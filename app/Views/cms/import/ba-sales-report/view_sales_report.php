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

    .box-header{
        margin-bottom: 20px !important;
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
                                        <th class='center-content'><input class="selectall" type="checkbox"></th>
                                        <th class='center-content'>BA Name</th>
                                        <th class='center-content'>Area</th>
                                        <th class='center-content'>Store</th>
                                        <th class='center-content'>Brand</th>
                                        <th class='center-content'>Date</th>
                                        <th class='center-content'>Amount</th>
                                        <th class='center-content'>Status</th>
                                        <th class='center-content'>Date Created</th>
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

    <!-- MODAL -->
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
                            <label for="ba_name" class="form-label">BA Name</label>
                            <input type="text" class="form-control required" id="ba_name" aria-describedby="ba_name">
                        </div>

                        <div class="mb-3">
                            <div hidden>
                                <input type="text" class="form-control" id="id" aria-describedby="id">
                            </div>
                            <label for="area" class="form-label">Area</label>
                            <input type="text" class="form-control required" id="area" aria-describedby="area">
                        </div>

                        <div class="mb-3">
                            <label for="store_name" class="form-label">Store Name</label>
                            <input type="text" class="form-control required" id="store_name" aria-describedby="store_name">
                        </div>

                        <div class="mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <input type="text" class="form-control required" id="brand" aria-describedby="brand">
                        </div>
                        
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control required" id="date" aria-describedby="date">
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="text" class="form-control required" id="amount" aria-describedby="amount">
                        </div>
                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
    
    <!-- IMPORT MODAL -->
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
                        <div class="mb-3" style="overflow-x: auto; height: 450px; padding: 0px;">
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

                        </div>

                            <table class= "table table-bordered listdata">
                                <thead>
                                    <tr>
                                        <th class='center-content'>Line #</th>
                                        <th class='center-content'>BA Name</th>
                                        <th class='center-content'>Area</th>
                                        <th class='center-content'>Store</th>
                                        <th class='center-content'>Brand</th>
                                        <th class='center-content'>Date</th>
                                        <th class='center-content'>Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="word_break import_table"></tbody>
                            </table>
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
                        
                        <div class="d-flex flex-column">
                            <div class="p-2 row">
                                <div class="col">
                                    <label class="col" >BA Name</label>
                                    <input id='ba_input' class='form-control' onkeypress="suggest_ba()" placeholder='Select BA Name'>
                                </div>
                                <div class="col">
                                    <label class="col" >Area</label>
                                    <input id='area_input' class='form-control' onkeypress="suggest_area()" placeholder='Select Area'>
                                </div>
                            </div>
                            <div class="p-2 row">
                                <div class="col">
                                    <label class="col" >Store</label>
                                    <input id='store_input' class='form-control' onkeypress="suggest_store()" placeholder='Select Store'>
                                </div>
                                <div class="col">
                                    <label class="col" >Brand</label>
                                    <input id='brand_input' class='form-control' onkeypress="suggest_brand()" placeholder='Select Brand'>
                                </div>

                            </div>
                            <div class="p-2 row">
                                <div class="col">
                                    <label>Date From</label>
                                    <input type="date" class="form-control" id="date_from">
                                </div>
                                <div class="col">
                                    <label>Date To</label>
                                    <input type="date" class="form-control" id="date_to">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="modal-footer">
                    <button type="button" class="btn save" onclick="handleExport()">Export All/Selected</button>
                    <button type="button" class="btn save" onclick="exportFilter()">Export Filter</button>
                    <button type="button" class="btn caution" data-dismiss="modal">Close</button>
                </div>
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
        get_pagination();
    });

    function get_data(new_query) {
        var data = {
            event : "list",
            select : "basr.id, ar.description as area, s.description as store_name, b.brand_description as brand, ba.name as ba_name, basr.date, basr.amount, basr.status, basr.created_date, basr.updated_date, basr.status",
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
                        var brandAmbassadorName = y.ba_name || 'NA';

                        html += "<tr class='" + rowClass + "'>";
                        html += "<td class='center-content' style='width: 5%'><input class='select' type=checkbox data-id="+y.id+" onchange=checkbox_check()></td>";
                        html += "<td scope=\"col\">" + trimText(brandAmbassadorName) + "</td>"
                        html += "<td scope=\"col\">" + trimText(areaDescription) + "</td>"
                        html += "<td scope=\"col\">" + trimText(storeDescription) + "</td>"
                        html += "<td scope=\"col\">" + trimText(brandDescription) + "</td>"
                        html += "<td scope=\"col\">" + ViewDateOnly(y.date) + "</td>";
                        html += "<td scope=\"col\">" + (y.amount.toLocaleString()) + "</td>";
                        html += "<td scope=\"col\">" + status + "</td>";
                        html += "<td scope=\"col\">" + (y.created_date ? ViewDateformat(y.created_date) : "N/A") + "</td>";
                        html += "<td scope=\"col\">" + (y.updated_date ? ViewDateformat(y.updated_date) : "N/A") + "</td>";

                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                            html+="<td class='center-content' style='width: 25%; min-width: 300px'>";
                            html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Delete Item'><span class='glyphicon glyphicon-pencil'>Delete</span>";
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

    function get_pagination() {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
          event : "pagination",
            select : "basr.id, basr.status",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_ba_sales_report as basr"
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
            var new_query = "(" + query + " AND ar.description LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND s.description LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND b.brand_description LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND ba.name LIKE '%" + keyword + "%') OR " +
                "(" + query + " AND basr.date LIKE '%" + keyword + "%')"; 
                
            get_data(new_query);
            get_pagination();
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

    function ViewDateOnly(dateString) {
        let date = new Date(dateString);
        return date.toLocaleString('en-US', { 
            month: 'short', 
            day: 'numeric', 
            year: 'numeric'
        });
    }


</script>