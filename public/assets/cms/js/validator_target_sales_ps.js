self.onmessage = async function(e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let invalid = false;
    let errorLogs = [];
    let unique_store = new Set();
    let unique_description = new Set();
    let valid_data = [];
    var err_counter = 0;

    try {
        let get_tsp_valid_response = await fetch(`${BASE_URL}cms/import-target-sales-ps/get_valid_target_sales_ps`);   
        let store_data = await get_tsp_valid_response.json();

        self.postMessage({ debug_store_data: store_data });

        // store_records = store_data.codes;
        // let store_lookup = {};
        // store_records.forEach(store => store_lookup[store.code] = store.id);

        // area_records = store_data.areas;
        // let area_lookup = {};
        // area_records.forEach(area => area_lookup[area.description] = area.id);

        // Process in smaller batches to avoid memory issues
        let batchSize = 2000;
        let index = 0;

        function processBatch() {
            if (index >= data.length) {
                self.postMessage({ invalid, errorLogs, valid_data, err_counter });
                return;
            }
    
            for (let i = 0; i < batchSize && index < data.length; i++, index++) {
                let row = data[index];
                let tr_count = index + 1;
                let location = row["Location"] ? row["Location"].trim() : "";
                let location_description = row["Location Description"] ? row["Location Description"].trim() : "";
                let january = row["January"] ? row["January"].trim() : "";
                let february = row["February"] ? row["February"].trim() : "";
                let march = row["March"] ? row["March"].trim() : "";
                let april = row["April"] ? row["April"].trim() : "";
                let may = row["May"] ? row["May"].trim() : "";
                let june = row["June"] ? row["June"].trim() : "";
                let july = row["July"] ? row["July"].trim() : "";
                let august = row["August"] ? row["August"].trim() : "";
                let september = row["September"] ? row["September"].trim() : "";
                let october = row["October"] ? row["October"].trim() : "";
                let november = row["November"] ? row["November"].trim() : "";
                let december = row["December"] ? row["December"].trim() : "";
                let user_id = row["Created by"] ? row["Created by"].trim() : "";
                let date_of_creation = row["Created Date"] ? row["Created Date"].trim() : "";
                
    
                // if (unique_store.has(store)) {
                //     invalid = true;
                //     errorLogs.push(`⚠️ Duplicated Code at line #: ${tr_count}`);
                //     err_counter++;
                // } else if (store.length > 25 || store === "") {
                //     invalid = true;
                //     errorLogs.push(`⚠️ Invalid Code at line #: ${tr_count}`);
                //     err_counter++;
                // } else {
                //     unique_store.add(store);
                // }
    
                // if (store_name.length > 25 || store_name === "") {
                //     invalid = true;
                //     errorLogs.push(`⚠️ Invalid Store Name at line #: ${tr_count}`);
                //     err_counter++;
                // }
    
                // if (unique_description.has(description)) {
                //     invalid = true;
                //     errorLogs.push(`⚠️ Duplicated Description at line #: ${tr_count}`);
                //     err_counter++;
                // } else if (description.length > 50 || description === "") {
                //     invalid = true;
                //     errorLogs.push(`⚠️ Invalid Description at line #: ${tr_count}`);
                //     err_counter++;
                // } else {
                //     unique_description.add(description);
                // }
    
                // if (!["active", "de-listed"].includes(status)) {
                //     invalid = true;
                //     errorLogs.push(`⚠️ Invalid Status at line #: ${tr_count}`);
                //     err_counter++;
                // }
    
                // let dateObj = new Date(deployment_date);
                // if (isNaN(dateObj.getTime())) {
                //     invalid = true;
                //     errorLogs.push(`⚠️ Invalid Deployment Date at line #: ${tr_count}`);
                //     err_counter++;
                // }

                let normalized_store_lookup = {};
                for (let key in store_lookup) {
                    normalized_store_lookup[key.toLowerCase()] = store_lookup[key];
                }

                let area_lower = area_id.toLowerCase();
                if (area_lower in normalized_store_lookup) {
                    area_id = normalized_store_lookup[area_lower];
                }else {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Store at line #: ${tr_count}`);
                    err_counter++;
                }
    
                if (!invalid) {
                    valid_data.push({
                        location: location,
                        location_description: location_description,
                        january: january,
                        february: february,
                        march: march,
                        april: april,
                        may: may,
                        june: june,
                        july: july,
                        august: august,
                        september: september,
                        october: october,
                        november: november,
                        december: december,
                        status : 1,
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