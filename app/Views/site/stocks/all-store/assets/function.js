    $(document).ready(function() {
        itemClassi.forEach(function (item) {
          $('#itemClass').append(
            $('<option>', {
              value: item.item_class_code,
              text: item.item_class_description
            })
          );
        });

        $('#itemClass').select2({ placeholder: 'Please Select...' });
        $('#inventoryStatus').select2({ placeholder: 'Please Select...' });
        autocomplete_field($("#itemLabelCat"), $("#itemLabelCatId"), brandLabel, "label");
        autocomplete_field($("#vendorName"), $("#vendorNameId"), company, "name");
    });

    $(document).on('click', '#clearButton', function () {
        $('input[type="text"], input[type="number"]').val('');
        $('input[type="checkbox"]').prop('checked', false);
        $('select').prop('selectedIndex', 0);
        $('.select2').val(null).trigger('change');
        $('.hide-div').hide();
        $('.table-empty').show();
    });

    $(document).on('click', '#refreshButton', function () {
        const fields = [
            { input: '#inventoryStatus', target: '#inventoryStatus' },
            { input: '#itemClass', target: '#itemClass' },
            { input: '#ascName', target: '#ascNameId' },
            { input: '#vendorName', target: '#vendorNameId' }
        ];

        let counter = 0;

        fields.forEach(({ input, target }) => {
            const val = $(input).val();
            if (val === "" || val === undefined) {
                $(target).val('');
            } else {
                if ($(input).is('select')) {
                    $(input).select2();
                }
                counter++;
            }
        });

        const vendorFilter = $('#vendorName').val();
        const invStatusFilter = $('#inventoryStatus').val();

        if (!vendorFilter || !invStatusFilter) {
            modal.alert('Please select both "Vendor Name" and "Inventory Status" before filtering.', "warning");
            return;
        }
        $('#sourceDate').text(calendarWeek);
        if (counter >= 1) {
            fetchData();
            $('.table-empty').hide();
            }
    });


    $('#previewButton').click(function() {
    });
    
    $('#exportButton').click(function() {
        //prepareExport();
    });

    function fetchData() {
        let selectedItemClass = $('#itemClass').val();
        let selectedItemCat = $('#itemLabelCatId').val();
        let selectedInventoryStatus = $('#inventoryStatus').val();
        let selectedVendor = $('#vendorNameId').val();

        if (!selectedInventoryStatus || selectedInventoryStatus.length === 0) {
            $('.table-empty').show();
            $('.hide-div.card').hide();
            return;
        }

        $('.table-empty').hide();

        $('.hide-div').first().show();

        let tables = [
            { id: "#table_slowMoving", type: "slowMoving" },
            { id: "#table_overStock", type: "overStock" },
            { id: "#table_npd", type: "npd" },
            { id: "#table_hero", type: "hero" }
        ];

        $('.hide-div.card').hide();
        tables.forEach(table => {
            if (selectedInventoryStatus.includes(table.type)) {
                $(table.id).closest('.hide-div.card').show();
                initializeTable(
                    table.id,
                    table.type,
                    selectedItemClass,
                    selectedItemCat,
                    selectedVendor
                );
            }
        });
    }

    function initializeTable(tableId, type, selectedItemClass, selectedItemCat, selectedVendor) {
        $(tableId).closest('.table-responsive').show(); 
        $(tableId).DataTable({
            destroy: true,
            ajax: {
                url: base_url + 'stocks/get-data-all-store',
                type: 'POST',
                data: function (d) {
                    d.itemClass = selectedItemClass === "" ? null : selectedItemClass;
                    d.itemCategory = selectedItemCat === "" ? null : selectedItemCat;
                    d.company = selectedVendor === "" ? null : selectedVendor;
                    d.type = type;
                    d.limit = d.length;
                    d.offset = d.start;
                },
                dataSrc: function(json) {
                    return json.data.length ? json.data : [];
                }
            },
            columns: [
                { data: 'itmcde' },
                { data: 'item_name' },
                { data: 'item_class' },
                type !== 'hero' ? { data: 'sum_total_qty' } : null,
                { data: 'sum_ave_sales' },
                { data: 'swc' }
            ].filter(Boolean),
            pagingType: "full_numbers",
            pageLength: 10,
            processing: true,
            serverSide: true,
            searching: false,
            colReorder: true,
            lengthChange: false
        });
    }

    function handleAction(action) {
        if (action === 'preview') {
        } else if (action === 'export') {
            //prepareExport();
            modal.alert("Not yet available");
        } else {
            modal.alert("Not yet available");
        }
    }

    function get_data(id, table, parameter) {
        return new Promise((resolve, reject) => {
            let query = id ? " id = " + id : ""
            let data = {
                event: "list",
                select: parameter,
                query: query,
                limit: 0,
                offset: 0,
                table: table,
                order: {}
            };
    
            aJax.post(url, data, function(result) {
                try {
                    if(id) {
                        resolve(JSON.parse(result)[0][parameter]);
                    } else {
                        resolve(null);
                    }
                } catch (error) {
                    reject(error);
                }
            })
        })
    }

    async function prepareExport() {
        let ba = $("#ba_id").val();
        let area = $("#area_id").val();
        let brand = $("#brand_id").val();
        let month = $("#month").val();
        let week = $("#week").val();
        let store = $("#store_id").val();
        let itemClass = $("#item_classi_id").val();
        let covered_asc = $("[name='coveredASC']:checked").val();
        
        let baval = await get_data(ba, 'tbl_brand_ambassador', 'name');
        let areaval = await get_data(area, 'tbl_area', 'description');
        let brandval = await get_data(brand, 'tbl_brand', 'brand_description');
        let monthval = await get_data(month, 'tbl_month', 'month');
        let weekval = await get_data(week, 'tbl_week', 'name');
        let itemclassval = await get_data(itemClass, 'tbl_classification', 'item_class_description');
        let storeval = await get_data(store, 'tbl_store', 'description');
        
        let fetchPromises = new Promise((resolve, reject) => {
            fetchTradeDashboardData({
                baseUrl: base_url,
                selectedBa: baval,
                selectedArea: areaval,
                selectedBrand: brandval,
                selectedMonth: monthval,
                selectedWeek: weekval,
                selectedStore: storeval,
                selectedClass: itemclassval,
                length: 10,
                start: 0,
                onSuccess: function(data) {
                    let newData = data.map(({ ambassador_name, asc_name, brand, item, item_class, item_name, store_name, total_qty }) => ({
                        "ambassador_name": ambassador_name,
                        "asc_name": asc_name,
                        "brand": brand,
                        "item": item,
                        "item_class": item_class,
                        "item_name": item_name,
                        "store_name": store_name,
                        "total_qty": total_qty,
                    }));
                    resolve(newData);
                },
                onError: function(error) {
                    reject(error);
                }
            });
        });

        fetchPromises.then((result) => {
            let formattedData = result.flat();

            const headerData = [
                ["LIFESTRONG MARKETING INC."],
                ["Report: Kam1 Dashboard"],
                ["Date Generated: " + formatDate(new Date())],
                ["Brand Ambassador: " + (baval ? baval : "ALL")],
                ["Area: " + (areaval ? areaval : "ALL")],
                ["Brand: " + (brandval ? brandval : "ALL")],
                ["Month: " + (monthval ? monthval : "ALL")],
                ["Week: " + (weekval ? weekval : "ALL")],
                ["Item Category: " + (itemclassval ? itemclassval : "ALL")],
                ["Store Name: " + (storeval ? storeval : "ALL")]
            ];

            exportArrayToCSV(formattedData, `Report: Kam1 Dashboard - ${formatDate(new Date())}`, headerData);
        }).catch((error) => {
        })
    }

    function fetchTradeDashboardData({ 
        baseUrl, 
        selectedBa,
        selectedArea,
        selectedBrand,
        selectedMonth,
        selectedWeek,
        selectedStore,
        selectedClass,
        length,
        start, 
        onSuccess, 
        onError 
    }) {
        let allData = [];

        function fetchData(offset) {
            $.ajax({
                url: baseUrl + 'stocks/get-data-all-store',
                type: 'GET',
                data: {
                    ba: selectedBa === 0 ? null : selectedBa,
                    area: selectedArea === 0 ? null : selectedArea,
                    brand: selectedBrand === 0 ? null : selectedBrand,
                    month: selectedMonth === 0 ? null : selectedMonth,
                    week: selectedWeek === 0 ? null : selectedWeek,
                    store: selectedStore === 0 ? null : selectedStore,
                    itemcat: selectedClass === 0 ? null : selectedClass,
                    limit: length,
                    offset: offset
                },
                success: function(response) {
                    if (response.data && response.data.length) {
                        allData = allData.concat(response.data);

                        if (response.data.length === length) {
                            fetchData(offset + length);
                        } else {
                            if (onSuccess) onSuccess(allData);
                        }
                    } else {
                        if (onSuccess) onSuccess(allData);
                    }
                },
                error: function(error) {
                    if (onError) onError(error);
                }
            });
        }

        fetchData(start); 
    }

    function exportArrayToCSV(data, filename, headerData) {
        const worksheet = XLSX.utils.json_to_sheet(data, { origin: headerData.length });

        XLSX.utils.sheet_add_aoa(worksheet, headerData, { origin: "A1" });

        const csvContent = XLSX.utils.sheet_to_csv(worksheet);

        const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });

        saveAs(blob, filename + ".csv");
    }
