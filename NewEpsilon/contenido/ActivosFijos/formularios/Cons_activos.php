<?php
	//conexion a la BD
	
	require_once("../../../dbconexion/conexion.php");
	$cn = Conectarse();
	include("selects.php");
	$activo=$_REQUEST[codigo];
	$consulta="SELECT * FROM activo_fijo WHERE codigo='$activo'";
    $resultado=mysql_query($consulta) or die (mysql_error());
	$cn = conectarse(); 
if (mysql_num_rows($resultado)>0) {
	
	//listar sedes del registro del activo
$lista = mysql_query("SELECT codigo,sede FROM activo_fijo WHERE codigo='$activo'", $cn);
$reg3= mysql_fetch_array($lista);
//listar propiedad del activo segun activo
$lista2 = mysql_query("SELECT codigo,propiedad FROM activo_fijo WHERE codigo='$activo'", $cn);
$reg6= mysql_fetch_array($lista2);
//listar adquicicion segun activo
$lista3 = mysql_query("SELECT codigo,adquicicion FROM activo_fijo WHERE codigo='$activo'", $cn);
$reg7= mysql_fetch_array($lista3);
//listar asegurado segun activo
$lista4 = mysql_query("SELECT codigo,idaseguradora FROM activo_fijo WHERE codigo='$activo'", $cn);
$reg8= mysql_fetch_array($lista4);
//listar aseguradora segun activo
$lista5 = mysql_query("SELECT codigo,idaseguradora FROM activo_fijo WHERE codigo='$activo'", $cn);
$reg9= mysql_fetch_array($lista5);
//listar desc hoja de vida segun activo
$lista7 = mysql_query("SELECT codigo,desc_hoja_vida FROM activo_fijo WHERE codigo='$activo'", $cn);
$reg11= mysql_fetch_array($lista7);
$lista8 = mysql_query("SELECT codigo,tipo_depreciacion FROM activo_fijo WHERE codigo='$activo'", $cn);
$reg12= mysql_fetch_array($lista8);
$listahojavida = mysql_query("SELECT * FROM desc_hoja_vida", $cn);
//listado responsable segun activo
	$listado2=mysql_query("SELECT codigo,responsable FROM activo_fijo  where codigo='$activo'",$cn);
	//listado de activo
$reg2= mysql_fetch_array($listado2);
	$listado=mysql_query("SELECT ac.codigo,ac.desc_activo,ac.cantidad,ac.marca,ac.modelo,ac.serie,ac.responsable,ac.centro_costos,ac.sede,ac.fecha_compra,ac.tiempo_depreciacion,ac.propiedad,ac.adquicicion,ac.url_adquicicion,ac.idaseguradora,ac.vencimiento_garantia,ac.url_hoja_vida,ac.contrato_mantenimiento,ac.contrato_calibracion,ac.observaciones,ac.desc_hoja_vida,f.nombres,f.apellidos,ac.Valor_activo,ac.cuota FROM activo_fijo ac INNER JOIN funcionario f ON f.idfuncionario= ac.responsable WHERE codigo='$activo'",$cn);
$reg4= mysql_fetch_array($listado);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prodiagnostico S.A</title>
<script src="../../../js/jquery.js"></script>
  <script src="../../../js/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
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
	 opcion=document.Newregistro.adquicicion.value;
	 if (opcion==1)
	 {
  document.Newregistro.cuota.disabled = true;
  document.Newregistro.tipo_cuota.disabled=true;
	 }else
	 {		 
  document.Newregistro.cuota.disabled = false;
  document.Newregistro.tipo_cuota.disabled=false;
		 }
 }
  </script>
<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../../css/default.css" rel="stylesheet" type="text/css">
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
<link href="../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>
<body topmargin="0">
<tr><td align="left" valign="middle">
		<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a href="../../../includes/main_menu.php">MEN&Uacute; PRINCIPAL</a></span> &gt;&nbsp;<a href="main_menu_activosfijos.php">Activos Fijos</a><span class="class_cargo" style="font-size:14px"> &gt;Ingreso activos</span></span></br></br></br>
</head>

<form action="../update_activo.php" method="post" enctype="multipart/form-data" name="Newregistro" id="Newregistro">
<table width="100%" border="0" cellspacing="0">
  <tr>
    <td valign="top" align="left" bgcolor="#DEDEDE"><table width="100%" cellspacing="0">
  <tr>
    <td bgcolor="#CCCCCC"><table width="100%" border="0" cellspacing="0">
  <tbody>
    <tr>
      <td align="left"></td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
      <td align="left"></td>
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
      <input name="codigo" type="text" class="tsmall" id="codigo" value="<? echo $activo;      ?>" readonly="readonly" />
      <span class="textfieldRequiredMsg">*</span></span></td>
    <td width="23%" align="left"><label for="prinombre"></label>
      <label for="descripcion"></label>
      <textarea name="descripcion" cols="39" rows="2" id="descripcion"><?php echo $reg4['desc_activo']; ?></textarea>
<label for="segnombre"></label></td>
    <td width="13%" align="left"><label for="priapellido"></label>
      <input name="cantidad" type="text" class="tsmall" id="cantidad" value="<?php echo $reg4['cantidad']; ?>" />
      <label for="segapellido"></label></td>
    <td width="13%" align="left"><label for="norden"></label>
      <input name="marca" type="text" class="tlarge" id="marca" value="<?php echo $reg4['modelo']; ?>" /></td>
    <td width="13%" align="left"><label for="modelo"></label>
      <input name="modelo" type="text" id="modelo" value="<?php echo $reg4['marca']; ?>" /></td>
    <td width="25%" align="left"><label for="serie"></label>
      <input name="serie" type="text" id="serie" value="<?php echo $reg4['serie']; ?>" /></td>
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
      <td width="27%" align="left"><strong>Responsable</strong></td>
      <td width="18%" align="left"><strong>Centro de Costos</strong></td>
      <td width="15%" align="left"><strong>Localizaci&oacute;n</strong></td>
      <td width="15%" align="left"><strong>Fecha de Compra</strong></td>
      <td width="25%" align="left"><strong>Tiempo de depreciaci&oacute;n</strong></td>
    </tr>
</tbody></table></td>
  </tr>
  <tr>
    <td id="consulta1"><table width="100%" border="0" cellspacing="0">
  <tbody><tr>
    <td width="13%" align="left"><label for="fechanacimiento"></label>
      <label for="responsable">
        <select name="responsable" id="responsable">
          <option value="">.: Seleccione :.</option>
            <?php
            	while($reg = mysql_fetch_array($listafuncionario))
				{
				?>
                <option value="<?php echo $reg[idfuncionario]?>"
                <?php
                	if($reg[idfuncionario]==$reg2[responsable])
					{
				?>
                 selected="selected"
					<?php
					}
					?>
                    >
				<?php echo $reg[nombres].$reg[apellidos]?></option>
				<?php
				}
			?>
          </select>
      </label></td>
    <td width="13%" align="left"><label for="eps"></label>
      <label for="centro"></label>
      <input name="centro" type="text" id="centro" value="<?php echo $reg4['centro_costos']; ?>" /></td>
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
  <input name="fecha" type="text" id="datepicker" class="fecha" value="<?php echo $reg4['fecha_compra']; ?>" /></td>
<td width="26%" align="left"><label for="tiempo_depreciacion"></label>
  <input name="tiempo_depreciacion" type="text" id="tiempo_depreciacion" value="<?php echo $reg4['tiempo_depreciacion']; ?>" />
  <label for="tipo_adquicicion"></label>
  <select name="tipo_depreciacion" id="tipo_depreciacion">
  <option>.:Seleccione:.</option>
      <?php
            	while($reg = mysql_fetch_array($listatiempodepreciacion))
				{
				?>
                <option value="<?php echo $reg[idsede]?>"
                <?php
                	if($reg[id_depreciacion]==$reg12[tipo_depreciacion])
					{
				?>
                 selected="selected"
					<?php
					}
					?>
                    >
				<?php echo $reg[desc_depreciacion]?></option>
				<?php
				}
			?>
    </select></td>
   </tr>
    <tr>
      <td align="left"></td>
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
      <td width="12%" align="left"><strong>Propiedad</strong></td>
      <td width="10%" align="left"><strong>Tipo de Adquicici&oacute;n</strong></td>
      <td width="11%" align="left"><strong>Aseguradora
        <input type="checkbox" name="asegurado" id="asegurado" onclick="document.Newregistro.idaseguradora.disabled=!document.Newregistro.idaseguradora.disabled" />
        <label for="asegurado"></label>
      </strong></td>
      <td width="13%" align="left"><strong>Fecha Vencimiento Garantia
        
        <label for="garantia"></label>
      </strong></td>
      <td width="11%" align="left"><strong>Hoja de Vida</strong></td>
      <td width="13%" align="left"><strong>Valor Activo</strong></td>
      <td width="13%" align="left"><strong>Cuota/Canon</strong></td>
      </tr>
</tbody></table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0">
  <tbody><tr>
    <td width="11%" align="left"><label for="sede"></label>
      <select name="propiedad" id="propiedad" class="select">
        <option>.:Seleccione:.</option>
        <?php
            	while($reg = mysql_fetch_array($listadopropiedad))
				{
				?>
                <option value="<?php echo $reg[id_propiedad]?>"
                <?php
                	if($reg[id_propiedad]==$reg6[propiedad])
					{
				?>
                 selected="selected"
					<?php
					}
					?>
                    >
				<?php echo $reg[desc_propiedad]?></option>
				<?php
				}
			?>
      </select></td>
    <td width="11%" align="left"><label for="servicio"></label>
      <select name="adquicicion" id="adquicicion" class="select" onchange="activar()">
        <option>.:Seleccione:.</option>
      <?php
            	while($reg = mysql_fetch_array($listadoadquicicion))
				{
				?>
                <option value="<?php echo $reg[id_adquicicion]?>"
                <?php
                	if($reg[id_adquicicion]==$reg7[adquicicion])
					{
				?>
                 selected="selected"
					<?php
					}
					?>
                    >
				<?php echo $reg[tipo]?></option>
				<?php
				}
			?>
      </select></td>
    <td width="11%" align="left"><select name="idaseguradora" id="idaseguradora" disabled="disabled">
      <option>.:Seleccione:.</option>
      <?php
            	while($reg = mysql_fetch_array($listadoasegurado))
				{
				?>
      <option value="<?php echo $reg[id]?>"
                <?php
                	if($reg[id]==$reg8[idaseguradora])
					{
				?>
                 selected="selected"
					<?php
					}
					?>
                    >
        <?php echo $reg[aseguradora]?></option>
      <?php
				}
			?>
    </select></td>
     <td width="13%" align="left"><input name="vencimiento_garantia" type="text" id="datepicker1" value="<?php echo $reg4['vencimiento_garantia']; ?>"/></td>
     <td width="11%" align="left"><label for="hoja?vida"></label>
       <select name="hoja_de_vida" id="hoja_de_vida">
       <option>.:Seleccione:.</option>
         <?php
            	while($reg = mysql_fetch_array($listahojavida))
				{
				?>
                <option value="<?php echo $reg[id]?>"
                <?php
                	if($reg[id]==$reg11[desc_hoja_vida])
					{
				?>
                 selected="selected"
					<?php
					}
					?>
                    >
				<?php echo $reg[desc_hoja_vida]?></option>
				<?php
				}
			?>
       </select></td>
     <td width="13%" align="left"><label for="valor"></label>
       <input name="valor" type="text" id="valor" value="<?php echo $reg4['Valor_activo']; ?>" /></td>
     <td width="13%" align="left"><label for="cuota"></label>
       <input name="cuota" type="text" disabled="disabled" id="cuota" value="<?php echo $reg4['cuota']; ?>"/></td>
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
      <input type="file" name="archivo_adquicicion" id="archivo_adquicicion"/>
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
    <td>
  <tr>
    <td width="93%"><label for="observacion"></label>
      <textarea name="observacion" id="observacion" rows="2" cols="180" class="areatexto"><?php echo $reg4['observaciones']; ?></textarea></td>
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
</form>
<?php
}
	else
	{?>
		<script type="text/javascript">
		alert ("El codigo que intenta ingresar no existe en el inventario.");
window.location="codigo.php";
</script>';
<?php
		}
	
	
?>
</body>
</html>