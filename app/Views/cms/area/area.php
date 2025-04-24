
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
                                        <th class='center-content' scope="col">Area Code</th>
                                        <th class='center-content' scope="col">Area Description</th>
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

    let currentPage = 1;
    let rowsPerPage = 1000;
    let totalPages = 1;
    let dataset = [];
    let stores_under_area = []

    let stores = new Set();
    let html = "";
    let paginator = 0;
    
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
        get_store('', 'store_0');
        open_modal('Add New Area', 'add', '');
    });
    
    // function edit_data(id) {
    //     modal.loading(true);

    //     open_modal('Edit Area', 'edit', id, () => {
    //         modal.loading(false);
    //     });
    // }
    
    // function view_data(id) {
    //     modal.loading(true);

    //     open_modal('View Area', 'view', id, () => {
    //         modal.loading(false);
    //     });
    // }

    function close_modal(callback) {
        if (typeof modal.close === "function") {
            modal.close();
            clear_stores();
        }
        setTimeout(callback, 300); 
    }

    function edit_data(id) {
        close_modal(() => {
            modal.loading(true);
            open_modal('Edit Area', 'edit', id, () => {
                modal.loading(false);
                // clear_stores();
            });
        });
    }

    function view_data(id) {
        close_modal(() => {
            modal.loading(true);
            open_modal('View Area', 'view', id, () => {
                modal.loading(false);
                // clear_stores();
            });
        });
    }
    
    function open_modal(msg, actions, id) {
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
        
        let store_name = $('#store').val();

        if(store_name === '') {
            // console.log(stores);
        } else {
            stores.add($('#store').val());

            renderStores();
        }

        //let line = get_max_number() + 1;

        /*let html = `
        <div id="line_${line}" class="ui-widget" style="display: flex; align-items: center; gap: 5px; margin-top: 3px;">
            <input id='store_${line}' class='form-control' placeholder='Select store'>
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
        get_store('', `store_${line}`);*/
    }

    function renderStores(action = "") {
        let store_array = Array.from(stores);
        
        if(action == "view") {
            html = `
                    <table class="table table-bordered mt-2" id="stores_list" border=1>
                        <thead>
                            <tr>
                                <th>Store ID</th>
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
                                <th>Store ID</th>
                                <th>Store Name</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="table-body word_break">
                `;
        }

        for(let i = paginator; i < paginator + 10; i++) {
            if(store_array[i] != null) {
                let storeDescription = store_array[i].split(' - ');
                let rowClass = i % 2 === 0 ? "even-row" : "odd-row";

                if(action == "view") {
                    html += `
                            <tr class=${rowClass}>
                                <td>${storeDescription[0]}</td>
                                <td style="width: 60%">${storeDescription[1]}</td>
                            </tr>
                        `
                } else {
                    html += `
                            <tr class=${rowClass}>
                                <td>${storeDescription[0]}</td>
                                <td style="width: 60%">${storeDescription[1]}</td>
                                <td align=middle>
                                    <button type="button" class="rmv-btn" onclick="remove_store(${i})">
                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                            `
                }
            }
        }

        if(store_array.length > 10) {
            console.log(paginator > store_array.length ? "disabled" : "");
            console.log('paginator', paginator);
            console.log('store array length', store_array.length);
            html += `
                                <tr>
                                    <td colspan=3 align=right>
                                        <button type="button" class="btn btn-warning" onclick="backPage('${action == "view" ? 'view' : ''}')" ${paginator == 0 ? "disabled" : ""}><</button>
                                        <button type="button" class="btn btn-warning" onclick="nextPage('${action == "view" ? 'view' : ''}')" ${paginator + 10 > store_array.length ? "disabled" : ""}>></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    `
        }


        $('#stores').html(html);
        $('#store').val("");
    }

    function backPage(action = "") {
        if(paginator >= 10) {
            paginator -= 10;
    
            renderStores(action);
        }
    }

    function nextPage(action = "") {
        
        let store_array = Array.from(stores);
        
        if(store_array[paginator + 10] != null) {
            paginator += 10;

            renderStores(action);
        }
    }

    function remove_store(index) {
        let store_array = Array.from(stores);
        store_array.splice(index, 1);
        stores = new Set(store_array);

        if(store_array.length <= 10) {
            paginator = 0;
        }

        console.log(store_array.length);

        renderStores();
    }

    function remove_line(lineId) {
        $(`#line_${lineId}`).remove();
    }
    
    // function populate_modal(inp_id, actions) {
    //     var query = "status >= 0 and id = " + inp_id;
    //     var url = "<?= base_url('cms/global_controller');?>";
    //     var data = {
    //         event : "list", 
    //         select : "id, code, description, status",
    //         query : query, 
    //         table : "tbl_area"
    //     }
    //     aJax.post(url,data,function(result){
    //         var obj = is_json(result);
    //         if(obj){
    //             $.each(obj, function(index,d) {
    //                 $('#id').val(d.id);
    //                 $('#code').val(d.code);
    //                 $('#description').val(d.description);
    //                 $('#store').val(d.store);
    //                 // get_store(d.store, 'store_0');
    //                 var line = 0;
    //                 var readonly = '';
    //                 var disabled = '';
    //                 let $store_list = $('#store_list')
    //                 $.each(get_area_stores(d.id), (x, y) => {
    //                     if (actions === 'view') {
    //                         disabled = 'disabled';
    //                         readonly = 'readonly';
    //                     } else {
    //                         readonly = '';
    //                         disabled = ''
    //                     }
    //                     get_field_values('tbl_store', 'description', 'id', [y.store_id], (res) => {
    //                         console.log(res);
    //                         for(let key in res) {
    //                             console.log(`Key: ${key}, Value: ${res[key]}`);

    //                             get_field_values('tbl_store', 'code', 'id', [key], (res1) => {
    //                                 for(let key1 in res1) {
    //                                     console.log(`${res1[key1]} - ${res[key]}`);

    //                                     if (actions === 'edit') {
    //                                         readonly = (line == 0) ? 'readonly' : '';
    //                                         disabled = (line == 0) ? 'disabled' : '';
    //                                     }
        
    //                                     let html = `
    //                                     <div id="line_${line}" class="ui-widget" style="display: flex; align-items: center; gap: 5px; margin-top: 3px;">
    //                                         <input id='store_${line}' class='form-control' placeholder='Select store' value='${res1[key1]} - ${res[key]}' ${actions === 'view' ? 'readonly' : ''}>
    //                                         <button type="button" class="rmv-btn" onclick="remove_line(${line})" ${disabled} ${readonly}>
    //                                             <i class="fa fa-minus" aria-hidden="true"></i>
    //                                         </button>
    //                                     </div>
    //                                     `;
        
    //                                     $('#store_list').append(html);
        
    //                                     $(`#store_${line}`).autocomplete({
    //                                         source: function(request, response) {
    //                                             var results = $.ui.autocomplete.filter(storeDescriptions, request.term);
    //                                             var uniqueResults = [...new Set(results)];
    //                                             response(uniqueResults.slice(0, 10));
    //                                         },
    //                                     });
    //                                     get_store(x, `store_${line}`);
    //                                     line++
    //                                 }
    //                             });
    //                         }
    //                     });
    //                 })
    //                 if(d.status == 1) {
    //                     $('#status').prop('checked', true)
    //                 } else {
    //                     $('#status').prop('checked', false)
    //                 }
    //             }); 
    //         }
    //     });
    // }
    
    function populate_modal(inp_id, actions, callback) {
        // clear_stores();
        var query = "status >= 0 and id = " + inp_id;
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event: "list", 
            select: "id, code, description, status",
            query: query, 
            table: "tbl_area"
        };
        let store_area = new Set();

        aJax.post(url, data, function(result) {
            var obj = is_json(result);
            if (obj) {
                var totalRequests = 0; // Count the total number of AJAX requests
                var completedRequests = 0; // Track completed requests

                $.each(obj, function(index, d) {
                    $('#id').val(d.id);
                    $('#code').val(d.code);
                    $('#description').val(d.description);
                    // $('#store').val(d.store);

                    var line = 0;
                    var readonly = '';
                    var disabled = '';
                    // let $store_list = $('#store_list');

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

                    // let line = get_max_number();

                    
                    $.each(get_area_stores(d.id), (x, y) => {
                        if (actions === 'view') {
                            disabled = 'disabled';
                            readonly = 'readonly';
                        } else {
                            readonly = '';
                            disabled = '';
                        }

                        totalRequests++;
                        // Pass the callback to the get_field_values function
                        get_field_values('tbl_store', 'description', 'id', [y.store_id], (res) => {
                            for (let key in res) {
                                get_field_values('tbl_store', 'code', 'id', [key], (res1) => {
                                    if (actions === 'edit') {
                                        readonly = (line == 0) ? 'readonly' : '';
                                        disabled = (line == 0) ? 'disabled' : '';
                                    }

                                    stores.add(key + ' - ' + res[key]);
                                });
                            }
                        });
                    });
                    
                    renderStores('view');
                    modal.loading(false);

                    if (d.status == 1) {
                        $('#status').prop('checked', true);
                    } else {
                        $('#status').prop('checked', false);
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
            let td_validator = ['area code', 'area description', 'stores', 'status']; 
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
            if (row["Stores"]) {
                let storeList = row["Stores"].split(",").map(item => item.trim().toLowerCase());
                row["Stores"] = [...new Set(storeList)]; // Remove duplicates
            }
            return {
                "Area Code": row["Area Code"] || "",
                "Area Description": row["Area Description"] || "", 
                "Status": row["Status"] || "", 
                "Stores": row["Stores"] || "", 
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

    $(document).on('click', '#search_button', function(event) {
        $('.btn_status').hide();
        $(".selectall").prop("checked", false);
        search_input = $('#search_query').val();
        offset = 1;
        new_query = query;
        new_query += ' and code like \'%'+search_input+'%\' or '+query+' and description like \'%'+search_input+'%\'';
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

    function get_pagination(query, field = "updated_date", order = "desc") {
        var data = {
        event : "pagination",
            select : "id",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_area",
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
    })

    function save_data(actions, id) {
        var code = $('#code').val();
        var description = $('#description').val();
        var chk_status = $('#status').prop('checked');
        var linenum = 0;
        var store = '';
        var unique_store = Array.from(stores);
        // var store_list = $('#store_list');

        // store_list.find('input').each(function() {
        //     if (!unique_store.includes($(this).val())) {
        //         store = $(this).val().split(' - ');

        //         if(store.length == 2) {
        //             unique_store.push(store[1]);
        //         } else {
        //             unique_store.push(store[1] + ' - ' + store[2]);
        //         }
        //     }
        //     linenum++
        // });

        console.log(unique_store);

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
                            let ids = [];
                            let hasDuplicate = false;
                            let valid = true;
                            // console.log(unique_store);
                            $.each(unique_store, (x, y) => {
                                // if(ids.includes(y)) {
                                //     hasDuplicate = true;
                                // } else {
                                //     ids.push(y);
                                // }
                                console.log(y);
                                store = y.split(' - ');
                                ids.push(store[1]);
                            });

                            if(hasDuplicate) {
                                console.log('Has duplicate');
                                modal.alert('Stores cannot be duplicated. Please check stores carefully.', 'error', () => {});
                            } else {
                                let batch = [];
                                get_field_values('tbl_store', 'id', 'description', ids, (res) => {
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

                                    console.log(batch);
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
                                    modal.loading(false);
                                    modal.alert('Store not found', 'error', function() {});
                                }
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
                            let ids = [];
                            let hasDuplicate = false;
                            let valid = true;
                            // console.log(unique_store);
                            $.each(unique_store, (x, y) => {
                                // if(ids.includes(y)) {
                                //     hasDuplicate = true;
                                // } else {
                                //     ids.push(y);
                                // }
                                console.log(y);
                                store = y.split(' - ');
                                ids.push(store[1]);
                            });

                            console.log(ids);

                            if(hasDuplicate) {
                                console.log('Has duplicate');
                                modal.alert('Stores cannot be duplicated. Please check stores carefully.', 'error', () => {});
                            } else {
                                let batch = [];
                                get_field_values('tbl_store', 'id', 'description', ids, (res) => {
                                    console.log(res);
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

                                    console.log(batch);
                                })
    
                                if(valid) {
                                    save_to_db(code, description, store, status_val, id, (obj) => {
                                        insert_batch = batch.map(batch => ({...batch, area_id: obj.ID}));
        
                                        batch_insert(url, insert_batch, 'tbl_store_group', false, () => {
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
        get_field_values("tbl_area", "code", "id", [id], function (res) {
            let code = res[id];
            let message = is_json(confirm_delete_message);
            message.message = `Code <i><b>${code}</b></i> from Area Masterfile`;
            modal.confirm(JSON.stringify(message),function(result){
                if (result) {
                    var url = "<?= base_url('cms/global_controller');?>"; 
                    var data = {
                        event: "list",
                        select: "a.id, a.code, COUNT(arsc.area_id) AS arsc_count, COUNT(bra.area) AS bra_count",
                        query: "a.id = " + id, 
                        offset: offset,  
                        limit: limit,   
                        table: "tbl_area a",
                        join: [
                            {
                                table: "tbl_area_sales_coordinator arsc",
                                query: "arsc.area_id = a.id",
                                type: "left"
                            },
                            {
                                table: "tbl_brand_ambassador bra",
                                query: "bra.area = a.id",
                                type: "left"
                            }
                        ],
                        group: "a.id, a.code"  
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

                            // Convert team_count to an integer
                            var Count = Number(obj[0].arsc_count) || 0;
                            var bracount = Number(obj[0].bra_count) || 0;

                            console.log("ASC COUNT MOTO: ",Count);
                            console.log("BRA AMBA COUNT MOTO",bracount);

                            if (Count > 0 || bracount > 0) { 
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
            event : "list",
            select : "id, code, description, status, created_date, updated_date",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_area",
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
                "Area Code": "",
                "Area Description": "",
                "Status": "",
                "Stores": "",
                "NOTE:": "Please do not change the column headers."
            },
            {
                "Area Code": "",
                "Area Description": "",
                "Status": "",
                "Stores": "",
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
                // ? get_area_where_in(`"${ids.join(', ')}"`, processResponse)
                ? dynamic_search(
                    "'tbl_area a'", 
                    "'LEFT JOIN tbl_store_group b ON a.id = b.area_id INNER JOIN tbl_store c ON b.store_id = c.id'", 
                    "'a.code as area_code, a.description as area_description, a.status, GROUP_CONCAT(DISTINCT c.description ORDER BY c.description ASC SEPARATOR \", \") AS store_description'", 
                    0, 
                    0, 
                    `'a.id:IN=${ids.join('|')}'`,  
                    `''`, 
                    `'a.id'`,
                    processResponse
                )
                // : getStoresByArea(processResponse);
                : batch_export();
        };

        const batch_export = () => {
            dynamic_search(
                "'tbl_area'", 
                "''", 
                "'COUNT(id) AS total_records'", 
                0, 
                0, 
                `''`,  
                `''`, 
                `''`,
                (res) => {
                    if (res && res.length > 0) {
                        let total_records = res[0].total_records;

                        for (let index = 0; index < total_records; index += 100000) {
                            dynamic_search(
                                "'tbl_area a'", 
                                "'LEFT JOIN tbl_store_group b ON a.id = b.area_id INNER JOIN tbl_store c ON b.store_id = c.id'", 
                                "'a.code as area_code, a.description as area_description, a.status, GROUP_CONCAT(DISTINCT a.description ORDER BY a.description ASC SEPARATOR \", \") AS store_description'", 
                                100000, 
                                index, 
                                `''`,  
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
                    } else {
                        console.log('No data received');
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
