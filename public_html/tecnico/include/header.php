<?php
include("../../db.php");
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: /index.php");
exit();
}
$nombre_us = $_SESSION['nombre'];
$apellido_us = $_SESSION['apellido'];
$tipo_us = $_SESSION['tipo_us'];
$zona_us = $_SESSION['zona'];
$tema_us = $_SESSION['tema'];
$fuente_us = $_SESSION['fuente'];
$icono_us = $_SESSION['icono'];
if($tipo_us == "Administrador") { $usu = 1; }
if($tipo_us == "Despacho") { $usu = 1; }
if($tipo_us == "Deposito") { $usu = 1; }
if($tipo_us == "Supervisor") { $usu = 1; }
if($tipo_us == "Tecnico") { $usu = 1; }
if($usu != 1)
{
header("location: /index.php");
}
?>
<!DOCTYPE html>
<html lang="es_ES">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Tecnicos</title>
  <link rel="stylesheet" type="text/css" href="/jquery-ui-1.12.1.custom/jquery-ui.css">
  <script src="/jquery-3.3.1.min.js"></script>
  <script src="/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link href="/fontawesome/css/all.css" rel="stylesheet">  
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="shortcut icon" type="image/png" href="/Image/argent.ico">
</head>
<body class="bg-dark">
<nav class="navbar sticky-top navbar-expand-md navbar-dark bg-dark">
  <img src="/Image/argent.png" width="30" height="37" class="d-inline-block align-top" alt="" loading="lazy">
    <a class="navbar-brand pl-3" href="/tecnico/index.php">Argentseal</a> 
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <span class="btn-group text-white">
      <div class="btn-group text-white">
      <a class="btn dropdown-toggle d-md-none d-lg-none" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="<?php echo $icono_us; ?>"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-left">
          <div class="form-row justify-content-center">
            <a class="modal-title font-weight-bold text-center"><?php echo $nombre_us ." " .$apellido_us; ?></a>
          </div>

          <a class="dropdown-item font-weight-light text-center" type="button"><small><?php echo $tipo_us; ?></small></a>
          <div class="form-row justify-content-center">
            <a class="text-center h2"><i class="<?php echo $icono_us; ?>"></i></a>
          </div>

          <?php
            $user_a = mysqli_query($conn, "SELECT * FROM usuarios WHERE nombre = '$nombre_us' AND apellido = '$apellido_us' AND tipo_us = '$tipo_us' ");    
            while($row = mysqli_fetch_assoc($user_a)) { ?>

          <a class="dropdown-item text-center" href="/Editar/edit_user.php?id=<?php echo $row['id']?>" type="button">Editar usuario</a>
          <div class="dropdown-divider"></div>

          <?php if ($tipo_us== 'Administrador' || $nombre_us == 'Jose' && $apellido_us == 'Lopez') { ?>
          <div class="form-row justify-content-center">
            <a href="/inicio.php" class="h1 text-danger"><i class="fas fa-users"></i></a>
          </div>
          <div class="dropdown-divider"></div>
          <?php } ?>          
          <a class="dropdown-item text-center" href="/includes/salir.php?id=<?php echo $row['id']?>" type="button">Cerrar sesion</a>
          <?php } ?>
        </div>
      </div>
    </span>
  </div>
  <span class="d-sm-none d-none d-md-block d-lg-block float-right">
    <div class="btn-group text-white">
    <a class="btn dropdown-toggle d-sm-none d-none d-md-block d-lg-block" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="<?php echo $icono_us; ?>"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        <div class="form-row justify-content-center">
          <a class="modal-title font-weight-bold text-center"><?php echo $nombre_us ." " .$apellido_us; ?></a>
        </div>

        <a class="dropdown-item font-weight-light text-center" type="button"><small><?php echo $tipo_us; ?></small></a>
        <div class="form-row justify-content-center">
          <a class="text-center h2"><i class="<?php echo $icono_us; ?>"></i></a>
        </div>

        <?php
        $user = mysqli_query($conn, "SELECT * FROM usuarios WHERE nombre = '$nombre_us' AND apellido = '$apellido_us' AND tipo_us = '$tipo_us' ");
        while($row = mysqli_fetch_assoc($user)) { ?>

        <a class="dropdown-item text-center" href="/Editar/edit_user.php?id=<?php echo $row['id']?>" type="button">Editar usuario</a>
        <div class="dropdown-divider"></div>

        <?php if ($tipo_us== 'Administrador' || $nombre_us == 'Jose' && $apellido_us == 'Lopez') { ?>
          <div class="form-row justify-content-center">
            <a href="/inicio.php" class="h1 text-danger"><i class="fas fa-users"></i></a>
          </div>
          <div class="dropdown-divider"></div>
        <?php } ?>        
        <a class="dropdown-item text-center" href="/salir.php?id=<?php echo $row['id']?>" type="button">Cerrar sesion</a>
        <?php } ?>
      </div>
    </div>
  </span>
</nav>
