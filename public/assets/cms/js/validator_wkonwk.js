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
        let customer_sku_code_response = await fetch(`${BASE_URL}cms/global_controller/get_valid_ba_data?customer_sku_code_lmi=1&customer_sku_code_rgdi=1&label_type=1&item_class=1`);   
        let sku_data = await customer_sku_code_response.json();

        sku_data.customer_sku_code_lmi.forEach(group => {
            customer_sku_code_lookup[group.cusitmcde.toLowerCase()] = group.recid;
        });

        sku_data.customer_sku_code_rgdi.forEach(group => {
            customer_sku_code_lookup[group.cusitmcde.toLowerCase()] = group.recid;
        });

        let label_type_lookup = {};
        sku_data.label_type.forEach(group => label_type_lookup[group.label.toLowerCase()] = group.id);  

        let item_class_lookup = {};
        sku_data.item_class.forEach(group => item_class_lookup[group.item_class_description.toLowerCase()] = group.id);  

        function processBatch() {
            if (index >= data.length) {
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
                let soh = row["soh"];
                let ave_weekly_sales = row["ave_weekly_sales"];
                let weeks_cover = row["weeks_cover"];
                let tr_count = index + 1;

                if (isNaN(quantity)) {
                    addErrorLog(`Invalid Quantity: "${quantity}" is not a number`);
                    continue;
                }

                if (soh !== null && soh !== undefined && soh !== '') {
                    if (!Number.isInteger(Number(soh))) {
                        addErrorLog(`Invalid SOH: "${soh}" must be a whole number`);
                        continue;
                    } else {
                        soh = parseInt(soh);
                    }
                }

                if (ave_weekly_sales !== null && ave_weekly_sales !== undefined && ave_weekly_sales !== '') {
                    let num = Number(ave_weekly_sales);
                    if (isNaN(num)) {
                        addErrorLog(`Invalid Ave Weekly Sales: "${ave_weekly_sales}" is not a number`);
                        continue;
                    } else {
                        ave_weekly_sales = parseFloat(num.toFixed(2));
                    }
                }

                if (weeks_cover !== null && weeks_cover !== undefined && weeks_cover !== '') {
                    let num = Number(weeks_cover);
                    if (isNaN(num)) {
                        addErrorLog(`Invalid Weeks Cover: "${weeks_cover}" is not a number`);
                        continue;
                    } else {
                        weeks_cover = parseFloat(num.toFixed(2));
                    }
                }

                let item_key = item.trim().toLowerCase();
                if (!(item_key in customer_sku_code_lookup)) {
                    addErrorLog(`Invalid SKU Code: ${item}`);
                    continue;
                }

                label_type = label_type_lookup[label_type.trim().toLowerCase()] || addErrorLog("Invalid Label Code: " + label_type);
                item_class = item_class_lookup[item_class.trim().toLowerCase()] || addErrorLog("Invalid Item Class: " + item_class);

                valid_data.push({
                    file_name, line_number, item, item_name, label_type, status, item_class, pog_store, quantity, soh, ave_weekly_sales, weeks_cover
                });
            }

            if (index % 100000 === 0) {
                self.postMessage({ progress: Math.round((index / data.length) * 100), err_counter });
            }

            setTimeout(processBatch, 0);
        }

        function addErrorLog(message) {
            invalid = true;
            err_counter++;
            if (errorLogs.length < ERROR_LOG_LIMIT) {
                errorLogs.push(`⚠️ ${message} at line #: ${index + 1}`);
            }
        }

        processBatch();
    }
    catch (error) {
        self.postMessage({ invalid: true, errorLogs: [`Validation failed: ${error.message}`], err_counter: 1 });
    }
}