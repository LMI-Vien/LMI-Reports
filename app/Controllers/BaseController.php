<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Session\Session;
use App\Models\Global_model;
use App\Models\Custom_model;
use App\Models\Dashboard_model;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];
	protected $Global_model;
    protected $Custom_model;
    protected $Dashboard_model;

	/** @var Session */
	protected $session;
	/** @var BaseConnection */
	protected $db;

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		$this->session = \Config\Services::session();
		$this->db = \Config\Database::connect();
		$this->Global_model = new Global_model();
        $this->Custom_model = new Custom_model();
        $this->Dashboard_model = new Dashboard_model();
	}

}
