<?php
	//Sesion del usuario
	
	//conexion a la base de datos
	include('../../../dbconexion/conexion.php');
	$cn = Conectarse();
	//declaracion de variables
	$idTurno = $_POST[idturno];
	$funcionario = $_POST[funcionario];
	$convencion = strtoupper($_POST[convencion]);
	$tipo = $_POST[tipo];
	$grupoEmpleado = $_POST[grupoEmpleado];
	$sede = $_POST[sede];
	$anio = $_POST[anio]; $mes = $_POST[mes]; $dia = $_POST[d];
	$servicio = $_POST[servicio];
	// ------------------ Variables de referencia para el calculo de las horas -------------------------------- //
	$inicio_nocturnas = "22:00";
	$inicio_diurnas = "06:00";
	$cambio_dia = "00:00";
	$ref_nocturna = strtotime($inicio_nocturnas);
	$ref_diurna = strtotime($inicio_diurnas);
	$ref_cambio = strtotime($cambio_dia);
	// ------------------------------------------------------------------------------------------------------- //
	if($mes<=9)
	{$mes = '0'.$mes;}
	if($dia<=9)
	{$dia = '0'.$dia;}
	$fecha = ($anio.'-'.$mes.'-'.$dia);
	//desglosar fecha para obtener la cantidad de dias que tiene el mes
	$dias = date('t', mktime(0,0,0, $mes, 1, $anio));
	//dia finalizacion del mes
	$fecha_limite = $anio.'-'.$mes.'-'.$dias;
	//validar que los campos requeridos se diligencien
	if($funcionario=="" || $fecha=="" || $convencion=="" || $grupoEmpleado=="" || $tipo=="" || $sede=="" || $servicio=="")
	{
		//echo 'No se ha registrado ningun turno';
	}
	else
	{
		//Validar que la convension registrada sea valida para el usuario
		$sqlConvencion = mysql_query("SELECT * FROM convencion_cuadro WHERE idgrupo_empleado = '$grupoEmpleado' AND alias = '$convencion' AND idservicio = '$servicio' AND idestado_Actividad = 1", $cn);
		$conConvencion = mysql_num_rows($sqlConvencion);
		$RegConvencion = mysql_fetch_array($sqlConvencion);
		$idConvencion = $RegConvencion[id];
				
		if($conConvencion>=1)
		{
			//validar si el funcionario tiene un turno registrado en otra sede en la misma fecha
			$sqlTurno = mysql_query("SELECT * FROM turno_funcionario WHERE idfuncionario = '$funcionario' AND fecha = '$fecha'", $cn);
			$conTurno = mysql_num_rows($sqlTurno);
			//eliminar turno anterior y registrar uno nuevo
			mysql_query("DELETE FROM turno_funcionario WHERE idturno='$idturno'", $cn);
			mysql_query("DELETE FROM novedad_turno WHERE idturno='$idturno'", $cn);
			//notificar si hay un turno registrado en esa fecha
			if($conTurno>=1)
			{
				//echo 'Ya se ha registrado un turno para esa fecha';	
			}
			else
			{
				//registrar el turno a partir de la validacion del tipo de dia de inicio
				if($tipo==1)
				{
					//inicio de turno en un dia ordinario
					//validar el horario del turno registrado en la convencion
					$sqlHora = mysql_query("SELECT hr_inicio, hr_fin FROM convencion_cuadro WHERE alias = '$convencion' AND idgrupo_empleado = '$grupoEmpleado'", $cn);
					$regHora = mysql_fetch_array($sqlHora);
					$hora_ini = $regHora[hr_inicio];
					$hora_fin = $regHora[hr_fin];
					//determinar si el horario corresponde a un turno en un mismo dia o en dias diferentes.
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
					//inicio de turno en dia festivo o domingo
					//validar el horario del turno registrado en la convencion
					$sqlHora = mysql_query("SELECT hr_inicio, hr_fin FROM convencion_cuadro WHERE alias = '$convencion' AND idgrupo_empleado = '$grupoEmpleado'", $cn);
					$regHora = mysql_fetch_array($sqlHora);
					$hora_ini = $regHora[hr_inicio];
					$hora_fin = $regHora[hr_fin];
					// ------------------------------ convertir variables para hacer operaciones -------------------------------------- //
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
		}
		else
		{
			//echo 'Los datos ingresados no son validos';
			echo '<div class="error message">Los datos que intenta registrar no son validos.</div>';
		}
	}
?>