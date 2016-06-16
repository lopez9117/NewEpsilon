<?php
//conexion a la bd
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//incluir campos seleccionables
include("../Query/selects.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Encuesta de satisfaccion Global :.</title>
<link href="../styles/general.css" rel="stylesheet" type="text/css">
<link href="../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css">
<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../../../js/jquery-1.7.1.js" type="text/javascript"></script>
<script src="../JavaScript/funciones.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script>
function Validar()
{
	var form, encuesta, anio, sede;
	form = document.Global;
	anio = form.anio.value;
	encuesta = form.encuesta.value;	
	sede = form.sede.value;
	if(anio=="" || encuesta =="" || sede=="")
	{
		alert("Verifique los campos vacios");
	}
	else
	{
		var randomnumber=Math.random()*11;
		$.post("Global.php?encuesta="+encuesta+"&anio="+anio+"&sede="+sede+"", {
			randomnumber:randomnumber
		}, function(data){
		  $("#contenido").html(data);
		});
	}
}
</script>
</head>
<body>
<fieldset>
<legend><h3>Satisfacción Sedes</h3></legend>
<form id="Global" name="Global" method="post" action="#">
  <table width="90%" border="0" align="center">
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Encuesta:</td>
      <td>Sede:</td>
      <td>Año:</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="25%">
      <select name="encuesta" id="encuesta" class="input">
          <option value="">.: Seleccione :.</option>
          <?php
        	while($rowEncuesta = mysql_fetch_array($listaEncuesta))
			{
				echo '<option value="'.$rowEncuesta['idnombencuesta'].'">'.$rowEncuesta['nomencuesta'].'</option>';
			}
		?>
        </select>
      </td>
      <td width="25%"><select name="sede" id="sede" class="input">
        <option value="">.: Seleccione :.</option>
        <?php
        	while($rowSede = mysql_fetch_array($listaSedeActiva))
			{
				echo '<option value="'.$rowSede['idsede'].'">'.$rowSede['descsede'].'</option>';
			}
		?>
      </select></td>
      <td width="25%"><label for="sede">
        <select name="anio" id="anio" class="input">
          <option value="">.: Seleccione :.</option>
          <?php
        	while($rowAnio = mysql_fetch_array($anios))
			{
				echo '<option value="'.$rowAnio['anio'].'">'.$rowAnio['anio'].'</option>';
			}
		?>
        </select>
      </label></td>
      <td width="25%"><input type="button" name="Consultar" id="Consultar" value="Consultar" onclick="Validar()" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" id="contenido"><label for="anio"></label></td>
    </tr>
  </table>
</form>
</fieldset>
</body>
</html>