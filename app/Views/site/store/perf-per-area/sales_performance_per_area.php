<?php
    $dir = dirname(__FILE__);
    $minify = new \App\Libraries\MinifyLib();

    echo $minify->css($dir . '/assets/custom.css', 'Store Custom CSS');
    echo $minify->js($dir . '/assets/function.js', 'App Functions JS');
?>

<?= view("site/store/perf-per-area/sales_performance_per_area_filter"); ?> 

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
                <div class="col-md-12">
                    <div class="card mt-4 p-4 shadow-sm hide-div">
                        <div class="mb-3" style="overflow-x: auto; height: 450px; padding: 0px;">
                            <table id="info_for_asc" class="table table-bordered table-responsive" style="width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="10"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                        >
                                            Store Sales Performance per Area
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-title-field">Rank</th>
                                        <th class="tbl-title-field">Area</th>
                                        <th class="tbl-title-field">Area Sales Coordinator</th>
                                        <th class="tbl-title-field">LY Scan Data</th>
                                        <th class="tbl-title-field">Actual Sales Report</th>
                                        <th class="tbl-title-field">Target</th>
                                        <th class="tbl-title-field">% Achieved</th>
                                        <th class="tbl-title-field">% Growth</th>
                                        <th class="tbl-title-field">Balance To Target</th>
                                        <th class="tbl-title-field">Target Per Remaining Days</th>

                                    </tr>
                                </thead>
                                      <tbody>
                                          <tr>
                                              <td colspan="10" class="text-center py-4 text-muted">
                                              </td>
                                          </tr>
                                          <tr>
                                              <td colspan="10" class="text-center py-4 text-muted">
                                                  No data available
                                              </td>
                                          </tr>
                                          <tr>
                                              <td colspan="10" class="text-center py-4 text-muted">
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
</div>

<script>
    var base_url = "<?= base_url(); ?>";
    let store_branch = <?= json_encode($store_branch) ?>;
    let area = <?= json_encode($area) ?>;

    $(document).ready(function() {

        initializeTable();
        autocomplete_field($("#store"), $("#store_id"), store_branch, "description", "id", function(result) {
            let data = {
                event: "list",
                select: "",
                query: "tbl_store_group.store_id = " + result.id,
                table: "tbl_store_group",
                join: [
                    {
                        table: "tbl_area",
                        query: "tbl_store_group.area_id = tbl_area.id",
                        type: "left"
                    }
                ]
            }

            aJax.post(base_url + "cms/global_controller", data, function(res) {
                let area_description = JSON.parse(res);
  
                $("#area").val(area_description[0].description);
                $("#area_id").val(area_description[0].id)
            })
        });

        autocomplete_field($("#area"), $("#area_id"), area, "area_description", "id", function(result) {
            let data = {
                event: "list",
                select: "",
                query: "area_id = " + result.id,
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
                let store_description = JSON.parse(res);

                $("#store").val("");
                $("#store_id").val("");

                store_branch = store_description;

                autocomplete_field($("#store"), $("#store_id"), store_branch, "description", "id", function(res) {
                    let data = {
                        event: "list",
                        select: "",
                        query: "id = " + res.store_id,
                        table: "tbl_store"
                    }

                    aJax.post(base_url + "cms/global_controller", data, function(res) {
                        let store_description = JSON.parse(res);
                        $("#store_id").val(store_description[0].id);
                    })
                })
            })
        });



    });

        $(document).on('click', '#clearButton', function () {
            $('input[type="text"]').val('');
            $('input[type="checkbox"]').prop('checked', false);
            $('input[name="sortOrder"][value="ASC"]').prop('checked', true);
            $('input[name="sortOrder"][value="DESC"]').prop('checked', false);
            $('select').prop('selectedIndex', 0);
            $('.table-empty').show();
            $('.hide-div').hide();
            $('#refreshButton').click();
        });

        // $(document).on('click', '#refreshButton', function () {
        //     if($('#area').val() == ""){
        //         $('#area_id').val('');
        //     }
        //     if($('#store').val() == ""){
        //         $('#store_id').val('');
        //     }
        //     $('.table-empty').hide();
        //     $('.hide-div').show();
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
        
        if ($.fn.DataTable.isDataTable('#info_for_asc')) {
            let existingTable = $('#info_for_asc').DataTable();
            existingTable.clear().destroy();
        }

        let table = $('#info_for_asc').DataTable({
            paging: true,
            searching: false,
            ordering: true,
            info: true,
            lengthChange: false,
            colReorder: true, 
            ajax: {
                url: base_url + 'store/get-sales-performance-per-area',
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
                    console.log(json);
                    return json.data.length ? json.data : [];
                }
            },
            columns: [
                { data: 'rank' },
                { data: 'area' },
                { data: 'asc_names' },
                { data: 'actual_sales', render: formatTwoDecimals },
                { data: 'actual_sales', render: formatTwoDecimals },
                { data: 'target_sales' },
                { data: 'percent_ach' },
                { data: 'percent_ach' },
                { data: 'balance_to_target', render: formatTwoDecimals },
                { data: 'target_per_remaining_days', render: formatNoDecimals }
            ].filter(Boolean),
            pagingType: "full_numbers",
            pageLength: 10,
            processing: true,
            serverSide: true,
            searching: false,
            lengthChange: false
        });
    }

    function formatNoDecimals(data) {
        return data ? Number(data).toLocaleString('en-US', { maximumFractionDigits: 0 }) : '0';
    }

    function formatTwoDecimals(data) {
        return data ? Number(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : '0.00';
    }

    function handleAction(action) {
        let selectedStore = $('#store_id').val() || "0";
        let selectedArea = $('#area_id').val() || "0";
        let selectedMonth = $('#month').val() || "0";
        let selectedYear = $('#year').val() || "0";
        let selectedStoreName = $('#store_id').val() || "0";
        let selectedAreaName = $('#area_id').val() || "0";
        let selectedMonthName = $("#month option:selected").text() || "0";
        let selectedYearName = $("#year option:selected").text() || "0";
        let selectedSortField = $('#sortBy').val() || "0";
        let selectedSortOrder = $('input[name="sortOrder"]:checked').val() || "0";


        if(selectedMonthName == "Please month.."){
            selectedMonthName = "0";
        }

        if(selectedYearName == "Please year.."){
            selectedYearName = "0";    
        }

        let url = base_url + 'store/per-area-generate-' + (action === 'export_pdf' ? 'pdf' : 'excel') + '?'
            + 'sort_field=' + encodeURIComponent(selectedSortField)
            + '&sort=' + encodeURIComponent(selectedSortOrder)
            + '&store=' + encodeURIComponent(selectedStoreName || '')
            + '&area=' + encodeURIComponent(selectedAreaName || '')
            + '&month=' + encodeURIComponent(selectedMonthName || '')
            + '&year=' + encodeURIComponent(selectedYearName || '');

        console.log(url);

        let iframe = document.createElement('iframe');
        iframe.style.display = "none";
        iframe.src = url;
        document.body.appendChild(iframe);
        
        // if (action === 'export_pdf') {
        //     var url = "<?= base_url("trade-dashboard/set-asc-preview-session");?>";
        //     var data = {
        //         store : selectedStore,
        //         area : selectedArea,
        //         month : selectedMonth,
        //         year : selectedYear,
        //         storename : selectedStoreName,
        //         areaname : selectedAreaName,
        //         monthname : selectedMonthName,
        //         yearname : selectedYearName,
        //         sortfield : selectedSortField,
        //         sortorder : selectedSortOrder

        //     }

        //     console.log(url);

        //     aJax.post(url,data,function(result){
        //         if(result.status == "success"){
        //             // window.location.href = "<?= base_url('trade-dashboard/asc-view') ?>";
        //             console.log(url);
        //         }
                
        //     });
        // } else if (action === 'export') {
        //     prepareExport();
        // } else {
            
        // }
    }

    function prepareExport() {
        let selectedStore = $('#store_id').val();
        let selectedArea = $('#area_id').val();
        let selectedMonth = $('#month').val();
        let selectedYear = $('#year').val();
        let selectedSortField = $('#sortBy').val();
        let selectedSortOrder = $('input[name="sortOrder"]:checked').val();

        let fetchPromise = new Promise((resolve, reject) => {
        fetchTradeDashboardData({
            selectedStore, 
            selectedArea, 
            selectedMonth, 
            selectedYear, 
            selectedSortField, 
            selectedSortOrder,
            length: 1000,
            start: 0,
            onSuccess: function(data) {
                let newData = data.map(
                    ({ rank, area, asc_names, actual_sales, target_sales, percent_ach, balance_to_target, 
                        target_per_remaining_days
                    }) => ({
                        "Rank": rank,
                        "Area": area,
                        "Area Sales Coordinator": asc_names,
                        "Actual Sales": actual_sales,
                        "Target": target_sales,
                        "% Ach": percent_ach,
                        "Balance To Target": balance_to_target,
                        "Target per Remaining days": target_per_remaining_days,


                        // "Store Code": store_code,
                        // "Store Name": store_name,
                        // "Actual Sales": actual_sales,
                        // "Possible Incentives": possible_incentives,
                        // "LY Scanned Data": ly_scanned_data,
                        // "Brand Ambassador": brand_ambassadors,
                        // "Deployed Date": deployment_date,
                        // "Brand": brands,
                        // "Growth": growth
                    })
                )
                resolve(newData);
            },
            onError: function(error) {
                reject(error);
            }
        });
    });

    fetchPromise
        .then(results => {
            const headerData = [
                ["LIFESTRONG MARKETING INC."],
                ["Report: Information for Area Sales Coordinator"],
                ["Date Generated: " + formatDate(new Date())],
                ["Store Name: " + $('#store').val()],
                ["Area: " + $('#area').val()],
                ["Month: " + ($('#month option:selected').text() === "Select Month..." ? "All" : $('#month option:selected').text())],
                ["Year: " + ($('#year option:selected').text() === "Select Year..." ? "All" : $('#year option:selected').text())],
                [""]
            ];
    
            exportArrayToCSV(results, `Report: ASC Dashboard - ${formatDate(new Date())}`, headerData);
        })
        .catch(error => {
            console.log(error, 'error');
        });

    }

    function fetchTradeDashboardData({ 
        baseUrl, 
        selectedStore = null, 
        selectedArea = null, 
        selectedMonth = null, 
        selectedYear = null, 
        selectedSortField = null, 
        selectedSortOrder = null,
        length, 
        start, 
        onSuccess, 
        onError 
    }) {
        let allData = [];

        function fetchData(offset) {
            $.ajax({
                url: base_url + 'trade-dashboard/trade-info-asc',
                type: 'GET',
                data: {
                    store : selectedStore === "0" ? null : selectedStore,
                    area : selectedArea === "0" ? null : selectedArea,
                    month : selectedMonth === "0" ? null : selectedMonth,
                    year : selectedYear === "0" ? null : selectedYear,
                    sort_field : selectedSortField,
                    sort : selectedSortOrder,
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
        // Create a new worksheet
        const worksheet = XLSX.utils.json_to_sheet(data, { origin: headerData.length });

        // Add header rows manually
        XLSX.utils.sheet_add_aoa(worksheet, headerData, { origin: "A1" });

        // Convert worksheet to CSV format
        const csvContent = XLSX.utils.sheet_to_csv(worksheet);

        // Convert CSV string to Blob
        const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });

        // Trigger file download
        saveAs(blob, filename + ".csv");
    }

</script>
