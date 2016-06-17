<?php
	//archivo de conexion a la base de datos
	require_once ("../../dbconexion/conexion.php");
	$cn = Conectarse();
	//incluir archivo que contiene consultas para llenar selects
	include("../select/selects.php");
	$idFuncionario = $_GET[id];
	//consulta para obtener los datos para mostrar en el formulario
	$sqlFuncionario = mysql_query("SELECT * FROM funcionario WHERE idfuncionario='$idFuncionario'", $cn);
	$regFuncionario = mysql_fetch_array($sqlFuncionario);
	
	$tipoCargo = $regFuncionario[idtipo_cargo];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prodiagnostico S.A</title>
<script src="../../js/jquery-1.7.1.js"></script>
<script src="../../js/ui/jquery.ui.core.js"></script>
<script src="../../js/ui/jquery.ui.widget.js"></script>
<script src="../../js/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../../js/ajax.js"></script>
<link rel="stylesheet" href="../../js/themes/cupertino/jquery.ui.all.css">
<link href="../../css/default.css" rel="stylesheet" type="text/css">
<link href="../../css/forms.css" rel="stylesheet" type="text/css">
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
<script language='javascript'>
$(document).ready(function() {
   // Interceptamos el evento submit
    $('#form, #fat, #Newregistro').submit(function() {
 		// Enviamos el formulario usando AJAX
        $.ajax({
		type: 'POST',
		url: $(this).attr('action'),
		data: $(this).serialize(),
		// Mostramos un mensaje con la respuesta de PHP
		success: function(data) {
		$('#notificacion').html(data);
            }
        })        
        return false;
    }); 
});
$( "#desde" ).datepicker({
				changeMonth: true,
				changeYear: true,
				showOtherMonths: true,
				selectOtherMonths: true,
			});
</script>
</head>
<body>
<div id="nav">
<div class="chou">
<table width="100%" border="0">
<tr><td align="center" valign="middle">
	<div class="marco">
	<div class="ruta">
		<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a href="../../includes/main_menu.php">MEN&Uacute; PRINCIPAL</a></span> &gt; <span class="class_cargo" style="font-size:14px"><a href="Vacaciones.php">Programar Vacaciones</a></span>> Nuevo Registro</span></div>
	<table width="98%" border="0">
	<tr>
	<td colspan="2" height="7"><div style="border-bottom: #D3D3D3 2px dotted"></div><br><a href="Vacaciones.php" class="botones"><span><span>Regresar</span></span></a><br><br></td>
	</tr>
	<tr>
	<td valign="top" align="left" bgcolor="#DEDEDE">
    <form action="action_reg_vacaciones/regVacaciones.php" method="post" name="Newregistro" id="Newregistro">
    <table width="70%" align="center">
	  <tr>
	    <td colspan="2">&nbsp;</td>
	    </tr>
	  <tr>
	    <td colspan="2">
	      <p><a class="class_login" style="text-decoration:none;font-size:16px" href="opciones.php?modulo=1">Programar Vacaciones</a></p></td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td><p>N&deg; de documento:</p>
          <p><span id="sprytextfield5">
            <label for="ndocumento"></label>
            <input type="text" name="ndocumento" id="ndocumento" class="text" readonly="readonly" value="<?php echo $idFuncionario ;?>" />
          </span></p></td>
	    <td><p>&nbsp;</p></td>
	    </tr>
	  <tr>
	    <td><p>Nombres:</p>
          <p><span id="sprytextfield3">
            <label for="nombres"></label>
            <input type="text" name="nombres" id="nombres" class="text" value="<?php echo $regFuncionario[nombres]?>" disabled="disabled" />
          </span></p></td>
	    <td><p>Apellidos:</p>
          <p><span id="sprytextfield4">
            <label for="apellidos"></label>
            <input type="text" name="apellidos" id="apellidos" class="text" value="<?php echo $regFuncionario[apellidos]?>" disabled="disabled" />
          </span></p></td>
	    </tr>
	  <tr>
	    <td><p>Desde:</p>
	      <p>
	        <label for="desde"></label>
            <input name="desde" type="text" class="text" id="desde"/>
            <script>
			$( "#desde" ).datepicker({
				changeMonth: true,
				changeYear: true,
				showOtherMonths: true,
				selectOtherMonths: true,
			});
		</script>
            </td>
	    <td><p>Cantidad de dias:</p>
	      <p>
	        <label for="cantDias"></label>
	        <input type="text" name="cantDias" id="cantDias" class="text" />
	      *</p></td>
	    </tr>
	  <tr>
	    <td><p>Tipo de cargo:</p>
          <p>
            <label for="tipo_cargo"></label>
            <select name="tipo_cargo" id="tipo_cargo" class="select" disabled="disabled">
              <option value="">.: Seleccione :.</option>
              <?php 
				while($regTipoCargo = mysql_fetch_array($listadoCargo))
				{
				?>
              <option value="<?php echo $regTipoCargo[idtipo_cargo]?>"
                <?php
                	if($regFuncionario[idtipo_cargo]==$regTipoCargo[idtipo_cargo])
					{
				?>
                 selected="selected"
					<?php
					}
					?>
                    > <?php echo $regTipoCargo[desctipo_cargo]?></option>
              <?php
				}
			?>
            </select>
          </p></td>
	    <td><label for="tipo"></label>
	      <input type="hidden" name="tipo" id="tipo" value="<?php echo $tipoCargo ?>" />
	      <label for="grupo_empleado"></label>
	      <input type="hidden" name="grupo_empleado" id="grupo_empleado" value="<?php echo $regFuncionario[idgrupo_empleado] ?>" /></td>
	    </tr>
	  <tr>
	    <td><p>&nbsp;</p></td>
	    <td><p>&nbsp;</p></td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td><div id="notificacion" class="notificacion"></div></td>
	    <td><input type="submit" name="Registrar" id="Registrar" value="Registrar" class="button" />
	      <input type="reset" name="restablecer" id="restablecer" value="Restablecer" class="button" /></td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
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