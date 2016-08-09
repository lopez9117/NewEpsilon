<?php
ini_set('max_execution_time', 0);
include("../../dbconexion/conexion.php");
$cn = Conectarse();

//variables
$desde = trim(base64_decode($_GET['FchDesde'])); 
$hasta = trim(base64_decode($_GET['FchHasta'])); 
$idSede = trim(base64_decode($_GET['sede'])); 
$descSede = trim(base64_decode($_GET['descSede']));

//convertir el documento en excel
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=OportunidadAsignacionCitas".$descSede.'-'.desde.'-'.$hasta.".xls");

//obtener totalidad de estudios
$SqlAgenda = mysql_query("SELECT id_informe, id_paciente, idestudio, id_prioridad, idservicio,
id_tecnica, idtipo_paciente, fecha_solicitud, hora_solicitud FROM r_informe_header  WHERE fecha_solicitud
BETWEEN '$desde' AND '$hasta' AND idsede = '$idSede' ORDER BY idservicio, fecha_solicitud, hora_solicitud ASC", $cn);
$ConAgenga = mysql_num_rows($SqlAgenda);


function GetPaciente($cn, $idPaciente)
{
    $SqlPaciente = mysql_query("SELECT CONCAT(p.nom1,' ',p.nom2) AS nombres, CONCAT(p.ape1,' ', p.ape2) AS apellidos, eps.desc_eps FROM r_paciente p
INNER JOIN eps eps ON eps.ideps = p.ideps WHERE p.id_paciente = '$idPaciente'", $cn);
    $RegPaciente = mysql_fetch_array($SqlPaciente);
    $nombres = ucwords(strtolower($RegPaciente['nombres']));
    $apellidos = ucwords(strtolower($RegPaciente['apellidos']));
    $eps = ucwords(strtolower($RegPaciente['desc_eps']));
    $String = '';

    $String .= '<td align="center">' . $idPaciente . '</td> 
                <td align="center">' . $nombres . '</td>
                <td align="center">' . $apellidos . '</td>
                <td align="center">' . $eps . '</td>';
    return $String;
}

function GetEstudio($cn, $idInforme, $idPaciente){
    $ConEstudio = mysql_query("SELECT i.idestudio, i.id_tecnica, i.idservicio, i.idtipo_paciente, e.nom_estudio, t.desc_tecnica, ser.descservicio, tp.desctipo_paciente  FROM r_informe_header i
    INNER JOIN r_estudio e ON e.idestudio = i.idestudio
    INNER JOIN r_tecnica t ON t.id_tecnica = i.id_tecnica
    INNER JOIN servicio ser ON ser.idservicio = i.idservicio
    inner JOIN r_tipo_paciente tp ON tp.idtipo_paciente = i.idtipo_paciente
    WHERE i.id_informe = '$idInforme' AND i.id_paciente = '$idPaciente'", $cn);
    $RegEstudio = mysql_fetch_array($ConEstudio);
    $Estudio = ucwords(strtolower($RegEstudio['nom_estudio']));
    $Tecnica = ucwords(strtolower($RegEstudio['desc_tecnica']));
    $Servicio = ucwords(strtolower($RegEstudio['descservicio']));
    $TipoPaciente = ucwords(strtolower($RegEstudio['desctipo_paciente']));
    $String = '';

    $String .= '<td align="center">'. $Servicio .'</td>
                <td align="center">'. $Estudio .'</td>
                <td align="center">'. $Tecnica .'</td>
                <td align="center">'. $TipoPaciente .'</td>';
    return $String;
}
function GetAgendamiento($cn, $IdInforme, $estado){
    $SqlAgendamiento = mysql_query("SELECT fecha, hora FROM r_log_informe WHERE id_informe = '$IdInforme' AND id_estadoinforme = '$estado'", $cn);
    $contador = mysql_num_rows($SqlAgendamiento);
    if($contador>=1) {
        $RegAgendamiento = mysql_fetch_array($SqlAgendamiento);
        $FechaAsignacion = $RegAgendamiento['fecha'];
        //$HoraAsignacion = $RegAgendamiento['hora'];
        return $FechaAsignacion;
    }
    else{
        $String = 'Cancelado';
        return $String;
    }
}
function CalularOportunidad($fechaSolicitud, $fechaAsignacion){
    $Inicio = strtotime($fechaSolicitud);
    $Final = strtotime($fechaAsignacion);
    $Diferencia = $Final - $Inicio;
    $Oportunidad = round($Diferencia / 86400);
    if($Oportunidad<0)
    {
        return 0;
    }
    else{
        return  $Oportunidad;
        
    }
}
?>
<style type="text/css">
    body { font-family: Arial, Helvetica, sans-serif; font-size: x-small; }
    .table-fill { background: white; width: 100%;}
    tr { border-top: 1px solid #C1C3D1; border-bottom-: 1px solid #C1C3D1; }
    tr:first-child { border-top:none; }
    tr:last-child {border-bottom:none; }
    tr:nth-child(odd)
    /*td { background:#EBEBEB; }
    td { background:#FFFFFF; }*/
    .text-center { text-align: center; background-color: #000066; }
</style>
<table border="1" rules="all">
    <tr align="center">
        <td colspan="11"><?php echo $descSede ?></td>
    </tr>
    <tr align="center">
        <td width="8%">Id. Paciente</td>
        <td width="10%">Nombres</td>
        <td width="10%">Apellidos</td>
        <td width="10%">EPS</td>
        <td width="10%">Servicio</td>
        <td width="20%">Estudio</td>
        <td width="5%">Tecnica</td>
        <td width="9%">Paciente</td>
        <td width="10%">Solicitud</td>
        <td width="10%">Asignacion</td>
        <td width="8%">Oportunidad</td>
    </tr>
    
    <?php
        if($ConAgenga>=1){
            while($RowAgenda = mysql_fetch_array($SqlAgenda)){
                echo '<tr align="center">';
                $idPaciente = $RowAgenda['id_paciente'];
                $FechaSolicitud = $RowAgenda['fecha_solicitud'];
                $IdInforme = $RowAgenda['id_informe'];
                $idEstudio = $RowAgenda['idestudio'];
                $HoraSolicitud = $RowAgenda['hora'];
                
                echo GetPaciente($cn, $idPaciente);
                echo GetEstudio($cn, $IdInforme, $idPaciente);
                echo '<td>'. $FechaSolicitud .'</td>';
                echo '<td>'. GetAgendamiento($cn, $IdInforme, 1) .'</td>';
                echo '<td>'. CalularOportunidad($FechaSolicitud, GetAgendamiento($cn, $IdInforme, 1)) .'</td>';
                echo '</tr>';
            }
        }
    ?>
</table>