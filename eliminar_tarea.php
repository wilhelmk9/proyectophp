<?php
// Incluir la conexión a la base de datos
include 'db.php';

// Verificar si se recibió el parámetro ID para eliminar
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar la consulta para eliminar la tarea con el ID correspondiente
    $sql = "DELETE FROM tareas WHERE id = ?";
    
    // Preparar la sentencia
    $stmt = $conn->prepare($sql);

    // Vincular los parámetros
    $stmt->bind_param("i", $id);

    // Ejecutar la sentencia
    if ($stmt->execute()) {
        // Si la eliminación es exitosa, redirigir de vuelta a tareas.php
        header("Location: tareas.php?mensaje=eliminado");
    } else {
        echo "Error al eliminar la tarea: " . $conn->error;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
} else {
    echo "No se recibió el parámetro de ID.";
}
?>
