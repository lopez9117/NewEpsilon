<?php
	include("../../../../dbconexion/conexion.php");
	$cn = conectarse();
	$idInforme = $_POST['informe'];
	mysql_query("DELETE FROM r_estadoventana WHERE id_informe = '$idInforme'", $cn);
?>