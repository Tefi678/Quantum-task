<?php
session_start(); // Asegúrate de que la sesión esté iniciada

require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->Quantum->usuarios;

// Si el usuario ya está autenticado, redirigir al dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Variables para el mensaje y la clase de alerta
$message = "";
$alert_class = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email_name = $_POST['user'];
    $password = $_POST['password'];

    // Buscar al usuario por email o nombre de usuario (asegúrate de usar los campos correctos)
    $usuario = $collection->findOne([
        '$or' => [
            ['email' => $email_name],
            ['nombre' => $email_name] // Cambia 'nombre' si el campo es diferente en la base de datos
        ]
    ]);

    if ($usuario) {
        // Verificar la contraseña utilizando password_verify()
        if (password_verify($password, $usuario['password'])) {
            // Guardar el ID del usuario y email en la sesión
            $_SESSION['user_id'] = (string) $usuario['_id']; // Convertir ObjectId a string
            $_SESSION['user_email'] = $usuario['email'];

            // Redirigir al panel
            header("Location: dashboard.php");
            exit(); // Detener la ejecución del script después de redirigir
        } else {
            $message = "Contraseña incorrecta.";
            $alert_class = "alert-danger";
        }
    } else {
        $message = "No se encontró una cuenta con ese nombre o correo electrónico.";
        $alert_class = "alert-danger";
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
    <title>Inicio de Sesión</title>
</head>
<body>
    <div class="container mt-5">
        <?php if ($message): ?>
            <div class="alert <?php echo $alert_class; ?>" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <a href="login.php" class="btn btn-primary">Volver al Login</a>
    </div>
</body>
</html>
