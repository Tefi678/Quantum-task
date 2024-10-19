<?php
require 'conexion.php';

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['username']) || !isset($data['password'])) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit();
}

$username = $data['username'];
$password = password_hash($data['password'], PASSWORD_DEFAULT); // Asegúrate de usar hashing para las contraseñas

$collection = $db->usuarios;

try {
    $result = $collection->insertOne(['username' => $username, 'password' => $password]);
    echo json_encode(['success' => true, 'message' => 'Usuario registrado']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error al registrar el usuario: ' . $e->getMessage()]);
}
?>
