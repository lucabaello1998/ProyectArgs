<?php
include("../db.php");
session_start();
if(!$_SESSION['tipo_us'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$tipo = $_SESSION['tipo_us'];
if($tipo == "Administrador") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}

$indumentaria = '';

if  (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "SELECT * FROM indumentaria_user WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $indumentaria = $row['indumentaria'];
  }
}

if (isset($_POST['update'])) {
  $id = $_GET['id'];
  $indumentaria= $_POST['indumentaria'];

  $query = "UPDATE indumentaria_user set indumentaria = '$indumentaria' WHERE id=$id";
  mysqli_query($conn, $query);
  $_SESSION['card'] = 1;
  $_SESSION['message'] = 'Indumentaria actualizado';
  $_SESSION['message_type'] = 'warning';
  header('Location: ../Basico/herramientas.php');

}
?>

<?php include('../includes/header.php'); ?>
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <div class="card card-body">
            <form action="edit_user_indumentaria.php?id=<?php echo $_GET['id']; ?>" method="POST">
              <p class="h4 mb-4 text-center">Actualizar indumentaria</p>
              <div class="form-row">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Indumentaria</label >
                  <input type="text" name="indumentaria" class="form-control" value="<?php echo $indumentaria; ?>" autofocus>
                </div>
              </div>
            
              <input type="submit" name="update" class="btn btn-success btn-block" value="Actualizar indumentaria">

            </form>
          </div>
        </div>
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
</body>
</html>
