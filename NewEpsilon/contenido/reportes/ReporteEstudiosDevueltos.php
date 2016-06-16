<?php
ini_set('max_execution_time', 0);
require_once("../../dbconexion/conexion.php");
$cn = conectarse();
//declaracion de variables
$fechaDesde = base64_decode($_GET['FchDesde']);
$fechaHasta = base64_decode($_GET['FchHasta']);
//consultar la cantidad de informes que han sido devueltos
$conDevueltos = mysql_query("SELECT DISTINCT(id_informe) FROM
(
	SELECT DISTINCT(id_informe) FROM r_observacion_informe
	WHERE id_tipocomentario = '6' AND fecha BETWEEN '$fechaDesde' AND '$fechaHasta'
	UNION ALL
	SELECT DISTINCT(id_informe)
	FROM r_estudiodevuelto WHERE fecha BETWEEN '$fechaDesde' AND '$fechaHasta'
)
t
GROUP BY id_informe HAVING COUNT(id_informe) = 1", $cn);
//lineas para exportar a excel
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Devueltos".$fechaDesde.'/'.$fechaHasta.".xls");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Reporte de Informes Devueltos :.</title>
<style type="text/css">
	body{font-family:Tahoma, Geneva, sans-serif; font-size:12px;
	}
</style>
<table width="98%" border="1" align="center" rules="all">
<?php
while($rowDevueltos = mysql_fetch_array($conDevueltos))
{
	echo 
	'
	<tr bgcolor="#0033FF" style="color:#FFF" align="center">
		<td width="10%">Id</td>
		<td width="15%">Paciente</td>
		<td width="20%">Estudio</td>
		<td width="10%">Tecnica</td>
		<td width="10%">Sede</td>
		<td width="10%">Servicio</td>
		<td width="10%">Tipo de paciente</td>
		<td width="5%">Extremidad</td>
		<td width="10%">Estado del informe</td>
	</tr>
	';
	$idDevueltos = $rowDevueltos['id_informe'];
	//consultar los datos del informe para el encabezado
	$consDetalles = mysql_query("SELECT i.id_paciente, CONCAT(p.nom1,' ',p.nom2,' ',p.ape1,' ',p.ape2) AS paciente, e.nom_estudio, est.desc_estado,
	ext.desc_extremidad, se.descsede, ser.descservicio, tec.desc_tecnica, ti.desctipo_paciente FROM r_informe_header i
	INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
	INNER JOIN r_estudio e ON e.idestudio = i.idestudio
	INNER JOIN r_estadoinforme est ON est.id_estadoinforme = i.id_estadoinforme
	INNER JOIN r_extremidad ext ON ext.id_extremidad = ext.id_extremidad
	INNER JOIN sede se ON se.idsede = i.idsede
	INNER JOIN servicio ser ON ser.idservicio = i.idservicio
	INNER JOIN r_tecnica tec ON tec.id_tecnica = i.id_tecnica
	INNER JOIN r_tipo_paciente ti ON ti.idtipo_paciente = i.idtipo_paciente WHERE i.id_informe = '$idDevueltos'", $cn);
	$RegsDetalles = mysql_fetch_array($consDetalles);
	//imprimir encabezado del estudio
	echo
	'<tr bgcolor="#CCCCCC">
    <td>'.$RegsDetalles['id_paciente'].'</td>
    <td>'.ucwords(mb_strtolower($RegsDetalles['paciente'])).'</td>
   	<td>'.ucwords(mb_strtolower($RegsDetalles['nom_estudio'])).'</td>
    <td>'.ucwords(mb_strtolower($RegsDetalles['desc_tecnica'])).'</td>
    <td>'.ucwords(mb_strtolower($RegsDetalles['descsede'])).'</td>
    <td>'.ucwords(mb_strtolower($RegsDetalles['descservicio'])).'</td>
    <td>'.ucwords(mb_strtolower($RegsDetalles['desctipo_paciente'])).'</td>
    <td>'.$RegsDetalles['desc_extremidad'].'</td>
    <td>'.ucwords(mb_strtolower($RegsDetalles['desc_estado'])).'</td>
	</tr>';
	//consultar observaciones por devolucion administrativa
	$consDevolucionAdmin = mysql_query("SELECT o.idfuncionario, o.observacion, o.fecha, o.hora, CONCAT(f.nombres,' ',f.apellidos) AS funcionario,
	ti.desc_comentario FROM r_observacion_informe o
	INNER JOIN funcionario f ON f.idfuncionario = o.idfuncionario
	INNER JOIN r_tipo_comentario ti ON ti.id_tipocomentario = o.id_tipocomentario
	WHERE o.id_tipocomentario = '6' AND o.id_informe = '$idDevueltos'", $cn);
	$contDevolucionAdmin = mysql_num_rows($consDevolucionAdmin);
	echo
	'<tr>
    <td colspan="9">
		<table width="100%" border="1" rules="all">
			<tr align="center" bgcolor="#00CCFF">
				<td width="18%">Funcionario</td>
				<td width="7%">Fecha</td>
				<td width="5%">Hora</td>
				<td width="10%">Clasificacion</td>
				<td width="60%">Observacion</td>
			</tr>';
			//validar si existen comentarios administrativos
			if($contDevolucionAdmin>=1)
			{
				//ciclo para imprimir todas las devoluciones administrativas
				while($rowDevolucionAdmin = mysql_fetch_array($consDevolucionAdmin))
				{
					echo
					'<tr>
						<td>'.ucwords(mb_strtolower($rowDevolucionAdmin['funcionario'])).'</td>
						<td align="center">'.$rowDevolucionAdmin['fecha'].'</td>
						<td align="center">'.$rowDevolucionAdmin['hora'].'</td>
						<td align="center">'.$rowDevolucionAdmin['desc_comentario'].'</td>
						<td>'.ucfirst(mb_strtolower($rowDevolucionAdmin['observacion'])).'</td>
					</tr>';
				}
			}
			//consultar devoluciones por parte del especialista
			$consDevolucionEspecialista = mysql_query("SELECT LEFT((fecha),10) AS fecha, RIGHT((fecha),8) AS hora, ed.comentario, CONCAT(f.nombres,' ', f.apellidos) AS especialista, md.desc_motivo
			FROM r_estudiodevuelto ed
			INNER JOIN funcionario f ON f.idfuncionario = ed.usuario
			INNER JOIN r_motivodevolucion md ON md.idmotivo = ed.idmotivo WHERE ed.id_informe = '$idDevueltos'", $cn);
			$contDevolucionEspecialista = mysql_num_rows($consDevolucionEspecialista);
			//validar si existen comentarios del especialista
			if($contDevolucionEspecialista>=1)
			{
				while($rowDevolucionEspecialista = mysql_fetch_array($consDevolucionEspecialista))
				{
					echo
					'<tr>
						<td>'.ucwords(mb_strtolower($rowDevolucionEspecialista['especialista'])).'</td>
						<td align="center">'.$rowDevolucionEspecialista['fecha'].'</td>
						<td align="center">'.$rowDevolucionEspecialista['hora'].'</td>
						<td align="center">'.ucwords(mb_strtolower($rowDevolucionEspecialista['desc_motivo'])).'</td>
						<td>'.ucfirst(mb_strtolower($rowDevolucionEspecialista['comentario'])).'</td>
					</tr>';	
				}
			}
		echo'
		</table>
	</td>
	</tr>';
}
?>
</table>
</body>
</html>