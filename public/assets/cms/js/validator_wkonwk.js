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
        let customer_sku_code_lookup = {};

        let customer_sku_code_response = await Promise.all([
            fetch(`${BASE_URL}cms/global_controller/get_valid_ba_data?customer_sku_code_lmi=1`),
            fetch(`${BASE_URL}cms/global_controller/get_valid_ba_data?customer_sku_code_rgdi=1`)
        ]);

        let [customer_sku_code_data_lmi, customer_sku_code_data_rgdi] = await Promise.all(
            customer_sku_code_response.map(response => response.json())
        );

        customer_sku_code_data_lmi.customer_sku_code_lmi.forEach(group => {
            customer_sku_code_lookup[group.cusitmcde.toLowerCase()] = group.recid;
        });

        customer_sku_code_data_rgdi.customer_sku_code_rgdi.forEach(group => {
            customer_sku_code_lookup[group.cusitmcde.toLowerCase()] = group.recid;
        });

        let label_type = await fetch(`${BASE_URL}cms/global_controller/get_valid_ba_data?label_type=1`);
        let label_type_data = await label_type.json();
        let label_type_lookup = {};
        label_type_data.label_type.forEach(group => label_type_lookup[group.label.toLowerCase()] = group.id);  

        let item_class = await fetch(`${BASE_URL}cms/global_controller/get_valid_ba_data?item_class=1`);
        let item_class_data = await item_class.json();
        let item_class_lookup = {};
        item_class_data.item_class.forEach(group => item_class_lookup[group.item_class_description.toLowerCase()] = group.id);  

        function processBatch() {
            if (index >= data.length) {
                // Final message with results
                self.postMessage({ invalid, errorLogs, valid_data, err_counter });
                return;
            }
    
            for (let i = 0; i < BATCH_SIZE && index < data.length; i++, index++) {
                let row = data[index];
                let file_name = row["file_name"];
                let line_number = row["line_number"];
                let item = row["item"];
                let item_name = row["item_name"];
                let label_type = row["label_type"];
                let status = row["status"];
                let item_class = row["item_class"];
                let pog_store = row["pog_store"];
                let quantity = row["quantity"];
                let tr_count = index + 1;

                if (isNaN(quantity)) {
                    addErrorLog(`Invalid quantity: "${quantity}" is not a number`);
                    continue;
                }
                item_name = customer_sku_code_lookup[item_name.toLowerCase()] || addErrorLog("Invalid SKU Code");
                label_type =  label_type_lookup[label_type.toLowerCase()] || addErrorLog("Invalid Label Code");
                item_class = item_class_lookup[item_class.toLowerCase()] || addErrorLog("Invalid Item Class");
    
                function addErrorLog(message) {
                    invalid = true;
                    err_counter++;
                    if (errorLogs.length < ERROR_LOG_LIMIT) {
                        errorLogs.push(`⚠️ ${message} at line #: ${tr_count}`);
                    }
                }
    
                valid_data.push({
                    file_name, line_number, item, item_name, label_type, status, item_class, pog_store, quantity
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