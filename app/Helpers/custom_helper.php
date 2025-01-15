<?php
	

	
	function send_email($data){
		require APPPATH.'Libraries/Sndgrd.php';
		$db      = \Config\Database::connect();
		$sndgrd = new \Sndgrd;
    	$emails = config('Emails');
		$protocol = $emails->protocol;
    	$default_email = $emails->default_email;
		$details = $db->table('cms_preference')->where(array('id' =>1))->get()->getResult();
    	//$details = $CI->Global_model->get_by_id('cms_preference', 1);
    	$from_name = (isset($data['from_name'])) ? $data['from_name'] : $details[0]->cms_title;
    	$from = (isset($data['from'])) ? $data['from'] : $default_email;

    	switch($protocol){
    		case 'smtp':
    			$CI->email->from($from, $from_name);
		        $CI->email->to($data['to']);
		        $CI->email->subject($data['subject']);
		        $CI->email->message($data['content']);
		        return $CI->email->send();
    			break;

    		case 'sendmail':
    			$CI->email->from($from, $from_name);
		        $CI->email->to($data['to']);
		        $CI->email->subject($data['subject']);
		        $CI->email->message($data['content']);
		        return $CI->email->send();
    			break;
    		
    		default:
    			$info = array(
    				'from_name' => $from_name,
    				'from' => $from,
    				'to' => $data['to'],
    				'subject' => $data['subject'],
    				'content' => $data['content']
    			);
    			$result = $sndgrd->send($info);
    			break;
    	}

    	return $result;
	}

   //vms api helper
    function vms_randomize($length = 5){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

     function generate($data, $token){

        $access_token = hash('sha512',$token . json_encode($data));
 
        return vms_randomize(6).$access_token;
    }
