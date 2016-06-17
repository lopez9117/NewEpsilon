<?php
//Conexion a la base de datos
include('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//variables con GET
$funcionario = $_GET['funcionario'];
$fecha = $_GET['fecha'];
$tipo = $_GET['tipo'];
//consultar la cantidad de turnos registrados para la fecha en curso
$conTurnos = mysql_query("SELECT t.idturno, t.hr_inicio, t.hr_fin, t.idsede, t.idservicio, t.hralmuerzo, s.descsede, ser.descservicio FROM turno_funcionario t
INNER JOIN sede s ON s.idsede = t.idsede
INNER JOIN servicio ser ON ser.idservicio = t.idservicio
WHERE t.fecha = '$fecha' AND idfuncionario = '$funcionario'", $cn);
$regTurnos = mysql_num_rows($conTurnos);
?>
<table width="100%" border="1" rules="all">
<?php
if($regTurnos=="" || $regTurnos=="0")
{
	echo '<tr>
			<td colspan="5" align="center">No hay turnos Registrados</td>
		</tr>';
}
else
{
	echo 
	'<tr>
		<td width="20%" align="center">Sede</td>
		<td width="20%" align="center">Servicio</td>
		<td width="15%" align="center">Horario</td>
		<td width="25%" align="center">Hr.Almuerzo</td>
		<td width="10%" align="center">Tareas</td>
	</tr>';
	while($row = mysql_fetch_array($conTurnos))
	{
		echo
		'<tr>
		<td align="center">'.$row['descsede'].'</td>
		<td align="center">'.$row['descservicio'].'</td>
		<td align="center">'.$row['hr_inicio'].'&nbsp;-&nbsp;'.$row['hr_fin'].'</td>';
	?>
	<td align="center">
	<table>
	<tr>
	<td>N/A</td>
	<td>30 min</td>
	<td>1 Hr.</td>
	</tr>
	<tr>
	<td><input type="radio" name="horaaLmuerzo" value="1" onclick="ModificarTotal(<?php echo $row['idturno'] ?>, 1)" <?php if($row['hralmuerzo'] == 1){echo 'checked="checked"';}?> /></td>
	<td><input type="radio" name="horaaLmuerzo" value="3" onclick="ModificarTotal(<?php echo $row['idturno'] ?>, 3)" <?php if($row['hralmuerzo'] == 3){echo 'checked="checked"';}?>/></td>
	<td><input type="radio" name="horaaLmuerzo" value="2" onclick="ModificarTotal(<?php echo $row['idturno'] ?>, 2)" <?php if($row['hralmuerzo'] == 2){echo 'checked="checked"';}?>/></td>
	</tr>
	</table>
	</td>
	<?php
	echo '<td align="center"><a href="#" onClick="EliminarTurno('.$row['idturno'].')" alt="Eliminar Turno" title="Eliminar Turno"><img src="../../images/button_cancel.png" width="10" height="10" /></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="NewNovedad.php?idturno='.base64_encode($row['idturno']).'&fecha='.base64_encode($fecha).'&funcionario='.base64_encode($funcionario).'&tipo='.base64_encode($tipo).'" alt="Modificar Turno" title="Modificar Turno"><img src="../../images/kate.png" width="10" height="10" /></a></td>
	</tr>';
	}
}
?>