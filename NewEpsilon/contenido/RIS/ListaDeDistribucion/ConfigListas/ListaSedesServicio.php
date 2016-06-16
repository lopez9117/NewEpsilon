<?php
include("../../../../dbconexion/conexion.php");
$cn = conectarse();
include("../../select/selects.php");
?>
<script type="text/javascript" language="javascript" src="../../javascript/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../../ajax.js"></script>
<link type="text/css" href="../../styles/demo_table.css" rel="stylesheet" />
<script>
function MostrarServicios()
{
	sede = document.ListaSedesWorklist.sede.value;
	
	if(sede=="")
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
			$.post("ListaSedesWorklist.php?&sede="+sede+"", {
				randomnumber:randomnumber
			}, function(data){
			  $("#contenido").html(data);
			});
		}
	}
}
function activarLista(id, sede, estado)
{
	//Codigo ajax para enviar datos al servidor y obtener respuesta
	//etiqueta donde se va a mostrar la respuesta
	notificacion = document.getElementById('notificacion');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST", "ActivarInactivarLista.php",true);
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			notificacion.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("id="+id+"&sede="+sede+"&estado="+estado+"&tiempo=" + new Date().getTime());
	//finalizar y actualizar el listado
	fin = setTimeout(MostrarServicios(), 5300);
}
</script>
<body>
<form name="ListaSedesWorklist" id="ListaSedesWorklist" method="post">
  <table width="100%">
    <tr bgcolor="#E1DFE3">
      <td colspan="3">Sede</td>
    </tr>
    <tr>
      <td width="15%"><select name="sede" id="sede" class="select" onChange="MostrarServicios()">
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
      <td width="22%"><label for="sede"></label><span class="asterisk">*</span></td>
      <td><div id="notificacion" align="left"></div><div align="right" style="position:relative;"></div></td>
    </tr>
  </table>
  <table width="100%">
<tr>
<td><div id="contenido"></div></td>
<?php mysql_close($cn); ?>
</tr>
</table>
</form>