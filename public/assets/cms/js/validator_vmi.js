self.onmessage = function(e) {
    let data = e.data;
    let invalid = false;
    let errorLogs = [];
    let unique_store = new Set();
    let unique_description = new Set();
    let valid_data = [];
    var err_counter = 0;

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
            let store = row["Store"] ? row["Store"].trim() : "";
            let store_name = row["Store Name"] ? row["Store Name"].trim() : "";
            let item = row["Item"] ? row["Item"].trim() : "";
            let item_name = row["Item Name"] ? row["Item Name"].trim() : "";
            let status = row["Status"] ? row["Status"].replace(/\s*\(.*?\)/, "").trim() : "";
            // status = status === "1" ? "active" : status === "3" ? "de-listed" : status;
            let item_class = row["Item Class"] ? row["Item Class"].trim() : "";
            let supplier = row["Supplier"] ? row["Supplier"].trim() : "";
            let group = row["Group"] ? row["Group"].trim() : "";
            let dept = row["Dept"] ? row["Dept"].trim() : "";
            let classs = row["Class"] ? row["Class"].trim() : "";
            let sub_class = row["Sub class"] ? row["Sub class"].trim() : "";
            let on_hand = row["on hand"] ? row["on hand"].replace(/,/g, "").trim() : "";
            let in_transit = row["in transit"] ? row["in transit"].replace(/,/g, "").trim() : "";
            let total_qty = row["Total qty"] ? row["Total qty"].replace(/,/g, "").trim() : "";
            let ave_sales_unit = row["Ave Sales Unit"] ? row["Ave Sales Unit"].trim() : "";
            let swc = row["SWC"] ? row["SWC"].trim() : "";
            let a202445 = row["202446"] ? row["202446"].trim() : "";
            let user_id = row["Created By"] ? row["Created By"].trim() : "";
            let date_of_creation = row["Created Date"] ? row["Created Date"].trim() : "";


            if (status === "1") {
                status = "active";
            } else if (status === "3") {
                status = "de-listed";
            } else {
                status = "inactive"; // Handle unexpected status values here
            }
            

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

            if (store_name.length > 25 || store_name === "") {
                invalid = true;
                errorLogs.push(`⚠️ Invalid Store Name at line #: ${tr_count}`);
                err_counter++;
            }

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

            if (!["active", "de-listed"].includes(status)) {
                invalid = true;
                errorLogs.push(`⚠️ Invalid Status at line #: ${tr_count}`);
                err_counter++;
            }

            // let dateObj = new Date(deployment_date);
            // if (isNaN(dateObj.getTime())) {
            //     invalid = true;
            //     errorLogs.push(`⚠️ Invalid Deployment Date at line #: ${tr_count}`);
            //     err_counter++;
            // }

            if (!invalid) {
                valid_data.push({
                    store: store,
                    store_name: store_name,
                    item: item,
                    item_name: item_name,
                    item_class: item_class,
                    supplier: supplier,
                    group: group,
                    dept: dept,
                    class: classs,
                    sub_class: sub_class,
                    on_hand: on_hand,
                    in_transit: in_transit,
                    total_qty: total_qty,
                    average_sales_unit: ave_sales_unit,
                    swc : swc,
                    a202445 : a202445,
                    status : status === "active" ? 1 : (status === "de-listed" ? 3 : 0),
                    created_by: user_id,
                    created_date: date_of_creation
                });
            }
        }

        setTimeout(processBatch, 0);
    }

    processBatch();
};