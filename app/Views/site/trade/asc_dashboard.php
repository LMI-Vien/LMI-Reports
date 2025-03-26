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

    /* Title Styling */
    .tbl-title-field {
        /* background: linear-gradient(to right, #007bff, #143996); */
        background: linear-gradient(to right, #143996, #007bff);
        color: black !important;
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

    /* Title Styling */
    .tbl-title-field {
        /* background: linear-gradient(to right, #007bff, #143996); */
        background: linear-gradient(to right, #143996, #007bff);
        color: black !important;
        text-align: center;
        padding: 10px;
        font-size: 18px;
        font-weight: bold;
    }

    .tbl-title-header {
        border-radius: 8px 8px 0px 0px !important;
    }

    /* Table Styling */
    .table {
        margin-bottom: 0;
        border-collapse: separate; /* Required for border-radius */
        border-spacing: 0; /* Ensures borders don't separate */
        border-radius: 12px 12px 0px 0px;
        overflow: hidden; /* Ensures inner content respects border-radius */
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

</style>

<div class="wrapper">
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid py-4">

                <!-- Filters Section -->
            <div class="card shadow-lg">
                <div class="text-center md-center p-2">
                    <h5 class="mt-1 mb-1">
                        <i class="fas fa-filter"></i> 
                        <span>
                            F I L T E R
                        </span>
                    </h5>
                </div>
                    <div class="row p-4">
                        <div class="col-md-6 column text-left" >
                            <div class="col-md-12 mx-auto row py-2" >
                                <label for="ascName" class="col-md-4 my-auto" >ASC Name</label>
                                <div class="col-md" >
                                    <input type="text" class="form-control" id="ascName" placeholder="Enter name">
                                    <input type="hidden" id="asc_id">
                                </div>
                            </div>
                            <div class="col-md-12 mx-auto row py-2" >
                                <label for="area" class="col-md-4 my-auto" >Area</label>
                                <div class="col-md" >
                                    <input type="text" class="form-control" id="area" placeholder="Enter area">
                                    <input type="hidden" id="area_id">
                                </div>
                            </div>
                            <div class="col-md-12 mx-auto row py-2" >
                                <label for="brand" class="col-md-4" >Brand</label>
                                <div class="col-md" >
                                    <input type="text" class="form-control" id="brand" placeholder="Enter brand">
                                    <input type="hidden" id="brand_id">
                                </div>
                            </div>
                            <div class="col-md-12 mx-auto row py-2" >
                                <label for="year" class="col-md-4" >Year</label>
                                <div class="col-md" >
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
                        <div class="col-md-4 column mt-1" style="border: 1px solid #dee2e6; border-radius: 12px;" >
                            <div class="col-md-12 mx-auto row my-2 py-2 text-left" >
                                <label class="my-auto col-md-12" >Covered by Selected ASC</label>
                            </div>
                            <div class="col-md-12 mx-auto row py-2 text-center" >
                                <div class="col-md-6 row" >
                                    <input type="radio" name="coveredASC" value="with_ba" class="col-md-2"><span class="col-md-10">W/ BA</span>
                                </div>
                                <div class="col-md-6 row" >
                                    <input type="radio" name="coveredASC" value="without_ba" class="col-md-2"><span class="col-md-10">W/O BA</span>
                                </div>
                            </div>
                            <div class="col-md-12 mx-auto row py-2 text-left" >
                                <label for="storeName" class="my-auto col-md-4" >Store Name</label>
                                <div class="col-md" >
                                    <input type="text" class="form-control" id="storeName" placeholder="Enter store">
                                    <input type="hidden" id="store_id">
                                </div>
                            </div>
                            <div class="col-md-12 mx-auto row py-2 text-left" >
                                <label for="ba" class="my-auto col-md-4" >BA Name</label>
                                <div class="col-md" >
                                    <input type="text" class="form-control" id="ba" placeholder="Enter BA name">
                                    <input type="hidden" id="ba_id">
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
            <div class="card p-4 shadow-sm" id="data-graph">
                <div class="text-center">
                    <h5 class="mb-3"><i class="fas fa-chart-bar"></i> ASC Performance</h5>
                </div>

                <div class="mb-3" style="overflow-x: auto; padding: 0px;">
                    <div id="chartContainer" class="d-flex flex-row"></div>
                </div>
                <!-- Data Table -->
                <div class="table-responsive mt-4">
                    <div class="mb-3" style="overflow-x: auto; height: 450px; padding: 0px;">
                    <table class="table table-bordered text-center">
                        <thead class="thead-light">
                            <tr>
                                <th class="tbl-title-field"></th>
                                <th class="tbl-title-field">Jan</th><th class="tbl-title-field">Feb</th><th class="tbl-title-field">Mar</th><th class="tbl-title-field">Apr</th><th class="tbl-title-field">May</th><th class="tbl-title-field">Jun</th>
                                <th class="tbl-title-field">Jul</th><th class="tbl-title-field">Aug</th><th class="tbl-title-field">Sep</th><th class="tbl-title-field">Oct</th><th class="tbl-title-field">Nov</th><th class="tbl-title-field">Dec</th>
                            </tr>
                        </thead>
                        <tbody class="asc-dashboard-body">
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            <div id="table-skus" style="overflow-x: auto; padding: 0px;">
                <div class="row mt-12">
                    <div class="d-flex flex-row">
                        <div class="col-md-6">
                            <div class="card p-6 shadow-sm">
                                <table id="slowMovingTable" class="table table-bordered" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th 
                                                colspan="5"
                                                style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                                class="tbl-title-header"
                                            >
                                                SLOW MOVING SKU'S
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="tbl-title-field">SKU</th>
                                            <th class="tbl-title-field">SOH Qty</th>
                                            <th class="tbl-title-field">Qty (W1)</th>
                                            <th class="tbl-title-field">Qty (W2)</th>
                                            <th class="tbl-title-field">Qty (W3)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5">No data available</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card p-6 shadow-sm">
                                <table id="overstockTable" class="table table-bordered" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th 
                                                colspan="5"
                                                style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                                class="tbl-title-header"
                                            >OVERSTOCK SKU'S</th>
                                        </tr>
                                        <tr>
                                            <th class="tbl-title-field">SKU</th>
                                            <th class="tbl-title-field">SOH Qty</th>
                                            <th class="tbl-title-field">Qty (W1)</th>
                                            <th class="tbl-title-field">Qty (W2)</th>
                                            <th class="tbl-title-field">Qty (W3)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5">No data available</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card p-6 shadow-sm">
                                <table id="npdTable" class="table table-bordered" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th 
                                                colspan="5"
                                                style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                                class="tbl-title-header"
                                            >NPD SKU'S</th>
                                        </tr>
                                        <tr>
                                            <th class="tbl-title-field">SKU</th>
                                            <th class="tbl-title-field">SOH Qty</th>
                                            <th class="tbl-title-field">Qty (W1)</th>
                                            <th class="tbl-title-field">Qty (W2)</th>
                                            <th class="tbl-title-field">Qty (W3)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5">No data available</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card p-6 shadow-sm">
                                <table id="heroTable" class="table table-bordered" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th 
                                                colspan="1"
                                                style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                                class="tbl-title-header"
                                            >HERO SKU'S</th>
                                        </tr>
                                        <tr>
                                            <th class="tbl-title-field">SKU</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5">No data available</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Buttons -->
            <div class="d-flex justify-content-end mt-3">
                <button class="btn btn-info mr-2" id="previewButton" onclick="handleAction('preview')"><i class="fas fa-eye"></i> Preview</button>
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- FileSaver -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<script>
    var base_url = "<?= base_url(); ?>";
    $(document).ready(function () {
       // let tables = ['#dataTable1', '#dataTable2', '#dataTable3', '#dataTable4'];

        let asc = <?= json_encode($asc); ?>;
        let area = <?= json_encode($area); ?>;
        let brand = <?= json_encode($brand); ?>;
        let store_branch = <?= json_encode($store_branch); ?>;
        let brand_ambassador = <?= json_encode($brand_ambassador); ?>;

        autocomplete_field($("#ascName"), $("#asc_id"), asc, "asc_description", "asc_id");
        autocomplete_field($("#area"), $("#area_id"), area, "area_description");
        autocomplete_field($("#brand"), $("#brand_id"), brand, "brand_description");
        autocomplete_field($("#storeName"), $("#store_id"), store_branch);
        autocomplete_field($("#ba"), $("#ba_id"), brand_ambassador);

        $(document).on('click', '#clearButton', function () {
            $('input[type="text"], input[type="number"], input[type="date"]').val('');
            $('input[type="radio"], input[type="checkbox"]').prop('checked', false);

            $('select').prop('selectedIndex', 0);
            $('#refreshButton').click();
        });

        $(document).on('click', '#refreshButton', function () {
            let selectedCoveredASC = $('input[name="coveredASC"]:checked').val();
            if($('#ascName').val() == ""){
                $('#asc_id').val('');
            }
            if($('#area').val() == ""){
                $('#area_id').val('');
            }
            if($('#brand').val() == ""){
                $('#brand_id').val('');
            }
            if($('#storeName').val() == ""){
                $('#store_id').val('');
            }
            if($('#ba').val() == ""){
                $('#ba_id').val('');
            }

            if(selectedCoveredASC){
                $('#data-graph').hide();
                $('#table-skus').show();
                    fetchDataTable();
            }else{
                $('#data-graph').show();
                $('#table-skus').hide();
                fetchData();
            }


        });
        fetchData();
    });

    // Define months
    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    const dataValues = {
        salesReport: [],
        targetSales: [],
        PerAchieved: []
    };

    let chartInstances = [];

    function renderCharts() {
        chartInstances.forEach(chart => chart.destroy());
        chartInstances = [];
        $('#chartContainer').html('');

        months.forEach((month, index) => {
            let chartHTML = `
                <div class="col-md-3 mb-4">
                    <div class="card p-2">
                        <h6 class="text-center card-title">${month}</h6>
                        <canvas id="chart${index}"></canvas>
                    </div>
                </div>
            `;
            $('#chartContainer').append(chartHTML);
            let ctx = document.getElementById(`chart${index}`).getContext('2d');

            let newChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["Sales Report", "Target Sales", "% Achieved"],
                    datasets: [{
                        label: month,
                        backgroundColor: ["#ffc107", "#990000", "#339933"],
                        data: [dataValues.salesReport[index], dataValues.targetSales[index], dataValues.PerAchieved[index]]
                    }]
                },
                options: {
                    responsive: true,
                    animation: true,
                    plugins: {
                        legend: { display: false } 
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
            chartInstances.push(newChart);
        });
    }

    function fetchData(){

        let selectedASC = $('#asc_id').val();
        let selectedArea = $('#area_id').val();
        let selectedBrand = $('#brand_id').val();
        let selectedYear = $('#year').val();
        let selectedStore = $('#store_id').val();
        let selectedBa = $('#ba_id').val();
        
        url = base_url + 'trade-dashboard/trade-asc-dashboard-one';
        var data = {
            asc : selectedASC,
            brand : selectedBrand,
            year : selectedYear,
            store : selectedStore,
            ba : selectedBa,
            area : selectedArea
        }
        aJax.post(url, data, function (result) {
            var html = '';
            if (result) {
                let salesData = result.data[0];

                dataValues.salesReport = [
                    salesData.amount_january, salesData.amount_february, salesData.amount_march,
                    salesData.amount_april, salesData.amount_may, salesData.amount_june,
                    salesData.amount_july, salesData.amount_august, salesData.amount_september,
                    salesData.amount_october, salesData.amount_november, salesData.amount_december
                ];
                
                dataValues.targetSales = [
                    salesData.target_sales_january, salesData.target_sales_february, salesData.target_sales_march,
                    salesData.target_sales_april, salesData.target_sales_may, salesData.target_sales_june,
                    salesData.target_sales_july, salesData.target_sales_august, salesData.target_sales_september,
                    salesData.target_sales_october, salesData.target_sales_november, salesData.target_sales_december
                ];
                
                dataValues.PerAchieved = [
                    salesData.achieved_january, salesData.achieved_february, salesData.achieved_march,
                    salesData.achieved_april, salesData.achieved_may, salesData.achieved_june,
                    salesData.achieved_july, salesData.achieved_august, salesData.achieved_september,
                    salesData.achieved_october, salesData.achieved_november, salesData.achieved_december
                ];

                $.each(result.data, function(x,y) {
                    html += '<tr><td style="background-color: #ebe6f3;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">LY Sell Out</td><td>'+(y.net_sales_january || "0.00")+'</td><td>'+(y.net_sales_february || "0.00")+'</td><td>'+(y.net_sales_march || "0.00")+'</td><td>'+(y.net_sales_april || "0.00")+'</td><td>'+(y.net_sales_may || "0.00")+'</td><td>'+(y.net_sales_june || "0.00")+'</td><td>'+(y.net_sales_july || "0.00")+'</td><td>'+(y.net_sales_august || "0.00")+'</td><td>'+(y.net_sales_september || "0.00")+'</td><td>'+(y.net_sales_october || "0.00")+'</td><td>'+(y.net_sales_november || "0.00")+'</td><td>'+(y.net_sales_december || "0.00")+'</td></tr>';
                    html += '<tr><td style="background-color: #ffc107;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Sales Report</td><td>'+(y.amount_january || "0.00")+'</td><td>'+(y.amount_february || "0.00")+'</td><td>'+(y.amount_march || "0.00")+'</td><td>'+(y.amount_april || "0.00")+'</td><td>'+(y.amount_may || "0.00")+'</td><td>'+(y.amount_june || "0.00")+'</td><td>'+(y.amount_july || "0.00")+'</td><td>'+(y.amount_august || "0.00")+'</td><td>'+(y.amount_september || "0.00")+'</td><td>'+(y.amount_october || "0.00")+'</td><td>'+(y.amount_november || "0.00")+'</td><td>'+(y.amount_december || "0.00")+'</td></tr>';
                    html += '<tr><td style="background-color: #990000;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Target Sales</td><td>'+(y.target_sales_january || "0.00")+'</td><td>'+(y.target_sales_february || "0.00")+'</td><td>'+(y.target_sales_march || "0.00")+'</td><td>'+(y.target_sales_april || "0.00")+'</td><td>'+(y.target_sales_may || "0.00")+'</td><td>'+(y.target_sales_june || "0.00")+'</td><td>'+(y.target_sales_july || "0.00")+'</td><td>'+(y.target_sales_august || "0.00")+'</td><td>'+(y.target_sales_september || "0.00")+'</td><td>'+(y.target_sales_october || "0.00")+'</td><td>'+(y.target_sales_november || "0.00")+'</td><td>'+(y.target_sales_december || "0.00")+'</td></tr>';
                    html += '<tr><td style="background-color: #ebe6f3;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Growth</td><td>'+(y.growth_january || "0.00")+'</td><td>'+(y.growth_february || "0.00")+'</td><td>'+(y.growth_march || "0.00")+'</td><td>'+(y.growth_april || "0.00")+'</td><td>'+(y.growth_may || "0.00")+'</td><td>'+(y.growth_june || "0.00")+'</td><td>'+(y.growth_july || "0.00")+'</td><td>'+(y.growth_august || "0.00")+'</td><td>'+(y.growth_september || "0.00")+'</td><td>'+(y.growth_october || "0.00")+'</td><td>'+(y.growth_november || "0.00")+'</td><td>'+(y.growth_december || "0.00")+'</td></tr>';
                    html += '<tr><td style="background-color: #339933;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">% Achieved</td><td>'+(y.achieved_january || "0.00")+'</td><td>'+(y.achieved_february || "0.00")+'</td><td>'+(y.achieved_march || "0.00")+'</td><td>'+(y.achieved_april || "0.00")+'</td><td>'+(y.achieved_may || "0.00")+'</td><td>'+(y.achieved_june || "0.00")+'</td><td>'+(y.achieved_july || "0.00")+'</td><td>'+(y.achieved_august || "0.00")+'</td><td>'+(y.achieved_september || "0.00")+'</td><td>'+(y.achieved_october || "0.00")+'</td><td>'+(y.achieved_november || "0.00")+'</td><td>'+(y.achieved_december || "0.00")+'</td></tr>';

                });
            }
            $('.asc-dashboard-body').html(html);
            renderCharts();
        });
    }

    function fetchDataTable() {
        let selectedASC = $('#ascName').val();
        let selectedArea = $('#area').val();
        let selectedBrand = $('#brand').val();
        let selectedYear = $('#year').val();
        let selectedStore = $('#store_id').val();
        let selectedBA = $('#ba').val();
        let withBA = $('input[name="coveredASC"]:checked').val();

        let tables = [
            { id: "#slowMovingTable", type: "slowMoving" },
            { id: "#overstockTable", type: "overStock" },
            { id: "#npdTable", type: "npd" },
            { id: "#heroTable", type: "hero" }
        ];

        tables.forEach(table => {
            initializeTable(table.id, table.type, selectedASC, selectedArea, selectedStore, selectedBrand, selectedBA, selectedYear, withBA);
        });
    }

    function initializeTable(tableId, type, selectedASC, selectedArea, selectedStore, selectedBrand, selectedBA, selectedYear, withBA) {

        $(tableId).DataTable({
            destroy: true,
            ajax: {
                url: base_url + 'trade-dashboard/trade-asc-dashboard-one-tables',
                type: 'POST',
                data: function (d) {

                    d.asc = selectedASC === "0" ? null : selectedASC;
                    d.area = selectedArea === "0" ? null : selectedArea;
                    d.brand = selectedBrand === "0" ? null : selectedBrand;
                    d.store = selectedStore === "0" ? null : selectedStore;
                    d.ba = selectedBA === "0" ? null : selectedBA;
                    d.year = selectedYear === "0" ? null : selectedYear;
                    d.withba = withBA;
                    d.trade_type = type;
                    d.limit = d.length;
                    d.offset = d.start;
                },
                dataSrc: function(json) {
                    return json.data.length ? json.data : [];
                }
            },
            columns: [
                { data: 'item_name' },
                type !== 'hero' ? { data: 'sum_total_qty' } : null,
                type !== 'hero' ? { data: 'total_on_hand' } : null,
                type !== 'hero' ? { data: 'total_on_hand' } : null,
                type !== 'hero' ? { data: 'total_on_hand' } : null
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

    function checkOutput(ifEmpty, ifNotEmpty) {
        let selectedCoveredASC = $('input[name="coveredASC"]:checked').val();

        if(selectedCoveredASC){
            ifNotEmpty();
        }else{
            ifEmpty();
        }
    }

    function handleAction(action) {
        if (action === 'preview') {
            checkOutput(
                () => {
                    let selectedASC = $('#asc_id').val();
                    let selectedArea = $('#area_id').val();
                    let selectedBrand = $('#brand_id').val();
                    let selectedYear = $('#year').val();
                    let selectedStore = $('#store_id').val();
                    let selectedBa = $('#ba_id').val();
                    let link = `FALSE-${selectedASC}-${selectedArea}-${selectedBrand}-${selectedYear}-${selectedStore}-${selectedBa}`;
                    window.open(`<?= base_url()?>trade-dashboard/asc-dashboard-1-view/${link}`, '_blank');
                },
                () => {
                    let selectedASC = $('#ascName').val();
                    let selectedArea = $('#area').val();
                    let selectedBrand = $('#brand').val();
                    let selectedYear = $('#year').val();
                    let selectedStore = $('#store_id').val();
                    let selectedBA = $('#ba').val();
                    let withBA = $('input[name="coveredASC"]:checked').val();
                    let link = `TRUE-${selectedASC}-${selectedArea}-${selectedBrand}-${selectedYear}-${selectedStore}-${selectedBA}-${withBA}`;
                    window.open(`<?= base_url()?>trade-dashboard/asc-dashboard-1-view/${link}`, '_blank');
                }
            );
        } else if (action === 'export') {
            checkOutput(
                prepareExport, 
                prepareExport1
            );
        } else {
            alert('wtf are u doing?')
        }
    }

    function prepareExport() {
        let selectedASC = $('#ascName').val();
        let selectedBrand = $('#brand').val();
        let selectedYear = $('#year').val();
        let selectedStore = $('#store_id').val();
        let selectedBA = $('#ba').val();
        let selectedArea = $('#area').val();

        fetchTradeDashboardData({
            selectedASC, 
            selectedBrand, 
            selectedYear, 
            selectedStore, 
            selectedBA, 
            selectedArea, 
            length: 10,
            start: 0,
            onSuccess: function(result) {
                const valuesData = [];
                if (result) {
                    let salesData = result[0];

                    valuesData.push({
                        "Month" : "January", 
                        "LY Sell Out" : salesData.net_sales_january, 
                        "Sales Report" : salesData.amount_january, 
                        "Target Sales" : salesData.target_sales_january, 
                        "Growth" : salesData.growth_january, 
                        "Achieved" : salesData.achieved_january
                    });
                    valuesData.push({
                        "Month" : "February", 
                        "LY Sell Out" : salesData.net_sales_february, 
                        "Sales Report" : salesData.amount_february, 
                        "Target Sales" : salesData.target_sales_february, 
                        "Growth" : salesData.growth_february, 
                        "Achieved" : salesData.achieved_february
                    })
                    valuesData.push({
                        "Month" : "March", 
                        "LY Sell Out" : salesData.net_sales_march, 
                        "Sales Report" : salesData.amount_march, 
                        "Target Sales" : salesData.target_sales_march, 
                        "Growth" : salesData.growth_march, 
                        "Achieved" : salesData.achieved_march
                    })
                    valuesData.push({
                        "Month" : "April", 
                        "LY Sell Out" : salesData.net_sales_april, 
                        "Sales Report" : salesData.amount_april, 
                        "Target Sales" : salesData.target_sales_april, 
                        "Growth" : salesData.growth_april, 
                        "Achieved" : salesData.achieved_april
                    })
                    valuesData.push({
                        "Month" : "May", 
                        "LY Sell Out" : salesData.net_sales_may, 
                        "Sales Report" : salesData.amount_may, 
                        "Target Sales" : salesData.target_sales_may, 
                        "Growth" : salesData.growth_may, 
                        "Achieved" : salesData.achieved_may
                    })
                    valuesData.push({
                        "Month" : "June", 
                        "LY Sell Out" : salesData.net_sales_june, 
                        "Sales Report" : salesData.amount_june, 
                        "Target Sales" : salesData.target_sales_june, 
                        "Growth" : salesData.growth_june, 
                        "Achieved" : salesData.achieved_june
                    })
                    valuesData.push({
                        "Month" : "July", 
                        "LY Sell Out" : salesData.net_sales_july, 
                        "Sales Report" : salesData.amount_july, 
                        "Target Sales" : salesData.target_sales_july, 
                        "Growth" : salesData.growth_july, 
                        "Achieved" : salesData.achieved_july
                    })
                    valuesData.push({
                        "Month" : "August", 
                        "LY Sell Out" : salesData.net_sales_august, 
                        "Sales Report" : salesData.amount_august, 
                        "Target Sales" : salesData.target_sales_august, 
                        "Growth" : salesData.growth_august, 
                        "Achieved" : salesData.achieved_august
                    })
                    valuesData.push({
                        "Month" : "September", 
                        "LY Sell Out" : salesData.net_sales_september, 
                        "Sales Report" : salesData.amount_september, 
                        "Target Sales" : salesData.target_sales_september, 
                        "Growth" : salesData.growth_september, 
                        "Achieved" : salesData.achieved_september
                    })
                    valuesData.push({
                        "Month" : "October", 
                        "LY Sell Out" : salesData.net_sales_october, 
                        "Sales Report" : salesData.amount_october, 
                        "Target Sales" : salesData.target_sales_october, 
                        "Growth" : salesData.growth_october, 
                        "Achieved" : salesData.achieved_october
                    })
                    valuesData.push({
                        "Month" : "November", 
                        "LY Sell Out" : salesData.net_sales_november, 
                        "Sales Report" : salesData.amount_november, 
                        "Target Sales" : salesData.target_sales_november, 
                        "Growth" : salesData.growth_november, 
                        "Achieved" : salesData.achieved_november
                    })
                    valuesData.push({
                        "Month" : "December", 
                        "LY Sell Out" : salesData.net_sales_december, 
                        "Sales Report" : salesData.amount_december, 
                        "Target Sales" : salesData.target_sales_december, 
                        "Growth" : salesData.growth_december, 
                        "Achieved" : salesData.achieved_december
                    });
                }

                const headerData = [
                    ["LIFESTRONG MARKETING INC."],
                    ["Report: ASC Dashboard 2"],
                    ["Date Generated: " + formatDate(new Date())],
                    ["ASC Name: " + selectedASC],
                    ["Area: " + selectedArea],
                    ["Brand: " + selectedBrand],
                    ["Year: " + ($('#year option:selected').text() === "Please select.." ? "All" : $('#year option:selected').text())],
                    [""]
                ];

                exportArrayToCSV(valuesData, `Report: BA Dashboard - ${formatDate(new Date())}`, headerData);
            },
            onError: function(error) {
                alert("Error:", error);
            }
        });
    }

    function fetchTradeDashboardData({ 
        selectedASC, 
        selectedBrand, 
        selectedYear, 
        selectedStore, 
        selectedBA, 
        selectedArea, 
        length, 
        start, 
        onSuccess, 
        onError 
    }) {
        let allData = [];

        function fetchData(offset) {
            $.ajax({
                url: base_url + 'trade-dashboard/trade-asc-dashboard-one',
                type: 'POST',
                data : {
                    asc : selectedASC,
                    brand : selectedBrand,
                    year : selectedYear,
                    store : selectedStore,
                    ba : selectedBA,
                    area : selectedArea
                },
                success: function(response) {
                    if (response.data && response.data.length) {
                        allData = allData.concat(response.data);

                        if (response.data.length > length) {
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

    function prepareExport1() {
        let selectedASC = $('#ascName').val();
        let selectedArea = $('#area').val();
        let selectedBrand = $('#brand').val();
        let selectedYear = $('#year').val();
        let selectedStore = $('#store_id').val();
        let selectedBA = $('#ba').val();
        let withBA = $('input[name="coveredASC"]:checked').val();

        let tables = [
            { id: "Slow Moving", type: "slowMoving" },
            { id: "Overstock", type: "overStock" },
            { id: "NPD", type: "npd" },
            { id: "Hero", type: "hero" },
        ];

        let fetchPromises = tables.map(table => {
            return new Promise((resolve, reject) => {
                let stype = table.type;
                fetchTradeDashboardData1({
                    stype, 
                    selectedASC, 
                    selectedArea, 
                    selectedStore, 
                    selectedBrand, 
                    selectedBA, 
                    selectedYear, 
                    withBA,
                    length: 10,
                    start: 0,
                    onSuccess: function(result) {
                        let newData = result.map(({ item_name, sum_total_qty }) => ({
                            "SKU Name": item_name,
                            "Quantity": sum_total_qty,
                            "LMI Code": "",
                            "RGDI Code": "",
                            "Type of SKU": table.id
                        }));
                        resolve(newData);
                    },
                    onError: function(error) {
                        reject(error);
                    }
                });
            });
        });

        Promise.all(fetchPromises)
            .then(results => {
                let formattedData = results.flat();

                const headerData = [
                    ["LIFESTRONG MARKETING INC."],
                    ["Report: ASC Dashboard 2"],
                    ["Date Generated: " + formatDate(new Date())],
                    ["ASC Name: " + selectedASC],
                    ["Area: " + selectedArea],
                    ["Brand: " + selectedBrand],
                    ["Year: " + ($('#year option:selected').text() === "Please select.." ? "All" : $('#year option:selected').text())],
                    [""]
                ];

                exportArrayToCSV(formattedData, `Report: BA Dashboard - ${formatDate(new Date())}`, headerData);
            })
            .catch(error => {
                alert("Error:", error);
            });
    }

    function fetchTradeDashboardData1({ 
        stype, 
        selectedASC, 
        selectedArea, 
        selectedStore, 
        selectedBrand, 
        selectedBA, 
        selectedYear, 
        withBA,
        length, 
        start, 
        onSuccess, 
        onError 
    }) {
        let allData = [];

        function fetchData1(offset) {
            $.ajax({
                url: "<?= base_url(); ?>" + 'trade-dashboard/trade-asc-dashboard-one-tables',
                type: 'POST',
                data : {
                    area : selectedArea === "0" ? null : selectedArea,
                    asc : selectedASC === "0" ? null : selectedASC,
                    brand : selectedBrand === "0" ? null : selectedBrand,
                    ba : selectedBA === "0" ? null : selectedBA,
                    store : selectedStore === "0" ? null : selectedStore,
                    year : selectedYear === "0" ? null : selectedYear,
                    trade_type : stype,
                    withba : withBA,
                    limit : length,
                    offset : start,
                },
                success: function(response) {
                    if (response.data && response.data.length) {
                        allData = allData.concat(response.data);

                        if (response.data.length > length) {
                            fetchData1(offset + length);
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

        fetchData1(start);
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
