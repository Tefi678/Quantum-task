<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Gestor de Proyectos</title>
    <?php include 'header.php'; ?>
</head>
<body>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="images/airfocus-um1zVjVCtEY-unsplash.jpg" alt="First slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Organiza tus Proyectos</h5>
                    <p>Con Quantum Task organiza paso a paso tus proyectos para gestionar el tiempo de manera optima</p>
                    <a href="proyectos.php" class="btn-primary">Crea tu proyecto</a>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="images/nick-morrison-FHnnjk1Yj7Y-unsplash.jpg" alt="Second slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Trabajo en Equipo</h5>
                    <p>Facilita el trabajo colaborativo entre compañeros</p>
                    <a href="amigos.php" class="btn-primary">Buscar amigos</a>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="images/rodeo-project-management-software-uetUPOdzhN0-unsplash.jpg" alt="Third slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Trabajo virtual</h5>
                    <p>Registrate y empieza a trabajar si es que no tienes cuenta</p>
                    <a href="registrar.php" class="btn-primary">Registrarte</a>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <section class="hero">
        <div class="hero-content">
            <h1>¡Bienvenido a Quantum Tas!</h1>
            <p>Explora, descubre y vive una experiencia única con nosotros.</p>
            <a href="#about" class="btn-primary">Conócenos</a>
        </div>
    </section>
    <section id="about" class="about">
        <h2>¿Quiénes Somos?</h2>
        <p>Quantum Task es un Gestor de proyectos donde puedes trabajar de manera colaborativa con diferentes compañeros</p>
    </section>
    <section class="services">
        <h2>Nuestros Servicios</h2>
        <div class="service-list">
            <div class="service-item">
                <h3>Proyectos y Tareas</h3>
                <p>Proyectos y tareas con amigos que puedes publicar</p>
            </div>
            <div class="service-item">
                <h3>Monitorear avances</h3>
                <p>Registro de cambios y control de avance</p>
            </div>
            <div class="service-item">
                <h3>Hablar con amigos</h3>
                <p>Ver otros perfiles y asignar tareas</p>
            </div>
        </div>
    </section>
    <section class="gallery">
        <h2>Galería</h2>
        <div class="gallery-grid">
            <img src="img1.jpg" alt="Imagen 1">
            <img src="img2.jpg" alt="Imagen 2">
            <img src="img3.jpg" alt="Imagen 3">
        </div>
    </section>
    <section class="call-to-action">
        <h2>¿Listo para Empezar?</h2>
        <p>Contacta con nosotros para obtener más información sobre nuestros servicios.</p>
        <a href="registrar.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Inicia en Quantum Task</a>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<footer>
    <?php include 'footer.html'; ?>
</footer>
</html>
