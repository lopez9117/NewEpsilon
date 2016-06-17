<?php
//archivo de conexion
include("../../../../dbconexion/conexion.php");
$cn = conectarse();
$idInforme = $_POST['informe'];
$especialista = $_POST['especialista'];
mysql_query("INSERT INTO r_estadoventana VALUES ('$idInforme','$especialista')", $cn);
?>