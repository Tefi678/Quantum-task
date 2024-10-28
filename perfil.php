<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collectionUsuarios = $client->Quantum->usuarios;

if (isset($_GET['msg'])) {
    echo '<div class="alert alert-info">' . htmlspecialchars($_GET['msg']) . '</div>';
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$userObjectId = new MongoDB\BSON\ObjectId($userId);

$usuario = $collectionUsuarios->findOne(['_id' => $userObjectId]);

if (!$usuario) {
    echo "Usuario no encontrado.";
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
    <title>Perfil de usuario</title>
    <?php include 'header.php'; ?>
</head>
<body>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <div class="container">
        <div class="row flex-lg-nowrap">
            <div class="col">
                <div class="row">
                    <div class="col mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="e-profile">
                                    <div class="row">
                                        <div class="col-12 col-sm-auto mb-3">
                                            <div class="mx-auto" style="width: 140px;">
                                            <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
                                                <img src="<?= htmlspecialchars($usuario['foto']) ?>" alt="Foto" style="max-height: 100%; max-width: 100%; object-fit: cover;">
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                            <div class="text-center text-sm-left mb-2 mb-sm-0">
                                                <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap"><?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']) ?></h4>
                                                <p class="mb-0">CI: <?= htmlspecialchars($usuario['ci']) ?></p>
                                                <div class="text-muted"><small>Nacido el <?= date('d M Y', strtotime($usuario['fecha_nacimiento'])) ?></small></div>
                                                <div class="mt-2">
                                                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#cambiarFotoModal">
                                                        <i class="fa fa-fw fa-camera"></i>
                                                        <span>Cambiar Foto</span>
                                                    </button>
                                                </div>
                                                <div class="modal fade" id="cambiarFotoModal" tabindex="-1" role="dialog" aria-labelledby="cambiarFotoModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="cambiarFotoModalLabel">Cambiar Foto de Perfil</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="new_foto.php" enctype="multipart/form-data">
                                                                    <div class="form-group">
                                                                        <label for="foto">Sube una nueva foto:</label>
                                                                        <input type="file" class="form-control-file" name="foto" accept="image/*">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Selecciona una imagen existente:</label>
                                                                        <select class="form-control" name="foto_existente">
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
                                                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center text-sm-right">
                                                <span class="badge badge-secondary"><?= htmlspecialchars($usuario['profesion']) ?></span>
                                                <div class="text-muted"><small><?= htmlspecialchars($usuario['bio']) ?></small></div>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item"><a href="" class="active nav-link">Datos de Usuario</a></li>
                                    </ul>
                                    <div class="tab-content pt-3">
                                        <div class="tab-pane active">
                                            <form class="form" method="POST" action="edit_perfil.php" novalidate="">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Nombre Completo</label>
                                                                    <input class="form-control" type="text" name="name" placeholder="Nombre" value="<?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']) ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Edad</label>
                                                                    <input class="form-control" type="number" name="edad" placeholder="Edad" value="<?= htmlspecialchars($usuario['edad']) ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col mb-3">
                                                                <div class="form-group">
                                                                    <label>Biografia</label>
                                                                    <textarea class="form-control" name="bio" rows="5" placeholder="Mi biografía"><?= htmlspecialchars($usuario['bio']) ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>CI</label>
                                                                    <input class="form-control" type="number" name="ci" placeholder="CI" value="<?= htmlspecialchars($usuario['ci']) ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Profesión</label>
                                                                    <input class="form-control" type="text" name="profesion" placeholder="Profesion" value="<?= htmlspecialchars($usuario['profesion']) ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Email</label>
                                                                    <input class="form-control" type="text" name="email" placeholder="user@example.com" value="<?= htmlspecialchars($usuario['email']) ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-2"><b>Cambiar Contraseña</b></div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Contraseña Actual</label>
                                                                <input class="form-control" type="password" name="current_password" placeholder="••••••">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label>Nueva Contraseña</label>
                                                                <input class="form-control" type="password" name="new_password" placeholder="••••••">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                        <div class="form-group">
                                                            <label>Confirmar Contraseña</label>
                                                            <input class="form-control" type="password" name="confirm_password" placeholder="••••••">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col d-flex justify-content-end">
                                                        <button class="btn btn-primary" type="submit">Guardar Cambios</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 mb-3">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="px-xl-3">
                                <a href="cerrar_sesion.php" class="btn btn-block btn-secondary">
                                   <i class="fa fa-sign-out"></i>
                                   <span>Cerrar Sesión</span>
                                </a>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title font-weight-bold">Historial</h6>
                                <p class="card-text">Monitorea los cambios que haz realizado y revisa como se han movido los proyectos en los que trabajas</p>
                                <button type="button" class="btn btn-primary">Ver historial</button>
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
<footer>
    <?php include 'footer.html'; ?>
</footer>
</html>