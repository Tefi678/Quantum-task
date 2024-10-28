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
                    <a href="proyectos.php" class="btn btn-outline-light">Crea tu proyecto</a>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="images/nick-morrison-FHnnjk1Yj7Y-unsplash.jpg" alt="Second slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Trabajo en Equipo</h5>
                    <p>Facilita el trabajo colaborativo entre compañeros</p>
                    <a href="amigos.php" class="btn btn-outline-light">Buscar amigos</a>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="images/rodeo-project-management-software-uetUPOdzhN0-unsplash.jpg" alt="Third slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Trabajo virtual</h5>
                    <p>Registrate y empieza a trabajar si es que no tienes cuenta</p>
                    <a href="registrar.php" class="btn btn-outline-light">Registrarte</a>
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
    <section class="hero" style="display: flex; align-items: center; padding: 50px 20px; background: linear-gradient(to top, #ff9690, #f9545b;">
        <div class="hero-content" style="flex: 1; text-align: center; color: white;">
            <h1>¡Bienvenido a Quantum Task!</h1>
            <p>Explora, descubre y vive una experiencia única con nosotros.</p>
            <p>Únete a nuestra comunidad y transforma la manera en que gestionas tus proyectos. Conéctate con amigos y optimiza tus tareas diarias.</p>
            <div style="margin-top: 20px;">
                <a href="#about" class="btn btn-outline-light">Conócenos</a>
                <a href="#services" class="btn btn-outline-light">¿Qué hacemos?</a>
                <a href="#gallery" class="btn btn-outline-light">Templates</a>
            </div>
        </div>
        <div class="hero-image" style="flex: 1; display: flex; justify-content: center;">
            <img src="images/logo.png" alt="Descripción de la imagen" style="max-width: 80%; height: auto; border-radius: 5px;">
        </div>
    </section>
    <section id="about" class="about" style="color: white;">
        <h2 style="text-align: center; margin-bottom: 20px;">¿Quiénes Somos?</h2>
        <p style="text-align: center; max-width: 800px; margin: 0 auto; font-size: 1.1rem;">
            Quantum Task es un gestor de proyectos innovador que permite a los usuarios trabajar de manera colaborativa con compañeros de equipo, facilitando la organización y el seguimiento de tareas. Nuestra plataforma está diseñada para optimizar el flujo de trabajo, promover la comunicación y fomentar la productividad, todo en un entorno fácil de usar.
        </p>
        <div style="display: flex; justify-content: space-between; margin-top: 40px;">
            <div class="about-item">
                <h3 style="text-align: center; margin-bottom: 10px;">Misión</h3>
                <p>Nuestra misión es empoderar a los equipos a alcanzar su máximo potencial mediante herramientas intuitivas que faciliten la colaboración y la gestión eficiente de proyectos, promoviendo así un entorno de trabajo más productivo y armonioso.</p>
            </div>
            <div class="about-item">
                <h3 style="text-align: center; margin-bottom: 10px;">Visión</h3>
                <p>Nos proponemos ser la plataforma de referencia para la gestión de proyectos colaborativos a nivel global, transformando la forma en que los equipos trabajan juntos y ayudando a las organizaciones a adaptarse a un mundo en constante cambio.</p>
            </div>
        </div>
    </section>
    <section id="services" class="services">
        <h2>Nuestros Servicios</h2>
        <div class="service-list">
            <div class="service-item">
                <h3>Proyectos y Tareas</h3>
                <p>Publica y organiza proyectos y tareas con tus amigos de manera sencilla y efectiva. Esta herramienta te permite colaborar en actividades, compartir ideas y asignar responsabilidades, todo en un mismo lugar. ¡Convierte tus planes en acciones concretas y disfruta del trabajo en equipo!</p>
            </div>
            <div class="service-item">
                <h3>Monitorear Avances</h3>
                <p>Realiza un seguimiento detallado de los cambios y el progreso de cada proyecto. Con nuestro sistema de registro, podrás visualizar el desarrollo de las tareas, identificar obstáculos y celebrar los logros. Mantente al tanto de cada paso y asegura que todo avance según lo planeado.</p>
            </div>
            <div class="service-item">
                <h3>Hablar con Amigos</h3>
                <p>Conéctate con tus amigos de manera más efectiva. Explora sus perfiles, comunícate fácilmente y asigna tareas según sus habilidades e intereses. Fomenta la colaboración y mejora la productividad en tus proyectos mediante una comunicación fluida y directa. ¡El trabajo en equipo nunca fue tan accesible!</p>
            </div>
        </div>
    </section>
    <section id="gallery" class="gallery">
        <h2>Templates</h2>
        <div class="gallery-grid">
            <img src="images/kym-mackinnon-R-NvndFpa9I-unsplash.jpg" alt="Imagen 1">
            <img src="images/frederic-paulussen-7wMKwF3LAdU-unsplash.jpg" alt="Imagen 2">
            <img src="images/vincentiu-solomon-ln5drpv_ImI-unsplash.jpg" alt="Imagen 3">
        </div>
    </section>
    <section class="call-to-action">
        <h2>¿Listo para Empezar?</h2>
        <p>Registrate y empieza a trabajar con nosotros</p>
        <a href="registrar.php" class="btn btn-outline-light" role="button" aria-pressed="true">Inicia en Quantum Task</a>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<footer>
    <?php include 'footer.html'; ?>
</footer>
</html>
