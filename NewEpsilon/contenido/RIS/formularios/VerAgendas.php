<?php
$cn = Conectarse();
include("../select/selects.php");
?>
<script language="JavaScript" type="text/javascript" src="../javascript/ajax.js"></script>
<script language="JavaScript" src="../../../js/jquery.js"></script>
<script src="../../../js/jquery.form.js"></script>
<script language="JavaScript" src="../js/jquery-ui-1.10.0.custom.min.js"></script>
<script type="text/javascript" language="javascript" src="../javascript/jquery.dataTables.js"></script>
<script src="../js/timepicker.js"></script>
<link type="text/css" href="../styles/demo_table.css" rel="stylesheet"/>
<link type="text/css" href="../css/ui-lightness/jquery-ui-1.8.13.custom.css" rel="stylesheet"/>
<script language='javascript'>
    /// funcion para mostrar agendas del dia seleccionado
    function agendasProgramadas() {
        var fecha, sede, servicio, usuario, HoraIni, Horafin;
        fecha = document.VerAgenda.fecha.value;
        sede = document.VerAgenda.sede.value;
        servicio = document.VerAgenda.servicio.value;
        HoraIni = document.VerAgenda.HoraIni.value;
        HoraFin = document.VerAgenda.HoraFin.value;
        usuario = document.VerAgenda.usuario.value;

        if (fecha == "" || sede == "" || servicio == "" || HoraIni == "" || HoraFin == "") {
            susess = "<font color='#FF0000'>Los campos marcados con * son obligatorios</font>";
            document.getElementById('mensajito').innerHTML = susess;
            document.getElementById('agendasProgramadas').innerHTML = "";
        }
        else {
            document.getElementById('mensajito').innerHTML = "";
            $(document).ready(function () {
                agendasServicio()
                //CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO
            })
            function agendasServicio() { //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
                var randomnumber = Math.random() * 11;
                $.post("ConsultarAgendaServicio.php?fecha=" + fecha + "&sede=" + sede + "&servicio=" + servicio + "&usuario=" + usuario + "&HoraIni=" + HoraIni + "&HoraFin=" + HoraFin + "", {
                    randomnumber: randomnumber
                }, function (data) {
                    $("#agendasProgramadas").html(data);
                });
            }
        }
    }
    $(document).ready(function () {
        $('.timepicker').timepicker({
            hours: {starts: 0, ends: 23},
            minutes: {interval: 15},
            rows: 2,
            showPeriodLabels: true,
            minuteText: '&nbsp;&nbsp;Min',
            hourText: '&nbsp;&nbsp;Hora',
        })
    });
</script>
<style type="text/css">
    .asterisk {
        color: #F00;
    }
</style>
<body onBlur="agendasProgramadas()" onFocus="agendasProgramadas()">
<form name="VerAgenda" id="VerAgenda">
    <table width="100%">
        <tr>
            <td width="15%">Fecha :
                <br><input type="text" class="datepicker" name="fecha" value="<?php echo date("m/d/Y"); ?>"
                           onChange="agendasProgramadas()"><span class="asterisk">*</span></td>
            <td width="28%">Sede : <br>
                <label for="sede"></label>
                <select name="sede" id="sede" onChange="agendasProgramadas()">
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
            <td width="20%">Servicio : <br>
                <label for="servicio"></label>
                <select name="servicio" id="servicio" onChange="agendasProgramadas()">
                    <option value="">.: Seleccione :.</option>
                    <?php
                    while ($rowServicio = mysql_fetch_array($listaServicio)) {
                        echo '<option value="' . $rowServicio['idservicio'] . '">' . $rowServicio['descservicio'] . '</option>';
                    }
                    ?>
                </select>
                <span class="asterisk">*</span></td>
            <td width="15%">
                Desde / Hasta: <br>
                <label for="HoraIni"></label>
                <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>">
                <input type="text" name="HoraIni" class="timepicker" size="4" onChange="agendasProgramadas()">-<input
                    type="text" name="HoraFin" class="timepicker" size="4" onChange="agendasProgramadas()"><span
                    class="asterisk">*</span></td>
            <td>
                <div id="mensajito"></div>
            </td>
        </tr>
    </table>
    <table width="100%" border="0">
        <tr>
            <td>
                <div id="agendasProgramadas"></div>
            </td>
        </tr>
    </table>
</form>
</body>