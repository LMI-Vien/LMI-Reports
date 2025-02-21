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
                <b>T A R G E T - S A L E S - P E R S T O R E</b>
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
                                        <th class='center-content'>Location</th>
                                        <th class='center-content'>Location Description</th>
                                        <!-- <th class='center-content'>Status</th> -->
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
                            <label for="store" class="form-label">Location</label>
                            <input type="text" class="form-control required" id="location" aria-describedby="location">
                        </div>

                        <div class="mb-3">
                            <label for="code" class="form-label">Location Description</label>
                            <input type="text" class="form-control required" id="location_desc" aria-describedby="location_desc">
                        </div>

                        <div class="mb-3">
                            <label for="code" class="form-label">January</label>
                            <input type="text" class="form-control required" id="jan" aria-describedby="jan">
                        </div>

                        <div class="mb-3">
                            <label for="code" class="form-label">February</label>
                            <input type="text" class="form-control required" id="feb" aria-describedby="feb">
                        </div>
                        
                        <div class="mb-3">
                            <label for="code" class="form-label">March</label>
                            <input type="text" class="form-control required" id="mar" aria-describedby="mar">
                        </div>

                        <div class="mb-3">
                            <label for="code" class="form-label">April</label>
                            <input type="text" class="form-control required" id="apr" aria-describedby="apr">
                        </div>

                        <div class="mb-3">
                            <label for="code" class="form-label">May</label>
                            <input type="text" class="form-control required" id="may" aria-describedby="may">
                        </div>

                        <div class="mb-3">
                            <label for="code" class="form-label">June</label>
                            <input type="text" class="form-control required" id="jun" aria-describedby="jun">
                        </div>

                        <div class="mb-3">
                            <label for="code" class="form-label">July</label>
                            <input type="text" class="form-control required" id="jul" aria-describedby="jul">
                        </div>


                        <div class="mb-3">
                            <label for="code" class="form-label">August</label>
                            <input type="text" class="form-control required" id="aug" aria-describedby="aug">
                        </div>

                        <div class="mb-3">
                            <label for="code" class="form-label">September</label>
                            <input type="text" class="form-control required" id="sep" aria-describedby="sep">
                        </div>

                        <div class="mb-3">
                            <label for="code" class="form-label">October</label>
                            <input type="text" class="form-control required" id="oct" aria-describedby="oct">
                        </div>

                        <div class="mb-3">
                            <label for="code" class="form-label">November</label>
                            <input type="text" class="form-control required" id="nov" aria-describedby="nov">
                        </div>

                        <div class="mb-3">
                            <label for="code" class="form-label">December</label>
                            <input type="text" class="form-control required" id="dec" aria-describedby="dec">
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

                            <div class="import_buttons">
                                <label for="file" class="custom-file-upload save" style="margin-left:10px; margin-top: 10px; align-items: center;">
                                    <i class="fa fa-file-import" style="margin-right: 5px;"></i>Custom Upload
                                </label>
                                <input
                                    type="file"
                                    style="display: none;"
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
                                        <th class='center-content'>Line #</th>
                                        <th class='center-content'>Location</th>
                                        <th class='center-content'>Location Description</th>
                                        <th class='center-content'>January</th>
                                        <th class='center-content'>February</th>
                                        <th class='center-content'>March</th>
                                        <th class='center-content'>April</th>
                                        <th class='center-content'>May</th>
                                        <th class='center-content'>June</th>
                                        <th class='center-content'>July</th>
                                        <th class='center-content'>August</th>
                                        <th class='center-content'>September</th>
                                        <th class='center-content'>October</th>
                                        <th class='center-content'>November</th>
                                        <th class='center-content'>December</th>
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
        var query = "status >= 0";
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
            event : "list",
            select : "id, location, location_description, january, february, march, april, may, june, july, august, september, october, november, december, status, created_date, updated_date",
            query : new_query,
            offset : offset,
            limit : limit,
            table : "tbl_target_sales_per_store",
            order : {
                field : "id, updated_date",
                order : "asc, desc" 
            }

        }

        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            var html = '';

            if(result) {
                if (result.length > 0) {
                    $.each(result, function(x,y) {
                        console.log(y);
                        var status = ( parseInt(y.status) === 1 ) ? status = "Active" : status = "Inactive";
                        var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";

                        html += "<tr class='" + rowClass + "'>";
                        html += "<td class='center-content' style='width: 5%'><input class='select' type=checkbox data-id="+y.id+" onchange=checkbox_check()></td>";
                        html += "<td scope=\"col\">" + trimText(y.location) + "</td>";
                        html += "<td scope=\"col\">" + trimText(y.location_description, 10) + "</td>";
                        // html += "<td scope=\"col\">" + (y.january) + "</td>";
                        // html += "<td scope=\"col\">" + (y.february) + "</td>";
                        // html += "<td scope=\"col\">" + (y.march) + "</td>";
                        // html += "<td scope=\"col\">" + (y.april) + "</td>";
                        // html += "<td scope=\"col\">" + (y.may) + "</td>";
                        // html += "<td scope=\"col\">" + (y.june) + "</td>";
                        // html += "<td scope=\"col\">" + (y.july) + "</td>";
                        // html += "<td scope=\"col\">" + (y.august) + "</td>";
                        // html += "<td scope=\"col\">" + (y.september) + "</td>";
                        // html += "<td scope=\"col\">" + (y.october) + "</td>";
                        // html += "<td scope=\"col\">" + (y.november) + "</td>";
                        // html += "<td scope=\"col\">" + (y.december) + "</td>";
                        // html += "<td scope=\"col\">" + status + "</td>";
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

    function get_pagination() {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
          event : "pagination",
            select : "id",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_target_sales_per_store",
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
            var new_query = "(" + query + " AND location LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND location_description LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND january LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND february LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND march LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND april LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND may LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND june LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND july LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND august LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND september LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND october LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND november LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND december LIKE '%" + keyword + "%')";
            get_data(new_query);
            get_pagination();
            console.log('Pressed key: ' + keyword);
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
        open_modal('Add New Target Sales per Store', 'add', '');
    });

    function edit_data(id) {
        open_modal('Edit Target Sales per Store', 'edit', id);
    }

    function view_data(id) {
        open_modal('View Target Sales per Store', 'view', id);
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
        set_field_state('#location, #location_desc, #jan, #feb, #mar, #apr, #may, #jun, #jul, #aug, #sep, #oct, #nov, #dec', isReadOnly);

        $footer.empty();
        if (actions === 'add') $footer.append(buttons.save);
        if (actions === 'edit') $footer.append(buttons.edit);
        $footer.append(buttons.close);

        $modal.modal('show');
    }

    function reset_modal_fields() {
        $('#popup_modal #location, #popup_modal #location_desc, #popup_modal #jan, #popup_modal #feb, #popup_modal #mar, #popup_modal #apr, #popup_modal #may, #popup_modal #jun, #popup_modal #jul, #popup_modal #aug, #popup_modal #sep, #popup_modal #oct, #popup_modal #nov, #popup_modal #dec').val('');
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
        title = addNbsp('IMPORT TARGET SALES PER STORE')
        $("#import_modal").find('.modal-title').find('b').html(title)
        $('#import_modal').modal('show');
    });

    function populate_modal(inp_id) {
        var query = "status >= 0 and id = " + inp_id;
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, location, location_description, january, february, march, april, may, june, july, august, september, october, november, december",
            query : query, 
            table : "tbl_target_sales_per_store"
        }
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(index,d) {
                    $('#location').val(d.location);
                    $('#location_desc').val(d.location_description);
                    $('#jan').val(d.january);
                    $('#feb').val(d.february);
                    $('#mar').val(d.march);
                    $('#apr').val(d.april);
                    $('#may').val(d.may);
                    $('#jun').val(d.june);
                    $('#jul').val(d.july);
                    $('#aug').val(d.august);
                    $('#sep').val(d.september);
                    $('#oct').val(d.october);
                    $('#nov').val(d.november);
                    $('#dec').val(d.december);
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

    function save_to_db(inp_location, inp_location_description, inp_january, inp_february, inp_march, inp_april, inp_may, inpt_june, inp_july, inp_august, inp_september, inp_october, inp_november, inp_december, id) {
        const url = "<?= base_url('cms/global_controller'); ?>";
        let data = {}; 
        let modal_alert_success;

        if (id !== undefined && id !== null && id !== '') {
            modal_alert_success = success_update_message;
            data = {
                event: "update",
                table: "tbl_target_sales_per_store",
                field: "id",
                where: id,
                data: {
                    location: inp_location,
                    location_description: inp_location_description,
                    january: inp_january,
                    february: inp_february,
                    march: inp_march,
                    april: inp_april,
                    may: inp_may, 
                    june: inpt_june,
                    july: inp_july,
                    august: inp_august,
                    september: inp_september,
                    october: inp_october,
                    november: inp_november,
                    december: inp_december,
                    updated_date: formatDate(new Date()),
                    updated_by: user_id,
                }
            };
        } else {
            modal_alert_success = success_save_message;
            data = {
                event: "insert",
                table: "tbl_target_sales_per_store",
                data: {
                    location: inp_location,
                    location_description: inp_location_description,
                    january: inp_january,
                    february: inp_february,
                    march: inp_march,
                    april: inp_april,
                    may: inp_may, 
                    june: inpt_june,
                    july: inp_july,
                    august: inp_august,
                    september: inp_september,
                    october: inp_october,
                    november: inp_november,
                    december: inp_december,
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
        var location = $('#location').val();
        var location_description = $('#location_description').val();
        var january = $('#jan').val();
        var february = $('#feb').val();
        var march = $('#mar').val();
        var april = $('#apr').val();
        var may = $('#may').val();
        var june = $('#jun').val();
        var july = $('#jul').val();
        var august = $('#aug').val();
        var september = $('#sep').val();
        var october = $('#oct').val();
        var november = $('#nov').val();
        var december = $('#dec').val();

        if(validate.standard("form-modal")){
            if (id !== undefined && id !== null && id !== '') {
                // check_current_db("tbl_vmi", ["store", "store_name", "item", "item_name", "item_class", "supplier", "group", "dept", "class", "sub_class", "on_hand", "in_transit", "total_qty", "average_sales_unit", "swc", "a202445"],
                // [store, store_name, item, item_name, item_class, supplier, group, dept, classs, sub_class, on_hand, in_transit, total_qty, avg_sales_unit, swc, a202445], "status" , "id", id, true, function(exists, duplicateFields) {
                    // if (exists) {
                        modal.confirm(confirm_update_message, function(result){
                            if(result){ 
                                    modal.loading(true);
                                save_to_db(location, location_description, january, february, march, april, may, june, july, august, september, october, november, december, id)
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
                    table : "tbl_target_sales_per_store",
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
                        table: "tbl_target_sales_per_store",
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

            //console.log('Total records to process:', jsonData.length);
            // Process in chunks
            processInChunks(jsonData, 5000, () => {
                paginateData(rowsPerPage);
            });
        };
        reader.readAsArrayBuffer(file);
    }

    function process_xl_file() {
        if (dataset.length === 0) {
            modal.alert('No data to process. Please upload a file.', 'error', () => {});
            return;
        }

        let jsonData = dataset.map(row => {
            return {
                "Location": row["Location"] || "",
                "Location Description": row["Location Description"] || "",
                "January": row["January"] || "",
                "February": row["February"] || "",
                "March": row["March"] || "",
                "April": row["April"] || "",
                "May": row["May"] || "",
                "June": row["June"] || "",
                "July": row["July"] || "",
                "August": row["August"] || "",
                "September": row["September"] || "",
                "October": row["October"] || "",
                "November": row["November"] || "",
                "December": row["December"] || "",
                "Created by": user_id || "", 
                "Created Date": formatDate(new Date()) || ""
            };
        });

        // var table = 'tbl_vmi';
        // var haystack = ['store', 'store_name', 'item', 'item_name', 'item_class', 'supplier', 'group', 'dept', 'class', 'sub_class', 'on_hand', 'in_transit', 'total_qty', 'average_sales_unit', 'swc', 'a202445'];
        // var selected_fields = ['id', 'store', 'store_name', 'item', 'item_name', 'item_class', 'supplier', 'group', 'dept', 'class', 'sub_class', 'on_hand', 'in_transit', 'total_qty', 'average_sales_unit', 'swc', 'a202445'];
        // var needle = []

        console.log("jsonData before processing:", jsonData);

        // jsonData.forEach(item => {
        //     console.log("Processing item:", item);

        //     if (item.store && item.Store_Name && item.Item && item.Item_Name && item.Item_Class && item.Supplier && item.Group && item.Dept && item.Class && item.Sub_class && item.on_hand && item.in_transit && item.total_qty && item.Ave_Sales_Unit && item.SWC && item.a202446) { // Ensure Code and Name are not empty
        //         needle.push([item.store, item.Store_Name, item.Item, item.Item_Name, item.Item_Class, item.Supplier, item.Group, item.Dept, item.Class, item.Sub_class, item.on_hand, item.in_transit, item.total_qty, item.Ave_Sales_Unit, item.SWC, item.a202446  ]);
        //     }
        // });

        // console.log("Final needle array:", needle);

        modal.loading_progress(true, "Validating and Saving data...");
        let worker = new Worker(base_url + "assets/cms/js/validator_target_sales_ps.js");
        worker.postMessage(jsonData);

        worker.onmessage = function(e) {
            console.log("Received from worker:", e.data);
            modal.loading_progress(false);

            let { invalid, errorLogs, valid_data, err_counter } = e.data;
            if (invalid) {
                console.log("Error logs from worker:", errorLogs);
                if (err_counter > 5000) {
                    
                    modal.content(
                        'Validation Error',
                        'error',
                        '⚠️ Too many errors detected. Please download the error log for details.',
                        '600px',
                        () => {}
                    );
                } else {
                    modal.content(
                        'Validation Error',
                        'error',
                        errorLogs.join("<br>"),
                        '600px',
                        () => {}
                    );
                }
                createErrorLogFile(errorLogs);
            } else if (valid_data && valid_data.length > 0) {
                updateSwalProgress("Validation Completed", 50);
                setTimeout(() => saveValidatedData(valid_data), 500);
                // validate contents of excel first before making a query to the database
                // list_existing(table, selected_fields, haystack, needle, function (result) {
                //     // if all codes and descriptions are unique start saving data
                //     if (result.status != "error") {
                //         // delay to let UI catch up with jquery updates
                //         updateSwalProgress("Validation Completed", 50);
                //         setTimeout(() => saveValidatedData(valid_data), 500);
                //     } 
                //     // if one of the codes and description already exists in the database
                //     else {
                //         var split_result = []
                //         // stop loading ui
                //         modal.loading_progress(false)
                //         // split and store into array
                //         split_result = result.message.split("<br>")
                //         $.each(split_result, (x, y) => {
                //             // for each message remove <b> tags
                //             cleaned_message = y.replace("<b>", "").replace("</b>", "").replace("<b>", "").replace("</b>", "")
                //             // add to error logs
                //             errorLogs.push(cleaned_message)
                //         })
                //         // pass error logs to create text file of error logs
                //         createErrorLogFile(errorLogs, "Error "+formatReadableDate(new Date(), true));
                //         // call popup to alert users with error messages
                //         modal.content(
                //             'Validation Error',
                //             'error',
                //             errorLogs.join("<br>"),
                //             '600px',
                //             () => {}
                //         );
                //     }
                // })
            } else {
                modal.loading_progress(false);
                console.error("No valid data returned from worker.");
                modal.alert("No valid data returned. Please check the file and try again.", "error", () => {});
            }
        };

        worker.onerror = function() {
            modal.loading_progress(false);
            modal.alert("Error processing data. Please try again.", "error", () => {});
        };
    }

    function processInChunks(data, chunkSize, callback) {
        let index = 0;
        let totalRecords = data.length;
        let totalProcessed = 0;

        function nextChunk() {
            if (index >= data.length) {
                modal.loading_progress(false);
                console.log('Total records processed:', totalProcessed);
                callback(); 
                return;
            }

            let chunk = data.slice(index, index + chunkSize);
            dataset = dataset.concat(chunk);
            totalProcessed += chunk.length; 
            index += chunkSize;


            // Calculate progress percentage
            let progress = Math.min(100, Math.round((totalProcessed / totalRecords) * 100));
            setTimeout(() => {
                updateSwalProgress("Preview Data", progress);
                nextChunk();
            }, 100); // Delay for UI update
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

            let td_validator = ['location', 'location description', 'january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];
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
        let retry_count = 0;
        let max_retries = 5; 

        function processNextBatch() {
            if (batch_index >= total_batches) {
                modal.alert(success_save_message, 'success', () => location.reload());
                return;
            }

            let batch = valid_data.slice(batch_index * batch_size, (batch_index + 1) * batch_size);
            let progress = Math.round(((batch_index + 1) / total_batches) * 100);
            setTimeout(() => {
                updateSwalProgress(`Processing batch ${batch_index + 1}/${total_batches}`, progress);
            }, 100);
            batch_insert(batch, function() {
                batch_index++;
                processNextBatch();
            });
        }

        function handleSaveError(batch) {
            if (retry_count < max_retries) {
                retry_count++;
                let wait_time = Math.pow(2, retry_count) * 1000;
                //console.log(`Error saving batch ${batch_index + 1}. Retrying in ${wait_time / 1000} seconds...`);
                setTimeout(() => {
                    //console.log(`Retrying batch ${batch_index + 1}, attempt ${retry_count}...`);
                    batch_insert(batch, function(success) {
                        if (success) {
                            batch_index++;
                            retry_count = 0;
                            processNextBatch();
                        } else {
                            handleSaveError(batch);
                        }
                    });
                }, wait_time);
            } else {
                modal.alert('Failed to save data after multiple attempts. Please check your connection and try again.', 'error', () => {});
            }
        }

        modal.loading_progress(true, "Validating and Saving data...");
        setTimeout(processNextBatch, 1000);
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
            <button onclick="firstPage()" ${currentPage === 1 ? "disabled" : ""}>First</button>
            <button onclick="prevPage()" ${currentPage === 1 ? "disabled" : ""}>Previous</button>
            
            <select onchange="goToPage(this.value)">
                ${Array.from({ length: totalPages }, (_, i) => 
                    `<option value="${i + 1}" ${i + 1 === currentPage ? "selected" : ""}>Page ${i + 1}</option>`
                ).join('')}
            </select>
            
            <button onclick="nextPage()" ${currentPage === totalPages ? "disabled" : ""}>Next</button>
            <button onclick="lastPage()" ${currentPage === totalPages ? "disabled" : ""}>Last</button>
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


    function batch_insert(insert_batch_data, cb) {
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event: "batch_insert",
            table: "tbl_target_sales_per_store",
            insert_batch_data: insert_batch_data
        };

        let retry_count = 0;
        let max_retries = 5; // Maximum retry attempts

        // Function to make the AJAX request and handle retries
        function attemptInsert() {
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function(result) {
                    if (result.message === "success") {
                        cb(true); // Success callback
                    } else {
                        handleSaveError(result); // Handle error if message is not success
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Save failed:", status, error);
                    handleSaveError({ message: 'fail' }); // Handle AJAX failure
                }
            });
        }

        // Handle the error and retry the request
        function handleSaveError(result) {
            if (retry_count < max_retries) {
                retry_count++;
                let wait_time = Math.pow(2, retry_count) * 1000; // Exponential backoff
                console.log(`Error saving batch. Retrying in ${wait_time / 1000} seconds...`);

                setTimeout(() => {
                    console.log(`Retrying attempt ${retry_count}...`);
                    attemptInsert(); // Retry the insertion
                }, wait_time);
            } else {
                console.error("Failed to save data after multiple attempts.");
                cb(false); // Call callback with failure if retries exceed max attempts
            }
        }

        // Initiate the first attempt to insert
        attemptInsert();
    }
    
</script>