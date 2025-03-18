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
        font-family: 'Courier New', Courier, monospace;
        font-size: large;
        background-color: #fdb92a;
        color: #333333;
        border: 1px solid #ffffff;
        border-radius: 10px;
        text-align: center;
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

    #previewButton, #exportButton {
        background-color: #143996 !important;
        color: white;
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

label {
    float: left;
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
                <div class="card p-4 shadow-sm">
                    <div class="md-center mb-3">
                        <h5><i class="fas fa-filter"></i> Filter</h5>
                    </div>
                    <div class="row g-3">
                        <!-- Left Side: Inputs -->
                        <div class="col-md-9">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="store">Store Name</label>
                                    <input id="store" class="form-control" placeholder="Please select...">
                                    <input type="hidden" id="store_id">
                                </div>
                                <div class="col-md-4">
                                    <label for="area">Area</label>
                                    <input id="area" class="form-control" placeholder="Please select...">
                                    <input type="hidden" id="area_id">
                                </div>
                                <div class="col-md-4 d-flex gap-2">
                                    <div>
                                        <label for="month">Month</label>
                                        <select class="form-control" id="month">
                                            <option value="0">Please select..</option>
                                            <?php
                                                if($month){
                                                    foreach ($month as $value) {
                                                        echo "<option value=".$value['id'].">".$value['month']."</option>";
                                                    }                                                
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="year">Year</label>
                                        <select class="form-control" id="year">
                                            <option value="0">Please select..</option>
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
                        
                        <!-- Right Side: Sort Filters -->
                        <div class="col-md-3">
                            <label>Sort By</label>
                            <div class="d-flex gap-3">
                                <select class="form-control" id="sortBy">
                                    <option value="rank">Rank</option>
                                    <option value="store">Store</option>
                                </select>
                                <div class="d-flex align-items-center gap-3">
                                    <input type="radio" name="sortOrder" value="asc" checked> Asc
                                    <input type="radio" name="sortOrder" value="desc"> Desc
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="button" id="clearButton" class="btn btn-secondary btn-sm" style="width: 90px; height: 32px;">Clear</button>
                                <button class="btn btn-primary btn-sm ml-2" id="refreshButton" style="width: 90px; height: 32px;">
                                    <i class="fas fa-sync-alt"></i> Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DataTables Section -->
                <div class="card mt-4 p-4 shadow-sm">
                    <div class="tbl-title-bg"><h5>OVERALL BA SALES TARGET</h5></div>
                    <div class="mb-3" style="overflow-x: auto; height: 450px; padding: 0px;">
                        <table id="info_for_asc" class="table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Area</th>
                                    <th>Area Sales Coordinator</th>
                                    <th>Actual Sales Report</th>
                                    <th>Target</th>
                                    <th>% Achieved</th>
                                    <th>Balance To Target</th>
                                    <th>Target per Remaining days</th>

                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Buttons -->
                <div class="d-flex justify-content-end mt-3 gap-2">
                    <button class="btn btn-info" id="previewButton"><i class="fas fa-eye"></i> Preview</button>
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
                    console.log(json.data);
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
