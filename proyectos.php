<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collectionProyectos = $client->Quantum->proyectos;

// Comprobar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirigir al login si no está autenticado
    exit();
}

// Obtener el ID del usuario logueado desde la sesión
$userId = $_SESSION['user_id'];

// Convertir el ID del usuario a ObjectId de MongoDB
$userObjectId = new MongoDB\BSON\ObjectId($userId);

// Buscar proyectos en los que el usuario es encargado
$cursor = $collectionProyectos->find([
    'encargado' => $userObjectId
]);

// Convertir cursor a un array para evitar problemas al iterar o contar
$proyectos = iterator_to_array($cursor);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Proyectos</title>
    <?php include 'header.html'; ?>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="align-items-center row">
                    <div class="col-lg-8">
                        <div class="mb-3 mb-lg-0">
                            <h6 class="fs-16 mb-0">Showing 1 – 8 of <?= count($proyectos) ?> results</h6>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="candidate-list-widgets">
                            <div class="row">
                                <div class="col-lg-6">
                                    <a class="nav-link" href="new_project.php">Nuevo Proyecto<span class="sr-only">(current)</span></a>
                                </div>
                                <div class="col-lg-6">
                                    <div class="selection-widget">
                                        <select class="form-select" data-trigger="true" name="choices-single-filter-orderby" id="choices-single-filter-orderby" aria-label="Default select example">
                                            <option value="df">Default</option>
                                            <option value="ne">Newest</option>
                                            <option value="od">Oldest</option>
                                            <option value="rd">Random</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="selection-widget mt-2 mt-lg-0">
                                        <select class="form-select" data-trigger="true" name="choices-candidate-page" id="choices-candidate-page" aria-label="Default select example">
                                            <option value="df">All</option>
                                            <option value="ne">8 per Page</option>
                                            <option value="ne">12 per Page</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="candidate-list">
                    <?php foreach ($proyectos as $proyecto): ?>
                        <div class="candidate-list-box card mt-4">
                            <div class="p-4 card-body">
                                <div class="align-items-center row">
                                    <div class="col-auto">
                                        <div class="candidate-list-images">
                                            <a href="#"><img src="./images/atom.png" alt="" class="avatar-md img-thumbnail rounded-circle" /></a>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="candidate-list-content mt-3 mt-lg-0">
                                            <h5 class="fs-19 mb-0">
                                                <a class="primary-link" href="project.php?id=<?= $proyecto['_id'] ?>"><?= $proyecto['titulo'] ?></a>
                                                <?php if ((string)$proyecto['encargado'] === (string)$userObjectId): ?>
                                                    <span class="badge bg-success ms-1">Encargado</span>
                                                <?php endif; ?>
                                            </h5>
                                            <p class="text-muted mb-2"><?= $proyecto['descripcion'] ?></p>
                                            <ul class="list-inline mb-0 text-muted">
                                                <li class="list-inline-item"><i class="mdi mdi-map-marker"></i> <?= $proyecto['ubicacion'] ?? 'Sin ubicación' ?></li>
                                                <li class="list-inline-item"><i class="mdi mdi-calendar"></i> <?= $proyecto['fecha_inicio'] ?? 'Sin fecha' ?></li>
                                            </ul>
                                        </div>
                                        <div class="col-auto">
                                            <div class="candidate-list-images">
                                                <a href="project.php?id=<?= $proyecto['_id'] ?>"><img src="./images/atom.png" alt="" class="avatar-md img-thumbnail rounded-circle" /></a>
                                            </div>
                                        </div>
                                    </div>
                                <div class="favorite-icon">
                                    <a href="#"><i class="mdi mdi-heart fs-18"></i></a>
                                </div>
                            </div>
                            <form action="delete_project.php" method="POST" class="mt-3">
                                <input type="hidden" name="project_id" value="<?= $proyecto['_id'] ?>">
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="mt-4 pt-2 col-lg-12">
                <nav aria-label="Page navigation example">
                    <div class="pagination job-pagination mb-0 justify-content-center">
                        <!-- Aquí se puede implementar paginación en el futuro -->
                    </div>
                </nav>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
