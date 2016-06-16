<?php
require_once("../../../../dbconexion/conexion.php");
$cn = conectarse();
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
function ListadoGeneral()
{
	//declarar variables
	var fechaDesde, fechaHasta, usuario;
	Form = document.ListadoPendientesGeneral;
	fechaDesde = Form.fechaDesde.value;
	fechaHasta = Form.fechaHasta.value;
	usuario = Form.usuario.value;
	
	//document.getElementById('notificacion').innerHTML = "";
	$(document).ready(function(){
	verlistadoGeneral()
		//CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO
})
	function verlistadoGeneral(){ //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
		var randomnumber=Math.random()*11;
		$.post("ListadoPendientesPorLecturaGeneral.php?fechaHasta="+fechaHasta+"&fechaDesde="+fechaDesde+"&usuario="+usuario+"", {
			randomnumber:randomnumber
		}, function(data){
		  $("#ListadoGeneral").html(data);
		});
	}
}
</script>
<body>
<form name="ListadoPendientesGeneral" id="ListadoPendientesGeneral" method="post">
  <table width="100%">
    <tr bgcolor="#E1DFE3">
      <td width="15%">Desde</td>
      <td width="15%">Hasta</td>
      <td width="22%">&nbsp;</td>
      <td width="22%">&nbsp;</td>
      <td width=""><span class="asterisk">
        <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>">
      </span></td>
    </tr>
    <tr>
      <td><input type="text"  name="fechaDesde" class="calendar" value="<?php
echo $DESDE;
?>" onChange="ListadoGeneral()" readonly /><span class="asterisk">*</span></td>
      <td><label for="fecha"></label>
      <input type="text" name="fechaHasta" class="calendar" value="<?php
echo $HASTA;
?>" onChange="ListadoGeneral()" readonly /><span class="asterisk">*</span></td>
      <td><label for="sede"></label></td>
      <td><label for="servicio"></label></td>
      <td></td>
    </tr>
  </table>
  <table width="100%">
<tr>
<td><div id="ListadoGeneral"></div></td>
</tr>
</table>
</form>