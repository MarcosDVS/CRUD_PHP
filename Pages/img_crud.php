<?php 
  require_once "../Shared/Header.php";
  require_once "../Service/imgService.php";

  $imagenService = new imgService();
  $Imagenes = $imagenService->Consultar();
?>

<div class="container mt-4">

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva imagen</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="" enctype="multipart/form-data" method="POST">
                <input type="file" class="form-control mb-2" name="input-imagen">
                <input type="submit" value="Registrar" name="btn-registrar" class="form-control btn btn-primary">
            </form>
        </div>
        <div class="modal-footer">
            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
        </div>
    </div>
    </div>

    <table class="table table-striped">
      <thead class="table-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Foto</th>
          <th scope="col">...</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($Imagenes as $item): ?>
          <tr>
            <th><?= $item['Id_img'] ?></th>
            <td><img src="<?= $item['Foto'] ?>" alt="" width="80"></td>
            <td>
              <a href="" class="btn btn-warning">Editar</a>
              <a href="" class="btn btn-danger">Eliminar</a>
            </td>
          </tr>
          <?php endforeach; ?>
      </tbody>
    </table>

</div>
<?php require_once"../Shared/Footer.php" ?>