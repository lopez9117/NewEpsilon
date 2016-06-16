<?php 
//Conexion a la base de datos
require_once('../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$id = $_GET[id];
include('listado/consulta.php');
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body>
<table border="1" align="center" width="90%">
  <tr>
    <td height="10" rowspan="4">
    <a class="class_nombre" style="text-decoration:none" href="opciones.php?modulo=1">
				<img src="../../images/prodiagnostico.png" width="190" height="83" id="Image1" border="0"></a>
    </td>
    <td height="10" rowspan="4" align="center""><strong>SOLICITUD REQUERIMIENTO DE SISTEMAS</strong></td>
  </tr>
  <tr>
    <td height="37"><strong>Versi&oacute;n:</strong> 5</td>
  </tr>
    <td><strong>C&oacute;digo:</strong>
    PA-RSI-03</td>
  </tr>
<p><br></p>
</table>

<p>&nbsp;</p>
<table width="90%"border="1" align="center">
  <tr>
    <td width="325" rowspan="2"><strong>Sede:</strong>&nbsp;&nbsp; <?php echo strtoupper($regSolicitud['descsede']); ?></td>
    <td colspan="3"><strong>Fecha de Solicitud:</strong></td>
  </tr>
  <tr>
    <td width="45"><strong>Año</strong></td>
    <td width="46"><strong>Mes</strong></td>
    <td width="93"><strong>Dia</strong></td>
  </tr>
  <tr>
    <td rowspan="2"><strong>Nombre:</strong>&nbsp;&nbsp; <?php echo strtoupper($regSolicitud['nombres'].' '.$regSolicitud['apellidos']); ?></td>
    <td><?php $fecha=$regSolicitud['fechahora_solicitud'];
	   list($año, $mes, $dia) = explode("-",$fecha);
	   echo $año; ?></td>
       <td><?php echo $mes; ?></td>
       <td><?php echo $dia; ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>Hora:</strong></td>
    <td><?php echo $regSolicitud['horasolicitud']; ?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><strong>Se Solicita: Mantenimiento:</strong> Preventivo:_ _  Mantenimiento Correctivo: _ _ Otros: _ _</td>
  </tr>
  <tr>
    <td colspan="4"><strong>Descripci&oacute;n del Requerimiento:&nbsp;</strong>&nbsp; <?php echo strtoupper($regSolicitud['desc_requerimiento']); ?>
    </td>
  </tr>
  <tr>
    <td colspan="4" bgcolor="#999999"><strong>Espacio reservado para el coordinador de sistemas.</strong></td>
  </tr>
  <tr>
    <td rowspan="4"><strong>Observaciones:</strong>&nbsp;&nbsp;<?php echo $regSolicitud['Diagnostico']; ?><br><br><br><br></td>
    <td colspan="3"><strong>Fecha de Visita:</strong><br></td>
  </tr>
  <tr>
    <td width="45"><strong>Año</strong></td>
    <td width="46"><strong>Mes</strong></td>
    <td width="93"><strong>Dia</strong></td>
  </tr>
  <tr>
  <td><?php $fecha2=$regSolicitud['fechahora_visita'];;
	   list($año, $mes, $dia) = explode("-",$fecha2);
	   echo $año; ?></td>
       <td><?php echo $mes; ?></td>
       <td><?php echo $dia; ?></td>
  <tr>
    <td colspan="2" aling="center"><strong>Hora:</strong></td>
    <td aling="center"><?php echo $regSolicitud['horavisita']; ?></td>
  </tr>
  <tr>
    <td colspan="4"><br>
    <strong>Firma de Usuario: </strong>_______________________ <br>
    <br>
    <strong>Firma de Coordinador:</strong> _______________________<br></td>
  </tr>
  <tr>
    <td colspan="4"><strong>&iquest;Se cumpli&oacute; con el requerimiento?:</strong> &nbsp;&nbsp;<?php echo $regSolicitud['descestado_solicitud'] ?> <br><br>
      <strong>&iquest;Por qu&eacute;?</strong><br><?php echo $regSolicitud['porque'] ?><br>
</td>
  </tr>
  <tr>
    <td colspan="2">FUM: 17/07/2013</td>
    <td height="41" colspan="2" align="right"><p><img src="../../images/iso.jpg" width="80" height="37" alt="iso"/></p></td>
  </tr> 
</table>
</body>
</html>