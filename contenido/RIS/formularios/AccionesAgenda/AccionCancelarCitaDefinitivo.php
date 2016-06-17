<?php
	//conexion a la BD
	require_once("../../../../dbconexion/conexion.php");
	$cn = conectarse();
	//variables POST
	
	$idInforme = $_POST['idInforme'];
	$usuario = $_POST['usuario'];
	//variables del sistema
	$fecha = date("Y-m-d");
	$hora = date("G:i:s");
	//consulta
	mysql_query("UPDATE r_log_informe SET id_estadoinforme = 6, fecha = '$fecha', hora = '$hora', idfuncionario = '$usuario' WHERE id_informe = '$idInforme'", $cn);
	mysql_query("UPDATE r_informe_header SET id_estadoinforme = 6 WHERE id_informe = '$idInforme'", $cn);
?>