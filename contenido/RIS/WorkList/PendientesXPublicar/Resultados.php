<?php
header("Cache-Control: no-cache");
header("Pragma: no-cache");
include('../../../../dbconexion/conexion.php');
$cn = Conectarse();
include("../../select/selects.php");
$usuario = $_GET['usuario'];
$sede = $_GET['sede'];
$hoy = date('Y-m-d');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE = 7, 8, 9, 10" />
<title>.: Entrega de resultados :.</title>
<link href="../../../../js/ajax.js">
<script src="../../../../js/jquery-1.9.1.js"></script>
<script src="../../../../js/jquery-ui-1.10.3.custom.js"></script>
<link href="../../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css"/>
<link href="../../styles/forms.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="javascript" src="../../javascript/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../../ajax.js"></script>
<link type="text/css" href="../../styles/demo_table.css" rel="stylesheet"/>
<script language="JavaScript">
$(function () { $("#tabs").tabs(); });
$(function () { $(".calendar").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd" }); });
function cargarResultados() {
    var fecha, sede, servicio, usuario;
    fecha = document.VerResultados.fecha.value;
    sede = document.VerResultados.sede.value;
    servicio = document.VerResultados.servicio.value;
    usuario = document.VerResultados.usuario.value;

    if (fecha == "" || sede == "" || servicio == "" || usuario=="") {
        mensaje = "Por favor Verifique los campos vacios";
        document.getElementById('notificacion').innerHTML = mensaje;
        document.getElementById('contenido').innerHTML = "";
    }
    else {
        document.getElementById('notificacion').innerHTML = "";
        $(document).ready(function () {
            verlistado()
        })
        function verlistado() {
            var randomnumber = Math.random() * 11;
            $.post("ListadoResultados.php?fecha=" + fecha + "&sede=" + sede + "&servicio=" + servicio + "&usuario=" + usuario + "",
                { randomnumber: randomnumber }, function (data) { $("#contenido").html(data); });
        }
    }
}
</script>
</head>
<body onblur="cargarResultados()" onfocus="cargarResultados()">
<div style="width:99%; margin-top:0.5%;">
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Resultados Preliminares / Pendientes por publicar</a></li>
        </ul>
        <div id="tabs-1">
            <form name="VerResultados" id="VerResultados" method="post">
                <table width="100%">
                    <tr bgcolor="#E1DFE3">
                        <td width="15%">Fecha</td>
                        <td width="22%">Sede</td>
                        <td width="22%">Servicio</td>
                        <td align="center"><div id="notificacion" style="color: red"></div></td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="fecha" class="calendar" value="<?php echo $hoy ?>" onChange="cargarResultados()" readonly/><span class="asterisk">*</span></td>
                        <td>
                        <select name="sede" id="sede" class="select" onChange="cargarResultados()">
                            <option value="">.: Seleccione :.</option>
                                <?php while ($rowSede = mysql_fetch_array($listaSede)) { ?>
                                    <option value="<?php echo $rowSede['idsede'] ?>" <?php if ($sede == $rowSede['idsede']) { echo 'selected'; } ?> > <?php echo $rowSede['descsede'] ?></option>
                                <?php } ?>
                        </select><span class="asterisk">*</span></td>
                        <td>
                            <select name="servicio" id="servicio" class="select" onChange="cargarResultados()">
                                <option value="">.: Seleccione :.</option>
                                    <?php while ($regListaServicio = mysql_fetch_array($listaServicio)) { echo '<option value="' . $regListaServicio['idservicio'] . '">' . $regListaServicio['descservicio'] . '</option>'; } ?>
                            </select><span class="asterisk">*</span>
                            <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario?>" readonly="readonly">
                        </td>
                        <td>
                            <a href="../videos/Preliminares/Preliminares.html">Video Tutorial</a>
                        </td>
                    </tr>
                </table>
                <table width="100%">
                    <tr>
                        <td><div id="contenido"></div></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
</body>
</html>