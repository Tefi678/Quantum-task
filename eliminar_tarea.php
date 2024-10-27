<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collectionTareas = $client->Quantum->tareas;
$collectionUsuariosTareas = $client->Quantum->usuarios_tareas;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirigir al login si no está autenticado
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tarea_id'])) {
    $tareaId = new MongoDB\BSON\ObjectId($_POST['tarea_id']);
    
    // Eliminar la tarea
    $collectionTareas->deleteOne(['_id' => $tareaId]);
    
    // Eliminar la asociación de usuarios con la tarea
    $collectionUsuariosTareas->deleteMany(['id_tarea' => $tareaId]);

    // Redirigir a la página de tareas del proyecto
    header("Location: tareas.php?id=" . htmlspecialchars($_GET['id']));
    exit();
}
?>
