

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


</style>

    <div class="content-wrapper p-4">
        <div class="card">
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
                        <table class= "table table-bordered listdata" style="background-image: url('your-image.jpg');">
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


    <div class="modal fade" id="save_modal" tabindex="-1" aria-labelledby="save_modalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="save_modalLabel">Save Record</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="form-save-modal">
              <div class="form-group">
                <label for="code">Code</label>
                <input type="text" class="form-control required" id="code" aria-describedby="code">
                <small id="code" class="form-text text-muted">add sample format here</small>
              </div>
              <div class="form-group">
                <label for="agency">Agency</label>
                <input type="text" class="form-control required" id="agency">
              </div>
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input required" id="status">
                <label class="form-check-label" for="status">Status</label>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="save_data">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="update_modal" tabindex="-1" aria-labelledby="update_modalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="update_modallLabel">Update Record</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="code">Code</label>
                <input type="text" class="form-control" id="code" aria-describedby="code">
                <small id="code" class="form-text text-muted">add sample format here</small>
              </div>
              <div class="form-group">
                <label for="agency">Agency</label>
                <input type="text" class="form-control" id="agency">
              </div>
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="status">
                <label class="form-check-label" for="status">Status</label>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="update_data" data-id="">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="view_modal" tabindex="-1" aria-labelledby="update_modalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="update_modallLabel">View Record</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="code">Code</label>
                <input type="text" class="form-control" id="code" aria-describedby="code" readonly>
                <small id="code" class="form-text text-muted">add sample format here</small>
              </div>
              <div class="form-group">
                <label for="agency">Agency</label>
                <input type="text" class="form-control" id="agency" readonly>
              </div>
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="status" disabled>
                <label class="form-check-label" for="status">Status</label>
              </div>
              <div class="modal-footer">
                <!-- <button type="button" class="btn btn-primary" id="update_data" data-id="">Update</button> -->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </form>
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
    });

    function get_data(keyword = null)
    {
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

                        html += "<tr>";
                        html += "<td class='center-content'><input class='select' type=checkbox data-id="+y.id+" onchange=checkbox_check()></td>";
                        html += "<td>" + y.code + "</td>";
                        html += "<td>" + y.agency + "</td>";
                        html += "<td class='center-content'>" + (y.updated_date ? y.updated_date : "N/A") + "</td>";
                        html += "<td>" +status+ "</td>";

                        html+="<td class='center-content'>";
                        html+="<a class='btn-sm btn-success btn edit btn-custom button-spacing' data-status='"+y.status+"' id='"+y.id+"' title='edit'><span class='glyphicon glyphicon-pencil'>Edit</span>";
                        html+="<a class='btn-sm btn-danger btn delete_data btn-custom button-spacing' data-status='"+y.status+"' id='"+y.id+"' title='edit'><span class='glyphicon glyphicon-pencil'>Delete</span>";
                        html+="<a class='btn-sm btn-info btn view btn-custom' data-status='"+y.status+"' id='"+y.id+"' title='edit'><span class='glyphicon glyphicon-pencil'>View</span>";
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

    $(document).on('click', '.edit', function() {
      id = $(this).attr('id');
      get_data_by_id(id);

    });

    $(document).on('click', '.view', function() {
      id = $(this).attr('id');
      get_data_by_id_view(id);

    });

    $(document).on('click', '#btn_add', function() {
        $('#save_modal').modal('show');
    });

    $(document).on('click', '#save_data', function() {
        if(validate.standard("form-save-modal")){

        }
        //save_data();
        // console.log($('#code').val());
        // console.log($('#agency').val());
        // console.log($('#status').val());
    });

    $(document).on('click', '#update_data', function() {
        var id = $(this).attr('data-id');
        update_data(id);
    });

    $(document).on('click', '.delete_data', function() {
        var id = $(this).attr('id');
        delete_data(id); 
    });


    $("#btn_export").on("click", function (e) {
      alert("call ajax to controler");
    });

    function save_data(){
        var status = $('#save_modal #status').prop('checked') ? 1 : 0;
        // var status = $('#save_modal #status').val();
        // if(status == 'on'){
        //     status = 1;
        // }else{
        //     status = 0;
        // }
        modal.confirm("Are you sure you want to save this record?",function(result){
            if(result){ 
                var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
                var data = {
                    event : "insert", // list, insert, update, delete
                    table : "tbl_agency", //table
                    data : {
                            code : $('#save_modal #code').val(),
                            agency : $('#save_modal #agency').val(),
                            created_date : formatDate(new Date()),
                            //update_date : formatDate(new Date()).format('YYYY-MM-DD HH:mm:ss'),
                            //to follow created data and created by
                            created_by : user_id,
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

    function update_data(id){
        var status = $('#update_modal #status').prop('checked') ? 1 : 0;
        // if(status == 'on'){
        //     status = 1;
        // }else{
        //     status = 0;
        // }
        modal.confirm("Are you sure you want to update this record?",function(result){
            if(result){ 
                var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
                var data = {
                    event : "update", // list, insert, update, delete
                    table : "tbl_agency", //table
                    field : "id",
                    where : id, 
                    data : {
                            code : $('#update_modal #code').val(),
                            agency : $('#update_modal #agency').val(),
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
                    //alert("pasok");
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
            select : "id, code, agency, status",
            query : query, 
            table : "tbl_agency"
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result);
            console.log(obj);
            if(obj){
                $.each(obj, function(x,y) {
                    console.log(y);
                    $('#update_modal #code').val(y.code);
                    $('#update_modal #agency').val(y.agency);
                    if(y.status == 1){
                        $('#update_modal #status').prop('checked', true);
                    }else{
                        $('#update_modal #status').prop('checked', false);
                    }

                }); 
            }
            
            $('#update_data').attr('data-id', id);
            $('#update_modal').modal('show');
        });
        return exists;
    }

    function get_data_by_id_view(id){
        var query = "id = " + id;
        var exists = 0;

        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, code, agency, status",
            query : query, 
            table : "tbl_agency"
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result);
            console.log(obj);
            if(obj){
                $.each(obj, function(x,y) {
                    console.log(y);
                    $('#view_modal #code').val(y.code);
                    $('#view_modal #agency').val(y.agency);
                    if(y.status == 1){
                        $('#view_modal #status').prop('checked', true);
                    }else{
                        $('#view_modal #status').prop('checked', false);
                    }

                }); 
            }
            
            // $('#update_data').attr('data-id', id);
            $('#view_modal').modal('show');
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