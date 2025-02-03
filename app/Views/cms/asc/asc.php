
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
                                    <th class='center-content'>Deployment Date</th>
                                    <th class='center-content'>Status</th>
                                    <th class='center-content'>Area ID</th>
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

<div class="modal" tabindex="-1" id="popup_modal">
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
                <form style="background-color: white !important; width: 100%;" id="form-save-modal">
                    <div class="mb-3">
                        <label for="code" class="form-label">Code</label>
                        <input type="text" class="form-control" id="id" aria-describedby="id" hidden>
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

                        <label for="preview" class="custom-file-upload save" id="nextButton" style="margin-top: 10px">
                            <i class="fa fa-sync" style="margin-right: 5px;"></i>Next
                        </label>
    
                        <table class= "table table-bordered listdata">
                            <thead>
                                <tr>
                                    <th style="width: 10%;" class='center-content'>Line #</th>
                                    <th style="width: 20%;" class='center-content'>Code</th>
                                    <th style="width: 20%;" class='center-content'>ASC Name</th>
                                    <th style="width: 10%;" class='center-content'>Status</th>
                                    <th style="width: 20%;" class='center-content'>Deployment Date</th>
                                    <th style="width: 10%;" class='center-content'>Area ID</th>
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
            select : "id, code, description, status, deploy_date, area_id",
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
                        var deployed_date = formatReadableDate(y.deploy_date)
                        var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";
    
                        html += "<tr class='" + rowClass + "'>";
                        html += "<td class='center-content'><input class='select' type=checkbox data-id="+y.id+" onchange=checkbox_check()></td>";
                        html += "<td style='width: 10%'>" + trimText(y.code) + "</td>";
                        html += "<td style='width: 20%'>" + trimText(y.description) + "</td>";
                        html += "<td style='width: 20%'>" + deployed_date + "</td>";
                        html += "<td style='width: 10%'>" + status + "</td>";
                        html += "<td style='width: 10%'>" + y.area_id + "</td>";
    
                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                            html+="<td class='center-content' style='width: 25%'>";
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

        aJax.post(url,data,function(res){
            var result = JSON.parse(res);
            var html = '<option id="default_val" value=" ">Select Area</option>';
    
            if(result) {
                if (result.length > 0) {
                    var selected = '';
                    $.each(result, function(x,y) {
                        if (id === y.id) {
                            selected = 'selected'

                        } else {
                            selected = ''
                        }
                        html += "<option value='"+y.id+"' "+selected+">"+y.description+"</option>"
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
        modal.loading(false);
    });

    $(document).on('keydown', '#search_query', function(event) {
        if (event.key == 'Enter') {
            search_input = $('#search_query').val();
            offset = 1;
            get_pagination();
            new_query = query;
            new_query += ' and code like \'%'+search_input+'%\' or '+query+' and description like \'%'+search_input+'%\'';
            get_data(new_query);
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
        // alert('Data deleted!');
        modal.confirm("Are you sure you want to delete this record?",function(result){
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

                aJax.post(url,data,function(result){
                    var obj = is_json(result);
                    if(obj){
                        load_swal('','600px','success','Succesfully deleted!','', false, false, function () {
                            location.reload();
                        });
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
        $('#popup_modal .modal-title b').html(addNbsp(msg));
        // clear the form inputs, dropdowns, and checkboxes
        reset_form();
        // <button type="button" class="btn save" id="save_data" onclick="validate_data()">Save</button>
        var save_btn = create_button('Save', 'save_data', 'btn save', function () {
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
            check_current_db(function (result) {
                var id = $('#id').val() || 0;
                var code = $('#code').val()
                var description = $('#description').val()
                var status = $('#status').prop('checked')
                var deploy_date = $('#deploy_date').val()
                var area_id = $('#popup_modal #area').val();
    
                var parsedResult = JSON.parse(result);
    
                invalid = false;
                err_msg = '';
                // loops through the parsed result to check if the code or description already exists
                $.each(parsedResult, function(index, asc) {
                    // if the code and description already exist, set invalid to true and add an error message
                    if (asc.code === code || asc.description === description) {
                        if (id != asc.id) {
                            invalid = true;
                            if (asc.code === code && asc.description === description) {
                                err_msg += "⚠️ Code & Description already exists in masterfile ⚠️<br>";
                            } else if (asc.code === code) {
                                err_msg += "⚠️ Code already exists in masterfile ⚠️<br>";
                            } else {
                                err_msg += "⚠️ Description already exists in masterfile ⚠️<br>";
                            }
                        }
                    }
                });
    
                // if invalid is true, show an error message
                if(invalid) {
                    load_swal('','600px','error','Error!',err_msg, false, false, function () {});
                } else {
                    // if invalid is false, call confirm_edit() if id is not 0, otherwise call confirm_save()
                    if (id != 0) {
                        // alert('confirm_edit() called');
                        confirm_edit(id, code, description, status, deploy_date, area_id);
                    } else {
                        confirm_save(code, description, status, deploy_date, area_id);
                    }
                }
            })
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
        var html = "<table class= 'table table-bordered listdata'>"
        html += "<thead>"
        html += "<tr>"
        html += "<th class='center-content'>Code</th>"
        html += "<th class='center-content'>Description</th>"
        html += "<th class='center-content'>Deployment Date</th>"
        html += "<th class='center-content'>Status</th>"
        html += "<th class='center-content'>Area ID</th>"
        html += "</tr>"
        html += "</thead>"

        html += "<tbody class='table_body word_break'>"
        html += "<tr>"
        html += "<td style='width:20%'>"+trimText(code)+"</td>"
        html += "<td style='width:20%'>"+trimText(description)+"</td>"
        html += "<td style='width:20%'>"+formatReadableDate(date)+"</td>"
        html += "<td style='width:20%'>"+chk_val+"</td>"
        html += "<td style='width:20%'>"+area+"</td>"
        html += "</tr>"
        html += "</tbody>"
        html += "</table>"
        // calls modal.confirm() to confirm if the user wants to save the data
        modal.confirm("Are you sure you want to save this record?",function(result){
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
                    // show users what was saved
                    // after users press ok refresh page
                    load_swal(
                        '', '1000px', 'success', 'Succesfully saved!', html, false, false, function() {
                            location.reload();
                        }
                    )
                })
            }
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
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            // calls the callback function and passes the result
            callback();
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
        var html = "<table class= 'table table-bordered listdata'>"
        html += "<thead>"
        html += "<tr>"
        html += "<th class='center-content'></th>"
        html += "<th class='center-content'>Code</th>"
        html += "<th class='center-content'>Description</th>"
        html += "<th class='center-content'>Deployment Date</th>"
        html += "<th class='center-content'>Status</th>"
        html += "<th class='center-content'>Area ID</th>"
        html += "</tr>"
        html += "</thead>"

        html += "<tbody class='table_body word_break'>"
        var old = {}
        check_current_db(
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

        html += "<tr>"
        html += "<td style='width:10%'><b>From</b></td>"
        html += "<td style='width:20%'>"+trimText(old.code)+"</td>"
        html += "<td style='width:20%'>"+trimText(old.description)+"</td>"
        html += "<td style='width:20%'>"+formatReadableDate(old.deploy_date)+"</td>"
        html += "<td style='width:20%'>"+old.status+"</td>"
        html += "<td style='width:10%'>"+old.area_id+"</td>"
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
        html += "<td>"+trimText(code)+"</td>"
        html += "<td>"+trimText(description)+"</td>"
        html += "<td>"+formatReadableDate(date)+"</td>"
        html += "<td>"+chk_val+"</td>"
        html += "<td>"+area+"</td>"
        html += "</tr>"
        html += "</tbody>"
        html += "</table>"
        // calls modal.confirm() to confirm if the user wants to save the data
        modal.confirm("Are you sure you want to update this record?",function(result){
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
                    load_swal(
                        '', '1000px', 'success', 'Succesfully edited!', html, false, false, function() {
                            location.reload();
                        }
                    )
                })
            }
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

        console.log(file);
        if (file === undefined) {
            load_swal(
                '',
                '500px',
                'error',
                'Error!',
                'Please select a file to upload',
                false,
                true,
                function () {}
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
                tr_counter += 1;
            });

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
                var td_validator = ['code', 'name', 'status', 'deployment date', 'area id'];
                td_validator.forEach(column => {
                    if (column === 'deployment date') {
                        lowerCaseRecord[column] = excel_date_to_readable_date(lowerCaseRecord[column]);
                    } else {
                        lowerCaseRecord[column] = lowerCaseRecord[column];
                    }
                    html += "<td id=\"" + column + "\">";
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
    
    // Attach "Next" button event
    $("#nextButton").click(function () {
        alert('alert')
    });

    function proccess_xl_file() {
        var extracted_data = $(".import_table");
        extracted_data.find('tr').each(function () {
            $(this).find('td').each( function() {
                var text_val = $(this).html().trim();
            });
        });
        alert('Processing file...');
    }

    function excel_date_to_readable_date(excel_date) {
        // let jsDate = new Date((excelDate - 25569) * 86400 * 1000);
        // let readableDate = jsDate.toLocaleDateString();
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

    function check_current_db(successCallback) {
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
    function formatReadableDate(dateStr) {
        const date = new Date(dateStr);
        return date.toLocaleDateString("en-US", { 
            year: "numeric", 
            month: "long", 
            day: "numeric" 
        });
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

    function trimText(str) {
        if (str.length > 10) {
            return str.substring(0, 10) + "...";
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