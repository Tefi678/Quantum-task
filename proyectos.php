<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collectionProyectos = $client->Quantum->proyectos;
$collectionUsuariosProyectos = $client->Quantum->usuarios_proyectos;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$userObjectId = new MongoDB\BSON\ObjectId($userId);

$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

$proyectosUsuarioCursor = $collectionUsuariosProyectos->find([
    'id_user' => $userObjectId
]);

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
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="main-box clearfix">
                <div class="table-responsive">
                    <table class="table user-list">
                        <thead>
                            <tr>
                                <th><span>Project</span></th>
                                <th><span>Description</span></th>
                                <th class="text-center"><span>Tag</span></th>
                                <th class="text-center"><span>Actions</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($proyectos)): ?>
                                <tr>
                                    <td colspan="4" class="text-center">No tienes proyectos asignados.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($proyectos as $proyecto): ?>
                                    <tr>
                                        <td>
                                            <a href="ver_proyecto.php?id=<?php echo $proyecto['_id']; ?>" class="user-link">
                                                <?php echo htmlspecialchars($proyecto['titulo']); ?>
                                            </a>
                                            <span class="user-subhead">Responsable: <?php echo htmlspecialchars($proyecto['responsable']); ?></span>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($proyecto['descripcion']); ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="label label-info"><?php echo htmlspecialchars($proyecto['etiqueta']); ?></span>
                                        </td>
                                        <td class="text-center" style="width: 20%;">
                                            <?php if ((string)$proyecto['responsable'] === (string)$userObjectId): ?>
                                                <a href="editar_proyecto.php?id=<?php echo $proyecto['_id']; ?>" class="table-link">
                                                    <span class="fa-stack">
                                                        <i class="fa fa-square fa-stack-2x"></i>
                                                        <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                                    </span>
                                                </a>
                                                <form action="proyectos.php" method="POST" style="display:inline;">
                                                    <input type="hidden" name="proyecto_id" value="<?php echo $proyecto['_id']; ?>" />
                                                    <button type="submit" name="eliminar" class="table-link danger" style="border: none; background: none;">
                                                        <span class="fa-stack">
                                                            <i class="fa fa-square fa-stack-2x"></i>
                                                            <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                                        </span>
                                                    </button>
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
