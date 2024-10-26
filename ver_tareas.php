<?php
include 'db.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT * FROM tareas WHERE usuario_id = $usuario_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mis Tareas</title>
</head>
<body>
    <h1>Tareas</h1>
    <table border="1">
        <tr>
            <th>Título</th>
            <th>Descripción</th>
            <th>Fecha de Vencimiento</th>
            <th>Prioridad</th>
            <th>Estado</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['titulo']}</td>
                        <td>{$row['descripcion']}</td>
                        <td>{$row['fecha_vencimiento']}</td>
                        <td>{$row['prioridad']}</td>
                        <td>{$row['estado']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No hay tareas</td></tr>";
        }
        ?>
    </table>
</body>
</html>
