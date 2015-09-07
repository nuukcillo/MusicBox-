<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perfiles extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        $this->load->helper('html');
        $this->load->model('perfiles_model');
        $this->load->library('table');
        $this->load->helper('form');
        $this->load->library('form_validation');


    }

	public function edit($id){

        $data['perfil'] =$this->perfiles_model->obtener_un_perfil($id);


        $this->form_validation->set_rules('nombre', 'Nombre', 'required|xss_clean');
        $this->form_validation->set_rules('descripcion', 'Descripción', 'required|xss_clean');

        $this->form_validation->set_error_delimiters('<br /><span class="error">', '</span>');

        if ($this->form_validation->run() == FALSE) // validation hasn't been passed
        {
            $this->load->view('perfilesmanag_view', $data);
        }
        else // passed validation proceed to post success logic
        {
            // build array for the model
            $form_data = array(
                'nombre' => set_value('nombre'),
                'descripcion' => set_value('descripcion')
            );

            // run insert model to write data to db

            if ($this->perfiles_model->cambiar_perfil($form_data, $this->session->userdata('userid')) == TRUE)
            {
                redirect('perfiles');   // or whatever logic needs to occur
            }
            else
            {
                echo 'An error occurred saving your information. Please try again later';
                // Or whatever error handling is necessary
            }
        }
    }
    public function add(){
        $this->form_validation->set_rules('nombre', 'Nombre', 'required|xss_clean');
        $this->form_validation->set_rules('descripcion', 'Descripción', 'required|xss_clean');

        $this->form_validation->set_error_delimiters('<br /><span class="error">', '</span>');

        if ($this->form_validation->run() == FALSE) // validation hasn't been passed
        {
            $this->load->view('perfilesadd_view');
        }
        else // passed validation proceed to post success logic
        {
            // build array for the model

            $form_data = array(
                'nombre' => set_value('nombre'),
                'descripcion' => set_value('descripcion')
            );

            // run insert model to write data to db

            if ($this->perfiles_model->insertar_perfil($form_data, $this->session->userdata('userid')) == TRUE) // the information has therefore been successfully saved in the db
            {
                redirect('perfiles');   // or whatever logic needs to occur
            }
            else
            {
                echo 'An error occurred saving your information. Please try again later';
                // Or whatever error handling is necessary
            }

    }
    }

	public function delete($id){
        $perfil =$this->perfiles_model->obtener_un_perfil($id);

        if ($perfil['nombre'] == "default") {
            echo "lo siento no puedes borrar este perfil.";
        }
        else{


        $ok = $this->perfiles_model->borrar_perfil($id);
            if ($ok == TRUE){
                redirect('perfiles');
            }
            else{
                echo "you cannot delete this profile";
            }
        }
    }
	public function index()
	{
        $data['perfiles'] = $this->perfiles_model->obtener_perfiles ($this->session->userdata('username'));
        $this->table->set_heading( 'Nombre', 'Descripcion', 'Acciones');
        foreach ($data['perfiles'] as $row) {
            $links  = anchor('perfiles/edit/'.$row['Id'] ,'Editar');
        $links .= anchor('perfiles/delete/'.$row['Id'], ' Borrar',
            array('onClick' => "return confirm('Si borras el perfil, todas las canciones pasarán al perfil por defecto. ¿Continuar?')"));
        $this->table->add_row($row['nombre'], $row['descripcion'], $links);
        }

        $data['table'] = $this->table->generate();



        $this->load->view('perfiles_view', $data);
	}
}

