<?php
	//conexion a la BD
	require_once("../../../../dbconexion/conexion.php");
	$cn = conectarse();
	//variables GET
	$idPlantilla = base64_decode($_GET['idPlantilla']);
	$Plantilla = $idPlantilla;
	//archivos para consulta
	include("../../select/selects.php");
	
	$sql = mysql_query("SELECT * FROM r_plantilla WHERE idplantilla = '$Plantilla'");
	$reg = mysql_fetch_array($sql);
	
	$servicio = $reg['idservicio'];
	$estudio = $reg['idestudio'];
	$tecnica = $reg['id_tecnica'];
	
	$sqlEstudio = mysql_query("SELECT idestudio, nom_estudio FROM r_estudio WHERE idservicio = '$servicio'", $cn);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Editar Plantilla :.</title>
<script type="text/javascript" src="../../../../js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<script type="text/javascript" src="../../fckeditor/fckeditor.js"></script>
<script src="../../ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../../js/ajax.js"></script>
<link href="../../ckeditor/skins/moono/editor.css" rel="stylesheet" type="text/css">
<link href="../../styles/forms.css" rel="stylesheet" type="text/css" />
<style>
	.textarea
	{width:100%;
	height:35px;
	}
	.body{
	font: 72.5% "Trebuchet MS", sans-serif;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	}
	select
	{width:450px;
	font: "Trebuchet MS", sans-serif;
	}
</style>
<script language="javascript">
function cargarEstudios()
{
	servicio = document.Plantilla.servicio.value;
	
		selectEstudio = document.getElementById('respuesta');
		ajax=nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax.open("POST", "SelectEstudio.php",true);
		ajax.onreadystatechange=function() 
		{
			if (ajax.readyState==4) 
			{
				selectEstudio.innerHTML = ajax.responseText;
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("servicio="+servicio+"&tiempo=" + new Date().getTime());
}

function validar()
{
	var servicio, estudio, tecnica;
	servicio = document.Plantilla.servicio.value;
	estudio = document.Plantilla.estudio.value;
	tecnica = document.Plantilla.tecnica.value;
	
	if(servicio == "" || estudio =="" || tecnica == "")
	{
		alert("Aun hay campos vacios");
	}
	else
	{
		document.Plantilla.submit();
	}
}
</script>
</head>
<body>
<form name="Plantilla" id="Plantilla" method="post" action="UpdatePlantilla.php">
<table width="95%" border="0" align="center" style="margin-top:3%;">
  <tr bgcolor="#CCCCCC">
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" width="50%">Servicio:<br><select name="servicio" id="servicio" onchange="cargarEstudios()">
      <option value="">.: Seleccione :.</option>
      <?php
      	while($rowServicio = mysql_fetch_array($listaServicio))
		{?>
		<option value="<?php echo $rowServicio['idservicio']?>"
		<?php
            if($rowServicio['idservicio']==$servicio)
            {
        ?>
         selected="selected"
            <?php
            }
            ?>
            >
        <?php echo $rowServicio['descservicio']?></option>	
		<?php
        }
	  ?>
    </select></td>
    <td colspan="2" id="respuesta">Estudio:<br>
      <label for="dummy"></label>
      <select name="estudio" id="estudio">
     <option value="">.: Seleccione un Estudio :.</option>
     <?php
	 	while($rowEstudio = mysql_fetch_array($sqlEstudio))
		{?>
		<option value="<?php echo $rowEstudio['idestudio']?>"
		<?php
            if($rowEstudio['idestudio']==$estudio)
            {
        ?>
         selected="selected"
            <?php
            }
            ?>
            >
        <?php echo $rowEstudio['nom_estudio']?></option>	
		<?php
		}
	 ?>
      </select></td>
  </tr>
  <tr>
    <td colspan="2">Tecnica:<br>
      <label for="tecnica"></label>
      <select name="tecnica" id="tecnica">
      <?php
      	while($rowTecnica = mysql_fetch_array($listaTecnica))
		{
			?>
		<option value="<?php echo $rowTecnica['id_tecnica']?>"
		<?php
            if($rowTecnica['id_tecnica']==$tecnica)
            {
        ?>
         selected="selected"
            <?php
            }
            ?>
            >
        <?php echo $rowTecnica['desc_tecnica']?></option>	
		<?php
		}
	  ?>
      </select></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><label for="servicio"></label></td>
     <td colspan="2">&nbsp;</td>
  </tr>
    <td colspan="4">
      <textarea class="ckeditor" cols="150" id="contenido" name="contenido" rows="10"><?php echo $reg['contenido']?></textarea>	
      </td>
  </tr>  
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%"><input type="hidden" name="idPlantilla" id="idPlantilla" value="<?php echo $idPlantilla ?>" /></td>
    <td width="20%" align="right"><input type="button" name="button" id="button" value="Modificar Plantilla" onclick="validar()"/></td>
  </tr>
</table>
</form>
</body>
</html>	