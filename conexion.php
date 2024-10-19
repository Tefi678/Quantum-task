<?php
require 'vendor/autoload.php';

try {
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $db = $client->Quantum; // Asegúrate de que la base de datos 'Quantum' exista
} catch (MongoDB\Driver\Exception\Exception $e) {
    die("Conexión fallida: " . $e->getMessage());
}
?>
