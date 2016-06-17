<?php 
//Conexion a la base de datos
require_once('../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$id = $_GET[id];
include('listado/consulta.php');
$fecha=$regSolicitud['fechahora_solicitud'];
	   list($año, $mes, $dia) = explode("-",$fecha);
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body>
<table border="1" align="center" width="100%">
  <tr>
    <td width="25%" height="10" rowspan="4">
				<img src="../../images/prodiagnostico.png" width="206" height="86" id="Image1" border="0">
    </td>
    <td width="38%" height="10" rowspan="4" align="center"><strong>INFORME DE SERVICIO</strong></td>
    <td width="25%"><strong>Fecha de aprobación:</strong> 03/04/2012</td>
  </tr>
  <tr>
    <td><strong>Versi&oacute;n:</strong>1</td>
  </tr>
  <tr>
    <td><strong>C&oacute;digo:</strong>PA-RGL-26</td>
  </tr>
   <tr>
    <td><strong>P&aacute;gina</strong> 1 de 1</td>
  </tr>
<p><br></p>
    <td><strong>Elaboraci&oacute;n:</strong>  Maritza Fernanda Toro Estrada,<br>Coordinadora de Suministros 
</td>
    <td align="center"><strong>Revisi&oacute;n:</strong> Coordinadora de Calidad</td>
    <td><strong>Aprobaci&oacute;n:</strong> Coordinadora de calidad
</td>
</table>
<br>
<table width="100%"border="1" align="center">
  <tr>
  <td colspan="6" align="center" bgcolor="#CCCCCC"><strong>DATOS DEL SERVICIO</strong></td>
  </tr>
  <tr>
    <td width="117">SEDE:</td>
    <td width="87"><?php echo strtoupper($regSolicitud['descsede']); ?></td>
    <td width="100">CONSECUTIVO:</td>
    <td colspan="3"><?php echo $id; ?></td>
  </tr>
  <tr>
    <td>SERVICIO:</td>
    <td>AYUDAS DIAGNOSTICAS</td>
    <td rowspan="2">FECHA:</td>
    <td width="38" align="center">DD</td>
    <td width="32" align="center">MM</td>
    <td width="33" align="center">AAAA</td>
  </tr>
  <tr>
    <td>CONTACTO:</td>
    <td><?php echo strtoupper($regSolicitud['nombres'].' '.$regSolicitud['apellidos']); ?></td>
    <td width="38" align="center"><?php echo $dia?></td>
    <td align="center"><?php echo $mes?></td>
    <td align="center"><?php echo $año?></td>
  </tr>
  <tr>
    <td colspan="6" align="center" bgcolor="#CCCCCC"><strong>DATOS DEL EQUIPO</strong></td>
  </tr>
  <tr>
    <td>EQUIPO:</td>
    <td>MARCA:</td>
    <td>MODELO:</td>
    <td colspan="2">SERIE:</td>
    <td>No INVENTARIO:</td>
  </tr>
  <tr>
    <td><?php echo strtoupper($regferencia[equipo])?></td>
    <td><?php echo strtoupper($regferencia[marca])?></td>
    <td>&nbsp;</td>
    <td colspan="2"><?php echo strtoupper($regferencia[serie])?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" align="center" bgcolor="#CCCCCC"><strong>TIPO DE SERVICIO</strong></td>
  </tr>
  <tr>
    <td>PREVENTIDO:</td>
    <td>CORRECTIVO:</td>
    <td colspan="2">INDUCCIÓN:</td>
    <td colspan="2">OTRO:</td>
  </tr>
  <tr>
    <td colspan="6" align="center" bgcolor="#CCCCCC"><strong>FALLA REPORTADA</strong></td>
  </tr>
  <tr>
    <td colspan="6"><?php echo strtoupper($regSolicitud['desc_requerimiento']); ?>
    </td>
  </tr>
  <tr>
    <td colspan="6" bgcolor="#CCCCCC" align="center"><strong>DESCRIPCION DEL TRABAJO REALIZADO</strong></td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" bgcolor="#CCCCCC" align="center"><strong>ESTADO DEL EQUIPO</strong></td>
  </tr>
  <tr>
    <td>CONCLUIDO:</td>
    <td>EN PROCESO:</td>
    <td colspan="2">FUERA DE SERVICIO:</td>
    <td colspan="2">OTRO:</td>
  </tr>
  <tr>
    <td colspan="6" bgcolor="#CCCCCC" align="center"><strong>REPUESTO REQUERIDO</strong></td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" bgcolor="#CCCCCC" align="center"><strong>OBSERVACIONES</strong></td>
  </tr>
  <tr>
  
    <td colspan="6"> <?php
		while($row = mysql_fetch_array($observacion))
		{
		echo '<strong>'.$row[nombres].' '.$row[apellidos].', COMENTO: </strong>'.$row[observacion].'<br>';
		}
		?></td>
  </tr>
  </table>
  <br>
<table width="100%" align="center">
  <tr>
    <td width="39%" align="center" bgcolor="#CCCCCC" style="border:1px solid;padding:3px 3px;"><strong>REALIZADO POR:</strong></td>
    <td width="22%">&nbsp;</td>
    <td width="39%" align="center" bgcolor="#CCCCCC" style="border:1px solid;padding:3px 3px;"><strong>RECIBIDO A CONFORMIDAD POR:</strong></td>
  </tr>
  <tr>
    <td align="center" style="border:1px solid;padding:3px 3px;"> <?php echo strtoupper($reg2['nombres'].' '.$reg2['apellidos']);?></td>
    <td>&nbsp;</td>
    <td align="center" style="border:1px solid;padding:3px 3px;"> <?php echo strtoupper($regSolicitud['nombres'].' '.$regSolicitud['apellidos']);?></td>
  </tr>
</table>
</body>
</html>