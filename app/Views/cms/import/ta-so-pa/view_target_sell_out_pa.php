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
            echo view("cms/layout/buttons",$buttons);
            $optionSet = '';
            foreach($pageOption as $pageOptionLoop) {
                $optionSet .= "<option value='".$pageOptionLoop."'>".$pageOptionLoop."</option>";
            }
        ?>
        <div class="text-center page-title md-center">
            <b id="sell_out_title"></b>
        </div>
        <div class="card-body text-center">
            <div class="d-flex flex-column text-left" style="margin-top: 20px;">
                <div class="d-flex flex-row">
                    <label for="year" class="form-label p-2 col-2">Year</label>
                    <input type="text" class="form-control p-2 col-3" id="year" readonly disabled>
                    <div hidden class="p-2 col-1"></div>
                    <label hidden for="s2" class="form-label p-2 col-3">Stuff 2</label>
                    <input hidden type="text" class="form-control p-2 col-3" id="s2" readonly disabled>
                </div>
            </div>
            <div class="box">
                <table class="table table-bordered listdata">
                    <thead>
                        <tr>
                            <th class='center-content'>ID</th>
                            <th class='center-content'>Payment Group</th>
                            <th class='center-content'>Total Amount</th>
                            <th class='center-content'>Total Quantity</th>
                            <th class='center-content'>Date Created</th>
                            <th class='center-content'>Date Modified</th>
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
                    <?= $optionSet; ?>
                </select>
                <label>Entries</label>
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
                    <div class="d-flex flex-column text-left" style="font-size: 14px;">
                        <div class="d-flex flex-row">
                            <div hidden>
                                <input type="text" class="form-control" id="id" aria-describedby="id">
                            </div>
                            <label for="store" class="form-label p-2 col-2">Payment Group</label>
                            <input type="text" class="form-control required col" id="payment_group" aria-describedby="payment_group">
                        </div>
                        <div class="d-flex flex-row">
                            <label for="code" class="form-label p-2 col-2">Vendor</label>
                            <input type="text" class="form-control required col" id="vendor" aria-describedby="vendor">
                            <label for="code" class="form-label p-2 col-2">Overall</label>
                            <input type="text" class="form-control required col" id="overall" aria-describedby="overall">
                        </div>
                        <div class="d-flex flex-row">
                            <label for="code" class="form-label p-2 col-2">KAM/KAS/KAA</label>
                            <input type="text" class="form-control required col" id="kam_kas_kaa" aria-describedby="kam_kas_kaa">
                            <label for="code" class="form-label p-2 col-2">Sales Group</label>
                            <input type="text" class="form-control required col" id="sales_group" aria-describedby="sales_group">
                        </div>

                        <div class="d-flex flex-row">
                            <label for="code" class="form-label p-2 col-2">Terms</label>
                            <input type="text" class="form-control required col" id="terms" aria-describedby="terms">
                            <label for="code" class="form-label p-2 col-2">Channel</label>
                            <input type="text" class="form-control required col" id="channel" aria-describedby="channel">
                        </div>

                        <div class="d-flex flex-row">
                            <label for="code" class="form-label p-2 col-2">Brand</label>
                            <input type="text" class="form-control required col" id="brand" aria-describedby="brand">
                            <label for="code" class="form-label p-2 col-2">Exclusivity</label>
                            <input type="text" class="form-control required col" id="exclusivity" aria-describedby="exclusivity">
                        </div>

                        <div class="d-flex flex-row">
                            <label for="code" class="form-label p-2 col-2">Category</label>
                            <input type="text" class="form-control required col" id="category" aria-describedby="category">
                            <label for="code" class="form-label p-2 col-2">LMI Code</label>
                            <input type="text" class="form-control required col" id="lmi_code" aria-describedby="lmi_code">
                        </div>

                        <div class="d-flex flex-row">
                            <label for="code" class="form-label p-2 col-2">RGDI Code</label>
                            <input type="text" class="form-control required col" id="rgdi_code" aria-describedby="rgdi_code">
                            <label for="code" class="form-label p-2 col-2">Customer SKU Code</label>
                            <input type="text" class="form-control required col" id="customer_sku_code" aria-describedby="customer_sku_code">
                        </div>

                        <div class="d-flex flex-row">
                            <label for="code" class="form-label p-2 col-2">Item Description</label>
                            <input type="text" class="form-control required col" id="item_description" aria-describedby="item_description">
                            <label for="code" class="form-label p-2 col-2">Item Status</label>
                            <input type="text" class="form-control required col" id="item_status" aria-describedby="item_status">
                        </div>

                        <div class="d-flex flex-row">
                            <label for="code" class="form-label p-2 col-2">SRP</label>
                            <input type="text" class="form-control required col" id="srp" aria-describedby="srp">
                            <label for="code" class="form-label p-2 col-2">Trade Discount</label>
                            <input type="text" class="form-control required col" id="trade_discount" aria-describedby="trade_discount">
                        </div>

                        <div class="d-flex flex-row">
                            <label for="code" class="form-label p-2 col-2">Customer Cost</label>
                            <input type="text" class="form-control required col" id="customer_cost" aria-describedby="customer_cost">
                            <label for="code" class="form-label p-2 col-2 align-items-center">Customer Cost <br> Net of Vat</label>
                            <input type="text" class="form-control required col" id="customer_cost_net_of_vat" aria-describedby="customer_cost_net_of_vat">
                        </div>

                        <div class="mb-3 text-center">
                            <label for="code" class="form-label">Total Quantity</label>
                        </div>

                        <div class="d-flex flex-row" style="margin-left:20px; margin-right: 20px;">
                            <label for="code" class="form-label p-2 col-2">January</label>
                            <input type="text" class="form-control required p-2 col-2" id="jan_tq" aria-describedby="jan_tq">
                            <label for="code" class="form-label p-2 col-2">February</label>
                            <input type="text" class="form-control required p-2 col-2" id="feb_tq" aria-describedby="feb_tq">
                            <label for="code" class="form-label p-2 col-2">March</label>
                            <input type="text" class="form-control required p-2 col-2" id="mar_tq" aria-describedby="mar_tq">
                        </div>
                        <div class="d-flex flex-row" style="margin-left:20px; margin-right: 20px;">
                            <label for="code" class="form-label p-2 col-2">April</label>
                            <input type="text" class="form-control required p-2 col-2" id="apr_tq" aria-describedby="apr_tq">
                            <label for="code" class="form-label p-2 col-2">May</label>
                            <input type="text" class="form-control required p-2 col-2" id="may_tq" aria-describedby="may_tq">
                            <label for="code" class="form-label p-2 col-2">June</label>
                            <input type="text" class="form-control required p-2 col-2" id="jun_tq" aria-describedby="jun_tq">
                        </div>
                        <div class="d-flex flex-row" style="margin-left:20px; margin-right: 20px;">
                            <label for="code" class="form-label p-2 col-2">July</label>
                            <input type="text" class="form-control required p-2 col-2" id="jul_tq" aria-describedby="jul_tq">
                            <label for="code" class="form-label p-2 col-2">August</label>
                            <input type="text" class="form-control required p-2 col-2" id="aug_tq" aria-describedby="aug_tq">
                            <label for="code" class="form-label p-2 col-2">September</label>
                            <input type="text" class="form-control required p-2 col-2" id="sep_tq" aria-describedby="sep_tq">
                        </div>
                        <div class="d-flex flex-row" style="margin-left:20px; margin-right: 20px;">
                            <label for="code" class="form-label p-2 col-2">October</label>
                            <input type="text" class="form-control required p-2 col-2" id="oct_tq" aria-describedby="oct_tq">
                            <label for="code" class="form-label p-2 col-2">November</label>
                            <input type="text" class="form-control required p-2 col-2" id="nov_tq" aria-describedby="nov_tq">
                            <label for="code" class="form-label p-2 col-2">December</label>
                            <input type="text" class="form-control required p-2 col-2" id="dec_tq" aria-describedby="dec_tq">
                        </div>

                        <div class="mb-3 mt-3 text-center">
                            <label for="code" class="form-label">Total Amount</label>
                        </div>

                        <div class="d-flex flex-row" style="margin-left:20px; margin-right: 20px;">
                            <label for="code" class="form-label p-2 col-2">January</label>
                            <input type="text" class="form-control required p-2 col-2" id="jan_ta" aria-describedby="jan_ta">
                            <label for="code" class="form-label p-2 col-2">February</label>
                            <input type="text" class="form-control required p-2 col-2" id="feb_ta" aria-describedby="feb_ta">
                            <label for="code" class="form-label p-2 col-2">March</label>
                            <input type="text" class="form-control required p-2 col-2" id="mar_ta" aria-describedby="mar_ta">
                        </div>
                        <div class="d-flex flex-row" style="margin-left:20px; margin-right: 20px;">
                            <label for="code" class="form-label p-2 col-2">April</label>
                            <input type="text" class="form-control required p-2 col-2" id="apr_ta" aria-describedby="apr_ta">
                            <label for="code" class="form-label p-2 col-2">May</label>
                            <input type="text" class="form-control required p-2 col-2" id="may_ta" aria-describedby="may_ta">
                            <label for="code" class="form-label p-2 col-2">June</label>
                            <input type="text" class="form-control required p-2 col-2" id="jun_ta" aria-describedby="jun_ta">
                        </div>
                        <div class="d-flex flex-row" style="margin-left:20px; margin-right: 20px;">
                            <label for="code" class="form-label p-2 col-2">July</label>
                            <input type="text" class="form-control required p-2 col-2" id="jul_ta" aria-describedby="jul_ta">
                            <label for="code" class="form-label p-2 col-2">August</label>
                            <input type="text" class="form-control required p-2 col-2" id="aug_ta" aria-describedby="aug_ta">
                            <label for="code" class="form-label p-2 col-2">September</label>
                            <input type="text" class="form-control required p-2 col-2" id="sep_ta" aria-describedby="sep_ta">
                        </div>
                        <div class="d-flex flex-row" style="margin-left:20px; margin-right: 20px;">
                            <label for="code" class="form-label p-2 col-2">October</label>
                            <input type="text" class="form-control required p-2 col-2" id="oct_ta" aria-describedby="oct_ta">
                            <label for="code" class="form-label p-2 col-2">November</label>
                            <input type="text" class="form-control required p-2 col-2" id="nov_ta" aria-describedby="nov_ta">
                            <label for="code" class="form-label p-2 col-2">December</label>
                            <input type="text" class="form-control required p-2 col-2" id="dec_ta" aria-describedby="dec_ta">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<script>
    var params = "<?=$uri->getSegment(4);?>";
    var query = `a.status >= 0 and y.year = ${params}`;
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url("cms/global_controller");?>";

    $(document).ready(function() {
        $("#sell_out_title").html(addNbsp("VIEW TARGET SELL OUT PER ACCOUNT"));
        $("#year").val(params)

        get_data(query);
        get_pagination(query);
    })

    function get_data(new_query) {
        var data = {
            event : "list",
            select : `a.id, a.payment_group, a.vendor, a.overall, a.kam_kas_kaa, a.sales_group, a.terms, a.channel, a.brand, 
            a.exclusivity, a.category, a.lmi_code, a.rgdi_code, a.customer_sku_code, a.item_description, a.item_status, a.srp, 
            a.trade_discount, a.customer_cost, a.customer_cost_net_of_vat,
            a.january_tq, a.february_tq, a.march_tq, a.april_tq, a.may_tq, a.june_tq, 
            a.july_tq, a.august_tq, a.september_tq, a.october_tq, a.november_tq, a.december_tq,
            a.status, a.january_ta, a.february_ta, a.march_ta, a.april_ta, a.may_ta, a.june_ta, 
            a.july_ta, a.august_ta, a.september_ta, a.october_ta, a.november_ta, a.december_ta, a.updated_date, 
            (a.january_ta + a.february_ta + a.march_ta + a.april_ta + a.may_ta + a.june_ta + 
            a.july_ta + a.august_ta + a.september_ta + a.october_ta + a.november_ta + a.december_ta) AS total_amount, 
            (a.january_tq + a.february_tq + a.march_tq + a.april_tq + a.may_tq + a.june_tq + 
            a.july_tq + a.august_tq + a.september_tq + a.october_tq + a.november_tq + a.december_tq) as total_qty,
            a.created_date`.replace(/\s+/g, ' '),
            query : new_query,
            offset : offset,
            limit : limit,
            table : "tbl_accounts_target_sellout_pa a",
            join : [
                {
                    table: "tbl_year y",
                    query: "y.id = a.year",
                    type: "left"
                }
            ],
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
                        var totalAmount = parseFloat(y.total_amount);
                        var formattedNumber = totalAmount.toLocaleString(undefined, {
                          minimumFractionDigits: 2,
                          maximumFractionDigits: 2
                        });
                        var formattedNumberTQ = Math.round(y.total_qty).toLocaleString();
                        html += "<tr class='" + rowClass + "'>";

                        html += "<td scope=\"col\">" + (y.id) + "</td>";
                        html += "<td scope=\"col\">" + (y.payment_group || 'N/A') + "</td>";
                        html += "<td scope=\"col\">" + formattedNumber + "</td>";
                        html += "<td scope=\"col\">" + formattedNumberTQ + "</td>";
                        html += "<td scope=\"col\">" + (y.created_date ? ViewDateformat(y.created_date) : "N/A") + "</td>";
                        html += "<td scope=\"col\">" + (y.updated_date ? ViewDateformat(y.updated_date) : "N/A") + "</td>";

                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                            html+="<td class='center-content'>";
                            html+="<a class='btn-sm btn view' onclick=\"view_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Show Details'><span class='glyphicon glyphicon-pencil'>View</span>";
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

    function create_button(btn_txt, btn_id, btn_class, onclick_event) {
        var new_btn = $('<button>', {
            text: btn_txt,
            id: btn_id,
            class: btn_class,
            click: onclick_event
        });
        return new_btn;
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

    function save_to_db(inp_payment_group, inp_vendor, inp_overall, inp_kam_kas_kaa, inp_sales_group, inp_terms, inp_channel, inp_brand, inp_exclusivity, inp_category, 
    inp_lmi_code, inp_rgdi_code, inp_sku_code, inp_item_description, inp_item_status, inp_srp, inp_trade_discount,
    inp_customer_cost, inp_customer_cost_nov, inp_jantq, inp_febtq, inp_martq, 
    inp_aprtq, inp_maytq, inp_juntq, inp_jultq, inp_augtq, inp_septq, inp_octtq,
    inp_novtq, inp_dectq, inp_janta, inp_febta, inp_marta, inp_aprta,
    inp_julta, inp_augta, inp_septa, inp_octta, inp_novta, inp_decta, id)
    {
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
        }
        else {
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

    function toCurrencyFormat(value) {
        return value ? Number(value).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : '0.00';
    }

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
                    $('#srp').val(toCurrencyFormat(d.srp));
                    $('#trade_discount').val(toCurrencyFormat(d.trade_discount));
                    $('#customer_cost').val(toCurrencyFormat(d.customer_cost));
                    $('#customer_cost_net_of_vat').val(d.customer_cost_net_of_vat);
                    $('#jan_tq').val(toCurrencyFormat(d.january_tq));
                    $('#feb_tq').val(toCurrencyFormat(d.february_tq));
                    $('#mar_tq').val(toCurrencyFormat(d.march_tq));
                    $('#apr_tq').val(toCurrencyFormat(d.april_tq));
                    $('#may_tq').val(toCurrencyFormat(d.may_tq));
                    $('#jun_tq').val(toCurrencyFormat(d.june_tq));
                    $('#jul_tq').val(toCurrencyFormat(d.july_tq));
                    $('#aug_tq').val(toCurrencyFormat(d.august_tq));
                    $('#sep_tq').val(toCurrencyFormat(d.september_tq));
                    $('#oct_tq').val(toCurrencyFormat(d.october_tq));
                    $('#nov_tq').val(toCurrencyFormat(d.november_tq));
                    $('#dec_tq').val(toCurrencyFormat(d.december_tq));
                    $('#jan_ta').val(toCurrencyFormat(d.january_ta));
                    $('#feb_ta').val(toCurrencyFormat(d.february_ta));
                    $('#mar_ta').val(toCurrencyFormat(d.march_ta));
                    $('#apr_ta').val(toCurrencyFormat(d.april_ta));
                    $('#may_ta').val(toCurrencyFormat(d.may_ta));
                    $('#jun_ta').val(toCurrencyFormat(d.june_ta));
                    $('#jul_ta').val(toCurrencyFormat(d.july_ta));
                    $('#aug_ta').val(toCurrencyFormat(d.august_ta));
                    $('#sep_ta').val(toCurrencyFormat(d.september_ta));
                    $('#oct_ta').val(toCurrencyFormat(d.october_ta));
                    $('#nov_ta').val(toCurrencyFormat(d.november_ta));
                    $('#dec_ta').val(toCurrencyFormat(d.december_ta));
                }); 
            }
        });
    }

    function set_field_state(selector, isReadOnly) {
        $(selector).prop({ readonly: isReadOnly, disabled: isReadOnly });
    }

    function get_pagination(new_query) {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "pagination",
            select: `a.id, a.payment_group, a.vendor, a.overall, a.kam_kas_kaa, a.sales_group, a.terms, a.channel, a.brand, 
                a.exclusivity, a.category, a.lmi_code, a.rgdi_code, a.customer_sku_code, a.item_description, a.item_status, a.srp, 
                a.trade_discount, a.customer_cost, a.customer_cost_net_of_vat,
                a.january_tq, a.february_tq, a.march_tq, a.april_tq, a.may_tq, a.june_tq, 
                a.july_tq, a.august_tq, a.september_tq, a.october_tq, a.november_tq, a.december_tq,
                a.status, a.january_ta, a.february_ta, a.march_ta, a.april_ta, a.may_ta, a.june_ta, 
                a.july_ta, a.august_ta, a.september_ta, a.october_ta, a.november_ta, a.december_ta, a.updated_date, 
                (a.january_ta + a.february_ta + a.march_ta + a.april_ta + a.may_ta + a.june_ta + 
                a.july_ta + a.august_ta + a.september_ta + a.october_ta + a.november_ta + a.december_ta) AS total_amount, 
                (a.january_tq + a.february_tq + a.march_tq + a.april_tq + a.may_tq + a.june_tq + 
                a.july_tq + a.august_tq + a.september_tq + a.october_tq + a.november_tq + a.december_tq) as total_qty,
                a.created_date`.replace(/\s+/g, ' '),
            query: new_query,
            offset: offset,
            limit: limit,
            table : "tbl_accounts_target_sellout_pa a",
            join : [
                {
                    table: "tbl_year y",
                    query: "y.id = a.year",
                    type: "left"
                }
            ],
            order : {
                field : "payment_group",
                order : "asc" 
            }
            // group : ""
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

    $(document).on("change", ".record-entries", function(e) {
        $(".record-entries option").removeAttr("selected");
        $(".record-entries").val($(this).val());
        $(".record-entries option:selected").attr("selected","selected");
        var record_entries = $(this).prop("selected",true ).val();
        limit = parseInt(record_entries);
        offset = 1;
        modal.loading(true); 
        get_data(query);
        modal.loading(false);
    });
</script>