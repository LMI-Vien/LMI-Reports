<?php
    $dir = dirname(__FILE__);
    $minify = new \App\Libraries\MinifyLib();

    echo $minify->css($dir . '/assets/custom.css', 'Store Custom CSS');
    echo $minify->js($dir . '/assets/function.js', 'App Functions JS');
?>

<?= view("site/stocks/week-all-store/data_week_all_store_filter"); ?> 

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
                            <strong>Source:</strong> <?= !empty($source) ? $source : 'N/A'; ?>

                        </div>
                    </div>
                <?php endif; ?>
                <div class="row mt-4">
                    <div class="col-md-12">
                      <div class="card p-4 shadow-lg text-center text-muted table-empty">
                          <i class="fas fa-filter mr-2"></i> Please select a filter
                      </div>
                        <div class="hide-div">
                        <div class="hide-div card">
                            <table id="table_slowMoving" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="3"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                            id="table_slowMoving_TH"
                                        >
                                            SLOW MOVING SKU'S
                                        </th>
                                    </tr>
                                     <tr id="table_slowMoving_headers">
                                        <th class="tbl-title-field">SKU Code</th>
                                        <th class="tbl-title-field">SKU Description</th>
                                        <th class="tbl-title-field">LMI/RGDI Code</th>
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

                        <div class="hide-div card">
                            <table id="table_overStock" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="3"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                            id="table_overStock_TH"
                                        >
                                            OVERSTOCK SKU'S
                                        </th>
                                    </tr>
                                    <tr id="table_overStock_headers">
                                        <th class="tbl-title-field">SKU Code</th>
                                        <th class="tbl-title-field">SKU Description</th>
                                        <th class="tbl-title-field">LMI/RGDI Code</th>
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

                        <div class="hide-div card">
                            <table id="table_npd" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="3"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                            id="table_npd_TH"
                                        >
                                            NPD SKU'S
                                        </th>
                                    </tr>
                                    <tr id="table_npd_headers">
                                        <th class="tbl-title-field">SKU Code</th>
                                        <th class="tbl-title-field">SKU Description</th>
                                        <th class="tbl-title-field">LMI/RGDI Code</th>
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

                        <div class="hide-div card">
                            <table id="table_hero" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="3"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                        >
                                            HERO SKU'S
                                        </th>
                                    </tr>
                                    <tr id="table_hero_headers">
                                        <th class="tbl-title-field">SKU Code</th>
                                        <th class="tbl-title-field">SKU Description</th>
                                        <th class="tbl-title-field">LMI/RGDI Code</th>
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
                        <div class="d-flex justify-content-end mt-3" id="step7">
                            <button 
                                class="btn btn-primary mr-2" 
                                id="ExportPDF"
                                onclick="handleAction('export_pdf')"
                            >
                                <i class="fas fa-file-export"></i> PDF
                            </button>
                            <button 
                                class="btn btn-success" 
                                id="exportButton"
                                onclick="handleAction('export_excel')"
                            >
                                <i class="fas fa-file-export"></i> Excel
                            </button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>

<script>
    let brandLabel = <?= json_encode($brandLabel); ?>;
    let itemClassi = <?= json_encode($itemClassi); ?>;

    $(document).ready(function() {
        let highestYear = $("#year option:not(:first)").map(function () {
            return parseInt($(this).val());
        }).get().sort((a, b) => b - a)[0];

        if (highestYear) {
            $("#year").val(highestYear);
        }
        itemClassi.forEach(function (item) {
          $('#itemClass').append(
            $('<option>', {
              value: item.item_class_code,
              text: item.item_class_description
            })
          );
        });

        $('#itemClass').select2({ placeholder: 'Please Select...' });
        autocomplete_field($("#itemLabelCat"), $("#itemLabelCatId"), brandLabel, "label");
        $('#inventoryStatus').select2({ placeholder: 'Please Select...' });
    });


    $(document).on('click', '#clearButton', function () {
        $('input[type="text"], input[type="number"], input[type="date"]').val('');
        $('input[type="checkbox"]').prop('checked', false);
        $('select').not('#year').prop('selectedIndex', 0);

        $('.select2').val(null).trigger('change');
        let highestYear = $("#year option:not(:first)").map(function () {
            return parseInt($(this).val());
        }).get().sort((a, b) => b - a)[0];

        if (highestYear) {
            $("#year").val(highestYear);
        }
        $('.hide-div').hide();
        $('.table-empty').show();
    });


    $(document).on('click', '#refreshButton', function () {
        const fields = [
            { input: '#ItemClass', target: '#ItemClass' },
            { input: '#inventoryStatus', target: '#inventoryStatus' }
        ];

        let counter = 0;

        fields.forEach(({ input, target }) => {
            const val = $(input).val();
            const hasValue = Array.isArray(val) ? val.length > 0 : val;
            if (!hasValue || val === undefined) {
                $(target).val('');
            } else {
                counter++;
                if ($(input).is('select') && !$(input).hasClass("select2-hidden-accessible")) {
                    $(input).select2();
                }
            }
        });

        const yearFilter = $('#year').val();
        const weekFromFilter = $('#week_from').val();
        const weekToFilter = $('#week_to').val();
        const invStatusFilter = $('#inventoryStatus').val();
        const dataSource = $('#dataSource').val();

        if (!yearFilter && !weekFromFilter && !weekToFilter && invStatusFilter.length === 0) {
            modal.alert('Please select both "Year", "Week Range" and Inventory Status" before filtering.', "warning");
            return;
        }

        if (!yearFilter || yearFilter.length === 0) {
            modal.alert('Please select "Year" before filtering.', "warning");
            return;
        }

        if (!weekFromFilter || weekFromFilter.length === 0) {
            modal.alert('Please select "Week From" before filtering.', "warning");
            return;
        }

        if (!weekToFilter || weekToFilter.length === 0) {
            modal.alert('Please select "Week To" before filtering.', "warning");
            return;
        }

        if (!invStatusFilter || invStatusFilter.length === 0) {
            modal.alert('Please select "Inventory Status" before filtering.', "warning");
            return;
        }

        const dataSourceText = $('#dataSource').find('option:selected').text();
        const yearFilterText = $('#year').find('option:selected').text();
        $('#sourceDate').text(dataSourceText+' - '+yearFilterText+' week: '+weekFromFilter+' - '+weekToFilter);
        if (counter >= 1) {
            fetchData();
            $('.table-empty').hide();
        }
    });

    function fetchData() {
        let selectedItemClass = $('#itemClass').val();
        let selectedItemCat = $('#itemLabelCat').val();
        let selectedInventoryStatus = $('#inventoryStatus').val();
        let selectedYear = $('#year').val();
        let selectedWeekFrom = $('#week_from').val();
        let selectedWeekTo = $('#week_to').val();
        let selectedSource = $('#dataSource').val();

        if (!selectedInventoryStatus || selectedInventoryStatus.length === 0) {
            $('.table-empty').show();
            $('.hide-div.card').hide();
            return;
        }

        $('.table-empty').hide();

        $('.hide-div').first().show();

        let tables = [
            { id: "#table_slowMoving", type: "slowMoving" },
            { id: "#table_overStock", type: "overStock" },
            { id: "#table_npd", type: "npd" },
            { id: "#table_hero", type: "hero" }
        ];
        $('.hide-div.card').hide();
        tables.forEach(table => {
            if (selectedInventoryStatus.includes(table.type)) {
                $(table.id).closest('.hide-div.card').show();
                initializeTable(
                    table.id,
                    table.type,
                    selectedItemClass,
                    selectedItemCat,
                    selectedYear,
                    selectedWeekFrom,
                    selectedWeekTo,
                    selectedSource
                );
            }
        });
    }

    function initializeTable(tableId, type, selectedItemClass, selectedItemCat, selectedYear, selectedWeekFrom, selectedWeekTo, selectedSource) {
         if ($.fn.DataTable.isDataTable($(tableId))) {
            let existingTable = $(tableId).DataTable();
            existingTable.clear().destroy();
        }
        const weekFrom = parseInt(selectedWeekFrom, 10);
        const weekTo = parseInt(selectedWeekTo, 10);
        // Reset week headers
        const $headerRow = $(`${tableId}_headers`);
        $headerRow.find("th.week-column").remove();

        const dynamicColumns = [];

        if (type !== 'hero') {
            colspan = (weekTo - weekFrom) + 4;
            $('#table_slowMoving_TH').attr('colspan', colspan);
            $('#table_overStock_TH').attr('colspan', colspan);
            $('#table_npd_TH').attr('colspan', colspan);

            if (!isNaN(weekFrom) && !isNaN(weekTo) && weekFrom <= weekTo) {
                for (let week = weekTo; week >= weekFrom; week--) {
                    $headerRow.append(`<th class="tbl-title-field week-column">Week ${week}</th>`);

                    dynamicColumns.push({
                        data: `week_${week}`,
                        title: `Week ${week}`,
                        defaultContent: '-',
                        render: data => data ?? '0'
                    });
                }
            }
        }

        const baseColumns = [
            { data: 'item', title: 'SKU Code' },
            { data: 'item_name', title: 'SKU Name' },
            { data: 'itmcde', title: 'LMI/RGDI Code' }
        ];

        $(tableId).DataTable({
            destroy: true,
            ajax: {
                url: base_url + 'stocks/get-data-week-all-store',
                type: 'POST',
                data: function (d) {
                    d.itemClass = selectedItemClass || null;
                    d.itemCategory = selectedItemCat || null;
                    d.year = selectedYear || null;
                    d.weekFrom = selectedWeekFrom || null;
                    d.weekTo = selectedWeekTo || null;
                    d.source = selectedSource || null;
                    d.type = type;
                    d.limit = d.length;
                    d.offset = d.start;
                },
                dataSrc: json => json.data.length ? json.data : []
            },
            columns: baseColumns.concat(dynamicColumns),
            order: type !== 'hero' && weekTo
                ? [[baseColumns.length, 'desc']]
                : [[1, 'desc']], 
            pagingType: "full_numbers",
            pageLength: 10,
            processing: true,
            serverSide: true,
            searching: false,
            colReorder: true,
            lengthChange: false,
            colReorder: true,
            dom: 'rt<"bottom"ip>', // remove automatic <thead> generation
        });
    }



    function handleAction(action) {

        if (action === 'export') {
            modal.alert("Not yet available");
        } else {
            modal.alert("Not yet available");
        }
    }

</script>
