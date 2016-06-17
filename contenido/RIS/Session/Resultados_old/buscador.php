<?php
include_once 'pacientes.class.php';
$usuario = new Pacientes();
echo json_encode($usuario->buscarPacientes($_GET['term']));
