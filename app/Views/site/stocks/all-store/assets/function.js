    const start_time = new Date();
    
    $(document).ready(function() {
        itemClassi.forEach(function (item) {
          $('#itemClass').append(
            $('<option>', {
              value: item.id,
              text: item.item_class_description
            })
          );
        });

        $('#itemClass').select2({ placeholder: 'Please Select...' });
        $('#inventoryStatus').select2({ placeholder: 'Please Select...' });
        autocomplete_field($("#itemLabelCat"), $("#itemLabelCatId"), traccItemClassi, "item_class_code");
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

        if($('#itemLabelCat').val() == ""){
            $('#itemLabelCatId').val('');
        }
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

        if (!vendorFilter && invStatusFilter.length === 0) {
            modal.alert('Please select both "Vendor Name" and "Inventory Status" before filtering.', "warning");
            return;
        }

        if (!vendorFilter) {
            modal.alert('Please select "Vendor Name" before filtering.', "warning");
            return;
        }

        if (invStatusFilter.length === 0) {
            modal.alert('Please select "Inventory Status" before filtering.', "warning");
            return;
        }
        $('#sourceDate').text(calendarWeek);
        if (counter >= 1) {
            fetchData();
            $('.table-empty').hide();
            }
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

        const columns = [
            { data: 'itmcde' },             
            { data: 'item' },                
            { data: 'item_name' },          
            { data: 'item_class_name' }      
        ];

        if (type !== 'hero') {
            columns.push({ data: 'sum_total_qty' }); 
        }

        columns.push(
            { data: 'sum_ave_sales', render: formatTwoDecimals },
            { data: 'swc' }                                        
        );

        let defaultSortColumn = type === 'hero' ? 0 : 4;

        let columnDefs;
        if (type === 'hero') {
            columnDefs = [{
                targets: Array.from({ length: columns.length }, (_, i) => i).filter(i => i !== 0),
                orderable: false
            }];
        } else {
            const lastColumnIndex = columns.length - 3;
            columnDefs = [{
                targets: Array.from({ length: columns.length }, (_, i) => i).filter(i => i !== 0 && i !== lastColumnIndex),
                orderable: false
            }];
        }

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
            columns: columns,
            order: [[defaultSortColumn, 'desc']],
            columnDefs: columnDefs,
            pagingType: "full_numbers",
            pageLength: 10,
            processing: true,
            serverSide: true,
            searching: false,
            colReorder: true,
            lengthChange: false
        });
    }

    function formatTwoDecimals(data) {
        return data ? Number(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : '0.00';
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

    function handleAction(action) {
        modal.loading(true);

        let selectedItemClass       = $('#itemClass').val();       
        let selectedItemCat         = $('#itemLabelCatId').val();    
        let selectedInventoryStatus = $('#inventoryStatus').val();  
        let selectedVendor          = $('#vendorNameId').val();    

        let itemClasses = Array.isArray(selectedItemClass)
            ? selectedItemClass
            : (selectedItemClass ? [ selectedItemClass ] : []);

        let statuses = Array.isArray(selectedInventoryStatus)
            ? selectedInventoryStatus
            : (selectedInventoryStatus ? [ selectedInventoryStatus ] : []);

        let qsParts = [];

        itemClasses.forEach(c => {
            qsParts.push(`itemClass[]=${encodeURIComponent(c)}`);
        });

        if (selectedItemCat) {
            qsParts.push(`itemLabelCat=${encodeURIComponent(selectedItemCat)}`);
        }

        statuses.forEach(s => {
            qsParts.push(`inventoryStatus[]=${encodeURIComponent(s)}`);
        });

        if (selectedVendor) {
            qsParts.push(`vendorName=${encodeURIComponent(selectedVendor)}`);
        }

        let qs = qsParts.join('&');

        let extraOrderParams = [];
        statuses.forEach((statusType, idx) => {
            let tableId  = `#table_${statusType}`;
            let dt       = $(tableId).DataTable();
            let orderArr = dt.order() || [[0, 'desc']];

            let colIdx  = orderArr[0][0];
            let dir     = orderArr[0][1];
            let dtCols  = dt.settings().init().columns;
            let colName = dtCols[colIdx].data; // e.g. "item_class"

            extraOrderParams.push(`order[${idx}][column]=${colIdx}`);
            extraOrderParams.push(`order[${idx}][dir]=${dir}`);
            extraOrderParams.push(`columns[${idx}][data]=${encodeURIComponent(colName)}`);

            extraOrderParams.push(`order[${idx}][colData]=${encodeURIComponent(colName)}`);
        });

        let orderQueryString = extraOrderParams.join('&');

        let endpoint = (action === 'exportPdf') ? 'all-store-generate-pdf' : 'all-store-generate-excel';
        let url = `${base_url}stocks/${endpoint}?${qs}&${orderQueryString}`;

        const end_time = new Date();
        const duration = formatDuration(start_time, end_time);
        const remarks = `
        Exported Successfully!
            <br>Start Time: ${formatReadableDate(start_time)}
            <br>End Time: ${formatReadableDate(end_time)}
            <br>Duration: ${duration}
        `;
        logActivity('Overall Stock Data of all Stores', action === 'exportPdf' ? 'Export PDF' : 'Export Excel', remarks, '-', null, null);

        let fetchedResponse; 

        fetch(url, {
            method: 'GET',
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Server returned ${response.status}`);
            }
            fetchedResponse = response;
            return response.blob();
        })
        .then(blob => {
            const contentDisposition = fetchedResponse.headers.get('Content-Disposition');
            const match = contentDisposition && /filename="?([^"]+)"/.exec(contentDisposition);
            let rawName = match?.[1] || null;

            if (rawName) {
                rawName = decodeURIComponent(rawName);
            }
            const filename = rawName
                || (action === 'exportPdf'
                    ? 'Overall Stock Data of All Stores.pdf'
                    : 'Overall Stock Data of All Stores.xlsx');

            const blobUrl = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = blobUrl;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            a.remove();

            URL.revokeObjectURL(blobUrl);
        })
        .catch(err => {
            modal.alert("Failed to generate file. Please try again.", "error");
        })
        .finally(() => {
            modal.loading(false);
        });


        // kapag nasira yung nasa taas at naka set time out
        // function handleAction(action) {
        //     modal.loading(true);
        //     let selectedItemClass       = $('#itemClass').val();       
        //     let selectedItemCat         = $('#itemLabelCatId').val();    
        //     let selectedInventoryStatus = $('#inventoryStatus').val();  
        //     let selectedVendor          = $('#vendorNameId').val();    

        //     let itemClasses = Array.isArray(selectedItemClass)
        //         ? selectedItemClass
        //         : (selectedItemClass ? [ selectedItemClass ] : []);

        //     let statuses = Array.isArray(selectedInventoryStatus)
        //         ? selectedInventoryStatus
        //         : (selectedInventoryStatus ? [ selectedInventoryStatus ] : []);

        //     //
        //     // 1) Build qs so PHP sees:
        //     //    itemClass[]=A&itemClass[]=B
        //     // AND inventoryStatus[]=npd&inventoryStatus[]=hero
        //     //
        //     let qsParts = [];

        //     // 1a) One itemClass[]= per selected class
        //     itemClasses.forEach(c => {
        //         qsParts.push(`itemClass[]=${encodeURIComponent(c)}`);
        //     });

        //     // 1b) itemLabelCat (single)
        //     if (selectedItemCat) {
        //         qsParts.push(`itemLabelCat=${encodeURIComponent(selectedItemCat)}`);
        //     }

        //     // 1c) One inventoryStatus[]= per selected status
        //     statuses.forEach(s => {
        //         qsParts.push(`inventoryStatus[]=${encodeURIComponent(s)}`);
        //     });

        //     // 1d) vendorName (single)
        //     if (selectedVendor) {
        //         qsParts.push(`vendorName=${encodeURIComponent(selectedVendor)}`);
        //     }

        //     let qs = qsParts.join('&');

        //     //
        //     // 2) Now loop exactly over statuses[] to capture each table’s sort
        //     //
        //     let extraOrderParams = [];
        //     statuses.forEach((statusType, idx) => {
        //         let tableId  = `#table_${statusType}`;
        //         let dt       = $(tableId).DataTable();
        //         let orderArr = dt.order() || [[0, 'desc']];

        //         let colIdx  = orderArr[0][0];
        //         let dir     = orderArr[0][1];
        //         let dtCols  = dt.settings().init().columns;
        //         let colName = dtCols[colIdx].data; // e.g. "item_class"

        //         extraOrderParams.push(`order[${idx}][column]=${colIdx}`);
        //         extraOrderParams.push(`order[${idx}][dir]=${dir}`);
        //         extraOrderParams.push(`columns[${idx}][data]=${encodeURIComponent(colName)}`);

        //         extraOrderParams.push(`order[${idx}][colData]=${encodeURIComponent(colName)}`);
        //     });

        //     let orderQueryString = extraOrderParams.join('&');

        //     let endpoint = (action === 'exportPdf') ? 'all-store-generate-pdf' : 'all-store-generate-excel';
        //     let url = `${base_url}stocks/${endpoint}?${qs}&${orderQueryString}`;

        //     const end_time = new Date();
        //     const duration = formatDuration(start_time, end_time);
        //     const remarks = `
        //     Exported Successfully!
        //         <br>Start Time: ${formatReadableDate(start_time)}
        //         <br>End Time: ${formatReadableDate(end_time)}
        //         <br>Duration: ${duration}
        //     `;
        //     logActivity(
        //         'Overall Stock Data of all Stores',
        //         action === 'exportPdf' ? 'Export PDF' : 'Export Excel',
        //         remarks, '-', null, null
        //     );

        //     let iframe = document.createElement('iframe');
        //     iframe.style.display = 'none';
        //     iframe.src = url;
        //     document.body.appendChild(iframe);

        //     setTimeout(function() {
        //         modal.loading(false);
        //     }, 5000);
        // }
    }
