<?php
// Conexión a la base de datos
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar el usuario de la base de datos
    $sql = "DELETE FROM usuarios WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        $mensaje = "Usuario eliminado exitosamente.";
    } else {
        $mensaje = "Error eliminando el usuario: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
            text-align: center; /* Centra el texto */
        }

        h2 {
            color: #333;
        }

        .mensaje {
            padding: 15px;
            margin: 20px;
            border-radius: 5px;
            background-color: #e7f3fe;
            color: #31708f;
            border: 1px solid #b8daff;
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

    <h2>Eliminar Usuario</h2>

    <?php if (isset($mensaje)): ?>
        <div class="mensaje">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <a class="volver" href="usuarios.php">Regresar a la lista de usuarios</a>
</body>
</html>
