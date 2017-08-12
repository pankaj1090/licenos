<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apidetails extends CI_Controller
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
    }
    public function index()
    {
        $this -> load -> view('api_views/allapi.php');

    }

    public function delete_documents()
    {
        $this ->load ->view('api_views/delete_documents.php');

    }
     public function forget_password()
    {
        $this ->load ->view('api_views/forget_password.php');

    }
  public function update_password()
    {
        $this ->load ->view('api_views/update_password.php');

    }
    public function add_documents()
    {
        $this ->load ->view('api_views/add_documents.php');

    }
    public function get_documents()
    {
        $this->load->view('api_views/get_documents.php');
    }

    public function signup()
    {
        $this->load->view('api_views/signup.php');
    }
    public function login()
    {
        $this->load->view('api_views/login.php');
    }
}
