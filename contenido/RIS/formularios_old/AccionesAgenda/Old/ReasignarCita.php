<?php
	//conexion a la BD
	require_once("../../../../dbconexion/conexion.php");
	$cn = conectarse();
	$idInforme = base64_decode($_GET['idInforme']);
	$usuario = base64_decode($_GET['usuario']);
	//obtener los datos de la agenda
	$sql = mysql_query("SELECT l.hora, l.id_informe, l.fecha, i.id_paciente, i.idestudio, i.id_prioridad, i.id_extremidad, i.id_tecnica,
	i.ubicacion, i.idsede, i.idservicio,
	CONCAT(p.nom1,' ',p.nom2,' ',p.ape1,' ',p.ape2) AS paciente, p.edad, es.nom_estudio, pr.desc_prioridad, t.desc_tecnica FROM r_log_informe l
	INNER JOIN r_informe_header i ON i.id_informe = l.id_informe
	INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
	INNER JOIN r_estudio es ON es.idestudio = i.idestudio
	INNER JOIN r_prioridad pr ON pr.id_prioridad = i.id_prioridad
	INNER JOIN r_tecnica t ON t.id_tecnica = i.id_tecnica
	WHERE i.id_informe = '$idInforme'", $cn);
	$reg = mysql_fetch_array($sql);
	$servicio=$reg['idservicio'];	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script language="JavaScript" src="../../../../js/ajax.js"></script>
<script src="../../js/jquery.js"></script>
<script src="../../js/ui/jquery.ui.core.js"></script>
<script src="../../js/ui/jquery.ui.widget.js"></script>
<script src="../../../../js/ui/jquery.ui.datepicker.js"></script>
<script src="../../js/jquery.ui.timepicker.js"></script>
<script src="../../../../js/jquery.maskedinput.js"></script>
<script language="JavaScript" type="text/javascript" src="../javascript/ajax.js"></script>
<script src="../../js/jquery.form.js"></script>
<link href="../../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css">
<link href="../../styles/forms.css" rel="stylesheet" type="text/css">

<script language='javascript'>
function validar(usuario)
{
	var idInforme, observaciones,nfecha;
	//etiqueta donde se va a mostrar la respuesta
	respuesta = document.getElementById('respuesta');
	idInforme = document.ReasignarCita.idInforme.value;
	nfecha= document.ReasignarCita.nfecha.value;
	nhora= document.ReasignarCita.nhora.value;
	estudio= document.ReasignarCita.estudio.value;
	tecnica= document.ReasignarCita.tecnica.value;
	observaciones = document.ReasignarCita.observaciones.value;
	mensaje = confirm("Seguro que desea Reasignar la cita ?");
	if(mensaje == true)
	{
		ajax=nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax.open("POST", "AccionReasignarCita.php",true);
		ajax.onreadystatechange = function() 
		{
			if (ajax.readyState==4) 
			{
				respuesta.innerHTML = ajax.responseText;
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("idInforme="+idInforme+"&observaciones="+observaciones+"&usuario="+usuario+"&nfecha="+nfecha+"&nhora="+nhora+"&estudio="+estudio+"&tecnica="+tecnica+"&tiempo=" + new Date().getTime());
		
		setTimeout(function(){window.close()},3000);
	}
}
$(function() {
		$( ".datepicker" ).datepicker({ minDate: 0, maxDate: "+2M" });
	});

jQuery(function($){
   $(".hora").mask("99:99");
});
</script>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Reasignar Cita :.</title>
<style>
	body
	{
		font-family:Arial, Helvetica, sans-serif;
		font-size:12px;
	}
	textarea
	{
		font-family:Arial, Helvetica, sans-serif;
		font-size:12px;
		width:98%;
		height:50px;
		resize:none;
	}
	.select
	{font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	width:255px;
	}
	fieldset
	{width:90%;
	margin-left:3%;
	margin-top:2%;
	}
	#text
	{font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	width:250px;
	}
</style>
</head>
<body onBeforeUnload="return window.opener.mostrarAgenda();">
<fieldset>
<legend><strong>Reasignar / Reprogramar cita</strong></legend>
<form id="ReasignarCita" name="ReasignarCita" method="post" action="#">
  <table width="100%" align="center">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>Paciente:</strong></td>
    </tr>
    <tr>
      <td width="33%">N° de identificacion: <strong><?php echo $reg['id_paciente'] ?></strong></td>
      <td width="33%">Nombres y Apellidos: <strong><?php echo $reg['paciente'] ?></strong></td>
      <td  width="33%">Edad: <strong><?php echo $reg['edad']?>(S)</strong></td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>Informacion de la agenda:</strong></td>
    </tr>
    <tr>
      <td>Estudio:</td>
      <td>Tecnica:</td>
      <td>Fecha y Hora</td>
    </tr>
    <tr>
    <td><select name="estudio" id="estudio" class="select">
      <option value="">.: Seleccione :.</option>
      <?php
      	//realizar consulta para obtener listado de estudios del servicio
		$sqlEstudio = mysql_query("SELECT idestudio, nom_estudio FROM r_estudio WHERE idservicio = '$servicio' AND idestado = '1' ORDER BY nom_estudio ASC ", $cn);
            	while($rowEstudio = mysql_fetch_array($sqlEstudio))
				{
				?>
      <option value="<?php echo $rowEstudio['idestudio']?>"
                <?php
                	if($rowEstudio['idestudio']==$reg['idestudio'])
					{
				?>
                 selected="selected"
					<?php
					}
					?>
                    > <?php echo $rowEstudio['nom_estudio']?></option>
      <?php
				}
			?>
    </select>
      <font size="2" color="#FF0000">*</font></td>
      <td><select name="tecnica" class="select">
        <?php
	  $listaTecnica = mysql_query("SELECT * FROM r_tecnica", $cn);
      while($rowTecnica = mysql_fetch_array($listaTecnica))
				{
				?>
        <option value="<?php echo $rowTecnica['id_tecnica']?>"
                <?php
                	if($rowTecnica['id_tecnica']==$reg['id_tecnica'])
					{
				?>
                 selected="selected"
					<?php
					}
					?>
                    > <?php echo $rowTecnica['desc_tecnica']?></option>
        <?php
				}
			?>
      </select>
        <font size="2" color="#FF0000">*</font></td>
      <td><strong>
        <?php $fecha=$reg['fecha'];
	  list($año,$mes,$dia)=explode("-",$fecha); 
	  echo $mes.'/'.$dia.'/'.$año?>
         - <?php echo $reg['hora']?></strong><br />
      <label for="tecnica"></label></td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>Asignar nueva fecha y hora para la cita:</strong></td>
    </tr>
    <tr>
      <td><strong>Nueva Fecha:</strong><br>
      <input type="text" name="nfecha" id="text" class="datepicker" /><font size="2" color="#FF0000"> *</font>
      <input type="hidden" name="idInforme" id="idInforme" value="<?php echo $idInforme ?>" /></td>
      <td><strong>Nueva Hora:</strong><br>
      <input type="text" name="nhora" id="text" class="hora" />        
      <font size="2" color="#FF0000"> *</font><br></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>Observaciones:</strong></td>
    </tr>
    <tr>
      <td colspan="3"><textarea name="observaciones" id="observaciones" cols="60" rows="5"></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div id="respuesta"></div></td>
      <td align="right"><input type="button" name="Reasignar Agenda" id="button" value="Reasignar Agenda" onclick="validar(<?php echo $usuario ?>)" /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</fieldset>
</body>
</html>