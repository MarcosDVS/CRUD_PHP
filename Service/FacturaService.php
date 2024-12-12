<?php
require_once "../Context/Database.php";

class FacturaService {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function CrearFactura($clienteId, $tipoPago, $esCredito, $total) {
        $query = "INSERT INTO factura (ClienteId, TipoPago, EsCredito, Total) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$clienteId, $tipoPago, $esCredito, $total]);
        return $this->conn->lastInsertId();
    }

    public function AgregarDetalle($facturaId, $articuloId, $cantidad, $precio) {
        $query = "INSERT INTO factura_detalle (FacturaId, ArticuloId, Cantidad, Precio) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$facturaId, $articuloId, $cantidad, $precio]);
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
}
?>
