<?php
	require_once("../../../dbconexion/conexion.php");
	$cn = conectarse();
	$usuario = $_GET['usuario'];
?>
<!DOCTYPE html>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Toma de Estudios :.</title>
<script src="../../../js/ajax.js"></script>
<script src="../../../js/jquery-1.9.1.js"></script>
<script src="../../../js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript" language="javascript" src="../javascript/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../javascript/ajax.js"></script>
<script src="../../Solicitudes/bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../../Solicitudes/bootstrap-3.3.2-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../../Solicitudes/bootstrap-3.3.2-dist/css/bootstrap-theme.min.css">
<link type="text/css" href="../styles/demo_table.css" rel="stylesheet" />
<link href="../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css" />
<link href="../../../css/default.css" rel="stylesheet" type="text/css">

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
       <div class="row">
        <div class="col-sm-8" >
        <label>Nº Documento/Nombre Paciente</label>
        <input name="paciente" placeholder="Nº Documento/Nombre Paciente" id="paciente" type="text" class="form-control" onkeyup="this.value=this.value.toUpperCase()"/>
        </div>
        <div class="col-sm-4"><br>
        <button type="submit" name="continuar" id="continuar" value="Buscar" class="btn-sm btn-primary"/>Buscar</button>
        </div>
        </div>
        </form> 
        <div id="contenido"></div>    
    </div>
    </div>
</div>
</body>
</html>