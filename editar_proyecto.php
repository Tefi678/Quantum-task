<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collectionProyectos = $client->Quantum->proyectos;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$userObjectId = new MongoDB\BSON\ObjectId($userId);

$projectId = new MongoDB\BSON\ObjectId($_GET['id']);
$proyecto = $collectionProyectos->findOne(['_id' => $projectId, 'responsable' => $userObjectId]);

if (!$proyecto) {
    echo "Proyecto no encontrado o no autorizado.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $etiqueta = $_POST['etiqueta'];
    
    $updateData = [
        'titulo' => $titulo,
        'descripcion' => $descripcion,
        'etiqueta' => $etiqueta,
    ];

    // Handle image upload
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'images/';
        $fileName = basename($_FILES['imagen']['name']);
        $uploadFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadFile)) {
            $updateData['imagen'] = $uploadFile;
        } else {
            header("Location: proyectos.php?msg=Error al subir la imagen.");
            exit();
        }
    } elseif (isset($_POST['imagen_existente']) && !empty($_POST['imagen_existente'])) {
        $imagenExistente = htmlspecialchars($_POST['imagen_existente']);
        $updateData['imagen'] = $imagenExistente;
    }

    $collectionProyectos->updateOne(
        ['_id' => $projectId],
        ['$set' => $updateData]
    );

    header("Location: proyectos.php?msg=Proyecto actualizado exitosamente.");
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Editar Proyecto</title>
    <?php include 'header.php'; ?>
    <style>
        .container {
            margin-top: 50px;
        }
        .form-container {
            padding: 20px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        h2 {
            font-size: 28px;
            font-weight: bold;
            color: #495057;
        }
        .form-group label {
            font-weight: bold;
            color: #6c757d;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body class="bg-theme-color-light">
    <div class="container">
        <div class="form-container">
            <h2 class="text-center">Editar Proyecto</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="titulo">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="<?= htmlspecialchars($proyecto['titulo']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="5" required><?= htmlspecialchars($proyecto['descripcion']) ?></textarea>
                </div>
                <div class="form-group">
                    <label for="etiqueta">Etiqueta</label>
                    <input type="text" class="form-control" id="etiqueta" name="etiqueta" value="<?= htmlspecialchars($proyecto['etiqueta']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="imagen">Sube una nueva imagen:</label>
                    <input type="file" class="form-control-file" name="imagen" accept="image/*">
                </div>
                <div class="form-group">
                    <label>Selecciona una imagen existente:</label>
                    <select class="form-control" name="imagen_existente">
                        <option value="">-- Selecciona una imagen --</option>
                        <?php
                        $images = glob("images/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
                        foreach ($images as $image) {
                            $imageName = basename($image);
                            echo "<option value='$image'>$imageName</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg">Guardar Cambios</button>
                </div>
            </form>
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
