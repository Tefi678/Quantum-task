<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collectionProyectos = $client->Quantum->proyectos;
$collectionUsuarios = $client->Quantum->usuarios;
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

$proyectos = [];
if (!empty($proyectoIds)) {
    $filter = ['_id' => ['$in' => $proyectoIds]];
    if ($searchQuery) {
        $filter['titulo'] = new MongoDB\BSON\Regex($searchQuery, 'i');
    }
    $cursor = $collectionProyectos->find($filter);

    $proyectos = iterator_to_array($cursor);
}

if (isset($_POST['eliminar'])) {
    $proyectoId = new MongoDB\BSON\ObjectId($_POST['proyecto_id']);
    $infoProyecto = $collectionProyectos->findOne(['_id' => $proyectoId]);

    if ($infoProyecto && (string)$infoProyecto['responsable'] === (string)$userObjectId) {
        $collectionProyectos->deleteOne(['_id' => $proyectoId]);
        $collectionUsuariosProyectos->deleteMany(['id_proyecto' => $proyectoId]);
    }
    header("Location: proyectos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style4.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Mis Proyectos</title>
    <?php include 'header.php'; ?>
</head>
<body>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container mt-4">
    <div class="row">
        <h1 style= "color: #ffffff">    Proyectos en los que trabajas   <a href="new_project.php" class="btn btn-outline-light btn-lg">Crear Nuevo Proyecto</a></h1>
        <h1></h1>
    </div>
    <div class="row">
        <?php if (empty($proyectos)): ?>
            <div class="col-12">
                <div class="alert alert-info">No tienes proyectos asignados.</div>
            </div>
        <?php else: ?>
            <?php foreach ($proyectos as $proyecto): ?>
                <?php
                $responsableId = $proyecto['responsable'];
                $usuarioResponsable = $collectionUsuarios->findOne(['_id' => new MongoDB\BSON\ObjectId($responsableId)]);
                $nombreResponsable = $usuarioResponsable ? htmlspecialchars($usuarioResponsable['nombre']) : 'Desconocido';
                $fotoResponsable = $usuarioResponsable ? htmlspecialchars($usuarioResponsable['foto']) : 'Desconocido';

                $colaboradoresCount = $collectionUsuariosProyectos->countDocuments(['id_proyecto' => $proyecto['_id']]);
                $fechaCreacion = date("d/m/Y", strtotime($proyecto['fecha_creacion']));
                ?>
                <div class="col-lg-4 col-12 mb-5">
                    <div class="card rounded-3">
                        <img src="<?php echo htmlspecialchars($proyecto['imagen']); ?>" alt="Image" class="img-fluid rounded-top">
                        <div class="avatar avatar-sm mt-n7 ms-4">
                            <img src="<?php echo $fotoResponsable; ?>" alt="Image" class="rounded-circle border-4 border-white-color-40" style="width: 50px; height: 50px;">
                        </div>
                        <div class="card-body">
                            <h4 class="mb-1"><?php echo htmlspecialchars($proyecto['titulo']); ?></h4>
                            <p><?php echo htmlspecialchars($proyecto['descripcion']); ?></p>
                            <p>Creado por: <?php echo $nombreResponsable; ?></p>
                            <p>N° de Colaboradores: <?php echo $colaboradoresCount; ?></p>
                            <p>Creado el: <?php echo $fechaCreacion; ?></p>
                            <span class="badge badge-secondary"><?php echo htmlspecialchars($proyecto['etiqueta']); ?></span>
                            <div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <a href="ver_proyecto.php?id=<?php echo $proyecto['_id']; ?>" class="btn btn-outline-primary">Ir a proyecto</a>
                                    <?php if ((string)$proyecto['responsable'] === (string)$userObjectId): ?>
                                        <a href="editar_proyecto.php?id=<?php echo $proyecto['_id']; ?>" class="btn btn-outline-secondary">Editar</a>
                                        <form action="proyectos.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="proyecto_id" value="<?php echo $proyecto['_id']; ?>" />
                                            <button type="submit" name="eliminar" class="btn btn-outline-danger">Eliminar</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-muted">No eres el responsable</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
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
