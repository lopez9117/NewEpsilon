<?php
class Horas{
    function GetHorasMes($cn, $mes, $anio){
        //consultar horas laborables mes
        $sqlLab = mysql_query("SELECT cant_horas FROM hora_mensual WHERE mes = '$mes' AND anio = '$anio'", $cn);
        $resLab = mysql_fetch_array($sqlLab);
        $CantidadHoras = $resLab['cant_horas'];
        return $CantidadHoras;
    }
    function DiasMes($mes, $anio){
        $dias = date('t', mktime(0,0,0, $mes, 1, $anio));
        $fecha_limite = $anio."-".$mes."-".$dias;
        return $fecha_limite;
    }
    function GetVacaciones($idFuncionario, $FechaInicio, $FechaFinal, $cn ){
        $SqlVacaciones = mysql_query("SELECT fecha FROM turno_funcionario WHERE idtipo_turno = '100' AND fecha BETWEEN '$FechaInicio' AND '$FechaFinal' AND idfuncionario = '$idFuncionario'", $cn);
        $ContVacaciones = mysql_num_rows($SqlVacaciones);
        return $ContVacaciones;
    }
    function GetDisponibilidades($idFuncionario, $FechaInicio, $FechaFinal, $cn ){
        $consDisponibilidades = mysql_query("SELECT fecha FROM ct_disponibilidad_funcionario WHERE idfuncionario = '$idFuncionario' AND fecha BETWEEN '$FechaInicio' AND '$FechaFinal'", $cn);
        $contDisponibilidades = mysql_num_rows($consDisponibilidades);
        if($contDisponibilidades>=1){
            $contador = round(($contDisponibilidades/7), 1);
            return $contador;
        }
        else{
            $contador = 0;
            return $contador;
        }
    }
    function SumatoriaHoras($cn, $mes, $anio, $idFuncionario){
        $FechaInicial = ($anio.'-'.$mes.'-'.'01');
        $FechaFinal = ($anio.'-'.$mes.'-'.'31');
        $SqlHoras = mysql_query("SELECT SUM(diurna) AS diurnaO, SUM(diurnafest) AS diurnaF, SUM(nocturna) AS nocturnaO, SUM(nocturnafest) AS nocturnaF, SUM(diurna + nocturna + nocturnafest + diurnafest) AS total FROM turno_funcionario WHERE fecha BETWEEN '$FechaInicial' AND '$FechaFinal' AND idfuncionario = '$idFuncionario'", $cn);
        $ResHoras = mysql_fetch_array($SqlHoras);
        $String = '';
        $String .=' <td>'.round($ResHoras['diurnaO'], 1).'</td>
                    <td>'.round($ResHoras['nocturnaO'], 1).'</td>
                    <td>'.round($ResHoras['diurnaF'], 1).'</td>
                    <td>'.round($ResHoras['nocturnaF'], 1).'</td>
                    <td>'.round($ResHoras['total'], 1).'</td>';
        return $String;
    }
    function SumatoriaHorasAdicionales($cn, $mes, $anio, $idFuncionario){
        $FechaInicial = ($anio.'-'.$mes.'-'.'01');
        $FechaFinal = ($anio.'-'.$mes.'-'.'31');
        $SqlHoras = mysql_query("SELECT n.idturno, SUM(n.diurnas_adicionales) AS diurnasO, SUM(n.nocturnas_adicionales) AS nocturnasO,
        SUM(n.diurfest_adicionales) AS diurnasF, SUM(n.nocfest_adicionales) AS nocturnasF,
        SUM(diurnas_adicionales + nocturnas_adicionales + diurfest_adicionales + nocfest_adicionales) AS total FROM
        novedad_turno n INNER JOIN turno_funcionario t ON t.idturno = n.idturno
        WHERE t.fecha BETWEEN '$FechaInicial' AND '$FechaFinal' AND t.idfuncionario = '$idFuncionario'", $cn);
        $ResHoras = mysql_fetch_array($SqlHoras);
        $String = '';
        $String .=' <td>'.round($ResHoras['diurnaO'], 1).'</td>
                    <td>'.round($ResHoras['nocturnaO'], 1).'</td>
                    <td>'.round($ResHoras['diurnaF'], 1).'</td>
                    <td>'.round($ResHoras['nocturnaF'], 1).'</td>
                    <td>'.round($ResHoras['total'], 1).'</td>';
        return $String;
    }
}
function CalcularHoras($horaIni, $horaFin, $FechaInicio, $FechaFinal, $fecha, $cn)
{
    //variables de referencia
    $InicioHorasDiurnas = strtotime("06:00");
    $InicioHorasNocturnas = strtotime("22:00");
    $InicioCmbioDia = strtotime("00:00");
    //Calula la diferencia entre las horas
    $totalHoras = (date("H:i", strtotime("00:00") + strtotime($horaFin) - strtotime($horaIni)));
    $desglose = mb_split(":", $totalHoras);
    $TotalLaboradas = $desglose[0] + $desglose[1] / 60;
    //calcular las horas diurnas
    $totalDiurnas = 0;
    $TotalDiurnasFestivas = 0;
    $TotalNocturnasFestivas = 0;
    $TotalNocturnas = 0;
    $HoraInicial = strtotime($horaIni);
    $HoraFinal = strtotime($horaFin);
    $DiaFestivo = IsDiaFestivo($fecha, $FechaInicio, $FechaFinal, $cn);
    $DiaDespues = SumarDia($fecha);
    $DiaFestivoDespues = IsDiaFestivo($DiaDespues, $FechaInicio, $FechaFinal, $cn);
    $Hora_Final_Aux = 0;
    if ($horaFin == "00:00") {
        $Hora_Final_Aux = strtotime("23:59");
    } else {
        $Hora_Final_Aux = $HoraFinal;
    }
    //cuando los turnos corresponden al mismo dia
    if ($HoraInicial < $Hora_Final_Aux) {
        $TotalNocturnasFestivas = 0;
        $TotalNocturnas = 0;
        $AuxInicio = strtotime("06:00");
        if ($Hora_Final_Aux > $InicioHorasNocturnas) {
            $AuxFin = $Hora_Final_Aux;
            $HoraFinal = $InicioHorasNocturnas;
        }
        if ($HoraInicial < $InicioHorasDiurnas) {
            $AuxInicio = $HoraInicial;
            $HoraInicial = $InicioHorasDiurnas;
        }
        if ($HoraInicial >= $InicioHorasDiurnas) {
            if ($DiaFestivo) {
                $TotalDiurnasFestivas = Calcular($HoraInicial, $HoraFinal);
                if ($AuxFin > $HoraFinal) {
                    $TotalNocturnasFestivas = $TotalNocturnasFestivas + Calcular($InicioHorasNocturnas, $AuxFin);
                }
                if ($AuxInicio < $InicioHorasDiurnas) {
                    $TotalNocturnasFestivas = $TotalNocturnasFestivas + Calcular($AuxInicio, $InicioHorasDiurnas);
                }
            } else {
                $totalDiurnas = Calcular($HoraInicial, $HoraFinal);
                if ($AuxFin > $HoraFinal) {
                    $TotalNocturnas = $TotalNocturnas + Calcular($InicioHorasNocturnas, $AuxFin);
                }
                if ($AuxInicio < $InicioHorasDiurnas) {
                    $TotalNocturnas = $TotalNocturnas + Calcular($AuxInicio, $InicioHorasDiurnas);
                }
            }
        }
    } else {
        if ($HoraInicial < $InicioHorasNocturnas) {
            if ($DiaFestivo) {
                $TotalDiurnasFestivas = $TotalDiurnasFestivas + Calcular($HoraInicial, $InicioHorasNocturnas);
                $TotalNocturnasFestivas = $TotalNocturnasFestivas + Calcular($InicioHorasNocturnas, strtotime("23:59"));
            } else {
                $totalDiurnas = $totalDiurnas + Calcular($HoraInicial, $InicioHorasNocturnas);
                $TotalNocturnas = $TotalNocturnas +Calcular($InicioHorasNocturnas, strtotime("23:59"));
            }
        } else {
            if ($DiaFestivo) {
                $TotalNocturnasFestivas = $TotalNocturnasFestivas + Calcular($HoraInicial, strtotime("23:59"));
            } else {
                $TotalNocturnas = $TotalNocturnas + Calcular($HoraInicial, strtotime("23:59"));
            }
        }
        if ($HoraFinal > $InicioHorasDiurnas) {
            if ($DiaFestivoDespues) {
                $TotalNocturnasFestivas = $TotalNocturnasFestivas + Calcular($InicioCmbioDia, $InicioHorasDiurnas);
                $TotalDiurnasFestivas = $TotalDiurnasFestivas + Calcular($InicioHorasDiurnas, $HoraFinal);
            } else {
                $TotalNocturnas = $TotalNocturnas + Calcular($InicioCmbioDia, $InicioHorasDiurnas);//
                $totalDiurnas = $totalDiurnas + Calcular($InicioHorasDiurnas, $HoraFinal);
            }
        } else {
            if ($DiaFestivoDespues) {
                $TotalNocturnasFestivas = $TotalNocturnasFestivas + Calcular($InicioCmbioDia, $HoraFinal);
            } else {
                $TotalNocturnas = $TotalNocturnas + Calcular($InicioCmbioDia, $HoraFinal);
            }
        }
    }
    $ContadorHoras = array("TotalDiurnas"=>round($totalDiurnas, 1), "TotalNocturnas"=>round($TotalNocturnas, 1), "TotalDiurnasFestivas"=>round($TotalDiurnasFestivas, 1), "TotalNocturnasFestivas"=>round($TotalNocturnasFestivas, 1), "TotalLaboradas"=>round(($TotalLaboradas), 1));
    return $ContadorHoras;
}

function Calcular($horaIni, $horaFin)
{
    //Calula la diferencia entre las horas
    $totalHoras = (date("H:i", strtotime("00:00") + $horaFin - $horaIni));
    $desglose = mb_split(":", $totalHoras);
    $TotalDiurnas = ($desglose[0] + $desglose[1] / 60);
    return $TotalDiurnas;
}
//obtener dias feriados y domingos
function IsDiaFestivo($fecha, $FechaInicio, $FechaFinal, $cn)
{
    //$FechaFinal = '2016-12-31';
    //obtener los dias festivos del mes
    $boolReturn = false;
    $SqlFestivos = mysql_query("SELECT fecha_festivo FROM dia_festivo", $cn);
    $DiaFestivo = array();
    while ($RowDiaFestivo = mysql_fetch_array($SqlFestivos)) {
        $DiaFestivo[$RowDiaFestivo['fecha_festivo']] = $RowDiaFestivo['fecha_festivo'];
    }
    if (date('N', strtotime($fecha)) == 7) {
        $boolReturn = true;
    }
    else if (array_key_exists($fecha,$DiaFestivo)) {
        $boolReturn = true;
    }else {
        $boolReturn = false;
    }
    return $boolReturn;
}
//obtener una fecha adicional
function SumarDia($fecha)
{
	$fechaInicio = date($fecha);
	$nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
	$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
	return $nuevafecha;
}
?>