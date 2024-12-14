<?php
require_once "../Context/Database.php";

class imgService {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function Consultar() {
        $query = "SELECT * FROM img";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function guardarImagen($imagen, $nombreImagen) {
        $tipoImagen = strtolower(pathinfo($nombreImagen, PATHINFO_EXTENSION));
        $directorio = "../archivos/";
        
        if ($tipoImagen == "jpg" || $tipoImagen == "jpeg" || $tipoImagen == "png") {
            try {
                // Insertar registro vacío y obtener ID
                $stmt = $this->conn->query("INSERT INTO img(Foto) VALUES('')");
                $idRegistro = $this->conn->lastInsertId();

                $ruta = $directorio . $idRegistro . "." . $tipoImagen;
                
                // Actualizar con la ruta
                $stmt = $this->conn->prepare("UPDATE img SET Foto = ? WHERE Id_img = ?");
                $stmt->execute([$ruta, $idRegistro]);

                // Almacenar la imagen
                if (move_uploaded_file($imagen, $ruta)) {
                    return ["success" => true, "message" => "Imagen guardada exitosamente"];
                } else {
                    return ["success" => false, "message" => "Error al guardar la imagen"];
                }
            } catch (PDOException $e) {
                return ["success" => false, "message" => "Error en la base de datos: " . $e->getMessage()];
            }
        } else {
            return ["success" => false, "message" => "No se aceptan archivos con el formato " . $tipoImagen];
        }
    }
}

// Procesar el formulario
if (!empty($_POST["btn-registrar"])) {
    $imgService = new imgService();
    $resultado = $imgService->guardarImagen(
        $_FILES["input-imagen"]["tmp_name"],
        $_FILES["input-imagen"]["name"]
    );
    
    echo "<div class='alert alert-" . ($resultado["success"] ? "info" : "danger") . "'>" . 
         $resultado["message"] . "</div>";
    ?>
    <script>
        history.replaceState(null, null, location.pathname);
    </script>
<?php
}
?>