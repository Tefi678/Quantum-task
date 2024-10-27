<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Registro</title>
    <?php include 'header.php'; ?>
</head>
<body>
    <div class="container register">
        <div class="row">
            <div class="col-md-3 register-left">
                <img src="./images/atom.png" alt="Logo" />
                <h3>¡Regístrate!</h3>
                <p>Registra tu usuario para comenzar a usar Quantum Task. Si ya tienes cuenta, inicia sesión.</p>
                <a href="login.php" class="btn btn-light">Iniciar sesión</a><br />
            </div>
            <div class="col-md-9 register-right">
                <?php
                require 'vendor/autoload.php';
                session_start();

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $client = new MongoDB\Client("mongodb://localhost:27017");
                    $collection = $client->Quantum->usuarios;

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
                            'password' => password_hash($password, PASSWORD_BCRYPT),
                            'fecha_nacimiento' => $fecha_nacimiento
                        ];
                        $insertOneResult = $collection->insertOne($nuevo_usuario);

                        if ($insertOneResult->getInsertedCount() == 1) {
                            $_SESSION['user_id'] = $insertOneResult->getInsertedId();
                            $_SESSION['user_email'] = $email;

                            header("Location: index.php");
                            exit();
                        } else {
                            $message = "Error al registrar el usuario.";
                            $alert_class = "alert-danger";
                        }
                    } else {
                        $message = "Por favor, completa todos los campos.";
                        $alert_class = "alert-warning";
                    }
                }
                ?>

                <form action="registrar.php" method="POST">
                    <h3 class="register-heading">Registrar nuevo usuario</h3>
                    <div class="row register-form">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="nombre" placeholder="Nombre" required />
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="apellido" placeholder="Apellido" required />
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" placeholder="Email" required />
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" name="password" placeholder="Password" id="exampleInputPassword1" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="ci" placeholder="CI" required />
                            </div>
                            <div class="form-group">
                                <input type="number" name="edad" class="form-control" placeholder="Edad" required />
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="profesion">
                                    <option class="hidden" selected disabled>Profesión</option>
                                    <option>Desarrollador de Software</option>
                                    <option>Ingeniero Civil</option>
                                    <option>Docente</option>
                                    <option>Diseñador Gráfico</option>
                                    <option>Arquitecto</option>
                                    <option>Especialista en Marketing</option>
                                    <option>Estudiante</option>
                                    <option>Otro</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="date" class="form-control" name="fecha_nacimiento" placeholder="Fecha de Nacimiento" required />
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btnRegister" value="Registrar" />
                </form>

                <?php if (isset($message)): ?>
                    <div class="alert <?= $alert_class ?>" role="alert">
                        <?= $message ?>
                    </div>
                <?php endif; ?>
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
