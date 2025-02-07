
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

                        <label for="file" class="custom-file-upload save" style="margin-left:10px; margin-top: 10px; align-items: center;">
                            <i class="fa fa-file-import" style="margin-right: 5px;"></i>Custom Upload
                        </label>
                        <input
                            type="file"
                            style="display: none;"
                            id="file"
                            accept=".xls,.xlsx,.csv"
                            aria-describedby="import_files"
                            onclick="clear_import_table()"
                        >

                        <label for="preview" class="custom-file-upload save" id="preview_xl_file" style="margin-top: 10px" onclick="read_xl_file()">
                            <i class="fa fa-sync" style="margin-right: 5px;"></i>Preview Data
                        </label>

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
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn caution" data-dismiss="modal">Close</button>
                <button type="button" class="btn save" onclick="proccess_xl_file()">Validate and Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    var query = "status >= 0";
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url('cms/global_controller');?>";

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
            console.log('Pressed key: ' + keyword);
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
        $(".import_table").empty()
    }

    function read_xl_file() {
        clear_import_table();
        var html = '';

        const file = $("#file")[0].files[0];

        if (file === undefined) {
            modal.alert('Please select a file to upload', 'error', ()=>{})
            return
        }
        const reader = new FileReader();
        reader.onload = function(e) {
            const data = e.target.result;
            // convert the data to a workbook
            const workbook = XLSX.read(data, {type: "binary"});
            // get the first sheet
            const sheet = workbook.Sheets[workbook.SheetNames[0]];
            // convert the sheet to JSON
            const jsonData = XLSX.utils.sheet_to_json(sheet);
    
            var tr_counter = 0;

            jsonData.forEach(row => {
                var rowClass = (tr_counter % 2 === 0) ? "even-row" : "odd-row";
                html += "<tr class=\""+rowClass+"\">";
                html += "<td>";
                html += tr_counter+1;
                html += "</td>";

                let record = row;

                let lowerCaseRecord = Object.keys(record).reduce((acc, key) => {
                    acc[key.toLowerCase()] = record[key];
                    return acc;
                }, {});
    
                // create a table cell for each item in the row
                var td_validator = ['code', 'description', 'status'];
                td_validator.forEach(column => {
                    if (column === 'deployment date') {
                        lowerCaseRecord[column] = excel_date_to_readable_date(lowerCaseRecord[column]);
                    } else {
                        lowerCaseRecord[column] = lowerCaseRecord[column];
                    }
                    html += "<td class=\"sample-id-"+lowerCaseRecord[column]+"\" id=\"" + column + "\">";
                    html += lowerCaseRecord[column] !== undefined ? lowerCaseRecord[column] : ""; // add value or leave empty
                    html += "</td>";
                });
                html += "</tr>";
                tr_counter += 1;
            });
    
            $(".import_table").append(html);
            html = '';
        };
        reader.readAsBinaryString(file);
    }

    function proccess_xl_file() {
        var extracted_data = $(".import_table");

        var code = '';
        var description = '';
        var status = '';

        var import_array = [];
        var needle = [];

        var invalid = false;
        var errmsg = '';

        var unique_code = [];
        var unique_description = [];

        var tr_count = 1;
        var row_mapping = {};

        extracted_data.find('tr').each(function () {
            td_count = 1;
            var temp = [];
            $(this).find('td').each(function () {
                var text_val = $(this).html().trim();
                var error_messages = {
                    code: {
                        duplicate: "⚠️ Duplicated Code at line #: <b>{line}</b>⚠️<br>",
                        length: "⚠️ Code exceeds 25 characters at line #: <b>{line}</b>⚠️<br>",
                        empty: "⚠️ Code is empty at line #: <b>{line}</b>⚠️<br>"
                    },
                    description: {
                        duplicate: "⚠️ Duplicated Description at line #: <b>{line}</b>⚠️<br>",
                        length: "⚠️ Description exceeds 50 characters at line #: <b>{line}</b>⚠️<br>",
                        empty: "⚠️ Description is empty at line #: <b>{line}</b>⚠️<br>"
                    },
                    status: "⚠️ Invalid Status at line #: <b>{line}</b>⚠️<br>"
                };

                const validateField = (type, value, maxLength, uniqueList) => {
                    if (uniqueList.includes(value)) {
                        invalid = true;
                        errmsg += error_messages[type].duplicate.replace("{line}", tr_count);
                    } else if (value.length > maxLength) {
                        invalid = true;
                        errmsg += error_messages[type].length.replace("{line}", tr_count);
                    } else if (!value) {
                        invalid = true;
                        errmsg += error_messages[type].empty.replace("{line}", tr_count);
                    } else {
                        uniqueList.push(value);
                        row_mapping[value] = tr_count;
                    }
                    return value;
                };

                switch (td_count) {
                    case 2:
                        code = validateField("code", text_val, 25, unique_code);
                        break;
                    case 3:
                        description = validateField("description", text_val, 50, unique_description);
                        break;
                    case 4:
                        if (["active", "inactive"].includes(text_val.toLowerCase())) {
                            status = text_val.toLowerCase() === "active" ? 1 : 0;
                        } else {
                            invalid = true;
                            errmsg += error_messages.status.replace("{line}", tr_count);
                        }
                        break;
                }

                td_count++;
            });
            tr_count += 1;
            temp.push(code, description, status);
            needle.push([code,description]);
            import_array.push(temp);
        })

        if (tr_count === 1) {
            modal.alert('Please select a file to upload', 'error', ()=>{})
            return;
        }

        var temp_invalid = invalid;
        var temp_errmsg = '';

        invalid = temp_invalid;
        errmsg += temp_errmsg;

        var table = 'tbl_team';
        var haystack = ['code', 'team_description'];
        var selected_fields = ['id', 'code', 'team_description'];

        if (invalid) {
            modal.content('Error', 'error', errmsg, '600px', ()=>{});
        } else {
            list_existing(table, selected_fields, haystack, needle, function (result) {
                if (result.status != "error") {
                    var batch = [];
                    import_array.forEach(row => {
                        let data = {
                            'code': row[0],
                            'team_description': row[1],
                            'status': row[2],
                            'created_by': user_id,
                            'created_date': formatDate(new Date())
                        };
    
                        batch.push(data);
                    });
    
                    modal.loading(true);
                    setTimeout(() => {
                        batch_insert(batch, () => {
                            modal.loading(false);
                            modal.alert(success_save_message, 'success', () => {
                                if (result) {
                                    location.reload();
                                }
                            })
                        })
                    }, 1000);
                } else {
                    let errmsg = "";
                    let processedFields = new Set();

                    $.each(result.existing, function (index, record) {
                        $.each(record, function (field, value) {
                            if (!processedFields.has(field + value)) { 
                                if (field === 'team_description') {
                                    columnName = "Description"
                                } else {
                                    columnName = "Code"
                                }
                                let line_number = row_mapping[value] || "Unknown";
                                errmsg += "⚠️ " + columnName + " already exists in masterfile at line #: <b>" + line_number + "</b>⚠️<br>";
                                processedFields.add(field + value); // Mark as processed
                            }
                        });
                    });
                    modal.content('Error', 'error', errmsg, '600px', () => {});
                }
            })
        }
    }

    function batch_insert(insert_batch_data, cb){
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
             event: "batch_insert",
             table: "tbl_team",
             insert_batch_data: insert_batch_data
        }

        aJax.post(url,data,function(result){
            cb(result.message)
        });
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
    
</script>