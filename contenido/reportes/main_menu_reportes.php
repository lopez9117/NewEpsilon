<?php
//sesion del usuario, validacion de la sesion para que no se pueda ingresar por url
session_start();
$CurrentUser = $_SESSION['currentuser'];
$mod = 7;
include("../ValidarModulo.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>Prodiagnostico S.A</title>
    <link type="text/css" href="../../css/demo_table.css" rel="stylesheet"/>
    <link href="../../css/default.css" rel="stylesheet" type="text/css">
    <link href="../../css/forms.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        body {
            margin-left: 0px;
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
        }
    </style>
</head>
<body topmargin="0">
<table width="100%" border="0">
    <tr>
        <td align="center" valign="middle">

            <div class="marco">
                <div class="ruta">
                    <span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a
                                href="../../includes/main_menu.php">MEN&Uacute;
                                PRINCIPAL</a></span> &gt; Reportes</span>
                </div>
                <table width="98%" border="0">
                    <tr>
                        <td colspan="2" height="7">
                            <div style="border-bottom: #D3D3D3 2px dotted"></div>
                            <br></td>
                    </tr>
                    <tr>
                        <td valign="top" align="center" bgcolor="#DEDEDE">
                            <table width="99%" border="0" cellpadding="0" cellspacing="0" bordercolor="#E6E9EC"
                                   bgcolor="#DEDEDE">
                                <tr>
                                    <td width="25%" height="100" align="center">
                                        <table width="80%">
                                            <tr>
                                                <td width="25%">
                                                    <a class="class_nombre" style="text-decoration:none"
                                                       href="ReportsCostos.php">
                                                        <img src="../../images/mac.png" width="72" height="72"
                                                             id="Image1" border="0"></a>
                                                </td>
                                                <td width="75%" valign="middle">
                                                    <div style="margin-left:4px">
				<span style="">
				<a class="class_login" style="text-decoration:none;font-size:16px" href="ReportsCostos.php">
                    Costos</a></span>.<br/>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    //-----------------------------------------------------------------------//
                                   

                                    <?php
                                    $conModulo = mysql_query("SELECT * FROM modulo_usuario WHERE idusuario='$CurrentUser' AND idmodulo='13'", $cn);
                                    $con = mysql_num_rows($conModulo);
                                    if ($con > 0) {
                                        ?>
                                        <td width="25%" height="100" align="center">
                                            <table width="80%">
                                                <tr>
                                                    <td width="25%"><a class="class_nombre" style="text-decoration:none"
                                                                       href="ReportFacuracionSede2.php"> <img
                                                                src="../../images/salud.png" alt="" width="72" height="72"
                                                                border="0" id="Image2"/></a></td>
                                                    <td width="75%" valign="middle">
                                                        <div style="margin-left:4px"><span style=""> <a
                                                                    class="class_login"
                                                                    style="text-decoration:none;font-size:16px"
                                                                    href="ReportFacuracionSede2.php">Reporte Superintendencia</a></span><br/>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>



                                    //---------------------------------------------------------------------------------

                                    <?php }
                                    $conModulo = mysql_query("SELECT * FROM modulo_usuario WHERE idusuario='$CurrentUser' AND idmodulo='13'", $cn);
                                    $con = mysql_num_rows($conModulo);
                                    if ($con > 0) {
                                        ?>
                                        <td width="25%" height="100" align="center">
                                            <table width="80%">
                                                <tr>
                                                    <td width="25%"><a class="class_nombre" style="text-decoration:none"
                                                                       href="ReportFacuracionSede.php"> <img
                                                                src="../../images/ark.png" alt="" width="72" height="72"
                                                                border="0" id="Image2"/></a></td>
                                                    <td width="75%" valign="middle">
                                                        <div style="margin-left:4px"><span style=""> <a
                                                                    class="class_login"
                                                                    style="text-decoration:none;font-size:16px"
                                                                    href="ReportFacuracionSede.php">General.</a></span><br/>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>

                                    <?php }                                    
                                    $conModulo = mysql_query("SELECT * FROM modulo_usuario WHERE idusuario='$CurrentUser' AND idmodulo='12'", $cn);
                                    $con = mysql_num_rows($conModulo);
                                    if ($con > 0) {
                                        ?>
                                        <td width="25%" height="100" align="center">
                                            <table width="80%">
                                                <tr>
                                                    <td width="25%"><a class="class_nombre" style="text-decoration:none"
                                                                       href="FacturacionSedeReporte.php"><img
                                                                src="../../images/calc.png" alt="" name="Image3"
                                                                width="72"
                                                                height="72" border="0" id="Image3"/></a></td>
                                                    <td width="75%" valign="middle">
                                                        <div style="margin-left:4px"><span style=""> <a
                                                                    class="class_login"
                                                                    style="text-decoration:none;font-size:16px"
                                                                    href="FacturacionSedeReporte.php">
                                                                    Facturaci&oacute;n.</a></span><br/>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    <?php } ?>
                                    <td width="25%" height="100" align="center">
                                        <table width="80%">
                                            <tr>
                                                <td width="25%"><a class="class_nombre" style="text-decoration:none"
                                                                   href="reporteventAdverso.php"> <img
                                                            src="../../images/access.png" alt="" width="72" height="72"
                                                            border="0" id="Image3"/></a></td>
                                                <td width="75%" valign="middle">
                                                    <div style="margin-left:4px"><span style=""> <a class="class_login"
                                                                                                    style="text-decoration:none;font-size:16px"
                                                                                                    href="reporteventAdverso.php">
                                                                Servicios no Conformes.</a></span><br/>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width="25%" height="100" align="center">
                                        <table width="80%">
                                            <tr>
                                                <td width="25%"><a class="class_nombre" style="text-decoration:none"
                                                                   href="ReporteProduccionEspecialista.php"> <img
                                                            src="../../images/icono_medico.png" alt="" width="72"
                                                            height="72" border="0" id="Image4"/></a></td>
                                                <td width="75%" valign="middle">
                                                    <div style="margin-left:4px"><span style=""> <a class="class_login"
                                                                                                    style="text-decoration:none;font-size:16px"
                                                                                                    href="ReporteProduccionEspecialista.php">
                                                                Producci&oacute;n por Especialista.</a></span><br/>
                                                    </div>
                                                </td>
                                            </tr>

                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan=4 background="" height="8" align="center">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <br>
            </div>
        </td>
    </tr>
</table>
</body>
</html>