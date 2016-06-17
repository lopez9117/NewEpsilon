<?php
	//archivo de conexion
	include("../../../../dbconexion/conexion.php");
	$cn = conectarse();
	//variables GET
	$idInforme = base64_decode($_GET['informe']);
	$usuario = base64_decode($_GET['user']);
	//obtener los datos del encabezado para el informe
	$sqlHeader = mysql_query("SELECT i.id_informe, i.ubicacion, i.id_paciente, i.orden, i.idfuncionario_esp, p.nom1, p.nom2,
	p.ape1, p.ape2, p.fecha_nacimiento, e.nom_estudio,p.edad,
	sex.desc_sexo, l.fecha, l.hora, t.desc_tecnica, ex.desc_extremidad, f.nombres, f.apellidos FROM r_informe_header i
	INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
	INNER JOIN r_estudio e ON e.idestudio = i.idestudio
	INNER JOIN r_sexo sex ON sex.id_sexo = p.id_sexo
	INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
	INNER JOIN r_tecnica t ON t.id_tecnica = i.id_tecnica
	INNER JOIN r_extremidad ex ON ex.id_extremidad = i.id_extremidad
	INNER JOIN funcionario f ON f.idfuncionario = i.idfuncionario_esp
	WHERE i.id_informe = '$idInforme' AND l.id_estadoinforme = '3'", $cn);
	$regHeader = mysql_fetch_array($sqlHeader);
	$especialista = $regHeader['idfuncionario_esp'];
	//validar si el informe ya se transcribio o no
	$conTranscripcion = mysql_query("SELECT * FROM r_detalle_informe WHERE id_informe = '$idInforme'", $cn);
	$countTranscripcion = mysql_num_rows($conTranscripcion);
	if($countTranscripcion>=1)
	{
		$regTranscripcion = mysql_fetch_array($conTranscripcion);
		$contenido = $regTranscripcion['detalle_informe'];
	}
	else
	{
		//obtener los datos de la plantilla del especialista
		$sqlPlantilla = mysql_query("SELECT p.contenido, t.desc_tecnica FROM r_plantilla p
		INNER JOIN r_tecnica t ON t.id_tecnica = p.id_tecnica
		WHERE p.idestudio = '$idestudio' AND p.idfuncionario_esp = '$especialista' AND p.id_tecnica = '$tecnica'", $cn);
		$regPlantilla = mysql_fetch_array($sqlPlantilla);
		$contenido = $regPlantilla['contenido'];
	}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE = 7, 8, 9, 10" />
<title>.: Transcribir Informe :.</title>
<script type="text/javascript" src="../../../../js/ajax.js"></script>
<script type="text/javascript" src="../../../../js/jquery.js"></script>
<script type="text/javascript" src="../../fckeditor/fckeditor.js"></script>
<script src="../../ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<link href="../../ckeditor/skins/moono/editor.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
    CKEDITOR.config.height = 600
</script>
<script language="javascript">
$( document ).ready( function() {
	$("a[rel='pop-up']").click(function () {
      	var caracteristicas = "height=600,width=1000,scrollTo,resizable=1,scrollbars=1,location=0";
      	nueva=window.open(this.href, 'Popup', caracteristicas);
      	return false;
 });
});
	function Guardar(opcion)
	{
		if(opcion=="parcial")
		{
			document.Informe.opcion.value = "parcial";
			document.Informe.submit();
			return window.opener.CargarAgenda();
		}
		else
		{
			document.Informe.opcion.value = "finalizar";
			document.Informe.submit();
			return window.opener.CargarAgenda();
		}
	}
	
function marcarLeido(informe)
{
	var informe, usuario;
	usuario = document.Informe.especialista.value;
	
	opcion = confirm("Marcar como Leido? (El informe estara disponible para transcripción)")
	if(opcion==true)
	{
		ajax=nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax.open("POST", "../acciones/actualizarLecturaPendiente.php",true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("informe="+informe+"&usuario="+usuario+"&tiempo=" + new Date().getTime());
		
		window.close();
	}
	
}
</script>
<style type="text/css">
	body
{font-family:Arial, Helvetica, sans-serif;
font-size:12px;
background: -moz-linear-gradient(top, rgba(232,232,232,1) 0%, rgba(232,232,232,0.99) 1%, rgba(229,229,229,0.55) 45%, rgba(229,229,229,0) 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(232,232,232,1)), color-stop(1%,rgba(232,232,232,0.99)), color-stop(45%,rgba(229,229,229,0.55)), color-stop(100%,rgba(229,229,229,0))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, rgba(232,232,232,1) 0%,rgba(232,232,232,0.99) 1%,rgba(229,229,229,0.55) 45%,rgba(229,229,229,0) 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, rgba(232,232,232,1) 0%,rgba(232,232,232,0.99) 1%,rgba(229,229,229,0.55) 45%,rgba(229,229,229,0) 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, rgba(232,232,232,1) 0%,rgba(232,232,232,0.99) 1%,rgba(229,229,229,0.55) 45%,rgba(229,229,229,0) 100%); /* IE10+ */
background: linear-gradient(to bottom, rgba(232,232,232,1) 0%,rgba(232,232,232,0.99) 1%,rgba(229,229,229,0.55) 45%,rgba(229,229,229,0) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e8e8e8', endColorstr='#00e5e5e5',GradientType=0 ); /* IE6-9 */
}
fieldset
{width:98%;
border-color:#FFF;}
table
{width:100%;
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
}
input.text
{font-family:Arial, Helvetica, sans-serif;
font-size:12px;
width:88%;
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
<script language="javascript">
function Cargar(informe, especialista)
{
	var informe, especialista;
	//Codigo ajax para enviar datos al servidor y obtener respuesta
	//etiqueta donde se va a mostrar la respuesta
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST", "RegistroVentana.php",true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("informe="+informe+"&especialista="+especialista+"&tiempo=" + new Date().getTime());
}

<!-- 
document.write('<style type="text/css">div.cp_oculta{display: none;}</style>'); 
function MostrarOcultar(capa,enlace) 
{ 
    if (document.getElementById) 
    { 
        var aux = document.getElementById(capa).style; 
        aux.display = aux.display? "":"block"; 
    } 
} 
</script>
</head>
<body onBeforeUnload="return window.opener.CargarAgenda();">
<form name="Informe" id="Informe" method="post" action="../acciones/RegistrarNuevoInforme.php">
<fieldset>
   	<legend><strong>Informe de Lectura:</strong></legend>
      <table width="100%" border="0">
          <tr>
            <td width="20%"><strong>Paciente:</strong></td>
            <td width="20%"><strong>N° de documento: </strong><?php echo $regHeader['id_paciente']?></td>
            <td width="20%"><strong>N° de Ingreso: </strong><?php echo $regHeader['orden']?></td>
            <td width="20%"><strong>Edad: </strong><?php echo $regHeader['edad'] ?>(S)</td>
            <td width="20%"><strong>Genero: </strong><?php echo $regHeader['desc_sexo']?></td>
          </tr>
          <tr>
            <td><?php echo $regHeader['nom1'].'&nbsp;'.$regHeader['nom2'].'&nbsp;'.$regHeader['ape1'].'&nbsp;'.$regHeader['ape2']?></td>
            <td><strong>Ubicación: </strong> <?php echo $regHeader['ubicacion']?></td>
            <td><strong>Fecha de la cita: </strong><?php echo $regHeader['fecha']?></td>
            <td><strong>Hora de la cita: </strong><?php echo $regHeader['hora']?></td>
            <td><strong>EPS: </strong><?php echo $regHeader['desc_eps']?></td>
          </tr>
          <tr>
            <td colspan="2"><strong>Estudio: </strong><?php echo $regHeader['nom_estudio']?></td>
            <td><strong>Tecnica: </strong><?php echo $regHeader['desc_tecnica']?></td>
            <td><strong>Extremidad: </strong><?php echo $regHeader['desc_extremidad']?></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><strong>Adicional: </strong>
            <input class="text" type="text" name="adicional" id="adicional" value="<?php echo $regTranscripcion['adicional']?>" placeholder="Registre aqui las adiciones al estudio" /></td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="5"><textarea class="ckeditor" cols="150" id="ResultadoInforme" name="ResultadoInforme" rows="10"><?php echo $contenido?></textarea>	</td>
          </tr>
          <tr>
            <td colspan="2"><strong>Leido por</strong> :<?php echo $regHeader['nombres'].'&nbsp;'.$regHeader['apellidos']?></td>
            <td><input type="hidden" name="idInforme" id="idInforme" value="<?php echo $idInforme ?>" />
              <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>" />
            <input type="hidden" name="opcion" /></td>
            <td colspan="2" align="right"><input type="button" name="button" id="button" value="Guardar Parcial" onclick="Guardar('parcial')"/>              <input type="button" name="button2" id="button2" value="Guardar y Finalizar" onclick="Guardar('finalizar')"/></td>
          </tr>
    </table>
  </fieldset>
<fieldset>
<legend><strong>Registrar Observación</strong></legend>
<table width="100%" align="center">
  <tr>
    <td colspan="5">
    <textarea name="observacionTranscripcion"></textarea>
    </td>
  </tr>
</table>
</fieldset>
<table width="100%" align="center">
	<tr>
    	<td width="100%"><a class="texto" href="javascript:MostrarOcultar('observaciones');">Ver / Ocultar todas las observaciones</a></td>
    </tr>
</table>
</form>
<div class="cp_oculta" id="observaciones"> 
<table width="100%" align="center">
	
    <?php
	//consultar observaciones realizadas en el informe
	$sqlObservacion =  mysql_query("SELECT o.idfuncionario, o.observacion, o.fecha, o.hora, f.nombres, f.apellidos
	FROM r_observacion_informe o
	INNER JOIN funcionario f ON f.idfuncionario = o.idfuncionario
	WHERE o.id_informe = '$idInforme'", $cn);
	$conObservacion = mysql_num_rows($sqlObservacion);
	if($conObservacion==0 || $conObservacion=="")
	{
		echo '<tr>
    		<td>No se han registrado observaciones</td>
    	</tr>';
	}
	else
	{
		while($rowObservacion = mysql_fetch_array($sqlObservacion))
		{
			?>
			 <tr>
		  <td>
          <fieldset>
          <legend><strong> <?php echo $rowObservacion['nombres'].' '.$rowObservacion['apellidos'] ?> </strong>hizo la siguiente observación,  las <?php echo $rowObservacion['hora']?> del <?php echo $rowObservacion['fecha']?></legend>
         <label for="area"></label>
		  <textarea name="area" id="area" cols="45" rows="5" readonly="readonly"><?php echo $rowObservacion['observacion'] ?></textarea>
          </fieldset>
          </td>
		</tr>
			<?php
		}
	}
	?>
</table>
</div>
</body>
</html>