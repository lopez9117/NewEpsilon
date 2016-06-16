<?php
header("Cache-Control: no-cache");
header("Pragma: no-cache");
include('../../../../dbconexion/conexion.php');
include('../class/Class.Query.php');
$cn = Conectarse();
$fecha = $_GET['fecha'];
$sede = $_GET['sede'];
$servicio = $_GET['servicio'];
$usuario = $_GET['usuario'];
$nuevafecha = strtotime('-1 month', strtotime($fecha));
$nuevafecha = date('Y-m-d', $nuevafecha);
$sqlagenda = mysql_query("SELECT i.id_informe, i.id_paciente FROM r_informe_header i
LEFT JOIN r_log_informe l ON l.id_informe = i.id_informe
WHERE i.id_estadoinforme = '5' AND l.id_estadoinforme='5' AND i.idsede = '$sede' AND i.idservicio = '$servicio'
AND l.fecha BETWEEN '$nuevafecha' AND '$fecha' GROUP BY i.id_informe", $cn);
?>
<script type="text/javascript">
 $(document).ready(function(){
   $('#Resultados').dataTable( { "sPaginationType": "full_numbers", "aaSorting": [[ 8, "asc" ]],
    "aoColumns": [ null, null, null, null, null, null, null, null, null, null, null ]} ); } );
 </script>
<table width="100%">
    <tr bgcolor="#E1DFE3">
        <td><strong>Resultados Preliminares / Pendientes por publicar</strong></td>
    </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="Resultados">
<thead>
<tr align="center">
    <th width="5%">Id</th>
    <th width="15%">Paciente</th>
    <th width="20%">Estudio</th>
    <th width="10%">Tecnica</th>
    <th width="10%">Tipo</th>
    <th width="10%">Prioridad</th>
    <th width="10%">Ubicacion</th>
    <th width="10%">Aprobaci&oacute;n</th>
    <th width="10%">Tipo resultado</th>
    <th width="10%">Especialista</th>
    <th width="10%">Tareas</th>
</tr>
<tfoot>
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
</tfoot>
<tbody>
<?php
while($RowPendientes = mysql_fetch_array($sqlagenda))
{
    $idInforme = $RowPendientes['id_informe'];
    $idPaciente = $RowPendientes['id_paciente'];
    $estado = '5';
    $Realizacion = Paciente::GetAgendamiento($cn, $idInforme, $estado);
    $Style = GetTipoResultado($cn, $idInforme);
    echo
    '<tr '.$Style.'>
    <td>'.$idPaciente.'</td>
    '.Paciente::GetPaciente($cn, $idPaciente).'
    '.Paciente::GetEstudio($cn, $idInforme, $idPaciente).'
    <td align="center">'.$Realizacion.'</td>
    <td align="center">' . ShowTipoResultado($cn, $idInforme) . '</td>
    <td align="center">'. GetEspecialista($cn, $idInforme) .'</td>'; ?>
    <td align="center">
        <table>
            <tr>
                <td><a href="../transcripcion/SubirResultado.php?informe=<?php echo base64_encode($idInforme)?>&usuario= <?php echo base64_encode($usuario) ?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img src="../../../../images/apply.png" width="15" height="15" title="Ver adjunto" alt="Ver adjunto" /></a></td>
                <td><a href="../../formularios/VistaPrevia1.php?informe=<?php echo base64_encode($idInforme)?>" target="popup" onClick="window.open(this.href, this.target, 'toolbar=no,scrollbars=no,width=800,height=700'); return false;"><img src="../../../../images/fileprint.png" width="14" height="14" alt="Vista de impresión" title="Vista de impresión"></a></td>
                <td><a href="../../formularios/AccionesAgenda/VerDetalles.php?idInforme=<?php echo base64_encode($idInforme)?>&usuario=<?php echo base64_encode($usuario)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/kfind.png" width="15" height="15" title="Observaciones" alt="Observaciones" /></a></td>
                <td><a href="../notes/EventosAdversos.php?idInforme=<?php echo base64_encode($idInforme)?>&usuario=<?php echo base64_encode($usuario)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/adblock.png" width="15" height="15" title="Registrar Evento Adverso" alt="Registrar Evento Adverso" /></a></td>
            </tr>
        </table>
    </td>
<?php
}
?>
<tbody>
</table>