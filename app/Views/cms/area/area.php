
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

    #list-data {
        overflow: visible !important;
        max-height: none !important;
        overflow-x: hidden !important;
        overflow-y: hidden !important;
    }

    /* .store-table {
        margin-top: 10px;
        width: 100%;
    } */
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
                                        <th class='center-content'>Area Code</th>
                                        <th class='center-content'>Area Description</th>
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
                            <label for="code" class="form-label">Area Code</label>
                            <input type="text" class="form-control" id="code" disabled>
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
                            <div id="store_list"></div>
                            <div id="stores"></div>
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
                                        <th class='center-content' scope="col">Line #</th>
                                        <th class='center-content' scope="col">Area Description</th>
                                        <th class='center-content' scope="col">Store Codes</th>
                                        <th class='center-content' scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="word_break import_table"></tbody>
                            </table>
                        </div>
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
    var query = "a.status >= 0";
    var column_filter = '';
    var order_filter = '';
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url("cms/global_controller");?>";
    var base_url = '<?= base_url();?>';

    let currentPage = 1;
    let rowsPerPage = 1000;
    let totalPages = 1;
    let dataset = [];
    let stores_under_area = []

    let stores = new Set();
    let html = "";
    let paginator = 0;

    let addedStores = [];
    let removedStores = [];
    
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
        get_pagination(query);
        modal.loading(false);
    });
    
    $(document).on('click', '#btn_add', function() {
        get_store('', 'store_0');
        open_modal('Add New Area', 'add', '', '');
    });

    function close_modal(callback) {
        if (typeof modal.close === "function") {
            modal.close();
            clear_stores();
        }
        setTimeout(callback, 300); 
    }

    function edit_data(id, code) {
        close_modal(() => {
            modal.loading(true);
            open_modal('Edit Area', 'edit', id, code, () => {
                modal.loading(false);
                // clear_stores();
            });
        });
    }

    function view_data(id, code) {
        close_modal(() => {
            modal.loading(true);
            open_modal('View Area', 'view', id, code, () => {
                modal.loading(false);
                // clear_stores();
            });
        });
    }
    
    // backup
    function open_modal(msg, actions, id, code) {
        window.lastFocusedElement = document.activeElement;
        $(".form-control").css('border-color','#ccc');
        $(".validate_error_message").remove();
        let $modal = $('#popup_modal');
        let $store_list = $('#store_list')
        let $footer = $modal.find('.modal-footer');
        let $contentWrapper = $('.content-wrapper');

        $modal.find('.modal-title b').html(addNbsp(msg));
        reset_modal_fields();
        clear_stores();

        let buttons = {
            save: create_button('Save', 'save_data', 'btn save', function () {
                if (validate.standard("form-modal")) {
                    save_data('save', null, null);
                }
            }),
            edit: create_button('Update', 'edit_data', 'btn update', function () {
                if (validate.standard("form-modal")) {
                    save_data('update', id, code);
                }
            }),
            close: create_button('Close', 'close_data', 'btn caution', function () {
                $modal.modal('hide');
            })
        };

        if (['edit', 'view'].includes(actions)) {
            populate_modal(id, actions, () => {
                modal.loading(false); 
            });
        }

        let isReadOnly = actions === 'view';
        set_field_state('#code, #description, #status', isReadOnly);
        
        $store_list.empty()
        $footer.empty();
        if (actions === 'add') {

            let line = get_max_number();

            let html = `
            <div id="line" class="ui-widget" style="display: flex; align-items: center; gap: 5px; margin-top: 3px;">
                <input id='store' class='form-control' placeholder='Select store'>
            </div>
            `;

            $('#store_list').append(html);

            $(`#store`).autocomplete({
                source: function(request, response) {
                    var results = $.ui.autocomplete.filter(storeDescriptions, request.term);
                    var uniqueResults = [...new Set(results)];
                    response(uniqueResults.slice(0, 10));
                },
                minLength: 0,
            }).focus(function () {
                $(this).autocomplete("search", "");
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

    function clear_stores() {
        stores.clear();
        $('#stores').empty();
    }
    
    function reset_modal_fields() {
        $('#popup_modal #code, #popup_modal #description, #popup_modal #store').val('');
        $('#popup_modal #status').prop('checked', true);
        setTimeout(() => {
            $('#popup_modal #code').prop('disabled', true)
        }, 500);
        
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
        const storeName = ($('#store').val() || '').trim();
        const storeCode = storeName.split(' - ')[0];
        if (!storeName) return;

        if (!$('#stores_list').length) {
            $('#stores').append(`
                <table class="table table-bordered mt-2" id="stores_list" border="1">
                    <thead>
                        <tr>
                            <th>Store Code</th>
                            <th>Store Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="table-body word_break"></tbody>
                </table>
            `);
        }

        const $tbody = $('#stores_list tbody');
        
        const line = $tbody.children('tr').length + 1;

        const newRow = `
            <tr id="line_${line}">
                <td>${storeCode}</td>
                <td>
                    <input
                        id="store_${line}"
                        class="form-control"
                        placeholder="Select store"
                        value="${storeName}"
                        readonly disabled
                    >
                </td>
                <td class="text-center">
                    <button
                        type="button"
                        class="rmv-btn btn btn-sm btn-danger"
                        onclick="remove_line(${line})"
                    ><i class="fa fa-minus"></i></button>
                </td>
            </tr>
        `;

        $tbody.append(newRow);

        $(`#store_${line}`).autocomplete({
            source(request, response) {
                const results = $.ui.autocomplete.filter(storeDescriptions, request.term);
                response([...new Set(results)].slice(0, 10));
            }
        });
        get_store('', `store_${line}`);
        $('#store').val('');
    }


    let StorecurrentPage = 1;
    const BASE_PAGE_SIZE = 10; // stays constant
    let StoreLimit = BASE_PAGE_SIZE;
    let StoreTotalRecords = 0;
    let StoreTotalPages = 1;

    function runStores(action, area_id) {
        const StoreOffset = StorecurrentPage;
        renderStores(area_id, StoreOffset, StoreLimit, action);
    }

    function renderStores(area_id, StoreOffset, StoreLimit, action) {
        query = "s.status = 1 AND sg.area_id = " + area_id;
        field = "s.description";
        order = "asc";

        var data = {
            event: "list_pagination",
            select: "s.code, s.description, s.status",
            query: query,
            offset: StoreOffset,
            limit: StoreLimit,
            table: "tbl_store_group sg",
            join: [
                {
                    table: "tbl_store s",
                    query: "s.id = sg.store_id",
                    type: "left"
                }
            ],
            order: {
                field: field,
                order: order
            }
        };

        aJax.post(url, data, function(result) {
            var result = JSON.parse(result);
            var obj_list = result.list;
            var html = '';

            if (action == "view") {
                html = `
                    <table class="table table-bordered mt-2" id="stores_list" border=1>
                        <thead>
                            <tr>
                                <th>Store Code</th>
                                <th>Store Name</th>
                            </tr>
                        </thead>
                        <tbody class="table-body word_break">
                `;
            } else {
                html = `
                    <table class="table table-bordered mt-2" id="stores_list" border=1>
                        <thead>
                            <tr>
                                <th>Store Code</th>
                                <th>Store Name</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="table-body word_break">
                `;
            }

            if (result && result.list) {
                $.each(obj_list, function(x, y) {
                    var status = parseInt(y.status) === 1 ? "Active" : "Inactive";
                    var rowClass = x % 2 === 0 ? "even-row" : "odd-row";

                    html += "<tr id='"+y.code+"' class='" + rowClass + "'>";
                    html += "<td scope=\"col\">" + trimText(y.code, 10) + "</td>";
                    html += "<td scope=\"col\">" + trimText(y.description, 20) + "</td>";
                    if (action !== "view") {
                        if (x === 0) {
                            html += `<td align="middle">
                                        <button type="button" class="rmv-btn" disabled>
                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                        </button>
                                    </td>`;
                        } else {
                            html += `<td align="middle">
                                        <button type="button" class="rmv-btn" onclick="remove_store('${y.code}', ${area_id})">
                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                        </button>
                                    </td>`;
                        }
                    }
                    html += "</tr>";
                });

                html += `</tbody>`; 

                StoreTotalRecords = result.pagination.total_record;
                StoreTotalPages = Math.ceil(StoreTotalRecords / BASE_PAGE_SIZE);

                html += `
                 <tfoot>
                    <tr>
                        <td colspan="${action === 'view' ? 2 : 3}" align="right">
                            Page ${StorecurrentPage} of ${StoreTotalPages}
                            <button type="button" class="btn btn-warning" onclick="firstPage('${action}', ${area_id})" ${StorecurrentPage === 1 ? "disabled" : ""}>&laquo; First</button>
                            <button type="button" class="btn btn-warning" onclick="backPage('${action}', ${area_id})" ${StorecurrentPage <= 1 ? "disabled" : ""}>&lsaquo; Prev</button>
                            <button type="button" class="btn btn-warning" onclick="nextPage('${action}', ${area_id})" ${StorecurrentPage >= StoreTotalPages ? "disabled" : ""}>Next &rsaquo;</button>
                            <button type="button" class="btn btn-warning" onclick="lastPage('${action}', ${area_id})" ${StorecurrentPage === StoreTotalPages ? "disabled" : ""}>Last &raquo;</button>
                        </td>
                    </tr>
                `;
            } else {
                html += `<tr><td colspan="3" class="center-align-format">${no_records}</td></tr>`;
            }

            html += `</tfoot></table>`;

            $('#stores').html(html);
            $('#store').val("");
        });
    }

    function backPage(action = "", area_id) {
        if (StorecurrentPage > 1) {
            StorecurrentPage--;
            runStores(action, area_id);
        }
    }

    function nextPage(action = "", area_id) {
        if (StorecurrentPage < StoreTotalPages) {
            StorecurrentPage++;
            runStores(action, area_id);
        }
    }

    function firstPage(action = "", area_id) {
        StorecurrentPage = 1;
        runStores(action, area_id);
    }

    function lastPage(action = "", area_id) {
        StorecurrentPage = StoreTotalPages;
        runStores(action, area_id);
    }

    function remove_store(index) {
        let store_array = Array.from(stores);
        store_array.splice(index, 1);
        stores = new Set(store_array);

        if(store_array.length <= 10) {
            paginator = 0;
        }

        $(`#${index}`).remove();
        removedStores.push(index);
        // runStores(action, area_id);
    }

    function remove_line(lineId) {
        $(`#line_${lineId}`).remove();
    }

    let selectedStores = [];
    let initialStoreNames = [];    

    function populate_modal(inp_id, actions, callback) {
        const query = `status >= 0 and id = ${inp_id}`;
        const url   = "<?= base_url('cms/global_controller');?>";
        const data  = {
            event:  "list",
            select: "id, code, description, status",
            query, offset: 1, limit: 1,
            table:  "tbl_area"
        };

        const areaStores = selectedStores;

        aJax.post(url, data, function(result) {
            const obj = is_json(result);
            if (!obj) {
                modal.loading(false);
                return;
            }

            const d = obj[0];
            $('#id').val(d.id);
            $('#code').val(d.code);
            $('#description').val(d.description);
            $('#status').prop('checked', d.status == 1);
            
            if (areaStores.length === 0 && actions === 'edit') {
                add_line();
            }

            let html = `
                <div id="line" class="ui-widget" style="display: flex; align-items: center; gap: 5px; margin-top: 3px;">
                    <input id='store' class='form-control' placeholder='Select store'>
                </div>
                `;

            $('#store_list').append(html);

            $(`#store`).autocomplete({
                source: function(request, response) {
                    var results = $.ui.autocomplete.filter(storeDescriptions, request.term);
                    var uniqueResults = [...new Set(results)];
                    response(uniqueResults.slice(0, 10));
                },
                minLength: 0,
            }).focus(function () {
                $(this).autocomplete("search", "");
            });

            get_store('', `store`);

            areaStores.forEach(({ store_id }) => {
                get_field_values('tbl_store', 'description', 'id', [store_id], (res) => {
                    const storeName = res[store_id] || "";
                   
                    add_line(storeName);

                    const lineNum = get_max_number();

                    if (actions === 'view') {
                    
                        $(`#store_${lineNum}`).prop('readonly', true);
                        $(`#line_${lineNum} .rmv-btn`).hide();
                    }

                });
            });

            modal.loading(false);
            runStores(actions === 'view' ? 'view' : 'edit', inp_id);

            if (callback) callback();
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

            processInChunks(jsonData, 5000, () => {
                paginateData(rowsPerPage);
            });
        };

        // Use readAsBinaryString instead of readAsText
        reader.readAsBinaryString(file);
    }

    function processInChunks(data, chunkSize, callback) {
        let index = 0;
        let StoreTotalRecords = data.length;
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

            let progress = Math.min(100, Math.round((totalProcessed / StoreTotalRecords) * 100));
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

            let td_validator = ['area description', 'store codes', 'status']; 
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
        var url = "<?= base_url('cms/global_controller');?>"; 
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
            var html = '';
    
            if(result) {
                if (result.length > 0) {
                    var selected = '';
                    
                    result.forEach(function (y) {
                        storeDescriptions.push(y.code + ' - ' + y.description);
                    });
                }
            }
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
        if (btn.prop("disabled")) return;

        btn.prop("disabled", true);
        $(".import_buttons").find("a.download-error-log").remove();

        if (!dataset.length) {
            modal.alert("No data to process. Please upload a file.", "error");
            return;
        }

        modal.loading(true);

        let jsonData = dataset.map(row => {
            if (row["Store Codes"]) {
                let storeList = row["Store Codes"].split(",").map(item => item.trim().toLowerCase());
                row["Store Codes"] = [...new Set(storeList)]; // Remove duplicates
            }
            return {
                "Area Description": row["Area Description"] || "", 
                "Status": row["Status"] || "", 
                "Store Codes": row["Store Codes"] || "", 
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
        const overallStart = new Date();
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
            // let result = JSON.parse(response);
            const result = JSON.parse(response);
            const allEntries = result.existing || [];

            // Build a Set of codes you're importing:
            const codeSet = new Set(valid_data.map(r => r.code.trim().toLowerCase()));
            const descSet = new Set(valid_data.map(r => r.description.trim().toLowerCase()));

            const originalEntries = allEntries.filter(r =>
                codeSet.has(r.code) || descSet.has(r.description)
            );

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

                    const overallEnd = new Date();
                    const duration = formatDuration(overallStart, overallEnd);

                    const remarks = `
                        Action: Import/Update Area Batch
                        <br>Processed ${valid_data.length} records
                        <br>Errors: ${errorLogs.length}
                        <br>Start: ${formatReadableDate(overallStart)}
                        <br>End: ${formatReadableDate(overallEnd)}
                        <br>Duration: ${duration}
                    `;

                    logActivity("import-area-module", "Import Batch", remarks, "-", JSON.stringify(valid_data), JSON.stringify(originalEntries));

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
                        delete row.created_date;
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
        const url           = "<?= base_url('cms/global_controller');?>";
        const overallStart  = new Date();
        const batch_size    = 5000;
        const storeDataKeys = Object.keys(store_per_area);
        const total_batches = Math.ceil(storeDataKeys.length / batch_size);

        let allNewEntries   = [];
        let originalEntries = [];

        // build your map
        const insertedMap = {};
        inserted_ids.forEach(({id, code}) => {
            insertedMap[code] = id;
        });

        // if there's nothing to do, log & exit
        if (storeDataKeys.length === 0) {
            const overallEnd = new Date();
            const duration   = formatDuration(overallStart, overallEnd);
            const remarks    = `
                Action: Update Store‐Group Batch
                <br>Processed 0 records
                <br>Start: ${formatReadableDate(overallStart)}
                <br>End: ${formatReadableDate(overallEnd)}
                <br>Duration: ${duration}
            `;
            logActivity("store-group-module-import", "Import Store Group Batch", remarks, "-", JSON.stringify([]), JSON.stringify([]));
            return callback();
        }

        // 1) Fetch “before” snapshot, and only there start the loop
        aJax.post(url, {
            event:  'list',
            table:  'tbl_store_group',
            select: 'id, store_id, area_id',
            query:  'area_id IN (' + inserted_ids.map(i => i.id).join(',') + ')'
        }, resp => {
            originalEntries = JSON.parse(resp) || [];
            processNextStoreBatch();
        });

        let storeBatchIndex = 0;
        function processNextStoreBatch() {
            // done?
            if (storeBatchIndex >= total_batches) {
            const overallEnd = new Date();
            const duration   = formatDuration(overallStart, overallEnd);
            const remarks    = `
                Action: Update Store‐Group Batch
                <br>Processed ${allNewEntries.length} records
                <br>Start: ${formatReadableDate(overallStart)}
                <br>End: ${formatReadableDate(overallEnd)}
                <br>Duration: ${duration}
            `;
            logActivity("store-group-module-import", "Import Store Group Batch", remarks, "-", JSON.stringify(allNewEntries), JSON.stringify(originalEntries));
            return callback();
            }

            // build this chunk
            const chunkKeys       = storeDataKeys.slice(storeBatchIndex * batch_size, (storeBatchIndex + 1) * batch_size);
            const chunkData       = [];
            const areaIdsToDelete = [];

            chunkKeys.forEach(code => {
                const area_id = insertedMap[code];
                if (!area_id) return;
                areaIdsToDelete.push(area_id);
                store_per_area[code].forEach(store_id => {
                    chunkData.push({
                    area_id,
                    store_id,
                    created_by:   user_id,
                    created_date: formatDate(new Date()),
                    updated_date: formatDate(new Date())
                    });
                });
            });

            // accumulate for log
            allNewEntries = allNewEntries.concat(chunkData);

            // helper to insert after delete
            function insertNew() {
                if (chunkData.length) {
                    batch_insert(url, chunkData, "tbl_store_group", false, () => {
                        storeBatchIndex++;
                    setTimeout(processNextStoreBatch, 100);
                });
                } else {
                    storeBatchIndex++;
                    setTimeout(processNextStoreBatch, 100);
                }
            }

            // delete old then insert new
            if (areaIdsToDelete.length) {
                batch_delete(url, "tbl_store_group", "area_id", areaIdsToDelete, "store_id", () => insertNew());
            } else {
                insertNew();
            }
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
            new_query += ' and a.code like \'%'+search_input+'%\' OR a.description like \'%'+search_input+'%\' OR s.description like \'%'+search_input+'%\' OR ascr.description like \'%'+search_input+'%\' OR ascr.code like \'%'+search_input+'%\' OR s.code like \'%'+search_input+'%\'';
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
        new_query += ' and a.code like \'%'+search_input+'%\' OR a.description like \'%'+search_input+'%\' OR s.description like \'%'+search_input+'%\' OR s.code like \'%'+search_input+'%\'';
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
        query = "a.status >= 0";
        
        query += status_f ? ` AND a.status = ${status_f}` : '';
        query += c_date_from ? ` AND a.created_date >= '${c_date_from} 00:00:00'` : ''; 
        query += c_date_to ? ` AND a.created_date <= '${c_date_to} 23:59:59'` : '';
        query += m_date_from ? ` AND a.updated_date >= '${m_date_from} 00:00:00'` : '';
        query += m_date_to ? ` AND a.updated_date <= '${m_date_to} 23:59:59'` : '';
        
        get_data(query, column_filter, order_filter);
        get_pagination(query, column_filter, order_filter);
        $('#filter_modal').modal('hide');
    })
    
    $('#clear_f').on('click', function(event) {
        order_filter = '';
        column_filter = '';
        query = "a.status >= 0";
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

    function get_pagination(query, field = "a.code", order = "asc") {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
          event : "pagination",
            select : `a.id, a.code, a.description, a.status, a.created_date, a.updated_date, 
            s.description as store_name, s.code as store_code, ascr.description AS asc_name, ascr.code as asc_code`,
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_area a",
            order : {
                field : field,
                order : order
            },
            join : [
                {
                    table: "tbl_store_group sg",
                    query: "sg.area_id = a.id",
                    type: "left"
                },
                {
                    table: "tbl_store s",
                    query: "s.id = sg.store_id",
                    type: "left"
                },
                {
                    table: "tbl_area_sales_coordinator ascr",
                    query: "ascr.area_id = a.id",
                    type: "left"
                }
            ],
            group: "a.code" 
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result);
            modal.loading(false);
            pagination.generate(obj.total_page, ".list_pagination", get_data);
        });
    }

    // function get_pagination(query, field = "a.code", order = "asc") {
    //     var data = {
    //     event : "pagination",
    //         select : `a.id, a.code, a.description, a.status, a.created_date, a.updated_date, 
    //         s.description as store_name, ascr.description AS asc_name, ascr.code as asc_code`,
    //         query : query,
    //         offset : offset,
    //         limit : limit,
    //         table : "tbl_area a",
    //         order : {
    //             field : field,
    //             order : order 
    //         },
    //         join : [
    //             {
    //                 table: "tbl_store_group sg",
    //                 query: "sg.area_id = a.id",
    //                 type: "left"
    //             },
    //             {
    //                 table: "tbl_store s",
    //                 query: "s.id = sg.store_id",
    //                 type: "left"
    //             },
    //             {
    //                 table: "tbl_area_sales_coordinator ascr",
    //                 query: "ascr.area_id = a.id",
    //                 type: "left"
    //             }
    //         ],
    //         group: "a.code" 

    //     }

    //     aJax.post(url,data,function(result){
    //         var obj = is_json(result); 
    //         modal.loading(false);
    //         pagination.generate(obj.total_page, ".list_pagination", get_data);
    //     });
    // }

    pagination.onchange(function(){
        offset = $(this).val();
        get_data(query, column_filter, order_filter);
        $('.selectall').prop('checked', false);
        $('.btn_status').hide();
    })

    function save_data(actions, id, code) {

        generateAreaCode(function (generatedCode) {
            var code = generatedCode;
            var description = $('#description').val().trim();
            var chk_status = $('#status').prop('checked');
            var linenum = 0;
            var store = '';
            var store_list = $('#store_list');
            var stores_list = $('#stores_list');

            checkUserChanges(id);

            function checkUserChanges(id) {
                stores_list.find('input').each(function () {
                    addedStores.push($(this).val().split(' - ')[0]);
                });

                // Note: removedStores is populated in remove_store()
                // function to remove duplicates from an array
                const unique = arr => [...new Set(arr)];

                // function to make sure addedStores and removedStores contain only unique store IDs
                addedStores = unique(addedStores);
                removedStores = unique(removedStores);

                // find store IDs that appear in both added and removed arrays
                const common = addedStores.filter(val => removedStores.includes(val));

                // remove common items from addedStores and removedStores
                const filteredAdded = addedStores.filter(val => !common.includes(val));
                const filteredRemoved = removedStores.filter(val => !common.includes(val));

                // reset the original arrays, clean up for future calls
                addedStores = [];
                removedStores = [];


                checkDoubleTag(filteredAdded, filteredRemoved, id)
            }

            // check if any of the newly added stores are already assigned to a different Area
            function checkDoubleTag(filteredAdded, filteredRemoved, id) {
                dynamic_search(
                    "'tbl_store_group a'", 
                    "'left join tbl_store b on a.store_id = b.id'", 
                    "'a.id, a.area_id, a.store_id, b.id as store_id, b.description as store_description'", 
                    0, 
                    0, 
                    `'b.code:IN=${filteredAdded.join('|')}'`,
                    `''`, 
                    `''`,
                    (res) => {
                        let err_msg = 'These stores have already been added to a different Area.';
                        
                        // filter out stores where the area_id does not match the current one 
                        // (e.g. store/s already belongs to a different Area)
                        let invalidItems = res.filter(item => item.area_id !== id);

                        // if there are any conflicting stores
                        if (invalidItems.length !== 0) {
                            modal.loading(false);
                            modal.alert(err_msg, 'error', function() {});

                            // exit the function early to prevent further processing
                            return;
                        } else {
                            proceedWithRestOfLogic(filteredAdded, filteredRemoved, id);
                        }
                    }
                );
            }

            function proceedWithRestOfLogic(filteredAdded, filteredRemoved, id) {
                if (filteredAdded.length != 0) {
                    dynamic_search(
                        "'tbl_store_group a'", 
                        "'left join tbl_store b on a.store_id = b.id'", 
                        "'a.id, a.area_id, a.store_id, b.id as store_id, b.description as store_description'", 
                        0, 
                        0, 
                        `'b.code:IN=${filteredAdded.join('|')}'`,
                        `''`, 
                        `''`,
                        (res) => {
                            let redundantStores = []
                            $.each(res, (x, y) => {
                                redundantStores.push(y.store_description)
                            })

                            filteredAdded = filteredAdded.filter(val => !redundantStores.includes(val));
                        }
                    )
                }

                if (chk_status) {
                    status_val = 1;
                } else {
                    status_val = 0;
                }


                // logic for adding
                if (id === undefined || id === null || id === '') 
                {
                    // check if existing
                    check_current_db(
                        "tbl_area", 
                        ["description"], 
                        [description], 
                        "status" , 
                        null, 
                        null, 
                        true, 
                        function(exists, duplicateFields) 
                        {
                            if (!exists) {
                                modal.confirm(confirm_add_message,function(result){
                                    if(result){ 
                                        let batch = [];
                                        let valid = true;

                                        // search for selected store ids then save to batch
                                        dynamic_search(
                                            "'tbl_store'", 
                                            "''", 
                                            "'id'", 
                                            0, 
                                            0, 
                                            `'code:IN=${filteredAdded.join('|')}'`,
                                            `''`, 
                                            `''`,
                                            (res) => {
                                                if(res.length == 0) {
                                                    valid = false;
                                                } else {
                                                    $.each(res, (x, y) => {
                                                        let data = {
                                                            'area_id': id,
                                                            'store_id': y.id,
                                                            'created_by': user_id,
                                                            'created_date': formatDate(new Date())
                                                        };
                                                        batch.push(data);
                                                    })
                                                }
                                            }
                                        )
        
                                        // save area and stores of that area
                                        // plus activity logs
                                        if(valid) {
                                            save_to_db(code, description, store, status_val, id, (obj) => {
                                                const batchStart = new Date();

                                                batch.forEach(item => {
                                                    item.area_id = obj.ID;
                                                });
                                                
                                                batch_insert(url, batch, 'tbl_store_group', false, () => {
                                                    const batchEnd = new Date();
                                                    const duration = formatDuration(batchStart, batchEnd);
        
                                                    const remarks = `
                                                        Action: Create Batch Store Groups
                                                        <br>Inserted ${batch.length} records for area ID ${id}
                                                        <br>Start Time: ${formatReadableDate(batchStart)}
                                                        <br>End Time: ${formatReadableDate(batchEnd)}
                                                        <br>Duration: ${duration}
                                                    `;
        
                                                    logActivity("store-group-module", "Update Batch", remarks, "-", JSON.stringify(batch), "");
        
                                                    modal.loading(false);
                                                    modal.alert(success_update_message, "success", function() {
                                                        location.reload();
                                                    });
                                                })
                                            })
                                        } else {
                                            modal.loading(false);
                                            modal.alert('Store not found', 'error', function() {});
                                        }
                                    }
                                });
                            }             
                        }
                    );
                } 
                // logic for updating
                else 
                {
                    // check if existing
                    code = $('#code').val();
                    check_current_db(
                        "tbl_area", 
                        ["description"], 
                        [description], 
                        "status" , 
                        "id", 
                        id, 
                        true, 
                        function(exists, duplicateFields) {
                            if (!exists) {
                                modal.confirm(confirm_update_message,function(result){
                                    if(result){ 
                                        let valid = true;
                                        let batch = [];
        
                                        // search for selected store ids then save to batch
                                        dynamic_search(
                                            "'tbl_store'", 
                                            "''", 
                                            "'id'", 
                                            0, 
                                            0, 
                                            `'code:IN=${filteredAdded.join('|')}'`,
                                            `''`, 
                                            `''`,
                                            (res) => {
                                                if(res.length == 0) {
                                                    if (filteredAdded.length === 0) {
                                                        valid = true;
                                                    } else {
                                                        valid = false;
                                                    }
                                                } else {
                                                    $.each(res, (x, y) => {
                                                        let data = {
                                                            'area_id': id,
                                                            'store_id': y.id,
                                                            'created_by': user_id,
                                                            'created_date': formatDate(new Date())
                                                        };
                                                        batch.push(data);
                                                    })
                                                }
                                            }
                                        )
        
                                        // delete from db all user deleted stores
                                        dynamic_search(
                                            "'tbl_store_group a'", 
                                            "'left join tbl_store b on a.store_id = b.id'", 
                                            "'a.id, a.area_id, a.store_id, b.id as store_id, b.description as store_description'", 
                                            0, 
                                            0, 
                                            `'b.code:IN=${filteredRemoved.join('|')}'`,
                                            `''`, 
                                            `''`,
                                            (res) => {
                                                $.each(res, (x, y) => {
                                                    const conditions = {
                                                        store_id: y.store_id
                                                    };
                                                    total_delete(url, 'tbl_store_group', conditions);
                                                })
                                            }
                                        )
            
                                        // update area and stores of that area
                                        // plus activity logs
                                        if (valid) {
                                            save_to_db(code, description, store, status_val, id, (obj) => {
                                                const batchStart = new Date();
        
                                                if (batch.length != 0) {
                                                    batch_insert(url, batch, 'tbl_store_group', false, () => {
                                                        const batchEnd = new Date();
                                                        const duration = formatDuration(batchStart, batchEnd);
            
                                                        const remarks = `
                                                            Action: Create Batch Store Groups
                                                            <br>Inserted ${batch.length} records for area ID ${obj.ID}
                                                            <br>Start Time: ${formatReadableDate(batchStart)}
                                                            <br>End Time: ${formatReadableDate(batchEnd)}
                                                            <br>Duration: ${duration}
                                                        `;
                                                        logActivity("store-group-module", "Create Batch", remarks, "-", JSON.stringify(batch), "");
            
                                                        modal.loading(false);
                                                        modal.alert(success_update_message, "success", function() {
                                                            location.reload();
                                                        });
                                                    });
                                                } else {
                                                    setTimeout(() => {
                                                        modal.loading(false);
                                                        modal.alert(success_update_message, "success", function() {
                                                            location.reload();
                                                        });
                                                    }, 500)
                                                }
                                            });
                                        } else {
                                            save_to_db(code, description, store, status_val, id, (obj) => {
                                                modal.loading(false);
                                                modal.alert('Store not found', 'error', function() {});
                                            })
                                        }
                                    }
                                });
                            }                  
                        }
                    );
                }
            }
        });
    }

    function generateAreaCode(callback) {
        const url = "<?= base_url('cms/global_controller'); ?>";
        const now = new Date();
        const year = now.getFullYear();
        const month = ('0' + (now.getMonth() + 1)).slice(-2);

        aJax.post(url, {
            event: "get_last_code",
            table: "tbl_area",
            field: "code"
        }, function (res) {
            const lastCode = res.last_code || '';
            const prefix = `AREA-${year}-${month}`;
            let newCode = `${prefix}-001`;

            if (lastCode.startsWith(prefix)) {
                const lastSeq = parseInt(lastCode.split('-')[3]) || 0;
                const newSeq = ('000' + (lastSeq + 1)).slice(-3);
                newCode = `${prefix}-${newSeq}`;
            }

            callback(newCode);
        });
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
                    description: inp_description,
                    updated_date: formatDate(new Date()),
                    updated_by: user_id,
                    status: status_val
                }
            };

            aJax.post(url, data, function(result) {
                var obj = is_json(result);
                cb(obj);
                modal.loading(false);
            });
        } else {
            aJax.post(url, { table: "tbl_area", event: "get_last_code", field: "code" }, function(codeResponse) {
                let codeResult = codeResponse;
                let lastCode = null;

                if (codeResult.message === 'success' && codeResult.last_code) {
                    lastCode = codeResult.last_code;
                }

                function generateNewCode() {
                    let today = new Date();
                    let year = today.getFullYear();
                    let month = String(today.getMonth() + 1).padStart(2, '0');
                    let newSequence = 1;
                    let prefix = `${year}-${month}`;
                    if (lastCode && lastCode.startsWith(`AREA-${prefix}`)) {
                        let parts = lastCode.replace('AREA-', '').split('-');
                        let lastSequence = parseInt(parts[2], 10);
                        if (!isNaN(lastSequence)) {
                            newSequence = lastSequence + 1;
                        }
                    }

                    return `AREA-${prefix}-${String(newSequence).padStart(3, '0')}`;
                }

                const newCode = generateNewCode();

                modal_alert_success = success_save_message;
                data = {
                    event: "insert",
                    table: "tbl_area",
                    data: {
                        code: newCode,
                        description: inp_description,
                        created_date: formatDate(new Date()),
                        created_by: user_id,
                        status: status_val
                    }
                };

                aJax.post(url, data, function(result) {
                    var obj = is_json(result);
                    cb(obj);
                    modal.loading(false);
                });
            });
        }
    }

    function delete_data(id) {
        get_field_values("tbl_area", "code", "id", [id], function (res) {
            let code = res[id];
            let message = is_json(confirm_delete_message);
            message.message = `Code <i><b>${code}</b></i> from Area Masterfile`;
            modal.confirm(JSON.stringify(message),function(result){
                if (result) {
                    var url = "<?= base_url('cms/global_controller');?>"; 
                    var data = {
                        event: "list",
                        select: "a.id, a.code, COUNT(arsc.area_id) AS arsc_count",
                        query: "a.id = " + id, 
                        offset: offset,  
                        limit: limit,   
                        table: "tbl_area a",
                        join: [
                            {
                                table: "tbl_area_sales_coordinator arsc",
                                query: "arsc.area_id = a.id",
                                type: "left"
                            }
                        ],
                        group: "a.id, a.code"  
                    };

                    aJax.post(url, data, function(response) {

                        try {
                            var obj = JSON.parse(response);

                            if (!Array.isArray(obj)) { 
                                modal.alert("Error processing response data.", "error", ()=>{});
                                return;
                            }

                            if (obj.length === 0) {
                                proceed_delete(id); 
                                return;
                            }

                            var Count = Number(obj[0].arsc_count) || 0;
                            var bracount = Number(obj[0].bra_count) || 0;
                            if (Count > 0 || bracount > 0) { 
                                modal.alert("This item is in use and cannot be deleted.", "error", ()=>{});
                            } else {
                                proceed_delete(id); 
                            }
                        } catch (e) {
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
            modal.alert(success_delete_message, 'success', function() {
                location.reload();
            });
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

    function get_data(query, field = "code, updated_date", order = "asc, desc") {
        var data = {
            event : "list_pagination",
            select : `a.id, a.code, a.description, a.status, a.created_date, a.updated_date, 
            s.description as store_name, s.code as store_code, ascr.description AS asc_name, ascr.code as asc_code`,
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_area a",
            order : {
                field : field,
                order : order
            },
            join : [
                {
                    table: "tbl_store_group sg",
                    query: "sg.area_id = a.id",
                    type: "left"
                },
                {
                    table: "tbl_store s",
                    query: "s.id = sg.store_id",
                    type: "left"
                },
                {
                    table: "tbl_area_sales_coordinator ascr",
                    query: "ascr.area_id = a.id",
                    type: "left"
                }
            ],
            group: "a.code"  

        }

        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            obj_data = result.list;
            var html = '';

            if(obj_data) {
                if (obj_data.length > 0) {
                    $.each(obj_data, function(x,y) {
                        var status = ( parseInt(y.status) === 1 ) ? status = "Active" : status = "Inactive";
                        var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";

                        html += "<tr class='" + rowClass + "'>";
                        html += "<td class='center-content' style='width: 5%'><input class='select' type=checkbox data-id="+y.id+" onchange=checkbox_check()></td>";
                        html += "<td scope=\"col\">" + trimText(y.code, 20) + "</td>";
                        html += "<td scope=\"col\">" + trimText(y.description, 20) + "</td>";
                        // html += "<td style='width: 20%'>" + y.store + "</td>";
                        html += "<td scope=\"col\">" + status + "</td>";
                        html += "<td scope=\"col\">" + (y.created_date ? ViewDateformat(y.created_date) : "N/A") + "</td>";
                        html += "<td scope=\"col\">" + (y.updated_date ? ViewDateformat(y.updated_date) : "N/A") + "</td>";

                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                            html+="<td class='center-content' scope=\"col\">";
                            html+="<a class='btn-sm btn update' onclick=\"edit_data('"+y.id+"', '"+y.code+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Edit Details'><span class='glyphicon glyphicon-pencil'>Edit</span>";
                            html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.id+"', '"+y.code+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Delete Item'><span class='glyphicon glyphicon-pencil'>Delete</span>";
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
                modal.loading_progress(true, "Reviewing Data...");
                setTimeout(() => {
                    handleExport()
                }, 500);
            }
        })
    })

    function download_template() {
        const headerData = [];

        formattedData = [
            {
                "Area Description": "",
                "Status": "",
                "Store Codes": "",
                "NOTE:": "Please do not change the column headers."
            },
            {
                "Area Description": "",
                "Status": "",
                "Store Codes": "",
                "NOTE:": "Stores should be separated by commas. eg(Store1, Store2, Store3)"
            }
        ]

        exportArrayToCSV(formattedData, `Masterfile: Area - ${formatDate(new Date())}`, headerData);
    }

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
                    area_code, area_description, status, store_description
                }) => ({
                    Code: area_code,
                    Description: area_description,
                    Status: status === "1" ? "Active" : "Inactive",
                    "Stores": store_description,
                }));
            };

            ids.length > 0 
                ? dynamic_search(
                    "'tbl_area a'", 
                    "'LEFT JOIN tbl_store_group b ON a.id = b.area_id INNER JOIN tbl_store c ON b.store_id = c.id'", 
                    "'a.code as area_code, a.description as area_description, a.status, GROUP_CONCAT(DISTINCT c.code, c.description ORDER BY c.description ASC SEPARATOR \", \") AS store_description'", 
                    0, 
                    0, 
                    `'a.id:IN=${ids.join('|')} a.status:IN=0|1'`,  
                    `''`, 
                    `'a.id'`,
                    processResponse
                )
                : batch_export();
        };

        const batch_export = () => {
            dynamic_search(
                "'tbl_area'", 
                "''", 
                "'COUNT(id) AS total_records'", 
                0, 
                0, 
                `'status:IN=0|1'`,  
                `''`, 
                `''`,
                (res) => {
                    if (res && res.length > 0) {
                        let total_records = res[0].total_records;

                        for (let index = 0; index < total_records; index += 100000) {
                            dynamic_search(
                                "'tbl_area a'", 
                                "'LEFT JOIN tbl_store_group b ON a.id = b.area_id INNER JOIN tbl_store c ON b.store_id = c.id'", 
                                "'a.code as area_code, a.description as area_description, a.status, GROUP_CONCAT(DISTINCT c.code, c.description ORDER BY c.description ASC SEPARATOR \", \") AS store_description'", 
                                100000, 
                                index, 
                                `'a.status:IN=0|1'`,  
                                `''`, 
                                `'a.id'`, 
                                (res) => {
                                    let newData = res.map(({ 
                                        id, area_code, area_description, status, store_description
                                    }) => ({
                                        Code: area_code,
                                        Description: area_description,
                                        Status: status === "1" ? "Active" : "Inactive",
                                        "Stores": store_description || '',
                                    }));
                                    formattedData.push(...newData); // Append new data to formattedData array
                                }
                            )
                        }
                    }
                }
            )
        };

        fetchStores();

        const headerData = [
            ["Company Name: Lifestrong Marketing Inc."],
            ["Masterfile: Area"],
            ["Date Printed: " + formatDate(new Date())],
            [""],
        ];

        exportArrayToCSV(formattedData, `Masterfile: Area - ${formatDate(new Date())}`, headerData);
        modal.loading_progress(false);
    };

    function exportArrayToCSV(data, filename, headerData) {

        const worksheet = XLSX.utils.json_to_sheet(data, { origin: headerData.length });
        XLSX.utils.sheet_add_aoa(worksheet, headerData, { origin: "A1" });
        const csvContent = XLSX.utils.sheet_to_csv(worksheet);
        const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
        saveAs(blob, filename + ".csv");
    }

    $(document).on('click', '.btn_status', function (e) {
        var status = $(this).attr("data-status");
        var modal_obj = "";
        var modal_alert_success = "";
        var hasExecuted = false; 

        var id = '';
        id = $("input.select:checked");
        var code = [];
        var code_string = '';

        id.each(function() {
            code.push($(this).attr('data-id'));
        })

        get_field_values('tbl_area', 'code', 'id', code, function(res) {
            if(code.length == 1) {
                code_string = `Code <i><b>${res[code[0]]}</b></i>`;
            } else {
                code_string = 'selected data';
            }
        })

        if (parseInt(status) === -2) {
            message = is_json(confirm_delete_message);
            message.message = `Delete ${code_string} from Area Masterfile?`;
            modal_obj = JSON.stringify(message);
            modal_alert_success = success_delete_message;
            offset = 1;
        } else if (parseInt(status) === 1) {
            message = is_json(confirm_publish_message);
            message.message = `Publish ${code_string} from Area Masterfile?`;
            modal_obj = JSON.stringify(message);
            modal_alert_success = success_publish_message;
        } else {
            message = is_json(confirm_unpublish_message);
            message.message = `Unpublish ${code_string} from Area Masterfile?`;
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
                        if (hasExecuted) return;

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
