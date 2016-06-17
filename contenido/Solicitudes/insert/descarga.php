<?php
$url=$_GET[id];
list($directorio,$ced,$archivo)=explode("/",$url);
$id= $archivo;


$ruta = $directorio."/".$ced;
	$size = filesize($url);
	
   header('Content-Type: application/force-download');
   header('Content-Disposition: attachment; filename='.$id);
   header("Pragma: no-cache");
   header("Expires: 0");
	header("Content-Length: " . $size);

   readfile($url);

?>
