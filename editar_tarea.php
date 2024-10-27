<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collectionTareas = $client->Quantum->tareas;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirigir al login si no está autenticado
    exit();
}

// Obtener el ID de la tarea desde la URL
if (!isset($_GET['id']) || !preg_match('/^[0-9a-f]{24}$/', $_GET['id'])) {
    echo "ID de tarea inválido.";
    exit();
}

$tareaId = new MongoDB\BSON\ObjectId($_GET['id']);
$tarea = $collectionTareas->findOne(['_id' => $tareaId]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Actualizar la tarea
    $updatedData = [
        'titulo' => $_POST['titulo'],
        'descripcion' => $_POST['descripcion'],
        'fecha_fin' => $_POST['fecha_fin'],
        'prioridad' => $_POST['prioridad'],
        'estado' => $_POST['estado']
    ];

    $collectionTareas->updateOne(['_id' => $tareaId], ['$set' => $updatedData]);
    
    header("Location: tareas.php?id=" . htmlspecialchars($tarea['proyecto']));
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style4.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Editar Tarea</title>
    <?php include 'header.php'; ?>
</head>
<body>
    <div class="container register">
        <div class="row">
            <div class="col-md-9 register-right">
                <form action="editar_tarea.php?id=<?= htmlspecialchars($tareaId) ?>" method="POST">
                    <h3 class="register-heading">Editar Tarea</h3>
                    <div class="row register-form">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="titulo" placeholder="Título" value="<?= htmlspecialchars($tarea['titulo']) ?>" required />
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="descripcion" placeholder="Descripción" required><?= htmlspecialchars($tarea['descripcion']) ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="fecha_fin">Fecha Límite:</label>
                                <input type="date" class="form-control" name="fecha_fin" value="<?= htmlspecialchars($tarea['fecha_fin']) ?>" required />
                            </div>
                            <div class="form-group">
                                <label for="prioridad">Prioridad:</label>
                                <select class="form-control" name="prioridad" required>
                                    <option value="Baja" <?= $tarea['prioridad'] == 'Baja' ? 'selected' : '' ?>>Baja</option>
                                    <option value="Media" <?= $tarea['prioridad'] == 'Media' ? 'selected' : '' ?>>Media</option>
                                    <option value="Alta" <?= $tarea['prioridad'] == 'Alta' ? 'selected' : '' ?>>Alta</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado:</label>
                                <select class="form-control" name="estado" required>
                                    <option value="Pendiente" <?= $tarea['estado'] == 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                    <option value="En progreso" <?= $tarea['estado'] == 'En progreso' ? 'selected' : '' ?>>En progreso</option>
                                    <option value="Completada" <?= $tarea['estado'] == 'Completada' ? 'selected' : '' ?>>Completada</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Guardar Cambios" />
                </form>
            </div>
        </div>
    </div>
</body>
<footer>
    <?php include 'footer.html'; ?>
</footer>
</html>
