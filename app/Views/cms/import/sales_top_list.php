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
</style>

    <div class="content-wrapper p-4">
        <div class="card">
            <div class="text-center page-title md-center">
                <b>I M P O R T - S A L E S - T O P - L I S T</b>
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
                                        <!-- <th class='center-content'><input class="selectall" type="checkbox"></th> -->
                                        <!-- <th class='center-content'>Code</th>
                                        <th class='center-content'>Area Description</th>
                                         --><!-- <th class='center-content'>Store</th> -->
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
                            <div hidden>
                                <input type="text" class="form-control" id="id" aria-describedby="id">
                            </div>
                            <label for="code" class="form-label">Code</label>
                            <input type="text" class="form-control required" id="code" aria-describedby="store_code" maxlength="25">
                            <small class="form-text text-muted">* required, must be unique, max 25 characters</small>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Area Description</label>
                            <textarea class="form-control required" id="description" aria-describedby="store_description" maxlength="50"></textarea>
                            <small class="form-text text-muted">* required, must be unique, max 50 characters</small>
                        </div>
                        <div class="form-group">
                            <div class="row" >
                                <label class="col" >Store</label>
                                <input
                                    type="button"
                                    value="Add Store"
                                    class="row add_line"
                                    onclick="add_line()"
                                >
                            </div>
                            <div id="store_list">
                                <!-- <div id="line_0" style="display: flex; align-items: center; gap: 5px; margin-top: 3px;">
                                    <select name="store" class="form-control store_drop required" id="store_0"></select>
                                    <button type="button" class="rmv-btn" onclick="remove_line(0)" disabled readonly>
                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                    </button>
                                </div> -->
                            </div>
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
                                        <th class='center-content' scope="col">Line #</th>
                                        <th class='center-content' scope="col">Code</th>
                                        <th class='center-content' scope="col">Area</th>
                                        <th class='center-content' scope="col">Stores/Branches</th>
                                        <th class='center-content' scope="col">Status</th>
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
        get_pagination(query);

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
        get_store('', 'store_0');
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
        let $store_list = $('#store_list')
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

        $store_list.empty()
        $footer.empty();
        if (actions === 'add') {
            let line = get_max_number();

            let html = `
            <div id="line_${line}" style="display: flex; align-items: center; gap: 5px; margin-top: 3px;">
                <select name="store" class="form-control store_drop required" id="store_${line}"></select>
                <button type="button" class="rmv-btn" disabled readonly onclick="remove_line(${line})">
                    <i class="fa fa-minus" aria-hidden="true"></i>
                </button>
            </div>
            `;
            $store_list.append(html)
            $('.add_line').attr('disabled', false)
            $('.add_line').attr('readonly', false)
            $footer.append(buttons.save)
        };
        if (actions === 'edit') {
            $footer.append(buttons.edit)
            $('.add_line').attr('disabled', false)
            $('.add_line').attr('readonly', false)
        };
        if (actions === 'view') {
            $('.add_line').attr('disabled', true)
            $('.add_line').attr('readonly', true)
        }
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
    
    function get_max_number() {
        let storeElements = $('[id^="store_"]');
        
        let maxNumber = Math.max(
            0,
            ...storeElements.map(function () {
                return parseInt(this.id.replace("store_", ""), 10) || 0;
            }).get()
        );

        return maxNumber;
    }

    function add_line() {
        let line = get_max_number() + 1;

        let html = `
        <div id="line_${line}" style="display: flex; align-items: center; gap: 5px; margin-top: 3px;">
            <select name="store" class="form-control store_drop required" id="store_${line}"></select>
            <button type="button" class="rmv-btn" onclick="remove_line(${line})">
                <i class="fa fa-minus" aria-hidden="true"></i>
            </button>
        </div>
        `;
        $('#store_list').append(html);
        get_store('', `store_${line}`);
    }

    function remove_line(lineId) {
        $(`#line_${lineId}`).remove();
    }
    
    function populate_modal(inp_id) {
        var query = "status >= 0 and id = " + inp_id;
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, code, description, status",
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
                    // get_store(d.store, 'store_0');
                    var line = 0;
                    var readonly = '';
                    var disabled = ''
                    let $store_list = $('#store_list')
                    $.each(get_area_stores(d.id), (x, y) => {
                        if (line === 0) {
                            disabled = 'disabled';
                            readonly = 'readonly';
                        } else {
                            readonly = '';
                            disabled = ''
                        }
                        let html = `
                        <div id="line_${line}" style="display: flex; align-items: center; gap: 5px; margin-top: 3px;">
                            <select name="store" class="form-control store_drop required" id="store_${line}"></select>
                            <button type="button" class="rmv-btn" ${disabled} ${readonly} onclick="remove_line(${line})">
                                <i class="fa fa-minus" aria-hidden="true"></i>
                            </button>
                        </div>
                        `;
                        $store_list.append(html)
                        get_store(y.store_id, `store_${line}`);
                        line++
                    })
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

    $(document).on('click', '#btn_import ', function() {
        title = addNbsp('IMPORT AREA')
        $("#import_modal").find('.modal-title').find('b').html(title)
        $("#import_modal").modal('show')
        clear_import_table()
    });
    
    // function read_xl_file() {
    //     $(".import_table").empty()
    //     var html = '';
    //     const file = $("#file")[0].files[0];
    //     if (file === undefined) {
    //         load_swal(
    //             '',
    //             '500px',
    //             'error',
    //             'Error!',
    //             'Please select a file to upload',
    //             false,
    //             true
    //         )
    //         return
    //     }
    //     const reader = new FileReader();
    //     reader.onload = function(e) {
    //         const data = e.target.result;
    //         // convert the data to a workbook
    //         const workbook = XLSX.read(data, {type: "binary"});
    //         // get the first sheet
    //         const sheet = workbook.Sheets[workbook.SheetNames[0]];
    //         // convert the sheet to JSON
    //         const jsonData = XLSX.utils.sheet_to_json(sheet);

    //         var tr_counter = 0;
    //         jsonData.forEach(row => {
    //             var rowClass = (tr_counter % 2 === 0) ? "even-row" : "odd-row";
    //             html += "<tr class=\""+rowClass+"\">";
    //             html += "<td>";
    //             html += tr_counter+1;
    //             html += "</td>";

    //             let record = row;

    //             let lowerCaseRecord = Object.keys(record).reduce((acc, key) => {
    //                 acc[key.toLowerCase()] = record[key];
    //                 return acc;
    //             }, {});
    
    //             // create a table cell for each item in the row
    //             var td_validator = ['code', 'description', 'stores', 'status'];
    //             td_validator.forEach(column => {
    //                 html += "<td class=\"sample-id-"+lowerCaseRecord[column]+"\" id=\"" + column + "\">";
    //                 html += lowerCaseRecord[column] !== undefined ? lowerCaseRecord[column] : ""; // add value or leave empty
    //                 html += "</td>";
    //             });
    //             html += "</tr>";
    //             tr_counter += 1;
    //         });

    //         $(".import_table").append(html);
    //         html = '';
    //     };
    //     reader.readAsBinaryString(file);
    // }

    // with special characters
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

        // const maxFileSize = 30 * 1024 * 1024; // 30MB limit
        // if (file.size > maxFileSize) {
        //     modal.loading_progress(false);
        //     modal.alert('The file size exceeds the 30MB limit. Please upload a smaller file.', 'error', () => {});
        //     return;
        // }

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
    
    let storeDescriptions = {};
    function get_store(id, dropdown_id) {
        var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
        var data = {
            event : "list",
            select : "id, code, description, status",
            query : 'status >= 0',
            offset : 0,
            limit : 0,
            table : "tbl_store",
            order : {
                field : "code",
                order : "asc" 
            }
        }

        aJax.post(url,data,function(res){
            var result = JSON.parse(res);
            var html = '<option id="default_val" value=" ">Select Store</option>';
    
            if(result) {
                if (result.length > 0) {
                    var selected = '';
                    $.each(result, function(x,y) {
                        storeDescriptions[y.id] = y.description;
                        if (id === y.id) {
                            selected = 'selected'

                        } else {
                            selected = ''
                        }
                        html += "<option value='"+y.id+"' "+selected+">"+y.description+"</option>"
                    })
                }
            }
            $('#'+dropdown_id).empty();
            $('#'+dropdown_id).append(html);
        })
    }

    function get_area_stores(area_id) {
        var data = {
            event : "list",
            select : "id, area_id, store_id",
            query : 'id > 0 and area_id = '+area_id,
            offset : 0,
            limit : 0,
            table : "tbl_store_group",
            order : {
                field : "id",
                order : "asc" 
            }
        }
        var result = '';

        aJax.post_async(url,data,function(res){
            result = JSON.parse(res);
        })

        return result;
    }

    let storedFile = null;

    function store_file(event) {
        storedFile = event.target.files[0]; // Store the file but do nothing yet
    }

    function proccess_xl_file() {
        var extracted_data = $(".import_table");

        var code = '';
        var description = '';
        var status = '';
        var deployment_date = '';
        var area_id = '';

        var invalid = false;
        var errmsg = '';

        var unique_code = [];
        var unique_description = [];
        var store_per_area = {};

        var import_array = [];
        var needle = [];

        var tr_count = 1;
        var row_mapping = {};

        extracted_data.find('tr').each(function (){
            td_count = 1;
            var temp = [];
            $(this).find('td').each(function () {
                var text_val = $(this).html().trim();
                var error_messages = {
                    code: {
                        duplicate: "⚠️ Duplicated Code at line #: <b>{line}</b>⚠️<br>",
                        length: "⚠️ Code exceeds 25 characters at line #: <b>{line}</b>⚠️<br>",
                        empty: "⚠️ Code is empty at line #: <b>{line}</b>⚠️<br>"
                    },
                    description: {
                        duplicate: "⚠️ Duplicated Description at line #: <b>{line}</b>⚠️<br>",
                        length: "⚠️ Description exceeds 50 characters at line #: <b>{line}</b>⚠️<br>",
                        empty: "⚠️ Description is empty at line #: <b>{line}</b>⚠️<br>"
                    },
                    status: "⚠️ Invalid Status at line #: <b>{line}</b>⚠️<br>"
                };

                const validateField = (type, value, maxLength, uniqueList) => {
                    if (uniqueList.includes(value)) {
                        // invalid = true;
                        errmsg += error_messages[type].duplicate.replace("{line}", tr_count);
                    } else if (value.length > maxLength) {
                        invalid = true;
                        errmsg += error_messages[type].length.replace("{line}", tr_count);
                    } else if (!value) {
                        invalid = true;
                        errmsg += error_messages[type].empty.replace("{line}", tr_count);
                    } else {
                        uniqueList.push(value);
                        row_mapping[value] = tr_count;
                    }
                    return value;
                };

                switch (td_count) {
                    case 2:
                        code = validateField("code", text_val, 25, unique_code);
                        if (!store_per_area[code]) {
                            store_per_area[code] = [];
                        }
                        break;
                    case 3:
                        description = validateField("description", text_val, 50, unique_description);
                        break;
                    case 4:
                        stores = text_val;
                        if (!store_per_area[code].includes(stores)) {
                            store_per_area[code].push(stores);
                        }
                        break;
                    case 5:
                        if (["active", "inactive"].includes(text_val.toLowerCase())) {
                            status = text_val.toLowerCase() === "active" ? 1 : 0;
                        } else {
                            invalid = true;
                            errmsg += error_messages.status.replace("{line}", tr_count);
                        }
                        break;
                }

                td_count++;
            })
            tr_count += 1;
            if (!needle.some(item => item[0] === code)) {
                needle.push([code, description]);
            }

            if (!import_array.some(item => item[0] === code)) {
                let temp = []; 
                temp.push(code, description, status);
                import_array.push(temp);
            }
        })

        if (tr_count === 1) {
            modal.alert('Please select a file to upload', 'error', ()=>{})
            return;
        }

        var temp_invalid = invalid;
        var temp_errmsg = '';

        invalid = temp_invalid;
        errmsg += temp_errmsg;

        var table = 'tbl_area';
        var haystack = ['code', 'description'];
        var selected_fields = ['id', 'code', 'description'];

        if (invalid) {
            modal.content('Error', 'error', errmsg, '600px', ()=>{});
        } else {
            list_existing(table, selected_fields, haystack, needle, function (result) {
                if (result.status != "error") {
                    var batch = [];
                    import_array.forEach(row => {
                        let data = {
                            'code': row[0],
                            'description': row[1],
                            'status': row[2],
                            'created_by': user_id,
                            'created_date': formatDate(new Date())
                        };

                        if (!batch.some(item => item.code === row[0])) {
                            batch.push(data);
                        }
                    });
    
                    modal.loading(true);
                    setTimeout(() => {
                        modal.loading(false);
                        batch_insert(batch, 'tbl_area',(result) => {

                            var temp_store_list = []
                            $.each(store_per_area, (x, stores) => {
                                $.each(stores, (a, b) => {
                                    if(!temp_store_list.includes(fixEncoding(b))) {
                                        temp_store_list.push(fixEncoding(b))
                                    }
                                })
                            })

                            var store_list_mapping = []
                            get_field_values(
                                "tbl_store", 
                                "description", 
                                "description",
                                temp_store_list,
                                (res) => {
                                    $.each(res, (x, y)=>{
                                        store_list_mapping[y] = x
                                    })
                                }
                            )

                            var store_batch = [];
                            $.each(result.message, (x,y) => {
                                $.each(store_per_area[y.code], (a,b) => {
                                    console.log(fixEncoding(b))
                                    console.log(y.id, store_list_mapping[fixEncoding(b)], user_id, formatDate(new Date()))
                                    temp = {
                                        'area_id': y.id,
                                        'store_id': store_list_mapping[fixEncoding(b)],
                                        'created_by': user_id,
                                        'created_date': formatDate(new Date())
                                    }
                                    store_batch.push(temp)
                                })
                            })
                            console.log(store_batch)
                            batch_insert(store_batch, 'tbl_store_group',(result) => {
                                modal.loading(false);
                                modal.alert(success_save_message, 'success', () => {
                                    if (result) {
                                        location.reload();
                                    }
                                })
                            })
                        })
                    }, 1000);
                }
            })
        }
    }

    function fixEncoding(text) {
        let correctedText = text.replace(/\uFFFD|\u0092/g, "’");
        return correctedText;
    }

    function batch_insert(insert_batch_data, batch_table, cb){
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event: "batch_insert",
            table: batch_table,
            insert_batch_data: insert_batch_data
        }

        aJax.post(url,data,function(result){
            cb(result)
        });
    }

    $(document).on('keydown', '#search_query', function(event) {
        $('.btn_status').hide();
        $(".selectall").prop("checked", false);
        if (event.key == 'Enter') {
            search_input = $('#search_query').val();
            offset = 1;
            new_query = query;
            new_query += ' and code like \'%'+search_input+'%\' or '+query+' and description like \'%'+search_input+'%\'';
            get_data(new_query);
            get_pagination(new_query);
        }
    });

    function get_pagination(query) {
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
        var linenum = 0;
        var unique_store = [];
        var store_list = $('#store_list');
        // add_line
        store_list.find('select').each(function() {
            linenum++
            if (!unique_store.includes($(this).val())) {
                unique_store.push($(this).val())
            }
        });
        if (chk_status) {
            status_val = 1;
        } else {
            status_val = 0;
        }
        // return;
        if (id !== undefined && id !== null && id !== '') {
            check_current_db("tbl_area", ["code", "description"], [code, description], "status" , "id", id, true, function(exists, duplicateFields) {
                if (!exists) {
                    modal.confirm(confirm_update_message,function(result){
                        if(result){ 
                             modal.loading(true);
                            save_to_db(code, description, store, status_val, id, (obj) => {
                                total_delete('tbl_store_group', 'area_id', id)
                                let batch = [];
                                $.each(unique_store, (x, y) => {
                                    let data = {
                                        'area_id': id,
                                        'store_id': y,
                                        'created_by': user_id,
                                        'created_date': formatDate(new Date())
                                    };
                                    batch.push(data);
                                })
                                batch_insert(batch, 'tbl_store_group', () => {
                                    modal.loading(false);
                                    modal.alert(success_save_message, "success", function() {
                                        location.reload();
                                    });
                                })
                            })
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
                            save_to_db(code, description, store, status_val, null, (obj) => {
                                let batch = [];
                                $.each(unique_store, (x, y) => {
                                    let data = {
                                        'area_id': obj.ID,
                                        'store_id': y,
                                        'created_by': user_id,
                                        'created_date': formatDate(new Date())
                                    };
                                    batch.push(data);
                                })
                                batch_insert(batch, 'tbl_store_group', () => {
                                    modal.loading(false);
                                    modal.alert(success_save_message, "success", function() {
                                        location.reload();
                                    });
                                })
                            })
                        }
                    });
                }                  
            });
        }
    }

    function total_delete(delete_table, delete_field, delete_where) {
        data = {
            event : "total_delete",
            table : delete_table,
            field : delete_field,
            where : delete_where
        }
        aJax.post(url,data,function(result){
            // console.log(result)
        })
    }

    function save_to_db(inp_code, inp_description, inp_store, status_val, id, cb) {
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
                    // store: inp_store,
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
                    // store: inp_store,
                    created_date: formatDate(new Date()),
                    created_by: user_id,
                    status: status_val
                }
            };
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result);
            cb(obj)
            // modal.loading(false);
            // modal.alert(modal_alert_success, "success", function() {
            //     location.reload();
            // });
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
                    modal.alert(success_delete_message, "success", function() {
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
            select : "id, code, description, status, created_date, updated_date",
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
                        html += "<td scope=\"col\">" + trimText(y.code, 10) + "</td>";
                        html += "<td scope=\"col\">" + trimText(y.description, 10) + "</td>";
                        // html += "<td style='width: 20%'>" + y.store + "</td>";
                        html += "<td scope=\"col\">" + status + "</td>";
                        html += "<td scope=\"col\">" + (y.created_date ? ViewDateformat(y.created_date) : "N/A") + "</td>";
                        html += "<td scope=\"col\">" + (y.updated_date ? ViewDateformat(y.updated_date) : "N/A") + "</td>";

                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                            html+="<td class='center-content' style='width: 25%; min-width: 300px'>";
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
                offset = 1;
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
                                    modal.alert(modal_alert_success, "success", function () {
                                        location.reload();
                                    });
                                }
                            } else {
                                if (!hasExecuted) {
                                    hasExecuted = true;
                                    modal.alert(failed_transaction_message, "error", function () {});
                                }
                            }
                        });
                    });
                }
            });
        });
        
    function trimText(str, length) {
        if (str.length > length) {
            return str.substring(0, length) + "...";
        } else {
            return str;
        }
    }
</script>