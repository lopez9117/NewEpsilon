<?php
//conexion a la bd
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//declaracion de variables
$anio = $_GET['anio'];
$encuesta = $_GET['encuesta'];
$sede = $_GET['sede'];
//consultar, meses donde se hicieron encuestas
$consMeses = mysql_query("SELECT DISTINCT MONTH(fecha) AS mes FROM e_encuesta WHERE idnombencuesta = '$encuesta' AND YEAR(fecha) = '$anio' AND idsede = '$sede' ", $cn);
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
//consulta para obtener y graficar los meses en los que se registran las encuestas
$consMeses2 = mysql_query("SELECT DISTINCT MONTH(fecha) AS mes FROM e_encuesta WHERE idnombencuesta = '$encuesta' AND YEAR(fecha) = '$anio' AND idsede = '$sede' ORDER BY mes ASC ", $cn);
//Etiqueta con las propiedades del grafico
$strXML = "<chart caption='' subCaption='' numdivlines='9' lineThickness='2' showValues='0' anchorRadius='3' anchorBgAlpha='50' showAlternateVGridColor='1' numVisiblePlot='12' animation='1' numberPrefix='%'>";
//valores que me crean la cantidad de meses que voy a graficar
$strXML .= "<categories >";
while($rowMeses2 = mysql_fetch_array($consMeses2))
{
	$mes2 = $rowMeses2['mes'];
	if($mes2==1){ $nombMes = "Ene";}
	elseif($mes2==2){ $nombMes = "Feb";}
	elseif($mes2==3){ $nombMes = "Mar";}
	elseif($mes2==4){ $nombMes = "Abr";}
	elseif($mes2==5){ $nombMes = "May";}
	elseif($mes2==6){ $nombMes = "Jun";}
	elseif($mes2==7){ $nombMes = "Jul";}
	elseif($mes2==8){ $nombMes = "Ago";}
	elseif($mes2==9){ $nombMes = "Sep";}
	elseif($mes2==10){ $nombMes = "Oct";}
	elseif($mes2==11){ $nombMes = "Nov";}
	elseif($mes2==12){ $nombMes = "Dic";}
	$strXML .= "<category label='".$nombMes."' />";
}
$strXML .= "</categories>";
//etiqueta para el pie de pagina que me señala el año seleccionado para obtener el indicador
$strXML .= "<dataset seriesName='".$anio."' color='800080' anchorBorderColor='800080'>";

//ciclo para agrupar todos los meses donde se registraron encuestas
while($rowMeses = mysql_fetch_array($consMeses))
{
	$mes = $rowMeses['mes'];
	//concatenar con 0 los valores menores a 10
	if($mes<=9)
	{
		$mes = "0".$mes;
	}
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
		//Impresion de los valores asignados a cada mes
		$strXML.="<set value='".round($satisfaccion, 1)."'/>";
}
$strXML .= "</dataset>";
//propiedades de estilo para el grafico
$strXML .= "<styles>";
	$strXML .= "<definition>";
		$strXML .= "<style name='Anim1' type='animation' param='_xscale' start='0' duration='1' />";
		$strXML .= "<style name='Anim2' type='animation' param='_alpha' start='0' duration='1' />";
		$strXML .= "<style name='DataShadow' type='Shadow' alpha='40'/>";
	$strXML .= "</definition>";
	$strXML .= "<application>";
		$strXML .= "<apply toObject='DIVLINES' styles='Anim1' />";
		$strXML .= "<apply toObject='HGRID' styles='Anim2' />";
		$strXML .= "<apply toObject='DATALABELS' styles='DataShadow,Anim2' />";
	$strXML .= "</application>	";
$strXML .= "</styles>";
$strXML .= "</chart>";
//Mostrar grafico de lineas y puntos
echo renderChart("charts/ScrollLine2D.swf", "", $strXML, "Sales", 1050, 500, false, false);
?>
</body>
</html>