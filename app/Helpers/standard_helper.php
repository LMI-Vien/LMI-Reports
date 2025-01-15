<?php
	function confirm($config)
	{
        $standard = config('Standard');
		echo json_encode($standard->$config);
    }
    function dialog_return($config){
        $standard = config('Standard');
		echo json_encode($standard->$config);
    }
    function dialog($config)
	{
        $standard = config('Standard');
		echo $standard->$config;
    }
    function details_using_site_id($table,$id)
	{	
		$db = \Config\Database::connect(); 
        $builder = $db->table($table)
                            ->where("site_id", $id);
        $q = $builder->get();
        return $q->getResult();
	}
    function details($table,$id) 
	{	
        $db = \Config\Database::connect(); 
		$builder = $db->table($table)
                            ->where("id", $id);
        $q = $builder->get();
        return $q->getResult();
	}
    function active_list($table, $query = null, $limit = 1, $start = 0, $select = "*", $order_field = null, $order_type = 'asc', $join = null, $group = null)
    {   
		$db = \Config\Database::connect(); 
		
		$builder = $db->table($table);
        $builder->select($select);
        if($query != null){
            $builder->where($query);
        }
        if($join != null){
            foreach ($join as $key => $vl) {
                $builder->join($vl['table'],$vl['query'],$vl['type']);
            };
        }
        if($order_field != null){
            $builder->orderBy($order_field, $order_type);
        }

        if($group != null){
            $builder->groupBy($group);
        }
        $q = $builder->get();
        return $q->getResult();
    }
    function inputs($list,$values=null,$field_inputs=false)
    {

        $input_val = null;
        $standard = config('Standard');
        $element_id = random_string();
        $generated_id = $element_id.time();
        $ctr = 0;
        $data_id = 1;
        if(!$field_inputs){
            echo '<div id="'.$generated_id.'">';
        }

        foreach ($list as $key => $value) {
            if(isset($standard->$value)){
                if ($standard->$value) {
                    if($values != null){
                        $input_val = $values[$key];
                    }
                    if($field_inputs){
                        field_input($standard->$value,$input_val,$ctr, $data_id);
                    }
                    else{
                        input($standard->$value,$input_val);
                    }
                }  else {
                    echo "<b class='invalid-format'>Error : </b><b>" . $value . "</b> not defined in application/config/standard.php file" . "<br>";
                }
            }else{
                echo '<b class="text-danger">ERROR!</b>'.$value;
            }
           
            $ctr++;
            $data_id++;
        }

        if(!$field_inputs){
            echo '<script type="text/javascript" src="' . base_url() . 'cms/js/filemanager_select.js" ></script>';
            echo '</div>';
            return $generated_id;
        }else{
            echo '<input type="hidden" id="counter_length" name="counter_length" value="'.$data_id.'"></input>';
            echo '<input type="hidden" id="counter_attr_length" name="counter_attr_length" value="'.$ctr.'"></input>';
        }

    }
	
    function input($config = null, $value = null)
    {

        $config["value"] = null;
        echo '<!--- ' . $config["id"] . ' --->' . "\n";

        echo '<div class="form-group '.$config['id'].'">';
        if($config != null){
            
            //build input
            switch ($config['type']) {
                case 'separator':
                    echo "<hr>";
                    break;
                case 'text':
                    if($value != null){
                        $config["value"] = $value; 
                    }

                    $label_col = "";
                    $input_col = "";
                    $config['class'] = $config['class'] . " " . $config['id'] .  "_input";

                    if(isset($config["form-align"])){
                        if($config["form-align"] == "horizontal"){
                            $label_col = "col-sm-2";
                            $input_col = "col-sm-10";
                        }
                        unset($config["form-align"]);
                    }

                    if(isset($config["required"])){
                        if($config["required"]){
                            $config['class'] = $config['class'] . " required_input";
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].'<span class="required_fields">*</span> :</label>';
                        } else {
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                        }
                        unset($config["required"]);
                    } else {
                        echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                    }

                    if(isset($config["alphaonly"])){
                        if($config["alphaonly"]){
                            $config['class'] = $config['class'] . " alphaonly";
                        }
                        unset($config["alphaonly"]);
                    }

                    if(isset($config["accept"])){
                        if($config["accept"]){
                            $config['onkeyup'] = "this.value=this.value.replace(".$config["accept"].",'');";
                        }
                        unset($config["alphaonly"]);
                    }


                    if(isset($config["no_html"])){
                        if($config["no_html"]){
                            $config['class'] = $config['class'] . " no_html";
                            
                        }
                        unset($config["no_html"]);
                    }

                    echo '<div class="'.$input_col.'">';
                    echo form_input($config);
                    
                    if(isset($config['note'])){
                        echo "<small class='standard-note'><i> <b>Note:</b> ".ucfirst($config['note'])."</i></small><br>";
                    }

                    
                    if(isset($config['maxlength'])){
                        echo "<small class='standard-max'><i>Maximum character count is ".$config['maxlength'].".</i></small>";
                    }

                    if(isset($config['min_input'])){
                        echo "<small class='standard-min'><i>Minimum value is ".$config['min_input'].".</i></small>";
                    }

                    if(isset($config['max_input'])){
                        echo "<br><small class='standard-max-input'><i>Maximum value is ".$config['max_input'].".</i></small>";
                    }

                    
                    


                    echo '</div>';
                    echo '<div class="clearfix"></div>';

                    break;

                case 'number':
                    if($value != null){
                        $config["value"] = $value; 
                    }

                    $label_col = "";
                    $input_col = "";
                    $config['class'] = $config['class'] . " " . $config['id'] .  "_input";

                    if(isset($config["form-align"])){
                        if($config["form-align"] == "horizontal"){
                            $label_col = "col-sm-2";
                            $input_col = "col-sm-10";
                        }
                        unset($config["form-align"]);
                    }

                    if(isset($config["required"])){
                        if($config["required"]){
                            $config['class'] = $config['class'] . " required_input";
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].'<span class="required_fields">*</span> :</label>';
                        } else {
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                        }
                        unset($config["required"]);
                    } else {
                        echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                    }

                    if(isset($config["alphaonly"])){
                        if($config["alphaonly"]){
                            $config['class'] = $config['class'] . " alphaonly";
                        }
                        unset($config["alphaonly"]);
                    }

                    if(isset($config["accept"])){
                        if($config["accept"]){
                            $config['onkeyup'] = "this.value=this.value.replace(".$config["accept"].",'');";
                        }
                        unset($config["alphaonly"]);
                    }


                    if(isset($config["no_html"])){
                        if($config["no_html"]){
                            $config['class'] = $config['class'] . " no_html";
                            
                        }
                        unset($config["no_html"]);
                    }

                    echo '<div class="'.$input_col.'">';
                    echo form_input($config);
                    
                    if(isset($config['note'])){
                        echo "<small class='standard-note'><i> <b>Note:</b> ".ucfirst($config['note']).".</i></small>";
                    }

                    
                    if(isset($config['maxlength'])){
                        echo "<small class='standard-max'><i>Maximum character count is ".$config['maxlength'].".</i></small>";
                    }

                    if(isset($config['min_input'])){
                        echo "<small class='standard-min'><i>Minimum value is ".$config['min_input'].".</i></small>";
                    }

                    if(isset($config['max_input'])){
                        echo "<br><small class='standard-max-input'><i>Maximum value is ".$config['max_input'].".</i></small>";
                    }

                    
                    


                    echo '</div>';
                    echo '<div class="clearfix"></div>';

                    break;
                
                case 'input-color':
                    if($value != null){
                        $config["value"] = $value; 
                    }else{
                        $config["value"] = '#f00000'; 
                    }

                    $label_col = "";
                    $input_col = "";
                    $config['class'] = $config['class'] . " " . $config['id'] .  "_input";

                    if(isset($config["form-align"])){
                        if($config["form-align"] == "horizontal"){
                            $label_col = "col-sm-2";
                            $color_col = "col-sm-1";
                            $input_col = "col-sm-9";
                        }
                        unset($config["form-align"]);
                    }

                    if(isset($config["required"])){
                        if($config["required"]){
                            $config['class'] = $config['class'] . " required_input";
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].'<span class="required_fields">*</span> :</label>';
                        } else {
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                        }
                        unset($config["required"]);
                    } else {
                        echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                    }

                    if(isset($config["alphaonly"])){
                        if($config["alphaonly"]){
                            $config['class'] = $config['class'] . " alphaonly";
                        }
                        unset($config["alphaonly"]);
                    }

                    if(isset($config["accept"])){
                        if($config["accept"]){
                            $config['onkeyup'] = "this.value=this.value.replace(".$config["accept"].",'');";
                        }
                        unset($config["alphaonly"]);
                    }


                    if(isset($config["no_html"])){
                        if($config["no_html"]){
                            $config['class'] = $config['class'] . " no_html";
                            
                        }
                        unset($config["no_html"]);
                    }

                    echo '<div class="'.$color_col.'">';
                        $triggerSetId = "triggerSet".$config["id"];
                        echo '<input type="text" id="'.$triggerSetId.'" name="'.$triggerSetId.'"/>';
                    echo '</div>';

                    echo '<div class="'.$input_col.'">';
                    echo form_input($config);                    
                    echo "<script>$('#".$triggerSetId."').spectrum({
                            color: '".$config['value']."',
                            showButtons: false
                        });
                    
                        $('#".$triggerSetId."').change(function(){
                            var color_value = $('#".$triggerSetId."').spectrum('get');
                            $('#".$config["id"]."').val(color_value.toHexString());
                        });
                    </script>";
                    echo '</div>';
                    echo '<div class="clearfix"></div>';

                    break;
                
                case 'email':
                    if($value != null){
                        $config["value"] = $value;
                    }

                    $config['class'] = $config['class'] . " email";
                    $config['class'] = $config['class'] . " " . $config['id'] .  "_input no_html";

                    $label_col = "";
                    $input_col = "";

                    if(isset($config["form-align"])){
                        if($config["form-align"] == "horizontal"){
                            $label_col = "col-sm-2";
                            $input_col = "col-sm-10";
                        }
                        unset($config["form-align"]);
                    }

                    if(isset($config["required"])){
                        if($config["required"]){
                            $config['class'] = $config['class'] . " required_input";
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].'<span class="required_fields">*</span> :</label>';
                        } else {
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                        }
                        unset($config["required"]);
                    } else {
                        echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                    }


                    echo '<div class="'.$input_col.'">';
                    echo form_input($config);
                    if(isset($config['note'])){
                        echo "<br><small class='standard-note'><i> <b>Note:</b> ".ucfirst($config['note']).".</i></small>";
                    }
                    if(isset($config['maxlength'])){
                        echo "<small class='standard-max'><i>Maximum character count is ".$config['maxlength'].".</i></small>";
                    }
                    echo '</div>';
                    echo '<div class="clearfix"></div>';
                    break;

                case 'password':


                    if($value != null){
                        $config["value"] = $value;
                    }
                    $config['class'] = $config['class'] . " " . $config['id'] .  "_input no_html";

                    $label_col = "";
                    $input_col = "";


                    if(isset($config["form-align"])){
                        if($config["form-align"] == "horizontal"){
                            $label_col = "col-sm-2";
                            $input_col = "col-sm-10";
                        }
                        unset($config["form-align"]);
                    }

                    if(isset($config["required"])){
                        if($config["required"]){
                            $config['class'] = $config['class'] . " required_input";
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].'<span class="required_fields">*</span> :</label>';
                        } else {
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                        }
                        unset($config["required"]);
                    } else {
                        echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                    }

                    echo '<div class="'.$input_col.'">';
                    echo form_input($config);
                    if(isset($config['note'])){

                        echo "<br><small class='standard-note'><i> <b>Note:</b> ".ucfirst($config['note']).".</i></small>";
                    }
                    echo '</div>';

                    if(isset($config['validated']) && $config['validated'] == true){
                        echo '<label class="control-label col-sm-2"></label>
                            <div class="col-sm-10">
                                <div id="password_chcklist">
                                    <p>Password Must:</p>
                                    <div class="password_chcklist_contanier">
                                        <input type="checkbox"  id="min_ten_chckbx_p" class="min_ten_chckbx password_checkbox required_input hidden"> 
                                       <i class="fas fa-check-square min_ten_chck" ></i> <p class="min_ten_chckbx_p">Minimum of 10 characters and maximum of 40.</p>
                                    </div>
                                    <div class="password_chcklist_contanier">
                                        <input type="checkbox" id="special_chckbx_p" class="special_chckbx password_checkbox required_input hidden"> 
                                      <i class="fas fa-check-square special_chck"></i> <p class="special_chckbx_p">Atleast 1 Special Characters</p>
                                    </div>
                                    <div class="password_chcklist_contanier">
                                        <input type="checkbox" id="upper_chckbx_p" class="upper_chckbx password_checkbox required_input hidden"> 
                                      <i class="fas fa-check-square upper_chck"></i> <p class="upper_chckbx_p">Atleast 1 Uppercase</p>
                                    </div>
                                    <div class="password_chcklist_contanier">
                                        <input type="checkbox" id="number_chckbx_p" class="number_chckbx password_checkbox required_input hidden"> 
                                      <i class="fas fa-check-square number_chck"></i> <p class="number_chckbx_p">Atleast 1 Number</p>
                                    </div>
                                 </div>
                            </div>';
                    }

                    echo '<div class="clearfix"></div>';
                    break;
                
                case 'dropdown':
                    $set_value ="";
                    if($value != null){
                        $set_value = $value;
                    }
                    $config['class'] = $config['class'] . " " . $config['id'] .  "_input no_html";

                    $label_col = "";
                    $input_col = "";

                    if(isset($config["form-align"])){
                        if($config["form-align"] == "horizontal"){
                            $label_col = "col-sm-2";
                            $input_col = "col-sm-10";
                        }
                        unset($config["form-align"]);
                    }

                    if(isset($config["required"])){
                        if($config["required"]){
                            $config['class'] = $config['class'] . " required_input";
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].'<span class="required_fields">*</span> :</label>';
                        } else {
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                        }
                        unset($config["required"]);
                    } else {
                        echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                    }

                    if(isset($config["list_value"])){
                        $list_value = $config['list_value'];
                    } else {
                        $list_value = array(''=>"");
                    }                    
                    
                    unset($config['list_value']);

                    echo '<div class="'.$input_col.'">';
                    echo form_dropdown($config['name'], $list_value, $set_value, $config);
                    if(isset($config['note'])){
                        echo "<small class='standard-note'><i> <b>Note:</b> ".ucfirst($config['note'])."</i></small>";
                    }
                    echo '</div>';
                    echo '<div class="clearfix"></div>';
                    break;
                
                case 'radio':
                    $set_value ="";
                    if($value != null){
                        $set_value = $value;
                    }
                    $config['class'] = $config['class'] . " " . $config['id'] .  "_input no_html";

                    $label_col = "";
                    $input_col = "";

                    if(isset($config["form-align"])){
                        if($config["form-align"] == "horizontal"){
                            $label_col = "col-sm-2";
                            $input_col = "col-sm-10";
                        }
                        unset($config["form-align"]);
                    }

                    if(isset($config["required"])){
                        if($config["required"]){
                            $config['class'] = $config['class'] . " required_input";
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].'<span class="required_fields">*</span> :</label>';
                        } else {
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                        }
                        unset($config["required"]);
                    } else {
                        echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                    }

                    
                    $list_value = $config['list_value'];
                    unset($config['list_value']);

                    echo '<div class="'.$input_col.'">';
                    foreach ($list_value as $k => $v) {
                        $is_checked = false;
                        if($k == $set_value){
                            $is_checked = true;
                        }
                        echo '<div class="radio-inline">';
                        echo '  <span>' . form_radio($config['name'], $k, $is_checked, $config) . " " . $v . '</span>';
                        echo '</div>';
                    }
                    if(isset($config['note'])){
                        echo "<br><small class='standard-note'><i> <b>Note:</b> ".ucfirst($config['note']).".</i></small>";
                    }
                    echo '</div>';
                    echo '<div class="clearfix"></div>';
                    break;

                case 'checkbox':
                    $set_value ="";
                    if($value != null){
                        $set_value = $value;
                    }
                    $config['class'] = $config['class'] . " " . $config['id'] .  "_input no_html";

                    $label_col = "";
                    $input_col = "";

                    if(isset($config["form-align"])){
                        if($config["form-align"] == "horizontal"){
                            $label_col = "col-sm-2";
                            $input_col = "col-sm-10";
                        }
                        unset($config["form-align"]);
                    }

                    if(isset($config["required"])){
                        if($config["required"]){
                            $config['class'] = $config['class'] . " required_input";
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].'<span class="required_fields">*</span> :</label>';
                        } else {
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                        }
                        unset($config["required"]);
                    } else {
                        echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                    }

                    
                    $list_value = $config['list_value'];
                    unset($config['list_value']);

                    echo '<div class="'.$input_col.'">';
                    foreach ($list_value as $k => $v) {
                        $is_checked = false;
                        if($k == $set_value){
                            $is_checked = true;
                        }
                        echo '<div class="radio-inline">';
                        echo '  <span>' . form_checkbox($config['name'], $k, $is_checked, $config) . " " . $v . '</span>';
                        echo '</div>';
                    }
                    if(isset($config['note'])){
                        echo "<br><small class='standard-note'><i> <b>Note:</b> ".ucfirst($config['note']).".</i></small>";
                    }
                    echo '</div>';
                    echo '<div class="clearfix"></div>';
                    break;

                case 'textarea':
                    if($value != null){
                        $config["value"] = $value;
                    }
                    $config['class'] = $config['class'] . " " . $config['id'] .  "_input no_html";

                    $label_col = "";
                    $input_col = "";

                    if(isset($config["form-align"])){
                        if($config["form-align"] == "horizontal"){
                            $label_col = "col-sm-2";
                            $input_col = "col-sm-10 ".$config['id'];
                        }
                        unset($config["form-align"]);
                    }

                    if(isset($config["required"])){
                        if($config["required"]){
                            $config['class'] = $config['class'] . " required_input";
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].'<span class="required_fields">*</span> :</label>';
                        } else {
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                        }
                        unset($config["required"]);
                    } else {
                        echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                    }

                    if(isset($config["alphaonly"])){
                        if($config["alphaonly"]){
                            $config['class'] = $config['class'] . " alphaonly";
                        }
                        unset($config["alphaonly"]);
                    }

                    if(isset($config["no_html"])){
                        if($config["no_html"]){
                            $config['class'] = $config['class'] . " no_html";
                        }
                        unset($config["no_html"]);
                    }

                    echo '<div class="'.$input_col.'">';
                    echo form_textarea($config);



                    if(isset($config['maxlength'])){
                        echo "<small class='standard-max'><i>Maximum character count is ".$config['maxlength'].".</i></small>";
                    }



                    if(isset($config['note'])){
                        echo "<br><small class='standard-note'><i> <b>Note:</b> ".ucfirst($config['note']).".</i></small>";
                    }

                    echo '</div>';
                    echo '<div class="clearfix"></div>';
                    break;  

                case 'date':
                    if($value != null){
                        $config["value"] = $value;
                    }
                    $config['class'] = $config['class'] . " " . $config['id'] .  "_input no_html";

                    $label_col = "";
                    $input_col = "";

                    if(isset($config["form-align"])){
                        if($config["form-align"] == "horizontal"){
                            $label_col = "col-sm-2";
                            $input_col = "col-sm-10";
                        }
                        unset($config["form-align"]);
                    }

                    $config['type'] = "text";
                    if(isset($config["required"])){
                        if($config["required"]){
                            $config['class'] = $config['class'] . " required_input";
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].'<span class="required_fields">*</span> :</label>';
                        } else {
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                        }
                        unset($config["required"]);
                    } else {
                        echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                    }

                    echo '<div class="'.$input_col.'">';
                    
                    echo form_input($config);

                    echo "<script>$('#".$config['id']."').materialDatePicker({time : false,weekStart : 0,clearButton : true});$(document).on('cut copy paste input', '#".$config['id']."', function(e) {e.preventDefault();});</script>";
                    if(isset($config['note'])){
                        echo "<small class='standard-note'><i> <b>Note:</b> ".ucfirst($config['note']).".</i></small>";
                    }

                    echo '</div>';
                    echo '<div class="clearfix"></div>';
                    break;  

                case 'timepicker':
                    if($value != null){
                        $config["value"] = $value;
                    }

                    $config['class'] = $config['class'] . " " . $config['id'] .  "_input no_html";

                    $label_col = "";
                    $input_col = "";

                    if(isset($config["form-align"])){
                        if($config["form-align"] == "horizontal"){
                            $label_col = "col-sm-2";
                            $input_col = "col-sm-10";
                        }
                        unset($config["form-align"]);
                    }

                    $config['type'] = "text";
                    if(isset($config["required"])){
                        if($config["required"]){
                            $config['class'] = $config['class'] . " required_input";
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].'<span class="required_fields">*</span> :</label>';
                        } else {
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                        }
                        unset($config["required"]);
                    } else {
                        echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                    }

                    echo '<div class="'.$input_col.'">';
                    
                    echo form_input($config);
                    echo "<script>$('#".$config['id']."').materialDatePicker({date : false});$(document).on('cut copy paste input', '#".$config['id']."', function(e) {e.preventDefault();});</script>";
                    if(isset($config['note'])){
                        echo "<small class='standard-note'><i> <b>Note:</b> ".ucfirst($config['note']).".</i></small>";
                    }

                    echo '</div>';
                    echo '<div class="clearfix"></div>';
                    break;   

                case 'filemanager':
                    if($value != null){
                        $config["value"] = $value;
                    } else {
                        $config["value"] = "";
                    }

                    $config['class'] = $config['class'] . " " . $config['id'] .  "_input no_html";

                    $label_col = "";
                    $input_col = "";

                    if(isset($config["form-align"])){
                        if($config["form-align"] == "horizontal"){
                            $label_col = "col-sm-2";
                            $input_col = "col-sm-10";
                        }
                        unset($config["form-align"]);
                    }

                    $config['type'] = "text";
                    if(isset($config["required"])){
                        if($config["required"]){
                            $config['class'] = $config['class'] . " required_input";
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].'<span class="required_fields">*</span> :</label>';
                        } else {
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                        }
                    } else {
                        echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                    }

                    $is_required = "";
                    if(isset($config["required"])){
                        if($config["required"]){
                            $is_required = "required_input";
                        }
                    }

                    $filter = "";
                    $accept = "";
                    if(isset($config["accept"])){
                        if($config["accept"]){
                            $filter = "ext_filter";
                            $accept = $config["accept"];
                        }
                    }


                    $max_size_class = "";
                    $max_size = "";
                    if(isset($config["max_size"])){
                        if($config["max_size"]){
                            $max_size_class = "size_filter";
                            $max_size = $config["max_size"];
                        }
                    }

                    unset($config["required"]);
                    echo '<div class="'.$input_col.'">';
                    echo '<div class="input-group '.$config['id'].'"> ';
                    echo '  <input id="'.$config['id'].'" class="form-control '.$is_required.' ' . $filter . ' ' . $max_size_class . ' ' . $config["class"] . '" readonly value="'.$config["value"].'" accept="'.$accept.'" name="'.$config['name'].'" max_size="'.$max_size.'" />';
                    echo '      <span class="input-group-btn" style="vertical-align: top;">';
                    echo '          <button type="button" data-id="'.$config['id'].'" class="file_manager_'.$config['id'].' btn btn-info btn-flat">Open File Manager</button>';
                    echo '      </span>';
                    echo '  </div>';                   

                    //put preview here
                    if($config["value"] != ""){
                        $ext = pathinfo($config["value"], PATHINFO_EXTENSION);
                        switch ($ext) {
                            case 'jpg':
                            case 'jpeg':
                            case 'gif':
                            case 'png':
                            case 'webp':
                                echo '<img class="img_banner_preview" src="'. base_url() . $config["value"].'" width="25%" />';
                                break;

                            case 'mp4':
                                echo '<video class="img_banner_preview" style="width : 25%" controls>';
                                echo '  <source src="' . base_url() . $config["value"].'" type="video/mp4"';
                                echo '  Your browser does not support HTML5 video.';
                                echo '</video>';
                                break;
                            
                            default:
                                echo '<span class="img_banner_preview"></span>';
                                break;
                        }
                    }


                    if(isset($config['max_size'])){
                        if($config['max_size'] != ""){
                            echo "<br><i> <b>Max Size : </b> ".strtoupper($config['max_size'])."MB.</i><br>";
                        }
                    }

                    if(isset($config['accept'])){
                        if($config['accept'] != ""){
                            echo "<br><i> <b>Accept : </b> ".strtoupper($config['accept']).".</i><br>";
                        }
                    }

                    if(isset($config['note'])){
                        
                        echo "<small class='standard-note'><i> <b>Note:</b> ".ucfirst($config['note']).".</i></small>";
                    }

                    echo '</div>';

                    
                    echo '<script>';
                    echo "  $(document).on('click', '.file_manager_".$config['id']."', function(e){";
                    echo '      var data_id ="'.$config['id'].'";';
                    echo '      modal.file_manager(data_id);';
                    echo '  });';
                    echo '</script>';

                    echo '<div class="clearfix"></div>';
                    break;         

                case 'ckeditor_modal':
                    $remove_plugin = "";
                    if($value != null){
                        $config["value"] = $value;
                    }

                    $config['class'] = $config['class'] . " " . $config['id'] .  "_input no_html";

                    $config['class'] = $config['class'] . " ckeditor_input_modal";

                    $label_col = "";
                    $input_col = "";

                    if(isset($config["form-align"])){
                        if($config["form-align"] == "horizontal"){
                            $label_col = "col-sm-2";
                            $input_col = "col-sm-10";
                        }
                        unset($config["form-align"]);
                    }


                    if(isset($config["required"])){
                        if($config["required"]){
                            $config['class'] = $config['class'] . " required_input";
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].'<span class="required_fields">*</span> :</label>';
                        } else {
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                        }
                        unset($config["required"]);
                    } else {
                        echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                    }

                    echo '<div class="'.$input_col.'">';
                    echo form_textarea($config);
                    if(isset($config["youtube"])){
                        if($config["youtube"] == false){
                            $remove_plugin .= "youtube,";
                        } 
                    }

                    if(isset($config["filemanager"])){
                        if($config["filemanager"] == false){
                            $remove_plugin .= "filemanager,";
                        } 
                    }
                    if(isset($config["list_style"])){
                        if($config["list_style"] == false){
                            $remove_plugin .= "list,";
                        } 
                    }

                    if(isset($config["source"])){
                        if($config["source"] == false){
                            $remove_plugin .= "sourcearea,";
                        } 
                    } 

                    echo '<script>CKEDITOR.replace("'.$config['id'].'",{extraPlugins: "filemanager, youtube",height: "500px", removePlugins : "'.$remove_plugin.'", allowedContent: true, extraAllowedContent : "*(*)"});</script>';
                    echo '<script>CKEDITOR.instances.'.$config['id'].'.on("change", function() { $("#'.$config['id'].'").val(CKEDITOR.instances.'.$config['id'].'.getData().replace(/(<([^>]+)>)/ig,"")); });</script>';
                        


                    if(isset($config['note'])){
                        echo "<br><small class='standard-note'><i> <b>Note:</b> ".ucfirst($config['note']).".</i></small>";
                    }

                    echo '</div>';
                    echo '<div class="clearfix"></div>';
                    break; 
                
                    case 'ckeditor_email':
                    $remove_plugin = "";
                    if($value != null){
                        $config["value"] = $value;
                    }

                    $config['class'] = $config['class'] . " " . $config['id'] .  "_input no_html";

                    $config['class'] = $config['class'] . " ckeditor_input_modal";

                    $label_col = "";
                    $input_col = "";

                    if(isset($config["form-align"])){
                        if($config["form-align"] == "horizontal"){
                            $label_col = "col-sm-2";
                            $input_col = "col-sm-10";
                        }
                        unset($config["form-align"]);
                    }


                    if(isset($config["required"])){
                        if($config["required"]){
                            $config['class'] = $config['class'] . " required_input";
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].'<span class="required_fields">*</span> :</label>';
                        } else {
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                        }
                        unset($config["required"]);
                    } else {
                        echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                    }

                    echo '<div class="'.$input_col.'">';
                    echo '<div class="editor">
                                <div type="ckeditor_email" class="'.$config['class'].'" cols="40" id="'.$config['id'].'" name="'.$config['id'].'" rows="30" data-sample-short contenteditable="true"></div>
                            </div>';
                    if(isset($config["youtube"])){
                        if($config["youtube"] == false){
                            $remove_plugin .= "youtube,";
                        } 
                    }

                    if(isset($config["filemanager"])){
                        if($config["filemanager"] == false){
                            $remove_plugin .= "filemanager,";
                        } 
                    }
                    if(isset($config["list_style"])){
                        if($config["list_style"] == false){
                            $remove_plugin .= "list,";
                        } 
                    }

                    if(isset($config["source"])){
                        if($config["source"] == false){
                            $remove_plugin .= "sourcearea,";
                        } 
                    } 
                    
                    if(isset($config['note'])){
                        echo "<br><small class='standard-note'><i> <b>Note:</b> ".ucfirst($config['note']).".</i></small>";
                    }

                    echo '</div>';
                    echo '<div class="clearfix"></div>';
                    break; 
                
                case 'ckeditor':
                    $remove_plugin = "";
                    if($value != null){
                        $config["value"] = $value;
                    }

                    $config['class'] = $config['class'] . " " . $config['id'] .  "_input no_html";

                    $config['class'] = $config['class'] . " ckeditor_input";

                    $label_col = "";
                    $input_col = "";

                    if(isset($config["form-align"])){
                        if($config["form-align"] == "horizontal"){
                            $label_col = "col-sm-2";
                            $input_col = "col-sm-10 ".$config['id'];
                        }
                        unset($config["form-align"]);
                    }


                    if(isset($config["required"])){
                        if($config["required"]){
                            $config['class'] = $config['class'] . " required_input";
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].'<span class="required_fields">*</span> :</label>';
                        } else {
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                        }
                        unset($config["required"]);
                    } else {
                        echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                    }

                    echo '<div class="'.$input_col.'">';
                    echo form_textarea($config);
                    if(isset($config["youtube"])){
                        if($config["youtube"] == false){
                            $remove_plugin .= "youtube,";
                        } 
                    }

                    if(isset($config["filemanager"])){
                        if($config["filemanager"] == false){
                            $remove_plugin .= "filemanager,";
                        } 
                    }
                    if(isset($config["list_style"])){
                        if($config["list_style"] == false){
                            $remove_plugin .= "list,";
                        } 
                    }

                    if(isset($config["source"])){
                        if($config["source"] == false){
                            $remove_plugin .= "sourcearea,";
                        } 
                    } 

                    echo '<script>CKEDITOR.replace("'.$config['id'].'",{extraPlugins: "filemanager, youtube",height: "500px", removePlugins : "'.$remove_plugin.'", allowedContent: true, extraAllowedContent : "*(*)"});</script>';
                    echo '<script>CKEDITOR.instances.'.$config['id'].'.on("change", function() { $("#'.$config['id'].'").val(CKEDITOR.instances.'.$config['id'].'.getData().replace(/(<([^>]+)>)/ig,"")); });</script>';
                        


                    if(isset($config['note'])){
                        echo "<br><small class='standard-note'><i> <b>Note:</b> ".ucfirst($config['note']).".</i></small>";
                    }

                    echo '</div>';
                    echo '<div class="clearfix"></div>';
                    break; 

                case 'mobile_number':
                    if($value != null){
                        $config["value"] = $value; 
                    }

                    $config['class'] = $config['class'] . " " . $config['id'] .  "_input no_html";

                    $label_col = "";
                    $input_col = "";

                    if(isset($config["form-align"])){
                        if($config["form-align"] == "horizontal"){
                            $label_col = "col-sm-2";
                            $input_col = "col-sm-10";
                        }
                        unset($config["form-align"]);
                    }

                    if(isset($config["required"])){
                        if($config["required"]){
                            $config['class'] = $config['class'] . " required_input";
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].'<span class="required_fields">*</span> :</label>';
                        } else {
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                        }
                        unset($config["required"]);
                    } else {
                        echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                    }

                    echo '<div class="'.$input_col.'">';
                    $config['class'] = $config['class'] . " mobile_number";

                    $config['onkeyup'] = "this.value=this.value.replace(/[^0-9]/g,'');";

                    echo form_input($config);
                    
                    if(isset($config['note'])){
                        echo "<small class='standard-note'><i> <b>Note:</b> ".ucfirst($config['note']).".</i></small>";
                    }

                    echo '</div>';
                    echo '<div class="clearfix"></div>';

                    break;
                
                case 'youtube':
                    if($value != null){
                        $config["value"] = $value;
                    } else {
                        $config["value"] = "";
                    }

                    $config['class'] = $config['class'] . " " . $config['id'] .  "_input no_html";

                    $label_col = "";
                    $input_col = "";

                    if(isset($config["form-align"])){
                        if($config["form-align"] == "horizontal"){
                            $label_col = "col-sm-2";
                            $input_col = "col-sm-10";
                        }
                        unset($config["form-align"]);
                    }

                    $config['type'] = "text";
                    if(isset($config["required"])){
                        if($config["required"]){
                            $config['class'] = $config['class'] . " required_input";
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].'<span class="required_fields">*</span> :</label>';
                        } else {
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                        }
                        
                    } else {
                        echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                    }

                    $is_required = "";
                    if(isset($config["required"])){
                        if($config["required"]){
                            $is_required = "required_input";
                        }
                        unset($config["required"]);
                    }

                    unset($config["required"]);
                    echo '<div class="'.$input_col.'">';
                    echo '<div class="input-group '.$config['id'].'"> ';
                    echo '  <input id="'.$config['id'].'" class="form-control '.$is_required.'" readonly value="'.$config["value"].'"/>';
                    echo '      <span class="input-group-btn">';
                    echo '          <button type="button" data-id="'.$config['id'].'" class="youtube_'.$config['id'].' btn btn-danger btn-flat">Add Youtube Link</button>';
                    echo '      </span>';
                    echo '  </div>';

                    echo '</div>';

                    echo '<script>';
                    echo "  $(document).on('click', '.youtube_".$config['id']."', function(e){";
                    echo '      var data_id ="'.$config['id'].'";';
                    echo '      modal.youtube(data_id);';
                    echo '  });';
                    echo '</script>';

                    echo '<div class="clearfix"></div>';
                    break;  


                case 'captcha':
                    if($value != null){
                        $config["value"] = $value; 
                    }

                    $label_col = "";
                    $input_col = "";
                    $config['class'] = $config['class'] . " " . $config['id'] .  "_input captcha_ci";

                    if(isset($config["form-align"])){
                        if($config["form-align"] == "horizontal"){
                            $label_col = "col-sm-2";
                            $input_col = "col-sm-10";
                        }
                        unset($config["form-align"]);
                    }

                    if(isset($config["required"])){
                        if($config["required"]){
                            $config['class'] = $config['class'] . " required_input";
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].'<span class="required_fields">*</span> :</label>';
                        } else {
                            echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                        }
                        
                    } else {
                        echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                    }

                    //checking if recaptcha
                    if(isset($config['captcha'])){
                        if($config['captcha'] == "codeigniter"){
                            $is_required = "";
                            if(isset($config["required"])){
                                if($config["required"]){
                                    $is_required = "required_input";
                                }
                            }
                            unset($config["required"]);
                            echo '<div class="'.$input_col.'">';
                            echo '  <div class="captcha_ci_image"></div>';
                            echo '  <div class="input-group '.$config['id'].'" style="max-width: 300px; margin-top: 5px;"> ';
                            echo '      <input id="'.$config['id'].'" class="form-control '.$is_required.' captcha_ci captcha_ci_input" placeholder="'.$config['placeholder'].'" value="'.$config["value"].'"/>';
                            echo '      <span class="input-group-btn">';
                            echo '          <button type="button" data-id="'.$config['id'].'" class="captcha_ci_refresh '.$config['id'].' btn btn-warning btn-flat"><i class="fa fa-refresh" aria-hidden="true"></i></button>';
                            echo '      </span>';
                            echo '  </div>';
                            echo '</div>';
                            echo '<div class="clearfix"></div>';

                            echo '<script>';
                            echo '      $(document).ready(function(){';
                            echo '          var url ="' . base_url("dynamic/global_controller/captcha_ci") . '";';
                            echo '          aJax.get(url,function(result){';
                            echo '              var obj = isJson(result);';
                            echo '              $(".captcha_ci_input").attr("cpt-val",obj.cpt_val);';
                            echo '              $(".captcha_ci_image").html(obj.cpt_image);';
                            echo '          });';
                            echo '      });';
                            echo '      $(document).on("click",".captcha_ci_refresh", function(e){';
                            echo '          var url ="' . base_url("dynamic/global_controller/captcha_ci") . '";';
                            echo '          aJax.get(url,function(result){';
                            echo '              var obj = isJson(result);';
                            echo '              $(".captcha_ci_input").attr("cpt-val",obj.cpt_val);';
                            echo '              $(".captcha_ci_image").html(obj.cpt_image);';
                            echo '          });';
                            echo '      });';
                            echo '</script>';
                        }

                        if($config['captcha'] == "google"){
                            $site_key = "6Lf8i2cUAAAAACaKQohJ3nFyBCGHMmDVQBK4sjVK";
                            if(isset($config['site_key'])){
                                $site_key = $config['site_key'];
                            }
                            echo '<div class="'.$input_col.'">';
                            echo '<div class="g-recaptcha" data-sitekey="'.$site_key.'"></div>';
                            echo '</div>';
                            echo '<div class="clearfix"></div>';
                        }
                    } else {
                        echo "CAPTCHA IS NOT SET IN STANDARD CONFIG";
                    }
                    break;
                
                case 'table':
                    $config['class'] = $config['class'] . " " . $config['id'] .  "_input no_html";

                    $label_col = "";
                    $input_col = "";

                    if(isset($config["form-align"])){
                        if($config["form-align"] == "horizontal"){
                            $label_col = "col-sm-2";
                            $input_col = "col-sm-10";
                        }
                        unset($config["form-align"]);
                    }

                    echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                    echo '<div class="'.$input_col.'">';
                    echo form_table($config);

                    echo '</div>';
                    echo '<div class="clearfix"></div>';
                    break;   
                
                case 'table_template':
                    $config['class'] = $config['class'] . " " . $config['id'] .  "_input no_html";

                    $label_col = "";
                    $input_col = "";

                    if(isset($config["form-align"])){
                        if($config["form-align"] == "horizontal"){
                            $label_col = "col-sm-2";
                            $input_col = "col-sm-10";
                        }
                        unset($config["form-align"]);
                    }

                    echo '<label class="control-label '.$config['id'].'_label '.$label_col.'">'.$config['label'].':</label>';
                    echo '<div class="'.$input_col.'">';
                    echo form_table_template($config);

                    echo '</div>';
                    echo '<div class="clearfix"></div>';
                    break;   
                default:
                    # code...
                    break;
            }
    
            echo '</div>'  ."\n\n";
        } else {
            echo "Error : Input config not defined.";
        }
    }
    function field_input($config = null, $value = null, $ctr=null, $data_id = null){
    
      
        if($config != null){
            //Initialize properties that are not defined in standard.php
            if(!isset($config['note'])){$config['note'] = '';}
            if(!isset($config['type'])){$config['type'] = '';}
            if(!isset($config['label'])){$config['label'] = '';}
            if(!isset($config['required'])){$config['required'] = '';}
            if(!isset($config['name'])){$config['name'] = '';}
            if(!isset($config['id'])){$config['id'] = '';}
            if(!isset($config['class'])){$config['class'] = '';}
            if(!isset($config['placeholder'])){$config['placeholder'] = '';}
            if(!isset($config['note'])){$config['note'] = '';}
            if(!isset($config['maxlength'])){$config['maxlength'] = '';}
            if(!isset($config['is_list'])){$config['is_list'] = "0";}
            if(!isset($config['alignment'])){$config['alignment'] = "0";}

            $datatypes = array("char", "varchar", "text", "blob", "int", "big int", "float", "double", "decimal", "datetime", "timestamp");

            echo '<div class="panel-settings" data-panel="'.$data_id.'">';
                echo '<div class="panel panel-default">';
                    echo '<div class = "panel-heading">';
                        echo '<span class="o_title" name="selected_pckg_'.$data_id.'" value="'.$config['label'].'">'.$config['label'].'</span>';
                        echo '<input type"hidden" class="form-control o_title hidden" name="selected_pckg_'.$data_id.'" value="'.$config['label'].'"></input>';
                        echo '<i class="glyphicon glyphicon-remove pull-right cp-remove-btn" data-id="'.$data_id.'" title="Remove"></i>';
                        echo '<i class="glyphicon glyphicon-edit pull-right cp-settings-btn" data-id="'.$data_id.'" title="Edit"></i>';
                        echo '<i class="glyphicon glyphicon-chevron-up pull-right up" data-id="'.$data_id.'" title="Move Up"></i>';
                        echo '<i class="glyphicon glyphicon-chevron-down pull-right down" data-id="'.$data_id.'" title="Move Up"></i>';
                        echo '';
                    echo '</div>';
                    echo '<div class = "panel-body">';
                        echo '<div class="cp-settings settings-opt" data-panel="'.$data_id.'">';
                            echo '<div class="form-group">';
                                echo '<label class = "control-label col-md-3">Data Type</label>';
                                echo '<div class="col-md-9">';
                                    echo '<select class="form-control" disabled name="datatype_'.$ctr.'">';
                                            foreach($datatypes AS $datatype){
                                                if($datatype === $config['type']){
                                                    echo '<option value="'.$datatype.'" selected>'.ucwords($datatype).'</option>';
                                                }
                                                else{
                                                    echo '<option value="'.$datatype.'">'.ucwords($datatype).'</option>';
                                                }
                                            }
                                        echo '</select>';
                                    echo '<input type="hidden" name="databuilder_'.$ctr.'" class="input_databuilder_'.$ctr.'" value="1" />';
                                echo '</div>';
                            echo '</div>';
                            
                            echo '<div class="form-group">';
                                echo '<label class = "control-label col-md-3">Required</label>';
                                echo '<div class="col-md-9">';
                                    echo '<select class="form-control" disabled name="required_'.$ctr.'">';
                                           if(0 === $config['required']){
                                                echo '<option value="0" selected>No</option>';
                                           }else{
                                                echo '<option value="1" selected>Yes</option>';
                                           }
                                    echo '</select>';
                                echo '</div>';
                            echo '</div>';
                           
                            echo '<div class="form-group">';
                                echo '<label class = "control-label col-md-3">Label<span class="required_fields">*</span></label>';
                                echo '<div class="col-md-9">';
                                    echo '<input type="text" disabled class="form-control input_label0 requ" name="label_'.$config['name'].'" placeholder="Enter Label" value="'.$config['label'].'"/>';
                                echo '</div>';
                            echo '</div>';
                           
                            echo '<div class="form-group">';
                            echo '<label class = "control-label col-md-3">Name<span class="required_fields">*</span></label>';
                                echo '<div class="col-md-9">';
                                    echo '<input type="textbox" disabled class="form-control input_name'.$ctr.' requ" name="name_'.$config['name'].'" placeholder="Enter Name" value="'.$config['name'].'"/>';
                                echo '</div>';
                            echo '</div>';
                            
                            echo '<div class="form-group">';
                                echo '<label class = "control-label col-md-3">ID<span class="required_fields">*</span></label>';
                                echo '<div class="col-md-9">';
                                    echo '<input type="text" disabled class="form-control input_id'.$ctr.' requ" name="id_'.$config['name'].' placeholder="Enter ID" value="'.$config['id'].'"/>';
                                echo '</div>';
                            echo '</div>';
                            
                            echo '<div class="form-group">';
                                echo '<label class = "control-label col-md-3">Class<span class="required_fields">*</span></label>';
                                echo '<div class="col-md-9">';
                                    echo '<input type="text" disabled class="form-control input_class'.$ctr.' requ" name="class_'.$config['name'].'" placeholder="Enter Class" value="'.$config['class'].'"/>';
                                echo '</div>';
                            echo '</div>';

                            echo '<div class="form-group">';
                                echo '<label class = "control-label col-md-3">Placeholder</label>';
                                echo '<div class="col-md-9">';
                                    echo '<input type="text" disabled class="form-control input_placeholder'.$ctr.'" name="placeholder_'.$config['name'].'" placeholder="Enter Placeholder" value="'.$config['placeholder'].'"/>';
                                echo '</div>';
                            echo '</div>';

                            echo '<div class="form-group">';
                            echo '<label class = "control-label col-md-3">Max Length</label>';
                            echo '<div class="col-md-9">'; 
                                echo '<input type="number" disabled class="form-control input_maxlength'.$ctr.'" name="maxlength_'.$config['name'].'" min="0" onkeypress="check_max_length_input(0)" onpaste="return false;" placeholder="Enter Maxlength" value="'.$config['maxlength'].'"/>';
                            echo '</div>';
                            echo '</div>';

                            echo '<div class="form-group">';
                                echo '<label class = "control-label col-md-3">Notes</label>';
                                echo '<div class="col-md-9">';
                                    echo '<input type="text" disabled class="form-control input_notes'.$ctr.'" name="note_'.$config['name'].'" placeholder="Enter Notes" value="'.$config['note'].'"/>';
                                echo '</div>';
                            echo '</div>';
                             echo '<div class="form-group">';
                                echo '<label class = "control-label col-md-3">Alignment</label>';
                                echo '<div class="col-md-9">';
                                    echo '<select class="form-control" name="alignment_'.$ctr.'" disabled>';
                                        if("0" === $config['alignment']){
                                            echo '<option value="0" selected>Not Center</option>';
                                        }else{
                                            echo '<option value="1">Center</option>';
                                        }
                                    echo '</select>';
                                echo '</div>';
                            echo '</div>';
                            echo '<div class="form-group">';
                                echo '<label class = "control-label col-md-3">Will show in list?</label>';
                                echo '<div class="col-md-9">';
                                    echo '<select class="form-control" name="is_list_'.$ctr.'" disabled>';
                                        if("0" === $config['is_list']){
                                            echo '<option value="0" selected>No</option>';
                                        }else{
                                            echo '<option value="1">Yes</option>';
                                        }
                                    echo '</select>';
                                echo '</div>';
                            echo '</div>';
                           
                        echo '</div>';
                       
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
        else{
            echo "Error : Input config not defined.";
        }
    }
     function canonical_common()
    {
        $str  = '<link rel="canonical" href="'.str_replace('index.php/','', current_url()).'" />';
        $str .= '';
        $str .= canonical_hreflang(current_url());

        return $str;
    }

     function canonical_br()
    {
        $str = '
	';
        return $str; 
    }

     function canonical_hreflang($url)
    {
        $str  = '<link rel="alternate" hreflang="en-PH" href="'.str_replace('index.php/','', $url).'" />
    ';
        $str .= '<link rel="alternate" hreflang="tl-PH" href="'.str_replace('index.php/','', $url).'" />';
        return $str;
    }
    function cookie_notification(){
        $db = \Config\Database::connect(); 

        $builder = $db->table('site_information')
                            ->select('site_cookie_notif_message')
                            ->where('id', 1);
        $query  = $builder->get();
        $result = $query->getResult();
        echo $result[0]->site_cookie_notif_message;


    }
    function is_cookie_id_existing($cookie_id){
        $db = \Config\Database::connect(); 
        $builder = $db->table("site_search_keywords");
        $builder->distinct();
        $builder->select("cookie_id");
        $builder->where("cookie_id", $cookie_id);
        $query  = $builder->get();
        $result = $query->getResult();
        
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }
    function get_pixel_urls($url) {
        $db = \Config\Database::connect(); 
        $builder = $db->table("site_url_pixel_list");
        $builder->select("content");
        $builder->where("url", $url);
         $q =$builder->get();
         return $q->getRow();
     }
     function get_corporate_social() {
        $db = \Config\Database::connect(); 
        $builder = $db->table("site_information");
        $select = "site_fb_link as fb_link, site_twitter_link as tw_link, site_instagram_link as ig_link, site_pinterest_link as pi_link, 
        site_linkedin_link as li_link, site_youtube_link as yt_link, site_fb_link_status as fb_status, site_twitter_link_status as tw_status, 
        site_instagram_link_status as ig_status, site_pinterest_link_status as pi_status, site_linkedin_link_status as li_status, 
        site_youtube_link_status as yt_status";
       $builder->select($select);
       $builder->where("site_id", 1);
        $q =$builder->get();
        $data = $q->getRow();
        return $data;
    }
    function get_row_data($table,$select,$site_id,$query = null, $limit = null) {
        $db = \Config\Database::connect(); 
        $builder = $db->table($table);
        $builder->select($select);
        $builder->where("site_id",$site_id);
        if($query){
            $builder->where($query);
        }
        if($limit){
            $builder->limit($limit,0);
        }
        $q = $builder->get();
        
        return $q->getRow();
    }
    function get_cookie_banner_notification(){
        $db = \Config\Database::connect(); 
        $builder = $db->table('site_information')
                            ->select('site_cookie_notif_message')
                            ->where('id', 1);
        $query  = $builder->get();
        $result = $query->getResult();
        return $result[0]->site_cookie_notif_message;
    }
    function get_site_icon($site_id)
    {
        $db = \Config\Database::connect(); 
        $builder =  $db->table("site_information")   
                            ->select("site_logo")
                            ->where("site_id", $site_id);
        return $builder->get()->getRowArray()["site_logo"];
    }
    function get_menu($default = TRUE)
    {
        $db = \Config\Database::connect(); 
        $builder = $db->table("site_menu");
        $builder->select("id, menu_url, menu_name, menu_level, menu_parent_id, menu_type, url_behavior");
        if($default) {
            $builder->where("default_menu", 0);
        }
        $builder->where("status", 1);
        $builder->orderBy("sort_order", "ASC");

        return $builder->get()->getResultArray();
    }
    function get_sub_menu($parent_menu)
    {
        $db = \Config\Database::connect();
        $builder = $db->table("site_menu");
        $builder->select("id, menu_url, menu_name, menu_level, menu_parent_id, menu_type, url_behavior");
        $builder->where("status", 1);
        $builder->where("menu_parent_id", $parent_menu);
        $builder->orderBy("sort_order", "ASC");

        return $builder->get()->getResultArray();
    }
    function get_footer_menu()
    {
        $db = \Config\Database::connect();
        $builder = $db->table("site_menu");
        $builder->select("id, menu_url, menu_name, menu_level, menu_parent_id, menu_type, url_behavior");
        $builder->where("status", 1);
        $builder->where("footer_menu", 1);
        $builder->orderBy("footer_order", "ASC");

        return $builder->get()->getResultArray();
    }
    function get_route_by_specific_controller($controller)
    {
        $db = \Config\Database::connect(); 
        $builder = $db->table('site_menu_routes');
        $builder->select('route');
        $builder->where('LOWER(controller)', strtolower($controller));
        $builder->where('status', 1);

        return $builder->get()->getRowArray();
    }
    function get_asc_by_url($url) {
       $db = \Config\Database::connect(); 
       $builder = $db->table("cms_asc_ref a");
       $builder->select("a.asc_ref_code");
       $builder->join("cms_sites s", "s.id = a.site_id", "LEFT");
       $builder->where("s.site_url", $url);
       $builder->where("a.status", 1);
       $builder->orderBy("a.sort_order","ASC");
        $q =$builder->get();
        return $q->getResultArray();
    }
    function get_asc_section($url) {
        $db = \Config\Database::connect(); 
        $builder = $db->table("site_asc_section a");
       $builder->select("a.title");
       $builder->join("cms_sites s", "s.id = a.site_id", "LEFT");
       $builder->where("s.site_url", $url);
       $builder->where("s.status", 1);
        $q =$builder->get();
        $data = $q->getRow();
        
        if ($url != 1) {
           $builder->select("title");
           $builder = $db->table("site_asc_section");
           $builder->where("site_id", 1);
            $q =$builder->get();
            $corporate_data = $q->getRow();

            if(empty($data)) {
                $data = $corporate_data;
            } 
        }
        return $data;
    }
    function get_asc_corporate_pages() {
        $db = \Config\Database::connect(); 
        $builder = $db->table("cms_asc_ref");
        $builder->select("asc_ref_code");
        $builder->where("site_id", 1);
        $builder->where("status", 1);			
        $builder->orderBy("sort_order","ASC");
         $q =$builder->get();
         return $q->getResultArray();
     }
     function get_asc_corp_section() {
        $db = \Config\Database::connect(); 
        $builder = $db->table("site_asc_section");
        $builder->select("title");
        $builder->where("site_id", 1);
         $q =$builder->get();
         return $q->getRow();
     }
     function get_site_id($brand_name) {
        $db = \Config\Database::connect(); 
        $builder = $db->table("cms_sites");
       $builder->select("cms_sites.id");
       $builder->where("cms_sites.status = 1 AND cms_sites.site_url='$brand_name'");
        
        $q =$builder->get();
        $data = $q->getRow();
        return $data;
    }
    function get_signup_ad($kw, $type=null, $s2=true) {
        $db = \Config\Database::connect();
        $int_flag = ($type == 'internal' && $s2) ? 1 : 0;

        if ($type == 'by_product_page' && $s2) {
            $builder = $db->table("site_product_info");
            $builder->select("pv_signup_ad as image_loc, pv_signup_ad_behavior as behavior, pv_signup_ad_url as url");
           
            $builder->where("url", $kw);
        } elseif ($type == 'by_article' && $s2) {
            $builder = $db->table("site_articles");
            $builder->select("article_signup_ad as image_loc, article_signup_ad_behavior as behavior, article_signup_ad_url as url");
            
            $builder->where("id", $kw);
        } elseif ($type == 'by_category' && $s2) {
            $builder = $db->table("site_product_categories");
            $builder->select("pc_signup_ad as image_loc, pc_signup_ad_behavior as behavior, pc_signup_ad_url as url");
            
            $builder->where("category_url", $kw);
        } else {
            $builder = $db->table('site_signup_ads');
            $builder->select("sua_image as image_loc, sua_title as title, sua_behavior as behavior, sua_url as url");
            
            $builder->like('sua_title', 'match'); 
            $builder->orLike('sua_subtitle', $kw);
            $builder->where('status', 1);
            $builder->where('internal_store', $int_flag);
        }
        
        $q = $builder->get();						
        $ret = array();

        if($int_flag) {
            return $q->getResult();
        }

        foreach ($q->getResult() as $v) {
            $ret['url'] = $v->url;
            $ret['image_loc'] = $v->image_loc;
            $ret['behavior'] = ($v->behavior == 0) ? "_blank" : "_self";
        }

        if ($q->getNumRows() AND $ret['image_loc'] == '') {
            $ret = ($type == 'by_product_page') ? get_signup_ad("product_page",$type,false) : get_signup_ad("generic", $type, false);
        }

        if ( !$q->getNumRows() ) {
            $ret['url'] = "https://www.unilab.com.ph/signup";
            $ret['image_loc'] = ($type == 'by_product_page') ? 'assets/assets/images/generic_product_page_ad.jpg'  : 'assets/assets/images/banner-sidepanel-healthplus.jpg';
            $ret['behavior'] = "_self";
        }

        return $ret;
    }

    function get_product_info_id($brand_name){
        $db = \Config\Database::connect();

        $builder = $db->table("site_product_info");
        $builder->select("site_product_info.id AS product_info_id");
        $builder->where("site_product_info.status", 1);
        $builder->where("site_product_info.url", $brand_name);
        
        $q = $builder->get();
        $data = $q->getRow();

        if($data !== null){
            return $data->product_info_id;
        }else{
            return 0;
        }
    }

    function get_list_query($table, $query)
    {
        $db = \Config\Database::connect(); 
        $builder = $db->table($table)
                            ->where($query);
        $q = $builder->get();
        return $q->getResult();
    }

