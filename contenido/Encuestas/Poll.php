<?php
//conexion a la bd
require_once('../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//Variables
$idEncuesta = base64_decode($_GET['idEncuesta']);
$fechaActual = date("Y-m-d");
//consulta con sedes y servicios
include('Query/selects.php');
//obtener descripcion de la encuesta
$sqlEncuesta = mysql_query("SELECT * FROM e_nombencuesta WHERE idnombencuesta = '$idEncuesta'", $cn);
$regEncuesta = mysql_fetch_array($sqlEncuesta);
//consultar las preguntas correspondientes a la encuesta
$sqlQuestion = mysql_query("SELECT * FROM e_pregunta WHERE idencuesta = '$idEncuesta' AND idestado_actividad = '1'", $cn);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Encuesta :. Prodiagnostico S.A</title>
<script src="../../js/jquery-1.7.1.js"></script>
<script src="../../js/ui/jquery.ui.core.js"></script>
<script src="../../js/ui/jquery.ui.widget.js"></script>
<script src="../../js/ui/jquery.ui.datepicker.js"></script>
<script src="../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="styles/general.css" rel="stylesheet" type="text/css">
<link href="../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css">
<link href="../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script>
$(function() {
	$( "#datepicker" ).datepicker({dateFormat: 'yy-mm-dd'});
});

function ValidarOpcion()
{
	var Checkbox, form;
	form = document.encuesta;
	Checkbox = form.TipoComentario.value;
	//comparar el valor del tipo de comentario para mostrar o no el campo de texto para hacer las observaciones
	if(Checkbox!=0)
	{
		document.getElementById('comentario').style.display = "block";
	}
	else
	{
		document.getElementById('comentario').style.display = "none";
	}
}
</script>
</head>
<body>
<form name="encuesta" id="encuesta" method="post" action="Inserts/PollRegister.php">
<fieldset style="margin-top:1%;">
  <legend><h3><strong><?php echo $regEncuesta['nomencuesta']?></strong></h3></legend>
    <table width="100%" border="0">
      <tr>
        <td colspan="3"><p><strong>Por favor, diligencie la siguiente información: </strong>(Si desea puede dejar en blanco sus datos de  identificación)</p></td>
      </tr>
      <tr>
        <td colspan="3">
        	<table width="100%" border="0">
  <tr>
    <td>Nombre completo:</td>
    <td><input type="text" name="nombusuario" id="nombusuario" class="input" placeholder="Nombre completo" /></td>
    <td>Cedula:</td>
    <td><input type="text" name="cedula" id="cedula" class="input" placeholder="Numero de documento"/></td>
    <td>Telefono:</td>
    <td><input type="text" name="telefono" id="telefono" class="input" placeholder = "Numero de telefono fijo y/o movil"/></td>
  </tr>
  <tr>
    <td>Direccion:</td>
    <td><input type="text" name="direccion" id="direccion"  class="input" placeholder="Dirección de su residencia"/></td>
    <td>Email:</td>
    <td><input type="text" name="email" id="email" class="input" placeholder="Correo electronico"/></td>
    <td>Sede:</td>
    <td><label for="sede"></label>
      <span id="spryselect1">
      <select name="sede" id="sede" class="input">
        <option value="">.: Seleccione :.</option>
        <?php
      	while($rowSede = mysql_fetch_array($listaSedeActiva))
		{
			echo '<option value="'.$rowSede['idsede'].'">'.$rowSede['descsede'].'</option>';
		}
	  ?>
      </select>
      <span class="selectRequiredMsg">*</span></span></td>
  </tr>
  <tr>
    <td>Servicio:</td>
    <td><span id="spryselect2">
      <select name="servicio" id="servicio" class="input">
        <option value="">.: Seleccione :.</option>
        <?php
      	while($rowServicio = mysql_fetch_array($listaServicios))
		{
			echo '<option value="'.$rowServicio['idservicio'].'">'.$rowServicio['descservicio'].'</option>';
		}
	  ?>
      </select>
      <span class="selectRequiredMsg"></span></span></td>
    <td>Fecha:</td>
    <td><label for="fecha"></label>
      <input type="text" name="fecha" id="datepicker" class="input" readonly="readonly" value="<?php echo $fechaActual ?>" /></td>
    <td>&nbsp;</td>
    <td><input type="hidden" name="encuesta" value="<?php echo $idEncuesta ?>"></td>
  </tr>
</table>
        </td>
      </tr>
      <tr>
        <td colspan="3"><strong>Por favor, conteste las siguientes preguntas:</strong></td>
      </tr>
      <?php
      	//imprimir las pregutas que correspondan a la encuesta seleccionada
		while($rowQuestion = mysql_fetch_array($sqlQuestion))
		{
			echo 
			'<tr>
				<td colspan="2" width="70%">'.$rowQuestion['desc_pregunta'].'<input type="hidden" name="pregunta[]" value="'.$rowQuestion['idpregunta'].'"></td>
				<td>
				<select name="respuesta[]" class="input">
					<option value="0">Prefiero no responder</option>
					<option value="1">Malo</option>
					<option value="2">Regular</option>
					<option value="3">Bueno</option>
					<option value="4">Excelente</option>
				</select>
			</td>
			</tr>';	
		}
	  ?>
      <tr>
        <td colspan="3"><strong>Porque usted es  importante... Seleccione el tipo de información</strong></td>
      </tr>
      <tr>
        <td colspan="3">
        <table>
        <tr>
        	<?php
        	//consultar tipos de comentarios disponibles
			$sqlTipoComentario = mysql_query("SELECT * FROM e_tipocomentario", $cn);
			while($rowregTipoComentario = mysql_fetch_array($sqlTipoComentario))
			{
			 echo '<td>' .$rowregTipoComentario['desctipo_comentario'].'&nbsp;';?>
            <input type="radio" name="TipoComentario" value="<?php echo $rowregTipoComentario['idtipocomentario']?>" 
            <?php if($rowregTipoComentario['idtipocomentario'] == 0) { echo 'checked="checked"';}?>
            onclick="ValidarOpcion()"/>|
			 <?php 
			 echo '</td>';
			}
		?>
        </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td colspan="3"><label for="comentario"></label>
        <textarea name="comentario" id="comentario" cols="45" rows="5" style="display:none;"></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right"><input type="submit" name="Enviar" id="Enviar" value="Enviar" /></td>
      </tr>
    </table>
</fieldset>
</form>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
</script>
</body>
</html>