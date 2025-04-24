<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;

class ErrorLogs extends BaseController
{
    public function index()
	{
		$data['meta'] = array(
			"title"         =>  "Error Logs",
			"description"   =>  "Error Logs",
			"keyword"       =>  ""
		);
		$data["title"] = "CMS";
		$data["PageName"] = ("Error Logs");
		$data['buttons'] = ['date_range'];
		$data["content"] = "cms/error_logs/page";
		$data['breadcrumb'] = array('Error Logs' => '');
        $data['standard'] = config('Standard');
        $data['session'] = session(); 
		$data['js'] = array(
				"assets/js/xlsx.full.min.js",
				"assets/js/bootstrap.min.js",
				"assets/js/adminlte.min.js",
				"assets/js/moment.js",
				"assets/js/xlsx.full.min.js"
                    );
        $data['css'] = array(
        		"assets/css/bootstrap.min.css",
        		"assets/css/adminlte.min.css",
        		"assets/css/all.min.css",
        		"assets/cms/css/main_style.css",//css sa style ni master Vien
        		"assets/css/style.css"
                    );		
		
		return view("cms/layout/template", $data);		
	}

	public function get_error_log_files(){
		$map = directory_map('../writable/logs'); //logs directory
		// $map = array_splice($map, 0); //removes the index.html from array
		$multi_map = array();
		$limit = $_POST["limit"];

		foreach($map as $file){
			if($file!='index.html'){
				$date = str_replace('log-', '', $file);
				$date = str_replace('.log', '', $date);
				$date_id = $date;
				$date = date('F d, Y',strtotime($date));
				$multi_map[] = array(
					'filename' => $file,
					'date' => $date,
					'date_id' => $date_id,
					'lines' => $this->get_lines('../writable/logs/'.$file)
				);
			}
		}

		$result_return = array(
			"data" => array_reverse($multi_map),
			"total_data"=> count($multi_map),
			"total_page"=>ceil(count($multi_map) / $limit)
		);

		echo json_encode($result_return);
	}

	public function get_error_log_files_filter(){
		$map = directory_map('../writable/logs'); //logs directory
		$map = array_splice($map, 1); //removes the index.html from array
		$multi_map = array();
		$to = $_POST["to"];
		$from = $_POST["from"];
		$limit = $_POST["limit"];

		foreach($map as $file){
			$date = str_replace('log-', '', $file);
			$date = str_replace('.php', '', $date);
			$date_id = $date;
			$date = date_format(date_create($date), 'F d, Y');
			if($date >= $from && $date <= $to) {
				$multi_map[] = array(
					'filename' => $file,
					'date' => $date,
					'date_id' => $date_id,
					'lines' => $this->get_lines('../writable/logs'.$file)
				);
			}			
		}

		$result_return = array(
			"data" => array_reverse($multi_map),
			"total_data"=> count($multi_map),
			"total_page"=>ceil(count($multi_map) / $limit)
		);

		echo json_encode($result_return);
	}

	public function get_lines($file){
		// $a = rtrim(file_get_contents($file), ",");
		// $b = json_decode('['.$a.']');
		$a = rtrim(file_get_contents($file), ",");
		$a = str_replace("INFO","|INFO",$a);
		$a = str_replace("CRITICAL","|CRITICAL",$a);
		$a = str_replace("WARNING","|WARNING",$a);
		$b = explode("|",$a);

		return count($b);
	}

	public function get_array_logs($file){
		// $a = rtrim(file_get_contents($file), ",");
		// $b = json_decode('['.$a.']', true);
		$a = rtrim(file_get_contents($file), ",");
		$a = str_replace("INFO","|INFO",$a);
		$a = str_replace("CRITICAL","|CRITICAL",$a);
		$a = str_replace("WARNING","|WARNING",$a);
		$a = str_replace("\n","<br>",$a);
		$b = explode("|",$a);

		return array_reverse($b);
	}

	public function log(){
		$data['meta'] = array(
			"title"         =>  "Error Logs",
			"description"   =>  "Error Logs",
			"keyword"       =>  ""
		);
		$uri = current_url(true);
		$date =  $uri->getSegment(5);
		$session = session();
		$date = str_replace('#', '', $date);

		$data["title"] = "Content Management";
		$data["PageName"] = ("Error Logs");
		$data['edit_title'] = true;
		$data["content"] = "cms/error_logs/error_view";
		
        $data['standard'] = config('Standard');
        $data['session'] = session();
		$data['uri'] =$uri;
		$data['js'] = array(
				"assets/js/xlsx.full.min.js",
				"assets/js/bootstrap.min.js",
				"assets/js/adminlte.min.js",
				"assets/js/moment.js",
				"assets/js/xlsx.full.min.js"
                    );
        $data['css'] = array(
        		"assets/css/bootstrap.min.css",
        		"assets/css/adminlte.min.css",
        		"assets/css/all.min.css",
        		"assets/cms/css/main_style.css",//css sa style ni master Vien
        		"assets/css/style.css"
                    );
		return view("cms/layout/template", $data);	
	}

	public function error_data(){

		$date = $this->request->getPost('date_id');
		$date = '../writable/logs/log-'.$date.'.log';

		echo json_encode($this->get_array_logs($date));
	}

	public function log_exists($date){
		$map = directory_map('../writable/logs'); //logs directory
		// $map = array_splice($map, 1); //removes the index.html from array
		$date = 'log-'.$date.'.log';
		$counter = 0;

		foreach($map as $file){
			if($file == $date){
				$counter++;
			}
		}

		return $counter;
	}
}
