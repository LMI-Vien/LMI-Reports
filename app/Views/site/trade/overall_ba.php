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
        color: white;
        font-weight: bold;
        font-family: 'Poppins', sans-serif;
        font-size: 1.5rem; 
        text-align: center;
        background: linear-gradient(90deg, #fdb92a, #ff9800);
        border: none;
        border-radius: 12px;
        transition: transform 0.2s ease-in-out;
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
        font-weight: bold; 
        color: white;
        background-color: #301311 !important;
    }

    #previewButton{
        color: #fff;
        background-color: #143996 !important;
    }

    #overall_ba_sales_tbl {
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

    .card {
        border-radius: 12px !important;
        background: #ffffff;
        transition: transform 0.3s ease-in-out;
    }

    .card-dark {
        border-radius: 12px !important;
        border: #dee2e6, solid, 1px;
    }

    /* Set specific column widths */
    th:nth-child(1), td:nth-child(1) { width: 5%; } /* Rank */
    th:nth-child(2), td:nth-child(2) { width: 5%; } /* Store Code */
    th:nth-child(3), td:nth-child(3) { width: 5%; } /* Area */
    th:nth-child(4), td:nth-child(4) { width: 10%; } /* Store Name */
    th:nth-child(5), td:nth-child(5) { width: 10%; } /* Actual Sales */
    th:nth-child(6), td:nth-child(6) { width: 10%; } /* Target */
    th:nth-child(7), td:nth-child(7) { width: 5%; } /* % Ach */
    th:nth-child(8), td:nth-child(8) { width: 10%; } /* Balance To Target */
    th:nth-child(9), td:nth-child(9) { width: 10%; } /* Possible Incentives */
    th:nth-child(10), td:nth-child(10) { width: 10%; } /* Target per Remaining days */
    th:nth-child(10), td:nth-child(10) { width: 5%; }
    th:nth-child(10), td:nth-child(10) { width: 5%; }
    th:nth-child(10), td:nth-child(10) { width: 10%; } 
    th:nth-child(10), td:nth-child(10) { width: 5%; } 
    th:nth-child(10), td:nth-child(10) { width: 5%; } 
</style>

<div class="wrapper">
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid py-4">
                <div class="card shadow-lg" style="width: 100%;">
                    <div class="md-center p-2 col">
                        <h5 class="mt-1 mb-1">
                            <i class="fas fa-filter"></i> 
                            <span>
                                F I L T E R
                            </span>
                        </h5>
                    </div>

                    <div class="row p-4">
                        <div class="col-md-6 column text-left">
                            <div class="col-md-12 row p-2">
                                <div class="col-md-3">
                                    <label for="store" class="pl-2">Store Name</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" id="store" class="form-control" placeholder="Please select...">
                                    <input type="hidden" id="store_id">
                                </div>
                            </div>
                            <div class="col-md-12 row p-2">
                                <div class="col-md-3">
                                    <label for="area" class="pl-2">Area</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" id="area" class="form-control" placeholder="Please select...">
                                    <input type="hidden" id="area_id">
                                </div>
                            </div>
                            <div class="col-md-12 row p-2">
                                <div class="col-md-3">
                                    <label for="month" class="pl-2">Month/Year</label>
                                </div>
                                <div class="row col-md">
                                    <div class="col-md-6">
                                        <select class="form-control" id="month">
                                            <option value="0">Select Month...</option>
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
                                            <option value="0">Select Year...</option>
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
                        <div class="col-md-4">
                            <div class="text-left column card-dark p-2">
                                <label class="col-md">Sort By</label>
    
                                <div class="col-md">
                                    <select class="form-control" id="sortBy">
                                        <option value="rank">Rank</option>
                                        <option value="store_code">Store Code</option>
                                        <option value="area">Area</option>
                                        <option value="store_name">Store Name</option>
                                        <option value="actual_sales">Actual Sales</option>
                                        <option value="target">Target</option>
                                        <option value="arch">%Arch</option>
                                        <option value="balance_to_target">Balance to Target</option>
                                        <option value="Possible_incentives">Possible Incentives</option>
                                        <option value="target_per_rem_days">Target per Remaining Days</option>
                                    </select>
                                </div>
    
                                <div class="col-md pt-2 row">
                                    <div class="col-md">
                                        <input type="radio" name="sortOrder" value="ASC" checked> Ascending
                                    </div>
                                    <div class="col-md">
                                        <input type="radio" name="sortOrder" value="DESC"> Descending
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 column">
                            <div class="p-2 d-flex justify-content-end">
                                <button class="btn btn-primary btn-sm filter_buttons" id="refreshButton" style="border-radius: 13px;"><i class="fas fa-sync-alt"></i> Refresh</button>
                            </div>
                            <div class="p-2 d-flex justify-content-end">
                                <button id="clearButton" class="btn btn-secondary btn-sm filter_buttons"><i class="fas fa-sync-alt"></i> Clear</button>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button class="btn btn-secondary" id="toggleColumnsButton"><i class="fas fa-columns"></i> Toggle Columns</button>
                            </div>

                        </div>
                        <div class="sortable row text-center p-2" id="columnToggleContainer" class="mb-3">
                            <strong class="col">Select Columns:</strong>
                        </div>
                    </div>
                </div>

                <!-- DataTables Section -->
                <div class="card mt-4 p-4 shadow-sm">
                    <div class="tbl-title-header p-2"><h5>OVERALL BA SALES TARGET</h5></div>
                    <div class="mb-3" style="overflow-x: auto; height: 450px; padding: 0px;">
                        <table id="overall_ba_sales_tbl" class="table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th class="tbl-title-field">Rank</th>
                                    <th class="tbl-title-field">Store Code</th>
                                    <th class="tbl-title-field">Area</th>
                                    <th class="tbl-title-field">Store Name</th>
                                    <th class="tbl-title-field">Actual Sales</th>
                                    <th class="tbl-title-field">Target</th>
                                    <th class="tbl-title-field">% Ach</th>
                                    <th class="tbl-title-field">Balance To Target</th>
                                    <th class="tbl-title-field">Possible Incentives</th>
                                    <th class="tbl-title-field">Target per Remaining days</th>
                                    <th class="tbl-title-field sort">LY Scanned Data</th>
                                    <th class="tbl-title-field sort">Brand Ambassador</th>
                                    <th class="tbl-title-field sort">Deployed Date</th>
                                    <th class="tbl-title-field sort">Brand</th>
                                    <th class="tbl-title-field sort">Growth</th>

                                </tr>
                            </thead>
                            <tbody>
                                <td colspan="15">No data available</td>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Buttons -->
                <div class="d-flex justify-content-end mt-3 gap-2">
                    <button class="btn btn-info" id="previewButton" onclick="handleAction('preview')"><i class="fas fa-eye"></i> Preview</button>
                    <button class="btn btn-success" id="exportButton" onclick="handleAction('export')"><i class="fas fa-file-export"></i> Export</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DataTables and Script -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.5.0/css/colReorder.dataTables.min.css">
<script src="https://cdn.datatables.net/colreorder/1.5.0/js/dataTables.colReorder.min.js"></script>
 -->

 <!-- FileSaver -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<script>
    var base_url = "<?= base_url(); ?>";
    let store_branch = <?= json_encode($store_branch) ?>;
    let area = <?= json_encode($area) ?>;

    $(document).ready(function() {
        $( ".sortable" ).sortable({
            revert: true
        });

        initializeTable();
        autocomplete_field($("#store"), $("#store_id"), store_branch);
        autocomplete_field($("#area"), $("#area_id"), area, "area_description");
        $('#columnToggleContainer').toggle();
        $(document).on('click', '#toggleColumnsButton', function() {
            $('#columnToggleContainer').toggle();
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

        $(document).on('click', '#clearButton', function () {
            $('input[type="text"], input[type="number"], input[type="date"]').val('');
            $('input[name="sortOrder"][value="ASC"]').prop('checked', true);
            $('input[name="sortOrder"][value="DESC"]').prop('checked', false);
            $('.main_all').addClass('active');
            $('select').prop('selectedIndex', 0);
            $('#refreshButton').click();
        });
    });

    function fetchData() {
      //  let selectedType = $('input[name="filterType"]:checked').val();
       // let selectedBa = $('#brand_ambassador').val();
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
                url: base_url + 'trade-dashboard/trade-overall-ba',
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
                { data: 'store_code' },
                { data: 'area' },
                { data: 'store_name' },
                { data: 'actual_sales', render: formatTwoDecimals },
                { data: 'target_sales' },
                { data: 'percent_ach' },
                { data: 'balance_to_target', render: formatTwoDecimals },
                { data: 'possible_incentives', render: formatFourDecimals  },
                { data: 'target_per_remaining_days', render: formatNoDecimals },
                { data: 'ly_scanned_data' },
                { data: 'brand_ambassadors' },
                { data: 'deployment_date', render: formattedDate },
                { data: 'brands' },
                { data: 'growth' }
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
        let selectedStore = $('#store_id').val();
        let selectedArea = $('#area_id').val();
        let selectedMonth = $('#month').val();
        let selectedYear = $('#year').val();
        let selectedSortField = $('#sortBy').val();
        let selectedSortOrder = $('input[name="sortOrder"]:checked').val();

        if (action === 'preview') {
            let link = `${selectedStore}-${selectedArea}-${selectedMonth}-${selectedYear}-${selectedSortField}-${selectedSortOrder}`;
            console.log(link, 'link');
            window.open(`<?= base_url()?>trade-dashboard/trade-overall-ba-view/${link}`, '_blank');
        } else if (action === 'export') {
            prepareExport();
        } else {
            alert('wtf are u doing?')
        }
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
                    ({ rank, store_code, area, store_name, actual_sales, target_sales, percent_ach, balance_to_target, possible_incentives, 
                        target_per_remaining_days, ly_scanned_data, brand_ambassadors, deployment_date, brands, growth 
                    }) => ({
                        "Rank": rank,
                        "Store Code": store_code,
                        "Area": area,
                        "Store Name": store_name,
                        "Actual Sales": actual_sales,
                        "Target": target_sales,
                        "% Ach": percent_ach,
                        "Balance To Target": balance_to_target,
                        "Possible Incentives": possible_incentives,
                        "Target per Remaining days": target_per_remaining_days,
                        "LY Scanned Data": ly_scanned_data,
                        "Brand Ambassador": brand_ambassadors,
                        "Deployed Date": deployment_date,
                        "Brand": brands,
                        "Growth": growth
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
            console.log(results, 'results');

            const headerData = [
                ["LIFESTRONG MARKETING INC."],
                ["Report: Overall BA Sales Target"],
                ["Date Generated: " + formatDate(new Date())],
                ["Store Name: " + $('#store').val()],
                ["Area: " + $('#area').val()],
                ["Month: " + ($('#month option:selected').text() === "Select Month..." ? "All" : $('#month option:selected').text())],
                ["Year: " + ($('#year option:selected').text() === "Select Year..." ? "All" : $('#year option:selected').text())],
                [""]
            ];
    
            exportArrayToCSV(results, `Report: BA Dashboard - ${formatDate(new Date())}`, headerData);
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
                url: base_url + 'trade-dashboard/trade-overall-ba',
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
