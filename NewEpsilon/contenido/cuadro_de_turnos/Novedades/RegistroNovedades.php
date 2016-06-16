<?php
//sesion del usuario, validacion de la sesion para que no se pueda ingresar por url
	session_start();
	$CurrentUser = $_SESSION['currentuser'] ;
//Conexion a la base de datos
	include('../../../dbconexion/conexion.php');
	$cn = Conectarse();
	//incluir archivo para generar selects
	include "../includes/selects.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prodiagnostico S.A</title>
<link href="../../../css/cuadroTurnos.css" rel="stylesheet" type="text/css" />
<link href="../../../css/default.css" rel="stylesheet" type="text/css">
<link type="text/css" href="../../../css/demo_table.css" rel="stylesheet" />
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
</style>

<script src="../../../js/jquery.js" type="text/javascript"></script>
<script src="../../../js/ajax.js" type="text/javascript"></script>
<script type="text/javascript" src="../../../js/osx.js"></script>
<link href="../../../css/forms.css" rel="stylesheet" type="text/css" />
<script language="javascript">
$(document).ready(function() {
   // Interceptamos el evento submit
    $('#form, #fat, #RegNovedades').submit(function() {
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
<link href="../../css/cuadroTurnos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.listado
{
	scrollbar-arrow-color : #0B0B3B;
	scrollbar-face-color : #FAFAFA;
	scrollbar-track-color :#FAFAFA; 
	height:350px;
	overflow-x: auto;
	width: 90%;
	position:inherit;
	font-family:Verdana, Geneva, sans-serif;
	font-size:10px;
}
</style>
</head>
<body>
<div id="nav">
<div class="show">
<table width="100%" border="0">
<tr><td align="center" valign="middle">	
	<div class="marco">
	<div class="ruta">
		<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a href="../../../includes/main_menu.php">MEN&Uacute; PRINCIPAL</a></span> &gt; <a href="../main_menu_cuadrot.php">Cuadro de turnos</a> &gt; Consultar Cuadros de Turnos</span></div>
	<table width="98%" border="0">
	<tr>
	<td colspan="2" height="7"><div style="border-bottom: #D3D3D3 2px dotted"></div><br></td>
	</tr>
	<tr>
	<td valign="top" align="center" bgcolor="#DEDEDE"><form id="RegNovedades" name="RegNovedades" method="post" action="crearListaNovedades.php"><br>
	  <table width="100%" border="0">
	    <tr>
	      <td><table width="100%" border="0">
	        <tr>
	          <td><span id="spryselect1">
	            <label for="grupoEmpleado"></label>
	            <select name="grupoEmpleado" id="grupoEmpleado">
	              <option value="">.: Grupo de empleados :.</option>
	              <?php while($rowGrupo = mysql_fetch_array($listaGrupoEmpleado))
						{
							echo '<option value="'.$rowGrupo['idgrupo_empleado'].'">'.$rowGrupo['desc_grupoempleado'].'</option>';
						}
					?>
	              </select>
	            *
	            <span class="selectRequiredMsg"></span></span></td>
              <td>
                <label for="sede"></label>
                <select name="sede" id="sede">
                  <option value="">.: Unidad de servicios :.</option>
                  <?php
                    while($rowSedeActiva = mysql_fetch_array($listaSedeActiva))
						{
							echo '<option value="'.$rowSedeActiva['idsede'].'">'.$rowSedeActiva['descsede'].'</option>';
						}
					?>
                </select>*
                <td>
                	<select name="servicio">
                    	<option value="">.: Seleccione Servicio :.</option>
                        <?php
                        	while($rowServicio = mysql_fetch_array($listaServicios))
							{
								echo '<option value="'.$rowServicio['idservicio'].'">'.$rowServicio['descservicio'].'</option>';
							}
						?>
                    </select>
                </td>
              <td><span id="spryselect3">
                <label for="mes"></label>
                <select name="mes" id="mes" class="small_select">
                  <option value="">.: Mes :.</option>
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
                <span class="selectRequiredMsg"></span></span></td>
              <td><span id="spryselect4">
                <label for="anio"></label>
                <select name="anio" id="anio" class="small_select">
                  <option value="">.: A&ntilde;o :.</option>
                  <?php 
						for($y=2013; $y<=2020 ; $y=$y+1 )
						{
							echo '<option value="'.$y.'">'.$y.'</option>';
						}
					?>
                </select>
                *
                <span class="selectRequiredMsg"></span></span></td>
              <td><input type="submit" name="Enviar" value="Enviar" id="table" />&nbsp;&nbsp;<input type="reset" name="Restablecer" value="Restablecer" id="table" /></td>
            </tr>
            <tr> </tr>
	        </table>
	        </td>
	      </tr>
	    </table> <div id="result"></div>
	  </form></td>
	</tr>
	</table><br>
	</div>
</td></tr>
</table>
</div></div>
</body>
</html>