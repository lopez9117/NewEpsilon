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

function enviarDatosInforme(){
	var n_documento, orden, sede, ubicacion, fecha_solicitud, hora_solicitud, servicio, estudio, tecnica, extremidad, portatil, remitido, comentarios, validador, user;
	//donde se mostrará lo resultados
//	divResultado = document.getElementById('resultado');//
//	divResultado = document.getElementById('formulario');
//	Respuesta = document.getElementById('Url');
	//valores de los inputs
	divResultado = document.getElementById('resultado');
	validador=document.nuevo_informe.validador.value;
	user=document.nuevo_informe.user.value;
//	conta2=document.nuevo_informe.conta2.value;
	n_documento=document.nuevo_informe.n_documento.value;
	orden=document.nuevo_informe.orden.value;
	sede=document.nuevo_informe.sede.value;
	ubicacion=document.nuevo_informe.ubicacion.value;
	fecha_solicitud=document.nuevo_informe.fecha_solicitud.value;
	hora_solicitud=document.nuevo_informe.hora_solicitud.value;
	servicio=document.nuevo_informe.servicio.value;
	estudio=document.nuevo_informe.estudio.value;
	tecnica=document.nuevo_informe.tecnica.value;
	extremidad=document.nuevo_informe.extremidad.value;
	portatil=document.nuevo_informe.portatil.value;
	remitido=document.nuevo_informe.remitido.value;
	comentarios=document.nuevo_informe.comentarios.value;
//	alert(comentario);
	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//uso del medotod POST
	//archivo que realizará la operacion
	//registro.php
	ajax.open("POST", "query/ingreso_informe_header.php",true);
	ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
			//mostrar resultados en esta capa
	//		divResultado.innerHTML = ajax.responseText
	Respuesta.innerHTML = ajax.responseText
			//llamar a funcion para limpiar los inputs
	//		LimpiarCampos();
		}
//		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send("n_documento="+n_documento+"&orden="+orden+"&sede="+sede+"&fecha_solicitud="+fecha_solicitud+"&hora_solicitud="+hora_solicitud+"&servicio="+servicio+"&estudio="+estudio+"&tecnica="+tecnica+"&extremidad="+extremidad+"&portatil="+portatil+"&remitido="+remitido+"&comentarios="+comentarios+"&ubicacion="+ubicacion+"&validador="+validador+"&user="+user)
//	cargar();

 // codeqr();
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

function cargarForm(){
var documento, divform;

documento=document.busqueda.documento.value;
//conta=document.conta.documento.value;
//alert(n_documento);
	//Codigo ajax para enviar datos al servidor y obtener respuesta
	divform = document.getElementById('formulario');//etiqueta donde se va a mostrar la respuesta
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax| +"tiempo=" + new Date().getTime()
	ajax.open("POST", "inc/formulario3.php",true);
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

function cargarEstudio()
	{	
		var servicio, estudio;
		//obtencion del grupo de empleados
			
		servicio = document.nuevo_informe.servicio.value;
	//	alert(especialista);
		//Codigo ajax para enviar datos al servidor y obtener respuesta
	    estudio = document.getElementById('divEstudio');//etiqueta donde se va a mostrar la respuesta
		ajax=nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax.open("POST", "inc/selects/select_estudio.php",true);
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
	//	alert(dep);
	//	alert(especialista);
		//Codigo ajax para enviar datos al servidor y obtener respuesta
	    munbar = document.getElementById('divMunbar');//etiqueta donde se va a mostrar la respuesta
		ajax=nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax.open("POST", "inc/selects/select_municipio.php",true);
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
