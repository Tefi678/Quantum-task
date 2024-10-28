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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'images/';
        $fileName = basename($_FILES['foto']['name']);
        $uploadFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadFile)) {
            $collectionUsuarios->updateOne(
                ['_id' => $userObjectId],
                ['$set' => ['foto' => $uploadFile]]
            );
            header("Location: perfil.php?msg=Foto de perfil actualizada.");
            exit();
        } else {
            header("Location: perfil.php?msg=Error al subir la foto.");
            exit();
        }
    } elseif (isset($_POST['foto_existente']) && !empty($_POST['foto_existente'])) {
        $fotoExistente = htmlspecialchars($_POST['foto_existente']);
        $collectionUsuarios->updateOne(
            ['_id' => $userObjectId],
            ['$set' => ['foto' => $fotoExistente]]
        );
        header("Location: perfil.php?msg=Foto de perfil actualizada.");
        exit();
    } else {
        header("Location: perfil.php?msg=No se seleccionó ninguna foto.");
        exit();
    }
}
?>