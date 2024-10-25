<?php
session_start();

// Verificar si el usuario está logueado
if (isset($_SESSION['user_id'])) {
    echo json_encode(['logueado' => true]);
} else {
    echo json_encode(['logueado' => false]);
}
?>
