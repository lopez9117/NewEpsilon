<?php
	//conexion a la base de datos
	require_once("../../../dbconexion/conexion.php");
	$cn = conectarse();
	//archivo con listas seleccionables
	include("../select/selects.php");
	$Idinforme = base64_decode($_GET['idInforme']);
	$usuario = base64_decode($_GET['usuario']);
	$sql = mysql_query("SELECT e.cod_iss, e.nom_estudio, l.hora, l.id_informe, l.fecha,i.orden, i.idservicio, i.id_paciente, i.idestudio, i.id_prioridad,p.id_sexo, i.id_extremidad, i.desc_extremidad, i.id_tecnica,
	i.ubicacion, i.idsede, i.idservicio,i.portatil, i.idtipo_paciente, i.id_prioridad, i.medico_solicitante, i.fecha_solicitud,i.hora_solicitud, p.nom1,p.nom2,p.ape1,p.ape2, p.edad FROM r_log_informe l
	INNER JOIN r_informe_header i ON i.id_informe = l.id_informe
	INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
  INNER JOIN r_estudio e ON e.idestudio=i.idestudio
	WHERE i.id_informe = '$Idinforme' AND l.id_estadoinforme=1", $cn);
	$reg = mysql_fetch_array($sql);
	$fechasolicitud = date("m/d/Y",strtotime($reg['fecha_solicitud']));
	$fechacita = date("m/d/Y",strtotime($reg['fecha']));
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
<head>
<title>Agendar Paciente</title>
<script src="../../../js/ui/jquery.ui.datepicker.js"></script>
<script src="../../../js/jquery.form.js"></script>
<script language="javascript" src="../../../js/jquery.js" type="text/javascript"></script>
<script language="javascript" src="../../../js/jquery.maskedinput.js" type="text/javascript"></script>
<script language="javascript" src="../../../js/jquery.form.js"></script>
<script language="javascript" src="../js/jquery-ui-1.10.0.custom.min.js"></script>
<link href="../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css">
<link href="../styles/forms.css" rel="stylesheet" type="text/css">
<script src="JavasScript/FuncionesAgendamiento.js"></script>
<script src="../js/ajax.js"></script>
<style type="text/css">
.asterisk {
	color: #F00;
}
</style>
<style type="text/css">
	input.text, select.text
	{
		width:250px;
		}
		input.textmedium, select.textmedium
	{
		width:113px;
		}
		input#textmedium, select#textmedium
	{
		width:113px;
		}
</style>
</head>
<body onBeforeUnload="return window.opener.mostrarAgenda();" onload="mostrarServicio();buscarCups();">
<form name="nuevo_informe" id="nuevo_informe" method="post" action="AccionesAgenda/AccionModificar.php" enctype="multipart/form-data">
<fieldset>
    <legend><strong>Tipo de modificacion: </strong></legend>
    <table width="90%" border="0">
<tr>
      <td width="16%">
      <strong>MODIFICAR </strong>
<input type="radio"  id="tipo" name="tipo" value="modificar" checked="checked" onclick="CargarForm()" />
</td>
    </tr>
    </table>
    <fieldset>
    <fieldset>
    <legend><strong>Informaci&oacute;n del paciente</strong></legend>
  <table width="90%" border="0">
    <tr>
      <td width="16%"><strong>N&deg; Documento</strong><br><label for="ndocumento"></label>
      <input type="text" name="ndocumento" value="<?php echo $reg['id_paciente'] ?>" placeholder="Numero de documento" class="textmedium" disabled="disabled" /><span class="asterisk">*</span></td>
      <td width="16%"><strong>1&deg; Nombre</strong><br><label for="pnombre"></label>
      <input type="text" name="pnombre" value="<?php echo $reg['nom1'] ?>" disabled="disabled" placeholder="Primer Nombre" class="textmedium" /><span class="asterisk">*</span></td>
      <td width="16%"><strong>2&deg; Nombre</strong><br><label for="snombre"></label>
      <input type="text" name="snombre" value="<?php echo $reg['nom2'] ?>" disabled="disabled" placeholder="Segundo Nombre" class="textmedium"/></td>
      <td width="16%"><strong>1&deg; Apellido</strong><br><label for="papellido"></label>
      <label for="papellido"></label>
      <input type="text" name="papellido" value="<?php echo $reg['ape1'] ?>" disabled="disabled" placeholder="Primer Apellido" class="textmedium" /><span class="asterisk">*</span></td>
      <td width="16%"><strong>2&deg; Apellido</strong><br><label for="sapellido"></label>
      <input type="text" name="sapellido" value="<?php echo $reg['ape2'] ?>" disabled="disabled" placeholder="Segundo Apellido" class="textmedium" />
<input type="hidden" name="genero" value="<?php echo $reg['id_sexo'] ?>" disabled="disabled" placeholder="Segundo Apellido" class="textmedium" />
<input type="hidden" name="edad" id="edad" size="8" value="<?php echo $Idinforme ?>" class="textSmall"/>
<input type="hidden" name="VistaEps" id="VistaEps" value="1"/>
      </td>
      
    </tr>
    </table>
    </fieldset>
    <fieldset>
    <table width="90%">
	<legend><strong>Informaci&oacute;n para la agenda</strong></legend>
  <tr>
    <td width="25%"><strong>N&deg; orden / Ingreso</strong><br />
      <input type="text" name="norden" class="text" placeholder="Numero de ingreso u orden de servicio" value="<?php echo $reg['orden']?>" onfocus="ValidarCita();"/>
      <span class="asterisk">*</span></td>
    <td width="25%"><strong>Sede</strong><br />
      <select name="sede" id="sede" class="text">
        <option value="" onchange="ValidarCita();">.: Seleccione :.</option>
        <?php 
	  	while($rowSede = mysql_fetch_array($listaSede))
		{?>
        <option value="<?php echo $rowSede['idsede']?>"
            <?php if($rowSede['idsede'] == $reg['idsede'])
			{
				echo 'selected';
			}?>><?php echo $rowSede['descsede']?></option>
        ';
		
        <?php
        }
	  ?>
      </select>
      <span class="asterisk">*</span></td>
    <td colspan="2"><strong>Estudio</strong><br />
      <input type="text" name="Vistaestudio" id="Vistaestudio" onkeyup="this.value=this.value.toUpperCase();ValidarCita();" onfocus="buscarCups();ValidarCita();" style="width:90%; font-family:Arial, Helvetica, sans-serif; font-size:11px;" placeholder="Ingresar nombre del estudio o procedimiento" onblur="mostrarServicio()" value="<?php echo $reg['cod_iss'].' - '.utf8_decode($reg['nom_estudio'])?>"/>
      <span class="asterisk">*</span></td>
    </tr>
  <tr>
    <td id="selectServicio"><strong>Servicio</strong><br />
      <select name="servicio" class="text" id="servicio" onchange="ValidarCita();">
        <?php  
		while($rowServicio = mysql_fetch_array($listaServicio))
		{?>
        <option value="<?php echo $rowServicio['idservicio']?>"
            <?php if($rowServicio['idservicio'] == $reg['idservicio'])
			{
				echo 'selected';
			}?>><?php echo $rowServicio['descservicio']?></option>
        ';
		
        <?php
        }
	  ?>
      </select>
      <span class="asterisk"> *</span></td>
    <td><strong>Tecnica</strong><br />
      <select name="tecnica" class="text" onblur="ValidarEstudio()" onchange="ValidarEstudio();ValidarCita();">
      <?php 
	  	while($rowTecnica = mysql_fetch_array($listaTecnica))
		{?>
        <option value="<?php echo $rowTecnica['id_tecnica']?>"
            <?php if($rowTecnica['id_tecnica'] == $reg['id_tecnica'])
			{
				echo 'selected';
			}?>><?php echo $rowTecnica['desc_tecnica']?></option>
        ';
		
        <?php
        }
	  ?>
      </select>
      <span class="asterisk">*</span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Lado</strong><br />
      <select name="lado" id="lado" class="text" onchange="ValidarCita();">
        <?php
      	while($rowExtremidad = mysql_fetch_array($listaExtremidad))
		{?>
        <option value="<?php echo $rowExtremidad['id_extremidad']?>"
            <?php if($rowExtremidad['id_extremidad'] == $reg['id_extremidad'])
			{
				echo 'selected';
			}?>><?php echo $rowExtremidad['desc_extremidad']?></option>
        ';
		
        <?php
        }
	  ?>
        </select>
      <span class="asterisk">*</span></td>
    <td><strong>Extremidad:</strong><br><input type="text" name="Extremidad" class="text" placeholder="Ejemplo:(Mano, Pie, Cuello de pie, Muñeca, entre otros...)" onkeyup="this.value=this.value.toUpperCase();ValidarCita();" onfocus="BuscarExtremidad();ValidarCita();" id="Extremidad" value="<?php echo utf8_decode($reg['desc_extremidad'])?>" /></td>
    <td width="25%"><strong>Adicional:</strong><br />
      <input type="text" name="adicional" class="text" placeholder="Registrar adiciones al estudio solo si es necesario" onkeyup="this.value=this.value.toUpperCase()" onfocus="BuscarAdicional()" id="adicional" value="<?php echo $reg['adicional']?>" /></td>
    <td width="25%"><strong>Portail</strong><br />
      <input type="checkbox" name="portatil" id="portatil" value="1"  onchange="ValidarCita();"
      <?php if ($reg['portatil']==1)
	  {
		  echo 'checked="checked" value="1"';
		}
	  ?>
      /></td>
  </tr>
  <tr>
    <td><strong>Tipo paciente</strong><br>
      <select name="tipopaciente" id="tipopaciente" class="text" onchange="ValidarCita();">
        <option value="">.: Seleccione :.</option>
        <?php
      	while($rowTipoPaciente = mysql_fetch_array($ListaTipoPAciente))
		{?>
        <option value="<?php echo $rowTipoPaciente['idtipo_paciente']?>"
            <?php if($rowTipoPaciente['idtipo_paciente'] == $reg['idtipo_paciente'])
			{
				echo 'selected';
			}?>><?php echo $rowTipoPaciente['desctipo_paciente']?></option>		
        <?php
        }
	  ?>
        </select>
      <span class="asterisk">*</span></td>
    <td><strong>Prioridad</strong><br>
      <select name="prioridad" id="prioridad" class="text" onchange="ValidarCita();">
        <option value="">.: Seleccione :.</option>
        <?php
      	while($rowPrioridad= mysql_fetch_array($listaPrioridad))
		
		{?>
        <option value="<?php echo $rowPrioridad['id_prioridad']?>"
            <?php if($rowPrioridad['id_prioridad'] == $reg['id_prioridad'])
			{
				echo 'selected';
			}?>><?php echo $rowPrioridad['desc_prioridad']?></option>		
        <?php
        }
	  ?>
        </select>
      <span class="asterisk">*</span></td>
    <td><strong>Ubicacion</strong><br>
      <input type="text" name="ubicacion" class="text" placeholder="Ubicación del paciente" onkeyup="this.value=this.value.toUpperCase();ValidarCita();" value="<?php echo $reg['ubicacion']?>" />
      <span class="asterisk">*</span></td>
    <td><strong>Medico solicitante</strong><br>
      <input type="text" name="medsolicita" id="medsolicita" class="text" placeholder="Medico que solicita el estudio" onkeyup="this.value=this.value.toUpperCase();ValidarCita();" value="<?php echo $reg['medico_solicitante']?>" /></td>
  </tr>
  <tr>
    <td><dt><label><strong>Archivos a Subir:</strong></label></dt>
        <!-- Esta div contendrá todos los campos file que creemos --><div id="archivos">
   <dd><div id="adjuntos">
        <!-- Hay que prestar atención a esto, el nombre de este campo debe siempre terminar en []
        como un vector, y ademas debe coincidir con el nombre que se da a los campos nuevos 
        en el script -->
   <input type="file" name="archivos[]" onchange="ValidarCita();" /><br />
   </div></dd>
   <dt><a href="#" onClick="addCampo()">Subir otro archivo</a></dt>
   </div></td>

    <td><strong>Fecha y hora de solicitud</strong><br>
      <input name="fechasolicitud" type="text" class="datepicker2" value="<?php echo $fechasolicitud ?>" id="textmedium" readonly="readonly" onchange="ValidarCita();" />
      <span class="asterisk">*</span>
      <input type="text" name="horasolicitud" placeholder="00:00" class="textmedium" id="hora" value="<?php echo $reg['hora_solicitud'] ?>" onchange="ValidarCita();"/>
      <span class="asterisk">*</span></td>
    <td colspan="2"><strong>Fecha y hora de la cita</strong><br>
      <input type="text" name="fechacita" class="datepicker" value="<?php echo $fechacita ?>" readonly="readonly" disabled="disabled" />
      <span class="asterisk">*</span>
      <input type="text" name="horacita" placeholder="00:00" class="textmedium" id="hora2" onchange="ValidarCita();" onblur="ValidarCita()" value="<?php echo $reg['hora'] ?>" disabled="disabled"/>
      <span class="asterisk">*</span></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="button" onclick="ValidarAgenda()" name="cancelar" id="cancelar" value="cancelar" style="display:none" /></td>
  </tr>
  <tr>
    <div id="motivo_cancel"><td colspan="4"><strong>Observacion:</strong>
    <input name="tipo_comentario" type="radio" value="1" checked="checked" onchange="ValidarCita();"/>
      <strong>Evento Adverso:</strong>
    <input name="tipo_comentario" type="radio" value="2" onchange="ValidarCita();"/>
    </td>
    </div>
    </tr>
  <tr>
  <tr>
    <td colspan="4">
      <textarea name="observaciones" id="observaciones" cols="45" rows="5" placeholder="Realizar las observaciones necesarias" style="width:60%" onfocus="ValidarCita();"></textarea><span class="asterisk">*</span></td>
      <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>" /></td>
      <div id="Valestudio"></div>
    </tr>
  <tr>
    <td colspan="3"><div id="resultado"></div></td>
    <td colspan="3"><input type="button" name="guardar" id="guardar" value="Guardar" onclick="ValidarAgenda()"/></td>
  </tr>
  <tr>
    <td><label for="fechasolicitud"></label></td>
    <td><label for="horasolicitud"></label></td>
    <td><label for="fechacita"></label></td>
    <td><label for="horacita"></label></td>
  </tr> 
</table>
</fieldset>
</form>
</body>
</html>