<?php
	//conexion a la base de datos
	require_once('../../../dbconexion/conexion.php');
	$cn = Conectarse();
	
	$idNovedad = $_POST[idNovedad];
	
	mysql_query("DELETE FROM novedad_turno WHERE idturno='$idNovedad'", $cn);
?>