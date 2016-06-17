<?php
	//declaracion de variables con POST
	$mes = $_POST[mes];
	$anio = $_POST[anio];
	if($mes!= "" && $anio!="")
	{
	function getMonthDays($Month, $Year)
	{
	   if( is_callable("cal_days_in_month"))
	   {
		  return cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
	   }
	   else
	   {
		  return date("d",mktime(0,0,0,$Month+1,0,$Year));
	   }
	}
	//Obtenemos la cantidad de días
	$dias = getMonthDays($mes, $anio);
	//construccion de variables para consultar
	$fechaDesde = $anio.'-'.$mes.'-'.'01';
	$fechaHasta = $anio.'-'.$mes.'-'.$dias;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Total de solicitudes para Sistemas :.</title>
<script languaje="Javascript" src="../FusionCharts/FusionCharts.js"></script>
	<style type="text/css">
	<!--
	body {
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
	}
	.text{
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
	}
	-->
	</style>
</head>
<body>
<form action="" method="post" name="consulta" target="_self" id="consulta">
  <table width="50%" border="0" align="center">
    <tr>
      <td width="33%"><label for="mes"></label>
        <select name="mes" id="mes">
        <option value="">.: Seleccione un mes :.</option>
        <option value="01">Enero</option>
        <option value="02">Febrero</option>
        <option value="03">Marzo</option>
        <option value="04">Abril</option>
        <option value="05">Mayo</option>
        <option value="06">Junio</option>
        <option value="07">Julio</option>
        <option value="08">Agosto</option>
        <option value="09">Septiembre</option>
        <option value="10">Octubre</option>
        <option value="11">Noviembre</option>
        <option value="12">Diciembre</option>
      </select></td>
      <td width="33%"><label for="anio"></label>
        <select name="anio" id="anio">
        <option value="">.: Seleccione un año :.</option>
		<?php 
        for($y=2013; $y<=2020 ; $y=$y+1 )
        {
            echo '<option value="'.$y.'">'.$y.'</option>';
        }
        ?>
      </select></td>
      <td width="33%"><input type="submit" name="Consultar" id="Consultar" value="Consultar" /></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
  </table>
</form>
<br>
<?php
//We've included ../Includes/FusionCharts.php and ../Includes/DBConn.php, which contains
//functions to help us easily embed the charts and connect to a database.
include("FusionCharts.php");
include("../../../dbconexion/conexion.php");
$cn = conectarse();
?>		
<center>
<h2>Consolidado de solicitudes para el area de sistemas de información</h2>
<p class="text">Haga Click en cualquier segmento del grafico de torta para resaltarlo </p>
<?php
	//consulta
	$sql = mysql_query("SELECT DISTINCT idsede FROM solicitud WHERE fechahora_solicitud BETWEEN '$fechaDesde' AND '$fechaHasta' AND idarea = '1'", $cn);
	//cantidad de solicitudes recibidas
	$sqlSolicitudes = mysql_query("SELECT COUNT(idsolicitud) AS cantidad FROM solicitud WHERE fechahora_solicitud BETWEEN '$fechaDesde' AND '$fechaHasta'", $cn);
	$regsSolicitudes = mysql_fetch_array($sqlSolicitudes);
	//Genera encabezado para el grafico
	$strXML = "<chart pieSliceDepth='40' showBorder='0' formatNumberScale='0' numberSuffix=' Solicitudes'>";
	//ciclo para obtener sumatoria
    while($rowSede = mysql_fetch_array($sql))
	{
		//obtener variables para consultar
		$Sede = $rowSede[idsede];
		//obtener datos sede
		$consSede = mysql_query("SELECT codigo FROM sede WHERE idsede = '$Sede'", $cn);
		$regsSede = mysql_fetch_array($consSede);
		//contar registros
		$ContSolicitud = mysql_query("SELECT COUNT(idsolicitud) AS cantidad FROM solicitud WHERE idsede = '$Sede' AND fechahora_solicitud BETWEEN '$fechaDesde' AND '$fechaHasta'", $cn);
		$RegsSolicitud = mysql_fetch_array($ContSolicitud);
				
		$strXML .= "<set label='".$regsSede[codigo]."' value='".$RegsSolicitud[cantidad]."'/>";
	}
	
//$strXML .= "<set label='hola' value='5' />";
	//Finally, close <chart> element
	$strXML .= "</chart>";
	//Create the chart - Pie 3D Chart with data from $strXML
	echo renderChart("../FusionCharts/Pie3D.swf", "", $strXML, "FactorySum", 900, 500, false, false);
?>
</center>
</body>
</html>