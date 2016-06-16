<?php
	require_once("../../../dbconexion/conexion.php");
	$cn = conectarse();
?>
<script language="JavaScript" type="text/javascript" src="../javascript/ajax.js"></script>
<script language="JavaScript" src="../../../js/jquery.js"></script>
<script src="../../../js/jquery.form.js"></script>
<script language="JavaScript" src="../js/jquery-ui-1.10.0.custom.min.js"></script>
<script type="text/javascript" language="javascript" src="../javascript/jquery.dataTables.js"></script>
<link type="text/css" href="../styles/demo_table.css" rel="stylesheet" />
<link type="text/css" href="../css/ui-lightness/jquery-ui-1.8.13.custom.css" rel="stylesheet" />
<?php
//seleccionar un identificador para el paciente
$con = "SELECT idfuncionario, nombres, apellidos FROM funcionario WHERE idgrupo_empleado = '4' AND idestado_actividad = '1'";//consulta para seleccionar las palabras a buscar, esto va a depender de su base de datos
$query = mysql_query($con);
?> 
<script>
	$(function() {
		<?php	
		while($row= mysql_fetch_array($query)) {//se reciben los valores y se almacenan en un arreglo
      $elementos[]= '"'.$row['idfuncionario'].' - '.$row['nombres'].' '.$row['apellidos'].'"';
}
$arreglo= implode(", ", $elementos);//junta los valores del array en una sola cadena de texto
		?>	
		var availableTags=new Array(<?php echo $arreglo; ?>);//imprime el arreglo dentro de un array de javascript	
		$( "#especialista" ).autocomplete({
			source: availableTags
		});
	});
	
	function validar()
	{
		especialista = document.busqueda.especialista.value;
		if(especialista!="")
		{
			$(document).ready(function(){
		verlistado()
			//CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO
	})
		function verlistado(){ //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
			var randomnumber=Math.random()*11;
			$.post("ValidateRegPlantilla.php?especialista="+especialista+"", {
				randomnumber:randomnumber
			}, function(data){
			  $("#Listaplantilla").html(data);
			});
		}
		}
	}
	</script>
<table width="100%" cellspacing="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0">
  <tr>
    <td width="87%" align="left"><form name="busqueda" id="busqueda">
    <strong>Especialista: </strong>
    <input name="especialista" id="especialista" type="text" style="font-size:12px; width:350px; height:15px;"/>
      <input type="button" name="continuar" id="continuar" value="Continuar" onClick="validar()"/>
    </form>      
      </td>
      <td></td>
    <td width="13%" align="center">
   </td>
  </tr>
</table>
</td>
</tr>
</table>
<div id="Listaplantilla">
</div>