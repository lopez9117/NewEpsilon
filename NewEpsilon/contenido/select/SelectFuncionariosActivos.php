<?php
	//conexion a la bd
require_once('../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();

	$sqlFuncioanrios = mysql_query("SELECT idfuncionario, nombres, apellidos FROM funcionario WHERE idestado_actividad = 1 ORDER BY nombres ASC", $cn);
?>