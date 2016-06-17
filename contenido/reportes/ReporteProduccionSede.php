<?php
header("Cache-Control: no-cache");
header("Pragma: no-cache");
ini_set('max_execution_time', 0);
include("../../dbconexion/conexion.php");
include('ClassQueryReportes.php');
$cn = Conectarse();
$desde = base64_decode($_GET['FchDesde']);
$hasta = base64_decode($_GET['FchHasta']); 
$idSede = base64_decode($_GET['sede']);
$ConLectura = mysql_query("SELECT DISTINCT(i.id_informe) AS id_informe FROM r_informe_header i LEFT JOIN r_log_informe l ON i.id_informe = l.id_informe
WHERE i.idsede = '$idSede' AND l.fecha BETWEEN '$desde' AND '$hasta' AND l.id_estadoinforme = '8' ORDER BY i.idservicio ASC", $cn);
$SinLectura = mysql_query("SELECT DISTINCT(i.id_informe) AS id_informe FROM r_informe_header i LEFT JOIN r_log_informe l ON i.id_informe = l.id_informe
WHERE i.idsede = '$idSede' AND l.fecha BETWEEN '$desde' AND '$hasta' AND i.id_estadoinforme = '10'  ORDER BY i.idservicio ASC", $cn);
//lineas para exportar a excel
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Produccion".$desde.'/'.$hasta.".xls");
?>
<style type="text/css">
table{
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size:12px;
}
.header{
	background:#0CF;
	color:#FFF
}
</style>
<body>
<table width="100%" border="1" rules="all">
<tr class="header" align="center">
<td>Id</td>
<td>1er nombre</td>
<td>2do nombre</td>
<td>1er apellido</td>
<td>2do apellido</td>
<td>EPS</td>
<td>Ingreso</td>
<td>Servicio</td>
<td>Estudio</td>
<td>Tecnica</td>
<td>Portatil</td>
<td>Tipo paciente</td>
<td>Prioridad</td>
<td>Ubicacion</td>
<td>Adicional</td>
<td>Con/Sin Lectura</td>
<td>Bi Rads</td>
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
<td>Fecha Publicacion</td>
<td>Hora Publicacion</td>
<td>Observaciones</td>
<!--<td>Oportunidad Asignacion</td>
<td>Oportunidad Toma</td>
<td>Oportunidad Lectura</td>
<td>Oportunidad Transcripcion</td>
<td>Oportunidad Aprobacion</td>
<td>Oportunidad Publicacion</td>-->
</tr>
<?php
$contConLectura = mysql_num_rows($ConLectura);
if($contConLectura>=1)
{
	while($rowConLectura = mysql_fetch_array($ConLectura)) {
		$idInforme = $rowConLectura['id_informe'];
		$regInforme = estudio::DatosEsudio($cn, $idInforme);
		$idPaciente = $regInforme['id_paciente'];
		$idServicio = $regInforme['idservicio'];
		echo '<tr align="center">';
		echo paciente::DatosPaciente($cn, $idPaciente);
		echo '<td>'.ucwords(strtolower($regInforme['orden'])).'</td>';
		echo '<td>'.servicio::GetServicio($cn, $idServicio).'</td>';
		echo estudio::GetEstudio($cn, $idInforme, $idPaciente);
		echo '<td>'.estudio::GetAdicional($cn, $idInforme).'</td>';
		echo '<td>Con Lectura</td>';
		echo '<td>'.estudio::GetBiRads($cn, $idInforme).'</td>';
		echo '<td>'.$regInforme['fecha_solicitud'].'</td>';
		echo '<td>'.$regInforme['hora_solicitud'].'</td>';
		//obtener informacion de todo el proceso
		$Cons = mysql_query("SELECT id_estadoinforme FROM r_log_informe WHERE id_informe = '$idInforme' GROUP BY id_estadoinforme ORDER BY id_estadoinforme ASC");
		$estados = array('1', '2', '3', '4', '5', '8');
		foreach($estados as $estadoInforme){
			$ConsEstado = mysql_query("SELECT l.fecha, l.hora, f.nombres, f.apellidos FROM r_log_informe l INNER JOIN funcionario f ON f.idfuncionario = l.idfuncionario WHERE l.id_informe = '$idInforme' AND id_estadoinforme = '$estadoInforme' ", $cn);
			$RegsEstado = mysql_fetch_array($ConsEstado);
			echo
			'<td>'.ucwords(strtolower($RegsEstado['nombres'])).' '.ucwords(strtolower($RegsEstado['apellidos'])).'</td>
			<td>'.$RegsEstado['fecha'].'</td>
			<td>'.$RegsEstado['hora'].'</td>';
		}
		//obtener comentarios
		$consComentarios = mysql_query("SELECT observacion, CONCAT(o.fecha, o.hora) AS fecha, f.nombres, f.apellidos FROM r_observacion_informe o INNER JOIN funcionario f ON f.idfuncionario = o.idfuncionario WHERE o.id_informe = '$idInforme' ORDER BY o.fecha, o.hora ASC", $cn);
		$contComentarios = mysql_num_rows($consComentarios);
		echo '<td>';
		if($contComentarios>=1){
			$regComentarios = mysql_fetch_array($consComentarios);
			echo ucwords(strtolower($regComentarios['nombres'])).' '.ucwords(strtolower($regComentarios['apellidos'])).' '.$regComentarios['fecha'].' - '.$regComentarios['observacion'];
		}
		echo '</td>';
	}
}
$contSinLectura = mysql_num_rows($SinLectura);
//imprimir filas de archivos sin lectura
if($contSinLectura>=1) {
	while($RowSinLectura = mysql_fetch_array($SinLectura)) {
		$idInforme = $RowSinLectura['id_informe'];
		$regInforme = estudio::DatosEsudio($cn, $idInforme);
		$idPaciente = $regInforme['id_paciente'];
		$idServicio = $regInforme['idservicio'];
		echo '<tr align="center">';
		echo paciente::DatosPaciente($cn, $idPaciente);
		echo '<td>'.ucwords(strtolower($regInforme['orden'])).'</td>';
		echo '<td>'.servicio::GetServicio($cn, $idServicio).'</td>';
		echo estudio::GetEstudio($cn, $idInforme, $idPaciente);
		echo '<td>'.estudio::GetAdicional($cn, $idInforme).'</td>';
		echo '<td>Sin Lectura</td>';
		echo '<td>'.estudio::GetBiRads($cn, $idInforme).'</td>';
		echo '<td>'.$regInforme['fecha_solicitud'].'</td>';
		echo '<td>'.$regInforme['hora_solicitud'].'</td>';
		//obtener informacion de todo el proceso
		$Cons = mysql_query("SELECT id_estadoinforme FROM r_log_informe WHERE id_informe = '$idInforme' GROUP BY id_estadoinforme ORDER BY id_estadoinforme ASC");
		$estados = array('1', '10', '0', '0', '0', '0');
		foreach($estados as $estadoInforme){
			$ConsEstado = mysql_query("SELECT l.fecha, l.hora, f.nombres, f.apellidos FROM r_log_informe l INNER JOIN funcionario f ON f.idfuncionario = l.idfuncionario WHERE l.id_informe = '$idInforme' AND id_estadoinforme = '$estadoInforme' ", $cn);
			$RegsEstado = mysql_fetch_array($ConsEstado);
			echo
			'<td>'.ucwords(strtolower($RegsEstado['nombres'])).' '.ucwords(strtolower($RegsEstado['apellidos'])).'</td>
			<td>'.$RegsEstado['fecha'].'</td>
			<td>'.$RegsEstado['hora'].'</td>';
		}
		//obtener comentarios
		$consComentarios = mysql_query("SELECT observacion, CONCAT(o.fecha, o.hora) AS fecha, f.nombres, f.apellidos FROM r_observacion_informe o INNER JOIN funcionario f ON f.idfuncionario = o.idfuncionario WHERE o.id_informe = '$idInforme' ORDER BY o.fecha, o.hora ASC", $cn);
		$contComentarios = mysql_num_rows($consComentarios);
		echo '<td>';
		if($contComentarios>=1){
			$regComentarios = mysql_fetch_array($consComentarios);
			echo ucwords(strtolower($regComentarios['nombres'])).' '.ucwords(strtolower($regComentarios['apellidos'])).' '.$regComentarios['fecha'].' - '.$regComentarios['observacion'];
		}
		echo '</td>';
		echo '</tr>';
	}
}
mysql_close($cn);
?>
</table>