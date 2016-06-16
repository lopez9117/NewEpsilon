<h3>Agendamiento</h3>
<div>
  <p><a href="../formularios/Agendamiento.php?usuario=<?php echo $user ?>&sede=<?php echo $sede ?>" target="content" style="cursor:pointer;">Gesti&oacute;n de Citas</a>
  </p>
</div>
<h3>Listas de Trabajo</h3>
<div>
	<p><a href="../WorkList/estudios/TomaEstudios.php?sede=<?php echo $sede ?>&usuario=<?php echo $user ?>&rol=<?php echo base64_encode($rol)?>" target="content" style="cursor:pointer;">Toma de estudios</a></p>
	<p><a href="../WorkList/lectura/LecturaEstudios.php?usuario=<?php echo $user ?>&sede=<?php echo $sede ?>" target="content" style="cursor:pointer;">Lectura y Aprobación</a></p>	
</div>
<h3>Resultados</h3>
<div>
	<p><a href="../Busqueda/BuscarInforme.php?sede=<?php echo $sede ?>&usuario=<?php echo $user ?>" style="cursor:pointer;" target="content">Buscar estado de informe</a></p>
	<p><a href="../Resultados/ResultadosDefinitivos.php?sede=<?php echo $sede ?>&usuario=<?php echo $user ?>" style="cursor:pointer;" target="content">Definitivos</a></p>
    <p><a href="../WorkList/PreliminaresEspecialista/PendientesPorPublicar.php?sede=<?php echo $sede ?>&usuario=<?php echo $user ?>" style="cursor:pointer;" target="content">Pendientes por Publicar</a></p>
</div>
<h3>Notas Aclaratorias</h3>
<div>
<p><a href="../NotasAclaratorias/NuevoAddemdum.php?sede=<?php echo $sede ?>&usuario=<?php echo $user ?>" style="cursor:pointer;" target="content">Registrar nota Aclaratoria</a></p>
</div>
</div>