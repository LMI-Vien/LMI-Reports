
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
                <form id="form-modal">
                    <div class="mb-3">
                        <label for="code" class="form-label">Code</label>
                        <input type="text" class="form-control required" id="code" aria-describedby="code" maxlength="25">
                        <small class="form-text text-muted">* required, must be unique, max 25 characters</small>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Team Description</label>
                        <textarea class="form-control required" id="team_description" aria-describedby="team_description" maxlength="50"></textarea>
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
                            onchange="store_file(event)"
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
    $(document).ready(function() {
      get_data();
      get_pagination();
    });

    // function get_data(new_query) {
    //   var url = "<?= base_url("cms/global_controller");?>";
    //     var data = {
    //         event : "list",
    //         select : "id, code, team_description, status, updated_date",
    //         query : new_query,
    //         offset : offset,
    //         limit : limit,
    //         table : "tbl_team",
    //         order : {
    //             field : "updated_date",
    //             order : "desc" 
    //         }

    //     }

    //     aJax.post(url,data,function(result){
    //         var result = JSON.parse(result);
    //         var html = '';

    //         if(result) {
    //             if (result.length > 0) {
    //                 $.each(result, function(x,y) {
    //                     var status = ( parseInt(y.status) === 1 ) ? status = "Active" : status = "Inactive";
    //                     var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";

    //                     html += "<tr class='" + rowClass + "'>";
    //                     html += "<td class='center-content'><input class='select' type=checkbox data-id="+y.id+" onchange=checkbox_check()></td>";
    //                     html += "<td>" + y.code + "</td>";
    //                     html += "<td>" + y.team_description + "</td>";
    //                     html += "<td>" +status+ "</td>";
    //                     html += "<td class='center-content'>" + (y.updated_date ? y.updated_date : "N/A") + "</td>";
                        
    //                     html+="<td class='center-content'>";
    //                     html+="<a class='btn-sm btn save' onclick=\"edit_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Edit Details'><span class='glyphicon glyphicon-pencil'>Edit</span>";
    //                     html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Delete Details'><span class='glyphicon glyphicon-pencil'>Delete</span>";
    //                     html+="<a class='btn-sm btn view' onclick=\"view_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Show Details'><span class='glyphicon glyphicon-pencil'>View</span>";
    //                     html+="</td>";
                        
                        
    //                     html += "</tr>";   
    //                 });
    //             } else {
    //                 html = '<tr><td colspan=12 class="center-align-format">'+ no_records +'</td></tr>';
    //             }
    //         }
    //         $('.table_body').html(html);
    //     });
    // }

    function get_data(keyword = null) {
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
            console.log(obj);
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

    // $(document).on('keypress', '#search_query', function(e) {               
    //     if (e.keyCode === 13) {
    //         var keyword = $(this).val().trim();
    //         offset = 1;
    //         query = "( code like '%" + keyword + "%' OR team_description like '%" + keyword + "%' ) AND status >= 1";
    //         get_data();
    //         get_pagination();
    //     }
    // });

    $(document).on('keydown', '#search_query', function(e) {               
        if (e.key === 'Enter') { // Detect Enter key
            var keyword = $(this).val().trim();
            offset = 1;
            query = "( code like '%" + keyword + "%' ) OR team_description like '%" + keyword + "%' AND status >= 1";
            get_data();
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
        get_data();
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

    function set_field_state(selector, isReadOnly) {
        $(selector).prop({ readonly: isReadOnly, disabled: isReadOnly });
    }

    $(document).on('click', '#btn_import ', function() {
        $("#import_modal").modal('show')
        clear_import_table()
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
        // console.log(counter);
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

    function clear_import_table() {
        $(".import_table").empty()
    }

    function read_xl_file() {
        $(".import_table").empty()
        var html = '';
        const file = $("#file")[0].files[0];
        if (file === undefined) {
            load_swal(
                '',
                '500px',
                'error',
                'Error!',
                'Please select a file to upload',
                false,
                true
            )
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

                // create a table cell for each item in the row
                var td_validator = ['code', 'team description', 'status']
                td_validator.forEach(column => {
                    html += "<td id=\"" + column + "\">";
                    html += row[column] !== undefined ? row[column] : ""; // add value or leave empty
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

    let storedFile = null;
    function store_file(event) {
        storedFile = event.target.files[0]; // Store the file but do nothing yet
        console.log("File stored:", storedFile.name);
    }

    function proccess_xl_file() {
        if (!storedFile) {
            // alert("No file selected!");
            load_swal(
                'add_alert',
                '500px',
                "error",
                "Error",
                "No file was selected!",
                false,
                false
            );
            return;
        }

        let reader = new FileReader();
        reader.onload = function (e) {
            let data = new Uint8Array(e.target.result);
            let workbook = XLSX.read(data, { type: "array" });

            let sheetName = workbook.SheetNames[0];
            let worksheet = workbook.Sheets[sheetName];

            let jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });

            if (!Array.isArray(jsonData) || jsonData.length < 2) {
                console.error("Invalid data format: No data rows found.");
                alert("Invalid file format. Please upload a valid Excel file.");
                return;
            }

            console.log("Extracted Data:", jsonData);

            let headers = jsonData[0];
            let records = jsonData.slice(1);

            let columnMapping = {
                "code": "code",
                "team description": "team_description",
                "status": "status"
            };

            let statusMapping = {
                "active": 1,
                "inactive": 0
            };

            let existingRecords = [];
            let invalidRecords = [];
            let insertedRecords = 0;
            let totalRecords = records.length;
            let processedCount = 0;

            records.forEach((row, rowIndex) => {
                let dataObject = {};
                let isValid = true;

                headers.forEach((header, index) => {
                    let dbColumn = columnMapping[header];
                    if (dbColumn) {
                        let value = row[index]?.trim() ?? null;
                        dataObject[dbColumn] = value;
                        if (!value) isValid = false;
                    }
                });

                if (dataObject['status']) {
                    dataObject['status'] = statusMapping[dataObject['status'].toLowerCase()] ?? 0;
                }

                dataObject['created_date'] = formatDate(new Date());
                dataObject['created_by'] = user_id;

                if (!dataObject.code || !dataObject.team_description || dataObject.status === null) {
                    invalidRecords.push(`Row ${rowIndex + 2}`);
                    processedCount++;
                    checkCompletion();
                    return;
                }

                check_if_exists(dataObject, function (exists) {
                    console.log("Check if it exists:", exists);
                    if (exists) {
                        existingRecords.push(dataObject.code);
                        processedCount++;
                        checkCompletion();
                    } else {
                        save_to_db_import(dataObject, function (success) {
                            if (success) {
                                insertedRecords++;
                                console.log(`Record inserted successfully: ${dataObject.code}`);
                            }
                            processedCount++;
                            checkCompletion();
                        });
                    }
                });
            });

            function checkCompletion() {
                console.log(`Processed count: ${processedCount}, Total records: ${totalRecords}`);
                if (processedCount === totalRecords) {
                    if (invalidRecords.length > 0) {
                        load_swal(
                            'add_alert',
                            '500px',
                            "error",
                            "Error!",
                            `The following rows have missing values: ${invalidRecords.join(', ')}`,
                            false,
                            false
                        );
                    } else if (existingRecords.length > 0) {
                        load_swal(
                            'add_alert',
                            '500px',
                            "error",
                            "Error!",
                            `The following records already exist in the database: ${existingRecords.join(', ')}`,
                            false,
                            false
                        );
                    } else if (insertedRecords > 0) {
                        load_swal(
                            'add_alert',
                            '500px',
                            "success",
                            "Success!",
                            `${insertedRecords} records inserted successfully!`,
                            false,
                            false
                        ).then(() => {
                            location.reload();
                        });
                    }
                }
            }
        };

        reader.readAsArrayBuffer(storedFile);
    }

    function check_if_exists(dataObject, callback) {
        var data = {
            event: "list",
            select: "id, code, team_description", // Adjust as needed for your schema
            query: `code = '${dataObject.code}' OR team_description = '${dataObject.team_description}'`, // Query for existing data
            offset: 0,
            limit: 0,
            table: "tbl_team"
        };

        console.log("Sending data to check_if_exists:", data); // Debugging

        $.ajax({
            url: "<?= base_url('cms/global_controller'); ?>", // URL of the controller
            type: 'POST',
            data: data,
            success: function (result) {
                console.log("Raw server response:", result); // Debugging

                // Ensure the result is parsed as JSON
                try {
                    result = JSON.parse(result);
                } catch (e) {
                    console.error("Failed to parse response:", e);
                    callback(false); // Exit early if response parsing fails
                    return;
                }

                if (!Array.isArray(result)) {
                    console.error("Expected an array, but received:", result); // Debugging invalid format
                    callback(false); // Exit early if the response is not an array
                    return;
                }

                // Log the result for further inspection
                result.forEach(item => {
                    console.log(`Checking item: code = ${item.code}, team_description = ${item.team_description}`);
                });

                // Check if any record has the same code or team description
                let exists = result.some(item => {
                    // Trim both fields and use case-insensitive comparison
                    let itemCode = item.code;
                    let itemTeamDesc = item.team_description;
                    let dataCode = dataObject.code;
                    let dataTeamDesc = dataObject.team_description;

                    console.log(`Comparing: ${dataCode} === ${itemCode} || ${dataTeamDesc} === ${itemTeamDesc}`);

                    return itemCode === dataCode || itemTeamDesc === dataTeamDesc;
                });

                console.log("Does record exist?", exists); // Debugging
                callback(exists); // Pass the result to the callback
            },
            error: function (e) {
                console.error("Error checking for existing record:", e);
                callback(false); // If error occurs, assume the record doesn't exist
            }
        });
    }

    function save_to_db_import(dataObject) {
        var url = "<?= base_url('cms/global_controller');?>"; // URL of Controller
        var data = {
            event: "insert",
            table: "tbl_team", // Table name
            data: dataObject  // Pass the entire object dynamically
        };

        aJax.post(url, data, function (result) {
            var obj = is_json(result);
            location.reload();
        });
    }
    
    function load_swal(swclass, swwidth, swicon, swtitle, swtext, swoutclick, swesckey) {
        Swal.fire({
            customClass: swclass, // no special characters allowed
            width: swwidth,
            icon: swicon, // can be "warning", "error", "success", "info"
            // https://sweetalert.js.org/docs/#icon
            title: swtitle, // string
            html: swtext, // string
            allowOutsideClick: swoutclick, // boolean 
            // true allow closing alert by clicking outside of alert
            // false prevent closing alert by clicking outside of alert
            allowEscapeKey: swesckey, // boolean
            // true allow closing alert by pressing escape key
            // false prevent closing alert by pressing escape key
        });
    }


    // $(document).ready(function () {
    //     $(document).on('click', '#btn_add', function () {
    //         title = addNbsp('ADD TEAM')
    //         $("#save_team_modal").find('.modal-title').find('b').html(title)
    //         $('#save_team_modal').modal('show');
    //     });
    // });

    // $(document).on('click', '#saveBtn', function() {
    //     if(validate.standard("save_team_modal")){
    //         save_data();
    //     }
    // });

    // $(document).on('click', '#updateBtn', function() {
    //     if(validate.standard("update_team_modal")){
    //         var id = $(this).attr('data-id');
    //         update_data(id);
    //     }
    // });

    // $(document).on('click', '.edit', function() {
    //     id = $(this).attr('id');
    //     get_data_by_id(id);
    // });

    // $(document).on('click', '.delete_data', function() {
    //     var id = $(this).attr('id');
    //     delete_data(id); 
    //     // console.log('hello');
    // });

    // $(document).on('click', '.view', function() {
    //     id = $(this).attr('id');
    //     get_data_by_id_view(id);
    // });

    // $(document).on('click', '#btn_import ', function() {
    //     title = addNbsp('IMPORT TEAM')
    //     $("#import_modal").find('.modal-title').find('b').html(title)
    //     $("#import_modal").modal('show')
    //     clear_import_table()
    // });

    // function save_data() {
    //     var code = $('#save_team_modal #add_code').val();
    //     var description = $('#save_team_modal #add_team_description').val(); 
    //     var status_val = $('#save_team_modal #add_status').prop('checked') ? 1 : 0; 

    //     check_current_db(function(result) {
    //         var err_msg = '';
    //         var valid = true;
            
    //         var result = JSON.parse(result);

    //         $.each(result, function(index, item) {
    //             if (item.code === code) {
    //                 valid = false;
    //                 err_msg += "Code already exists in masterfile<br>";
    //             }
    //             if (item.team_description === description) {
    //                 valid = false;
    //                 err_msg += "Description already exists in masterfile<br>";
    //             }
    //         });

    //         if (!valid) {
    //             load_swal(
    //                 'add_alert',
    //                 '500px',
    //                 "error",
    //                 "Error!",
    //                 err_msg,
    //                 false,
    //                 false
    //             );
    //         } else {
    //             modal.confirm("Are you sure you want to save this record?", function(result) {
    //                 if (result) {
    //                     var dataObject = {
    //                         code: code,
    //                         team_description: description,
    //                         status: status_val,
    //                         created_date: formatDate(new Date()), 
    //                         created_by: user_id
    //                     };
    //                     save_to_db(dataObject); 
    //                 }
    //             });
    //         }
    //     });
    // }

    // function get_data_by_id(id){
    //     var query = "id = " + id;
    //     var exists = 0;

    //     var url = "<?= base_url('cms/global_controller');?>";
    //     var data = {
    //         event : "list", 
    //         select : "id, code, team_description, status, updated_date",
    //         query : query, 
    //         table : "tbl_team"
    //     }

    //     aJax.post(url,data,function(result){
    //         var obj = is_json(result);
    //         console.log(obj);
    //         if(obj){
    //             $.each(obj, function(x,y) {
    //                 console.log(y);
    //                 $('#update_team_modal #e_code').val(y.code);
    //                 $('#update_team_modal #e_team_description').val(y.team_description);
                    
    //                 if(y.status == 1){
    //                     $('#update_team_modal #e_status').prop('checked', true);
    //                 }else{
    //                     $('#update_team_modal #e_status').prop('checked', false);
    //                 }

    //             }); 
    //         }
            
    //         $('#updateBtn').attr('data-id', id);
    //         $('#update_team_modal').modal('show');
    //     });
    //     return exists;
    // }

    // function update_data(id) {
    //     var code = $('#e_code').val();
    //     var team_desc = $('#e_team_description').val();
    //     var status = $('#status').prop('checked') ? 1 : 0; // Get the status as 1 or 0

    //     // Check if the code or description already exists in the database before updating
    //     check_current_db(function(result) {
    //         var err_msg = '';
    //         var valid = true;

    //         // Parse the result (assuming it's JSON)
    //         var result = JSON.parse(result);

    //         // Iterate through result and check for code and description
    //         $.each(result, function(index, item) {
    //             if (item.code === code && item.id !== id) { // Exclude the current record being updated
    //                 valid = false;
    //                 err_msg += "Code already exists in masterfile<br>";
    //             }
    //             if (item.team_description === team_desc && item.id !== id) { // Exclude the current record being updated
    //                 valid = false;
    //                 err_msg += "Description already exists in masterfile<br>";
    //             }
    //         });

    //         // If not valid, show error message
    //         if (!valid) {
    //             load_swal(
    //                 'add_alert',
    //                 '500px',
    //                 "error",
    //                 "Error!",
    //                 err_msg,
    //                 false,
    //                 false
    //             );
    //         } else {
    //             // If valid, confirm and update the record
    //             modal.confirm("Are you sure you want to update this record?", function(result) {
    //                 if (result) {
    //                     var data = {
    //                         event: "update", // Specify event type
    //                         table: "tbl_team", // Table name
    //                         field: "id",
    //                         where: id, // Record to update
    //                         data: {
    //                             code: code,
    //                             team_description: team_desc,
    //                             status: status,
    //                             updated_date: formatDate(new Date()),
    //                             updated_by: user_id
    //                         }
    //                     };

    //                     var url = "<?= base_url('cms/global_controller'); ?>"; // URL of the controller
    //                     aJax.post(url, data, function(result) {
    //                         var obj = is_json(result);
    //                         location.reload();
    //                     });
    //                 }
    //             });
    //         }
    //     });
    // }

    // function delete_data(id){
        
    //     modal.confirm(confirm_delete_message,function(result){
    //         if(result){ 
    //             var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
    //             var data = {
    //                 event : "update", // list, insert, update, delete
    //                 table : "tbl_team", //table
    //                 field : "id",
    //                 where : id, 
    //                 data : {
    //                         updated_date : formatDate(new Date()),
    //                         updated_by : user_id,
    //                         status : -2
    //                 }  
    //             }

    //             aJax.post(url,data,function(result){
    //                 var obj = is_json(result);
    //                 // alert("pasok");
    //                 location.reload();
    //                 // modal.alert("<strong>Success!</strong> Record has been Saved",function(){ 
    //                 //    location.reload();
    //                 // })
    //             });
    //         }

    //     });
    // }


    // function get_data_by_id_view(id){
    //     var query = "id = " + id;
    //     var exists = 0;

    //     var url = "<?= base_url('cms/global_controller');?>";
    //     var data = {
    //         event : "list", 
    //         select : "id, code, team_description, status, updated_date",
    //         query : query, 
    //         table : "tbl_team"
    //     }

    //     aJax.post(url,data,function(result){
    //         var obj = is_json(result);
    //         console.log(obj);
    //         if(obj){
    //             $.each(obj, function(x,y) {
    //                 console.log(y);
    //                 $('#view_team_modal #code').val(y.code);
    //                 $('#view_team_modal #team_description').val(y.team_description);
                    
    //                 if(y.status == 1){
    //                     $('#view_team_modal #status').prop('checked', true);
    //                 }else{
    //                     $('#view_team_modal #status').prop('checked', false);
    //                 }

    //             }); 
    //         }
            
    //         $('#view_team_modal').modal('show');
    //     });
    //     return exists;
    // }

    // function check_current_db(successCallback) {
    //     var data = {
    //         event : "list",
    //         select : "id, code, team_description, status",
    //         query : query,
    //         offset : 0,
    //         limit : 0,
    //         table : "tbl_team",
    //     }
    //     jQuery.ajax({
    //         url: url,
    //         type: 'post',
    //         data: data,
    //         async: false,
    //         success: function (res) {
    //             successCallback(res);
    //         }, error(e){
    //             alert('alert', e)
    //             console.log(e)
    //         }
    //     });
    // }

    // function client_validate_data(code, team_description, e) {
    //     var invalid = false;
    //     var err_title = 'Error!'
    //     var err_msg = '';
    //     var result = true;
    //     // remove leading and trailing whitespace from user input
    //     var trim_code = code.trim();
    //     var trim_desc = team_description.trim()
    //     // check for empty fields
    //     if (trim_code === "" && trim_desc === "") {
    //         invalid = true; // Mark the input as invalid.
    //         err_msg+= "Code and Description is required<br>"; // Add error message.
    //     }
    //     else if (trim_code == "") {
    //         invalid = true;
    //         err_msg+= 'Code is required<br>';
    //     }
    //     else if (trim_desc == "") {
    //         invalid = true;
    //         err_msg+= 'Description is required<br>';
    //     }
    //     // check if the input exceeds the maximum allowed length for the database (25 characters).
    //     if (trim_code.length > 25) {
    //         invalid = true;
    //         err_msg += "Code is too long. Maximum allowed is 25 characters.<br>";
    //     }
    //     // check if the input exceeds the maximum allowed length for the database (50 characters).
    //     if (trim_desc.length > 50) {
    //         invalid = true;
    //         err_msg+="Description is too long. Maximum allowed is 50 characters.<br>";
    //     }

    //     // if input is invalid (invalid = true) display alert to user
    //     if (invalid) {
    //         load_swal(
    //             'add_alert', // custom class in case you want to modify the alert
    //             '500px',
    //             "error", // alert style
    //             "Error!", // title.
    //             err_msg, // message
    //             false, // prevent closing alert by clicking outside of alert
    //             false // prevent closing alert by pressing escape key
    //         );
            
    //         result = false; // assign false to result to prevent saving
    //     }

    //     return result;
    // }
    
</script>