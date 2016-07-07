// JavaScript Funciones en formulario de registro de pacientes RIS
//Ocultar campos de texto opcionales
//function muestra_oculta(id) {
//    if (document.getElementById) { //se obtiene el id
//        var el = document.getElementById('contacto'); //se define la variable "el" igual a nuestro div
//        el.style.display = (el.style.display == 'none') ? 'block' : 'none'; //damos un atributo display:none que oculta el div
//    }
//}
//window.onload = function () {/*hace que se cargue la función lo que predetermina que div estará oculto hasta llamar a la función nuevamente*/
//    muestra_oculta('contacto');
//    /* "contenido_a_mostrar" es el nombre que le dimos al DIV */
//}

//funcion para validar el agendamiento
function ValidarAgenda() {

    var tipo_documento, edad, ubicacion, ndocumento, pnombre, papellido, fechanacimiento, genero, norden, sede, servicio, estudio, tecnica, extremidad, tipopaciente, prioridad, fechasolicitud, horasolicitud, fechacita, horacita, eps, tipo_afiliacion, fechanacimiento, erp, realizacion;
    tipo_afiliacion = document.nuevo_informe.tipo_afiliacion.value;
    ndocumento = document.nuevo_informe.ndocumento.value;
    pnombre = document.nuevo_informe.pnombre.value;
    papellido = document.nuevo_informe.papellido.value;
    edad = document.nuevo_informe.edad.value;
    genero = document.nuevo_informe.genero.value;
    norden = document.nuevo_informe.norden.value;
    sede = document.nuevo_informe.sede.value;
    servicio = document.nuevo_informe.servicio.value;
    estudio = document.nuevo_informe.estudio.value;
    tecnica = document.nuevo_informe.tecnica.value;
    extremidad = document.nuevo_informe.lado.value;
    tipopaciente = document.nuevo_informe.tipopaciente.value;
    prioridad = document.nuevo_informe.prioridad.value;
    fechasolicitud = document.nuevo_informe.fechasolicitud.value;
    horasolicitud = document.nuevo_informe.horasolicitud.value;
    fechacita = document.nuevo_informe.fechacita.value;
    horacita = document.nuevo_informe.horacita.value;
    fechapreparacion = document.nuevo_informe.fechapreparacion.value;
    horapreparacion = document.nuevo_informe.horapreparacion.value;
    ubicacion = document.nuevo_informe.ubicacion.value;
    //eps = document.nuevo_informe.VistaEps.value;
    erp = document.nuevo_informe.erp.value;
    realizacion = document.nuevo_informe.realizacion.value;
    fechanacimiento = document.nuevo_informe.fecha_nacimiento.value;
    tipopaciente = document.nuevo_informe.tipopaciente.value;
    dep = document.nuevo_informe.dep.value;
    mun = document.nuevo_informe.mun.value;
    barrio = document.nuevo_informe.barrio.value;
    direccion = document.nuevo_informe.direccion.value;
    tel = document.nuevo_informe.tel.value;
    guia = $('#guiaselected').val();
    ideps = $('#ideps').val();
    if (fechapreparacion == "" || horapreparacion == "" && sede == 3 && tecnica == 3) {
        mensaje = '<font size="2" color="#FF0000">Los campos señalados con * son obligatorios</font>';
        //etiqueta donde voy a mostrar la respuesta
        document.getElementById('resultado').innerHTML = mensaje;
    }
    else if (ndocumento == "" || pnombre == "" || papellido == "" || genero == "" || norden == "" || sede == "" || servicio == "" || estudio == "" || tecnica == "" || extremidad == "" || tipopaciente == "" || prioridad == "" || fechasolicitud == "" || horasolicitud == "" || fechacita == "" || horacita == "" || ubicacion == "" || ideps == "" || erp == "" || realizacion == "" || tipo_afiliacion == "" || fechanacimiento == "") {
        mensaje = '<font size="2" color="#FF0000">Los campos señalados con * son obligatorios</font>';
        //etiqueta donde voy a mostrar la respuesta
        document.getElementById('resultado').innerHTML = mensaje;
    } else if (servicio == 7 && guia == "") {
        mensaje = '<font size="2" color="#FF0000">El campo guia es Obligatorio </font>';//5167260 ext 2033
        //etiqueta donde voy a mostrar la respuesta
        document.getElementById('resultado').innerHTML = mensaje;
    }
    else {
        //if (tipopaciente == '2') {
        //if (dep == "0" || mun == "0" || barrio == "" || direccion == "") {
        //  mensaje = '<font size="2" color="#FF0000">Los campos señalados con * son obligatorios</font>';
        //etiqueta donde voy a mostrar la respuesta
        //document.getElementById('resultado').innerHTML = mensaje;
        //}
        //else {
        //  document.nuevo_informe.submit();
        //}
        //}
        //else {
        document.nuevo_informe.submit();
        //}
    }
}

//calendario Jquery
$(function () {
    $("#fecha_nacimiento").datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        yearRange: '-120:+0'
    });
});
//
$(function () {
    $("#datepicker").datepicker({maxDate: 0, dateFormat: 'dd/mm/yy'});
    $("#datepicker1").datepicker({maxDate: 0, dateFormat: 'dd/mm/yy'});
});
///Calendario con restriccion de meses y dias anteriores Jquery
$(function () {
    $("#datepicker2").datepicker({minDate: 0, maxDate: "+8M", dateFormat: 'dd/mm/yy'});
    $("#datepicker21").datepicker({minDate: 0, maxDate: "+8M", dateFormat: 'dd/mm/yy'});
});
$(function () {
    $("#datepicker3").datepicker({minDate: 0, maxDate: "+8M", dateFormat: 'dd/mm/yy'});
    $("#datepicker31").datepicker({minDate: 0, maxDate: "+8M", dateFormat: 'dd/mm/yy'});
});

jQuery(function ($) {
    $("#hora").mask("99:99");
    $("#hora1").mask("99:99");
    $("#hora2").mask("99:99");
    $("#hora21").mask("99:99");
    $("#hora3").mask("99:99");
    $("#hora31").mask("99:99");
    $("#fecha_nacimiento").mask("99/99/9999");
});
//Buscar EPS por coincidencia
function BuscarEps() {
    $(function () {
        $('#VistaEps').autocomplete({
            source: 'QueryEPS/buscadorEPS.php',
            select: function (event, ui) {
                $('#resultados').slideUp('slow', function () {
                });
                $('#resultados').slideDown('slow');
            }
        });
    });
}
//validar y obtener codigos de la EPS para la agenda
function ValidarEps() {
    var VistaEps;
    VistaEps = document.nuevo_informe.VistaEps.value;
    //Codigo ajax para enviar datos al servidor y obtener respuesta
    ResultadoEps = document.getElementById('ResultadoEps');//etiqueta donde se va a mostrar la respuesta
    ajax = nuevoAjax();
    //llamado al archivo que va a ejecutar la consulta ajax
    ajax.open("POST", "QueryEPS/CodigoEps.php", true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            ResultadoEps.innerHTML = ajax.responseText;
        }
    }
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send("VistaEps=" + VistaEps + "&tiempo=" + new Date().getTime());
//	codeqr();
}
//buscador de estudios por coincidencia y/o codigo CUPS
function buscarCups(servicio, sede, identificador) {
    var id = '';
    if (identificador != undefined) {
        id = identificador;
    }
    $(function () {
        $('#Vistaestudio' + id).autocomplete({
            source: 'QueryCups/buscadorCups.php?servicio=' + servicio + '&sede=' + sede + '',
            select: function (event, ui) {
                $('#resultados').slideUp('slow', function () {
                });
                $('#resultados').slideDown('slow');
            }
        });
    });
}

//Buscar adicionales
//buscador de estudios por coincidencia y/o codigo CUPS
function BuscarAdicional() {
    $(function () {
        $('#adicional').autocomplete({
            source: 'QueryAdicional/buscadorAdicional.php',
            select: function (event, ui) {
                $('#resultados').slideUp('slow', function () {
                });
                $('#resultados').slideDown('slow');
            }
        });
    });
}
//Buscar Extremidad
function BuscarExtremidad() {
    $(function () {
        $('#Extremidad').autocomplete({
            source: 'QueryExtremidad/buscadorExtremidad.php',
            select: function (event, ui) {
                $('#resultados').slideUp('slow', function () {
                });
                $('#resultados').slideDown('slow');
            }
        });
    });
}
// asosciar estudios con servicios seleccionados
// ++++++++++++++++++++++++++++++++++++++++++++++
function MostrarEstudios(identificador) {
    var id = '';
    if (identificador != undefined) {
        id = identificador;
    }
    var servicio, sede, erp;
    servicio = $('#servicio' + id).val();
    erp = $('#erp' + id).val();
    sede = $('#sede' + id).val();
    if (servicio == 1) {
        document.getElementById('showcomparativa' + id).style.display = "block";
        document.getElementById('showproyeccion' + id).style.display = "block";
        document.getElementById('descripcion_extremidad' + id).style.display = "none";
        $('#Extremidad' + id).val('');
    } else {
        document.getElementById('showcomparativa' + id).style.display = "none";
        $('#comparativa' + id).prop('checked', false);
        document.getElementById('showproyeccion' + id).style.display = "none";
        $('#proyeccionesrx' + id).val('0');
        document.getElementById('descripcion_extremidad' + id).style.display = "block";
    }
    if (servicio == 1 || servicio == 3 || servicio == 51 || servicio == 9 || servicio == 20 || servicio == 53 || servicio == 7) {
        document.getElementById('tecnicaestudio' + id).style.display = "none";
    }
    else {
        document.getElementById('tecnicaestudio' + id).style.display = "block";
        if (erp == 38) {
            $('#tecnica').children('option[value="4"]').show();
        } else {
            $('#tecnica').children('option[value="4"]').hide();
        }
    }
    if (servicio == 2) {
        document.getElementById('showreconstruccion' + id).style.display = "block";
    } else {
        document.getElementById('showreconstruccion' + id).style.display = "none";
        $('#reconstruccion' + id).prop('checked', false);
    }
    if (servicio == 7) {
        $('#showguia' + id).show();
    } else {
        $('#showguia' + id).hide();
    }

    $('#estudio' + id + 'view').val("");
    $('#estudio' + id).val("");

    //Codigo ajax para enviar datos al servidor y obtener respuesta
    peticionajaxestudio(id, servicio, sede, '');

}
// ++++++++++++++++++++++++++++++++++++++++++++++PETICION AJAX ESTUDIO
function peticionajaxestudio(id, servicio, sede, idestudio) {
    Estudios = document.getElementById('estudio' + id);//etiqueta donde se va a mostrar la respuesta
    ajax = nuevoAjax();
    //llamado al archivo que va a ejecutar la consulta ajax
    ajax.open("POST", "QueryEstudios/SelectEstudios.php", true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            Estudios.innerHTML = ajax.responseText;
        }
    }
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send("servicio=" + servicio + "&sede=" + sede + "&id=" + id + "&idestudio=" + idestudio + "&tiempo=" + new Date().getTime());
    $("#estudio" + id).combobox();
}
// ++++++++++++++++++++++++++++++++++++++++++++++
function ValEstudio(servicio, identificador) {
    var id = '';
    if (identificador != undefined) {
        id = identificador;
    }
    var Vistaestudio;
    Vistaestudio = $('#Vistaestudio' + id).val();
    //Codigo ajax para enviar datos al servidor y obtener respuesta
    selectServicio = document.getElementById('vistaidestudio' + id);//etiqueta donde se va a mostrar la respuesta
    ajax = nuevoAjax();
    //llamado al archivo que va a ejecutar la consulta ajax
    ajax.open("POST", "QueryEstudios/SelectServicio.php", true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            selectServicio.innerHTML = ajax.responseText;
            return validarlado(id);
        }
    }
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send("Vistaestudio=" + Vistaestudio + "&servicio=" + servicio + '&id=' + id + "&tiempo=" + new Date().getTime());

}
//validar lado
function validarlado(id) {
    estudio = document.getElementById('estudio' + id).value;
    var arrayestudios = [892, 1063, 1066, 1103, 1126, 1061, 1062, 970, 1099, 893, 969, 1058, 1065, 1055, 1097, 1061, 1054, 1056, 1057, 1060, 1059, 1052, 1069, 1100, 1101, 750, 879, 877, 1070];
    for (i = 0; i < arrayestudios.length; i++) {
        if (estudio == arrayestudios[i]) {
            document.getElementById('valilado' + id).style.display = "block";
            i = arrayestudios.length;
        }
        else {
            document.getElementById('valilado' + id).style.display = "none";
        }
    }

}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

// ++++++++++++++++++++++ validarf tipo de paciente ////
function Validartipopaciente() {
    idpaciente = document.nuevo_informe.ndocumento.value;
    tipopaciente = document.nuevo_informe.tipopaciente.value;
    if (tipopaciente == 2) {
        $('#validar_departamento').show();
        $('#validar_municipio').show();
        $('#validar_barrio').show();
        $('#validar_direccion').show();
        $('#validar_telefono').show();
    } else {
        $('#validar_departamento').hide();
        $('#validar_municipio').hide();
        $('#validar_barrio').hide();
        $('#validar_direccion').hide();
        $('#validar_telefono').hide();
    }
    //Codigo ajax para enviar datos al servidor y obtener respuesta
    //ValTipopaciente = document.getElementById('Contacto');//etiqueta donde se va a mostrar la respuesta
    //ajax = nuevoAjax();
    ////llamado al archivo que va a ejecutar la consulta ajax
    //ajax.open("POST", "QueryTipoPaciente/TipoPaciente.php", true);
    //ajax.onreadystatechange = function () {
    //    if (ajax.readyState == 4) {
    //        ValTipopaciente.innerHTML = ajax.responseText;
    //    }
    //}
    //ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    //ajax.send("tipopaciente=" + tipopaciente + "&idpaciente=" + idpaciente + "&tiempo=" + new Date().getTime());
}
// +++++++++++++++++++++++++++++++++++++++++++++++++++++
function CargarForm() {
    var tipo, formulario;
    formulario = document.nuevo_informe;
    //Codigo ajax para enviar datos al servidor y obtener respuesta
    formulario = document.nuevo_informe;
    //Codigo ajax para enviar datos al servidor y obtener respuesta
    tipo = document.getElementById('tipo1').value;//etiqueta donde se va a mostrar la respuesta
    MotivoCancelacion = document.nuevo_informe.MotivoCancelacion.disabled = true;
    cancelar = document.nuevo_informe.cancelar.disabled = true;
    norden = document.nuevo_informe.norden.disabled = false;
    sede = document.nuevo_informe.sede.disabled = false;
    servicio = document.nuevo_informe.servicio.disabled = false;
    estudio = document.nuevo_informe.Vistaestudio.disabled = false;
    tecnica = document.nuevo_informe.tecnica.disabled = false;
    extremidad = document.nuevo_informe.lado.disabled = false;
    tipopaciente = document.nuevo_informe.tipopaciente.disabled = false;
    prioridad = document.nuevo_informe.prioridad.disabled = false;
    fechasolicitud = document.nuevo_informe.fechasolicitud.disabled = false;
    horasolicitud = document.nuevo_informe.horasolicitud.disabled = false;
    fechacita = document.nuevo_informe.fechacita.disabled = false;
    horacita = document.nuevo_informe.horacita.disabled = false;
    ubicacion = document.nuevo_informe.ubicacion.disabled = false;
    Extremidad = document.nuevo_informe.Extremidad.disabled = false;
    adicion = document.getElementById('adicional').disabled = false;
    archivo = document.getElementById('archivos').style.display = 'block';
    portatil = document.getElementById('portatil').disabled = false;
    medsolicita = document.getElementById('medsolicita').disabled = false;
    cancelar = document.getElementById('cancelar').style.display = 'none';
    motivo_cancel = document.getElementById('motivo_cancel').style.display = 'block';
}
function CargarForm1() {
    var tipo, formulario;
    formulario = document.nuevo_informe;
    //Codigo ajax para enviar datos al servidor y obtener respuesta
    tipo = document.getElementById('tipo1').value;//etiqueta donde se va a mostrar la respuesta
    MotivoCancelacion = document.nuevo_informe.MotivoCancelacion.disabled = false;
    norden = document.nuevo_informe.norden.disabled = true;
    sede = document.nuevo_informe.sede.disabled = true;
    servicio = document.nuevo_informe.servicio.disabled = true;
    estudio = document.nuevo_informe.Vistaestudio.disabled = true;
    tecnica = document.nuevo_informe.tecnica.disabled = true;
    extremidad = document.nuevo_informe.lado.disabled = true;
    tipopaciente = document.nuevo_informe.tipopaciente.disabled = true;
    prioridad = document.nuevo_informe.prioridad.disabled = true;
    fechasolicitud = document.nuevo_informe.fechasolicitud.disabled = true;
    horasolicitud = document.nuevo_informe.horasolicitud.disabled = true;
    fechacita = document.nuevo_informe.fechacita.disabled = true;
    horacita = document.nuevo_informe.horacita.disabled = true;
    ubicacion = document.nuevo_informe.ubicacion.disabled = true;
    Extremidad = document.nuevo_informe.Extremidad.disabled = true;
    adicion = document.nuevo_informe.adicional.disabled = true;
    archivo = document.getElementById('archivos').style.display = 'none';
    portatil = document.nuevo_informe.portatil.disabled = true;
    medsolicita = document.getElementById('medsolicita').disabled = true;
    motivo_cancel = document.getElementById('motivo_cancel').style.display = 'none';
    cancelar = document.getElementById('cancelar').style.display = 'block';
    cancelar = document.getElementById('cancelar').disabled = false;
    guardar = document.nuevo_informe.guardar.style.display = 'none';

}
//funcion para validar la cita
function ValidarCita(identificador) {
    var idpaciente, servicio, fecha, hora, idsede, formulario, erp;
    //obtencion del grupo de empleados
    formulario = document.nuevo_informe;
    idpaciente = formulario.ndocumento.value;
    servicio = formulario.servicio.value;
    fecha = formulario.fechacita.value;
    idsede = formulario.sede.value;
    erp = formulario.erp.value;
    hora = formulario.horacita.value;
    //Codigo ajax para enviar datos al servidor y obtener respuesta
    munbar = document.getElementById('ValCita');//etiqueta donde se va a mostrar la respuesta
    ajax = nuevoAjax();
    //llamado al archivo que va a ejecutar la consulta ajax
    ajax.open("POST", "QueryValidarCita/ValidarCita.php", true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            munbar.innerHTML = ajax.responseText;
        }
    }
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send("idpaciente=" + idpaciente + "&servicio=" + servicio + "&fecha=" + fecha + "&idsede=" + idsede + "&hora=" + hora + "&tiempo=" + new Date().getTime());
}
//Funcion para mostrar listado de estudios del paciente durante una fecha
function MostrarCitas() {
    var idpaciente, fecha, formulario;
    //obtencion del grupo de empleados
    formulario = document.nuevo_informe;
    idpaciente = formulario.ndocumento.value;
    fecha = formulario.fechacita.value;
    //Codigo ajax para enviar datos al servidor y obtener respuesta
    MosCita = document.getElementById('MosCita');//etiqueta donde se va a mostrar la respuesta
    ajax = nuevoAjax();
    //llamado al archivo que va a ejecutar la consulta ajax
    ajax.open("POST", "QueryValidarCita/MostrarCitas.php", true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            if (ajax.responseText != "") {
                MosCita.innerHTML = ajax.responseText;
                $("#MosCita").dialog("open");
            }
        }
    }
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send("idpaciente=" + idpaciente + "&fecha=" + fecha + "&tiempo=" + new Date().getTime());
}
//funcion para validar que no tenga el mismo servicio
function ValidarEstudio(identificador) {
    var id = identificador != undefined ? identificador : '';
    var idpaciente, servicio, fecha, hora, idsede, tecnica;
    //obtencion del grupo de empleados
    idpaciente = $('#ndocumento' + id).val();
    servicio = $('#servicio' + id).val();
    fecha = $('#datepicker2' + id).val();
    idsede = $('#sede' + id).val();
    hora = $('#hora2' + id).val();
    tecnica = $('#tecnica' + id).val();
    if (tecnica == 3 && idsede == 3) {
        $('#val_fecha_preparacion' + id).show();
        $('#val_hora_preparacion' + id).show();
    }
    else {
        $('#val_hora_preparacion' + id).hide();
        $('#val_fecha_preparacion' + id).hide();
    }
    if (tecnica == 3 || tecnica == 6) {
        //Codigo ajax para enviar datos al servidor y obtener respuesta
        Valestudio = document.getElementById('Valestudio' + id);//etiqueta donde se va a mostrar la respuesta
        ajax = nuevoAjax();
        //llamado al archivo que va a ejecutar la consulta ajax
        ajax.open("POST", "QueryValidarCita/consulta.php", true);
        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4) {
                Valestudio.innerHTML = ajax.responseText;
            }
        }
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.send("idpaciente=" + idpaciente + "&servicio=" + servicio + "&fecha=" + fecha + "&idsede=" + idsede + "&hora=" + hora + "&tecnica=" + tecnica + "&tiempo=" + new Date().getTime());
    }
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
var numero = 0; //Esta es una variable de control para mantener nombres
//diferentes de cada campo creado dinamicamente.
evento = function (evt) { //esta funcion nos devuelve el tipo de evento disparado
    return (!evt) ? event : evt;
}

//Aqui se hace lamagia... jejeje, esta funcion crea dinamicamente los nuevos campos file
addCampo = function () {
//Creamos un nuevo div para que contenga el nuevo campo
    nDiv = document.createElement('div');
//con esto se establece la clase de la div
    nDiv.className = 'archivo';
//este es el id de la div, aqui la utilidad de la variable numero
//nos permite darle un id unico
    nDiv.id = 'file' + (++numero);
//creamos el input para el formulario:
    nCampo = document.createElement('input');
//le damos un nombre, es importante que lo nombren como vector, pues todos los campos
//compartiran el nombre en un arreglo, asi es mas facil procesar posteriormente con php

    nCampo.name = 'archivos[]';
//Establecemos el tipo de campo
    nCampo.type = 'file';
//Ahora creamos un link para poder eliminar un campo que ya no deseemos
    a = document.createElement('a');
//El link debe tener el mismo nombre de la div padre, para efectos de localizarla y eliminarla
    a.name = nDiv.id;
//Este link no debe ir a ningun lado
    a.href = '#';
//Establecemos que dispare esta funcion en click
    a.onclick = elimCamp;
//Con esto ponemos el texto del link
    a.innerHTML = 'Eliminar';
//Bien es el momento de integrar lo que hemos creado al documento,
//primero usamos la función appendChild para adicionar el campo file nuevo
    nDiv.appendChild(nCampo);
//Adicionamos el Link
    nDiv.appendChild(a);
//Ahora si recuerdan, en el html hay una div cuyo id es 'adjuntos', bien
//con esta función obtenemos una referencia a ella para usar de nuevo appendChild
//y adicionar la div que hemos creado, la cual contiene el campo file con su link de eliminación:
    container = document.getElementById('adjuntos');
    container.appendChild(nDiv);
}
//con esta función eliminamos el campo cuyo link de eliminación sea presionado
elimCamp = function (evt) {
    evt = evento(evt);
    nCampo = rObj(evt);
    div = document.getElementById(nCampo.name);
    div.parentNode.removeChild(div);
}
//con esta función recuperamos una instancia del objeto que disparo el evento
rObj = function (evt) {
    return evt.srcElement ? evt.srcElement : evt.target;
}
// esta es la funcion para crear un div de la informacion del compañante y poder registrar varios dentro de la agenda.
function Clonar() {
//Creamos un DIv para generar el array
    nDiv = document.createElement('div');
    nDiv.className = 'Informacion';
    nDiv.id = 'text' + (++numero);
    //Creamos el texto del primer input Numero de documento
    t = document.createElement('t');
    t.name = nDiv.id;
    t.innerHTML = '<br>Documento';
    //Creamos el input del numero de documento
    nCampo = document.createElement('input');
    nCampo.name = 'Documento[]';
    nCampo.className = 'text';
    nCampo.type = 'text';
    //Creamos el texto para el segundo input Nombres
    c = document.createElement('c');
    c.name = nDiv.id;
    c.innerHTML = ' Nombres ';
    //Creamos el input del nombre
    nCampo2 = document.createElement('input');
    nCampo2.name = 'Nombres[]';
    nCampo2.className = 'text';
    nCampo2.type = 'text';
    //Creamos el texto para el Tercer input Apellidos
    f = document.createElement('f');
    f.name = nDiv.id;
    f.innerHTML = ' Apellidos ';
    //Creamos el input del Apellido
    nCampo3 = document.createElement('input');
    nCampo3.name = 'Apellidos[]';
    nCampo3.className = 'text';
    nCampo3.type = 'text';
    //Creamos el texto para el cuarto input Telefonos
    k = document.createElement('k');
    k.name = nDiv.id;
    k.innerHTML = ' Telefono ';
    //Creamos el input del Telefonos
    nCampo4 = document.createElement('input');
    nCampo4.name = 'Telefono[]';
    nCampo4.className = 'text';
    nCampo4.type = 'text';
    //Creamos el texto para el quinto input Parentezco
    l = document.createElement('l');
    l.name = nDiv.id;
    l.innerHTML = 'Parentezco ';
    //Creamos el input del Parentezco
    nCampo5 = document.createElement('input');
    nCampo5.name = 'Parentezco[]';
    nCampo5.className = 'text';
    nCampo5.type = 'text';
    //Creamos el input para eliminar los campos agregados
    a = document.createElement('input');
    a.type = 'button';
    a.name = nDiv.id;
    a.href = '#';
    a.onclick = elimCamp;
    a.value = 'Eliminar';
    //Agregamos uno a uno los campos agregados este es para el numero de documento
    nDiv.appendChild(t);
    nDiv.appendChild(nCampo);
    // campo para nombre
    nDiv.appendChild(c);
    nDiv.appendChild(nCampo2);
    // Campo para apellido
    nDiv.appendChild(f);
    nDiv.appendChild(nCampo3);
    // Campo para telefono
    nDiv.appendChild(k);
    nDiv.appendChild(nCampo4);
    // Campo parentezco
    nDiv.appendChild(l);
    nDiv.appendChild(nCampo5);
    // botono para eliminar
    nDiv.appendChild(a);
    container = document.getElementById('contenedor');
    container.appendChild(nDiv);
}
//validar edad del paciente
function calcularEdad() {
    var fecha = document.getElementById("fecha_nacimiento").value;

    // Si la fecha es correcta, calculamos la edad
    var values = fecha.split("/");
    var dia = values[0];
    var mes = values[1];
    var ano = values[2];
    var fechacompare = mes + '/' + dia + '/' + ano;
    var fechadate = new Date(fechacompare);
    var fechaactual = new Date();
    var anoactual = fechaactual.getFullYear();
    if (fecha == '__/__/____' || fecha == null) {
        document.getElementById('validarfechanacimiento').innerHTML = '<font size="2" color="#FF0000">La fecha de nacimiento no puede estar vacia</font>';
        $('#fecha_nacimiento').focus();
    }
    else if (dia > 31) {
        document.getElementById('validarfechanacimiento').innerHTML = '<font size="2" color="#FF0000">El dia no puede ser mayor a 31</font>';
        $('#fecha_nacimiento').val(null);
        $('#fecha_nacimiento').focus();

    }
    else if (mes > 12) {
        document.getElementById('validarfechanacimiento').innerHTML = '<font size="2" color="#FF0000">el mes no puede ser mayor a 12</font>';
        $('#fecha_nacimiento').val(null);
        $('#fecha_nacimiento').focus();
    }
    else if (ano > anoactual) {
        document.getElementById('validarfechanacimiento').innerHTML = '<font size="2" color="#FF0000">El año no puede ser mayor al actual</font>';
        $('#fecha_nacimiento').val(null);
        $('#fecha_nacimiento').focus();
    }
    else if (fechadate >= fechaactual) {
        document.getElementById('validarfechanacimiento').innerHTML = '<font size="2" color="#FF0000">La fecha de nacimiento no puede ser mayor al dia de hoy</font>';
        $('#fecha_nacimiento').val(null);
        $('#fecha_nacimiento').focus();
    }
    else {
        // cogemos los valores actuales
        var fecha_hoy = new Date();
        var ahora_ano = fecha_hoy.getYear();
        var ahora_mes = fecha_hoy.getMonth();
        var ahora_dia = fecha_hoy.getDate();

        // realizamos el calculo
        var edad = (ahora_ano + 1900) - ano;
        if (ahora_mes < (mes - 1)) {
            edad--;
        }
        if (((mes - 1) == ahora_mes) && (ahora_dia < dia)) {
            edad--;
        }
        if (edad > 1900) {
            edad -= 1900;
        }
        // calculamos los meses
        var meses = 0;
        if (ahora_mes > (mes - 1)) {
            meses = ahora_mes - (mes - 1);
        }
        if (ahora_mes < (mes - 1)) {
            meses = 12 - ((mes - 1) - ahora_mes);
        }
        if (ahora_mes == (mes - 1) && dia > ahora_dia) {
            meses = 11;
        }
        // calculamos los dias
        var dias = 0;
        if (ahora_dia > dia) {
            dias = ahora_dia - dia;
        }
        if (ahora_dia < dia) {
            ultimoDiaMes = new Date(ahora_ano, ahora_mes, 0);
            dias = ultimoDiaMes.getDate() - (dia - ahora_dia);
        }
        if (edad > 0) {
            document.getElementById('edad').value = edad;
            document.forms['nuevo_informe']['unidadedad2'].value = 'AÑO';
        }
        else if (meses > 0) {
            document.getElementById('edad').value = meses;
            document.forms['nuevo_informe']['unidadedad2'].value = 'MES';
        }
        else if (dias >= 0) {
            document.getElementById('edad').value = dias;
            $('#unidadedad2').val('DIA');
            //document.forms['nuevo_informe']['unidadedad2'].value = 'DIA';
        }
        document.getElementById('validarfechanacimiento').innerHTML = '';
    }
}

// Validar tipo de archivo a subir, solo se permiten archivos . PDF
function validartipoarchivo(evt) {
    var files = evt.target.files;
    count = files.length;
    contador = 0;
    for (i = 0; i < count; i++) {
        var input = files[i].type;
        if (input != "application/pdf") {
            contador = contador + 1;
        }
    }
    if (contador != 0) {
        alert('Solo se Admite Archivos .PDF');
        document.nuevo_informe.archivo.value = "";
    }

}

function AgregarEstudios() {
    $("#AgregarEstudio").dialog("open");
    $("#sede1").val($("#sede").val());
    $("#erp1").val($("#erp").val());
    $("#realizacion1").val($("#realizacion").val());
}
//document.getElementById('archivo').addEventListener('change', validartipoarchivo, false);

$(function () {
    $("#MosCita").dialog({
        autoOpen: false,
        modal: true,
        buttons: {
            "Cerrar": function () {
                $(this).dialog("close");
            }
        }
    });
    $("#AgregarEstudio").dialog({
        autoOpen: false,
        modal: true,
        buttons: {
            "Aceptar": function () {
                ParcialAjax('guardar', '', '');
            }
        }
    });
    $("#MosCita").dialog("option", "width", 1000);
    $("#MosCita").dialog("option", "height", 250);

    $("#AgregarEstudio").dialog("option", "width", 1300);
    $("#AgregarEstudio").dialog("option", "height", 390);
});


function ParcialAjax(opcion, doc, idest) {
    var ndocumento, sede, erp, realizacion, norden, servicio, estudio, proyecciones, comparativa, reconstruccion, tecnica,
        copago, lado, extremidad, adicional, portatil, anestesia, sedacion, fechasolicitud, horasolicitud, fechacita, horacita,
        fechapreparacion, horapreparacion, observaciones, guia;
    ndocumento = document.nuevo_informe.ndocumento.value;
    norden = $('#norden1').val();
    servicio = $('#servicio1').val();
    estudio = $('#estudio1').val();
    proyecciones = $('#proyeccionesrx1').val();
    comparativa = $('#comparativa1').is(':checked') ? $('#comparativa1').val() : 0;
    reconstruccion = $('#reconstruccion1').is(':checked') ? $('#reconstruccion1').val() : 0;
    tecnica = $('#tecnica1').val();
    copago = $('#copago1').val();
    lado = $('#lado1').val();
    extremidad = $('#extremidad1').val();
    adicional = $('#adicional1').val();
    portatil = $('#portatil1').is(':checked') ? $('#portatil1').val() : 0;
    anestesia = $('#anestesia1').is(':checked') ? $('#anestesia1').val() : 0;
    sedacion = $('#sedacion1').is(':checked') ? $('#sedacion1').val() : 0;
    fechasolicitud = $('#datepicker1').val();
    fechasolicitud = convertdate(fechasolicitud);
    horasolicitud = $('#hora1').val();
    fechacita = $('#datepicker21').val();
    fechacita = convertdate(fechacita);
    horacita = $('#hora21').val();
    fechapreparacion = $('#datepicker31').val();
    fechapreparacion = convertdate(fechapreparacion);
    horapreparacion = $('#hora31').val();
    observaciones = $('#observaciones1').val();
    sede = $('#sede1').val();
    erp = $('#erp1').val();
    realizacion = $('#realizacion1').val();
    guia = $('#guiaselected1').val() != '' ? $('#guiaselected1').val() : 0;
    parciales = document.getElementById('parciales');//etiqueta donde se va a mostrar la respuesta
    ajax = nuevoAjax();

    if (opcion == 'guardar') {
        if (fechapreparacion == "" || horapreparacion == "" && sede == 3 && tecnica == 3) {
            mensaje = '<font size="2" color="#FF0000">Los campos señalados con * son obligatorios</font>';
            //etiqueta donde voy a mostrar la respuesta
            document.getElementById('resultado1').innerHTML = mensaje;
        }
        else if (ndocumento == "" || norden == "" || servicio == "" || estudio == "" || tecnica == "" || fechasolicitud == "" || horasolicitud == "" || fechacita == "" || horacita == "" || sede == "" || erp == "" || realizacion == "") {
            mensaje = '<font size="2" color="#FF0000">Los campos señalados con * son obligatorios</font>';
            //etiqueta donde voy a mostrar la respuesta
            document.getElementById('resultado1').innerHTML = mensaje;
        } else if (servicio == 7 && guia == 0) {
            mensaje = '<font size="2" color="#FF0000">La Guia es un Campo Obligatorio</font>';
            //etiqueta donde voy a mostrar la respuesta
            document.getElementById('resultado1').innerHTML = mensaje;
        }
        else {

            //llamado al archivo que va a ejecutar la consulta ajax
            ajax.open("POST", "QueryGuardarParcial/GuardarEstudioParcial.php", true);
            ajax.onreadystatechange = function () {
                if (ajax.readyState == 4) {

                    parciales.innerHTML = ajax.responseText;
                    $('#AgregarEstudio').dialog("close");
                    return limpiaForm();
                }
            }
            ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            ajax.send("idpaciente=" + ndocumento + "&orden=" + norden + "&servicio=" + servicio + "&estudio=" + estudio + "&proyecciones=" + proyecciones +
            "&comparativa=" + comparativa + "&reconstruccion=" + reconstruccion + "&tecnica=" + tecnica +
            "&copago=" + copago + "&lado=" + lado + "&extremidad=" + extremidad + "&adicional=" + adicional + "&portatil=" + portatil +
            "&anestesia=" + anestesia + "&sedacion=" + sedacion + "&fechasolicitud=" + fechasolicitud + "&horacolicitud=" + horasolicitud +
            "&fechacita=" + fechacita + "&horacita=" + horacita + "&fechapreparacion=" + fechapreparacion + "&horapreparacion=" + horapreparacion + "&observaciones=" + observaciones + "&opcion=" + opcion +
            "&sede=" + sede + "&erp=" + erp + "&realizacion=" + realizacion + "&guia=" + guia + "&tiempo=" + new Date().getTime());
        }
    } else {

        //llamado al archivo que va a ejecutar la consulta ajax
        ajax.open("POST", "QueryGuardarParcial/GuardarEstudioParcial.php", true);
        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4) {
                parciales.innerHTML = ajax.responseText;
            }
        }
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.send("&opcion=" + opcion + "&doc=" + doc + "&idest=" + idest + "&tiempo=" + new Date().getTime());
    }
}

function convertdate(fecha) {
    array = fecha.split("/");

    fechareturn = array[2] + '-' + array[1] + '-' + array[0];

    return fechareturn;
}

//limpiar campos DIV
function limpiaForm() {
// recorremos todos los campos que tiene el formulario
    $(':input', '#AgregarEstudio').each(function () {
        var type = this.type;
        var id = this.id;
        var tag = this.tagName.toLowerCase();
//limpiamos los valores de los campos…
        if (type == 'text' || tag == 'textarea') {
            if (id == 'datepicker1' || id == 'datepicker31' || id == 'datepicker21') {
                this.value = this.value;

            } else if (id == 'copago1') {
                this.value = 0;
            } else {
                this.value = "";
            }
        }
// excepto de los checkboxes y radios, le quitamos el checked
// pero su valor no debe ser cambiado
        else if (type == 'checkbox')
            this.checked = false;
// los selects le ponesmos el indice a -
        else if (tag == 'select')
            if (id == 'servicio1' || id == 'tecnica1' || id == 'lado1') {
                this.selectedIndex = 0;
            }
    });
}
//funcion para eliminar los adjuntos
function EliminarAdjunto(adjunto, id_informe) {
    var adjunto, id_informe;
    //Codigo ajax para enviar datos al servidor y obtener respuesta
    vista_adjuntos = document.getElementById('archivos_adjuntos');//etiqueta donde se va a mostrar la respuesta
    ajax = nuevoAjax();
    //llamado al archivo que va a ejecutar la consulta ajax
    ajax.open("POST", "AccionesAgenda/EliminarAdjuntos.php", true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            vista_adjuntos.innerHTML = ajax.responseText;
        }
    }
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send("adjunto=" + adjunto + "&id_informe=" + id_informe + "&tiempo=" + new Date().getTime());
}
// funcion para ver listados de eps por select
(function ($) {
    $.widget("custom.combobox", {
        _create: function () {
            this.wrapper = $("<span>")
                .addClass("custom-combobox")
                .insertAfter(this.element);


            this.element.hide();
            var id = this.element.attr('id');
            this._createAutocomplete(id);
            this._createasterisk();

            //this._createShowAllButton();
        },

        _createAutocomplete: function (id) {
            var selected = this.element.children(":selected"),
                value = selected.val() ? selected.text() : "";
            cadena = "<input id=" + id + 'view' + " style=\"width:90%;\">";

            this.input = $(cadena)
                .appendTo(this.wrapper)
                .val(value)
                .attr("title", "")
                //.addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left")
                .autocomplete({
                    delay: 0,
                    minLength: 0,
                    source: $.proxy(this, "_source")
                })
                .tooltip({
                    tooltipClass: "ui-state-highlight"
                });
            this._on(this.input, {
                autocompleteselect: function (event, ui) {
                    ui.item.option.selected = true;
                    this._trigger("select", event, {
                        item: ui.item.option
                    });
                },

                autocompletechange: "_removeIfInvalid"
            });
        },

        _createasterisk: function () {

            this.asterisk = $("<span class='asterisk'>*</span>")
                .appendTo(this.wrapper)

        },

        _source: function (request, response) {
            var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
            response(this.element.children("option").map(function () {
                var text = $(this).text();
                if (this.value && ( !request.term || matcher.test(text) ))
                    return {
                        label: text,
                        value: text,
                        option: this
                    };
            }));
        },

        _removeIfInvalid: function (event, ui) {

            // Selected an item, nothing to do
            if (ui.item) {
                return;
            }

            // Search for a match (case-insensitive)
            var value = this.input.val(),
                valueLowerCase = value.toLowerCase(),
                valid = false;
            this.element.children("option").each(function () {
                if ($(this).text().toLowerCase() === valueLowerCase) {
                    this.selected = valid = true;
                    return false;
                }
            });

            // Found a match, nothing to do
            if (valid) {
                return;
            }

            // Remove invalid value
            this.input
                .val("")
                .attr("title", value + ". No existe dentro del Sistema RIS")
                .tooltip("open");
            this.element.val("");
            this._delay(function () {
                this.input.tooltip("close").attr("title", "");
            }, 2500);
            this.input.autocomplete("instance").term = "";
        },

        _destroy: function () {
            this.wrapper.remove();
            this.element.show();
        }
    });
})(jQuery);
$(function () {
    $("#ideps").combobox();
});


$(document).ready(function () {

});
function validateradio(identificador) {
    var id = '';
    if (identificador != undefined) {
        id = identificador;
    }
    $('#guiaselected' + id).val($('[name=guia' + id + ']:checked').val());
}
//funcion para crear el adjunto desde el GHIPS
function SubirAdjunto(adjunto) {
    var adjunto;
    //Codigo ajax para enviar datos al servidor y obtener respuesta
    vista_orden = document.getElementById('vista_orden');//etiqueta donde se va a mostrar la respuesta
    ajax = nuevoAjax();
    //llamado al archivo que va a ejecutar la consulta ajax
    ajax.open("POST", "Crearpdf/OrdenPdf.php", true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            vista_orden.innerHTML = ajax.responseText;
        }
    }
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send("adjunto=" + adjunto + "&tiempo=" + new Date().getTime());
}
