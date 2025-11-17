    const start_time = new Date();
    let isGraphMode = false;
    let chartInstance = null;
    let currentPage = 1;
    const chartLimit = 10;
    let totalRecords = 0;
    var isExport = false;
    var type = 0;
    $(document).ready(function() {
        const $toggleBtn = $('#toggleAdditionalFilters');
        const $filterPanel = $('#additionalFiltersPanel');

        $toggleBtn.on('click', function () {
          const isOpen = $filterPanel.hasClass('open');

          if (isOpen) {
            $filterPanel.removeClass('open');
            $toggleBtn.html('<i class="fas fa-angle-double-right mr-1"></i> More Filters');
          } else {
            $filterPanel.addClass('open');
            $toggleBtn.html('<i class="fas fa-angle-double-left mr-1"></i> Hide Filters');
          }
        });

        $('#closeAdditionalFilters').on('click', function () {
          $filterPanel.removeClass('open');
          $toggleBtn.html('<i class="fas fa-angle-double-right mr-1"></i> More Filters');
        });
        const currentWeek = getCurrentWeek();
        if (currentWeek) {
            $('#currentWeek').text(currentWeek.display);
        } else {
            $('#currentWeek').text('N/A');
        }

        //$('#generationPeriod').text('N/A');

        const latestWeekAttr = $('#mostRecentImportWeekRange').data('latest-week');
        const latestWeek = latestWeekAttr ? parseInt(latestWeekAttr, 10) : null;
        if (latestWeek) {
            const wk = getImportWeekDisplay(latestWeek);
            $('#mostRecentImportWeekRange').text(
                wk ? `(${wk.start} - ${wk.end})` : 'N/A'
            );
        } else {
            $('#mostRecentImportWeekRange').text('N/A');
        }

        $('#brands').select2({
          placeholder: 'Select Brands',
          width: '100%',
          templateResult: function (data) {
            return data.text;
          },
          templateSelection: function (data) {
            if (!data.id) return data.text; 
            const text = data.text || '';
            return text.length > 10 ? text.substring(0, 10) + '…' : text;
          }
        });

        $('#itemLabel').select2({ placeholder: 'Select Select Label Type' });

        $('#itmCode').select2({
            placeholder: 'Select Item',
            minimumInputLength: 0, 
            ajax: {
                url: base_url + 'promo-analysis/search-sku',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { term: params.term || '' };
                },
                processResults: function (data) {
                    return { results: data.results || data };
                },
                cache: true
            },
            templateResult: function (data) {
                return data.text;
            },
            templateSelection: function (data) {
                if (!data.id) return data.text;
                const text = data.text || '';
                return text.length > 15 ? text.substring(0, 15) + '…' : text;
            }
        });

        $('#itmCode').on('select2:open', function () {
            const select = $(this);
            const select2 = select.data('select2');

            if (!select2.loadedOnce) {
                $.ajax({
                    url: base_url + 'promo-analysis/search-sku',
                    dataType: 'json',
                    data: { term: '' },
                    success: function (data) {
                        const results = data.results || data;
                        const firstItems = results.slice(0, 10);
                        select.empty();
                        firstItems.forEach(item => {
                            const option = new Option(item.text, item.id, false, false);
                            select.append(option);
                        });
                        select.trigger('change.select2');
                        select2.loadedOnce = true;
                    }
                });
            }
        });

        $('#storeName').select2({
            placeholder: 'Select Store',
            minimumInputLength: 0,
            ajax: {
                url: base_url + 'promo-analysis/search-store',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { term: params.term || '' };
                },
                processResults: function (data) {
                    return { results: data.results || data };
                },
                cache: true
            },
            templateResult: function (data) {
                return data.text;
            },
            templateSelection: function (data) {
                if (!data.id) return data.text;
                const text = data.text || '';
                return text.length > 15 ? text.substring(0, 15) + '…' : text;
            }
        });

        $('#storeName').on('select2:open', function () {
            const select = $(this);
            const select2 = select.data('select2');

            if (!select2.loadedOnce) {
                $.ajax({
                    url: base_url + 'promo-analysis/search-store',
                    dataType: 'json',
                    data: { term: '' },
                    success: function (data) {
                        const results = data.results || data;
                        const firstItems = results.slice(0, 10);
                        select.empty();
                        firstItems.forEach(item => {
                            const option = new Option(item.text, item.id, false, false);
                            select.append(option);
                        });
                        select.trigger('change.select2');
                        select2.loadedOnce = true;
                    }
                });
            }
        });

        $('#variantName').select2({
            placeholder: 'Please select...',
            allowClear: true,
            width: '100%',
            minimumInputLength: 0,
            ajax: {
                url: base_url + 'promo-analysis/search-variant',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { term: params.term || '' };
                },
                processResults: function (data) {
                    return { results: data.results || data };
                },
                cache: true
            },
            templateResult: function (data) {
                return data.text;
            },
            templateSelection: function (data) {
                if (!data.id) return data.text;
                const text = data.text || '';
                return text.length > 15 ? text.substring(0, 15) + '…' : text;
            }
        });

        $('#variantName').on('select2:open', function () {
            const select = $(this);
            const select2 = select.data('select2');

            if (!select2.loadedOnce) {
                $.ajax({
                    url: base_url + 'promo-analysis/search-variant',
                    dataType: 'json',
                    data: { term: '' },
                    success: function (data) {
                        const results = data.results || data;
                        const firstItems = results.slice(0, 10);
                        select.empty();
                        firstItems.forEach(item => {
                            const option = new Option(item.text, item.id, false, false);
                            select.append(option);
                        });
                        select.trigger('change.select2');
                        select2.loadedOnce = true;
                    }
                });
            }
        });

        $("#year").on("change", function () {
            const year = $(this).val();
            if(year){
                // $('#sourceDate').text(
                //     getTextOrDash("#year") + " " +
                //     getTextOrDash("#monthFrom") +
                //     " to " +
                //     getTextOrDash("#monthTo")
                // );
            }

            updateWeeks('weekfromPre', getCurrentWeek()); 
            updateWeeks('weektoPre', getCurrentWeek()); 
            updateWeeks('weekfromPost', getCurrentWeek()); 
            updateWeeks('weektoPost', getCurrentWeek()); 
        });

        $("#monthFromPre").on("change", function() {
            let selected = $("#monthToPre").val();
            let start = $("#monthFromPre").val();
            let html = "<option value=''>Please select...</option>";

            months.forEach(month => {
                if (parseInt(month.id) >= start) {
                    html += `<option value="${month.id}">${month.month}</option>`;
                }
            });

            $("#monthToPre").html(html);
            // $('#sourceDate').text(
            //     getTextOrDash("#year") + " " +
            //     getTextOrDash("#monthFromPre") +
            //     " to " +
            //     getTextOrDash("#monthTo")
            // );
        });

        $("#monthToPre").on("change", function() {
            let selected = $("#monthFromPre").val();
            let end = $("#monthToPre").val();
            let html = "<option value=''>Please select...</option>";

            months.forEach(month => {
                if (parseInt(month.id) < end) {
                    html += `<option value="${month.id}">${month.month}</option>`;
                }
            });

            //$('#sourceDate').text(
                // getTextOrDash("#year") + " " +
                // getTextOrDash("#monthFrom") +
                // " to " +
                // getTextOrDash("#monthTo")
           //);
        });

        $("#monthFromPost").on("change", function() {
            let selected = $("#monthToPost").val();
            let start = $("#monthFromPost").val();
            let html = "<option value=''>Please select...</option>";

            months.forEach(month => {
                if (parseInt(month.id) >= start) {
                    html += `<option value="${month.id}">${month.month}</option>`;
                }
            });

            $("#monthToPost").html(html);
            // $('#sourceDate').text(
            //     getTextOrDash("#year") + " " +
            //     getTextOrDash("#monthFromPre") +
            //     " to " +
            //     getTextOrDash("#monthTo")
            // );
        });

        $("#monthToPost").on("change", function() {
            let selected = $("#monthFromPost").val();
            let end = $("#monthToPost").val();
            let html = "<option value=''>Please select...</option>";

            months.forEach(month => {
                if (parseInt(month.id) < end) {
                    html += `<option value="${month.id}">${month.month}</option>`;
                }
            });

            //$('#sourceDate').text(
                // getTextOrDash("#year") + " " +
                // getTextOrDash("#monthFrom") +
                // " to " +
                // getTextOrDash("#monthTo")
           //);
        });

        function getTextOrDash(selector) {
            const text = $(`${selector} option:selected`).text();
            return text === "Please select..." || !text ? "-" : text;
        }

        function buildMonthDropdown(from = 1, to = 12) {
            let html = "<option value=''>Please select...</option>";
            months.forEach(month => {
                if (month.id >= from && month.id <= to) {
                    html += `<option value="${month.id}">${month.month}</option>`;
                }
            });
            return html;
        }

    });

    $(document).on('click', '#clearButton', function () {
        $('input[type="text"], input[type="number"]').val('');
        $('input[type="checkbox"]').prop('checked', false);
        $('select').prop('selectedIndex', 0);
        $('.select2').val(null).trigger('change');
        $('.btn-outline-light').removeClass('active');
        $('.main_all').addClass('active');
        $('#additionalFiltersPanel').removeClass('open');
        $('#toggleAdditionalFilters').html('<i class="fas fa-angle-double-right mr-1"></i> More Filters');
        $('#sourceDate').text(" N / A");
        $('.hide-div').hide();
        $('.table-empty').show();
    });

    $(document).on('click', '#refreshButton', function () {
        const fields = [
            { input: '#brands', target: '#brands' },
            { input: '#itemLabel', target: '#itemLabel' },
            { input: '#itmCode', target: '#itmCode' },
            { input: '#storeName', target: '#storeName' }
            
        ];

        let counter = 0;

        fields.forEach(({ input, target }) => {
            const val = $(input).val();
            if (val === "" || val === undefined) {
                $(target).val('');
            } else {
                if ($(input).is('select')) {
                    //$(input).select2();
                }
                counter++;
            }
        });

        const preWeekFromOption = $("#weekfromPre option:selected");
        const preStartDateFrom = preWeekFromOption.data("start-date");
        const preWeekToOption = $("#weektoPre option:selected");
        const preEndDateTo = preWeekToOption.data("end-date"); 
        const preWeekFromFilter = $('#weekfromPre').val();
        const preWeekToFilter = $('#weektoPre').val();

        const postWeekFromOption = $("#weekfromPost option:selected");
        const postStartDateFrom = postWeekFromOption.data("start-date");
        const postWeekToOption = $("#weektoPost option:selected");
        const postEndDateTo = postWeekToOption.data("end-date"); 
        const postWeekFromFilter = $('#weekfromPost').val();
        const postWeekToFilter = $('#weektoPost').val();

        const preMonthFromFilter = $('#monthFromPre').val();
        const preMonthToFilter = $('#monthToPre').val();
        const postMonthFromFilter = $('#monthFromPost').val();
        const postMonthToFilter = $('#monthToPost').val();

        const yearFilter = $('#year').val();

        const $toggleBtn = $('#toggleAdditionalFilters');
        const $filterPanel = $('#additionalFiltersPanel');

        const currentYear = new Date().getFullYear();
        if (parseInt(yearFilter) > currentYear) {
            modal.alert('You cannot select a future year.', "warning");
            $filterPanel.addClass('open');
            $toggleBtn.html('<i class="fas fa-angle-double-left mr-1"></i> Hide Filters');
            return;
        }

        if (!yearFilter) {
            modal.alert('Please select "Year" before filtering.', "warning");
            $filterPanel.addClass('open');
            $toggleBtn.html('<i class="fas fa-angle-double-left mr-1"></i> Hide Filters');
            return;
        }

        if (!preMonthFromFilter) {
            modal.alert('Please select Scanned Data PRE "Month From" before filtering.', "warning");
            $filterPanel.addClass('open');
            $toggleBtn.html('<i class="fas fa-angle-double-left mr-1"></i> Hide Filters');
            return;
        }

        if (!preMonthToFilter) {
            modal.alert('Please select Scanned Data PRE "Month To" before filtering.', "warning");
            $filterPanel.addClass('open');
            $toggleBtn.html('<i class="fas fa-angle-double-left mr-1"></i> Hide Filters');
            return;
        } 

        if (!postMonthFromFilter) {
            modal.alert('Please select Scanned Data POST "Month From" before filtering.', "warning");
            $filterPanel.addClass('open');
            $toggleBtn.html('<i class="fas fa-angle-double-left mr-1"></i> Hide Filters');
            return;
        }

        if (!postMonthToFilter) {
            modal.alert('Please select Scanned Data POST "Month To" before filtering.', "warning");
            $filterPanel.addClass('open');
            $toggleBtn.html('<i class="fas fa-angle-double-left mr-1"></i> Hide Filters');
            return;
        } 

        if (postMonthFromFilter < preMonthToFilter) {
            modal.alert('Must be greater than or equal to Scanned Data PRE Period!', "warning");
            $filterPanel.addClass('open');
            $toggleBtn.html('<i class="fas fa-angle-double-left mr-1"></i> Hide Filters');
            return;
        }

        if (!preWeekFromFilter) {
            modal.alert('Please select VMI PRE "Week From" before filtering.', "warning");
            $filterPanel.addClass('open');
            $toggleBtn.html('<i class="fas fa-angle-double-left mr-1"></i> Hide Filters');
            return;
        }

        if (!preWeekToFilter) {
            modal.alert('Please select VMI PRE "Week To" before filtering.', "warning");
            $filterPanel.addClass('open');
            $toggleBtn.html('<i class="fas fa-angle-double-left mr-1"></i> Hide Filters');
            return;
        } 

        if (!postWeekFromFilter) {
            modal.alert('Please select VMI POST "Week From" before filtering.', "warning");
            $filterPanel.addClass('open');
            $toggleBtn.html('<i class="fas fa-angle-double-left mr-1"></i> Hide Filters');
            return;
        }

        if (!postWeekToFilter) {
            modal.alert('Please select VMI POST "Week To" before filtering.', "warning");
            $filterPanel.addClass('open');
            $toggleBtn.html('<i class="fas fa-angle-double-left mr-1"></i> Hide Filters');
            return;
        }  

        if (parseInt(preWeekFromFilter) > parseInt(preWeekToFilter)) {
            modal.alert('Pre Week From must be less than or equal to Pre Week To.', "warning");
            $filterPanel.addClass('open');
            $toggleBtn.html('<i class="fas fa-angle-double-left mr-1"></i> Hide Filters');
            return;
        }

        if (parseInt(postWeekFromFilter) > parseInt(postWeekToFilter)) {
            modal.alert('Post Week From must be less than or equal to Post Week To.', "warning");
            $filterPanel.addClass('open');
            $toggleBtn.html('<i class="fas fa-angle-double-left mr-1"></i> Hide Filters');
            return;
        }

        if (parseInt(postWeekFromFilter) < parseInt(preWeekToFilter)) {
            modal.alert('Post period must be greater than or equal to PRE period!', "warning");
            $filterPanel.addClass('open');
            $toggleBtn.html('<i class="fas fa-angle-double-left mr-1"></i> Hide Filters');
            return;
        }
       
        $('#sourceDate').text($("#year option:selected").text() + " - " + preStartDateFrom + " to " + postEndDateTo);
    
        if (counter >= 1) {
            const generationPeriod = getTodayDateTime();
            logActivity("Promo Analysis", "Refresh", "User refreshed promo analysis.", "", "", "" );

            fetchData();
            $('.table-empty').hide();
            $('.hide-div').show();
            $('#additionalFiltersPanel').removeClass('open');
            $('#toggleAdditionalFilters').html('<i class="fas fa-angle-double-right mr-1"></i> More Filters');
        }
        // else {
        //     $('#generationPeriod').text('N/A');
        // }
    });

    function handleAction(action) {
        modal.loading(true);

        const filters = collectFilters(); 

        filters.type = action === 'exportPdf' ? 1 : 2;
        filters.is_export = true;
        //     console.log(filters);
        // return;
        if (action === 'exportPdf' || action === 'exportExcel') {
            $.ajax({
                url: base_url + 'promo-analysis/get-promo-table-all',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(filters),
                xhrFields: { responseType: 'blob' },
                success: function(data, status, xhr) {
                    var blobType = action === 'exportPdf' ? 'application/pdf' : 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                    var blob = new Blob([data], { type: blobType });
                    var link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = action === 'exportPdf' ? 'Promo_Analysis.pdf' : 'Promo_Analysis.xlsx';
                    link.click();
                    URL.revokeObjectURL(link.href);
                },
                error: function(xhr, status, error) {
                    console.error('Export error:', error);
                },
                complete: () => modal.loading(false)
            });

            const end_time = new Date();
            const duration = formatDuration(start_time, end_time);

            const remarks = `
                Exported Successfully!
                <br>Start Time: ${formatReadableDate(start_time)}
                <br>End Time: ${formatReadableDate(end_time)}
                <br>Duration: ${duration}
            `;
            logActivity('Promo Analysis', action === 'exportPdf' ? 'Export PDF' : 'Export Excel', remarks, '-', null, null)

        } else {
            fetchData(filters, action);
            modal.loading(false);
        }
    }

    function formatColoredValue(value) {
        let num = parseFloat(value);

        if (isNaN(num) || num === 0) return "";

        let color = "";
        let arrow = "";
        let percent = "%";

        if (num > 0) {
            color = "green";
            arrow = ' <i class="fas fa-arrow-up"></i> +';
        } else if (num < 0) {
            color = "red";
            arrow = ' <i class="fas fa-arrow-down"></i> ';
        }

        return `<span style="color:${color}; font-weight:600;">${arrow}${formatNumberWithCommas(num.toFixed(2))} ${percent}</span>`;
    }


    function fetchData() {
        const f = collectFilters();

        if (!f.year) {
            $('.table-empty').show();
            $('.hide-div.card').hide();
            return;
        }

        if ($.fn.DataTable.isDataTable('#PromoAnalysis')) {
            let existingTable = $('#PromoAnalysis').DataTable();
            existingTable.clear().destroy();
        }

        var preWeekDays = 0;
        var postWeekDays = 0;
        var preMonthDays = 0;
        var postMonthDays = 0;

        let table = $('#PromoAnalysis').DataTable({
            paging: false,
            searching: false,
            ordering: true,
            info: false,
            lengthChange: false,
            colReorder: true,
            scrollY: "500px",
            scrollCollapse: true,

            ajax: {
                url: base_url + 'promo-analysis/get-promo-table-all',
                type: 'POST',
                data: function(d) {
                    Object.assign(d, f);
                    d.type = type;
                    d.is_export = isExport;
                },
                dataSrc: function(json) {
                    if (json.data.length > 0) {
                        preWeekDays = json.pre_week_days;
                        postWeekDays = json.post_week_days;
                        preMonthDays = json.pre_month_days;
                        postMonthDays = json.post_month_days;

                        $('.preWeekDays').text(preWeekDays);
                        $('.postWeekDays').text(postWeekDays);
                        $('.preMonthDays').text(preMonthDays);
                        $('.postMonthDays').text(postMonthDays);

                        $('.preWeek').text(' (W' + f.pre_week_start + ' - W' + f.pre_week_end + ')');
                        $('.postWeek').text(' (W' + f.post_week_start + ' - W' + f.post_week_end + ')');
                        $('.preMonth').text(' (' + f.pre_month_start_text + ' - ' + f.pre_month_end_text + ')');
                        $('.postMonth').text(' (' + f.post_month_start_text + ' - ' + f.post_month_end_text + ')');
                    }

                    return json.data.length ? json.data : [];
                }
            },

            columns: [
                { data: 'itmcde' },
                { data: 'item_name' },

                { data: 'pre_vmi', render: formatNumberWithCommas },
                { data: 'post_vmi', render: formatNumberWithCommas },

                // PRE vs POST VMI — COLORED
                {
                    data: 'adv_vmi',
                    render: function(data) {
                        return formatColoredValue(data);
                    }
                },

                { data: 'pre_sales', render: formatNumberWithCommas },
                { data: 'post_sales', render: formatNumberWithCommas },

                // PRE vs POST SALES — COLORED
                {
                    data: 'ads_sales',
                    render: function(data) {
                        return formatColoredValue(data);
                    }
                }
            ].filter(Boolean),

            footerCallback: function(row, data, start, end, display) {
                let api = this.api();

                let intVal = function(i) {
                    return typeof i === 'string'
                        ? i.replace(/[\$,]/g, '') * 1
                        : typeof i === 'number'
                        ? i
                        : 0;
                };

                let totalPreVMI = api.column(2).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                let totalPostVMI = api.column(3).data().reduce((a, b) => intVal(a) + intVal(b), 0);

                let totalPreScan = api.column(5).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                let totalPostScan = api.column(6).data().reduce((a, b) => intVal(a) + intVal(b), 0);

                let totalPrePostVMI = totalPreVMI !== 0
                    ? ((totalPostVMI - totalPreVMI) / totalPreVMI) * 100
                    : 0;

                let totalPrePostScan = totalPreScan !== 0
                    ? ((totalPostScan - totalPreScan) / totalPreScan) * 100
                    : 0;

                $(api.column(2).footer()).html(formatNumberWithCommas(totalPreVMI.toFixed(2)));
                $(api.column(3).footer()).html(formatNumberWithCommas(totalPostVMI.toFixed(2)));

                // footer colored
                $(api.column(4).footer()).html(formatColoredValue(totalPrePostVMI));

                $(api.column(5).footer()).html(formatNumberWithCommas(totalPreScan.toFixed(2)));
                $(api.column(6).footer()).html(formatNumberWithCommas(totalPostScan.toFixed(2)));

                // footer colored
                $(api.column(7).footer()).html(formatColoredValue(totalPrePostScan));
            },

            columnDefs: [
                { targets: [0, 1, 2, 3, 4, 5, 6], orderable: true }
            ],

            processing: true,
            serverSide: true,
            searching: true,
            lengthChange: false
        });
    }


    function collectFilters() {

        return {
            // Items / Brands
            items: $('#itmCode').val(),
            brands: $('#brands').val(),
            brands_text: $('#brands option:selected').map(function () {
                return $(this).text();
            }).get(),

            variant_name: $('#variantName').val(),

            brands_label: $('#itemLabel').val(),
            brands_label_text: $('#itemLabel option:selected').map(function () {
                return $(this).text();
            }).get(),

            // Stores
            store_codes: $('#storeName').val(),
            store_codes_text: $('#storeName option:selected').map(function () {
                return $(this).text();
            }).get(),

            // Year
            year: $('#year').val(),
            year_id: $("#year option:selected").data("year"),

            // Pre-Month Range
            pre_month_start: $('#monthFromPre').val(),
            pre_month_start_text: $("#monthFromPre option:selected").text(),
            pre_month_end: $('#monthToPre').val(),
            pre_month_end_text: $("#monthToPre option:selected").text(),

            // Post-Month Range
            post_month_start: $('#monthFromPost').val(),
            post_month_start_text: $("#monthFromPost option:selected").text(),
            post_month_end: $('#monthToPost').val(),
            post_month_end_text: $("#monthToPost option:selected").text(),

            // Pre-Week Range
            pre_week_start: $('#weekfromPre').val(),
            pre_week_start_date: $("#weekfromPre option:selected").data("start-date"),
            pre_week_end: $('#weektoPre').val(),
            pre_week_end_date: $("#weektoPre option:selected").data("end-date"),

            // Post-Week Range
            post_week_start: $('#weekfromPost').val(),
            post_week_start_date: $("#weekfromPost option:selected").data("start-date"),
            post_week_end: $('#weektoPost').val(),
            post_week_end_date: $("#weektoPost option:selected").data("end-date")
        };
    }

    function updateWeeks(id, targetWeek) {
        let selectedYear = $('#year option:selected').text();
        let weeks = getCalendarWeeks(selectedYear);

        if(targetWeek){
            //console.log(targetWeek);
            if(targetWeek.week){
                populateDropdown(id, weeks, 'display', 'id');
                if(id === 'weekfromPre' || id === 'weekfromPost'){
                    let firstWeek = getCalendarWeeks(selectedYear)[0].week;
                    $("#" + id).val(firstWeek);
                }else{
                    $("#" + id).val(targetWeek.week);
                }

            }
        }else{
            let selectedYtd = $('input[name="ytd"]:checked').val();
            if(selectedYtd === "no"){
                populateDropdown(id, getCalendarWeeks(selectedYear), 'display', 'id');
            }
        }
    }

    const populateDropdown = (selected_class, result, textKey = 'name', valueKey = 'id') => {
        let html = '<option id="default_val" value="">Select</option>';
        
        if (result && result.length > 0) {
            result.forEach((item) => {
                html += `<option value="${item[valueKey]}" data-start-date="${item['start']}" data-end-date="${item['end']}">${item[textKey]}</option>`;
            });
        }
        
        $('#' + selected_class).html(html);
    };

