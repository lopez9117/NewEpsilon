<?php
	include('../../../dbconexion/conexion.php');
	$cn = Conectarse();
	//declaracion de variables con GET
	$idFuncionario = base64_decode($_GET['document']);
	$fechaInicial = base64_decode($_GET['fchstart']);
	$fechaLimite = base64_decode($_GET['fchstop']);
	$nombres = base64_decode($_GET['nomb']);
	//consultar la cantidad de turnos registrador para el funcionario
	$sql = mysql_query("SELECT t.idturno, t.hr_inicio, t.hr_fin, t.fecha, t.diurna, t.diurnafest, t.nocturna, t.nocturnafest, t.hralmuerzo,
	f.nombres, f.apellidos, s.descsede, ser.descservicio FROM turno_funcionario t
	INNER JOIN funcionario f ON f.idfuncionario = t.idfuncionario
	INNER JOIN sede s ON s.idsede = t.idsede
	INNER JOIN servicio ser ON ser.idservicio = t.idservicio WHERE t.fecha BETWEEN '$fechaInicial' AND '$fechaLimite'
	AND t.idfuncionario = '$idFuncionario' ORDER BY t.fecha ASC", $cn);	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<meta http-equiv=Content-Type content="text/html; charset=ISO-8859-1">
<title>Reporte de horas</title>
<link type="text/css" href="../../../css/cuadroTurnos.css" rel="stylesheet" media="screen"/>
<script src="../../../js/ajax.js" type="text/javascript"></script>
<style type="text/css">
	body{font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	}
	fieldset
	{width:95%;
	margin-left:2%}
	table
	{width:100%;
	}
</style>
</head>
<body>
<fieldset>
	<legend><strong>Reporte de horas para:</strong> <?php echo $nombres ?> <strong>Periodo:</strong> <?php echo $fechaInicial .'&nbsp;/&nbsp;'.$fechaLimite ?></legend>

<table width="90%" border="1" align="center" rules="all">
  <tr align="center" id="table">
  	<td>Dia</td>
    <td>Fecha</td>
    <td>Sede</td>
    <td>Servicio</td>
    <td>Hr. Inicio</td>
    <td>Hr. Final</td>
    <td>Diurnas</td>
    <td>Nocturnas</td>
    <td>D. Festivas</td>
    <td>N. Festivas</td>
    <td>Total Turno</td>
    <!--<td>Hora de almuerzo</td>-->
    <td colspan="8">Novedad</td>
  </tr>
    <tr align="center" id="table">
    	<td colspan="11">&nbsp;</td>
        <td>Hr. Inicio</td>
        <td>Hr. Final</td>
        <td>Diurnas</td>
        <td>Nocturnas</td>
        <td>D. Festivas</td>
        <td>N. Festivas</td>
  </tr>
  <?php
  	while($row = mysql_fetch_array($sql))
	{
		$idTurno = $row['idturno'];
		$fecha = $row['fecha'];
		list($anio, $mes, $dia) = explode("-",$fecha);
		$wkdy = (((mktime ( 0, 0, 0, $mes, $dia, $anio) - mktime ( 0, 0, 0, 7, 17, 2006))/(60*60*24))+700000) % 7;
		if($wkdy == 0)
		{$dia_semana = 'L';	}
		elseif ($wkdy == 1)
		{$dia_semana = 'M';	}
		elseif ($wkdy == 2)
		{$dia_semana = 'W';	}
		elseif ($wkdy == 3)
		{$dia_semana = 'J';	}
		elseif ($wkdy == 4)
		{$dia_semana = 'V';	}
		elseif ($wkdy == 5)
		{$dia_semana = 'S';	}
		elseif ($wkdy == 6)
		{$dia_semana = 'D'; }
		$sqlHoras = mysql_query ("SELECT SUM(t.diurna+t.diurnafest+t.nocturna+t.nocturnafest) AS total
FROM turno_funcionario t WHERE t.idturno = '$idTurno'", $cn);
		$regTurno = mysql_fetch_array($sqlHoras);
		$sqlNovedad = mysql_query("SELECT * FROM novedad_turno WHERE idturno = '$idTurno'", $cn);
		$conNovedad = mysql_num_rows($sqlNovedad);
		if($wkdy==6)
		{
			echo
			'<tr align="center" id="table">
				<td>'.$dia_semana.'</td>
				<td>'.$row['fecha'].'</td>
				<td>'.$row['descsede'].'</td>
				<td>'.$row['descservicio'].'</td>
				<td>'.$row['hr_inicio'].'</td>
				<td>'.$row['hr_fin'].'</td>
				<td>'.round($row['diurna'], 2).'</td>
				<td>'.round($row['nocturna'], 2).'</td>
				<td>'.round($row['diurnafest'], 2).'</td>
				<td>'.round($row['nocturnafest'], 2).'</td>
				<td>'.round($regTurno['total'], 2).'</td>';
				/*if($row['hralmuerzo']==2)
				{
					echo '<td><input type="checkbox" checked="checked" onclick="ModificarTotal('.$idTurno.')" name="'.$idTurno.'" id="'.$idTurno.'" /></td>';
				}
				else
				{
					echo '<td><input type="checkbox" onclick="ModificarTotal('.$idTurno.')" name="'.$idTurno.'" id="'.$idTurno.'" /></td>';
				}	*/		
				if($conNovedad<=1 || $conNovedad==0)
				{
					$regNovedad = mysql_fetch_array($sqlNovedad);
					echo '<td>'.$regNovedad['hr_inicio'].'</td>';
					echo '<td>'.$regNovedad['hr_fin'].'</td>';
					echo '<td>'.round($regNovedad['diurnas_adicionales'], 2).'</td>';
					echo '<td>'.round($regNovedad['nocturnas_adicionales'], 2).'</td>';
					echo '<td>'.round($regNovedad['diurfest_adicionales'], 2).'</td>';
					echo '<td>'.round($regNovedad['nocfest_adicionales'], 2).'</td>';
				}
				else
				{
				 echo '<td colspan="8">&nbsp;</td>';
				}
		 	echo '</tr>';
		}
		else
		{
			//consultar si la fecha corresponde a un dia festivo
			$sqlFecha = mysql_query("SELECT fecha_festivo FROM dia_festivo WHERE fecha_festivo = '$fecha'", $cn);
			$regFecha = mysql_num_rows($sqlFecha);
			if($regFecha>=1)
			{
				echo
				'<tr align="center" id="table">
				<td>'.$dia_semana.'</td>
				<td>'.$row['fecha'].'</td>
				<td>'.$row['descsede'].'</td>
				<td>'.$row['descservicio'].'</td>
				<td>'.$row['hr_inicio'].'</td>
				<td>'.$row['hr_fin'].'</td>
				<td>'.round($row['diurna'], 2).'</td>
				<td>'.round($row['nocturna'], 2).'</td>
				<td>'.round($row['diurnafest'], 2).'</td>
				<td>'.round($row['nocturnafest'], 2).'</td>
				<td>'.round($regTurno['total'], 2).'</td>';
				/*if($row[hralmuerzo]==2)
				{
					echo '<td><input type="checkbox" checked="checked" onclick="ModificarTotal('.$idTurno.')" name="'.$idTurno.'" id="'.$idTurno.'" /></td>';
				}
				else
				{
					echo '<td><input type="checkbox" onclick="ModificarTotal('.$idTurno.')" name="'.$idTurno.'" id="'.$idTurno.'" /></td>';
				}*/
				if($conNovedad<=1 || $conNovedad==0)
				{
					$regNovedad = mysql_fetch_array($sqlNovedad);
					echo '<td>'.$regNovedad['hr_inicio'].'</td>';
					echo '<td>'.$regNovedad['hr_fin'].'</td>';
					echo '<td>'.round($regNovedad['diurnas_adicionales'], 2).'</td>';
					echo '<td>'.round($regNovedad['nocturnas_adicionales'], 2).'</td>';
					echo '<td>'.round($regNovedad['diurfest_adicionales'], 2).'</td>';
					echo '<td>'.round($regNovedad['nocfest_adicionales'], 2).'</td>';
				}
				else
				{
				 echo '<td colspan="8">&nbsp;</td>';
				}
			}
			else
			{
				echo
				'<tr align="center">
				<td>'.$dia_semana.'</td>
				<td>'.$row['fecha'].'</td>
				<td>'.$row['descsede'].'</td>
				<td>'.$row['descservicio'].'</td>
				<td>'.$row['hr_inicio'].'</td>
				<td>'.$row['hr_fin'].'</td>
				<td>'.round($row['diurna'], 2).'</td>
				<td>'.round($row['nocturna'], 2).'</td>
				<td>'.round($row['diurnafest'], 2).'</td>
				<td>'.round($row['nocturnafest'], 2).'</td>
				<td>'.round($regTurno['total'], 2).'</td>';
				/*if($row[hralmuerzo]==2)
				{
					echo '<td><input type="checkbox" checked="checked" onclick="ModificarTotal('.$idTurno.')" name="'.$idTurno.'" id="'.$idTurno.'" /></td>';
				}
				else
				{
					echo '<td><input type="checkbox" onclick="ModificarTotal('.$idTurno.')" name="'.$idTurno.'" id="'.$idTurno.'" /></td>';
				}*/
				if($conNovedad<=1 || $conNovedad==0)
				{
					$regNovedad = mysql_fetch_array($sqlNovedad);
					echo '<td>'.$regNovedad['hr_inicio'].'</td>';
					echo '<td>'.$regNovedad['hr_fin'].'</td>';
					echo '<td>'.round($regNovedad['diurnas_adicionales'], 2).'</td>';
					echo '<td>'.round($regNovedad['nocturnas_adicionales'], 2).'</td>';
					echo '<td>'.round($regNovedad['diurfest_adicionales'], 2).'</td>';
					echo '<td>'.round($regNovedad['nocfest_adicionales'], 2).'</td>';
				}
				else
				{
				 echo '<td colspan="8">&nbsp;</td>';
				}	
			}
		 	echo '</tr>';
		}
	}
  ?>
</table>
</fieldset>
<fieldset>
	<legend>Vacaciones</legend>
    <?php
    	//consultar si hay vacaciones registradas en el periodo consultado
		$consVacaciones = mysql_query("SELECT * FROM turno_funcionario WHERE idtipo_turno = '100' AND fecha BETWEEN '$fechaInicial' AND '$fechaLimite' AND idfuncionario = '$idFuncionario'", $cn);
		$contVacaciones = mysql_num_rows($consVacaciones);
		if($contVacaciones>=1)
		{	
			while($rowVacaciones = mysql_fetch_array($consVacaciones))
			{
				echo $rowVacaciones['fecha'].'&nbsp;|&nbsp;';
			}
		}
	?>
</fieldset>
<fieldset>
	<legend>Disponibilidades</legend>
    <?php
    	//consultar disponibilidades del funcionario
		$consDisponibilidades = mysql_query("SELECT * FROM disponibilidad_funcionario WHERE idfuncionario = '$idFuncionario' AND fecha BETWEEN '$fechaInicial' AND '$fechaLimite'", $cn);
		$contDisponibilidades = mysql_num_rows($consDisponibilidades);
		
		if($contDisponibilidades=="" || $contDisponibilidades==0)
		{
			echo 'No se registraron disponibilidades';
		}
		else
		{
			echo '<table border="1" rules="all">
				<tr>
					<td><strong>Fecha</strong></td>
					<td><strong>Equivalente</strong></td>
				</tr>';
			echo '<tr>
					<td>
						<table border="0" rules="all">';
							while($rowDisponibilidad = mysql_fetch_array($consDisponibilidades))
							{
								echo '<tr>
									<td>'.$rowDisponibilidad['fecha'].'</td>
								</tr>';
							}
				echo '</table>
					</td>
					<td align="center">'.round(($contDisponibilidades/7),2).'</td>
				</tr>';
			echo '</table>';
		}
	?>
</fieldset>
<br>
<?php
	//consulta para obtener el total de horas
	$sqlTotal = mysql_query("SELECT SUM(diurna) AS diurna, SUM(nocturna) AS nocturna, SUM(diurnafest) AS diurnafest, SUM(nocturnafest) AS nocturnafest
FROM turno_funcionario WHERE fecha BETWEEN '$fechaInicial' AND '$fechaLimite' AND idfuncionario='$idFuncionario'", $cn);
	$resTotal = mysql_fetch_array($sqlTotal);
?>
<fieldset>
	<legend><strong>Total</strong></legend>
<table border="1" rules="all" align="center">
  <tr id="table">
    <td colspan="4">Total Laboradas</td>
     <td>&nbsp;</td>
    <td colspan="4">Total Por Novedades</td>
  </tr>
 <tr>
    <td>Diurnas</td>
    <td>Nocturnas</td>
    <td>Diurnas Festivas</td>
    <td>Nocturnas Festivas</td>
    <td>&nbsp;</td>
    <td>Diurnas</td>
    <td>Nocturnas</td>
    <td>Diurnas Festivas</td>
    <td>Nocturnas Festivas</td>
  </tr>
<?php 

	$con = mysql_query("SELECT n.diurnas_adicionales, n.nocturnas_adicionales, n.diurfest_adicionales, n.nocfest_adicionales
FROM novedad_turno n INNER JOIN turno_funcionario t ON t.idturno = n.idturno
WHERE t.idfuncionario = '$idFuncionario' AND t.fecha BETWEEN '$fechaInicial' AND '$fechaLimite'");
	$rows = mysql_num_rows($con);
	
	$diurfest_adicionales = 0;
	$nocfest_adicionales = 0;
	$diurnas_adicionales = 0;
	$nocturnas_adicionales = 0;

  	for($i=0; $i<$rows; $i++)
	{
		$ver = mysql_fetch_array($con);
		$diurfest_adicionales = $diurfest_adicionales + $ver['diurfest_adicionales'];
		$nocfest_adicionales = $nocfest_adicionales + $ver['nocfest_adicionales'];
		$diurnas_adicionales = $diurnas_adicionales + $ver['diurnas_adicionales'];
		$nocturnas_adicionales = $nocturnas_adicionales + $ver['nocturnas_adicionales'];
	}	
  	echo '<tr>
    <td>'.round($resTotal['diurna'], 2).'</td>
    <td>'.round($resTotal['nocturna'], 2).'</td>
    <td>'.round($resTotal['diurnafest'], 2).'</td>
    <td>'.round($resTotal['nocturnafest'], 2).'</td>
    <td>&nbsp;</td>
    <td>'.round($diurnas_adicionales, 2).'</td>
    <td>'.round($nocturnas_adicionales, 2).'</td>
    <td>'.round($diurfest_adicionales, 2).'</td>
    <td>'.round($nocfest_adicionales, 2).'</td>
  </tr>';
?>
</table>
</fieldset>
</body>
</html>