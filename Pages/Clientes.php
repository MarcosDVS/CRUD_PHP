<?php
require_once "../Shared/Header.php";
require_once "../Service/ClienteService.php";

$clienteService = new ClienteService();
$Clientes = $clienteService->Consultar();

// Referencia a los servicios para la entidad articulo
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['crear-cliente'])) {
        $clienteService->Crear($_POST['nombre'], $_POST['direccion'], $_POST['telefono']);
    } 
    elseif (isset($_POST['editar-cliente'])) {
        $clienteService->Editar($_POST['id'], $_POST['nombre'], $_POST['direccion'], $_POST['telefono']);
    } 
    elseif (isset($_POST['eliminar-cliente'])) {
        $clienteService->Eliminar($_POST['id']);
    }
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
    <a onclick="showForm(0);"class="btn btn-primary mb-3">Agregar Cliente</a>
    <table class="table table-striped">
        <thead>
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
                    <td><?= $cliente['Telefono'] ?></td>
                    <td>
                        <a href="AddEditClientes.php?id=<?= $cliente['Id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <form method="post" action="../Service/ClienteService.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $cliente['Id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
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