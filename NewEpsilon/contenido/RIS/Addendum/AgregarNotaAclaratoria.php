<?php
	//conexion a la BD
	require_once("../../../dbconexion/conexion.php");
	$cn = conectarse();
	$Nota = $_POST['NotaAclaratoria'];
	$usuario = $_POST['usuario'];
	$idinforme = $_POST['idInforme'];
	$fecha = date("Y-m-d");
	$hora = date("G:i:s");
	//insersion en la bd
	mysql_query("INSERT INTO r_nota_aclaratoria VALUES('$idinforme','$Nota','$usuario','$fecha $hora')", $cn);
	//codificar variables
	$info = base64_encode($idinforme);
	$user = base64_encode($usuario);
	echo '<script language="javascript">
		location.href="CrearAddemdum.php?informe='.$info.'&usuario='.$user.'"
	</script>';
	mysql_close($cn);
?>