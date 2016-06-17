<?php
header("Cache-Control: no-cache");
header("Pragma: no-cache");
$sede = $_GET['sede'];
$usuario = $_GET['usuario'];
include("../../../dbconexion/conexion.php");
$cn = Conectarse();
include("../select/selects.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<meta http-equiv="X-UA-Compatible" content="IE = 7, 8, 9, 10" />
<script src="../../../js/jquery.js"></script>
<script src="../../../js/ui/jquery.ui.core.js"></script>
<script src="../../../js/ui/jquery.ui.widget.js"></script>
<script src="../../../js/ui/jquery.ui.datepicker.js"></script>
<script src="../js/timepicker.js"></script>
<script language="JavaScript" type="text/javascript" src="../javascript/ajax.js"></script>
<script src="../../../js/jquery.form.js"></script>
<link href="../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css">
<link href="../styles/forms.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="../javascript/ajax.js"></script>
<script language="JavaScript" src="../../../js/jquery.js"></script>
<script src="../../../js/jquery.form.js"></script>
<script language="JavaScript" src="../js/jquery-ui-1.10.0.custom.min.js"></script>
<script type="text/javascript" language="javascript" src="../javascript/jquery.dataTables.js"></script>
<link type="text/css" href="../styles/demo_table.css" rel="stylesheet" />
<link type="text/css" href="../css/ui-lightness/jquery-ui-1.8.13.custom.css" rel="stylesheet" />
<script>
$(function() { $( "#tabs" ).tabs({ beforeLoad: function( event, ui ) { ui.jqXHR.error(function() { ui.panel.html( "Lo sentimos, no es posible cargar el contenido en este momento. " + "Por favor contacte el personal de sistemas." ); }); }}); });
//Calendario con restriccion de meses y dias anteriores Jquery
$(function() { $( "#datepicker" ).datepicker({ minDate: "-2M", maxDate: "+8M" }); });
$(function() { $( ".datepicker" ).datepicker({ changeMonth: true, changeYear: true }); });
</script>
<style type="text/css">
    .asterisk {
        color: #F00;
    }
</style>
<head>
<body onFocus="mostrarAgenda()">
<table width="99%">
    <tr>
        <td>
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Agendamiento</a></li>
                  

                </ul>
                <div id="tabs-1"><?php include("AsignarAgenda_conquis.php") ?></div>
                
              
            </div>
        </td>
    </tr>
</table>
</body>
</html>