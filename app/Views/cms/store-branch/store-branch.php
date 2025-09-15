<style>
    #list-data {
        overflow: visible !important;
        max-height: none !important;
        overflow-x: hidden !important;
        overflow-y: hidden !important;
    }

    .ui-widget {
        z-index: 1051 !important;
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
</style>

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
                                    <th class='center-content'>Store/Branch Code</th>
                                    <th class='center-content'>Store/Branch Description</th>
                                    <!-- <th class='center-content'>Store/Branch Brand Ambassador</th> -->
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
                        <label for="code" class="form-label">Store/Branch Code</label>
                        <input type="text" class="form-control" id="id" aria-describedby="id" hidden>
                        <input type="text" class="form-control required" id="code" maxlength="25" aria-describedby="code">
                        <small id="code" class="form-text text-muted">* required, must be unique, max 25 characters</small>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Store/Branch Description</label>
                        <input type="text" class="form-control required" id="description" maxlength="50" aria-describedby="description">
                        <small id="description" class="form-text text-muted">* required, must be unique, max 50 characters</small>
                    </div>

                    <div class="form-group">
                        <div class="row" >
                            <label class="col" >Store/Branch Brand Ambassador</label>
                            <input
                                type="button"
                                value="Add BA"
                                class="row add_line"
                                onclick="add_line()"
                            >
                        </div>
                        <div id="baName_list">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="storeSegment" class="form-label">Store/Branch Segment</label>
                        <input type="text" class="form-control required" id="storeSegment" placeholder="Select Store/Branch Segment">
                        <input type="hidden" id="storeSegmentId" name="storeSegmentId">
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
                                    <th class='center-content'>Line #</th>
                                    <th class='center-content'>Store/Branch Code</th>
                                    <th class='center-content'>Store/Branch Description</th>
                                    <th class='center-content'>Store/Branch Brand Ambassador Code</th>
                                    <th class='center-content'>Store Segment Code</th>
                                    <th class='center-content'>Status</th>
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
    var query = "s.status >= 0";
    var column_filter = '';
    var order_filter = '';
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url("cms/global_controller");?>";

    let currentPage = 1;
    let rowsPerPage = 1000;
    let totalPages = 1;
    let dataset = [];

    $(document).ready(function() {
        get_data(query);
        get_pagination(query);
        let storeSegment = <?= json_encode($storeSegment); ?>

        let storeSegmentOptions = storeSegment.map(ss => ({
            id: ss.id,
            display: (ss.code ? ss.code + ' - ' : '') + (ss.description || '')
        }));

        let storeSegmentToId = new Map(storeSegmentOptions.map(o => [o.display, String(o.id)]));

        initAuto($('#storeSegment'),       $('#storeSegmentId'),       storeSegmentOptions,'display', 'id', row => { $('#storeSegmentId').val(row.id); });

        enforceValidPick($('#storeSegment'),       $('#storeSegmentId'),       storeSegmentToId);
    });


    function initAuto($input, $hidden, options, labelKey, idKey, onPick) {
        if (!$input.length || $input.data('ui-autocomplete')) return;

        // call your existing helper as-is
        autocomplete_field($input, $hidden, options, labelKey, idKey, function(row){
            if (typeof onPick === 'function') onPick(row);
        });

        // put the menu inside the modal so it isn't clipped
        try { $input.autocomplete('option', 'appendTo', '#popup_modal'); } catch (e) {}

        // open suggestions on focus
        $input.on('focus', function(){ $(this).autocomplete('search', ''); });

        // clear stale id if user types
        $input.on('input', function(){ $hidden.val(''); });
    }

    function enforceValidPick($input, $hidden, labelToIdMap) {
        $input.on('blur', function () {
            const label = $input.val().trim();
            const id = $hidden.val();
            // if label doesn't map to a known id OR id is empty/mismatched, clear both
            if (!labelToIdMap.has(label) || String(labelToIdMap.get(label)) !== String(id)) {
                $input.val('');
                $hidden.val('');
            }
        });
    }

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

    $(document).on('keydown', '#search_query', function(event) {
        $('.btn_status').hide();
        $(".selectall").prop("checked", false);
        if (event.key == 'Enter') {
            search_input = $('#search_query').val();
            var escaped_keyword = search_input.replace(/'/g, "''"); 
            offset = 1;
            new_query = query;
            new_query += ' and (s.code like \'%'+escaped_keyword+'%\' or s.description like \'%'+escaped_keyword+'%\' or ba.code like \'%'+escaped_keyword+'%\' or '+query+' and ba.name like \'%'+escaped_keyword+'%\')';
            get_data(new_query);
            get_pagination(new_query);
        }
    });

    function get_max_number() {
        let storeElements = $('[id^="baName_"]');
        
        let maxNumber = Math.max(
            0,
            ...storeElements.map(function () {
                return parseInt(this.id.replace("baName_", ""), 10) || 0;
            }).get()
        );

        return maxNumber;
    }

    let brandAmbassadorName = [];
    function get_baName(id, dropdown_id) {
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list",
            select : "id, code, name, status",
            query : 'status >= 0',
            offset : 0,
            limit : 0,
            table : "tbl_brand_ambassador",
            order : {
                field : "id",
                order : "asc" 
            }
        }

        aJax.post(url,data,function(res){
            var result = JSON.parse(res);
            var html = '';
    
            if(result) {
                if (result.length > 0) {
                    var selected = '';
                    
                    brandAmbassadorName = [];
                    brandAmbassadorName.push("Vacant");
                    brandAmbassadorName.push("Non BA");
                    result.forEach(function (y) {
                        brandAmbassadorName.push(y.code + ' - ' + y.name);
                    });
                }
            }
        });
    }

    function add_line() {
        let line = get_max_number() + 1;

        let html = `
        <div id="line_${line}" class="ui-widget" style="display: flex; align-items: center; gap: 5px; margin-top: 3px;">
            <input id='baName_${line}' class='form-control' placeholder='Select Brand Ambassador'>
            <button type="button" class="rmv-btn" onclick="remove_line(${line})">
                <i class="fa fa-minus" aria-hidden="true"></i>
            </button>
        </div>
        `;

        $('#baName_list').append(html);

        $(`#baName_${line}`).autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(brandAmbassadorName, request.term);
                var uniqueResults = [...new Set(results)];
                response(uniqueResults.slice(0, 10));
            },
        });
        get_baName('', `baName_${line}`);
    }

    function remove_line(lineId) {
        $(`#line_${lineId}`).remove();
    }

    $(document).on('click', '#search_button', function(event) {
        $('.btn_status').hide();
        $(".selectall").prop("checked", false);
        search_input = $('#search_query').val();
        var escaped_keyword = search_input.replace(/'/g, "''"); 

        offset = 1;
        new_query = query;
        new_query += ' and (code like \'%'+escaped_keyword+'%\' or description like \'%'+escaped_keyword+'%\')';
        get_data(new_query);
        get_pagination(query);
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
        query = "s.status >= 0";
        
        query += status_f ? ` AND s.status = ${status_f}` : '';
        query += c_date_from ? ` AND s.created_date >= '${c_date_from} 00:00:00'` : ''; 
        query += c_date_to ? ` AND s.created_date <= '${c_date_to} 23:59:59'` : '';
        query += m_date_from ? ` AND s.updated_date >= '${m_date_from} 00:00:00'` : '';
        query += m_date_to ? ` AND s.updated_date <= '${m_date_to} 23:59:59'` : '';
        
        get_data(query, column_filter, order_filter);
        get_pagination(query, column_filter, order_filter);
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

    function get_data(query, field = "s.id, s.updated_date", order = "asc") {
        var data = {
            event : "list",
            select : "s.id, s.code, s.description, s.status, s.updated_date, s.created_date, ba.code AS ba_code, ba.name AS ba_name",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_store s",
            order : {
                field : field,
                order : order 
            },
            join : [
                {
                    table: "tbl_brand_ambassador_group bag",
                    query: "bag.store_id = s.id",
                    type: "left"
                },
                {
                    table: "tbl_brand_ambassador ba",
                    query: "ba.id = bag.brand_ambassador_id",
                    type: "left"
                }
            ],
            group : "s.code"

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
                        html += "<td scope=\"col\">" + trimText(y.code, 15) + "</td>";
                        html += "<td scope=\"col\">" + trimText(y.description, 15) + "</td>";
                        html += "<td scope=\"col\">" + status + "</td>";
                        html += "<td scope=\"col\">" + (y.created_date ? ViewDateformat(y.created_date) : "N/A") + "</td>";
                        html += "<td scope=\"col\">" + (y.updated_date ? ViewDateformat(y.updated_date) : "N/A") + "</td>";

                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                            html+="<td class='center-content' scope=\"col\">";
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
    };

    function get_pagination(query, field = "s.updated_date", order = "asc") {
        var data = {
        event : "pagination",
            select : "s.id",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_store s",
            order : {
                field : field, 
                order : order
            },
            join : [
                {
                    table: "tbl_brand_ambassador_group bag",
                    query: "bag.store_id = s.id",
                    type: "left"
                },
                {
                    table: "tbl_brand_ambassador ba",
                    query: "ba.id = bag.brand_ambassador_id",
                    type: "left"
                }
            ],
            group : "s.code"

        }

        aJax.post(url,data,function(result){
            var obj = is_json(result); 
            modal.loading(false);
            pagination.generate(obj.total_page, ".list_pagination", get_data);
        });
    };

    pagination.onchange(function(){
        offset = $(this).val();
        get_data(query, column_filter, order_filter);
    });

    $('#btn_add').on('click', function() {
        get_baName('', 'brandAmba_0');
        open_modal('Add New Store/Branch', 'add', '');
    });

    $('#btn_import').on('click', function() {
        title = addNbsp('IMPORT STORE/BRANCH')
        $("#import_modal").find('.modal-title').find('b').html(title)
        $("#import_modal").modal('show')
        clear_import_table()
    });

    function edit_data(id) {
        open_modal('Edit Store/Branch', 'edit', id);
    };

    function view_data(id) {
        open_modal('View Store/Branch', 'view', id);
    };

    function open_modal(msg, actions, id) {
        window.lastFocusedElement = document.activeElement;
        $(".form-control").css('border-color','#ccc');
        $(".validate_error_message").remove();
        let $modal = $('#popup_modal');

        let $baName_list = $('#baName_list');

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

        if (['edit', 'view'].includes(actions)) {
            populate_modal(id, actions, () => {
                modal.loading(false); 
            });
        }

        let isReadOnly = actions === 'view';
        set_field_state('#code, #description, #storeSegment, #status', isReadOnly);

        $baName_list.empty();        
        $footer.empty();
        if (actions === 'add') {
            let line = get_max_number();

            let html = `
            <div id="line_${line}" class="ui-widget" style="display: flex; align-items: center; gap: 5px; margin-top: 3px;">
                <input id='baName_${line}' class='form-control ba-autocomplete' data-value="" placeholder='Select Brand Ambassador'>
                <button type="button" class="rmv-btn" onclick="remove_line(${line})" disabled>
                    <i class="fa fa-minus" aria-hidden="true"></i>
                </button>
            </div>
            `;

            $('#baName_list').append(html);

            const baInput = $(`#baName_${line}`);

            baInput.autocomplete({
                source: function(request, response) {
                    let term = request.term.toLowerCase();
                    let customOptions = [
                       // { label: "Vacant", value: "-5" },  // Non-numeric ID for Vacant
                       // { label: "Non BA", value: "-6" }   // Non-numeric ID for Non BA
                    ];

                    let filtered = $.ui.autocomplete.filter(brandAmbassadorName, term).map(name => ({
                        label: name,
                        value: name
                    }));

                    response([...customOptions, ...filtered]);
                },
                minLength: 0,
                select: function(event, ui) {
                    // Store selected value in data attribute
                    $(this).val(ui.item.label);                    
                    if (ui.item.value === "-5") {
                        $(this).data("value", "-5 - Vacant");
                    } else if (ui.item.value === "-6") {
                        $(this).data("value", "-6 - Non BA");
                    } else {
                        $(this).data("value", ui.item.value);
                    }
                    
                    return false;
                }
            }).focus(function () {
                $(this).autocomplete("search", "");
            });

            $('.add_line').attr('disabled', false);
            $('.add_line').attr('readonly', false);
            $footer.append(buttons.save);
        }

        if (actions === 'edit') {
            $footer.append(buttons.edit);
            $('.add_line').attr('disabled', false)
            $('.add_line').attr('readonly', false)
        }
        if (actions === 'view') {
            set_field_state('.add_line', true);
        }
        $footer.append(buttons.close);
        $contentWrapper.attr('inert', '');
        $modal.on('shown.bs.modal', function () {
            $(this).find('input, textarea, button, select').filter(':visible:first').focus();
        });

        $modal.modal('show');
        $modal.on('hidden.bs.modal', function () {
            $contentWrapper.removeAttr('inert');
            if (window.lastFocusedElement) {
                window.lastFocusedElement.focus();
            }
        });
    }


    function reset_modal_fields() {
        $('#popup_modal #code, #popup_modal #description, #popup_modal, #brand_amba, #popup_modal').val('');
        $('#popup_modal #status').prop('checked', true);
    };

    function set_field_state(selector, isReadOnly) {
        $(selector).prop({ readonly: isReadOnly, disabled: isReadOnly });
    };


    function create_button(btn_txt, btn_id, btn_class, onclick_event) {
        var new_btn = $('<button>', {
            text: btn_txt,
            id: btn_id,
            class: btn_class,
            click: onclick_event 
        });
        return new_btn;
    };

    function populate_modal(inp_id, actions) {
        var query = "s.status >= 0 and s.id = " + inp_id;
        var url   = "<?= base_url('cms/global_controller');?>";
        var data  = {
            event:   "list",
            select:  "s.id, s.code, s.description, s.store_segment_id, seg.code AS segment_code, s.status",
            query:   query,
            table:   "tbl_store s",
            join : [
                {
                    table: "tbl_store_segment_list seg", 
                    query: "seg.id = s.store_segment_id",
                    type: "left"
                }
            ],
        };

        aJax.post(url, data, function(result) {
            var obj = is_json(result);
            if (!obj) return;

            $.each(obj, function(_, asc) {
                $('#id').val(asc.id);
                $('#code').val(asc.code);
                $('#description').val(asc.description);
                $('#storeSegment').val(asc.segment_code);
                $('#status').prop('checked', asc.status == 1);

                let line = 0;
                let $baName_list = $('#baName_list');
                $baName_list.empty(); 

                $.each(get_store_ba(asc.id), (x, y) => {
                    var baId = y.brand_ambassador_id;
                    var inputReadonly = '';
                    var btnDisabled   = '';
                    if (actions === 'view') {
                        inputReadonly = 'readonly';
                        btnDisabled   = 'disabled';
                    } else if (actions === 'edit') {
                        if (line === 0) {
                            inputReadonly = '';
                            btnDisabled   = 'disabled';
                        } else {
                            inputReadonly = 'readonly';
                            btnDisabled   = '';
                        }
                    }

                    if (baId < 0) {
                        //$('.add_line').attr('disabled', true);
                        var displayName = parseInt(baId) === -5 ? 'Vacant' : 'Non BA';

                        var html = `
                        <div id="line_${line}" style="display:flex;align-items:center;gap:5px;margin-top:3px;">
                        <input id="baName_${line}"
                                class="form-control"
                                placeholder="Select Brand Ambassador"
                                value="${displayName}"
                                ${inputReadonly} />
                        <button type="button"
                                class="rmv-btn"
                                onclick="remove_line(${line})"
                                ${btnDisabled}>
                            <i class="fa fa-minus" aria-hidden="true"></i>
                        </button>
                        </div>
                        `;
                        $baName_list.append(html);
                        $(`#baName_${line}`).autocomplete({
                            source: function(request, response) {
                                var results = $.ui.autocomplete.filter(brandAmbassadorName, request.term);
                                var uniqueResults = [...new Set(results)];
                                response(uniqueResults.slice(0, 10));
                            },
                        });

                        get_baName(x, `baName_${line}`); 
                        line++;
                        return;  // skip the DB lookups
                    }


                    get_field_values('tbl_brand_ambassador', 'name', 'id', [y.brand_ambassador_id], (res) => {
                        for (let key in res) {
                            get_field_values('tbl_brand_ambassador', 'code', 'id', [key], (res1) => {
                                for (let key1 in res1) {
                                    let readonly = '', disabled = '';
                                    if (actions === 'edit') {
                                        if (line === 0) {
                                            readonly = '';
                                            disabled = 'disabled';
                                        } else {
                                            readonly = 'readonly';
                                            disabled = '';
                                        }
                                    } else if (actions === 'view') {
                                        readonly = 'readonly';
                                        disabled = 'disabled';
                                    }

                                    let html = `
                                    <div id="line_${line}" style="display: flex; align-items: center; gap: 5px; margin-top: 3px;">
                                        <input id='baName_${line}' class='form-control' placeholder='Select Brand Ambassador' value='${res1[key]} - ${res[key]}' ${actions === 'view' ? 'readonly' : ''}>
                                        <button type="button" class="rmv-btn" onclick="remove_line(${line})" ${disabled} ${readonly}>
                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    `;
                                    $baName_list.append(html); 

                                    $(`#baName_${line}`).autocomplete({
                                        source: function(request, response) {
                                            var results = $.ui.autocomplete.filter(brandAmbassadorName, request.term);
                                            var uniqueResults = [...new Set(results)];
                                            response(uniqueResults.slice(0, 10));
                                        },
                                    });

                                    get_baName(x, `baName_${line}`); 

                                    line++; 
                                }
                            });
                        }
                    });
                });
            });
        });
    }


    function get_store_ba(id) {
        var data = {
            event : "list",
            select : "id, store_id, brand_ambassador_id",
            query : "id > 0 and store_id = " + id,
            offset : 0,
            limit : 0,
            table : "tbl_brand_ambassador_group",
            order : {
                field : "id",
                order : "asc" 
            }
        }
        var result = '';

        aJax.post_async(url, data, function(res) {
            result = JSON.parse(res);
        })

        return result;
    }

    function save_data(actions, id) {
        var code        = $('#code').val().trim();
        var description = $('#description').val().trim();
        var storeSegment = $('#storeSegmentId').val().trim();
        var chk_status  = $('#status').prop('checked');
        var status_val  = chk_status ? 1 : 0;
        var linenum     = 0;
        var unique_brandAmba = [];
        var brandAmba_list   = $('#baName_list');

        let modal_alert_success = actions === 'update' ? success_update_message : success_save_message;
        brandAmba_list.find('input').each(function() {
            var raw = $(this).val().trim();
            var baCode;

            if (raw === "Vacant") {
                baCode = "-5";
                // baDesc = raw;
            } else if (raw === "Non BA") {
                baCode = "-6";
                // baDesc = raw;
            } else {
                var parts = raw.split(' - ');
                if (parts.length === 2) {
                    baCode = parts[0].trim();
                } else {
                    return;
                }
            }

            if (!unique_brandAmba.includes(baCode)) {
                unique_brandAmba.push(baCode);
            }
            linenum++;
        });

        if (unique_brandAmba.length === 0) {
            return modal.alert('Please select at least one Brand Ambassador before saving.', 'warning');
        }

        function hasDuplicates(arr) {
            var seen = {};
            for (var i = 0; i < arr.length; i++) {
                if (seen[arr[i]]) return true;
                seen[arr[i]] = true;
            }
            return false;
        }

        function finalize_and_insert(storeId, batch) {
            save_to_db(code, description, storeSegment, unique_brandAmba, status_val, storeId, function(obj) {
                var finalStoreId = storeId || obj.ID;
                const batchStart = new Date();
                if (storeId) {
                    const conditions = { store_id: finalStoreId };
                    total_delete(url, 'tbl_brand_ambassador_group', conditions);
                }

                batch.forEach(function(item) {
                    item.store_id = finalStoreId;
                });

                batch_insert(url, batch, 'tbl_brand_ambassador_group', false, function() {
                    
                    const batchEnd = new Date();
                    const duration = formatDuration(batchStart, batchEnd);

                    const remarks = `
                        Action: Create Batch Store Groups
                        <br>Inserted ${batch.length} records for area ID ${finalStoreId}
                        <br>Start Time: ${formatReadableDate(batchStart)}
                        <br>End Time: ${formatReadableDate(batchEnd)}
                        <br>Duration: ${duration}
                    `;

                    logActivity("ba-brand-group-module", "Update Batch", remarks, "-", JSON.stringify(batch), "");

                    modal.loading(false);
                    modal.alert(modal_alert_success, "success", function() {
                        location.reload();
                    });
                });
            });
        }

        function buildAndSave(storeId) {
            if (hasDuplicates(unique_brandAmba)) {
                return modal.alert('Brand Ambassador cannot be duplicated. Please check your input carefully.', 'error');
            }

            var special = unique_brandAmba.filter(code => code === "-5" || code === "-6");
            var normal  = unique_brandAmba.filter(code => code !== "-5" && code !== "-6");
            var batch   = [];

            // Handle Vacant / Non BA
            special.forEach(function(code) {
                batch.push({
                    store_id: storeId,
                    brand_ambassador_id: parseInt(code, 10), // store as -5 or -6
                    created_by: user_id,
                    created_date: formatDate(new Date())
                });
            });

            if (normal.length > 0) {
                get_field_values('tbl_brand_ambassador', 'code', 'code', normal, function(res) {
                    // res is { 1: '2025-05-001', 2: '123-45-6', ... }

                    var codeToId = {};
                    Object.entries(res).forEach(function([idStr, codeStr]) {
                        codeToId[codeStr] = parseInt(idStr, 10);
                    });

                    var missing = normal.filter(function(code) {
                        return !(code in codeToId);
                    });

                    if (missing.length) {
                        modal.loading(false);
                        return modal.alert('The following Brand Ambassador codes were not found in the masterfile: ' + missing.join(', '),'error');
                    }

                    Object.entries(codeToId).forEach(function([codeStr, id]) {
                        batch.push({
                        store_id:            storeId,
                        brand_ambassador_id: id,
                        created_by:          user_id,
                        created_date:        formatDate(new Date())
                        });
                    });

                    finalize_and_insert(storeId, batch);
                });
            } else {
                finalize_and_insert(storeId, batch);
            }
        }

        if (id) {
            check_current_db("tbl_store", ["code", "description"], [code, description], "status", "id", id, true, function(exists) {
                if (!exists) {
                    modal.confirm(confirm_update_message, function(result) {
                        if (result) {
                            buildAndSave(id);
                        }
                    });
                }
            });
        } else {
            check_current_db("tbl_store", ["code"], [code], "status", null, null, true, function(exists) {
                if (!exists) {
                    modal.confirm(confirm_add_message, function(result) {
                        if (result) {
                            buildAndSave(null);
                        }
                    });
                }
            });
        }
    }
 
    function save_to_db(inp_code, inp_description, inp_storeSegment, inp_brandAmba, status_val, id, cb) {
        const url = "<?= base_url('cms/global_controller'); ?>";
        let data = {}; 
        let modal_alert_success;

        if (id !== undefined && id !== null && id !== '') {
            modal_alert_success = success_update_message;
            data = {
                event: "update",
                table: "tbl_store",
                field: "id",
                where: id,
                data: {
                    code: inp_code,
                    description: inp_description,
                    store_segment_id : inp_storeSegment,
                    updated_date: formatDate(new Date()),
                    updated_by: user_id,
                    status: status_val
                }
            };
        } else {
            modal_alert_success = success_save_message;
            data = {
                event: "insert",
                table: "tbl_store",
                data: {
                    code: inp_code,
                    description: inp_description,
                    store_segment_id : inp_storeSegment,
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
    };

    function delete_data(id) {
        get_field_values("tbl_store", "code", "id", [id], (res) => {
            let code = res[id];
            let message = is_json(confirm_delete_message);
            message.message = `Delete <b><i>${code}</i></b> from Store/Branch Masterfile?`;

            modal.confirm(JSON.stringify(message),function(result){
                if (result) {
                    var url = "<?= base_url('cms/global_controller');?>"; 
                    var data = {
                        event: "list",
                        select: "s.id, s.code, s.description, COUNT(asg.store_id) AS storeid_count",
                        query: "s.id = " + id, 
                        offset: offset,  
                        limit: limit,   
                        table: "tbl_store s",
                        join: [
                            {
                                table: "tbl_store_group asg",
                                query: "asg.store_id = s.id",
                                type: "left"
                            }
                        ],
                        group: "s.id, s.code, s.description"  
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

                            var Count = Number(obj[0].storeid_count) || 0;
                            var count2 = Number(obj[0].bra_count) || 0;

                            if (Count > 0 || count2 > 0) { 
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
        })
    }

    function proceed_delete(id) {
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "update",
            table : "tbl_store",
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

    function clear_import_table() {
        $(".import_table").empty()
    };

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
            const workbook = XLSX.read(data, { type: "binary", raw: true });
            const sheet = workbook.Sheets[workbook.SheetNames[0]];

            let jsonData = XLSX.utils.sheet_to_json(sheet, { raw: true });
            jsonData = jsonData.map(row => {
                let fixedRow = {};
                Object.keys(row).forEach(key => {
                    let value = row[key];
                    if (typeof value === "number") {
                        value = String(value);
                    }

                    fixedRow[key] = value !== null && value !== undefined ? String(value) : "";
                });
                return fixedRow;
            });

            processInChunks(jsonData, 5000, () => {
                paginateData(rowsPerPage);
            });
        };

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
    };

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

            let td_validator = ['store/branch code', 'store/branch description', 'store/branch brand ambassador code', 'store segment code', 'status'];
            td_validator.forEach(column => {
                html += `<td>${lowerCaseRecord[column] !== undefined ? lowerCaseRecord[column] : ""}</td>`;
            });

            html += "</tr>";
            tr_counter += 1;
        });

        modal.loading(false);
        $(".import_table").html(html);
        updatePaginationControls();
    };

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
    };

    function excel_date_to_readable_date(excel_date) {
        var dateStr = excel_date.split('/').map((part, index) => {
            if (index === 2 && part.length === 2) {
            }
            return part;
        }).join('/');

        var date = new Date(dateStr);
        
        if (isNaN(date)) {
            return "Invalid Date";
        }
        
        return date.toLocaleDateString("en-US", { 
            year: "numeric", 
            month: "long", 
            day: "numeric" 
        });
    };

    function process_xl_file() {
        let btn = $(".btn.save");
        if (btn.prop("disabled")) return;

        btn.prop("disabled", true);
        $(".import_buttons").find("a.download-error-log").remove();
        
        if (dataset.length === 0) {
            modal.alert('No data to process. Please upload a file.', 'error', () => {});    
            return;
        }
        modal.loading(true);

        let jsonData = dataset.map(row => {
            if (row["Store/Branch Brand Ambassador Code"]) {
                let baList = row["Store/Branch Brand Ambassador Code"].split(",").map(item => item.trim().toLowerCase());
                row["Store/Branch Brand Ambassador Code"] = [...new Set(baList)]; // Remove duplicates
            }
            return {
                "Store/Branch Code": row["Store/Branch Code"] || "",
                "Store/Branch Description": row["Store/Branch Description"] || "",
                "Store/Branch Brand Ambassador Code": row["Store/Branch Brand Ambassador Code"] || "",
                "Store Segment Code": row["Store Segment Code"] || "",
                "Status": row["Status"] || "",
                "Created By": user_id || "",
                "Created Date": formatDate(new Date()) || ""
            };
        });

        let worker = new Worker(base_url + "assets/cms/js/validator_store.js");
        worker.postMessage({ data: jsonData, base_url });

        worker.onmessage = function(e) {
            modal.loading_progress(false);

            let { invalid, errorLogs, valid_data, err_counter, ba_per_store } = e.data;
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
                setTimeout(() => saveValidatedData(valid_data, ba_per_store), 500);
            } else {
                btn.prop("disabled", false);
                modal.alert("No valid data returned. Please check the file and try again.", "error", () => {});
            }
        };

        worker.onerror = function() {
            modal.loading_progress(false);
            modal.alert("Error processing data. Please try again.", "error", () => {});
        };
    };

    function saveValidatedData(valid_data, ba_per_store) {
        const overallStart = new Date();
        let batch_size = 5000;
        let total_batches = Math.ceil(valid_data.length / batch_size);
        let batch_index = 0;
        let errorLogs = [];
        let url = "<?= base_url('cms/global_controller');?>";
        let table = 'tbl_store';
        let selected_fields = ['id', 'code', 'description'];

        const existingMapByCode = new Map(), existingMapByDescription = new Map();
        const matchType = "OR"; 

        modal.loading_progress(true, "Validating and Saving data...");

        aJax.post(url, { table: table, event: "fetch_existing", status: true, selected_fields: selected_fields }, function(response) {
            const result = JSON.parse(response);
            const allEntries = result.existing || [];

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

                    logActivity("import-store-branch-module", "Import Batch", remarks, "-", JSON.stringify(valid_data), JSON.stringify(originalEntries));

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
                        batch_update(url, updateRecords, "tbl_store", "id", true, (response) => {
                            if (response.message !== 'success') {
                                errorLogs.push(`Failed to update: ${JSON.stringify(response.error)}`);
                            }
                            updateOverallProgress("Updating Stores...", batch_index + 1, total_batches);
                            processBaPerStore(updateRecords.map(r => ({ id: r.id, code: r.code })), ba_per_store, callback);
                        });
                    } else {
                        callback(); // Proceed even if no updates
                    }
                }

                function processInserts() {
                    if (newRecords.length > 0) {
                        batch_insert(url, newRecords, "tbl_store", true, (response) => {
                            if (response.message === 'success') {
                                let inserted_ids = response.inserted;
                                updateOverallProgress("Saving Stores...", batch_index + 1, total_batches);
                                processBaPerStore(inserted_ids, ba_per_store, function() {
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

    function processBaPerStore(inserted_ids, ba_per_store, callback) {
        const url               = "<?= base_url('cms/global_controller');?>";
        const overallStart      = new Date();
        const batch_size        = 5000;
        let baBatchIndex        = 0;
        let baDataKeys          = Object.keys(ba_per_store);
        let total_ba_batches    = Math.ceil(baDataKeys.length / batch_size);

        let allNewEntries       = [];

        let insertedMap = {};
        inserted_ids.forEach(({ id, code }) => {
            insertedMap[code] = id;
        });

        if (baDataKeys.length === 0) {
            const overallEnd = new Date();
            const duration   = formatDuration(overallStart, overallEnd);
            const remarks    = `
                Action: Import BA-Brand
                <br>Processed 0 records
                <br>Start: ${formatReadableDate(overallStart)}
                <br>End: ${formatReadableDate(overallEnd)}
                <br>Duration: ${duration}
            `;
            logActivity("ba-brand-module-import", "Import BA-Per-Store Batch", remarks, "-", JSON.stringify(allNewEntries), JSON.stringify([]));
            return callback();
        }

        function processNextStoreBatch() {
            // 2a) All done?
            if (baBatchIndex >= total_ba_batches) {
                const overallEnd = new Date();
                const duration   = formatDuration(overallStart, overallEnd);
                const remarks    = `
                    Action: Import BA-Per-Store Batch
                    <br>Processed ${allNewEntries.length} records
                    <br>Start: ${formatReadableDate(overallStart)}
                    <br>End: ${formatReadableDate(overallEnd)}
                    <br>Duration: ${duration}
                `;
                logActivity("ba-per-store-module-import", "Import BA-Per-Store Batch", remarks, "-", JSON.stringify(allNewEntries), JSON.stringify([]));
                return callback();
            }
           
            const chunkKeys      = baDataKeys.slice(baBatchIndex * batch_size,(baBatchIndex + 1) * batch_size);
            let chunkData        = [];
            let storeIdsToDelete = [];

            chunkKeys.forEach(code => {
                const store_id = insertedMap[code];
                const ba_ids   = ba_per_store[code];
                if (store_id && Array.isArray(ba_ids)) {
                    storeIdsToDelete.push(store_id);
                    ba_ids.forEach(ba_id => {
                        chunkData.push({
                            store_id,
                            brand_ambassador_id: ba_id,
                            created_by:   user_id,
                            created_date: formatDate(new Date()),
                            updated_date: formatDate(new Date())
                        });
                    });
                }
            });

            allNewEntries = allNewEntries.concat(chunkData);

            function insertNewStoreRecords() {
                if (chunkData.length > 0) {
                    batch_insert(url, chunkData, "tbl_brand_ambassador_group", false, function(response) {
                        baBatchIndex++;
                        setTimeout(processNextStoreBatch, 100);
                    });
                } else {
                    baBatchIndex++;
                    setTimeout(processNextStoreBatch, 100);
                }
            }

            if (storeIdsToDelete.length > 0) {
                batch_delete(url, "tbl_brand_ambassador_group", "store_id", storeIdsToDelete, "brand_ambassador_id", () => insertNewStoreRecords());
            } else {
                insertNewStoreRecords();
            }
        }

        processNextStoreBatch();
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
    };

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
        })

        get_field_values("tbl_store", "code", "id", code, (res) => {
            if(code.length == 1) {
                code_string = `Code <b><i>${res[code[0]]}</i></b>`;
            }
        })

        if (parseInt(status) === -2) {
            message = is_json(confirm_delete_message);
            message.message = `Delete ${code_string} from Store/Branch Masterfile?`;
            modal_obj = JSON.stringify(message);
            modal_alert_success = success_delete_message;
            offset = 1;
        } else if (parseInt(status) === 1) {
            message = is_json(confirm_publish_message);
            message.message = `Publish ${code_string} from Store/Branch Masterfile?`;
            modal_obj = JSON.stringify(message);
            modal_alert_success = success_publish_message;
        } else {
            message = is_json(confirm_unpublish_message);
            message.message = `Unpublish ${code_string} from Store/Branch Masterfile?`;
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
                        table: "tbl_store",
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
                "Store/Branch Code": "",
                "Store/Branch Description": "",
                "Store/Branch Brand Ambassador Code": "",
                "Store Segment Code" : "",
                "Status": "",
                "NOTE:": "Please do not change the column headers."
            },
            {
                "Store/Branch Code": "",
                "Store/Branch Description": "",
                "Store/Branch Brand Ambassador Code": "",
                "Store Segment Code" : "",
                "Status": "",
                "NOTE:": "Brand Ambassadors should be separated by commas. eg(BA1, BA2, BA3)"
            }
        ]

        exportArrayToCSV(formattedData, `Masterfile: Store/Branch - ${formatDate(new Date())}`, headerData);
    }

    $(document).on('click', '#btn_export', function () {
        modal.confirm(confirm_export_message,function(result){
            if (result) {
                modal.loading_progress(true, "Reviewing Data...");
                setTimeout(() => {
                    exportStore()
                }, 500);
            }
        })
    })

    const exportStore = () => {
        var ids = [];

        $('.select:checked').each(function () {
            var id = $(this).attr('data-id');
            ids.push(`'${id}'`);
        });

        console.log(ids, 'ids');

        const params = new URLSearchParams();
        ids.length > 0 ? 
            params.append('selectedids', ids.join(',')) :
            params.append('selectedids', '0');

        window.open("<?= base_url('cms/');?>" + 'store-branch/export-store?'+ params.toString(), '_blank');
        modal.loading_progress(false);
    }

    function exportArrayToCSV(data, filename, headerData) {

        const worksheet = XLSX.utils.json_to_sheet(data, { origin: headerData.length });
        XLSX.utils.sheet_add_aoa(worksheet, headerData, { origin: "A1" });
        const csvContent = XLSX.utils.sheet_to_csv(worksheet);
        const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
        saveAs(blob, filename + ".csv");
    }

</script>