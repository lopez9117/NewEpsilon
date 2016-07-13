<?php
require_once("../../dbconexion/conexion.php");
$cn = conectarse();

$user = $_GET['user'];
//obtener datos del funcionario
$sql = mysql_query("SELECT nombres, apellidos FROM funcionario WHERE idfuncionario = '$user'", $cn);
$reg = mysql_fetch_array($sql);	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<style type="text/css">
body
{font-family:Arial, Helvetica, sans-serif;
font-size:12px;
}
 div
 {
	 width:80%; height:70%; margin-top:5%; margin-left:10%;
 }
 h1
 {
	 font-family:Arial, Helvetica, sans-serif;
	 color:#006;
	 font-size:38px;
	 padding:inherit;
	 position:relative;}
	 
	 h2
 {
	font-family:Arial, Helvetica, sans-serif;
	 color:#006;
	 font-size:20px;}
	  h3
 {
	 font-family:Arial, Helvetica, sans-serif;
	 color:#006;
	 font-size:15px;}
	 
</style>
<body>
<div>
<h1>Bienvenido !</h1>
<h3><?php echo $reg['nombres'].'&nbsp;'.$reg['apellidos']?></h3>
<h2>A su sistema de información radiologia (RIS) en &epsilon;psilón</h2>
</div>
</body>
</html>