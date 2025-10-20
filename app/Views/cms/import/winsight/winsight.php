<style>
    @media (min-width: 1200px) {
        .modal-xxl {
            max-width: 95%;
        }
    }
</style>

<div class="content-wrapper p-4">
    <div class="card">
        <div class="text-center page-title md-center">
            <b>IMPORT WINSIGHT FILE</b>
        </div>

        <div class="card-body text-center mx-3 my-3">

            <div class="card-body text-center">
                <div class="box">
                    <?php
                        echo view("cms/layout/buttons",$buttons);
                        $optionSet = '';
                        foreach($pageOption as $pageOptionLoop) {
                            $optionSet .= "<option value='".$pageOptionLoop."'>".$pageOptionLoop."</option>";
                        }
                    ?>
                    <div class="box-body">
                        <div class="col-md-12 list-data tbl-content" id="list-data">
                            <table class="table table-bordered listdata">
                                <thead>
                                    <tr>
                                        <th class='center-content'>Import Date</th>
                                        <th class='center-content'>Import File Name</th>
                                        <th class='center-content'>Imported By</th>
                                        <th class='center-content'>Year</th>
                                        <th class='center-content'>Month</th>
                                        <th class='center-content'>Week</th>
                                        <th class='center-content'>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="table_body word_break"></tbody>
                            </table>
                        </div>
                        <div class="list_pagination"></div>
                        <div class="form-group pull-right">
                            <label>Show</label>
                            <select class="record-entries">
                                <?= $optionSet; ?>
                            </select>
                            <label>Entries</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="add_winsight_modal">
    <div class="modal-dialog modal-xxl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">
                    <b>Import Winsight Sales</b>
                </h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card p-3">
                    <div class="mb-3">
                        <div class="text-center p-2" 
                            style="font-family: 'Courier New', Courier, monospace; font-size: large; background-color: #fdb92a; 
                            color: #333333; border-radius: 10px;">
                            <b>Extracted Data</b>
                        </div>

                        <div class="row my-3">
                            <div class="col-md-8 import_buttons">
                                <label for="file" class="btn btn-warning mt-2" style="margin-bottom: 0px;">
                                    <i class="fa fa-file-import my-32"></i> Custom Upload
                                </label>
                                <input type="file" id="file" accept=".xls,.xlsx,.csv" style="display: none;" 
                                onclick="clear_import_table()">

                                <button class="btn btn-primary mt-2" id="preview_xl_file" onclick="read_xl_file()">
                                    <i class="fa fa-sync my-32"></i> Preview Data
                                </button>

                                <button class="btn btn-success mt-2" id="download_template" onclick="download_template()">
                                    <i class="fa fa-file-download my-32"></i> Download Import Template
                                </button>
                            </div>
                        </div>
                        <div style="overflow-x: auto; max-height: 400px;">
                            <table class="table table-bordered listdata">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th>Line #</th>
                                        <th>BU Name</th>
                                        <th>Supplier</th>
                                        <th>Brand Name</th>
                                        <th>Product ID</th>
                                        <th>Product Name</th>
                                        <th>Category 1 (Item Classification)</th>
                                        <th>Category 2 (Sub Classification)</th>
                                        <th>Category 3 (Department)</th>
                                        <th>Category 4 (Merch. Category)</th>
                                        <th>Year</th>
                                        <th>Year Month</th>
                                        <th>Year Week</th>
                                        <th>Date</th>
                                        <th>Online/ Offline</th>
                                        <th>Store Format</th>
                                        <th>Store Segment</th>
                                        <th>Gross Sales</th>
                                        <th>Net Sales</th>
                                        <th>Sales Qty</th>
                                        <th>Barcode</th>
                                    </tr>
                                </thead>
                                <tbody class="word_break import_table"></tbody>
                            </table>
                        </div>
                    </div>

                    <center class="my-2">
                        <div class="import_pagination btn-group"></div>
                    </center>
                </div>
            </div>

            
            <div class="modal-footer">
                <button type="button" class="btn save" onclick="process_xl_file()">Validate and Save</button>
                <button type="button" class="btn caution" data-dismiss="modal">Close</button>
                
            </div>
        </div>
    </div>
</div>

<script>
    var query = "a.status >= 0";
    var limit = 10; 
    let currentPage = 1;
    let rowsPerPage = 1000;
    let totalPages = 1;
    let dataset = [];
    let fetchRes = null;
    var url = "<?= base_url('cms/global_controller');?>";

    $(document).ready(function() {
        get_data(query);
        get_pagination(query);
    })

    const get_data = (query) => {
        var data = {
            event : "list",
            select : "a.id, a.created_date, b.username, a.file_name, a.status, a.year, a.month, a.week",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_winsight_header as a",
            join : [
                {
                    table : "cms_users as b",
                    query : "a.created_by = b.id",
                    type : "left"
                }
            ],
            order : {
                field : "a.created_date",
                order : "desc" 
            }
        }

        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            var html = '';

            if(result) {
                if (result.length > 0) {
                    $.each(result, function(x,y) {
                        var status = ( parseInt(y.status) === 1 ) ? status = "Active" : status = "Inactive";
                        var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";

                        html += "<tr class='" + rowClass + "'>";
                        html += "<td scope=\"col\">" + y.created_date + "</td>";
                        html += "<td scope=\"col\">" + y.file_name + "</td>";
                        html += "<td scope=\"col\">" + y.username + "</td>";
                        html += "<td scope=\"col\">" + y.year + "</td>";
                        html += "<td scope=\"col\">" + y.month + "</td>";
                        html += "<td scope=\"col\">" + y.week + "</td>";

                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                          html+="<td class='center-content' style='width: 25%'>";

                          html+="<a class='btn-sm btn save' onclick=\"export_data('"
                          +y.id+"')\" data-status='"
                          +y.status+"' id='"
                          +y.id+"' title='Export Details'><span class='glyphicon glyphicon-pencil'>Export</span>";

                          html+="<a class='btn-sm btn view' onclick=\"view_data('"
                          +y.id+"')\" data-status='"
                          +y.status+"' id='"
                          +y.id+"' title='View Details'><span class='glyphicon glyphicon-pencil'>View</span>";

                          html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.id+"','"+y.year+"','"+y.month+"','"+y.week+
                            "')\" data-status='"
                          +y.status+"' id='"
                          +y.id+"' title='Delete Details'><span class='glyphicon glyphicon-pencil'>Delete</span>";

                          html+="</td>";
                        }
                        
                        html += "</tr>";   
                    });
                } else {
                    html = '<tr><td colspan=12 class="center-align-format">'+ no_records +'</td></tr>';
                }
            }
            $('.table_body').html(html);
        });
    }

    const get_pagination = (query) => {
        var data = {
          event : "pagination",
            select : "a.id",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_winsight_header as a",
            join : [
                {
                    table : "cms_users as b",
                    query : "a.created_by = b.id",
                    type : "left"
                }
            ],
            order : {
                field : "a.created_date",
                order : "desc" 
            }

        }

        aJax.post(url,data,function(result){
            var obj = is_json(result);
            modal.loading(false);
            pagination.generate(obj.total_page, ".list_pagination", get_data);
        });
    }

    pagination.onchange(function(){
        offset = $(this).val();
        get_data(query);
        $('.selectall').prop('checked', false);
        $('.btn_status').hide();
        $("#search_query").val("");
    });

    $(document).on('keypress', '#search_query', function(e) {               
        if (e.keyCode === 13) {
            var keyword = $(this).val().trim();
            var escaped_keyword = keyword.replace(/'/g, "''"); 
            offset = 1;
            var new_query = 
            `${query} AND (
                a.created_date LIKE '%${escaped_keyword}%' OR 
                a.file_name LIKE '%${escaped_keyword}%' OR
                b.username LIKE '%${escaped_keyword}%' OR 
                a.year LIKE '%${escaped_keyword}%' OR 
                a.month LIKE '%${escaped_keyword}%' OR 
                a.week LIKE '%${escaped_keyword}%'
            )`
            get_data(new_query);
            get_pagination(new_query);
        }
    });

    function export_data(id) {
        modal.confirm(confirm_export_message,function(result){
            if (result) {
                modal.loading_progress(true, "Reviewing Data...");
                setTimeout(() => {
                    const start_time = new Date();
                    handleExport(id, start_time)
                }, 500);
            }
        })
    }

    function view_data(id) {
        window.open("<?= base_url('cms/import-winsight/view') ?>/" + id, '_blank');
    }

    function handleExport(id, start_time) {
        modal.loading(true);
        let expurl = "<?= base_url()?>"+`cms/import-winsight/export-winsight-data`;
        $.ajax({
            url: expurl,
            method: 'POST',
            data: {
                id : id
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(blob, status, xhr) {
                const cd = xhr.getResponseHeader('Content-Disposition');
                const match = cd && /filename="?([^"]+)"/.exec(cd);
                const filename = 'Winsight Files '+formatDate(new Date())+'.xlsx';
                const blobUrl = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = blobUrl;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                a.remove();
                URL.revokeObjectURL(blobUrl);

                const end_time = new Date();
                const duration = formatDuration(start_time, end_time);
                
                let remarks = 
                `Export Completed Successfully!
                <br>Start Time: ${formatReadableDate(start_time)}
                <br>End Time: ${formatReadableDate(end_time)}
                <br>Duration: ${duration}`;
                
                let link = '';

                logActivity('Import Winsight Module', 'Export Data', remarks, link, null, null);
            },
            error: function(xhr, status, error) {
                alert(xhr+' - '+status+' - '+error);
                console.log(xhr)
                modal.loading(false);
            },
            complete: function() {
                modal.loading(false);
            }
        })
    }

    function delete_data(id, year, month, week) {
        modal.confirm(confirm_delete_message,function(result){
            if(result){ 
                modal.loading(true);
                const start_time = new Date();
                var url = "<?= base_url('cms/global_controller');?>";

                const header_conditions = [
                    { field: "id", values: [id] },
                    { field: "year", values: [year] },
                    { field: "month", values: [month] },
                    { field: "week", values: [week] }
                ];

                const details_conditions = [
                    { field: "header_id", values: [id] },
                    { field: "year", values: [year] },
                    { field: "month", values: [month] },
                    { field: "week", values: [week] }
                ];

                batch_delete_with_conditions(url, "tbl_winsight_header", header_conditions, function(resp) {
                    batch_delete_with_conditions(url, "tbl_winsight_details", details_conditions, function(resp) {
                        const end_time = new Date();
                        const duration = formatDuration(start_time, end_time);
                        
                        let remarks = 
                        `Selected records deleted successfully!
                        <br>Start Time: ${formatReadableDate(start_time)}
                        <br>End Time: ${formatReadableDate(end_time)}
                        <br>Duration: ${duration}`;
                        
                        let link = '';

                        logActivity('Import Winsight Module', 'Delete Data', remarks, link, null, null);

                        modal.loading(false);
                        modal.alert("Selected records deleted successfully!", 'success', () => location.reload());
                    });
                });
            }
        });
    }

    $("#btn_add").click(() => {
        $("#add_winsight_modal").modal('show')
    })

    const read_xl_file = async () => {
        const file = $("#file")[0].files[0];

        if (!file) {
            modal.loading_progress(false);
            modal.alert('Please select a file to upload', 'error', () => {});
            return;
        }

        clear_import_table();
        if (fetchRes != null) {
            delete_temp_data();
        }

        dataset = [];

        modal.loading_progress(true, "Preparing Data");
        const chunkSize = 512 * 1024; // 512 KB
        const totalChunks = Math.ceil(file.size / chunkSize);

        for (let chunkIndex = 0; chunkIndex < totalChunks; chunkIndex++) {
            let start = chunkIndex * chunkSize;
            let end = Math.min(start + chunkSize, file.size);
            let chunk = file.slice(start, end);

            let formData = new FormData();
            formData.append("file", chunk);
            formData.append("chunkIndex", chunkIndex);
            formData.append("totalChunks", totalChunks);
            formData.append("fileName", file.name);
            try {
                let response = await fetch("<?= base_url('cms/import-winsight/import-temp-winsight-data'); ?>", {
                    method: "POST",
                    body: formData
                });
                fetchRes = await response.json();
            } catch (error) {
                modal.alert("Upload error, please try again.", "error");
            }

            let progress = Math.round(((chunkIndex + 1) / totalChunks) * 100);
            updateSwalProgress("Preview Data", progress);
        }

        fetchPaginatedData(fetchRes.uid);
        modal.loading_progress(false);
    }

    const clear_import_table = () => {
        $(".import_table").empty();
    }

    const delete_temp_data = () => {
        const file = $("#file")[0].files[0];
        let nameWithoutExt = file.name.split('.').slice(0, -1).join('.');

        $.ajax({
            url: "<?= base_url('cms/import-winsight/delete-temp-winsight-data'); ?>",
            type: "POST",
            data: {
                fileName : nameWithoutExt,
                uid: fetchRes.uid
            },
            success: function (response) { 
                // alert(response) 
            },
            error: function (xhr, status, error) { 
                // alert(error) 
            }
        });
    }

    const fetchPaginatedData = (uid) => {
        const file = $("#file")[0].files[0];
        let file_name = file.name;
        let nameWithoutExt = file.name.split('.').slice(0, -1).join('.');
        let tds = $("tbody.import_table tr:first td");

        modal.loading(true);
        $.ajax({
            url: "<?= base_url('cms/import-winsight/fetch-temp-winsight-data'); ?>",
            method: "GET",
            data: {
                page: currentPage,
                limit: rowsPerPage,
                file_name: nameWithoutExt,
                uid: uid
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    totalPages = Math.ceil(response.totalRecords / rowsPerPage);
                    display_imported_data(response.data);
                } else {
                    modal.alert("Failed to fetch data.", "error");
                }
                modal.loading(false);
            },
            error: function() {
                modal.alert("Error fetching data.", "error");
                modal.loading(false);
            }
        });
    }

    const display_imported_data = (paginatedData) => {
        let html = "";
        let tr_counter = (currentPage - 1) * rowsPerPage;

        paginatedData.forEach(row => {
            let rowClass = (tr_counter % 2 === 0) ? "even-row" : "odd-row";
            html += `<tr class="${rowClass}">`;

            let lowerCaseRecord = Object.keys(row).reduce((acc, key) => {
                acc[key.toLowerCase()] = row[key];
                return acc;
            }, {});

            let td_validator = [
                'line_number',
                'bu_name',
                'supplier',
                'brand_name',
                'product_id',
                'product_name',
                'cat_1',
                'cat_2',
                'cat_3',
                'cat_4',
                'year',
                'month',
                'week',
                'date',
                'online_offline',
                'store_format',
                'store_segment',
                'gross_sales',
                'net_sales',
                'sales_qty',
                'barcode'
            ];
            td_validator.forEach(column => {
                let value = "";
                if (column == 'line_number') {
                    value = lowerCaseRecord[column] !== undefined ? lowerCaseRecord[column] : "";
                } else {
                    value = lowerCaseRecord[column] !== undefined ? lowerCaseRecord[column] : "";
                }

                if (column === 'status' && typeof value === 'string') {
                    value = value.replace(/\s*\(.*?\)/g, "");
                }

                html += `<td>${value}</td>`;
            });

            html += "</tr>";
            tr_counter += 1;
        });

        $(".import_table").html(html);
        updatePaginationControls();
    }

    const updatePaginationControls = () => {
        let paginationHtml = `
            <button onclick="goToPage(1)" ${currentPage === 1 ? "disabled" : ""}>
                <i class="fas fa-angle-double-left"></i>
            </button>
            <button onclick="changePage(-1)" ${currentPage === 1 ? "disabled" : ""}>
                <i class="fas fa-angle-left"></i>
            </button>
            
            <select onchange="goToPage(this.value)">
                ${Array.from({ length: totalPages }, (_, i) => 
                    `<option value="${i + 1}" ${i + 1 === currentPage ? "selected" : ""}>Page ${i + 1}</option>`
                ).join('')}
            </select>
            
            <button onclick="changePage(1)" ${currentPage === totalPages ? "disabled" : ""}>
                <i class="fas fa-angle-right"></i>
            </button>
            <button onclick="goToPage(totalPages)" ${currentPage === totalPages ? "disabled" : ""}>
                <i class="fas fa-angle-double-right"></i>
            </button>
        `;

        $(".import_pagination").html(paginationHtml);
    }

    const changePage = (offset) => {
        if ((offset === -1 && currentPage > 1) || (offset === 1 && currentPage < totalPages)) {
            currentPage += offset;
            fetchPaginatedData(fetchRes.uid);
        }
    }

    function goToPage(page){
        page = parseInt(page);
        if (page >= 1 && page <= totalPages) {
            currentPage = page;
            fetchPaginatedData(fetchRes.uid);
        }
    }

    const download_template = () => {
        let formattedData = [
            {
                "BU Name" : "",
                "Supplier" : "",
                "Brand Name" : "",
                "Product ID" : "",
                "Product Name" : "",
                "Category 1 (Item Classification)" : "",
                "Category 2 (Sub Classification)" : "",
                "Category 3 (Department)" : "",
                "Category 4 (Merch. Category)" : "",
                "Year" : "",
                "Month" : "",
                "Week" : "",
                "Date" : "",
                "Online/ Offline" : "",
                "Store Format" : "",
                "Store Segment" : "",
                "Gross Sales" : "",
                "Net Sales" : "",
                "Sales Qty" : "",
                "Barcode" : "",
                "NOTE:": "For column header: Month"
            },
            {
                "BU Name" : "",
                "Supplier" : "",
                "Brand Name" : "",
                "Product ID" : "",
                "Product Name" : "",
                "Category 1 (Item Classification)" : "",
                "Category 2 (Sub Classification)" : "",
                "Category 3 (Department)" : "",
                "Category 4 (Merch. Category)" : "",
                "Year" : "",
                "Month" : "",
                "Week" : "",
                "Date" : "",
                "Online/ Offline" : "",
                "Store Format" : "",
                "Store Segment" : "",
                "Gross Sales" : "",
                "Net Sales" : "",
                "Sales Qty" : "",
                "Barcode" : "",
                "NOTE:": "Do note that for this column the imported file will only take the last two characters of the entry."
            },
            {
                "BU Name" : "",
                "Supplier" : "",
                "Brand Name" : "",
                "Product ID" : "",
                "Product Name" : "",
                "Category 1 (Item Classification)" : "",
                "Category 2 (Sub Classification)" : "",
                "Category 3 (Department)" : "",
                "Category 4 (Merch. Category)" : "",
                "Year" : "",
                "Month" : "",
                "Week" : "",
                "Date" : "",
                "Online/ Offline" : "",
                "Store Format" : "",
                "Store Segment" : "",
                "Gross Sales" : "",
                "Net Sales" : "",
                "Sales Qty" : "",
                "Barcode" : "",
                "NOTE:": "Eg. XXXX07 will be saved as 07 denoting the month"
            },
            {
                "BU Name" : "",
                "Supplier" : "",
                "Brand Name" : "",
                "Product ID" : "",
                "Product Name" : "",
                "Category 1 (Item Classification)" : "",
                "Category 2 (Sub Classification)" : "",
                "Category 3 (Department)" : "",
                "Category 4 (Merch. Category)" : "",
                "Year" : "",
                "Month" : "",
                "Week" : "",
                "Date" : "",
                "Online/ Offline" : "",
                "Store Format" : "",
                "Store Segment" : "",
                "Gross Sales" : "",
                "Net Sales" : "",
                "Sales Qty" : "",
                "Barcode" : "",
                "NOTE:": "Please remember to remove these notes. Thank you!"
            }
        ]
        let headerData = [];
    
        exportArrayToCSV(formattedData, `Winsight Import Data Template - ${formatDate(new Date())}`, headerData);
    }

    const exportArrayToCSV = (data, filename, headerData) => {
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

    const process_xl_file = () => {
        const file = $("#file")[0].files[0];

        if (!file) {
            modal.loading_progress(false);
            modal.alert('Please select a file to upload', 'error', () => {});
            return;
        }

        const nameWithoutExt = file.name.split('.').slice(0, -1).join('.');

        let uid = fetchRes.uid;

        check_current_db(
            "tbl_winsight_header", 
            ["year", "month", "week"],
            [fetchRes.addtnl.year, fetchRes.addtnl.month, fetchRes.addtnl.week], 
            "id" , 
            null, 
            null,
            false, 
            function(exists, duplicateFields) {
                if (!exists) {
                    modal.loading(true, "Fetching all data from temporary table...");

                    let allData = [];

                    function fetchAllPages(page = 1) {
                        $.ajax({
                            url: "<?= base_url('cms/import-winsight/fetch-temp-winsight-data'); ?>",
                            method: "GET",
                            
                            data: { page, limit: 5000, file_name: nameWithoutExt, uid}, // Fetch in larger chunks
                            success: function(response) {
                                allData = allData.concat(response.data);
                                if (response.data.length === 5000) {
                                    fetchAllPages(page + 1);
                                } 
                                else {
                                    validate_temp_data(allData)
                                }
                            },
                            error: function(xhr) {
                                modal.loading(false);
                                modal.alert("Error fetching data: " + xhr.responseText, "error");
                            }
                        });
                    }

                    fetchAllPages()
                } else {
                    modal.alert("Data already exists", "error")
                }
            }
        )
    }

    const validate_temp_data = (data) => {
        let worker = new Worker(base_url + "assets/cms/js/validator_winsight.js");
        worker.postMessage({ data, base_url });

        worker.onmessage = function(e) {
            const { invalid, errorLogs, valid_data, err_counter } = e.data;

            if (invalid) {
                let errorMsg = err_counter > 1000
                    ? '⚠️ Too many errors detected. Please download the error log for details.'
                    : errorLogs.slice(0, 10).join("<br>") + (errorLogs.length > 10 ? "<br>...and more" : "");

                modal.content('Validation Error', 'error', errorMsg, '600px', () => { 
                    $(".btn.save").prop("disabled", false);
                });

                createErrorLogFile(errorLogs, `Error_${formatReadableDate(new Date(), true)}`);
            } else if (Array.isArray(valid_data) && valid_data.length > 0) { 
                let new_data = valid_data.map(record => ({
                    ...record
                }));

                saveHeaderData(function(header_id) {
                    saveValidatedData(valid_data, header_id);
                });
            } else {
                modal.alert("No valid data found. Please check the file.", "error");
            }
        }
    }

    const saveHeaderData = (callback) => {
        const file = $("#file")[0].files[0];
        let nameWithoutExt = file.name.split('.').slice(0, -1).join('.');

        let data = {
            uid: fetchRes.uid,
            year: fetchRes.addtnl.year,
            month: fetchRes.addtnl.month,
            week: fetchRes.addtnl.week,
            created_date: formatDate(new Date()),
            created_by: '<?=$session->sess_uid;?>',
            file_name: nameWithoutExt,
            status: 1
        };

        let payload = {
            event: "insert",
            table: "tbl_winsight_header",
            data: data
        };

        aJax.post(url, payload, function (result) {
            var obj = is_json(result);

            if (callback && typeof callback === "function") {
                callback(obj.ID);
            }
        });
    }

    const saveValidatedData = (valid_data, data_header_id) => {
        let batch_size = 1000;
        let total_batches = Math.ceil(valid_data.length / batch_size);
        let batch_index = 0;
        let errorLogs = [];
        let url = "<?= base_url('cms/global_controller');?>";
        let table = 'tbl_winsight_details';
        const start_time = new Date();
        
        modal.loading_progress(true, "Saving validated data...");

        function processNextBatch() {
            if (batch_index >= total_batches) {
                modal.loading_progress(false);

                if (errorLogs.length > 0) {
                    createErrorLogFile(errorLogs, "Insert_Error_Log_" + formatReadableDate(new Date(), true));
                    modal.alert("Some records encountered errors. Check the log.", 'info');
                } else {
                    modal.loading_progress(true, "Finalizing data...");
                    delete_temp_data();
                    setTimeout(function() {
                        modal.alert("All records inserted successfully!", 'success', function() {
                            let logData = valid_data.map(record => ({
                                ...record,
                                header_id: data_header_id,
                                uid: fetchRes.uid,
                                created_date: formatDate(new Date()),
                                created_by: '<?=$session->sess_uid;?>'
                            }));
                            logAll(start_time, logData);
                            window.location.href = "<?= base_url('cms/import-winsight') ?>";
                        });
                    }, 1000);
                }
                return;
            }

            let batch = valid_data.slice(batch_index * batch_size, (batch_index + 1) * batch_size);

            let newRecords = batch.map(record => ({
                ...record,
                header_id: data_header_id,
                uid: fetchRes.uid,
                created_date: formatDate(new Date()),
                created_by: '<?=$session->sess_uid;?>'
            }));

            batch_insert(url, newRecords, table, false, (response) => {
                if (response.message === 'success') {
                    updateSwalProgress("Inserting Records...", batch_index + 1, total_batches);
                } else {
                    errorLogs.push(`Batch insert failed: ${JSON.stringify(response.error)}`);
                }
                batch_index++;
                setTimeout(processNextBatch, 300);
            });
        }

        setTimeout(processNextBatch, 1000);
    };

    function logAll(start_time, valid_data) {
        const headers = 
        [
            `created_date`, `created_by`, `file_name`, `line_number`, 
            `bu_name`, `supplier`, `brand_name`, `product_id`, `product_name`,
            `cat_1`, `cat_2`, `cat_3`, `cat_4`,
            `year`, `month`, `week`,
            `online_offline`, `store_format`, `store_segment`,
            `gross_sales`, `net_sales`, `sales_qty`, `barcode`
        ];
        const url = "<?= base_url('cms/global_controller/save_import_log_file') ?>";
        saveImportDetailsToServer(valid_data, headers, 'import_winsight', url, function(filePath) {
            const end_time = new Date();
            const duration = formatDuration(start_time, end_time);

            let remarks = `
                Import Completed Successfully!
                <br>Total Records: ${valid_data.length}
                <br>Start Time: ${formatReadableDate(start_time)}
                <br>End Time: ${formatReadableDate(end_time)}
                <br>Duration: ${duration}`;

            let link = filePath ? `<a href="<?= base_url() ?>${filePath}" target="_blank">View Details</a>` : null;

            logActivity('Import Winsight Module', 'Import Data', remarks, link, null, null);
        });
    }
</script>