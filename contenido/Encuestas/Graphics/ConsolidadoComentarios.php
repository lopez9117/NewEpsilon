<?php
//conexion a la bd
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//declaracion de variables
$encuesta = $_GET['encuesta']; $sede = $_GET['sede']; $anio = $_GET['anio']; $mes = $_GET['mes'];
//crear variables para hacer consulta en el rango de fechas
$fechaInicio = $anio.'-'.$mes.'-'.'01';
$fechaFinal =  $anio.'-'.$mes.'-'.'31';
//consultar los tipos de comentarios que se pueden realilzar
$tipoComentario = mysql_query("SELECT * FROM e_tipocomentario WHERE idtipocomentario != 0", $cn);
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>.: Consolidado Comentarios :.</title>
<script language='Javascript' src='charts/FusionCharts.js'></script>
</head>
<body>
<?php
include('charts/FusionCharts.php');
$strXML .= "<chart palette='2' caption='Consolidado de comentarios' showValues='0' decimals='0' formatNumberScale='0' useRoundEdges='1'>";
while($rowTipoComentario = mysql_fetch_array($tipoComentario))
{
	$tipo = $rowTipoComentario['idtipocomentario'];
	//realizar consultas para obtener la cantidad de comentarios de cada tipo
	$consCantidad = mysql_query("SELECT COUNT(idtipocomentario) AS total FROM e_comentarios WHERE idtipocomentario = '$tipo' AND idsede = '$sede' AND fecha BETWEEN '$fechaInicio' AND '$fechaFinal'", $cn);
	$regsCantidad = mysql_fetch_array($consCantidad);
	$strXML .="<set label='".$rowTipoComentario['desctipo_comentario']."' value='".$regsCantidad['total']."'/>";	
}
$strXML .="</chart>";
//Mostrar grafico de lineas y puntos
echo renderChart("charts/Column2D.swf", "", $strXML, "Sales", 1050, 500, false, false);
?>
</body>
</html>