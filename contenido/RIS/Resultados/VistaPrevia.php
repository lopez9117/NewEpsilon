<?php
require_once("../../../dbconexion/conexion.php");
$cn = conectarse();
//variables GET
$idInforme = base64_decode($_GET['informe']);
//obtener los datos del encabezado para el informe
$sqlHeader = mysql_query("SELECT i.id_informe,ser.idservicio, i.idsede, i.ubicacion, i.id_paciente, i.idestudio,
i.portatil, i.desc_extremidad, p.nom1, p.nom2,p.ape1, p.ape2, p.edad,
e.nom_estudio, f.idfuncionario, f.nombres, f.apellidos,
sex.desc_sexo, eps.desc_eps,l.fecha, l.hora, t.desc_tecnica, s.url_logo,
d.detalle_informe, d.adicional, esp.url_firma, tec.desc_tecnica, ext.desc_extremidad AS lado FROM r_informe_header i
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio e ON e.idestudio = i.idestudio
INNER JOIN funcionario f ON f.idfuncionario = i.idfuncionario_esp
INNER JOIN r_sexo sex ON sex.id_sexo = p.id_sexo
INNER JOIN eps eps ON eps.ideps = p.ideps
INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
INNER JOIN r_tecnica t ON t.id_tecnica = i.id_tecnica
INNER JOIN sede s ON s.idsede = i.idsede
INNER JOIN r_detalle_informe d ON d.id_informe = i.id_informe
INNER JOIN r_especialista esp ON esp.idfuncionario_esp = i.idfuncionario_esp
INNER JOIN r_tecnica tec ON tec.id_tecnica = i.id_tecnica
INNER JOIN r_extremidad ext ON ext.id_extremidad = i.id_extremidad
INNER JOIN servicio ser ON ser.idservicio=i.idservicio
WHERE i.id_informe = '$idInforme' AND l.id_estadoinforme = '8' AND i.id_estadoinforme = '8'", $cn);
$regHeader = mysql_fetch_array($sqlHeader);
$especialista = $regHeader['idfuncionario'];
// informacion del especialista
$sqlEspecialista = mysql_query("SELECT e.reg_medico, e.url_firma, f.nombres, f.apellidos, u.nom_universidad,esp.nom_especialidad FROM r_especialista e
INNER JOIN funcionario f ON f.idfuncionario = e.idfuncionario_esp
INNER JOIN r_universidad u ON u.iduniversidad = e.iduniversidad
INNER JOIN r_especialidad esp ON esp.id_especialidad = e.id_especialidad
WHERE e.idfuncionario_esp = '$especialista'", $cn);
$regEspecialista = mysql_fetch_array($sqlEspecialista);
//consultar la fecha de toma del estudio
$sqlEstudio = mysql_query("SELECT fecha FROM r_log_informe WHERE id_informe = '$idInforme' AND id_estadoinforme = '1'", $cn);
$regEstudio = mysql_fetch_array($sqlEstudio);
//consulta para preguntar si tiene firma de respaldo o no?
$sqlfirma = mysql_query("SELECT fr.id_informe, f.nombres, f.apellidos, esp.url_firma, esp.reg_medico,ep.nom_especialidad,u.nom_universidad FROM r_firma_respaldo fr
INNER JOIN funcionario f ON f.idfuncionario = fr.idfuncionario_esp
INNER JOIN r_informe_header i ON i.id_informe=fr.id_informe
INNER JOIN r_especialista esp ON esp.idfuncionario_esp = fr.idfuncionario_esp
INNER JOIN r_especialidad ep ON ep.id_especialidad=esp.id_especialidad
INNER JOIN r_universidad u ON u.iduniversidad=esp.iduniversidad
WHERE i.id_informe = '$idInforme'", $cn);
$regfirma = mysql_fetch_array($sqlfirma);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
<title>.: Vista Previa :.</title>
<style type="text/css">
body
{font-family:Arial, Helvetica, sans-serif;
font-size:12px;
}
fieldset
{width:auto;
border-color:#FFF;
border:hidden;
position:relative;}
.table
{width:98%;
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
}
textarea
{
font-family:Verdana, Geneva, sans-serif;
font-size:12px;
width:100%;
height:55px;
resize:none;
}
.fondo
{background-color:#CCC;
}
.img
{
	width:190px; 
	height:130px;
	border:none;
}
p
{
	line-height: 0.40cm
}
</style>
</head>
<body>
<table align="center" class="table">
<tr>
<td width="30%" align="center"><img class="img" src="../images/<?php echo $regHeader['url_logo']?>"/></td>
<td width="70%">
	  <table width="100%" border="1" rules="all">
		  <tr class="fondo">
			<td colspan="2"><strong>Paciente: </strong><?php echo $regHeader['nom1'].'&nbsp;'.$regHeader['nom2'].'&nbsp;'.$regHeader['ape1'].'&nbsp;'.$regHeader['ape2'] ?></td>
		</tr>
		  <tr>
			  <td width="50%"><strong>Documento: </strong>: <?php echo $regHeader['id_paciente']?></td>
			  <td width="50%"><strong>Sexo: </strong>: <?php echo $regHeader['desc_sexo']?></td>
		  </tr>
	  <tr class="fondo">
			  <td width="50%"><strong>Edad: </strong><?php echo $regHeader['edad']?>(S)</td>
			  <td width="50%"><strong>Fecha: </strong><?php echo $regEstudio['fecha']?></td>
		</tr>
		  <tr>
			  <td colspan="2"><strong>Estudio: </strong><?php echo $regHeader['nom_estudio']?><?php if($regHeader['portatil'] == 1){ echo ' - <strong>PORTATIL</strong>'; }?></td>
		</tr>
		  <tr class="fondo">
			<td><strong>Tecnica: </strong><?php echo $regHeader['desc_tecnica']?></td>
			<td><strong>Lado: </strong><?php echo $regHeader['lado']?></td>
		  </tr>
		  <tr >
		    <td><strong>Extremidad:</strong><?php echo $regHeader['desc_extremidad']?></td>
            <td>&nbsp;</td>
	    </tr>
		  <tr class="fondo">
			<td colspan="2"><strong>EPS / Aseguradora: </strong><?php echo $regHeader['desc_eps']?></td>
		  </tr>
	  <tr>
			  <td colspan="2"><strong>Adicional: </strong><?php echo $regHeader['adicional'] ?></td>
		</tr>
	  </table>
</td>
</tr>
</table>
<table align="center" class="table">
<tr>
  <td colspan="2"><?php echo $string = ereg_replace( ("<p>&nbsp;</p>"), "", $regHeader['detalle_informe'] ); ?></td>
</tr>
<tr>
  <td colspan="2"></td>
</tr>
<tr align="">
  <td><img src="../images/<?php echo $regEspecialista['url_firma']?>" width="115" height="91" /></td>
  <td align="right"><?php
 if ($regfirma['id_informe']!="")
{
 echo '<img src="../images/'.$regfirma['url_firma'].'" width="115" height="91"';
}
 'alt="firmarespaldo"/>'; ?></td>
</tr>
<tr>
	<td width="50%" >Dr(a). <?php echo $regEspecialista['nombres'].'&nbsp;'.$regEspecialista['apellidos']?>. </br>
	  <?php echo $regEspecialista['nom_especialidad']?>.</br>
  Reg. Medico: <?php echo $regEspecialista['reg_medico']?>.</br>
   <?php echo $regEspecialista['nom_universidad'] ?></td>
	<td width="50%" align="right"><?php
if ($regfirma['id_informe']!="")
{
echo 'Dr(a). '.$regfirma['nombres'].'&nbsp;'.$regfirma['apellidos'].'.</br>';
}
?>
	  <?php 
if ($regfirma['id_informe']!="")
{
echo $regfirma['nom_especialidad'].'.</br>';
echo 'Reg. Medico: '. $regfirma['reg_medico'].'</br>';
}
?>
	<?php echo $regfirma['nom_universidad'] ?></td>
</tr>
</table>
</body>
</html>