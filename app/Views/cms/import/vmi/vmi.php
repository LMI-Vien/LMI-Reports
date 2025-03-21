<style>
    @media (min-width: 1200px) {
        .modal-xxl {
            max-width: 95%;
        }
    }

    .card {
        margin-right: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .uniform-dropdown {
        height: 36px;
        font-size: 14px;
        border-radius: 5px;
        min-width: 120px; 
        flex-grow: 1; 
    }
    
    .d-flex {
        gap: 10px; 
        margin: 5px;
    }

    th, td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

</style>

<div class="content-wrapper p-4">
    <div class="card">
        <div class="text-center page-title md-center">
            <b>I M P O R T - V M I</b>
        </div>
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
                                    <th class='center-content'>Imported Date</th>
                                    <th class='center-content'>Imported By</th>
                                    <th class='center-content'>Company</th>
                                    <th class='center-content'>Year</th>
                                    <th class='center-content'>Month</th>
                                    <th class='center-content'>Week</th>
                                    <th class='center-content'>Date Modified</th>
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

<!-- IMPORT MODAL -->
<div class="modal" tabindex="-1" id="import_modal">
    <div class="modal-dialog modal-xxl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">
                    <b></b>
                </h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card p-3">
                    <div class="mb-3">
                        <div class="text-center p-2" 
                            style="font-family: 'Courier New', Courier, monospace; font-size: large; background-color: #fdb92a; color: #333333; border-radius: 10px;">
                            <b>Extracted Data</b>
                        </div>

                        <div class="row my-3">
                            <div class="col-md-8 import_buttons">
                                <label for="file" class="btn btn-warning mt-2" style="margin-bottom: 0px;">
                                    <i class="fa fa-file-import me-2"></i> Custom Upload
                                </label>
                                <input type="file" id="file" accept=".xls,.xlsx,.csv" style="display: none;" onclick="clear_import_table()">

                                <button class="btn btn-primary mt-2" id="preview_xl_file" onclick="read_xl_file()">
                                    <i class="fa fa-sync me-2"></i> Preview Data
                                </button>

                                <button class="btn btn-success mt-2" id="download_template" onclick="download_template()">
                                    <i class="fa fa-file-download me-2"></i> Download Import Template
                                </button>
                            </div>

                            <div class="col-md-4">
                                <div class="card p-4 shadow-lg rounded-3 border-0" style="background: #f8f9fa;">
                                    <div class="row g-3">
                                        <div class="col-12 d-flex align-items-center">
                                            <label for="yearSelect" class="form-label fw-semibold me-2">Choose Year:</label>
                                            <select id="yearSelect" class="form-select uniform-dropdown">
                                            </select>
                                        </div>
                                        <div class="col-12 d-flex align-items-center">
                                            <label for="monthSelect" class="form-label fw-semibold me-2">Choose Month:</label>
                                            <select id="monthSelect" class="form-select uniform-dropdown">
                                            </select>
                                        </div>
                                        <div class="col-12 d-flex align-items-center">
                                            <label for="weekSelect" class="form-label fw-semibold me-2">Choose Week:</label>
                                            <select id="weekSelect" class="form-select uniform-dropdown">
                                            </select>
                                        </div>
                                        <div class="col-12 d-flex align-items-center">
                                            <label for="companySelect" class="form-label fw-semibold me-2">Choose Company:</label>
                                            <select id="companySelect" class="form-select uniform-dropdown">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div style="overflow-x: auto; max-height: 400px;">
                            <table class="table table-bordered listdata">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th>Line #</th>
                                        <th>Store</th>
                                        <th>Item</th>
                                        <th>Item Name</th>
                                        <th>VMI Status</th>
                                        <th>Item Class</th>
                                        <th>Supplier</th>
                                        <th>Group</th>
                                        <th>Dept</th>
                                        <th>Class</th>
                                        <th>Sub-class</th>
                                        <th>On Hand</th>
                                        <th>In transit</th>
                                        <th>Ave Sales Unit</th>
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

<div class="modal" tabindex="-1" id="export_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">
                    <b></b>
                </h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card p-4 shadow-lg rounded-3 border-0" style="background: #f8f9fa;">
                    <div class="row g-3">
                        <div class="col-12 d-flex align-items-center">
                            <label for="year_select" class="form-label fw-semibold me-2">Choose Year:</label>
                            <select id="year_select" class="form-select uniform-dropdown">
                            </select>
                        </div>
                        <div class="col-12 d-flex align-items-center">
                            <label for="month_select" class="form-label fw-semibold me-2">Choose Month:</label>
                            <select id="month_select" class="form-select uniform-dropdown">
                            </select>
                        </div>
                        <div class="col-12 d-flex align-items-center">
                            <label for="week_select" class="form-label fw-semibold me-2">Choose Week:</label>
                            <select id="week_select" class="form-select uniform-dropdown">
                            </select>
                        </div>
                        <div class="col-12 d-flex align-items-center">
                            <label for="company_select" class="form-label fw-semibold me-2">Choose Company:</label>
                            <select id="company_select" class="form-select uniform-dropdown">
                            </select>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="modal-footer">
                <button type="button" class="btn save" onclick="handleExport()">Export All</button>
                <button type="button" class="btn save" onclick="exportFilter()">Export Filter</button>
                <button type="button" class="btn caution" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    var query = "v.status >= 0";
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url('cms/global_controller');?>";

    //for importing
    let currentPage = 1;
    let rowsPerPage = 1000;
    let totalPages = 1;
    let dataset = [];

    $(document).ready(function() {
      get_data(query);
      get_pagination(query);
    });

    function get_data(new_query) {
        var data = {
            event: "list",
            select: "c.name AS company, y.year as year, m.month, w.name week, v.created_date, v.updated_date, u.name as imported_by",
            query: new_query,
            offset: offset,
            limit: limit,
            table: "tbl_vmi v",
            join: [
                {
                    table: "cms_users u",
                    query: "u.id = v.created_by",
                    type: "left"
                },
                {
                    table: "tbl_company c",
                    query: "c.id = v.company",
                    type: "left"
                },
                {
                    table: "tbl_year y",
                    query: "y.id = v.year",
                    type: "left"
                },
                {
                    table: "tbl_month m",
                    query: "m.id = v.month",
                    type: "left"
                },
                {
                    table: "tbl_week w",
                    query: "w.id = v.week",
                    type: "left"
                }
            ],
            order: {
                field: "v.year",
                order: "asc"
            },
            group : "v.year, v.month, v.week, c.name"
        };
        console.log(data, 'data')

        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            var html = '';

            if(result) {
                if (result.length > 0) {
                    $.each(result, function(x,y) {
                        var status = ( parseInt(y.status) === 1 ) ? status = "Active" : status = "Inactive";
                        var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";

                        html += "<tr class='" + rowClass + "'>";
                        html += "<td scope=\"col\">" + (y.created_date ? ViewDateformat(y.created_date) : "N/A") + "</td>";
                        html += "<td scope=\"col\">" + (y.imported_by) + "</td>";
                        html += "<td scope=\"col\">" + (y.company) + "</td>";
                        html += "<td scope=\"col\">" + (y.year) + "</td>";
                        html += "<td scope=\"col\">" + (y.month) + "</td>";
                        html += "<td scope=\"col\">" + (y.week) + "</td>";
                        html += "<td scope=\"col\">" + (y.updated_date ? ViewDateformat(y.updated_date) : "N/A") + "</td>";

                        let href = "<?= base_url()?>"+"cms/import-vmi/view/"+`${y.company}-${y.year}-${y.month}-${y.week}`;

                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                            html+="<td class='center-content' style='width: 25%; min-width: 200px'>";
                            html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.company+"','"+y.year+"','"+y.month+"','"+y.week+
                            "')\" data-status='"+y.status+"' id='"+y.id+
                            "' title='Delete Item'><span class='glyphicon glyphicon-pencil'>Delete</span>";
                            
                            html+="<a class='btn-sm btn view' href='"+ href +"' data-status='"+y.status+
                            "' target='_blank' id='"+y.id+
                            "' title='View'><span class='glyphicon glyphicon-pencil'>View</span>";

                            html+="<a class='btn-sm btn save' onclick=\"export_data('"+y.company+"','"+y.year+"','"+y.month+"','"+y.week+
                            "')\" data-status='"+y.status+"' id='"+y.id+
                            "' title='Export Batch'><span class='glyphicon glyphicon-pencil'>Export</span>";

                            html+="</td>";
                        }
                        
                        html += "</tr>";   
                    });
                } else {
                    html = '<tr><td colspan=18 class="center-align-format">'+ no_records +'</td></tr>';
                }
            }
            $('.table_body').html(html);
        });
    }

    function get_pagination(new_query) {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
          event : "pagination",
          select: "c.name AS company, y.year as year, m.month, w.name week",
          query: new_query,
          offset: offset,
          limit: limit,
          table: "tbl_vmi v",
          join: [
              {
                  table: "tbl_company c",
                  query: "c.id = v.company",
                  type: "left"
              },
              {
                  table: "tbl_year y",
                  query: "y.id = v.year",
                  type: "left"
              },
              {
                  table: "tbl_month m",
                  query: "m.id = v.month",
                  type: "left"
              },
              {
                  table: "tbl_week w",
                  query: "w.id = v.week",
                  type: "left"
              }
          ],
          order: {
              field: "v.year",
              order: "asc"
          },
          group : "v.year, v.month, v.week, c.name"
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
            offset = 1;
            var new_query = "(" + query + " AND c.name LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND y.year LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND m.month LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND w.name LIKE '%" + keyword + "%')";
            get_data(new_query);
            get_pagination(new_query);
        }
    });

    $(document).on("change", ".record-entries", function(e) {
        $(".record-entries option").removeAttr("selected");
        $(".record-entries").val($(this).val());
        $(".record-entries option:selected").attr("selected","selected");
        var record_entries = $(this).prop( "selected",true ).val();
        limit = parseInt(record_entries);
        offset = 1;
        modal.loading(true); 
        get_data(query);
        get_pagination(query);
        modal.loading(false);
    });

    function clear_import_table() {
        $(".import_table").empty();
    }

    function paginateData(rowsPerPage) {
        totalPages = Math.ceil(dataset.length / rowsPerPage);
        currentPage = 1;
        display_imported_data();
    }


    $(document).on('click', '#btn_import ', function() {
        title = addNbsp('IMPORT VMI')
        $("#import_modal").find('.modal-title').find('b').html(title)
        $('#import_modal').modal('show');
        get_year('yearSelect');
        get_month('monthSelect');
        get_company('companySelect');
        get_week('weekSelect');
    });

    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0'); 
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');

        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }

    function addNbsp(inputString) {
        return inputString.split('').map(char => {
            if (char === ' ') {
            return '&nbsp;&nbsp;';
            }
            return char + '&nbsp;';
        }).join('');
    }

    // function read_xl_file() {
    //     let btn = $(".btn.save");
    //     btn.prop("disabled", false); 
    //     clear_import_table();
        
    //     dataset = [];

    //     const file = $("#file")[0].files[0];
    //     if (!file) {
    //         modal.loading_progress(false);
    //         modal.alert('Please select a file to upload', 'error', ()=>{});
    //         return;
    //     }
    //     modal.loading_progress(true, "Reviewing Data...");

    //     const reader = new FileReader();
    //     reader.onload = function(e) {
    //         const data = new Uint8Array(e.target.result);
    //         const workbook = XLSX.read(data, { type: "array" });
    //         const sheet = workbook.Sheets[workbook.SheetNames[0]];

    //         const jsonData = XLSX.utils.sheet_to_json(sheet, { raw: false });

    //         processInChunks(jsonData, 5000, () => {
    //             paginateData(rowsPerPage);
    //         });
    //     };
    //     reader.readAsArrayBuffer(file);
    // }

    // with special characters
    function read_xl_file() {
        let btn = $(".btn.save");
        btn.prop("disabled", false);
        clear_import_table();

        dataset = [];

        const file = $("#file")[0].files[0];
        if (!file) {
            modal.loading_progress(false);
            modal.alert('Please select a file to upload', 'error', () => {});
            return;
        }

        // const maxFileSize = 30 * 1024 * 1024; // 30MB limit
        // if (file.size > maxFileSize) {
        //     modal.loading_progress(false);
        //     modal.alert('The file size exceeds the 30MB limit. Please upload a smaller file.', 'error', () => {});
        //     return;
        // }

        modal.loading_progress(true, "Reviewing Data...");

        const reader = new FileReader();
        reader.onload = function(e) {
            const data = e.target.result;

            // Read as binary instead of plain text
            const workbook = XLSX.read(data, { type: "binary", raw: true });
            const sheet = workbook.Sheets[workbook.SheetNames[0]];

            let jsonData = XLSX.utils.sheet_to_json(sheet, { raw: true });

            // Ensure special characters like "ñ" are correctly preserved
            jsonData = jsonData.map(row => {
                let fixedRow = {};
                Object.keys(row).forEach(key => {
                    let value = row[key];

                    // Convert numbers to text while keeping dates unchanged
                    if (typeof value === "number") {
                        value = String(value);
                    }

                    fixedRow[key] = value !== null && value !== undefined ? value : "";
                });
                return fixedRow;
            });

            console.log(jsonData);

            processInChunks(jsonData, 5000, () => {
                paginateData(rowsPerPage);
            });
        };

        // Use readAsBinaryString instead of readAsText
        reader.readAsBinaryString(file);
    }

    function process_xl_file() {
        let btn = $(".btn.save");
        if (btn.prop("disabled")) return;

        btn.prop("disabled", true);
        $(".import_buttons").find("a.download-error-log").remove();
         setTimeout(() => {
                btn.prop("disabled", false);
            }, 4000);
        const inp_year = $('#yearSelect').val()?.trim();
        const inp_month = $('#monthSelect').val()?.trim();
        const inp_week = $('#weekSelect').val()?.trim();
        const inp_company = $('#companySelect').val()?.trim();

        const fields = { inp_year, inp_month, inp_week, inp_company };

        for (const [key, value] of Object.entries(fields)) {
            if (!value) {
                return modal.alert(`Please select a ${key.charAt(4).toUpperCase() + key.slice(5)}.`, 'error', () => {});
            }
        }

        if (dataset.length === 0) {
            return modal.alert('No data to process. Please upload a file.', 'error', () => {});
        }
        modal.loading(true);

        let jsonData = dataset.map(row => {
            return {
                "Store": row["Store"] || "",
                "Item": row["Item"] || "",
                "Item Name": row["Item Name"] || "",
                "VMI Status": row["VMI Status"] || "",
                "Item Class": row["Item Class"] || "",
                "Supplier": row["Supplier"] || "",
                "Group": row["Group"] || "",
                "Dept": row["Dept"] || "",
                "Class": row["Class"] || "",
                "Sub Class": row["Sub Class"] || "",
                "On Hand": row["On Hand"] || "",
                "In Transit": row["In Transit"] || "",
                "Ave Sales Unit": row["Ave Sales Unit"] || "",
                "Created by": user_id || "", 
                "Created Date": formatDate(new Date()) || ""
            };
        });


        let worker = new Worker(base_url + "assets/cms/js/validator_vmi.js");
        worker.postMessage({ data: jsonData, base_url, inp_company });

        worker.onmessage = function(e) {
            modal.loading_progress(false);
            const { invalid, errorLogs, valid_data, err_counter, progress } = e.data;
            if(progress == 100){
                if (invalid) {
                    let errorMsg = err_counter > 1000 
                        ? '⚠️ Too many errors detected. Please download the error log for details.'
                        : errorLogs.join("<br>");
                    modal.content('Validation Error', 'error', errorMsg, '600px', () => { 
                        read_xl_file();
                        btn.prop("disabled", false);
                    });
                    createErrorLogFile(errorLogs, "Error " + formatReadableDate(new Date(), true));
                } else if (valid_data && valid_data.length > 0) {
                    btn.prop("disabled", false);
                    updateSwalProgress("Validation Completed", 10);
                    new_data = valid_data.map(record => ({
                        ...record,
                        year: inp_year,
                        month: inp_month,
                        week: inp_week,
                        company: inp_company
                    }));
                    setTimeout(() => saveValidatedData(new_data), 500);
                } else {
                    btn.prop("disabled", false);
                    modal.alert("No valid data returned. Please check the file and try again.", "error", () => {});
                }
            }else{
                //modal.loading(false);
                //modal.loading_progress(true); 
                //updateSwalProgress("Validating data...", progress);
            
            }

        };

        worker.onerror = function() {
            modal.loading_progress(false);
            modal.alert("Error processing data. Please try again.", "error");
        };
    }

    function processInChunks(data, chunkSize, callback) {
        let index = 0;
        let totalRecords = data.length;
        let totalProcessed = 0;

        function nextChunk() {
            if (index >= data.length) {
                modal.loading_progress(false);
                callback(); 
                return;
            }

            let chunk = data.slice(index, index + chunkSize);
            dataset = dataset.concat(chunk);
            totalProcessed += chunk.length; 
            index += chunkSize;

            let progress = Math.min(100, Math.round((totalProcessed / totalRecords) * 100));
            updateSwalProgress("Preview Data", progress);
            requestAnimationFrame(nextChunk);
        }
        nextChunk();
    }

    function display_imported_data() {
        let start = (currentPage - 1) * rowsPerPage;
        let end = start + rowsPerPage;
        let paginatedData = dataset.slice(start, end);

        let html = '';
        let tr_counter = start;

        paginatedData.forEach(row => {
            let rowClass = (tr_counter % 2 === 0) ? "even-row" : "odd-row";
            html += `<tr class="${rowClass}">`;
            html += `<td>${tr_counter + 1}</td>`;

            let lowerCaseRecord = Object.keys(row).reduce((acc, key) => {
                acc[key.toLowerCase()] = row[key];
                return acc;
            }, {});

            let td_validator = ['store', 'item', 'item name', 'vmi status', 'item class', 'supplier', 'group', 'dept', 'class', 'sub class', 'on hand', 'in transit', 'ave sales unit'];
            td_validator.forEach(column => {
                let value = lowerCaseRecord[column] !== undefined ? lowerCaseRecord[column] : ""; 

                if (column === 'status' && typeof value === 'string') {
                    value = value.replace(/\s*\(.*?\)/g, "");
                }

                html += `<td>${value}</td>`;
            });

            html += "</tr>";
            tr_counter += 1;
        });

        modal.loading(false);
        $(".import_table").html(html);
        updatePaginationControls();
    }

    function saveValidatedData(valid_data) {
        let batch_size = 5000;
        let total_batches = Math.ceil(valid_data.length / batch_size);
        let batch_index = 0;
        let errorLogs = [];
        let url = "<?= base_url('cms/global_controller');?>";
        let table = 'tbl_vmi';

        let selected_fields = [
            'id', 'store', 'item', 'item_name', 'vmi_status', 'item_class',
            'supplier', 'group', 'dept', 'class', 'sub_class', 'on_hand', 
            'in_transit', 'year', 'month', 'week', 'company'
        ];

        const matchFields = [
            'store', 'item', 'item_name', 'vmi_status', 'item_class', 'supplier', 
            'group', 'dept', 'class', 'sub_class', 'on_hand', 'in_transit', 'year', 'month', 'week', 'company'
        ];  

        const matchType = "AND";  // Use "AND" or "OR" for matching logic

        modal.loading_progress(true, "Validating and Saving data...");

        aJax.post(url, { table: table, event: "fetch_existing", selected_fields: selected_fields }, function(response) {
            let result = JSON.parse(response);
            let existingMap = new Map();

            if (result.existing) {
                result.existing.forEach(record => {
                    let key = matchFields.map(field => String(record[field] || "").trim().toLowerCase()).join("|");
                    existingMap.set(key, record.id);
                });
            }

            function processNextBatch() {
                if (batch_index >= total_batches) {
                    modal.loading_progress(false);
                    if (errorLogs.length > 0) {
                        createErrorLogFile(errorLogs, "Update_Error_Log_" + formatReadableDate(new Date(), true));
                        modal.alert("Some records encountered errors. Check the log.", 'info');
                    } else {
                        modal.alert("All records saved/updated successfully!", 'success', () => location.reload());
                    }
                    return;
                }

                let batch = valid_data.slice(batch_index * batch_size, (batch_index + 1) * batch_size);
                let newRecords = [];
                let updateRecords = [];

                batch.forEach(row => {
                    let matchedId = null;

                    if (matchType === "AND") {
                        let key = matchFields.map(field => String(row[field] || "").trim().toLowerCase()).join("|");
                        if (existingMap.has(key)) {
                            matchedId = existingMap.get(key);
                        }
                    } else if (matchType === "OR") {
                        for (let [key, id] of existingMap.entries()) {
                            let keyParts = key.split("|");
                            for (let field of matchFields) {
                                if (keyParts.includes(String(row[field] || "").trim().toLowerCase())) {
                                    matchedId = id;
                                    break; 
                                }
                            }
                            if (matchedId) break;
                        }
                    }

                    if (matchedId) {
                        row.id = matchedId;
                        row.updated_by = user_id;
                        row.updated_date = formatDate(new Date());
                        delete row.created_by; // to prevent overwritting the created by
                        delete row.created_date; // Unset created_date
                        updateRecords.push(row);
                    } else {
                        row.created_by = user_id;
                        row.created_date = formatDate(new Date());
                        newRecords.push(row);
                    }
                });

                function processUpdates() {
                    return new Promise((resolve) => {
                        if (updateRecords.length > 0) {
                            batch_update(url, updateRecords, table, "id", false, (response) => {
                                if (response.message !== 'success') {
                                    errorLogs.push(`Failed to update: ${JSON.stringify(response.error)}`);
                                }
                                updateSwalProgress("Updating Records...", batch_index + 1, total_batches);
                                resolve();
                            });
                        } else {
                            resolve();
                        }
                    });
                }

                function processInserts() {
                    return new Promise((resolve) => {
                        if (newRecords.length > 0) {
                            console.log(newRecords, 'newRecords')
                            batch_insert(url, newRecords, table, false, (response) => {
                                if (response.message === 'success') {
                                    updateSwalProgress("Inserting Records...", batch_index + 1, total_batches);
                                } else {
                                    errorLogs.push(`Batch insert failed: ${JSON.stringify(response.error)}`);
                                }
                                resolve();
                            });
                        } else {
                            resolve();
                        }
                    });
                }

                processUpdates()
                    .then(processInserts)
                    .then(() => {
                        batch_index++;
                        setTimeout(processNextBatch, 300);
                    })
                    .catch(error => {
                        errorLogs.push(`Unexpected error: ${error}`);
                        processNextBatch();
                    });
            }

            setTimeout(processNextBatch, 1000);
        });
    }

    function updatePaginationControls() {
        let paginationHtml = `
            <button onclick="firstPage()" ${currentPage === 1 ? "disabled" : ""}><i class="fas fa-angle-double-left"></i></button>
            <button onclick="prevPage()" ${currentPage === 1 ? "disabled" : ""}><i class="fas fa-angle-left"></i></button>
            
            <select onchange="goToPage(this.value)">
                ${Array.from({ length: totalPages }, (_, i) => 
                    `<option value="${i + 1}" ${i + 1 === currentPage ? "selected" : ""}>Page ${i + 1}</option>`
                ).join('')}
            </select>
            
            <button onclick="nextPage()" ${currentPage === totalPages ? "disabled" : ""}><i class="fas fa-angle-right"></i></button>
            <button onclick="lastPage()" ${currentPage === totalPages ? "disabled" : ""}><i class="fas fa-angle-double-right"></i></button>
        `;

        $(".import_pagination").html(paginationHtml);
    }

    function createErrorLogFile(errorLogs, filename) {
        let errorText = errorLogs.join("\n");
        let blob = new Blob([errorText], { type: "text/plain" });
        let url = URL.createObjectURL(blob);

        $(".import_buttons").find("a.download-error-log").remove();

        let $downloadBtn = $("<a>", {
            href: url,
            download: filename+".txt",
            text: "Download Error Logs",
            class: "download-error-log btn btn-danger mt-2", 
            css: {
                border: "1px solid white",
                borderRadius: "10px",
                display: "inline-block",
                background: "#990000",
                color: "white",
                textAlign: "center",
                cursor: "pointer",
                textDecoration: "none",
                boxShadow: "6px 6px 15px rgba(0, 0, 0, 0.5)",
            }
        });

        $(".import_buttons").append($downloadBtn);
    }

    function get_year(selected_class) {
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list",
            select : "id, year, status",
            query : 'status >= 0',
            offset : 0,
            limit : 0,
            table : "tbl_year",
            order : {
                field : "id",
                order : "asc" 
            }
        }

        aJax.post(url,data,function(res){
            var result = JSON.parse(res);
            var html = '';
            html += '<option id="default_val" value=" ">Select Year</option>';

    
            if(result) {
                if (result.length > 0) {
                    var selected = '';
                    
                    result.forEach(function (y) {
                        html += `<option value="${y.id}">${y.year}</option>`;
                    });
                }
            }
            $('#'+selected_class).html(html);
        })
    }

    function get_month(selected_class) {
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list",
            select : "id, month, status",
            query : 'status >= 0',
            offset : 0,
            limit : 0,
            table : "tbl_month",
            order : {
                field : "id",
                order : "asc" 
            }
        }

        aJax.post(url,data,function(res){
            var result = JSON.parse(res);
            var html = '';
            html += '<option id="default_val" value=" ">Select Month</option>';
            
    
            if(result) {
                if (result.length > 0) {
                    var selected = '';
                    
                    result.forEach(function (y) {
                        html += `<option value="${y.id}">${y.month}</option>`;
                    });
                }
            }
            $('#'+selected_class).html(html);
        })
    }

    function get_week(selected_class) {
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list",
            select : "id, name, status",
            query : 'status >= 0',
            offset : 0,
            limit : 0,
            table : "tbl_week",
            order : {
                field : "id",
                order : "asc" 
            }
        }

        aJax.post(url,data,function(res){
            var result = JSON.parse(res);
            var html = '';
            html += '<option id="default_val" value=" ">Select Week</option>';
            
    
            if(result) {
                if (result.length > 0) {
                    var selected = '';
                    
                    result.forEach(function (y) {
                        html += `<option value="${y.id}">${y.name}</option>`;
                    });
                }
            }
            $('#'+selected_class).html(html);
        })
    }

    function get_company(selected_class) {
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list",
            select : "id, name, status",
            query : 'status >= 0',
            offset : 0,
            limit : 0,
            table : "tbl_company",
            order : {
                field : "id",
                order : "asc" 
            }
        }

        aJax.post(url,data,function(res){
            var result = JSON.parse(res);
            var html = '';
            html += '<option id="default_val" value=" ">Select Company</option>';
            
    
            if(result) {
                if (result.length > 0) {
                    var selected = '';
                    
                    result.forEach(function (y) {
                        html += `<option value="${y.id}">${y.name}</option>`;
                    });
                }
            }
            $('#'+selected_class).html(html);
        })
    }

    function download_template() {
        let formattedData = [
            {
                "Store":"", 
                "Item":"", 
                "Item Name":"", 
                "VMI Status":"", 
                "Item Class":"", 
                "Supplier":"", 
                "Group":"", 
                "Dept":"", 
                "Class":"", 
                "Sub Class":"", 
                "On Hand":"", 
                "In Transit":"", 
                "Ave Sales Unit":"", 
                "NOTE:": "Please do not change the column headers."
            }
        ]
        const headerData = [];
    
        exportArrayToCSV(formattedData, `VMI - ${formatDate(new Date())}`, headerData);
    }

    $(document).on('click', '#btn_export ', function() {
        title = addNbsp('EXPORT VMI')
        $("#export_modal").find('.modal-title').find('b').html(title)
        $('#export_modal').modal('show');
        get_year('year_select');
        get_month('month_select');
        get_week('week_select');
        get_company('company_select');
    });

    function exportFilter() {
        var formattedData = [];

        const company = $('#company_select').val()?.trim();
        const year = $('#year_select').val()?.trim();
        const month = $('#month_select').val()?.trim();
        const week = $('#week_select').val()?.trim();

        let filterArr = []
        if(company) {
            filterArr.push(`company:EQ=${company}`);
        }
        if(year) {
            filterArr.push(`year:EQ=${year}`);
        }
        if(month) {
            filterArr.push(`month:EQ=${month}`);
        }
        if(week) {
            filterArr.push(`week:EQ=${week}`);
        }

        let filter = filterArr.join(',')

        modal.confirm(confirm_export_message,function(result){
            if (result) {
                modal.loading_progress(true, "Reviewing Data...");
                setTimeout(() => {
                    startExport()
                }, 500);
            }
        })

        const startExport = () => {
            dynamic_search(
                "'tbl_vmi'", 
                "''", 
                "'store, item, item_name, item_class, supplier, `group`, dept, class as classification, sub_class, on_hand, in_transit, average_sales_unit, company, vmi_status, year, month, week'", 
                0, 
                0, 
                `'${filter}'`,  
                `''`, 
                `''`,
                (res) => {
                    let store_ids = []
                    let store_map = {}
            
                    res.forEach(stores => {
                        store_ids.push(`${stores.store}`);
                    });
            
                    dynamic_search(
                        "'tbl_store'", 
                        "''", 
                        "'id, code, description'", 
                        0, 
                        0, 
                        `'id:IN=${store_ids.join('|')}'`,  
                        `''`, 
                        `''`,
                        (result) => {
                            result.forEach(store => {
                                if (!store_map[store.id]) {
                                    store_map[store.id] = {}; // Initialize as an object
                                }
                                store_map[store.id].description = store.description;
                                store_map[store.id].code = store.code;
                            });
                        }
                    );

                    spacing = {
                        "Store":"", 
                        "Item":"", 
                        "Item Name":"", 
                        "VMI Status":"", 
                        "Item Class":"", 
                        "Supplier":"", 
                        "Group":"", 
                        "Dept":"", 
                        "Class":"", 
                        "Sub Class":"", 
                        "On Hand":"", 
                        "In Transit":"", 
                        "Ave Sales Unit":"", 
                    }

                    let previousRecord = null;
                    let count = 0;
                    res.forEach(det => {
                        let rec_company = det.company;
                        let rec_year = det.year;
                        let rec_month = det.month;
                        let rec_week = det.week;
                        let currentRecord = { rec_company, rec_year, rec_month, rec_week };

                        console.log(currentRecord, count+1)
                        count+=1;

                        let newData = {
                            "Store":store_map[`${det.store}`].code, 
                            "Item":det.item, 
                            "Item Name":det.item_name, 
                            "VMI Status":det.vmi_status, 
                            "Item Class":det.item_class, 
                            "Supplier":det.supplier, 
                            "Group":det.group, 
                            "Dept":det.dept, 
                            "Class":det.classification, 
                            "Sub Class":det.sub_class, 
                            "On Hand":det.on_hand, 
                            "In Transit":det.in_transit, 
                            "Ave Sales Unit":det.average_sales_unit, 
                        }

                        if (previousRecord && 
                            (
                                previousRecord.rec_company !== det.company || 
                                previousRecord.rec_year !== det.year || 
                                previousRecord.rec_month !== det.month || 
                                previousRecord.rec_week !== det.week
                            )
                        ) {
                            formattedData.push(spacing)
                            console.log('spaced')
                        }
                        formattedData.push(newData)
                        previousRecord = currentRecord;
                    })
                }
            )
    
            const headerData = [
                ["Company Name: Lifestrong Marketing Inc."],
                ["VMI"],
                ["Date Printed: " + formatDate(new Date())],
                [""],
            ];
    
            exportArrayToCSV(formattedData, `VMI - ${formatDate(new Date())}`, headerData);
            modal.loading_progress(false);
        }
    }

    function handleExport() {
        var formattedData = [];

        modal.confirm(confirm_export_message,function(result){
            if (result) {
                modal.loading_progress(true, "Reviewing Data...");
                setTimeout(() => {
                    startExport()
                }, 500);
            }
        })

        const startExport = () => {
            const batch_export = () => {
                dynamic_search(
                    "'tbl_vmi'", 
                    "''", 
                    `'COUNT(id) as total_records'`, 
                    0, 
                    0, 
                    `''`,  
                    `''`, 
                    `''`,
                    (res) => {
                        if (res && res.length > 0) {
                            let total_records = res[0].total_records;

                            for (let index = 0; index < total_records; index += 100000) {
                                dynamic_search(
                                    "'tbl_vmi'", 
                                    "''", 
                                    `'store, item, item_name, item_class, supplier, \`group\`, dept, class as classification, sub_class, on_hand, in_transit, average_sales_unit, company, vmi_status, year, month, week'`, 
                                    100000, 
                                    index, 
                                    `''`,  
                                    `''`, 
                                    `''`,
                                    (res) => {
                                        let store_ids = []
                                        let store_map = {}

                                        res.forEach(stores => {
                                            store_ids.push(`${stores.store}`);
                                        });

                                        dynamic_search(
                                            "'tbl_store'", 
                                            "''", 
                                            "'id, code, description'", 
                                            0, 
                                            0, 
                                            `'id:IN=${store_ids.join('|')}'`,  
                                            `''`, 
                                            `''`,
                                            (result) => {
                                                result.forEach(store => {
                                                    if (!store_map[store.id]) {
                                                        store_map[store.id] = {}; // Initialize as an object
                                                    }
                                                    store_map[store.id].description = store.description;
                                                    store_map[store.id].code = store.code;
                                                });
                                            }
                                        );

                                        spacing = {
                                            "Store":"", 
                                            "Item":"", 
                                            "Item Name":"", 
                                            "VMI Status":"", 
                                            "Item Class":"", 
                                            "Supplier":"", 
                                            "Group":"", 
                                            "Dept":"", 
                                            "Class":"", 
                                            "Sub Class":"", 
                                            "On Hand":"", 
                                            "In Transit":"", 
                                            "Ave Sales Unit":"", 
                                        }

                                        let previousRecord = null;
                                        let count = 0;
                                        res.forEach(det => {
                                            let rec_company = det.company;
                                            let rec_year = det.year;
                                            let rec_month = det.month;
                                            let rec_week = det.week;
                                            let currentRecord = { rec_company, rec_year, rec_month, rec_week };

                                            console.log(currentRecord, count+1)
                                            count+=1;

                                            let newData = {
                                                "Store":store_map[`${det.store}`].code, 
                                                "Item":det.item, 
                                                "Item Name":det.item_name, 
                                                "VMI Status":det.vmi_status, 
                                                "Item Class":det.item_class, 
                                                "Supplier":det.supplier, 
                                                "Group":det.group, 
                                                "Dept":det.dept, 
                                                "Class":det.classification, 
                                                "Sub Class":det.sub_class, 
                                                "On Hand":det.on_hand, 
                                                "In Transit":det.in_transit, 
                                                "Ave Sales Unit":det.average_sales_unit, 
                                            }

                                            if (previousRecord && 
                                                (
                                                    previousRecord.rec_company !== det.company || 
                                                    previousRecord.rec_year !== det.year || 
                                                    previousRecord.rec_month !== det.month || 
                                                    previousRecord.rec_week !== det.week
                                                )
                                            ) {
                                                formattedData.push(spacing)
                                                console.log('spaced')
                                            }
                                            formattedData.push(newData)
                                            previousRecord = currentRecord;
                                        })
                                    }
                                )
                            }
                        } else {
                            console.log('No data received');
                        }
                    }
                )
            };

            batch_export();

            const headerData = [
                ["Company Name: Lifestrong Marketing Inc."],
                ["VMI"],
                ["Date Printed: " + formatDate(new Date())],
                [""],
            ];

            exportArrayToCSV(formattedData, `VMI - ${formatDate(new Date())}`, headerData);
            modal.loading_progress(false);
        }
    }

    function export_data(company, year, month, week) {
        var formattedData = [];
        let filterArr = []
        filterArr.push(`c.name:EQ=${company}`);
        filterArr.push(`y.year:EQ=${year}`);
        filterArr.push(`m.month:EQ=${month}`);
        filterArr.push(`w.name:EQ=${week}`);

        let filter = filterArr.join(',')

        dynamic_search(
                "'tbl_vmi v'", 
                "'left join tbl_company c on v.company = c.id "+
                "left join tbl_year y on v.year = y.id "+
                "left join tbl_month m on v.month = m.id "+
                "left join tbl_week w on v.week = w.id'", 
                "'COUNT(v.id) as total_records'", 
                0, 
                0, 
                `'${filter}'`,  
                `''`, 
                `''`,
                (res) => {
                    if (res && res.length > 0) {
                        let total_records = res[0].total_records;

                        for (let index = 0; index < total_records; index += 100000) {
                            dynamic_search(
                                "'tbl_vmi v'", 

                                "'left join tbl_company c on v.company = c.id "+
                                "left join tbl_year y on v.year = y.id "+
                                "left join tbl_month m on v.month = m.id "+
                                "left join tbl_week w on v.week = w.id'", 

                                "'store, item, item_name, item_class, supplier, `group`, dept, class as classification, "+
                                "sub_class, on_hand, in_transit, average_sales_unit, company, vmi_status, year, month, week'", 

                                100000, 
                                index, 
                                `'${filter}'`,  
                                `''`, 
                                `''`,
                                (res) => {
                                    let store_ids = []
                                    let store_map = {}
                            
                                    res.forEach(stores => {
                                        store_ids.push(`${stores.store}`);
                                    });
                            
                                    dynamic_search(
                                        "'tbl_store'", 
                                        "''", 
                                        "'id, code, description'", 
                                        0, 
                                        0, 
                                        `'id:IN=${store_ids.join('|')}'`,  
                                        `''`, 
                                        `''`,
                                        (result) => {
                                            result.forEach(store => {
                                                if (!store_map[store.id]) {
                                                    store_map[store.id] = {}; // Initialize as an object
                                                }
                                                store_map[store.id].description = store.description;
                                                store_map[store.id].code = store.code;
                                            });
                                        }
                                    );

                                    res.forEach(det => {
                                        let newData = {
                                            "Store":store_map[`${det.store}`].code, 
                                            "Item":det.item, 
                                            "Item Name":det.item_name, 
                                            "VMI Status":det.vmi_status, 
                                            "Item Class":det.item_class, 
                                            "Supplier":det.supplier, 
                                            "Group":det.group, 
                                            "Dept":det.dept, 
                                            "Class":det.classification, 
                                            "Sub Class":det.sub_class, 
                                            "On Hand":det.on_hand, 
                                            "In Transit":det.in_transit, 
                                            "Ave Sales Unit":det.average_sales_unit, 
                                        }

                                        formattedData.push(newData)
                                    })
                                }
                            )
                        }
                    }
                }
        )

        const headerData = [
            ["Company Name: Lifestrong Marketing Inc."],
            ["VMI"],
            ["Date Printed: " + formatDate(new Date())],
            [""],
        ];
    
        exportArrayToCSV(formattedData, `VMI - ${formatDate(new Date())}`, headerData);
    }

    function delete_data(company, year, month, week) {
        modal.confirm(confirm_delete_message,function(result){
            if(result){ 
                var url = "<?= base_url('cms/global_controller');?>";
                var formattedData = [];
                let filterArr = []
                filterArr.push(`c.name:EQ=${company}`);
                filterArr.push(`y.year:EQ=${year}`);
                filterArr.push(`m.month:EQ=${month}`);
                filterArr.push(`w.name:EQ=${week}`);

                let filter = filterArr.join(',')

                dynamic_search(
                    "'tbl_vmi v'", 
    
                    "'left join tbl_company c on v.company = c.id "+
                    "left join tbl_year y on v.year = y.id "+
                    "left join tbl_month m on v.month = m.id "+
                    "left join tbl_week w on v.week = w.id'", 
    
                    "'v.id'", 
    
                    0, 
                    0, 
                    `'${filter}'`,  
                    `''`, 
                    `''`,
                    (res) => {
                        let updateRecords = [];
                        res.forEach(item => {
                            item.updated_date = formatDate(new Date());
                            item.updated_by = user_id;
                            item.status = -2;
                            updateRecords.push(item);
                            console.log(item.id)
                        })
                        console.log(updateRecords, 'updateRecords')
                        batch_update(url, updateRecords, "tbl_vmi", "id", false, (response) => {
                            if (response.message !== 'success') {
                                errorLogs.push(`Failed to update: ${JSON.stringify(response.error)}`);
                            }
                            modal.alert(success_delete_message, "success", function() {
                                location.reload();
                            });
                        });
                    }
                );
            }
        });
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
    
</script>