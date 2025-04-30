<style>
    @media (min-width: 1200px) {
        .modal-xxl {
            max-width: 95%;
        }
    }

    .uniform-dropdown {
        height: 36px;
        font-size: 14px;
        border-radius: 5px;
        min-width: 120px; 
        flex-grow: 1; 
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
            <b>WEEK on WEEK SALES</b>
        </div>

        <div class="card-body text-center mx-3 my-3">
            <?php
                echo view("cms/layout/buttons",$buttons);

                $optionSet = '';
                foreach($pageOption as $pageOptionLoop) {
                    $optionSet .= "<option value='".$pageOptionLoop."'>".$pageOptionLoop."</option>";
                }
            ?>

            <table class="table">
                <thead>
                    <tr>
                        <th class='center-content'>Import Date</th>
                        <th class='center-content'>Import File Name</th>
                        <th class='center-content'>Imported By</th>
                        <th class='center-content'>Year</th>
                        <th class='center-content'>Week</th>
                        <th class='center-content'>Actions</th>
                    </tr>
                </thead>
                <tbody class="table_body word_break">
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="add_wk_on_wk_modal">
    <div class="modal-dialog modal-xxl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">
                    <b>Import Week on Week Sales</b>
                </h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card p-3">
                    <div class="mb-3">
                        <div class="text-center p-2" 
                            style="font-family: 'Courier New', Courier, monospace; font-size: large; background-color: #fdb92a; 
                            color: #333333; border-radius: 10px;">
                            <b>Extracted Data</b>
                        </div>

                        <div class="row my-3">
                            <div class="col-md-8 import_buttons">
                                <label for="file" class="btn btn-warning mt-2" style="margin-bottom: 0px;">
                                    <i class="fa fa-file-import my-32"></i> Custom Upload
                                </label>
                                <input type="file" id="file" accept=".xls,.xlsx,.csv" style="display: none;" 
                                onclick="clear_import_table()">

                                <button class="btn btn-primary mt-2" id="preview_xl_file" onclick="read_xl_file()">
                                    <i class="fa fa-sync my-32"></i> Preview Data
                                </button>

                                <button class="btn btn-success mt-2" id="download_template" onclick="download_template()">
                                    <i class="fa fa-file-download my-32"></i> Download Import Template
                                </button>
                            </div>

                            <div class="col-md-4">
                                <div class="card p-4 shadow-lg rounded-3 border-0" style="background: #f8f9fa;">
                                    <div class="row g-3">
                                        <div class="col-12 d-flex align-items-center">
                                            <label for="year" class="ml-2 form-label fw-semibold my-2">Choose Year:</label>
                                            <select id="year" class="ml-2 form-select uniform-dropdown">
                                            </select>
                                        </div>
                                        <div class="col-12 d-flex align-items-center mt-2">
                                            <label for="week" class="ml-2 form-label fw-semibold my-2">Choose Week:</label>
                                            <select id="week" class="ml-2 form-select uniform-dropdown" onfocus="updateWeeks()">
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
                                        <th>Item</th>
                                        <th>Item Name</th>
                                        <th>Label Type</th>
                                        <th>Status</th>
                                        <th>Item Class</th>
                                        <th>POG Store</th>
                                        <th>Quantity</th>
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

<script>
    let currentPage = 1;
    let rowsPerPage = 1000;
    let totalPages = 1;
    let dataset = [];
    var query = "a.status >= 0";
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url('cms/global_controller');?>";
    let years = <?= json_encode($year) ?>;
    const currentYear = new Date().getFullYear();

    $(document).ready(function() {
        get_data(query);
        get_pagination(query);
        populateDropdown('year', years, 'year', 'id')
    })

    const get_data = (query) => {
        var data = {
            event : "list",
            select : "a.id, b.year, c.username, a.created_date, a.week, a.file_name",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_week_on_week_header as a",
            join : [
                {
                    table : "tbl_year as b",
                    query : "a.year = b.id",
                    type : "left"
                },
                {
                    table : "cms_users as c",
                    query : "a.created_by = c.id",
                    type : "left"
                },
            ],
            order : {
                field : "a.year",
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
                        var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";

                        html += "<tr class='" + rowClass + "'>";
                        html += "<td scope=\"col\">" + y.created_date + "</td>";
                        html += "<td scope=\"col\">" + y.file_name + "</td>";
                        html += "<td scope=\"col\">" + y.username + "</td>";
                        html += "<td scope=\"col\">" + y.year + "</td>";
                        html += "<td scope=\"col\">" + y.week + "</td>";

                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                          html+="<td class='center-content' style='width: 25%'>";

                          html+="<a class='btn-sm btn save' onclick=\"export_data('"
                          +y.id+"')\" data-status='"
                          +y.status+"' id='"
                          +y.id+"' title='Export Details'><span class='glyphicon glyphicon-pencil'>Export</span>";

                          html+="<a class='btn-sm btn view' onclick=\"print_data('"
                          +y.id+"')\" data-status='"
                          +y.status+"' id='"
                          +y.id+"' title='Print Details'><span class='glyphicon glyphicon-pencil'>Print</span>";

                          html+="<a class='btn-sm btn delete' onclick=\"delete_data('"
                          +y.id+"')\" data-status='"
                          +y.status+"' id='"
                          +y.id+"' title='Delete Details'><span class='glyphicon glyphicon-pencil'>Delete</span>";

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

    const get_pagination = (query) => {
        var data = {
          event : "pagination",
            select : "a.id",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_week_on_week_header as a",
            order : {
                field : "a.year",
                order : "desc" 
            }

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
            var new_query = `${query} AND (
                b.year LIKE '%${keyword}%' OR 
                c.username LIKE '%${keyword}%' OR 
                a.created_date LIKE '%${keyword}%' OR 
                a.week LIKE '%${keyword}%' OR 
                a.file_name LIKE '%${keyword}%'
            )`
            get_data(new_query);
            get_pagination(query);
        }
    });

    function export_data(id) {
        modal.confirm(confirm_export_message,function(result){
            if (result) {
                modal.loading_progress(true, "Reviewing Data...");
                setTimeout(() => {
                    handleExport(id, 'xlsx')
                }, 500);
            }
        })
    }

    function handleExport(id, output) {
        if (output == 'xlsx') {
            let formattedData = [];
            const processResponse = (res) => {
                console.log(res, res[0].id)
    
                table = 'tbl_week_on_week_details';
                join = '';
                fields = 'COUNT(id) checker';
                limit = 0;
                offset = 0;
                filter = `header_id:EQ=${id}`;
                order = '';
                group = '';
                dynamic_search(`'${table}'`,`'${join}'`,`'${fields}'`,`${limit}`,`${offset}`,`'${filter}'`, `'${order}'`,`'${group}'`,
                    (res1) => {
                        console.log(res1[0].checker)
                        for (let index = 0; index < res1[0].checker; index += 100000) {
                            table = 'tbl_week_on_week_details';
                            join = '';
                            fields = 'item, item_class, label_type, status, item_class, pog_store, quantity';
                            limit = 100000;
                            offset = index;
                            filter = `header_id:EQ=${id}`;
                            order = '';
                            group = '';
                            dynamic_search(`'${table}'`,`'${join}'`,`'${fields}'`,`${limit}`,`${offset}`,`'${filter}'`, `'${order}'`,`'${group}'`,
                                (res2) => {
                                    console.log(res2)
                                    res2.forEach(item => {
                                        let newData = {
                                            "Item": item.item,
                                            "Item Class": item.item_class,
                                            "Label Type": item.label_type,
                                            "Status": item.status,
                                            "Item Class": item.item_class,
                                            "POG Store": item.pog_store,
                                            "Quantity": item.quantity,
                                        }
                                        formattedData.push(newData);
                                    })
                                }
                            )
                        }
                    }
                )
    
                const headerData = [
                    ["Year: ", res[0].year],
                    ["Week: ", res[0].week],
                    ["Import Date: ", res[0].created_date],
                    ["Import File Name: ", res[0].file_name],
                    ["Date Printed: ", formatDate(new Date())],
                    [""],
                ];
            
                exportArrayToCSV(formattedData, `Sales File (${res[0].file_name})- ${formatDate(new Date())}`, headerData);
                modal.loading_progress(false);
            }
    
            table = 'tbl_week_on_week_header a';
            join = 'LEFT JOIN tbl_year b on a.year = b.id left join cms_users c on a.created_by = c.id';
            fields = 'a.id, b.year, c.username, a.created_date, a.week, a.file_name';
            limit = 1;
            offset = 0;
            filter = `a.id:EQ=${id}`;
            order = '';
            group = '';
            dynamic_search(`'${table}'`,`'${join}'`,`'${fields}'`,`${limit}`,`${offset}`,`'${filter}'`, `'${order}'`,`'${group}'`,
                processResponse
            )
        } else {
            window.location.href = "<?= base_url('cms/import-week-on-week/print-temp-wkonwk-data'); ?>?selected_id=" + id;
            modal.loading_progress(false);
        }
    }
    
    function print_data(id) {
        modal.confirm(confirm_export_message,function(result){
            if (result) {
                modal.loading_progress(true, "Reviewing Data...");
                setTimeout(() => {
                    handleExport(id, 'pdf')
                }, 500);
            }
        })
    }
    
    function delete_data(id) {
        modal.confirm(confirm_delete_message,function(result){
            if (result) {
                modal.loading_progress(true, "Reviewing Data...");
                setTimeout(() => {
                    var url = "<?= base_url('cms/global_controller');?>";
                    var data = {
                        event : "update",
                        table : "tbl_week_on_week_header",
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
                }, 500);
            }
        })
    }

    function updateWeeks() {
        let selectedYear = $('#year option:selected').text()
        populateDropdown('week', getCalendarWeeks(selectedYear), 'display', 'id');
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

    $("#btn_add").click(() => {
        $("#add_wk_on_wk_modal").modal('show')
    })

    const populateDropdown = (selected_class, result, textKey = 'name', valueKey = 'id') => {
        let html = '<option id="default_val" value=" ">Select</option>';

        if (result && result.length > 0) {
            result.forEach((item) => {
                html += `<option value="${item[valueKey]}">${item[textKey]}</option>`;
            });
        }

        $('#' + selected_class).html(html);
    };

    const clear_import_table = () => {
        $(".import_table").empty();
    }

    const delete_temp_data = () => {
        const file = $("#file")[0].files[0];
        let file_name = file.name;

        $.ajax({
            url: "<?= base_url('cms/import-week-on-week/delete-temp-wkonwk-data'); ?>",
            type: "POST",
            data: { 
                action: "delete_temp_records",
                file_name: file_name,
                year : $("#year").val(),
                week: $("#week").val(),
            },
            success: function (response) { console.log(response) },
            error: function (xhr, status, error) { console.log(xhr, status, error) }
        });
    }

    const read_xl_file = async () => {
        const file = $("#file")[0].files[0];
        const year = $("#year").val();
        const week = $("#week").val();

        if (!file) {
            modal.loading_progress(false);
            modal.alert('Please select a file to upload', 'error', () => {});
            return;
        }

        if (!year || !week) {
            modal.loading_progress(false);
            modal.alert(`Month and Week are required fields.`, 'error', () => {});
            return;
        }

        clear_import_table();
        delete_temp_data();

        dataset = [];

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
            formData.append("year", $("#year").val());
            formData.append("week", $("#week").val());

            try {
                let response = await fetch("<?= base_url('cms/import-week-on-week/import-temp-wkonwk-data'); ?>", {
                    method: "POST",
                    body: formData
                });
                let data = await response.json();
            } catch (error) {
                modal.alert("Upload error, please try again.", "error");
            }

            let progress = Math.round(((chunkIndex + 1) / totalChunks) * 100);
            updateSwalProgress("Preview Data", progress);
        }

        fetchPaginatedData();
        modal.loading_progress(false);
    }

    const fetchPaginatedData = () => {
        const file = $("#file")[0].files[0];
        let file_name = file.name;
        modal.loading(true);
        $.ajax({
            url: "<?= base_url('cms/import-week-on-week/fetch-temp-wkonwk-data'); ?>",
            method: "GET",
            data: {
                page: currentPage,
                limit: rowsPerPage,
                file_name: file_name,
                year: $("#year").val(),
                week: $("#week").val(),
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

    const display_imported_data = (paginatedData) => {
        let html = "";
        let tr_counter = (currentPage - 1) * rowsPerPage;

        paginatedData.forEach(row => {
            let rowClass = (tr_counter % 2 === 0) ? "even-row" : "odd-row";
            html += `<tr class="${rowClass}">`;

            let lowerCaseRecord = Object.keys(row).reduce((acc, key) => {
                acc[key.toLowerCase()] = row[key];
                return acc;
            }, {});

            let td_validator = ['line_number','item', 'item_name', 'label_type', 'status', 'item_class', 'pog_store', 'quantity'];
            td_validator.forEach(column => {
                let value = "";
                if (column == 'line_number') {
                    value = lowerCaseRecord[column] !== undefined ? lowerCaseRecord[column] - 3 : "";
                } else {
                    value = lowerCaseRecord[column] !== undefined ? lowerCaseRecord[column] : "";
                }

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

    const updatePaginationControls = () => {
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

    const changePage = (offset) => {
        if ((offset === -1 && currentPage > 1) || (offset === 1 && currentPage < totalPages)) {
            currentPage += offset;
            fetchPaginatedData();
        }
    }

    function goToPage(page){
        page = parseInt(page);
        if (page >= 1 && page <= totalPages) {
            currentPage = page;
            fetchPaginatedData();
        }
    }

    const download_template = () => {
        let formattedData = [
            {
                "ITEM":"", 
                "ITEM NAME":"", 
                "LABEL TYPE":"", 
                "VSTATUS":"", 
                "ITEM CLASS":"", 
                "HOLD REASON CODE":"", 
                "POG STORES":"", 
                "YYYYWW":"", 
                "NOTE:": "For column header: YYYYWW"
            },
            {
                "ITEM":"", 
                "ITEM NAME":"", 
                "LABEL TYPE":"", 
                "VSTATUS":"", 
                "ITEM CLASS":"", 
                "HOLD REASON CODE":"", 
                "POG STORES":"", 
                "YYYYWW":"", 
                "NOTE:": "Please remember to change the column header to reflect the year and the week (eg. 202401, 202402)."
            },
            {
                "ITEM":"", 
                "ITEM NAME":"", 
                "LABEL TYPE":"", 
                "VSTATUS":"", 
                "ITEM CLASS":"", 
                "HOLD REASON CODE":"", 
                "POG STORES":"", 
                "YYYYWW":"", 
                "NOTE:": "Please remember to delete these notes before processing the data."
            },
            {
                "ITEM":"", 
                "ITEM NAME":"", 
                "LABEL TYPE":"", 
                "VSTATUS":"", 
                "ITEM CLASS":"", 
                "HOLD REASON CODE":"", 
                "POG STORES":"", 
                "YYYYWW":"", 
                "NOTE:": "Thank you!"
            }
        ]
        const headerData = [
            [""],
            [""],
            [""],
        ];
    
        exportArrayToCSV(formattedData, `Week on Week Sales Import Data - ${formatDate(new Date())}`, headerData);
    }

    const exportArrayToCSV = (data, filename, headerData) => {
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

    const process_xl_file = () => {
        const file = $("#file")[0].files[0];

        if (!file) {
            modal.loading_progress(false);
            modal.alert('Please select a file to upload', 'error', () => {});
            return;
        }

        let file_name = file.name;
        let year = $("#year").val();
        let week = $("#week").val();

        if (!year || !week) {
            modal.loading_progress(false);
            modal.alert(`Month and Week are required fields.`, 'error', () => {});
            return;
        }

        check_current_db(
            "tbl_week_on_week_header", 
            ["year", "week", "file_name"], 
            [year, week, file_name], 
            "id" , 
            null, 
            null,
            false, 
            function(exists, duplicateFields) {
                console.log(exists, duplicateFields)
                if (!exists) {
                    modal.loading(true, "Fetching all data from temporary table...");

                    let allData = [];

                    function fetchAllPages(page = 1) {
                        $.ajax({
                            url: "<?= base_url('cms/import-week-on-week/fetch-temp-wkonwk-data'); ?>",
                            method: "GET",

                            data: { page, limit: 5000, file_name, year, week}, // Fetch in larger chunks
                            success: function(response) {
                                allData = allData.concat(response.data);
                                if (response.data.length === 5000) {
                                    fetchAllPages(page + 1);
                                } 
                                else {
                                    validate_temp_data(allData)
                                }
                            },
                            error: function(xhr) {
                                modal.loading(false);
                                modal.alert("Error fetching data: " + xhr.responseText, "error");
                            }
                        });
                    }

                    fetchAllPages()
                }
            }
        )
    }

    const validate_temp_data = (data) => {
        let worker = new Worker(base_url + "assets/cms/js/validator_wkonwk.js");
        worker.postMessage({ data, base_url });

        worker.onmessage = function(e) {
            const { invalid, errorLogs, valid_data, err_counter } = e.data;

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
                    ...record
                }));

                saveHeaderData(function(header_id) {
                    saveValidatedData(valid_data, header_id);
                });
            } else {
                modal.alert("No valid data found. Please check the file.", "error");
            }
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

    const saveHeaderData = (callback) => {
        const file = $("#file")[0].files[0];
        let file_name = file.name;

        let data = {
            year: $("#year").val(),
            week: $("#week").val(),
            created_date: formatDate(new Date()),
            created_by: '<?=$session->sess_uid;?>',
            file_name: file_name,
            status: 1
        };

        let payload = {
            event: "insert",
            table: "tbl_week_on_week_header",
            data: data
        };

        aJax.post(url, payload, function (result) {
            var obj = is_json(result);

            // Invoke callback with header ID
            if (callback && typeof callback === "function") {
                callback(obj.ID);
            }
        });
    }

    const saveValidatedData = (valid_data, data_header_id) => {
        let batch_size = 5000;
        let total_batches = Math.ceil(valid_data.length / batch_size);
        let batch_index = 0;
        let errorLogs = [];
        let url = "<?= base_url('cms/global_controller');?>";
        let table = 'tbl_week_on_week_details';

        let selected_fields = [
            'id', 'header_id', 'file_name', 'line_number', 'item', 'item_name', 'label_type', 'status', 'item_class', 'pog_store', 'quantity'
        ];

        const matchFields = [
            'header_id', 'file_name', 'line_number', 'item', 'item_name', 'label_type', 'status', 'item_class', 'pog_store', 'quantity'
        ];  

        const filters = [
            '2025',
            '3'
        ];  

        const matchType = "AND";  // Use "AND" or "OR" for matching logic

        modal.loading_progress(true, "Validating and Saving data...");
        let existingMap = new Map();
        aJax.post(url, { table: table, event: "fetch_existing_new", selected_fields: selected_fields, filters:filters}, function(response) {
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
                        modal.loading_progress(true, "Finishing data...");
                        delete_temp_data();
                        setTimeout(function(){
                            modal.alert("All records saved/updated successfully!", 'success', () => {
                                let href = "<?= base_url() ?>" + "cms/import-week-on-week/";
                                window.location.href = href;
                            });
                        }, 1000);
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
                                    break; 
                                }
                            }
                            if (matchedId) break;
                        }
                    }

                    if (matchedId) {
                        row.id = matchedId;
                        updateRecords.push(row);
                    } else {
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
                            newRecords = batch.map(record => ({
                                ...record,
                                header_id: data_header_id,
                                created_date: formatDate(new Date()),
                                created_by: '<?=$session->sess_uid;?>',
                                week: $("#week").val(),
                                year: $("#year").val()
                            }));
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
</script>