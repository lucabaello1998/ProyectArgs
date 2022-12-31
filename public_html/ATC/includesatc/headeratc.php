<?php include("/db.php");
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../../index.php");
exit();
}
$tipo = $_SESSION['tipo_us'];
if($tipo == "Administrador") { $usu = 1; }
if($tipo == "Despacho") { $usu = 1; }
if($tipo == "ATC") { $usu = 1; }
if($usu != 1)
{
header("location: ../../index.php");
}
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
  <title>Argentseal</title><!--titulo de pestaña-->

  <!--Bootstrap 4-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <!--Bootstrap 4-->

  <!--- Font Awesome 5----->
  <link href="/fontawesome/css/all.css" rel="stylesheet"> 
  <!--- Font Awesome 5----->

  
<!-- Mapa -->
  <!-----CDN Leaflet----->
  <script src="/ATC/plugin/Leaflet-1.7.1/dist/leaflet.js"></script>
  <link rel="stylesheet" href="/ATC/plugin/Leaflet-1.7.1/dist/leaflet.css"/>

  <!-----CDN Leaflet----->
  <script src="https://maps.googleapis.com/maps/api/js" type="text/javascript"></script>

  <!-----LAYER TREE----->
  <link rel="stylesheet" href="/ATC/plugin/TreeMaster/L.Control.Layers.Tree.css" crossorigin=""/>
  <script src="/ATC/plugin/TreeMaster/L.Control.Layers.Tree.js"></script>
  <!-----LAYER TREE----->

  <!-----FULLSCREEN----->
  <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
  <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />
  <!-----FULLSCREEN----->

  <!-----markercluster----->
  <link rel="stylesheet" href="../../ATC/plugin/markercluster/dist/MarkerCluster.css" />
  <link rel="stylesheet" href="../../ATC/plugin/markercluster/dist/MarkerCluster.Default.css" />
  <script src="https://unpkg.com/leaflet.markercluster@1.1.0/dist/leaflet.markercluster.js"></script>
  <!-----markercluster-----> 

  <!-----CDN Omnivore----->
  <script src='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.3.1/leaflet-omnivore.min.js'></script>
  <!-----CDN Omnivore----->

  <!-----CDN lector KML previo----->
  <script src="https://unpkg.com/togeojson@0.16.0"></script>
  <script src="https://unpkg.com/leaflet-filelayer@1.2.0"></script>
  <!-----CDN lector KML previo----->

  <!----PRINT---->
  <script src="../../ATC/plugin/print/dist/leaflet.browser.print.min.js"></script>
  <!----PRINT---->
  
  <!----PolylineMeasure---->
  <link rel="stylesheet" href="../../ATC/plugin/polylinemeasure/Leaflet.PolylineMeasure.css" />
  <script src="../../ATC/plugin/polylinemeasure/Leaflet.PolylineMeasure.js"></script>
  <!----PolylineMeasure---->

  <!----Geocoder---->
  <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder@2.3.0/dist/Control.Geocoder.css" />
  <script src="https://unpkg.com/leaflet-control-geocoder@2.3.0/dist/Control.Geocoder.js"></script>
  <!----Geocoder---->

  <!-- Mapa -->

  

  <!----Timepicker---->
  <link rel="stylesheet" type="text/css" href="../../clockpicker.css">
  <!----Timepicker---->

  <link rel="shortcut icon" href="https://www.argentseal.com.ar/vistas/images/favicon/favicon.ico" type="image/x-icon">
</head>
<body>

<nav class="navbar sticky-top navbar-expand-md navbar-dark bg-dark">
  <img src="/Image/argent.png" width="30" height="37" class="d-inline-block align-top" alt="" loading="lazy">
    <a class="navbar-brand pl-3" href="../../ATC/indexatc.php">Argentseal</a> 
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav mr-auto my-2 my-lg-0 navbar-nav-scroll" style="max-height: 100px;">      
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-toggle="dropdown" aria-expanded="false">Reportes</a>
        <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
        	<!--  <li><a class="dropdown-item" href="../../ATC/Basico/reportescaba.php">CABA</a></li>   -->
          <!-- <li><a class="dropdown-item" href="../../ATC/Basico/reportes.php">Prueba 01</a></li> -->
          <li><a class="dropdown-item" href="../../ATC/Basico/reporteslineal.php">Lineal</a></li>
          <li><a class="dropdown-item" href="../../ATC/Basico/reportesgpon.php">Gpon</a></li>
          <!-- <li><hr class="dropdown-divider"></li> SEPARADOR-->          
        </ul>
      </li>
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-toggle="dropdown" aria-expanded="false">Tecnicos</a>
        <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
          <li><a class="dropdown-item" href="../../ATC/Basico/tecnicosatc.php">Datos</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="../../ATC/Basico/asistencia.php">Asistencias</a></li>
          <li><a class="dropdown-item" href="../../ATC/Basico/km.php">Kilometros</a></li>
          <!-- <li><hr class="dropdown-divider"></li> SEPARADOR--> 
        </ul>
      </li>
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-toggle="dropdown" aria-expanded="false">Carga</a>
        <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
          <li><a class="dropdown-item" href="../../ATC/Basico/mapas.php">Mapas</a></li>
          <li><a class="dropdown-item" href="../../ATC/Basico/lineal.php">Reportes lineal</a></li>
          <li><a class="dropdown-item" href="../../ATC/Basico/gpon.php">Reportes gpon</a></li>
          <!-- <li><hr class="dropdown-divider"></li> SEPARADOR-->          
        </ul>
      </li>
    </ul>

      <span class="btn-group text-white">
      <div class="btn-group text-white">
      <a class="btn dropdown-toggle d-md-none d-lg-none" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <?php if ($tipo == 'Administrador'){ echo '<i class="text-white fas fa-user-ninja"></i>';} ?>
         <?php if ($tipo == 'Despacho'){ echo '<i class="fas fa-user-tie"></i>';} ?>
         <?php if ($tipo == 'ATC'){ echo '<i class="fas fa-user"></i>';} ?>
      </a>
      <div class="dropdown-menu dropdown-menu-left">
          <div class="form-row justify-content-center">
            <a class="modal-title font-weight-bold text-center"><?php echo $nombre ." " .$apellido; ?></a>
          </div>

          <a class="dropdown-item font-weight-light text-center" type="button"><small><?php echo $tipo; ?></small></a>
          <div class="form-row justify-content-center">
          <a class="text-center h2">
            <?php if ($tipo == 'Administrador'){ echo '<i class="text-white fas fa-user-ninja"></i>';} ?>
         <?php if ($tipo == 'Despacho'){ echo '<i class="fas fa-user-tie"></i>';} ?>
          <?php if ($tipo == 'ATC'){ echo '<i class="fas fa-user"></i>';} ?>
          </a></div>

           <?php
          $query = "SELECT * FROM usuarios WHERE nombre = '$nombre' AND apellido = '$apellido' AND tipo_us = '$tipo' ";
          $result_tasks = mysqli_query($conn, $query);    

          while($row = mysqli_fetch_assoc($result_tasks)) { ?>

          <a class="dropdown-item text-center" href="../../Editar/edit_user.php?id=<?php echo $row['id']?>" type="button">Editar usuario</a>
          <div class="dropdown-divider"></div>
          

          <?php if ($tipo == 'Administrador'){ echo '<div class="form-row justify-content-center">
          <a href="../inicio.php" class="h1 text-danger"><i class="fas fa-sync-alt"></i></a>
         </div>' ;} ?>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-center" href="../../includes/salir.php?id=<?php echo $row['id']?>" type="button">Cerrar sesion</a>
          <?php } ?>
        </div>
      </div>
    </span>

  </div>
  <span class="btn-group text-white">
      <div class="btn-group text-white">
      <a class="btn dropdown-toggle d-sm-none d-none d-md-block d-lg-block text-white " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <?php if ($tipo == 'Administrador'){ echo '<i class="text-white fas fa-user-ninja"></i>';} ?>
         <?php if ($tipo == 'Despacho'){ echo '<i class="fas fa-user-tie"></i>';} ?>
         <?php if ($tipo == 'ATC'){ echo '<i class="fas fa-user"></i>';} ?>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
          <div class="form-row justify-content-center">
            <a class="modal-title font-weight-bold text-center"><?php echo $nombre ." " .$apellido; ?></a>
          </div>

          <a class="dropdown-item font-weight-light text-center" type="button"><small><?php echo $tipo; ?></small></a>
          <div class="form-row justify-content-center">
          <a class="text-center h2">
            <?php if ($tipo == 'Administrador'){ echo '<i class=" fas fa-user-ninja"></i>';} ?>
         <?php if ($tipo == 'Despacho'){ echo '<i class="fas fa-user-tie"></i>';} ?>
         <?php if ($tipo == 'ATC'){ echo '<i class="fas fa-user"></i>';} ?>
          </a></div>

           <?php
          $query = "SELECT * FROM usuarios WHERE nombre = '$nombre' AND apellido = '$apellido' AND tipo_us = '$tipo' ";
          $result_tasks = mysqli_query($conn, $query);    

          while($row = mysqli_fetch_assoc($result_tasks)) { ?>

          <a class="dropdown-item text-center" href="../../Editar/edit_user.php?id=<?php echo $row['id']?>" type="button">Editar usuario</a>
          <div class="dropdown-divider"></div>
          

          <?php if ($tipo == 'Administrador'){ echo '
          <div class="form-row justify-content-center">
          <a href="../../corpo/indexcorpo.php" class="h1 text-success"><i class="fas fa-user-tie"></i></a>
          </div>
          <div class="form-row justify-content-center">
          <a href="../../inicio.php" class="h1 text-danger"><i class="fas fa-users"></i></a>
          </div>' ;} ?>
          <?php if ($tipo == 'Despacho'){ echo '
          <div class="form-row justify-content-center">
          <a href="../../corpo/indexcorpo.php" class="h1 text-success"><i class="fas fa-user-tie"></i></a>
          </div>
          <div class="form-row justify-content-center">
          <a href="../../inicio.php" class="h1 text-danger"><i class="fas fa-users"></i></a>
          </div>' ;} ?>          

          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-center" href="../../includes/salir.php?id=<?php echo $row['id']?>" type="button">Cerrar sesion</a>
          <?php } ?>
        </div>
      </div>
    </span>
</nav>
