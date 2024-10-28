<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usernameOrEmail = $_POST['username'];
    $password = $_POST['password'];

    require 'vendor/autoload.php';
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $collection = $client->Quantum->usuarios;

    $user = $collection->findOne(['$or' => [
        ['nombre' => $usernameOrEmail],
        ['email' => $usernameOrEmail]
    ]]);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = (string)$user['_id'];
            $_SESSION['username'] = $user['nombre'];

            header("Location: index.php");
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
    <link rel="stylesheet" href="css/style2.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Iniciar Sesión</title>
    <?php include 'header.php'; ?>
</head>
<body>
    <section class="h-100 gradient-form">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">
                                    <div class="text-center">
                                        <img src="images/logo.png" style="width: 185px;" alt="logo">
                                        <h4 class="mt-1 mb-5 pb-1">Quantum Task</h4>
                                    </div>
                                    <?php if ($error): ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php echo htmlspecialchars($error); ?>
                                        </div>
                                    <?php endif; ?>
                                    <form method="POST" action="login.php">
                                        <p>Ingresa tu nombre o email</p>
                                        <div class="form-group" data-mdb-input-init class="form-outline mb-4">
                                            <input type="text" class="form-control" id="username" name="username" required>
                                        </div>
                                        <div class="form-group" data-mdb-input-init class="form-outline mb-4">
                                            <label for="password">Contraseña:</label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                        <div class="text-center pt-1 mb-5 pb-1">
                                            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center pb-4">
                                            <p class="mb-0 me-2">¿No tienes cuenta?</p>
                                            <a class="btn btn-outline-info" href="registrar.php" role="button">Registrarse</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                    <h4 class="mb-4">Bienvenido de vuelta!</h4>
                                    <p class="small mb-0">Estamos contentos de verte otra vez, esperamos que disfrutes la experiencia</p>
                                    <p class="small mb-0">Puedes cambiar los datos de tu perfil en perfil, si necesitas tambien puedes revisar el historiad de tu proyecto</p>
                                    <p class="small mb-0">Quantum Task esta interesado en tu seguimiento de progreso, si tienes dudas ve a ayuda</p>
                                    <a class="btn btn-outline-info" href="help.php" role="button">Ayuda</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="path/to/your/bootstrap.bundle.min.js"></script>
</body>
<footer>
    <?php include 'footer.html'; ?>
</footer>
</html>