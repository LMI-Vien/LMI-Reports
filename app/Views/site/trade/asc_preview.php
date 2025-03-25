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
</style>

<div class="wrapper">
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid py-4">
                <div class="container mt-4">
                    <div class="card">
                        <div class="md-center text-center p-2 col">
                            <span class="my-auto">Information for Area Sales Coordinator (Preview)</span>
                        </div>

                        <!-- <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="store_name">Store Name</label>
                                    <input type="text" class="form-control" id="store_name" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="area">Area</label>
                                    <input type="text" class="form-control" id="area" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="month_year">Month</label>
                                    <input type="text" class="form-control" id="month" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="month_year">Year</label>
                                    <input type="text" class="form-control" id="year" readonly>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6 text-right pr-2">
                                        <small id="date-generated"></small>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row mt-3 align-items-center">
                                
                                <div class="col-md-3"></div>
                                
                            </div>
                        </div> -->

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="store">Store</label>
                                    <input type="text" class="form-control" id="store_name" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="area">Area</label>
                                    <input type="text" class="form-control" id="area" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="month">Month</label>
                                    <input type="text" class="form-control" id="month" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="year">Year</label>
                                    <input type="text" class="form-control" id="year" readonly>
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
                                    <tr>
                                        <th>Rank</th>
                                        <th>Area</th>
                                        <th>Area Sales Coordinator</th>
                                        <th>Actual Sales Report</th>
                                        <th>Target</th>
                                        <th>% Achieved</th>
                                        <th>Balance to Target</th>
                                        <th>Target per Remaining days</th> 
                                    </tr>
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

    let store_branch = <?= json_encode($store_branch) ?>;
    let area = <?= json_encode($area) ?>;
    let month = <?= json_encode($month) ?>;
    let year = <?= json_encode($year) ?>;

    $(document).ready(function() {
        // populate header
        populateHeaderData();

        // populate table
        populateTable();
       
    });

    function populateHeaderData() {
        let storeMap = mapData(store_branch, 'id', 'description');
        let areaMap = mapData(area, 'id', 'area_description');
        let monthMap = mapData(month, 'id', 'month');
        let yearMap = mapData(year, 'id', 'year');

        $("#store_name").val(storeMap[params[0]] || "ALL");
        $("#area").val(areaMap[params[1]] || "ALL");
        $("#month").val(monthMap[params[2]] || "ALL");
        $("#year").val(yearMap[params[3]] || "ALL");

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

    function mapData(obj, index, value) {
        let mapped_data = {};
        
        if (!Array.isArray(obj)) {
            return {};
        }

        obj.forEach(item => {
            if (item[index] !== undefined && item[value] !== undefined) {
                mapped_data[item[index]] = item[value];
            }
        });

        return mapped_data;
    }

    function populateTable() {
        console.log("Fetching data...", params);
        let selectedStore = params[0];
        let selectedArea = params[1];
        let selectedMonth = params[2];
        let selectedYear = params[3];
        let selectedSortField = params[4];
        let selectedSortOrder = params[5];

        fetchTradeDashboardData({
            selectedStore, 
            selectedArea, 
            selectedMonth, 
            selectedYear, 
            selectedSortField, 
            selectedSortOrder,
            length: 10,
            start: 0,
            onSuccess: function(data) {
                console.log(data, 'data');
                let html = '';

                data.forEach((value) => {
                    html += `<tr>
                        <td>${value.rank}</td>
                        <td>${value.area}</td>
                        <td>${value.asc_names}</td>
                        <td>${value.actual_sales}</td>
                        <td>${value.target_sales}</td>
                        <td>${value.percent_ach ?? ""}</td>
                        <td>${value.balance_to_target}</td>
                        <td>${value.target_per_remaining_days}</td>
                    </tr>`;
                });

                $(`#asc_preview_tbl tbody`).append(html);
            },
            onError: function(error) {
                alert("Error:", error);
            }
        });
    }

    function fetchTradeDashboardData({ 
        baseUrl, 
        selectedStore = null, 
        selectedArea = null, 
        selectedMonth = null, 
        selectedYear = null, 
        selectedSortField = null, 
        selectedSortOrder = null,
        length, 
        start, 
        onSuccess, 
        onError 
    }) {
        let allData = [];

        function fetchData(offset) {
            $.ajax({
                url: base_url + 'trade-dashboard/trade-info-asc',
                type: 'GET',
                data: {
                    store : selectedStore === "0" ? null : selectedStore,
                    area : selectedArea === "0" ? null : selectedArea,
                    month : selectedMonth === "0" ? null : selectedMonth,
                    year : selectedYear === "0" ? null : selectedYear,
                    sort_field : selectedSortField,
                    sort : selectedSortOrder,
                    limit: length,
                    offset: offset
                },
                success: function(response) {
                    console.log("Response received:", response);

                    if (response.data && response.data.length) {
                        allData = allData.concat(response.data);
                        console.log("Current allData:", allData);

                        if (response.data.length === length) {
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

    

</script>