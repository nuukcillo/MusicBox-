<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Testid3 extends CI_Controller {

	public function index()
	{
        require_once(APPPATH.'libraries/getid3/getid3.php');
        $getID3 = new getID3;

// Analyze file and store returned data in $ThisFileInfo
        $ThisFileInfo = $getID3->analyze('musica/rick/Natalia Kills - Trouble.mp3');

        print_r($ThisFileInfo['tags']);
    }
}

