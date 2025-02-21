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
                                        <!-- <th class='center-content'>Deployment Date</th>
                                        <th class='center-content'>Agency</th>
                                        <th class='center-content'>Brand</th>
                                        <th class='center-content'>Store</th>
                                        <th class='center-content'>Team</th>
                                        <th class='center-content'>Area</th> -->
                                        <th class='center-content'>Status</th>
                                        <!-- <th class='center-content'>Type</th> -->
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
                        <label>Deployment Date</label>
                        <input type="date" class="form-control" id="deployment_date">
                    </div>

                    <div class="form-group">
                        <label>Agency</label>
                        <select name="area" class="form-control required" id="agency">
                        </select>
                    </div>

<!--                     <div class="form-group">
                        <label>Brand</label>
                        <select name="area" class="form-control required" id="brand">
                        </select>
                    </div>
 -->
                        <div class="form-group">
                            <div class="row" >
                                <label class="col" >Brand</label>
                                <input
                                    type="button"
                                    value="Add Brand"
                                    class="row add_line"
                                    onclick="add_line()"
                                >
                            </div>
                            <div id="brand_list">
                                <!-- <div id="line_0" style="display: flex; align-items: center; gap: 5px; margin-top: 3px;">
                                    <select name="store" class="form-control store_drop required" id="store_0"></select>
                                    <button type="button" class="rmv-btn" onclick="remove_line(0)" disabled readonly>
                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                    </button>
                                </div> -->
                            </div>
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
                                        <th class='center-content' scope="col">Line #</th>
                                        <th class='center-content' scope="col">Code</th>
                                        <th class='center-content' scope="col">Name</th>
                                        <th class='center-content' scope="col">Deployment Date</th>
                                        <th class='center-content' scope="col">Agency</th>
                                        <th class='center-content' scope="col">Brand</th>
                                        <th class='center-content' scope="col">Store</th>
                                        <th class='center-content' scope="col">Team</th>
                                        <th class='center-content' scope="col">Area</th>
                                        <th class='center-content' scope="col">Type</th>
                                        <th class='center-content' scope="col">Status</th>
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
                    <button type="button" class="btn caution" data-dismiss="modal">Close</button>
                    <button type="button" class="btn save" onclick="process_xl_file()">Validate and Save</button>
                </div>
            </div>
        </div>
    </div>

<script>
    var query = "ba.status >= 0";
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url("cms/global_controller");?>";
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

    function get_data(query) {
      var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "list",
            select : "ba.id, ba.code, ba.name, ba.deployment_date, a.agency, s.description as store, t.team_description, ar.description as area, ba.status, ba.type, ba.updated_date, ba.created_date",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_brand_ambassador ba",
            order : {
                field : "ba.code",
                order : "asc" 
            },
            join : [
                {
                    table: "tbl_agency a",
                    query: "a.id = ba.agency",
                    type: "left"
                },
                // {
                //     table: "tbl_ba_brands b",
                //     query: "b.ba_id = ba.id",
                //     type: "left"
                // },
                {
                    table: "tbl_store s",
                    query: "s.id = ba.store",
                    type: "left"
                },
                {
                    table: "tbl_team t",
                    query: "t.id = ba.team",
                    type: "left"
                },
                {
                    table: "tbl_area ar",
                    query: "ar.id = ba.area",
                    type: "left"
                }
            ]            
            

        }

        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            var html = '';

            if(result) {
                if (result.length > 0) {
                    $.each(result, function(x,y) {
                        var status = ( parseInt(y.status) === 1 ) ? status = "Active" : status = "Inactive";
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
                        html += "<td>" +status+ "</td>";
                        // html += "<td>" + (y.type == 1 ? "Outright" : "Consign") + "</td>";
                        html += "<td class='center-content'>" + (y.created_date ? ViewDateformat(y.created_date) : "N/A") + "</td>";
                        html += "<td class='center-content'>" + (y.updated_date ? ViewDateformat(y.updated_date) : "N/A") + "</td>";
                        
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
    
    function get_pagination() {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
          event : "pagination",
            select : "id, status",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_brand_ambassador ba",
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
        get_data(query);
        $('.selectall').prop('checked', false);
        $('.btn_status').hide();
    })

    $(document).on('keydown', '#search_query', function(event) {
        $('.btn_status').hide();
        $(".selectall").prop("checked", false);
        if (event.key == 'Enter') {
            search_input = $('#search_query').val();
            offset = 1;
            new_query = query;
            new_query += " AND (ba.code LIKE '%" + search_input + "%' OR ba.name LIKE '%" + search_input + "%' OR a.agency LIKE '%" + search_input + "%' OR s.description LIKE '%" + search_input + "%' OR t.team_description LIKE '%" + search_input + "%' OR ar.description LIKE '%" + search_input + "%')";
            //to follow OR b.brand_description LIKE '%" + search_input + "%'
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
        modal.loading(false);
    });

    $('#btn_add').on('click', function() {
        open_modal('Add New Brand Ambassador', 'add', '');
        get_area('');
        get_agency('');
        get_store('');
        get_team('');
        get_brand('', 'brand_0');
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
        let $brand_list = $('#brand_list');
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
        
        setTimeout(() => {
            if (actions === 'view') {
                $('.rmv-btn').attr('disabled', true);
                $('.brand_drop').attr('disabled', true);
            }
        }, 1000); 

        $brand_list.empty();
        $('input[name="type"]').prop('disabled', isReadOnly);

        $footer.empty();
        //if (actions === 'add') $footer.append(buttons.save);
        if (actions === 'add') {
            let line = get_max_number();

            let html = `
            <div id="line_${line}" style="display: flex; align-items: center; gap: 5px; margin-top: 3px;">
                <select name="brand" class="form-control brand_drop required" id="brand_${line}"></select>
                <button type="button" class="rmv-btn" disabled readonly onclick="remove_line(${line})">
                    <i class="fa fa-minus" aria-hidden="true"></i>
                </button>
            </div>
            `;
            $brand_list.append(html)
            $('input[name="type"]').each(function() {
                if ($(this).val() == 1) {
                    $(this).prop('checked', true); 
                }
            });
            $('.add_line').attr('disabled', false)
            $('.add_line').attr('readonly', false)
            $footer.append(buttons.save)
        };
        if (actions === 'edit') {
            $footer.append(buttons.edit)
            $('.add_line').attr('disabled', false)
            $('.add_line').attr('readonly', false)
        };
        if (actions === 'view') {
            $('.add_line').attr('disabled', true)
            $('.add_line').attr('readonly', true)
        }
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

    $(document).on('click', '#btn_import ', function() {
        title = addNbsp('IMPORT BRAND AMBASSADOR')
        $("#import_modal").find('.modal-title').find('b').html(title)
        $("#import_modal").modal('show')
        clear_import_table()
    });

    function clear_import_table() {
        $(".import_table").empty();
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

            let td_validator = ['code', 'name', 'deployment date', 'agency', 'brand', 'store', 'team', 'area', 'type' ,'status'];
            td_validator.forEach(column => {
                if (column === 'deployment date') {
                    lowerCaseRecord[column] = excel_date_to_readable_date(lowerCaseRecord[column]);
                }
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

    function read_xl_file() {
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
            modal.alert('The file size exceeds the 50MB limit. Please upload a smaller file.', 'error', () => {});
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

    function process_xl_file() {
        let btn = $(".btn.save");
        if (btn.prop("disabled")) return; // Prevent multiple clicks

        btn.prop("disabled", true);
        $(".import_buttons").find("a.download-error-log").remove();
        
        if (dataset.length === 0) {
            modal.alert('No data to process. Please upload a file.', 'error', () => {});
            return;
        }
        modal.loading(true);
        let jsonData = dataset.map(row => {
            if (row["Brand"]) { 
                let brandList = row["Brand"].split(',').map(item => item.trim());
                let seen = new Map();

                row["Brand"] = brandList.filter(brand => {
                    let lowerCaseBrand = brand.toLowerCase();
                    if (!seen.has(lowerCaseBrand)) {
                        seen.set(lowerCaseBrand, brand); // Store original case of first occurrence
                        return true;
                    }
                    return false;
                });
            }

            return {
                "Code": row["Code"] || "",
                "Name": row["Name"] || "",
                "Deployment Date": row["Deployment Date"] ? row["Deployment Date"] : "",
                "Agency": row["Agency"] || "",
                "Brand": row["Brand"] || "",
                "Store": row["Store"] || "",
                "Team": row["Team"] || "",
                "Area": row["Area"] || "",
                "Status": row["Status"] || "",
                "Type": row["Type"] || "",
                "Created By": user_id || "",
                "Created Date": formatDate(new Date()) || ""
            };
        });

        let worker = new Worker(base_url + "assets/cms/js/validator_ba.js");
        worker.postMessage({ data: jsonData, base_url: base_url });

        worker.onmessage = function(e) {
            modal.loading_progress(false);

            let { invalid, errorLogs, valid_data, err_counter, brand_per_ba } = e.data;
            if (invalid) {
                if (err_counter > 1000) {
                    
                    modal.content(
                        'Validation Error',
                        'error',
                        '⚠️ Too many errors detected. Please download the error log for details.',
                        '600px',
                        () => {read_xl_file()}
                    );
                } else {
                    modal.content(
                        'Validation Error',
                        'error',
                        errorLogs.join("<br>"),
                        '600px',
                        () => {read_xl_file()}
                    );
                }
                createErrorLogFile(errorLogs, "Error "+formatReadableDate(new Date(), true));
            } else if (valid_data && valid_data.length > 0) {
                updateSwalProgress("Validation Completed", 10);
                setTimeout(() => saveValidatedData(valid_data, brand_per_ba), 500);
            } else {
                modal.loading_progress(false);
                modal.alert("No valid data returned. Please check the file and try again.", "error", () => {});
            }
        };

        worker.onerror = function() {
            modal.loading_progress(false);
            modal.alert("Error processing data. Please try again.", "error", () => {});
        };
    }

    //backup
    // function saveValidatedData(valid_data, brand_per_ba) {
    //     let batch_size = 5000;
    //     let total_batches = Math.ceil(valid_data.length / batch_size);
    //     let batch_index = 0;
    //     let errorLogs = [];
    //     let url = "<?= base_url('cms/global_controller');?>";
    //     let table = 'tbl_brand_ambassador';
    //     let selected_fields = ['id', 'code', 'name'];
    //     let existingMapByCode = new Map();
    //     let existingMapByName = new Map();
    //     matchType = "OR";

    //     modal.loading_progress(true, "Validating and Saving data...");

    //     aJax.post(url, { table: table, event: "fetch_existing", status: true, selected_fields: selected_fields }, function(response) {
    //         let result = JSON.parse(response);
    //         if (result.existing) {
    //             result.existing.forEach(record => {
    //                 existingMapByCode.set(record.code, record.id);
    //                 existingMapByName.set(record.name, record.id);
    //             });
    //         }

    //         function updateOverallProgress(stepName, completed, total) {
    //             let progress = Math.round((completed / total) * 100);
    //             updateSwalProgress(stepName, progress);
    //         }

    //         function processNextBatch() {
    //             if (batch_index >= total_batches) {
    //                 modal.loading_progress(false);

    //                 if (errorLogs.length > 0) {
    //                     createErrorLogFile(errorLogs, "Update_Error_Log_" + formatReadableDate(new Date(), true));
    //                     modal.alert("Some records encountered errors. Check the log.", 'info', () => {});
    //                 } else {
    //                     modal.alert("All records saved/updated successfully!", 'success', () => location.reload());
    //                 }
    //                 return;
    //             }

    //             let batch = valid_data.slice(batch_index * batch_size, (batch_index + 1) * batch_size);
    //             let newRecords = [];
    //             let updateRecords = [];

    //             batch.forEach(row => {
    //                 let matchByCode = existingMapByCode.get(row.code);
    //                 let matchByName = existingMapByName.get(row.name);

    //                 let matchFound = false;
    //                 let existingId = null;

    //                 if (matchType === "AND") {
    //                     if (matchByCode && matchByName && matchByCode === matchByName) {
    //                         matchFound = true;
    //                         existingId = matchByCode;
    //                     }
    //                 } else if (matchType === "OR") {
    //                     if (matchByCode || matchByName) {
    //                         matchFound = true;
    //                         existingId = matchByCode || matchByName;
    //                     }
    //                 }

    //                 if (matchFound) {
    //                     row.id = existingId;
    //                     row.updated_date = formatDate(new Date());
    //                     updateRecords.push(row);
    //                 } else {
    //                     row.created_by = user_id;
    //                     row.created_date = formatDate(new Date());
    //                     newRecords.push(row);
    //                 }
    //             });

    //             function processUpdates(callback) {
    //                 if (updateRecords.length > 0) {
    //                     batch_update(url, updateRecords, "tbl_brand_ambassador", "id", true, (response) => {
    //                         let inserted_ids = response.inserted_ids;
    //                         if (response.message !== 'success') {
    //                             updateOverallProgress("Updating Brands...", batch_index + 1, total_batches);
    //                             errorLogs.push(`Failed to update: ${JSON.stringify(response.error)}`);
    //                         }
    //                         processBrandPerBA(inserted_ids, brand_per_ba, function() {
    //                         });
    //                         callback();
    //                     });
    //                 } else {
    //                     callback();
    //                 }
    //             }

    //             function processInserts() {
    //                 if (newRecords.length > 0) {
    //                     batch_insert(url, newRecords, "tbl_brand_ambassador", true, (response) => {
    //                         if (response.message === 'success') {
    //                             let inserted_ids = response.inserted;
    //                             updateOverallProgress("Saving Brands...", batch_index + 1, total_batches);
    //                             processBrandPerBA(inserted_ids, brand_per_ba, function() {
    //                                 batch_index++;
    //                                 setTimeout(processNextBatch, 300);
    //                             });
    //                         } else {
    //                             errorLogs.push(`Batch insert failed: ${JSON.stringify(response.error)}`);
    //                             batch_index++;
    //                             setTimeout(processNextBatch, 300);
    //                         }
    //                     });
    //                 } else {
    //                     batch_index++;
    //                     setTimeout(processNextBatch, 300);
    //                 }
    //             }

    //             processUpdates(processInserts);
    //         }

    //         setTimeout(processNextBatch, 1000);
    //     });
    // }

    // function processBrandPerBA(inserted_ids, brand_per_ba, callback) {
    //     let batch_size = 5000;
    //     let brandBatchIndex = 0;
    //     let brandDataKeys = Object.keys(brand_per_ba);
    //     let total_brand_batches = Math.ceil(brandDataKeys.length / batch_size);
    //     let insertedMap = {};

    //     inserted_ids.forEach(({ id, code }) => {
    //         insertedMap[code] = id;
    //     });

    //     function processNextBrandBatch() {
    //         if (brandBatchIndex >= total_brand_batches) {
    //             callback();
    //             return;
    //         }

    //         let chunkKeys = brandDataKeys.slice(brandBatchIndex * batch_size, (brandBatchIndex + 1) * batch_size);
    //         let chunkData = [];
    //         let baIdsToDelete = [];
    //         chunkKeys.forEach(code => {
    //             if (insertedMap[code]) {

    //                 let ba_id = insertedMap[code];
    //                 let brand_ids = brand_per_ba[code];
    //                 baIdsToDelete.push(ba_id);
    //                 brand_ids.forEach(brand_id => {
    //                     chunkData.push({
    //                         ba_id: ba_id,
    //                         brand_id: brand_id,
    //                         created_by: user_id,
    //                         created_date: formatDate(new Date()),
    //                         updated_date: formatDate(new Date())
    //                     });
    //                 });
    //             }
    //         });
    //         if (baIdsToDelete.length > 0) {
    //             batch_delete(url, "tbl_ba_brands", "ba_id", baIdsToDelete, 'brand_id', function(resp) {
    //                 insertNewBrandRecords(chunkData);
    //             });
    //         } else {
    //             insertNewBrandRecords(chunkData);
    //         }
    //     }

    //     function insertNewBrandRecords(chunkData) {
    //         if (chunkData.length > 0) {
    //             batch_insert(url, chunkData, "tbl_ba_brands", false, function(response) {
    //                 brandBatchIndex++;
    //                 setTimeout(processNextBrandBatch, 100);
    //             });
    //         } else {
    //             brandBatchIndex++;
    //             setTimeout(processNextBrandBatch, 100);
    //         }
    //     }

    //     if (brandDataKeys.length > 0) {
    //         processNextBrandBatch();
    //     } else {
    //         callback();
    //     }
    // }

    function saveValidatedData(valid_data, brand_per_ba) {
        let batch_size = 5000;
        let total_batches = Math.ceil(valid_data.length / batch_size);
        let batch_index = 0;
        let errorLogs = [];
        let url = "<?= base_url('cms/global_controller');?>";
        let table = 'tbl_brand_ambassador';
        let selected_fields = ['id', 'code', 'name'];
        
        let existingMapByCode = new Map();
        let existingMapByName = new Map();
        matchType = "OR";

        modal.loading_progress(true, "Validating and Saving data...");

        aJax.post(url, { table: table, event: "fetch_existing", status: true, selected_fields: selected_fields }, function(response) {
            let result = JSON.parse(response);
            if (result.existing) {
                result.existing.forEach(record => {
                    existingMapByCode.set(record.code, record.id);
                    existingMapByName.set(record.name, record.id);
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
                    let matchByName = existingMapByName.get(row.name);

                    let matchFound = false;
                    let existingId = null;

                    if (matchType === "AND") {
                        if (matchByCode && matchByName && matchByCode === matchByName) {
                            matchFound = true;
                            existingId = matchByCode;
                        }
                    } else if (matchType === "OR") {
                        if (matchByCode || matchByName) {
                            matchFound = true;
                            existingId = matchByCode || matchByName;
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
                        batch_update(url, updateRecords, "tbl_brand_ambassador", "id", true, (response) => {
                            if (response.message !== 'success') {
                                errorLogs.push(`Failed to update: ${JSON.stringify(response.error)}`);
                            }
                            updateOverallProgress("Updating Brands...", batch_index + 1, total_batches);
                            processBrandPerBA(updateRecords.map(r => ({ id: r.id, code: r.code })), brand_per_ba, callback);
                        });
                    } else {
                        callback(); // Proceed even if no updates
                    }
                }

                function processInserts() {
                    if (newRecords.length > 0) {
                        batch_insert(url, newRecords, "tbl_brand_ambassador", true, (response) => {
                            if (response.message === 'success') {
                                let inserted_ids = response.inserted;
                                updateOverallProgress("Saving Brands...", batch_index + 1, total_batches);
                                processBrandPerBA(inserted_ids, brand_per_ba, function() {
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

    function processBrandPerBA(inserted_ids, brand_per_ba, callback) {
        let batch_size = 5000;
        let brandBatchIndex = 0;
        let brandDataKeys = Object.keys(brand_per_ba);
        let total_brand_batches = Math.ceil(brandDataKeys.length / batch_size);
        let insertedMap = {};

        inserted_ids.forEach(({ id, code }) => {
            insertedMap[code] = id;
        });

        function processNextBrandBatch() {
            if (brandBatchIndex >= total_brand_batches) {
                callback();
                return;
            }

            let chunkKeys = brandDataKeys.slice(brandBatchIndex * batch_size, (brandBatchIndex + 1) * batch_size);
            let chunkData = [];
            let baIdsToDelete = [];

            chunkKeys.forEach(code => {
                if (insertedMap[code]) {
                    let ba_id = insertedMap[code];
                    let brand_ids = brand_per_ba[code];
                    baIdsToDelete.push(ba_id);
                    brand_ids.forEach(brand_id => {
                        chunkData.push({
                            ba_id: ba_id,
                            brand_id: brand_id,
                            created_by: user_id,
                            created_date: formatDate(new Date()),
                            updated_date: formatDate(new Date())
                        });
                    });
                }
            });

            function insertNewBrandRecords(chunkData) {
                if (chunkData.length > 0) {
                    batch_insert(url, chunkData, "tbl_ba_brands", false, function(response) {
                        brandBatchIndex++;
                        setTimeout(processNextBrandBatch, 100);
                    });
                } else {
                    brandBatchIndex++;
                    setTimeout(processNextBrandBatch, 100);
                }
            }

            if (baIdsToDelete.length > 0) {
                batch_delete(url, "tbl_ba_brands", "ba_id", baIdsToDelete, 'brand_id', function(resp) {
                    insertNewBrandRecords(chunkData);
                });
            } else {
                insertNewBrandRecords(chunkData);
            }
        }

        if (brandDataKeys.length > 0) {
            processNextBrandBatch();
        } else {
            callback();
        }
    }

    function readable_date_to_excel_date(readable_date) {
        var dateObj = new Date(readable_date);
        var yyyy = dateObj.getFullYear();
        var mm = String(dateObj.getMonth() + 1).padStart(2, '0');
        var dd = String(dateObj.getDate()).padStart(2, '0');
        var formattedDate = `${yyyy}-${mm}-${dd}`;

        return formattedDate;
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

    function populate_modal(inp_id) {
        var query = "status >= 0 and id = " + inp_id;
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, code, name, deployment_date, agency, store, team, area, status, type",
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
                    $('#store').val(ba.store);
                    get_store(ba.store);
                    $('#team').val(ba.team);
                    get_team(ba.team);
                    $('#area').val(ba.area);
                    //console.log(area);
                    get_area(ba.area);

                    var line = 0;
                    var readonly = '';
                    var disabled = ''

                    let $brand_list = $('#brand_list')
                    $.each(get_ba_brands(ba.id), (x, y) => {
                        if (line === 0) {
                            disabled = 'disabled';
                            readonly = 'readonly';
                        } else {
                            readonly = '';
                            disabled = ''
                        }
                        let html = `
                        <div id="line_${line}" style="display: flex; align-items: center; gap: 5px; margin-top: 3px;">
                            <select name="brand" class="form-control brand_drop required" id="brand_${line}"></select>
                            <button type="button" class="rmv-btn" ${disabled} ${readonly} onclick="remove_line(${line})">
                                <i class="fa fa-minus" aria-hidden="true"></i>
                            </button>
                        </div>
                        `;
                        $brand_list.append(html)
                        get_brand(y.brand_id, `brand_${line}`);
                        line++
                    })
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

    function get_ba_brands(ba_id) {
        var data = {
            event : "list",
            select : "id, ba_id, brand_id",
            query : 'id > 0 and ba_id = '+ba_id,
            offset : 0,
            limit : 0,
            table : "tbl_ba_brands",
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

    function reset_modal_fields() {
        $('#popup_modal #code, #popup_modal #name, #popup_modal #deployment_date, #popup_modal #agency, #popup_modal #brand, #popup_modal #store, #popup_modal #team, #popup_modal #area, #popup_modal').val('');
        $('#popup_modal #status').prop('checked', true);
        $('input[name="type"]').prop('checked', false);
    }

    function save_data(action, id) {
        var code = $('#code').val().trim();
        var name = $('#name').val().trim();
        var deployment_date = $('#deployment_date').val();
        var agency = $('#agency').val();
        var brand = $('#brand').val();
        var store = $('#store').val();
        var team = $('#team').val();
        var area = $('#area').val();
        var type = $('input[name="type"]:checked').val() || ''; 
        var chk_status = $('#status').prop('checked');
        var linenum = 0;
        var unique_brand = [];
        var brand_list = $('#brand_list');
        // add_line
        brand_list.find('select').each(function() {
            linenum++
            if (!unique_brand.includes($(this).val())) {
                unique_brand.push($(this).val())
            }
        });
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
                            save_to_db(code, name, deployment_date, agency, store, team, area, type, status_val, id, (obj) => {
                                total_delete(url, 'tbl_ba_brands', 'ba_id', id)
                                let batch = [];
                                $.each(unique_brand, (x, y) => {
                                    let data = {
                                        'ba_id': id,
                                        'brand_id': y,
                                        'created_by': user_id,
                                        'created_date': formatDate(new Date())
                                    };
                                    batch.push(data);
                                })
                                batch_insert(url, batch, 'tbl_ba_brands', false, () => {
                                    modal.loading(false);
                                    modal.alert(success_update_message, "success", function() {
                                        location.reload();
                                    });
                                })
                            });
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
                            save_to_db(code, name, deployment_date, agency, store, team, area, type, status_val, null, (obj) => {
                                let batch = [];
                                $.each(unique_brand, (x, y) => {
                                    let data = {
                                        'ba_id': obj.ID,
                                        'brand_id': y,
                                        'created_by': user_id,
                                        'created_date': formatDate(new Date())
                                    };
                                    batch.push(data);
                                })
                                batch_insert(url, batch, 'tbl_ba_brands', false, () => {
                                    modal.loading(false);
                                    modal.alert(success_save_message, "success", function() {
                                        location.reload();
                                    });
                                })
                            });
                        }
                    });

                }                  
            });
        }
    }

    function save_to_db(inp_code, inp_name, inp_deployment_date, inp_agency, inp_store, inp_team, inp_area, int_type, status_val, id, cb) {
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
                    //brand: inp_brand,
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
                    //brand: inp_brand,
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
            cb(obj);
            modal.loading(false);
        });
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
        });
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
        });
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
        });
    }

    let brandDescriptions = {};
    function get_brand(id, dropdown_id) {
        var url = "<?= base_url('cms/global_controller');?>";
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
            $('#'+dropdown_id).empty();
            $('#'+dropdown_id).append(html);
        });
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

        modal.confirm(modal_obj, function (result) {
            if (result) {
                var url = "<?= base_url('cms/global_controller');?>";
                var dataList = [];
                
                $('.select:checked').each(function () {
                    var id = $(this).attr('data-id');
                    dataList.push({
                        event: "update",
                        table: "tbl_brand_ambassador",
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

    function get_max_number() {
        let storeElements = $('[id^="brand_"]');
        
        let maxNumber = Math.max(
            0,
            ...storeElements.map(function () {
                return parseInt(this.id.replace("brand_", ""), 10) || 0;
            }).get()
        );

        return maxNumber;
    }

    function add_line() {
        let line = get_max_number() + 1;

        let html = `
        <div id="line_${line}" style="display: flex; align-items: center; gap: 5px; margin-top: 3px;">
            <select name="brand" class="form-control brand_drop required" id="brand_${line}"></select>
            <button type="button" class="rmv-btn" onclick="remove_line(${line})">
                <i class="fa fa-minus" aria-hidden="true"></i>
            </button>
        </div>
        `;
        $('#brand_list').append(html);
        get_brand('', `brand_${line}`);
    }

    function remove_line(lineId) {
        $(`#line_${lineId}`).remove();
    }
    
</script>
