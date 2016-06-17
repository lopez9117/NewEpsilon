<?php
//conexion a la bd
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//consulta con sedes y servicios
include('../Query/selects.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Ver Encuestas :.</title>
<script type="text/javascript" src="../../../js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="../JavaScript/jquery.dataTables.js"></script>
<link href="../styles/demo_table.css" rel="stylesheet" type="text/css">
<link href="../styles/general.css" rel="stylesheet" type="text/css">
</head>

<body>
<script>
function ValidarConsulta()
{
	var form, sede, mes, anio, encuesta;
	form = document.VerEncuestas;
	sede = form.sede.value;
	mes = form.mes.value;
	anio = form.anio.value;
	encuesta = form.encuesta.value;
	
	if(sede=="" || mes=="" || anio=="" || encuesta=="")
	{
		alert("Campos Vacios");
	}
	else
	{
		$(document).ready(function(){
		verlistado()
			//CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO
		})
		function verlistado(){ //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
			  var randomnumber=Math.random()*11;
			$.post("ListadoEncuestaSede.php?sede="+sede+"&mes="+mes+"&anio="+anio+"&encuesta="+encuesta+"", {
				randomnumber:randomnumber
			}, function(data){
			  $("#contenido").html(data);
			});
		}
	}
}
</script>
<fieldset style="margin-top:1%;">
<legend><h3><strong>Ver encuestas de satisfaccion:</strong></h3></legend>
<form id="VerEncuestas" name="VerEncuestas" method="post" action="">
  <table width="90%" border="0" align="center">
    <tr>
      <td colspan="4"></td>
    </tr>
    <tr>
      <td width="25%">&nbsp;</td>
      <td width="25%">&nbsp;</td>
      <td width="25%">&nbsp;</td>
      <td width="25%">&nbsp;</td>
    </tr>
    <tr>
      <td>Sede:</td>
      <td>Mes:</td>
      <td>Año:</td>
      <td>Encuesta</td>
    </tr>
    <tr>
      <td><label for="sede"></label>
        <select name="sede" id="sede" class="input">
        <option value="">.: Seleccione :.</option>
        <?php
      	while($rowSede = mysql_fetch_array($listaSedeActiva))
		{
			echo '<option value="'.$rowSede['idsede'].'">'.$rowSede['descsede'].'</option>';
		}
	  ?>
      </select></td>
      <td><label for="mes"></label>
        <select name="mes" id="mes" class="input">
        <option value="">.: Seleccione :.</option>
        <?php
        	foreach($meses as $m => $mes)
			{
				echo '<option value="'.$m.'">'.$mes.'</option>';
			}
		?>
      </select></td>
      <td><label for="anio"></label>
        <select name="anio" id="anio" class="input">
        <option value="">.: Seleccione :.</option>
        <?php
        	while($rowAnio = mysql_fetch_array($anios))
			{
				echo '<option value="'.$rowAnio['anio'].'">'.$rowAnio['anio'].'</option>';
			}
		?>
      </select></td>
       <td>
       <select name="encuesta" id="encuesta" class="input">
          <option value="">.: Seleccione :.</option>
          <?php
        	while($rowEncuesta = mysql_fetch_array($listaEncuesta))
			{
				echo '<option value="'.$rowEncuesta['idnombencuesta'].'">'.$rowEncuesta['nomencuesta'].'</option>';
			}
		?>
        </select>
       </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
       <td>&nbsp;</td>
      <td><input type="button" name="button" id="button" value="Consultar" onclick="ValidarConsulta()"/>
      <input type="reset" name="button2" id="button2" value="Restablecer" /></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" id="contenido">&nbsp;</td>
    </tr>
  </table>
</form>
</fieldset>
</body>
</html>