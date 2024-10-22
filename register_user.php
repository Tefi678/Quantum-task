<?php
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->Quantum->usuarios;

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$edad = (int)$_POST['edad'];
$ci = $_POST['ci'];
$profesion = $_POST['profesion'];
$email = $_POST['email'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];

if ($nombre && $apellido && $edad && $ci && $profesion && $email && $fecha_nacimiento) {
    $nuevo_usuario = [
        'nombre' => $nombre,
        'apellido' => $apellido,
        'edad' => $edad,
        'ci' => $ci,
        'profesion' => $profesion,
        'email' => $email,
        'fecha_nacimiento' => $fecha_nacimiento
    ];

    $insertOneResult = $collection->insertOne($nuevo_usuario);

    if ($insertOneResult->getInsertedCount() == 1) {
        echo "Registro exitoso. ID del nuevo usuario: " . $insertOneResult->getInsertedId();
    } else {
        echo "Error al registrar el usuario.";
    }
} else {
    echo "Por favor, completa todos los campos.";
}
?>
