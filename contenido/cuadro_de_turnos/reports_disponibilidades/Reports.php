<?php
//Conexion a la base de datos
	include('../../../dbconexion/conexion.php');
	$cn = Conectarse();
	//incluir archivo para generar selects
	include "../Includes/selects.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<meta http-equiv=Content-Type content="text/html; charset=ISO-8859-1">
<title>Prodiagnostico S.A</title>
<link href="../../../css/cuadroTurnos.css" rel="stylesheet" type="text/css" />
<link href="../../../css/default.css" rel="stylesheet" type="text/css">
<link type="text/css" href="../../css/demo_table.css" rel="stylesheet" />
<link href="../../../css/default.css" rel="stylesheet" type="text/css">
<!-- END VALIDADOR -->
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<script src="../../../js/jquery.js" type="text/javascript"></script>
<script src="../../../js/jquery-1.7.1.js"></script>
<script src="../../../js/ui/jquery.ui.core.js"></script>
<script src="../../../js/ui/jquery.ui.widget.js"></script>
<script src="../../../js/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript" language="javascript" src="../../../js/jquery.dataTables.js"></script>
<link href="../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css">
<link href="../../../js/lib/base.css" rel="stylesheet" type="text/css">
<script>
function generarReporte()
{
	var mes, anio;
	mes = document.ConsReporte.mes.value;
	anio = document.ConsReporte.anio.value;
	if(mes == "" || anio == "")
	{
		mensaje = '<font color="#FF0000">Los campos señalados con * son obligatorios</font>';
		document.getElementById('result').innerHTML = mensaje;
	}
	else
	{
		$(document).ready(function(){
		verlistado()
			//CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO
		})
		function verlistado(){ //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
			  var randomnumber=Math.random()*11;
			$.post("ReportGrupalDisponibilidades.php?mes="+mes+"&anio="+anio+"", {
				randomnumber:randomnumber
			}, function(data){
			  $("#result").html(data);
			});
		}
	}
}
</script>
<link type="text/css" href="../../../css/demo_table.css" rel="stylesheet" />
<link href="../../../css/default.css" rel="stylesheet" type="text/css">
<link href="../../../css/forms.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="100%" border="0">
<tr><td align="center" valign="middle">
	
	<div class="marco">
	<div class="ruta">
		<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a href="../../../includes/main_menu.php">MEN&Uacute; PRINCIPAL</a></span> &gt; <a href="../main_menu_cuadrot.php">Cuadro de turnos</a> &gt; Reporte Disponibilidades</span></div>
	<table width="98%" border="0">
	<tr>
	<td colspan="2" height="7"><div style="border-bottom: #D3D3D3 2px dotted"></div><br></td>
	</tr>
	<tr>
	<td valign="top" align="center" bgcolor="#DEDEDE"><!--<form id="ConsReporte" name="ConsReporte" method="post" action="reports/ReportGrupal.php">-->
    <form id="ConsReporte" name="ConsReporte" method="post" action="#">
	  <table width="100%" border="0">
	    <tr>
	      <td><span id="spryselect1">
	        <label for="GrupoEmpleado"></label>
	        <span class="selectRequiredMsg"></span></span><span id="spryselect2">
	        <label for="mes"></label>
	        <select name="mes" id="mes">
            	<option value="">.: Seleccione un mes :.</option>
                <option value="01">Enero</option>
                <option value="02">Febrero</option>
                <option value="03">Marzo</option>
                <option value="04">Abril</option>
                <option value="05">Mayo</option>
                <option value="06">Junio</option>
                <option value="07">Julio</option>
                <option value="08">Agosto</option>
                <option value="09">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
	        </select>
	        *
	        <span class="selectRequiredMsg"></span></span><span id="spryselect3">
	        <label for="anio"></label>
	        <select name="anio" id="anio"><option value="">.: Seleccione un año :.</option>
        <?php 
			for($y=2013; $y<=2020 ; $y=$y+1 )
			{
				echo '<option value="'.$y.'">'.$y.'</option>';
			}
		?>
	          </select>
	        *
	        <span class="selectRequiredMsg"></span>
	        <input type="button" name="Consultar" id="Consultar" value="Consultar" onclick="generarReporte()" />
	        </span>
	        <div id="result"></div></td>
	      </tr>
	    </table>
	  </form></td>
	</tr>
	</table><br>
	</div>
</td></tr>
</table>
</body>
</html>