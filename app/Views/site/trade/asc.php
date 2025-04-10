<style>
    .content-wrapper, .content {
        margin-top: 0 !important;
        padding-top: 0 !important;
        padding-bottom: 30px;
    }

    footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        background: #f8f9fa;
        padding: 10px;
        text-align: center;
        box-shadow: 0 -2px 5px rgba(0,0,0,0.1);
    }

    .md-center {
        padding: 5px;
        font-family: 'Poppins', sans-serif;
        font-size: large;
        font-weight: bold;
        color: white;
        text-align: center;
        border: 1px solid #ffffff;
        border-radius: 12px;
        transition: transform 0.2s ease-in-out;
        background: linear-gradient(90deg, #fdb92a, #ff9800);
    }

    th {
        color: #fff;
        background-color: #301311 !important;
    }

    .tbl-title-bg {
        color: #fff;
        border-radius: 5px;
        background-color: #143996 !important;
        padding: 10px;
        text-align: center;
    }

    #previewButton{
        color: #fff;
        background-color: #143996 !important;
    }

    .tbl-title-header {
        border-radius: 8px 8px 0px 0px ;
        color: #fff;
        border-radius: 5px;
        background-color: #301311 ;
        padding: 10px;
        text-align: center;
    }
    .tbl-title-field {
        background: linear-gradient(to right, #143996, #007bff);
        color: #fff;
        text-align: center;
        padding: 10px;
        font-size: 18px;
        font-weight: bold;
    }

    .filter-button {
        width: 10em;
        height: 3em;
        border-radius: 12px;
        box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.5);
    }

    #exportButton {
        color: white;
    }

    #previewButton{
        color: #fff;
        background-color: #143996 !important;
    }

    #dataTable4 {
        table-layout: fixed;
        width: 100%;
    }

    table {
        width: 100%;
        table-layout: fixed; /* Ensures fixed column widths */
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
        min-width: 100px; /* Prevents shrinking */
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .filter_buttons {
        width: 10em;
        height: 3em;
        border-radius: 12px;
        box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.5);
    }

    #clearButton {
        width: 10em;
        height: 3em;
        border-radius: 13px;
        box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.5);
    }

    /* Title Styling */
    .tbl-title-field {
        /* background: linear-gradient(to right, #007bff, #143996); */
        background: linear-gradient(to right, #143996, #007bff);
        color: white !important;
        text-align: center;
        padding: 10px;
        font-size: 18px;
        font-weight: bold;
    }

    .tbl-title-header {
        border-radius: 8px 8px 0px 0px !important;
    }

    /* Set specific column widths */
    th:nth-child(1), td:nth-child(1) { width: 10%; } /* Rank */
    th:nth-child(2), td:nth-child(2) { width: 10%; } /* Store Code */
    th:nth-child(3), td:nth-child(3) { width: 10%; } /* Area */
    th:nth-child(4), td:nth-child(4) { width: 15%; } /* Store Name */
    th:nth-child(5), td:nth-child(5) { width: 10%; } /* Actual Sales */
    th:nth-child(6), td:nth-child(6) { width: 10%; } /* Target */
    th:nth-child(7), td:nth-child(7) { width: 10%; } /* % Ach */
    th:nth-child(8), td:nth-child(8) { width: 10%; } /* Balance To Target */
    th:nth-child(9), td:nth-child(9) { width: 10%; } /* Possible Incentives */
    th:nth-child(10), td:nth-child(10) { width: 15%; } /* Target per Remaining days */
</style>

<div class="wrapper">
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid py-4">
                <!-- Filters Section -->
                <div class="card shadow-sm">
                    <div class="text-center md-center p-2">
                        <h5 class="mt-1 mb-1">
                            <i class="fas fa-filter"></i> 
                            <span>
                                F I L T E R
                            </span>
                        </h5>
                    </div>

                    <div class="row p-4">
                        <div class="col-md-6 column p-2 text-left">
                            <div class="col-md p-1 row">
                                <div class="col-md-3">
                                    <label class="mt-2" for="store">Store Name</label>
                                </div>
                                <div class="col-md">
                                    <input type="text" id="store" class="form-control" placeholder="Please select...">
                                    <input type="hidden" id="store_id">
                                </div>
                            </div>
                            <div class="col-md p-1 row">
                                <div class="col-md-3">
                                    <label class="mt-2" for="area">Area</label>
                                </div>
                                <div class="col-md">
                                    <input type="text" id="area" class="form-control" placeholder="Please select...">
                                    <input type="hidden" id="area_id">
                                </div>
                            </div>
                            <div class="col-md p-1 row">
                                <div class="col-md-3">
                                    <label class="mt-2" for="month">Month/Year</label>
                                </div>
                                <div class="col-md row">
                                    <div class="col-md-6">
                                        <select class="form-control" id="month">
                                            <option value="0" disabled selected>Please month..</option>
                                            <?php
                                                if($month){
                                                    foreach ($month as $value) {
                                                        echo "<option value=".$value['id'].">".$value['month']."</option>";
                                                    }                                                
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control" id="year">
                                            <option value="0" disabled selected>Please year..</option>
                                            <?php
                                                if($year){
                                                    foreach ($year as $value) {
                                                        echo "<option value=".$value['id'].">".$value['year']."</option>";
                                                    }                                                
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 p-2 text-left" style="border: #dee2e6, solid, 1px; border-radius: 12px;">
                            <label class="p-2">Sort By</label>
                            <div class="column">
                                <select class="form-control col-md" id="sortBy">
                                    <option value="rank">Rank</option>
                                    <option value="area">Area</option>
                                    <option value="asc_names">Area Sales Coordinator</option>
                                    <option value="actual_sales">Actual Sales Report</option>
                                    <option value="target_sales">Target</option>
                                    <option value="percent_ach">% Arch</option>
                                    <option value="balance_to_target">Balance to Target</option>
                                    <option value="target_per_remaining_days">Target per Remaining Days</option>
                                </select>
                                <!-- <div class="col-md mt-3">
                                    <input type="radio" name="sortOrder" value="asc" checked> Asc
                                    <input type="radio" name="sortOrder" value="desc"> Desc
                                </div> -->
                                <div class="col-md mt-3">
                                    <input type="radio" id="sort_asc" name="sortOrder" value="asc" checked>
                                    <label for="sort_asc">Asc</label>

                                    <input type="radio" id="sort_desc" name="sortOrder" value="desc">
                                    <label for="sort_desc">Desc</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 p-2 column">
                            <div class="p-2 d-flex justify-content-end">
                                <button class="btn btn-primary btn-sm p-2 filter-button" id="refreshButton">
                                    <i class="fas fa-sync-alt"></i> Refresh
                                </button>
                            </div>
                            <div class="p-2 d-flex justify-content-end">
                                <button type="button" id="clearButton" class="btn btn-secondary btn-sm p-2 filter-button">Clear</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DataTables Section -->
                <div class="card mt-4 p-4 shadow-sm">
                    <div class="mb-3" style="overflow-x: auto; height: 450px; padding: 0px;">
                        <table id="info_for_asc" class="table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th 
                                        colspan="8"
                                        style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                        class="tbl-title-header"
                                    >
                                        INFORMATION FOR AREA SALES COORDINATOR
                                    </th>
                                </tr>
                                <tr>
                                    <th class="tbl-title-field">Rank</th>
                                    <th class="tbl-title-field">Area</th>
                                    <th class="tbl-title-field">Area Sales Coordinator</th>
                                    <th class="tbl-title-field">Actual Sales Report</th>
                                    <th class="tbl-title-field">Target</th>
                                    <th class="tbl-title-field">% Achieved</th>
                                    <th class="tbl-title-field">Balance To Target</th>
                                    <th class="tbl-title-field">Target per Remaining days</th>

                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td colspan="8"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" style="text-align: center;">No data available</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="8"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="8"></td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Buttons -->
                <div class="d-flex justify-content-end mt-3 gap-2">
                    <button class="btn btn-info mr-2" id="previewButton" onclick="handleAction('export_pdf')"><i class="fas fa-eye"></i> PDF</button>
                    <button class="btn btn-success" id="exportButton" onclick="handleAction('export_excel')"><i class="fas fa-file-export"></i> Excel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DataTables and Script -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.5.0/css/colReorder.dataTables.min.css">
<script src="https://cdn.datatables.net/colreorder/1.5.0/js/dataTables.colReorder.min.js"></script> -->

<!-- FileSaver -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

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


        $(document).on('click', '#clearButton', function () {
            $('input[type="text"]').val('');
            $('input[type="checkbox"]').prop('checked', false);
            $('input[name="sortOrder"][value="ASC"]').prop('checked', true);
            $('input[name="sortOrder"][value="DESC"]').prop('checked', false);
            $('select').prop('selectedIndex', 0);
            $('#refreshButton').click();
        });

        $(document).on('click', '#refreshButton', function () {
            if($('#area').val() == ""){
                $('#area_id').val('');
            }
            if($('#store').val() == ""){
                $('#store_id').val('');
            }
            fetchData();
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
                url: base_url + 'trade-dashboard/trade-info-asc',
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
                { data: 'target_sales' },
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

        let url = base_url + 'trade-dashboard/generate-' + (action === 'export_pdf' ? 'pdf' : 'excel') + '-asc?'
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
