<style>
    th, td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<div class="content-wrapper p-4">
    <div class="card">
        <?php
            echo view("cms/layout/buttons",$buttons);
            $optionSet = '';
            foreach($pageOption as $pageOptionLoop) {
                $optionSet .= "<option value='".$pageOptionLoop."'>".$pageOptionLoop."</option>";
            }
        ?>
        <div class="text-center page-title md-center">
            <b id="sell_out_title"></b>
        </div>
        <div class="card-body text-center">
            <div class="d-flex flex-column text-left" style="margin-top: 20px;">
                <div class="d-flex flex-row">
                    <label for="year" class="form-label p-2 col-2">Year</label>
                    <input type="text" class="form-control p-2 col-3" id="year" readonly disabled>
                    <div hidden class="p-2 col-1"></div>
                    <label hidden for="s2" class="form-label p-2 col-3">Stuff 2</label>
                    <input hidden type="text" class="form-control p-2 col-3" id="s2" readonly disabled>
                </div>
            </div>
            <div class="box">
                <table class="table table-bordered listdata">
                    <thead>
                        <tr>
                            <!-- <th class='center-content'><input class="selectall" type="checkbox"></th> -->
                            <th class='center-content'>BA Name</th>
                            <th class='center-content'>Location</th>
                            <th class='center-content'>Location Description</th>
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
                    <div class="d-flex flex-column text-left" style="font-size: 14px;">
                        <div class="d-flex flex-row">
                            <div hidden>
                                <input type="text" class="form-control" id="id" aria-describedby="id">
                            </div>
                            <label for="ba_name" class="form-label p-2 col-2">BA Name</label>
                            <input type="text" class="form-control required p-2 col" id="ba_name" aria-describedby="ba_name">
                            <label for="location" class="form-label p-2 col-2">Location</label>
                            <input type="text" class="form-control required p-2 col" id="location" aria-describedby="location">
                            <label for="location_desc" class="form-label p-2 col-2">Location Description</label>
                            <input type="text" class="form-control required p-2 col" id="location_desc" aria-describedby="location_desc">
                        </div>

                        <div class="mb-3 mt-3 text-center">
                            <label for="code" class="form-label">Target per Month</label>
                        </div>

                        <div class="d-flex flex-row" style="margin-left:20px; margin-right: 20px;">
                            <label for="jan" class="form-label p-2 col-2">January</label>
                            <input type="text" class="form-control required p-2 col-2" id="jan" aria-describedby="jan">
                            <label for="feb" class="form-label p-2 col-2">February</label>
                            <input type="text" class="form-control required p-2 col-2" id="feb" aria-describedby="feb">
                            <label for="mar" class="form-label p-2 col-2">March</label>
                            <input type="text" class="form-control required p-2 col-2" id="mar" aria-describedby="mar">
                        </div>

                        <div class="d-flex flex-row" style="margin-left:20px; margin-right: 20px;">
                            <label for="apr" class="form-label p-2 col-2">April</label>
                            <input type="text" class="form-control required p-2 col-2" id="apr" aria-describedby="apr">
                            <label for="may" class="form-label p-2 col-2">May</label>
                            <input type="text" class="form-control required p-2 col-2" id="may" aria-describedby="may">
                            <label for="jun" class="form-label p-2 col-2">June</label>
                            <input type="text" class="form-control required p-2 col-2" id="jun" aria-describedby="jun">
                        </div>
        
                        <div class="d-flex flex-row" style="margin-left:20px; margin-right: 20px;">
                            <label for="jul" class="form-label p-2 col-2">July</label>
                            <input type="text" class="form-control required p-2 col-2" id="jul" aria-describedby="jul">
                            <label for="aug" class="form-label p-2 col-2">August</label>
                            <input type="text" class="form-control required p-2 col-2" id="aug" aria-describedby="aug">
                            <label for="sep" class="form-label p-2 col-2">September</label>
                            <input type="text" class="form-control required p-2 col-2" id="sep" aria-describedby="sep">
                        </div>
        
                        <div class="d-flex flex-row" style="margin-left:20px; margin-right: 20px;">
                            <label for="oct" class="form-label p-2 col-2">October</label>
                            <input type="text" class="form-control required p-2 col-2" id="oct" aria-describedby="oct">
                            <label for="nov" class="form-label p-2 col-2">November</label>
                            <input type="text" class="form-control required p-2 col-2" id="nov" aria-describedby="nov">
                            <label for="dec" class="form-label p-2 col-2">December</label>
                            <input type="text" class="form-control required p-2 col-2" id="dec" aria-describedby="dec">
                        </div>

                        <div class="d-flex flex-row" style="margin-left:20px; margin-right: 20px; margin-top:50px;" >
                            <label for="total" class="form-label p-2 col-2">Total for all months</label>
                            <input type="text" class="form-control required p-2 col-2" id="total" aria-describedby="total">
                        </div>
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
    </div>

<script>
    var params = "<?=$uri->getSegment(4);?>";
    var query = `a.status >= 0 and b.year = ${params}`;
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url("cms/global_controller");?>";

    $(document).ready(function() {
        $("#sell_out_title").html(addNbsp("VIEW TARGET SALES PER STORE"));
        $("#year").val(params)

        get_data(query);
        get_pagination(query);
    })

    function get_data(new_query) {
        var data = {
            event: "list",
            select: "a.id, a.january, a.february, a.march, a.april, a.may, a.june, "+
            "a.july, a.august, a.september, a.october, a.november, a.december, "+
            "s1.code AS location, s1.description AS location_desc, a.updated_date, a.created_date, a.status, ba.name as ba_name",
            // select: "a.created_date, u.name imported_by, b.year, a.updated_date",
            query: new_query,
            offset: offset,
            limit: limit,
            table: "tbl_target_sales_per_store a",
            order : {
                field : "a.id",
                order : "asc" 
            },
            join: [
                {
                    table: "tbl_store s1",
                    query: "s1.id = a.location",
                    type: "left"
                },
                {
                    table: "tbl_year b",
                    query: "a.year = b.id",
                    type: "left"
                },
                {
                    table: "cms_users u",
                    query: "u.id = a.created_by",
                    type: "left"
                },
                {
                    table: "tbl_brand_ambassador ba",
                    query: "ba.code = a.ba_code",
                    type: "left"
                },
            ]
        };

        aJax.post(url, data, function(result) {
            // console.log("Raw result:", result);

            var result = JSON.parse(result);
            var html = '';

            if (result && result.length > 0) {
                var count = 1;
                $.each(result, function(x, y) {
                    console.log(count);
                    count+=1;
                    var status = (parseInt(y.status) === 1) ? "Active" : "Inactive";
                    var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";
                    var storeCode = y.location || 'N/A';
                    var storeDesc = y.location_desc || 'N/A';
                    var BAName = y.ba_name || 'N/A';
                    html += "<tr class='" + rowClass + "'>";
                    // html += "<td class='center-content' style='width: 5%'><input class='select' type='checkbox' data-id='" + y.id + "' onchange='checkbox_check()'></td>";
                    html += "<td scope=\"col\">" + trimText(BAName) + "</td>";
                    html += "<td scope=\"col\">" + trimText(storeCode) + "</td>";
                    html += "<td scope=\"col\">" + trimText(storeDesc) + "</td>";
                    html += "<td scope=\"col\">" + status + "</td>";
                    html += "<td scope=\"col\">" + (y.created_date ? ViewDateformat(y.created_date) : "N/A") + "</td>";
                    html += "<td scope=\"col\">" + (y.updated_date ? ViewDateformat(y.updated_date) : "N/A") + "</td>";

                    if (y.id == 0) {
                        html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                    } else {
                        html+="<td class='center-content'>";
                        
                        // html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.id+
                        // "')\" data-status='"+y.status+"' id='"+y.id+
                        // "' title='Delete Item'><span class='glyphicon glyphicon-pencil'>Delete</span>";
                        
                        html+="<a class='btn-sm btn view' onclick=\"view_data('"+y.id+
                        "')\" data-status='"+y.status+"' id='"+y.id+
                        "' title='Show Details'><span class='glyphicon glyphicon-pencil'>View</span>";

                        html+="</td>";
                    }

                    html += "</tr>";
                });
            } else {
                html = '<tr><td colspan=12 class="center-align-format">' + no_records + '</td></tr>';
            }

            $('.table_body').html(html);
        });
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
        set_field_state('#ba_name, #location, #location_desc, #jan, #feb, #mar, #apr, #may, #jun, #jul, #aug, #sep, #oct, #nov, #dec, #total', isReadOnly);

        $footer.empty();
        if (actions === 'add') $footer.append(buttons.save);
        if (actions === 'edit') $footer.append(buttons.edit);
        $footer.append(buttons.close);

        $modal.modal('show');
    }

    function reset_modal_fields() {
        $('#popup_modal #ba_name, #popup_modal #location, #popup_modal #location_desc, #popup_modal #jan, #popup_modal #feb, #popup_modal #mar, #popup_modal #apr, #popup_modal #may, #popup_modal #jun, #popup_modal #jul, #popup_modal #aug, #popup_modal #sep, #popup_modal #oct, #popup_modal #nov, #popup_modal #dec').val('');
        $('#popup_modal #status').prop('checked', true);
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
        var query = "pr.status >= 0 and pr.id = " + inp_id;
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "pr.id, pr.january, pr.february, pr.march, pr.april, pr.may, pr.june, pr.july, pr.august, pr.september, pr.october, pr.november, pr.december, s1.code as location, s1.description as location_description, ba.name AS ba_code",
            query : query, 
            table : "tbl_target_sales_per_store pr",
            join: [
                {
                    table: "tbl_store s1",
                    query: "s1.id = pr.location AND s1.id = pr.location",
                    type: "left"
                },
                {
                    table: "tbl_brand_ambassador ba",
                    query: "ba.code = pr.ba_code",
                    type: "left"
                },
            ]
        }
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(index,d) {
                    $('#ba_name').val(d.ba_code);
                    $('#location').val(d.location);
                    $('#location_desc').val(d.location_description);
                    $('#jan').val(Math.round(d.january).toLocaleString());
                    $('#feb').val(Math.round(d.february).toLocaleString());
                    $('#mar').val(Math.round(d.march).toLocaleString());
                    $('#apr').val(Math.round(d.april).toLocaleString());
                    $('#may').val(Math.round(d.may).toLocaleString());
                    $('#jun').val(Math.round(d.june).toLocaleString());
                    $('#jul').val(Math.round(d.july).toLocaleString());
                    $('#aug').val(Math.round(d.august).toLocaleString());
                    $('#sep').val(Math.round(d.september).toLocaleString());
                    $('#oct').val(Math.round(d.october).toLocaleString());
                    $('#nov').val(Math.round(d.november).toLocaleString());
                    $('#dec').val(Math.round(d.december).toLocaleString());

                    let months = ['january', 'february', 'march', 'april', 'may', 'june', 
                                'july', 'august', 'september', 'october', 'november', 'december'];

                    let total = 0;

                    months.forEach(month => {
                        let value = Math.round(d[month]) || 0; 
                        total += value; 
                        $('#' + month.substring(0, 3)).val(value.toLocaleString()); 
                    });

                    $('#total').val(total.toLocaleString());
                }); 
            }
        });
    }

    function set_field_state(selector, isReadOnly) {
        $(selector).prop({ readonly: isReadOnly, disabled: isReadOnly });
    }

    function save_data(action, id) {
        var location = $('#location').val();
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
                modal.confirm(confirm_update_message, function(result){
                    if(result){ 
                            modal.loading(true);
                        save_to_db(location, january, february, march, april, may, june, july, august, september, october, november, december, id)
                    }
                });
            }
        }
    }

    function save_to_db(inp_location, inp_january, inp_february, inp_march, inp_april, inp_may, inpt_june, inp_july, inp_august, inp_september, inp_october, inp_november, inp_december, id) {
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

    function get_pagination(new_query) {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "pagination",
            select: "a.id, a.january, a.february, a.march, a.april, a.may, a.june, "+
            "a.july, a.august, a.september, a.october, a.november, a.december, "+
            "s1.code AS location, s1.description AS location_desc, a.updated_date, a.created_date, a.status",
            query: new_query,
            offset: offset,
            limit: limit,
            table: "tbl_target_sales_per_store a",
            join: [
                {
                    table: "tbl_store s1",
                    query: "s1.id = a.location",
                    type: "left"
                },
                {
                    table: "tbl_year b",
                    query: "a.year = b.id",
                    type: "left"
                },
                {
                    table: "cms_users u",
                    query: "u.id = a.created_by",
                    type: "left"
                }
            ],
            order : {
                field : "a.id",
                order : "asc" 
            },
            // group : ""
        };

        aJax.post(url,data,function(result){
            var obj = is_json(result); 
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

    $(document).on("change", ".record-entries", function(e) {
        $(".record-entries option").removeAttr("selected");
        $(".record-entries").val($(this).val());
        $(".record-entries option:selected").attr("selected","selected");
        var record_entries = $(this).prop("selected",true ).val();
        limit = parseInt(record_entries);
        offset = 1;
        modal.loading(true); 
        get_data(query);
        modal.loading(false);
    });
</script>