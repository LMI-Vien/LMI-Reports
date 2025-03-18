self.onmessage = async function(e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let invalid = false;
    let errorLogs = [];
    let unique_code = new Set();
    let unique_description = new Set();
    let valid_data = [];
    var err_counter = 0;
    var store_per_area = {};

    try {
        let get_ba_valid_response = await fetch(`${BASE_URL}cms/global_controller/get_valid_ba_data?stores=1`);   
        let ba_data = await get_ba_valid_response.json();

        store_records = ba_data.stores;
        let store_lookup = {};
        store_records.forEach(store => store_lookup[store.description] = store.id);

        function formatDateForDB(dateStr) {
            let [month, day, year] = dateStr.split('/');
            return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
        }
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

                let code = row["Area Code"] ? row["Area Code"].trim() : "";
                let description = row["Area Description"] ? row["Area Description"].trim() : "";
                let status = row["Status"] ? row["Status"].toLowerCase() : "";
                let stores = row["Stores"] ? row["Stores"] : "";
                let user_id = row["Created By"] ? row["Created By"].trim() : "";
                let date_of_creation = row["Created Date"] ? row["Created Date"].trim() : "";
                let invalid_store = false; 

                if (unique_code.has(code)) {
                    invalid = true;
                    errorLogs.push(`⚠️ Duplicated Code at line #: ${tr_count}`);
                    err_counter++;
                } else if (code.length > 25 || code === "") {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Code at line #: ${tr_count}`);
                    err_counter++;
                } else {
                    if (!store_per_area[code]) {
                        store_per_area[code] = []; 
                    }

                    let normalized_store_lookup = {};

                    for (let key in store_lookup) {
                        normalized_store_lookup[key.toLowerCase()] = store_lookup[key];
                    }
                    
                    for (i = 0; i < stores.length; ++i) {
                        let store_lower = stores[i].toLowerCase();
                        if (store_lower in normalized_store_lookup) {
                            let store_id = normalized_store_lookup[store_lower];
                            if (!store_per_area[code].includes(store_id)) {
                                store_per_area[code].push(store_id);
                            }
                        } else {
                            if (!invalid_store) {
                                    invalid = true;
                                    invalid_store = true;
                                    errorLogs.push(`⚠️ Invalid Store at line #: ${tr_count}`);
                                err_counter++;
                            }
                        }
                    }

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
                //  else {
                //     unique_description.add(description);
                // }

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
            }

            setTimeout(processBatch, 0);
        }

        processBatch();
    }catch (error) {
        self.postMessage({ invalid: true, errorLogs: [`Validation failed: ${error.message}`], err_counter: 1 });
    }
};