<?php

class Perfiles_model extends CI_Model {
//TODO: lo mismo que en canciones model
    function contar_perfiles ($user){

        $this->db->select('id')->where('username', $user);
        $idUser = $this->db->get('usuarios')-> result_array()[0]['id'];

        $this->db->select('*')->where('usuario', $idUser);

        return $this->db->count_all_results('perfiles');

    }

    function obtener_nombre_perfiles($id) {
        $this->db->select('Id, nombre')->where('usuario', $id);

        return $this->db->get('perfiles');
    }
    function obtener_perfiles($user) {
        $this->db->select('id')->where('username', $user);
        $idUser = $this->db->get('usuarios')-> result_array()[0]['id'];

        $this->db->select('*')->where('usuario', $idUser);

        return $this->db->get('perfiles')->result_array();

    }
    function obtener_un_perfil($id) {
        $this->db->select('*')->where('Id', $id);

        return $this->db->get('perfiles')->row_array();

    }
    function borrar_perfil($id){
        $data = array(
            'perfil_Id' => 1
        );
        $this->db->where('perfil_Id', $id)->update('cancionesperfiles', $data);

        $this->db->where('Id', $id);
        return $this->db->delete('perfiles');

    }
    function cambiar_perfil($data, $idUser){



        $this->db->where('id', $idUser);
        return $this->db->update('perfiles', $data);



    }
    function insertar_perfil($data, $idUser){


        $data ['usuario'] = $idUser;
        return $this->db->insert('perfiles', $data);



    }
    function cambiar_cancionperfil($cancion, $perfilold, $perfilnew){
        $this->db->where('cancion_Id', $cancion)->where('perfil_Id', $perfilold);
        $data['perfil_Id'] = $perfilnew;
        return $this->db->update('cancionesperfiles', $data);
    }
    function copiar_cancionperfil($cancion, $perfilnew){
        $data['perfil_Id'] = $perfilnew;
        $data['cancion_Id'] = $cancion;


        return $this->db->insert('cancionesperfiles', $data);
    }
}

