<script>
function ListadoGeneral()
{
	//declarar variables
	var fechaDesde, fechaHasta, usuario;
	Form = document.ListadoPendientesGeneral;
	fechaDesde = Form.fechaDesde.value;
	fechaHasta = Form.fechaHasta.value;
	usuario = Form.usuario.value;
	//document.getElementById('notificacion').innerHTML = "";
	$(document).ready(function(){
	verlistadoGeneral()
		//CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO
})
	function verlistadoGeneral(){ //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
		var randomnumber=Math.random()*11;
		$.post("ListadoPendientesPorLecturaGeneral.php?fechaHasta="+fechaHasta+"&fechaDesde="+fechaDesde+"&usuario="+usuario+"", {
			randomnumber:randomnumber
		}, function(data){
		  $("#ListadoGeneral").html(data);
		});
	}
}
</script>
<body>
<form name="ListadoPendientesGeneral" id="ListadoPendientesGeneral" method="post">
<table width="100%">
    <tr bgcolor="#E1DFE3">
        <td width="15%"><strong>Desde</strong></td>
        <td width="15%"><strong>Hasta</strong></td>
        <td width="22%">&nbsp;</td>
        <td width="22%">&nbsp;</td>
        <td width=""><span class="asterisk">
        <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>"></span></td>
    </tr>
    <tr>
        <td><input type="text" name="fechaDesde" class="calendar" value="<?php echo $nuevafecha;?>" onChange="ListadoGeneral()" readonly /><span class="asterisk">*</span></td>
        <td><input type="text" name="fechaHasta" class="calendar" value="<?php echo $hoy;?>" onChange="ListadoGeneral()" readonly /><span class="asterisk">*</span></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td><div id="ListadoGeneral"></div></td>
    </tr>
</table>
</form>