<?php
// Este archivo contiene el formulario para crear y editar clientes.
?>

    <form method="post" class="row g-3 p-4 bg-light border rounded">
        <input type="hidden" id="id" name="id">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion">
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono">
        </div>
        <button type="submit" class="btn btn-primary" id="submit-button" name="crear-cliente">Create</button>
        <a href="Clientes.php" class="btn btn-secondary">Cancelar</a>
    </form>
