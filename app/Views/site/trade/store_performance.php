<style>
/*    .content{
        margin-bottom: 35px;
    }*/
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

    th {
        color: #fff !important;
        background-color: #301311 !important;
    }
    .tbl-title-bg{
        color: #fff;
        border-radius: 5px;
        background-color: #143996 !important;
    }
    #previewButton{
      background-color: #143996 !important;
    }

    .card-title {
        text-align: center;
        font-size: 1.25rem;
        font-weight: bold;
    }

    .tbl-title-header {
        border-radius: 8px 8px 0px 0px !important;
    }

    /* Table Styling /
    .table {
        margin-bottom: 0;
        border-collapse: separate; / Required for border-radius /
        border-spacing: 0; / Ensures borders don't separate /
        border-radius: 12px 12px 0px 0px;
        overflow: hidden; / Ensures inner content respects border-radius */
    }

    .table th {
        color: white !important;
    }

    .table-bordered {
        border: 1px solid #ddd;
    }

    .table thead {
        background-color: #007bff;
        color: white;
        font-weight: bold;
    }

    .table tbody tr {
        transition: background 0.3s ease-in-out;
    }

    .table tbody tr:hover {
        background: rgba(0, 123, 255, 0.1);
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

    #exportButton{
        background-color: #339933 !important;
    }
    label {
        float: left;
    }
    #table-skus{
        display: none;
    }
    th:nth-child(1), td:nth-child(1) { width: 10%; } 
    th:nth-child(2), td:nth-child(2) { width: 20%; }
    th:nth-child(3), td:nth-child(3) { width: 20%; }
    th:nth-child(4), td:nth-child(4) { width: 15%; }
    th:nth-child(5), td:nth-child(5) { width: 15%; }
    th:nth-child(6), td:nth-child(6) { width: 15%; }
    th:nth-child(7), td:nth-child(7) { width: 20%; }
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
                    <!-- Left Side: Inputs -->
                    <div class="col-md-6 column text-left">
                        <div class="col-md-12 mx-auto row py-2">
                            <div class="col-md-3">
                                <label for="storeName">Month/Start</label>
                            </div>
                            <div class="col-md">
                                <select class="form-control" id="month_start">
                                    <option value="0">Please select..</option>
                                    <?php
                                        if($year){
                                            foreach ($month as $value) {
                                                echo "<option value=".$value['id'].">".$value['month']."</option>";
                                            }                                                
                                        }
                                    ?>
                                </select>
                            </div>
                        </div> 
                        <div class="col-md-12 mx-auto row py-2">
                            <div class="col-md-3">
                                <label for="storeName">Month/End</label>
                            </div>
                            <div class="col-md">
                                <select class="form-control" id="month_end">
                                    <option value="0">Please select..</option>
                                    <?php
                                        if($year){
                                            foreach ($month as $value) {
                                                echo "<option value=".$value['id'].">".$value['month']."</option>";
                                            }                                                
                                        }
                                    ?>
                                </select>
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-4 column text-left"> 
                        <div class="col-md-12 mx-auto row py-2">
                            <div class="col-md-3">
                                <label for="year">Year</label>
                            </div>
                            <div class="col-md">
                                <select class="form-control" id="year">
                                    <option value="0">Please select..</option>
                                    <?php
                                        if($year){
                                            $maxYear = max(array_column($year, 'year')); 
                                            foreach ($year as $value) {
                                                $selected = ($value['year'] == $maxYear) ? 'selected' : '';
                                                echo "<option value='{$value['id']}' {$selected}>{$value['year']}</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div> 
                    </div>    
                    <div class="col-md-2">
                        <!-- Refresh Button -->
                        <div class="row">
                            <div class="p-3 d-flex justify-content-end">
                                <button class="btn btn-primary btn-sm filter_buttons" id="refreshButton">
                                    <i class="fas fa-sync-alt"></i> Refresh
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="p-3 d-flex justify-content-end">
                                <button id="clearButton" class="btn btn-secondary btn-sm filter_buttons"><i class="fas fa-sync-alt"></i> Clear</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <!-- DataTables Section -->
                <div class="card mt-4 p-4 shadow-sm">
                    <table id="top_performing_stores" class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th 
                                    colspan="7"
                                    style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                    class="tbl-title-header"
                                >
                                    TOP PERFORMING WATSONS STORES
                                </th>
                            </tr>
                            <tr>
                                <th class="tbl-title-field">Rank</th>
                                <th class="tbl-title-field">Store Code</th>
                                <th class="tbl-title-field">Location Description</th>
                                <th class="tbl-title-field">LY Sell Out</th>
                                <th class="tbl-title-field">TY Sell Out</th>
                                <th class="tbl-title-field">% Sell Through</th>
                                <th class="tbl-title-field">Contribution</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7"></td>
                            </tr>
                            <tr>
                                <td colspan="7" style="text-align: center;">No data available</td>
                            </tr>
                            <tr>
                                <td colspan="7"></td>
                            </tr>
                            <tr>
                                <td colspan="7"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <!-- Buttons -->
                <div class="d-flex justify-content-end mt-3">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<script>
    let months = <?= json_encode($month); ?>;

    $(document).ready(function() {
        fetchData();
        $(document).on('click', '#refreshButton', function () {
            if($('#month_start').val() == ""){
                $('#month_start').val('');
            }
            if($('#month_end').val() == ""){
                $('#month_end').val('');
            }
            if($('#year').val() == ""){
                $('#year').val('');
            }
            fetchData();
        });

        $(document).on('click', '#clearButton', function () {
            $('input[type="text"], input[type="number"]').val('');
            $('select').not('#year').prop('selectedIndex', 0);
            //reset the year dd
            let highestYear = $("#year option:not(:first)").map(function () {
                return parseInt($(this).val());
            }).get().sort((a, b) => b - a)[0];

            if (highestYear) {
                $("#year").val(highestYear);
            }
            $("#refreshButton").click();
        });
    });

    function fetchData() {
        let selectedMonthStart = $('#month_start').val();
        let selectedMonthEnd = $('#month_end').val();
        let selectedYear = $('#year').val();
        initializeTable(selectedMonthStart, selectedMonthEnd, selectedYear);
    }

    function initializeTable(selectedMonthStart = null, selectedMonthEnd = null, selectedYear = null) {
        if ($.fn.DataTable.isDataTable('#top_performing_stores')) {
            let existingTable = $('#top_performing_stores').DataTable();
            existingTable.clear().destroy();
        }

        let table = $('#top_performing_stores').DataTable({
            paging: true,
            searching: false,
            ordering: true,
            info: true,
            lengthChange: false,
            colReorder: true, 
            ajax: {
                url: base_url + 'trade-dashboard/trade-store-performance',
                type: 'POST',
                data: function(d) {
                    d.year = selectedYear === "0" ? null : selectedYear;
                    d.month_start = selectedMonthStart === "0" ? null : selectedMonthStart;
                    d.month_end = selectedMonthEnd === "0" ? null : selectedMonthEnd;
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
                { data: 'store_name' },
                { data: 'ly_scanned_data' },
                { data: 'ty_scanned_data' },
                { data: 'sell_through' },
                { data: 'contribution' }
            ].filter(Boolean),
            pagingType: "full_numbers",
            pageLength: 10,
            processing: true,
            serverSide: true,
            searching: false,
            lengthChange: false
        });
    }

    $("#month_start").on("change", function() {
        let start = $("#month_start").val();
        let html = "<option value=''>Please select..</option>";

        months.forEach(month => {
            if (parseInt(month.id) >= start) {
                html += `<option value="${month.id}">${month.month}</option>`;
            }
        });

        $("#month_end").html(html);
    });

    $("#month_end").on("change", function() {
        let end = $("#month_end").val();
        let html = "<option value=''>Please select..</option>";

        months.forEach(month => {
            if (parseInt(month.id) < end) {
                html += `<option value="${month.id}">${month.month}</option>`;
            }
        });

       // $("#month_start").html(html);
    });

</script>