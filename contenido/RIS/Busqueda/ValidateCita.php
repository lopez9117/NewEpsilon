<?php 
//conexion a la BD
include("../../../dbconexion/conexion.php");
$cn = conectarse();	
//variables POST
$Paciente = $_GET['paciente'];
list($regpaciente, $nombres) = explode("-", $Paciente);
//consultar si el funcionario es valido
$conCita = mysql_query("SELECT i.id_paciente, CONCAT(p.nom1,' ', nom2,' ', ape1,' ', ape2) AS paciente, es.nom_estudio,
se.descsede, ser.descservicio, tec.desc_tecnica, l.fecha, l.hora
FROM r_informe_header i
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio es ON es.idestudio = i.idestudio
INNER JOIN sede se ON se.idsede = i.idsede
INNER JOIN servicio ser ON ser.idservicio = i.idservicio
INNER JOIN r_tecnica tec ON tec.id_tecnica = i.id_tecnica
INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
WHERE i.id_paciente = '$regpaciente' AND i.id_estadoinforme = '1' ORDER BY l.fecha, l.hora ASC ", $cn);
?>
<script type="text/javascript">
$(document).ready(function(){
$('#TableListadoPlantillas').dataTable( {
	"sPaginationType": "full_numbers"
} );
})
</script>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="TableListadoPlantillas">
<thead>
	<tr align="center">
		<th width="10%">Id</th>
		<th width="15%">Nombres y Apellidos</th>
		<th width="10%">Sede</th>
		<th width="10%">Servicio</th>
		<th width="20%">Estudio</th>
		<th width="10%">Tecnica</th>
		<th width="10%">Fecha</th>
		<th width="10%">Hora</th>
		<th width="10%">Tareas</th>
	</tr>
</thead>
<tfoot>
<tr>
	<th></th>
	<th></th>
   <th></th>                     
</tr>
</tfoot>
<tbody>
<?php
while($reg =  mysql_fetch_array($conCita))
{	
	echo
	'<tr>
	<td>'.$reg['id_paciente'].'</td>
	<td>'.ucwords(strtolower($reg['paciente'])).'</td>
	<td>'.$reg['descsede'].'</td>
	<td>'.$reg['descservicio'].'</td>
	<td>'.ucwords(strtolower($reg['nom_estudio'])).'</td>
	<td>'.ucwords(strtolower($reg['desc_tecnica'])).'</td>
	<td>'.$reg['fecha'].'</td>
	<td>'.$reg['hora'].'</td>'; ?>
	<td align="center">
    <table>
        <tr>
            <td><a href="../formularios/AccionesAgenda/VerDetalles.php?idInforme=<?php echo base64_encode($reg['id_informe'])?>&usuario=<?php echo base64_encode($usuario)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../images/viewmag+.png" width="15" height="15" title="Ver Detalles" alt="Ver Detalles" /></a></td>
            <td>
            <?php
            //consultar adjuntos
			$sqlAdjunto = mysql_query("SELECT id_adjunto FROM r_adjuntos WHERE id_informe = '$reg[id_informe]'", $cn);
			$count = mysql_num_rows($sqlAdjunto);
			if ($count>=1)
			{
				while($regAdjunto = mysql_fetch_array($sqlAdjunto))
			   {
				?>
				<a href="../WorkList/ViewAttached.php?Attached=<?php echo base64_encode($regAdjunto['id_adjunto'])?> " target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img src="../../../images/pdf grande.png" width="15" height="15" title="Ver adjunto" alt="Ver adjunto" /></a>
				<?php   
			   }
			   '</td>';
			}
			else
			{
				echo '<td align="right"></td>';
			}
			?>
            </td>
        </tr>
    </table>
	</td>
<?php
}
mysql_close($cn);
?>
<tbody>
</table>
<br>