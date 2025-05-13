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
            <b>Y E A R</b>
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
                        <table class="table table-bordered listdata">
                            <thead>
                                <tr>
                                    <th class='center-content'><input class="selectall" type="checkbox"></th>
                                    <th class='center-content'>Year</th>
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
                            <?= $optionSet; ?>
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
    <div class="modal-dialog modal-l">
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
                        <label for="code" class="form-label">Year</label>
                        <input type="text" class="form-control required numbersonly" id="year" aria-describedby="year">
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


<script>
    var query = "status >= 0";
    var column_filter = '';
    var order_filter = '';
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url("cms/global_controller");?>";
    var base_url = '<?= base_url();?>';

    $(document).ready(function() {
      get_data(query);
      get_pagination(query);
    });

    function get_data(query, field = "id", order = "asc") {
      var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "list",
            select : "id, year, status, sort_order, updated_date, created_date",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_year",
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
                        html += "<td scope=\"col\">" + trimText(y.year, 10) + "</td>";
                        html += "<td scope=\"col\">" +status+ "</td>";
                        html += "<td class='center-content' scope=\"col\">" + (y.created_date ? ViewDateformat(y.created_date) : "N/A") + "</td>";
                        html += "<td class='center-content' scope=\"col\">" + (y.updated_date ? ViewDateformat(y.updated_date) : "N/A") + "</td>";

                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                          html+="<td class='center-content' scope=\"col\">";
                          html+="<a class='btn-sm btn save' onclick=\"edit_data('"+y.id+"')\" data-status='"
                            +y.status+"' id='"+y.id+"' title='Edit Details'><span class='glyphicon glyphicon-pencil'>Edit</span>";
                          html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.id+"')\" data-status='"
                            +y.status+"' id='"+y.id+"' title='Delete Details'><span class='glyphicon glyphicon-pencil'>Delete</span>";
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

    function get_pagination(query, field = "id", order = "asc") {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
          event : "pagination",
            select : "id",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_year",
            order : {
                field : field, //field to order
                order : order //asc or desc
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
            offset = 1;
            get_pagination(query);
            new_query = query;
            new_query += ' and year like \'%'+search_input+'%\'';
            get_data(new_query);
        }
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

    $(document).on('click', '#search_button', function(event) {
        $('.btn_status').hide();
        $(".selectall").prop("checked", false);
        search_input = $('#search_query').val();
        offset = 1;
        get_pagination(query);
        new_query = query;
        new_query += ' and year like \'%'+search_input+'%\'';
        get_data(new_query);
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
        get_pagination(query);
        modal.loading(false);
    });

    $(document).on('click', '#btn_add', function() {
        open_modal('Add New Year', 'add', '');
    });

    function edit_data(id) {
        open_modal('Edit Year', 'edit', id);
    }

    function view_data(id) {
        open_modal('View Year', 'view', id);
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
        set_field_state('#year, #status', isReadOnly);

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

        // Fix focus issue when modal is hidden
        $modal.on('hidden.bs.modal', function () {
            $contentWrapper.removeAttr('inert');  // Re-enable background interaction
            if (window.lastFocusedElement) {
                window.lastFocusedElement.focus();
            }
        });
    }

    function reset_modal_fields() {
        $('#popup_modal #year').val('');
        $('#popup_modal #status').prop('checked', true);
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
            select : "id, year, status",
            query : query, 
            table : "tbl_year"
        }
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(index,d) {
                    $('#id').val(d.id);
                    $('#year').val(d.year);
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

    function save_to_db(inp_year, status_val, id) {
        const url = "<?= base_url('cms/global_controller'); ?>";
        let data = {}; 
        let modal_alert_success;

        if (id !== undefined && id !== null && id !== '') {
            modal_alert_success = success_update_message;
            data = {
                event: "update",
                table: "tbl_year",
                field: "id",
                where: id,
                data: {
                    year: inp_year,
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
            get_last_sort_order(function(new_sort_order) {
                modal_alert_success = success_save_message;
                    data = {
                        event: "insert",
                        table: "tbl_year",
                        data: {
                            year: inp_year,
                            sort_order: new_sort_order,
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
        var year = $('#year').val();
        var chk_status = $('#status').prop('checked');
        if (chk_status) {
            status_val = 1;
        } else {
            status_val = 0;
        }
        if(validate.standard("form-save-modal")){
            if (id !== undefined && id !== null && id !== '') {
                check_current_db("tbl_year", ["year"], [year], "status" , "id", id, true, function(exists, duplicateFields) {
                    if (!exists) {
                        modal.confirm(confirm_update_message, function(result){
                            if(result){ 
                                    modal.loading(true);
                                save_to_db(year, status_val, id)
                            }
                        });
    
                    }             
                });
            }else{
                check_current_db("tbl_year", ["year"], [year], "status" , null, null, true, function(exists, duplicateFields) {
                    if (!exists) {
                        modal.confirm(confirm_add_message, function(result){
                            if(result){ 
                                    modal.loading(true);
                                save_to_db(year, status_val, null)
                            }
                        });
    
                    }                  
                });
            }
        }
    }

    function delete_data(id) {
        get_field_values("tbl_year", "year", "id", [id], (res) => {
            let code = res[id];
            let message = is_json(confirm_delete_message);
            message.message = `Delete year <b><i>${code}</i></b> from Year Masterfile?`;

            modal.confirm(JSON.stringify(message),function(result){
                if(result){ 
                    var url = "<?= base_url('cms/global_controller');?>";
                    var data = {
                        event : "update",
                        table : "tbl_year",
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
        })
    }

    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0'); 
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');

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
        var hasExecuted = false;

        let id = $("input.select:checked");
        let code = [];
        let code_string = "selected data";

        id.each(function() {
            code.push($(this).attr("data-id"));
        });

        get_field_values("tbl_year", "year", "id", code, (res) => {
            if(code.length == 1) {
                code_string = `year <b><i>${res[code[0]]}</i></b>`;
            }
        })

        if (parseInt(status) === -2) {
            message = is_json(confirm_delete_message);
            message.message = `Delete ${code_string} from Year Masterfile?`;
            modal_obj = JSON.stringify(message);
            modal_alert_success = success_delete_message;
        } else if (parseInt(status) === 1) {
            message = is_json(confirm_publish_message);
            message.message = `Publish ${code_string} from Year Masterfile?`;
            modal_obj = JSON.stringify(message);
            modal_alert_success = success_publish_message;
        } else {
            message = is_json(confirm_unpublish_message);
            message.message = `Unpublish ${code_string} from Year Masterfile?`;
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
                        table: "tbl_year",
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

            let td_validator = ['code', 'team_description', 'status'];
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

    function get_last_sort_order(callback) {
      var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "list",
            select : "id, MAX(sort_order) AS last_sort_order",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_year",
        }

        aJax.post(url, data, function(result) {
            console.log(result);
            // return;
            var obj = is_json(result);
            if (obj && obj.length > 0 && obj[0].last_sort_order !== null) {
                callback(parseInt(obj[0].last_sort_order, 10) + 1);
            } else {
                callback(1);
            }
        });
    }


</script>