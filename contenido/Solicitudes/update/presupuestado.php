<?php
//Conexion a la base de datos
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
echo $id = $_POST[idsolicitud];
$estado=$_POST[estado];
$sql = mysql_query("UPDATE solicitud SET id_presupuesto='$estado' WHERE idsolicitud='$id'", $cn);
?>