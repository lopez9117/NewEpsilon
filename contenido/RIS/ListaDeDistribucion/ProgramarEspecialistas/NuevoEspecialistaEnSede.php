<?php
include("../../../../dbconexion/conexion.php");
$cn = conectarse();
include("../../select/selects.php");
$fecha = date("Y-m-d");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Agendar Especialista :.</title>
<script src="../../../../js/ajax.js"></script>
<script src="../../../../js/jquery-1.9.1.js"></script>
<script src="../../../../js/jquery-ui-1.10.3.custom.js"></script>
<script src="../../js/timepicker.js"></script>
<link href="../../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css" />
<link href="../../styles/forms.css" rel="stylesheet" type="text/css">
<link href="../ListasDeDistribucionCss/formularios.css" rel="stylesheet" type="text/css">
<style type="text/css">
body
{font-family:Arial, Helvetica, sans-serif;
font-size:10px;}
fieldset
{width:90%;
}
</style>
<script>
$(function() {
	$( "#tabs" ).tabs();
});
//buscador
$(function(){
	$('#especialista').autocomplete({
	   source : 'QueryEspecialistas/ajax.php',
	   select : function(event, ui){
		   $('#resultados').slideUp('slow', function(){
		   });
		   $('#resultados').slideDown('slow');
	   }
	});
});
//calendario
$(function() {
$( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd',
  changeMonth: true,
    changeYear: true
});
});
//
$(document).ready(function() {
   $(".timepicker").timepicker({
	   hours: { starts: 0, ends: 23 },
	   minutes: { interval: 15 },
	   rows: 2,
	   showPeriodLabels: true,
	   minuteText: '&nbsp;&nbsp;Min',
	   hourText : '&nbsp;&nbsp;Hora',
   })
});
//validar registro de la informacion
function ValidarRegistro()
{
	//declaracion de variables
	var especialista, fechaDesde, sede, servicio, desde, hasta;
	formulario = document.AsignarEspecialista;
	especialista = formulario.especialista.value;
	fechaDesde = formulario.fechaDesde.value;
	sede = formulario.sede.value;
	servicio = formulario.servicio.value;
	desde = formulario.desde.value;
	hasta = formulario.hasta.value;
	//validar campos obligatorios del formulario
	if(especialista == "" || fechaDesde == "" || sede == "" || servicio == "" || desde == "" || hasta == "")
	{
		mensaje = "<font color='#FF0000'>Los campos son obligatorios</font>";
		document.getElementById('Respuesta').innerHTML = mensaje;	
	}
	else
	{
		ajax=nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax.open("POST", "Querys/RegistrarNuevoEspecialistaEnSede.php",true);
		ajax.onreadystatechange=function() 
		{
			if (ajax.readyState==4) 
			{
				divRespuesta.innerHTML = ajax.responseText;
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("fechaDesde="+fechaDesde+"&especialista="+especialista+"&sede="+sede+"&servicio="+servicio+"&desde="+desde+"&hasta="+hasta+"&tiempo=" + new Date().getTime());
		
		setTimeout(window.close, 3000)	
	}
}
</script>
</head>
<body>
<div style="width:99%; margin-top:0.5%;">
<div id="tabs">
<ul>
<li><a href="#tabs-1">Especialistas</a></li>
</ul>
<div id="tabs-1">
    <form name="AsignarEspecialista" id="AsignarEspecialista" method="post">
    <table width="100%" align="center">
    <tr bgcolor="#E1DFE3">
      <td colspan="5"><strong>N° documento / Nombre del especialista: </strong></td>
    <tr>
      <td colspan="5">
        <input name="especialista" id="especialista" type="text" style="font-size:12px; width:450px; height:15px;" onkeyup="this.value=this.value.toUpperCase()" /></td>
      </tr>
    <tr  bgcolor="#E1DFE3">
    <td width="20%"><strong>Fecha</strong></td>
      <td width="20%"><strong>Sede</strong></td>
      <td width="20%"><strong>Servicio</strong></td>
      <td width="20%"><strong>Desde</strong></td>
      <td width="20%"><strong>Hasta</strong></td>
      </tr>
      <tr>
        <td><input type="text" id="datepicker" name="fechaDesde" class="texto"  onchange="CargarAgendaEspecialista()" readonly="readonly" value="<?php echo $fecha ?>" /></td>
        <td><select name="sede" id="sede" class="select">
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
        </select></td>
        <td><select name="servicio" id="servicio" class="select">
          <option value="">.: Seleccione :.</option>
          <?php
        while($regListaServicio = mysql_fetch_array($listaServicio))
        {
            echo '<option value="'.$regListaServicio['idservicio'].'">'.$regListaServicio['descservicio'].'</option>';
        }
    ?>
        </select></td>
        <td><input type="text" name="desde" id="inputSmall" class="timepicker" /></td>
        <td><input type="text" name="hasta" id="inputSmall2" class="timepicker" /></td>
      </tr>
      <tr>
      <td colspan="3"><div id="divRespuesta"></div></td>
      <td colspan="2" align="right"><input type="button" name="enviar" id="enviar" value="Guardar" onclick="ValidarRegistro()" />
        <input type="reset" name="restablecer" id="restablecer" value="Restablecer" /></td>
      </tr>
    </table>
    </form>  
    <div id="contenido"></div>    
</div>
</div>
</div>
</body>
</html>