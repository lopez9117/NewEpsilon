<?php
//Conexion a la base de datos
require_once('../../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$fechadesde = $_GET['fechadesde'];
$fechahasta = $_GET['fechahasta'];
$sede = $_GET['sede'];
$servicio = $_GET['servicio'];
$usuario = $_GET['usuario'];
$fechadesde = date("Y-m-d", strtotime($fechadesde));
$fechahasta = date("Y-m-d", strtotime($fechahasta));
//consultar la cantidad de estudios que estan agendados para la fecha especificada
$sqlagenda = mysql_query("SELECT DISTINCT(i.id_informe), i.id_paciente, CONCAT(p.nom1,' ',p.nom2,'<br>',
p.ape1,' ',p.ape2) AS paciente ,e.nom_estudio, l.fecha, l.hora, pr.desc_prioridad,
CONCAT(f.nombres,'<br>',f.apellidos) AS especialista, tp.desctipo_paciente, tec.desc_tecnica
FROM r_informe_header i
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio e ON e.idestudio = i.idestudio
INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
INNER JOIN r_prioridad pr ON pr.id_prioridad = i.id_prioridad
INNER JOIN funcionario f ON f.idfuncionario = i.idfuncionario_esp
INNER JOIN r_tipo_paciente tp ON tp.idtipo_paciente = i.idtipo_paciente
INNER JOIN r_tecnica tec ON tec.id_tecnica = i.id_tecnica
WHERE i.id_estadoinforme = '3' AND i.idsede = '$sede' AND i.idservicio = '$servicio' AND l.fecha BETWEEN '$fechadesde' AND '$fechahasta' AND l.id_estadoinforme = '3' GROUP BY i.id_informe", $cn);
$sqlSede = mysql_query("SELECT descsede FROM sede WHERE idsede='$sede'", $cn);
$regSede = mysql_fetch_array($sqlSede);
$sqlServicio = mysql_query("SELECT descservicio FROM servicio WHERE idservicio = '$servicio'", $cn);
$regServicio = mysql_fetch_array($sqlServicio);
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#tabla_listado_pacientes').dataTable({ //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
            "sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
        });
    })
</script>
<table width="100%">
    <tr bgcolor="#E1DFE3">
        <td><strong>Pendientes para transcripcion <?php echo $regServicio['descservicio'] ?>
                en <?php echo $regSede['descsede'] ?></strong></td>
    </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_listado_pacientes">
    <thead>
    <tr>
        <th align="left" width="8%">Documento</th>
        <!--Estado-->
        <th align="left" width="15%">Nombres y Apellidos</th>
        <th align="left" width="25%">Estudio</th>
        <th align="left" width="10%">Tecnica</th>
        <th align="left" width="15%">Especialista</th>
        <th align="left" width="10%">T. Paciente</th>
        <th align="center" width="5%">Prioridad</th>
        <th align="center" width="5%">Fecha/Hora Lectura</th>
        <th align="center" width="20%">Tareas</th>
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
    while ($reg = mysql_fetch_array($sqlagenda))
    {
    //Codificar variables para pasar por URL
    $idInforme = $reg['id_informe'];
    $fechacita = $reg['fecha'];
    list($año, $mes, $dia) = explode("-", $fechacita);
    $fechaCitaPaciente = $dia . '/' . $mes . '/' . $año;
    echo '<tr>';
    echo '<td align="center">' . $reg['id_paciente'] . '</td>';
    echo '<td align="left">' . $reg['paciente'] . '</td>';
    //echo '<td align="left">'.$regServicio[descservicio].'</td>';
    echo '<td align="left">' . $reg['nom_estudio'] . '</td>';
    echo '<td align="left">' . $reg['desc_tecnica'] . '</td>';
    echo '<td align="left">' . $reg['especialista'] . '</td>';
    echo '<td align="left">' . $reg['desctipo_paciente'] . '</td>';
    echo '<td align="center">' . $reg['desc_prioridad'] . '</td>';
    echo '<td align="center">' . $fechaCitaPaciente . '<br>' . $reg['hora'] . '</td>';
    echo '<td align="center">
	   <table>
	   	<tr>';
    ?>
    <td>
        <a href="TranscribirEstudio.php?informe=<?php echo base64_encode($idInforme)?>&user= <?php echo base64_encode($usuario) ?>"
           target="pop-up"
           onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img
                src="../../../../images/kate.png" width="15" height="15" title="Ver adjunto"
                alt="Devolver Paciente"/></a></td>
    <td>
        <a href="../AddObservacion.php?idInforme=<?php echo base64_encode($idInforme)?>&usuario= <?php echo base64_encode($usuario) ?>"
           target="pop-up"
           onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img
                src="../../../../images/kfind.png" width="15" height="15" title="Ver/Registrar Observaciones"
                alt="Ver/Registrar Observaciones"/></a></td>
    <td>
        <a href="../notes/EventosAdversos.php?idInforme=<?php echo base64_encode($reg['id_informe'])?>&usuario=<?php echo base64_encode($_GET['usuario'])?>"
           target="pop-up"
           onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img
                src="../../../../images/adblock.png" width="15" height="15" title="Registrar Evento Adverso"
                alt="Registrar Evento Adverso"/></a>
    </td>
    </tr>
</table>


<?php
}
?>
<tbody>
</table>