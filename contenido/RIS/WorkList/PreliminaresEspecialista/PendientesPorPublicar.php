<?php
header("Cache-Control: no-cache");
header("Pragma: no-cache");
include("../../../../dbconexion/conexion.php");
$cn = conectarse();
include("../../select/selects.php");
$usuario = $_GET['usuario'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta http-equiv="X-UA-Compatible" content="IE = 7, 8, 9, 10" />
<title>.: Pendientes por Publicar :.</title>
<script src="../../../../js/ajax.js"></script>
<script src="../../../../js/jquery-1.9.1.js"></script>
<script src="../../../../js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript" language="javascript" src="../../javascript/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../../javascript/ajax.js"></script>
<link type="text/css" href="../../styles/demo_table.css" rel="stylesheet" />
<link href="../../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css" />
<link href="../../styles/forms.css" rel="stylesheet" type="text/css">
<script>
$(function() {
	$( "#tabs" ).tabs();
});
$(function() {
$( "#datepicker" ).datepicker({
	changeMonth: true,
    changeYear: true
});
});
$(function() {
$( "#datepicker2" ).datepicker({
	changeMonth: true,
    changeYear: true
});
});
</script>
<script>
function cargarResultados()
{
	var fecha, sede, servicio;
	fecha = document.VerResultados.fecha.value;
	sede = document.VerResultados.sede.value;
	servicio = document.VerResultados.servicio.value;
	
	if(fecha=="" || sede=="" || servicio=="")
	{
		mensaje = "<font color='#FF0000'>Los campos marcados con * son obligatorios</font>";
		document.getElementById('notificacion').innerHTML = mensaje;
		document.getElementById('contenido').innerHTML = "";
	}
	else
	{	
		document.getElementById('notificacion').innerHTML = "";
		$(document).ready(function(){
		verlistado()
			//CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO
	})
		function verlistado(){ //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
			var randomnumber=Math.random()*11;
			$.post("ListadoPendientesPorPublicar.php?fecha="+fecha+"&sede="+sede+"&servicio="+servicio+"&usuario="+<?php echo $usuario ?>+"", {
				randomnumber:randomnumber
			}, function(data){
			  $("#contenido").html(data);
			});
		}
	}
}
</script>
</head>
<body onfocus="cargarResultados()">
<div style="width:99%; margin-top:0.5%;">
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">Pendientes por Publicar</a></li>
		</ul>
		<div id="tabs-1">
			<form name="VerResultados" id="VerResultados" method="post">
				<table width="100%">
					<tr bgcolor="#E1DFE3">
						<td width="15%"><strong>Fecha</strong></td>
						<td width="22%"><strong>Sede</strong></td>
						<td width="22%"><strong>Servicio</strong></td>
						<td width="">&nbsp;</td>
					</tr>
					<tr>
						<td><label for="fecha"></label>
							<input type="text" id="datepicker" name="fecha" class="texto" value="<?php
							echo date("m/d/Y");
							?>" onChange="cargarResultados()" readonly/><span class="asterisk">*
      </span></td>
						<td><label for="sede"></label>
							<select name="sede" id="sede" class="select" onChange="cargarResultados()">
								<option value="">.: Seleccione :.</option>
								<?php
								while ($rowSede = mysql_fetch_array($listaSede)) {
									?>
									<option value="<?php echo $rowSede['idsede']?>"
										<?php if ($rowSede['idsede'] == $sede) {
											echo 'selected';
										}?>><?php echo $rowSede['descsede']?></option>';
								<?php
								}
								?>
							</select><span class="asterisk">*</span></td>
						<td><label for="servicio"></label>
							<select name="servicio" id="servicio" class="select" onChange="cargarResultados()">
								<option value="">.: Seleccione :.</option>
								<?php
								while ($regListaServicio = mysql_fetch_array($listaServicio)) {
									echo '<option value="' . $regListaServicio['idservicio'] . '">' . $regListaServicio['descservicio'] . '</option>';
								}
								?>
							</select><span class="asterisk">*</span></td>
						<td>
							<div id="notificacion"></div>
						</td>
					</tr>
				</table>
				<table width="100%">
					<tr>
						<td>
							<div id="contenido"></div>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>
</body>
</html>