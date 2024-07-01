<?php
require_once 'conexion.php';

class Reserva {
    private $conn;

    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->conectar();
    }

    public function realizarReserva($usuario_id, $clase_deportiva, $horario) {
        $fecha = date('Y-m-d');
        if ($this->existeReservaHoy($usuario_id, $fecha)) {
            return false;
        }
        $stmt = $this->conn->prepare("INSERT INTO reservas (usuario_id, clase_deportiva, horario, fecha) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $usuario_id, $clase_deportiva, $horario, $fecha);
        return $stmt->execute();
    }

    public function existeReservaHoy($usuario_id, $fecha) {
        $stmt = $this->conn->prepare("SELECT * FROM reservas WHERE usuario_id = ? AND fecha = ?");
        $stmt->bind_param("is", $usuario_id, $fecha);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function obtenerReservasUsuario($usuario_id) {
        $stmt = $this->conn->prepare("SELECT * FROM reservas WHERE usuario_id = ?");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function reporteReservas() {
        $result = $this->conn->query("SELECT clase_deportiva, horario, COUNT(*) as total FROM reservas GROUP BY clase_deportiva, horario");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
