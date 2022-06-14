<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	private $data;
	public function __construct()
	{
		parent::__construct();
        $this->load->model('UsersModel');
	}
	function  index()
	{
		$this->load->helper('form');
		$this->load->library('form_validation'); 
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == FALSE){

            // comes the validation errors

        }
        else{
            // we store the inormation into database
            $data=array('email'=>$this->input->post('email'),
                'password'=>$this->input->post('password'));
            $result=$this->UsersModel->login($data);

            if($result['result']===0){ 
                $this->data['result']='error';
                $this->data['message']=$result['message'];
            }else{

                $this->session->set_userdata('id',$result['info']->userid);
                $this->session->set_userdata('name',$result['info']->firstname);
                $this->session->set_userdata('usertype',$result['info']->usertype);
                $this->session->set_userdata('islogin',true);
                if($result['info']->usertype=='Admin'){
                	redirect('admin/dashboard',true);
                	return;
                }
                redirect('users/dashboard');
            }
        }
		$inputemail=array('type'=>'email',
			'name'=>'email',
			'value'=>set_value('email'),
			'class'=>'form-input',
			'placeholder'=>'Enter Your Email');
		$this->data['regfrm']['email']=form_input($inputemail);

		$inputpass=array('type'=>'password',
			'name'=>'password',
			'value'=>'',
			'class'=>'form-input',
			'placeholder'=>'Enter Your Password');
		$this->data['regfrm']['pass']=form_input($inputpass);

		$this->load->view('login',$this->data);
	}

}