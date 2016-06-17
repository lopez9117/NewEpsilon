<?php
include("../../../../dbconexion/conexion.php");
$cn = Conectarse();
$opcion = $_POST['opcion'];

if ($opcion == 'eliminar') {
    $doc = $_POST['doc'];
    $idest = $_POST['idest'];
    $id_paciente = $doc;
    mysql_query("DELETE FROM r_informe_header_temp WHERE id_paciente='$doc' AND idestudio = '$idest'", $cn) or showerror(mysql_error());
} else {
    $id_paciente = $_POST["idpaciente"];
    $orden = $_POST["orden"];
    $idservicio = $_POST["servicio"];
    $idestudio = $_POST["estudio"];
    $id_tecnica = $_POST["tecnica"];
    $copago = $_POST["copago"];
    $id_extremidad = $_POST["lado"];
    $extremidad = $_POST["extremidad"];
    $adicional = $_POST["adicional"];
    $portatil = $_POST["portatil"];
    $anestesia = $_POST["anestesia"];
    $sedacion = $_POST["sedacion"];
    $fechasolicitud = $_POST["fechasolicitud"];
    $horasolicitud = $_POST["horacolicitud"];
    $fechacita = $_POST["fechacita"];
    $horacita = $_POST["horacita"];
    $fechapreparacion = $_POST["fechapreparacion"];
    $horapreparacion = $_POST["horapreparacion"];
    $proyecciones = $_POST['proyecciones'];
    $comparativa = $_POST['comparativa'];
    $reconstruccion = $_POST['reconstruccion'];
    $observaciones = $_POST['observaciones'];
    $sede = $_POST['sede'];
    $erp = $_POST['erp'];
    $realizacion = $_POST['realizacion'];
    $guia = $_POST['guia'];

    try {
        mysql_query("INSERT INTO r_informe_header_temp(id_paciente, idestudio, id_extremidad, idservicio, portatil, id_tecnica, hora_solicitud, fecha_solicitud, hora_cita, fecha_cita, fecha_preparacion, orden, desc_extremidad, anestesia, sedacion, adicional,copago,comparativa,proyeccion,reconstruccion,observaciones,idsede,erp,lugar_realizacion,guia)
                                VALUES ('$id_paciente','$idestudio','$id_extremidad','$idservicio','$portatil','$id_tecnica','$horasolicitud','$fechasolicitud','$horacita','$fechacita','$fechapreparacion','$orden','$extremidad','$anestesia','$sedacion','$adicional','$copago','$comparativa','$proyecciones','$reconstruccion','$observaciones','$sede','$erp','$realizacion','$guia')", $cn)
        or showerror(mysql_error());
    } catch (Exception $e) {
        echo 'Ha Ocurrido un error ';
    }
}
try {
    $sql = mysql_query("SELECT riht.orden,riht.id_paciente,se.descservicio,nom_estudio,riht.fecha_solicitud,riht.hora_solicitud,riht.fecha_cita,riht.hora_cita,riht.idestudio FROM r_informe_header_temp riht
                      INNER JOIN r_estudio es ON es.idestudio = riht.idestudio
                      INNER JOIN servicio se ON riht.idservicio = se.idservicio WHERE id_paciente='$id_paciente'", $cn) or showerror(mysql_error());

    $conrows = mysql_num_rows($sql);
} catch (Exeption $e) {
    echo 'ocurrio un error' . $e;
}
function showerror($e)
{
    echo '<h3> Ocurrio un error agendando el estudio ' . $e . ' <br/></h3>';
}

if ($conrows > 0)
{
?>
<center>
    <div class="table">
        <div class="row header blue">
            <div class="cell">
                <strong>Orden</strong>
            </div>
            <div class="cell">
                <strong>Documento</strong>
            </div>
            <div class="cell">
                <strong>Servicio</strong>
            </div>
            <div class="cell">
                <strong>Estudio</strong>
            </div>
            <div class="cell">
                <strong>Fecha Solicitud</strong>
            </div>
            <div class="cell">
                <strong>Fecha Cita</strong>
            </div>
            <div class="cell">
                <strong>Acciones</strong>
            </div>
        </div>
        <?php while ($row = mysql_fetch_array($sql)) {
            $idestudio = $row['idestudio'];
            echo
                '<div class="row">
              <div class="cell">
                ' . $row['orden'] . '
              </div>
              <div class="cell">
                ' . $row['id_paciente'] . '
              </div>
              <div class="cell">
                ' . $row['descservicio'] . '
              </div>
              <div class="cell">
                ' . $row['nom_estudio'] . '
              </div>
			  <div class="cell">
                ' . $row['fecha_solicitud'] . '<br/>' . $row['hora_solicitud'] . '
              </div>
			  <div class="cell">
                ' . $row['fecha_cita'] . '<br/>' . $row['hora_cita'] . '
              </div>
			  <div class="cell">
                <input type="button" value="Eliminar" onclick="ParcialAjax(\'eliminar\',' . $row['id_paciente'] . ',' . $idestudio . ')"/>
              </div>
            </div>';
        }
        }
        mysql_free_result($sql);
        mysql_close($cn);
        ?>
    </div>
    </div>
</center>
