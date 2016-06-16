<?php
	include("../../../dbconexion/conexion.php");
	$cn = conectarse();
	include("../select/selects.php");
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
$(function() {
	$( "#tabs" ).tabs();
});
//ejecutar consulta
function validar()
	{
		paciente = document.busqueda.paciente.value;
		if(paciente!="")
		{
			$(document).ready(function(){
		verlistado()
			//CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO
	})
		function verlistado(){ //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
			var randomnumber=Math.random()*11;
			$.post("ValidateRegInforme.php?paciente="+paciente+"", {
				randomnumber:randomnumber
			}, function(data){
			  $("#ListaPacientes").html(data);
			});
		}
		}
	}
//buscador
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
</script>
</head>
<body>
<div style="width:99%; margin-top:0.5%;">
    <div id="tabs">
    <ul>
    <li><a href="#tabs-1">Buscar estado de informe</a></li>
    </ul>
    <div id="tabs-1">
        <form name="busqueda" id="busqueda" method="post">
        <table width="100%" align="center">
        <tr>
        <td width="70%"><strong>N° documento / Nombre del paciente: <br></strong>
        <input name="paciente" id="paciente" type="text" style="font-size:12px; width:450px; height:15px;" onkeyup="this.value=this.value.toUpperCase()" />
        <input type="button" name="continuar" id="continuar" value="Continuar" onclick="validar()"/></td>
        <td width="30%" id="respuesta"></td>
        </tr>
        </table>
        </form>  
        <div id="ListaPacientes" style="width:99%; margin-top:0.5%;"></div>
    </div>
    </div>
</div>
<?php mysql_close($cn); ?>
</body>
</html>