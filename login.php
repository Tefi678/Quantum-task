<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Registro</title>
    <?php include 'header.html'; ?>
</head>
<body>
    <div id="login" class="container mt-5" style="display: none;">
        <h2>Iniciar Sesión</h2>
        <form id="loginForm">
            <div class="form-group">
                <label for="loginUsername">Nombre de Usuario</label>
                <input type="text" class="form-control" id="loginUsername" required>
            </div>
            <div class="form-group">
                <label for="loginPassword">Contraseña</label>
                <input type="password" class="form-control" id="loginPassword" required>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </form>
        <p class="mt-3">¿No tienes una cuenta? <a href="#register">Registrarse</a></p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
