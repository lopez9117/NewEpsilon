<?php
	//conexion a la BD '<font color="#006600"><strong>Actualizado exitosamente !</strong></font>'
	include("../../../../dbconexion/conexion.php");
	$cn = Conectarse();
	//variables con post
	$idespecialista = $_POST['idEspecialista'];
	$universidad = $_POST['universidad'];
	$especialidad = $_POST['especialidad'];
	$registro_medico = $_POST['registroMedico'];
	//actualizar registro y pasar a estado de cancelacion
	mysql_query("UPDATE r_especialista SET iduniversidad = '$universidad',id_especialidad='$especialidad',reg_medico='$registro_medico' WHERE idfuncionario_esp = '$idespecialista'", $cn);
	echo '<script>
		location.href = "../UpdateEspecialista.php";
	</script>';
	mysql_close($cn);
?>