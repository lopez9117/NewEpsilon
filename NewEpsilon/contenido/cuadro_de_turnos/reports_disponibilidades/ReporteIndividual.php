<?php
	include('../../../dbconexion/conexion.php');
	$cn = Conectarse();
	//declaracion de variables con GET
	$idFuncionario = base64_decode($_GET['document']);
	$fechaInicial = base64_decode($_GET['fchstart']);
	$fechaLimite = base64_decode($_GET['fchstop']);
	$nombres = base64_decode($_GET['nomb'        ]);
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
	<legend><strong>Detalle de disponibilidades para:</strong> <?php echo $nombres ?> <strong>Periodo:</strong> <?php echo $fechaInicial .'&nbsp;/&nbsp;'.$fechaLimite ?></legend>

<fieldset>
	<legend>Disponibilidades</legend>
    <?php
    	//consultar disponibilidades del funcionario
		$consDisponibilidades = mysql_query("SELECT * FROM ct_disponibilidad_funcionario WHERE idfuncionario = '$idFuncionario' AND fecha BETWEEN '$fechaInicial' AND '$fechaLimite'", $cn);
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
					<td align="center">'.round(($contDisponibilidades/7),1).'</td>
				</tr>';
			echo '</table>';
		}
	?>
</fieldset>
</body>
</html>