<style>
    th, td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .uniform-dropdown {
        height: 36px;
        font-size: 14px;
        border-radius: 5px;
        /* min-width: 120px; */
        width: 90%;
        flex-grow: 1;
    }

    .ui-widget {
        z-index: 1051 !important;
    }

    #list-data {
        overflow: visible !important;
        max-height: none !important;
        overflow-x: hidden !important;
        overflow-y: hidden !important;
    }

    @media (min-width: 1200px) {
        .modal-xxl {
            max-width: 95%;
        }
    }
</style>

<div class="content-wrapper p-4">
    <div class="card">
        <div class="text-center page-title md-center">
            <b>S E L L  O U T</b>
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
                                    <!-- <th class='center-content'>ID</th> -->
                                    <th class='center-content'>Month</th>
                                    <th class='center-content'>Year</th>
                                    <th class='center-content'>Customer Payment Group</th>
                                    <th class='center-content'>Template ID</th>
                                    <th class='center-content'>Created Date</th>
                                    <th class='center-content'>Created By</th>
                                    <th class='center-content'>File Type</th>
                                    <th class='center-content'>Remarks</th>
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
                            <?= $optionSet;?>
                            </select>
                        <label>Entries</label>
                    </div>
                </div>   
            </div>
        </div>
    </div>
</div>

<div 
    class="modal" 
    tabindex="-1" 
    id="view_store_modal" 
    data-backdrop="static" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
>
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
                <table class= "table table-bordered listdata">
                    <thead>
                        <tr>
                            <th class='center-content'>Store Code</th>
                            <th class='center-content'>Store Description</th>
                            <th class='center-content'>File Name</th>
                        </tr>  
                    </thead>
                    <tbody class="view_store_table word_break"></tbody>
                </table>
            </div>
            <div class="modal-footer"></div>
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
                                    <input type="text" class="form-control required" id="file_code" >
                                </div>

                                <div class="col-md-6">
                                    <label for="file_type" class="form-label">File Type</label>
                                    <input type="text" class="form-control required" id="file_type" >
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="pay_grp" class="form-label">Customer Payment Group</label>
                                    <input type="text" class="form-control required" id="pay_grp" >
                                </div>
    
                                <div class="col-md-6">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <input type="text" class="form-control required" id="remarks" >
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="line_head" class="form-label">First Line is header</label>
                                    <input type="text" class="form-control required" id="line_head" >
                                </div>

                                <div class="col-md-6">
                                    <label for="col_count" class="form-label">Template Column Count</label>
                                    <input type="text" class="form-control required" id="col_count" >
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
                                    <th class='center-content' hidden>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="word_break">
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn caution" onclick="list_template()" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="template_list_modal">
    <div class="modal-dialog modal-xxl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">
                    <b>Sell Out Templates</b>
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
                <button type="button" class="btn caution" onclick="list_template()" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="add_scan_data">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">
                    <b>Add Scan Data</b>
                </h1>
            </div>

            <div class="modal-body">
                <form id="form-modal">
                    <div class="px-3">
                        <div class="col-md-12">
                            <label for="pay_group" class="form-label">Payment Group</label>
                            <input type="text" class="form-control required" id="pay_group" >
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="year" class="ml-2 form-label fw-semibold me-2">Choose Year:</label>
                                <select id="year" class="ml-2 form-select uniform-dropdown">
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="month" class="ml-2 form-label fw-semibold me-2">Choose Month:</label>
                                <select id="month" class="ml-2 form-select uniform-dropdown">
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="template" class="form-label">Choose Template</label>
                            <input type="text" class="form-control required" id="template" >
                        </div>
                    </div>
                </form>
            </div>
        
            <div class="modal-footer">
                <button type="button" class="btn save" onclick="import_sellout()">Next</button>
                <button type="button" class="btn caution" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    var query = " so.id >= 0";
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url('cms/global_controller');?>";

    $(document).ready(function() {
      get_data(query);
      get_pagination(query);

      getpaygroup();
      getTemplates();
      populatedropdown('#pay_group', pay_group);
      populatedropdown('#template', templates);
      populatedropdown('#pay_grp', pay_group);
      populatedropdown('#file_type', ["xlsx", "xml"],);
    });

    function get_data(query) {
        var data = {
            event : "list",
            select : "so.id, m.month, so.year, so.customer_payment_group, so.template_id, so.created_date, so.created_by, so.file_type, so.remarks",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_sell_out_data_header as so",
            join : [{
                table : "tbl_month as m",
                query : "m.id = so.month",
                type : "left"
            }],
            order : {
                field : "so.id",
                order : "asc" 
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
                        html += "<td class='center-content' style='width: 5%'><input class='select' type=checkbox data-id="+y.id+" onchange=checkbox_check()></td>";
                        // html += "<td scope=\"col\">" + y.id + "</td>";
                        html += "<td scope=\"col\">" + y.month + "</td>";
                        html += "<td scope=\"col\">" + y.year + "</td>";
                        html += "<td scope=\"col\">" + (y.customer_payment_group) + "</td>";
                        html += "<td scope=\"col\">" + y.template_id + "</td>";
                        html += "<td scope=\"col\">" + y.created_date + "</td>";
                        html += "<td scope=\"col\">" + y.created_by + "</td>";
                        html += "<td scope=\"col\">" + y.file_type + "</td>";
                        html += "<td scope=\"col\">" + (y.remarks) + "</td>";

                        let href = "<?= base_url()?>"+"cms/import-sell-out/view/"+y.id;

                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                          html+="<td class='center-content' style='width: 25%'>";
                          //   html+="<td class='center-content' style='width: 25%'>";
                          html+="<a class='btn-sm btn view' href='"+ href +"' data-status='"+y.status+
                          "' target='_blank' id='"+y.id+
                          "' title='View Details'><span class='glyphicon glyphicon-pencil'>View</span>";

                          html+="<a class='btn-sm btn view' onclick=\"view_stores('"
                          +y.id+"')\" data-status='"
                          +y.status+"' id='"
                          +y.id+"' title='Edit Details'><span class='glyphicon glyphicon-pencil'>View Stores</span>";

                          html+="<a class='btn-sm btn save' onclick=\"export_sellout('"
                          +y.id+"')\" data-status='"
                          +y.status+"' id='"
                          +y.id+"' title='Edit Details'><span class='glyphicon glyphicon-pencil'>Export</span>";

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

    function get_pagination(query) {
        var data = {
          event : "pagination",
            select : "so.id",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_sell_out_data_header as so",
            order : {
                field : "so.id", //field to order
                order : "asc" //asc or desc
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
            // query = "( code like '%" + keyword + "%' ) OR team_description like '%" + keyword + "%' AND status >= 1";
            var new_query = "("+query+" AND so.customer_payment_group like '%" + keyword + "%') OR "+
            "("+query+" AND so.template_id like '%" + keyword + "%') OR "+
            "("+query+" AND so.created_by like '%" + keyword + "%') OR "+
            "("+query+" AND so.file_type like '%" + keyword + "%') OR "+
            "("+query+" AND m.month like '%" + keyword+ "%') OR "+
            "("+query+" AND so.remarks like '%" + keyword + "%')"
            get_data(new_query);
            get_pagination(query);
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

    function view_stores(id) {
        $("#view_store_modal").modal('show');

        var data = {
            event : "list",
            select : "data_header_id, file_name, store_description, store_code",
            query : " data_header_id = " + id,
            offset : offset,
            limit : limit,
            table : "tbl_sell_out_data_details",
            order : {
                field : "store_code",
                order : "asc" 
            },
            group : "tbl_sell_out_data_details.store_code"

        }

        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            console.log(result, 'result');

            var html = '';

            if(result) {
                if (result.length > 0) {
                    $.each(result, function(x,y) {
                        var status = ( parseInt(y.status) === 1 ) ? status = "Active" : status = "Inactive";
                        var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";

                        html += "<tr class='" + rowClass + "'>";
                        html += "<td scope=\"col\">" + y.store_code + "</td>";
                        html += "<td scope=\"col\">" + y.store_description + "</td>";
                        html += "<td scope=\"col\">" + y.file_name + "</td>";
                        
                        html += "</tr>";   
                    });
                } else {
                    html = '<tr><td colspan=12 class="center-align-format">'+ no_records +'</td></tr>';
                }
            }
            $('.view_store_table').html(html);
        })
    }

    $(document).on('click', '#btn_export ', function() {
        modal.confirm(confirm_export_message,function(result){
            if (result) {
                modal.loading_progress(true, "Reviewing Data...");
                setTimeout(() => {
                    handleExport()
                }, 500);
            }
        })
    });

    function handleExport() {
        var formattedData = [];
        var ids = [];
        let table = '';
        let join = '';
        let fields = '';
        let limit = 0;
        let offset = 0;
        let filter = '';
        let order = '';
        let group = '';
        
        $('.select:checked').each(function () {
            var id = $(this).attr('data-id');
            ids.push(`${id}`); // Collect IDs in an array
        });
        
        const fetchStores = (callback) => {
            const processResponse = (res) => {
                res.forEach(item => {
                    let spacing = {
                        "File Name": "",
                        "Store Code": "",
                        "Store Description": "",
                        "SKU Code": "",
                        "SKU Description": "",
                        "Quantity": "",
                        "Net Sales": "",
                    }
                    let newData = {
                        "File Name": item.month,
                        "Store Code": item.year,
                        "Store Description": item.customer_payment_group,
                        "SKU Code": item.created_date,
                        "SKU Description": item.created_by,
                        "Quantity": item.file_type,
                        "Net Sales": item.remarks,
                    }
                    formattedData.push(newData); // Append new data to formattedData array
                    table = 'tbl_sell_out_data_details';
                    join = '';
                    fields = 'COUNT(id) AS total_records';
                    limit = 0;
                    offset = 0;
                    filter = `data_header_id:EQ=${item.id}`;
                    order = '';
                    group = '';
                    dynamic_search(`'${table}'`,`'${join}'`,`'${fields}'`,`${limit}`,`${offset}`,`'${filter}'`, `'${order}'`,`'${group}'`,
                        (res) => {
                            if (res && res.length > 0) {
                                let total_records = res[0].total_records;
                                for (let index = 0; index < total_records; index += 100000) {
                                    table = 'tbl_sell_out_data_details';
                                    join = '';
                                    fields = 'data_header_id, id, file_name, line_number, store_code, store_description, sku_code, sku_description, quantity, net_sales';
                                    limit = 100000;
                                    offset = index;
                                    filter = `data_header_id:EQ=${item.id}`;
                                    order = '';
                                    group = '';
                                    dynamic_search(`'${table}'`,`'${join}'`,`'${fields}'`,`${limit}`,`${offset}`,`'${filter}'`, `'${order}'`,`'${group}'`,
                                        (result) => {
                                            result.forEach(item => {
                                                let newData = {
                                                    "File Name": item.file_name,
                                                    "Store Code": item.store_code,
                                                    "Store Description": item.store_description,
                                                    "SKU Code": item.sku_code,
                                                    "SKU Description": item.sku_description,
                                                    "Quantity": item.quantity,
                                                    "Net Sales": item.net_sales,
                                                }
                                                formattedData.push(newData);
                                            })
                                        }
                                    )
                                }
                            }
                        }
                    )

                    formattedData.push(spacing); // Append new data to formattedData array
                });
            };

            ids.length > 0 
                ? dynamic_search(
                    "'tbl_sell_out_data_header a'", 
                    "'left join tbl_month b on a.month = b.id'", 
                    "'a.id, b.month, a.year, a.customer_payment_group, a.template_id, a.created_date, a.created_by, a.file_type, a.remarks'", 
                    0, 
                    0, 
                    `'a.id:IN=${ids.join('|')}'`,  
                    `''`, 
                    `''`,
                    processResponse
                )
                : batch_export();
        };

        const batch_export = () => {
            table = 'tbl_sell_out_data_header';
            join = '';
            fields = 'COUNT(id) AS total_records';
            limit = 0;
            offset = 0;
            filter = '';
            order = '';
            group = '';
            dynamic_search(`'${table}'`,`'${join}'`,`'${fields}'`,`${limit}`,`${offset}`,`'${filter}'`, `'${order}'`,`'${group}'`,
                (res) => {
                    if (res && res.length > 0) {
                        let total_records = res[0].total_records;
                        for (let index = 0; index < total_records; index += 100000) {
                            table = 'tbl_sell_out_data_header a';
                            join = 'left join tbl_month b on a.month = b.id';
                            fields = 'a.id, b.month, a.year, a.customer_payment_group, a.template_id, a.created_date, a.created_by, a.file_type, a.remarks';
                            limit = 100000;
                            offset = index;
                            filter = '';
                            order = '';
                            group = '';
                            dynamic_search(`'${table}'`,`'${join}'`,`'${fields}'`,`${limit}`,`${offset}`,`'${filter}'`, `'${order}'`,`'${group}'`,
                                (res) => {
                                    res.forEach(item => {
                                        let spacing = {
                                            "File Name": "",
                                            "Store Code": "",
                                            "Store Description": "",
                                            "SKU Code": "",
                                            "SKU Description": "",
                                            "Quantity": "",
                                            "Net Sales": "",
                                        }
                                        let newData = {
                                            "File Name": item.month,
                                            "Store Code": item.year,
                                            "Store Description": item.customer_payment_group,
                                            "SKU Code": item.created_date,
                                            "SKU Description": item.created_by,
                                            "Quantity": item.file_type,
                                            "Net Sales": item.remarks,
                                        }
                                        formattedData.push(newData); // Append new data to formattedData array
                                        table = 'tbl_sell_out_data_details';
                                        join = '';
                                        fields = 'COUNT(id) AS total_records';
                                        limit = 0;
                                        offset = 0;
                                        filter = `data_header_id:EQ=${item.id}`;
                                        order = '';
                                        group = '';
                                        dynamic_search(`'${table}'`,`'${join}'`,`'${fields}'`,`${limit}`,`${offset}`,`'${filter}'`, `'${order}'`,`'${group}'`,
                                            (res) => {
                                                if (res && res.length > 0) {
                                                    let total_records = res[0].total_records;
                                                    for (let index = 0; index < total_records; index += 100000) {
                                                        table = 'tbl_sell_out_data_details a';
                                                        join = '';
                                                        fields = 'data_header_id, id, file_name, line_number, store_code, store_description, sku_code, sku_description, quantity, net_sales';
                                                        limit = 100000;
                                                        offset = index;
                                                        filter = `data_header_id:EQ=${item.id}`;
                                                        order = '';
                                                        group = '';
                                                        dynamic_search(`'${table}'`,`'${join}'`,`'${fields}'`,`${limit}`,`${offset}`,`'${filter}'`, `'${order}'`,`'${group}'`,
                                                            (result) => {
                                                                result.forEach(item => {
                                                                    let newData = {
                                                                        "File Name": item.file_name,
                                                                        "Store Code": item.store_code,
                                                                        "Store Description": item.store_description,
                                                                        "SKU Code": item.sku_code,
                                                                        "SKU Description": item.sku_description,
                                                                        "Quantity": item.quantity,
                                                                        "Net Sales": item.net_sales,
                                                                    }
                                                                    formattedData.push(newData);
                                                                })
                                                            }
                                                        )
                                                    }
                                                }
                                            }
                                        )

                                        formattedData.push(spacing); // Append new data to formattedData array
                                    });
                                }
                            )
                        }
                    }
                }
            )

            console.log(formattedData, 'formattedData')
        };

        fetchStores();

        const headerData = [
            ["Company Name: Lifestrong Marketing Inc."], // Row 1
            ["Sell Out"], // Row 2
            ["Date Printed: " + formatDate(new Date())], // Row 3
            [""], // Empty row for spacing
        ];

        exportArrayToCSV(formattedData, `Sell Out - ${formatDate(new Date())}`, headerData);
        modal.loading_progress(false);
    };

    function export_sellout(id) {
        var formattedData = [];
        const processResponse = (res) => {
            res.forEach(item => {
                let spacing = {
                    "File Name": "",
                    "Store Code": "",
                    "Store Description": "",
                    "SKU Code": "",
                    "SKU Description": "",
                    "Quantity": "",
                    "Net Sales": "",
                }
                let newData = {
                    "File Name": item.month,
                    "Store Code": item.year,
                    "Store Description": item.customer_payment_group,
                    "SKU Code": item.created_date,
                    "SKU Description": item.created_by,
                    "Quantity": item.file_type,
                    "Net Sales": item.remarks,
                }
                formattedData.push(newData); // Append new data to formattedData array
                table = 'tbl_sell_out_data_details';
                join = '';
                fields = 'COUNT(id) AS total_records';
                limit = 0;
                offset = 0;
                filter = `data_header_id:EQ=${item.id}`;
                order = '';
                group = '';
                dynamic_search(`'${table}'`,`'${join}'`,`'${fields}'`,`${limit}`,`${offset}`,`'${filter}'`, `'${order}'`,`'${group}'`,
                    (res) => {
                        if (res && res.length > 0) {
                            let total_records = res[0].total_records;
                            for (let index = 0; index < total_records; index += 100000) {
                                table = 'tbl_sell_out_data_details a';
                                join = '';
                                fields = 'data_header_id, id, file_name, line_number, store_code, store_description, sku_code, sku_description, quantity, net_sales';
                                limit = 100000;
                                offset = index;
                                filter = `data_header_id:EQ=${item.id}`;
                                order = '';
                                group = '';
                                dynamic_search(`'${table}'`,`'${join}'`,`'${fields}'`,`${limit}`,`${offset}`,`'${filter}'`, `'${order}'`,`'${group}'`,
                                    (result) => {
                                        result.forEach(item => {
                                            let newData = {
                                                "File Name": item.file_name,
                                                "Store Code": item.store_code,
                                                "Store Description": item.store_description,
                                                "SKU Code": item.sku_code,
                                                "SKU Description": item.sku_description,
                                                "Quantity": item.quantity,
                                                "Net Sales": item.net_sales,
                                            }
                                            formattedData.push(newData);
                                        })
                                    }
                                )
                            }
                        }
                    }
                )
    
                formattedData.push(spacing); // Append new data to formattedData array
            });

            const headerData = [
                ["Company Name: Lifestrong Marketing Inc."], // Row 1
                ["Sell Out"], // Row 2
                ["Date Printed: " + formatDate(new Date())], // Row 3
                [""], // Empty row for spacing
            ];

            exportArrayToCSV(formattedData, `Sell Out - ${formatDate(new Date())}`, headerData);
        }

        table = 'tbl_sell_out_data_header a';
        join = 'left join tbl_month b on a.month = b.id';
        fields = 'a.id, b.month, a.year, a.customer_payment_group, a.template_id, a.created_date, a.created_by, a.file_type, a.remarks';
        limit = 0;
        offset = 0;
        filter = `a.id:EQ=${id}`;
        order = '';
        group = '';
        dynamic_search(`'${table}'`,`'${join}'`,`'${fields}'`,`${limit}`,`${offset}`,`'${filter}'`, `'${order}'`,`'${group}'`,
            processResponse
        )
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

    function trimText(str, length) {
        if (str.length > length) {
            return str.substring(0, length) + "...";
        } else {
            return str;
        }
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

    function list_template() {
        $('#template_modal').modal('hide');
        $('#template_list_modal').modal('show');
        list_templates()
    }

    function list_templates() {
        // dynamic_search(tbl_name, join, table_fields, limit, offset, conditions, order, group, callback)
        dynamic_search(
            // "'tbl_sell_out_template_header'",
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
                    html+="<a class='btn-sm btn save' onclick=\"load_template("+template.id+", 'edit')\" title='Edit Item'>";
                    html+="<span class='glyphicon glyphicon-pencil'>Edit</span>"
                    html+="<a class='btn-sm btn view' onclick=\"load_template("+template.id+", 'view')\" title='View Item'>";
                    html+="<span class='glyphicon glyphicon-pencil'>Inquire</span>"
                    html+="<a class='btn-sm btn delete' onclick=\"delete_template("+template.id+")\" title='Delete Item'>";
                    html+="<span class='glyphicon glyphicon-pencil'>Delete</span>"
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
            let count = 1;
            data.forEach(item => {
                html+='<tr>';
                html+=
                `<td style="text-align: center; vertical-align: middle;">
                    <input type="text" id="col_no_${count}" class="form-control required" value="${item.column_number}" ${readonly} ${disabled}>
                </td>`;

                html+=
                `<td>
                    <select name="headers" id="headers_${count}" class="form-control required" ${readonly} ${disabled}>
                        <option id="0" value="0" ${item.column_header == 0 ? "selected" : ""}></option>
                        <option id="1" value="1" ${item.column_header == 1 ? "selected" : ""}>Store Code</option>
                        <option id="2" value="2" ${item.column_header == 2 ? "selected" : ""}>Store Description</option>
                        <option id="3" value="3" ${item.column_header == 3 ? "selected" : ""}>SKU Code</option>
                        <option id="4" value="4" ${item.column_header == 4 ? "selected" : ""}>SKU Description</option>
                        <option id="5" value="5" ${item.column_header == 5 ? "selected" : ""}>Quantity</option>
                        <option id="6" value="6" ${item.column_header == 6 ? "selected" : ""}>Net Sales</option>
                        <option id="7" value="7" ${item.column_header == 7 ? "selected" : ""}>Gross Sales</option>
                    </select>
                </td>`;

                html+=
                `<td>
                    <input type="text" id="caption_${count}" class="form-control required" value="${item.file_header}" ${readonly} ${disabled}>
                </td>`

                html+=`<td class='center-content' style='width: 5%;' hidden>`;
                html+=`<input type="text" id="id_${count}" class="form-control required" value="${item.id}">`
                html+=`</td>`

                html+='</tr>';
                count++;
            });

            let template_id = data[0].template_header_id;
            let button = ""
            if (view == 'edit') {
                button += `<button type="button" class="btn save" 
                onclick="edit_template(${template_id})">Edit Template</button>`;
                button += `<button type="button" class="btn caution" onclick="list_template()" data-dismiss="modal">Close</button>`;
            } else {
                button += `<button type="button" class="btn caution" onclick="list_template()" data-dismiss="modal">Close</button>`;
            }
            
            $('#template_modal tbody').html(html)
            $('#template_modal .modal-footer').html(button);
            $('#template_modal').modal('show');
        }
        dynamic_search(
            "'tbl_sell_out_template_details'", 
            // "'tbl_sell_out_template_details'", 
            "''", 
            "'template_header_id, id, column_header, column_number, file_header'", 
            0, 0, 
            "'template_header_id:EQ="+id+"'", 
            "''", 
            "''", 
            load_template_details
        );

        function load_template_headers(data) {
            let head = data[0];

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
            // "'tbl_sell_out_template_header'", 
            "''", 
            "'id, import_file_code, file_type, template_column_count, line_header, customer_payment_group, remarks'", 
            1, 0, 
            "'id:EQ="+id+"'", 
            "''", 
            "''", 
            (res) => { 
                load_template_headers(res)
            }
        );
    }

    function add_template() {
        $('#template_list_modal').modal('hide');
        $("#file_code, #file_type, #pay_grp, #remarks, #line_head, #col_count")
        .val('')
        let data = [1,2,3,4,5,6,7];
        let html = "";
        data.forEach(item => {
            html+='<tr>';
            html+=
            `<td style="text-align: center; vertical-align: middle;">
                <input type="text" id="col_no_${item}" class="form-control required" value="">
            </td>`;

            html+=
            `<td>
                <select name="headers" id="headers_${item}" class="form-control required">
                    <option id="0" value="0" ${item == 0 ? "selected" : ""}></option>
                    <option id="1" value="1" ${item == 1 ? "selected" : ""}>Store Code</option>
                    <option id="2" value="2" ${item == 2 ? "selected" : ""}>Store Description</option>
                    <option id="3" value="3" ${item == 3 ? "selected" : ""}>SKU Code</option>
                    <option id="4" value="4" ${item == 4 ? "selected" : ""}>SKU Description</option>
                    <option id="5" value="5" ${item == 5 ? "selected" : ""}>Quantity</option>
                    <option id="6" value="6" ${item == 6 ? "selected" : ""}>Net Sales</option>
                    <option id="7" value="7" ${item == 7 ? "selected" : ""}>Gross Sales</option>
                </select>
            </td>`;

            html+=
            `<td>
                <input type="text" id="caption_${item}" class="form-control required" value="">
            </td>`

            html+=`<td class='center-content' style='width: 5%;' hidden>`;
            html+=`<input type="text" id="id_${item}" class="form-control required" value="">`
            html+=`</td>`

            html+='</tr>';
        });
        $('#template_modal tbody').html(html)

        let button = "<button type=\"button\" class=\"btn save\" onclick=\"save_template()\">Save Template</button>";
        button += "<button type=\"button\" class=\"btn caution\" onclick=\"list_template()\" data-dismiss=\"modal\">Close</button>";
        $('#template_modal .modal-footer').html(button);

        $('#template_modal').modal('show');
    }

    function save_template() {
        let headerarr = {
            import_file_code: $("#file_code").val(),
            file_type: $("#file_type").val(),
            customer_payment_group: $("#pay_grp").val(),
            remarks: $("#remarks").val(),
            line_header: $("#line_head").val(),
            template_column_count: $("#col_count").val(),
        };

        data = {
            event: "insert",
            table: "tbl_sell_out_template_header",
            data: headerarr
        };

        aJax.post(url,data,function(result){
            var obj = is_json(result);

            let detailarr = []
            let data = [1,2,3,4,5,6,7];
            data.forEach(item => {
                detailarr.push({
                    "template_header_id" : obj.ID,
                    "column_number" : $(`#col_no_${item}`).val(),
                    "column_header" : $(`#headers_${item}`).val(),
                    "file_header" : $(`#caption_${item}`).val(),
                })
            })

            batch_insert(url, detailarr, 'tbl_sell_out_template_details', false, (response) => {
                modal.alert(success_save_message, 'success', function() {
                    $('#template_modal').modal('hide');
                })
            });
        });
    }

    function edit_template(id) {
        let headerarr = {
            import_file_code: $("#file_code").val(),
            file_type: $("#file_type").val(),
            customer_payment_group: $("#pay_grp").val(),
            remarks: $("#remarks").val(),
            line_header: $("#line_head").val(),
            template_column_count: $("#col_count").val(),
        };

        let data = {
            event: "update",
            table: "tbl_sell_out_template_header",
            field: "id",
            where: id,
            data: headerarr,
        };

        aJax.post(url,data,function(result) {
            data = {
                conditions : "'id:EQ="+id+"'",
                event : "dynamic_search",
                group : "''",
                join: "''",
                limit: 1,
                offset: 0,
                order: "''",
                table_fields: "'id, import_file_code, file_type, template_column_count, line_header, customer_payment_group, remarks'",
                tbl_name: "'tbl_sell_out_template_header'"
            }

            aJax.post(url,data,function(result){
                var obj = is_json(result);

                let detailarr = []
                let data = [1,2,3,4,5,6,7];
                data.forEach(item => {
                    detailarr.push({
                        "id" : $(`#id_${item}`).val(),
                        "template_header_id" : obj[0].id,
                        "column_number" : $(`#col_no_${item}`).val(),
                        "column_header" : $(`#headers_${item}`).val(),
                        "file_header" : $(`#caption_${item}`).val(),
                    })
                })

                batch_update(url, detailarr, "tbl_sell_out_template_details", "id", false, (response) => {
                    modal.alert(success_update_message, 'success', function() {
                        $('#template_modal').modal('hide');
                    })
                })
            });
        })
    }

    function delete_template(id) {
        modal.confirm(confirm_delete_message, function(result){
            if (result) {
                let callback = (res) => {
                    console.log(res, 'delete template header')
                    let callback2 = (res) => {
                        modal.alert(success_delete_message, 'success', function () {
                            $("#template_list_modal").modal('hide')
                        });
                    }
                    batch_delete(url, "tbl_sell_out_template_details", "template_header_id", { id }, "", callback2)
                }
                batch_delete(url, "tbl_sell_out_template_header", "id", { id }, "", callback)
            }
        });
    }

    $("#btn_add").click(() => {
        // alert('add');
        $("#add_scan_data").modal('show')
        get_year("year")
        get_month("month")
    })

    $("#btn_templates").click(() => {
        list_template()
    })

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

    function import_sellout() {
        let month = $("#month").val();
        let year = $('#year option:selected').text();
        let payGroup = $("#pay_group").val();
        let template = $("#template").val();

        if (payGroup == '' || year == '' || month == '' || template == '') {
            return modal.alert_custom("Fill up the Fields.", "Payment Group, Template, Month and Year cannot be empty", "error");
        }

        check_current_db(
            "tbl_sell_out_data_header", 
            ["month", "year", "customer_payment_group", "template_id"], 
            [$("#month").val(), $('#year option:selected').text(), $("#pay_group").val(), $("#template").val()], 
            "id" , 
            null, 
            null,
            false, 
            function(exists, duplicateFields) {
                console.log(exists, duplicateFields, 'exists, duplicateFields')
                if (!exists) {
                    modal.confirm(confirm_add_message, function(result){
                        if(result){ 
                            console.log(result, "result")
                            let href = "<?= base_url() ?>" + "cms/import-sell-out/add/";

                            let payGroup = $("#pay_group").val();
                            let year = $("#year").val();
                            let month = $("#month").val();
                            let template = $("#template").val();

                            if (payGroup == '' || year == '' || month == '' || template == '') {
                                return modal.alert_custom("Fill up the Fields.", "Payment Group, Template, Month and Year cannot be empty", "error");
                            }

                            href += `${encodeURIComponent(payGroup)}-${encodeURIComponent(year)}-${encodeURIComponent(month)}-${encodeURIComponent(template)}`;

                            // window.open(href, '_blank');
                            window.location.href = href;
                        }
                    });
        
                }             
            }
        );
    }

    let pay_group = [];
    function getpaygroup() {
        var url = "<?= base_url('cms/global_controller');?>"; 
        var data = {
            event : "list",
            select : "id, customer_group_code",
            query : 'status >= 0',
            offset : 0,
            limit : 0,
            table : "tbl_cus_payment_group_lmi",
            order : {
                field : "id",
                order : "asc" 
            }
        }

        aJax.post(url,data,function(res){
            var result = JSON.parse(res);
            var html = '';
    
            if(result) {
                if (result.length > 0) {
                    var selected = '';
                    
                    result.forEach(function (y) {
                        pay_group.push(y.customer_group_code);
                    });
                }
            }
        })
    }

    let templates = [];
    function getTemplates() {
        var url = "<?= base_url('cms/global_controller');?>"; 
        var data = {
            event : "list",
            select : "id, import_file_code",
            query : '',
            offset : 0,
            limit : 0,
            table : "tbl_sell_out_template_header",
            order : {
                field : "id",
                order : "asc" 
            }
        }

        aJax.post(url,data,function(res){
            var result = JSON.parse(res);
            var html = '';
    
            if(result) {
                if (result.length > 0) {
                    var selected = '';
                    
                    result.forEach(function (y) {
                        templates.push(y.import_file_code);
                    });
                }
            }
        })
    }

    function populatedropdown(selector, data) {
        $(selector).autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(data, request.term);
                var uniqueResults = [...new Set(results)];
                response(uniqueResults.slice(0, 10));
            },
            minLength: 0,
        }).focus(function () {
            $(this).autocomplete("search", "");
        });
    }

</script>