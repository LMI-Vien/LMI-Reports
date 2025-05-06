self.onmessage = async function (e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let invalid = false;
    let errorLogs = [];
    let valid_data = [];
    var err_counter = 0;
    let batchSize = 2000;
    let index = 0;

    function formatDateForDB(dateStr) {
        let [month, day, year] = dateStr.split('/');
        return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
    }

    try {
        let get_ba_valid_response = await fetch(`${BASE_URL}cms/global_controller/get_valid_ba_data?brands=1&ba_area_store_brand=1`);
        let ba_data = await get_ba_valid_response.json();

        // Normalize brand lookup
        let brand_lookup = {};
        ba_data.brands.forEach(brand => {
            brand_lookup[brand.brand_description.toLowerCase()] = brand.id;
        });

        // Transform ba_area_store_brand into lookup by area + store + ba
        let ba_checklist = [];
        // console.log(ba_data.ba_area_store_brand);
        // return;
        ba_data.ba_area_store_brand.forEach(entry => {
            let ba_codes = entry.brand_ambassador_code
                ? entry.brand_ambassador_code.split(',').map(b => b.trim())
                : [null];
            let ba_ids = entry.brand_ambassador_id
                ? entry.brand_ambassador_id.split(',').map(id => id.trim())
                : [null];
            let store_codes = entry.store_code
                ? entry.store_code.split(',').map(s => s.trim())
                : [];
            let store_ids = entry.store_id
                ? entry.store_id.split(',').map(id => id.trim())
                : [];

            ba_codes.forEach((ba_code, ba_idx) => {
                store_codes.forEach((store_code, store_idx) => {
                    ba_checklist.push({
                        area_code: entry.area_code,
                        store_code: store_code,
                        ba_code: ba_code || "",

                        area_id: entry.area_id,
                        store_id: store_ids[store_idx] || null,
                        ba_id: ba_ids[ba_idx] || null,

                        brand_ids: entry.brand_id
                            ? entry.brand_id.split(',').map(id => id.trim())
                            : [],
                        brand_names: entry.brand_name
                            ? entry.brand_name.split(',').map(name => name.trim().toLowerCase())
                            : []
                    });
                });
            });
        });

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

            for (let i = 0; i < batchSize && index < data.length; i++, index++) {
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

                if (area_code === "" || store_code === "") {
                    invalid = true;
                    errorLogs.push(`⚠️ Missing Area or Store Code at line #: ${tr_count}`);
                    err_counter++;
                    continue;
                }

                let match = findMatch(area_code, store_code, ba_code);

                if (!match) {
                    invalid = true;
                    errorLogs.push(`⚠️ No match for Area "${area_code}", Store "${store_code}", BA "${ba_code}" at line #: ${tr_count}`);
                    err_counter++;
                    continue;
                }

                if (brand) {
                    let brand_lower = brand.toLowerCase();
                    if (!match.brand_names.includes(brand_lower)) {
                        invalid = true;
                        errorLogs.push(`⚠️ Brand "${brand}" not valid for Area "${area_code}", Store "${store_code}", BA "${ba_code}" at line #: ${tr_count}`);
                        err_counter++;
                        continue;
                    }
                    brand = brand_lookup[brand_lower] || null;
                    if (!brand) {
                        invalid = true;
                        errorLogs.push(`⚠️ Brand "${brand}" not recognized at line #: ${tr_count}`);
                        err_counter++;
                        continue;
                    }
                }

                let dateObj = new Date(date);
                if (isNaN(dateObj.getTime())) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Date at line #: ${tr_count}`);
                    err_counter++;
                    continue;
                } else {
                    date = formatDateForDB(date);
                }

                let cleanedAmount = amount.replace(/,/g, '');
                if (cleanedAmount === "" || isNaN(cleanedAmount)) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Amount at line #: ${tr_count}`);
                    err_counter++;
                    continue;
                } else {
                    amount = parseFloat(cleanedAmount);
                }

                if (!invalid) {
                    valid_data.push({
                        area_id: match.area_id,
                        store_id: match.store_id,
                        ba_id: match.ba_id,
                        brand: brand,
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
