<?php
include('../../../../dbconexion/conexion.php');
$cn = Conectarse();
//variables POST
//creacion de variables
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$funcionario = $_POST['funcionario'];
$CurrentUser = $_POST['CurrentUser'];
//calcular los dias entre las dos fechas seleccionadas
//defino fecha 1 
list($ano1, $mes1, $dia1) = explode("-", $desde);
//defino fecha 2 
list($ano2, $mes2, $dia2) = explode("-", $hasta);
//calculo timestam de las dos fechas 
$timestamp1 = mktime(0, 0, 0, $mes1, $dia1, $ano1);
$timestamp2 = mktime(4, 12, 0, $mes2, $dia2, $ano2);
//resto a una fecha la otra 
$segundos_diferencia = $timestamp1 - $timestamp2;
//echo $segundos_diferencia; 
//convierto segundos en días 
$dias_diferencia = $segundos_diferencia / (60 * 60 * 24);
//obtengo el valor absoulto de los días (quito el posible signo negativo) 
$dias_diferencia = abs($dias_diferencia);
//quito los decimales a los días de diferencia 
$dias_diferencia = floor($dias_diferencia);
$MaxDias = ($dias_diferencia);
//consultar si hay registrada una disponibilidad
$con1 = mysql_query("SELECT * FROM ct_disponibilidad_funcionario WHERE idfuncionario = '$funcionario' AND fecha = '$desde'", $cn);
$contador1 = mysql_num_rows($con1);
if ($contador1 == 0 || $contador1 == "") {
    mysql_query("INSERT INTO ct_disponibilidad_funcionario (`idfuncionario`,`fecha`,`fecha_log`, `idfuncionario_registro` ) VALUES('$funcionario','$desde', now(), '$CurrentUser')", $cn);
    //Cantidad de dias maximo para el prestamo, este sera util para crear el for
}
//Creamos un for desde 0 hasta X
for ($i = 0; $i < $MaxDias; $i++) {
    $dia = $dia + 1;
    $nuevafecha = strtotime('+' . $dia . ' day', strtotime($desde));
    $nuevafecha = date('Y-m-d', $nuevafecha);
    //validar si existe un registro
    $con = mysql_query("SELECT * FROM ct_disponibilidad_funcionario WHERE idfuncionario = '$funcionario' AND fecha = '$nuevafecha'", $cn);
    $contador = mysql_num_rows($con);
    if ($contador == "" || $contador == 0) {
        mysql_query("INSERT INTO ct_disponibilidad_funcionario (`idfuncionario`,`fecha`,`fecha_log`, `idfuncionario_registro` ) VALUES('$funcionario','$nuevafecha', now(), '$CurrentUser')", $cn);
    }
}
?>