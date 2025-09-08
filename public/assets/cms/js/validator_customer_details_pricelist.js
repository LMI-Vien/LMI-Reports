self.onmessage = async function(e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;
    let invalid = false;
    let errorLogs = [];
    let unique_description = new Set();
    let valid_data = [];
    let err_counter = 0;
    let parentId = e.data.parentId;

    try {
        let get_ba_valid_response = await fetch(`${BASE_URL}cms/global_controller/get_valid_ba_data?brands=1&label_category=1&item_classification=1`);
        let ba_data = await get_ba_valid_response.json();
        // console.log(ba_data);
        // return;

        let brand_records = ba_data.brands;
        let brand_lookup = {};
        brand_records.forEach(brand => brand_lookup[brand.brand_description] = brand.id);
        // console.log(brand_records);
        // return;

        let label_category_records = ba_data.label_category;
        let label_category_lookup = {};
        label_category_records.forEach(label_category => label_category_lookup[label_category.code] = label_category.id);
        // console.log(label_category_records);
        // return;

        let item_classification_records = ba_data.item_classification;
        let item_classification_lookup = {};
        item_classification_records.forEach(item_classification => item_classification_lookup[item_classification.item_class_code] = item_classification.id);
        // console.log(label_category_records);
        // return;


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

                let brandId = row["Brand"] ? row["Brand"].trim() : "";
                let brandLabelType = row["Brand Label Type"] ? row["Brand Label Type"].trim() : "";
                let labelTypeCategory = row["Label Type Category"] ? row["Label Type Category"].trim() : "";
                let category1 = row["Category 1 (Item Class MF)"] ? row["Category 1 (Item Class MF)"].trim() : "";
                let category2 = row["Category 2 (Sub Class MF)"] ? row["Category 2 (Sub Class MF)"].trim() : "";
                let category3 = row["Category 3 (Department MF)"] ? row["Category 3 (Department MF)"].trim() : "";
                let category4 = row["Category 4 (Merch. Category MF)"] ? row["Category 4 (Merch. Category MF)"].trim() : "";
                let itemCode = row["Item Code"] ? row["Item Code"].trim() : "";
                let itemDesc = row["Item Description"] ? row["Item Description"].trim() : "";
                let customerItemCode = row["Customer Item Code"] ? row["Customer Item Code"].trim() : "";
                let uom = row["UOM"] ? row["UOM"].trim() : "";
                let sellingPrice = row["Selling Price"] ? row["Selling Price"].trim() : "";
                let discountInPercent = row["Discount in Percent"] ? row["Discount in Percent"].trim() : "";
                let effectivityDate = row["Effectivity Date"] ? row["Effectivity Date"].trim() : "";
                let status = row["Status"] ? row["Status"].trim() : "";
                let user_id = row["Created by"] ? row["Created by"].trim() : "";
                let date_of_creation = row["Created Date"] ? row["Created Date"].trim() : "";

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
                for (let key in item_classification_lookup) {
                    normalize_category1_records[key.toLowerCase()] = item_classification_lookup[key];
                }

                let category1_lower = category1.toLowerCase();
                if (category1_lower in normalize_category1_records) {
                    category1 = normalize_category1_records[category1_lower];
                } else {
                    invalid = true;
                    errorLogs.push(`⚠️ Invalid Item Classification at line #: ${tr_count}`);
                    err_counter++;
                }

                if (!invalid) {
                    valid_data.push({
                        customer_id: parentId,
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