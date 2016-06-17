<?php
	require_once("../../../dbconexion/conexion.php");
	$cn = conectarse();
	$usuario = $_GET['usuario'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Toma de Estudios :.</title>
<script src="../../../js/ajax.js"></script>
<script src="../../../js/jquery-1.9.1.js"></script>
<script src="../../../js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript" language="javascript" src="../javascript/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../javascript/ajax.js"></script>
<link type="text/css" href="../styles/demo_table.css" rel="stylesheet" />
<link href="../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css" />
<link href="../styles/forms.css" rel="stylesheet" type="text/css">
<script>
//tabs
$(function() {
	$( "#tabs" ).tabs();
});

//buscador
function buscar()
{
	$(function(){
		$('#paciente').autocomplete({
		   source : 'buscador.php',
		   select : function(event, ui){
			   $('#resultados').slideUp('slow', function(){
			   });
			   $('#resultados').slideDown('slow');
		   }
		});
	});
}
//envio de formulario con ajax
$(document).ready(function() {
   // Interceptamos el evento submit
    $('#form, #fat, #busqueda').submit(function() {
 		// Enviamos el formulario usando AJAX
        $.ajax({
		type: 'POST',
		url: $(this).attr('action'),
		data: $(this).serialize(),
		// Mostramos un mensaje con la respuesta de PHP
		success: function(data) {
		$('#contenido').html(data);
            }
        })        
        return false;
    }); 
});
</script>
</head>
<body onload="buscar()">
<div style="width:99%; margin-top:0.5%;">
    <div id="tabs">
    <ul>
    <li><a href="#tabs-1">Resultados</a></li>
    </ul>
    <div id="tabs-1">
        <form name="busqueda" id="busqueda" method="post" action="ListadoResultadosPublicados.php">
        <table width="100%" align="center">
        <tr>
        <td width="70%"><strong>N° documento / Nombre del paciente: <br></strong>
        <input name="paciente" id="paciente" type="text" style="font-size:12px; width:450px; height:15px;" onkeyup="this.value=this.value.toUpperCase()"/>
        <input type="submit" name="continuar" id="continuar" value="Buscar"/></td>
        <td width="30%" id="respuesta"></td>
        </tr>
        </table>
        </form>  
        <div id="contenido"></div>    
    </div>
    </div>
</div>
</body>
</html>