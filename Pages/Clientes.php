<?php
require_once "../Shared/Header.php";
require_once "../Service/ClienteService.php";
require_once "../Service/Utils.php"; // Incluir el nuevo archivo
$clienteService = new ClienteService();
$Clientes = $clienteService->Consultar();

// Referencia a los servicios para la entidad cliente
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $clienteService->manejarPost($_POST); // Llamada al nuevo método
    header("Location: Clientes.php");
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
                <?php include 'AddEditClientes.php'; ?>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <h2>Listado de Clientes</h2>
    <a onclick="showForm(0);"class="btn btn-primary mb-3 text-black">Agregar Cliente</a>
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($Clientes as $cliente): ?>
                <tr>
                    <td><?= $cliente['Id'] ?></td>
                    <td><?= $cliente['Nombre'] ?></td>
                    <td><?= $cliente['Direccion'] ?></td>
                    <td> <!--  Para manejar el formato de esta propieda cree el archivo Utils.php -->
                        <?= formatPhoneNumber($cliente['Telefono']) ?>
                    </td>
                    <td>
                        <a class="btn btn-warning btn-sm fw-bold" onclick="showForm(<?php echo $cliente['Id']; ?>);
                            fillForm('<?php echo $cliente['Id']; ?>', '<?php echo $cliente['Nombre']; ?>', 
                            '<?php echo $cliente['Direccion']; ?>', '<?php echo $cliente['Telefono']; ?>');">
                            EDIT
                        </a>

                        <button type="button" class="btn btn-danger btn-sm text-black fw-bold" 
                        onclick="if(confirmDelete()) { 
                            document.getElementById('deleteForm<?php echo $cliente['Id']; ?>').submit(); }">
                            DELETE
                        </button>
                        <form id="deleteForm<?php echo $cliente['Id']; ?>" method="post" style="display:none;">
                            <input type="hidden" name="id" value="<?php echo $cliente['Id']; ?>">
                            <input type="hidden" name="eliminar-cliente" value="1">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Referencia a los metodos Javascript en ArticuloMethod.js -->
<script src="../Shared/js/ClienteMethod.js"></script>

<?php require_once "../Shared/Footer.php"; ?>