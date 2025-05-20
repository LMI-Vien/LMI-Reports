<?php
    $dir = dirname(__FILE__);
    $minify = new \App\Libraries\MinifyLib();

    echo $minify->css($dir . '/assets/custom.css', 'Store Custom CSS');
    echo $minify->js($dir . '/assets/function.js', 'App Functions JS');
?>

<?= view("site/store/perf-per-ba/sales_performance_per_ba_filter"); ?> 

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
                    <div class="form-group">
                        <button class="btn btn-secondary" id="toggleColumnsButton"><i class="fas fa-columns"></i> Toggle Columns</button>
                    </div>

                    <div class="sortable row text-center p-2" id="columnToggleContainer" class="mb-3" style="color: black;background-color: rgb(108 117 125);border-radius: 10px;margin: 10px;">
                        <strong class="col">Select Columns:</strong>
                    </div>
                    <div class="mb-3" style="overflow-x: auto; height: 450px; padding: 0px;">
                                <!-- added min-width so the table header would not get compressed using width : x% -->
                        <table id="overall_ba_sales_tbl" class="table table-bordered" style="min-width: 3000px;"> 
                            <thead>
                                <tr>
                                    <th colspan="14"
                                        style="font-weight: bold; font-family: 'Poppins', sans-serif; text-align: center;"
                                        class="tbl-title-header"
                                    >
                                        Store Sales Performance per Brand Ambassador
                                    </th>
                                </tr>                          
                                <tr>
                                    <th class="tbl-title-field">Rank</th>
                                    <th class="tbl-title-field">Area</th>
                                    <th class="tbl-title-field">Store Code / Store Name</th>
                                    <th class="tbl-title-field sort">Brand Ambassador</th>
                                    <th class="tbl-title-field sort">Deployed Date</th>
                                    <th class="tbl-title-field sort">Brand Handle</th>
                                    <th class="tbl-title-field sort">LY Scanned Data</th>
                                    <th class="tbl-title-field">Actual Sales Report</th>
                                    <th class="tbl-title-field">Target</th>
                                    <th class="tbl-title-field">% Achieved 
                                        <span class="tooltip-text">
                                            FORMULA:
                                            <br>
                                            Actual Sales Report / Target * 100 
                                        </span>
                                    </th>
                                    <th class="tbl-title-field sort">% Growth 
                                        <span class="tooltip-text">
                                            FORMULA:
                                            <br>
                                            Actual Sales Report / LY Scan Data * 100
                                        </span>
                                    </th>
                                    <th class="tbl-title-field">Balance To Target 
                                        <span class="tooltip-text">
                                            FORMULA:
                                            <br>
                                            Target - Actual Sales Report
                                        </span>
                                    </th>
                                    <th class="tbl-title-field">Possible Incentives</th>
                                    <th class="tbl-title-field">Target Per Remaining Days 
                                        <span class="tooltip-text">
                                            FORMULA:
                                            <br>
                                            Balance to Target / remaining days in a month
                                        </span>
                                    </th>

                                </tr>
                            </thead>
                                  <tbody>
                                      <tr>
                                          <td colspan="14" class="text-center py-4 text-muted">
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="14" class="text-center py-4 text-muted">
                                              No data available
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="14" class="text-center py-4 text-muted">
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

        $( ".sortable" ).sortable({
            revert: true
        });

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
                let data = JSON.parse(res);
                if(data.length > 0){
                    if(data[0].code){ 
                        $("#storeName").val(data.code+' - '+data.description);
                        $("#storeNameId").val(data.id);      
                    }             
                }
            })
        });

        autocomplete_field($("#storeName"), $("#storeNameId"), store_branch, "description", "id");

        $('#columnToggleContainer').toggle();
        $(document).on('click', '#toggleColumnsButton', function() {
            $('#columnToggleContainer').toggle();
        });
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
    });

    function fetchData() {
        let selectedArea = $('#areaId').val();
        let selectedAsc = $('#ascNameId').val();
        let selectedBaType = $('input[name="filterType"]:checked').val();
        let selectedBa = $('#brandAmbassadorId').val();
        let selectedStore = $('#storeNameId').val();
        let selectedBrands = $('#brands').val();   
        let selectedYear = $('#year').val();
        let selectedMonthStart = $('#month').val();
        let selectedMonthEnd = $('#monthTo').val();
        initializeTable(selectedArea, selectedAsc, selectedBaType, selectedBa, selectedStore, selectedBrands, selectedYear, selectedMonthStart, selectedMonthEnd);
    }

    function initializeTable(selectedArea = null, selectedAsc = null, selectedBaType = null, selectedBa = null, selectedStore = null, selectedBrands = null, selectedYear = null, selectedMonthStart = null, selectedMonthEnd = null) {

        if ($.fn.DataTable.isDataTable('#overall_ba_sales_tbl')) {
            let existingTable = $('#overall_ba_sales_tbl').DataTable();
            existingTable.clear().destroy();
        }

        let table = $('#overall_ba_sales_tbl').DataTable({
            paging: true,
            searching: false,
            ordering: true,
            info: true,
            lengthChange: false,
            colReorder: true, 
            ajax: {
                url: base_url + 'store/get-sales-performance-per-ba',
                type: 'POST',
                data: function(d) {
                    d.area = selectedArea === "" ? null : selectedArea;
                    d.asc = selectedAsc === "" ? null : selectedAsc;
                    d.baType = selectedBaType === "" ? null : selectedBaType;
                    d.ba = selectedBa === "" ? null : selectedBa;
                    d.store = selectedStore === "" ? null : selectedStore;
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
                { data: 'area_name' },
                { data: 'store_name' },
                { data: 'ba_name' },
                {
                    data: 'ba_deployment_date',
                    render: function(data, type, row) {
                        return formatDateToMMDDYYYY(data);
                    }
                },
                { data: 'brand_name' },
                { data: 'ly_scanned_data' },
                { data: 'actual_sales', render: formatTwoDecimals },
                { data: 'target_sales' },
                { data: 'percent_ach' },
                { data: 'growth' },
                { data: 'balance_to_target', render: formatTwoDecimals },
                { data: 'possible_incentives', render: formatTwoDecimals  },
                { data: 'target_per_remaining_days', render: formatNoDecimals }
            ].filter(Boolean),
            pagingType: "full_numbers",
            pageLength: 10,
            processing: true,
            serverSide: true,
            searching: false,
            lengthChange: false
        });
        addColumnToggle(table);
    }

    function formatDateToMMDDYYYY(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        if (isNaN(date)) return ''; // Handle invalid dates
        const month = ('0' + (date.getMonth() + 1)).slice(-2);
        const day = ('0' + date.getDate()).slice(-2);
        const year = date.getFullYear();
        return `${month}/${day}/${year}`;
    }

    function formatNoDecimals(data) {
        return data ? Number(data).toLocaleString('en-US', { maximumFractionDigits: 0 }) : '0';
    }

    function formatTwoDecimals(data) {
        return data ? Number(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : '0.00';
    }

    function formatFourDecimals(data) {
        return data ? Number(data).toLocaleString('en-US', { minimumFractionDigits: 4, maximumFractionDigits: 4 }) : '0.0000';
    }

    function formattedDate(data) {
        if (!data) return ''; 

        let date = new Date(data);
        let options = { month: 'short', day: '2-digit', year: 'numeric' };
        return date.toLocaleDateString('en-US', options).replace(',', '');
    }

    function addColumnToggle(table) {
        $('.mx-2').remove();
        table.columns().every(function(index) {
            let column = this;
            let columnHeader = $(column.header());
            if (columnHeader.hasClass('sort')) {
                let columnTitle = columnHeader.text();

                let checkbox = $('<input>', {
                    type: 'checkbox',
                    checked: true,
                    change: function() {
                        column.visible($(this).prop('checked'));
                    }
                });
                $('#columnToggleContainer').append(
                    $('<label class="mx-2 col">').append(checkbox, " " + columnTitle)
                );
            }
        });
    }

    const start_time = new Date();  
    function handleAction(action) {
        modal.loading(true);

        let selectedArea = $('#areaId').val();
        let selectedAsc = $('#ascNameId').val();
        let selectedBaType = $('input[name="filterType"]:checked').val();
        let selectedBa = $('#brandAmbassadorId').val();
        let selectedStore = $('#storeNameId').val();
        let selectedBrands = $('#brands').val();   
        let selectedYear = $('#year').val();
        let selectedMonthStart = $('#month').val();
        let selectedMonthEnd = $('#monthTo').val();

        let qs = [
            'area='             + encodeURIComponent(selectedArea),
            'asc='              + encodeURIComponent(selectedAsc),
            'baType='           + encodeURIComponent(selectedBaType),
            'ba='               + encodeURIComponent(selectedBa),
            'store='            + encodeURIComponent(selectedStore),
            'brands='           + encodeURIComponent(selectedBrands),
            'year='             + encodeURIComponent(selectedYear),
            'month_start='      + encodeURIComponent(selectedMonthStart),
            'month_end='        + encodeURIComponent(selectedMonthEnd),
            'limit='            + encodeURIComponent(99999),
            'offset='           + encodeURIComponent(0),
        ].join('&');

        let endpoint = action === 'export_pdf' ? 'per-ba-generate-pdf' : 'per-ba-generate-excel-ba';

        let url = `${base_url}store/${endpoint}?${qs}`;

        const end_time = new Date();
        const duration = formatDuration(start_time, end_time);

        const remarks = `
            Exported Successfully!
            <br>Start Time: ${formatReadableDate(start_time)}
            <br>End Time: ${formatReadableDate(end_time)}
            <br>Duration: ${duration}
        `;
        logActivity('Store Sales Performance per Brand Ambassador', action === 'export_pdf' ? 'Export PDF' : 'Export Excel', remarks, '-', null, null);

        let iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        iframe.src = url;
        document.body.appendChild(iframe);

        setTimeout(function() {
            modal.loading(false);
        }, 500);
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
