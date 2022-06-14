<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verify extends CI_Controller {

	private $data;
	public function __construct()
	{
		parent::__construct();
        $this->load->model('UsersModel');
	}
	function  email($otp)
	{
		$result=$this->UsersModel->verifyemail($otp);
		if($result['result']=='error')
		{
			echo $result['result'];
			echo '<br/>Email not varified';
		}else
		{
			echo $result['result'];
			echo '<br/>Click here to login<a href="'.site_url('login').'">Login</a>';
		}
	}

}