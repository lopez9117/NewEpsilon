<?php 
//Conexion a la base de datos
require_once('../../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//variables
$idestudio = base64_decode($_GET['idestudio']);
include("../../select/selects.php");
$con = mysql_query("SELECT * FROM r_estudio WHERE idestudio = '$idestudio'", $cn);
$reg = mysql_fetch_array($con);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
<title>.: Editar :.</title>
<style type="text/css">
body
{font-family:Arial, Helvetica, sans-serif;
font-size:12px;}
fieldset
{width:95%;
	background: -moz-linear-gradient(top, rgba(232,232,232,1) 0%, rgba(232,232,232,0.99) 1%, rgba(229,229,229,0.55) 45%, rgba(229,229,229,0) 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(232,232,232,1)), color-stop(1%,rgba(232,232,232,0.99)), color-stop(45%,rgba(229,229,229,0.55)), color-stop(100%,rgba(229,229,229,0))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, rgba(232,232,232,1) 0%,rgba(232,232,232,0.99) 1%,rgba(229,229,229,0.55) 45%,rgba(229,229,229,0) 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, rgba(232,232,232,1) 0%,rgba(232,232,232,0.99) 1%,rgba(229,229,229,0.55) 45%,rgba(229,229,229,0) 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, rgba(232,232,232,1) 0%,rgba(232,232,232,0.99) 1%,rgba(229,229,229,0.55) 45%,rgba(229,229,229,0) 100%); /* IE10+ */
background: linear-gradient(to bottom, rgba(232,232,232,1) 0%,rgba(232,232,232,0.99) 1%,rgba(229,229,229,0.55) 45%,rgba(229,229,229,0) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e8e8e8', endColorstr='#00e5e5e5',GradientType=0 ); /* IE6-9 */
}
.large
{
	font-family:Arial, Helvetica, sans-serif;
font-size:12px;
width:95%;
}
.largetext
{
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
width:98%;
}
</style>
<script src="../../../../js/jquery.js" type="text/javascript"></script>
<script src="../../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>
<body>
<script language='javascript'>
  function ValBiosia()
  {
    servicio = $('#servicio').val();
    if (servicio == 7) {
        $('#biop').show();
        $('#dren').show();
    }
    else{
      $('#biop').hide();
      $('#dren').hide();
    }
  }
function Guardar()
{
	var nom_estudio, cod_iss, cod_soat, servicio, estado;
	nom_estudio = document.CreateEstudio.nom_estudio.value;
	cod_iss = document.CreateEstudio.cod_iss.value;
	cod_soat = document.CreateEstudio.cod_soat.value;
	servicio = document.CreateEstudio.servicio.value;
	estado = document.CreateEstudio.estado.value;
	//validar campos obligatorios
	if(nom_estudio == "" || servicio == "" || estado == "")
	{
		mensaje = '<font color="#FF0000">Los campos marcados con * son obligatorios</font>';
		document.getElementById('respuesta').innerHTML = mensaje;
	}
	else
	{
		document.CreateEstudio.submit();
	}
}
</script>
<div style="margin-left:2%;">
<fieldset>
	<legend><strong>Editar estudio / procedimiento</strong></legend>
    <form id="CreateEstudio" name="CreateEstudio" method="post" action="InsertNuevoEstudio.php">
      <table width="100%" border="0">
        <tr>
          <td width="50%">Estudio / Procedimiento</td>
          <td width="50%">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><span id="sprytextfield1">
            <input type="text" name="nom_estudio" id="nom_estudio" value="" class="largetext" onkeyup="this.value=this.value.toUpperCase()" />
          <span class="textfieldRequiredMsg">*</span></span></td>
        </tr>
        <tr>
          <td>Cod. ISS:</td>
          <td>Cod. SOAT:</td>
        </tr>
        <tr>
          <td><span id="sprytextfield2">
          <input type="text" name="cod_iss" id="cod_iss" class="large" onkeyup="this.value=this.value.toUpperCase()" />
          <span class="textfieldRequiredMsg">*</span><span class="textfieldInvalidFormatMsg">*</span></span></td>
          <td><span id="sprytextfield3">
          <input type="text" name="cod_soat" id="cod_soat" class="large" onkeyup="this.value=this.value.toUpperCase()" />
          <span class="textfieldRequiredMsg">*</span><span class="textfieldInvalidFormatMsg">*</span></span></td>
        </tr>
        <tr>
          <td>Servicio:</td>
          <td>Estado:</td>
        </tr>
        <tr>
          <td><label for="servicio"></label>
            <span id="spryselect1">
            <select name="servicio" id="servicio" class="large" onchange="ValBiosia()">
              <option value="">.: Seleccione :.</option>
              <?php
            	while($rowServicio = mysql_fetch_array($listaServicio))
				{
					echo '<option value="'.$rowServicio['idservicio'].'">'.$rowServicio['descservicio'].'</option>';
				}
			?>
            </select>
          <span class="selectRequiredMsg">*</span></span></td>
          <td><label for="estado"></label>
            <span id="spryselect2">
            <select name="estado" id="estado" class="large">
              <option value="">.: Seleccione :.</option>
              <?php
            	while($rowEstado = mysql_fetch_array($listarEstado))
				{
					echo '<option value="'.$rowEstado['idestado_actividad'].'">'.$rowEstado['desc_estado'].'</option>';
				}
			?>
            </select>
          <span class="selectRequiredMsg">*</span></span></td>
        </tr>
		 <tr>
          <td>Valor ISS:</td>
          <td>Valor SOAT:</td>
        </tr>
        <tr>
          <td><span id="sprytextfield2">
          <input type="number" name="val_iss" id="val_iss" value="0" class="large" onkeyup="this.value=this.value.toUpperCase()"  />
          <span class="textfieldRequiredMsg">*</span><span class="textfieldInvalidFormatMsg">*</span></span></td>
          <td><span id="sprytextfield3">
          <input type="number" name="val_soat" id="val_soat" value="0" class="large" onkeyup="this.value=this.value.toUpperCase()"  />
          <span class="textfieldRequiredMsg">*</span><span class="textfieldInvalidFormatMsg">*</span></span></td>
        </tr>
		  <tr>
          <td>Cod. Propio:</td>
          <td>Valor Propio:</td>
        </tr>
        <tr>
          <td><span id="sprytextfield2">
          <input type="text" name="cod_propio" id="cod_propio" class="large" onkeyup="this.value=this.value.toUpperCase()"  />
          <span class="textfieldRequiredMsg">*</span><span class="textfieldInvalidFormatMsg">*</span></span></td>
          <td><span id="sprytextfield3">
          <input type="number" name="val_propio" id="val_propio" value="0" class="large" onkeyup="this.value=this.value.toUpperCase()"  />
          <span class="textfieldRequiredMsg">*</span><span class="textfieldInvalidFormatMsg">*</span></span></td>
        </tr>
		<tr>
          <td>Cod. Sala:</td>
          <td>Valor Sala:</td>
        </tr>
        <tr>
          <td><span id="sprytextfield2">
          <input type="text" name="sala" id="sala" class="large" onkeyup="this.value=this.value.toUpperCase()"  />
          <span class="textfieldRequiredMsg">*</span><span class="textfieldInvalidFormatMsg">*</span></span></td>
          <td><span id="sprytextfield3">
          <input type="number" name="val_sala" id="val_sala" value="0" class="large" onkeyup="this.value=this.value.toUpperCase()"  />
          <span class="textfieldRequiredMsg">*</span><span class="textfieldInvalidFormatMsg">*</span></span></td>
        </tr>
		<tr>
		  <td>Materiales:</td>
          <td>Valor Materiales:</td>
        </tr>
        <tr>
          <td><span id="sprytextfield2">
          <input type="text" name="materiales" id="materiales" value="" class="large" onkeyup="this.value=this.value.toUpperCase()"  />
          <span class="textfieldRequiredMsg">*</span><span class="textfieldInvalidFormatMsg">*</span></span></td>
          <td><span id="sprytextfield3">
          <input type="number" name="val_materiales" id="val_materiales" value="0" class="large" onkeyup="this.value=this.value.toUpperCase()"  />
          <span class="textfieldRequiredMsg">*</span><span class="textfieldInvalidFormatMsg">*</span></span></td>
        </tr>
		<tr>
		  <td>Cod. Cups:</td>
          <td>Honorarios:</td>
        </tr>
        <tr>
          <td><span id="sprytextfield2">
          <input type="text" name="cups_iss" id="cups_iss" class="large" onkeyup="this.value=this.value.toUpperCase()"  />
          <span class="textfieldRequiredMsg">*</span><span class="textfieldInvalidFormatMsg">*</span></span></td>
          <td><span id="sprytextfield3">
          <input type="number" name="honorario" id="honorario" value="0" class="large" onkeyup="this.value=this.value.toUpperCase()"  />
          <span class="textfieldRequiredMsg">*</span><span class="textfieldInvalidFormatMsg">*</span></span></td>
        </tr>
		<tr>
		<td>Procedimiento Espcial (UVR)</td>
		<td id="biop" style="display: none">Biopsia o Drenaje</td>
		</tr>
		<tr>
          <td><label for="uvr"></label>
            <span id="spryselect1">
            <select name="uvr" id="uvr" class="large">
              <option value="">.: Seleccione :.</option>
			  <option value="T">SI</option>
			  <option value="F">NO</option>
            </select>
          <span class="selectRequiredMsg">*</span></span>*</td>
		  <td id="dren" style="display: none"><select name="b/d" id="b/d" class="large">
              <option value="NULL">.: Seleccione :.</option>
              <option value="B">Biopsia</option>
              <option value="D">Drenaje</option>
            </select></td>
		</tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
        	<td id="respuesta">&nbsp;</td>
            <td align="right"><input type="submit" name="button" id="button" value="Guardar" onclick="Guardar()" />
            <input type="reset" name="button2" id="button2" value="Restablecer" /></td>
        </tr>
      </table>
    </form>
</fieldset>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur", "change"]});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
</script>
</body>
</html>