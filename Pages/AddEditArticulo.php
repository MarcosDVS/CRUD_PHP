<?php
// Este archivo contiene el formulario para crear y editar artículos.
?>

<div class="col-md-12">
    <form method="post" class="row g-3 p-4 bg-light border rounded">
        <input type="hidden" name="id" id="id">
        <div class="col-md-12">
            <label for="descripcion" class="form-label fw-bold">Descripción</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
        </div>
        <div class="col-md-6">
            <label for="p_compra" class="form-label fw-bold">Precio de Compra</label>
            <input type="number" step="0.01" class="form-control" id="p_compra" name="p_compra" required>
        </div>
        <div class="col-md-6">
            <label for="p_venta" class="form-label fw-bold">Precio de Venta</label>
            <input type="number" step="0.01" class="form-control" id="p_venta" name="p_venta" required>
        </div>
        <div class="col-md-12 text-center mt-3">
            <button type="submit" id="submit-button" name="create" class="btn btn-success fw-bold me-2">
                Crear
            </button>
            <button type="button" id="cancel-button" class="btn btn-secondary fw-bold" onclick="clearForm()">
                Cancelar
            </button>
        </div>
    </form>
</div>

<script>
    function fillForm(id, descripcion, p_compra, p_venta) {
        document.getElementById('id').value = id;
        document.getElementById('descripcion').value = descripcion;
        document.getElementById('p_compra').value = p_compra;
        document.getElementById('p_venta').value = p_venta;
        document.getElementById('submit-button').innerText = 'Modificar'; // Cambia el texto del botón
        document.getElementById('submit-button').name = 'update'; // Cambia el name del botón a 'update'
    }
    function clearForm() {
        document.getElementById('id').value = '';
        document.getElementById('descripcion').value = '';
        document.getElementById('p_compra').value = '';
        document.getElementById('p_venta').value = '';
        document.getElementById('submit-button').innerText = 'Crear'; // Restablece el texto del botón
        document.getElementById('submit-button').name = 'create'; // Restablece el nombre del botón a 'create'
        hideForm(); // Cierra el modal
    }
</script>