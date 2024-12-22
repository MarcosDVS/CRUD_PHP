<?php
require_once "../Header.php";
require_once "../Service/FacturaService.php";

$facturaService = new FacturaService();
$facturas = $facturaService->ConsultarFacturas();

foreach ($facturas as &$factura) {
    // Recuperar los abonos para cada factura
    $factura['Abonos'] = $facturaService->ConsultarAbonosPorFactura($factura['Id']);
}
?>

<div class="container mt-4">
    <div class="row mt-4 d-flex justify-content-between align-items-center">
        <div class="col">
            <h3 class="fw-bold">Listado de Facturas</h3>

        </div>
        <div class="col-3">
            <!-- Menú desplegable para filtrar las facturas -->
            <form method="GET" class="mb-3">
                <select name="tipoFactura" id="tipoFactura" class="form-select" onchange="this.form.submit()">
                    <option value="Contado" selected <?= isset($_GET['tipoFactura']) && $_GET['tipoFactura'] == 'Contado' ? 'selected' : '' ?>>Contado</option>
                    <option value="Credito" <?= isset($_GET['tipoFactura']) && $_GET['tipoFactura'] == 'Credito' ? 'selected' : '' ?>>Crédito</option>
                    <option value="Pendiente" <?= isset($_GET['tipoFactura']) && $_GET['tipoFactura'] == 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                </select>
            </form>

        </div>
        

    </div>

    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Tipo Pago</th>
                <th>Total</th>
                <?php
                // Filtrar las facturas según el tipo seleccionado
                $tipoFactura = $_GET['tipoFactura'] ?? '';
                ?>
                <?php if ($tipoFactura === 'Credito' || $tipoFactura === 'Pendiente'): ?>
                    <th>Abonos</th>
                    <th>Pendiente</th>
                <?php endif; ?>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($facturas as $factura): 
                $importe = array_sum($factura['Abonos']) - $factura['Total'];
                if (($tipoFactura == 'Contado' && $importe !== 0 && $factura['EsCredito'] === "1") || 
                    ($tipoFactura == 'Credito' && $importe < 0 && $factura['EsCredito'] === "0") || 
                    ($tipoFactura == 'Pendiente' && $importe < 0 && $factura['EsCredito'] === "0")) {
                    continue; // Saltar facturas que no coinciden con el filtro
                }
            ?>
                <tr>
                    <th><?= $factura['Id'] ?></th>
                    <td><?= $factura['Cliente'] ?: 'Cliente Frecuente' ?></td>
                    <td><?= $factura['Fecha'] ?></td>
                    <td><?= $factura['TipoPago'] ?></td>
                    <th>$<?= number_format($factura['Total'], 2) ?></th>
                    <?php if ($tipoFactura === 'Credito' || $tipoFactura === 'Pendiente'): ?>
                        <td>$<?= number_format(array_sum($factura['Abonos']), 2) ?></td>
                        <th>$<?= number_format($importe, 2) ?></th>
                    <?php endif; ?>
                    <td>
                        <a href="AddEditFactura.php?id=<?= $factura['Id'] ?>" class="btn btn-primary">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once "../Footer.php"; ?>
