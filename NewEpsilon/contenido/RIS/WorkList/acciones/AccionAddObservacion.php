<?php
	//conexion a la BD
	require_once("../../../../dbconexion/conexion.php");
	$cn = conectarse();
	$observacion = $_POST['observacion'];
	$usuario = $_POST['usuario'];
	$idinforme = $_POST['informe'];
	$tipo_comentario = $_POST['tipo_comentario'];
	$fecha = date("Y-m-d");
	$hora = date("G:i:s");
	//insersion en la bd
	mysql_query("INSERT INTO r_observacion_informe VALUES('$idinforme','$usuario','$observacion','$fecha','$hora', '$tipo_comentario')", $cn);
	//codificar variables
	$info = base64_encode($idinforme);
	$user = base64_encode($usuario);
	echo '<script language="javascript">
		location.href="../AddObservacion.php?idInforme='.$info.'&usuario='.$user.'"
	</script>';
?>