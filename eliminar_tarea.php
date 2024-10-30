<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collectionTareas = $client->Quantum->tareas;
$collectionProyectos = $client->Quantum->proyectos;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$tareaId = new MongoDB\BSON\ObjectId($_GET['id']);

$tarea = $collectionTareas->findOne(['_id' => $tareaId]);

if (!$tarea) {
    echo "Tarea no encontrada.";
    exit();
}

$projectId = $tarea['proyecto'];

$proyecto = $collectionProyectos->findOne([
    '_id' => $projectId,
    '$or' => [
        ['responsable' => new MongoDB\BSON\ObjectId($_SESSION['user_id'])],
        ['colaboradores' => new MongoDB\BSON\ObjectId($_SESSION['user_id'])]
    ]
]);

if (!$proyecto || $proyecto['responsable'] != $_SESSION['user_id']) {
    echo "No tienes permiso para eliminar esta tarea.";
    exit();
}

$collectionTareas->deleteOne(['_id' => $tareaId]);

header("Location: ver_proyecto.php?id={$projectId}&msg=Tarea eliminada exitosamente.");
exit();
?>
