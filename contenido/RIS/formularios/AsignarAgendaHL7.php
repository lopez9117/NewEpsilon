<?php
require_once("../../../dbconexion/conexion.php");
$cn = conectarse();
include("../select/selects.php");

$Anio=date("Y");
$Mes=date("m");
$dias = date('t', mktime(0,0,0, $Mes, 1, $Anio));
$fecha_inicio=($Anio.'-'.$Mes.'-'.'01');
$fecha_limite=($Anio.'-'.$Mes.'-'.$dias);
list($AñO,$MES,$DIA)=explode("-",$fecha_inicio);
 $DESDE= $MES."/".$DIA."/".$AñO;
 list($AñO,$MES,$DIA)=explode("-",$fecha_limite);
 $HASTA= $MES."/".$DIA."/".$AñO;
?>
<script language="JavaScript" type="text/javascript" src="../javascript/ajax.js"></script>
<script language="JavaScript" src="../../../js/jquery.js"></script>
<script src="../../../js/jquery.form.js"></script>
<script language="JavaScript" src="../js/jquery-ui-1.10.0.custom.min.js"></script>
<script type="text/javascript" language="javascript" src="../javascript/jquery.dataTables.js"></script>
<link type="text/css" href="../styles/demo_table.css" rel="stylesheet"/>
<link type="text/css" href="../css/ui-lightness/jquery-ui-1.8.13.custom.css" rel="stylesheet"/>
<script>
    function mostrarAgenda() {
        var fecha, sede, servicio, usuario, estado;
		fechadesde = document.agenda.fechadesde.value;
		fechahasta = document.agenda.fechahasta.value;
        sede = document.agenda.sede.value;
        servicio = document.agenda.servicio.value;
        usuario = document.agenda.usuario.value;
//	estado = document.agenda.estado.value;

        if (sede == "" || servicio == "") {
            mensaje = "<font color='#FF0000'>Los campos marcados con * son obligatorios</font>";
            document.getElementById('notificacion').innerHTML = mensaje;
            document.getElementById('agendas').innerHTML = "";
        }
        else {
            document.getElementById('notificacion').innerHTML = "";
            $(document).ready(function () {
                verlistado()
                //CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO
            })
            function verlistado() { //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
                var randomnumber = Math.random() * 11;
                $.post("lista_pacientes_agendadosHL7.php?fechahasta=" + fechahasta + "&fechadesde=" + fechadesde + "&sede=" + sede + "&servicio=" + servicio + "&usuario=" + usuario + "", {
                    randomnumber: randomnumber
                }, function (data) {
                    $("#agendas").html(data);
                });
            }
        }
    }
</script>
<style type="text/css">
    .asterisk {
        color: #F00;
    }
</style>
<body onFocus="mostrarAgenda()">
<form name="agenda" id="agenda">
    <table width="100%">
        <tr>
            <td width="15%">Fecha Desde
                <br><input type="text" id="datepicker1" name="fechadesde" value="<?php
                echo $DESDE;
                ?>" onChange="mostrarAgenda()"><span class="asterisk">*</span></td>
            <td width="15%">Fecha Hasta
                <br><input type="text" id="datepicker" name="fechahasta" value="<?php
                echo $HASTA;
                ?>" onChange="mostrarAgenda()"><span class="asterisk">*</span></td>
            <td width="28%">Sede  <br>
                <label for="sede"></label>
                <select name="sede" id="sede" onChange="mostrarAgenda()">
                    <option value="">.: Seleccione :.</option>
                    <?php
                    while ($rowSede = mysql_fetch_array($listaSede)) {
                        ?>
                        <option value="<?php echo $rowSede['idsede'] ?>"
                            <?php if ($rowSede['idsede'] == $sede) {
                                echo 'selected';
                            } ?>><?php echo $rowSede['descsede'] ?></option>';
                        <?php
                    }
                    ?>
                </select><span class="asterisk">*</span></td>
            <td width="20%">Servicio  <br>
                <label for="servicio"></label>
                <select name="servicio" id="servicio" onChange="mostrarAgenda()">
                    <option value="">.: Seleccione :.</option>
                    <?php
                    while ($rowServicio = mysql_fetch_array($listaServicio)) {
                        echo '<option value="' . $rowServicio['idservicio'] . '">' . $rowServicio['descservicio'] . '</option>';
                    }
                    ?>
                </select>
      <span class="asterisk">*
      <label for="usuario"></label>
      <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>">
      </span></td>
            <td width="15%">
                <br>
                <span class="asterisk"></span></td>
            <td>
                <div id="notificacion"></div>
            </td>
        </tr>
    </table>
    <table width="100%" border="0">
        <tr>
            <td>
                <div id="agendas"></div>
            </td>
        </tr>
    </table>
</form>
</body>