<?php
// Referencia al head de la pagina
require_once "../Shared/Header.php";
// Referencia a los servicios para la entidad articulo
require_once "../Service/ArticuloService.php";
// Referencia a los servicios para la entidad articulo
$service = new ArticuloService();
$articulos = $service->getAll();
// Referencia a los servicios para la entidad articulo
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        $service->create($_POST['descripcion'], $_POST['p_compra'], $_POST['p_venta']);
    } elseif (isset($_POST['update'])) {
        $service->update($_POST['id'], $_POST['descripcion'], $_POST['p_compra'], $_POST['p_venta']);
    } elseif (isset($_POST['delete'])) {
        $service->delete($_POST['id']);
    }
    header("Location: index.php");
}
?>


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
        <button id="newButton" class="btn btn-success mb-3 fw-bold text-black" onclick="showForm(0);">
            NEW
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
        <?php foreach ($articulos as $articulo): ?>
            <tr>
                <td><?php echo $articulo['Id']; ?></td>
                <td><?php echo $articulo['Descripcion']; ?></td>
                <td><?php echo $articulo['P_Compra']; ?></td>
                <td><?php echo $articulo['P_Venta']; ?></td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $articulo['Id']; ?>">
                        <button type="button" name="edit" class="btn btn-warning btn-sm" onclick="showForm(<?php echo $articulo['Id']; ?>); fillForm('<?php echo $articulo['Id']; ?>', '<?php echo $articulo['Descripcion']; ?>', '<?php echo $articulo['P_Compra']; ?>', '<?php echo $articulo['P_Venta']; ?>');">
                            <b>EDIT</b>
                        </button>
                    </form>
                    <form method="post" style="display:inline;" onsubmit="return confirmDelete();">
                        <input type="hidden" name="id" value="<?php echo $articulo['Id']; ?>">
                        <button type="submit" name="delete" class="btn btn-danger btn-sm text-black">
                            <b>DELETE</b>
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    // Funciones java para mostrar y ocultar el modal que posee el formulario
    function showForm(id) {
        document.getElementById('formModal').style.display = 'block';
        document.getElementById('modalTitle').textContent = id === 0 ? 'New item' : 'Updating item';
    }
    function hideForm() {
        document.getElementById('formModal').style.display = 'none';
    }
    function confirmDelete() {
        return confirm("Are you sure you want to delete this?");
    }
</script>

<!-- Referencia al pie de pagina que se encuentra en Shared -->
<?php require_once "../Shared/Footer.php"; ?>
