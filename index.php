<?php
session_start();
require_once 'usuarioc.php';

$usuario = new Usuario();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $cedula = $_POST['cedula'];
    $clave = $_POST['clave'];
    if ($usuario->login($cedula, $clave)) {
        if ($_SESSION['es_admin']) {
            header('Location: reportes.php');
        } else {
            header('Location: reservas.php');
        }
        exit();
    } else {
        $error = "Credenciales incorrectas";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inicio de Sesión</title>
</head>
<body>
    <h2>Inicio de Sesión</h2>
    <form method="POST">
        <input type="text" name="cedula" placeholder="Cédula" required><br>
        <input type="password" name="clave" placeholder="Clave" required><br>
        <button type="submit" name="login">Iniciar Sesión</button>
        <button type="button" onclick="window.location.href='registro.php'">Registrarse</button>
    </form>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</body>
</html>
