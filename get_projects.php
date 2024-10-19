<?php
require 'conexion.php';

header('Content-Type: application/json');

$proyectosCollection = $db->proyectos; // Colección para proyectos
$projects = $proyectosCollection->find()->toArray();

echo json_encode($projects);
?>
