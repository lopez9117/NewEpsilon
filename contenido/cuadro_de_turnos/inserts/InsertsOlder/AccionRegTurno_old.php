<?php
session_start();
$CurrentUser = $_SESSION['currentuser'];
//conexion a la base de datos
include('../../../dbconexion/conexion.php');
$cn = Conectarse();
//declaracion de variables
$funcionario = $_POST['funcionario'];
$idConvencion = $_POST['convencion'];
$tipo = $_POST['tipo'];
$grupoEmpleado = $_POST['grupoEmpleado'];
$sede = $_POST['sede'];
$fecha = $_POST['fecha'];
$hora_ini = $_POST['inicio'];
$hora_fin = $_POST['fin'];
$servicio = $_POST['servicio'];
list($anio, $mes, $dia) = explode("-",$fecha);
$anio; $mes; $dia;
// ------------------ Variables de referencia para el calculo de las horas -------------------------------- //
$inicio_nocturnas = "22:00";
$inicio_diurnas = "06:00";
$cambio_dia = "00:00";
$ref_nocturna = strtotime($inicio_nocturnas);
$ref_diurna = strtotime($inicio_diurnas);
$ref_cambio = strtotime($cambio_dia);
// ------------------------------------------------------------------------------------------------------- //
//desglosar fecha para obtener la cantidad de dias que tiene el mes
$dias = date('t', mktime(0,0,0, $mes, 1, $anio));
//dia finalizacion del mes
$fecha_limite = $anio.'-'.$mes.'-'.$dias;
//validar si el funcionario tiene un turno registrado en otra sede en la misma fecha
$sqlTurno = mysql_query("SELECT * FROM turno_funcionario WHERE idfuncionario = '$funcionario' AND fecha = '$fecha' AND hr_inicio = '$hora_ini' AND hr_fin = '$hora_fin'", $cn);
$conTurno = mysql_num_rows($sqlTurno);
//notificar si hay un turno registrado en esa fecha
if($conTurno>=1)
{
	echo 'Ya se ha registrado un turno para esa fecha';
}
else
{
	if($tipo==1)
	{
		if($hora_ini < $hora_fin)
		{
			// ------------------------------ convertir variables para hacer operaciones ------------------------------- //
			$ini = strtotime($hora_ini);
			$fin = strtotime($hora_fin);
			include("OrdinarioIgual.php");
		}
		else
		{
			//validar el tipo de dia en el que termina el turno
			$nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
			$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
			//desglosar fecha para obtener el dia de la semana al que corresponde
			list($anio1, $mes1, $dia1) = explode("-",$nuevafecha);
			//funcion para conocer a que dia de la semana corresponde la fecha generada
			$wkdy = (((mktime ( 0, 0, 0, $mes1, $dia1, $anio1) - mktime ( 0, 0, 0, 7, 17, 2006))/(60*60*24))+700000) % 7;
			if($wkdy == 6)
			{
				// ------------------------------ convertir variables para hacer operaciones ------------------------------ //
				$ini = strtotime($hora_ini);
				$fin = strtotime($hora_fin);
				include('OrdinarioFestivo.php');
			}
			else
			{
				//Validar el tipo de dia de finalizacion
				$sqlFecha = mysql_query("SELECT * FROM dia_festivo WHERE fecha_festivo = '$nuevafecha'", $cn);
				$conFecha = mysql_num_rows($sqlFecha);	
				if($conFecha==0 || $conFecha == "")
				{	
					// ------------------------------ convertir variables para hacer operaciones --------------------------- //
					$ini = strtotime($hora_ini);
					$fin = strtotime($hora_fin);
					include("OrdinarioOrdinario.php");
				}
				else
				{
					// ------------------------------ convertir variables para hacer operaciones -------------------------- //
					$ini = strtotime($hora_ini);
					$fin = strtotime($hora_fin);
					include('OrdinarioFestivo.php');	
				}
			}
		}
	}
	else
	{
		$ini = strtotime($hora_ini);
		$fin = strtotime($hora_fin);
		//determinar si el horario corresponde a un turno en un mismo dia o en dias diferentes.
		if($hora_ini < $hora_fin)
		{
			// ------------------------------ convertir variables para hacer operaciones --------------------------------- //
			$ini = strtotime($hora_ini);
			$fin = strtotime($hora_fin);
			include("FestivoIgual.php");
		}
		else
		{
			//validar el tipo de dia en el que termina el turno
			$nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
			$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
			//Validar el tipo de dia de finalizacion
			$sqlFecha = mysql_query("SELECT * FROM dia_festivo WHERE fecha_festivo = '$nuevafecha'", $cn);
			$conFecha = mysql_num_rows($sqlFecha);
			list($anio1, $mes1, $dia1) = explode("-",$nuevafecha);
			//funcion para conocer a que dia de la semana corresponde la fecha generada
			$wkdy = (((mktime ( 0, 0, 0, $mes1, $dia1, $anio1) - mktime ( 0, 0, 0, 7, 17, 2006))/(60*60*24))+700000) % 7;
			if($wkdy == 6)
			{
				// ------------------------------ convertir variables para hacer operaciones ----------------------------------- //
				$ini = strtotime($hora_ini);
				$fin = strtotime($hora_fin);
				include("FestivoFestivo.php");
			}
			else
			{
				//Validar el tipo de dia de finalizacion
				$sqlFecha = mysql_query("SELECT * FROM dia_festivo WHERE fecha_festivo = '$nuevafecha'", $cn);
				$conFecha = mysql_num_rows($sqlFecha);
				if($conFecha==0 || $conFecha == "")
				{
					// ------------------------------ convertir variables para hacer operaciones -------------------------------- //
					$ini = strtotime($hora_ini);
					$fin = strtotime($hora_fin);
					include('FestivoOrdinario.php');	
				}
				else
				{
					// ------------------------------ convertir variables para hacer operaciones -------------------------------- //
					$ini = strtotime($hora_ini);
					$fin = strtotime($hora_fin);
					include("FestivoFestivo.php");	
				}
			}
		}
	}
}
?>