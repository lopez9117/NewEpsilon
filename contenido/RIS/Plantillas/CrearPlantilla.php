<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script src="../../../js/jquery.js"></script>
<script src="../../../js/ui/jquery.ui.core.js"></script>
<script src="../../../js/ui/jquery.ui.widget.js"></script>
<script src="../../../js/ui/jquery.ui.datepicker.js"></script>
<script language="JavaScript" type="text/javascript" src="../javascript/ajax.js"></script>
<script src="../../../js/jquery.form.js"></script>
<link href="../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css">
<link href="../styles/forms.css" rel="stylesheet" type="text/css">
<script>
$(function() {
	$( "#tabs" ).tabs();
});
$(function() {
$( ".datepicker" ).datepicker({
  	changeMonth: true,
    changeYear: true
});
});
</script>
<title>Agendar Cita</title>
<head>
<body onblur="validar()" onfocus="validar()">
<table width="99%">
<tr>
	<td>
        <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Registrar Plantillas</a></li>
        </ul>
        <div id="tabs-1"><?php include("Especialistas.php");?></div>
        </div> 
    </td>
	</tr>
</table>
</div>
</body>
</html>