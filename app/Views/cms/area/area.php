
    <div class="content-wrapper p-4">
        <div class="card">
            <div class="text-center page-title md-center">
                <b>A R E A</b>
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
                                        <th class='center-content'>Code</th>
                                        <th class='center-content'>Area Description</th>
                                        <th class='center-content'>Store</th>
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
                                <?= $optionSet; ?>
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
                            <label for="code" class="form-label">Code</label>
                            <input type="text" class="form-control required" id="code" aria-describedby="store_code" maxlength="25">
                            <small class="form-text text-muted">* required, must be unique, max 25 characters</small>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Area Description</label>
                            <textarea class="form-control required" id="description" aria-describedby="store_description" maxlength="50"></textarea>
                            <small class="form-text text-muted">* required, must be unique, max 50 characters</small>
                        </div>
                        <div class="mb-3">
                            <label for="store" class="form-label">Store</label>
                            <input type="text" class="form-control required" id="store" aria-describedby="store" maxlength="50">
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
                    <h1 class="modal-title">Import File</h1>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="mb-3">
                            <label for="import_files" class="form-label import-label">Add files</label><br>
                            <input type="file" id="file" accept=".xls,.xlsx,.csv" aria-describedby="import_files" onclick="clear_import_table()" onchange="read_xl_file()">
                            <small id="import_files" class="form-text text-muted">* required, select a file from your device</small>
                        </div>
                    </div>
                    <div class="card">
                        <div class="text-center">
                            <b>Extracted Data</b>
                        </div>
                        <div class="mb-3 extracted-data">
                            <table class="table table-bordered listdata">
                                <thead>
                                    <tr>
                                        <th class='center-content'>Line #</th>
                                        <th class='center-content'>Code</th>
                                        <th class='center-content'>Area Description</th>
                                        <th class='center-content'>Status</th>
                                    </tr>
                                </thead>
                                <tbody class="word_break import_table"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn caution" data-dismiss="modal">Close</button>
                    <button type="button" class="btn save" onclick="proccess_xl_file()">Validate and Save</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var query = "status >= 0";
        var limit = 10; 
        var user_id = '<?=$session->sess_uid;?>';
        var url = "<?= base_url("cms/global_controller");?>";

        $(document).ready(function() {
            get_data(query);
            get_pagination();

        });

        // uses function get_data(
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

        $(document).on('click', '#btn_add', function() {
            open_modal('Add New Area', 'add', '');
        });

        function edit_data(id) {
            open_modal('Edit Area', 'edit', id);
        }

        function view_data(id) {
            open_modal('View Area', 'view', id);
        }

        function open_modal(msg, actions, id) {
            $(".form-control").css('border-color','#ccc');
            $(".validate_error_message").remove();
            let $modal = $('#popup_modal');
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
            set_field_state('#code, #description, #store, #status', isReadOnly);

            $footer.empty();
            if (actions === 'add') $footer.append(buttons.save);
            if (actions === 'edit') $footer.append(buttons.edit);
            $footer.append(buttons.close);

            $modal.modal('show');
        }

        function reset_modal_fields() {
            $('#popup_modal #code, #popup_modal #description, #popup_modal #store').val('');
            $('#popup_modal #status').prop('checked', true);
        }

        function set_field_state(selector, isReadOnly) {
            $(selector).prop({ readonly: isReadOnly, disabled: isReadOnly });
        }

        $(document).on('click', '#btn_import ', function() {
            $("#import_modal").modal('show')
            clear_import_table()
        });

        function populate_modal(inp_id) {
            var query = "status >= 0 and id = " + inp_id;
            var url = "<?= base_url('cms/global_controller');?>";
            var data = {
                event : "list", 
                select : "id, code, description, store, status",
                query : query, 
                table : "tbl_area"
            }
            aJax.post(url,data,function(result){
                var obj = is_json(result);
                if(obj){
                    $.each(obj, function(index,d) {
                        $('#id').val(d.id);
                        $('#code').val(d.code);
                        $('#description').val(d.description);
                        $('#store').val(d.store);
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

        function clear_import_table() {
            $(".import_table").empty()
        }

        function read_xl_file() {
            var html = '';
            const file = $("#file")[0].files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                const data = e.target.result;
                const workbook = XLSX.read(data, {type: "binary"});
                const sheet = workbook.Sheets[workbook.SheetNames[0]];
                const jsonData = XLSX.utils.sheet_to_json(sheet);

                var tr_counter = 0;
                jsonData.forEach(row => {
                    var rowClass = (tr_counter % 2 === 0) ? "even-row" : "odd-row";
                    html += "<tr class=\""+rowClass+"\">";
                    html += "<td>";
                    html += tr_counter+1;
                    html += "</td>";

                    // create a table cell for each item in the row
                    var td_validator = ['code', 'description', 'status']
                    td_validator.forEach(column => {
                        html += "<td id=\"" + column + "\">";
                        html += row[column] !== undefined ? row[column] : ""; // add value or leave empty
                        html += "</td>";
                    });
                    html += "</tr>";
                    tr_counter += 1;
                });

                $(".import_table").append(html);
                html = '';
            };
            reader.readAsBinaryString(file);
        }

        function proccess_xl_file() {
            // var extracted_data = $(".import_table");
            // var html_tr_count = 1;
            // var invalid = false;
            // var errmsg = '';
            // var unique_code = [];
            // var unique_description = [];
            // var import_array = [];
            // extracted_data.find('tr').each(function () {
            //     var html_td_count = 1;
            //     var temp = [];
            //     $(this).find('td').each( function() {
            //         var text_val = $(this).html().trim();
            //         if (html_td_count != 1) {
            //             temp.push(text_val)
            //         }

            //         if (html_td_count == 2) {
            //             if (unique_code.includes(text_val)) {
            //                 invalid = true;
            //                 errmsg += "⚠️ Duplicated Code at line #: <b>" + html_tr_count + "</b>⚠️<br>";
            //             } else {
            //                 unique_code.push(text_val);
            //             }
            //         }
            //         if (html_td_count == 2 && text_val == '') {
            //             invalid = true;
            //             errmsg += "⚠️ Invalid Code at line #: <b>"+html_tr_count+"</b>⚠️<br>";
            //         }
            //         if (html_td_count == 2 && text_val.length > 25) {
            //             invalid = true;
            //             errmsg += "⚠️ Code exceeds the set character limit(25) at line #: <b>"+html_tr_count+"</b>⚠️<br>";
            //         }

            //         if (html_td_count == 3) {
            //             if (unique_description.includes(text_val)) {
            //                 invalid = true;
            //                 errmsg += "⚠️ Duplicated Description at line #: <b>"+html_tr_count+"</b>⚠️<br>";
            //             }
            //             else {
            //                 unique_description.push(text_val)
            //             }
            //         }
            //         if (html_td_count == 3 && text_val == '') {
            //             invalid = true;
            //             errmsg += "⚠️ Invalid Description at line #: <b>"+html_tr_count+"</b>⚠️<br>";
            //         }
            //         if (html_td_count == 3 && text_val.length > 50) {
            //             invalid = true;
            //             errmsg += "⚠️ Description exceeds the set character limit(50) at line #: <b>"+html_tr_count+"</b>⚠️<br>";
            //         }

            //         if (html_td_count == 4 && text_val.toLowerCase() != 'active' && text_val.toLowerCase() != 'inactive') {
            //             invalid = true;
            //             errmsg += "⚠️ Invalid Status at line #: <b>"+html_tr_count+"</b>⚠️<br>";
            //         }

            //         html_td_count+=1;
            //     })

            //     import_array.push(temp)
            //     html_tr_count+=1;
            // });

            // var temp_invalid = false;
            // var temp_err_msg = '';
            // var temp_line_no = 0;
            // var promises = [];

            // import_array.forEach(row => {
            //     // Wrap the check_current_db in a promise
            //     var promise = new Promise((resolve, reject) => {
            //         check_current_db(function(result) {
            //             var parsedResult = JSON.parse(result);

            //             $.each(parsedResult, function(index, item) {
            //                 if (item.code === row[0] && item.description === row[1]) {
            //                     temp_invalid = true;
            //                     temp_err_msg += "⚠️ Code already exists in masterfile at line #: <b>"+temp_line_no+"</b>⚠️<br>";
            //                 }
            //                 else if (item.code === row[0]) {
            //                     temp_invalid = true;
            //                     temp_err_msg += "⚠️ Code already exists in masterfile at line #: <b>"+temp_line_no+"</b>⚠️<br>";
            //                 }
            //                 else if (item.description === row[1]) {
            //                     temp_invalid = true;
            //                     temp_err_msg += "⚠️ Description already exists in masterfile at line #: <b>"+temp_line_no+"</b>⚠️<br>";
            //                 } else {
                                
            //                 }
            //             });
            //             temp_line_no+=1;
            //             resolve(); // Resolve if no issues are found
            //         });
            //     });
                
            //     promises.push(promise);
            // });

            // // Wait for all promises to be resolved
            // Promise.all(promises).then(() => {
            //     invalid = temp_invalid;
            //     errmsg += temp_err_msg;

            //     if(invalid) {
            //         load_swal(
            //             '',
            //             '1000px',
            //             'error',
            //             'Error!',
            //             errmsg,
            //             false,
            //             true
            //         )
            //         $("#import_modal").modal('hide')
            //         return
            //     }
            //     alert('proceeded to saving')
            //     import_array.forEach(row => {
            //         var status_val = 0;
            //         if (row[2] == 'active') {
            //             status_val = 1
            //         } else {
            //             status_val = 0
            //         }
            //         save_to_db(row[0], row[1], status_val)
            //     })
            // });
        }

        $(document).on('keydown', '#search_query', function(event) {
            $('.btn_status').hide();
            $(".selectall").prop("checked", false);
            if (event.key == 'Enter') {
                search_input = $('#search_query').val();
                offset = 1;
                get_pagination();
                new_query = query;
                new_query += ' and code like \'%'+search_input+'%\' or '+query+' and description like \'%'+search_input+'%\'';
                get_data(new_query);
            }
        });

        function get_pagination() {
            var data = {
            event : "pagination",
                select : "id",
                query : query,
                offset : offset,
                limit : limit,
                table : "tbl_area",
                order : {
                    field : "updated_date",
                    order : "desc" 
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
            get_data(query);
        })

        function save_data(action, id) {
            var code = $('#code').val();
            var description = $('#description').val();
            var store = $('#store').val();
            var chk_status = $('#status').prop('checked');
            if (chk_status) {
                status_val = 1;
            } else {
                status_val = 0;
            }
            if (id !== undefined && id !== null && id !== '') {
                check_current_db("tbl_area", ["code", "description"], [code, description], "status" , "id", id, true, function(exists, duplicateFields) {
                    if (!exists) {
                        modal.confirm(confirm_update_message,function(result){
                            if(result){ 
                                 modal.loading(true);
                                save_to_db(code, description, store, status_val, id)
                            }
                        });

                    }             
                });
            }else{
                check_current_db("tbl_area", ["code"], [code], "status" , null, null, true, function(exists, duplicateFields) {
                    if (!exists) {
                        modal.confirm(confirm_add_message,function(result){
                            if(result){ 
                                 modal.loading(true);
                                save_to_db(code, description, store, status_val, null)
                            }
                        });

                    }                  
                });
            }
        }

        function save_to_db(inp_code, inp_description, inp_store, status_val, id) {
            const url = "<?= base_url('cms/global_controller'); ?>";
            let data = {}; 
            let modal_alert_success;

            if (id !== undefined && id !== null && id !== '') {
                modal_alert_success = success_update_message;
                data = {
                    event: "update",
                    table: "tbl_area",
                    field: "id",
                    where: id,
                    data: {
                        code: inp_code,
                        description: inp_description,
                        store: inp_store,
                        updated_date: formatDate(new Date()),
                        updated_by: user_id,
                        status: status_val
                    }
                };
            } else {
                modal_alert_success = success_save_message;
                data = {
                    event: "insert",
                    table: "tbl_area",
                    data: {
                        code: inp_code,
                        description: inp_description,
                        store: inp_store,
                        created_date: formatDate(new Date()),
                        created_by: user_id,
                        status: status_val
                    }
                };
            }

            aJax.post(url,data,function(result){
                var obj = is_json(result);
                modal.loading(false);
                modal.alert(modal_alert_success, function() {
                    location.reload();
                });
            });
        }



        function delete_data(id) {
            modal.confirm(confirm_delete_message,function(result){
                if(result){ 
                    var url = "<?= base_url('cms/global_controller');?>";
                    var data = {
                        event : "update",
                        table : "tbl_area",
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
                        modal.alert(success_delete_message, function() {
                            location.reload();
                        });
                    });
                }

            });
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

        function get_data(new_query) {
            var data = {
                event : "list",
                select : "id, code, description, store, status",
                query : new_query,
                offset : offset,
                limit : limit,
                table : "tbl_area",
                order : {
                    field : "code, updated_date",
                    order : "asc, desc" 
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
                            html += "<td style='width: 30%'>" + y.description + "</td>";
                            html += "<td style='width: 20%'>" + y.store + "</td>";
                            html += "<td style='width: 10%'>" + status + "</td>";

                            if (y.id == 0) {
                                html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                            } else {
                                html+="<td class='center-content' style='width: 25%'>";
                                html+="<a class='btn-sm btn update' onclick=\"edit_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Edit Details'><span class='glyphicon glyphicon-pencil'>Edit</span>";
                                html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Delete Item'><span class='glyphicon glyphicon-pencil'>Delete</span>";
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
            // var counter = 0; 
            // $('.select:checked').each(function () {
            //     var id = $(this).attr('data-id');
            //     if(id){
            //         counter++;
            //     }
            //  });
            // console.log(counter);
            modal.confirm(modal_obj, function (result) {
                if (result) {
                    var url = "<?= base_url('cms/global_controller');?>";
                    var dataList = [];
                    
                    $('.select:checked').each(function () {
                        var id = $(this).attr('data-id');
                        dataList.push({
                            event: "update",
                            table: "tbl_area",
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
                                    modal.alert(modal_alert_success, function () {
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

        function addNbsp(inputString) {
            return inputString.split('').map(char => {
                if (char === ' ') {
                return '&nbsp;&nbsp;';
                }
                return char + '&nbsp;';
            }).join('');
        }

    //sample data for progress loading
    //let data = ["Row 1", "Row 2", "Row 3", "Row 4", "Row 5"]; 
    // var counter = 0;
    // let total = data.length;
    // let current = 0;

    // $.each(data, function (index, row) {
    //     setTimeout(function () {
    //         let progress = Math.round(((current + 1) / total) * 100);
    //         updateSwalProgress(row, progress);
    //         current++;

    //         // Close the modal when all rows are processed
    //         if (current === total) {
    //             setTimeout(() => {
    //                modal.loading_progress(false);
    //             }, 500);
    //         }
    //     }, index * 1000); // Delay each iteration by 1 second
    // });
</script>