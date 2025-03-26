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
                            <span class="my-auto">ASC Dashboard (Preview)</span>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="ascName">ASC Name</label>
                                    <input type="text" class="form-control" id="ascName" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="area">Area</label>
                                    <input type="text" class="form-control" id="area" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="brand">Brand</label>
                                    <input type="text" class="form-control" id="brand" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="year">Year</label>
                                    <input type="text" class="form-control" id="year" readonly>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label for="ascCov">Covered by Selected ASC</label>
                                    <input type="text" class="form-control" id="ascCov" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="store_id">Store Name</label>
                                    <input type="text" class="form-control" id="store_id" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="ba">BA Name</label>
                                    <input type="text" class="form-control" id="ba" readonly>
                                </div>
                                <div class="col-md-3"></div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6"></div>
                                <div class="col-md-3 text-right pr-2">
                                    <small id="date-generated"></small>
                                </div>
                                <div class="col-md-3">
                                    <button id="generatePDF" class="my-3 mx-auto" onclick="generatePDF()">Generate PDF</button>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="card">
                        <div class="table-responsive">
                            <table id="tbl1" class="table">
                                <thead>
                                    <tr>
                                        <th colspan="6">ASC Dashboard 1</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Month</th>
                                        <th>LY Sell Out</th>
                                        <th>Sales Report</th>
                                        <th>Target Sales</th>
                                        <th>Growth</th>
                                        <th>Achieved</th>
                                    </tr>
                                </tbody>
                            </table>
            
                            <table id="tbl2" class="table">
                                <thead>
                                    <tr>
                                        <th colspan="5">ASC Dashboard 2</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>SKU Name</th>
                                        <th>Quantity</th>
                                        <th>LMI Code</th>
                                        <th>RGDI Code</th>
                                        <th>Type of SKU</th>
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
    var params = segment.split("-"); 

    let asc = <?= json_encode($asc); ?>;
    let area = <?= json_encode($area); ?>;
    let brand = <?= json_encode($brand); ?>;
    let year = <?= json_encode($year) ?>;
    let store_branch = <?= json_encode($store_branch); ?>;
    let brand_ambassador = <?= json_encode($brand_ambassador); ?>;

    let ascName = mapData(asc, 'asc_id', 'asc_description');
    let areaName = mapData(area, 'id', 'area_description');
    let brandName = mapData(brand, 'id', 'brand_description');
    let yearMap = mapData(year, 'id', 'year');
    let storeName = mapData(store_branch, 'id', 'description');
    let baName = mapData(brand_ambassador, 'id', 'description');

    const { jsPDF } = window.jspdf;

    $(document).ready(function() {
        $("#tbl1").hide();
        $("#tbl2").hide();

        checkOutput(
            () => { 
                prepareExport(true); 
                $("#tbl1").show(); 
            },
            () => { 
                prepareExport1(true); 
                $("#tbl2").show(); 
            },
        );

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
    });

    function generatePDF() {
        checkOutput(
            () => { 
                prepareExport(false); 
            },
            () => { 
                prepareExport1(false); 
            },
        );
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

    function checkOutput(ifEmpty, ifNotEmpty) {
        if(params[0] == "TRUE"){
            ifNotEmpty();
        }else if (params[0] == "FALSE"){
            ifEmpty();
        }
    }

    function prepareExport(plotTbl) {
        // let link = `FALSE-${selectedASC}-${selectedArea}-${selectedBrand}-${selectedYear}-${selectedStore}-${selectedBa}`;

        $('#ascName').val(ascName[params[1]] || "All");
        $('#area').val(areaName[params[2]] || "All");
        $('#brand').val(brandName[params[3]] || "All");;
        $('#year').val(yearMap[params[4]] || "All");
        $('#store_id').val(storeName[params[5]]|| "All");
        $('#ba').val(baName[params[6]]|| "All");
        
        let selectedASC = params[1]; 
        let selectedArea = params[2]; 
        let selectedBrand = params[3]; 
        let selectedYear = params[4]; 
        let selectedStore = params[5]; 
        let selectedBA = params[6]; 
        
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
                
                if (plotTbl) {
                    let html = '';
                    valuesData.forEach(data => {
                        html += '<tr>';
                        html += '<td>' + data.Month + '</td>';
                        html += '<td>' + data["LY Sell Out"] + '</td>';
                        html += '<td>' + data["Sales Report"] + '</td>';
                        html += '<td>' + data["Target Sales"] + '</td>';
                        html += '<td>' + (data.Growth !== null && data.Growth !== undefined ? data.Growth : "0.00") + '</td>';
                        html += '<td>' + data.Achieved + '</td>';
                        html += '</tr>';
                    });
                    $('#tbl1 tbody').append(html)
                } else {
                    outputPDF1(valuesData, 'tbl1');
                }
            },
            onError: function(error) {
                alert("Error:", error);
            }
        });
    }

    function outputPDF1(valuesData, tbl) {
        console.log(valuesData, 'outputPDF1');

        const doc = new jsPDF({
            orientation: "landscape",
        });
        
        // Add title
        doc.setFont("helvetica", "bold");
        doc.setFontSize(22);
        doc.text("LIFESTRONG MARKETING INC.", 20, 20);

        // Add a subtitle
        doc.setFontSize(14);
        doc.text("Report: ASC Dashboard 2", 20, 30);

        // Add a line separator
        doc.line(20, 35, 300, 35);

        doc.setFontSize(12);
        if (tbl === 'tbl1') {
            doc.text("Item Name", 20, 40);
            doc.text("Quantity", 70, 40);
            doc.text("LMI Code", 120, 40);
            doc.text("RGDI Code", 170, 40);
            doc.text("Growth", 220, 40);
            doc.text("Achieved", 270, 40);
        } else {
            doc.text("Item Name", 20, 40);
            doc.text("Quantity", 145, 40);
            doc.text("LMI Code", 170, 40);
            doc.text("RGDI Code", 205, 40);
            doc.text("Type of SKU", 245, 40);
        }

        // Load an image and add it to PDF
        // Example image
        const imgURL = "<?php echo base_url('assets/img/sampleimg.png'); ?>"; // if this does not work use the other link
        const img = new Image();
        img.src = imgURL;
        
        img.onload = function () {
            doc.addImage(img, "PNG", 245, 5, 30, 30); // Add image at x=20, y=60, width=50, height=50
        };

        let yPos = 50;
        doc.setFont("helvetica", "normal");
        doc.setFontSize(12);

        if (tbl === 'tbl1') {
            valuesData.forEach(data => {
                doc.text(data["Month"], 20, yPos);
                doc.text(data["LY Sell Out"], 70, yPos);
                doc.text(data["Sales Report"], 120, yPos);
                doc.text(data["Target Sales"], 170, yPos);
                doc.text((data["Growth"] !== null && data["Growth"] !== undefined ? data["Growth"] : "0.00"), 220, yPos);
                doc.text(data["Achieved"], 270, yPos);
                yPos += 10;
            })
        } else {
            valuesData.forEach(data => {
                if (yPos >= 200) {
                    doc.addPage();

                    doc.setFont("helvetica", "bold");
                    doc.setFontSize(22);
                    doc.text("LIFESTRONG MARKETING INC.", 20, 20);

                    doc.setFontSize(14);
                    doc.text("Report: ASC Dashboard 2", 20, 30);

                    doc.line(20, 35, 300, 35);

                    doc.setFontSize(12);
                    doc.text("Item Name", 20, 40);
                    doc.text("Quantity", 145, 40);
                    doc.text("LMI Code", 170, 40);
                    doc.text("RGDI Code", 195, 40);
                    doc.text("Type of SKU", 245, 40);

                    yPos = 50;
                    doc.setFont("helvetica", "normal");
                    doc.setFontSize(12);
                }
                doc.text(data["SKU Name"], 20, yPos);
                doc.text(data["Quantity"], 145, yPos);
                doc.text(data["LMI Code"], 170, yPos);
                doc.text(data["RGDI Code"], 195, yPos);
                doc.text(data["Type of SKU"], 245, yPos);
                yPos += 10;
            });
        }

        doc.save(`ASC Dashboard.pdf`);
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

    function prepareExport1(plotTbl) {
        // let link = `TRUE-${selectedASC}-${selectedArea}-${selectedBrand}-${selectedYear}-${selectedStore}-${selectedBA}-${withBA}`;

        $('#ascName').val(ascName[params[1]] || "All");
        $('#area').val(areaName[params[2]] || "All");
        $('#brand').val(brandName[params[3]] || "All");;
        $('#year').val(yearMap[params[4]] || "All");
        $('#store_id').val(storeName[params[5]]|| "All");
        $('#ba').val(baName[params[6]]|| "All");
        let covAsc = params[7] == "with_ba" ? "W/ BA" : "W/O BA";
        $('#ascCov').val(covAsc);

        let selectedASC = params[1];
        let selectedArea = params[2];
        let selectedBrand = params[3];
        let selectedYear = params[4];
        let selectedStore = params[5];
        let selectedBA = params[6];
        let withBA = params[7];

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

                if (plotTbl) {
                    let html = '';
                    formattedData.forEach(data => {
                        html += '<tr>';
                        html += '<td>' + data["SKU Name"] + '</td>';
                        html += '<td>' + data["Quantity"] + '</td>';
                        html += '<td>' + data["LMI Code"] + '</td>';
                        html += '<td>' + data["RGDI Code"] + '</td>';
                        html += '<td>' + data["Type of SKU"] + '</td>';
                        html += '</tr>';
                    });
                    $('#tbl2 tbody').append(html);
                } else {
                    outputPDF1(formattedData, 'tbl2');
                }
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

</script>