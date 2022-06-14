<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Products extends CI_Controller {

	private $data; 
	public function __construct() 
	{
		parent::__construct();
		if( !$this->session->userdata('islogin') || $this->session->userdata('usertype')!='Admin')
		{
			redirect ('login',true);
		}
		$this->load->model('UsersModel');
		$this->load->model('ProductsModel');
	}

	public function index()
	{
		
		
		//$this->data['rate']['usd']=$this->USDtoRONconvertor(1);
		$this->data['products']=$this->ProductsModel->getProducts();
		$this->load->view('admin/products/all',$this->data);
	}
	public function add()
	{
		
		$this->data['formaction']='admin/products/add';
		$this->data['pagetitle']='Add Product';
		$this->data['buttontitle']='Save';
		$this->load->helper('form');
		$this->load->library('form_validation'); 
		$this->form_validation->set_rules('title', 'Title', 'required');
		if ($this->form_validation->run() == FALSE){

            // comes the validation errors

        }else{
        	$imagename='';
        	if(isset($_FILES['imagefile']) && $_FILES['imagefile']['tmp_name'] !='')
        	{
        		// user select file uplaod , save the file on lcal directory
        		$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|png';
				//$config['max_size']     = '1024';
				$config['encrypt_name'] = TRUE;
				//$config['max_width'] = '1024';
				//$config['max_height'] = '768';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if($this->upload->do_upload('imagefile'))
				{
					$this->data['upload_data']= $this->upload->data();
					$imagename=$this->data['upload_data']['file_name'];
				}else
				{
					//print_r($this->upload->display_errors());
				}
			}

        
        // we store the inormation into database
        

            $data=array('title'=>$this->db->escape_str($this->input->post('title')),
                'description'=>$this->db->escape_str($this->input->post('description')),
            	'image'=>$imagename,
            	'status'=>$this->input->post('status'));
            $result=$this->ProductsModel->add($data);
             
            if($result<=0){ 
                $this->data['result']='error';
                $this->data['message']='Error occure while adding product';
            }else{
            	$this->session->set_flashdata('message','Product Successfully Added');
            	redirect('admin/products');
        	}
        }
   

		$title=array('type'=>'text',
			'name'=>'title',
			'value'=>set_value('title'),
			'class'=>'form-input',
			'placeholder'=>'Enter product title');
		$this->data['profrm']['title']=form_input($title);

		$descp=array( 
			'name'=>'description',
			'value'=>set_value('description'),
			'class'=>'form-input',
			'placeholder'=>'Enter product Descriptions');
		$this->data['profrm']['description']=form_textarea($descp);

		$image=array('type'=>'file',
			'name'=>'imagefile',
			'value'=>'',
			'class'=>'form-input',
			'placeholder'=>'Select Product Image');
		$this->data['profrm']['imagefile']=form_input($image);

		$option=array('Active'=>"Active",
					 'Inactive'=>'Inactive');
		$extra=array('class'=>'form-input');
		$this->data['profrm']['status']=form_dropdown('status',$option,set_value('status','Active'),$extra);

		$this->load->view('admin/products/add',$this->data);
	}


	public function edit($productid=0)
	{
		$product=$this->ProductsModel->getProduct($productid);

		if(empty($product))
		{
			die('Invalid id provided');
		}
		$this->data['product']=$product;
		$this->data['formaction']='admin/products/edit/'.$productid;
		$this->data['pagetitle']='Update Product';
		$config['encrypt_name'] = TRUE;
		$this->data['buttontitle']='Update';
		$this->load->helper('form');
		$this->load->library('form_validation'); 
		$this->form_validation->set_rules('title', 'Title', 'required');
		if ($this->form_validation->run() == FALSE){

            // comes the validation errors

        }else{
        	$imagename='';
        	if(isset($_FILES['imagefile']) && $_FILES['imagefile']['tmp_name'] !='')
        	{
        		// user select file uplaod , save the file on lcal directory
        		$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|png';
				//$config['max_size']     = '1024';
				//$config['max_width'] = '1024';
				//$config['max_height'] = '768';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if($this->upload->do_upload('imagefile'))
				{
					$this->data['upload_data']= $this->upload->data();
					$imagename=$this->data['upload_data']['file_name'];
				}else
				{
					print_r($this->upload->display_errors());
				}
			}

        
        // we store the inormation into database
        

            $data=array('title'=>$this->db->escape_str($this->input->post('title')),
                'description'=>$this->db->escape_str($this->input->post('description')),
            	'status'=>$this->db->escape_str($this->input->post('status')),);
            if($imagename!='')
            {
            	$data['image']=$imagename;
            }
            $result=$this->ProductsModel->update($data,$productid);
             
            if($result===1){ 
                 
            	$this->session->set_flashdata('message','Product Successfully Updated');
            	//redirect('admin/products');
        	}
        }
   

		$title=array('type'=>'text',
			'name'=>'title',
			'value'=>set_value('title',$product->title),
			'class'=>'form-input',
			'placeholder'=>'Enter product title');
		$this->data['profrm']['title']=form_input($title);

		$descp=array( 
			'name'=>'description',
			'value'=>set_value('description',$product->description),
			'class'=>'form-input',
			'placeholder'=>'Enter product Descriptions');
		$this->data['profrm']['description']=form_textarea($descp);

		$image=array('type'=>'file',
			'name'=>'imagefile',
			'value'=>'',
			'class'=>'form-input',
			'placeholder'=>'Select Product Image');
		$this->data['profrm']['imagefile']=form_input($image);

		$option=array('Active'=>"Active",
					 'Inactive'=>'Inactive');
		$extra=array('class'=>'form-input');
		$this->data['profrm']['status']=form_dropdown('status',$option,set_value('status', $product->status),$extra);

		$this->load->view('admin/products/add',$this->data);
	}

	function delete($pid=0)
	{
		$result=$this->ProductsModel->delete($pid);
		$this->session->set_flashdata('message','Product Successfully Deleted');
		redirect('admin/products');
	}


}