self.onmessage = async function (e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let errorLogs = [];
    let valid_data = [];
    let err_counter = 0;

    try {
        let get_ba_valid_response = await fetch(`${BASE_URL}cms/global_controller/get_valid_ba_data?brands=1&customer_sku_code_lmi=1&customer_sku_code_rgdi=1`);
        let ba_data = await get_ba_valid_response.json();

        let brand_lookup = createLookup(ba_data.brands, "brand_code", "brand_code");
        let payment_group_lookup = createLookup(ba_data.payment_group, "customer_group_code", "customer_group_code");

        let customer_sku_code_lmi_lookup = ba_data.customer_sku_code_lmi.reduce((acc, item) => {
            acc[item.cusitmcde.toLowerCase()] = item;
            acc[item.itmcde.toLowerCase()] = item;
            return acc;
        }, {});

        let customer_sku_code_rgdi_lookup = ba_data.customer_sku_code_rgdi.reduce((acc, item) => {
            acc[item.cusitmcde.toLowerCase()] = item;
            acc[item.itmcde.toLowerCase()] = item;
            return acc;
        }, {});

        let batchSize = 2000;
        let index = 0;

        function createLookup(records, key1, key2) {
            let lookup = {};
            records.forEach(record => {
                lookup[record[key1].toLowerCase()] = record.id;
                lookup[record[key2].toLowerCase()] = record.id;
            });
            return lookup;
        }

        function normalizeLookup(lookup, skuValue, itemValue, fieldName) {
            let lowerSkuValue = skuValue.toLowerCase();
            let lowerItemValue = itemValue.toLowerCase();

            let item = lookup[lowerSkuValue]; // Check if customer SKU exists

            if (!item || item.itmcde.toLowerCase() !== lowerItemValue) {
                errorLogs.push(`⚠️ Invalid ${fieldName} at line #: ${index + 1}`);
                err_counter++;
                return null;
            }

            return skuValue;
        }

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
                self.postMessage({ invalid, errorLogs, valid_data, err_counter, progress: 100 });
                return;
            }

            let progress = Math.round((index / data.length) * 100);
            self.postMessage({ progress });

            for (let i = 0; i < batchSize && index < data.length; i++, index++) {
                let row = data[index];
                let tr_count = index + 1;
                let invalid = false;

                let vendor = row["Vendor"]?.trim() || "";
                let overall = row["Overall"]?.trim() || "";
                let kam_kas_kaa = row["KAM/KAS/KAA"]?.trim() || "";
                let sales_group = row["Sales Group"]?.trim() || "";
                let terms = row["Terms"]?.trim() || "";
                let channel = row["Channel"]?.trim() || "";
                let exclusivity = row["Exclusivity"]?.trim() || "";
                let category = row["Category"]?.trim() || "";
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

                validateField(vendor, 50, "Vendor");
                validateField(overall, 25, "Overall");
                validateField(kam_kas_kaa, 50, "KAM/KAS/KAA");
                validateField(sales_group, 50, "Sales Group");
                validateField(terms, 25, "Terms");
                validateField(channel, 25, "Channel");
                validateField(exclusivity, 25, "Exclusivity");
                validateField(category, 25, "Category");
                validateField(customer_sku_code, 25, "Customer SKU Code");
                validateField(item_description, 500, "Item Description");
                validateField(item_status, 25, "Item Status");
                validateField(trade_discount, 10, "Trade Discount");

                function validateFloatField(value, fieldName) {
                    if (!isValidFloat(value)) {
                        invalid = true;
                        errorLogs.push(`⚠️ Invalid ${fieldName} at line #: ${tr_count}`);
                        err_counter++;
                    } else {
                        let num = parseFloat(value);

                        if (num.toString().includes(".")) {
                            let decimalPlaces = num.toString().split(".")[1].length;
                            if (decimalPlaces > 2) {
                                num = parseFloat(num.toFixed(2));
                            }
                        }

                        return num;
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

                srp = validateFloatField(srp, "SRP") ?? srp;
                customer_cost = validateFloatField(customer_cost, "Customer Cost") ?? customer_cost;
                customer_cost_nov = validateFloatField(customer_cost_nov, "Customer Cost Net Of Vat") ?? customer_cost_nov;

                // Apply rounding to all monthly values
                Object.entries(monthlyTq).forEach(([key, value]) => {
                    if (value) monthlyTq[key] = validateFloatField(value, `TQ ${key.replace("_tq", "")}`);
                });

                Object.entries(monthlyTa).forEach(([key, value]) => {
                    if (value) monthlyTa[key] = validateFloatField(value, `TA ${key.replace("_ta", "")}`);
                });


                function normalizeLookup_single(lookup, key, fieldName) {
                    let lowerKey = key.toLowerCase();
                    if (lowerKey in lookup) {
                        return key;
                    } else {
                        invalid = true;
                        errorLogs.push(`⚠️ Invalid ${fieldName} at line #: ${tr_count}`);
                        err_counter++;
                        return key; 
                    }
                }

                let payment_group = normalizeLookup_single(payment_group_lookup, row["Payment Group"]?.trim() || "", "Payment Group");
                let brand = normalizeLookup_single(brand_lookup, row["Brand"]?.trim() || "", "Brand");
                let lmi_code = normalizeLookup(customer_sku_code_lmi_lookup, row["Customer SKU Code"]?.trim() || "", row["LMI Code"]?.trim() || "", "LMI Code");
                let rgdi_code = normalizeLookup(customer_sku_code_rgdi_lookup, row["Customer SKU Code"]?.trim() || "", row["RGDI Code"]?.trim() || "", "RGDI Code");
                                
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
                        srp: srp,
                        trade_discount,
                        customer_cost: parseFloat(customer_cost),
                        customer_cost_net_of_vat: parseFloat(customer_cost_nov),
                        ...Object.fromEntries(Object.entries(monthlyTq).map(([k, v]) => [k, v])),
                        ...Object.fromEntries(Object.entries(monthlyTa).map(([k, v]) => [k, v])),
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
