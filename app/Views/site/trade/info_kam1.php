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
        color: #fff;
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
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    #dataTable4 {
        width: 100% !important;
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
            <div class="card p-4 shadow-sm">
                <div class="text-center md-center">
                    <h5 class="mb-3"><i class="fas fa-filter"></i> Filter</h5>
                </div>
                <div class="row">
                    <!-- Left Side: Inputs -->
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="brandAmbassador">Brand Ambassador</label>
                                <input type="text" class="form-control" id="brandAmbassador" placeholder="Please select">
                                <input type="hidden" id="ba_id">
                            </div>
                            <div class="col-md-3">
                                <label for="area">Area</label>
                                <input type="text" class="form-control" id="area" placeholder="Please select...">
                                <input type="hidden" id="area_id">
                            </div>
                            <div class="col-md-3">
                                <label for="brand">Brand</label>
                                <input type="text" class="form-control" id="brand" placeholder="Please select...">
                                <input type="hidden" id="brand_id">
                            </div>
                            <div class="col-md-3 d-flex gap-2">
                                <div style="width: 100%;">
                                    <label for="month">Month</label>
                                    <select class="form-control" id="month">
                                        <option>January</option>
                                        <option>February</option>
                                    </select>
                                </div>
                                <div style="width: 70%;">
                                    <label for="week">Week</label>
                                    <select class="form-control" id="week">
                                        <option>Week 1</option>
                                        <option>Week 2</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label for="store">Store</label>
                                <input type="text" class="form-control" id="store" placeholder="Please select...">
                                <input type="hidden" id="store_id">
                            </div>
                            <div class="col-md-3">
                                <label for="item">Item Category</label>
                                <input type="text" class="form-control" id="item" placeholder="Please select...">
                            </div>
                            <div class="col-md-3 position-relative p-3" style="border-radius: 7px; background-color: #edf1f1;">
                                <label class="position-absolute" style="top: 5px; left: 10px; font-size: 12px; font-weight: bold; background-color: #edf1f1; padding: 0 5px;">Class A, B, NPD Only</label>
                                <div style="margin-top: 15px;">
                                    <label for="ascName">ASC Name</label>
                                    <input type="text" class="form-control" id="ascName" placeholder="ASC Name">
                                    <input type="hidden" id="asc_id">
                                </div>
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
                <div class="card mt-4 p-4 shadow-sm">
                    <div class="tbl-title-bg"><h5>OVERALL BA SALES TARGET</h5></div>

                    <table id="dataTable4" class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>Store</th>
                                <th>Area Sales Coordinator</th>
                                <th>Brand Ambassador</th>
                                <th>SKU</th>
                                <th>SKU Code</th>
                                <th>Item Class</th>
                                <th>Stock Qty</th>

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
        
        $("#brandAmbassador").autocomplete({
            source: function(request, response) {
                let result = $.ui.autocomplete.filter(
                    ba.map(ba => ({
                        label: ba.description,
                        value: ba.id
                    })),
                    request.term
                );
                let uniqueResults = [...new Set(result)];
                response(uniqueResults.slice(0, 10));
            },
            select: function(event, ui) {
                $("#brandAmbassador").val(ui.item.label);
                $("#ba_id").val(ui.item.value);
                return false;
            },
            minLength: 0,
        }).focus(function() {
            $(this).autocomplete("search", "");
        })

        $("#area").autocomplete({
            source: function(request, response) {
                let result = $.ui.autocomplete.filter(
                    area.map(area => ({
                        label: area.area_description,
                        value: area.id
                    })),
                    request.term
                );
                let uniqueResults = [...new Set(result)];
                response(uniqueResults.slice(0, 10));
            },
            select: function(event, ui) {
                $("#area").val(ui.item.label);
                $("#area_id").val(ui.item.value);
                return false;
            },
            minLength: 0,
        }).focus(function() {
            $(this).autocomplete("search", "");
        })

        $("#brand").autocomplete({
            source: function(request, response) {
                let result = $.ui.autocomplete.filter(
                    brand.map(brand => ({
                        label: brand.brand_description,
                        value: brand.id
                    })),
                    request.term
                );
                let uniqueResults = [...new Set(result)];
                response(uniqueResults.slice(0, 10));
            },
            select: function(event, ui) {
                $("#brand").val(ui.item.label);
                $("#brand_id").val(ui.item.value);
                return false;
            },
            minLength: 0,
        }).focus(function() {
            $(this).autocomplete("search", "");
        })

        $("#store").autocomplete({
            source: function(request, response) {
                let result = $.ui.autocomplete.filter(
                    store.map(store => ({
                        label: store.description,
                        value: store.id
                    })),
                    request.term
                );
                let uniqueResults = [...new Set(result)];
                response(uniqueResults.slice(0, 10));
            },
            select: function(event, ui) {
                $("#store").val(ui.item.label);
                $("#store_id").val(ui.item.value);
                return false;
            },
            minLength: 0,
        }).focus(function() {
            $(this).autocomplete("search", "");
        })

        $("#ascName").autocomplete({
            source: function(request, response) {
                let result = $.ui.autocomplete.filter(
                    asc.map(asc => ({
                        label: asc.asc_description,
                        value: asc.asc_id
                    })),
                    request.term
                );
                let uniqueResults = [...new Set(result)];
                response(uniqueResults.slice(0, 10));
            },
            select: function(event, ui) {
                $("#ascName").val(ui.item.label);
                $("#asc_id").val(ui.item.value);
                return false;
            },
            minLength: 0,
        }).focus(function() {
            $(this).autocomplete("search", "");
        })

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
