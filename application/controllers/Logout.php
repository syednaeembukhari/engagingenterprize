<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	private $data;
	public function __construct()
	{
		parent::__construct();
	}
	function  index()
	{
		$this->session->set_userdata('id','');
        $this->session->set_userdata('name','');
        $this->session->set_userdata('usertype','');
        $this->session->set_userdata('islogin',false);
        $this->session->sess_destroy();
        redirect('login');
            
     }
		 
}