<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collectionUsuarios = $client->Quantum->usuarios;
$notificacionesCollection = $client->Quantum->notificaciones;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = new MongoDB\BSON\ObjectId($_SESSION['user_id']);

function registrarActividad($user_id, $descripcion, $tipo) {
    global $notificacionesCollection;
    $actividad = [
        'user_id' => $user_id,
        'descripcion' => $descripcion,
        'fecha' => new MongoDB\BSON\UTCDateTime(),
        'tipo' => $tipo,
    ];
    $notificacionesCollection->insertOne($actividad);
}

$notificaciones = $notificacionesCollection->find(['user_id' => $userId], ['sort' => ['fecha' => -1]]);

function buscarUsuarios($nombre) {
    global $collectionUsuarios;

    $resultados = $collectionUsuarios->find([
        'nombre' => new MongoDB\BSON\Regex($nombre, 'i')
    ])->toArray();

    return array_map(function ($usuario) {
        return [
            '_id' => (string) $usuario['_id'],
            'nombre' => $usuario['nombre'],
            'foto' => $usuario['foto']
        ];
    }, $resultados);
}

if (isset($_POST['add_friend'])) {
    $amigoId = new MongoDB\BSON\ObjectId($_POST['friend_id']);
    $amigo = $collectionUsuarios->findOne(['_id' => $amigoId]);

    $usuario = $collectionUsuarios->findOne(['_id' => $userId]);
    $amigos = isset($usuario['friends']) ? iterator_to_array($usuario['friends']) : [];
    
    if (!in_array($amigoId, $amigos)) {
        if (empty($amigos)) {
            $collectionUsuarios->updateOne(
                ['_id' => $userId],
                [
                    '$set' => ['friends' => [$amigoId]],
                    '$inc' => ['amigos' => 1]
                ]
            );
        } else {
            $collectionUsuarios->updateOne(
                ['_id' => $userId],
                [
                    '$addToSet' => ['friends' => $amigoId],
                    '$inc' => ['amigos' => 1]
                ]
            );
        }
        // Register activity for adding a friend
        registrarActividad($userId, 'Agregó a ' . $amigo['nombre'], 'Agregar amigo');
    }
    header("Location: friends.php");
    exit();
}

if (isset($_POST['remove_friend'])) {
    $amigoId = new MongoDB\BSON\ObjectId($_POST['friend_id']);
    $amigo = $collectionUsuarios->findOne(['_id' => $amigoId]);

    $usuario = $collectionUsuarios->findOne(['_id' => $userId]);

    if (isset($usuario['friends']) && in_array($amigoId, iterator_to_array($usuario['friends']))) {
        $collectionUsuarios->updateOne(
            ['_id' => $userId],
            [
                '$pull' => ['friends' => $amigoId],
                '$inc' => ['amigos' => -1]
            ]
        );
        // Register activity for removing a friend
        registrarActividad($userId, 'Eliminó a ' . $amigo['nombre'], 'Eliminar amigo');
    }
    header("Location: friends.php");
    exit();
}

$usuarioActual = $collectionUsuarios->findOne(['_id' => $userId]);
$amigosActuales = isset($usuarioActual['friends']) ? iterator_to_array($usuarioActual['friends']) : [];

$usuarios = [];
if (isset($_GET['nombre'])) {
    $nombre = trim($_GET['nombre']);
    $usuarios = buscarUsuarios($nombre);
}

$detallesAmigos = [];
if (!empty($amigosActuales)) {
    $detallesAmigos = $collectionUsuarios->find([
        '_id' => ['$in' => $amigosActuales]
    ])->toArray();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style9.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Gestor de Amigos</title>
    <?php include 'header.php'; ?>
</head>
<body>
    <div class="container">
        <h2 style="color: white">Buscar Amigos</h2>
        <form method="GET" action="">
            <input type="text" name="nombre" placeholder="Buscar por nombre" required>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <h2 class="mt-4" style="color: white">Tus Amigos</h2>
        <div class="row mt-2">
            <?php foreach ($detallesAmigos as $amigo): ?>
                <div class="col-md-6 col-xl-4">
                    <div class="card">
                        <div class="card-body p-4 d-flex align-items-center gap-3">
                            <img src="<?= htmlspecialchars($amigo['foto']) ?>" alt="" class="rounded-circle" width="40" height="40">
                            <div>
                                <h5 class="fw-semibold mb-0"><?= htmlspecialchars($amigo['nombre']) ?></h5>
                                <form method="POST" action="">
                                    <input type="hidden" name="friend_id" value="<?= $amigo['_id'] ?>">
                                    <button type="submit" name="remove_friend" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="row mt-2">
            <h2 class="mt-4" style="color: white">Resultados de Búsqueda</h2>
            <?php foreach ($usuarios as $usuario): ?>
                <div class="col-md-6 col-xl-4">
                    <div class="card">
                        <div class="card-body p-4 d-flex align-items-center gap-3">
                            <img src="<?= htmlspecialchars($usuario['foto']) ?>" alt="" class="rounded-circle" width="40" height="40">
                            <div>
                                <h5 class="fw-semibold mb-0"><?= htmlspecialchars($usuario['nombre']) ?></h5>
                                <form method="POST" action="">
                                    <input type="hidden" name="friend_id" value="<?= $usuario['_id'] ?>">
                                    <button type="submit" name="add_friend" class="btn btn-success">Agregar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.2.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<footer>
    <?php include 'footer.html'; ?>
</footer>
</html>
