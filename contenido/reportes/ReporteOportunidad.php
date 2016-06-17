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
header("content-disposition: attachment;filename=OportunidadAsignacionCitas".$descSede.'-'.desde.'/'.$hasta.".xls");

//obtener totalidad de estudios
$SqlAgenda = mysql_query("SELECT id_informe, id_paciente, idestudio, id_prioridad, idservicio,
id_tecnica, idtipo_paciente, fecha_solicitud, hora_solicitud FROM r_informe_header  WHERE fecha_solicitud
BETWEEN '$desde' AND '$hasta' AND idsede = '$idSede' ORDER BY idservicio, fecha_solicitud, hora_solicitud ASC", $cn);
$ConAgenga = mysql_num_rows($SqlAgenda);
$consecutivo=1;
function GetPaciente($cn, $idPaciente)
{
    $SqlPaciente = mysql_query("SELECT p.nom1,p.nom2, p.ape1,p.ape2, eps.eapb,i.cod_documento,p.fecha_nacimiento,s.desc_sexo FROM r_paciente p
INNER JOIN eps eps ON eps.ideps = p.ideps

INNER JOIN tipo_documento i ON  i.idtipo_documento = p.idtipo_documento
INNER JOIN r_sexo s ON s.id_sexo =  p.id_sexo 
 WHERE p.id_paciente = '$idPaciente'" , $cn);

    $RegPaciente = mysql_fetch_array($SqlPaciente);
    $tipoderegistro = 2;

    $consecutivo=$consecutivo+1;
    $tipodeid = ucwords(strtolower($RegPaciente['cod_documento']));
    $apellido1 = ucwords(strtolower($RegPaciente['ape1']));
    $apellido2 = ucwords(strtolower($RegPaciente['ape2']));
    $nombre1 = ucwords(strtolower($RegPaciente['nom1'])); 
    $nombre2 = ucwords(strtolower($RegPaciente['nom2']));
    $fecha_nacimiento = ucwords(strtolower($RegPaciente['fecha_nacimiento']));
    $sexo = ucwords(strtolower($RegPaciente['desc_sexo']));
    $eps = ucwords(strtolower($RegPaciente['eapb']));
    $String = '';

    $String .= '<td align="center">' . $tipoderegistro . '</td>
                <td align="center">' . $consecutivo . '</td> 
                <td align="center">' . $tipodeid . '</td> 
                <td align="center">' . $idPaciente . '</td> 
                <td align="center">' . $fecha_nacimiento . '</td>
                <td align="center">' . $sexo . '</td>
                <td align="center">' . $apellido1 . '</td>
                <td align="center">' . $apellido2 . '</td>
                 <td align="center">' . $nombre1 . '</td>
                <td align="center">' . $nombre2 . '</td>
                <td align="center">' . $eps . '</td>';
    return $String;
}
function GetEstudio($cn, $idInforme, $idPaciente){
    $ConEstudio = mysql_query("SELECT i.idestudio, i.id_tecnica, i.idservicio, i.idtipo_paciente, e.nom_estudio, t.desc_tecnica, ser.descservicio, tp.desctipo_paciente,e.cups_iss,i.fecha_solicitud,i.fecha_preparacion FROM r_informe_header i
    INNER JOIN r_estudio e ON e.idestudio = i.idestudio
    INNER JOIN r_tecnica t ON t.id_tecnica = i.id_tecnica
    INNER JOIN servicio ser ON ser.idservicio = i.idservicio
    inner JOIN r_tipo_paciente tp ON tp.idtipo_paciente = i.idtipo_paciente
    WHERE i.id_informe = '$idInforme' AND i.id_paciente = '$idPaciente'", $cn);
    $RegEstudio = mysql_fetch_array($ConEstudio);
    $cups= ucwords(strtolower($RegEstudio['cups_iss']));
    $fechasolicitud= ucwords(strtolower($RegEstudio['fecha_solicitud']));
    $siono="S";
    $fechapreparacion = ucwords(strtolower($RegEstudio['fecha_preparacion']));
 
    $fechadeseadaporelusuario = ucwords(strtolower($RegEstudio['fecha_preparacion']));
   
    $String = '';

    $String .= '
                <td align="center">'. $cups .'</td>
                <td align="center">'. $fechasolicitud .'</td>
                <td align="center">'. $siono.'</td>
                <td align="center">'. $fechapreparacion.'</td>               
                <td align="center">'. $fechadeseadaporelusuario .'</td>
                                                       ';
            return $String;
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
        <td colspan="16"><?php echo $descSede ?></td>
    </tr>
    <tr align="center">
    <td width="8%">Tipo de registro</td>
    <td width="8%">Consecutivo de registro</td>
    <td width="8%">Tipo de identificacion del usuario</td>
    <td width="8%">Numero de identificacion del usuario</td>
    <td width="8%">Fecha de nacimiento del usuario</td>
        <td width="8%">Sexo del usuario</td>
        <td width="10%">Primer  apellido del usuario</td>        
        <td width="10%">Segundo apellido del usuario</td>
        <td width="10%">Primer Nombre del usuario</td>
        <td width="10%">Segundo nombre del usuario</td>
        <td width="20%">Codigo de la EAPB del usuario</td>
        <td width="5%">Identificacion del tipo de cita o procedimiento no quirujico</td>
        <td width="9%">Fecha de la solicitud de la cita</td>
        <td width="10%">La cita fue asignada</td>
        <td width="10%">Fecha de la Asignacion de la cita</td>
        <td width="8%">Fecha para la cual el usuario solicito que le fuera asignada la cita(fecha deseada)</td>
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
                echo '</tr>';
            }
        }
    ?>


</table>