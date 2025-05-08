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
      get_pagination(query);
    });

    function get_data(new_query) {
        modal.loading(true);
        var data = {
            event: "list",
            select: "name",
            query: new_query,
            offset: offset,
            limit: limit,
            table: "tbl_vmi_grouped"
        };

        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            var html = '';
            var latestDate = null;
            modal.loading(false);
            if(result) {
                if (result.length > 0) {
                    $.each(result, function(x,y) {
                        var status = ( parseInt(y.status) === 1 ) ? status = "Active" : status = "Inactive";
                        var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";
                        if (y.updated_date && y.updated_date !== "0000-00-00 00:00:00") {
                            const currentDate = y.updated_date;
                            if (!latestDate || currentDate > latestDate) {
                                latestDate = currentDate;
                            }
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
                            html+="<a class='btn-sm btn save' onclick=\"export_data('"+y.company+"','"+y.year+"','"+y.week+
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
        });
    }

    function get_pagination(new_query) {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
          event : "pagination",
          select: "c.name AS company, y.year as year, m.month, w.name week",
          query: new_query,
          offset: offset,
          limit: limit,
          table: "tbl_vmi v",
          join: [
              {
                  table: "tbl_company c",
                  query: "c.id = v.company",
                  type: "left"
              },
              {
                  table: "tbl_year y",
                  query: "y.id = v.year",
                  type: "left"
              },
              {
                  table: "tbl_month m",
                  query: "m.id = v.month",
                  type: "left"
              },
              {
                  table: "tbl_week w",
                  query: "w.id = v.week",
                  type: "left"
              }
          ],
          order: {
              field: "v.year",
              order: "asc"
          },
          group : "v.year, v.month, v.week, c.name"
        }

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

    $(document).on('keypress', '#search_query', function(e) {               
        if (e.keyCode === 13) {
            var keyword = $(this).val().trim();
            offset = 1;

            var search_conditions = [
                "c.name LIKE '%" + keyword + "%'",
                "y.year LIKE '%" + keyword + "%'",
                "m.month LIKE '%" + keyword + "%'",
                "w.name LIKE '%" + keyword + "%'"
            ];

            var combined_query = "(" + search_conditions.join(" OR ") + ")";

            var new_query = query ? "(" + query + " AND " + combined_query + ")" : combined_query;

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
        // get_month('monthSelect');
        get_company('companySelect');
        // get_week('weekSelect');
    });

    function updateWeeks() {
        let selectedYear = $('#yearSelect option:selected').text();
        let year_select = $('#year_select option:selected').text();
        populateDropdown('weekSelect', getCalendarWeeks(selectedYear), 'display', 'id');
        populateDropdown('week_select', getCalendarWeeks(year_select), 'display', 'id');
    }

    const getCalendarWeeks = (year) => {
        const weeks = [];
        const startDate = new Date(year, 0, 1); // Jan 1
        const day = startDate.getDay(); // day of the week (0 = Sunday)

        const firstMonday = new Date(startDate);
        if (day !== 1) {
            const offset = (day === 0 ? 1 : (9 - day)); 
            firstMonday.setDate(startDate.getDate() + offset);
        }

        let currentDate = new Date(firstMonday);
        let weekNumber = 1;

        while (currentDate.getFullYear() <= year) {
            const weekStart = new Date(currentDate);
            const weekEnd = new Date(currentDate);
            weekEnd.setDate(weekEnd.getDate() + 6);

            if (weekStart.getFullYear() > year) break;

            weeks.push({
                id: weekNumber,
                display: `Week ${weekNumber} (${weekStart.toISOString().slice(0, 10)} - ${weekEnd.toISOString().slice(0, 10)})`,
                week: weekNumber++,
                start: weekStart.toISOString().slice(0, 10),
                end: weekEnd.toISOString().slice(0, 10),
            });

            currentDate.setDate(currentDate.getDate() + 7);
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

    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0'); 
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');

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
        // var inp_month = $('#monthSelect').val()?.trim();
        var inp_week = $('#weekSelect').val()?.trim();
        var inp_company = $('#companySelect').val()?.trim();

        // const fields = { inp_year, inp_month, inp_week, inp_company };
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
        inp_month = $('#monthSelect').val()?.trim();
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
                inp_month: inp_month,
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

                // data: { page, limit: 5000, inp_year, inp_month, inp_week, inp_company}, // Fetch in larger chunks
                data: { page, limit: 5000, inp_year, inp_week, inp_company}, // Fetch in larger chunks
                success: function(response) {
                    if (response.success && response.data.length > 0) {
                        allData = allData.concat(response.data);
                        if (response.data.length === 5000) {
                            fetchAllPages(page + 1);
                        } else {
                            // validate_temp_data(allData, inp_year, inp_month, inp_week, inp_company);
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

    // function validate_temp_data(data, inp_year, inp_month, inp_week, inp_company) 
    function validate_temp_data(data, inp_year, inp_week, inp_company) 
    {
        modal.loading(true, "Validating data...");

        let worker = new Worker(base_url + "assets/cms/js/validator_vmi.js");
        worker.postMessage({ data, base_url, company: inp_company });

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
                    year: inp_year,
                    // month: inp_month,
                    week: inp_week,
                    company: inp_company
                }));
                // console.log(new_data);
                // return;
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

    function saveValidatedData(valid_data) {
        let batch_size = 5000;
        let total_batches = Math.ceil(valid_data.length / batch_size);
        let batch_index = 0;
        let errorLogs = [];
        let url = "<?= base_url('cms/global_controller');?>";
        let table = 'tbl_vmi';
        const start_time = new Date();

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

                // Update overall progress
                const progress = Math.round((batch_index / total_batches) * 100);

                updateSwalProgress(`Saving Data...`, progress);

                // No artificial delay! Continue immediately
                processNextBatch();
            }

            function finishImport() {
                const headers = ['store', 'item', 'item_name']; 
                const url = "<?= base_url('cms/global_controller/save_import_log_file') ?>";

                saveImportDetailsToServer(valid_data, headers, 'import_vmi', url, function(filePath) {
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
                    location.reload();
                });
            }
            processNextBatch();
        });
    }

    // Utilities
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

    //for optimization
    // function saveValidatedData(valid_data) {
    //     let batch_size = 5000;
    //     let batch_index = 0;
    //     let errorLogs = [];
    //     let url = "<?= base_url('cms/global_controller');?>";
    //     let table = 'tbl_vmi';

    //     let matchFields = ['store', 'item', 'item_name', 'vmi_status', 'item_class', 'supplier', 'group', 'dept', 'class', 'sub_class', 'on_hand', 'in_transit', 'year', 'month', 'week', 'company'];
    //     let matchType = "AND";

    //     modal.loading_progress(true, "Validating and Saving data...");

    //     let existingMap = new Map();

    //     async function fetchExistingData() {
    //         return new Promise((resolve, reject) => {
    //             aJax.post(url, { table: table, event: "fetch_existing2", selected_fields: matchFields, valid_data: valid_data }, function(response) {
    //                 let result = JSON.parse(response);
    //                 if (result.existing) {
    //                     result.existing.forEach(record => {
    //                         let key = matchFields.map(field => String(record[field] || "").trim().toLowerCase()).join("|");
    //                         existingMap.set(key, record.id);
    //                     });
    //                 }
    //                 resolve();
    //             });
    //         });
    //     }

    //     async function processNextBatch() {
    //         if (batch_index * batch_size >= valid_data.length) {
    //             modal.loading_progress(false);
    //             if (errorLogs.length > 0) {
    //                 createErrorLogFile(errorLogs, "Update_Error_Log_" + formatReadableDate(new Date(), true));
    //                 modal.alert("Some records encountered errors. Check the log.", 'info');
    //             } else {
    //                 modal.alert("All records saved/updated successfully!", 'success', () => location.reload());
    //             }
    //             return;
    //         }

    //         let batch = valid_data.slice(batch_index * batch_size, (batch_index + 1) * batch_size);
    //         let newRecords = [];
    //         let updateRecords = [];

    //         batch.forEach(row => {
    //             let key = matchFields.map(field => String(row[field] || "").trim().toLowerCase()).join("|");
    //             let matchedId = existingMap.get(key);

    //             if (matchedId) {
    //                 row.id = matchedId;
    //                 row.updated_by = user_id;
    //                 row.updated_date = formatDate(new Date());
    //                 delete row.created_by;
    //                 delete row.created_date;
    //                 updateRecords.push(row);
    //             } else {
    //                 row.created_by = user_id;
    //                 row.created_date = formatDate(new Date());
    //                 newRecords.push(row);
    //             }
    //         });

    //         try {
    //             if (updateRecords.length > 0) {
    //                 let updateResponse = await batch_update(url, updateRecords, table, "id", false);
    //                 if (updateResponse.message !== 'success') errorLogs.push(`Failed to update: ${JSON.stringify(updateResponse.error)}`);
    //             }

    //             if (newRecords.length > 0) {
    //                 let insertResponse = await batch_insert(url, newRecords, table, false);
    //                 if (insertResponse.message !== 'success') errorLogs.push(`Batch insert failed: ${JSON.stringify(insertResponse.error)}`);
    //             }
    //         } catch (error) {
    //             errorLogs.push(`Unexpected error: ${error}`);
    //         }

    //         batch_index++;
    //         requestIdleCallback(processNextBatch);
    //     }

    //     fetchExistingData().then(processNextBatch);
    // }

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

    // function processInChunks(data, chunkSize, callback) {
    //     let index = 0;
    //     let totalRecords = data.length;
    //     let totalProcessed = 0;

    //     function nextChunk() {
    //         if (index >= data.length) {
    //             modal.loading_progress(false);
    //             callback(); 
    //             return;
    //         }

    //         let chunk = data.slice(index, index + chunkSize);
    //         dataset = dataset.concat(chunk);
    //         totalProcessed += chunk.length; 
    //         index += chunkSize;

    //         let progress = Math.min(100, Math.round((totalProcessed / totalRecords) * 100));
    //         updateSwalProgress("Preview Data", progress);
    //         requestAnimationFrame(nextChunk);
    //     }
    //     nextChunk();
    // }

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
        // const month = $('#month_select').val()?.trim();
        const week = $('#week_select').val()?.trim();

        let filterArr = []
        if(company) {
            filterArr.push(`company:EQ=${company}`);
        }
        if(year) {
            filterArr.push(`year:EQ=${year}`);
        }
        // if(month) {
        //     filterArr.push(`month:EQ=${month}`);
        // }
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
                "'tbl_vmi'", 
                "''", 
                "'store, item, item_name, item_class, supplier, `c_group`, dept, `c_class` as classification, sub_class, on_hand, in_transit, average_sales_unit, company, vmi_status, v.year, v.month, v.week'", 
                0, 
                0, 
                `'${filter}'`,  
                `''`, 
                `''`,
                (res) => {
                    let store_ids = []
                    let store_map = {}
            
                    res.forEach(stores => {
                        store_ids.push(`${stores.store}`);
                    });
            
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
                                previousRecord.rec_month !== det.month || 
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
                                    "'tbl_vmi'", 
                                    "''", 
                                    `'store, item, item_name, item_class, supplier, \`c_group\`, dept, c_class as classification, sub_class, on_hand, in_transit, average_sales_unit, company, vmi_status, v.year, v.month, v.week'`, 
                                    100000, 
                                    index, 
                                    `''`,  
                                    `''`, 
                                    `''`,
                                    (res) => {
                                        let store_ids = []
                                        let store_map = {}

                                        res.forEach(stores => {
                                            store_ids.push(`${stores.store}`);
                                        });

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
                                            let rec_month = det.month;
                                            let rec_week = det.week;
                                            let currentRecord = { rec_company, rec_year, rec_month, rec_week };
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
                                                    previousRecord.rec_month !== det.month || 
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
                        } else {

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

    // function export_data(company, year, month, week) 
    function export_data(company, year, week) 
    {
        var formattedData = [];
        let filterArr = []
        filterArr.push(`c.name:EQ=${company}`);
        filterArr.push(`y.year:EQ=${year}`);
        // filterArr.push(`m.month:EQ=${month}`);
        filterArr.push(`w.name:EQ=${week}`);

        let filter = filterArr.join(',')

        dynamic_search(
                "'tbl_vmi v'", 
                "'left join tbl_company c on v.company = c.id "+
                "left join tbl_year y on v.year = y.id "+
                // "left join tbl_month m on v.month = m.id "+
                "left join tbl_week w on v.week = w.id'", 
                "'COUNT(v.id) as total_records'", 
                0, 
                0, 
                `'${filter}'`,  
                `''`, 
                `''`,
                (res) => {
                    if (res && res.length > 0) {
                        let total_records = res[0].total_records;

                        for (let index = 0; index < total_records; index += 100000) {
                            dynamic_search(
                                "'tbl_vmi v'", 

                                "'left join tbl_company c on v.company = c.id "+
                                "left join tbl_year y on v.year = y.id "+
                                // "left join tbl_month m on v.month = m.id "+
                                "left join tbl_week w on v.week = w.id'", 

                                "'store, item, item_name, item_class, supplier, `c_group`, dept, c_class as classification, "+
                                "sub_class, on_hand, in_transit, average_sales_unit, company, vmi_status, v.year, v.month, v.week'", 

                                100000, 
                                index, 
                                `'${filter}'`,  
                                `''`, 
                                `''`,
                                (res) => {
                                    let store_ids = []
                                    let store_map = {}
                            
                                    res.forEach(stores => {
                                        store_ids.push(`${stores.store}`);
                                    });
                            
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

                                    res.forEach(det => {
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

                                        formattedData.push(newData)
                                    })
                                }
                            )
                        }
                    }
                }
        )

        const headerData = [
            ["Company Name: Lifestrong Marketing Inc."],
            ["VMI"],
            ["Date Printed: " + formatDate(new Date())],
            [""],
        ];
    
        exportArrayToCSV(formattedData, `VMI - ${formatDate(new Date())}`, headerData);
    }

    // function delete_data(company, year, month, week) 
    function delete_data(company, year, week) 
    {
        modal.confirm(confirm_delete_message,function(result){
            if(result){ 
                var url = "<?= base_url('cms/global_controller');?>";
                var formattedData = [];
                let filterArr = []
                filterArr.push(`c.name:EQ=${company}`);
                filterArr.push(`y.year:EQ=${year}`);
                // filterArr.push(`m.month:EQ=${month}`);
                filterArr.push(`w.name:EQ=${week}`);

                let filter = filterArr.join(',')

                dynamic_search(
                    "'tbl_vmi v'", 
    
                    "'left join tbl_company c on v.company = c.id "+
                    "left join tbl_year y on v.year = y.id "+
                    // "left join tbl_month m on v.month = m.id "+
                    "left join tbl_week w on v.week = w.id'", 
    
                    "'v.id'", 
    
                    0, 
                    0, 
                    `'${filter}'`,  
                    `''`, 
                    `''`,
                    (res) => {
                        const conditions = [
                            { field: "year", values: [year] },
                            { field: "company", values: [company] },
                            // { field: "month", values: [month] },
                            { field: "week", values: [week] }
                        ];

                        batch_delete_with_conditions(url, "tbl_vmi", conditions, function(resp) {
                            modal.alert("Selected records deleted successfully!", 'success', () => location.reload());
                        });

                    }
                );
            }
        });
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