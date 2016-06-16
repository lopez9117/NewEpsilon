<?php
//sesion del usuario, validacion de la sesion para que no se pueda ingresar por url
	session_start();
	$CurrentUser = $_SESSION['currentuser'] ;
//Conexion a la base de datos
	include('../../dbconexion/conexion.php');
	$cn = Conectarse();
	//incluir archivo para generar selects
	include "../select/selects.php";
	//$year = date("Y");
$year = '2017';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache">
<title>Prodiagnostico S.A</title>
<link href="../../css/cuadroTurnos.css" rel="stylesheet" type="text/css">
<link href="../../css/default.css" rel="stylesheet" type="text/css">
<link type="text/css" href="../../css/demo_table.css" rel="stylesheet" />
<link href="../../css/default.css" rel="stylesheet" type="text/css">
<script src="../../js/jquery.js" type="text/javascript"></script>
<script src="../../js/ajax.js" type="text/javascript"></script>
<script type='text/javascript' src='../js/osx.js'></script>
<script language="javascript">
$(document).ready(function() {
   // Interceptamos el evento submit
    $('#form, #fat, #CrearCuadroTurnos').submit(function() {
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

	body
{
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;}
table
{width:100%;
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
}
input.text
{font-family:Arial, Helvetica, sans-serif;
font-size:12px;
width:200px;
}
textarea
	{
		font-family:Verdana, Geneva, sans-serif;
		font-size:12px;
		width:100%;
		height:55px;
		resize:none;
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
		<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a href="../../includes/main_menu.php">MEN&Uacute; PRINCIPAL</a></span> &gt; <a href="main_menu_cuadrot.php">Cuadro de turnos</a> &gt; Crear cuadro de turnos</span></div>
	<table width="98%" border="0">
	<tr>
	<td colspan="2" height="7"><div style="border-bottom: #D3D3D3 2px dotted"></div><br></td>
	</tr>
	<tr>
	<td valign="top" align="center" bgcolor="#DEDEDE"><form id="CrearCuadroTurnos" name="CrearCuadroTurnos" method="post" action="crearCuadroSeleccionable.php"><br>
	  <table width="100%" border="0">
	    <tr>
	      <td>
	          <table width="100%" border="0">
	              <tr>
	                <td><select name="grupoEmpleado" id="grupoEmpleado" class="text">
	                  <option value="">.: Grupo de empleados :.</option>
	                  <?php while($rowGrupo = mysql_fetch_array($listaGrupoEmpleado))
						{
							echo '<option value="'.$rowGrupo['idgrupo_empleado'].'">'.$rowGrupo['desc_grupoempleado'].'</option>';
						}
					?>
	                  </select>
* <span class="selectRequiredMsg"></span></td>
	                <td><select name="sede" id="sede" class="text">
	                  <option value="">.: Unidad de servicios :.</option>
	                  <?php
                    while($rowSedeActiva = mysql_fetch_array($listaSedeActiva))
						{
							echo '<option value="'.$rowSedeActiva['idsede'].'">'.$rowSedeActiva['descsede'].'</option>';
						}
					?>
	                  </select>
*</td>
	                <td><label for="mes">
	                  <select name="ciudad" id="ciudad">
	                    <option value="">.: Ciudad :.</option>
	                    <?php
                      	$consciudad = mysql_query("SELECT DISTINCT f.cod_mun, m.nombre_mun FROM funcionario f
INNER JOIN r_municipio m ON m.cod_mun = f.cod_mun
WHERE f.cod_mun != 0 ORDER BY m.nombre_mun ASC", $cn);
						while($rowCiudad = mysql_fetch_array($consciudad))
						{
							echo '<option value="'.$rowCiudad['cod_mun'].'">'.utf8_decode($rowCiudad['nombre_mun']).'</option>';
						}
					  ?>
	                    </select>*
	                </label></td>
	                <td><select name="mes" id="mes" class="text">
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
* </td>
	                <td><label for="ciudad">
	                  <select name="anio" id="anio" class="small_select">
	                    <option value="">.: A&ntilde;o :.</option>
	                    <?php 
						for($y=2013; $y<=$year ; $y=$y+1 )
						{
							echo '<option value="'.$y.'">'.$y.'</option>';
						}
					?>
	                    </select>
* </label></td>
	                <td><input type="submit" name="Enviar" id="table" value="Enviar" />
	                  <input type="reset" name="Restablecer" id="table" value="Restablecer" /></td>
	                </tr>
	            </table></td>
	      </tr>
        <tr>
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