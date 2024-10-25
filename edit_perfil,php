<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.html'; ?>

    <div>
        <h1>Perfil de <?php echo $usuario->nombre; ?></h1>
        <p>Email: <?php echo $usuario->email; ?></p>

        <!-- Formulario para editar el nombre completo -->
        <form action="editar_perfil.php" method="POST">
            <input type="hidden" name="usuario_id" value="<?php echo $usuario->_id; ?>">
            <label for="nombre">Nombre Completo:</label>
            <input type="text" name="nombre" value="<?php echo $usuario->nombre; ?>" required>
            <button type="submit">Guardar Cambios</button>
        </form>

        <!-- Botón para eliminar el perfil -->
        <form action="eliminar_perfil.php" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar tu perfil?');">
            <input type="hidden" name="usuario_id" value="<?php echo $usuario->_id; ?>">
            <button type="submit">Eliminar Perfil</button>
        </form>
    </div>

    <?php include 'footer.html'; ?>
</body>
</html>