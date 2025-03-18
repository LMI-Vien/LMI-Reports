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

    #previewButton, #exportButton {
        background-color: #143996 !important;
        color: white;
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

    #refreshButton {
        width: 10em;
        height: 3em;
        border-radius: 12px;
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
                                    <input id="store" class="form-control" placeholder="Please select...">
                                    <input type="hidden" id="store_id">
                                </div>
                            </div>
                            <div class="col-md-12 row p-2">
                                <div class="col-md-3">
                                    <label for="area" class="pl-2">Area</label>
                                </div>
                                <div class="col-md-9">
                                    <input id="area" class="form-control" placeholder="Please select...">
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
                                        <input type="radio" name="sortOrder" value="asc" checked> Ascending
                                    </div>
                                    <div class="col-md">
                                        <input type="radio" name="sortOrder" value="desc"> Descending
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 column">
                            <div class="p-2 d-flex justify-content-end">
                                <button class="btn btn-primary btn-sm" id="refreshButton"><i class="fas fa-sync-alt"></i> Refresh</button>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button class="btn btn-secondary" id="toggleColumnsButton"><i class="fas fa-columns"></i> Toggle Columns</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="columnToggleContainer" class="mb-3">
                    <strong>Select Columns:</strong>
                </div>
                <!-- DataTables Section -->
                <div class="card mt-4 p-4 shadow-sm">
                    <div class="tbl-title-bg"><h5>OVERALL BA SALES TARGET</h5></div>
                    <div class="mb-3" style="overflow-x: auto; height: 450px; padding: 0px;">
                        <table id="overall_ba_sales_tbl" class="table table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Store Code</th>
                                    <th>Area</th>
                                    <th>Store Name</th>
                                    <th>Actual Sales</th>
                                    <th>Target</th>
                                    <th>% Ach</th>
                                    <th>Balance To Target</th>
                                    <th>Possible Incentives</th>
                                    <th>Target per Remaining days</th>
                                    <th class="sort">LY Scanned Data</th>
                                    <th class="sort">Brand Ambassador</th>
                                    <th class="sort">Deployed Date</th>
                                    <th class="sort">Brand</th>
                                    <th class="sort">Growth</th>

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
<script src="https://cdn.datatables.net/colreorder/1.5.0/js/dataTables.colReorder.min.js"></script>
 -->
<script>
    var base_url = "<?= base_url(); ?>";
    let store_branch = <?= json_encode($store_branch) ?>;
    let area = <?= json_encode($area) ?>;

    $(document).ready(function() {

        initializeTable();
        autocomplete_field($("#store"), $("#store_id"), store_branch);
        autocomplete_field($("#area"), $("#area_id"), area, "area_description");

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

        console.log(selectedStore);

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
                    console.log(json.data);
                    return json.data.length ? json.data : [];
                }
            },
            columns: [
                { data: 'rank' },
                { data: 'store_code' },
                { data: 'area' },
                { data: 'store_name' },
                { data: 'actual_sales' },
                { data: 'target_sales' },
                { data: 'percent_ach' },
                { data: 'balance_to_target' },
                { data: 'possible_incentives' },
                { data: 'target_per_remaining_days' },
                { data: 'ly_scanned_data' },
                { data: 'brand_ambassadors' },
                { data: 'deployment_date' },
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
                    $('<label class="mx-2">').append(checkbox, " " + columnTitle)
                );
            }
        });
    }
</script>
