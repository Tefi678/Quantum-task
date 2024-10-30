<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collectionProyectos = $client->Quantum->proyectos;
$collectionTareas = $client->Quantum->tareas;
$collectionUsuarios = $client->Quantum->usuarios;
$collectionUsuariosProyectos = $client->Quantum->usuarios_proyectos;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$taskId = new MongoDB\BSON\ObjectId($_GET['id']);
$tarea = $collectionTareas->findOne(['_id' => $taskId]);

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

if (!$proyecto) {
    echo "No tienes permiso para editar esta tarea.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $progreso = (int) $_POST['progreso'];
    $fechaLimite = new MongoDB\BSON\UTCDateTime(strtotime($_POST['fecha_limite']) * 1000);

    $collectionTareas->updateOne(
        ['_id' => $taskId],
        ['$set' => [
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'progreso' => $progreso,
            'fecha_limite' => $fechaLimite,
        ]]
    );

    header("Location: ver_proyecto.php?id={$projectId}&msg=Tarea actualizada exitosamente.");
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
    <title>Editar Tarea</title>
    <?php include 'header.php'; ?>
</head>
<body>
    <div class="container">
        <div class="col-md-8 offset-md-2">
            <div class="card mt-5">
                <div class="card-header">
                    <h4>Editar Tarea</h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="form-group">
                            <label for="nombre">Nombre de la Tarea</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" value="<?= htmlspecialchars($tarea['nombre']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" rows="4" required><?= htmlspecialchars($tarea['descripcion']) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="progreso">Progreso (%)</label>
                            <input type="number" class="form-control" name="progreso" id="progreso" min="0" max="100" value="<?= htmlspecialchars($tarea['progreso']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha_limite">Fecha Límite</label>
                            <input type="date" class="form-control" name="fecha_limite" id="fecha_limite" value="<?= htmlspecialchars($tarea['fecha_limite']->toDateTime()->format('Y-m-d')) ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar Tarea</button>
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
