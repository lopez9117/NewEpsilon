<?php 
	//archivo de conexion
	require_once("../../../../dbconexion/conexion.php");
	$cn = conectarse();
	//declaracion de variables
	$informe = $_POST['informe'];
	$idInforme = $_POST['idInforme'];
	$observacion = $_POST['observacionTranscripcion'];
	$usuario = $_POST['usuario'];
	$opcion = $_POST['opcion'];
	$sdate = date("Y")."-".date("m")."-".date("d");
	$stime = date("h").":".date("i");
	//variables encriptadas
	$id = base64_encode($idInforme);
	$user = base64_encode($usuario);
	//modificar el contenido del informe
	mysql_query("UPDATE r_detalle_informe SET detalle_informe = '$informe' WHERE id_informe = '$idInforme'", $cn);
	//mysql_query("UPDATE r_informe_header SET id_estadoinforme = '5' WHERE id_informe = '$idInforme'", $cn);
	//registrar observaciones
	if($observacion!="")
	{
		mysql_query("INSERT INTO r_observacion_informe VALUES('$idInforme','$usuario','$observacion')", $cn);
	}
	//devolver al informe previamente guardado
	echo '<script language="javascript">location.href = "RevisarAprobar.php?informe='.$id.'&user='.$user.'"</script>';
?>