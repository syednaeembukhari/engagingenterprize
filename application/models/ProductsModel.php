<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductsModel extends CI_Model {

	public function __construct()
    {
        parent::__construct();
		
    }
    function getProducts($status='')
    {
        if(!empty($status))
            $this->db->where('status',$status);
        return $this->db->get('products');
    }
    function getProduct($pid)
    {
        
        $this->db->where('pid',$pid);
        return $this->db->get('products')->row();
    }
    function getUnusedProducts()
    {
         
      
        return $this->db->query("SELECT * FROM products where pid NOT IN (SELECT pid from users_products) AND status='Active'");
    }

    function getAttachedProductsCount()
    {
         
        
        $result= $this->db->query("SELECT sum(users_products.instock) as inhand FROM users_products 
            INNER JOIN products ON users_products.pid=products.pid WHERE products.status='Active'") ;
        
        return $result;
    }
    function add($data)
    {
        $this->db->insert('products',$data);
        return $this->db->insert_id();
    }
    function update($data,$pid)
    {   
        $this->db->where('pid',$pid);
        foreach($data as $i=>$d){
            $this->db->set($i,$d);
        }
        $this->db->update('products');
        return 1;
    }
    function delete($pid)
    {
        $this->db->where('pid',$pid);
        $this->db->delete('products');
        return 1;
    }

}// end of the class productmodel