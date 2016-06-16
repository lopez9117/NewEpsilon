<?php
session_start();
//Conexion a la base de datos
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$CurrentUser = $_SESSION['currentuser'];
$id = $_POST['idsolicitud'];
$estado=$_POST['estado'];
$Fecha=date("Y/m/d");
$time = date("G:i:s");
$validar = mysql_query("SELECT idsolicitud,idestado_solicitud FROM solicitud where idestado_solicitud=2 AND idsolicitud='$id'", $cn);
$regvalidar = mysql_num_rows($validar);
$Area = mysql_query("SELECT idsolicitud,idarea FROM solicitud where idsolicitud='$id'", $cn);
$regArea = mysql_fetch_array($Area);
if ($estado == 5){$desc_estado="Solicitud de Compra/Servicio Aprobada";}else if($estado ==6){$desc_estado="Solicitud de Compra/Servicio No Aprobada";}else if($estado==7){$desc_estado="Solicitud de Compra/Servicio En Tramite";}else if($estado==8){$desc_estado="Solicitud de Compra/Servicio Pre Aprobada";}
if ($regvalidar>=1)
{
$sql = mysql_query("UPDATE solicitud SET idestado_solicitud='$estado',idfuncionarioresponde='$CurrentUser' WHERE idsolicitud='$id'", $cn);
}
else
{
$sql = mysql_query("UPDATE solicitud SET fechahora_visita='$Fecha',horavisita='$time',idestado_solicitud='$estado',idfuncionarioresponde='$CurrentUser' WHERE idsolicitud='$id'", $cn);
}
	if($regArea['idarea']==3){
		$consulta = mysql_query("SELECT u.email, f.nombres, f.apellidos FROM usuario u
        INNER JOIN funcionario f on u.idusuario=f.idfuncionario WHERE idusuario='$CurrentUser'", $cn);
        $rowconsulta = mysql_fetch_array($consulta);
        $sqlComentario = mysql_query("SELECT o.idfuncionario, o.observacion, f.nombres, f.apellidos,o.fecha,o.hora
        FROM observaciones o
        INNER JOIN funcionario f ON f.idfuncionario = o.idfuncionario
        WHERE o.idsolicitud = '$id'", $cn);

        $comentarios = '';
            $con = mysql_num_rows($sqlComentario);
            if($con == "" || $con==0)
            {
                $comentarios = 'No se han registrado comentarios';
            }
            else
            {
                while($rowObservacion = mysql_fetch_array($sqlComentario))
                {
                    $fecha=$rowObservacion['fecha'];
                    list($Año,$Mes,$Dia)=explode("-",$fecha);
                    $comentarios = $comentarios.'<strong>'. utf8_decode($rowObservacion['nombres']).' '.utf8_decode($rowObservacion['apellidos']).' escrib&oacute; el dia '.$Dia.'/'.$Mes.'/'.$Año.' a las '.$rowObservacion['hora'].'</strong><br>'.utf8_decode($rowObservacion['observacion']).'<br><br>';
                }
            }


        $myString = substr($rowconsulta["nombres"], 0, -1);
        $nombre = ucwords(strtolower($myString . ' ' . $rowconsulta["apellidos"]));
        $asunto = 'Respuesta '.$desc_estado.' '.$id;
        $asunt = utf8_encode($asunto);
        $mensaje = 'Se ha enviado una respuesta desde la Gerencia y/o Subgerencia para la aprobacion de la solicitud. (' . $id . '),
        con los siguientes comentarios: <br><br>'.$comentarios.'<br><br>
        para mas información puede visitar el portal de aplicaciones del modulo de solicitudes.<br>
        http://www.portalprodiagnostico.com.co/newepsilon <br><br>
        Nota: porfavor evite responder sobre este correo, cualquier comentario que se desee agregar es necesario que se haga dentro del modulo de solicitudes para mayor trazabilidad de la información. <br><br>
        Muchas Gracias';
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

        $mail->From = $rowconsulta['email'];

        $mail->FromName = $nombre;

        $mail->Subject = $asunt;

        $vector = array('directorgeneral@prodiagnostico.com.co','subgerencia@prodiagnostico.com.co','subgerenteasistencial@prodiagnostico.com.co');
        foreach ($vector as $email) {
            $mail->addAddress($email, $email);
        }
        $mail->MsgHTML($mensaje);
        if ($mail->Send()) {

        }		
	}
?>