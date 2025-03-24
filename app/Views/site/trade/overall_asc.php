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
        color: #fff !important;
        background-color: #301311 !important;
    }
    .tbl-title-bg{
        color: #fff;
        border-radius: 5px;
        background-color: #143996 !important;
    }

    #previewButton{
        color: #fff;
        background-color: #143996 !important;
    }

    .paginate_button  {
        font-size: 1em;
    }

    /* Card Styling */
    .card {
        border-radius: 12px !important;
        background: #ffffff;
        transition: transform 0.3s ease-in-out;
    }

    .card-dark {
        border-radius: 12px !important;
        border: #dee2e6, solid, 1px;
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

    #refreshButton {
        width: 10em;
        height: 3em;
        border-radius: 12px;
        box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.5);
    }

    #clearButton {
        width: 10em;
        height: 3em;
        border-radius: 12px;
        box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.5);
    }


    .paginate_button {
        font-size: 15px !important;
    }

    label {
        display: flex !important;
        align-items: center;
        margin-bottom: 0px !important;
    }

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
                    <div class="col-md-5 column p-2 text-left">
                            <div class="col-md p-3 row">
                                <div class="col-md-3">
                                    <label for="asc">ASC Name</label>
                                </div>
                                <div class="col-md">
                                    <input type="text" class="form-control" id="asc" placeholder="Please select...">
                                    <input type="hidden" id="asc_id">
                                </div>    
                            </div>
                            <div class="col-md p-3 row">
                                <div class="col-md-3">
                                    <label for="area">Area</label>
                                </div>
                                <div class="col-md">
                                    <input type="text" class="form-control" id="area" placeholder="Please select...">
                                    <input type="hidden" id="area_id">
                                </div>
                            </div>
                    </div>
                    <div class="col-md-5 column p-2 text-left">
                        <div class="col-md p-3 row">
                            <div class="col-md-3">
                                <label for="brand">Brand</label>
                            </div>
                            <div class="col-md">
                                <input type="text" class="form-control" id="brand" placeholder="Please select...">
                                <input type="hidden" id="brand_id">
                            </div>
                        </div>
                        <div class="col-md p-3 row">
                            <div class="col-md-3">
                                <label for="year">Year</label>
                            </div>
                            <div class="col-md">
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
                    <div class="col-md-2" style="float: right;">
                        <!-- Refresh Button -->
                        <div class="row">
                            <div class="p-2 d-flex justify-content-end">
                                <button class="btn btn-primary btn-sm filter_buttons" id="refreshButton">
                                    <i class="fas fa-sync-alt"></i> Refresh
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="p-2 d-flex justify-content-end">
                                <button id="clearButton" class="btn btn-secondary btn-sm filter_buttons"><i class="fas fa-sync-alt"></i> Clear</button>
                            </div>
                        </div>
                    </div>
             
                </div>
            </div>


                <!-- DataTables Section -->
            <div class="card p-4 shadow-sm">
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
                            <tr class="asc-dashboard-thead">
                               <!--  <th class="tbl-title-field"></th>
                                <th class="tbl-title-field">Jan</th><th class="tbl-title-field">Feb</th><th class="tbl-title-field">Mar</th><th class="tbl-title-field">Apr</th><th class="tbl-title-field">May</th><th class="tbl-title-field">Jun</th>
                                <th class="tbl-title-field">Jul</th><th class="tbl-title-field">Aug</th><th class="tbl-title-field">Sep</th><th class="tbl-title-field">Oct</th><th class="tbl-title-field">Nov</th><th class="tbl-title-field">Dec</th> -->
                            </tr>
                        </thead>
                        <tbody class="asc-dashboard-body">
                        </tbody>
                    </table>
                    </div>
                </div>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

    $(document).ready(function () {
        let asc = <?= json_encode($asc); ?>;
        let area = <?= json_encode($area); ?>;
        let brand = <?= json_encode($brand); ?>;

        autocomplete_field($("#asc"), $("#asc_id"), asc, "asc_description", "asc_id");
        autocomplete_field($("#area"), $("#area_id"), area, "area_description");
        autocomplete_field($("#brand"), $("#brand_id"), brand, "brand_description");

        renderCharts(); // Initial render

        $(document).on('click', '#clearButton', function () {
            $('input[type="text"], input[type="number"]').val('');
            $('input[type="radio"], input[type="checkbox"]').prop('checked', false);

            $('select').prop('selectedIndex', 0);
            $('#refreshButton').click();
        });

        $('#refreshButton').click(function () {
            if($('#area').val() == ""){
                $('#area_id').val('');
            }
            if($('#brand').val() == ""){
                $('#brand_id').val('');
            }
            if($('#asc').val() == ""){
                $('#asc_id').val('');
            }
            if($('#asc').val() !== ""){
                fetchDataASCMonthy();
            }else{
                fetchData();
            }
            
        });
        fetchData();
    });

    // Define months
    var months = [];

    var dataValues = {
        salesReport: [],
        targetSales: [],
        PerAchieved: []
    };
    
    let chartInstances = []; // Store chart instances

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
        months = [];
        dataValues = {
            salesReport: [],
            targetSales: [],
            PerAchieved: []
        };
        let selectedASC = $('#asc_id').val();
        let selectedArea = $('#area_id').val();
        let selectedBrand = $('#brand_id').val();
        let selectedYear = $('#year').val();
        let selectedStore = $('#store_id').val();
        let selectedBa = $('#ba_id').val();
        url = base_url + 'trade-dashboard/trade-overall-asc-sales-report';
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
            var thead = "<th class='tbl-title-field'></th>";
            var selloutdata = '';
            var salesreportdata = '';
            var targetsalesreport = '';
            var growthreport = '';
            var achievedreport = '';

            if (result) {
                let salesData = result.data[0];
                if(result.data.length > 0){
                    $.each(result.data, function(x,y) {
                        if(y.asc_name){
                            months.push(y.asc_name); 
                            dataValues.salesReport.push(y.total_amount);
                            dataValues.targetSales.push(y.total_target_sales); // Fix here
                            dataValues.PerAchieved.push(y.achieved);
                            thead += "<th class='tbl-title-field'>"+y.asc_name+"</th>";
                            selloutdata += '<td>'+(y.total_net_sales || "0.00")+'</td>';
                            salesreportdata += '<td>'+(y.total_amount || "0.00")+'</td>';
                            targetsalesreport += '<td>'+(y.total_target_sales || "0.00")+'</td>';
                            growthreport += '<td>'+(y.growth || "0.00")+'</td>';
                            achievedreport += '<td>'+(y.achieved || "0.00")+'</td>';
                        }

                    });                    
                }else{
                    thead += "<th class='tbl-title-field'></th>";
                        selloutdata += '<td>No Data Available</td>';
                        salesreportdata += '<td>No Data Available</td>';
                        targetsalesreport += '<td>No Data Available</td>';
                        growthreport += '<td>No Data Available</td>';
                        achievedreport += '<td>No Data Available</td>';
                }
            }
            sellout = '';
            sellout += '<tr><td style="background-color: #ebe6f3;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">LY Sell Out</td>'+selloutdata+'</td></tr>';
            sellout += '<tr><td style="background-color: #ffc107;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Sales Report</td>'+salesreportdata+'</td></tr>';
            sellout += '<tr><td style="background-color: #990000;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Target Sales</td>'+targetsalesreport+'</td></tr>';
            sellout += '<tr><td style="background-color: #ebe6f3;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Growth</td>'+growthreport+'</td></tr>';
            sellout += '<tr><td style="background-color: #339933;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">% Achieved</td>'+achievedreport+'</td></tr>';
            html = sellout;
            $('.asc-dashboard-body').html(html);
            $('.asc-dashboard-thead').html(thead);
            
            renderCharts();
        });
    }

    function renderChartsASC() {
        chartInstances.forEach(chart => chart.destroy());
        chartInstances = [];
        $('#chartContainer').html('');
        months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
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

    function fetchDataASCMonthy(){

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
            var thead = `
                <th class="tbl-title-field"></th>
                <th class="tbl-title-field">Jan</th>
                <th class="tbl-title-field">Feb</th>
                <th class="tbl-title-field">Mar</th>
                <th class="tbl-title-field">Apr</th>
                <th class="tbl-title-field">May</th>
                <th class="tbl-title-field">Jun</th>
                <th class="tbl-title-field">Jul</th>
                <th class="tbl-title-field">Aug</th>
                <th class="tbl-title-field">Sep</th>
                <th class="tbl-title-field">Oct</th>
                <th class="tbl-title-field">Nov</th>
                <th class="tbl-title-field">Dec</th>
            `;
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
            $('.asc-dashboard-thead').html(thead);
            renderChartsASC();
        });
    }
</script>
