<?php
require 'conexion.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['titulo']) && isset($data['objetivo'])) {
    $proyectosCollection = $db->proyectos; // Colección para proyectos

    // Crear el nuevo proyecto
    $newProject = [
        'titulo' => $data['titulo'],
        'objetivo' => $data['objetivo'],
        'n_tareas' => 0,
        'responsable' => 1,
        'n_colaboradores' => 0,
        'tasks' => [] // Inicializa la lista de tareas
    ];

    // Insertar en la colección
    $result = $proyectosCollection->insertOne($newProject);

    if ($result->getInsertedCount() === 1) {
        echo json_encode(['success' => true, 'message' => 'Proyecto creado exitosamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al crear el proyecto']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
}
?>
