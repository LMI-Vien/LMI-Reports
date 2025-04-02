<style>
    .card {
        border-radius: 12px !important;
        background: #ffffff;
        transition: transform 0.3s ease-in-out;
        border: 1px solid grey;
        padding: 15px;
    }

    table {
        border-collapse: collapse;
        border: 1px solid #ddd;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    
    th, td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
    }

    thead {
        color: white;
        text-align: center;
        position: sticky;
        top: 0;
        z-index: 100;
        color: #fff;
        background-color: #301311;
    }

    tbody tr th {
        position: sticky;
        top: 50px;
        z-index: 90;
        color: #fff;
        background: linear-gradient(to right, #143996, #007bff);
        color: white;
    }
    
    tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    
    tbody tr:hover {
        background-color: #f1f1f1;
        cursor: pointer;
    }
    
    .table-responsive {
        max-height: 500px;
        overflow-x: auto;
        overflow-y: auto;
        display: block;
        white-space: nowrap;
    }

    .md-center {
        color: white;
        font-weight: bold;
        font-family: 'Poppins', sans-serif;
        font-size: 1.6rem;
        text-align: center;
        background: linear-gradient(90deg, #fdb92a, #ff9800);
        border: none;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }

    label {
        font-weight: 600;
        font-size: 0.95rem;
        color: #333;
        margin-bottom: 5px;
    }

    input.form-control {
        background: #f9f9f9;
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 0.95rem;
    }

    input.form-control:focus {
        border-color: #ff9800;
        box-shadow: 0px 0px 5px rgba(255, 152, 0, 0.5);
        background: #fff;
    }
    
    @media (max-width: 768px) {
        th, td {
            font-size: 14px;
            padding: 8px;
        }
    }
    
    .bold-text {
        font-weight: bold;
    }
</style>

<div class="wrapper">
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid py-4">
                <div class="container mt-4">
                    <div class="card">
                        <div class="md-center text-center p-2 col">
                            <span class="my-auto">Information for Overall ASC Sales Report (Preview)</span>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="asc_name">ASC Name</label>
                                    <input type="text" class="form-control" id="asc_name" value="<?= ($asc_name == 0) ? 'ANY' : $asc_name; ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="area">Area</label>
                                    <input type="text" class="form-control" id="area" value="<?= ($area_name == 0) ? 'ANY' : $area_name; ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="brand">Brand</label>
                                    <input type="text" class="form-control" id="brand" value="<?= ($brand_name == 0) ? 'ANY' : $brand_name; ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="year">Year</label>
                                    <input type="text" class="form-control" id="year" value="<?= ($year_name == 0) ? 'ANY' : $year_name; ?>" readonly>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6"></div>
                                <div class="col-md-6 text-right pr-2">
                                    <small id="date-generated"></small>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card">
                        <div class="table-responsive">
                            <table id="asc_preview_tbl" class="table">
                                <thead>
                                    <tr>
                                        <th colspan="8">Summary</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <tr>
                                        <th>Rank</th>
                                        <th>Area</th>
                                        <th>Area Sales Coordinator</th>
                                        <th>Actual Sales Report</th>
                                        <th>Target</th>
                                        <th>% Achieved</th>
                                        <th>Balance to Target</th>
                                        <th>Target per Remaining days</th> 
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var segment = "<?=$uri->getSegment(3);?>";
    var params = segment.split("-");

    $(document).ready(function() {
        populateHeaderData();

        populateTable();
       
    });

    $(window).on("beforeunload", function() {
        $.ajax({
            url: "<?= base_url('trade-dashboard/clear-filter-session/overall_asc_preview_filters'); ?>",
            type: "POST",
            async: false 
        });
    });

    $(document).on("click", "a", function() {
        $.post("<?= base_url('trade-dashboard/clear-filter-session/asc_preview_filters'); ?>");
    });


    function populateHeaderData() {
        let date = new Date();
        let formattedDate = date.toLocaleDateString("en-US", { 
            year: "numeric", 
            month: "short", 
            day: "numeric",
            hour:"2-digit",
            minute:"2-digit",
            second:"2-digit",
            hour12:true
        });
        $('#date-generated').text(`Date Generated: ${formattedDate}`);
    }

    function populateTable() {
        
    }

    // function mapData(obj, index, value) {
    //     let mapped_data = {};

    //     // console.log("Input data:", obj);
        
    //     if (!Array.isArray(obj)) {
    //         return {};
    //     }

    //     obj.forEach(item => {
    //         // console.log("Processing item:", item);
    //         if (item[index] !== undefined && item[value] !== undefined) {
    //             mapped_data[item[index]] = item[value];
    //         }
    //     });

    //     // console.log("Mapped Data:", mapped_data);

    //     return mapped_data;
    // }

    // Goods na to
    // function populateTable() {
    //     // console.log("Fetching data...", params);

    //     let selectedAsc = params[0] || "0";
    //     let selectedArea = params[1] || "0";
    //     let selectedBrand = params[2] || "0";
    //     let selectedYear = params[3] || "0";

    //     // Determine which function to call
    //     let fetchFunction = (!selectedAsc && !selectedArea && !selectedBrand && !selectedYear) || 
    //                         (selectedAsc === "0" && selectedArea === "0" && selectedBrand === "0" && selectedYear === "0") 
    //                         ? fetchTradeDashboardDataAll 
    //                         : fetchTradeDashboardDataMonthly;

    //     console.log("Calling function:", fetchFunction.name);

    //     fetchFunction({
    //         baseUrl: base_url,
    //         selectedAsc,
    //         selectedArea,
    //         selectedBrand,
    //         selectedYear,
    //         length: 10,
    //         start: 0,
    //         onSuccess: function(data) {
    //             console.log("Data received:", data);

    //             if (fetchFunction === fetchTradeDashboardDataAll) {
    //                 generateTableAll(data, "#asc_preview_tbl");
    //             } else if (fetchFunction === fetchTradeDashboardDataMonthly) {
    //                 generateTableMonthly(data, "#asc_preview_tbl");
    //             }
    //         },
    //         onError: function(error) {
    //             alert("Error:", error);
    //         }
    //     });
    // }


    // function populateTable() {
    //     console.log("Params:", params); 

    //     let selectedAsc = params?.[0] || "0";  
    //     let selectedArea = params?.[1] || "0";  
    //     let selectedBrand = params?.[2] || "0";  
    //     let selectedYear = params?.[3] || "0"; 

    //     console.log("Selected values:", { selectedAsc, selectedArea, selectedBrand, selectedYear });

        
    //     // let fetchFunction = (selectedAsc === "0" && selectedArea === "0" && selectedBrand === "0" && selectedYear === "0")  
    //     //                     ? fetchTradeDashboardDataAll  
    //     //                     : fetchTradeDashboardDataMonthly;

    //     // console.log("Calling function:", fetchFunction.name);

    //     let fetchFunction = fetchTradeDashboardDataMonthly;

    //     fetchFunction({
    //         baseUrl: base_url,
    //         selectedAsc,
    //         selectedArea,
    //         selectedBrand,
    //         selectedYear,
    //         length: 10,
    //         start: 0,
    //         onSuccess: function(data) {
    //             console.log("Data received:", data);

    //             // if (fetchFunction === fetchTradeDashboardDataAll) {
    //             //     generateTableAll(data, "#asc_preview_tbl");
    //             // } else if (fetchFunction === fetchTradeDashboardDataMonthly) {
    //             //     generateTableMonthly(data, "#asc_preview_tbl");
    //             // }

    //             if (fetchFunction === fetchTradeDashboardDataMonthly) {
    //                 generateTableMonthly(data, "#asc_preview_tbl");
    //             } 
                
    //         },
    //         onError: function(error) {
    //             console.error("Error fetching data:", error);
    //             alert("Error fetching data. Check console for details.");
    //         }
    //     });
    // }

    // GOODS NA TO
    // function fetchTradeDashboardDataAll({ 
    //     baseUrl, 
    //     selectedAsc = null, 
    //     selectedArea = null, 
    //     selectedBrand = null, 
    //     selectedYear = null, 
    //     length, 
    //     start, 
    //     onSuccess, 
    //     onError 
    // }) {
    //     let allData = [];

    //     function fetchData(offset) {
    //         $.ajax({
    //             url: base_url + 'trade-dashboard/trade-overall-asc-sales-report',
    //             type: 'GET',
    //             data: {
    //                 asc_names : selectedAsc === "0" ? null : selectedAsc,
    //                 area : selectedArea === "0" ? null : selectedArea,
    //                 brands : selectedBrand === "0" ? null : selectedBrand,
    //                 year : selectedYear === "0" ? null : selectedYear,
    //                 limit: length,
    //                 offset: offset
    //             },
    //             success: function(response) {
    //                 // console.log("Response received:", response);

    //                 if (response.data && response.data.length) {
    //                     allData = allData.concat(response.data);
    //                     // console.log("Current allData:", allData);

    //                     if (response.data.length === length) {
    //                         fetchData(offset + length);
    //                     } else {
    //                         if (onSuccess) onSuccess(allData);
    //                     }
    //                 } else {
    //                     if (onSuccess) onSuccess(allData);
    //                 }
    //             },
    //             error: function(error) {
    //                 if (onError) onError(error);
    //             }
    //         });
    //     }

    //     fetchData(start);
    // }


    // function fetchTradeDashboardDataMonthly({ 
    //     baseUrl, 
    //     selectedAsc = null, 
    //     selectedArea = null, 
    //     selectedBrand = null, 
    //     selectedYear = null,
    //     length, 
    //     start, 
    //     onSuccess, 
    //     onError 
    // }) {
    //     let allData = [];

    //     function fetchData(offset) {
    //         $.ajax({
    //             url: base_url + 'trade-dashboard/trade-asc-dashboard-one',
    //             type: 'POST',
    //             data:
    //             console.log("Sending request with:", {
    //                 asc_names : selectedAsc === "0" ? null : parseInt(selectedAsc, 10),
    //                 area : selectedArea === "0" ? null : parseInt(selectedArea, 10),
    //                 brands : selectedBrand === "0" ? null : parseInt(selectedBrand, 10),
    //                 year : selectedYear === "0" ? null : parseInt(selectedYear, 10),
    //                 limit: length,
    //                 offset: offset
    //             }),
    //             success: function(response) {
    //                 console.log("Response received:", response);

    //                 if (response.data && response.data.length) {
    //                     allData = allData.concat(response.data);
    //                     // console.log("Current allData:", allData);

    //                     if (response.data.length === length) {
    //                         fetchData(offset + length);
    //                     } else {
    //                         if (onSuccess) onSuccess(allData);
    //                     }
    //                 } else {
    //                     if (onSuccess) onSuccess(allData);
    //                 }
    //             },
    //             error: function(error) {
    //                 if (onError) onError(error);
    //             }
    //         });
    //     }

    //     fetchData(start);
    // }

    // GOODS NA TO
    // function generateTableAll(data, tableSelector) {
    //     let html = `<table border="1">
    //         <thead>
    //             <tr>
    //                 <th></th>`;
    //     data.forEach((value) => {
    //         if (value.asc_name) {
    //             html += `<th>${value.asc_name}</th>`;
    //         }
    //     });
    //     html += `</tr>
    //         </thead>
    //         <tbody>
    //             <tr>
    //                 <td class="bold-text">LY Sell Out</td>`;
    //     data.forEach((value) => {
    //         if (value.asc_name) {
    //             html += `<td>${value.total_net_sales || "0.00"}</td>`;
    //         }
    //     });
    //     html += `</tr>
    //             <tr>
    //                 <td class="bold-text">Sales Report</td>`;
    //     data.forEach((value) => {
    //         if (value.asc_name) {
    //             html += `<td>${value.total_amount || "0.00"}</td>`;
    //         }
    //     });
    //     html += `</tr>
    //             <tr>
    //                 <td class="bold-text">Target Sales</td>`;
    //     data.forEach((value) => {
    //         if (value.asc_name) {
    //             html += `<td>${value.total_target_sales || "0.00"}</td>`;
    //         }
    //     });
    //     html += `</tr>
    //             <tr>
    //                 <td class="bold-text">Growth</td>`;
    //     data.forEach((value) => {
    //         if (value.asc_name) {
    //             html += `<td>${value.growth || "0.00"}</td>`;
    //         }
    //     });
    //     html += `</tr>
    //             <tr>
    //                 <td class="bold-text">% Achieved</td>`;
    //     data.forEach((value) => {
    //         if (value.asc_name) {
    //             html += `<td>${value.achieved || "0.00"}</td>`;
    //         }
    //     });
    //     html += `</tr>
    //         </tbody>
    //     </table>`;

    //     $(tableSelector).html(html);
    // }

    // function generateTableMonthly(data, tableSelector) {
    //     let html = `<table border="1">
    //         <thead>
    //             <tr>
    //                 <th></th>
    //                 <th>Jan</th>
    //                 <th>Feb</th>
    //                 <th>Mar</th>
    //                 <th>Apr</th>
    //                 <th>May</th>
    //                 <th>Jun</th>
    //                 <th>Jul</th>
    //                 <th>Aug</th>
    //                 <th>Sep</th>
    //                 <th>Oct</th>
    //                 <th>Nov</th>
    //                 <th>Dec</th>
    //             </tr>
    //         </thead>
    //         <tbody>
    //             <tr>
    //                 <td class="bold-text">LY Sell Out</td>
    //                 <td>${data[0].net_sales_january || "0.00"}</td>
    //                 <td>${data[0].net_sales_february || "0.00"}</td>
    //                 <td>${data[0].net_sales_march || "0.00"}</td>
    //                 <td>${data[0].net_sales_april || "0.00"}</td>
    //                 <td>${data[0].net_sales_may || "0.00"}</td>
    //                 <td>${data[0].net_sales_june || "0.00"}</td>
    //                 <td>${data[0].net_sales_july || "0.00"}</td>
    //                 <td>${data[0].net_sales_august || "0.00"}</td>
    //                 <td>${data[0].net_sales_september || "0.00"}</td>
    //                 <td>${data[0].net_sales_october || "0.00"}</td>
    //                 <td>${data[0].net_sales_november || "0.00"}</td>
    //                 <td>${data[0].net_sales_december || "0.00"}</td>
    //             </tr>
    //             <tr>
    //                 <td class="bold-text">Sales Report</td>
    //                 <td>${data[0].amount_january || "0.00"}</td>
    //                 <td>${data[0].amount_february || "0.00"}</td>
    //                 <td>${data[0].amount_march || "0.00"}</td>
    //                 <td>${data[0].amount_april || "0.00"}</td>
    //                 <td>${data[0].amount_may || "0.00"}</td>
    //                 <td>${data[0].amount_june || "0.00"}</td>
    //                 <td>${data[0].amount_july || "0.00"}</td>
    //                 <td>${data[0].amount_august || "0.00"}</td>
    //                 <td>${data[0].amount_september || "0.00"}</td>
    //                 <td>${data[0].amount_october || "0.00"}</td>
    //                 <td>${data[0].amount_november || "0.00"}</td>
    //                 <td>${data[0].amount_december || "0.00"}</td>
    //             </tr>
    //             <tr>
    //                 <td class="bold-text">Target Sales</td>
    //                 <td>${data[0].target_sales_january || "0.00"}</td>
    //                 <td>${data[0].target_sales_february || "0.00"}</td>
    //                 <td>${data[0].target_sales_march || "0.00"}</td>
    //                 <td>${data[0].target_sales_april || "0.00"}</td>
    //                 <td>${data[0].target_sales_may || "0.00"}</td>
    //                 <td>${data[0].target_sales_june || "0.00"}</td>
    //                 <td>${data[0].target_sales_july || "0.00"}</td>
    //                 <td>${data[0].target_sales_august || "0.00"}</td>
    //                 <td>${data[0].target_sales_september || "0.00"}</td>
    //                 <td>${data[0].target_sales_october || "0.00"}</td>
    //                 <td>${data[0].target_sales_november || "0.00"}</td>
    //                 <td>${data[0].target_sales_december || "0.00"}</td>
    //             </tr>
    //             <tr>
    //                 <td class="bold-text">Growth</td>
    //                 <td>${data[0].growth_january || "0.00"}</td>
    //                 <td>${data[0].growth_february || "0.00"}</td>
    //                 <td>${data[0].growth_march || "0.00"}</td>
    //                 <td>${data[0].growth_april || "0.00"}</td>
    //                 <td>${data[0].growth_may || "0.00"}</td>
    //                 <td>${data[0].growth_june || "0.00"}</td>
    //                 <td>${data[0].growth_july || "0.00"}</td>
    //                 <td>${data[0].growth_august || "0.00"}</td>
    //                 <td>${data[0].growth_september || "0.00"}</td>
    //                 <td>${data[0].growth_october || "0.00"}</td>
    //                 <td>${data[0].growth_november || "0.00"}</td>
    //                 <td>${data[0].growth_december || "0.00"}</td>
    //             </tr>
    //             <tr>
    //                 <td class="bold-text">% Achieved</td>
    //                 <td>${data[0].achieved_january || "0.00"}</td>
    //                 <td>${data[0].achieved_february || "0.00"}</td>
    //                 <td>${data[0].achieved_march || "0.00"}</td>
    //                 <td>${data[0].achieved_april || "0.00"}</td>
    //                 <td>${data[0].achieved_may || "0.00"}</td>
    //                 <td>${data[0].achieved_june || "0.00"}</td>
    //                 <td>${data[0].achieved_july || "0.00"}</td>
    //                 <td>${data[0].achieved_august || "0.00"}</td>
    //                 <td>${data[0].achieved_september || "0.00"}</td>
    //                 <td>${data[0].achieved_october || "0.00"}</td>
    //                 <td>${data[0].achieved_november || "0.00"}</td>
    //                 <td>${data[0].achieved_december || "0.00"}</td>
    //             </tr>
    //         </tbody>
    //     </table>`;

    //     $(tableSelector).html(html);
    // }




</script>

