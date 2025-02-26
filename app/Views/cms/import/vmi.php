<style>
    @media (min-width: 1200px) {
        .modal-xxl {
            max-width: 95%;
        }
    }

    .card {
        margin-right: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .uniform-dropdown {
        height: 36px;
        font-size: 14px;
        border-radius: 5px;
        min-width: 120px; /* Ensures uniform dropdown width */
        flex-grow: 1; /* Makes sure dropdown takes available space */
    }
    
    .d-flex {
        gap: 10px; /* Adds space between label and dropdown */
        margin: 5px;
    }

</style>

<div class="content-wrapper p-4">
    <div class="card">
        <div class="text-center page-title md-center">
            <b>I M P O R T - V M I</b>
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
                                    <th class='center-content'>Store</th>
                                    <th class='center-content'>Store Name</th>
                                    <th class='center-content'>Item</th>
                                    <th class='center-content'>Item Name</th>
                                    <th class='center-content'>VMI Status</th>
                                    <th class='center-content'>Status</th>
                                    <th class='center-content'>Item Class</th>
                                    <th class='center-content'>Supplier</th>
                                    <th class='center-content'>Group</th>
                                    <th class='center-content'>Dept</th>
                                    <th class='center-content'>Class</th>
                                    <th class='center-content'>Sub-class</th>
                                    <th class='center-content'>On Hand</th>
                                    <th class='center-content'>In transit</th>
                                    <th class='center-content'>Total Qty</th>
                                    <th class='center-content'>Ave Sales Unit</th>
                                    
                                    <th class='center-content'>Date Created</th>
                                    <th class='center-content'>Date Modified</th>
                                    <th class='center-content'>Company</th>
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
    <div class="modal-dialog modal-xl">
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
                        <label for="store" class="form-label">Store</label>
                        <input type="text" class="form-control required" id="store" aria-describedby="store">
                    </div>

                    <div class="mb-3">
                        <label for="store_name" class="form-label">Store Name</label>
                        <input type="text" class="form-control required" id="store_name" aria-describedby="store_name">
                    </div>

                    <div class="mb-3">
                        <label for="item" class="form-label">Item</label>
                        <input type="text" class="form-control required numbersonly" id="item" aria-describedby="item">
                    </div>

                    <div class="mb-3">
                        <label for="item_name" class="form-label">Item Name</label>
                        <input type="text" class="form-control required" id="item_name" aria-describedby="item_name">
                    </div>

                    <div class="mb-3">
                        <label for="item_class" class="form-label">Item Class</label>
                        <input type="text" class="form-control required" id="item_class" aria-describedby="item_class">
                    </div>

                    <div class="mb-3">
                        <label for="supplier" class="form-label">Supplier</label>
                        <input type="text" class="form-control required numbersonly" id="supplier" aria-describedby="supplier">
                    </div>

                    <div class="mb-3">
                        <label for="group" class="form-label">Group</label>
                        <input type="text" class="form-control required numbersonly" id="group" aria-describedby="group">
                    </div>

                    <div class="mb-3">
                        <label for="dept" class="form-label">Dept</label>
                        <input type="text" class="form-control required numbersonly" id="dept" aria-describedby="dept">
                    </div>

                    <div class="mb-3">
                        <label for="class" class="form-label">Class</label>
                        <input type="text" class="form-control required numbersonly" id="class" aria-describedby="class">
                    </div>

                    <div class="mb-3">
                        <label for="sub_class" class="form-label">Sub Class</label>
                        <input type="text" class="form-control required numbersonly" id="sub_class" aria-describedby="sub_class">
                    </div>

                    <div class="mb-3">
                        <label for="on_hand" class="form-label">On Hand</label>
                        <input type="text" class="form-control required numbersonly" id="on_hand" aria-describedby="on_hand">
                    </div>

                    <div class="mb-3">
                        <label for="in_transit" class="form-label">In Transit</label>
                        <input type="text" class="form-control required numbersonly" id="in_transit" aria-describedby="in_transit">
                    </div>

                    <div class="mb-3">
                        <label for="avg_sales_unit" class="form-label">Average Sales Unit</label>
                        <input type="text" class="form-control required numbersdecimalonly" id="avg_sales_unit" aria-describedby="avg_sales_unit">
                    </div>

                    <div class="mb-3">
                        <label for="company" class="form-label">Company</label>
                        <input type="text" class="form-control required" id="company" aria-describedby="company">
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
    <div class="modal-dialog modal-xxl">
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
    <div class="card p-3">
        <div class="mb-3" style="overflow-x: auto; height: 450px;">
            <div class="text-center p-2" 
                style="font-family: 'Courier New', Courier, monospace; font-size: large; background-color: #fdb92a; color: #333333; border-radius: 10px;">
                <b>Extracted Data</b>
            </div>

            <div class="row my-3">
                <div class="col-md-8 import_buttons">
                    <label for="file" class="btn btn-warning mt-2" style="margin-bottom: 0px;">
                        <i class="fa fa-file-import me-2"></i> Custom Upload
                    </label>
                    <input type="file" id="file" accept=".xls,.xlsx,.csv" style="display: none;" onclick="clear_import_table()">

                    <button class="btn btn-primary mt-2" id="preview_xl_file" onclick="read_xl_file()">
                        <i class="fa fa-sync me-2"></i> Preview Data
                    </button>

                    <button class="btn btn-success mt-2" id="download_template" onclick="download_template()">
                        <i class="fa fa-file-download me-2"></i> Download Import Template
                    </button>
                </div>

                <div class="col-md-4">
                    <div class="card p-4 shadow-lg rounded-3 border-0" style="background: #f8f9fa;">
                        <div class="row g-3">
                            <div class="col-12 d-flex align-items-center">
                                <label for="yearSelect" class="form-label fw-semibold me-2">Choose Year:</label>
                                <select id="yearSelect" class="form-select uniform-dropdown">
                                </select>
                            </div>
                            <div class="col-12 d-flex align-items-center">
                                <label for="monthSelect" class="form-label fw-semibold me-2">Choose Month:</label>
                                <select id="monthSelect" class="form-select uniform-dropdown">
                                </select>
                            </div>
                            <div class="col-12 d-flex align-items-center">
                                <label for="weekSelect" class="form-label fw-semibold me-2">Choose Week:</label>
                                <select id="weekSelect" class="form-select uniform-dropdown">
                                </select>
                            </div>
                            <div class="col-12 d-flex align-items-center">
                                <label for="companySelect" class="form-label fw-semibold me-2">Choose Company:</label>
                                <select id="companySelect" class="form-select uniform-dropdown">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <table class="table table-bordered listdata">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Line #</th>
                        <th>Store</th>
                        <th>Item</th>
                        <th>Item Name</th>
                        <th>VMI Status</th>
                        <th>Item Class</th>
                        <th>Supplier</th>
                        <th>Group</th>
                        <th>Dept</th>
                        <th>Class</th>
                        <th>Sub-class</th>
                        <th>On Hand</th>
                        <th>In transit</th>
                        <th>Ave Sales Unit</th>
                    </tr>
                </thead>
                <tbody class="word_break import_table"></tbody>
            </table>
        </div>

        <center class="my-2">
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
    var query = "v.status >= 0";
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url('cms/global_controller');?>";

    //for importing
    let currentPage = 1;
    let rowsPerPage = 1000;
    let totalPages = 1;
    let dataset = [];

    $(document).ready(function() {
      get_data(query);
      get_pagination();
    });

    function get_data(new_query) {
        var data = {
            event: "list",
            select: "v.id, s.code AS store, s.description AS store_name, v.item, v.item_name, v.status, v.item_class, v.supplier, v.group, v.dept, v.class, v.sub_class, v.on_hand, v.in_transit, (v.on_hand + v.in_transit) AS total_qty, v.average_sales_unit, v.vmi_status, v.created_date, v.updated_date, c.name AS company",
            query: new_query,
            offset: offset,
            limit: limit,
            table: "tbl_vmi v",
            join: [
                {
                    table: "tbl_store s",
                    query: "s.id = v.store",
                    type: "left"
                },
                {
                    table: "tbl_company c",
                    query: "c.id = v.company",
                    type: "left"
                }
            ],
            order: {
                field: "v.year",
                order: "asc"
            }
        };


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
                        html += "<td scope=\"col\">" + (y.store) + "</td>";
                        html += "<td scope=\"col\">" + trimText(y.store_name, 10) + "</td>";
                        html += "<td scope=\"col\">" + (y.item) + "</td>";
                        html += "<td scope=\"col\">" + y.item_name + "</td>";
                        html += "<td scope=\"col\">" + (y.vmi_status) + "</td>";
                        html += "<td scope=\"col\">" + status + "</td>";
                        html += "<td scope=\"col\">" + trimText(y.item_class, 10) + "</td>";
                        html += "<td scope=\"col\">" + (y.supplier) + "</td>";
                        html += "<td scope=\"col\">" + (y.group) + "</td>";
                        html += "<td scope=\"col\">" + (y.dept) + "</td>";
                        html += "<td scope=\"col\">" + (y.class) + "</td>";
                        html += "<td scope=\"col\">" + (y.sub_class) + "</td>";
                        html += "<td scope=\"col\">" + (y.on_hand) + "</td>";
                        html += "<td scope=\"col\">" + (y.in_transit) + "</td>";
                        html += "<td scope=\"col\">" + (y.total_qty) + "</td>";
                        html += "<td scope=\"col\">" + (y.average_sales_unit) + "</td>";
                        html += "<td scope=\"col\">" + (y.created_date ? ViewDateformat(y.created_date) : "N/A") + "</td>";
                        html += "<td scope=\"col\">" + (y.updated_date ? ViewDateformat(y.updated_date) : "N/A") + "</td>";
                        html += "<td scope=\"col\">" + (y.company) + "</td>";

                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                            html+="<td class='center-content' style='width: 25%; min-width: 300px'>";
                            //html+="<a class='btn-sm btn update' onclick=\"edit_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Edit Details'><span class='glyphicon glyphicon-pencil'>Edit</span>";
                            html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Delete Item'><span class='glyphicon glyphicon-pencil'>Delete</span>";
                            html+="<a class='btn-sm btn view' onclick=\"view_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Show Details'><span class='glyphicon glyphicon-pencil'>View</span>";
                            html+="</td>";
                        }
                        
                        html += "</tr>";   
                    });
                } else {
                    html = '<tr><td colspan=18 class="center-align-format">'+ no_records +'</td></tr>';
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
            table : "tbl_vmi v",

        }

        aJax.post(url,data,function(result){
            var obj = is_json(result); //check if result is valid JSON format, Format to JSON if not
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
    });

    $(document).on('keypress', '#search_query', function(e) {               
        if (e.keyCode === 13) {
            var keyword = $(this).val().trim();
            offset = 1;
            var new_query = "(" + query + " AND s.code LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND s.description LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND v.item LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND v.item_name LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND v.item_class LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND v.supplier LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND `v.group` LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND v.dept LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND v.class LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND v.sub_class LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND v.on_hand LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND v.in_transit LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND average_sales_unit LIKE '%" + keyword + "%')";
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
        get_pagination(query);
        modal.loading(false);
    });

    $(document).on('click', '#btn_add', function() {
        open_modal('Add New VMI', 'add', '');
    });

    function edit_data(id) {
        open_modal('Edit VMI', 'edit', id);
    }

    function view_data(id) {
        open_modal('View VMI', 'view', id);
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
                save_data('update', id);
               
            }),
            close: create_button('Close', 'close_data', 'btn caution', function () {
                $modal.modal('hide');
            })
        };

        if (['edit', 'view'].includes(actions)) populate_modal(id);
        
        let isReadOnly = actions === 'view';
        set_field_state('#store, #store_name, #item, #item_name, #item_class, #supplier, #group, #dept, #class, #sub_class, #on_hand, #in_transit, #total_qty, #avg_sales_unit, #swc, #202445, #status, #company', isReadOnly);

        $footer.empty();
        if (actions === 'add') $footer.append(buttons.save);
        if (actions === 'edit') $footer.append(buttons.edit);
        $footer.append(buttons.close);

        $modal.modal('show');
    }

    function reset_modal_fields() {
        $('#popup_modal #store, #popup_modal #store_name, #popup_modal #item, #popup_modal #item_name, #popup_modal #item_class, #popup_modal #supplier, #popup_modal #group, #popup_modal #dept, #popup_modal #class, #popup_modal #sub_class, #popup_modal #on_hand, #popup_modal #in_transit, #popup_modal #total_qty, #popup_modal #avg_sales_unit, #popup_modal #swc, #popup_modal #202445').val('');
        $('#popup_modal #status').prop('checked', true);
    }

    function clear_import_table() {
        $(".import_table").empty();
    }

    function paginateData(rowsPerPage) {
        totalPages = Math.ceil(dataset.length / rowsPerPage);
        currentPage = 1;
        display_imported_data();
    }

    function set_field_state(selector, isReadOnly) {
        $(selector).prop({ readonly: isReadOnly, disabled: isReadOnly });
    }

    $(document).on('click', '#btn_import ', function() {
        title = addNbsp('IMPORT VMI')
        $("#import_modal").find('.modal-title').find('b').html(title)
        $('#import_modal').modal('show');
        get_year();
        get_month();
        get_company();
        get_week();
    });

    function populate_modal(inp_id) {
        var query = "v.status >= 0 and v.id = " + inp_id;
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "v.id, s.code as store,, s.description as store_name, v.item, v.item_name, v.status, v.item_class, v.supplier, v.group, v.dept, v.class, v.sub_class, v.on_hand, v.in_transit, v.average_sales_unit, c.name AS company",
            query : query, 
            table : "tbl_vmi v",
            join : [
                {
                    table: "tbl_store s",
                    query: "s.id = v.store",
                    type: "left"
                },
                {
                    table: "tbl_company c",
                    query: "c.id = v.company",
                    type: "left"
                }
            ], 
        }
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(index,d) {
                    $('#id').val(d.id);
                    $('#store').val(d.store);
                    $('#store_name').val(d.store_name);
                    $('#item').val(d.item);
                    $('#item_name').val(d.item_name);
                    $('#item_class').val(d.item_class);
                    $('#supplier').val(d.supplier);
                    $('#group').val(d.group);
                    $('#dept').val(d.dept);
                    $('#class').val(d.class);
                    $('#sub_class').val(d.sub_class);
                    $('#on_hand').val(d.on_hand);
                    $('#in_transit').val(d.in_transit);
                    // $('#total_qty').val(d.total_qty);
                    $('#avg_sales_unit').val(d.average_sales_unit);
                    $('#company').val(d.company);
                    // $('#swc').val(d.swc);
                    $('#202445').val(d.a202445);
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
            click: onclick_event // Attach the onclick event
        });
        return new_btn;
    }

    function save_to_db(inp_store, inp_item, inp_item_name, inp_item_class, inp_supplier, inp_group, inpt_dept, inp_class, inp_sub_class, inp_on_hand, inp_in_transit, inp_total_qty, inp_avg_sales_unit, status_val, id) {
        const url = "<?= base_url('cms/global_controller'); ?>";
        let data = {}; 
        let modal_alert_success;

        if (id !== undefined && id !== null && id !== '') {
            modal_alert_success = success_update_message;
            data = {
                event: "update",
                table: "tbl_vmi",
                field: "id",
                where: id,
                data: {
                    store: inp_store,
                    // store_name: inp_store_name,
                    item: inp_item,
                    item_name: inp_item_name,
                    item_class: inp_item_class,
                    supplier: inp_supplier,
                    group: inp_group, 
                    dept: inpt_dept,
                    class: inp_class,
                    sub_class: inp_sub_class,
                    on_hand: inp_on_hand,
                    in_transit: inp_in_transit,
                    // total_qty: inp_total_qty,
                    average_sales_unit: inp_avg_sales_unit,
                    // swc: inp_swc,
                    // a202445: inp_a202445,
                    updated_date: formatDate(new Date()),
                    updated_by: user_id,
                    status: status_val
                }
            };
        } else {
            modal_alert_success = success_save_message;
            data = {
                event: "insert",
                table: "tbl_vmi",
                data: {
                    store: inp_store,
                    // store_name: inp_store_name,
                    item: inp_item,
                    item_name: inp_item_name,
                    item_class: inp_item_class,
                    supplier: inp_supplier,
                    group: inp_group, 
                    dept: inpt_dept,
                    class: inp_class,
                    sub_class: inp_sub_class,
                    on_hand: inp_on_hand,
                    in_transit: inp_in_transit,
                    // total_qty: inp_total_qty,
                    average_sales_unit: inp_avg_sales_unit,
                    // swc: inp_swc,
                    // a202445: inp_a202445,
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

    function save_data(action, id) {
        var store = $('#store').val();
        // var store_name = $('#store_name').val();
        var item = $('#item').val();
        var item_name = $('#item_name').val();
        var item_class = $('#item_class').val();
        var supplier = $('#supplier').val();
        var group = $('#group').val();
        var dept = $('#dept').val();
        var classs = $('#class').val();
        var sub_class = $('#sub_class').val();
        var on_hand = $('#on_hand').val();
        var in_transit = $('#in_transit').val();
        var total_qty = $('#total_qty').val();
        var avg_sales_unit = $('#avg_sales_unit').val();
        // var swc = $('#swc').val();
        // var a202445 = $('#202445').val();


        var chk_status = $('#status').prop('checked');
        if (chk_status) {
            status_val = 1;
        } else {
            status_val = 3;
        }
        if(validate.standard("form-modal")){
            if (id !== undefined && id !== null && id !== '') {
                // check_current_db("tbl_vmi", ["store", "store_name", "item", "item_name", "item_class", "supplier", "group", "dept", "class", "sub_class", "on_hand", "in_transit", "total_qty", "average_sales_unit", "swc", "a202445"],
                // [store, store_name, item, item_name, item_class, supplier, group, dept, classs, sub_class, on_hand, in_transit, total_qty, avg_sales_unit, swc, a202445], "status" , "id", id, true, function(exists, duplicateFields) {
                    // if (exists) {
                        modal.confirm(confirm_update_message, function(result){
                            if(result){ 
                                    modal.loading(true);
                                save_to_db(store, item, item_name, item_class, supplier, group, dept, classs, sub_class, on_hand, in_transit, total_qty, avg_sales_unit, status_val, id)
                            }
                        });
    
                    // }             
                // });
            }
        }
    }

    function delete_data(id) {
        modal.confirm(confirm_delete_message,function(result){
            if(result){ 
                var url = "<?= base_url('cms/global_controller');?>";
                var data = {
                    event : "update",
                    table : "tbl_vmi",
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

    function addNbsp(inputString) {
        return inputString.split('').map(char => {
            if (char === ' ') {
            return '&nbsp;&nbsp;';
            }
            return char + '&nbsp;';
        }).join('');
    }

    function trimText(str) {
        if (str.length > 10) {
            return str.substring(0, 10) + "...";
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
        modal.confirm(modal_obj, function (result) {
            if (result) {
                var url = "<?= base_url('cms/global_controller');?>";
                var dataList = [];
                
                $('.select:checked').each(function () {
                    var id = $(this).attr('data-id');
                    dataList.push({
                        event: "update",
                        table: "tbl_vmi",
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
        modal.loading_progress(true, "Reviewing Data...");

        const reader = new FileReader();
        reader.onload = function(e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, { type: "array" });
            const sheet = workbook.Sheets[workbook.SheetNames[0]];

            const jsonData = XLSX.utils.sheet_to_json(sheet, { raw: false });

            processInChunks(jsonData, 5000, () => {
                paginateData(rowsPerPage);
            });
        };
        reader.readAsArrayBuffer(file);
    }

    function process_xl_file() {
        let btn = $(".btn.save");
        if (btn.prop("disabled")) return; // Prevent multiple clicks

        btn.prop("disabled", true);
        $(".import_buttons").find("a.download-error-log").remove();
         setTimeout(() => {
                btn.prop("disabled", false);
            }, 4000);
        const year = $('#yearSelect').val()?.trim();
        const month = $('#monthSelect').val()?.trim();
        const week = $('#weekSelect').val()?.trim();
        const company = $('#companySelect').val()?.trim();

        const fields = { year, month, week, company };

        for (const [key, value] of Object.entries(fields)) {
            if (!value) {
                return modal.alert(`Please select a ${key.charAt(0).toUpperCase() + key.slice(1)}.`, 'error', () => {});
            }
        }

        if (dataset.length === 0) {
            return modal.alert('No data to process. Please upload a file.', 'error', () => {});
        }
        modal.loading(true);

        let jsonData = dataset.map(row => {
            return {
                "Store": row["Store"] || "",
                "Item": row["Item"] || "",
                "Item Name": row["Item Name"] || "",
                "VMI Status": row["VMI Status"] || "",
                "Item Class": row["Item Class"] || "",
                "Supplier": row["Supplier"] || "",
                "Group": row["Group"] || "",
                "Dept": row["Dept"] || "",
                "Class": row["Class"] || "",
                "Sub Class": row["Sub Class"] || "",
                "On Hand": row["On Hand"] || "",
                "In Transit": row["In Transit"] || "",
                "Ave Sales Unit": row["Ave Sales Unit"] || "",
                "Created by": user_id || "", 
                "Created Date": formatDate(new Date()) || ""
            };
        });


        let worker = new Worker(base_url + "assets/cms/js/validator_vmi.js");
        worker.postMessage({ data: jsonData, base_url });

        worker.onmessage = function(e) {
            modal.loading_progress(false);
            const { invalid, errorLogs, valid_data, err_counter, progress } = e.data;
            if(progress == 100){
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
                    new_data = valid_data.map(record => ({
                        ...record,
                        year: year,
                        month: month,
                        week: week,
                        company: company
                    }));
                    setTimeout(() => saveValidatedData(new_data), 500);
                } else {
                    btn.prop("disabled", false);
                    modal.alert("No valid data returned. Please check the file and try again.", "error", () => {});
                }
            }else{
                modal.loading(false);
                modal.loading_progress(true); 
                updateSwalProgress("Validating data...", progress);
            
            }

        };

        worker.onerror = function() {
            modal.loading_progress(false);
            modal.alert("Error processing data. Please try again.", "error");
        };
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

            let td_validator = ['store', 'item', 'item name', 'vmi status', 'item class', 'supplier', 'group', 'dept', 'class', 'sub class', 'on hand', 'in transit', 'ave sales unit'];
            td_validator.forEach(column => {
                let value = lowerCaseRecord[column] !== undefined ? lowerCaseRecord[column] : ""; 

                if (column === 'status' && typeof value === 'string') {
                    value = value.replace(/\s*\(.*?\)/g, "");
                }

                html += `<td>${value}</td>`;
            });

            html += "</tr>";
            tr_counter += 1;
        });

        modal.loading(false);
        $(".import_table").html(html);
        updatePaginationControls();
    }

    function saveValidatedData(valid_data) {
        let batch_size = 5000;
        let total_batches = Math.ceil(valid_data.length / batch_size);
        let batch_index = 0;
        let errorLogs = [];
        let url = "<?= base_url('cms/global_controller');?>";
        let table = 'tbl_vmi';

        let selected_fields = [
            'id', 'store', 'item', 'item_name', 'vmi_status', 'item_class',
            'supplier', 'group', 'dept', 'class', 'sub_class', 'on_hand', 
            'in_transit', 'year', 'month', 'company'
        ];

        const matchFields = [
            'store', 'item', 'item_name', 'vmi_status', 'item_class', 'supplier', 
            'group', 'dept', 'class', 'sub_class', 'on_hand', 'in_transit', 'year', 'month', 'company'
        ];  

        const matchType = "AND";  // Use "AND" or "OR" for matching logic

        modal.loading_progress(true, "Validating and Saving data...");

        aJax.post(url, { table: table, event: "fetch_existing", selected_fields: selected_fields }, function(response) {
            let result = JSON.parse(response);
            let existingMap = new Map();

            if (result.existing) {
                result.existing.forEach(record => {
                    let key = matchFields.map(field => String(record[field] || "").trim().toLowerCase()).join("|");
                    existingMap.set(key, record.id);
                });
            }

            function processNextBatch() {
                if (batch_index >= total_batches) {
                    modal.loading_progress(false);
                    if (errorLogs.length > 0) {
                        createErrorLogFile(errorLogs, "Update_Error_Log_" + formatReadableDate(new Date(), true));
                        modal.alert("Some records encountered errors. Check the log.", 'info');
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
                        let key = matchFields.map(field => String(row[field] || "").trim().toLowerCase()).join("|");
                        if (existingMap.has(key)) {
                            matchedId = existingMap.get(key);
                        }
                    } else if (matchType === "OR") {
                        for (let [key, id] of existingMap.entries()) {
                            let keyParts = key.split("|");
                            for (let field of matchFields) {
                                if (keyParts.includes(String(row[field] || "").trim().toLowerCase())) {
                                    matchedId = id;
                                    break; // Stop searching once a match is found
                                }
                            }
                            if (matchedId) break;
                        }
                    }

                    if (matchedId) {
                        row.id = matchedId;
                        row.updated_by = user_id;
                        row.updated_date = formatDate(new Date());
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
                            batch_update(url, updateRecords, table, "id", false, (response) => {
                                if (response.message !== 'success') {
                                    errorLogs.push(`Failed to update: ${JSON.stringify(response.error)}`);
                                }
                                updateSwalProgress("Updating Records...", batch_index + 1, total_batches);
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
                            batch_insert(url, newRecords, table, false, (response) => {
                                if (response.message === 'success') {
                                    updateSwalProgress("Inserting Records...", batch_index + 1, total_batches);
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

                processUpdates()
                    .then(processInserts)
                    .then(() => {
                        batch_index++;
                        setTimeout(processNextBatch, 300);
                    })
                    .catch(error => {
                        errorLogs.push(`Unexpected error: ${error}`);
                        processNextBatch();
                    });
            }

            setTimeout(processNextBatch, 1000);
        });
    }


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
            class: "download-error-log btn btn-danger mt-2", 
            css: {
                border: "1px solid white",
                borderRadius: "10px",
                display: "inline-block",
                // padding: "10px",
                // lineHeight: 0.5,
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

    function get_year() {
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list",
            select : "id, year, status",
            query : 'status >= 0',
            offset : 0,
            limit : 0,
            table : "tbl_year",
            order : {
                field : "id",
                order : "asc" 
            }
        }

        aJax.post(url,data,function(res){
            var result = JSON.parse(res);
            var html = '';
            html += '<option id="default_val" value=" ">Select Year</option>';

    
            if(result) {
                if (result.length > 0) {
                    var selected = '';
                    
                    result.forEach(function (y) {
                        html += `<option value="${y.id}">${y.year}</option>`;
                    });
                }
            }
            $('#yearSelect').html(html);
        })
    }

    function get_month() {
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list",
            select : "id, month, status",
            query : 'status >= 0',
            offset : 0,
            limit : 0,
            table : "tbl_month",
            order : {
                field : "id",
                order : "asc" 
            }
        }

        aJax.post(url,data,function(res){
            var result = JSON.parse(res);
            var html = '';
            html += '<option id="default_val" value=" ">Select Month</option>';
            
    
            if(result) {
                if (result.length > 0) {
                    var selected = '';
                    
                    result.forEach(function (y) {
                        html += `<option value="${y.id}">${y.month}</option>`;
                    });
                }
            }
            $('#monthSelect').html(html);
        })
    }

    function get_week() {
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list",
            select : "id, name, status",
            query : 'status >= 0',
            offset : 0,
            limit : 0,
            table : "tbl_week",
            order : {
                field : "id",
                order : "asc" 
            }
        }

        aJax.post(url,data,function(res){
            var result = JSON.parse(res);
            var html = '';
            html += '<option id="default_val" value=" ">Select Week</option>';
            
    
            if(result) {
                if (result.length > 0) {
                    var selected = '';
                    
                    result.forEach(function (y) {
                        html += `<option value="${y.id}">${y.name}</option>`;
                    });
                }
            }
            $('#weekSelect').html(html);
        })
    }

    function get_company() {
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list",
            select : "id, name, status",
            query : 'status >= 0',
            offset : 0,
            limit : 0,
            table : "tbl_company",
            order : {
                field : "id",
                order : "asc" 
            }
        }

        aJax.post(url,data,function(res){
            var result = JSON.parse(res);
            var html = '';
            html += '<option id="default_val" value=" ">Select Company</option>';
            
    
            if(result) {
                if (result.length > 0) {
                    var selected = '';
                    
                    result.forEach(function (y) {
                        html += `<option value="${y.id}">${y.name}</option>`;
                    });
                }
            }
            $('#companySelect').append(html);
        })
    }
    
</script>