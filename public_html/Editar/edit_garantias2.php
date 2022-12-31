<?php
include("../db.php");
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$nombre_us = $_SESSION['nombre'];
$apellido_us = $_SESSION['apellido'];
if($nombre_us == "Damian" && $apellido_us == 'Duarte') { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}
$tecnico = '';
$tecrep= '';

if(isset($_GET['id']))
{
  $id = $_GET['id'];
  $result = mysqli_query($conn, "SELECT * FROM garantias WHERE id=$id");
  if (mysqli_num_rows($result) == 1)
  {
    $row = mysqli_fetch_array($result);
    $tecnico = $row['tecnico'];
    $ot = $row['ot'];
    $tecrep = $row['tecrep'];
  }
}

if (isset($_POST['update']))
{
  $id = $_GET['id'];
  $tecnico= $_POST['tecnico'];
  $tecrep = $_POST['tecrep'];

  $result = mysqli_query($conn, "UPDATE garantias set tecnico = '$tecnico', tecrep = '$tecrep' WHERE id=$id");
  if(!$result)
  {
    $titulo_toast = "Error";
    $msj_toast = "Hubo un error interno al guardar el proceso";
    $color_toast = "danger";
  }
  else
  {
    $titulo_toast = "Guardado";
    $msj_toast = "La garantia de " .$tecnico ." fue actualizada.";
    $color_toast = "success";
  }
  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
  header('Location: ../Basico/produccion2.php');
}

?>
<?php include('../includes/header.php'); ?>
<div class="container-fluid p-4">
  <div class="row p-2">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <form action="edit_garantias2.php?id=<?php echo $_GET['id']; ?>" method="POST">
            <p class="h4 mb-4 text-center">Actualizar la garantia de <?php echo $tecnico; ?></p>
            <div class="form-row">
              <div class="form-group col">
                <label>Tecnico responsable</label >
                <select type="text" name="tecnico" class="form-control">                
                    <option selected><?php echo $tecnico; ?></option>                
                    <?php
                      $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?>   
                      <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>
                    <?php endforeach ?>
                </select>
              </div>  
              <div class="form-group col">
                <label>OT</label >
                <input type="number" value="<?php echo $ot; ?>" class="form-control" readonly>
              </div>
              <div class="form-group col">
                <label>Tecnico que lo reparo</label >
                <select type="text" name="tecrep" class="form-control">                
                  <option selected><?php echo $tecrep; ?></option>                
                  <?php
                    $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                  ?>
                  <?php foreach ($ejecutar as $opciones): ?>   
                    <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                  <?php endforeach ?>
                </select>
              </div>
            </div>
            <input type="submit" name="update" class="btn btn-success btn-block" value="Actualizar garantia">
          </form>
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
