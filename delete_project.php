<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collectionProyectos = $client->Quantum->proyectos;

// Comprobar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirigir al login si no está autenticado
    exit();
}

// Verificar si se ha enviado el ID del proyecto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['project_id'])) {
    $projectId = $_POST['project_id'];

    // Convertir el ID a ObjectId de MongoDB
    $projectObjectId = new MongoDB\BSON\ObjectId($projectId);

    // Eliminar el proyecto
    $result = $collectionProyectos->deleteOne(['_id' => $projectObjectId]);

    if ($result->getDeletedCount() > 0) {
        // Redirigir a la lista de proyectos con un mensaje de éxito
        header("Location: proyectos.php?msg=Proyecto eliminado con éxito");
        exit();
    } else {
        // Redirigir a la lista de proyectos con un mensaje de error
        header("Location: proyectos.php?msg=Error al eliminar el proyecto");
        exit();
    }
} else {
    // Redirigir a la lista de proyectos si no se recibió el ID
    header("Location: proyectos.php");
    exit();
}
