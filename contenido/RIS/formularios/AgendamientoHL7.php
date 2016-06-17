<?php
	$sede = $_GET['sede'];
	$usuario = $_GET['usuario'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
<script src="../../../js/jquery.js"></script>
<script src="../../../js/ui/jquery.ui.core.js"></script>
<script src="../../../js/ui/jquery.ui.widget.js"></script>
<script src="../../../js/ui/jquery.ui.datepicker.js"></script>
<script src="../js/timepicker.js"></script>
<script language="JavaScript" type="text/javascript" src="../javascript/ajax.js"></script>
<script src="../../../js/jquery.form.js"></script>
<link href="../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css">
<link href="../styles/forms.css" rel="stylesheet" type="text/css">
<script>
$(function() {
    $( "#tabs" ).tabs({
      beforeLoad: function( event, ui ) {
        ui.jqXHR.error(function() {
          ui.panel.html(
            "Lo sentimos, no es posible cargar el contenido en este momento. " +
            "Por favor contacte el personal de sistemas." );
        });
      }
    });
  });
// classs for datepicker
$(function() {
$( "#datepicker" ).datepicker({
  changeMonth: true,
    changeYear: true
});
    $( "#datepicker1" ).datepicker({
        changeMonth: true,
        changeYear: true
    });
});
</script>

<head>
<body>
<table width="99%">
<tr>
  <td>
         <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Agendamiento</a></li>
              </ul>
   <div id="tabs-1"><?php require_once("AsignarAgendaHL7.php") ?></div>
        		 
        </td>
    </tr>
</table>
</div>
</body>
</html>