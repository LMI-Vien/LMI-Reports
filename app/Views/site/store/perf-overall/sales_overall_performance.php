<?php
    $dir = dirname(__FILE__);
    $minify = new \App\Libraries\MinifyLib();

    echo $minify->css($dir . '/assets/custom.css', 'Store Custom CSS');
    echo $minify->js($dir . '/assets/function.js', 'App Functions JS');
?>

<?= view("site/store/perf-overall/sales_overall_performance_filter"); ?> 

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
                <div class="card p-4 shadow-lg text-center text-muted table-empty">
                  <i class="fas fa-filter mr-2"></i> Please select a filter
                </div>

                <div class="card mt-4 p-4 shadow-sm hide-div">
                    <div class="mb-3" style="overflow-x: auto; height: 450px; padding: 0px;">
                        <table id="top_performing_stores" class="table table-bordered" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    <th 
                                        colspan="6"
                                        style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                        class="tbl-title-header"
                                    >
                                        OVERALL STORES SALES PERFORMANCE
                                    </th>
                                </tr>
                                <tr>
                                    <th class="tbl-title-field">Rank</th>
                                    <th class="tbl-title-field">Store Code / Store Name</th>
                                    <th class="tbl-title-field">LY Sell Out</th>
                                    <th class="tbl-title-field">TY Sell Out</th>
                                    <th class="tbl-title-field">% Growth</th>
                                    <th class="tbl-title-field">Share of Business</th>
                                </tr>
                            </thead>
                              <tbody>
                                  <tr>
                                      <td colspan="6" class="text-center py-4 text-muted">
                                      </td>
                                  </tr>
                                  <tr>
                                      <td colspan="6" class="text-center py-4 text-muted">
                                          No data available
                                      </td>
                                  </tr>
                                  <tr>
                                      <td colspan="6" class="text-center py-4 text-muted">
                                      </td>
                                  </tr>
                              </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
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

<script>
    let brand_ambassadors = <?= json_encode($brand_ambassadors) ?>;
    let store_branch = <?= json_encode($store_branches) ?>;
    let brands = <?= json_encode($brands) ?>;
    let area = <?= json_encode($areas) ?>;
    let asc = <?= json_encode($asc) ?>;
    let brandLabel = <?= json_encode($brandLabel); ?>;
    let year = <?= json_encode($year); ?>;
    let months = <?= json_encode($months); ?>;
    brand_ambassadors.unshift(
        { id: "-6", name: "Non Ba" },
        { id: "-5", name: "Vacant" }
    )

    $(document).ready(function() {
        let highestYear = $("#year option:not(:first)").map(function () {
            return parseInt($(this).val());
        }).get().sort((a, b) => b - a)[0];

        if (highestYear) {
            $("#year").val(highestYear);
        }
        $('#itemLabel').select2({ placeholder: 'Select Brand Label Types' });
        $('#brands').select2({ placeholder: 'Select Brands' });
        autocomplete_field($("#area"), $("#areaId"), area, "description", "id", function(result) {
            //let url = url;
            let data = {
                event: "list",
                select: "a.id, a.description, asc.description as asc_description, asc.id as asc_id",
                query: "a.id = " + result.id,
                offset: offset,
                limit: 0,
                table: "tbl_area a",
                join: [
                    {
                        table: "tbl_area_sales_coordinator asc",
                        query: "a.id = asc.area_id",
                        type: "left"
                    }
                ]
            }

            aJax.post(url, data, function(result) {
                let data = JSON.parse(result);
                $("#ascName").val(data[0].asc_description);
                $("#ascNameId").val(data[0].asc_id);
            })
        });

        autocomplete_field($("#ascName"), $("#ascNameId"), asc, "description");

        autocomplete_field($("#brandAmbassador"), $("#brandAmbassadorId"), brand_ambassadors, "name", "id", function(result) {
            let data = {
                event: "list",
                select: "s.id, s.code, s.description",
                query: "sg.brand_ambassador_id = " + result.id,
                table: "tbl_brand_ambassador_group sg",
                join: [
                    {
                        table: "tbl_store s",
                        query: "s.id = sg.store_id",
                        type: "left"
                    }
                ]
            }

            aJax.post(base_url + "cms/global_controller", data, function(res) {
                let data = JSON.parse(res)[0];
                if(data){
                    $("#storeName").val(data.description);
                    $("#storeNameId").val(data.code);
                }
            })
        });

        autocomplete_field($("#storeName"), $("#storeNameId"), store_branch, "description", "id");
    });

    $('#itemLabel').on('change', function () {
        let selectedValues = $(this).val(); 
        $('#brands').empty();

        if (selectedValues && selectedValues.length > 0) {
            let inQuery = selectedValues.map(id => `'${id}'`).join(',');

            let data = {
                event: "list",
                select: "b.id, b.brand_description",
                query: "b.category_id IN (" + inQuery + ")",
                table: "tbl_brand b"
            };

            aJax.post(base_url + "cms/global_controller", data, function (res) {
                let result = JSON.parse(res);

                if (result && result.length > 0) {
                    result.forEach(function (item) {
                        let newOption = new Option(item.brand_description, item.id, true, true);
                        $('#brands').append(newOption);
                    });
                    $('#brands').trigger('change');
                } else {
                    $('#brands').trigger('change');
                }
            });
        } else {
            $('#brands').trigger('change');
        }
    });

    $(document).on('click', '#refreshButton', function () {
        const fields = [
            { input: '#area', target: '#areaId' },
            { input: '#ascName', target: '#ascNameId' },
            { input: '#brandAmbassador', target: '#brandAmbassadorId' },
            { input: '#storeName', target: '#storeNameId' },
            { input: '#year', target: '#year' }
        ];

        let counter = 0;

        fields.forEach(({ input, target }) => {
            const val = $(input).val();
            const hasValue = Array.isArray(val) ? val.length > 0 : val;
            if (!hasValue || val === undefined) {
                $(target).val('');
            } else {
                counter++;
            }
        });

        const monthFrom = $('#month').val();
        const monthTo = $('#monthTo').val();

        if (!monthFrom || !monthTo) {
            modal.alert('Please select both "Month From" and "Month To" before filtering.', "warning");
            return;
        }

        if (counter >= 1) {
            fetchData();
            $('.table-empty').hide();
            $('.hide-div').show();
        }
    });  

    $(document).on('click', '#clearButton', function () {
        $('input[type="text"], input[type="number"]').val('');
        $('.btn-outline-light').removeClass('active');
        $('.main_all').addClass('active');
        $('select').val('').trigger('change');

        let highestYear = $("#year option:not(:first)").map(function () {
            return parseInt($(this).val());
        }).get().sort((a, b) => b - a)[0];

        if (highestYear) {
            $("#year").val(highestYear).trigger('change');
        }

        $('.table-empty').show();
        $('.hide-div').hide();
        $('.data-graph').hide();
    });

    function fetchData() {
        let selectedArea = $('#areaId').val();
        let selectedAsc = $('#ascNameId').val();
        let selectedBaType = $('input[name="filterType"]:checked').val();
        let selectedBa = $('#brandAmbassadorId').val();
        let selectedStore = $('#storeNameId').val();
        let selectedBrandCategories = $('#itemLabel').val();
        let selectedBrands = $('#brands').val();   
        let selectedYear = $('#year').val();
        let selectedMonthStart = $('#month').val();
        let selectedMonthEnd = $('#monthTo').val();

        if ($.fn.DataTable.isDataTable('#top_performing_stores')) {
            let existingTable = $('#top_performing_stores').DataTable();
            existingTable.clear().destroy();
        }

        let table = $('#top_performing_stores').DataTable({
            paging: true,
            searching: false,
            ordering: true,
            info: true,
            lengthChange: false,
            colReorder: true, 
            ajax: {
                url: base_url + 'store/get-sales-overall-performance',
                type: 'POST',
                data: function(d) {
                    d.area = selectedArea === "" ? null : selectedArea;
                    d.asc = selectedAsc === "" ? null : selectedAsc;
                    d.baType = selectedBaType === "" ? null : selectedBaType;
                    d.ba = selectedBa === "" ? null : selectedBa;
                    d.store = selectedStore === "" ? null : selectedStore;
                    d.brandCategories = selectedBrandCategories === [] ? null : selectedBrandCategories;
                    d.brands = selectedBrands === [] ? null : selectedBrands;
                    d.year = selectedYear === "0" ? null : selectedYear;
                    d.month_start = selectedMonthStart === "0" ? null : selectedMonthStart;
                    d.month_end = selectedMonthEnd === "0" ? null : selectedMonthEnd;
                    d.limit = d.length;
                    d.offset = d.start;
                },
                dataSrc: function(json) {
                    return json.data.length ? json.data : [];
                }
            },
            columns: [
                { data: 'rank' },
                { data: 'store_name' },
                { data: 'ly_scanned_data' },
                { data: 'ty_scanned_data' },
                { data: 'growth' },
                { data: 'sob' }
            ].filter(Boolean),
            pagingType: "full_numbers",
            pageLength: 10,
            processing: true,
            serverSide: true,
            searching: false,
            lengthChange: false
        });
    }

    $("#month").on("change", function() {
        let selected = $("#monthTo").val();
        let start = $("#month").val();
        let html = "<option value=''>Please select..</option>";

        months.forEach(month => {
            if (parseInt(month.id) >= start) {
                html += `<option value="${month.id}">${month.month}</option>`;
            }
        });

        $("#monthTo").html(html);
    });

    $("#monthTo").on("change", function() {
        let selected = $("#month").val();
        let end = $("#monthTo").val();
        let html = "<option value=''>Please select..</option>";

        months.forEach(month => {
            if (parseInt(month.id) < end) {
                html += `<option value="${month.id}">${month.month}</option>`;
            }
        });
        $('#sourceDate').text($("#year option:selected").text() + " - " + $("#month option:selected").text() + " to " + $("#monthTo option:selected").text());
    });

</script>