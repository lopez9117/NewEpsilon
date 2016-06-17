<?php
    include('../../../dbconexion/conexion.php');
    include('../ClassFuncionario.php');
    $cn = Conectarse();
    header("Cache-Control: no-cache");
    header("Pragma: no-cache");
    //declaracion de variables con GET
    $idFuncionario = base64_decode($_GET['document']); $FechaInicio = base64_decode($_GET['fchstart']);
    $FechaFinal = base64_decode($_GET['fchstop']);
    //consultar la cantidad de turnos registrador para el funcionario
    $TurnosFuncionario = mysql_query("SELECT DISTINCT (idturno), time, fecha FROM turno_funcionario WHERE fecha BETWEEN '$FechaInicio' AND '$FechaFinal'
    AND idfuncionario = '$idFuncionario' AND idtipo_turno = '0' ORDER BY fecha ASC", $cn);
	$Funcionario = funcionario::GetNombresApellidos($cn, $idFuncionario);
?>
<style type="text/css">
	body { font-family: Arial, Helvetica, sans-serif; font-size: small; }
	.table-fill { background: white; width: 100%; font-size: small; margin-top: 1%;}
	/*tr { border-top: 1px solid #C1C3D1; border-bottom-: 1px solid #C1C3D1; }
	tr:first-child { border-top:none; }
	tr:last-child {border-bottom:none; }
	tr:nth-child(odd)
	td { background:#EBEBEB; }
	td { background:#FFFFFF; }
	.text-center { text-align: center; background-color: #000066; }*/
</style>
<strong>Reporte de horas para:</strong> <?php echo ucwords(strtolower($Funcionario['nombres'])).'&nbsp;'.ucwords(strtolower($Funcionario['apellidos'])) ?> <strong>Periodo:</strong> <?php echo $FechaInicio .'&nbsp;/&nbsp;'.$FechaFinal; ?>
<table border="1" align="center" rules="all" class="table-fill">
<tr align="center" style="background-color: #000066; color: #ffffff;">
	<td width="5%"><stong>Dia</stong></td>
	<td width="10%"><stong>Fecha</stong></td>
	<td width="20%"><stong>Sede</stong></td>
	<td width="15%"><stong>Servicio</stong></td>
	<td width="10%"><stong>Hora Inicio</stong></td>
	<td width="10%"><stong>Hora Fin</stong></td>
	<td width="6%"><stong>Diurnas</stong></td>
	<td width="6%"><stong>Nocturnas</stong></td>
	<td width="6%"><stong>Diurnas Festivas</stong></td>
	<td width="6%"><stong>Nocturnas Festivas</stong></td>
	<td width="6%"><stong>Total</stong></td>
</tr>
<?php
	while($RowTurnos = mysql_fetch_array($TurnosFuncionario)){
		$fecha = $RowTurnos['fecha'];
		$idTurno = $RowTurnos['idturno'];

		$DiaSemana = funcionario::DiaSemana($fecha);
		$Dia = Dia($fecha);
		$DiaFestivo = funcionario::ValidateFestivo($cn, $fecha);

		if($Dia == 6){
			$Style = 'style="background-color: #000066; color: #ffffff;"';
		}
		else{
			$Style = '';
		}

		if($DiaFestivo){
			$Style = 'style="background-color: #000066; color: #ffffff;"';
		}

		echo '<tr align="center" '.$Style.'>
				<td>'.$DiaSemana.'</td>
				<td>'.$fecha.'</td>
				'.ObtenerTurnos($cn, $idTurno).'
			</tr>';
	}
?>
<tr align="center">
    <td colspan="11"><strong>Vacaciones</strong></td>
</tr>
<tr>
    <td colspan="11" align="center"><?php echo funcionario::GetVacaciones($idFuncionario, $FechaInicio, $FechaFinal, $cn) ?></td>
</tr>
<tr align="center">
    <td colspan="11"><strong>Disponibilidades</strong></td>
</tr>
<tr align="center">
    <td colspan="11"><?php echo funcionario::GetDisponibilidades($idFuncionario, $FechaInicio, $FechaFinal, $cn) ?></td>
</tr>
</table>
<?php
	function ObtenerTurnos($cn, $idTurno){
		$SqlTurno = mysql_query("SELECT t.hr_inicio, t.hr_fin, t.diurna, t.diurnafest, t.nocturna, t.nocturnafest, SUM(t.diurna + t.diurnafest + t.nocturna + t.nocturnafest) AS total , se.descsede, ser.descservicio FROM turno_funcionario t
		INNER JOIN sede se ON se.idsede = t.idsede
		INNER JOIN servicio ser ON ser.idservicio = t.idservicio WHERE t.idturno = '$idTurno'", $cn);
		$RegTurno = mysql_fetch_array($SqlTurno);
		$String = '';
		$String.='<td>'.$RegTurno['descsede'].'</td>
					<td>'.$RegTurno['descservicio'].'</td>
					<td>'.$RegTurno['hr_inicio'].'</td>
					<td>'.$RegTurno['hr_fin'].'</td>
					<td>'.$RegTurno['diurna'].'</td>
					<td>'.$RegTurno['nocturna'].'</td>
					<td>'.$RegTurno['diurnafest'].'</td>
					<td>'.$RegTurno['nocturnafest'].'</td>
					<td>'.$RegTurno['total'].'</td>';
		return $String;
	}

function Dia($fecha){
	list($anio, $mes, $dia) = explode("-",$fecha);
	$wkdy = (((mktime ( 0, 0, 0, $mes, $dia, $anio) - mktime ( 0, 0, 0, 7, 17, 2006))/(60*60*24))+700000) % 7;
	$valorDia = $wkdy;
	return $valorDia;
}
?>