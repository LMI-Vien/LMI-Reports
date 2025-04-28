<?php
    $dir = dirname(__FILE__);
    $minify = new \App\Libraries\MinifyLib();

    echo $minify->css($dir . '/assets/custom.css', 'Store Custom CSS');
    echo $minify->js($dir . '/assets/function.js', 'App Functions JS');
?>

<?= view("site/store/perf-per-ba/sales_performance_per_ba_filter"); ?> 

<div class="wrapper">
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid py-4">
                <!-- Filters Section -->
                <?php if (isset($breadcrumb)): ?>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent px-0 mb-0">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url() ?>">
                                        <i class="fas fa-home"></i>
                                    </a>
                                </li>
                                <?php 
                                    $last = end($breadcrumb);
                                    foreach ($breadcrumb as $label => $url): 
                                        if ($url != ''):
                                ?>
                                    <li class="breadcrumb-item">
                                        <?= $label ?>
                                    </li>
                                <?php else: ?>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <?= $label ?>
                                    </li>
                                <?php 
                                        endif;
                                    endforeach; 
                                ?>
                            </ol>
                        </nav>
                        <!-- Right side content -->
                        <div class="ml-auto text-muted small" style="white-space: nowrap;">
                            <strong>Source:</strong> <?= !empty($source) ? $source : 'N/A'; ?> - <?= !empty($source_date) ? $source_date : 'N/A'; ?>

                        </div>
                    </div>
                <?php endif; ?>
                <!-- DataTables Section -->

                <div class="card p-4 shadow-lg text-center text-muted table-empty">
                  <i class="fas fa-filter mr-2"></i> Please select a filter
                </div>
                <div class="card mt-4 p-4 shadow-sm hide-div">
                    <div class="form-group">
                        <button class="btn btn-secondary" id="toggleColumnsButton"><i class="fas fa-columns"></i> Toggle Columns</button>
                    </div>

                    <div class="sortable row text-center p-2" id="columnToggleContainer" class="mb-3">
                        <strong class="col">Select Columns:</strong>
                    </div>
                    <div style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;">Store Sales Performance per Brand Ambassador</div>
                    <div class="mb-3" style="overflow-x: auto; height: 450px; padding: 0px;">
                        <table id="overall_ba_sales_tbl" class="table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th colspan="14"
                                        style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                        class="tbl-title-header"
                                    >
                                        Store Sales Performance per Brand Ambassador
                                    </th>
                                </tr>                          
                                <tr>
                                    <th class="tbl-title-field">Rank</th>
                                    <th class="tbl-title-field">Area</th>
                                    <th class="tbl-title-field">Store Code / Store Name</th>
                                    <th class="tbl-title-field sort">Brand Ambassador</th>
                                    <th class="tbl-title-field sort">Deployed Date</th>
                                    <th class="tbl-title-field sort">Brand Handle</th>
                                    <th class="tbl-title-field sort">LY Scanned Data</th>
                                    <th class="tbl-title-field">Actual Sales Report</th>
                                    <th class="tbl-title-field">Target</th>
                                    <th class="tbl-title-field">% Achieved</th>
                                    <th class="tbl-title-field sort">%Growth</th>
                                    <th class="tbl-title-field">Balance To Target</th>
                                    <th class="tbl-title-field">Possible Incentives</th>
                                    <th class="tbl-title-field">Target Per Remaining Days</th>

                                </tr>
                            </thead>
                                  <tbody>
                                      <tr>
                                          <td colspan="14" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="14" class="text-center py-4 text-muted">
                                              No data available
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="14" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                  </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button 
                            class="btn btn-primary mr-2" 
                            id="ExportPDF"
                            data-title="Step 5: Exporting the Report (PDF)"
                            data-intro="Paki palitan to haha" 
                            data-step="10"
                            onclick="handleAction('export_pdf')"
                        >
                            <i class="fas fa-file-export"></i> PDF
                        </button>
                        <button 
                            class="btn btn-success" 
                            id="exportButton"
                            id="step11" 
                            data-title="Step 6: Exporting the Report (Excel)"
                            data-intro="
                            Once satisfied with the report:<br><br>
                            Click the Export button.<br>
                            Choose between PDF or Excel format.<br>
                            The file will be generated and downloaded to your device.<br><br>
                            <small>Tip: Use PDF for sharing and Excel for further data analysis.</small><br><br>
                            Click Next" 
                            data-step="11"
                            onclick="handleAction('export_excel')"
                        >
                            <i class="fas fa-file-export"></i> Excel
                        </button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script>
    var base_url = "<?= base_url(); ?>";
    let store_branch = <?= json_encode($store_branch) ?>;
    // let store_branch = [];
    let area = <?= json_encode($area) ?>;

    $(document).ready(function() {
        $( ".sortable" ).sortable({
            revert: true
        });
        //initializeTable();

        autocomplete_field($("#area"), $("#area_id"), area, "area_description", "id", function(result) {
            let data = {
                event: "list",
                select: "",
                query: "tbl_store_group.area_id = " + result.id,
                table: "tbl_store_group",
                join: [
                    {
                        table: "tbl_store",
                        query: "tbl_store_group.store_id = tbl_store.id",
                        type: "left"
                    }
                ]
            }

            aJax.post(base_url + "cms/global_controller", data, function(res) {
                let store = JSON.parse(res);
                store_branch = store;

                $("#store").val("");
                $("#store_id").val("");

                autocomplete_field($("#store"), $("#store_id"), store_branch, "description", "id", function(result) {
                    let data = {
                        event: "list",
                        select: "tbl_store_group.store_id, tbl_area.description",
                        query: "tbl_store_group.store_id = " + result.id,
                        table: "tbl_store_group",
                        offset: offset,
                        limit: 0,
                        join: [
                            {
                                table: "tbl_area",
                                query: "tbl_area.id = tbl_store_group.area_id",
                                type: "left"
                            }
                        ]
                    }

                    aJax.post(base_url + "cms/global_controller", data, function(result) {
                        let store_description = JSON.parse(result);

                        $("#store_id").val(store_description[0].store_id);
                    })
                })
            })
        });

        autocomplete_field($("#store"), $("#store_id"), store_branch, "description", "id", function(result) {

            let data = {
                event: "list",
                select: "tbl_area.id, tbl_area.description",
                query: "tbl_store_group.store_id = " + result.id,
                table: "tbl_store_group",
                offset: offset,
                limit: 0,
                join: [
                    {
                        table: "tbl_area",
                        query: "tbl_area.id = tbl_store_group.area_id",
                        type: "left"
                    }
                ]
            }

            aJax.post(base_url + "cms/global_controller", data, function(result) {
                let area_description = JSON.parse(result);

                $("#area").val(area_description[0].description);
                $("#area_id").val(area_description[0].id);

            })
        });

        $('#columnToggleContainer').toggle();
        $(document).on('click', '#toggleColumnsButton', function() {
            $('#columnToggleContainer').toggle();
        });

        // $(document).on('click', '#refreshButton', function () {
        //     if($('#area').val() == ""){
        //         $('#area_id').val('');
        //     }
        //     if($('#store').val() == ""){
        //         $('#store_id').val('');
        //     }
        //     fetchData();
        // });

        $(document).on('click', '#refreshButton', function () {
            const fields = [
                { input: '#area', target: '#area_id' },
                { input: '#brand', target: '#brand_id' },
                { input: '#store', target: '#store_id' },
                { input: '#item_classi', target: '#item_classi_id' },
                { input: '#qtyscp', target: '#qtyscp' }
            ];

            let counter = 0;

            fields.forEach(({ input, target }) => {
                const val = $(input).val();
                const hasValue = Array.isArray(val) ? val.length > 0 : val;
                if (!hasValue || val === undefined) {
                    $(target).val('');
                } else {
                    counter++;
                }
            });
            if (counter >= 1) {
                fetchData();
                $('.table-empty').hide();
                $('.hide-div').show();
            }
        });       

        $(document).on('click', '#clearButton', function () {
            $('input[type="text"], input[type="number"], input[type="date"]').val('');
            $('input[name="sortOrder"][value="ASC"]').prop('checked', true);
            $('input[name="sortOrder"][value="DESC"]').prop('checked', false);
            $('.main_all').addClass('active');
            $('select').prop('selectedIndex', 0);
            $('.table-empty').show();
            $('.hide-div').hide();
            $('#refreshButton').click();
        });
    });

    function fetchData() {
        let selectedStore = $('#store_id').val();
        let selectedArea = $('#area_id').val();
        let selectedMonth = $('#month').val();
        let selectedYear = $('#year').val();
        let selectedSortField = $('#sortBy').val();
        let selectedSortOrder = $('input[name="sortOrder"]:checked').val();
        initializeTable(selectedStore, selectedArea, selectedMonth, selectedYear, selectedSortField, selectedSortOrder);
    }

    function initializeTable(selectedStore = null, selectedArea = null, selectedMonth = null, selectedYear = null, selectedSortField = null, selectedSortOrder = null) {

        if ($.fn.DataTable.isDataTable('#overall_ba_sales_tbl')) {
            let existingTable = $('#overall_ba_sales_tbl').DataTable();
            existingTable.clear().destroy();
        }

        let table = $('#overall_ba_sales_tbl').DataTable({
            paging: true,
            searching: false,
            ordering: true,
            info: true,
            lengthChange: false,
            colReorder: true, 
            ajax: {
                url: base_url + 'store/get-sales-performance-per-ba',
                type: 'GET',
                data: function(d) {
                    d.sort_field = selectedSortField;
                    d.sort = selectedSortOrder;
                    d.year = selectedYear === "0" ? null : selectedYear;
                    d.month = selectedMonth === "0" ? null : selectedMonth;
                    d.area = selectedArea === "0" ? null : selectedArea;
                    d.store = selectedStore === "0" ? null : selectedStore;
                    d.limit = d.length;
                    d.offset = d.start;
                },
                dataSrc: function(json) {
                    return json.data.length ? json.data : [];
                }
            },
            columns: [
                { data: 'rank' },
                { data: 'area' },
                { data: 'store_code' },
                { data: 'brand_ambassadors' },
                { data: 'ba_deployment_dates' },
                { data: 'brands' },
                { data: 'ly_scanned_data' },
                { data: 'actual_sales', render: formatTwoDecimals },
                { data: 'target_sales' },
                { data: 'percent_ach' },
                { data: 'growth' },
                { data: 'balance_to_target', render: formatTwoDecimals },
                { data: 'possible_incentives', render: formatFourDecimals  },
                { data: 'target_per_remaining_days', render: formatNoDecimals }
            ].filter(Boolean),
            pagingType: "full_numbers",
            pageLength: 10,
            processing: true,
            serverSide: true,
            searching: false,
            lengthChange: false
        });
        addColumnToggle(table);
    }

    function formatNoDecimals(data) {
        return data ? Number(data).toLocaleString('en-US', { maximumFractionDigits: 0 }) : '0';
    }

    function formatTwoDecimals(data) {
        return data ? Number(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : '0.00';
    }

    function formatFourDecimals(data) {
        return data ? Number(data).toLocaleString('en-US', { minimumFractionDigits: 4, maximumFractionDigits: 4 }) : '0.0000';
    }

    function formattedDate(data) {
        if (!data) return ''; 

        let date = new Date(data);
        let options = { month: 'short', day: '2-digit', year: 'numeric' };
        return date.toLocaleDateString('en-US', options).replace(',', '');
    }

    function addColumnToggle(table) {
        $('.mx-2').remove();
        table.columns().every(function(index) {
            let column = this;
            let columnHeader = $(column.header());
            if (columnHeader.hasClass('sort')) {
                let columnTitle = columnHeader.text();

                let checkbox = $('<input>', {
                    type: 'checkbox',
                    checked: true,
                    change: function() {
                        column.visible($(this).prop('checked'));
                    }
                });
                $('#columnToggleContainer').append(
                    $('<label class="mx-2 col">').append(checkbox, " " + columnTitle)
                );
            }
        });
    }

    function handleAction(action) {
        modal.loading(true);
    
        let selectedStore = $('#store').val();
        let selectedArea = $('#area').val();
        let selectedMonth = $('#month').val();
        let selectedYear = $('#year').val();
        let selectedSortField = $('#sortBy').val();
        let selectedSortOrder = $('input[name="sortOrder"]:checked').val();

        let url = base_url + 'store/per-ba-generate-' + (action === 'export_pdf' ? 'pdf' : 'excel') + '?'
            + 'sort_field=' + encodeURIComponent(selectedSortField)
            + '&sort=' + encodeURIComponent(selectedSortOrder)
            + '&store=' + encodeURIComponent(selectedStore)
            + '&area=' + encodeURIComponent(selectedArea)
            + '&month=' + encodeURIComponent(selectedMonth)
            + '&year=' + encodeURIComponent(selectedYear)
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
</script>
