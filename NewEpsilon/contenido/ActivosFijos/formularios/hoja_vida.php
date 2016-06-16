<?php
include("../../../dbconexion/conexion.php");
	include("selects.php");
$activo=$_GET[id];
$consulta="SELECT * FROM hoja_vida WHERE codigo='$activo'";
    $resultado=mysql_query($consulta) or die (mysql_error());
	$cn = conectarse(); 
	$fecha=date("Y/m/d");
	$listado=mysql_query("SELECT h.fecha_elaboracion,h.codigo,h.nombre_generico,h.descripcion,h.marca,h.modelo,h.localizacion,h.observaciones FROM hoja_vida h WHERE codigo='$activo'",$cn);
$reg4= mysql_fetch_array($listado);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prodiagnostico S.A</title>
<link href="../../../css/default.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../js/ajax.js"></script>
<style type="text/css">
body {
	margin-left: 10px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	overflow-x: hidden;
}
body,td,th {
	font-size: 12px;
}
</style>
<body topmargin="0">
<tr>
  <td align="left" valign="middle">
		<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a href="../../../includes/main_menu.php">MEN&Uacute; PRINCIPAL</a></span> &gt;&nbsp;<a href="main_menu_activosfijos.php">Activos Fijos</a><span class="class_cargo" style="font-size:14px"> &gt;Ingreso activos</span></span>
	</div>
	
    
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<?php
if (mysql_num_rows($resultado)>0) {
?>
<form action="../update_hoja_vida.php" method="post" enctype="multipart/form-data" name="Newregistro" id="Newregistro">
</br>
</br>
<table width="100%" border="0" cellspacing="0">
  <tr>
    <td valign="top" align="left" bgcolor="#DEDEDE"><table width="100%" cellspacing="0">
  <tr>
    <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="0">
  <tbody>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      </tr>
    <tr>
    <td width="24%" align="left"><strong>Codigo:</strong></td>
    <td width="40%" align="left"><strong>Descripci&oacute;n</strong></td>
    <td width="36%" align="left"><strong>Nombre Generico</strong></td>
    </tr>
</tbody></table></td>
  </tr>
  <tr>
    <td id="consulta"><table width="100%" border="0" cellspacing="0">
  <tbody><tr>
    <td width="24%" align="left"><label for="tipo_documento"></label>
      <label for="ndocumento"></label>
      <span id="sprytextfield1">
        <input name="codigo" type="text" class="tsmall" id="codigo" value="<? echo $activo;      ?>" readonly="readonly" />
        <span class="textfieldRequiredMsg">*</span></span></td>
    <td width="40%" align="left"><label for="prinombre"></label>
      <label for="descripcion"></label>
      <textarea name="descripcion" cols="39" rows="2" id="descripcion"><?php echo $reg4['descripcion']; ?></textarea>
  <label for="segnombre"></label></td>
    <td width="36%" align="left">
      <input name="nombre_generico" type="text" class="tsmall" id="nombre_generico" value="<?php echo $reg4['nombre_generico']; ?>" />
      <label for="segapellido"></label></td>
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
    <td width="26%" align="left"><strong>Marca</a></strong></td>
    <td width="25%" align="left"><strong>Modelo</strong></td>
    <td width="24%" align="left"><strong>Localizaci&oacute;n</strong></td>
    <td width="25%" align="left"><strong>Fecha de realizacion</strong></td>
    </tr>
</tbody></table></td>
  </tr>
  <tr>
    <td id="consulta1"><table width="100%" border="0" cellspacing="0">
  <tbody><tr>
    <td width="13%" align="left"><label for="fechanacimiento">
      <input name="marca2" type="text" class="tlarge" id="marca2" value="<?php echo $reg4['modelo']; ?>" />
    </label></td>
    <td width="13%" align="left"><label for="eps"></label>
      <label for="centro">
        <input name="modelo2" type="text" id="modelo2" value="<?php echo $reg4['marca']; ?>" />
      </label></td>
<td width="11%" align="left"><label for="fechaHoraCita"></label>
  <label for="localizacion"><strong>
    <select name="localizacion2" id="localizacion2">
      <option>.:Seleccione:.</option>
      <?php
            	while($reg = mysql_fetch_array($listaSedeActiva))
				{
				?>
                <option value="<?php echo $reg[idsede]?>"
                <?php
                	if($reg[idsede]==$reg3[sede])
					{
				?>
                 selected="selected"
					<?php
					}
					?>
                    >
				<?php echo $reg[descsede]?></option>
				<?php
				}
			?>
    </select>
  </strong></label></td>
<td width="13%" align="left"><label for="fecha"></label>
  <input name="fecha" type="text" id="fecha" value="<?php echo $reg4['fecha_elaboracion']; ?>" readonly="readonly" /></td>
</tr>
    <tr>
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
          <td width="13%" align="left"><strong>&nbsp;Observaci&oacute;n</strong></td>
          <td width="17%" align="left">&nbsp;</td>
          <td width="10%" align="left">&nbsp;</td>
          <td width="16%" align="left">&nbsp;</td>
          <td width="44%" align="left">&nbsp;</td>
          </tr>
        </tbody></table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0">
      <tr>
        <td width="93%"><label for="observacion"></label>
          <textarea name="observacion" id="observacion" cols="180" rows="2" class="areatexto"><?php echo $reg4['observaciones']; ?></textarea></td>
        <td width="7%">&nbsp;</td>
        </tr>
      <tr>
        <td><input type="submit" name="Guardar" id="Guardar" value="Enviar" />
          <input type="reset" name="Cancelar" id="Cancelar" value="Restablecer" /></td>
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
<?php
}
else
{ 
?>
<form action="../insert_hoja_vida.php" method="post" enctype="multipart/form-data" name="Newregistro" id="Newregistro">
</br>
</br>
<table width="100%" border="0" cellspacing="0">
  <tr>
    <td valign="top" align="left" bgcolor="#DEDEDE"><table width="100%" cellspacing="0">
  <tr>
    <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="0">
  <tbody>
    <tr>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
    <tr>
      <td width="25%" align="left"><strong>Codigo:</strong></td>
      <td width="40%" align="left"><strong>Descripci&oacute;n</strong></td>
      <td width="35%" align="left"><strong>Nombre Generico</strong></td>
    </tr>
</tbody></table></td>
  </tr>
  <tr>
    <td id="consulta"><table width="100%" border="0" cellspacing="0">
  <tbody><tr>
    <td width="25%" align="left"><label for="tipo_documento"></label>
      <label for="ndocumento"></label>
      <span id="sprytextfield1">
        <input name="codigo" type="text" class="tsmall" id="codigo" value="<? echo $activo;      ?>" readonly="readonly" />
        <span class="textfieldRequiredMsg">*</span></span></td>
    <td width="40%" align="left"><label for="prinombre"></label>
      <label for="descripcion"></label>
      <textarea name="descripcion" cols="39" rows="2" id="descripcion"><?php echo $reg4['desc_activo']; ?></textarea>
  <label for="segnombre"></label></td>
    <td width="35%" align="left">
      <input name="nombre_generico" type="text" class="tsmall" id="nombre_generico" />
      <label for="segapellido"></label></td>
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
    <td width="26%" align="left"><strong>Marca</a></strong></td>
    <td width="25%" align="left"><strong>Modelo</strong></td>
    <td width="24%" align="left"><strong>Localizaci&oacute;n</strong></td>
    <td width="25%" align="left"><strong>Fecha de realizacion</strong></td>
    </tr>
</tbody></table></td>
  </tr>
  <tr>
    <td id="consulta1"><table width="100%" border="0" cellspacing="0">
  <tbody><tr>
    <td width="13%" align="left"><label for="fechanacimiento">
      <input name="marca2" type="text" class="tlarge" id="marca2"/>
    </label></td>
    <td width="13%" align="left"><label for="eps"></label>
      <label for="centro">
        <input name="modelo2" type="text" id="modelo2"/>
      </label></td>
<td width="11%" align="left"><label for="fechaHoraCita"></label>
  <label for="localizacion"><strong>
    <select name="localizacion2" id="localizacion2">
      <option>.:Seleccione:.</option>
      <?php
            	while($reg = mysql_fetch_array($listaSedeActiva))
				{
				?>
                <option value="<?php echo $reg[idsede]?>"
                <?php
                	if($reg[idsede]==$reg3[sede])
					{
				?>
                 selected="selected"
					<?php
					}
					?>
                    >
				<?php echo $reg[descsede]?></option>
				<?php
				}
			?>
    </select>
  </strong></label></td>
<td width="13%" align="left"><label for="fecha"></label>
  <input name="fecha" type="text" id="fecha" value="<? echo $fecha;      ?>" readonly="readonly"/></td>
</tr>
    <tr>
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
          <td width="13%" align="left"><strong>&nbsp;Observaci&oacute;n</strong></td>
          <td width="17%" align="left">&nbsp;</td>
          <td width="10%" align="left">&nbsp;</td>
          <td width="16%" align="left">&nbsp;</td>
          <td width="44%" align="left">&nbsp;</td>
          </tr>
        </tbody></table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0">
      <tr>
        <td width="93%"><label for="observacion"></label>
          <textarea name="observacion" id="observacion" cols="180" rows="2" class="areatexto"><?php echo $reg4['observaciones']; ?></textarea></td>
        <td width="7%">&nbsp;</td>
        </tr>
      <tr>
        <td><input type="submit" name="Guardar" id="Guardar" value="Enviar" />
          <input type="reset" name="Cancelar" id="Cancelar" value="Restablecer" /></td>
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
<?
}
?>

<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
    
</body>
</html>
