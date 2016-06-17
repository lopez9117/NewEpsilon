<?php

	require_once("../../../../dbconexion/conexion.php");
	$cn = conectarse();
?>
<script type="text/javascript" language="javascript" src="../../javascript/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../../javascript/ajax.js"></script>
<link type="text/css" href="../../styles/demo_table.css" rel="stylesheet" />
<script>
function Estudio()
{
	var fecha, usuario,fechahasta;
	fecha = document.VerEstudios.fecha.value;
	usuario = document.VerEstudios.usuario.value;
	fechahasta = document.VerEstudios.fechahasta.value;
	$(document).ready(function(){
	verlistado()
		//CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO
	})
	function verlistado(){ //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
		var randomnumber=Math.random()*11;
		$.post("ListaLeidos.php?fecha="+fecha+"&fechahasta="+fechahasta+"&usuario="+usuario+"", {
			randomnumber:randomnumber
		}, function(data){
		  $("#result").html(data);
		});
	}
}
</script>
<form name="VerEstudios" id="VerEstudios" method="post" action="">
  <table width="100%">
    <tr bgcolor="#E1DFE3">
      <td colspan="1">Fecha</td>
      <td colspan="3">Fecha</td>
    </tr>
    <tr>
      <td width="15%"><label for="fecha"></label>
      <input type="text" id="datepicker3" name="fecha" readonly value="<?php 
echo date("m/d/Y");
?>" onChange="Estudio()"/><span class="asterisk">*</span></td>
      <td width="22%"><label for="fechahasta"></label>
      <input type="text" id="datepicker4" name="fechahasta" readonly value="<?php 
echo date("m/d/Y");
?>" onChange="Estudio()"/><span class="asterisk">*</span></td>
      <td width="22%"><label for="usuario"></label>
      <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>"></td>
      <td><div id="respuesta"></div></td>
    </tr>
  </table>
  <table width="100%">
<tr>
<td><div id="result"></div></td>
</tr>
</table>
</form>