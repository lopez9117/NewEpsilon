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
//+++++++++++++++++++++++++++++++++++++++ Cargar paginas en un div ++++++++++++++++++++++++++++++++++++++++++//
	
function Enviar(_pagina,capa) {
    var ajax;
    ajax = ajaxFunction();
    ajax.open("POST", _pagina, true);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    ajax.onreadystatechange = function() {
		if (ajax.readyState==1){
			document.getElementById(capa).innerHTML = " Aguarde por favor...";
			     }
		if (ajax.readyState == 4) {
		   
                document.getElementById(capa).innerHTML=ajax.responseText; 
		     }}
			 
	ajax.send(null);
} 
//++++++++++++++++++++++++++++++++ Mostrar descripcion del funcionario en el cuadro de turnos +++++++++++++++++++//
function mostrar(documento)
{
	var documento, nombre;
	//Codigo ajax para enviar datos al servidor y obtener respuesta
	//etiqueta donde se va a mostrar la respuesta
	nombre = document.getElementById('nombre');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST", "desc_funcionario.php",true);
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			nombre.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("documento="+documento+"&tiempo=" + new Date().getTime());
}
// +++++++++++++++++++++++++++ documento de identificacion == password de usuario ++++++++++++++++++++++++++//
function copypassword()
{
	var origen, destino;
	origen = document.Newregistro.ndocumento.value;
	//etiqueta donde se va a mostrar la respuesta
	destino = document.Newregistro.pass.value = origen;
}
// ++++++++++++++++++++++++ Seleccion de un funcionario para editar la hoja de vida +++++++++++++++++++++++//
function estadoFuncionario(documento)
{
	var documento, destino;
	destino = document.getElementById('idFuncionario').value = documento;
}
//++++++++++++++++++++++
function mostrarFecha()
{
	var fecha;
	fecha = document.getElementsByName('fecha').value;
	alert(fecha);
}
//+++++++++++++++++++++++++++++++ Funcion para generar turnos captando la variable que equivale a una convension +++++++++++++++++++++++++++//
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
// +++++++++++++++++++++++++++++++ Funcion para cargar servicios de un especialista +++++++++++++++++++++++++++++++++++++++++++//
function ListarServicio()
{
	var especialista, respuesta;
	especialista = document.NewInforme.especialista.value;
	//etiqueta donde se va a mostrar la respuesta
	respuesta = document.getElementById('servicio');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST","../select/selectServicio_Especialista.php",true);
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			respuesta.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("especialista="+especialista+"&tiempo=" + new Date().getTime());
}
//++++++++++++++++++++++++++++++++++++++++++++++ Listar estudios correspondientes a un servicio y un especialista +++++++++++++++++++//
function listarEstudios()
{
	var especialista, servicio, respuesta;
	especialista = document.NewInforme.especialista.value;
	servicio = document.NewInforme.servicio.value;
	
	respuesta = document.getElementById('estudio');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST","../select/selectEstudio_Especialista.php",true);
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			respuesta.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("especialista="+especialista+"&servicio="+servicio+"&tiempo=" + new Date().getTime());
}
//+++++++++++++++++++++++++++++ Activar o desactivar una convencion ++++++++++++++++++++++++++++++++++++//
function ActConvencion(id)
{
	var id;
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST","updates/ActConvencion.php",true);
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			respuesta.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("id="+id+"&tiempo=" + new Date().getTime());	
}
// +++++++++++++++++++++++++ desactivar convencion +++++++++++++++++++++++++++++++++++++++++ //
function DesConvencion(id)
{
	var id;
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST","updates/DesConvencion.php",true);
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			respuesta.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("id="+id+"&tiempo=" + new Date().getTime());			
}
// ++++++++++++++++++++++++ Mostrar informacion acerca de los turnos de un funcinario +++++++++++++++++++++++++++++++++++//
function ConsTurno(funcionario, fecha, anio, mes, d )
{
	var respuesta, funcionario, fecha, anio, mes, d;
	//etiqueta donde se va a mostrar la respuesta
	respuesta = document.getElementById('turno');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST", "ConstTurnos.php",true);
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			respuesta.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("funcionario="+funcionario+"&anio="+anio+"&mes="+mes+"&d="+d+"&tiempo=" + new Date().getTime());
}
//+++++++++++++++++++++++++++ mostrar formularios para novedades +++++++++++++++++++++++++++++++++++++++++++//
function mostrarAgregar()
{
document.getElementById('Modificar').style.display = 'none';
document.getElementById('Evento').style.display = 'none';
document.getElementById('Disponibilidad').style.display = 'none';
document.getElementById('Agregar').style.display = 'block';
}
// +++++++++++ Formulario para editar horario del turno ++++++++++++++++++++++//
function MostrarModificar()
{
document.getElementById('Agregar').style.display = 'none';
document.getElementById('Evento').style.display = 'none';
document.getElementById('Disponibilidad').style.display = 'none';
document.getElementById('Modificar').style.display = 'block';
}
// ++++++++++ Formulario para registrar eventos adversos ++++++++++++++++++++++++//
function MostrarEvento()
{
document.getElementById('Agregar').style.display = 'none';
document.getElementById('Modificar').style.display = 'none';
document.getElementById('Disponibilidad').style.display = 'none';
document.getElementById('Evento').style.display = 'block';
}
function MostrarDisponibilidad()
{
document.getElementById('Agregar').style.display = 'none';
document.getElementById('Modificar').style.display = 'none';
document.getElementById('Disponibilidad').style.display = 'block';
document.getElementById('Evento').style.display = 'none';
}

//++++++++++++++++++++++++ Modificar o eliminar un turno ++++++++++++++++++++++++++++++++++++++++++++++++//
function Update(idturno, funcionario, fecha, tipo, anio, mes, d, grupoEmpleado, sede, CurrentUser, servicio)
{
	var idturno, respuesta, funcionario, fecha, tipo, id, convencion, anio, mes, d, grupoEmpleado, sede, CurrentUser, servicio;
	id = (funcionario+""+fecha);
	convencion = document.getElementById(id).value;
	//etiqueta donde se va a mostrar la respuesta
	respuesta = document.getElementById('respuesta');
	if(convencion=="")
	{
		ajax=nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax.open("POST", "inserts/DeleteTurno.php",true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("idturno="+idturno+"&tiempo=" + new Date().getTime());
		
		finfuncion = terminar();
	}
	else
	{
		ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST", "inserts/UpdateTurno.php",true);
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			respuesta.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("idturno="+idturno+"&funcionario="+funcionario+"&convencion="+convencion+"&tipo="+tipo+"&anio="+anio+"&mes="+mes+"&d="+d+"&grupoEmpleado="+grupoEmpleado+"&sede="+sede+"&CurrentUser="+CurrentUser+"&servicio="+servicio+"&tiempo=" + new Date().getTime());
	
	finfuncion = terminar();
	}
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
function activarSede(idsede)
{
	var idsede;
	//etiqueta donde se va a mostrar la respuesta
	sede = document.getElementById('sede');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST", "update/activarSede.php",true);
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			sede.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("idsede="+idsede+"&tiempo=" + new Date().getTime());
}

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
function desactivarSede(idsede)
{
	var idsede;
	//etiqueta donde se va a mostrar la respuesta
	sede = document.getElementById('sede');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST", "update/desactivarSede.php",true);
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			sede.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("idsede="+idsede+"&tiempo=" + new Date().getTime());
	
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
function activarServicio(idservicio)
{
	var idservicio;
	//etiqueta donde se va a mostrar la respuesta
	servicio = document.getElementById('servicio');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST", "update/activarServicio.php",true);
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			servicio.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("idservicio="+idservicio+"&tiempo=" + new Date().getTime());
}

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
function desactivarServicio(idservicio)
{
	var idservicio;
	//etiqueta donde se va a mostrar la respuesta
	servicio = document.getElementById('servicio');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST", "update/desactivarServicio.php",true);
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			servicio.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("idservicio="+idservicio+"&tiempo=" + new Date().getTime());
	
}
// +++++++++++++++++++++++++++++++ Funcion para cargar servicios de un especialista +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++//
function ListarServicio()
{
	var especialista, respuesta;
	especialista = document.NewInforme.especialista.value;
	//etiqueta donde se va a mostrar la respuesta
	respuesta = document.getElementById('servicio');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST","../select/selectServicio_Especialista.php",true);
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			respuesta.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("especialista="+especialista+"&tiempo=" + new Date().getTime());
}
//++++++++++++++++++++++++++++++++++++++++++++++ Listar estudios correspondientes a un servicio y un especialista +++++++++++++++++++//
function listarEstudios()

{
	var especialista, servicio, respuesta;
	especialista = document.NewInforme.especialista.value;
	servicio = document.NewInforme.servicio.value;
	
	respuesta = document.getElementById('estudio');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST","../select/selectEstudio_Especialista.php",true);
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			respuesta.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("especialista="+especialista+"&servicio="+servicio+"&tiempo=" + new Date().getTime());
	}
	
	var editor, html = '';

//++++++++++++++++++++++++++++++++++++++++++++++ Satisfecho ++++++++++++++++++++++//

function satisfecho(idsolicitud)
{
	var idsolicitud;
	//etiqueta donde se va a mostrar la respuesta
	solicitud = document.getElementById('solicitud');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST","../update/satisfecho.php",true); 
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
//+++++++++++++++++++++++++++++++++++++++++++++++ No satisfecho ++++++++++++++++++++++++++++++++++++++++++++
function nosatisfecho(idsolicitud)
{
	var idsolicitud;
	//etiqueta donde se va a mostrar la respuesta
	solicitud = document.getElementById('solicitud');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST","../update/nosatisfecho.php",true); 
	//window.open("../update/porque.php?id="+idsolicitud+"","","top=300,left=300,width=300,height=300,aling=center");
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
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ //
function ValidarSolicitud()
{
	var sede, prioridad, asunto, descrequerimiento;
	sede = document.Newregistro.sede.value;
	prioridad = document.Newregistro.prioridad.value;
	asunto = document.Newregistro.asunto.value;
	descrequerimiento = document.Newregistro.desc_Requerimiento.value;
	if(sede=="" || prioridad=="" || asunto =="" || descrequerimiento=="")
	{
		mensaje = '<font size="2" color="#FF0000">Los campos señalados con * son obligatorios</font>';
		//etiqueta donde voy a mostrar la respuesta
		document.getElementById('notificacion').innerHTML = mensaje;
	}
	else
	{
		document.Newregistro.submit();
	}
}
// +++++++++++++++++++++ Consultar datos del paciente +++++++++++++++++++++++++++++++++++++++++++++//
function consultar()
{
	var paciente, respuesta, formulario;
	formulario = document.getElementById('formulario');
	mensaje = document.getElementById('respuesta');
	paciente = document.getElementById('ndocumento').value;
	if(paciente=="")
	{
		mensaje = "Por favor digite un numero de documento";
		//etiqueta donde voy a mostrar la respuesta
		document.getElementById('respuesta').innerHTML = mensaje;
	}
	else
	{
		document.getElementById('respuesta').innerHTML = "";
		ajax=nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax.open("POST","../contenido/RIS/forms/ConsPaciente.php",true); 
		ajax.onreadystatechange = function() 
		{
			if (ajax.readyState==4) 
			{
				formulario.innerHTML = ajax.responseText;
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("paciente="+paciente+"&tiempo=" + new Date().getTime());
	}
}
// Recargar el div que contiene el cuadro de turnos, cada vez que se haga una modificacion en los registros //
function terminar()
{
	Cuadro = document.getElementById('Cuadro');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST","QueryCuadro.php",true); 
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			Cuadro.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send(null);
}

function RegEventualidad()
{
	var funcionario, desde, cantDias, tipo, observacion;
	idfuncionario = document.Ausentismo.funcionario.value;
	desde = document.Ausentismo.fechadesde.value;
	cantDias = document.Ausentismo.cantDias.value;
	tipo = document.Ausentismo.tipo.value;
	observacion = document.Ausentismo.observacion.value;
	//Validar Campos obligatorios del formulario
	if(desde == "" || cantDias =="" || funcionario=="")
	{
		mensaje = "Los campos marcados con * son obligatorios";
		document.getElementById('respuesta').innerHTML = mensaje;
	}
	else
	{
		//etiqueta donde se va a mostrar la respuesta
		respuesta = document.getElementById('respuesta');
		ajax=nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax.open("POST","NovedadesForms/InsertsAusentismo/RegEventualildad.php",true); 
		ajax.onreadystatechange = function() 
		{
			if (ajax.readyState==4) 
			{
				respuesta.innerHTML = ajax.responseText;
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("idfuncionario="+idfuncionario+"&desde="+desde+"&cantDias="+cantDias+"&tipo="+tipo+"&observacion="+observacion+"&tiempo=" + new Date().getTime());
	}
}

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ //
function EliminarNovedad(idNovedad)
	{
		opcion = confirm("Desea Eliminar la novedad ?");
		if(opcion==true)
		{
			ajax=nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax.open("POST","Delete/DeleteNovedad.php",true); 
		ajax.onreadystatechange = function() 
		{
			if (ajax.readyState==4) 
			{
				respuesta.innerHTML = ajax.responseText;
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("idNovedad="+idNovedad+"&tiempo=" + new Date().getTime());	
		}
		else
		{
			
		}
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

// ++++++++++++++++ modificar total de horas del turno ++++++++++++++++++++++++++++//
function ModificarTotal(idTurno)
{
	//etiqueta donde se va a mostrar la respuesta
	respuesta = document.getElementById('respuesta');
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST","UpdateHrs.php",true);
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			respuesta.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("idTurno="+idTurno+"&tiempo=" + new Date().getTime());	
	
	location.reload();
}
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
function RegDisponibilidad()
{
	var hrdesde, hrhasta, sede, servicio, funcionario, fecha, observacion, grupoEmpleado;
	
	hrdesde = document.Disponibilidades.hrdesde.value;
	hrhasta = document.Disponibilidades.hrhasta.value;
	sede =  document.Disponibilidades.sede.value;
	servicio = document.Disponibilidades.servicio.value;
	funcionario = document.Disponibilidades.funcionario.value;
	fecha = document.Disponibilidades.fecha.value;
	observacion = document.Disponibilidades.observacion.value;
	grupoEmpleado = document.Disponibilidades.grupoEmpleado.value;
	notificacion = document.getElementById('notificacion');
		
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST","NovedadesForms/Disponibilidades/RegDisponibilidad.php",true);
	ajax.onreadystatechange = function() 
	{
		if (ajax.readyState==4) 
		{
			notificacion.innerHTML = ajax.responseText;
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("hrdesde="+hrdesde+"&hrhasta="+hrhasta+"&sede="+sede+"&servicio="+servicio+"&funcionario="+funcionario+"&fecha="+fecha+"&observacion="+observacion+"&grupoEmpleado="+grupoEmpleado+"&tiempo=" + new Date().getTime());
}
