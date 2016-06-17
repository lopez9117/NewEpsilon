<?php
//Conexion a la base de datos
include('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//variables GET
$funcionario = base64_decode($_GET['id']);
$CurrentUser = base64_decode($_GET['CurrentUser']);
//obtener datos de funcionario
$sql = mysql_query("SELECT * FROM funcionario WHERE idfuncionario = '$funcionario'", $cn);
$reg = mysql_fetch_array($sql);
//obtener la fecha actual del servidor
$fechaActual = date("Y-m-d");
$Anio = date("Y", $fechaActual);
$Mes = date("m", $fechaActual);
$dias = date('t', mktime(0, 0, 0, $Mes, 1, $Anio));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Disponibilidades :.</title>
<script src="../../../js/jquery-1.7.1.js"></script>
<script src="../../../js/ui/jquery.ui.core.js"></script>
<script src="../../../js/ui/jquery.ui.widget.js"></script>
<script src="../../../js/ui/jquery.ui.datepicker.js"></script>
<script src="../../../js/ajax.js" type="text/javascript"></script>
<script src="../../../js/ui/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="../js/jquery.timepicker.css" />
<link href="../../../js/demos/demos.css" rel="stylesheet" type="text/css">
<link href="../../../js/themes/cupertino/jquery-ui.css" rel="stylesheet" type="text/css">
<script>
//validar formulario antes de insertar
	
	$(document).ready(function() {
	   // Interceptamos el evento submit
		$('#form, #fat, #dispo').submit(function() {
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
	})
	
function Mostrardisp()
{
	fecha = document.dispo.desde.value;
	$(document).ready(function(){
	verlistado()
	})
	function verlistado(){
		var randomnumber=Math.random()*11;
		$.post("Query/DisponibilidadFuncionario.php?funcionario=<?php echo $funcionario ?>&fecha="+fecha+"", {
			randomnumber:randomnumber
		}, function(data){
		  $("#contenido").html(data);
		});
	}
}
function EliminarDisponibilidad(idfuncionario, fecha)
{
	mensaje = confirm("Eliminar fecha de disponibilidad?");
	if(mensaje==true)
	{
		ajax=nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax.open("POST", "inserts/DeleteDisponibilidad.php",true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("idfuncionario="+idfuncionario+"&fecha="+fecha+"&tiempo=" + new Date().getTime());
	}
}
</script>
<style type="text/css">
fieldset
{width:97%;
border-color:#FFF;}
.text
{font-family:Arial, Helvetica, sans-serif;
font-size:12px;
width:150px;
}
.textsmall
{font-family:Arial, Helvetica, sans-serif;
font-size:12px;
width:75px;
}
#textsmall
{font-family:Arial, Helvetica, sans-serif;
font-size:12px;
width:75px;
}
textarea
	{
		font-family:Verdana, Geneva, sans-serif;
		font-size:12px;
		width:100%;
		height:40px;
		resize:none;
		}
		body { font-family: Arial, Helvetica, sans-serif; font-size: small; }
	.table { background: white; width: 100%; font-size: small; margin-top: 1%;}
	.tr { border-top: 1px solid #C1C3D1; border-bottom-: 1px solid #C1C3D1; }
	.tr:first-child { border-top:none; }
	.tr:last-child {border-bottom:none; }
	.tr:nth-child(odd)
	.td { background:#EBEBEB; }
	.td { background:#FFFFFF; }
	.text-center { text-align: center; background-color: #000066; }
</style>
</head>
<body bgcolor="#FFFFFF">
<fieldset>
<legend>Registrar disponibilidades para:<strong><?php echo ucwords(strtolower($reg['nombres'])).'&nbsp;'.ucwords(strtolower($reg['apellidos'])) ?></strong></legend>
<form id="dispo" name="dispo" method="post" action="inserts/RegDisponibilidades.php">
  <table width="100%" border="0">
    <tr>
      <td width="25%">N° documento:<br>
        <label for="funcionario"></label>
      <input type="text" name="funcionario" id="funcionario" value="<?php echo $funcionario ?>" />
		  <input type="hidden" name="CurrentUser" id="CurrentUser" value="<?php echo $CurrentUser ?>" /></td>
      <td width="25%">Desde:<br>
        <label for="desde"></label>
      <input type="text" name="desde" id="desde" onchange="setInterval('Mostrardisp()',1000)" readonly="readonly"/></td>
      <script>
		  $(function() {
			  var dt = new Date();
			  var month = dt.getMonth()+ 1;
			  var day = dt.getDate();
			  var year = dt.getFullYear();
			  $( "#desde" ).datepicker({
				  changeMonth: false,
				  changeYear: false,
				  minDate: (year + '-' + month + '-' + '01'),
				  maxDate: (year + '-' + month + '-' + '<?php echo $dias; ?>')
			  });
		  });
		</script>
      <td width="25%">Hasta:<br>
        <label for="hasta"></label>
      <input type="text" name="hasta" id="hasta" readonly="readonly" />
      <script>
		  $(function() {
			  var dt = new Date();
			  var month = dt.getMonth()+ 1;
			  var day = dt.getDate();
			  var year = dt.getFullYear();
			  $( "#hasta" ).datepicker({
				  changeMonth: false,
				  changeYear: false,
				  minDate: (year + '-' + month + '-' + '01'),
				  maxDate: (year + '-' + month + '-' + '<?php echo $dias; ?>')
			  });
		  });
		</script>
      </td>
      <td width="25%"><br><input type="submit" name="button" id="button" value="Enviar" /></td>
    </tr>
    <tr>
      <td colspan="4"><div id="notificacion"></div></td>
    </tr>
  </table>
</form>
</fieldset>
<fieldset>
	<legend>Disponibilidades registradas</legend>
    <div id="contenido"> Seleccione una fecha en el campo desde, para ver las disponibilidades registradas en el mes</div>
</fieldset>
</body>
</html>