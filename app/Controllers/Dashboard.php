<?php

namespace App\Controllers;

use Config\Database;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Dashboard extends BaseController
{
    protected $session;
    private $auth_token;
    protected $db;
    public function __construct()
	{
	    $this->session = session();
	    $this->auth_token = getenv('API_AUTH_TOKEN');
        helper('url');
	    if (!$this->session->get('sess_site_uid')) {
	        redirect()->to(base_url('login'))->send();
	        exit;
	    }
	}

    private function check_token()
    {
        $request_token = $this->request->getHeaderLine('Authorization');

        if ($request_token !== $this->auth_token) {
            return $this->failUnauthorized('Invalid or missing token.');
        }

        return true;
    }

	public function index()
	{
		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);
		$data['title'] = "Dashboard";
		$data['PageName'] = 'Dashboard';
		$data['PageUrl'] = 'Dashboard';
		$data["breadcrumb"] = array('Announcements' => '');
		$today = date('Y-m-d H:i:s');

		$query = [
		    'status' => 1,
		    'start_date <=' => $today,
		    'end_date >='   => $today,
		];
		$data['announcements'] = $this->Global_model->get_data('tbl_announcements', $query, 999, 0, 'id, title, description_1, description_2, description_3, start_date, end_date', 'title', 'ASC', null, null);
		$data['announcementTypes'] = [
			'System Update'     => '#007BFF',
			'Event Notification'=> '#28A745',
			'Policy Update'     => '#FD7E14',
			'Downtime Alert'    => '#DC3545',
			'Holiday Advisory'  => '#FFC107',
			'Security Notice'   => '#343A40',
			'Promotion or Offer'=> '#6F42C1',
			'Personnel Update'  => '#795548',
			'User Reminder'     => '#6C757D',
		];
		
		$data['content'] = "site/dashboard/dashboard";
		$data['session'] = session();
		$data['js'] = array(
                    );
        $data['css'] = array(
                    );
        return view("site/layout/template_no_sidebar", $data);
	}

    public function getCounts()
    {
        $counts = $this->Dashboard_model->getCounts();
        return $this->response->setJSON($counts);
    }

	public function get_ba_asc_name() {
	    $name = $this->request->getPost('name');
	    $role = $this->session->get('sess_site_role');
	    $response = ['status' => 'error', 'message' => 'No result found'];
	    //$role = 8;
	    if (empty($name)) {
	        return $this->response->setJSON($response);
	    }

	    $table = 'tbl_area_sales_coordinator asc';
	    $field = 'asc.description AS asc_name, asc.id AS asc_id, a.id AS area_id, a.description AS area';
	    $join = [
	        ['table' => 'tbl_area a', 'query' => 'asc.area_id = a.id', 'type' => 'left'],
	        ['table' => 'tbl_store_group sg', 'query' => 'a.id = sg.area_id', 'type' => 'left'],
	        ['table' => 'tbl_store s', 'query' => 'sg.store_id = s.id', 'type' => 'left']
	    ];

	    if ($role == 7) { // Brand Ambassador
	        $table = 'tbl_brand_ambassador ba';
	        $field = 'ba.name AS brand_ambassador, ba.id AS brand_ambassador_id, a.id AS area_id, a.description AS area';
	        $join = [
	            ['table' => 'tbl_brand_ambassador_group bag', 'query' => 'ba.id = bag.brand_ambassador_id', 'type' => 'left'],
	            ['table' => 'tbl_store s', 'query' => 'bag.store_id = s.id', 'type' => 'left'],
	            ['table' => 'tbl_store_group sg', 'query' => 's.id = sg.store_id', 'type' => 'left'],
	            ['table' => 'tbl_area a', 'query' => 'sg.area_id = a.id', 'type' => 'left']
	        ];
	    }

	    $result = $this->Global_model->get_by_name($table, $field, $name, $join);

	    if (!empty($result)) {
	        $row = $result[0];
	        $data = [];

	        if ($role == 7) {
	            $data = [
	                'brandAmbassador'   => $row->brand_ambassador ?? '',
	                'brandAmbassadorId' => $row->brand_ambassador_id ?? '',
	                'area'              => (!empty($row->area_id) && !empty($row->area))
	                    ? "AREA-" . str_pad($row->area_id, 4, '0', STR_PAD_LEFT) . " - " . $row->area
	                    : '',
	                'areaId'            => $row->area_id ?? ''
	            ];
	        } else {
	            $data = [
	                'ascName'   => $row->asc_name ?? '',
	                'ascNameId' => $row->asc_id ?? '',
	                'area'      => (!empty($row->area_id) && !empty($row->area))
	                    ? "AREA-" . str_pad($row->area_id, 4, '0', STR_PAD_LEFT) . " - " . $row->area
	                    : '',
	                'areaId'    => $row->area_id ?? ''
	            ];
	        }

	        return $this->response->setJSON([
	            'status' => 'success',
	            'data'   => $data
	        ]);
	    }

	    return $this->response->setJSON($response);
	}

	// ================================= Header for pdf export =================================
	private function printHeader($pdf, $title) {
		$pdf->SetFont('helvetica', '', 12);
		$pdf->Cell(0, 10, 'LIFESTRONG MARKETING INC.', 0, 1, 'C');
		$pdf->SetFont('helvetica', '', 10);
		$pdf->Cell(0, 5, $title, 0, 1, 'C');
		$pdf->Ln(5);
	}

	public function exportAnnouncementPdf() {
		$request = $this->request->getJSON();
		$id = $request->id ?? null;

		$announcement = $this->db->table('tbl_announcements')->where('id', $id)->get()->getRow();

		$title = "Announcement";
		$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator('LMI SFA');
		$pdf->SetAuthor('LIFESTRONG MARKETING INC.');
		$pdf->SetTitle($title);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();

		$this->printHeader($pdf, $title);

		$html = "<h2>{$announcement->title}</h2>
				<p><strong>Type:</strong> {$announcement->description_1}</p>
				<p><strong>Active From:</strong> " . date('F j, Y', strtotime($announcement->start_date)) . " to " . date('F j, Y', strtotime($announcement->end_date)) . "</p>
				<hr>
				<p>{$announcement->description_2}</p>
				<p>{$announcement->description_3}</p>";

		$pdf->writeHTML($html, true, false, true, false, '');

		$pdf->Output($title . '.pdf', 'D');
		exit;
	}

	public function exportAnnouncementExcel() {
		$request = $this->request->getJSON();
		$id = $request->id ?? null;

		$announcement = $this->db->table('tbl_announcements')
			->where('id', $id)
			->get()
			->getRow();

		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'LIFESTRONG MARKETING INC.');
		$sheet->setCellValue('A2', 'Announcement Details');
		$sheet->mergeCells('A1:B1');
		$sheet->mergeCells('A2:B2');

		$sheet->getStyle('A1:A2')->getFont()->setBold(true)->setSize(14);
		$sheet->getStyle('A1:A2')->getAlignment()->setHorizontal('center');

		$sheet->setCellValue('A4', 'Title');
		$sheet->setCellValue('B4', $announcement->title);

		$sheet->setCellValue('A5', 'Type');
		$sheet->setCellValue('B5', $announcement->description_1);

		$sheet->setCellValue('A6', 'Start Date');
		$sheet->setCellValue('B6', date('F j, Y', strtotime($announcement->start_date)));

		$sheet->setCellValue('A7', 'End Date');
		$sheet->setCellValue('B7', date('F j, Y', strtotime($announcement->end_date)));

		$sheet->setCellValue('A9', 'Description');
		$sheet->setCellValue('B9', $announcement->description_2);

		// $sheet->setCellValue('A9', 'Description');
		$sheet->setCellValue('B10', $announcement->description_3);

		// Auto size columns
		foreach (range('A', 'B') as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}

		$filename = 'Announcement.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

}
