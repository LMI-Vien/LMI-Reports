    const start_time = new Date();
    let isGraphMode = false;
    let chartInstance = null;
    let currentPage = 1;
    const chartLimit = 10;
    let totalRecords = 0;
    
    $(document).ready(function() {

        const $toggleBtn = $('#toggleAdditionalFilters');
        const $filterPanel = $('#additionalFiltersPanel');
        const $toggleCategoryFilterBtn = $('#toggleAdditionalCategoryFilters');
        const $filterCategoryPanel = $('#additionalCategoryFiltersPanel');

        $toggleBtn.on('click', function () {
          const isOpen = $filterPanel.hasClass('open');
          $filterCategoryPanel.removeClass('open');
          $toggleCategoryFilterBtn.html('<i class="fas fa-angle-double-right mr-1"></i> More Category Filters');
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

        $toggleCategoryFilterBtn.on('click', function () {
          const isOpen = $filterCategoryPanel.hasClass('open');
          $filterPanel.removeClass('open');
          $toggleBtn.html('<i class="fas fa-angle-double-right mr-1"></i> More Filters');
          if (isOpen) {
            $filterCategoryPanel.removeClass('open');
            $toggleCategoryFilterBtn.html('<i class="fas fa-angle-double-right mr-1"></i> More Category Filters');
          } else {
            $filterCategoryPanel.addClass('open');
            $toggleCategoryFilterBtn.html('<i class="fas fa-angle-double-left mr-1"></i> Hide Category Filters');
          }
        });

        $('#closeAdditionalCategoryFilters').on('click', function () {
          $filterCategoryPanel.removeClass('open');
          $toggleCategoryFilterBtn.html('<i class="fas fa-angle-double-right mr-1"></i> More Category Filters');
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

        $('#category').select2({ placeholder: 'Select Label Type Category' });
        $('#brandCategory').select2({ placeholder: 'Select Item Classification' });
        $('#brandSubCategory').select2({ placeholder: 'Select Item Sub Classification' });
        $('#itemDepartment').select2({ placeholder: 'Select Item Department' });
        $('#merchCategory').select2({ placeholder: 'Select Item Merchandise Category' });

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
                source = $('#dataSource').val();
                $('#sourceDate').text(
                    getTextOrDash("#year") + " " +
                    getTextOrDash("#monthFrom") +
                    " to " +
                    getTextOrDash("#monthTo")
                );    

                updateWeeks('weekfrom', getCurrentWeek()); 
                updateWeeks('weekto', getCurrentWeek()); 

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
            let weekFrom = 1, weekTo = 53;
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
                    weekFrom = 40; weekTo = 53;
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
        $('#toggleAdditionalFilters').html('<i class="fas fa-angle-double-right mr-1"></i> More Category Filters');
        $('#additionalCategoryFiltersPanel').removeClass('open');
        $('#toggleAdditionalCategoryFilters').html('<i class="fas fa-angle-double-right mr-1"></i> More Category Filters');
        $('#source').text(" "+ $("#dataSource option:selected").text());
        $('#sourceDate').text(" N / A");
        $('.hide-div').hide();
        $('.table-empty').show();
    });

    $(document).on('click', '#refreshButton', function () {

        const fields = [
            { input: '#category', target: '#category' },
            { input: '#brandCategory', target: '#brandCategory' },
            { input: '#brandSubCategory', target: '#brandSubCategory' },
            { input: '#itemDepartment', target: '#itemDepartment' },
            { input: '#brandCategory', target: '#brandCategory' },
            { input: '#merchCategory', target: '#merchCategory' }
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
            logActivity("Sell Through By Brand Category", "Refresh", "User refreshed sell through by brand category.", "", "", "" );
            let mode = $('#toggleGraphMode').text().trim();
            if (mode === 'Graph View') {
                $('#chartContainer').hide();
                $('#tableContainer').fadeIn(200);
                fetchData();
                $('#toggleGraphMode').html('<i class="fas fa-chart-bar"></i> Graph View');
                isGraphMode = false;

                if (chartInstance) {
                    chartInstance.destroy();
                    chartInstance = null;
                }

            } else {
                $('#tableContainer').hide();
                $('#chartContainer').fadeIn(200);
                $('#toggleGraphMode').html('<i class="fas fa-table"></i> Table View');
                isGraphMode = true;
                setTimeout(() => {
                    renderSellThroughChart();
                }, 150);
            }
            $('.table-empty').hide();
            $('.hide-div').show();
            $('#additionalFiltersPanel').removeClass('open');
            $('#toggleAdditionalCategoryFilters').html('<i class="fas fa-angle-double-right mr-1"></i> More Category Filters');
            $('#additionalCategoryFiltersPanel').removeClass('open');
            $('#toggleAdditionalFilters').html('<i class="fas fa-angle-double-right mr-1"></i> More Category Filters');
        }
        // else {
        //     $('#generationPeriod').text('N/A');
        // }
    });

    $(document).on('click', '#toggleGraphMode', async function () {
        if (isGraphMode) {
            $('#chartContainer').hide();
            $('#tableContainer').fadeIn(200);
            fetchData();
            $(this).html('<i class="fas fa-chart-bar"></i> Graph View');
            isGraphMode = false;

            if (chartInstance) {
                chartInstance.destroy();
                chartInstance = null;
            }

        } else {
            $('#tableContainer').hide();
            $('#chartContainer').fadeIn(200);
            $(this).html('<i class="fas fa-table"></i> Table View');
            isGraphMode = true;
            setTimeout(() => {
                renderSellThroughChart();
            }, 150);
        }
    });

    function fetchData() {
        let selectedSource = $('#dataSource').val();
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
        let selectedCategories = $('#category').val();
        let selectedBrandCategories = $('#brandCategory').val();
        let selectedSubBrandCategories = $('#brandSubCategory').val();
        let selectedDepartments = $('#itemDepartment').val();
        let selectedMerchs = $('#merchCategory').val();

        if (!selectedSource || !selectedSalesGroup) {
            $('.table-empty').show();
            $('.hide-div.card').hide();
            return;
        }

        if ($.fn.DataTable.isDataTable('#sellThroughByBrandCategory')) {
            let existingTable = $('#sellThroughByBrandCategory').DataTable();
            existingTable.clear().destroy();
        }

        let table = $('#sellThroughByBrandCategory').DataTable({
            paging: true,
            searching: false,
            ordering: true,
            info: true,
            lengthChange: false,
            colReorder: true, 
            ajax: {
                url: base_url + 'sell-through/get-by-brand-category',
                type: 'POST',
                data: function(d) {
                    d.source = selectedSource === "" ? null : selectedSource;
                    d.brand_categories = selectedBrandCategories.length ? selectedBrandCategories : null;
                    d.sub_brand_categories = selectedSubBrandCategories.length ? selectedSubBrandCategories : null;
                    d.categories = selectedCategories.length ? selectedCategories : null;
                    d.item_departments = selectedDepartments.length ? selectedDepartments : null;
                    d.merch_categories = selectedMerchs.length ? selectedMerchs : null;
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
                    return json.data.length ? json.data : [];
                }
            },
            columns: [
                { data: 'rank' },
                { data: 'label_category' },
                { data: 'brand_category' },
                { data: 'sub_classification' },
                { data: 'item_department' },
                { data: 'item_merchandise' },
                { data: 'sell_in', render: formatNumberWithCommas},
                { data: 'sell_out', render: formatNumberWithCommas},
                { data: 'sell_out_ratio', render: formatNumberWithCommas}
            ].filter(Boolean),
            columnDefs: [
                {
                    targets: [0, 1, 2, 3, 4],
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

    function renderSellThroughChart(page = 1) {
        let selectedSource = $('#dataSource').val();
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
        let selectedCategories = $('#category').val();
        let selectedBrandCategories = $('#brandCategory').val();
        let selectedSubBrandCategories = $('#brandSubCategory').val();
        let selectedDepartments = $('#itemDepartment').val();
        let selectedMerchs = $('#merchCategory').val();
        const offset = (page - 1) * chartLimit;

        if (chartInstance) {
            chartInstance.destroy();
        }

        $.ajax({
            url: base_url + 'sell-through/get-by-brand-category',
            type: 'POST',
            data: {
                source : selectedSource === "" ? null : selectedSource,
                brand_categories : selectedBrandCategories.length ? selectedBrandCategories : null,
                sub_brand_categories : selectedSubBrandCategories.length ? selectedSubBrandCategories : null,
                categories : selectedCategories.length ? selectedCategories : null,
                item_departments : selectedDepartments.length ? selectedDepartments : null,
                merch_categories : selectedMerchs.length ? selectedMerchs : null,
                // brand_category : selectedBrandCategory || null,
                // sub_brand_category : selectedSubBrandCategory || null,
                // category : selectedCategory || null,
                // item_department : selectedDepartment || null,
                // merch_category : selectedMerch || null,
                year : selectedYear === "0" ? null : selectedYear,
                year_id : selectedYearId === "0" ? null : selectedYearId,
                month_start : selectedMonthStart === "0" ? null : selectedMonthStart,
                month_end : selectedMonthEnd === "0" ? null : selectedMonthEnd,
                week_start : selectedWeekStart === "0" ? null : selectedWeekStart,
                week_end : selectedWeekEnd === "0" ? null : selectedWeekEnd,
                week_start_date : selectedWeekStartDate === "0" ? null : selectedWeekStartDate,
                week_end_date : selectedWeekEndDate === "0" ? null : selectedWeekEndDate,
                sales_group : selectedSalesGroup === "" ? null : selectedSalesGroup,
                sub_sales_group : selectedSubSalesGroup === "" ? null : selectedSubSalesGroup,
                type : selectedType === "" ? null : selectedType,
                measure : selectedMeasure === "" ? null : selectedMeasure,
                limit: chartLimit,
                offset: offset
            },
            beforeSend: function() {
                modal.loading(true);
            },
            success: function(response) {
                modal.loading(false);

                if (!response.data || response.data.length === 0) {
                    modal.alert('No data available to display chart.', 'warning');
                    return;
                }

                // store total records (you must return this from backend)
                totalRecords = response.recordsTotal || 0;
                let labels = response.data.map(item => item.brand_category);
                let sellIn = response.data.map(item => parseFloat(item.sell_in) || 0);
                let sellOut = response.data.map(item => parseFloat(item.sell_out) || 0);
                let sellOutRatio = response.data.map(item => parseFloat(item.sell_out_ratio) || 0);

                let ctx = document.getElementById("sellThroughChart").getContext("2d");

                chartInstance = new Chart(ctx, {
                    type: "bar",
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: "Sell In",
                                backgroundColor: "#ffc107",
                                borderColor: "#d39e00",
                                borderWidth: 1,
                                data: sellIn
                            },
                            {
                                label: "Sell Out",
                                backgroundColor: "#990000",
                                borderColor: "#770000",
                                borderWidth: 1,
                                data: sellOut
                            },
                            {
                                label: "Sell Out Ratio",
                                backgroundColor: "#339933",
                                borderColor: "#267326",
                                borderWidth: 1,
                                data: sellOutRatio
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: "top" },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.dataset.label + ": " + tooltipItem.raw.toLocaleString();
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                title: { display: true, text: "SKU", font: { weight: "bold" } }
                            },
                            y: {
                                beginAtZero: true,
                                title: { display: true, text: "Values", font: { weight: "bold" } }
                            }
                        },
                        animation: {
                            duration: 800,
                            easing: "easeOutBounce"
                        }
                    }
                });

                updatePaginationUI();
            },
            error: function() {
                modal.loading(false);
                modal.alert('Failed to load chart data.', 'danger');
            }
        });
    }

    function updatePaginationUI() {
        const totalPages = Math.ceil(totalRecords / chartLimit);

        $('#pageInfo').text(`Graph ${currentPage} of ${totalPages}`);

        $('#prevPage').prop('disabled', currentPage === 1);
        $('#nextPage').prop('disabled', currentPage === totalPages || totalPages === 0);
    }

    $(document).on('click', '#nextPage', function () {
        currentPage++;
        renderSellThroughChart(currentPage);
    });

    $(document).on('click', '#prevPage', function () {
        if (currentPage > 1) {
            currentPage--;
            renderSellThroughChart(currentPage);
        }
    });

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
        let selectedSource = $('#dataSource').val();
        let selectedYear = $('#year').val();
        let yearOption = $("#year option:selected");
        let selectedYearId = yearOption.data("year");
        let selectedMonthStart = $('#monthFrom').val();
        let selectedMonthEnd = $('#monthTo').val();
        let selectedSalesGroup = $('#salesGroup').val();
        let selectedSalesGroupText = $('#salesGroup option:selected').text();

        let selectedSubSalesGroup = $('#subGroup').val();
        let selectedType = $('input[name="filterType"]:checked').val();
        let selectedMeasure = $('input[name="measure"]:checked').val();
        let weekFromOption = $("#weekfrom option:selected");
        let selectedWeekStartDate = weekFromOption.data("start-date");
        let selectedWeekStart =  $('#weekfrom').val();
        let weekToOption = $("#weekto option:selected");
        let selectedWeekEndDate = weekToOption.data("end-date"); 
        let selectedWeekEnd =  $('#weekto').val();
        let selectedCategories = $('#category').val();
        //let selectedCategoriesText = $('#category option:selected').text();
        let selectedCategoriesText = $('#category option:selected').map(function() {
                    return $(this).text();
                }).get(); 
        let selectedBrandCategories = $('#brandCategory').val();
        //let selectedBrandCategoriesText = $('#brandCategory option:selected').text();
        let selectedBrandCategoriesText = $('#brandCategory option:selected').map(function() {
                    return $(this).text();
                }).get(); 
        let selectedSubBrandCategories = $('#brandSubCategory').val();
        //let selectedSubBrandCategoriesText = $('#brandSubCategory option:selected').text();
        let selectedSubBrandCategoriesText = $('#brandSubCategory option:selected').map(function() {
                    return $(this).text();
                }).get(); 
        let selectedDepartments = $('#itemDepartment').val();
        //let selectedDepartmentsText = $('#itemDepartment option:selected').text();
        let selectedDepartmentsText = $('#itemDepartment option:selected').map(function() {
                    return $(this).text();
                }).get(); 
        let selectedMerchs = $('#merchCategory').val();
        //let selectedMerchsText = $('#merchCategory option:selected').text();
        let selectedMerchsText = $('#merchCategory option:selected').map(function() {
                    return $(this).text();
                }).get(); 
        let postData = {
            source: selectedSource,
            brand_categories: selectedBrandCategories,
            brand_categories_text: selectedBrandCategoriesText,

            sub_brand_categories: selectedSubBrandCategories,
            sub_brand_categories_text: selectedSubBrandCategoriesText,

            categories: selectedCategories,
            categories_text: selectedCategoriesText,

            item_departments: selectedDepartments,
            item_departments_text: selectedDepartmentsText,

            merch_categories: selectedMerchs,
            merch_categories_text: selectedMerchsText,

            year: selectedYear,
            year_id: selectedYearId,
            month_start: selectedMonthStart,
            month_end: selectedMonthEnd,
            week_start: selectedWeekStart,
            week_end: selectedWeekEnd,
            week_start_date: selectedWeekStartDate,
            week_end_date: selectedWeekEndDate,
            sales_group: selectedSalesGroup,
            sales_group_text: normalize(selectedSalesGroupText),
            sub_sales_grouptype: selectedSubSalesGroup,
            search_value: searchValue,
            type: selectedType,
            measure: selectedMeasure,
            order_by: orderByField,
            order_dir: orderDir
        }
        let endpoint = action === 'exportPdf' ? 'by-brand-category-generate-pdf' : 'by-brand-category-generate-excel-ba';
        let url = `${base_url}sell-through/${endpoint}`; 

        $.ajax({
            url: url,
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(postData),
            xhrFields: {
                responseType: 'blob'
            },
            success: function(blob, status, xhr) {
                const cd = xhr.getResponseHeader('Content-Disposition');
                const match = cd && /filename="?([^"]+)"/.exec(cd);
                let rawName = match?.[1] ? decodeURIComponent(match[1]) : null;
                const filename = rawName
                    || (action === 'exportPdf'
                        ? 'Sell Through by Brand Category.pdf'
                        : 'Sell Through by Brand Category.xlsx');

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

        const end_time = new Date();
        const duration = formatDuration(start_time, end_time);

        const remarks = `
            Exported Successfully!
            <br>Start Time: ${formatReadableDate(start_time)}
            <br>End Time: ${formatReadableDate(end_time)}
            <br>Duration: ${duration}
        `;
        logActivity('Sell Through By Brand Category', action === 'exportPdf' ? 'Export PDF' : 'Export Excel', remarks, '-', null, null)
    }

     function normalize(val) {
        if (
            val === undefined ||
            val === null ||
            val === "" ||
            val === "0" ||
            (typeof val === "string" && val.toLowerCase().includes("please select"))
        ) {
            return null;
        }
        return val;
    }