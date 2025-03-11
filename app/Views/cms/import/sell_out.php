<style>
    th, td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
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
<script>
    var query = " so.id >= 0";
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url('cms/global_controller');?>";

    $(document).ready(function() {
      get_data(query);
      get_pagination(query);
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

                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                          html+="<td class='center-content' style='width: 25%'>";
                          //   html+="<td class='center-content' style='width: 25%'>";
                          html+="<a class='btn-sm btn view' href='<?= base_url()?>"
                          +'cms/import-sell-out/view/'+y.id+"' data-status='"+y.status+
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
</script>