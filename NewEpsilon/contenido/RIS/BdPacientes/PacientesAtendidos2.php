<?php
ini_set('max_execution_time', 0);
//conexion a la base de datos
include("../../../dbconexion/conexion.php");
$cn = conectarse();
//construir variables
$idSede = $_GET['sede'];
$mes = $_GET['mes'];
$anio = $_GET['anio'];
$desde = $anio.'-'.$mes.'-'.'01'; 
$hasta = $anio.'-'.$mes.'-'.'31'; 
$servicio = $_GET['servicio'];
//consultar la cantidad de estudios realizados en cada sede con lectura
$ConLectura = mysql_query("SELECT DISTINCT i.id_informe FROM r_informe_header i LEFT JOIN r_log_informe l ON i.id_informe = l.id_informe
WHERE i.idsede = '$idSede' AND i.idservicio = '$servicio' AND l.fecha BETWEEN '$desde' AND '$hasta' AND l.id_estadoinforme = '8'", $cn);
//consultar la cantidad de estudios realizados en cada sede con sin lectura
$SinLectura = mysql_query("SELECT DISTINCT i.id_informe FROM r_informe_header i LEFT JOIN r_log_informe l ON i.id_informe = l.id_informe
WHERE i.idsede = '$idSede' AND i.idservicio = '$servicio' AND l.fecha BETWEEN '$desde' AND '$hasta' AND i.id_estadoinforme = '10'", $cn);
//lineas para exportar a excel
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=BdPacientes".$desde.'/'.$hasta.".xls");
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
	<td>Paciente</td>
	<td>Sexo</td>
	<td>Edad</td>
	<td>EPS</td>
	<td>Numero Telefonico</td>
	<td>Servicio</td>
	<td>Estudio</td>
	<td>Tecnica</td>
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
		$SqlInforme = mysql_query("SELECT ser.descservicio, p.id_paciente,
		CONCAT(p.nom1,' ',p.nom2,' ',p.ape1,' ',p.ape2) AS paciente, p.tel, p.edad, se.descsede,
		est.nom_estudio, eps.desc_eps, tec.desc_tecnica, sex.desc_sexo FROM r_informe_header i
		INNER JOIN r_tipo_paciente tp ON tp.idtipo_paciente = i.idtipo_paciente
		INNER JOIN servicio ser ON ser.idservicio = i.idservicio
		INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
		INNER JOIN sede se ON se.idsede = i.idsede
		INNER JOIN r_estudio est ON est.idestudio = i.idestudio
		INNER JOIN eps eps ON eps.ideps = p.ideps
		INNER JOIN r_tecnica tec ON tec.id_tecnica = i.id_tecnica
		INNER JOIN r_detalle_informe d ON i.id_informe = d.id_informe
		INNER JOIN r_sexo sex ON sex.id_sexo = p.id_sexo
		WHERE i.id_informe = '$idInforme' GROUP BY i.id_informe", $cn);
		$RegInforme = mysql_fetch_array($SqlInforme);
		echo 
		'<tr>
			<td>'.$RegInforme['id_paciente'].'</td>
			<td>'.$RegInforme['paciente'].'</td>
			<td>'.$RegInforme['desc_sexo'].'</td>
			<td>'.$RegInforme['edad'].'(S)</td>
			<td>'.$RegInforme['desc_eps'].'</td>
			<td>'.$RegInforme['tel'].'</td>
			<td>'.$RegInforme['descservicio'].'</td>
			<td>'.$RegInforme['nom_estudio'].'</td>
			<td>'.$RegInforme['desc_tecnica'].'</td>
		</tr>';
	}
}
//imprimir filas de archivos sin lectura
if($contSinLectura>=1)
{
	while($rowSinLectura = mysql_fetch_array($SinLectura))
	{
		$idInforme = $rowSinLectura['id_informe'];
		$SqlInforme = mysql_query("SELECT ser.descservicio, p.id_paciente,
		CONCAT(p.nom1,' ',p.nom2,' ',p.ape1,' ',p.ape2) AS paciente, p.tel, p.edad, se.descsede,
		est.nom_estudio, eps.desc_eps, tec.desc_tecnica, sex.desc_sexo FROM r_informe_header i
		INNER JOIN r_tipo_paciente tp ON tp.idtipo_paciente = i.idtipo_paciente
		INNER JOIN servicio ser ON ser.idservicio = i.idservicio
		INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
		INNER JOIN sede se ON se.idsede = i.idsede
		INNER JOIN r_estudio est ON est.idestudio = i.idestudio
		INNER JOIN eps eps ON eps.ideps = p.ideps
		INNER JOIN r_tecnica tec ON tec.id_tecnica = i.id_tecnica
		INNER JOIN r_detalle_informe d ON i.id_informe = d.id_informe
		INNER JOIN r_sexo sex ON sex.id_sexo = p.id_sexo
		WHERE i.id_informe = '$idInforme' GROUP BY i.id_informe", $cn);
		$RegInforme = mysql_fetch_array($SqlInforme);
		echo 
		'<tr>
			<td>'.$RegInforme['id_paciente'].'</td>
			<td>'.$RegInforme['paciente'].'</td>
			<td>'.$RegInforme['desc_sexo'].'</td>
			<td>'.$RegInforme['edad'].'(S)</td>
			<td>'.$RegInforme['desc_eps'].'</td>
			<td>'.$RegInforme['tel'].'</td>
			<td>'.$RegInforme['descservicio'].'</td>
			<td>'.$RegInforme['nom_estudio'].'</td>
			<td>'.$RegInforme['desc_tecnica'].'</td>
		</tr>';	
	}
}
?>
</table>
</body>
</html>