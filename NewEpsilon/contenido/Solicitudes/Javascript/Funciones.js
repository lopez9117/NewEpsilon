//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// JavaScript Funciones Solicitudes Biomedicos.
//Funcion para mostrar los equipos biomedicos
function mostrarEquipo() {
        var Sede;
        Sede = document.Newregistro.sede.value;
        //Codigo ajax para enviar datos al servidor y obtener respuesta
        selectEquipo = document.getElementById('selectEquipo');//etiqueta donde se va a mostrar la respuesta
        ajax = nuevoAjax();
        //llamado al archivo que va a ejecutar la consulta ajax
        ajax.open("POST", "listado/SelectEquipo.php", true);
        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4) {
                selectEquipo.innerHTML = ajax.responseText;
            }
        }
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.send("Sede=" + Sede + "&tiempo=" + new Date().getTime());
    }
//Funcion para cargar los datos del equipo.  
function CargarEquipo() {
        var selectEquipo;
        selectEquipo = document.Newregistro.selectEquipo.value;
        //Codigo ajax para enviar datos al servidor y obtener respuesta
        CargaEquipo = document.getElementById('CargaEquipo');//etiqueta donde se va a mostrar la respuesta
        ajax = nuevoAjax();
        //llamado al archivo que va a ejecutar la consulta ajax
        ajax.open("POST", "listado/CargarEquipo.php", true);
        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4) {
                CargaEquipo.innerHTML = ajax.responseText;
            }
        }
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.send("selectEquipo=" + selectEquipo + "&tiempo=" + new Date().getTime());

    }
//Validar solicitud de biomedico
function ValidarSolicitudBiomedico() {
        var sede, prioridad, asunto, descrequerimiento, selectEquipo;
        contador = document.Newregistro.contador.value;
        sede = document.Newregistro.sede.value;
        prioridad = document.Newregistro.prioridad.value;
        asunto = document.Newregistro.asunto.value;
        selectEquipo = document.Newregistro.selectEquipo.value;
        descrequerimiento = CKEDITOR.instances['desc_Requerimiento'].getData();
        if (sede == "" || prioridad == "" || desc_Requerimiento == "" || Session == "" || asunto == "") {
            mensaje = '<font size="2" color="#FF0000">El campo requerimiento es obligatorio</font>';
            //etiqueta donde voy a mostrar la respuesta
            document.getElementById('notificacion').innerHTML = mensaje;
        }
		else {
                document.Newregistro.submit();
        	 }
    }
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// todas las funciones de compras
//funcion para actualizar estado de la solicitude de compras por parte de suministros
function enproceso(idsolicitud)
{
	
	var idsolicitud;
	//etiqueta donde se va a mostrar la respuesta
	solicitud = document.getElementById('solicitud');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST","../update/enproceso.php",true);
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			solicitud.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("idsolicitud="+idsolicitud+"&tiempo=" + new Date().getTime());
	return CargarCompra();
}
//cumplido de compras
function cumplido(idsolicitud)
{
	solicitud = document.getElementById('solicitud');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST","../update/cumplido.php",true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("idsolicitud="+idsolicitud+"&tiempo=" + new Date().getTime());
	return CargarCompra();
}
//update en proceso
function enpro(idsolicitud)
{
	
	var idsolicitud;
	//etiqueta donde se va a mostrar la respuesta
	solicitud = document.getElementById('solicitud');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST","../update/enproceso.php",true);
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			solicitud.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("idsolicitud="+idsolicitud+"&tiempo=" + new Date().getTime());
	return cargardiv2();
}
//solicitud cumplido
function cumplid(idsolicitud)
{
	solicitud = document.getElementById('solicitud');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST","../update/cumplido.php",true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("idsolicitud="+idsolicitud+"&tiempo=" + new Date().getTime());
	return cargardiv2();
}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
	function preguntar(idsolicitud) 
{
	var idsolicitud;
	//etiqueta donde se va a mostrar la respuesta
	solicitud = document.getElementById('solicitud');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax 
	window.open("../update/RespuestaCompras.php?id="+idsolicitud+"","","top=300,left=300,width=300,height=300,aling=center");
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			solicitud.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("idsolicitud="+idsolicitud+"&tiempo=" + new Date().getTime());
}
//++++++++++++++++++++++++++++++++++++++++++++++ Satisfecho ++++++++++++++++++++++//
//Funciones Sistemas---------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ //
function ValidarSolicitud()
{
	var sede, prioridad, asunto, descrequerimiento;
	sede = document.Newregistro.sede.value;
	prioridad = document.Newregistro.prioridad.value;
	asunto = document.Newregistro.asunto.value;
	descrequerimiento = CKEDITOR.instances['desc_Requerimiento'].getData();
	if(sede=="" || prioridad=="" || asunto =="" || descrequerimiento=="")
	{
		mensaje = '<font size="2" color="#FF0000">El campo requerimiento es obligatorio</font>';
		//etiqueta donde voy a mostrar la respuesta
		document.getElementById('notificacion').innerHTML = mensaje;
	}
	else
	{
		document.Newregistro.submit();
	}
}
//
