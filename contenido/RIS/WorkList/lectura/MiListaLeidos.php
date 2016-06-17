<?php 
include('../../../../dbconexion/conexion.php');
include('Class.Query.php');
$cn = Conectarse();
$fecha = $_GET['fecha'];
$user = $_GET['usuario'];
$estado = '4';
//consultar la cantidad de estudios que estan agendados para la fecha especificada
$sqlagenda = mysql_query("SELECT i.id_informe, i.id_paciente FROM r_informe_header i
INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
WHERE i.idfuncionario_esp = '$usuario' AND l.id_estadoinforme = '$estado' AND i.id_estadoinforme = '$estado' GROUP BY i.id_informe", $cn);
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#misLecturas').dataTable({ //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
            "sPaginationType": "full_numbers",
            "aaSorting": [[7, "asc"]], "aoColumns": [null, null, null, null, null, null, null, null,null]
        });
    });
</script>
<table width="100%">
    <tr bgcolor="#E1DFE3">
        <td><strong>Pendientes por aprobaci&oacute;n</strong></td>
    </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="misLecturas">
<thead>
    <tr>
        <th width="5%">Id</th>
        <th width="15%">Paciente</th>
        <th width="20%">Estudio</th>
        <th width="10%">Tecnica</th>
        <th width="10%">Tipo</th>
        <th width="10%">Prioridad</th>
        <th width="10%">Ubicacion</th>
        <th width="10%">Fecha / Hora lectura</th>
        <th width="10%">Tareas</th>
    </tr>
</thead>
  <tbody>
<?php
while($reg =  mysql_fetch_array($sqlagenda)) {
    $idInforme = $reg['id_informe'];
    $idPaciente = $reg['id_paciente'];
    echo
        '
    <tr>
        <td>' . $idPaciente . '</td>
        ' . Paciente::GetPaciente($cn, $idPaciente) . '
        ' . Paciente::GetEstudio($cn, $idInforme, $idPaciente) . '
        <td align="center">' . Paciente::GetAgendamiento($cn, $idInforme, $estado) . '</td>
        <td>'; ?>
    <table>
        <tr align="center">
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
            <td>
                <a href="TranscribirAprobar.php?idInforme=<?php echo base64_encode($idInforme) ?>&usuario=<?php echo base64_encode($usuario) ?>" target="transcripcion" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img src="../../../../images/kate.png" width="15" height="15" title="Transcribir/Aprobar Estudios" alt="Transcribir/Aprobar Estudios"/></a>
            </td>
            <td><a href="DevolverEstudio.php?idInforme=<?php echo base64_encode($idInforme) ?>&usuario=<?php echo base64_encode($usuario) ?>"  target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/reload.png" width="15" height="15" title="Regresar Estudio" alt="Regresar Estudio" /></a></td>
            <td>
                <a href="../notes/EventosAdversos.php?idInforme=<?php echo base64_encode($idInforme) ?>&usuario=<?php echo base64_encode($usuario) ?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/adblock.png" width="15" height="15" title="Registrar Evento Adverso" alt="Registrar Evento Adverso"/></a>
            </td>
            <td>
                <a href="../../formularios/AccionesAgenda/VerDetalles.php?idInforme=<?php echo base64_encode($idInforme) ?>&usuario=<?php echo base64_encode($usuario) ?>" target="popup_observaciones" onClick="window.open(this.href, this.target, width=800,height=800); return false;"><img src="../../../../images/viewmag+.png" width="15" height="15" title="Ver todas las observaciones" alt="Ver todas las observaciones" /></a>
            </td>
        </tr>
    </table>
    <?php
    echo '
        </td>
    </tr> ';
}?>
<tbody>