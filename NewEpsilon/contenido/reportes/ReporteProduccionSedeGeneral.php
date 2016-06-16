<?php
ini_set('max_execution_time', 0);
//conexion a la base de datos
include("../../dbconexion/conexion.php");
$cn = conectarse();
//variables con POST
$desde = base64_decode($_GET['FchDesde']); 
$hasta = base64_decode($_GET['FchHasta']); 
//consultar la cantidad de estudios realizados en cada sede con lectura
$ConLectura = mysql_query("SELECT DISTINCT i.id_informe FROM r_informe_header i LEFT JOIN r_log_informe l ON i.id_informe = l.id_informe
WHERE l.fecha BETWEEN '$desde' AND '$hasta' AND i.id_estadoinforme = '8'", $cn);
//consultar la cantidad de estudios realizados en cada sede con sin lectura
$SinLectura = mysql_query("SELECT DISTINCT i.id_informe FROM r_informe_header i LEFT JOIN r_log_informe l ON i.id_informe = l.id_informe
WHERE l.fecha BETWEEN '$desde' AND '$hasta' AND i.id_estadoinforme = '10'", $cn);
//lineas para exportar a excel
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Produccion".$desde.'/'.$hasta.".xls");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Reporte de produccion por sede :.</title>
</head>
<style type="text/css">
body
{
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size:10px;
}
.header
{background:#0CF;
color:#FFF
}
</style>
<body>
<table width="100%" border="1" rules="all">
<tr class="header" style="background:#0CF;
color:#FFF;">
<td>Id Paciente</td>
<td>Ingreso/Orden</td>
<td>1er nombre</td>
<td>2do nombre</td>
<td>1er apellido</td>
<td>2do apellido</td>
<td>Servicio</td>
<td>Estudio</td>
<td>Tecnica</td>
<td>Portatil</td>
<td>EPS</td>
<td>Tipo Paciente</td>
<td>Ubicacion</td>
<td>Con/Sin Lectura</td>
<td>Fecha Solicitud</td>
<td>Hora Solicitud</td>
<td>Agendado Por</td>
<td>Fecha Programación</td>
<td>Hora Programación</td>
<td>Tomado Por</td>
<td>Fecha Realización</td>
<td>Hora Realización</td>
<td>Leido por</td>
<td>Fecha lectura</td>
<td>Hora lectura</td>
<td>Transcribe</td>
<td>Fecha transcripcion</td>
<td>Hora Transcripcion</td>
<td>Aprobado Por</td>
<td>Fecha aprobacion</td>
<td>Hora aprobacion</td>
<td>Publicado Por</td>
<td>Fecha Publicación</td>
<td>Hora Publicación</td>
<!--<td>Oportunidad Asignacion</td>
<td>Oportunidad Toma</td>
<td>Oportunidad Lectura</td>
<td>Oportunidad Transcripcion</td>
<td>Oportunidad Aprobacion</td>
<td>Oportunidad Publicacion</td>-->
</tr>
<?php
//validar cantidades de informes con y sin lectura
$contConLectura = mysql_num_rows($ConLectura);
$contSinLectura = mysql_num_rows($SinLectura);
//imprimir filas de archivos con lectura
if($contConLectura>=1)
{
	while($rowConLectura = mysql_fetch_array($ConLectura))
	{
		$idInforme = $rowConLectura['id_informe'];
		$SqlInforme = mysql_query("SELECT DISTINCT(i.id_informe), i.portatil, i.hora_solicitud, i.fecha_solicitud, i.ubicacion, i.orden,
		ser.descservicio, p.id_paciente, p.nom1, p.nom2, p.ape1, p.ape2, se.descsede, est.nom_estudio, eps.desc_eps,
		tec.desc_tecnica, d.adicional, tp.desctipo_paciente, i.id_estadoinforme FROM r_informe_header i
		INNER JOIN r_tipo_paciente tp ON tp.idtipo_paciente = i.idtipo_paciente
		INNER JOIN servicio ser ON ser.idservicio = i.idservicio
		INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
		INNER JOIN sede se ON se.idsede = i.idsede
		INNER JOIN r_estudio est ON est.idestudio = i.idestudio
		INNER JOIN eps eps ON eps.ideps = p.ideps
		INNER JOIN r_tecnica tec ON tec.id_tecnica = i.id_tecnica
		INNER JOIN r_detalle_informe d ON i.id_informe = d.id_informe
		WHERE i.id_informe = '$idInforme'", $cn);
		$RegInforme = mysql_fetch_array($SqlInforme);
		echo 
		'<tr>
		<td>'.$RegInforme['id_paciente'].'</td>
		<td>'.$RegInforme['orden'].'</td>
		<td>'.$RegInforme['nom1'].'</td>
		<td>'.$RegInforme['nom2'].'</td>
		<td>'.$RegInforme['ape1'].'</td>
		<td>'.$RegInforme['ape2'].'</td>
		<td>'.$RegInforme['descservicio'].'</td>
		<td>'.$RegInforme['nom_estudio'].'</td>
		<td>'.$RegInforme['desc_tecnica'].'</td>';
		//validar si el estudio fue portatil
		if($RegInforme['portatil']==1)
		{
			echo '<td>Si</td>';
		}
		else
		{
			echo '<td>No</td>';
		}
		echo
		'<td>'.$RegInforme['desc_eps'].'</td>
		<td>'.$RegInforme['desctipo_paciente'].'</td>
		<td>'.$RegInforme['ubicacion'].'</td>
		<td>Con Lectura</td>
		<td>'.$RegInforme['fecha_solicitud'].'</td>
		<td>'.$RegInforme['hora_solicitud'].'</td>';
		//consultar detalles del log
		$consDetalles = mysql_query("SELECT DISTINCT(l.id_estadoinforme), l.fecha, l.hora, CONCAT(f.nombres,' ',f.apellidos) AS funcionario FROM r_log_informe l
		INNER JOIN funcionario f ON f.idfuncionario = l.idfuncionario
		WHERE l.id_informe = '$idInforme' AND l.id_estadoinforme BETWEEN '1' AND '8' GROUP BY l.id_estadoinforme ORDER BY l.id_estadoinforme ASC", $cn);
		//imprimir resultados dentro de un ciclo
		while($rowDetalles = mysql_fetch_array($consDetalles))
		{
			$fecha = ($rowDetalles['fecha'].'/'.$rowDetalles['hora']);
			echo
			'<td>'.$rowDetalles['funcionario'].'</td>
			<td>'.$rowDetalles['fecha'].'</td>
			<td>'.$rowDetalles['hora'].'</td>';
		}
		echo '</tr>';
	}
}
//imprimir filas de archivos sin lectura
if($contSinLectura>=1)
{
	while($rowSinLectura = mysql_fetch_array($SinLectura))
	{
		$idInforme = $rowSinLectura['id_informe'];
		$SqlInforme = mysql_query("SELECT DISTINCT(i.id_informe), i.portatil, i.hora_solicitud, i.fecha_solicitud, i.ubicacion, i.orden,
		ser.descservicio, p.id_paciente, p.nom1, p.nom2, p.ape1, p.ape2, se.descsede, est.nom_estudio, eps.desc_eps,
		tec.desc_tecnica, d.adicional, tp.desctipo_paciente, i.id_estadoinforme FROM r_informe_header i
		INNER JOIN r_tipo_paciente tp ON tp.idtipo_paciente = i.idtipo_paciente
		INNER JOIN servicio ser ON ser.idservicio = i.idservicio
		INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
		INNER JOIN sede se ON se.idsede = i.idsede
		INNER JOIN r_estudio est ON est.idestudio = i.idestudio
		INNER JOIN eps eps ON eps.ideps = p.ideps
		INNER JOIN r_tecnica tec ON tec.id_tecnica = i.id_tecnica
		INNER JOIN r_detalle_informe d ON i.id_informe = d.id_informe 
		WHERE i.id_informe = '$idInforme'", $cn);
		$RegInforme = mysql_fetch_array($SqlInforme);
		echo 
		'<tr>
		<td>'.$RegInforme['id_paciente'].'</td>
		<td>'.$RegInforme['orden'].'</td>
		<td>'.$RegInforme['nom1'].'</td>
		<td>'.$RegInforme['nom2'].'</td>
		<td>'.$RegInforme['ape1'].'</td>
		<td>'.$RegInforme['ape2'].'</td>
		<td>'.$RegInforme['descservicio'].'</td>
		<td>'.$RegInforme['nom_estudio'].'</td>
		<td>'.$RegInforme['desc_tecnica'].'</td>';
		//validar si el estudio fue portatil
		if($RegInforme['portatil']==1)
		{
			echo '<td>Si</td>';
		}
		else
		{
			echo '<td>No</td>';
		}
		echo
		'<td>'.$RegInforme['desc_eps'].'</td>
		<td>'.$RegInforme['desctipo_paciente'].'</td>
		<td>'.$RegInforme['ubicacion'].'</td>
		<td>Sin Lectura</td>
		<td>'.$RegInforme['fecha_solicitud'].'</td>
		<td>'.$RegInforme['hora_solicitud'].'</td>';
		//consultar detalles del log
		$consDetalles = mysql_query("SELECT DISTINCT(l.id_estadoinforme), l.fecha, l.hora, CONCAT(f.nombres,' ',f.apellidos) AS funcionario FROM r_log_informe l
INNER JOIN funcionario f ON f.idfuncionario = l.idfuncionario
WHERE l.id_informe = '$idInforme' AND l.id_estadoinforme = '1' OR l.id_informe = '$idInforme' AND l.id_estadoinforme = '10'
GROUP BY l.id_estadoinforme ORDER BY l.id_estadoinforme ASC", $cn);
		//imprimir resultados dentro de un ciclo
		while($rowDetalles = mysql_fetch_array($consDetalles))
		{
			echo
			'<td>'.$rowDetalles['funcionario'].'</td>
			<td>'.$rowDetalles['fecha'].'</td>
			<td>'.$rowDetalles['hora'].'</td>';
		}
		echo '</tr>';
	}
}
?>
</table>
</body>
</html>