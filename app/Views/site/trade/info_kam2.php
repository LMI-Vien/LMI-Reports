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

    #previewButton{
        color: #fff;
        background-color: #143996 !important;
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

    /* Title Styling */
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

</style>

<div class="wrapper">
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid py-4">

                <!-- Filters Section -->
            <div class="card p-4 shadow-sm">
                <div class="text-center md-center p-2">
                    <h5 class="mt-1 mb-1">
                        <i class="fas fa-filter"></i> 
                        <span>
                            F I L T E R
                        </span>
                    </h5>
                </div>
                <div class="row p-4">
                    <div class="col-md-4 column p-2 text-left">
                        <div class="col-md p-1 row">
                            <div class="col-md-3">
                                <label for="brandAmbassador">Brand Ambassador</label>
                            </div>
                            <div class="col-md">
                                <input type="text" class="form-control" id="brandAmbassador" placeholder="Please select...">
                                <input type="hidden" id="ba_id">
                            </div>
                        </div>
                        <div class="col-md p-1 row">
                            <div class="col-md-3">
                                <label for="storeName">Store Name</label>
                            </div>
                            <div class="col-md">
                                <input type="text" class="form-control" id="storeName" placeholder="Please select...">
                                <input type="hidden" id="store_id">
                            </div>
                        </div>
                        <div class="col-md p-1 row">
                            <div class="col-md-3">
                                <label for="storeName2">Category</label>
                            </div>
                            <div class="col-md">
                                <input type="text" class="form-control" id="storeName2" placeholder="Enter store">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 column p-2 text-left">
                        <div class="col-md p-1 row">
                            <div class="col-md-3">
                                <label for="baName">Qty Scope</label>
                            </div>
                            <div class="col-md">
                                <input type="text" class="form-control" id="baName" placeholder="Enter BA name">
                            </div>
                        </div>
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

                    <div class="col-md-3 column mt-1" style="border: 1px solid #dee2e6; border-radius: 12px;" >
                        <div class="col-md-12 mx-auto row py-2 text-left" >
                            <label for="ascName">SKU</label>
                            <div class="col-md" >
                                <input type="text" class="form-control" id="ascName" placeholder="ASC Name">
                                    <input type="hidden" id="asc_id">
                            </div>
                        </div>
                        <div class="col-md-12 mx-auto row py-2 text-center" >
                            <div class="col-md-6 row" >
                                <input type="radio" name="coveredASC" value="with_ba" class="col-md-2"><span class="col-md-10">Acsending</span>
                            </div>
                            <div class="col-md-6 row" >
                                <input type="radio" name="coveredASC" value="without_ba" class="col-md-2"><span class="col-md-10">Descending</span>
                            </div>
                        </div>
                    </div>                         
                    <div class="col-md-2">
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
            </div>

                <!-- DataTables Section -->
                <div class="row mt-12" style="overflow-x: auto; max-height: 400px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card p-3 shadow-sm">
                                <table id="dataTable1" class="table table-bordered">
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
                                <table id="dataTable2" class="table table-bordered">
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
                                <table id="dataTable3" class="table table-bordered">
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
                                <table id="dataTable4" class="table table-bordered">
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

        // autocomplete_field($("#brandAmbassador"), $("ba_id"), ba);
        // autocomplete_field($("#storeName"), $("store_id"), store);

        autocomplete_field($("#brandAmbassador"), $("#ba_id"), ba, "description", "id", function(result) {
            // console.log(result);

            let url ="<?= base_url("cms/global_controller"); ?>";
            let data = {
                event: "list",
                select: "tbl_store.id, tbl_store.description",
                query: "tbl_brand_ambassador.id = " + result.id,
                offset: offset,
                limit: 0,
                table: "tbl_brand_ambassador",
                join: [
                    {
                        table: "tbl_store",
                        query: "tbl_store.id = tbl_brand_ambassador.store",
                        type: "left"
                    }
                ]
            }

            aJax.post(url, data, function(result) {
                let store_name = JSON.parse(result);
                $("#storeName").val(store_name[0].description);
                $("#store_id").val(store_name[0].id);
            })
        });

        autocomplete_field($("#storeName"), $("#store_id"), store, "description", "id", function(result) {
            console.log(result.id);

            let url ="<?= base_url("cms/global_controller"); ?>";
            let data = {
                event: "list",
                select: "tbl_brand_ambassador.id, tbl_brand_ambassador.name",
                query: "tbl_store.id = " + result.id,
                offset: offset,
                limit: 0,
                table: "tbl_store",
                join: [
                    {
                        table: "tbl_brand_ambassador",
                        query: "tbl_brand_ambassador.store = tbl_store.id",
                        type: "left"
                    }
                ]
            }

            aJax.post(url, data, function(result) {
                let baname = JSON.parse(result);

                if(baname[0].name !== null) {
                    $("#brandAmbassador").val(baname[0].name);
                    $("#ba_id").val(baname[0].id);
                } else {
                    $("#brandAmbassador").val("No Brand Ambassador");
                }

            })
        });

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
