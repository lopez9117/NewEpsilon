<?php
//conexion a la base de datos
include('../../../dbconexion/conexion.php');
$cn = Conectarse();
$idturno = $_POST['idturno'];
//consulta para eliminar el turno
mysql_query("DELETE FROM turno_funcionario WHERE idturno = '$idturno'", $cn);
mysql_query("DELETE FROM novedad_turno WHERE idturno = '$idturno'", $cn);
?>