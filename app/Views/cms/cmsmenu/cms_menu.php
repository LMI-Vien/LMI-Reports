<style>
    .hidden {
        display: none;
    }
</style>

<div class="content-wrapper p-4">
    <div class="card">
        <div class="text-center page-title md-center">
            <b>C M S - M E N U</b>
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
                                    <th class = "w-10"><input class ="selectall" type ="checkbox"></th>
                                    <th class = "center-align-format">Menu Name</th>
                                    <th class = "center-align-format">Parent Name</th>
                                    <th class = "center-align-format">Menu URL</th>
                                    <th class = "center-align-format">Menu Type</th>
                                    <th class = "center-align-format">Date Created</th>
                                    <th class = "center-align-format">Modified Date</th>
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
                            <option value="2">Module</option>
                            <option value="1">Group Menu</option>
                        </select>
                        <small id="menu_type_small" class="form-text text-muted">* required, must be unique, max 50 characters</small>
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


<script>
    var menu_id = "<?=$menu_id;?>";
    var query = "status >= 0 and menu_parent_id = 0";
    var limit = 10;
    var sub_menu_id = 0;
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url("cms/global_controller");?>";

    if (menu_id) {
        sub_menu_id  = menu_id;
        add_data = "/<?=$menu_id;?>/<?=$menu_group;?>";
    }

    if(sub_menu_id){
        query = " menu_parent_id = "+ sub_menu_id +" AND status >= 0";
    }

    $(document).ready(() => {
        get_data(query);
        get_pagination();
        if (sub_menu_id != 0) {
            $('#add_modal').attr('disabled', true);
        }
    });

    function get_data(query) {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "list",
            select : "id, menu_name, menu_url, menu_icon, menu_type, menu_parent_id, status, updated_date, created_date",
            query : query,
            offset : offset,
            limit : limit,
            table : "cms_menu",
            order : {
                field : "updated_date", //field to order
                order : "desc" //asc or desc
            }
        }
        
        aJax.post(url,data,(result) => {
            var result = JSON.parse(result);
            var html = '';
            
            if(result) {
                if (result.length > 0) {
                    let menu_id_list = [];
                    let menu_mapping = {};

                    $.each(result, (x,y) => {
                        menu_id_list.push(y.menu_parent_id,);
                    })
                    get_field_values('cms_menu', 'menu_name', 'id', menu_id_list, (res)=>{
                        $.each(res, (x,y) => {
                            menu_mapping[x] = y;
                        })
                        menu_mapping[0] = ''
                    })

                    $.each(result, (x,y) => {
                        html += '<tr>';
                        html += '<td class="hidden"><p class="order" data-order="" data-id='+y.id+'></p></td>';
                        html += '<td><input class = "select"  data-id='+y.id+' type ="checkbox"></td>';
                        
                        if (y.menu_type === "1") {
                            if (y.menu_type === "Buy Now") {
                                html += '<td><a class="text-primary" href="<?= base_url('cms/cms-menu/shop_list');?>">'+y.menu_name+'</a></td>';
                            } else {
                                html += '<td><a class="text-primary" href="<?= base_url('cms/cms-menu/menu');?>/'+y.id+'/'+y.menu_name+'" >'+y.menu_name+'</a></td>';
                            }
                        } else {
                            if (parseInt(y.default_menu) === 1) {
                                html += '<td>' +y.menu_name+ ' <b><i>(default)</i></b></td>';
                            } else {
                                html += '<td>' +y.menu_name+ '</td>';
                            }
                        }
                        
                        let updated_date = y.updated_date ? formatReadableDate(y.updated_date, true) : 'N/A';
                        html += '<td>' + menu_mapping[y.menu_parent_id] + '</td>'; 
                        html += '<td>' +y.menu_url+ '</td>'; 
                        // html += '<td>'+y.menu_type+ '</td>';
                        html += '<td>' + (y.menu_type == 1 ? 'Group Menu' : y.menu_type == 2 ? 'Module' : 'Unknown') + '</td>';
                        html += '<td class = "center-align-format">' + formatReadableDate(y.created_date, true) + '</td>';
                        html += '<td class = "center-align-format">' + updated_date + '</td>';
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
                                html+="<a class='btn-sm btn update' onclick=\"edit_data('"+y.id+"', '"+y.menu_parent_id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Edit Details'><span class='glyphicon glyphicon-pencil'>Edit</span>";
                                html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Delete Item'><span class='glyphicon glyphicon-pencil'>Delete</span>";
                                html+="<a class='btn-sm btn view' onclick=\"view_data('"+y.id+"', '"+y.menu_parent_id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Show Details'><span class='glyphicon glyphicon-pencil'>View</span>";
                                html+="</td>";
                            }
                        html += '</tr>';
                    });
                }
                else {
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
            table : "cms_menu",
            order : {
                field : "id", //field to order
                order : "asc" //asc or desc
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
        modal.loading(false);
    });

    $(document).on('keydown', '#search_query', function(event) {
        if (event.key == 'Enter') {
            search_input = $('#search_query').val();
            offset = 1;
            new_query = '';
            new_query += query+' and menu_name like \'%'+search_input+'%\' or '
            new_query += query+' and menu_url like \'%'+search_input+'%\' or '
            new_query += query+' and menu_parent_id like \'%'+search_input+'%\'';
            get_data(new_query);
            get_pagination();
        }
    });

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
                        table: "cms_menu",
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

    $(document).on("click", "#btn_add", function() {
        open_modal('Add Site Menu', 'add', '', sub_menu_id)
    })

    function edit_data(id, parent) {
        open_modal('Edit Site Menu', 'edit', id, parent);
    }

    function view_data(id, parent) {
        open_modal('View Site Menu', 'view', id, parent);
    }

    function delete_data(id) {
        modal.confirm(confirm_delete_message,function(result){
            if(result){
                var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
                var data = {
                    event : "update", // list, insert, update, delete
                    table : "cms_menu", //table
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

    function open_modal(msg, actions, id, parent) {
        let modal = $('#popup_modal');
        let body = modal.find('.modal-body')
        let form = body.find('#form-modal')
        let dropdown = form.find(".type-dropdown")
        let footer = modal.find('.modal-footer');

        reset_modal_fields();

        modal.find('.modal-title b').html(addNbsp(msg));

        html = '';
        html+= `<label for="menu_type" class="form-label">Menu Type</label>
        <input type="text" class="form-control" id="type_val" aria-describedby="type_val" hidden>
        <select name="menu_type" class="form-control required" id="menu_type">
        <option value="">Select Option</option>
        <option class="mod" value="2">Module</option>
        <option class="grp" value="1">Group Menu</option>
        </select>
        <small class="form-text text-muted">* required</small>`

        if (sub_menu_id === 0) {
            dropdown.empty()
            dropdown.append(html)
        }

        var table = 'cms_menu';
        var selected_fields = ['id', 'menu_url', 'menu_name'];
        var haystack = ['id', 'menu_parent_id'];
        var needle = [
            [id, parent]
        ]

        let buttons = {
            save: create_button('Save', 'save_data', 'btn save', () => {
                if (validate.standard("form-modal")) {
                    save_data('save', null);
                }
            }),
            edit: create_button('Update', 'edit_data', 'btn update', () => {
                if (validate.standard("form-modal")) {
                    save_data('update', id);
                }
            }),
            close: create_button('Close', 'close_data', 'btn caution', () => {
                modal.modal('hide');
            })
        };

        if (['edit', 'view'].includes(actions)) populate_modal(id);

        let isReadOnly = actions === 'view';
        set_field_state('#menu_name, #menu_url, #menu_type, #status', isReadOnly);

        footer.empty();
        if (actions === 'add') footer.append(buttons.save);
        if (actions === 'edit') footer.append(buttons.edit);
        footer.append(buttons.close);

        modal.modal('show');
    }

    function reset_modal_fields() {
        $('#menu_name').val('');
        $('#menu_url').val('');
        $('#menu_type .mod').attr('selected', false);
        $('#menu_type .grp').attr('selected', false);
        $('#status').prop('checked', true);
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

    function save_data(action, id) {
        var menu_name = $('#menu_name').val();
        var menu_url = $('#menu_url').val();
        var menu_drop = $('#menu_type').val();
        var chk_status = $('#status').prop('checked');

        if (menu_drop == 2) {
            menu_type = '2'
        } else if (menu_drop == 1) {
            menu_type = '1'
        } else {
            menu_type = 'error!'
        }

        if (sub_menu_id != 0) {
            menu_type = '2'
        }
        
        if (chk_status) {
            status = '1'
        } else {
            status = '0'
        }
        if (id !== undefined && id !== null && id !== '') {
            db_fields = ["id", "menu_name", "menu_url"];
            input_fields = [id, menu_name, menu_url];
            excludeField = "id";
            excludeId = id;
        } else {
            db_fields = ["menu_name", "menu_url"];
            input_fields = [menu_name, menu_url];
            excludeField = null;
            excludeId = null;
        }
    
        check_current_db("cms_menu", db_fields, input_fields, "status" , excludeField, excludeId, true, function(exists, duplicateFields) {
            if(!exists) {
                if (id !== undefined && id !== null && id !== '') {
                    modal.confirm(confirm_update_message,function(result){
                        if(result) {
                            save_to_db(menu_name, menu_url, menu_type, sub_menu_id, status, id)
                        }
                    })
                } else {
                    modal.confirm(confirm_add_message,function(result){
                        if (result) {
                            save_to_db(menu_name, menu_url, menu_type, sub_menu_id, status, null)
                        }
                    })
                }
            }
        });
    }

    function populate_modal(id) {
        var query = "status >= 0 and id = " + id;
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, menu_url, menu_name, menu_type, status",
            query : query, 
            table : "cms_menu"
        }
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(index,d) {
                    $('#id').val(d.id);
                    $('#menu_name').val(d.menu_name);
                    $('#menu_url').val(d.menu_url);
                    if (d.menu_type === 'Module') {
                        $('#menu_type .mod').attr('selected', true);
                        $('#menu_type .grp').attr('selected', false);
                    } else {
                        $('#menu_type .mod').attr('selected', false);
                        $('#menu_type .grp').attr('selected', true);
                    }
                    if(d.status == 1) {
                        $('#status').prop('checked', true)
                    } else {
                        $('#status').prop('checked', false)
                    }
                }); 
            }
        });
    }

    function set_field_state(selector, isReadOnly) {
        $(selector).prop({ readonly: isReadOnly, disabled: isReadOnly });
    }

    function save_to_db(menu_name, menu_url, menu_type, sub_menu_id, status, id) {
        var url = "<?= base_url('cms/global_controller');?>"
        if (id !== undefined && id !== null && id !== '') {
            var data = {
                event: "update",
                table: "cms_menu",
                field: "id",
                where: id,
                data: {
                    menu_name: menu_name,
                    menu_url: menu_url,
                    menu_type: menu_type,
                    updated_date: formatDate(new Date()),
                    updated_by: user_id,
                    status: status
                }
            }
        } else {
            var data = {
                event : "insert", // list, insert, update, delete
                table : "cms_menu", // table
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
        }
    
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            location.reload();
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

    function encodeHtmlEntities(str) {
        return $('<div/>').text(str).html();
    }

    function addNbsp(inputString) {
        return inputString.split('').map(char => {
            if (char === ' ') {
            return '&nbsp;&nbsp;';
            }
            return char + '&nbsp;';
        }).join('');
    }

</script>