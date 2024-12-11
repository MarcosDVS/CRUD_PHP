<?php
require_once "../Context/Database.php";

class ArticuloService {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function Consultar() {
        $query = "SELECT * FROM articulo";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Crear($descripcion, $p_compra, $p_venta) {
        $query = "INSERT INTO articulo (Descripcion, P_Compra, P_Venta) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$descripcion, $p_compra, $p_venta]);
    }

    public function Editar($id, $descripcion, $p_compra, $p_venta) {
        $query = "UPDATE articulo SET Descripcion = ?, P_Compra = ?, P_Venta = ? WHERE Id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$descripcion, $p_compra, $p_venta, $id]);
    }

    public function Eliminar($id) {
        $query = "DELETE FROM articulo WHERE Id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
    }
}
?>
