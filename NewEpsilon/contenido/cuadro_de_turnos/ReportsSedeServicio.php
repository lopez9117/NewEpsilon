<?php
//sesion del usuario, validacion de la sesion para que no se pueda ingresar por url
	session_start();
	$CurrentUser = $_SESSION[currentuser] ;
//Conexion a la base de datos
	require_once('../../dbconexion/conexion.php');
	$cn = Conectarse();
	//incluir archivo para generar selects
	include "../select/selects.php";
	include "../select/select.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prodiagnostico S.A</title>
<link href="../css/cuadroTurnos.css" rel="stylesheet" type="text/css" />
<link href="../../css/default.css" rel="stylesheet" type="text/css">
<link type="text/css" href="../css/demo_table.css" rel="stylesheet" />
<link href="../css/default.css" rel="stylesheet" type="text/css">
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
 <script type="text/javascript">
		function excel()
		{
			window.open("CuadroExcel.php");
		}
        </script>
<script src="../../js/jquery.js" type="text/javascript"></script>
<script src="../../js/ajax.js" type="text/javascript"></script>
<script type='text/javascript' src='../../js/osx.js'></script>
<link href="../../css/forms.css" rel="stylesheet" type="text/css" />
<script language="javascript">
$(document).ready(function() {
   // Interceptamos el evento submit
    $('#form, #fat, #ConsReporte').submit(function() {
 		// Enviamos el formulario usando AJAX
        $.ajax({
		type: 'POST',
		url: $(this).attr('action'),
		data: $(this).serialize(),
		// Mostramos un mensaje con la respuesta de PHP
		success: function(data) {
		$('#result').html(data);
            }
        })        
        return false;
    }); 
})
</script>
</head>
<body>
<table width="100%" border="0">
<tr><td align="center" valign="middle">
	
	<div class="marco">
	<div class="ruta">
		<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a href="../../includes/main_menu.php">MEN&Uacute; PRINCIPAL</a></span> &gt; <a href="main_menu_cuadrot.php">Cuadro de turnos</a> &gt;<span class="class_cargo" style="font-size:14px"><a href="main_menu_reports.php"> Reportes</a></span> <span class="class_cargo" style="font-size:14px">&gt; Reporte por sede</span></span></div>
	<table width="98%" border="0">
	<tr>
	<td colspan="2" height="7"><div style="border-bottom: #D3D3D3 2px dotted"></div><br></td>
	</tr>
	<tr>
	<td valign="top" align="center" bgcolor="#DEDEDE"><form id="ConsReporte" name="ConsReporte" method="post" action="reports/ReportGrupalSedeServicio.php">
	  <table width="100%" border="0">
	    <tr>
	      <td><span id="spryselect1">
          <select name="sede" id="sede">
            	<option value="">.: Seleccione Sede :.</option>
                <?php while($rowGrupo = mysql_fetch_array($ListaSede))
				{
					echo '<option value="'.$rowGrupo[idsede].'">'.$rowGrupo[descsede].'</option>';
				}
				?>
            </select>
          <label for="GrupoEmpleado"></label>
	        <select name="GrupoEmpleado" id="GrupoEmpleado">
            	<option value="">.: Seleccione grupo de empleados :.</option>
                <?php while($rowGrupo = mysql_fetch_array($listaGrupoEmpleado))
				{
					echo '<option value="'.$rowGrupo[idgrupo_empleado].'">'.$rowGrupo[desc_grupoempleado].'</option>';
				}
				?>
            </select>
	        *
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
	        <input type="submit" name="Consultar" id="Consultar" value="Consultar" />
	        </span>
	        <div id="result">
            </div></td>
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