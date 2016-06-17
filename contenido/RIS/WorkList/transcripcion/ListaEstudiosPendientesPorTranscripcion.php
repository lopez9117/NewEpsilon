<?php
	require_once("../../../../dbconexion/conexion.php");
	$cn = conectarse();
	include("../../select/selects.php");
?>
<script type="text/javascript" language="javascript" src="../../javascript/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../../javascript/ajax.js"></script>
<link type="text/css" href="../../styles/demo_table.css" rel="stylesheet" />
<script>
function CargarAgenda(){
	
	var fechadesde,fechahasta, sede, servicio;
	fechadesde = document.VerAgenda.fechadesde.value;
	fechahasta = document.VerAgenda.fechahasta.value;
	sede = document.VerAgenda.sede.value;
	servicio = document.VerAgenda.servicio.value;
	usuario = document.VerAgenda.usuario.value;
	
	if(fechadesde=="" || sede=="" || fechahasta=="" || servicio=="")
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
			$.post("ListaPendientesPorTranscripcion.php?fechadesde="+fechadesde+"&fechahasta="+fechahasta+"&sede="+sede+"&servicio="+servicio+"&usuario="+usuario+"", {
				randomnumber:randomnumber
			}, function(data){
			  $("#contenido").html(data);
			});
		}
	}
}
function changeEstadoTrans(informe)
{
	usuario = document.VerAgenda.usuario.value;
	question = confirm("Desea marcarlo como transcrito?");
	
	if(question == true)
	{
		ajax=nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax.open("POST", "../acciones/ActualizarTranscripcionPendiente.php",true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("informe="+informe+"&usuario="+usuario+"&tiempo=" + new Date().getTime());
		
		return CargarAgenda();
	}
	else
	{
		document.getElementById(informe).checked = false;
	}
}
</script>
<body onLoad="CargarAgenda()">
<form name="VerAgenda" id="VerAgenda" method="post">
  <table width="100%">
    <tr bgcolor="#E1DFE3">
      <td width="15%">Fecha Desde</td>
      <td width="15%">Fecha Hasta</td>
      <td width="22%">Sede</td>
      <td width="22%">Servicio</td>
      <td width="">&nbsp;</td>
    </tr>
    <tr>
      <td><label for="fecha"></label>
      <input type="text" id="datepicker" name="fechadesde" class="texto" value="<?php
echo date("m/d/Y");
?>" onChange="CargarAgenda()" readonly /><span class="asterisk">*
      <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>">
      </span></td>
      <td><input type="text" id="datepicker2" name="fechahasta" class="texto" value="<?php
echo date("m/d/Y");
?>" onChange="CargarAgenda()" readonly />
        <span class="asterisk">*
        <input type="hidden" name="usuario2" id="usuario2" value="<?php echo $usuario ?>">
      </span></td>
      <td><label for="sede"></label>
        <select name="sede" id="sede" class="select" onChange="CargarAgenda()">
        <option value="">.: Seleccione :.</option>
        <?php 
	  	while($rowSede = mysql_fetch_array($listaSede))
		{?>
			<option value="<?php echo $rowSede['idsede']?>"
            <?php if($rowSede['idsede'] == $sede)
			{
				echo 'selected';
			}?>><?php echo $rowSede['descsede']?></option>';
		<?php
        }
	  ?>
      </select><span class="asterisk">*</span></td>
      <td><label for="servicio"></label>
        <select name="servicio" id="servicio" class="select" onChange="CargarAgenda()">
        <option value="">.: Seleccione :.</option>
        <?php
        	while($regListaServicio = mysql_fetch_array($listaServicio))
			{
				echo '<option value="'.$regListaServicio['idservicio'].'">'.$regListaServicio['descservicio'].'</option>';
			}
		?>
      </select><span class="asterisk">*</span></td>
      <td><div id="notificacion"></div></td>
    </tr>
  </table>
  <table width="100%">
<tr>
<td><div id="contenido"></div></td>
</tr>
</table>
</form>