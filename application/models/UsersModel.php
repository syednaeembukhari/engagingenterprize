<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsersModel extends CI_Model {

	public function __construct()
    {
        parent::__construct();
		
    }
    
    /* this function is to get users 
    params @active   	-> Active or Inactive
    params @varified  	-> 1 or 0   1 for varified and 0 for unvarified

    return set of users db object
    */
    public function get_users($active='',$varified='')
    {
    	if(!empty($active))
    		$this->db->where('userstatus',$active);
    	if(!empty($varified))
    		$this->db->where('isvarified',$varified);
    	return $this->db->get('users');
    }

    public function getActiveUsersWithActiveProduts()
    {
 		$this->db->select('users.*');
 		$this->db->join('users_products','users_products.userid = users.userid');
 		$this->db->join('products','products.pid = users_products.pid');
    	$this->db->where('users.userstatus','Active');
    	$this->db->where('users.isvarified',1);
    	$this->db->where('products.status','Active');
    	return $this->db->get('users');
    }

    
    public function getSummaryActiveProductsWithUsers()
    {
 		$this->db->select('sum(users_products.instock * users_products.price)  as psum',false);
 		$this->db->join('users_products','users_products.userid = users.userid');
 		$this->db->join('products','products.pid = users_products.pid');
    	$this->db->where('users.userstatus','Active');
    	$this->db->where('users.isvarified',1);
    	$this->db->where('products.status','Active');
    	return $this->db->get('users');
    }

    public function getSummaryProductsWithUsersWise()
    {
 		$this->db->select('users.firstname,users.lastname,sum(users_products.instock * users_products.price)  as psum',false);
 		$this->db->join('users_products','users_products.userid = users.userid');
 		$this->db->join('products','products.pid = users_products.pid');
 		$this->db->group_by('users.firstname,users.lastname,users.userstatus,users.isvarified,products.status');
    	$this->db->having('users.userstatus','Active');
    	$this->db->having('users.isvarified',1);
    	$this->db->having('products.status','Active');
    	return $this->db->get('users');
    }

}