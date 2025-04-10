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

        brand_records = ba_data.brands;
        let brand_lookup = {};
        brand_records.forEach(brand => brand_lookup[brand.brand_description] = brand.id);

        let ba_checklist = {};
        ba_data.ba_area_store_brand.forEach(item => {
            ba_checklist[item.code] = {
                id: item.id,
                area_id: item.area_id,
                area_code: item.area_code,
                store_id: item.store_id,
                store_code: item.store_code,
                brands: item.brands ? item.brands.split(',').map(b => b.trim().toLowerCase()) : []
            };
        });

        function processBatch() {
            if (index >= data.length) {
                self.postMessage({ invalid, errorLogs, valid_data, err_counter });
                return;
            }

            for (let i = 0; i < batchSize && index < data.length; i++, index++) {
                let row = data[index];
                let tr_count = index + 1;

                let ba_code = row["BA Code"]?.trim() || "";
                let area_code = row["Area Code"]?.trim() || "";
                let store_code = row["Store Code"]?.trim() || "";
                let brand = row["Brand"]?.trim() || "";
                let date = row["Date"] || "";
                let amount = row["Amount"]?.trim() || "";
                let user_id = row["Created by"]?.trim() || "";
                let date_of_creation = row["Created Date"]?.trim() || "";

                // Check for empty values
                if (ba_code === "") {
                    invalid = true;
                    errorLogs.push(`⚠️ Empty Brand Ambassador Code at line #: ${tr_count}`);
                    err_counter++;
                    continue;
                }

                let matchedBA = ba_checklist[ba_code];
                if (!matchedBA) {
                    invalid = true;
                    errorLogs.push(`⚠️ BA Code "${ba_code}" not found in system at line #: ${tr_count}`);
                    err_counter++;
                    continue;
                }

                if (area_code === "") {
                    invalid = true;
                    errorLogs.push(`⚠️ Empty Area Code at line #: ${tr_count}`);
                    err_counter++;
                } else if (matchedBA.area_code !== area_code) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Area Code "${area_code}" for BA Code "${ba_code}" at line #: ${tr_count}`);
                    err_counter++;
                }

                if (store_code === "") {
                    invalid = true;
                    errorLogs.push(`⚠️ Empty Store Code at line #: ${tr_count}`);
                    err_counter++;
                } else if (matchedBA.store_code !== store_code) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Store Code "${store_code}" for BA Code "${ba_code}" at line #: ${tr_count}`);
                    err_counter++;
                }

                if (brand !== "") {
                    let brandLower = brand.toLowerCase();
                    if (!matchedBA.brands.includes(brandLower)) {
                        invalid = true;
                        errorLogs.push(`⚠️ Brand "${brand}" is not associated with BA Code "${ba_code}" at line #: ${tr_count}`);
                        err_counter++;
                    }
                }

                let normalized_brand_lookup = {};
                for (let key in brand_lookup) {
                    normalized_brand_lookup[key.toLowerCase()] = brand_lookup[key];
                }

                let brand_lower = brand.toLowerCase();
                if (brand_lower in normalized_brand_lookup) {
                    brand = normalized_brand_lookup[brand_lower];
                } else {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Brand at line #: ${tr_count}`);
                    err_counter++;
                }

                let dateObj = new Date(date);
                if (isNaN(dateObj.getTime())) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Date at line #: ${tr_count}`);
                    err_counter++;
                } else {
                    date = formatDateForDB(date);
                }

                let cleanedAmount = amount.replace(/,/g, '');

                if (cleanedAmount === "" || isNaN(cleanedAmount) || isNaN(parseFloat(cleanedAmount))) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Amount at line #: ${tr_count}`);
                    err_counter++;
                } else {
                    amount = parseFloat(cleanedAmount);
                }

                if (!invalid) {
                    valid_data.push({
                        area_id: matchedBA.area_id,
                        store_id: matchedBA.store_id,
                        ba_id: matchedBA.id,
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
