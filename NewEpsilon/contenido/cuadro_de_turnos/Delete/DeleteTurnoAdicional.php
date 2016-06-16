<?php
	require_once('../../../dbconexion/conexion.php');
	$cn = Conectarse();
	$idturno = $_POST[idturno];
	mysql_query("DELETE FROM turno_funcionario WHERE idturno = '$idturno'", $cn);
	mysql_query("DELETE FROM novedad_turno WHERE idturno = '$idturno'", $cn);
?>