self.onmessage = async function(e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let invalid = false;
    let errorLogs = [];
    let unique_label_cat_code = new Set();
    let unique_label_cat_description = new Set();
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
            let labelCategoryCode = row["Label Category Code"] ? row["Label Category Code"].trim() : "";
            let labelCategoryDesc = row["Label Category Description"] ? row["Label Category Description"].trim() : "";
            let status = row["Status"] ? row["Status"].toLowerCase() : "";
            let user_id = row["Created by"] ? row["Created by"].trim() : "";
            let date_of_creation = row["Created Date"] ? row["Created Date"].trim() : "";

            if (unique_label_cat_code.has(labelCategoryCode)) {
                invalid = true;
                errorLogs.push(`⚠️ Duplicated Label Category Code at line #: ${tr_count}`);
                err_counter++;
            }else if (labelCategoryCode.length > 25 || labelCategoryCode === "") {
                invalid = true;
                errorLogs.push(`⚠️ Invalid Label Category Code at line #: ${tr_count}`);
                err_counter++;
            } else {
                unique_label_cat_code.add(labelCategoryCode);
            }

            if (unique_label_cat_description.has(labelCategoryDesc)) {
                invalid = true;
                errorLogs.push(`⚠️ Duplicated Label Category Description at line #: ${tr_count}`);
                err_counter++;
            }else if (labelCategoryDesc.length > 50 || labelCategoryDesc === "") {
                invalid = true;
                errorLogs.push(`⚠️ Invalid Label Category Description at line #: ${tr_count}`);
                err_counter++;
            } else {
                unique_label_cat_code.add(labelCategoryCode);
            }

            if (!["active", "inactive"].includes(status)) {
                invalid = true;
                errorLogs.push(`⚠️ Invalid Status at line #: ${tr_count}`);
                err_counter++;
            }

            if (!invalid) {
                valid_data.push({
                    code: labelCategoryCode,
                    description: labelCategoryDesc,
                    status: status === "active" ? 1 : 0,
                    created_date: date_of_creation,
                    created_by : user_id
                });
            }
        }

        setTimeout(processBatch, 0);
    }

    processBatch();
}