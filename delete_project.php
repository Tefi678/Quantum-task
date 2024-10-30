<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collectionProyectos = $client->Quantum->proyectos;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['project_id'])) {
    $projectId = $_POST['project_id'];

    $projectObjectId = new MongoDB\BSON\ObjectId($projectId);
    
    $result = $collectionProyectos->deleteOne(['_id' => $projectObjectId]);

    if ($result->getDeletedCount() > 0) {
        header("Location: proyectos.php?msg=Proyecto eliminado con éxito");
        exit();
    } else {
        header("Location: proyectos.php?msg=Error al eliminar el proyecto");
        exit();
    }
} else {
    header("Location: proyectos.php");
    exit();
}
