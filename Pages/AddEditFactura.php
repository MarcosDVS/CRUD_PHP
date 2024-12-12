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
?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-12">
            <div class="card shadow-lg border-0 rounded-3">
                <form method="post" id="facturaForm" class="needs-validation" novalidate>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <!-- Cliente y Tipo de Pago -->
                            <div class="col-md-6">
                                <label for="cliente" class="form-label">Cliente</label>
                                <select class="form-select" id="cliente" name="cliente" required>
                                    <option value="">Seleccionar Cliente</option>
                                    <?php foreach ($Clientes as $cliente): ?>
                                        <option value="<?= $cliente['id'] ?>"><?= $cliente['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Por favor seleccione un cliente</div>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="tipoPago" class="form-label">Tipo de Pago</label>
                                <select class="form-select" id="tipoPago" name="tipoPago" required>
                                    <option value="">Seleccionar Tipo de Pago</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Tarjeta">Tarjeta</option>
                                </select>
                                <div class="invalid-feedback">Seleccione un tipo de pago</div>
                            </div>

                            <!-- Sección de Agregar Productos -->
                            <div class="col-md-6">
                                <div class="card bg-light mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Agregar Producto</h5>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="producto" class="form-label">Producto</label>
                                                <select class="form-select" id="producto" name="producto" required>
                                                    <option value="">Seleccionar Producto</option>
                                                    <?php foreach ($Productos as $producto): ?>
                                                        <option value="<?= $producto['Id'] ?>"><?= $producto['Descripcion'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="cantidad" class="form-label">Cantidad</label>
                                                <input type="number" class="form-control" id="cantidad" name="cantidad" 
                                                       min="1" value="1" required>
                                            </div>
                                            <div class="col align-self-end">
                                                <button type="button" id="agregar-producto" class="btn btn-success w-100">
                                                    <i class="bi bi-plus-circle me-1"></i>Agregar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabla de Productos -->
                            <div class="col-md-6">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="table-primary">
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
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-save me-1"></i>Guardar Factura
                        </button>
                        <button type="button" id="cancel-button" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i>Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
        cantidadProductoInput.addEventListener('change', function() {
            const nuevaCantidad = parseInt(this.value);
            const productoId = this.getAttribute('data-producto-id');
            const precioUnitario = productosMap[productoId];
            const nuevoTotal = (precioUnitario * nuevaCantidad).toFixed(2);
            
            // Update total cell and hidden input
            const totalCelda = this.closest('tr').querySelector('td:nth-child(4)');
            totalCelda.textContent = `$${nuevoTotal}`;
            
            // Call calcularTotal to update the overall total
            calcularTotal();
        });

        tablaProductos.appendChild(nuevaFila);
        productosAgregados.add(productoId);

        // Reset form
        productoSelect.selectedIndex = 0;
        cantidadInput.value = 1;

        calcularTotal();
    });

    function calcularTotal() {
        const filas = tablaProductos.querySelectorAll('tr');
        let total = 0;
        
        filas.forEach(fila => {
            const totalCelda = fila.querySelector('td:nth-child(4)');
            if (totalCelda) {
                total += parseFloat(totalCelda.textContent.replace('$', '').replace(',', ''));
            }
        });

        // Update total display with formatted currency
        document.getElementById('total-factura').textContent = 
            '$' + total.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
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