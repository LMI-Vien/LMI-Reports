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

    @media (min-width: 1200px) {
        .modal-xxl {
            max-width: 95%;
        }
    }

</style>

    <div class="content-wrapper p-4">
        <div class="card">
            <div class="text-center page-title md-center">
                <b>B A - S A L E S - R E P O R T</b>
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
                                        <th class='center-content'>Area</th>
                                        <th class='center-content'>Store Name</th>
                                        <th class='center-content'>Brand</th>
                                        <th class='center-content'>BA Name</th>
                                        <th class='center-content'>Date</th>
                                        <th class='center-content'>Amount</th>
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
                            <label for="area" class="form-label">Area</label>
                            <input type="text" class="form-control required" id="area" aria-describedby="area">
                        </div>

                        <div class="mb-3">
                            <label for="store_name" class="form-label">Store Name</label>
                            <input type="text" class="form-control required" id="store_name" aria-describedby="store_name">
                        </div>

                        <div class="mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <input type="text" class="form-control required" id="brand" aria-describedby="brand">
                        </div>

                        <div class="mb-3">
                            <label for="ba_name" class="form-label">BA Name</label>
                            <input type="text" class="form-control required" id="ba_name" aria-describedby="ba_name">
                        </div>
                        
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control required" id="date" aria-describedby="date">
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="text" class="form-control required" id="amount" aria-describedby="amount">
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
                    <div class="card">
                        <div class="mb-3" style="overflow-x: auto; height: 450px; padding: 0px;">
                            <div class="text-center"
                            style="padding: 10px; font-family: 'Courier New', Courier, monospace; font-size: large; background-color: #fdb92a; color: #333333; border: 1px solid #ffffff; border-radius: 10px;"                            
                            >
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

                        </div>

                            <table class= "table table-bordered listdata">
                                <thead>
                                    <tr>
                                        <th class='center-content'>Line #</th>
                                        <th class='center-content'>Area</th>
                                        <th class='center-content'>Store Name</th>
                                        <th class='center-content'>Brand</th>
                                        <th class='center-content'>BA Name</th>
                                        <th class='center-content'>Date</th>
                                        <th class='center-content'>Amount</th>
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
    var query = "basr.status >= 0";
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url('cms/global_controller');?>";
    var base_url = '<?= base_url();?>';

    //for importing
    let currentPage = 1;
    let rowsPerPage = 1000;
    let totalPages = 1;
    let dataset = [];

    $(document).ready(function() {
        get_data(query);
        get_pagination();
    });

    // function get_data(new_query) {
    //     var data = {
    //         event : "list",
    //         select : "id, area, store_name, brand, ba_name, date, amount, status, created_date, updated_date",
    //         query : new_query,
    //         offset : offset,
    //         limit : limit,
    //         table : "tbl_ba_sales_report",
    //         order : {
    //             field : "id, updated_date",
    //             order : "asc, desc" 
    //         }

    //     }

    //     aJax.post(url,data,function(result){
    //         var result = JSON.parse(result);
    //         var html = '';

    //         if(result) {
    //             if (result.length > 0) {
    //                 $.each(result, function(x,y) {
    //                     console.log(y);
    //                     var status = ( parseInt(y.status) === 1 ) ? status = "Active" : status = "Inactive";
    //                     var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";
    //                     y.amount = parseFloat(y.amount) || 0;

    //                     html += "<tr class='" + rowClass + "'>";
    //                     html += "<td class='center-content' style='width: 5%'><input class='select' type=checkbox data-id="+y.id+" onchange=checkbox_check()></td>";
    //                     html += "<td scope=\"col\">" + trimText(y.area) + "</td>";
    //                     html += "<td scope=\"col\">" + trimText(y.store_name, 10) + "</td>";
    //                     html += "<td scope=\"col\">" + (y.brand) + "</td>";
    //                     html += "<td scope=\"col\">" + (y.ba_name) + "</td>";
    //                     html += "<td scope=\"col\">" + ViewDateOnly(y.date) + "</td>";
    //                     html += "<td scope=\"col\">" + (y.amount.toLocaleString()) + "</td>";
    //                     html += "<td scope=\"col\">" + (y.created_date ? ViewDateformat(y.created_date) : "N/A") + "</td>";
    //                     html += "<td scope=\"col\">" + (y.updated_date ? ViewDateformat(y.updated_date) : "N/A") + "</td>";

    //                     if (y.id == 0) {
    //                         html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
    //                     } else {
    //                         html+="<td class='center-content' style='width: 25%; min-width: 300px'>";
    //                         html+="<a class='btn-sm btn update' onclick=\"edit_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Edit Details'><span class='glyphicon glyphicon-pencil'>Edit</span>";
    //                         html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Delete Item'><span class='glyphicon glyphicon-pencil'>Delete</span>";
    //                         html+="<a class='btn-sm btn view' onclick=\"view_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Show Details'><span class='glyphicon glyphicon-pencil'>View</span>";
    //                         html+="</td>";
    //                     }
                        
    //                     html += "</tr>";   
    //                 });
    //             } else {
    //                 html = '<tr><td colspan=12 class="center-align-format">'+ no_records +'</td></tr>';
    //             }
    //         }
    //         $('.table_body').html(html);
    //     });
    // }

    function get_data(new_query) {
        var data = {
            event : "list",
            select : "basr.id, ar.description as area, s.description as store_name, b.brand_description as brand, ba.name as ba_name, basr.date, basr.amount, basr.status, basr.created_date, basr.updated_date, basr.status",
            query : new_query,
            offset : offset,
            limit : limit,
            table : "tbl_ba_sales_report basr",
            join : [
                {
                    table: "tbl_brand b",
                    query: "b.id = basr.brand",
                    type: "left"
                },
                {
                    table: "tbl_store s",
                    query: "s.id = basr.store_name",
                    type: "left"
                },
                {
                    table: "tbl_brand_ambassador ba",
                    query: "ba.id = basr.ba_name",
                    type: "left"
                },
                {
                    table: "tbl_area ar",
                    query: "ar.id = basr.area",
                    type: "left"
                }
            ], 
            order : {
                field : "basr.id",
                order : "asc" 
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
                        var status = ( parseInt(y.status) === 1 ) ? status = "Active" : status = "Inactive";
                        y.amount = parseFloat(y.amount) || 0;

                        var areaDescription = y.area || 'N/A';
                        var storeDescription = y.store_name || 'N/A';
                        var brandDescription = y.brand || 'NA';
                        var brandAmbassadorName = y.ba_name || 'NA';

                        html += "<tr class='" + rowClass + "'>";
                        html += "<td class='center-content' style='width: 5%'><input class='select' type=checkbox data-id="+y.id+" onchange=checkbox_check()></td>";
                        html += "<td scope=\"col\">" + trimText(areaDescription) + "</td>"
                        html += "<td scope=\"col\">" + trimText(storeDescription) + "</td>"
                        html += "<td scope=\"col\">" + trimText(brandDescription) + "</td>"
                        html += "<td scope=\"col\">" + trimText(brandAmbassadorName) + "</td>"
                        html += "<td scope=\"col\">" + ViewDateOnly(y.date) + "</td>";
                        html += "<td scope=\"col\">" + (y.amount.toLocaleString()) + "</td>";
                        html += "<td scope=\"col\">" + status + "</td>";
                        html += "<td scope=\"col\">" + (y.created_date ? ViewDateformat(y.created_date) : "N/A") + "</td>";
                        html += "<td scope=\"col\">" + (y.updated_date ? ViewDateformat(y.updated_date) : "N/A") + "</td>";

                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                            html+="<td class='center-content' style='width: 25%; min-width: 300px'>";
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

    function get_pagination() {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
          event : "pagination",
            select : "basr.id, basr.status",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_ba_sales_report as basr"
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
            var new_query = "(" + query + " AND ar.description LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND s.description LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND b.brand_description LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND ba.name LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND basr.date LIKE '%" + keyword + "%')"; 
                
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
        open_modal('Add New BA Sales Report', 'add', '');
    });

    function edit_data(id) {
        open_modal('Edit BA Sales Report', 'edit', id);
    }

    function view_data(id) {
        open_modal('View BA Sales Report', 'view', id);
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
        set_field_state('#area, #store_name, #brand, #ba_name, #date, #amount', isReadOnly);

        $footer.empty();
        if (actions === 'add') $footer.append(buttons.save);
        if (actions === 'edit') $footer.append(buttons.edit);
        $footer.append(buttons.close);

        $modal.modal('show');
    }

    function reset_modal_fields() {
        $('#popup_modal #area, #popup_modal #store_name, #popup_modal #brand, #popup_modal #ba_name, #popup_modal #date, #popup_modal #amount').val('');
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
        title = addNbsp('IMPORT BA SALES REPORT')
        $("#import_modal").find('.modal-title').find('b').html(title)
        $('#import_modal').modal('show');
    });

    function populate_modal(inp_id) {
        var query = "status >= 0 and id = " + inp_id;
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, area, store_name, brand, ba_name, date, amount",
            query : query, 
            table : "tbl_ba_sales_report"
        }
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(index,d) {
                    // $('#area').val(d.area);
                    get_area(d.area);
                    // $('#store_name').val(d.store_name);
                    get_store(d.store_name);
                    // $('#brand').val(d.brand);
                    get_brand(d.brand);
                    // $('#ba_name').val(d.ba_name);
                    get_brand_ambassador(d.ba_name);
                    $('#date').val(d.date);
                    $('#amount').val(d.amount);
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

    function save_to_db(inp_area, inp_store_name, inp_brand, inp_ba_name, inp_date, inp_amount, id) {
        const url = "<?= base_url('cms/global_controller'); ?>";
        let data = {}; 
        let modal_alert_success;

        if (id !== undefined && id !== null && id !== '') {
            modal_alert_success = success_update_message;
            data = {
                event: "update",
                table: "tbl_ba_sales_report",
                field: "id",
                where: id,
                data: {
                    area: inp_area,
                    store_name: inp_store_name,
                    brand: inp_brand,
                    ba_name: inp_ba_name,
                    date: inp_date,
                    amount: inp_amount,
                    updated_date: formatDate(new Date()),
                    updated_by: user_id,
                }
            };
        } else {
            modal_alert_success = success_save_message;
            data = {
                event: "insert",
                table: "tbl_ba_sales_report",
                data: {
                    area: inp_area,
                    store_name: inp_store_name,
                    brand: inp_brand,
                    ba_name: inp_ba_name,
                    date: inp_date,
                    amount: inp_amount,
                    created_date: formatDate(new Date()),
                    created_by: user_id,
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
        var area = $('#area').val();
        var store_name = $('#store_name').val();
        var brand = $('#brand').val();
        var ba_name = $('#ba_name').val();
        var date = $('#date').val();
        var amount = $('#amount').val();

        if(validate.standard("form-modal")){
            if (id !== undefined && id !== null && id !== '') {
                // check_current_db("tbl_vmi", ["store", "store_name", "item", "item_name", "item_class", "supplier", "group", "dept", "class", "sub_class", "on_hand", "in_transit", "total_qty", "average_sales_unit", "swc", "a202445"],
                // [store, store_name, item, item_name, item_class, supplier, group, dept, classs, sub_class, on_hand, in_transit, total_qty, avg_sales_unit, swc, a202445], "status" , "id", id, true, function(exists, duplicateFields) {
                    // if (exists) {
                        modal.confirm(confirm_update_message, function(result){
                            if(result){ 
                                    modal.loading(true);
                                save_to_db(area, store_name, brand, ba_name, date, amount, id)
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
                    table : "tbl_ba_sales_report",
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
                        table: "tbl_ba_sales_report",
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

    function ViewDateOnly(dateString) {
        let date = new Date(dateString);
        return date.toLocaleString('en-US', { 
            month: 'short', 
            day: 'numeric', 
            year: 'numeric'
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

        if (dataset.length === 0) {
            return modal.alert('No data to process. Please upload a file.', 'error', () => {});
        }
        modal.loading(true);

        let jsonData = dataset.map(row => {
            return {
                "Area": row["Area"] || "",
                "Store Name": row["Store Name"] || "",
                "Brand": row["Brand"] || "",
                "BA Name": row["BA Name"] || "",
                "Date": row["Date"] || "",
                "Amount": row["Amount"] || "",
                "Created by": user_id || "", 
                "Created Date": formatDate(new Date()) || ""
            };
        });

        let worker = new Worker(base_url + "assets/cms/js/validator_ba_sales_report.js");
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
                    setTimeout(() => saveValidatedData(valid_data), 500);
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

            let td_validator = ['area', 'store name', 'brand', 'ba name', 'date', 'amount'];
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
        let batch_size = 5000; // Process 1000 records at a time
        let total_batches = Math.ceil(valid_data.length / batch_size);
        let batch_index = 0;
        let errorLogs = [];
        let url = "<?= base_url('cms/global_controller');?>";
        let table = 'tbl_ba_sales_report';

        let selected_fields = [
            'id', 'area', 'store_name', 'brand', 'ba_name', 'date'
        ];

        const matchFields = [
            'area', 'store_name', 'brand', 'ba_name', 'date'
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
                    if (row.date) {
                        row.date = formatDateToISO(row.date);
                    }
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

    function get_area(id) {
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event: "list",
            select: "id, code, description, status",
            query: "status >= 0 AND id = " + id,
            offset: 0,
            limit: 0,
            table: "tbl_area",
            order: {
                field: "id",
                order: "asc"
            }
        };

        aJax.post(url, data, function(res) {
            var result = JSON.parse(res);
            // console.log("location Data:", result);

            var area = ''; 
            if (result && result.length > 0) {
                area = result[0].code; 
            }

            $('#area').val(area); 
        });
    }

    function get_store(id) {
        var url = "<?= base_url('cms/global_controller');?>"; 
        var data = {
            event: "list",
            select: "id, code, description, status",
            query: "status >= 0 AND id = " + id,
            offset: 0,
            limit: 0,
            table: "tbl_store",
            order: {
                field: "code",
                order: "asc"
            }
        };

        aJax.post(url, data, function(res) {
            var result = JSON.parse(res);
            // console.log("location Data:", result);

            var store_name = '';
            if (result && result.length > 0) {
                store_name = result[0].description;
            }

            $('#store_name').val(store_name);
        });
    }

    function get_brand(id) {
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event: "list",
            select: "id, brand_code, brand_description, status",
            query: "status >= 0 AND id = " + id,
            offset: 0,
            limit: 0,
            table: "tbl_brand",
            order: {
                field: "brand_code",
                order: "asc"
            }
        };

        aJax.post(url, data, function(res) {
            var result = JSON.parse(res);
            // console.log("location Data:", result);

            var brand = '';
            if (result && result.length > 0) {
                brand = result[0].brand_description;
            }

            $('#brand').val(brand);
        });
    }

    function get_brand_ambassador(id) {
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event: "list",
            select: "id, code, name, deployment_date, status",
            query: "status >= 0 AND id = " + id,
            offset: 0,
            limit: 0,
            table: "tbl_brand_ambassador",
            order: {
                field: "code",
                order: "asc"
            }
        };

        aJax.post(url, data, function(res) {
            var result = JSON.parse(res);
            // console.log("location Data:", result);

            var ba_name = '';
            if (result && result.length > 0) {
                ba_name = result[0].name;
            }

            $('#ba_name').val(ba_name);
        });
    }


    
</script>