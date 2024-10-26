<?php
// Conexión a la base de datos
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];
    $prioridad = $_POST['prioridad'];
    $categoria_id = $_POST['categoria_id'];
    $estado = $_POST['estado']; // Capturar el estado

    // Insertar la nueva tarea en la base de datos
    $sql = "INSERT INTO tareas (titulo, descripcion, fecha_vencimiento, prioridad, categoria_id, estado) 
            VALUES ('$titulo', '$descripcion', '$fecha_vencimiento', '$prioridad', '$categoria_id', '$estado')";

    if ($conn->query($sql) === TRUE) {
        echo "Tarea creada exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
