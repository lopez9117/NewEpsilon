<?php
class Paciente{
    function GetPaciente($cn, $idPaciente)
    {
        $SqlPaciente = mysql_query("SELECT CONCAT(nom1,' ',nom2) AS nombres, CONCAT(ape1,' ', ape2) AS apellidos FROM r_paciente WHERE id_paciente = '$idPaciente'", $cn);
        $RegPaciente = mysql_fetch_array($SqlPaciente);
        $nombres = ucwords(strtolower($RegPaciente['nombres']));
        $apellidos = ucwords(strtolower($RegPaciente['apellidos']));
        $String = '';
        $String .= '
        <td>' . $nombres .' '. $apellidos .'</td>';
        return $String;
    }
    //obtener informacion del estudio
    function GetEstudio($cn, $idInforme, $idPaciente){
        $ConEstudio = mysql_query("SELECT i.idestudio, i.id_tecnica, i.idtipo_paciente, i.id_prioridad, i.ubicacion, e.nom_estudio, t.desc_tecnica,
        tp.desctipo_paciente, p.desc_prioridad FROM r_informe_header i
        INNER JOIN r_estudio e ON e.idestudio = i.idestudio
        INNER JOIN r_tecnica t ON t.id_tecnica = i.id_tecnica
        INNER JOIN r_tipo_paciente tp ON tp.idtipo_paciente = i.idtipo_paciente
        INNER JOIN r_prioridad p ON p.id_prioridad = i.id_prioridad
        WHERE i.id_informe = '$idInforme' AND i.id_paciente = '$idPaciente'", $cn);
        $RegEstudio = mysql_fetch_array($ConEstudio);
        $Estudio = ucwords(strtolower($RegEstudio['nom_estudio']));
        $Tecnica = ucwords(strtolower($RegEstudio['desc_tecnica']));
        $TipoPaciente = ucwords(strtolower($RegEstudio['desctipo_paciente']));
        $Prioridad = ucwords(strtolower($RegEstudio['desc_prioridad']));
        $Ubicacion = ucwords(strtolower($RegEstudio['ubicacion']));
        $String = '';
        $String .= '
        <td>'. $Estudio .'</td>
        <td align="center">'. $Tecnica .'</td>
        <td align="center">'. $TipoPaciente .'</td>
        <td align="center">'. $Prioridad .'</td>
        <td align="center">'. $Ubicacion .'</td>';
        return $String;
    }
//obtener datos de agendamiento, toma, etc
    function GetAgendamiento($cn, $IdInforme, $estado){
        $SqlAgendamiento = mysql_query("SELECT fecha, hora FROM r_log_informe WHERE id_informe = '$IdInforme' AND id_estadoinforme = '$estado' ", $cn);
        $RegAgendamiento = mysql_fetch_array($SqlAgendamiento);
        $FechaAsignacion = $RegAgendamiento['fecha'];
        $HoraAsignacion = $RegAgendamiento['hora'];
        $TomaDeEstudio = $FechaAsignacion.' '.$HoraAsignacion;
        return $TomaDeEstudio;
    }
}
function TareasEspecialista($cn, $IdInforme, $idUsuario){
    $sqlAdjunto = mysql_query("SELECT ad.id_informe,ad.adjunto,ad.id_adjunto,i.id_informe FROM r_adjuntos ad
INNER JOIN r_informe_header i ON i.id_informe = ad.id_informe where i.id_informe='$IdInforme'", $cn);
    $count = mysql_num_rows($sqlAdjunto);
    $String = '';
    $String .=
        '<table>
            <tr align="center">
                <td></td>
                <td><a href="TranscribirAprobar.php?idinforme='.base64_encode($IdInforme).'&idfuncionario='.base64_encode($idUsuario).'" target="transcripcion" onClick="window.open(this.href, this.target); return false;"><img src="../../../../images/kate.png" width="15" height="15" title="Transcribir/Aprobar Estudios" alt="Transcribir/Aprobar Estudios" /></a></td>
                <td><img src="../../../../images/reload.png" width="15" height="15" title="Regresar Estudio" alt="Regresar Estudio" /></td>
                <td><img src="../../../../images/dokter.png" width="15" height="15" title="Nota Medica" alt="Nota Medica" /></td>
                <td><img src="../../../../images/adblock.png" width="15" height="15" title="Registrar Evento Adverso" alt="Registrar Evento Adverso" /></td>
            </tr>
        </table>';
    return $String;
}
class funcionario
{
    function GetFuncionario($cn, $idFuncionario)
    {
        $SqlFuncionario = mysql_query("SELECT CONCAT(nombres, ' ', apellidos) AS especialista FROM funcionario WHERE idfuncionario = '$idFuncionario'", $cn);
        $RegFuncionario = mysql_fetch_array($SqlFuncionario);
        $NomFuncionario = ucwords(strtolower($RegFuncionario['especialista']));
        return $NomFuncionario;
    }

    function GetPermisos($cn, $idFuncionario){
        $boolReturn = false;
        $SqlPermisos = mysql_query("SELECT idfuncionario_esp FROM r_especialista WHERE idfuncionario_esp = '$idFuncionario'", $cn);
        $ResPermisos = mysql_num_rows($SqlPermisos);
        if($ResPermisos>=1){
            $boolReturn = true;
            return $boolReturn;
        }
        else{
            $boolReturn = false;
            return $boolReturn;
        }
    }
}
function DatosEsudio($cn, $idInforme)
{
    $ConEstudio = mysql_query("SELECT i.id_paciente,i.idestudio, i.id_tecnica, i.idtipo_paciente, i.id_prioridad, i.orden, i.ubicacion, i.desc_extremidad, e.nom_estudio, t.desc_tecnica,
        tp.desctipo_paciente, p.desc_prioridad FROM r_informe_header i
        INNER JOIN r_estudio e ON e.idestudio = i.idestudio
        INNER JOIN r_tecnica t ON t.id_tecnica = i.id_tecnica
        INNER JOIN r_tipo_paciente tp ON tp.idtipo_paciente = i.idtipo_paciente
        INNER JOIN r_prioridad p ON p.id_prioridad = i.id_prioridad
        WHERE i.id_informe = '$idInforme'", $cn);
        $RegEstudio = mysql_fetch_array($ConEstudio);
    return $RegEstudio;
}

function DatosPaciente($cn, $idPaciente){
    $SqlPaciente = mysql_query("SELECT CONCAT(p.nom1,' ',p.nom2) AS nombres, CONCAT(p.ape1,' ',p.ape2) AS apellidos, p.fecha_nacimiento, p.ideps, sex.desc_sexo FROM r_paciente p
    INNER JOIN r_sexo sex ON sex.id_sexo = p.id_sexo
    WHERE id_paciente = '$idPaciente'", $cn);
    $RegPaciente = mysql_fetch_array($SqlPaciente);
    return $RegPaciente;
}
function calculaedad($fechanacimiento){
    list($ano, $mes, $dia) = explode("-", $fechanacimiento);
    $ano_diferencia = date("Y") - $ano;
    $mes_diferencia = date("m") - $mes;
    $dia_diferencia = date("d") - $dia;
    if ($dia_diferencia < 0 || $mes_diferencia < 0)
        $ano_diferencia--;
    return $ano_diferencia;
}
function GetEps($cn, $ideps){
    $SqlEps = mysql_query("SELECT desc_eps FROM eps WHERE ideps='$ideps'", $cn);
    $RegEps = mysql_fetch_array($SqlEps);
    $eps = ucwords(strtolower($RegEps['desc_eps']));
    return $eps;
}
function GetRealizacion($cn, $idInforme){
    $SqlRealizacion = mysql_query("SELECT fecha, hora FROM r_log_informe WHERE id_estadoinforme = '2' AND id_informe = '$idInforme' GROUP BY id_informe", $cn);
    $RegRealizacion = mysql_fetch_array($SqlRealizacion);
    return $RegRealizacion;
}
function GetLectura($cn, $idinforme){
    $SqlLectura = mysql_query("SELECT detalle_informe, adicional, id_tipo_resultado FROM r_detalle_informe WHERE id_informe = '$idinforme'", $cn);
    $RegLectura = mysql_fetch_array($SqlLectura);
    return $RegLectura;
}
function GetServicioEstudio($cn, $IdEstudio){

    $ConStudio = mysql_query("SELECT idservicio FROM r_estudio WHERE idestudio = '$IdEstudio'", $cn);
    $RegStudio = mysql_fetch_array($ConStudio);
    $idServicio = $RegStudio['idservicio'];
    return $idServicio;
}

function GetBiRads($cn, $idinforme){
    $SqlBiRads = mysql_query("SELECT valor_birad FROM r_birad_informe WHERE id_informe = '$idinforme'", $cn);
    $RegBiRads = mysql_fetch_array($SqlBiRads);
    $ValBiRads = $RegBiRads['valor_birad'];
    return $ValBiRads;
	mysql_free_result($SqlBiRads);
	mysql_close($cn);
}

function GetEstadoLista($cn, $sede, $servicio){
    $consLista = mysql_query("SELECT * FROM r_conf_lista_lectura WHERE idsede = '$sede' AND idservicio = '$servicio' AND idestado_actividad = '2'", $cn);
    $regsLista = mysql_num_rows($consLista);
    return $regsLista;
	mysql_free_result($consLista);
	mysql_close($cn);
}

class Sede{
    function GetSede($cn, $idSede){
        $SqlSede = mysql_query("SELECT descsede FROM sede WHERE idsede = '$idSede'", $cn);
        $RegSede = mysql_fetch_array($SqlSede);
        return $RegSede['descsede'];
		mysql_free_result($SqlSede);
		mysql_close($cn);
    }
}
function GetOportunidad($cn, $idInforme, $Realizacion){
    $ConsInforme = mysql_query("SELECT idsede, idtipo_paciente, idservicio FROM r_informe_header WHERE id_informe = '$idInforme'", $cn);
    $RegsInforme = mysql_fetch_array($ConsInforme);
    $idSede = $RegsInforme['idsede'];
    $idServicio = $RegsInforme['idservicio'];
    $idTipoPaciente = $RegsInforme['idtipo_paciente'];
    $ConsOportunidad = mysql_query("SELECT tiempo_oportunidad FROM r_oportunidad_sede WHERE idsede = '$idSede' AND idtipo_paciente = '$idTipoPaciente' AND idservicio = '$idServicio'", $cn);
    $RegsOportunidad = mysql_fetch_array($ConsOportunidad);
    $Oportunidad = $RegsOportunidad['tiempo_oportunidad'];
    $VarStyle = '';
    if($Oportunidad!=''){
        $TiempoTranscurrido = CalcularOportunidad($Realizacion);
        $TiempoRestante = $Oportunidad - $TiempoTranscurrido;

        if($TiempoRestante<=6){
            $VarStyle = 'style="color:red"';
        }
        elseif($TiempoRestante>6 && $TiempoRestante<=12){
            $VarStyle = 'style="color:#d58512"';
        }
        else{
            $VarStyle = '';
        }
    }
    return $VarStyle;
	mysql_free_result($ConsInforme);
	mysql_free_result($ConsOportunidad);
	mysql_close($cn);
}
function CalcularOportunidad($Realizacion){
    $hoy = date('Y-m-d H:i:s');
    $tiempo_en_segundos = strtotime($hoy) - strtotime($Realizacion);
    $horas = floor($tiempo_en_segundos / 3600);
    $minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
    $segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);
    return $horas;
}

function GetTipoResultado($cn, $idInforme){
    $Sql = mysql_query("SELECT id_tipo_resultado FROM r_detalle_informe WHERE id_informe = '$idInforme'", $cn);
    $Reg = mysql_fetch_array($Sql);
    $TipoResultado = $Reg['id_tipo_resultado'];
    $VarStyle = '';
    if($TipoResultado>1){
        $VarStyle = 'style="color:red"';
    }
    else{
        $VarStyle = '';
    }
    return $VarStyle;
	mysql_free_result($Sql);
	mysql_close($cn);
}

function ShowTipoResultado($cn, $idInforme){
    $Sql = mysql_query("SELECT id_tipo_resultado FROM r_detalle_informe WHERE id_informe = '$idInforme'", $cn);
    $Reg = mysql_fetch_array($Sql);
    $TipoResultado = $Reg['id_tipo_resultado'];
    if($TipoResultado==0 || $TipoResultado==1){
        $ShowTipoResultado = 'Normal';
    }
    elseif($TipoResultado==2){
        $ShowTipoResultado = 'Crit&iacute;co';
    }
    return $ShowTipoResultado;
	mysql_free_result($Sql);
	mysql_close($cn);
}

function GetEspecialista($cn, $idInforme){
    $sqlEspecialista = mysql_query("SELECT l.idfuncionario, f.nombres, f.apellidos FROM r_log_informe l
INNER JOIN funcionario f ON f.idfuncionario = l.idfuncionario
WHERE l.id_informe = '$idInforme' AND l.id_estadoinforme = '3'", $cn);
    $regEspecialista = mysql_fetch_array($sqlEspecialista);
    $nombEspecialista = ucwords(strtolower($regEspecialista['nombres'])).' '.ucwords(strtolower($regEspecialista['apellidos']));
    return $nombEspecialista;
	mysql_free_result($sqlEspecialista);
	mysql_close($cn);
}
?>