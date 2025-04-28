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