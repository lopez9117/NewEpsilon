<?php
	//conexion a la base de datos
	require_once("../../dbconexion/conexion.php");
	$cn = conectarse();
	//variables con POST
	$fechaIni = $_GET[FchDesde]; 
	$fechaFin = $_GET[FchHasta]; 
	$sede=$_GET[sede];
	header("Content-Type: application/vnd.ms-excel");

header("Expires: 0");

header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

header("content-disposition: attachment;filename=Eventos_Adversos.xls");
	//consulta
	$conInformes = mysql_query("SELECT i.id_informe,i.id_paciente,p.nom1,p.nom2,p.ape1,p.ape2,s.descservicio,e.nom_estudio,t.desc_tecnica, se.descsede, i.ubicacion, l.id_estadoinforme, ei.desc_estado FROM r_log_informe l
INNER JOIN r_informe_header i ON i.id_informe=l.id_informe
INNER JOIN r_estadoinforme ei ON l.id_estadoinforme=ei.id_estadoinforme
INNER JOIN r_paciente p ON i.id_paciente=p.id_paciente
INNER JOIN servicio s ON i.idservicio=s.idservicio
INNER JOIN r_estudio e ON i.idestudio=e.idestudio
INNER JOIN r_tecnica t ON i.id_tecnica=t.id_tecnica 
INNER JOIN sede se ON i.idsede=se.idsede
WHERE l.fecha BETWEEN '$fechaIni' AND '$fechaFin' AND i.idsede = '$sede' AND l.id_estadoinforme='6' OR l.fecha BETWEEN '$fechaIni' AND '$fechaFin' AND i.idsede = '$sede' AND l.id_estadoinforme='7'", $cn);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Reporte de produccion por sede :.</title>
</head>
<style type="text/css">
	body
	{font-family:Verdana, Geneva, sans-serif;
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
    <td>N° documento Paciente</td>
    <td>1er nombre</td>
    <td>2do nombre</td>
    <td>1er apellido</td>
    <td>2do apellido</td>
    <td>Ubicacion</td>
    <td>Servicio</td>
    <td>Estudio</td>
    <td>Tecnica</td>
    <td>Estado informe</td>
    <td>Comentario</td>
  </tr>
  <!-- Imprimir Ciclo -->
  <?php
  while($rowInformes = mysql_fetch_array($conInformes))
	{	
	$idInforme=$rowInformes[id_informe];	
		echo 
		'<tr>
			<td>'.$rowInformes[id_paciente].'</td>
			<td>'.$rowInformes[nom1].'</td>
			<td>'.$rowInformes[nom2].'</td>
			<td>'.$rowInformes[ape1].'</td>
			<td>'.$rowInformes[ape2].'</td>
			<td>'.$rowInformes[ubicacion].'</td>
			<td>'.$rowInformes[descservicio].'</td>
			<td>'.$rowInformes[nom_estudio].'</td>
			<td>'.$rowInformes[desc_tecnica].'</td>
			<td>'.$rowInformes[desc_estado].'</td>';
			$observacion = mysql_query("SELECT o.observacion, o.fecha, o.hora, f.nombres, f.apellidos FROM r_observacion_informe o
		INNER JOIN funcionario f ON f.idfuncionario = o.idfuncionario
		WHERE id_informe='$idInforme' AND observacion != ''", $cn);
		
		echo '<td>';
		while($row = mysql_fetch_array($observacion))
		{
			echo '<strong>'.$row[nombres].' '.$row[apellidos].' Comento el '.$row[fecha].' a las '.$row[hora].'</strong>';
			echo $row[observacion];
		}
		echo '</td>
		</tr>';
	}
  ?>
</table>
</body>
</html>