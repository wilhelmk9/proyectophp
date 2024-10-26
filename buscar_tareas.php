<?php
include 'db.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Inicializar la variable de resultados
$result = null;

// Verificar si se ha enviado el formulario de búsqueda
if (isset($_POST['buscar'])) {
    // Escapar caracteres especiales en la entrada del usuario
    $keyword = $conn->real_escape_string($_POST['keyword']);
    
    // Consulta para buscar tareas por título o descripción
    $sql = "SELECT * FROM tareas WHERE titulo LIKE '%$keyword%' OR descripcion LIKE '%$keyword%'";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Tareas</title>
    <link rel="stylesheet" href="estilos.css"> <!-- Asegúrate de tener un archivo de estilos -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        h1, h2 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px;
        }

        button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        ul {
            list-style-type: none; /* Quitar los puntos de la lista */
            padding: 0; /* Quitar el padding */
        }

        li {
            background-color: #e7f3fe;
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
        }

        .volver {
            display: inline-block;
            margin-top: 20px;
            background-color: gray;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none; /* Sin subrayado */
        }

        .volver:hover {
            background-color: #555; /* Color al pasar el mouse */
        }
    </style>
</head>
<body>
    <h1>Buscar Tareas</h1>
    <form method="POST" action="buscar_tareas.php">
        <input type="text" name="keyword" placeholder="Buscar tareas" required>
        <button type="submit" name="buscar">Buscar</button>
    </form>

    <?php if (isset($result)): ?>
        <h2>Resultados</h2>
        <ul>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li>{$row['titulo']} - {$row['descripcion']}</li>";
                }
            } else {
                echo "<li>No se encontraron resultados</li>";
            }
            ?>
        </ul>
    <?php endif; ?>

    <a class="volver" href="tareas.php">Volver</a>
</body>
</html>
