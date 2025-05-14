self.onmessage = async function(e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let companyString = e.data.companyString;

    let invalid = false;
    let errorLogs = [];
    let valid_data = [];
    let err_counter = 0;
    const ERROR_LOG_LIMIT = 1000;
    const BATCH_SIZE = 2500;
    let index = 0;

    try {
        let get_ba_valid_response = await fetch(`${BASE_URL}cms/global_controller/get_valid_ba_data?stores=1&payment_group_lmi=1&payment_group_rgdi=1&customer_sku_code_lmi=1&customer_sku_code_rgdi=1&ba_area_store_brand=1`);
        let con_data = await get_ba_valid_response.json();

        let store_lookup = {};
        con_data.stores.forEach(store => store_lookup[store.code.toLowerCase()] = store.id);

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
            let ba_codes = entry.brand_ambassador_code?.split(',').map(b => b.trim()) || [];
            let ba_ids = entry.brand_ambassador_id?.split(',').map(id => id.trim()) || [];
            let store_codes = entry.store_code?.split(',').map(s => s.trim()) || [];
            let store_ids = entry.store_id?.split(',').map(id => id.trim()) || [];
            let brand_ids = entry.brand_id?.split(',').map(id => id.trim()) || [];

            store_codes.forEach((store_code, store_idx) => {
                if (!ba_checklist[store_code.toLowerCase()]) {
                    ba_checklist[store_code.toLowerCase()] = {
                        area_code: entry.area_code || "0",
                        store_code: store_code,
                        ba_codes,
                        ba_ids,
                        area_id: entry.area_id || "0",
                        asc_id: entry.asc_id || null,
                        store_id: store_ids[store_idx] || null,
                        brand_ids
                    };
                }
            });
        });

        function processBatch() {
            if (index >= data.length) {
                self.postMessage({ invalid, errorLogs, valid_data, err_counter });
                return;
            }

            for (let i = 0; i < BATCH_SIZE && index < data.length; i++, index++) {
                let row = data[index];
                let {
                    data_header_id, month, year, template_id, file_name,
                    line_number, store_code, store_description,
                    sku_code, sku_description, quantity, net_sales, gross_sales
                } = row;
                let customer_payment_group = row["customer_payment_group"]?.trim() || "";
                let tr_count = index + 1;

                function addErrorLog(message) {
                    invalid = true;
                    err_counter++;
                    if (errorLogs.length < ERROR_LOG_LIMIT) {
                        errorLogs.push(`⚠️ ${message} at line #: ${tr_count}`);
                    }
                }

                if (companyString == 'LMI') {
                    if (!cusgrp_lookup_lmi[customer_payment_group.toLowerCase()]) {
                        addErrorLog("Invalid Payment Group (LMI)");
                    }
                    // Temporary override
                    sku_code = sku_code;
                } else {
                    if (!cusgrp_lookup_rgdi[customer_payment_group.toLowerCase()]) {
                        addErrorLog("Invalid Payment Group (RGDI)");
                    }
                    sku_code = sku_code;
                }

                let store = store_lookup[store_code.toLowerCase()];
                if (!store) addErrorLog("Invalid Store");

                let matched = ba_checklist[store_code?.toLowerCase()] || {};

                valid_data.push({
                    data_header_id, month, year, customer_payment_group, template_id, file_name,
                    line_number, store_description, sku_code, sku_description, quantity, net_sales, gross_sales,
                    store_code: matched?.store_code || 0,
                    area_id: matched?.area_id || 0,
                    asc_id: matched?.asc_id || 0,
                    brand_ids: (matched.brand_ids && matched.brand_ids.length) ? matched.brand_ids.join(',') : '',
                    brand_ambassador_ids: (matched.ba_ids && matched.ba_ids.length) ? matched.ba_ids.join(',') : '',
                });
            }

            if (index % 100000 === 0) {
                self.postMessage({ progress: Math.round((index / data.length) * 100), err_counter });
            }

            setTimeout(processBatch, 0);
        }

        processBatch();
    } catch (error) {
        self.postMessage({ invalid: true, errorLogs: [`Validation failed: ${error.message}`], err_counter: 1 });
    }
};
