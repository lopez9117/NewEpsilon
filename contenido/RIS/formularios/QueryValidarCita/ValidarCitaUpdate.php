<?php
require_once("../../../../dbconexion/conexion.php");
$cn = conectarse();
$idpaciente=$_POST['paciente'];
$sede=$_POST['sede'];
$servicio=$_POST['servicio'];
$fechacita=$_POST['fechacita'];
list ($mes,$dia,$ano)=explode('/',$fecha);
$fecha=$ano.'-'.$mes.'-'.$dia;
$horacita=$_POST['horacita'];
if ($idpaciente == "" || $sede == "" || $servicio == "" || $fechacita == "" || $horacita == "")
{
	echo '<font size="2" color="#FF0000">Los campos señalados con * son obligatorios</font>';
}
else
{
	$sqlvalidacionhoraservicio = mysql_query("SELECT DISTINCT(l.id_informe) FROM r_log_informe l
	INNER JOIN r_informe_header i ON i.id_informe=l.id_informe
	where l.id_estadoinforme=1 AND idsede='$sede' AND fecha='$fechacita' AND idservicio='$servicio' AND hora='$horacita' AND id_paciente!='$idpaciente'", $cn);
	$contadorhoraservicio=mysql_num_rows($sqlvalidacionhoraservicio);
	if ($contadorhoraservicio>=1)
	{
	echo '<font size="2" color="#FF0000">Este horario ya ha sido asignado dentro de la agenda</font>';
	}
	else
	{
	$sqlvalidacionhorapaciente = mysql_query("SELECT DISTINCT(l.id_informe) FROM r_log_informe l
	INNER JOIN r_informe_header i ON i.id_informe=l.id_informe
	where l.id_estadoinforme=1 AND idsede='$sede' AND fecha='$fecha' AND id_paciente='$idpaciente' AND hora='$hora' AND idservicio!='$servicio'", $cn);
	$contadorhorapaciente=mysql_num_rows($sqlvalidacionhorapaciente);
		if ($contadorhorapaciente>=1)
		{
			echo '<font size="2" color="#FF0000">Este Paciente ya se ha asignado a esta hora dentro de otro servicio</font>';
		}
		else
		{
			?>
			<input type="button" name="modificar" id="modificar" value="Modificar" onClick="ValidarModificacion('Modificar')">
		<?php 
		}
	}
}
?>