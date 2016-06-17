<?php
//conexion a la bd
include('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//incluir campos seleccionables
include("../../Encuestas/Query/selects.php");
$meses = array( '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre', );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Base de datos de pacientes :.</title>
<script type="text/javascript" src="../javascript/ajax.js"></script>
<script src="../../../../js/ajax.js"></script>
<script src="../../../js/jquery-1.9.1.js"></script>
<script src="../../../js/jquery-ui-1.10.3.custom.js"></script>
<script src="../../../js/jquery.form.js"></script>
<link href="../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css" />
<link href="../../../css/forms.css" rel="stylesheet" type="text/css">
<style type="text/css">
	body{font-size:10px;}
</style>
<script language="javascript">
function validar()
{
	var sede, anio, mes;
	sede = document.Pacientes.sede.value;
	servicio = document.Pacientes.servicio.value;
	anio = document.Pacientes.anio.value;
	mes = document.Pacientes.mes.value;
	
	if(sede=="" || anio =="" || mes=="" || servicio == "")
	{
		alert("Campos Vacios");
	}
	else
	{
		//Codigo ajax para enviar datos al servidor y obtener respuesta
		divRespuesta = document.getElementById('divRespuesta');//etiqueta donde se va a mostrar la respuesta
		ajax=nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax.open("POST", "GeneradorReporte.php",true);
		ajax.onreadystatechange=function() 
		{
			if (ajax.readyState==4) 
			{
				divRespuesta.innerHTML = ajax.responseText;
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("sede="+sede+"&mes="+mes+"&anio="+anio+"&servicio="+servicio+"&tiempo=" + new Date().getTime());
	}	
}

$(function() {
	$( "#tabs" ).tabs();
});
</script>
</head>
<body>
<div style="width:99%; margin-top:0.5%;">
<div id="tabs">
<ul>
<li><a href="#tabs-1">Base de datos de pacientes</a></li>
</ul>
<div id="tabs-1">
<form id="Pacientes" name="Pacientes" method="post" action="#">
<table width="100%" border="0" align="center">
<tr>
    <td>Sede:</td>
    <td>Servicio:</td>
    <td>Mes</td>
    <td>Año:</td>
</tr>
<tr>
  <td width="25%"><select name="sede" id="sede" class="select">
    <option value="">.: Seleccione :.</option>
    <?php
        while($rowSede = mysql_fetch_array($listaSedeActiva))
        {
            echo '<option value="'.$rowSede['idsede'].'">'.$rowSede['descsede'].'</option>';
        }
    ?>
  </select></td>
  <td><select name="servicio" id="servicio" class="select">
    <option value="">.: Seleccione :.</option>
    <?php
        while($rowServicios = mysql_fetch_array($listaServicios))
        {
            echo '<option value="'.$rowServicios['idservicio'].'">'.$rowServicios['descservicio'].'</option>';
        }
    ?>
  </select></td>
  <td width="25%"><label for="mes"></label>
    <select name="mes" id="mes" class="select">
    <option value="">.: Seleccione :.</option>
    <?php
        foreach($meses as $m => $mes)
        {
            echo '<option value="'.$m.'">'.$mes.'</option>';
        }
    ?>
    </select></td>
  <td width="25%"><select name="anio" id="anio" class="select">
    <option value="">.: Seleccione :.</option>
    <?php
        while($rowAnio = mysql_fetch_array($anios))
        {
            echo '<option value="'.$rowAnio['anio'].'">'.$rowAnio['anio'].'</option>';
        }
        mysql_close($cn);
    ?>
  </select></td>
</tr>
<tr>
<td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><input type="button" name="Consultar" id="Consultar" value="Consultar" onclick="validar()" /></td>
</tr>
</table>
</form>
<div id="divRespuesta"></div>
</div>
</div>
</div>
</body>
</html>