
<div class="content-wrapper p-4">
    <div class="card">
        <div class="text-center page-title md-center">
            <b>T E A M</b>
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
                            <table class= "table table-bordered listdata">
                            <thead>
                                <tr>
                                    <th class='center-content'><input class ="selectall" type ="checkbox"></th>
                                        <th class='center-content'>Code</th>
                                        <th class='center-content'>Team Description</th>
                                        <th class='center-content'>Status</th>
                                        <th class='center-content'>Date Created</th>
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
                                <?= $optionSet;?>
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
    <div class="modal-dialog modal-lg">
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
                <form id="form-modal form-save-modal">
                    <div class="mb-3">
                        <label for="code" class="form-label">Code</label>
                        <input type="text" class="form-control required" id="code" aria-describedby="code" maxlength="25">
                        <small class="form-text text-muted">* required, must be unique, max 25 characters</small>
                    </div>
                    <div class="mb-3">
                        <label for="team_description" class="form-label">Team Description</label>
                        <textarea type="text" class="form-control required" id="team_description" aria-describedby="team_description" maxlength="50">
                        </textarea>
                        <small class="form-text text-muted">* required, must be unique, max 50 characters</small>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="status" checked>
                        <label class="form-check-label" for="status">Active</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<!-- IMPORT MODAL -->
<div class="modal" tabindex="-1" id="import_modal">
    <div class="modal-dialog modal-xl">
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

                        <div class="row">
                            <div class="import_buttons col-6">
                                <label for="file" class="custom-file-upload save" style="margin-left:10px; margin-top: 10px; margin-bottom: 10px">
                                    <i class="fa fa-file-import" style="margin-right: 5px;"></i>Custom Upload
                                </label>
                                <input
                                    type="file"
                                    style="padding-left: 10px;"
                                    id="file"
                                    accept=".xls,.xlsx,.csv"
                                    aria-describedby="import_files"
                                    onclick="clear_import_table()"
                                >
            
                                <label class="custom-file-upload save" id="preview_xl_file" style="margin-top: 10px; margin-bottom: 10px" onclick="read_xl_file()">
                                    <i class="fa fa-sync" style="margin-right: 5px;"></i>Preview Data
                                </label>
                            </div>
    
                            <div class="col"></div>
    
                            <div class="col-3">
                                <label class="custom-file-upload save" id="download_template" style="margin-top: 10px; margin-bottom: 10px" onclick="download_template()">
                                    <i class="fa fa-file-download" style="margin-right: 5px;"></i>Download Import Template
                                </label>
                            </div>
                        </div>

                        <table class= "table table-bordered listdata">
                            <thead>
                                <tr>
                                    <th class='center-content'>Line #</th>
                                    <th class='center-content'>Code</th>
                                    <th class='center-content'>Team Description</th>
                                    <th class='center-content'>Status</th>
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

<script>
    var query = "status >= 0";
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
      get_pagination();
    });

    function get_data(query) {
      var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "list",
            select : "id, code, team_description, status, updated_date, created_date",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_team",
            order : {
                field : "updated_date",
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
                        html += "<td class='center-content' style='width: 5%'><input class='select' type=checkbox data-id="+y.id+" onchange=checkbox_check()></td>";
                        html += "<td style='width: 10%'>" + y.code + "</td>";
                        html += "<td style='width: 20%'>" + trimText(y.team_description) + "</td>";
                        html += "<td style='width: 10%'>" +status+ "</td>";
                        html += "<td class='center-content' style='width: 10%'>" + (y.created_date ? ViewDateformat(y.created_date) : "N/A") + "</td>";
                        html += "<td class='center-content' style='width: 10%'>" + (y.updated_date ? ViewDateformat(y.updated_date) : "N/A") + "</td>";

                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                          html+="<td class='center-content' style='width: 25%'>";
                          html+="<a class='btn-sm btn save' onclick=\"edit_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Edit Details'><span class='glyphicon glyphicon-pencil'>Edit</span>";
                          html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Delete Details'><span class='glyphicon glyphicon-pencil'>Delete</span>";
                          html+="<a class='btn-sm btn view' onclick=\"view_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Show Details'><span class='glyphicon glyphicon-pencil'>View</span>";
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

    function get_pagination() {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
          event : "pagination",
            select : "id",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_team",
            order : {
                field : "updated_date", //field to order
                order : "desc" //asc or desc
            }

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
        $("#search_query").val("");
    });

    $(document).on('keypress', '#search_query', function(e) {               
        if (e.keyCode === 13) {
            var keyword = $(this).val().trim();
            offset = 1;
            // query = "( code like '%" + keyword + "%' ) OR team_description like '%" + keyword + "%' AND status >= 1";
            var new_query = "("+query+" AND code like '%" + keyword + "%') OR "+
            "("+query+" AND team_description like '%" + keyword + "%')"
            get_data(new_query);
            get_pagination();
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

    $(document).on('click', '#btn_add', function() {
        open_modal('Add New Team', 'add', '');
    });

    function edit_data(id) {
        open_modal('Edit Team', 'edit', id);
    }

    function view_data(id) {
        open_modal('View Team', 'view', id);
    }

    function open_modal(msg, actions, id) {
        $(".form-control").css('border-color','#ccc');
        $(".validate_error_message").remove();
        let $modal = $('#popup_modal');
        let $footer = $modal.find('.modal-footer');

        $modal.find('.modal-title b').html(addNbsp(msg));
        reset_modal_fields();

        let buttons = {
            save: create_button('Save', 'save_data', 'btn save', function () {
                if (validate.standard("form-modal")) {
                    save_data('save', null);
                }
            }),
            edit: create_button('Update', 'edit_data', 'btn update', function () {
                if (validate.standard("form-modal")) {
                    save_data('update', id);
                }
            }),
            close: create_button('Close', 'close_data', 'btn caution', function () {
                $modal.modal('hide');
            })
        };

        if (['edit', 'view'].includes(actions)) populate_modal(id);
        
        let isReadOnly = actions === 'view';
        set_field_state('#code, #team_description, #status', isReadOnly);

        $footer.empty();
        if (actions === 'add') $footer.append(buttons.save);
        if (actions === 'edit') $footer.append(buttons.edit);
        $footer.append(buttons.close);

        $modal.modal('show');
    }

    function reset_modal_fields() {
        $('#popup_modal #code, #popup_modal #team_description, #popup_modal').val('');
        $('#popup_modal #status').prop('checked', true);
    }

    function clear_import_table() {
        $(".import_table").empty();
    }

    function paginateData(rowsPerPage) {
        totalPages = Math.ceil(dataset.length / rowsPerPage);
        currentPage = 1;
        display_imported_data();
    }

    function set_field_state(selector, isReadOnly) {
        $(selector).prop({ readonly: isReadOnly, disabled: isReadOnly });
    }

    $(document).on('click', '#btn_import ', function() {
        title = addNbsp('IMPORT TEAMS')
        $("#import_modal").find('.modal-title').find('b').html(title)
        $('#import_modal').modal('show');
    });

    function populate_modal(inp_id) {
        var query = "status >= 0 and id = " + inp_id;
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, code, team_description, status",
            query : query, 
            table : "tbl_team"
        }
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(index,d) {
                    $('#id').val(d.id);
                    $('#code').val(d.code);
                    $('#team_description').val(d.team_description);
                    if(d.status == 1) {
                        $('#status').prop('checked', true)
                    } else {
                        $('#status').prop('checked', false)
                    }
                }); 
            }
        });
    }

    function create_button(btn_txt, btn_id, btn_class, onclick_event) {
        var new_btn = $('<button>', {
            text: btn_txt,
            id: btn_id,
            class: btn_class,
            click: onclick_event // Attach the onclick event
        });
        return new_btn;
    }

    function save_to_db(inp_code, inp_description, status_val, id) {
        const url = "<?= base_url('cms/global_controller'); ?>";
        let data = {}; 
        let modal_alert_success;

        if (id !== undefined && id !== null && id !== '') {
            modal_alert_success = success_update_message;
            data = {
                event: "update",
                table: "tbl_team",
                field: "id",
                where: id,
                data: {
                    code: inp_code,
                    team_description: inp_description,
                    updated_date: formatDate(new Date()),
                    updated_by: user_id,
                    status: status_val
                }
            };
        } else {
            modal_alert_success = success_save_message;
            data = {
                event: "insert",
                table: "tbl_team",
                data: {
                    code: inp_code,
                    team_description: inp_description,
                    created_date: formatDate(new Date()),
                    created_by: user_id,
                    status: status_val
                }
            };
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result);
            modal.loading(false);
            modal.alert(modal_alert_success, 'success', function() {
                location.reload();
            });
        });
    }

    function save_data(action, id) {
        var code = $('#code').val();
        var description = $('#team_description').val();
        var chk_status = $('#status').prop('checked');
        if (chk_status) {
            status_val = 1;
        } else {
            status_val = 0;
        }
        if(validate.standard("form-save-modal")){
            if (id !== undefined && id !== null && id !== '') {
                check_current_db("tbl_team", ["code", "team_description"], [code, description], "status" , "id", id, true, function(exists, duplicateFields) {
                    if (!exists) {
                        modal.confirm(confirm_update_message, function(result){
                            if(result){ 
                                    modal.loading(true);
                                save_to_db(code, description, status_val, id)
                            }
                        });
    
                    }             
                });
            }else{
                check_current_db("tbl_team", ["code"], [code], "status" , null, null, true, function(exists, duplicateFields) {
                    if (!exists) {
                        modal.confirm(confirm_add_message, function(result){
                            if(result){ 
                                    modal.loading(true);
                                save_to_db(code, description, status_val, null)
                            }
                        });
    
                    }                  
                });
            }
        }
    }

    function delete_data(id) {
        modal.confirm(confirm_delete_message,function(result){
            if(result){ 
                var url = "<?= base_url('cms/global_controller');?>";
                var data = {
                    event : "update",
                    table : "tbl_team",
                    field : "id",
                    where : id, 
                    data : {
                            updated_date : formatDate(new Date()),
                            updated_by : user_id,
                            status : -2
                    }  
                }
                aJax.post(url,data,function(result){
                    var obj = is_json(result);
                    modal.alert(success_delete_message, 'success', function() {
                        location.reload();
                    });
                });
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
        if (str.length > 10) {
            return str.substring(0, 10) + "...";
        } else {
            return str;
        }
    }

    $(document).on('click', '.btn_status', function (e) {
        var status = $(this).attr("data-status");
        var modal_obj = "";
        var modal_alert_success = "";
        var hasExecuted = false; // Prevents multiple executions

        if (parseInt(status) === -2) {
            modal_obj = confirm_delete_message;
            modal_alert_success = success_delete_message;
        } else if (parseInt(status) === 1) {
            modal_obj = confirm_publish_message;
            modal_alert_success = success_publish_message;
        } else {
            modal_obj = confirm_unpublish_message;
            modal_alert_success = success_unpublish_message;
        }
        // var counter = 0; 
        // $('.select:checked').each(function () {
        //     var id = $(this).attr('data-id');
        //     if(id){
        //         counter++;
        //     }
        //  });
        modal.confirm(modal_obj, function (result) {
            if (result) {
                var url = "<?= base_url('cms/global_controller');?>";
                var dataList = [];
                
                $('.select:checked').each(function () {
                    var id = $(this).attr('data-id');
                    dataList.push({
                        event: "update",
                        table: "tbl_team",
                        field: "id",
                        where: id,
                        data: {
                            status: status,
                            updated_date: formatDate(new Date())
                        }
                    });
                });

                if (dataList.length === 0) return;

                var processed = 0;
                dataList.forEach(function (data, index) {
                    aJax.post(url, data, function (result) {
                        if (hasExecuted) return; // Prevents multiple executions

                        modal.loading(false);
                        processed++;

                        if (result === "success") {
                            if (!hasExecuted) {
                                hasExecuted = true;
                                $('.btn_status').hide();
                                modal.alert(modal_alert_success, 'success', function () {
                                    location.reload();
                                });
                            }
                        } else {
                            if (!hasExecuted) {
                                hasExecuted = true;
                                modal.alert(failed_transaction_message, function () {});
                            }
                        }
                    });
                });
            }
        });
    });

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

    function read_xl_file() {
        let btn = $(".btn.save");
        btn.prop("disabled", false); 
        clear_import_table();
        
        dataset = [];

        const file = $("#file")[0].files[0];
        if (!file) {
            modal.loading_progress(false);
            modal.alert('Please select a file to upload', 'error', ()=>{});
            return;
        }

        // File Size Validation (Limit: 30MB) temp
        const maxFileSize = 30 * 1024 * 1024; // 30MB in bytes
        if (file.size > maxFileSize) {
            modal.loading_progress(false);
            modal.alert('The file size exceeds the 50MB limit. Please upload a smaller file.', 'error', () => {});
            return;
        }

        modal.loading_progress(true, "Reviewing Data...");

        const reader = new FileReader();
        reader.onload = function(e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, { type: "array" });
            const sheet = workbook.Sheets[workbook.SheetNames[0]];

            const jsonData = XLSX.utils.sheet_to_json(sheet, { raw: false });
            processInChunks(jsonData, 5000, () => {
                paginateData(rowsPerPage);
            });
        };
        reader.readAsArrayBuffer(file);
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

    function process_xl_file() {
        let btn = $(".btn.save");
        if (btn.prop("disabled")) return; // Prevent multiple clicks

        btn.prop("disabled", true);
        $(".import_buttons").find("a.download-error-log").remove();

        if (dataset.length === 0) {
            modal.alert('No data to process. Please upload a file.', 'error', () => {});
            return;
        }

        modal.loading(true);

        let jsonData = dataset.map(row => {
            return {
                "Code": row["Code"] || "",
                "Team_Description": row["Team_Description"] || "",
                "Status": row["Status"] || "",
                "Created by": user_id || "", 
                "Created Date": formatDate(new Date()) || ""
            };
        });

        let worker = new Worker(base_url + "assets/cms/js/validator_team.js");
        worker.postMessage({ data: jsonData, base_url: base_url });

        worker.onmessage = function(e) {
            modal.loading_progress(false);

            let { invalid, errorLogs, valid_data, err_counter } = e.data;
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
                setTimeout(() => saveValidatedData(valid_data), 500);
            } else {
                btn.prop("disabled", false);
                modal.alert("No valid data returned. Please check the file and try again.", "error", () => {});
            }
        };

        worker.onerror = function() {
            modal.alert("Error processing data. Please try again.", "error", () => {});
        };
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

            let td_validator = ['code', 'team_description', 'status'];
            td_validator.forEach(column => {
                html += `<td>${lowerCaseRecord[column] !== undefined ? lowerCaseRecord[column] : ""}</td>`;
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
        let retry_count = 0;
        let max_retries = 5; 
        let errorLogs = [];
        let url = "<?= base_url('cms/global_controller');?>";
        let table = 'tbl_team';
        let selected_fields = ['id', 'code', 'team_description'];

        //for lookup of duplicate recors
        const matchFields = ["code", "team_description"];  
        const matchType = "OR";  //use OR/AND depending on the condition
        modal.loading_progress(true, "Validating and Saving data...");

        // Fetch existing records to determine insert vs. update
        aJax.post(url, { table: table, event: "fetch_existing", selected_fields: selected_fields }, function(response) {
            let result = JSON.parse(response);
            let existingMap = new Map(); // Stores records using composite keys

            if (result.existing) {
                result.existing.forEach(record => {
                    let key = matchFields.map(field => record[field] || "").join("|"); 
                    existingMap.set(key, record.id);
                });
            }

            function updateOverallProgress(stepName, completed, total) {
                let progress = Math.round((completed / total) * 100);
                updateSwalProgress(stepName, progress);
            }

            function processNextBatch() {
                if (batch_index >= total_batches) {
                    modal.loading_progress(false);
                    if (errorLogs.length > 0) {
                        createErrorLogFile(errorLogs, "Update_Error_Log_" + formatReadableDate(new Date(), true));
                        modal.alert("Some records encountered errors. Check the log.", 'info', () => {});
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
                        let key = matchFields.map(field => row[field] || "").join("|");
                        if (existingMap.has(key)) {
                            matchedId = existingMap.get(key);
                        }
                    } else {
                        for (let [key, id] of existingMap.entries()) {
                            let keyParts = key.split("|");

                            for (let field of matchFields) {
                                if (keyParts.includes(row[field])) {
                                    matchedId = id;
                                }
                            }

                            if (matchedId) break;
                        }
                    }

                    if (matchedId) {
                        row.id = matchedId;
                        row.updated_date = formatDate(new Date());
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
                            batch_update(url, updateRecords, "tbl_team", "id", false, (response) => {
                                if (response.message !== 'success') {
                                    errorLogs.push(`Failed to update: ${JSON.stringify(response.error)}`);
                                }
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
                            batch_insert(url, newRecords, "tbl_team", false, (response) => {
                                if (response.message === 'success') {
                                    updateOverallProgress("Saving Team...", batch_index + 1, total_batches);
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

                function handleSaveError() {
                    if (retry_count < max_retries) {
                        retry_count++;
                        let wait_time = Math.pow(2, retry_count) * 1000;
                        setTimeout(() => {
                            processInserts().then(() => {
                                batch_index++;
                                retry_count = 0;
                                processNextBatch();
                            }).catch(handleSaveError);
                        }, wait_time);
                    } else {
                        modal.alert('Failed to save data after multiple attempts. Please check your connection and try again.', 'error', () => {});
                    }
                }

                // Execute updates first, then inserts, then proceed to next batch
                processUpdates()
                    .then(processInserts)
                    .then(() => {
                        batch_index++;
                        setTimeout(processNextBatch, 300);
                    })
                    .catch(handleSaveError);
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

    function createErrorLogFile(errorLogs, filename) {
        let errorText = errorLogs.join("\n");
        let blob = new Blob([errorText], { type: "text/plain" });
        let url = URL.createObjectURL(blob);

        $(".import_buttons").find("a.download-error-log").remove();

        let $downloadBtn = $("<a>", {
            href: url,
            download: filename+".txt",
            text: "Download Error Logs",
            class: "download-error-log", 
            css: {
                border: "1px solid white",
                borderRadius: "10px",
                display: "inline-block",
                padding: "10px",
                lineHeight: 0.5,
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
    
    function download_template() {
        const headerData = [];

        formattedData = [
            {
                "Code": "",
                "Description": "",
                "Status": "",
                "NOTE:": "Please do not change the column headers."
            }
        ]

        exportArrayToCSV(formattedData, `Masterfile: Team - ${formatDate(new Date())}`, headerData);
    }

    $(document).on('click', '#btn_export', function () {
        modal.confirm(confirm_export_message,function(result){
            if (result) {
                modal.loading_progress(true, "Reviewing Data...");
                setTimeout(() => {
                    handleExport()
                }, 500);
            }
        })
    })

    function handleExport() {
        var formattedData = [];
        var ids = [];

        $('.select:checked').each(function () {
            var id = $(this).attr('data-id');
            ids.push(`${id}`); // Collect IDs in an array
        });

        const fetchStores = (callback) => {
            const processResponse = (res) => {
                formattedData = res.map(({ 
                    code, team_description, status
                }) => ({
                    Code: code,
                    Description: team_description,
                    Status: status === "1" ? "Active" : "Inactive",
                }));
            };

            ids.length > 0 
                // ? get_team_where_in(`"${ids.join(', ')}"`, processResponse)
                ? dynamic_search(
                    "'tbl_team'", "''", "'code, team_description, status'", 0, 0, `'id:IN=${ids.join('|')}'`, `''`, `''`, 
                    processResponse
                )
                : batch_export();
        };

        const batch_export = () => {
            dynamic_search(
                "'tbl_team'", "''", "'COUNT(id) as total_records'", 0, 0, `''`, `''`, `''`, 
                (res) => {
                    if (res && res.length > 0) {
                        let total_records = res[0].total_records;
                        console.log(total_records, 'total records');

                        for (let index = 0; index < total_records; index += 100000) {
                            dynamic_search(
                                "'tbl_team'", "''", "'code, team_description, status'", 100000, index, `''`, `''`, `''`, 
                                (res) => {
                                    let newData = res.map(({ 
                                        code, team_description, status
                                    }) => ({
                                        Code: code,
                                        Description: team_description,
                                        Status: status === "1" ? "Active" : "Inactive",
                                    }));
                                    formattedData.push(...newData); // Append new data to formattedData array
                                }
                            )
                        }
                    } else {
                        console.log('No data received');
                    }
                }
            )
        };

        fetchStores();

        const headerData = [
            ["Company Name: Lifestrong Marketing Inc."],
            ["Masterfile: Team"],
            ["Date Printed: " + formatDate(new Date())],
            [""],
        ];

        exportArrayToCSV(formattedData, `Masterfile: Team - ${formatDate(new Date())}`, headerData);
        modal.loading_progress(false);
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