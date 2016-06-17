<?php
//conexion a la BD
include("../../../../dbconexion/conexion.php");
$cn = Conectarse();
$orden = $_POST['idorden'];
mysql_query("DELETE FROM _temp WHERE idorden='$orden'",$cn);