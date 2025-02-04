
    <div class="content-wrapper p-4">
        <div class="card">
            <div class="text-center page-title md-center">
                <b>B R A N D - A M B A S S A D O R</b>
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
                                        <th class='center-content'>Name</th>
                                        <th class='center-content'>Deployment Date</th>
                                        <th class='center-content'>Agency</th>
                                        <th class='center-content'>Brand</th>
                                        <th class='center-content'>Store</th>
                                        <th class='center-content'>Team</th>
                                        <th class='center-content'>Area</th>
                                        <th class='center-content'>Status</th>
                                        <th class='center-content'>Type</th>
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


<!-- Modal -->
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
                        <label for="description" class="form-label">Name</label>
                        <input type="text" class="form-control required" id="name" maxlength="50" aria-describedby="description">
                        <small id="description" class="form-text text-muted">* required, must be unique, max 50 characters</small>
                    </div>

                    <div class="form-group">
                        <label>Deployment Data</label>
                        <input type="date" class="form-control" id="deployment_date">
                    </div>

                    <div class="form-group">
                        <label>Agency</label>
                        <select name="area" class="form-control required" id="agency">
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Brand</label>
                        <select name="area" class="form-control required" id="brand">
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Store</label>
                        <select name="area" class="form-control required" id="store">
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Team</label>
                        <select name="area" class="form-control required" id="team">
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Area</label>
                        <select name="area" class="form-control required" id="area">
                        </select>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="status" checked>
                        <label class="form-check-label" for="status">Active</label>
                    </div>

                    <div class="form-group mt-3">
                        <label>Type</label>
                        <div class="d-flex gap-2"> 
                            <label class="mr-3">
                                <input type="radio" name="type" value="1"> Outright
                            </label>
                            <label>
                                <input type="radio" name="type" value="0"> Consign
                            </label>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<!-- Add MODAL -->
<!-- <div class="modal fade" id="save_ba_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Code</label>
                    <input type="text" class="form-control" id="code">
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="name">
                </div>
                <div class="form-group">
                    <label>Deployment Data</label>
                    <input type="date" class="form-control" id="deployment_data">
                </div>
                <div class="form-group">
                    <label>Agency</label>
                    <select class="form-control" id="agency">
                        <option value="">Select Agency</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Brand</label>
                    <input type="text" class="form-control" id="brand">
                </div>
                <div class="form-group">
                    <label>Store</label>
                    <input type="text" class="form-control" id="store">
                </div>
                <div class="form-group">
                    <label>Team</label>
                    <input type="text" class="form-control" id="team">
                </div>
                <div class="form-group">
                    <label>Area</label>
                    <input type="text" class="form-control" id="area">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input large-checkbox" id="status">
                    <label class="form-check-label large-label" for="status">Active</label>
                </div>
                <div class="form-group mt-3">
                    <label>Type</label>
                    <div class="d-flex gap-2"> 
                        <label class="mr-3">
                            <input type="radio" name="type" value="1"> Outright
                        </label>
                        <label>
                            <input type="radio" name="type" value="0"> Consign
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveBtn">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> -->

<!-- Update MODAL -->
<!-- <div class="modal fade" id="update_ba_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> 
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Code</label>
                    <input type="text" class="form-control" id="code">
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="name">
                </div>
                <div class="form-group">
                    <label>Deployment Data</label>
                    <input type="date" class="form-control" id="deployment_data">
                </div>
                <div class="form-group">
                    <label>Agency</label>
                    <input type="text" class="form-control" id="agency">
                </div>
                <div class="form-group">
                    <label>Brand</label>
                    <input type="text" class="form-control" id="brand">
                </div>
                <div class="form-group">
                    <label>Store</label>
                    <input type="text" class="form-control" id="store">
                </div>
                <div class="form-group">
                    <label>Team</label>
                    <input type="text" class="form-control" id="team">
                </div>
                <div class="form-group">
                    <label>Area</label>
                    <input type="text" class="form-control" id="area">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input large-checkbox" id="status">
                    <label class="form-check-label large-label" for="status">Active</label>
                </div>
                <div class="form-group mt-3">
                    <label>Type</label>
                    <div class="d-flex gap-2">
                        <label class="mr-3"> 
                            <input type="radio" name="type" value="1"> Outright
                        </label>
                        <label>
                            <input type="radio" name="type" value="0"> Consign
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="updateBtn">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> -->

<!-- View MODAL -->
<!-- <div class="modal fade" id="view_ba_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Code</label>
                    <input type="text" class="form-control" id="code" readonly>
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="name" readonly>
                </div>
                <div class="form-group">
                    <label>Deployment Data</label>
                    <input type="date" class="form-control" id="deployment_data" readonly>
                </div>
                <div class="form-group">
                    <label>Agency</label>
                    <input type="text" class="form-control" id="agency" readonly>
                </div>
                <div class="form-group">
                    <label>Brand</label>
                    <input type="text" class="form-control" id="brand" readonly>
                </div>
                <div class="form-group">
                    <label>Store</label>
                    <input type="text" class="form-control" id="store" readonly>
                </div>
                <div class="form-group">
                    <label>Team</label>
                    <input type="text" class="form-control" id="team" readonly>
                </div>
                <div class="form-group">
                    <label>Area</label>
                    <input type="text" class="form-control" id="area" readonly>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input large-checkbox" id="status" disabled>
                    <label class="form-check-label large-label" for="status">Active</label>
                </div>
                <div class="form-group mt-3">
                    <label>Type</label>
                    <div class="d-flex gap-2"> 
                        <label class="mr-3"> 
                            <input type="radio" name="type" value="1" disabled> Outright
                        </label>
                        <label>
                            <input type="radio" name="type" value="0" disabled> Consign
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> -->

<script>
    var query = "status >= 0";
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';

    // $(document).ready(function() {
    //   get_data();
    //   get_pagination();
    // });
    $(document).ready(function() {
        get_area();
        get_agency();
        get_store();
        get_team();
        get_brand();
        
        get_data();
        get_pagination();

    });

    function get_data(keyword = null) {
      var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "list",
            select : "id, code, name, deployment_date, agency, brand, store, team, area, status, type, updated_date",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_brand_ambassador",
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
                        let date = new Date(y.deployment_date);
                        let formattedDate = date.toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                        var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";

                        var areaDescription = areaDescriptions[y.area] || 'N/A';
                        var agencyDescription = agencyDescriptions[y.agency] || 'N/A';
                        var storeDescription = storeDescriptions[y.store] || 'N/A';
                        var teamDescription = teamDescriptions[y.team] || 'N/A';
                        var brandDescription = brandDescriptions[y.brand] || 'N/A';

                        html += "<tr class='" + rowClass + "'>";
                        html += "<td class='center-content'><input class='select' type=checkbox data-id="+y.id+" onchange=checkbox_check()></td>";
                        html += "<td>" + y.code + "</td>";
                        html += "<td>" + y.name + "</td>";
                        html += "<td>" + formattedDate + "</td>";
                        // html += "<td>" + y.agency + "</td>";
                        html += "<td>" + agencyDescription + "</td>";
                        // html += "<td>" + y.brand + "</td>";
                        html += "<td>" + brandDescription + "</td>";
                        // html += "<td>" + y.store + "</td>";
                        html += "<td>" + storeDescription + "</td>";
                        // html += "<td>" + y.team + "</td>";
                        html += "<td>" + teamDescription + "</td>";
                        // html += "<td>" + y.area + "</td>";
                        html += "<td>" + areaDescription + "</td>";
                        html += "<td>" +status+ "</td>";
                        html += "<td>" + (y.type == 1 ? "Outright" : "Consign") + "</td>";
                        html += "<td class='center-content'>" + (y.updated_date ? y.updated_date : "N/A") + "</td>";
                        
                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                            html+="<td class='center-content' style='width: 25%'>";
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

    // get_area();
    // get_agency();
    // get_store();
    // get_team();
    // get_brand();
    

    function get_pagination() {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
          event : "pagination",
            select : "id",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_brand_ambassador",
            order : {
                field : "updated_date", //field to order
                order : "desc" //asc or desc
            }

        }

        aJax.post(url,data,function(result){
            var obj = is_json(result); //check if result is valid JSON format, Format to JSON if not
            // console.log(obj);
            modal.loading(false);
            pagination.generate(obj.total_page, ".list_pagination", get_data);
        });
    }

    pagination.onchange(function(){
        offset = $(this).val();
        get_data();
        $('.selectall').prop('checked', false);
        $('.btn_status').hide();
        $("#search_query").val("");
    })

    $(document).on('keypress', '#search_query', function(e) {               
        if (e.keyCode === 13) {
            var keyword = $(this).val().trim();
            offset = 1;
            query = "( code like '%" + keyword + "%' ) OR team_description like '%" + keyword + "%' AND status >= 1";
            get_data();
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
        get_data();
        modal.loading(false);
    });

    $('#btn_add').on('click', function() {
        open_modal('Add New Brand Ambassador', 'add', '');
        get_area('');
        get_agency('');
        get_store('');
        get_team('');
        get_brand('');
    });

    function edit_data(id) {
        open_modal('Edit Brand Ambassador', 'edit', id);
    }

    function view_data(id) {
        open_modal('View Brand Ambassador', 'view', id);
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
        set_field_state('#code, #name, #deployment_date, #agency, #brand, #store, #team, #area, #status', isReadOnly);
        $('input[name="type"]').prop('disabled', isReadOnly);

        $footer.empty();
        if (actions === 'add') $footer.append(buttons.save);
        if (actions === 'edit') $footer.append(buttons.edit);
        $footer.append(buttons.close);

        $modal.modal('show');
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

    function populate_modal(inp_id) {
        var query = "status >= 0 and id = " + inp_id;
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, code, name, deployment_date, agency, brand, store, team, area, status, type",
            query : query, 
            table : "tbl_brand_ambassador"
        }
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(index,ba) {
                    $('#id').val(ba.id);
                    $('#code').val(ba.code);
                    $('#name').val(ba.name);
                    $('#deployment_date').val(ba.deployment_date);
                    $('#agency').val(ba.agency);
                    get_agency(ba.agency);
                    $('#brand').val(ba.brand);
                    get_brand(ba.brand);
                    $('#store').val(ba.store);
                    get_store(ba.store);
                    $('#team').val(ba.team);
                    get_team(ba.team);
                    $('#area').val(ba.area);
                    get_area(ba.area);
                    $('input[name="type"]').each(function() {
                        if ($(this).val() == ba.type) {
                            $(this).prop('checked', true); 
                        }
                    });
                    if(ba.status == 1) {
                        $('#status').prop('checked', true)
                    } else {
                        $('#status').prop('checked', false)
                    }
                }); 
            }
        });
    }

    function reset_modal_fields() {
        $('#popup_modal #code, #popup_modal #name, #popup_modal #deployment_date, #popup_modal #agency, #popup_modal #brand, #popup_modal #store, #popup_modal #team, #popup_modal #area, #popup_modal').val('');
        $('#popup_modal #status').prop('checked', true);
        $('input[name="type"]').prop('checked', false);
    }

    function save_data(action, id) {
        var code = $('#code').val();
        var name = $('#name').val();
        var deployment_date = $('#deployment_date').val();
        var agency = $('#agency').val();
        var brand = $('#brand').val();
        var store = $('#store').val();
        var team = $('#team').val();
        var area = $('#area').val();
        var type = $('input[name="type"]:checked').val() || ''; 
        var chk_status = $('#status').prop('checked');
        if (chk_status) {
            status_val = 1;
        } else {
            status_val = 0;
        }
        if (id !== undefined && id !== null && id !== '') {
            check_current_db("tbl_brand_ambassador", ["code", "name"], [code, name], "status" , "id", id, true, function(exists, duplicateFields) {
                if (!exists) {
                    modal.confirm(confirm_update_message, function(result){
                        if(result){ 
                                modal.loading(true);
                            save_to_db(code, name, deployment_date, agency, brand, store, team, area, type, status_val, id)
                        }
                    });

                }             
            });
        }else{
            check_current_db("tbl_brand_ambassador", ["code", "name"], [code, name], "status" , null, null, true, function(exists, duplicateFields) {
                if (!exists) {
                    modal.confirm(confirm_add_message, function(result){
                        if(result){ 
                                modal.loading(true);
                            save_to_db(code, name, deployment_date, agency, brand, store, team, area, type, status_val, null)
                        }
                    });

                }                  
            });
        }
    }

    function save_to_db(inp_code, inp_name, inp_deployment_date, inp_agency, inp_brand, inp_store, inp_team, inp_area, int_type, status_val, id) {
        const url = "<?= base_url('cms/global_controller'); ?>";
        let data = {}; 
        let modal_alert_success;

        if (id !== undefined && id !== null && id !== '') {
            modal_alert_success = success_update_message;
            data = {
                event: "update",
                table: "tbl_brand_ambassador",
                field: "id",
                where: id,
                data: {
                    code: inp_code,
                    name: inp_name,
                    deployment_date: inp_deployment_date,
                    agency: inp_agency,
                    brand: inp_brand,
                    store: inp_store,
                    team: inp_team,
                    area: inp_area,
                    updated_date: formatDate(new Date()),
                    updated_by: user_id,
                    type: int_type,
                    status: status_val,
                }
            };
        } else {
            modal_alert_success = success_save_message;
            data = {
                event: "insert",
                table: "tbl_brand_ambassador",
                data: {
                    code: inp_code,
                    name: inp_name,
                    deployment_date: inp_deployment_date,
                    agency: inp_agency,
                    brand: inp_brand,
                    store: inp_store,
                    team: inp_team,
                    area: inp_area,
                    created_date: formatDate(new Date()),
                    created_by: user_id,
                    type: int_type,
                    status: status_val,
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

    function addNbsp(inputString) {
        return inputString.split('').map(char => {
            if (char === ' ') {
            return '&nbsp;&nbsp;';
            }
            return char + '&nbsp;';
        }).join('');
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

    function delete_data(id) {
        modal.confirm(confirm_delete_message,function(result){
            if(result){ 
                var url = "<?= base_url('cms/global_controller');?>";
                var data = {
                    event : "update",
                    table : "tbl_brand_ambassador",
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

    let areaDescriptions = {}; 
    function get_area(id) {
        var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
        var data = {
            event : "list",
            select : "id, code, description, status",
            query : 'status >= 0',
            offset : 0,
            limit : 0,
            table : "tbl_area",
            order : {
                field : "code",
                order : "asc" 
            }
        }

        aJax.post(url,data,function(res){
            var result = JSON.parse(res);
            var html = '<option id="default_val" value=" ">Select Area</option>';
    
            if(result) {
                if (result.length > 0) {
                    var selected = '';
                    $.each(result, function(x,y) {
                        areaDescriptions[y.id] = y.description;
                        if (id === y.id) {
                            selected = 'selected'

                        } else {
                            selected = ''
                        }
                        html += "<option value='"+y.id+"' "+selected+">"+y.description+"</option>"
                    })
                }
            }
            $('#area').empty();
            $('#area').append(html);

            // let selectedAreaDescription = areaDescriptions[id] || 'N/A';
            // console.log(selectedAreaDescription);

        });
    }

    let agencyDescriptions = {};
    function get_agency(id) {
        var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
        var data = {
            event : "list",
            select : "id, code, agency, status",
            query : 'status >= 0',
            offset : 0,
            limit : 0,
            table : "tbl_agency",
            order : {
                field : "code",
                order : "asc" 
            }
        }

        aJax.post(url,data,function(res){
            var result = JSON.parse(res);
            var html = '<option id="default_val" value=" ">Select Agency</option>';
    
            if(result) {
                if (result.length > 0) {
                    var selected = '';
                    $.each(result, function(x,y) {
                        agencyDescriptions[y.id] = y.agency;
                        if (id === y.id) {
                            selected = 'selected'

                        } else {
                            selected = ''
                        }
                        html += "<option value='"+y.id+"' "+selected+">"+y.agency+"</option>"
                    })
                }
            }
            $('#agency').empty();
            $('#agency').append(html);

            // let selectedAreaDescription = agencyDescriptions[id] || 'N/A';
            // console.log(selectedAreaDescription);
        })
    }

    let storeDescriptions = {};
    function get_store(id) {
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
            $('#store').empty();
            $('#store').append(html);

            // let selectedStoreDescription = storeDescriptions[id] || 'N/A';
            // console.log(selectedStoreDescription);
        })
    }

    let teamDescriptions = {};
    function get_team(id) {
        var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
        var data = {
            event : "list",
            select : "id, code, team_description, status",
            query : 'status >= 0',
            offset : 0,
            limit : 0,
            table : "tbl_team",
            order : {
                field : "code",
                order : "asc" 
            }
        }

        aJax.post(url,data,function(res){
            var result = JSON.parse(res);
            var html = '<option id="default_val" value=" ">Select Team</option>';
    
            if(result) {
                if (result.length > 0) {
                    var selected = '';
                    $.each(result, function(x,y) {
                        teamDescriptions[y.id] = y.team_description;
                        if (id === y.id) {
                            selected = 'selected'

                        } else {
                            selected = ''
                        }
                        html += "<option value='"+y.id+"' "+selected+">"+y.team_description+"</option>"
                    })
                }
            }
            $('#team').empty();
            $('#team').append(html);

            // let selectedStoreDescription = teamDescriptions[id] || 'N/A';
            // console.log(selectedStoreDescription);
        })
    }

    let brandDescriptions = {};
    function get_brand(id) {
        var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
        var data = {
            event : "list",
            select : "id, brand_code, brand_description, status",
            query : 'status >= 0',
            offset : 0,
            limit : 0,
            table : "tbl_brand",
            order : {
                field : "brand_code",
                order : "asc" 
            }
        }

        aJax.post(url,data,function(res){
            var result = JSON.parse(res);
            var html = '<option id="default_val" value=" ">Select Brand</option>';
    
            if(result) {
                if (result.length > 0) {
                    var selected = '';
                    $.each(result, function(x,y) {
                        brandDescriptions[y.id] = y.brand_description;
                        if (id === y.id) {
                            selected = 'selected'

                        } else {
                            selected = ''
                        }
                        html += "<option value='"+y.id+"' "+selected+">"+y.brand_code+"</option>"
                    })
                }
            }
            $('#brand').empty();
            $('#brand').append(html);

            // let selectedStoreDescription = brandDescriptions[id] || 'N/A';
            // console.log(selectedStoreDescription);
        })
    }
    

    // $(document).ready(function () {
    //     $(document).on('click', '#btn_add', function () {
    //         $('#popup_modal').modal('show');
    //     });
    // });

    // $(document).on('click', '#updateBtn', function() {
    //     var id = $(this).attr('data-id');
    //     update_data(id);
    // });

    // $(document).on('click', '.edit', function() {
    //     id = $(this).attr('id');
    //     get_data_by_id(id);
    // });

    // $(document).on('click', '.delete_data', function() {
    //     var id = $(this).attr('id');
    //     delete_data(id); 
    //     // console.log('hello');
    // });

    // $(document).on('click', '.view', function() {
    //     id = $(this).attr('id');
    //     get_data_by_id_view(id);
    // });

    
    // $(document).on('click', '#saveBtn', function() {
       
    //     save_data();
    //     // var status = $('#status').is(':checked') ? 1 : 0;
    //     // console.log($('#code').val());
    //     // console.log($('#name').val());
    //     // console.log($('#deployment_data').val());
    //     // console.log($('#agency').val());
    //     // console.log($('#brand').val());
    //     // console.log($('#store').val());
    //     // console.log($('#team').val());
    //     // console.log($('#area').val());
    //     // console.log(status);
    //     // console.log($('input[name="type"]:checked').val());
    // });

    // function save_data() {
    //     var status = $('#save_ba_modal #status').prop('checked') ? 1 : 0;
    //     modal.confirm("Are you sure you want to save this record?",function(result){
    //         if(result){ 
    //             var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
    //             var data = {
    //                 event : "insert", // list, insert, update, delete
    //                 table : "tbl_brand_ambassador", //table
    //                 data : {
    //                         code : $('#save_ba_modal #code').val(),
    //                         name : $('#save_ba_modal #name').val(),
    //                         deployment_date : $('#save_ba_modal #deployment_date').val(),
    //                         agency : $('#save_ba_modal #agency').val(),
    //                         brand : $('#save_ba_modal #brand').val(),
    //                         store  : $('#save_ba_modal #store').val(),
    //                         team : $('#save_ba_modal #team').val(),
    //                         area : $('#save_ba_modal #area').val(),
    //                         status : $('#save_ba_modal #status').val(),
    //                         type : $('#save_ba_modal #type').val(),
    //                         created_date : formatDate(new Date()),
    //                         //update_date : formatDate(new Date()).format('YYYY-MM-DD HH:mm:ss'),
    //                         //to follow created data and created by
    //                         created_by : user_id,
    //                         status : status
    //                 }  
    //             }

    //             aJax.post(url,data,function(result){
    //                 var obj = is_json(result);
    //                 // alert("pasok");
    //                 location.reload();
    //                 // modal.alert("<strong>Success!</strong> Record has been Saved",function(){ 
    //                 //    location.reload();
    //                 // })
    //             });
    //         }

    //     });
    // }

    // function get_data_by_id(id){
    //     var query = "id = " + id;
    //     var exists = 0;

    //     var url = "<?= base_url('cms/global_controller');?>";
    //     var data = {
    //         event : "list", 
    //         select : "id, code, name, deployment_date, agency, brand, store, team, area, status, type, updated_date",
    //         query : query, 
    //         table : "tbl_brand_ambassador"
    //     }

    //     aJax.post(url,data,function(result){
    //         var obj = is_json(result);
    //         console.log(obj);
    //         if(obj){
    //             $.each(obj, function(x,y) {
    //                 console.log(y);
    //                 $('#update_ba_modal #code').val(y.code);
    //                 $('#update_ba_modal #name').val(y.name);
    //                 $('#update_ba_modal #deployment_date').val(y.deployment_date);
    //                 $('#update_ba_modal #agency').val(y.agency);
    //                 $('#update_ba_modal #brand').val(y.brand);
    //                 $('#update_ba_modal #store').val(y.store);
    //                 $('#update_ba_modal #team').val(y.team);
    //                 $('#update_ba_modal #area').val(y.area);
                    
    //                 if(y.status == 1){
    //                     $('#update_ba_modal #status').prop('checked', true);
    //                 }else{
    //                     $('#update_ba_modal #status').prop('checked', false);
    //                 }

    //                 $('input[name="type"][value="' + y.type + '"]').prop('checked', true);

    //             }); 
    //         }
            
    //         $('#updateBtn').attr('data-id', id);
    //         $('#update_ba_modal').modal('show');
    //     });
    //     return exists;
    // }

    // function update_data(id){
    //     // var status = $('#update_user_modal #status').val();
    //     var status = $('#update_ba_modal #status').prop('checked') ? 1 : 0;
    //     console.log(status);
    //     // if(status == 'on'){
    //     //     status = 1;
    //     // }else{
    //     //     status = 0;
    //     // }
    //     modal.confirm("Are you sure you want to update this record?",function(result){
    //         console.log(result);
    //         if(result){ 
    //             var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
    //             var data = {
    //                 event : "update", // list, insert, update, delete
    //                 table : "tbl_brand_ambassador", //table
    //                 field : "id",
    //                 where : id, 
    //                 data : {
    //                         code : $('#update_ba_modal #code').val(),
    //                         name : $('#update_ba_modal #name').val(),
    //                         deployment_date : $('#update_ba_modal #deployment_date').val(),
    //                         agency : $('#update_ba_modal #agency').val(),
    //                         brand : $('#update_ba_modal #brand').val(),
    //                         store  : $('#update_ba_modal #store').val(),
    //                         team : $('#update_ba_modal #team').val(),
    //                         area : $('#update_ba_modal #area').val(),
    //                         status : $('#update_ba_modal #status').val(),
    //                         type: $('input[name="type"]:checked').val(),
    //                         //created_date : formatDate(new Date()),
    //                         updated_date : formatDate(new Date()),
    //                         //to follow created data and created by
    //                         //created_by : user_id,
    //                         updated_by : user_id,
    //                         status : status
    //                 }  
    //             }

    //             aJax.post(url,data,function(result){
    //                 var obj = is_json(result);
    //                 //alert("pasok");
    //                 location.reload();
    //                 // modal.alert("<strong>Success!</strong> Record has been Saved",function(){ 
    //                 //    location.reload();
    //                 // })
    //             });
    //         }

    //     });
    // }

    // function delete_data(id){
        
    //     modal.confirm("Are you sure you want to delete this record?",function(result){
    //         if(result){ 
    //             var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
    //             var data = {
    //                 event : "update", // list, insert, update, delete
    //                 table : "tbl_brand_ambassador", //table
    //                 field : "id",
    //                 where : id, 
    //                 data : {
    //                         updated_date : formatDate(new Date()),
    //                         updated_by : user_id,
    //                         status : -2
    //                 }  
    //             }

    //             aJax.post(url,data,function(result){
    //                 var obj = is_json(result);
    //                 // alert("pasok");
    //                 location.reload();
    //                 // modal.alert("<strong>Success!</strong> Record has been Saved",function(){ 
    //                 //    location.reload();
    //                 // })
    //             });
    //         }

    //     });
    // }

    // function get_data_by_id_view(id){
    //     var query = "id = " + id;
    //     var exists = 0;

    //     var url = "<?= base_url('cms/global_controller');?>";
    //     var data = {
    //         event : "list", 
    //         select : "id, code, name, deployment_date, agency, brand, store, team, area, status, type, updated_date",
    //         query : query, 
    //         table : "tbl_brand_ambassador"
    //     }

    //     aJax.post(url,data,function(result){
    //         var obj = is_json(result);
    //         console.log(obj);
    //         if(obj){
    //             $.each(obj, function(x,y) {
    //                 console.log(y);
    //                 $('#view_ba_modal #code').val(y.code);
    //                 $('#view_ba_modal #name').val(y.name);
    //                 $('#view_ba_modal #deployment_date').val(y.deployment_date);
    //                 $('#view_ba_modal #agency').val(y.agency);
    //                 $('#view_ba_modal #brand').val(y.brand);
    //                 $('#view_ba_modal #store').val(y.store);
    //                 $('#view_ba_modal #team').val(y.team);
    //                 $('#view_ba_modal #area').val(y.area);
                    
    //                 if(y.status == 1){
    //                     $('#view_ba_modal #status').prop('checked', true);
    //                 }else{
    //                     $('#view_ba_modal #status').prop('checked', false);
    //                 }

    //                 $('input[name="type"][value="' + y.type + '"]').prop('checked', true);

    //             }); 
    //         }
            
    //         $('#updateBtn').attr('data-id', id);
    //         $('#view_ba_modal').modal('show');
    //     });
    //     return exists;
    // }

    
</script>
