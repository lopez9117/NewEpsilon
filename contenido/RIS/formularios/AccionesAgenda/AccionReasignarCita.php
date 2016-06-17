<?php
	//conexion a la BD
	require_once("../../../../dbconexion/conexion.php");
	$cn = conectarse();
	//variables con post
	$idInforme = $_POST['idInforme'];
	$observaciones = $_POST['observaciones'];
	$usuario = $_POST['usuario'];
	$estudio = $_POST['estudio'];
	$tecnica = $_POST['tecnica'];
	//$nuevafecha = $_POST['nfecha'];
	$nuevahora = $_POST['nhora'];
	$nuevafecha = date("Y-m-d",strtotime($_POST['nfecha']));
	//variables del sistema
	$fecha = date("Y-m-d");
	$hora = date("G:i:s");
	if($nuevafecha=="1969-12-31")
	{
	echo '<font size="2" color="#FF0000">Los campos señalados con * son obligatorios</font>';
	}
	else
	{
	//eliminar informacion anterior del informe
	mysql_query("DELETE FROM r_log_informe WHERE id_informe = '$idInforme'", $cn);
	//actualizar registro y ponerlo nuevamente en la agenda
	mysql_query("UPDATE r_informe_header SET id_estadoinforme = 1, idestudio = '$estudio', id_tecnica='$tecnica', idfuncionario_esp = '0', idfuncionario_trans = 0, idfuncionario_take = 0 WHERE id_informe = '$idInforme'", $cn);
	mysql_query("INSERT INTO r_log_informe VALUES('$idInforme','$usuario','1','$nuevafecha','$nuevahora')", $cn);
	//insertar una observacion
	mysql_query("INSERT INTO r_observacion_informe VALUES('$idInforme','$usuario','$observaciones','$fecha','$hora')", $cn);
	echo '<font color="#006600"><strong>reasignado exitosamente !</strong></font>';
	}?>