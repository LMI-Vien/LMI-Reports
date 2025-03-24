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
                                            <option value="0">Please month..</option>
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
                                            <option value="0">Please year..</option>
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
                                <div class="col-md mt-3">
                                    <input type="radio" name="sortOrder" value="asc" checked> Asc
                                    <input type="radio" name="sortOrder" value="desc"> Desc
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
                                        OVERALL BA SALES TARGET
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
                    <button class="btn btn-info mr-2" id="previewButton"><i class="fas fa-eye"></i> Preview</button>
                    <button class="btn btn-success" id="exportButton"><i class="fas fa-file-export"></i> Export</button>
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

<script>
    var base_url = "<?= base_url(); ?>";
    let store_branch = <?= json_encode($store_branch) ?>;
    let area = <?= json_encode($area) ?>;

    $(document).ready(function() {

        initializeTable();
        autocomplete_field($("#store"), $("#store_id"), store_branch);
        autocomplete_field($("#area"), $("area_id"), area, "area_description");


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
                    return json.data.length ? json.data : [];
                }
            },
            columns: [
                { data: 'rank' },
                { data: 'area' },
                { data: 'asc_names' },
                { data: 'actual_sales' },
                { data: 'target_sales' },
                { data: 'percent_ach' },
                { data: 'balance_to_target' },
                { data: 'target_per_remaining_days' }
            ].filter(Boolean),
            pagingType: "full_numbers",
            pageLength: 10,
            processing: true,
            serverSide: true,
            searching: false,
            lengthChange: false
        });
    }

</script>
