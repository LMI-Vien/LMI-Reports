self.onmessage = async function(e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let invalid = false;
    let errorLogs = [];
    let unique_code = new Set();
    let unique_description = new Set();
    let valid_data = [];
    var err_counter = 0;

    // Process in smaller batches to avoid memory issues
    let batchSize = 2000;
    let index = 0;

    function processBatch() {
        if (index >= data.length) {
            self.postMessage({ invalid, errorLogs, valid_data, err_counter });
            return;
        }

        for (let i = 0; i < batchSize && index < data.length; i++, index++) {
            let row = data[index];
            let tr_count = index + 1;
            let code = row["Code"] ? row["Code"].trim() : "";
            let description = row["Name"] ? row["Name"].trim() : "";
            let status = row["Status"] ? row["Status"].toLowerCase() : "";
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

            // if (unique_description.has(description)) {
            //     invalid = true;
            //     errorLogs.push(`⚠️ Duplicated Description at line #: ${tr_count}`);
            //     err_counter++;
            // } else 
            if (description.length > 50 || description === "") {
                invalid = true;
                errorLogs.push(`⚠️ Invalid Description at line #: ${tr_count}`);
                err_counter++;
            }

            if (!["active", "inactive"].includes(status)) {
                invalid = true;
                errorLogs.push(`⚠️ Invalid Status at line #: ${tr_count}`);
                err_counter++;
            }

            if (!invalid) {
                valid_data.push({
                    code: code,
                    description: description,
                    status: status === "active" ? 1 : 0,
                    created_by: user_id,
                    created_date: date_of_creation
                });
            }
        }

        setTimeout(processBatch, 0);
    }

    processBatch();
};