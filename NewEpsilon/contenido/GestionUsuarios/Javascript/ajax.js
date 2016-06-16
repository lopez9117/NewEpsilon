// JavaScript Document

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
function ajaxFunction() {
  var xmlHttp;
  
  try {
   
    xmlHttp=new XMLHttpRequest();
    return xmlHttp;
  } catch (e) {
    
    try {
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
      return xmlHttp;
    } catch (e) {
      
	  try {
        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        return xmlHttp;
      } catch (e) {
        alert("Tu navegador no soporta AJAX!");
        return false;
      }}}
}
var xmlhttp = false;
 
//Chequeo si se usa IExplorer.
try {
    //Si la version de Javascript es mayor que la 5.
    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
 
    //If not, then use the older active x object.
    try {
        //If we are using Internet Explorer.
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (E) {
        //Si no, no se esta usando un Internet Explorer.
        xmlhttp = false;
    }
}
//Si no se esta usando un IExplorer, se crea una instancia javascript del objeto.
if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
    xmlhttp = new XMLHttpRequest();
}

//validar los campos de registro del formulario de usuarios del sistema
function Validate()
{
	var usuario, formulario, rol, email, pass1, pass2;
	formulario = document.RegistrarUsuario;
	usuario = formulario.documento.value;
	rol = formulario.rol.value;
	email = formulario.email.value;
	pass1 = formulario.pass1.value;
	pass2 = formulario.pass2.value;
	//validar campos vacios del formulario
	if(usuario == "" || rol == "" || email == "" || pass1 == "" || pass2 == "")
	{
		mensaje = "Los campos señalados con * son obligatorios";
		document.getElementById('respuesta').innerHTML = mensaje;
	}
	else
	{
		//validar que las contraseñas sean iguales
		if(pass1 != pass1)
		{
			mensaje = "Las contraseñas no coinciden";
			document.getElementById('respuesta').innerHTML = mensaje;
		}
		else
		{
			RegistrarUsuario.submit();
		}
	}
}

/*
function RegTurno(funcionario, fecha, tipo, anio, mes, d, grupoEmpleado, sede, CurrentUser)
{
	var respuesta, funcionario, fecha, tipo, id, convencion, anio, mes, d, grupoEmpleado, sede, CurrentUser;	
	id = (funcionario+""+fecha);
	convencion = document.getElementById(id).value;
	//etiqueta donde se va a mostrar la respuesta
	respuesta = document.getElementById('respuesta');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST", "inserts/accionCrearTurno.php",true);
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			respuesta.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("funcionario="+funcionario+"&convencion="+convencion+"&tipo="+tipo+"&anio="+anio+"&mes="+mes+"&d="+d+"&grupoEmpleado="+grupoEmpleado+"&sede="+sede+"&CurrentUser="+CurrentUser+"&tiempo=" + new Date().getTime());
	
	finfuncion = terminar();
}
*/