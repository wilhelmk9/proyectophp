<?php
// Conexión a la base de datos
include 'db.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado de la creación de usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        .container {
            background: white;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .message {
            font-size: 18px;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        a {
            text-decoration: none;
            color: #007bff;
            display: inline-block;
            margin-top: 20px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar la contraseña
            $rango = $_POST['rango']; // Capturar el rango seleccionado

            // Insertar el nuevo usuario en la base de datos
            $sql = "INSERT INTO usuarios (nombre, email, password, rango) VALUES ('$nombre', '$email', '$password', '$rango')";

            if ($conn->query($sql) === TRUE) {
                echo "<div class='message success'>Usuario creado exitosamente</div>";
            } else {
                echo "<div class='message error'>Error: " . $sql . "<br>" . $conn->error . "</div>";
            }

            $conn->close();
        }
        ?>
        <a href="usuarios.php">Regresar</a>
    </div>
</body>
</html>
