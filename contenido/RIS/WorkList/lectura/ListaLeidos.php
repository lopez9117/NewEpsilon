<?php
//Conexion a la base de datos
include('../../../../dbconexion/conexion.php');
include('Class.Query.php');
set_time_limit(300);
//funcion para abrir conexion
$cn = Conectarse();
$fechaDesde = $_GET['FechaInicio'];
$fechaHasta = $_GET['FechaLimite'];
$usuario = $_GET['usuario'];
$estado = '5';
//consultar la cantidad de estudios que estan agendados para la fecha especificada
$SqlPendientesEspecialista = mysql_query("SELECT DISTINCT(i.id_informe) AS id_informe, i.id_paciente
FROM r_informe_header i
INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
WHERE l.idfuncionario = '$usuario' AND l.id_estadoinforme = '$estado' AND l.fecha BETWEEN '$fechaDesde' AND '$fechaHasta' GROUP BY id_informe", $cn);
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#MiProduccion').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
            "sPaginationType": "full_numbers",
            "aaSorting": [[ 6, "asc" ]],
            "aoColumns": [ null, null, null, null, null, null, null, null, null ]
        } );
    } );
</script>
<table width="100%">
    <tr bgcolor="#E1DFE3">
        <td><strong>Mi producci&oacute;n</strong></td>
    </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="MiProduccion">
<thead>
<tr align="center">
    <th width="5%">Id</th>
    <th width="10%">Paciente</th>
    <th width="15%">Estudio</th>
    <th width="10%">Tecnica</th>
    <th width="10%">Tipo</th>
    <th width="10%">Prioridad</th>
    <th width="10%">Ubicacion</th>
    <th width="10%">Fecha / Hora lectura</th>
    <th width="10%">Tareas</th>
</tr>
</thead>
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
while($RegPersonal =  mysql_fetch_array($SqlPendientesEspecialista))
{
    $idInforme = $RegPersonal['id_informe'];
    $idPaciente = $RegPersonal['id_paciente'];
    $idSede = $RegPersonal['idsede'];
    echo
    '<tr>
        <td>'.$idPaciente.'</td>
        '.Paciente::GetPaciente($cn, $idPaciente).'
        '.Paciente::GetEstudio($cn, $idInforme, $idPaciente).'
        <td align="center">'.Paciente::GetAgendamiento($cn, $idInforme, $estado).'</td>
        <td>';?>
        <table>
            <tr align="center">
                <td>
                    <a href="../../Resultados/VistaPrevia.php?informe=<?php echo base64_encode($idInforme)?>" target="popup" onClick="window.open(this.href, this.target, 'toolbar=no,scrollbars=no,width=800,height=700'); return false;"><img src="../../../../images/fileprint.png" width="14" height="14" alt="Vista de impresión" title="Vista de impresión"></a>
                </td>
            </tr>
        </table>
        <?php echo '
        </td>
    </tr>';
}
?>
<tbody>