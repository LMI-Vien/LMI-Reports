<style>
/*temp pa lang*/
.hidden {
display: none;
}
</style>
    <div class="content-wrapper p-4">
        <div class="card">
            <div class="text-center page-title md-center">
                <b>S I T E - M E N U</b>
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
                                        <th class = "w-10 hidden"></th>
                                        <th class = "w-10"><input class ="selectall" type ="checkbox"></th>
                                        <th class = "center-align-format">Menu</th>
                                        <th class = "center-align-format">Parent</th>
                                        <th class = "center-align-format">Description</th>
                                        <th class = "center-align-format">Menu Type</th>
                                        <th class = "center-align-format">Date Modified</th>
                                        <th class = "center-align-format">Status</th>
                                        <th class = "center-align-format">Actions</th>
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
        
    <div class="modal" tabindex="-1" id="add_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Menus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <form style="background-color: white !important; width: 100%;">
                        <div class="mb-3">
                            <label for="menu_name" class="form-label">Menu Name</label>
                            <input type="text" class="form-control" id="menu_name" aria-describedby="menu_name">
                            <small id="menu_name" class="form-text text-muted">* required, must be unique, max 25 characters</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="menu_url" class="form-label">Menu Url</label>
                            <input type="text" class="form-control" id="menu_url" aria-describedby="menu_url">
                            <small id="menu_url" class="form-text text-muted">* required, must be unique, max 50 characters</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="menu_type" class="form-label">Menu Type</label>
                            <br>
                            <select name="menu_type" id="menu_type">
                                <option value="" readonly>Please select...</option>
                                <option value="Module">Module</option>
                                <option value="Group Menu">Group Menu</option>
                            </select>
                            <small id="menu_type" class="form-text text-muted">* required, must be unique, max 50 characters</small>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="status" checked>
                            <label class="form-check-label" for="status">Active</label>
                        </div>
                    </form>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn caution" data-dismiss="modal">Close</button>
                    <button type="button" class="btn save" id="add_data" onclick="validate_data('add_modal', 'save')">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="edit_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Menus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <form style="background-color: white !important; width: 100%;">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="menu_list_id" aria-describedby="menu_list_id" >
                            <label for="menu_name" class="form-label">Menu Name</label>
                            <input type="text" class="form-control" id="menu_name" aria-describedby="menu_name">
                            <small id="menu_name" class="form-text text-muted">* required, must be unique, max 25 characters</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="menu_url" class="form-label">Menu Url</label>
                            <input type="text" class="form-control" id="menu_url" aria-describedby="menu_url">
                            <small id="menu_url" class="form-text text-muted">* required, must be unique, max 50 characters</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="menu_type" class="form-label">Menu Type</label>
                            <br>
                            <select name="menu_type" id="menu_type">
                                <option value="" readonly>Please select...</option>
                                <option id="1" value="Module">Module</option>
                                <option id="2" value="Group Menu">Group Menu</option>
                            </select>
                            <small id="menu_type" class="form-text text-muted">* required, must be unique, max 50 characters</small>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="status" checked>
                            <label class="form-check-label" for="status">Active</label>
                        </div>
                    </form>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn caution" data-dismiss="modal">Close</button>
                    <button type="button" class="btn save" id="edit_data" onclick="validate_data('edit_modal', 'edit')">Save</button>
                </div>
            </div>
        </div>
    </div>


<script>    
var menu_id = "<?=$menu_id;?>";
var query = "status >= 0";
var limit = 10;
var sub_menu_id = 0;
var user_id = '<?=$session->sess_uid;?>';

if (menu_id) {
    //$('.btn_close').show();
    sub_menu_id  = menu_id;
    add_data = "/<?=$menu_id;?>/<?=$menu_group;?>";
}
if(sub_menu_id){
    query = " menu_parent_id = "+ sub_menu_id +" AND status >= 0";
}

$(document).ready(function() {
    get_data();
    get_pagination();
    if (sub_menu_id != 0) {
        $('#add_modal').attr('disabled', true);
    }
});

function get_data()
{
    var url = "<?= base_url("cms/global_controller");?>";
    var data = {
        event : "list",
        select : "id, menu_url, menu_name, default_menu, menu_type, updated_date, status, menu_parent_id",
        query : query,
        offset : offset,
        limit : limit,
        table : "site_menu",
        order : {
            field : "updated_date", //field to order
            order : "desc" //asc or desc
        }
    }
    
    aJax.post(url,data,function(result){
        var result = JSON.parse(result);
        var html = '';
        
        if(result) {
            if (result.length > 0) {
                $.each(result, function(x,y) {
                    html += '<tr>';
                    html += '<td class="hidden"><p class="order" data-order="" data-id='+y.id+'></p></td>';
                    html += '<td><input class = "select"  data-id='+y.id+' type ="checkbox"></td>';
                    
                    if (y.menu_type === "Group Menu") {
                        if (y.menu_type === "Buy Now") {
                            html += '<td><a class="text-primary" href="<?= base_url('cms/site-menu/shop_list');?>">'+y.menu_name+'</a></td>';
                        } else {
                            html += '<td><a class="text-primary" href="<?= base_url('cms/site-menu/menu');?>/'+y.id+'/'+y.menu_name+'" >'+y.menu_name+'</a></td>';
                        }
                    } else {
                        if (parseInt(y.default_menu) === 1) {
                            html += '<td>' +y.menu_name+ ' <b><i>(default)</i></b></td>';
                        } else {
                            html += '<td>' +y.menu_name+ '</td>';
                        }
                    }
                    
                    html += '<td>' + y.menu_parent_id+ '</td>'; 
                    html += '<td>' +y.menu_url+ '</td>'; 
                    html += '<td>'+y.menu_type+ '</td>';
                    html += '<td class = "center-align-format">' + moment(y.updated_date).format('LLL')+ '</td>';
                    if (parseInt(y.status) === 1) {
                        status = 'Active';
                    }
                    else {
                        status = 'Inactive';
                    }
                    
                    html += '<td>'+status+'</td>';
                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                            html+="<td class='center-content' style='width: 25%'>";
                            html+="<a class='btn-sm btn update' onclick=\"edit_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Edit Details'><span class='glyphicon glyphicon-pencil'>Edit</span>";
                            html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Delete Item'><span class='glyphicon glyphicon-pencil'>Delete</span>";
                            html+="<a class='btn-sm btn view' onclick=\"view_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Show Details'><span class='glyphicon glyphicon-pencil'>View</span>";
                            html+="</td>";
                        }
                    html += '</tr>';
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
        table : "site_menu",
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

    $(document).on("click", "#btn_add", function() {
        $("#add_modal").modal('show')
    })

    function validate_data(class_name, action) {
        var invalid = false;
        var errmsg = '';
        var menu_list_id = $("#"+class_name+" #menu_list_id").val()
        var menu_name = $("#"+class_name+" #menu_name").val()
        var menu_url = $("#"+class_name+" #menu_url").val()
        var menu_type = $("#"+class_name+" #menu_type").val()
        var status = $("#"+class_name+" #status").prop('checked')
        if (status) {
            chk_status = 1;
        } else {
            chk_status = 0;
        }

        if (menu_name === '') {
            invalid = true;
            errmsg += 'Menu Name is required<br>'
        }
        if (menu_name > 50) {
            invalid = false;
            errmsg += 'Menu Name is longer than the set character limit(50)<br>'
        }
        if (menu_url === '') {
            invalid = true;
            errmsg += 'Menu URL is required<br>'
        }
        if (menu_type === '') {
            invalid = true;
            errmsg += 'Menu Type is required<br>'
        }
        if (action == 'edit') {
            // console.log(get_menu_id_from_db(menu_url, menu_name)); return;
            if (get_menu_id_from_db(menu_url, menu_name) != menu_list_id){
                // if (is_exists('site_menu', 'menu_name', menu_name, chk_status) !== 0) {
                //     invalid = true;
                //     errmsg += 'This Menu Name already exists!<br>'
                // }
                // if (is_exists('site_menu', 'menu_url', menu_url, chk_status) !== 0) {
                //     invalid = true;
                //     errmsg += 'This Menu URL already exists!<br>'
                // }
            }
        } else {
            // if (is_exists('site_menu', 'menu_name', menu_name, chk_status) !== 0) {
            //     invalid = true;
            //     errmsg += 'This Menu Name already exists!<br>'
            // }
            // if (is_exists('site_menu', 'menu_url', menu_url, chk_status) !== 0) {
            //     invalid = true;
            //     errmsg += 'This Menu URL already exists!<br>'
            // }
        }

        if(invalid) {
            load_swal('', '500px', 'error', 'Error!', errmsg, false, false)
            $("#"+class_name+"").modal('hide')
        } else {
            if (action == 'edit') {
                update_db(menu_name, menu_url, menu_type, menu_list_id, chk_status)
            } else {
                save_to_db(menu_name, menu_url, menu_type, sub_menu_id, chk_status)
            }
            $("#"+class_name+"").modal('hide')
        }
    }

    function get_menu_id_from_db(menu_url, menu_name) {
        var db_id = 0;
        var query = "menu_url = '" + menu_url + "' and menu_name = '"+menu_name+"'";
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, menu_url, menu_name, menu_type, status",
            query : query, 
            limit : 1,
            table : "site_menu"
        }
        aJax.post_async(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(x,y) {
                    db_id = y.id;
                    // console.log(y.id, y.menu_name, y.menu_url, y.menu_type)
                })
            }
        })

        return db_id;
    }

    function save_to_db(menu_name, menu_url, menu_type, sub_menu_id, status) {
        var url = "<?= base_url('cms/global_controller');?>"
        var data = {
            event : "insert", // list, insert, update, delete
            table : "site_menu", //table
            data : {
                menu_name : menu_name,
                menu_url : menu_url,
                menu_type : menu_type,
                status : status,
                menu_parent_id :sub_menu_id,
                created_by : user_id,
                created_date : formatDate(new Date())
            }
        }
    
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            location.reload();
        });
    }

    function update_db(menu_name, menu_url, menu_type, id, chk_status) {
        var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
        var data = {
            event : "update", // list, insert, update, delete
            table : "site_menu", //table
            field : "id",
            where : id, 
            data : {
                menu_name : menu_name,
                menu_url : menu_url,
                updated_by : user_id,
                updated_date : formatDate(new Date()),
                status : chk_status
            }  
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result);
            location.reload();
        });
    }

    function edit_data(id) {
        // check existing in db
        // is_exists(table, field, value, status, site_id)
        view_data(id, 'edit_modal')
    }

    function view_data(inp_id, modal_class) {
        var query = "id = " + inp_id;
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, menu_url, menu_name, menu_type, status",
            query : query, 
            table : "site_menu"
        }
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(x,y) {
                    if (modal_class == 'modal_edit') {
                    }
                    $('#'+modal_class+' #menu_list_id').val(y.id);
                    $('#'+modal_class+' #menu_name').val(y.menu_name);
                    $('#'+modal_class+' #menu_url').val(y.menu_url);
                    // $('#'+modal_class+' #menu_type').val(y.menu_type);
                    if (y.menu_type == "Module") {
                        $('#'+modal_class+' #menu_type #1').attr('selected', true);
                        $('#'+modal_class+' #menu_type #2').attr('selected', false);
                    } else if (y.menu_type == "Group Menu") {
                        $('#'+modal_class+' #menu_type #1').attr('selected', false);
                        $('#'+modal_class+' #menu_type #2').attr('selected', true);
                    } else {
                        $('#'+modal_class+' #menu_type #1').attr('selected', true);
                        $('#'+modal_class+' #menu_type #2').attr('selected', false);
                    }
                    if(y.status == 1) {
                        $('#'+modal_class+' #status').prop('checked', true)
                    } else {
                        $('#'+modal_class+' #status').prop('checked', false)
                    }
                }); 
            }
            
            $('#update_data').attr('data-id', inp_id);
            $('#'+modal_class).modal('show');
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

    function encodeHtmlEntities(str) {
        return $('<div/>').text(str).html();
    }

</script>