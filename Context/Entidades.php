<!-- 
 
1) Luego de activar las opciones apache y MySQL en XAMPP ve a tu navegador
y pega esta direccion url 👉 http://localhost/phpmyadmin/

2) En la parte superior de la pantalla hay una opcion llamada SQL, pricionala
y escribe el siguiente comando:

-- Crear la base de datos
CREATE DATABASE ejemplo_crud;

Luego sombrea el comando que acabas de escribir y preciona el boton llamado
"Go" o "Ejecutar" que se encuentra en la parte inferior derecha

3) Vuelve a la opcion SQL y escribe el siguiente comando:

-- Usar la base de datos creada
USE ejemplo_crud;

-- Crear la tabla articulo
CREATE TABLE articulo (
    Id INT(11) AUTO_INCREMENT PRIMARY KEY, -- Llave primaria y autoincremental
    Descripcion VARCHAR(255) NOT NULL,     -- Descripción del artículo
    P_Compra DECIMAL(10,2) NOT NULL,       -- Precio de compra con dos decimales
    P_Venta DECIMAL(10,2) NOT NULL         -- Precio de venta con dos decimales
);

Sombrealo y selecciona el boton "Go" o "Ejecutar"

CREATE TABLE cliente (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Direccion VARCHAR(255),
    Telefono VARCHAR(15)
);

CREATE TABLE factura (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    ClienteId INT,
    Fecha DATE NOT NULL DEFAULT CURDATE(),
    TipoPago ENUM('Efectivo', 'Tarjeta') NOT NULL,
    EsCredito BOOLEAN NOT NULL,
    Total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (ClienteId) REFERENCES cliente(Id)
);

CREATE TABLE factura_detalle (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    FacturaId INT,
    ArticuloId INT,
    Cantidad INT NOT NULL,
    Precio DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (FacturaId) REFERENCES factura(Id),
    FOREIGN KEY (ArticuloId) REFERENCES articulo(Id)
);

CREATE TABLE abono (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    FacturaId INT,
    Fecha DATE NOT NULL DEFAULT CURDATE(),
    Monto DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (FacturaId) REFERENCES factura(Id)
);

CREATE TABLE img (
    Id_img INT AUTO_INCREMENT PRIMARY KEY,
    Foto VARCHAR(100) NOT NULL
);
-->