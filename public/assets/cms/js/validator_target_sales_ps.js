self.onmessage = async function(e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let invalid = false;
    let unique_code = new Set();
    let errorLogs = [];
    let valid_data = [];
    let err_counter = 0;
    const ERROR_LOG_LIMIT = 1000; // Reduce error log limit
    const BATCH_SIZE = 2000; // Reduce batch size

    try {
        let get_tsp_valid_response = await fetch(`${BASE_URL}cms/global_controller/get_valid_ba_data?stores=1&ba=1&ba_area_store_brand=1`);
        let fetch_data = await get_tsp_valid_response.json();
        let ba_checklist = {};

        fetch_data.ba_area_store_brand.forEach(entry => {
            let ba_codes = entry.brand_ambassador_code?.split(',').map(b => b.trim()) || [];
            let ba_ids = entry.brand_ambassador_id?.split(',').map(id => id.trim()) || [];
            let store_codes = entry.store_code?.split(',').map(s => s.trim()) || [];
            let store_ids = entry.store_id?.split(',').map(id => id.trim()) || [];
            let brand_ids = entry.brand_id?.split(',').map(id => id.trim()) || [];

            store_codes.forEach((store_code, store_idx) => {
                if (!ba_checklist[store_code.toLowerCase()]) {
                    ba_checklist[store_code.toLowerCase()] = {
                        area_code: entry.area_code || "0",
                        store_code: store_code,
                        ba_codes,
                        ba_ids,
                        area_id: entry.area_id || "0",
                        asc_id: entry.asc_id || null,
                        store_id: store_ids[store_idx] || null,
                        brand_ids
                    };
                }
            });
        });

        let store_lookup = createLookup(fetch_data.stores, "code", "code");

        ba_records = fetch_data.ba;
        let ba_lookup = {
            "vacant": -5,
            "non ba": -6
        };
        //ba_records.forEach(ba => ba_lookup[ba.code] = ba.id);
        ba_records.forEach(ba => {
            ba_lookup[ba.code.toLowerCase()] = { id: ba.id, type: ba.type }; // assuming 'type' is the ba_types field
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
                let normalized_store_lookup = {};
                for (let key in store_lookup) {
                    normalized_store_lookup[key.toLowerCase()] = store_lookup[key];
                }
                let row = data[index];
                let tr_count = index + 1;
                let ba_code_raw = row["BA Code"] ? row["BA Code"].trim() : "";
                let ba_codes = ba_code_raw.split(',').map(c => c.trim().toLowerCase()).filter(c => c);
                let resolved_ba_ids = [];
                let resolved_ba_code_str = [];
                let ba_types_found = new Set();
                let has_invalid_ba = false;
                let store_code_raw = row["Store Code"] ? row["Store Code"].trim() : "";
                let store_code_lower = store_code_raw.toLowerCase();
                let store_code_id = normalized_store_lookup[store_code_lower];
                let user_id = row["Created by"] ? row["Created by"].trim() : "";
                let date_of_creation = row["Created Date"] ? row["Created Date"].trim() : "";
    
                function addErrorLog(message) {
                    invalid = true;
                    err_counter++;
                    if (errorLogs.length < ERROR_LOG_LIMIT) {
                        errorLogs.push(`⚠️ ${message} at line #: ${tr_count}`);
                    }
                }

                if (unique_code.has(store_code_lower)) {
                    invalid = true;
                    errorLogs.push(`⚠️ Duplicated Store Code at line #: ${tr_count}`);
                    err_counter++;
                } else if (store_code_lower.length > 25 || store_code_lower === "") {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Store Code at line #: ${tr_count}`);
                    err_counter++;
                } else {
                    unique_code.add(store_code_lower);
                }

                // ba_codes.forEach(code => {
                //     if (code === "vacant") {
                //         resolved_ba_ids.push(-5);
                //         resolved_ba_code_str.push("-5");
                //     } else if (code === "non ba") {
                //         resolved_ba_ids.push(-6);
                //         resolved_ba_code_str.push("-6");
                //     } else if (ba_lookup.hasOwnProperty(code)) {
                //         resolved_ba_ids.push(ba_lookup[code]);
                //         resolved_ba_code_str.push(code);
                //     } else {
                //         has_invalid_ba = true;
                //         addErrorLog(`Invalid Brand Ambassador Code: ${code}`);
                //     }
                // });

                ba_codes.forEach(code => {
                    if (code === "vacant") {
                        resolved_ba_ids.push(-5);
                        resolved_ba_code_str.push("-5");
                        ba_types_found.add(3);
                    } else if (code === "non ba") {
                        resolved_ba_ids.push(-6);
                        resolved_ba_code_str.push("-6");
                        ba_types_found.add(3);
                    } else if (ba_lookup.hasOwnProperty(code)) {
                        let ba_id = ba_lookup[code];
                        resolved_ba_ids.push(ba_id);
                        resolved_ba_code_str.push(code);
                        // Extract type from ba_lookup_data
                        let ba_record = fetch_data.ba.find(ba => ba.code === code);
                        if (ba_record && ba_record.type !== undefined) {
                            ba_types_found.add(parseInt(ba_record.type));
                        // } else {
                        //     has_invalid_ba = true;
                        //     addErrorLog(`Missing BA type for code: ${code}`);
                        }
                    } else {
                        has_invalid_ba = true;
                        addErrorLog(`Invalid Brand Ambassador Code: ${code}`);
                    }
                });

                // Check that all BA types are the same
                let ba_type_final = null;
                if (ba_types_found.size > 1) {
                    addErrorLog(`Mismatched BA types for codes: ${ba_code_raw}`);
                } else if (ba_types_found.size === 1) {
                    ba_type_final = [...ba_types_found][0];
                }

                if (ba_code_raw.length > 250 || ba_codes.length === 0) {
                    addErrorLog("Invalid Brand Ambassador Code");
                }

                let monthlyValues = getMonthlyValues(row);
                Object.entries(monthlyValues).forEach(([key, value]) => {
                    if (value) monthlyValues[key] = validateFloatField(value, key, tr_count);
                });
    
                if (!store_code_id) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Store Code at line #: ${tr_count}`);
                    err_counter++;
                }

                let matched = ba_checklist[store_code_lower] || {};

                if (!invalid) {
                    valid_data.push({
                        ba_code: resolved_ba_code_str.join(','),
                        location: matched?.store_code || 0,
                        ...monthlyValues,
                        status: 2,
                        created_by: user_id,
                        created_date: date_of_creation,
                        area_id: matched?.area_id || 0,
                        asc_id: matched?.asc_id || 0,
                        brand_ids: (matched.brand_ids && matched.brand_ids.length) ? matched.brand_ids.join(',') : '',
                        ba_types: ba_type_final
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
