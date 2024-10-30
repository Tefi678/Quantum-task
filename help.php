<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style8.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Ayuda</title>
    <style>
        .text-thin {
            font-size: 1.5em;
            color: #003366;
            font-weight: bold;
        }
        .curiosidades {
            font-size: 1.2em;
            color: #003366;
            margin-top: 10px;
            font-weight: bold;
        }
        .btn-custom {
            font-size: 1.2em;
            margin-top: 10px;
        }
    </style>
    <?php include 'header.php'; ?>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="mar-btm">
                    <img src="images/atom.png" alt="Logo" class="img-fluid mb-3">
                    <h4 class="text-thin"><i class="fa fa-lightbulb-o fa-lg fa-fw text-warning"></i> Consejos útiles</h4>
                    <p class="text-muted mar-top">Gestiona tus proyectos de manera eficiente y mantente organizado.</p>
                    <div class="list-group bg-trans">
                        <a class="list-group-item" href="#"><span class="badge badge-purple badge-icon badge-fw pull-left"></span> Usa etiquetas para tus tareas</a>
                        <a class="list-group-item" href="#"><span class="badge badge-info badge-icon badge-fw pull-left"></span> Establece fechas límite</a>
                        <a class="list-group-item" href="#"><span class="badge badge-pink badge-icon badge-fw pull-left"></span> Colabora con tu equipo</a>
                        <a class="list-group-item" href="#"><span class="badge badge-success badge-icon badge-fw pull-left"></span> Revisa el progreso regularmente</a>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel">
                    <div class="panel-body">
                        <h3 class="pad-all bord-btm text-thin">Información del Proyecto</h3>
                        <p class="curiosidades">Este gestor de proyectos está construido utilizando PHP y MongoDB, permitiendo una gestión eficiente y escalable de tus tareas y proyectos.</p>
                        <p class="curiosidades">La aplicación permite colaboración en tiempo real, ideal para equipos de trabajo que desean organizar sus tareas de manera efectiva.</p>

                        <h3 class="pad-all bord-btm text-thin">Navegación</h3>
                        <a href="perfil.php" class="btn btn-primary btn-custom">Perfil</a>
                        <a href="proyectos.php" class="btn btn-primary btn-custom">Proyectos</a>
                        <a href="friends.php" class="btn btn-primary btn-custom">Amigos</a>
                        <a href="login.php" class="btn btn-primary btn-custom">Login</a>

                        <h3 class="pad-all bord-btm text-thin">General</h3>
                        <div id="demo-gen-faq" class="panel-group accordion">
                            <div class="bord-no pad-top">
                                <div class="text-semibold pad-hor text-lg">
                                    <a href="#demo-gen-faq1" data-toggle="collapse" data-parent="#demo-gen-faq">¿Cómo crear un nuevo proyecto?</a>
                                </div>
                                <div id="demo-gen-faq1" class="collapse in">
                                    <div class="pad-all">
                                        Para crear un nuevo proyecto, dirígete a la sección "Proyectos" y selecciona "Crear nuevo". Completa la información requerida y guarda los cambios.
                                    </div>
                                </div>
                            </div>
                            <div class="bord-no pad-top">
                                <div class="text-semibold pad-hor text-lg">
                                    <a href="#demo-gen-faq2" data-toggle="collapse" data-parent="#demo-gen-faq">¿Cómo añadir tareas a un proyecto?</a>
                                </div>
                                <div id="demo-gen-faq2" class="collapse in">
                                    <div class="pad-all">
                                        En la vista del proyecto, haz clic en "Añadir tarea" y completa los detalles necesarios. Puedes asignar la tarea a un miembro del equipo y establecer fechas de vencimiento.
                                    </div>
                                </div>
                            </div>
                            <div class="bord-no pad-top">
                                <div class="text-semibold pad-hor text-lg">
                                    <a href="#demo-gen-faq3" data-toggle="collapse" data-parent="#demo-gen-faq">¿Cómo revisar el progreso de mis tareas?</a>
                                </div>
                                <div id="demo-gen-faq3" class="collapse">
                                    <div class="pad-all">
                                        En la sección "Tareas", podrás ver el estado de cada tarea, incluyendo las completadas y las pendientes.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="bord-no pad-all">
                        <h3 class="pad-all bord-btm text-thin">Cuenta</h3>
                        <div id="demo-acc-faq" class="panel-group accordion">
                            <div class="panel panel-trans pad-top">
                                <div class="text-semibold pad-hor text-lg">
                                    <a href="#demo-acc-faq1" data-toggle="collapse" data-parent="#demo-acc-faq">¿Cómo cambiar mi contraseña?</a>
                                </div>
                                <div id="demo-acc-faq1" class="collapse in">
                                    <div class="pad-all">
                                        Para cambiar tu contraseña, ve a la sección "Configuración" y selecciona "Cambiar contraseña". Sigue las instrucciones proporcionadas.
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-trans pad-top">
                                <div class="text-semibold pad-hor text-lg">
                                    <a href="#demo-acc-faq2" data-toggle="collapse" data-parent="#demo-acc-faq">¿Puedo eliminar mi cuenta?</a>
                                </div>
                                <div id="demo-acc-faq2" class="collapse">
                                    <div class="pad-all">
                                        Sí, puedes eliminar tu cuenta en la sección "Configuración" bajo "Eliminar cuenta". Ten en cuenta que esta acción es irreversible.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <?php include 'footer.html'; ?>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
