<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">
        <img src="./images/atom.png" width="30" height="30" class="d-inline-block align-top" alt="">
        Quantum Task
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="proyectos.php">Proyectos<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="historial.php">Notificaciones</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="./images/user.png" alt="Cuenta" style="width: 30px; height: 30px; border-radius: 50%;">
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php if (isset($_SESSION['username'])): ?>
                        <a class="dropdown-item" href="perfil.php"><?php echo htmlspecialchars($_SESSION['username']); ?></a>
                        <a class="dropdown-item" href="cerrar_sesion.php">Cerrar Sesión</a>
                    <?php else: ?>
                        <a class="dropdown-item" href="registrar.php">Registrarse</a>
                        <a class="dropdown-item" href="login.php">Iniciar Sesión</a>
                    <?php endif; ?>
                </div>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="GET" action="proyectos.php">
            <input class="form-control mr-sm-2" type="search" name="search" placeholder="Buscar por título" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>
    </div>
</nav>
