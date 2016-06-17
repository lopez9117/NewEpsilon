<?php 
//Conexion a la base de datos
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//variables metodo GET
$usuario= $_GET['usuario'];
$fecha = $_GET['fecha'];
$hasta = $_GET['hasta'];
$sede = $_GET['sede'];
$servicio = $_GET['servicio'];
$estado = $_GET['estado'];
$fechacons = date("Y-m-d",strtotime($fecha));
$fechacons2 = date("Y-m-d",strtotime($hasta));
//obtener la cantidad de estudios
$sqlagenda = mysql_query("SELECT STRAIGHT_JOIN DISTINCT(l.id_informe),l.fecha,l.hora, i.id_paciente, CONCAT(p.nom1,' ',p.nom2,' ',p.ape1,' ',p.ape2) AS nombre, est.nom_estudio, pri.desc_prioridad, tec.desc_tecnica,
tp.desctipo_paciente FROM r_informe_header i
INNER JOIN r_log_informe l ON l.id_informe=i.id_informe
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio est ON est.idestudio = i.idestudio
INNER JOIN r_prioridad pri ON pri.id_prioridad = i.id_prioridad
INNER JOIN r_tecnica tec ON tec.id_tecnica = i.id_tecnica
INNER JOIN r_tipo_paciente tp ON tp.idtipo_paciente = i.idtipo_paciente
WHERE l.id_estadoinforme = '$estado' AND l.fecha BETWEEN '$fechacons' AND '$fechacons2' AND i.idservicio = '$servicio' AND i.idsede = '$sede' AND i.id_estadoinforme='$estado' GROUP BY l.id_informe ORDER BY fecha, hora ASC", $cn);

$sqlSede = mysql_query("SELECT descsede FROM sede WHERE idsede='$sede'", $cn);
$regSede = mysql_fetch_array($sqlSede);

$sqlServicio = mysql_query("SELECT descservicio FROM servicio WHERE idservicio = '$servicio'", $cn);
$regServicio = mysql_fetch_array($sqlServicio);

//crear array asociativo para traer estados de los estudios
$EstadoArray = array( 1 => 'Agendado/Pendiente por realizar', 2 => 'Pendiente por Lectura', 3 => 'Pendiente por transcribir', 4 => 'Pendiente por Aprobar', 5 => 'Pendiente por publicar', 6 => 'Cancelado definitivamente', 7 => 'Pendiente por Reasignar', 8 => 'Publicado', 9 => 'Devuelto por el especialista', 10 => 'Realizado Sin Lectura');
?> <script type="text/javascript">
$(document).ready(function(){
$('#consulta').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
	"sPaginationType": "full_numbers",
	"aaSorting": [[ 7, "asc" ]],
"aoColumns": [ null, null, null, null, null, null, null, null ]
} );
} );
</script>
<table width="100%">
<tr bgcolor="#E1DFE3">
	<td><strong><?php echo $estadoinforme?> de <?php echo $regServicio['descservicio'] ?> en <?php echo $regSede['descsede'] ?> desde <?php echo $fecha ?> hasta <?php echo $hasta ?> </strong> </td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="consulta">
<thead>
<tr>
    <th align="left" width="5%">Id</th>
    <th align="left" width="15%">Nombres y Apellidos</th>
    <th align="left" width="20%">Estudio</th>
    <th align="left" width="10%">Tecnica</th>
    <th align="left" width="10%">Tipo Paciente</th>
    <th align="left" width="10%">Prioridad</th>
    <th align="left" width="20%">Funcionario</th>
    <th align="center" width="15%">Fecha / Hora</th>
</tr>
<tbody>
<?php
while($reg =  mysql_fetch_array($sqlagenda))
{
	$idInforme=$reg['id_informe'];
	echo '<tr>';
	echo '<td align="left">'.$reg['id_paciente'].'</td>';
	echo '<td align="left">'.ucwords(strtolower($reg['nombre'])).'</td>';
	echo '<td align="left">'.ucwords(strtolower($reg['nom_estudio'])).'</td>';
	echo '<td align="left">'.ucwords(strtolower($reg['desc_tecnica'])).'</td>';
	echo '<td align="left">'.ucwords(strtolower($reg['desctipo_paciente'])).'</td>';
	echo '<td align="left">'.ucwords(strtolower($reg['desc_prioridad'])).'</td>';
	if($estado==4 || $estado==2)
	{
		//obtener datos del especialista que tiene estudios pendientes por aprobacion
		$consEspecialista = mysql_query("SELECT CONCAT(f.nombres,' ',f.apellidos) AS nombres FROM r_informe_header i
INNER JOIN funcionario f ON f.idfuncionario = i.idfuncionario_esp
WHERE i.id_informe = '$idInforme'", $cn);
		$regEspecialista = mysql_fetch_array($consEspecialista);
		if($regEspecialista!="")
		{
			echo '<td align="left">'.ucwords(strtolower($regEspecialista['nombres'])).'</td>';
		}
		else
		{
			echo '<td align="left">Sin asignar</td>';
		}
	}
	else
	{
		echo '<td align="center">&nbsp;</td>';
	}
	echo '<td align="center">'.$reg['fecha'].' / '.$reg['hora'].'</td>';
	echo '</tr>';
}
mysql_close($cn);
?>
<tbody>
</table>