<?php
session_start();
include("conexion.php");
$link=conectarse();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cellarway</title>

<link rel="stylesheet" type="text/css" href="template.css" />
<script language="JavaScript" src="richedit.js"></script>

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
	
  <div class="contenedorcontenido">
  <?php //Noticia seleccionada
$id = $_GET['id'];

$noticia = mysql_query("SELECT * FROM noticias WHERE id='$id'",$link); //Seleccion de categoria NOTICIAS
	

while($row = mysql_fetch_array($noticia)) //Mientras haya datos...imprime todas las noticias de la consulta
{
/*$var = explode('-',$row["fecha"]);//Obtiene la fecha y la pone en cristiano entendible
$fecha_user="$var[2]-$var[1]-$var[0]"; */

echo "
<div class='contenido'>
<h1><a href='noticia?id=".$row['id']."'>".$row['titular']."</a></h1>
<p>".$row['descripcion']."</p>
<p><br />Escrito por: <b>".$row['usuario']."</b> el ".$row['fecha']."</p>
</div>
";
}
?>
</div>
 
  
  <div class="contenedordetalle">
 	<?php //lista de detalles
	 $detalles = mysql_query("SELECT * FROM noticias WHERE categoria='Detalle' ORDER BY id DESC LIMIT 0 , 5",$link); //Seleccion de categoria NOTICIAS		

		while($row = mysql_fetch_array($detalles)) //Mientras haya datos...imprime todas las noticias
		{		  
		  echo "<div class='detalle'><b>".$row['usuario']."</b> ".$fecha_user."
		  <p>".$row['descripcion']."</p></div>";  
		}
	?>
  </div>
  
  <?php //COMIENZO DE LA INSERCION DE COMENTARIOS Y LA MUESTRA DE LOS MISMOS
  // if register_globals is off:
  if(isset($_REQUEST['richEdit0'])) $richEdit0 = $_REQUEST['richEdit0'];

  if($richEdit0) {
    if(get_magic_quotes_gpc()) $richEdit0 = stripslashes($richEdit0);
	
	
	if(isset($_REQUEST['nombrecomentario'])) $nombrecomentario = $_REQUEST['nombrecomentario'];

  if($nombrecomentario) {
    if(get_magic_quotes_gpc()) $nombrecomentario = stripslashes($nombrecomentario);

	    //Inserta el comentario
	//primero adivina cual es el ID del ultimo comentario
	$ultimocomentario = mysql_query("SELECT id FROM comentarios ORDER BY id ASC", $link);
			  
	while($row = mysql_fetch_array($ultimocomentario)) //Mientras haya datos...
    { 
	$ultimomsg = $row['id'];
	}	  	
	$ultimomsg +=1;
	
	$n_comentarios = mysql_num_rows(mysql_query("SELECT mensaje FROM comentarios",$link));
	if($n_comentarios == 0){
	$ultimomsg=1;
	}
	$ip = $_SERVER['REMOTE_ADDR'];

	$ahora = date("d-m-Y (H:i)");
    mysql_query("INSERT INTO comentarios VALUES ('$ultimomsg', '$nombrecomentario', '$ahora', '$richEdit0','$id', '$ip')",$link);
  }
  }
?>
  
  <div id="contenedorcomentario">
   	<?php //lista de comentarios
	 $comentarios = mysql_query("SELECT id,usuario, fecha, mensaje FROM comentarios WHERE titular=$id ORDER BY fecha ASC",$link); //Seleccion de categoria NOTICIAS		

		while($row = mysql_fetch_array($comentarios)) //Mientras haya datos...imprime todas las noticias
		{		  	
		
		  echo "
		  <div class='comentario'>
		  ".$row['mensaje']."
		  <p align='right'>Lo dijo: <b>".$row['usuario']."</b> el ".$row['fecha']."</p>
		  </div>";
		}
	?>
    



    

<div class="contenedorcontenido" style="padding-left: 0px; margin-left: 0px; padding-top:10px;">
<div class="comentario" style="background-image:none; background-color: #9fdf4c; width:93%;">

<form name="f1" action="noticia.php?id=<?php echo $id;?>" method="post">
<script language="JavaScript"> <!--
var editor = new EDITOR();
<?php
  if(!get_magic_quotes_runtime()) $richEdit0 = addslashes($richEdit0);
  
  if(!get_magic_quotes_runtime()) $nombrecomentario = addslashes($nombrecomentario);
?>
editor.create("<br>");
//--> </script>
<br />
</form>
</div>
</div>


</div>

</div>

<div style="clear:both;">
<?php
		if($sesion==1 OR $sesion==2){
		echo "<A HREF='unlog.php'>Cerrar sesion</A>";
		}
		else
		echo "<A HREF='login.php'>Login</A>";
?>
</div>

</body>
</html>