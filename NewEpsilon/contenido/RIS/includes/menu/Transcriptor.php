<h3>Agendamiento</h3>
<div>
   <p><a href="../formularios/Agendamiento.php?usuario=<?php echo $user ?>&sede=<?php echo $sede ?>" target="content" style="cursor:pointer;">Gesti&oacute;n de Citas</a>
  </p>
  <?php
  if ($sede==1 || $sede==3)
  {
  ?>
  <p><a href="../formularios/AgendamientoHL7.php?usuario=<?php echo $user ?>&amp;sede=<?php echo $sede ?>" target="content" style="cursor:pointer;">Preagendamiento (HIS)</a>
  </p>
	<?php
	  }
	  ?>
      <p><a href="../Busqueda/BuscadorCitas.php?sede=<?php echo $sede ?>&usuario=<?php echo $user ?>" style="cursor:pointer;" target="content">Buscar cita paciente</a></p>
	  
	   <?php
  if ($sede==32)
  {
  ?>
  <p><a href="../formularios/AgendarConquis?usuario=<?php echo $user ?>&amp;sede=<?php echo $sede ?>" target="content" style="cursor:pointer;">Agendar En Conquistadores RX</a>
  </p>

  <p><a href="../formularios/AgendarConquisTomo?usuario=<?php echo $user ?>&amp;sede=<?php echo $sede ?>" target="content" style="cursor:pointer;">Agendar En Conquistadores Tomografia</a>
  </p>
	<?php
	  }
	  ?>
	  
</div>
<h3>Listas de Trabajo</h3>
<div>
	<p><a href="../WorkList/estudios/TomaEstudios.php?sede=<?php echo $sede ?>&usuario=<?php echo $user ?>&rol=<?php echo base64_encode($rol)?>" target="content" style="cursor:pointer;">Toma de estudios</a></p>
	<p><a href="../WorkList/transcripcion/TranscripcionEstudios.php?usuario=<?php echo $user ?>&sede=<?php echo $sede ?>" target="content" style="cursor:pointer;">Transcripcion</a></p>
</div>
<h3>Especialistas</h3>
<div>
	<p><a href="../Especialistas/UpdateEspecialista.php" style="cursor:pointer;" target="content">Actualizar Datos</a></p>
	<p><a href="../plantillas/CrearPlantilla.php" style="cursor:pointer;" target="content">Registrar Plantillas</a></p>
</div>
<h3>Resultados</h3>
<div>
	<!--<p><a href="../worklist/PendientesXPublicar/Resultados.php?sede=<?php echo $sede ?>&usuario=<?php echo $user ?>" style="cursor:pointer;" target="content">Preliminares</a></p>-->
	<p><a href="../worklist/PendientesXPublicar/Resultados.php?sede=<?php echo $sede ?>&usuario=<?php echo $user ?>" style="cursor:pointer;" target="content">Preliminares</a></p>
	<p><a href="../Busqueda/BuscarInforme.php?sede=<?php echo $sede ?>&usuario=<?php echo $user ?>" style="cursor:pointer;" target="content">Buscar estado de informe</a></p>
	<p><a href="../Resultados/ResultadosDefinitivos.php?sede=<?php echo $sede ?>&usuario=<?php echo $user ?>" style="cursor:pointer;" target="content">Definitivos</a></p>
</div>
<h3>Otras tareas</h3>
<div>
	<p><a href="../Pacientes/UpdateDatosPaciente.php" style="cursor:pointer;" target="content">Modificar informacion del paciente</a></p>
    	<p><a href="../auditoriaAux/Home.php?sede=<?php echo $sede ?>&usuario=<?php echo $user ?>" style="cursor:pointer;" target="content">Auditoria</a></p>
</div>
<h3>Base de datos de pacientes</h3>
<div>
    <p><a href="../BdPacientes/BdPacientesAtendidos.php" style="cursor:pointer;" target="content">Descargar base de datos</a></p>
</div>