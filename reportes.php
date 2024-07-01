<?php
session_start();
require_once 'usuarioc.php';
require_once 'reservac.php';

$usuario = new Usuario();
$reserva = new Reserva();

if (!$usuario->isLoggedIn() || !$_SESSION['es_admin']) {
    header('Location: index.php');
    exit();
}

$reporte_reservas = $reserva->reporteReservas();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reportes</title>
</head>
<body>
    <h2>Reportes</h2>
    <h3>Reservas por Clase Deportiva y Horario</h3>
    <table border="1">
        <tr>
            <th>Clase Deportiva</th>
            <th>Horario</th>
            <th>Número de Reservas</th>
        </tr>
        <?php foreach ($reporte_reservas as $reporte): ?>
            <tr>
                <td><?php echo $reporte['clase_deportiva']; ?></td>
                <td><?php echo $reporte['horario']; ?></td>
                <td><?php echo $reporte['total']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <form method="POST" action="index.php">
        <button type="submit" name="logout">Cerrar Sesión</button>
    </form>
</body>
</html>
