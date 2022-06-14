<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller {

	private $data; 
	public function __construct() 
	{
		parent::__construct();
		if( !$this->session->userdata('islogin') || $this->session->userdata('usertype')!='Admin')
		{
			redirect ('login',true);
		}

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

		//$this->data['rate']['usd']=$this->USDtoRONconvertor(1);

		$this->load->view('admin/dashboard',$this->data);
	}


}