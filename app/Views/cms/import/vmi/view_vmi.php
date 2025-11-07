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
                    <label for="week" class="form-label p-2 col-2">Week</label>
                    <input type="text" class="form-control p-2 col-3" id="week" readonly disabled>
                    <div class="p-2 col-1"></div>
                    <label for="week" class="form-label p-2 col-3"></label>
                </div>
            </div>
            <div class="box">
                <table class="table table-bordered listdata">
                    <thead>
                        <tr>
                            <th class='center-content'>Store Code</th>
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
    var params = "<?=$uri->getSegment(4);?>";
    paramlist = params.split('-')
    var query = `v.status >= 0 and y.year = '${paramlist[1]}' and c.name = '${paramlist[0]}' and v.week = '${decodeURIComponent(paramlist[2])}'`;
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url('cms/global_controller');?>";

    $(document).ready(function() {
        $("#sell_out_title").html(addNbsp("VIEW VMI DATA"));
        $("#company").val(paramlist[0]);
        $("#year").val(paramlist[1]);
        $("#week").val(decodeURIComponent(paramlist[2]));

        modal.loading(true); 
        get_data(query);
    })

    function get_data(new_query) {
        var data = {
            event: "list_pagination",
            select: "v.id, s.code AS store, s.description AS store_name, a.code AS area_code, v.item, v.item_name, "+
            "v.status, v.item_class, v.supplier, v.c_group, v.dept, v.c_class, v.sub_class, v.on_hand, v.in_transit, "+
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
                    table: "tbl_area a",
                    query: "a.id = v.area_id",
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
                    table: "tbl_week w",
                    query: "w.id = v.week",
                    type: "left"
                }
            ],
            order: {
                field: "v.store",
                order: "asc"
            },
            group : ""
        };


        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            var html = '';
            var list = result.list;
            if(list) {
                if (list.length > 0) {
                    $.each(list, function(x,y) {
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
                        html += "<td scope=\"col\">" + (y.c_group) + "</td>";
                        html += "<td scope=\"col\">" + (y.dept) + "</td>";
                        html += "<td scope=\"col\">" + (y.c_class) + "</td>";
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
            modal.loading(false);
            if(result.pagination){
              if(result.pagination.total_page > 1){
                  pagination.generate(result.pagination.total_page, ".list_pagination", get_data);
                    currentPage = offset;
                    $(".pager_number option[value="+currentPage+"]").prop("selected", false)
                    $('.pager_number').val(currentPage);
                    $('.pager_no').html("Page " + numeral(currentPage).format('0,0'));
              }
              else if(result.total_data < limit) {
              $('.list_pagination').empty();
              } 
            }
        });
    }

    // function get_pagination(new_query) {
    //     var url = "<?= base_url("cms/global_controller");?>";
    //     var data = {
    //       event : "pagination",
    //       select: "v.id, s.code AS store, a.code AS area_code, v.item, v.item_name, "+
    //         "v.status, v.item_class, v.supplier, v.c_group, v.dept, v.c_class, v.sub_class, v.on_hand, v.in_transit, "+
    //         "(v.on_hand + v.in_transit) AS total_qty, v.average_sales_unit, v.vmi_status, v.created_date, v.updated_date, "+
    //         "c.name AS company",
    //       query: new_query,
    //       offset: offset,
    //       limit: limit,
    //       table: "tbl_vmi v",
    //       join: [
    //             {
    //                 table: "tbl_store s",
    //                 query: "s.id = v.store",
    //                 type: "left"
    //             },
    //             {
    //                 table: "tbl_area a",
    //                 query: "a.id = v.area_id",
    //                 type: "left"
    //             },
    //             {
    //                 table: "tbl_company c",
    //                 query: "c.id = v.company",
    //                 type: "left"
    //             },
    //             {
    //                 table: "tbl_year y",
    //                 query: "y.id = v.year",
    //                 type: "left"
    //             },
    //             {
    //                 table: "tbl_week w",
    //                 query: "w.id = v.week",
    //                 type: "left"
    //             }
    //       ],
    //       order: {
    //           field: "v.year",
    //           order: "asc"
    //       },
    //       group : ""
    //     }

    //     aJax.post(url,data,function(result){
    //         var obj = is_json(result); 
    //         modal.loading(false);
    //         pagination.generate(obj.total_page, ".list_pagination", get_data);
    //     });
    // }

    pagination.onchange(function(){
        offset = $(this).val();
        modal.loading(true);
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
    });
    
</script>