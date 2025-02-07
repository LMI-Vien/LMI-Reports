
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
                                      <th class='center-content'>Code</th>
                                      <th class='center-content'>Agency</th>
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
                            <input type="text" class="form-control" id="id" aria-describedby="id" hidden>
                            <input type="text" class="form-control required" id="code" maxlength="25" aria-describedby="code">
                            <small id="code" class="form-text text-muted">* required, must be unique, max 25 characters</small>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Agency</label>
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

                            <label for="file" class="custom-file-upload save" style="margin-left:10px; margin-top: 10px; align-items: center;">
                                <i class="fa fa-file-import" style="margin-right: 5px;"></i>Custom Upload
                            </label>
                            <input
                                type="file"
                                style="display: none;"
                                id="file"
                                accept=".xls,.xlsx,.csv"
                                aria-describedby="import_files"
                                onchange="store_file(event)"
                                onclick="clear_import_table()"
                            >

                            <label for="preview" class="custom-file-upload save" id="preview_xl_file" style="margin-top: 10px" onclick="read_xl_file()">
                                <i class="fa fa-sync" style="margin-right: 5px;"></i>Preview Data
                            </label>

                            <table class= "table table-bordered listdata">
                                <thead>
                                    <tr>
                                        <th class='center-content' style='width: 5%'>Line #</th>
                                        <th class='center-content' style='width: 10%'>Code</th>
                                        <th class='center-content' style='width: 20%'>Agency</th>
                                        <th class='center-content' style='width: 10%'>Status</th>
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
    $(document).ready(function() {
      get_data(query);
      get_pagination();
    });

    function get_data(query) {
      var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "list",
            select : "id, code, agency, status, updated_date, created_date",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_agency",
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
                        var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";

                        html += "<tr class='" + rowClass + "'>";
                        html += "<td class='center-content' style='width: 5%'><input class='select' type=checkbox data-id="+y.id+" onchange=checkbox_check()></td>";
                        html += "<td style='width: 10%'>" + trimText(y.code, 10) + "</td>";
                        html += "<td style='width: 20%'>" + trimText(y.agency, 10) + "</td>";
                        html += "<td style='width: 10%'>" +status+ "</td>";
                        html += "<td class='center-content' style='width: 10%; min-width: 200px'>" + (y.created_date ? ViewDateformat(y.created_date) : "N/A") + "</td>";
                        html += "<td class='center-content' style='width: 10%; min-width: 200px'>" + (y.updated_date ? ViewDateformat(y.updated_date) : "N/A") + "</td>";

                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                          html+="<td class='center-content' style='width: 20%; min-width: 300px'>";
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

    function get_pagination() {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
          event : "pagination",
            select : "id",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_agency",
            order : {
                field : "updated_date", //field to order
                order : "desc" //asc or desc
            }

        }

        aJax.post(url,data,function(result){
            var obj = is_json(result); //check if result is valid JSON format, Format to JSON if not
            console.log(obj);
            modal.loading(false);
            pagination.generate(obj.total_page, ".list_pagination", get_data);
        });
    }

    pagination.onchange(function(){
        offset = $(this).val();
        get_data(query);
        $('.selectall').prop('checked', false);
        $('.btn_status').hide();
        $("#search_query").val("");
    })

    $(document).on('keypress', '#search_query', function(e) {               
        if (e.keyCode === 13) {
            var keyword = $(this).val().trim();
            offset = 1;
            new_query = " ("+ query + " AND code like '%" + keyword + "%' ) OR";
            new_query += " ("+ query + " AND agency like '%" + keyword + "%')";
            get_data(new_query);
            get_pagination();
        }
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
        modal.loading(false);
    });

    $('#btn_add').on('click', function() {
        open_modal('Add New Agency', 'add', '');
    });

    $('#btn_import').on('click', function() {
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
        set_field_state('#code, #agency, #status', isReadOnly);

        $footer.empty();
        if (actions === 'add') $footer.append(buttons.save);
        if (actions === 'edit') $footer.append(buttons.edit);
        $footer.append(buttons.close);

        $modal.modal('show');
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
            click: onclick_event // Attach the onclick event
        });
        return new_btn;
    }

    // function save_data() {
    //     var code = $('#code').val(); 
    //     var agency = $('#agency').val(); 
    //     var status_val = $('#status').prop('checked') ? 1 : 0; 

    //     check_current_db(function(result) {
    //         var err_msg = '';
    //         var valid = true;
            
    //         var result = JSON.parse(result);

    //         $.each(result, function(index, item) {
    //             if (item.code === code) {
    //                 valid = false;
    //                 err_msg += "Code already exists in masterfile<br>";
    //             }
    //             if (item.agency === agency) {
    //                 valid = false;
    //                 err_msg += "Description already exists in masterfile<br>";
    //             }
    //         });

    //         if (!valid) {
    //             load_swal(
    //                 'add_alert',
    //                 '500px',
    //                 "error",
    //                 "Error!",
    //                 err_msg,
    //                 false,
    //                 false
    //             );
    //         } else {
    //             modal.confirm(confirm_add_message, function(result) {
    //                 if (result) {
    //                     var dataObject = {
    //                         code: code,
    //                         agency: agency,
    //                         status: status_val,
    //                         created_date: formatDate(new Date()), 
    //                         created_by: user_id
    //                     };
    //                     save_to_db(dataObject); 
    //                 }
    //             });
    //         }
    //     });
    // }

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

        if (id !== undefined && id !== null && id !== '') {
            modal_alert_success = success_update_message;
            data = {
                event: "update",
                table: "tbl_agency",
                field: "id",
                where: id,
                data: {
                    code: inp_code,
                    agency: inp_agency,
                    updated_date: formatDate(new Date()),
                    updated_by: user_id,
                    status: status_val
                }
            };
        } else {
            modal_alert_success = success_save_message;
            data = {
                event: "insert",
                table: "tbl_agency",
                data: {
                    code: inp_code,
                    agency: inp_agency,
                    created_date: formatDate(new Date()),
                    created_by: user_id,
                    status: status_val
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
        modal.confirm(confirm_delete_message,function(result){
            if(result){ 
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

    function save_to_db_import(dataObject) {
        var url = "<?= base_url('cms/global_controller');?>"; // URL of Controller
        var data = {
            event: "insert",
            table: "tbl_agency", // Table name
            data: dataObject  // Pass the entire object dynamically
        };

        aJax.post(url, data, function (result) {
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

    var storedFile = null;
    function store_file(event) {
        storedFile = event.target.files[0]; // Store the file but do nothing yet
        console.log("File stored:", storedFile.name);
    }

    function clear_import_table() {
        $(".import_table").empty()
    }

    function read_xl_file() {
        $(".import_table").empty()
        var html = '';
        const file = $("#file")[0].files[0];
        if (file === undefined) {
            // load_swal(
            //     '',
            //     '500px',
            //     'error',
            //     'Error!',
            //     'Please select a file to upload',
            //     false,
            //     true
            // )
            modal.alert('Please select a file to upload', 'error', ()=>{})
            return
        }
        const reader = new FileReader();
        reader.onload = function(e) {
            const data = e.target.result;
            // convert the data to a workbook
            const workbook = XLSX.read(data, {type: "binary"});
            // get the first sheet
            const sheet = workbook.Sheets[workbook.SheetNames[0]];
            // convert the sheet to JSON
            const jsonData = XLSX.utils.sheet_to_json(sheet);

            var tr_counter = 0;
            jsonData.forEach(row => {
                var rowClass = (tr_counter % 2 === 0) ? "even-row" : "odd-row";
                html += "<tr class=\""+rowClass+"\">";
                html += "<td>";
                html += tr_counter+1;
                html += "</td>";

                // create a table cell for each item in the row
                var td_validator = ['code', 'agency', 'status']
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
        if (!storedFile) {
            modal.alert('Please select a file to upload', 'error', ()=>{})
            return;
        }

        modal.loading(true)
        let reader = new FileReader();
        reader.onload = function (e) {
            let data = new Uint8Array(e.target.result);
            let workbook = XLSX.read(data, { type: "array" });

            let sheetName = workbook.SheetNames[0];
            let worksheet = workbook.Sheets[sheetName];

            let jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });

            if (!Array.isArray(jsonData) || jsonData.length < 2) {
                console.error("Invalid data format: No data rows found.");
                alert("Invalid file format. Please upload a valid Excel file.");
                return;
            }

            console.log("Extracted Data:", jsonData);

            let headers = jsonData[0];
            let records = jsonData.slice(1);

            let columnMapping = {
                "code": "code",
                "agency": "agency",
                "status": "status"
            };

            let statusMapping = {
                "active": 1,
                "inactive": 0
            };

            let existingRecords = [];
            let invalidRecords = [];
            let insertedRecords = 0;
            let totalRecords = records.length;
            let processedCount = 0;

            records.forEach((row, rowIndex) => {
                let dataObject = {};
                let isValid = true;

                headers.forEach((header, index) => {
                    let dbColumn = columnMapping[header];
                    if (dbColumn) {
                        let value = row[index]?.trim() ?? null;
                        dataObject[dbColumn] = value;
                        if (!value) isValid = false;
                    }
                });

                if (dataObject['status']) {
                    dataObject['status'] = statusMapping[dataObject['status'].toLowerCase()] ?? 0;
                }

                dataObject['created_date'] = formatDate(new Date());
                dataObject['created_by'] = user_id;

                if (!dataObject.code || !dataObject.agency || dataObject.status === null) {
                    invalidRecords.push(`Row ${rowIndex + 2}`);
                    processedCount++;
                    checkCompletion();
                    return;
                }

                check_if_exists(dataObject, function (exists) {
                    console.log("Check if it exists:", exists);
                    if (exists) {
                        existingRecords.push(dataObject.code);
                        processedCount++;
                        checkCompletion();
                    } else {
                        save_to_db_import(dataObject, function (success) {
                            if (success) {
                                insertedRecords++;
                                console.log(`Record inserted successfully: ${dataObject.code}`);
                            }
                            processedCount++;
                            checkCompletion();
                        });
                    }
                });
            });

            function checkCompletion() {
                console.log(`Processed count: ${processedCount}, Total records: ${totalRecords}`);
                if (processedCount === totalRecords) {
                    if (invalidRecords.length > 0) {
                        load_swal(
                            'add_alert',
                            '500px',
                            "error",
                            "Error!",
                            `The following rows have missing values: ${invalidRecords.join(', ')}`,
                            false,
                            false
                        );
                    } else if (existingRecords.length > 0) {
                        load_swal(
                            'add_alert',
                            '500px',
                            "error",
                            "Error!",
                            `The following records already exist in masterfile: ${existingRecords.join(', ')}`,
                            false,
                            false
                        );
                    } else if (insertedRecords > 0) {
                        // load_swal(
                        //     'add_alert',
                        //     '500px',
                        //     "success",
                        //     "Success!",
                        //     `${insertedRecords} records inserted successfully!`,
                        //     false,
                        //     false
                        // ).then(() => {
                        //     modal.loading(false)
                        //     setTimeout(() => {
                        //         location.reload(); 
                        //     }, 1000);
                        // });
                        modal.loading(false)
                        modal.alert(`${insertedRecords} records inserted successfully!`, 'success', () => {
                            if (result) {
                                location.reload();
                            }
                        })
                    }
                }
            }
        };

        reader.readAsArrayBuffer(storedFile);
    }

    // Function to check if record exists
    function check_if_exists(dataObject, callback) {
        var data = {
            event: "list",
            select: "id, code, agency", // Adjust as needed for your schema
            query: `code = '${dataObject.code}' OR agency = '${dataObject.agency}'`, // Query for existing data
            offset: 0,
            limit: 0,
            table: "tbl_agency"
        };

        console.log("Sending data to check_if_exists:", data); // Debugging

        $.ajax({
            url: "<?= base_url('cms/global_controller'); ?>", // URL of the controller
            type: 'POST',
            data: data,
            success: function (result) {
                console.log("Raw server response:", result); // Debugging

                // Ensure the result is parsed as JSON
                try {
                    result = JSON.parse(result);
                } catch (e) {
                    console.error("Failed to parse response:", e);
                    callback(false); // Exit early if response parsing fails
                    return;
                }

                if (!Array.isArray(result)) {
                    console.error("Expected an array, but received:", result); // Debugging invalid format
                    callback(false); // Exit early if the response is not an array
                    return;
                }

                // Log the result for further inspection
                result.forEach(item => {
                    console.log(`Checking item: code = ${item.code}, agency = ${item.agency}`);
                });

                // Check if any record has the same code or team description
                let exists = result.some(item => {
                    // Trim both fields and use case-insensitive comparison
                    let itemCode = item.code;
                    let itemAgency = item.agency;
                    let dataCode = dataObject.code;
                    let dataAgency = dataObject.agency;

                    console.log(`Comparing: ${dataCode} === ${itemCode} || ${dataAgency} === ${itemAgency}`);

                    return itemCode === dataCode || itemAgency === dataAgency;
                });

                console.log("Does record exist?", exists); // Debugging
                callback(exists); // Pass the result to the callback
            },
            error: function (e) {
                console.error("Error checking for existing record:", e);
                callback(false); // If error occurs, assume the record doesn't exist
            }
        });
    }

    // function update_data(id) {
    //     var code = $('#code').val();
    //     var agency = $('#agency').val();
    //     var status = $('#status').prop('checked') ? 1 : 0; // Get the status as 1 or 0

    //     // Check if the code or description already exists in the database before updating
    //     check_current_db(function(result) {
    //         var err_msg = '';
    //         var valid = true;

    //         // Parse the result (assuming it's JSON)
    //         var result = JSON.parse(result);

    //         // Iterate through result and check for code and description
    //         $.each(result, function(index, item) {
    //             if (item.code === code && item.id !== id) { // Exclude the current record being updated
    //                 valid = false;
    //                 err_msg += "Code already exists in masterfile<br>";
    //             }
    //             if (item.agency === agency && item.id !== id) { // Exclude the current record being updated
    //                 valid = false;
    //                 err_msg += "Agency already exists in masterfile<br>";
    //             }
    //         });

    //         // If not valid, show error message
    //         if (!valid) {
    //             load_swal(
    //                 'add_alert',
    //                 '500px',
    //                 "error",
    //                 "Error!",
    //                 err_msg,
    //                 false,
    //                 false
    //             );
    //         } else {
    //             // If valid, confirm and update the record
    //             modal.confirm(confirm_update_message, function(result) {
    //                 if (result) {
    //                     var data = {
    //                         event: "update", // Specify event type
    //                         table: "tbl_agency", // Table name
    //                         field: "id",
    //                         where: id, // Record to update
    //                         data: {
    //                             code: code,
    //                             agency: agency,
    //                             status: status,
    //                             updated_date: formatDate(new Date()),
    //                             updated_by: user_id
    //                         }
    //                     };

    //                     var url = "<?= base_url('cms/global_controller'); ?>"; // URL of the controller
    //                     aJax.post(url, data, function(result) {
    //                         var ob   j = is_json(result);
    //                         location.reload();
    //                     });
    //                 }
    //             });
    //         }
    //     });
    // }

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
                        if (hasExecuted) return; // Prevents multiple executions

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

    // function open_modal(msg, actions, id) {
    //     modal_title = addNbsp(msg);
    //     $('#popup_modal .modal-title b').html(modal_title);
    //     $('#popup_modal #code').val('');
    //     $('#popup_modal #agency').val('');
    //     $('#popup_modal #status').prop('checked', true);
    //     // <button type="button" class="btn save" id="save_data">Save</button>
    //     var save_btn = create_button('Save', 'save_data', 'btn save', function () {
    //         if(validate.standard("popup_modal")){
    //             save_data();
    //         }
    //     });
    //     // <button type="button" class="btn save" id="edit_data">Edit</button>
    //     var edit_btn = create_button('Edit', 'edit_data', 'btn save', function () {
    //         // alert("Form edited!");
    //         update_data(id);
    //     });
    //     // <button type="button" class="btn caution" data-dismiss="modal">Close</button>
    //     var close_btn = create_button('Close', 'close_data', 'btn caution', function () {
    //         $('#popup_modal').modal('hide');
    //     });
    //     switch (actions) {
    //         case 'add':
    //             $('#code').attr('readonly', false);
    //             $('#code').attr('disabled', false);
    //             $('#agency').attr('readonly', false);   
    //             $('#agency').attr('disabled', false);
    //             $('#popup_modal .modal-footer').empty();
    //             $('#popup_modal .modal-footer').append(save_btn);
    //             $('#popup_modal .modal-footer').append(close_btn);
    //             break;
                
    //         case 'edit':
    //             populate_modal(id);
    //             $('#code').attr('readonly', false);
    //             $('#code').attr('disabled', false);
    //             $('#agency').attr('readonly', false);   
    //             $('#agency').attr('disabled', false);
    //             $('#status').attr('disabled', false);
    //             $('#status').attr('readonly', false);   
    //             $('#popup_modal .modal-footer').empty();
    //             $('#popup_modal .modal-footer').append(edit_btn);
    //             $('#popup_modal .modal-footer').append(close_btn);
    //             break;
            
    //         case 'view':
    //             populate_modal(id);
    //             $('#code').attr('readonly', true);
    //             $('#code').attr('disabled', true);
    //             $('#agency').attr('readonly', true);   
    //             $('#agency').attr('disabled', true);
    //             $('#status').attr('readonly', true);   
    //             $('#status').attr('disabled', true);
    //             $('#popup_modal .modal-footer').empty();
    //             $('#popup_modal .modal-footer').append(close_btn);
    //             break;
        
    //         default:
    //             populate_modal(id);
    //             $('#popup_modal .modal-footer').empty();
    //             $('#popup_modal .modal-footer').append(close_btn);
    //             break;
    //     }
    //     $('#popup_modal').modal('show');
    // }

</script>