self.onmessage = async function(e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let invalid = false;    
    let errorLogs = [];
    let unique_code = new Set();
    let unique_name = new Set();
    let valid_data = [];
    var err_counter = 0;
    var brand_per_ba = {};

    try {
        let get_ba_valid_response = await fetch(`${BASE_URL}cms/brand-ambassador/get_valid_ba_data`);   
        let ba_data = await get_ba_valid_response.json();

        agency_records = ba_data.agencies;
        let agency_lookup = {};
        agency_records.forEach(agency => agency_lookup[agency.agency] = agency.id);

        brand_records = ba_data.brands;
        let brand_lookup = {};
        brand_records.forEach(brand => brand_lookup[brand.brand_code] = brand.id);

        store_records = ba_data.stores;
        let store_lookup = {};
        store_records.forEach(store => store_lookup[store.description] = store.id);

        team_records = ba_data.teams;
        let team_lookup = {};
        team_records.forEach(team => team_lookup[team.team_description] = team.id);

        area_records = ba_data.areas;
        let area_lookup = {};
        area_records.forEach(area => area_lookup[area.description] = area.id);

        function formatDateForDB(dateStr) {
            let [month, day, year] = dateStr.split('/');
            return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
        }

        // Process in smaller batches to avoid memory issues
        let batchSize = 2000;
        let index = 0;

        function processBatch() {
            if (index >= data.length) {
                self.postMessage({ invalid, errorLogs, valid_data, err_counter, brand_per_ba });
                return;
            }

            for (let i = 0; i < batchSize && index < data.length; i++, index++) {
                let row = data[index];
                let tr_count = index + 1;
                let code = row["Code"] ? row["Code"].trim() : "";
                let name = row["Name"] ? row["Name"].trim() : "";
                let agency = row["Agency"] ? row["Agency"].trim() : "";
                let brand = row["Brand"] ? row["Brand"] : "";
                let store = row["Store"] ? row["Store"].trim() : "";
                let team = row["Team"] ? row["Team"].trim() : "";
                let area = row["Area"] ? row["Area"].trim() : "";
                let status = row["Status"] ? row["Status"].toLowerCase() : "";
                let type = row["Type"] ? row["Type"].toLowerCase() : "";
                let deployment_date = row["Deployment Date"] ? row["Deployment Date"].trim() : "";
                let user_id = row["Created By"] ? row["Created By"].trim() : "";
                let date_of_creation = row["Created Date"] ? row["Created Date"].trim() : "";
                let invalid_brand = false; 

                if (unique_code.has(code)) {
                    invalid = true;
                    errorLogs.push(`⚠️ Duplicated Code at line #: ${tr_count}`);
                    err_counter++;
                } else if (code.length > 25 || code === "") {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Code at line #: ${tr_count}`);
                    err_counter++;
                } else {

                    if (!brand_per_ba[code]) {
                        brand_per_ba[code] = []; 
                    }

                    let normalized_brand_lookup = {};

                    for (let key in brand_lookup) {
                        normalized_brand_lookup[key.toLowerCase()] = brand_lookup[key];
                    }

                    for (i = 0; i < brand.length; ++i) {
                        let brand_lower = brand[i].toLowerCase();
                        if (brand_lower in normalized_brand_lookup) {
                            let brand_id = normalized_brand_lookup[brand_lower];
                            if (!brand_per_ba[code].includes(brand_id)) {
                                brand_per_ba[code].push(brand_id);
                            }
                        } else {
                            if (!invalid_brand) {
                                    invalid = true;
                                    invalid_brand = true;
                                    errorLogs.push(`⚠️ Invalid Brand at line #: ${tr_count}`);
                                err_counter++;
                            }
                        }
                    }

                    unique_code.add(code);
                }

                if (unique_name.has(name)) {
                    invalid = true;
                    errorLogs.push(`⚠️ Duplicated Name at line #: ${tr_count}`);
                    err_counter++;
                } else if (name.length > 50 || name === "") {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Name at line #: ${tr_count}`);
                    err_counter++;
                } else {
                    unique_name.add(name);
                }

                if (!["outright", "consign"].includes(type)) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Type at line #: ${tr_count}`);
                    err_counter++;
                }

                if (!["active", "inactive"].includes(status)) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Status at line #: ${tr_count}`);
                    err_counter++;
                }

                let dateObj = new Date(deployment_date);
                if (isNaN(dateObj.getTime())) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Deployment Date at line #: ${tr_count}`);
                    err_counter++;
                }

                let normalized_agency_lookup = {};
                for (let key in agency_lookup) {
                    normalized_agency_lookup[key.toLowerCase()] = agency_lookup[key];
                }

                let agency_lower = agency.toLowerCase();
                if (agency_lower in normalized_agency_lookup) {
                    agency = normalized_agency_lookup[agency_lower];
                }else {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Agency at line #: ${tr_count}`);
                    err_counter++;
                }

                let normalized_team_lookup = {};
                for (let key in team_lookup) {
                    normalized_team_lookup[key.toLowerCase()] = team_lookup[key];
                }

                let team_lower = team.toLowerCase();
                if (team_lower in normalized_team_lookup) {
                    team = normalized_team_lookup[team_lower];
                }else {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Team at line #: ${tr_count}`);
                    err_counter++;
                }

                let normalized_area_lookup = {};
                for (let key in area_lookup) {
                    normalized_area_lookup[key.toLowerCase()] = area_lookup[key];
                }

                let area_lower = area.toLowerCase();
                if (area_lower in normalized_area_lookup) {
                    area = normalized_area_lookup[area_lower];
                }else {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Area at line #: ${tr_count}`);
                    err_counter++;
                }

                let normalized_store_lookup = {};
                for (let key in store_lookup) {
                    normalized_store_lookup[key.toLowerCase()] = store_lookup[key];
                }

                let store_lower = store.toLowerCase();
                if (store_lower in normalized_store_lookup) {
                    store = normalized_store_lookup[store_lower];
                }else {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Store at line #: ${tr_count}`);
                    err_counter++;
                }

                if (deployment_date) {
                    deployment_date = formatDateForDB(deployment_date);
                }
                
                if (!invalid) {
                    valid_data.push({
                        code: code,
                        name: name,
                        deployment_date: deployment_date,
                        store: store,
                        team: team,
                        agency: agency,
                        area: area,
                        status: status.toLowerCase() === "active" ? 1 : 0,
                        type: type.toLowerCase() === "consign" ? 1 : 0,
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