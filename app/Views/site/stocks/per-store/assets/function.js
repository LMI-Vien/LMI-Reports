    $(document).ready(function () {

       // fetchData();
        $('#inventoryStatus').select2({ placeholder: 'Select inventory statuses' });
        $(document).on('click', '#clearButton', function () {
            $('input[type="text"], input[type="number"], input[type="date"]').val('');
            $('input[type="checkbox"]').prop('checked', false);
            $('input[name="sortOrder"][value="ASC"]').prop('checked', true);
            $('input[name="sortOrder"][value="DESC"]').prop('checked', false);
            $('.btn-outline-primary').removeClass('active');
            $('.main_all').addClass('active');
            $('select').prop('selectedIndex', 0);
            $('.select2').val(null).trigger('change');
            // $('table[id^="table_"]').each(function () {
            //     $(this).closest('.table-responsive').hide();
            // });
            $('.hide-div').hide();
            $('.table-empty').show();
            $('#refreshButton').click();
        });

        autocomplete_field($("#brand_ambassadors"), $("#ba_id"), brand_ambassadors, "description", "id", function(result) {
            let url = url;
            let data = {
                event: "list",
                select: "tbl_store.id, tbl_store.description",
                query: "tbl_brand_ambassador.id = " + result.id,
                offset: offset,
                limit: 0,
                table: "tbl_brand_ambassador",
                join: [
                    {
                        table: "tbl_store",
                        query: "tbl_store.id = tbl_brand_ambassador.store",
                        type: "left"
                    }
                ]
            }

            aJax.post(url, data, function(result) {
                let store_name = JSON.parse(result);
                $("#store_branch").val(store_name[0].description);
                $("#store_id").val(store_name[0].id);
            })
        });

        autocomplete_field($("#store_branch"), $("#store_id"), store_branch, "description", "id", function(result) {
            let url = url;
            let data = {
                event: "list",
                select: "tbl_brand_ambassador.id, tbl_brand_ambassador.name",
                query: "tbl_store.id = " + result.id,
                offset: offset,
                limit: 0,
                table: "tbl_store",
                join: [
                    {
                        table: "tbl_brand_ambassador",
                        query: "tbl_brand_ambassador.store = tbl_store.id",
                        type: "left"
                    }
                ]
            }

            aJax.post(url, data, function(result) {
                let baname = JSON.parse(result);

                if(baname[0].name !== null) {
                    $("#brand_ambassadors").val(baname[0].name);
                    $("#ba_id").val(baname[0].id);
                } else {
                    $("#brand_ambassadors").val("No Brand Ambassador");
                }

            })
        });
        autocomplete_field($("#brand"), $("#brand_id"), brands, "brand_description", "id");
        if (!localStorage.getItem("TutorialMessage")) {
            $('#popup_modal').modal('show');
        } else {
            $('#popup_modal').modal('hide');
        }
    });

    function startTutorial() {
        localStorage.setItem("TutorialMessage", "true");
        $('#popup_modal').modal('hide');
        introJs().start();
    }

    function closeTutorial() {
        localStorage.setItem("TutorialMessage", "true");
        $('#popup_modal').modal('hide');
    }

    $(document).on('click', '#refreshButton', function () {
        // if($('#brand_ambassadors').val() == ""){
        //     $('#ba_id').val('');
        // }
        // if($('#store_branch').val() == ""){
        //     $('#store_id').val('');
        // }
        // if($('#brand').val() == ""){
        //     $('#brand_id').val('');
        // }
        // let selectedBa = $('#ba_id').val();

            const fields = [
                { input: '#brandAmbassador', target: '#ba_id' },
                { input: '#area', target: '#area_id' },
                { input: '#brand', target: '#brand_id' },
                { input: '#store', target: '#store_id' },
                { input: '#item_classi', target: '#item_classi_id' },
                { input: '#qtyscp', target: '#qtyscp' }
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
            if (counter >= 1) {
                fetchData();
                $('.table-empty').hide();
                $('.hide-div').show();
            }
        //fetchData();
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

        let filteredTables = tables.filter(table => selectedInventoryStatus.includes(table.type));
        filteredTables.forEach(table => {
            initializeTable(table.id, table.type, selectedType, selectedBa, selectedStore, selectedBrand, selectedSortField, selectedSortOrder);
        });
    }

    function initializeTable(tableId, type, selectedType, selectedBa, selectedStore, selectedBrand, selectedSortField, selectedSortOrder) {
        $(tableId).closest('.table-responsive').show(); 
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