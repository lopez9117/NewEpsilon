<?php
//conexion a la bd
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//declaracion de variables
$anio = $_GET['anio'];
$encuesta = $_GET['encuesta'];
$sede = $_GET['sede'];
$mes = $_GET['mes'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Grafico de Satisfaccion Global :.</title>
<script language="Javascript" src="charts/FusionCharts.js"></script>
</head>
<body>
<?php
include("charts/FusionCharts.php");
//construir rangos de fecha para realizar consultas
$fechaInicio = $anio.'-'.$mes.'-'.'01';
$fechaFinal = $anio.'-'.$mes.'-'.'31';
//realizar consultas obteniendo resultados de los meses arrojados por el ciclo
$consEncuesta = mysql_query("SELECT DISTINCT(idencuesta) AS idencuesta FROM e_encuesta WHERE idnombencuesta = '$encuesta' AND fecha BETWEEN '$fechaInicio' AND '$fechaFinal' AND idsede = '$sede' ", $cn);
//obtener la cantidad de encuestas que se registraron en el mes
$totalSatisfecho = 0;
$totalNoSatisfecho = 0;
while($rowEncuesta = mysql_fetch_array($consEncuesta))
{
	$idEncuesta = $rowEncuesta['idencuesta'];
	//consultar las respuestas afirmativas de cada una de las encuestas consultadas
	$consRespSatisfecho = mysql_query("SELECT COUNT(idcalificacion) AS satisfecho FROM e_resp_encuesta WHERE idencuesta = '$idEncuesta' AND idcalificacion BETWEEN '3' AND '4'", $cn);
	$regsRespSatisfecho = mysql_fetch_array($consRespSatisfecho);
	//consultar las respuestas negativas de cada una de las encuestas consultadas
	$consRespNoSatisfecho = mysql_query("SELECT COUNT(idcalificacion) AS NoSatisfecho FROM e_resp_encuesta WHERE idencuesta = '$idEncuesta' AND idcalificacion BETWEEN '1' AND '2'", $cn);
	$regsRespNoSatisfecho = mysql_fetch_array($consRespNoSatisfecho);
	//Calificaciones totales
	$totalSatisfecho = $totalSatisfecho + $regsRespSatisfecho['satisfecho'];
	$totalNoSatisfecho = $totalNoSatisfecho + $regsRespNoSatisfecho['NoSatisfecho'];
}	
$totalRespuestas = $totalNoSatisfecho+$totalSatisfecho;
//calcular formula
$satisfaccion = ($totalSatisfecho)/$totalRespuestas*100;
//Consultar la cantidad de usuarios encuestados
$consCantidades = mysql_query("SELECT COUNT(idencuesta) AS cantidad FROM e_encuesta WHERE idsede = '$sede' AND fecha BETWEEN '$fechaInicio' AND '$fechaFinal'", $cn);
$RegsCantidades = mysql_fetch_array($consCantidades);
$total = $RegsCantidades['cantidad'];
echo 'Total de usuarios encuestados '.$total; 
//realizar regla de 3 para obtener la cantidad de usuarios satisfechos
$satistechos = ($total/100*$satisfaccion);
$noSatisfechos = ($total-$satistechos);
$strXML .="<chart palette='3'>";
$strXML .="<set label='Satisfecho' value='".round($satistechos)."'/>";
$strXML .="<set label='No Satisfecho' value='".round($noSatisfechos)."'/>";
$strXML .="</chart>";
//Mostrar grafico de lineas y puntos
echo renderChart("charts/Pie3D.swf", "", $strXML, "Sales", 1050, 400, false, false);
?>
</body>
</html>