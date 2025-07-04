self.onmessage = async function(e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let company = e.data.company;

    let invalid = false;
    let errorLogs = [];
    let valid_data = [];
    let err_counter = 0;
    const ERROR_LOG_LIMIT = 1000; // Reduce error log limit
    const BATCH_SIZE = 2500; // Reduce batch size
    let index = 0;

    try {
        let get_ba_valid_response = await fetch(`${BASE_URL}cms/global_controller/get_valid_ba_data?stores=1&customer_sku_code_lmi=1&customer_sku_code_rgdi=1&ba_area_store_brand=1&item_classification=1`);   
        let ba_data = await get_ba_valid_response.json();

        let ba_checklist = {};
        ba_data.ba_area_store_brand.forEach(entry => {
            let ba_codes = entry.brand_ambassador_code?.split(',').map(b => b.trim()) || [];
            let ba_ids = entry.brand_ambassador_id?.split(',').map(id => id.trim()) || [];
            let store_codes = entry.store_code?.split(',').map(s => s.trim()) || [];
            let store_ids = entry.store_id?.split(',').map(id => id.trim()) || [];
            let brand_ids = entry.brand_id?.split(',').map(id => id.trim()) || [];
            let ba_types = entry.ba_types?.split(',').map(id => id.trim()) || [];

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
                        brand_ids,
                        ba_types
                    };
                }
            });
        });


        let store_lookup = {};
        ba_data.stores.forEach(store => store_lookup[store.code.toLowerCase()] = store.id);

        let item_class_lookup = {};
        ba_data.item_classification.forEach(item_class => item_class_lookup[item_class.item_class_code.toLowerCase()] = item_class.id);

        let item_lookup = {};
        let item_records = company == 1 ? ba_data.customer_sku_code_rgdi : ba_data.customer_sku_code_lmi;
        item_records.forEach(item => item_lookup[item.cusitmcde.toLowerCase()] = item.recid);

        function processBatch() {
            if (index >= data.length) {
                self.postMessage({ invalid, errorLogs, valid_data, err_counter });
                return;
            }

            for (let i = 0; i < BATCH_SIZE && index < data.length; i++, index++) {
                let row = data[index];
                let tr_count = index + 1;
                let store_code = row["store"]?.trim() || "";
                let item = row["item"]?.trim() || "";
                let item_name = row["item_name"]?.trim() || "";
                let vmi_status = row["vmi_status"]?.toLowerCase() || "";
                let item_class = row["item_class"]?.trim() || "";
                let supplier = row["supplier"]?.trim() || "";
                let c_group = row["group"]?.trim() || "";
                let dept = row["dept"]?.trim() || "";
                let r_class = row["class"]?.trim() || "";
                let sub_class = row["sub_class"]?.trim() || "";
                let on_hand = row["on_hand"]?.replace(/,/g, "").trim() || "";
                let in_transit = row["in_transit"]?.replace(/,/g, "").trim() || "";
                let ave_sales_unit = row["average_sales_unit"]?.trim() || "";
                let user_id = row["created_by"]?.trim() || "";
                let date_of_creation = row["created_date"]?.trim() || "";
                let status = 1;

                function addErrorLog(message) {
                    invalid = true;
                    err_counter++;
                    if (errorLogs.length < ERROR_LOG_LIMIT) {
                        errorLogs.push(`⚠️ ${message} at line #: ${tr_count}`);
                    }
                }

                if (!["1 (active)", "3 (de-listed)", "2 (new)"].includes(vmi_status)) {
                    addErrorLog("Invalid VMI Status");
                }

                if (!item) {
                    addErrorLog("Invalid Item");
                }

                if (!item_name) {
                    addErrorLog("Invalid Item Name");
                }

                if (!item_class) {
                    addErrorLog("Invalid Item Class");
                }

                if (!supplier || isNaN(Number(supplier))) {
                    addErrorLog("Invalid Supplier");
                }

                if (!c_group || isNaN(Number(c_group))) {
                    addErrorLog("Invalid Group");
                }

                if (!dept || isNaN(Number(dept))) {
                    addErrorLog("Invalid Dept");
                }

                if (!r_class || isNaN(Number(r_class))) {
                    addErrorLog("Invalid Class");
                }

                if (!sub_class || isNaN(Number(sub_class))) {
                    addErrorLog("Invalid Sub Class");
                }

                if (on_hand === "" || !Number.isInteger(Number(on_hand))) {
                    addErrorLog("Invalid On Hand");
                }

                if (!in_transit || isNaN(Number(in_transit))) {
                    addErrorLog("Invalid In Transit");
                }

                let store = store_lookup[store_code.toLowerCase()];
                if (!store) addErrorLog("Invalid Store");

                let item_classi = item_class_lookup[item_class.toLowerCase()];
                if (!item_classi) addErrorLog("Invalid item Class");

                let matched = ba_checklist[store_code?.toLowerCase()] || {};

                //if (!matched?.store_id) addErrorLog("Invalid store not tagged to any area");
                if (!invalid) {
                    valid_data.push({
                        store: matched?.store_id || 0,
                        item,
                        item_name,
                        item_class,
                        supplier,
                        c_group,
                        dept,
                        c_class: r_class,
                        sub_class,
                        on_hand,
                        in_transit,
                        average_sales_unit: ave_sales_unit,
                        vmi_status,
                        status,
                        created_by: user_id,
                        created_date: date_of_creation,
                        area_id: matched?.area_id || 0,
                        asc_id: matched?.asc_id || 0,
                        brand_ids: (matched.brand_ids && matched.brand_ids.length) ? matched.brand_ids.join(',') : '',
                        brand_ambassador_ids: (matched.ba_ids && matched.ba_ids.length) ? matched.ba_ids.join(',') : '',
                        ba_types: (matched.ba_types && matched.ba_types.length) ? matched.ba_types.join(',') : '',
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
