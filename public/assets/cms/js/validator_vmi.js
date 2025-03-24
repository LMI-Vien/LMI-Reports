self.onmessage = async function(e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let company = e.data.company;
    let invalid = false;
    let errorLogs = [];
    let valid_data = [];
    let err_counter = 0;
    const ERROR_LOG_LIMIT = 1000; // Reduce error log limit
    const BATCH_SIZE = 1000; // Reduce batch size
    let index = 0;

    try {
        let get_ba_valid_response = await fetch(`${BASE_URL}cms/global_controller/get_valid_ba_data?stores=1&customer_sku_code_lmi=1&customer_sku_code_rgdi=1`);   
        let ba_data = await get_ba_valid_response.json();

        let store_lookup = {};
        ba_data.stores.forEach(store => store_lookup[store.code.toLowerCase()] = store.id);

        let item_lookup = {};
        let item_records = company == 1 ? ba_data.customer_sku_code_rgdi : ba_data.customer_sku_code_lmi;
        item_records.forEach(item => item_lookup[item.cusitmcde.toLowerCase()] = item.recid);

        function processBatch() {
            if (index >= data.length) {
                // Final message with results
                self.postMessage({ invalid, errorLogs, valid_data, err_counter });
                return;
            }

            for (let i = 0; i < BATCH_SIZE && index < data.length; i++, index++) {
                let row = data[index];
                let tr_count = index + 1;
                let store = row["store"]?.trim() || "";
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

                if (!["1 (active)", "3 (de-listed)"].includes(vmi_status)) {
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

                store = store_lookup[store.toLowerCase()] || addErrorLog("Invalid Store");
                //temporary disabled for demo
               // item = item_lookup[item.toLowerCase()] || addErrorLog("Invalid Item");

                if (!invalid) {
                    valid_data.push({
                        store, item, item_name, item_class, supplier, c_group, dept, c_class: r_class, sub_class, 
                        on_hand, in_transit, average_sales_unit: ave_sales_unit, vmi_status, status, 
                        created_by: user_id, created_date: date_of_creation
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
