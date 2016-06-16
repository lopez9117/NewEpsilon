<?php

	require_once("../../../../dbconexion/conexion.php");
	$cn = conectarse();
?>
<script type="text/javascript" language="javascript" src="../../javascript/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../../javascript/ajax.js"></script>
<link type="text/css" href="../../styles/demo_table.css" rel="stylesheet" />
<script>
function misEstudios()
{
		
	var fecha, usuario;
	fecha = document.VerMisEstudios.fecha.value;
	usuario = document.VerMisEstudios.usuario.value;

	$(document).ready(function(){
	verlistado()
		//CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO
	})
	function verlistado(){ //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
		var randomnumber=Math.random()*11;
		$.post("MiListaTranscripciones.php?fecha="+fecha+"&usuario="+usuario+"", {
			randomnumber:randomnumber
		}, function(data){
		  $("#resultado").html(data);
		});
	}
}
</script>
<body onLoad="misEstudios()">
<form name="VerMisEstudios" id="VerMisEstudios" method="post" action="">
  <table width="100%">
    <tr bgcolor="#E1DFE3">
      <td colspan="4">Fecha</td>
    </tr>
    <tr>
      <td width="15%"><label for="fecha"></label>
      <input type="text" id="datepicker2" name="fecha" class="texto" value="<?php 
echo date("m/d/Y");
?>" onChange="misEstudios()"/><span class="asterisk">*</span></td>
      <td width="22%"><div id="respuesta"></div></td>
      <td width="22%"><label for="usuario"></label>
      <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <table width="100%">
<tr>
<td><div id="resultado"></div></td>
</tr>
</table>
</form>