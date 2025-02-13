    <div class="content-wrapper p-4">
        <div class="card">
            <div class="text-center page-title md-center">
                <b>E R R O R - L O G S</b>
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
                            <table class="table table-hover table-bordered">
                                <colgroup>
                                    <col width="*">
                                    <col width="25%">
                                    <col width="25%">
                                    <col width="9%">
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th>Log Files</th>
                                        <th>Date</th>
                                        <th>No. of Errors</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="table_body word_break"></tbody>
                            </table>
                        </div>
                        <div class="list_pagination"></div>
                        <div class="form-group pull-right">
                            <label>Show</label>
                            <select class="record-entries">
                                <?= $optionSet; ?>
                            </select>
                            <label>Entries</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script type="text/javascript">
    var limit = 10;
    var offset = 1;
    var limit_array = [];
    var cms = '<?= base_url('cms')?>';

    $(document).ready(function(){
        modal.loading(true);
        get_data();
        modal.loading(false);

        <?php if($session->getFlashdata('no_log')) : ?>
            modal.alert("<?=$session->getFlashdata('no_log');?>");
        <?php endif; ?>
    });

    pagination.onchange(function() {
        offset = $(this).val();
        get_pagination();
    });

    $(document).on("change", ".record-entries", function(e) {
        $(".record-entries option").removeAttr("selected");
        $(".record-entries").val($(this).val());
        $(".record-entries option:selected").attr("selected","selected");
        var record_entries = $(this).prop( "selected",true ).val();
        limit = parseInt(record_entries);
        offset = 1;
        get_data();
    });

    function get_data(generated_result = null){
        var offset_array = [];
        var offset_counter = 1;
        var limit_counter = 0;
        var total_counter = 1;
        //var obj = [];
       
        limit_array = [];

        modal.loading(true);
            var data = {
                limit : limit
            };

            aJax.post("<?=base_url('cms/error_logs/get_error_log_files');?>",data, function(result){
                obj = is_json(result);          
           // console.log(obj);
              obj = obj.data;
              console.log(obj);
               var html = "";    
            if (obj) {
                if (obj.length > 0) {
                    $.each(obj, function(x,y){
                        html += "<tr>";
                            html += "<td>"+y.filename+"</td>";
                            html += "<td>"+y.date+"</td>";
                            html += "<td>"+y.lines+"</td>";
                            html += "<td><a href='"+cms+"/error_logs/log/"+y.date_id+"' class='edit'><span class='fa fa-eye'></span></td>";
                        html += "</tr>";  
                    });
                } else {
                    html = '<tr><td colspan=12 class="colspan-no-record">'+ no_records +'</td></tr>';
                }
            }
            console.log(html);
            $('.table_body').html(html);
            
        }, function(result) {
                            var result = JSON.parse(result);
                            if(result) {
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



    $(document).on('click', '#btn_filter', function() {
        var from = $('.start-date').val();
        var to = $('.end-date').val();

        if('' === from && '' === to) {
            get_data();
        } else {
            var format_from = moment(from).format('MMMM DD, Y');
            var format_to = moment(to).format('MMMM DD, Y');

            data = {
                from : format_from,
                to : format_to,
                limit : limit
            };

            aJax.post("<?=base_url('dynamic/error_logs/get_error_log_files_filter');?>",data, function(result){
                var obj = is_json(result);
                var html = "";

                get_data(obj);
            });
            offset = 1;
        }
    });

    $(document).on('click', '#btn_reset', function() {
        $('.start-date').val('');
        $('.end-date').val('');
        offset = 1;
        get_data();
    });
</script>