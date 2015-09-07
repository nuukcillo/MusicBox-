<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Canciones_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->helper('form');
    }
    //TODO: quitar las consultas para el id y sacarlo de la sesion
     function exists($file ){
        // grab user input
        $this->db->where('ubicacion', $file);
        $query = $this->db->get('canciones');
        // Let's check if there are any results
        if($query->num_rows == 1)
        {
            // If there is a user, then create session data

            return true;
        }
        // If the previous process did not validate
        // then return false.
        else
            return false;
    }
     function insertar_cancion( $file, $result, $user)
    {


        //Preparacion de la cancion para insertarla en el perfil default
        $songdata = array (
           'titulo' => $result['Title'],
            'album' => $result['Album'],
            'artista' => $result['Author'],
            'ubicacion' => $file
        ) ;
        $this->db->insert('canciones', $songdata);

        $this->db->select('id')->where('ubicacion', $file);
        $idCancion = $this->db->get('canciones')-> result_array()[0]['id'];

        $this->db->select('id')->where('username', $user);
        $idUser = $this->db->get('usuarios')-> result_array()[0]['id'];

        $this->db->select('id')->where('nombre', 'default')->where('usuario', $idUser);

        $idPerfil = $this->db->get('perfiles')-> result_array()[0]['id'];

        $data = array (
            'cancion_Id' => $idCancion,
            'perfil_Id' => $idPerfil)
         ;

        $this->db->insert('cancionesperfiles', $data);




    }
     function obtener_canciones($user){

        //extraemos id usuario
        $this->db->select('id')->where('username', $user);
        $idUser = $this->db->get('usuarios')-> result_array()[0]['id'];

        $this->db->select('id, nombre')->where('usuario', $idUser);
        //extraemos numero perfiles
        $perfiles = $this->db->get('perfiles');

        //$perfiles->num_rows();
        $songstable = "";
        //$result = "";
        //para cada perfil sacamos las canciones que estan en el
        foreach ($perfiles->result() as $perfil)
        {
           // echo $perfil->id;

            $this->table->set_heading('ID', 'Titulo', 'Artista','Album', 'Acciones');
            $this->table->set_caption($perfil->nombre);

            $canciones = $this->db->select('cancion_Id')->where('perfil_Id',$perfil->id )->get('cancionesperfiles');
            foreach ($canciones->result() as $cancion){
                $rowCancion = $this->db->select('id, titulo, artista, album')
                                        ->where('id', $cancion->cancion_Id)
                                         ->get('canciones');
                foreach ($rowCancion->result() as $row)
                {

                $links  = anchor('canciones/edit/'.$row->id ,'Editar');
                $links .= anchor('canciones/delete/'.$row->id , ' Borrar');
                $this->table->add_row(form_checkbox('values[]', $row->id), $row->titulo, $row->artista, $row->album, $links);
                }
              //  $perfil->nombre;
            };
            //$this->table->set_caption($perfil->nombre);
            $songstable .= $this->table->generate();

        }
         $this->table->clear();
        //print_r($result);
        return $songstable;

    }

     function obtener_una_cancion($id){
         $query = $this->db->select('id, titulo, artista, album')
             ->where('id', $id)
             ->get('canciones');
         return $query->row_array();

     }

    function obtener_ubicacion($id){
        $query = $this->db->select('ubicacion')
            ->where('id', $id)
            ->get('canciones');
        return $query->result_array() [0]['ubicacion'];

    }
    function cambiar_cancion($data) {
        $querydata = array(
            'titulo' => $data['titulo'],
            'artista' => $data['artista'],
            'album' => $data['album']
        );

        $this->db->where('id', $data['id']);
        return $this->db->update('canciones', $querydata);

    }

    function canciones_perfil($perfil) {
        $canciones = $this->db->select('cancion_Id')->where('perfil_Id',$perfil->id )->get('cancionesperfiles');

        return $canciones;

    }


}
?>

