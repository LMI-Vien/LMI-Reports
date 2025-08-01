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
        itemClassi.forEach(function (item) {
          $('#itemClass').append(
            $('<option>', {
              value: item.id,
              text: item.item_class_description
            })
          );
        });

        $('#itemClass').select2({ placeholder: 'Please Select...' });
        autocomplete_field($("#itemLabelCat"), $("#itemLabelCatId"), traccItemClassi, "item_class_code");
        $('#inventoryStatus').select2({ placeholder: 'Please Select...' });
    });

    $(document).on('click', '#clearButton', function () {
        $('input[type="text"], input[type="number"], input[type="date"]').val('');
        $('input[type="checkbox"]').prop('checked', false);
        $('select').not('#year').prop('selectedIndex', 0);
        $('#itemLabelCatId').val('');
        $('.select2').val(null).trigger('change');
        let highestYear = $("#year option:not(:first)").map(function () {
            return parseInt($(this).val());
        }).get().sort((a, b) => b - a)[0];

        if (highestYear) {
            $("#year").val(highestYear);
        }
        $('.hide-div').hide();
        $('.table-empty').show();
    });

    $(document).on('click', '#refreshButton', function () {
        const fields = [
            { input: '#ItemClass', target: '#ItemClass' },
            { input: '#inventoryStatus', target: '#inventoryStatus' }
        ];

        if($('#itemLabelCat').val() == ""){
            $('#itemLabelCatId').val('');
        }
        let counter = 0;

        fields.forEach(({ input, target }) => {
            const val = $(input).val();
            const hasValue = Array.isArray(val) ? val.length > 0 : val;
            if (!hasValue || val === undefined) {
                $(target).val('');
            } else {
                counter++;
                if ($(input).is('select') && !$(input).hasClass("select2-hidden-accessible")) {
                    $(input).select2();
                }
            }
        });

        const yearFilter = $('#year').val();
        const weekFromFilter = $('#week_from').val();
        const weekToFilter = $('#week_to').val();
        const invStatusFilter = $('#inventoryStatus').val();
        const dataSource = $('#dataSource').val();

        if (!yearFilter && !weekFromFilter && !weekToFilter && invStatusFilter.length === 0) {
            modal.alert('Please select both "Year", "Week Range" and Inventory Status" before filtering.', "warning");
            return;
        }

        if (!yearFilter || yearFilter.length === 0) {
            modal.alert('Please select "Year" before filtering.', "warning");
            return;
        }

        if (!weekFromFilter && !weekToFilter) {
            modal.alert('Please select both "Week From" and "Week To" before filtering.', "warning");
            return;
        }

        if (!weekFromFilter || weekFromFilter.length === 0) {
            modal.alert('Please select "Week From" before filtering.', "warning");
            return;
        }

        if (!weekToFilter || weekToFilter.length === 0) {
            modal.alert('Please select "Week To" before filtering.', "warning");
            return;
        }

        if (!invStatusFilter || invStatusFilter.length === 0) {
            modal.alert('Please select "Inventory Status" before filtering.', "warning");
            return;
        }

        const fromWeek = parseInt(weekFromFilter);
        const toWeek = parseInt(weekToFilter);

        if (fromWeek > toWeek) {
            modal.alert('Invalid Week Range!', "warning");
            return;
        }

        const weekDifference = toWeek - fromWeek + 1;
        if (weekDifference > 13) {
            modal.alert('You can only select a maximum range of 13 weeks.', "warning");
            return;
        }

        const dataSourceText = $('#dataSource').find('option:selected').text();
        const yearFilterText = $('#year').find('option:selected').text();
        $('#sourceDate').text(dataSourceText + ' - ' + yearFilterText + ' week: ' + weekFromFilter + ' - ' + weekToFilter);

        if (counter >= 1) {
            fetchData();
            $('.table-empty').hide();
        }
    });

    function fetchData() {
        let selectedItemClass = $('#itemClass').val();
        let selectedItemCat = $('#itemLabelCat').val();
        let selectedInventoryStatus = $('#inventoryStatus').val();
        let selectedYear = $('#year').val();
        let selectedWeekFrom = $('#week_from').val();
        let selectedWeekTo = $('#week_to').val();
        let selectedSource = $('#dataSource').val();

        if (!selectedInventoryStatus || selectedInventoryStatus.length === 0) {
            $('.table-empty').show();
            $('.hide-div.card').hide();
            return;
        }

        $('.table-empty').hide();

        $('.hide-div').first().show();

        let tables = [
            { id: "#table_slowMoving", type: "slowMoving" },
            { id: "#table_overStock", type: "overStock" },
            { id: "#table_npd", type: "npd" },
            { id: "#table_hero", type: "hero" }
        ];
        $('.hide-div.card').hide();
        tables.forEach(table => {
            if (selectedInventoryStatus.includes(table.type)) {
                $(table.id).closest('.hide-div.card').show();
                initializeTable(
                    table.id,
                    table.type,
                    selectedItemClass,
                    selectedItemCat,
                    selectedYear,
                    selectedWeekFrom,
                    selectedWeekTo,
                    selectedSource
                );
            }
        });
    }

    function initializeTable(tableId, type, selectedItemClass, selectedItemCat, selectedYear, selectedWeekFrom, selectedWeekTo, selectedSource) {
         if ($.fn.DataTable.isDataTable($(tableId))) {
            let existingTable = $(tableId).DataTable();
            existingTable.clear().destroy();
        }
        const weekFrom = parseInt(selectedWeekFrom, 10);
        const weekTo = parseInt(selectedWeekTo, 10);

        const $headerRow = $(`${tableId}_headers`);
        $headerRow.find("th.week-column").remove();

        const dynamicColumns = [];

        if (type !== 'hero') {
            colspan = ((weekTo - weekFrom + 1) * 2) + 3;
            $('#table_slowMoving_TH').attr('colspan', colspan);
            $('#table_overStock_TH').attr('colspan', colspan);
            $('#table_npd_TH').attr('colspan', colspan);

            if (!isNaN(weekFrom) && !isNaN(weekTo) && weekFrom <= weekTo) {
                for (let week = weekTo; week >= weekFrom; week--) {
                    $headerRow.append(`<th class="tbl-title-field week-column">Week ${week}</th>`);
                    $headerRow.append(`<th class="tbl-title-field week-column">Item Class Week ${week}</th>`);

                    dynamicColumns.push({
                        data: `week_${week}`,
                        title: `Week ${week}`,
                        defaultContent: '-',
                        render: function (data) {
                            return formatNumberWithCommas(data);
                        }
                    });
                    dynamicColumns.push({
                        data: `item_class_week_${week}`,
                        title: `Item Class`,
                        defaultContent: '-'
                    });    
                }
            }
        }

        const baseColumns = [
            { data: 'item', title: 'SKU Code' },
            { data: 'item_name', title: 'SKU Name' },
            { data: 'itmcde', title: 'LMI/RGDI Code' }
        ];

        $(tableId).DataTable({
            destroy: true,
            ajax: {
                url: base_url + 'stocks/get-data-week-all-store',
                type: 'POST',
                data: function (d) {
                    d.itemClass = selectedItemClass || null;
                    d.itemCategory = selectedItemCat || null;
                    d.year = selectedYear || null;
                    d.weekFrom = selectedWeekFrom || null;
                    d.weekTo = selectedWeekTo || null;
                    d.source = selectedSource || null;
                    d.type = type;
                    d.limit = d.length;
                    d.offset = d.start;
                },
                dataSrc: json => json.data.length ? json.data : []
            },
            columns: baseColumns.concat(dynamicColumns),
            order: type !== 'hero' && weekTo
                ? [[baseColumns.length, 'desc']]
                : [[2, 'desc']], 
            columnDefs: [
                {
                    targets: [0, 1],
                    orderable: false
                }
            ],
            pagingType: "full_numbers",
            pageLength: 10,
            processing: true,
            serverSide: true,
            searching: true,
            colReorder: true,
            lengthChange: false
        });
    }

    function formatTwoDecimals(data) {
        return data ? Number(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : '0.00';
    }

    function formatNumberWithCommas(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function paramsToJSON(params) {
        const json = {};

        for (const [key, value] of params.entries()) {
            const keys = key.match(/[^\[\]]+/g); 

            if (keys.length === 1) {
                json[keys[0]] = value;
            } else {
                let temp = json;
                for (let i = 0; i < keys.length; i++) {
                    const k = keys[i];
 
                    if (i === keys.length - 1) {
                        temp[k] = value;
                    } else { 
                        if (!temp[k]) {
                            temp[k] = /^\d+$/.test(keys[i + 1]) ? [] : {};
                        }
                        temp = temp[k];
                    }
                }
            }
        }

        return json;
    }

    function handleAction(action) {
        modal.loading(true);
        let selectedItemClass     = $('#itemClass').val();
        let selectedItemClassText = $('#itemClass').select2('data').map(function(item) {
            return item.text;
        });
        let selectedItemCategory  = $('#itemLabelCat').val();
        let selectedType          = $('#inventoryStatus').val();
        let typeList = $('#inventoryStatus').select2('data').map((item) => {
            return item.text
        });
        let selectedYear          = $('#year').val();
        let selectedYearText      = $('#year option:selected').text();
        let selectedWeekFrom      = $('#week_from').val();
        let selectedWeekTo        = $('#week_to').val();
        let selectedDataSource    = $('#dataSource').val();
        var tableSlowMoving = $('input[aria-controls="table_slowMoving"]').val() || '';
        var tableHero = $('input[aria-controls="table_hero"]').val() || '';
        var tableNpd = $('input[aria-controls="table_npd"]').val() || '';
        var tableOverStock = $('input[aria-controls="table_overStock"]').val() || '';

        let params = new URLSearchParams();
        params.append('itemClass',    selectedItemClass   || '');
        params.append('itemCategory', selectedItemCategory|| '');
        params.append('type',         Array.isArray(selectedType) ? selectedType.join(',') : (selectedType||''));
        params.append('year',         selectedYear       || '');
        params.append('weekFrom',     selectedWeekFrom   || '');
        params.append('weekTo',       selectedWeekTo     || '');
        params.append('source',       selectedDataSource || '');
        params.append('itmclstxt',    selectedItemClassText || '');
        params.append('yrtxt',        selectedYearText || '');
        params.append('typeList',     typeList || '');
        params.append('search',       '');
        params.append('table_slowMoving', tableSlowMoving.trim());
        params.append('table_hero', tableHero.trim());
        params.append('table_npd', tableNpd.trim());
        params.append('table_overStock', tableOverStock.trim());

        let tableTypes = ['slowMoving','overStock','npd','hero'];
        let tableCount = 0;
        let firstOrderColumn, firstOrderDir, firstColumnsDef;

        tableTypes.forEach((type) => {
            let tableId = `#table_${type}`;
            if ($(tableId).is(':visible')) {
                let dt = $(tableId).DataTable();
                let pageInfo = dt.page.info();
                let orderArr = dt.order()[0];
                let cols     = dt.settings().init().columns;

                if (tableCount === 0) {
                    firstOrderColumn = orderArr[0];
                    firstOrderDir    = orderArr[1];
                    firstColumnsDef  = JSON.parse(JSON.stringify(cols));
                }

                params.append(`typeList[${tableCount}]`, type);
                params.append(`limit[${tableCount}]`,  pageInfo.length);
                params.append(`offset[${tableCount}]`, pageInfo.start);
                params.append(`order[${tableCount}][column]`, orderArr[0]);
                params.append(`order[${tableCount}][dir]`,    orderArr[1]);

                cols.forEach((colObj, colIndex) => {
                    params.append(`columns[${tableCount}][${colIndex}][data]`, colObj.data);
                });

                tableCount++;
            }
        });

        if (tableCount === 0) {
            modal.alert('No table is currently visible for export.', 'warning');
            modal.loading(false);
            return;
        }

        if (tableCount === 1) {
            params.append('order[0][column]', firstOrderColumn);
            params.append('order[0][dir]',    firstOrderDir);

            firstColumnsDef.forEach((colObj, colIndex) => {
                params.append(`columns[${colIndex}][data]`, colObj.data);
            });
        }

        let endpoint = (action === 'exportPdf')
                    ? 'stocks-week-all-store-generate-pdf'
                    : 'stocks-week-all-store-generate-excel';

        let url = `${base_url}stocks/${endpoint}`;

        const jsonData = paramsToJSON(params);
        $.ajax({
            url: url,
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(jsonData),
            xhrFields: {
                responseType: 'blob'
            },
            success: function(blob, status, xhr) {
                const cd = xhr.getResponseHeader('Content-Disposition');
                const match = cd && /filename="?([^"]+)"/.exec(cd);
                let rawName = match?.[1] ? decodeURIComponent(match[1]) : null;
                const filename = rawName
                    || (action === 'exportPdf'
                        ? 'Week by Week Stock Data of All Stores.pdf'
                        : 'Week by Week Stock Data of All Stores.xlsx');

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
        logActivity('Week by Week Stock Data of all Stores', (action === 'exportPdf') ? 'Export PDF' : 'Export Excel', remarks, '-', null, null);
    }


    function updateWeeks(id) {
        let selectedYear = $('#year option:selected').text()
        populateDropdown(id, getCalendarWeeks(selectedYear), 'display', 'id');
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

    const populateDropdown = (selected_class, result, textKey = 'name', valueKey = 'id') => {
        let html = '<option id="default_val" value="">Select</option>';
        
        if (result && result.length > 0) {
            result.forEach((item) => {
                html += `<option value="${item[valueKey]}">${item[textKey]}</option>`;
            });
        }
        
        $('#' + selected_class).html(html);
    };

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