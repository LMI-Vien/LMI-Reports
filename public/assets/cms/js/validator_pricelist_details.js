self.onmessage = async function(e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let invalid = false;
    let errorLogs = [];
    let unique_description = new Set();
    let valid_data = [];
    let err_counter = 0;
    let parentId = e.data.pricelistId;
    let paymentGroup = e.data.customerPaymentGroup;

    try {
        let get_ba_valid_response = await fetch(`${BASE_URL}cms/global_controller/get_valid_ba_data?brands=1&label_category=1&classification=1&label_type=1&sub_classification=1&item_department=1&item_merchandise_category=1&itemfile_lmi=1&itemfile_rgdi=1`);
        let ba_data = await get_ba_valid_response.json();
        // console.log(ba_data);
        // return;

        let brand_records = ba_data.brands;
        let brand_lookup = {};
        brand_records.forEach(brand => brand_lookup[brand.brand_description] = brand.id);
        // console.log(brand_records);
        // return;

        let brand_label_type_records = ba_data.label_type;
        let brand_label_type_lookup = {};
        brand_label_type_records.forEach(brand_label_type => brand_label_type_lookup[brand_label_type.label] = brand_label_type.id);
        // console.log(brand_label_type_records);
        // return;


        let label_category_records = ba_data.label_category;
        let label_category_lookup = {};
        label_category_records.forEach(label_category => label_category_lookup[label_category.code] = label_category.id);
        // console.log(label_category_records);
        // return;

        let classification_records = ba_data.classification;
        let classification_lookup = {};
        classification_records.forEach(classification => classification_lookup[classification.item_class_code] = classification.id);
        // console.log(classification_records);
        // return;

        let sub_classification_records = ba_data.sub_classification;
        let sub_classification_lookup = {};
        sub_classification_records.forEach(sub_classification => sub_classification_lookup[sub_classification.item_sub_class_code] = sub_classification.id);
        // console.log(sub_classification_records);
        // return;

        let item_department_records = ba_data.item_department;
        let item_department_lookup = {};
        item_department_records.forEach(item_department => item_department_lookup[item_department.item_department_code] = item_department.id);
        // console.log(item_department_records);
        // return;

        let item_merch_cat_records = ba_data.item_merchandise_category;
        let item_merch_cat_lookup = {};
        item_merch_cat_records.forEach(item_merchandise_category => item_merch_cat_lookup[item_merchandise_category.item_mech_cat_code] = item_merchandise_category.id);
        // console.log(item_merch_cat_records);
        // return;

        const itemsLmi  = Array.isArray(ba_data.itemfile_lmi)  ? ba_data.itemfile_lmi  : [];
        const itemsRgdi = Array.isArray(ba_data.itemfile_rgdi) ? ba_data.itemfile_rgdi : [];

        function norm(s) {
            return (s || '').toString().replace(/\s+/g, ' ').trim().toLowerCase();
        }

        // LMI sets
        const lmiCodeSet = new Set();
        const lmiDescSet = new Set();
        const lmiPairSet = new Set();
        for (const item of itemsLmi) {
            const code = norm(item.itmcde);
            const description = norm(item.itmdsc);
            if (code) lmiCodeSet.add(code);
            if (description) lmiDescSet.add(description);
            if (code && description) lmiPairSet.add(`${code}|${description}`);
        }

        // RGDI sets
        const rgdiCodeSet = new Set();
        const rgdiDescSet = new Set();
        const rgdiPairSet = new Set();
        for (const item of itemsRgdi) {
            const code = norm(item.itmcde);
            const description = norm(item.itmdsc);
            if (code) rgdiCodeSet.add(code);
            if (description) rgdiDescSet.add(description);
            if (code && description) rgdiPairSet.add(`${code}|${description}`);
        }

        // Change this to true if the item must exist in BOTH sources
        const requireInBoth = false;

        function formatDateForDB(dateStr) {
            let [month, day, year] = dateStr.split('/');
            return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
        }

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
                let rowInvalid = false;

                let brandId = row["Brand"] ? row["Brand"].trim() : "";
                let brandLabelType = row["Brand Label Type"] ? row["Brand Label Type"].trim() : "";
                let labelTypeCategory = row["Label Type Category"] ? row["Label Type Category"].trim() : "";
                let category1 = row["Category 1 (Item Classification MF)"] ? row["Category 1 (Item Classification MF)"].trim() : "";
                let category2 = row["Category 2 (Sub Classification MF)"] ? row["Category 2 (Sub Classification MF)"].trim() : "";
                let category3 = row["Category 3 (Department MF)"] ? row["Category 3 (Department MF)"].trim() : "";
                let category4 = row["Category 4 (Merch. Category MF)"] ? row["Category 4 (Merch. Category MF)"].trim() : "";
                let itemCode = row["Item Code"] ? row["Item Code"].trim() : "";
                let itemDesc = row["Item Description"] ? row["Item Description"].trim() : "";
                let customerItemCode = row["Customer Item Code"] ? row["Customer Item Code"].trim() : "";
                let uom = row["UOM"] ? row["UOM"].trim() : "";
                let sellingPrice = row["Selling Price"] ? row["Selling Price"].trim() : "";
                let discountInPercent = row["Discount in Percent"] ? row["Discount in Percent"].trim() : "";
                let effectivityDate = row["Effectivity Date"] ? row["Effectivity Date"].trim() : "";
                let status = row["Status"] ? row["Status"].trim().toLowerCase() : "";
                let user_id = row["Created by"] ? row["Created by"].trim() : "";
                let date_of_creation = row["Created Date"] ? row["Created Date"].trim() : "";

                const nCode = norm(itemCode);
                const nDesc = norm(itemDesc);

                // netPrice
                if (discountInPercent < 0) discountInPercent = 0;
                if (discountInPercent > 100) discountInPercent = 100;
                
                let netPrice = sellingPrice * (1 - discountInPercent / 100);
                // netPrice

                if (!["active", "inactive"].includes(status)) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Status at line #: ${tr_count}`);
                    err_counter++;
                }

                let dateObj = new Date(effectivityDate);
                if (isNaN(dateObj.getTime())) {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Deployment Date at line #: ${tr_count}`);
                    err_counter++;
                }

                if (!isNaN(dateObj.getTime())) {
                    const today = new Date();
                    const todayMidnight = new Date(today.getFullYear(), today.getMonth(), today.getDate()).getTime();
                    const candMidnight  = new Date(dateObj.getFullYear(), dateObj.getMonth(), dateObj.getDate()).getTime();

                    if (candMidnight < todayMidnight) {
                        rowInvalid = true;
                        invalid = true;        
                        err_counter++;
                        errorLogs.push(`⚠️ Effectivity Date cannot be in the past at line #: ${tr_count}`);
                    }
                }

                if (effectivityDate) {
                    effectivityDate = formatDateForDB(effectivityDate);
                }


                let normalized_brand_lookup = {};
                for (let key in brand_lookup) {
                    normalized_brand_lookup[key.toLowerCase()] = brand_lookup[key];
                }

                let brand_lower = brandId.toLowerCase();
                if (brand_lower in normalized_brand_lookup) {
                    brandId = normalized_brand_lookup[brand_lower];
                } else {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Brand Description at line #: ${tr_count}`);
                    err_counter++;
                }

                let normalize_brand_label_type_records = {};
                for (let key in brand_label_type_lookup) {
                    normalize_brand_label_type_records[key.toLowerCase()] = brand_label_type_lookup[key];
                }

                let brand_label_type_records_lower = brandLabelType.toLowerCase();
                if (brand_label_type_records_lower in normalize_brand_label_type_records) {
                    brandLabelType = normalize_brand_label_type_records[brand_label_type_records_lower];
                } else {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Brand Label Type at line #: ${tr_count}`);
                    err_counter++;
                }

                let normalize_label_category_records = {};
                for (let key in label_category_lookup) {
                    normalize_label_category_records[key.toLowerCase()] = label_category_lookup[key];
                }

                let label_category_records_lower = labelTypeCategory.toLowerCase();
                if (label_category_records_lower in normalize_label_category_records) {
                    labelTypeCategory = normalize_label_category_records[label_category_records_lower];
                } else {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Label Type Category at line #: ${tr_count}`);
                    err_counter++;
                }

                let normalize_category1_records = {};
                for (let key in classification_lookup) {
                    normalize_category1_records[key.toLowerCase()] = classification_lookup[key];
                }

                let category1_lower = category1.toLowerCase();
                if (category1_lower in normalize_category1_records) {
                    category1 = normalize_category1_records[category1_lower];
                } else {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Category 1 (Item Classification) at line #: ${tr_count}`);
                    err_counter++;
                }

                let normalize_category2_records = {};
                for (let key in sub_classification_lookup) {
                    normalize_category2_records[key.toLowerCase()] = sub_classification_lookup[key];
                }

                let category2_lower = category2.toLowerCase();
                if (category2_lower in normalize_category2_records) {
                    category2 = normalize_category2_records[category2_lower];
                } else {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Category 2 (Sub Classification) at line #: ${tr_count}`);
                    err_counter++;
                }

                let normalize_category3_records = {};
                for (let key in item_department_lookup) {
                    normalize_category3_records[key.toLowerCase()] = item_department_lookup[key];
                }

                let category3_lower = category3.toLowerCase();
                if (category3_lower in normalize_category3_records) {
                    category3 = normalize_category3_records[category3_lower];
                } else {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Category 3 (Department) at line #: ${tr_count}`);
                    err_counter++;
                }

                let normalize_category4_records = {};
                for (let key in item_merch_cat_lookup) {
                    normalize_category4_records[key.toLowerCase()] = item_merch_cat_lookup[key];
                }

                let normalize4_lower = category4.toLowerCase();
                if (normalize4_lower in normalize_category4_records) {
                    category4 = normalize_category4_records[normalize4_lower];
                } else {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Category 4 (Merch. Category) at line #: ${tr_count}`);
                    err_counter++;
                }

                // Does it exist in LMI?
                let inLmi = false;
                    if (nCode && nDesc) {
                        inLmi = lmiPairSet.has(nCode + '|' + nDesc);
                    } else if (nCode) {
                        inLmi = lmiCodeSet.has(nCode);
                    } else if (nDesc) {
                        inLmi = lmiDescSet.has(nDesc);
                }

                // Does it exist in RGDI?
                let inRgdi = false;
                    if (nCode && nDesc) {
                        inRgdi = rgdiPairSet.has(nCode + '|' + nDesc);
                    } else if (nCode) {
                        inRgdi = rgdiCodeSet.has(nCode);
                    } else if (nDesc) {
                        inRgdi = rgdiDescSet.has(nDesc);
                }

                // Final existence rule: either source (default) or both if toggled
                const exists = requireInBoth ? (inLmi && inRgdi) : (inLmi || inRgdi);

                if (!exists) {
                    rowInvalid = true;
                    invalid = true;
                    err_counter++;
                    errorLogs.push(`⚠️ Item not found in LMI or RGDI at line #${tr_count}`);
                }

                if (!rowInvalid) {
                    valid_data.push({
                        pricelist_id: parentId,
                        customer_payment_group: paymentGroup,
                        brand_id: brandId,
                        brand_label_type_id: brandLabelType,
                        label_type_category_id: labelTypeCategory,
                        category_1_id: category1,
                        category_2_id: category2,
                        category_3_id: category3,
                        category_4_id: category4,
                        item_code: itemCode,
                        item_description: itemDesc,
                        cust_item_code: customerItemCode,
                        uom: uom,
                        selling_price: sellingPrice,
                        disc_in_percent: discountInPercent,
                        net_price: netPrice,
                        effectivity_date: effectivityDate,
                        status: status === "active" ? 1 : 0,                    
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