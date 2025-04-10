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
        color: #fff;
        background-color: #301311 !important;
    }

    #ExportPDF{
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

    .swal2-checkbox{
        display: none !important;
    }

</style>

<div class="wrapper">
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid py-4">
                <!-- Filters Section -->
                <div class="card shadow-lg" 
                    style="width: 100%;"
                    id="step2" 
                    data-title="Step 1: Applying Filters"
                    data-intro="
                    - The dashboard includes filters to refine data based on specific criteria. <br><br>
                    To apply filters :<br><br>
                    Click Next" 
                    data-step="2"
                >
                    <div class="md-center p-2 col">
                        <h5 class="mt-1 mb-1">
                            <i 
                                class="fas fa-filter"
                                id="step1" 
                                data-title="Welcome to the Info for BA Dashboard tutorial!"
                                data-intro="
                                This guide will walk you through using filters, sorting options, 
                                and exporting reports to PDF or Excel." 
                                data-step="1"
                            ></i> 
                            <span
                                id="step12" 
                                data-title="Final Notes"
                                data-intro="
                                - Use filters and sorting to analyze data effectively.<br>
                                - Export reports for documentation and decision-making.<br><br>
                                You're now ready to use the BA Dashboard efficiently! 🚀<br>
                                Let us know if you need further assistance." 
                                data-step="12"
                            >
                                F I L T E R
                            </span>
                        </h5>
                    </div>
                    <div class="row p-4">
                        <!-- Left Side: Inputs and Selected BA -->
                        <div class="col-md-6">
                            <div class="d-flex flex-column">
                                <!-- Brand Ambassador -->
                                <div 
                                    class="p-2 d-flex flex-row"
                                    id="step3" 
                                    data-title="Brand Ambassador:"
                                    data-intro="
                                    - Type on the input box and select one of the suggested options.<br><br>
                                    Click Next" 
                                    data-step="3"
                                >
                                    <label for="brand_ambassadors" class="col-3">Brand Ambassador</label>
                                    <input type="text" id="brand_ambassadors" class="form-control" placeholder="Please select...">
                                    <input type="hidden" id="ba_id">
                                </div>
                                <!-- Store Name -->
                                <div 
                                    class="p-2 d-flex flex-row"
                                    id="step4" 
                                    data-title="Store Name:"
                                    data-intro="
                                    - Type on the input box and select one of the suggested options.<br><br>
                                    Click Next" 
                                    data-step="4"
                                >
                                    <label for="storeName" class="col-3">Store Name</label>
                                    <input type="text" id="store_branch" class="form-control" placeholder="Please select...">
                                    <input type="hidden" id="store_id">
                                </div>
                                <!-- Brand -->
                                <div 
                                    class="p-2 d-flex flex-row"
                                    id="step5" 
                                    data-title="Brand:"
                                    data-intro="
                                    - Type on the input box and select one of the suggested options.<br><br>
                                    Click Next" 
                                    data-step="5"
                                >
                                    <label for="brand" class="col-3">Brand</label>
                                    <input type="text" id="brand" class="form-control" placeholder="Please select...">
                                    <input type="hidden" id="brand_id">
                                </div>
                                <!-- Selected BA -->
                                <span class="p-2 d-flex flex-row">
                                    <strong class="col-3 text-left">
                                        Area / ASC Name:
                                    </strong>
                                    <p id="ar_asc_name" class="align-items-center col mb-0"> 
                                        Please Select Brand Ambassador
                                    </p>
                                </span>
                            </div>
                        </div>

                        <!-- Right Side: Radio Filters, Sorting Order & Refresh Button -->
                        <div class="col-md-4">
                            <!-- Sorting Order -->
                            <div class="card-dark column"
                                id="step7" 
                                data-title="Step 2: Sorting Data"
                                data-intro="
                                - Click on any column header in the table to sort the data in ascending or descending order.<br>
                                - Click again to switch between sorting orders.<br><br>
                                Click Next" 
                                data-step="7"
                            >
                                <label class="pt-2 pl-3">Sort By</label>
                                <select class="form-control col mx-auto my-2" id="sortBy" style="width: 95%">
                                    <option value="item_name">Item Name</option>
                                    <option value="sum_total_qty">Quantity</option>
                                </select>
                                <div class="text-left pl-3 pb-3">
                                    <input type="radio" name="sortOrder" value="ASC" checked> Ascending
                                    <input type="radio" name="sortOrder" value="DESC"> Descending
                                </div>
                            </div>
                            <!-- Radio Filters -->
                            <div
                                class="p-2 d-flex flex-column flex-md-row align-items-center"
                                id="step6" 
                                data-title="Type:"
                                data-intro="
                                - Choose All for a full view or Outright/Consignment for specific transaction types<br><br>
                                Click Next" 
                                data-step="6"
                            >
                                <label class="col-12 col-md-4 text-center text-md-start mb-2 mb-md-0">Filter by Type</label>
                                <div class="btn-group btn-group-toggle d-flex flex-wrap col-12 col-md" data-toggle="buttons" style="background-color: white; border-radius: 8px;">
                                    <label class="btn btn-outline-primary active main_all">
                                        <input type="radio" name="filterType" value="3" checked> All
                                    </label>
                                    <label class="btn btn-outline-primary">
                                        <input type="radio" name="filterType" value="1"> Outright
                                    </label>
                                    <label class="btn btn-outline-primary">
                                        <input type="radio" name="filterType" value="0"> Consignment
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <!-- Refresh Button -->
                            <div class="row">
                                <div class="p-2 d-flex justify-content-end">
                                    <button class="btn btn-primary btn-sm" id="refreshButton"
                                        id="step8" 
                                        data-title="Step 3:"
                                        data-intro="
                                        - Click the Refresh button to update the data in all tables based on the set filters<br><br>
                                        Click Next" 
                                        data-step="8"
                                    >
                                        <i class="fas fa-sync-alt"></i> Refresh
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="p-2 d-flex justify-content-end">
                                    <button id="clearButton" class="btn btn-secondary btn-sm"><i class="fas fa-sync-alt"></i> Clear</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DataTables Section -->
                <div class="row mt-3"
                    id="step9" 
                    data-title="Step 4: Understanding the Tables"
                    data-intro="
                    The dashboard includes four key tables displaying product data:<br><br>
                    <b>Slow Moving SKU</b> – Products with low sales velocity.<br>
                    <b>Overstock SKU</b> – Products with excess inventory.<br>
                    <b>NPD (New Product Development) SKU</b> – Newly introduced products.<br>
                    <b>Hero SKU</b> – Best-performing products with high sales.<br><br>
                    Click Next" 
                    data-step="9"
                >
                    <div class="col-md-3">
                        <div class="card p-3 shadow-lg">
                            <!-- <div class="tbl-title-field" style="font-weight: bold; font-family: 'Poppins', sans-serif;">
                                <h5>SLOW MOVING SKU'S</h5>
                            </div> -->
                            <table id="slowMovingTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="2"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif;"
                                            class="tbl-title-header"
                                        >
                                            SLOW MOVING SKU'S
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-title-field">SKU Name</th>
                                        <th class="tbl-title-field">Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                         <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">No data available</td>
                                    </tr>
                                    <tr>
                                         <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card p-3 shadow-lg">
                            <!-- <div class="tbl-title-field" style="font-weight: bold; font-family: 'Poppins', sans-serif;">
                                <h5>OVERSTOCK SKU'S</h5>
                            </div> -->
                            <table id="overstockTable" class="table table-bordered" >
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="2"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif;"
                                            class="tbl-title-header"
                                        >OVERSTOCK SKU'S</th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-title-field">SKU Name</th>
                                        <th class="tbl-title-field">Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                         <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">No data available</td>
                                    </tr>
                                    <tr>
                                         <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card p-3 shadow-lg">
                            <!-- <div class="tbl-title-field" style="font-weight: bold; font-family: 'Poppins', sans-serif;">
                                <h5>NPD SKU'S</h5>
                            </div> -->
                            <table id="npdTable" class="table table-bordered" style="min-height: 100px !important;">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="2"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif;"
                                            class="tbl-title-header"
                                        >NPD SKU'S</th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-title-field">SKU Name</th>
                                        <th class="tbl-title-field">Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                         <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">No data available</td>
                                    </tr>
                                    <tr>
                                         <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card p-3 shadow-lg">
                            <!-- <div class="tbl-title-field" style="font-weight: bold; font-family: 'Poppins', sans-serif;">
                                <h5>HERO SKU'S</h5>
                            </div> -->
                            <table 
                                id="heroTable" 
                                class="table table-bordered" 
                                style="min-height: 100px !important; min-width: 200px !important;"
                            >
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="2"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif;"
                                            class="tbl-title-header"
                                        >HERO SKU'S</th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-title-field">SKU Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                         <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">No data available</td>
                                    </tr>
                                    <tr>
                                         <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <!-- Buttons -->
                <div class="d-flex justify-content-end mt-3">
                    <button 
                        class="btn btn-info mr-2" 
                        id="ExportPDF"
                        data-title="Step 5: Exporting the Report (PDF)"
                        data-intro="Paki palitan to haha" 
                        data-step="10"
                        onclick="handleAction('export_pdf')"
                    >
                        <i class="fas fa-file-export"></i> PDF
                    </button>
                    <button 
                        class="btn btn-success" 
                        id="exportButton"
                        id="step11" 
                        data-title="Step 6: Exporting the Report (Excel)"
                        data-intro="
                        Once satisfied with the report:<br><br>
                        Click the Export button.<br>
                        Choose between PDF or Excel format.<br>
                        The file will be generated and downloaded to your device.<br><br>
                        <small>Tip: Use PDF for sharing and Excel for further data analysis.</small><br><br>
                        Click Next" 
                        data-step="11"
                        onclick="handleAction('export_excel')"
                    >
                        <i class="fas fa-file-export"></i> Excel
                    </button>
                </div>
            </div>
        </div>

        <!-- Tutorial Floating Modal -->
        <div class="modal fade" id="popup_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm"> 
                <div class="modal-content">
                    <!-- Header -->
                    <div class="modal-header">
                        <h5 class="modal-title"><b>Welcome to the BA Dashboard</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeTutorial()">
                            <span>&times;</span>
                        </button>
                    </div>
                    <!-- Body -->
                    <div class="modal-body text-center">
                        <p>Would you like to start the tutorial?</p>
                    </div>
                    <!-- Footer -->
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-primary" id="start_tutorial" onclick="startTutorial()" >Yes, Start</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeTutorial()" >No, Thanks</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Bootstrap 5 & DataTables CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intro.js/minified/introjs.min.css">

<!-- jQuery (Use 3.6.0 for Stability) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- DataTables & Intro.js -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/intro.js/minified/intro.min.js"></script>

<!-- Bootstrap JS (AFTER jQuery) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- FileSaver -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<script>
    var base_url = "<?= base_url(); ?>";
    let brand_ambassadors = <?= json_encode($brand_ambassador) ?>;
    let store_branch = <?= json_encode($store_branch) ?>;
    let brands = <?= json_encode($brands) ?>;

    $(document).ready(function () {
        fetchData();
        $(document).on('click', '#clearButton', function () {
            $('input[type="text"], input[type="number"], input[type="date"]').val('');
            $('input[type="checkbox"]').prop('checked', false);
            $('input[name="sortOrder"][value="ASC"]').prop('checked', true);
            $('input[name="sortOrder"][value="DESC"]').prop('checked', false);
            $('.btn-outline-primary').removeClass('active');
            $('.main_all').addClass('active');
            $('select').prop('selectedIndex', 0);
            $('#refreshButton').click();
        });

        autocomplete_field($("#brand_ambassadors"), $("#ba_id"), brand_ambassadors, "description", "id", function(result) {
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
                $("#store_branch").val(store_name[0].description);
                $("#store_id").val(store_name[0].id);
            })
        });

        autocomplete_field($("#store_branch"), $("#store_id"), store_branch, "description", "id", function(result) {
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
                    $("#brand_ambassadors").val(baname[0].name);
                    $("#ba_id").val(baname[0].id);
                } else {
                    $("#brand_ambassadors").val("No Brand Ambassador");
                }

            })
        });
        autocomplete_field($("#brand"), $("#brand_id"), brands, "brand_description", "id");
        if (!localStorage.getItem("TutorialMessage")) {
            $('#popup_modal').modal('show');
        } else {
            $('#popup_modal').modal('hide');
        }
    }); 

    function startTutorial() {
        localStorage.setItem("TutorialMessage", "true");
        $('#popup_modal').modal('hide');
        introJs().start();
    }

    function closeTutorial() {
        localStorage.setItem("TutorialMessage", "true");
        $('#popup_modal').modal('hide');
    }

    $(document).on('click', '#refreshButton', function () {
        if($('#brand_ambassadors').val() == ""){
            $('#ba_id').val('');
        }
        if($('#store_branch').val() == ""){
            $('#store_id').val('');
        }
        if($('#brand').val() == ""){
            $('#brand_id').val('');
        }
        let selectedBa = $('#ba_id').val();
        if(selectedBa !== 0){
            get_area_asc(selectedBa);
            
        }else{
            $('#ar_asc_name').text('Please Select Brand Ambassador'); 
        }
        fetchData();
    });

    function fetchData() {
        let selectedType = $('input[name="filterType"]:checked').val();
        let selectedBa = $('#brand_ambassadors').val();
        let selectedStore = $('#store_branch').val();
        let selectedBrand = $('#brand').val();
        let selectedSortField = $('#sortBy').val();
        let selectedSortOrder = $('input[name="sortOrder"]:checked').val();

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
            destroy: true,
            ajax: {
                url: base_url + 'trade-dashboard/trade-ba',
                type: 'GET',
                data: function (d) {
                    d.sort_field = selectedSortField;
                    d.sort = selectedSortOrder;
                    d.brand = selectedBrand === "" ? null : selectedBrand;
                    d.brand_ambassador = selectedBa === "" ? null : selectedBa;
                    d.store_name = selectedStore === "" ? null : selectedStore;
                    d.ba_type = selectedType;
                    d.type = type;
                    d.limit = d.length;
                    d.offset = d.start;
                },
                dataSrc: function(json) {
                    return json.data.length ? json.data : [];
                }
            },
            columns: [
                { data: 'item_name' },
                type !== 'hero' ? { data: 'sum_total_qty' } : null
            ].filter(Boolean),
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

    function handleAction(action) {
        modal.loading(true);

        let selectedType = $('input[name="filterType"]:checked').val();
        let selectedBa = $('#brand_ambassadors').val();
        let selectedStore = $('#store_branch').val();
        let selectedBrand = $('#brand').val();
        let selectedSortField = $('#sortBy').val();
        let selectedSortOrder = $('input[name="sortOrder"]:checked').val();
        let ascName = $('#ar_asc_name').text().trim();
        
        let type = 'slowMoving';

        let url = base_url + 'trade-dashboard/generate-' + (action === 'export_pdf' ? 'pdf' : 'excel') + '-ba?'
            + 'sort_field=' + encodeURIComponent(selectedSortField)
            + '&sort=' + encodeURIComponent(selectedSortOrder)
            + '&brand=' + encodeURIComponent(selectedBrand || '')
            + '&brand_ambassador=' + encodeURIComponent(selectedBa || '')
            + '&store_name=' + encodeURIComponent(selectedStore || '')
            + '&ba_type=' + encodeURIComponent(selectedType)
            + '&asc_name=' + encodeURIComponent(ascName)
            + '&type=' + encodeURIComponent(type)
            + '&limit=' + encodeURIComponent(length)
            + '&offset=' + encodeURIComponent(offset);

        let iframe = document.createElement('iframe');
        iframe.style.display = "none";
        iframe.src = url;
        document.body.appendChild(iframe);

        setTimeout(() => {
            modal.loading(false);
        }, 5000);
    }

</script>
