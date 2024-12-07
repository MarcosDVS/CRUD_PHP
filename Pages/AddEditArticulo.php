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
            <button type="submit" id="submit-button" name="create" class="btn btn-success fw-bold me-2 text-black">
                Create
            </button>
            <button type="button" id="cancel-button" class="btn btn-secondary fw-bold text-black" onclick="clearForm()">
                Cancel
            </button>
        </div>
    </form>
</div>

<script src="../Shared/js/ArticuloMethod.js"></script>