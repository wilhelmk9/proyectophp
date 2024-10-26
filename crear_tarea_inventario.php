<?php
// Iniciar sesión si es necesario
session_start();

// Conexión a la base de datos
include 'db.php';

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];
    $prioridad = $_POST['prioridad'];
    $categoria_id = $_POST['categoria_id'];
    $estado = $_POST['estado']; // Capturar el estado

    // Preparar la consulta SQL
    $sql = "INSERT INTO tareas (titulo, descripcion, fecha_vencimiento, prioridad, categoria_id, estado) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    // Preparar la declaración
    if ($stmt = $conn->prepare($sql)) {
        // Vincular parámetros
        $stmt->bind_param("ssssss", $titulo, $descripcion, $fecha_vencimiento, $prioridad, $categoria_id, $estado);

        // Ejecutar la declaración
        if ($stmt->execute()) {
            echo "Tarea creada exitosamente";
        } else {
            echo "Error al crear la tarea: " . $stmt->error;
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error; // Mostrar error de preparación
    }

    // Cerrar la conexión
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Tarea</title>
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

        label {
            font-weight: bold;
            margin-top: 10px;
            display: block; /* Cada etiqueta en su propia línea */
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

        input[type="submit"] {
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

        input[type="submit"]:hover {
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
    <h1>Crear Tarea</h1>
    <form method="POST" action="">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required><br>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea><br>

        <label for="fecha_vencimiento">Fecha de Vencimiento:</label>
        <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" required><br>

        <label for="prioridad">Prioridad:</label>
        <select id="prioridad" name="prioridad" required>
            <option value="baja">Baja</option>
            <option value="media">Media</option>
            <option value="alta">Alta</option>
        </select><br>

        <label for="categoria_id">Categoría:</label>
        <select id="categoria_id" name="categoria_id" required>
            <?php
            // Cargar categorías desde la base de datos
            $sql = "SELECT id, nombre FROM categorias";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['nombre']) . "</option>";
                }
            } else {
                echo "<option value=''>No hay categorías disponibles</option>";
            }
            ?>
        </select><br>

        <label for="estado">Estado:</label>
        <select id="estado" name="estado" required>
            <option value="Activo">Activo</option>
            <option value="Finalizado">Finalizado</option>
        </select><br>

        <input type="submit" value="Crear Tarea">
    </form>
    
    <br>
    <a href="inventario.php">Volver a la lista de tareas</a> <!-- Redirigir al CRUD de tareas -->
</body>
</html>