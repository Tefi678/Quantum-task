<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Registro</title>
    <?php include 'header.html'; ?>
</head>
<body>
    <div class="wrapper bg-white">
        <div class="h2 text-center">Quantum Task</div>
        <div class="h4 text-muted text-center pt-2">Iniciar Sesión</div>
        <form class="pt-3">
            <div class="form-group py-2">
                <div class="input-field"> <span class="far fa-user p-2"></span> <input type="text" placeholder="Nombre o Email" required class=""> </div>
            </div>
            <div class="form-group py-1 pb-2">
                <div class="input-field"> <span class="fas fa-lock p-2"></span> <input type="text" placeholder="Contraseña" required class=""> <button class="btn bg-white text-muted"> <span class="far fa-eye-slash"></span> </button> </div>
            </div>
            <div class="d-flex align-items-start">
                <div class="remember"> <label class="option text-muted">Recordarme<input type="radio" name="radio"> <span class="checkmark"></span> </label> </div>
                <div class="ml-auto"> <a href="#" id="forgot">¿Olvidaste tu contraseña?</a> </div>
            </div> <button class="btn btn-block text-center my-3">Iniciar Sesión</button>
            <div class="text-center pt-3 text-muted">¿No tienes cuenta? <a href="registrar.php">Registrate</a></div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>
<footer>
    <?php include 'footer.html'; ?>
</footer>
</html>
