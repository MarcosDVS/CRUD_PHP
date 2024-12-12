<?php
require_once "../Context/Database.php";

class ClienteService {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function Consultar() {
        $query = "SELECT * FROM cliente";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Crear($nombre, $direccion, $telefono) {
        $query = "INSERT INTO cliente (Nombre, Direccion, Telefono) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nombre, $direccion, $telefono]);
    }

    public function Editar($id, $nombre, $direccion, $telefono) {
        $query = "UPDATE cliente SET Nombre = ?, Direccion = ?, Telefono = ? WHERE Id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nombre, $direccion, $telefono, $id]);
    }

    public function Eliminar($id) {
        $query = "DELETE FROM cliente WHERE Id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
    }

    public function ConsultarPorId($id) {
        $query = "SELECT * FROM cliente WHERE Id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
