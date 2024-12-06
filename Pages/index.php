<?php
require_once "../Service/ArticuloService.php";
require_once "../Shared/Header.php";

$service = new ArticuloService();
$articulos = $service->getAll();

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

<div class="container mt-4">
    <h2>CRUD de Articulo</h2>
    
    <!-- Modal para el formulario de nuevo artículo -->
    <div id="formModal" class="modal" tabindex="-1" role="dialog" style="display:none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Artículo</h5>
                    <!-- <button type="button" class="close" onclick="hideForm();" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>
                <div class="modal-body">
                    <?php include 'AddEditArticulo.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <button id="newButton" class="btn btn-primary mb-3 fw-bold" onclick="showForm();">NEW</button>

    <h3 class="mt-4">Lista de Artículos</h3>
    <table class="table table-striped">
        <thead>
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
                        <form method="post" style="display:inline;" onsubmit="event.preventDefault(); fillForm('<?php echo $articulo['Id']; ?>', '<?php echo $articulo['Descripcion']; ?>', '<?php echo $articulo['P_Compra']; ?>', '<?php echo $articulo['P_Venta']; ?>');">
                            <input type="hidden" name="id" value="<?php echo $articulo['Id']; ?>">
                            <button type="button" name="edit" class="btn btn-warning btn-sm" onclick="showForm(); fillForm('<?php echo $articulo['Id']; ?>', '<?php echo $articulo['Descripcion']; ?>', '<?php echo $articulo['P_Compra']; ?>', '<?php echo $articulo['P_Venta']; ?>');">
                                <b>EDIT</b>
                            </button>
                        </form>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $articulo['Id']; ?>">
                            <button type="submit" name="delete" class="btn btn-danger btn-sm">
                                <b>DELETE</b>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    function showForm() {
        document.getElementById('formModal').style.display = 'block';
    }

    function hideForm() {
        document.getElementById('formModal').style.display = 'none';
    }
</script>

<?php require_once "../Shared/Footer.php"; ?>
