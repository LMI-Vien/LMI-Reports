    $(document).ready(function () {

        const currentWeek = getCurrentWeek();
        if (currentWeek) {
            $('#currentWeek').text(currentWeek.display);
        } else {
            $('#currentWeek').text('N/A');
        }

        if (localStorage.getItem("TutorialMessage") === "true") {
            $('#popup_modal').modal('show');
        } else {
            $('#popup_modal').modal('hide');
        }

        const tutorialSteps = [
            {
                id: 'step1',
                title: '<b>Welcome to the Dashboard Tutorial!</b>',
                intro: `This tutorial will guide you step by step on how to effectively navigate and utilize the features of this dashboard.
                Whether you're a new user or just need a quick refresher, you'll find this guide helpful for getting the most out of the tools available.`
            },
            {
                id: 'step2',
                title: '<b>Understanding the Filters Panel</b>',
                intro: `The Filters Panel is your control center for customizing the data shown on the dashboard.
                It lets you apply specific criteria to focus on what’s most relevant to you.<br><br>
                Here are two important buttons you'll find in the filters section:`
            },
            {
                id: 'step3',
                title: 'Clear Filters',
                intro: `This button resets all the filter selections back to their default state.
                Use this when you want to start fresh or remove all applied filters at once.
                It’s especially helpful if you've applied multiple filters and want to quickly go back to the original view.`
            },
            {
                id: 'step4',
                title: 'Refresh',
                intro: `After selecting or modifying your filters, click the Refresh button to update the dashboard.
                This action fetches the latest data that matches your filter settings and updates the tables accordingly.
                Make sure to hit Refresh after making changes, or your filters won't take effect.`
            },
            {
                id: 'step5',
                title: '<strong>REMINDER !!!</strong>',
                intro: `Always double-check your filters before hitting Refresh to ensure you’re pulling the correct data.`
            },
            {
                id: 'step6',
                title: '<b>Data Tables</b>',
                intro: `After the filters, you’ll find tables that update after you click the refresh button based on your selected filters.
                These tables present key metrics, trends, and detailed breakdowns in an organized and easy-to-read format.  
                Each column is sortable, and you may be able to export the data or drill down into specific rows for more insights.`
            },
            {
                id: 'step7',
                title: '<strong>Table Buttons</strong>',
                intro: `Each data table includes a set of buttons that give you quick access to additional actions. 
                These may include options to export data, copy table contents, or adjust the view. 
                Familiarizing yourself with these buttons helps you work more efficiently with the data presented.`
            },
            {
                id: 'ExportPDF',
                title: 'Export as PDF',
                intro: `Click this button to generate a PDF version of the current table view. 
                It’s a convenient way to save or share a snapshot of your data for reporting, documentation, or printing purposes. 
                The export will reflect any filters or sorting you’ve applied.`
            },
            {
                id: 'exportButton',
                title: 'Export as Excel',
                intro: `Use this button to export the table data to an Excel (.xlsx) file. 
                This is useful for performing deeper analysis, building reports, or keeping a local backup of your filtered results. 
                Like the PDF export, it respects the current filters and sorting selections.`
            }
        ];

        tutorialSteps.forEach((step, index) => {
            $(`#${step.id}`).attr({
                'data-title': step.title,
                'data-intro': step.intro,
                'data-step': (index + 1).toString()
            });
        });

        $('#inventoryStatus').select2({ placeholder: 'Select inventory statuses' });
        $('#brands').select2({ placeholder: 'Select Brands' });
        autocomplete_field($("#area"), $("#areaId"), area, "description", "id", function(result) {
            let data = {
                event: "list",
                select: "a.id, a.description, asc.description as asc_description, asc.id as asc_id, asc.code",
                query: "a.id = " + result.id,
                offset: offset,
                limit: 0,
                table: "tbl_area a",
                join: [
                    {
                        table: "tbl_area_sales_coordinator asc",
                        query: "a.id = asc.area_id",
                        type: "left"
                    }
                ]
            }

            aJax.post(url, data, function(result) {
                let data = JSON.parse(result);
                if(data.length > 0){
                    if(data[0].code){ 
                        $("#ascName").val(data[0].code+' - '+data[0].asc_description);
                        $("#ascNameId").val(data[0].asc_id);
                        $("#ascName").prop('disabled', true); 
                    }else{
                        $("#ascName").val('');
                        $("#ascNameId").val('');
                        $("#ascName").prop('disabled', false); 
                    }           
                }else{
                    $("#ascName").val('');
                    $("#ascNameId").val('');
                    $("#ascName").prop('disabled', false); 
                }    
            })
        });

        autocomplete_field($("#ascName"), $("#ascNameId"), asc, "description");

        autocomplete_field($("#brandAmbassador"), $("#brandAmbassadorId"), brand_ambassadors, "name", "id", function(result) {
            let data = {
                event: "list",
                select: "s.id, s.code, s.description",
                query: "sg.brand_ambassador_id = " + result.id,
                table: "tbl_brand_ambassador_group sg",
                join: [
                    {
                        table: "tbl_store s",
                        query: "s.id = sg.store_id",
                        type: "left"
                    }
                ]
            }

            aJax.post(base_url + "cms/global_controller", data, function(res) {
                let data = JSON.parse(res);
                if(parseInt($('#brandAmbassadorId').val()) === -5 || parseInt($('#brandAmbassadorId').val()) === -6){
                    $("#storeName").val('');
                    $("#storeNameId").val('');
                    $("#storeName").prop('disabled', false);
                    return;
                }
                if(data.length > 0){
                    if(data[0].code){
                        $("#storeName").val(data[0].code+' - '+data[0].description);
                        $("#storeNameId").val(data[0].id); 
                        $("#storeName").prop('disabled', true);   
                    }else{
                        $("#storeName").val('');
                        $("#storeNameId").val('');
                        $("#storeName").prop('disabled', false);
                    }       
                }else{
                    $("#storeName").val('');
                    $("#storeNameId").val('');
                    $("#storeName").prop('disabled', false);
                }  
            })
        });

        autocomplete_field($("#storeName"), $("#storeNameId"), store_branch, "description", "id");

        autocomplete_field($("#brand"), $("#brand_id"), brands, "brand_description", "id");
        if (!localStorage.getItem("TutorialMessage")) {
            $('#popup_modal').modal('show');
        } else {
            $('#popup_modal').modal('hide');
        }

        $('#filteredDate').text('N/A');

        const latestWeekAttr = $('#mostRecentImportWeekRange').data('latest-week');
        const latestWeek = latestWeekAttr ? parseInt(latestWeekAttr, 10) : null;
        if (latestWeek) {
            const wk = getImportWeekDisplay(latestWeek);
            $('#mostRecentImportWeekRange').text(
                wk ? `(${wk.start} - ${wk.end})` : 'N/A'
            );
        } else {
            $('#mostRecentImportWeekRange').text('N/A');
        }
    });

    $(document).on('click', '#clearButton', function () {
        $('#area').val('');
        $('#brandAmbassador').val('');
        $('#ascName').val('');
        $('#storeName').val('');    
        $('#areaId').val('');
        $('#brandAmbassadorId').val('');
        $('#ascNameId').val('');
        $('#storeNameId').val('');
        $('.btn-outline-light').removeClass('active');
        $('.main_all').addClass('active');
        $('select').prop('selectedIndex', 0);
        $('select').val('').trigger('change');
        $('.hide-div').hide();
        $('.table-empty').show();
    });

    function startTutorial() {
        introJs().start();
    }

    function startTutorial() {
        localStorage.setItem("TutorialMessage", "true");
        $('#popup_modal').modal('hide');
        introJs().start();
    }

    function closeTutorial() {
        localStorage.setItem("TutorialMessage", "false");
        $('#popup_modal').modal('hide');
    }

    $(document).on('change', '#brandAmbassador', function () {
        data = $(this).val();
        if(!(data)){
            $("#storeName").prop('disabled', false);
        }
    });

    $(document).on('change', '#area', function () {
        data = $(this).val();
        if(!(data)){
            $("#ascName").prop('disabled', false);
        }
    });

    $(document).on('click', '#refreshButton', function () {
        const fields = [
            { input: '#inventoryStatus', target: '#inventoryStatus' },
            { input: '#area', target: '#areaId' },
            { input: '#ascName', target: '#ascNameId' },
            { input: '#brandAmbassador', target: '#brandAmbassadorId' },
            { input: '#storeName', target: '#storeNameId' }
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

        baFilter = $('#brandAmbassador').val();
        invStatusFilter = $('#inventoryStatus').val();

        if (!baFilter && invStatusFilter.length === 0) {
            modal.alert('Please select both "Brand Ambassador" and Inventory Status" before filtering.', "warning");
            return;
        }

        invStatusFilter = $('#inventoryStatus').val();
        if (!invStatusFilter || invStatusFilter.length === 0) {
            modal.alert('Please select "Inventory Status" before filtering.', "warning");
            return;
        }



        $('#sourceDate').text(calendarWeek);
        if (counter >= 1) {
            const filteredDate = getTodayDateTime();
            $('#filteredDate').text(filteredDate.display);

            fetchData();
            $('.table-empty').hide();
        } else {
            $('#filteredDate').text('N/A');
        }
    });

    function fetchData() {
        let selectedArea = $('#areaId').val();
        let selectedAsc = $('#ascNameId').val();
        let selectedBaType = $('input[name="filterType"]:checked').val();
        let selectedBa = $('#brandAmbassadorId').val();
        let selectedStore = $('#storeNameId').val();
        let selectedBrands = $('#brands').val();
        let selectedInventoryStatus = $('#inventoryStatus').val();

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
                    selectedArea,
                    selectedAsc,
                    selectedBaType,
                    selectedBa,
                    selectedStore,
                    selectedBrands
                );
            }
        });
    }

    function initializeTable(tableId, type, selectedArea, selectedAsc, selectedBaType, selectedBa, selectedStore, selectedBrands) {
        $(tableId).closest('.table-responsive').show(); 

        const columns = [
            { data: 'itmcde' },  
            { data: 'item' },       
            { data: 'item_name' }    
        ];

        if (type !== 'hero') {
            columns.push({ data: 'sum_total_qty', render: formatNumberWithCommas });
        }

        let defaultSortColumn = type === 'hero' ? 0 : columns.length - 1;
        let columnDefs = [];

        if (type === 'hero') {
            columnDefs.push({
                targets: [1],
                orderable: false
            });
        } else {
            const lastColumnIndex = columns.length - 1;
            const nonSortableTargets = Array.from({ length: columns.length }, (_, i) => i)
                .filter(i => i !== 0 && i !== lastColumnIndex);
            
            columnDefs.push({
                targets: nonSortableTargets,
                orderable: false
            });
        }

        $(tableId).DataTable({
            destroy: true,
            ajax: {
                url: base_url + 'stocks/get-data-per-store',
                type: 'POST',
                data: function (d) {
                    d.area = selectedArea || null;
                    d.asc = selectedAsc || null;
                    d.baType = selectedBaType || null;
                    d.ba = selectedBa || null;
                    d.store = selectedStore || null;
                    d.brands = selectedBrands.length ? selectedBrands : null;
                    d.type = type;
                    d.limit = d.length;
                    d.offset = d.start;
                },
                dataSrc: json => json.data || []
            },
            columns: columns,
            order: [[defaultSortColumn, 'desc']],
            columnDefs: columnDefs,
            pagingType: "full_numbers",
            pageLength: 10,
            processing: true,
            serverSide: true,
            searching: true,
            colReorder: true,
            lengthChange: false
        });
    }

    function paramsToJSON(params) {
        const json = {};

        for (const [key, value] of params.entries()) {
            const keys = key.match(/[^\[\]]+/g); 

            if (keys.length === 1) {
                json[keys[0]] = value;
            } else {
                let temp = json;
                for (let i = 0; i < keys.length; i++) {
                    const k = keys[i];
 
                    if (i === keys.length - 1) {
                        temp[k] = value;
                    } else { 
                        if (!temp[k]) {
                            temp[k] = /^\d+$/.test(keys[i + 1]) ? [] : {};
                        }
                        temp = temp[k];
                    }
                }
            }
        }

        return json;
    }

    function handleAction(action) {
        modal.loading(true);
        const selectedInventoryStatus = $('#inventoryStatus').val();
        var tableSlowMoving = $('input[aria-controls="table_slowMoving"]').val() || '';
        var tableHero = $('input[aria-controls="table_hero"]').val() || '';
        var tableNpd = $('input[aria-controls="table_npd"]').val() || '';
        var tableOverStock = $('input[aria-controls="table_overStock"]').val() || '';

        const params = new URLSearchParams();
        params.append('area', $('#areaId').val() || '');
        params.append('areaText', $('#area').val() || '');
        params.append('asc', $('#ascNameId').val() || '');
        params.append('ascText', $('#ascName').val() || '');
        params.append('baType', $('input[name="filterType"]:checked').val() || '');
        params.append('ba', $('#brandAmbassadorId').val() || '');
        params.append('baText', $('#brandAmbassador').val() || '');
        params.append('store', $('#storeNameId').val() || '');
        params.append('storeText', $('#storeName').val() || '');
        params.append('types', JSON.stringify(selectedInventoryStatus));
        params.append('table_slowMoving', tableSlowMoving);
        params.append('table_hero', tableHero);
        params.append('table_npd', tableNpd);
        params.append('table_overStock', tableOverStock);

        const brands = $('#brands').val();
        params.append('brands', JSON.stringify(brands));

        const linkto = action === 'export_pdf'
            ? "stocks/per-store-generate-pdf?"
            : "stocks/per-store-generate-excel-ba?";

        let url = `${base_url}${linkto}`;
        const jsonData = paramsToJSON(params);
        $.ajax({
            url: url,
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(jsonData),
            xhrFields: {
                responseType: 'blob'
            },
            success: function(blob, status, xhr) {
                const cd = xhr.getResponseHeader('Content-Disposition');
                const match = cd && /filename="?([^"]+)"/.exec(cd);
                let rawName = match?.[1] ? decodeURIComponent(match[1]) : null;
                const filename = rawName
                    || (action === 'exportPdf'
                        ? 'Week by Week Stock Data of All Stores.pdf'
                        : 'Week by Week Stock Data of All Stores.xlsx');

                const blobUrl = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = blobUrl;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                a.remove();
                URL.revokeObjectURL(blobUrl);
            },
            error: function(xhr, status, error) {
                alert(xhr+' - '+status+' - '+error);
                modal.loading(false);
            },
            complete: function() {
                modal.loading(false);
            }
        })
    }