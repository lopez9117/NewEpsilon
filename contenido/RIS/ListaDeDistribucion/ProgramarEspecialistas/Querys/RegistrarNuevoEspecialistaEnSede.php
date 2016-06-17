<?php
//conexion a la base de datos
include("../../../../../dbconexion/conexion.php");
$cn = conectarse();
//declaracion de variables
$fechaDesde = $_POST['fechaDesde']; 
$idEspecialista = $_POST['especialista']; 
$sede = $_POST['sede']; 
$servicio = $_POST['servicio']; 
$desde = strtotime($_POST['desde']);
$hasta = strtotime($_POST['hasta']);
list($idEspecialista, $nombres) = explode("-", $idEspecialista);
//Validar campos obligatorios
if($fechaDesde=="" || $idEspecialista=="" || $sede=="" || $servicio=="" || $desde=="" || $hasta=="")
{
	echo '<font color="#FF0000">Por favor verifique que no existan campos vacios</font>';
}
else
{
	//insertar
	mysql_query("INSERT INTO r_horario_especialista (idfuncionario, fecha, hr_desde, hr_hasta, idsede, idservicio) VALUES ('$idEspecialista','$fechaDesde','$desde','$hasta','$sede','$servicio')", $cn);
}
?>