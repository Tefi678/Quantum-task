<?php
session_start();
require 'vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");
$database = $client->Quantum;
$notificacionesCollection = $database->notificaciones;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

include 'header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style7.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Notificaciones</title>
</head>
<body>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <ul class="cbp_tmtimeline">
                    <?php foreach ($notificaciones as $notificacion): ?>
                        <li>
                            <time class="cbp_tmtime" datetime="<?= $notificacion['fecha']->toDateTime()->format('Y-m-d H:i') ?>">
                                <span><?= $notificacion['fecha']->toDateTime()->format('H:i') ?></span>
                                <span><?= $notificacion['fecha']->toDateTime()->format('d/m/Y') ?></span>
                            </time>
                            <div class="cbp_tmicon bg-info"><i class="zmdi zmdi-label"></i></div>
                            <div class="cbp_tmlabel">
                                <h2><?= htmlspecialchars($notificacion['descripcion']) ?></h2>
                                <p><?= htmlspecialchars($notificacion['tipo']) ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
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
