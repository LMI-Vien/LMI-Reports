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
    grid-template-columns: 52fr repeat(3, 16fr);
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
    width: 52%;
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
    width: 52%;
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
<div class="modal fade bd-example-modal-xl" id="save_user_role_modal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add User Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>User Role</label>
                    <input type="text" class="form-control required" id="user_role">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input large-checkbox required" id="status">
                    <label class="form-check-label large-label" for="status">Active</label>
                </div>
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
                                            </ul>
                                      </div> 
                                    <div class="menu_body_container">
                                  </div>
                            </div>
         
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

          <!--   <div class="modal-footer">
                close_data
                <button type="button" class="btn btn-primary" id="save_btn">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div> -->
            <div class="modal-footer">
                <button id="save_btn" class="btn save">Save</button>
                <button id="close_data" class="btn caution" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Update MODAL -->
<div class="modal fade" id="update_user_role_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update User Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>User Role</label>
                    <input type="text" class="form-control" id="user_role">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input large-checkbox" id="status">
                    <label class="form-check-label large-label" for="status">Active</label>
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
                                            </ul>
                                      </div> 
                                    <div class="menu_body_container_edit">
                                  </div>
                            </div>
         
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="updateBtn">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- View MODAL -->
<div class="modal fade" id="view_user_role_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View User Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>User Role</label>
                    <input type="text" class="form-control" id="user_role" readonly>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input large-checkbox" id="status" disabled>
                    <label class="form-check-label large-label" for="status">Active</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
      get_data();
      get_pagination();
    });

    function get_data()
    {
      var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "list",
            select : "id, name, status, updated_date",
            query : query,
            offset : offset,
            limit : limit,
            table : "cms_user_roles",
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

                        html += "<tr>";
                        html += "<td class='center-content'><input class='select' type=checkbox data-id="+y.id+" onchange=checkbox_check()></td>";
                        html += "<td>" + y.name + "</td>";
                        html += "<td class='center-content'>"+y.updated_date+  "</td>";
                        html += "<td>" +status+ "</td>";

                        if (y.id <= 2) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                            html+="<td class='center-content'>";
                            html += "<a class='btn-sm btn save' onclick=\"edit_data("
                                + y.id + ", '"
                                + y.name.replace(/'/g, "\\'").replace(/"/g, "&quot;")
                                + y.status + "')\" data-status='"
                                + y.status + "' id='"
                                + y.id + "' title='Edit Details'><span class='glyphicon glyphicon-pencil'>Edit</span></a>";

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

    function get_pagination()
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
        get_data();
    })

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

    $("#btn_export").on("click", function (e) {
      alert("call ajax to controler");
    });

    $(document).ready(function () {
        $(document).on('click', '#btn_add', function () {
            $('#save_user_role_modal').modal('show');
            get_data_modules();
            get_data_site_menu();
        });
    });

    $(document).on('click', '#save_btn', function() {
        if (validate.standard("save_user_role_modal")) {
          save_data('save', null);  
        }
    });

    $(document).on('click', '#updateBtn', function() {
        var id = $(this).attr('data-id');
        update_data(id);
    });

    $(document).on('click', '.edit', function() {
        id = $(this).attr('id');
        get_data_by_id(id);
    });

    $(document).on('click', '.delete_data', function() {
        var id = $(this).attr('id');
        delete_data(id); 
    });

    $(document).on('click', '.view', function() {
        id = $(this).attr('id');
        get_data_by_id_view(id);
    });

    function save_data() {
        var status = $('#save_user_role_modal #status').prop('checked') ? 1 : 0;
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
            menu_role_updated_date: current_date,
            menu_role_created_date: current_date
        };

        site_menu_data.push(data_array_site_menu);
    });
        
        var user_role_data = {
            name : $('#user_role').val(),
            status : status,
            created_date :  current_date,
           // update_date :  current_date,
            created_by  : user_id
           // updated_by  : user_id
        };
        
        var data = {
            cms_menu_role_data : cms_menu_data,
            site_menu_role_data : site_menu_data,
            user_role_data : user_role_data
        }
        console.log(data);
        modal.confirm(confirm_add_message,function(result){
            if(result){ 
                aJax.post("<?= base_url('cms/site-menu/menu_insert');?>",data,function(result){
                   
                    modal.loading(false);
                    modal.alert(success_save_message, function(){
                        location.href = '<?=base_url("cms/roles") ?>';
                    }); 
                });
            }

        });
    }

    function update_data(id){
        // var status = $('#update_user_role_modal #status').val();
        var status = $('#update_user_role_modal #status').prop('checked') ? 1 : 0;
        
        modal.confirm("Are you sure you want to update this record?",function(result){
            console.log(result);
            if(result){ 
                var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
                var data = {
                    event : "update", // list, insert, update, delete
                    table : "cms_user_roles", //table
                    field : "id",
                    where : id, 
                    data : {
                            name : $('#update_user_role_modal #user_role').val(),
                            status : $('#update_user_role_modal #status').val(),
                            //created_date : formatDate(new Date()),
                            updated_date : formatDate(new Date()),
                            //to follow created data and created by
                            //created_by : user_id,
                            updated_by : user_id,
                            status : status
                    }  
                }

                aJax.post(url,data,function(result){
                    var obj = is_json(result);
                    //alert("pasok");
                    location.reload();
                    // modal.alert("<strong>Success!</strong> Record has been Saved",function(){ 
                    //    location.reload();
                    // })
                });
            }

        });
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
            console.log(obj);
            if(obj){
                $.each(obj, function(x,y) {
                    console.log(y);
                    $('#update_user_role_modal #user_role').val(y.name);
                    
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
        
        modal.confirm("Are you sure you want to delete this record?",function(result){
            if(result){ 
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
                    // alert("pasok");
                    location.reload();
                    // modal.alert("<strong>Success!</strong> Record has been Saved",function(){ 
                    //    location.reload();
                    // })
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
            select : "id, name, status, updated_date",
            query : query, 
            table : "cms_user_roles"
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(x,y) {
                    $('#view_user_role_modal #user_role').val(y.name);
                    
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

    function get_data_site_menu(){
        var query = "menu_level = 1 and status = 1";
        var exists = 0;

        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id,menu_name,menu_type,menu_parent_id,menu_level,status,sort_order",
            query : query, 
            table : "site_menu"
        }

        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            var htm = '';
            if(result.length > 0){  
                $.each(result,function(x,y){
                    htm += "<ul class='parent_menu'>";
                        if(parseInt(y.menu_level) === 1){
                          htm += "<li class='main_menu_sitemenu_"+y.id+"'>";
                          htm += "<div class='menu_title'><input type='hidden' class='menu_id_site menu_id_"+counter+"' data-id="+y.id+"><span>"+y.menu_name+"</span></div>"; 
                          htm += "<div class='menu_chkbx'><input class='chckbx_menu_site view_site view_"+counter+" chckbx_menu_view parent_chckbox_view_"+y.id+"' type = 'checkbox'  name='menu_role_view' data-id="+y.id+" value='0' onchange='chckbox_parent_menu_site("+y.id+")'></div>";
                          htm += "<div class='menu_chkbx'><input class='chckbx_menu_site generate_site generate_"+counter+" chckbx_menu_generate parent_chckbox_generate_"+y.id+"' name='menu_role_generate' type = 'checkbox' data-id="+y.id+" value='0' onchange='chckbox_parent_menu_site("+y.id+")'></div>";
                          htm += "<div class='menu_chkbx'><input class='chckbx_menu_site export_site export_"+counter+" chckbx_menu_export parent_chckbox_export_"+y.id+"' name='menu_role_export' type = 'checkbox' data-id="+y.id+" value='0' onchange='chckbox_parent_menu_site("+y.id+")'></div>";
                          htm += "</li>";
                            get_sub_menu(y.id, "site_menu", "sitemenu");
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

    function get_data_modules(){
        var query = "menu_level = 1 and status = 1";
        var exists = 0;

        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id,menu_name,menu_type,menu_parent_id,menu_level,status,sort_order",
            query : query, 
            table : "cms_menu",
            order: {
                field: "sort_order",
                order: "asc"
             }
        }

        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            var htm = '';
            if(result.length > 0){  
                $.each(result,function(x,y){
                    htm += "<ul class='parent_menu'>";
                        if(parseInt(y.menu_level) === 1){
                          htm += "<li class='main_menu_cmsmenu_"+y.id+"'>";
                          htm += "<div class='menu_title'><input type='hidden' class='menu_id_cms menu_id_"+counter_cmsmenu+"' data-id="+y.id+"><span>"+y.menu_name+"</span></div>"; 
                          htm += "<div class='menu_chkbx'><input class='chckbx_menu read_cms read_"+counter_cmsmenu+" chckbx_menu_read parent_chckbox_read_"+y.id+"' type = 'checkbox'  name='menu_role_read' data-id="+y.id+" value='0' onchange='chckbox_parent_menu("+y.id+")'></div>";
                          htm += "<div class='menu_chkbx'><input class='chckbx_menu write_cms write_"+counter_cmsmenu+" chckbx_menu_write parent_chckbox_write_"+y.id+"' name='menu_role_write' type = 'checkbox' data-id="+y.id+" value='0' onchange='chckbox_parent_menu("+y.id+")'></div>";
                          htm += "<div class='menu_chkbx'><input class='chckbx_menu delete_cms delete_"+counter_cmsmenu+" chckbx_menu_delete parent_chckbox_delete_"+y.id+"' name='menu_role_delete' type = 'checkbox' data-id="+y.id+" value='0' onchange='chckbox_parent_menu("+y.id+")'></div>";
                          htm += "</li>";
                              get_sub_menu(y.id, "cms_menu", "cmsmenu");
                        }
                    htm += "</ul>";
                    counter_cmsmenu++;
                });



            } else {
                htm += '<ul>';
                htm += '<li class="ta_c;">No Results Found.</li>';
                htm += '</ul>';
            }
            $('.module_body_container').html(htm);
        });
    }

    function get_sub_menu(id, table, module_name)
    {
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
                 var chckbx_menu = "chckbx_menu";
                 var func = "chckbox_sub_menu";
                 var clsname = "menu_id_cms";
                 var clsname2 = "cms";
                 counter = counter_cmsmenu;
                 if(module_name == "sitemenu"){
                    one = "view";
                    two = "generate";
                    three = "export";
                    counter = counter_sitemenu;
                    chckbx_menu = "chckbx_menu_site";
                    func = "chckbox_sub_menu_site";
                    clsname = "menu_id_site";
                    clsname2 = "site";
                 }
                 $.each(obj,function(a,b)
                 {  
                      htm += "<ul class='child_menu'>";
                          if(parseInt(b.menu_level) === 2){
                              htm += "<li class='sub_menu_"+b.id+"'>";
                              htm += "<div class='sub_menu_title'><input type='hidden' class='"+clsname+" menu_id_"+counter+"' data-id="+b.id+"><span>"+b.menu_name+"</span></div>";
                              htm += "<div class='sub_menu_chkbx'><input class='"+chckbx_menu+" read_"+clsname2+" "+one+"_"+counter+" chckbx_menu_"+one+" sub_checker_"+one+"_"+id+" sub_chckbox_"+one+"_"+counter+"' name='menu_role_"+one+"' type = 'checkbox' data-id="+b.id+" value='0' onchange='"+func+"("+counter+","+id+")'></div>";
                              htm += "<div class='sub_menu_chkbx'><input class='"+chckbx_menu+" write_"+clsname2+" "+two+"_"+counter+" chckbx_menu_"+two+" sub_checker_"+two+"_"+id+" sub_chckbox_"+two+"_"+counter+"' name='menu_role_"+two+"' type = 'checkbox' data-id="+b.id+" value='0' onchange='"+func+"("+counter+","+id+")'></div>";
                              htm += "<div class='sub_menu_chkbx'><input class='"+chckbx_menu+" delete_"+clsname2+" "+three+"_"+counter+" chckbx_menu_"+three+" sub_checker_"+three+"_"+id+" sub_chckbox_"+three+"_"+counter+"' name='menu_role_"+three+"' type = 'checkbox' data-id="+b.id+" value='0' onchange='"+func+"("+counter+","+id+")'></div>";
                              htm += "</li>";
                          }
                      htm += "</ul>";

                    counter++;
                     
                });
                setTimeout(() => { 
                    $(htm).insertAfter($('.main_menu_'+module_name+"_"+id)); 
                }, 500);
                      
            }
        });
   }

    function get_sub_menu2(id, table, module_name){

        console.log(id, roles_menu_id);
        if(role == 1){
          query = "role_id = "+roles_menu_id+" AND menu_parent_id = "+id+" AND menu_level = 2 AND status = 1";
        }else{
           query = "role_id = "+roles_menu_id+" AND menu_parent_id = "+id+" AND menu_level = 2 AND status = 1 AND menu_id != 14 AND menu_id != 15 AND menu_id != 22";
        } 

        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event:"list",
            select:"cms_menu.id as menu_id,menu_name,menu_type,menu_parent_id,menu_level,status,sort_order,role_id,cms_menu_roles.menu_id as roles_menu_id,menu_role_read,menu_role_write,menu_role_delete",
            table: table,
            query: query,
             join : [ //optional
                {
                    table : "cms_menu_roles", //table
                    query : "cms_menu_roles.menu_id = cms_menu.id", //join query
                    type : "left" //type of join
                }
            ],
            sort_order:{
                field: "sort_order",
                sort_order: "asc"
             }

        }

        aJax.post_async(url,data,function(result){
            var obj = is_json(result);
            console.log(obj);
            var htm = '';
            if(obj.length > 0){
                 $.each(obj,function(a,b){  
                      var checked_read = ( b.menu_role_read == 1 ) ? checked_read = "checked" : checked_read = "";
                      var checked_write = ( b.menu_role_write == 1 ) ? checked_write = "checked" : checked_write = "";
                      var checked_delete = ( b.menu_role_delete == 1 ) ? checked_delete = "checked" : checked_delete = "";

                      htm += "<ul class='child_menu'>";
                          if(b.menu_level == 2){
                              htm += "<li class='sub_menu_"+b.menu_id+"'>";
                              htm += "<div class='sub_menu_title'><input type='hidden' class='menu_id_"+counter+"' data-id="+b.menu_id+"><span>"+b.menu_name+"</span></div>";
                              htm += "<div class='sub_menu_chkbx'><input class='chckbx_menu read_"+counter+" chckbx_menu_read sub_checker_read_"+id+" sub_chckbox_read_"+counter+"' name='menu_role_read' type = 'checkbox' data-id="+b.menu_id+" value="+b.menu_role_read+" onchange='chckbox_sub_menu("+counter+","+id+")' "+checked_read+"></div>";
                              htm += "<div class='sub_menu_chkbx'><input class='chckbx_menu write_"+counter+" chckbx_menu_write sub_checker_write_"+id+" sub_chckbox_write_"+counter+"' name='menu_role_write' type = 'checkbox' data-id="+b.menu_id+" value="+b.menu_role_write+" onchange='chckbox_sub_menu("+counter+","+id+")' "+checked_write+"></div>";
                              htm += "<div class='sub_menu_chkbx'><input class='chckbx_menu delete_"+counter+" chckbx_menu_delete sub_checker_delete_"+id+" sub_chckbox_delete_"+counter+"' name='menu_role_delete' type = 'checkbox' data-id="+b.menu_id+" value="+b.menu_role_delete+" onchange='chckbox_sub_menu("+counter+","+id+")' "+checked_delete+"></div>";
                              htm += "</li>";
                          }
                      htm += "</ul>";

                    counter++;
                     
                });

                setTimeout(() => { 
                    console.log(module_name);
                    $(htm).insertAfter($('.main_menu_'+module_name+"_"+id)); 
                    //Select all Read
                    select_read();
                    //Select all Write
                    select_write();
                    //Select all Delete
                    select_delete();
                }, 500);
            }

    });

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
    }

    function chckbox_parent_menu_site(id){
        if(($('input.parent_chckbox_view_'+id+'').is(':checked'))){
            $('.sub_checker_view_'+id+'').prop("checked", true).val(1);
        }else{
            $('.sub_checker_view_'+id+'').prop("checked", false).val(0);
        }

        //check view column if generate is checked
         if (($('input.parent_chckbox_generate_'+id+'').is(':checked'))) {
                                  alert('asd')
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

    function edit_data(menu_role_id, name, status){
        console.log(name, status);
        roles_menu_id = menu_role_id;
        $('#update_user_role_modal').modal('show');
        if(role === 1){
          query = "`role_id` = "+roles_menu_id+" AND `menu_level` = 1 AND `status` = 1 and role_id != 0";
        }else{
           query = "`role_id` = "+roles_menu_id+" AND `menu_level` = 1 AND `status` = 1 AND `menu_id` != 8 AND `menu_id` != 6 and role_id != 0";
        } 

        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
             event: "list",
             select: "`cms_menu`.`id` as `menu_id`,`menu_name`,`menu_type`,`menu_parent_id`,`menu_level`,`status`,`sort_order`,`role_id`,`cms_menu_roles`.`menu_id` as `roles_menu_id`,`menu_role_read`,`menu_role_write`,`menu_role_delete`",
             table: "cms_menu",
             query: query,
             join : [ //optional
                {
                    table : "cms_menu_roles", //table
                    query : "cms_menu_roles.menu_id = cms_menu.id", //join query
                    type : "left" //type of join
                }
            ],
             order: {
                field: "sort_order",
                order: "asc"
             }
        }

        aJax.post_async(url,data,function(result){
            var obj = is_json(result);
            var htm = '';

           if(obj.length > 0){  
                $.each(obj,function(x,y){
                    var checked_read = ( y.menu_role_read == 1 ) ? checked_read = "checked" : checked_read = "";
                    var checked_write = ( y.menu_role_write == 1 ) ? checked_write = "checked" : checked_write = "";
                    var checked_delete = ( y.menu_role_delete == 1 ) ? checked_delete = "checked" : checked_delete = "";

                    htm += "<ul class='parent_menu'>";
                        if(y.menu_level == 1){
                          htm += "<li class='main_menu_cmsmenu_"+y.menu_id+"'>";
                          htm += "<div class='menu_title'><input type='hidden' class='menu_id_"+counter+"' data-id="+y.menu_id+"><span>"+y.menu_name+"</span></div>"; 
                          htm += "<div class='menu_chkbx'><input class='chckbx_menu  read_"+counter+" chckbx_menu_read parent_chckbox_read_"+y.menu_id+"' type = 'checkbox'  name='menu_role_read' data-id="+y.menu_id+" value="+y.menu_role_read+" onchange='chckbox_parent_menu("+y.menu_id+")' "+checked_read+"></div>";
                          htm += "<div class='menu_chkbx'><input class='chckbx_menu write_"+counter+" chckbx_menu_write parent_chckbox_write_"+y.menu_id+"' name='menu_role_write' type = 'checkbox' data-id="+y.menu_id+" value="+y.menu_role_write+" onchange='chckbox_parent_menu("+y.menu_id+")'  "+checked_write+"></div>";
                          htm += "<div class='menu_chkbx'><input class='chckbx_menu delete_"+counter+" chckbx_menu_delete parent_chckbox_delete_"+y.menu_id+"' name='menu_role_delete' type = 'checkbox' data-id="+y.menu_id+" value="+y.menu_role_delete+" onchange='chckbox_parent_menu("+y.menu_id+")' "+checked_delete+"></div>";
                          htm += "</li>";
                          get_sub_menu2(y.menu_id, "cms_menu", "cmsmenu");
                        }
                    htm += "</ul>";
                    counter++;
                });



             }else{
                htm += '    <ul>';
                htm += '        <li class="ta_c">No Results Found.</li>';
                htm += '    </ul>';
             }
            $('.module_body_container').html(htm);

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
</script>