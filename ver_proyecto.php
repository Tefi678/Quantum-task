<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collectionTareas = $client->Quantum->tareas;
$collectionUsuariosTareas = $client->Quantum->usuarios_tareas; // Colección para asociar usuarios a tareas
$collectionProyectos = $client->Quantum->proyectos;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirigir al login si no está autenticado
    exit();
}

$userId = $_SESSION['user_id'];
$userObjectId = new MongoDB\BSON\ObjectId($userId);

// Obtener el ID del proyecto desde la URL
if (!isset($_GET['id']) || !preg_match('/^[0-9a-f]{24}$/', $_GET['id'])) {
    echo "ID de proyecto inválido.";
    exit();
}

$proyectoId = new MongoDB\BSON\ObjectId($_GET['id']);

// Registrar una nueva tarea
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'] ?? 'Sin título';
    $descripcion = $_POST['descripcion'] ?? 'Sin descripción';
    $fecha_fin = $_POST['fecha_fin'] ?? null;
    $prioridad = $_POST['prioridad'] ?? 'Baja';
    $estado = $_POST['estado'] ?? 'Pendiente';
    
    // Crear el nuevo registro de tarea
    $nuevaTarea = [
        'titulo' => $titulo,
        'descripcion' => $descripcion,
        'fecha_fin' => $fecha_fin,
        'prioridad' => $prioridad,
        'estado' => $estado,
        'proyecto' => $proyectoId,
        'responsable' => $userObjectId // Asigna el responsable
    ];

    // Insertar la nueva tarea en la colección
    $resultado = $collectionTareas->insertOne($nuevaTarea);
    $tareaId = $resultado->getInsertedId();

    // Crear el registro en la colección usuarios_tareas
    $collectionUsuariosTareas->insertOne([
        'id_user' => $userObjectId,
        'id_tarea' => $tareaId
    ]);

    // Redirigir a la página de tareas después de crear la nueva tarea
    header("Location: tareas.php?id=" . htmlspecialchars($proyectoId));
    exit();
}

// Obtener las tareas del proyecto
$tareas = $collectionTareas->find(['proyecto' => $proyectoId]);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style4.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Registrar nueva Tarea</title>
    <?php include 'header.php'; ?>
</head>
<body>
    <div class="container register">
        <div class="row">
            <div class="col-md-9 register-right">
                <form action="new_task.php?id=<?= htmlspecialchars($proyectoId) ?>" method="POST">
                    <h3 class="register-heading">Registrar nueva Tarea</h3>
                    <div class="row register-form">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="titulo" placeholder="Título" required />
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="descripcion" placeholder="Descripción" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="fecha_fin">Fecha Límite:</label>
                                <input type="date" class="form-control" name="fecha_fin" required />
                            </div>
                            <div class="form-group">
                                <label for="prioridad">Prioridad:</label>
                                <select class="form-control" name="prioridad" required>
                                    <option value="Baja">Baja</option>
                                    <option value="Media">Media</option>
                                    <option value="Alta">Alta</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado:</label>
                                <select class="form-control" name="estado" required>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="En progreso">En progreso</option>
                                    <option value="Completada">Completada</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Crear Tarea" />
                </form>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <h2>Tareas del Proyecto</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Fecha Límite</th>
                    <th>Prioridad</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tareas as $tarea): ?>
                    <tr>
                        <td><?= htmlspecialchars($tarea['titulo']) ?></td>
                        <td><?= htmlspecialchars($tarea['descripcion']) ?></td>
                        <td><?= htmlspecialchars($tarea['fecha_fin']) ?></td>
                        <td><?= htmlspecialchars($tarea['prioridad']) ?></td>
                        <td><?= htmlspecialchars($tarea['estado']) ?></td>
                        <td>
                            <a href="editar_tarea.php?id=<?= $tarea['_id'] ?>" class="btn btn-warning">Editar</a>
                            <form action="eliminar_tarea.php" method="POST" style="display:inline;">
                                <input type="hidden" name="tarea_id" value="<?= $tarea['_id'] ?>" />
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<footer>
    <?php include 'footer.html'; ?>
</footer>
</html>
