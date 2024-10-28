<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collectionProyectos = $client->Quantum->proyectos;
$collectionTareas = $client->Quantum->tareas;
$collectionUsuarios = $client->Quantum->usuarios;

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener el ID del proyecto de la URL
$projectId = new MongoDB\BSON\ObjectId($_GET['id']);

// Verificar si el proyecto existe y si el usuario es responsable o colaborador
$proyecto = $collectionProyectos->findOne(['_id' => $projectId, '$or' => [
    ['responsable' => new MongoDB\BSON\ObjectId($_SESSION['user_id'])],
    ['colaboradores' => new MongoDB\BSON\ObjectId($_SESSION['user_id'])]
]]);
if (!$proyecto) {
    echo "No tienes permiso para agregar tareas a este proyecto.";
    exit();
}

// Obtener la lista de usuarios disponibles en el proyecto (responsable y colaboradores)
$usuariosProyecto = $collectionUsuarios->find([
    '_id' => ['$in' => array_merge(
        [$proyecto['responsable']],
        $proyecto['colaboradores'] ?? []
    )]
]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $progreso = (int) $_POST['progreso'];
    $fechaLimite = new MongoDB\BSON\UTCDateTime(strtotime($_POST['fecha_limite']) * 1000);
    $involucrados = array_map(function($id) {
        return new MongoDB\BSON\ObjectId($id);
    }, $_POST['involucrados']);

    // Crear nueva tarea en la base de datos
    $collectionTareas->insertOne([
        'nombre' => $nombre,
        'descripcion' => $descripcion,
        'progreso' => $progreso,
        'fecha_limite' => $fechaLimite,
        'proyecto' => $projectId,
        'involucrados' => $involucrados
    ]);

    header("Location: ver_proyecto.php?id={$projectId}&msg=Tarea creada exitosamente.");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style5.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Registrar nueva Tarea</title>
    <?php include 'header.php'; ?>
</head>
<body>
    <div class="container">
        <div class="col-md-8 offset-md-2">
            <div class="card mt-5">
                <div class="card-header">
                    <h4>Registrar nueva Tarea</h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="form-group">
                            <label for="nombre">Nombre de la Tarea</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="progreso">Progreso Inicial (%)</label>
                            <input type="number" class="form-control" name="progreso" id="progreso" min="0" max="100" value="0" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha_limite">Fecha Límite</label>
                            <input type="date" class="form-control" name="fecha_limite" id="fecha_limite" required>
                        </div>
                        <div class="form-group">
                            <label for="involucrados">Involucrados</label>
                            <select class="form-control" name="involucrados[]" id="involucrados" multiple required>
                                <?php foreach ($usuariosProyecto as $usuario): ?>
                                    <option value="<?= $usuario['_id'] ?>">
                                        <?= htmlspecialchars($usuario['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Registrar Tarea</button>
                        <a href="ver_proyecto.php?id=<?= $projectId ?>" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<footer>
    <?php include 'footer.html'; ?>
</footer>
</html>
