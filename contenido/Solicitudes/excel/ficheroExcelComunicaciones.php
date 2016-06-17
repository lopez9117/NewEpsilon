<?php
//Conexion a la base de datos
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$fechaDesde = $_POST['fechaDesde'];
$fechaHasta = $_POST['fechaHasta'];
list($MES,$DIA,$AÑO) = explode("/",$fechaDesde);
$DESDE= $AÑO."-".$MES."-".$DIA;
list($MES,$DIA,$AÑO) = explode("/",$fechaHasta);
$HASTA= $AÑO."-".$MES."-".$DIA;
//linea que convierte archivo a excel
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=ConsolidadoSistemas.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Excel Solicitudes :.</title>
</head>
<style type="text/css">
	body
	{font-family:Tahoma, Geneva, sans-serif;
	font-size:12px;
	}
</style>
<body>
<?php 
//obtener listado de solicitudes
$listado =  mysql_query("SELECT so.idsolicitud,so.porque, so.desc_requerimiento, so.fechahora_solicitud,so.horasolicitud, so.fechahora_visita,so.horavisita,
s.descsede, e.descestado_solicitud,CONCAT(f.nombres,' ', f.apellidos) AS nombres, sa.desc_satisfaccion,tp.desc_prioridad,t.desc_tiposolicitud FROM solicitud so
INNER JOIN tipo_solicitud t ON t.id_tiposolicitud = so.id_tiposolicitud
INNER JOIN sede s ON s.idsede = so.idsede
INNER JOIN estado_solicitud e ON e.idestado_solicitud = so.idestado_solicitud
INNER JOIN funcionario f ON f.idfuncionario= so.idfuncionario
INNER JOIN satisfaccion sa ON sa.idsatisfaccion= so.idsatisfaccion
INNER JOIN tipo_prioridad tp ON tp.idprioridad=so.idprioridad
WHERE so.idarea = '9' AND fechahora_solicitud BETWEEN '$DESDE' AND '$HASTA' ORDER BY so.fechahora_solicitud DESC",$cn);
 ?>
<table cellpadding="0" cellspacing="0" rules="all" border="1">
<tr bgcolor="#0066FF">
    <td align="center">Usuario</td>
    <td align="center">Sede</td>
    <td align="center">Requerimiento</td>
    <td align="center">Prioridad</td>
    <td align="center">Fecha Solicitud</td>
    <td align="center">Hora Solicitud</td>
    <td align="center">Fecha de Cumplimiento</td>
    <td align="center">Hora de Cumplimiento</td>
    <td align="center">Estado</td>
    <td align="center">Satisfaccion</td>
    <td align="center">¿Por qué?</td>
    <td align="center">Tipo Solicitud</td>
    <td align="center">Observaciones</td>
</tr>
<?php
while($reg =  mysql_fetch_array($listado))
{
	$idSolicitud = $reg['idsolicitud'];
	//consultar las observaciones realizadas a la solicitud
	$consObservaciones = mysql_query("SELECT o.fecha, o.hora, o.observacion, f.nombres, f.apellidos FROM observaciones o
	INNER JOIN funcionario f ON f.idfuncionario = o.idfuncionario WHERE o.idsolicitud = '$idSolicitud' ", $cn);
	echo '<tr>';
	echo '<td align="left">'.$reg['nombres'].'</td>';
	echo '<td align="left">'.$reg['descsede'].'</td>';
	echo '<td align="left">'.$reg['desc_requerimiento'].'</td>';
	echo '<td align="left">'.$reg['desc_prioridad'].'</td>';
	echo '<td align="left">'.$reg['fechahora_solicitud'].'</td>';
	echo '<td align="left">'.$reg['horasolicitud'].'</td>';
	echo '<td align="left">'.$reg['fechahora_visita'].'</td>';
	echo '<td align="left">'.$reg['horavisita'].'</td>';
	echo '<td align="left">'.$reg['descestado_solicitud'].'</td>';
	echo '<td align="left">'.$reg['desc_satisfaccion'].'</td>';
	echo '<td align="left">'.$reg['porque'].'</td>';
	echo '<td align="left">'.$reg['desc_tiposolicitud'].'</td>';
	echo '<td>';
	while($rowObservaciones = mysql_fetch_array($consObservaciones))
	{
		echo '<strong>'.$rowObservaciones['nombres'].' '.$rowObservaciones['apellidos'].' - '.$rowObservaciones['fecha'].' - '.$rowObservaciones['hora'].'</strong>'.'&nbsp;';
		echo $rowObservaciones['observacion'];
	}
	echo '</td>';
	echo '</tr>';
}
?>
</table>
</body>
</html>