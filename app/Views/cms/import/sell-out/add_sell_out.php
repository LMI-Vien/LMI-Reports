<div class="content-wrapper p-4">
    <div class="card">
        <div class="text-center page-title md-center">
            <b>P R O C E S S &nbsp;&nbsp;&nbsp; S E L L O U T &nbsp;&nbsp;&nbsp; D A T A</b>
        </div>

        <div class="card-body">
            <form id="form-modal" class="row">
                <div class="col-md-6">
                    <label for="paygrp" class="form-label">Payment Group</label>
                    <input type="text" class="form-control required" id="paygrp" aria-describedby="paygrp" disabled readonly>
                </div>

                <div class="col-md-6">
                    <label for="month" class="form-label">Month</label>
                    <input type="text" class="form-control required" id="month" aria-describedby="month" disabled readonly>
                </div>

                <div class="col-md-6">
                    <label for="file_code" class="form-label">Import File Group</label>
                    <input type="text" class="form-control required" id="file_code" aria-describedby="file_code" disabled readonly>
                </div>

                <div class="col-md-6">
                    <label for="year" class="form-label">Year</label>
                    <input type="text" class="form-control required" id="year" aria-describedby="year" disabled readonly>
                </div>

                <div class="col-md-12">
                    <label for="remarks" class="form-label">Remarks</label>
                    <input type="text" class="form-control required" id="remarks" aria-describedby="remarks">
                </div>
            </form>

            <div class="row my-3">
                <div class="col-md-2 d-flex justify-content-start">
                    <label for="file" class="custom-file-upload save" style="margin-left:10px; margin-top: 10px; margin-bottom: 10px">
                        <i class="fa fa-file-import" style="margin-right: 5px;"></i>Custom Upload
                    </label>
                    <input
                        type="file"
                        style="padding-left: 10px;"
                        id="file"
                        accept=".xls,.xlsx,.csv,.xml"
                        aria-describedby="import_files"
                    >
                </div>
        
                <div class="col-md-2 d-flex justify-content-start">
                    <label 
                        for="process_file" 
                        class="custom-file-upload save" 
                        style="margin-left:10px; margin-top: 10px; margin-bottom: 10px"
                        onclick="read_xl_file()"
                    >
                        <i class="fa fa-sync" style="margin-right: 5px;"></i>Process File
                    </label>
                </div>

                <div class="col d-flex justify-content-end import_buttons" id="import_buttons">
                    <label 
                        for="process_file" 
                        class="custom-file-upload save" 
                        style="margin-right:10px; margin-top: 10px; margin-bottom: 10px"
                        onclick="process_xl_file()"
                    >
                        <i class="fa fa-save" style="margin-right: 5px;"></i>Validate then Save
                    </label>
                </div>
            </div>

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

<script>
    let currentPage = 1;
    let rowsPerPage = 1000;
    let totalPages = 1;
    let dataset = [];
    var template_id = "<?=$uri->getSegment(4);?>";
    var url = "<?= base_url('cms/global_controller');?>"; 
    let decoded = "";
    let parts = "";
    let months = <?= json_encode($month) ?>;
    let dynamicPlaceholder = null; // global variable
    let companyString = "";

    $(document).ready(function() {
        decoded = decodeURIComponent(template_id);
        parts = decoded.split("-");

        dynamic_search("'tbl_company'", "''", "'name'", 1, 0, "'id:EQ="+parts[0]+"'", "''", "''", (res)=>{
            companyString = res[0].name
        })
        
        $("#paygrp").val(parts[1]);
        dynamic_search("'tbl_month'", "''", "'month'", 1, 0, "'id:EQ="+parts[3]+"'", "''", "''", (res)=>{
            $("#month").val(res[0].month);
        })
        dynamic_search("'tbl_year'", "''", "'year'", 1, 0, "'id:EQ="+parts[2]+"'", "''", "''", (res)=>{
            $("#year").val(res[0].year);
        })
        $("#file_code").val(parts[4]);

        dynamic_search(
            "'tbl_sell_out_template_header as a'", 
            "'left join tbl_sell_out_template_details b on a.id = b.template_header_id'", 
            "'a.line_header, a.end_line_read, b.column_number, b.column_header'", 
            0, 0, 
            "'a.import_file_code:EQ=" + parts[4] + "'", "''", "''", 
            (res) => {
                const mapping = {
                    1: 'store_code',
                    2: 'store_description',
                    3: 'sku_code',
                    4: 'sku_description',
                    5: 'quantity',
                    6: 'net_sales',
                    7: 'gross_sales',
                };

                const placeholder = {
                    start_line_read: parseInt(res[0]?.line_header ?? 1),
                    end_line_read: parseInt(res[0]?.end_line_read ?? 1)
                };

                res.forEach(item => {
                    const field = mapping[parseInt(item.column_header)];
                    if (field) {
                        placeholder[field] = parseInt(item.column_number);
                    }
                });

                Object.values(mapping).forEach(field => {
                    if (!(field in placeholder)) {
                        placeholder[field] = null;
                    }
                });

                dynamicPlaceholder = placeholder;
            }
        );
    })

    async function read_xl_file() {

        let btn = $(".btn.save");
        btn.prop("disabled", false);
        clear_import_table();
        delete_temp_data();

        dataset = [];

        const file = $("#file")[0].files[0];

        if (!file) {
            modal.loading_progress(false);
            modal.alert('Please select a file to upload', 'error', () => {});
            return;
        }

        // Wait until dynamicPlaceholder is ready
        if (!dynamicPlaceholder) {
            modal.alert("Template mapping not ready. Please wait or try again.", "error");
            return;
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
           // formData.append("header_id", "1");
            formData.append("month", getMonthIdByName($("#month").val()));
            formData.append("year", $("#year").val());
            formData.append("customer_payment_group", $('#paygrp').val());
            formData.append("template_id", "1");
            formData.append("placeholder", JSON.stringify(dynamicPlaceholder));

            try {
                let response = await fetch("<?= base_url('cms/import-sell-out/import-temp-scan-data'); ?>", {
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

    function fetchPaginatedData() {
        const file = $("#file")[0].files[0];
        let file_name = file.name;
        modal.loading(true);
        $.ajax({
            url: "<?= base_url('cms/import-sell-out/fetch-temp-scan-data'); ?>",
            method: "GET",
            data: {
                page: currentPage,
                limit: rowsPerPage,
                file_name: file_name
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

    function clear_import_table() {
        $(".import_table").empty()
    }

    function delete_temp_data() {
        const month = getMonthIdByName($("#month").val());
        const year = $("#year").val();

        $.ajax({
            url: "<?= base_url('cms/import-sell-out/delete-temp-scan-data'); ?>",
            type: "POST",
            data: { 
                action: "delete_temp_records",
                month: month,
                year: year
            },
            success: function (response) { },
            error: function (xhr, status, error) { }
        });
    }

    function update_aggregated_data() {
        $.ajax({
            url: "<?= base_url('cms/import-sell-out/update-aggregated-scan-data'); ?>",
            type: "GET",
            success: function (response) { },
            error: function (xhr, status, error) { }
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

            let td_validator = ['store_code', 'store_description', 'sku_code', 'sku_description', 'gross_sales', 'quantity', 'net_sales'];
            td_validator.forEach(column => {
                let value = lowerCaseRecord[column] !== undefined ? lowerCaseRecord[column] : "";

                if (['gross_sales', 'net_sales'].includes(column)) {
                    value = parseFloat(value);
                    value = isNaN(value) ? "" : value.toFixed(2);
                } else if (column === 'quantity') {
                    value = parseFloat(value);
                    value = isNaN(value) ? "" : value.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
                } else if (column === 'status' && typeof value === 'string') {
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

    function process_xl_file() {
        const file = $("#file")[0].files[0];
        let file_name = file.name;

        modal.loading(true, "Fetching all data from temporary table...");

        let allData = [];

        function fetchAllPages(page = 1) {
            $.ajax({
                url: "<?= base_url('cms/import-sell-out/fetch-temp-scan-data'); ?>",
                method: "GET",

                data: { page, limit: 5000, file_name}, // Fetch in larger chunks
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

    function validate_temp_data(data) 
    {
        modal.loading(true, "Validating data...");

        let worker = new Worker(base_url + "assets/cms/js/validator_sell_out.js");
        worker.postMessage({ data, base_url, companyString });

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
                    ...record
                }));
                checkDataSalesPerStore(parts, valid_data);
            } else {
                modal.alert("No valid data found. Please check the file.", "error");
            }
        };

        worker.onerror = function(event) {
            modal.loading_progress(false);
            modal.alert("Error processing data. Please try again.", "error");
        };
    }
    var counter = 0;
    function checkDataSalesPerStore(parts, valid_data) {

        counter++;
        const month = getMonthIdByName($("#month").val());
        const year = $("#year").val();
        const company = parts[0];

        var new_query = `h.month = ${month} AND h.company = ${company} AND h.year = ${year}`;
        new_query += ` AND h.customer_payment_group = '${parts[1]}'`;
        
        const data = {
            event: "list",
            select: "h.created_date, h.year",
            query: new_query,
            offset: 1,
            limit: 1,
            table: "tbl_sell_out_data_header h",
            order: {
                field: "h.id",
                order: "asc"
            },
            group: "h.year, h.month, h.company"
        };

        aJax.post(url, data, function (result) {
            result = is_json(result);

            if(counter ===  1){
                if (result && result.length > 0) {
                    modal.alert("Sellout Data Already Exist!", "error");
                    return;
                }
                saveHeaderData(parts, function (new_header_id, new_headers) {
                    saveValidatedData(valid_data, new_header_id, new_headers);
                });
            }

        });
    }


    function createErrorLogFile(errorLogs, filename) {
        let errorText = errorLogs.join("\n");
        let blob = new Blob([errorText], { type: "text/plain" });
        let url = URL.createObjectURL(blob);

        $(".import_buttons").find("label.download-error-log").remove();

        let $downloadLabel = $("<label>", {
            text: "Download Error Logs",
            class: "download-error-log custom-file-upload delete",
            css: {
                marginRight: "10px",
                marginTop: "10px",
                marginBottom: "10px",
                display: "inline-block",
                padding: "6px 12px"
            }
        });

        let $hiddenLink = $("<a>", {
            href: url,
            download: filename + ".txt",
            style: "display: none"
        });

        $downloadLabel.on("click", function() {
            $hiddenLink[0].click();
        });

        $(".import_buttons").append($downloadLabel).append($hiddenLink);
    }

    function saveValidatedData(valid_data, data_header_id, header) {
        const batch_size = 5000;
        const total_batches = Math.ceil(valid_data.length / batch_size);
        let batch_index = 0;
        const errorLogs = [];
        const url = "<?= base_url('cms/global_controller');?>";
        const table = 'tbl_sell_out_data_details';
        const start_time = new Date();
        const month = getMonthIdByName($("#month").val());
        const year = $("#year").val();
        const customer_payment_group = $("#paygrp").val();
        const company_id = parts[0];

        modal.loading_progress(true, "Saving data...");

        function processNextBatch() {
            if (batch_index >= total_batches) {
                modal.loading_progress(false);
                if (errorLogs.length > 0) {
                    createErrorLogFile(
                        errorLogs,
                        "Insert_Error_Log_" + formatReadableDate(new Date(), true)
                    );
                    modal.alert("Some records encountered errors. Check the log.", 'info');
                } else {
                    modal.loading_progress(true, "Finishing data...");
                    delete_temp_data();
                    updateAggregatedScanData(data_header_id, month, year, customer_payment_group, company_id);
                    logAll(start_time, valid_data);
                    setTimeout(() => {
                        modal.loading(true);
                        modal.alert("All records inserted successfully!", 'success',() => {
                                window.location.href = "<?= base_url('cms/import-sell-out') ?>";
                            }
                        );
                        //modal.alert("Selected records deleted successfully!", 'success', () => location.reload());
                    }, 1000);
                }
                return;
            }

            // slice and augment batch records
            const batch = valid_data
                .slice(batch_index * batch_size, (batch_index + 1) * batch_size)
                .map(record => ({
                    ...record,
                    data_header_id: data_header_id,
                    month: month,
                    year: year,
                    customer_payment_group: header[0].customer_payment_group,
                    template_id: header[0].import_file_code,
                }));

            // insert batch
            batch_insert(url, batch, table, false, (response) => {
                if (response.message !== 'success') {
                    errorLogs.push(`Batch insert failed: ${JSON.stringify(response.error)}`);
                } else {
                    updateSwalProgress(
                        "Inserting Records...", batch_index + 1, total_batches
                    );
                }
                batch_index++;
                setTimeout(processNextBatch, 300);
            });
        }

        // start processing
        setTimeout(processNextBatch, 1000);
    }

    function updateAggregatedScanData(data_header_id, month, year, customer_payment_group, company_id){
        const update_url = "<?= base_url('cms/import-sell-out/update-aggregated-scan-data');?>";
        const data = {
            data_header_id: data_header_id,
            month: month,
            year: year,
            customer_payment_group: customer_payment_group,
            company: company_id,
        };

        aJax.post(update_url, data, function (result) {
            
        });
    }

    function logAll(start_time, valid_data) {
        const headers = 
        [
            `data_header_id`, 
            `month`, 
            `year`, 
            `customer_payment_group`, 
            `template_id`, 
            `file_name`, 
            `line_number`, 
            `store_code`, 
            `brand_ambassador_ids`, 
            `store_description`, 
            `sku_code`, 
            `sku_description`, 
            `quantity`, 
            `net_sales`, 
            `gross_sales`,
        ];
        const url = "<?= base_url('cms/global_controller/save_import_log_file') ?>";
        saveImportDetailsToServer(valid_data, headers, 'import_sell_out', url, function(filePath) {
            const end_time = new Date();
            const duration = formatDuration(start_time, end_time);

            let remarks = `
                Import Completed Successfully!
                <br>Total Records: ${valid_data.length}
                <br>Start Time: ${formatReadableDate(start_time)}
                <br>End Time: ${formatReadableDate(end_time)}
                <br>Duration: ${duration}`;

            let link = filePath ? `<a href="<?= base_url() ?>${filePath}" target="_blank">View Details</a>` : null;

            logActivity('Add Sell Out Module', 'Import Data', remarks, link, null, null);
            window.location.href = "<?=base_url('cms/import-sell-out/');?>";
        });
    }

    function getMonthIdByName(name) {
        const month = months.find(m => m.month.toLowerCase() === name.toLowerCase());
        return month ? month.id : null;
    }

    function saveHeaderData(parts, callback) {
        let header_data = [];
        dynamic_search(
            "'tbl_sell_out_template_header'", "''",
            "'customer_payment_group, import_file_code, file_type'",
            1, 0,
            "'import_file_code:EQ=" + parts[4] + "'", "''", "''",
            (res) => {
                header_data = res;

                let data = {
                    company : parts[0],
                    month: getMonthIdByName($("#month").val()),
                    year: $("#year").val(),
                    customer_payment_group: parts[1],
                    template_id: header_data[0].import_file_code,
                    created_date: formatDate(new Date()),
                    created_by: '<?=$session->sess_uid;?>',
                    file_type: header_data[0].file_type,
                    remarks: $("#remarks").val(),
                };

                let payload = {
                    event: "insert",
                    table: "tbl_sell_out_data_header",
                    data: data
                };

                aJax.post(url, payload, function (result) {
                    var obj = is_json(result);

                    // Invoke callback with header ID
                    if (callback && typeof callback === "function") {
                        callback(obj.ID, header_data);
                    }
                });
            }
        );
    }

</script>