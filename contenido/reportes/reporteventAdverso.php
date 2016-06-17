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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Prodiagnostico S.A</title>
<script src="../../js/jquery-1.7.1.js"></script>
<script src="../../js/ui/jquery.ui.core.js"></script>
<script src="../../js/ui/jquery.ui.widget.js"></script>
<script src="../../js/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery.dataTables.js"></script>
<link href="../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css">
<link href="../../css/default.css" rel="stylesheet" type="text/css">
<link href="../../js/lib/base.css" rel="stylesheet" type="text/css">
<link type="text/css" href="../../css/demo_table.css" rel="stylesheet" />
<script language="javascript">
$(document).ready(function() {
   // Interceptamos el evento submit
    $('#form, #fat, #Consulta').submit(function() {
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
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>
<body>
 <form name="Consulta" id="Consulta" method="post" action="produccioneventoadverso.php">
<table width="100%" border="0">
<tr><td align="center" valign="middle">
	<div class="marco">
	<div class="ruta">
		<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a href="../../includes/main_menu.php">MEN&Uacute; PRINCIPAL</a></span> &gt; <a href="main_menu_reportes.php">Reportes</a></span>
	    <span class="class_cargo" style="font-size:14px">&gt;Eventos Adversos</span></div>
	<table width="98%" border="0">
	<tr>
	<td colspan="2" height="7"><div style="border-bottom: #D3D3D3 2px dotted"></div><br></td>
	</tr>
	<tr>
	<td valign="top" align="center" bgcolor="#DEDEDE">
		<table width="99%"  border="0" cellpadding="0" cellspacing="0" bordercolor="#E6E9EC" bgcolor="#DEDEDE"><tr>
		  <td width="100%" height="8" align="center" background="">
          <table width="100%" border="0">
		  <tr>
		    <td height="19"><table width="96%" border="0" align="center">
		      <tr>
		        <td width="15%">Desde:<br>
                  <input name="FechaDesde" type="text" class="text" id="FechaDesde"/>*
            <script>
			$( "#FechaDesde" ).datepicker({
				changeMonth: true,
				changeYear: true,
				showOtherMonths: true,
				selectOtherMonths: true,
			});
		</script></td>
		        <td width="15%">Hasta:<br>
		          <label for="FechaHasta"></label>
		          <input type="text" name="FechaHasta" id="FechaHasta" />*
		          <script>
			$( "#FechaHasta" ).datepicker({
				changeMonth: true,
				changeYear: true,
				showOtherMonths: true,
				selectOtherMonths: true,
			});
		</script>
		          </td>
        <td><input type="submit" value="Consultar" class="ui-button" /></td>
		        </tr>
                <tr>
                <td colspan="3"><div id="result"></div></td>
                </tr>
                <tr>
                <td colspan="3">&nbsp;</td>
                </tr>
		      </table></td>
		    </tr>
		  </table></td></tr></table></td>
	</tr>
	</table>
	<br>
	</div>
</td></tr>
</table>
</form>
</body>
</html>