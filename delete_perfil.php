<?php
require 'vendor/autoload.php'; // Conectar a MongoDB

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->nombre_base_datos->nombre_coleccion;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuarioId = $_POST['usuario_id'];
    $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($usuarioId)]);

    header('Location: index.php');
}
?>