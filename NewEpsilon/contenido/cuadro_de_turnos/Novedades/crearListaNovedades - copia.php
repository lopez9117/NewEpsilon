<?php
//sesion del usuario, validacion de la sesion para que no se pueda ingresar por url
	session_start();
	$CurrentUser = $_SESSION[currentuser] ;
	//Conexion a la base de datos
	require_once('../../dbconexion/conexion.php');
	//funcion para abrir conexion
	$cn = Conectarse();
	//declaracon de variables post
	$grupoEmpleado = $_POST[grupoEmpleado];
	$sede = $_POST[sede];
	$mes = $_POST[mes];
	$anio = $_POST[anio];
//Validar campos obligatorios dentro del formulario
if($grupoEmpleado=="" || $sede=="" || $mes=="" || $anio=="" || $CurrentUser=="")
{
	echo '<table width="100%" border="0" align="center">
    <tr align="left" style="height:20px;">
      <td><font color="#FF0000" size="2">Los campos señalados con * son obligatorios</font></td>
    </tr>
    </table>';
}
else
{
	//desglosar fecha para obtener la cantidad de dias que tiene el mes
	$dias = date('t', mktime(0,0,0, $mes, 1, $anio));
	//dia finalizacion del mes
	$fecha_inicio = $anio."-".$mes."-".'01';
	$fecha_limite = $anio."-".$mes."-".$dias;
	//consultar si hay funcionarios con turnos en los datos ingresados en la consulta
	$consFuncionarios = mysql_query("SELECT DISTINCT idfuncionario FROM turno_funcionario WHERE fecha BETWEEN '$fecha_inicio' AND '$fecha_limite' AND idsede = '$sede' AND idgrupo_empleado = '$grupoEmpleado'", $cn);
	$regsFuncionarios = mysql_num_rows($consFuncionarios);
	
	if($regsFuncionarios==0 || $regsFuncionarios=="")
	{
		echo '<table width="100%" border="0" align="center">
		<tr align="left" style="height:20px;">
		  <td><font color="#FF0000" size="2">No se encontraron datos asociados con la consulta</font></td>
		</tr>
		</table>';
	}
	else
	{
		$mesActual = date('m');
	$anioActual = date('Y');
	$diaActual = date('d');
	//comparar si el mes y el año actual coinciden con los seleccionados
	if($anio==$anioActual && $mes==$mesActual)
	{
		echo '<script>window.open("CrearCuadroNovedades.php?grupoEmpleado='.$grupoEmpleado.'&sede='.$sede.'&mes='.$mes.'&anio='.$anio.'")</script>';
	}
	elseif($anio<$anioActual && $mes!=$mesActual)
	{
		function getMonthDays($Month, $Year)
		{
		   if( is_callable("cal_days_in_month"))
		   {
			  return cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
		   }
		   else
		   {
			  return date("d",mktime(0,0,0,$Month+1,0,$Year));
		   }
		}
		//Obtenemos la cantidad de días
		$dias = getMonthDays($mes, $anio);
		//calcular la cantidad de dias que hay entre las fechas
		$fechaOld = $anio.'-'.$mes.'-'.$dias;
		$fechaAct = $anioActual.'-'.$mesActual.'-'.$diaActual;
		function dateDiff($start, $end) 
		{ 
			$start_ts = strtotime($start); 
			$end_ts = strtotime($end); 
			$diff = $end_ts - $start_ts; 
			return round($diff / 86400);
		}
		$difDias = dateDiff($fechaOld, $fechaAct);
		//si la cantidad de dias es menor o igual a 5
		if($difDias>=6)
		{
			echo '<table width="100%" border="0" align="center">
			<tr align="left" style="height:20px;">
			  <td><font color="#FF0000" size="2">No es posible registrar novedades en este momento</font></td>
			</tr>
			</table>';
		}
		else
		{
			echo '<script>window.open("CrearCuadroNovedades.php?grupoEmpleado='.$grupoEmpleado.'&sede='.$sede.'&mes='.$mes.'&anio='.$anio.'")</script>';
        }
	}
	elseif($anio==$anioActual && $mes>$mesActual)
	{
		echo '<script>window.open("CrearCuadroNovedades.php?grupoEmpleado='.$grupoEmpleado.'&sede='.$sede.'&mes='.$mes.'&anio='.$anio.'")</script>';
    }
	elseif($anio==$anioActual && $mes<$mesActual)
	{
		//calcular la cantidad de dias que hay entre la ultima fecha del mes anterior y la fecha actual
		function getMonthDays($Month, $Year)
		{
		   if( is_callable("cal_days_in_month"))
		   {
			  return cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
		   }
		   else
		   {
			  return date("d",mktime(0,0,0,$Month+1,0,$Year));
		   }
		}
		//Obtenemos la cantidad de días
		$dias = getMonthDays($mes, $anio);
		//calcular la cantidad de dias que hay entre las fechas
		$fechaOld = $anio.'-'.$mes.'-'.$dias;
		$fechaAct = $anioActual.'-'.$mesActual.'-'.$diaActual;
		function dateDiff($start, $end) 
		{ 
			$start_ts = strtotime($start); 
			$end_ts = strtotime($end); 
			$diff = $end_ts - $start_ts; 
			return round($diff / 86400);
		}
		$difDias = dateDiff($fechaOld, $fechaAct);
		
		if($difDias>=6)
		{
			echo '<table width="100%" border="0" align="center">
			<tr align="left" style="height:20px;">
			  <td><font color="#FF0000" size="2">No es posible registrar novedades en este momento</font></td>
			</tr>
			</table>';
		}
		else
		{
			echo '<script>window.open("CrearCuadroNovedades.php?grupoEmpleado='.$grupoEmpleado.'&sede='.$sede.'&mes='.$mes.'&anio='.$anio.'")</script>';
        }
	}
	}
}
?>