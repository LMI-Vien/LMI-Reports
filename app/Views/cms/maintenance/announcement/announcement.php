<style>
    #list-data {
        overflow: visible !important;
        max-height: none !important;
        overflow-x: hidden !important;
        overflow-y: hidden !important;
    }

    .table-responsive-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .table-responsive-wrapper table {
        min-width: 1000px; /* Adjust based on your actual content */
        width: 100%;
        border-collapse: collapse;
    }

</style>

<div class="content-wrapper p-4">
    <div class="card">
        <div class="text-center page-title md-center">
            <b>A N N O U N C E M E N T S</b>
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
                            <div class="table-responsive-wrapper">
                                <table class="table table-bordered listdata">
                                    <thead>
                                        <tr>
                                            <th class='center-content'><input class="selectall" type="checkbox"></th>
                                            <th class='center-content'>Title</th>
                                            <th class='center-content'>Description 1</th>
                                            <th class='center-content'>Description 2</th>
                                            <th class='center-content'>Description 3</th>
                                            <th class='center-content'>Start Date</th>
                                            <th class='center-content'>End Date</th>
                                            <th class='center-content'>Status</th>
                                            <th class='center-content'>Date Created</th>
                                            <th class='center-content'>Date Modified</th>
                                            <th class='center-content'>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table_body word_break"></tbody>
                                </table>
                            </div>
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
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control required" id="title" aria-describedby="title">
                    </div>
                    <div class="mb-3">
                        <label for="desc_1" class="form-label">Description 1</label>
                        <textarea class="form-control required" id="desc_1" aria-describedby="desc_1"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="desc_2" class="form-label">Description 2</label>
                        <textarea class="form-control" id="desc_2" aria-describedby="desc_2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="desc_3" class="form-label">Description 3</label>
                        <textarea class="form-control" id="desc_3" aria-describedby="desc_3"></textarea>
                    </div>
                    <!-- <div class="mb-3">
                        <label for="ban_1" class="form-label">Banner 1</label>
                        <input type="text" class="form-control required" id="ban_1" aria-describedby="ban_1">
                    </div>
                    <div class="mb-3">
                        <label for="ban_2" class="form-label">Banner 2</label>
                        <input type="text" class="form-control required" id="ban_2" aria-describedby="ban_2">
                    </div> -->
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="datetime-local" class="form-control required" id="start_date" aria-describedby="start_date">
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="datetime-local" class="form-control required" id="end_date" aria-describedby="end_date">
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
    var url = "<?= base_url('cms/global_controller');?>";

    $(document).ready(function() {
        get_data(query);
        get_pagination(query);

        const today = new Date();
        today.setMinutes(today.getMinutes() - today.getTimezoneOffset()); 
        const todayStr = today.toISOString().slice(0, 16);  

        $('#start_date').attr('min', todayStr);

        $('#start_date').on('input', function () {
            const startDateValue = $(this).val();
            $('#end_date').attr('min', startDateValue);  
        });

        $('#end_date').on('input', function () {
            const startDateValue = $('#start_date').val();
            const endDateValue = $(this).val();
            
            if (endDateValue && endDateValue < startDateValue) {
                alert("End date cannot be before the start date.");
                $(this).val(""); 
            }
        });
    });     

    function get_data(query, field = "id", order = "order") {
      var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "list",
            select : "id, title, description_1, description_2, description_3, start_date, end_date, status, updated_date, created_date",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_announcements",
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
                        html += "<td style='width: 10%'>" + y.title + "</td>";
                        html += "<td style='width: 20%'>" + trimText(y.description_1) + "</td>";
                        html += "<td style='width: 20%'>" + trimText(y.description_2) + "</td>";
                        html += "<td style='width: 20%'>" + trimText(y.description_3) + "</td>";
                        // html += "<td style='width: 10%'>" + y.banner_1 + "</td>";
                        // html += "<td style='width: 10%'>" + y.banner_2 + "</td>";
                        html += "<td class='center-content' style='width: 10%'>" + (y.start_date ? ViewDateformat(y.start_date) : "N/A") + "</td>";
                        html += "<td class='center-content' style='width: 10%'>" + (y.end_date ? ViewDateformat(y.end_date) : "N/A") + "</td>";
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
        set_field_state('#title, #desc_1, #desc_2, #desc_3, #start_date, #end_date', isReadOnly);

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

    $(document).on('click', '#btn_add', function() {
        open_modal('Add Announcement', 'add', '');
    });

    function edit_data(id) {
        open_modal('Edit Announcement', 'edit', id);
    }

    function view_data(id) {
        open_modal('View Announcement', 'view', id);
    }

    function reset_modal_fields() {
        // $('#popup_modal #title, #popup_modal #desc_1, #popup_modal #desc_2, #popup_modal #desc_3, #popup_modal #start_date, #popup_modal #end_date, #popup_modal').val('');
        $('#popup_modal').find('#title, #desc_1, #desc_2, #desc_3, #start_date, #end_date').val('');
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

    function populate_modal(inp_id) {
        var query = "status >= 0 and id = " + inp_id;
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, title, description_1, description_2, description_3, start_date, end_date, status",
            query : query, 
            table : "tbl_announcements"
        }
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(index,d) {
                    $('#title').val(d.title);
                    $('#desc_1').val(d.description_1);
                    $('#desc_2').val(d.description_2);
                    $('#desc_3').val(d.description_3);
                    // $('#ban_1').val(d.banner_1);
                    // $('#ban_2').val(d.banner_2);
                    $('#start_date').val(d.start_date);
                    $('#end_date').val(d.end_date);

                }); 
            }
        });
    }

    function save_data(action, id) {
        var title = $('#title').val();
        var desc_1 = $('#desc_1').val();
        var desc_2 = $('#desc_2').val();
        var desc_3 = $('#desc_3').val();
        // var ban_1 = $('#ban_1').val();
        // var ban_2 = $('#ban_2').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();

        if(validate.standard("popup_modal")){
            if (id !== undefined && id !== null && id !== '') {
                check_current_db("tbl_announcements", ["title", "description_1", "description_2", "description_3", "start_date", "end_date"], [title, desc_1, desc_2, desc_3, start_date, end_date], "status" , "id", id, true, function(exists, duplicateFields) {
                    if (!exists) {
                        modal.confirm(confirm_update_message, function(result){
                            if(result){ 
                                    modal.loading(true);
                                save_to_db(title, desc_1, desc_2, desc_3, start_date, end_date, id)
                            }
                        });
    
                    }             
                });
            }else{
                check_current_db("tbl_announcements", ["title", "description_1", "description_2", "description_3", "start_date", "end_date"], [title, desc_1, desc_2, desc_3, start_date, end_date], "status" , null, null, true, function(exists, duplicateFields) {
                    if (!exists) {
                        modal.confirm(confirm_add_message, function(result){
                            if(result){ 
                                    modal.loading(true);
                                save_to_db(title, desc_1, desc_2, desc_3, start_date, end_date, null)
                            }
                        });
    
                    }                  
                });
            }
        }
    }

    function save_to_db(inp_title, inp_desc1, inp_desc2, inp_desc3, inp_startDate, inp_endDate, id) {
        const url = "<?= base_url('cms/global_controller'); ?>";
        let data = {}; 
        let modal_alert_success;

        if (id !== undefined && id !== null && id !== '') {
            modal_alert_success = success_update_message;
            data = {
                event: "update",
                table: "tbl_announcements",
                field: "id",
                where: id,
                data: {
                    title: inp_title,
                    description_1: inp_desc1,
                    description_2: inp_desc2,
                    description_3: inp_desc3,
                    // banner_1: inp_banner1,
                    // banner_2: inp_banner2,
                    start_date: inp_startDate,
                    end_date: inp_endDate,
                    updated_date: formatDate(new Date()),
                    updated_by: user_id,
                    status: '1',
                }
            };
        } else {
            modal_alert_success = success_save_message;
            data = {
                event: "insert",
                table: "tbl_announcements",
                data: {
                    title: inp_title,
                    description_1: inp_desc1,
                    description_2: inp_desc2,
                    description_3: inp_desc3,
                    // banner_1: inp_banner1,
                    // banner_2: inp_banner2,
                    start_date: inp_startDate,
                    end_date: inp_endDate,
                    created_date: formatDate(new Date()),
                    created_by: user_id,
                    status: '1',
                }
            };
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result);
            modal.loading(false);
            modal.alert(modal_alert_success, 'success', function() {
                location.reload();
            });
        });
    }

    function delete_data(id) {
        get_field_values("tbl_announcements", "title", "id", [id], (res) => {
            let title = res[id];
            let message = is_json(confirm_delete_message);
            message.message = `Delete <b><i>${title}</i></b> from Announcements?`

            modal.confirm(JSON.stringify(message),function(result){
                if(result){
                    var url = "<?= base_url('cms/global_controller');?>";
                    var data = {
                        event : "update",
                        table : "tbl_announcements",
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

    function get_pagination(query, field = "updated_date", order = "desc") {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
          event : "pagination",
            select : "id",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_announcements",
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
            offset = 1;
            get_pagination(query);
            new_query = query;
            new_query += ' and title like \'%'+search_input+'%\'';
            get_data(new_query);
        }
    });

    $(document).on('click', '#search_button', function(e) {
        $('.btn_status').hide();
        $(".selectall").prop("checked", false);
        search_input = $('#search_query').val();
        offset = 1;
        get_pagination(query);
        new_query = query;
        new_query += ' and title like \'%'+search_input+'%\'';
        get_data(new_query);
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
        
        console.log(order_filter, column_filter);
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

        get_field_values("tbl_announcements", "title", "id", code, (res) => {
            if(code.length == 1) {
                code_string = `<b><i>${res[code[0]]}</b></i>`;
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
                        table: "tbl_announcements",
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



</script>