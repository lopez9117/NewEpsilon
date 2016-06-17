<?php
//conexion a la base de datos
include('../../../../dbconexion/conexion.php');
$cn = Conectarse();
$idfuncionario = $_POST['idfuncionario'];
$fecha = $_POST['fecha'];
mysql_query("DELETE FROM ct_disponibilidad_funcionario WHERE idfuncionario = '$idfuncionario' AND fecha = '$fecha'", $cn);
?>