<?php
ini_set('max_execution_time', 0);
//conexion a la base de datos
include("../../dbconexion/conexion.php");
$cn = conectarse();
//variables con POST
$desde = base64_decode($_GET['FchDesde']); 
$hasta = base64_decode($_GET['FchHasta']); 
$idSede = base64_decode($_GET['sede']);
$NomSede = base64_decode($_GET['NomSede']);
//obtener los estudios cancelados
$ConCancelados = mysql_query("SELECT DISTINCT(c.id_informe), c.comentario, c.fecha, CONCAT(f.nombres, ' ', f.apellidos) AS funcionario,
m.desc_motivo, i.id_paciente, CONCAT(p.nom1,' ',p.nom2,' ',p.ape1,' ',p.ape2) AS paciente, ser.descservicio,
est.nom_estudio, sed.descsede FROM r_comentmotivocancel c
INNER JOIN funcionario f ON f.idfuncionario = c.idfuncionario
INNER JOIN r_motivocancel m ON m.id_motivo = c.id_motivo
INNER JOIN r_informe_header i ON i.id_informe = c.id_informe
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN servicio ser ON ser.idservicio = i.idservicio
INNER JOIN r_estudio est ON est.idestudio = i.idestudio
INNER JOIN sede sed ON sed.idsede = i.idsede
WHERE c.fecha BETWEEN '$desde' AND '$hasta' AND i.idsede = '$idSede' ORDER BY fecha ASC", $cn);
//lineas para exportar a excel
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Cancelaciones".$desde.'/'.$hasta.".".$NomSede.".xls");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Informe Cancelaciones :.</title>
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
</head>

<body>
<table width="100%" border="1" rules="all">
  <tr class="header">
    <td>Id. Paciente</td>
    <td>Nombres y Apellidos.</td>
    <td>Estudio</td>
    <td>Servicio</td>
    <td>Sede</td>
    <td>Funcionario</td>
    <td>Fecha / Hora de cancelación</td>
    <td>Motivo / Razón</td>
    <td>Observaciones</td>
  </tr>
 <?php
 	//Imprimir los registros arrojados por la consulta
	while($rowCancelado = mysql_fetch_array($ConCancelados))
	{
  	echo 
	  '<tr>
		<td>'.$rowCancelado['id_paciente'].'</td>
		<td>'.$rowCancelado['paciente'].'</td>
		<td>'.$rowCancelado['nom_estudio'].'</td>
		<td>'.$rowCancelado['descservicio'].'</td>
		<td>'.$rowCancelado['descsede'].'</td>
		<td>'.$rowCancelado['funcionario'].'</td>
		<td>'.$rowCancelado['fecha'].'</td>
		<td>'.$rowCancelado['desc_motivo'].'</td>
		<td>'.$rowCancelado['comentario'].'</td>
	  </tr>';
	}
	?>
</table>
</body>
</html>