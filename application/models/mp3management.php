?php

class Mp3management extends CI_Model {

    private $table = 'items';

    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }

    function insert_mp3($FileName, $FileSize, $Folder, $Song, $Artist, $Album  , $Year, $Comment, $Genre){

//        CREATE TABLE mp3list (
//   ID int(11) NOT NULL auto_increment,
//   FileName varchar(100) NOT NULL,
//   FileSize varchar(10) NOT NULL,
//   Folder varchar(150) NOT NULL,
//   Song varchar(75) NOT NULL,
//   Artist varchar(75) NOT NULL,
//   Album varchar(50) NOT NULL,
//   Year varchar(5) NOT NULL,
//   Comment tinytext NOT NULL,
//   Genre varchar(20) NOT NULL,
//   PRIMARY KEY (ID)
//);
       $data = array ( 'Filename' => $FileName, 'FileSize' => $FileSize, 'Folder' => $Folder, 'Song' => $Song, 'Artist' => $Artist, 'Album' => $Album  , 'Year' =>  $Year, 'Comment' => $Comment,
           'Genre' => $Genre );
        $this->db->insert('mp3list',$data);

    }

}