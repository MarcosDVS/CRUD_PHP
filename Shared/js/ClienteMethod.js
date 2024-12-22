// Muestra el formulario en el archivo.php y modifica el
//titulo del mismo dependiendo si vas a crear un articulo
//o editar la informacion de uno ya existente
function showForm(id) {
    document.getElementById('formModal').style.display = 'block';
    document.getElementById('modalTitle').textContent = id === 0 ? 'New customer' : 'Updating customer';
}
// Oculta el formulario en el archivo index.php
function hideForm() {
    document.getElementById('formModal').style.display = 'none';
}
// Abre una ventana flotante para confirmar si deseas eliminar un registro
function confirmDelete() {
    return confirm("Are you sure you want to delete this?");
}

// Recolecta informacion de un registro en el index al utilizar
//el boton EDIT y la inserta en el formulario AddEditArticulo
//ademas cambia el metodo del boton Create de Crear a Editar
function fillForm(id, nombre, direccion, telefono) { // almacenan los valores
    // Asignan los valores almacenados a los inputs
    document.getElementById('id').value = id;
    document.getElementById('nombre').value = nombre;
    document.getElementById('direccion').value = direccion;
    document.getElementById('telefono').value = telefono;
    document.getElementById('submit-button').innerText = 'Update'; // Cambia el texto del botón
    document.getElementById('submit-button').name = 'editar-cliente'; // Cambia el name del botón a 'update'
}

// Limpia el formulario
function clearForm() {
    document.getElementById('id').value = '';
    document.getElementById('nombre').value = '';
    document.getElementById('direccion').value = '';
    document.getElementById('telefono').value = '';
    document.getElementById('submit-button').innerText = 'Create'; // Restablece el texto del botón
    document.getElementById('submit-button').name = 'crear-cliente'; // Restablece el nombre del botón a 'create'
    hideForm(); // Cierra el modal
}
