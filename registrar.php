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
                <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt="" />
                <h3>¡Registrate!</h3>
                <p>Registra tu usuario para iniciar con la experiencia del gestor de proyectos Quantum Task. Si ya tienes cuenta, inicia sesión</p>
                <input type="submit" name="" value="Iniciar sesión" /><br />
                <input type="submit" name="" value="Google" /><br />
            </div>
            <div class="col-md-9 register-right">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <h3 class="register-heading">Registrar nuevo usuario</h3>
                        <div class="row register-form">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Nombre" value="" />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Apellido" value="" />
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Contraseña" value="" />
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Confirmar contraseña" value="" />
                                </div>
                                <div class="form-group">
                                    <div class="maxl">
                                        <label class="radio inline">
                                            <input type="radio" name="gender" value="male" checked>
                                            <span>Masculino</span>
                                        </label>
                                        <label class="radio inline">
                                            <input type="radio" name="gender" value="female">
                                            <span>Femenino</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Email" value="" />
                                </div>
                                <div class="form-group">
                                    <input type="text" minlength="10" maxlength="10" name="age" class="form-control" placeholder="Edad" value="" />
                                </div>
                                <div class="form-group">
                                    <select class="form-control">
                                        <option class="hidden" selected disabled>Profesión</option>
                                        <option>Desarrollador de Software</option>
                                        <option>Ingeniero Civil</option>
                                        <option>Docente</option>
                                        <option>Diseñador Grafico</option>
                                        <option>Arquitecto</option>
                                        <option>Especialista en Marketing</option>
                                        <option>Estudiante</option>
                                        <option>Otro</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Fecha de Nacimiento" value="" />
                                </div>
                                <input type="submit" class="btnRegister" value="Registrar" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>
<foot>
    <?php include 'footer.html'; ?>
</foot>
</html>
