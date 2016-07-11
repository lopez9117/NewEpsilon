<?php
//archivo de conexion a la BD
	require_once("../../../dbconexion/conexion.php");
	$cn = conectarse();	
	//Variables por GET
	$fecha = base64_decode($_GET['fecha']);
	$horaIni = base64_decode($_GET['HoraIni']);
	$horaFin = base64_decode($_GET['HoraFin']);
	$sede = base64_decode($_GET['sede']);
	$servicio = base64_decode($_GET['servicio']);
	//convertir formato de fecha
	$fecha = date("Y-m-d",strtotime($fecha));
	$sql = mysql_query("SELECT DISTINCT(i.id_informe), i.id_paciente, i.ubicacion, i.id_tecnica,
	l.fecha, l.hora, CONCAT(p.nom1,' ',p.nom2,' ',p.ape1,' ',p.ape2) AS paciente, e.nom_estudio,
	tp.desctipo_paciente, tec.desc_tecnica FROM r_informe_header i
	INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
	INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
	INNER JOIN r_estudio e ON e.idestudio = i.idestudio
	INNER JOIN servicio ser ON ser.idservicio = i.idservicio
	INNER JOIN r_tipo_paciente tp ON tp.idtipo_paciente = i.idtipo_paciente
	INNER JOIN r_tecnica tec ON tec.id_tecnica = i.id_tecnica
	WHERE l.fecha = '$fecha' AND l.hora BETWEEN '$horaIni' AND '$horaFin' AND i.idsede = '$sede' AND i.idservicio = '$servicio' 
	AND l.id_estadoinforme = '1' ORDER BY l.hora ASC", $cn);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Imprimir Agenda :.</title>
<style type="text/css">
body
{
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
}
</style>
<body>
<table width="100%" cellpadding="0" cellspacing="0" border="1" rules="all">
<thead>
    <tr bgcolor="#CCCCCC">
    	<th align="center" width="5%">Fecha</th>
    	<th align="center" width="5%">Hrs</th>
        <th align="center" width="10%">N° Documento</th>
        <th align="center" width="20%">Nombres y Apellidos</th>
        <th align="center" width="30%">Estudio</th>
        <th align="center" width="8%">Tecnica</th>
        <th align="center" width="14%">Ubicacion</th>
        <th align="center" width="8%">T. Paciente</th>
    </tr>
  <tbody>
    <?php
   while($reg =  mysql_fetch_array($sql))
   {
       echo '<tr>';
	   echo '<td align="center">'.$fecha.'</td>';
	   echo '<td align="center">'.$reg['hora'].'</td>';
       echo '<td align="center">'.$reg['id_paciente'].'</td>';
       echo '<td align="center">'.$reg['paciente'].'</td>';
	   echo '<td align="center">'.$reg['nom_estudio'].'</td>';
	   echo '<td align="center">'.$reg['desc_tecnica'].'</td>';
	   echo '<td align="center">'.$reg['ubicacion'].'</td>';
	   echo '<td align="center">'.$reg['desctipo_paciente'].'</td>';
       echo '</tr>';
   }
    ?>
<tbody>
</table>
</body>