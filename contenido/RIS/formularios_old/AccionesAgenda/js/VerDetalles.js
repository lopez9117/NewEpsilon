function HoraActual() {
    var esteMomento = new Date();
    var hora = esteMomento.getHours();
    if (hora < 10) hora = '0' + hora;
    var minuto = esteMomento.getMinutes();
    if (minuto < 10) minuto = '0' + minuto;
    var segundo = esteMomento.getSeconds();
    if (segundo < 10) segundo = '0' + segundo;
    HoraCompleta = hora + " : " + minuto + " : " + segundo;
    document.getElementById('contenedor_reloj').innerHTML = HoraCompleta;
}
/**
 * Created by Cristian Sierra on 14/08/2015.
 */
function horallega() {
    var hora, formulario;
    formulario = document.observacion;
    formulario = document.observacion;
    usuario = formulario.usuario.value;
    idforme = formulario.informe.value;
    horallegada = formulario.horallegada.value;
    contenedor_reloj = document.getElementById('contenedor_reloj').style.display = 'block';
    ajax = nuevoAjax();
//llamado al archivo que va a ejecutar la consulta ajax
    ajax.open("POST", "horallegada.php", true);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            selectServicio.innerHTML = ajax.responseText;
        }
    }
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send("usuario=" + usuario + "&idforme=" + idforme + "&horallegada=" + horallegada + "&tiempo=" + new Date().getTime());
}

function enviarObservacion() {
    //declarar variables
    usuario = document.observacion.usuario.value;
    informe = document.observacion.informe.value;
    observacion = document.observacion.observacion.value;
    //validar campos obligatorios
    if (observacion == "") {
        mensaje = "<font color='#FF0000'><strong>Por favor escriba su observación y/o comentario</strong></font>";
        document.getElementById('respuesta').innerHTML = mensaje;
    }
    else {
        mensaje = "";
        document.getElementById('respuesta').innerHTML = mensaje;

        document.observacion.submit();
    }
}


function eliminar(name) {
    //evt = evento(evt);
    //nCampo = rObj(evt);
    div = document.getElementById(name);
    div.parentNode.removeChild(div);
}
buscar = function (evt) {
    evt = evento(evt);
    var input = rObj(evt);
    var idinput = input.id;
    var sede, servicio;
    sede = $('#sede').val();
    servicio = $('#servicio').val();
    $(function () {
        $('#' + idinput).autocomplete({
            source: '../../WorkList/transcripcion/QueryInsumos/buscadorInsumos.php?sede=' + sede + '&servicio=' + servicio + '',
            select: function (event, ui) {
                $('#resultados').slideUp('slow', function () {
                });
                $('#resultados').slideDown('slow');
            }
        });
    });
}
evento = function (evt) { //esta funcion nos devuelve el tipo de evento disparado
    return (!evt) ? event : evt;
}
rObj = function (evt) {
    return evt.srcElement ? evt.srcElement : evt.target;
}
elimCamp = function (evt) {
    evt = evento(evt);
    nCampo = rObj(evt);
    div = document.getElementById(nCampo.name);
    div.parentNode.removeChild(div);
}
function buscarInsumos() {
    var sede, servicio;
    sede = $('#sede').val();
    servicio = $('#servicio').val();
    $(function () {
        $('#buscarinsumos0').autocomplete({
            source: '../../WorkList/transcripcion/QueryInsumos/buscadorInsumos.php?sede=' + sede + '&servicio=' + servicio + '',
            select: function (event, ui) {
                $('#resultados').slideUp('slow', function () {
                });
                $('#resultados').slideDown('slow');
            }
        });
    });
}
function Clonar() {
//Creamos un DIv pa1ra generar el array

    var numero = $('#contador').val();

    rowDiv = document.createElement('div');
    rowDiv.id = 'row' + numero;

    nDiv = document.createElement('div');
    nDiv.className = 'col-lg-9 col-md-9 col-sm-9 col-xs-9 form-group';
    nDiv.id = 'in' + numero;

    mDiv = document.createElement('div');
    mDiv.className = 'col-lg-1 col-md-1 col-sm-1 col-xs-1 form-group';
    mDiv.id = 'can' + numero;

    eDiv = document.createElement('div');
    eDiv.className = 'col-lg-2 col-md-2 col-sm-2 col-xs-2 form-group';
    eDiv.id = 'el' + numero;

    //Creamos el input del numero de documento
    insumo = document.createElement('input');
    insumo.name = 'buscarinsumos[]';
    insumo.id = 'buscarinsumos' + numero;
    insumo.className = 'form-control';
    insumo.type = 'text';
    insumo.onfocus = buscar;

    //Creamos el input del nombre
    cantidad = document.createElement('input');
    cantidad.name = 'Cantidad[]';
    cantidad.id = 'cantidad' + numero;
    cantidad.value = "1";
    cantidad.className = 'form-control';
    cantidad.type = 'text';

    //Creamos el input para eliminar los campos agregados
    eliminar = document.createElement('input');
    eliminar.type = 'button';
    eliminar.className = 'btn btn-danger';
    eliminar.name = rowDiv.id;
    eliminar.href = '#';
    eliminar.onclick = elimCamp;
    eliminar.value = 'Eliminar';

    //Agregamos uno a uno los campos agregados este es para el numero de documento
    nDiv.appendChild(insumo);
    // campo para nombre
    mDiv.appendChild(cantidad);
    // botono para eliminar
    eDiv.appendChild(eliminar);

    rowDiv.appendChild(nDiv);
    rowDiv.appendChild(mDiv);
    rowDiv.appendChild(eDiv);

    container = document.getElementById('contenedor');
    container.appendChild(rowDiv);
    numero = parseInt(numero) + 1;
    $('#contador').val(numero);
}

function saveinsumos(servicio) {

    if (servicio == 5 || servicio == 8 || servicio == 23) {
        var contador = $('#contador').val();
        var insumos = '';
        var cantidades = '';
        var con = 0;
        var i = 0;
        while (i != contador) {
            var insumocompleto = $('#buscarinsumos' + i).val();
            var cantidad = $('#cantidad' + i).val();
            if (insumocompleto != undefined && insumocompleto != "" && cantidad != 0) {
                var str = insumocompleto.split("-", 1);
                if (con == 0) {
                    insumos += str[0].trim();
                    cantidades += cantidad.trim();
                } else {
                    insumos += '-' + str[0].trim();
                    cantidades += '-' + cantidad.trim();
                }
                con += 1;
            }
            i += 1;
        }
        $('#insumos').val(insumos);
        $('#cantidades').val(cantidades);
    }
}