<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        // load ci's Form and Url Helpers
        $this->load->helper(array('form', 'url'));
    }
    function index()
    {
        $this->load->view('upload', array('error' => ' ' ));
    }
    function do_upload()
    {
        $user = $this->session->userdata('username');
        print_r($_FILES);
        $config['upload_path'] = './musica/' . $user . '/';
        $config['allowed_types'] = 'zip';

        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('zipfile'))
        {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('upload', $error);
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $zip = new ZipArchive;
            $file = $data['upload_data']['full_path'];
            chmod($file,0777);
            if ($zip->open($file) === TRUE) {
                $zip->extractTo('musica/'. $user . '/');
                $zip->close();

            } else {

            }
            if(unlink($file)) {

            }
            else {
                echo 'errors occurred';
                }
            $this->load->view('upload_success', $data);
        }
    }
}
