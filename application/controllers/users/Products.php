<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Products extends CI_Controller {

	private $data; 
	public function __construct() 
	{
		parent::__construct();
		if( !$this->session->userdata('islogin') || $this->session->userdata('usertype')!='Customer')
		{
			redirect ('login',true);
		}
		$this->load->model('UsersModel');
		$this->load->model('ProductsModel');
	}

	public function index()
	{
		$this->data['products']=$this->ProductsModel->getUserProducts($this->session->userdata('id'));
		$this->load->view('user/products/all',$this->data);
	}
	public function add()
	{
		
		$this->data['formaction']='users/products/add';
		$this->data['pagetitle']='Add Product';
		$this->data['buttontitle']='Save';
		$this->load->helper('form');
		$this->load->library('form_validation'); 
		$this->form_validation->set_rules('price', 'Price', 'required|integer');
		$this->form_validation->set_rules('instock','Quantity', 'required|numeric');
		if ($this->form_validation->run() == FALSE){

            // comes the validation errors

        }else{
        	 

        
        // we store the inormation into database
        

            $data=array('price'=>$this->db->escape_str($this->input->post('price')),
                'instock'=>$this->db->escape_str($this->input->post('instock')),
            	'pid'=>$this->db->escape_str($this->input->post('pid')),
            	'userid'=>$this->session->userdata('id'),

            	);
            $result=$this->ProductsModel->addUserProduct($data);
             
            if($result<=0){ 
                $this->data['result']='error';
                $this->data['message']='user may have added this product already ';
            }else{
            	$this->session->set_flashdata('message','Product Successfully Added');
            	redirect('admin/products');
        	}
        }
   
        $this->data['products']=$this->ProductsModel->getProducts('Active');
        $option=array();
        foreach($this->data['products']->result() as $product){
        	$option[$product->pid]= $product->title;
        }
		$extra=array('class'=>'form-input');
		$this->data['profrm']['pidlist']=form_dropdown('pid',$option,set_value('pid', $product->status),$extra);

		$price=array('type'=>'text',
			'name'=>'price',
			'value'=>set_value('price'),
			'class'=>'form-input',
			'placeholder'=>'Enter product price');
		$this->data['profrm']['price']=form_input($price);
		$instock=array('type'=>'numeric',
			'name'=>'instock',
			'value'=>set_value('instock'),
			'class'=>'form-input',
			'placeholder'=>'Enter product Quantity');
		$this->data['profrm']['instock']=form_input($instock);


		$this->load->view('user/products/add',$this->data);
	}


	public function edit($productid=0)
	{
		$product=$this->ProductsModel->getUserProduct($productid,$this->session->userdata('id'));

		if(empty($product))
		{
			die('Invalid id provided');
		}
		$this->data['product']=$product;
		$this->data['formaction']='users/products/edit/'.$productid;
		$this->data['pagetitle']='Update Product';
		$config['encrypt_name'] = TRUE;
		$this->data['buttontitle']='Update';
		$this->load->helper('form');
		$this->load->library('form_validation'); 
		$this->form_validation->set_rules('price', 'price', 'required');
		$this->form_validation->set_rules('instock', 'instock', 'required');
		if ($this->form_validation->run() == FALSE){

            // comes the validation errors

        }else{
        	 
        	 

        
        // we store the inormation into database
        

            $data=array('price'=>$this->db->escape_str($this->input->post('price')),
                'instock'=>$this->db->escape_str($this->input->post('instock')),
            	);
            
            $result=$this->ProductsModel->updateUserProduct($data,$productid,$this->session->userdata('id'));
             
            if($result===1){ 
                 
            	$this->session->set_flashdata('message','Product Successfully Updated');
            	//redirect('admin/products');
        	}
        }
   

		$this->data['products']=$this->ProductsModel->getProducts('Active');
         
		$price=array('type'=>'text',
			'name'=>'price',
			'value'=>set_value('price',$product->price),
			'class'=>'form-input',
			'placeholder'=>'Enter product price');
		$this->data['profrm']['price']=form_input($price);
		$instock=array('type'=>'numeric',
			'name'=>'instock',
			'value'=>set_value('instock',$product->instock),
			'class'=>'form-input',
			'placeholder'=>'Enter product Quantity');
		$this->data['profrm']['instock']=form_input($instock);

		$this->load->view('user/products/add',$this->data);
	}

	function delete($pid=0)
	{
		$result=$this->ProductsModel->delete($pid,$this->session->userdata('id'));
		$this->session->set_flashdata('message','Product Successfully Deleted');
		redirect('users/products');
	}


}