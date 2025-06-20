<style>
    .password_chcklist_contanier p {
        display: inline-block;
        vertical-align: top;
        margin: 0;
        font-style: italic;
        text-indent: 3px;
    }

    #password_chcklist p {
        margin: 0;
    }

    .password_checker{
        color: #14C239;
    }
   /* .hidden{
        display: none;
    }*/
    .display-none {
        display: none;
    }
</style>


<div class="content-wrapper p-4">
    <div class="card">
        <div class="text-center page-title md-center">
            <b>U S E R S</b>
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
                                    <th class='center-content'>Name</th>
                                    <th class='center-content'>Username</th>
                                    <th class='center-content'>Email Address</th>
                                    <th class='center-content'>User Role</th>
                                    <th class='center-content'>Date Created</th>
                                    <th class='center-content'>Date Modified</th>
                                    <th class='center-content'>Status</th>
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

<!-- Add MODAL -->
<div class="modal fade" id="user_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">
                    <b></b>
                </h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span >&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-modal">
                    <div hidden>
                        <input type="text" class="form-control" id="id" aria-describedby="id">
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control required" id="name">
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control required" id="username">
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="text" class="form-control required" id="email">
                    </div>
                    <div class="form-group">
                        <label for="user_role">User Role</label>
                        <select class="form-control user_role required" id="user_role">
                        </select>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input large-checkbox" id="dashboard_access">
                        <label class="form-check-label large-label" for="dashboard_access">Has Dashboard Access</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input large-checkbox" id="status">
                        <label class="form-check-label large-label" for="status">Active</label>
                    </div>
                    
                    <div class="form-check display-none">
                        <input type="checkbox" class="form-check-input large-checkbox" id="update_pass">
                        <label class="form-check-label large-label" for="update_pass">Update Password?</label>
                    </div>

                    <hr>
    </form>
</div>
<div class="modal-footer">
</div>
</div>
</div>
</div>


<script>
    var query = "u.status >= 0";
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var role = '<?=$session->sess_role;?>';
    $(document).ready(function() {
      get_data(query);
      get_pagination(query);
      get_data_user_roles();
        if(role == 1){
            $( '<a href="#" id="btn_unblock" data-status=3 class=" btn_status btn-sm btn btn-default cms-btn" style="display: none;"> Unblock </a>' ).insertAfter( $( ".btn_trash" ) );
        }
    });

    $('#update_pass').change(function(){
        var passwordFormHtml = `
        <div class="panel-body password-div"> 
            <div accept-charset="UTF-8" role="form" class="form-signin">
                <fieldset>
                    <div class="callout" hidden style="margin-bottom: 0px !important;"></div>
                    <div class="form-group">
                        <label>New Password</label>
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        <input id="password1" name="password1" type="password" class="txtlog form-control required new-password" placeholder="New Password" autocomplete="new-password">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        <input id="password2" name="password2" type="password" class="txtlog form-control required re-password" placeholder="Confirm Password"/>
                    </div>
                    <div class="re-pw-err"></div>
                    <div id="password_chcklist">
                        <p>Password Must:</p>
                        <div class="password_chcklist_contanier">
                            <i class="fas fa-check-square min_ten_chck" ></i> <p class="min_ten_chckbx_p"> Minimum of 10 characters</p>
                        </div>
                        <div class="password_chcklist_contanier">
                            <i class="fas fa-check-square special_chck"></i> <p class="special_chckbx_p">At least 1 Special Character</p>
                        </div>
                        <div class="password_chcklist_contanier">
                            <i class="fas fa-check-square upper_chck"></i> <p class="upper_chckbx_p">At least 1 Uppercase</p>
                        </div>
                        <div class="password_chcklist_contanier">
                            <i class="fas fa-check-square number_chck"></i> <p class="number_chckbx_p">At least 1 Number</p>
                        </div>
                    </div>
                </fieldset>                   
            </div>
        </div>`;
        if($(this).is(':checked')) {
            $('hr').after(passwordFormHtml);
        } else {
            $('.password-div').remove();
        }
    });

    function get_data(query)
    {
      var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "list",
            select : "u.id, u.username, u.email, u.name, u.status, r.name as role_name, u.created_date, u.updated_date",
            query : query,
            offset : offset,
            limit : limit,
            table : "cms_users u",
            order : {
                field : "u.created_date", //field to order
                order : "asc" //asc or desc
            },
            join : [ //optional
                {
                    table : "cms_user_roles r", //table
                    query : "r.id = u.role", //join query
                    type : "left" //type of join
                }
            ]

        }

        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            var html = '';

            if(result) {
                if (result.length > 0) {
                    $.each(result, function(x,y) {
                        var status = (parseInt(y.status) === 1) ? status = "Active" : status = "Inactive";
            
                        html+="<tr>";
                        html+="<td class='center-content'><input class = 'select'  data-id = '"+y.id+"' data-name='"+y.name+"' data-logs='"+y.user_block_logs+"' type ='checkbox'></td>";
                        html+="<td>"+y.name+"</td>";
                        html+="<td>"+y.username+"</td>";
                        html+="<td>"+y.email+"</a></p></td>";
                        html+="<td>"+y.role_name+"</a></p></td>";
                        html += "<td class='center-content'>"+(y.created_date ? ViewDateformat(y.created_date) : "N/A")+  "</td>";
                        html += "<td class='center-content'>"+(y.updated_date ? ViewDateformat(y.updated_date) : "N/A")+  "</td>";
                        html+="<td>"+status+"</a></td>";
                        html+="<td class='center-content'>";
                        html+="<a class='btn-sm btn save' onclick=\"edit_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Edit Details'><span class='glyphicon glyphicon-pencil'>Edit</span>";
                        if(y.id > 3){
                            html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Delete Details'><span class='glyphicon glyphicon-pencil'>Delete</span>";    
                        }
                        html+="<a class='btn-sm btn view' onclick=\"view_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Show Details'><span class='glyphicon glyphicon-pencil'>View</span>";
                        html+="</td>";
                        html+="</tr>";
                    });
                } else {
                    html = '<tr><td colspan=12 class="center-align-format">'+ no_records +'</td></tr>';
                }
            }
            $('.table_body').html(html);
        });
    }

    function get_pagination(query)
    {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
          event : "pagination",
            select : "u.id",
            query : query,
            offset : offset,
            limit : limit,
            table : "cms_users u",
            order : {
                field : "u.updated_date",
                order : "desc"
            },
            join : [ 
                {
                    table : "cms_user_roles r", 
                    query : "r.id = u.role", 
                    type : "left" 
                }
            ]

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
    })

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

    // $(document).on('click', '#saveBtn', function() {
    //     save_data();
    // });

    // $(document).on('click', '#updateBtn', function() {
    //     var id = $(this).attr('data-id');
    //     update_data(id);
    // });

    // $(document).on('click', '.delete_data', function() {
    //     var id = $(this).attr('id');
    //     delete_data(id); 
    //     // console.log('hello');
    // });

    // $(document).on('click', '.edit', function() {
    //     id = $(this).attr('id');
    //     get_data_by_id(id);
    // });

    // $(document).on('click', '.view', function() {
    //     id = $(this).attr('id');
    //     get_data_by_id_view(id);
    // });

    $(document).on('keydown', '#search_query', function(event) {
        $('.btn_status').hide();
        $(".selectall").prop("checked", false);
        if (event.key == 'Enter') {
            search_input = $('#search_query').val();
            offset = 1;
            new_query = query;
            new_query += ' AND u.name like \'%'+search_input+'%\' OR u.email like \'%'+search_input+'%\'';
            get_data(new_query);
            get_pagination(new_query);
        }
    });

    $(document).on('click', '#btn_add', function() {
        open_modal('Add New User', 'add', '');
    });

    function edit_data(id) {
        open_modal('Edit User', 'edit', id);
    }

    function view_data(id) {
        open_modal('View User', 'view', id);
    }

    function open_modal(msg, actions, id) {
        $(".form-control").css('border-color','#ccc');
        $(".validate_error_message").remove();
        let $modal = $('#user_modal');
        let $footer = $modal.find('.modal-footer');
        var email_address = $('#email').val();
        $modal.find('.modal-title b').html(addNbsp(msg));
        reset_modal_fields();

        let buttons = {
            save: create_button('Save', 'save_data', 'btn save', function () {
                
                if (validate.standard("form-modal")) {
                    if(validate.email_address($('#email').val())){
                        save_data('save', null);
                    }else{
                        $(".form-control").css('border-color','#ccc');
                        $(".validate_error_message").remove();
                        var error_message = "<span class='validate_error_message' style='color: red;'>Invalid Email Address!<br></span>"
                        $('#email').css('border-color','red');
                        $(error_message).insertAfter($('#email'));
                    }
                 }
            }),
            edit: create_button('Update', 'edit_data', 'btn update', function () {
                if (validate.standard("form-modal")) {
                    if(validate.email_address($('#email').val())){
                        save_data('update', id);
                    }else{
                        $(".form-control").css('border-color','#ccc');
                        $(".validate_error_message").remove();
                        var error_message = "<span class='validate_error_message' style='color: red;'>Invalid Email Address!<br></span>"
                        $('#email').css('border-color','red');
                        $(error_message).insertAfter($('#email'));
                    }
                 }

            }),
            close: create_button('Close', 'close_data', 'btn caution', function () {
                $modal.modal('hide');
            })
        };

        if (['edit', 'view'].includes(actions)) populate_modal(id);
        
        let isReadOnly = actions === 'view';
        set_field_state('#name, #username, #email, #user_role, #status', isReadOnly);

        $footer.empty();
        if (actions === 'add') $footer.append(buttons.save);
        if (actions === 'edit') $footer.append(buttons.edit);
        $footer.append(buttons.close);
        if (actions === 'edit'){
            $('.display-none').show();
            $('.password-div').remove();
            $('#update_pass').prop('checked', false)
        }else if(actions === 'add'){
            $('.password-div').remove();
            $('.display-none').hide();
            var passwordFormHtml = `
            <div class="panel-body password-div"> 
                <div accept-charset="UTF-8" role="form" class="form-signin">
                    <fieldset>
                        <div class="callout" hidden style="margin-bottom: 0px !important;"></div>
                        <div class="form-group">
                            <label>New Password</label>
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                            <input id="password1" name="password1" type="password" class="txtlog form-control required new-password" placeholder="New Password" autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                            <input id="password2" name="password2" type="password" class="txtlog form-control required re-password" placeholder="Confirm Password"/>
                        </div>
                        <div class="re-pw-err"></div>
                        <div id="password_chcklist">
                            <p>Password Must:</p>
                            <div class="password_chcklist_contanier">
                                <i class="fas fa-check-square min_ten_chck" ></i> <p class="min_ten_chckbx_p"> Minimum of 10 characters</p>
                            </div>
                            <div class="password_chcklist_contanier">
                                <i class="fas fa-check-square special_chck"></i> <p class="special_chckbx_p">At least 1 Special Character</p>
                            </div>
                            <div class="password_chcklist_contanier">
                                <i class="fas fa-check-square upper_chck"></i> <p class="upper_chckbx_p">At least 1 Uppercase</p>
                            </div>
                            <div class="password_chcklist_contanier">
                                <i class="fas fa-check-square number_chck"></i> <p class="number_chckbx_p">At least 1 Number</p>
                            </div>
                        </div>
                    </fieldset>                   
                </div>
            </div>`;
            $('hr').after(passwordFormHtml);
        }else{
            $('.display-none').hide();
            $('.password-div').remove();
        }
        $modal.modal('show');
    }

    function reset_modal_fields() {
        $('#name, #username, #email, #user_role').val('');
        $('#user_modal #status, #user_modal #dashboard_access').prop('checked', true);
    }

    function populate_modal(inp_id) {

        var query = "status >= 0 and id = " + inp_id;
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, username, email, name, status, role",
            query : query, 
            table : "cms_users"
        }
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(index,d) {
                    $('#id').val(d.id);
                    $('#name').val(d.name);
                    $('#username').val(d.username);
                    $('#email').val(d.email);
                    $('#user_role').val(d.role);
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
            click: onclick_event
        });
        return new_btn;
    }

    function set_field_state(selector, isReadOnly) {
        $(selector).prop({ readonly: isReadOnly, disabled: isReadOnly });
    }

    function save_data(action, id) {
         var counter = 0;
        var chk_update_password = $('#update_pass').prop('checked');
        if (chk_update_password) {
            update_password_val = 1;
        } else {
            update_password_val = 0;
        }
        $('.validate_error_message').remove();
        $('.required').css('border-color', '#eee');
        validatePassword(action, update_password_val, id);
    }

    function validatePassword(action, update_password_val, id) {
        if (action !== "update" && action !== "save") return;

        var counter = 0;
        if (action === "update" && update_password_val !== 1) {
            setTimeout(() => validate_save(id), 1000); 
            return; 
        }

        var re_password = $('#password1').val().trim();
        var new_password = $('#password2').val().trim();

        var messages = {
            required: "<span class='validate_error_message' style='color: red;'>" + form_empty_error + "<br></span>",
            password_mismatch: "<span class='validate_error_message' style='color: red;'>New password does not match Confirm password.<br></span>",
            password_used: "<span class='validate_error_message' style='color: red;'>You have already used this password. Try a new one.<br></span>"
        };

        function showError(selector, message) {
            $(selector).html(message);
            $(selector.replace('-err', '')).css('border-color', 'red');
            counter++;
        }

        /* New Password */
        if (new_password === '') {
            showError('.new-pw-err', messages.required);
        } else if (is_exists_historical(user_id, new_password) == 1) {
            showError('.new-pw-err', messages.password_used);
        }

        /* Confirm Password */
        if (re_password === '') {
            showError('.re-pw-err', messages.required);
        } else if (re_password !== new_password) {
            showError('.re-pw-err', messages.password_mismatch);
            $('.new-password').css('border-color', 'red');
        }

        /* Checkbox validation */
        $('.password_checkbox').each(function () {
            var id = $(this).attr("id");
            var label = $("." + id);
            if (!$(this).is(':checked')) {
                counter++;
                label.css('color', 'red');
            } else {
                label.css('color', '#333');
            }
        });

        // ✅ Always call `validate_save(id)` if password validation passes OR password update is not required
        if (counter === 0) {
            setTimeout(() => validate_save(id), 1000);
        }
    }


    function validate_save(id){
     
        var chk_status = $('#status').prop('checked');
        var chk_dashboard_access = $('#dashboard_access').prop('checked');
        if (chk_status) {
            status_val = 1;
        } else {
            status_val = 0;
        }
        if (chk_dashboard_access) {
            dashboard_access_val = 1;
        } else {
            dashboard_access_val = 0;
        }

        var username = $('#username').val();
        var email_address = $('#email').val();
        if (id !== undefined && id !== null && id !== '') {
            check_current_db("cms_users", ["username", "email"], [username, email_address], "status" , "id", id, true, function(exists, duplicateFields) {
                if (!exists) {
                    modal.confirm(confirm_update_message,function(result){
                        if(result){ 
                             modal.loading(true);
                            save_to_db(status_val, dashboard_access_val, id)
                        }
                    });

                }             
            });
        }else{
            check_current_db("cms_users", ["username", "email"], [username, email_address], "status" , null, null, true, function(exists, duplicateFields) {
                if (!exists) {
                    modal.confirm(confirm_add_message,function(result){
                        if(result){ 
                             modal.loading(true);
                            save_to_db(status_val, dashboard_access_val, null)
                        }
                    });

                }                  
            });
        }

    }

    function save_to_db(status_val, dashboard_access_val, id) {

            let data = {}; 
            let modal_alert_success;

            if (id !== undefined && id !== null && id !== '') {
                modal_alert_success = success_update_message;
                var url = "<?= base_url('cms/users/update_user');?>";
                var chk_update_password = $('#update_pass').prop('checked');
                if (chk_update_password) {
                    data = {
                        table : "cms_users",
                        user_id: id,
                        data : {
                                name : $('#user_modal #name').val(),
                                username : $('#user_modal #username').val(),
                                email : $('#user_modal #email').val(),
                                role : $('#user_modal #user_role').val(),
                                dashboard_access : dashboard_access_val,
                                status : status_val,
                                password1 : $('#password1').val(),
                                password2 : $('#password2').val(),
                                updated_date : formatDate(new Date()),
                                updated_by : user_id,
                                update_password: chk_update_password
                        }  
                    }
                } else {
                    data = {
                        table : "cms_users",
                        user_id: id,
                        data : {
                                name : $('#user_modal #name').val(),
                                username : $('#user_modal #username').val(),
                                email : $('#user_modal #email').val(),
                                role : $('#user_modal #user_role').val(),
                                dashboard_access : dashboard_access_val,
                                status : status_val,
                                password1 : $('#password1').val(),
                                password2 : $('#password2').val(),
                                updated_date : formatDate(new Date()),
                                updated_by : user_id,
                                update_password: chk_update_password
                        }  
                    }
                }

            }else{
                
                var url = "<?= base_url('cms/users/save_user');?>";
                modal_alert_success = success_save_message;
                data = {
                    table : "cms_users",
                    data : {
                            name : $('#user_modal #name').val(),
                            username : $('#user_modal #username').val(),
                            email : $('#user_modal #email').val(),
                            role : $('#user_modal #user_role').val(),
                            dashboard_access : dashboard_access_val,
                            status : status_val,
                            password1 : $('#password1').val(),
                            password2 : $('#password2').val(),
                            created_date : formatDate(new Date()),
                            created_by : user_id
                    }  
                }
            }
            aJax.post(url,data,function(result){
                var obj = is_json(result);
                modal.loading(false);
                modal.alert(modal_alert_success, "success", function() {
                    location.reload();
                });
            });
    }

    function get_data_by_id(id){
        var query = "id = " + id;
        var exists = 0;

        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, username, email, name, status, role, updated_date",
            query : query, 
            table : "cms_users"
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(x,y) {
                    $('#update_user_modal #username').val(y.username);
                    $('#update_user_modal #email').val(y.email);
                    $('#update_user_modal #name').val(y.name);
                    $('#update_user_modal #user_role').val(y.role);
                    
                    if(y.status == 1){
                        $('#update_user_modal #status').prop('checked', true);
                    }else{
                        $('#update_user_modal #status').prop('checked', false);
                    }

                }); 
            }
            
            $('#updateBtn').attr('data-id', id);
            $('#update_user_modal').modal('show');
        });
        return exists;
    }

    function delete_data(id){
        
        modal.confirm(confirm_delete_message,function(result){
            if(result){ 
                var url = "<?= base_url('cms/global_controller');?>";
                var data = {
                    event : "update", 
                    table : "cms_users",
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
                    modal.alert(success_delete_message, "success", function() {
                        location.reload();
                    });
                });
            }

        });
    }

    function get_data_by_id_view(id){
        var query = "id = " + id;
        var exists = 0;

        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, username, email, name, status, role, updated_date",
            query : query, 
            table : "cms_users"
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(x,y) {
                    $('#view_user_modal #username').val(y.username);
                    $('#view_user_modal #email').val(y.email);
                    $('#view_user_modal #name').val(y.name);
                    $('#view_user_modal #user_role').val(y.role);
                    
                    if(y.status == 1){
                        $('#view_user_modal #status').prop('checked', true);
                    }else{
                        $('#view_user_modal #status').prop('checked', false);
                    }

                }); 
            }
            
            // $('#updateBtn').attr('data-id', id);
            $('#view_user_modal').modal('show');
        });
        return exists;
    }

    function get_data_user_roles(){
        var query = "status > 0";

        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, name, status, updated_date",
            query : query, 
            table : "cms_user_roles"
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if (obj) {
                var roles = obj;
                $('.user_role').empty().append(
                    $('<option></option>').val('').html('Please Select') // Add default option
                );
                $.each(roles, function(val, text) {
                    $('.user_role').append(
                        $('<option></option>').val(text.id).html(text.name)
                    );
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


    //password js

    $(document).on("keypress", "#password1, #password2", function(e) {                          
        if (e.keyCode == 13) {
            $("#reset_password").click();
        }
    });

    function is_exists_historical(user_id, password){
        var query = "user_id = " + user_id + " and password = '"+ password +"'";
        var exists = 0;

        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, user_id, password",
            query : query, 
            table : "cms_historical_passwords",
            id: user_id,
            password: password,
            isChangePassword : "true",
            <?= csrf_token() ?>:"<?= csrf_hash() ?>"
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj.length != 0){
                exists = 1;
            }
            else{
                exists = 0;
            }
        });
        return exists;
    }


    $(document).on("change keydown paste input", "#password1", function(event) {
        var password_input = $(this).val();
        var min_ten_Regex = new RegExp("^(?=.{10,})");
        var special_char_Regex =  new RegExp("^(?=.*[!@#\$%\^&])");
        var upper_char_Regex = new RegExp("^(?=.*?[A-Z])");
        var number_Regex = new RegExp("^(?=.*[0-9])");

        if(min_ten_Regex.test(password_input)){
        $('.min_ten_chck').addClass('password_checker');
        $('.min_ten_chckbx').prop('checked', true);
        }else{
        $('.min_ten_chckbx').prop('checked', false);
        $('.min_ten_chck').removeClass('password_checker');
        }

        if (special_char_Regex.test(password_input)){
        $('.special_chck').addClass('password_checker');
        $('.special_chckbx').prop('checked', true);
        }else{
        $('.special_chckbx').prop('checked', false);
        $('.special_chck').removeClass('password_checker');
        }

        if(upper_char_Regex.test(password_input)){
        $('.upper_chck').addClass('password_checker');
        $('.upper_chckbx').prop('checked', true);
        }else{
        $('.upper_chckbx').prop('checked', false);
        $('.upper_chck').removeClass('password_checker');
        }

        if (number_Regex.test(password_input)){
        $('.number_chck').addClass('password_checker');
        $('.number_chckbx').prop('checked', true);
        }else{
        $('.number_chckbx').prop('checked', false);
        $('.number_chck').removeClass('password_checker');
        }
    });

    $('#user_modal').on('show.bs.modal', function () {
        $(this).removeAttr('aria-hidden'); // Remove aria-hidden when modal opens
    });

    $('#user_modal').on('hidden.bs.modal', function () {
        $(this).attr('aria-hidden', 'true'); // Restore aria-hidden when modal closes
    });

    //dito

    $(document).on('click', '.btn_status', function (e) {
        var status = $(this).attr("data-status");
        var modal_obj = "";
        var modal_alert_success = "";
        var hasExecuted = false; // Prevents multiple executions

        if (parseInt(status) === -2) {
            modal_obj = confirm_delete_message;
            modal_alert_success = success_delete_message;
            offset = 1;
        } else if (parseInt(status) === 1) {
            modal_obj = confirm_publish_message;
            modal_alert_success = success_publish_message;
        } else if (parseInt(status) === 0) {
            modal_obj = confirm_unpublish_message;
            modal_alert_success = success_unpublish_message;
        }else{
            modal_obj = confirm_unblock_message;
            modal_alert_success = success_unblock_message;           
        }
        modal.confirm(modal_obj, function (result) {
            if (result) {
                var url = "<?= base_url('cms/global_controller');?>";
                var dataList = [];

                if (parseInt(status) === 3) {
                    $('.selectall').prop('checked', false);
                    let hasAlertExecuted = false;

                    $('.select:checked').each(function () {

                        var id = $(this).attr('data-id');
                        var data = {
                            event: "update",
                            table: "cms_users",
                            field: "id",
                            where: id,
                            data: {
                                updated_date: formatDate(new Date()),
                                updated_by: user_id,
                                user_error_logs: 0,
                                user_block_logs: 0,
                                user_lock_time: ''
                            }
                        };

                        aJax.post(url, data, function (result) {
                            var obj = is_json(result);
                            if (!hasAlertExecuted) {
                                hasAlertExecuted = true;
                                modal.alert(success_update_message, "success", function (cb) {
                                    if (cb) {
                                        location.reload();
                                    }
                                });
                            }
                        });
                    });
                } else {
                    $('.select:checked').each(function () {
                        var id = $(this).attr('data-id');
                        dataList.push({
                            event: "update",
                            table: "cms_users",
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
                            if (hasExecuted) return;

                            modal.loading(false);
                            processed++;

                            if (result === "success") {
                                if (!hasExecuted) {
                                    hasExecuted = true;
                                    $('.btn_status').hide();
                                    modal.alert(modal_alert_success, "success", function () {
                                        location.reload();
                                    });
                                }
                            } else {
                                if (!hasExecuted) {
                                    hasExecuted = true;
                                    modal.alert(failed_transaction_message, "error", function () {});
                                }
                            }
                        });
                    });
                }
            }

        });
    });
</script>