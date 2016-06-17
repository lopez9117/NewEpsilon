<?php
	include("../../../dbconexion/conexion.php");
	$cn = conectarse();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Toma de Estudios :.</title>
<script src="../../../js/ajax.js"></script>
<script src="../../../js/jquery-1.9.1.js"></script>
<script src="../../../js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript" language="javascript" src="../javascript/ajax.js"></script>
<link href="../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css" />
<link href="../styles/forms.css" rel="stylesheet" type="text/css">
<style type="text/css">
body
{font-family:Arial, Helvetica, sans-serif;
font-size:10px;}
fieldset
{width:90%;
}
</style>
<script>
$(function() {
	$( "#tabs" ).tabs();
});
//validar formulario
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
}) ;
//buscador
$(function(){
	$('#especialista').autocomplete({
	   source : 'ajax.php',
	   select : function(event, ui){
		   $('#resultados').slideUp('slow', function(){
		   });
		   $('#resultados').slideDown('slow');
	   }
	});
});

</script>
</head>
<body>
<div style="width:99%; margin-top:0.5%;">
    <div id="tabs">
    <ul>
    <li><a href="#tabs-1">Especialistas</a></li>
    </ul>
    <div id="tabs-1">
        <form name="busqueda" id="busqueda" method="post" action="InfoEspecialista.php">
        <table width="100%" align="center">
        <tr>
        <td width="70%"><strong>N° documento / Nombre del especialista: <br></strong>
        <input name="especialista" id="especialista" type="text" style="font-size:12px; width:450px; height:15px;" onkeyup="this.value=this.value.toUpperCase()" />
        <input type="submit" name="continuar" id="continuar" value="Continuar" onclick="resultados()"/></td>
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