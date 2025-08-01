    $(document).ready(function () {
        const currentWeek = getCurrentWeek();
        if (currentWeek) {
            $('#currentWeek').text(currentWeek.display);
        } else {
            $('#currentWeek').text('N/A');
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

            aJax.post(url, data, function(res) {
                let data2 = JSON.parse(res);
                if(data2.length > 0){
                    if(data2[0].code){ 
                        $("#ascName").val(data2[0].code+' - '+data2[0].asc_description);
                        $("#ascNameId").val(data2[0].asc_id);       
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
                        $("#storeNameId").val(data[0].id);      
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
    });

    $(document).on('click', '#clearButton', function () {
        $('#area').val('');
        $('#brandAmbassador').val('');
        $('#ascName').val('');
        $('#storeName').val('');    
        $('#areaId').val('');
        $('#brandAmbassadorId').val('');
        $('#ascNameId').val('');
        $('#storeNameId').val('');
        $('input[type="text"], input[type="number"]').val('');
        $('.btn-outline-light').removeClass('active');
        $('.main_all').addClass('active');
        $('select').val('').trigger('change');
        $('.table-empty').show();
        $('.hide-div').hide();

    });

    $(document).on('click', '#refreshButton', function () {
        const fields = [
            { input: '#area', target: '#areaId' },
            { input: '#ascName', target: '#ascNameId' },
            { input: '#brandAmbassador', target: '#brandAmbassadorId' },
            { input: '#storeName', target: '#storeNameId' }
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

        const area = $('#area').val();
        //const storeName = $('#storeName').val();


        if (!area) {
            modal.alert('Please select "Area" before filtering.', "warning");
            return;
        }

        if (counter >= 1) {
           // modal.loading(true);
            fetchData();
            $('.table-empty').hide();
            $('.data-graph').show();
            $('#table-skus').hide();
        }
        
    });     

    // Define months
    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    const dataValues = {
        salesReport: [],
        targetSales: [],
        PerAchieved: []
    };

    let chartInstances = [];

    function renderCharts() {
        chartInstances.forEach(chart => chart.destroy());
        chartInstances = [];
        $('#chartContainer').html('<canvas id="consolidatedChart"></canvas>');

        let ctx = document.getElementById("consolidatedChart").getContext("2d");

        let datasets = [
            {
                label: "Sales Report",
                backgroundColor: "#ffc107",
                borderColor: "#d39e00",
                borderWidth: 1,
                data: dataValues.salesReport
            },
            {
                label: "Target Sales",
                backgroundColor: "#990000",
                borderColor: "#770000",
                borderWidth: 1,
                data: dataValues.targetSales
            },
            {
                label: "% Achieved",
                backgroundColor: "#339933",
                borderColor: "#267326",
                borderWidth: 1,
                data: dataValues.PerAchieved
            }
        ];

        let consolidatedChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: months,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: "top"
                    },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.dataset.label + ": " + tooltipItem.raw;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: "Months",
                            font: { weight: "bold" }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: "Values",
                            font: { weight: "bold" }
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: "easeOutBounce"
                }
            }
        });

        chartInstances.push(consolidatedChart);
        modal.loading(false);
    }

    function fetchData(){

        let selectedArea = $('#areaId').val();
        let selectedAsc = $('#ascNameId').val();
        let selectedBaType = $('input[name="filterType"]:checked').val();
        let selectedBa = $('#brandAmbassadorId').val();
        let selectedStore = $('#storeNameId').val();
        let selectedBrands = $('#brands').val();   
        let selectedBrandCategories = $('#itemLabel').val();

        url2 = base_url + 'store/get-sales-performance-per-month';
        var data = {
            area : selectedArea,
            asc : selectedAsc,
            baType : selectedBaType,
            ba : selectedBa,
            store : selectedStore,
            brandCategories : selectedBrandCategories,
            brands : selectedBrands
        }
        aJax.post(url2, data, function (result) {
            var html = '';
            if (result.data.length > 0) {
                let salesData = result.data[0];

                dataValues.salesReport = [
                    salesData.amount_january, salesData.amount_february, salesData.amount_march,
                    salesData.amount_april, salesData.amount_may, salesData.amount_june,
                    salesData.amount_july, salesData.amount_august, salesData.amount_september,
                    salesData.amount_october, salesData.amount_november, salesData.amount_december
                ];
                
                dataValues.targetSales = [
                    salesData.target_sales_jan, salesData.target_sales_feb, salesData.target_sales_march,
                    salesData.target_sales_april, salesData.target_sales_may, salesData.target_sales_june,
                    salesData.target_sales_july, salesData.target_sales_august, salesData.target_sales_september,
                    salesData.target_sales_october, salesData.target_sales_november, salesData.target_sales_december
                ];
                
                dataValues.PerAchieved = [
                    salesData.achieved_january, salesData.achieved_february, salesData.achieved_march,
                    salesData.achieved_april, salesData.achieved_may, salesData.achieved_june,
                    salesData.achieved_july, salesData.achieved_august, salesData.achieved_september,
                    salesData.achieved_october, salesData.achieved_november, salesData.achieved_december
                ];

                $.each(result.data, function(x,y) {
                    if(session_role == 7 || session_role == 8 ){
                        html += '<tr><td style="background-color: #ebe6f3;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">LY Sell Out</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></td><td>-</td></tr>';
                    }else{
                        html += '<tr><td style="background-color: #ebe6f3;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">LY Sell Out</td><td>'+formatTwoDecimals(y.ly_sell_out_january || "0.00")+'</td><td>'+formatTwoDecimals(y.ly_sell_out_february || "0.00")+'</td><td>'+formatTwoDecimals(y.ly_sell_out_march || "0.00")+'</td><td>'+formatTwoDecimals(y.ly_sell_out_april || "0.00")+'</td><td>'+formatTwoDecimals(y.ly_sell_out_may || "0.00")+'</td><td>'+formatTwoDecimals(y.ly_sell_out_june || "0.00")+'</td><td>'+formatTwoDecimals(y.ly_sell_out_july || "0.00")+'</td><td>'+formatTwoDecimals(y.ly_sell_out_august || "0.00")+'</td><td>'+formatTwoDecimals(y.ly_sell_out_september || "0.00")+'</td><td>'+formatTwoDecimals(y.ly_sell_out_october || "0.00")+'</td><td>'+formatTwoDecimals(y.ly_sell_out_november || "0.00")+'</td><td>'+formatTwoDecimals(y.ly_sell_out_december || "0.00")+'</td><td>'+formatTwoDecimals(y.total_ly_sell_out || "0.00")+'</td></tr>';    
                    }
                    html += '<tr><td style="background-color: #ebe6f3;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">TY Sell Out</td><td>'+formatTwoDecimals(y.ty_sell_out_january || "0.00")+'</td><td>'+formatTwoDecimals(y.ty_sell_out_february || "0.00")+'</td><td>'+formatTwoDecimals(y.ty_sell_out_march || "0.00")+'</td><td>'+formatTwoDecimals(y.ty_sell_out_april || "0.00")+'</td><td>'+formatTwoDecimals(y.ty_sell_out_may || "0.00")+'</td><td>'+formatTwoDecimals(y.ty_sell_out_june || "0.00")+'</td><td>'+formatTwoDecimals(y.ty_sell_out_july || "0.00")+'</td><td>'+formatTwoDecimals(y.ty_sell_out_august || "0.00")+'</td><td>'+formatTwoDecimals(y.ty_sell_out_september || "0.00")+'</td><td>'+formatTwoDecimals(y.ty_sell_out_october || "0.00")+'</td><td>'+formatTwoDecimals(y.ty_sell_out_november || "0.00")+'</td><td>'+formatTwoDecimals(y.ty_sell_out_december || "0.00")+'</td><td>'+formatTwoDecimals(y.total_ty_sell_out || "0.00")+'</td></tr>';
                    html += '<tr><td style="background-color: #ffc107;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Sales Report</td><td>'+formatTwoDecimals(y.amount_january || "0.00")+'</td><td>'+formatTwoDecimals(y.amount_february || "0.00")+'</td><td>'+formatTwoDecimals(y.amount_march || "0.00")+'</td><td>'+formatTwoDecimals(y.amount_april || "0.00")+'</td><td>'+formatTwoDecimals(y.amount_may || "0.00")+'</td><td>'+formatTwoDecimals(y.amount_june || "0.00")+'</td><td>'+formatTwoDecimals(y.amount_july || "0.00")+'</td><td>'+formatTwoDecimals(y.amount_august || "0.00")+'</td><td>'+formatTwoDecimals(y.amount_september || "0.00")+'</td><td>'+formatTwoDecimals(y.amount_october || "0.00")+'</td><td>'+formatTwoDecimals(y.amount_november || "0.00")+'</td><td>'+formatTwoDecimals(y.amount_december || "0.00")+'</td><td>'+formatTwoDecimals(y.total_amount || "0.00")+'</td></tr>';
                    html += '<tr><td style="background-color: #990000;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Target Sales</td><td>'+formatTwoDecimals(y.target_sales_jan || "0.00")+'</td><td>'+formatTwoDecimals(y.target_sales_feb || "0.00")+'</td><td>'+formatTwoDecimals(y.target_sales_mar || "0.00")+'</td><td>'+formatTwoDecimals(y.target_sales_apr || "0.00")+'</td><td>'+formatTwoDecimals(y.target_sales_may || "0.00")+'</td><td>'+formatTwoDecimals(y.target_sales_jun || "0.00")+'</td><td>'+formatTwoDecimals(y.target_sales_jul || "0.00")+'</td><td>'+formatTwoDecimals(y.target_sales_aug || "0.00")+'</td><td>'+formatTwoDecimals(y.target_sales_sep || "0.00")+'</td><td>'+formatTwoDecimals(y.target_sales_oct || "0.00")+'</td><td>'+formatTwoDecimals(y.target_sales_nov || "0.00")+'</td><td>'+formatTwoDecimals(y.target_sales_dec || "0.00")+'</td><td>'+formatTwoDecimals(y.total_target || "0.00")+'</td></tr>';
                    html += '<tr><td style="background-color: #ebe6f3;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" class="labeltext">Balance To Target<span class="tooltip-text">FORMULA:<br>Target Sales - Sales Report</span></td><td>'+formatTwoDecimals(y.balance_to_target_jan || "0.00")+'</td><td>'+formatTwoDecimals(y.balance_to_target_feb || "0.00")+'</td><td>'+formatTwoDecimals(y.balance_to_target_mar || "0.00")+'</td><td>'+formatTwoDecimals(y.balance_to_target_apr || "0.00")+'</td><td>'+formatTwoDecimals(y.balance_to_target_may || "0.00")+'</td><td>'+formatTwoDecimals(y.balance_to_target_jun || "0.00")+'</td><td>'+formatTwoDecimals(y.balance_to_target_jul || "0.00")+'</td><td>'+formatTwoDecimals(y.balance_to_target_aug || "0.00")+'</td><td>'+formatTwoDecimals(y.balance_to_target_sep || "0.00")+'</td><td>'+formatTwoDecimals(y.balance_to_target_oct || "0.00")+'</td><td>'+formatTwoDecimals(y.balance_to_target_nov || "0.00")+'</td><td>'+formatTwoDecimals(y.balance_to_target_dec || "0.00")+'</td><td>'+formatTwoDecimals(y.total_balance_to_target || "0.00")+'</td></tr>';
                    if(session_role == 7 || session_role == 8 ){
                        html += '<tr><td style="background-color: #ebe6f3;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" class="labeltext">% Growth<span class="tooltip-text">FORMULA:<br>(TY Sell Out - LY Sell Out / LY Sell Out) * 100%</span></td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></td><td>-</td></tr>';
                    }else{
                        html += '<tr><td style="background-color: #ebe6f3;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" class="labeltext">% Growth<span class="tooltip-text">FORMULA:<br>(TY Sell Out - LY Sell Out / LY Sell Out) * 100%</span></td><td>'+formatTwoDecimals(y.growth_january || "0.00")+'</td><td>'+formatTwoDecimals(y.growth_february || "0.00")+'</td><td>'+formatTwoDecimals(y.growth_march || "0.00")+'</td><td>'+formatTwoDecimals(y.growth_april || "0.00")+'</td><td>'+formatTwoDecimals(y.growth_may || "0.00")+'</td><td>'+formatTwoDecimals(y.growth_june || "0.00")+'</td><td>'+formatTwoDecimals(y.growth_july || "0.00")+'</td><td>'+formatTwoDecimals(y.growth_august || "0.00")+'</td><td>'+formatTwoDecimals(y.growth_september || "0.00")+'</td><td>'+formatTwoDecimals(y.growth_october || "0.00")+'</td><td>'+formatTwoDecimals(y.growth_november || "0.00")+'</td><td>'+formatTwoDecimals(y.growth_december || "0.00")+'</td><td>-</td></tr>';   
                    }
                    html += '<tr><td style="background-color: #339933;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" class="labeltext">% Achieved<span class="tooltip-text">FORMULA:<br>Please check the foot note</span></td><td>'+formatTwoDecimals(y.achieved_january || "0.00")+'</td><td>'+formatTwoDecimals(y.achieved_february || "0.00")+'</td><td>'+formatTwoDecimals(y.achieved_march || "0.00")+'</td><td>'+formatTwoDecimals(y.achieved_april || "0.00")+'</td><td>'+formatTwoDecimals(y.achieved_may || "0.00")+'</td><td>'+formatTwoDecimals(y.achieved_june || "0.00")+'</td><td>'+formatTwoDecimals(y.achieved_july || "0.00")+'</td><td>'+formatTwoDecimals(y.achieved_august || "0.00")+'</td><td>'+formatTwoDecimals(y.achieved_september || "0.00")+'</td><td>'+formatTwoDecimals(y.achieved_october || "0.00")+'</td><td>'+formatTwoDecimals(y.achieved_november || "0.00")+'</td><td>'+formatTwoDecimals(y.achieved_december || "0.00")+'</td><td>-</td></tr>';
                });
            }else{
                    html += '<tr><td style="background-color: #ebe6f3;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">LY Sell Out</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td></td><td>-</td></tr>';
                    html += '<tr><td style="background-color: #ebe6f3;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">TY Sell Out</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td></td><td>-</td></tr>';
                    html += '<tr><td style="background-color: #ffc107;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Sales Report</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td></td><td>-</td></tr>';
                    html += '<tr><td style="background-color: #990000;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Target Sales</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td></td><td>-</td></tr>';
                    html += '<tr><td style="background-color: #ebe6f3;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" class="labeltext">Balance To Target<span class="tooltip-text">FORMULA:<br>Target Sales - Sales Report</span></td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td></td><td>-</td></tr>';
                    html += '<tr><td style="background-color: #ebe6f3;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" class="labeltext">% Growth<span class="tooltip-text">FORMULA:<br>(TY Sell Out - LY Sell Out / LY Sell Out) * 100%</span></td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td></td><td>-</td></tr>';
                    html += '<tr><td style="background-color: #339933;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" class="labeltext">% Achieved<span class="tooltip-text">FORMULA:<br>Please check the foot note</span></td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td></td><td>-</td></tr>';
            }
            $('.asc-dashboard-body').html(html);
            renderCharts();
        });
    }

    function checkOutput(ifEmpty, ifNotEmpty) {
        let selectedCoveredASC = $('input[name="coveredASC"]:checked').val();

        if(selectedCoveredASC){
            ifNotEmpty();
        }else{
            ifEmpty();
        }
    }

    function formatTwoDecimals(data) {
        if(data == "N/A"){
            return data;
        }
        return data ? Number(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : '0.00';
    }

    function handleAction(action) {
        modal.loading(true);
        let selectedArea = $('#areaId').val();
        let selectedAsc = $('#ascNameId').val();
        let selectedBaType = $('input[name="filterType"]:checked').val();
        let selectedBa = $('#brandAmbassadorId').val();
        let selectedStore = $('#storeNameId').val();
        let selectedBrands = $('#brands').val();   
        let selectedBrandCategories = $('#itemLabel').val();
        let areaMap = $('#area').val();
        let ascMap = $('#ascName').val();
        let baMap = $('#brandAmbassador').val();
        let storeMap = $('#storeName').val();
        let itemBrandMap = $('#brands').select2('data').map((item) => {
            return item.text
        });
        let brandLabelTypeMap = $('#itemLabel').select2('data').map((item) => {
            return item.text
        });

        postData = {
            area: selectedArea,
            asc: selectedAsc,
            baType: selectedBaType,
            ba: selectedBa,
            store: selectedStore,
            brands: selectedBrands,
            brandCategories: selectedBrandCategories,
            areaMap: areaMap,
            ascMap: ascMap,
            baMap: baMap,
            storeMap: storeMap,
            itemBrandMap: itemBrandMap,
            brandLabelTypeMap: brandLabelTypeMap
        }

        let endpoint = action === 'exportPdf' ? 'per-month-generate-pdf' : 'per-month-generate-excel';

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
                        ? 'Store Sales Performance per Month.pdf'
                        : 'Store Sales Performance per Month.xlsx');

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
        logActivity('Store Sales Performance per Month', action === 'exportPdf' ? 'Export PDF' : 'Export Excel', remarks, '-', null, null);
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

