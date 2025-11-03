    const start_time = new Date();
    let isGraphMode = false;
    let chartInstance = null;
    let currentPage = 1;
    const chartLimit = 10;
    let totalRecords = 0;
    var isExport = false;
    var type = null;
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

        $('#brands').select2({ placeholder: 'Select Brands' });
        $('#itemLabel').select2({ placeholder: 'Select Select Label Type' });
        $('#itmCode').select2({ placeholder: 'Select Item' });
        $('#storeName').select2({ placeholder: 'Select Store' });

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
            { input: '#itmCode', target: '#storeName' }
            
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

        if (postWeekFromFilter < preWeekToFilter) {
            modal.alert('Must be greater than or equal to VMI Data PRE Period!', "warning");
            $filterPanel.addClass('open');
            $toggleBtn.html('<i class="fas fa-angle-double-left mr-1"></i> Hide Filters');
            return;
        }
       
        $('#sourceDate').text($("#year option:selected").text() + " - " + preStartDateFrom + " to " + postEndDateTo);
    
        if (counter >= 1) {
            const generationPeriod = getTodayDateTime();
            logActivity("Sell Through By Brand", "Refresh", "User refreshed sell through by brand.", "", "", "" );

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


    function fetchData() {
        let selectedItems = $('#itmCode').val();
        let selectedBrands = $('#brands').val();
        let selectedVariant = $('#variantName').val();  
        let selectedBrandLabels = $('#itemLabel').val();
        let selectedStores = $('#storeName').val();  
        let selectedYear = $('#year').val();
        let yearOption = $("#year option:selected");
        let selectedYearId = yearOption.data("year");
        let selectedPreMonthStart = $('#monthFromPre').val();
        let selectedPreMonthStartOption = $("#monthFromPre option:selected").text();
        let selectedPreMonthEnd = $('#monthToPre').val();
        let selectedPreMonthEndOption = $("#monthToPre option:selected").text();
        let selectedPostMonthStart = $('#monthFromPost').val();
        let selectedPostMonthStartOption = $("#monthFromPost option:selected").text();
        let selectedPostMonthEnd = $('#monthToPost').val();
        let selectedPostMonthEndOption = $("#monthToPost option:selected").text();

        let preWeekFromOption = $("#weekfromPre option:selected");
        let selectedPreWeekStartDate = preWeekFromOption.data("start-date");
        let selectedPreWeekStart =  $('#weekfromPre').val();
        let preWeekToOption = $("#weektoPre option:selected");
        let selectedPreWeekEndDate = preWeekToOption.data("end-date"); 
        let selectedPreWeekEnd =  $('#weektoPre').val();

        let postWeekFromOption = $("#weekfromPost option:selected");
        let selectedPostWeekStartDate = postWeekFromOption.data("start-date");
        let selectedPostWeekStart =  $('#weekfromPost').val();
        let postWeekToOption = $("#weektoPost option:selected");
        let selectedPostWeekEndDate = postWeekToOption.data("end-date"); 
        let selectedPostWeekEnd =  $('#weektoPost').val();

        if (!selectedYear) {
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
            ajax: {
                url: base_url + 'promo-analysis/get-promo-table-all',
                type: 'POST',
                data: function(d) {
                    d.store_codes = selectedStores.length ? selectedStores : null;
                    d.variant_name = selectedVariant === "" ? null : selectedVariant;
                    d.items = selectedItems.length ? selectedItems : null;
                    d.brands = selectedBrands.length ? selectedBrands : null;
                    d.brands_label = selectedBrandLabels.length ? selectedBrandLabels : null;
                    d.brands_label = selectedBrandLabels.length ? selectedBrandLabels : null;
                    d.year = selectedYear === "0" ? null : selectedYear;
                    d.year_id = selectedYearId === "0" ? null : selectedYearId;
                    d.pre_month_start = selectedPreMonthStart === "0" ? null : selectedPreMonthStart;
                    d.pre_month_end = selectedPreMonthEnd === "0" ? null : selectedPreMonthEnd;
                    d.post_month_start = selectedPostMonthStart === "0" ? null : selectedPostMonthStart;
                    d.post_month_end = selectedPostMonthEnd === "0" ? null : selectedPostMonthEnd;
                    d.pre_week_start = selectedPreWeekStart === "0" ? null : selectedPreWeekStart;
                    d.pre_week_end = selectedPreWeekEnd === "0" ? null : selectedPreWeekEnd;
                    d.pre_week_start_date = selectedPreWeekStartDate === "0" ? null : selectedPreWeekStartDate;
                    d.pre_week_end_date = selectedPreWeekEndDate === "0" ? null : selectedPreWeekEndDate;
                    d.post_week_start = selectedPostWeekStart === "0" ? null : selectedPostWeekStart;
                    d.post_week_end = selectedPostWeekEnd === "0" ? null : selectedPostWeekEnd;
                    d.post_week_start_date = selectedPostWeekStartDate === "0" ? null : selectedPostWeekStartDate;
                    d.post_week_end_date = selectedPostWeekEndDate === "0" ? null : selectedPostWeekEndDate;
                    d.post_week_end_date = selectedPostWeekEndDate === "0" ? null : selectedPostWeekEndDate;
                    d.post_week_end_date = selectedPostWeekEndDate === "0" ? null : selectedPostWeekEndDate;
                    d.type = type;
                    d.is_export = isExport;
                },
                dataSrc: function(json) {
                    if(json.data.length > 0){
                        preWeekDays = json.data[0].pre_week_days;
                        postWeekDays = json.data[0].post_week_days;
                        preMonthDays = json.data[0].pre_month_days;
                        postMonthDays = json.data[0].post_month_days;
                        $('.preWeekDays').text(preWeekDays);
                        $('.postWeekDays').text(postWeekDays);
                        $('.preMonthDays').text(preMonthDays);
                        $('.postMonthDays').text(postMonthDays);
                        $('.preWeek').text( ' (W'+selectedPreWeekStart+' - W'+selectedPreWeekEnd+')');
                        $('.postWeek').text( ' (W'+selectedPostWeekStart+' - W'+selectedPostWeekEnd+')');
                        $('.preMonth').text( ' ('+selectedPreMonthStartOption+' - '+selectedPreMonthEndOption+')');
                        $('.postMonth').text( ' ('+selectedPostMonthStartOption+' - '+selectedPostMonthEndOption+')');    
                    }
                    
                    return json.data.length ? json.data : [];

                }
            },
            columns: [
                { data: 'itmcde' },
                { data: 'item_name' },
                { data: 'pre_vmi', render: formatNumberWithCommas},
                { data: 'post_vmi', render: formatNumberWithCommas},
                { data: 'adv_vmi', render: formatNumberWithCommas},
                { data: 'pre_sales', render: formatNumberWithCommas},
                { data: 'post_sales', render: formatNumberWithCommas},
                { data: 'ads_sales', render: formatNumberWithCommas}
            ].filter(Boolean),
            footerCallback: function (row, data, start, end, display) {
                let api = this.api();

                let intVal = function (i) {
                    return typeof i === 'string'
                        ? i.replace(/[\$,]/g, '') * 1
                        : typeof i === 'number'
                        ? i
                        : 0;
                };

                let totalPreVMI = api.column(2).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                let totalPostVMI = api.column(3).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                let totalPrePostVMI = api.column(4).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                let totalPreScan = api.column(5).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                let totalPostScan = api.column(6).data().reduce((a, b) => intVal(a) + intVal(b), 0);
                let totalPrePostScan = api.column(7).data().reduce((a, b) => intVal(a) + intVal(b), 0);

                $(api.column(2).footer()).html(formatNumberWithCommas(totalPreVMI.toFixed(2)));
                $(api.column(3).footer()).html(formatNumberWithCommas(totalPostVMI.toFixed(2)));
                $(api.column(4).footer()).html(formatNumberWithCommas(totalPrePostVMI.toFixed(2)));
                $(api.column(5).footer()).html(formatNumberWithCommas(totalPreScan.toFixed(2)));
                $(api.column(6).footer()).html(formatNumberWithCommas(totalPostScan.toFixed(2)));
                $(api.column(7).footer()).html(formatNumberWithCommas(totalPrePostScan.toFixed(2)));
            },
            columnDefs: [
                {
                    targets: [0, 1, 2, 3, 4, 5, 6],
                    orderable: true
                }
            ],
            processing: true,
            serverSide: true,
            searching: true,
            lengthChange: false
        });
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

    function handleAction(action) {

    }