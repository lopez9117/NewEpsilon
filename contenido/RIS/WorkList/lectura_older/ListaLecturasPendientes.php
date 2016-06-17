<?php
require_once("../../../../dbconexion/conexion.php");
$cn = conectarse();
include("../../select/selects.php");
$Anio = date("Y");
$Mes = date("m");
$dias = date('t', mktime(0, 0, 0, $Mes, 1, $Anio));
$fecha_inicio = ($Anio . '-' . $Mes . '-' . '01');
$fecha_limite = ($Anio . '-' . $Mes . '-' . $dias);
list($AÑO, $MES, $DIA) = explode("-", $fecha_inicio);
$DESDE = ($MES - 01) . "/" . $DIA . "/" . $AÑO;
list($AÑO, $MES, $DIA) = explode("-", $fecha_limite);
$HASTA = $MES . "/" . $DIA . "/" . $AÑO;
?>
<script type="text/javascript" language="javascript" src="../../javascript/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../../ajax.js"></script>
<link type="text/css" href="../../styles/demo_table.css" rel="stylesheet"/>
<script>
    function CargarAgenda() {
        var fechaDesde, fechaHasta, sede, servicio, usuario;
        fechaDesde = document.VerAgenda.fechaDesde.value;
        fechaHasta = document.VerAgenda.fechaHasta.value;
        sede = document.VerAgenda.sede.value;
        servicio = document.VerAgenda.servicio.value;
        usuario = document.VerAgenda.usuario.value;

        if (fechaDesde == "" || fechaHasta == "" || sede == "" || servicio == "") {
            mensaje = "<font color='#FF0000'>Los campos marcados con * son obligatorios</font>";
            document.getElementById('notificacion').innerHTML = mensaje;
            document.getElementById('contenido').innerHTML = "";
        }
        else {
            document.getElementById('notificacion').innerHTML = "";
            $(document).ready(function () {
                verlistado()
                //CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO
            })
            function verlistado() { //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
                var randomnumber = Math.random() * 11;
                $.post("ListaPendientesPorLectura.php?fechaHasta=" + fechaHasta + "&fechaDesde=" + fechaDesde + "&sede=" + sede + "&servicio=" + servicio + "&usuario=" + usuario + "", {
                    randomnumber: randomnumber
                }, function (data) {
                    $("#contenido").html(data);
                });
            }
        }
    }

    function ventanaEmergente(ultimo_informe) {
        if (ultimo_informe != "") {
            ajax = nuevoAjax();
            //llamado al archivo que va a ejecutar la consulta ajax
            ajax.open("POST", "../acciones/ActualizarEstadoVentana.php", true);
            ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            ajax.send("ultimo_informe=" + ultimo_informe + "&tiempo=" + new Date().getTime());
        }
    }
</script>
<body onLoad="CargarAgenda()" onBlur="CargarAgenda()" onFocus="CargarAgenda()">
<form name="VerAgenda" id="VerAgenda" method="post">
    <table width="100%">
        <tr bgcolor="#E1DFE3">
            <td width="15%">Desde</td>
            <td width="15%">Hasta</td>
            <td width="22%">Sede</td>
            <td width="22%">Servicio</td>
            <td width=""><span class="asterisk">
        <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>">
      </span></td>
        </tr>
        <tr>
            <td><input type="text" id="datepicker2" name="fechaDesde" class="texto" value="<?php
                echo $DESDE;
                ?>" onChange="CargarAgenda()" readonly/><span class="asterisk">*</span></td>
            <td><label for="fecha"></label>
                <input type="text" id="datepicker" name="fechaHasta" class="texto" value="<?php
                echo $HASTA;
                ?>" onChange="CargarAgenda()" readonly/><span class="asterisk">*</span></td>
            <td><label for="sede"></label>
                <select name="sede" id="sede" class="select" onChange="CargarAgenda()">
                    <option value="">.: Seleccione :.</option>
                    <?php
                    while ($rowSede = mysql_fetch_array($listaSede)) {
                        ?>
                        <option value="<?php echo $rowSede['idsede']?>"
                            <?php if ($rowSede['idsede'] == $sede) {
                                echo 'selected';
                            }?>><?php echo $rowSede['descsede']?></option>';
                    <?php
                    }
                    ?>
                </select><span class="asterisk">*</span></td>
            <td><label for="servicio"></label>
                <select name="servicio" id="servicio" class="select" onChange="CargarAgenda()">
                    <option value="">.: Seleccione :.</option>
                    <?php
                    while ($regListaServicio = mysql_fetch_array($listaServicio)) {
                        echo '<option value="' . $regListaServicio['idservicio'] . '">' . $regListaServicio['descservicio'] . '</option>';
                    }
                    ?>
                </select><span class="asterisk">*
      
      </span></td>
            <td>
                <div id="notificacion" align="left"></div>
                <a href="../../Videos/LecturayAprobacion/LecturayAprobacion.html">Ver Video-Tutorial</a>
                <div align="right" style="position:relative;"><img src="../../../../images/reload.png" width="24"
                                                                   height="24" title="Recargar" alt="Recargar"
                                                                   onClick="CargarAgenda()"></div>
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td>
                <div id="contenido"></div>
            </td>
        </tr>
    </table>
</form>