<style>
    @media (min-width: 1200px) {
        .modal-xxl {
            max-width: 95%;
        }
    }
</style>

<div class="content-wrapper p-4">
    <div class="card">
        <div class="text-center page-title md-center">
            <b>N E W F I L E</b>
        </div>

        <div class="justify-content-end">
            <label for="file" class="custom-file-upload save" style="margin-left:10px; margin-top: 10px; margin-bottom: 10px">
                <i class="fa fa-file-import" style="margin-right: 5px;"></i>Custom Upload
            </label>
            <input
                type="file"
                style="padding-left: 10px;"
                id="file"
                accept=".xls,.xlsx,.csv"
                aria-describedby="import_files"
            >
    
            <label 
                for="process_file" 
                class="custom-file-upload save" 
                style="margin-left:10px; margin-top: 10px; margin-bottom: 10px"
                onclick="read_xl_file()"
            >
                <i class="fa fa-sync" style="margin-right: 5px;"></i>Process File
            </label>

            <label 
                for="process_file" 
                class="custom-file-upload save" 
                style="margin-left:10px; margin-top: 10px; margin-bottom: 10px"
                onclick="process_xl_file()"
            >
                <i class="fa fa-save" style="margin-right: 5px;"></i>Validate then Save
            </label>

            <label 
                for="create_template" 
                class="custom-file-upload save" 
                style="margin-left:10px; margin-top: 10px; margin-bottom: 10px"
                onclick="create_template()"
            >
                <i class="fa fa-plus" style="margin-right: 5px;"></i>Create Template
            </label>
        </div>

        <div class="card-body text-center">
            <div style="height: 500px; overflow-y: auto; border: 1px solid #ddd;">
                <table class="table table-bordered listdata" style="width: 100%;">
                    <thead class="table-header">
                        <tr>
                            <th class='center-content'>Line #</th>
                            <th class='center-content'>Store Code</th>
                            <th class='center-content'>Store Description</th>
                            <th class='center-content'>Item Code</th>
                            <th class='center-content'>Item Description</th>
                            <th class='center-content'>Gross Sales</th>
                            <th class='center-content'>Quantity</th>
                            <th class='center-content'>Net Sales</th>
                        </tr>
                    </thead>
                    <tbody class="word_break import_table"></tbody>
                </table>
            </div>
    
            <div class="import_pagination"></div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="template_list_modal">
    <div class="modal-dialog modal-xxl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">
                    <b>Create Template</b>
                </h1>
            </div>

            <div class="modal-body">
                <button type="button" class="btn save mb-4" onclick="add_template()">Add Template</button>
                <table class="table table-bordered listdata" style="width: 100%;">
                    <thead class="table-header">
                        <tr>
                            <th class='center-content'>Import File Code</th>
                            <th class='center-content'>File Type</th>
                            <th class='center-content'>First Line Header</th>
                            <th class='center-content'>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="word_break"></tbody>
                </table>
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn caution" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="template_modal">
    <div class="modal-dialog modal-xxl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">
                    <b>Template</b>
                </h1>
            </div>

            <div class="modal-body">
                <form id="form-modal">
                    <div class="card">
                        <div class="px-3 my-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="file_code" class="form-label">Import File Code</label>
                                    <input type="text" class="form-control required" id="file_code" aria-describedby="payment_group">
                                </div>

                                <div class="col-md-6">
                                    <label for="file_type" class="form-label">File Type</label>
                                    <input type="text" class="form-control required" id="file_type" aria-describedby="payment_group">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="pay_grp" class="form-label">Customer Payment Group</label>
                                    <input type="text" class="form-control required" id="pay_grp" aria-describedby="payment_group">
                                </div>
    
                                <div class="col-md-6">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <input type="text" class="form-control required" id="remarks" aria-describedby="payment_group">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="line_head" class="form-label">First Line is header</label>
                                    <input type="text" class="form-control required" id="line_head" aria-describedby="payment_group">
                                </div>

                                <div class="col-md-6">
                                    <label for="col_count" class="form-label">Template Column Count</label>
                                    <input type="text" class="form-control required" id="col_count" aria-describedby="payment_group">
                                </div>
                            </div>

                            <small>
                                <span style="color: red;">Note: </span>
                                If the header is not on the first line of the import file, specify the exact
                                row number where the header is located
                            </small>
                        </div>
                    </div>

                    <div class="card">
                        <table class="table table-bordered listdata" style="width: 100%;">
                            <thead class="table-header">
                                <tr>
                                    <th class='center-content'>Column No.</th>
                                    <th class='center-content'>Column Header</th>
                                    <th class='center-content'>Caption (Import File Header)</th>
                                    <th class='center-content'>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="word_break">
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
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

    function clear_import_table() {
        $(".import_table").empty()
    }

    async function read_xl_file() {
        let btn = $(".btn.save");
        btn.prop("disabled", false);
        clear_import_table();
        delete_temp_data()

        dataset = [];

        const file = $("#file")[0].files[0];

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
            formData.append("header_id", "1");
            formData.append("month", "3");
            formData.append("year", "2025");
            formData.append("customer_payment_group", "Watsons Personal Inc");
            formData.append("template_id", "1");

            try {
                let response = await fetch("<?= base_url('cms/newfile/import-temp-scan-data'); ?>", {
                    method: "POST",
                    body: formData
                });
                let data = await response.json();
            } catch (error) {
                console.error("Upload error:", error);
                modal.alert("Upload error, please try again.", "error");
            }
        }
        
        if (!file) {
            modal.loading_progress(false);
            modal.alert('Please select a file to upload', 'error', () => {});
            return;
        }

        const maxFileSize = 30 * 1024 * 1024; // 30MB limit
        if (file.size > maxFileSize) {
            modal.loading_progress(false);
            modal.alert('The file size exceeds the 30MB limit. Please upload a smaller file.', 'error', () => {});
            return;
        }

        modal.loading_progress(true, "Reviewing Data...");

        const reader = new FileReader();
        reader.onload = function(e) {
            const data = e.target.result;

            // Read as binary instead of plain text
            const workbook = XLSX.read(data, { type: "binary", raw: true });
            const sheet = workbook.Sheets[workbook.SheetNames[0]];

            // User-defined number of rows to skip at the top
            const skipRows = 5; // Adjust this value
            
            // User-defined number of rows to ignore from the bottom
            const ignoreRows = 1; // Adjust this value

            let jsonData = XLSX.utils.sheet_to_json(sheet, { 
                raw: true, 
                range: skipRows // This skips the first `skipRows` rows
            });

            // Remove the last `ignoreRows` rows
            if (ignoreRows > 0) {
                jsonData = jsonData.slice(0, jsonData.length - ignoreRows);
            }

            // Ensure special characters like "ñ" are correctly preserved
            jsonData = jsonData.map(row => {
                let fixedRow = {};
                let count = 0;
                Object.keys(row).forEach(key => {
                    let value = row[key];

                    if (typeof value === "number") {
                        value = String(value);
                    }

                    fixedRow[count] = value !== null && value !== undefined ? value : "";

                    count += 1;
                });
                return fixedRow;
            });

            processInChunks(jsonData, 5000, () => {
                paginateData(rowsPerPage);
            });
        };

        // Use readAsBinaryString instead of readAsText
        reader.readAsBinaryString(file);
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
            
            let selected_td = [0, 1, 2, 3, 4, 5, 6]
            $.each(selected_td, (x, y) => {
                if (selected_td.includes(y)) {
                    html += `<td>${lowerCaseRecord[y] !== undefined ? lowerCaseRecord[y] : ""}</td>`;
                }
            })

            html += "</tr>";
            
            tr_counter += 1;
        });

        modal.loading(false);
        $(".import_table").html(html);
        updatePaginationControls();
    }

    function updatePaginationControls() {
        let paginationHtml = `
        <button onclick="firstPage()" ${currentPage === 1 ? "disabled" : ""}>
            <i class="fas fa-angle-double-left"></i>
        </button>
        <button onclick="prevPage()" ${currentPage === 1 ? "disabled" : ""}>
            <i class="fas fa-angle-left"></i>
        </button>
        
        <select onchange="goToPage(this.value)">
            ${Array.from({ length: totalPages }, (_, i) => 
                `<option value="${i + 1}" ${i + 1 === currentPage ? "selected" : ""}>Page ${i + 1}</option>`
            ).join('')}
        </select>
        
        <button onclick="nextPage()" ${currentPage === totalPages ? "disabled" : ""}>
            <i class="fas fa-angle-right"></i>
        </button>
        <button onclick="lastPage()" ${currentPage === totalPages ? "disabled" : ""}>
            <i class="fas fa-angle-double-right"></i>
        </button>
        `;

        $(".import_pagination").html(paginationHtml);
        modal.loading_progress(false);
    }

    function process_xl_file() {
        const file = $("#file")[0].files[0];
        let file_name = file.name;

        modal.loading(true, "Fetching all data from temporary table...");

        let allData = [];

        function fetchAllPages(page = 0) {
            console.log(page, 'page')
            $.ajax({
                url: "<?= base_url('cms/newfile/fetch-temp-scan-data'); ?>",
                method: "GET",

                data: { page, limit: 1000, file_name}, // Fetch in larger chunks
                success: function(response) {
                    console.log(response.data, 'response.data')
                    allData = allData.concat(response.data);
                    if (response.data.length === 1000) {
                        fetchAllPages(page + 1000);
                    } 
                    else {
                        console.log(allData.length, 'allData.length')
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

    function validate_temp_data(data) {
        let worker = new Worker(base_url + "assets/cms/js/validator_newfile.js");
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

                // createErrorLogFile(errorLogs, `Error_${formatReadableDate(new Date(), true)}`);
            } else if (Array.isArray(valid_data) && valid_data.length > 0) { 
                let new_data = valid_data.map(record => ({
                    ...record
                }));

                console.log(valid_data.length, 'valid_data.length')
                console.log(new_data.length, 'new_data.length')
                saveValidatedData(new_data);
            } else {
                modal.alert("No valid data found. Please check the file.", "error");
            }
        }
    }

    function createErrorLogFile() {
        alert('createErrorLogFile')
    }

    function saveValidatedData(valid_data) {
        let batch_size = 1000;
        let total_batches = Math.ceil(valid_data.length / batch_size);
        let batch_index = 0;
        let errorLogs = [];
        let url = "<?= base_url('cms/global_controller');?>";
        let table = 'tbl_sell_out_data_details_copy';

        function processNextBatch() {
            if (batch_index >= total_batches) {
                console.log("All batches processed.", batch_index, total_batches);
                modal.loading_progress(false);
                delete_temp_data()
                modal.alert("All records saved/updated successfully!", 'success', () => {
                    location.reload()
                });
                return;
            }

            let batch = valid_data.slice(batch_index * batch_size, (batch_index + 1) * batch_size);
            let newRecords = [...batch]; // Avoid modifying the original array

            function processInserts() {
                return new Promise((resolve) => {
                    if (newRecords.length > 0) {
                        batch_insert(url, newRecords, table, false, (response) => {
                            console.log(`Batch ${batch_index + 1} processed.`, total_batches);

                            if (response.message === 'success') {
                                updateSwalProgress("Inserting Records...", batch_index + 1, total_batches);
                            } else {
                                errorLogs.push(`Batch insert failed: ${JSON.stringify(response.error)}`);
                            }
                            
                            resolve();  // Ensure promise is resolved
                        });
                    } else {
                        resolve(); // Resolve even for empty batches
                    }
                });
            }

            processInserts()
                .then(() => {
                    batch_index++; // Move to next batch
                    setTimeout(processNextBatch, 300);
                })
                .catch(error => {
                    errorLogs.push(`Unexpected error: ${error}`);
                    batch_index++; // Ensure it moves forward even on error
                    processNextBatch();
                });
        }

        setTimeout(processNextBatch, 1000);
    }

    function delete_temp_data() {
        const file = $("#file")[0].files[0];
        let file_name = file.name;

        $.ajax({
            url: "<?= base_url('cms/newfile/delete-temp-scan-data'); ?>",
            type: "POST",
            data: { 
                action: "delete_temp_records",
                file_name: file_name
            },
            success: function (response) {
                console.log(response)
            },
            error: function (xhr, status, error) {
            }
        });
    }

    function create_template() {
        $('#template_list_modal').modal('show');
        list_templates()
    }

    var url = "<?= base_url('cms/global_controller');?>";
    function list_templates() {
        // dynamic_search(tbl_name, join, table_fields, limit, offset, conditions, order, group, callback)
        console.log(url)
        dynamic_search(
            "'tbl_sell_out_template_header'", 
            "''", 
            "'id, import_file_code, file_type, line_header'", 
            10, 
            0, 
            "''", 
            "''", 
            "''", 
            (res) => {
                let html = "";
                res.forEach(template => {
                    html+='<tr>';
                    html+=`<td scope=\"col\">${template.import_file_code}</td>`;
                    html+=`<td scope=\"col\">${template.file_type}</td>`;
                    html+=`<td scope=\"col\">${template.line_header}</td>`;
                    html+=`<td class='center-content' style='width: 20%;'>`;
                    html+="<a class='btn-sm btn save' onclick=\"load_template("+template.id+", 'edit')\" title='Edit Item'><span class='glyphicon glyphicon-pencil'>Edit</span>";
                    html+="<a class='btn-sm btn view' onclick=\"load_template("+template.id+", 'view')\" title='View Item'><span class='glyphicon glyphicon-pencil'>Inquire</span>";
                    html+="<a class='btn-sm btn delete' onclick=\"delete_template()\" title='Delete Item'><span class='glyphicon glyphicon-pencil'>Delete</span>";
                    html+=`</td>`
                    html+='</tr>';
                });

                $('#template_list_modal tbody').html(html)
            }
        )
    }

    function load_template(id, view) {
        function load_template_details(data) {
            $('#template_list_modal').modal('hide');

            let readonly = '';
            let disabled = '';
            if (view === 'view') {
                readonly = 'readonly';
                disabled = 'disabled';
            }
            else {
                let readonly = '';
                let disabled = '';
            }

            let html = "";
            data.forEach(item => {
                html+='<tr>';
                html+=
                `<td style="text-align: center; vertical-align: middle;">
                    <input type="text" class="form-control required" value="${item.column_number}" ${readonly} ${disabled}>
                </td>`;

                html+=
                `<td>
                    <select name="headers" id="headers" class="form-control required" ${readonly} ${disabled}>
                        <option id="0" value="" ${item.column_header == 0 ? "selected" : ""}></option>
                        <option id="1" value="storecode" ${item.column_header == 1 ? "selected" : ""}>Store Code</option>
                        <option id="2" value="storedesc" ${item.column_header == 2 ? "selected" : ""}>Store Description</option>
                        <option id="3" value="skucode" ${item.column_header == 3 ? "selected" : ""}>SKU Code</option>
                        <option id="4" value="skudesc" ${item.column_header == 4 ? "selected" : ""}>SKU Description</option>
                        <option id="5" value="qty" ${item.column_header == 5 ? "selected" : ""}>Quantity</option>
                        <option id="6" value="netsales" ${item.column_header == 6 ? "selected" : ""}>Net Sales</option>
                        <option id="7" value="grosssales" ${item.column_header == 7 ? "selected" : ""}>Gross Sales</option>
                    </select>
                </td>`;

                html+=
                `<td>
                    <input type="text" class="form-control required" value="${item.file_header}" ${readonly} ${disabled}>
                </td>`

                html+=`<td class='center-content' style='width: 5%;'>`;
                html+=`<button type="button" class="btn-sm btn delete" onclick=delete_row(${item.column_header}) ${readonly} ${disabled}>Delete</button>`
                html+=`</td>`

                html+='</tr>';
            });
            $('#template_modal tbody').html(html)
            $('#template_modal').modal('show');
        }
        dynamic_search(
            "'tbl_sell_out_template_details'", 
            "''", 
            "'id, column_header, column_number, file_header'", 
            0, 0, 
            "'template_header_id:EQ="+id+"'", 
            "''", 
            "''", 
            load_template_details
        );

        function load_template_headers(data) {
            console.log(data[0], 'data')
            let head = data[0]

            if (view === 'view') {
                $("#file_code, #file_type, #pay_grp, #remarks, #line_head, #col_count")
                    .prop('disabled', true)   // Disables the fields
                    .prop('readonly', true);  // Makes them read-only
            } else {
                $("#file_code, #file_type, #pay_grp, #remarks, #line_head, #col_count")
                    .prop('disabled', false)   // Disables the fields
                    .prop('readonly', false);  // Makes them read-only
            }

            $("#file_code").val(head.import_file_code)
            $("#file_type").val(head.file_type)
            $("#pay_grp").val(head.customer_payment_group)
            $("#remarks").val(head.remarks)
            $("#line_head").val(head.line_header)
            $("#col_count").val(head.template_column_count)
        }

        dynamic_search(
            "'tbl_sell_out_template_header'", 
            "''", 
            "'id, import_file_code, file_type, template_column_count, line_header, customer_payment_group, remarks'", 
            1, 0, 
            "'id:EQ="+id+"'", 
            "''", 
            "''", 
            load_template_headers
        );
    }

    function delete_row(id) {
        console.log(id, 'delete row')
    }

</script>