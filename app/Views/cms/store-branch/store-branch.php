
    <div class="content-wrapper p-4">
        <div class="card">
            <div class="text-center page-title md-center">
                <b>S T O R E / B R A N C H</b>
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
                                        <th class='center-content'>Code</th>
                                        <th class='center-content'>Store/Branch</th>
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

    <div class="modal" tabindex="-1" id="save_modal">
        <div class="modal-dialog">
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
                            <label for="code" class="form-label">Code</label>
                            <input type="text" class="form-control" id="code" aria-describedby="store_code">
                            <small id="code" class="form-text text-muted">* required, must be unique, max 25 characters</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" aria-describedby="store_description">
                            <small id="description" class="form-text text-muted">* required, must be unique, max 50 characters</small>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="status" checked>
                            <label class="form-check-label" for="status">Active</label>
                        </div>
                    </form>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn caution" data-dismiss="modal">Close</button>
                    <button type="button" class="btn save" id="save_data">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="view_modal">
        <div class="modal-dialog">
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
                            <label for="code" class="form-label">Code</label>
                            <input type="text" class="form-control" id="v_code" aria-describedby="store_code" readonly disabled >
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="v_description" aria-describedby="store_description" readonly disabled >
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="v_status" readonly disabled >
                            <label class="form-check-label" for="status">Active</label>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn caution" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="edit_modal">
        <div class="modal-dialog">
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
                        <input type="text" hidden id="e_id">
                        <div class="mb-3">
                            <label for="code" class="form-label">Code</label>
                            <input type="text" class="form-control" id="e_code" aria-describedby="store_code">
                            <small id="code" class="form-text text-muted">* required, must be unique, max 25 characters</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="e_description" aria-describedby="store_description">
                            <small id="code" class="form-text text-muted">* required, must be unique, max 50 characters</small>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="e_status">
                            <label class="form-check-label" for="status">Active</label>
                        </div>
                    </form>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn caution" data-dismiss="modal">Close</button>
                    <button type="button" class="btn save" id="update_data">Save and Update</button>
                </div>
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

                            <label for="file" class="custom-file-upload save" style="margin-left:10px; margin-top: 10px">
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

                            <label for="preview" class="custom-file-upload save" id="preview_xl_file" style="margin-top: 10px" onclick="read_xl_file()">
                                <i class="fa fa-sync" style="margin-right: 5px;"></i>Preview Data
                            </label>

                            <table class= "table table-bordered listdata">
                                <thead>
                                    <tr>
                                        <th class='center-content'>Line #</th>
                                        <th class='center-content'>Code</th>
                                        <th class='center-content'>Store/Branch</th>
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
            title = addNbsp('ADD STORE/BRANCH')
            $("#save_modal").find('.modal-title').find('b').html(title)
            $("#save_modal").modal('show')
        });

        $(document).on('click', '#save_data', function(e){
            save_data(e)
            $("#save_modal").modal('hide')
        })

        $(document).on('click', '#btn_import ', function() {
            title = addNbsp('IMPORT STORE/BRANCH')
            $("#import_modal").find('.modal-title').find('b').html(title)
            $("#import_modal").modal('show')
            clear_import_table()
        });

        function clear_import_table() {
            $(".import_table").empty()
        }

        function read_xl_file() {
            $(".import_table").empty()
            var html = '';
            const file = $("#file")[0].files[0];
            if (file === undefined) {
                load_swal(
                    '',
                    '500px',
                    'error',
                    'Error!',
                    'Please select a file to upload',
                    false,
                    true
                )
                return
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                const data = e.target.result;

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
            var extracted_data = $(".import_table");
            var html_tr_count = 1;
            var invalid = false;
            var errmsg = '';
            var unique_code = [];
            var unique_description = [];
            var import_array = [];
            extracted_data.find('tr').each(function () {
                var html_td_count = 1;
                var temp = [];
                $(this).find('td').each( function() {
                    var text_val = $(this).html().trim();
                    if (html_td_count != 1) {
                        temp.push(text_val)
                    }

                    if (html_td_count == 2) {
                        if (unique_code.includes(text_val)) {
                            invalid = true;
                            errmsg += "⚠️ Duplicated Code at line #: <b>" + html_tr_count + "</b>⚠️<br>";
                        } else {
                            unique_code.push(text_val);
                        }
                    }
                    if (html_td_count == 2 && text_val == '') {
                        invalid = true;
                        errmsg += "⚠️ Invalid Code at line #: <b>"+html_tr_count+"</b>⚠️<br>";
                    }
                    if (html_td_count == 2 && text_val.length > 25) {
                        invalid = true;
                        errmsg += "⚠️ Code exceeds the set character limit(25) at line #: <b>"+html_tr_count+"</b>⚠️<br>";
                    }

                    if (html_td_count == 3) {
                        if (unique_description.includes(text_val)) {
                            invalid = true;
                            errmsg += "⚠️ Duplicated Description at line #: <b>"+html_tr_count+"</b>⚠️<br>";
                        }
                        else {
                            unique_description.push(text_val)
                        }
                    }
                    if (html_td_count == 3 && text_val == '') {
                        invalid = true;
                        errmsg += "⚠️ Invalid Description at line #: <b>"+html_tr_count+"</b>⚠️<br>";
                    }
                    if (html_td_count == 3 && text_val.length > 50) {
                        invalid = true;
                        errmsg += "⚠️ Description exceeds the set character limit(50) at line #: <b>"+html_tr_count+"</b>⚠️<br>";
                    }

                    if (html_td_count == 4 && text_val.toLowerCase() != 'active' && text_val.toLowerCase() != 'inactive') {
                        invalid = true;
                        errmsg += "⚠️ Invalid Status at line #: <b>"+html_tr_count+"</b>⚠️<br>";
                    }

                    html_td_count+=1;
                })

                import_array.push(temp)
                html_tr_count+=1;
            });

            var temp_invalid = invalid;
            var temp_err_msg = '';
            var temp_line_no = 0;
            var promises = [];

            import_array.forEach(row => {
                check_current_db(function(result) {
                    var parsedResult = JSON.parse(result);
    
                    $.each(parsedResult, function(index, item) {
                        if (item.code === row[0] && item.description === row[1]) {
                            temp_invalid = true;
                            temp_err_msg += "⚠️ Code already exists in masterfile at line #: <b>"+temp_line_no+"</b>⚠️<br>";
                        }
                        else if (item.code === row[0]) {
                            temp_invalid = true;
                            temp_err_msg += "⚠️ Code already exists in masterfile at line #: <b>"+temp_line_no+"</b>⚠️<br>";
                        }
                        else if (item.description === row[1]) {
                            temp_invalid = true;
                            temp_err_msg += "⚠️ Description already exists in masterfile at line #: <b>"+temp_line_no+"</b>⚠️<br>";
                        } else {
                            
                        }
                    });
                    temp_line_no+=1;
                });
            });
            
            invalid = temp_invalid;
            errmsg += temp_err_msg;

            if(invalid) {
                load_swal(
                    '',
                    '1000px',
                    'error',
                    'Error!',
                    errmsg,
                    false,
                    true
                )
                $("#import_modal").modal('hide')
                return
            }
            import_array.forEach(row => {
                var status_val = 0;
                if (row[2] == 'active') {
                    status_val = 1
                } else {
                    status_val = 0
                }
                save_to_db(row[0], row[1], status_val)
            })

            get_pagination();
        }

        // uses function update_data(
        $(document).on('click', '#update_data', function(e){
            var id = $(this).attr('data-id');
            update_data(id)
            $("#save_modal").modal('hide')
        })

        // uses function get_data(
        $(document).on('keydown', '#search_query', function(event) {
            if (event.key == 'Enter') {
                search_input = $('#search_query').val();
                offset = 1;
                get_pagination();
                new_query = query;
                new_query += ' and code like \'%'+search_input+'%\' or '+query+' and description like \'%'+search_input+'%\'';
                get_data(new_query);
            }
        });

        // used : 1 
        function get_pagination() {
            var data = {
            event : "pagination",
                select : "id",
                query : query,
                offset : offset,
                limit : limit,
                table : "tbl_store",
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

        // uses function get_data(
        pagination.onchange(function(){
            offset = $(this).val();
            get_data(query);
        })

        // used : 1 
        // uses function client_validate_data(
        // uses function check_current_db(
        // uses function load_swal(
        // uses function save_to_db(
        function save_data(e) {
            var code = $('#code').val()
            var description = $('#description').val()

            if(client_validate_data(code, description)) {
                check_current_db(function (result) {
                    var err_msg = '';
                    var valid = true;
                    var result = JSON.parse(result);
                    $.each(result, function(index, item) {
                        if (item.code === code) {
                            valid = false
                            err_msg += "Code already exists in masterfile<br>";
                        }
                        if (item.description === description) {
                            valid = false
                            err_msg += "Description already exists in masterfile<br>";
                        }
                    });

                    if(!valid){
                        load_swal(
                            'add_alert',
                            '500px',
                            "error",
                            "Error!",
                            err_msg,
                            false,
                            false
                        )
                    } else {
                        var chk_status = $('#status').prop('checked')
                        if (chk_status) {
                            status_val = 1
                        } else {
                            status_val = 0
                        }
                        modal.confirm("Are you sure you want to save this record?",function(result){
                            if(result){ 
                                save_to_db(code, description, status_val)
                            }
                        })
                    };
                })
            }
        }

        function save_to_db(inp_code, inp_description, status_val) {
            var url = "<?= base_url('cms/global_controller');?>";
            var data = {
                event : "insert", 
                table : "tbl_store",
                data : {
                        code : inp_code,
                        description : inp_description,
                        created_date : formatDate(new Date()),
                        created_by : user_id,
                        status : status_val
                }  
            }

            aJax.post(url,data,function(result){
                var obj = is_json(result);
                location.reload();
            });
        }

        function update_data(id) {
            var inp_id = $('#e_id').val()
            var inp_code = $('#e_code').val()
            var inp_description = $('#e_description').val()
            var chk_status = $('#e_status').prop('checked')

            if(client_validate_data(inp_code, inp_description)) {
                var err_msg = '';
                var valid = true;
                
                check_current_db(function (result) {
                    var result = JSON.parse(result);
                    var status_msg = '';
                    // server_validate_data();
                    // check if code and description already exists in the database
                    $.each(result, function(index, item) {
                        if(chk_status) {
                            status_val = 1
                        } else {
                            status_val = 0
                        }
                        if (item.status == status_val) {
                            if (item.code ===  inp_code && inp_id != item.id) {
                                valid = false
                                err_msg += "Code already exists in masterfile<br>";
                            }
                            if (item.description === inp_description && inp_id != item.id) {
                                valid = false
                                err_msg += "Description already exists in masterfile<br>";
                            }
                        }
                    });
                    // if it does show sweet alert
                    if(!valid){
                        load_swal(
                            'add_alert',
                            '500px',
                            "error",
                            "Error!",
                            err_msg,
                            false,
                            false
                        )
                    } 
                    // otherwise proceed to saving
                    else {
                        modal.confirm("Are you sure you want to update this record?",function(result){
                            if(result){ 
                                if (chk_status) {
                                    status_val = 1
                                } else {
                                    status_val = 0
                                }
                                var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
                                var data = {
                                    event : "update", // list, insert, update, delete
                                    table : "tbl_store", //table
                                    field : "id",
                                    where : id, 
                                    data : {
                                            code : inp_code,
                                            description : inp_description,
                                            updated_by : user_id,
                                            updated_date : formatDate(new Date()),
                                            status : status_val
                                    }  
                                }

                                aJax.post(url,data,function(result){
                                    var obj = is_json(result);
                                    location.reload();
                                });
                            }
                        });
                    }
                })
            
            }
        }

        // used : 1
        // uses function view_data(
        function edit_data(e_id) {
            // alert(code)
            title = addNbsp('EDIT STORE/BRANCH')
            $("#edit_modal").find('.modal-title').find('b').html(title)
            view_data(e_id, 'e_', 'edit_modal', 'EDIT ')
        }

        // used : 1
        // uses function formatDate(
        function delete_data(id) {
            // alert(id); return;
            modal.confirm("Are you sure you want to delete this record?",function(result){
                if(result){ 
                    var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
                    var data = {
                        event : "update", // list, insert, update, delete
                        table : "tbl_store", //table
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
                        location.reload();
                    });
                }

            });
        }

        // used : 2
        function view_data(inp_id, prefix, modal_class,action) {
            var query = "id = " + inp_id;
            var url = "<?= base_url('cms/global_controller');?>";
            var data = {
                event : "list", 
                select : "id, code, description, status",
                query : query, 
                table : "tbl_store"
            }
            aJax.post(url,data,function(result){
                var obj = is_json(result);
                if(obj){
                    $.each(obj, function(x,y) {
                        $('#'+prefix+'id').val(y.id);
                        $('#'+prefix+'code').val(y.code);
                        $('#'+prefix+'description').val(y.description);
                        if(y.status == 1) {
                            $('#'+prefix+'status').prop('checked', true)
                        } else {
                            $('#'+prefix+'status').prop('checked', false)
                        }
                    }); 
                }
                
                $('#update_data').attr('data-id', inp_id);
                title = addNbsp(action+'STORE/BRANCH')
                $("#"+modal_class).find('.modal-title').find('b').html(title)
                $('#'+modal_class).modal('show');
            });
        }

        // used : 2
        function check_current_db(successCallback) {
            var data = {
                event : "list",
                select : "id, code, description, status",
                query : query,
                offset : 0,
                limit : 0,
                table : "tbl_store",
            }
            jQuery.ajax({
                url: url,
                type: 'post',
                data: data,
                async: false,
                success: function (res) {
                    successCallback(res);
                }, error(e){
                    alert('alert', e)
                    console.log(e)
                }
            });
        }

        // used : 2
        // uses function load_swal(
        function client_validate_data(code, description, e) {
            var invalid = false;
            var err_title = 'Error!'
            var err_msg = '';
            var result = true;
            // remove leading and trailing whitespace from user input
            var trim_code = code.trim();
            var trim_desc = description.trim()
            // check for empty fields
            if (trim_code === "" && trim_desc === "") {
                invalid = true; // Mark the input as invalid.
                err_msg+= "Code and Description is required<br>"; // Add error message.
            }
            else if (trim_code == "") {
                invalid = true;
                err_msg+= 'Code is required<br>';
            }
            else if (trim_desc == "") {
                invalid = true;
                err_msg+= 'Description is required<br>';
            }
            // check if the input exceeds the maximum allowed length for the database (25 characters).
            if (trim_code.length > 25) {
                invalid = true;
                err_msg += "Code is too long. Maximum allowed is 25 characters.<br>";
            }
            // check if the input exceeds the maximum allowed length for the database (50 characters).
            if (trim_desc.length > 50) {
                invalid = true;
                err_msg+="Description is too long. Maximum allowed is 50 characters.<br>";
            }

            // if input is invalid (invalid = true) display alert to user
            if (invalid) {
                load_swal(
                    'add_alert', // custom class in case you want to modify the alert
                    '500px',
                    "error", // alert style
                    "Error!", // title.
                    err_msg, // message
                    false, // prevent closing alert by clicking outside of alert
                    false // prevent closing alert by pressing escape key
                );
                
                result = false; // assign false to result to prevent saving
            }

            return result;
        }

        // used : 3
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

        // used : 3
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

        // used : 7
        function get_data(new_query) {
            var data = {
                event : "list",
                select : "id, code, description, status",
                query : new_query,
                offset : offset,
                limit : limit,
                table : "tbl_store",
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
                            html += "<td style='width: 20%'>" + y.code + "</td>";
                            html += "<td style='width: 40%'>" + y.description + "</td>";
                            html += "<td style='width: 10%'>" + status + "</td>";

                            if (y.id == 0) {
                                html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                            } else {
                                html+="<td class='center-content' style='width: 25%'>";
                                html+="<a class='btn-sm btn save' onclick=\"edit_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Edit Details'><span class='glyphicon glyphicon-pencil'>Edit</span>";
                                html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Delete Item'><span class='glyphicon glyphicon-pencil'>Delete</span>";
                                html+="<a class='btn-sm btn view' onclick=\"view_data('"+y.id+"', 'v_', 'view_modal', 'VIEW ')\" data-status='"+y.status+"' id='"+y.id+"' title='Show Details'><span class='glyphicon glyphicon-pencil'>View</span>";
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

        // addNbsp()™: A Truly Revolutionary Function
        // This function is the epitome of laziness and brilliance combined. 
        // Why manually type `&nbsp;` repeatedly when you can let JavaScript do the heavy lifting?
        // With `addNbsp`, you can transform every character in a string into a spaced-out masterpiece,
        // replacing regular spaces with double `&nbsp;&nbsp;` and adding `&nbsp;` after every other character. 
        // It’s elegant. It’s lazy. It’s genius.
        // Honestly, this function is not just a tool—it’s a lifestyle.
        function addNbsp(inputString) {
            return inputString.split('').map(char => {
                if (char === ' ') {
                return '&nbsp;&nbsp;';
                }
                return char + '&nbsp;';
            }).join('');
        }
</script>