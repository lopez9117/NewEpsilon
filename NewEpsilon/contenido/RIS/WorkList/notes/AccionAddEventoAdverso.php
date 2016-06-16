<?php
//conexion a la BD
require_once("../../../../dbconexion/conexion.php");
$cn = conectarse();
$idinforme = $_POST['informe'];
$sqlHeader = mysql_query("SELECT CONCAT(p.nom1,' ',p.nom2,' ',p.ape1,' ',p.ape2) as paciente,p.id_paciente FROM r_informe_header i
INNER JOIN r_paciente p ON i.id_paciente=p.id_paciente where id_informe='$idinforme'", $cn);
$regHeader = mysql_fetch_array($sqlHeader);
$observacion = $_POST['observacion'];
$asunto='Evento Adverso del paciente '.$regHeader['paciente'].' CC - '.$regHeader['id_paciente'];
$usuario = $_POST['usuario'];
$sqlfuncionario = mysql_query("SELECT nombres,apellidos, u.email FROM funcionario f 
INNER JOIN usuario u ON f.idfuncionario=u.idusuario
WHERE idfuncionario='$usuario'", $cn);
$regfuncionario = mysql_fetch_array($sqlfuncionario);
$myString = substr($regfuncionario["nombres"], 0, -1);
$nombre = ucwords(strtolower($myString.' '.$regfuncionario["apellidos"]));
$tipo_comentario = $_POST['tipo_comentario'];
$fecha = date("Y-m-d");
$hora = date("G:i:s");
require "../../Resultados/Crearpdf/PHPMailer-master/class.phpmailer.php";
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
          $mail->Username = "soporte@prodiagnostico.com";
          $mail->Password = "Pr0d14gn0st1c0$2014";
          $mail->From = $regfuncionario['email'];
          $mail->FromName = $nombre;
          $mail->Subject = utf8_decode($asunto);        
		  $vector= array('coordinacioncalidad@prodiagnostico.com.co','asistentecalidad@prodiagnostico.com.co','teccalidad@prodiagnostico.com.co','coordinacionhemodinamia@prodiagnostico.com.co','jgiraldo@prodiagnostico.com');
		  foreach ($vector as $email){
          $mail->addAddress($email, $email);}
          $mail->MsgHTML($observacion);
       	  //$mail->addAttachment("PDF/".$idInforme.".pdf", $paciente.".pdf"); 
		  //insersion en la bd
		  mysql_query("INSERT INTO r_observacion_informe VALUES('$idinforme','$usuario','$observacion','$fecha','$hora', '2')", $cn);
          if($mail->Send())
        	{
    		$info = base64_encode($idinforme);
			$user = base64_encode($usuario);
			echo '<script language="javascript">
			location.href="EventosAdversos.php?idInforme='.$info.'&usuario='.$user.'"
			</script>';
    		}
        	else
        	{
			$info = base64_encode($idinforme);
			$user = base64_encode($usuario);
			echo '<script language="javascript">
			location.href="EventosAdversos.php?idInforme='.$info.'&usuario='.$user.'"
			</script>';
    		}
?>