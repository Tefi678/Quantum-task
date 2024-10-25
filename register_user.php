<?php
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->Quantum->usuarios;

session_start();

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$edad = (int)$_POST['edad'];
$ci = $_POST['ci'];
$profesion = $_POST['profesion'];
$email = $_POST['email'];
$password = $_POST['password'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];

$message = "";
$alert_class = "";

if ($nombre && $apellido && $edad && $ci && $profesion && $email && $password && $fecha_nacimiento) {
    $nuevo_usuario = [
        'nombre' => $nombre,
        'apellido' => $apellido,
        'edad' => $edad,
        'ci' => $ci,
        'profesion' => $profesion,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT), // Hashear contraseña
        'fecha_nacimiento' => $fecha_nacimiento
    ];

    $insertOneResult = $collection->insertOne($nuevo_usuario);

    if ($insertOneResult->getInsertedCount() == 1) {
        $_SESSION['user_id'] = $insertOneResult->getInsertedId();
        $_SESSION['user_email'] = $email;

        header("Location: login.php");
        exit();
    } else {
        $message = "Error al registrar el usuario.";
        $alert_class = "alert-danger";
    }
} else {
    $message = "Por favor, completa todos los campos.";
    $alert_class = "alert-warning";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Registro</title>
</head>
<body>
    <div class="container mt-5">
        <?php if ($message): ?>
            <div class="alert <?= $alert_class ?>" role="alert">
                <?= $message ?>
            </div>
        <?php endif; ?>
        <a href="login.php" class="btn btn-primary mt-3">Volver al Inicio de Sesión</a>
    </div>
</body>
</html>
