<?php
	//conexion a la BD
	
	include("selects.php");
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prodiagnostico S.A</title>
<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script>
function consultaractivo(codigo)
{
	var activo, respuesta
	mensaje = document.getElementById('respuesta');
	activo = document.getElementById('codigo').value;
	if(activo=="")
	{
		mensaje = "Por favor digite el codigo del activo";
		//etiqueta donde voy a mostrar la respuesta
		document.getElementById('respuesta').innerHTML = mensaje;
	}
	else
		document.activo.submit();
		}
</script>
<script>
function consultaractivo2(tipo_activo)
{
	var tipo_activo, respuesta
	mensaje = document.getElementById('respuesta');
	tipo_activo = document.getElementById('tipo_activo').value;
	if(activo=="")
	{
		mensaje = "Por favor digite el codigo del activo";
		//etiqueta donde voy a mostrar la respuesta
		document.getElementById('respuesta').innerHTML = mensaje;
	}
	else
		document.tipo_activo.submit();
		}
</script>
<link href="file:///C|/AppServ/www/epsilon1/SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../../css/default.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../js/ajax.js"></script> 
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<link href="../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>
<body topmargin="0">
<table width="100%" border="0">
<tr>
  <td align="left" valign="middle">
		<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a href="file:///C|/AppServ/www/epsilon1/includes/main_menu.php">MEN&Uacute; PRINCIPAL</a></span> &gt;&nbsp;<a href="../main_menu_activosfijos.php">Activos Fijos</a><span class="class_cargo" style="font-size:14px"> &gt;Ingreso activos</span></span>
	</div>
	<table width="98%" border="0">
	<tr>
	<td colspan="2" height="7"><div style="border-bottom: #D3D3D3 2px dotted"></div><br></td>
	</tr>
	<tr>
	<td valign="top" align="left" bgcolor="#DEDEDE"><table width="100%" border="0">
	  <tr>
	    <td width="83%"><p><strong>Codigo Activo:</strong></p>
	      <p>
	        
	        <form id="activo" name="activo" method="get" action="Cons_activos.php">
	          <span id="sprytextfield1">
	            <input type="text" name="codigo" id="codigo" onblur="consultaractivo(codigo)" />
	            <span class="textfieldRequiredMsg">*</span></span>
	        </form>
	      </td>
	    </tr>
	  
	    <tr>
	      <td><span id="respuesta" style="font-size:12px; color:#F00;"></span></td>
	      <tr>
          <td width="83%"><p><strong>Tipo Activo:</strong></p>
	      <p><form id="tipo_activo" name="tipo_activo" method="post" action="Cons_activos2.php">
            <label for="tipo_activo"></label>
            <span id="spryselect1">
              <select name="tipo_activo" id="tipo_activo" onchange="consultaractivo2(tipo_activo)">
                <option>.:Seleccione:.</option>
                <?php
      	while($rowtipoactivo = mysql_fetch_array($listatipoactivo))
		{
			echo '<option value="'.$rowtipoactivo[id_tipo].'">'.$rowtipoactivo[desc_tipo].'</option>';
		}
	  ?></select>
	      </form></td>
          <tr>
	    <td></td>
	    </tr>
	  </table>
      </td>
	</tr>
	</table>

<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
</script>


<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
</body>
</html>