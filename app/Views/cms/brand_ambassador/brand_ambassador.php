<style>
  .pull-right{
    float:right;
  }
  .box-header.with-border {
      margin-top: 5px;
      display: flex;
  }
    .box-header:before,
    .box-body:before,
    .box-footer:before,
    .box-header:after,
    .box-body:after,
    .box-footer:after {
    content: " ";
    display: table;
    }
    .box-header:after,
    .box-body:after,
    .box-footer:after {
    clear: both;
    }
    .box-header {
    color: #444;
    display: block;
    padding: 10px;
    position: relative;
    }
    .box-header.with-border {
    border-bottom: 1px solid #f4f4f4;
    }
    .collapsed-box .box-header.with-border {
    border-bottom: none;
    }

    .tbl-content{
    max-height: 530px;
    overflow: auto;
    }

    div#list-data {
        padding: 0;
    }

    .search-query {
        height: 31px;
        border-radius: 7px;

    }
    #form-search .has-feedback .form-control-feedback {
        right: 0px !important;
    }

    #form-search  .form-group {
        margin-right: 0px !important;
        margin-left: 0px !important;
    }

    #form-search{
        display: inline-block;
        position: fixed;
        right:2em;
        width: 20%;
        display: inline-block;
    }
    /*.hidden{
        display: none;
    }*/

    .large-checkbox {
            width: 20px;
        height: 20px;
    }
    
    .large-label {
        font-size: 18px;
        margin-left: 10px;
    }

    .button-spacing {
    margin-right: 5px;
    }

    .btn-custom {
    width: 80px; 
    height: 40px;
    line-height: 24px; 
    text-align: center; 
    display: inline-block; 
    padding: 5px 10px; 
    }

    .even-row {
        background-color: #FFFFFF;
    }
    .even-row:hover{
        background-color: #b3e5fc;
    }

    .odd-row {
        background-color: #DEDEDE;
    }
    .odd-row:hover{
        background-color: #b3e5fc;
    }

    thead{
        background-color: #301311;
        color: white;
    }

    .edit {
        border: 1px solid #267326; 
        padding: 10px; 
        min-width: 75px; 
        max-height: 30px; 
        line-height: 0.5; 
        background-color: #339933; 
        color:white; 
        border-radius:10px; 
        margin-right:5px;
        box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5);    
    }
    .edit:hover {
        color: white !important ; 
        background-color: #15C815 !important ; 
        border: 0px solid #339933 !important ; 
    }
    .edit:focus {
        color: white !important ; 
        background-color: #15C815 !important ; 
        border: 0px solid #339933 !important ; 
    }

    .save {
        border: 1px solid #267326; 
        padding: 10px; 
        min-width: 75px; 
        max-height: 30px; 
        line-height: 0.5; 
        background-color: #339933; 
        color:white; 
        border-radius:10px; 
        margin-right:5px;
        box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5);    
    }
    .save:hover {
        color: white !important ; 
        background-color: #15C815 !important ; 
        border: 0px solid #339933 !important ; 
    }
    .save:focus {
        color: white !important ; 
        background-color: #15C815 !important ; 
        border: 0px solid #339933 !important ; 
    }

    .view {
        border: 1px solid #143996; 
        padding: 10px; 
        min-width: 75px; 
        max-height: 30px; 
        line-height: 0.5; 
        background-color: #1439a6; 
        color:white; 
        border-radius:10px; 
        margin-right:5px;
        box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5);
    }
    .view:hover {
        color: white; 
        background-color: #1439FF; 
        border: 0px solid #1439a6; 
    }

    .delete_data {
        border: 1px solid #730000;
        padding: 10px; 
        min-width: 75px; 
        max-height: 30px; 
        line-height: 0.5; 
        background-color: #990000; 
        color: white; border-radius: 10px; 
        margin-right: 2px; 
        box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5);
    }
    .delete_data:hover {
        color: white; 
        background-color: #C80000; 
        border: 0px solid #990000; 
    }

    .caution {
        border: 2px solid #FE9900; 
        padding: 10px; 
        min-width: 75px; 
        max-height: 30px; 
        line-height: 0.5; 
        background-color: #FE9900; 
        color: white; 
        border-radius:10px; 
        margin-right:5px;
        box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5);
    }
    .caution:hover {
        padding: 10px; 
        color: white; 
        background-color: #FFC14D; 
        border: 0px solid #FE9900; 
    }

    .default {
        border: 2px solid white; 
        padding: 10px; 
        min-width: 75px; 
        max-height: 30px; 
        line-height: 0.5; 
        background-color:gray; 
        color:white; 
        border-radius:10px; 
        margin-right:5px;
        box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5);
    }

    .card {
        box-shadow: 6px 6px 15px rgba(0, 0, 0, 0.5);
        border-radius: 10px;
        margin-bottom: 10px;
    }

    .card-body {
        padding-top: 0px;
    }

    .modal-title {
        font-family: 'Courier New', Courier, monospace; 
        font-size: large;
    }

</style>

    <div class="content-wrapper p-4">
        <div class="card">
            <div class="text-center" 
                style="padding: 10px; font-family: 'Courier New', Courier, monospace; font-size: large; background-color: #fdb92a; color: #333333; border: 1px solid #ffffff; border-radius: 10px">
                <b>B R A N D - A M B A S S A D O R</b>
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
                                        <th class='center-content'>Code</th>
                                        <th class='center-content'>Name</th>
                                        <th class='center-content'>Deployment Data</th>
                                        <th class='center-content'>Agency</th>
                                        <th class='center-content'>Brand</th>
                                        <th class='center-content'>Store</th>
                                        <th class='center-content'>Team</th>
                                        <th class='center-content'>Area</th>
                                        <th class='center-content'>Status</th>
                                        <th class='center-content'>Type</th>
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
                                <?= $optionSet;?>
                                </select>
                            <label>Entries</label>
                        </div>
                    </div>   
                </div>
                </div>
        </div>
    </div>


<!-- Add MODAL -->
<div class="modal fade" id="save_ba_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Use modal-lg for a larger modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Code</label>
                    <input type="text" class="form-control" id="code">
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="name">
                </div>
                <div class="form-group">
                    <label>Deployment Data</label>
                    <input type="date" class="form-control" id="deployment_data">
                </div>
                <div class="form-group">
                    <label>Agency</label>
                    <select class="form-control" id="agency">
                        <option value="">Select Agency</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Brand</label>
                    <input type="text" class="form-control" id="brand">
                </div>
                <div class="form-group">
                    <label>Store</label>
                    <input type="text" class="form-control" id="store">
                </div>
                <div class="form-group">
                    <label>Team</label>
                    <input type="text" class="form-control" id="team">
                </div>
                <div class="form-group">
                    <label>Area</label>
                    <input type="text" class="form-control" id="area">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input large-checkbox" id="status">
                    <label class="form-check-label large-label" for="status">Active</label>
                </div>
                <div class="form-group mt-3">
                    <label>Type</label>
                    <div class="d-flex gap-2"> <!-- Flexbox for horizontal alignment -->
                        <label class="mr-3"> <!-- Add margin for spacing -->
                            <input type="radio" name="type" value="1"> Outright
                        </label>
                        <label>
                            <input type="radio" name="type" value="0"> Consign
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveBtn">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Update MODAL -->
<div class="modal fade" id="update_ba_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Use modal-lg for a larger modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Code</label>
                    <input type="text" class="form-control" id="code">
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="name">
                </div>
                <div class="form-group">
                    <label>Deployment Data</label>
                    <input type="date" class="form-control" id="deployment_data">
                </div>
                <div class="form-group">
                    <label>Agency</label>
                    <input type="text" class="form-control" id="agency">
                </div>
                <div class="form-group">
                    <label>Brand</label>
                    <input type="text" class="form-control" id="brand">
                </div>
                <div class="form-group">
                    <label>Store</label>
                    <input type="text" class="form-control" id="store">
                </div>
                <div class="form-group">
                    <label>Team</label>
                    <input type="text" class="form-control" id="team">
                </div>
                <div class="form-group">
                    <label>Area</label>
                    <input type="text" class="form-control" id="area">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input large-checkbox" id="status">
                    <label class="form-check-label large-label" for="status">Active</label>
                </div>
                <div class="form-group mt-3">
                    <label>Type</label>
                    <div class="d-flex gap-2"> <!-- Flexbox for horizontal alignment -->
                        <label class="mr-3"> <!-- Add margin for spacing -->
                            <input type="radio" name="type" value="1"> Outright
                        </label>
                        <label>
                            <input type="radio" name="type" value="0"> Consign
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="updateBtn">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- View MODAL -->
<div class="modal fade" id="view_ba_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Use modal-lg for a larger modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Code</label>
                    <input type="text" class="form-control" id="code" readonly>
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="name" readonly>
                </div>
                <div class="form-group">
                    <label>Deployment Data</label>
                    <input type="date" class="form-control" id="deployment_data" readonly>
                </div>
                <div class="form-group">
                    <label>Agency</label>
                    <input type="text" class="form-control" id="agency" readonly>
                </div>
                <div class="form-group">
                    <label>Brand</label>
                    <input type="text" class="form-control" id="brand" readonly>
                </div>
                <div class="form-group">
                    <label>Store</label>
                    <input type="text" class="form-control" id="store" readonly>
                </div>
                <div class="form-group">
                    <label>Team</label>
                    <input type="text" class="form-control" id="team" readonly>
                </div>
                <div class="form-group">
                    <label>Area</label>
                    <input type="text" class="form-control" id="area" readonly>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input large-checkbox" id="status" disabled>
                    <label class="form-check-label large-label" for="status">Active</label>
                </div>
                <div class="form-group mt-3">
                    <label>Type</label>
                    <div class="d-flex gap-2"> <!-- Flexbox for horizontal alignment -->
                        <label class="mr-3"> <!-- Add margin for spacing -->
                            <input type="radio" name="type" value="1" disabled> Outright
                        </label>
                        <label>
                            <input type="radio" name="type" value="0" disabled> Consign
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    var query = "status >= 0";
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';

    $(document).ready(function() {
      get_data();
      get_pagination();
        $('#btn_add').css({
            'border': '2px solid white', 
            'background-color':'#339933',
            'color':'white',
            'border-radius':'10px',
        });
    });

    function get_data(keyword = null)
    {
      var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "list",
            select : "id, code, name, deployment_data, agency, brand, store, team, area, status, type, updated_date",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_brand_ambassador",
            order : {
                field : "updated_date",
                order : "desc" 
            }

        }

        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            var html = '';

            if(result) {
                if (result.length > 0) {
                    $.each(result, function(x,y) {
                        var status = ( parseInt(y.status) === 1 ) ? status = "Active" : status = "Inactive";
                        let date = new Date(y.deployment_data);
                        let formattedDate = date.toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                        var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";

                        html += "<tr class='" + rowClass + "'>";
                        html += "<td class='center-content'><input class='select' type=checkbox data-id="+y.id+" onchange=checkbox_check()></td>";
                        html += "<td>" + y.code + "</td>";
                        html += "<td>" + y.name + "</td>";
                        html += "<td>" + formattedDate + "</td>";
                        html += "<td>" + y.agency + "</td>";
                        html += "<td>" + y.brand + "</td>";
                        html += "<td>" + y.store + "</td>";
                        html += "<td>" + y.team + "</td>";
                        html += "<td>" + y.area + "</td>";
                        html += "<td>" +status+ "</td>";
                        html += "<td>" + (y.type == 1 ? "Outright" : "Consign") + "</td>";
                        html += "<td class='center-content'>" + (y.updated_date ? y.updated_date : "N/A") + "</td>";
                        
                        html+="<td class='center-content'>";
                        html+="<a class='btn-sm btn-success btn edit btn-custom button-spacing' data-status='"+y.status+"' id='"+y.id+"' title='edit'><span class='glyphicon glyphicon-pencil'>Edit</span>";
                        html+="<a class='btn-sm btn-danger btn delete_data btn-custom button-spacing' data-status='"+y.status+"' id='"+y.id+"' title='delete'><span class='glyphicon glyphicon-pencil'>Delete</span>";
                        html+="<a class='btn-sm btn-info btn view btn-custom' data-status='"+y.status+"' id='"+y.id+"' title='view'><span class='glyphicon glyphicon-pencil'>View</span>";
                        html+="</td>";
                        
                        
                        html += "</tr>";   
                    });
                } else {
                    html = '<tr><td colspan=12 class="center-align-format">'+ no_records +'</td></tr>';
                }
            }
            $('.table_body').html(html);
        });
    }

    function get_pagination()
    {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
          event : "pagination",
            select : "id",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_brand_ambassador",
            order : {
                field : "updated_date", //field to order
                order : "desc" //asc or desc
            }

        }

        aJax.post(url,data,function(result){
            var obj = is_json(result); //check if result is valid JSON format, Format to JSON if not
            console.log(obj);
            modal.loading(false);
            pagination.generate(obj.total_page, ".list_pagination", get_data);
        });
    }

    pagination.onchange(function(){
        offset = $(this).val();
        get_data();
        $('.selectall').prop('checked', false);
        $('.btn_status').hide();
        $("#search_query").val("");
    })

    $(document).on('keypress', '#search_query', function(e) {               
        if (e.keyCode === 13) {
            var keyword = $(this).val().trim();
            offset = 1;
            query = "( code like '%" + keyword + "%' ) OR team_description like '%" + keyword + "%' AND status >= 1";
            get_data();
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
        get_data();
        modal.loading(false);
    });


    $(document).ready(function () {
        $(document).on('click', '#btn_add', function () {
            $('#save_ba_modal').modal('show');
        });
    });

    $(document).on('click', '#updateBtn', function() {
        var id = $(this).attr('data-id');
        update_data(id);
    });

    $(document).on('click', '.edit', function() {
        id = $(this).attr('id');
        get_data_by_id(id);
    });

    $(document).on('click', '.delete_data', function() {
        var id = $(this).attr('id');
        delete_data(id); 
        // console.log('hello');
    });

    $(document).on('click', '.view', function() {
        id = $(this).attr('id');
        get_data_by_id_view(id);
    });

    
    $(document).on('click', '#saveBtn', function() {
       
        save_data();
        // var status = $('#status').is(':checked') ? 1 : 0;
        // console.log($('#code').val());
        // console.log($('#name').val());
        // console.log($('#deployment_data').val());
        // console.log($('#agency').val());
        // console.log($('#brand').val());
        // console.log($('#store').val());
        // console.log($('#team').val());
        // console.log($('#area').val());
        // console.log(status);
        // console.log($('input[name="type"]:checked').val());
    });

    function save_data() {
        var status = $('#save_ba_modal #status').prop('checked') ? 1 : 0;
        modal.confirm("Are you sure you want to save this record?",function(result){
            if(result){ 
                var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
                var data = {
                    event : "insert", // list, insert, update, delete
                    table : "tbl_brand_ambassador", //table
                    data : {
                            code : $('#save_ba_modal #code').val(),
                            name : $('#save_ba_modal #name').val(),
                            deployment_data : $('#save_ba_modal #deployment_data').val(),
                            agency : $('#save_ba_modal #agency').val(),
                            brand : $('#save_ba_modal #brand').val(),
                            store  : $('#save_ba_modal #store').val(),
                            team : $('#save_ba_modal #team').val(),
                            area : $('#save_ba_modal #area').val(),
                            status : $('#save_ba_modal #status').val(),
                            type : $('#save_ba_modal #type').val(),
                            created_date : formatDate(new Date()),
                            //update_date : formatDate(new Date()).format('YYYY-MM-DD HH:mm:ss'),
                            //to follow created data and created by
                            created_by : user_id,
                            status : status
                    }  
                }

                aJax.post(url,data,function(result){
                    var obj = is_json(result);
                    // alert("pasok");
                    location.reload();
                    // modal.alert("<strong>Success!</strong> Record has been Saved",function(){ 
                    //    location.reload();
                    // })
                });
            }

        });
    }

    function get_data_by_id(id){
        var query = "id = " + id;
        var exists = 0;

        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, code, name, deployment_data, agency, brand, store, team, area, status, type, updated_date",
            query : query, 
            table : "tbl_brand_ambassador"
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result);
            console.log(obj);
            if(obj){
                $.each(obj, function(x,y) {
                    console.log(y);
                    $('#update_ba_modal #code').val(y.code);
                    $('#update_ba_modal #name').val(y.name);
                    $('#update_ba_modal #deployment_data').val(y.deployment_data);
                    $('#update_ba_modal #agency').val(y.agency);
                    $('#update_ba_modal #brand').val(y.brand);
                    $('#update_ba_modal #store').val(y.store);
                    $('#update_ba_modal #team').val(y.team);
                    $('#update_ba_modal #area').val(y.area);
                    
                    if(y.status == 1){
                        $('#update_ba_modal #status').prop('checked', true);
                    }else{
                        $('#update_ba_modal #status').prop('checked', false);
                    }

                    $('input[name="type"][value="' + y.type + '"]').prop('checked', true);

                }); 
            }
            
            $('#updateBtn').attr('data-id', id);
            $('#update_ba_modal').modal('show');
        });
        return exists;
    }

    function update_data(id){
        // var status = $('#update_user_modal #status').val();
        var status = $('#update_ba_modal #status').prop('checked') ? 1 : 0;
        console.log(status);
        // if(status == 'on'){
        //     status = 1;
        // }else{
        //     status = 0;
        // }
        modal.confirm("Are you sure you want to update this record?",function(result){
            console.log(result);
            if(result){ 
                var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
                var data = {
                    event : "update", // list, insert, update, delete
                    table : "tbl_brand_ambassador", //table
                    field : "id",
                    where : id, 
                    data : {
                            code : $('#update_ba_modal #code').val(),
                            name : $('#update_ba_modal #name').val(),
                            deployment_data : $('#update_ba_modal #deployment_data').val(),
                            agency : $('#update_ba_modal #agency').val(),
                            brand : $('#update_ba_modal #brand').val(),
                            store  : $('#update_ba_modal #store').val(),
                            team : $('#update_ba_modal #team').val(),
                            area : $('#update_ba_modal #area').val(),
                            status : $('#update_ba_modal #status').val(),
                            type: $('input[name="type"]:checked').val(),
                            //created_date : formatDate(new Date()),
                            updated_date : formatDate(new Date()),
                            //to follow created data and created by
                            //created_by : user_id,
                            updated_by : user_id,
                            status : status
                    }  
                }

                aJax.post(url,data,function(result){
                    var obj = is_json(result);
                    //alert("pasok");
                    location.reload();
                    // modal.alert("<strong>Success!</strong> Record has been Saved",function(){ 
                    //    location.reload();
                    // })
                });
            }

        });
    }

    function delete_data(id){
        
        modal.confirm("Are you sure you want to delete this record?",function(result){
            if(result){ 
                var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
                var data = {
                    event : "update", // list, insert, update, delete
                    table : "tbl_brand_ambassador", //table
                    field : "id",
                    where : id, 
                    data : {
                            updated_date : formatDate(new Date()),
                            updated_by : user_id,
                            status : -2
                    }  
                }

                aJax.post(url,data,function(result){
                    var obj = is_json(result);
                    // alert("pasok");
                    location.reload();
                    // modal.alert("<strong>Success!</strong> Record has been Saved",function(){ 
                    //    location.reload();
                    // })
                });
            }

        });
    }

    function get_data_by_id_view(id){
        var query = "id = " + id;
        var exists = 0;

        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, code, name, deployment_data, agency, brand, store, team, area, status, type, updated_date",
            query : query, 
            table : "tbl_brand_ambassador"
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result);
            console.log(obj);
            if(obj){
                $.each(obj, function(x,y) {
                    console.log(y);
                    $('#view_ba_modal #code').val(y.code);
                    $('#view_ba_modal #name').val(y.name);
                    $('#view_ba_modal #deployment_data').val(y.deployment_data);
                    $('#view_ba_modal #agency').val(y.agency);
                    $('#view_ba_modal #brand').val(y.brand);
                    $('#view_ba_modal #store').val(y.store);
                    $('#view_ba_modal #team').val(y.team);
                    $('#view_ba_modal #area').val(y.area);
                    
                    if(y.status == 1){
                        $('#view_ba_modal #status').prop('checked', true);
                    }else{
                        $('#view_ba_modal #status').prop('checked', false);
                    }

                    $('input[name="type"][value="' + y.type + '"]').prop('checked', true);

                }); 
            }
            
            $('#updateBtn').attr('data-id', id);
            $('#view_ba_modal').modal('show');
        });
        return exists;
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
