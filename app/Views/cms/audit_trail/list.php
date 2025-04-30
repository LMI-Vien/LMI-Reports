<?php 
    $optionSet = '';
    foreach ($pageOption as $pageOptionLoop) {
        $optionSet .= "<option value='".$pageOptionLoop."'>".$pageOptionLoop."</option>";
    } 
?>

<div class="content-wrapper p-4">
    <div class="card">
        <div class="text-center page-title md-center">
            <b>C M S - A U D I T - L O G S</b>
        </div>

        <div class="box audit_trail_div">
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
                            <table class= "table table-bordered listdata table-bordered ">
                               <thead>
                                    <tr>
                                        <th class = 'center-align-format'>User</th>
                                        <th class = 'center-align-format'>Module</th>
                                        <th class = 'center-align-format'>Action</th>
                                        <th class = 'center-align-format'>Date &amp; Time</th>
                                        <th class = 'center-align-format'>Device IP</th>
                                        <th class = 'center-align-format'>Download Logs</th>
                                        <th class = 'center-align-format'>Remarks</th>
                                        <th class = 'center-align-format'>Action</th>
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
                </div>
        </div>

    </div>
</div>


<script type="text/javascript">
    var query = "id >= 0";
    var limit = 10;
   // var offset = 0;
    $(document).ready(function() {
        get_data(query);
        get_pagination();
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
    
    function get_data(query) {
        var url = "<?= base_url("cms/global_controller");?>";
        var data = {
            event : "list",
            select : "id, user, module, action, remarks, ip_address, link, new_data, old_data, created_at",
            query : query,
            offset : offset,
            limit : limit,
            table : "activity_logs",
            order : {
                field : "created_at", //field to order
                order : "desc" //asc or desc
            }
        }
        
        aJax.post(url,data,(result) => {
            var result = JSON.parse(result);
            var html = '';
            
            if(result) {
                if (result.length > 0) {
                    $.each(result, (x,y) => {
                        html += '<tr>';
                    
                        html += '<td>' + (y.user ?? '-') + '</td>';
                        html += '<td>' + (y.module ?? '-') + '</td>';
                        html += '<td>' + (y.action ?? '-') + '</td>';
                        html += '<td class="center-align-format">' + (y.created_at ? formatReadableDate(y.created_at, true) : '-') + '</td>';
                        html += '<td>' + (y.ip_address ?? '-') + '</td>';
                        html += '<td>' + (y.link ?? '-') + '</td>';
                        html += '<td>' + (y.remarks ?? '-') + '</td>';
                        if(y.new_data != ""){
                            html += '   <td style="width: 50px;"><a class="view_history" href="#" data-id="'+y.id+'"><i class="fa fa-eye"></i></a></td>';
                        } else {
                            html += '   <td style="width: 50px;"></td>';
                        }                        
                        if (parseInt(y.status) === 1) {
                            status = 'Active';
                        }
                        else {
                            status = 'Inactive';
                        }
                        
                        html += '</tr>';
                    });
                }
                else {
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
            table : "activity_logs",
            order : {
                field : "id", //field to order
                order : "asc" //asc or desc
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
    })

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

    $(document).on('keypress', '#search_query', function(e) {                          
        if (e.keyCode === 13) {
            var keyword = $(this).val().trim();
            offset = 1;
            get_data(keyword);
        }
    });

    $(document).on('click', '.view_history', function (e) {
        e.preventDefault();
        modal.loading(true);

        const data_id = $(this).attr("data-id");
        const query = "id = " + data_id;
        const url = "<?= base_url("cms/global_controller"); ?>";

        const data = {
            event: "list",
            select: "id, user, module, action, new_data, old_data, remarks, ip_address, created_at",
            query: query,
            offset: offset,
            limit: limit,
            table: "activity_logs",
            order: {
                field: "created_at",
                order: "desc"
            }
        };

        aJax.post(url, data, (response) => {
            modal.loading(false);
            const result = JSON.parse(response);
            if (!result || result.length === 0) return;

            const entry = result[0];

            const newData = is_json(entry.new_data) ? JSON.parse(entry.new_data) : {};
            let oldData = is_json(entry.old_data) ? JSON.parse(entry.old_data) : {};

            // Fix: If old_data is an array with one object, extract the first object
            if (Array.isArray(oldData) && oldData.length === 1) {
                oldData = oldData[0];
            }

            const allKeys = new Set([...Object.keys(newData), ...Object.keys(oldData)]);

            let html = '<table class="col-md-12 table table-bordered m-t-20"><thead><tr>';
            html += '<th class="center-align-format al-100-px">Field</th>';
            html += '<th class="center-align-format al-370-px">Old Data</th>';
            html += '<th class="center-align-format al-370-px">New Data</th>';
            html += '</tr></thead><tbody>';

            if (allKeys.size > 0) {
                allKeys.forEach(key => {
                    const oldVal = oldData[key] ?? 'No Data';
                    const newVal = newData[key] ?? 'No Data';
                    const changed = oldVal !== newVal;

                    html += '<tr>';
                    html += `<td class="al-100-px">${key}</td>`;
                    html += `<td class="w-370-px">${oldVal}</td>`;
                    html += `<td class="w-370-px ${changed ? 'bg-c7cdfa' : ''}">${newVal}</td>`;
                    html += '</tr>';
                });
            } else {
                html += '<tr><td colspan="3" class="text-center">No changes found</td></tr>';
            }

            html += '</tbody></table>';

            modal.show('<div class="scroll-500">' + html + '</div>', "large", function () { });
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