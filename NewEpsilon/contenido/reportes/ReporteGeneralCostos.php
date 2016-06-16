<?php
	//conexion a la base de datos
	require_once("../../dbconexion/conexion.php");
	$cn = conectarse();
	//variables POST
	$fechaInicio = $_GET[fechaInicio] ;
	$fechaStop = $_GET[fechaStop] ;
	$sede = $_GET[sede];
	
	$sql = mysql_query("SELECT DISTINCT t.idfuncionario, f.nombres, f.apellidos, f.salario FROM turno_funcionario t
INNER JOIN funcionario f ON f.idfuncionario = t.idfuncionario
WHERE t.fecha BETWEEN '$fechaInicio' AND '$fechaStop' AND t.idsede = '$sede'
ORDER BY apellidos ASC", $cn);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Reporte General :.</title>
<style type="text/css">
	body
	{font-size:10px;
	font-family:Arial, Helvetica, sans-serif;
	}
</style>
<link rel="stylesheet" type="text/css" href="../../css/cuadroTurnos.css" />
</head>
<body>
<table width="100%" border="1" rules="all" align="center">
  <tr align="center" id="table">
    <td>N° Documento</td>
    <td>Apellidos / Nombres</td>
    <td>Salario</td>
    <td>Cargo</td>
    <td>Sede</td>
    <td>Servicio</td>
    <td>Diurnas</td>
    <td>Nocturnas</td>
    <td>Diurnas<br>Festivas</td>
    <td>Nocturnas<br>Festivas</td>
    <td>Diurnas<br>Adicionales</td>
    <td>Nocturnas<br>Adicionales</td>
    <td>Diurnas<br>Festivas Adicionales</td>
    <td>Nocturnas<br>Festivas Adicionales</td>
  </tr>
  <?php
  	while($row = mysql_fetch_array($sql))
	{
		$docFuncionario = $row[idfuncionario];
		$nombres = $row[apellidos].'&nbsp;'.$row[nombres];
		
		//consultar todos los turnos del funcionario
		$sqlTurnos = mysql_query("SELECT t.idturno, t.hr_inicio, t.hr_fin, t.fecha, t.diurna, t.diurnafest, t.nocturna, t.nocturnafest,
s.descsede, se.descservicio, g.desc_grupoempleado FROM turno_funcionario t
INNER JOIN sede s ON s.idsede = t.idsede
INNER JOIN servicio se ON se.idservicio = t.idservicio
INNER JOIN grupo_empleado g ON g.idgrupo_empleado = t.idgrupo_empleado
WHERE t.idfuncionario = '$docFuncionario' AND t.fecha BETWEEN '$fechaInicio' AND '$fechaStop'", $cn);

		while($rowTurnos = mysql_fetch_array($sqlTurnos))
		{
			$idTurno = $rowTurnos[idturno];
			
			$sqlNovedad = mysql_query("SELECT diurnas_adicionales, nocturnas_adicionales, diurfest_adicionales, nocfest_adicionales
FROM novedad_turno WHERE idturno = '$idTurno'", $cn);
			$regNovedad = mysql_num_rows($sqlNovedad);
			$reg = mysql_fetch_array($sqlNovedad);
			
			if($regNovedad>=1)
			{
				echo 
				'<tr align="center">
					<td>'.$docFuncionario.'</td>
					<td>'.$nombres.'</td>
					<td>'.$row[salario].'</td>
					<td>'.$rowTurnos[desc_grupoempleado].'</td>
					<td>'.$rowTurnos[descsede].'</td>
					<td>'.$rowTurnos[descservicio].'</td>
					<td>'.$rowTurnos[diurna].'</td>
					<td>'.$rowTurnos[nocturna].'</td>
					<td>'.$rowTurnos[diurnafest].'</td>
					<td>'.$rowTurnos[nocturnafest].'</td>
					<td>'.$reg[diurnas_adicionales].'</td>
					<td>'.$reg[nocturnas_adicionales].'</td>
					<td>'.$reg[diurfest_adicionales].'</td>
					<td>'.$reg[nocfest_adicionales].'</td>
				</tr>';	
			}
			else
			{
				echo 
				'<tr align="center">
					<td>'.$docFuncionario.'</td>
					<td>'.$nombres.'</td>
					<td>'.$row[salario].'</td>
					<td>'.$rowTurnos[desc_grupoempleado].'</td>
					<td>'.$rowTurnos[descsede].'</td>
					<td>'.$rowTurnos[descservicio].'</td>
					<td>'.$rowTurnos[diurna].'</td>
					<td>'.$rowTurnos[nocturna].'</td>
					<td>'.$rowTurnos[diurnafest].'</td>
					<td>'.$rowTurnos[nocturnafest].'</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
				</tr>';	
			}
		}
  	}
  ?>
</table>
</body>
</html>