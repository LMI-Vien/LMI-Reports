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

    .ui-widget {
        z-index: 1051 !important;
    }

    th, td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .tbl-content {
      /* max-height: 500px; */
    }

    .box-header{
        margin-bottom: 20px !important;
    }

    .form-container {
        display: flex;
        flex-direction: column;
        font-size: 14px;
        text-align: left;
    }

    .form-group {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .form-label {
        width: 40%;
        font-weight: bold;
    }

    .small-input {
        width: 50%;
        font-size: 13px;
        padding: 5px;
    }

    .clickable-link {
        color: #007bff; /* Link color */
        cursor: pointer; /* Change the cursor to a pointer */
    }

    .clickable-link:hover {
        color: #0056b3; /* Darker shade when hovering */
        text-decoration: none; /* Optional: remove underline on hover */
    }

</style>

    <div class="content-wrapper p-4">
        <div class="card">
            <div class="text-center page-title md-center">
                <b>B A - S A L E S - R E P O R T</b>
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
                                        <!-- <th class='center-content'><input class="selectall" type="checkbox"></th> -->
                                        <th class='center-content'>BA Name</th>
                                        <th class='center-content'>Area</th>
                                        <th class='center-content'>Store</th>
                                        <th class='center-content'>Brand</th>
                                        <th class='center-content'>Date</th>
                                        <th class='center-content'>Amount</th>
                                        <th class='center-content'>Status</th>
                                        <th class='center-content'>Date Created</th>
                                        <th class='center-content'>Date Modified</th>
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

    <div class="modal" tabindex="-1" id="popup_modal" data-backdrop="static" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-m">
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
                        <div class="form-container">
                            <div hidden>
                                <input type="text" class="form-control small-input" id="id" aria-describedby="id">
                            </div>

                            <div class="form-group d-flex">
                                <label for="ba_name" class="form-label">Brand Ambassador Name</label>
                                <input type="text" class="form-control required small-input" id="ba_name" aria-describedby="ba_name">
                            </div>

                            <div class="form-group d-flex">
                                <label for="ba_total_amount" class="form-label">Total Amount for the day</label>
                                <input type="text" class="form-control required small-input" id="ba_total_amount" aria-describedby="ba_total_amount">
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>


<script>
    
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url('cms/global_controller');?>";
    var base_url = '<?= base_url();?>';
    var ba_sales_report_date = "<?=$uri->getSegment(4);?>";
    var query = "basr.status >= 0 and basr.date = '"+ba_sales_report_date+"'";
    console.log(query);

    $(document).ready(function() {
        get_data(query);
        get_pagination(query);
    });

    function get_data(new_query) {
        var data = {
            event : "list",
            select : "basr.id, basr.ba_id as custom_name, ar.description as area, s.description as store_name, b.brand_description as brand, ba.name as ba_name, basr.date, basr.amount, basr.status, basr.created_date, basr.updated_date, basr.status",
            query : new_query,
            offset : offset,
            limit : limit,
            table : "tbl_ba_sales_report basr",
            join : [
                {
                    table: "tbl_brand b",
                    query: "b.id = basr.brand",
                    type: "left"
                },
                {
                    table: "tbl_store s",
                    query: "s.id = basr.store_id",
                    type: "left"
                },
                {
                    table: "tbl_brand_ambassador ba",
                    query: "ba.id = basr.ba_id",
                    type: "left"
                },
                {
                    table: "tbl_area ar",
                    query: "ar.id = basr.area_id",
                    type: "left"
                }
            ], 
            order : {
                field : "basr.id",
                order : "asc" 
            }

        }

        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            var html = '';

            console.log(result);

            if(result) {
                if (result.length > 0) {
                    $.each(result, function(x,y) {
                        var status = ( parseInt(y.status) === 1 ) ? status = "Active" : status = "Inactive";
                        var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";
                        var status = ( parseInt(y.status) === 1 ) ? status = "Active" : status = "Inactive";
                        y.amount = parseFloat(y.amount) || 0;

                        var areaDescription = y.area || 'N/A';
                        var storeDescription = y.store_name || 'N/A';
                        var brandDescription = y.brand || 'NA';
                        var brandAmbassadorName = 'N/A';
                        if (y.ba_name) {
                            brandAmbassadorName = y.ba_name;
                        } else if (y.custom_name == '-5') {
                            brandAmbassadorName = 'Vacant';
                        } else if (y.custom_name == '-6') {
                            brandAmbassadorName = 'Non Ba';
                        }
                        html += "<tr class='" + rowClass + "'>";
                        // html += "<td class='center-content' style='width: 5%'><input class='select' type=checkbox data-id="+y.id+" onchange=checkbox_check()></td>";
                        // html += "<td scope=\"col\">" + trimText(brandAmbassadorName) + "</td>"
                        html += "<td scope=\"col\"><a href='#' class='clickable-link' onclick='handleBrandAmbassadorClick(\"" + y.id + "\", \"" + y.date + "\", \"" + brandAmbassadorName + "\")'>" + trimText(brandAmbassadorName) + "</a></td>";
                        html += "<td scope=\"col\">" + trimText(areaDescription) + "</td>"
                        html += "<td scope=\"col\">" + trimText(storeDescription) + "</td>"
                        html += "<td scope=\"col\">" + trimText(brandDescription) + "</td>"
                        html += "<td scope=\"col\">" + ViewDateOnly(y.date) + "</td>";
                        html += "<td scope=\"col\">" + (y.amount.toLocaleString()) + "</td>";
                        html += "<td scope=\"col\">" + status + "</td>";
                        html += "<td scope=\"col\">" + (y.created_date ? ViewDateformat(y.created_date) : "N/A") + "</td>";
                        html += "<td scope=\"col\">" + (y.updated_date ? ViewDateformat(y.updated_date) : "N/A") + "</td>";

                        // if (y.id == 0) {
                        //     html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        // } else {
                        //     html+="<td class='center-content' style='width: 25%; min-width: 300px'>";
                        //     html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Delete Item'><span class='glyphicon glyphicon-pencil'>Delete</span>";
                        //     html+="<a class='btn-sm btn view' onclick=\"view_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Show Details'><span class='glyphicon glyphicon-pencil'>View</span>";
                        //     html+="</td>";
                        // }
                        
                        html += "</tr>";   
                    });
                } else {
                    html = '<tr><td colspan=12 class="center-align-format">'+ no_records +'</td></tr>';
                }
            }
            $('.table_body').html(html);
        });
    }

    function updateModalTitle(message) {
        $('.modal-title').html('<b>' + message + '</b>'); 
    }

    function handleBrandAmbassadorClick(id, date) {
        $('#popup_modal').modal('show');
        open_modal(id, date);

        updateModalTitle("Total Amount");
        
        console.log(id, date);
    }

    // function open_modal(id) {
    //     let data = {
    //         event: "list",
    //         select: "basr.id, basr.date, ba.name AS ba_name, ar.description AS area, s.description AS store_name, b.brand_description AS brand, SUM(basr.amount) AS total_amount, basr.status",
    //         query: "basr.id = '" + id + "'",
    //         offset: offset,
    //         limit: 0,
    //         table: "tbl_ba_sales_report AS basr",
    //         join : [
    //             {
    //                 table: "tbl_brand b",
    //                 query: "b.id = basr.brand",
    //                 type: "left"
    //             },
    //             {
    //                 table: "tbl_store s",
    //                 query: "s.id = basr.store_id",
    //                 type: "left"
    //             },
    //             {
    //                 table: "tbl_brand_ambassador ba",
    //                 query: "ba.id = basr.ba_id",
    //                 type: "left"
    //             },
    //             {
    //                 table: "tbl_area ar",
    //                 query: "ar.id = basr.area_id",
    //                 type: "left"
    //             }
    //         ],
    //         order : {
    //             field : "basr.id",
    //             order : "asc" 
    //         },
    //         // group: "basr.date"
    //     }

    //     aJax.post(url,data,function(result){
    //         // console.log("result mo to: ",result)
    //         var obj = is_json(result);
    //         if(obj){
    //             $.each(obj, function(index,y) {
    //                 $('#id').val(y.id);
    //                 // console.log(y.id);
    //                 $('#ba_name').val(y.ba_name);
    //                 $('#ba_total_amount').val(y.total_amount);
    //             }); 
    //         }
    //     });
    // }

    function open_modal(id, date) {
        let data = {
            event: "list",
            select: "ba.name AS ba_name, basr.date, SUM(basr.amount) AS total_amount",
            query: "basr.ba_id = (SELECT ba_id FROM tbl_ba_sales_report WHERE id = '" + id + "') AND basr.date = '" + date + "'",
            offset: 0,
            limit: 0,
            table: "tbl_ba_sales_report AS basr",
            join: [
                {
                    table: "tbl_brand_ambassador ba",
                    query: "ba.id = basr.ba_id",
                    type: "left"
                }
            ],
            group: "ba.name, basr.date",  
            order: { 
                field: "basr.date", 
                order: "asc" 
            }
        };

        aJax.post(url, data, function(result) {
            console.log("AJAX Response:", result);
            var obj = is_json(result);
            if (obj && obj.length > 0) {
                let totalAmount = 0; 
                let baName = obj[0].ba_name; 

                $.each(obj, function(index, y) {
                    totalAmount += parseFloat(y.total_amount); 
                });

                $('#ba_name').val(baName);
                $('#ba_total_amount').val(totalAmount.toFixed(2));
            }
        });

        set_field_state('#ba_name, #ba_total_amount', true);
    }

    function set_field_state(selector, isReadOnly) {
        $(selector).prop({ readonly: isReadOnly, disabled: isReadOnly });
    }

    // function get_pagination() {
    //     var url = "<?= base_url("cms/global_controller");?>";
    //     var data = {
    //       event : "pagination",
    //         select : "basr.id, basr.status",
    //         query : query,
    //         offset : offset,
    //         limit : limit,
    //         table : "tbl_ba_sales_report as basr"
    //     }

    //     aJax.post(url,data,function(result){
    //         var obj = is_json(result); //check if result is valid JSON format, Format to JSON if not
    //         modal.loading(false);
    //         pagination.generate(obj.total_page, ".list_pagination", get_data);
    //     });
    // }

    // pagination.onchange(function(){
    //     offset = $(this).val();
    //     get_data(query);
    //     $('.selectall').prop('checked', false);
    //     $('.btn_status').hide();
    //     $("#search_query").val("");
    // });

    // $(document).on('keypress', '#search_query', function(e) {               
    //     if (e.keyCode === 13) {
    //         var keyword = $(this).val().trim();
    //         offset = 1;
    //         var new_query = "(" + query + " AND ar.description LIKE '%" + keyword + "%') OR " +
    //             "(" + query + " AND s.description LIKE '%" + keyword + "%') OR " +
    //             "(" + query + " AND b.brand_description LIKE '%" + keyword + "%') OR " +
    //             "(" + query + " AND ba.name LIKE '%" + keyword + "%') OR " +
    //             "(" + query + " AND basr.date LIKE '%" + keyword + "%')"; 
                
    //         get_data(new_query);
    //         get_pagination();
    //     }
    // });

    // $(document).on("change", ".record-entries", function(e) {
    //     $(".record-entries option").removeAttr("selected");
    //     $(".record-entries").val($(this).val());
    //     $(".record-entries option:selected").attr("selected","selected");
    //     var record_entries = $(this).prop( "selected",true ).val();
    //     limit = parseInt(record_entries);
    //     offset = 1;
    //     modal.loading(true); 
    //     get_data(query);
    //     get_pagination(query);
    //     modal.loading(false);
    // });

    function ViewDateOnly(dateString) {
        let date = new Date(dateString);
        return date.toLocaleString('en-US', { 
            month: 'short', 
            day: 'numeric', 
            year: 'numeric'
        });
    }

    function get_pagination(new_query) {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "pagination",
            select: "basr.id, ar.description as area, s.description as store_name, b.brand_description as brand, ba.name as ba_name, basr.date, basr.amount, basr.status, basr.created_date, basr.updated_date, basr.status",
            query: new_query,
            offset: offset,
            limit: limit,
            table : "tbl_ba_sales_report basr",
            join : [
                {
                    table: "tbl_brand b",
                    query: "b.id = basr.brand",
                    type: "left"
                },
                {
                    table: "tbl_store s",
                    query: "s.id = basr.store_id",
                    type: "left"
                },
                {
                    table: "tbl_brand_ambassador ba",
                    query: "ba.id = basr.ba_id",
                    type: "left"
                },
                {
                    table: "tbl_area ar",
                    query: "ar.id = basr.area_id",
                    type: "left"
                }
            ], 
            order : {
                field : "basr.id",
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