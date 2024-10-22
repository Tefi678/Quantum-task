<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Registro</title>
    <?php include 'header.html'; ?>
</head>
<body>
    <div class="container register">
        <div class="row">
            <div class="col-md-3 register-left">
                <img src="./images/atom.png" alt="Logo" />
                <h3>¡Registrate!</h3>
                <p>Registra tu usuario para comenzar a usar Quantum Task. Si ya tienes cuenta, inicia sesión.</p>
                <a href="login.php" class="btn btn-light">Iniciar sesión</a><br />
            </div>
            <div class="col-md-9 register-right">
                <form action="register_user.php" method="POST">
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
                            <div class="form-group">
                                <input type="text" class="form-control" name="ci" placeholder="CI" required />
                            </div>
                        </div>
                        <div class="col-md-6">
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
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<footer>
    <?php include 'footer.html'; ?>
</footer>
</html>
