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
                                <input type="text" class="form-control" id="brandAmbassador" placeholder="Please select...">
                                <input type="hidden" id="ba_id">
                            </div>
                            <div class="col-md-3">
                                <label for="storeName">Store Name</label>
                                <input type="text" class="form-control" id="storeName" placeholder="Please select...">
                                <input type="hidden" id="store_id">
                            </div>
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-3 position-relative p-3" style="border-radius: 7px; background-color: #edf1f1;">
                                <label class="position-absolute" style="top: 5px; left: 10px; font-size: 12px; font-weight: bold; background-color: #edf1f1; padding: 0 5px;">Sort By</label>
                                <div style="margin-top: 15px;">
                                    <label for="ascName">SKU</label>
                                    <input type="text" class="form-control" id="ascName" placeholder="ASC Name">
                                    <input type="hidden" id="asc_id">
                                </div>
                                <div class="d-flex">
                                    <input type="radio" name="sortOrder" value="asc" checked> Acsending
                                    <input type="radio" name="sortOrder" value="desc" class="ml-3"> Descending
                                </div>
                            </div>                            

                        </div>

                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label for="storeName2">Category</label>
                                <input type="text" class="form-control" id="storeName2" placeholder="Enter store">
                            </div>
                            <div class="col-md-3">
                                <label for="baName">Qty Scope</label>
                                <input type="text" class="form-control" id="baName" placeholder="Enter BA name">
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
<script>
    $(document).ready(function() {
        let ba = <?= json_encode($brand_ambassador); ?>;
        let store = <?= json_encode($store_branch); ?>;
        let asc = <?= json_encode($asc); ?>;
        let tables = ['#dataTable1', '#dataTable2', '#dataTable3', '#dataTable4'];

        autocomplete_field($("#brandAmbassador"), $("#ba_id"), ba);
        autocomplete_field($("#storeName"), $("#store_id"), store);
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
