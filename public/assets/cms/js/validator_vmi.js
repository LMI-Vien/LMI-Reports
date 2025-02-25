self.onmessage = async function(e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let invalid = false;
    let errorLogs = [];
    let valid_data = [];
    var err_counter = 0;

    try {
        let get_ba_valid_response = await fetch(`${BASE_URL}cms/import-vmi/get_valid_ba_data`);   
        let ba_data = await get_ba_valid_response.json();

        store_records = ba_data.stores;
        let store_lookup = {};
        store_records.forEach(store => store_lookup[store.code] = store.id);

        item_records = ba_data.items;
        let item_lookup = {};
        item_records.forEach(item => item_lookup[item.cusitmcde] = item.recid);
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
                let store = row["Store"] ? row["Store"].trim() : "";
                let item = row["Item"] ? row["Item"].trim() : "";
                let item_name = row["Item Name"] ? row["Item Name"].trim() : "";
                let vmi_status = row["VMI Status"] ? row["VMI Status"].toLowerCase() : "";
                let item_class = row["Item Class"] ? row["Item Class"].trim() : "";
                let supplier = row["Supplier"] ? row["Supplier"].trim() : "";
                let group = row["Group"] ? row["Group"].trim() : "";
                let dept = row["Dept"] ? row["Dept"].trim() : "";
                let r_class = row["Class"] ? row["Class"].trim() : "";
                let sub_class = row["Sub Class"] ? row["Sub Class"].trim() : "";
                let on_hand = row["On Hand"] ? row["On Hand"].replace(/,/g, "").trim() : "";
                let in_transit = row["In Transit"] ? row["In Transit"].replace(/,/g, "").trim() : "";
                let ave_sales_unit = row["Ave Sales Unit"] ? row["Ave Sales Unit"].trim() : "";
                let user_id = row["Created By"] ? row["Created By"].trim() : "";
                let date_of_creation = row["Created Date"] ? row["Created Date"].trim() : "";
                let status = 1;

                if (!["active", "de-listed"].includes(vmi_status)) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid VMI Status at line #: ${tr_count}`);
                    err_counter++;
                }

                if (store === "") {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Store Code at line #: ${tr_count}`);
                    err_counter++;
                }

                if (item === "") {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Item at line #: ${tr_count}`);
                    err_counter++;
                }

                if (item_name === "") {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Item Name at line #: ${tr_count}`);
                    err_counter++;
                }

                if (item_class === "") {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Item Class at line #: ${tr_count}`);
                    err_counter++;
                }

                if (supplier === "" || !Number.isInteger(Number(supplier))) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Supplier at line #: ${tr_count}`);
                    err_counter++;
                }

                if (group === "" || !Number.isInteger(Number(group))) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Group at line #: ${tr_count}`);
                    err_counter++;
                }

                if (dept === "" || !Number.isInteger(Number(dept))) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Dept at line #: ${tr_count}`);
                    err_counter++;
                }

                if (r_class === "" || !Number.isInteger(Number(r_class))) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Class at line #: ${tr_count}`);
                    err_counter++;
                }

                if (sub_class === "" || !Number.isInteger(Number(sub_class))) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Sub Class at line #: ${tr_count}`);
                    err_counter++;
                }

                if (on_hand === "" || !Number.isInteger(Number(on_hand))) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid On Hand at line #: ${tr_count}`);
                    err_counter++;
                }

                if (in_transit === "" || !Number.isInteger(Number(in_transit))) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid In Transit at line #: ${tr_count}`);
                    err_counter++;
                }

                if (ave_sales_unit === "" || !Number.isInteger(Number(ave_sales_unit))) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid In Ave Sales Unit at line #: ${tr_count}`);
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

                let normalized_item_lookup = {};
                for (let key in item_lookup) {
                    normalized_item_lookup[key.toLowerCase()] = item_lookup[key];
                }

                let item_lower = item.toLowerCase();
                if (item_lower in normalized_item_lookup) {
                    item = item;
                }else {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Item at line #: ${tr_count}`);
                    err_counter++;
                }

                if (!invalid) {
                    valid_data.push({
                        store: store,
                        item: item,
                        item_name: item_name,
                        item_class: item_class,
                        supplier: supplier,
                        group: group,
                        dept: dept,
                        class: r_class,
                        sub_class: sub_class,
                        on_hand: on_hand,
                        in_transit: in_transit,
                        average_sales_unit: ave_sales_unit,
                        vmi_status : vmi_status,
                        status : status,
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