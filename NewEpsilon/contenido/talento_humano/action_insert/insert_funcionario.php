<?php
	//archivo de conexion a la base de datos
	require_once ("../../../dbconexion/conexion.php");
	$cn = Conectarse();
	//declaracion de variables con metodo POST
	$tipoDocumento = $_POST['tipoDocumento'];
	$nDocumento = $_POST['ndocumento'];
	$nombres = $_POST['nombres'];
	$apellidos = $_POST['apellidos'];
	$fecha_nacimiento = $_POST['fecha_nacimiento'];
	$direccion = $_POST['direccion'];
	$telefonos = $_POST['telefonos'];
	$perfil = $_POST['perfil'];
	$pass = md5($_POST['pass']);
	$foto = $_POST['foto'];
	$grupoEmpleado = $_POST['grupoempleado'];
	$email = $_POST['email'];
	$tipo_cargo = $_POST['tipo_cargo'];
	$salario = $_POST['salario'];
	$auxTransporte = $_POST['auxTransporte'];
	$municipio = $_POST['municipio'];
	//validar campos obligatorios del formulario
	if($tipoDocumento == "" || $nDocumento == "" || $nombres == "" || $perfil == "" || $pass == "" || $grupoEmpleado == "" || $tipo_cargo=="" || $salario=="" || $auxTransporte=="")
	{
		echo '<table width="100%" border="0" align="center">
		<tr align="left" style="height:20px;">
		  <td><font color="#FF0000" size="2">Los campos señalados con * son obligatorios</font></td>
		</tr>
		</table>';
	}
	else
	{
		//verificar si el usuario esta registrado y/o activo o inactivo en el sistema
		$sqlFuncionario = mysql_query("SELECT * FROM funcionario WHERE idfuncionario='$nDocumento'", $cn);
		$regFuncionario = mysql_num_rows($sqlFuncionario);
		
		if($regFuncionario>=1)
		{
			echo '<table width="100%" border="0" align="center">
			<tr align="left" style="height:20px;">
			  <td><font color="#FF0000" size="2">El funcionario ya esta registrado en el sistema, por favor compruebe su estado</font></td>
			</tr>
			</table>';
		}
		else
		{
			mysql_query("INSERT INTO funcionario VALUES('$nDocumento','$nombres','$apellidos','$grupoEmpleado', '$tipoDocumento','','$direccion','$fecha_nacimiento','$telefonos','1','$tipo_cargo','$salario','$auxTransporte','$municipio')", $cn);			
			echo '<table width="100%" border="0" align="center">
			<tr align="left" style="height:20px;">
			  <td><font color="#00FF00" size="2">Funcionario registrado exitosamente</font></td>
			</tr>
			</table>';
		}
	}	
?>