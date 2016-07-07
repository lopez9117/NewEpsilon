<?php
	//archivo de conexion a la BD
	require_once("../../../dbconexion/conexion.php");
	$cn = conectarse();	
	//Variables por GET
	$idInforme = base64_decode($_GET['idInforme']);
	//consulta
	$sql = mysql_query("SELECT l.hora, l.id_informe, l.fecha, i.id_paciente, i.idestudio, i.id_prioridad, i.id_extremidad, i.id_tecnica,
	i.ubicacion, i.idsede, i.idservicio, i.adjunto,
	p.nom1, p.nom2, p.ape1, p.ape2, es.nom_estudio, pr.desc_prioridad, t.desc_tecnica FROM r_log_informe l
	INNER JOIN r_informe_header i ON i.id_informe = l.id_informe
	INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
	INNER JOIN r_estudio es ON es.idestudio = i.idestudio
	INNER JOIN r_prioridad pr ON pr.id_prioridad = i.id_prioridad
	INNER JOIN r_tecnica t ON t.id_tecnica = i.id_tecnica
	WHERE i.id_informe = '$idInforme'", $cn);
	$reg = mysql_fetch_array($sql);
	$servicio = $reg['idservicio'];	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Modiicar Información del Estudio :.</title>
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
<style type="text/css">
	body{
		font-family:Arial, Helvetica, sans-serif;
		font-size:11px;
	}
	fieldset
	{width:95%;
	}
	.text
	{width:200px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	}
	.select
	{
		width:210px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	}
</style>
<script language="javascript">
	function validar()
	{
		var ubicacion;
		estudio= document.CambiarUbicacion.estudio.value;
		tecnica= document.CambiarUbicacion.tecnica.value;
		ubicacion = document.CambiarUbicacion.ubicacion.value;
		if(ubicacion=="")
		{
			mensaje = '<font color="#FF0000">Por favor ingrese una ubicación para el paciente</font>';
			document.getElementById('respuesta').innerHTML = mensaje;
		}
		else
		{
			document.getElementById('respuesta').innerHTML = "";
			document.CambiarUbicacion.submit();
		}
	}
</script>
<script type="text/javascript">
var numero = 0; //Esta es una variable de control para mantener nombres
            //diferentes de cada campo creado dinamicamente.
evento = function (evt) { //esta funcion nos devuelve el tipo de evento disparado
   return (!evt) ? event : evt;
}

//Aqui se hace lamagia... jejeje, esta funcion crea dinamicamente los nuevos campos file
addCampo = function () { 
//Creamos un nuevo div para que contenga el nuevo campo
   nDiv = document.createElement('div');
//con esto se establece la clase de la div
   nDiv.className = 'archivo';
//este es el id de la div, aqui la utilidad de la variable numero
//nos permite darle un id unico
   nDiv.id = 'file' + (++numero);
//creamos el input para el formulario:
   nCampo = document.createElement('input');
//le damos un nombre, es importante que lo nombren como vector, pues todos los campos
//compartiran el nombre en un arreglo, asi es mas facil procesar posteriormente con php
   nCampo.name = 'archivos[]';
//Establecemos el tipo de campo
   nCampo.type = 'file';
//Ahora creamos un link para poder eliminar un campo que ya no deseemos
   a = document.createElement('a');
//El link debe tener el mismo nombre de la div padre, para efectos de localizarla y eliminarla
   a.name = nDiv.id;
//Este link no debe ir a ningun lado
   a.href = '#';
//Establecemos que dispare esta funcion en click
   a.onclick = elimCamp;
//Con esto ponemos el texto del link
   a.innerHTML = 'Eliminar';
//Bien es el momento de integrar lo que hemos creado al documento,
//primero usamos la función appendChild para adicionar el campo file nuevo
   nDiv.appendChild(nCampo);
//Adicionamos el Link
   nDiv.appendChild(a);
//Ahora si recuerdan, en el html hay una div cuyo id es 'adjuntos', bien
//con esta función obtenemos una referencia a ella para usar de nuevo appendChild
//y adicionar la div que hemos creado, la cual contiene el campo file con su link de eliminación:
   container = document.getElementById('adjuntos');
   container.appendChild(nDiv);
}
//con esta función eliminamos el campo cuyo link de eliminación sea presionado
elimCamp = function (evt){
   evt = evento(evt);
   nCampo = rObj(evt);
   div = document.getElementById(nCampo.name);
   div.parentNode.removeChild(div);
}
//con esta función recuperamos una instancia del objeto que disparo el evento
rObj = function (evt) { 
   return evt.srcElement ?  evt.srcElement : evt.target;
}
</script>
</head>
<body onBeforeUnload="return window.opener.agendasProgramadas();">
<form id="CambiarUbicacion" name="CambiarUbicacion" method="post" action="AccionesAgenda/AccionCambiarUbicacion.php" enctype="multipart/form-data">
<fieldset>
	<legend><strong>Información del paciente</strong></legend>
    <table width="100%" border="0" align="center">
      <tr>
        <td width="33%">N° de identificacion:</td>
        <td width="33%">Nombres y Apellidos:</td>
        <td width="33%">Ubicación:</td>
      </tr>
      <tr>
        <td><label for="documento"></label>
        <input type="text" name="documento" id="documento" class="text" value="<?php echo $reg['id_paciente']?>" placeholder="Numero de documento" /></td>
        <td><label for="usuario"></label>
        <input type="text" name="usuario" id="usuario" class="text" value="<?php echo $reg['nom1'].'&nbsp;'.$reg['nom2'].'&nbsp;'.$reg['ape1'].'&nbsp;'.$reg['ape2'] ?>" readonly="readonly" placeholder="Nombres y Apellidos"/></td>
        <td><label for="ubicacion"></label>
        <input type="text" name="ubicacion" id="ubicacion" class="text" value="<?php echo $reg['ubicacion'] ?>" placeholder="Ubicacion del paciente"/>
        <input type="hidden" name="idInforme" id="idInforme" value="<?php echo $idInforme ?>" /></td>
      </tr>
    </table>
</fieldset>
<fieldset>
<legend><strong>Información de la agenda</strong></legend>
<table width="100%" border="0" align="center">
  <tr>
    <td width="33%">Estudio:</td>
    <td width="33%">Tecnica:</td>
    <td width="33%">Fecha y Hora</td>
  </tr>
  <tr>
    <td><select name="estudio" id="estudio" class="select">
      <option value="">.: Seleccione :.</option>
      <?php
      	//realizar consulta para obtener listado de estudios del servicio
		$sqlEstudio = mysql_query("SELECT idestudio, nom_estudio FROM r_estudio WHERE idservicio = '$servicio' ORDER BY nom_estudio ASC ", $cn);
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
    </select></td>
    <td><select name="tecnica" id="tecnica" class="select">
      <?php
	  $listaTecnica = mysql_query("SELECT * FROM r_tecnica WHERE idestado = '1'", $cn);
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
    </select></td>
    <td><input type="text" name="fecha" id="fecha" class="text" value="<?php echo $reg['fecha']?> / <?php echo $reg['hora']?>" readonly="readonly" placeholder="Fecha y hora" /></td>
  </tr>
  <tr>
    <td><dt><label><strong>Archivos a Subir:</strong></label></dt>
        <!-- Esta div contendrá todos los campos file que creemos -->
   <dd><div id="adjuntos">
        <!-- Hay que prestar atención a esto, el nombre de este campo debe siempre terminar en ['']
        como un vector, y ademas debe coincidir con el nombre que se da a los campos nuevos 
        en el script -->
   <input type="file" name="archivos['']" /><br />
   </div></dd>
   <dt><a href="#" onClick="addCampo()">Subir otro archivo</a></dt></td>
    <td>Extremidad:
      <select name="extremidad" id="extremidad" class="select">
        <?php
	  $listaTecnica = mysql_query("SELECT * FROM r_extremidad", $cn);
      while($rowTecnica = mysql_fetch_array($listaTecnica))
				{
				?>
        <option value="<?php echo $rowTecnica['id_extremidad']?>"
                <?php
                	if($rowTecnica['id_extremidad']==$reg['id_extremidad'])
					{
				?>
                 selected="selected"
					<?php
					}
					?>
                    > <?php echo $rowTecnica['desc_extremidad']?></option>
        <?php
				}
			?>
      </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><div id="respuesta"></div></td>
    <td><input type="button" name="actualizar" id="actualizar" value="Actualizar" onclick="validar()" /></td>
  </tr>
</table>
</fieldset>
</form>
</body>
</html>