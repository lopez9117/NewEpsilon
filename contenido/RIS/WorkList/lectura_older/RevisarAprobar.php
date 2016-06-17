<?php
//archivo de conexion
require_once("../../../../dbconexion/conexion.php");
$cn = conectarse();
//variables GET
$idInforme = base64_decode($_GET['informe']);
$especialista = base64_decode($_GET['especialista']);
$funcionarioEsp = $especialista;
//obtener los datos del encabezado para el informe
$sqlHeader = mysql_query("SELECT i.id_informe, i.ubicacion, i.id_paciente, i.orden,CONCAT(p.nom1,' ', p.nom2,
'<br>',p.ape1,' ', p.ape2) AS nombres, p.edad, e.nom_estudio, pr.desc_prioridad,
sex.desc_sexo, l.fecha, l.hora, t.desc_tecnica, ex.desc_extremidad, ep.desc_eps FROM r_informe_header i
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio e ON e.idestudio = i.idestudio
INNER JOIN r_prioridad pr ON pr.id_prioridad = i.id_prioridad
INNER JOIN r_sexo sex ON sex.id_sexo = p.id_sexo
INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
INNER JOIN r_tecnica t ON t.id_tecnica = i.id_tecnica
INNER JOIN r_extremidad ex ON ex.id_extremidad = i.id_extremidad
INNER JOIN eps ep ON ep.ideps=p.ideps
WHERE i.id_informe = '$idInforme' AND l.id_estadoinforme = 1", $cn);
$regHeader = mysql_fetch_array($sqlHeader);
//validar si el informe ya se transcribio o no
$conTranscripcion = mysql_query("SELECT detalle_informe, id_tipo_resultado FROM r_detalle_informe WHERE id_informe = '$idInforme'", $cn);
$countTranscripcion = mysql_num_rows($conTranscripcion);
if($countTranscripcion>=1)
{
	$regTranscripcion = mysql_fetch_array($conTranscripcion);
	$consEspecialista = mysql_query("SELECT CONCAT(nombres,' ', apellidos) AS nombres FROM funcionario WHERE idfuncionario = '$especialista'", $cn);
	$nombEspecialista = mysql_fetch_array($consEspecialista);
	$contenido = $regTranscripcion['detalle_informe'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
<title>.: Revisar aprobar Informe :.</title>
<script type="text/javascript" src="../../../../js/ajax.js"></script>
<script type="text/javascript" src="../../../../js/jquery.js"></script>
<script type="text/javascript" src="../../fckeditor/fckeditor.js"></script>
<script src="../../ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<link href="../../ckeditor/skins/moono/editor.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
CKEDITOR.config.height = 450
</script>
<script language="javascript">
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
		document.Informe.opcion.value = "aprobar";
		document.Informe.submit();
		return window.opener.CargarAgenda();
	}
}
</script>
<style type="text/css">
body
{font-family:Arial, Helvetica, sans-serif;
font-size:12px;
background-color:#999;
color:#FFF;}
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
<body class="body" onBeforeUnload="return window.opener.misEstudios();">
<form name="Informe" id="Informe" method="post" action="AccionRevisarAprobar.php">
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
<td><?php echo $regHeader['nombres']?></td>
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
<td colspan="2"><strong>Leido por</strong> : <?php echo $nombEspecialista['nombres']?>
  <input type="hidden" name="idInforme" id="idInforme" value="<?php echo $idInforme ?>" />
  <input type="hidden" name="especialista" id="especialista" value="<?php echo $especialista ?>" />
<input type="hidden" name="opcion" /></td>
<td><?php
        	//consultar tipo de resultado
			$consTipoResultado = mysql_query("SELECT * FROM r_tipo_resultado", $cn);
		?>
        <select name="tipoResultado">
        	<option value="0">.: Seleccione :.</option>
            <?php
            	while($rowTipo = mysql_fetch_array($consTipoResultado))
				{?>
					<option value="<?php echo $rowTipo['id_tipo_resultado']?>"
                    <?php
                    	if($rowTipo['id_tipo_resultado'] == $regTranscripcion['id_tipo_resultado'])
						{
							echo 'selected="selected"';
						}
					?>><?php echo $rowTipo['desc_tipo_resultado'] ?></option>
				<?php
                }
			?>
        </select></td>
<td colspan="2" align="right">
  <input type="button" name="button" id="button" value="Guardar Parcial" onclick="Guardar('parcial')"/>
<input type="button" name="button2" id="button2" value="Guardar y Aprobar" onclick="Guardar('aprobar')"/></td>
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
mysql_close($cn);
?>
</table>
</div>
</body>
</html>