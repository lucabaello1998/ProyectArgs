<?php
include("../db.php");
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
if($tipo == "Deposito") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");   /////Visor - Deposito/////
}else{
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
$supervisor = $nombre ." " .$apellido;
}



if  (isset($_GET['id']))
{
  $id = $_GET['id'];
  $query = "SELECT * FROM no_conformidades WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1)
  {
    $row = mysqli_fetch_array($result);
    $tecnico = $row['tecnico'];
    $fecha = $row['fecha'];
    $supervisor = $row['supervisor'];
    $id_nc = $row['id_nc'];
    $imagenprimera = $row['imagenpri'];
    $imagensegunda = $row['imagenseg'];
    $imagentercera = $row['imagenter'];
    $problema = $row['problema'];
  }
   /* FECHA INICIO */
  $fecha_desc = date("l j m Y", strtotime($ult_fecha));

  $fechi  = $fecha_desc;
  $so_fechi = explode(" ", $fechi);
  $dia_nombre = $so_fechi[0];
  $dia_numero = $so_fechi[1];
  $mes_nombre = $so_fechi[2];
  $anio_numero = $so_fechi[3];

  switch ($fecha)
  {
    case 'Monday': $dia_mm = "Lunes";
    break;
    case 'Tuesday': $dia_mm = "Martes";
    break;
    case 'Wednesday': $dia_mm = "Miercoles";
    break;
    case 'Thursday': $dia_mm = "Jueves";
    break;
    case 'Friday': $dia_mm = "Viernes";
    break;
    case 'Saturday': $dia_mm = "Sabado";
    break;
    case 'Sunday': $dia_mm = "Domingo";
    break;
  }
  switch ($mes_nombre)
  {
    case '12': $mes_mm = "Diciembre";
    break;
    case '11': $mes_mm = "Noviembre";
    break;
    case '10': $mes_mm = "Octubre";
    break;
    case '09': $mes_mm = "Septiembre";
    break;
    case '08': $mes_mm = "Agosto";
    break;
    case '07': $mes_mm = "Julio";
    break;
    case '06': $mes_mm = "Junio";
    break;
    case '05': $mes_mm = "Mayo";
    break;
    case '04': $mes_mm = "Abril";
    break;
    case '03': $mes_mm = "Marzo";
    break;
    case '02': $mes_mm = "Febrero";
    break;
    case '01': $mes_mm = "Enero";
    break;
  }
/* FECHA INICIO */
}
include('../includes/header.php');
?>


<div class="container p-2">
  <div class="row">
    <div class="col-md">
      <div class="card card-body">
        <p class="h3 mb-4 text-center">No conformidad <?php echo $id_nc; ?></p>
        <p class="h5 mb-4 text-center">el <?php echo $dia_mm .' ' .$dia_numero .' de ' .$mes_mm ?></p>
        <br>

        <div class="row justify-content-start">
          <div class="col-12">      
              <p class="h5 text-start"><b>Tecnico:</b> <?php echo $tecnico; ?></p>      
          </div>
        </div>

        <div class="row justify-content-start">
          <div class="col-12">      
              <p class="h5"><b>Supervisor:</b> <?php echo $supervisor; ?></p>
          </div>
        </div>

        <div class="row justify-content-start">
          <div class="col-12">      
              <p class="h5 text-start"><b>Observaciones:</b> <?php echo $problema; ?></p>      
          </div>
        </div>

        <br>

        <?php if ($imagenprimera == "") 
          {
            echo "";
          }
          else 
          { ?> 
        <div class="row align-items-center">
          <img src="<?php echo "../Archivos/no_conformidad/" .$imagenprimera; ?>" alt="<?php echo $imagenpri; ?>" width="50%" height="50%">
        </div>
        <?php } ?>

        <br>


        <?php if ($imagensegunda == "") 
          {
            echo "";
          }
          else 
          { ?> 
        <div class="row align-items-center">
          <img src="<?php echo "../Archivos/no_conformidad/" .$imagensegunda; ?>" alt="<?php echo $imagenseg; ?>" width="50%" height="50%">
        </div>
        <?php } ?>
        <br>

        <?php if ($imagentercera == "") 
          {
            echo "";
          }
          else 
          { ?> 
        <div class="row align-items-center">
          <img src="<?php echo "../Archivos/no_conformidad/" .$imagentercera; ?>" alt="<?php echo $imagenter; ?>" width="50%" height="50%">
        </div>
        <?php } ?>
        <br>

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