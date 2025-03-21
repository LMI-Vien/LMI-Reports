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
                    <label for="company" class="form-label p-2 col-2">Company</label>
                    <input type="text" class="form-control p-2 col-3" id="company" readonly disabled>
                    <div class="p-2 col-1"></div>
                    <label for="year" class="form-label p-2 col-3">Year</label>
                    <input type="text" class="form-control p-2 col-3" id="year" readonly disabled>
                </div>
                <div class="d-flex flex-row">
                    <label for="month" class="form-label p-2 col-2">Month</label>
                    <input type="text" class="form-control p-2 col-3" id="month" readonly disabled>
                    <div class="p-2 col-1"></div>
                    <label for="week" class="form-label p-2 col-3">Week</label>
                    <input type="text" class="form-control p-2 col-3" id="week" readonly disabled>
                </div>
            </div>
            <div class="box" style="max-height: 500px; overflow-y: auto; margin-top: 20px;">
                <table class="table table-bordered listdata">
                    <thead>
                        <tr>
                            <th class='center-content'>Store</th>
                            <th class='center-content'>Store Name</th>
                            <th class='center-content'>Item</th>
                            <th class='center-content'>Item Name</th>
                            <th class='center-content'>VMI Status</th>
                            <th class='center-content'>Status</th>
                            <th class='center-content'>Item Class</th>
                            <th class='center-content'>Supplier</th>
                            <th class='center-content'>Group</th>
                            <th class='center-content'>Dept</th>
                            <th class='center-content'>Class</th>
                            <th class='center-content'>Sub-class</th>
                            <th class='center-content'>On Hand</th>
                            <th class='center-content'>In transit</th>
                            <th class='center-content'>Total Qty</th>
                            <th class='center-content'>Ave Sales Unit</th>
                            <th class='center-content'>Date Created</th>
                            <th class='center-content'>Date Modified</th>
                            <th class='center-content'>Company</th>
                        </tr>
                    </thead>
                    <tbody class="table_body word_break"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    var params = "<?=$uri->getSegment(4);?>";
    paramlist = params.split('-')
    var query = `v.status >= 0 and c.name = '${paramlist[0]}' and y.year = '${paramlist[1]}' and m.month = '${paramlist[2]}' and w.name = '${decodeURIComponent(paramlist[3])}'`;
    var limit = 0; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url('cms/global_controller');?>";

    $(document).ready(function() {
        $("#sell_out_title").html(addNbsp("VIEW VMI DATA"));
        $("#company").val(paramlist[0]);
        $("#year").val(paramlist[1]);
        $("#month").val(paramlist[2]);
        $("#week").val(decodeURIComponent(paramlist[3]));

        get_data(query);
    })

    function get_data(new_query) {
        var data = {
            event: "list",
            select: "v.id, s.code AS store, s.description AS store_name, v.item, v.item_name, "+
            "v.status, v.item_class, v.supplier, v.group, v.dept, v.class, v.sub_class, v.on_hand, v.in_transit, "+
            "(v.on_hand + v.in_transit) AS total_qty, v.average_sales_unit, v.vmi_status, v.created_date, v.updated_date, "+
            "c.name AS company",
            query: new_query,
            offset: offset,
            limit: limit,
            table: "tbl_vmi v",
            join: [
                {
                    table: "tbl_store s",
                    query: "s.id = v.store",
                    type: "left"
                },
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
            group : ""
        };


        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            var html = '';

            if(result) {
                if (result.length > 0) {
                    $.each(result, function(x,y) {
                        var status = ( parseInt(y.status) === 1 ) ? status = "Active" : status = "Inactive";
                        var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";

                        html += "<tr class='" + rowClass + "'>";
                        html += "<td scope=\"col\">" + (y.store) + "</td>";
                        html += "<td scope=\"col\">" + (y.store_name) + "</td>";
                        html += "<td scope=\"col\">" + (y.item) + "</td>";
                        html += "<td scope=\"col\">" + y.item_name + "</td>";
                        html += "<td scope=\"col\">" + (y.vmi_status) + "</td>";
                        html += "<td scope=\"col\">" + status + "</td>";
                        html += "<td scope=\"col\">" + (y.item_class) + "</td>";
                        html += "<td scope=\"col\">" + (y.supplier) + "</td>";
                        html += "<td scope=\"col\">" + (y.group) + "</td>";
                        html += "<td scope=\"col\">" + (y.dept) + "</td>";
                        html += "<td scope=\"col\">" + (y.class) + "</td>";
                        html += "<td scope=\"col\">" + (y.sub_class) + "</td>";
                        html += "<td scope=\"col\">" + (y.on_hand) + "</td>";
                        html += "<td scope=\"col\">" + (y.in_transit) + "</td>";
                        html += "<td scope=\"col\">" + (y.total_qty) + "</td>";
                        html += "<td scope=\"col\">" + (y.average_sales_unit) + "</td>";
                        html += "<td scope=\"col\">" + (y.created_date ? ViewDateformat(y.created_date) : "N/A") + "</td>";
                        html += "<td scope=\"col\">" + (y.updated_date ? ViewDateformat(y.updated_date) : "N/A") + "</td>";
                        html += "<td scope=\"col\">" + (y.company) + "</td>";
                        html += "</tr>";   
                    });
                } else {
                    html = '<tr><td colspan=18 class="center-align-format">'+ no_records +'</td></tr>';
                }
            }
            $('.table_body').html(html);
        });
    }
</script>