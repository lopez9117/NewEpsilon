<?php
session_start();
$CurrentUser = $_SESSION['currentuser'];
//conexion a la base de datos
include('../../../dbconexion/conexion.php');
$cn = Conectarse();
//declaracion de variables
$funcionario = $_POST['funcionario']; $idConvencion = $_POST['convencion']; $tipo = $_POST['tipo']; $grupoEmpleado = $_POST['grupoEmpleado']; 
$sede = $_POST['sede']; $fecha = $_POST['fecha']; $inicio = $_POST['inicio']; $fin = $_POST['fin']; $servicio = $_POST['servicio'];
//desglozar la fecha para obtener valores dd/mm/aaaa independientes
list($anio, $mes, $dia) = explode("-",$fecha);
$anio; $mes; $dia;
//variables de referencia
$InicioDiurnas = '06:00';
$InicioNocturnas = '22:00';
$CambioDia = '00:00';
//validar si el funcionario tiene un turno registrado en otra sede en la misma fecha
$sqlTurno = mysql_query("SELECT * FROM turno_funcionario WHERE idfuncionario = '$funcionario' AND fecha = '$fecha' AND hr_inicio = '$hora_ini' AND hr_fin = '$hora_fin'", $cn);
$conTurno = mysql_num_rows($sqlTurno);
//notificar si hay un turno registrado en esa fecha
if($conTurno>=1)
{
	echo '<font color="#FF0000">Ya se ha registrado un turno</font>';
}
else
{
	//calcular horario cuando todas las horas son diurnas
	if($inicio>=$InicioDiurnas && $fin<=$InicioNocturnas && $fin>$InicioDiurnas && $fin>$inicio)
	{
		include("ClassCalcularDiurnasNocturnas.php");
		//Realizar insersion a partir del tipo de dia
		if($tipo==1)
		{
			echo 'El total de horas dirunas Ordinarias es: '.$contHoras;
		}
		elseif($tipo==2)
		{
			echo 'El total de horas dirunas Festivas es: '.$contHoras;
		}
	}
	elseif($inicio>=$InicioNocturnas && $fin==$CambioDia || $inicio>=$CambioDia && $fin<=$InicioDiurnas || $inicio>=$InicioNocturnas && $fin<=$InicioDiurnas)
	{
		include("ClassCalcularDiurnasNocturnas.php");
		//Realizar insersion a partir del tipo de dia
		if($tipo==1)
		{
			echo 'El total de horas dirunas Ordinarias es: '.$contHoras;
		}
		elseif($tipo==2)
		{
			echo 'El total de horas dirunas Festivas es: '.$contHoras;
		}
	}
	else
	{
		echo 'otros calculos';
	}
}
?>