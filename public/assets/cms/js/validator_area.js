self.onmessage = function(e) {
    let data = e.data;
    let invalid = false;
    let errorLogs = [];
    let unique_code = new Set();
    let unique_description = new Set();
    let valid_data = [];
    let store_per_area = [];
    var err_counter = 0;

    // Process in smaller batches to avoid memory issues
    let batchSize = 2000;
    let index = 0;

    function processBatch() {
        if (index >= data.length) {
            self.postMessage({ invalid, errorLogs, valid_data, err_counter, store_per_area });
            return;
        }

        for (let i = 0; i < batchSize && index < data.length; i++, index++) {
            let row = data[index];
            let tr_count = index + 1;

            let code = row["Code"] ? row["Code"].trim() : "";
            let description = row["Name"] ? row["Name"].trim() : "";
            let status = row["Status"] ? row["Status"].toLowerCase() : "";
            let stores = row["Stores"] ? row["Stores"] : "";
            let user_id = row["Created By"] ? row["Created By"].trim() : "";
            let date_of_creation = row["Created Date"] ? row["Created Date"].trim() : "";

            if (unique_code.has(code)) {
                invalid = true;
                errorLogs.push(`⚠️ Duplicated Code at line #: ${tr_count}`);
                err_counter++;
            } else if (code.length > 25 || code === "") {
                invalid = true;
                errorLogs.push(`⚠️ Invalid Code at line #: ${tr_count}`);
                err_counter++;
            } else {
                unique_code.add(code);
            }

            if (unique_description.has(description)) {
                invalid = true;
                errorLogs.push(`⚠️ Duplicated Description at line #: ${tr_count}`);
                err_counter++;
            } else if (description.length > 50 || description === "") {
                invalid = true;
                errorLogs.push(`⚠️ Invalid Description at line #: ${tr_count}`);
                err_counter++;
            } else {
                unique_description.add(description);
            }

            if (!["active", "inactive"].includes(status)) {
                invalid = true;
                errorLogs.push(`⚠️ Invalid Status at line #: ${tr_count}`);
                err_counter++;
            }

            if (!invalid) {
                if (!valid_data.some(item => item.code === code)) {
                    valid_data.push({
                        code: code,
                        description: description,
                        status: status === "active" ? 1 : 0,
                        created_by: user_id,
                        created_date: date_of_creation
                    });
                }                
            }

            if (!store_per_area[code]) {
                store_per_area[code] = [];
            }

            if (!store_per_area[code].includes(stores)) {
                store_per_area[code].push(stores);
            }
        }

        setTimeout(processBatch, 0);
    }

    processBatch();
};