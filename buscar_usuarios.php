<?php
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collectionUsuarios = $client->Quantum->usuarios;

$nombre = isset($_GET['nombre']) ? trim($_GET['nombre']) : '';

if ($nombre) {
    $resultados = $collectionUsuarios->find([
        'nombre' => new MongoDB\BSON\Regex($nombre, 'i')
    ])->toArray();

    $usuarios = [];
    foreach ($resultados as $usuario) {
        $usuarios[] = [
            '_id' => (string) $usuario['_id'],
            'nombre' => $usuario['nombre'],
            'foto' => $usuario['foto']
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($usuarios);
}
?>
