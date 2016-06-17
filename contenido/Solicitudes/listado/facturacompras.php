<?php
session_start();
require_once('../../../dbconexion/conexion.php');
include("../../select/selectsListado.php");
//funcion para abrir conexion
$cn = Conectarse();
$id=$_GET['id'];
$_SESSION['area'] = $area;
$listado=mysql_query("SELECT so.idfuncionario, so.idfuncionarioresponde, so.asunto, so.idsolicitud, so.fechahora_visita,so.horavisita, so.asunto, so.idsolicitud, so.desc_requerimiento, so.fechahora_solicitud, so.horasolicitud, so.idsatisfaccion,
s.descsede, s.codigo, CONCAT(f.nombres, f.apellidos) AS nombre, p.desc_prioridad, tp.desc_tiposolicitud, ser.descservicio, so.idservicio, ad.tipo  FROM solicitud so
INNER JOIN tipo_adquisicion ad ON ad.id_adquisicion=so.id_adquisicion
INNER JOIN sede s ON s.idsede = so.idsede
INNER JOIN funcionario f ON f.idfuncionario= so.idfuncionario
INNER JOIN tipo_prioridad p ON p.idprioridad= so.idprioridad
INNER JOIN tipo_solicitud tp ON tp.id_tiposolicitud= so.id_tiposolicitud
INNER JOIN servicio ser ON ser.idservicio=so.idservicio
WHERE idsolicitud='$id'",$cn);
$listapresupuesto=mysql_query("SELECT desc_presupuesto,so.id_presupuesto FROM presupuestado pre
INNER JOIN solicitud so ON pre.id_presupuesto=so.id_presupuesto where so.idsolicitud='$id'",$cn);
$regpresupuesto= mysql_fetch_array($listapresupuesto);
$reg= mysql_fetch_array($listado);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
<head>
<title>Factura Compra</title>
</head>
<body>
<table border="1" align="center" width="100%">
  <tr>
    <td colspan="2"><strong>Empresa: </strong>Prodiagn&oacute;stico S.A</td>
    <td width="47%" rowspan="4"><img src="../../../images/prodiagnostico.png" width="242" height="85" id="Image1"></td>
  </tr>
  <tr>
    <td colspan="2"><strong>Empleado: </strong><?php echo $reg['nombre'].' '.$reg['apellidos']; ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>Centro de Costos: </strong><?php echo $reg['codigo'].' - '.$reg['descsede'].' / '.$reg['idservicio'].' - '.$reg['descservicio']; ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>Codigo Solicitud: </strong> <?php echo $reg['idsolicitud']; ?></td>
  </tr>
  <tr>
    <td height="23" colspan="3" align="center"><strong>Descripci&oacute;n de la Solicitud</strong></td>
  </tr>
  <tr>
    <td colspan="2">
    <strong>Fecha Solicitud: </strong><?php echo  $reg['fechahora_solicitud']; ?></br>
    <strong>Asunto: </strong><?php echo  $reg['asunto']; ?> </br>
     <strong>Tipo Prioridad: </strong><?php echo  $reg['desc_prioridad']; ?> </br>
      
        </td>
    <td><strong>Fecha de Aprobaci&oacute;n:</strong> <?php echo  $reg['fechahora_visita']; ?></br>
    <strong>Tipo Solicitud: </strong><?php echo  $reg['desc_tiposolicitud']; ?> </br>
    <strong>Tipo Adquisición: </strong><?php echo  $reg['tipo']; ?> </br></td>
  </tr>
  <tr>
    <td height="23" colspan="3"><strong>Solicitud: </strong><?php echo  utf8_decode($reg['desc_requerimiento']); ?></td>
  </tr>
  <tr>
    <td width="52%" height="23"><br />____________________<br />
      <strong>Firma</strong><br />
    <strong></strong><?php echo  $reg['nombre']; ?></td>
    <td colspan="2" height="23"><br />_____________________<br />
    <strong>Sello Revisado</strong><br /><br /></td>
  </tr>
</table>

</body>
</html>

