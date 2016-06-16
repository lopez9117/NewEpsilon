<?php
//conexion a la bd
include("../../../dbconexion/conexion.php");
$cn = conectarse();
//variables con post
$idfuncionario = base64_decode($_GET['idFuncionario']);
//validar campos obligatorios del formulario
if($idfuncionario=="")
{
	echo '<font size="2" color="#FF0000">Por favor seleccione un funcionario de la lista</font>';
}
else
{
	//obtener los datos del funcionario para mostrar en pantalla
	$sql = mysql_query("SELECT f.idfuncionario, f.nombres, f.apellidos, t.desc_tipodocumento, g.desc_grupoempleado FROM funcionario f
	INNER JOIN tipo_documento t ON t.idtipo_documento = f.idtipo_documento
	INNER JOIN grupo_empleado g ON g.idgrupo_empleado = f.idgrupo_empleado WHERE f.idfuncionario = '$idfuncionario'", $cn);
	$reg = mysql_fetch_array($sql);
	$sqlRol = mysql_query("SELECT * FROM rol", $cn);
	$sqlDatosFuncionario = mysql_query("SELECT * FROM usuario WHERE idusuario = '$idfuncionario'", $cn);
	$resDatosFuncionario = mysql_fetch_array($sqlDatosFuncionario);
	$columna = 1;
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="../../../css/EstiloVisual.css" rel="stylesheet" type="text/css">
	<script language="javascript" src="../Javascript/ajax.js"></script>
	<title>.: Asignar permisos y accesos :.</title>
	</head>
	<body>
	<br>
	<form name="RegistrarUsuario" id="RegistrarUsuario" action="RegistrarUsuario.php" method="post">
	<table width="100%" align="center">
	<tr>
	<td width="25%">Tipo de documento:<br>
	  <label for="tipodocumento"></label>
	  <select name="tipodocumento" id="tipodocumento" disabled="disabled" class="inputSelect">
	  <option><?php echo $reg['desc_tipodocumento'] ?></option>
	  </select>
	</td>
	<td width="25%">N° de documento:<br>
	  <label for="documento"></label>
	  <input type="text" value="<?php echo $reg['idfuncionario'] ?>" disabled="disabled" class="input" />
	</td>
	<td width="25%">Nombres:<br>
	  <label for="nombres"></label>
	  <input type="text" name="nombres" id="nombres" value="<?php echo $reg['nombres']?>" disabled="disabled" class="input" />
	</p></td>
	<td width="25%">Apellidos:<br>
	  <label for="apellidos"></label>
	  <input type="text" name="apellidos" id="apellidos" value="<?php echo $reg['apellidos']?>" disabled="disabled" class="input" />
	</td>
	</tr>
	<tr>
	<td>Rol:<br>
	  <label for="rol"></label>
	  <select name="rol" id="rol" class="inputSelect">
	  <option value="">.: Seleccione Rol :.</option>
	  <?php
		while($regRol = mysql_fetch_array($sqlRol))
		{?>
			<option value="<?php echo $regRol['idrol']?>"
            <?php
            	if($resDatosFuncionario['idrol'] == $regRol['idrol']) { echo "selected='selected'"; }
			?>><?php echo $regRol['desc_rol']?></option>';
		<?php
        }
	  ?>
	  </select>*
	  </td>
	<td>Correo electronico:<br>
	  <label for="email"></label>
	  <input type="text" name="email" id="email" class="input" value="<?php echo $resDatosFuncionario['email']?>" />*
	</td>
	<td>Contraseña:<br>
	  <label for="pass1"></label>
	  <input type="password" name="pass1" id="pass1" class="input" value="<?php echo $resDatosFuncionario['pass']?>" />*
	</td>
	<td>Confirmar contraseña:<br>
	  <label for="pass2"></label>
	  <input type="password" name="pass2" id="pass2" class="input" value="<?php echo $resDatosFuncionario['pass']?>" />*
	</td>
	</tr>
	<tr>
	<td><input type="hidden" name="documento" value="<?php echo $reg['idfuncionario'] ?>"/></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	</tr>
	<tr>
	<td colspan="4">A continuacion seleccione los modulos a los cuales va a terner acceso el funcionario seleccionado (Recuerde que es necesario seleccionar por lo menos un modulo).</td>
	</tr>
	</table>
	<br />
	<table width="50%" border="0">
	   <?php
	   //consultar los modulos a los que tiene acceso el funcionario
		$conMod = mysql_query("SELECT * FROM modulo ORDER BY descmodulo ASC", $cn);
		while($regMod = mysql_fetch_array($conMod))
		{
			$sqlmodsUsuario = mysql_query("SELECT idmodulo FROM modulo_usuario WHERE idusuario = '$idfuncionario' AND idmodulo = '$regMod[idmodulo]'", $cn);
			$regmodsUsuario = mysql_fetch_array($sqlmodsUsuario);
			
			if ($columna==1) 
			echo '<tr>'; //se abre la primera fila
			echo '<td>';
			?>
            <input type="checkbox" name="modulo[<?php echo $regMod['idmodulo'] ?>]" value="<?php echo $regMod['idmodulo'] ?>"
            <?php  if ($regMod['idmodulo']==$regmodsUsuario['idmodulo']){ echo 'checked="checked"';}?>/>
			
			<?php echo $regMod['descmodulo'] ?></td> 
            <?php
			if ($columna!=1) 
			{
			echo '</tr>'; // la fila solo se cierra despues de la segunda columna
				$columna=1; 
			}
			else
			{
				$columna++; //incrementamos el valor en uno, ahora columna = 2
			}
		}
	?>
	  <tr>
		 <td colspan="4">&nbsp;</td>
	  </tr>
	  <tr>
	<td colspan="4"><div id="respuesta"></div></td>
	</tr>
	</table>
	<table width="100%">
	 <tr>
	<td><input type="button" name="enviar" id="enviar" value="Enviar" onclick="Validate()"/> </td>
	<td id="Resultado"></td>
	</tr>
	</table>
	</form><br>
	</body>
	</html>
<?php
}
?>