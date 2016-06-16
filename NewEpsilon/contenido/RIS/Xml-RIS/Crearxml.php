<?php
$idestudio='34567';
$xml=new DomDocument("1.0","iso-8859-1");
/*Encabezado de archivo XML--------------------------*/
$raiz=$xml->createElement("ResultadoDatos");
$raiz=$xml->appendChild($raiz);
$Origen=$xml->createElement("Origen", "Prodiagnostico");
$Origen=$raiz->appendChild($Origen);
$Destino=$xml->createElement("Destino", "Leon XIII");
$Destino=$raiz->appendChild($Destino);
$MsjID=$xml->createElement("MsjID", "6e8e16ca-15fa-4905-91f5-f0197526fbad");
$MsjID=$raiz->appendChild($MsjID);
/*tDatos del Paciente--------------------------*/  
$Paciente=$xml->createElement("Paciente");
$Paciente=$raiz->appendChild($Paciente);
$ID=$xml->createElement("ID", "9876543210");
$ID=$Paciente->appendChild($ID);
$Tipo=$xml->createElement("Tipo", "CC");
$Tipo=$Paciente->appendChild($Tipo);
$Pnombre=$xml->createElement("PrimerNombre", "Carlos");
$Pnombre=$Paciente->appendChild($Pnombre);
$SegundoNombre=$xml->createElement("SegundoNombre", "Mario");
$SegundoNombre=$Paciente->appendChild($SegundoNombre);
$PrimerApellido=$xml->createElement("PrimerApellido", "Cortina");
$PrimerApellido=$Paciente->appendChild($PrimerApellido);
$SegundoApellido=$xml->createElement("SegundoApellido", "Garcia");
$SegundoApellido=$Paciente->appendChild($SegundoApellido);
$Ingreso=$xml->createElement("Ingreso", "6621051");
$Ingreso=$Paciente->appendChild($Ingreso);
/* Datos del personal que participan en la realizacion del estudio. */
$Personal=$xml->createElement("Personal");
$Personal=$raiz->appendChild($Personal);
/*Datos medico */
$Medico=$xml->createElement("Medico");
$Medico=$Personal->appendChild($Medico);
$Identificacion=$xml->createElement("Identificacion", "1234567890");
$Identificacion=$Medico->appendChild($Identificacion);
$Pnombre=$xml->createElement("PrimerNombre", "Carlos");
$Pnombre=$Medico->appendChild($Pnombre);
$SegundoNombre=$xml->createElement("SegundoNombre", "Mario");
$SegundoNombre=$Medico->appendChild($SegundoNombre);
$Apellidos=$xml->createElement("Apellidos", "Cortina");
$Apellidos=$Medico->appendChild($Apellidos);
/*Datos Asistente */
$Asistente=$xml->createElement("Asistente");
$Asistente=$Personal->appendChild($Asistente);
$Identificacion=$xml->createElement("Identificacion", "1234567890");
$Identificacion=$Asistente->appendChild($Identificacion);
$Pnombre=$xml->createElement("PrimerNombre", "Carlos");
$Pnombre=$Asistente->appendChild($Pnombre);
$SegundoNombre=$xml->createElement("SegundoNombre", "Mario");
$SegundoNombre=$Asistente->appendChild($SegundoNombre);
$Apellidos=$xml->createElement("Apellidos", "Cortina");
$Apellidos=$Asistente->appendChild($Apellidos);
/*Datos Tecnico */
$Tecnico=$xml->createElement("Tecnico");
$Tecnico=$Personal->appendChild($Tecnico);
$Identificacion=$xml->createElement("Identificacion", "1234567890");
$Identificacion=$Tecnico->appendChild($Identificacion);
$Pnombre=$xml->createElement("PrimerNombre", "Carlos");
$Pnombre=$Tecnico->appendChild($Pnombre);
$SegundoNombre=$xml->createElement("SegundoNombre", "Mario");
$SegundoNombre=$Tecnico->appendChild($SegundoNombre);
$Apellidos=$xml->createElement("Apellidos", "Cortina");
$Apellidos=$Tecnico->appendChild($Apellidos);
/*Datos Transcriptor */
$Transcriptor=$xml->createElement("Transcriptor");
$Transcriptor=$Personal->appendChild($Transcriptor);
$Identificacion=$xml->createElement("Identificacion", "1234567890");
$Identificacion=$Transcriptor->appendChild($Identificacion);
$Pnombre=$xml->createElement("PrimerNombre", "Carlos");
$Pnombre=$Transcriptor->appendChild($Pnombre);
$SegundoNombre=$xml->createElement("SegundoNombre", "Mario");
$SegundoNombre=$Transcriptor->appendChild($SegundoNombre);
$Apellidos=$xml->createElement("Apellidos", "Cortina");
$Apellidos=$Transcriptor->appendChild($Apellidos);
/* Resultado */
$Resultado=$xml->createElement("Resultado");
$Resultado=$raiz->appendChild($Resultado);
$Lectura=$xml->createElement("Lectura", "Aqui va la Lectura");
$Lectura=$Resultado->appendChild($Lectura);
$IDResultado=$xml->createElement("IDResultado", "0001");
$IDResultado=$Resultado->appendChild($IDResultado);
$FechaHoraExamen=$xml->createElement("FechaHoraExamen", "20140315173120");
$FechaHoraExamen=$Resultado->appendChild($FechaHoraExamen);
$FechaHoraLectura=$xml->createElement("FechaHoraLectura", "20140316154220");
$FechaHoraLectura=$Resultado->appendChild($FechaHoraLectura);
/*guardar xml--------------------------------*/  
$xml->formatOut=true;
$strings_xml=$xml->saveXML();
if($xml->save("../../../../WebServiceSOAP/ORU/".$idestudio.".xml")){
  echo "Termino de crear el xml.";
}else{
  echo "No pudimos guardar el xml.";
}
mysql_close($cn);
?>
