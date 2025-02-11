self.onmessage = function(e) {
    let data = e.data;
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
            let deployment_date = row["Deployment Date"] ? row["Deployment Date"].trim() : "";
            let area_id = row["Area"] ? row["Area"].trim() : "";

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

            let dateObj = new Date(deployment_date);
            if (isNaN(dateObj.getTime())) {
                invalid = true;
                errorLogs.push(`⚠️ Invalid Deployment Date at line #: ${tr_count}`);
                err_counter++;
            }

            if (!invalid) {
                valid_data.push({
                    code: code,
                    description: description,
                    status: status === "active" ? 1 : 0,
                    deployment_date: deployment_date,
                    area_id: area_id
                });
            }
        }

        setTimeout(processBatch, 0);
    }

    processBatch();
};