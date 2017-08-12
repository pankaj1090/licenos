<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webservice extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this -> load -> library('session');
        $this -> load -> helper('form');
        $this -> load -> helper('url');
        $this -> load -> database();
        $this -> load -> library('form_validation');
        $this -> load -> model('Login_model');
        $this -> load -> model('Merchant_model');
        $this -> load -> helper('string_helper');

    }

     public function signup_api()
     {
         $fullname=$this->input->post('fullname');
         $email=$this->input->post('email');
         $mobile_no=$this->input->post('mobile_no');

         $password=$this->input->post('password');
         $image=$this->input->post('image');
         // print_r($file);
         $this->load->library('upload');
         $check_user=$this->Merchant_model->check_merchant($email, $mobile_no);
//check email already exists or not 
         if(!$check_user)
         {

         $config['upload_path']   = './assets/images/'; 
         $config['allowed_types'] = 'gif|jpg|jpeg|png';
         $config['max_size']      = 10000; 
         $config['file_name']     = time().$fullname;
         $this->upload->initialize($config);
         $uploaddocument="";
         if ( $this->upload->do_upload('image'))
         {
            // echo " uploaded";
             $uploaddocument='assets/images/'.$this->upload->data('file_name'); 
         } 
         else   {
//            echo $this->upload->display_errors();
                }

         $data['fullname']=$fullname;
         $data['email']=$email;
         $data['mobile_no']=$mobile_no;
         $data['password']=md5($password);
         $data['image']=$uploaddocument;

         if(  $this->Merchant_model->merchant_insert($data))
         {
                        $data['image']= $uploaddocument?base_url($uploaddocument):"";
                    $raw_data=array('status'=>"true",
                                     'message'=>"Your Registration is Success",
                                     "data" =>   $data
                                        );
         }
         else
         {
             $raw_data=array('status'=>"false",
                                     'message'=>"data not inserted",
                                     "data" => ""
                                        );
         }

     }
     else
     {
        $raw_data=array('status'=>"false",
                                     'message'=>"Email or Mobile No. Already Exist",
                                     "data" => ""
                                        );

     }
          header('Content-Type: application/json'); 
         echo json_encode($raw_data);
     }
     public function login_api()
     {
         $email=$this->input->post('email');
         $password=$this->input->post('password');
         $result= $this->Merchant_model->login($email,$password);
         if($result)
         {
            $result[0]->password="*********";
            $result[0]->image= base_url($result[0]->image);

             $raw_data=array('status'=>"true",
                                     'message'=>"Login Successfull",
                                     "data" => $result[0]
                                        );
         }
          else{
             $raw_data=array('status'=>"false",
                                     'message'=>"Login Failed",
                                     "data" =>  ""
                                        );
          }
          header('Content-Type: application/json'); 
          echo json_encode($raw_data);

     }
     public function add_documents()
     {

         $email=$this->input->post('email');
         $image=$this->input->post('image');
         $document_name=$this->input->post('document_name');
         // print_r($file);

         $docname=explode("@", $email);
         $name="$docname[0]";

         $this->load->library('upload');
    
         $config['upload_path']   = './assets/images/'; 
         $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
         $config['max_size']      = 10000; 
         $config['file_name']     = $document_name;
         $this->upload->initialize($config);
         $updatedcatimage="";
         if ( $this->upload->do_upload('image'))
         {
          $updatedcatimage='assets/images/'.$this->upload->data('file_name'); 
         }
         else   {
//            echo $this->upload->display_errors();
                }

         $data['email']=$email;
         $data['document_name']=$document_name;
         $data['image']=$updatedcatimage;
         
         $this->Merchant_model->add_documents($data);

        $arr = array('status' => 'true', 'message' => 'Upload Successfully'); 
         header('Content-Type: application/json');      
         echo json_encode($arr);
     }
     public function get_documents()
     {

         $email=$this->input->post('email');

         $data=$this->Merchant_model->get_documents($email);
         if($data)
         {
            foreach ($data as $data1) {
                $data1->image= base_url($data1->image);

            }          
             $arr = array('status' => 'true', 'message' => 'Get Documents', 'data' =>$data); 
         header('Content-Type: application/json');      
         echo json_encode($arr);
         }

         else
         {
             $arr = array('status' => 'false', 'message' => 'No Documents Found'); 
         header('Content-Type: application/json');      
         echo json_encode($arr);
         }
      } 
     public function delete_documents()
     {

         $id=$this->input->post('id');

         $this->Merchant_model->delete_documents($id);
        
             $arr = array('status' => 'true', 'message' => 'Delete Document'); 
         header('Content-Type: application/json');      
         echo json_encode($arr);
      }

	public function forget_password() 
	{ 

		$value = $this->input->post('value', TRUE); 
		if(is_numeric($value))
		{
			$mobile_no=$value;
			$email_id =$this->Merchant_model->check_mail($mobile_no);
			$get_email= $email_id[0]->email;

			$from_email = 'liceno@info.com';  
		    $length= 5;
			$chars = "0123456789";
			$password = substr( str_shuffle( $chars ), 0, $length );
			$space = " ";

			$new_password= md5(trim($password));
			$data['password']= $new_password;
			$data['email']= $get_email;

			$this->Merchant_model->forget_password($data);
			send_password_mobile($mobile_no, $password);
		 	$this->load->library('email'); 

		 	$this->email->from($from_email, 'Liceno Password'); 
		 	$this->email->to($get_email);
		 	$this->email->subject('Liceno Password'); 
		 	$this->email->message('Liceno Password'.$space.$password); 
				
		 //Send mail
			 if($this->email->send()) 
			 {
			 	$arr = array('status' => 'true', 'message' => "Password updated"); 
			 header('Content-Type: application/json');      
			   echo json_encode($arr);
			 }
			 
			 else {
			 	  $arr = array('status' => 'false', 'message' => "Please try again later"); 
			 header('Content-Type: application/json');      
			   echo json_encode($arr);
			 }
			}
			else
			{
			$get_email=$value;
			$mobile =$this->Merchant_model->check_mobile($get_email);
			$mobile_no= $mobile[0]->mobile_no;
			//print_r($mobile_no);
			$from_email = 'liceno@info.com';  
			$length= 5;
			$chars = "0123456789";
			$password = substr( str_shuffle( $chars ), 0, $length );
			$space = " ";
		    $new_password= md5(trim($password));

			send_password_mobile($mobile_no, $password);
			$data['password']= $new_password;
			$data['email']= $get_email;

			$this->Merchant_model->forget_password($data);
		    $this->load->library('email'); 

		 	$this->email->from($from_email, 'Liceno Password'); 
		 	$this->email->to($get_email);
		 	$this->email->subject('Liceno Password'); 
		 	$this->email->message('Liceno Password'.$space.$password); 
				
			 //Send mail
			 if($this->email->send()) 
			 {
			 	$arr = array('status' => 'true', 'message' => "Password updated"); 
			 header('Content-Type: application/json');      
			   echo json_encode($arr);
			 }
			 
			 else 
			 {
			 	$arr = array('status' => 'false', 'message' => "Please try again later"); 
			 header('Content-Type: application/json');      
			   echo json_encode($arr);
			 }
		}
	} 

        public function update_password()
	{
		$email= $this->input->post('email', TRUE); 
		$old_password = $this->input->post('old_password', TRUE);
		$password = $this->input->post('password', TRUE);

		$data['email']=$email;
		$data['old_password']=$old_password;
		$data['password']=$password;

		if ($dataget =$this->Merchant_model->check_password($data)) {
			if($this->Merchant_model->update_password($data))
			{
				$arr = array('status' => 'ture', 'message' => "Password Change Sucessfully"); 
				header('Content-Type: application/json');      
				echo json_encode($arr);
			}
			else{

				$arr = array('status' => 'false', 'message' => "Please try again later"); 
				header('Content-Type: application/json');      
				echo json_encode($arr);
			}
		}
		else{
			$arr = array('status' => 'false', 'message' => "Invaild password"); 
			header('Content-Type: application/json');      
			echo json_encode($arr);
		}
		

	} 
}