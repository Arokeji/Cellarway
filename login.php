<?php
session_start();

include('conexion.php');
$link=conectarse();

$usuario = $_POST['txt_usuario'];
session_register(usuario);
/*echo "<script>alert('".$usuario."')</script>";*/

$password = $_POST['txt_password'];
session_register(password);

$usuarios = mysql_query("SELECT * FROM usuarios",$link);

while($row = mysql_fetch_array($usuarios)) //Mientras haya datos Y COINCIDAN
{ 
if($usuario==$row['usuario'] AND $password==$row['password']){
$ip = $_SERVER['REMOTE_ADDR']; 
$registro = mysql_query("INSERT INTO registro VALUES ('$usuario', NOW(),'$ip' )",$link);
if($row['administrador'] == 1)
$sesion = 1;
else
$sesion = 2;
session_register(sesion);
}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cellarway</title>

<link rel="stylesheet" type="text/css" href="template.css" />

</head>

<body>

<div id="contenedor">
	<div id="menu">
	<ul>
	<li><a href="index.php">Home | </a></li>
	<li><a href="#">Bio | </a></li>
	<li><a href="#">Sonido/video | </a></li>
    <li><a href="#">Album | </a></li>
    <li><a href="#">Conciertos | </a></li>
	</ul>
  </div>
 
 <div class="contenido" style="width: 96%; text-align:center;">
      
  <?php
if($sesion == 0)
  echo "     
	<form action='login.php' method='post' name='formulario'>
   		<p style='margin-left: 20px; margin-top:20px;'>Usuario <input name='txt_usuario' type='text' size='20' maxlength='40' /></p>
  	 	<p style='margin-bottom:20px;'>Contraseña <input name='txt_password' type='password' size='20' maxlength='40' /></p>
  	    <p align='center'><input type='submit' name='login' value='Acceder'></p>
	</form>
	";
if($sesion==1){
	echo "Bienvenido administrador ".$usuario.".";
	echo "<meta http-equiv='refresh' content='2;URL=index.php'>";
	}
if($sesion==2){
	echo "Bienvenido ".$usuario.".";
	echo "<meta http-equiv='refresh' content='2;URL=index.php'>";
	}
?>
  </div>
</div>

</body>
</html>