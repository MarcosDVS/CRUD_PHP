<?php
class Database {
    private $host = "localhost"; //Direccion ip de tu servidor
    private $db_name = "ejemplo_crud"; //Nombre de tu database
    private $username = "root"; //Nombre de usuario en el servidor que aloja tu database
    private $password = ""; //Password del servidor que aloja tu database
    public $conn;

    /**
     * Establece una conexión a la base de datos utilizando PDO.
     *
     * @return PDO|null Devuelve la conexión PDO o null si falla.
     */
    public function getConnection() {
        $this->conn = null; // Inicializa la conexión como nula
        try {
            // Crea una nueva conexión PDO (PHP Data Objects)
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            // Establece el modo de error de PDO a excepción
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            // Captura cualquier excepción y muestra un mensaje de error
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn; // Devuelve la conexión
    }
}
?>

<!-- 5) Una vez ya creada tu conexion es momento de crear los controladores o servicios
dentro de tu proyecto crea una carpeta llamada Service y en dicha carpeta crea un 
archivo llamado ArticuloService.php -->

<!-- ArticuloService.php es donde manejaras el crud (create, read, update, delete) de la entidad
articulo que habias creado anteriormente  -->