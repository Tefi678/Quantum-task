<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style4.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Registro</title>
    <?php include 'header.html'; ?>
</head>
<body>
    <div class="container register">
        <div class="row">
            <div class="col-md-9 register-right">
                <form action="insert_project.php" method="POST">
                    <h3 class="register-heading">Registrar nuevo Proyecto</h3>
                    <div class="row register-form">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="titulo" placeholder="Titulo" required />
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="descripcion" placeholder="Descripcion" required />
                            </div>
                            <div class="form-group">
                                <input type="encargado" class="form-control" name="encargado" placeholder="Encargado" required />
                            </div>
                            <select class="form-control" name="profesion">
                                    <option class="hidden" selected disabled>Etiqueta</option>
                                    <option>Scrum</option>
                                    <option>Hogar</option>
                                    <option>Personal</option>
                                    <option>Trabajo</option>
                                    <option>Otro</option>
                            </select>
                        </div>
                    </div>
                    <input type="submit" class="btnProject" value="Crear proyecto" />
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
