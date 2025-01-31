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

  /*for menu roles*/

  th:first-child{
        width:20px;   
    }

    th:last-child{
        width: 30px;
    }

    td:last-child{
        text-align: center;
    }

    .ta_c
    {
        text-align: center;
    }

    .module_content{
        overflow: auto;
        height: auto;
    }
    .menu_header_ul {
        padding: 0;
        display: block; 
        vertical-align: middle;
        margin: 0;
        display: grid;
        grid-template-columns: 52fr repeat(3, 16fr);
    }
    .menu_header_ul li{
        display: inline-block;
        text-align: left;
    }

    .menu_header_ul li:first-child {
        text-align: left;
    }

    .menu_header_li span {
        padding-left: 10px;
    }

    .module_header_container {
    /*    position: absolute;*/
        width: 100%;
        padding: 9px 0px;
        overflow: hidden;
        background: #301311;
        color: #fff;
        font-weight: 600;
        font-size: 15px;
        z-index: 1;
    }
    .module_body_container {
    /*    padding-top: 40px;*/
        width: 100%;
        position: relative;
    }

    .module_col {
        position: relative;
        width: 100%;
        overflow: hidden;
    }
    ul.parent_menu {
        padding: 0;
        display: block;
        vertical-align: middle;
        margin: 0;
        font-size: 16px;
    }

    ul.child_menu {
        padding: 0;
        display: block;
        vertical-align: middle;
        margin: 0;
    }

    .menu_title {
        display: inline-block;
        width: 52%;
        background: rgba(44, 59, 65, 0.15);
        color: #000;
        font-weight: 500;
        font-size : 17px;
    }

    .menu_title span {
        padding-left: 10px;
    }

    .menu_chkbx {
        display: inline-block;
        width: 16%;
        background: rgba(44, 59, 65, 0.15);
        font-size: 17px;
    }

    .sub_menu_title {
        display: inline-block;
        width: 52%;
    }

    .sub_menu_title span {
        padding-left: 20px;
    }

    .sub_menu_chkbx {
        display: inline-block;
        width: 16%;
    }

    .page-title {
        padding: 10px; 
        font-family: 'Courier New', Courier, monospace; 
        font-size: large; 
        background-color: #fdb92a; 
        color: #333333; 
        border: 1px solid #ffffff; 
        border-radius: 10px
    }

    .modal-title {
        font-family: 'Courier New', Courier, monospace; 
        font-size: large;
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

    .delete {
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
    .delete:hover {
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

    thead{
        background-color: #301311;
        color: white;
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


</style>

    <!-- <div class="content-wrapper p-4">
        <div class="card">
          <div class="text-center page-title">
              <b>&nbsp;&nbsp;&nbsp;A G E N C Y&nbsp;&nbsp;&nbsp;</b>
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
                                    <th class='center-content'>Agency</th>
                                    <th class='center-content'>Date Modified</th>
                                    <th class='center-content'>Status</th>
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
    </div> -->

    <div class="content-wrapper p-4">
      <div class="card">
          <div class="text-center page-title">
              <b>&nbsp;&nbsp;&nbsp;A G E N C Y&nbsp;&nbsp;&nbsp;</b>
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
                                      <th class='center-content'>Agency</th>
                                      <th class='center-content'>Date Modified</th>
                                      <th class='center-content'>Status</th>
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

    <div class="modal" tabindex="-1" id="popup_modal">
        <div class="modal-dialog">
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
                    <form style="background-color: white !important; width: 100%;">
                        <div class="mb-3">
                            <label for="code" class="form-label">Code</label>
                            <input type="text" class="form-control" id="id" aria-describedby="id" hidden>
                            <input type="text" class="form-control required" id="code" maxlength="25" aria-describedby="code">
                            <small id="code" class="form-text text-muted">* required, must be unique, max 25 characters</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Agency</label>
                            <input type="text" class="form-control required" id="agency" maxlength="50" aria-describedby="description">
                            <small id="description" class="form-text text-muted">* required, must be unique, max 50 characters</small>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="status" checked>
                            <label class="form-check-label" for="status">Active</label>
                        </div>
                    </form>
                </div>
                
                <div class="modal-footer">
                    
                </div>
            </div>
        </div>
    </div>

    <!-- IMPORT MODAL -->
    <div class="modal" tabindex="-1" id="import_modal">
        <div class="modal-dialog modal-xl">
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

                            <label for="file" class="custom-file-upload save" style="margin-left:10px; margin-top: 10px; align-items: center;">
                                <i class="fa fa-file-import" style="margin-right: 5px;"></i>Custom Upload
                            </label>
                            <input
                                type="file"
                                style="display: none;"
                                id="file"
                                accept=".xls,.xlsx,.csv"
                                aria-describedby="import_files"
                                onchange="store_file(event)"
                                onclick="clear_import_table()"
                            >

                            <label for="preview" class="custom-file-upload save" id="preview_xl_file" style="margin-top: 10px" onclick="read_xl_file()">
                                <i class="fa fa-sync" style="margin-right: 5px;"></i>Preview Data
                            </label>

                            <table class= "table table-bordered listdata">
                                <thead>
                                    <tr>
                                        <th class='center-content' style='width: 5%'>Line #</th>
                                        <th class='center-content' style='width: 10%'>Code</th>
                                        <th class='center-content' style='width: 20%'>Agency</th>
                                        <th class='center-content' style='width: 10%'>Status</th>
                                    </tr>
                                </thead>
                                <tbody class="word_break import_table"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn caution" data-dismiss="modal">Close</button>
                    <button type="button" class="btn save" onclick="proccess_xl_file()">Validate and Save</button>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.3/xlsx.full.min.js"></script>
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
        $('#btn_import').css({
            'border': '2px solid white', 
            'background-color':'#339933',
            'color':'white',
            'border-radius':'10px',
        });
    });

    function get_data(keyword = null) {
      var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "list",
            select : "id, code, agency, status, updated_date",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_agency",
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
                        var rowClass = (x % 2 === 0) ? "even-row" : "odd-row";

                        html += "<tr class='" + rowClass + "'>";
                        html += "<td class='center-content'><input class='select' type=checkbox data-id="+y.id+" onchange=checkbox_check()></td>";
                        html += "<td style='width: 10%'>" + y.code + "</td>";
                        html += "<td style='width: 20%'>" + y.agency + "</td>";
                        html += "<td class='center-content' style='width: 20%'>" + (y.updated_date ? y.updated_date : "N/A") + "</td>";
                        html += "<td style='width: 10%'>" +status+ "</td>";

                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                          html+="<td class='center-content'>";
                          html+="<a class='btn-sm btn save' onclick=\"edit_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Edit Details'><span class='glyphicon glyphicon-pencil'>Edit</span>";
                          html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Delete Details'><span class='glyphicon glyphicon-pencil'>Delete</span>";
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
            select : "id",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_agency",
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
            query = "( code like '%" + keyword + "%' ) OR agency like '%" + keyword + "%' AND status >= 1";
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

    $('#btn_add').on('click', function() {
        open_modal('Add New Agency', 'add', '');
    });

    $('#btn_import').on('click', function() {
        $("#import_modal").modal('show')
        clear_import_table()
    });

    function edit_data(id) {
        open_modal('Edit Agency', 'edit', id);
    }

    function view_data(id) {
        open_modal('View Agency', 'view', id);
    }

    function open_modal(msg, actions, id) {
        modal_title = addNbsp(msg);
        $('#popup_modal .modal-title b').html(modal_title);
        $('#popup_modal #code').val('');
        $('#popup_modal #agency').val('');
        $('#popup_modal #status').prop('checked', true);
        // <button type="button" class="btn save" id="save_data">Save</button>
        var save_btn = create_button('Save', 'save_data', 'btn save', function () {
            if(validate.standard("popup_modal")){
                save_data();
            }
        });
        // <button type="button" class="btn save" id="edit_data">Edit</button>
        var edit_btn = create_button('Edit', 'edit_data', 'btn save', function () {
            // alert("Form edited!");
            update_data(id);
        });
        // <button type="button" class="btn caution" data-dismiss="modal">Close</button>
        var close_btn = create_button('Close', 'close_data', 'btn caution', function () {
            $('#popup_modal').modal('hide');
        });
        switch (actions) {
            case 'add':
                $('#code').attr('readonly', false);
                $('#code').attr('disabled', false);
                $('#agency').attr('readonly', false);   
                $('#agency').attr('disabled', false);
                $('#popup_modal .modal-footer').empty();
                $('#popup_modal .modal-footer').append(save_btn);
                $('#popup_modal .modal-footer').append(close_btn);
                break;
                
            case 'edit':
                populate_modal(id);
                $('#code').attr('readonly', false);
                $('#code').attr('disabled', false);
                $('#agency').attr('readonly', false);   
                $('#agency').attr('disabled', false);
                $('#status').attr('disabled', false);
                $('#status').attr('readonly', false);   
                $('#popup_modal .modal-footer').empty();
                $('#popup_modal .modal-footer').append(edit_btn);
                $('#popup_modal .modal-footer').append(close_btn);
                break;
            
            case 'view':
                populate_modal(id);
                $('#code').attr('readonly', true);
                $('#code').attr('disabled', true);
                $('#agency').attr('readonly', true);   
                $('#agency').attr('disabled', true);
                $('#status').attr('readonly', true);   
                $('#status').attr('disabled', true);
                $('#popup_modal .modal-footer').empty();
                $('#popup_modal .modal-footer').append(close_btn);
                break;
        
            default:
                populate_modal(id);
                $('#popup_modal .modal-footer').empty();
                $('#popup_modal .modal-footer').append(close_btn);
                break;
        }
        $('#popup_modal').modal('show');
    }

    function create_button(btn_txt, btn_id, btn_class, onclick_event) {
        var new_btn = $('<button>', {
            text: btn_txt,
            id: btn_id,
            class: btn_class,
            click: onclick_event // Attach the onclick event
        });
        return new_btn;
    }

    function save_data() {
        var code = $('#code').val(); 
        var agency = $('#agency').val(); 
        var status_val = $('#status').prop('checked') ? 1 : 0; 

        check_current_db(function(result) {
            var err_msg = '';
            var valid = true;
            
            var result = JSON.parse(result);

            $.each(result, function(index, item) {
                if (item.code === code) {
                    valid = false;
                    err_msg += "Code already exists in masterfile<br>";
                }
                if (item.agency === agency) {
                    valid = false;
                    err_msg += "Description already exists in masterfile<br>";
                }
            });

            if (!valid) {
                load_swal(
                    'add_alert',
                    '500px',
                    "error",
                    "Error!",
                    err_msg,
                    false,
                    false
                );
            } else {
                modal.confirm("Are you sure you want to save this record?", function(result) {
                    if (result) {
                        var dataObject = {
                            code: code,
                            agency: agency,
                            status: status_val,
                            created_date: formatDate(new Date()), 
                            created_by: user_id
                        };
                        save_to_db(dataObject); 
                    }
                });
            }
        });
    }

    function update_data(id) {
        var code = $('#code').val();
        var agency = $('#agency').val();
        var status = $('#status').prop('checked') ? 1 : 0; // Get the status as 1 or 0

        // Check if the code or description already exists in the database before updating
        check_current_db(function(result) {
            var err_msg = '';
            var valid = true;

            // Parse the result (assuming it's JSON)
            var result = JSON.parse(result);

            // Iterate through result and check for code and description
            $.each(result, function(index, item) {
                if (item.code === code && item.id !== id) { // Exclude the current record being updated
                    valid = false;
                    err_msg += "Code already exists in masterfile<br>";
                }
                if (item.agency === agency && item.id !== id) { // Exclude the current record being updated
                    valid = false;
                    err_msg += "Agency already exists in masterfile<br>";
                }
            });

            // If not valid, show error message
            if (!valid) {
                load_swal(
                    'add_alert',
                    '500px',
                    "error",
                    "Error!",
                    err_msg,
                    false,
                    false
                );
            } else {
                // If valid, confirm and update the record
                modal.confirm("Are you sure you want to update this record?", function(result) {
                    if (result) {
                        var data = {
                            event: "update", // Specify event type
                            table: "tbl_agency", // Table name
                            field: "id",
                            where: id, // Record to update
                            data: {
                                code: code,
                                agency: agency,
                                status: status,
                                updated_date: formatDate(new Date()),
                                updated_by: user_id
                            }
                        };

                        var url = "<?= base_url('cms/global_controller'); ?>"; // URL of the controller
                        aJax.post(url, data, function(result) {
                            var obj = is_json(result);
                            location.reload();
                        });
                    }
                });
            }
        });
    }

    function delete_data(id) {
        // alert('Data deleted!');
        modal.confirm("Are you sure you want to delete this record?",function(result){
            if(result){ 
                var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
                var data = {
                    event : "update", // list, insert, update, delete
                    table : "tbl_agency", //table
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

    function populate_modal(inp_id) {
        var query = "status >= 0 and id = " + inp_id;
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, code, agency, status",
            query : query, 
            table : "tbl_agency"
        }
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(index,asc) {
                    $('#id').val(asc.id);
                    $('#code').val(asc.code);
                    $('#agency').val(asc.agency);
                    if(asc.status == 1) {
                        $('#status').prop('checked', true)
                    } else {
                        $('#status').prop('checked', false)
                    }
                }); 
            }
        });
    }

    // addNbsp()™: A Truly Revolutionary Function
    // This function is the epitome of laziness and brilliance combined. 
    // Why manually type `&nbsp;` repeatedly when you can let JavaScript do the heavy lifting?
    // With `addNbsp`, you can transform every character in a string into a spaced-out masterpiece,
    // replacing regular spaces with double `&nbsp;&nbsp;` and adding `&nbsp;` after every other character. 
    // It’s elegant. It’s lazy. It’s genius.
    // Honestly, this function is not just a tool—it’s a lifestyle.
    function addNbsp(inputString) {
        return inputString.split('').map(char => {
            if (char === ' ') {
            return '&nbsp;&nbsp;';
            }
            return char + '&nbsp;';
        }).join('');
    }

    function save_to_db(dataObject) {
        var url = "<?= base_url('cms/global_controller');?>"; // URL of Controller
        var data = {
            event: "insert",
            table: "tbl_agency", // Table name
            data: dataObject  // Pass the entire object dynamically
        };

        aJax.post(url, data, function (result) {
            var obj = is_json(result);
            location.reload();
        });
    }

    function check_current_db(successCallback) {
        var url = "<?= base_url('cms/global_controller');?>"; // URL of Controller
        var data = {
            event : "list",
            select : "id, code, agency, status",
            query : query,
            offset : 0,
            limit : 0,
            table : "tbl_agency",
        }
        jQuery.ajax({
            url: url,
            type: 'post',
            data: data,
            async: false,
            success: function (res) {
                successCallback(res);
            }, error(e){
                alert('alert', e)
                console.log(e)
            }
        });
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

    function load_swal(swclass, swwidth, swicon, swtitle, swtext, swoutclick, swesckey) {
        Swal.fire({
            customClass: swclass, // no special characters allowed
            width: swwidth,
            icon: swicon, // can be "warning", "error", "success", "info"
            // https://sweetalert.js.org/docs/#icon
            title: swtitle, // string
            html: swtext, // string
            allowOutsideClick: swoutclick, // boolean 
            // true allow closing alert by clicking outside of alert
            // false prevent closing alert by clicking outside of alert
            allowEscapeKey: swesckey, // boolean
            // true allow closing alert by pressing escape key
            // false prevent closing alert by pressing escape key
        });
    }

    function store_file(event) {
        storedFile = event.target.files[0]; // Store the file but do nothing yet
        console.log("File stored:", storedFile.name);
    }

    function clear_import_table() {
        $(".import_table").empty()
    }

    function read_xl_file() {
        $(".import_table").empty()
        var html = '';
        const file = $("#file")[0].files[0];
        if (file === undefined) {
            load_swal(
                '',
                '500px',
                'error',
                'Error!',
                'Please select a file to upload',
                false,
                true
            )
            return
        }
        const reader = new FileReader();
        reader.onload = function(e) {
            const data = e.target.result;
            // convert the data to a workbook
            const workbook = XLSX.read(data, {type: "binary"});
            // get the first sheet
            const sheet = workbook.Sheets[workbook.SheetNames[0]];
            // convert the sheet to JSON
            const jsonData = XLSX.utils.sheet_to_json(sheet);

            var tr_counter = 0;
            jsonData.forEach(row => {
                var rowClass = (tr_counter % 2 === 0) ? "even-row" : "odd-row";
                html += "<tr class=\""+rowClass+"\">";
                html += "<td>";
                html += tr_counter+1;
                html += "</td>";

                // create a table cell for each item in the row
                var td_validator = ['code', 'agency', 'status']
                td_validator.forEach(column => {
                    html += "<td id=\"" + column + "\">";
                    html += row[column] !== undefined ? row[column] : ""; // add value or leave empty
                    html += "</td>";
                });
                html += "</tr>";
                tr_counter += 1;
            });

            $(".import_table").append(html);
            html = '';
        };
        reader.readAsBinaryString(file);
    }

    function proccess_xl_file() {
        if (!storedFile) {
            alert("No file selected!");
            return;
        }

        let reader = new FileReader();
        reader.onload = function (e) {
            let data = new Uint8Array(e.target.result);
            let workbook = XLSX.read(data, { type: "array" });

            let sheetName = workbook.SheetNames[0];
            let worksheet = workbook.Sheets[sheetName];

            let jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });

            if (!Array.isArray(jsonData) || jsonData.length < 2) {
                console.error("Invalid data format: No data rows found.");
                alert("Invalid file format. Please upload a valid Excel file.");
                return;
            }

            console.log("Extracted Data:", jsonData);

            let headers = jsonData[0];
            let records = jsonData.slice(1);

            let columnMapping = {
                "code": "code",
                "agency": "agency",
                "status": "status"
            };

            let statusMapping = {
                "active": 1,
                "inactive": 0
            };

            let existingRecords = [];
            let invalidRecords = [];
            let insertedRecords = 0;
            let totalRecords = records.length;
            let processedCount = 0;

            records.forEach((row, rowIndex) => {
                let dataObject = {};
                let isValid = true;

                headers.forEach((header, index) => {
                    let dbColumn = columnMapping[header];
                    if (dbColumn) {
                        let value = row[index]?.trim() ?? null;
                        dataObject[dbColumn] = value;
                        if (!value) isValid = false;
                    }
                });

                if (dataObject['status']) {
                    dataObject['status'] = statusMapping[dataObject['status'].toLowerCase()] ?? 0;
                }

                dataObject['created_date'] = formatDate(new Date());
                dataObject['created_by'] = user_id;

                if (!dataObject.code || !dataObject.agency || dataObject.status === null) {
                    invalidRecords.push(`Row ${rowIndex + 2}`);
                    processedCount++;
                    checkCompletion();
                    return;
                }

                check_if_exists(dataObject, function (exists) {
                    console.log("Check if it exists:", exists);
                    if (exists) {
                        existingRecords.push(dataObject.code);
                        processedCount++;
                        checkCompletion();
                    } else {
                        save_to_db(dataObject, function (success) {
                            if (success) {
                                insertedRecords++;
                                console.log(`Record inserted successfully: ${dataObject.code}`);
                            }
                            processedCount++;
                            checkCompletion();
                        });
                    }
                });
            });

            function checkCompletion() {
                console.log(`Processed count: ${processedCount}, Total records: ${totalRecords}`);
                if (processedCount === totalRecords) {
                    if (invalidRecords.length > 0) {
                        load_swal(
                            'add_alert',
                            '500px',
                            "error",
                            "Error!",
                            `The following rows have missing values: ${invalidRecords.join(', ')}`,
                            false,
                            false
                        );
                    } else if (existingRecords.length > 0) {
                        load_swal(
                            'add_alert',
                            '500px',
                            "error",
                            "Error!",
                            `The following records already exist in masterfile: ${existingRecords.join(', ')}`,
                            false,
                            false
                        );
                    } else if (insertedRecords > 0) {
                        load_swal(
                            'add_alert',
                            '500px',
                            "success",
                            "Success!",
                            `${insertedRecords} records inserted successfully!`,
                            false,
                            false
                        ).then(() => {
                            location.reload();
                        });
                    }
                }
            }
        };

        reader.readAsArrayBuffer(storedFile);
    }

    // Function to check if record exists
    function check_if_exists(dataObject, callback) {
        var data = {
            event: "list",
            select: "id, code, agency", // Adjust as needed for your schema
            query: `code = '${dataObject.code}' OR agency = '${dataObject.agency}'`, // Query for existing data
            offset: 0,
            limit: 0,
            table: "tbl_agency"
        };

        console.log("Sending data to check_if_exists:", data); // Debugging

        $.ajax({
            url: "<?= base_url('cms/global_controller'); ?>", // URL of the controller
            type: 'POST',
            data: data,
            success: function (result) {
                console.log("Raw server response:", result); // Debugging

                // Ensure the result is parsed as JSON
                try {
                    result = JSON.parse(result);
                } catch (e) {
                    console.error("Failed to parse response:", e);
                    callback(false); // Exit early if response parsing fails
                    return;
                }

                if (!Array.isArray(result)) {
                    console.error("Expected an array, but received:", result); // Debugging invalid format
                    callback(false); // Exit early if the response is not an array
                    return;
                }

                // Log the result for further inspection
                result.forEach(item => {
                    console.log(`Checking item: code = ${item.code}, agency = ${item.agency}`);
                });

                // Check if any record has the same code or team description
                let exists = result.some(item => {
                    // Trim both fields and use case-insensitive comparison
                    let itemCode = item.code;
                    let itemAgency = item.agency;
                    let dataCode = dataObject.code;
                    let dataAgency = dataObject.agency;

                    console.log(`Comparing: ${dataCode} === ${itemCode} || ${dataAgency} === ${itemAgency}`);

                    return itemCode === dataCode || itemAgency === dataAgency;
                });

                console.log("Does record exist?", exists); // Debugging
                callback(exists); // Pass the result to the callback
            },
            error: function (e) {
                console.error("Error checking for existing record:", e);
                callback(false); // If error occurs, assume the record doesn't exist
            }
        });
    }


</script>