self.onmessage = async function(e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let invalid = false;
    let errorLogs = [];
    let unique_code = new Set();
    let unique_description = new Set();
    let valid_data = [];
    var err_counter = 0;
    var ba_per_store = {};

    try {
        let get_ba_valid_response = await fetch(`${BASE_URL}cms/global_controller/get_valid_ba_data?ba=1&store_ba=1`);   
        let ba_data = await get_ba_valid_response.json();

        let ba_records = ba_data.ba;
        let store_ba_group_records = ba_data.store_ba;

        let ba_lookup = {};
        ba_records.forEach(ba => ba_lookup[ba.code.toLowerCase()] = ba.id);

        let ba_id_to_code = {};
        let store_ba_global_tag_map = {};

        store_ba_group_records.forEach(row => {
            if (row.ba_id && row.store_id && row.ba_code) {
                store_ba_global_tag_map[row.ba_id] = row.ba_code;
                ba_id_to_code[row.store_id] = row.ba_code;
            }
        });

        let batchSize = 2000;
        let index = 0;

        function processBatch() {
            if (index >= data.length) {
                self.postMessage({ invalid, errorLogs, valid_data, err_counter, ba_per_store });
                return;
            }

        for (let i = 0; i < batchSize && index < data.length; i++, index++) {
            let row = data[index];
            let tr_count = index + 1;
            let code = row["Store/Branch Code"] ? row["Store/Branch Code"].trim() : "";
            let description = row["Store/Branch Description"] ? row["Store/Branch Description"].trim() : "";
            let bas_raw = row["Store/Branch Brand Ambassador Code"];
            let bas = typeof bas_raw === 'string' ? bas_raw.trim() : String(bas_raw || '').trim();
            let status = row["Status"] ? row["Status"].toLowerCase() : "";
            let user_id = row["Created By"] ? row["Created By"].trim() : "";
            let date_of_creation = row["Created Date"] ? row["Created Date"].trim() : "";
            let invalid_ba = false; 

            if (unique_code.has(code)) {
                invalid = true;
                errorLogs.push(`⚠️ Duplicated Code at line #: ${tr_count}`);
                err_counter++;
            } else if (code.length > 25 || code === "") {
                invalid = true;
                errorLogs.push(`⚠️ Invalid Code at line #: ${tr_count}`);
                err_counter++;
            } else {
                if (!ba_per_store[code]) {
                    ba_per_store[code] = []; 
                }

                let ba_list = [];
                if (typeof bas === 'string') {
                    ba_list = bas.split(',').map(s => s.trim().toLowerCase());
                } else if (Array.isArray(bas)) {
                    ba_list = bas.map(s => String(s).trim().toLowerCase());
                }
                // for (let s of ba_list) {
                //     if (s in ba_lookup) {
                //         let ba_id = ba_lookup[s];

                //         if (store_ba_global_tag_map[ba_id] && store_ba_global_tag_map[ba_id] !== code) {
                //             invalid = true;
                //             // if (!invalid_ba) {
                //             //     invalid_ba = true;
                //             //     if (s === store_ba_global_tag_map[ba_id].toLowerCase()) {
                //             //         errorLogs.push(`⚠️ Brand Ambassador "${s}" at line #: ${tr_count} is already assigned to another Store.`);
                //             //     } else {
                //             //         errorLogs.push(`⚠️ Brand Ambassador "${s}" at line #: ${tr_count} is already assigned to another Store (${store_ba_global_tag_map[ba_id]}).`);
                //             //     }
                //             //     err_counter++;
                //             // }
                //         } else {
                //             if (!ba_per_store[code].includes(ba_id)) {
                //                 ba_per_store[code].push(ba_id);
                //             }
                //             store_ba_global_tag_map[ba_id] = code;
                //         }
                //     } else {
                //         if (!invalid_ba) {
                //             if (!["active", "inactive"].includes(bas)) {
                //                 invalid = true;
                //                 invalid_ba = true;
                //                 errorLogs.push(`⚠️ Invalid Brand Ambassador at line #: ${tr_count}`);
                //                 err_counter++;
                //             }
                            
                //         }
                //     }
                // }
                for (let s of ba_list) {
                    if (s === 'vacant') {
                        if (!ba_per_store[code].includes(-5)) {
                            ba_per_store[code].push(-5);
                        }
                    } else if (s === 'non ba' || s === 'nonba') {
                        if (!ba_per_store[code].includes(-6)) {
                            ba_per_store[code].push(-6);
                        }
                    } else if (s in ba_lookup) {
                        let ba_id = ba_lookup[s];

                        if (store_ba_global_tag_map[ba_id] && store_ba_global_tag_map[ba_id] !== code) {
                            //to be confirm
                            // invalid = true;
                            // if (!invalid_ba) {
                            //     invalid_ba = true;
                            //     errorLogs.push(`⚠️ Brand Ambassador "${s}" at line #: ${tr_count} is already assigned to another Store.`);
                            //     err_counter++;
                            // }
                            if (!ba_per_store[code].includes(ba_id)) {
                                ba_per_store[code].push(ba_id);
                            }
                            store_ba_global_tag_map[ba_id] = code;
                        } else {
                            if (!ba_per_store[code].includes(ba_id)) {
                                ba_per_store[code].push(ba_id);
                            }
                            store_ba_global_tag_map[ba_id] = code;
                        }
                    } else {
                        if (!invalid_ba) {
                            if (!["active", "inactive"].includes(s)) {
                                invalid = true;
                                invalid_ba = true;
                                errorLogs.push(`⚠️ Invalid Brand Ambassador "${s}" at line #: ${tr_count}`);
                                err_counter++;
                            }
                        }
                    }
                }

                unique_code.add(code);
            }

            if (description.length > 50 || description === "") {
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
                    code: code,
                    description: description,
                    status: status === "active" ? 1 : 0,
                    created_by: user_id,
                    created_date: date_of_creation
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

