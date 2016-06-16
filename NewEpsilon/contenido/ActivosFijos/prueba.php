<html>
<head><title>Titulo</title></head>
<body">
<a href="javascript:window.print()">Imprimir esta página</a> 
<script> 
function window.on{ 
noImprimir.style.visibility = 'hidden'; 
noImprimir.style.position = 'absolute'; 
} 
function window.onafterprint(){ 
noImprimir.style.visibility = 'visible'; 
noImprimir.style.position = 'relative'; 
}</script> 
<p id="noImprimir">Texto no imprimible</p> 
</body>
</html>