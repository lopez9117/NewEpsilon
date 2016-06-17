<title>.: Guardando Cambios :.</title>
<link href="../styles/VisualStyles.css" rel="stylesheet" type="text/css">
<body onBeforeUnload="return window.opener.cargardiv();">
<table width="50%" border="0" align="center" style="margin-top:20%;">
    <tr>
        <td><img src="../styles/images/MnyxU.gif" width="64" height="64"/>
        </td>
        <td>
            <strong><h3>Guardando los cambios, por favor espere...</h3></strong>
        </td>
    </tr>
</table>
</body>
<?php
//inicio de session
session_start();
$usuario = $_SESSION[currentuser];
//funcion para abrir conexion
require_once("../../../dbconexion/conexion.php");
ini_set('max_execution_time', 0);
$cn = Conectarse();
$consulta = mysql_query("SELECT u.email, f.nombres, f.apellidos FROM usuario u
INNER JOIN funcionario f on u.idusuario=f.idfuncionario WHERE idusuario='$usuario'", $cn);
$rowconsulta = mysql_fetch_array($consulta);
//declaracion de variables con metodo POST
$Sede = $_POST['sede'];
$Fecha = date("Y/m/d");
$time = date("G:i:s");
echo $ruta = 'uploads';
echo $carpeta = '/' . $usuario;
$prioridad = $_POST['prioridad'];
$sqlInfo = mysql_query("SELECT MAX(idsolicitud+1) AS idsolicitud FROM solicitud", $cn);
$regInfo = mysql_fetch_array($sqlInfo);
$idSolicitud = $regInfo['idsolicitud'];
$equipo = $_POST['selectEquipo'];
$desc_Requerimiento = $_POST['desc_Requerimiento'];
$requerimiento = utf8_encode($desc_Requerimiento);
$asunto = utf8_encode($_POST["asunto"]);
$adjunto = $_FILES["archivos"];
if (isset($_POST["phpmailer"])) {

    $myString = substr($rowconsulta["nombres"], 0, -1);
    $nombre = ucwords(strtolower($myString . ' ' . $rowconsulta["apellidos"]));
    $mensaje = 'Se ha realizado una solicitud identificada con el numero (' . $idSolicitud . '), con el suguiente requerimiento: <br><br>' . $_POST["desc_Requerimiento"] . '<br><br> para mas información puede visitar el portal de aplicaciones del modulo de solicitudes.<br> http://www.portalprodiagnostico.com.co/newepsilon <br><br> Nota: porfavor evite responder sobre este correo, cualquier comentario que se desee agregar es necesario que se haga dentro del modulo de solicitudes para mayor trazabilidad de la información. <br><br> Muchas Gracias ';
    $adjunto = $_FILES["archivos"];
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

    $mail->Subject = $asunto;

    $vector = array($rowconsulta['email'], 'coordinacionbiomedica@prodiagnostico.com.co', 'biomedica@prodiagnostico.com.co');
    foreach ($vector as $email) {
        $mail->addAddress($email, $email);
    }
    $mail->MsgHTML($mensaje);


    if (isset ($_FILES["archivos"])) {
        //de se asi, para procesar los archivos subidos al servidor solo debemos recorrerlo
        //obtenemos la cantidad de elementos que tiene el arreglo archivos
        $tot = count($_FILES["archivos"]["name"]);
        //este for recorre el arreglo
        for ($i = 0; $i < $tot; $i++) {
            $tmp_name = $_FILES["archivos"]["tmp_name"][$i];
            $name = $_FILES["archivos"]["name"][$i];
            $mail->addAttachment($tmp_name, $name);
        }
    }


    if ($mail->Send()) {
        echo 'En hora buena el mensaje ha sido enviado con exito a $email';
        echo '<script type="text/javascript">
					window.close();
					</script>';
    } else {
        echo "Lo siento, ha habido un error al enviar el mensaje a $email";
        echo '<script type="text/javascript">
					window.close();
					</script>';
    }
}

if (file_exists($ruta . '/' . $carpeta)) {
    if (isset ($_FILES["archivos"])) {
        //de se asi, para procesar los archivos subidos al servidor solo debemos recorrerlo
        //obtenemos la cantidad de elementos que tiene el arreglo archivos
        $tot = count($_FILES["archivos"]["name"]);
        //este for recorre el arreglo
        for ($i = 0; $i < $tot; $i++) {
            //con el indice $i, poemos obtener la propiedad que desemos de cada archivo
            //para trabajar con este
            $tmp_name = $_FILES["archivos"]["tmp_name"][$i];
            $name = $_FILES["archivos"]["name"][$i];
            //copiar los archivos adjuntos en la carpeta uploads
            copy($tmp_name, $ruta . '/' . $usuario . '/' . $name);
            $url = $ruta . '/' . $usuario . '/' . $name;
            //insertar en la tabla adjuntos para luego realizar consulta del total de archivos adjuntos
            mysql_query("INSERT INTO adjuntos_solicitudes (adjunto,idsolicitud) VALUES ('$url','$idSolicitud')", $cn);
        }
    }
} else {
    $carpeta = mkdir($ruta . '/' . $CurrentUser);
    if (isset ($_FILES["archivos"])) {
        //de se asi, para procesar los archivos subidos al servidor solo debemos recorrerlo
        //obtenemos la cantidad de elementos que tiene el arreglo archivos
        $tot = count($_FILES["archivos"]["name"]);
        //este for recorre el arreglo
        for ($i = 0; $i < $tot; $i++) {
            //con el indice $i, poemos obtener la propiedad que desemos de cada archivo
            //para trabajar con este
            $tmp_name = $_FILES["archivos"]["tmp_name"][$i];
            $name = $_FILES["archivos"]["name"][$i];
            //copiar los archivos adjuntos en la carpeta uploads
            copy($tmp_name, $ruta . '/' . $usuario . '/' . $name);
            $url = $ruta . '/' . $usuario . '/' . $name;
            //insertar en la tabla adjuntos para luego realizar consulta del total de archivos adjuntos
            mysql_query("INSERT INTO adjuntos_solicitudes (adjunto,idsolicitud) VALUES ('$url','$idSolicitud')", $cn);
        }
    }
}
mysql_query("INSERT INTO solicitud (idsolicitud, idsede, idarea, desc_requerimiento, fechahora_solicitud, fechahora_visita, idestado_solicitud, asunto, idfuncionario, idsatisfaccion, id_adquisicion, horasolicitud, horavisita, idfuncionarioresponde, idprioridad, id_tiposolicitud, id_estadocompra, id_presupuesto, idservicio, porque, id_referencia)
					VALUES ('$idSolicitud','$Sede','2','$requerimiento','$Fecha',NULL,'1','$asunto','$usuario','3','0','$time',NULL,'0','$prioridad','0','0','0','0','','$equipo')", $cn);
?>