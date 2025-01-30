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
        background-color: #1F2D3D;
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
                <b>T E A M</b>
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
                                            <th class='center-content'>Team Description</th>
                                            <th class='center-content'>Status</th>
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
<div class="modal fade" id="save_team_modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">
                    <b></b>
                </h1>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Code</label>
                    <input type="text" class="form-control required" id="add_code">
                </div>
                <div class="form-group">
                    <label>Team Description</label>
                    <input type="text" class="form-control required" id="add_team_description">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input large-checkbox" id="add_status">
                    <label class="form-check-label large-label" for="status">Active</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn save" id="saveBtn">Save changes</button>
                <button type="button" class="btn caution" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Update MODAL -->
<div class="modal fade" id="update_team_modal" tabindex="-1" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Team</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="text" hidden id="e_id">
            <div class="modal-body">
                <div class="form-group">
                    <label>Code</label>
                    <input type="text" class="form-control required" id="code">
                </div>
                <div class="form-group">
                    <label>Team Description</label>
                    <input type="text" class="form-control required" id="team_description">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input large-checkbox" id="status">
                    <label class="form-check-label large-label" for="status">Active</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn save" id="updateBtn">Update</button>
                <button type="button" class="btn caution" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- View MODAL -->
<div class="modal fade" id="view_team_modal" tabindex="-1" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View User</h5>
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
                        <label>Team Description</label>
                        <input type="text" class="form-control" id="team_description" readonly>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input large-checkbox" id="status" disabled>
                        <label class="form-check-label large-label" for="status">Active</label>
                    </div>
                </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-primary" id="updateBtn">Update</button> -->
                <button type="button" class="btn caution" data-dismiss="modal">Close</button>
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
                        <!-- DI PA TAPOS VALIDATION NG IMPORT -->
                        <input
                            type="file"
                            style="display: none;"
                            id="file"
                            accept=".xls,.xlsx,.csv"
                            aria-describedby="import_files"
                            onchange="handle_file_upload(event)"
                            onclick="clear_import_table()"
                        >

                        <label for="preview" class="custom-file-upload save" id="preview_xl_file" style="margin-top: 10px" onclick="read_xl_file()">
                            <i class="fa fa-sync" style="margin-right: 5px;"></i>Preview Data
                        </label>

                        <table class= "table table-bordered listdata">
                            <thead>
                                <tr>
                                    <th class='center-content'>Line #</th>
                                    <th class='center-content'>Code</th>
                                    <th class='center-content'>Team Description</th>
                                    <th class='center-content'>Status</th>
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
    var url = "<?= base_url("cms/global_controller");?>";

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

    function get_data(keyword = null)
    {
      var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "list",
            select : "id, code, team_description, status, updated_date",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_team",
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
                        html += "<td>" + y.code + "</td>";
                        html += "<td>" + y.team_description + "</td>";
                        html += "<td>" +status+ "</td>";
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
            table : "tbl_team",
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
            title = addNbsp('ADD TEAM')
            $("#save_team_modal").find('.modal-title').find('b').html(title)
            $('#save_team_modal').modal('show');
        });
    });

    $(document).on('click', '#saveBtn', function() {
        if(validate.standard("save_team_modal")){
            save_data();
        }
        // console.log($('#add_code').val());
        // console.log($('#add_team_description').val());
        // console.log($('#add_status').val());
    });

    $(document).on('click', '#updateBtn', function() {
        if(validate.standard("update_team_modal")){
            var id = $(this).attr('data-id');
            update_data(id);
        }
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

    $(document).on('click', '#btn_import ', function() {
        title = addNbsp('IMPORT TEAM')
        $("#import_modal").find('.modal-title').find('b').html(title)
        $("#import_modal").modal('show')
        clear_import_table()
    });

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
                var td_validator = ['code', 'team description', 'status']
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

    // function proccess_xl_file() {
    //     var extracted_data = $(".import_table");
    //     var html_tr_count = 1;
    //     var invalid = false;
    //     var errmsg = '';
    //     var unique_code = [];
    //     var unique_team_description = [];
    //     var import_array = [];
    //     extracted_data.find('tr').each(function () {
    //         var html_td_count = 1;
    //         var temp = [];
    //         $(this).find('td').each( function() {
    //             var text_val = $(this).html().trim();
    //             if (html_td_count != 1) {
    //                 temp.push(text_val)
    //             }

    //             if (html_td_count == 2) {
    //                 if (unique_code.includes(text_val)) {
    //                     invalid = true;
    //                     errmsg += "⚠️ Duplicated Code at line #: <b>" + html_tr_count + "</b>⚠️<br>";
    //                 } else {
    //                     unique_code.push(text_val);
    //                 }
    //             }
    //             if (html_td_count == 2 && text_val == '') {
    //                 invalid = true;
    //                 errmsg += "⚠️ Invalid Code at line #: <b>"+html_tr_count+"</b>⚠️<br>";
    //             }
    //             if (html_td_count == 2 && text_val.length > 25) {
    //                 invalid = true;
    //                 errmsg += "⚠️ Code exceeds the set character limit(25) at line #: <b>"+html_tr_count+"</b>⚠️<br>";
    //             }

    //             if (html_td_count == 3) {
    //                 if (unique_team_description.includes(text_val)) {
    //                     invalid = true;
    //                     errmsg += "⚠️ Duplicated Description at line #: <b>"+html_tr_count+"</b>⚠️<br>";
    //                 }
    //                 else {
    //                     unique_team_description.push(text_val)
    //                 }
    //             }
    //             if (html_td_count == 3 && text_val == '') {
    //                 invalid = true;
    //                 errmsg += "⚠️ Invalid Description at line #: <b>"+html_tr_count+"</b>⚠️<br>";
    //             }
    //             if (html_td_count == 3 && text_val.length > 50) {
    //                 invalid = true;
    //                 errmsg += "⚠️ Description exceeds the set character limit(50) at line #: <b>"+html_tr_count+"</b>⚠️<br>";
    //             }

    //             if (html_td_count == 4 && text_val.toLowerCase() != 'active' && text_val.toLowerCase() != 'inactive') {
    //                 invalid = true;
    //                 errmsg += "⚠️ Invalid Status at line #: <b>"+html_tr_count+"</b>⚠️<br>";
    //             }

    //             html_td_count+=1;
    //         })

    //         import_array.push(temp)
    //         html_tr_count+=1;
    //     });

    //     var temp_invalid = invalid;
    //     var temp_err_msg = '';
    //     var temp_line_no = 0;
    //     var promises = [];

    //     import_array.forEach(row => {
    //         check_current_db(function(result) {
    //             var parsedResult = JSON.parse(result);

    //             $.each(parsedResult, function(index, item) {
    //                 if (item.code === row[0] && item.team_description === row[1]) {
    //                     temp_invalid = true;
    //                     temp_err_msg += "⚠️ Code already exists in masterfile at line #: <b>"+temp_line_no+"</b>⚠️<br>";
    //                 }
    //                 else if (item.code === row[0]) {
    //                     temp_invalid = true;
    //                     temp_err_msg += "⚠️ Code already exists in masterfile at line #: <b>"+temp_line_no+"</b>⚠️<br>";
    //                 }
    //                 else if (item.team_description === row[1]) {
    //                     temp_invalid = true;
    //                     temp_err_msg += "⚠️ Description already exists in masterfile at line #: <b>"+temp_line_no+"</b>⚠️<br>";
    //                 } else {
                        
    //                 }
    //             });
    //             temp_line_no+=1;
    //         });
    //     });
        
    //     invalid = temp_invalid;
    //     errmsg += temp_err_msg;

    //     if(invalid) {
    //         load_swal(
    //             '',
    //             '1000px',
    //             'error',
    //             'Error!',
    //             errmsg,
    //             false,
    //             true
    //         )
    //         $("#import_modal").modal('hide')
    //         return
    //     }
    //     import_array.forEach(row => {
    //         var status_val = 0;
    //         if (row[2] == 'active') {
    //             status_val = 1
    //         } else {
    //             status_val = 0
    //         }
    //         save_to_db(row[0], row[1], status_val)
    //     })

    //     get_pagination();
    // }

    function handle_file_upload(event) {
        const file = event.target.files[0]; // Get the uploaded file
        if (!file) {
            alert('No file selected. Please upload a valid Excel file.');
            return;
        }

        const reader = new FileReader();

        // Read the file as an ArrayBuffer for SheetJS processing
        reader.onload = function (e) {
            const data = new Uint8Array(e.target.result); // Convert to Uint8Array
            const workbook = XLSX.read(data, { type: 'array' }); // Read workbook
            const sheetName = workbook.SheetNames[0]; // Use the first sheet
            const sheet = workbook.Sheets[sheetName];

            // Convert the sheet data to a 2D array
            const parsedData = XLSX.utils.sheet_to_json(sheet, { header: 1 }); // Header: 1 = array format
            console.log("Parsed Data:", parsedData);

            // Pass data to the processing function
            proccess_xl_file(parsedData);
        };

        reader.readAsArrayBuffer(file); // Trigger file reading
    }

    // Function to process the parsed Excel data
    function proccess_xl_file(data) {
        console.log("Processing Data:", data);

        if (!Array.isArray(data) || !Array.isArray(data[0])) {
            console.error("Invalid data format: Data must be a 2D array.");
            return;
        }

        const headerRow = data[0]; // Optional: Capture the header row
        const rows = data.slice(1); // Skip the header row

        rows.forEach((row, index) => {
            console.log(`Row ${index + 1}:`, row);

            // Assuming columns are structured as follows:
            const code = row[0]; // Column 1
            const team_description = row[1]; // Column 2
            const status_val = row[2]?.toLowerCase() === 'active' ? 1 : 0; // Column 3

            // Pass each row's data to save_to_db
            save_to_db(code, team_description, status_val);
        });
    }



    function save_data() {
        var status = $('#save_team_modal #status').prop('checked') ? 1 : 0;
        modal.confirm("Are you sure you want to save this record?",function(result){
            if(result){ 
                var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
                var data = {
                    event : "insert", // list, insert, update, delete
                    table : "tbl_team", //table
                    data : {
                            code : $('#save_team_modal #add_code').val(),
                            team_description : $('#save_team_modal #add_team_description').val(),
                            status : $('#save_team_modal #add_status').val(),
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

    function save_to_db(code, team_description, status_val) {
        var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
        var data = {
            event : "insert", // list, insert, update, delete
            table : "tbl_team", //table
            data : {
                    code : code,
                    team_description : team_description,
                    created_date : formatDate(new Date()),
                    created_by : user_id,
                    status : status_val
            }  
        }
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            location.reload();
        });
    }

    function get_data_by_id(id){
        var query = "id = " + id;
        var exists = 0;

        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, code, team_description, status, updated_date",
            query : query, 
            table : "tbl_team"
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result);
            console.log(obj);
            if(obj){
                $.each(obj, function(x,y) {
                    console.log(y);
                    $('#update_team_modal #code').val(y.code);
                    $('#update_team_modal #team_description').val(y.team_description);
                    
                    if(y.status == 1){
                        $('#update_team_modal #status').prop('checked', true);
                    }else{
                        $('#update_team_modal #status').prop('checked', false);
                    }

                }); 
            }
            
            $('#updateBtn').attr('data-id', id);
            $('#update_team_modal').modal('show');
        });
        return exists;
    }

    function update_data(id){
        var code = $('#code').val()
        var team_desc = $('#team_description').val()
        var status = $('#status').prop('checked')


        var status = $('#update_team_modal #status').prop('checked') ? 1 : 0;
        modal.confirm("Are you sure you want to update this record?",function(result){
            console.log(result);
            if(result){ 
                var url = "<?= base_url('cms/global_controller');?>"; //URL OF CONTROLLER
                var data = {
                    event : "update", // list, insert, update, delete
                    table : "tbl_team", //table
                    field : "id",
                    where : id, 
                    data : {
                            code : code,
                            team_description : team_desc,
                            status : $('#update_team_modal #status').val(),
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
                    table : "tbl_team", //table
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
            select : "id, code, team_description, status, updated_date",
            query : query, 
            table : "tbl_team"
        }

        aJax.post(url,data,function(result){
            var obj = is_json(result);
            console.log(obj);
            if(obj){
                $.each(obj, function(x,y) {
                    console.log(y);
                    $('#view_team_modal #code').val(y.code);
                    $('#view_team_modal #team_description').val(y.team_description);
                    
                    if(y.status == 1){
                        $('#view_team_modal #status').prop('checked', true);
                    }else{
                        $('#view_team_modal #status').prop('checked', false);
                    }

                }); 
            }
            
            $('#view_team_modal').modal('show');
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

    function check_current_db(successCallback) {
        var data = {
            event : "list",
            select : "id, code, team_description, status",
            query : query,
            offset : 0,
            limit : 0,
            table : "tbl_team",
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

    function client_validate_data(code, team_description, e) {
        var invalid = false;
        var err_title = 'Error!'
        var err_msg = '';
        var result = true;
        // remove leading and trailing whitespace from user input
        var trim_code = code.trim();
        var trim_desc = team_description.trim()
        // check for empty fields
        if (trim_code === "" && trim_desc === "") {
            invalid = true; // Mark the input as invalid.
            err_msg+= "Code and Description is required<br>"; // Add error message.
        }
        else if (trim_code == "") {
            invalid = true;
            err_msg+= 'Code is required<br>';
        }
        else if (trim_desc == "") {
            invalid = true;
            err_msg+= 'Description is required<br>';
        }
        // check if the input exceeds the maximum allowed length for the database (25 characters).
        if (trim_code.length > 25) {
            invalid = true;
            err_msg += "Code is too long. Maximum allowed is 25 characters.<br>";
        }
        // check if the input exceeds the maximum allowed length for the database (50 characters).
        if (trim_desc.length > 50) {
            invalid = true;
            err_msg+="Description is too long. Maximum allowed is 50 characters.<br>";
        }

        // if input is invalid (invalid = true) display alert to user
        if (invalid) {
            load_swal(
                'add_alert', // custom class in case you want to modify the alert
                '500px',
                "error", // alert style
                "Error!", // title.
                err_msg, // message
                false, // prevent closing alert by clicking outside of alert
                false // prevent closing alert by pressing escape key
            );
            
            result = false; // assign false to result to prevent saving
        }

        return result;
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

    function addNbsp(inputString) {
        return inputString.split('').map(char => {
            if (char === ' ') {
            return '&nbsp;&nbsp;';
            }
            return char + '&nbsp;';
        }).join('');
    }

    
</script>