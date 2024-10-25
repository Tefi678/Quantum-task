<?php
session_start();

require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->Quantum->proyectos;

if (!isset($_SESSION['user_id'])) {
    echo "No has iniciado sesión. Por favor, inicia sesión primero.";
    header("refresh:2;url=login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : null;
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : null;
    $n_colaboradores = isset($_POST['n_colaboradores']) ? (int)$_POST['n_colaboradores'] : 0;

    if ($titulo && $descripcion && $n_colaboradores > 0) {
        $encargado = $_SESSION['user_id'];
        $n_tareas = 0;

        $nuevo_proyecto = [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'encargado' => $encargado,
            'n_colaboradores' => $n_colaboradores,
            'n_tareas' => $n_tareas,
            'fecha_creacion' => new MongoDB\BSON\UTCDateTime()
        ];

        try {
            $insertOneResult = $collection->insertOne($nuevo_proyecto);

            if ($insertOneResult->getInsertedCount() == 1) {
                $message = "Proyecto registrado con éxito. ID del proyecto: " . $insertOneResult->getInsertedId();
                $alert_class = "alert-success";
            } else {
                $message = "Error al registrar el proyecto.";
                $alert_class = "alert-danger";
            }
        } catch (Exception $e) {
            $message = "Error de conexión o en la base de datos: " . $e->getMessage();
            $alert_class = "alert-danger";
        }
    } else {
        $message = "Por favor, completa todos los campos y asegúrate de que el número de colaboradores sea mayor a 0.";
        $alert_class = "alert-warning";
    }
} else {
    $message = "Método de solicitud no permitido.";
    $alert_class = "alert-danger";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Registro de Proyecto</title>
</head>
<body>
    <div class="container mt-5">
        <div class="alert <?php echo $alert_class; ?>" role="alert">
            <?php echo $message; ?>
        </div>
        <a href="dashboard.php" class="btn btn-primary">Volver al Panel</a>
    </div>
</body>
</html>
