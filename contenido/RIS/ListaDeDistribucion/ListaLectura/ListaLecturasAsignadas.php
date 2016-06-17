<?php
include("../../select/selects.php");
$Anio=date("Y");
$Mes=date("m");
$dias = date('t', mktime(0,0,0, $Mes, 1, $Anio));
$fecha_inicio=($Anio.'-'.$Mes.'-'.'01');
$fecha_limite=($Anio.'-'.$Mes.'-'.$dias);
list($AÑO,$MES,$DIA)=explode("-",$fecha_inicio);
$DESDE= $MES."/".$DIA."/".$AÑO;
list($AÑO,$MES,$DIA)=explode("-",$fecha_limite);
$HASTA= $MES."/".$DIA."/".$AÑO;
?>
<script type="text/javascript" language="javascript" src="../../javascript/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../../ajax.js"></script>
<link type="text/css" href="../../styles/demo_table.css" rel="stylesheet" />
<script>
function MostrarAsignados()
{
	var fechaDesde,fechaHasta, sede, servicio,usuario;
	fechaDesde = document.LecturaAsignada.fechaDesde.value;
	fechaHasta = document.LecturaAsignada.fechaHasta.value;
	sede = document.LecturaAsignada.sede.value;
	servicio = document.LecturaAsignada.servicio.value;
	especialista = document.LecturaAsignada.especialista.value;
	
	if(fechaDesde=="" || fechaHasta=="" || sede=="" || servicio=="" || especialista=="")
	{
		mensaje = "<font color='#FF0000'>Los campos marcados con * son obligatorios</font>";
		document.getElementById('notificacionAsignados').innerHTML = mensaje;
		document.getElementById('contenidoAsignados').innerHTML = "";
	}
	else
	{	
		document.getElementById('notificacionAsignados').innerHTML = "";
		$(document).ready(function(){
		verlistado()
			//CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO
	})
		function verlistado(){ //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
			var randomnumber=Math.random()*11;
			$.post("AsignadosEspecialista.php?fechaHasta="+fechaHasta+"&fechaDesde="+fechaDesde+"&sede="+sede+"&servicio="+servicio+"&especialista="+especialista+"", {
				randomnumber:randomnumber
			}, function(data){
			  $("#ResultadosEstudios").html(data);
			});
		}
	}
}
</script>
<form name="LecturaAsignada" id="LecturaAsignada" method="post">
  <table width="100%">
    <tr bgcolor="#E1DFE3">
      <td width="15%">Desde</td>
      <td width="15%">Hasta</td>
      <td width="22%">Sede</td>
      <td width="22%">Servicio</td>
       <td width="22%">Especialista</td>
      <td width="">&nbsp;</td>
    </tr>
    <tr>
      <td><input type="text" name="fechaDesde" class="datepicker4" value="<?php
echo $DESDE;
?>" onChange="MostrarAsignados()" readonly /><span class="asterisk">*</span></td>
      <td><label for="fecha"></label>
      <input type="text" i name="fechaHasta" class="datepicker4" value="<?php
echo $HASTA;
?>" onChange="MostrarAsignados()" readonly /><span class="asterisk">*</span></td>
      <td><label for="sede"></label>
        <select name="sede" id="sede" class="select" onChange="MostrarAsignados()">
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
        <select name="servicio" id="servicio" class="select" onChange="MostrarAsignados()">
        <option value="">.: Seleccione :.</option>
        <?php
        	while($regListaServicio = mysql_fetch_array($listaServicio))
			{
				echo '<option value="'.$regListaServicio['idservicio'].'">'.$regListaServicio['descservicio'].'</option>';
			}
		?>
      </select><span class="asterisk">*
      
      </span></td>
      <td><label for="especialista"></label>
        <select name="especialista" id="especialista" onChange="MostrarAsignados()">
        <option value="">.: Seleccione :.</option>
        <?php
        	//consultar especialistas
			$consEspecialista = mysql_query("SELECT DISTINCT esp.idfuncionario_esp, f.nombres, f.apellidos FROM r_especialista esp
INNER JOIN funcionario f ON f.idfuncionario = esp.idfuncionario_esp WHERE f.idestado_actividad = '1'
ORDER BY nombres ASC", $cn);
    	while($rowEspecialista = mysql_fetch_array($consEspecialista))
		{
			echo '<option value="'.$rowEspecialista['idfuncionario_esp'].'">'.$rowEspecialista['nombres'].'&nbsp;'.$rowEspecialista['apellidos'].'</option>';
		}
	?>
      </select></td>
      <td><div id="notificacionAsignados" align="left"></div></td>
    </tr>
  </table>
  <table width="100%">
<tr>
<td><div id="ResultadosEstudios"></div></td>
</tr>
</table>
</form>