<?php
require_once("../../../../dbconexion/conexion.php");
$cn = conectarse();
$idpaciente=$_POST['idpaciente'];
$sede=$_POST['idsede'];
$servicio=$_POST['servicio'];
$fecha=$_POST['fecha'];
$tecnica=$_POST['tecnica'];
list ($dia,$mes,$ano)=explode('/',$fecha);
$fecha = $ano.'-'.$mes.'-'.$dia;
$hora = $_POST['hora'];
$sqlconsulta = mysql_query("SELECT l.fecha, l.id_informe,l.id_estadoinforme,i.id_paciente,i.id_tecnica FROM r_log_informe l
INNER JOIN r_informe_header i ON i.id_informe=l.id_informe
where l.id_estadoinforme=1 and id_paciente='$idpaciente' and id_tecnica=3 OR l.id_estadoinforme=1 and id_paciente='$idpaciente' and id_tecnica=6 ORDER BY fecha desc limit 1", $cn);
$regservicio = mysql_fetch_array($sqlconsulta);
$dias = (strtotime($regservicio['fecha'])-strtotime($fecha))/86400;
$dias = abs($dias);
$dias = floor($dias);
if ($dias <= 3 )
{
echo '<font size="2" color="#FF0000">Este Paciente solicitado ya se le realizó un estudio contrastado antes de las 72 horas, Por favor informarle a el medico y el paciente por motivos de seguridad.</font>';
}
