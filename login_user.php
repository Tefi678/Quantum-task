<?php
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->Quantum->usuarios;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email_name = $_POST['user'];
    $password = $_POST['password'];

    $usuario = $collection->findOne([
        '$or' => [
            ['email' => $email_name],
            ['user' => $email_name]
        ]
    ]);

    if ($usuario) {
        if ($password == $usuario['password']) {
            session_start();
            $_SESSION['user_id'] = $usuario['_id'];
            $_SESSION['user_email'] = $usuario['email'];
            echo "Inicio de sesión exitoso. Redirigiendo a tu panel...";
            header("refresh:2;url=dashboard.php");
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "No se encontró una cuenta con ese nombre o correo electrónico.";
    }
}
