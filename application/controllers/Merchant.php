<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Merchant extends CI_Controller
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
    }

    public function index()
    {
        $data['merchant']=$this->Merchant_model->get_all_merchant();

        $this -> load -> view('common/head.php');
        $this->load->view('common/sidebar.php');
        $this->load->view('merchant_view.php',$data);
        $this -> load -> view('common/footer.php');
    }
     public function gallery()
    {
       /* $data['merchant']=$this->Merchant_model->get_all_merchant();*/

        $this -> load -> view('common/head.php');
        $this->load->view('common/sidebar.php');
        $this->load->view('gallery.php');
        $this -> load -> view('common/footer.php');
    }


}