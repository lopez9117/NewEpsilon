<title>.: Guardando Cambios :.</title>
<link href="../styles/VisualStyles.css" rel="stylesheet" type="text/css">
<body onBeforeUnload="return window.opener.cargarResultados()">
<table width="50%" border="0" align="center" style="margin-top:20%;">
    <tr>
        <td><img src="../../styles/images/MnyxU.gif" width="64" height="64"/></td>
        <td><strong><h3>Guardando los cambios, por favor espere...</h3></strong></td>
    </tr>
</table>
</body>
<?php
//archivo de conexion
require_once("../../../../dbconexion/conexion.php");
$cn = conectarse();
//declaracion de variables
$tecnica = $_POST['tecnica'];
$informe = $_POST['informe'];
$idInforme = $_POST['idInforme'];
$observacion = $_POST['observacionTranscripcion'];
$usuario = $_POST['usuario'];
$adicional = $_POST['adicional'];
$opcion = $_POST['opcion'];
$firma_respaldo = $_POST['firmaRespaldo'];
$arrayinsumos = $_POST['insumos'];
$cantidadesinsumos = $_POST['cantidades'];
$ecografia = $_POST['eco_biopsia'];
$bilateral = $_POST['biopsiabilateral'];
if ($bilateral == '' || $bilateral == null) {
    $bilateral = 0;
}
$guia = $_POST['guias'];

if ($guia == '') {
    $guia = 0;
}
$cantinsumo = count($_POST['buscarinsumos']);
$cantcantidades = count($_POST['cantidad']);
if ($ecografia == "") {
    $ecografia = 0;
}
$fecha = date("Y") . "-" . date("m") . "-" . date("d");
$hora = date("G:i:s");
$coninsumosfac = mysql_query("SELECT COUNT(*) AS contador FROM r_informe_facturacion WHERE id_informe='$idInforme'", $cn) or showerror(mysql_error(), '1');
$reginsumosfacturacion = mysql_fetch_array($coninsumosfac);
//validar a partir de la opcion de guardado seleccionada
if ($opcion == "finalizar") {
//validar si la tecnica esta vacia
    if ($tecnica != "") {
//validar si ya se ha registrado una tecnica para el informe
        $consTecnica = mysql_query("SELECT COUNT(id_informe) AS id_informe FROM r_tecnica_estudio WHERE id_informe = '$idInforme'", $cn) or showerror(mysql_error(), '2');
        $contTecnica = mysql_fetch_array($consTecnica);
        if ($contTecnica['id_informe'] >= 1) {
//actualizar la tecnica actual
            mysql_query("UPDATE r_tecnica_estudio SET contenido = '$tecnica' WHERE id_informe = '$idInforme'", $cn) or showerror(mysql_error(), '3');
        } else {
//insertar la tecnica
            mysql_query("INSERT INTO r_tecnica_estudio VALUES('$idInforme','$tecnica')", $cn) or showerror(mysql_error(), '4');
        }
    } elseif ($tecnica == "") {
//eliminar la tecnica registrada para dejarla en blanco
        mysql_query("DELETE FROM r_tecnica_estudio WHERE id_informe = '$idInforme'", $cn) or showerror(mysql_error(), '5');
    }
//validar que no se haga mas de una vez el registro
    $sql = mysql_query("SELECT * FROM r_log_informe WHERE id_estadoinforme = '8' AND id_informe ='$idInforme'", $cn) or showerror(mysql_error(), '6');
    $con = mysql_num_rows($sql);
//validar si el informe debe de incluir firma de respaldo
    if ($firma_respaldo != "") {
        mysql_query("INSERT INTO r_firma_respaldo VALUES('$idInforme','$firma_respaldo')", $cn) or showerror(mysql_error(), '7');
    }
//registrar observaciones
    if ($observacionTranscripcion != "") {
        mysql_query("INSERT INTO r_observacion_informe VALUES('$idInforme','$usuario','$observacion','$fecha', '$hora','1')", $cn) or showerror(mysql_error(), '8');
    }
//registrar detalles del informe (transcripcion)
    mysql_query("UPDATE r_detalle_informe SET adicional = '$adicional' WHERE id_informe = '$idInforme'", $cn) or showerror(mysql_error(), '9');
//realizar una insersion en el log
    mysql_query("UPDATE r_informe_header SET id_estadoinforme = '8' WHERE id_informe = '$idInforme'", $cn) or showerror(mysql_error(), '10');
    if ($reginsumosfacturacion['contador'] >= 0) {
//registrar los insumos gastados durante el procedimiento
        mysql_query("UPDATE r_informe_facturacion SET insumos='$arrayinsumos',cantidadinsumos='$cantidadesinsumos',eco_biopsia='$ecografia',bilateral='$bilateral',guia='$guia' WHERE id_informe='$idInforme'", $cn) or showerror(mysql_error(), '11');
    } else {
        mysql_query("INSERT INTO r_informe_facturacion(id_informe,insumos,cantidadinsumos,eco_biopsia,bilateral,guia) VALUES ('$idInforme','$arrayinsumos','$cantidadesinsumos','$ecografia','$bilateral','$guia')", $cn) or showerror(mysql_error(), '12');
    }
//modificar el estado en el encabezado del informe
    mysql_query("INSERT INTO r_log_informe VALUES('$idInforme','$usuario','8','$fecha','$hora')", $cn) or showerror(mysql_error(), '13');
//validar firma de respaldo
    if ($firma_respaldo != "") {
        mysql_query("INSERT INTO r_firma_respaldo VALUES('$idInforme','$firma_respaldo')", $cn) or showerror(mysql_error(), '14');
    }
//cerrar ventana actual
    echo '<script language="javascript">setTimeout(window.close, 2000);</script>';
    echo '<script language="javascript">window.location.href="InformeDefinitivo.php?informe=' . base64_encode($idInforme) . '"</script>';
//include("../../Xml-RIS/Crearxml.php");
} elseif ($opcion == "parcial") {
// validar si la tecnica esta vacia
    if ($tecnica != "") {
//validar si ya se ha registrado una tecnica para el informe
        $consTecnica = mysql_query("SELECT COUNT(id_informe) AS id_informe FROM r_tecnica_estudio WHERE id_informe = '$idInforme'", $cn) or showerror(mysql_error(), '15');
        $contTecnica = mysql_fetch_array($consTecnica);
        if ($contTecnica['id_informe'] >= 1) {
//actualizar la tecnica actual
            mysql_query("UPDATE r_tecnica_estudio SET contenido = '$tecnica' WHERE id_informe = '$idInforme'", $cn) or showerror(mysql_error(), '16');
//echo '<script language="javascript">setTimeout(location.href="../transcripcion/SubirResultado.php?informe=' . base64_encode($idInforme) . '&usuario=' . base64_encode($usuario) . '", 2000);</script>';
        } else {
//insertar la tecnica
            mysql_query("INSERT INTO r_tecnica_estudio VALUES('$idInforme','$tecnica')", $cn) or showerror(mysql_error(), '17');
//echo '<script language="javascript">setTimeout(location.href="../transcripcion/SubirResultado.php?informe=' . base64_encode($idInforme) . '&usuario=' . base64_encode($usuario) . '", 2000);</script>';
        }
    } else {
//validar si ya se ha registrado una tecnica para el informe
        $consTecnica = mysql_query("SELECT COUNT(id_informe) AS id_informe FROM r_tecnica_estudio WHERE id_informe = '$idInforme'", $cn) or showerror(mysql_error(), '18');
        $contTecnica = mysql_fetch_array($consTecnica);
//eliminar la tecnica registrada para dejarla en blanco
        mysql_query("DELETE FROM r_tecnica_estudio WHERE id_informe = '$idInforme'", $cn) or showerror(mysql_error(), '19');
    }
//    //registrar detalles del informe (transcripcion)
    mysql_query("UPDATE r_detalle_informe SET adicional = '$adicional' WHERE id_informe = '$idInforme'", $cn) or showerror(mysql_error(), '20');
//    //registrar observaciones
    if ($observacionTranscripcion != "") {
        mysql_query("INSERT INTO r_observacion_informe VALUES('$idInforme','$usuario','$observacion','$fecha', '$hora','1')", $cn) or showerror(mysql_error(), '21');
    }
//    //registrar los insumos gastados durante el procedimiento
    if ($reginsumosfacturacion['contador'] >= 0) {
        mysql_query("UPDATE r_informe_facturacion SET insumos='$arrayinsumos',cantidadinsumos='$cantidadesinsumos',eco_biopsia='$ecografia',bilateral='$bilateral',guia='$guia' WHERE id_informe='$idInforme'", $cn) or showerror(mysql_error(), '22');
    } else {
        mysql_query("INSERT INTO r_informe_facturacion(id_informe,insumos,cantidadinsumos,eco_biopsia,bilateral,guia) VALUES ('$idInforme','$arrayinsumos','$cantidadesinsumos','$ecografia','$bilateral','$guia')", $cn) or showerror(mysql_error(), '23');
    }
    echo '<script language="javascript">setTimeout(location.href="../transcripcion/SubirResultado.php?informe=' . base64_encode($idInforme) . '&usuario=' . base64_encode($usuario) . '", 2000);</script>';
}
function showerror($e, $line)
{
    echo 'Error en ' . $e . ' en la linea' . $line . '<br/>';

}

?>
</body>