<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN'
  'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>

<head>    
    <title>MusicBox</title>
    <?php echo link_tag('css/login.css'); ?>

</head>
<body>
    <div class='login'>
        <form action='<?php echo base_url();?>index.php/login/process' method='post' name='process'>
            <br />
            <?php if(! is_null($msg)) {
               echo ' <a href="#" class="forgot">'; echo $msg; echo '</a>';

            }?>
            <input type='text' name='username'placeholder="Usuario" id='username' size='25' /><br />

            <input type='password' name='password' placeholder="Password" id='password' size='25' /><br />

            <input type='Submit' value='Entrar' />
            <div class="shadow"></div>

        </form>
    </div>
</body>
</html>