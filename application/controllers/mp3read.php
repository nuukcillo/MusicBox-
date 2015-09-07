<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mp3read extends CI_Controller {

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
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('directory');
        $this->load->helper('file');
        $this->load->library('table');


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

    }
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
//

    public function index()
    {
        $this->load->model('folder_model');
        $map = $this->folder_model->iterate();

        $this->table->set_heading('Titulo', 'Album', 'Autor');
        //$tablehead =  $this->table->generate();

        foreach ($map as $item) {
            $file =   "web/musica/" . $item;
            $result =  $this->tagReader($file);
          //  print_r( $result);
            $this->table->add_row($result['Title'],$result['Album'],$result['Author']);

        }
      //  print_r( $result);
        $this->load->view('mp3read_table_heading');

        echo  $this->table->generate();

        $this->load->view('mp3read_table_finish');

    }

}
       // $this->load->view('mp3read');



/* End of file welcome.php */
