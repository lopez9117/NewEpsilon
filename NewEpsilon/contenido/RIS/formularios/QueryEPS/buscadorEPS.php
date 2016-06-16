<?php
require_once("../../../../dbconexion/conexion.php");
$cn = Conectarse();
include_once 'eps.class.php';
$eps = new eps();
echo json_encode($eps->buscarEPS($_GET['term']));
mysql_close($cn);
?>
