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
function VerListadoGeneralEspecialista()
{
	var fechaDesde,fechaHasta, sede, servicio,usuario;
	fechaDesde = document.ListadoGeneralXEspecialista.fechaDesde.value;
	fechaHasta = document.ListadoGeneralXEspecialista.fechaHasta.value;
	especialista = document.ListadoGeneralXEspecialista.especialista.value;
	
	if(fechaDesde=="" || fechaHasta=="" || especialista=="")
	{
		mensaje = "<font color='#FF0000'>Los campos marcados con * son obligatorios</font>";
		document.getElementById('alerta').innerHTML = mensaje;
		document.getElementById('ListaGeneralXEspecialista').innerHTML = "";
	}
	else
	{	
		document.getElementById('alerta').innerHTML = "";
		$(document).ready(function(){
		verlistadoGeneral()
			//CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO
	})
		function verlistadoGeneral(){ //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
			var randomnumber=Math.random()*11;
			$.post("ListaGeneralXEspecialista.php?fechaHasta="+fechaHasta+"&fechaDesde="+fechaDesde+"&especialista="+especialista+"", {
				randomnumber:randomnumber
			}, function(data){
			  $("#ListaGeneralXEspecialista").html(data);
			});
		}
	}
}
</script>
<form name="ListadoGeneralXEspecialista" id="ListadoGeneralXEspecialista" method="post">
<table width="100%">
<tr bgcolor="#E1DFE3">
  <td width="15%"><strong>Desde</strong></td>
  <td width="15%"><strong>Hasta</strong></td>
  <td width="22%"><strong>Especialista</strong></td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td><input type="text" name="fechaDesde" class="calendario" value="<?php
echo $DESDE;
?>" onChange="VerListadoGeneralEspecialista()" readonly /><span class="asterisk">*</span></td>
  <td><label for="fecha"></label>
  <input type="text" name="fechaHasta" class="calendario" value="<?php
echo $HASTA;
?>" onChange="VerListadoGeneralEspecialista()" readonly /><span class="asterisk">*</span></td>
  <td><label for="sede">
    <select name="especialista" id="especialista" onChange="VerListadoGeneralEspecialista()">
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
      </select>
  </label></td>
  <td align="right"><div id="alerta"></div></td>
</tr>
</table>
<table width="100%">
<tr>
<td><div id="ListaGeneralXEspecialista"></div></td>
</tr>
<?php mysql_close($cn); ?>
</table>
</form>