<?php
require_once 'usuarioc.php';

$usuario = new Usuario();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $clave = $_POST['clave'];

    if ($usuario->register($cedula, $nombre, $apellido, $clave)) {
        header('Location: index.php');
        exit();
    } else {
        $error = "Error en el registro";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuario</title>
</head>
<body>
    <h2>Registro de Usuario</h2>
    <form method="POST">
        <input type="text" name="cedula" placeholder="Cédula" required><br>
        <input type="text" name="nombre" placeholder="Nombre" required><br>
        <input type="text" name="apellido" placeholder="Apellido" required><br>
        <input type="password" name="clave" placeholder="Clave" required><br>
        <button type="submit" name="register">Registrar</button>
    </form>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</body>
</html>
