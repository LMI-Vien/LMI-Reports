self.onmessage = async function (e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let invalid = false;
    let errorLogs = [];
    let unique_description = new Set();
    let valid_data = [];
    let err_counter = 0;
    let store_per_area = {};

    try {
        const today = new Date();
        const currentYear = today.getFullYear();
        const currentMonth = String(today.getMonth() + 1).padStart(2, '0');
        const codePrefix = `AREA-${currentYear}-${currentMonth}-`;

        let get_ba_valid_response = await fetch(`${BASE_URL}cms/global_controller/get_valid_ba_data?stores=1&store_area=1`);
        let ba_data = await get_ba_valid_response.json();

        let get_existing_area_response = await fetch(`${BASE_URL}cms/area/get-existing-area-data`);
        let existing_area_data = await get_existing_area_response.json();

        let descriptionToCodeMap = {};
        if (Array.isArray(existing_area_data)) {
            existing_area_data.forEach(row => {
                if (row.description && row.code) {
                    descriptionToCodeMap[row.description.trim().toLowerCase()] = row.code.trim();
                }
            });
        }

        let get_latest_code_response = await fetch(`${BASE_URL}cms/area/get-latest-area-code`);
        let latest_code_data = await get_latest_code_response.json();
        let latest_code = latest_code_data.code || "";
        let latest_number = 0;

        if (latest_code.startsWith(codePrefix)) {
            latest_number = parseInt(latest_code.split("-")[3]) || 0;
        }

        function generateNextCode() {
            latest_number++;
            return `${codePrefix}${String(latest_number).padStart(3, '0')}`;
        }

        let generatedCodeCache = {};

        let store_records = ba_data.stores;
        let store_group_records = ba_data.store_area;

        let store_lookup = {};
        store_records.forEach(store => store_lookup[store.code.toLowerCase()] = store.id);

        let store_global_tag_map = {};
        store_group_records.forEach(row => {
            if (row.store_id && row.area_id && row.area_code) {
                store_global_tag_map[row.store_id] = row.area_code;
            }
        });

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

                let description = row["Area Description"]?.trim() || "";
                let status = row["Status"]?.toLowerCase() || "";
                let stores = row["Store Codes"] || "";
                let user_id = row["Created By"]?.trim() || "";
                let date_of_creation = row["Created Date"]?.trim() || "";

                if (description === "" || description.length > 50) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Description at line #: ${tr_count}`);
                    err_counter++;
                    continue;
                }

                if (!["active", "inactive"].includes(status)) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Status at line #: ${tr_count}`);
                    err_counter++;
                    continue;
                }

                if (unique_description.has(description.toLowerCase())) {
                    invalid = true;
                    errorLogs.push(`⚠️ Duplicate Area Description at line #: ${tr_count}`);
                    err_counter++;
                    continue;
                }

                unique_description.add(description.toLowerCase());

                let descKey = description.toLowerCase();
                let code = "";
                if (descriptionToCodeMap[descKey]) {
                    code = descriptionToCodeMap[descKey];
                } else if (generatedCodeCache[descKey]) {
                    code = generatedCodeCache[descKey];
                } else {
                    code = generateNextCode();
                    generatedCodeCache[descKey] = code;
                }

                if (!store_per_area[code]) {
                    store_per_area[code] = [];
                }

                let store_list = [];
                if (typeof stores === 'string') {
                    store_list = stores.split(',').map(s => s.trim().toLowerCase());
                } else if (Array.isArray(stores)) {
                    store_list = stores.map(s => String(s).trim().toLowerCase());
                }

                let invalid_store = false;
                for (let s of store_list) {
                    if (s in store_lookup) {
                        let store_id = store_lookup[s];

                        if (store_global_tag_map[store_id] && store_global_tag_map[store_id] !== code) {
                            invalid = true;
                            if (!invalid_store) {
                                invalid_store = true;
                                errorLogs.push(`⚠️ Store "${s}" at line #: ${tr_count} is already assigned to another area (${store_global_tag_map[store_id]}).`);
                                err_counter++;
                            }
                        } else {
                            if (!store_per_area[code].includes(store_id)) {
                                store_per_area[code].push(store_id);
                            }
                            store_global_tag_map[store_id] = code;
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
