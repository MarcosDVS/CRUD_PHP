<?php
require_once "../Shared/Header.php";
require_once "../Service/FacturaService.php";
require_once "../Service/ClienteService.php";
require_once "../Service/ArticuloService.php";

$facturaService = new FacturaService();
$clienteService = new ClienteService();
$articuloService = new ArticuloService();

$Clientes = $clienteService->Consultar();
$Productos = $articuloService->Consultar();

// Create a map of products with their selling prices for easy lookup in JavaScript
$ProductoPrecios = [];
foreach ($Productos as $producto) {
    $ProductoPrecios[$producto['Id']] = $producto['P_Venta'];
}
// Referencia a los servicios para factura
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['crear-factura'])) {

        try {
            // Validar que los campos requeridos no estén vacíos
            if (!empty($_POST['cliente']) && !empty($_POST['tipoPago']) && !empty($_POST['productos'])) {
                // Obtener el cliente, tipo de pago y calcular el total
                $clienteId = $_POST['cliente']; // ID del cliente seleccionado
                $tipoPago = $_POST['tipoPago']; // Tipo de pago seleccionado
                $esCredito = false; // Cambiar según la lógica de tu aplicación
                $total = 0; // Inicializar el total

                // Calcular el total de los productos
                foreach ($_POST['productos'] as $index => $productoId) {
                    $cantidad = $_POST['cantidades'][$index];
                    $precio = $_POST['precios'][$index];
                    $total += $cantidad * $precio;
                }

                // Crear la factura
                $facturaId = $facturaService->CrearFactura($clienteId, $tipoPago, $esCredito, $total);
                if (!$facturaId) {
                    die("Error al crear la factura. Verifique la consulta SQL.");
                }

                // Agregar detalles
                foreach ($_POST['productos'] as $index => $productoId) {
                    $cantidad = $_POST['cantidades'][$index];
                    $precio = $_POST['precios'][$index];
                    $resultado = $facturaService->AgregarDetalle($facturaId, $productoId, $cantidad, $precio);

                    if (!$resultado) {
                        die("Error al agregar el detalle del producto con ID: $productoId.");
                    }
                }

                // Si todo salió bien, confirmar la transacción
                $facturaService->conn->commit();
                
                // Mostrar alerta con el ID de la factura y luego redireccionar
                echo "<script>
                    alert('Factura creada exitosamente. ID de la factura: " . $facturaId . "');
                    window.location.href = 'AddEditFactura.php';
                </script>";
                exit;

            } else {
                // Manejar el error de campos vacíos
                echo "<script>alert('Por favor complete todos los campos requeridos.');</script>";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            exit;
        }
    } 
    header("Location: AddEditFactura.php");
}
?>

    <div class="row">
        <form method="post" id="facturaForm" class="needs-validation" novalidate>
            <div class="col-md-3">
                <!-- Barra lateral para Cliente y Tipo de Pago -->
                <div class="card shadow-lg border-0 rounded-3 position-fixed" style="height: 100vh;">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold">Cliente y Tipo de Pago</h5>
                        
                        <!-- Seleccion de clientes -->
                        <div class="mb-3">
                            <label for="cliente" class="form-label fw-bold">Cliente</label>
                            <!-- Modificar el input del cliente para guardar el ID -->
                            <select class="form-select" id="cliente" name="cliente" required>
                                <option value="" class="fw-bold">Seleccionar Cliente</option>
                                <?php foreach ($Clientes as $cliente): ?>
                                    <option value="<?= $cliente['Id'] ?>"><?= $cliente['Nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Por favor seleccione un cliente</div>
                        </div>
                        
                        <!-- Seleccion del tipo de pago -->
                        <div class="mb-3">
                            <label for="tipoPago" class="form-label fw-bold">Tipo de Pago</label>
                            <select class="form-select" id="tipoPago" name="tipoPago" required>
                                <option value="" class="fw-bold" disabled>Seleccionar Tipo de Pago</option>
                                <option value="Efectivo" selected>Efectivo 💵</option>
                                <option value="Tarjeta">Tarjeta 💳</option>
                            </select>
                            <div class="invalid-feedback">Seleccione un tipo de pago</div>
                        </div>

                        <!-- Seleccion del tipo de venta -->
                        <div class="mb-3">
                            <label for="tiopVenta" class="form-label fw-bold">Tipo de Venta</label>
                            <select class="form-select" id="tiopVenta" name="tiopVenta" required>
                                <option value="" class="fw-bold" disabled>Seleccionar Tipo de Pago</option>
                                <option value="0" selected>Contado 💰</option>
                                <option value="1">Crédito 💳</option>
                            </select>
                            <div class="invalid-feedback">Seleccione un tipo de pago</div>
                        </div>

                        <!-- Agregar esto aquí -->
                        <div class="mb-3">
                            <div class="alert alert-info" role="alert">
                                <strong>Número de Factura:</strong> 
                                <?php 
                                    $ultimaFactura = $facturaService->ObtenerUltimaFactura();
                                    $siguienteNumero = $ultimaFactura ? $ultimaFactura['Id'] + 1 : 1;
                                    echo str_pad($siguienteNumero, 8, '0', STR_PAD_LEFT); 
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-9 offset-md-3 mt-4"> <!-- Card para Agregar Producto y Tabla de Productos -->
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <!-- Seleccionar producto -->
                            <div class="col-md-6">
                                <label for="producto" class="form-label fw-bold">Producto</label>
                                <select class="form-select" id="producto" name="producto">
                                    <option value="">Seleccionar Producto</option>
                                    <?php foreach ($Productos as $producto): ?>
                                        <option value="<?= $producto['Id'] ?>"><?= $producto['Descripcion'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- Seleccionar cantidad -->
                            <div class="col-md-2">
                                <label for="cantidad" class="form-label">Cantidad</label>
                                <input type="number" class="form-control" id="cantidad" name="cantidad" 
                                       min="1" value="1" required>
                            </div>
                            <!-- Boton para agregar detalles a la tabla -->
                            <div class="col align-self-end">
                                <button type="button" id="agregar-producto" class="btn btn-success w-100">
                                    <i class="bi bi-plus-circle me-1"></i>Agregar
                                </button>
                            </div>
                        </div>

                        <!-- Tabla de Productos -->
                        <div class="table-responsive mt-3">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Cantidad</th>
                                        <th>Producto</th>
                                        <th>Costo</th>
                                        <th>Total</th>
                                        <th>...</th>
                                    </tr>
                                </thead>
                                <tbody id="tabla-productos">
                                    <!-- Productos se agregarán dinámicamente aquí -->
                                    <tr id="no-productos" class="text-center" <?= count($Productos) > 0 ? 'style="display:none;"' : '' ?>>
                                        <td colspan="5">No hay productos agregados</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                        <td id="total-factura">$0.00</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary me-2" name="crear-factura">
                            <i class="bi bi-save me-1"></i>Guardar Factura
                        </button>
                        <button type="button" id="cancel-button" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i>Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const productosMap = <?= json_encode(array_map(function($price) { 
        return number_format($price, 2, '.', ''); // Cambiado para no usar coma como separador de miles
    }, $ProductoPrecios)) ?>;
    const tablaProductos = document.getElementById('tabla-productos');
    const agregarProductoBtn = document.getElementById('agregar-producto');
    const productoSelect = document.getElementById('producto');
    const cantidadInput = document.getElementById('cantidad');

    // Track added products to prevent duplicates
    const productosAgregados = new Set();

    agregarProductoBtn.addEventListener('click', function() {
        const productoId = productoSelect.value;
        const cantidad = parseInt(cantidadInput.value);
        
        // Validate inputs
        if (!productoId || cantidad <= 0) {
            alert('Por favor seleccione un producto y una cantidad válida');
            return;
        }

        // Prevent duplicate products
        if (productosAgregados.has(productoId)) {
            alert('Este producto ya ha sido agregado. Modifique la cantidad en la tabla.');
            return;
        }

        const productoNombre = productoSelect.options[productoSelect.selectedIndex].text;
        const precioUnitario = productosMap[productoId];
        const totalProducto = (precioUnitario * cantidad).toFixed(2);

        const nuevaFila = document.createElement('tr');
        nuevaFila.innerHTML = `
            <td class="w-25">
                <input type="number" class="form-control w-25 form-control-sm cantidad-producto" 
                    value="${cantidad}" min="1" 
                    data-producto-id="${productoId}">
            </td>
            <td>${productoNombre}</td>
            <td>
                $${parseFloat(precioUnitario).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}
            </td>
            <td>
                $${parseFloat(totalProducto).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger eliminar-producto">
                    <i class="bi bi-trash fw-bold text-black">DELETE</i>
                </button>
            </td>
        `;

        // Add hidden inputs for form submission
        nuevaFila.innerHTML += `
            <input type="hidden" name="productos[]" value="${productoId}">
            <input type="hidden" name="cantidades[]" value="${cantidad}">
            <input type="hidden" name="precios[]" value="${precioUnitario}">
        `;

        // Add event listener to delete button
        const eliminarBtn = nuevaFila.querySelector('.eliminar-producto');
        eliminarBtn.addEventListener('click', function() {
            productosAgregados.delete(productoId);
            tablaProductos.removeChild(nuevaFila);
            calcularTotal();
        });

        // Add event listener to quantity input
        const cantidadProductoInput = nuevaFila.querySelector('.cantidad-producto');
        // Update the total when quantity changes
        cantidadProductoInput.addEventListener('change', function() {
            const nuevaCantidad = parseInt(this.value);
            if (nuevaCantidad <= 0) {
                alert('La cantidad debe ser mayor a cero');
                this.value = 1; // Reset to default
                return;
            }
            const totalProducto = (nuevaCantidad * precioUnitario).toFixed(2);
            nuevaFila.children[3].innerText = `$${parseFloat(totalProducto).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            calcularTotal();
        });

        // Add the new row to the table
        tablaProductos.appendChild(nuevaFila);
        productosAgregados.add(productoId);
        calcularTotal();

        // Hide the "No Products" row if it is visible
        document.getElementById('no-productos').style.display = 'none';
    });

    // Calculate the total for the invoice
    function calcularTotal() {
        let total = 0;
        const filas = tablaProductos.querySelectorAll('tr');
        filas.forEach(fila => {
            const totalCell = fila.children[3]; // Total column
            if (totalCell) {
                const totalValue = parseFloat(totalCell.innerText.replace('$', '').replace(',', ''));
                total += isNaN(totalValue) ? 0 : totalValue;
            }
        });
        document.getElementById('total-factura').innerText = `$${total.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
    }

    // Optional: Form submission handler
    document.getElementById('facturaForm').addEventListener('submit', function(e) {
        if (tablaProductos.children.length === 0) {
            e.preventDefault();
            alert('Debe agregar al menos un producto a la factura');
        }
    });
});
</script>

<?php require_once "../Shared/Footer.php"; ?>