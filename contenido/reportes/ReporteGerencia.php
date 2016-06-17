<?php
ini_set('max_execution_time', 0);
//conexion a la base de datos
include("../../dbconexion/conexion.php");
$cn = conectarse();
//variables con POST
$desde = '2014-01-01'; 
$hasta = '2014-12-31'; 
$idSede = '3';
//consultar la cantidad de estudios realizados en cada sede con lectura
$ConLectura = mysql_query("SELECT DISTINCT i.id_informe FROM r_informe_header i LEFT JOIN r_log_informe l ON i.id_informe = l.id_informe
WHERE i.idsede = '$idSede' AND l.fecha BETWEEN '$desde' AND '$hasta' AND l.id_estadoinforme = '8' AND i.idtipo_paciente = '1' GROUP BY i.id_informe ORDER BY l.fecha ASC", $cn);
//lineas para exportar a excel
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Consolidado".$fechaDesde.'/'.$fechaHasta.".xls");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
<td>Paciente</td>
<td>Servicio</td>
<td>Estudio</td>
<td>Tecnica</td>
<td>Adicional</td>
<td>Portatil</td>
<td>Fecha Solicitud</td>
<td>Hora Solicitud</td>
<td>Fecha Programación</td>
<td>Hora Programación</td>
<td>Fecha Realización</td>
<td>Hora Realización</td>
<td>Fecha lectura</td>
<td>Hora lectura</td>
<td>Fecha transcripcion</td>
<td>Hora Transcripcion</td>
<td>Fecha aprobacion</td>
<td>Hora aprobacion</td>
<td>Fecha Publicación</td>
<td>Hora Publicación</td>
<td>Observaciones</td>
</tr>
<?php
//validar cantidades de informes con y sin lectura
$contConLectura = mysql_num_rows($ConLectura);
//imprimir filas de archivos con lectura
if($contConLectura>=1)
{
	while($rowConLectura = mysql_fetch_array($ConLectura))
	{
		$idInforme = $rowConLectura['id_informe'];
		$SqlInforme = mysql_query("SELECT DISTINCT(i.id_informe), i.portatil, i.hora_solicitud, i.fecha_solicitud, i.ubicacion, i.orden,
		ser.descservicio, p.id_paciente, CONCAT(p.nom1,' ',p.nom2,' ',p.ape1,' ',p.ape2) AS paciente, se.descsede, est.nom_estudio, eps.desc_eps,
		tec.desc_tecnica, d.adicional, tp.desctipo_paciente, i.id_estadoinforme, d.adicional FROM r_informe_header i
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
		<td>'.ucwords(strtolower($RegInforme['paciente'])).'</td>
		<td>'.ucwords(strtolower($RegInforme['descservicio'])).'</td>
		<td>'.ucwords(strtolower($RegInforme['nom_estudio'])).'</td>
		<td>'.$RegInforme['desc_tecnica'].'</td>
		<td>'.ucwords(strtolower($RegInforme['adicional'])).'</td>';
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
		'
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
			'
			<td>'.$rowDetalles['fecha'].'</td>
			<td>'.$rowDetalles['hora'].'</td>';
		}
		//consultar observaciones realizadas durante el proceso.
		$sqlObservaciones = mysql_query("SELECT o.observacion, f.nombres, f.apellidos, c.desc_comentario FROM r_observacion_informe o
		INNER JOIN funcionario f ON f.idfuncionario = o. idfuncionario
		INNER JOIN r_tipo_comentario c ON c.id_tipocomentario = o.id_tipocomentario
		WHERE o.id_informe = '$idInforme'", $cn);
		//impriimr todas las observaciones realizadas en el proceso
		echo '<td>';
		while($rowObservaciones = mysql_fetch_array($sqlObservaciones))
		{
			echo '<strong>'.$rowObservaciones['nombres'].'&nbsp;'.$rowObservaciones['apellidos'].' ('.$rowObservaciones['desc_comentario'].') '.'</strong>: '.$rowObservaciones['observacion'];
		}
		//consultar observaciones realizadas por los espeicalistas
		$consDevolucionEspecialista = mysql_query("SELECT LEFT((fecha),10) AS fecha, RIGHT((fecha),8) AS hora, ed.comentario, CONCAT(f.nombres,' ', f.apellidos) AS especialista, md.desc_motivo
		FROM r_estudiodevuelto ed
		INNER JOIN funcionario f ON f.idfuncionario = ed.usuario
		INNER JOIN r_motivodevolucion md ON md.idmotivo = ed.idmotivo WHERE ed.id_informe = '$idInforme'", $cn);
		$contDevolucionEspecialista = mysql_num_rows($consDevolucionEspecialista);
		if($contDevolucionEspecialista>=1)
		{
			while($rowDevolucionEspecialista = mysql_fetch_array($consDevolucionEspecialista))
			{
				echo
				'<strong>'.$rowDevolucionEspecialista['especialista'].'('.ucwords(mb_strtolower($rowDevolucionEspecialista['desc_motivo'])).')'.'</strong>'.$rowDevolucionEspecialista['comentario'];	
			}
		}
		echo '</td>';
		echo '</tr>';
	}
}
?>
</table>
</body>
</html>