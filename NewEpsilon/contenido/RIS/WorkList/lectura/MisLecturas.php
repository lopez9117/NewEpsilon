<script>
function misEstudios()
{
	var usuario;
	usuario = document.VerMisEstudios.usuario.value;
	$(document).ready(function(){
	verlistado()

	})
	function verlistado(){
		var randomnumber=Math.random()*11;
		$.post("MiListaLeidos.php?usuario="+usuario+"", {
			randomnumber:randomnumber
		}, function(data){
		  $("#resultado").html(data);
		});
	}
}
</script>
<form name="VerMisEstudios" id="VerMisEstudios" method="post" action="">
<input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>"></td>
<table width="100%">
	<tr>
		<td><div id="resultado"></div></td>
	</tr>
</table>
	<div id="resp"></div>
</form>