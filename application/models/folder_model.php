<?php

class Folder_model extends CI_Model {

    function iterate() {
    $this->load->helper('directory');
    $directory =  '../web/musica/'.$this->session->userdata('username');
    //echo  $directory ;
        $map = directory_map($directory, 1);
    return $map;
}

}

