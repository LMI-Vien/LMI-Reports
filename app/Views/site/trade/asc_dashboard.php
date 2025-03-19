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
        color: white;
        font-weight: bold;
        font-family: 'Poppins', sans-serif;
        font-size: 1.5rem; 
        text-align: center;
        border: none;
        border-radius: 12px;
        transition: transform 0.2s ease-in-out;
        background: linear-gradient(90deg, #fdb92a, #ff9800);
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

    .tbl-title-field {
        /* background: linear-gradient(to right, #007bff, #143996); */
        background: linear-gradient(to right, #143996, #007bff);
        color: white !important;
        text-align: center;
        font-weight: bold;
    }

    .tbl-title-header {
        background-color: #301311 !important;
        color: white;
        border-radius: 8px 8px 0px 0px !important;
    }

    #previewButton{
      background-color: #143996 !important;
    }

    .card-inverse {
        box-shadow: inset 0 0 1px rgba(0, 0, 0, 1), inset 0 1px 3px rgba(0, 0, 0, 0.2);
        border-radius: 12px;
    }

    .card-title {
        text-align: center;
        font-size: 1.25rem;
        font-weight: bold;
    }
    #refreshButton{
        background-color: #143996 !important;
    }
    #exportButton{
        background-color: #339933 !important;
    }

    .filter_buttons {
        width: 10em;
        height: 3em;
        border-radius: 12px;
        box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.5);
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
                    <div class="row p-4" >
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
                        <div class="col-md-2 column" >
                            <button class="btn btn-primary btn-sm col-md-12 filter_buttons" id="refreshButton">
                                <i class="fas fa-sync-alt"></i> Refresh
                            </button>
                            <button type="button" id="clearButton" class="btn btn-secondary btn-sm mt-3 col-md-12 filter_buttons">Clear</button>
                        </div>
                    </div>
                </div>

                <!-- DataTables Section -->
                <div class="card p-4 shadow-lg" id="data-graph">
                    <div class="text-center">
                        <h5 class="mb-3"><i class="fas fa-chart-bar"></i> ASC Performance</h5>
                    </div>

                    <!-- Chart Container (Will be dynamically filled) -->
                    <div class="mb-3" style="overflow-x: auto; padding: 10px; border-radius: 12px; border: 1px solid #dee2e6;">
                        <div id="chartContainer" class="d-flex flex-row"></div>
                    </div>
                    <!-- Data Table -->
                    <div class="table-responsive mt-4">
                        <div class="mb-3" style="overflow-x: auto; height: 450px; padding: 0px;">
                        <table class="table table-bordered text-center">
                            <thead class="thead-light">
                                <tr>
                                    <th></th>
                                    <th>Jan</th><th>Feb</th><th>Mar</th><th>Apr</th><th>May</th><th>Jun</th>
                                    <th>Jul</th><th>Aug</th><th>Sep</th><th>Oct</th><th>Nov</th><th>Dec</th>
                                </tr>
                            </thead>
                            <tbody class="asc-dashboard-body">
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>

                <div id="table-skus">
                    <div class="row mt-12" style="overflow-x: auto; padding: 0px;">
                        <div class="d-flex flex-row">
                            <div class="col-md-6">
                                <div class="card p-6 shadow-lg">
                                    <div class="tbl-title-bg tbl-title-header p-2"><h5>SLOW MOVING SKU'S</h5></div>
                                    <table id="dataTable1" class="table table-bordered">
                                        <thead>
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
                                                <td>John Doe</td>
                                                <td>Store A</td>
                                                <td>John Doe</td>
                                                <td>Store A</td>
                                                <td>Store A</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card p-6 shadow-lg">
                                    <div class="tbl-title-bg tbl-title-header p-2"><h5>OVERSTOCK SKU'S</h5></div>
                                    <table id="dataTable2" class="table table-bordered">
                                        <thead>
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
                                                <td>Jane Smith</td>
                                                <td>Store B</td>
                                                <td>Jane Smith</td>
                                                <td>Store B</td>
                                                <td>Jane Smith</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card p-6 shadow-lg">
                                    <div class="tbl-title-bg tbl-title-header p-2"><h5>NPD SKU'S</h5></div>
                                    <table id="dataTable3" class="table table-bordered">
                                        <thead>
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
                                                <td>Mike Johnson</td>
                                                <td>Store C</td>
                                                <td>Mike Johnson</td>
                                                <td>Store C</td>
                                                <td>Store C</td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card p-6 shadow-lg">
                                    <div class="tbl-title-bg tbl-title-header p-2"><h5>HERO SKU'S</h5></div>
                                    <table id="dataTable4" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="tbl-title-field">SKU</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Store D</td>
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

    // tables.forEach(id => {
    //     $(id).DataTable({
    //         paging: true,
    //         searching: false,
    //         ordering: true,
    //         info: true,
    //         lengthChange: false     // Hide "Show Entries" dropdown
    //     });
    // });
    renderCharts(); // Initial render

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
        console.log(selectedCoveredASC);
        if(selectedCoveredASC){
            console.log('asdasd');
            $('#data-graph').hide();
            $('#table-skus').show();
        }else{
            $('#data-graph').show();
            $('#table-skus').hide();
            fetchData();
            renderCharts();
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

let chartInstances = []; // Store chart instances

function renderCharts() {
    // Destroy previous charts
    chartInstances.forEach(chart => chart.destroy());
    chartInstances = [];

    // Clear and recreate chart container
    $('#chartContainer').html(''); // This ensures no duplication

    // Generate new charts
    months.forEach((month, index) => {
        // Append new chart container
        let chartHTML = `
            <div class="col-md-3">
                <div class="card-inverse p-2 mt-3">
                    <h6 class="text-center card-title mb-2">${month}</h6>
                    <canvas id="chart${index}"></canvas>
                </div>
            </div>
        `;
        $('#chartContainer').append(chartHTML); // Append new chart div

        // Get canvas context
        let ctx = document.getElementById(`chart${index}`).getContext('2d');

        // Create new chart
        let newChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Sales Report", "Target Sales", "% Achieved"],
                datasets: [{
                    label: month,
                    backgroundColor: ["#1439a6", "#990000", "#339933"],
                    data: [dataValues.salesReport[index], dataValues.targetSales[index], dataValues.PerAchieved[index]]
                }]
            },
            options: {
                responsive: true,
                animation: true, // Disable animation
                plugins: {
                    legend: { display: false } // Hide legend if needed
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Store chart instance
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
    //console.log(selectedASC, 'selectedASC', selectedArea, 'selectedArea', selectedBrand, 'selectedBrand', selectedYear, 'selectedYear', selectedStore, 'selectedStore', selectedBa, 'selectedBa');

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
            let salesData = result.data[0]; // Assuming response has an array

            // Update dataValues dynamically
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
                html += '<tr><td style="background-color: #808080;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">LY Sell Out</td><td>'+(y.net_sales_january || "0.00")+'</td><td>'+(y.net_sales_february || "0.00")+'</td><td>'+(y.net_sales_march || "0.00")+'</td><td>'+(y.net_sales_april || "0.00")+'</td><td>'+(y.net_sales_may || "0.00")+'</td><td>'+(y.net_sales_june || "0.00")+'</td><td>'+(y.net_sales_july || "0.00")+'</td><td>'+(y.net_sales_august || "0.00")+'</td><td>'+(y.net_sales_september || "0.00")+'</td><td>'+(y.net_sales_october || "0.00")+'</td><td>'+(y.net_sales_november || "0.00")+'</td><td>'+(y.net_sales_december || "0.00")+'</td></tr>';
                html += '<tr><td style="background-color: #ADD8E6;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Sales Report</td><td>'+(y.amount_january || "0.00")+'</td><td>'+(y.amount_february || "0.00")+'</td><td>'+(y.amount_march || "0.00")+'</td><td>'+(y.amount_april || "0.00")+'</td><td>'+(y.amount_may || "0.00")+'</td><td>'+(y.amount_june || "0.00")+'</td><td>'+(y.amount_july || "0.00")+'</td><td>'+(y.amount_august || "0.00")+'</td><td>'+(y.amount_september || "0.00")+'</td><td>'+(y.amount_october || "0.00")+'</td><td>'+(y.amount_november || "0.00")+'</td><td>'+(y.amount_december || "0.00")+'</td></tr>';
                html += '<tr><td style="background-color: #FFC0CB;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Target Sales</td><td>'+(y.target_sales_january || "0.00")+'</td><td>'+(y.target_sales_february || "0.00")+'</td><td>'+(y.target_sales_march || "0.00")+'</td><td>'+(y.target_sales_april || "0.00")+'</td><td>'+(y.target_sales_may || "0.00")+'</td><td>'+(y.target_sales_june || "0.00")+'</td><td>'+(y.target_sales_july || "0.00")+'</td><td>'+(y.target_sales_august || "0.00")+'</td><td>'+(y.target_sales_september || "0.00")+'</td><td>'+(y.target_sales_october || "0.00")+'</td><td>'+(y.target_sales_november || "0.00")+'</td><td>'+(y.target_sales_december || "0.00")+'</td></tr>';
                html += '<tr><td style="background-color: #808080;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Growth</td><td>'+(y.growth_january || "0.00")+'</td><td>'+(y.growth_february || "0.00")+'</td><td>'+(y.growth_march || "0.00")+'</td><td>'+(y.growth_april || "0.00")+'</td><td>'+(y.growth_may || "0.00")+'</td><td>'+(y.growth_june || "0.00")+'</td><td>'+(y.growth_july || "0.00")+'</td><td>'+(y.growth_august || "0.00")+'</td><td>'+(y.growth_september || "0.00")+'</td><td>'+(y.growth_october || "0.00")+'</td><td>'+(y.growth_november || "0.00")+'</td><td>'+(y.growth_december || "0.00")+'</td></tr>';
                html += '<tr><td style="background-color: #90EE90;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">% Achieved</td><td>'+(y.achieved_january || "0.00")+'</td><td>'+(y.achieved_february || "0.00")+'</td><td>'+(y.achieved_march || "0.00")+'</td><td>'+(y.achieved_april || "0.00")+'</td><td>'+(y.achieved_may || "0.00")+'</td><td>'+(y.achieved_june || "0.00")+'</td><td>'+(y.achieved_july || "0.00")+'</td><td>'+(y.achieved_august || "0.00")+'</td><td>'+(y.achieved_september || "0.00")+'</td><td>'+(y.achieved_october || "0.00")+'</td><td>'+(y.achieved_november || "0.00")+'</td><td>'+(y.achieved_december || "0.00")+'</td></tr>';

            });
        }
        $('.asc-dashboard-body').html(html);
        renderCharts();
    });
}

</script>
