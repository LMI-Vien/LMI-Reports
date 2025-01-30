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
</style>

<div class="content-wrapper p-4">
    <div class="card">
        <div class="text-center page-title">
            <b>A R E A&nbsp;&nbsp;&nbsp;S A L E S&nbsp;&nbsp;&nbsp;C O O R D I N A T O R</b>
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
                                    <th class='center-content'>Store/Branch</th>
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
                        <input type="text" class="form-control" id="code" aria-describedby="code">
                        <small id="code" class="form-text text-muted">* required, must be unique, max 25 characters</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" aria-describedby="description">
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.3/xlsx.full.min.js"></script>
<script>
    var query = "status >= 0";
    var limit = 10; 
    var user_id = '<?=$session->sess_uid;?>';
    var url = "<?= base_url("cms/global_controller");?>";

    $(document).ready(function() {
        get_data(query);
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

    function get_data(new_query) {
        var data = {
            event : "list",
            select : "id, code, description, status",
            query : new_query,
            offset : offset,
            limit : limit,
            table : "tbl_asc",
            order : {
                field : "code, updated_date",
                order : "asc, desc" 
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
                        html += "<td class='center-content' style='width: 5%'><input class='select' type=checkbox data-id="+y.id+" onchange=checkbox_check()></td>";
                        html += "<td style='width: 20%'>" + y.code + "</td>";
                        html += "<td style='width: 40%'>" + y.description + "</td>";
                        html += "<td style='width: 10%'>" + status + "</td>";
    
                        if (y.id == 0) {
                            html += "<td><span class='glyphicon glyphicon-pencil'></span></td>";
                        } else {
                            html+="<td class='center-content' style='width: 25%'>";
                            html+="<a class='btn-sm btn save' onclick=\"edit_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Edit Details'><span class='glyphicon glyphicon-pencil'>Edit</span>";
                            html+="<a class='btn-sm btn delete' onclick=\"delete_data('"+y.id+"')\" data-status='"+y.status+"' id='"+y.id+"' title='Delete Item'><span class='glyphicon glyphicon-pencil'>Delete</span>";
                            html+="<a class='btn-sm btn view' onclick=\"view_data('"+y.id+"', 'v_', 'view_modal', 'VIEW ')\" data-status='"+y.status+"' id='"+y.id+"' title='Show Details'><span class='glyphicon glyphicon-pencil'>View</span>";
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
        var data = {
        event : "pagination",
            select : "id",
            query : query,
            offset : offset,
            limit : limit,
            table : "tbl_asc",
            order : {
                field : "updated_date", //field to order
                order : "desc" //asc or desc
            }
    
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
        modal.loading(false);
    });

    $(document).on('keydown', '#search_query', function(event) {
        if (event.key == 'Enter') {
            search_input = $('#search_query').val();
            offset = 1;
            get_pagination();
            new_query = query;
            new_query += ' and code like \'%'+search_input+'%\' or '+query+' and description like \'%'+search_input+'%\'';
            get_data(new_query);
        }
    });

    $('#btn_add').on('click', function() {
        open_modal('Add New ASC', 'add', '');
    });

    function edit_data(id) {
        open_modal('Edit ASC', 'edit', id);
    }

    function view_data(id) {
        open_modal('View ASC', 'view', id);
    }

    function open_modal(msg, actions, id) {
        modal_title = addNbsp(msg);
        $('#popup_modal .modal-title b').html(modal_title);
        $('#popup_modal #code').val('');
        $('#popup_modal #description').val('');
        $('#popup_modal #status').prop('checked', true);
        // <button type="button" class="btn save" id="save_data">Save</button>
        var save_btn = create_button('Save', 'save_data', 'btn save', function () {
            save_data();
            if(validate.standard("form-save-modal")){
                save_data(e);
            }
        });
        // <button type="button" class="btn save" id="edit_data">Edit</button>
        var edit_btn = create_button('Edit', 'edit_data', 'btn save', function () {
            alert("Form edited!");
        });
        // <button type="button" class="btn caution" data-dismiss="modal">Close</button>
        var close_btn = create_button('Close', 'close_data', 'btn caution', function () {
            $('#popup_modal').modal('hide');
        });
        switch (actions) {
            case 'add':
                $('#code').attr('readonly', false);
                $('#code').attr('disabled', false);
                $('#description').attr('readonly', false);   
                $('#description').attr('disabled', false);
                $('#popup_modal .modal-footer').empty();
                $('#popup_modal .modal-footer').append(save_btn);
                $('#popup_modal .modal-footer').append(close_btn);
                break;
                
            case 'edit':
                populate_modal(id);
                $('#code').attr('readonly', false);
                $('#code').attr('disabled', false);
                $('#description').attr('readonly', false);   
                $('#description').attr('disabled', false);
                $('#popup_modal .modal-footer').empty();
                $('#popup_modal .modal-footer').append(edit_btn);
                $('#popup_modal .modal-footer').append(close_btn);
                break;
            
            case 'view':
                populate_modal(id);
                $('#code').attr('readonly', true);
                $('#code').attr('disabled', true);
                $('#description').attr('readonly', true);   
                $('#description').attr('disabled', true);
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

    function delete_data(id) {
        alert('Data deleted!');
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
        alert('Data saved!');
    }

    function populate_modal(inp_id) {
        var query = "status >= 0 and id = " + inp_id;
        var url = "<?= base_url('cms/global_controller');?>";
        var data = {
            event : "list", 
            select : "id, code, description, status",
            query : query, 
            table : "tbl_asc"
        }
        aJax.post(url,data,function(result){
            var obj = is_json(result);
            if(obj){
                $.each(obj, function(index,asc) {
                    $('#id').val(asc.id);
                    $('#code').val(asc.code);
                    $('#description').val(asc.description);
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
</script>