<?php
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collectionUsuarios = $client->Quantum->usuarios;

$nombre = isset($_GET['nombre']) ? trim($_GET['nombre']) : '';

if ($nombre) {
    // Buscar usuarios cuyo nombre coincida con el criterio
    $resultados = $collectionUsuarios->find([
        'nombre' => new MongoDB\BSON\Regex($nombre, 'i') // Búsqueda insensible a mayúsculas/minúsculas
    ])->toArray();

    // Transformar resultados a un formato limpio
    $usuarios = [];
    foreach ($resultados as $usuario) {
        $usuarios[] = [
            '_id' => (string) $usuario['_id'],
            'nombre' => $usuario['nombre']
        ];
    }

    // Enviar los resultados como JSON
    header('Content-Type: application/json');
    echo json_encode($usuarios);
}
