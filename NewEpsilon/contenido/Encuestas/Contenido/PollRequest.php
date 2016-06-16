<?php
//Conexion a la base de datos
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//variables
$idEncuestado = base64_decode($_GET['id']);
//listas seleccionables
include('../Query/selects.php');
//consultar toda la informacion de la encuesta
$consPoll = mysql_query("SELECT en.idusuario, en.fecha, en.idsede, en.idservicio, en.idnombencuesta, us.nombres, us.tel, us.direccion,
us.email, us.cedula FROM e_encuesta en
INNER JOIN e_usuario us ON us.idusuario = en.idusuario
WHERE en.idencuesta = '$idEncuestado'", $cn);
$regsPoll = mysql_fetch_array($consPoll);
//consultar las preguntas de acuerdo a la encuesta contestada
$idEncuesta = $regsPoll['idnombencuesta'];
//consultar las preguntas correspondientes a la encuesta
$sqlQuestion = mysql_query("SELECT * FROM e_pregunta WHERE idencuesta = '$idEncuesta' AND idestado_actividad = '1'", $cn);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../styles/general.css" rel="stylesheet" type="text/css">
<title>.: Detalles Encuesta :.</title>
</head>
<body>
<fieldset>
<legend></legend>
<table width="100%" border="0">
<tr>
<td colspan="3"><p><strong>Por favor, diligencie la siguiente información: </strong>(Si desea puede dejar en blanco sus datos de  identificación)</p></td>
</tr>
<tr>
<td colspan="3">
	<table width="100%" border="0">
<tr>
<td>Nombre completo:</td>
<td><input type="text" name="nombusuario" id="nombusuario" class="input" placeholder="Nombre completo" value="<?php echo $regsPoll['nombres']?>" disabled="disabled" /></td>
<td>Cedula:</td>
<td><input type="text" name="cedula" id="cedula" class="input" placeholder="Numero de documento" value="<?php echo $regsPoll['cedula']?>" disabled="disabled"/></td>
<td>Telefono:</td>
<td><input type="text" name="telefono" id="telefono" class="input" placeholder = "Numero de telefono fijo y/o movil" value="<?php echo $regsPoll['tel']?>" disabled="disabled"/></td>
</tr>
<tr>
<td>Direccion:</td>
<td><input type="text" name="direccion" id="direccion"  class="input" placeholder="Dirección de su residencia" value="<?php echo $regsPoll['direccion']?>" disabled="disabled"/></td>
<td>Email:</td>
<td><input type="text" name="email" id="email" class="input" placeholder="Correo electronico" value="<?php echo $regsPoll['email']?>" disabled="disabled"/></td>
<td>Sede:</td>
<td><label for="sede"></label>
<span id="spryselect1">
<select name="sede" id="sede" class="input" disabled="disabled">
<option value="">.: Seleccione :.</option>
<?php
while($rowSede = mysql_fetch_array($listaSedeActiva))
{?>
	<option value="<?php echo $rowSede['idsede'] ?>"
	<?php if($regsPoll['idsede']==$rowSede['idsede'])
	{
		echo 'selected="selected"';
	}?>
	>
	<?php echo $rowSede['descsede'] ?></option>
<?php	
}
?>
</select>
</td>
</tr>
<tr>
<td>Servicio:</td>
<td><span id="spryselect2">
<select name="servicio" id="servicio" class="input" disabled="disabled">
<option value="">.: Seleccione :.</option>
<?php
while($rowServicio = mysql_fetch_array($listaServicios))
{?>
	<option value="<?php echo $rowServicio['idservicio']?>"
	<?php if($regsPoll['idservicio'] == $rowServicio['idservicio'])
	{
		echo 'selected="selected"';
	}?>
	>
	<?php echo $rowServicio['descservicio']?>
	</option>
<?php    
}
?>
</select>
</td>
<td>Fecha:</td>
<td><label for="fecha"></label>
<input type="text" name="fecha" id="datepicker" class="input" disabled="disabled" value="<?php echo $regsPoll['fecha']?>" /></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</table>
</td>
</tr>
<tr>
<td colspan="3"><strong>Por favor, conteste las siguientes preguntas:</strong></td>
</tr>
<?php
//obtener preguntas y respuestas correspondientes a la encuesta
$consulta = mysql_query("SELECT res.idpregunta, res.idcalificacion, pre.desc_pregunta, cal.desccalificacion FROM e_resp_encuesta res
INNER JOIN e_pregunta pre ON pre.idpregunta = res.idpregunta
INNER JOIN e_calificacion cal ON cal.idcalificacion = res.idcalificacion
WHERE res.idencuesta = '$idEncuestado' ORDER BY res.idpregunta ASC", $cn);
while($rowConsulta = mysql_fetch_array($consulta))
{
	echo 
	'<tr>
		<td colspan="2" width="70%">'.$rowConsulta['desc_pregunta'].'</td>
		<td>
		<select class="input" disabled="disabled">
			<option>'.$rowConsulta['desccalificacion'].'</option>
		</select>
	</td>
	</tr>';	
}
?>
<tr>
<td colspan="3"><strong>Porque usted es  importante…. Seleccione el tipo de información</strong></td>
</tr>
<tr>
<td colspan="3">
<table>
<tr>
<?php
//consultar si se hicieron comentarios en la consulta
$sqlComentario = mysql_query("SELECT * FROM e_comentarios WHERE idencuesta = '$idEncuestado'", $cn);
$ConComentario = mysql_num_rows($sqlComentario);
$regComentario = mysql_fetch_array($sqlComentario);
if($ConComentario>=1)
{
	//consultar tipos de comentarios disponibles
	$sqlTipoComentario = mysql_query("SELECT * FROM e_tipocomentario", $cn);
	while($rowregTipoComentario = mysql_fetch_array($sqlTipoComentario))
	{
	 echo '<td>'.$rowregTipoComentario['desctipo_comentario'].'&nbsp;';?>
	<input type="radio" name="TipoComentario" value="<?php echo $rowregTipoComentario['idtipocomentario']?>" 
	<?php if($rowregTipoComentario['idtipocomentario'] == $regComentario['idtipocomentario']) { echo 'checked="checked"';}?>
	onclick="ValidarOpcion()"/>|
	 <?php 
	}
	 echo '</td>';
?>
</tr>
</table>
</td>
</tr>
<tr>
<td colspan="3"><label for="comentario"></label>
<textarea disabled="disabled" name="comentario" id="comentario" cols="45" rows="5"><?php echo $regComentario['comentario']?></textarea></td>
</tr>
<?php
}
?>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td align="right">&nbsp;</td>
</tr>
</table>
</fieldset>
</body>
</html>