<style>
    #list-data {
        overflow: visible !important;
        max-height: none !important;
        overflow-x: hidden !important;
        overflow-y: hidden !important;
    }
</style>

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
                                    <th class='center-content'>ASC Code</th>
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

<div 
    class="modal" 
    id="popup_modal" 
    data-backdrop="static"
>
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
                <form id="form-save-modal">
                    <div class="mb-3">
                        <label for="code" class="form-label">ASC Code</label>
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
                        <!-- <input type="text" class="form-control required" id="deployment_date" placeholder="Select Date"> -->
                        <input type="date" class="form-control required" id="deployment_date">
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
    
                        <table class="table table-bordered listdata">
                            <thead>
                                <tr>
                                    <th style="width: 10%;" class='center-content'>Line #</th>
                                    <th style="width: 20%;" class='center-content'>ASC Code</th>
                                    <th style="width: 20%;" class='center-content'>ASC Name</th>
                                    <th style="width: 10%;" class='center-content'>Status</th>
                                    <th style="width: 20%;" class='center-content'>Deployment Date</th>
                                    <th style="width: 10%;" class='center-content'>Area</th>
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
    var column_filter = '';
    var order_filter = '';
    var limit = 10;
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url("cms/global_controller");?>";
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

    function get_data(query, field = "code", order = "asc") {
        var data = {
            event : "list",
            select : "id, code, description, status, created_date, updated_date, area_id",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_area_sales_coordinator",
            order : {
                field : field,
                order : order
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
                        html += "<td style='width: 20%; min-width: 200px'>" + createddate + "</td>";
                        html += "<td style='width: 20%; min-width: 200px'>" + updateddate + "</td>";
    
                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                            html+="<td class='center-content' style='width: 25%; min-width: 300px'>";
                            html+="<a class='btn-sm btn update' onclick=\"edit_data('"+y.id+"')\" data-status='"
                                +y.status+"' id='"+y.id+"' title='Edit Details'><span class='glyphicon glyphicon-pencil'>Edit</span>";
                            html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.id+"')\" data-status='"
                                +y.status+"' id='"+y.id+"' title='Delete Item'><span class='glyphicon glyphicon-pencil'>Delete</span>";
                            html+="<a class='btn-sm btn view' onclick=\"view_data('"+y.id+"')\" data-status='"
                                +y.status+"' id='"+y.id+"' title='Show Details'><span class='glyphicon glyphicon-pencil'>View</span>";
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

        let id = $("input.select:checked");
        let code = [];
        let code_string = "selected data";

        id.each(function () {
            code.push(id.attr("data-id"));
        });

        get_field_values("tbl_area_sales_coordinator", "code", "id", code, (res) => {
            if(code.length == 1) {
                code_string = `Code <b><i>${res[code[0]]}</i></b>`
            }
        })
    
        if (parseInt(status) === -2) {
            message = is_json(confirm_delete_message);
            message.message = `Delete ${code_string} from Area Sales Coordinator Masterfile?`;
            modal_obj = JSON.stringify(message);
            modal_alert_success = success_delete_message;
        } else if (parseInt(status) === 1) {
            message = is_json(confirm_publish_message);
            message.message = `Publish ${code_string} from Area Sales Coordinator Masterfile?`;
            modal_obj = JSON.stringify(message);
            modal_alert_success = success_publish_message;
        } else {
            message = is_json(confirm_unpublish_message);
            message.message = `Unpublish ${code_string} from Area Sales Coordinator Masterfile?`;
            modal_obj = JSON.stringify(message);
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
                        table: "tbl_area_sales_coordinator",
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

    function get_pagination(query, field = "updated_date", order = "desc") {
        var data = {
        event : "pagination",
            select : "id",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_area_sales_coordinator",
            order : {
                field : field, //field to order
                order : order //asc or desc
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
        get_data(query, column_filter, order_filter);
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
        get_pagination(query)
        modal.loading(false);
    });

    $(document).on('keydown', '#search_query', function(event) {
        if (event.key == 'Enter') {
            search_input = $('#search_query').val();
            offset = 1;
            new_query = query;
            new_query += ' and code like \'%'+search_input+'%\' or '+query+' and description like \'%'+search_input+'%\'';
            get_data(new_query);
        }
    });

    $(document).on('click', '#search_button', function(event) {
        $('.btn_status').hide();
        $(".selectall").prop("checked", false);
        search_input = $('#search_query').val();
        offset = 1;
        new_query = query;
        new_query += ' and code like \'%'+search_input+'%\' or '+query+' and description like \'%'+search_input+'%\'';
        get_data(new_query);
        get_pagination(new_query);
    });

    $('#btn_filter').on('click', function(event) {
        title = addNbsp('FILTER DATA');
        $('#filter_modal').find('.modal-title').find('b').html(title);
        $('#filter_modal').modal('show');
    })

    $('#button_f').on('click', function(event) {
        let status_f = $("input[name='status_f']:checked").val();
        let c_date_from = $("#created_date_from").val();
        let c_date_to = $("#created_date_to").val();
        let m_date_from = $("#modified_date_from").val();
        let m_date_to = $("#modified_date_to").val();
        
        order_filter = $("input[name='order']:checked").val();
        column_filter = $("input[name='column']:checked").val();
        query = "status >= 0";
        
        query += status_f ? ` AND status = ${status_f}` : '';
        query += c_date_from ? ` AND created_date >= '${c_date_from} 00:00:00'` : ''; 
        query += c_date_to ? ` AND created_date <= '${c_date_to} 23:59:59'` : '';
        query += m_date_from ? ` AND updated_date >= '${m_date_from} 00:00:00'` : '';
        query += m_date_to ? ` AND updated_date <= '${m_date_to} 23:59:59'` : '';
        
        // console.log(query);
        get_pagination(query, column_filter, order_filter);
        get_data(query, column_filter, order_filter);
        $('#filter_modal').modal('hide');
    })
    
    $('#clear_f').on('click', function(event) {
        order_filter = '';
        column_filter = '';
        query = "status >= 0";
        get_data(query);
        get_pagination(query);
        
        $("input[name='status_f']").prop('checked', false);
        $("#created_date_from").val('');
        $('#created_date_to').val('');
        $('#modified_date_from').val('');
        $('#modified_date_to').val('');
        $("input[name='order']").prop('checked', false);
        $("input[name='column']").prop('checked', false);

        $('#filter_modal').modal('hide');
    })

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
        get_field_values("tbl_area_sales_coordinator", "code", "id", [id], (res) => {
            let code = res[id];
            let message = is_json(confirm_delete_message);
            message.message = `Delete Code <b><i>${code}</i></b> from Area Sales Coordinator?`

            modal.confirm(JSON.stringify(message),function(result){
                if(result){
                    var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
                    var data = {
                        event : "update", // list, insert, update, delete
                        table : "tbl_area_sales_coordinator", //table
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
        })
    }

    // view
    function view_data(id) {
        open_modal('View ASC', 'view', id);
    }

    function open_modal(msg, actions, id) {
        // remove error message
        $(".validate_error_message").remove();
        // remove error style
        $(".form-control").css('border-color','#ccc');
        // add modal title
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
                $('#popup_modal .modal-footer').append(save_btn);
                $('#popup_modal .modal-footer').append(close_btn);
                break;
                
            case 'edit':
                // calls populate_modal(id), which includes a call to get_area(area_id) internally
                // this ensures that the correct area is selected in the dropdown
                // calls add_input_behavior(false) to enable input fields
                // clears the modal footer and adds the edit and close buttons
                populate_modal(id);
                add_input_behavior(false);
                $('#popup_modal .modal-footer').empty();
                $('#popup_modal .modal-footer').append(edit_btn);
                $('#popup_modal .modal-footer').append(close_btn);
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
        $('#popup_modal #deployment_date').val('');
    }

    // decides whether to enable or disable input fields
    function add_input_behavior(bool) {
        $('#code').attr('readonly', bool);
        $('#code').attr('disabled', bool);
        $('#description').attr('readonly', bool);   
        $('#description').attr('disabled', bool);
        $('#deployment_date').attr('readonly', bool);   
        $('#deployment_date').attr('disabled', bool);
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

    function validate_data() {
        if(validate.standard("form-save-modal")){

            var id = $('#id').val() || 0;
            var code = $('#code').val()
            var description = $('#description').val()
            var status = $('#status').prop('checked')
            var deployment_date = $('#deployment_date').val()
            var area_id = $('#popup_modal #area').val();

            if (code === '' || description === '' || deployment_date === '' || area_id === '') {
                modal.alert(missing_user_input_message, 'error', () => {
                    reset_form();
                })
                return;
            }

            var db_fields = [];
            var input_fields = [];
            if (id != 0) {
                db_fields = ["id", "code", "description", "area_id"];
                input_fields = [id, code, description, area_id];
                excludeField = "id";
                excludeId = id;
            } else {
                db_fields = ["code", "description", "area_id"];
                input_fields = [code, description, area_id];
                excludeField = null;
                excludeId = null;
            }

            check_current_db("tbl_area_sales_coordinator", db_fields, input_fields, "status" , excludeField, excludeId, true, function(exists, duplicateFields) {
                if(!exists) {
                    if (id != 0) {
                        confirm_edit(id, code, description, status, deployment_date, area_id);
                    } else {
                        confirm_save(code, description, status, deployment_date, area_id);
                    }
                }
            });
        }
    }

    function confirm_save(code, description, status, date, area) {
        if (status) {
            val_status = 1
            chk_val = 'Active'
        } else {
            val_status = 0
            chk_val = 'Inactive'
        }

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
            modal.confirm(confirm_add_message, function(result){
                if(result){
                    data = {
                        'code': code, 
                        'description':description, 
                        'status':val_status, 
                        'deployment_date':date, 
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
            table : "tbl_area_sales_coordinator", //table
            data : {
                code : user_input.code,
                description : user_input.description,
                deployment_date : user_input.deployment_date,
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

    function confirm_edit(id, code, description, status, date, area) {
        // checks if the status is true or false and sets the value accordingly
        if (status) {
            val_status = 1
            chk_val = 'Active'
        } else {
            val_status = 0
            chk_val = 'Inactive'
        }
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
                        old['deployment_date'] = asc.deployment_date;
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
            html += "<td style='width:20%'>"+formatReadableDate(old.deployment_date, false)+"</td>"
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
                    // passing the code, description, status, date, and area as parameters
                    data = {
                        'id': id,
                        'code': code, 
                        'description':description, 
                        'status':val_status, 
                        'deployment_date':date, 
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
            table : "tbl_area_sales_coordinator", //table
            field : "id",
            where : user_input.id, 
            data : {
                code : user_input.code,
                description : user_input.description,
                status : user_input.status,
                deployment_date : user_input.deployment_date,
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
        $(".import_table").empty();
    }

    function paginateData(rowsPerPage) {
        totalPages = Math.ceil(dataset.length / rowsPerPage);
        currentPage = 1;
        display_imported_data();
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

            let td_validator = ['asc code', 'asc name', 'status', 'deployment date', 'area'];
            td_validator.forEach(column => {
                if (column === 'deployment date') {
                    lowerCaseRecord[column] = excel_date_to_readable_date(lowerCaseRecord[column]);
                }
                html += `<td>${lowerCaseRecord[column] !== undefined ? lowerCaseRecord[column] : ""}</td>`;
            });

            html += "</tr>";
            tr_counter += 1;
        });

        modal.loading(false);
        $(".import_table").html(html);
        updatePaginationControls();
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

    // try function
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

    //     const maxFileSize = 30 * 1024 * 1024; // 30MB in bytes
    //     if (file.size > maxFileSize) {
    //         modal.loading_progress(false);
    //         modal.alert('The file size exceeds the 30MB limit. Please upload a smaller file.', 'error', () => {});
    //         return;
    //     }

    //     modal.loading_progress(true, "Reviewing Data...");

    //     const reader = new FileReader();
    //     reader.onload = function(e) {
    //         const text = e.target.result;

    //         // Read CSV manually to avoid auto-conversion
    //         const workbook = XLSX.read(text, { type: "string", raw: true });
    //         const sheet = workbook.Sheets[workbook.SheetNames[0]];

    //         let jsonData = XLSX.utils.sheet_to_json(sheet, { raw: true });

    //         // Ensure only numbers are treated as text, keeping dates unchanged
    //         jsonData = jsonData.map(row => {
    //             let fixedRow = {};
    //             Object.keys(row).forEach(key => {
    //                 let value = row[key];

    //                 // Convert numbers to text while keeping dates unchanged
    //                 if (typeof value === "number") {
    //                     value = String(value); // Convert numbers to string
    //                 }

    //                 fixedRow[key] = value !== null && value !== undefined ? value : "";
    //             });
    //             return fixedRow;
    //         });

    //         console.log(jsonData);

    //         processInChunks(jsonData, 5000, () => {
    //             paginateData(rowsPerPage);
    //         });
    //     };

    //     reader.readAsText(file); 
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

        const maxFileSize = 30 * 1024 * 1024; // 30MB limit
        if (file.size > maxFileSize) {
            modal.loading_progress(false);
            modal.alert('The file size exceeds the 30MB limit. Please upload a smaller file.', 'error', () => {});
            return;
        }

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
        let jsonData = dataset.map(row => ({
            "ASC Code": row["ASC Code"] || "",
            "ASC Name": row["ASC Name"] || "",
            "Status": row["Status"] || "",
            "Deployment Date": row["Deployment Date"] || "",
            "Area": row["Area"] || "",
            "Created By": user_id || "",
            "Created Date": formatDate(new Date()) || ""
        }));

        // console.log(jsonData);
        // return;

        let worker = new Worker(base_url + "assets/cms/js/validator_asc.js");
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

    function saveValidatedData(valid_data) {
        let batch_size = 5000;
        let total_batches = Math.ceil(valid_data.length / batch_size);
        let batch_index = 0;
        let retry_count = 0;
        let max_retries = 5; 
        let errorLogs = [];
        let url = "<?= base_url('cms/global_controller');?>";
        let table = 'tbl_area_sales_coordinator';
        let selected_fields = ['id', 'code', 'description'];

        //for lookup of duplicate recors
        const matchFields = ["code", "description"];  
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

                            if (matchedId) break; // Stop looping if we found a match
                        }
                    }

                    if (matchedId) {
                        row.id = matchedId;
                        row.updated_date = formatDate(new Date());
                        delete row.created_date;
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
                            batch_update(url, updateRecords, "tbl_area_sales_coordinator", "id", false, (response) => {
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
                            batch_insert(url, newRecords, "tbl_area_sales_coordinator", false, (response) => {
                                if (response.message === 'success') {
                                    updateOverallProgress("Saving ASC...", batch_index + 1, total_batches);
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

    function readable_date_to_excel_date(readable_date) {
        var dateObj = new Date(readable_date);
        var yyyy = dateObj.getFullYear();
        var mm = String(dateObj.getMonth() + 1).padStart(2, '0');
        var dd = String(dateObj.getDate()).padStart(2, '0');
        var formattedDate = `${yyyy}-${mm}-${dd}`;

        return formattedDate;
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

    function populate_modal(inp_id) {
        var query = "status >= 0 and id = " + inp_id;
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, code, description, status, area_id, deployment_date",
            query : query, 
            limit : 1,
            table : "tbl_area_sales_coordinator"
        }
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(index,asc) {
                    $('#id').val(asc.id);
                    $('#code').val(asc.code);
                    $('#description').val(asc.description);
                    $('#area_id').val(asc.area_id);
                    $('#deployment_date').val(asc.deployment_date)
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
            select : "id, code, description, deployment_date, status, area_id",
            query : "status >= 0",
            offset : 0,
            limit : 0,
            table : "tbl_area_sales_coordinator",
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

    // function batch_insert(insert_batch_data, cb) {
    //     var url = "<?= base_url('cms/global_controller');?>";
    //     var data = {
    //         event: "batch_insert",
    //         table: "tbl_area_sales_coordinator",
    //         insert_batch_data: insert_batch_data
    //     };

    //     let retry_count = 0;
    //     let max_retries = 5; // Maximum retry attempts

    //     // Function to make the AJAX request and handle retries
    //     function attemptInsert() {
    //         $.ajax({
    //             type: "POST",
    //             url: url,
    //             data: data,
    //             success: function(result) {
    //                 if (result.message === "success") {
    //                     cb(true); // Success callback
    //                 } else {
    //                     handleSaveError(result); // Handle error if message is not success
    //                 }
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error("Save failed:", status, error);
    //                 handleSaveError({ message: 'fail' }); // Handle AJAX failure
    //             }
    //         });
    //     }

    //     // Handle the error and retry the request
    //     function handleSaveError(result) {
    //         if (retry_count < max_retries) {
    //             retry_count++;
    //             let wait_time = Math.pow(2, retry_count) * 1000; // Exponential backoff
    //             console.log(`Error saving batch. Retrying in ${wait_time / 1000} seconds...`);

    //             setTimeout(() => {
    //                 console.log(`Retrying attempt ${retry_count}...`);
    //                 attemptInsert(); // Retry the insertion
    //             }, wait_time);
    //         } else {
    //             console.error("Failed to save data after multiple attempts.");
    //             cb(false); // Call callback with failure if retries exceed max attempts
    //         }
    //     }

    //     // Initiate the first attempt to insert
    //     attemptInsert();
    // }

    // This code is a fine example of reinventing the wheel—except the wheel is square, and occasionally forgets it's a wheel.
    let startTime, endTime;

    // Function to start the timer
    function startTimer() {
        startTime = new Date(); // Get the current time
        console.log("Timer started at: " + startTime.toLocaleTimeString());
    }

    // Function to stop the timer
    function stopTimer() {
        if (!startTime) {
            console.log("Timer was not started!");
            return;
        }
        
        endTime = new Date(); // Get the current time
        console.log("Timer stopped at: " + endTime.toLocaleTimeString());
        
        let timeDiff = endTime - startTime; // Time difference in milliseconds
        let seconds = Math.floor(timeDiff / 1000); // Convert to seconds
        let minutes = Math.floor(seconds / 60);
        let hours = Math.floor(minutes / 60);
        
        seconds = seconds % 60; // Remaining seconds
        minutes = minutes % 60; // Remaining minutes

        console.log(`Elapsed time: ${hours}h ${minutes}m ${seconds}s`);
    }

    function download_template() {
        const headerData = [];

        formattedData = [
            {
                "ASC Code": "",
                "ASC Name": "",
                "Status": "",
                "Deployment Date": "",
                "Area": "",
                "NOTE:": "Please do not change the column headers."
            }
        ]

        exportArrayToCSV(formattedData, `Masterfile: Area Sales Coordinator - ${formatDate(new Date())}`, headerData);
    }

    $(document).on('click', '#btn_export', function () {
        modal.confirm(confirm_export_message,function(result){
            if (result) {
                startTimer()
                modal.loading_progress(true, "Reviewing Data...");
                setTimeout(() => {
                    handleExport()
                }, 500);
            }
        })
    })

    /**
     * Handles the export process for Area Sales Coordinator data.
     * This function retrieves selected records or fetches all records if none are selected,
     * formats the data, and exports it to an Excel file.
     */
    function handleExport() {
        var formattedData = []; // Array to store formatted data for export
        var ids = []; // Array to store selected record IDs
        
        // Collect selected record IDs from checkboxes
        $('.select:checked').each(function () {
            var id = $(this).attr('data-id');
            ids.push(`${id}`); // Wrap ID in single quotes
        });
        
        /**
         * Fetches store data based on selected IDs.
         * If IDs are provided, fetches specific records; otherwise, fetches all records in batches.
         * @param {Function} callback - Function to process the response data
         */
        const fetchAscs = (callback) => {
            /**
             * Processes the ajax response and formats the data.
             * @param {Array} res - ajax response containing store records
             */
            const processResponse = (res) => {
                console.log(res)
                formattedData = res.map(({
                    asc_code, asc_description, 
                    status, deployment_date, 
                    area_code, area_description 
                }) => ({
                    "ASC Code": asc_code,
                    "ASC Name": asc_description,
                    Status: status === "1" ? "Active" : "Inactive",
                    "Deployment Date": deployment_date,
                    "Area Code": area_code,
                    "Area Description": area_description,
                }));
            };

            // If specific IDs are selected, fetch corresponding records; 
            // otherwise, perform batch export
            ids.length > 0 
            ? dynamic_search(
                "'tbl_area_sales_coordinator a'", 
                "'left join tbl_area b on a.area_id = b.id'", 
                "'a.code as asc_code, a.description as asc_description, a.deployment_date as deployment_date, a.status as status, b.code as area_code, b.description as area_description'", 
                0, 
                0, 
                `'a.id:IN=${ids.join('|')}'`,  
                `''`, 
                `''`, 
                processResponse
            )
            : batch_export();
        };

        /**
         * Fetches all store data in batches if no specific IDs are selected.
         * Uses pagination to handle large datasets "efficiently".
         */
        function batch_export() {
            dynamic_search(
                "'tbl_area_sales_coordinator a'", 
                "''", 
                "'COUNT(id) as total_records'", 
                0, 
                0, 
                `''`,  
                `''`, 
                `''`, 
                (res) => {
                    if (res && res.length > 0) {
                        console.log(res[0].total_records, 'asc count');

                        let asc_count = res[0].total_records; // Total number of records

                        // Fetch data in batches of 100,000 records
                        for (let index = 0; index < asc_count; index += 100000) {
                            dynamic_search(
                                "'tbl_area_sales_coordinator a'", 
                                "'left join tbl_area b on a.area_id = b.id'", 
                                "'a.code as asc_code, a.description as asc_description, a.deployment_date as deployment_date, a.status as status, b.code as area_code, b.description as area_description'", 
                                100000, 
                                index, 
                                `''`,  
                                `''`, 
                                `''`, 
                                (res) => {
                                    console.log(res)
                                    let newData = res.map(({
                                        asc_code, asc_description, 
                                        status, deployment_date, 
                                        area_code, area_description 
                                    }) => ({
                                        Code: asc_code,
                                        Description: asc_description,
                                        Status: status === "1" ? "Active" : "Inactive",
                                        "Deployment Date": deployment_date,
                                        "Area Code": area_code,
                                        "Area Description": area_description,
                                    }));
                                    formattedData.push(...newData); // Append new data to formattedData array
                                }
                            )
                        }
                        
                    } else {
                        console.log('No data received'); // error handling
                    }
                }
            );
            
        }

        // Initiate data retrieval
        fetchAscs();

        console.log(formattedData, 'formattedData') // debugging

        // Header information for the exported Excel file
        const headerData = [
            ["Company Name: Lifestrong Marketing Inc."],
            ["Masterfile: Area Sales Coordinator"],
            ["Date Printed: " + formatDate(new Date())],
            [""],
        ];

        // Export the formatted data to an Excel file
        exportArrayToCSV(formattedData, `Masterfile: Area Sales Coordinator - ${formatDate(new Date())}`, headerData);

        // Hide the loading progress modal
        modal.loading_progress(false);

        console.log('done');
        stopTimer();
    };

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