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


    try {
        let get_ba_valid_response = await fetch(`${BASE_URL}cms/global_controller/get_valid_ba_data?payment_group_lmi=1`);
        let ba_data = await get_ba_valid_response.json();

        let payment_group_records = ba_data.payment_group_lmi;
        let payment_group_lookup = {};
        payment_group_records.forEach(groupCode => payment_group_lookup[groupCode.customer_group_code] = groupCode.id);


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


                let normalized_payment_group_lookup = {};
                for (let key in payment_group_lookup) {
                    normalized_payment_group_lookup[key.toLowerCase()] = payment_group_lookup[key];
                }

                let payment_group_lower = description.toLowerCase();
                let description_id = null; 
                let original_description = description;
                if (payment_group_lower in normalized_payment_group_lookup) {
                   description_id = normalized_payment_group_lookup[payment_group_lower];
                   description = description_id;
                } else {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Description at line #: ${tr_count}`);
                    err_counter++;
                }

                if (unique_description.has(description)) { 
                    invalid = true;
                    errorLogs.push(`⚠️ Duplicated Description at line #: ${tr_count}`);
                    err_counter++;
                } else if (original_description.length > 50 || original_description === "") {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Desription at line #: ${tr_count}`);
                    err_counter++;
                } else {
                    unique_description.add(description);
                }

                if (remarks.length > 50 || remarks === "") {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Remarks at line #: ${tr_count}`);
                    err_counter++;
                }

                if (!["active", "inactive"].includes(status)) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Status at line #: ${tr_count}`);
                    err_counter++;
                }

                if (!invalid) {
                    valid_data.push({
                        description_id: description_id,
                        description: original_description,
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
    } catch (error) {
        self.postMessage({ invalid: true, errorLogs: [`Validation failed: ${error.message}`], err_counter: 1 });
    }
};