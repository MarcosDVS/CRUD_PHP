<?php
require_once "../Context/Database.php";

class FacturaService {
    public $conn; // Cambiado a público para acceder a las transacciones

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function CrearFactura($clienteId, $tipoPago, $esCredito, $total) {
        $query = "INSERT INTO factura (ClienteId, TipoPago, EsCredito, Total) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $success = $stmt->execute([$clienteId, $tipoPago, $esCredito, $total]);
        
        if ($success) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function AgregarDetalle($facturaId, $articuloId, $cantidad, $precio) {
        $query = "INSERT INTO factura_detalle (FacturaId, ArticuloId, Cantidad, Precio) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$facturaId, $articuloId, $cantidad, $precio]);
    }

    public function ConsultarFacturas() {
        $query = "SELECT f.*, c.Nombre AS Cliente FROM factura f LEFT JOIN cliente c ON f.ClienteId = c.Id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function RegistrarAbono($facturaId, $monto) {
        $query = "INSERT INTO abono (FacturaId, Monto) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$facturaId, $monto]);
    }

    public function ObtenerUltimaFactura() {
        $query = "SELECT Id FROM factura ORDER BY Id DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
