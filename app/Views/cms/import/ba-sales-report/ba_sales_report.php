<style>
    .rmv-btn {
        border-radius: 20px;
        background-color: #C80000;
        color: white;
        border: 0.5px solid #990000;
        box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5);
    }

    .rmv-btn:disabled {
        border-radius: 20px;
        background-color: gray;
        color: black;
        border: 0.5px solid gray;
        box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5);
    }
    .add_line {
        margin-right: 10px;
        margin-bottom: 10px;
        padding: 10px;
        min-width: 75px;
        max-height: 30px;
        line-height: 0.5;
        background-color: #339933;
        color: white;
        border: 1px solid #267326;
        border-radius: 10px;
        box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5);
    }

    .add_line:disabled {
        background-color: gray !important;
        color: black !important;
    }

    @media (min-width: 1200px) {
        .modal-xxl {
            max-width: 95%;
        }
    }

    .ui-widget {
        z-index: 1051 !important;
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
                <b>B A - S A L E S - R E P O R T</b>
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
                                        <!-- <th class='center-content'><input class="selectall" type="checkbox"></th> -->
                                        <th class='center-content'>Imported Date</th>
                                        <th class='center-content'>Imported By</th>
                                        <th class='center-content'>Sales Date</th>
                                        <!-- 
                                        <th class='center-content'>Brand</th>
                                        <th class='center-content'>Date</th>
                                        <th class='center-content'>Amount</th>
                                        <th class='center-content'>Status</th> -->
                                        <th class='center-content'>Date Modified</th>

                                        <th class='center-content'>Action</th>
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

    <!-- MODAL -->
    <div class="modal" tabindex="-1" id="popup_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">
                        <b></b>
                    </h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-modal">
                        <div class="mb-3">
                            <label for="ba_name" class="form-label">BA Name</label>
                            <input type="text" class="form-control required" id="ba_name" aria-describedby="ba_name">
                        </div>

                        <div class="mb-3">
                            <div hidden>
                                <input type="text" class="form-control" id="id" aria-describedby="id">
                            </div>
                            <label for="area" class="form-label">Area</label>
                            <input type="text" class="form-control required" id="area" aria-describedby="area">
                        </div>

                        <div class="mb-3">
                            <label for="store_name" class="form-label">Store Name</label>
                            <input type="text" class="form-control required" id="store_name" aria-describedby="store_name">
                        </div>

                        <div class="mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <input type="text" class="form-control required" id="brand" aria-describedby="brand">
                        </div>
                        
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control required" id="date" aria-describedby="date">
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="text" class="form-control required" id="amount" aria-describedby="amount">
                        </div>
                    </form>
                </div>
                <div class="modal-footer"></div>
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
                    <div class="card">
                        <div class="mb-3" style="overflow-x: auto; height: 450px; padding: 0px;">
                            <div class="text-center"
                            style="padding: 10px; font-family: 'Courier New', Courier, monospace; font-size: large; background-color: #fdb92a; color: #333333; border: 1px solid #ffffff; border-radius: 10px;"                            
                            >
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

                        </div>

                            <table class= "table table-bordered listdata">
                                <thead>
                                    <tr>
                                        <th class='center-content'>Line #</th>
                                        <th class='center-content'>BA Name</th>
                                        <th class='center-content'>Area</th>
                                        <th class='center-content'>Store</th>
                                        <th class='center-content'>Brand</th>
                                        <th class='center-content'>Date</th>
                                        <th class='center-content'>Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="word_break import_table"></tbody>
                            </table>
                        </div>
                        <center style="margin-bottom: 5px">
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
        <div class="modal-dialog modal-lg">
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
                    <div class="card">
                        <div 
                            class="text-center"
                            style="padding: 10px;
                            font-family: 'Courier New', Courier, monospace;
                            font-size: large;
                            background-color: #fdb92a;
                            color: #333333;
                            border: 1px solid #ffffff;
                            border-radius: 10px;"                            
                        >
                            <b>Filters</b>
                        </div>
                        
                        <div class="d-flex flex-column">
                            <div class="p-2 row">
                                <div class="col">
                                    <label class="col" >BA Name</label>
                                    <input id='ba_input' class='form-control' onkeypress="suggest_ba()" placeholder='Select BA Name'>
                                </div>
                                <div class="col">
                                    <label class="col" >Area</label>
                                    <input id='area_input' class='form-control' onkeypress="suggest_area()" placeholder='Select Area'>
                                </div>
                            </div>
                            <div class="p-2 row">
                                <div class="col">
                                    <label class="col" >Store</label>
                                    <input id='store_input' class='form-control' onkeypress="suggest_store()" placeholder='Select Store'>
                                </div>
                                <div class="col">
                                    <label class="col" >Brand</label>
                                    <input id='brand_input' class='form-control' onkeypress="suggest_brand()" placeholder='Select Brand'>
                                </div>

                            </div>
                            <div class="p-2 row">
                                <div class="col">
                                    <label>Date From</label>
                                    <input type="date" class="form-control" id="date_from">
                                </div>
                                <div class="col">
                                    <label>Date To</label>
                                    <input type="date" class="form-control" id="date_to">
                                </div>
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
    var query = "basr.status >= 0";
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url('cms/global_controller');?>";
    var base_url = '<?= base_url();?>';

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
            event : "list",
            select : "basr.id, ar.description as area, s.description as store_name, b.brand_description as brand, ba.name as ba_name, basr.date, basr.amount, basr.status, basr.created_date, basr.updated_date, basr.status, u.name as imported_by",
            query : new_query,
            offset : offset,
            limit : limit,
            table : "tbl_ba_sales_report basr",
            join : [
                {
                    table: "tbl_brand b",
                    query: "b.id = basr.brand",
                    type: "left"
                },
                {
                    table: "tbl_store s",
                    query: "s.id = basr.store_id",
                    type: "left"
                },
                {
                    table: "tbl_brand_ambassador ba",
                    query: "ba.id = basr.ba_id",
                    type: "left"
                },
                {
                    table: "tbl_area ar",
                    query: "ar.id = basr.area_id",
                    type: "left"
                },
                {
                    table: "cms_users u",
                    query: "u.id = basr.created_by",
                    type: "left"
                }
            ], 
            order : {
                field : "basr.id",
                order : "asc" 
            },
            group : 'date'

        }

        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            var html = '';

            if(result) {
                if (result.length > 0) {
                    $.each(result, function(x,y) {
                         var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";

                        html += "<tr class='" + rowClass + "'>";
                        html += "<td scope=\"col\">" + (y.created_date ? ViewDateformat(y.created_date) : "N/A") + "</td>";
                        html += "<td scope=\"col\">" + trimText(y.imported_by) + "</td>";
                        html += "<td scope=\"col\">" + (y.date ? formatReadableDate(y.date, false) : "N/A") + "</td>";
                        html += "<td scope=\"col\">" + (y.updated_date ? ViewDateformat(y.updated_date) : "N/A") + "</td>";

                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                            html+="<td class='center-content' style='width: 25%; min-width: 300px'>";
                            html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.date+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Delete Item'><span class='glyphicon glyphicon-pencil'>Delete</span>";
                            
                            html+="<a class='btn-sm btn view' href='<?= base_url()?>"
                          +'cms/import-ba-sales-report/view/'+y.date+"' data-status='"+y.status+
                          "' target='_blank' id='"+y.id+
                          "' title='View Details'><span class='glyphicon glyphicon-pencil'>View</span>";

                          html+="<a class='btn-sm btn save' onclick=\"export_ba_date_group('"
                          +y.date+"')\" data-status='"
                          +y.status+"' id='"
                          +y.id+"' title='Edit Details'><span class='glyphicon glyphicon-pencil'>Export</span>";

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

    function get_pagination(query) {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "pagination",
            select : "basr.id, basr.status, date",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_ba_sales_report as basr",
            join : [
                {
                    table: "tbl_brand b",
                    query: "b.id = basr.brand",
                    type: "left"
                },
                {
                    table: "tbl_store s",
                    query: "s.id = basr.store_id",
                    type: "left"
                },
                {
                    table: "tbl_brand_ambassador ba",
                    query: "ba.id = basr.ba_id",
                    type: "left"
                },
                {
                    table: "tbl_area ar",
                    query: "ar.id = basr.area_id",
                    type: "left"
                },
                {
                    table: "cms_users u",
                    query: "u.id = basr.created_by",
                    type: "left"
                }
            ], 
            order : {
                field : "basr.id",
                order : "asc" 
            },
            group : 'basr.date'
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result); //check if result is valid JSON format, Format to JSON if not
            modal.loading(false);
            pagination.generate(obj.total_page, ".list_pagination", get_data);
        });
    }

    pagination.onchange(function(){
        offset = $(this).val();
        get_data(query);
        $('.selectall').prop('checked', false);
        $('.btn_status').hide();
    });

    $(document).on('keypress', '#search_query', function(e) {     
        let months = {
            "Jan": 01,
            "Feb": 02,
            "Mar": 03,
            "Apr": 04,
            "May": 05,
            "Jun": 06,
            "Jul": 07,
            "Aug": 08,
            "Sep": 09,
            "Oct": 10,
            "Nov": 11,
            "Dec": 12,
        };

        if (e.keyCode === 13) {
            var keyword = $(this).val().trim();
            // alert(keyword == 0);
            offset = 1;

            if(keyword == 0) {
                query = " basr.status >= 0 ";
            } else {
                query = "(u.name like '%" + keyword + "%') OR "
                        + "(basr.date like '%" + months[keyword] + "%')";
            }
            get_data(query);
            get_pagination(query);
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
        title = addNbsp('IMPORT BA SALES REPORT')
        $("#import_modal").find('.modal-title').find('b').html(title)
        $('#import_modal').modal('show');
    });

    function delete_data(date) {
        modal.confirm(confirm_delete_message,function(result){
            if(result){ 
                var url = "<?= base_url('cms/global_controller');?>";
                dynamic_search(
                    "'tbl_ba_sales_report'", 
                    "''", 
                    "'id'", 
                    0, 
                    0, 
                    `'date:EQ=${date}'`,  
                    `''`, 
                    `''`, 
                    (res) => {
                        date = [date];
                        batch_delete(url, "tbl_ba_sales_report", "date", date, 'date', function(resp) {
                            modal.alert("Selected records deleted successfully!", 'success', () => location.reload());
                        });
                    }
                );
            }

        });
    }

    function formatDate(date) {
        // Get components of the date
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-based
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');

        // Combine into the desired format
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

    function trimText(str) {
        if (str.length > 15) {
            return str.substring(0, 15) + "...";
        } else {
            return str;
        }
    }

    function ViewDateformat(dateString) {
        let date = new Date(dateString);
        return date.toLocaleString('en-US', { 
            month: 'short', 
            day: 'numeric', 
            year: 'numeric', 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit', 
            hour12: true 
        });
    }

    function ViewDateOnly(dateString) {
        let date = new Date(dateString);
        return date.toLocaleString('en-US', { 
            month: 'short', 
            day: 'numeric', 
            year: 'numeric'
        });
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

            processInChunks(jsonData, 5000, () => {
                paginateData(rowsPerPage);
            });
        };

        // Use readAsBinaryString instead of readAsText
        reader.readAsBinaryString(file);
    }

    function process_xl_file() {
        let btn = $(".btn.save");
        if (btn.prop("disabled")) return; // Prevent multiple clicks

        btn.prop("disabled", true);
        $(".import_buttons").find("a.download-error-log").remove();
        setTimeout(() => {
            btn.prop("disabled", false);
        }, 4000);

        if (dataset.length === 0) {
            return modal.alert('No data to process. Please upload a file.', 'error', () => {});
        }
        modal.loading(true);

        let jsonData = dataset.map(row => {
            return {
                "BA Code": row["BA Code"] || "",
                "Area Code": row["Area Code"] || "",
                "Store Code": row["Store Code"] || "",
                "Brand": row["Brand"] || "",
                "Date": row["Date"] || "",
                "Amount": row["Amount"] || "",
                "Created by": user_id || "", 
                "Created Date": formatDate(new Date()) || ""
            };
        });

        let worker = new Worker(base_url + "assets/cms/js/validator_ba_sales_report.js");
        worker.postMessage({ data: jsonData, base_url });

        worker.onmessage = function(e) {
            const { invalid, errorLogs, valid_data, err_counter, progress } = e.data;

            if (progress !== undefined) {
                modal.loading_progress(true, `Processing... ${progress}%`);
                return;
            }

            modal.loading_progress(false);

            if (invalid) {
                let errorMsg = err_counter > 1000
                    ? '⚠️ Too many errors detected. Please download the error log for details.'
                    : errorLogs.slice(0, 10).join("<br>") + (errorLogs.length > 10 ? "<br>...and more" : "");

                modal.content('Validation Error', 'error', errorMsg, '600px', () => { 
                    $(".btn.save").prop("disabled", false);
                });

                createErrorLogFile(errorLogs, `Error_${formatReadableDate(new Date(), true)}`);
            } else if (Array.isArray(valid_data) && valid_data.length > 0) { 
                saveValidatedData(valid_data);
            } else {
                modal.alert("No valid data found. Please check the file.", "error");
            }
        };

        worker.onerror = function(event) {
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

            let td_validator = ['ba code', 'area code', 'store code', 'brand', 'date', 'amount'];
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
        let batch_size = 5000; // Process 1000 records at a time
        let total_batches = Math.ceil(valid_data.length / batch_size);
        let batch_index = 0;
        let errorLogs = [];
        let url = "<?= base_url('cms/global_controller');?>";
        let table = 'tbl_ba_sales_report';
        const start_time = new Date();

        let selected_fields = [
            'id', 'area_id', 'ba_id', 'brand', 'date'
        ];

        const matchFields = [
            'area_id', 'ba_id', 'brand', 'date'
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
                        setTimeout(finishImport, 500);
                    }
                    return;
                }

                let batch = valid_data.slice(batch_index * batch_size, (batch_index + 1) * batch_size);
                let newRecords = [];
                let updateRecords = [];

                batch.forEach(row => {
                    let matchedId = null;
                    if (row.date) {
                        row.date = formatDateToISO(row.date);
                    }
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
                                    break; // Stop searching once a match is found
                                }
                            }
                            if (matchedId) break;
                        }
                    }

                    if (matchedId) {
                        row.id = matchedId;
                        row.updated_by = user_id;
                        row.updated_date = formatDate(new Date());
                        delete row.created_date; // Unset created_date
                        updateRecords.push(row);
                    } else {
                        row.created_by = user_id;
                        row.created_date = formatDate(new Date());
                        newRecords.push(row);
                    }
                });

                function finishImport() {
                    let areaArr = <?= json_encode($areaMap) ?>;
                    let ascArr  = <?= json_encode($ascMap) ?>;
                    let baArr   = <?= json_encode($baMap) ?>;

                    const areaLookup = Object.fromEntries(
                        areaArr.map(item => [ item.id, item.description ])
                    );
                    const ascLookup = Object.fromEntries(
                        ascArr.map(item => [ item.id, item.description ])
                    );
                    const baLookup = Object.fromEntries(
                        baArr.map(item => [ item.id, item.name ])
                    );

                    const dataWithNames = valid_data.map(row => ({
                        area_name: areaLookup[row.area_id],
                        asc_name:  ascLookup[row.asc_id],
                        ba_name:   baLookup[row.ba_id]
                    }));

                    const headers = ['area_name', 'asc_name', 'ba_name']; 
                    const url = "<?= base_url('cms/global_controller/save_import_log_file') ?>";

                    saveImportDetailsToServer(dataWithNames, headers, 'import_ba_sales_report', url, function(filePath) {
                        const end_time = new Date();
                        const duration = formatDuration(start_time, end_time);

                        let remarks = `
                            Import Completed Successfully!
                            <br>Total Records: ${dataWithNames.length}
                            <br>Start Time: ${formatReadableDate(start_time)}
                            <br>End Time: ${formatReadableDate(end_time)}
                            <br>Duration: ${duration}`;

                        let link = filePath ? `<a href="<?= base_url() ?>${filePath}" target="_blank">View Details</a>` : null;

                        logActivity('Import BA Sales Report', 'Import Data', remarks, link, null, null);
                        // location.reload();
                    });
                }

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

    function excel_date_to_readable_date(excel_date) {
        var dateStr = excel_date.split('/').map((part, index) => {
            if (index === 2 && part.length === 2) {
            }
            return part;
        }).join('/');

        var date = new Date(dateStr);
        
        if (isNaN(date)) {
            return "Invalid Date";
        }
        
        return date.toLocaleDateString("en-US", { 
            year: "numeric", 
            month: "long", 
            day: "numeric" 
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

    function suggest_area() {
        let search = $('#area_input').val()
        var temp_area = [];

        dynamic_search("'tbl_area'", "''", "'id, code, description, status'", 10, 0, `'status:IN=1|0, description:LIKE=${search}'`,  `''`, `''`, (res) => {
            res.forEach(item => {
                temp_area.push(item.description.trim());
            });
        });
        $(`#area_input`).autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(temp_area, request.term);
                var uniqueResults = [...new Set(results)];
                response(uniqueResults.slice(0, 10));
            },
        });
    }

    function suggest_store() {
        let search = $('#store_input').val()
        var temp_store = [];

        dynamic_search("'tbl_store'", "''", "'id, code, description, status'", 10, 0, `'status:IN=1|0, description:LIKE=${search}'`,  `''`, `''`, (res) => {
            res.forEach(item => {
                temp_store.push(item.description.trim());
            });
        });
        $(`#store_input`).autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(temp_store, request.term);
                var uniqueResults = [...new Set(results)];
                response(uniqueResults.slice(0, 10));
            },
        });
    }

    function suggest_brand() {
        let search = $('#brand_input').val()
        var temp_brand = [];

        dynamic_search("'tbl_brand'", "''", "'id, brand_code, brand_description, status'", 0, 0, `'status:IN=1|0, brand_description:LIKE=${search}'`,  `''`, `''`, (res) => {
            res.forEach(item => {
                temp_brand.push(item.brand_description.trim());
            });
        });
        $(`#brand_input`).autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(temp_brand, request.term);
                var uniqueResults = [...new Set(results)];
                response(uniqueResults.slice(0, 10));
            },
        });
    }

    function suggest_ba() {
        let search = $('#ba_input').val()
        var temp_ba = [];

        dynamic_search("'tbl_brand_ambassador'", "''", "'id, name, status'", 0, 0, `'status:IN=1|0, name:LIKE=${search}'`,  `''`, `''`, (res) => {
            res.forEach(item => {
                temp_ba.push(item.name.trim());
            });
        });
        $(`#ba_input`).autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(temp_ba, request.term);
                var uniqueResults = [...new Set(results)];
                response(uniqueResults.slice(0, 10));
            },
        });
    }

    $(document).on('click', '#btn_export ', function() {
        title = addNbsp('EXPORT BA Sales Report');
        $("#export_modal").find('.modal-title').find('b').html(title)
        $('#area_input, #store_input, #brand_input, #ba_input').val('');
        $('#export_modal').modal('show');
    });

    function download_template() {
        let formattedData = [
            {
                "BA Code":"",
                "Area Code":"",
                "Store Code":"",
                "Brand":"",
                "Date":"",
                "Amount":"",
                "Status":"",
                "NOTE:": "Please do not change the column headers."
            }
        ]
        const headerData = [];
    
        exportArrayToCSV(formattedData, `BA Sales Report - ${formatDate(new Date())}`, headerData);
    }

    function exportFilter() {
        // Get user input from form fields
        let area = $('#area_input').val();  // Get the selected area from the input field
        let store = $('#store_input').val();  // Get the selected store from the input field
        let brand = $('#brand_input').val();  // Get the selected brand from the input field
        let ba = $('#ba_input').val();  // Get the selected brand ambassador from the input field
        let date_from = $('#date_from').val();  // Get the selected start date
        let date_to = $('#date_to').val();  // Get the selected end date

        // Initialize ID variables to store database IDs of selected values
        let area_id = 0;
        let store_id = 0;
        let brand_id = 0;
        let ba_id = 0;

        // Arrays to store filtering conditions
        var filterArr = [];  // Stores filter conditions for search queries
        var formattedData = [];  // Stores formatted data (not used in this snippet)

        // Search for table IDs based on user input
        if (area) {
            // Search for area ID in 'tbl_area' based on area description
            dynamic_search("'tbl_area'", "''", "'id'", 1, 0, `'status:IN=1|0, description:EQ=${area}'`, `''`, `''`,
                (res) => { area_id = res[0].id; }  // Assign the found area ID
            );
        }
        if (store) {
            // Search for store ID in 'tbl_store' based on store description
            dynamic_search("'tbl_store'", "''", "'id'", 1, 0, `'status:IN=1|0, description:EQ=${store}'`, `''`, `''`,
                (res) => { store_id = res[0].id; }  // Assign the found store ID
            );
        }
        if (brand) {
            // Search for brand ID in 'tbl_brand' based on brand description
            dynamic_search("'tbl_brand'", "''", "'id'", 1, 0, `'status:IN=1|0, brand_description:EQ=${brand}'`, `''`, `''`,
                (res) => { brand_id = res[0].id; }  // Assign the found brand ID
            );
        }
        if (ba) {
            // Search for brand ambassador ID in 'tbl_brand_ambassador' based on name
            dynamic_search("'tbl_brand_ambassador'", "''", "'id'", 1, 0, `'status:IN=1|0, name:EQ=${ba}'`, `''`, `''`,
                (res) => { ba_id = res[0].id; }  // Assign the found brand ambassador ID
            );
        }

        // Construct filter conditions for querying the database
        if (area_id != 0) {
            filterArr.push(`area_id:EQ=${area_id}`);  // Add area filter if a valid area ID was found
        }
        if (store_id != 0) {
            filterArr.push(`store_id:EQ=${store_id}`);  // Add store filter if a valid store ID was found
        }
        if (brand_id != 0) {
            filterArr.push(`brand:EQ=${brand_id}`);  // Add brand filter if a valid brand ID was found
        }
        if (ba_id != 0) {
            filterArr.push(`ba_id:EQ=${ba_id}`);  // Add brand ambassador filter if a valid BA ID was found
        }

        modal.confirm(confirm_export_message,function(result){
            if (result) {
                modal.loading_progress(true, "Reviewing Data...");
                setTimeout(() => {
                    if (date_from && date_to) {
                        // Add date range filter if both start and end dates are provided
                        filterArr.push(`date:BETWEEN=${date_from}|${date_to}`);
                        if (date_from > date_to) {
                            modal.loading_progress(false);
                            modal.alert("Date FROM should not be later than Date TO!", 'info');
                        } else {
                            startExport()
                        }
                    } else {
                        startExport()
                    }
                }, 500);
            }
        })

        const startExport = () => {
            dynamic_search(
                "'tbl_ba_sales_report'", "''", "'COUNT(id) as total_records'", 0, 0, 
                `'${filterArr.join(',')}'`,`''`, `''`,
                (res) => {
                    if (res && res.length > 0) {
                        let total_records = res[0].total_records;
    
                        for (let index = 0; index < total_records; index += 100000) {
                            dynamic_search(
                                "'tbl_ba_sales_report'", "''", "'id, area_id, store_id, brand, ba_id, date, amount, status'", 100000, index, 
                                `'${filterArr.join(',')}'`,`'date asc, id asc'`, `''`,
                                (res) => {
                                    var areaArr = [];
                                    var storeArr = [];
                                    var brandArr = [];
                                    var baArr = [];
                                    res.forEach(item => {
                                        if (!areaArr.includes(`${item.area_id}`)) {
                                            areaArr.push(`${item.area_id}`);
                                        }

                                        if (!storeArr.includes(`${item.store_id}`)) {
                                            storeArr.push(`${item.store_id}`);
                                        }

                                        if (!brandArr.includes(`${item.brand}`)) {
                                            brandArr.push(`${item.brand}`);
                                        }

                                        if (!baArr.includes(`${item.ba_id}`)) {
                                            baArr.push(`${item.ba_id}`);
                                        }
                                    });

                                    temp_area = {};
                                    dynamic_search("'tbl_area'", "''", "'id, code, description, status'", 100000, 0, `"status:IN=1|0,id:IN=${areaArr.join('|')}"`,  `''`, `''`, (res) => {
                                        res.forEach(item => {
                                            temp_area[item.id] = item.description.trim();
                                        });
                                    });

                                    temp_store = {};
                                    dynamic_search("'tbl_store'", "''", "'id, code, description, status'", 100000, 0, `"status:IN=1|0,id:IN=${storeArr.join('|')}"`,  `''`, `''`, (res) => {
                                        res.forEach(item => {
                                            temp_store[item.id] = item.description.trim();
                                        });
                                    });

                                    temp_brand = {};
                                    dynamic_search("'tbl_brand'", "''", "'id, brand_code, brand_description, status'", 100000, 0, `"status:IN=1|0,id:IN=${brandArr.join('|')}"`,  `''`, `''`, (res) => {
                                        res.forEach(item => {
                                            temp_brand[item.id] = item.brand_description.trim();
                                        });
                                    });

                                    temp_baArr = {};
                                    dynamic_search("'tbl_brand_ambassador'", "''", "'id, code, name, status'", 100000, 0, `"status:IN=1|0,id:IN=${baArr.join('|')}"`,  `''`, `''`, (res) => {
                                        res.forEach(item => {
                                            temp_baArr[item.id] = item.name.trim();
                                        });
                                    });

                                    let previousDate = null;
                                    let totalAmount = 0;

                                    let spacing = {
                                        "BA Code": "",
                                        "Area Code": "",
                                        "Store Code": "",
                                        "Brand": "",
                                        "Date": "",
                                        "Amount": "",
                                        "Status": "",
                                    };

                                    res.forEach(({ area_id, store_id, brand, ba_id, date, amount, status }, index) => {
                                        // Convert amount to number safely
                                        const numericAmount = parseFloat(amount) || 0;

                                        // If date changes and not the first row, push total and spacing
                                        if (previousDate !== null && previousDate !== date) {
                                            // Push total row
                                            formattedData.push({
                                                "BA Code": "",
                                                "Area Code": "",
                                                "Store Code": "",
                                                "Brand": "",
                                                "Date": previousDate,
                                                "Amount": totalAmount,
                                                "Status": "Total",
                                            });

                                            // Push spacing row
                                            formattedData.push({ ...spacing });

                                            // Reset total
                                            totalAmount = 0;
                                        }

                                        // Push the current row
                                        formattedData.push({
                                            "BA Code": temp_baArr[ba_id],
                                            "Area Code": temp_area[area_id],
                                            "Store Code": temp_store[store_id],
                                            "Brand": temp_brand[brand],
                                            "Date": date,
                                            "Amount": amount,
                                            "Status": parseInt(status) === 1 ? "Active" : "Inactive",
                                        });

                                        totalAmount += numericAmount;
                                        previousDate = date;

                                        // Final iteration: push total and spacing
                                        if (index === res.length - 1) {
                                            formattedData.push({
                                                "BA Code": "",
                                                "Area Code": "",
                                                "Store Code": "",
                                                "Brand": "",
                                                "Date": date,
                                                "Amount": totalAmount,
                                                "Status": "Total",
                                            });

                                            formattedData.push({ ...spacing });
                                        }
                                    });
                                }
                            );
                        }
                    }
                }
            )
            
            if (!formattedData || formattedData.length === 0) {
                formattedData = [
                    {
                        "BA Code":"",
                        "Area Code":"",
                        "Store Code":"",
                        "Brand":"",
                        "Date":"",
                        "Amount":"",
                        "Status":"",
                    },
                ]
            }
    
            const headerData = [
                ["Company Name: Lifestrong Marketing Inc."],
                ["BA Sales Report"],
                ["Date Printed: " + formatDate(new Date())],
                [""],
            ];
    
            exportArrayToCSV(formattedData, `BA Sales Report - ${formatDate(new Date())}`, headerData);
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
                    `'tbl_ba_sales_report'`,
                    `''`,
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
                                    `'tbl_ba_sales_report'`,
                                    `''`,
                                    `'area_id, store_id, brand, ba_id, date, amount, status'`,
                                    100000,
                                    index,
                                    `''`, 
                                    `'date asc, id asc'`, 
                                    `''`,
                                    (res) => {
                                        var areaArr = [];
                                        var storeArr = [];
                                        var brandArr = [];
                                        var baArr = [];
                                        res.forEach(item => {
                                            if (!areaArr.includes(`${item.area_id}`)) {
                                                areaArr.push(`${item.area_id}`);
                                            }

                                            if (!storeArr.includes(`${item.store_id}`)) {
                                                storeArr.push(`${item.store_id}`);
                                            }

                                            if (!brandArr.includes(`${item.brand}`)) {
                                                brandArr.push(`${item.brand}`);
                                            }

                                            if (!baArr.includes(`${item.ba_id}`)) {
                                                baArr.push(`${item.ba_id}`);
                                            }
                                        });

                                        temp_area = {};
                                        dynamic_search("'tbl_area'", "''", "'id, code, description, status'", 100000, 0, `"status:IN=1|0,id:IN=${areaArr.join('|')}"`,  `''`, `''`, (res) => {
                                            res.forEach(item => {
                                                temp_area[item.id] = item.description.trim();
                                            });
                                        });

                                        temp_store = {};
                                        dynamic_search("'tbl_store'", "''", "'id, code, description, status'", 100000, 0, `"status:IN=1|0,id:IN=${storeArr.join('|')}"`,  `''`, `''`, (res) => {
                                            res.forEach(item => {
                                                temp_store[item.id] = item.description.trim();
                                            });
                                        });

                                        temp_brand = {};
                                        dynamic_search("'tbl_brand'", "''", "'id, brand_code, brand_description, status'", 100000, 0, `"status:IN=1|0,id:IN=${brandArr.join('|')}"`,  `''`, `''`,
                                            (res) => {
                                                res.forEach(item => {
                                                    temp_brand[item.id] = item.brand_description.trim();
                                                });
                                            }
                                        );

                                        temp_baArr = {};
                                        dynamic_search("'tbl_brand_ambassador'", "''", "'id, code, name, status'", 100000, 0, `"status:IN=1|0,id:IN=${baArr.join('|')}"`,  `''`, `''`, (res) => {
                                            res.forEach(item => {
                                                temp_baArr[item.id] = item.name.trim();
                                            });
                                        });

                                        let previousDate = null;
                                        let totalAmount = 0;

                                        let spacing = {
                                            "BA Code": "",
                                            "Area Code": "",
                                            "Store Code": "",
                                            "Brand": "",
                                            "Date": "",
                                            "Amount": "",
                                            "Status": "",
                                        };

                                        res.forEach(({ area_id, store_id, brand, ba_id, date, amount, status }, index) => {
                                            // Convert amount to number safely
                                            const numericAmount = parseFloat(amount) || 0;

                                            // If date changes and not the first row, push total and spacing
                                            if (previousDate !== null && previousDate !== date) {
                                                // Push total row
                                                formattedData.push({
                                                    "BA Code": "",
                                                    "Area Code": "",
                                                    "Store Code": "",
                                                    "Brand": "",
                                                    "Date": previousDate,
                                                    "Amount": totalAmount,
                                                    "Status": "Total",
                                                });

                                                // Push spacing row
                                                formattedData.push({ ...spacing });

                                                // Reset total
                                                totalAmount = 0;
                                            }

                                            // Push the current row
                                            formattedData.push({
                                                "BA Code": temp_baArr[ba_id],
                                                "Area Code": temp_area[area_id],
                                                "Store Code": temp_store[store_id],
                                                "Brand": temp_brand[brand],
                                                "Date": date,
                                                "Amount": amount,
                                                "Status": parseInt(status) === 1 ? "Active" : "Inactive",
                                            });

                                            totalAmount += numericAmount;
                                            previousDate = date;

                                            // Final iteration: push total and spacing
                                            if (index === res.length - 1) {
                                                formattedData.push({
                                                    "BA Code": "",
                                                    "Area Code": "",
                                                    "Store Code": "",
                                                    "Brand": "",
                                                    "Date": date,
                                                    "Amount": totalAmount,
                                                    "Status": "Total",
                                                });

                                                formattedData.push({ ...spacing });
                                            }
                                        });
                                    }
                                )
                            }
                        } else {
                            //console.log('No data received');
                        }
                    }
                )
            };

            batch_export()

            const headerData = [
                ["Company Name: Lifestrong Marketing Inc."],
                ["BA Sales Report"],
                ["Date Printed: " + formatDate(new Date())],
                [""],
            ];

            exportArrayToCSV(formattedData, `BA Sales Report - ${formatDate(new Date())}`, headerData);
            modal.loading_progress(false);
        }

    }

    function export_ba_date_group(date) {
        var formattedData = [];
        dynamic_search(
            "'tbl_ba_sales_report basr'", 

            "'left join tbl_brand b on b.id = basr.brand"+
            " left join tbl_store s on s.id = basr.store_id"+
            " left join tbl_brand_ambassador ba on ba.id = basr.ba_id"+
            " left join tbl_area ar on ar.id = basr.area_id'", 

            "'basr.id, ar.description as area, s.description as store_name, b.brand_description as brand, ba.name as ba_name,"+
            "basr.date, basr.amount, basr.status, basr.created_date, basr.updated_date, basr.status'", 

            0, 
            0, 

            `"basr.date:EQ=${date}"`,  
            `'basr.id asc'`, 
            `''`, 
            (res) => {
                let newData = res.map(({ 
                    area, store_name, brand, ba_name, date, amount, status,
                }) => ({
                    "BA Code":ba_name,
                    "Area Code":area,
                    "Store Code":store_name,
                    "Brand":brand,
                    "Date":date,
                    "Amount":amount,
                    "Status": parseInt(status) === 1 ? "Active" : "Inactive",
                }));

                const totalAmountPerDate = res.reduce((acc, row) => {
                    const date = row.date;
                    const amount = parseFloat(row.amount) || 0;
                    if (!acc[date]) {
                        acc[date] = 0;
                    }
                    acc[date] += amount;
                    return acc;
                }, {});
    
                Object.entries(totalAmountPerDate).forEach(([date, amount]) => {
                    newData.push({
                        "BA Code": "",
                        "Area Code": "",
                        "Store Code": "",
                        "Brand": "",
                        "Date": date,
                        "Amount": amount,
                        "Status": "Total"
                    });
                });

                formattedData.push(...newData); 
            }
        );

        const headerData = [
            ["Company Name: Lifestrong Marketing Inc."],
            ["BA Sales Report"],
            ["Date Printed: " + formatDate(new Date())],
            [""],
        ];
    
        exportArrayToCSV(formattedData, `BA Sales Report - ${formatDate(new Date())}`, headerData);
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