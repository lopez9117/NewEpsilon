<?php
	//conexion a la BD
	session_start();
	$usuario = $_SESSION[currentuser];
	$_SESSION[area] = $area;
	require_once("../../../dbconexion/conexion.php");
	$cn = conectarse();
	$idinforme = $_POST['informe'];
	$consulta= mysql_query("SELECT u.email,s.idsolicitud, f.nombres, f.apellidos FROM usuario u
INNER JOIN funcionario f ON u.idusuario=f.idfuncionario
INNER JOIN solicitud s ON u.idusuario=s.idfuncionario
WHERE idsolicitud='$idinforme'", $cn);
	$rowconsulta= mysql_fetch_array($consulta);	
	$consult= mysql_query("SELECT u.email, f.nombres, f.apellidos FROM usuario u
INNER JOIN funcionario f on u.idusuario=f.idfuncionario WHERE idusuario='$usuario'", $cn);
	$rowconsult= mysql_fetch_array($consult);
	$observacion = utf8_encode($_POST['observacion']);
	$desc_area = $_POST['desc_area'];
	$prioridad= $_POST['prioridad'];
	$tipo_solicitud=$_POST['tipo_solicitud'];
	$estado=$_POST['estado'];
	$Fecha=date("Y/m/d");
	$time = date("g:i:s");
	//enviar correo electronico
	if ($observacion!="")
     {
        
    $myString = substr($rowconsult["nombres"], 0, -1);
    $nombre = ucwords(strtolower($myString.' '.$rowconsult["apellidos"]));
	$asunto =  utf8_decode($_POST["asunto"]);
    $mensaje ='Se ha realizado la siguiente observacion identificada con el numero ('.$idinforme.'):<br><br>'.$observacion.'<br><br> para mas información puede visitar el portal de aplicaciones del modulo de solicitudes.<br> http://www.portalprodiagnostico.com.co/newepsilon <br><br> Nota: porfavor evite responder sobre este correo, cualquier comentario que se desee agregar es necesario que se haga dentro del modulo de solicitudes para mayor trazabilidad de la información. <br><br> Muchas Gracias ';
 
        
        require "../PHPMailer-master/class.phpmailer.php";
    
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
       
          $mail->From = $rowconsult['email'];
          $mail->FromName = $nombre;
        
          $mail->Subject = $asunto;
		
			if ($desc_area==1)
		{
$vector= array($rowconsulta['email'],'coordinacionsistemas@prodiagnostico.com.co','adminredes@prodiagnostico.com.co','soportesistemas@prodiagnostico.com.co');
		  foreach ($vector as $email)
		  {
          $mail->addAddress($email, $email);
		  }
		 }
		elseif ($desc_area==2)
		{
		$vector= array($rowconsulta['email'],'coordinacionbiomedica@prodiagnostico.com.co','biomedica@prodiagnostico.com.co');
		  foreach ($vector as $email)
		  {
          $mail->addAddress($email, $email);
		  }
		}
		elseif ($desc_area==8)
		{
		$vector= array($rowconsulta['email'],'infraestructura@prodiagnostico.com.co');
		  foreach ($vector as $email)
		  {
          $mail->addAddress($email, $email);
		  }
		}
			elseif ($desc_area==9)
			{
				$vector= array($rowconsulta['email'],'comunicaciones@prodiagnostico.com.co');
				foreach ($vector as $email)
				{
					$mail->addAddress($email, $email);
				}
			}
		elseif ($desc_area==3)
		{
		$vector= array($rowconsulta['email'],'coordinacionsuministros@prodiagnostico.com.co','subgerencia@prodiagnostico.com.co','costos@prodiagnostico.com.co','subgerenteasistencial@prodiagnostico.com.co');
		 foreach ($vector as $email)
		 {
          $mail->addAddress($email, $email);
		 }
		}
		
          $mail->MsgHTML($mensaje);
       
			if($mail->Send())
        	{
    		if ($desc_area==1 || $desc_area==2 || $desc_area==8 || $desc_area==9)
			{
			echo '<script language="javascript">
		location.href="detalle.php?id='.$idinforme.'&area='.$desc_area.'"
		</script>';
			}
			else
			{
			echo '<script language="javascript">
		location.href="detallecompras.php?id='.$idinforme.'&area='.$desc_area.'"
		</script>';
	}
    		}
        	else
        	{
			if ($desc_area==1 || $desc_area==2 || $desc_area==8 || $desc_area==9)
			{
			echo '<script language="javascript">
		location.href="detalle.php?id='.$idinforme.'&area='.$desc_area.'"
		</script>';
			}
			else
			{
			echo '<script language="javascript">
		location.href="detallecompras.php?id='.$idinforme.'&area='.$desc_area.'"
		</script>';
	}
 }
}
//modificar datos de la solicitud
$validar = mysql_query("SELECT idsolicitud,idestado_solicitud FROM solicitud where idestado_solicitud>=2 AND idsolicitud='$idinforme'", $cn);
$regvalidar = mysql_num_rows($validar);
if ($regvalidar>=1)
{
if($area==1 || $area==2 || $area==8 && $estado!="" && $tipo_solicitud!="")
{
mysql_query("UPDATE solicitud SET idprioridad='$prioridad', id_tiposolicitud='$tipo_solicitud', idestado_solicitud='$estado', idfuncionarioresponde='$usuario' WHERE idsolicitud='$idinforme' ", $cn);	
echo '<script language="javascript">
location.href="detalle.php?id='.$idinforme.'&area='.$desc_area.'"
</script>';
}
}
else
{
if($area==1 || $area==2 || $area==8 || $area==9 && $estado!="" && $tipo_solicitud!="")
{
mysql_query("UPDATE solicitud SET idprioridad='$prioridad', id_tiposolicitud='$tipo_solicitud', idestado_solicitud='$estado', idfuncionarioresponde='$usuario',fechahora_visita='$Fecha',horavisita='$time' WHERE idsolicitud='$idinforme' ", $cn);
echo '<script language="javascript">
location.href="detalle.php?id='.$idinforme.'&area='.$desc_area.'"
</script>';	
}
}
if ($observacion!="")
{
//insertar comentarios
mysql_query("INSERT INTO observaciones VALUES ($idinforme,$usuario,'$Fecha','$time','$observacion')", $cn);	
}
	?>
