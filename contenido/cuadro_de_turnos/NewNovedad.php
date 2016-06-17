<?php
//Conexion a la base de datos
include('../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$Funcionario = base64_decode($_GET['funcionario']);
$Fecha = base64_decode($_GET['fecha']);
$idturno = base64_decode($_GET['idturno']);
$tipo = base64_decode($_GET['tipo']);
//consulta
$sqlFuncionario = mysql_query("SELECT nombres, apellidos FROM funcionario WHERE idfuncionario = '$Funcionario'", $cn);
$regFuncionario = mysql_fetch_array($sqlFuncionario);
//obtener datos del turno
$sqlTurno = mysql_query("SELECT * FROM turno_funcionario WHERE idturno = '$idturno'", $cn);
$regTurno = mysql_fetch_array($sqlTurno);
//variables
$grupoEmpleado = $regTurno['idgrupo_empleado'];
$sede = $regTurno['idsede'];
$idservicio = $regTurno['idservicio'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Turnos :.</title>
<script src="../../js/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="../../js/ajax.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="js/jquery.timepicker.css" />
<link href="../../js/demos/demos.css" rel="stylesheet" type="text/css">
<link href="../../js/themes/cupertino/jquery-ui.css" rel="stylesheet" type="text/css">
<script>
$(function() {
$( "#tabs" ).tabs();
});
 $(function() {
                    $('.Reloj').timepicker({ 'timeFormat': 'H:i' });
			 });
function MostrarNovedad()
{
	$(document).ready(function(){
	verlistado()
	})
	function verlistado(){
		var randomnumber=Math.random()*11;
		$.post("Query/NovedadesFuncionario.php?idturno=<?php echo $idturno ?>", {
			randomnumber:randomnumber
		}, function(data){
		  $("#contenido").html(data);
		});
	}
}
function guardar(opcion)
{
	var inicio, fin, servicio, nota, notificacion;
	inicio = document.Novedad.inicio.value;
	fin = document.Novedad.fin.value;
	servicio = document.Novedad.servicio.value;
	nota = document.Novedad.nota.value;
	idturno = document.Novedad.idturno.value;
	notificacion = document.getElementById('notificacion');
	mensaje = '<font color="#FF0000">No se admiten campos vacios</font>';
	if(inicio=="" || fin =="" || servicio =="" || idturno=="")
	{
		notificacion.innerHTML = mensaje;
	}
	else
	{
		ajax = nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax.open("POST", "Updates/UpdateNovedad.php",true);
		ajax.onreadystatechange = function() 
		{
			if (ajax.readyState==4) 
			{
				notificacion.innerHTML = ajax.responseText;
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("inicio="+inicio+"&fin="+fin+"&servicio="+servicio+"&nota="+nota+"&idturno="+idturno+"&opcion="+opcion+"&tiempo=" + new Date().getTime());
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
</style>
</head>
<body bgcolor="#FFFFFF" onLoad="setInterval('MostrarNovedad()',3000)">
<table width="100%">
	<tr>
    	<td width="50%" align="left">Funcionario: <?php echo $regFuncionario['nombres'].'&nbsp;'.$regFuncionario['apellidos']; ?></td>
        <td width="50%" align="right">Fecha: <?php echo $Fecha ?></td>
    </tr>
</table>
<div id="tabs">
  <ul>
    <li><a href="#tabs-2">Novedades</a></li>
</ul>
  <div id="tabs-2">
     <form id="Novedad" name="Novedad" method="post" action="#">
       <table width="100%" border="0">
         <tr>
           <td>Hora de inicio:</td>
           <td>Hora de finalizacion:</td>
           <td>Servicio:</td>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <td><label for="textfield"></label>
           <input type="text" name="iniOld" id="textsmall" value="<?php echo $regTurno ['hr_inicio']?>" readonly="readonly"/></td>
           <td><label for="textfield2"></label>
           <input type="text" name="finOld" id="textsmall" value="<?php echo $regTurno['hr_fin']?>" readonly="readonly" /></td>
           <td><select name="ServOld" id="ServOld" class="text">
             <?php
					//consultar servicios
					$Servicio = mysql_query("SELECT * FROM servicio WHERE idservicio = '$idservicio'", $cn);
					while($Servicio = mysql_fetch_array($Servicio))
					{
						echo '<option value="'.$Servicio['idservicio'].'">'.$Servicio['descservicio'].'</option>';
					}
				?>
           </select></td>
           <td><input type="hidden" name="idturno" id="idturno" value="<?php echo $idturno ?>" /></td>
         </tr>
         <tr>
           <td width="25%">Nueva hora de inicio:</td>
           <td width="25%">Nueva hora finalizacion:</td>
           <td width="25%">Servicio:</td>
           <td width="25%">&nbsp;</td>
         </tr>
         <tr>
           <td><input type="text" name="inicio" class="Reloj" id="textsmall" /></td>
           <td><input type="text" name="fin" class="Reloj" id="textsmall"/></td>
           <td><select name="servicio" id="servicio" class="text">
             <option value="">-- Seleccione --</option>
             <?php
					//consultar servicios
					$consServicio = mysql_query("SELECT * FROM servicio WHERE idestado_actividad = '1'", $cn);
					while($rowServicio = mysql_fetch_array($consServicio))
					{
						echo '<option value="'.$rowServicio['idservicio'].'">'.$rowServicio['descservicio'].'</option>';
					}
				?>
           </select></td>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <td colspan="2">Observaciones:</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <td colspan="3"><label for="nota"></label>
           <textarea name="nota" id="nota" cols="45" rows="5"></textarea></td>
           <td align="right">
           <input type="button" name="button" id="button" value="Agregar Horario" onclick="guardar('agregar')"/>
           <input type="button" name="button" id="button" value="Actualizar Horario" onclick="guardar('modificar')"/></td>
         </tr>
         <tr>
         	<td colspan="3"><div id="notificacion"></div></td>
            <td>&nbsp;</td>
         </tr>
       </table>
</form>
     <fieldset>
	<legend><h4>Novedades</h4></legend>
    <span id="contenido"></span>
</fieldset>
  </div>
</div><br>
<a href="RegistrarTurno.php?grupoEmpleado=<?php echo base64_encode($grupoEmpleado); ?>&Fecha=<?php echo base64_encode($Fecha) ?>&sede=<?php echo base64_encode($sede)?>&tipo=<?php echo base64_encode($tipo)?>&Funcionario=<?php echo base64_encode($Funcionario)?>">Regresar</a>
</body>
</html>