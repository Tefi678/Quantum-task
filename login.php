<?php
session_start(); // Inicia la sesión

// Variables para almacenar mensajes de error
$error = '';

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener las credenciales ingresadas
    $usernameOrEmail = $_POST['username']; // Puede ser nombre de usuario o email
    $password = $_POST['password'];

    // Conectar a MongoDB
    require 'vendor/autoload.php'; // Asegúrate de que este archivo existe y la biblioteca esté instalada
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $collection = $client->Quantum->usuarios;

    // Buscar el usuario en la base de datos
    $user = $collection->findOne(['$or' => [
        ['nombre' => $usernameOrEmail],
        ['email' => $usernameOrEmail]
    ]]);

    if ($user) {
        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = (string)$user['_id']; // Almacenar el ID del usuario en la sesión
            $_SESSION['username'] = $user['nombre']; // Almacenar el nombre de usuario en la sesión

            header("Location: index.php"); // Redirigir a la página principal
            exit();
        } else {
            $error = 'Contraseña incorrecta.';
        }
    } else {
        $error = 'Nombre de usuario o email incorrecto.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Iniciar Sesión</title>
    <?php include 'header.php'; ?>
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="username">Nombre de Usuario o Email:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </form>
    </div>
    <script src="path/to/your/bootstrap.bundle.min.js"></script> <!-- Asegúrate de tener Bootstrap -->
</body>
<footer>
    <?php include 'footer.html'; ?>
</footer>
</html>