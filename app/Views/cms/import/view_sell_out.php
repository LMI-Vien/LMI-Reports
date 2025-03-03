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
        </div>
    </div>
</div>


<script>
    var query = "";
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url('cms/global_controller');?>";

    $(document).ready(function() {
        var import_sellout_id = "<?=$uri->getSegment(4);?>";

        console.log(import_sellout_id)

        $("#sell_out_title").html(addNbsp("VIEW SELLOUT DATA"));

        var query = " data_header_id = " + import_sellout_id;
        get_data(query);
        get_pagination();
    });

    function get_data(query) {
        var data = {
            event : "list",
            select : "id, file_name, line_number, store_code, store_description, sku_code, sku_description, quantity, net_sales",
            query : query,
            offset : 0,
            limit : 0,
            table : "tbl_sell_out_data_details",
            order : {
                field : "id",
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
            }
            $('.table_body').html(html);
        });
    }

    function addNbsp(inputString) {
        return inputString.split('').map(char => {
            if (char === ' ') {
            return '&nbsp;&nbsp;';
            }
            return char + '&nbsp;';
        }).join('');
    }
</script>