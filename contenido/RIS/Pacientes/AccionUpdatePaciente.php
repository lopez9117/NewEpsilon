<?php
	require_once("../../../dbconexion/conexion.php");
	$cn = conectarse();
	
	$documentoOld = $_POST['PacienteOld'];
	$fecha_nacimiento = $_POST['fecha_naci'];
	$documento = $_POST['ndocumento'];
	$tipo_documento = $_POST['tipo_documento'];
	$pnombre = $_POST['pnombre'] ;
	$snombre = $_POST['snombre']; 
	$papellido = $_POST['papellido'];
	$sapellido = $_POST['sapellido']; 
	$edad = $_POST['edad']; 
	$unidadedad = $_POST['unidadedad']; 
	$genero = $_POST['genero']; 
	if ($genero==1){$sexo='M';}else{$sexo='F';}
	$eps = $_POST['eps']; 
	$tipo_afiliacion = $_POST['tipo_afiliacion']; 
	$nivel_afiliacion = $_POST['nivel_afiliacion']; 
	$dep = $_POST['dep']; 
	$mun = $_POST['mun']; 
	$barrio = $_POST['barrio']; 
	$direccion = $_POST['direccion']; 
	$tel = $_POST['tel']; 
	$movil = $_POST['movil']; 
	$email = $_POST['email'];
	$edadpaciente = $edad.' '.$unidadedad;
	//consultar y validar que el numero de documento no este duplicado
	$consValidacion = mysql_query("SELECT * FROM r_paciente WHERE id_paciente = '$documento'", $cn);
	$regsValidacion = mysql_num_rows($consValidacion);
	//consulta worklist
	$consultavalidador=mysql_query("SELECT count(id_paciente) as contador FROM r_worklist_temp where id_paciente='$documentoOld' AND procesado!=5",$cn);
	$regValidador = mysql_fetch_array($consultavalidador);
	//si el documento nuevo ya esta registrado, actualizar todos los registros que contengan el documento anterior y elminar el registro con el documento errado.
	if($regsValidacion>=1)
	{
		if ($regValidador['contador']>=1)
		{//Accion para modificar el estudio del worklist.
		mysql_query("UPDATE r_worklist_temp SET id_paciente='$documento', genero= '$sexo',
		nombre_paciente='$pnombre $snombre', apellido_paterno_paciente='$papellido', apellido_materno_paciente='$sapellido',
		procesado='2',fecha_nacimiento='$fecha_nacimiento' WHERE id_paciente='$documento' AND procesado!=5", $cn);		
		}
		//actualizar la informacion del paciente si hubo algun cambio
		mysql_query("UPDATE r_paciente SET fecha_nacimiento='$fecha_nacimiento', id_sexo = '$genero', id_tipoafiliacion = '$tipo_afiliacion', cod_mun = '$mun', cod_dpto = '$dep', idtipo_documento = '$tipo_documento', nom1 = '$pnombre', nom2 = '$snombre', ape1 = '$papellido', ape2 = '$sapellido', barrio = '$barrio', direccion = '$direccion', email = '$email', ideps = '$eps', tel = '$tel / $movil', nivel = '$nivel_afiliacion', edad = '$edadpaciente', idregimen = 1 WHERE id_paciente = '$documento'", $cn);
		//modificar los estudios que estaban registrados con el numero de cedula errado
		mysql_query("UPDATE r_informe_header SET id_paciente = '$documento' WHERE id_paciente = '$documentoOld'");
		//eliminar el registro errado en la tabla pacientes
		mysql_query("DELETE FROM r_paciente WHERE id_paciente = '$documentoOld'");
		echo 
		'<script>
			function r() { location.href="UpdateDatosPaciente.php" } 
			setTimeout ("r()", 1500);
		</script>';
	}
	else
	{
		if ($regValidador['contador']>=1)
		{//Accion para modificar el estudio en el worklist.
		mysql_query("UPDATE r_worklist_temp SET id_paciente= '$documento', genero= '$sexo',
		nombre_paciente='$pnombre $snombre', apellido_paterno_paciente='$papellido', apellido_materno_paciente='$sapellido',
		procesado='2',fecha_nacimiento='$fecha_nacimiento' WHERE id_paciente='$documentoOld' AND procesado!=5", $cn);
		}
		//crear un nuevo registro en la base de datos, con la informacion registrada por el usuario
		mysql_query("INSERT INTO r_paciente VALUES ('$documento','$genero','$tipo_afiliacion','$mun','$dep','$tipo_documento','$pnombre','$snombre','$papellido','$sapellido','$fecha_nacimiento','$barrio','$direccion','$email','$eps','$tel/$movil','$nivel_afiliacion','$edadpaciente','0','1')",$cn);
		//modificar la tabla r_informe_header con el numero de documento actual
		mysql_query("UPDATE r_informe_header SET id_paciente = '$documento' WHERE id_paciente = '$documentoOld'", $cn);
		//eliminar el registro anterior
		mysql_query("DELETE FROM r_paciente WHERE id_paciente = '$documentoOld'", $cn);
		
		echo '<font color="#009900">Realizado con Exito!!!</font>';
		echo 
		'<script>
			function r() { location.href="UpdateDatosPaciente.php" } 
			setTimeout ("r()", 1500);
		</script>';
	}
	mysql_close($cn);
?>