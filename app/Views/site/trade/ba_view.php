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
                            <span class="my-auto">Information for Brand Ambassador (Preview)</span>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="ba">Brand Ambassador</label>
                                    <input type="text" class="form-control" id="ba" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="store">Store</label>
                                    <input type="text" class="form-control" id="store" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="brand">Brand</label>
                                    <input type="text" class="form-control" id="brand" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="type">Type</label>
                                    <input type="text" class="form-control" id="type" readonly>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label for="ar_asc_name">Area / ASC Name:</label>
                                    <input type="text" class="form-control" id="ar_asc_name" readonly>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-3">
                                    <button id="generatePDF" class="my-3" onclick="generatePDF()">Generate PDF</button>
                                </div>
                                <div class="col-md-3 text-right pr-2">
                                    <small id="date-generated"></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="table-responsive">
                            <table id="baTable" class="table">
                                <thead>
                                    <tr>
                                        <th colspan="5">Summary</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Item Name</th>
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
    let brand_ambassadors = <?= json_encode($brand_ambassador) ?>;
    let store_branch = <?= json_encode($store_branch) ?>;
    let brands = <?= json_encode($brands) ?>;
    var segment = "<?=$uri->getSegment(3);?>";
    var params = segment.split("-"); 

    let tables = [
        { id: "Slow Moving SKU", type: "slowMoving" },
        { id: "Overstock SKU", type: "overStock" },
        { id: "NPD SKU", type: "npd" },
        { id: "Hero SKU", type: "hero" }
    ];

    // Ensure jsPDF is available
    const { jsPDF } = window.jspdf;

    $(document).ready(function() {
        // populate header
        populateHeaderData();

        // populate table
        populateTableData();
    });

    // Function to generate PDF
    function generatePDF() {
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
        doc.text("Report: BA Dashboard", 20, 30);

        doc.setFont("helvetica", "normal");
        doc.setFontSize(12);
        doc.text("Brand Ambassador: " + $('#ba').val(), 20, 40);
        doc.text("Store Name: " + $('#store').val(), 20, 45);
        doc.text("Brand: " + $('#brand').val(), 120, 40);
        doc.text("Area / ASC Name: " + $('#ar_asc_name').val(), 120, 45);
        doc.text("Outright/Consignment: " + $('#type').val(), 190, 40);
        doc.text("Date Generated: " + formattedDate, 190, 45);

        // Add a line separator
        doc.line(20, 50, 300, 50);

        doc.setFont("helvetica", "bold");
        doc.setFontSize(12);
        doc.text("Item Name", 20, 55);
        doc.text("Quantity", 145, 55);
        doc.text("LMI Code", 170, 55);
        doc.text("RGDI Code", 205, 55);
        doc.text("Type of SKU", 245, 55);

        let yPos = 65;
        doc.setFont("helvetica", "normal");
        doc.setFontSize(12);

        let newTableData = [];

        async function fetchDataForTables() {
            let fetchPromises = tables.map(table => {
                return new Promise((resolve, reject) => {
                    fetchTradeDashboardData({
                        baseUrl: "<?= base_url(); ?>",
                        selectedSortField: params[4],
                        selectedSortOrder: params[5],
                        selectedBrand: params[3],
                        selectedBa: params[1],
                        selectedStore: params[2],
                        selectedType: params[0],
                        type: table.type,
                        length: 10,
                        start: 0,
                        onSuccess: function(data) {
                            data.forEach((value) => {
                                newTableData.push([
                                    value.item_name,
                                    value.sum_total_qty,
                                    "",
                                    "",
                                    table.id
                                ]);
                            });
                            resolve(); // Mark this request as complete
                        },
                        onError: function(error) {
                            console.error("Error:", error);
                            reject(error); // Mark this request as failed
                        }
                    });
                });
            });

            // Wait for all requests to complete before proceeding
            await Promise.all(fetchPromises);

            $.each(newTableData, function (rowIndex, row) {
                if (yPos >= 200) {
                    doc.addPage();

                    doc.setFont("helvetica", "bold");
                    doc.setFontSize(22);
                    doc.text("LIFESTRONG MARKETING INC.", 20, 20);
                    doc.setFontSize(14);
                    doc.text("Report: BA Dashboard", 20, 30);

                    doc.setFont("helvetica", "normal");
                    doc.setFontSize(12);
                    doc.text("Brand Ambassador: " + $('#ba').val(), 20, 40);
                    doc.text("Store Name: " + $('#store').val(), 20, 45);
                    doc.text("Brand: " + $('#brand').val(), 120, 40);
                    doc.text("Area / ASC Name: " + $('#ar_asc_name').val(), 120, 45);
                    doc.text("Outright/Consignment: " + $('#type').val(), 220, 40);

                    doc.line(20, 50, 300, 50);

                    doc.setFont("helvetica", "bold");
                    doc.setFontSize(12);
                    doc.text("Item Name", 20, 55);
                    doc.text("Quantity", 145, 55);
                    doc.text("LMI Code", 170, 55);
                    doc.text("RGDI Code", 205, 55);
                    doc.text("Type of SKU", 245, 55);

                    yPos = 65;
                    doc.setFont("helvetica", "normal");
                    doc.setFontSize(12);
                }
                let xPos = 20;
                doc.text(row[0], xPos, yPos);
                doc.text(row[1], xPos+125, yPos);
                doc.text(row[2], xPos+150, yPos);
                doc.text(row[3], xPos+185, yPos);
                doc.text(row[4], xPos+225, yPos);
                yPos += 5;
            });

            // Save the PDF
            doc.save(`BA Dashboard ${formattedDate}.pdf`);
        }

        // Call the function
        fetchDataForTables();
    }

    /**
     * @example
     * const data = [
     *   { id: 1, name: "Alice" },
     *   { id: 2, name: "Bob" },
     *   { id: 3, name: "Charlie" }
     * ];
     * 
     * const result = mapData(data, "id", "name");
     * console.log(result); // { "1": "Alice", "2": "Bob", "3": "Charlie" }
     */
    function mapData(obj, index, value) {
        let mapped_data = {};
        
        // validation
        if (!Array.isArray(obj)) {
            return {};
        }

        // loop thru every object in the array
        obj.forEach(item => {
            // check if index and value properties exist in the object
            if (item[index] !== undefined && item[value] !== undefined) {
                mapped_data[item[index]] = item[value];
            }
        });

        return mapped_data;
    }

    function get_area_asc(id) {
        var url = "<?= base_url('cms/global_controller');?>";
        query = 'ba.status = 1 AND ba.id = '+id;
        var data = {
            event : "list",
            select : "ba.id, ba.code, asc.description as asc_name, a.description as area",
            query : query,
            offset : 1,
            limit : 1,
            table : "tbl_brand_ambassador ba",
            join : [
                {
                    table: "tbl_area a",
                    query: "a.id = ba.area",
                    type: "left"
                },
                {
                    table: "tbl_area_sales_coordinator asc",
                    query: "asc.area_id = a.id",
                    type: "left"
                }                
            ],
            order : {
                field : 'ba.code',
                order : 'asc'
            }

        }

        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            if(result){
                $.each(result, function(index,d) {
                    $('#ar_asc_name').val((d.area || "N/A") + " / " + (d.asc_name || "N/A"));
                });
            }
        });
    }

    function populateHeaderData() {
        let bamap = mapData(brand_ambassadors, 'id', 'description')
        $('#ba').val(bamap[params[1]] || "All");

        let storemap = mapData(store_branch, 'id', 'description')
        $('#store').val(storemap[params[2]] || "All");

        let brandmap = mapData(brands, 'id', 'brand_description')
        $('#brand').val(brandmap[params[3]] || "All");

        let type = ''
        if (params[0] == '1') {
            type = 'Outright'
        } else if (params[0] == '0') {
            type = 'Consignment'
        } else if (params[0] == '3') {
            type = 'All'
        } else {
            type = 'Error! Invalid Type Value'
        }
        $('#type').val(type);

        get_area_asc(params[1]);

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

    function populateTableData() {
        tables.forEach(table => {
            fetchTradeDashboardData({
                baseUrl: "<?= base_url(); ?>",
                selectedSortField: params[4],
                selectedSortOrder: params[5],
                selectedBrand: params[3],
                selectedBa: params[1],
                selectedStore: params[2],
                selectedType: params[0],
                type: table.type,
                length: 10,
                start: 0,
                onSuccess: function(data) {
                    let html = '';

                    data.forEach((value) => {
                        html += `<tr>
                            <td class="text-left"><span style="margin-left: 10px">${value.item_name}</span></td>
                            <td>${value.sum_total_qty}</td>
                            <td></td>
                            <td></td>
                            <td>${table.id}</td>
                        </tr>`;
                    });

                    $(`#baTable tbody`).append(html);
                },
                onError: function(error) {
                    alert("Error:", error);
                }
            });
        });
    }

    function fetchTradeDashboardData({ 
        baseUrl, 
        selectedSortField, 
        selectedSortOrder, 
        selectedBrand, 
        selectedBa, 
        selectedStore, 
        selectedType, 
        type, 
        length, 
        start, 
        onSuccess, 
        onError 
    }) {
        let allData = [];

        function fetchData(offset) {
            $.ajax({
                url: baseUrl + 'trade-dashboard/trade-ba',
                type: 'GET',
                data: {
                    sort_field: selectedSortField,
                    sort: selectedSortOrder,
                    brand: selectedBrand === "0" ? null : selectedBrand,
                    brand_ambassador: selectedBa === "0" ? null : selectedBa,
                    store_name: selectedStore === "0" ? null : selectedStore,
                    ba_type: selectedType,
                    type: type,
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

</script>