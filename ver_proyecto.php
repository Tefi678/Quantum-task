<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collectionProyectos = $client->Quantum->proyectos;
$collectionTareas = $client->Quantum->tareas;
$collectionUsuarios = $client->Quantum->usuarios;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$projectId = new MongoDB\BSON\ObjectId($_GET['id']);

$proyecto = $collectionProyectos->findOne(['_id' => $projectId]);
$tareas = $collectionTareas->find(['proyecto' => $projectId]);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagenFondo'])) {
    $fileTmp = $_FILES['imagenFondo']['tmp_name'];
    $fileName = 'images/' . $_FILES['imagenFondo']['name'];
    move_uploaded_file($fileTmp, $fileName);
    $imagenFondo = $fileName;
} else {
    $imagenFondo = $proyecto['imagen'] ?? 'images/default_background.jpg';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style5.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Ver Tareas del Proyecto</title>
    <?php include 'header.php'; ?>
    <style>
        body {
            background: url('<?= $imagenFondo ?>') no-repeat center center fixed;
            background-size: cover;
        }
        .card {
            background-color: white;
        }
    </style>
</head>
<body>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />

<div class="container">
    <div class="col-md-12 col-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4><?= htmlspecialchars($proyecto['titulo']) ?></h4>
                <p><?= htmlspecialchars($proyecto['descripcion']) ?></p>
                <h5>Colaboradores:</h5>
                <div class="d-flex">
                    <?php
                    if (isset($proyecto['colaboradores'])) {
                        foreach ($proyecto['colaboradores'] as $colaboradorId) {
                            $colaborador = $collectionUsuarios->findOne(['_id' => new MongoDB\BSON\ObjectId($colaboradorId)]);
                            if ($colaborador && isset($colaborador['foto'])) {
                                echo "<img src='{$colaborador['foto']}' class='rounded-circle mr-2' alt='Colaborador' width='50' height='50' />";
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Involucrados</th>
                                <th>Nombre de la Tarea</th>
                                <th>Progreso</th>
                                <th>Fecha Límite</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tareas as $tarea): ?>
                                <tr>
                                    <td class="text-center">
                                        <?php
                                        if (isset($tarea['involucrados'])) {
                                            foreach ($tarea['involucrados'] as $involucradoId) {
                                                $involucrado = $collectionUsuarios->findOne(['_id' => new MongoDB\BSON\ObjectId($involucradoId)]);
                                                if ($involucrado && isset($involucrado['foto'])) {
                                                    echo "<img src='{$involucrado['foto']}' class='rounded-circle' alt='Involucrado' width='40' height='40' />";
                                                }
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td><?= htmlspecialchars($tarea['nombre']) ?></td>
                                    <td class="align-middle">
                                        <div class="progress" data-height="4" style="height: 4px;">
                                            <div class="progress-bar bg-success" style="width: <?= htmlspecialchars($tarea['progreso']) ?>%;"></div>
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($tarea['fecha_limite']->toDateTime()->format('Y-m-d')) ?></td>
                                    <td>
                                        <a href="editar_tarea.php?id=<?= $tarea['_id'] ?>" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                        <a href="eliminar_tarea.php?id=<?= $tarea['_id'] ?>" class="btn btn-danger btn-action" data-toggle="tooltip" title="Eliminar"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <a href="nueva_tarea.php?id=<?= $projectId ?>" class="btn btn-primary">
                                Registrar Nueva Tarea
                            </a>
                        </tbody>
                    </table>
                </div>
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
