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
                    $("#storeName").val('');
                    $("#storeNameId").val('');
                }  
            })
        });

        autocomplete_field($("#ascName"), $("#ascNameId"), asc, "description");

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
    });

    $(document).on('click', '#refreshButton', function () {
        const fields = [
            { input: '#year', target: '#year' },
            { input: '#area', target: '#areaId' },
            { input: '#ascName', target: '#ascNameId' }
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
            logActivity("Store Sales Performance per Area", "Refresh", "User refreshed store sales performance per area.", "", "", "" );
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
                { data: 'area_name' },
                { data: 'asc_name' },
                { data: 'ly_scanned_data' },
                { data: 'actual_sales', render: formatTwoDecimals },
                { data: 'target_sales' },
                { data: 'percent_ach' },
                { data: 'growth' },
                { data: 'balance_to_target', render: formatTwoDecimals },
                { data: 'target_per_remaining_days', render: formatNoDecimals }
            ].filter(Boolean),
            columnDefs: [
                {
                     targets: [1, 2, 3, 5, 8, 9],
                    orderable: false
                },
                {
                    targets: [0, 4, 6, 7],
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
        let selectedBrands = $('#brands').val();   
        let selectedYear = $('#year').val();
        let selectedMonthStart = $('#month').val();
        let selectedMonthEnd = $('#monthTo').val();
        let searchValue = $('#info_for_asc').DataTable().search(); 
        let textArea = $('#area').val();
        let textAsc = $('#ascName').val();
        let brandList = $('#brands').select2('data').map((item) => {
            return item.text
        });
        let textMonthStart = $('#month option:selected').text();
        let textMonthEnd = $('#monthTo option:selected').text();
        
        let postData = {
            area: selectedArea,
            asc: selectedAsc,
            baType: selectedBaType,
            brands: selectedBrands,
            year: selectedYear,
            monthStart: selectedMonthStart,
            monthEnd: selectedMonthEnd,
            searchValue: searchValue,
            textArea: textArea,
            textAsc: textAsc,
            brandList: brandList,
            textMonthStart: textMonthStart,
            textMonthEnd: textMonthEnd
        }

        let endpoint = action === 'exportPdf' ? 'per-area-generate-pdf' : 'per-area-generate-excel';

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
                        ? 'Store Sales Performance per Brand Ambassador.pdf'
                        : 'Store Sales Performance per Brand Ambassador.xlsx');

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
        logActivity('Store Sales Performance per Area', action === 'exportPdf' ? 'Export PDF' : 'Export Excel', remarks, '-', null, null);
    }