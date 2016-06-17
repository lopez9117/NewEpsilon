<script>
function VerMisLecturas()
{
	var FechaInicio, usuario,FechaLimite;
	FechaInicio = document.VerEstudios.FechaInicio.value;
	usuario = document.VerEstudios.usuario.value;
	FechaLimite = document.VerEstudios.FechaLimite.value;
	$(document).ready(function(){
	verlistado()
	})
	function verlistado(){
		var randomnumber=Math.random()*11;
		$.post("ListaLeidos.php?FechaInicio="+FechaInicio+"&FechaLimite="+FechaLimite+"&usuario="+usuario+"", {
			randomnumber:randomnumber
		}, function(data){
		  $("#VerMisLecturas").html(data);
		});
	}
}
</script>
<form name="VerEstudios" id="VerEstudios">
<table width="100%">
    <tr bgcolor="#E1DFE3">
        <td colspan="1">Desde</td>
        <td colspan="3">Hasta</td>
    </tr>
    <tr>
        <td width="15%"><label for="fecha"></label><input type="text" class="calendar" name="FechaInicio" readonly value="<?php echo $PrimerDia; ?>" onChange="VerMisLecturas()"/></td>
        <td width="22%"><label for="fechahasta"></label><input type="text" class="calendar" name="FechaLimite" readonly value="<?php echo $hoy ?>" onChange="VerMisLecturas()"/></td>
        <td width="22%"><label for="usuario"></label><input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>"></td><td><div id="respuesta"></div></td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td><div id="VerMisLecturas"></div></td>
    </tr>
</table>
</form>