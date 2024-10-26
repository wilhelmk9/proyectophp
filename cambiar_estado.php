<?php
session_start();
include 'db.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener los parámetros de la URL
$id = $_GET['id'];
$estado = $_GET['estado'];

// Actualizar el estado de la tarea
$sql = "UPDATE tareas SET estado = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $estado, $id);

if ($stmt->execute()) {
    // Verificar desde qué página se está realizando la acción
    if (isset($_SERVER['HTTP_REFERER'])) {
        // Redirigir a la página anterior (inventario.php o tareas.php)
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        // Si no se encuentra el HTTP_REFERER, redirigir a una página por defecto
        header("Location: tareas.php");
    }
} else {
    echo "Error al actualizar el estado: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
