function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
  		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}
//AJAX
//---------------------------------------------------------------------------------------------
function nuevoAjax()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false;
	try
	{	
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
		
	}
	catch(e)
	{
		try
		{	
			// Creacion del objet AJAX para IE
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			
		}
		catch(E)
		{
			
			if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp=new XMLHttpRequest();
		}
	}
	return xmlhttp; 
}
function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
  		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}


//funcion para registrar los datos del paciente y datos de la agenda
function enviarDatosInforme(){
	var tdocumento, ndocumento, nom1, nom2, ape1, ape2, fechanacimiento, genero, eps, tafiliacion, dep, mun, barrio, dir, tel1, tel2, cel, email, orden, sede, ubicacion, fechasolicitud, servicio, estudio, adicional, extremidad, remitido, portatil, comentarios;
	
	//captura de variables del formulario.
	tdocumento = document.nuevo_informe.tdocumento.value;
	ndocumento = document.nuevo_informe.ndocumento.value;
	nom1 = document.nuevo_informe.nom1.value;
	nom2 = document.nuevo_informe.nom2.value;
	ape1 = document.nuevo_informe.ape1.value;
	ape2 = document.nuevo_informe.ape2.value;
	fecha_nacimiento = document.nuevo_informe.fechanacimiento.value;
	genero = document.nuevo_informe.genero.value;
	eps = document.nuevo_informe.eps.value;
	tafiliacion = document.nuevo_informe.tafiliacion.value;
	dep = document.nuevo_informe.dep.value;
	mun = document.nuevo_informe.mun.value;
	barrio = document.nuevo_informe.barrio.value;
	dir = document.nuevo_informe.dir.value;
	tel1 = document.nuevo_informe.tel1.value;
	tel2 = document.nuevo_informe.tel2.value;
	cel = document.nuevo_informe.cel.value;
	email = document.nuevo_informe.email.value;
	orden = document.nuevo_informe.orden.value;
	sede = document.nuevo_informe.sede.value;
	ubicacion = document.nuevo_informe.ubicacion.value;
	fechasolicitud = document.nuevo_informe.fechasolicitud.value;
	servicio = document.nuevo_informe.servicio.value;
	estudio = document.nuevo_informe.estudio.value;
	adicional = document.nuevo_informe.adicional.value;
	extremidad = document.nuevo_informe.extremidad.value;
	remitido = document.nuevo_informe.remitido.value;
	portatil = document.nuevo_informe.portatil.value;
	comentarios = document.nuevo_informe.comentarios.value;

	//instanciamos el objetoAjax
	divResultado = document.getElementById('resultado');
	ajax=objetoAjax();
	//archivo que realizará la operacion
	ajax.open("POST", "Inserts/RegDatosPaciente.php",true);
	ajax.onreadystatechange=function() {
	if (ajax.readyState==4) {
			//mostrar resultados en esta capa
	divResultado.innerHTML = ajax.responseText
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
ajax.send("t_documento="+t_documento+"&n_documento="+n_documento+"&nom1="+nom1+"&nom2="+nom2+"&ape1="+ape1+"&ape2="+ape2+"&fecha_nacimiento="+fecha_nacimiento+"&genero="+genero+"&eps="+eps+"&tipo_afiliacion="+tipo_afiliacion+"&dep="+dep+"&mun="+mun+"&barrio="+barrio+"&dir="+dir+"&tel1="+tel1+"&tel2="+tel2+"&cel="+cel+"&email="+email+"&orden="+orden+"&sede="+sede+"&ubicacion="+ubicacion+"&fecha_solicitud="+fecha_solicitud+"&servicio="+servicio+"&estudio="+estudio+"&adicional="+adicional+"&extremidad="+extremidad+"&remitido="+remitido+"&adjunto="+adjunto+"&portatil="+portatil+"&comentarios="+comentarios+"&tiempo=" + new Date().getTime());
}



function fAgrega()
{
document.getElementById("Text2").value = document.getElementById("Text1").value;

}
function recoger(){
var mivariable = nuevo_informe.n_documento.value;
alert('Texto guardado: '+mivariable);
}

function cargar(){
var paciente, divbutton;
paciente= document.nuevo_informe.n_documento.value;
	//Codigo ajax para enviar datos al servidor y obtener respuesta
	divbutton = document.getElementById('button1');//etiqueta donde se va a mostrar la respuesta
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST", "inc/boton.php",true);
	ajax.onreadystatechange=function() 
	{
		if (ajax.readyState==4) 
		{
			divbutton.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("paciente="+paciente+"&tiempo=" + new Date().getTime());
//	codeqr();

	} 
// ++++++++++++++++++++++++++++++++++++++++++++++
function codeqr(){
	var paciente, divqr;
	paciente= document.nuevo_informe.n_documento.value;
	//Codigo ajax para enviar datos al servidor y obtener respuesta
	divqr = document.getElementById('qr');//etiqueta donde se va a mostrar la respuesta
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST", "qr/index.php",true);
	ajax.onreadystatechange=function() 
	{
		if (ajax.readyState==4) 
		{
			divqr.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("paciente="+paciente+"&tiempo=" + new Date().getTime());
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function comprobar()
	{
		var n_documento, divResultado1;
		
		n_documento=document.nuevo_informe.n_documento.value;
	//	t_documento1=document.informe.t_documento1.value;
		divResultado1 = document.getElementById('consulta');
		//alert("OK");
		ajax=objetoAjax();
		
//	alert(n_documento);	
	ajax.open("POST", "busqueda.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			//mostrar resultados en esta capa
			divResultado1.innerHTML = ajax.responseText
			//llamar a funcion para limpiar los inputs
			}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("n_documento="+n_documento)
	
//	$("ubicacion").focus();
////	var1 = cambiar();
//alert("Aqui se cambio el foco");
//comprobarQR();
//comprobarQR();
//alert(n_documento);
//scomprobar2();
}

function comprobarQR(){
//alert("prueba div 2");	
			var n_documento;
		
		n_documento=document.nuevo_informe.n_documento.value;
	//	t_documento1=document.informe.t_documento1.value;
		divQR = document.getElementById('qr');
		//alert("OK");
		ajax=objetoAjax();

	ajax.open("POST", "codigoQR.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			//mostrar resultados en esta capa
			divQR.innerHTML = ajax.responseText
			//llamar a funcion para limpiar los inputs
			}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("n_documento="+n_documento)

	}

function comprobar2()
	{
		var n_documento, divResultado2;
		
		n_documento=document.nuevo_informe.n_documento.value;
	//	t_documento1=document.informe.t_documento1.value;
		divResultado2 = document.getElementById('consulta1');
		//alert("OK");
		ajax=objetoAjax();
		
//	alert(n_documento);	
	ajax.open("POST", "busqueda1.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			//mostrar resultados en esta capa
			divResultado2.innerHTML = ajax.responseText
			//llamar a funcion para limpiar los inputs
			}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("n_documento="+n_documento)
	
//	$("ubicacion").focus();
////	var1 = cambiar();
//alert("Aqui se cambio el foco");
//comprobarQR();
//comprobarQR();
//alert(n_documento);
}	
function trigger(){
	funcion0 = enviarDatosInforme();
	funcion2 = codeqr();
	funcion1 = cargar();
}
	
function cargarPrueba(){
var divbutton;
	//Codigo ajax para enviar datos al servidor y obtener respuesta
	divbutton = document.getElementById('cuerpo');//etiqueta donde se va a mostrar la respuesta
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST", "cuerpo.php",true);
	ajax.onreadystatechange=function() 
	{
		if (ajax.readyState==4) 
		{
			divbutton.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("tiempo=" + new Date().getTime());
//	codeqr();

	} 
// +++++++++++++++++ cargar estudios a partir de la seleccion de un servicio ++++++++++++++++++++++ //
function cargarEstudio()
	{	
		var servicio, estudio;
		//obtener el valor del campo			
		servicio = document.nuevo_informe.servicio.value;
		//Codigo ajax para enviar datos al servidor y obtener respuesta
	    estudio = document.getElementById('estudio');//etiqueta donde se va a mostrar la respuesta
		ajax=nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax.open("POST", "../select/SelectEstudio.php",true);
		ajax.onreadystatechange=function() 
		{
			if (ajax.readyState==4) 
			{
				estudio.innerHTML = ajax.responseText;
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("servicio="+servicio+"&tiempo=" + new Date().getTime());
	}
// +++++++++++++  calcular la edad de un paciente  +++++++++++++++++ //
function CalcularEdad()
{
	var fechanacimiento, edad;
	fechanacimiento = document.nuevo_informe.fechanacimiento.value;
	//validar contenido del campo
	if(fechanacimiento=="")
	{
		alert("Por favor ingrese una fecha valida");
	}
	else
	{
		edad = document.getElementById('edad');
		ajax=nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax.open("POST", "../select/CalcularEdad.php",true);
		ajax.onreadystatechange=function() 
		{
			if (ajax.readyState==4) 
			{
				edad.innerHTML = ajax.responseText;
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("fechanacimiento="+fechanacimiento+"&tiempo=" + new Date().getTime());
	}
}
// +++++++++++++++++++++++++ Cargar agenda a partir del dia, sede, servicio +++++++++++++++++++++++//
/*function CargarAgenda()
{
	var fecha, sede, servicio;
	fecha = document.VerAgenda.fecha.value;
	sede = document.VerAgenda.sede.value;
	servicio = document.VerAgenda.servicio.value;
	//validar si alguno de los campos es vacio
	if(fecha=="" || sede=="" || servicio=="")
	{
		mensaje = "<font color='#FF0000'>Los campos marcados con * son obligatorios</font>";
		document.getElementById('notificacion').innerHTML = mensaje;
	}
	else
	{
		mensaje = "";
		document.getElementById('notificacion').innerHTML = mensaje;
		
		agenda = document.getElementById('agenda');
		ajax=nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax.open("POST", "../WorkList/PacientesAgendados.php",true);
		ajax.onreadystatechange=function() 
		{
			if (ajax.readyState==4) 
			{
				agenda.innerHTML = ajax.responseText;
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("fecha="+fecha+"&sede="+sede+"&servicio="+servicio+"&tiempo=" + new Date().getTime());
	}
}
*/




function cargarTecnica()
	{	
		var servicio, tecnica;
		//obtencion del grupo de empleados
			
		servicio = document.nuevo_informe.servicio.value;
	//	alert(especialista);
		//Codigo ajax para enviar datos al servidor y obtener respuesta
	    tecnica = document.getElementById('divTecnica');//etiqueta donde se va a mostrar la respuesta
		ajax=nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax.open("POST", "inc/selects/select_tecnica.php",true);
		ajax.onreadystatechange=function() 
		{
			if (ajax.readyState==4) 
			{
				tecnica.innerHTML = ajax.responseText;
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("servicio="+servicio+"&tiempo=" + new Date().getTime());
	}
	
function cargarUrl(){
var inform, divUrl;

documento=document.getElementById('Url').documento.value;
//alert(n_documento);
	//Codigo ajax para enviar datos al servidor y obtener respuesta
	divform = document.getElementById('formulario');//etiqueta donde se va a mostrar la respuesta
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax| +"tiempo=" + new Date().getTime()
	ajax.open("POST", "inc/formulario.php",true);
	ajax.onreadystatechange=function() 
	{
		if (ajax.readyState==4) 
		{
			divform.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("documento="+documento);
//	codeqr();
document.busqueda.documento.value = "";
}

function cargarMunicipio()
	{	
		var dep, munbar;
		//obtencion del grupo de empleados
		dep = document.nuevo_informe.dep.value;
		//Codigo ajax para enviar datos al servidor y obtener respuesta
	    munbar = document.getElementById('mun');//etiqueta donde se va a mostrar la respuesta
		ajax=nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax.open("POST", "../select/SelectMunicipio.php",true);
		ajax.onreadystatechange=function() 
		{
			if (ajax.readyState==4) 
			{
				munbar.innerHTML = ajax.responseText;
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("dep="+dep+"&tiempo=" + new Date().getTime());
	
	}

function enviarDatosPaciente(){
	var n_documento, t_documento, nom1, nom2, ape1, ape2, datepicker, genero, eps, t_afiliacion, dep, mun, barrio, dir, tel1, tel2, cel, email;
	//donde se mostrará lo resultados
//	divResultado = document.getElementById('resultado');//
//	divResultado = document.getElementById('formulario');
//	Respuesta = document.getElementById('Url');
	//valores de los inputs
	divResultado = document.getElementById('resultado');
	
	n_documento=document.nuevo_informe.n_documento.value;
	t_documento=document.nuevo_informe.t_documento.value;
	nom1=document.nuevo_informe.nom1.value;
	nom2=document.nuevo_informe.nom2.value;
	ape1=document.nuevo_informe.ape1.value;
	ape2=document.nuevo_informe.ape2.value;
	datepicker=document.nuevo_informe.datepicker.value
	genero=document.nuevo_informe.genero.value;
	eps=document.nuevo_informe.eps.value;
	t_afiliacion=document.nuevo_informe.t_afiliacion.value;
	dep=document.nuevo_informe.dep.value;
	mun=document.nuevo_informe.mun.value;
	barrio=document.nuevo_informe.barrio.value;
	dir=document.nuevo_informe.dir.value;
//	alert(dir);
	tel1=document.nuevo_informe.tel1.value;
	tel2=document.nuevo_informe.tel2.value;
	cel=document.nuevo_informe.cel.value;
	email=document.nuevo_informe.email.value;

//	alert(comentario);
	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registro.php
	ajax.open("POST", "query/ingreso_paciente.php",true);
	ajax.onreadystatechange=function() {
			if (ajax.readyState<4){
				
		//		alert('Hola!')
			Respuesta.innerHTML = "images/ajax-loader.gif";
		}else{

		if (ajax.readyState==4) {
			//mostrar resultados en esta capa
	//		divResultado.innerHTML = ajax.responseText
	Respuesta.innerHTML = ajax.responseText
			//llamar a funcion para limpiar los inputs
	//		LimpiarCampos();
		}
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("n_documento="+n_documento+"&t_documento="+t_documento+"&nom1="+nom1+"&nom2="+nom2+"&ape1="+ape1+"&ape2="+ape2+"&datepicker="+datepicker+"&genero="+genero+"&eps="+eps+"&t_afiliacion="+t_afiliacion+"&dep="+dep+"&mun="+mun+"&barrio="+barrio+"&dir="+dir+"&tel1="+tel1+"&tel2="+tel2+"&cel="+cel+"&email="+email)
//	cargar();

 codeqr();
	}
	
	
function cargarMunicipio2()
	{	
		var dep, munbar;
		//obtencion del grupo de empleados
			
		dep = document.nuevo_informe.dep.value;
	//	alert(dep);
	//	alert(especialista);
		//Codigo ajax para enviar datos al servidor y obtener respuesta
	    munbar = document.getElementById('divMunbar');//etiqueta donde se va a mostrar la respuesta
		ajax=nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax.open("POST", "inc/selects/select_municipio2.php",true);
		ajax.onreadystatechange=function() 
		{
			if (ajax.readyState==4) 
			{
				munbar.innerHTML = ajax.responseText;
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("dep="+dep+"&tiempo=" + new Date().getTime());
	
	}
	
	
	function cargarEdad()
	{	
		var datepicker;
		//obtencion del grupo de empleados
		 datepicker = document.nuevo_informe.datepicker.value;
	//	alert(especialista);
//		alert(datepicker);	
		//Codigo ajax para enviar datos al servidor y obtener respuesta
	    edad = document.getElementById('divEdad');//etiqueta donde se va a mostrar la respuesta
		ajax=nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax.open("POST", "inc/selects/edad.php",true);
		ajax.onreadystatechange=function() 
		{
			if (ajax.readyState==4) 
			{
				estudio.innerHTML = ajax.responseText;
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("datepicker="+datepicker);
	
	}
	
function abrir(pag,ancho,alto,posx,posy){
	  emergente = window.open(pag, "ventana","status=yes,width="+ancho+", height="+alto+",scrollbars=no,location=no,toolbar=no,directories=no,menubar=no,left="+posx+",top="+posy+"");        
	  emergente.focus();
    }	
	

function AbrirCentrado(Url,NombreVentana,width,height,extras) {
var largo = width;
var altura = height;
var adicionales= extras;
var top = (screen.height-altura)/2;
var izquierda = (screen.width-largo)/2; nuevaVentana=window.open(''+ Url + '',''+ NombreVentana + '','width=' + largo + ',height=' + altura + ',top=' + top + ',left=' + izquierda + ',features=' + adicionales + ''); 
nuevaVentana.focus();
}

//------------------------------
