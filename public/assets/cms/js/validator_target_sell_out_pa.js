self.onmessage = function(e) {
    let data = e.data;
    let invalid = false;
    let errorLogs = [];
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

        console.log(`Processing batch starting at index: ${index}`);

        for (let i = 0; i < batchSize && index < data.length; i++, index++) {
            let row = data[index];
            let tr_count = index + 1;
            let payment_group = row["Payment Group"] ? row["Payment Group"].trim() : "";
            let vendor = row["Vendor"] ? row["Vendor"].trim() : "";
            let overall = row["Overall"] ? row["Overall"].trim() : "";
            let kam_kas_kaa = row["KAM/KAS/KAA"] ? row["KAM/KAS/KAA"].trim() : "";
            let sales_group = row["Sales Group"] ? row["Sales Group"].trim() : "";
            let terms = row["Terms"] ? row["Terms"].trim() : "";
            let channel = row["Channel"] ? row["Channel"].trim() : "";
            let brand = row["Brand"] ? row["Brand"].trim() : "";
            let exclusivity = row["Exclusivity"] ? row["Exclusivity"].trim() : "";
            let category = row["Category"] ? row["Category"].trim() : "";
            let lmi_code = row["LMI Code"] ? row["LMI Code"].trim() : "";
            let rgdi_code = row["RGDI CODE"] ? row["RGDI CODE"].trim() : "";
            let customer_sku_code = row["Customer SKU Code"] ? row["Customer SKU Code"].trim() : "";
            let item_description = row["Item Description"] ? row["Item Description"].trim() : "";
            let item_status = row["Item status"] ? row["Item status"].trim() : "";
            let srp = row["SRP"] ? row["SRP"].trim() : "";
            let trade_discount = row["Trade Discount"] ? row["Trade Discount"].trim() : "";
            let customer_cost = row["Customer Cost"] ? row["Customer Cost"].trim() : "";
            let customer_cost_nov = row["Customer Cost (Net of Vat)"] ? row["Customer Cost (Net of Vat)"].trim() : "";

            let monthlyTq = getMonthlyValues(row, "tq");
            let monthlyTa = getMonthlyValues(row, "ta");

            // let january_tq = row["January"] ? row["January"].trim() : "";
            // let february_tq = row["February"] ? row["February"].trim() : "";
            // let march_tq = row["March"] ? row["March"].trim() : "";
            // let april_tq = row["April"] ? row["April"].trim() : "";
            // let may_tq = row["May"] ? row["May"].trim() : "";
            // let june_tq = row["June"] ? row["June"].trim() : "";
            // let july_tq = row["July"] ? row["July"].trim() : "";
            // let august_tq = row["August"] ? row["August"].trim() : "";
            // let september_tq = row["September"] ? row["September"].trim() : "";
            // let october_tq = row["October"] ? row["October"].trim() : "";
            // let november_tq = row["November"] ? row["November"].trim() : "";
            // let december_tq = row["December"] ? row["December"].trim() : "";
            let totalQty = row["Total Quantity"]?.trim() || "";
            let totalAmount = row["Total Amount"]?.trim() || "";
            let user_id = row["Created by"] ? row["Created by"].trim() : "";
            let date_of_creation = row["Created Date"] ? row["Created Date"].trim() : "";  

            // if (payment_group.length > 25 || payment_group === "") {
            //     invalid = true;
            //     errorLogs.push(`⚠️ Invalid Payment Group at line #: ${tr_count}`);
            //     err_counter++;
            // }

            if (!invalid) {
                valid_data.push({
                    payment_group: payment_group,
                    vendor: vendor,
                    overall: overall,
                    kam_kas_kaa: kam_kas_kaa,
                    sales_group: sales_group,
                    terms: terms,
                    channel: channel,
                    brand: brand,
                    exclusivity: exclusivity,
                    category: category,
                    lmi_code: lmi_code,
                    rgdi_code: rgdi_code,
                    customer_sku_code: customer_sku_code,
                    item_description: item_description,
                    item_status : item_status,
                    srp: srp,
                    trade_discount: trade_discount,
                    customer_cost: customer_cost,
                    customer_cost_net_of_vat: customer_cost_nov,
                    ...monthlyTq,
                    total_quantity: totalQty,
                    ...monthlyTa,
                    total_amount: totalAmount,
                    status: 1,
                    created_by: user_id,
                    created_date: date_of_creation
                });
            }
        }

        setTimeout(processBatch, 0);
    }

    processBatch();

    function getMonthlyValues(row, type) {
        const months = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        
        let values = {};
        months.forEach(month => {
            values[`${month.toLowerCase()}_${type}`] = row[month]?.trim() || "";
        });
    
        return values;
    }

   
};