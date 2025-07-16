self.onmessage = async function (e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let invalid = false;
    let errorLogs = [];
    let valid_data = [];
    var err_counter = 0;
    const ERROR_LOG_LIMIT = 1000;
    const BATCH_SIZE = 2000;
    let index = 0;

    function formatDateForDB(dateStr) {
        let [month, day, year] = dateStr.split('/');
        return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
    }

    try {
        let get_ba_valid_response = await fetch(`${BASE_URL}cms/global_controller/get_valid_ba_data?brands=1&ba_area_store_brand=1&stores=1&areas=1&ba=1&area_asc=1`);
        let ba_data = await get_ba_valid_response.json();

        // Brand lookup normalization
        let brand_lookup = {};
        ba_data.brands.forEach(brand => {
            brand_lookup[brand.brand_description.toLowerCase()] = brand.id;
        });

        let store_lookup = {};
        ba_data.stores.forEach(store => {
            store_lookup[store.code.toLowerCase()] = store.id;
        });

        let area_lookup = {};
        ba_data.areas.forEach(area => {
            area_lookup[area.code.toLowerCase()] = area.id;
        });

        let ba_lookup = {};
        ba_data.ba.forEach(ba => {
            ba_lookup[ba.code.toLowerCase()] = { id: ba.id, type: ba.type }; // assuming 'type' is the ba_types field
        });

        let area_asc_lookup = {};
        ba_data.area_asc.forEach(area_asc => {
            if (area_asc.code && area_asc.asc_id) {
                area_asc_lookup[area_asc.code.trim().toLowerCase()] = area_asc.asc_id;
            }
        });


        let ba_checklist = [];

        function findMatch(area_code, store_code, ba_code) {
            return ba_checklist.find(entry =>
                entry.area_code === area_code &&
                entry.store_code === store_code &&
                (entry.ba_code === ba_code || (!entry.ba_code && ba_code === ""))
            );
        }

        function processBatch() {
            if (index >= data.length) {
                self.postMessage({ invalid, errorLogs, valid_data, err_counter });
                return;
            }

            for (let i = 0; i < BATCH_SIZE && index < data.length; i++, index++) {
                let row = data[index];
                let tr_count = index + 1;

                let area_code = row["Area Code"]?.trim() || "";
                let store_code = row["Store Code"]?.trim() || "";
                let ba_code = row["BA Code"]?.trim() || "";
                let brand = row["Brand"]?.trim() || "";
                let date = row["Date"] || "";
                let amount = row["Amount"]?.trim() || "";
                let user_id = row["Created by"]?.trim() || "";
                let date_of_creation = row["Created Date"]?.trim() || "";

                function addErrorLog(message) {
                    invalid = true;
                    err_counter++;
                    if (errorLogs.length < ERROR_LOG_LIMIT) {
                        errorLogs.push(`⚠️ ${message} at line #: ${tr_count}`);
                    }
                }

                if (area_code === "" || store_code === "") {
                    addErrorLog("Missing Area or Store Code");
                    continue;
                }

                // 🆕 Validate store-area tagging
                let match = findMatch(area_code, store_code, ba_code);

                if (brand) {
                    let brand_lower = brand.toLowerCase();

                    brand_id = brand_lookup[brand_lower] || null;
                    if (!brand_id) {
                        addErrorLog(`Brand "${brand}" not recognized`);
                        continue;
                    }
                }

                if (store_code) {
                    let store_lower = store_code.toLowerCase();
                    store = store_lookup[store_lower] || null;
                    if (!store) {
                        addErrorLog(`Store Code "${store_code}" not recognized`);
                        continue;
                    }
                }

                let asc_id = null;
                if (area_code) {
                    let area_lower = area_code.toLowerCase();
                    area = area_lookup[area_lower] || null;
                    if (!area) {
                        addErrorLog(`Area Code "${area_code}" not recognized`);
                        continue;
                    }

                    asc_id = area_asc_lookup[area_lower] || null;
                }

                if (!ba_code) {
                    addErrorLog("BA Code is required");
                    continue;
                }

                let ba_lower = ba_code.toLowerCase();
                let ba_entry = ba_lookup[ba_lower] || null;

                if (!ba_entry) {
                    addErrorLog(`Brand Ambassador Code "${ba_code}" not recognized`);
                    continue;
                }

                let ba = ba_entry.id;
                let ba_type = ba_entry.type;

                // 🔍 Validate ba_type is not null or 3
                if (ba_type === null || ba_type === undefined) {
                    addErrorLog(`BA Type is missing for BA Code "${ba_code}"`);
                    continue;
                }

                if (ba_type === 3) {
                    addErrorLog(`Invalid BA Type (3) for BA Code "${ba_code}" – 'vacant' or 'non BA' not allowed in this module`);
                    continue;
                }

                let dateObj = new Date(date);
                if (isNaN(dateObj.getTime())) {
                    addErrorLog("Invalid Date");
                    continue;
                } else {
                    date = formatDateForDB(date);
                }

                let cleanedAmount = amount.replace(/,/g, '');
                if (cleanedAmount === "" || isNaN(cleanedAmount)) {
                    addErrorLog("Invalid Amount");
                    continue;
                } else {
                    amount = parseFloat(cleanedAmount);
                }

                if (!invalid) {
                    valid_data.push({
                        area_id: area,
                        store_id: store,
                        store_code: store_code,
                        ba_id: ba || 0,
                        ba_type: ba_type,
                        brand: brand_id,
                        asc_id: asc_id || 0,
                        date: date,
                        amount: amount,
                        status: 1,
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
