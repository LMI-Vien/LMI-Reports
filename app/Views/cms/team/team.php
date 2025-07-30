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
                                        <th class='center-content'>Team Code</th>
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
                        <label for="code" class="form-label">Team Code</label>
                        <input type="text" class="form-control" id="code" aria-describedby="code" disabled>
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

                        <table class= "table table-bordered listdata">
                            <thead>
                                <tr>
                                    <th class='center-content'>Line #</th>
                                    <th class='center-content'>Team Description</th>
                                    <th class='center-content'>Status</th>
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
    var column_filter = 'code';
    var order_filter = 'order';
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url('cms/global_controller');?>";

    //for importing
    let currentPage = 1;
    let rowsPerPage = 1000;
    let totalPages = 1;
    let dataset = [];

    $(document).ready(function() {
      get_data(query);
      get_pagination(query);
    });

    function get_data(query, field = "code", order = "order") {
      var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "list",
            select : "id, code, team_description, status, updated_date, created_date",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_team",
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
                        var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";

                        html += "<tr class='" + rowClass + "'>";
                        html += "<td class='center-content' style='width: 5%'><input class='select' type=checkbox data-id="+y.id+" onchange=checkbox_check()></td>";
                        html += "<td style='width: 10%'>" + y.code + "</td>";
                        html += "<td style='width: 20%'>" + trimText(y.team_description, 15) + "</td>";
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

    function get_pagination(query, field = "code", order = "order") {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
          event : "pagination",
            select : "id",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_team",
            order : {
                field : field,
                order : order 
            }
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result); 
            modal.loading(false);
            pagination.generate(obj.total_page, ".list_pagination", get_data);
        });
    }

    pagination.onchange(function(){
        offset = $(this).val();
        get_data(query, column_filter, order_filter);
        $('.selectall').prop('checked', false);
        $('.btn_status').hide();
        $("#search_query").val("");
    });

    $(document).on('keydown', '#search_query', function(event) {
        $('.btn_status').hide();
        $(".selectall").prop("checked", false);
        if (event.key == 'Enter') {
            search_input = $('#search_query').val();
            var escaped_keyword = search_input.replace(/'/g, "''"); 
            offset = 1;
            new_query = query;
            new_query += ' and (code like \'%'+escaped_keyword+'%\' or team_description like \'%'+escaped_keyword+'%\')';
            get_data(new_query);
            get_pagination(query);
        }
    });

    $(document).on('click', '#search_button', function(e) {
        $('.btn_status').hide();
        $(".selectall").prop("checked", false);
        search_input = $('#search_query').val();
        var escaped_keyword = search_input.replace(/'/g, "''"); 
        offset = 1;
        new_query = query;
        new_query += ' and (code like \'%'+escaped_keyword+'%\' or team_description like \'%'+escaped_keyword+'%\')';
        get_data(new_query);
        get_pagination(query);
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
        
        get_data(query, column_filter, order_filter);
        get_pagination(query, column_filter, order_filter);
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
        window.lastFocusedElement = document.activeElement;
        $(".form-control").css('border-color','#ccc');
        $(".validate_error_message").remove();
        let $modal = $('#popup_modal');
        let $footer = $modal.find('.modal-footer');
        let $contentWrapper = $('.content-wrapper');

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

        // Disable background content interaction
        $contentWrapper.attr('inert', '');

        // Move focus inside modal when opened
        $modal.on('shown.bs.modal', function () {
            $(this).find('input, textarea, button, select').filter(':visible:first').focus();
        });

        $modal.modal('show');
        $modal.on('hidden.bs.modal', function () {
            $contentWrapper.removeAttr('inert'); 
            if (window.lastFocusedElement) {
                window.lastFocusedElement.focus();
            }
        });
    }

    function reset_modal_fields() {
        $('#popup_modal #code, #popup_modal #team_description, #popup_modal').val('');
        $('#popup_modal #status').prop('checked', true);
        setTimeout(() => {
            $('#popup_modal #code').prop('disabled', true)
        }, 500);
    }

    function clear_import_table() {
        $(".import_table").empty();
    }

    function paginateData(rowsPerPage) {
        totalPages = Math.ceil(dataset.length / rowsPerPage);
        currentPage = 1;
        display_imported_data();
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
            click: onclick_event
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
                    team_description: inp_description,
                    updated_date: formatDate(new Date()),
                    updated_by: user_id,
                    status: status_val
                }
            };
            aJax.post(url,data,function(result){
                var obj = is_json(result);
                modal.loading(false);
                modal.alert(modal_alert_success, 'success', function() {
                    location.reload();
                });
            });
        } else {
            aJax.post(url, { table: "tbl_team", event: "get_last_code", field: "code" }, function(codeResponse) {
                let codeResult = codeResponse;
                let lastCode = null;

                if (codeResult.message === 'success' && codeResult.last_code) {
                    lastCode = codeResult.last_code;
                }
                modal_alert_success = success_save_message;
                function generateNewCode() {
                    let today = new Date();
                    let year = today.getFullYear();
                    let month = String(today.getMonth() + 1).padStart(2, '0');
                    let newSequence = 1;
                    let prefix = `${year}-${month}`;

                    if (lastCode && lastCode.startsWith(`TEAM-${prefix}`)) {
                        let parts = lastCode.replace('TEAM-', '').split('-'); 
                        let lastSequence = parseInt(parts[2], 10);
                        if (!isNaN(lastSequence)) {
                            newSequence = lastSequence + 1;
                        }
                    }

                    return `TEAM-${prefix}-${String(newSequence).padStart(3, '0')}`;
                }

                const newCode = generateNewCode();

                data = {
                    event: "insert",
                    table: "tbl_team",
                    data: {
                        code: newCode,
                        team_description: inp_description,
                        created_date: formatDate(new Date()),
                        created_by: user_id,
                        status: status_val
                    }
                };

                aJax.post(url,data,function(result){
                    var obj = is_json(result);
                    modal.loading(false);
                    modal.alert(modal_alert_success, 'success', function() {
                        location.reload();
                    });
                });
            });
        }
    }

    function save_data(action, id) {
        generateTeamCode(function (generatedCode) {
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
                    
                    check_current_db("tbl_team", ["team_description"], [description], "status" , "id", id, true, function(exists, duplicateFields) {
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
                    code = generatedCode;
                    check_current_db("tbl_team", ["team_description"], [description], "status" , null, null, true, function(exists, duplicateFields) {
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
        });
    }

    function generateTeamCode(callback) {
        const url = "<?= base_url('cms/global_controller'); ?>";
        const now = new Date();
        const year = now.getFullYear();
        const month = ('0' + (now.getMonth() + 1)).slice(-2);

        aJax.post(url, {
            event: "get_last_code",
            table: "tbl_team",
            field: "code"
        }, function (res) {
            const lastCode = res.last_code || '';
            const prefix = `TEAM-${year}-${month}`;
            let newCode = `${prefix}-001`;

            if (lastCode.startsWith(prefix)) {
                const lastSeq = parseInt(lastCode.split('-')[3]) || 0;
                const newSeq = ('000' + (lastSeq + 1)).slice(-3);
                newCode = `${prefix}-${newSeq}`;
            }

            callback(newCode);
        });
    }

    function delete_data(id) {
        get_field_values("tbl_team", "code", "id", [id], (res) => {
            let code = res[id];
            let message = is_json(confirm_delete_message);
            message.message = `Delete <b><i>${code}</i></b> from Team Masterfile?`;

            modal.confirm(JSON.stringify(message),function(result){
                if (result) {
                    var url = "<?= base_url('cms/global_controller');?>"; 
                    var data = {
                        event: "list",
                        select: "t.id, t.code, COUNT(bra.team) AS team_count",
                        query: "t.id = " + id, 
                        offset: offset,  
                        limit: limit,   
                        table: "tbl_team t",
                        join: [
                            {
                                table: "tbl_brand_ambassador bra",
                                query: "bra.team = t.id",
                                type: "left"
                            }
                        ],
                        group: "t.id, t.code"  
                    };

                    aJax.post(url, data, function(response) {

                        try {
                            var obj = JSON.parse(response);

                            if (!obj || obj.length === 0) { 
                                console.error("Invalid or empty response:", response);
                                return;
                            }

                            var teamCount = Number(obj[0].team_count) || 0;

                            if (teamCount > 0) { 
                                modal.alert("This item is in use and cannot be deleted.", "error", ()=>{});
                            } else {
                                proceed_delete(id); 
                            }
                        } catch (e) {
                            console.error("Error parsing response:", e, response);
                        }
                    });
                }
            });
        })
    }

    function proceed_delete(id) {
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

    $(document).on('click', '.btn_status', function (e) {
        var status = $(this).attr("data-status");
        var modal_obj = "";
        var modal_alert_success = "";
        var hasExecuted = false;

        let id = $("input.select:checked");
        let code = [];
        let code_string = "";

        id.each(function () {
            code.push($(this).attr("data-id"));
        })

        get_field_values("tbl_team", "code", "id", code, (res) => {
            if(code.length == 1) {
                code_string = `Code <b><i>${res[code[0]]}</b></i>`;
            }
        })

        if (parseInt(status) === -2) {
            message = is_json(confirm_delete_message);
            message.message = `Delete ${code_string} from Team Masterfile?`;
            modal_obj = JSON.stringify(message);
            modal_alert_success = success_delete_message;
        } else if (parseInt(status) === 1) {
            message = is_json(confirm_publish_message);
            message.message = `Publish ${code_string} from Team Masterfile?`;
            modal_obj = JSON.stringify(message);
            modal_alert_success = success_publish_message;
        } else {
            message = is_json(confirm_unpublish_message);
            message.message = `Unpublish ${code_string} from Team Masterfile?`;
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
                        if (hasExecuted) return; 

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
            const workbook = XLSX.read(data, { type: "binary", raw: true });
            const sheet = workbook.Sheets[workbook.SheetNames[0]];

            let jsonData = XLSX.utils.sheet_to_json(sheet, { raw: true });
            jsonData = jsonData.map(row => {
                let fixedRow = {};
                Object.keys(row).forEach(key => {
                    let value = row[key];
                    if (typeof value === "number") {
                        value = String(value);
                    }

                    fixedRow[key] = value !== null && value !== undefined ? value : "";
                });
                return fixedRow;
            });

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
        if (btn.prop("disabled")) return;

        btn.prop("disabled", true);
        $(".import_buttons").find("a.download-error-log").remove();

        if (dataset.length === 0) {
            modal.alert('No data to process. Please upload a file.', 'error', () => {});
            return;
        }

        modal.loading(true);

        let jsonData = dataset.map(row => {
            return {
                "Team Description": row["Team Description"] || "",
                "Status": row["Status"] || "",
                "Created by": user_id || "", 
                "Created Date": formatDate(new Date()) || ""
            };
        });

        let worker = new Worker(base_url + "assets/cms/js/validator_team.js");
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

            let td_validator = ['team description', 'status'];
            td_validator.forEach(column => {
                html += `<td>${lowerCaseRecord[column] !== undefined ? lowerCaseRecord[column] : ""}</td>`;
            });

            html += "</tr>";
            tr_counter += 1;
        });

        modal.loading(false);
        $(".import_table").html(html);
        updatePaginationControls();
    }

    function saveValidatedData(valid_data) {
        const overallStart = new Date();
        const batch_size = 5000;
        const total_batches = Math.ceil(valid_data.length / batch_size);
        let batch_index = 0;
        let retry_count = 0;
        const max_retries = 5;
        const errorLogs = [];

        const url = "<?= base_url('cms/global_controller');?>";
        const table = 'tbl_team';
        const selected_fields = ['id', 'team_description'];
        const matchFields = ['team_description'];
        const matchType = 'OR';

        modal.loading_progress(true, "Validating and Saving data...");

        aJax.post(url, { table, event: "fetch_existing", selected_fields }, function (response) {
            const result = JSON.parse(response);
            const allEntries = result.existing || [];

            const descSet = new Set(valid_data.map(r => r.team_description.trim().toLowerCase()));

            const originalEntries = allEntries.filter(r =>
                descSet.has(r.team_description)
            );
            let existingMap = new Map();
            allEntries.forEach(record => {
                const key = matchFields.map(field => (record[field] || "")).join("|");
                existingMap.set(key, record.id);
            });

            aJax.post(url, { table, event: "get_last_code", field: "code" }, function (codeResponse) {
                let lastCode = '';
                if (typeof codeResponse === 'string') {
                    codeResponse = JSON.parse(codeResponse);
                }
                if (codeResponse.message === 'success' && codeResponse.last_code) {
                    lastCode = codeResponse.last_code;
                }

                function generateNewCode() {
                    const today = new Date();
                    const year = today.getFullYear();
                    const month = String(today.getMonth() + 1).padStart(2, '0');
                    const prefix = `${year}-${month}`;
                    let newSequence = 1;

                    if (lastCode.startsWith(`TEAM-${prefix}`)) {
                        const parts = lastCode.replace('TEAM-', '').split('-');
                        const lastSequence = parseInt(parts[2], 10);
                        if (!isNaN(lastSequence)) {
                            newSequence = lastSequence + 1;
                        }
                    }

                    lastCode = `TEAM-${prefix}-${String(newSequence).padStart(3, '0')}`;
                    return lastCode;
                }

                function updateOverallProgress(stepName, completed, total) {
                    const progress = Math.round((completed / total) * 100);
                    updateSwalProgress(stepName, progress);
                }

                function processNextBatch() {
                    if (batch_index >= total_batches) {
                        modal.loading_progress(false);

                        const overallEnd = new Date();
                        const duration = formatDuration(overallStart, overallEnd);

                        const remarks = `
                            Action: Import/Update Team Batch
                            <br>Processed ${valid_data.length} records
                            <br>Errors: ${errorLogs.length}
                            <br>Start: ${formatReadableDate(overallStart)}
                            <br>End: ${formatReadableDate(overallEnd)}
                            <br>Duration: ${duration}
                        `;

                        logActivity("import-team-module", "Import Batch", remarks, "-", JSON.stringify(valid_data), JSON.stringify(originalEntries));
                        if (errorLogs.length > 0) {
                            createErrorLogFile(errorLogs, "Update_Error_Log_" + formatReadableDate(new Date(), true));
                            modal.alert("Some records encountered errors. Check the log.", 'info', () => { });
                        } else {
                            modal.alert("All records saved/updated successfully!", 'success', () => location.reload());
                        }
                        return;
                    }

                    const batch = valid_data.slice(batch_index * batch_size, (batch_index + 1) * batch_size);
                    const newRecords = [];
                    const updateRecords = [];

                    batch.forEach(row => {
                        let matchedId = null;

                        if (matchType === "AND") {
                            const key = matchFields.map(field => row[field] || "").join("|");
                            if (existingMap.has(key)) {
                                matchedId = existingMap.get(key);
                            }
                        } else {
                            for (let [key, id] of existingMap.entries()) {
                                const keyParts = key.split("|");
                                let match = matchFields.some((field, i) => keyParts[i] === row[field]);
                                if (match) {
                                    matchedId = id;
                                    break;
                                }
                            }
                        }

                        if (matchedId) {
                            row.id = matchedId;
                            row.updated_date = formatDate(new Date());
                            delete row.created_date;
                            updateRecords.push(row);
                        } else {
                            row.code = generateNewCode();
                            row.created_by = user_id;
                            row.created_date = formatDate(new Date());
                            newRecords.push(row);
                        }
                    });

                    function processUpdates() {
                        return new Promise((resolve) => {
                            if (updateRecords.length > 0) {
                                batch_update(url, updateRecords, table, "id", false, (response) => {
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
                                batch_insert(url, newRecords, table, false, (response) => {
                                    if (response.message !== 'success') {
                                        errorLogs.push(`Batch insert failed: ${JSON.stringify(response.error)}`);
                                    }
                                    updateOverallProgress("Saving Team...", batch_index + 1, total_batches);
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
                            const wait_time = Math.pow(2, retry_count) * 1000;
                            setTimeout(() => {
                                processInserts().then(() => {
                                    batch_index++;
                                    retry_count = 0;
                                    processNextBatch();
                                }).catch(handleSaveError);
                            }, wait_time);
                        } else {
                            modal.alert('Failed to save data after multiple attempts. Please check your connection and try again.', 'error', () => { });
                        }
                    }

                    processUpdates()
                        .then(processInserts)
                        .then(() => {
                            batch_index++;
                            setTimeout(processNextBatch, 300);
                        })
                        .catch(handleSaveError);
                }

                processNextBatch();
            });
        });
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
    
    function download_template() {
        const headerData = [];

        formattedData = [
            {
                "Team Description": "",
                "Status": "",
                "NOTE:": "Please do not change the column headers."
            }
        ]

        exportArrayToCSV(formattedData, `Masterfile: Team - ${formatDate(new Date())}`, headerData);
    }

    $(document).on('click', '#btn_export', function () {
        modal.confirm(confirm_export_message,function(result){
            if (result) {
                modal.loading_progress(true, "Reviewing Data...");
                setTimeout(() => {
                    exportTeam()
                }, 500);
            }
        })
    })

    const exportTeam = () => {
        var ids = [];

        $('.select:checked').each(function () {
            var id = $(this).attr('data-id');
            ids.push(`'${id}'`);
        });
        const params = new URLSearchParams();
        ids.length > 0 ? 
            params.append('selectedids', ids.join(',')) :
            params.append('selectedids', '0');

        window.open("<?= base_url('cms/');?>" + 'team/export-team?'+ params.toString(), '_blank');
        modal.loading_progress(false);
    }

    function exportArrayToCSV(data, filename, headerData) {
        const worksheet = XLSX.utils.json_to_sheet(data, { origin: headerData.length });
        XLSX.utils.sheet_add_aoa(worksheet, headerData, { origin: "A1" });
        const csvContent = XLSX.utils.sheet_to_csv(worksheet);
        const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
        saveAs(blob, filename + ".csv");
    }

</script>