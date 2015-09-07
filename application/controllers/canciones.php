<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Canciones extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */

    function __construct()
    {
        parent::__construct();

        //$this->load->model('add_xsd_model');

        $this->load->helper('directory');
        $this->load->helper('file');
        $this->load->library('table');
        $this->load->model('folder_model');
        $this->load->model('canciones_model');
        $this->load->model('perfiles_model');

        $this->load->helper('form');
        $this->load->library('form_validation');

        require_once(APPPATH.'libraries/getid3/getid3.php');
        require_once(APPPATH.'libraries/getid3/write.php');

        //    $this->load->library('session');



    }
    function bin2text($bin_str)
    {
        $text_str = '';
        $chars = EXPLODE("\n", CHUNK_SPLIT(STR_REPLACE("\n", '', $bin_str), 8));
        $_I = COUNT($chars);
        FOR($i = 0; $i < $_I; $text_str .= CHR(BINDEC($chars[$i])), $i  );
        RETURN $text_str;
    }

    public function tagReader($file){


    $id3v23 = array("TIT2","TALB","TPE1","TRCK","TDRC","TLEN","USLT");
    $id3v22 = array("TT2","TAL","TP1","TRK","TYE","TLE","ULT");
    $fsize = filesize($file);
    $fd = fopen($file,"r");
    $tag = fread($fd,$fsize);

    $tmp = "";
    fclose($fd);
      //  echo substr($tag,0,3);

    if (substr($tag,0,3) == "ID3") {
        $result['FileName'] = $file;
        $result['TAG'] = substr($tag,0,3);
        $result['Version'] = hexdec(bin2hex(substr($tag,3,1))).".".hexdec(bin2hex(substr($tag,4,1)));


        if($result['Version'] == "4.0" || $result['Version'] == "3.0"){

            for ($i=0;$i<count($id3v23);$i++){
                if (strpos($tag,$id3v23[$i].chr(0))!= FALSE){
                    $pos = strpos($tag, $id3v23[$i].chr(0));
                    $len = hexdec(bin2hex(substr($tag,($pos+5),3)));
                    $data = substr($tag, $pos, 10+$len);
                    for ($a=0;$a<strlen($data);$a++){
                        $char = substr($data,$a,1);
                        if($char >= " " && $char <= "~") $tmp.=$char;
                    }
                    if(substr($tmp,0,4) == "TIT2") $result['Title'] = substr($tmp,4);
                    if(substr($tmp,0,4) == "TALB") $result['Album'] = substr($tmp,4);
                    if(substr($tmp,0,4) == "TPE1") $result['Author'] = substr($tmp,4);
                    if(substr($tmp,0,4) == "TRCK") $result['Track'] = substr($tmp,4);
                    if(substr($tmp,0,4) == "TDRC") $result['Year'] = substr($tmp,4);
                    if(substr($tmp,0,4) == "TLEN") $result['Lenght'] = substr($tmp,4);
                    if(substr($tmp,0,4) == "USLT") $result['Lyric'] = substr($tmp,7);
                    $tmp = "";
                }
            }
        }
        if($result['Version'] == "2.0"){

            for ($i=0;$i<count($id3v22);$i++){
                if (strpos($tag,$id3v22[$i].chr(0))!= FALSE){
                    $pos = strpos($tag, $id3v22[$i].chr(0));
                    $len = hexdec(bin2hex(substr($tag,($pos+3),3)));
                    $data = substr($tag, $pos, 6+$len);
                    for ($a=0;$a<strlen($data);$a++){
                        $char = substr($data,$a,1);
                        if($char >= " " && $char <= "~") $tmp.=$char;
                    }
                    if(substr($tmp,0,3) == "TT2") $result['Title'] = substr($tmp,3);
                    if(substr($tmp,0,3) == "TAL") $result['Album'] = substr($tmp,3);
                    if(substr($tmp,0,3) == "TP1") $result['Author'] = substr($tmp,3);
                    if(substr($tmp,0,3) == "TRK") $result['Track'] = substr($tmp,3);
                    if(substr($tmp,0,3) == "TYE") $result['Year'] = substr($tmp,3);
                    if(substr($tmp,0,3) == "TLE") $result['Lenght'] = substr($tmp,3);
                    if(substr($tmp,0,3) == "ULT") $result['Lyric'] = substr($tmp,6);
                    $tmp = "";
                }
            }
        }

        return $result;
    }

    }
//
    public function tagWriter($file, $songdata){
        $getID3 = new getID3;
        $TextEncoding = 'UTF-8';
        $getID3->setOption(array('encoding'=>$TextEncoding));
        $tagwriter = new getid3_writetags;
        $tagwriter->filename = $file;
     //   print_r(base_url($file));
        $tagwriter->tagformats = array('id3v2.3');
        $tagwriter->overwrite_tags = true;
        $tagwriter->tag_encoding = $TextEncoding;
        //$tagwriter->remove_other_tags = true;

        $TagData = array(
            'title'         => array($songdata['titulo']),
            'artist'        => array($songdata['artista']),
            'album'         => array($songdata['album']),
            'comment'       => array('Tag creada por MusicBox'),
        );
        $tagwriter->tag_data = $TagData;

        if ($tagwriter->WriteTags()) {
            echo 'Successfully wrote tags<br>';
            if (!empty($tagwriter->warnings)) {
                echo 'There were some warnings:<br>'.implode('<br><br>', $tagwriter->warnings);
            }
        } else {
            echo 'Failed to write tags!<br>'.implode('<br><br>', $tagwriter->errors);
        }
    }

    public function sincronizar() {

        $map = $this->folder_model->iterate();


        $numCanciones = 0;
        foreach ($map as $item) {
            $file =   'musica/' .$this->session->userdata('username').'/'. $item;

            $isInDB = $this->canciones_model->exists($file);

            if (!$isInDB)
            {
            $result =  $this->tagReader($file);
            //print_r( $result);
            if (!isset($result['Title']))
                $result['Title'] = "";
            if (!isset($result['Album']))
                $result['Album'] = "";
            if (!isset($result['Author']))
                $result['Author'] = "";

            $this->canciones_model->insertar_cancion($file, $result, $this->session->userdata('username'));
            $numCanciones++;
            }
        }



        redirect('canciones');
    }
    public function edit($id){

        $cancion = $this->canciones_model->obtener_una_cancion($id);
        $data['cancion'] = $cancion;

        $this->form_validation->set_rules('titulo', 'Titulo', 'xss_clean');
        $this->form_validation->set_rules('artista', 'Artista', 'xss_clean');
        $this->form_validation->set_rules('album', 'Album', 'xss_clean');

        $this->form_validation->set_error_delimiters('<br /><span class="error">', '</span>');

        if ($this->form_validation->run() == FALSE) // validation hasn't been passed
        {

            $this->load->view('canciones_edit', $data);
        }
        else // passed validation proceed to post success logic
        {
            // build array for the model

            $form_data = array(
                'id'  => $id,
                'titulo' => set_value('titulo'),
                'artista' => set_value('artista'),
                'album' => set_value('album')
            );

            // run insert model to write data to db

            if ($this->canciones_model->cambiar_cancion($form_data) == TRUE) // the information has therefore been successfully saved in the db
            {
                $this->tagWriter($this->canciones_model->obtener_ubicacion($id), $form_data);

                redirect('canciones');   // or whatever logic needs to occur
            }
            else
            {
                echo 'An error occurred saving your information. Please try again later';
                // Or whatever error handling is necessary
            }
        }
    }

    public function copiar_perfil(){
        $this->form_validation->set_rules('values', 'values', '');

        $this->form_validation->set_error_delimiters('<br /><span class="error">', '</span>');

        if ($this->form_validation->run() == FALSE) // validation hasn't been passed
        {
            redirect('canciones');
        }
        else // passed validation proceed to post success logic
        {
            // build array for the model

            $cancionesselect = $this->input->post("values");


            foreach ($cancionesselect as $cancionselect){
               $this->perfiles_model->copiar_cancionperfil($cancionselect, $this->input->post("perfiles"));
            }
            redirect('canciones');
        }


    }

    public function index()
    {


        //$tablehead =  $this->table->generate();

        $data['table']  = $this->canciones_model->obtener_canciones($this->session->userdata('username'));

        $query = $this->perfiles_model->obtener_nombre_perfiles($this->session->userdata('userid'));
;
        foreach ($query->result() as $row) {

        $perfiles[$row->Id] = $row->nombre;
        }
        $data['perfiles'] = $perfiles;
        $this->load->view('canciones', $data);

    }

}



