<?php
ini_set('max_execution_time', 0);
require_once("../../dbconexion/conexion.php");
$cn = conectarse();
//declaracion de variables
$fechaDesde = base64_decode($_GET['FchDesde']);
$fechaHasta = base64_decode($_GET['FchHasta']);
$sede = base64_decode($_GET['sede']);
$descSede = base64_decode($_GET['descSede']);
//consultar devoluciones por parte del especialista
$consDevolucionEspecialista = mysql_query("SELECT LEFT((fecha),10) AS fecha, RIGHT((fecha),8) AS hora, ed.comentario, ed.id_informe,
CONCAT(f.nombres,' ', f.apellidos) AS especialista, md.desc_motivo FROM r_estudiodevuelto ed
INNER JOIN funcionario f ON f.idfuncionario = ed.usuario
INNER JOIN r_motivodevolucion md ON md.idmotivo = ed.idmotivo WHERE fecha BETWEEN '$fechaDesde' AND '$fechaHasta'
ORDER BY ed.id_informe", $cn);
//lineas para exportar a excel
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=DevueltosPorEspecialista".$fechaDesde.'-'.$fechaHasta.'-'.$descSede.".xls");
?>
<style type="text/css">
table
{
	font-family:Arial, Helvetica, sans-serif; 
	font-size:12px;
	width:100%;
}
</style>
<!-- imprimir los registros dentro de una tabla -->
<table width="100%" border="1" rules="all">
  <tr bgcolor="#6699FF" align="center">
  	<td width="5%">Id</td>
    <td width="5%">Id paciente</td>
    <td width="10%">Paciente</td>
    <td width="10%">Estudio</td>
    <td width="5%">Tecnica</td>
    <td width="10%">Sede</td>
    <td width="10%">Especialista</td>
    <td width="5%">Fecha</td>
    <td width="5%">Hora</td>
    <td width="5%">Causa de devolucion</td>
    <td width="30%">Comentario</td>
  </tr>
<?php
while($rowDevolucionEspecialista = mysql_fetch_array($consDevolucionEspecialista))
{
	$idInforme = $rowDevolucionEspecialista['id_informe'];
	//obtener datos complementarios del estudio
	$consDetalles = mysql_query("SELECT CONCAT(p.nom1,' ',p.nom2,' ',p.ape1,' ',p.ape2) AS paciente, i.id_paciente, i.idsede,
	pri.desc_prioridad, se.descsede, ser.descservicio, est.nom_estudio, tec.desc_tecnica FROM r_informe_header i
	INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
	INNER JOIN r_prioridad pri ON pri.id_prioridad = i.id_prioridad
	INNER JOIN sede se ON se.idsede = i.idsede
	INNER JOIN servicio ser ON ser.idservicio = i.idservicio
	INNER JOIN r_estudio est ON est.idestudio = i.idestudio
	INNER JOIN r_tecnica tec ON tec.id_tecnica = i.id_tecnica
	WHERE i.id_informe = '$idInforme'", $cn);
	$RegsDetalles = mysql_fetch_array($consDetalles);
	//condicionar para que se impriman los registros correspondientes a una sede
	if($RegsDetalles['idsede'] == $sede)
	{
		echo
		'<tr>
			<td>'.$rowDevolucionEspecialista['id_informe'].'</td>
			<td>'.$RegsDetalles['id_paciente'].'</td>
			<td>'.ucwords(mb_strtolower($RegsDetalles['paciente'])).'</td>
			<td>'.ucwords(mb_strtolower($RegsDetalles['nom_estudio'])).'</td>
			<td>'.ucwords(mb_strtolower($RegsDetalles['desc_tecnica'])).'</td>
			<td>'.$RegsDetalles['descsede'].'</td>
			<td>'.ucwords(mb_strtolower($rowDevolucionEspecialista['especialista'])).'</td>
			<td align="center">'.$rowDevolucionEspecialista['fecha'].'</td>
			<td align="center">'.$rowDevolucionEspecialista['hora'].'</td>
			<td align="center">'.ucwords(mb_strtolower($rowDevolucionEspecialista['desc_motivo'])).'</td>
			<td>'.ucfirst(mb_strtolower($rowDevolucionEspecialista['comentario'])).'</td>	
		</tr>';
	}
}
?>
</table>