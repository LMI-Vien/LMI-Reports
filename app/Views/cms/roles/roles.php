<style>
/*for menu roles*/

th:first-child{
    width:20px;   
}

th:last-child{
    width: 30px;
}

td:last-child{
    text-align: center;
}

.ta_c
{
    text-align: center;
}

.module_content{
    overflow: auto;
    height: auto;
}
.menu_header_ul {
    padding: 0;
    display: block;
    vertical-align: middle;
    margin: 0;
    display: grid;
    grid-template-columns: 36fr repeat(4, 16fr);
}
.menu_header_ul li{
    display: inline-block;
    text-align: left;
}

.menu_header_ul li:first-child {
    text-align: left;
}

.menu_header_li span {
    padding-left: 10px;
}

.module_header_container {
/*    position: absolute;*/
    width: 100%;
    padding: 9px 0px;
    overflow: hidden;
    background: #301311;
    color: #fff;
    font-weight: 600;
    font-size: 15px;
    z-index: 1;
}
.module_body_container {
/*    padding-top: 40px;*/
    width: 100%;
    position: relative;
}

.module_col {
    position: relative;
    width: 100%;
    overflow: hidden;
}
ul.parent_menu {
    padding: 0;
    display: block;
    vertical-align: middle;
    margin: 0;
    font-size: 16px;
}

ul.child_menu {
    padding: 0;
    display: block;
    vertical-align: middle;
    margin: 0;
}


.menu_title {
    display: inline-block;
    width: 36%;
    background: rgba(44, 59, 65, 0.15);
    color: #000;
    font-weight: 500;
    font-size : 17px;
}

.menu_title span {
    padding-left: 10px;
}

.menu_chkbx {
    display: inline-block;
    width: 16%;
    background: rgba(44, 59, 65, 0.15);
    font-size: 17px;
}

.sub_menu_title {
    display: inline-block;
    width: 36%;
}

.sub_menu_title span {
    padding-left: 20px;
}

.sub_menu_chkbx {
    display: inline-block;
    width: 16%;
}

</style>
    <div class="content-wrapper p-4">
        <div class="card">
            <div class="text-center page-title md-center">
                <b> R O L E S </b>
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
<div class="modal fade" id="user_role_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                <form id="form-modal">
                    <div class="form-group">
                        <div hidden>
                            <input type="text" class="form-control" id="id" aria-describedby="id">
                        </div>
                        <label>User Role</label>
                        <input type="text" class="form-control required" id="name">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input large-checkbox required" id="status">
                        <label class="form-check-label large-label" for="status">Active</label>
                    </div>
                </form>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="module_col">
                            <div class="module_content">
                                    <div class= "module_header_container">
                                            <ul class= "menu_header_ul">
                                                <li class="menu_header_li"><span>CMS Modules</span></li>
                                                 <li class="menu_header_li"><input class="select_all_read" type = "checkbox"><span> Read</span></li>
                                                <li class="menu_header_li"><input class="select_all_write" type = "checkbox"><span> Write</span></li>
                                                <li class="menu_header_li"><input class="select_all_delete" type = "checkbox"><span> Delete</span></li>
                                                <li class="menu_header_li"><input class="select_all_approve not_in_use" type = "checkbox" disabled><span> Approve</span></li>
                                            </ul>
                                      </div> 
                                    <div class="module_body_container">
                                  </div>
                            </div>
         
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="module_col">
                            <div class="module_content">
                                    <div class= "module_header_container">
                                            <ul class= "menu_header_ul">
                                                <li class="menu_header_li"><span>Site Menu</span></li>
                                                <li class="menu_header_li"><input class="select_all_view" type = "checkbox"><span> View</span></li>
                                                <li class="menu_header_li"><input class="select_all_generate" type = "checkbox"><span> Generate</span></li>
                                                <li class="menu_header_li"><input class="select_all_export" type = "checkbox"><span> Export</span></li>
                                                <li class="menu_header_li"><input class="select_all_filter" type = "checkbox"><span> Filter</span></li>
                                            </ul>
                                      </div> 
                                    <div class="menu_body_container">
                                  </div>
                            </div>
         
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
               <!--  <button id="save_btn" class="btn save">Save</button>
                <button id="close_data" class="btn caution" data-dismiss="modal">Close</button> -->
            </div>
        </div>
    </div>
</div>

<script>
    var query = "status >= 0";
    var limit = 10;
    var counter_sitemenu = 0;
    var counter_cmsmenu = 0;
    var counter = 0;
    var user_id = '<?=$session->sess_uid;?>';
    var role = parseInt("<?=$session->sess_role;?>");
    var roles_menu_id = 0;
    $(document).ready(function() {
      get_data(query);
      get_pagination(query);
    });

    function get_data(query)
    {
      var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "list",
            select : "id, name, status, created_date, updated_date",
            query : query,
            offset : offset,
            limit : limit,
            table : "cms_user_roles",
            order : {
                field : "created_date",
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

                        html += "<tr>";
                        html += "<td class='center-content'><input class='select' type=checkbox data-id="+y.id+" onchange=checkbox_check()></td>";
                        html += "<td>" + y.name + "</td>";
                        html += "<td class='center-content'>"+(y.created_date ? ViewDateformat(y.created_date) : "N/A")+  "</td>";
                        html += "<td class='center-content'>"+(y.updated_date ? ViewDateformat(y.updated_date) : "N/A")+  "</td>";
                        html += "<td>" +status+ "</td>";

                        // if (y.id <= 2) {
                        //     html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        // } else {
                            html+="<td class='center-content'>";
                            html += "<a class='btn-sm btn save' onclick=\"edit_data("
                                + y.id + ", '"
                                + y.name.replace(/'/g, "\\'").replace(/"/g, "&quot;") + "'"
                                + ", "+ y.status + ")\" data-status='"
                                + y.status + "' id='"
                                + y.id + "' title='Edit Details'><span class='glyphicon glyphicon-pencil'>Edit</span></a>";
                            if (y.id > 4 && y.id != 7 && y.id != 8) {
                                html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Delete Details'><span class='glyphicon glyphicon-pencil'>Delete</span>"; 
                            }    
                            
                            html+="<a class='btn-sm btn view' onclick=\"view_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Show Details'><span class='glyphicon glyphicon-pencil'>View</span>";
                            html+="</td>";
                        // }
                        
                        html += "</tr>";   
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
            select : "id",
            query : query,
            offset : offset,
            limit : limit,
            table : "cms_user_roles",
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

    $("#btn_export").on("click", function (e) {
      alert("call ajax to controler");
    });

    $(document).on('click', '#btn_add', function () {
        open_modal('Add New Role', 'add', '');
    });

    $(document).on('click', '.edit', function() {
        id = $(this).attr('id');
        get_data_by_id(id);
    });

    $(document).on('click', '.delete_data', function() {
        var id = $(this).attr('id');
        delete_data(id); 
    });

    function create_button(btn_txt, btn_id, btn_class, onclick_event) {
        var new_btn = $('<button>', {
            text: btn_txt,
            id: btn_id,
            class: btn_class,
            click: onclick_event
        });
        return new_btn;
    }

    function reset_modal_fields() {
        $('#user_role_modal #name').val('');
        $('#user_role_modal #status').prop('checked', true);
        $('.chckbx_menu').prop('checked', false);
        $('.chckbx_menu_site').prop('checked', false);
        $('.select_all_read, .select_all_write, .select_all_delete, .select_all_approve, .select_all_view, .select_all_generate, .select_all_export, .select_all_filter').prop('checked', false);
    }

    function save_data(action, id) {
        var chk_status = $('#user_role_modal #status').prop('checked');
        if (chk_status) {
            status_val = 1;
        } else {
            status_val = 0;
        }
        var url = "<?= base_url('cms/global_controller');?>";
        var cms_menu_data = [];
        var site_menu_data = [];
        var current_date = formatDate(new Date());


    $.each($('.menu_id_cms'), function(x, y) {
        var menuId = $(this).attr('data-id'); // Get the menu ID

        var data_array_cms_menu = {
            menu_id: menuId,
            menu_role_read: $('.read_cms[data-id="' + menuId + '"]').prop('checked') ? 1 : 0,
            menu_role_write: $('.write_cms[data-id="' + menuId + '"]').prop('checked') ? 1 : 0,
            menu_role_delete: $('.delete_cms[data-id="' + menuId + '"]').prop('checked') ? 1 : 0,
            menu_role_approve: $('.approve_cms[data-id="' + menuId + '"]').prop('checked') ? 1 : 0,
            menu_role_updated_date: current_date,
            menu_role_created_date: current_date
        };

        cms_menu_data.push(data_array_cms_menu);
    });

    $.each($('.menu_id_site'), function(x, y) {
        var menuId = $(this).attr('data-id'); // Get the menu ID

        var data_array_site_menu = {
            menu_id: menuId,
            menu_role_view: $('.view_site[data-id="' + menuId + '"]').prop('checked') ? 1 : 0,
            menu_role_generate: $('.generate_site[data-id="' + menuId + '"]').prop('checked') ? 1 : 0,
            menu_role_export: $('.export_site[data-id="' + menuId + '"]').prop('checked') ? 1 : 0,
            menu_role_filter: $('.filter_site[data-id="' + menuId + '"]').prop('checked') ? 1 : 0,
            menu_role_updated_date: current_date,
            menu_role_created_date: current_date
        };

        site_menu_data.push(data_array_site_menu);
    });
        
        var user_role_data = {
            name : $('#name').val(),
            status : status_val,
            created_date :  current_date,
            created_by  : user_id
        };
        
        var data = {
            cms_menu_role_data : cms_menu_data,
            site_menu_role_data : site_menu_data,
            user_role_data : user_role_data
        }
        if(action == "save"){
                check_current_db("cms_user_roles", ["name"], [$('#name').val()], "status" , "id", id, true, function(exists, duplicateFields) {
                    if (!exists) {
                        modal.confirm(confirm_add_message,function(result){
                            if(result){ 
                                aJax.post("<?= base_url('cms/roles/menu-insert');?>",data,function(result){
                                   
                                    modal.loading(false);
                                    modal.alert(success_save_message, "success", function(){
                                        location.href = '<?=base_url("cms/roles") ?>';
                                    }); 
                                });
                            }
                        });

                    }             
                });
        }else{
            check_current_db("cms_user_roles", ["name"], [$('#name').val()], "status" , "id", id, true, function(exists, duplicateFields) {
                if (!exists) {
                        var chk_status = $('#user_role_modal #status').prop('checked');
                        if (chk_status) {
                            status_val = 1;
                        } else {
                            status_val = 0;
                        }
                        modal.confirm(confirm_update_message,function(result){
                            if(result){ 
                                modal.loading(true);
                                var customURL = "<?= base_url('cms/roles/delete-role-tagging');?>"; 
                                var data = {
                                    role_id : id
                                }
                                aJax.post(customURL,data,function(result){});
                                var url = "<?= base_url('cms/global_controller');?>";
                                var data = {
                                    event : "update",
                                    table : "cms_user_roles",
                                    field : "id",
                                    where : id,
                                    data : {

                                            name : $('#name').val(),
                                            status : status_val,
                                            updated_date :  formatDate(new Date()),
                                            updated_by : user_id
                                    }  
                                }

                                aJax.post(url,data,function(result){ 
                                    var obj = is_json(result);         
                                    save_role_module(roles_menu_id);
                                });    
                            }
                        });
                    }   

            });        
        }

    }

    function save_role_module(role_id){
        var current_date = formatDate(new Date());
        var cms_menu_data = [];
        var site_menu_data = [];
       
        $.each($('.menu_id_cms'), function(x, y) {
            var menuId = $(this).attr('data-id'); // Get the menu ID

            var data_array_cms_menu = {
                menu_id: menuId,
                menu_role_read: $('.read_cms[data-id="' + menuId + '"]').prop('checked') ? 1 : 0,
                menu_role_write: $('.write_cms[data-id="' + menuId + '"]').prop('checked') ? 1 : 0,
                menu_role_delete: $('.delete_cms[data-id="' + menuId + '"]').prop('checked') ? 1 : 0,
                menu_role_approve: $('.approve_cms[data-id="' + menuId + '"]').prop('checked') ? 1 : 0,
                menu_role_updated_date: current_date,
                menu_role_created_date: current_date
            };

            cms_menu_data.push(data_array_cms_menu);
        });

        $.each($('.menu_id_site'), function(x, y) {
            var menuId = $(this).attr('data-id');
            var data_array_site_menu = {
                menu_id: menuId,
                menu_role_view: $('.view_site[data-id="' + menuId + '"]').prop('checked') ? 1 : 0,
                menu_role_generate: $('.generate_site[data-id="' + menuId + '"]').prop('checked') ? 1 : 0,
                menu_role_export: $('.export_site[data-id="' + menuId + '"]').prop('checked') ? 1 : 0,
                menu_role_filter: $('.filter_site[data-id="' + menuId + '"]').prop('checked') ? 1 : 0,
                menu_role_updated_date: current_date,
                menu_role_created_date: current_date
            };

           site_menu_data.push(data_array_site_menu);
        });

        var data = {
            cms_menu_role_data : cms_menu_data,
            site_menu_role_data : site_menu_data,
            user_role_data : role_id
        }
        // return;
        aJax.post("<?= base_url('cms/roles/menu-update');?>",data,function(result){
            modal.loading(false);
            modal.alert(success_update_message, "success", function(){
                location.reload();
            }); 
        });
    }

    function get_data_by_id_view(id){
        var query = "id = " + id;
        var exists = 0;

        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, name, status, updated_date",
            query : query, 
            table : "cms_user_roles"
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(x,y) {
                    $('#view_user_role_modal #name').val(y.name);
                    
                    if(y.status == 1){
                        $('#view_user_role_modal #status').prop('checked', true);
                    }else{
                        $('#view_user_role_modal #status').prop('checked', false);
                    }

                }); 
            }
            
            $('#view_user_role_modal').modal('show');
        });
        return exists;
    }

    function get_data_by_id(id){
        var query = "id = " + id;
        var exists = 0;

        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, name, status, updated_date",
            query : query, 
            table : "cms_user_roles"
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(x,y) {
                    $('#update_user_role_modal #name').val(y.name);
                    
                    if(y.status == 1){
                        $('#update_user_role_modal #status').prop('checked', true);
                    }else{
                        $('#update_user_role_modal #status').prop('checked', false);
                    }

                }); 
            }
            
            $('#updateBtn').attr('data-id', id);
            $('#update_user_role_modal').modal('show');
        });
        return exists;
    }

    function delete_data(id){
        
        modal.confirm(confirm_delete_message,function(result){
            if(result){
                modal.loading(true);
                var customURL = "<?= base_url('cms/roles/delete-role-tagging');?>"; 
                var data = {
                    role_id : id
                }
                aJax.post(customURL,data,function(result){});
                var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
                var data = {
                    event : "update", // list, insert, update, delete
                    table : "cms_user_roles", //table
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
                        modal.loading(false);
                        location.reload();
                    });
                });
            }

        });
    }

    function get_data_modules(query, action){
        var exists = 0;
        var url = "<?= base_url('cms/global_controller');?>";
        var select = "";
        var join = [];
        if(action == "add"){
            select = "`cms_menu`.`id` as `menu_id`,`menu_name`,`menu_type`,`menu_parent_id`,`menu_level`,`status`,`sort_order`";
        }else{
            select = "`cms_menu`.`id` as `menu_id`,`menu_name`,`menu_type`,`menu_parent_id`,`menu_level`,`status`,`sort_order`,`role_id`,`cms_menu_roles`.`menu_id` as `roles_menu_id`,`menu_role_read`,`menu_role_write`,`menu_role_delete`, `menu_role_approve`";
            join.push({
                table: "cms_menu_roles", // Table name
                query: "cms_menu_roles.menu_id = cms_menu.id", // Join condition
                type: "left" // Type of join
            });
        }
        var data = {
             event: "list",
             select: select,
             table: "cms_menu",
             query: query,
             join : join,
             order: {
                field: "sort_order",
                order: "asc"
             }
        }

        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            var htm = '';
            var old_menu_id = 0;
            if(result.length > 0){  
                $.each(result,function(x,y){
                    if(y.menu_id){
                       old_menu_id = y.menu_id;
                       counter_cmsmenu = y.menu_id;
                   }else{
                       counter_cmsmenu = old_menu_id;
                   }
                    if(action == "add"){
                        var checked_read = "";
                        var checked_write = "";
                        var checked_delete = "";
                        var checked_approve = "";
                    }else{
                        var checked_read = ( y.menu_role_read == 1 ) ? checked_read = "checked" : checked_read = "";
                        var checked_write = ( y.menu_role_write == 1 ) ? checked_write = "checked" : checked_write = "";
                        var checked_delete = ( y.menu_role_delete == 1 ) ? checked_delete = "checked" : checked_delete = "";
                        var checked_approve = ( y.menu_role_approve == 1 ) ? checked_approve = "checked" : checked_approve = "";
                    }

                    htm += "<ul class='parent_menu'>";
                        if(parseInt(y.menu_level) === 1){
                          htm += "<li class='main_menu_cmsmenu_"+y.menu_id+"'>";
                          htm += "<div class='menu_title'><input type='hidden' class='menu_id_cms menu_id_"+counter_cmsmenu+"' data-id="+y.menu_id+"><span>"+y.menu_name+"</span></div>"; 
                          htm += "<div class='menu_chkbx'><input class='chckbx_menu read_cms read_"+counter_cmsmenu+" chckbx_menu_read parent_chckbox_read_"+y.menu_id+"' type = 'checkbox'  name='menu_role_read' data-id="+y.menu_id+" value='0' onchange='chckbox_parent_menu("+y.menu_id+")' "+checked_read+"></div>";
                          htm += "<div class='menu_chkbx'><input class='chckbx_menu write_cms write_"+counter_cmsmenu+" chckbx_menu_write parent_chckbox_write_"+y.menu_id+"' name='menu_role_write' type = 'checkbox' data-id="+y.menu_id+" value='0' onchange='chckbox_parent_menu("+y.menu_id+")' "+checked_write+"></div>";
                          htm += "<div class='menu_chkbx'><input class='chckbx_menu delete_cms delete_"+counter_cmsmenu+" chckbx_menu_delete parent_chckbox_delete_"+y.menu_id+"' name='menu_role_delete' type = 'checkbox' data-id="+y.menu_id+" value='0' onchange='chckbox_parent_menu("+y.menu_id+")' "+checked_delete+"></div>";
                          if(y.menu_name == "Tracc Data"){
                              htm += "<div class='menu_chkbx'><input class='chckbx_menu approve_cms approve_"+counter_cmsmenu+" chckbx_menu_approve parent_chckbox_approve_"+y.menu_id+"' name='menu_role_approve' type = 'checkbox' data-id="+y.menu_id+" value='0' onchange='chckbox_parent_menu("+y.menu_id+")' "+checked_approve+"></div>";                            
                          }else{
                              htm += "<div class='menu_chkbx'><input class='chckbx_menu approve_cms approve_"+counter_cmsmenu+" chckbx_menu_approve parent_chckbox_approve_"+y.menu_id+" not_in_use' name='menu_role_approve' type = 'checkbox'></div>"; 
                          }

                          htm += "</li>";
                              get_sub_menu(y.menu_id, "cms_menu", "cmsmenu", action, counter_cmsmenu);
                        }
                    htm += "</ul>";
                });



            } else {
                htm += '<ul>';
                htm += '<li class="ta_c;">No Results Found.</li>';
                htm += '</ul>';
            }
            
            $('.module_body_container').html(htm);      
            setTimeout(() => {
                $('.not_in_use').prop('disabled', true);
            }, 1000);
        });
    }

    function get_data_site_menu(query, action){
        //var query = "menu_level = 1 and status = 1";
        var exists = 0;

        var url = "<?= base_url('cms/global_controller');?>";
        var select = "";
        var join = [];
        if(action == "add"){
            select = "`site_menu`.`id` as `menu_id`,`menu_name`,`menu_type`,`menu_parent_id`,`menu_level`,`status`,`sort_order`";
        }else{
            select = "`site_menu`.`id` as `menu_id`,`menu_name`,`menu_type`,`menu_parent_id`,`menu_level`,`status`,`sort_order`,`role_id`,`cms_site_menu_roles`.`menu_id` as `roles_menu_id`,`menu_role_view`,`menu_role_generate`,`menu_role_export`,`menu_role_filter`";
            join.push({
                table: "cms_site_menu_roles",
                query: "cms_site_menu_roles.menu_id = site_menu.id",
                type: "left"
            });
        }
        var data = {
             event: "list",
             select: select,
             table: "site_menu",
             query: query,
             join : join,
             order: {
                field: "sort_order",
                order: "asc"
             }
        }

        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            var htm = '';
            var old_menu_id = 0;
            if(result.length > 0){  
                $.each(result,function(x,y){
                    if(y.menu_id){
                       old_menu_id = y.menu_id;
                       counter_sitemenu = y.menu_id;
                   }else{
                       counter_sitemenu = old_menu_id;
                   }
                    if(action == "add"){
                        var checked_view = "";
                        var checked_generate = "";
                        var checked_export = "";
                        var checked_filter = "";
                    }else{
                        var checked_view = ( y.menu_role_view == 1 ) ? checked_view = "checked" : checked_view = "";
                        var checked_generate = ( y.menu_role_generate == 1 ) ? checked_generate = "checked" : checked_generate = "";
                        var checked_export = ( y.menu_role_export == 1 ) ? checked_export = "checked" : checked_export = "";
                        var checked_filter = ( y.menu_role_filter == 1 ) ? checked_filter = "checked" : checked_filter = "";
                    }
                    htm += "<ul class='parent_menu'>";
                        if(parseInt(y.menu_level) === 1){
                          htm += "<li class='main_menu_sitemenu_"+y.menu_id+"'>";
                          htm += "<div class='menu_title'><input type='hidden' class='menu_id_site menu_id_"+counter_sitemenu+"' data-id="+y.menu_id+"><span>"+y.menu_name+"</span></div>"; 
                          htm += "<div class='menu_chkbx'><input class='chckbx_menu_site view_site view_"+counter+" chckbx_menu_view parent_chckbox_view_"+y.menu_id+"' type = 'checkbox'  name='menu_role_view' data-id="+y.menu_id+" value='0' onchange='chckbox_parent_menu_site("+y.menu_id+")' "+checked_view+"></div>";
                          htm += "<div class='menu_chkbx'><input class='chckbx_menu_site generate_site generate_"+counter_sitemenu+" chckbx_menu_generate parent_chckbox_generate_"+y.menu_id+"' name='menu_role_generate' type = 'checkbox' data-id="+y.menu_id+" value='0' onchange='chckbox_parent_menu_site("+y.menu_id+")' "+checked_generate+"></div>";
                          htm += "<div class='menu_chkbx'><input class='chckbx_menu_site export_site export_"+counter_sitemenu+" chckbx_menu_export parent_chckbox_export_"+y.menu_id+"' name='menu_role_export' type = 'checkbox' data-id="+y.menu_id+" value='0' onchange='chckbox_parent_menu_site("+y.menu_id+")' "+checked_export+"></div>";
                          htm += "<div class='menu_chkbx'><input class='chckbx_menu_site filter_site filter_"+counter_sitemenu+" chckbx_menu_filter parent_chckbox_filter_"+y.menu_id+"' name='menu_role_filter' type = 'checkbox' data-id="+y.menu_id+" value='0' onchange='chckbox_parent_menu_site("+y.menu_id+")' "+checked_filter+"></div>";
                          htm += "</li>";
                            get_sub_menu(y.menu_id, "site_menu", "sitemenu", action, counter_sitemenu);
                        }
                    htm += "</ul>";
                    counter++;
                });



            } else {
                htm += '<ul>';
                htm += '<li class="ta_c;">No Results Found.</li>';
                htm += '</ul>';
            }
            $('.menu_body_container').html(htm);
        });
    }

    function get_sub_menu(id, table, module_name, action, counter)
    {
        if(action == "add"){
            query = "menu_parent_id = "+id+" AND menu_level = 2 AND status = 1";
            
            var url = "<?= base_url('cms/global_controller');?>";
            var data = {
                event:"list",
                select:"id,menu_name,menu_type,menu_parent_id,menu_level,status,sort_order",
                table: table,
                query: query,
                group:"menu_name",
                sort_order:{
                    field: "sort_order",
                    sort_order: "asc"
                 }
            }

            aJax.post_async(url,data,function(result)
            {
                var obj = is_json(result);
                var htm = '';
                if(obj.length > 0)
                {
                     var one = "read";
                     var two = "write";
                     var three = "delete";
                     var four = "approve";
                     var chckbx_menu = "chckbx_menu";
                     var func = "chckbox_sub_menu";
                     var clsname = "menu_id_cms";
                     var clsname2 = "cms";

                     if(module_name == "sitemenu"){
                        one = "view";
                        two = "generate";
                        three = "export";
                        four = "filter";
                        chckbx_menu = "chckbx_menu_site";
                        func = "chckbox_sub_menu_site";
                        clsname = "menu_id_site";
                        clsname2 = "site";
                     }
                     counter = counter;
                     $.each(obj,function(a,b){
                          htm += "<ul class='child_menu'>";
                              if(parseInt(b.menu_level) === 2){
                                
                                  htm += "<li class='sub_menu_"+b.id+"'>";
                                  htm += "<div class='sub_menu_title'><input type='hidden' class='"+clsname+" menu_id_"+counter+"' data-id="+b.id+"><span>"+b.menu_name+"</span></div>";
                                  htm += "<div class='sub_menu_chkbx'><input class='"+chckbx_menu+" "+one+"_"+clsname2+" "+one+"_"+counter+" chckbx_menu_"+one+" sub_checker_"+one+"_"+id+" sub_chckbox_"+one+"_"+counter+"' name='menu_role_"+one+"' type = 'checkbox' data-id="+b.id+" value='0' onchange='"+func+"("+counter+","+id+")'></div>";
                                  htm += "<div class='sub_menu_chkbx'><input class='"+chckbx_menu+" "+two+"_"+clsname2+" "+two+"_"+counter+" chckbx_menu_"+two+" sub_checker_"+two+"_"+id+" sub_chckbox_"+two+"_"+counter+"' name='menu_role_"+two+"' type = 'checkbox' data-id="+b.id+" value='0' onchange='"+func+"("+counter+","+id+")'></div>";
                                  htm += "<div class='sub_menu_chkbx'><input class='"+chckbx_menu+" "+three+"_"+clsname2+" "+three+"_"+counter+" chckbx_menu_"+three+" sub_checker_"+three+"_"+id+" sub_chckbox_"+three+"_"+counter+"' name='menu_role_"+three+"' type = 'checkbox' data-id="+b.id+" value='0' onchange='"+func+"("+counter+","+id+")'></div>";
                                  if(b.menu_name == "Import Target Sales Per Store" || four == "filter"){
                                      htm += "<div class='sub_menu_chkbx'><input class='"+chckbx_menu+" "+four+"_"+clsname2+" "+four+"_"+counter+" chckbx_menu_"+four+" sub_checker_"+four+"_"+id+" sub_chckbox_"+four+"_"+counter+"' name='menu_role_"+four+"' type = 'checkbox' data-id="+b.id+" value='0' onchange='"+func+"("+counter+","+id+")'></div>";
                                  }else{
                                      htm += "<div class='sub_menu_chkbx'><input class='"+chckbx_menu+" not_in_use' name='' type = 'checkbox' data-id="+b.id+" value='0' onchange=''></div>";   
                                  }
                                  htm += "</li>";

                              }
                          htm += "</ul>";

                        counter++;
                         
                    });
                    setTimeout(() => { 
                        $(htm).insertAfter($('.main_menu_'+module_name+"_"+id));
                        modal.loading(false);
                    }, 500);  
                }
            });
        }else{
            roles_menu_id = roles_menu_id;
            if(role == 1){
              query = "role_id = "+roles_menu_id+" AND menu_parent_id = "+id+" AND menu_level = 2 AND status = 1";
            }else{
               query = "role_id = "+roles_menu_id+" AND menu_parent_id = "+id+" AND menu_level = 2 AND status = 1 AND menu_id != 14 AND menu_id != 15 AND menu_id != 22";
            } 

            var url = "<?= base_url('cms/global_controller');?>";
            var select = "";
            var join = [];

            if (table == "cms_menu") {
                select = "cms_menu.id as menu_id, menu_name, menu_type, menu_parent_id, menu_level, status, sort_order, role_id, cms_menu_roles.menu_id as roles_menu_id, menu_role_read, menu_role_write, menu_role_delete, menu_role_approve";
                join.push({
                    table: "cms_menu_roles", // Table name
                    query: "cms_menu_roles.menu_id = cms_menu.id", // Join condition
                    type: "left" // Type of join
                });
            } else {
                select = "site_menu.id as menu_id, menu_name, menu_type, menu_parent_id, menu_level, status, sort_order, role_id, cms_site_menu_roles.menu_id as roles_menu_id, menu_role_view, menu_role_generate, menu_role_export, menu_role_filter";
                join.push({
                    table: "cms_site_menu_roles", // Table name
                    query: "cms_site_menu_roles.menu_id = site_menu.id", // Fixed join condition
                    type: "left" // Type of join
                });
            }
            var data = {
                event:"list",
                select:select,
                table: table,
                query: query,
                join : join,
                sort_order:{
                    field: "sort_order",
                    sort_order: "asc"
                 }

            }

            aJax.post_async(url,data,function(result)
            {

                var obj = is_json(result);
                var htm = '';

                if(obj.length > 0)
                {
                     var one = "read";
                     var two = "write";
                     var three = "delete";
                     var four = "approve";
                     var chckbx_menu = "chckbx_menu";
                     var func = "chckbox_sub_menu";
                     var clsname = "menu_id_cms";
                     var clsname2 = "cms";
                     //counter = counter_cmsmenu;
                     if(module_name == "sitemenu"){
                        one = "view";
                        two = "generate";
                        three = "export";
                        four = "filter";
                    //    counter = counter_sitemenu;
                        chckbx_menu = "chckbx_menu_site";
                        func = "chckbox_sub_menu_site";
                        clsname = "menu_id_site";
                        clsname2 = "site";
                     }
                     counter = counter;
                     $.each(obj,function(a,b){
                          var checked_read = ( b.menu_role_read == 1 ) ? checked_read = "checked" : checked_read = "";
                          var checked_write = ( b.menu_role_write == 1 ) ? checked_write = "checked" : checked_write = "";
                          var checked_delete = ( b.menu_role_delete == 1 ) ? checked_delete = "checked" : checked_delete = "";
                          var checked_approve = ( b.menu_role_approve == 1 ) ? checked_approve = "checked" : checked_approve = "";

                          var checked_view = ( b.menu_role_view == 1 ) ? checked_view = "checked" : checked_view = "";
                          var checked_generate = ( b.menu_role_generate == 1 ) ? checked_generate = "checked" : checked_generate = "";
                          var checked_export = ( b.menu_role_export == 1 ) ? checked_export = "checked" : checked_export = "";
                          var checked_filter = ( b.menu_role_filter == 1 ) ? checked_filter = "checked" : checked_filter = "";
                          htm += "<ul class='child_menu'>";
                              if(parseInt(b.menu_level) === 2){
                                
                                  htm += "<li class='sub_menu_"+b.menu_id+"'>";
                                  htm += "<div class='sub_menu_title'><input type='hidden' class='"+clsname+" menu_id_"+counter+"' data-id="+b.menu_id+"><span>"+b.menu_name+"</span></div>";
                                  htm += "<div class='sub_menu_chkbx'><input class='"+chckbx_menu+" "+one+"_"+clsname2+" "+one+"_"+counter+" chckbx_menu_"+one+" sub_checker_"+one+"_"+id+" sub_chckbox_"+one+"_"+counter+"' name='menu_role_"+one+"' type = 'checkbox' data-id="+b.menu_id+" value='0' onchange='"+func+"("+counter+","+id+")' "+checked_read+" "+checked_view+"></div>";
                                  htm += "<div class='sub_menu_chkbx'><input class='"+chckbx_menu+" "+two+"_"+clsname2+" "+two+"_"+counter+" chckbx_menu_"+two+" sub_checker_"+two+"_"+id+" sub_chckbox_"+two+"_"+counter+"' name='menu_role_"+two+"' type = 'checkbox' data-id="+b.menu_id+" value='0' onchange='"+func+"("+counter+","+id+")' "+checked_write+" "+checked_generate+"></div>";
                                  htm += "<div class='sub_menu_chkbx'><input class='"+chckbx_menu+" "+three+"_"+clsname2+" "+three+"_"+counter+" chckbx_menu_"+three+" sub_checker_"+three+"_"+id+" sub_chckbox_"+three+"_"+counter+"' name='menu_role_"+three+"' type = 'checkbox' data-id="+b.menu_id+" value='0' onchange='"+func+"("+counter+","+id+")' "+checked_delete+" "+checked_export+"></div>";
                                  if(b.menu_name == "Import Target Sales Per Store" || four == "filter"){
                                       htm += "<div class='sub_menu_chkbx'><input class='"+chckbx_menu+" "+four+"_"+clsname2+" "+four+"_"+counter+" chckbx_menu_"+four+" sub_checker_"+four+"_"+id+" sub_chckbox_"+four+"_"+counter+"' name='menu_role_"+four+"' type = 'checkbox' data-id="+b.menu_id+" value='0' onchange='"+func+"("+counter+","+id+")' "+checked_approve+" "+checked_filter+"></div>";
                                  }else{
                                      htm += "<div class='sub_menu_chkbx'><input class='"+chckbx_menu+" not_in_use' name='' type = 'checkbox' data-id="+b.id+" value='0' onchange=''></div>";  
                                  }
                                  htm += "</li>";
                              }
                          htm += "</ul>";

                        counter++;
                         
                    });
                    setTimeout(() => { 
                        $(htm).insertAfter($('.main_menu_'+module_name+"_"+id));
                        if(action == "edit"){
                            //Select all Read
                            select_read();
                            //Select all Write
                            select_write();
                            //Select all Delete
                            select_delete();
                            //Select all Approve
                            select_approve();
                            //Select all View
                            select_view();
                            //Select all Generate
                            select_generate();
                            //Select all Export
                            select_export();
                            //Select all Filter
                            select_filter();
                        }
                        modal.loading(false);
                    }, 500);
                          
                }
            });            
        }
   }

   function select_read(){
        var read_checkbox_count = $('input[name="menu_role_read"]').length;
        var read_checked_checkboxes_count = $('input[name="menu_role_read"]:checked').length;
        if (read_checkbox_count == read_checked_checkboxes_count) {
            $(".select_all_read").prop("checked", true);
        } else {
            $(".select_all_read").prop("checked", false);
        }

   }

   function select_write(){
        var write_checkbox_count = $('input[name="menu_role_write"]').length;
        var write_checked_checkboxes_count = $('input[name="menu_role_write"]:checked').length;
        if (write_checkbox_count == write_checked_checkboxes_count) {
            $(".select_all_write").prop("checked", true);
        } else {
            $(".select_all_write").prop("checked", false);
            $('.select_all_read').attr('disabled',false);
        }
   }

   function select_delete(){
        var delete_checkbox_count = $('input[name="menu_role_delete"]').length;
        var delete_checked_checkboxes_count = $('input[name="menu_role_delete"]:checked').length;
        if (delete_checkbox_count == delete_checked_checkboxes_count) {
            $(".select_all_delete").prop("checked", true);
        } else {
            $(".select_all_delete").prop("checked", false);
            $('.select_all_read').attr('disabled',false);
        }   
   }

   function select_approve(){
        var approve_checkbox_count = $('input[name="menu_role_approve"]').length;
        var approve_checked_checkboxes_count = $('input[name="menu_role_approve"]:checked').length;
        if (approve_checkbox_count == approve_checked_checkboxes_count) {
            $(".select_all_approve").prop("checked", true);
        } else {
            $(".select_all_approve").prop("checked", false);
        }   
   }

   function select_view(){
        var view_checkbox_count = $('input[name="menu_role_view"]').length;
        var view_checked_checkboxes_count = $('input[name="menu_role_view"]:checked').length;
        if (view_checkbox_count == view_checked_checkboxes_count) {
            $(".select_all_view").prop("checked", true);
        } else {
            $(".select_all_view").prop("checked", false);
        }

   }

   function select_generate(){
        var generate_checkbox_count = $('input[name="menu_role_generate"]').length;
        var generate_checked_checkboxes_count = $('input[name="menu_role_generate"]:checked').length;
        if (generate_checkbox_count == generate_checked_checkboxes_count) {
            $(".select_all_generate").prop("checked", true);
        } else {
            $(".select_all_generate").prop("checked", false);
            $('.select_all_view').attr('disabled',false);
        }
   }

   function select_export(){
        var export_checkbox_count = $('input[name="menu_role_export"]').length;
        var export_checked_checkboxes_count = $('input[name="menu_role_export"]:checked').length;
        if (export_checkbox_count == export_checked_checkboxes_count) {
            $(".select_all_export").prop("checked", true);
        } else {
            $(".select_all_export").prop("checked", false);
            $('.select_all_view').attr('disabled',false);
        }   
   }

   function select_filter(){
        var filter_checkbox_count = $('input[name="menu_role_filter"]').length;
        var filter_checked_checkboxes_count = $('input[name="menu_role_filter"]:checked').length;
        if (filter_checkbox_count == filter_checked_checkboxes_count) {
            $(".select_all_filter").prop("checked", true);
        } else {
            $(".select_all_filter").prop("checked", false);
            $('.select_all_view').attr('disabled',false);
        }   
   }

   //Set Value of checkbox
    $(document).on('change', '.chckbx_menu', function(){
        if (this.checked) { 
            $(this).val(1);
        } else {
            $(this).val(0);
        }

        //Select all Read
        var read_checkbox_count = $('input[name="menu_role_read"]').length;
        var read_checked_checkboxes_count = $('input[name="menu_role_read"]:checked').length;
        if (read_checkbox_count == read_checked_checkboxes_count) {
            $(".select_all_read").prop("checked", true);
        } else {
            $(".select_all_read").prop("checked", false);
        }

        //Select all Write
   
        var write_checkbox_count = $('input[name="menu_role_write"]').length;
        var write_checked_checkboxes_count = $('input[name="menu_role_write"]:checked').length;
        if (write_checkbox_count == write_checked_checkboxes_count) {
     ;
            $(".select_all_write").prop("checked", true);
        } else {
            $(".select_all_write").prop("checked", false);
            $('.select_all_read').attr('disabled',false);
        }

        //Select all Delete
        var delete_checkbox_count = $('input[name="menu_role_delete"]').length;
        var delete_checked_checkboxes_count = $('input[name="menu_role_delete"]:checked').length;
        if (delete_checkbox_count == delete_checked_checkboxes_count) {
            $(".select_all_delete").prop("checked", true);
        } else {
            $(".select_all_delete").prop("checked", false);
            $('.select_all_read').attr('disabled',false);
        } 

        //Select all Approve
        var approve_checkbox_count = $('input[name="menu_role_approve"]').length;
        var approve_checked_checkboxes_count = $('input[name="menu_role_approve"]:checked').length;
        if (approve_checkbox_count == approve_checked_checkboxes_count) {
            $(".select_all_approve").prop("checked", true);
        } else {
            $(".select_all_approve").prop("checked", false);
        }   

    });

    $(document).on('change', '.chckbx_menu_site', function(){
        if (this.checked) { 
            $(this).val(1);
        } else {
            $(this).val(0);
        }

        //Select all View
        var view_checkbox_count = $('input[name="menu_role_view"]').length;
        var view_checked_checkboxes_count = $('input[name="menu_role_view"]:checked').length;
        if (view_checkbox_count == view_checked_checkboxes_count) {
            $(".select_all_view").prop("checked", true);
        } else {
            $(".select_all_view").prop("checked", false);
        }

        //Select all Generate
        var generate_checkbox_count = $('input[name="menu_role_generate"]').length;
        var generate_checked_checkboxes_count = $('input[name="generate_role_generate"]:checked').length;
        if (generate_checkbox_count == generate_checked_checkboxes_count) {
           
            $(".select_all_generate").prop("checked", true);
        } else {
            $(".select_all_generate").prop("checked", false);
            $('.select_all_view').attr('disabled',false);
        }

        //Select all Export
        var export_checkbox_count = $('input[name="menu_role_export"]').length;
        var export_checked_checkboxes_count = $('input[name="menu_role_export"]:checked').length;
        if (export_checkbox_count == export_checked_checkboxes_count) {
            $(".select_all_export").prop("checked", true);
        } else {
            $(".select_all_export").prop("checked", false);
            $('.select_all_view').attr('disabled',false);
        }

        //Select all Filter
        var filter_checkbox_count = $('input[name="menu_role_filter"]').length;
        var filter_checked_checkboxes_count = $('input[name="menu_role_filter"]:checked').length;
        if (filter_checkbox_count == filter_checked_checkboxes_count) {
            $(".select_all_filter").prop("checked", true);
        } else {
            $(".select_all_filter").prop("checked", false);
            $('.select_all_view').attr('disabled',false);
        }   

    });

    function chckbox_sub_menu(count_id,id){
         //check parent menu read column
         if($('input.sub_chckbox_read_'+count_id+'').is(':checked')){
              $('.parent_chckbox_read_'+id+'').prop("checked", true).val(1);

         }

         //check parent menu read column if write and delete is checked
         if (($('input.sub_chckbox_write_'+count_id+'').is(':checked'))) {
              $('.sub_chckbox_read_'+count_id+'').prop("checked", true).attr('disabled',true).val(1);
              $('.parent_chckbox_read_'+id+'').prop("checked", true).attr('disabled',true).val(1);
              $('.parent_chckbox_write_'+id+'').prop("checked", true).val(1);
  
          } else {
             $('.sub_chckbox_read_'+count_id+'').attr('disabled',false);
             $('.parent_chckbox_read_'+id+'').attr('disabled',false);
          }


         //check parent menu read column if write and delete is checked
         if (($('input.sub_chckbox_delete_'+count_id+'').is(':checked'))) {
              $('.sub_chckbox_read_'+count_id+'').prop("checked", true).attr('disabled',true).val(1);
              $('.parent_chckbox_read_'+id+'').prop("checked", true).attr('disabled',true).val(1);
              $('.parent_chckbox_delete_'+id+'').prop("checked", true).val(1);
  
          } else {
             $('.sub_chckbox_read_'+count_id+'').attr('disabled',false);
             $('.parent_chckbox_read_'+id+'').attr('disabled',false);
          }

         if (($('input.sub_chckbox_approve_'+count_id+'').is(':checked'))) {
              $('.sub_chckbox_read_'+count_id+'').prop("checked", true).attr('disabled',true).val(1);
              $('.parent_chckbox_read_'+id+'').prop("checked", true).attr('disabled',true).val(1);
              $('.parent_chckbox_approve_'+id+'').prop("checked", true).val(1);
  
          } else {
             $('.sub_chckbox_read_'+count_id+'').attr('disabled',false);
             $('.parent_chckbox_read_'+id+'').attr('disabled',false);
          }

       /// Unchecked parent menu  if all sub menu value is 0 
         if(($('.sub_checker_read_'+id+':checked').length) == 0){
             $('.parent_chckbox_read_'+id+'').prop("checked", false).val(0);
         }


       /// Unchecked parent menu  if all sub menu value is 0 
         if(($('.sub_checker_write_'+id+':checked').length) == 0){
             $('.parent_chckbox_write_'+id+'').prop("checked", false).val(0);
         }

      
         if(($('.sub_checker_delete_'+id+':checked').length) == 0){
             $('.parent_chckbox_delete_'+id+'').prop("checked", false).val(0);
         }

         if(($('.sub_checker_approve_'+id+':checked').length) == 0){
             $('.parent_chckbox_approve_'+id+'').prop("checked", false).val(0);
         }
    }

    function chckbox_sub_menu_site(count_id,id){
         //check parent menu view column
         if($('input.sub_chckbox_view_'+count_id+'').is(':checked')){
              $('.parent_chckbox_view_'+id+'').prop("checked", true).val(1);

         }

         //check parent menu view column if generate and export is checked
         if (($('input.sub_chckbox_generate_'+count_id+'').is(':checked'))) {
              $('.sub_chckbox_view_'+count_id+'').prop("checked", true).attr('disabled',true).val(1);
              $('.parent_chckbox_view_'+id+'').prop("checked", true).attr('disabled',true).val(1);
              $('.parent_chckbox_generate_'+id+'').prop("checked", true).val(1);
  
          } else {
             $('.sub_chckbox_view_'+count_id+'').attr('disabled',false);
             $('.parent_chckbox_view_'+id+'').attr('disabled',false);
          }


         //check parent menu view column if generate and export is checked
         if (($('input.sub_chckbox_export_'+count_id+'').is(':checked'))) {
              $('.sub_chckbox_view_'+count_id+'').prop("checked", true).attr('disabled',true).val(1);
              $('.parent_chckbox_view_'+id+'').prop("checked", true).attr('disabled',true).val(1);
              $('.parent_chckbox_export_'+id+'').prop("checked", true).val(1);
  
          } else {
             $('.sub_chckbox_view_'+count_id+'').attr('disabled',false);
             $('.parent_chckbox_view_'+id+'').attr('disabled',false);
          }

         //check parent menu view column if generate and filter is checked
         if (($('input.sub_chckbox_filter_'+count_id+'').is(':checked'))) {
              $('.sub_chckbox_view_'+count_id+'').prop("checked", true).attr('disabled',true).val(1);
              $('.parent_chckbox_view_'+id+'').prop("checked", true).attr('disabled',true).val(1);
              $('.parent_chckbox_filter_'+id+'').prop("checked", true).val(1);
  
          } else {
             $('.sub_chckbox_view_'+count_id+'').attr('disabled',false);
             $('.parent_chckbox_view_'+id+'').attr('disabled',false);
          }



       /// Unchecked parent menu  if all sub menu value is 0 
         if(($('.sub_checker_view_'+id+':checked').length) == 0){
             $('.parent_chckbox_view_'+id+'').prop("checked", false).val(0);
         }


       /// Unchecked parent menu  if all sub menu value is 0 
         if(($('.sub_checker_generate_'+id+':checked').length) == 0){
             $('.parent_chckbox_generate_'+id+'').prop("checked", false).val(0);
         }

      
         if(($('.sub_checker_export_'+id+':checked').length) == 0){
             $('.parent_chckbox_export_'+id+'').prop("checked", false).val(0);
         }

        if(($('.sub_checker_filter_'+id+':checked').length) == 0){
             $('.parent_chckbox_filter_'+id+'').prop("checked", false).val(0);
         }
    }

    function chckbox_parent_menu(id){
        if(($('input.parent_chckbox_read_'+id+'').is(':checked'))){
            $('.sub_checker_read_'+id+'').prop("checked", true).val(1);
        }else{
            $('.sub_checker_read_'+id+'').prop("checked", false).val(0);
        }

        //check  read column if write  is checked
         if (($('input.parent_chckbox_write_'+id+'').is(':checked'))) {
              $('.sub_checker_write_'+id+'').prop("checked", true).val(1);
              $('.parent_chckbox_read_'+id+'').prop("checked", true).val(1);
              $('.sub_checker_read_'+id+'').prop("checked", true).attr('disabled',true).val(1);    
          } else {
             $('.sub_checker_write_'+id+'').prop("checked", false).val(0);
             $('.parent_chckbox_read_'+id+'').attr('disabled',false);
             $('.sub_checker_read_'+id+'').attr('disabled',false);
          }

         if (($('input.parent_chckbox_delete_'+id+'').is(':checked'))) {
              $('.sub_checker_delete_'+id+'').prop("checked", true).val(1);
              $('.parent_chckbox_read_'+id+'').prop("checked", true).val(1);
              $('.sub_checker_read_'+id+'').prop("checked", true).attr('disabled',true).val(1);    
          } else {
             $('.sub_checker_delete_'+id+'').prop("checked", false).val(0);
             $('.parent_chckbox_read_'+id+'').attr('disabled',false);
             $('.sub_checker_read_'+id+'').attr('disabled',false);
          }

         if (($('input.parent_chckbox_approve_'+id+'').is(':checked'))) {
              $('.sub_checker_approve_'+id+'').prop("checked", true).val(1);
             // $('.parent_chckbox_read_'+id+'').prop("checked", true).val(1);
             // $('.sub_checker_read_'+id+'').prop("checked", true).attr('disabled',true).val(1);    
          } else {
             $('.sub_checker_approve_'+id+'').prop("checked", false).val(0);
             $('.parent_chckbox_read_'+id+'').attr('disabled',false);
             $('.sub_checker_read_'+id+'').attr('disabled',false);
          }
    }

    function chckbox_parent_menu_site(id){
        if(($('input.parent_chckbox_view_'+id+'').is(':checked'))){
            $('.sub_checker_view_'+id+'').prop("checked", true).val(1);
        }else{
            $('.sub_checker_view_'+id+'').prop("checked", false).val(0);
        }

        //check view column if generate is checked
         if (($('input.parent_chckbox_generate_'+id+'').is(':checked'))) {
              $('.sub_checker_generate_'+id+'').prop("checked", true).val(1);
              $('.parent_chckbox_view_'+id+'').prop("checked", true).val(1);
              $('.sub_checker_view_'+id+'').prop("checked", true).attr('disabled',true).val(1);    
          } else {
             $('.sub_checker_generate_'+id+'').prop("checked", false).val(0);
             $('.parent_chckbox_view_'+id+'').attr('disabled',false);
             $('.sub_checker_view_'+id+'').attr('disabled',false);
          }

         if (($('input.parent_chckbox_export_'+id+'').is(':checked'))) {
              $('.sub_checker_export_'+id+'').prop("checked", true).val(1);
              $('.parent_chckbox_view_'+id+'').prop("checked", true).val(1);
              $('.sub_checker_view_'+id+'').prop("checked", true).attr('disabled',true).val(1);    
          } else {
             $('.sub_checker_export_'+id+'').prop("checked", false).val(0);
             $('.parent_chckbox_view_'+id+'').attr('disabled',false);
             $('.sub_checker_view_'+id+'').attr('disabled',false);
          }

         if (($('input.parent_chckbox_filter_'+id+'').is(':checked'))) {
              $('.sub_checker_filter_'+id+'').prop("checked", true).val(1);
              $('.parent_chckbox_view_'+id+'').prop("checked", true).val(1);
              $('.sub_checker_view_'+id+'').prop("checked", true).attr('disabled',true).val(1);    
          } else {
             $('.sub_checker_filter_'+id+'').prop("checked", false).val(0);
             $('.parent_chckbox_view_'+id+'').attr('disabled',false);
             $('.sub_checker_view_'+id+'').attr('disabled',false);
          }
    }

    //Select all function for Read
    $(document).on('change', '.select_all_read', function(){
      if(this.checked) { 
        $('.chckbx_menu_read').each(function() { 
          this.checked = true; 
          this.value = 1;      
        });
      }else{
        $('.chckbx_menu_read').each(function() { 
          this.checked = false; 
          this.value = 0;                
        });         
      }
    });

    //Select all function for View
    $(document).on('change', '.select_all_view', function(){
      if(this.checked) { 
        $('.chckbx_menu_view').each(function() { 
          this.checked = true; 
          this.value = 1;      
        });
      }else{
        $('.chckbx_menu_view').each(function() { 
          this.checked = false; 
          this.value = 0;                
        });         
      }
    });

    //Select all function for write
    $(document).on('change', '.select_all_write', function(){
      if(this.checked) { 
        $('.chckbx_menu_write').each(function() { 
          this.checked = true; 
          this.value = 1; 
            $('.chckbx_menu_read').each(function() { 
              this.checked = true; 
              this.value = 1;      
            });
            $('.select_all_read').prop("checked", true);  
            $('.select_all_read').attr('disabled',true);
            $('.chckbx_menu_read').attr('disabled',true);  
        });
      }else{
        $('.chckbx_menu_write').each(function() { 
          this.checked = false; 
          this.value = 0;                
        });    
        $('.select_all_read').attr('disabled',false);
        $('.chckbx_menu_read').attr('disabled',false);      
      }
    });

    //Select all function for generate
    $(document).on('change', '.select_all_generate', function(){
      if(this.checked) { 
        $('.chckbx_menu_generate').each(function() { 
          this.checked = true; 
          this.value = 1; 
            $('.chckbx_menu_view').each(function() { 
              this.checked = true; 
              this.value = 1;      
            });
            $('.select_all_view').prop("checked", true);  
            $('.select_all_view').attr('disabled',true);
            $('.chckbx_menu_view').attr('disabled',true);  
        });
      }else{
        $('.chckbx_menu_generate').each(function() { 
          this.checked = false; 
          this.value = 0;                
        });    
        $('.select_all_view').attr('disabled',false);
        $('.chckbx_menu_view').attr('disabled',false);      
      }
    });

    //Select all function for delete
    $(document).on('change', '.select_all_delete', function(){
      if(this.checked) { 
        $('.chckbx_menu_delete').each(function() { 
          this.checked = true; 
          this.value = 1; 
            $('.chckbx_menu_read').each(function() { 
              this.checked = true; 
              this.value = 1;      
            });
            $('.select_all_read').prop("checked", true);  
            $('.select_all_read').attr('disabled',true);
            $('.chckbx_menu_read').attr('disabled',true);  
        });
      }else{
        $('.chckbx_menu_delete').each(function() { 
          this.checked = false; 
          this.value = 0;                
        });    
        $('.select_all_read').attr('disabled',false);
        $('.chckbx_menu_read').attr('disabled',false);      
      }
    });

    //Select all function for approve
    $(document).on('change', '.select_all_approve', function(){
      if(this.checked) { 
        $('.chckbx_menu_approve').each(function() { 
          this.checked = true; 
          this.value = 1; 
            $('.chckbx_menu_read').each(function() { 
              this.checked = true; 
              this.value = 1;      
            });
            //$('.select_all_read').prop("checked", true);  
            //$('.select_all_read').attr('disabled',true);
            //$('.chckbx_menu_read').attr('disabled',true);  
        });
      }else{
        $('.chckbx_menu_approve').each(function() { 
          this.checked = false; 
          this.value = 0;                
        });    
        $('.select_all_read').attr('disabled',false);
        $('.chckbx_menu_read').attr('disabled',false);      
      }
    });

    //Select all function for export
    $(document).on('change', '.select_all_export', function(){
      if(this.checked) { 
        $('.chckbx_menu_export').each(function() { 
          this.checked = true; 
          this.value = 1; 
            $('.chckbx_menu_view').each(function() { 
              this.checked = true; 
              this.value = 1;      
            });
            $('.select_all_view').prop("checked", true);  
            $('.select_all_view').attr('disabled',true);
            $('.chckbx_menu_view').attr('disabled',true);  
        });
      }else{
        $('.chckbx_menu_export').each(function() { 
          this.checked = false; 
          this.value = 0;                
        });    
        $('.select_all_view').attr('disabled',false);
        $('.chckbx_menu_view').attr('disabled',false);      
      }
    });

    //Select all function for filter
    $(document).on('change', '.select_all_filter', function(){
      if(this.checked) { 
        $('.chckbx_menu_filter').each(function() { 
          this.checked = true; 
          this.value = 1; 
            $('.chckbx_menu_view').each(function() { 
              this.checked = true; 
              this.value = 1;      
            });
            $('.select_all_view').prop("checked", true);  
            $('.select_all_view').attr('disabled',true);
            $('.chckbx_menu_view').attr('disabled',true);  
        });
      }else{
        $('.chckbx_menu_filter').each(function() { 
          this.checked = false; 
          this.value = 0;                
        });    
        $('.select_all_view').attr('disabled',false);
        $('.chckbx_menu_view').attr('disabled',false);      
      }
    });

    $(document).on('keydown', '#search_query', function(event) {
        $('.btn_status').hide();
        $(".selectall").prop("checked", false);
        if (event.key == 'Enter') {
            search_input = $('#search_query').val();
            offset = 1;
            new_query = query;
            new_query += ' AND name like \'%'+search_input+'%\'';
            get_data(new_query);
            get_pagination(new_query);
        }
    });

    $(document).on('click', '.btn_status', function (e) {
        var status = $(this).attr("data-status");
        var modal_obj = "";
        var modal_alert_success = "";
        var hasExecuted = false; // Prevents multiple executions
        var id_array = [];

        if (parseInt(status) === -2) {
            modal_obj = confirm_delete_message;
            modal_alert_success = success_delete_message;
            offset = 1;
        } else if (parseInt(status) === 1) {
            modal_obj = confirm_publish_message;
            modal_alert_success = success_publish_message;
        } else {
            modal_obj = confirm_unpublish_message;
            modal_alert_success = success_unpublish_message;
        }
        modal.confirm(modal_obj, function (result) {
            if (result) {
                $('.selectall').prop('checked', false);
                $('.select:checked').each(function(index) { 
                    id = $(this).attr('data-id');
                    id_array.push(id);
                });
                if( <?=STATUS_UNPUBLISH?> === parseInt(status) || <?=STATUS_TRASH?> === parseInt(status)){
                    var url = "<?= base_url('cms/global_controller');?>";
                    var data = {
                        event : "list",
                        select : "id,role,status",
                        query : "status >= 0 AND role IN (" + id_array +")",
                        table : "cms_users"
                    }
                    aJax.post(url,data,function(result){
                        var obj = is_json(result);
                        if (obj.length > 0){
                            modal.alert(error_value_used, "error", function(){});
                            $('.btn_status').hide();
                            $(".select:checked").prop("checked", false);
                        } else {
                            var url = "<?= base_url('cms/global_controller');?>";
                            var dataList = [];
                            
                            $('.select:checked').each(function () {
                                var id = $(this).attr('data-id');
                                dataList.push({
                                    event: "update",
                                    table: "cms_user_roles",
                                    field: "id",
                                    where: id,
                                    data: {
                                        status: status,
                                        updated_date: formatDate(new Date())
                                    }
                                });
                                var customURL = "<?= base_url('cms/role/delete-role-tagging');?>"; 
                                var data = {
                                    role_id : id
                                }
                                aJax.post(customURL,data,function(result){});
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

                    });
                }else{
                    var url = "<?= base_url('cms/global_controller');?>";
                    var dataList = [];
                    
                    $('.select:checked').each(function () {
                        var id = $(this).attr('data-id');
                        dataList.push({
                            event: "update",
                            table: "cms_user_roles",
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

    function open_modal(msg, actions, id) {
        //modal.loading(true);
        $(".form-control").css('border-color','#ccc');
        $(".validate_error_message").remove();
        let $modal = $('#user_role_modal');
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
        

        $footer.empty();
        if (actions === 'add') $footer.append(buttons.save);
        if (actions === 'edit') $footer.append(buttons.edit);
        $footer.append(buttons.close);
        if(id == ""){
            var query = "`menu_level` = 1 and `status` = 1";
            get_data_modules(query, "add");
            get_data_site_menu(query, "add");
        }
        
        setTimeout(() => {
            $modal.modal('show');
            modal.loading(true);
            set_field_state('#name, #status, .chckbx_menu_site, .chckbx_menu, .select_all_view, .select_all_generate, .select_all_export, .select_all_filter, .select_all_read, .select_all_write, .select_all_delete, .select_all_approve', isReadOnly);
        }, 2000);
        
    }

    function populate_modal(inp_id) {
        //modal.loading(true);
        var query = "status >= 0 and id = " + inp_id;
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, name, status",
            query : query, 
            table : "cms_user_roles"
        }
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(index,d) {
                    $('#id').val(d.id);
                    $('#name').val(d.name);
                    if(d.status == 1) {
                        $('#status').prop('checked', true)
                    } else {
                        $('#status').prop('checked', false)
                    }

                    roles_menu_id = d.id;
                    if(role === 1){
                      query = "`role_id` = "+roles_menu_id+" AND `menu_level` = 1 AND `status` = 1 and role_id != 0";
                    }else{
                       query = "`role_id` = "+roles_menu_id+" AND `menu_level` = 1 AND `status` = 1 AND `menu_id` != 8 AND `menu_id` != 6 and role_id != 0";
                    }
                    get_data_modules(query, "edit");
                    get_data_site_menu(query, "edit");
                    //modal.loading(false);
                }); 
            }
        });
    }

    function view_data(id) {
        open_modal('View Role', 'view', id);
    }

    function edit_data(menu_role_id, role, status){
        open_modal('Edit Role', 'edit', menu_role_id);
    }

    function set_field_state(selector, isReadOnly) {
        $(selector).prop({ readonly: isReadOnly, disabled: isReadOnly });
    }

    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0'); 
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');

        // Combine into the desired format
        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }
</script>