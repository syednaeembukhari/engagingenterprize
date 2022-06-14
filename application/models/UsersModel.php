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
    public function get_user($userid)
    {
    	$this->db->where('userid',$userid);
    	return $this->db->get('users')->row();
    }
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

    public function register($data)
    {
        $this->db->insert('users',$data);
        return $this->db->insert_id(); 
    }

    public function getOTP($userid)
    {
        $otp=  $userid.'_'.strtolower(bin2hex(random_bytes(12)));

        $this->db->set('otp',$otp);
        $this->db->where('userid',$userid);
        $this->db->update('users');

        return $otp;
    }

    public function sendVarificationMessage($userid)
    {
            $otp=$this->getOTP($userid);

            $user=$this->get_user($userid);

            $verify_link = site_url('verify/email/'.$otp);

           echo  $message='Click the link below to verify your email  <a href="'.$verify_link.'>Verify Your Email</a>';
            $subject="Email Varification required";
            $this->load->library('email');
            $this->email->from("some@emaildomain.com");
            $this->email->to($user->email);
            $this->email->subject($subject);
            $this->email->message($message);
            if($this->email->send()){
                return array('result'=>'success','message'=>"Verification Email Send. Please check your email.");
            }else{
                return array('result'=>'error','message'=>"Email not send");
            }
    }

    public function verifyemail($otp)
    {
        $otpsplit=explode('_',$otp);
        $this->db->where('userid',$otpsplit[0]);
        $this->db->where('otp',$otp);
        $result= $this->db->get('users');

        if($result->num_rows()<=0){
           return array('result'=>'error','message'=>"Invalid OTP given");
        }else{
            $this->db->where('userid',$otpsplit[0]);
            $this->db->set('otp','');
            $this->db->set('isvarified',1);
            $result= $this->db->update('users');
            return array('result'=>'success','message'=>"Email Successfully varified");
        }
    }

    public function login($data)
    {
        foreach($data as $item=>$val)
        {
            $this->db->where($item,$val);
        }
        $res=$this->db->get('users');
        if($res->num_rows()>0)
        {
            $row=$res->row();
            if($row->isvarified==0)
            {
                 return array('result'=>0,'message'=>"Your is not varified, kindly chek your email");
            }else
            {
                return array('result'=>'success','message'=>"Success",'info'=>$row);
            }
        }
        return array('result'=>0,'message'=>"Invalid Email or password ");
    }

}