<?php
//variable session
require_once("../../dbconexion/conexion.php");
$cn = Conectarse();
session_start();
$CurrentUser = $_SESSION['Currentuser'];
//incluir archivo que contiene consultas para llenar selects
include("../select/select.php");

?>
<!DOCTYPE>
<html>
<script type="text/javascript" src="fckeditor/fckeditor.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script src="Javascript/Funciones.js"></script>
<script type="text/javascript" src="../../js/jquery-1.7.1.js"></script>
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/ajax.js"></script>
<link href="ckeditor/skins/moono/editor.css" rel="stylesheet" type="text/css">
<link href="styles/Style.css" rel="stylesheet" type="text/css">
<link href="../../css/default.css" rel="stylesheet" type="text/css">
<script src="bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap-theme.min.css">
<script type="text/javascript">
    CKEDITOR.config.disableNativeSpellChecker = false;
    </script>
<script language='javascript'>
    function ValidarSolicitud() {
        var sede, prioridad, asunto, descrequerimiento, tiposolicitud;
        sede = document.Newregistro.sede.value;
        prioridad = document.Newregistro.prioridad.value;
        asunto = document.Newregistro.asunto.value;
        tiposolicitud = document.Newregistro.tipo_solicitud.value;
        descrequerimiento = CKEDITOR.instances['desc_Requerimiento'].getData();
        servicio = document.Newregistro.servicio.value;
        tipo_Adquisicion = document.Newregistro.tipo_Adquisicion.value;
        if (sede == "" || prioridad == "" || asunto == "" || descrequerimiento == "" || tiposolicitud == "" || servicio == "" || tipo_Adquisicion == "" || servicio == "") {
            mensaje = '<font size="2" color="#FF0000">Los campos se�alados con * son obligatorios</font>';
            //etiqueta donde voy a mostrar la respuesta
            document.getElementById('notificacion').innerHTML = mensaje;
        }
        else {
            document.Newregistro.submit();
        }
    }
</script>
<script>
jQuery(function($){
$("#Newregistro").validate({
event: 'blur',
rules: {
title: {required: true},
content: {required: true}
}
});
});
</script>
<style type="text/css">
    .asterisk {
        font-size: 15px;
        color: #F00;
        padding: 2px;
    }
</style>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>Prodiagnostico S.A</title>
</head>
<body>
<table width="100%" border="0">
    <td align="center" valign="middle">
        <div class="marco">
            <div class="ruta">
                <span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a
                            href="../../includes/main_menu.php">MEN&Uacute; PRINCIPAL</a></span> &gt; </a>  <a
                        href="menu/main_menu_solicitudes.php">Solicitudes</a></a> ><a href="menu/mainmenu_compras.php">
                        Soportes Compras </a></span><span class="class_cargo" style="font-size:14px">&gt; Solicitud Compra</span>
                <table width="98%" border="0">
                    <tr>
                        <td colspan="3" valign="top" align="left">
                            <div style="border-bottom: #D3D3D3 2px dotted"></div>
                            <a href="menu/mainmenu_sistemas.php"
                               class="botones"><span><span>Regresar</span></span></a><br><br>

                            <form action="insert/insert_compra.php" method="post" enctype="multipart/form-data"
                                  name="Newregistro" id="Newregistro">
                                <h4 align="center"><strong>Realizar Solicitud Compras y Servicios</strong></h4>
                                <br/>
                                <br/>

                                <div class="row">
                                    <div class="col-lg-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="asunto">Asunto:</label>
                                            <input type="text" name="asunto" id="asunto" class="form-control" required/>
                                            <span class="asterisk">*</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="prioridad">Tipo Prioridad:</label>
                                            <select name="prioridad" id="prioridad" class="form-control" required>
                                                <option value="">.:Seleccione:.</option>
                                                <?php
                                                while ($rowPrioridad = mysql_fetch_array($ListaPrioridad)) {
                                                    echo '<option value="' . $rowPrioridad[idprioridad] . '">' . $rowPrioridad[desc_prioridad] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <span class="asterisk">*</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="tipo_solicitud">Tipo Solicitud:</label>
                                            <select name="tipo_solicitud" id="tipo_solicitud" class="form-control"
                                                    required>
                                                <option value="">.:Seleccione:.</option>
                                                <?php
                                                while ($rowsolicitud = mysql_fetch_array($ListaSolicitud)) {
                                                    echo '<option value="' . $rowsolicitud[id_tiposolicitud] . '">' . $rowsolicitud[desc_tiposolicitud] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <span class="asterisk">*</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="tipo_adquisicion">Tipo Adquisici&oacute;n:</label>
                                            <select name="tipo_Adquisicion" id="tipo_Adquisicion" class="form-control"
                                                    requiered>
                                                <option value="">.:Seleccione:.</option>
                                                <?php
                                                while ($rowAdquisicion = mysql_fetch_array($ListaAdquisicion)) {
                                                    echo '<option value="' . $rowAdquisicion['id_adquisicion'] . '">' . $rowAdquisicion['tipo'] . '</option>';
                                                }
                                                ?>
                                            </select><span class="asterisk">*</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="sede">Sede:</label>
                                            <select name="sede" id="sede" class="form-control" requiered>
                                                <option value="">.:Seleccione:.</option>
                                                <?php
                                                while ($rowSede = mysql_fetch_array($ListaSede)) {
                                                    echo '<option value="' . $rowSede[idsede] . '">' . $rowSede[descsede] . '</option>';
                                                }
                                                ?>
                                            </select><span class="asterisk">*</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="servicio">Servicio:</label>
                                            <select name="servicio" id="servicio" class="form-control" requiered>
                                                <option value="">.:Seleccione:.</option>
                                                <?php
                                                while ($rowServicio = mysql_fetch_array($ListaServicio)) {
                                                    echo '<option value="' . $rowServicio['idservicio'] . '">' . $rowServicio['descservicio'] . '</option>';
                                                }
                                                ?>
                                            </select><span class="asterisk">*</span>
                                        </div>
                                    </div>
                                </div>

                                <label for="ckeditor">Requerimiento</label>
                                <textarea class="ckeditor" name="desc_Requerimiento" id="desc_Requerimiento" cols="100"
                                          rows="5" requiered></textarea><span class="asterisk">*</span>
                                <br/>

                                <div class="row">
                                    <div class="col-lg-4 col-sm-3 col-xs-12 form-group">
                                        <label for="adjunto"></label>
                                        <label for="archivos">Archivos a Subir:</label>
                                        <input type="file" name="archivos[]" multiple/><br/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-sm-3 col-xs-12 form-group">
                                        <button type="submit" name="guardar" id="guardar" onClick="ValidarSolicitud()"
                                                class="btn-primary btn-sm"/>
                                        Enviar</button>
                                        <button type="reset" name="restablecer" id="restablecer"
                                                class="btn-danger btn-sm"/>
                                        Restablecer</button>
                                        <input type="hidden" name="Session" id="Session" value="<?php echo $CurrentUser
                                        ?>"/>
                                        <input type="hidden" name="phpmailer">
                                    </div>
                                </div>
            </div>
            </div>
            <div id="notificacion" class="notificacion"></div>
            </form>
    </td>
</table>
<br>
</div>
</td></tr>
</table>
</body>
</html>