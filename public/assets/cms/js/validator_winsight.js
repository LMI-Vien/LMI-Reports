self.onmessage = async function(e) {
    let data = e.data.data;
    let BASE_URL = e.data.base_url;

    let invalid = false;
    let errorLogs = [];
    let valid_data = [];
    let err_counter = 0;
    const ERROR_LOG_LIMIT = 1000; // Reduce error log limit
    const BATCH_SIZE = 1000; // Reduce batch size
    let index = 0;

    try {
        let firstYear = null;
        let firstMonth = null;
        let firstWeek = null;

        let get_ba_valid_response = await fetch(
            `${BASE_URL}cms/global_controller/get_valid_ba_data?`
            +`main_pricelist=1`
            +`&store_segment=1`
            +`&brands=1`
            +`&classification=1`
            +`&sub_classification=1`
            +`&item_department=1`
            +`&item_merchandise_category=1`
            +`&itemfile_lmi=1`
            +`&itemfile_rgdi=1`
            +`&label_type=1`
            +`&label_category=1`
            +`&years=1`
            +`&months=1`
        );
        let ba_data = await get_ba_valid_response.json();

        let main_pricelist_lookup = {};
        ba_data.main_pricelist.forEach(
            main_pricelist => main_pricelist_lookup[main_pricelist.cust_item_code.toLowerCase()] = main_pricelist.id
        ); 
        // kukuhain yung SFA Pricelist ID (mother pricelist)
        let reverse_main_pricelist_lookup = {};
        ba_data.main_pricelist.forEach(
            main_pricelist => reverse_main_pricelist_lookup[main_pricelist.id] = main_pricelist
        ); 
        // kukuhain yung SFA Pricelist details based sa ID
        // para ma check kung existing ba sa SFA Pricelist yung user input

        let store_segment_lookup = {};
        ba_data.store_segment.forEach(
            store_segment => store_segment_lookup[store_segment.description.toLowerCase()] = store_segment.id
        );

        let brands_lookup = {};
        ba_data.brands.forEach(
            brand => brands_lookup[brand.brand_description.toLowerCase()] = brand.id
        );

        let classification_lookup = {};
        ba_data.classification.forEach(
            classification => classification_lookup[classification.item_class_description.toLowerCase()] = classification.id
        );

        let sub_classification_lookup = {};
        ba_data.sub_classification.forEach(
            sub_classification => sub_classification_lookup[sub_classification.item_sub_class_description.toLowerCase()] = sub_classification.id
        );

        let item_department_lookup = {};
        ba_data.item_department.forEach(
            item_department => item_department_lookup[item_department.item_department_code.toLowerCase()] = item_department.id
        );

        let item_merchandise_category_lookup = {};
        ba_data.item_merchandise_category.forEach(
            item_merchandise_category => 
                item_merchandise_category_lookup[item_merchandise_category.item_mech_cat_code.toLowerCase()] = item_merchandise_category.id
        );

        let itemfile_lmi_lookup = {};
        ba_data.itemfile_lmi.forEach(
            itemfile_lmi => itemfile_lmi_lookup[itemfile_lmi.itmcde.toLowerCase()] = itemfile_lmi.recid
        );
        let itemfile_rgdi_lookup = {};
        ba_data.itemfile_rgdi.forEach(
            itemfile_rgdi => itemfile_rgdi_lookup[itemfile_rgdi.itmcde.toLowerCase()] = itemfile_rgdi.recid
        ); 
        // tracc data kaya naka recid

        let label_type_lookup = {};
        ba_data.label_type.forEach(
            label_type => label_type_lookup[label_type.id] = label_type.label.toLowerCase()
        );

        let label_category_lookup = {};
        ba_data.label_category.forEach(
            label_category => label_category_lookup[label_category.id] = label_category.description.toLowerCase()
        );

        let year_lookup = {};
        ba_data.years.forEach(
            years => year_lookup[years.year.toLowerCase()] = years.id 
        )
        // need i check kung na registered na ba yung year sa masterfile

        let month_lookup = {};
        ba_data.months.forEach(
            months => month_lookup[months.id] = months.month.toLowerCase() 
        )


        function processBatch() {
            if (index >= data.length) {
                self.postMessage({ invalid, errorLogs, valid_data, err_counter });
                return;
            }

            for (let i = 0; i < BATCH_SIZE && index < data.length; i++, index++) {
                let row = data[index];
                let file_name = row["file_name"];
                let line_number = row["line_number"];
                
                let bu_name = row["bu_name"];
                let supplier = row["supplier"];

                let sfa_pricelist = null; 
                // field_name -> from: table_name -> table_name na pinagkukuhaan ng field ID
                let product_id = row["product_id"]; 
                // cust_item_code -> tbl_main_pricelist
                let product_name = row["product_name"];
                if (!product_id) {
                    addErrorLog("Product ID is missing or empty");
                } else if (main_pricelist_lookup[product_id] === undefined) {
                    addErrorLog("Product ID does not exist in SFA Pricelist: " + product_id);
                } else {
                    sfa_pricelist = reverse_main_pricelist_lookup[main_pricelist_lookup[product_id]];
                }

                let brand_name = row["brand_name"]; 
                // brand_id -> tbl_main_pricelist -> tbl_brand
                let brand_id = validateField(
                    row["brand_name"], "Brand Name", brands_lookup, sfa_pricelist, "brand_id", product_id
                );
                
                let cat_1 = row["cat_1"]; 
                // category_1_id -> tbl_main_pricelist -> tbl_classification
                let cat_1_id = validateField(
                    row["cat_1"], "Category 1 (Item Classification)", classification_lookup, sfa_pricelist, "category_1_id", product_id
                );

                let cat_2 = row["cat_2"];
                // category_2_id -> tbl_main_pricelist -> tbl_sub_classification
                let cat_2_id = validateField(
                    row["cat_2"], "Category 2 (Item Sub Classification)", sub_classification_lookup, sfa_pricelist, "category_2_id", product_id
                );

                let cat_3 = row["cat_3"]; 
                // category_3_id -> tbl_main_pricelist -> tbl_item_department
                let cat_3_id = validateField(
                    row["cat_3"], "Category 3 (Item Department)", item_department_lookup, sfa_pricelist, "category_3_id", product_id
                );

                let cat_4 = row["cat_4"]; 
                // category_4_id -> tbl_main_pricelist -> tbl_item_merchandise_category
                let cat_4_id = validateField(
                    row["cat_4"], "Category 4 (Item Merchandise Category)", item_merchandise_category_lookup, sfa_pricelist, "category_4_id", product_id
                );

                let year = parseInt(row["year"], 10);
                let month = parseInt(row["month"], 10);
                let week = row["week"];
                let date = row["date"];

                if (isNaN(year) || year_lookup[year] === undefined) {
                    addErrorLog("Year unregistered in masterfile: "+ row["year"]);
                }
                if (isNaN(month) || month_lookup[month] === undefined) {
                    addErrorLog("Invalid Month: "+ row["month"]);
                }

                if (!isWeekAligned(year, month, week)) {
                    addErrorLog(`Invalid: Week ${week} does not align with Year ${year}, Month ${month}`);
                }

                if (firstYear === null) {
                    firstYear = year;
                } else if (year !== firstYear) {
                    addErrorLog(`Year mismatch: expected ${firstYear} but got ${year}`);
                }
                if (firstMonth === null) {
                    firstMonth = month;
                } else if (month !== firstMonth) {
                    addErrorLog(`Month mismatch: expected ${firstMonth} but got ${month}`);
                }
                if (firstWeek === null) {
                    firstWeek = week;
                } else if (week !== firstWeek) {
                    addErrorLog(`Week mismatch: expected ${firstWeek} but got ${week}`);
                }
                
                let online_offline = row["online_offline"];
                let store_format = row["store_format"];
                let store_segment = row["store_segment"];
                let store_segment_id = store_segment && store_segment_lookup[store_segment.toLowerCase()];

                if (!store_segment) {
                    addErrorLog("Store Segment cannot be empty!");
                } else if (!store_segment_id) {
                    addErrorLog("Store Segment not existing in masterfile: "+ store_segment);
                }

                let gross_sales = validateNumber(row["gross_sales"], "Gross Sales");
                let net_sales   = validateNumber(row["net_sales"], "Net Sales");
                // i sasave to pero hindi ito yung pagbabasehan sa calculation ng amount
                // yung net sales per pcs galing sa SFA pricelist
                let sales_qty = row["sales_qty"];
                let qty = Number(sales_qty);
                if (!Number.isInteger(qty)) {
                    addErrorLog("Sales Quantity must be a whole number: " + sales_qty);
                }
                let barcode = row["barcode"];

                let item_code = null;
                let brand_label_type = null;
                let net_price_per_pcs= null;
                let amount = null;
                let label_type_category = null;
                let brand_label_type_id = null;
                let label_type_category_id = null;

                if (sfa_pricelist !== null) {
                    item_code = sfa_pricelist["item_code"]; 
                    // item_code -> tbl_main_pricelist -> tbl_itemfile_lmi / tbl_itemfile_rgdi
                    if (
                        itemfile_lmi_lookup[item_code.toLowerCase()] === undefined &&
                        itemfile_rgdi_lookup[item_code.toLowerCase()] === undefined
                    ) {
                        addErrorLog("Item Code not found in both Itemfile LMI and RGDI: "+ item_code);
                    }

                    brand_label_type_id = sfa_pricelist["brand_label_type_id"]; 
                    // brand_label_type_id -> tbl_main_pricelist -> tbl_brand_label_type
                    if (label_type_lookup[brand_label_type_id] == undefined) {
                        addErrorLog("Label Type not found: "+ brand_label_type_id);
                    } else {
                        brand_label_type = label_type_lookup[brand_label_type_id]
                    }

                    net_price_per_pcs = validateNumber(sfa_pricelist["net_price"], "Net Price");
                    // net_price -> tbl_main_pricelist -> net_price = selling_price * (1 - disc_in_percent/100)
                    sales_qty         = validateNumber(sales_qty, "Sales Qty");

                    if (sales_qty !== null && net_price_per_pcs !== null) {
                        amount = validateNumber(sales_qty * net_price_per_pcs, "Amount");
                    } else {
                        addErrorLog("Cannot compute amount: missing Sales Qty or Net Price");
                    }

                    label_type_category_id = sfa_pricelist["label_type_category_id"]; 
                    // label_type_category_id -> tbl_main_pricelist -> tbl_label_category_list
                    if (label_category_lookup[label_type_category_id] == undefined) {
                        addErrorLog("Label Category not found: "+ label_type_category_id);
                    } else {
                        label_type_category = label_category_lookup[label_type_category_id]
                    }
                }

                valid_data.push({
                    file_name, line_number,
                    bu_name, supplier,
                    brand_name, product_id, product_name,
                    cat_1, cat_2, cat_3, cat_4,
                    year, month, week, date,
                    online_offline, store_format,
                    store_segment, gross_sales, net_sales, sales_qty, barcode,
                    brand_id, store_segment_id, 
                    cat_1_id, cat_2_id, cat_3_id, cat_4_id,
                    brand_label_type_id, label_type_category_id,
                    item_code, brand_label_type, net_price_per_pcs, amount, label_type_category
                });
            }

            if (index % 100000 === 0) {
                self.postMessage({ progress: Math.round((index / data.length) * 100), err_counter });
            }

            setTimeout(processBatch, 0);
        }

        function validateNumber(value, fieldName) {
            let num = Number(value);

            if (isNaN(num)) {
                addErrorLog(`${fieldName} must be a valid number: ${value}`);
                return null;
            }

            return parseFloat(num.toFixed(2));
        }

        function isWeekAligned(year, month, weekCode) {
            // weekCode = 202528 changed to year 2025, week 28
            const weekYear = Math.floor(weekCode / 100); // 2025
            const weekNumber = weekCode % 100;           // 28

            // quick year to yearweek check
            if (weekYear !== year) {
                return false;
            }

            const weeks = getCalendarWeeks(year);
            const weekInfo = weeks.find(w => w.week === weekNumber);

            if (!weekInfo) {
                return false; // week not valid for this year
            }

            const weekStart = new Date(weekInfo.start);
            const weekEnd = new Date(weekInfo.end);

            // check if week overlaps with target month
            return (
                (weekStart.getMonth() + 1 === month) ||
                (weekEnd.getMonth() + 1 === month) ||
                (weekStart.getMonth() + 1 < month && weekEnd.getMonth() + 1 > month) // covers full span
            );
        }

        function getCalendarWeeks(year) {
            const weeks = [];

            let date = new Date(year, 0, 4); 
            const day = date.getDay();
            const diff = (day === 0 ? -6 : 1 - day);
            date.setDate(date.getDate() + diff);

            let weekNumber = 1;

            while (date.getFullYear() <= year || (date.getFullYear() === year + 1 && weekNumber < 54)) {
                const weekStart = new Date(date);
                const weekEnd = new Date(date);
                weekEnd.setDate(weekEnd.getDate() + 6);

                if (weekStart.getFullYear() > year && weekEnd.getFullYear() > year) break;

                weeks.push({
                    id: weekNumber,
                    display: `Week ${weekNumber} (${weekStart.toISOString().slice(0, 10)} - ${weekEnd.toISOString().slice(0, 10)})`,
                    week: weekNumber++,
                    start: weekStart.toISOString().slice(0, 10),
                    end: weekEnd.toISOString().slice(0, 10),
                });

                date.setDate(date.getDate() + 7);
            }

            return weeks;
        }

        function addErrorLog(message) {
            invalid = true;
            err_counter++;
            if (errorLogs.length < ERROR_LOG_LIMIT) {
                errorLogs.push(`⚠️ ${message} at line #: ${index + 1}`);
            }
        }

        function validateField(rowValue, fieldName, lookup, sfa_pricelist, pricelistField, product_id) {
            if (!sfa_pricelist) {
                addErrorLog(`Product ID does not exist in SFA Pricelist: ${product_id}`);
                return null;
            }
            if (!rowValue) {
                addErrorLog(`${fieldName} is missing or empty`);
                return null;
            }
            if (!sfa_pricelist[pricelistField]) {
                addErrorLog(`SFA Pricelist is missing ${fieldName} for product: ${product_id}`);
                return null;
            }

            let key = rowValue.toLowerCase();
            let masterfile_id = lookup[key];

            if (!masterfile_id || masterfile_id !== sfa_pricelist[pricelistField]) {
                addErrorLog(`${fieldName} does not exist in SFA Pricelist: ${rowValue}`);
                return null;
            }

            return sfa_pricelist[pricelistField];
        }

        processBatch();
    }
    catch (error) {
        self.postMessage({ invalid: true, errorLogs: [`Validation failed: ${error.message}`], err_counter: 1 });
    }
}