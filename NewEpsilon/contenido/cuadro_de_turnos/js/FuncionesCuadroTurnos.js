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


// Funciones para el cuadro de turnos
function GetConvencion()
	{
		var convencion, inicio;
		convencion = document.Regturno.convencion.value;
		inicio = document.getElementById('inicio');
		ajax1 = nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax1.open("POST", "Query/HoraInicio.php",true);
		ajax1.onreadystatechange = function() 
		{
			if (ajax1.readyState==4) 
			{
				inicio.innerHTML = ajax1.responseText;
			}
		}
		ajax1.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax1.send("convencion="+convencion+"&tiempo=" + new Date().getTime());	
	}
	function Final()
	{
		var convencion, fin;
		convencion = document.Regturno.convencion.value;
		fin = document.getElementById('fin');
		ajax2 = nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax2.open("POST", "Query/HoraFinal.php",true);
		ajax2.onreadystatechange = function() 
		{
			if (ajax2.readyState==4) 
			{
				fin.innerHTML = ajax2.responseText;
			}
		}
		ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax2.send("convencion="+convencion+"&tiempo=" + new Date().getTime());
	}

function Validar()
{	
	//variables
	var form, convencion, servicio, funcionario, tipo, grupoEmpleado, sede, fecha, inicio, fin;
	form = document.Regturno; convencion = form.convencion.value;
	servicio = form.servicio.value; funcionario = form.funcionario.value;
	tipo = form.tipo.value;	grupoEmpleado = form.grupoEmpleado.value;
	sede = form.sede.value;	fecha = form.fecha.value;
	inicio = form.inicio.value; fin = form.fin.value;
	//etiqueta donde voy a mostrar mi respuesta
	notificacion = document.getElementById('notificacion');
	if(convencion == "" || inicio == "" || fin == "" || servicio == "" || funcionario == "" || tipo == "" || grupoEmpleado == "" || sede == "" || fecha == "" )
	{
		mensaje = '<font color="#FF0000">Por favor verifique los campos vacios</font>';
		notificacion.innerHTML = mensaje;
	}
	else
	{
		notificacion.innerHTML = "";
		ajax=nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax.open("POST","inserts/AccionRegTurno.php",true);
		ajax.onreadystatechange = function() 
		{
			if (ajax.readyState==4) 
			{
				notificacion.innerHTML = ajax.responseText;
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("convencion="+convencion+"&inicio="+inicio+"&fin="+fin+"&servicio="+servicio+"&funcionario="+funcionario+"&tipo="+tipo+"&grupoEmpleado="+grupoEmpleado+"&sede="+sede+"&fecha="+fecha+"&tiempo=" + new Date().getTime());
	}
}
//****************************************************************************************************//
function MostrarTurnos()
{
	var funcionario, fecha, tipo;
	funcionario = document.Regturno.funcionario.value;
	fecha = document.Regturno.fecha.value;
	tipo = document.Regturno.tipo.value;
	$(document).ready(function(){
	verlistado()
	})
	function verlistado(){
		var randomnumber=Math.random()*11;
		$.post("Query/TurnosFuncionario.php?funcionario="+funcionario+"&fecha="+fecha+"&tipo="+tipo+"", {
			randomnumber:randomnumber
		}, function(data){
		  $("#contenido").html(data);
		});
	}
}
function EliminarTurno(idturno)
{
	var idturno;
	mensaje = confirm("Eliminar Turno?");
	if(mensaje == true)
	{
		ajax = nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax.open("POST", "inserts/DeleteTurno.php",true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("idturno="+idturno+"&tiempo=" + new Date().getTime());
		fin = MostrarTurnos();
	}
}

//validar tipo de dias
function validaFecha()
{
	var fecha, respTipo, form;
	form = document.Regturno;
	fecha = form.fecha.value;
	respTipo = document.getElementById('respTipo');
	ajax = nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST", "Query/ConsultaTipoDia.php",true);
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			respTipo.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("fecha="+fecha+"&tiempo=" + new Date().getTime());
}

//sumar y restar la hora de almuerzo dentro de los turnos
// ++++++++++++++++ modificar total de horas del turno ++++++++++++++++++++++++++++//
function ModificarTotal(idTurno, valor)
{
	//etiqueta donde se va a mostrar la respuesta
	respuesta = document.getElementById('respuesta');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST","Query/UpdateHrs.php",true);
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			respuesta.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("idTurno="+idTurno+"&valor="+valor+"&tiempo=" + new Date().getTime());	
}