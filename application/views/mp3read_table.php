
<?php
$this->load->library('table');
$this->table->set_heading('Nombre Fichero', 'TAG', 'Version', 'Titulo', 'Album', 'Autor', 'Pista');
$this->table->add_row($result);



