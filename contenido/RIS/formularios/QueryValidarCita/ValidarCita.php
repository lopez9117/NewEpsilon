<?php
require_once("../../../../dbconexion/conexion.php");
		$cn = conectarse();
$idpaciente = $_POST['idpaciente'];
$sede = $_POST['idsede'];
$servicio = $_POST['servicio'];
$fecha = $_POST['fecha'];
list ($dia,$mes,$ano)=explode('/',$fecha);
$fechaCita = $ano.'-'.$mes.'-'.$dia;
$hora = $_POST['hora'];
if ($idpaciente == "" || $sede == "" || $servicio == "" || $fechaCita == "" || $hora == "_:_")
{
echo '<font size="2" color="#FF0000">Por favor llenar los campos con asterisco para poder validar la cita de la agenda</font>';
}
else
{
$sqlvalidacionhoraservicio = mysql_query("SELECT DISTINCT(l.id_informe) FROM r_log_informe l
INNER JOIN r_informe_header i ON i.id_informe=l.id_informe
where l.id_estadoinforme=1 AND idsede='$sede' AND fecha='$fechaCita' AND idservicio='$servicio' AND hora='$hora' AND id_paciente!='$idpaciente'", $cn);
$contadorhoraservicio=mysql_num_rows($sqlvalidacionhoraservicio);

if ($contadorhoraservicio>=1)
{
echo '<font size="2" color="#FF0000">Este horario ya ha sido asignado dentro de la agenda</font>';
}
else
{
$sqlvalidacionhorapaciente = mysql_query("SELECT DISTINCT(l.id_informe) FROM r_log_informe l
INNER JOIN r_informe_header i ON i.id_informe=l.id_informe
where l.id_estadoinforme=1 AND idsede='$sede' AND fecha='$fechaCita' AND id_paciente='$idpaciente' AND hora='$hora' AND idservicio!='$servicio'", $cn);
$contadorhorapaciente=mysql_num_rows($sqlvalidacionhorapaciente);
	if ($contadorhorapaciente>=1)
	{
		echo '<font size="2" color="#FF0000">Este Paciente ya se ha asignado a esta hora dentro de otro servicio</font>';
	}
	else
	{
		echo '<td colspan="2"><input type="button" name="guardar" id="guardar" value="Guardar" onclick="ValidarAgenda()"/></td>';
		echo '<td>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</td>';
		echo '<td><input type="button" value="Agregar Estudio" name="agregar" id="agregar" onClick="AgregarEstudios()" /></td>';
	}
	}
}
?>