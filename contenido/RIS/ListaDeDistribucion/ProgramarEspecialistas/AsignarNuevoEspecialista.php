<?php
include("../../select/selects.php");
$fecha = date("Y-m-d");
?>
<script type="text/javascript" language="javascript" src="../../javascript/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../../ajax.js"></script>
<link type="text/css" href="../../styles/demo_table.css" rel="stylesheet" />
<script>
function CargarAgendaEspecialista()
{
	var fechaDesde, idEspecialista;
	fechaDesde = document.AgendaEspecialista.fechaDesde.value;
	idEspecialista = document.AgendaEspecialista.idEspecialista.value;
	if(fechaDesde!="" )
	{
		$(document).ready(function(){
		verlistado()
			//CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO
		})
		function verlistado(){ //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
			var randomnumber=Math.random()*11;
			$.post("AgendaEspecialista.php?idEspecialista="+idEspecialista+"&fechaDesde="+fechaDesde+"", {
				randomnumber:randomnumber
			}, function(data){
			  $("#contenido").html(data);
			});
		}
	}
}
//validar y guardar con ajax
function ValidarGuardar()
{
	var fechaDesde, idEspecialista, sede, servicio, desde, hasta;
	formulario = document.AgendaEspecialista;
	fechaDesde = formulario.fechaDesde.value;
	idEspecialista = formulario.idEspecialista.value;
	sede = formulario.sede.value;
	servicio = formulario.servicio.value;
	desde = formulario.desde.value;
	hasta = formulario.hasta.value;
	//valirable donde se va a mostrar la respuesta
	divRespuesta = document.getElementById('Respuesta');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST", "Querys/InsertNuevoHorario.php",true);
	ajax.onreadystatechange=function() 
	{
		if (ajax.readyState==4) 
		{
			divRespuesta.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("fechaDesde="+fechaDesde+"&idEspecialista="+idEspecialista+"&sede="+sede+"&servicio="+servicio+"&desde="+desde+"&hasta="+hasta+"&tiempo=" + new Date().getTime());
return CargarAgendaEspecialista();
}

function BorrarHorario(idAut)
{
	mensaje = confirm("Seguro que desea eliminar?");
	if(mensaje==true)
	{
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST", "Querys/DeleteHorarioEspecialista.php",true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("idAut="+idAut+"&tiempo=" + new Date().getTime());
return CargarAgendaEspecialista();
	}
}
$(function() {
$( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd',
  changeMonth: true,
    changeYear: true
});
});
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
</script>
<body>
<form name="AgendaEspecialista" id="AgendaEspecialista" method="post">
  <table width="100%">
    <tr bgcolor="#E1DFE3">
      <td width="20%">Fecha</td>
      <td width="30%"><strong>Sede</strong></td>
      <td width="30%"><strong>Servicio
        <input type="hidden" name="idEspecialista" id="idEspecialista" value="<?php echo $idEspecialista ?>">
      </strong></td>
      <td width="10%"><strong>Desde</strong></td>
      <td width="10%"><strong>Hasta</strong></td>
    </tr>
    <tr>
      <td><input type="text" id="datepicker" name="fechaDesde" class="texto"  onChange="CargarAgendaEspecialista()" readonly value="<?php echo $fecha ?>" /></td>
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
        ';
		
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
      <td><label for="desde"></label>
      <input type="text" name="desde" id="inputSmall" class="timepicker"></td>
      <td>
      <input type="text" name="hasta" id="inputSmall2" class="timepicker"></td>
    </tr>
    <tr>
      <td colspan="3"><div id="Respuesta"></div></td>
      <td colspan="2" align="right"><input type="button" name="button" id="button" value="Guardar" onClick="ValidarGuardar()">
      <input type="reset" name="Restablecer" id="Restablecer" value="Restablecer"></td>
    </tr>
    
  </table>
  <table width="100%">
<tr>
<td><div id="contenido"></div></td>
</tr>
</table>
</form>