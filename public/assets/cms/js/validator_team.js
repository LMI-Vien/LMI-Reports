self.onmessage = async function(e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let invalid = false;
    let errorLogs = [];
    let unique_code = new Set();
    let unique_team_description = new Set();
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
            let code = row["Team Code"] ? row["Team Code"].trim() : "";
            let team_description = row["Team Description"] ? row["Team Description"].trim() : "";
            let status = row["Status"] ? row["Status"].toLowerCase() : "";
            let user_id = row["Created by"] ? row["Created by"].trim() : "";
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

            // if (unique_team_description.has(team_description)) {
            //     invalid = true;
            //     errorLogs.push(`⚠️ Duplicated Team Description at line #: ${tr_count}`);
            //     err_counter++;
            // } else 
            if (team_description.length > 50 || team_description === "") {
                invalid = true;
                errorLogs.push(`⚠️ Invalid Team Description at line #: ${tr_count}`);
                err_counter++;
            }
            //  else {
            //     unique_team_description.add(team_description);
            // }

            if (!["active", "inactive"].includes(status)) {
                invalid = true;
                errorLogs.push(`⚠️ Invalid Status at line #: ${tr_count}`);
                err_counter++;
            }


            if (!invalid) {
                valid_data.push({
                    code: code,
                    team_description: team_description,
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