<style>
    .rmv-btn {
        border-radius: 20px;
        background-color: #C80000;
        color: white;
        border: 0.5px solid #990000;
        box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5);
    }

    .rmv-btn:disabled {
        border-radius: 20px;
        background-color: gray;
        color: black;
        border: 0.5px solid gray;
        box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5);
    }
    .add_line {
        margin-right: 10px;
        margin-bottom: 10px;
        padding: 10px;
        min-width: 75px;
        max-height: 30px;
        line-height: 0.5;
        background-color: #339933;
        color: white;
        border: 1px solid #267326;
        border-radius: 10px;
        box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5);
    }

    .add_line:disabled {
        background-color: gray !important;
        color: black !important;
    }

    #list-data {
        overflow: visible !important;
        max-height: none !important;
        overflow-x: hidden !important;
        overflow-y: hidden !important;
    }
</style>

    <div class="content-wrapper p-4">
        <div class="card">
            <div class="text-center md-center">
                <b>A G E N C Y</b>
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
                                      <th class='center-content'><input class ="selectall" type ="checkbox"></th>
                                      <th class='center-content'>Agency Code</th>
                                      <th class='center-content'>Agency Description</th>
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
    <div class="modal" tabindex="-1" id="popup_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel">
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
                            <label for="code" class="form-label">Agency Code</label>
                            <input type="text" class="form-control" id="id" aria-describedby="id" hidden>
                            <input type="text" class="form-control required" id="code" maxlength="25" aria-describedby="code">
                            <small id="code" class="form-text text-muted">* required, must be unique, max 25 characters</small>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Agency Description</label>
                            <input type="text" class="form-control required" id="agency" maxlength="50" aria-describedby="description">
                            <small id="description" class="form-text text-muted">* required, must be unique, max 50 characters</small>
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


    <!-- IMPORT MODAL -->
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
                                        <th class='center-content' style='width: 5%'>Line #</th>
                                        <th class='center-content' style='width: 10%'>Agency Code</th>
                                        <th class='center-content' style='width: 20%'>Agency Description</th>
                                        <th class='center-content' style='width: 10%'>Status</th>
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
      var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "list",
            select : "id, code, agency, status, updated_date, created_date",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_agency",
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
                        html += "<td scope=\"col\">" + trimText(y.code, 10) + "</td>";
                        html += "<td scope=\"col\">" + trimText(y.agency, 10) + "</td>";
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

    function get_pagination(query, field = "agency", order = "asc") {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
          event : "pagination",
            select : "id, agency",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_agency",
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
    });

    $(document).on('keydown', '#search_query', function(event) {
        $('.btn_status').hide();
        $(".selectall").prop("checked", false);
        if (event.key == 'Enter') {
            search_input = $('#search_query').val();
            offset = 1;
            new_query = query;
            new_query += ' and code like \'%'+search_input+'%\' or '+query+' and agency like \'%'+search_input+'%\'';
            get_data(new_query);
            get_pagination(new_query);
        }
    });

    $(document).on('click', '#search_button', function(event) {
        $('.btn_status').hide();
        $(".selectall").prop("checked", false);
        search_input = $('#search_query').val();
        offset = 1;
        new_query = query;
        new_query += ' and code like \'%'+search_input+'%\' or '+query+' and agency like \'%'+search_input+'%\'';
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
        
        console.log(query);
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
        modal.loading(false);
    });

    $('#btn_add').on('click', function() {
        open_modal('Add New Agency', 'add', '');
    });

    $('#btn_import').on('click', function() {
        title = addNbsp('IMPORT AGENCY')
        $("#import_modal").find('.modal-title').find('b').html(title)
        $("#import_modal").modal('show')
        clear_import_table()
    });

    function edit_data(id) {
        open_modal('Edit Agency', 'edit', id);
    }

    function view_data(id) {
        open_modal('View Agency', 'view', id);
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
        set_field_state('#code, #agency, #status', isReadOnly);

        $footer.empty();
        if (actions === 'add') $footer.append(buttons.save);
        if (actions === 'edit') $footer.append(buttons.edit);
        $footer.append(buttons.close);

        $modal.modal('show');

        $modal.off('shown.bs.modal').on('shown.bs.modal', function () {
        // Disable background interaction
        $contentWrapper.attr('inert', '');

        // Now it's safe to focus inside the modal
        $(this).find('input, textarea, button, select').filter(':visible:first').focus();
        });

        $modal.off('hidden.bs.modal').on('hidden.bs.modal', function () {
            $contentWrapper.removeAttr('inert');
            if (window.lastFocusedElement) window.lastFocusedElement.focus();
        });
    }

    function reset_modal_fields() {
        $('#popup_modal #code, #popup_modal #agency, #popup_modal').val('');
        $('#popup_modal #status').prop('checked', true);
    }

    function set_field_state(selector, isReadOnly) {
        $(selector).prop({ readonly: isReadOnly, disabled: isReadOnly });
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
        var code = $('#code').val();
        var agency = $('#agency').val();
        var chk_status = $('#status').prop('checked');
        if (chk_status) {
            status_val = 1;
        } else {
            status_val = 0;
        }
        if (id !== undefined && id !== null && id !== '') {
            check_current_db("tbl_agency", ["code", "agency"], [code, agency], "status" , "id", id, true, function(exists, duplicateFields) {
                if (!exists) {
                    modal.confirm(confirm_update_message, function(result){
                        if(result){ 
                                modal.loading(true);
                            save_to_db(code, agency, status_val, id)
                        }
                    });

                }             
            });
        }else{
            check_current_db("tbl_agency", ["code"], [code], "status" , null, null, true, function(exists, duplicateFields) {
                if (!exists) {
                    modal.confirm(confirm_add_message, function(result){
                        if(result){ 
                                modal.loading(true);
                            save_to_db(code, agency, status_val, null)
                        }
                    });

                }                  
            });
        }
    }

    function save_to_db(inp_code, inp_agency, status_val, id) {
        const url = "<?= base_url('cms/global_controller'); ?>";
        let data = {}; 
        let modal_alert_success;
        const now = new Date();
        const start_time = now;
        let valid_data = []; // to log into file

        if (id !== undefined && id !== null && id !== '') {
            modal_alert_success = success_update_message;
            const updated_data = {
                code: inp_code,
                agency: inp_agency,
                updated_date: formatDate(now),
                updated_by: user_id,
                status: status_val
            };

            valid_data.push({
                module: "Agency Module",
                action: "Update",
                remarks: "Updated agency information",
                new_data: JSON.stringify(updated_data),
                old_data: ''
            });

            data = {
                event: "update",
                table: "tbl_agency",
                field: "id",
                where: id,
                data: updated_data
            };
        } else {
            modal_alert_success = success_save_message;
            const inserted_data = {
                code: inp_code,
                agency: inp_agency,
                created_date: formatDate(now),
                created_by: user_id,
                status: status_val
            };

            valid_data.push({
                module: "Agency Module",
                action: "Insert",
                remarks: "Inserted new agency",
                new_data: JSON.stringify(inserted_data),
                old_data: ""
            });

            data = {
                event: "insert",
                table: "tbl_agency",
                data: inserted_data
            };
        }

        aJax.post(url, data, function(result) {
            const obj = is_json(result);
            const end_time = new Date();
            const duration = formatDuration(start_time, end_time);
            //const headers = ['module', 'action', 'remarks', 'new_data', 'old_data'];

            //saveImportDetailsToServer(valid_data, headers, 'agency_logs', function(filePath) {
                const remarks = `
                    Action: ${valid_data[0].action}
                    <br>${valid_data[0].remarks}
                    <br>Start Time: ${formatReadableDate(start_time)}
                    <br>End Time: ${formatReadableDate(end_time)}
                    <br>Duration: ${duration}
                `;
                const link = '-';
                logActivity("agency-module", valid_data[0].action, remarks, link, valid_data[0].new_data, valid_data[0].old_data);
                
                modal.loading(false);
                modal.alert(modal_alert_success, 'success', function () {
                    location.reload();
                });
            //});
        });
    }


    function delete_data(id) {
        get_field_values('tbl_agency', 'code', 'id', [id], function(res) {
            let code = res[id];
            message = is_json(confirm_delete_message);
            message.message = `Delete Agency Code <b><i>${code}</i></b> from Agency Masterfile?`;

            modal.confirm(JSON.stringify(message), function(result){
                if (result) {
                    var url = "<?= base_url('cms/global_controller');?>"; 
                    var data = {
                        event: "list",
                        select: "a.id, a.code, a.agency, COUNT(bra.agency) as agency_count",
                        query: "a.id = " + id, 
                        offset: offset,  
                        limit: limit,   
                        table: "tbl_agency a",
                        join: [
                            {
                                table: "tbl_brand_ambassador bra",
                                query: "bra.agency = a.id",
                                type: "left"
                            }
                        ],
                        group: "a.id, a.code, a.agency"  
                    };

                    aJax.post(url, data, function(response) {
                        console.log("Raw Response:", response);

                        try {
                            var obj = JSON.parse(response);
                            console.log("Parsed Response Data:", obj);

                            if (!Array.isArray(obj)) { 
                                console.error("Invalid response format:", response);
                                modal.alert("Error processing response data.", "error", ()=>{});
                                return;
                            }

                            if (obj.length === 0) {
                                proceed_delete(id); 
                                return;
                            }

                            var Count = Number(obj[0].agency_count) || 0;
                            console.log("Count:", Count);

                            if (Count > 0) { 
                                modal.alert("This item is in use and cannot be deleted.", "error", ()=>{});
                            } else {
                                proceed_delete(id); 
                            }
                        } catch (e) {
                            console.error("Error parsing response:", e, response);
                            modal.alert("Error processing response data.", "error", ()=>{});
                        }
                    });
                }
            });
        });
    }

    function proceed_delete(id) {
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "update",
            table : "tbl_agency",
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

    function populate_modal(inp_id) {
        var query = "status >= 0 and id = " + inp_id;
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, code, agency, status",
            query : query, 
            table : "tbl_agency"
        }
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(index,asc) {
                    $('#id').val(asc.id);
                    $('#code').val(asc.code);
                    $('#agency').val(asc.agency);
                    if(asc.status == 1) {
                        $('#status').prop('checked', true)
                    } else {
                        $('#status').prop('checked', false)
                    }
                }); 
            }
        });
    }

    function addNbsp(inputString) {
        return inputString.split('').map(char => {
            if (char === ' ') {
            return '&nbsp;&nbsp;';
            }
            return char + '&nbsp;';
        }).join('');
    }

    function formatDate(date) {
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-based
      const day = String(date.getDate()).padStart(2, '0');
      const hours = String(date.getHours()).padStart(2, '0');
      const minutes = String(date.getMinutes()).padStart(2, '0');
      const seconds = String(date.getSeconds()).padStart(2, '0');

      // Combine into the desired format
      return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }

    function clear_import_table() {
        $(".import_table").empty()
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

        let jsonData = dataset.map(row => {
            return {
                "Agency Code": row["Agency Code"] || "",
                "Agency Description": row["Agency Description"] || "",
                "Status": row["Status"] || "",
                "Created by": user_id || "", 
                "Created Date": formatDate(new Date()) || ""
            };
        });

        let worker = new Worker(base_url + "assets/cms/js/validator_agency.js");
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
        const overallStart = new Date();
        let batch_size = 5000;
        let total_batches = Math.ceil(valid_data.length / batch_size);
        let batch_index = 0;
        let retry_count = 0;
        let max_retries = 5; 
        let errorLogs = [];
        let url = "<?= base_url('cms/global_controller');?>";
        let table = 'tbl_agency';
        let selected_fields = ['id', 'code', 'agency'];

        //for lookup of duplicate recors
        const matchFields = ["code", "agency"];  
        const matchType = "OR";  //use OR/AND depending on the condition
        modal.loading_progress(true, "Validating and Saving data...");

        // Fetch existing records
        aJax.post(url, { table: table, event: "fetch_existing", selected_fields: selected_fields }, function(response) {
            // let result = JSON.parse(response);
            const result = JSON.parse(response);
            const allEntries = result.existing || [];

            // Build a Set of codes you're importing:
            const codeSet = new Set(valid_data.map(r => r.code));

            // Keep only the rows whose code matches:
            const originalEntries = allEntries.filter(rec => codeSet.has(rec.code));

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

                    const overallEnd = new Date();
                    const duration = formatDuration(overallStart, overallEnd);

                    const remarks = `
                        Action: Import/Update Agency Batch
                        <br>Processed ${valid_data.length} records
                        <br>Errors: ${errorLogs.length}
                        <br>Start: ${formatReadableDate(overallStart)}
                        <br>End: ${formatReadableDate(overallEnd)}
                        <br>Duration: ${duration}
                    `;

                    logActivity("import-agency-module", "Import Batch", remarks, "-", JSON.stringify(valid_data), JSON.stringify(originalEntries));

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
                        // AND Condition: Both fields must match exactly
                        let key = matchFields.map(field => row[field] || "").join("|");
                        if (existingMap.has(key)) {
                            matchedId = existingMap.get(key);
                        }
                    } else {
                        // OR Condition: At least one field should match
                        for (let [key, id] of existingMap.entries()) {
                            let keyParts = key.split("|"); // ["AJK 530", "Marsden F. Hoffman"]

                            // for (let field of matchFields) {
                            //     if (keyParts.includes(row[field])) {  // Check if any field value matches
                            //         matchedId = id;
                            //         break; // Stop as soon as we find a match
                            //     }
                            // }

                            if (keyParts[0] === row["code"]) {
                                matchedId = id;
                                break; // Stop looping once a match is found
                            }

                            // if (matchedId) break; // Stop looping if we found a match
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
                            batch_update(url, updateRecords, "tbl_agency", "id", false, (response) => {
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
                            batch_insert(url, newRecords, "tbl_agency", false, (response) => {
                                if (response.message === 'success') {
                                    updateOverallProgress("Saving Agency...", batch_index + 1, total_batches);
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

            // 
            let td_validator = ['agency code', 'agency description', 'status'];
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

    function trimText(str, length) {
        if (str.length > length) {
            return str.substring(0, length) + "...";
        } else {
            return str;
        }
    }

    $(document).on('click', '.btn_status', function (e) {
        var status = $(this).attr("data-status");
        var modal_obj = "";
        var modal_alert_success = "";
        var hasExecuted = false; // Prevents multiple executions

        var id = '';
        id = $("input.select:checked");
        var code = [];
        var code_string = '';

        id.each(function() {
            code.push(parseInt($(this).attr('data-id')));
        });

        get_field_values('tbl_agency', 'code', 'id', code, function(res) {
            if(code.length == 1) {
                code_string = `Code <i><b>${res[code[0]]}</b></i>`;
            } else {
                code_string = 'selected data'
            }
        })

        if (parseInt(status) === -2) {
            message = is_json(confirm_delete_message);
            message.message = `Delete ${code_string} from Agency Masterfile?`;  
            modal_obj = JSON.stringify(message);
            modal_alert_success = success_delete_message;
        } else if (parseInt(status) === 1) {
            message = is_json(confirm_publish_message);
            message.message = `Publish ${code_string} from Agency Masterfile?`;
            modal_obj = JSON.stringify(message);
            modal_alert_success = success_publish_message;
        } else {
            message = is_json(confirm_unpublish_message);
            message.message = `Unpublish ${code_string} from Agency Masterfile?`;  
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
                        table: "tbl_agency",
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

    function download_template() {
        const headerData = [];

        formattedData = [
            {
                "Agency Code": "",
                "Agency Description": "",
                "Status": "",
                "NOTE:": "Please do not change the column headers."
            }
        ]

        exportArrayToCSV(formattedData, `Masterfile: Agency - ${formatDate(new Date())}`, headerData);
    }

    $(document).on('click', '#btn_export', function () {
        modal.confirm(confirm_export_message,function(result){
            if (result) {
                modal.loading_progress(true, "Reviewing Data...");
                setTimeout(() => {
                    handleExport()
                }, 500);
            }
        })
    })

    function handleExport() {
        var formattedData = [];
        var ids = [];

        $('.select:checked').each(function () {
            var id = $(this).attr('data-id');
            ids.push(`${id}`); // Collect IDs in an array
        });

        const fetchStores = (callback) => {
            const processResponse = (res) => {
                formattedData = res.map(({ 
                    code, agency, status
                }) => ({
                    Code: code,
                    Agency: agency,
                    Status: status === "1" ? "Active" : "Inactive",
                }));
            };

            ids.length > 0 
                ? dynamic_search(
                    "'tbl_agency'", 
                    "''", 
                    "'code, agency, status'", 
                    0, 
                    0, 
                    `'id:IN=${ids.join('|')}'`,  
                    `''`, 
                    `''`,
                    processResponse
                )
                : batch_export();
        };

        const batch_export = () => {
            dynamic_search("'tbl_agency'", "''", "'COUNT(id) as total_records'", 0, 0, `''`,  `''`, `''`, (res) => {
                if (res && res.length > 0) {
                    let total_records = res[0].total_records;
                    console.log(total_records, 'total records');

                    for (let index = 0; index < total_records; index += 100000) {
                        dynamic_search("'tbl_agency'", "''", "'code, agency, status'", 100000, index, `''`,  `''`, `''`, (res) => {
                            console.log(res, 'look here')
                            let newData = res.map(({ 
                                code, agency, status
                            }) => ({
                                "Agency Code": code,
                                "Agency": agency,
                                "Status": status === "1" ? "Active" : "Inactive",
                            }));
                            formattedData.push(...newData); // Append new data to formattedData array
                        })
                    }
                } else {
                    console.log('No data received');
                }
            })
        };

        fetchStores();

        const headerData = [
            ["Company Name: Lifestrong Marketing Inc."],
            ["Masterfile: Agency"],
            ["Date Printed: " + formatDate(new Date())],
            [""],
        ];

        exportArrayToCSV(formattedData, `Masterfile: Agency - ${formatDate(new Date())}`, headerData);
        modal.loading_progress(false);
    }

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