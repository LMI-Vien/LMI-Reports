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
                <b>T A R G E T - S A L E S - P E R - S T O R E</b>
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
                                        <th class='center-content'>Imported Date</th>
                                        <th class='center-content'>Imported By</th>
                                        <th class='center-content'>Year</th>
                                        <th class='center-content'>Date Modified</th>
                                        <th class='center-content'>Action</th>
                                        <!-- <th class='center-content'><input class="selectall" type="checkbox"></th>
                                        <th class='center-content'>Location</th>
                                        <th class='center-content'>Location Description</th>
                                        <th class='center-content'>Status</th>
                                        <th class='center-content'>Date Created</th>
                                        <th class='center-content'>Date Modified</th>
                                        <th class='center-content'>Action</th> -->
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
                            <label for="ba_code" class="form-label">BA Code</label>
                            <input type="text" class="form-control required" id="ba_code" aria-describedby="ba_code">
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control required" id="location" aria-describedby="location">
                        </div>

                        <div class="mb-3">
                            <label for="location_desc" class="form-label">Location Description</label>
                            <input type="text" class="form-control required" id="location_desc" aria-describedby="location_desc">
                        </div>

                        <div class="mb-3">
                            <label for="jan" class="form-label">January</label>
                            <input type="text" class="form-control required" id="jan" aria-describedby="jan">
                        </div>

                        <div class="mb-3">
                            <label for="feb" class="form-label">February</label>
                            <input type="text" class="form-control required" id="feb" aria-describedby="feb">
                        </div>
                        
                        <div class="mb-3">
                            <label for="mar" class="form-label">March</label>
                            <input type="text" class="form-control required" id="mar" aria-describedby="mar">
                        </div>

                        <div class="mb-3">
                            <label for="apr" class="form-label">April</label>
                            <input type="text" class="form-control required" id="apr" aria-describedby="apr">
                        </div>

                        <div class="mb-3">
                            <label for="may" class="form-label">May</label>
                            <input type="text" class="form-control required" id="may" aria-describedby="may">
                        </div>

                        <div class="mb-3">
                            <label for="jun" class="form-label">June</label>
                            <input type="text" class="form-control required" id="jun" aria-describedby="jun">
                        </div>

                        <div class="mb-3">
                            <label for="jul" class="form-label">July</label>
                            <input type="text" class="form-control required" id="jul" aria-describedby="jul">
                        </div>


                        <div class="mb-3">
                            <label for="aug" class="form-label">August</label>
                            <input type="text" class="form-control required" id="aug" aria-describedby="aug">
                        </div>

                        <div class="mb-3">
                            <label for="sep" class="form-label">September</label>
                            <input type="text" class="form-control required" id="sep" aria-describedby="sep">
                        </div>

                        <div class="mb-3">
                            <label for="oct" class="form-label">October</label>
                            <input type="text" class="form-control required" id="oct" aria-describedby="oct">
                        </div>

                        <div class="mb-3">
                            <label for="nov" class="form-label">November</label>
                            <input type="text" class="form-control required" id="nov" aria-describedby="nov">
                        </div>

                        <div class="mb-3">
                            <label for="dec" class="form-label">December</label>
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
                        <div class="mb-3">
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

                                <div class="col-md-4">
                                    <div class="card p-4 shadow-lg rounded-3 border-0" style="background: #f8f9fa;">
                                        <div class="row g-3">
                                            <div class="col-12 d-flex align-items-center">
                                                <label for="yearSelect" class="form-label fw-semibold me-2">Choose Year:</label>
                                                <select id="yearSelect" class="form-select uniform-dropdown">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div style="overflow-x: auto; max-height: 400px;">
                                <table class= "table table-bordered listdata">
                                    <thead>
                                        <tr>
                                            <th class='center-content'>Line #</th>
                                            <th class='center-content'>BA Code</th>
                                            <th class='center-content'>Location</th>
                                            <!-- <th class='center-content'>Location Description</th> -->
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

    <div class="modal" tabindex="-1" id="export_modal">
        <div class="modal-dialog modal-lg">
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
                        <div class="mb-3">
                            <div 
                                class="text-center"
                                style="padding: 10px;
                                font-family: 'Courier New', Courier, monospace;
                                font-size: large;
                                background-color: #fdb92a;
                                color: #333333;
                                border: 1px solid #ffffff;
                                border-radius: 10px;"                            
                            >
                                <b>Filters</b>
                            </div>
    
                            <div class="col-12 row d-flex" style="margin-top: 20px;">
                                <label 
                                    for="year_select" 
                                    class="form-label fw-semibold me-"
                                    style="padding-top: 5px;"
                                >
                                    Choose Year:
                                </label>
                                <select id="year_select" class="form-select uniform-dropdown">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="modal-footer">
                    <button type="button" class="btn save" onclick="handleExport()">Export All</button>
                    <button type="button" class="btn save" onclick="exportFilter()">Export Filter</button>
                    <button type="button" class="btn caution" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    
<script>
    var query = "a.status >= 0";
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
        get_pagination(query);
    });

    function get_data(new_query) {
        var data = {
            event: "list",
            // select: "a.id, a.january, a.february, a.march, a.april, a.may, a.june, "+
            // "a.july, a.august, a.september, a.october, a.november, a.december, "+
            // "s1.code AS location, s1.description AS location_desc, a.updated_date, a.created_date, a.status",
            select: "a.created_date, u.name imported_by, b.year, a.updated_date, a.year yearval, b.id as year_id",
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
                }
            ],
            group: "b.year"
        };

        aJax.post(url, data, function(result) {
            // console.log("Raw result:", result);

            var result = JSON.parse(result);
            var html = '';

            if (result && result.length > 0) {
                $.each(result, function(x, y) {
                    var status = (parseInt(y.status) === 1) ? "Active" : "Inactive";
                    var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";

                    html += "<tr class='" + rowClass + "'>";
                    html += "<td scope=\"col\">" + (y.created_date ? ViewDateformat(y.created_date) : "N/A") + "</td>";
                    html += "<td scope=\"col\">" + (y.imported_by) + "</td>";
                    html += "<td scope=\"col\">" + (y.year) + "</td>";
                    html += "<td scope=\"col\">" + (y.updated_date ? ViewDateformat(y.updated_date) : "N/A") + "</td>";

                    let href = "<?= base_url()?>"+"cms/import-target-sales-ps/view/"+`${y.year}`;

                    if (y.id == 0) {
                        html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                    } else {
                        html+="<td class='center-content'>";
                        
                        html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.year_id+
                        "')\" data-status='"+y.status+"' id='"+y.id+
                        "' title='Delete Item'><span class='glyphicon glyphicon-pencil'>Delete</span>";

                        html+="<a class='btn-sm btn view' href='"+ href +"' data-status='"+y.status+
                        "' target='_blank' id='"+y.id+
                        "' title='View'><span class='glyphicon glyphicon-pencil'>View</span>";

                        html+="<a class='btn-sm btn save' onclick=\"export_data('"+y.yearval+
                        "')\" data-status='"+y.status+"' id='"+y.id+
                        "' title='Export Details'><span class='glyphicon glyphicon-pencil'>Export</span>";

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

    function get_pagination(new_query) {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
          event : "pagination",
          select: "a.created_date, u.name imported_by, b.year, a.updated_date",
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
              }
          ],
          group: "b.year"
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
            var new_query = "(" + query + " AND b.year LIKE '%" + keyword + "%')";
            get_data(new_query);
            get_pagination(new_query);
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
        get_year('yearSelect');
    });

    function populate_modal(inp_id) {
        var query = "pr.status >= 0 and pr.id = " + inp_id;
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "pr.id, pr.january, pr.february, pr.march, pr.april, pr.may, pr.june, pr.july, pr.august, pr.september, pr.october, pr.november, pr.december, s1.code as location, s1.description as location_description",
            query : query, 
            table : "tbl_target_sales_per_store pr",
            join: [
                {
                    table: "tbl_store s1",
                    query: "s1.id = pr.location AND s1.id = pr.location",
                    type: "left"
                }
            ]
        }
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(index,d) {
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

    function delete_data(year) {
        modal.confirm(confirm_delete_message,function(result){
            if(result){
                var url = "<?= base_url('cms/global_controller');?>";
                var formattedData = [];
        
                dynamic_search(
                    "'tbl_target_sales_per_store'", 
                    "''", 
                    "'id'", 
                    0, 
                    0, 
                    `'year:EQ=${year}'`,  
                    `''`, 
                    `''`,
                    (res) => {
                        year = [year];
                        console.log(year);
                        batch_delete(url, "tbl_target_sales_per_store", "year", year, 'year', function(resp) {
                            modal.alert("Selected records deleted successfully!", 'success', () => location.reload());
                        });
                    }
                )
            }
        })
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

    // function read_xl_file() {
    //     let btn = $(".btn.save");
    //     btn.prop("disabled", false); 
    //     clear_import_table();
        
    //     dataset = [];

    //     const file = $("#file")[0].files[0];
    //     if (!file) {
    //         modal.loading_progress(false);
    //         modal.alert('Please select a file to upload', 'error', ()=>{});
    //         return;
    //     }
    //     modal.loading_progress(true, "Reviewing Data...");

    //     const reader = new FileReader();
    //     reader.onload = function(e) {
    //         const data = new Uint8Array(e.target.result);
    //         const workbook = XLSX.read(data, { type: "array" });
    //         const sheet = workbook.Sheets[workbook.SheetNames[0]];

    //         const jsonData = XLSX.utils.sheet_to_json(sheet, { raw: false });

    //         processInChunks(jsonData, 5000, () => {
    //             paginateData(rowsPerPage);
    //         });
    //     };
    //     reader.readAsArrayBuffer(file);
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

    function process_xl_file() {
        let btn = $(".btn.save");
        if (btn.prop("disabled")) return; // Prevent multiple clicks

        btn.prop("disabled", true);
        $(".import_buttons").find("a.download-error-log").remove();
        setTimeout(() => {
            btn.prop("disabled", false);
        }, 4000);
        const year = $('#yearSelect').val()?.trim();

        const fields = { year };

        for (const [key, value] of Object.entries(fields)) {
            if (!value) {
                return modal.alert(`Please select a ${key.charAt(0).toUpperCase() + key.slice(1)}.`, 'error', () => {});
            }
        }

        if (dataset.length === 0) {
            modal.alert('No data to process. Please upload a file.', 'error', () => {});
            return;
        }

        let jsonData = dataset.map(row => {
            return {
                "BA Code": row["BA Code"] || "",
                "Location": row["Location"] || "",
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

      //  modal.loading_progress(true, "Validating and Saving data...");
        let worker = new Worker(base_url + "assets/cms/js/validator_target_sales_ps.js");
        worker.postMessage({ data: jsonData, base_url });

        worker.onmessage = function(e) {
            const { invalid, errorLogs, valid_data, err_counter, progress } = e.data;

            if (progress !== undefined) {
                modal.loading_progress(true, `Processing... ${progress}%`);
                return;
            }

            modal.loading_progress(false);

            if (invalid) {
                let errorMsg = err_counter > 1000
                    ? '⚠️ Too many errors detected. Please download the error log for details.'
                    : errorLogs.slice(0, 10).join("<br>") + (errorLogs.length > 10 ? "<br>...and more" : "");

                modal.content('Validation Error', 'error', errorMsg, '600px', () => { 
                    $(".btn.save").prop("disabled", false);
                });

                createErrorLogFile(errorLogs, `Error_${formatReadableDate(new Date(), true)}`);
            } else if (Array.isArray(valid_data) && valid_data.length > 0) { 
                let new_data = valid_data.map(record => ({
                    ...record,
                    year: year,
                }));
                saveValidatedData(new_data);
            } else {
                modal.alert("No valid data found. Please check the file.", "error");
            }
        };

        worker.onerror = function(event) {
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

            let td_validator = ['ba code', 'location', 'january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];
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
        let table = 'tbl_target_sales_per_store';

        let selected_fields = [
            'id', 'ba_code', 'location', 'january', 'february', 'march', 'april',
            'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december',
            'year'

        ];

        const matchFields = [
            'ba_code', 'location', 'january', 'february', 'march', 'april',
            'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december',
            'year'
        ]; 

        const floatFields = [
            'january', 'february', 'march', 'april','may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'
        ];

        const matchType = "AND";  // Use "AND" or "OR" for matching logic

        modal.loading_progress(true, "Validating and Saving data...");

        aJax.post(url, { table: table, event: "fetch_existing", selected_fields: selected_fields }, function(response) {
            let result = JSON.parse(response);
            let existingMap = new Map();

            if (result.existing) {
                result.existing.forEach(record => {
                    let key = matchFields.map(field => {
                        let value = record[field] || "";
                        return floatFields.includes(field) ? parseFloat(value) || 0 : String(value).trim().toLowerCase();
                    }).join("|");

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
                        let key = matchFields.map(field => {
                            let value = row[field] || "";
                            return floatFields.includes(field) ? parseFloat(value) || 0 : String(value).trim().toLowerCase();
                        }).join("|");

                        if (existingMap.has(key)) {
                            matchedId = existingMap.get(key);
                        }
                    } else if (matchType === "OR") {
                        for (let [key, id] of existingMap.entries()) {
                            let keyParts = key.split("|");
                            for (let field of matchFields) {
                                let value = row[field] || "";
                                let formattedValue = floatFields.includes(field) ? parseFloat(value) || 0 : String(value).trim().toLowerCase();
                                if (keyParts.includes(formattedValue)) {
                                    matchedId = id;
                                    break;
                                }
                            }
                            if (matchedId) break;
                        }
                    }

                    if (matchedId) {
                        row.id = matchedId;
                        row.updated_by = user_id;
                        row.updated_date = formatDate(new Date());
                        delete row.created_date; // Unset created_date
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

    function get_year(selected_class) {
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
            $('#'+selected_class).html(html);
        })
    }

    $(document).on('click', '#btn_export ', function() {
        title = addNbsp('EXPORT Target Sellout PS');
        $("#export_modal").find('.modal-title').find('b').html(title)
        $('#export_modal').modal('show');
        get_year('year_select');
    });

    function download_template() {
        let formattedData = [
            {
                "BA Code":"",
                "Location":"",
                "January":"",
                "February":"",
                "March":"",
                "April":"",
                "May":"",
                "June":"",
                "July":"",
                "August":"",
                "September":"",
                "October":"",
                "November":"",
                "December":"",
                "NOTE:": "Please do not change the column headers."
            }
        ]

        const headerData = [];
    
        exportArrayToCSV(formattedData, `Target Sales per Store - ${formatDate(new Date())}`, headerData);
    }

    function exportFilter() {
        const year = $('#year_select').val()?.trim();

        const fields = { year };

        var formattedData = [];

        for (const [key, value] of Object.entries(fields)) {
            if (!value) {
                return modal.alert(`Please select a ${key.charAt(0).toUpperCase() + key.slice(1)}.`, 'error', () => {});
            }
        }

        modal.confirm(confirm_export_message,function(result){
            if (result) {
                modal.loading_progress(true, "Reviewing Data...");
                setTimeout(() => {
                    startExport()
                }, 500);
            }
        })

        const startExport = () => {
            dynamic_search(
                "'tbl_target_sales_per_store a'", 
                "'left join tbl_store s1 on s1.id = a.location'", 
                "'s1.description location, a.ba_code, a.january, a.february, a.march, a.april, a.may, a.june, a.july, a.august, a.september, a.october, a.november, a.december'",  
                0, 
                0, 
                `"year:EQ=${year}"`,  
                `''`, 
                `''`,
                (res) => {
                    let store_ids = []
                    let store_map = {}
            
                    let newData = res.map(({ 
                        location, ba_code, january, february, march, april, may, june, july, august, september, october, november, december
                    }) => ({
                        "BA Code":ba_code,
                        "Location":location,
                        "January":january,
                        "February":february,
                        "March":march,
                        "April":april,
                        "May":may,
                        "June":june,
                        "July":july,
                        "August":august,
                        "September":september,
                        "October":october,
                        "November":november,
                        "December":december,
                    }));

                    formattedData.push(...newData); // Append new data to formattedData array
                }
            )
    
            const headerData = [
                ["Company Name: Lifestrong Marketing Inc."],
                ["Target Sales per Store"],
                ["Date Printed: " + formatDate(new Date())],
                [""],
            ];
    
            exportArrayToCSV(formattedData, `Target Sales per Store - ${formatDate(new Date())}`, headerData);
            modal.loading_progress(false);
        }
    }

    function handleExport() {
        var formattedData = [];
        var ids = [];

        $('.select:checked').each(function () {
            var id = $(this).attr('data-id');
            ids.push(`${id}`); // Collect IDs in an array
        });

        modal.confirm(confirm_export_message,function(result){
            if (result) {
                modal.loading_progress(true, "Reviewing Data...");
                setTimeout(() => {
                    startExport()
                }, 500);
            }
        })

        const startExport = () => {
            const fetchStores = (callback) => {
                function processResponse (res) {
                    formattedData = res.map(({ 
                        location, ba_code, january, february, march, april, may, june, july, august, september, october, november, december
                    }) => ({
                        "BA Code":ba_code,
                        "Location":location,
                        "January":january,
                        "February":february,
                        "March":march,
                        "April":april,
                        "May":may,
                        "June":june,
                        "July":july,
                        "August":august,
                        "September":september,
                        "October":october,
                        "November":november,
                        "December":december,
                    }));
                };

                ids.length > 0 
                    ? dynamic_search(
                        "'tbl_target_sales_per_store a'", 
                        "'left join tbl_store s1 on s1.id = a.location'", 
                        "'s1.description location, a.ba_code, a.january, a.february, a.march, a.april, a.may, a.june, a.july, a.august, a.september, a.october, a.november, a.december'",  
                        100000, 
                        0, 
                        `'id:IN=${ids.join('|')}'`,  
                        `''`, 
                        `''`,
                        processResponse
                    )
                    : batch_export();
            };

            const batch_export = () => {
                dynamic_search(
                    "'tbl_target_sales_per_store'", 
                    "''", 
                    "'COUNT(id) as total_records'", 
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
                                    "'tbl_target_sales_per_store a'", 
                                    "'left join tbl_store s1 on s1.id = a.location'", 
                                    "'s1.description location, a.ba_code, a.january, a.february, a.march, a.april, a.may, a.june, a.july, a.august, a.september, a.october, a.november, a.december'",  
                                    100000, 
                                    index, 
                                    `''`,  
                                    `''`, 
                                    `''`,
                                    (res) => {
                                        let newData = res.map(({ 
                                            location, ba_code, january, february, march, april, may, june, july, august, september, october, november, december
                                        }) => ({
                                            "BA Code":ba_code,
                                            "Location":location,
                                            "January":january,
                                            "February":february,
                                            "March":march,
                                            "April":april,
                                            "May":may,
                                            "June":june,
                                            "July":july,
                                            "August":august,
                                            "September":september,
                                            "October":october,
                                            "November":november,
                                            "December":december,
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
                ["Target Sales per Store"],
                ["Date Printed: " + formatDate(new Date())],
                [""],
            ];

            exportArrayToCSV(formattedData, `Target Sales per Store - ${formatDate(new Date())}`, headerData);
            modal.loading_progress(false);
        }
    }

    function export_data(year) {
        var formattedData = [];

        const startExport = (res) => {
            let newData = res.map(({ 
                location, ba_code, january, february, march, april, may, june, july, august, september, october, november, december

            }) => ({
                "BA Code":ba_code,
                "Location":location,
                "January":january,
                "February":february,
                "March":march,
                "April":april,
                "May":may,
                "June":june,
                "July":july,
                "August":august,
                "September":september,
                "October":october,
                "November":november,
                "December":december,
            }));
            formattedData.push(...newData);
        }

        const startCount = (res) => {
            if (res && res.length > 0) {
                let total_records = res[0].total_records;
    
                for (let index = 0; index < total_records; index += 100000) {
                    dynamic_search(
                        "'tbl_target_sales_per_store a'", 
                        "'left join tbl_store s1 on s1.id = a.location'", 
                        "'s1.description location, a.ba_code, a.january, a.february, a.march, a.april, a.may, a.june, a.july, a.august, a.september, a.october, a.november, a.december'",  
                        100000, 
                        index, 
                        `'a.year:EQ=${year}'`, 
                        `''`,  
                        `''`,
                        startExport
                    )
                }
            }
        }

        dynamic_search(
            "'tbl_target_sales_per_store'", 
            "''", 
            "'COUNT(id) as total_records'", 
            0, 
            0, 
            `'year:EQ=${year}'`, 
            `''`,  
            `''`,
            startCount
        )

        const headerData = [
            ["Company Name: Lifestrong Marketing Inc."],
            ["Target Sales per Store"],
            ["Date Printed: " + formatDate(new Date())],
            [""],
        ];
    
        exportArrayToCSV(formattedData, `Target Sales per Store - ${formatDate(new Date())}`, headerData);
    }

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
    
</script>