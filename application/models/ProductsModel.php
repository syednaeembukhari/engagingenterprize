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

}// end of the class productmodel