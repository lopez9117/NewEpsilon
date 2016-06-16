<?php
	//conexion a la BD
	
	require_once("../../../dbconexion/conexion.php");
	$cn = Conectarse();
	include("selects.php");
	include("select.php");
	$tipo_activo=$_POST[tipo_activo];
	$cont = mysql_query("SELECT MAX(codigo+1) AS total FROM activo_fijo WHERE id_tipo_activo='$tipo_activo'", $cn);
	$regcont= mysql_fetch_array($cont);
	$cn = conectarse();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prodiagnostico S.A</title>
<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="file:///C|/AppServ/www/epsilon1/SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../../css/default.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../js/ajax.js"></script>
<script src="../../../js/jquery.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css" />
  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>
  <script> 
  $(function() {
    $( "#datepicker1" ).datepicker();
  });
  </script>
  <script> 
 function activar(){
	 var opcion;
	 opcion=document.Newregistro.adquicicion2.value;
	 if (opcion==1)
	 {
  document.Newregistro.cuota.disabled = true;
	 }else
	 {		 
  document.Newregistro.cuota.disabled = false;
	}
 }
 function activardepreciacion(){
document.Newregistro.tiempo_depreciacion.disabled=!document.Newregistro.tiempo_depreciacion.disabled
document.Newregistro.tipo_depreciacion.disabled=!document.Newregistro.tipo_depreciacion.disabled
 }
  </script>
<style type="text/css">
body {
	margin-left: 10px;
	margin-top: 0px;
	margin-right: 4px;
	margin-bottom: 0px;
	overflow-x: hidden;
}
</style>
<link href="../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body,td,th {
	font-size: 12px;
}
</style>
</head>
<body topmargin="0">
<table width="80%" border="0">
<tr>
  <td align="left" valign="middle">
		<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a href="file:///C|/AppServ/www/epsilon1/includes/main_menu.php">MEN&Uacute; PRINCIPAL</a></span> &gt;&nbsp;<a href="../main_menu_activosfijos.php">Activos Fijos</a><span class="class_cargo" style="font-size:14px"> &gt;Ingreso activos</span></span>
	</div>
    <table width="98%" border="0">
	<tr>
	<td colspan="2" height="7"><div style="border-bottom: #D3D3D3 2px dotted"></div><br></td>
	</tr>
	<tr>
    
  </tr>
</table>
<form action="../insert_activo.php" method="post" enctype="multipart/form-data" name="Newregistro" id="Newregistro">
  <table width="83%" border="0" cellspacing="0">
    <tr>
    <td valign="top" align="left" bgcolor="#DEDEDE"><table width="47%" cellspacing="0">
  <tr>
    <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="0">
  <tbody>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td width="21%" align="left"><strong>Codigo:</strong></td>
      <td width="19%" align="left"><strong>Descripci&oacute;n&nbsp;</strong></td>
      <td width="13%" align="left"><strong>Cantidad</strong></td>
      <td width="13%" align="left"><strong>Marca</a></strong></td>
      <td width="13%" align="left"><strong>Modelo</strong></td>
      <td width="21%" align="left"><strong>Serie</strong></td>
    </tr>
</tbody></table></td>
  </tr>
  <tr>
    <td id="consulta"><table width="100%" border="0" cellspacing="0">
  <tbody><tr>
    <td width="13%" align="left"><label for="tipo_documento"></label>
      <label for="ndocumento"></label>
      <span id="sprytextfield1">
      <input name="codigo2" type="text" class="tsmall" id="codigo2" value="<? echo $regcont[total];?>" />
      </span></td>
    <td width="23%" align="left"><label for="prinombre"></label>
      <label for="descripcion"></label>
      <textarea name="descripcion" cols="39" rows="2" id="descripcion"></textarea>
<label for="segnombre"></label></td>
    <td width="13%" align="left"><label for="priapellido"></label>
      <input type="text" name="cantidad" id="cantidad" class="tsmall" />
      <label for="segapellido"></label></td>
    <td width="13%" align="left"><label for="norden"></label>
      <input type="text" name="marca" id="marca" class="tlarge" /></td>
    <td width="13%" align="left"><label for="modelo"></label>
      <input type="text" name="modelo" id="modelo" /></td>
    <td width="25%" align="left"><label for="serie"></label>
      <input type="text" name="serie" id="serie" /></td>
  </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
  </tbody>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="0">
  <tbody>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td width="26%" align="left"><strong>Responsable</strong></td>
      <td width="18%" align="left"><strong>Centro de Costos</strong></td>
      <td width="14%" align="left"><strong>Localizaci&oacute;n</strong></td>
      <td width="16%" align="left"><strong>Fecha de Compra</strong></td>
      <td width="26%" align="left"><strong>Tiempo de depreciaci&oacute;n
        <input type="checkbox" name="depreciacion" id="depreciacion" onclick="activardepreciacion()" />
        <label for="depreciacion"></label>
      </strong></td>
    </tr>
</tbody></table></td>
  </tr>
  <tr>
    <td id="consulta1"><table width="100%" border="0" cellspacing="0">
  <tbody><tr>
    <td width="11%" align="left"><label for="fechanacimiento"></label>
      <label for="responsable"></label>
      <span id="spryselect1">
      <select name="responsable2" id="responsable2">
        <option>.:Seleccione:.</option>
        <?php
      	while($rowfuncionario = mysql_fetch_array($listafuncionario))
		{
			echo '<option value="'.$rowfuncionario[idfuncionario].'">'.$rowfuncionario[nombres].$rowfuncionario[apellidos].'</option>';
		}
	  ?>
      </select>
      <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
    <td width="13%" align="left"><label for="eps"></label>
      <label for="centro"></label>
      <input type="text" name="centro" id="centro" /></td>
<td width="11%" align="left"><label for="fechaHoraCita"></label>
  <label for="localizacion"></label>
  <span id="spryselect2">
  <select name="localizacion" id="localizacion">
    <option>.:Seleccione:.</option>
    <?php
      	while($rowSede = mysql_fetch_array($listaSedeActiva))
		{
			echo '<option value="'.$rowSede[idsede].'">'.$rowSede[descsede].'</option>';
		}
	  ?>
  </select>
  <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
<td width="15%" align="left"><label for="fecha"></label>
  <span id="sprytextfield2">
  <input type="text" name="datepicker" id="datepicker" />
  <span class="textfieldRequiredMsg">*</span></span></td>
<td width="50%" align="left"><label for="tiempo_depreciacion"></label>
  <input name="tiempo_depreciacion" type="text" id="tiempo_depreciacion" disabled="disabled" />
  <label for="tipo_depreciacion"></label>
  <select name="tipo_depreciacion" id="tipo_depreciacion" disabled="disabled">
  <option>.:Seleccione:.</option>
         <?php
      	while($rowdepreciacion = mysql_fetch_array($listatiempodepreciacion))
		{
			echo '<option value="'.$rowdepreciacion[id_depreciacion].'">'.$rowdepreciacion[desc_depreciacion].'</option>';
		}
	  ?>
  </select></td>
   </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
  </tbody>
    </table></td>

  </tr>
  <tr>
    <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="0">
  <tbody>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      </tr>
    <tr>
      <td width="11%" align="left"><strong>Propiedad</strong></td>
      <td width="13%" align="left"><strong>Tipo de Adquicici&oacute;n</strong></td>
      <td width="13%" align="left"><strong>Aseguradora
        
      </strong></td>
      <td width="15%" align="left"><strong>Fecha Vencimiento Garantia
        
      </strong></td>
      <td width="13%" align="left"><strong>Hoja de Vida</strong></td><td width="16%" align="left"><strong>Valor Activo</strong></td>
      <td width="19%" align="left"><strong>Cuota/Canon</strong></td>
      </tr>
</tbody></table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0">
  <tbody><tr>
    <td width="11%" align="left"><label for="sede"></label>
      <span id="spryselect3">
      <select name="propiedad2" id="propiedad2" class="select">
        <option>.:Seleccione:.</option>
        <?php
      	while($rowpropiedad = mysql_fetch_array($listadopropiedad))
		{
			echo '<option value="'.$rowpropiedad[id_propiedad].'">'.$rowpropiedad[desc_propiedad].'</option>';
		}
	  ?>
      </select>
      <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
    <td width="13%" align="left"><label for="servicio"></label>
      <span id="spryselect4">
      <select name="adquicicion2" id="adquicicion2" class="select" onchange="activar()">
        <option>.:Seleccione:.</option>
        <?php
      	while($rowAdquicicion = mysql_fetch_array($listadoadquicicion))
		{
			echo '<option value="'.$rowAdquicicion[id_adquicicion].'">'.$rowAdquicicion[tipo].'</option>';
		?>
   <?php	
		}
	  ?>
      </select>
      <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
    <td width="13%" align="left"><select name="asegurado" id="asegurado" disabled="disabled">
      <option>.:Seleccione:.</option>
      <?php
      	while($rowasegurado = mysql_fetch_array($listadoasegurado))
		{
			echo '<option value="'.$rowasegurado[id].'">'.$rowasegurado[aseguradora].'</option>';
		}
	  ?>
    </select>
      <strong>
      <input type="checkbox" name="asegurado2" id="asegurado2" onclick="document.Newregistro.asegurado.disabled=!document.Newregistro.asegurado.disabled" />
      </strong></td>
     <td width="15%" align="left"><input type="text" name="vencimiento_garantia" id="datepicker1"/></td>
     <td width="13%" align="left"><label for="hoja?vida"></label>
       <select name="hoja_de_vida" id="hoja_de_vida">
       <option>.:Seleccione:.</option>
         <?php
      	while($rowhoja_vida = mysql_fetch_array($listahojavida))
		{
			echo '<option value="'.$rowhoja_vida[id].'">'.$rowhoja_vida[desc_hoja_vida].'</option>';
		}
	  ?>
       </select></td>
     <td width="16%" align="left"><label for="valor"></label>
       <span id="sprytextfield3">
       <input type="text" name="valor" id="valor" />
       <span class="textfieldRequiredMsg">*</span></span></td>
     <td width="19%" align="left"><label for="cuota"></label>
       <input type="text" name="cuota" id="cuota" disabled="disabled" /></td>
     </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      </tr>
  </tbody>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="0">
      <tbody>
        <tr>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td width="24%" align="left"><strong>Adjuntar adquicici&oacute;n</strong></td>
          <td width="24%" align="left"><strong>Hoja de vida</strong></td>
          <td width="25%" align="left"><strong>Contrato Mantenimiento</strong></td>
          <td width="27%" align="left"><strong>Contrato de Calibraci&oacute;n</strong></td>
        </tr>
  </tbody></table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0">
  <tbody>
    <tr>
    <td width="11%" align="left"><label for="vencimiento_garantia">
      <input type="file" name="archivo_adquicicion" id="archivo_adquicicion" />
    </label></td>
    <td width="22%" align="left"><label for="hoja_vida"></label>
      <input type="file" name="hoja_vida" id="hoja_vida" /></td>
    <td width="21%" height="24" align="left"><label for="contrato_mantenimiento"></label>
      <input type="file" name="contrato_mantenimiento" id="contrato_mantenimiento" /></td>
    <td width="33%" align="left"><label for="contrato_calibracion"></label>
      <input type="file" name="contrato_calibracion" id="contrato_calibracion" /></td>
    </tr>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td height="24" align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
  </tbody>
    </table></td>
  </tr>
    <tr>
    <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="0">
  <tbody>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td width="58%" align="left"><strong>&nbsp;Observaci&oacute;n</strong></td>
      <td width="42%" align="left">&nbsp;</td>
    </tr>
</tbody></table></td>
  </tr>
   <tr>
    <td><table width="100%" border="0" cellspacing="0">
  <tr>
    <td width="93%"><label for="observacion"></label>
      <textarea name="observacion" id="observacion" cols="180" rows="2" class="areatexto"></textarea></td>
    <td width="7%">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="submit" name="Guardar" id="Guardar" value="Enviar" />
      <input type="reset" name="Cancelar" id="Cancelar" value="Restablecer" />
      <input type="hidden" name="tipo_activo" id="tipo_activo" value="<?    echo $tipo_activo  ?>" /></td>
    <td>&nbsp;</td>
  </tr>
    </table>
</td>
  </tr>
</table>
</td>
    <td width="12%" valign="top"><table width="100%" border="1" bordercolor="#D3D3D3" rules="all" cellspacing="0">
      <tr>
        <td id="qr" name="qr"></td>
      </tr>
      <tr>
        <td height="140">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none");
</script>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
</script>
<script type="text/javascript">
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
</script>
<script type="text/javascript">
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
</script>
<script type="text/javascript">
var spryselect4 = new Spry.Widget.ValidationSelect("spryselect4");
</script>
    
    
    </table>
<script type="text/javascript">
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
</script>
</body>
</html>
