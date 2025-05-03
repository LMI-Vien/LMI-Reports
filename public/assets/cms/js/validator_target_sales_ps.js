self.onmessage = async function(e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let invalid = false;
    let errorLogs = [];
    let valid_data = [];
    let err_counter = 0;

    try {
        let get_tsp_valid_response = await fetch(`${BASE_URL}cms/global_controller/get_valid_ba_data?stores=1&ba=1`);
        let fetch_data = await get_tsp_valid_response.json();

        let store_lookup = createLookup(fetch_data.stores, "code", "code");

        ba_records = fetch_data.ba;
        let ba_lookup = {};
        ba_records.forEach(ba => ba_lookup[ba.code] = ba.id);

        function createLookup(records, key1, key2) {
            let lookup = {};
            records.forEach(record => {
                lookup[record[key1].toLowerCase()] = record.id;
                lookup[record[key2].toLowerCase()] = record.id;
            });
            return lookup;
        }

        function isValidFloat(value) {
            return value !== "" && !isNaN(value) && !isNaN(parseFloat(value));
        }

        function validateFloatField(value, fieldName, tr_count) {
            if (!isValidFloat(value)) {
                invalid = true;
                errorLogs.push(`⚠️ Invalid ${fieldName} at line #: ${tr_count}`);
                err_counter++;
            } else {
                let num = parseFloat(value);
                if (num.toString().includes(".")) {
                    let decimalPlaces = num.toString().split(".")[1].length;
                    if (decimalPlaces > 2) {
                        num = parseFloat(num.toFixed(2));
                    }
                }
                return num;
            }
            return null;
        }

        function getMonthlyValues(row) {
            const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            let values = {};

            months.forEach(month => {
                let key = month;
                let value = row[key]?.replace(/,/g, "").trim() || "";
                values[key.toLowerCase()] = value;
            });

            return values;
        }

        let batchSize = 2000;
        let index = 0;

        function processBatch() {
            if (index >= data.length) {
                // Final message with results
                self.postMessage({ invalid, errorLogs, valid_data, err_counter });
                return;
            }

            // let progress = Math.round((index / data.length) * 100);
            // self.postMessage({ progress });
    
            for (let i = 0; i < batchSize && index < data.length; i++, index++) {
                let row = data[index];
                let tr_count = index + 1;
                let ba_code = row["BA Code"] ? row["BA Code"].trim() : "";
                let location = row["Location"] ? row["Location"].trim() : "";
                let user_id = row["Created by"] ? row["Created by"].trim() : "";
                let date_of_creation = row["Created Date"] ? row["Created Date"].trim() : "";
    
                if (location.length > 25 || location === "") {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Location at line #: ${tr_count}`);
                    err_counter++;
                }

                if (ba_code.length > 25 || ba_code === "") {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid BA Code at line #: ${tr_count}`);
                    err_counter++;
                }

                let monthlyValues = getMonthlyValues(row);
                Object.entries(monthlyValues).forEach(([key, value]) => {
                    if (value) monthlyValues[key] = validateFloatField(value, key, tr_count);
                });
    
                let normalized_store_lookup = {};
                for (let key in store_lookup) {
                    normalized_store_lookup[key.toLowerCase()] = store_lookup[key];
                }
    
                let area_lower = location.toLowerCase();
                if (area_lower in normalized_store_lookup) {
                    location = normalized_store_lookup[area_lower];
                } else {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Store at line #: ${tr_count}`);
                    err_counter++;
                }

                let normalized_ba_lookup = {};
                for (let key in ba_lookup) {
                    normalized_ba_lookup[key.toLowerCase()] = ba_lookup[key];
                }

                let ba_lower = ba_code.toLowerCase();
                if (ba_lower in normalized_ba_lookup) {
                    //ba_code = normalized_ba_lookup[ba_lower];
                }else {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Brand Ambassador Code at line #: ${tr_count}`);
                    err_counter++;
                }
    
                if (!invalid) {
                    valid_data.push({
                        ba_code,
                        location,
                        ...monthlyValues,
                        status: 3,
                        created_by: user_id,
                        created_date: date_of_creation
                    });
                }
            }

            if (index % 100000 === 0) {
                self.postMessage({ progress: Math.round((index / data.length) * 100), err_counter });
            }

            setTimeout(processBatch, 0);
        }

        processBatch();
    } catch (error) {
        self.postMessage({ invalid: true, errorLogs: [`Validation failed: ${error.message}`], err_counter: 1 });
    }
};
