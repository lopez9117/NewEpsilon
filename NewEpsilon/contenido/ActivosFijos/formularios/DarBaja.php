<?php
//Conexion a la base de datos
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();

$codigo = $_POST[codigo];

$sql = mysql_query("UPDATE activo_fijo SET estado_activo ='2' WHERE codigo='$codigo'", $cn);


?>