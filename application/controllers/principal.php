<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Principal extends CI_Controller {


	    function __construct()
    {
        parent::__construct();

		$this->check_isvalidated();
        $this->load->helper('html');
        $this->load->model('perfiles_model');


    }
	public function index()
	{
        $data['perfilescount'] = $this->perfiles_model->contar_perfiles ($this->session->userdata('username'));
		$this->load->view('principal', $data);


	}



    
    private function check_isvalidated(){
        if(! $this->session->userdata('validated')){
            redirect('login');
        }
    }
    
    public function do_logout(){
        $this->session->sess_destroy();
        redirect('login');
    }
 }
 ?>