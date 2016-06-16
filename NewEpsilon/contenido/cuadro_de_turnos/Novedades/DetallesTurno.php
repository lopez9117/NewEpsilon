<?php
	//Conexion a la base de datos
	require_once('../../../dbconexion/conexion.php');
	//funcion para abrir conexion
	$cn = Conectarse();
	//variables con GET
	$fecha = base64_decode($_GET['Fecha']);
	$funcionario  = base64_decode($_GET['Funcionario']);
	//consultar turnos del funcionario en la fecha seleccionada
	$consTurnos = mysql_query("SELECT t.hr_inicio, t.hr_fin, t.idConvencion, t.idsede, t.idservicio, s.descsede, ser.descservicio, c.alias
	FROM turno_funcionario t
	INNER JOIN sede s ON s.idsede = t.idsede
	INNER JOIN servicio ser ON ser.idservicio = t.idservicio
	INNER JOIN convencion_cuadro c ON c.id = t.idConvencion WHERE t.idfuncionario = '$funcionario' AND fecha = '$fecha'", $cn);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Detalles de Turno :.</title>
<style type="text/css">
	body{background-color:#FFF;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	}
</style>
</head>

<body>
<table width="100%" border="1" rules="all">
  <tr>
    <td width="25%" align="center"><strong>Sede</strong></td>
    <td width="25%" align="center"><strong>Servicio</strong></td>
    <td width="25%" align="center"><strong>Hora de inicio</strong></td>
    <td width="25%" align="center"><strong>Hora de finalización</strong></td>
  </tr>
  <?php
  	while($rows = mysql_fetch_array($consTurnos))
	{
		echo 
		'<tr>
			<td width="25%" align="center">'.$rows['descsede'].'</td>
			<td width="25%" align="center">'.$rows['descservicio'].'</td>
			<td width="25%" align="center">'.$rows['hr_inicio'].'</td>
			<td width="25%" align="center">'.$rows['hr_fin'].'</td>
  		</tr>';
	}
  ?>
</table>
</body>
</html>