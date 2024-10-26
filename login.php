<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['rango'] = $user['rango']; // Guardar el rango en la sesión

            // Redirigir según el rango del usuario
            switch ($user['rango']) {
                case 'ingenieria':
                    header("Location: tareas.php");
                    break;
                case 'inventario':
                    header("Location: inventario.php");
                    break;
                case 'mantenimiento':
                    header("Location: mantenimiento.php"); // Crea este archivo similar a inventario.php
                    break;
                case 'mecanico':
                    header("Location: mecanico.php"); // Crea este archivo similar a inventario.php
                    break;
                default:
                    echo "Rango no válido.";
                    break;
            }
            exit();
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "Usuario no encontrado";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="email"],
        input[type="password"] {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>
    <div class="login-container">
        <h1>Ingresar Usuario</h1>
        <form method="POST" action="login.php">
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Contraseña" required><br>
            <br>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <a href="usuarios.php">Usuarios Registrados</a>
    </div>
</body>
</html>
