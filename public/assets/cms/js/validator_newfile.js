self.onmessage = async function(e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;

    let invalid = false;
    let errorLogs = [];
    let valid_data = [];
    let err_counter = 0;
    const ERROR_LOG_LIMIT = 1000; // Reduce error log limit
    const BATCH_SIZE = 1000; // Reduce batch size
    let index = 0;

    try {
        let get_ba_valid_response = await fetch(`${BASE_URL}cms/global_controller/get_valid_ba_data?payment_group=1`);   
        let ba_data = await get_ba_valid_response.json();

        let cusgrp_lookup = {};
        ba_data.payment_group.forEach(group => cusgrp_lookup[group.customer_group_code.toLowerCase()] = group.id);

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
    
                customer_payment_group = cusgrp_lookup[customer_payment_group.toLowerCase()] || addErrorLog("Invalid Payment Group");
    
                valid_data.push({
                    data_header_id, month, year, customer_payment_group, template_id, file_name,
                    line_number, store_code, store_description, sku_code, sku_description, quantity, net_sales, gross_sales
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