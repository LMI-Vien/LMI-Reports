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
        min-width: 120px; 
        flex-grow: 1; 
    }
    
    .d-flex {
        gap: 10px; 
        margin: 5px;
    }

    th, td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
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
                                    <th class='center-content'>Imported Date</th>
                                    <th class='center-content'>Imported By</th>
                                    <th class='center-content'>Company</th>
                                    <th class='center-content'>Year</th>
                                    <!-- <th class='center-content'>Month</th> -->
                                    <th class='center-content'>Week</th>
                                    <th class='center-content'>Date Modified</th>
                                    <th class='center-content'>Actions</th>
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
                    <div class="mb-3">
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
                                        <!-- <div class="col-12 d-flex align-items-center">
                                            <label for="monthSelect" class="form-label fw-semibold me-2">Choose Month:</label>
                                            <select id="monthSelect" class="form-select uniform-dropdown">
                                            </select>
                                        </div> -->
                                        <div class="col-12 d-flex align-items-center">
                                            <label for="weekSelect" class="form-label fw-semibold me-2">Choose Week:</label>
                                            <select id="weekSelect" class="form-select uniform-dropdown" onfocus="updateWeeks()">
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
                        <div style="overflow-x: auto; max-height: 400px;">
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

<div class="modal" tabindex="-1" id="export_modal">
    <div class="modal-dialog">
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
                <div class="card p-4 shadow-lg rounded-3 border-0" style="background: #f8f9fa;">
                    <div class="row g-3">
                        <div class="col-12 d-flex align-items-center">
                            <label for="year_select" class="form-label fw-semibold me-2">Choose Year:</label>
                            <select id="year_select" class="form-select uniform-dropdown">
                            </select>
                        </div>
                        <!-- <div class="col-12 d-flex align-items-center">
                            <label for="month_select" class="form-label fw-semibold me-2">Choose Month:</label>
                            <select id="month_select" class="form-select uniform-dropdown">
                            </select>
                        </div> -->
                        <div class="col-12 d-flex align-items-center">
                            <label for="week_select" class="form-label fw-semibold me-2">Choose Week:</label>
                            <select id="week_select" class="form-select uniform-dropdown" onfocus="updateWeeks()">
                            </select>
                        </div>
                        <div class="col-12 d-flex align-items-center">
                            <label for="company_select" class="form-label fw-semibold me-2">Choose Company:</label>
                            <select id="company_select" class="form-select uniform-dropdown">
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
    var query = "vmih.status >= 0";
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url('cms/global_controller');?>";

    //for importing
    let currentPage = 1;
    let rowsPerPage = 1000;
    let totalPages = 1;
    let dataset = [];

    $(document).ready(function() {
        const checkInterval = 120000;

        const pollInterval = setInterval(function () {
            $.getJSON('<?= base_url('cms/import-vmi/pending');?>', function (response) {
                if (response.ready) {
                    const filename = response.filename;

                    // Download file via hidden iframe
                    $('<iframe>', {
                        src: `<?= base_url('cms/import-vmi/download/');?>${response.filename}`,
                        style: 'display: none;'
                    }).appendTo('body');

                    clearInterval(pollInterval);
                    modal.alert("Your export is ready. Downloading now.", "success");
                }
            });
        }, checkInterval);

        modal.loading(true);  
        get_data();
    });

    function get_data() {
        var data = {
            event : "list_pagination",
            select : "vmih.id, vmih.year AS filter_year, vmih.week, vmih.week AS filter_week, vmih.company AS filter_company, c.name AS company, y.year, vmih.status, vmih.created_by, vmih.created_date, vmih.updated_date, cu.name AS imported_by",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_vmi_header vmih",
            join : [{
                table : "tbl_company as c",
                query : "c.id = vmih.company",
                type : "left"
            },
            {
                table : "tbl_year as y",
                query : "y.id = vmih.year",
                type : "left"
            },
            {
                table : "cms_users as cu",
                query : "cu.id = vmih.created_by",
                type : "left"
            }],
            order : {
                field : ["vmih.year", "vmih.week", "vmih.company"],
                order : ["desc", "desc", "asc"] 
            }

        }

        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            var html = '';
            var list = result.list;
            if(list) {
                if (list.length > 0) {
                    $.each(list, function(x,y) {
                        var status = ( parseInt(y.status) === 1 ) ? status = "Active" : status = "Inactive";
                        var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";
                        var latestDate = null;
                        if (y.updated_date !== "0000-00-00 00:00:00") {
                            latestDate = y.updated_date;
                        } else {
                            latestDate = null;
                        }
                        html += "<tr class='" + rowClass + "'>";
                        html += "<td scope=\"col\">" + (y.created_date ? ViewDateformat(y.created_date) : "N/A") + "</td>";
                        html += "<td scope=\"col\">" + (y.imported_by) + "</td>";
                        html += "<td scope=\"col\">" + (y.company) + "</td>";
                        html += "<td scope=\"col\">" + (y.year) + "</td>";
                        html += "<td scope=\"col\">" + (y.week) + "</td>";
                        html += "<td scope=\"col\">" + (latestDate ? ViewDateformat(latestDate) : "N/A") + "</td>";
                        let href = "<?= base_url()?>"+"cms/import-vmi/view/"+`${y.company}-${y.year}-${y.week}`;

                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                            html+="<td class='center-content' style='width: 25%; min-width: 200px'>";
                            // html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.filter_company+"','"+y.filter_year+"','"+y.filter_month+"','"+y.filter_week+
                            html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.filter_company+"','"+y.filter_year+"','"+y.filter_week+
                            "')\" data-status='"+y.status+"' id='"+y.id+
                            "' title='Delete Item'><span class='glyphicon glyphicon-pencil'>Delete</span>";
                            
                            html+="<a class='btn-sm btn view' href='"+ href +"' data-status='"+y.status+
                            "' target='_blank' id='"+y.id+
                            "' title='View'><span class='glyphicon glyphicon-pencil'>View</span>";

                            // html+="<a class='btn-sm btn save' onclick=\"export_data('"+y.company+"','"+y.year+"','"+y.month+"','"+y.week+
                            html+="<a class='btn-sm btn save' onclick=\"export_data('"+y.filter_company+"','"+y.filter_year+"','"+y.week+
                            "')\" data-status='"+y.status+"' id='"+y.id+
                            "' title='Export Batch'><span class='glyphicon glyphicon-pencil'>Export</span>";

                            html+="</td>";
                        }
                        
                        html += "</tr>";   
                    });
                } else {
                    html = '<tr><td colspan=18 class="center-align-format">'+ no_records +'</td></tr>';
                }
            }

            $('.table_body').html(html);
            modal.loading(false);
            if(result.pagination){
              if(result.pagination.total_page > 1){
                  pagination.generate(result.pagination.total_page, ".list_pagination", get_data);
                    currentPage = offset;
                    $(".pager_number option[value="+currentPage+"]").prop("selected", false)
                    $('.pager_number').val(currentPage);
                    $('.pager_no').html("Page " + numeral(currentPage).format('0,0'));
              }
              else if(result.total_data < limit) {
              $('.list_pagination').empty();
              } 
            }
        });
    }

    pagination.onchange(function(){
      offset = $(this).val();
      modal.loading(true);
      get_data();
      $("#search_query").val("");
    });

    $(document).on('keydown', '#search_query', function(event) {
        $('.btn_status').hide();
        $(".selectall").prop("checked", false);
        if (event.key == 'Enter') {
            search_input = $('#search_query').val();
            var escaped_keyword = search_input.replace(/'/g, "''"); 
            offset = 1;
            if(search_input){
                query = 'vmih.status >= 0 and (c.name like \'%'+escaped_keyword+'%\' or y.year like \'%'+escaped_keyword+'%\' or cu.name like \'%'+escaped_keyword+'%\')';
            }else{
                query = 'vmih.status >= 0';
            }
            get_data();
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
    });

    function clear_import_table() {
        $(".import_table").empty();
    }

    function paginateData(rowsPerPage) {
        totalPages = Math.ceil(dataset.length / rowsPerPage);
        currentPage = 1;
        fetchPaginatedData();
    }


    $(document).on('click', '#btn_import ', function() {
        title = addNbsp('IMPORT VMI')
        $("#import_modal").find('.modal-title').find('b').html(title)
        $('#import_modal').modal('show');
        get_year('yearSelect');
        get_company('companySelect');
        // get_week('weekSelect');
    });

    function updateWeeks() {
        let selectedYear = $('#yearSelect option:selected').text();
        let year_select = $('#year_select option:selected').text();
        populateDropdown('weekSelect', getCalendarWeeks(selectedYear), 'display', 'id');
        populateDropdown('week_select', getCalendarWeeks(year_select), 'display', 'id');
    }

    function getCalendarWeeks(year) {
        const weeks = [];

        // Start from the first Monday of the ISO week 1
        let date = new Date(year, 0, 4); // Jan 4 is always in the first ISO week
        const day = date.getDay();
        const diff = (day === 0 ? -6 : 1 - day); // move to Monday
        date.setDate(date.getDate() + diff);

        let weekNumber = 1;

        while (date.getFullYear() <= year || (date.getFullYear() === year + 1 && weekNumber < 54)) {
            const weekStart = new Date(date);
            const weekEnd = new Date(date);
            weekEnd.setDate(weekEnd.getDate() + 6);

            if (weekStart.getFullYear() > year && weekEnd.getFullYear() > year) break;

            weeks.push({
                id: weekNumber,
                display: `Week ${weekNumber} (${weekStart.toISOString().slice(0, 10)} - ${weekEnd.toISOString().slice(0, 10)})`,
                week: weekNumber++,
                start: weekStart.toISOString().slice(0, 10),
                end: weekEnd.toISOString().slice(0, 10),
            });

            date.setDate(date.getDate() + 7); // move to next Monday
        }

        return weeks;
    }

    const populateDropdown = (selected_class, result, textKey = 'name', valueKey = 'id') => {
        let html = '<option id="default_val" value=" ">Select</option>';

        if (result && result.length > 0) {
            result.forEach((item) => {
                html += `<option value="${item[valueKey]}">${item[textKey]}</option>`;
            });
        }

        $('#' + selected_class).html(html);
    };

    function addNbsp(inputString) {
        return inputString.split('').map(char => {
            if (char === ' ') {
            return '&nbsp;&nbsp;';
            }
            return char + '&nbsp;';
        }).join('');
    }

    async function read_xl_file() {
        delete_temp_data();
        $(".btn.save").prop("disabled", false);
        let fileInput = document.getElementById("file");
        let file = fileInput.files[0];

        if (!file) {
            modal.alert("Please select a file to upload.", "error");
            return;
        }

        var inp_year = $('#yearSelect').val()?.trim();
        var inp_week = $('#weekSelect').val()?.trim();
        var inp_company = $('#companySelect').val()?.trim();
        const fields = { inp_year, inp_week, inp_company };
        for (const [key, value] of Object.entries(fields)) {
            if (!value) {
                return modal.alert(`Please select a ${key.replace("inp_", "")}.`, 'error', () => {});
            }
        }


        modal.loading_progress(true, "Preparing Data");
        const chunkSize = 512 * 1024; // 512 KB
        const totalChunks = Math.ceil(file.size / chunkSize);

        for (let chunkIndex = 0; chunkIndex < totalChunks; chunkIndex++) {
            let start = chunkIndex * chunkSize;
            let end = Math.min(start + chunkSize, file.size);
            let chunk = file.slice(start, end);

            let formData = new FormData();
            formData.append("file", chunk);
            formData.append("chunkIndex", chunkIndex);
            formData.append("totalChunks", totalChunks);
            formData.append("fileName", file.name);
            formData.append("inp_year", inp_year);
            // formData.append("inp_month", inp_month);
            formData.append("inp_week", inp_week);
            formData.append("inp_company", inp_company);

            try {
                let response = await fetch("<?= base_url('cms/import-vmi/import-temp-vmi-data'); ?>", {
                    method: "POST",
                    body: formData
                });
                let result = await response.json();
                if (!response.ok) {
                    modal.alert(result.message || "Upload error, please try again.", "error");
                    return;
                }
            } catch (error) {
                modal.alert("Upload error, please try again.", "error");
                return;
            }
            let progress = Math.round(((chunkIndex + 1) / totalChunks) * 100);
            updateSwalProgress("Preview Data", progress);
        }
        fetchPaginatedData();
        modal.loading_progress(false);
    }

    function fetchPaginatedData() {
        inp_year = $('#yearSelect').val()?.trim();
        inp_week = $('#weekSelect').val()?.trim();
        inp_company = $('#companySelect').val()?.trim();

        modal.loading(true);
        $.ajax({
            url: "<?= base_url('cms/import-vmi/fetch-temp-vmi-data'); ?>",
            method: "GET",
            data: {
                page: currentPage,
                limit: rowsPerPage,
                inp_year: inp_year,
                inp_week: inp_week,
                inp_company: inp_company
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    totalPages = Math.ceil(response.totalRecords / rowsPerPage);
                    display_imported_data(response.data);
                } else {
                    modal.alert("Failed to fetch data.", "error");
                }
                modal.loading(false);
            },
            error: function() {
                modal.alert("Error fetching data.", "error");
                modal.loading(false);
            }
        });
    }

    function process_xl_file() {
        let btn = $(".btn.save");
        if (btn.prop("disabled")) return;
        btn.prop("disabled", true);

        var inp_year = $('#yearSelect').val()?.trim();
        // var inp_month = $('#monthSelect').val()?.trim();
        var inp_week = $('#weekSelect').val()?.trim();
        var inp_company = $('#companySelect').val()?.trim();

        // const fields = { inp_year, inp_month, inp_week, inp_company };
        const fields = { inp_year, inp_week, inp_company };
        for (const [key, value] of Object.entries(fields)) {
            if (!value) {
                btn.prop("disabled", false);
                return modal.alert(`Please select a ${key.replace("inp_", "")}.`, 'error', () => {});
            }
        }

        modal.loading(true, "Fetching all data from temporary table...");

        let allData = [];

        function fetchAllPages(page = 1) {
            inp_year = $('#yearSelect').val()?.trim();
            // inp_month = $('#monthSelect').val()?.trim();
            inp_week = $('#weekSelect').val()?.trim();
            inp_company = $('#companySelect').val()?.trim();

            $.ajax({
                url: "<?= base_url('cms/import-vmi/fetch-temp-vmi-data'); ?>",
                method: "GET",

                data: { page, limit: 5000, inp_year, inp_week, inp_company},
                success: function(response) {
                    if (response.success && response.data.length > 0) {
                        allData = allData.concat(response.data);
                        if (response.data.length === 5000) {
                            fetchAllPages(page + 1);
                        } else {
                            validate_temp_data(allData, inp_year, inp_week, inp_company);
                        }
                    } else {
                        modal.loading_progress(false);
                        modal.alert("No data found in the temporary table.", "error", () => {});
                    }
                },
                error: function(xhr) {
                    modal.loading(false);
                    modal.alert("Error fetching data: " + xhr.responseText, "error", () => {});
                }
            });
        }

        fetchAllPages();
    }

    var counter = 0;
    function validate_temp_data(data, inp_year, inp_week, inp_company) 
    {
        modal.loading(true, "Validating data...");

        let worker = new Worker(base_url + "assets/cms/js/validator_vmi.js");
        worker.postMessage({ data, base_url, company: inp_company });

        worker.onmessage = function(e) {
            const { invalid, errorLogs, valid_data, err_counter, progress } = e.data;

            if (progress !== undefined) {
                counter++;
                if(counter === 1){
                  modal.loading_progress(true, `Processing... 57%`);  
                }
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
                    year: inp_year,
                    week: inp_week,
                    company: inp_company
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

    function display_imported_data(paginatedData) {
        let html = "";
        let tr_counter = (currentPage - 1) * rowsPerPage;

        paginatedData.forEach(row => {
            let rowClass = (tr_counter % 2 === 0) ? "even-row" : "odd-row";
            html += `<tr class="${rowClass}">`;
            html += `<td>${tr_counter + 1}</td>`;

            let lowerCaseRecord = Object.keys(row).reduce((acc, key) => {
                acc[key.toLowerCase()] = row[key];
                return acc;
            }, {});

            let td_validator = ['store', 'item', 'item_name', 'vmi_status', 'item_class', 'supplier', 'group', 'dept', 'class', 'sub_class', 'on_hand', 'in_transit', 'average_sales_unit'];
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

        $(".import_table").html(html);
        updatePaginationControls();
    }

    function updateAggregatedVmiData(){
        const week = $("#weekSelect").val();
        const year = $("#yearSelect").val();
        const company = $("#companySelect").val();

        const update_url = "<?= base_url('cms/import-vmi/update-aggregated-vmi-data');?>";
        const data = {
            company: company,
            week: week,
            year: year,
        };

        aJax.post(update_url, data, function (result) { 
        });
    }


    function saveValidatedData(valid_data) {
        let batch_size = 5000;
        let total_batches = Math.ceil(valid_data.length / batch_size);
        let batch_index = 0;
        let errorLogs = [];
        let url = "<?= base_url('cms/global_controller');?>";
        let table = 'tbl_vmi';
        const start_time = new Date();
        const { year, week, company, created_by, created_date } = valid_data[0];
       // return;   
        const selected_fields = [
            'id', 'store', 'item', 'item_name', 'vmi_status', 'item_class',
            'supplier', 'c_group', 'dept', 'c_class', 'sub_class', 'on_hand',
            'in_transit', 'year', 'week', 'company'
        ];

        const matchFields = [
            'store', 'item', 'item_name', 'vmi_status', 'item_class', 'supplier',
            'c_group', 'dept', 'c_class', 'sub_class', 'on_hand',
            'in_transit', 'year', 'week', 'company'
        ];

        const matchType = "AND";

        let inp_year = $('#yearSelect').val()?.trim();
        let inp_week = $('#weekSelect').val()?.trim();
        let inp_company = $('#companySelect').val()?.trim();
        const filters = [inp_year, inp_week, inp_company];

        modal.loading_progress(true, "Validating and Saving data...");
        aJax.post(url, {
            table: "tbl_vmi_header",
            event: "insert_or_get_header",
            filters: filters,
            data: { year, week, company, created_by, created_date }
        }, function(headerResponse) {
            let headerResult = headerResponse;
            if (!headerResult.status || !headerResult.id) {
                modal.alert("Error creating/retrieving VMI header.", "error");
                modal.loading_progress(false);
                return;
            }

            const vmi_header_id = headerResult.id;
            valid_data.forEach(row => {
                row.vmi_header_id = vmi_header_id;
            });

            aJax.post(url, { table: table, event: "fetch_existing_new", selected_fields: selected_fields, filters: filters }, function(response) {
                let result = JSON.parse(response);
                let existingMap = new Map();

                if (result.existing) {
                    result.existing.forEach(record => {
                        let key = matchFields.map(field => String(record[field] || "").trim().toLowerCase()).join("|");
                        existingMap.set(key, record.id);
                    });
                }

                async function processNextBatch() {
                    if (batch_index >= total_batches) {
                        modal.loading_progress(false);
                        if (errorLogs.length > 0) {
                            createErrorLogFile(errorLogs, "Update_Error_Log_" + formatReadableDate(new Date(), true));
                            modal.alert("Some records encountered errors. Check the log.", 'info');
                        } else {
                            modal.loading_progress(true, "Finishing data...");
                            setTimeout(finishImport, 500);
                        }
                        return;
                    }

                    const batch = valid_data.slice(batch_index * batch_size, (batch_index + 1) * batch_size);
                    const newRecords = [];
                    const updateRecords = [];

                    batch.forEach(row => {
                        let matchedId = null;
                        if (matchType === "AND") {
                            let key = matchFields.map(field => String(row[field] || "").trim().toLowerCase()).join("|");
                            if (existingMap.has(key)) {
                                matchedId = existingMap.get(key);
                            }
                        }

                        if (matchedId) {
                            row.id = matchedId;
                            row.updated_by = user_id;
                            row.updated_date = formatDate(new Date());
                            delete row.created_by;
                            delete row.created_date;
                            updateRecords.push(row);
                        } else {
                            row.created_by = user_id;
                            row.created_date = formatDate(new Date());
                            newRecords.push(row);
                        }
                    });

                    try {
                        if (updateRecords.length > 0) {
                            await batchUpdateAsync(url, updateRecords, table, "id");
                        }
                        if (newRecords.length > 0) {
                            await batchInsertAsync(url, newRecords, table);
                        }
                    } catch (error) {
                        errorLogs.push(`Batch ${batch_index}: ${error}`);
                    }

                    batch_index++;

                    const progress = Math.round((batch_index / total_batches) * 100);

                    updateSwalProgress(`Saving Data...`, progress);
                    processNextBatch();
                }

                function finishImport() {
                    const headers = ['store', 'item', 'item_name']; 
                    const logUrl = "<?= base_url('cms/global_controller/save_import_log_file') ?>";
                    updateAggregatedVmiData();
                    saveImportDetailsToServer(valid_data, headers, 'import_vmi', logUrl, function(filePath) {
                        const end_time = new Date();
                        const duration = formatDuration(start_time, end_time);

                        let remarks = `
                            Import Completed Successfully!
                            <br>Total Records: ${valid_data.length}
                            <br>Start Time: ${formatReadableDate(start_time)}
                            <br>End Time: ${formatReadableDate(end_time)}
                            <br>Duration: ${duration}`;

                        let link = filePath ? `<a href="<?= base_url() ?>${filePath}" target="_blank">View Details</a>` : null;

                        logActivity('VMI Module', 'Import Data', remarks, link, null, null);
                        modal.loading(false);
                        location.reload();
                    });
                }
                processNextBatch();
            });
        });
    }

    async function batchUpdateAsync(url, records, table, key) {
        return new Promise((resolve, reject) => {
            batch_update(url, records, table, key, false, (response) => {
                if (response.message === 'success') {
                    resolve();
                } else {
                    reject(response.error || 'Unknown update error');
                }
            });
        });
    }

    async function batchInsertAsync(url, records, table) {
        return new Promise((resolve, reject) => {
            batch_insert(url, records, table, false, (response) => {
                if (response.message === 'success') {
                    resolve();
                } else {
                    reject(response.error || 'Unknown insert error');
                }
            });
        });
    }

    function delete_temp_data(){
        $.ajax({
            url: "<?= base_url('cms/import-vmi/delete-temp-vmi-data'); ?>",
            type: "POST",
            data: { action: "delete_temp_records" },
            success: function (response) {
            },
            error: function (xhr, status, error) {
            }
        });
    }

    function display_imported_data(paginatedData) {
        let html = "";
        let tr_counter = (currentPage - 1) * rowsPerPage;

        paginatedData.forEach(row => {
            let rowClass = (tr_counter % 2 === 0) ? "even-row" : "odd-row";
            html += `<tr class="${rowClass}">`;
            html += `<td>${tr_counter + 1}</td>`;

            let lowerCaseRecord = Object.keys(row).reduce((acc, key) => {
                acc[key.toLowerCase()] = row[key];
                return acc;
            }, {});

            let td_validator = ['store', 'item', 'item_name', 'vmi_status', 'item_class', 'supplier', 'group', 'dept', 'class', 'sub_class', 'on_hand', 'in_transit', 'average_sales_unit'];
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

        $(".import_table").html(html);
        updatePaginationControls();
    }

    function updatePaginationControls() {
        let paginationHtml = `
            <button onclick="goToPage(1)" ${currentPage === 1 ? "disabled" : ""}>
                <i class="fas fa-angle-double-left"></i>
            </button>
            <button onclick="changePage(-1)" ${currentPage === 1 ? "disabled" : ""}>
                <i class="fas fa-angle-left"></i>
            </button>
            
            <select onchange="goToPage(this.value)">
                ${Array.from({ length: totalPages }, (_, i) => 
                    `<option value="${i + 1}" ${i + 1 === currentPage ? "selected" : ""}>Page ${i + 1}</option>`
                ).join('')}
            </select>
            
            <button onclick="changePage(1)" ${currentPage === totalPages ? "disabled" : ""}>
                <i class="fas fa-angle-right"></i>
            </button>
            <button onclick="goToPage(totalPages)" ${currentPage === totalPages ? "disabled" : ""}>
                <i class="fas fa-angle-double-right"></i>
            </button>
        `;

        $(".import_pagination").html(paginationHtml);
    }

    function changePage(offset) {
        if ((offset === -1 && currentPage > 1) || (offset === 1 && currentPage < totalPages)) {
            currentPage += offset;
            fetchPaginatedData();
        }
    }

    function goToPage(page) {
        page = parseInt(page);
        if (page >= 1 && page <= totalPages) {
            currentPage = page;
            fetchPaginatedData();
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
            class: "download-error-log btn btn-danger mt-2", 
            css: {
                border: "1px solid white",
                borderRadius: "10px",
                display: "inline-block",
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
                field : "year",
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

    function get_month(selected_class) {
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
            $('#'+selected_class).html(html);
        })
    }

    function get_week(selected_class) {
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
            $('#'+selected_class).html(html);
        })
    }

    function get_company(selected_class) {
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
            $('#'+selected_class).html(html);
        })
    }

    function download_template() {
        let formattedData = [
            {
                "Store":"", 
                "Item":"", 
                "Item Name":"", 
                "VMI Status":"", 
                "Item Class":"", 
                "Supplier":"", 
                "C Group":"", 
                "Dept":"", 
                "C Class":"", 
                "Sub Class":"", 
                "On Hand":"", 
                "In Transit":"", 
                "Ave Sales Unit":"", 
                "NOTE:": "Please do not change the column headers."
            }
        ]
        const headerData = [];
    
        exportArrayToCSV(formattedData, `VMI - ${formatDate(new Date())}`, headerData);
    }

    $(document).on('click', '#btn_export ', function() {
        title = addNbsp('EXPORT VMI')
        $("#export_modal").find('.modal-title').find('b').html(title)
        $('#export_modal').modal('show');
        get_year('year_select');
        // get_month('month_select');
        // get_week('week_select');
        get_company('company_select');
    });

    function exportFilter() {
        var formattedData = [];

        const company = $('#company_select').val()?.trim();
        const year = $('#year_select').val()?.trim();
        const week = $('#week_select').val()?.trim();

        let filterArr = []
        if(company) {
            filterArr.push(`a.company:EQ=${company}`);
        }
        if(year) {
            filterArr.push(`a.year:EQ=${year}`);
        }

        if(week) {
            filterArr.push(`week:EQ=${week}`);
        }

        let filter = filterArr.join(',')

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
                "'tbl_vmi a'", 
                "'LEFT JOIN tbl_year as v on a.year = v.id LEFT JOIN tbl_company as c ON c.id = a.company'", 
                "'store, item, item_name, item_class, supplier, `c_group`, dept, `c_class` as classification, sub_class, on_hand, in_transit, average_sales_unit, company, vmi_status, v.year, week'", 
                0, 
                0, 
                `'${filter}'`,  
                `''`, 
                `''`,
                (res) => {
                    let store_ids = []
                    let store_map = {}
            
                    const storeSet = new Set(store_ids); // convert existing array to a Set
                    res.forEach(stores => {
                        storeSet.add(`${stores.store}`);
                    });
                    store_ids = Array.from(storeSet); // convert back to array
            
                    dynamic_search(
                        "'tbl_store'", 
                        "''", 
                        "'id, code, description'", 
                        0, 
                        0, 
                        `'id:IN=${store_ids.join('|')}'`,  
                        `''`, 
                        `''`,
                        (result) => {
                            result.forEach(store => {
                                if (!store_map[store.id]) {
                                    store_map[store.id] = {}; // Initialize as an object
                                }
                                store_map[store.id].description = store.description;
                                store_map[store.id].code = store.code;
                            });
                        }
                    );

                    spacing = {
                        "Store":"", 
                        "Item":"", 
                        "Item Name":"", 
                        "VMI Status":"", 
                        "Item Class":"", 
                        "Supplier":"", 
                        "Group":"", 
                        "Dept":"", 
                        "Class":"", 
                        "Sub Class":"", 
                        "On Hand":"", 
                        "In Transit":"", 
                        "Ave Sales Unit":"", 
                    }

                    let previousRecord = null;
                    let count = 0;
                    res.forEach(det => {
                        let rec_company = det.company;
                        let rec_year = det.year;
                        // let rec_month = det.month;
                        let rec_week = det.week;
                        // let currentRecord = { rec_company, rec_year, rec_month, rec_week };
                        let currentRecord = { rec_company, rec_year, rec_week };
                        count+=1;

                        let newData = {
                            "Store":store_map[`${det.store}`].code, 
                            "Item":det.item, 
                            "Item Name":det.item_name, 
                            "VMI Status":det.vmi_status, 
                            "Item Class":det.item_class, 
                            "Supplier":det.supplier, 
                            "Group":det.c_group, 
                            "Dept":det.dept, 
                            "Class":det.classification, 
                            "Sub Class":det.sub_class, 
                            "On Hand":det.on_hand, 
                            "In Transit":det.in_transit, 
                            "Ave Sales Unit":det.average_sales_unit, 
                        }

                        if (previousRecord && 
                            (
                                previousRecord.rec_company !== det.company || 
                                previousRecord.rec_year !== det.year || 
                                //previousRecord.rec_month !== det.month || 
                                previousRecord.rec_week !== det.week
                            )
                        ) {
                            formattedData.push(spacing)
                        }
                        formattedData.push(newData)
                        previousRecord = currentRecord;
                    })
                }
            )
    
            const headerData = [
                ["Company Name: Lifestrong Marketing Inc."],
                ["VMI"],
                ["Date Printed: " + formatDate(new Date())],
                [""],
            ];
    
            exportArrayToCSV(formattedData, `VMI - ${formatDate(new Date())}`, headerData);
            modal.loading_progress(false);
        }
    }

    function handleExport() {
        var formattedData = [];

        modal.confirm(confirm_export_message,function(result){
            if (result) {
                modal.loading_progress(true, "Reviewing Data...");
                setTimeout(() => {
                    startExport()
                }, 500);
            }
        })

        const startExport = () => {
            const batch_export = () => {
                dynamic_search(
                    "'tbl_vmi'", 
                    "''", 
                    `'COUNT(id) as total_records'`, 
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
                                    "'tbl_vmi a'", 
                                    "'LEFT JOIN tbl_year as v on a.year = v.id'", 
                                    `'store, item, item_name, item_class, supplier, \`c_group\`, dept, c_class as classification, sub_class, on_hand, in_transit, average_sales_unit, company, vmi_status, v.year, week'`, 
                                    100000, 
                                    index, 
                                    `''`,  
                                    `''`, 
                                    `''`,
                                    (res) => {
                                        let store_ids = []
                                        let store_map = {}

                                        const storeSet = new Set(store_ids); // convert existing array to a Set
                                        res.forEach(stores => {
                                            storeSet.add(`${stores.store}`);
                                        });
                                        store_ids = Array.from(storeSet); // convert back to array

                                        dynamic_search(
                                            "'tbl_store'", 
                                            "''", 
                                            "'id, code, description'", 
                                            0, 
                                            0, 
                                            `'id:IN=${store_ids.join('|')}'`,  
                                            `''`, 
                                            `''`,
                                            (result) => {
                                                result.forEach(store => {
                                                    if (!store_map[store.id]) {
                                                        store_map[store.id] = {}; // Initialize as an object
                                                    }
                                                    store_map[store.id].description = store.description;
                                                    store_map[store.id].code = store.code;
                                                });
                                            }
                                        );

                                        spacing = {
                                            "Store":"", 
                                            "Item":"", 
                                            "Item Name":"", 
                                            "VMI Status":"", 
                                            "Item Class":"", 
                                            "Supplier":"", 
                                            "C Group":"", 
                                            "Dept":"", 
                                            "C Class":"", 
                                            "Sub Class":"", 
                                            "On Hand":"", 
                                            "In Transit":"", 
                                            "Ave Sales Unit":"", 
                                        }

                                        let previousRecord = null;
                                        let count = 0;
                                        res.forEach(det => {
                                            let rec_company = det.company;
                                            let rec_year = det.year;
                                            let rec_week = det.week;
                                            let currentRecord = { rec_company, rec_year, rec_week };
                                            count+=1;

                                            let newData = {
                                                "Store":store_map[`${det.store}`].code, 
                                                "Item":det.item, 
                                                "Item Name":det.item_name, 
                                                "VMI Status":det.vmi_status, 
                                                "Item Class":det.item_class, 
                                                "Supplier":det.supplier, 
                                                "C Group":det.c_group, 
                                                "Dept":det.dept, 
                                                "C Class":det.classification, 
                                                "Sub Class":det.sub_class, 
                                                "On Hand":det.on_hand, 
                                                "In Transit":det.in_transit, 
                                                "Ave Sales Unit":det.average_sales_unit, 
                                            }

                                            if (previousRecord && 
                                                (
                                                    previousRecord.rec_company !== det.company || 
                                                    previousRecord.rec_year !== det.year || 
                                                    previousRecord.rec_week !== det.week
                                                )
                                            ) {
                                                formattedData.push(spacing)
                                            }
                                            formattedData.push(newData)
                                            previousRecord = currentRecord;
                                        })
                                    }
                                )
                            }
                        }
                    }
                )
            };

            batch_export();

            const headerData = [
                ["Company Name: Lifestrong Marketing Inc."],
                ["VMI"],
                ["Date Printed: " + formatDate(new Date())],
                [""],
            ];

            exportArrayToCSV(formattedData, `VMI - ${formatDate(new Date())}`, headerData);
            modal.loading_progress(false);
        }
    }

    function export_data(company, year, week) 
    {
        modal.loading(true);
        let expurl = "<?= base_url()?>"+`cms/import-vmi/export`;
        $.ajax({
            url: expurl,
            method: 'POST',
            data: {
                company : company,
                year : year,
                week : week
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(blob, status, xhr) {
                const cd = xhr.getResponseHeader('Content-Disposition');
                const match = cd && /filename="?([^"]+)"/.exec(cd);
                const filename = 'VMI '+formatDate(new Date())+'.xlsx';
                const blobUrl = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = blobUrl;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                a.remove();
                URL.revokeObjectURL(blobUrl);
            },
            error: function(xhr, status, error) {
                alert(xhr+' - '+status+' - '+error);
                console.log(xhr)
                modal.loading(false);
            },
            complete: function() {
                modal.loading(false);
            }
        })
    }

    function delete_data(company, year, week){   
        modal.confirm(confirm_delete_message,function(result){
            if(result){ 
                modal.loading(true);
                var url = "<?= base_url('cms/global_controller');?>";

                const conditions = [
                    { field: "year", values: [year] },
                    { field: "company", values: [company] },
                    { field: "week", values: [week] }
                ];

                batch_delete_with_conditions(url, "tbl_vmi_pre_aggregated_data", conditions, function(resp) {
                });
                batch_delete_with_conditions(url, "tbl_vmi_header", conditions, function(resp) {
                });
                batch_delete_with_conditions(url, "tbl_vmi", conditions, function(resp) {
                    modal.loading(false);    
                    modal.alert("Selected records deleted successfully!", 'success', () => location.reload());
                });
            }
        });
    }

    function exportArrayToCSV(data, filename, headerData) {
        const worksheet = XLSX.utils.json_to_sheet(data, { origin: headerData.length });
        XLSX.utils.sheet_add_aoa(worksheet, headerData, { origin: "A1" });
        const csvContent = XLSX.utils.sheet_to_csv(worksheet);
        const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
        saveAs(blob, filename + ".csv");
    }
    
</script>