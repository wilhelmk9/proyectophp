<?php
// Conexión a la base de datos
include 'db.php';

// Verificar si se envió el formulario para actualizar el usuario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $rango = $_POST['rango'];
    
    // Solo actualizar la contraseña si se proporciona una nueva
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET nombre = '$nombre', email = '$email', password = '$password', rango = '$rango' WHERE id = $id";
    } else {
        $sql = "UPDATE usuarios SET nombre = '$nombre', email = '$email', rango = '$rango' WHERE id = $id";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Usuario actualizado exitosamente";
        header("Location: usuarios.php"); // Redirige a usuarios.php
        exit(); // Asegura que el script se detenga después de la redirección
    } else {
        echo "Error al actualizar el usuario: " . $conn->error;
    }
}

// Obtener los datos del usuario para mostrarlos en el formulario
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM usuarios WHERE id = $id";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
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
        }

        form {
            max-width: 400px;
            margin: 0 auto; /* Centrar el formulario */
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Para que el padding no afecte al ancho */
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3; /* Color al pasar el mouse */
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
    <h2>Editar Usuario</h2>
    <form method="POST" action="editar_usuario.php">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

        <label>Rango:</label>
        <select name="rango" required>
            <option value="mecanico" <?php if ($user['rango'] == 'mecanico') echo 'selected'; ?>>Mecanico</option>
            <option value="mantenimiento" <?php if ($user['rango'] == 'mantenimiento') echo 'selected'; ?>>Mantenimiento</option>
            <option value="ingenieria" <?php if ($user['rango'] == 'ingenieria') echo 'selected'; ?>>Ingeniería</option>
            <option value="inventario" <?php if ($user['rango'] == 'inventario') echo 'selected'; ?>>Inventario</option>
        </select>

        <label>Nueva Contraseña (opcional):</label>
        <input type="password" name="password" placeholder="Dejar en blanco si no desea cambiarla">

        <button type="submit">Actualizar Usuario</button>
    </form>
    <br>
    <a class="volver" href="usuarios.php">Regresar</a>
</body>
</html>
