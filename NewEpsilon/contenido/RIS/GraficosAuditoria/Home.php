<?php
require_once("../../../dbconexion/conexion.php");
$cn = conectarse();
include("../select/selects.php");
$usuario = $_GET['usuario'];
$sede = $_GET['sede'];
include("../../Encuestas/Graphics/charts/FusionCharts.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Gráficos estadísticos :.</title>
<script src="../../../js/ajax.js"></script>
<script src="../../../js/jquery-1.9.1.js"></script>
<script src="../../../js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript" language="javascript" src="../javascript/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../javascript/ajax.js"></script>
<script language="Javascript" src="../../Encuestas/Graphics/charts/FusionCharts.js"></script>
<link type="text/css" href="../styles/demo_table.css" rel="stylesheet" />
<link href="../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css" />
<link href="../styles/forms.css" rel="stylesheet" type="text/css">
<script>
$(function() {
$( "#tabs" ).tabs();
});
$(function() {
$( ".datepicker" ).datepicker({
changeMonth: true,
changeYear: true
});
});
</script>
<script>
function consultar()
{
var fecha, sede, servicio, estado, usuario;
usuario = document.agenda.usuario.value;
fecha = document.agenda.fecha.value;
hasta = document.agenda.hasta.value;
sede = document.agenda.sede.value;
estado = document.agenda.estado.value;
if(fecha == "" || sede == "" || estado =="" || hasta == "")
{
	document.getElementById('result').innerHTML = "<font color='#FF0000'>Los campos señalados con * son obligatorios</font>";
}
else
{
	$(document).ready(function(){
	verlistado()
	//CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO
	})
	function verlistado(){ //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
		var randomnumber=Math.random()*11;
		$.post("ListadoResultados.php?fecha="+fecha+"&sede="+sede+"&estado="+estado+"&hasta="+hasta+"&usuario="+usuario+"", {
			randomnumber:randomnumber
		}, function(data){
		  $("#result").html(data);
		});
	}
}
}
</script>
<style type="text/css">
.text{
	width:80%;
	font-family:Tahoma, Geneva, sans-serif;
	font-size:12px;
	height:20px;
	}
	#text{
	width:80%;
	font-family:Tahoma, Geneva, sans-serif;
	font-size:12px;
	height:20px;
	}
	#textsmall{
	width:60%;
	font-family:Tahoma, Geneva, sans-serif;
	font-size:12px;
	height:15px;
	}
	#result
	{
		width:99%;
		height:40%;
		margin-top:2%;
	}
</style>
</head>
<body>
<div style="width:99%; margin-top:0.5%;">
<div id="tabs">
<ul>
<li><a href="#tabs-1">Gráficos estadísticos</a></li>
</ul>
<div id="tabs-1">
<div id="contenido">
	<form name="agenda" id="agenda">
<table width="100%">
<tr>
<input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>">
<td width="10%"><strong>Desde:</strong><br/>
  <input type="text" class="datepicker" id="textsmall" name="fecha" value="<?php 
echo date("m/d/Y");
?>" onChange="consultar()"><span class="asterisk">*</span></td>
<td width="10%"><strong>Hasta:</strong><br/>
  <input type="text" class="datepicker" id="textsmall" name="hasta" value="<?php 
echo date("m/d/Y");
?>" onchange="consultar()" />
	<span class="asterisk">*</span>
  </p></td>
<td width="22%"><strong>Sede:</strong><br>
  <label for="sede"></label>
  <select name="sede" id="sede" onchange="consultar()" class="text">
	<option value="">.: Seleccione :.</option>
	<?php 
	while($rowSede = mysql_fetch_array($listaSede))
	{?>
	<option value="<?php echo $rowSede['idsede']?>"
		<?php if($rowSede['idsede'] == $sede)
		{
			echo 'selected';
		}?>><?php echo $rowSede['descsede']?></option>	
	<?php
	}
  ?>
  </select>
  <span class="asterisk">*</span></td>
  <td width="22%"><strong>Estado:</strong><br />
    <select name="estado" id="estado" onchange="consultar()" class="text">
      <?php
		//crear array asociativo para traer estados de los estudios
		$EstadoArray = array( 1 => 'Agendado/Pendiente por realizar', 2 => 'Pendiente por Lectura', 3 => 'Pendiente por transcribir', 4 => 'Pendiente por Aprobar', 5 => 'Pendiente por publicar', 9 => 'Devuelto por el especialista');
		foreach ($EstadoArray as $valor => $descripcion) 
		{
			echo '<option value="'.$valor.'">'.$descripcion.'</option>';
		}
	?>
    </select>
    <span class="asterisk">*</span></td>
</tr>
</table>
<table width="100%" border="0">
<tr>
<td><div id="result"></div></td>
</tr>
</table>
</form>
</div>    
</div>
</div>
</div>
<?php mysql_close($cn); ?>
</body>
</html>