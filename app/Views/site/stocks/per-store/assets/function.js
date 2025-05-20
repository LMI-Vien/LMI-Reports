    $(document).ready(function () {

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
            //let url = url;
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
                    }             
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
                let data = JSON.parse(res)[0];
                if(data.length > 0){
                    if(data[0].code){ 
                        $("#storeName").val(data.code+' - '+data.description);
                        $("#storeNameId").val(data.id);      
                    }             
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
    });

    $(document).on('click', '#clearButton', function () {
        $('.btn-outline-light').removeClass('active');
        $('.main_all').addClass('active');
        $('select').prop('selectedIndex', 0);
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


    $(document).on('click', '#refreshButton', function () {

        const fields = [
            { input: '#inventoryStatus', target: '#ba_id' }
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

        const storeFilter = $('#storeName').val();
        const invStatusFilter = $('#inventoryStatus').val();

        if (!storeFilter || !invStatusFilter) {
            modal.alert('Please select both "Store Name" and "Inventory Status" before filtering.', "warning");
            return;
        }

        if (counter >= 1) {
            fetchData();
            $('.table-empty').hide();
            $('.hide-div').show();
            }
    });

    function fetchData() {
        let selectedType = $('input[name="filterType"]:checked').val();
        let selectedBa = $('#brand_ambassadors').val();
        let selectedStore = $('#store_branch').val();
        let selectedBrand = $('#brand').val();
        let selectedSortField = $('#sortBy').val();
        let selectedSortOrder = $('input[name="sortOrder"]:checked').val();
        let selectedInventoryStatus = $('#inventoryStatus').val(); // returns an array
        if (!selectedInventoryStatus || selectedInventoryStatus.length === 0) return;
       // table-empty
        $('.table-empty').hide(); 
        let tables = [
            { id: "#table_slowMoving", type: "slowMoving" },
            { id: "#table_overStock", type: "overStock" },
            { id: "#table_npd", type: "npd" },
            { id: "#table_hero", type: "hero" }
        ];
        console.log('asd');
        let filteredTables = tables.filter(table => selectedInventoryStatus.includes(table.type));
        filteredTables.forEach(table => {
            initializeTable(table.id, table.type, selectedType, selectedBa, selectedStore, selectedBrand, selectedSortField, selectedSortOrder);
        });
    }

    function initializeTable(tableId, type, selectedType, selectedBa, selectedStore, selectedBrand, selectedSortField, selectedSortOrder) {
        $(tableId).closest('.table-responsive').show(); 
        console.log(tableId);
        $(tableId).DataTable({
            destroy: true,
            ajax: {
                url: base_url + 'stocks/get-data-per-store',
                type: 'GET',
                data: function (d) {
                    d.sort_field = selectedSortField;
                    d.sort = selectedSortOrder;
                    d.brand = selectedBrand === "" ? null : selectedBrand;
                    d.brand_ambassador = selectedBa === "" ? null : selectedBa;
                    d.store_name = selectedStore === "" ? null : selectedStore;
                    d.ba_type = selectedType;
                    d.type = type;
                    d.limit = d.length;
                    d.offset = d.start;
                },
                dataSrc: function(json) {
                    return json.data.length ? json.data : [];
                }
            },
            columns: [
                { data: 'item_name' },
                { data: 'item_name' },
                type !== 'hero' ? { data: 'sum_total_qty' } : null
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
        modal.loading(true);
        
        let selectedType = $('input[name="filterType"]:checked').val();
        let selectedBa = $('#brand_ambassadors').val();
        let selectedStore = $('#store_branch').val();
        let selectedBrand = $('#brand').val();
        let selectedSortField = $('#sortBy').val();
        let selectedSortOrder = $('input[name="sortOrder"]:checked').val();
        let ascName = $('#ar_asc_name').text().trim();
        
        let type = 'slowMoving';
        if(type){
          let url = base_url + 'stocks/per-store-generate-pdf-' + (action === 'export_pdf' ? 'pdf' : 'excel') + '-ba?'
              + 'sort_field=' + encodeURIComponent(selectedSortField)
              + '&sort=' + encodeURIComponent(selectedSortOrder)
              + '&brand=' + encodeURIComponent(selectedBrand || '')
              + '&brand_ambassador=' + encodeURIComponent(selectedBa || '')
              + '&store_name=' + encodeURIComponent(selectedStore || '')
              + '&ba_type=' + encodeURIComponent(selectedType)
              + '&asc_name=' + encodeURIComponent(ascName)
              + '&type=' + encodeURIComponent(type)
              + '&limit=' + encodeURIComponent(length)
              + '&offset=' + encodeURIComponent(offset);

          let iframe = document.createElement('iframe');
          iframe.style.display = "none";
          iframe.src = url;
          document.body.appendChild(iframe);

          setTimeout(() => {
              modal.loading(false);
          }, 5000);
        }
    }