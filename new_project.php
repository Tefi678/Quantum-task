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
            <div class="col-md-9 register-right">
                <form action="insert_project.php" method="POST">
                    <h3 class="register-heading">Registrar nuevo Proyecto</h3>
                    <div class="row register-form">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="titulo" placeholder="Título" required />
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="descripcion" placeholder="Descripción" required />
                            </div>
                            <div class="form-group">
                                <label for="n_colaboradores">Número de Colaboradores:</label>
                                <input type="number" class="form-control" name="n_colaboradores" id="n_colaboradores" placeholder="Número de colaboradores" min="1" required />
                            </div>
                            <div class="form-group">
                                <label for="profesion">Etiqueta:</label>
                                <select class="form-control" name="profesion" id="profesion" required>
                                    <option value="" disabled selected>Seleccione una etiqueta</option>
                                    <option value="Scrum">Scrum</option>
                                    <option value="Hogar">Hogar</option>
                                    <option value="Personal">Personal</option>
                                    <option value="Trabajo">Trabajo</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Crear proyecto" />
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
