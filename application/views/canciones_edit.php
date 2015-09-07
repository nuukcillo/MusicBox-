<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- TemplateBeginEditable name="doctitle" -->
<title>Bienvenido</title>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
    <?php echo link_tag('css/styles.css'); ?>
</head>

<body>

<div class="container">
  <div class="header"><a href="#"><img src="<?php echo base_url(); ?>imagenes/logo.png" width="80" height="80" alt="MusicBox+"></a> 
    <!-- end .header -->`</div>
  <div class="topbar">
<div id="navcontainer">
<ul>
<li><a href="<?php echo base_url().'index.php/principal/' ?>">Mi Perfil</a></li>
    <li><a href="<?php echo base_url().'index.php/perfiles/' ?>">Perfiles</a></li>

    <li><a href="<?php echo base_url(); ?>index.php/canciones">Canciones</a></li>
<li><a href="#">Configuracion</a></li>
<li></li>
<li></li>
</ul>
</div> 
  </div>
  <div class="sidebar1">
    <ul class="nav">

      <li><a href="#">Hola, <?php print_r( $this->session->userdata('username')) ?></a></li>
      <li><a href="<?php echo base_url().'index.php/canciones/sincronizar/'.$this->session->userdata('username'); ?> ">Sincronizar</a></li>
      <li><a href="#">Vínculo cuatro</a></li>
      <li><a href="<?php echo base_url().'index.php/principal/do_logout'; ?> ">Salir!</a></li>
    </ul>
    <p>&nbsp;</p>
    <!-- end .sidebar1 --></div>
  <div class="content">

      <?php

      echo form_open('canciones/edit/'.$cancion['id']); ?>
        <h4>Advertencia: Estos tags tambien se escribiran en la cancion seleccionada</h4>
      <p>
          <label for="titulo">Titulo</label>
          <?php echo form_error('titulo'); ?>
          <br /><input id="titulo" type="text" name="titulo"  value="<?php echo set_value('titulo',$cancion['titulo']); ?>"  />
      </p>

      <p>
          <label for="artista">Artista</label>
          <?php echo form_error('artista'); ?>
          <br /><input id="artista" type="text" name="artista"  value="<?php echo set_value('artista',$cancion['artista']); ?>"  />
      </p>

      <p>
          <label for="album">Album</label>
          <?php echo form_error('album'); ?>
          <br /><input id="album" type="text" name="album"  value="<?php echo set_value('album',$cancion['album']); ?>"  />
      </p>


      <p>
          <?php echo form_submit( 'submit', 'Cambiar'); ?>
          <?php $js = 'onClick=history.go(-1);';

          echo form_button('backbutton', 'Atrás', $js);?>
      </p>

      <?php echo form_close(); ?>
    <!-- end .content --></div>
  <div class="footer">
    <p>&nbsp;</p>
    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
</html>
