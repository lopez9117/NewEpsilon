<?php 
//sesion del usuario, validacion de la sesion para que no se pueda ingresar por url
	session_start();
	$CurrentUser = $_SESSION[currentuser] ;
	$mod = 7;
	include("../ValidarModulo.php");
	//incluir archivo para generar selects
	include "../select/selects.php";
	$SedeActiva = mysql_query("SELECT * FROM sede WHERE idestado_actividad=1 ORDER BY descsede ASC", $cn);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prodiagnostico S.A</title>
<link type="text/css" href="../../css/demo_table.css" rel="stylesheet" />
<link href="../../css/cuadroTurnos.css" rel="stylesheet" type="text/css" />
<link href="../../css/default.css" rel="stylesheet" type="text/css">
<link type="text/css" href="../../css/demo_table.css" rel="stylesheet" />
<link href="../../css/default.css" rel="stylesheet" type="text/css">
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<script src="../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../../js/jquery.js" type="text/javascript"></script>
<script src="../../js/jquery-1.7.1.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery.dataTables.js"></script>
<script language="javascript">
function generarReporte()
{
	var sede, servicio, mes, anio, grupoEmpleado;
	sede = document.ReporteCostos.sede.value;
	servicio = document.ReporteCostos.servicio.value;
	mes = document.ReporteCostos.mes.value;
	anio = document.ReporteCostos.anio.value;
	grupoEmpleado = document.ReporteCostos.grupoEmpleado.value;
	if(sede == "" || servicio == "" || mes == "" || anio=="" || grupoEmpleado == "")
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
			$.post("Validate/ReportCostosSedeServicio.php?grupoEmpleado="+grupoEmpleado+"&mes="+mes+"&anio="+anio+"&servicio="+servicio+"&sede="+sede+"", {
				randomnumber:randomnumber
			}, function(data){
			  $("#result").html(data);
			});
		}
	}
}
</script>
<link href="../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css">
<link href="../../js/lib/base.css" rel="stylesheet" type="text/css">
<link href="../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>
<div id="nav">
<div class="show">
<table width="100%" border="0">
<tr><td align="center" valign="middle">
	<div class="marco">
	<div class="ruta">
		<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a href="../../includes/main_menu.php">MEN&Uacute; PRINCIPAL</a></span> &gt; <a href="main_menu_reportes.php">Reportes</a></span>
	    <span class="class_cargo" style="font-size:14px">&gt; Costos</span></div>
	<table width="98%" align="center">
	<tr>
	<td colspan="2" height="7"><div style="border-bottom: #D3D3D3 2px dotted"></div></td>
	</tr>
	<tr>
	<td valign="top" align="left" bgcolor="#DEDEDE"><form id="ReporteCostos" name="ReporteCostos" method="post" action="">
	  <table width="98%" border="0" align="center">
	    <tr>
	      <td>Sede<br>
          <label for="sede"></label>
          <select name="sede" id="sede">
          <option value="">.: Seleccione :.</option>
          <?php
            while($rowSede = mysql_fetch_array($listaSedeActiva))
            {
                echo '<option value="'.$rowSede[idsede].'">'.$rowSede[descsede].'</option>';
            }
          ?>
            </select>
	        </td>
	      <td>Servicio<br>
	        <label for="servicio"></label>
	        <select name="servicio" id="servicio">
            <option value="">.: Seleccione :.</option>
            <?php
            	while($rowServicio = mysql_fetch_array($listaServicios))
				{
					echo '<option value="'.$rowServicio[idservicio].'">'.$rowServicio[descservicio].'</option>';
				}
			?>
	          </select></td>
	      <td>Mes<br>
          <select name="mes" id="mes" class="select">
          <option value="">.: Seleccione :.</option>
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
          </td>
          <td>año<br />
            <select name="anio" id="anio" class="select">
              <option value="">.: Seleccione :.</option>
              <?php 
						for($y=2013; $y<=2020 ; $y=$y+1 )
						{
							echo '<option value="'.$y.'">'.$y.'</option>';
						}
						?>
            </select></td>
	      <td>Grupo de empleados<br />
            <label for="grupoEmpleado"></label>
            <select name="grupoEmpleado" id="grupoEmpleado">
              <option value="">.: Seleccione :.</option>
              <?php
            	while($rowGrupo = mysql_fetch_array($listaGrupoEmpleado))
				{
					echo '<option value="'.$rowGrupo[idgrupo_empleado].'">'.$rowGrupo[desc_grupoempleado].'</option>';
				}
			?>
            </select></td>
	      <td><br><input type="button" name="consultar" id="consultar" value="consultar" onclick="generarReporte()" />
	        <input type="reset" name="restablecer" id="restablecer" value="Restablecer" /></td>
	      </tr>
	    </table>
        <table width="98%" align="center">
        <tr>
        <td><div id="result"></div></td>
        </tr>
        </table>
	  </form></td>
	</tr>
	</table>
	<br>
	</div>
</td></tr>
</table>
</div></div>
</body>
</html>