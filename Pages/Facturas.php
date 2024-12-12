<?php
require_once "../Shared/Header.php";
require_once "../Service/FacturaService.php";

$facturaService = new FacturaService();
$facturas = $facturaService->ConsultarFacturas();

?>


<h3 class="text-center fw-bold">Listado de Facturas</h3>
<table class="table table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Tipo Pago</th>
            <th>Total</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($facturas as $factura): ?>
            <tr>
                <td><?= $factura['Id'] ?></td>
                <td><?= $factura['Cliente'] ?: 'Cliente Frecuente' ?></td>
                <td><?= $factura['Fecha'] ?></td>
                <td><?= $factura['TipoPago'] ?></td>
                <td>$<?= number_format($factura['Total'], 2) ?></td>
                <td>
                    <a href="AddEditFactura.php?id=<?= $factura['Id'] ?>" class="btn btn-primary">Editar</a>
                    <a href="DeleteFactura.php?id=<?= $factura['Id'] ?>" class="btn btn-danger">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once "../Shared/Footer.php"; ?>
