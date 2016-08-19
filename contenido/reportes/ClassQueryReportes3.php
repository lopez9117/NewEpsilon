<?php
class funcionario{

    function GetFuncionario($cn, $idFuncionario)
    {
        $SqlFuncionario = mysql_query("SELECT CONCAT(nombres, ' ', apellidos) AS especialista FROM funcionario WHERE idfuncionario = '$idFuncionario'", $cn);
        $RegFuncionario = mysql_fetch_array($SqlFuncionario);
        $NomFuncionario = ucwords(strtolower($RegFuncionario['especialista']));
        return $NomFuncionario;
    }

}

class paciente{

    function DatosPaciente($cn, $idPaciente)
    {
        $SqlPaciente = mysql_query("SELECT p.nom1, p.nom2, p.ape1 ,p.ape2, p.ideps, sex.desc_sexo, eps.desc_eps FROM r_paciente p
        INNER JOIN r_sexo sex ON sex.id_sexo = p.id_sexo
        INNER JOIN eps eps ON eps.ideps = p.ideps
        WHERE id_paciente = '$idPaciente'", $cn);
        $RegPaciente = mysql_fetch_array($SqlPaciente);
        $nom1 = ucwords(strtolower($RegPaciente['nom1']));
        $nom2 = ucwords(strtolower($RegPaciente['nom2']));
        $ape1 = ucwords(strtolower($RegPaciente['ape1']));
        $ape2 = ucwords(strtolower($RegPaciente['ape2']));
        $eps = ucwords(strtolower($RegPaciente['desc_eps']));
        $String = '';
        $String .= '
        <td>' . $idPaciente . '</td>
        <td>' . $nom1 . '</td>
        <td>' . $nom2 . '</td>
        <td>' . $ape1 . '</td>
        <td>' . $ape2 . '</td>
        <td>' . $eps . '</td>';
        return $String;
    }
}

class estudio{

    function GetEstudio($cn, $idInforme, $idPaciente){
        $ConEstudio = mysql_query("SELECT i.idestudio, i.id_tecnica, i.idtipo_paciente, i.id_prioridad, i.ubicacion, i.portatil, e.nom_estudio, t.desc_tecnica,
        tp.desctipo_paciente, p.desc_prioridad,r.desc_erp,ep.descsede,otra.descsede as otra FROM r_informe_header i
        INNER JOIN r_estudio e ON e.idestudio = i.idestudio
        INNER JOIN r_tecnica t ON t.id_tecnica = i.id_tecnica
        INNER JOIN r_tipo_paciente tp ON tp.idtipo_paciente = i.idtipo_paciente
        INNER JOIN r_prioridad p ON p.id_prioridad = i.id_prioridad
        INNER JOIN r_erp r ON r.erp = i.erp
        INNER JOIN sede ep ON ep.idsede = i.idsede
        INNER JOIN sede otra ON otra.idsede = i.lugar_realizacion
        WHERE i.id_informe = '$idInforme' AND i.id_paciente = '$idPaciente'", $cn);
        $RegEstudio = mysql_fetch_array($ConEstudio);
        $Estudio = ucwords(strtolower($RegEstudio['nom_estudio']));
        $erp = ucwords(strtolower($RegEstudio['desc_erp']));
        $sede = ucwords(strtolower($RegEstudio['descsede']));
        $lugar_realizacion=ucwords(strtolower($RegEstudio['otra']));
        $Tecnica = ucwords(strtolower($RegEstudio['desc_tecnica']));
        $TipoPaciente = ucwords(strtolower($RegEstudio['desctipo_paciente']));
        $Prioridad = ucwords(strtolower($RegEstudio['desc_prioridad']));
        $Ubicacion = ucwords(strtolower($RegEstudio['ubicacion']));
        $Portatil = $RegEstudio['portatil'];
        if($Portatil==1){
            $ResPortatil = 'Si';
        }
        else{
            $ResPortatil = 'No';
        }
        $String = '';
        $String .= '
        <td>'. $erp .'</td>
        <td>'. $sede .'</td>
        <td>'. $lugar_realizacion .'</td>
        <td>'. $Estudio .'</td>
        <td>'. $Tecnica .'</td>
        <td>'. $ResPortatil .'</td>
        <td>'. $TipoPaciente .'</td>
        <td>'. $Prioridad .'</td>
        <td>'. $Ubicacion .'</td>';
        return $String;
    }

    function GetAgendamiento($cn, $IdInforme, $estado){
        $SqlAgendamiento = mysql_query("SELECT fecha, hora FROM r_log_informe WHERE id_informe = '$IdInforme' AND id_estadoinforme = '$estado' ", $cn);
        $RegAgendamiento = mysql_fetch_array($SqlAgendamiento);
        $Fecha = $RegAgendamiento['fecha'];
        $Hora = $RegAgendamiento['hora'];
    }

    function DatosEsudio($cn, $idInforme)
    {
        $ConEstudio = mysql_query("SELECT i.id_paciente, i.idestudio, i.id_tecnica, i.idservicio, i.idtipo_paciente, i.id_prioridad, i.orden, i.ubicacion, i.desc_extremidad, i.fecha_solicitud, i.hora_solicitud,
        e.nom_estudio, t.desc_tecnica, tp.desctipo_paciente, p.desc_prioridad FROM r_informe_header i
        INNER JOIN r_estudio e ON e.idestudio = i.idestudio
        INNER JOIN r_tecnica t ON t.id_tecnica = i.id_tecnica
        INNER JOIN r_tipo_paciente tp ON tp.idtipo_paciente = i.idtipo_paciente
        INNER JOIN r_prioridad p ON p.id_prioridad = i.id_prioridad
        WHERE i.id_informe = '$idInforme'", $cn);
        $RegEstudio = mysql_fetch_array($ConEstudio);
        return $RegEstudio;
    }

    function GetAdicional($cn, $idInforme){
        $SqlAdicional = mysql_query("SELECT adicional FROM r_detalle_informe WHERE id_informe = '$idInforme'", $cn);
        $RegAdicional = mysql_fetch_array($SqlAdicional);
        $Adicional = ucwords(strtolower($RegAdicional['adicional']));
        return $Adicional;
    }

    function GetBiRads($cn, $idInforme){
        $SqlBiRads = mysql_query("SELECT valor_birad FROM r_birad_informe WHERE id_informe = '$idInforme'", $cn);
        $RegBiRads = mysql_fetch_array($SqlBiRads);
        $ValBiRads = $RegBiRads['valor_birad'];
        if($ValBiRads==''){
            $ValBiRads = 'N/A';
        }
        return $ValBiRads;
    }
}

class Sede{
    function GetSede($cn, $idSede){
        $SqlSede = mysql_query("SELECT descsede FROM sede WHERE idsede = '$idSede'", $cn);
        $RegSede = mysql_fetch_array($SqlSede);
        return $RegSede['descsede'];
    }
}

class servicio{
    function GetServicio($cn, $idServicio){
        $SqlServicio = mysql_query("SELECT descservicio FROM servicio WHERE idservicio = '$idServicio'", $cn);
        $RegServicio = mysql_fetch_array($SqlServicio);
        $DescServicio = $RegServicio['descservicio'];
        return $DescServicio;

    }
}
?>