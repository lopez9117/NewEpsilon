<?php 
//linea que convierte archivo a excel
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=SoporteCompras.xls");
header("Pragma: no-cache");
header("Expires: 0");
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
//consulta para obtener los datos del especialista
$listado =  mysql_query("SELECT CONCAT(f.nombres,' ',f.apellidos) AS nombres, s.descsede, so.fechahora_solicitud,so.horasolicitud,
so.fechahora_visita,so.horavisita, e.descestado_solicitud, CONCAT(fr.nombres,' ',fr.apellidos) AS funcionario, tp.desc_prioridad,
p.desc_presupuesto,t.desc_tiposolicitud,ta.tipo, so.desc_requerimiento, descservicio FROM solicitud so
INNER JOIN sede s ON s.idsede = so.idsede
INNER JOIN estado_solicitud e ON e.idestado_solicitud = so.idestado_solicitud
INNER JOIN funcionario f ON f.idfuncionario= so.idfuncionario
INNER JOIN tipo_prioridad tp ON tp.idprioridad = so.idprioridad
INNER JOIN funcionario fr ON so.idfuncionarioresponde = fr.idfuncionario
INNER JOIN presupuestado p ON p.id_presupuesto = so.id_presupuesto
INNER JOIN tipo_solicitud t ON t.id_tiposolicitud = so.id_tiposolicitud
INNER JOIN tipo_adquisicion ta ON ta.id_adquisicion = so.id_adquisicion
INNER JOIN servicio ser ON ser.idservicio=so.idservicio
WHERE so.idarea='3' AND fechahora_solicitud BETWEEN '$DESDE' AND '$HASTA' ORDER BY so.fechahora_solicitud desc;",$cn);


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
<table cellpadding="0" cellspacing="0" rules="all" border="1">
<tr bgcolor="#0066FF">
        <th align="left">Nombre/Apellido</th><!--Estado-->
        <th align="left">Sede</th>
        <th align="left">Servicio</th>
        <th align="left">Fecha/hora Solicitud</th>
        <th align="left">Fecha/hora Aprobación</th>
        <th align="left">Estado Solicitud</th>
        <th align="left">Aprobado por:</th>
        <th align="left">Tipo Prioridad</th>
        <th align="left">Presupuesto</th>
        <th align="left">Tipo Solicitud</th>
        <th align="left">Tipo Adquisición</th>
        <th align="left">Requerimiento</th>
    </tr>
    <?php


   while($reg=  mysql_fetch_array($listado))
   {
       echo '<tr>';
	   echo '<td align="left">'.$reg['nombres'].'</td>';
	   echo '<td align="left">'.$reg['descsede'].'</td>';
	  echo '<td align="left">'.$reg['descservicio'].'</td>'; 
       echo '<td align="left">'.$reg['fechahora_solicitud'].'/'.$reg['horasolicitud'].'</td>';
	   echo '<td align="left">'.$reg['fechahora_visita'].'/'.$reg['horavisita'].'</td>';
	   echo '<td align="left">'.$reg['descestado_solicitud'].'</td>';
       echo '<td align="left">'.$reg['funcionario'].'</td>';
	   echo '<td align="left">'.$reg['desc_prioridad'].'</td>';
	   echo '<td align="left">'.$reg['desc_presupuesto'].'</td>';
	   echo '<td align="left">'.$reg['desc_tiposolicitud'].'</td>';
	   echo '<td align="left">'.$reg['tipo'].'</td>';
	    echo '<td align="left">'.$reg['desc_requerimiento'].'</td>';
       echo '</tr>';
   }
    ?>