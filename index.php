<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Gestor de Proyectos</title>
    <?php include 'header.php'; ?>
</head>
<body>
    <main>
    <section class="hero">
        <div class="hero-content">
            <h1>Bienvenido a Nuestra Página</h1>
            <p>Explora, descubre y vive una experiencia única con nosotros.</p>
            <a href="#about" class="btn-primary">Conócenos</a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <h2>¿Quiénes Somos?</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus interdum semper metus, et facilisis dui aliquam in.</p>
    </section>

    <!-- Services Section -->
    <section class="services">
        <h2>Nuestros Servicios</h2>
        <div class="service-list">
            <div class="service-item">
                <h3>Servicio 1</h3>
                <p>Descripción breve del servicio 1.</p>
            </div>
            <div class="service-item">
                <h3>Servicio 2</h3>
                <p>Descripción breve del servicio 2.</p>
            </div>
            <div class="service-item">
                <h3>Servicio 3</h3>
                <p>Descripción breve del servicio 3.</p>
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
        <a href="#contact" class="btn-secondary">Contáctanos</a>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    <script>
    function verificarSesion() {
        // Llamada AJAX para verificar si el usuario está logueado
        fetch('verificar_sesion.php')
            .then(response => response.json())
            .then(data => {
                if (data.logueado) {
                    // Redirigir al perfil si el usuario está logueado
                    window.location.href = "perfil.php";
                } else {
                    // Mostrar ventana emergente de alerta si no está logueado
                    alert("Debe iniciar sesión para ver su perfil.");
                }
            })
            .catch(error => console.error('Error al verificar la sesión:', error));
        }
    </script>

</body>
<foot>
    <?php include 'footer.html'; ?>
</foot>
</html>
