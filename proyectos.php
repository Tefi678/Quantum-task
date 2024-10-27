<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collectionProyectos = $client->Quantum->proyectos;
$collectionUsuariosProyectos = $client->Quantum->usuarios_proyectos;

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirigir al login si no está autenticado
    exit();
}

$userId = $_SESSION['user_id'];
$userObjectId = new MongoDB\BSON\ObjectId($userId);

// Obtener la consulta de búsqueda si existe
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

// Buscar proyectos asociados al usuario
$proyectosUsuarioCursor = $collectionUsuariosProyectos->find([
    'id_user' => $userObjectId
]);

// Obtener todos los IDs de proyectos asociados al usuario
$proyectoIds = [];
foreach ($proyectosUsuarioCursor as $proyectoUsuario) {
    $proyectoIds[] = new MongoDB\BSON\ObjectId($proyectoUsuario['id_proyecto']);
}

// Si hay proyectos asociados, buscar sus datos en la colección de proyectos
$proyectos = [];
if (!empty($proyectoIds)) {
    // Filtrar por título si hay una búsqueda
    $filter = ['_id' => ['$in' => $proyectoIds]];
    if ($searchQuery) {
        $filter['titulo'] = new MongoDB\BSON\Regex($searchQuery, 'i'); // Búsqueda insensible a mayúsculas
    }
    $cursor = $collectionProyectos->find($filter);

    // Convertir cursor a un array para evitar problemas al iterar o contar
    $proyectos = iterator_to_array($cursor);
}

// Eliminar proyecto
if (isset($_POST['eliminar'])) {
    $proyectoId = new MongoDB\BSON\ObjectId($_POST['proyecto_id']);
    // Obtener información del proyecto para verificar el encargado
    $infoProyecto = $collectionProyectos->findOne(['_id' => $proyectoId]);

    // Verificar que el encargado sea el usuario logueado
    if ($infoProyecto && (string)$infoProyecto['responsable'] === (string)$userObjectId) {
        // Eliminar el proyecto de la colección proyectos
        $collectionProyectos->deleteOne(['_id' => $proyectoId]);
        // Eliminar las asociaciones de usuarios_proyectos
        $collectionUsuariosProyectos->deleteMany(['id_proyecto' => $proyectoId]);
    }
    // Redirigir para evitar reenvío de formulario
    header("Location: proyectos.php");
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
    <title>Mis Proyectos</title>
    <?php include 'header.php'; ?>
</head>
<body>
    <div class="container">
        <h3 class="mt-4">Mis Proyectos</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Etiqueta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($proyectos)): ?>
                    <tr>
                        <td colspan="4">No tienes proyectos asignados.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($proyectos as $proyecto): ?>
                        <tr>
                            <td><a href="ver_proyecto.php?id=<?php echo $proyecto['_id']; ?>"><?php echo htmlspecialchars($proyecto['titulo']); ?></a></td>
                            <td><?php echo htmlspecialchars($proyecto['descripcion']); ?></td>
                            <td><?php echo htmlspecialchars($proyecto['etiqueta']); ?></td>
                            <td>
                                <?php if ((string)$proyecto['responsable'] === (string)$userObjectId): ?>
                                    <form action="proyectos.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="proyecto_id" value="<?php echo $proyecto['_id']; ?>" />
                                        <button type="submit" name="eliminar" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-muted">No puedes eliminar este proyecto</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="new_project.php" class="btn btn-primary">Crear Nuevo Proyecto</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<footer>
    <?php include 'footer.html'; ?>
</footer>
</html>
