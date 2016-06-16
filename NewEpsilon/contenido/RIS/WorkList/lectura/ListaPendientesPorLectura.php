<?php
include('../../../../dbconexion/conexion.php');
include('Class.Query.php');
$cn = Conectarse();
$fechaDesde = $_GET['fechaDesde'];
$fechaHasta = $_GET['fechaHasta'];
$sede = $_GET['sede'];
$servicio = $_GET['servicio'];
$usuario = $_GET['usuario'];
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#tabla_listado_pacientes').dataTable({ //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
            "sPaginationType": "full_numbers",
            "aaSorting": [[7, "asc"]], "aoColumns": [null, null, null, null, null, null, null, null,null]
        });
    });
</script>
<table width="100%">
    <tr bgcolor="#E1DFE3">
        <td><strong>Estudios pendientes por lectura</strong></td>
    </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_listado_pacientes">
<thead>
<tr align="center">
    <th width="5%">Id</th>
    <th width="15%">Paciente</th>
    <th width="20%">Estudio</th>
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
//Validar el estado de la lista de lectura
$Estado = GetEstadoLista($cn, $sede, $servicio);
if($Estado==0){
    //Consultar lista de trabajo abierta
    $sqlagenda = mysql_query("SELECT i.id_informe, i.id_paciente FROM r_informe_header i
    LEFT JOIN r_log_informe l ON l.id_informe = i.id_informe
    WHERE i.id_estadoinforme = '2' AND i.idfuncionario_esp IN('$usuario', 0, '') AND i.idsede = '$sede' AND i.idservicio = '$servicio'
    AND l.fecha BETWEEN '$fechaDesde' AND '$fechaHasta' GROUP BY i.id_informe", $cn);
}
else{
    //Consultar lista de trabajo cerrada
    $sqlagenda = mysql_query("SELECT i.id_informe, i.id_paciente FROM r_informe_header i
    LEFT JOIN r_log_informe l ON l.id_informe = i.id_informe
    WHERE i.id_estadoinforme = '2' AND i.idfuncionario_esp = '$usuario' AND i.idsede = '$sede' AND i.idservicio = '$servicio'
    AND l.fecha BETWEEN '$fechaDesde' AND '$fechaHasta' GROUP BY i.id_informe", $cn);
}
while($RowPendientes = mysql_fetch_array($sqlagenda)){
    $idInforme = $RowPendientes['id_informe'];
    $idPaciente = $RowPendientes['id_paciente'];
    $estado = '2';
    $Realizacion = Paciente::GetAgendamiento($cn, $idInforme, $estado);
    $Style = GetOportunidad($cn, $idInforme, $Realizacion);
    echo
    '<tr '.$Style.'>
        <td>'.$idPaciente.'</td>
        '.Paciente::GetPaciente($cn, $idPaciente).'
        '.Paciente::GetEstudio($cn, $idInforme, $idPaciente).'
        <td align="center">'.$Realizacion.'</td>
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
                    <td><a href="TranscribirAprobar.php?idInforme=<?php echo base64_encode($idInforme) ?>&usuario=<?php echo base64_encode($usuario) ?>" target="transcripcion" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img src="../../../../images/kate.png" width="15" height="15" title="Transcribir / Aprobar Estudios" alt="Transcribir / Aprobar Estudios" /></a></td>
                    <td><a href="DevolverEstudio.php?idInforme=<?php echo base64_encode($idInforme) ?>&usuario=<?php echo base64_encode($usuario) ?>"  target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/reload.png" width="15" height="15" title="Regresar Estudio" alt="Regresar Estudio" /></a></td>
                    <td><a href="../notes/NotaMedica.php?idInforme=<?php echo base64_encode($idInforme) ?>&usuario=<?php echo base64_encode($usuario) ?>" target="pop-up_notamedica" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/dokter.png" width="15" height="15" title="Nota Medica" alt="Nota Medica" /></a></td>
                    <td><a href="../notes/EventosAdversos.php?idInforme=<?php echo base64_encode($idInforme) ?>&usuario=<?php echo base64_encode($usuario) ?>" target="pop-up_eventos" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/adblock.png" width="15" height="15" title="Registrar Evento Adverso" alt="Registrar Evento Adverso" /></a></td>
                    <td><a href="../../formularios/AccionesAgenda/VerDetalles.php?idInforme=<?php echo base64_encode($idInforme) ?>&usuario=<?php echo base64_encode($usuario) ?>" target="popup_observaciones" onClick="window.open(this.href, this.target, width=800,height=800); return false;"><img src="../../../../images/viewmag+.png" width="15" height="15" title="Ver todas las observaciones" alt="Ver todas las observaciones" /></a></td>
                </tr>
            </table>
    <?php echo '
        </td>
    </tr>';
}
?>
</tbody>