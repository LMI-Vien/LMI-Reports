    const start_time = new Date();
    
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
        $('#brandCategory').select2({ placeholder: 'Select Brand Categories' });
        $('#itemLabel').select2({ placeholder: 'Select Label Type' });

        $("input[name='measure']").on("change", function () {
            let selectedMeasure = $('input[name="measure"]:checked').val();
            $('.tblMeasure').text( ' ('+selectedMeasure+')');
        });

        $("input[name='ytd']").on("change", function () {
            const isYtd = $(this).val() === 'yes';

            if (isYtd) {
                const currentDate = new Date();
                const currentYear = currentDate.getFullYear();
                const currentMonth = currentDate.getMonth() + 1;

                $("#year").val(currentYear);

                const htmlFrom = buildMonthDropdown(1, currentMonth);
                const htmlTo = buildMonthDropdown(1, currentMonth);

                $("#monthFrom").html(htmlFrom).val(1);
                $("#monthTo").html(htmlTo).val(currentMonth);

                $('#sourceDate').text(
                    getTextOrDash("#year") + " " +
                    getTextOrDash("#monthFrom") +
                    " to " +
                    getTextOrDash("#monthTo")
                );    

                updateWeeks('weekfrom', getCurrentWeek()); 
                updateWeeks('weekto', getCurrentWeek()); 
                source = $('#dataSource').val();
                if(source !== "scann_data"){
                    $('#sourceDate').text(
                        getTextOrDash("#year") + " " +
                        getTextOrDash("#weekfrom") +
                        " to " +
                        getTextOrDash("#weekto")
                    );
                }    
            }else {
                const htmlFrom = buildMonthDropdown(1, 12);
                const htmlTo = buildMonthDropdown(1, 12);

                $('#weekto').val('');
                $('#weekfrom').val('');

                $("#monthFrom").html(htmlFrom).val('');
                $("#monthTo").html(htmlTo).val('');
                $("#year").val('');
                $("#quarter").val('');
                $('#sourceDate').text(" N / A");
            }
        });

        $("#quarter").on("change", function () {
            const quarter = $(this).val();
            let from = 1, to = 12;
            let weekFrom = 1, weekTo = 52;
            var year = $("#year").val();
            if(year === 'Please select...'){
                modal.alert('Please select "Year" before filtering.', "warning");
                return;
            }
            updateWeeks('weekfrom', getCurrentWeek()); 
            updateWeeks('weekto', getCurrentWeek()); 
            switch (quarter) {
                case "Q1":
                    from = 1; to = 3;
                    weekFrom = 1; weekTo = 13;
                    break;
                case "Q2":
                    from = 4; to = 6;
                    weekFrom = 14; weekTo = 26;
                    break;
                case "Q3":
                    from = 7; to = 9;
                    weekFrom = 27; weekTo = 39;
                    break;
                case "Q4":
                    from = 10; to = 12;
                    weekFrom = 40; weekTo = 52;
                    break;
            }

            const html = buildMonthDropdown(from, to);
            $("#monthFrom").html(html).val(from);
            $("#monthTo").html(html).val(to);

            $("#weekfrom").val(weekFrom);
            $("#weekto").val(weekTo);
            $('#source').text(" "+ $("#dataSource option:selected").text());
            $('#sourceDate').text(`${getTextOrDash("#year")} ${getTextOrDash("#monthFrom")} to ${getTextOrDash("#monthTo")}`);
            if(source !== "scann_data"){
                $('#sourceDate').text(`${getTextOrDash("#year")} ${getTextOrDash("#weekfrom")} to ${getTextOrDash("#weekto")}`);
            }
            
        });

        $("#dataSource").on("change", function () {
            const source = $(this).val();
            $('#source').text(" "+ $("#dataSource option:selected").text());
            if(source === "scann_data"){
              $('#monthFilterSection').show();
              $('#monthToSection').show();
              $('#weekFilterSection').hide();
              $('#weekToSection').hide();
            }else{
              $('#monthFilterSection').hide();
              $('#monthToSection').hide();
              $('#weekFilterSection').show();
              $('#weekToSection').show();
            }
        });

        $("#year").on("change", function () {
            const year = $(this).val();
            if(year){
                $('#sourceDate').text(
                    getTextOrDash("#year") + " " +
                    getTextOrDash("#monthFrom") +
                    " to " +
                    getTextOrDash("#monthTo")
                );
            }
        });

        $("#monthFrom").on("change", function() {
            let selected = $("#monthTo").val();
            let start = $("#monthFrom").val();
            let html = "<option value=''>Please select...</option>";

            months.forEach(month => {
                if (parseInt(month.id) >= start) {
                    html += `<option value="${month.id}">${month.month}</option>`;
                }
            });

            $("#monthTo").html(html);
            $('#sourceDate').text(
                getTextOrDash("#year") + " " +
                getTextOrDash("#monthFrom") +
                " to " +
                getTextOrDash("#monthTo")
            );
        });

        $("#monthTo").on("change", function() {
            let selected = $("#monthFrom").val();
            let end = $("#monthTo").val();
            let html = "<option value=''>Please select...</option>";

            months.forEach(month => {
                if (parseInt(month.id) < end) {
                    html += `<option value="${month.id}">${month.month}</option>`;
                }
            });

            $('#sourceDate').text(
                getTextOrDash("#year") + " " +
                getTextOrDash("#monthFrom") +
                " to " +
                getTextOrDash("#monthTo")
            );
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

        $('#salesGroup').on('change', function () {
            const selected = $('#salesGroup').val();
            $('#subGroup').val('');
            if (selected) {
                get_sub_sales_group(selected);
            } else {
                $('#subGroupWrapper').slideUp();
            }
        });
    });


    $(document).on('click', '#clearButton', function () {
        $('input[type="text"], input[type="number"]').val('');
        $('input[type="checkbox"]').prop('checked', false);
        $('select').prop('selectedIndex', 0);
        $('.select2').val(null).trigger('change');
        $('.btn-outline-light').removeClass('active');
        $('.main_all').addClass('active');
        $('input[name="filterType"][value="3"]').prop('checked', true);
        $('input[name="ytd"][value="no"]').prop('checked', true);
        $('input[name="measure"][value="qty"]').prop('checked', true);
        $('#subGroupWrapper').slideUp();
        $('#subGroup').val('');
        $('#additionalFiltersPanel').removeClass('open');
        $('#toggleAdditionalFilters').html('<i class="fas fa-angle-double-right mr-1"></i> More Filters');
        $('#source').text(" "+ $("#dataSource option:selected").text());
        $('#sourceDate').text(" N / A");
        $('.hide-div').hide();
        $('.table-empty').show();
    });

    $(document).on('click', '#refreshButton', function () {
        const fields = [
            { input: '#brands', target: '#brands' },
            { input: '#brandCategory', target: '#brandCategory' },
            { input: '#itemLabel', target: '#itemLabel' }
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

        const weekFromOption = $("#weekfrom option:selected");
        const startDateFrom = weekFromOption.data("start-date");
        const weekToOption = $("#weekto option:selected");
        const endDateTo = weekToOption.data("end-date"); 
        const weekFromFilter = $('#weekfrom').val();
        const weekToFilter = $('#weekto').val();

        const sourceFilter = $('#dataSource').val();
        const monthFromFilter = $('#monthFrom').val();
        const monthToFilter = $('#monthTo').val();
        const yearFilter = $('#year').val();
        const SalesGroupFilter = $('#salesGroup').val();

        if (!sourceFilter) {
            modal.alert('Please select "Data Source" before filtering.', "warning");
            return;
        }

        const $toggleBtn = $('#toggleAdditionalFilters');
        const $filterPanel = $('#additionalFiltersPanel');

        if (!yearFilter) {
            modal.alert('Please select "Year" before filtering.', "warning");
            $filterPanel.addClass('open');
            $toggleBtn.html('<i class="fas fa-angle-double-left mr-1"></i> Hide Filters');
            return;
        }
 
        if(sourceFilter === "scann_data"){
            if (!sourceFilter && !monthFromFilter && !monthToFilter) {
                modal.alert('Please select both "Data Source" and "Month" selection before filtering.', "warning");
                return;
            }

            if (!monthFromFilter) {
                modal.alert('Please select "Month From" before filtering.', "warning");
                $filterPanel.addClass('open');
                $toggleBtn.html('<i class="fas fa-angle-double-left mr-1"></i> Hide Filters');
                return;
            }

            if (!monthToFilter) {
                modal.alert('Please select "Month To" before filtering.', "warning");
                $filterPanel.addClass('open');
                $toggleBtn.html('<i class="fas fa-angle-double-left mr-1"></i> Hide Filters');
                return;
            } 
        }else{
            if (!sourceFilter && !weekFromFilter && !weekToFilter) {
                modal.alert('Please select both "Data Source" and "Weeks" selection before filtering.', "warning");
                return;
            }

            if (!weekFromFilter) {
                modal.alert('Please select "Week From" before filtering.', "warning");
                $filterPanel.addClass('open');
                $toggleBtn.html('<i class="fas fa-angle-double-left mr-1"></i> Hide Filters');
                return;
            }

            if (!weekToFilter) {
                modal.alert('Please select "Week To" before filtering.', "warning");
                $filterPanel.addClass('open');
                $toggleBtn.html('<i class="fas fa-angle-double-left mr-1"></i> Hide Filters');
                return;
            }  
        }

        if (!SalesGroupFilter) {
            modal.alert('Please select "Sales Group" before filtering.', "warning");
            $filterPanel.removeClass('open');
            $toggleBtn.html('<i class="fas fa-angle-double-right mr-1"></i> More Filters');
            return;
        }  

        $('#source').text(" " + $("#dataSource option:selected").text() );
        if(sourceFilter === "scann_data"){
            $('#sourceDate').text($("#year option:selected").text() + " - " + $("#monthFrom option:selected").text() + " to " + $("#monthTo option:selected").text());
        }else{
            $('#sourceDate').text($("#year option:selected").text() + " - " + startDateFrom + " to " + endDateTo);
        }

        if (counter >= 1) {
            const generationPeriod = getTodayDateTime();
            //$('#generationPeriod').text(generationPeriod.display);
            logActivity("Sell Through Overall", "Refresh", "User refreshed sell through overall.", "", "", "" );
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
        let selectedSource = $('#dataSource').val();
        let selectedBrands = $('#brands').val();
        let selectedBrandCategories = $('#brandCategory').val();
        let selectedBrandLabels = $('#itemLabel').val();  
        let selectedYear = $('#year').val();
        let yearOption = $("#year option:selected");
        let selectedYearId = yearOption.data("year");
        let selectedMonthStart = $('#monthFrom').val();
        let selectedMonthEnd = $('#monthTo').val();
        let selectedSalesGroup = $('#salesGroup').val();
        let selectedSubSalesGroup = $('#subGroup').val();
        let selectedType = $('input[name="filterType"]:checked').val();
        let selectedMeasure = $('input[name="measure"]:checked').val();
        let weekFromOption = $("#weekfrom option:selected");
        let selectedWeekStartDate = weekFromOption.data("start-date");
        let selectedWeekStart =  $('#weekfrom').val();
        let weekToOption = $("#weekto option:selected");
        let selectedWeekEndDate = weekToOption.data("end-date"); 
        let selectedWeekEnd =  $('#weekto').val();

        if (!selectedSource || !selectedSalesGroup) {
            $('.table-empty').show();
            $('.hide-div.card').hide();
            return;
        }

        if ($.fn.DataTable.isDataTable('#sellThroughOverall')) {
            let existingTable = $('#sellThroughOverall').DataTable();
            existingTable.clear().destroy();
        }

        let table = $('#sellThroughOverall').DataTable({
            paging: true,
            searching: false,
            ordering: true,
            info: true,
            lengthChange: false,
            colReorder: true, 
            ajax: {
                url: base_url + 'sell-through/get-overall',
                type: 'POST',
                data: function(d) {
                    d.source = selectedSource === "" ? null : selectedSource;
                    d.brands = selectedBrands.length ? selectedBrands : null;
                    d.brand_categories = selectedBrandCategories.length ? selectedBrandCategories : null;
                    d.brands_label = selectedBrandLabels.length ? selectedBrandLabels : null;
                    d.year = selectedYear === "0" ? null : selectedYear;
                    d.year_id = selectedYearId === "0" ? null : selectedYearId;
                    d.month_start = selectedMonthStart === "0" ? null : selectedMonthStart;
                    d.month_end = selectedMonthEnd === "0" ? null : selectedMonthEnd;
                    d.week_start = selectedWeekStart === "0" ? null : selectedWeekStart;
                    d.week_end = selectedWeekEnd === "0" ? null : selectedWeekEnd;
                    d.week_start_date = selectedWeekStartDate === "0" ? null : selectedWeekStartDate;
                    d.week_end_date = selectedWeekEndDate === "0" ? null : selectedWeekEndDate;
                    d.sales_group = selectedSalesGroup === "" ? null : selectedSalesGroup;
                    d.sub_sales_group = selectedSubSalesGroup === "" ? null : selectedSubSalesGroup;
                    d.type = selectedType === "" ? null : selectedType;
                    d.measure = selectedMeasure === "" ? null : selectedMeasure;
                    d.limit = d.length;
                    d.offset = d.start;
                },
                dataSrc: function(json) {
                    // console.log(json, 'json')
                    return json.data.length ? json.data : [];
                }
            },
            columns: [
                { data: 'rank' },
                { data: 'itmcde' },
                { data: 'customer_sku' },
                { data: 'item_description' },
                { data: 'brand' },
                { data: 'brand_category' },
                { data: 'sell_in', render: formatNumberWithCommas},
                { data: 'sell_out', render: formatNumberWithCommas},
                { data: 'sell_out_ratio', render: formatNumberWithCommas}
            ].filter(Boolean),
            columnDefs: [
                {
                    targets: [0, 1, 2, 3, 4, 5, 6],
                    orderable: true
                }
            ],
            pagingType: "full_numbers",
            pageLength: 10,
            processing: true,
            serverSide: true,
            searching: true,
            // colReorder: true,
            lengthChange: false
        });
        
    }

    function get_sub_sales_group(sub_group){
        $.ajax({
          type: 'Post',
          url: base_url + 'sell-through/get-sub-sales-group',
          data: { sales_group: sub_group },
        }).done( function(data){
          var obj = JSON.parse(data);
          var htm1 = '';
          var htm2 = '';
          var items_per_group =  obj.items;
          var sub_payment_group = obj.sub_payment_group; 
          htm1 += '<option value="">--Select--</option>';
          
          $.each(sub_payment_group, function(index, row){
              htm1 += '<option value="'+row.code+'">'+row.description+'</option>';
          });

            $.each(items_per_group, function(index, row){
              htm2 += '<option value="'+row.item_code+'">'+row.item_code+'</option>';
          });

          $('#subGroup').html(htm1);
          $('#itmCode').val(null).trigger('change');
          $('#itmCode').html(htm2);
          $('#subGroupWrapper').slideDown();
        });
    }  

    function updateWeeks(id, targetWeek) {
        let selectedYear = $('#year option:selected').text();
        let weeks = getCalendarWeeks(selectedYear);

        if(targetWeek){
            //console.log(targetWeek);
            if(targetWeek.week){
                populateDropdown(id, weeks, 'display', 'id');
                if(id === 'weekfrom'){
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
            //console.log(result);
            result.forEach((item) => {
                html += `<option value="${item[valueKey]}" data-start-date="${item['start']}" data-end-date="${item['end']}">${item[textKey]}</option>`;
            });
        }
        
        $('#' + selected_class).html(html);
    };

    function handleAction(action) {
        modal.loading(true);
        let endpoint = (action === 'exportPdf') ? 'by-overall-generate-pdf' : 'by-overall-generate-excel-ba';
        let url = `${base_url}sell-through/${endpoint}`;

        let selectedSource = $('#dataSource').val();

        let selectedBrands = $('#brands').val();
        let selectedBrandsText = $('#brands option:selected')
        .map(function() { return $(this).text(); }) .get() .join(', ');

        let selectedBrandCategories = $('#brandCategory').val();
        let selectedBrandCategoriesText = $('#brandCategory option:selected')
        .map(function() { return $(this).text(); }) .get() .join(', ');

        let selectedBrandLabels = $('#itemLabel').val();  
        let selectedBrandLabelsText = $('#itemLabel option:selected')
        .map(function() { return $(this).text(); }) .get() .join(', ');

        let selectedYear = $('#year').val();
        let yearOption = $("#year option:selected");
        let selectedYearId = yearOption.data("year");
        let selectedQuarter = $('#quarter').val();
        let selectedMonthStart = $('#monthFrom').val();
        let selectedMonthEnd = $('#monthTo').val();
        let ytd = $('input[name="ytd"]:checked').val();
        let selectedSalesGroup = $('#salesGroup').val();
        let selectedSubSalesGroup = $('#subGroup').val();
        let selectedType = $('input[name="filterType"]:checked').val();
        let selectedMeasure = $('input[name="measure"]:checked').val();
        let weekFromOption = $("#weekfrom option:selected");
        let selectedWeekStartDate = weekFromOption.data("start-date");
        let selectedWeekStart =  $('#weekfrom').val();
        let weekToOption = $("#weekto option:selected");
        let selectedWeekEndDate = weekToOption.data("end-date"); 
        let selectedWeekEnd =  $('#weekto').val();
        let searchValue = $('.dt-input').val();
        let order = $('#sellThroughOverall').DataTable().order();
        let orderByColumn = '';
        let orderDirection = '';
        switch (order[0][0]) {
            case 1: orderByColumn = 'itmcde'; break;
            case 2: orderByColumn = 'customer_sku'; break;
            case 3: orderByColumn = 'item_description'; break;
            case 4: orderByColumn = 'brand'; break;
            case 5: orderByColumn = 'brand_category'; break;
            case 6: orderByColumn = 'sell_in'; break;
            case 7: orderByColumn = 'sell_out'; break;
            case 8: orderByColumn = 'sell_out_ratio'; break;
            default: orderByColumn = 'rank'; break;
        }
        orderDirection = order[0][1].toUpperCase();

        let postData = {
            source : selectedSource === "" ? null : selectedSource,
            brands : selectedBrands.length ? selectedBrands : null,
            brands_text : selectedBrandsText,
            brand_categories : selectedBrandCategories.length ? selectedBrandCategories : null,
            brand_categories_text : selectedBrandCategoriesText,
            brands_label : selectedBrandLabels === "" ? null : selectedBrandLabels,
            brands_label_text : selectedBrandLabelsText,
            year : selectedYear === "0" ? null : selectedYear,
            quarter : selectedQuarter === "0" ? null : selectedQuarter,
            year_id : selectedYearId === "0" ? null : selectedYearId,
            month_start : selectedMonthStart === "0" ? null : selectedMonthStart,
            month_end : selectedMonthEnd === "0" ? null : selectedMonthEnd,
            week_start : selectedWeekStart === "0" ? null : selectedWeekStart,
            week_end : selectedWeekEnd === "0" ? null : selectedWeekEnd,
            week_start_date : selectedWeekStartDate === "0" ? null : selectedWeekStartDate,
            week_end_date : selectedWeekEndDate === "0" ? null : selectedWeekEndDate,
            ytd : ytd === "0" ? null : ytd,
            sales_group : selectedSalesGroup === "" ? null : selectedSalesGroup,
            sub_sales_group : selectedSubSalesGroup === "" ? null : selectedSubSalesGroup,
            type : selectedType === "" ? null : selectedType,
            measure : selectedMeasure === "" ? null : selectedMeasure,
            limit : 9999,
            offset : 0,
            search : searchValue,
            order_by_column : orderByColumn,
            order_direction : orderDirection,
        }

        $.ajax({
            url: url,
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(postData),
            // success : (res) => {
            //     console.log(JSON.parse(res), 'res')
            // },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(blob, status, xhr) {
                const cd = xhr.getResponseHeader('Content-Disposition');
                const match = cd && /filename="?([^"]+)"/.exec(cd);
                let rawName = match?.[1] ? decodeURIComponent(match[1]) : null;
                const filename = rawName
                    || (action === 'exportPdf'
                        ? 'Sell Through - Overall.pdf'
                        : 'Sell Through - Overall.xlsx');

                const blobUrl = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = blobUrl;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                a.remove();
                URL.revokeObjectURL(blobUrl);
            },
            error: function(xhr, status, error) {
                alert(xhr+' - '+status+' - '+error);
                modal.loading(false);
            },
            complete: function() {
                modal.loading(false);
            }
        });
    }