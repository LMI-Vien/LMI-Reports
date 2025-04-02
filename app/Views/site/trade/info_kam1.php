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
                                        <?php
                                            if($month){
                                                foreach ($month as $value) {
                                                    echo "<option value=".$value['id'].">".$value['month']."</option>";
                                                }                                                
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md p-1 row">
                                <div class="col-md-3">
                                    <label for="week">Week</label>
                                </div>
                                <div class="col-md">
                                    <select class="form-control" id="week">
                                        <?php
                                            if($week){
                                                foreach ($week as $value) {
                                                    echo "<option value=".$value['id'].">".$value['name']."</option>";
                                                }                                                
                                            }
                                        ?>
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
                                <label for="item_classi">Item Category</label>
                            </div>
                            <div class="col-md">
                                <input type="text" class="form-control" id="item_classi" placeholder="Please select...">
                                <input type="hidden" id="item_classi_id">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 column mt-1" style="border: 1px solid #dee2e6; border-radius: 12px;" >
                        <div class="col-md-12 mx-auto row my-2 py-2 text-left" >
                            <label class="my-auto col-md-12">Covered by Selected ASC</label>
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
                    <table id="table-kam-one" class="table table-bordered table-responsive">
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
                            <tr>
                                <td colspan="7"></td>
                            </tr>
                            <tr>
                                <td colspan="7" style="text-align: center;">No data available</td>
                            </tr>
                            <tr>
                                <td colspan="7"></td>
                            </tr>
                            <tr>
                                <td colspan="7"></td>
                            </tr>
                            <tr>
                                <td colspan="7"></td>
                            </tr>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<script>
    $(document).ready(function() {
        fetchData();

        let ba = <?= json_encode($brand_ambassador); ?>;
        let area = <?= json_encode($area); ?>;
        let brand = <?= json_encode($brand); ?>;
        let store = <?= json_encode($store_branch); ?>;
        let item_classification = <?= json_encode($item_classification); ?>;

        autocomplete_field($("#brandAmbassador"), $("#ba_id"), ba, "description", "id", function(result) {
            // console.log(result);

            let url ="<?= base_url("cms/global_controller"); ?>";
            let data = {
                event: "list",
                select: "tbl_store.id, tbl_store.description, tbl_area.id AS area_id, tbl_area.description AS area",
                query: "tbl_brand_ambassador.id = " + result.id,
                offset: offset,
                limit: 0,
                table: "tbl_brand_ambassador",
                join: [
                    {
                        table: "tbl_store",
                        query: "tbl_store.id = tbl_brand_ambassador.store",
                        type: "left"
                    },
                    {
                        table: "tbl_store_group",
                        query: "tbl_store_group.store_id = tbl_store.id",
                        type: "left"
                    },
                    {
                        table: "tbl_area",
                        query: "tbl_store_group.area_id = tbl_area.id",
                        type: "left"
                    }
                ]
            }

            aJax.post(url, data, function(result) {
                let store_name = JSON.parse(result);
                console.log(store_name);

                $("#store").val(store_name[0].description);
                $("#store_id").val(store_name[0].id);

                $("#area").val(store_name[0].area);
                $("#area_id").val(store_name[0].area_id);
            })
        });

        autocomplete_field($("#store"), $("#store_id"), store, "description", "id", function(result) {
            console.log(result.id);

            let url ="<?= base_url("cms/global_controller"); ?>";
            let data = {
                event: "list",
                select: "tbl_brand_ambassador.id, tbl_brand_ambassador.name, tbl_area.description AS area, tbl_area.id AS area_id",
                query: "tbl_store.id = " + result.id,
                offset: offset,
                limit: 0,
                table: "tbl_store",
                join: [
                    {
                        table: "tbl_brand_ambassador",
                        query: "tbl_brand_ambassador.store = tbl_store.id",
                        type: "left"
                    },
                    {
                        table: "tbl_store_group",
                        query: "tbl_store_group.store_id = tbl_store.id",
                        type: "left"
                    },
                    {
                        table: "tbl_area",
                        query: "tbl_store_group.area_id = tbl_area.id",
                        type: "left"
                    }
                ]
            }

            aJax.post(url, data, function(result) {
                let baname = JSON.parse(result);
                console.log(baname);

                if(baname[0].name !== null) {
                    $("#brandAmbassador").val(baname[0].name);
                    $("#ba_id").val(baname[0].id);

                    $("#area").val(baname[0].area);
                    $("#area_id").val(baname[0].area_id);
                } else {
                    $("#brandAmbassador").val("No Brand Ambassador");
                }

            })
        });

        // autocomplete_field($("#brandAmbassador"), $("#ba_id"), ba);
        autocomplete_field($("#area"), $("#area_id"), area, "area_description", "id", function(res) {
            let data = {
                event: "list",
                query: "area_id = " + res.id,
                select: "tbl_store.id AS store_id, tbl_brand_ambassador.id AS ba_id, tbl_store.description AS store_description, tbl_brand_ambassador.name AS ba_name",
                table: "tbl_store_group",
                join: [
                    {
                        table: "tbl_store",
                        query: "tbl_store_group.store_id = tbl_store.id",
                        type: "left"
                    },
                    {
                        table: "tbl_brand_ambassador",
                        query: "tbl_store.id = tbl_brand_ambassador.store",
                        type: "left"
                    }
                ]
            }

            aJax.post(base_url + "cms/global_controller", data, function(res) {
                let info = JSON.parse(res);
                
                autocomplete_field($("#brandAmbassador"), $("#ba_id"), info, "ba_name", "ba_id", function(res) {
                    $("#store").val(res.store_description);
                    $("#store_id").val(res.store_id);
                })

                autocomplete_field($("#store"), $("#store_id"), info, "store_description", "store_id", function(res) {
                    $("#brandAmbassador").val(res.ba_name);
                    $("#ba_id").val(res.ba_id);
                })
            })
        });



        autocomplete_field($("#brand"), $("#brand_id"), brand, "brand_description");
        // autocomplete_field($("#store"), $("#store_id"), store);
        autocomplete_field($("#item_classi"), $("#item_classi_id"), item_classification, "item_class_description");

        $(document).on('click', '#clearButton', function () {
            $('input[type="text"]').val('');
            $('input[type="checkbox"]').prop('checked', false);
            $('input[name="coveredASC"][value="with_ba"]').prop('checked', false);
            $('input[name="coveredASC"][value="without_ba"]').prop('checked', false);
            $('select').prop('selectedIndex', 0);
            $('#refreshButton').click();
        });

        $(document).on('click', '#refreshButton', function () {
            if($('#brandAmbassador').val() == ""){
                $('#ba_id').val('');
            }
            if($('#area').val() == ""){
                $('#area_id').val('');
            }
            if($('#brand').val() == ""){
                $('#brand_id').val('');
            }
            if($('#store').val() == ""){
                $('#store_id').val('');
            }
            if($('#item_classi').val() == ""){
                $('#item_classi_id').val('');
            }
            fetchData();
        });

        $('#previewButton').click(function() {
        });
        
        $('#exportButton').click(function() {
            prepareExport();
        });
    });

    function fetchData() {
        let selectedBa = $('#brandAmbassador').val();
        let selectedArea = $('#area').val();
        let selectedBrand = $('#brand').val();
        let selectedMonth = $('#month').val();
        let selectedWeek = $('#week').val();
        let selectedStore = $('#store').val();
        let selectedItemCat = $('#item_classi').val();
        initializeTable(selectedBa, selectedArea, selectedBrand, selectedMonth, selectedWeek, selectedStore, selectedItemCat);
    }

    function initializeTable(selectedBa = null, selectedArea = null, selectedBrand = null, selectedMonth = null, selectedWeek = null, selectedStore = null, selectedItemCat = null) {
        if ($.fn.DataTable.isDataTable('#table-kam-one')) {
            let existingTable = $('#table-kam-one').DataTable();
            existingTable.clear().destroy();
        }

        let table = $('#table-kam-one').DataTable({
            paging: true,
            searching: false,
            ordering: true,
            info: true,
            lengthChange: false,
            colReorder: true, 
            ajax: {
                url: base_url + 'trade-dashboard/trade-kam-one',
                type: 'POST',
                data: function(d) {
                    d.ba = selectedBa;
                    d.area = selectedArea;
                    d.brand = selectedBrand;
                    d.week = selectedWeek === "0" ? null : selectedWeek;
                    d.month = selectedMonth === "0" ? null : selectedMonth;
                    d.store = selectedStore === "0" ? null : selectedStore;
                    d.itemcat = selectedItemCat === "0" ? null : selectedItemCat;
                    d.limit = d.length;
                    d.offset = d.start;
                },
                dataSrc: function(json) {
                    return json.data.length ? json.data : [];
                }
            },
            columns: [
                { data: 'store_name' },
                { data: 'asc_name' },
                { data: 'ambassador_name' },
                { data: 'item_name' },
                { data: 'item' },
                { data: 'item_class' },
                { data: 'total_qty' }
            ].filter(Boolean),
            pagingType: "full_numbers",
            pageLength: 10,
            processing: true,
            serverSide: true,
            searching: false,
            lengthChange: false
        });
    }

    // $("#previewButton").on('click', function() {
    //     prepareExport();
    // })

    function get_data(id, table, parameter) {
        return new Promise((resolve, reject) => {
            let query = id ? " id = " + id : ""
            let url = "<?= base_url('cms/global_controller'); ?>";
            let data = {
                event: "list",
                select: parameter,
                query: query,
                limit: 0,
                offset: 0,
                table: table,
                order: {}
            };
    
            aJax.post(url, data, function(result) {
                try {
                    if(id) {
                        resolve(JSON.parse(result)[0][parameter]);
                    } else {
                        resolve(null);
                    }
                } catch (error) {
                    reject(error);
                }
            })
        })
    }

    async function prepareExport() {
        let ba = $("#ba_id").val();
        let area = $("#area_id").val();
        let brand = $("#brand_id").val();
        let month = $("#month").val();
        let week = $("#week").val();
        let store = $("#store_id").val();
        let itemClass = $("#item_classi_id").val();
        let covered_asc = $("[name='coveredASC']:checked").val();
        
        let baval = await get_data(ba, 'tbl_brand_ambassador', 'name');
        let areaval = await get_data(area, 'tbl_area', 'description');
        let brandval = await get_data(brand, 'tbl_brand', 'brand_description');
        let monthval = await get_data(month, 'tbl_month', 'month');
        let weekval = await get_data(week, 'tbl_week', 'name');
        let itemclassval = await get_data(itemClass, 'tbl_classification', 'item_class_description');
        let storeval = await get_data(store, 'tbl_store', 'description');
        
        let fetchPromises = new Promise((resolve, reject) => {
            fetchTradeDashboardData({
                baseUrl: "<?= base_url(); ?>",
                selectedBa: baval,
                selectedArea: areaval,
                selectedBrand: brandval,
                selectedMonth: monthval,
                selectedWeek: weekval,
                selectedStore: storeval,
                selectedClass: itemclassval,
                length: 10,
                start: 0,
                onSuccess: function(data) {
                    let newData = data.map(({ ambassador_name, asc_name, brand, item, item_class, item_name, store_name, total_qty }) => ({
                        "ambassador_name": ambassador_name,
                        "asc_name": asc_name,
                        "brand": brand,
                        "item": item,
                        "item_class": item_class,
                        "item_name": item_name,
                        "store_name": store_name,
                        "total_qty": total_qty,
                    }));
                    // console.log(newData);
                    resolve(newData);
                },
                onError: function(error) {
                    reject(error);
                }
            });
        });

        fetchPromises.then((result) => {
            let formattedData = result.flat();
            console.log(formattedData);

            const headerData = [
                ["LIFESTRONG MARKETING INC."],
                ["Report: Kam1 Dashboard"],
                ["Date Generated: " + formatDate(new Date())],
                ["Brand Ambassador: " + (baval ? baval : "ALL")],
                ["Area: " + (areaval ? areaval : "ALL")],
                ["Brand: " + (brandval ? brandval : "ALL")],
                ["Month: " + (monthval ? monthval : "ALL")],
                ["Week: " + (weekval ? weekval : "ALL")],
                ["Item Category: " + (itemclassval ? itemclassval : "ALL")],
                ["Store Name: " + (storeval ? storeval : "ALL")]
            ];

            exportArrayToCSV(formattedData, `Report: Kam1 Dashboard - ${formatDate(new Date())}`, headerData);
        }).catch((error) => {
            console.error(error);
        })
    }

    function fetchTradeDashboardData({ 
        baseUrl, 
        selectedBa,
        selectedArea,
        selectedBrand,
        selectedMonth,
        selectedWeek,
        selectedStore,
        selectedClass,
        length,
        start, 
        onSuccess, 
        onError 
    }) {
        let allData = [];

        function fetchData(offset) {
            $.ajax({
                url: baseUrl + 'trade-dashboard/trade-kam-one',
                type: 'GET',
                data: {
                    ba: selectedBa === 0 ? null : selectedBa,
                    area: selectedArea === 0 ? null : selectedArea,
                    brand: selectedBrand === 0 ? null : selectedBrand,
                    month: selectedMonth === 0 ? null : selectedMonth,
                    week: selectedWeek === 0 ? null : selectedWeek,
                    store: selectedStore === 0 ? null : selectedStore,
                    itemcat: selectedClass === 0 ? null : selectedClass,
                    limit: length,
                    offset: offset
                },
                success: function(response) {
                    console.log(response);
                    if (response.data && response.data.length) {
                        allData = allData.concat(response.data);

                        if (response.data.length === length) {
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

    function exportArrayToCSV(data, filename, headerData) {
        const worksheet = XLSX.utils.json_to_sheet(data, { origin: headerData.length });

        XLSX.utils.sheet_add_aoa(worksheet, headerData, { origin: "A1" });

        const csvContent = XLSX.utils.sheet_to_csv(worksheet);

        const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });

        saveAs(blob, filename + ".csv");
    }
    
</script>
