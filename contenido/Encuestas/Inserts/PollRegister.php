<?php
session_start();
//registrar la sede y el usuario seleccionados en una variable de sesion permanente
$user = base64_decode($_SESSION['usuario_encuestas']);
//conexion a base de datos
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//declaracion de variables
$encuesta = $_POST['encuesta']; $nombusuario = $_POST['nombusuario']; $cedula = $_POST['cedula']; $telefono = $_POST['telefono'];
$email = $_POST['email']; $sede = $_POST['sede']; $servicio = $_POST['servicio']; $fecha = $_POST['fecha']; $TipoComentario = $_POST['TipoComentario']; $comentario = $_POST['comentario']; $direccion = $_POST['direccion']; $respuesta = $_POST['respuesta']; $pregunta = $_POST['pregunta'];
//consultar el consecutivo para asignar al usuario
$consUsuario = mysql_query("SELECT MAX(idusuario+1) AS idusuario FROM e_usuario",$cn);
$regsUsuario = mysql_fetch_array($consUsuario);
$idUsuario = $regsUsuario['idusuario'];

if($idUsuario==0 || $idUsuario==0)
{
	$idUsuario = 1;
}
//guardar datos del usuario
mysql_query("INSERT INTO e_usuario (idusuario, nombres, tel, direccion, email, cedula) VALUES ('$idUsuario','$nombusuario','$telefono','$direccion','$email','$cedula')", $cn);
//consultar consecutivo de la encuesta para obtener variable para el registro
$consPoll = mysql_query("SELECT MAX(idencuesta+1) AS idencuesta FROM e_encuesta", $cn);
$regsPoll = mysql_fetch_array($consPoll);
$idEncuesta = $regsPoll['idencuesta'];
if($idEncuesta=="" || $idEncuesta == 0)
{
	$idEncuesta = 1;
}
//validar si hay observacines y/o comentarios para registrar
if($TipoComentario!=0)
{
	mysql_query("INSERT INTO e_comentarios (idtipocomentario, idencuesta, comentario, idsede, idusuario, fecha) VALUES ('$TipoComentario','$idEncuesta','$comentario','$sede','$idUsuario','$fecha')", $cn);	
}
//registrar encuesta
mysql_query("INSERT INTO e_encuesta (idencuesta, idusuario, fecha, idsede, idservicio, idnombencuesta, currentuser, fecha_registro) VALUES('$idEncuesta','$idUsuario','$fecha','$sede','$servicio','$encuesta', '$user', NOW())", $cn);
//registro de las respuestas al contenido de la encuesta
if($_POST['pregunta'])
{
	foreach ($_POST['pregunta'] as $Question => $idPregunta)
	{
		$idRespuesta = $respuesta[$Question];
		//insersion de las preguntas y la respectiva calificacion
		mysql_query("INSERT INTO e_resp_encuesta (idpregunta, idencuesta, idcalificacion, idnombencuesta) VALUES ('$idPregunta','$idEncuesta','$idRespuesta','$encuesta')", $cn);
	}  
}
?>
<script>
	alert("Guardado exitosamente! Muchas gracias por su tiempo");
	location.href = "../Bienvenida.php";
</script>