<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	var $data; 
	public function __construct() 
	{
		parent::__construct();
		 

	}

	public function index()
	{
		$this->load->model('UsersModel');
		$this->load->model('ProductsModel');
		$this->data['users']['activeVarified']=$this->UsersModel->get_users('Active',1);
		$this->data['users']['haveActiveProducts']=$this->UsersModel->getActiveUsersWithActiveProduts();
		$this->data['users']['allSummaryActiveProducts']=$this->UsersModel->getSummaryActiveProductsWithUsers();
		$this->data['users']['allSummaryProductsUsers']=$this->UsersModel->getSummaryProductsWithUsersWise();
		$this->data['products']['activeProducts']=$this->ProductsModel->getProducts();
		$this->data['products']['unusedProducts']=$this->ProductsModel->getUnusedProducts();
		$this->data['products']['attachedProducts']=$this->ProductsModel->getAttachedProductsCount();

		$this->data['rate']['usd']=$this->USDtoRONconvertor(1);

		$this->load->view('dashboard',$this->data);
	}

	private function USDtoRONconvertor($amt)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.apilayer.com/exchangerates_data/convert?to=RON&from=USD&amount=$amt",
		  CURLOPT_HTTPHEADER => array(
		    "Content-Type: text/plain",
		    "apikey: fd3mkXUs5DztOFNaat9G3eBhFnTx6Jdw"
		  ),
		  CURLOPT_RETURNTRANSFER => true,	
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET"
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$res=json_decode($response);
		if($res->success)
		{
			return $res->result;
		}
		return $response;
	}
}
