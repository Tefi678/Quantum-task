<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collectionProyectos = $client->Quantum->proyectos;
$collectionTareas = $client->Quantum->tareas;

// Comprobar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirigir al login si no está autenticado
    exit();
}

// Obtener el ID del proyecto de la URL
if (!isset($_GET['id'])) {
    echo "Proyecto no encontrado";
    exit();
}

$projectId = $_GET['id'];
$projectObjectId = new MongoDB\BSON\ObjectId($projectId);

// Buscar el proyecto por su ID
$proyecto = $collectionProyectos->findOne(['_id' => $projectObjectId]);

if (!$proyecto) {
    echo "Proyecto no encontrado";
    exit();
}

// Procesar el formulario de nueva tarea
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titulo']) && isset($_POST['descripcion'])) {
    $tituloTarea = $_POST['titulo'];
    $descripcionTarea = $_POST['descripcion'];

    // Insertar nueva tarea en la colección
    $collectionTareas->insertOne([
        'proyecto_id' => $projectObjectId,
        'titulo' => $tituloTarea,
        'descripcion' => $descripcionTarea,
        'completado' => false
    ]);

    // Redirigir a la misma página para actualizar la lista de tareas y evitar reenvío de formulario
    header("Location: project.php?id=" . $projectId);
    exit();
}

// Buscar tareas relacionadas al proyecto
$tareas = $collectionTareas->find(['proyecto_id' => $projectObjectId]);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title><?= $proyecto['titulo'] ?></title>
    <?php include 'header.html'; ?>
</head>
<body>
    <div class="container">
        <h1 class="my-4"><?= $proyecto['titulo'] ?></h1>
        <p class="text-muted"><?= $proyecto['descripcion'] ?></p>

        <!-- Formulario para nueva tarea -->
        <div class="mb-4">
            <h2>Agregar nueva tarea</h2>
            <form method="post">
                <div class="form-group">
                    <label for="titulo">Título de la tarea:</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción de la tarea:</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Agregar Tarea</button>
            </form>
        </div>

        <div class="card-columns">
            <?php foreach ($tareas as $tarea): ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $tarea['titulo'] ?></h5>
                        <p class="card-text"><?= $tarea['descripcion'] ?></p>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" <?= $tarea['completado'] ? 'checked' : '' ?> disabled>
                            <label class="form-check-label">Completado</label>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
