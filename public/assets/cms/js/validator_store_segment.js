self.onmessage = async function(e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let invalid = false;
    let errorLogs = [];
    let unique_segment_description = new Set();
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
            let segment_description = row["Segment Description"] ? row["Segment Description"].trim() : "";
            let status = row["Status"] ? row["Status"].toLowerCase() : "";
            let user_id = row["Created by"] ? row["Created by"].trim() : "";
            let date_of_creation = row["Created Date"] ? row["Created Date"].trim() : "";

            if (unique_segment_description.has(segment_description)) {
                invalid = true;
                errorLogs.push(`⚠️ Duplicated Segment at line #: ${tr_count}`);
                err_counter++;
            }else if (segment_description.length > 50 || segment_description === "") {
                invalid = true;
                errorLogs.push(`⚠️ Invalid Segment Description at line #: ${tr_count}`);
                err_counter++;
            } else {
                unique_segment_description.add(segment_description);
            }

            if (!["active", "inactive"].includes(status)) {
                invalid = true;
                errorLogs.push(`⚠️ Invalid Status at line #: ${tr_count}`);
                err_counter++;
            }

            if (!invalid) {
                valid_data.push({
                    description: segment_description,
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