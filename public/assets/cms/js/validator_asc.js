self.onmessage = async function(e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let invalid = false;
    let errorLogs = [];
    let unique_code = new Set();
    let unique_description = new Set();
    let valid_data = [];
    var err_counter = 0;

    try {
        let get_ba_valid_response = await fetch(`${BASE_URL}cms/brand-ambassador/get_valid_ba_data`);   
        let ba_data = await get_ba_valid_response.json();

        area_records = ba_data.areas;
        let area_lookup = {};
        area_records.forEach(area => area_lookup[area.description] = area.id);

        function formatDateForDB(dateStr) {
            let [month, day, year] = dateStr.split('/');
            return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
        }

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
                let user_id = row["Created By"] ? row["Created By"].trim() : "";
                let area_id = row["Area"] ? row["Area"].trim() : "";
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
                    errorLogs.push(`⚠️ Duplicated Name at line #: ${tr_count}`);
                    err_counter++;
                } else if (description.length > 50 || description === "") {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Name at line #: ${tr_count}`);
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

                let normalized_area_lookup = {};
                for (let key in area_lookup) {
                    normalized_area_lookup[key.toLowerCase()] = area_lookup[key];
                }

                let area_lower = area_id.toLowerCase();
                if (area_lower in normalized_area_lookup) {
                    area_id = normalized_area_lookup[area_lower];
                }else {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Area at line #: ${tr_count}`);
                    err_counter++;
                }

                if (deployment_date) {
                    deployment_date = formatDateForDB(deployment_date);
                }

                if (!invalid) {
                    valid_data.push({
                        code: code,
                        description: description,
                        status: status === "active" ? 1 : 0,
                        deployment_date: deployment_date,
                        area_id: area_id,
                        created_by: user_id,
                        created_date: date_of_creation
                    });
                }
            }
            setTimeout(processBatch, 0);
        }

            processBatch();
        }catch (error) {
        self.postMessage({ invalid: true, errorLogs: [`Validation failed: ${error.message}`], err_counter: 1 });
    }
};