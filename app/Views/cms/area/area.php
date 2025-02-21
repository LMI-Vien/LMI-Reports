
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

    .ui-widget {
        z-index: 1051 !important;
    }
</style>

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
                                        <!-- <th class='center-content'>Store</th> -->
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
                            <!-- <datalist id="stores">
                            </datalist> -->
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

                            <div class="import_buttons">
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
                            </div>

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
                    <button type="button" class="btn save" onclick="process_xl_file()">Validate and Save</button>
                </div>
            </div>
        </div>
    </div>


    
<script>
    var query = "status >= 0";
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url("cms/global_controller");?>";
    var base_url = '<?= base_url();?>';

    let currentPage = 1;
    let rowsPerPage = 1000;
    let totalPages = 1;
    let dataset = [];
    let stores_under_area = []
    
    $(document).ready(function() {
        get_data(query);
        get_pagination(query);

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

        if (['edit', 'view'].includes(actions)) populate_modal(id, actions);
        let isReadOnly = actions === 'view';
        set_field_state('#code, #description, #status, #store_0', isReadOnly);
        
        $store_list.empty()
        $footer.empty();
        if (actions === 'add') {
            
            let line = get_max_number();

            let html = `
            <div id="line_${line}" class="ui-widget" style="display: flex; align-items: center; gap: 5px; margin-top: 3px;">
                <input id='store_${line}' class='form-control'>
                <button type="button" class="rmv-btn" onclick="remove_line(${line})">
                    <i class="fa fa-minus" aria-hidden="true"></i>
                </button>
            </div>
            `;

            $('#store_list').append(html);

            $(`#store_${line}`).autocomplete({
                source: function(request, response) {
                    var results = $.ui.autocomplete.filter(storeDescriptions, request.term);
                    var uniqueResults = [...new Set(results)];
                    response(uniqueResults.slice(0, 10));
                },
            });
            $('.add_line').attr('disabled', false)
            $('.add_line').attr('readonly', false)
            $footer.append(buttons.save)
        };
        if (actions === 'edit') {
            $footer.append(buttons.edit)
            set_field_state('.add_line', false)
        };
        if (actions === 'view') {
            set_field_state('.add_line', true)
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
        <div id="line_${line}" class="ui-widget" style="display: flex; align-items: center; gap: 5px; margin-top: 3px;">
            <input id='store_${line}'>
            <button type="button" class="rmv-btn" onclick="remove_line(${line})">
                <i class="fa fa-minus" aria-hidden="true"></i>
            </button>
        </div>
        `;

        $('#store_list').append(html);

        $(`#store_${line}`).autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(storeDescriptions, request.term);
                var uniqueResults = [...new Set(results)];
                response(uniqueResults.slice(0, 10));
            },
        });
        get_store('', `store_${line}`);
    }

    function remove_line(lineId) {
        $(`#line_${lineId}`).remove();
    }
    
    function populate_modal(inp_id, actions) {
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
                    var disabled = '';
                    let $store_list = $('#store_list')
                    $.each(get_area_stores(d.id), (x, y) => {
                        if (action === 'view') {
                            disabled = 'disabled';
                            readonly = 'readonly';
                        } else {
                            readonly = '';
                            disabled = ''
                        }
                        get_field_values('tbl_store', 'description', 'id', [y.store_id], (res) => {
                            $.each(res, (x, y) => {
                                // console.log(res);

                                if (action === 'edit') {
                                    readonly = (line == 0) ? 'readonly' : '';
                                    disabled = (line == 0) ? 'disabled' : '';
                                }

                                let html = `
                                <div id="line_${line}" class="ui-widget" style="display: flex; align-items: center; gap: 5px; margin-top: 3px;">
                                    <input id='store_${line}' class='form-control' value='${y}' ${action === 'view' ? 'readonly' : ''}>
                                    <button type="button" class="rmv-btn" onclick="remove_line(${line})" ${disabled} ${readonly}>
                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                    </button>
                                </div>
                                `;

                                $('#store_list').append(html);

                                $(`#store_${line}`).autocomplete({
                                    source: function(request, response) {
                                        var results = $.ui.autocomplete.filter(storeDescriptions, request.term);
                                        var uniqueResults = [...new Set(results)];
                                        response(uniqueResults.slice(0, 10));
                                    },
                                });
                                get_store(x, `store_${line}`);
                                line++
                            });
                        });
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
    
    function read_xl_file() {
        let btn = $(".btn.save");
        btn.prop("disabled", false); 
        clear_import_table();
        
        dataset = [];

        const file = $("#file")[0].files[0];
        if (!file) {
            modal.loading_progress(false);
            modal.alert('Please select a file to upload', 'error', ()=>{});
            return;
        }

        // File Size Validation (Limit: 30MB) temp
        const maxFileSize = 30 * 1024 * 1024; // 30MB in bytes
        if (file.size > maxFileSize) {
            modal.loading_progress(false);
            modal.alert('The file size exceeds the 30MB limit. Please upload a smaller file.', 'error', () => {});
            return;
        }
        modal.loading_progress(true, "Reviewing Data...");

        const reader = new FileReader();
        reader.onload = function(e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, { type: "array" });
            const sheet = workbook.Sheets[workbook.SheetNames[0]];

            const jsonData = XLSX.utils.sheet_to_json(sheet, { raw: false });

            // Process in chunks
            processInChunks(jsonData, 5000, () => {
                paginateData(rowsPerPage);
            });
        };
        reader.readAsArrayBuffer(file);
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
            let td_validator = ['code', 'description', 'stores', 'status'];
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
    
    let storeDescriptions = [];
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
            // var html = '<option id="default_val" value=" ">Select Store</option>';
            var html = '';
    
            if(result) {
                if (result.length > 0) {
                    var selected = '';
                    
                    result.forEach(function (y) {
                        storeDescriptions.push(y.description);
                        html += `<option value="${y.description}">`;
                    });
                }
            }
            // console.log(html);
            $('#stores').append(html);
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

    function process_xl_file() {
        let btn = $(".btn.save");
        if (btn.prop("disabled")) return; // Prevent multiple clicks

        btn.prop("disabled", true);
        $(".import_buttons").find("a.download-error-log").remove();

        if (!dataset.length) {
            modal.alert("No data to process. Please upload a file.", "error");
            return;
        }

        modal.loading(true);

        let jsonData = dataset.map(row => {
            if (row["stores"]) {
                let storeList = row["stores"].split(",").map(item => item.trim().toLowerCase());
                row["stores"] = [...new Set(storeList)]; // Remove duplicates
            }
            return {
                "Code": row["code"] || "",
                "Name": row["description"] || "", 
                "Status": row["status"] || "", 
                "Stores": row["stores"] || "", 
                "Created By": user_id || "",
                "Created Date": formatDate(new Date()) || ""
            };
        });

        let worker = new Worker(base_url + "assets/cms/js/validator_area.js");
        worker.postMessage({ data: jsonData, base_url });

        worker.onmessage = function(e) {
            modal.loading_progress(false);
            const { invalid, errorLogs, valid_data, err_counter, store_per_area } = e.data;

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
                setTimeout(() => saveValidatedData(valid_data, store_per_area), 500);
            } else {
                btn.prop("disabled", false);
                modal.alert("No valid data returned. Please check the file and try again.", "error", () => {});
            }
        };

        worker.onerror = function() {
            modal.loading_progress(false);
            modal.alert("Error processing data. Please try again.", "error");
        };
    }

    function saveValidatedData(valid_data, store_per_area) {
        let batch_size = 5000;
        let total_batches = Math.ceil(valid_data.length / batch_size);
        let batch_index = 0;
        let errorLogs = [];
        let url = "<?= base_url('cms/global_controller');?>";
        let table = 'tbl_area';
        let selected_fields = ['id', 'code', 'description'];

        const existingMapByCode = new Map(), existingMapByDescription = new Map();
        const matchType = "OR";  //use OR/AND depending on the condition

        modal.loading_progress(true, "Validating and Saving data...");

        aJax.post(url, { table: table, event: "fetch_existing", status: true, selected_fields: selected_fields }, function(response) {
            let result = JSON.parse(response);
            if (result.existing) {
                result.existing.forEach(record => {
                    existingMapByCode.set(record.code, record.id);
                    existingMapByDescription.set(record.description, record.id);
                });
            }

            function updateOverallProgress(stepName, completed, total) {
                let progress = Math.round((completed / total) * 100);
                updateSwalProgress(stepName, progress);
            }

            function processNextBatch() {
                if (batch_index >= total_batches) {
                    modal.loading_progress(false);

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
                    let matchByCode = existingMapByCode.get(row.code);
                    let matchByDescription = existingMapByDescription.get(row.description);

                    let matchFound = false;
                    let existingId = null;

                    if (matchType === "AND") {
                        if (matchByCode && matchByDescription && matchByCode === matchByDescription) {
                            matchFound = true;
                            existingId = matchByCode;
                        }
                    } else if (matchType === "OR") {
                        if (matchByCode || matchByDescription) {
                            matchFound = true;
                            existingId = matchByCode || matchByDescription;
                        }
                    }

                    if (matchFound) {
                        row.id = existingId;
                        row.updated_date = formatDate(new Date());
                        updateRecords.push(row);
                    } else {
                        row.created_by = user_id;
                        row.created_date = formatDate(new Date());
                        newRecords.push(row);
                    }
                });

                function processUpdates(callback) {
                    if (updateRecords.length > 0) {
                        batch_update(url, updateRecords, "tbl_area", "id", true, (response) => {
                            if (response.message !== 'success') {
                                errorLogs.push(`Failed to update: ${JSON.stringify(response.error)}`);
                            }
                            updateOverallProgress("Updating Areas...", batch_index + 1, total_batches);
                            processStorePerArea(updateRecords.map(r => ({ id: r.id, code: r.code })), store_per_area, callback);
                        });
                    } else {
                        callback(); // Proceed even if no updates
                    }
                }

                function processInserts() {
                    if (newRecords.length > 0) {
                        batch_insert(url, newRecords, "tbl_area", true, (response) => {
                            if (response.message === 'success') {
                                let inserted_ids = response.inserted;
                                updateOverallProgress("Saving Areas...", batch_index + 1, total_batches);
                                processStorePerArea(inserted_ids, store_per_area, function() {
                                    batch_index++;
                                    setTimeout(processNextBatch, 300);
                                });
                            } else {
                                errorLogs.push(`Batch insert failed: ${JSON.stringify(response.error)}`);
                                batch_index++;
                                setTimeout(processNextBatch, 300);
                            }
                        });
                    } else {
                        batch_index++;
                        setTimeout(processNextBatch, 300);
                    }
                }

                processUpdates(processInserts);
            }

            setTimeout(processNextBatch, 1000);
        });
    }

    function processStorePerArea(inserted_ids, store_per_area, callback) {
        let batch_size = 5000;
        let storeBatchIndex = 0;
        let storeDataKeys = Object.keys(store_per_area);
        let total_store_batches = Math.ceil(storeDataKeys.length / batch_size);
        let insertedMap = {};

        inserted_ids.forEach(({ id, code }) => {
            insertedMap[code] = id;
        });

        function processNextStoreBatch() {
            if (storeBatchIndex >= total_store_batches) {
                callback();
                return;
            }

            let chunkKeys = storeDataKeys.slice(storeBatchIndex * batch_size, (storeBatchIndex + 1) * batch_size);
            let chunkData = [];
            let areaIdsToDelete = [];

            chunkKeys.forEach(code => {
                if (insertedMap[code]) {
                    let area_id = insertedMap[code];
                    let store_ids = store_per_area[code];
                    areaIdsToDelete.push(area_id);
                    store_ids.forEach(store_id => {
                        chunkData.push({
                            area_id: area_id,
                            store_id: store_id,
                            created_by: user_id,
                            created_date: formatDate(new Date()),
                            updated_date: formatDate(new Date())
                        });
                    });
                }
            });

            function insertNewStoreRecords(chunkData) {
                if (chunkData.length > 0) {
                    batch_insert(url, chunkData, "tbl_store_group", false, function(response) {
                        storeBatchIndex++;
                        setTimeout(processNextStoreBatch, 100);
                    });
                } else {
                    storeBatchIndex++;
                    setTimeout(processNextStoreBatch, 100);
                }
            }

            if (areaIdsToDelete.length > 0) {
                batch_delete(url, "tbl_store_group", "area_id", areaIdsToDelete, 'store_id', function(resp) {
                    insertNewStoreRecords(chunkData);
                });
            } else {
                insertNewStoreRecords(chunkData);
            }
        }

        if (storeDataKeys.length > 0) {
            processNextStoreBatch();
        } else {
            callback();
        }
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

    function fixEncoding(text) {
        let correctedText = text.replace(/\uFFFD|\u0092/g, "’");
        return correctedText;
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
        store_list.find('input').each(function() {
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
                            let batch = [];
                            let valid = true;
                            $.each(unique_store, (x, y) => {
                                get_field_values('tbl_store', 'id', 'description', [y], (res) => {
                                    if(res.length == 0) {
                                        valid = false;
                                    } else {
                                        modal_alert = 'success';
                                        $.each(res, (x, y) => {
                                            let data = {
                                                'area_id': id,
                                                'store_id': y,
                                                'created_by': user_id,
                                                'created_date': formatDate(new Date())
                                            };
                                            batch.push(data);
                                        })
                                    }
                                })
                            })

                            if(valid) {
                                save_to_db(code, description, store, status_val, id, (obj) => {
                                    total_delete(url, 'tbl_store_group', 'area_id', id);

                                    batch_insert(url, batch, 'tbl_store_group', false, () => {
                                        modal.loading(false);
                                        modal.alert(success_update_message, "success", function() {
                                            location.reload();
                                        });
                                    })
                                })
                                
                            } else {
                                // alert('mali');
                                modal.loading(false);
                                modal.alert('Store not found', 'error', function() {});
                            }
                        }
                    });

                }             
            });
        }else{
            check_current_db("tbl_area", ["code", "description"], [code, description], "status" , null, null, true, function(exists, duplicateFields) {
                if (!exists) {
                    modal.confirm(confirm_add_message,function(result){
                        if(result){ 
                            modal.loading(true);
                            save_to_db(code, description, store, status_val, null, (obj) => {
                                let batch = [];

                                $.each(unique_store, (x, y) => {
                                    get_field_values('tbl_store', 'id', 'description', [y], (res) => {
                                        $.each(res, (x, y) => {
                                            let data = {
                                                'area_id': obj.ID,
                                                'store_id': y,
                                                'created_by': user_id,
                                                'created_date': formatDate(new Date())
                                            };
                                            batch.push(data);
                                        });
                                    })
                                });
                                batch_insert(url, batch, 'tbl_store_group', false, () => {
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
            modal.loading(false);
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
                    total_delete(url, 'tbl_store_group', 'area_id', id)
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
                            html+="<td class='center-content' scope=\"col\">";
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

    $(document).on('click', '#btn_export', function () {
        modal.confirm(confirm_export_message,function(result){
            if (result) {
                handleExport()
            }
        })
    })

    function handleExport() {
        var new_query = query; // Default: assign query to new_query
        
        var ids = [];
        $('.select:checked').each(function () {
            var id = $(this).attr('data-id');
            ids.push(`'${id}'`); // Collect IDs in an array
        });

        // Only modify new_query if there are selected checkboxes
        if (ids.length > 0) {
            new_query += ' and id in (' + ids.join(', ') + ')';
        }

        var data = {
            event: "list",
            select: "id, code, description, status, updated_date, created_date",
            query: new_query,
            offset: 0,
            limit: 0,
            table: "tbl_area",
            order: {
                field: "code",
                order: "asc"
            }
        };

        aJax.post(url, data, function (result) {
            var result = JSON.parse(result);
            const formattedData = result.map(item => ({
                // ID: item.id,
                Code: item.code,
                Description: item.description,
                Status: item.status === "1" ? "Active" : "Inactive",
                "Updated Date": item.updated_date ? item.updated_date : "N/A",
                "Created Date": item.created_date
            }));

            const headerData = [
                ["Company Name: Lifestrong Marketing Inc."], // Row 1
                ["Masterfile: Area"], // Row 2
                ["Date Printed: " + formatDate(new Date())], // Row 3
                [""], // Empty row for spacing
            ];

            exportArrayToExcel(formattedData, "Masterfile: Area - " + formatDate(new Date()), headerData);
        });
    };

    function exportArrayToExcel(data, filename, headerData) {
        // Create a new workbook
        const workbook = XLSX.utils.book_new();

        // Convert data to worksheet
        const worksheet = XLSX.utils.json_to_sheet(data, { origin: headerData.length });

        // Add header rows manually
        XLSX.utils.sheet_add_aoa(worksheet, headerData, { origin: "A1" });

        // Append sheet to workbook
        XLSX.utils.book_append_sheet(workbook, worksheet, "Sheet1");

        // Generate Excel file
        const excelBuffer = XLSX.write(workbook, { bookType: "xlsx", type: "array" });

        // Convert buffer to Blob and trigger download
        const blob = new Blob([excelBuffer], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
        saveAs(blob, filename + ".xlsx");
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
