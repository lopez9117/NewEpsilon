<?php
//variable session
session_start();
$usuario = $_SESSION['currentuser'];
require_once("../../dbconexion/conexion.php");
include("../select/select.php");
$cn = Conectarse();
?>
<!DOCTYPE>
<html>
<script src="bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap-theme.min.css">
<script type="text/javascript" src="fckeditor/fckeditor.js"></script>
<script src="ckeditor/ckeditor.js"></script>
<script src="Javascript/Funciones.js"></script>
<script type="text/javascript" src="../../js/jquery-1.7.1.js"></script>
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/ajax.js"></script>
<link href="ckeditor/skins/moono/editor.css" rel="stylesheet" type="text/css">
<link href="styles/Style.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
    CKEDITOR.config.disableNativeSpellChecker = false;
    </script>
<head>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>Prodiagnostico S.A</title>
</head>
<body onBeforeUnload="return window.opener.cargardiv('<?php echo $count ?>');">
<form action="insert/insert_comunicaciones.php" method="post" enctype="multipart/form-data"
                  name="Newregistro" id="Newregistro">
                 <h4 align="center"><strong>Realizar Solicitud Comunicaciones</strong></h4>
    <div class="row">
        <div class="col-lg-4 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="asunto">Asunto</label>
                <input type="text" name="asunto" id="asunto" class="form-control" required/>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="prioridad">Prioridad</label>
                <select name="prioridad" id="prioridad" class="form-control" required>
                    <option value="">.:Seleccione:.</option>
                    <?php
                    while ($rowPrioridad = mysql_fetch_array($ListaPrioridad)) {
                        echo '<option value="' . $rowPrioridad['idprioridad'] . '">' . $rowPrioridad['desc_prioridad'] . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="col-lg-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="sede">Sede:</label>
                <select name="sede" id="sede" onChange="mostrarEquipo()" class="form-control" required>
                    <option value="">.:Seleccione:.</option>
                    <?php
                    while ($rowSede = mysql_fetch_array($ListaSede)) {
                        echo '<option value="' . $rowSede[idsede] . '">' . $rowSede[descsede] . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <label for="ckeditor">Requerimiento:</label>
    <textarea class="ckeditor" name="desc_Requerimiento" id="desc_Requerimiento" cols="100" rows="5" required></textarea>
<div id="notificacion" class="notificacion"></div>
    <div class="row">
        <div class="col-lg-4 col-sm-3 col-xs-12 form-group">
        <label>Archivos a Subir:</label></dt>
        <input type="file" name="archivos[]" multiple/><br/>
    </div>
    </div>
    
    <div class="row">
        <div class="col-lg-4 col-sm-3 col-xs-12 form-group">
            <button type="submit" name="guardar" id="guardar" value="Enviar" class="btn-primary btn-sm"/>Enviar</button>
            <button type="reset" name="restablecer" id="restablecer" value="Restablecer" class="btn-danger btn-sm"/>Restablecer</button>
            <input type="hidden" name="Session" id="Session" value="<?php echo $usuario
            ?>"/>
            <input type="hidden" name="contador" id="contador" value="<?php echo $count='4';
            ?>"/>
            <input type="hidden" name="phpmailer">
        </div>
    </div>
</form>
</body>
</html>