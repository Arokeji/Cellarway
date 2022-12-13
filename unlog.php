<?php
session_start();

include("conexion.php");
$link=conectarse();
 
$sesion = 0;
session_register("sesion");
/*echo "<script>history.back();</script>";*/
echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cellarway</title>

<html>
<body>
</body>
</html>
