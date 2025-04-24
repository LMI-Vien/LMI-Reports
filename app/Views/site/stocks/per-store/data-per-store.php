
<?= view("site/stocks/per-store/data-per-store-filter"); ?> 
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
                            <table id="table_slowMoving" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="3"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                        >
                                            SLOW MOVING SKU'S
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-title-field">LMI/RGDI Code</th>
                                        <th class="tbl-title-field">SKU Name</th>
                                        <th class="tbl-title-field">Quantity</th>
                                    </tr>
                                </thead>
                                  <tbody>
                                      <tr>
                                          <td colspan="3" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="3" class="text-center py-4 text-muted">
                                              No data available
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="3" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                  </tbody>
                            </table>
                        </div>

                        <div class="hide-div">
                            <table id="table_overStock" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="3"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                        >
                                            OVERSTOCK SKU'S
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-title-field">LMI/RGDI Code</th>
                                        <th class="tbl-title-field">SKU Name</th>
                                        <th class="tbl-title-field">Quantity</th>
                                    </tr>
                                </thead>
                                  <tbody>
                                      <tr>
                                          <td colspan="3" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="3" class="text-center py-4 text-muted">
                                              No data available
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="3" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                  </tbody>
                            </table>
                        </div>

                        <div class="hide-div">
                            <table id="table_npd" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="3"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                        >
                                            NPD SKU'S
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-title-field">LMI/RGDI Code</th>
                                        <th class="tbl-title-field">SKU Name</th>
                                        <th class="tbl-title-field">Quantity</th>
                                    </tr>
                                </thead>
                                  <tbody>
                                      <tr>
                                          <td colspan="3" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="3" class="text-center py-4 text-muted">
                                              No data available
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="3" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                  </tbody>
                            </table>
                        </div>

                        <div class="hide-div">
                            <table id="table_hero" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="2"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                        >
                                            HERO SKU'S
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-title-field">LMI/RGDI Code</th>
                                        <th class="tbl-title-field">SKU Name</th>
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
    let brands = <?= json_encode($brands) ?>;

    $(document).ready(function () {

       // fetchData();
        $('#inventoryStatus').select2({ placeholder: 'Select inventory statuses' });
        $(document).on('click', '#clearButton', function () {
            $('input[type="text"], input[type="number"], input[type="date"]').val('');
            $('input[type="checkbox"]').prop('checked', false);
            $('input[name="sortOrder"][value="ASC"]').prop('checked', true);
            $('input[name="sortOrder"][value="DESC"]').prop('checked', false);
            $('.btn-outline-primary').removeClass('active');
            $('.main_all').addClass('active');
            $('select').prop('selectedIndex', 0);
            $('.select2').val(null).trigger('change');
            // $('table[id^="table_"]').each(function () {
            //     $(this).closest('.table-responsive').hide();
            // });
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
        // if($('#brand_ambassadors').val() == ""){
        //     $('#ba_id').val('');
        // }
        // if($('#store_branch').val() == ""){
        //     $('#store_id').val('');
        // }
        // if($('#brand').val() == ""){
        //     $('#brand_id').val('');
        // }
        // let selectedBa = $('#ba_id').val();

            const fields = [
                { input: '#brandAmbassador', target: '#ba_id' },
                { input: '#area', target: '#area_id' },
                { input: '#brand', target: '#brand_id' },
                { input: '#store', target: '#store_id' },
                { input: '#item_classi', target: '#item_classi_id' },
                { input: '#qtyscp', target: '#qtyscp' }
            ];

            let counter = 0;

            fields.forEach(({ input, target }) => {
                const val = $(input).val();
                if (val === "" || val === undefined) {
                    $(target).val('');
                } else {
                    if ($(input).is('select')) {
                        $(input).select2();
                    }
                    counter++;
                }
            });
            if (counter >= 1) {
                fetchData();
                $('.table-empty').hide();
                $('.hide-div').show();
            }
        //fetchData();
    });

    function fetchData() {
        let selectedType = $('input[name="filterType"]:checked').val();
        let selectedBa = $('#brand_ambassadors').val();
        let selectedStore = $('#store_branch').val();
        let selectedBrand = $('#brand').val();
        let selectedSortField = $('#sortBy').val();
        let selectedSortOrder = $('input[name="sortOrder"]:checked').val();
        let selectedInventoryStatus = $('#inventoryStatus').val(); // returns an array
        if (!selectedInventoryStatus || selectedInventoryStatus.length === 0) return;
       // table-empty
        $('.table-empty').hide(); 
        let tables = [
            { id: "#table_slowMoving", type: "slowMoving" },
            { id: "#table_overStock", type: "overStock" },
            { id: "#table_npd", type: "npd" },
            { id: "#table_hero", type: "hero" }
        ];

        let filteredTables = tables.filter(table => selectedInventoryStatus.includes(table.type));
        filteredTables.forEach(table => {
            initializeTable(table.id, table.type, selectedType, selectedBa, selectedStore, selectedBrand, selectedSortField, selectedSortOrder);
        });
    }

    function initializeTable(tableId, type, selectedType, selectedBa, selectedStore, selectedBrand, selectedSortField, selectedSortOrder) {
        $(tableId).closest('.table-responsive').show(); 
        $(tableId).DataTable({
            destroy: true,
            ajax: {
                url: base_url + 'stocks/get-data-per-store',
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
        if(type){
          let url = base_url + 'stocks/per-store-generate-pdf-' + (action === 'export_pdf' ? 'pdf' : 'excel') + '-ba?'
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

    }

</script>
