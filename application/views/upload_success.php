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

    <li><a href="<?php echo base_url().'index.php/canciones/' ?>">Canciones</a></li>
<li><a href="#">Configuracion</a></li>
<li></li>
<li></li>
</ul>
</div> 
  </div>
  <div class="sidebar1">
    <ul class="nav">

      <li><a href="#">Hola, <?php print_r( $this->session->userdata('username')) ?></a></li>
      <li><a href="<?php echo base_url().'index.php/upload/' ?>">Subir Canciones</a></li>
      <li><a href="#">Vínculo cuatro</a></li>
      <li><a href="<?php echo base_url().'index.php/principal/do_logout'; ?> ">Salir!</a></li>
    </ul>
    <p>&nbsp;</p>
    <!-- end .sidebar1 --></div>
  <div class="content">
    <h1>Subida de archivos: Tu archivo se ha subido correctamente </h1>
    <!-- end .content -->

      <?php foreach ($upload_data as $item => $value):?>
          <li><?php echo $item;?>: <?php echo $value;?></li>
      <?php endforeach; ?>
      </ul>
      <p><?php echo anchor('upload', 'Subir otro fichero'); ?></p>

  </div>
  <div class="footer">
    <p>&nbsp;</p>
    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
</html>
