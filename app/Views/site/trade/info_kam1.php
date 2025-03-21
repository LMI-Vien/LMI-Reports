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

/* Set specific column widths */
th:nth-child(1), td:nth-child(1) { width: 15%; }
th:nth-child(2), td:nth-child(2) { width: 15%; }
th:nth-child(3), td:nth-child(3) { width: 15%; }
th:nth-child(4), td:nth-child(4) { width: 15%; } 
th:nth-child(5), td:nth-child(5) { width: 15%; } 
th:nth-child(6), td:nth-child(6) { width: 15%; } 
th:nth-child(7), td:nth-child(7) { width: 10%; } 
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
                    <div class="col-md-3 column p-2 text-left">
                        <div class="col-md p-1 row">
                            <div class="col-md-4">
                                <label for="brandAmbassador">Brand Ambassador</label>
                            </div>
                            <div class="col-md">
                                <input type="text" class="form-control" id="brandAmbassador" placeholder="Please select">
                                <input type="hidden" id="ba_id">
                            </div>
                        </div>
                        <div class="col-md p-1 row">
                            <div class="col-md-3">
                                <label for="area">Area</label>
                            </div>
                            <div class="col-md">
                                <input type="text" class="form-control" id="area" placeholder="Please select...">
                                <input type="hidden" id="area_id">
                            </div>
                        </div>
                        <div class="col-md p-1 row">
                            <div class="col-md-3">
                                <label for="brand">Brand</label>
                            </div>
                            <div class="col-md">
                                <input type="text" class="form-control" id="brand" placeholder="Please select...">
                                <input type="hidden" id="brand_id">
                            </div>
                        </div>
                    </div> 
                    <div class="col-md-2 column p-2 text-left">
                            <div class="col-md p-1 row">
                                <div class="col-md-3">
                                    <label for="month">Month</label>
                                </div>
                                <div class="col-md">
                                    <select class="form-control" id="month">
                                        <option>January</option>
                                        <option>February</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md p-1 row">
                                <div class="col-md-3">
                                    <label for="week">Week</label>
                                </div>
                                <div class="col-md">
                                    <select class="form-control" id="week">
                                        <option>Week 1</option>
                                        <option>Week 2</option>
                                    </select>
                                </div>
                            </div>   
                    </div>     
                    <div class="col-md-3 column p-2 text-left">
                        <div class="col-md p-1 row">
                            <div class="col-md-3">
                                <label for="store">Store</label>
                            </div>
                            <div class="col-md">
                                <input type="text" class="form-control" id="store" placeholder="Please select...">
                                <input type="hidden" id="store_id">
                            </div>
                        </div>

                        <div class="col-md p-1 row">
                            <div class="col-md-3">
                                <label for="item">Item Category</label>
                            </div>
                            <div class="col-md">
                                <input type="text" class="form-control" id="item" placeholder="Please select...">
                                <input type="hidden" id="item_id">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 column mt-1" style="border: 1px solid #dee2e6; border-radius: 12px;" >
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
                    <table id="dataTable4" class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th 
                                    colspan="8"
                                    style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                    class="tbl-title-header"
                                >
                                    SKU's IN STORE
                                </th>
                            </tr>
                            <tr>
                                <th class="tbl-title-field">Store</th>
                                <th class="tbl-title-field">Area Sales Coordinator</th>
                                <th class="tbl-title-field">Brand Ambassador</th>
                                <th class="tbl-title-field">SKU</th>
                                <th class="tbl-title-field">SKU Code</th>
                                <th class="tbl-title-field">Item Class</th>
                                <th class="tbl-title-field">Stock Qty</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Alice Brown</td><td>Store D1</td><td>Store D1</td><td>Store D1</td><td>Store D1</td><td>Store D1</td><td>Store D1</td></tr>
                            <tr><td>Alice Brown</td><td>Store D2</td><td>Store D2</td><td>Store D2</td><td>Store D2</td><td>Store D2</td><td>Store D2</td></tr>
                            <tr><td>Alice Brown</td><td>Store D3</td><td>Store D3</td><td>Store D3</td><td>Store D3</td><td>Store D3</td><td>Store D3</td></tr>
                            <tr><td>Alice Brown</td><td>Store D4</td><td>Store D4</td><td>Store D4</td><td>Store D4</td><td>Store D4</td><td>Store D4</td></tr>
                            <tr><td>Alice Brown</td><td>Store D5</td><td>Store D5</td><td>Store D5</td><td>Store D5</td><td>Store D5</td><td>Store D5</td></tr>
                            <tr><td>Alice Brown</td><td>Store D6</td><td>Store D6</td><td>Store D6</td><td>Store D6</td><td>Store D6</td><td>Store D6</td></tr>
                            <tr><td>Alice Brown</td><td>Store D7</td><td>Store D7</td><td>Store D7</td><td>Store D7</td><td>Store D7</td><td>Store D7</td></tr>
                            <tr><td>Alice Brown</td><td>Store D8</td><td>Store D8</td><td>Store D8</td><td>Store D8</td><td>Store D8</td><td>Store D8</td></tr>
                            <tr><td>Alice Brown</td><td>Store D9</td><td>Store D9</td><td>Store D9</td><td>Store D9</td><td>Store D9</td><td>Store D9</td></tr>
                            <tr><td>Alice Brown</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td></tr>
                            <tr><td>Alice Brown</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td></tr>
                            <tr><td>Alice Brown</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td></tr>
                            <tr><td>Alice Brown</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td><td>Store D10</td></tr>
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
<script>
    $(document).ready(function() {
        let tables = ['#dataTable1', '#dataTable2', '#dataTable3', '#dataTable4'];
        let ba = <?= json_encode($brand_ambassador); ?>;
        let area = <?= json_encode($area); ?>;
        let brand = <?= json_encode($brand); ?>;
        let store = <?= json_encode($store_branch); ?>;
        let asc = <?= json_encode($asc); ?>;
        
        autocomplete_field($("#brandAmbassador"), $("#ba_id"), ba);
        autocomplete_field($("#area"), $("#area_id"), area, "area_description");
        autocomplete_field($("#brand"), $("#brand_id"), brand, "brand_description");
        autocomplete_field($("#store"), $("#store_id"), store);
        autocomplete_field($("#ascName"), $("#asc_id"), asc, "asc_description", "asc_id");

        tables.forEach(id => {
            $(id).DataTable({
                paging: true,
                searching: false,
                ordering: true,
                info: true,
                lengthChange: false     // Hide "Show Entries" dropdown
            });
        });

        $('#refreshButton').click(function() {
            alert('Refreshing data...');
            tables.forEach(id => $(id).DataTable().ajax.reload(null, false));
        });

        $('#previewButton').click(function() {
            alert('Preview feature coming soon!');
        });

        $('#exportButton').click(function() {
            alert('Export feature coming soon!');
        });
    });
    
</script>
