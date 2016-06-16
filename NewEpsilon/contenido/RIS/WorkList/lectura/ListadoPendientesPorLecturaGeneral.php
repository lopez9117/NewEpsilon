<?php
//Conexion a la base de datos
include('../../../../dbconexion/conexion.php');
include('Class.Query.php');
//funcion para abrir conexion
$cn = Conectarse();
$fechaDesde = $_GET['fechaDesde'];
$fechaHasta = $_GET['fechaHasta'];
$usuario = $_GET['usuario'];
$estado = '2';
//consultar la cantidad de estudios que estan agendados para la fecha especificada
$SqlPendientesEspecialista = mysql_query("SELECT DISTINCT(i.id_informe) AS id_informe, i.id_paciente, i.idsede
FROM r_informe_header i
INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
WHERE i.idfuncionario_esp = '$usuario' AND i.id_estadoinforme = '$estado' AND l.fecha BETWEEN '$fechaDesde' AND '$fechaHasta' GROUP BY id_informe", $cn);
?>
<script type="text/javascript">
 $(document).ready(function(){
   $('#ListadoPendientesPorLecturaGeneral').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "sPaginationType": "full_numbers",
		"aaSorting": [[ 6, "asc" ]],
"aoColumns": [ null, null, null, null, null, null, null, null, null, null ]
} );
} );
 </script>
 <table width="100%">
  <tr bgcolor="#E1DFE3">
    	<td><strong>Pendientes por lectura</strong></td>
    </tr>
 </table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListadoPendientesPorLecturaGeneral">
<thead>
    <tr align="center">
    <th width="5%">Id</th>
    <th width="10%">Paciente</th>
	<th width="15%">Sede</th>
    <th width="15%">Estudio</th>
    <th width="10%">Tecnica</th>
    <th width="10%">Tipo</th>
    <th width="10%">Prioridad</th>
    <th width="10%">Ubicacion</th>
    <th width="10%">Fecha / Hora realizado</th>
    <th width="10%">Tareas</th>
</tr>
</thead>
<tfoot>
<tr>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>                     
</tr>
</tfoot>
<tbody>
<?php
while($RegPersonal =  mysql_fetch_array($SqlPendientesEspecialista))
{
	$idInforme = $RegPersonal['id_informe'];
	$idPaciente = $RegPersonal['id_paciente'];
	$idSede = $RegPersonal['idsede'];
	echo
		'
    <tr>
        <td>'.$idPaciente.'</td>
        '.Paciente::GetPaciente($cn, $idPaciente).'
        <td>'.Sede::GetSede($cn, $idSede).'</td>
        '.Paciente::GetEstudio($cn, $idInforme, $idPaciente).'
        <td align="center">'.Paciente::GetAgendamiento($cn, $idInforme, $estado).'</td>
        <td>';?>
	<table>
		<tr>
			<td>
				<?php
				$sqlAdjunto = mysql_query("SELECT ad.id_informe,ad.adjunto,ad.id_adjunto,i.id_informe FROM r_adjuntos ad
                            INNER JOIN r_informe_header i ON i.id_informe = ad.id_informe where i.id_informe='$idInforme'", $cn);
				$count = mysql_num_rows($sqlAdjunto);
				if ($count >= 1) {
					while ($regAdjunto = mysql_fetch_array($sqlAdjunto)) {
						?>
						<a href="../ViewAttached.php?Attached=<?php echo base64_encode($regAdjunto['id_adjunto']) ?>" target="orden" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img src="../../../../images/pdf grande.png" width="15" height="15" title="Ver adjunto" alt="Ver adjunto"/></a>
						<?php
					}
				}
				?>
			</td>
			<td><a href="TranscribirAprobar.php?idInforme=<?php echo base64_encode($idInforme) ?>&usuario=<?php echo base64_encode($usuario) ?>" target="transcripcion" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img src="../../../../images/kate.png" width="15" height="15" title="Transcribir/Aprobar Estudios" alt="Transcribir/Aprobar Estudios" /></a></td>
			<td><a href="DevolverEstudio.php?idInforme=<?php echo base64_encode($idInforme) ?>&usuario=<?php echo base64_encode($usuario) ?>"  target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/reload.png" width="15" height="15" title="Regresar Estudio" alt="Regresar Estudio" /></a></td>
			<td><a href="../notes/NotaMedica.php?idInforme=<?php echo base64_encode($idInforme) ?>&usuario=<?php echo base64_encode($usuario) ?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/dokter.png" width="15" height="15" title="Nota Medica" alt="Nota Medica" /></a></td>
			<td><a href="../notes/EventosAdversos.php?idInforme=<?php echo base64_encode($idInforme) ?>&amp;usuario=<?php echo base64_encode($usuario) ?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/adblock.png" width="15" height="15" title="Registrar Evento Adverso" alt="Registrar Evento Adverso" /></a></td>
		</tr>
	</table>
	<?php echo '
        </td>
    </tr>
    ';
}
?>
<tbody>