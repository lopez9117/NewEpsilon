<?php
//conexion a la BD
require_once("../../../../dbconexion/conexion.php");
$cn = conectarse();
$observacion = $_POST['observacion'];
$usuario = $_POST['usuario'];
$idinforme = $_POST['informe'];
$fecha = date("Y-m-d");
$hora = date("G:i:s");
//insersion en la bd
mysql_query("INSERT INTO r_observacion_informe VALUES('$idinforme','$usuario','$observacion','$fecha','$hora', '4')", $cn);
//codificar variables
$info = base64_encode($idinforme);
$user = base64_encode($usuario);
echo '<script language="javascript">
	location.href="NotaMedica.php?idInforme='.$info.'&usuario='.$user.'"
</script>';
?>