    <div class="content-wrapper p-4">
        <div class="card">
            <div class="text-center page-title md-center">
                <b>E R R O R - L O G S</b>
            </div>
            <div class="card-body text-center">
                <div class="box">
                    <?php
                        $data['buttons'] = ['fetch', 'close'];
                        echo view("cms/layout/buttons",$data);
                    ?>
                    <div class="box-body">
                            <div class="table-fixed-head">
                                <table class="table table-hover table-bordered">
                                    <colgroup>
                                        <col width="4%">
                                        <col width="9%">
                                        <col width="*">
                                        <col width="9%">
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Level</th>
                                            <th>Message</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table_body"></tbody>
                                </table>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


<script type="text/javascript">
    var limit = 10;
    var offset = 1;

	$(document).ready(function(){
		get_data();

        var date_id = "<?=$uri->getSegment(5);?>";
        $('.date-header').text(moment(date_id).format('LL'));
	});

    pagination.onchange(function() {
        offset = $(this).val();
        get_data();
    });

	function get_data(){
		var url = "<?=base_url('cms/error-logs/error-data');?>";
		var data = { date_id: "<?=$uri->getSegment(4);?>" };

        modal.loading(true);
		aJax.post(url, data, function(result){
			var obj = is_json(result);
            var html = "";
            var counter = 0;
            if(obj.length > 0){
            	counter = obj.length;
                $.each(obj, function(x,y){
                    if($.trim(y[0])){
                        var text = y;
                        var result = text.replace("CRITICAL - ", "");
                        var result = result.replace("INFO - ", "");
                        var result = result.replace("WARNING - ", "");
                        var date_data = result.substr(0, 18);
                        var temp_message = result.split("<br>");
                        var temp_count = temp_message.length-1;
                        var message_content = '';
                        for(var i=0;i<temp_message.length;i++){
                            
                            if(i!=temp_count){
                            message_content += '<li class="list-group-item">'+temp_message[i]+'</li>';
                            }
                        }
                        html += "<tr>";
                            html += "<td>"+counter+"</td>";
                            if(y[0]=='W'){
                                html += "<td>WARNING</td>";
                            }
                            if(y[0]=='I'){
                                html += "<td>INFO</td>";
                            }
                            if(y[0]=='C'){
                                html += "<td>CRITICAL</td>";
                            }
                            html += "<td><ul class='list-group'>"+
                                        message_content
                                            +"</ul></td>";
                            html += "<td>"+moment(date_data).format('LTS')+"</td>";
                        html += "</tr>";
                        counter--;
                    }
                    
                });
            }else{
                html = "<tr><td colspan=3 style='text-align: center;'>No records to show.</td></tr>";
            }

            $('.table_body').html(html);
		});
        modal.loading(false);
	}

    $(document).on('click', '#btn_fetch', function(){
        get_data();
    });

	$(document).on('click', '#btn_close', function(){
		location.href = "<?=base_url('cms/error-logs');?>";
	});

</script>