<?php
//inicio de session
session_start();
//funcion para abrir conexion
require_once("../../../../dbconexion/conexion.php");
$cn = Conectarse();
$idInforme = $_POST['Iinforme'];
//declaracion de variables con metodo POST
$asunto= $_POST['asunto'];
$mensaje= $_POST['mensaje'];
$email = $_POST['correo'];
$paciente= $_POST['paciente'];
require "PHPMailer-master/class.phpmailer.php";
          $mail = new PHPMailer;
		  //indico a la clase que use SMTP
          $mail->IsSMTP();		  
          //permite modo debug para ver mensajes de las cosas que van ocurriendo
          //$mail->SMTPDebug = 2;
		  //Debo de hacer autenticación SMTP
          $mail->SMTPAuth = true;
          $mail->SMTPSecure = "ssl";
		  //indico el servidor de Gmail para SMTP
          $mail->Host = "smtp.gmail.com";
		  //indico el puerto que usa Gmail
          $mail->Port = 465;
		  //indico un usuario / clave de un usuario de gmail
          $mail->Username = "resultados@prodiagnostico.com";
          $mail->Password = "resultados15";
          $mail->From = 'resultados@prodiagnostico.com';
          $mail->FromName = 'Resultados Prodiagnostico';
          $mail->Subject = utf8_decode($asunto);        
		  $vector= array($email);
		  foreach ($vector as $email){
          $mail->addAddress($email, $email);}
          $mail->MsgHTML($mensaje);
       	  $mail->addAttachment("PDF/".$idInforme.".pdf", $paciente.".pdf"); 
		  mysql_query("UPDATE r_paciente SET email='$email' WHERE id_paciente='$paciente'",$cn);
          if($mail->Send())
        	{
    		echo '<script type="text/javascript">
				window.location="../ResultadosDefinitivos.php";
				</script>';
    		}
        	else
        	{
				echo '<script type="text/javascript">
				window.location="../ResultadosDefinitivos.php";
				</script>';
    		
    		}
?>