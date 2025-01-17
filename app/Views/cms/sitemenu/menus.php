

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
                              <th class = "w-10"></th>
                              <th class = "w-10"><input class ="selectall" type ="checkbox"></th>
                              <th class = "center-align-format">Menu</th>
                              <th class = "center-align-format">Url</th>
                              <th class = "center-align-format">Type</th>
                              <th class = "center-align-format">Date Modified</th>
                              <th class = "center-align-format">Status</th>
                              <th class = "center-align-format">Edit</th>
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
    var query = "status >= 0";
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
            select : "id, menu_url, menu_name, default_menu, menu_type, updated_date, status",
            query : query,
            offset : offset,
            limit : limit,
            table : "site_menu",
            order : {
                field : "updated_date", //field to order
                order : "desc" //asc or desc
            }

        }

        aJax.post(url,data,function(result){
            var result = JSON.parse(result);
            var html = '';

            if(result) {
                if (result.length > 0) {
                    $.each(result, function(x,y) {
                        html += '<tr>';
                        html += '<td class="hide"><p class="order" data-order="" data-id='+y.id+'></p></td>';
                        html += '<td class="list-bg-color"><span class="list-span-color move-menu glyphicon glyphicon-th"></span></td>';
                        html += '<td><input class = "select"  data-id= '+y.id+' data-menu='+y.menu_name+' type ="checkbox"></td>';

                        if (y.menu_type === "Group Menu") {
                            if (y.menu_type === "Buy Now") {
                                html += '<td><a class="text-primary" href="<?= base_url('dynamic/Site_menu/shop_list');?>">'+y.menu_name+'</a></td>';
                            } else {
                                html += '<td><a class="text-primary" href="<?= base_url('dynamic/Site_menu/menu');?>/'+y.id+'/'+y.menu_name+'" >'+y.menu_name+'</a></td>';
                            }
                        } else {
                            if (parseInt(y.default_menu) === 1) {
                                html += '<td>' +y.menu_name+ ' <b><i>(default)</i></b></td>';
                            } else {
                                html += '<td>' +y.menu_name+ '</td>';
                            }
                        }

                        html += '<td>' +y.menu_url+ '</td>'; 
                        html += '<td>'+y.menu_type+ '</td>';
                        html += '<td class = "center-align-format">' + moment(y.updated_date).format('LLL')+ '</td>';
                        if (parseInt(y.status) === 1) {
                            status = 'Active';
                        }
                        else {
                            status = 'Inactive';
                        }

                        html += '<td>'+status+'</td>';
                        html += "<td class = 'center-align-format'><a href='<?= base_url()."dynamic/"?>Site_menu/menu_update/"+y.id+"' class='edit' title='edit'><span class='glyphicon glyphicon-pencil'></span></a></td>";
                        html += '</tr>';
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
            table : "site_menu",
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