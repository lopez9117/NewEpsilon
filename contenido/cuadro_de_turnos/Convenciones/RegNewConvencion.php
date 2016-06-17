<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Nueva convencion :. -  Prodiagnostico S.A</title>
<script type="text/javascript" src="../../../js/jquery-1.7.1.js"></script>
<script type="text/javascript" src="../../../js/ajax.js"></script>
<script type="text/javascript" src="../../../js/lib/base.js"></script>
<script type="text/javascript" src="../../../js/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="../../../js/jquery.timepicker.css" />
<link rel="stylesheet" type="text/css" href="../../../../js/lib/base.css" />
<script language='javascript'>
$(document).ready(function() {
   // Interceptamos el evento submit
    $('#form, #fat, #NewConvencion').submit(function() {
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
});
$(function() {
$('.hora').timepicker({ 'timeFormat': 'H:i' });
});
</script>
<style type="text/css">
body
{font-family:Arial, Helvetica, sans-serif;
font-size:12px;}
fieldset
{width:90%;
margin-left:3%;
}
#input
{width:100px;
}
#button
{font-size:11px;
}
</style>
</head>
<body>
<form id="NewConvencion" name="NewConvencion" method="post" action="InsertConvencion.php">
<fieldset>
	<legend><strong>Registrar nueva convención para cuadro de turnos</strong></legend>
    <table width="100%" border="0">
      <tr>
        <td width="33%"><strong>Hora de inicio</strong></td>
        <td width="33%"><strong>Hora de finalizaci&oacute;n</strong></td>
        <td width="33%"><strong>Alias</strong></td>
      </tr>
      <tr>
        <td><label for="horaInicio"></label>
        <input type="text" name="horaInicio" id="input" class="hora" /></td>
        <td><label for="horaFinalizacion"></label>
        <input type="text" name="horaFinalizacion" id="input" class="hora" /></td>
        <td><label for="alias"></label>
        <input type="text" name="alias" id="input" onkeyup="this.value=this.value.toUpperCase()" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" id="notificacion">&nbsp;</td>
        <td><input type="submit" name="crear" id="button" value="Crear" />
        <input type="reset" name="button" id="button" value="Restaurar" /></td>
      </tr>
    </table>
</fieldset>
</form>
</body>
</html>