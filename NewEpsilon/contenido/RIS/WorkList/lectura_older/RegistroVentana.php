<?php

//archivo de conexion
	require_once("../../../../dbconexion/conexion.php");
	$cn = conectarse();
	//variables post
$idInforme = $_POST['informe'];
$especialista = $_POST['especialista'];
//registrar la ventana para evitar el uso simultaneo
		mysql_query("INSERT INTO r_estadoventana VALUES ('$idInforme','$especialista')", $cn);
?>