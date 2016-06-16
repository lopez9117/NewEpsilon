<?php
include("../../../../dbconexion/conexion.php");
$cn = conectarse();
include("../../select/selects.php");
?>
<script type="text/javascript" language="javascript" src="../../javascript/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../../ajax.js"></script>
<link type="text/css" href="../../styles/demo_table.css" rel="stylesheet" />
<script>
function CargarAgenda()
{
	var fechaDesde, sede, servicio,usuario;
	fechaDesde = document.ListarEspecialistas.fechaDesde.value;
	sede = document.ListarEspecialistas.sede.value;
	servicio = document.ListarEspecialistas.servicio.value;
	usuario = document.ListarEspecialistas.usuario.value;
	
	if(fechaDesde=="" || sede=="" || servicio=="")
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
			$.post("EspecialistasAgendados.php?fechaDesde="+fechaDesde+"&sede="+sede+"&servicio="+servicio+"&usuario="+usuario+"", {
				randomnumber:randomnumber
			}, function(data){
			  $("#contenido").html(data);
			});
		}
	}
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
return CargarAgenda();
	}
}
</script>
<body>
<form name="ListarEspecialistas" id="ListarEspecialistas" method="post">
  <table width="100%">
    <tr bgcolor="#E1DFE3">
      <td width="15%">Fecha</td>
      <td width="22%">Sede</td>
      <td width="">Servicio<span class="asterisk">
        <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>">
      </span></td>
    </tr>
    <tr>
      <td><input type="text" id="datepicker" name="fechaDesde" class="texto" value="<?php
echo $fecha;
?>" onChange="CargarAgenda()" readonly /><span class="asterisk">*</span></td>
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
      </select><span class="asterisk">*
      
      </span></td>
      <td><div id="notificacion" align="left"></div><div align="right" style="position:relative;"></div></td>
    </tr>
  </table>
  <table width="100%">
<tr>
<td><div id="contenido"></div></td>
</tr>
</table>
</form>