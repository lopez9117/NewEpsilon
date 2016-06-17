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
	//consultar departamento
	$CodMun = $regFuncionario[cod_mun];
	$sqlDepto = mysql_query("SELECT m.cod_mun, m.cod_dpto FROM r_municipio m WHERE cod_mun = '$CodMun'", $cn);
	$regDepto = mysql_fetch_array($sqlDepto);
	//obtener direccion de email del funcionario
	$sqlemail = mysql_query("SELECT email FROM usuario WHERE idusuario = '$idFuncionario'", $cn);
	$regemail = mysql_fetch_array($sqlemail);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prodiagnostico S.A</title>
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/ajax.js"></script>
<link type="text/css" href="../../css/demo_table.css" rel="stylesheet" />
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
<script type="text/javascript" src="../../js/jquery-1.7.1.js"></script>
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
})
function loadMunicipio()
{
	var coddpto;
	coddpto = document.Newregistro.departamento.value;
	//etiqueta donde se va a mostrar la respuesta
	respuesta = document.getElementById('municipio');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST","../select/SelectMunicipio.php",true); 
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			respuesta.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("coddpto="+coddpto+"&tiempo=" + new Date().getTime());
}
</script>
</head>
<body>
<div id="nav">
<div class="chou">
<table width="100%" border="0">
<tr><td align="center" valign="middle">
	<div class="marco">
	<div class="ruta">
		<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a href="../../includes/main_menu.php">MEN&Uacute; PRINCIPAL</a></span> &gt; <a href="main_menu_talentoh.php">Talento Humano</a> > <a href="hojas_de_vida.php">Hojas de Vida</a></span> <span class="class_cargo" style="font-size:14px">&gt; Editar Registro</span></div>
	<table width="98%" border="0">
	<tr>
	<td colspan="2" height="7"><div style="border-bottom: #D3D3D3 2px dotted"></div><br><a href="hojas_de_vida.php" class="botones"><span><span>Regresar</span></span></a><br><br></td>
	</tr>
	<tr>
	<td valign="top" align="left" bgcolor="#DEDEDE">
    <form action="action_update/update_funcionario.php" method="post" name="Newregistro" id="Newregistro">
    <table width="70%" align="center">
	  <tr>
	    <td colspan="2">
	      <p><a class="class_login" style="text-decoration:none;font-size:16px" href="opciones.php?modulo=1">Editar hoja de vida</a></p></td>
	    </tr>
	  <tr>
	    <td><p>Tipo de documento:</p>
	      <p><span id="spryselect1">
          <label for="tipoDocumento"></label>
          <select name="tipoDocumento" id="tipoDocumento" class="select">
            <option value="">.: Seleccione :.</option>
            <?php
            	while($regTipoDocumento = mysql_fetch_array($listaTipoDocumento))
				{
				?>
                <option value="<?php echo $regTipoDocumento[idtipo_documento]?>"
                <?php
                	if($regFuncionario[idtipo_documento]==$regTipoDocumento[idtipo_documento])
					{
				?>
                 selected="selected"
					<?php
					}
					?>
                    >
				<?php echo $regTipoDocumento[desc_tipodocumento]?></option>
				<?php
				}
			?>
          </select>
          <span class="selectRequiredMsg">*</span></span></p></td>
	    <td><p>N&deg; de documento:</p>
	      <p><span id="sprytextfield5">
	        <label for="ndocumento"></label>
	        <input type="text" name="ndocumento" id="ndocumento" class="text" readonly="readonly" value="<?php echo $idFuncionario ;?>" />
	        <span class="textfieldRequiredMsg">*</span></span></p></td>
	    </tr>
	  <tr>
	    <td><p>Nombres:</p>
          <p><span id="sprytextfield3">
            <label for="nombres"></label>
            <input type="text" name="nombres" id="nombres" class="text" value="<?php echo $regFuncionario[nombres]?>" />
            <span class="textfieldRequiredMsg">*</span></span></p></td>
	    <td><p>Apellidos:</p>
          <p><span id="sprytextfield4">
            <label for="apellidos"></label>
            <input type="text" name="apellidos" id="apellidos" class="text" value="<?php echo $regFuncionario[apellidos]?>" />
            <span class="textfieldRequiredMsg">*</span></span></p></td>
	    </tr>
	  <tr>
	    <td><p>Fecha de nacimiento:</p>
	      <p>
	        <label for="fecha_nacimiento"></label>
	        <span id="sprytextfield6">
	        <input type="text" name="fecha_nacimiento" id="fecha_nacimiento" class="text" value="<?php echo $regFuncionario[fecha_nacimiento]?>" />
	        <span class="textfieldInvalidFormatMsg">*</span></span></p></td>
	    <td><p>Edad:</p>
	      <p>
	        <label for="edad"></label>
	        <input type="text" name="edad" id="edad" class="text" />
	      </p></td>
	    </tr>
	  <tr>
	    <td><p>Direccion:</p>
          <p>
            <label for="direccion"></label>
            <input type="text" name="direccion" id="direccion" class="text" value="<?php echo $regFuncionario[direccion]?>" />
          </p></td>
	    <td><p>Telefonos:</p>
          <p>
            <label for="telefonos2"></label>
            <span id="sprytextfield7">
              <input type="text" name="telefonos" id="telefonos2" class="text" value="<?php echo $regFuncionario[telefonos]?>" />
            </span></p></td>
	    </tr>
	  <tr>
	    <td><a class="class_login" style="text-decoration:none;font-size:16px" href="opciones.php?modulo=1">Informaci&oacute;n laboral.</a></td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td><p>Grupo de empleados:</p>
	      <p><span id="spryselect3">
	        <label for="grupoempleado"></label>
	        <select name="grupoempleado" id="grupoempleado" class="select">
	          	<option value="">.: Seleccione :.</option>
                <?php
					while($regGrupo = mysql_fetch_array($listaGrupoEmpleado))
					{
				?>
                <option value="<?php echo $regGrupo[idgrupo_empleado]?>"
                <?php
                	if($regFuncionario[idgrupo_empleado]==$regGrupo[idgrupo_empleado])
					{
				?>
                 selected="selected"
					<?php
					}
					?>
                    >
				<?php echo $regGrupo[desc_grupoempleado]?></option>
				<?php
				}
				?>
              </select>
	        <span class="selectRequiredMsg">*</span></span></p></td>
	    <td><p>Correo electronico:</p>
	      <p>
	        <label for="email"></label>
	        <input type="text" name="email" id="email" class="text" value="<?php echo $regemail[email]?>" />
	      *</p></td>
	    </tr>
	  <tr>
	    <td><p>Departamento:</p>
	      <p>
	        <select name="departamento" id="departamento" class="select" onchange="loadMunicipio()">
	          <option value="">.: Seleccione :.</option>
	          <?php
            	while($rowDpto = mysql_fetch_array($listadoDpto))
				{
				?>
                <option value="<?php echo $rowDpto[cod_dpto]?>"
                <?php
                	if($rowDpto[cod_dpto]==$regDepto[cod_dpto])
					{
				?>
                 selected="selected"
					<?php
					}
					?>
                    >
				<?php echo $rowDpto[nombre_dpto]?></option>
				<?php
				}
			?>
	          </select>
	      </p></td>
	    <td><p>Ciudad / Municipio :</p>
	      <p>
	        <select name="municipio" id="municipio" class="select">
	          <option value="">.: Seleccione :.</option>
              <?php
            	while($rowMpo = mysql_fetch_array($listadoMun))
				{
				?>
                <option value="<?php echo $rowMpo[cod_mun]?>"
                <?php
                	if($rowMpo[cod_mun]==$CodMun)
					{
				?>
                 selected="selected"
					<?php
					}
					?>
                    >
				<?php echo $rowMpo[nombre_mun]?></option>
				<?php
				}
			?>
	          </select>
	      </p></td>
	    </tr>
	  <tr>
	    <td><p>Perfil:</p>
	      <p><span id="spryselect2">
	        <label for="perfil"></label>
	        <select name="perfil" id="perfil" class="select" disabled="disabled">
	          <option value="">.: Seleccione :.</option>
	          <?php
                	while($regPerfil = mysql_fetch_array($listarPerfiles))
						{
						echo '<option value="'.$regPerfil[idperfil].'">'.$regPerfil[descperfil].'</option>';
					}
				?>
	          </select>
	        </span></p></td>
	    <td><p>Estado:</p>
  <label for="estado"></label>
	      <span id="spryselect4">
	        <select name="estado" id="estado" class="select">
	          <option value="">.: Seleccione :.</option>
	          <?php
            	while($regEstado = mysql_fetch_array($listarEstado))
				/*{
					echo '<option value="'.$regEstado[idestado_actividad].'">'.$regEstado[desc_estado].'</option>';
				}*/
				{
				?>
	          <option value="<?php echo $regEstado[idestado_actividad]?>"
                <?php
                	if($regFuncionario[idestado_actividad]==$regEstado[idestado_actividad])
					{
				?>
                 selected="selected"
					<?php
					}
					?>
                    >
	            <?php echo $regEstado[desc_estado]?></option>
	          <?php
				}
			?>
	          </select>
	        <span class="selectRequiredMsg">*</span></span></td>
	    </tr>
	  <tr>
	    <td><p>Tipo de cargo:</p>
          <p>
            <label for="tipo_cargo"></label>
            <select name="tipo_cargo" id="tipo_cargo" class="select">
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
                    >
				<?php echo $regTipoCargo[desctipo_cargo]?></option>
				<?php
				}
			?>
            </select>
*          </p></td>
	    <td><p>Salario:</p>
	      <p>
  <label for="salario"></label>
	        <input type="text" name="salario" id="salario" class="text" value="<?php echo $regFuncionario[salario]?>" />
	        *</p></td>
	    </tr>
	  <tr>
	    <td><p>Auxilio de transporte:</p>
	      <p>
	        <label for="auxTransporte"></label>
	        <input type="text" name="auxTransporte" id="auxTransporte" class="text" value="<?php echo $regFuncionario[auxtransporte]?>" />
	      *</p></td>
	    <td><p>Fotografia:</p>
          <label for="file"></label>
          <input type="file" name="foto" id="file"/></td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td><div id="notificacion" class="notificacion"></div></td>
	    <td><input type="submit" name="Actualizar" id="Actualizar" value="Actualizar" class="button" />
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