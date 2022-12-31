<?php include("../db.php"); ?>
<!-----Supervisor---->
<?php
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$tipo = $_SESSION['tipo_us'];
if($tipo == "Administrador") { $usu = 1; }
if($tipo == "Despacho") { $usu = 1; }
if($tipo == "Supervisor") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");   /////Visor - Deposito/////
}else{
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
$supervisor = $nombre ." " .$apellido;
}

?>


<?php include('../includes/header.php'); ?>
<?php
$mes = "20" .date ('y-m', strtotime('-0 month'));
if(isset($_POST['meses']))
{
  $mes1 = $_POST['mes'];
  $mes = "20" .date ('y-m', strtotime($mes1));
}
?>

<?php 
if  (isset($_GET['id']))
{
  $id = $_GET['id'];
  $query = "SELECT * FROM auditoria_vehiculo WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1)
  {
    $row = mysqli_fetch_array($result);
    $identificador = $row['identificador'];
    $super = $row['supervisor'];
    $tecnico = $row['tecnico'];
    $fecha = $row['fecha'];
    $imagenprimera = $row['imagenpri'];
    $imagensegunda = $row['imagenseg'];
    $imagentercera = $row['imagenter'];
    $imagencuarta = $row['imagencuar'];
    $obs = $row['obs'];


  }
}
?>


<div class="container p-2">
  <div class="row">
    <div class="col-md">
      <div class="card card-body">
        <p class="h3 mb-4 text-center">Auditoria <?php echo $identificador; ?></p>
        <p class="h5 mb-4 text-center">el <?php echo $fecha ?></p>
        <p class="h6 mb-4 text-center">por <?php echo $super ?></p>
        <br>
        <div class="row justify-content-start">
          <div class="col-6">
          </div>
        </div>

        <div class="row justify-content-start">
          <div class="col">      
              <p class="h5 text-start"><b>Tecnico:</b> <?php echo $tecnico; ?></p>      
          </div>
        </div>

        <div class="row justify-content-start">
          <div class="col-12">      
              <p class="h5 text-start"><b>Observaciones:</b> <?php echo $obs; ?></p>      
          </div>
        </div>

        <?php if ($imagenprimera == "") 
          {
            echo "";
          }
          else 
          { ?> 
        <div class="row align-items-center">
          <img src="<?php echo "../Archivos/foto_vehiculos/" .$imagenprimera; ?>" alt="<?php echo $imagenpri; ?>" width="50%" height="50%">
        </div>
        <?php } ?>


        <?php if ($imagensegunda == "") 
          {
            echo "";
          }
          else 
          { ?> 
        <div class="row align-items-center">
          <img src="<?php echo "../Archivos/foto_vehiculos/" .$imagensegunda; ?>" alt="<?php echo $imagenseg; ?>" width="50%" height="50%">
        </div>
        <?php } ?>


        <?php if ($imagentercera == "") 
          {
            echo "";
          }
          else 
          { ?> 
        <div class="row align-items-center">
          <img src="<?php echo "../Archivos/foto_vehiculos/" .$imagentercera; ?>" alt="<?php echo $imagenter; ?>" width="50%" height="50%">
        </div>
        <?php } ?>


        <?php if ($imagencuarta == "") 
          {
            echo "";
          }
          else 
          { ?> 
        <div class="row align-items-center">
          <img src="<?php echo "../Archivos/foto_vehiculos/" .$imagencuarta; ?>" alt="<?php echo $imagencuar; ?>" width="50%" height="50%">
        </div>
        <?php } ?>


      </div>
    </div>
  </div>
</div>
<br>




<!-- PIE DE PAGINA -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- then Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>