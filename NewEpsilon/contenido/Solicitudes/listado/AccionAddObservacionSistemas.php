<?php
	//conexion a la BD
	session_start();
	$CurrentUser = $_SESSION[currentuser];
	require_once("../../../dbconexion/conexion.php");
	$cn = conectarse();
	$observacion = utf8_encode($_POST[observacion]);
	$idinforme = $_POST[informe];
	$Fecha=date("Y/m/d");
	$time = date("g:i:s A");
	//insersion en la bd
	mysql_query("INSERT INTO observaciones VALUES ($idinforme,$CurrentUser,'$Fecha','$time','$observacion')", $cn);
	//codificar variables
	echo '<script language="javascript">
		location.href="detalle.php?id='.$idinforme.'"
		</script>';
?>
