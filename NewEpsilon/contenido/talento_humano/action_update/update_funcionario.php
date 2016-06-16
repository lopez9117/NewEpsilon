<?php
	require_once ("../../../dbconexion/conexion.php");
	$cn = Conectarse();
	//declaracion de variables POST
	$tipoDocumento = $_POST[tipoDocumento];
	$ndocumento = $_POST[ndocumento];
	$nombres = $_POST[nombres];
	$apellidos = $_POST[apellidos];
	$fecha_nacimiento = $_POST[fecha_nacimiento];
	$grupoempleado = $_POST[grupoempleado];
	$direccion = $_POST[direccion];
	$telefonos = $_POST[telefonos];
	$estado = $_POST[estado];
	$tipo_cargo = $_POST[tipo_cargo];
	$salario = $_POST[salario];
	$auxTransporte = $_POST[auxTransporte];
	$municipio = $_POST[municipio];
	$email = $_POST[email];
	//validar campos obligatorios en el formulario
	if($tipoDocumento=="" || $nombres=="" || $apellidos=="" || $grupoempleado=="" || $estado=="" || $tipo_cargo=="" || $salario=="" || $auxTransporte=="")
	{
		echo '<table width="100%" border="0" align="center">
		<tr align="left" style="height:20px;">
		  <td><font color="#FF0000" size="2">Los campos señalados con * son obligatorios</font></td>
		</tr>
		</table>';
	}
	else
	{
		//realizar consulta para actualizar los datos en la BD
		mysql_query("UPDATE funcionario SET nombres='$nombres', apellidos='$apellidos', idgrupo_empleado='$grupoempleado', idtipo_documento='$tipoDocumento', direccion = '$direccion', fecha_nacimiento = '$fecha_nacimiento', telefonos = '$telefonos', idestado_actividad = '$estado', idtipo_cargo = '$tipo_cargo', salario = '$salario', auxtransporte = '$auxTransporte', cod_mun = '$municipio' WHERE idfuncionario = '$ndocumento'", $cn);
		//modificar email
		mysql_query("UPDATE usuario SET email = '$email' WHERE idusuario = '$ndocumento'",$cn);
		
		echo '<table width="100%" border="0" align="center">
		<tr align="left" style="height:20px;">
		  <td><font color="#00FF00" size="2">Actualizacion realizada con exito</font></td>
		</tr>
		</table>';
	}
?>