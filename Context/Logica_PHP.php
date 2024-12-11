<!-- 
 
Aquí tienes un listado básico de la lógica de programación en PHP con ejemplos prácticos para cada concepto:

---

### **1. Declarar Variables**
En PHP, las variables comienzan con el símbolo `$`.

```php
<?php
$nombre = "Juan"; // Variable tipo string
$edad = 25;       // Variable tipo entero
$precio = 19.99;  // Variable tipo float
$esActivo = true; // Variable tipo booleano
?>
```

---

### **2. Estructuras de Control**

#### **Condicional `if`, `else if` y `else`**
```php
<?php
$edad = 20;

if ($edad >= 18) {
    echo "Eres mayor de edad.";
} elseif ($edad == 17) {
    echo "Estás a punto de ser mayor de edad.";
} else {
    echo "Eres menor de edad.";
}
?>
```

#### **Operador Ternario**
```php
<?php
$mensaje = ($edad >= 18) ? "Mayor de edad" : "Menor de edad";
echo $mensaje;
?>
```

---

### **3. Ciclos**

#### **`for`**
Se usa para recorrer un rango conocido de veces.

```php
<?php
for ($i = 1; $i <= 5; $i++) {
    echo "Número: $i<br>";
}
?>
```

#### **`foreach`**
Se utiliza para recorrer arrays.

```php
<?php
$frutas = ["Manzana", "Pera", "Naranja"];

foreach ($frutas as $fruta) {
    echo "Fruta: $fruta<br>";
}
?>
```

#### **`while`**
Se ejecuta mientras la condición sea verdadera.

```php
<?php
$contador = 1;

while ($contador <= 5) {
    echo "Contador: $contador<br>";
    $contador++;
}
?>
```

#### **`do while`**
Similar a `while`, pero asegura que el bloque de código se ejecute al menos una vez.

```php
<?php
$contador = 1;

do {
    echo "Contador: $contador<br>";
    $contador++;
} while ($contador <= 5);
?>
```

---

### **4. Funciones**

#### **Declarar una función**
```php
<?php
function sumar($a, $b) {
    return $a + $b;
}

$resultado = sumar(5, 10);
echo "La suma es: $resultado";
?>
```

---

### **5. Arrays**

#### **Array Indexado**
```php
<?php
$numeros = [1, 2, 3, 4, 5];
echo $numeros[0]; // Imprime 1
?>
```

#### **Array Asociativo**
```php
<?php
$persona = [
    "nombre" => "Juan",
    "edad" => 25,
    "profesion" => "Ingeniero"
];
echo $persona["nombre"]; // Imprime Juan
?>
```

#### **Array Multidimensional**
```php
<?php
$productos = [
    ["nombre" => "Laptop", "precio" => 1500],
    ["nombre" => "Teclado", "precio" => 50]
];
echo $productos[0]["nombre"]; // Imprime Laptop
?>
```

---

### **6. Manipulación de Strings**

#### Concatenación de cadenas
```php
<?php
$nombre = "Juan";
$saludo = "Hola, " . $nombre . "!";
echo $saludo;
?>
```

#### Interpolación de variables
```php
<?php
echo "Hola, $nombre!";
?>
```

---

### **7. Manejo de Formularios**
```php
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    echo "Hola, $nombre!";
}
?>
<form method="post">
    <input type="text" name="nombre">
    <button type="submit">Enviar</button>
</form>
```

---

### **8. Inclusión de Archivos**
```php
<?php
include 'archivo.php'; // Incluye el archivo
require 'config.php'; // Similar a include pero arroja error fatal si el archivo no existe
?>
```

---

### **9. Manejo de Errores**
```php
<?php
try {
    $resultado = 10 / 0; // Genera error
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
```

---

Este listado cubre los conceptos básicos de la lógica de programación en PHP. 
Si necesitas más detalles sobre algún punto, ¡puedes preguntar! 😊

-->