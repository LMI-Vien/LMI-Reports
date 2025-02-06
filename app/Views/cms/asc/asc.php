<div class="content-wrapper p-4">
    <div class="card">
        <div class="text-center page-title md-center">
            <b>A R E A&nbsp;&nbsp;&nbsp;S A L E S&nbsp;&nbsp;&nbsp;C O O R D I N A T O R</b>
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
                                    <th class='center-content'>ASC Name</th>
                                    <th class='center-content'>Status</th>
                                    <th class='center-content'>Created Date</th>
                                    <th class='center-content'>Modified Date</th>
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

<div class="modal" tabindex="-1" id="popup_modal" data-backdrop="static">
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
                <form style="background-color: white !important; width: 100%;" id="form-save-modal">
                    <div class="mb-3">
                        <label for="code" class="form-label">Code</label>
                        <div hidden>
                            <input type="text" class="form-control" id="id" aria-describedby="id">
                        </div>
                        <input type="text" class="form-control required" maxlength="25" id="code" aria-describedby="code">
                        <small id="code" class="form-text text-muted">* required, must be unique, max 25 characters</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">ASC Name</label>
                        <textarea type="text" class="form-control required" maxlength="50" id="description" aria-describedby="description">
                        </textarea>
                        <small id="description" class="form-text text-muted">* required, must be unique, max 50 characters</small>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deployment Date</label>
                        <input type="text" class="form-control required" id="deploy_date" placeholder="Select Date">
                        <small id="description" class="form-text text-muted">* required</small>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Area</label>
                        <input type="text" class="form-control" id="area_id" aria-describedby="area_id" hidden>
                        <select name="area" class="form-control required" id="area">
                        </select>
                        <small id="description" class="form-text text-muted">* required</small>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="status" checked>
                        <label class="form-check-label" for="status">Active</label>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="import_modal" data-backdrop="static">
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
    
                        <label for="file" class="custom-file-upload save" style="margin-left:10px; margin-top: 10px">
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

                        <!-- nextButton -->
    
                        <label for="preview" class="custom-file-upload save" id="preview_xl_file" style="margin-top: 10px" onclick="read_xl_file()">
                            <i class="fa fa-sync" style="margin-right: 5px;"></i>Preview Data
                        </label>

                        <!-- <label for="preview" class="custom-file-upload save" id="nextButton" style="margin-top: 10px">
                            <i class="fa fa-sync" style="margin-right: 5px;"></i>Next
                        </label> -->
    
                        <table class= "table table-bordered listdata">
                            <thead>
                                <tr>
                                    <th style="width: 10%;" class='center-content'>Line #</th>
                                    <th style="width: 20%;" class='center-content'>Code</th>
                                    <th style="width: 20%;" class='center-content'>ASC Name</th>
                                    <th style="width: 10%;" class='center-content'>Status</th>
                                    <th style="width: 20%;" class='center-content'>Deployment Date</th>
                                    <th style="width: 10%;" class='center-content'>Area</th>
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
    var url = "<?= base_url("cms/global_controller");?>";

    $(document).ready(function() {
        get_data(query);
        get_pagination();
        
        $("#deploy_date").datepicker({
            changeMonth: true,
            changeYear: true
        });
    });

    function get_data(new_query) {
        var data = {
            event : "list",
            select : "id, code, description, status, created_date, updated_date, area_id",
            query : new_query,
            offset : offset,
            limit : limit,
            table : "tbl_asc",
            order : {
                field : "code",
                order : "asc" 
            }
        }
    
        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            var html = '';

            if(result) {
                if (result.length > 0) {
                    $.each(result, function(x,y) {

                        var status = ( parseInt(y.status) === 1 ) ? status = "Active" : status = "Inactive";
                        var createddate = formatReadableDate(y.created_date, true)
                        var updateddate = "";
                        if (y.updated_date === null) {
                            updateddate = "N/A";
                        } else {
                            updateddate = formatReadableDate(y.updated_date, true);
                        }
                        var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";
    
                        html += "<tr class='" + rowClass + "'>";
                        html += "<td class='center-content' style='width: 5%;'>"+
                        "<input class='select' type=checkbox data-id="+y.id+" onchange=checkbox_check()>"+
                        "</td>";
                        html += "<td style='width: 10%'>" + trimText(y.code, 10) + "</td>";
                        html += "<td style='width: 15%'>" + trimText(y.description, 10) + "</td>";
                        html += "<td style='width: 15%'>" + status + "</td>";
                        html += "<td style='width: 20%'>" + createddate + "</td>";
                        html += "<td style='width: 20%'>" + updateddate + "</td>";
    
                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                            html+="<td class='center-content' style='width: 25%; min-width: 300px'>";
                            html+="<a class='btn-sm btn update' onclick=\"edit_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Edit Details'><span class='glyphicon glyphicon-pencil'>Edit</span>";
                            html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Delete Item'><span class='glyphicon glyphicon-pencil'>Delete</span>";
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
        
        modal.confirm(modal_obj, function (result) {
            if (result) {
                var url = "<?= base_url('cms/global_controller');?>";
                var dataList = [];
                
                $('.select:checked').each(function () {
                    var id = $(this).attr('data-id');
                    dataList.push({
                        event: "update",
                        table: "tbl_asc",
                        field: "id",
                        where: id,
                        data: {
                            status: status,
                            updated_date: formatDate(new Date()),
                            updated_by: user_id,
                        }
                    });
                });
    
                if (dataList.length === 0) return;
    
                var processed = 0;
                dataList.forEach((data, index) => {
                    aJax.post(url, data, (result) => {
                        if (hasExecuted) return; // Prevents multiple executions
    
                        modal.loading(false);
                        processed++;
    
                        if (result === "success") {
                            if (!hasExecuted) {
                                hasExecuted = true;
                                $('.btn_status').hide();
                                modal.alert(modal_alert_success, 'success', () => {location.reload();});
                            }
                        } else {
                            if (!hasExecuted) {
                                hasExecuted = true;
                                modal.alert(failed_transaction_message, 'success', () => {location.reload();});
                            }
                        }
                    });
                });
            }
        });
    });

    function get_area(id) {
        var data = {
            event : "list",
            select : "id, code, description, status",
            query : 'status >= 0',
            offset : 0,
            limit : 0,
            table : "tbl_area",
            order : {
                field : "code",
                order : "asc" 
            }
        }

        var html = '<option id="default_val" value=" ">Select Area</option>';
        aJax.post_async(url,data,function(res){
            var result = JSON.parse(res);
    
            if(result) {
                if (result.length > 0) {
                    var selected = '';
                    $.each(result, function(x,y) {
                        if (id === y.id) {
                            selected = 'selected'

                        } else {
                            selected = ''
                        }
                        html += "<option value='"+y.id+"' "+selected+">"+y.code+"</option>"
                    })
                }
            }
            $('#area').empty();
            $('#area').append(html);
        })
    }

    function get_pagination() {
        var data = {
        event : "pagination",
            select : "id",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_asc",
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
        get_pagination()
        modal.loading(false);
    });

    $(document).on('keydown', '#search_query', function(event) {
        if (event.key == 'Enter') {
            search_input = $('#search_query').val();
            offset = 1;
            new_query = query;
            new_query += ' and code like \'%'+search_input+'%\' or '+query+' and description like \'%'+search_input+'%\'';
            get_data(new_query);
            get_pagination();
        }
    });

    // add
    $('#btn_add').on('click', function() {
        open_modal('Add New ASC', 'add', '');
    });

    // import
    $('#btn_import').on('click', function() {
        title = addNbsp('IMPORT ASC')
        $("#import_modal").find('.modal-title').find('b').html(title)
        $('#import_modal').modal('show');
    });

    // edit
    function edit_data(id) {
        open_modal('Edit ASC', 'edit', id);
    }

    // delete
    function delete_data(id) {
        modal.confirm(confirm_delete_message,function(result){
            if(result){
                var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
                var data = {
                    event : "update", // list, insert, update, delete
                    table : "tbl_asc", //table
                    field : "id",
                    where : id, 
                    data : {
                        status : -2,
                        updated_by : user_id,
                        updated_date : formatDate(new Date()),
                    }  
                }

                aJax.post_async(url,data,function(result){
                    var obj = is_json(result);
                    if(obj){
                        modal.alert(success_delete_message, 'success', () => {
                            if (result) {
                                location.reload();
                            }
                        })
                    }
                });
            }
        })
    }

    // view
    function view_data(id) {
        open_modal('View ASC', 'view', id);
    }

    function open_modal(msg, actions, id) {
        // add modal title
        $(".validate_error_message").remove();
        $(".form-control").css('border-color','#ccc');
        $('#popup_modal .modal-title b').html(addNbsp(msg));
        // clear the form inputs, dropdowns, and checkboxes
        reset_form();
        // <button type="button" class="btn save" id="save_data" onclick="validate_data()">Save</button>
        var save_btn = create_button('Save', 'save_data', 'btn save', function () {
            id = 0;
            validate_data()
        });
        // <button type="button" class="btn save" id="edit_data">Edit</button>
        var edit_btn = create_button('Edit', 'edit_data', 'btn save', function () {
            validate_data()
        });
        // <button type="button" class="btn caution" data-dismiss="modal">Close</button>
        var close_btn = create_button('Close', 'close_data', 'btn caution', function () {
            reset_form();
            $('#popup_modal').modal('hide');
        });
        switch (actions) {
            case 'add':
                // calls get_area('') to populate the area dropdown
                // passing an empty string so that no area is preselected
                // calls add_input_behavior(false) to enable input fields
                // clears the modal footer and adds the save and close buttons
                $('#id').val(0);
                get_area('')
                add_input_behavior(false);
                $('#popup_modal .modal-footer').empty();
                $('#popup_modal .modal-footer').append(close_btn);
                $('#popup_modal .modal-footer').append(save_btn);
                break;
                
            case 'edit':
                // calls populate_modal(id), which includes a call to get_area(area_id) internally
                // this ensures that the correct area is selected in the dropdown
                // calls add_input_behavior(false) to enable input fields
                // clears the modal footer and adds the edit and close buttons
                populate_modal(id);
                add_input_behavior(false);
                $('#popup_modal .modal-footer').empty();
                $('#popup_modal .modal-footer').append(close_btn);
                $('#popup_modal .modal-footer').append(edit_btn);
                break;
            
            case 'view':
                // calls populate_modal(id), which includes a call to get_area(area_id) internally
                // this ensures that the correct area is selected in the dropdown
                // calls add_input_behavior(true), to disable input fields to make the modal read-only
                // clears the modal footer and appends only the close button
                populate_modal(id);
                add_input_behavior(true);
                $('#popup_modal .modal-footer').empty();
                $('#popup_modal .modal-footer').append(close_btn);
                break;
        
            default:
                // behaves the same as 'view', so that if an unrecognized action value is passed,
                // the modal still loads in a read-only state with only the close button
                populate_modal(id);
                add_input_behavior(true);
                $('#popup_modal .modal-footer').empty();
                $('#popup_modal .modal-footer').append(close_btn);
                break;
        }
        // show modal
        $('#popup_modal').modal('show');
    }

    // clears all  user input/changes in the modal
    function reset_form() {
        $('#popup_modal #code').val('');
        $('#popup_modal #description').val('');
        $('#popup_modal #status').prop('checked', true);
        $('#popup_modal #area_id').val('');
        $('#popup_modal #area option').removeAttr('selected'); // Remove 'selected' from all options
        $('#popup_modal #area option:first').attr('selected', 'selected'); // Add 'selected' to the first option
        $('#popup_modal #deploy_date').val('');
    }

    // decides whether to enable or disable input fields
    function add_input_behavior(bool) {
        $('#code').attr('readonly', bool);
        $('#code').attr('disabled', bool);
        $('#description').attr('readonly', bool);   
        $('#description').attr('disabled', bool);
        $('#deploy_date').attr('readonly', bool);   
        $('#deploy_date').attr('disabled', bool);
        $('#area').attr('readonly', bool);   
        $('#area').attr('disabled', bool);
        $('#status').attr('readonly', bool);   
        $('#status').attr('disabled', bool);
    }

    // creates a button element with the specified text, id, class, and onclick event
    function create_button(btn_txt, btn_id, btn_class, onclick_event) {
        var new_btn = $('<button>', {
            text: btn_txt,
            id: btn_id,
            class: btn_class,
            click: onclick_event // Attach the onclick event
        });
        return new_btn;
    }

    // validates the data in the modal
    function validate_data() {
        // calls validate.standard("form-save-modal") to check if the form is valid
        if(validate.standard("form-save-modal")){
            // calls check_current_db() to check if the code and description already exist in the database

            var id = $('#id').val() || 0;
            var code = $('#code').val()
            var description = $('#description').val()
            var status = $('#status').prop('checked')
            var deploy_date = $('#deploy_date').val()
            var area_id = $('#popup_modal #area').val();
            var db_fields = [];
            var input_fields = [];
            if (id != 0) {
                db_fields = ["id", "code", "description"];
                input_fields = [id, code, description];
                excludeField = "id";
                excludeId = id;
            } else {
                db_fields = ["code", "description"];
                input_fields = [code, description];
                excludeField = null;
                excludeId = null;
            }

            check_current_db("tbl_asc", db_fields, input_fields, "status" , excludeField, excludeId, true, function(exists, duplicateFields) {
                if(!exists) {
                    if (id != 0) {
                        confirm_edit(id, code, description, status, deploy_date, area_id);
                    } else {
                        confirm_save(code, description, status, deploy_date, area_id);
                    }
                }
            });
        }
    }

    // confirms if the user wants to save the data
    function confirm_save(code, description, status, date, area) {
        // checks if the status is true or false and sets the value accordingly
        if (status) {
            val_status = 1
            chk_val = 'Active'
        } else {
            val_status = 0
            chk_val = 'Inactive'
        }
        var converted_date = formatDateToISO(date)

        var new_area_code = '';
        var area_code_array = {};
        get_field_values('tbl_area', 'code', 'id', [area], (res)=>{
            $.each(res, (x, y) => {
                area_code_array[x] = y;
            })
            var html = "<table class= 'table table-bordered listdata'>"
            html += "<thead>"
            html += "<tr>"
            html += "<th class='center-content'>Code</th>"
            html += "<th class='center-content'>Description</th>"
            html += "<th class='center-content'>Deployment Date</th>"
            html += "<th class='center-content'>Status</th>"
            html += "<th class='center-content'>Area</th>"
            html += "</tr>"
            html += "</thead>"
    
            html += "<tbody class='table_body word_break'>"
            html += "<tr>"
            html += "<td style='width:20%'>"+trimText(code, 10)+"</td>"
            html += "<td style='width:20%'>"+trimText(description, 10)+"</td>"
            html += "<td style='width:20%'>"+formatReadableDate(date, false)+"</td>"
            html += "<td style='width:20%'>"+chk_val+"</td>"
            html += "<td style='width:20%'>"+area_code_array[area]+"</td>"
            html += "</tr>"
            html += "</tbody>"
            html += "</table>"
            // calls modal.confirm() to confirm if the user wants to save the data
            modal.confirm(confirm_add_message, function(result){
                if(result){
                    // if the user confirms, call save_to_db() to save the data
                    // passing the code, description, status, converted_date, and area as parameters
                    data = {
                        'code': code, 
                        'description':description, 
                        'status':val_status, 
                        'deploy_date':converted_date, 
                        'area_id':area
                    }
                    save_to_db(data, function () {
                        modal.content(success_save_message, 'success', html, '1000px', ()=>{location.reload();})
                    })
                }
            })
        })
    }

    // saves the data to the database
    function save_to_db(user_input, callback) {
        var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
        var data = {
            event : "insert", // list, insert, update, delete
            table : "tbl_asc", //table
            data : {
                code : user_input.code,
                description : user_input.description,
                deploy_date : user_input.deploy_date,
                status : user_input.status,
                area_id : user_input.area_id,
                created_by : user_id,
                created_date : formatDate(new Date()),
            }  
        }
    
        // calls aJax.post() to send the data to the controller
        aJax.post_async(url,data,function(result){
            var obj = is_json(result);
            // calls the callback function and passes the result
            callback();
        });
    }

    function batch_insert(insert_batch_data, cb){
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
             event: "batch_insert",
             table: "tbl_asc",
             insert_batch_data: insert_batch_data
        }

        aJax.post(url,data,function(result){
            cb(result.message)
        });
    }

    function confirm_edit(id, code, description, status, date, area) {
        // checks if the status is true or false and sets the value accordingly
        if (status) {
            val_status = 1
            chk_val = 'Active'
        } else {
            val_status = 0
            chk_val = 'Inactive'
        }
        var converted_date = formatDateToISO(date)
        var old = {}

        list_current_db(
            function (res) {
                var parsedResult = JSON.parse(res);
                $.each(parsedResult, function(index, asc) {
                    if (id === asc.id) {
                        if (asc.status === 1) {
                            status_val = 'Inactive'
                        } else {
                            status_val = 'Active'
                        }
                        old['code'] = asc.code;
                        old['description'] = asc.description;
                        old['deploy_date'] = asc.deploy_date;
                        old['status'] = status_val;
                        old['area_id'] = asc.area_id;
                    }
                })
            }
        )

        var old_area_code = '';
        var new_area_code = '';
        var area_code_array = {};
        get_field_values('tbl_area', 'code', 'id', [old.area_id, area], (res)=>{
            $.each(res, (x,y) => {
                area_code_array[x] = y
            })

            var html = "<table class= 'table table-bordered listdata'>"
            html += "<thead>"
            html += "<tr>"
            html += "<th class='center-content'></th>"
            html += "<th class='center-content'>Code</th>"
            html += "<th class='center-content'>Description</th>"
            html += "<th class='center-content'>Deployment Date</th>"
            html += "<th class='center-content'>Status</th>"
            html += "<th class='center-content'>Area</th>"
            html += "</tr>"
            html += "</thead>"

            html += "<tbody class='table_body word_break'>"

            html += "<tr>"
            html += "<td style='width:10%'><b>From</b></td>"
            html += "<td style='width:20%'>"+trimText(old.code, 10)+"</td>"
            html += "<td style='width:20%'>"+trimText(old.description, 10)+"</td>"
            html += "<td style='width:20%'>"+formatReadableDate(old.deploy_date, false)+"</td>"
            html += "<td style='width:20%'>"+old.status+"</td>"
            html += "<td style='width:10%'>"+area_code_array[old.area_id]+"</td>"
            html += "</tr>"
    
            html += "<tr>"
            html += "<td>⬇️</td>"
            html += "<td>⬇️</td>"
            html += "<td>⬇️</td>"
            html += "<td>⬇️</td>"
            html += "<td>⬇️</td>"
            html += "<td>⬇️</td>"
            html += "</tr>"
    
            html += "<tr>"
            html += "<td><b>To</b></td>"
            html += "<td>"+trimText(code, 10)+"</td>"
            html += "<td>"+trimText(description, 10)+"</td>"
            html += "<td>"+formatReadableDate(date , false)+"</td>"
            html += "<td>"+chk_val+"</td>"
            html += "<td>"+area_code_array[area]+"</td>"
            html += "</tr>"
            html += "</tbody>"
            html += "</table>"

            // calls modal.confirm() to confirm if the user wants to save the data
            modal.confirm(confirm_update_message,function(result){
                if(result){
                    // if the user confirms, call save_to_db() to save the data
                    // passing the code, description, status, converted_date, and area as parameters
                    data = {
                        'id': id,
                        'code': code, 
                        'description':description, 
                        'status':val_status, 
                        'deploy_date':converted_date, 
                        'area_id':area
                    }
                    update_db(data, function () {
                        // show users what was saved
                        // after users press ok refresh page
                        modal.content(success_update_message, 'success', html, '1000px', ()=>{location.reload();})
                    })
                }
            })
        })
    }

    function update_db(user_input, callback) {
        var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
        var data = {
            event : "update", // list, insert, update, delete
            table : "tbl_asc", //table
            field : "id",
            where : user_input.id, 
            data : {
                code : user_input.code,
                description : user_input.description,
                status : user_input.status,
                deploy_date : user_input.deploy_date,
                area_id : user_input.area_id,
                updated_by : user_id,
                updated_date : formatDate(new Date()),
            }  
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result);
            callback();
        });
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
                var td_validator = ['code', 'name', 'status', 'deployment date', 'area'];
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
        var deploy_date = '';
        var area_id = '';

        var invalid = false;
        var errmsg = '';

        var unique_code = [];
        var unique_description = [];
        var unique_area_id = [];
        var area_desc = [];

        var import_array = [];
        var needle = [];

        var tr_count = 1;
        var row_mapping = {};

        extracted_data.find('tr').each(function () {
            td_count = 1;
            var temp = [];
            $(this).find('td').each(function () {
                var text_val = $(this).html().trim();

                if (td_count === 2) {
                    if (unique_code.includes(text_val)) {
                        invalid = true;
                        errmsg += "⚠️ Duplicated Code at line #: <b>" + tr_count + "</b>⚠️<br>";
                    } else if (text_val.length > 25) {
                        invalid = true;
                        errmsg += "⚠️ Code exceeds 25 characters at line #: <b>" + tr_count + "</b>⚠️<br>";
                    } else if (text_val === '') {
                        invalid = true;
                        errmsg += "⚠️ Code is empty at line #: <b>" + tr_count + "</b>⚠️<br>";
                    } else {
                        code = text_val;
                        unique_code.push(text_val);
                        row_mapping[code] = tr_count;
                    }
                }

                if (td_count === 3) {
                    if (unique_description.includes(text_val)) {
                        invalid = true;
                        errmsg += "⚠️ Duplicated Description at line #: <b>" + tr_count + "</b>⚠️<br>";
                    } else if (text_val.length > 50) {
                        invalid = true;
                        errmsg += "⚠️ Description exceeds 50 characters at line #: <b>" + tr_count + "</b>⚠️<br>";
                    } else if (text_val === '') {
                        invalid = true;
                        errmsg += "⚠️ Description is empty at line #: <b>" + tr_count + "</b>⚠️<br>";
                    } else {
                        description = text_val;
                        unique_description.push(text_val);
                        row_mapping[description] = tr_count;
                    }
                }

                if (td_count === 4) {
                    if (text_val.toLowerCase() === 'active') {
                        status = 1;
                    } else if (text_val.toLowerCase() === 'inactive') {
                        status = 0;
                    } else {
                        invalid = true;
                        errmsg += "⚠️ Invalid Status at line #: <b>" + tr_count + "</b>⚠️<br>";
                    }
                }

                if (td_count === 5) {
                    let dateObj = new Date(text_val);
                    if (isNaN(dateObj.getTime())) {
                        invalid = true;
                        errmsg += "⚠️ Invalid Deployment Date at line #: <b>" + tr_count + "</b>⚠️<br>";
                    } else {
                        deploy_date = readable_date_to_excel_date(text_val);
                    }
                }

                if (td_count === 6) {
                    if (!unique_area_id.includes(text_val)) {
                        unique_area_id.push(text_val);
                    }
                    area_id = text_val;
                }

                td_count += 1;
            });

            tr_count += 1;
            temp.push(code, description, status, deploy_date, area_id);
            if(!area_desc.includes(area_id)){
                area_desc.push(area_id)
            }
            needle.push([code,description]);
            import_array.push(temp);
        });

        var temp_invalid = invalid;
        var temp_errmsg = '';

        invalid = temp_invalid;
        errmsg += temp_errmsg;

        var table = 'tbl_asc';
        var haystack = ['code', 'description'];
        var selected_fields = ['id', 'code', 'description'];

        if (invalid) {
            modal.content('Error', 'error', errmsg, '600px', ()=>{});
        } else {
            list_existing(table, selected_fields, haystack, needle, function (result) {
                if (result.status === "error") {
                    let errmsg = "";
                    let processedFields = new Set();

                    $.each(result.existing, function (index, record) {
                        $.each(record, function (field, value) {
                            if (!processedFields.has(field + value)) { 
                                let line_number = row_mapping[value] || "Unknown";
                                errmsg += "⚠️ " + field.charAt(0).toUpperCase() + field.slice(1) + " already exists in masterfile at line #: <b>" + line_number + "</b>⚠️<br>";
                                processedFields.add(field + value); // Mark as processed
                            }
                        });
                    });
                    modal.content('Error', 'error', errmsg, '600px', () => {});
                } else {
                    var batch = [];
                    let area_desc_list = [...new Set(import_array.map(row => row[4]))];
                    get_field_values("tbl_area", "code", "code", area_desc_list, (res) => {
                        let areaMapping = {};
                        $.each(res, (x,y) => {
                            areaMapping[y] = x;
                        })

                        import_array.forEach(row => {
                            let matchedArea = areaMapping[row[4]];
                            let area_id = matchedArea ? matchedArea : null;

                            let data = {
                                'code': row[0],
                                'description': row[1],
                                'status': row[2],
                                'deploy_date': row[3],
                                'area_id': area_id,  // Replaced with the fetched value
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
                    });
                }
            });
        }
    }

    function readable_date_to_excel_date(readable_date) {
        var dateObj = new Date(readable_date);
        
        var yyyy = dateObj.getFullYear();
        var mm = String(dateObj.getMonth() + 1).padStart(2, '0'); // Months are 0-based
        var dd = String(dateObj.getDate()).padStart(2, '0');
        
        var formattedDate = `${yyyy}-${mm}-${dd}`;

        return formattedDate;
    }

    function excel_date_to_readable_date(excel_date) {
        var date = new Date((excel_date - (25567 + 1)) * 86400 * 1000);
        return date.toLocaleDateString("en-US", { 
            year: "numeric", 
            month: "long", 
            day: "numeric" 
        });
    }

    function populate_modal(inp_id) {
        var query = "status >= 0 and id = " + inp_id;
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, code, description, status, area_id, deploy_date",
            query : query, 
            limit : 1,
            table : "tbl_asc"
        }
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(index,asc) {
                    $('#id').val(asc.id);
                    $('#code').val(asc.code);
                    $('#description').val(asc.description);
                    $('#area_id').val(asc.area_id);
                    $('#deploy_date').val(formatDateToMMDDYYYY(asc.deploy_date))
                    get_area(asc.area_id);
                    if(asc.status == 1) {
                        $('#status').prop('checked', true)
                    } else {
                        $('#status').prop('checked', false)
                    }
                }); 
            }
        });
    }

    function list_current_db(successCallback) {
        var data = {
            event : "list",
            select : "id, code, description, deploy_date, status, area_id",
            query : "status >= 0",
            offset : 0,
            limit : 0,
            table : "tbl_asc",
        }
        jQuery.ajax({
            url: url,
            type: 'post',
            data: data,
            async: false,
            success: function (res) {
                successCallback(res);
            }, error(e){
                alert('alert', e)
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

    // Converts a date string from mm/dd/yyyy to yyyy-mm-dd
    function formatDateToISO(dateStr) {
        const [mm, dd, yyyy] = dateStr.split('/'); // Destructuring the parts
        return `${yyyy}-${mm.padStart(2, '0')}-${dd.padStart(2, '0')}`;
    }

    // Converts a date string to mm/dd/yyyy format
    function formatDateToMMDDYYYY(dateStr) {
        const date = new Date(dateStr);
        const mm = String(date.getMonth() + 1).padStart(2, '0'); // Month is 0-based
        const dd = String(date.getDate()).padStart(2, '0');
        const yyyy = date.getFullYear();
        return `${mm}/${dd}/${yyyy}`;
    }

    // Formats a date string to a readable format
    function formatReadableDate(dateStr, datetime) {
        const date = new Date(dateStr);
        if (datetime) {
            return date.toLocaleDateString("en-US", { 
                year: "numeric", 
                month: "short", 
                day: "numeric",
                hour:"2-digit",
                minute:"2-digit",
                second:"2-digit",
                hour12:true
            });
        } else {
            return date.toLocaleDateString("en-US", { 
                year: "numeric", 
                month: "short", 
                day: "numeric",
            });
        }
    }

    function load_swal(swclass, swwidth, swicon, swtitle, swtext, swoutclick, swesckey, callback) {
        Swal.fire({
            customClass: swclass,
            width: swwidth,
            icon: swicon,
            title: swtitle,
            html: swtext,
            allowOutsideClick: swoutclick,
            allowEscapeKey: swesckey,
        }).then((result) => {
            if (result.isConfirmed) {
                callback()
		    }
        });
    }

    function trimText(str, length) {
        if (str.length > length) {
            return str.substring(0, length) + "...";
        } else {
            return str;
        }
    }

    // addNbsp()™: A Truly Revolutionary Function
    // This function is the epitome of laziness and brilliance combined. 
    // Why manually type `&nbsp;` repeatedly when you can let JavaScript do the heavy lifting?
    // With `addNbsp`, you can transform every character in a string into a spaced-out masterpiece,
    // replacing regular spaces with double `&nbsp;&nbsp;` and adding `&nbsp;` after every other character. 
    // It’s elegant. It’s lazy. It’s genius.
    // Honestly, this function is not just a tool—it’s a lifestyle.
    function addNbsp(inputString) {
        return inputString.split('').map(char => {
            if (char === ' ') {
            return '&nbsp;&nbsp;';
            }
            return char + '&nbsp;';
        }).join('');
    }

</script>