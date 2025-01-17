

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
                        <table class= "table table-bordered listdata">
                        <thead>
                            <tr>
                                <th class='center-content'><input class ="selectall" type ="checkbox"></th>
                                    <th class='center-content'>Name</th>
                                    <th class='center-content'>Username</th>
                                    <th class='center-content'>Email Address</th>
                                    <th class='center-content'>User Role</th>
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



<script>
    var query = "u.status >= 0";
    var limit = 10; 
    $(document).ready(function() {
      get_data();
      get_pagination();
    });

    function get_data()
    {
      var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "list",
            select : "u.id, u.username, u.email, u.name, u.status, r.name as role_name",
            query : query,
            offset : offset,
            limit : limit,
            table : "cms_users u",
            order : {
                field : "u.update_date", //field to order
                order : "desc" //asc or desc
            },
            join : [ //optional
                {
                    table : "cms_user_roles r", //table
                    query : "r.id = u.role", //join query
                    type : "left" //type of join
                }
            ]

        }

        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            var html = '';

            if(result) {
                if (result.length > 0) {
                    $.each(result, function(x,y) {
                        var status = (parseInt(y.status) === 1) ? status = "Active" : status = "Inactive";
            
                        html+="<tr>";
                        html+="<td class='center-content'><input class = 'select'  data-id = '"+y.id+"' data-name='"+y.name+"' data-logs='"+y.user_block_logs+"' type ='checkbox'></td>";
                        html+="<td>"+y.name+"</td>";
                        html+="<td>"+y.username+"</td>";
                        html+="<td>"+y.email+"</a></p></td>";
                        html+="<td>"+y.role_name+"</a></p></td>";
                        html+="<td>"+status+"</a></td>";
                        html+="<td class='center-content'>";
                        html+="<a href='#' class='btn-sm btn edit' data-status='"+y.status+"' id='"+y.id+"' title='edit'><span class='glyphicon glyphicon-pencil'>Edit</span>";
                        html+="<a href='#' class='btn-sm btn edit' data-status='"+y.status+"' id='"+y.id+"' title='edit'><span class='glyphicon glyphicon-pencil'>Delete</span>";
                        html+="<a href='#' class='btn-sm btn edit' data-status='"+y.status+"' id='"+y.id+"' title='edit'><span class='glyphicon glyphicon-pencil'>View</span>";
                        html+="</td>";
                        html+="</tr>";
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
            select : "u.id",
            query : query,
            offset : offset,
            limit : limit,
            table : "cms_users u",
            order : {
                field : "u.update_date", //field to order
                order : "desc" //asc or desc
            },
            join : [ //optional
                {
                    table : "cms_user_roles r", //table
                    query : "r.id = u.role", //join query
                    type : "left" //type of join
                }
            ]

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
    })

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
</script>