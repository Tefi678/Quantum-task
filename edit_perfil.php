<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collectionUsuarios = $client->Quantum->usuarios;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$userObjectId = new MongoDB\BSON\ObjectId($userId);

$nombreCompleto = explode(" ", trim($_POST['name']));
$nombre = htmlspecialchars($nombreCompleto[0]);
$apellido = htmlspecialchars($nombreCompleto[1]);
$edad = (int)$_POST['edad'];
$email = htmlspecialchars($_POST['email']);
$bio = htmlspecialchars($_POST['bio']);
$ci = htmlspecialchars($_POST['ci']);
$profesion = htmlspecialchars($_POST['profesion']);

$usuario = $collectionUsuarios->findOne(['_id' => $userObjectId]);
if (!$usuario) {
    header("Location: perfil.php?msg=Usuario no encontrado.");
    exit();
}

if (!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
    if (password_verify($_POST['current_password'], $usuario['password'])) {
        if ($_POST['new_password'] === $_POST['confirm_password']) {
            $newPasswordHash = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            $result = $collectionUsuarios->updateOne(
                ['_id' => $userObjectId],
                ['$set' => ['password' => $newPasswordHash]]
            );

            if ($result->getModifiedCount() > 0) {
                header("Location: perfil.php?msg=Contraseña cambiada correctamente.");
                exit();
            } else {
                header("Location: perfil.php?msg=No se realizaron cambios en la contraseña.");
                exit();
            }
        } else {
            header("Location: perfil.php?msg=Las contraseñas nuevas no coinciden.");
            exit();
        }
    } else {
        header("Location: perfil.php?msg=La contraseña actual es incorrecta.");
        exit();
    }
}

$result = $collectionUsuarios->updateOne(
    ['_id' => $userObjectId],
    ['$set' => [
        'nombre' => $nombre,
        'apellido' => $apellido,
        'edad' => $edad,
        'email' => $email,
        'bio' => $bio,
        'ci' => $ci,
        'profesion' => $profesion,
    ]]
);

if ($result->getModifiedCount() > 0) {
    header("Location: perfil.php?msg=Datos actualizados correctamente.");
} else {
    header("Location: perfil.php?msg=No se realizaron cambios en los datos.");
}
exit();
?>
