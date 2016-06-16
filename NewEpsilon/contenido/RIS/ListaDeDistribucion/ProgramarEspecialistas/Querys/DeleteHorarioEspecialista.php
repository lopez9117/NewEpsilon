<?php
//conexion a la base de datos
include("../../../../../dbconexion/conexion.php");
$cn = conectarse();
//declaracion de variables
$idAut = $_POST['idAut'];
mysql_query("DELETE FROM r_horario_especialista WHERE idAut = '$idAut'", $cn);
?>