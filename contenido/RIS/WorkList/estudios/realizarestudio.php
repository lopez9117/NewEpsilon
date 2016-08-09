<title>.: Guardando Cambios :.</title>
<link href="../styles/VisualStyles.css" rel="stylesheet" type="text/css">
<body onBeforeUnload="return window.opener.CargarAgenda();">
<table width="50%" border="0" align="center" style="margin-top:20%;">
    <tr>
        <td><img src="../../styles/images/MnyxU.gif" width="64" height="64"/>
        </td>
        <td>
            <strong><h3>Guardando los cambios, por favor espere...</h3></strong>
        </td>
    </tr>
</table>
<?php
//conexion a la BD
require_once("../../../../dbconexion/conexion.php");
$cn = conectarse();
//declaracion de variables con POST
$idpaciente = $_POST['documento'];
$observacion = $_POST['observacion'];
$usuario = $_POST['usuario'];
$idInforme = $_POST['idInforme'];
$estado = $_POST['lectura'];
$KV = $_POST['KV'];
$MAS = $_POST['MAS'];
$Dosis = $_POST['Dosis'];
$i_dañadas = $_POST['i_dañadas'];
$r_innecesarias = $_POST['r_innecesarias'];
$sede = $_POST['sede'];
$servicio = $_POST['servicio'];
$espaciostomografia = $_POST['adicionales'];
$sotano = $_POST['sotano'];
$tipo_comentario = '1';
$DLP=$_POST['DLP'];

if($DLP=="")
{
    $DLP=0;
}

$distancia = $_POST['distancia'];
$foco = $_POST['foco'];
$Dosis = $_POST['Dosis'];
$fluoroscopia = $_POST['tiempofluoroscopia'] != '' ? $_POST['tiempofluoroscopia'] : 0;

if ($espaciostomografia == "") {
    $espaciostomografia = 0;
}
if ($sotano == "") {
    $sotano = 0;
}
$contraste = $_POST['contrastereal'];
if ($contraste == "") {
    $contraste = 0;
}


$medicogeneral = $_POST['nombremedicogeneral'];
$anesteciologo = $_POST['anestesiologo'];
$peso = $_POST['pesop'];
$fecha = date("Y-m-d");
$hora = date("H:i:s");

//varibles para hacer calculo con horas
$horaActual = date("H:i");
$ref_toma = strtotime($horaActual);

$con = mysql_query("SELECT COUNT(*) AS contador FROM r_informe_facturacion WHERE id_informe=$idInforme", $cn) or showerror(mysql_error(), 1);
$regcon = mysql_fetch_array($con);
$contador = $regcon['contador'];

//Si hay observaciones registradas
if ($observacion != "") {
    mysql_query("INSERT INTO r_observacion_informe VALUES('$idInforme','$usuario','$observacion','$fecha','$hora','$tipo_comentario')", $cn) or showerror(mysql_error(), 2);
}
//validar si el estudio tiene lectura o no
if ($estado == 10) {
    //modificar el estado del estudio como realizado sin lectura
    mysql_query("UPDATE r_informe_header SET id_estadoinforme = '$estado',idfuncionario_take='$usuario',medico_general='$medicogeneral',anestesiologo='$anesteciologo',peso_paciente='$peso' WHERE id_informe = '$idInforme'", $cn) or showerror(mysql_error(), 3);
    //registrar el peso en r_paciente
    mysql_query("UPDATE r_paciente SET peso='$peso' WHERE id_paciente='$idpaciente'", $cn) or showerror(mysql_error(), 18);
    //registrar espacios adicionales y cantidad de contraste
    if ($contador > 0) {
        mysql_query("UPDATE r_informe_facturacion SET espacios_tomografia='$espaciostomografia',cantcontraste='$contraste',sotano=$sotano WHERE id_informe='$idInforme'", $cn) or showerror(mysql_error(), 4);
    } else {
        mysql_query("INSERT INTO r_informe_facturacion(id_informe,espacios_tomografia,cantcontraste,sotano) VALUES ($idInforme,$espaciostomografia,$contraste,$sotano)", $cn) or showerror(mysql_error(), 5);
    }
    //registrar el estudio como realizado sin lectura
    mysql_query("INSERT INTO r_log_informe VALUES('$idInforme','$usuario','$estado','$fecha','$hora')", $cn) or showerror(mysql_error(), 6);
    //cerrar ventana despues de realizar las operaciones en BD
    echo
    '<script language="javascript">
		setTimeout(window.close, 3000);
	</script>';
} elseif ($estado == 2) {
    //consultar que medico esta en agenda para registrarle el estudio.
    $consEspecialista = mysql_query("SELECT idfuncionario AS especialista FROM r_horario_especialista WHERE idsede = '$sede' AND idservicio = '$servicio' AND fecha = '$fecha'
	AND '$ref_toma' BETWEEN hr_desde AND hr_hasta", $cn) or showerror(mysql_error(), 8);
    $contEspecialista = mysql_num_rows($consEspecialista);
    //si hay un especialista asignado para el horario en que se toma el estudio
    if ($contEspecialista >= 1) {
        //realizar asignacion al medico registrado
        $regEspecialista = mysql_fetch_array($consEspecialista);
        $idEspecialista = $regEspecialista['especialista'];
        //enviar a lista especifica
        //modificar el estado del estudio como realizado con lectura
        mysql_query("UPDATE r_informe_header SET id_estadoinforme = '$estado',idfuncionario_take='$usuario',idfuncionario_esp = '$idEspecialista',medico_general='$medicogeneral',anestesiologo='$anesteciologo',peso_paciente='$peso' WHERE id_informe = '$idInforme'", $cn) or showerror(mysql_error(), 9);
        //registrar el peso en r_paciente
        mysql_query("UPDATE r_paciente SET peso='$peso' WHERE id_paciente='$idpaciente'", $cn) or showerror(mysql_error(), 19);
        //registrar espacios adicionales y cantidad de contraste
        if ($contador > 0) {
            mysql_query("UPDATE r_informe_facturacion SET espacios_tomografia='$espaciostomografia',cantcontraste='$contraste',sotano=$sotano WHERE id_informe='$idInforme'", $cn) or showerror(mysql_error(), 10);
        } else {
            mysql_query("INSERT INTO r_informe_facturacion(id_informe,espacios_tomografia,cantcontraste,sotano) VALUES ($idInforme,$espaciostomografia,$contraste,$sotano)", $cn) or showerror(mysql_error(), 11);
        }
        //registrar el estudio como realizado con lectura
        mysql_query("INSERT INTO r_log_informe VALUES('$idInforme','$usuario','$estado','$fecha','$hora')", $cn) or showerror(mysql_error(), 12);
        echo
        '<script language="javascript">
			setTimeout(window.close, 3000);
		</script>';
    } else {
        //realizar el proceso normal y enviar a lista de asignacion
        //modificar el estado del estudio como realizado con lectura
        mysql_query("UPDATE r_informe_header SET id_estadoinforme = '$estado',idfuncionario_take='$usuario',medico_general='$medicogeneral',anestesiologo='$anesteciologo',peso_paciente='$peso' WHERE id_informe = '$idInforme'", $cn) or showerror(mysql_error(), 14);
        //registrar el peso en r_paciente
        mysql_query("UPDATE r_paciente SET peso='$peso' WHERE id_paciente='$idpaciente'", $cn) or showerror(mysql_error(), 20);
        //registrar espacios adicionales y cantidad de contraste
        if ($contador > 0) {
            mysql_query("UPDATE r_informe_facturacion SET espacios_tomografia='$espaciostomografia',cantcontraste='$contraste',sotano=$sotano WHERE id_informe='$idInforme'", $cn) or showerror(mysql_error(), 15);
        } else {
            mysql_query("INSERT INTO r_informe_facturacion(id_informe,espacios_tomografia,cantcontraste,sotano) VALUES ($idInforme,$espaciostomografia,$contraste,$sotano)", $cn) or showerror(mysql_error(), 16);
        }
        //registrar el estudio como realizado con lectura
        mysql_query("INSERT INTO r_log_informe VALUES('$idInforme','$usuario','$estado','$fecha','$hora')", $cn) or showerror(mysql_error(), 17);
        echo
        '<script language="javascript">
			setTimeout(window.close, 3000);
		</script>';
    }

}
//registrar el worlist
mysql_query("UPDATE r_worklist_temp SET procesado='4', observacion= '$observaciones' WHERE idestudio=$idInforme", $cn) or showerror(mysql_error(), 18);
mysql_query("INSERT INTO r_estadistica (id_informe, mas, kv, i_danadas, r_innecesarias, total_dosis,distancia,foco,tiempofluoroscopia,DLP) VALUES('$idInforme','$MAS','$KV','$i_dañadas','$r_innecesarias','$Dosis','$distancia','$foco','$fluoroscopia','$DLP')", $cn) or showerror(mysql_error(), 19);

function showerror($error, $line)
{
    echo 'Ha ocurrido un error ' . $error . ' En la query ' . $line . '<br/>';
}

?>
</body>