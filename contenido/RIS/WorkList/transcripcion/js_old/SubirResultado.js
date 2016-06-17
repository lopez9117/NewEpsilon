/**
 * Created by Cristian Sierra on 25/06/2015.
 */

function habilitarinputs(id) {
    if ($('#check' + id).is(':checked')) {
        $('#input' + id).prop('disabled', false);
        $('#input' + id).val(1);
    } else {
        $('#input' + id).prop('disabled', true);
        $('#input' + id).val('');
    }
}

function validateguias(habilitar, deshabilitar) {
    if ($('#' + habilitar).is(':checked')) {
        $('#' + deshabilitar).prop('checked', false);
        $('#select' + habilitar).show();
        $('#select' + deshabilitar).hide();
        $('#sel' + deshabilitar).val('0');
        $('#sel' + habilitar).val('0');
    } else if (!$('#' + habilitar).is(':checked')) {
        $('#' + habilitar).val('0');
        $('#select' + habilitar).hide();
        $('#' + deshabilitar).val('0');
        $('#select' + deshabilitar).hide();
    }

}

function Cargar(informe, especialista) {
    var informe, especialista;
    //Codigo ajax para enviar datos al servidor y obtener respuesta
    //etiqueta donde se va a mostrar la respuesta
    ajax = nuevoAjax();
    //llamado al archivo que va a ejecutar la consulta ajax
    ajax.open("POST", "RegistroVentana.php", true);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send("informe=" + informe + "&especialista=" + especialista + "&tiempo=" + new Date().getTime());
}

document.write('<style type="text/css">div.cp_oculta{display: none;}</style>');
function MostrarOcultar(capa, enlace) {
    if (document.getElementById) {
        var aux = document.getElementById(capa).style;
        aux.display = aux.display ? "" : "block";
    }
}

function Guardar(opcion) {

    var insumos = '';
    var cantidades = '';
    var con = 0;
    var guiaeco, guiatac, i;
    i = 0;
    guiaeco = '';
    guiatac = '';
    var contador = $('#contador').val();

    var mensaje;

    if ($('#guiaecografica').is(':checked')) {
        guiaeco = $('#guiaecografica').val();
        $('#guias').val(guiaeco);
        $('#eco_biopsia').val($('#selguiaecografica').val());
    }
    else if ($('#guiatomografica').is(':checked')) {
        guiatac = $('#guiatomografica').val();
        $('#guias').val(guiatac);
        $('#eco_biopsia').val($('#selguiatomografica').val());
    }
    if ($('#bilateral').is(':checked')) {
        $('#biopsiabilateral').val($('#bilateral').val());
    }

    $("input[type=checkbox]:checked").each(function () {
        //cada elemento seleccionado
        var identificador = $(this).attr('id');
        var sub = identificador.substr(0, 5);
        if (sub == 'check') {
            id = $(this).val();
            if (con == 0) {
                insumos = insumos + $(this).val();
                cantidades = cantidades + $('#input' + id).val();
                mensaje = sub;
            } else {
                insumos = insumos + '-' + $(this).val();
                cantidades = cantidades + '-' + $('#input' + id).val();
            }
            con = con + 1;
        }
    });

    while (i != contador) {
        var insumocompleto = $('#buscarinsumos' + i).val();
        var cantidad = $('#cantidad' + i).val();
        if (insumocompleto != null && insumocompleto != "") {
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
    var hiddenservicio = document.Informe.hiddenservicio.value;
    var bolean = true;
   // if ((hiddenservicio == 7) && (insumos == '' || (guiatac == '' && guiaeco == ''))) {
     //   bolean = false;
   // }
 //   else if (hiddenservicio != 7) {
        //bolean = true;
   // }
    if (bolean) {
        if (opcion == "parcial") {
            document.Informe.opcion.value = "parcial";
            document.Informe.submit();
//                    return window.opener.CargarAgenda();
        }
        else {
            document.Informe.opcion.value = "finalizar";
            mensaje = confirm("El informe se publicara  y no estara disponible para editarlo nuevamente, desea publicar el informe?");
            if (mensaje == true) {
                document.Informe.submit();
//                        return window.opener.CargarAgenda();
            }
        }
    } else {
        if (hiddenservicio == 7 && guiaeco == '' && guiatac == '') {
            alert('Debe ingresar el tipo de guia');
        } else if (hiddenservicio == 7 && insumos == '') {
            alert('Recuerde seleccionar los Insumos que se utilizaron durante el Procedimiento');
        }
    }

}
//
function buscarInsumos() {
    var sede, servicio;
    sede = $('#idsede').val();
    servicio = $('#idservicio').val();
    $(function () {
        $('#buscarinsumos0').autocomplete({
            source: 'QueryInsumos/buscadorInsumos.php?sede=' + sede + '&servicio=' + servicio + '',
            select: function (event, ui) {
                $('#resultados').slideUp('slow', function () {
                });
                $('#resultados').slideDown('slow');
            }
        });
    });
}
buscar = function (evt) {
    evt = evento(evt);
    var input = rObj(evt);
    var idinput = input.id;
    var sede, servicio;
    sede = $('#idsede').val();
    servicio = $('#idservicio').val();
    $(function () {
        $('#' + idinput).autocomplete({
            source: 'QueryInsumos/buscadorInsumos.php?sede=' + sede + '&servicio=' + servicio + '',
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

var numero = 1;
function Clonar() {
//Creamos un DIv pa1ra generar el array

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

    numero = numero + 1;
    $('#contador').val(numero);
}