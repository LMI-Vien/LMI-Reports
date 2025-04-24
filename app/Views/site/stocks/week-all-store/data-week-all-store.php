<?= view("site/stocks/week-all-store/data-week-all-store-filter"); ?> 

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
/*
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
*/

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

    body .hide-div {
      display: none;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
      background-color: #ffc107 !important; /* Bootstrap's bg-warning */
      border-color: #ffc107 !important;
      color: #000 !important; /* Ensure text is readable */
      font-weight: 500;
    }
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
                <!-- DataTables Section -->
                <div class="row mt-4"><!-- use mt-4 or define mt-12 in custom CSS -->
                    <div class="col-md-12">
                            <div class="card p-4 shadow-lg text-center text-muted table-empty">
                              <i class="fas fa-filter mr-2"></i> Please select a filter
                            </div>

                            <div class="hide-div">
                                <table id="table_slowMovingTable" class="table table-bordered" style="min-height: 100px !important; width: 100% !important;">
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
                                            <th class="tbl-title-field">LMI/RGDI Code</th>
                                            <th class="tbl-title-field">Qty (Cal Wk 3)</th>
                                            <th class="tbl-title-field">Qty (Cal Wk 2)</th>
                                            <th class="tbl-title-field">Qty (Cal Wk 1)</th>
                                        </tr>
                                    </thead>
                                      <tbody>
                                          <tr>
                                              <td colspan="5" class="text-center py-4 text-muted">
                                              </td>
                                          </tr>
                                          <tr>
                                              <td colspan="5" class="text-center py-4 text-muted">
                                                  No data available
                                              </td>
                                          </tr>
                                          <tr>
                                              <td colspan="5" class="text-center py-4 text-muted">
                                              </td>
                                          </tr>
                                      </tbody>
                                </table>
                            </div>

                            <div class="hide-div">
                                <table id="table_overstockTable" class="table table-bordered" style="min-height: 100px !important; width: 100% !important;">
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
                                            <th class="tbl-title-field">LMI/RGDI Code</th>
                                            <th class="tbl-title-field">Qty (Cal Wk 3)</th>
                                            <th class="tbl-title-field">Qty (Cal Wk 2)</th>
                                            <th class="tbl-title-field">Qty (Cal Wk 1)</th>
                                        </tr>
                                    </thead>
                                      <tbody>
                                          <tr>
                                              <td colspan="5" class="text-center py-4 text-muted">
                                              </td>
                                          </tr>
                                          <tr>
                                              <td colspan="5" class="text-center py-4 text-muted">
                                                  No data available
                                              </td>
                                          </tr>
                                          <tr>
                                              <td colspan="5" class="text-center py-4 text-muted">
                                              </td>
                                          </tr>
                                      </tbody>
                                </table>
                            </div>

                            <div class="hide-div">
                                <table id="table_npdTable" class="table table-bordered" style="min-height: 100px !important; width: 100% !important;">
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
                                            <th class="tbl-title-field">LMI/RGDI Code</th>
                                            <th class="tbl-title-field">Qty (Cal Wk 3)</th>
                                            <th class="tbl-title-field">Qty (Cal Wk 2)</th>
                                            <th class="tbl-title-field">Qty (Cal Wk 1)</th>
                                        </tr>
                                    </thead>
                                      <tbody>
                                          <tr>
                                              <td colspan="5" class="text-center py-4 text-muted">
                                              </td>
                                          </tr>
                                          <tr>
                                              <td colspan="5" class="text-center py-4 text-muted">
                                                  No data available
                                              </td>
                                          </tr>
                                          <tr>
                                              <td colspan="5" class="text-center py-4 text-muted">
                                              </td>
                                          </tr>
                                      </tbody>
                                </table>
                            </div>

                            <div class="hide-div">
                                <table 
                                    id="table_heroTable" 
                                    class="table table-bordered" 
                                    style="min-height: 100px !important; width: 100% !important;"
                                >
                                    <thead>
                                        <tr>
                                            <th 
                                                colspan="2"
                                                style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                                class="tbl-title-header"
                                            >HERO SKU'S</th>
                                        </tr>
                                        <tr>
                                            <th class="tbl-title-field">SKU</th>
                                            <th class="tbl-title-field">LMI/RGDI Code</th>
                                        </tr>
                                    </thead>
                                      <tbody>
                                          <tr>
                                              <td colspan="2" class="text-center py-4 text-muted">
                                              </td>
                                          </tr>
                                          <tr>
                                              <td colspan="2" class="text-center py-4 text-muted">
                                                  No data available
                                              </td>
                                          </tr>
                                          <tr>
                                              <td colspan="2" class="text-center py-4 text-muted">
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
    var base_url = "<?= base_url(); ?>";
    let brand_ambassadors = <?= json_encode($brand_ambassador) ?>;
    let store_branch = <?= json_encode($store_branch) ?>;

    $(document).ready(function() {
        $('#ItemClass').select2({ placeholder: 'Select Item Class' });
        $('#inventoryStatus').select2({ placeholder: 'Select inventory statuses' });
        fetchDataTable();
        $(document).on('click', '#clearButton', function () {
            $('input[type="text"], input[type="number"], input[type="date"]').val('');
            $('input[type="checkbox"]').prop('checked', false);
            $('input[name="coveredASC"][value="ASC"]').prop('checked', true);
            $('input[name="coveredASC"][value="DESC"]').prop('checked', false);
            $('.btn-outline-primary').removeClass('active');
            $('.main_all').addClass('active');
            $('select').not('#year').prop('selectedIndex', 0);

            $('.select2').val(null).trigger('change');
            // $('table[id^="table_"]').each(function () {
            //     $(this).closest('.table-responsive').hide();
            // });
            //reset the year dd
            let highestYear = $("#year option:not(:first)").map(function () {
                return parseInt($(this).val());
            }).get().sort((a, b) => b - a)[0];

            if (highestYear) {
                $("#year").val(highestYear);
            }
            $('.hide-div').hide();
            $('.table-empty').show();
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
    });


    // $(document).on('click', '#refreshButton', function () {
    //     if($('#brand_ambassadors').val() == ""){
    //         $('#ba_id').val('');
    //     }
    //     if($('#store_branch').val() == ""){
    //         $('#store_id').val('');
    //     }
    //     fetchDataTable();
    // });

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
                fetchDataTable();
                $('.table-empty').hide();
                $('.hide-div').show();
            }
        });

    function fetchDataTable() {
        let selectedBa = $('#brand_ambassadors').val();
        let selectedStore = $('#store_branch').val();
        let selectedMonth = $('#month').val();
        let selectedYear = $('#year').val();
        let selectedSortField = $('#sortBy').val();
        let selectedSortOrder = $('input[name="coveredASC"]:checked').val();
        let selectedInventoryStatus = $('#inventoryStatus').val(); // returns an array
        if (!selectedInventoryStatus || selectedInventoryStatus.length === 0) return;
       // table-empty
        $('.table-empty').hide(); 
        $('.table-responsive').show();   
        let tables = [
            { id: "#slowMovingTable", type: "slowMoving" },
            { id: "#overstockTable", type: "overStock" },
            { id: "#npdTable", type: "npd" },
            { id: "#heroTable", type: "hero" }
        ];

        tables.forEach(table => {
            initializeTable(table.id, table.type, selectedBa, selectedStore, selectedMonth, selectedYear, selectedSortField, selectedSortOrder);
        });
    }

    function initializeTable(tableId, type, selectedBa, selectedStore, selectedMonth, selectedYear, selectedSortField, selectedSortOrder) {

        $(tableId).DataTable({
            destroy: true,
            ajax: {
                url: base_url + 'stocks/get-data-week-all-store',
                type: 'POST',
                data: function (d) {
                    d.trade_type = type;
                    d.brand_ambassador = selectedBa === "" ? null : selectedBa;
                    d.store = selectedStore === "" ? null : selectedStore;
                    d.month = selectedMonth === "0" ? null : selectedMonth;
                    d.year = selectedYear === "0" ? null : selectedYear;
                    d.sort_field = selectedSortField === "" ? null : selectedSortField;
                    d.sort = selectedSortOrder === "ASC" ? null : selectedSortOrder;
                    d.limit = d.length;
                    d.offset = d.start;
                },
                dataSrc: function(json) {
                    return json.data.length ? json.data : [];
                }
            },
            columns: [
                { 
                    data: 'item_name',
                    render: function(data, type, row) {
                        return `<span title="${data}">${data}</span>`; // Tooltip enabled
                    }
                },
                type !== 'hero' ? { data: 'sum_total_qty' } : null,
                type !== 'hero' ? { data: 'week_1' } : null,
                type !== 'hero' ? { data: 'week_2' } : null,
                type !== 'hero' ? { data: 'week_3' } : null,
                type == 'hero' ? { 
                    data: 'trans_date',
                    render: function(data, type, row) {
                        return data ? 'week ' + data : ''; 
                    }
                } : null
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

</script>
