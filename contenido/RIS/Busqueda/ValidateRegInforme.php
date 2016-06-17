<?php
//conexion a la BD
include("../../../dbconexion/conexion.php");
$cn = conectarse();
//variables POST
$Paciente = $_GET['paciente'];
list($regpaciente, $nombres) = explode("-", $Paciente);
//consultar si el funcionario es valido
$sql = mysql_query("SELECT * FROM r_paciente WHERE id_paciente = '$regpaciente'", $cn);
$res = mysql_num_rows($sql);
$consulta = mysql_query("SELECT MAX(l.id_estadoinforme) AS estado,MAX(l.fecha) AS fecha, i.id_informe,i.id_estadoinforme,ei.desc_estado,
(SELECT descsede FROM sede WHERE idsede=i.erp) AS erp,
i.id_paciente,p.nom1,p.nom2,p.ape1,p.ape2,s.descservicio,e.nom_estudio,t.desc_tecnica,ei.desc_estado,se.descsede,i.fecha_solicitud,i.ubicacion FROM r_informe_header i
INNER JOIN r_paciente p ON i.id_paciente=p.id_paciente
INNER JOIN servicio s ON i.idservicio=s.idservicio
INNER JOIN r_estudio e ON i.idestudio=e.idestudio
INNER JOIN r_tecnica t ON i.id_tecnica=t.id_tecnica
INNER JOIN r_log_informe l ON i.id_informe=l.id_informe
INNER JOIN r_estadoinforme ei ON i.id_estadoinforme=ei.id_estadoinforme
INNER JOIN sede se ON i.idsede=se.idsede
WHERE i.id_paciente='$regpaciente' GROUP BY l.id_informe, i.id_informe;", $cn);
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#TableListadoPlantillas').dataTable({ //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
            "sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
        });
    })
</script>
<table width="100%">
    <tr bgcolor="#E1DFE3">
        <td align="left"><strong>Iinformes para el paciente <?php echo $nombres ?></strong></td>
    </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="TableListadoPlantillas">
    <thead>
    <tr align="center">
        <th>Id</th>
        <th>Paciente</th>
        <th>Servicio</th>
        <th>Estudio</th>
        <th>Tecnica</th>
        <th>Estado</th>
        <th>Sede</th>
        <th>ERP</th>
        <th>Ubicación</th>
        <th>Fecha Estado</th>
        <th>Fecha Solicitud</th>
        <th>Fecha Toma</th>
        <th>Fecha Cita</th>
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
    while ($reg = mysql_fetch_array($consulta)) {
        $idinforme = $reg['id_informe'];
        $fechatoma = mysql_query("SELECT fecha FROM r_log_informe WHERE id_informe = '$idinforme' AND id_estadoinforme='2'", $cn);
        $fechatomaestudio = mysql_fetch_array($fechatoma);
        if ($reg['id_estadoinforme'] == 1) {
            $estadoinforme = 'Agendado/Pendiente por Tomar';
        } else if ($reg['id_estadoinforme'] == 2) {
            $estadoinforme = 'Pendiente Por Lectura';
        } else if ($reg['id_estadoinforme'] == 3) {
            $estadoinforme = 'Pendiente Por Transcripción';
        } else if ($reg['id_estadoinforme'] == 4) {
            $estadoinforme = 'Pendiente Por Aprobación';
        } else if ($reg['id_estadoinforme'] == 5) {
            $estadoinforme = 'Pendiente Por Publicar';
        } else if ($reg['id_estadoinforme'] == 6) {
            $estadoinforme = 'Cancelado Definitivo';
        } else if ($reg['id_estadoinforme'] == 7) {
            $estadoinforme = 'Pendiente Por Reasignar';
        } else if ($reg['id_estadoinforme'] == 8) {
            $estadoinforme = 'Publicado';
        } else if ($reg['id_estadoinforme'] == 9) {
            $estadoinforme = 'Devuelto por el Especialista';
        } else if ($reg['id_estadoinforme'] == 10) {
            $estadoinforme = 'Sin Lectura';
        }

        $FechaSolicitud = $reg['fecha_solicitud'];
        list($año, $mes, $dia) = explode("-", $FechaSolicitud);
        $FechaSolicitud = $dia . '/' . $mes . '/' . $año;
        $FechaInforme = $reg['fecha'];
        list($año1, $mes1, $dia1) = explode("-", $FechaInforme);
        $FechaInforme = $dia1 . '/' . $mes1 . '/' . $año1;
        $TomaEstudio = $fechatomaestudio['fecha'];
        list($año2, $mes2, $dia2) = explode("-", $TomaEstudio);
        $TomaEstudio = $dia2 . '/' . $mes2 . '/' . $año2;
        echo '<tr>';
        echo '<td>' . $reg['id_paciente'] . '</td>';
        echo '<td>' . ucwords(strtolower($reg['nom1'])) . ' ' . ucwords(strtolower($reg['nom2'])) . ' ' . ucwords(strtolower($reg['ape1'])) . ' ' . ucwords(strtolower($reg['ape2'])) . '</td>';
        echo '<td>' . $reg['descservicio'] . '</td>';
        echo '<td>' . ucwords(strtolower($reg['nom_estudio'])) . '</td>';
        echo '<td>' . ucwords(strtolower($reg['desc_tecnica'])) . '</td>';
        echo '<td>' . $estadoinforme . '</td>';
        echo '<td>' . $reg['descsede'] . '</td>';
        echo '<td>' . $reg['erp'] . '</td>';
        echo '<td>' . $reg['ubicacion'] . '</td>';
        echo '<td>' . $FechaInforme . '</td>';
        echo '<td>' . $FechaSolicitud . '</td>';
        echo '<td>' . $TomaEstudio . '</td>';
        $fechacita = mysql_query("SELECT fecha FROM r_log_informe WHERE id_informe = '$idinforme' AND id_estadoinforme='1'", $cn);
        $rowfechacita = mysql_fetch_array($fechacita);
        list($año3, $mes3, $dia3) = explode("-", $rowfechacita['fecha']);
        $Cita = $dia3 . '/' . $mes3 . '/' . $año3;
        echo '<td>' . $Cita . '</td>';
        echo '</tr>';
    }
    mysql_close($cn);
    ?>
    <tbody>
</table>
<br>