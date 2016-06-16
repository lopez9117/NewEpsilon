<?php
require_once("../../../../dbconexion/conexion.php");
function createOrdenpdf()
{
    $Norden = $_POST['adjunto'];
    $cn = conectarse();
    $sqlorden = mysql_query("SELECT * FROM _temp WHERE idorden='$Norden'", $cn);
    $regorden = mysql_fetch_array($sqlorden);
//datos paciente
    $idservicio = $regorden['id_servicio'];
    $idpac = $regorden['idpaciente'];
    $telefonos = $regorden['telefono'];
    $direccion = $regorden['direccion'];
    $nom1 = $regorden['nombre1'];
    $nom2 = $regorden['nombre2'];
    $ape1 = $regorden['apellido1'];
    $ape2 = $regorden['apellido2'];
    $nac = $regorden['fchnacimiento'];
    $sex = $regorden['sexo'];
    if ($sex=="F"){$sex="Femenino";}else{$sex="Masculino";}
    $eps = $regorden['eps'];
//Datos Agendamiento
    $idOrd = $regorden['idorden'];
    $idmedreferencia = $regorden['idMedRef'];
    $descServ = $regorden['descservicio'];
    $codcups = $regorden['codservicio'];
    $desc_tecnica = $regorden['tecnica'];
    $ubicacion = $regorden['ubicacion'];
    $tipoD = $regorden['tipo'];
    $fecha_solicitud = $regorden['fch_solicitud'];
    $cie10 = $regorden['coddx'];
    $diagnostico = $regorden['descripciondx'];
    $sustentacion = $regorden['sustentacion'];
    $medico_solicitante = $regorden['NomMedRef'] . ' ' . $regorden['ApeMedRef'];
    $especialidad = $regorden['especialidad'];
    $conver = substr($fecha_solicitud, -0, 8);
    $fch_sol = date("d/m/Y", strtotime($conver));
    $lugar = 2;
    $solo_hora = substr($fecha_solicitud, 8, 4);
    $insertar = ":";
    $hora_creada = $resultado = substr($solo_hora, 0, $lugar) . $insertar . substr($solo_hora, $lugar);
    $rest = substr($nac, -0, 8);
    $f_nac = date("d/m/Y", strtotime($rest));
    function edad($fecha_de_nacimiento)
    {
        if (is_string($fecha_de_nacimiento)) {
            $fecha_de_nacimiento = strtotime($fecha_de_nacimiento);
        }
        $diferencia_de_fechas = time() - $fecha_de_nacimiento;
        return ($diferencia_de_fechas / (60 * 60 * 24 * 365));
    }

    $edad_posible = edad($rest);
    if ($idservicio==1){ $desc_tecnicaR = $desc_tecnica; } else { $desc_tecnicaR = 'No Aplica';}
//obtener los datos del encabezado para el informe

    $html = "";
    $html = $html .
        '<!DOCTYPE html>
<html>
<head>
<title>.: Orden GHIPS :.</title>
<style type="text/css">
    body
{font-family:Arial, Helvetica, sans-serif;
font-size:15px;
font-size:25px;
}
.fondo
{background-color:#D3D3D3;
}
.img
{
    width:120px;
	height:100px;
}
p
{
    line-height: 0.10cm
}
</style>
</head>
<body>';
    $html = $html . '<table style="font-size:40px">
                       <tr>
                            <td width="30%" aling="left">
                            <img class="img" src="../../images/ips_universitaria.JPG"/>
                            </td>
                            <td width="45%">
                            <strong>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            CLINICA LEON XIII<br/><br/>
                            Calle 69 No. 51C-24 - Tel&eacute;fono: 5167300<br/>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            Antioquia - Medell&iacute;n
                            </strong>
                            </td>
                            <td width="30%">
                            <strong>
                            ORDENES MEDICAS
                            </strong>
                            </td>
                        </tr></table>
                    <table border="0.5" rules="all">
                        <tr>
                            <td ALIGN="CENTER" class="fondo" colspan="4">
                            <strong>ORDENES MEDICAS</strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="fondo"><strong> Paciente </strong></td>
                            <td> '. $nom1 . ' ' . $nom2 . ' ' . $ape1 . ' ' . $ape2 . '</td>
                            <td class="fondo"><strong> N&uacute;mero de identificaci&oacute;n </strong></td>
                            <td> ' . $tipoD . ' - ' . $idpac . '</td>
                            </tr>
                            <tr>
                            <td class="fondo"><strong> N&uacute;mero de atenci&oacute;n: </strong></td>
                            <td> ' . $idOrd . '</td>
                            <td class="fondo"><strong> Fecha de nacimiento </strong></td>
                            <td> ' . $f_nac . '</td>

                        </tr>
                        <tr>
                            <td class="fondo"><strong> Edad </strong></td>
                            <td> ' . (integer)$edad_posible . ' ' . '</td>
                            <td class="fondo"><strong> Direcci&oacute;n: </strong></td>
                            <td> ' . $direccion . '</td>
                        </tr>
                        <tr>
                            <td class="fondo"><strong> Tel&eacute;fono </strong></td>
                            <td> ' . $telefonos . '</td>
                            <td class="fondo"><strong> G&eacute;nero </strong></td>
                            <td> ' . $sex . '</td>
                        </tr>
                        <tr>
                            <td class="fondo"><strong> Diagnostico &nbsp;</strong></td>
                            <td>' .$cie10.' - '. utf8_decode($diagnostico) . '</td>
                            <td class="fondo"><strong> Aseguradora </strong></td>
                            <td>' . $regorden['codeps'].' - '.$eps . '</td>
                        </tr>
                        <tr>
                            <td class="fondo"><strong> Cama/Ubicaci&oacute;n </strong></td>
                            <td> ' . $ubicacion . '</td>
                            <td class="fondo"><strong> Especialidad </strong></td>
                            <td> ' . $especialidad . '</td>
                        </tr>
                    </table><br/>
                    <table border="0.5" rules="all">
                        <tr>
                            <td class="fondo"><strong> Cups </strong></td>
                            <td> ' . $codcups . '</td>
                        </tr>
                        <tr>
                            <td class="fondo"><strong> Especificaciones </strong></td>
                            <td>' . $descServ . '</td>
                        </tr>
                        <tr>
                            <td class="fondo"><strong> Fecha de Solicitud </strong></td>
                            <td> ' . $fch_sol .' '.$hora_creada. '</td>
                        </tr>
                        <tr>
                            <td class="fondo"><strong> Tipo Tomograf&iacute;a </strong></td>
                            <td> ' . $desc_tecnica . '</td>
                        </tr>
                        <tr>
                            <td class="fondo"><strong> Tipo Radiograf&iacute;a </strong></td>
                            <td> ' . $desc_tecnicaR  . '</td>
                        </tr>
                        <tr>
                            <td class="fondo"><strong> PYP </strong></td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td class="fondo"><strong> Cantidad </strong></td>
                            <td> </td>
                        </tr>
                        <tr>
                            <td class="fondo" aling="left"><strong> Sustentacion:&nbsp;</strong></td>
                            <td>' . utf8_decode($sustentacion) . '</td>
                        </tr>
                        <tr>
                            <td class="fondo"><strong> Solicitante </strong></td>
                            <td> ' . $medico_solicitante .' CC: '. $idmedreferencia . '</td>
                        </tr>
                    </table>
        </body>
</html>';
    return utf8_encode($html);
}

?>


