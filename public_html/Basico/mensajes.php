<?php
  include("../db.php");
  session_start();
  if(!$_SESSION['nombre'])
  {
  session_destroy();
  header("location: ../index.php");
  exit();
  }
  $tipo_us = $_SESSION['tipo_us'];
  $nombre_us = $_SESSION['nombre'];
  $apellido_us = $_SESSION['apellido'];
  $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
  if($tipo_us == "Administrador") { $usu = 1; }
  if($tipo_us == "Despacho") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
  }

  if(isset($_POST['borrar_sesion']))
  {
    $borrar_sesion = $_POST['borrar_sesion'];
    $r = mysqli_query($conn, "UPDATE mensajes_tec set estado = 'Cerrado' WHERE token_sesion = '$borrar_sesion'");
    if($r)
    {
      header('Location: mensajes.php');
    }
    
  }
?>
<?php include('../includes/header.php'); ?>
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
  <?php $_SESSION['card'] = 0; } ?>
  <script>
    $(document).ready(function(){
      $('.toast').toast('show');
    });
  </script>
<!-- MESSAGES -->
<div class="container-fluid p-4">
  <div class="row p-2">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1">
            <?php 
              $msn_c = mysqli_query($conn, "SELECT * FROM mensajes_tec WHERE tomado = '$quien_notas' AND estado = 'Abierto' OR estado = 'Abierto' AND tomado = '' GROUP BY tecnico");
              if (mysqli_num_rows($msn_c) >= 1)
              {
                while($row = mysqli_fetch_array($msn_c))
                {
                  $tomado = $row['tomado'];
                  ?>
                    <div class="col-md-3 col-12 m-2 mx-auto">
                      <div class="card text-center" style="width: 18rem;">
                        <div class="card-body">
                          <h5 class="card-title"><?php echo $row['tecnico']; ?></h5>
                          <p class="card-text" data-toggle="tooltip" data-placement="top" title="<?php echo $row['consulta']; ?>"><?php echo limitar_cadena($row['consulta'], 30); ?></p>

                          <?php if($tomado !== '') { ?>
                            <a href="tomar_consulta.php?token=<?php echo $row['token_sesion']; ?>" class="btn btn-info btn-sm m-1">Ingresar</a>
                            <form action="mensajes.php" method="POST">
                              <input type="hidden" name="borrar_sesion" value="<?php echo $row['token_sesion']; ?>">
                              <button class="btn btn-danger btn-sm" name="cerrar" type="submit">Cerrar consulta</button>
                            </form>
                          <?php }else{ ?>
                            <a href="tomar_consulta.php?token=<?php echo $row['token_sesion']; ?>" class="btn btn-primary btn-sm">Tomar consulta</a>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                  <?php
                }
              }
              else
              {
                echo 'No hay mensajes';
              }
            ?>
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