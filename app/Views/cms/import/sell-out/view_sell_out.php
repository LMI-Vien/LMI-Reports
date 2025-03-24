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
            <b id="sell_out_title"></b>
        </div>
        <div class="card-body text-center">
            <div class="d-flex flex-column text-left" style="margin-top: 20px;">
                <div class="d-flex flex-row">
                    <label for="paygroup" class="form-label p-2 col-2">Payment Group</label>
                    <input type="text" class="form-control p-2 col-3" id="paygroup" readonly disabled>
                    <div class="p-2 col-1"></div>
                    <label for="uploaddte" class="form-label p-2 col-3">Date and Time Uploaded</label>
                    <input type="text" class="form-control p-2 col-3" id="uploaddte" readonly disabled>
                </div>
                <div class="d-flex flex-row">
                    <label for="uploader" class="form-label p-2 col-2">Uploader</label>
                    <input type="text" class="form-control p-2 col-3" id="uploader" readonly disabled>
                    <div class="p-2 col-1"></div>
                    <label for="month" class="form-label p-2 col-3">Month</label>
                    <input type="text" class="form-control p-2 col-3" id="month" readonly disabled>
                </div>
                <div class="d-flex flex-row">
                    <label for="filetype" class="form-label p-2 col-2">File Type</label>
                    <input type="text" class="form-control p-2 col-3" id="filetype" readonly disabled>
                    <div class="p-2 col-1"></div>
                    <label for="year" class="form-label p-2 col-3">Year</label>
                    <input type="text" class="form-control p-2 col-3" id="year" readonly disabled>
                </div>
                <div class="d-flex flex-row" style="margin-top: 30px;">
                    <label for="remarks" class="form-label p-2 col-2">Remarks</label>
                    <input type="text" class="form-control p-2 col" id="remarks" readonly disabled>
                </div>
            </div>
            <div class="box" style="max-height: 500px; overflow-y: auto; margin-top: 20px;">
                <table class= "table table-bordered listdata" style="width: 100%">
                    <thead>
                        <tr>
                            <!-- <th class='center-content'><input class ="selectall" type ="checkbox"></th> -->
                            <th class='center-content'>File Name</th>
                            <!-- <th class='center-content'>Line Number</th> -->
                            <th class='center-content'>Store Code</th>
                            <th class='center-content'>Store Description</th>
                            <th class='center-content'>SKU Code</th>
                            <th class='center-content'>SKU Description</th>
                            <th class='center-content'>Quantity</th>
                            <th class='center-content'>Net Sales</th>
                        </tr>  
                    </thead>
                    <tbody class="table_body word_break"></tbody>
                </table>
            </div>
            <div class="list_pagination"></div>
        </div>
    </div>
</div>


<script>
    var url = "<?= base_url('cms/global_controller');?>";
    var import_sellout_id = "<?=$uri->getSegment(4);?>";
    var limit = 10; 

    $(document).ready(function() {
        $("#sell_out_title").html(addNbsp("VIEW SELLOUT DATA"));

        renderHeader(import_sellout_id)
        renderDetails(import_sellout_id)
    });

    function renderHeader(header_id) {
        table = 'tbl_sell_out_data_header a';
        join = 'left join tbl_month b on a.month = b.id';
        fields = 'a.id, b.month, a.year, a.customer_payment_group, a.template_id, a.created_date, a.created_by, a.file_type, a.remarks';
        limit = 0;
        dynaoffset = 0;
        filter = `a.id:EQ=${header_id}`;
        order = '';
        group = '';
        dynamic_search(
            `'${table}'`,`'${join}'`,`'${fields}'`,`${limit}`,`${dynaoffset}`,`'${filter}'`, `'${order}'`,`'${group}'`, 
            (result) => {
                $.each(result, function(x,y) {
                    $('#paygroup').val(y.customer_payment_group);
                    $('#uploaddte').val(y.created_date);

                    $('#uploader').val(y.created_by);
                    $('#month').val(y.month);

                    $('#filetype').val(y.file_type);
                    $('#year').val(y.year);

                    $('#remarks').val(y.remarks);
                })
            }
        )
    }

    function renderDetails(header_id) {
        table = 'tbl_sell_out_data_details a';
        join = '';
        fields = 'data_header_id, id, file_name, line_number, store_code, store_description, sku_code, sku_description, quantity, net_sales';
        limit = 0;
        dynaoffset = 0;
        filter = `data_header_id:EQ=${header_id}`;
        order = '';
        group = '';
        dynamic_search(
            `'${table}'`,`'${join}'`,`'${fields}'`,`${limit}`,`${dynaoffset}`,`'${filter}'`, `'${order}'`,`'${group}'`, 
            (result) => {
                var html = '';
                if(result) {
                    if (result.length > 0) {
                        $.each(result, function(x,y) {
                            var status = ( parseInt(y.status) === 1 ) ? status = "Active" : status = "Inactive";
                            var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";

                            html += "<tr class='" + rowClass + "'>";
                            // html += "<td class='center-content' style='width: 5%'><input class='select' type=checkbox data-id="+y.id+" onchange=checkbox_check()></td>";
                            html += "<td scope=\"col\">" + y.file_name + "</td>";
                            // html += "<td scope=\"col\">" + y.line_number + "</td>";
                            html += "<td scope=\"col\">" + y.store_code + "</td>";
                            html += "<td scope=\"col\">" + y.store_description + "</td>";
                            html += "<td scope=\"col\">" + y.sku_code + "</td>";
                            html += "<td scope=\"col\">" + y.sku_description + "</td>";
                            html += "<td scope=\"col\">" + y.quantity + "</td>";
                            html += "<td scope=\"col\">" + y.net_sales + "</td>";
                            
                            html += "</tr>";   
                        });
                    } else {
                        html = '<tr><td colspan=12 class="center-align-format">'+ no_records +'</td></tr>';
                    }
                };
                $('.table_body').html(html);
            }
        )
    }

    function addNbsp(inputString) {
        return inputString.split('').map(char => {
            if (char === ' ') {
            return '&nbsp;&nbsp;';
            }
            return char + '&nbsp;';
        }).join('');
    }

    function get_pagination(new_query) {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "pagination",
            select: "data_header_id, id, file_name, line_number, store_code, store_description, sku_code, sku_description, quantity, net_sales",
            query: new_query,
            offset: offset,
            limit: limit,
            table : "tbl_sell_out_data_details",
            order : {
                field : "id",
                order : "asc" 
            }
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result); 
            modal.loading(false);
            pagination.generate(obj.total_page, ".list_pagination", renderDetails);
        });
    }

    pagination.onchange(function(){
        offset = $(this).val();
        renderDetails(query);
        $('.selectall').prop('checked', false);
        $('.btn_status').hide();
        $("#search_query").val("");
    });
</script>