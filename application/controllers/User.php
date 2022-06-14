<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	private $data;
	public function __construct()
	{
		parent::__construct();
        $this->load->model('UsersModel');
	} 
	private function index()
	{
		echo 'silence is gold';
	}
	public function register()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('firstname', 'First Name', 'required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('password2', 'Password Confirmation', "required|matches[password]");

		if ($this->form_validation->run() == FALSE){

            // comes the validation errors

        }
        else{
            // we store the inormation into database
            $data=array('firstname'=>$this->input->post('firstname'),
                'lastname'=>$this->input->post('lastname'),
                'email'=>$this->input->post('email'),
                'password'=>$this->input->post('password'),
                'userstatus'=>'Active',
                'isvarified'=>0);
            $id=$this->UsersModel->register($data);
            if($id<=0){ 
                $this->data['result']='error';
                $this->data['result']='Error occure while processing try again';
            }else{
                $check=$this->UsersModel->sendVarificationMessage($id);
                $this->session->set_flashdata('message','User  Successfully Registered'.$check['message']);
                redirect('user/register');
            }
        }



		$inputfirstname=array('type'=>'text',
			'name'=>'firstname',
			'value'=>set_value('firstname'),
			'class'=>'form-input',
			'placeholder'=>'Enter Your First Name');
		$this->data['regfrm']['firstname']=form_input($inputfirstname);

		$inputlastname=array('type'=>'text',
			'name'=>'lastname',
			'value'=>set_value('lastname'),
			'class'=>'form-input',
			'placeholder'=>'Enter Your last Name');

		$this->data['regfrm']['lastname']=form_input($inputlastname);
		$inputemail=array('type'=>'email',
			'name'=>'email',
			'value'=>set_value('email'),
			'class'=>'form-input',
			'placeholder'=>'Enter Your Email');
		$this->data['regfrm']['email']=form_input($inputemail);

		$inputpass=array('type'=>'password',
			'name'=>'password',
			'value'=>set_value('password'),
			'class'=>'form-input',
			'placeholder'=>'Enter Your Password');
		$this->data['regfrm']['pass']=form_input($inputpass);

		$inputpass2=array('type'=>'password',
			'name'=>'password2',
			'value'=>set_value('password2'),
			'class'=>'form-input',
			'placeholder'=>'Re-type Your Password');
		$this->data['regfrm']['pass2']=form_input($inputpass2);

		$this->load->view('user/registration',$this->data);

	}

}
