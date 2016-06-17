<?php
	require_once("../../../../dbconexion/conexion.php");
	$cn = conectarse();
	include("../../select/selects.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
<title>.: Estudios :.</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="../../../../js/ajax.js"></script>
<script src="../../../../js/jquery-1.9.1.js"></script>
<script src="../../../../js/jquery-ui-1.10.3.custom.js"></script>
<link href="../../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css" />
<link href="../../styles/forms.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="javascript" src="../../javascript/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../../javascript/ajax.js"></script>
<link type="text/css" href="../../styles/demo_table.css" rel="stylesheet" />
<script>
$(function() {
$( "#tabs" ).tabs();
});

function mostrarEstudios(){
	var estado, servicio;
	servicio = document.Estudios.servicio.value;
	estado = document.Estudios.estado.value;
	
	if(estado=="" || servicio=="")
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
			$.post("ListaEstudiosProcedimientos.php?servicio="+servicio+"&estado="+estado+"", {
				randomnumber:randomnumber
			}, function(data){
			  $("#contenido").html(data);
			});
		}
	}
}

$(function() {
    $( ".boton" )
      .button()
      .click(function( event ) {
        event.preventDefault();
      });
  });
</script>
</head>
<body onfocus="mostrarEstudios()">
<div style="width:99%; margin-top:0.5%;">
<div id="tabs">
<ul>
<li><a href="#tabs-1">Estudios / Procedimientos</a></li>
</ul>
<div id="tabs-1">
<form name="Estudios" id="Estudios" method="post" action="">
  <table width="100%">
    <tr bgcolor="#E1DFE3">
      <td width="25%"><strong>Servicio</strong></td>
      <td width="25%"><strong>Estado</strong></td>
      <td width="25%">&nbsp;</td>
      <td width="25%">&nbsp;</td>
    </tr>
    <tr>
      <td><label for="sede">
        <select name="servicio" id="servicio" class="select" onchange="mostrarEstudios()">
          <option value="">.: Seleccione :.</option>
          <?php
        	while($regListaServicio = mysql_fetch_array($listaServicio))
			{
				echo '<option value="'.$regListaServicio['idservicio'].'">'.$regListaServicio['descservicio'].'</option>';
			}
		?>
        </select>
        <span class="asterisk">*</span></label></td>
      <td><label for="estado"></label>
        <select name="estado" id="estado" onchange="mostrarEstudios()">
        <option value="">.: Seleccione :.</option>
        <?php
        	while($rowEstActividad = mysql_fetch_array($listarEstado))
			{
				echo '<option value="'.$rowEstActividad['idestado_actividad'].'">'.$rowEstActividad['desc_estado'].'</option>';
			}
		?>
        </select><span class="asterisk">*</span></td>
      <td><div id="notificacion"></div></td>
      <td align="right"><a class="boton" href="CrearNuevoEstudio.php" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=600, height=500, top=85, left=140'); return false;"><strong>Nuevo</strong></a></td>
    </tr>
  </table>
  <table width="100%">
<tr>
<td><div id="contenido"></div></td>
</tr>
</table>
</form>
</div>
</div>
</div>
</body>
</html>