<?php
//Conexion a la base de datos
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$idSolicitud = $_POST[idsolicitud];
$sql = mysql_query("UPDATE solicitud SET idsatisfaccion ='1' WHERE idsolicitud='$idSolicitud'", $cn);
?>