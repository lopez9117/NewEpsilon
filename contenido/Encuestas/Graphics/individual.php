<?php
//conexion a la bd
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//declaracion de variables
$encuesta = $_GET['encuesta']; $pregunta = $_GET['pregunta']; $sede = $_GET['sede']; $mes = $_GET['mes']; $anio = $_GET['anio'];
//construir variables con fechas
$desde = $anio.'-'.$mes.'-'.'01';
$hasta = $anio.'-'.$mes.'-'.'31';
//consultar cantidad de usuarios que contestaron la encuesta en la sede seleccionada
$consEncuesta = mysql_query("SELECT idencuesta FROM e_encuesta WHERE idsede = '$sede' AND idnombencuesta = '$encuesta' AND fecha BETWEEN '$desde' AND '$hasta'", $cn);
$contEncuesta = mysql_num_rows($consEncuesta);
if($contEncuesta==0 || $contEncuesta=="")
{
	echo '<font size="+2" color="#FF0000">No se encontraron registros asociados a la busqueda</font>';
}
else
{
while($rowEncuesta = mysql_fetch_array($consEncuesta))
{
	$idEncuesta = $rowEncuesta['idencuesta'];
	//consultar y agrupar la cantidad de usuarios que contestaron la pregunta y contabilizar satisfechos y no satisfechos.
	$consResp = mysql_query("SELECT idcalificacion FROM e_resp_encuesta WHERE idencuesta = '$idEncuesta' AND idpregunta = '$pregunta'", $cn);
	$regsResp = mysql_fetch_array($consResp);
	$respuesta = $regsResp['idcalificacion'];
	//agrupar respuestas satisfactorias
	if($respuesta==1 || $respuesta==2)
	{
	 	$nosatisfecho = $nosatisfecho+1;
	}
	elseif($respuesta==3 || $respuesta==4)
	{
		$satisfecho = $satisfecho+1;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Grafico de satisfacción :.</title>
<script language="Javascript" src="charts/FusionCharts.js"></script>
</head>
<body>
<?php
include("charts/FusionCharts.php");
$strXML = "<chart palette='1' numberPrefix='Usuarios ' caption='Satisfacción de Usuarios' animation='1'>";
$strXML.="<set label='Satisfecho' value='".$satisfecho."'/>";
$strXML.="<set label='No Satisfecho' value='".$nosatisfecho."'/>";
$strXML.="</chart>";
echo renderChart("charts/Doughnut2D.swf", "", $strXML, "Sales", 1050, 400, false, false);
	}
?>
</body>
</html>