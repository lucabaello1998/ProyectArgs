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
  $query = "SELECT * FROM auditoria_instalaciones WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1)
  {
    $row = mysqli_fetch_array($result);
    $identificador = $row['identificador'];
    $super = $row['supervisor'];
    $tecnico = $row['tecnico'];
    $fecha = $row['fecha'];
    $ot = $row['ot'];
    $instalacion_externa = $row['instalacion_externa'];
    $foto_nomenclador = $row['foto_nomenclador'];
    $cadena = $row['cadena'];
    $altura_acometida = $row['altura_acometida'];
    $punto_retencion = $row['punto_retencion'];
    $curva_goteo = $row['curva_goteo'];
    $ingreso_domicilio = $row['ingreso_domicilio'];
    $engrampado_interior = $row['engrampado_interior'];
    $ont = $row['ont'];
    $residuos = $row['residuos'];
    $trato_cliente = $row['trato_cliente'];
    $uso_herramientas = $row['uso_herramientas'];
    $epp = $row['epp'];
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
          <div class="col-6">      
              <p class="h5 text-start"><b>Tecnico:</b> <?php echo $tecnico; ?></p>      
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>OT:</b> <?php echo $ot; ?></p>
          </div>
        </div>

        <div class="row justify-content-start">
          <div class="col-6">      
              <p class="h5 text-start"><b>Instalacion externa:</b> <?php if ($instalacion_externa == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($instalacion_externa == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Foto del nomenclador:</b> <?php if ($foto_nomenclador == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($foto_nomenclador == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
        </div>

        <div class="row justify-content-start">
          <div class="col-6">      
              <p class="h5 text-start"><b>Cadena:</b> <?php if ($cadena == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($cadena == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Altura de la acometida:</b> <?php if ($altura_acometida == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($altura_acometida == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
        </div>

        <div class="row justify-content-start">
          <div class="col-6">      
              <p class="h5 text-start"><b>Punto de retencion:</b> <?php if ($punto_retencion == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($punto_retencion == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Curva de goteo:</b> <?php if ($curva_goteo == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($curva_goteo == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
        </div>

        <div class="row justify-content-start">
          <div class="col-6">      
              <p class="h5 text-start"><b>Ingreso al domicilio:</b> <?php if ($ingreso_domicilio == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($ingreso_domicilio == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Engrampado interior:</b> <?php if ($engrampado_interior == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($engrampado_interior == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
        </div>

        <div class="row justify-content-start">
          <div class="col-6">      
              <p class="h5 text-start"><b>ONT:</b> <?php if ($ont == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($ont == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Residuos en el domicilio:</b> <?php if ($residuos == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($residuos == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
        </div>

        <div class="row justify-content-start">
          <div class="col-6">      
              <p class="h5 text-start"><b>Trato con el cliente:</b> <?php if ($trato_cliente == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($trato_cliente == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
          <div class="col-6">      
              <p class="h5 text-start"><b>Uso de las herramientas:</b> <?php if ($uso_herramientas == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($uso_herramientas == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>
          </div>
        </div>

        <div class="row justify-content-start">
          <div class="col-6">      
              <p class="h5 text-start"><b>Uso de EPP:</b> <?php if ($epp == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($epp == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></p>      
          </div>
          <div class="col-6">      
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
          <img src="<?php echo "../Archivos/instalaciones2/" .$imagenprimera; ?>" alt="<?php echo $imagenpri; ?>" width="50%" height="50%">
        </div>
        <?php } ?>


        <?php if ($imagensegunda == "") 
          {
            echo "";
          }
          else 
          { ?> 
        <div class="row align-items-center">
          <img src="<?php echo "../Archivos/instalaciones2/" .$imagensegunda; ?>" alt="<?php echo $imagenseg; ?>" width="50%" height="50%">
        </div>
        <?php } ?>


        <?php if ($imagentercera == "") 
          {
            echo "";
          }
          else 
          { ?> 
        <div class="row align-items-center">
          <img src="<?php echo "../Archivos/instalaciones2/" .$imagentercera; ?>" alt="<?php echo $imagenter; ?>" width="50%" height="50%">
        </div>
        <?php } ?>


        <?php if ($imagencuarta == "") 
          {
            echo "";
          }
          else 
          { ?> 
        <div class="row align-items-center">
          <img src="<?php echo "../Archivos/instalaciones2/" .$imagencuarta; ?>" alt="<?php echo $imagencuar; ?>" width="50%" height="50%">
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