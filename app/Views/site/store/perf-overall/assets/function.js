    $(document).ready(function() {

        const currentWeek = getCurrentWeek();
        if (currentWeek) {
            $('#currentWeek').text(currentWeek.display);
        } else {
            $('#currentWeek').text('N/A');
        }

        let highestYear = $("#year option:not(:first)").map(function () {
            return parseInt($(this).val());
        }).get().sort((a, b) => b - a)[0];

        if (highestYear) {
            $("#year").val(highestYear);
        }
        $('#itemLabel').select2({ placeholder: 'Select Brand Label Types' });
        $('#brands').select2({ placeholder: 'Select Brands' });
        autocomplete_field($("#area"), $("#areaId"), area, "description", "id", function(result) {
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
                    }else{
                        $("#ascName").val('');
                        $("#ascNameId").val('');
                    }             
                }else{
                    $("#ascName").val('');
                    $("#ascNameId").val('');
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
                if(parseInt($('#brandAmbassadorId').val()) === -5 || parseInt($('#brandAmbassadorId').val()) === -6){
                    $("#storeName").val('');
                    $("#storeNameId").val('');
                    return;
                }
                if(data.length > 0){
                    if(data[0].code){
                        $("#storeName").val(data[0].code+' - '+data[0].description);
                        $("#storeNameId").val(data[0].code);      
                    }else{
                        $("#storeName").val('');
                        $("#storeNameId").val('');
                    }           
                }else{
                    $("#storeName").val('');
                    $("#storeNameId").val('');
                } 
            })
        });

        autocomplete_field($("#storeName"), $("#storeNameId"), store_branch, "description", "id");
    
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
        $('input[name="filterType"][value="3"]').prop('checked', true);
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
                url: base_url + 'store/get-sales-overall-growth',
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
                    if(session_role == 7 || session_role == 8 ){
                        json.data = json.data.map(row => {
                            return {
                                ...row,
                                ly_scanned_data: '-',
                                growth: '-'
                            };
                        });
                    }
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
            columnDefs: [
                {
                     targets: [1, 2, 3],
                    orderable: false
                },
                {
                    targets: [0, 4, 5],
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

    function handleAction(action) {
        modal.loading(true);
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
        let searchValue = $('#top_performing_stores').DataTable().search();
        let textArea = $('#area').val();
        let textAsc = $('#ascName').val();
        let textBa = $('#brandAmbassador').val();
        let textStore = $('#storeName').val();
        let textBrandCategories = $('#itemLabel').select2('data').map((item) => {
            return item.text
        });
        let textBrands = $('#brands').select2('data').map((item) => {
            return item.text
        });
        let textMonthStart = $('#month option:selected').text();
        let textMonthEnd = $('#monthTo option:selected').text();
        
        let postData = {
            area : selectedArea,
            asc : selectedAsc,
            baType : selectedBaType,
            ba : selectedBa,
            store : selectedStore,
            brandCategories : selectedBrandCategories,
            brands : selectedBrands,
            year : selectedYear,
            monthStart : selectedMonthStart,
            monthEnd : selectedMonthEnd,
            searchValue : searchValue,
            textArea : textArea,
            textAsc : textAsc,
            textBa : textBa,
            textStore : textStore,
            textBrandCategories : textBrandCategories,
            textBrands : textBrands,
            textMonthStart : textMonthStart,
            textMonthEnd : textMonthEnd
        }
        console.log(postData, 'post data'); 
        // return;

        let endpoint = action === 'exportPdf' ? 'overall-growth-generate-pdf' : 'overall-growth-generate-excel';

        // let url = `${base_url}store/${endpoint}?${qs}`;
        let url = `${base_url}store/${endpoint}`;
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
                        ? 'Overall Stores Sales Growth.pdf'
                        : 'Overall Stores Sales Growth.xlsx');

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
        logActivity('Overall Store Sales Growth', action === 'exportPdf' ? 'Export PDF' : 'Export Excel', remarks, '-', null, null)

    }

    function getCalendarWeeks(year) {
        const weeks = [];

        // Start from the first Monday of the ISO week 1
        let date = new Date(year, 0, 4); // Jan 4 is always in the first ISO week
        const day = date.getDay();
        const diff = (day === 0 ? -6 : 1 - day); // move to Monday
        date.setDate(date.getDate() + diff);

        let weekNumber = 1;

        while (date.getFullYear() <= year || (date.getFullYear() === year + 1 && weekNumber < 54)) {
            const weekStart = new Date(date);
            const weekEnd = new Date(date);
            weekEnd.setDate(weekEnd.getDate() + 6);

            if (weekStart.getFullYear() > year && weekEnd.getFullYear() > year) break;

            weeks.push({
                id: weekNumber,
                display: `Week ${weekNumber} (${weekStart.toISOString().slice(0, 10)} - ${weekEnd.toISOString().slice(0, 10)})`,
                week: weekNumber++,
                start: weekStart.toISOString().slice(0, 10),
                end: weekEnd.toISOString().slice(0, 10),
            });

            date.setDate(date.getDate() + 7); // move to next Monday
        }

        return weeks;
    }

    function getCurrentWeek(year = new Date().getFullYear()) {
        const weeks = getCalendarWeeks(year);
        const today = new Date().toISOString().slice(0, 10);

        for (const week of weeks) {
            if (today >= week.start && today <= week.end) {
                return week;
            }
        }

        return null;
    }