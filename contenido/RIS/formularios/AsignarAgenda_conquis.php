<script>
function mostrarAgenda() {
    var fecha, sede, servicio, usuario, estado;
    fecha = document.agenda.fecha.value;
    sede = document.agenda.sede.value;
    servicio = document.agenda.servicio.value;
    usuario = document.agenda.usuario.value;
    estado = document.agenda.estado.value;

    if (fecha == "" || sede == "" || servicio == "" || estado == "") {
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
            $.post("lista_pacientes_conquis.php?fecha=" + fecha + "&sede=" + sede + "&servicio=" + servicio + "&usuario=" + usuario + "&estado=" + estado + "", {
                randomnumber: randomnumber
            }, function (data) {
                $("#agendas").html(data);
            });
        }
    }
}
function cancelarCita(idInforme, usuario) {
    var idInforme, usuario;
    opcion = confirm("Seguro que desea cancelar la cita?");
    if (opcion == true) {
        ajax = nuevoAjax();
        //llamado al archivo que va a ejecutar la consulta ajax
        ajax.open("POST", "AccionesAgenda/AccionCancelarCitaDefinitivo.php", true);
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.send("idInforme=" + idInforme + "&usuario=" + usuario + "&tiempo=" + new Date().getTime());

        return mostrarAgenda();
    }
    else {
        return mostrarAgenda();
    }
}
</script>
<form name="agenda" id="agenda">
    <table width="100%">
        <tr>
            <td width="15%">Fecha:<br><input type="text" id="datepicker" name="fecha"value="<?php echo date("m/d/Y"); ?>" onChange="mostrarAgenda()"><span class="asterisk">*</span></td>
            <td width="28%">Sede:<br><label for="sede"></label>
                <select name="sede" id="sede" onChange="mostrarAgenda()">
                    <option value="32">Clinica Conquistadores</option>
                    
                </select><span class="asterisk">*</span></td>
            <td width="20%">Servicio:<br>
                <select name="servicio" id="servicio" onChange="mostrarAgenda()">
                    <option value="1">RayosX</option>
                    
                </select><span class="asterisk">*</span>
                <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>">
            </td>
            <td width="15%">
                Estado:<br>
                <select name="estado" id="estado" onChange="mostrarAgenda()">
                    <option value="1">Agendados</option>
                   
                </select><span class="asterisk">*</span>
            </td>
            <td>
                <div id="notificacion"></div>
                <a href="../Videos/Agendamiento/Agendamiento.html">Ver Video Tutorial</a>
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
<?php mysql_close($cn); ?>