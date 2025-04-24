<?= view("site/stocks/all-store/data-all-store-filter"); ?> 

<style>
    .content-wrapper, .content {
        margin-top: 0 !important;
        padding-top: 0 !important;
        padding-bottom: 30px;
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
/*
    #ExportPDF{
        color: #fff;
        background-color: #143996 !important;
    }*/

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


.select2-container--default .select2-selection--multiple .select2-selection__choice {
  background-color: #ffc107 !important; /* Bootstrap's bg-warning */
  border-color: #ffc107 !important;
  color: #000 !important; /* Ensure text is readable */
  font-weight: 500;
}

body .hide-div {
  display: none;
}
/* Set specific column widths */
th:nth-child(1), td:nth-child(1) { width: 20%; }
th:nth-child(2), td:nth-child(2) { width: 25%; }
th:nth-child(3), td:nth-child(3) { width: 20%; }
th:nth-child(4), td:nth-child(4) { width: 20%; } 
th:nth-child(5), td:nth-child(5) { width: 15%; } 
th:nth-child(6), td:nth-child(6) { width: 20%; } 
</style>

<div class="wrapper">
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid py-4">

                <!-- Filters Section -->
                <?php if (isset($breadcrumb)): ?>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent px-0 mb-0">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url() ?>">
                                        <i class="fas fa-home"></i>
                                    </a>
                                </li>
                                <?php 
                                    $last = end($breadcrumb);
                                    foreach ($breadcrumb as $label => $url): 
                                        if ($url != ''):
                                ?>
                                    <li class="breadcrumb-item">
                                        <?= $label ?>
                                    </li>
                                <?php else: ?>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <?= $label ?>
                                    </li>
                                <?php 
                                        endif;
                                    endforeach; 
                                ?>
                            </ol>
                        </nav>
                        <!-- Right side content -->
                        <div class="ml-auto text-muted small" style="white-space: nowrap;">
                            <strong>Source:</strong> <?= !empty($source) ? $source : 'N/A'; ?> - <?= !empty($source_date) ? $source_date : 'N/A'; ?>

                        </div>
                    </div>
                <?php endif; ?>
                <!-- filter-->
                <!-- DataTables Section -->
                <div class="row mt-4"><!-- use mt-4 or define mt-12 in custom CSS -->
                    <div class="col-md-12">
                        <div class="card p-4 shadow-lg text-center text-muted table-empty">
                          <i class="fas fa-filter mr-2"></i> Please select a filter
                        </div>

                        <div class="card mt-4 p-4 shadow-sm hide-div">
                            <table id="table_data_all_store" class="table table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="8"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                        >
                                            OVERALL STOCK DATA OF ALL STORES
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-title-field">SKU</th>
                                        <th class="tbl-title-field">SKU Name</th>
                                        <th class="tbl-title-field">Item Class</th>
                                        <th class="tbl-title-field">Total Qty</th>
                                        <th class="tbl-title-field">Ave Sales Unit</th>
                                        <th class="tbl-title-field">SWC</th>
                                    </tr>
                                </thead>
                                  <tbody>
                                      <tr>
                                          <td colspan="7" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="7" class="text-center py-4 text-muted">
                                              No data available
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="7" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                  </tbody>
                            </table>
                        </div>
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
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

 -->

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>

    let ba = <?= json_encode($brand_ambassador); ?>;
    let area = <?= json_encode($area); ?>;
    let brand = <?= json_encode($brand); ?>;
    let store = <?= json_encode($store_branch); ?>;
    let item_classification = <?= json_encode($item_classification); ?>;

    $(document).ready(function() {
        fetchData();

        $('#ItemClass').select2({ placeholder: 'Select Item Class' });
        $('#inventoryStatus').select2({ placeholder: 'Select inventory statuses' });
        autocomplete_field($("#brandAmbassador"), $("#ba_id"), ba, "description", "id", function(result) {

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

                $("#store").val(store_name[0].description);
                $("#store_id").val(store_name[0].id);

                $("#area").val(store_name[0].area);
                $("#area_id").val(store_name[0].area_id);
            })
        });

        autocomplete_field($("#store"), $("#store_id"), store, "description", "id", function(result) {

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
            $("#store").val("");
            $("#store_id").val("");

            $("#brandAmbassador").val("");
            $("#ba_id").val("");

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
                        type: "right"
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
            $('input[type="text"], input[type="number"]').val('');
            $('input[type="checkbox"]').prop('checked', false);
            $('input[name="coveredASC"][value="with_ba"]').prop('checked', false);
            $('input[name="coveredASC"][value="without_ba"]').prop('checked', false);
            $('select').prop('selectedIndex', 0);
            $('.select2').val(null).trigger('change');
            // $('table[id^="table_"]').each(function () {
            //     $(this).closest('.table-responsive').hide();
            // });
            $('.hide-div').hide();
            $('.table-empty').show();
            $('#refreshButton').click();
        });

        $(document).on('click', '#refreshButton', function () {
            const fields = [
                { input: '#ItemClass', target: '#ItemClass' },
                { input: '#area', target: '#area_id' },
                { input: '#brand', target: '#brand_id' },
                { input: '#store', target: '#store_id' },
                { input: '#item_classi', target: '#item_classi_id' },
                { input: '#qtyscp', target: '#qtyscp' }
            ];

            let counter = 0;

            fields.forEach(({ input, target }) => {
                const val = $(input).val();
                const hasValue = Array.isArray(val) ? val.length > 0 : val;
                if (!hasValue || val === undefined) {
                    $(target).val('');
                } else {
                    counter++;

                    // Initialize Select2 if it's a select
                    if ($(input).is('select') && !$(input).hasClass("select2-hidden-accessible")) {
                        $(input).select2();
                    }
                }
            });
            if (counter >= 1) {
                fetchData();
                $('.table-empty').hide();
                $('.hide-div').show();
            }
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
        let selectedQty = $('#qtyscp').val();
        let selectedInventoryStatus = $('#inventoryStatus').val(); // returns an array
        if (!selectedInventoryStatus || selectedInventoryStatus.length === 0) return;
       // table-empty
        $('.table-empty').hide(); 
        $('.table-responsive').show();        
        initializeTable(selectedBa, selectedArea, selectedBrand, selectedMonth, selectedWeek, selectedStore, selectedItemCat, selectedQty);
    }

    function initializeTable(selectedBa = null, selectedArea = null, selectedBrand = null, selectedMonth = null, selectedWeek = null, selectedStore = null, selectedItemCat = null, selectedQty = 0) {
        if ($.fn.DataTable.isDataTable('#table_data_all_store')) {
            let existingTable = $('#table_data_all_store').DataTable();
            existingTable.clear().destroy();
        }

        let table = $('#table_data_all_store').DataTable({
            paging: true,
            searching: false,
            ordering: true,
            info: true,
            lengthChange: false,
            colReorder: true, 
            ajax: {
                url: base_url + 'stocks/get-data-all-store',
                type: 'POST',
                data: function(d) {
                    d.ba = selectedBa;
                    d.area = selectedArea;
                    d.brand = selectedBrand;
                    d.week = selectedWeek === "0" ? null : selectedWeek;
                    d.month = selectedMonth === "0" ? null : selectedMonth;
                    d.store = selectedStore === "0" ? null : selectedStore;
                    d.itemcat = selectedItemCat === "0" ? null : selectedItemCat;
                    d.qty = selectedQty === "0" ? null : selectedQty;
                    d.limit = d.length;
                    d.offset = d.start;
                },
                dataSrc: function(json) {
                    return json.data.length ? json.data : [];
                }
            },
            columns: [
                { data: 'store_name'},
                { data: 'asc_name'},
                { data: 'ambassador_names'},
                { data: 'item_name'},
                { data: 'item'},
                { data: 'item_class'},
                { data: 'total_qty'}
            ].filter(Boolean),
            pagingType: "full_numbers",
            pageLength: 10,
            processing: true,
            serverSide: true,
            searching: false,
            lengthChange: false
        });
    }

    function handleAction(action) {
        if (action === 'preview') {
            alert('coming soon!');
        } else if (action === 'export') {
            prepareExport();
        } else {
            alert('wala rito boy');
        }
    }

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
                    resolve(newData);
                },
                onError: function(error) {
                    reject(error);
                }
            });
        });

        fetchPromises.then((result) => {
            let formattedData = result.flat();

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
                url: baseUrl + 'stocks/get-data-all-store',
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
