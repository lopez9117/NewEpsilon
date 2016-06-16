<?php
ini_set('max_execution_time', 0);
//Conexion a la base de datos
include('../../../dbconexion/conexion.php');
header("Cache-Control: no-cache");
header("Pragma: no-cache");
//funcion para abrir conexion
$cn = Conectarse();
//declaracion de variables por GET
$fecha = $_GET['fecha'];
$sede = $_GET['sede'];
$servicio = $_GET['servicio'];
$usuario = $_GET['usuario'];
$estado = $_GET['estado'];
//convertir la variable para hacer la consulta en la base de datos
$fecha = date("Y-m-d", strtotime($fecha));
//consulta
$listado = mysql_query("SELECT i.id_informe, l.hora, l.fecha, i.id_paciente, i.ubicacion, i.id_estadoinforme,
CONCAT(p.nom1,' ',p.nom2,' ',p.ape1,' ',p.ape2) AS nombre, es.nom_estudio, pr.desc_prioridad, t.desc_tecnica,rif.guia FROM r_log_informe l
INNER JOIN r_informe_header i ON i.id_informe = l.id_informe
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio es ON es.idestudio = i.idestudio
INNER JOIN r_prioridad pr ON pr.id_prioridad = i.id_prioridad
INNER JOIN r_tecnica t ON t.id_tecnica = i.id_tecnica
INNER JOIN r_informe_facturacion rif ON rif.id_informe=i.id_informe
WHERE l.fecha = '$fecha' AND i.idsede = '$sede' AND i.idservicio = '$servicio' AND l.id_estadoinforme = '$estado' GROUP BY i.id_informe", $cn);
?>
<script type="text/javascript">
    $(document).ready(function () { $('#Lista_Pacientes').dataTable({ "sPaginationType": "full_numbers" }); })
</script>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="Lista_Pacientes">
<thead>
    <tr align="center">
        <th width="5%">Hora</th>
        <th width="10%">Id</th>
        <th width="15%">Paciente</th>
        <th width="10%">Ubicacion</th>
        <th width="20%">Estudio</th>
        <?php if ($servicio == 7) { echo ' <th align="left" width="10%">Gu&iacute;a</th>'; }?>
        <th width="10%">Tecnica</th>
        <th width="10%">Prioridad</th>
        <th width="10%" colspan="1">Tareas</th>
    </tr>
</thead>
    <tbody>
    <?php
    while ($reg = mysql_fetch_array($listado)) {
        echo '<tr>';
        echo '<td align="left">' . $reg['hora'] . '</td>';
        echo '<td align="left">' . $reg['id_paciente'] . '</td>';
        echo '<td align="left">' . ucwords(strtolower($reg['nombre'])) . '</td>';
        echo '<td align="left">' . ucwords(strtolower($reg['ubicacion'])) . '</td>';
        echo '<td align="left">' . ucwords(strtolower($reg['nom_estudio'])) . '</td>';
        if ($servicio == 7) {
            if ($reg['guia'] == 1048) { echo '<td align="left"">Ecogr&aacute;fica</td>'; }
            elseif ($reg['guia'] == 166) { echo '<td align="left"">Tomogr&aacute;fica</td>'; }
            else { echo '<td align="left"">Sin Guia</td>'; }
        }
        echo '<td align="left">' . ucwords(strtolower($reg['desc_tecnica'])) . '</td>';
        echo '<td align="left">' . $reg['desc_prioridad'] . '</td>';
        echo '<td align="center">
        <table>
            <tr>';
            //mostrar las tareas de acuerdo al estado de la cita
            if ($estado == 1 || $estado == 6) {
                if ($reg['id_estadoinforme'] > 1 || $reg['id_estadoinforme'] == 6) {
                    ?>
                    <td align="left"><a
                            href="CancelarCita.php?idInforme=<?php echo base64_encode($reg['id_informe']) ?>&usuario=<?php echo base64_encode($_GET['usuario']) ?>"
                            target="pop-up"
                            onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1500, height=550, top=100, left=100'); return false;"><img
                                src="../../../images/reload.png" width="15" height="15" title="Modificar Cita"
                                alt="Modificar Cita"/></a></td>
                    <?php
                } else {
                    ?>
                    <td align="left"><a
                            href="CancelarCita.php?idInforme=<?php echo base64_encode($reg['id_informe']) ?>&usuario=<?php echo base64_encode($_GET['usuario']) ?>"
                            target="pop-up"
                            onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1500, height=550, top=100, left=100'); return false;"><img
                                src="../../../images/button_cancel.png" width="15" height="15" title="Cancelar Cita"
                                alt="Cancelar Cita"/></a></td>
                    <?php
                }
            }
            ?>
            <td align="center">
                <a href="AccionesAgenda/VerDetalles.php?idInforme=<?php echo base64_encode($reg['id_informe']) ?>&usuario=<?php echo base64_encode($usuario) ?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../images/viewmag+.png" width="15" height="15" title="Ver Detalles" alt="Ver Detalles"/></a>
            </td>
            <?php
            $sqlAdjunto = mysql_query("SELECT id_adjunto FROM r_adjuntos WHERE id_informe = '$reg[id_informe]'", $cn);
            $count = mysql_num_rows($sqlAdjunto);
            if ($count >= 1) {
                echo '<td align="right">';
                while ($regAdjunto = mysql_fetch_array($sqlAdjunto)) { ?>
                    <a href="../WorkList/ViewAttached.php?Attached=<?php echo base64_encode($regAdjunto['id_adjunto']) ?> " target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img src="../../../images/pdf grande.png" width="15" height="15" title="Ver adjunto" alt="Ver adjunto"/></a>
                    <?php
                }
                '</td>';
            }
            else { echo '<td align="right">&nbsp;</td>'; } ?>
            <td>
                <a href="../Worklist/notes/EventosAdversos.php?idInforme=<?php echo base64_encode($reg['id_informe']) ?>&usuario=<?php echo base64_encode($_GET['usuario']) ?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../images/adblock.png" width="15" height="15" title="Registrar Evento Adverso" alt="Registrar Evento Adverso"/></a>
            </td>
            <!--<td>
                <a href="../BarCodeGenerator/CodeGenerator.php?Id=<?php echo base64_encode($reg['id_informe']); ?>&Patient=<?php echo base64_encode($reg['nombre']); ?>&Document=<?php echo base64_encode($reg['id_paciente']); ?>&Estudio=<?php echo base64_encode($reg['nom_estudio']); ?>"
                   target="pop-up"
                   onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=400, height=200, top=85, left=140'); return false;"><img
                        src="../../../images/fileprint.png" width="15" height="15" title="Generar Código"
                        alt="Generar Código"/></a>
            </td>-->
        <?php '</tr>';
        echo '</table>';
    }
    ?>
    <tbody>
</table>
<script>
$(function () { $(".boton").button().click(function (event) { event.preventDefault(); }); });
</script>
<br>



<a href="GestionCitas.php?fecha=<?php echo base64_encode($fecha) ?>&sede=<?php echo base64_encode($sede) ?>&servicio=<?php echo base64_encode($servicio) ?>&usuario=<?php echo base64_encode($usuario)?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;" class="boton">Agendar Paciente</a>
