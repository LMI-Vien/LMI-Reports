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
                                        colspan="7"
                                        style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                        class="tbl-title-header"
                                    >
                                        OVERALL STORES SALES PERFORMANCE
                                    </th>
                                </tr>
                                <tr>
                                    <th class="tbl-title-field">Rank</th>
                                    <th class="tbl-title-field">Store Code / Store Name</th>
                                    <th class="tbl-title-field">Location Description</th>
                                    <th class="tbl-title-field">LY Sell Out</th>
                                    <th class="tbl-title-field">TY Sell Out</th>
                                    <th class="tbl-title-field">% Growth</th>
                                    <th class="tbl-title-field">Share of Business</th>
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
                    <div class="d-flex justify-content-end mt-3">
                        <button 
                            class="btn btn-primary mr-2" 
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
        </div>
    </div>
</div>

<script>
    let months = <?= json_encode($month); ?>;

    $(document).ready(function() {
        //fetchData();

    });

    $(document).on('click', '#refreshButton', function () {
        const fields = [
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
            }
        });
        if (counter >= 1) {
            fetchData();
            $('.table-empty').hide();
            $('.hide-div').show();
        }
    });  

        $(document).on('click', '#clearButton', function () {
            $('input[type="text"], input[type="number"]').val('');
            $('select').not('#year').prop('selectedIndex', 0);
            //reset the year dd
            let highestYear = $("#year option:not(:first)").map(function () {
                return parseInt($(this).val());
            }).get().sort((a, b) => b - a)[0];

            if (highestYear) {
                $("#year").val(highestYear);
            }
            $('.table-empty').show();
            $('.hide-div').hide();
            $('.data-graph').hide();
            $("#refreshButton").click();
        });

    function fetchData() {
        let selectedMonthStart = $('#month_start').val();
        let selectedMonthEnd = $('#month_end').val();
        let selectedYear = $('#year').val();
        initializeTable(selectedMonthStart, selectedMonthEnd, selectedYear);
    }

    function initializeTable(selectedMonthStart = null, selectedMonthEnd = null, selectedYear = null) {
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
                { data: 'store_code' },
                { data: 'store_name' },
                { data: 'ly_scanned_data' },
                { data: 'ty_scanned_data' },
                { data: 'sell_through' },
                { data: 'contribution' }
            ].filter(Boolean),
            pagingType: "full_numbers",
            pageLength: 10,
            processing: true,
            serverSide: true,
            searching: false,
            lengthChange: false
        });
    }

    $("#month_start").on("change", function() {
        let selected = $("#month_end").val();
        let start = $("#month_start").val();
        let html = "<option value=''>Please select..</option>";

        months.forEach(month => {
            if (parseInt(month.id) >= start) {
                html += `<option value="${month.id}">${month.month}</option>`;
            }
        });

        $("#month_end").html(html);
    });

    $("#month_end").on("change", function() {
        let selected = $("#month_start").val();
        let end = $("#month_end").val();
        let html = "<option value=''>Please select..</option>";

        months.forEach(month => {
            if (parseInt(month.id) < end) {
                html += `<option value="${month.id}">${month.month}</option>`;
            }
        });

       // $("#month_start").html(html);
    });

</script>