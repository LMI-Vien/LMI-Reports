<?php 
    $dir = dirname(__FILE__);
    css($dir . "/assets/styles.css", "Audit Trail Style");
    $optionSet = '';
    foreach ($pageOption as $pageOptionLoop) {
        $optionSet .= "<option value='".$pageOptionLoop."'>".$pageOptionLoop."</option>";
    } 
?>

<div class="box audit_trail_div">
    <?php   
        echo view("dynamic/template/buttons", $buttons);
    ?>  
	<?php 
        $optionSet = '';
        foreach ($pageOption as $pageOptionLoop) {
            $optionSet .= "<option value='".$pageOptionLoop."'>".$pageOptionLoop."</option>";
        } 
	?>
    <div class="box-body">
        <div class="form-group record-entries pull-right">
            <label>Show</label> 
                <select id="record-entries">
                <?php echo $optionSet;?>
                </select>
            <label>Entries</label>
        </div>
        <div class="col-md-12 list-data tbl-content" id="list-data">
            <table class= "table table-bordered listdata table-bordered ">
               <thead>
                    <tr>
                        <th class = 'center-align-format'>Site</th>
                        <th class = 'center-align-format'>Page</th>
                        <th class = 'center-align-format'>Username</th>
                        <th class = 'center-align-format'>Action</th>
                        <th class = 'center-align-format'>Date &amp; Time</th>
                        <th class = 'center-align-format'></th>
                    </tr>  
                 </thead>
                <tbody class="table_body word_break">
                </tbody>
             </table>
        </div>
        <div class="list_pagination"></div>
        <div class="form-group record-entries pull-right">
			<label>Show</label> 
			   <select id="record-entries">
			     <?php echo $optionSet;?>
			   </select>
			<label>Entries</label>
		</div>
    </div>
</div>

<script type="text/javascript">
    var query = "";
    var limit = 10;

    $(document).ready(function() {
        get_data();
        $("#form_search").removeClass( "pull-right" );
        $(document).on('cut copy paste input', '.start-date, .end-date', function(e) {
            e.preventDefault();
        });
    });

	$(document).on("change", ".record-entries select", function(e) {
        $(".record-entries option").removeAttr("selected");
        $(".record-entries select").val($(this).val());
        $(".record-entries option:selected").attr("selected","selected");
        var record_entries = $(this).prop( "selected",true ).val();
        limit = parseInt(record_entries);
        offset = 1;
        get_data();
    });
    
    function get_data(keyword = null) {
        var from = $('.start-date').val();
        var to = $('.end-date').val();
        modal.loading(true); 
        AJAX.select.select("cms_sites.site_name as site_name, cms_audit_trail.new_data as data, cms_audit_trail.id as id, cms_audit_trail.url as Url, cms_users.name as Name, cms_audit_trail.action as Action, cms_audit_trail.created_date as Date");
        AJAX.select.offset(offset);
        AJAX.select.limit(limit);
        AJAX.select.table("cms_audit_trail");
        if (keyword) {
            AJAX.select.where.like("( cms_audit_trail.url", keyword);
            AJAX.select.where.or.like("cms_users.name", keyword);
            AJAX.select.where.or.like("cms_audit_trail.action", keyword);
            AJAX.select.where.or.like("old_data", keyword);
            AJAX.select.where.or.like("new_data", keyword);
            AJAX.select.where.or.like("cms_sites.site_name", keyword);
            AJAX.select.where.or.equal("close_parenthesis", " ");
        }
        if (from && to) {
            AJAX.select.where.greater_equal("cms_audit_trail.created_date", moment(from).format('YYYY-MM-DD HH:mm:ss')); 
            AJAX.select.where.less_equal("cms_audit_trail.created_date", moment(to+" 23:59:59").format('YYYY-MM-DD HH:mm:ss'));
        }
        AJAX.select.order.desc("cms_audit_trail.created_date");
        AJAX.select.join.left("cms_users", "cms_users.id", "cms_audit_trail.user_id");
        AJAX.select.join.left("cms_sites", "cms_sites.id","cms_audit_trail.site_id");
        AJAX.select.exec(function(result) {
            var result = JSON.parse(result);
            var html = '';
            if (result) {
                if (result.length > 0) {
                    $.each(result, function(x,y) {
                        html += '<tr>';
                        var page = y.Url.split("/");
                        var bread = '<ul class="breadcrumb">';
                        var uri =   "<?= base_url('content_management');?>/";

                        var count = 0;
                        $.each(page, function(x,y) {
                            count ++;
                            if (count < 3) {
                                if(count == 1) {
                                    bread += '<li>'+y+'</li>';
                                } else {
                                    bread += '<li>'+y+'</li>';
                                }
                            }
                        });

                        bread += '</ul>';
                        if(y.site_name !== null){
                            html += '   <td>'+y.site_name+'</td>';
                        }else{
                            html += '   <td></td>';
                        }
                        html += '   <td>'+bread+'</td>';
                        html += '   <td>'+y.Name+'</td>';
                        html += '   <td>'+y.Action+'</td>';
                        html += '   <td>'+moment(y.Date).format('LLL')+'</td>';
                        if (y.data != "") {
                            html += '   <td style="width: 50px;"><a class="view_history" href="#" data-id="'+y.id+'"><i class="fa fa-eye"></i></a></td>';
                        } else {
                            html += '   <td style="width: 50px;"></td>';
                        }
                        
                        html += '</tr>';
                    });
                } else {
                    html = '<tr><td colspan=12 class="colspan-no-record">'+ no_records +'</td></tr>';
                }
            }
            $('.table_body').html(html);
            
        }, function(result) {
            var result = JSON.parse(result);
            if (result) {
                if (result.total_page > 1) {
                    pagination.generate(result.total_page, ".list_pagination", get_data);
                }
                else if (result.total_data <= limit) {
                    $('.list_pagination').empty();
                }
            }
        });
        modal.loading(false); 
    }

    pagination.onchange(function() {
        modal.loading(true);
        get_data();
        $("#search_query").val("");
        modal.loading(false);
    });

    $(document).on('keypress', '#search_query', function(e) {                          
        if (e.keyCode === 13) {
            var keyword = $(this).val().trim();
            offset = 1;
            get_data(keyword);
        }
    });

    $(document).on('click', '.view_history', function(e) {
        e.preventDefault();
        modal.loading(true);
        var html = "";
        var html2 = "";
        var data_id = $(this).attr("data-id");
        AJAX.select.select("cms_audit_trail.new_data as new_data,cms_audit_trail.old_data as old_data");
        AJAX.select.table("cms_audit_trail");
        AJAX.select.where.equal("id",data_id);
	    AJAX.select.exec(function(result) {
            var result = JSON.parse(result);
            if (result) {
                var obj = result;
                var obj2 = is_json(obj[0].new_data); 
                var json = is_json(obj[0].old_data);
                var json2 = Object.keys(is_json(obj[0].new_data));
                var obj3 = is_json(obj[0].old_data);
                var obj = result; 
                var obj2 = is_json(obj[0].new_data); 
                var json = Object.keys(is_json(obj[0].old_data));
                var json2 = Object.keys(is_json(obj[0].new_data));
                var obj3 = is_json(obj[0].old_data);

                html += '<table class="col-md-6 table table-bordered m-t-20" >';
                html += '<tbody>';
                html += '<tr id="header">';
                html += '<td class = "center-align-format al-100-px">Field</td>';
                html += '<td class = "center-align-format al-370-px">Old Data</td>';
                html += '<td class = "center-align-format al-370-px">New Data</td>';
                html += '</tr>';
                
                if (obj3[0]) {
                    $.each(obj3[0], function(x,y) {
                        html += '<tr>';
                        html += '<td class = "al-100-px">' + x + '</td>';
                        html += '<td class = "w-370-px">' + y + '</td>';
                        if (json2.indexOf(x) > -1) {
                            if (obj2[x] !== y) {
                                html += '<td class = "bg-c7cdfa">'+ obj2[x] +'</td>';
                            } else {
                                html += '<td>'+ obj2[x] +'</td>';     
                            }
                        } else {
                            html += '<td>'+y+'</td>';
                        }
                        html += '</tr>';
                    });
                } else {
                    var json_new_data = is_json(obj[0].new_data);
                    $.each(json_new_data, function(x,y) {
                        html += '<tr>';
                        html += '<td class="al-100-px">' + x + '</td>';
                        html += '<td class="w-370-bg-fbe7eb">No Data</td>';
                        html += '<td class="w-370-px bg-c7cdfa">' + y + '</td>';
                        html += '</tr>';
                    });
                }
                
                modal.loading(false);
                modal.show('<div class="scroll-500">' + html + '</div>',"large",function(){});
            }
        });
    });

    $(document).on('click', '#btn_filter', function() {
        var from = $('.start-date').val();
        var to = $('.end-date').val();
        var keyword = $('.search-query').val();
        $('.start-date').css('border-color','#ccc');
        $('.end-date').css('border-color','#ccc');
        offset = 1;
        if (!from) {
          $('.start-date').css('border-color','red');
        } else if (!to) {
          $('.end-date').css('border-color','red');
        }
        get_data(null);
    });

   $(document).on('click', '#btn_reset', function() {
        $('.start-date').val('');
        $('.end-date').val('');
        $('.search-query').val('');
        query = "user_id != 0";
        get_data();
    });

</script>