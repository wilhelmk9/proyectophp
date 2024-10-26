<?php
include 'db.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener el ID de la tarea a editar
if (isset($_GET['id'])) {
    $tarea_id = $_GET['id'];

    // Obtener los detalles de la tarea actual
    $sql = "SELECT * FROM tareas WHERE id = $tarea_id";
    $result = $conn->query($sql);
    $tarea = $result->fetch_assoc();
}

// Actualizar la tarea cuando se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];
    $prioridad = $_POST['prioridad'];
    $categoria_id = $_POST['categoria_id'];

    $sql = "UPDATE tareas 
            SET titulo = '$titulo', descripcion = '$descripcion', fecha_vencimiento = '$fecha_vencimiento', 
                prioridad = '$prioridad', categoria_id = $categoria_id 
            WHERE id = $tarea_id";

    if ($conn->query($sql) === TRUE) {
        echo "Tarea actualizada exitosamente";
        header("Location: tareas.php");
    } else {
        echo "Error al actualizar la tarea: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarea</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 2.5em; /* Aumentar el tamaño del título */
            margin-bottom: 20px; /* Espacio debajo del título */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1); /* Sombra suave para el título */
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="date"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box; /* Asegura que el padding no aumente el ancho total */
        }

        textarea {
            resize: vertical; /* Permitir el cambio de tamaño verticalmente */
            height: 100px; /* Altura inicial del textarea */
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            margin: 20px auto 0; /* Margen en la parte superior y centrado */
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
            text-align: center;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Editar Tarea</h1>

    <form method="POST" action="">
        <input type="text" name="titulo" value="<?php echo htmlspecialchars($tarea['titulo']); ?>" required placeholder="Título de la tarea"><br>
        <textarea name="descripcion" placeholder="Descripción de la tarea" required><?php echo htmlspecialchars($tarea['descripcion']); ?></textarea><br>
        <input type="date" name="fecha_vencimiento" value="<?php echo htmlspecialchars($tarea['fecha_vencimiento']); ?>" required><br>
        
        <select name="prioridad" required>
            <option value="baja" <?php if ($tarea['prioridad'] == 'baja') echo 'selected'; ?>>Baja</option>
            <option value="media" <?php if ($tarea['prioridad'] == 'media') echo 'selected'; ?>>Media</option>
            <option value="alta" <?php if ($tarea['prioridad'] == 'alta') echo 'selected'; ?>>Alta</option>
        </select><br>

        <!-- Cargar categorías dinámicamente desde la base de datos -->
        <select name="categoria_id" required>
            <?php
            // Consulta para obtener todas las categorías
            $sql = "SELECT id, nombre FROM categorias";
            $result = $conn->query($sql);

            // Crear opciones del menú desplegable dinámicamente
            while ($row = $result->fetch_assoc()) {
                $selected = ($row['id'] == $tarea['categoria_id']) ? 'selected' : '';
                echo "<option value='" . $row['id'] . "' $selected>" . htmlspecialchars($row['nombre']) . "</option>";
            }
            ?>
        </select><br>
        
        <button type="submit">Guardar Cambios</button>
    </form>

    <br>
    <a href="tareas.php">Volver</a>
</body>
</html>
