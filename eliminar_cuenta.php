<?php
session_start();
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collectionUsuarios = $client->Quantum->usuarios;
$collectionProyectos = $client->Quantum->proyectos;
$collectionUsuariosProyectos = $client->Quantum->usuarios_proyectos;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$userObjectId = new MongoDB\BSON\ObjectId($userId);

$proyectosUsuarioCursor = $collectionUsuariosProyectos->find(['id_user' => $userObjectId]);

foreach ($proyectosUsuarioCursor as $proyectoUsuario) {
    $proyectoId = $proyectoUsuario['id_proyecto'];
    $otherColaboradores = $collectionUsuariosProyectos->countDocuments([
        'id_proyecto' => $proyectoId,
        'id_user' => ['$ne' => $userObjectId]
    ]);

    if ($otherColaboradores === 0) {
        $collectionProyectos->deleteOne(['_id' => new MongoDB\BSON\ObjectId($proyectoId)]);
    } else {
        $newResponsable = $collectionUsuariosProyectos->findOne([
            'id_proyecto' => $proyectoId,
            'id_user' => ['$ne' => $userObjectId]
        ]);

        if ($newResponsable) {
            $newResponsableId = $newResponsable['id_user'];
            $collectionProyectos->updateOne(
                ['_id' => new MongoDB\BSON\ObjectId($proyectoId)],
                ['$set' => ['responsable' => $newResponsableId]]
            );
        }
    }

    $collectionUsuariosProyectos->deleteMany(['id_user' => $userObjectId]);
}

$collectionUsuarios->deleteOne(['_id' => $userObjectId]);

session_destroy();
header("Location: login.php?msg=Cuenta eliminada exitosamente.");
exit();
?>
