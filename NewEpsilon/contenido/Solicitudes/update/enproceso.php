<?php
//Conexion a la base de datos
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();

$idSolicitud = $_POST[idsolicitud];

$sql = mysql_query("UPDATE solicitud SET id_estadocompra ='4' WHERE idsolicitud='$idSolicitud'", $cn);


?>