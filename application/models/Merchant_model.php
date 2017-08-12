<?php

class Merchant_model extends CI_Model
{
    public function __construct()
    {
        $this->load->helper('new_helper');
    }

    public function merchant_insert($data)
    {
        $this->db->insert('merchant', $data);
        return true;
    }
     public function add_documents($data)
    {
        $this->db->insert('documents', $data);
        return true;
    }
    public function delete_documents($id)
    {
     $this->db-> where('id', $id);
     $query = $this->db->delete('documents');
    }
    public function get_documents($email)
    {
        $this->db->where('email',$email);
        $this -> db -> from('documents');
        $query = $this -> db -> get();
        return $query->result();
    }
    public function check_mail($mobile_no)
    {				
	$this->db->where('mobile_no',$mobile_no);
	$this->db->select("email");
	$this->db->from('merchant');
	$query = $this->db->get();			  
	 return $query->result();
    }
   public function check_mobile($get_email)
    {				
	$this->db->where('email',$get_email);
	$this->db->select("mobile_no");
	$this->db->from('merchant');
	$query = $this->db->get();			  
	return $query->result();
   }
    public function forget_password($data)
    {		
	$email_id = $data['email'];
	$this->db->where('email',$email_id);
	$this->db->update('merchant', $data);	
    }    
    public function login($email,$password)
    {
        $this->db->where('email',$email);
        $this->db->where('password',md5($password));
        $this -> db -> from('merchant');
        $query = $this -> db -> get();
        return $query->result();
    }
    public function  check_merchant($email,$mobile_no)
    {
    	$this->db->where('email',$email);
    	$this->db->where('mobile_no',$mobile_no);
        $this -> db -> from('merchant');
        $query = $this -> db -> get();
        return $query->result();
    }
    public function get_all_merchant()
    {
        $this -> db -> from('merchant');
        $query = $this -> db -> get();
        return $query->result();
    }
    public function check_password($data)
    {				
	$password= $data['old_password'];
	$new_password= md5(trim($password));
	$condition['email']=$data['email'];
	$condition['password']= $new_password;
	$this->db->where($condition);
	$this->db->from('merchant');				
	$query = $this->db->get();				
	return $query->result();		
   }
   public function update_password($data)
   {		
	$email = $data['email'];
	$old_password = $data['old_password'];
	$get_old_password= md5(trim($old_password));
	$update_password = $data['password'];
	$new_password= md5(trim($update_password));
	$datas['password']=$new_password;
	$this->db->where('email',$email);
	$this->db->where('password',$get_old_password);
	$this->db->update('merchant', $datas);
	  return true;
  }
}