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
        font-family: 'Courier New', Courier, monospace;
        font-size: large;
        background-color: #fdb92a;
        color: #333333;
        border: 1px solid #ffffff;
        border-radius: 10px;
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
    #refreshButton{
        background-color: #143996 !important;
    }
    #exportButton{
        background-color: #339933 !important;
    }


</style>

<div class="wrapper">
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid py-4">

                <!-- Filters Section -->
            <div class="card p-4 shadow-sm">
                <div class="text-center md-center">
                    <h5 class="mb-3"><i class="fas fa-filter"></i> Filter</h5>
                </div>
                <div class="row">
                    <!-- Left Side: Inputs -->
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="ascName">ASC Name</label>
                                <input type="text" class="form-control" id="ascName" placeholder="Enter name">
                                <input type="hidden" id="asc_id">
                            </div>
                            <div class="col-md-3">
                                <label for="area">Area</label>
                                <input type="text" class="form-control" id="area" placeholder="Enter area">
                                <input type="hidden" id="area_id">
                            </div>
                            <div class="col-md-3">
                                <label for="brand">Brand</label>
                                <input type="text" class="form-control" id="brand" placeholder="Enter brand">
                                <input type="hidden" id="brand_id">
                            </div>
                            <div class="col-md-3">
                                <label for="year">Year</label>
                                <select class="form-control" id="year">
                                    <option value="2025">2025</option>
                                    <option value="2024">2024</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label for="storeName">Store Name</label>
                                <input type="text" class="form-control" id="storeName" placeholder="Enter store">
                                <input type="hidden" id="store_id">
                            </div>
                            <div class="col-md-3">
                                <label for="ba">BA Name</label>
                                <input type="text" class="form-control" id="ba" placeholder="Enter BA name">
                                <input type="hidden" id="ba_id">
                            </div>
                            <div class="col-md-3 position-relative p-3" style="border-radius: 7px; background-color: #edf1f1;">
                                <label class="position-absolute" style="top: 5px; left: 10px; font-size: 12px; font-weight: bold; background-color: #edf1f1; padding: 0 5px;">Covered by Selected ASC</label>
                                <div style="margin-top: 15px;"></div>
                                <div class="d-flex">
                                    <input type="radio" name="sortOrder" value="asc" checked> W/ BA
                                    <input type="radio" name="sortOrder" value="desc" class="ml-3"> W/O BA
                                </div>
                            </div>
                             <div class="col-md-3 d-flex align-items-end">
                                <button class="btn btn-primary btn-sm w-100" id="refreshButton">
                                    <i class="fas fa-sync-alt"></i> Refresh
                                </button>
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

                <!-- Chart Container (Will be dynamically filled) -->
                <div id="chartContainer" class="row"></div>

                <!-- Data Table -->
                <div class="table-responsive mt-4">
                    <table class="table table-bordered text-center">
                        <thead class="thead-light">
                            <tr>
                                <th></th>
                                <th>Jan</th><th>Feb</th><th>Mar</th><th>Apr</th><th>May</th><th>Jun</th>
                                <th>Jul</th><th>Aug</th><th>Sep</th><th>Oct</th><th>Nov</th><th>Dec</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>LY Sell Out</td><td colspan="12"></td></tr>
                            <tr><td>Sales Report</td><td colspan="12"></td></tr>
                            <tr><td>Target Sales</td><td colspan="12"></td></tr>
                            <tr><td>Growth</td><td colspan="12"></td></tr>
                            <tr><td>% Achieved</td><td colspan="12"></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

                <div class="row mt-12" style="overflow-x: auto; max-height: 400px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card p-3 shadow-sm">
                                <div class="tbl-title-bg"><h5>SLOW MOVING SKU'S</h5></div>
                                <table id="dataTable1" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SKU</th>
                                            <th>SOH Qty</th>
                                            <th>Qty (W1)</th>
                                            <th>Qty (W2)</th>
                                            <th>Qty (W3)</th>
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
                            <div class="card p-3 shadow-sm">
                                <div class="tbl-title-bg"><h5>OVERSTOCK SKU'S</h5></div>
                                <table id="dataTable2" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SKU</th>
                                            <th>SOH Qty</th>
                                            <th>Qty (W1)</th>
                                            <th>Qty (W2)</th>
                                            <th>Qty (W3)</th>
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
                            <div class="card p-3 shadow-sm">
                                <div class="tbl-title-bg"><h5>NPD SKU'S</h5></div>
                                <table id="dataTable3" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SKU</th>
                                            <th>SOH Qty</th>
                                            <th>Qty (W1)</th>
                                            <th>Qty (W2)</th>
                                            <th>Qty (W3)</th>
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
                            <div class="card p-3 shadow-sm">
                                <div class="tbl-title-bg"><h5>HERO SKU'S</h5></div>
                                <table id="dataTable4" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SKU</th>
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
    let tables = ['#dataTable1', '#dataTable2', '#dataTable3', '#dataTable4'];

    let asc = <?= json_encode($asc); ?>;
    let area = <?= json_encode($area); ?>;
    let brand = <?= json_encode($brand); ?>;
    let store_branch = <?= json_encode($store_branch); ?>;
    let brand_ambassador = <?= json_encode($brand_ambassador); ?>;

    $("#ascName").autocomplete({
        source: function(request, response) {
            let result = $.ui.autocomplete.filter(asc.map(asc => ({
                label: asc.asc_description,
                value: asc.asc_id
            })), request.term);
            let uniqueResults = [...new Set(result)];
            response(uniqueResults.slice(0, 10));
        },
        select: function(event, ui) {
            $("#ascName").val(ui.item.label);
            $("#asc_id").val(ui.item.value);
            return false;
        },
        minLength: 0,
    }).focus(function () {
        $(this).autocomplete("search", "");
    });

    $("#area").autocomplete({
        source: function(request, response) {
            let result = $.ui.autocomplete.filter(area.map(area => ({
                label: area.area_description,
                value: area.id
            })), request.term);
            let uniqueResults = [...new Set(result)];
            response(uniqueResults.slice(0, 10));
        },
        select: function(event, ui) {
            $("#area").val(ui.item.label);
            $("#area_id").val(ui.item.value);
            return false;
        },
        minLength: 0,
    }).focus(function () {
        $(this).autocomplete("search", "");
    });

    $("#brand").autocomplete({
        source: function(request, response) {
            let result = $.ui.autocomplete.filter(brand.map(brand => ({
                label: brand.brand_description,
                value: brand.id
            })), request.term);
            let uniqueResults = [...new Set(result)];
            response(uniqueResults.slice(0, 10));
        },
        select: function(event, ui) {
            $("#brand").val(ui.item.label);
            $("#brand_id").val(ui.item.value);
            return false;
        },
        minLength: 0,
    }).focus(function () {
        $(this).autocomplete("search", "");
    });

    $("#storeName").autocomplete({
        source: function(request, response) {
            let result = $.ui.autocomplete.filter(store_branch.map(store => ({
                label: store.description,
                value: store.id
            })), request.term);
            let uniqueResults = [...new Set(result)];
            response(uniqueResults.slice(0, 10));
        },
        select: function(event, ui) {
            $("#storeName").val(ui.item.label);
            $("#store_id").val(ui.item.value);
            return false;
        },
        minLength: 0,
    }).focus(function () {
        $(this).autocomplete("search", "");
    });

    $("#ba").autocomplete({
        source: function(request, response) {
            let result = $.ui.autocomplete.filter(brand_ambassador.map(ba => ({
                label: ba.description,
                value: ba.id
            })), request.term);
            let uniqueResults = [...new Set(result)];
            response(uniqueResults.slice(0, 10));
        },
        select: function(event, ui) {
            $("#ba").val(ui.item.label);
            $("#ba_id").val(ui.item.value);
            return false;
        },
        minLength: 0,
    }).focus(function () {
        $(this).autocomplete("search", "");
    });

    tables.forEach(id => {
        $(id).DataTable({
            paging: true,
            searching: false,
            ordering: true,
            info: true,
            lengthChange: false     // Hide "Show Entries" dropdown
        });
    });
    renderCharts(); // Initial render

    $('#refreshButton').click(function () {
        alert('Refreshing data...');
        renderCharts(); // Re-render charts on refresh
    });
});

// Define months
const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

const dataValues = {
    salesReport: [10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65],
    targetSales: [8, 14, 22, 26, 28, 38, 45, 50, 55, 60, 63, 70],
    PerAchieved: [12, 18, 24, 28, 32, 40, 48, 52, 58, 64, 70, 75]
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
            <div class="col-md-3 mb-4">
                <div class="card p-2">
                    <h6 class="text-center card-title">${month}</h6>
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

</script>
