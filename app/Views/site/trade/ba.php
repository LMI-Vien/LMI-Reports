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
                    <div class="md-center"><h5 class="mb-3"><i class="fas fa-filter"></i> Filter</h5></div>
                    <div class="row">
                        <!-- Left Side: Inputs -->
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="brandAmbassador">Brand Ambassador</label>
                                    <select class="form-control" id="brand_ambassador">
                                        <option value="0">Please select..</option>
                                        <?php
                                            if($brand_ambassador){
                                                foreach ($brand_ambassador as $value) {
                                                    echo "<option value=".$value['id'].">".$value['description']."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="storeName">Store Name</label>
                                    <select class="form-control" id="store_name">
                                        <option value="0">Please select..</option>
                                        <?php
                                            if($store_branch){
                                                foreach ($store_branch as $value) {
                                                    echo "<option value=".$value['id'].">".$value['description']."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="brand">Brand</label>
                                    <select class="form-control" id="brand">
                                        <option value="0">Please select..</option>
                                        <?php
                                            if($brands){
                                                foreach ($brands as $value) {
                                                    echo "<option value=".$value['id'].">".$value['brand_description']."</option>";
                                                }                                                
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label>Sort By</label>
                                    <div class="d-flex">
                                        <select class="form-control w-75" id="sortBy">
                                            <option value="item_name">Item Name</option>
                                            <option value="qty">Quantity</option>
                                        </select>
                                        <div class="ml-3">
                                            <input type="radio" name="sortOrder" value="ASC" checked> Asc
                                            <input type="radio" name="sortOrder" value="DESC"> Desc
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side: Radio Filters & Refresh -->
                        <div class="col-md-4">
                            <label>Filter by Type</label>
                            <div class="btn-group btn-group-toggle d-flex" data-toggle="buttons">
                                <label class="btn btn-outline-primary active">
                                    <input type="radio" name="filterType" value="3" checked> All
                                </label>
                                <label class="btn btn-outline-primary">
                                    <input type="radio" name="filterType" value="1"> Outright
                                </label>
                                <label class="btn btn-outline-primary">
                                    <input type="radio" name="filterType" value="0"> Consignment
                                </label>
                            </div>
                            <div class="mt-3 d-flex justify-content-between align-items-center">
                                <span><strong>Area / ASC Name:</strong><p id="ar_asc_name"> Please Select Brand Ambassador</p></span>
                                <button class="btn btn-primary btn-sm" id="refreshButton"><i class="fas fa-sync-alt"></i> Refresh</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DataTables Section -->
                <div class="row mt-3">
                    <div class="col-md-3">
                        <div class="card p-3 shadow-sm">
                            <div class="tbl-title-bg"><h5>SLOW MOVING SKU'S</h5></div>
                            <div style="overflow-x: auto; max-height: 400px;">      
                                <table id="slowMovingTable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SKU Name</th>
                                            <th>Quality</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="2">No data available</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card p-3 shadow-sm">
                            <div class="tbl-title-bg"><h5>OVERSTOCK SKU'S</h5></div>
                            <div style="overflow-x: auto; max-height: 400px;">      
                                <table id="overstockTable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SKU Name</th>
                                            <th>Quality</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="2">No data available</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card p-3 shadow-sm">
                            <div class="tbl-title-bg"><h5>NPD SKU'S</h5></div>
                            <table id="npdTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>SKU Name</th>
                                        <th>Quality</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="2">No data available</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card p-3 shadow-sm">
                            <div class="tbl-title-bg"><h5>HERO SKU'S</h5></div>
                            <table id="heroTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>SKU Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>No data available</td>
                                    </tr>
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    var base_url = "<?= base_url(); ?>";

    $(document).ready(function () {
        fetchData();
    });

    $(document).on('click', '#refreshButton', function () {
        let selectedBa = $('#brand_ambassador').val();
        if(selectedBa !== 0){
            get_area_asc(selectedBa);
        }
        fetchData();
    });

    function fetchData() {
        let selectedType = $('input[name="filterType"]:checked').val();
        let selectedBa = $('#brand_ambassador').val();
        let selectedStore = $('#store_name').val();
        let selectedBrand = $('#brand').val();
        let selectedSortField = $('#sortBy').val();
        let selectedSortOrder = $('input[name="sortOrder"]:checked').val();

        console.log({ selectedType, selectedBa, selectedStore, selectedBrand, selectedSortField, selectedSortOrder });

        let tables = [
            { id: "#slowMovingTable", type: "slowMoving" },
            { id: "#overstockTable", type: "overStock" },
            { id: "#npdTable", type: "npd" },
            { id: "#heroTable", type: "hero" }
        ];

        tables.forEach(table => {
            initializeTable(table.id, table.type, selectedType, selectedBa, selectedStore, selectedBrand, selectedSortField, selectedSortOrder);
        });
    }

    function initializeTable(tableId, type, selectedType, selectedBa, selectedStore, selectedBrand, selectedSortField, selectedSortOrder) {
        $(tableId).DataTable({
            destroy: true, // Ensure the table is reinitialized
            ajax: {
                url: base_url + 'trade-dashboard/trade-ba',
                type: 'GET',
                data: function (d) {
                    d.sort_field = selectedSortField;
                    d.sort = selectedSortOrder;
                    d.brand = selectedBrand === "0" ? null : selectedBrand;
                    d.brand_ambassador = selectedBa === "0" ? null : selectedBa;
                    d.store_name = selectedStore === "0" ? null : selectedStore;
                    d.ba_type = selectedType;
                    d.type = type;
                    d.limit = d.length;
                    d.offset = d.start;
                },
                dataSrc: 'data'
            },
            columns: [
                { data: 'item_name' },
                type !== 'hero' ? { data: 'sum_total_qty' } : null
            ].filter(Boolean), // Remove `null` entries
            pagingType: "full_numbers",
            pageLength: 10,
            processing: true,
            serverSide: true,
            searching: false,
            colReorder: true,
            lengthChange: false
        });
    }



    function get_area_asc(id) {
        //id = 1;
        var url = "<?= base_url('cms/global_controller');?>";
        query = 'ba.status = 1 AND ba.id = '+id;
        var data = {
            event : "list",
            select : "ba.id, ba.code, asc.description as asc_name, a.description as area",
            query : query,
            offset : 1,
            limit : 1,
            table : "tbl_brand_ambassador ba",
            join : [
                {
                    table: "tbl_area a",
                    query: "a.id = ba.area",
                    type: "left"
                },
                {
                    table: "tbl_area_sales_coordinator asc",
                    query: "asc.area_id = a.id",
                    type: "left"
                }                
            ],
            order : {
                field : 'ba.code',
                order : 'asc'
            }

        }

        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            if(result){
                $.each(result, function(index,d) {
                    $('#ar_asc_name').text((d.area || "N/A") + " / " + (d.asc_name || "N/A"));

                });
            }
        });
    }
</script>
