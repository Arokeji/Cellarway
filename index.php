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
<script language="JavaScript" src="insertnoticia.js"></script>
</head>

<body>

<div id="contenedor">
 <div id="menu">
	<ul>
	<li><a href="">Home | </a></li>
	<li><a href="#">Bio | </a></li>
	<li><a href="#">Sonido/video | </a></li>
    <li><a href="#">Album | </a></li>
    <li><a href="#">Conciertos | </a></li>
	</ul>
  </div>
	
    
  <div class="contenedorcontenido">
  <form method="post" name="consultanoticia" action="index.php">
    <?php //COMIENZO DE LA INSERCION DE NOTICIAS Y LA MUESTRA DE LAS MISMAS
  // if register_globals is off:
  if(isset($_REQUEST['richEdit0'])) $richEdit0 = $_REQUEST['richEdit0'];

  if($richEdit0) {
    if(get_magic_quotes_gpc()) $richEdit0 = stripslashes($richEdit0);
	
	
	if(isset($_REQUEST['titular'])) $titular = $_REQUEST['titular'];

  if($titular) {
    if(get_magic_quotes_gpc()) $titular = stripslashes($titular);
	
	 
//Inserta la noticia
	//primero adivina cual es el ID de la ultima noticia
	$ultimocomentario = mysql_query("SELECT id FROM noticias ORDER BY id ASC", $link);
			  
	while($row = mysql_fetch_array($ultimocomentario)) //Mientras haya datos...
    { 
	$ultimomsg = $row['id'];
	}	  	
	$ultimomsg +=1;
	
	$n_comentarios = mysql_num_rows(mysql_query("SELECT descripcion FROM noticias",$link));
	if($n_comentarios == 0){
	$ultimomsg=1;
	}

	$ahora = date("d-m-Y (H:i)");
    mysql_query("INSERT INTO noticias VALUES ('$ultimomsg', '$titular', '$richEdit0', '$ahora', '$usuario', 'Noticia')",$link);
}
}
	 
$num=4; //Numero de noticias por pagina
$click=0;
$comienzo=$_GET['comienzo']; //Obtiene el nº de pagina anterior

if(!isset($comienzo))
$comienzo=0; //Si la pagina carga y comienzo no tiene ningun valor, comienzo valdrá 0

$noticias = mysql_query("SELECT * FROM noticias WHERE categoria='Noticia' ORDER BY id DESC LIMIT $comienzo , $num",$link); //Seleccion de categoria NOTICIAS

$click=1;			

while($row = mysql_fetch_array($noticias)) //Mientras haya datos...imprime todas las noticias
{

echo "
<div class='contenido'>
<h1><a href='noticia?id=".$row['id']."'>".$row['titular']."</a></h1>
<p>".$row['descripcion']."</p>

<br /><br /><p align='right'>Escrito por: <b>".$row['usuario']."</b> el ".$row['fecha']."

";

//comentarios que tiene esta entrada
$n_comentarios = mysql_num_rows(mysql_query("SELECT mensaje FROM comentarios WHERE titular='".$row['id']."'",$link));

echo "
<br /><a href='noticia?id=".$row['id']."'>".$n_comentarios." comentarios</a><p>
</div>
";
}
?>
</form>
<?php /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		 //BOTONES SIGUIENTE Y ATRAS
$cantidad = mysql_query("SELECT * FROM noticias", $link); // Consulta de todas las filas de la tabla
$cuantas = mysql_num_rows($cantidad); //Obtiene el nº de filas totales de la tabla 
			
			echo "<table border='0' width='490px' style='margin-left: 8px;'>
					<tr>
						<td width='34%' align='left'>";
			if($comienzo!=0)//Si no es la primera pagina, en este cuadrante aparece "ATRAS"
			echo "<A HREF='" . $_SERVER['PHP_SELF'] . "?comienzo=" . ($comienzo - $num) ."'><p class='style12'><strong>&lt;&lt;Más actuales</strong></A>";
			
			echo "</td>
			<td width='34%' align='center'><p class='style12'>
			";
			//FIN ATRAS <----------------------------
			$contador=0;
			$pagina=1;
			while($row = mysql_fetch_array($cantidad)) //Mientras haya datos...
         { 
			if($contador==0){
			if (($comienzo/$num+1)!=$pagina){
			echo "<A HREF='". $_SERVER['PHP_SELF'] . "?comienzo=" . (($pagina-1)*$num) . "'>".$pagina."</A>";
			echo "&nbsp;";
			}
			else{
			echo $pagina;
			echo "&nbsp;";
			}
			$pagina = $pagina + 1;
			}
			
		 	$contador = $contador + 1;
			if($contador==$num)
			$contador=0;
		 }
		 
		 			echo "
				</td>
				  <td width='40%' align='right'>";
		 
		 //SIGUIENTE-------------------------->

			
			if(($comienzo==0 OR ($comienzo + $num)< $cuantas) AND $cuantas>$num)//SIGUIENTE
			echo "<A HREF='". $_SERVER['PHP_SELF'] . "?comienzo=" . ($comienzo + $num) . "'><p class='style12'><strong>Más antiguos>></strong></A>";
			
			echo "</p></td>
				</table>";
			
			//BOTONES SIGUIENTE Y ATRAS FIN
			

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77			
?> 

</div>
 
  
  <div class="contenedordetalle">
 	<?php //lista de detalles
	 $detalles = mysql_query("SELECT * FROM noticias WHERE categoria='Detalle' ORDER BY id DESC LIMIT $comienzo , $num",$link); //Seleccion de categoria NOTICIAS		

		while($row = mysql_fetch_array($detalles)) //Mientras haya datos...imprime todas las noticias
		{		  
		  echo "<div class='detalle'><b>".$row['usuario']."</b> ".$fecha_user."
		  <p>".$row['descripcion']."</p></div>";  
		}
	?>
  </div>
  
  
  
</div>
 
 <div style="clear:both;">
 <div align="center">
    <?php

		if($sesion==1 OR $sesion==2){
		echo "
		<form name='f1' action='index.php' method='post'>
<script language='JavaScript'> <!--
var editor = new EDITOR();
<?php
  $richEdit0 = preg_replace('/\r|\n/', '', $richEdit0);
  if(!get_magic_quotes_runtime()) $richEdit0 = addslashes($richEdit0);
  
    $nombrecomentario = preg_replace('/\r|\n/', '', $nombrecomentario);
  if(!get_magic_quotes_runtime()) $nombrecomentario = addslashes($nombrecomentario);
?>
editor.create('<br>');
//--> </script>
<br />
</form>
";
}
	?>
    </div>
  </div>
  
  <div style="background-color:#FFCC00">
    <?php
		if($sesion==1 OR $sesion==2){
  		echo "NOTAS AL ADMINISTRADOR:<br />Para que la imagen se coloque correctamente se debe adjuntar <b>antes</b> que el texto.<br />Para escribir una comilla simple has escribirla dos veces.<br /> Si no se ha escrito la noticia comprueba que has escrito el titular.<br />El ancho de una imagen para que se ajuste perfectamente a la capa es de 390px (Se recomienda eliminar los margenes).";
  		}
    ?>
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