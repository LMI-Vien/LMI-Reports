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

            // let january_ta = row["JanuaryTA"] ? row["JanuaryTA"].trim() : "";
            // let february_ta = row["FebruaryTA"] ? row["FebruaryTA"].trim() : "";
            // let march_ta = row["MarchTA"] ? row["MarchTA"].trim() : "";
            // let april_ta = row["AprilTA"] ? row["AprilTA"].trim() : "";
            // let may_ta = row["MayTA"] ? row["MayTA"].trim() : "";
            // let june_ta = row["JuneTA"] ? row["JuneTA"].trim() : "";
            // let july_ta = row["JulyTA"] ? row["JulyTA"].trim() : "";
            // let august_ta = row["AugustTA"] ? row["AugustTA"].trim() : "";
            // let september_ta = row["SeptemberTA"] ? row["SeptemberTA"].trim() : "";
            // let october_ta = row["OctoberTA"] ? row["OctoberTA"].trim() : "";
            // let november_ta = row["NovemberTA"] ? row["NovemberTA"].trim() : "";
            // let december_ta = row["DecemberTA"] ? row["DecemberTA"].trim() : "";

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
                    // ...monthlyTa,
                    january_ta: monthlyTa.january_ta,
                    february_ta: monthlyTa.february_ta,
                    march_ta: monthlyTa.march_ta,
                    april_ta: monthlyTa.april_ta,
                    may_ta: monthlyTa.may_ta,
                    june_ta: monthlyTa.june_ta,
                    july_ta: monthlyTa.july_ta,
                    august_ta: monthlyTa.august_ta,
                    september_ta: monthlyTa.september_ta,
                    october_ta: monthlyTa.october_ta,
                    november_ta: monthlyTa.november_ta,
                    december_ta: monthlyTa.december_ta,
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
            let key = type === "ta" ? `${month}TA` : month;
            let value = row[key]?.replace(/,/g, "").trim() || "";  

            values[`${month.toLowerCase()}_${type}`] = value;
        });
    
        return values;
    }

   
};