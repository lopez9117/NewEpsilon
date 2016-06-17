<?php
//conexion a la bd
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//incluir campos seleccionables
include("../Query/selects.php");
//vector asociativo con los meses del año
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Encuesta de satisfacción Sede :.</title>
<link href="../styles/general.css" rel="stylesheet" type="text/css">
<link href="../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css">
<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../../../js/jquery-1.7.1.js" type="text/javascript"></script>
<script src="../JavaScript/funciones.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script>
function Validar()
{
	var form, encuesta, pregunta, sede, mes, anio;
	form = document.SedePregunta;
	encuesta = form.encuesta.value;
	pregunta = form.pregunta.value;
	sede = form.sede.value;
	mes = form.mes.value;
	anio = form.anio.value;
	
	if(encuesta=="" || pregunta=="" || sede =="" || mes=="" || anio=="")
	{
		alert("Verifique los campos vacios");
	}
	else
	{
		var randomnumber=Math.random()*11;
		$.post("individual.php?encuesta="+encuesta+"&pregunta="+pregunta+"&sede="+sede+"&mes="+mes+"&anio="+anio+"", {
			randomnumber:randomnumber
		}, function(data){
		  $("#contenido").html(data);
		});
	}
}
</script>
</head>
<body>
<form id="SedePregunta" name="SedePregunta" method="post" action="#">
  <table width="90%" border="0" align="center">
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>Encuesta:</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><span id="spryselect1">
        <label for="encuesta"></label>
        <select name="encuesta" id="encuesta" class="input" onchange="CargarPreguntas()">
          <option value="">.: Seleccione la encuesta de la que desea obtener información :.</option>
          <?php
        	while($rowEncuesta = mysql_fetch_array($listaEncuesta))
			{
				echo '<option value="'.$rowEncuesta['idnombencuesta'].'">'.$rowEncuesta['nomencuesta'].'</option>';
			}
		?>
        </select>
      <span class="selectRequiredMsg">*</span></span></td>
    </tr>
    <tr>
      <td>Pregunta:</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3"><span id="spryselect2">
        <label for="pregunta"></label>
        <select name="pregunta" id="pregunta" class="input">
          <option value="">.: Por favor seleccione una pregunta de la lista :.</option>
        </select>
      <span class="selectRequiredMsg">*</span></span></td>
    </tr>
    <tr>
      <td width="33%">Sede</td>
      <td width="33%">Mes</td>
      <td width="33%">Año</td>
    </tr>
    <tr>
      <td><span id="spryselect3">
        <label for="sede"></label>
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
      <td><span id="spryselect4">
        <label for="mes"></label>
        <select name="mes" id="mes" class="input">
        <option value="">.: Seleccione :.</option>
        <?php
        	foreach($meses as $m => $mes)
			{
				echo '<option value="'.$m.'">'.$mes.'</option>';
			}
		?>
        </select>
      <span class="selectRequiredMsg">*</span></span></td>
      <td><span id="spryselect5">
        <label for="anio"></label>
        <select name="anio" id="anio" class="input">
        <option value="">.: Seleccione :.</option>
        <?php
        	while($rowAnio = mysql_fetch_array($anios))
			{
				echo '<option value="'.$rowAnio['anio'].'">'.$rowAnio['anio'].'</option>';
			}
		?>
        </select>
      <span class="selectRequiredMsg">*</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="button" name="Consultar" id="Consultar" value="Consultar" onclick="Validar()" />
      <input type="reset" name="button" id="button" value="Restablecer" /></td>
    </tr>
  </table>
</form><br>
<div id="contenido"></div>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var spryselect4 = new Spry.Widget.ValidationSelect("spryselect4");
var spryselect5 = new Spry.Widget.ValidationSelect("spryselect5");
</script>
</body>
</html>