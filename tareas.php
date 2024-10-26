<?php
session_start();
include 'db.php';

// Verificar que el usuario tenga acceso
if (!isset($_SESSION['usuario_id']) || $_SESSION['rango'] !== 'ingenieria') {
    header("Location: login.php");
    exit();
}

// Consulta para obtener las tareas y sus respectivas categorías
$sql = "SELECT t.id, t.titulo, t.descripcion, t.fecha_vencimiento, t.prioridad, t.estado, c.nombre AS categoria
        FROM tareas t
        JOIN categorias c ON t.categoria_id = c.id";
$result = $conn->query($sql);

// Crear un arreglo para agrupar tareas por categoría
$tareasPorCategoria = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tareasPorCategoria[$row['categoria']][] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
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

        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
            text-align: center;
        }

        a:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .actions {
            white-space: nowrap; /* Evitar que los botones se desplacen */
        }

        .actions a {
            margin-right: 10px;
            color: white; /* Cambiado a blanco */
            text-decoration: none;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        .category-title {
            color: #007bff;
            margin-top: 20px;
        }

        .logout-btn {
            background-color: gray;
            margin-top: 20px;
        }

    </style>
</head>
<body>
    <h1>Lista de Tareas</h1>

    <a href="logout.php" class="logout-btn">Cerrar Sesión</a>

    <?php
    // Mostrar las tareas separadas por categoría
    foreach ($tareasPorCategoria as $categoria => $tareas) {
        echo "<h2 class='category-title'>Categoría: " . htmlspecialchars($categoria) . "</h2>";
        echo "<table>";
        echo "<thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Prioridad</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
              </thead>
              <tbody>";
        
        foreach ($tareas as $tarea) {
            echo "<tr>";
            echo "<td>" . $tarea['id'] . "</td>";
            echo "<td>" . htmlspecialchars($tarea['titulo']) . "</td>";
            echo "<td>" . htmlspecialchars($tarea['descripcion']) . "</td>";
            echo "<td>" . htmlspecialchars($tarea['fecha_vencimiento']) . "</td>";
            echo "<td>" . htmlspecialchars($tarea['prioridad']) . "</td>";
            echo "<td>" . htmlspecialchars($tarea['estado']) . "</td>";
            echo "<td class='actions'>
                    <a href='editar_tarea.php?id=" . $tarea['id'] . "'>Editar</a> |
                    <a href='eliminar_tarea.php?id=" . $tarea['id'] . "'>Eliminar</a> |
                    <a href='cambiar_estado.php?id=" . $tarea['id'] . "&estado=" . ($tarea['estado'] == 'Activo' ? 'Finalizada' : 'Activo') . "'>
                        " . ($tarea['estado'] == 'Activo' ? 'Finalizar' : 'Reactivar') . "
                    </a>
                  </td>";
            echo "</tr>";
        }
        
        echo "</tbody></table><br>"; // Cierre de la tabla por categoría
    }
    ?>
    
    <a href="crear_tarea.php">Crear Nueva Tarea</a>
    <br>
    <a href="usuarios.php">Agregar o editar usuarios</a>
    <br>
    <a href="buscar_tareas.php">Buscar tarea</a>
</body>
</html>
