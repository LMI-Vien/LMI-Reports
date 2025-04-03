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
                                <label for="brand_ambassadors">Brand Ambassador</label>
                            </div>
                            <div class="col-md">
                                <input type="text" class="form-control" id="brand_ambassadors" placeholder="Please select...">
                                <input type="hidden" id="ba_id">
                            </div>
                        </div>
                        <div class="col-md p-1 row">
                            <div class="col-md-3">
                                <label for="store_branch">Store Name</label>
                            </div>
                            <div class="col-md">
                                <input type="text" class="form-control" id="store_branch" placeholder="Please select...">
                                <input type="hidden" id="store_id">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 column p-2 text-left">
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
                                <label for="week">Year</label>
                            </div>
                            <div class="col-md">
                                <select class="form-control" id="year">
                                    <option value="0">Please select..</option>
                                    <?php
                                        if($year){
                                            $maxYear = max(array_column($year, 'year')); 
                                            foreach ($year as $value) {
                                                $selected = ($value['year'] == $maxYear) ? 'selected' : '';
                                                echo "<option value='{$value['id']}' {$selected}>{$value['year']}</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>   
                    </div>

                    <div class="col-md-3 column mt-1" style="border: 1px solid #dee2e6; border-radius: 12px;" >
                        <div class="col-md-12 mx-auto row py-2 text-left" >
                            <label for="ascName">Sort By</label>
                            <div class="col-md" >
                                <select class="form-control col mx-auto my-2" id="sortBy" style="width: 95%">
                                    <option value="item_name">SKU</option>
                                    <option value="sum_total_qty">SOH Qty</option>
                                    <option value="week_1">Qty (W1)</option>
                                    <option value="week_2">Qty (W2)</option>
                                    <option value="week_3">Qty (W3)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mx-auto row py-2 text-center" >
                            <div class="col-md-6 row" >
                                <input type="radio" name="coveredASC" value="ASC" class="col-md-2" checked><span class="col-md-10">Acsending</span>
                            </div>
                            <div class="col-md-6 row" >
                                <input type="radio" name="coveredASC" value="DESC" class="col-md-2"><span class="col-md-10">Descending</span>
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
                <div class="d-flex mt-3" style="overflow-x: auto; white-space: nowrap; gap: 10px;">
                    <div class="col-md-6">
                        <div class="card p-6 shadow-lg" >
                            <table id="slowMovingTable" class="table table-bordered" style="min-height: 100px !important; width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="5"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif;"
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
                                         <td colspan="5"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">No data available</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card p-6 shadow-lg">
                            <table id="overstockTable" class="table table-bordered" style="min-height: 100px !important; width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="5"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif;"
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
                                         <td colspan="5"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">No data available</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card p-6 shadow-lg">
                            <table id="npdTable" class="table table-bordered" style="min-height: 100px !important; width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="5"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif;"
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
                                         <td colspan="5"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">No data available</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card p-6 shadow-lg">
                            <table 
                                id="heroTable" 
                                class="table table-bordered" 
                                style="min-height: 100px !important; width: 100% !important;"
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
                                        <th class="tbl-title-field">SKU</th>
                                        <th class="tbl-title-field">Transition Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                         <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">No data available</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <!-- Buttons -->
                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-info mr-2" id="previewButton" onclick="handleAction('preview')"><i class="fas fa-eye"></i> Preview</button>
                    <button class="btn btn-success" id="exportButton" onclick="handleAction('export')"><i class="fas fa-file-export"></i> Export</button>
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

<!-- FileSaver -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<script>
    var base_url = "<?= base_url(); ?>";
    let brand_ambassadors = <?= json_encode($brand_ambassador) ?>;
    let store_branch = <?= json_encode($store_branch) ?>;

    $(document).ready(function() {
        fetchDataTable();
        $(document).on('click', '#clearButton', function () {
            $('input[type="text"], input[type="number"], input[type="date"]').val('');
            $('input[type="checkbox"]').prop('checked', false);
            $('input[name="coveredASC"][value="ASC"]').prop('checked', true);
            $('input[name="coveredASC"][value="DESC"]').prop('checked', false);
            $('.btn-outline-primary').removeClass('active');
            $('.main_all').addClass('active');
            $('select').not('#year').prop('selectedIndex', 0);
            //reset the year dd
            let highestYear = $("#year option:not(:first)").map(function () {
                return parseInt($(this).val());
            }).get().sort((a, b) => b - a)[0];

            if (highestYear) {
                $("#year").val(highestYear);
            }
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


    $(document).on('click', '#refreshButton', function () {
        if($('#brand_ambassadors').val() == ""){
            $('#ba_id').val('');
        }
        if($('#store_branch').val() == ""){
            $('#store_id').val('');
        }
        fetchDataTable();
    });

    function fetchDataTable() {
        let selectedBa = $('#brand_ambassadors').val();
        let selectedStore = $('#store_branch').val();
        let selectedMonth = $('#month').val();
        let selectedYear = $('#year').val();
        let selectedSortField = $('#sortBy').val();
        let selectedSortOrder = $('input[name="coveredASC"]:checked').val();

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
                url: base_url + 'trade-dashboard/trade-kam-two',
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

    // function fetchData() {
    //     let selectedBa = $('#brand_ambassadors').val();
    //     let selectedStore = $('#store_branch').val();
    //     let selectedMonth = $('#month').val();
    //     let selectedYear = $('#year').val();
    //     let selectedSortField = $('#sortBy').val();
    //     let selectedSortOrder = $('input[name="sortOrder"]:checked').val();

    //     let tables = [
    //         { id: "#slowMovingTable", type: "slowMoving" },
    //         { id: "#overstockTable", type: "overStock" },
    //         { id: "#npdTable", type: "npd" },
    //         { id: "#heroTable", type: "hero" }
    //     ];
    //     tables.forEach(table => {
    //         initializeTable(table.id, table.type, selectedType, selectedBa, selectedStore, selectedMonth, selectedYear, selectedSortField, selectedSortOrder);
    //     });
    // }

    // function initializeTable(tableId, type, selectedType, selectedBa, selectedStore, selectedMonth, selectedYear, selectedSortField, selectedSortOrder) {
    //     $(tableId).DataTable({
    //         destroy: true,
    //         ajax: {
    //             url: base_url + 'trade-dashboard/trade-ba',
    //             type: 'GET',
    //             data: function (d) {
    //                 d.sort_field = selectedSortField;
    //                 d.sort = selectedSortOrder;
    //                 d.month = selectedMonth === "" ? null : selectedMonth;
    //                 d.year = selectedYear === "" ? null : selectedYear;
    //                 d.brand_ambassador = selectedBa === "" ? null : selectedBa;
    //                 d.store_name = selectedStore === "" ? null : selectedStore;
    //                 d.ba_type = selectedType;
    //                 d.type = type;
    //                 d.limit = d.length;
    //                 d.offset = d.start;
    //             },
    //             dataSrc: function(json) {
    //                 return json.data.length ? json.data : [];
    //             }
    //         },
    //         columns: [
    //             { data: 'item_name' },
    //             type !== 'hero' ? { data: 'sum_total_qty' } : null
    //         ].filter(Boolean),
    //         pagingType: "full_numbers",
    //         pageLength: 10,
    //         processing: true,
    //         serverSide: true,
    //         searching: false,
    //         colReorder: true,
    //         lengthChange: false
    //     });
    // }



</script>
