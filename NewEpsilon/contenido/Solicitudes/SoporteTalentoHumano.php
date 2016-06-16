<?php
	//incluir archivo que contiene consultas para llenar selects
	include("../select/selects.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prodiagnostico S.A</title>
<script type="text/javascript" src="../../js/jquery.js"></script>
<link type="text/css" href="../../css/demo_table.css" rel="stylesheet" />
<link href="../../css/default.css" rel="stylesheet" type="text/css">
<link href="../../css/forms.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<script type="text/javascript" src="../../js/jquery-1.7.1.js"></script>
<script language='javascript'>
$(document).ready(function() {
   // Interceptamos el evento submit
    $('#form, #fat, #Newregistro').submit(function() {
 		// Enviamos el formulario usando AJAX
        $.ajax({
		type: 'POST',
		url: $(this).attr('action'),
		data: $(this).serialize(),
		// Mostramos un mensaje con la respuesta de PHP
		success: function(data) {
		$('#notificacion').html(data);
            }
        })
        return false;
    });
})
</script>
<script language="javascript">
	function activar()
	{
		firmarespaldo.disabled = false;
	}
	function desactivar()
	{
		firmarespaldo.disabled = true;
	}
	function copypassword()
	{
		var origen, destino;
		origen = document.Newregistro.ndocumento.value;
		//etiqueta donde se va a mostrar la respuesta
		destino = document.Newregistro.pass.value = origen;
	}
</script>
</head>
<body topmargin="0">
<table width="100%" border="0">
<tr><td align="center" valign="middle">
	<div class="marco">
	<div class="ruta">
		<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a href="../../includes/main_menu.php">MEN&Uacute; PRINCIPAL</a></span> &gt; <a href="menu/main_menu_solicitudes.php">Solicitudes</a> ></span> <span class="class_cargo" style="font-size:14px"> Solicitud Mantenimiento Sistemas</span></div>
	<table width="98%" border="0">
	<tr>
	<td colspan="2" height="7"><div style="border-bottom: #D3D3D3 2px dotted"></div><br><a href="reg_especialista.php" class="botones"><span><span>Regresar</span></span></a><br><br></td>
	</tr>
	<tr>
	<td width="30%" align="left" valign="top" bgcolor="#DEDEDE">
      <blockquote>
        <form action="insert/accion_reg_especialista.php" method="post" name="Newregistro" id="Newregistro">
        <table width="100%" aling="center">
  <tr>
    <td colspan="2" aling="center"><p>Cedula de:</p>
    </td>
  </tr>
	<tr>
	  <td colspan="2"><span id="sprytextfield1">
        <input type="text" name="de" id="de" />
        <span class="textfieldRequiredMsg">*</span></span></td>
	  </tr>
  <tr>
    <td colspan="2"><p>Cargo:</p></td>

  </tr>
  <tr>
    <td colspan="2"><span id="sprytextfield2">
      <input type="text" name="cargo" id="cargo" />
      <span class="textfieldRequiredMsg">*</span></span></td>
  </tr>
  <tr>
    <td width="53%"><p>Dia del Turno:</p></td>
    <td width="47%"><p>Por el Dia:</p></td>
  </tr>
  <tr>
    <td>      <label for="dia"></label>
      <input type="text" name="dia" id="dia" />
   </td>
    <td>      <label for="pordia"></label>
      <input type="text" name="pordia" id="pordia" />
   </td>
  </tr>
  <tr>
    <td colspan="2"><p>Compa�ero:</p></td>
  </tr>
  <tr>
    <td colspan="2"><select name="compa�ero">
      <option>.:Seleccione:.</option>
    </select></td>
  </tr>
  <tr>
    <td colspan="2"><p>Motivo:</p></td>
  </tr>
  <tr>
    <td colspan="3"><label for="cuerpo"></label>
      <textarea name="motivo" id="motivo" cols="45" rows="5"></textarea></td>
    </tr>
  <tr>
    <td colspan="2"><label for="adjunto"></label>
      <input type="file" name="adjunto" id="adjunto" /></td>
  </tr>
  <tr>
    <td colspan="3"><input type="submit" name="guardar" id="guardar" value="Enviar" />
      <input type="reset" name="restablecer" id="restablecer" value="Restablecer" /></td>
    </tr>
        </table>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
<script type="text/javascript">
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>