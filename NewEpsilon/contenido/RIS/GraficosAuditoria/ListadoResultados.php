<?php 
include("../../Encuestas/Graphics/charts/FusionCharts.php");
ini_set('max_execution_time', 0);
//Conexion a la base de datos
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//variables metodo GET
$usuario= $_GET['usuario'];
$fecha = $_GET['fecha'];
$hasta = $_GET['hasta'];
$sede = $_GET['sede'];
$servicio = $_GET['servicio'];
$estado = $_GET['estado'];
$fechacons = date("Y-m-d",strtotime($fecha));
$fechacons2 = date("Y-m-d",strtotime($hasta));
//arreglo con los estados
$EstadoArray = array( 1 => 'Agendado/Pendiente por realizar', 2 => 'Pendiente por Lectura', 3 => 'Pendiente por transcribir', 4 => 'Pendiente por Aprobar', 5 => 'Pendiente por publicar', 9 => 'Devuelto por el especialista');
foreach ($EstadoArray as $valor => $descripcion) 
{
	if($estado==$valor)
	{
		$descEstado = $descripcion;
	}
}
//consultar los servicios de cada sede
$sqlServicios = mysql_query("SELECT DISTINCT(h.idservicio), ser.descservicio FROM r_informe_header h 
INNER JOIN servicio ser ON ser.idservicio = h.idservicio
WHERE h.idsede = '$sede' AND h.id_estadoinforme = '$estado' ORDER BY descservicio ASC", $cn);
$strXML .="<chart caption='".$descEstado."' showValues='0' decimals='0' formatNumberScale='0' chartRightMargin='30'>";
//ciclo para agrupar los servicios
while($rowServicio = mysql_fetch_array($sqlServicios))
{
	$idServicio = $rowServicio['idservicio'];
	//contar todos los estudios pendientes por cada servicio en cada sede
	$sqlContadores = mysql_query("SELECT DISTINCT(l.id_informe) FROM r_log_informe l
	LEFT JOIN r_informe_header i ON i.id_informe = l.id_informe
	WHERE l.fecha BETWEEN '$fechacons' AND '$fechacons2' AND i.idservicio = '$idServicio' AND i.idsede = '$sede' AND l.id_estadoinforme = '$estado' AND i.id_estadoinforme = '$estado'", $cn);
	$regcontadores = mysql_num_rows($sqlContadores);
	//imprimir solo los pendientes
	if($regcontadores>0)
	{
		$strXML .="<set label='".$rowServicio['descservicio']."' value='".$regcontadores."'/>";
	}
}
$strXML .="</chart>";
echo renderChart("../../Encuestas/Graphics/charts/Bar2D.swf", "", $strXML, "Sales", 900, 400, false, false);
mysql_close($cn);
?>