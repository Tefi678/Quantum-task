<?php
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->Quantum->proyectos;

$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$encargado = 1;
$n_colaboradores = 1;
$n_tareas = 0;

if ($titulo && $descripcion && $encargado && $n_colaboradores && $n_tareas) {
    $nuevo_proyecto = [
        'titulo' => $titulo,
        'descripcion' => $descripcion,
        'encargado' => $encargado,
        'n_colaboradores' => $n_colaboradores,
        'n_tareas' => $n_tareas
    ];

    $insertOneResult = $collection->insertOne($nuevo_proyecto);

    if ($insertOneResult->getInsertedCount() == 1) {
        $message = "Registro exitoso. ID del nuevo proyecto: " . $insertOneResult->getInsertedId();
        $alert_class = "alert-success";
    } else {
        $message = "Error al registrar el proyecto.";
        $alert_class = "alert-danger";
    }
} else {
    $message = "Por favor, completa todos los campos.";
    $alert_class = "alert-warning";
}
?>