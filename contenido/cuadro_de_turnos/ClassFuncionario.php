<?php
class funcionario
{


    function ValidateFestivo($cn, $fecha){
        $sql = mysql_query("SELECT fecha_festivo FROM dia_festivo WHERE fecha_festivo = '$fecha'", $cn);
        $reg = mysql_num_rows($sql);
        $BoolReturn = false;
        if($reg>=1){
            $BoolReturn = true;
            return $BoolReturn;
        }
        else{
            $BoolReturn = false;
            return $BoolReturn;
        }
    }


    function GetNombresApellidos($cn, $idFuncionario){
        $sql = mysql_query("SELECT f.nombres, f.apellidos, m.nombre_mun  FROM funcionario f
        INNER JOIN r_municipio m ON m.cod_mun = f.cod_mun
        WHERE idfuncionario = '$idFuncionario'", $cn);
        $res = mysql_fetch_array($sql);
        return $res;
    }
    function CrearEnlace($idFuncionario, $fechaInicial, $fecha_limite, $Nombres){
        $String = '';
        $String .='document='.base64_encode($idFuncionario).'&fchstart='.base64_encode($fechaInicial).'&fchstop='.base64_encode($fecha_limite).'&nomb='.base64_encode($Nombres).'';
        return $String;
    }

    //Otener turnos de funcionario
    function GetTurnos($IdFuncionario, $fecha, $FechaInicio, $FechaFinal, $fecha_log, $cn)
    {
        $Detalles = '';
        //Consultar los datos de un turno
        $SqlTurno = mysql_query("SELECT tf.time, tf.fecha, tf.hr_inicio, tf.hr_fin, se.descsede, ser.descservicio FROM turno_funcionario tf
        INNER JOIN sede se ON se.idsede = tf.idsede
        INNER JOIN servicio ser ON  ser.idservicio = tf.idservicio WHERE tf.idfuncionario = '$IdFuncionario' AND fecha = '$fecha' AND time = '$fecha_log' ORDER BY fecha ASC", $cn);
        $RowTurno = mysql_fetch_array($SqlTurno);
        $DiaFestivo = funcionario::IsDiaFestivo($fecha, $FechaInicio, $FechaFinal, $cn);
        $style = '';
        if ($DiaFestivo) {
            $style = 'class="btn-primary"';
        }
        $Detalles .= '<tr align="center"' . $style . '>
        <td>'. funcionario::DiaSemana($fecha) .'</td>
        <td>' . $fecha . '</td>
        <td>' . $RowTurno['descsede'] . '</td>
        <td>' . $RowTurno['descservicio'] . '</td>
        <td>' . $RowTurno['hr_inicio'] . '</td>
        <td>' . $RowTurno['hr_fin'] . '</td>
        ' . funcionario::CalcularHoras($RowTurno['hr_inicio'], $RowTurno['hr_fin'], $FechaInicio, $FechaFinal, $fecha, $cn) . '
        </tr>';
        return $Detalles;
    }

    function DiaSemana($fecha){
        list($anio, $mes, $dia) = explode("-",$fecha);
        $wkdy = (((mktime ( 0, 0, 0, $mes, $dia, $anio) - mktime ( 0, 0, 0, 7, 17, 2006))/(60*60*24))+700000) % 7;
        $DiasSemana = array(0=>"L", 1=>"M", 2=>"W", 3=>"J", 4=>"V", 5=>"S", 6=>"D");
        foreach($DiasSemana as $ValorDia => $NomDia){
            if($wkdy == $ValorDia){
                return $NomDia;
            }
        }
    }
    function GetVacaciones($idFuncionario, $FechaInicio, $FechaFinal, $cn ){
        $SqlVacaciones = mysql_query("SELECT fecha FROM turno_funcionario WHERE idtipo_turno = '100' AND fecha BETWEEN '$FechaInicio' AND '$FechaFinal' AND idfuncionario = '$idFuncionario'", $cn);
        $ContVacaciones = mysql_num_rows($SqlVacaciones);
        if($ContVacaciones>=1){
            return $ContVacaciones;
        }
       else{
           $String = '';
           $String .= 'No se registraron vacaciones en este periodo';
           return $String;
       }
    }
    function GetDisponibilidades($idFuncionario, $FechaInicio, $FechaFinal, $cn ){
        $consDisponibilidades = mysql_query("SELECT fecha FROM ct_disponibilidad_funcionario WHERE idfuncionario = '$idFuncionario' AND fecha BETWEEN '$FechaInicio' AND '$FechaFinal'", $cn);
        $contDisponibilidades = mysql_num_rows($consDisponibilidades);
        if($contDisponibilidades>=1){
            $contador = round(($contDisponibilidades/7), 2);
            return $contador;
        }
        else{
            $String = '';
            $String .= 0;
            return $String;
        }
    }
    function GetGrupoEmpleado($cn, $idGrupoEmpleado){
        $SqlGrupo = mysql_query("SELECT desc_grupoempleado FROM grupo_empleado WHERE idgrupo_empleado = '$idGrupoEmpleado'", $cn);
        $RegGrupo = mysql_fetch_array($SqlGrupo);
        $Grupo = ucwords(strtolower($RegGrupo['desc_grupoempleado']));
        return $Grupo;
    }
}
function GetSede($cn, $idSede){
    $sqlSede = mysql_query("SELECT descsede FROM sede WHERE idsede = '$idSede'", $cn);
    $regSede = mysql_fetch_array($sqlSede);
    $Sede = ucwords(strtolower($regSede['descsede']));
    return $Sede;

}

?>