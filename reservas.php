<?php
session_start();
require_once 'usuarioc.php';
require_once 'reservac.php';

$usuario = new Usuario();
$reserva = new Reserva();

if (!$usuario->isLoggedIn() || $_SESSION['es_admin']) {
    header('Location: index.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['logout'])) {
        $usuario->logout();
        header('Location: index.php');
        exit();
    }

    if (isset($_POST['reservar'])) {
        $clase_deportiva = $_POST['clase_deportiva'];
        $horario = $_POST['horario'];
        if (!$reserva->existeReservaHoy($usuario_id, date('Y-m-d'))) {
            $reserva->realizarReserva($usuario_id, $clase_deportiva, $horario);
            $mensaje = "Reserva realizada exitosamente.";
        } else {
            $mensaje = "Ya has realizado una reserva para hoy.";
        }
    }
}

$reserva_usuario = $reserva->existeReservaHoy($usuario_id, date('Y-m-d'));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reservas</title>
</head>
<body>
    <h2>Reservas</h2>
    <p>Nombre: <?php echo $nombre; ?></p>
    <p>Apellido: <?php echo $apellido; ?></p>

    <?php if ($reserva_usuario): ?>
        <p>Ya has realizado una reserva para hoy. Esta es tu reserva:</p>
        <p>Clase Deportiva: <?php echo $reserva_usuario['clase_deportiva']; ?></p>
        <p>Horario: <?php echo $reserva_usuario['horario']; ?></p>
    <?php else: ?>
        <form method="POST">
            <label>Clase Deportiva:</label><br>
            <select name="clase_deportiva" required>
                <option value="Yoga">Yoga</option>
                <option value="Spinning">Spinning</option>
                <option value="Zumba">Zumba</option>
            </select><br>
            <label>Horario:</label><br>
            <select name="horario" required>
                <option value="7:00 AM - 8:00 AM">7:00 AM - 8:00 AM</option>
                <option value="6:00 PM - 7:00 PM">6:00 PM - 7:00 PM</option>
            </select><br>
            <button type="submit" name="reservar">Reservar</button>
        </form>
    <?php endif; ?>

    <form method="POST">
        <button type="submit" name="logout">Cancelar</button>
    </form>
    <?php if (isset($mensaje)) echo "<p>$mensaje</p>"; ?>
</body>
</html>
