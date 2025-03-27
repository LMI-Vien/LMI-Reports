<style>
    .content-wrapper {
        display: flex;
        justify-content: flex-start !important;
        flex-direction: column;
        gap: 10px;
    }

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

    #generatePDF {
        background-color: #007bff; /* Blue color */
        color: white; /* Text color */
        font-size: 16px;
        font-weight: bold;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
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
                            <span class="my-auto">Overall Brand Ambassador Sales Target (Preview)</span>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="store">Store</label>
                                    <input type="text" class="form-control" id="store" readonly>
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
                                <div class="col-md-3">
                                    <button id="generatePDF" class="my-3 mx-auto" onclick="generatePDF()">Generate PDF</button>
                                </div>
                                <div class="col-md-3 text-right pr-2">
                                    <small id="date-generated"></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="table-responsive">
                            <table id="overall_ba_sales_tbl" class="table">
                                <thead>
                                    <tr>
                                        <th colspan="10">Summary</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Store Code</th>
                                        <th>Area</th>
                                        <th>Store Name</th>
                                        <th>Actual Sales</th>
                                        <th>Target</th>
                                        <th>%Achieved</th>
                                        <th>Balance to target</th>
                                        <th>Possible Incentives</th>
                                        <th>Target per remaining days</th>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/3.0.1/jspdf.umd.min.js"></script>

<script>
    var segment = "<?=$uri->getSegment(3);?>";
    var params = segment.split("-"); // store, area, month, year

    let store_branch = <?= json_encode($store_branch) ?>;
    let area = <?= json_encode($area) ?>;
    let month = <?= json_encode($month) ?>;
    let year = <?= json_encode($year) ?>;

    $(document).ready(function() {
        populateHeader();

        populateTable(true);
    });

    function populateHeader() {
        let storeMap = mapData(store_branch, 'id', 'description');
        let areaMap = mapData(area, 'id', 'area_description');
        let monthMap = mapData(month, 'id', 'month');
        let yearMap = mapData(year, 'id', 'year');

        $("#store").val(storeMap[params[0]] || "ALL");
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

    function populateTable(plotTbl) {
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
                let html = '';

                if (plotTbl) {
                    data.forEach((value) => {
                        html += `<tr>
                            <td>${value.rank}</td>
                            <td>${value.store_code}</td>
                            <td>${value.area}</td>
                            <td>${value.store_name}</td>
                            <td>${value.actual_sales}</td>
                            <td>${value.target_sales}</td>
                            <td>${value.percent_ach ?? ""}</td>
                            <td>${value.balance_to_target}</td>
                            <td>${value.possible_incentives}</td>
                            <td>${value.target_per_remaining_days}</td>
                        </tr>`;
                    });
    
                    $(`#overall_ba_sales_tbl tbody`).append(html);
                } else {
                    outputPDF(data)
                }
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
                url: base_url + 'trade-dashboard/trade-overall-ba',
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
                    if (response.data && response.data.length) {
                        allData = allData.concat(response.data);

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
    
    function generatePDF() {
        populateTable(false)
    }

    function outputPDF(data) {
        const { jsPDF } = window.jspdf;

        const doc = new jsPDF({
            orientation: "landscape",
        });

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

        // Add title
        doc.setFont("helvetica", "bold");
        doc.setFontSize(22);
        doc.text("LIFESTRONG MARKETING INC.", 20, 20);

        // Add a subtitle
        doc.setFontSize(14);
        doc.text("Report: Overall BA Sales Target", 20, 30);

        doc.setFont("helvetica", "normal");
        doc.setFontSize(12);
        doc.text("Store Name: " + $('#store').val(), 20, 35);
        doc.text("Area: " + $('#area').val(), 20, 40);
        doc.text("Month: " + $('#month').val(), 120, 35);
        doc.text("Year: " + $('#year').val(), 120, 40);
        doc.text("Date Generated: " + formattedDate, 190, 35);

        // Add a line separator
        doc.line(20, 45, 290, 45);

        doc.setFont("helvetica", "bold");
        doc.setFontSize(12);
        doc.text("Rank", 20, 50);
        doc.text("Store", 35, 50);
        doc.text("Code", 35, 55);
        doc.text("Area", 55, 50);
        doc.text("Store Name", 90, 50);
        doc.text("Actual Sales", 125, 50);
        doc.text("Target", 155, 50);
        doc.text("%Ach", 175, 50);
        doc.text("Balance to", 195, 50);
        doc.text("target", 195, 55);
        doc.text("Possible", 230, 50);
        doc.text("Incentives", 230, 55);
        doc.text("Target per", 260, 50);
        doc.text("remaining days", 260, 55);

        let yPos = 60;
        doc.setFont("helvetica", "normal");
        doc.setFontSize(12);

        data.forEach((value) => {
            doc.text(value.rank, 20, yPos);
            doc.text(value.store_code, 35, yPos);
            doc.text(value.area, 55, yPos);
            doc.text(trimText(value.store_name, 10), 90, yPos);
            doc.text(value.actual_sales, 125, yPos);
            doc.text(value.target_sales, 155, yPos);
            doc.text((value.percent_ach ?? ""), 175, yPos);
            doc.text(value.balance_to_target, 195, yPos);
            doc.text(value.possible_incentives, 230, yPos);
            doc.text(value.target_per_remaining_days, 260, yPos);
            yPos += 5;
        })

        doc.save(`Overall BA Sales Target ${formattedDate}.pdf`);
    }

    function trimText(str, length) {
        if (str.length > length) {
            return str.substring(0, length) + "...";
        } else {
            return str;
        }
    }

</script>