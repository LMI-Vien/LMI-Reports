self.onmessage = async function(e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let invalid = false;
    let errorLogs = [];
    let unique_description = new Set();
    let valid_data = [];
    var err_counter = 0;

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
            let description = row["Description"] ? row["Description"].trim() : "";
            let remarks = row["Remarks"] ? row["Remarks"].trim() : "";
            let status = row["Status"] ? row["Status"].toLowerCase() : "";
            let user_id = row["Created by"] ? row["Created by"].trim() : "";
            let date_of_creation = row["Created Date"] ? row["Created Date"].trim() : "";

            if (unique_description.has(description)) { 
                invalid = true;
                errorLogs.push(`⚠️ Duplicated Description at line #: ${tr_count}`);
                err_counter++;
            } else if (description.length > 50 || description === "") {
                invalid = true;
                errorLogs.push(`⚠️ Invalid Descritpion at line #: ${tr_count}`);
                err_counter++;
            } else {
                unique_description.add(description);
            }

            if (remarks.length > 50 || remarks === "") {
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
                    description: description,
                    remarks: remarks,
                    status: status === "active" ? 1 : 0,
                    created_date: date_of_creation,
                    created_by : user_id
                });
            }
        }
        setTimeout(processBatch, 0);
    }

    processBatch();
};