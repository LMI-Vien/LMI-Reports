self.onmessage = async function (e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let errorLogs = [];
    let valid_data = [];
    let err_counter = 0;

    try {
        // let get_ba_valid_response = await fetch(`${BASE_URL}cms/import-vmi/get_valid_ba_data`);
        // let ba_data = await get_ba_valid_response.json();

        // let store_lookup = Object.fromEntries(ba_data.stores.map(store => [store.code, store.id]));
        // let item_lookup = Object.fromEntries(ba_data.items.map(item => [item.cusitmcde, item.recid]));

        let batchSize = 2000;
        let index = 0;

        function isValidFloat(value) {
            return value !== "" && !isNaN(value) && !isNaN(parseFloat(value));
        }

        function getMonthlyValues(row, type) {
            const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            let values = {};

            months.forEach(month => {
                let key = type === "ta" ? `${month}TA` : month;
                let value = row[key]?.replace(/,/g, "").trim() || "";
                values[`${month.toLowerCase()}_${type}`] = value;
            });

            return values;
        }

        function processBatch() {
            if (index >= data.length) {
                self.postMessage({ invalid: err_counter > 0, errorLogs, valid_data, err_counter });
                return;
            }

            for (let i = 0; i < batchSize && index < data.length; i++, index++) {
                let row = data[index];
                let tr_count = index + 1;
                let invalid = false;

                let payment_group = row["Payment Group"]?.trim() || "";
                let vendor = row["Vendor"]?.trim() || "";
                let overall = row["Overall"]?.trim() || "";
                let kam_kas_kaa = row["KAM/KAS/KAA"]?.trim() || "";
                let sales_group = row["Sales Group"]?.trim() || "";
                let terms = row["Terms"]?.trim() || "";
                let channel = row["Channel"]?.trim() || "";
                let brand = row["Brand"]?.trim() || "";
                let exclusivity = row["Exclusivity"]?.trim() || "";
                let category = row["Category"]?.trim() || "";
                let lmi_code = row["LMI Code"]?.trim() || "";
                let rgdi_code = row["RGDI CODE"]?.trim() || "";
                let customer_sku_code = row["Customer SKU Code"]?.trim() || "";
                let item_description = row["Item Description"]?.trim() || "";
                let item_status = row["Item status"]?.trim() || "";
                let srp = row["SRP"]?.trim() || "";
                let trade_discount = row["Trade Discount"]?.trim() || "";
                let customer_cost = row["Customer Cost"]?.trim() || "";
                let customer_cost_nov = row["Customer Cost (Net of Vat)"]?.trim() || "";

                let monthlyTq = getMonthlyValues(row, "tq");
                let monthlyTa = getMonthlyValues(row, "ta");

                let user_id = row["Created by"]?.trim() || "";
                let date_of_creation = row["Created Date"]?.trim() || "";

                function validateField(value, maxLength, fieldName) {
                    if (value.length > maxLength || value === "") {
                        invalid = true;
                        errorLogs.push(`⚠️ Invalid ${fieldName} at line #: ${tr_count}`);
                        err_counter++;
                    }
                }

                validateField(payment_group, 50, "Payment Group");
                validateField(vendor, 50, "Vendor");
                validateField(overall, 25, "Overall");
                validateField(kam_kas_kaa, 50, "KAM/KAS/KAA");
                validateField(sales_group, 50, "Sales Group");
                validateField(terms, 25, "Terms");
                validateField(channel, 25, "Channel");
                validateField(brand, 50, "Brand");
                validateField(exclusivity, 25, "Exclusivity");
                validateField(category, 25, "Category");
                validateField(lmi_code, 25, "LMI Code");
                validateField(rgdi_code, 25, "RGDI Code");
                validateField(customer_sku_code, 25, "Customer SKU Code");
                validateField(item_description, 500, "Item Description");
                validateField(item_status, 25, "Item Status");
                validateField(trade_discount, 10, "Trade Discount");

                function validateFloatField(value, fieldName) {
                    if (!isValidFloat(value)) {
                        invalid = true;
                        errorLogs.push(`⚠️ Invalid ${fieldName} at line #: ${tr_count}`);
                        err_counter++;
                    }
                }

                function validateFloatFieldNoData(value, fieldName) {
                    if(value){
                        if (!isValidFloat(value)) {
                            invalid = true;
                            errorLogs.push(`⚠️ Invalid ${fieldName} at line #: ${tr_count}`);
                            err_counter++;
                        }                        
                    }

                }

                validateFloatField(srp, "SRP");
                validateFloatField(customer_cost, "Customer Cost");
                validateFloatField(customer_cost_nov, "Customer Cost Net Of Vat");

                Object.entries(monthlyTq).forEach(([key, value]) => {
                    validateFloatFieldNoData(value, `TQ ${key.replace("_tq", "")}`);
                });

                Object.entries(monthlyTa).forEach(([key, value]) => {
                    validateFloatFieldNoData(value, `TA ${key.replace("_ta", "")}`);
                });

                if (!invalid) {
                    valid_data.push({
                        payment_group,
                        vendor,
                        overall,
                        kam_kas_kaa,
                        sales_group,
                        terms,
                        channel,
                        brand,
                        exclusivity,
                        category,
                        lmi_code,
                        rgdi_code,
                        customer_sku_code,
                        item_description,
                        item_status,
                        srp: parseFloat(srp),
                        trade_discount,
                        customer_cost: parseFloat(customer_cost),
                        customer_cost_net_of_vat: parseFloat(customer_cost_nov),
                        ...Object.fromEntries(Object.entries(monthlyTq).map(([k, v]) => [k, parseFloat(v)])),
                        ...Object.fromEntries(Object.entries(monthlyTa).map(([k, v]) => [k, parseFloat(v)])),
                        status: 1,
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
