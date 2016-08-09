/**
 * Created by Cristian Sierra on 26/08/2015.
 */
$(document).ready(function () {
        var servicio, portatil;
        servicio = $('#servicio').val();
        portatil = $('#portatil').val();
        if (servicio == 1) {
            $('#shownuevadosisbutton').show();
            $('#shownuevadosisinput').show();
            if (portatil == 1) {
                $('#showfoco').hide();
                $('#foco').val(0);
            }
            $('#tiempofluoroscopia').val(0);
            $('#show_r_innecesarias').show();
        } else if (servicio == 2) {
            $('#shownuevadosis').hide();
            $('#show_DLP').show();
            $('#show_r_innecesarias').show();
            $('#showma').hide();
            $('#MA').val(0);
            $('#showkv').hide();
            $('#kv').val(0);
            $('#showfoco').hide();
            $('#foco').val(0);
            $('#showdistancia').hide();
            $('#distancia').val(0);
            $('#calculator').show();
            $('#Dosis0').prop('readonly', false);
            $('#tiempofluoroscopia').val(0);
        } else if (servicio == 5 || servicio == 4 || servicio == 23) {

            $('#showma').hide();
            $('#MA').val(0);
            $('#showkv').hide();
            $('#kv').val(0);
            $('#showfoco').hide();
            $('#foco').val(0);
            $('#showdistancia').hide();
            $('#distancia').val(0);
            //$('#calculator').show();
            $('#showtiempo').show();
            $('#showtiempototal').show();
            $('#showbutton').show();
            $('#Dosis').prop('readonly', false);
        } else if (servicio == 10) {

            $('#showma').hide();
            $('#MA').val(0);
            $('#showkv').hide();
            $('#kv').val(0);
            $('#showfoco').hide();
            $('#foco').val(0);
            $('#showdistancia').hide();
            $('#distancia').val(0);
            $('#calculator').show();
            $('#showdosis').hide();
            $('#Dosis').val(0);
            $('#tiempofluoroscopia').val(0);
        }
    }
);
function Changedosis() {
    var dosis = $('#Dosis0').val();
    $('#Dosis').val(dosis);
}

function tomar() {

    MAS = document.estadistica.MAS.value;

    KV = document.estadistica.KV.value;

    i_dañadas = document.estadistica.i_dañadas.value;
    observacion = document.estadistica.observacion.value;
    lectura = document.estadistica.lectura.value;
    peso = document.estadistica.pesop.value;
   contrastereal = $('contrastereal').val();

    if( id_tecnica != 3 && contrastereal ==""){
        contrastereal = 0;
    }

    codiss = document.estadistica.codiss.value;
    espaciosadicionales = 0;
    id_tecnica = document.estadistica.id_tecnica.value;
    servicio = document.estadistica.servicio.value;
    distancia = $('#distancia').val();
    

    foco = $('#foco').val();

    portatil = $('#portatil').val();
    dosis = $('#Dosis').val();
    fluoroscopia = $('#tiempofluoroscopia').val();
    r_innecesarias = $('#r_innecesarias').val();
    DLP = $('#DLP').val();




    if (codiss == 213609) {
        espaciosadicionales = document.estadistica.adicionales.value;
    }
    if (servicio == 2 && (DLP == "" || r_innecesarias == "" || dosis == "")) {
        mensaje = '<font color="#FF0000">Por favor llene los datos necesarios para el registro de la realizacion del estudio</font>';
        document.getElementById('respuesta').innerHTML = mensaje;
    }
    else if (servicio == 1 && portatil == 0 && (MAS == "" || KV == "" || lectura == "" || distancia == "" || foco == "" || dosis == "" || r_innecesarias == "")) {
        mensaje = '<font color="#FF0000">Por favor llene los datos necesarios para el registro de la realizacion del estudio</font>';
        document.getElementById('respuesta').innerHTML = mensaje;
    }
    else if (servicio == 1 && portatil == 1 && (MAS == "" || KV == "" || lectura == "" || distancia == "" || dosis == "")) {
        mensaje = '<font color="#FF0000">Por favor llene los datos necesarios para el registro de la realizacion del estudio</font>';
        document.getElementById('respuesta').innerHTML = mensaje;

    }else if( id_tecnica == 3 && contrastereal==" " ){
         mensaje = '<font color="#FF0000">Por favor infrese medio de contraste con el valor requerido, si lo ingreso en el estudio anterior debe rellenar en 0</font>';
        document.getElementById('respuesta').innerHTML = mensaje;
    } else if ( id_tecnica == 3 && contrastereal > 0 && contrastereal < 10 ){
        mensaje = '<font color="#FF0000">Por favor ingrese la cantidad de contrate mayor a 30</font>';
        document.getElementById('respuesta').innerHTML = mensaje;
    }
    else if ((servicio == 5 || servicio == 4 || servicio == 23) && (fluoroscopia == 0 || fluoroscopia == "")) {
        alert(fluoroscopia);
        mensaje = '<font color="#FF0000">El campo Tiempo Fluoroscopia es un campo Obligatorio</font>';
        document.getElementById('respuesta').innerHTML = mensaje;
    }
    
    else {
        document.estadistica.submit();
        return window.opener.CargarAgenda();
    }
}
function validatemedicogeneral(check) {
    if (check == true) {
        document.getElementById('nombremedicogeneral').disabled = false;
    } else {
        document.getElementById('nombremedicogeneral').disabled = true;
    }
}

function validatecontraste() {
    peso = $('#pesop').val();
    contraste = $('#contrastereal').val();
    cont = 0;
    if (peso > 0) {
        contrasteutilizar = peso * 1.5;
        if (contraste > contrasteutilizar) {
            alert('La cantidad de contraste es muy alta, por favor explique el por que en el campo Observacion');
            mensaje = '<font color="#FF0000">La cantidad de contraste es muy alta, por favor explique el por que en el campo Observacion</font>';
            document.getElementById('respuesta').innerHTML = mensaje;
        }
    }
    else {
        alert('El peso del paciente debe ser mayor a 0');
        mensaje = '<font color="#FF0000">El peso del paciente debe ser mayor a 0</font>';
        document.getElementById('respuesta').innerHTML = mensaje;
        $('#pesop').focus();
    }
}

function calculatedose(ide) {
    var id = ide;
    if (ide == undefined) {
        id = '';
    }
    var portatil, foco, distancia, ma, kv, totaldose;
    portatil = $('#portatil').val() != '' ? parseFloat($('#portatil').val()) : '';
    foco = $('#foco' + id).val() != '' ? parseFloat($('#foco' + id).val()) : '';
    distancia = $('#distancia' + id).val() != '' ? parseFloat($('#distancia' + id).val()) : '';
    ma = $('#MAS' + id).val() != '' ? parseFloat($('#MAS' + id).val()) : '';
    kv = $('#KV' + id).val() != '' ? parseFloat($('#KV' + id).val()) : '';
    totaldose = 0;
    if (portatil == 0 && foco != '' && distancia != '' && ma != '' && kv != '') {
        distancia = (distancia * distancia);
        totaldose = (((((0.93 * kv) / 100) * foco) / (distancia)) / 60) * (ma / foco) * 0.96;
        totaldose = totaldose.toFixed(6);
        $('#Dosis' + id).val(totaldose);
    } else if (portatil == 1 && distancia != '' && ma != '' && kv != '') {
        totaldose = ((0.93 / 600) * kv * ma) / distancia;
        totaldose = totaldose.toFixed(6);
        $('#Dosis' + id).val(totaldose);
    }
    calculatetotaldose();
}

function calculatetotaldose() {
    var contador = $('#contador').val();
    con = 0;
    totaldose = 0;
    totalma = 0;
    totalkv = 0;
    totalfoco = 0;
    totaldistancia = 0;
    while (con != contador) {
        dose = $('#Dosis' + con).val();
        ma = $('#MAS' + con).val();
        kv = $('#KV' + con).val();
        distancia = $('#distancia' + con).val();
        foco = $('#foco' + con).val();
        if (dose == undefined || dose == '') {
            dose = 0;
        }
        if (ma == undefined || ma == '') {
            ma = 0;
        }
        if (kv == undefined || kv == '') {
            kv = 0;
        }
        if (distancia == undefined || distancia == '') {
            distancia = 0;
        }
        if (foco == undefined || foco == '') {
            foco = 0;
        }
        totaldose += parseFloat(dose);
        totalma += parseFloat(ma);
        totalkv += parseFloat(kv);
        totaldistancia += parseFloat(distancia);
        totalfoco += parseFloat(foco);
        con += 1;
    }
    $('#Dosis').val(parseFloat(totaldose).toFixed(6));
    $('#MAS').val(parseInt(totalma));
    $('#KV').val(parseInt(totalkv));
    $('#distancia').val(parseInt(totaldistancia));
    $('#foco').val(parseInt(totalfoco));


}

var nextinput = 1;
function AgregarCampos() {

    campo = '<input type="text" style="width:  3em" id="campo' + nextinput + '" name="campo' + nextinput + '" onblur="totaltiempofluoroscopia()" value="0" />&nbsp;';
    $("#showtiempo").append(campo);
    nextinput++;
}


function totaltiempofluoroscopia() {
    var totalinputs = parseInt(nextinput);
    var totalfluoroscopia = 0;
    var fluoroscopia = 0;
    var i = parseInt(0);
    while (i != totalinputs) {
        fluoroscopia = parseInt($('#campo' + i).val());
        if (fluoroscopia == '' || fluoroscopia == undefined) {
            fluoroscopia = 0;
        }
        totalfluoroscopia = parseInt(totalfluoroscopia) + parseInt(fluoroscopia);
        i += 1;
    }
    $('#tiempofluoroscopia').val(totalfluoroscopia);
    if (totalfluoroscopia > 20) {
        campo = '<span style="color: red">Alerta!!! El tiempo de fluoroscopia es superior al recomendado</span> ';
        $('#showerror').append(campo);
        $('#showerror').show();
    }
}
buscar = function (evt) {
    evt = evento(evt);
    var input = rObj(evt);
    var idinput = input.id;
    var sede, servicio;

}
var numero = 1;
function Clonar() {
//Creamos un DIv pa1ra generar el array

    var numero = $('#contador').val();

    var ma = '<br/><label for="distancia">MA:</label><br>' +
        '<input type="text" name="MAS' + numero + '" id="MAS' + numero + '" class="text" placeholder="MAS" onblur="calculatedose(' + numero + ')"/>' +
        '<span class="asterisk1">*</span>';
    var kv = '<br/><label for="distancia">KV:</label><br>' +
        '<input type="text" name="KV' + numero + '" id="KV' + numero + '" class="text" placeholder="KV" onblur="calculatedose(' + numero + ')"/>' +
        '<span class="asterisk1">*</span>';
    var distancia = '<br/><label for="distancia">Distancia:</label><br>' +
        '<input type="text" name="distancia' + numero + '" id="distancia' + numero + '" class="text" placeholder="Distancia" onblur="calculatedose(' + numero + ')"/>' +
        '<span class="asterisk1">*</span>';
    var foco = '<br/><label for="distancia">Foco:</label><br>' +
        '<input type="text" name="foco' + numero + '" id="foco' + numero + '" class="text" placeholder="Foco" onblur="calculatedose(' + numero + ')"/>' +
        '<span class="asterisk1">*</span>';
    var dosis = ' <br/><label for="Dosis">Total Dosis (mSv):</label><br/>' +
        '<input type="text" name="Dosis' + numero + '" id="Dosis' + numero + '" onchange="calculatetotaldose()" class="text" placeholder="Total Dosis de Radiacción" readonly/>';
    $('#showma').append(ma);
    $('#showkv').append(kv);
    $('#showdistancia').append(distancia);
    $('#showfoco').append(foco);
    $('#showdosis').append(dosis);
    numero = parseInt(numero) + 1;
    $('#contador').val(numero);
}


 

