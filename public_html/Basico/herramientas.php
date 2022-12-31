<?php include("../db.php"); ?>

<!-----Administrador---->
<?php
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$tipo = $_SESSION['tipo_us'];
if($tipo != "Administrador") /////Visor - Deposito - Supervisor - Despacho/////
{
header("location: ../index.php");
}
?>
<!-----Administrador---->
<?php include('../includes/header.php'); ?>
<main class="container p-2">
  <div class="row">
    <div class="col-lg">

      <!-- MESSAGES -->
      <?php session_start();      
       if ($_SESSION['card'] == 1) { ?>
      <div class="alert alert-<?= $_SESSION['message_type']?> alert-dismissible fade show" role="alert">
        <?= $_SESSION['message']?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php $_SESSION['card'] = 0; } ?>
<!-- MESSAGES -->
      <div class="card card-body">
        <form action="../Guardar/save_herramientas.php" method="POST">

          <p class="h4 mb-4 text-center">Carga de herramientas</p>
          <div class="form-row">
            <div class="form-group col">
              <label for="exampleFormControlSelect1">Herramienta</label >
              <input type="text" name="herramienta" maxlength="255"  class="form-control" autofocus required>
            </div>
          </div>
          <input type="submit" name="save_herramienta" class="btn btn-success btn-block" value="Guardar herramienta">
        </form>
      </div>
    </div>
  </div>  
</main>

<main class="container p-2">
  <div class="row">
    <div class="col-lg">
      <div class="card card-body">
        <form action="../Guardar/save_user_indumentaria.php" method="POST">
          <p class="h4 mb-4 text-center">Carga de indumentaria</p>
          <div class="form-row">
            <div class="form-group col">
              <label for="exampleFormControlSelect1">Indumentaria</label >
              <input type="text" name="indumentaria" maxlength="255"  class="form-control" autofocus required>
            </div>
          </div>
          <input type="submit" name="save_indumentaria" class="btn btn-success btn-block" value="Guardar indumentaria">
        </form>
      </div>
    </div>
  </div>  
</main>

<main class="container p-2">
  <div class="row">
    <div class="col-lg">
      <div class="card card-body">
        <form action="../Guardar/save_user_vehiculo.php" method="POST">
          <p class="h4 mb-4 text-center">Carga de vehiculo</p>
          <div class="form-row">
            <div class="form-group col">
              <label for="exampleFormControlSelect1">Indumentaria</label >
              <input type="text" name="vehiculo" maxlength="255"  class="form-control" autofocus required>
            </div>
          </div>
          <input type="submit" name="save_vehiculo" class="btn btn-success btn-block" value="Guardar vehiculo">
        </form>
      </div>
    </div>
  </div>  
</main>



<div class="container p-5">
  <div class="row">
    <div class="col-lg">
      <p class="h4 mb-4 text-center">Herramientas</p>
      <div class="container">
        <table class="table table-responsive table-striped table-bordered" align="center">
          <thead class="thead-dark text-center">
            <tr>
              <th>Acciones</th>
              <th>Herramientas</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = "SELECT * FROM herramienta ORDER BY herramienta desc";
            $result_tasks = mysqli_query($conn, $query);
            while($row = mysqli_fetch_assoc($result_tasks)) { ?>
              <tr>
                <td align="center">
                  <a href="../Editar/edit_herramientas.php?id=<?php echo $row['id']?>">
                    <i class="fas fa-pen p-2"></i>
                  </a>
                  <a href="../Borrar/delete_herramientas.php?id=<?php echo $row['id']?>">
                    <i class="far fa-trash-alt  p-2"></i>
                  </a>
                </td>
                <td><?php echo $row['herramienta']; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="container p-5">
  <div class="row">
    <div class="col-lg">
      <p class="h4 mb-4 text-center">Indumentaria</p>
      <div class="container">
        <table class="table table-responsive table-striped table-bordered" align="center">
          <thead class="thead-dark text-center">
            <tr>
              <th>Acciones</th>
              <th>Indumentaria</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = "SELECT * FROM indumentaria_user ORDER BY indumentaria desc";
            $result_tasks = mysqli_query($conn, $query);
            while($row = mysqli_fetch_assoc($result_tasks)) { ?>
              <tr>
                <td align="center">
                  <a href="../Editar/edit_user_indumentaria.php?id=<?php echo $row['id']?>">
                    <i class="fas fa-pen p-2"></i>
                  </a>
                  <a href="../Borrar/delete_user_indumentaria.php?id=<?php echo $row['id']?>">
                    <i class="far fa-trash-alt  p-2"></i>
                  </a>
                </td>
                <td><?php echo $row['indumentaria']; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<div class="container p-5">
  <div class="row">
    <div class="col-lg">
      <p class="h4 mb-4 text-center">Vehiculo</p>
      <div class="container">
        <table class="table table-responsive table-striped table-bordered" align="center">
          <thead class="thead-dark text-center">
            <tr>
              <th>Acciones</th>
              <th>Vehiculo</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = "SELECT * FROM vehiculo_user ORDER BY vehiculo desc";
            $result_tasks = mysqli_query($conn, $query);
            while($row = mysqli_fetch_assoc($result_tasks)) { ?>
              <tr>
                <td align="center">
                  <a href="../Editar/edit_user_vehiculo.php?id=<?php echo $row['id']?>">
                    <i class="fas fa-pen p-2"></i>
                  </a>
                  <a href="../Borrar/delete_user_vehiculo.php?id=<?php echo $row['id']?>">
                    <i class="far fa-trash-alt  p-2"></i>
                  </a>
                </td>
                <td><?php echo $row['vehiculo']; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- PIE DE PAGINA -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- then Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>