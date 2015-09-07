<h1><?=$virtual_root?></h1>
<h2><?='/'.$path_in_url?></h2>
<?php
$prefix = $controller.'/'.$virtual_root.'/'.$path_in_url;
if (!empty($dirs)) foreach( $dirs as $dir )
    echo 'd '.anchor($prefix.$dir['name'], $dir['name']).'<br>';

if (!empty($files)) foreach( $files as $file )
    echo anchor($prefix.$file['name'], $file['name']).'<br>';
?>