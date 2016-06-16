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

//obtener las preguntas correspondientes a cada encuesta

function CargarPreguntas()
{
	var encuesta, pregunta, formulario;
	formulario  = document.SedePregunta;
	encuesta = formulario.encuesta.value;
	pregunta = document.getElementById('pregunta');
	//Codigo ajax para enviar datos al servidor y obtener respuesta
	//etiqueta donde se va a mostrar la respuesta
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST", "../Query/QueryPreguntas.php",true);
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			pregunta.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("encuesta="+encuesta+"&tiempo=" + new Date().getTime());
}