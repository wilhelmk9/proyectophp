<?php
// Conexión a la base de datos
include 'db.php';

// Consulta para obtener los usuarios
$sql = "SELECT id, nombre, email, rango FROM usuarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto; /* Centrar la tabla */
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1; /* Color de fondo al pasar el mouse */
        }

        a {
            text-decoration: none;
            color: #007bff; /* Color de los enlaces */
        }

        a:hover {
            text-decoration: underline; /* Subrayar al pasar el mouse */
        }

        .acciones {
            display: flex;
            gap: 10px; /* Espacio entre enlaces */
        }

        .volver {
            display: inline-block;
            margin-top: 20px;
            background-color: gray;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            text-decoration: none; /* Sin subrayado */
        }

        .volver:hover {
            background-color: #555; /* Color al pasar el mouse */
        }
    </style>
</head>
<body>
    <h2>Lista de Usuarios</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rango</th>
            <th>Acciones</th> <!-- Columna para acciones -->
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['nombre']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['rango']); ?></td>
            <td class="acciones">
                <a href="editar_usuario.php?id=<?php echo $row['id']; ?>">Editar</a>
                <a href="eliminar_usuario.php?id=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">Eliminar</a>
            </td> <!-- Enlaces de Editar y Eliminar -->
        </tr>
        <?php } ?>
    </table>
    <br>
    <a class="volver" href="crear_usuario.php">Crear Nuevo Usuario</a>
    <br>
    <a class="volver" href="tareas.php">Volver</a>
</body>
</html>

<?php
$conn->close();
?>
