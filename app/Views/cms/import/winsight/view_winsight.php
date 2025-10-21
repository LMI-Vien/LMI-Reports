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
            $optionSet = '';
            foreach($pageOption as $pageOptionLoop) {
                $optionSet .= "<option value='".$pageOptionLoop."'>".$pageOptionLoop."</option>";
            }
        ?>
        <div class="text-center page-title md-center">
            <b id="winsight_title"></b>
        </div>
        <div class="card-body text-center">
            <div class="d-flex flex-column text-left mt-2">
                <div class="row">
                    <div class="col-8">
                        <label for="file_name" class="form-label p-2">Import File Name</label>
                        <input type="text" id="file_name" class="form-control p-2" disabled readonly>
                    </div>
                    <div class="col-4">
                        <label for="username" class="form-label p-2">Imported By</label>
                        <input type="text" id="username" class="form-control p-2" disabled readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="year" class="form-label p-2">Year</label>
                        <input type="text" id="year" class="form-control p-2" disabled readonly>
                    </div>
                    <div class="col-4">
                        <label for="month" class="form-label p-2">Month</label>
                        <input type="text" id="month" class="form-control p-2" disabled readonly>
                    </div>
                    <div class="col-4">
                        <label for="week" class="form-label p-2">Week</label>
                        <input type="text" id="week" class="form-control p-2" disabled readonly>
                    </div>
                </div>
            </div>
            <div class="box">
                <table class= "table table-bordered listdata" style="width: 100%">
                    <thead>
                        <tr>
                            <td>Line #</td>
                            <td>BU Name</td>
                            <td>Supplier</td>
                            <td>Brand ID</td>
                            <td>Product ID</td>
                            <td>Category 1 (Item Classification)</td>
                            <td>Category 2 (Sub Classification)</td>
                            <td>Category 3 (Department)</td>
                            <td>Category 4 (Merch. Category)</td>
                            <td>Year</td>
                            <td>Year Month</td>
                            <td>Year Week</td>
                            <td>Date</td>
                            <td>Online/ Offline</td>
                            <td>Store Format</td>
                            <td>Store Segment</td>
                            <td>Gross Sales</td>
                            <td>Net Sales</td>
                            <td>Sales Qty</td>
                            <td>Barcode</td>
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


<script>
    var url = "<?= base_url('cms/global_controller');?>";
    var headers = <?= json_encode($headers); ?>;
    var id = <?= $id; ?>;
    var limit = 10; 
    var offset = 1;

    $(document).ready(function() {
        $("#winsight_title").html(addNbsp("VIEW WINSIGHT DATA"));

        const sessionData = <?= json_encode(session()->get()) ?>;
        let remarks = `USER: "${sessionData.sess_name}" opened Winsight data with ID No.: "${id}"`;
        let link = '';
        logActivity('Import Winsight Module', 'View Data', remarks, link, null, null);

        renderHeader();
        renderDetails();
    });

    function renderHeader() {
        let x = headers[0];
        $("#file_name").val(x.file_name)
        $("#username").val(x.username)
        $("#year").val(x.year)
        $("#month").val(x.month)
        $("#week").val(x.week)
    }

    function renderDetails(new_query) {
        // insert detail data
        get_data();
        get_pagination();
    }

    const get_data = () => {
        select = '';
		select += 'a.header_id, a.file_name, a.line_number,';
		select += 'a.bu_name, a.supplier, a.brand_name, a.product_id, a.product_name,';
		select += 'a.cat_1, a.cat_2, a.cat_3, a.cat_4,';
		select += 'a.year, b.month, a.week, a.date,';
		select += 'a.online_offline, a.store_format, a.store_segment, ';
		select += 'a.gross_sales, a.net_sales, a.sales_qty, a.barcode';
        var data = {
            event : "list",
            select : select,
            query : `header_id = ${id}`,
            offset : offset,
            limit : 0,
            table : "tbl_winsight_details a",
            join : [
                {
                    table : "tbl_month b",
                    query : "a.month = b.id",
                    type : "left"
                }
            ]
        }

        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            var html = '';

            console.log(result, 'result')

            if(result) {
                if (result.length > 0) {
                    $.each(result, function(x,y) {
                        var status = ( parseInt(y.status) === 1 ) ? status = "Active" : status = "Inactive";
                        var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";

                        html += "<tr class='" + rowClass + "'>";
                        html += "<td scope=\"col\">" + y.line_number + "</td>"; // <td>Line #</td>
                        html += "<td scope=\"col\">" + y.bu_name + "</td>"; // <td>BU Name</td>
                        html += "<td scope=\"col\">" + y.supplier + "</td>"; // <td>Supplier</td>
                        html += "<td scope=\"col\">" + y.brand_name + "</td>"; // <td>Brand ID</td>
                        html += "<td scope=\"col\">" + y.product_id + "</td>"; // <td>Product ID</td>
                        html += "<td scope=\"col\">" + y.cat_1 + "</td>"; // <td>Category 1 (Item Classification)</td>
                        html += "<td scope=\"col\">" + y.cat_2 + "</td>"; // <td>Category 2 (Sub Classification)</td>
                        html += "<td scope=\"col\">" + y.cat_3 + "</td>"; // <td>Category 3 (Department)</td>
                        html += "<td scope=\"col\">" + y.cat_4 + "</td>"; // <td>Category 4 (Merch. Category)</td>
                        html += "<td scope=\"col\">" + y.year + "</td>"; // <td>Year</td>
                        html += "<td scope=\"col\">" + y.month + "</td>"; // <td>Year Month</td>
                        html += "<td scope=\"col\">" + y.week + "</td>"; // <td>Year Week</td>
                        html += "<td scope=\"col\">" + y.date + "</td>"; // <td>Date</td>
                        html += "<td scope=\"col\">" + y.online_offline + "</td>"; // <td>Online/ Offline</td>
                        html += "<td scope=\"col\">" + y.store_format + "</td>"; // <td>Store Format</td>
                        html += "<td scope=\"col\">" + y.store_segment + "</td>"; // <td>Store Segment</td>
                        html += "<td scope=\"col\">" + y.gross_sales + "</td>"; // <td>Gross Sales</td>
                        html += "<td scope=\"col\">" + y.net_sales + "</td>"; // <td>Net Sales</td>
                        html += "<td scope=\"col\">" + y.sales_qty + "</td>"; // <td>Sales Qty</td>
                        html += "<td scope=\"col\">" + y.barcode + "</td>"; // <td>Barcode</td>
                        html += "</tr>";   
                    });
                } else {
                    html = '<tr><td colspan=12 class="center-align-format">'+ no_records +'</td></tr>';
                }
            }
            $('.table_body').html(html);
        });
    }

    const get_pagination = () => {
        var data = {
          event : "pagination",
            select : "a.id",
            query : `header_id = ${id}`,
            offset : offset,
            limit : limit,
            table : "tbl_winsight_details a",
            order : {
                field : "a.line_number",
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
        get_data();
        $('.selectall').prop('checked', false);
        $('.btn_status').hide();
    });
</script>