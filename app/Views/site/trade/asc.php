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
                                    <input type="text" class="form-control" id="store" placeholder="Enter store">
                                    <input type="hidden" id="store_id">
                                </div>
                                <div class="col-md-4">
                                    <label for="area">Area</label>
                                    <input type="text" class="form-control" id="area" placeholder="Enter area">
                                    <input type="hidden" id="area_id">
                                </div>
                                <div class="col-md-4 d-flex gap-2">
                                    <div>
                                        <label for="month">Month</label>
                                        <select class="form-control" id="month">
                                            <option>January</option>
                                            <option>February</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="year">Year</label>
                                        <select class="form-control" id="year">
                                            <option>2024</option>
                                            <option>2025</option>
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
                            <div class="mt-3 d-flex justify-content-end">
                                <button class="btn btn-primary btn-sm" id="refreshButton"><i class="fas fa-sync-alt"></i> Refresh</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DataTables Section -->
                <div class="card mt-4 p-4 shadow-sm">
                    <div class="tbl-title-bg"><h5>OVERALL BA SALES TARGET</h5></div>

                    <table id="dataTable4" class="table table-bordered table-responsive">
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
                            <tr><td>Alice Brown</td><td>Store D1</td><td>Store D1</td><td>Store D1</td><td>Store D1</td><td>Store D1</td><td>Store D1</td><td>Store D1</td></tr>
                            <tr><td>Alice Brown</td><td>Store D2</td><td>Store D2</td><td>Store D2</td><td>Store D2</td><td>Store D2</td><td>Store D2</td><td>Store D2</td></tr>
                            <tr><td>Alice Brown</td><td>Store D3</td><td>Store D3</td><td>Store D3</td><td>Store D3</td><td>Store D3</td><td>Store D3</td><td>Store D3</td></tr>
                            <tr><td>Alice Brown</td><td>Store D4</td><td>Store D4</td><td>Store D4</td><td>Store D4</td><td>Store D4</td><td>Store D4</td><td>Store D4</td></tr>
                            <tr><td>Alice Brown</td><td>Store D5</td><td>Store D5</td><td>Store D5</td><td>Store D5</td><td>Store D5</td><td>Store D5</td><td>Store D5</td></tr>
                            <tr><td>Alice Brown</td><td>Store D6</td><td>Store D6</td><td>Store D6</td><td>Store D6</td><td>Store D6</td><td>Store D6</td><td>Store D6</td></tr>
                            <tr><td>Alice Brown</td><td>Store D7</td><td>Store D7</td><td>Store D7</td><td>Store D7</td><td>Store D7</td><td>Store D7</td><td>Store D7</td></tr>
                            <tr><td>Alice Brown</td><td>Store D8</td><td>Store D8</td><td>Store D8</td><td>Store D8</td><td>Store D8</td><td>Store D8</td><td>Store D8</td></tr>
                            <tr><td>Alice Brown</td><td>Store D9</td><td>Store D9</td><td>Store D9</td><td>Store D9</td><td>Store D9</td><td>Store D9</td><td>Store D9</td></tr>
                            <tr><td>Alice Brown</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td></tr>
                            <tr><td>Alice Brown</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td></tr>
                            <tr><td>Alice Brown</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td></tr>
                            <tr><td>Alice Brown</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td></tr>
                        </tbody>
                    </table>
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
<link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.5.0/css/colReorder.dataTables.min.css">
<script src="https://cdn.datatables.net/colreorder/1.5.0/js/dataTables.colReorder.min.js"></script>

<script>
$(document).ready(function() {
    let store = <?= json_encode($store_branch); ?>;
    let area = <?= json_encode($area); ?>;

    autocomplete_field($("#store"), $("#store_id"), store);
    autocomplete_field($("#area"), $("#area_id"), area, "area_description");

    let table = $('#dataTable4').DataTable({
        paging: true,
        searching: false,
        ordering: true,
        info: true,
        lengthChange: false,
        colReorder: true, // Enable column reordering
    });

    // Column Toggle Feature
    table.columns().every(function(index) {
        let column = this;
        let columnTitle = $(column.header()).text();

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
        $('#columnToggleContainer').hide();
    });
});

$(document).on('click', '#toggleColumnsButton', function (e) {
    $('#columnToggleContainer').toggle();
});

$(document).on('click', '#refreshButton', function(e) {
    
})

</script>
