<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">CRUD Articulo</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <!-- Ruta corregida para Productos (index.php) -->
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" aria-current="page" href="index.php">Productos</a>
                </li>
                <li class="nav-item">
                    <!-- Ruta corregida para img_crud.php -->
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'img_crud.php' ? 'active' : ''; ?>" aria-current="page" href="img_crud.php">Imagen</a>
                </li>
                <li class="nav-item">
                    <!-- Ruta corregida para Clientes.php -->
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'Clientes.php' ? 'active' : ''; ?>" aria-current="page" href="Clientes.php">Clientes</a>
                </li>
                <li class="nav-item">
                    <!-- Ruta corregida para Facturas.php -->
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'Facturas.php' ? 'active' : ''; ?>" aria-current="page" href="Facturas.php">Facturas</a>
                </li>
                <li class="nav-item">
                    <!-- Ruta corregida para AddEditFactura.php -->
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'AddEditFactura.php' ? 'active' : ''; ?>" aria-current="page" href="AddFactura.php">Vender</a>
                </li>
                <li class="nav-item">
                    <!-- Ruta corregida para about.php -->
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>" href="about.php">About</a>
                </li>
                <!-- Asegúrate de que todas las rutas sean correctas y que los archivos existan en las ubicaciones especificadas -->
            </ul>
        </div>
    </div>
</nav>
