self.onmessage = async function(e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let companyString = e.data.companyString;

    let invalid = false;
    let errorLogs = [];
    let valid_data = [];
    let err_counter = 0;
    const ERROR_LOG_LIMIT = 1000; // Reduce error log limit
    const BATCH_SIZE = 2500; // Reduce batch size
    let index = 0;

    try {
        let get_ba_valid_response = await fetch(`${BASE_URL}cms/global_controller/get_valid_ba_data?payment_group_lmi=1&payment_group_rgdi=1&customer_sku_code_lmi=1&customer_sku_code_rgdi=1&ba_area_store_brand=1`);   
        let con_data = await get_ba_valid_response.json();

        let cusgrp_lookup_lmi = {};
        con_data.payment_group_lmi.forEach(group => cusgrp_lookup_lmi[group.customer_group_code.toLowerCase()] = group.id);

        let cusgrp_lookup_rgdi = {};
        con_data.payment_group_rgdi.forEach(group => cusgrp_lookup_rgdi[group.customer_group_code.toLowerCase()] = group.id);

        let customer_sku_code_lookup_lmi = {};
        con_data.customer_sku_code_lmi.forEach(group => customer_sku_code_lookup_lmi[group.cusitmcde.toLowerCase()] = group.recid);        

        let customer_sku_code_lookup_rgdi = {};
        con_data.customer_sku_code_rgdi.forEach(group => customer_sku_code_lookup_rgdi[group.cusitmcde.toLowerCase()] = group.recid); 

        let ba_checklist = {};
        con_data.ba_area_store_brand.forEach(entry => {
            let ba_codes = entry.brand_ambassador_cod ? entry.brand_ambassador_code.split(',').map(b => b.trim()) : [null];
            let ba_ids = entry.brand_ambassador_id ? entry.brand_ambassador_id.split(',').map(id => id.trim()) : [null];
            let store_codes = entry.store_code ? entry.store_code.split(',').map(s => s.trim()) : [];
            let store_ids = entry.store_id ? entry.store_id.split(',').map(id => id.trim()) : [];
            let brand_ids = entry.brand_id ? entry.brand_id.split(',').map(id => id.trim()) : [];

            store_codes.forEach((store_code, store_idx) => {
                if (!ba_checklist[store_code.toLowerCase()]) {
                    ba_checklist[store_code.toLowerCase()] = {
                        area_code: entry.area_code,
                        store_code: store_code,
                        ba_code: ba_codes[0] || "",
                        area_id: entry.area_id,
                        asc_id: entry.asc_id || null,
                        store_id: store_ids[store_idx] || null,
                        ba_id: ba_ids.join(',') || null,
                        brand_ids: brand_ids.join(','),
                        brand_names: entry.brand_name ? entry.brand_name.split(',').map(name => name.trim().toLowerCase()) : []
                    };
                }
            });
        });


        function processBatch() {
            if (index >= data.length) {
                // Final message with results
                self.postMessage({ invalid, errorLogs, valid_data, err_counter });
                return;
            }
    
            for (let i = 0; i < BATCH_SIZE && index < data.length; i++, index++) {
                let row = data[index];
                let data_header_id = row["data_header_id"];
                let month = row["month"];
                let year = row["year"];
                let customer_payment_group = row["customer_payment_group"]?.trim() || "";
                let template_id = row["template_id"];
                let file_name = row["file_name"];
                let line_number = row["line_number"];
                let store_code = row["store_code"];
                let store_description = row["store_description"];
                let sku_code = row["sku_code"];
                let sku_description = row["sku_description"];
                let quantity = row["quantity"];
                let net_sales = row["net_sales"];
                let gross_sales = row["gross_sales"];
                let tr_count = index + 1;
    
                function addErrorLog(message) {
                    invalid = true;
                    err_counter++;
                    if (errorLogs.length < ERROR_LOG_LIMIT) {
                        errorLogs.push(`⚠️ ${message} at line #: ${tr_count}`);
                    }
                }
                
                if (companyString == 'LMI') {
                    customer_payment_group = cusgrp_lookup_lmi[customer_payment_group.toLowerCase()] || addErrorLog("Invalid Payment Group (LMI)");
                    sku_code = customer_sku_code_lookup_lmi[sku_code.toLowerCase()] || addErrorLog("Invalid SKU Code (LMI)");
                } else {
                    customer_payment_group = cusgrp_lookup_rgdi[customer_payment_group.toLowerCase()] || addErrorLog("Invalid Payment Group (RGDI)");
                    sku_code = customer_sku_code_lookup_rgdi[sku_code.toLowerCase()] || addErrorLog("Invalid SKU Code (RGDI)");
                }

                let matched = ba_checklist[store_code.toLowerCase()];
                if (!matched?.store_id) addErrorLog("Invalid store not tagged to any area");

                valid_data.push({
                    data_header_id, month, year, customer_payment_group, template_id, file_name,
                    line_number, store_description, sku_code, sku_description, quantity, net_sales, gross_sales,
                    store_code: matched?.store_code || null,
                    area_id: matched?.area_id || null,
                    asc_id: matched?.asc_id || null,
                    brand_ids: matched?.brand_ids || [],
                    brand_ambassador_ids: matched?.ba_id || null
                })
            }
    
            if (index % 100000 === 0) {
                self.postMessage({ progress: Math.round((index / data.length) * 100), err_counter });
            }
    
            setTimeout(processBatch, 0);
        }

        processBatch();
    }
    catch (error) {
        self.postMessage({ invalid: true, errorLogs: [`Validation failed: ${error.message}`], err_counter: 1 });
    }
}