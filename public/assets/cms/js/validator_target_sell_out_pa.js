self.onmessage = async function (e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let errorLogs = [];
    let valid_data = [];
    let err_counter = 0;
    let invalid = false;
    const ERROR_LOG_LIMIT = 1000;

    try {
        const get_ba_valid_response = await fetch(`${BASE_URL}cms/global_controller/get_valid_ba_data?brandssopa=1&customer_sku_code_lmi_per_account=1&customer_sku_code_rgdi_per_account=1&payment_group_lmi=1&payment_group_rgdi=1`);
        const ba_data = await get_ba_valid_response.json();

        const createLookup = (records, key1, key2) => {
            const lookup = {};
            records.forEach(record => {
                lookup[String(record[key1]).toLowerCase()] = record.id;
                lookup[String(record[key2]).toLowerCase()] = record.id;
            });
            return lookup;
        };

        let payment_group_lmi_look_up = {};
        ba_data.payment_group_lmi.forEach(payment_group_lmi => payment_group_lmi_look_up[payment_group_lmi.customer_group_code.toLowerCase()] = payment_group_lmi.id);

        let payment_group_rgdi_look_up = {};
        ba_data.payment_group_rgdi.forEach(payment_group_rgdi => payment_group_rgdi_look_up[payment_group_rgdi.customer_group_code.toLowerCase()] = payment_group_rgdi.id);


        let customer_sku_code_lmi_per_account_lookup = {};
        ba_data.customer_sku_code_lmi_per_account.forEach(customer_sku_code_lmi_per_account => customer_sku_code_lmi_per_account_lookup[customer_sku_code_lmi_per_account.itmcde.toLowerCase()] = customer_sku_code_lmi_per_account.recid);

        let customer_sku_code_rgdi_per_account_lookup = {};
        ba_data.customer_sku_code_rgdi_per_account.forEach(customer_sku_code_rgdi_per_account => customer_sku_code_rgdi_per_account_lookup[customer_sku_code_rgdi_per_account.itmcde.toLowerCase()] = customer_sku_code_rgdi_per_account.recid);
 
        const brand_lookup = createLookup(ba_data.brandssopa, "brand_code", "brand_code");
        const isValidFloat = value => value !== "" && !isNaN(value) && !isNaN(parseFloat(value));

        const getMonthlyValues = (row, type) => {
            const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            const values = {};
            months.forEach(month => {
                const key = type === "ta" ? `${month}TA` : month;
                const value = row[key]?.replace(/,/g, "").trim() || "";
                values[`${month.toLowerCase()}_${type}`] = value;
            });
            return values;
        };

        const normalizeLookup = (lookup, skuValue, itemValue, fieldName, tr_count) => {
            const item = lookup[skuValue.toLowerCase()];
            if (!item || item.itmcde.toLowerCase() !== itemValue.toLowerCase()) {
                if (errorLogs.length < ERROR_LOG_LIMIT) errorLogs.push(`⚠️ Invalid ${fieldName} at line #: ${tr_count}`);
                err_counter++;
                return null;
            }
            return skuValue;
        };

        const normalizeLookupSingle = (lookup, key, fieldName, tr_count) => {
            if (lookup[key.toLowerCase()]) return key;
            if (errorLogs.length < ERROR_LOG_LIMIT) errorLogs.push(`⚠️ Invalid ${fieldName} at line #: ${tr_count}`);
            err_counter++;
            return key;
        };

        const validateFloatField = (value, fieldName, tr_count) => {
            if (!isValidFloat(value)) {
                if (errorLogs.length < ERROR_LOG_LIMIT) errorLogs.push(`⚠️ Invalid ${fieldName} at line #: ${tr_count}`);
                err_counter++;
                return null;
            }
            let num = parseFloat(value);
            return parseFloat(num.toFixed(2));
        };

        const batchSize = 2000;
        let index = 0;

        const processBatch = () => {
            if (index >= data.length) {
                self.postMessage({ invalid, errorLogs, valid_data, err_counter });
                return;
            }

            for (let i = 0; i < batchSize && index < data.length; i++, index++) {
                const row = data[index];
                const tr_count = index + 1;

                const getVal = key => row[key]?.trim() || "";

                payment_group = getVal("Payment Group");
                const vendor = getVal("Vendor");
                const overall = getVal("Overall");
                const kam_kas_kaa = getVal("KAM/KAS/KAA");
                const sales_group = getVal("Sales Group");
                const terms = getVal("Terms");
                const channel = getVal("Channel");
                const exclusivity = getVal("Exclusivity");
                const category = getVal("Category");
                const customer_sku_code = getVal("Customer SKU Code");
                const item_description = getVal("Item Description");
                const item_status = getVal("Item status");
                let srp = getVal("SRP");
                const trade_discount = getVal("Trade Discount");
                let customer_cost = getVal("Customer Cost");
                let customer_cost_nov = getVal("Customer Cost (Net of Vat)");
                const user_id = getVal("Created by");
                const date_of_creation = getVal("Created Date");
                const monthlyTq = getMonthlyValues(row, "tq");
                const monthlyTa = getMonthlyValues(row, "ta");
                lmi_code = getVal("LMI Code");
                rgdi_code = getVal("RGDI Code");

                function addErrorLog(message) {
                    invalid = true;
                    err_counter++;
                    if (errorLogs.length < ERROR_LOG_LIMIT) {
                        errorLogs.push(`⚠️ ${message} at line #: ${tr_count}`);
                    }
                }

                const requiredFields = [
                    { val: vendor, name: "Vendor" },
                    { val: overall, name: "Overall" },
                    { val: kam_kas_kaa, name: "KAM/KAS/KAA" },
                    { val: sales_group, name: "Sales Group" },
                    { val: terms, name: "Terms" },
                    { val: channel, name: "Channel" },
                    { val: item_description, name: "Item Description" },
                    { val: item_status, name: "Item Status" }
                ];

                requiredFields.forEach(({ val, name }) => {
                    if (!val && errorLogs.length < ERROR_LOG_LIMIT) {
                        errorLogs.push(`⚠️ Invalid ${name} at line #: ${tr_count}`);
                        invalid = true;
                        err_counter++;
                    }
                });
                if(srp){
                    srp = validateFloatField(srp, "SRP", tr_count) ?? srp;    
                }

                if(customer_cost){
                    customer_cost = validateFloatField(customer_cost, "Customer Cost", tr_count) ?? customer_cost;
                }
                if(customer_cost_nov){
                    customer_cost_nov = validateFloatField(customer_cost_nov, "Customer Cost Net Of Vat", tr_count) ?? customer_cost_nov;
                }
                
                Object.entries(monthlyTq).forEach(([k, v]) => {
                    if (v) monthlyTq[k] = validateFloatField(v, `TQ ${k.replace("_tq", "")}`, tr_count);
                });

                Object.entries(monthlyTa).forEach(([k, v]) => {
                    if (v) monthlyTa[k] = validateFloatField(v, `TA ${k.replace("_ta", "")}`, tr_count);
                });

                
                const brand = normalizeLookupSingle(brand_lookup, getVal("Brand"), "Brand", tr_count);
                
                if(lmi_code && !rgdi_code){
                        lmi_code = customer_sku_code_lmi_per_account_lookup[lmi_code.toLowerCase()] || addErrorLog("Item Code does not exist on Customer Pricelist.");
                        payment_group = payment_group_lmi_look_up[payment_group.toLowerCase()] || addErrorLog("Invalid Payment Group");
                }else if(rgdi_code && !lmi_code){
                        rgdi_code = customer_sku_code_rgdi_per_account_lookup[rgdi_code.toLowerCase()] || addErrorLog("Item Code does not exist on Customer Pricelist.");
                        payment_group = payment_group_rgdi_look_up[payment_group.toLowerCase()] || addErrorLog("Invalid Payment Group");
                }else if(rgdi_code && lmi_code){
                    if(rgdi_code !== lmi_code){
                        addErrorLog("RGDI/LMI Code doesn't matched");
                    }else{
                        lmi_code = customer_sku_code_lmi_per_account_lookup[lmi_code.toLowerCase()] || addErrorLog("Item Code does not exist on Customer Pricelist.");
                        payment_group = payment_group_lmi_look_up[payment_group.toLowerCase()] || addErrorLog("Invalid Payment Group");
                    }
                }
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
                        srp,
                        trade_discount,
                        customer_cost: parseFloat(customer_cost),
                        customer_cost_net_of_vat: parseFloat(customer_cost_nov),
                        ...monthlyTq,
                        ...monthlyTa,
                        status: 1,
                        created_by: user_id,
                        created_date: date_of_creation
                    });
                }
            }

            if (index % 100000 === 0) {
                self.postMessage({ progress: Math.round((index / data.length) * 100), err_counter });
            }

            setTimeout(processBatch, 0);
        };

        processBatch();
    } catch (error) {
        self.postMessage({ invalid: true, errorLogs: [`Validation failed: ${error.message}`], err_counter: 1 });
    }
};