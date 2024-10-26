<?php
session_start();
include 'db.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Consulta para obtener las tareas de inventario
$sql = "SELECT t.id, t.titulo, t.descripcion, t.fecha_vencimiento, t.prioridad, t.estado, c.nombre AS categoria
        FROM tareas t
        JOIN categorias c ON t.categoria_id = c.id
        WHERE c.nombre = 'Inventario'"; // Solo muestra las tareas de inventario
$result = $conn->query($sql);

// Crear un arreglo para agrupar tareas por categoría
$tareasPorCategoria = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tareasPorCategoria[$row['categoria']][] = $row;
    }
}

// Si se presiona el botón de cerrar sesión
if (isset($_POST['cerrar_sesion'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas de Inventario</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Fila alterna de color gris claro */
        }

        button {
            padding: 10px 15px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #c82333; /* Color de fondo al pasar el mouse */
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
    <h1>Lista de Tareas - Inventario</h1>
    
    <!-- Botón para cerrar sesión -->
    <form method="POST" action="inventario.php">
        <button type="submit" name="cerrar_sesion">Cerrar Sesión</button>
    </form>

    <?php
    // Mostrar las tareas separadas por categoría
    foreach ($tareasPorCategoria as $categoria => $tareas) {
        echo "<h2>Categoría: " . htmlspecialchars($categoria) . "</h2>";
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
            echo "<td>
                    <a href='editar_tarea_inventario.php?id=" . $tarea['id'] . "'>Editar</a> |
                    <a href='cambiar_estado.php?id=" . $tarea['id'] . "&estado=" . ($tarea['estado'] == 'Activo' ? 'Finalizada' : 'Activo') . "'>
                        " . ($tarea['estado'] == 'Activo' ? 'Finalizar' : 'Reactivar') . "
                    </a>
                  </td>";
            echo "</tr>";
        }
        
        echo "</tbody></table>"; // Cierre de la tabla por categoría
    }
    ?>

    <br>
    <a class="volver" href="crear_tarea_inventario.php">Crear Nueva Tarea</a>
</body>
</html>
