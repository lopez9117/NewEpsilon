<?php
include("../../../../dbconexion/conexion.php");
$cn = conectarse();
include("../../select/selects.php");
?>
<script type="text/javascript" language="javascript" src="../../javascript/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../../ajax.js"></script>
<link type="text/css" href="../../styles/demo_table.css" rel="stylesheet" />
<script>
function MostrarDistribucion()
{
	var fechaDesde, fechaHasta, sede, servicio,usuario;
	fechaDesde = document.DistribucionDeEstudios.fechaDesde.value;
	fechaHasta = document.DistribucionDeEstudios.fechaHasta.value;
	sede = document.DistribucionDeEstudios.sede.value;
	servicio = document.DistribucionDeEstudios.servicio.value;
	
	if(fechaDesde=="" || sede=="" || servicio=="" || fechaHasta== "")
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
			$.post("ListaDistribucionDeEstudios.php?fechaDesde="+fechaDesde+"&sede="+sede+"&servicio="+servicio+"&usuario="+usuario+"&fechaHasta="+fechaHasta+"", {
				randomnumber:randomnumber
			}, function(data){
			  $("#Listado").html(data);
			});
		}
	}
}
</script>
<body>
<form name="DistribucionDeEstudios" id="DistribucionDeEstudios" method="post">
  <table width="100%">
    <tr bgcolor="#E1DFE3">
      <td width="15%"><strong>Desde</strong></td>
      <td width="22%"><strong>Hasta</strong></td>
      <td width=""><strong>Sede</strong></td>
      <td width=""><strong>Servicio</strong></td>
    </tr>
    <tr>
      <td><input type="text" name="fechaDesde" class="datepicker" value="<?php
echo $fecha;
?>" readonly onChange="MostrarDistribucion()" /><span class="asterisk">*</span></td>
      <td><label for="sede">
        <input type="text" name="fechaHasta" class="datepicker" value="<?php
echo $fecha;
?>" readonly onChange="MostrarDistribucion()" />
      <span class="asterisk">*</span></label></td>
      <td><select name="sede" id="sede" class="select" onChange="MostrarDistribucion()">
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
      </select>
      <span class="asterisk">*</span></td>
      <td><select name="servicio" id="servicio" class="select" onChange="MostrarDistribucion()">
        <option value="">.: Seleccione :.</option>
        <?php
        	while($regListaServicio = mysql_fetch_array($listaServicio))
			{
				echo '<option value="'.$regListaServicio['idservicio'].'">'.$regListaServicio['descservicio'].'</option>';
			}
		?>
      </select>
      <span class="asterisk">* </span></td>
    </tr>
  </table>
  <table width="100%">
<tr>
<td><div id="Listado"></div></td>
</tr>
</table>
</form>