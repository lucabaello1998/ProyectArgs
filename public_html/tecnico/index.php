<?php
  include("../db.php");
  session_start();
  if(!$_SESSION['nombre'])
  {
  session_destroy();
  header("location: ../index.php");
  exit();
  }
  $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
  $tipo_us = $_SESSION['tipo_us'];
  if($tipo_us == "Administrador") { $usu = 1; }
  if($tipo_us == "Despacho") { $usu = 1; }
  if($tipo_us == "Supervisor") { $usu = 1; }
  if($tipo_us == "Deposito") { $usu = 1; }
  if($tipo_us == "Tecnico") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
  }
?>
	<?php include('include/header.php'); ?>
  <?php
    if(isset($_POST['cambio']))
    {
      /* MOVIMIENTO INDIVIDUAL */
        $token_movi = uniqid();
        $tipo_us = $_SESSION['tipo_us'];
        $zona_us = $_SESSION['zona'];
        $hoy_movi = date("Y-m-j");
        mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Ingreso', 'Tecnico', '$hoy_movi', '$tipo_us', '$zona_us')");
      /* MOVIMIENTO INDIVIDUAL */
      $cambio_tecnico = $_POST['cambio_tecnico'];
      $_SESSION['new_tec'] = $_POST['cambio_tecnico'];
    }
    else
    {
      $cambio_tecnico = $_SESSION['new_tec'];
    }
  ?>
    <!-- MESSAGES -->
      <?php
        if ($_SESSION['card'] == 1) { ?>
        <div class="position-fixed top-5 right-0 p-3" style="z-index: 5; right: 0rem; top: 3rem; width: 18rem">
          <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000">
            <div class="toast-header border-<?= $_SESSION['color_toast']?> ">
              <?php switch($_SESSION['color_toast'])
                {case 'success': $icono_toast = '<i class="fa-solid fa-circle-check text-success pr-2"></i>';break;
                case 'danger': $icono_toast = '<i class="fa-solid fa-circle-xmark text-danger pr-2"></i>';break;
                case 'warning': $icono_toast = '<i class="fa-solid fa-circle-exclamation text-warning pr-2"></i>';break;}
              ?>
              <strong class="mr-auto"><?php echo $icono_toast; ?> <?= $_SESSION['titulo_toast']?></strong>
              <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="toast-body p-2"><?= $_SESSION['mensaje_toast']?></div>
          </div>
        </div>
        <script>
          $(document).ready(function(){
            $('.toast').toast('show');
          });
        </script>
      <?php $_SESSION['card'] = 0; } ?>
    <!-- MESSAGES -->
			<div class="row p-2 m-2">
				<div class="col-md-3 col-6 align-items-center p-1">
          <a class="row rounded bg-white shadow m-1" href="./basic/consultas.php" style="text-decoration: none;">
            <div class="col-12 p-2">
              <p class="h2 text-left text-info text-center"><i class="fa-solid fa-circle-info"></i></p>
              <p class="h4 text-muted text-center">Consulta</p>
            </div>
          </a>
				</div>
        <div class="col-md-3 col-6 align-items-center p-1">
          <a class="row rounded bg-white shadow m-1" href="./basic/contactos.php" style="text-decoration: none;">
            <div class="col-12 p-2">
              <p class="h2 text-left text-info text-center"><i class="fa-solid fa-address-book"></i></p>
              <p class="h4 text-muted text-center">Contactos</p>
            </div>
          </a>
				</div>
        <div class="col-md-3 col-6 align-items-center p-1">
          <a class="row rounded bg-white shadow m-1" href="./basic/cierres.php" style="text-decoration: none;">
            <div class="col-12 p-2">
              <p class="h2 text-left text-info text-center"><i class="fa-solid fa-cloud-arrow-up"></i></p>
              <p class="h4 text-muted text-center">Cierres</p>
            </div>
          </a>
				</div>
        <div class="col-md-3 col-6 align-items-center p-1">
          <a class="row rounded bg-white shadow m-1" href="./basic/mensajes.php" style="text-decoration: none;">
            <div class="col-12 p-2">
              <p class="h2 text-left text-info text-center"><i class="fa-solid fa-paper-plane"></i></p>
              <p class="h4 text-muted text-center">Mensaje</p>
            </div>
          </a>
				</div>
        <div class="col-12 align-items-center p-1">
          <a class="row rounded bg-white shadow m-1" href="./basic/datos.php" style="text-decoration: none;">
            <div class="col-12 p-2">
              <p class="h2 text-left text-info text-center"><i class="fa-solid fa-chart-bar"></i></p>
              <p class="h4 text-muted text-center">Datos <?php echo ' de ' .$cambio_tecnico; ?></p>
            </div>
          </a>
				</div>
			</div>
		<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
</html>