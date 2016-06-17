<?php
session_start();
$CurrentUser = $_SESSION['currentuser'];
//conexion a la base de datos
include('../../../dbconexion/conexion.php');
include('../ClassHoras.php');
$cn = Conectarse();
//declaracion de variables
$funcionario = $_POST['funcionario'];
$idConvencion = $_POST['convencion'];
$tipo = $_POST['tipo'];
$grupoEmpleado = $_POST['grupoEmpleado'];
$sede = $_POST['sede'];
$fecha = $_POST['fecha'];
$horaIni = $_POST['inicio'];
$horaFin = $_POST['fin'];
$servicio = $_POST['servicio'];
list($anio, $mes, $dia) = explode("-",$fecha);
$FechaInicio = ($anio.'-'.$mes.'-'.'01');
$FechaFinal = Horas::DiasMes($mes, $anio);
//Arreglo para obtener los valores calculados

$Horas = CalcularHoras($horaIni, $horaFin, $FechaInicio, $FechaFinal, $fecha, $cn);
$TotalDiurnas = $Horas['TotalDiurnas'];
$TotalNocturnas =  $Horas['TotalNocturnas'];
$TotalDiurnasFestivas = $Horas['TotalDiurnasFestivas'];
$TotalNocturnasFestivas = $Horas['TotalNocturnasFestivas'];
$TotalLaboradas = $Horas['TotalLaboradas'];

mysql_query("INSERT INTO turno_funcionario (idfuncionario, hr_inicio, hr_fin,fecha, currentuser, idtipo_turno, diurna, diurnafest, nocturna,
nocturnafest, idConvencion, idsede, idgrupo_empleado, idservicio, hralmuerzo, time)
VALUES ('$funcionario', '$horaIni', '$horaFin','$fecha','$CurrentUser','0','$TotalDiurnas', '$TotalDiurnasFestivas','$TotalNocturnas',
'$TotalNocturnasFestivas', '$idConvencion','$sede', '$grupoEmpleado','$servicio', '1', NOW())", $cn);
mysql_free_result($cn);
mysql_close($cn);
?>