<?php include("/db.php"); ?>

<?php
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../../indexcorpo.php");
exit();
}
$tipo = $_SESSION['tipo_us'];
if($tipo == "Administrador") { $usu = 1; }
if($tipo == "Despacho") { $usu = 1; }
if($usu != 1)
{
header("location: ../../indexcorpo.php");
}
?>
<?php 
///// Datos de usuarios//////////////
if(!$_SESSION['nombre']){
$sinusuario = "si";
}else{
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
$tipo = $_SESSION['tipo_us'];

}
///// Datos de usuarios//////////////
?>

<?php $mes = "20" .date ('y-m', strtotime('-0 month'));?>

<!DOCTYPE html>
<html lang="es_ES">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Corporativos</title><!--titulo de pestaña-->

  <!--Bootstrap 4-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <!----Timepicker---->
  <link rel="stylesheet" type="text/css" href="../../clockpicker.css">
  <!--- Font Awesome 5----->
  <link href="/fontawesome/css/all.css" rel="stylesheet">  
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> 

  <link rel="shortcut icon" type="image/png" href=”../../Image/argent.ico” >
</head>
<body>

<nav class="navbar sticky-top navbar-expand-md navbar-dark bg-dark">
  <img src="/Image/argent.png" width="30" height="37" class="d-inline-block align-top" alt="" loading="lazy">
    <a class="navbar-brand pl-3" href="../indexcorpo.php">Argentseal</a> 
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav mr-auto my-2 my-lg-0 navbar-nav-scroll" style="max-height: 100px;">      
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
          Reportes
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
          <!--  <li><a class="dropdown-item" href="../../ATC/Basico/reportescaba.php">CABA</a></li>   -->
          <center><li><a class="dropdown-item" href="../../corpo/Basico/alta.php">Altas</a></li></center>
          <li><a class="dropdown-item" href="../../corpo/Basico/tareas.php">Coordinacion</a></li>
          <!--<li><a class="dropdown-item" href="../../corpo/Basico/modificacion.php">Modificacion</a></li>-->
          <!-- <li><hr class="dropdown-divider"></li> SEPARADOR-->          
        </ul>
      </li>
      <li><a class="btn text-light" href="../../inicio_despacho.php">Masivo</a></li>
      <li><a class="btn text-light" href="../../../corpo/corpo2/indexcorpo2.html">Corpo</a></li>
      <li class="nav-item dropdown active">
       <!-- <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-toggle="dropdown" aria-expanded="false">Tecnicos</a>
        <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
          <li><a class="dropdown-item" href="../../ATC/Basico/tecnicosatc.php">Datos</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="../../ATC/Basico/asistencia.php">Asistencias</a></li>
          <!-- <li><hr class="dropdown-divider"></li> SEPARADOR
        </ul>
      </li>
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
          Carga
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
          <li><a class="dropdown-item" href="../../ATC/Basico/mapas.php">Mapas</a></li>
          <li><a class="dropdown-item" href="../../ATC/Basico/lineal.php">Reportes lineal</a></li>
          <li><a class="dropdown-item" href="../../ATC/Basico/gpon.php">Reportes gpon</a></li>
          <!-- <li><hr class="dropdown-divider"></li> SEPARADOR          
        </ul>
      </li>
    </ul>-->

      <span class="btn-group text-white">
      <div class="btn-group text-white">
      <a class="btn dropdown-toggle d-md-none d-lg-none" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <?php if ($tipo == 'Administrador'){ echo '<i class="fas fa-user-ninja"></i>';} ?>
         <?php if ($tipo == 'Despacho'){ echo '<i class="fas fa-user-tie"></i>';} ?>
      </a>
      <div class="dropdown-menu dropdown-menu-left">
          <div class="form-row justify-content-center">
            <a class="modal-title font-weight-bold text-center"><?php echo $nombre ." " .$apellido; ?></a>
          </div>

          <a class="dropdown-item font-weight-light text-center" type="button"><small><?php echo $tipo; ?></small></a>
          <div class="form-row justify-content-center">
          <a class="text-center h2">
            <?php if ($tipo == 'Administrador'){ echo '<i class="fas fa-user-ninja"></i>';} ?>
         <?php if ($tipo == 'Despacho'){ echo '<i class="fas fa-user-tie"></i>';} ?>
          </a></div>

           <?php
          $query = "SELECT * FROM usuarios WHERE nombre = '$nombre' AND apellido = '$apellido' AND tipo_us = '$tipo' ";
          $result_tasks = mysqli_query($conn, $query);    

          while($row = mysqli_fetch_assoc($result_tasks)) { ?>

          <a class="dropdown-item text-center" href="../Editar/edit_user.php?id=<?php echo $row['id']?>" type="button">Editar usuario</a>
          <div class="dropdown-divider"></div>
          

          <?php if ($tipo == 'Administrador'){ echo '<div class="form-row justify-content-center">
          <a href="../inicio.php" class="h1 text-danger"><i class="fas fa-sync-alt"></i></a>
         </div>' ;} ?>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-center" href="../includes/salir.php?id=<?php echo $row['id']?>" type="button">Cerrar sesion</a>
          <?php } ?>
        </div>
      </div>
    </span>

  </div>
  <span class="btn-group text-white">
      <div class="btn-group text-white">
      <a class="btn dropdown-toggle d-sm-none d-none d-md-block d-lg-block" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <?php if ($tipo == 'Administrador'){ echo '<i class="fas fa-user-ninja"></i>';} ?>
         <?php if ($tipo == 'Despacho'){ echo '<i class="fas fa-user-tie"></i>';} ?>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
          <div class="form-row justify-content-center">
            <a class="modal-title font-weight-bold text-center"><?php echo $nombre ." " .$apellido; ?></a>
          </div>

          <a class="dropdown-item font-weight-light text-center" type="button"><small><?php echo $tipo; ?></small></a>
          <div class="form-row justify-content-center">
          <a class="text-center h2">
            <?php if ($tipo == 'Administrador'){ echo '<i class="fas fa-user-ninja"></i>';} ?>
         <?php if ($tipo == 'Despacho'){ echo '<i class="fas fa-user-tie"></i>';} ?>
          </a></div>

           <?php
          $query = "SELECT * FROM usuarios WHERE nombre = '$nombre' AND apellido = '$apellido' AND tipo_us = '$tipo' ";
          $result_tasks = mysqli_query($conn, $query);    

          while($row = mysqli_fetch_assoc($result_tasks)) { ?>

          <a class="dropdown-item text-center" href="../Editar/edit_user.php?id=<?php echo $row['id']?>" type="button">Editar usuario</a>
          <div class="dropdown-divider"></div>
          

          <?php if ($tipo == 'Administrador'){ echo '
          <div class="form-row justify-content-center">
          <a href="../../inicio.php" class="h1 text-danger"><i class="fas fa-users"></i></a>
          </div>
          <div class="form-row justify-content-center">
          <a href="../../ATC/indexatc.php" class="h1 text-info"><i class="fas fa-street-view"></i></a>
          </div> ' ;} ?>
          <?php if ($tipo == 'Despacho'){ echo '
          <div class="form-row justify-content-center">
          <a href="../../inicio.php" class="h1 text-danger"><i class="fas fa-users"></i></a>
          </div>
          <div class="form-row justify-content-center">
          <a href="../../ATC/indexatc.php" class="h1 text-info"><i class="fas fa-street-view"></i></a>
          </div>' ;} ?>          

          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-center" href="../includes/salir.php?id=<?php echo $row['id']?>" type="button">Cerrar sesion</a>
          <?php } ?>
        </div>
      </div>
    </span>
</nav>
