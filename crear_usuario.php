<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        form {
            background: white;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Asegura que el padding no sume al ancho total */
        }

        button {
            background-color: #007bff; /* Color del botón actualizado */
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3; /* Color del botón al pasar el mouse */
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff; /* Color del enlace */
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Crear Usuario</h2>
    <form action="guardar_usuario.php" method="POST">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        
        <!-- Menú desplegable para seleccionar el rango -->
        <label for="rango">Rango:</label>
        <select name="rango" required>
            <option value="mecanico">Mecanico</option>
            <option value="mantenimiento">Mantenimiento</option>
            <option value="ingenieria">Ingeniería</option>
            <option value="inventario">Inventario</option>
        </select>
        
        <button type="submit">Crear Usuario</button>
    </form>
    <br>
    <a href="usuarios.php">Volver</a>
</body>
</html>
