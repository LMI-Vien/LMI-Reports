<?php
    $dir = dirname(__FILE__);
    $minify = new \App\Libraries\MinifyLib();

    echo $minify->css($dir . '/assets/custom.css', 'Store Custom CSS');
    echo $minify->js($dir . '/assets/function.js', 'App Functions JS');
?>

<?= view("site/store/perf-per-area/sales_performance_per_area_filter"); ?> 

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
                <div class="col-md-12">
                    <div class="card mt-4 p-4 shadow-sm hide-div">
                        <div class="mb-3" style="overflow-x: auto; height: 450px; padding: 0px;">
                            <table id="info_for_asc" class="table table-bordered table-responsive" style="width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th 
                                            colspan="10"
                                            style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                            class="tbl-title-header"
                                        >
                                            Store Sales Performance per Area
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="tbl-title-field">Rank</th>
                                        <th class="tbl-title-field">Area</th>
                                        <th class="tbl-title-field">Area Sales Coordinator</th>
                                        <th class="tbl-title-field">LY Scan Data</th>
                                        <th class="tbl-title-field">Actual Sales Report</th>
                                        <th class="tbl-title-field">Target</th>
                                        <th class="tbl-title-field">% Achieved</th>
                                        <th class="tbl-title-field">% Growth</th>
                                        <th class="tbl-title-field">Balance To Target</th>
                                        <th class="tbl-title-field">Target Per Remaining Days</th>

                                    </tr>
                                </thead>
                                      <tbody>
                                          <tr>
                                              <td colspan="10" class="text-center py-4 text-muted">
                                              </td>
                                          </tr>
                                          <tr>
                                              <td colspan="10" class="text-center py-4 text-muted">
                                                  No data available
                                              </td>
                                          </tr>
                                          <tr>
                                              <td colspan="10" class="text-center py-4 text-muted">
                                              </td>
                                          </tr>
                                      </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button 
                                class="btn btn-primary mr-2" 
                                id="ExportPDF"
                                onclick="handleAction('exportPdf')"
                            >
                                <i class="fas fa-file-export"></i> PDF
                            </button>
                            <button 
                                class="btn btn-success" 
                                id="exportButton"
                                onclick="handleAction('exportExcel')"
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

<script>
    var base_url = "<?= base_url(); ?>";
    let store_branch = <?= json_encode($store_branches) ?>;
    let brands = <?= json_encode($brands) ?>;
    let area = <?= json_encode($areas) ?>;
    let asc = <?= json_encode($asc) ?>;
    let year = <?= json_encode($year); ?>;
    let months = <?= json_encode($months); ?>;
    const start_time = new Date();  

    $(document).ready(function() {

        let highestYear = $("#year option:not(:first)").map(function () {
            return parseInt($(this).val());
        }).get().sort((a, b) => b - a)[0];

        if (highestYear) {
            $("#year").val(highestYear);
        }

        $('#brands').select2({ placeholder: 'Select Brands' });
        autocomplete_field($("#area"), $("#areaId"), area, "description", "id", function(result) {
            //let url = url;
            let data = {
                event: "list",
                select: "a.id, a.description, asc.description as asc_description, asc.id as asc_id, asc.code",
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
                if(data.length > 0){
                    if(data[0].code){ 
                        $("#ascName").val(data[0].code+' - '+data[0].asc_description);
                        $("#ascNameId").val(data[0].asc_id);       
                    }             
                }
            })
        });

        autocomplete_field($("#ascName"), $("#ascNameId"), asc, "description");
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
    });

    $(document).on('click', '#refreshButton', function () {
        const fields = [
            { input: '#year', target: '#year' },
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

    function fetchData() {

        let selectedArea = $('#areaId').val();
        let selectedAsc = $('#ascNameId').val();
        let selectedBaType = $('input[name="filterType"]:checked').val();
        let selectedBrands = $('#brands').val();   
        let selectedYear = $('#year').val();
        let selectedMonthStart = $('#month').val();
        let selectedMonthEnd = $('#monthTo').val();
        initializeTable(selectedArea, selectedAsc, selectedBaType, selectedBrands, selectedYear, selectedMonthStart, selectedMonthEnd);
    }

    function initializeTable(selectedArea = null, selectedAsc = null, selectedBaType = null, selectedBrands = null, selectedYear = null, selectedMonthStart = null, selectedMonthEnd = null) {
        
        if ($.fn.DataTable.isDataTable('#info_for_asc')) {
            let existingTable = $('#info_for_asc').DataTable();
            existingTable.clear().destroy();
        }

        let table = $('#info_for_asc').DataTable({
            paging: true,
            searching: false,
            ordering: true,
            info: true,
            lengthChange: false,
            colReorder: true, 
            ajax: {
                url: base_url + 'store/get-sales-performance-per-area',
                type: 'POST',
                data: function(d) {
                    d.area = selectedArea === "" ? null : selectedArea;
                    d.asc = selectedAsc === "" ? null : selectedAsc;
                    d.baType = selectedBaType === "" ? null : selectedBaType;
                    d.brands = selectedBrands === [] ? null : selectedBrands;
                    d.year = selectedYear === "0" ? null : selectedYear;
                    d.month_start = selectedMonthStart === "0" ? null : selectedMonthStart;
                    d.month_end = selectedMonthEnd === "0" ? null : selectedMonthEnd;
                    d.limit = d.length;
                    d.offset = d.start;
                    console.log('Filter :', d);
                },
                dataSrc: function(json) {
                    console.log('Server responded with:', json);
                    return json.data.length ? json.data : [];
                }
            },
            columns: [
                { data: 'rank' },
                { data: 'area_name' },
                { data: 'asc_name' },
                { data: 'ly_scanned_data', render: formatTwoDecimals },
                { data: 'actual_sales', render: formatTwoDecimals },
                { data: 'target_sales' },
                { data: 'percent_ach' },
                { data: 'growth' },
                { data: 'balance_to_target', render: formatTwoDecimals },
                { data: 'target_per_remaining_days', render: formatNoDecimals }
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

    function formatNoDecimals(data) {
        return data ? Number(data).toLocaleString('en-US', { maximumFractionDigits: 0 }) : '0';
    }

    function formatTwoDecimals(data) {
        return data ? Number(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : '0.00';
    }

    function handleAction(action) {
        modal.loading(true);
        let selectedArea = $('#areaId').val();
        let selectedAsc = $('#ascNameId').val();
        let selectedBaType = $('input[name="filterType"]:checked').val();
        let selectedBrands = $('#brands').val();   
        let selectedYear = $('#year').val();
        let selectedMonthStart = $('#month').val();
        let selectedMonthEnd = $('#monthTo').val();

        let qs = [
            `area=`         + encodeURIComponent(selectedArea),
            `asc=`          + encodeURIComponent(selectedAsc),
            `baType=`       + encodeURIComponent(selectedBaType),
            `brands=`       + encodeURIComponent(selectedBrands),
            `year=`         + encodeURIComponent(selectedYear),
            `monthStart=`   + encodeURIComponent(selectedMonthStart),
            `monthEnd=`     + encodeURIComponent(selectedMonthEnd),
        ].join('&');

        let endpoint = action === 'exportPdf' ? 'per-area-generate-pdf' : 'per-area-generate-excel';

        let url = `${base_url}store/${endpoint}?${qs}`;

        const end_time = new Date();
        const duration = formatDuration(start_time, end_time);

        const remarks = `
            Exported Successfully!
            <br>Start Time: ${formatReadableDate(start_time)}
            <br>End Time: ${formatReadableDate(end_time)}
            <br>Duration: ${duration}
        `;
        logActivity('Store Sales Performance per Area', action === 'exportPdf' ? 'Export PDF' : 'Export Excel', remarks, '-', null, null);

        let iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        iframe.src = url;
        document.body.appendChild(iframe);

        setTimeout(function() {
            modal.loading(false);
        }, 5000);


    }

</script>
