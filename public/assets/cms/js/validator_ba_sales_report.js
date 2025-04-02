self.onmessage = async function(e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let invalid = false;
    let errorLogs = [];
    let valid_data = [];
    var err_counter = 0;

    // Process in smaller batches to avoid memory issues
    let batchSize = 2000;
    let index = 0;
    try {
        let get_ba_valid_response = await fetch(`${BASE_URL}cms/global_controller/get_valid_ba_data?ba=1&brands=1&stores=1&areas=1&ba_store_area=1`);   
        let ba_data = await get_ba_valid_response.json();
        ba_records = ba_data.ba;
        let ba_lookup = {};
        ba_records.forEach(ba => ba_lookup[ba.code] = ba.id);

        brand_records = ba_data.brands;
        let brand_lookup = {};
        brand_records.forEach(brand => brand_lookup[brand.brand_description] = brand.id);

        store_records = ba_data.stores;
        let store_lookup = {};
        store_records.forEach(store => store_lookup[store.code] = store.id);

        area_records = ba_data.areas;
        let area_lookup = {};
        area_records.forEach(area => area_lookup[area.code] = area.id);



        ba_area_store_records = ba_data.ba_store_area;
        let ba_area_store_lookup = {};
        ba_area_store_records.forEach(record => {
            let baId = String(record.id);
            let storeId = String(record.store);
            let areaId = String(record.area);

            if (!ba_area_store_lookup[baId]) {
                ba_area_store_lookup[baId] = { stores: new Set(), areas: new Set() };
            }
            ba_area_store_lookup[baId].stores.add(storeId);
            ba_area_store_lookup[baId].areas.add(areaId);
        });

        function formatDateForDB(dateStr) {
            let [month, day, year] = dateStr.split('/');
            return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
        }

        function processBatch() {
            if (index >= data.length) {
                // Final message with results
                self.postMessage({ invalid, errorLogs, valid_data, err_counter });
                return;
            }


            let progress = Math.round((index / data.length) * 100);
            self.postMessage({ progress });

            for (let i = 0; i < batchSize && index < data.length; i++, index++) {
                let row = data[index];
                let tr_count = index + 1;
                let ba_id = row["BA Code"] ? row["BA Code"].trim() : "";
                let area_id = row["Area Code"] ? row["Area Code"].trim() : "";
                let store_id = row["Store Code"] ? row["Store Code"].trim() : "";
                let brand = row["Brand"] ? row["Brand"].trim() : "";
                let date = row["Date"] ? row["Date"]: "";
                let amount = row["Amount"] ? row["Amount"].trim() : "";
                let user_id = row["Created by"] ? row["Created by"].trim() : "";
                let date_of_creation = row["Created Date"] ? row["Created Date"].trim() : "";  

                if (store_id === "") {
                    invalid = true;
                    errorLogs.push(`⚠️ Empty Store Code at line #: ${tr_count}`);
                    err_counter++;
                }

                if (area_id === "") {
                    invalid = true;
                    errorLogs.push(`⚠️ Empty Area Code at line #: ${tr_count}`);
                    err_counter++;
                }

                if (brand === "") {
                    invalid = true;
                    errorLogs.push(`⚠️ Empty Brand at line #: ${tr_count}`);
                    err_counter++;
                }

                if (ba_id === "") {
                    invalid = true;
                    errorLogs.push(`⚠️ Empty Brand Ambassador Code at line #: ${tr_count}`);
                    err_counter++;
                }

                let dateObj = new Date(date);
                if (isNaN(dateObj.getTime())) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Date at line #: ${tr_count}`);
                    err_counter++;
                }

                if (amount === "" || isNaN(amount) || isNaN(parseFloat(amount))) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Amount at line #: ${tr_count}`);
                    err_counter++;
                }

                let normalized_store_lookup = {};
                for (let key in store_lookup) {
                    normalized_store_lookup[key.toLowerCase()] = store_lookup[key];
                }

                let store_lower = store_id.toLowerCase();
                if (store_lower in normalized_store_lookup) {
                    store_id = normalized_store_lookup[store_lower];
                }else {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Store Code at line #: ${tr_count}`);
                    err_counter++;
                }

                let normalized_brand_lookup = {};
                for (let key in brand_lookup) {
                    normalized_brand_lookup[key.toLowerCase()] = brand_lookup[key];
                }

                let brand_lower = brand.toLowerCase();
                if (brand_lower in normalized_brand_lookup) {
                    brand = normalized_brand_lookup[brand_lower];
                }else {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Brand at line #: ${tr_count}`);
                    err_counter++;
                }

                let normalized_ba_lookup = {};
                for (let key in ba_lookup) {
                    normalized_ba_lookup[key.toLowerCase()] = ba_lookup[key];
                }

                let ba_lower = ba_id.toLowerCase();
                if (ba_lower in normalized_ba_lookup) {
                    ba_id = normalized_ba_lookup[ba_lower];
                }else {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Brand Ambassador Code at line #: ${tr_count}`);
                    err_counter++;
                }

                let normalized_area_lookup = {};
                for (let key in area_lookup) {
                    normalized_area_lookup[key.toLowerCase()] = area_lookup[key];
                }

                let area_lower = area_id.toLowerCase();
                if (area_lower in normalized_area_lookup) {
                    area_id = normalized_area_lookup[area_lower];
                }else {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Area Code at line #: ${tr_count}`);
                    err_counter++;
                }

                if (!ba_area_store_lookup[ba_id] || 
                    !ba_area_store_lookup[ba_id].stores.has(store_id) || 
                    !ba_area_store_lookup[ba_id].areas.has(area_id)) {
                    invalid = true;
                    errorLogs.push(`⚠️ BA Code is not associated with Area Code and Store Code at line #: ${tr_count}`);
                    err_counter++;
                }

                if (date) {
                    date = formatDateForDB(date);
                }

                if (!invalid) {
                    valid_data.push({
                        area_id: area_id,
                        store_id: store_id,
                        brand: brand,
                        ba_id: ba_id,
                        date: date,
                        amount: amount,
                        status: 1,
                        created_by: user_id,
                        created_date: date_of_creation
                    });
                }
            }

            setTimeout(processBatch, 0);
        }

            processBatch();
        }catch (error) {
        self.postMessage({ invalid: true, errorLogs: [`Validation failed: ${error.message}`], err_counter: 1 });
    }
};