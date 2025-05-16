    $(document).ready(function () {
        $('#itemLabel').select2({ placeholder: 'Select Brand Label Types' });
        $('#brands').select2({ placeholder: 'Select Brands' });
        autocomplete_field($("#area"), $("#areaId"), area, "description", "id", function(result) {
            //let url = url;
            let data = {
                event: "list",
                select: "a.id, a.description, asc.description as asc_description, asc.id as asc_id",
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
                $("#ascName").val(data[0].asc_description);
                $("#ascNameId").val(data[0].asc_id);
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
                let data = JSON.parse(res)[0];
                if(data){
                    alert(data.code);
                    $("#storeName").val(data.description);
                    $("#storeNameId").val(data.code);
                }
            })
        });

        autocomplete_field($("#storeName"), $("#storeNameId"), store_branch, "description", "id");
    });

    $(document).on('click', '#refreshButton', function () {
        const fields = [
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
        if (counter >= 1) {
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


    //old backup
    // function renderCharts() {
    //     chartInstances.forEach(chart => chart.destroy());
    //     chartInstances = [];
    //     $('#chartContainer').html('');

    //     months.forEach((month, index) => {
    //         let chartHTML = `
    //             <div class="col-md-3 mb-4">
    //                 <div class="card p-2">
    //                     <h6 class="text-center card-title">${month}</h6>
    //                     <canvas id="chart${index}"></canvas>
    //                 </div>
    //             </div>
    //         `;
    //         $('#chartContainer').append(chartHTML);
    //         let ctx = document.getElementById(`chart${index}`).getContext('2d');

    //         let newChart = new Chart(ctx, {
    //             type: 'bar',
    //             data: {
    //                 labels: ["Sales Report", "Target Sales", "% Achieved"],
    //                 datasets: [{
    //                     label: month,
    //                     backgroundColor: ["#ffc107", "#990000", "#339933"],
    //                     data: [dataValues.salesReport[index], dataValues.targetSales[index], dataValues.PerAchieved[index]]
    //                 }]
    //             },
    //             options: {
    //                 responsive: true,
    //                 animation: true,
    //                 plugins: {
    //                     legend: { display: false } 
    //                 },
    //                 scales: {
    //                     y: { beginAtZero: true }
    //                 }
    //             }
    //         });
    //         chartInstances.push(newChart);
    //     });
    // }

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
    }

    function fetchData(){

        let selectedASC = $('#asc_id').val();
        let selectedArea = $('#area_id').val();
        let selectedBrand = $('#brand_id').val();
        let selectedYear = $('#year').val();
        let selectedStore = $('#store_id').val();
        let selectedBa = $('#ba_id').val();
        
        url = base_url + 'store/get-sales-performance-per-month';
        var data = {
            asc : selectedASC,
            brand : selectedBrand,
            year : selectedYear,
            store : selectedStore,
            ba : selectedBa,
            area : selectedArea
        }
        aJax.post(url, data, function (result) {
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
                    salesData.target_sales_january, salesData.target_sales_february, salesData.target_sales_march,
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
                    html += '<tr><td style="background-color: #ebe6f3;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">LY Sell Out</td><td>'+formatTwoDecimals(y.net_sales_january || "0.00")+'</td><td>'+formatTwoDecimals(y.net_sales_february || "0.00")+'</td><td>'+formatTwoDecimals(y.net_sales_march || "0.00")+'</td><td>'+formatTwoDecimals(y.net_sales_april || "0.00")+'</td><td>'+formatTwoDecimals(y.net_sales_may || "0.00")+'</td><td>'+formatTwoDecimals(y.net_sales_june || "0.00")+'</td><td>'+formatTwoDecimals(y.net_sales_july || "0.00")+'</td><td>'+formatTwoDecimals(y.net_sales_august || "0.00")+'</td><td>'+formatTwoDecimals(y.net_sales_september || "0.00")+'</td><td>'+formatTwoDecimals(y.net_sales_october || "0.00")+'</td><td>'+formatTwoDecimals(y.net_sales_november || "0.00")+'</td><td>'+formatTwoDecimals(y.net_sales_december || "0.00")+'</td></tr>';
                    html += '<tr><td style="background-color: #ffc107;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Sales Report</td><td>'+formatTwoDecimals(y.amount_january || "0.00")+'</td><td>'+formatTwoDecimals(y.amount_february || "0.00")+'</td><td>'+formatTwoDecimals(y.amount_march || "0.00")+'</td><td>'+formatTwoDecimals(y.amount_april || "0.00")+'</td><td>'+formatTwoDecimals(y.amount_may || "0.00")+'</td><td>'+formatTwoDecimals(y.amount_june || "0.00")+'</td><td>'+formatTwoDecimals(y.amount_july || "0.00")+'</td><td>'+formatTwoDecimals(y.amount_august || "0.00")+'</td><td>'+formatTwoDecimals(y.amount_september || "0.00")+'</td><td>'+formatTwoDecimals(y.amount_october || "0.00")+'</td><td>'+formatTwoDecimals(y.amount_november || "0.00")+'</td><td>'+formatTwoDecimals(y.amount_december || "0.00")+'</td></tr>';
                    html += '<tr><td style="background-color: #990000;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Target Sales</td><td>'+formatTwoDecimals(y.target_sales_january || "0.00")+'</td><td>'+formatTwoDecimals(y.target_sales_february || "0.00")+'</td><td>'+formatTwoDecimals(y.target_sales_march || "0.00")+'</td><td>'+formatTwoDecimals(y.target_sales_april || "0.00")+'</td><td>'+formatTwoDecimals(y.target_sales_may || "0.00")+'</td><td>'+formatTwoDecimals(y.target_sales_june || "0.00")+'</td><td>'+formatTwoDecimals(y.target_sales_july || "0.00")+'</td><td>'+formatTwoDecimals(y.target_sales_august || "0.00")+'</td><td>'+formatTwoDecimals(y.target_sales_september || "0.00")+'</td><td>'+formatTwoDecimals(y.target_sales_october || "0.00")+'</td><td>'+formatTwoDecimals(y.target_sales_november || "0.00")+'</td><td>'+formatTwoDecimals(y.target_sales_december || "0.00")+'</td></tr>';
                    html += '<tr><td style="background-color: #ebe6f3;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">% Growth</td><td>'+formatTwoDecimals(y.growth_january || "0.00")+'</td><td>'+formatTwoDecimals(y.growth_february || "0.00")+'</td><td>'+formatTwoDecimals(y.growth_march || "0.00")+'</td><td>'+formatTwoDecimals(y.growth_april || "0.00")+'</td><td>'+formatTwoDecimals(y.growth_may || "0.00")+'</td><td>'+formatTwoDecimals(y.growth_june || "0.00")+'</td><td>'+formatTwoDecimals(y.growth_july || "0.00")+'</td><td>'+formatTwoDecimals(y.growth_august || "0.00")+'</td><td>'+formatTwoDecimals(y.growth_september || "0.00")+'</td><td>'+formatTwoDecimals(y.growth_october || "0.00")+'</td><td>'+formatTwoDecimals(y.growth_november || "0.00")+'</td><td>'+formatTwoDecimals(y.growth_december || "0.00")+'</td></tr>';
                    html += '<tr><td style="background-color: #339933;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">% Achieved</td><td>'+formatTwoDecimals(y.achieved_january || "0.00")+'</td><td>'+formatTwoDecimals(y.achieved_february || "0.00")+'</td><td>'+formatTwoDecimals(y.achieved_march || "0.00")+'</td><td>'+formatTwoDecimals(y.achieved_april || "0.00")+'</td><td>'+formatTwoDecimals(y.achieved_may || "0.00")+'</td><td>'+formatTwoDecimals(y.achieved_june || "0.00")+'</td><td>'+formatTwoDecimals(y.achieved_july || "0.00")+'</td><td>'+formatTwoDecimals(y.achieved_august || "0.00")+'</td><td>'+formatTwoDecimals(y.achieved_september || "0.00")+'</td><td>'+formatTwoDecimals(y.achieved_october || "0.00")+'</td><td>'+formatTwoDecimals(y.achieved_november || "0.00")+'</td><td>'+formatTwoDecimals(y.achieved_december || "0.00")+'</td></tr>';

                });formatTwoDecimals
            }else{
                    html += '<tr><td style="background-color: #ebe6f3;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">LY Sell Out</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td></tr>';
                    html += '<tr><td style="background-color: #ffc107;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Sales Report</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td></tr>';
                    html += '<tr><td style="background-color: #990000;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Target Sales</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td></tr>';
                    html += '<tr><td style="background-color: #ebe6f3;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">% Growth</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td></tr>';
                    html += '<tr><td style="background-color: #339933;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">% Achieved</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td></tr>';
            }
            $('.asc-dashboard-body').html(html);
            renderCharts();
        });
    }

    function fetchDataTable() {
        let selectedASC = $('#ascName').val();
        let selectedArea = $('#area').val();
        let selectedBrand = $('#brand').val();
        let selectedYear = $('#year').val();
        let selectedStore = $('#store_id').val();
        let selectedBA = $('#ba').val();
        let withBA = $('input[name="coveredASC"]:checked').val();

        let tables = [
            { id: "#slowMovingTable", type: "slowMoving" },
            { id: "#overstockTable", type: "overStock" },
            { id: "#npdTable", type: "npd" },
            { id: "#heroTable", type: "hero" }
        ];

        tables.forEach(table => {
            initializeTable(table.id, table.type, selectedASC, selectedArea, selectedStore, selectedBrand, selectedBA, selectedYear, withBA);
        });
    }

    function initializeTable(tableId, type, selectedASC, selectedArea, selectedStore, selectedBrand, selectedBA, selectedYear, withBA) {

        $(tableId).DataTable({
            destroy: true,
            ajax: {
                url: base_url + 'store/get-sales-performance-per-table',
                type: 'POST',
                data: function (d) {

                    d.asc = selectedASC === "0" ? null : selectedASC;
                    d.area = selectedArea === "0" ? null : selectedArea;
                    d.brand = selectedBrand === "0" ? null : selectedBrand;
                    d.store = selectedStore === "0" ? null : selectedStore;
                    d.ba = selectedBA === "0" ? null : selectedBA;
                    d.year = selectedYear === "0" ? null : selectedYear;
                    d.withba = withBA;
                    d.trade_type = type;
                    d.limit = d.length;
                    d.offset = d.start;
                },
                dataSrc: function(json) {
                    return json.data.length ? json.data : [];
                }
            },
            columns: [
                { data: 'item_name' },
                type !== 'hero' ? { data: 'sum_total_qty' } : null,
                type !== 'hero' ? { data: 'week_1' } : null,
                type !== 'hero' ? { data: 'week_2' } : null,
                type !== 'hero' ? { data: 'week_3' } : null
            ].filter(Boolean),
            pagingType: "full_numbers",
            pageLength: 10,
            processing: true,
            serverSide: true,
            searching: false,
            colReorder: true,
            lengthChange: false
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
        return data ? Number(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : '0.00';
    }

    function handleAction(action) {
        let selectedASC = $('#asc_id').val() || '0';
        let selectedArea = $('#area_id').val() || '0';
        let selectedBrand = $('#brand_id').val() || '0';
        let selectedYear = $('#year').val() || '0';
        let selectedStore = $('#store_id').val() || '0';
        let selectedBa = $('#ba_id').val() || '0';
        let withba = $("input[name='coveredASC']:checked").val();
        let printData = [];

        let tables = [
            { id: "#slowMovingTable", type: "slowMoving" },
            { id: "#overstockTable", type: "overStock" },
            { id: "#npdTable", type: "npd" },
            { id: "#heroTable", type: "hero" }
        ];

        let url = base_url + 'trade-dashboard/generate-' + (action === 'exportPDF' ? 'pdf' : 'excel') + '-asc_dashboard?'
            + 'asc=' + encodeURIComponent(selectedASC)
            + '&area=' + encodeURIComponent(selectedArea)
            + '&brand=' + encodeURIComponent(selectedBrand)
            + '&year=' + encodeURIComponent(selectedYear)
            + '&store=' + encodeURIComponent(selectedStore)
            + '&ba=' + encodeURIComponent(selectedBa)
            + '&withba=' + encodeURIComponent(withba);

        // window.open(url, '_blank');
        let iframe = document.createElement('iframe');
        iframe.style.display = "none";
        iframe.src = url;
        document.body.appendChild(iframe);

        // if (action === 'exportPDF') {
        //     checkOutput(
        //         () => {
        //             let selectedASC = $('#asc_id').val();
        //             let selectedArea = $('#area_id').val();
        //             let selectedBrand = $('#brand_id').val();
        //             let selectedYear = $('#year').val();
        //             let selectedStore = $('#store_id').val();
        //             let selectedBa = $('#ba_id').val();
        //             let link = `FALSE-${selectedASC}-${selectedArea}-${selectedBrand}-${selectedYear}-${selectedStore}-${selectedBa}`;
        //             window.open(`<?= base_url()?>trade-dashboard/asc-dashboard-1-view/${link}`, '_blank');
        //         },
        //         () => {
        //             let selectedASC = $('#ascName').val();
        //             let selectedArea = $('#area').val();
        //             let selectedBrand = $('#brand').val();
        //             let selectedYear = $('#year').val();
        //             let selectedStore = $('#store_id').val();
        //             let selectedBA = $('#ba').val();
        //             let withBA = $('input[name="coveredASC"]:checked').val();
        //             let link = `TRUE-${selectedASC}-${selectedArea}-${selectedBrand}-${selectedYear}-${selectedStore}-${selectedBA}-${withBA}`;
        //             window.open(`<?= base_url()?>trade-dashboard/asc-dashboard-1-view/${link}`, '_blank');
        //         }
        //     );
        // } else if (action === 'export') {
        //     checkOutput(
        //         prepareExport, 
        //         prepareExport1
        //     );
        // } else {
        //     alert('wtf are u doing?')
        // }
    }

    function initializeData(tableId, type, selectedASC, selectedArea, selectedStore, selectedBrand, selectedBa, selectedYear, withba, url) {
        data = {
            asc: selectedASC === "0" ? null : selectedASC,
            area: selectedArea === "0" ? null : selectedArea,
            brand: selectedBrand === "0" ? null: selectedBrand,
            store: selectedStore === "0" ? null: selectedStore,
            ba: selectedBa === "0" ? null: selectedBa,
            year: selectedYear === "0" ? null: selectedYear,
            withba: withba,
            trade_type: type,
            limit: 10,
            offset: 0,
        };

        return new Promise((resolve, reject) => {
            aJax.get(url, data, function(res) {
                resolve(res);
            })
        })
    }

    function prepareExport() {
        let selectedASC = $('#ascName').val();
        let selectedBrand = $('#brand').val();
        let selectedYear = $('#year').val();
        let selectedStore = $('#store_id').val();
        let selectedBA = $('#ba').val();
        let selectedArea = $('#area').val();

        fetchTradeDashboardData({
            selectedASC, 
            selectedBrand, 
            selectedYear, 
            selectedStore, 
            selectedBA, 
            selectedArea, 
            length: 10,
            start: 0,
            onSuccess: function(result) {
                const valuesData = [];
                if (result) {
                    let salesData = result[0];

                    valuesData.push({
                        "Month" : "January", 
                        "LY Sell Out" : salesData.net_sales_january, 
                        "Sales Report" : salesData.amount_january, 
                        "Target Sales" : salesData.target_sales_january, 
                        "Growth" : salesData.growth_january, 
                        "Achieved" : salesData.achieved_january
                    });
                    valuesData.push({
                        "Month" : "February", 
                        "LY Sell Out" : salesData.net_sales_february, 
                        "Sales Report" : salesData.amount_february, 
                        "Target Sales" : salesData.target_sales_february, 
                        "Growth" : salesData.growth_february, 
                        "Achieved" : salesData.achieved_february
                    })
                    valuesData.push({
                        "Month" : "March", 
                        "LY Sell Out" : salesData.net_sales_march, 
                        "Sales Report" : salesData.amount_march, 
                        "Target Sales" : salesData.target_sales_march, 
                        "Growth" : salesData.growth_march, 
                        "Achieved" : salesData.achieved_march
                    })
                    valuesData.push({
                        "Month" : "April", 
                        "LY Sell Out" : salesData.net_sales_april, 
                        "Sales Report" : salesData.amount_april, 
                        "Target Sales" : salesData.target_sales_april, 
                        "Growth" : salesData.growth_april, 
                        "Achieved" : salesData.achieved_april
                    })
                    valuesData.push({
                        "Month" : "May", 
                        "LY Sell Out" : salesData.net_sales_may, 
                        "Sales Report" : salesData.amount_may, 
                        "Target Sales" : salesData.target_sales_may, 
                        "Growth" : salesData.growth_may, 
                        "Achieved" : salesData.achieved_may
                    })
                    valuesData.push({
                        "Month" : "June", 
                        "LY Sell Out" : salesData.net_sales_june, 
                        "Sales Report" : salesData.amount_june, 
                        "Target Sales" : salesData.target_sales_june, 
                        "Growth" : salesData.growth_june, 
                        "Achieved" : salesData.achieved_june
                    })
                    valuesData.push({
                        "Month" : "July", 
                        "LY Sell Out" : salesData.net_sales_july, 
                        "Sales Report" : salesData.amount_july, 
                        "Target Sales" : salesData.target_sales_july, 
                        "Growth" : salesData.growth_july, 
                        "Achieved" : salesData.achieved_july
                    })
                    valuesData.push({
                        "Month" : "August", 
                        "LY Sell Out" : salesData.net_sales_august, 
                        "Sales Report" : salesData.amount_august, 
                        "Target Sales" : salesData.target_sales_august, 
                        "Growth" : salesData.growth_august, 
                        "Achieved" : salesData.achieved_august
                    })
                    valuesData.push({
                        "Month" : "September", 
                        "LY Sell Out" : salesData.net_sales_september, 
                        "Sales Report" : salesData.amount_september, 
                        "Target Sales" : salesData.target_sales_september, 
                        "Growth" : salesData.growth_september, 
                        "Achieved" : salesData.achieved_september
                    })
                    valuesData.push({
                        "Month" : "October", 
                        "LY Sell Out" : salesData.net_sales_october, 
                        "Sales Report" : salesData.amount_october, 
                        "Target Sales" : salesData.target_sales_october, 
                        "Growth" : salesData.growth_october, 
                        "Achieved" : salesData.achieved_october
                    })
                    valuesData.push({
                        "Month" : "November", 
                        "LY Sell Out" : salesData.net_sales_november, 
                        "Sales Report" : salesData.amount_november, 
                        "Target Sales" : salesData.target_sales_november, 
                        "Growth" : salesData.growth_november, 
                        "Achieved" : salesData.achieved_november
                    })
                    valuesData.push({
                        "Month" : "December", 
                        "LY Sell Out" : salesData.net_sales_december, 
                        "Sales Report" : salesData.amount_december, 
                        "Target Sales" : salesData.target_sales_december, 
                        "Growth" : salesData.growth_december, 
                        "Achieved" : salesData.achieved_december
                    });
                }

                const headerData = [
                    ["LIFESTRONG MARKETING INC."],
                    ["Report: ASC Dashboard 2"],
                    ["Date Generated: " + formatDate(new Date())],
                    ["ASC Name: " + selectedASC],
                    ["Area: " + selectedArea],
                    ["Brand: " + selectedBrand],
                    ["Year: " + ($('#year option:selected').text() === "Please select.." ? "All" : $('#year option:selected').text())],
                    [""]
                ];

                exportArrayToCSV(valuesData, `Report: BA Dashboard - ${formatDate(new Date())}`, headerData);
            },
            onError: function(error) {
                alert("Error:", error);
            }
        });
    }

    function fetchTradeDashboardData({ 
        selectedASC, 
        selectedBrand, 
        selectedYear, 
        selectedStore, 
        selectedBA, 
        selectedArea, 
        length, 
        start, 
        onSuccess, 
        onError 
    }) {
        let allData = [];

        function fetchData(offset) {
            $.ajax({
                url: base_url + 'trade-dashboard/trade-asc-dashboard-one',
                type: 'POST',
                data : {
                    asc : selectedASC,
                    brand : selectedBrand,
                    year : selectedYear,
                    store : selectedStore,
                    ba : selectedBA,
                    area : selectedArea
                },
                success: function(response) {
                    if (response.data && response.data.length) {
                        allData = allData.concat(response.data);

                        if (response.data.length > length) {
                            fetchData(offset + length);
                        } else {
                            if (onSuccess) onSuccess(allData);
                        }
                    } else {
                        if (onSuccess) onSuccess(allData);
                    }
                },
                error: function(error) {
                    if (onError) onError(error);
                }
            });
        }

        fetchData(start);
    }

    function prepareExport1() {
        let selectedASC = $('#ascName').val();
        let selectedArea = $('#area').val();
        let selectedBrand = $('#brand').val();
        let selectedYear = $('#year').val();
        let selectedStore = $('#store_id').val();
        let selectedBA = $('#ba').val();
        let withBA = $('input[name="coveredASC"]:checked').val();

        let tables = [
            { id: "Slow Moving", type: "slowMoving" },
            { id: "Overstock", type: "overStock" },
            { id: "NPD", type: "npd" },
            { id: "Hero", type: "hero" },
        ];

        let fetchPromises = tables.map(table => {
            return new Promise((resolve, reject) => {
                let stype = table.type;
                fetchTradeDashboardData1({
                    stype, 
                    selectedASC, 
                    selectedArea, 
                    selectedStore, 
                    selectedBrand, 
                    selectedBA, 
                    selectedYear, 
                    withBA,
                    length: 10,
                    start: 0,
                    onSuccess: function(result) {
                        let newData = result.map(({ item_name, sum_total_qty }) => ({
                            "SKU Name": item_name,
                            "Quantity": sum_total_qty,
                            "LMI Code": "",
                            "RGDI Code": "",
                            "Type of SKU": table.id
                        }));
                        resolve(newData);
                    },
                    onError: function(error) {
                        reject(error);
                    }
                });
            });
        });

        Promise.all(fetchPromises)
            .then(results => {
                let formattedData = results.flat();

                const headerData = [
                    ["LIFESTRONG MARKETING INC."],
                    ["Report: ASC Dashboard 2"],
                    ["Date Generated: " + formatDate(new Date())],
                    ["ASC Name: " + selectedASC],
                    ["Area: " + selectedArea],
                    ["Brand: " + selectedBrand],
                    ["Year: " + ($('#year option:selected').text() === "Please select.." ? "All" : $('#year option:selected').text())],
                    [""]
                ];

                exportArrayToCSV(formattedData, `Report: BA Dashboard - ${formatDate(new Date())}`, headerData);
            })
            .catch(error => {
                alert("Error:", error);
            });
    }

    function fetchTradeDashboardData1({ 
        stype, 
        selectedASC, 
        selectedArea, 
        selectedStore, 
        selectedBrand, 
        selectedBA, 
        selectedYear, 
        withBA,
        length, 
        start, 
        onSuccess, 
        onError 
    }) {
        let allData = [];

        function fetchData1(offset) {
            $.ajax({
                url: "<?= base_url(); ?>" + 'trade-dashboard/trade-asc-dashboard-one-tables',
                type: 'POST',
                data : {
                    area : selectedArea === "0" ? null : selectedArea,
                    asc : selectedASC === "0" ? null : selectedASC,
                    brand : selectedBrand === "0" ? null : selectedBrand,
                    ba : selectedBA === "0" ? null : selectedBA,
                    store : selectedStore === "0" ? null : selectedStore,
                    year : selectedYear === "0" ? null : selectedYear,
                    trade_type : stype,
                    withba : withBA,
                    limit : length,
                    offset : start,
                },
                success: function(response) {
                    if (response.data && response.data.length) {
                        allData = allData.concat(response.data);

                        if (response.data.length > length) {
                            fetchData1(offset + length);
                        } else {
                            if (onSuccess) onSuccess(allData);
                        }
                    } else {
                        if (onSuccess) onSuccess(allData);
                    }
                },
                error: function(error) {
                    if (onError) onError(error);
                }
            });
        }

        fetchData1(start);
    }

    function exportArrayToCSV(data, filename, headerData) {
        // Create a new worksheet
        const worksheet = XLSX.utils.json_to_sheet(data, { origin: headerData.length });

        // Add header rows manually
        XLSX.utils.sheet_add_aoa(worksheet, headerData, { origin: "A1" });

        // Convert worksheet to CSV format
        const csvContent = XLSX.utils.sheet_to_csv(worksheet);

        // Convert CSV string to Blob
        const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });

        // Trigger file download
        saveAs(blob, filename + ".csv");
    }
