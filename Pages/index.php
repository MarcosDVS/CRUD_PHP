<?php
// Referencia al head de la pagina
require_once "../Shared/Header.php";
// Referencia a los servicios para la entidad articulo
require_once "../Service/ArticuloService.php";
// Referencia a los servicios para la entidad articulo
$artService = new ArticuloService();

$Articulos = $artService->Consultar(); // Consulta los datos

// Referencia a los servicios para la entidad articulo
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $artService->manejarPost($_POST); // Llamada al nuevo método
    header("Location: index.php");
}
?>

<div class="container mt-4">
    <!-- Modal para el formulario de nuevo artículo -->
    <div id="formModal" class="modal" tabindex="-1" role="dialog" style="display:none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title fw-bold" id="modalTitle"></h5>
                </div>
                <div class="modal-body">
                    <!-- Referencia al formulario de los articulos -->
                    <?php include 'AddEditArticulo.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <button id="newButton" class="btn btn-primary mb-3 text-black" onclick="showForm(0);">
                Agregar producto
            </button>
        </div>
        <div class="col text-end">
            <h3 class="fw-bold">Item list</h3>
        </div>
    </div>

    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>P. Compra</th>
                <th>P. Venta</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($Articulos as $item): ?>
                <tr>
                    <td><?php echo $item['Id']; ?></td>
                    <td><?php echo $item['Descripcion']; ?></td>
                    <td>$<?= number_format($item['P_Compra'], 2) ?></td>
                    <td>$<?= number_format($item['P_Venta'], 2) ?></td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm fw-bold" 
                            onclick="showForm(<?php echo $item['Id']; ?>); 
                            fillForm('<?php echo $item['Id']; ?>', '<?php echo $item['Descripcion']; ?>', 
                            '<?php echo $item['P_Compra']; ?>', '<?php echo $item['P_Venta']; ?>');">
                            EDIT
                        </button>
                        <button type="button" class="btn btn-danger btn-sm text-black fw-bold" 
                            onclick="if(confirmDelete()) { 
                                document.getElementById('deleteForm<?php echo $item['Id']; ?>').submit(); }">
                            DELETE
                        </button>
                        <form id="deleteForm<?php echo $item['Id']; ?>" method="post" style="display:none;">
                            <input type="hidden" name="id" value="<?php echo $item['Id']; ?>">
                            <input type="hidden" name="eliminarItem" value="1">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Referencia a los metodos Javascript en ArticuloMethod.js -->
    <script src="../Shared/js/ArticuloMethod.js"></script>
</div>
<!-- Referencia al pie de pagina que se encuentra en Shared -->
<?php require_once "../Shared/Footer.php"; ?>
