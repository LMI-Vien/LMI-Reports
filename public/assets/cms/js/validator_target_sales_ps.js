self.onmessage = async function(e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let invalid = false;
    let errorLogs = [];
    let valid_data = [];
    let err_counter = 0;
    const ERROR_LOG_LIMIT = 1000; // Reduce error log limit
    const BATCH_SIZE = 2000; // Reduce batch size

    try {
        let get_tsp_valid_response = await fetch(`${BASE_URL}cms/global_controller/get_valid_ba_data?stores=1&ba=1&ba_area_store_brand=1`);
        let fetch_data = await get_tsp_valid_response.json();

        let store_lookup = createLookup(fetch_data.stores, "code", "code");

        ba_records = fetch_data.ba;
        let ba_lookup = {
            "vacant": -5,
            "non ba": -6
        };
        ba_records.forEach(ba => ba_lookup[ba.code] = ba.id);

        let ba_checklist = {};
        fetch_data.ba_area_store_brand.forEach(entry => {
            let ba_codes = entry.brand_ambassador_code ? entry.brand_ambassador_code.split(',').map(b => b.trim()) : [null];
            let ba_ids = entry.brand_ambassador_id ? entry.brand_ambassador_id.split(',').map(id => id.trim()) : [null];
            let store_codes = entry.store_code ? entry.store_code.split(',').map(s => s.trim()) : [];
            let store_ids = entry.store_id ? entry.store_id.split(',').map(id => id.trim()) : [];
            let brand_ids = entry.brand_id ? entry.brand_id.split(',').map(id => id.trim()) : [];

            store_codes.forEach((store_code, store_idx) => {
                if (!ba_checklist[store_code.toLowerCase()]) {
                    ba_checklist[store_code.toLowerCase()] = {
                        area_code: entry.area_code,
                        store_code: store_code,
                        ba_code: ba_codes[0] || "",
                        area_id: entry.area_id,
                        asc_id: entry.asc_id || null,
                        store_id: store_ids[store_idx] || null,
                        ba_id: ba_ids.join(',') || null,
                        brand_ids: brand_ids.join(','),
                        brand_names: entry.brand_name ? entry.brand_name.split(',').map(name => name.trim().toLowerCase()) : []
                    };
                }
            });
        });

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
    
            for (let i = 0; i < BATCH_SIZE && index < data.length; i++, index++) {
                let row = data[index];
                let tr_count = index + 1;
                let ba_code = row["BA Code"] ? row["BA Code"].trim() : "";
                let location = row["Location"] ? row["Location"].trim() : "";
                let user_id = row["Created by"] ? row["Created by"].trim() : "";
                let date_of_creation = row["Created Date"] ? row["Created Date"].trim() : "";
    
                function addErrorLog(message) {
                    invalid = true;
                    err_counter++;
                    if (errorLogs.length < ERROR_LOG_LIMIT) {
                        errorLogs.push(`⚠️ ${message} at line #: ${tr_count}`);
                    }
                }
    
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

                if (ba_code) {
                    let ba_lower = ba_code.toLowerCase();
                    ba = ba_lookup[ba_lower] || null;
                    if (!ba && ba !== 0) {
                        invalid = true;
                        errorLogs.push(`⚠️ Invalid Brand Ambassador Code at line #: ${tr_count}`);
                        err_counter++;
                    }
                }

                // let ba_lower = ba_code.toLowerCase();
                // if (ba_lower in normalized_ba_lookup) {
                // }else {
                //     invalid = true;
                //     errorLogs.push(`⚠️ Invalid Brand Ambassador Code at line #: ${tr_count}`);
                //     err_counter++;
                // }

                // let matched = ba_checklist[location.toLowerCase()];
                // if (!matched?.location) addErrorLog("Invalid BA not tagged to any store");

                // get the normalized store code & BA ID
                const storeKey = row["Location"].trim().toLowerCase();
                const thisBaId = ba_lookup[ row["BA Code"].trim().toLowerCase() ];

                const matched = ba_checklist[storeKey];
                let ba_trimmed = ba_code.trim().toLowerCase();

                if (ba_trimmed === "vacant") {
                    ba_code = -5;
                } else if (ba_trimmed === "non ba") {
                    ba_code = -6;
                }
                if (!invalid) {
                    valid_data.push({
                        ba_code: ba_code,
                        location: matched?.store_code || null,
                        ...monthlyValues,
                        status: 2,
                        created_by: user_id,
                        created_date: date_of_creation,
                        area_id: matched?.area_id || null,
                        asc_id: matched?.asc_id || null,
                        brand_ids: matched?.brand_ids || []
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
