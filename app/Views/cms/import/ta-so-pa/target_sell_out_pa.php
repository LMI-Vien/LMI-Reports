<style>
    .rmv-btn {
        border-radius: 20px;
        background-color: #C80000;
        color: white;
        border: 0.5px solid #990000;
        box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5);
    }

    .rmv-btn:disabled {
        border-radius: 20px;
        background-color: gray;
        color: black;
        border: 0.5px solid gray;
        box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5);
    }
    .add_line {
        margin-right: 10px;
        margin-bottom: 10px;
        padding: 10px;
        min-width: 75px;
        max-height: 30px;
        line-height: 0.5;
        background-color: #339933;
        color: white;
        border: 1px solid #267326;
        border-radius: 10px;
        box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5);
    }

    .add_line:disabled {
        background-color: gray !important;
        color: black !important;
    }

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
            <b>T A R G E T - S E L L - O U T - P E R - A C C O U N T</b>
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
                                    <th class='center-content'>Year</th>
                                    <th class='center-content'>Date Modified</th>
                                    <th class='center-content'>Action</th>
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

<div class="modal" tabindex="-1" id="popup_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
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
                <form id="form-modal">
                    <div class="mb-3">
                        <div hidden>
                            <input type="text" class="form-control" id="id" aria-describedby="id">
                        </div>
                        <label for="payment_group" class="form-label">Payment Group</label>
                        <input type="text" class="form-control required" id="payment_group" aria-describedby="payment_group">
                    </div>

                    <div class="mb-3">
                        <label for="vendor" class="form-label">Vendor</label>
                        <input type="text" class="form-control required" id="vendor" aria-describedby="vendor">
                    </div>

                    <div class="mb-3">
                        <label for="overall" class="form-label">Overall</label>
                        <input type="text" class="form-control required" id="overall" aria-describedby="overall">
                    </div>

                    <div class="mb-3">
                        <label for="kam_kas_kaa" class="form-label">KAM/KAS/KAA</label>
                        <input type="text" class="form-control required" id="kam_kas_kaa" aria-describedby="kam_kas_kaa">
                    </div>

                    <div class="mb-3">
                        <label for="sales_group" class="form-label">Sales Group</label>
                        <input type="text" class="form-control required" id="sales_group" aria-describedby="sales_group">
                    </div>

                    <div class="mb-3">
                        <label for="terms" class="form-label">Terms</label>
                        <input type="text" class="form-control required" id="terms" aria-describedby="terms">
                    </div>

                    <div class="mb-3">
                        <label for="channel" class="form-label">Channel</label>
                        <input type="text" class="form-control required" id="channel" aria-describedby="channel">
                    </div>

                    <div class="mb-3">
                        <label for="brand" class="form-label">Brand</label>
                        <input type="text" class="form-control required" id="brand" aria-describedby="brand">
                    </div>

                    <div class="mb-3">
                        <label for="exclusivity" class="form-label">Exclusivity</label>
                        <input type="text" class="form-control required" id="exclusivity" aria-describedby="exclusivity">
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" class="form-control required" id="category" aria-describedby="category">
                    </div>

                    <div class="mb-3">
                        <label for="lmi_code" class="form-label">LMI Code</label>
                        <input type="text" class="form-control required" id="lmi_code" aria-describedby="lmi_code">
                    </div>

                    <div class="mb-3">
                        <label for="rgdi_code" class="form-label">RGDI Code</label>
                        <input type="text" class="form-control required" id="rgdi_code" aria-describedby="rgdi_code">
                    </div>

                    <div class="mb-3">
                        <label for="customer_sku_code" class="form-label">Customer SKU Code</label>
                        <input type="text" class="form-control required" id="customer_sku_code" aria-describedby="customer_sku_code">
                    </div>

                    <div class="mb-3">
                        <label for="item_description" class="form-label">Item Description</label>
                        <input type="text" class="form-control required" id="item_description" aria-describedby="item_description">
                    </div>

                    <div class="mb-3">
                        <label for="item_status" class="form-label">Item Status</label>
                        <input type="text" class="form-control required" id="item_status" aria-describedby="item_status">
                    </div>

                    <div class="mb-3">
                        <label for="srp" class="form-label">SRP</label>
                        <input type="text" class="form-control required" id="srp" aria-describedby="srp">
                    </div>

                    <div class="mb-3">
                        <label for="trade_discount" class="form-label">Trade Discount</label>
                        <input type="text" class="form-control required" id="trade_discount" aria-describedby="trade_discount">
                    </div>

                    <div class="mb-3">
                        <label for="customer_cost" class="form-label">Customer Cost</label>
                        <input type="text" class="form-control required" id="customer_cost" aria-describedby="customer_cost">
                    </div>

                    <div class="mb-3">
                        <label for="customer_cost_net_of_vat" class="form-label">Customer Cost Net of Vat</label>
                        <input type="text" class="form-control required" id="customer_cost_net_of_vat" aria-describedby="customer_cost_net_of_vat">
                    </div>

                    <div class="mb-3">
                        <label for="jan_tq" class="form-label">January</label>
                        <input type="text" class="form-control required" id="jan_tq" aria-describedby="jan_tq">
                    </div>

                    <div class="mb-3">
                        <label for="feb_tq" class="form-label">February</label>
                        <input type="text" class="form-control required" id="feb_tq" aria-describedby="feb_tq">
                    </div>
                    
                    <div class="mb-3">
                        <label for="mar_tq" class="form-label">March</label>
                        <input type="text" class="form-control required" id="mar_tq" aria-describedby="mar_tq">
                    </div>

                    <div class="mb-3">
                        <label for="apr_tq" class="form-label">April</label>
                        <input type="text" class="form-control required" id="apr_tq" aria-describedby="apr_tq">
                    </div>

                    <div class="mb-3">
                        <label for="may_tq" class="form-label">May</label>
                        <input type="text" class="form-control required" id="may_tq" aria-describedby="may_tq">
                    </div>

                    <div class="mb-3">
                        <label for="jun_tq" class="form-label">June</label>
                        <input type="text" class="form-control required" id="jun_tq" aria-describedby="jun_tq">
                    </div>

                    <div class="mb-3">
                        <label for="jul_tq" class="form-label">July</label>
                        <input type="text" class="form-control required" id="jul_tq" aria-describedby="jul_tq">
                    </div>


                    <div class="mb-3">
                        <label for="aug_tq" class="form-label">August</label>
                        <input type="text" class="form-control required" id="aug_tq" aria-describedby="aug_tq">
                    </div>

                    <div class="mb-3">
                        <label for="sep_tq" class="form-label">September</label>
                        <input type="text" class="form-control required" id="sep_tq" aria-describedby="sep_tq">
                    </div>

                    <div class="mb-3">
                        <label for="oct_tq" class="form-label">October</label>
                        <input type="text" class="form-control required" id="oct_tq" aria-describedby="oct_tq">
                    </div>

                    <div class="mb-3">
                        <label for="nov_tq" class="form-label">November</label>
                        <input type="text" class="form-control required" id="nov_tq" aria-describedby="nov_tq">
                    </div>

                    <div class="mb-3">
                        <label for="dec_tq" class="form-label">December</label>
                        <input type="text" class="form-control required" id="dec_tq" aria-describedby="dec_tq">
                    </div>

                    <div class="mb-3">
                        <label for="jan_ta" class="form-label">January</label>
                        <input type="text" class="form-control required" id="jan_ta" aria-describedby="jan_ta">
                    </div>

                    <div class="mb-3">
                        <label for="feb_ta" class="form-label">February</label>
                        <input type="text" class="form-control required" id="feb_ta" aria-describedby="feb_ta">
                    </div>

                    <div class="mb-3">
                        <label for="mar_ta" class="form-label">March</label>
                        <input type="text" class="form-control required" id="mar_ta" aria-describedby="mar_ta">
                    </div>

                    <div class="mb-3">
                        <label for="apr_ta" class="form-label">April</label>
                        <input type="text" class="form-control required" id="apr_ta" aria-describedby="apr_ta">
                    </div>

                    <div class="mb-3">
                        <label for="may_ta" class="form-label">May</label>
                        <input type="text" class="form-control required" id="may_ta" aria-describedby="may_ta">
                    </div>

                    <div class="mb-3">
                        <label for="jun_ta" class="form-label">June</label>
                        <input type="text" class="form-control required" id="jun_ta" aria-describedby="jun_ta">
                    </div>

                    <div class="mb-3">
                        <label for="jul_ta" class="form-label">July</label>
                        <input type="text" class="form-control required" id="jul_ta" aria-describedby="jul_ta">
                    </div>

                    <div class="mb-3">
                        <label for="aug_ta" class="form-label">August</label>
                        <input type="text" class="form-control required" id="aug_ta" aria-describedby="aug_ta">
                    </div>

                    <div class="mb-3">
                        <label for="sep_ta" class="form-label">September</label>
                        <input type="text" class="form-control required" id="sep_ta" aria-describedby="sep_ta">
                    </div>

                    <div class="mb-3">
                        <label for="oct_ta" class="form-label">October</label>
                        <input type="text" class="form-control required" id="oct_ta" aria-describedby="oct_ta">
                    </div>

                    <div class="mb-3">
                        <label for="nov_ta" class="form-label">November</label>
                        <input type="text" class="form-control required" id="nov_ta" aria-describedby="nov_ta">
                    </div>

                    <div class="mb-3">
                        <label for="dec_ta" class="form-label">December</label>
                        <input type="text" class="form-control required" id="dec_ta" aria-describedby="dec_ta">
                    </div>

                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
    
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
                <div class="card">
                    <div class="mb-3">
                        <div class="text-center"
                        style="padding: 10px; font-family: 'Courier New', Courier, monospace; font-size: large; background-color: #fdb92a; color: #333333; border: 1px solid #ffffff; border-radius: 10px;"                            
                        >
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
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div style="overflow-x: auto; max-height: 400px;">
                            <table class= "table table-bordered listdata">
                                <thead>
                                    <tr>
                                        <th class='center-content'>Line #</th>
                                        <th class='center-content'>Payment Group</th>
                                        <th class='center-content'>Vendor</th>
                                        <th class='center-content'>Overall</th>
                                        <th class='center-content'>KAM/KAS/KAA</th>
                                        <th class='center-content'>Sales Group</th>
                                        <th class='center-content'>Terms</th>
                                        <th class='center-content'>Channel</th>
                                        <th class='center-content'>Brand</th>
                                        <th class='center-content'>Exclusivity</th>
                                        <th class='center-content'>Category</th>
                                        <th class='center-content'>LMI Code</th>
                                        <th class='center-content'>RGDI Code</th>
                                        <th class='center-content'>Customer SKU Code</th>
                                        <th class='center-content'>Item Description</th>
                                        <th class='center-content'>Item Status</th>
                                        <th class='center-content'>SRP</th>
                                        <th class='center-content'>Trade Discount</th>
                                        <th class='center-content'>Customer Cost</th>
                                        <th class='center-content'>Customer Cost Net of VAT</th>
                                        <th class='center-content'>January TQ</th>
                                        <th class='center-content'>February TQ</th>
                                        <th class='center-content'>March TQ</th>
                                        <th class='center-content'>April TQ</th>
                                        <th class='center-content'>May TQ</th>
                                        <th class='center-content'>June TQ</th>
                                        <th class='center-content'>July TQ</th>
                                        <th class='center-content'>August TQ</th>
                                        <th class='center-content'>September TQ</th>
                                        <th class='center-content'>October TQ</th>
                                        <th class='center-content'>November TQ</th>
                                        <th class='center-content'>December TQ</th>
                        
                                        <th class='center-content'>January TA</th>
                                        <th class='center-content'>February TA</th>
                                        <th class='center-content'>March TA</th>
                                        <th class='center-content'>April TA</th>
                                        <th class='center-content'>May TA</th>
                                        <th class='center-content'>June TA</th>
                                        <th class='center-content'>July TA</th>
                                        <th class='center-content'>August TA</th>
                                        <th class='center-content'>September TA</th>
                                        <th class='center-content'>October TA</th>
                                        <th class='center-content'>November TA</th>
                                        <th class='center-content'>December TA</th>
        
                                    </tr>
                                </thead>
                                <tbody class="word_break import_table"></tbody>
                            </table>
                        </div>
                    </div>
                    <center style="margin-bottom: 5px">
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
    <div class="modal-dialog modal-lg">
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
                <div class="card">
                    <div class="mb-3">
                        <div 
                            class="text-center"
                            style="padding: 10px;
                            font-family: 'Courier New', Courier, monospace;
                            font-size: large;
                            background-color: #fdb92a;
                            color: #333333;
                            border: 1px solid #ffffff;
                            border-radius: 10px;"                            
                        >
                            <b>Filters</b>
                        </div>

                        <div class="col-12 row d-flex" style="margin-top: 20px;">
                            <label 
                                for="year_select" 
                                class="form-label fw-semibold me-"
                                style="padding-top: 5px;"
                            >
                                Choose Year:
                            </label>
                            <select id="year_select" class="form-select uniform-dropdown">
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
    var query = "a.status >= 0";
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url("cms/global_controller");?>";

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
        var data = {
            event : "list",
            select : "a.created_date, u.name imported_by, b.year, a.updated_date, b.id as year_id",
            query : new_query,
            offset : offset,
            limit : limit,
            table : "tbl_accounts_target_sellout_pa a",
            join: [
                {
                    table: "tbl_year b",
                    query: "a.year = b.id",
                    type: "left"
                },
                {
                    table: "cms_users u",
                    query: "u.id = a.created_by",
                    type: "left"
                }
            ],
            group : "a.year"
        }

        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            var html = '';

            if(result) {
                if (result.length > 0) {
                    $.each(result, function(x,y) {
                        var status = ( parseInt(y.status) === 1 ) ? status = "Active" : status = "Inactive";
                        var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";
                        var totalAmount = parseFloat(y.total_amount);
                        var formattedNumber = totalAmount.toLocaleString(undefined, {
                          minimumFractionDigits: 2,
                          maximumFractionDigits: 2
                        });
                        var formattedNumberTQ = Math.round(y.total_qty).toLocaleString();
                        html += "<tr class='" + rowClass + "'>";
                        html += "<td scope=\"col\">" + (y.created_date ? ViewDateformat(y.created_date) : "N/A") + "</td>";
                        html += "<td scope=\"col\">" + (y.imported_by) + "</td>";
                        html += "<td scope=\"col\">" + (y.year) + "</td>";
                        html += "<td scope=\"col\">" + (y.updated_date ? ViewDateformat(y.updated_date) : "N/A") + "</td>";

                        let href = "<?= base_url()?>"+"cms/import-target-sell-out-pa/view/"+`${y.year}`;

                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                            html+="<td class='center-content' style='width: 25%; min-width: 300px'>";
                            
                            html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.year_id+
                            "')\" data-status='"+y.status+"' id='"+y.id+
                            "' title='Delete Item'><span class='glyphicon glyphicon-pencil'>Delete</span>";

                            html+="<a class='btn-sm btn view' href='"+ href +"' data-status='"+y.status+
                            "' target='_blank' id='"+y.id+
                            "' title='View'><span class='glyphicon glyphicon-pencil'>View</span>";

                            html+="<a class='btn-sm btn save' onclick=\"export_data('"+y.year+
                            "')\" data-status='"+y.status+"' id='"+y.id+
                            "' title='Export Data'><span class='glyphicon glyphicon-pencil'>Export</span>";

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

    function get_pagination(new_query) {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
          event : "pagination",
          select : "a.created_date, u.name imported_by, b.year, a.updated_date",
          query : new_query,
          offset : offset,
          limit : limit,
          table : "tbl_accounts_target_sellout_pa a",
          join: [
              {
                  table: "tbl_year b",
                  query: "a.year = b.id",
                  type: "left"
              },
              {
                  table: "cms_users u",
                  query: "u.id = a.created_by",
                  type: "left"
              }
          ],
          group : "a.year"

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
            // a.created_date, u.name imported_by, b.year, a.updated_date
            var new_query = "(" + query + " AND u.name LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND b.year LIKE '%" + keyword + "%')";
            get_data(new_query);
            get_pagination(new_query);
        }
    });
    
    // uses function get_data(
    $(document).on("change", ".record-entries", function(e) {
        $(".record-entries option").removeAttr("selected");
        $(".record-entries").val($(this).val());
        $(".record-entries option:selected").attr("selected","selected");
        var record_entries = $(this).prop( "selected",true ).val();
        limit = parseInt(record_entries);
        offset = 1;
        modal.loading(true); 
        get_data(query);
        modal.loading(false);
    });
    
    function edit_data(id) {
        open_modal('Edit Target Sellout per Account', 'edit', id);
    }
    
    function view_data(id) {
        open_modal('View Target Sellout per Account', 'view', id);
    }
    
    function open_modal(msg, actions, id) {
        $(".form-control").css('border-color','#ccc');
        $(".validate_error_message").remove();
        let $modal = $('#popup_modal');
        let $footer = $modal.find('.modal-footer');

        $modal.find('.modal-title b').html(addNbsp(msg));
        reset_modal_fields();

        let buttons = {
            save: create_button('Save', 'save_data', 'btn save', function () {
                if (validate.standard("form-modal")) {
                    save_data('save', null);
                }
            }),
            edit: create_button('Update', 'edit_data', 'btn update', function () {
                save_data('update', id);
               
            }),
            close: create_button('Close', 'close_data', 'btn caution', function () {
                $modal.modal('hide');
            })
        };

        if (['edit', 'view'].includes(actions)) populate_modal(id);
        
        let isReadOnly = actions === 'view';
        let fields = [
            "payment_group", "vendor", "overall", "kam_kas_kaa", "sales_group", "terms", "channel", "brand", "exclusivity", "category",
            "lmi_code", "rgdi_code", "customer_sku_code", "item_description", "item_status", "srp", "trade_discount", "customer_cost",
            "customer_cost_net_of_vat", "jan_tq", "feb_tq", "mar_tq", "apr_tq", "may_tq", "jun_tq", "jul_tq", "aug_tq", "sep_tq", "oct_tq",
            "nov_tq", "dec_tq", "jan_ta", "feb_ta", "mar_ta", "apr_ta", "may_ta", "jun_ta", "jul_ta", "aug_ta", "sep_ta", "oct_ta", "nov_ta",
            "dec_ta"
        ];

        set_field_state(fields.map(id => `#${id}`).join(', '), isReadOnly);

        $footer.empty();
        if (actions === 'add') $footer.append(buttons.save);
        if (actions === 'edit') $footer.append(buttons.edit);
        $footer.append(buttons.close);

        $modal.modal('show');
    }

    function reset_modal_fields() {
        let fields = [
            "payment_group", "vendor", "overall", "kam_kas_kaa", "sales_group", "terms", "channel", "brand", "exclusivity", "category",
            "lmi_code", "rgdi_code", "customer_sku_code", "item_description", "item_status", "srp", "trade_discount", "customer_cost",
            "customer_cost_net_of_vat", "jan_tq", "feb_tq", "mar_tq", "apr_tq", "may_tq", "jun_tq", "jul_tq", "aug_tq", "sep_tq", "oct_tq",
            "nov_tq", "december_tq", "jan_ta", "feb_ta", "mar_ta", "apr_ta", "may_ta", "jun_ta", "jul_ta", "aug_ta", "sep_ta",
            "oct_ta", "nov_ta", "dec_ta"
        ];

        fields.forEach(field => {
            $(`#popup_modal #${field}`).val('');
        });

        $('#popup_modal #status').prop('checked', true);
    }

    function clear_import_table() {
        $(".import_table").empty()
    }

    function paginateData(rowsPerPage) {
        totalPages = Math.ceil(dataset.length / rowsPerPage);
        currentPage = 1;
        display_imported_data();
    }

    function set_field_state(selector, isReadOnly) {
        $(selector).prop({ readonly: isReadOnly, disabled: isReadOnly });
    }

    $(document).on('click', '#btn_import ', function() {
        title = addNbsp('IMPORT TARGET SELL OUT PER ACCOUNT')
        $("#import_modal").find('.modal-title').find('b').html(title)
        $("#import_modal").modal('show')
        clear_import_table();
        get_year('yearSelect');
    });
    
    function populate_modal(inp_id) {
        var query = "status >= 0 and id = " + inp_id;
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : `id, payment_group, vendor, overall, kam_kas_kaa, sales_group, terms, channel, brand, exclusivity, category, 
            lmi_code, rgdi_code, customer_sku_code, item_description, item_status, srp, trade_discount, customer_cost, customer_cost_net_of_vat,
            january_tq, february_tq, march_tq, april_tq, may_tq, june_tq, july_tq, august_tq, september_tq, october_tq, november_tq, december_tq,
            january_ta, february_ta, march_ta, april_ta, may_ta, june_ta, july_ta, august_ta, september_ta, october_ta, november_ta, december_ta,
            created_date, updated_date`.replace(/\s+/g, ' '),
            query : query, 
            table : "tbl_accounts_target_sellout_pa"
        }
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(index,d) {
                    $('#id').val(d.id);
                    $('#payment_group').val(d.payment_group);
                    $('#vendor').val(d.vendor);
                    $('#overall').val(d.overall);
                    $('#kam_kas_kaa').val(d.kam_kas_kaa);
                    $('#sales_group').val(d.sales_group);
                    $('#terms').val(d.terms);
                    $('#channel').val(d.channel);
                    $('#brand').val(d.brand);
                    $('#exclusivity').val(d.exclusivity);
                    $('#category').val(d.category);
                    $('#lmi_code').val(d.lmi_code);
                    $('#rgdi_code').val(d.rgdi_code);
                    $('#customer_sku_code').val(d.customer_sku_code);
                    $('#item_description').val(d.item_description);
                    $('#item_status').val(d.item_status);
                    $('#srp').val(d.srp);
                    $('#trade_discount').val(d.trade_discount);
                    $('#customer_cost').val(d.customer_cost);
                    $('#customer_cost_net_of_vat').val(d.customer_cost_net_of_vat);
                    $('#jan_tq').val(d.january_tq);
                    $('#feb_tq').val(d.february_tq);
                    $('#mar_tq').val(d.march_tq);
                    $('#apr_tq').val(d.april_tq);
                    $('#may_tq').val(d.may_tq);
                    $('#jun_tq').val(d.june_tq);
                    $('#jul_tq').val(d.july_tq);
                    $('#aug_tq').val(d.august_tq);
                    $('#sep_tq').val(d.september_tq);
                    $('#oct_tq').val(d.october_tq);
                    $('#nov_tq').val(d.november_tq);
                    $('#dec_tq').val(d.december_tq);
                    $('#jan_ta').val(d.january_ta);
                    $('#feb_ta').val(d.february_ta);
                    $('#mar_ta').val(d.march_ta);
                    $('#apr_ta').val(d.april_ta);
                    $('#may_ta').val(d.may_ta);
                    $('#jun_ta').val(d.june_ta);
                    $('#jul_ta').val(d.july_ta);
                    $('#aug_ta').val(d.august_ta);
                    $('#sep_ta').val(d.september_ta);
                    $('#oct_ta').val(d.october_ta);
                    $('#nov_ta').val(d.november_ta);
                    $('#dec_ta').val(d.december_ta);
                }); 
            }
        });
    }
    
    function create_button(btn_txt, btn_id, btn_class, onclick_event) {
        var new_btn = $('<button>', {
            text: btn_txt,
            id: btn_id,
            class: btn_class,
            click: onclick_event
        });
        return new_btn;
    }

    function save_to_db(inp_payment_group, inp_vendor, inp_overall, inp_kam_kas_kaa, inp_sales_group, inp_terms, inp_channel, inp_brand, inp_exclusivity, inp_category, 
        inp_lmi_code, inp_rgdi_code, inp_sku_code, inp_item_description, inp_item_status, inp_srp, inp_trade_discount,
        inp_customer_cost, inp_customer_cost_nov, inp_jantq, inp_febtq, inp_martq, 
        inp_aprtq, inp_maytq, inp_juntq, inp_jultq, inp_augtq, inp_septq, inp_octtq,
        inp_novtq, inp_dectq, inp_janta, inp_febta, inp_marta, inp_aprta,
        inp_julta, inp_augta, inp_septa, inp_octta, inp_novta, inp_decta, id) {

        const url = "<?= base_url('cms/global_controller'); ?>";
        let data = {}; 
        let modal_alert_success;

        if (id !== undefined && id !== null && id !== '') {
            modal_alert_success = success_update_message;
            data = {
                event: "update",
                table: "tbl_accounts_target_sellout_pa",
                field: "id",
                where: id,
                data: {
                    payment_group: inp_payment_group,
                    vendor: inp_vendor,
                    overall: inp_overall,
                    kam_kas_kaa: inp_kam_kas_kaa,
                    sales_group: inp_sales_group,
                    terms: inp_terms,
                    channel: inp_channel,
                    brand: inp_brand,
                    exclusivity: inp_exclusivity,
                    category: inp_category, 
                    lmi_code: inp_lmi_code,
                    rgdi_code: inp_rgdi_code,
                    customer_sku_code: inp_sku_code,
                    item_description: inp_item_description,
                    item_status: inp_item_status,
                    srp: inp_srp,
                    trade_discount: inp_trade_discount,
                    customer_cost: inp_customer_cost,
                    customer_cost_net_of_vat: inp_customer_cost_nov,
                    january_tq: inp_jantq,
                    february_tq: inp_febtq,
                    march_tq: inp_martq,
                    april_tq: inp_aprtq,
                    may_tq: inp_maytq,
                    june_tq: inp_juntq,
                    july_tq: inp_jultq,
                    august_tq: inp_augtq,
                    september_tq: inp_septq,
                    october_tq: inp_octtq,
                    november_tq: inp_novtq,
                    december_tq: inp_dectq,
                    january_ta: inp_janta,
                    february_ta: inp_febta,
                    march_ta: inp_marta,
                    april_ta: inp_aprta,
                    may_ta: inp_marta,
                    june_ta: inp_junta,
                    july_ta: inp_julta,
                    august_ta: inp_augta,
                    september_ta: inp_septa,
                    october_ta: inp_octta,
                    november_ta: inp_novta,
                    december_ta: inp_decta,
                    updated_date: formatDate(new Date()),
                    updated_by: user_id,
          
                }
            };
        } else {
            modal_alert_success = success_save_message;
            data = {
                event: "insert",
                table: "tbl_accounts_target_sellout_pa",
                data: {
                    payment_group: inp_payment_group,
                    vendor: inp_vendor,
                    overall: inp_overall,
                    kam_kas_kaa: inp_kam_kas_kaa,
                    sales_group: inp_sales_group,
                    terms: inp_terms,
                    channel: inp_channel,
                    brand: inp_brand,
                    exclusivity: inp_exclusivity,
                    category: inp_category, 
                    lmi_code: inp_lmi_code,
                    rgdi_code: inp_rgdi_code,
                    customer_sku_code: inp_sku_code,
                    item_description: inp_item_description,
                    item_status: inp_item_status,
                    srp: inp_srp,
                    trade_discount: inp_trade_discount,
                    customer_cost: inp_customer_cost,
                    customer_cost_net_of_vat: inp_customer_cost_nov,
                    january_tq: inp_jantq,
                    february_tq: inp_febtq,
                    march_tq: inp_martq,
                    april_tq: inp_aprtq,
                    may_tq: inp_maytq,
                    june_tq: inp_juntq,
                    july_tq: inp_jultq,
                    august_tq: inp_augtq,
                    september_tq: inp_septq,
                    october_tq: inp_octtq,
                    november_tq: inp_novtq,
                    december_tq: inp_dectq,
                    january_ta: inp_janta,
                    february_ta: inp_febta,
                    march_ta: inp_marta,
                    april_ta: inp_aprta,
                    may_ta: inp_marta,
                    june_ta: inp_junta,
                    july_ta: inp_julta,
                    august_ta: inp_augta,
                    september_ta: inp_septa,
                    october_ta: inp_octta,
                    november_ta: inp_novta,
                    december_ta: inp_decta,
                    updated_date: formatDate(new Date()),
                    updated_by: user_id,
                }
            };
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result);
            modal.loading(false);
            modal.alert(modal_alert_success, 'success', function() {
                location.reload();
            });
        });
    }

    function save_data(action, id) {


        var payment_group = $('#payment_group').val();
        var vendor = $('#vendor').val();
        var overall = $('#overall').val();
        var kam_kas_kaa = $('#kam_kas_kaa').val();
        var sales_group = $('#sales_group').val();
        var terms = $('#terms').val();
        var channel = $('#channel').val();
        var brand = $('#brand').val();
        var exclusivity = $('#exclusivity').val();
        var category = $('#category').val();
        var lmi_code = $('#lmi_code').val();
        var rgdi_code = $('#rgdi_code').val();
        var customer_sku_code = $('#customer_sku_code').val();
        var item_description = $('#item_description').val();
        var item_status = $('#item_status').val();
        var srp = $('#srp').val();
        var trade_discount = $('#trade_discount').val();
        var customer_cost = $('#customer_cost').val();
        var customer_cost_nov = $('#customer_cost_net_of_vat').val();
        var jan_tq = $('#jan_tq').val();
        var feb_tq = $('#feb_tq').val();
        var mar_tq = $('#mar_tq').val();
        var apr_tq = $('#apr_tq').val();
        var may_tq = $('#may_tq').val();
        var jun_tq = $('#jun_tq').val();
        var jul_tq = $('#jul_tq').val();
        var aug_tq = $('#aug_tq').val();
        var sep_tq = $('#sep_tq').val();
        var oct_tq = $('#oct_tq').val();
        var nov_tq = $('#nov_tq').val();
        var dec_tq = $('#dec_tq').val();
        var jan_ta = $('#jan_ta').val();
        var feb_ta = $('#feb_ta').val();
        var mar_ta = $('#mar_ta').val();
        var apr_ta = $('#apr_ta').val();
        var may_ta = $('#may_ta').val();
        var jun_ta = $('#jun_ta').val();
        var jul_ta = $('#jul_ta').val();
        var aug_ta = $('#aug_ta').val();
        var sep_ta = $('#sep_ta').val();
        var oct_ta = $('#oct_ta').val();
        var nov_ta = $('#nov_ta').val();
        var dec_ta = $('#dec_ta').val();

        if (validate.standard("form-modal")) {
            if (id !== undefined && id !== null && id !== '') {
                modal.confirm(confirm_update_message, function (result) {
                    if (result) {
                        modal.loading(true);
                        save_to_db(
                            payment_group, vendor, overall, kam_kas_kaa, sales_group, terms, 
                            channel, brand, exclusivity, category, lmi_code, rgdi_code, 
                            customer_sku_code, item_description, item_status, srp, 
                            trade_discount, customer_cost, customer_cost_nov, 
                            jan_tq, feb_tq, mar_tq, apr_tq, may_tq, jun_tq, jul_tq, aug_tq,
                            sep_tq, oct_tq, nov_tq, dec_tq, totalQty,
                            jan_ta, feb_ta, mar_ta, apr_ta, may_ta, jun_ta, jul_ta, aug_ta,
                            sep_ta, oct_ta, nov_ta, dec_ta, totalAmnt, id
                        );
                    }
                });
            }
        }
    }

    function delete_data(year) {
        modal.confirm(confirm_delete_message,function(result){
            if(result){
                var url = "<?= base_url('cms/global_controller');?>";
                var formattedData = [];
        
                dynamic_search(
                    "'tbl_accounts_target_sellout_pa a'", 
                    "'left join tbl_year y on y.id = a.year'", 
                    "'a.id'", 
                    0, 
                    0, 
                    `'y.year:EQ=${year}'`,  
                    `''`, 
                    `''`,
                    (res) => {
                        year = [year];
                        console.log(year);
                        batch_delete(url, "tbl_accounts_target_sellout_pa", "year", year, 'year', function(resp) {
                            modal.alert("Selected records deleted successfully!", 'success', () => location.reload());
                        });
                    }
                )
            }
        })
    }

    function read_xl_file() {
        let btn = $(".btn.save");
        btn.prop("disabled", false);
        clear_import_table();

        dataset = [];

        const file = $("#file")[0].files[0];
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

            let jsonData = XLSX.utils.sheet_to_json(sheet, { raw: true });

            // Ensure special characters like "ñ" are correctly preserved
            jsonData = jsonData.map(row => {
                let fixedRow = {};
                Object.keys(row).forEach(key => {
                    let value = row[key];

                    // Convert numbers to text while keeping dates unchanged
                    if (typeof value === "number") {
                        value = String(value);
                    }

                    fixedRow[key] = value !== null && value !== undefined ? value : "";
                });
                return fixedRow;
            });

            console.log(jsonData);

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

            let td_validator = ['payment group', 'vendor', 'overall', 'kam/kas/kaa', 'sales group', 'terms', 'channel', 'brand', 'exclusivity', 'category', 'lmi code', 'rgdi code', 'customer sku code', 'item description', 'item status', 'srp', 'trade discount', 'customer cost', 'customer cost (net of vat)', 'january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december', 'januaryta', 'februaryta', 'marchta', 'aprilta', 'mayta', 'juneta', 'julyta', 'augustta', 'septemberta', 'octoberta', 'novemberta', 'decemberta'];
            td_validator.forEach(column => {
                let value = lowerCaseRecord[column] !== undefined ? lowerCaseRecord[column] : "";

                html += `<td>${value}</td>`;
            });

            html += "</tr>";
            tr_counter += 1;
        });

        modal.loading(false);
        $(".import_table").html(html);
        updatePaginationControls();
    }

    function updatePaginationControls() {
        let paginationHtml = `
            <button onclick="firstPage()" ${currentPage === 1 ? "disabled" : ""}><i class="fas fa-angle-double-left"></i></button>
            <button onclick="prevPage()" ${currentPage === 1 ? "disabled" : ""}><i class="fas fa-angle-left"></i></button>
            
            <select onchange="goToPage(this.value)">
                ${Array.from({ length: totalPages }, (_, i) => 
                    `<option value="${i + 1}" ${i + 1 === currentPage ? "selected" : ""}>Page ${i + 1}</option>`
                ).join('')}
            </select>
            
            <button onclick="nextPage()" ${currentPage === totalPages ? "disabled" : ""}><i class="fas fa-angle-right"></i></button>
            <button onclick="lastPage()" ${currentPage === totalPages ? "disabled" : ""}><i class="fas fa-angle-double-right"></i></button>
        `;

        $(".import_pagination").html(paginationHtml);
    }
    
    function process_xl_file() {
        let btn = $(".btn.save");
        if (btn.prop("disabled")) return; // Prevent multiple clicks

        btn.prop("disabled", true);
        $(".import_buttons").find("a.download-error-log").remove();
        setTimeout(() => {
            btn.prop("disabled", false);
        }, 4000);
        const year = $('#yearSelect').val()?.trim();

        const fields = { year };

        for (const [key, value] of Object.entries(fields)) {
            if (!value) {
                return modal.alert(`Please select a ${key.charAt(0).toUpperCase() + key.slice(1)}.`, 'error', () => {});
            }
        }

        if (dataset.length === 0) {
            return modal.alert('No data to process. Please upload a file.', 'error', () => {});
        }
        modal.loading(true);

        let jsonData = dataset.map(row => {
            return {
                "Payment Group": row["Payment Group"] || "",
                "Vendor": row["Vendor"] || "",
                "Overall": row["Overall"] || "",
                "KAM/KAS/KAA": row["KAM/KAS/KAA"] || "",
                "Sales Group": row["Sales Group"] || "",
                "Terms": row["Terms"] || "",
                "Channel": row["Channel"] || "",
                "Brand": row["Brand"] || "",
                "Exclusivity": row["Exclusivity"] || "",
                "Category": row["Category"] || "",
                "LMI Code": row["LMI Code"] || "",
                "RGDI Code": row["RGDI Code"] || "",
                "Customer SKU Code": row["Customer SKU Code"] || "",
                "Item Description": row["Item Description"] || "",
                "Item status": row["Item status"] || "",
                "SRP": row["SRP"] || "",
                "Trade Discount": row["Trade Discount"] || "",
                "Customer Cost": row["Customer Cost"] || "",
                "Customer Cost (Net of Vat)": row["Customer Cost (Net of Vat)"] || "",
                "January": row["January"] || "",
                "February": row["February"] || "",
                "March": row["March"] || "",
                "April": row["April"] || "",
                "May": row["May"] || "",
                "June": row["June"] || "",
                "July": row["July"] || "",
                "August": row["August"] || "",
                "September": row["September"] || "",
                "October": row["October"] || "",
                "November": row["November"] || "",
                "December": row["December"] || "",
                "JanuaryTA": row["JanuaryTA"] || "",
                "FebruaryTA": row["FebruaryTA"] || "",
                "MarchTA": row["MarchTA"] || "",
                "AprilTA": row["AprilTA"] || "",
                "MayTA": row["MayTA"] || "",
                "JuneTA": row["JuneTA"] || "",
                "JulyTA": row["JulyTA"] || "",
                "AugustTA": row["AugustTA"] || "",
                "SeptemberTA": row["SeptemberTA"] || "",
                "OctoberTA": row["OctoberTA"] || "",
                "NovemberTA": row["NovemberTA"] || "",
                "DecemberTA": row["DecemberTA"] || "",
                "Created by": user_id || "",
                "Created Date": formatDate(new Date()) || ""
            };
        });

        let worker = new Worker(base_url + "assets/cms/js/validator_target_sell_out_pa.js");
        worker.postMessage({ data: jsonData, base_url });

        worker.onmessage = function(e) {
            modal.loading_progress(false);
            const { invalid, errorLogs, valid_data, err_counter } = e.data;
            console.log(invalid);
            console.log(valid_data, 'valid_data');
            if (invalid) {
                let errorMsg = err_counter > 1000 
                    ? '⚠️ Too many errors detected. Please download the error log for details.'
                    : errorLogs.join("<br>");
                modal.content('Validation Error', 'error', errorMsg, '600px', () => { 
                    read_xl_file();
                    btn.prop("disabled", false);
                });
                createErrorLogFile(errorLogs, "Error " + formatReadableDate(new Date(), true));
            } else if (Array.isArray(valid_data) && valid_data.length > 0) { 
                btn.prop("disabled", false);
                updateSwalProgress("Validation Completed", 10);
                new_data = valid_data.map(record => ({
                    ...record,
                    year: year
                }));
                setTimeout(() => saveValidatedData(new_data), 500);
            } else {
                btn.prop("disabled", false);
                setTimeout(() => {
                    modal.alert("No valid data returned. Please check the file and try again.", "error", () => {});
                }, 500);
                
            }
        };

        worker.onerror = function() {
            modal.loading_progress(false);
            modal.alert("Error processing data. Please try again.", "error");
        };
    }

    function fixEncoding(text) {
        let correctedText = text.replace(/\uFFFD|\u0092/g, "’");
        return correctedText;
    }

    function saveValidatedData(valid_data) {
        let batch_size = 1000; // Process 1000 records at a time
        let total_batches = Math.ceil(valid_data.length / batch_size);
        let batch_index = 0;
        let errorLogs = [];
        let url = "<?= base_url('cms/global_controller');?>";
        let table = 'tbl_accounts_target_sellout_pa';

        let selected_fields = [
            'id', 'payment_group', 'vendor', 'overall', 'kam_kas_kaa', 'sales_group',
            'terms', 'channel', 'brand', 'exclusivity', 'category', 'lmi_code',
            'rgdi_code', 'customer_sku_code', 'item_description', 'item_status', 'trade_discount',
            'customer_cost', 'customer_cost_net_of_vat',
            'srp', 'january_tq', 'february_tq', 'march_tq', 'april_tq',
            'may_tq', 'june_tq', 'july_tq', 'august_tq', 'september_tq', 'october_tq', 'november_tq', 'december_tq',
            'january_ta', 'february_ta', 'march_ta', 'april_ta',
            'may_ta', 'june_ta', 'july_ta', 'august_ta', 'september_ta', 'october_ta', 'november_ta', 'december_ta',
            'year'
        ];

        const matchFields = [
            'payment_group', 'vendor', 'overall', 'kam_kas_kaa', 'sales_group',
            'terms', 'channel', 'brand', 'exclusivity', 'category', 'lmi_code',
            'rgdi_code', 'customer_sku_code', 'item_description', 'item_status', 'trade_discount',
            'customer_cost', 'customer_cost_net_of_vat',
            'srp', 'january_tq', 'february_tq', 'march_tq', 'april_tq',
            'may_tq', 'june_tq', 'july_tq', 'august_tq', 'september_tq', 'october_tq', 'november_tq', 'december_tq',
            'january_ta', 'february_ta', 'march_ta', 'april_ta',
            'may_ta', 'june_ta', 'july_ta', 'august_ta', 'september_ta', 'october_ta', 'november_ta', 'december_ta',
            'year'
        ]; 

        const floatFields = [
            'srp', 'january_tq', 'february_tq', 'march_tq', 'april_tq', 'may_tq', 'june_tq', 'july_tq', 'august_tq',
            'september_tq', 'october_tq', 'november_tq', 'december_tq',
            'january_ta', 'february_ta', 'march_ta', 'april_ta', 'may_ta', 'june_ta', 'july_ta', 'august_ta',
            'september_ta', 'october_ta', 'november_ta', 'december_ta'
        ];

        const matchType = "AND";  // Use "AND" or "OR" for matching logic

        modal.loading_progress(true, "Validating and Saving data...");

        aJax.post(url, { table: table, event: "fetch_existing", selected_fields: selected_fields }, function(response) {
            let result = JSON.parse(response);
            let existingMap = new Map();

            if (result.existing) {
                result.existing.forEach(record => {
                    let key = matchFields.map(field => {
                        let value = record[field] || "";
                        return floatFields.includes(field) ? parseFloat(value) || 0 : String(value).trim().toLowerCase();
                    }).join("|");

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
                        modal.alert("All records saved/updated successfully!", 'success', () => location.reload());
                    }
                    return;
                }

                let batch = valid_data.slice(batch_index * batch_size, (batch_index + 1) * batch_size);
                let newRecords = [];
                let updateRecords = [];

                batch.forEach(row => {
                    let matchedId = null;

                    if (matchType === "AND") {
                        let key = matchFields.map(field => {
                            let value = row[field] || "";
                            return floatFields.includes(field) ? parseFloat(value) || 0 : String(value).trim().toLowerCase();
                        }).join("|");

                        if (existingMap.has(key)) {
                            matchedId = existingMap.get(key);
                        }
                    } else if (matchType === "OR") {
                        for (let [key, id] of existingMap.entries()) {
                            let keyParts = key.split("|");
                            for (let field of matchFields) {
                                let value = row[field] || "";
                                let formattedValue = floatFields.includes(field) ? parseFloat(value) || 0 : String(value).trim().toLowerCase();
                                if (keyParts.includes(formattedValue)) {
                                    matchedId = id;
                                    break;
                                }
                            }
                            if (matchedId) break;
                        }
                    }

                    if (matchedId) {
                        row.id = matchedId;
                        row.updated_by = user_id;
                        row.updated_date = formatDate(new Date());
                        delete row.created_date;
                        updateRecords.push(row);

                    } else {
                        row.created_by = user_id;
                        row.created_date = formatDate(new Date());
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

    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0'); 
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');
        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }

    $(document).on('click', '.btn_status', function (e) {
        var status = $(this).attr("data-status");
        var modal_obj = "";
        var modal_alert_success = "";
        var hasExecuted = false;

        if (parseInt(status) === -2) {
            modal_obj = confirm_delete_message;
            modal_alert_success = success_delete_message;
            offset = 1;
        } else if (parseInt(status) === 1) {
            modal_obj = confirm_publish_message;
            modal_alert_success = success_publish_message;
        } else {
            modal_obj = confirm_unpublish_message;
            modal_alert_success = success_unpublish_message;
        }
        modal.confirm(modal_obj, function (result) {
            if (result) {
                var url = "<?= base_url('cms/global_controller');?>";
                var dataList = [];
                
                $('.select:checked').each(function () {
                    var id = $(this).attr('data-id');
                    dataList.push({
                        event: "update",
                        table: "tbl_accounts_target_sellout_pa",
                        field: "id",
                        where: id,
                        data: {
                            status: status,
                            updated_date: formatDate(new Date())
                        }
                    });
                });

                if (dataList.length === 0) return;

                var processed = 0;
                dataList.forEach(function (data, index) {
                    aJax.post(url, data, function (result) {
                        if (hasExecuted) return;

                        modal.loading(false);
                        processed++;

                        if (result === "success") {
                            if (!hasExecuted) {
                                hasExecuted = true;
                                $('.btn_status').hide();
                                modal.alert(modal_alert_success, "success", function () {
                                    location.reload();
                                });
                            }
                        } else {
                            if (!hasExecuted) {
                                hasExecuted = true;
                                modal.alert(failed_transaction_message, "error", function () {});
                            }
                        }
                    });
                });
            }
        });
    });
        
    function trimText(str, length) {
        if (str.length > length) {
            return str.substring(0, length) + "...";
        } else {
            return str;
        }
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

    $(document).on('click', '#btn_export ', function() {
        title = addNbsp('EXPORT Target Sellout PA');
        $("#export_modal").find('.modal-title').find('b').html(title)
        $('#export_modal').modal('show');
        get_year('year_select');
    });

    function download_template() {
        let formattedData = [
            {
                "Payment Group":"",
                "Vendor":"",
                "Overall":"",
                "KAM/KAS/KAA":"",
                "Sales Group":"",
                "Terms":"",
                "Channel":"",
                "Brand":"",
                "Exclusivity":"",
                "Category":"",
                "LMI Code":"",
                "RGDI Code":"",
                "Customer SKU Code":"",
                "Item Description":"",
                "Item status":"",
                "SRP":"",
                "Trade Discount":"",
                "Customer Cost":"",
                "Customer Cost (Net of Vat)":"",
                "January":"",
                "February":"",
                "March":"",
                "April":"",
                "May":"",
                "June":"",
                "July":"",
                "August":"",
                "September":"",
                "October":"",
                "November":"",
                "December":"",
                "JanuaryTA":"",
                "FebruaryTA":"",
                "MarchTA":"",
                "AprilTA":"",
                "MayTA":"",
                "JuneTA":"",
                "JulyTA":"",
                "AugustTA":"",
                "SeptemberTA":"",
                "OctoberTA":"",
                "NovemberTA":"",
                "DecemberTA":"",
                "NOTE:": "Please do not change the column headers."
            }
        ]
        const headerData = [];
    
        exportArrayToCSV(formattedData, `Target Sell Out per Account - ${formatDate(new Date())}`, headerData);
    }

    function exportFilter() {
        const year = $('#year_select').val()?.trim();

        const fields = { year };

        var formattedData = [];

        for (const [key, value] of Object.entries(fields)) {
            if (!value) {
                return modal.alert(`Please select a ${key.charAt(0).toUpperCase() + key.slice(1)}.`, 'error', () => {});
            }
        }

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
                "'tbl_accounts_target_sellout_pa'", 
                "''", 
                `'payment_group, vendor, overall, kam_kas_kaa, sales_group, 
                terms, channel, brand, exclusivity, 
                category, lmi_code, rgdi_code, 
                customer_sku_code, item_description, item_status, srp, trade_discount,
                customer_cost, customer_cost_net_of_vat, 
                january_tq, february_tq, march_tq, april_tq, may_tq, june_tq, 
                july_tq, august_tq, september_tq, october_tq, november_tq, december_tq,
                january_ta, february_ta, march_ta, april_ta, may_ta, june_ta, 
                july_ta, august_ta, september_ta, october_ta, november_ta, december_ta'`, 
                0, 
                0, 
                `"year:EQ=${year}"`,  
                `''`, 
                `''`,
                (res) => {
                    console.log(year, res);
                    let store_ids = []
                    let store_map = {}
            
                    let newData = res.map(({ 
                        payment_group, vendor, overall, kam_kas_kaa, sales_group, 
                        terms, channel, brand, exclusivity, 
                        category, lmi_code, rgdi_code, 
                        customer_sku_code, item_description, item_status, srp, trade_discount,
                        customer_cost, customer_cost_net_of_vat, 
                        january_tq, february_tq, march_tq, april_tq, may_tq, june_tq, 
                        july_tq, august_tq, september_tq, october_tq, november_tq, december_tq,
                        january_ta, february_ta, march_ta, april_ta, may_ta, june_ta, 
                        july_ta, august_ta, september_ta, october_ta, november_ta, december_ta,
                    }) => ({
                        "Payment Group":payment_group,
                        "Vendor":vendor,
                        "Overall":overall,
                        "KAM/KAS/KAA":kam_kas_kaa,
                        "Sales Group":sales_group,
                        "Terms":terms,
                        "Channel":channel,
                        "Brand":brand,
                        "Exclusivity":exclusivity,
                        "Category":category,
                        "LMI Code":lmi_code,
                        "RGDI Code":rgdi_code,
                        "Customer SKU Code":customer_sku_code,
                        "Item Description":item_description,
                        "Item status":item_status,
                        "SRP":srp,
                        "Trade Discount":trade_discount,
                        "Customer Cost":customer_cost,
                        "Customer Cost (Net of Vat)":customer_cost_net_of_vat,
                        "January":january_tq,
                        "February":february_tq,
                        "March":march_tq,
                        "April":april_tq,
                        "May":may_tq,
                        "June":june_tq,
                        "July":july_tq,
                        "August":august_tq,
                        "September":september_tq,
                        "October":october_tq,
                        "November":november_tq,
                        "December":december_tq,
                        "JanuaryTA":january_ta,
                        "FebruaryTA":february_ta,
                        "MarchTA":march_ta,
                        "AprilTA":april_ta,
                        "MayTA":may_ta,
                        "JuneTA":june_ta,
                        "JulyTA":july_ta,
                        "AugustTA":august_ta,
                        "SeptemberTA":september_ta,
                        "OctoberTA":october_ta,
                        "NovemberTA":november_ta,
                        "DecemberTA":december_ta,
                    }));

                    formattedData.push(...newData); // Append new data to formattedData array
                }
            )
    
            const headerData = [
                ["Company Name: Lifestrong Marketing Inc."],
                ["Target Sell Out per Account"],
                ["Date Printed: " + formatDate(new Date())],
                [""],
            ];
    
            exportArrayToCSV(formattedData, `Target Sell Out per Account - ${formatDate(new Date())}`, headerData);
            modal.loading_progress(false);
        }
    }

    function handleExport() {
        var formattedData = [];
        var ids = [];

        $('.select:checked').each(function () {
            var id = $(this).attr('data-id');
            ids.push(`${id}`);
        });

        modal.confirm(confirm_export_message,function(result){
            if (result) {
                modal.loading_progress(true, "Reviewing Data...");
                setTimeout(() => {
                    startExport()
                }, 500);
            }
        })

        const startExport = () => {
            const fetchStores = (callback) => {
                function processResponse (res) {
                    formattedData = res.map(({ 
                        payment_group, vendor, overall, kam_kas_kaa, sales_group, 
                        terms, channel, brand, exclusivity, 
                        category, lmi_code, rgdi_code, 
                        customer_sku_code, item_description, item_status, srp, trade_discount,
                        customer_cost, customer_cost_net_of_vat, 
                        january_tq, february_tq, march_tq, april_tq, may_tq, june_tq, 
                        july_tq, august_tq, september_tq, october_tq, november_tq, december_tq,
                        january_ta, february_ta, march_ta, april_ta, may_ta, june_ta, 
                        july_ta, august_ta, september_ta, october_ta, november_ta, december_ta,
                    }) => ({
                        "Payment Group":payment_group,
                        "Vendor":vendor,
                        "Overall":overall,
                        "KAM/KAS/KAA":kam_kas_kaa,
                        "Sales Group":sales_group,
                        "Terms":terms,
                        "Channel":channel,
                        "Brand":brand,
                        "Exclusivity":exclusivity,
                        "Category":category,
                        "LMI Code":lmi_code,
                        "RGDI Code":rgdi_code,
                        "Customer SKU Code":customer_sku_code,
                        "Item Description":item_description,
                        "Item status":item_status,
                        "SRP":srp,
                        "Trade Discount":trade_discount,
                        "Customer Cost":customer_cost,
                        "Customer Cost (Net of Vat)":customer_cost_net_of_vat,
                        "January":january_tq,
                        "February":february_tq,
                        "March":march_tq,
                        "April":april_tq,
                        "May":may_tq,
                        "June":june_tq,
                        "July":july_tq,
                        "August":august_tq,
                        "September":september_tq,
                        "October":october_tq,
                        "November":november_tq,
                        "December":december_tq,
                        "JanuaryTA":january_ta,
                        "FebruaryTA":february_ta,
                        "MarchTA":march_ta,
                        "AprilTA":april_ta,
                        "MayTA":may_ta,
                        "JuneTA":june_ta,
                        "JulyTA":july_ta,
                        "AugustTA":august_ta,
                        "SeptemberTA":september_ta,
                        "OctoberTA":october_ta,
                        "NovemberTA":november_ta,
                        "DecemberTA":december_ta,
                    }));
                };

                ids.length > 0 
                    ? dynamic_search(
                        "'tbl_accounts_target_sellout_pa'", 
                        "''", 
                        `'payment_group, vendor, overall, kam_kas_kaa, sales_group, 
                        terms, channel, brand, exclusivity, 
                        category, lmi_code, rgdi_code, 
                        customer_sku_code, item_description, item_status, srp, trade_discount,
                        customer_cost, customer_cost_net_of_vat, 
                        january_tq, february_tq, march_tq, april_tq, may_tq, june_tq, 
                        july_tq, august_tq, september_tq, october_tq, november_tq, december_tq,
                        january_ta, february_ta, march_ta, april_ta, may_ta, june_ta, 
                        july_ta, august_ta, september_ta, october_ta, november_ta, december_ta'`, 
                        0, 
                        0, 
                        `"id:IN=${ids.join('|')}"`,  
                        `''`,
                        `''`,
                        processResponse
                    )
                    : batch_export();
            };

            const batch_export = () => {
                dynamic_search(
                    "'tbl_accounts_target_sellout_pa'", 
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
                                    "'tbl_accounts_target_sellout_pa'", 
                                    "''", 
                                    `'payment_group, vendor, overall, kam_kas_kaa, sales_group, 
                                    terms, channel, brand, exclusivity, 
                                    category, lmi_code, rgdi_code, 
                                    customer_sku_code, item_description, item_status, srp, trade_discount,
                                    customer_cost, customer_cost_net_of_vat, 
                                    january_tq, february_tq, march_tq, april_tq, may_tq, june_tq, 
                                    july_tq, august_tq, september_tq, october_tq, november_tq, december_tq,
                                    january_ta, february_ta, march_ta, april_ta, may_ta, june_ta, 
                                    july_ta, august_ta, september_ta, october_ta, november_ta, december_ta'`, 
                                    100000, 
                                    index, 
                                    `''`,  
                                    `''`,
                                    `''`,
                                    (res) => {
                                        let newData = res.map(({ 
                                            payment_group, vendor, overall, kam_kas_kaa, sales_group, 
                                            terms, channel, brand, exclusivity, 
                                            category, lmi_code, rgdi_code, 
                                            customer_sku_code, item_description, item_status, srp, trade_discount,
                                            customer_cost, customer_cost_net_of_vat, 
                                            january_tq, february_tq, march_tq, april_tq, may_tq, june_tq, 
                                            july_tq, august_tq, september_tq, october_tq, november_tq, december_tq,
                                            january_ta, february_ta, march_ta, april_ta, may_ta, june_ta, 
                                            july_ta, august_ta, september_ta, october_ta, november_ta, december_ta,
                                        }) => ({
                                            "Payment Group":payment_group,
                                            "Vendor":vendor,
                                            "Overall":overall,
                                            "KAM/KAS/KAA":kam_kas_kaa,
                                            "Sales Group":sales_group,
                                            "Terms":terms,
                                            "Channel":channel,
                                            "Brand":brand,
                                            "Exclusivity":exclusivity,
                                            "Category":category,
                                            "LMI Code":lmi_code,
                                            "RGDI Code":rgdi_code,
                                            "Customer SKU Code":customer_sku_code,
                                            "Item Description":item_description,
                                            "Item status":item_status,
                                            "SRP":srp,
                                            "Trade Discount":trade_discount,
                                            "Customer Cost":customer_cost,
                                            "Customer Cost (Net of Vat)":customer_cost_net_of_vat,
                                            "January":january_tq,
                                            "February":february_tq,
                                            "March":march_tq,
                                            "April":april_tq,
                                            "May":may_tq,
                                            "June":june_tq,
                                            "July":july_tq,
                                            "August":august_tq,
                                            "September":september_tq,
                                            "October":october_tq,
                                            "November":november_tq,
                                            "December":december_tq,
                                            "JanuaryTA":january_ta,
                                            "FebruaryTA":february_ta,
                                            "MarchTA":march_ta,
                                            "AprilTA":april_ta,
                                            "MayTA":may_ta,
                                            "JuneTA":june_ta,
                                            "JulyTA":july_ta,
                                            "AugustTA":august_ta,
                                            "SeptemberTA":september_ta,
                                            "OctoberTA":october_ta,
                                            "NovemberTA":november_ta,
                                            "DecemberTA":december_ta,
                                        }));
                                        formattedData.push(...newData); // Append new data to formattedData array
                                    }
                                )
                            }
                        } else {
                            console.log('No data received');
                        }
                    }
                )
            };

            fetchStores();

            const headerData = [
                ["Company Name: Lifestrong Marketing Inc."],
                ["Target Sell Out per Account"],
                ["Date Printed: " + formatDate(new Date())],
                [""],
            ];

            exportArrayToCSV(formattedData, `Target Sell Out per Account - ${formatDate(new Date())}`, headerData);
            modal.loading_progress(false);
        }
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
    
    function export_data(year) {
        var formattedData = [];
        dynamic_search(
            "'tbl_accounts_target_sellout_pa a'", 
            "'left join tbl_year y on y.id = a.year'", 
            "'COUNT(a.id) as total_records'", 
            0, 
            0, 
            `'y.year:EQ=${year}'`,  
            `''`, 
            `''`,
            (result) => {
                let total_records = result[0].total_records;
                for (let index = 0; index < total_records; index += 100000) {
                    dynamic_search(
                        "'tbl_accounts_target_sellout_pa a'", 
                        "'left join tbl_year y on y.id = a.year'", 
                        "'a.payment_group, a.vendor, a.overall, a.kam_kas_kaa, a.sales_group, "+
                        "a.terms, a.channel, a.brand, a.exclusivity, "+
                        "a.category, a.lmi_code, a.rgdi_code, "+
                        "a.customer_sku_code, a.item_description, a.item_status, a.srp, a.trade_discount,"+
                        "a.customer_cost, a.customer_cost_net_of_vat, "+
                        "a.january_tq, a.february_tq, a.march_tq, a.april_tq, a.may_tq, a.june_tq, "+
                        "a.july_tq, a.august_tq, a.september_tq, a.october_tq, a.november_tq, a.december_tq,"+
                        "a.january_ta, a.february_ta, a.march_ta, a.april_ta, a.may_ta, a.june_ta, "+
                        "a.july_ta, a.august_ta, a.september_ta, a.october_ta, a.november_ta, a.december_ta'", 
                        100000, 
                        index, 
                        `'y.year:EQ=${year}'`,  
                        `''`, 
                        `''`,
                        (result) => {
                            let newData = result.map(({ 
                                payment_group, vendor, overall, kam_kas_kaa, sales_group, 
                                terms, channel, brand, exclusivity, 
                                category, lmi_code, rgdi_code, 
                                customer_sku_code, item_description, item_status, srp, trade_discount,
                                customer_cost, customer_cost_net_of_vat, 
                                january_tq, february_tq, march_tq, april_tq, may_tq, june_tq, 
                                july_tq, august_tq, september_tq, october_tq, november_tq, december_tq,
                                january_ta, february_ta, march_ta, april_ta, may_ta, june_ta, 
                                july_ta, august_ta, september_ta, october_ta, november_ta, december_ta,
                            }) => ({
                                "Payment Group":payment_group,
                                "Vendor":vendor,
                                "Overall":overall,
                                "KAM/KAS/KAA":kam_kas_kaa,
                                "Sales Group":sales_group,
                                "Terms":terms,
                                "Channel":channel,
                                "Brand":brand,
                                "Exclusivity":exclusivity,
                                "Category":category,
                                "LMI Code":lmi_code,
                                "RGDI Code":rgdi_code,
                                "Customer SKU Code":customer_sku_code,
                                "Item Description":item_description,
                                "Item status":item_status,
                                "SRP":srp,
                                "Trade Discount":trade_discount,
                                "Customer Cost":customer_cost,
                                "Customer Cost (Net of Vat)":customer_cost_net_of_vat,
                                "January":january_tq,
                                "February":february_tq,
                                "March":march_tq,
                                "April":april_tq,
                                "May":may_tq,
                                "June":june_tq,
                                "July":july_tq,
                                "August":august_tq,
                                "September":september_tq,
                                "October":october_tq,
                                "November":november_tq,
                                "December":december_tq,
                                "JanuaryTA":january_ta,
                                "FebruaryTA":february_ta,
                                "MarchTA":march_ta,
                                "AprilTA":april_ta,
                                "MayTA":may_ta,
                                "JuneTA":june_ta,
                                "JulyTA":july_ta,
                                "AugustTA":august_ta,
                                "SeptemberTA":september_ta,
                                "OctoberTA":october_ta,
                                "NovemberTA":november_ta,
                                "DecemberTA":december_ta,
                            }));
                            formattedData.push(...newData); 
                        }
                    );
                }
            }
        )
        
        const headerData = [
            ["Company Name: Lifestrong Marketing Inc."],
            ["Target Sell Out per Account"],
            ["Date Printed: " + formatDate(new Date())],
            [""],
        ];
    
        exportArrayToCSV(formattedData, `Target Sell Out per Account - ${formatDate(new Date())}`, headerData);
    }
</script>