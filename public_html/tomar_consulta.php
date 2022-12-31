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
  $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
  if($tipo_us == "Administrador") { $usu = 1; }
  if($tipo_us == "Despacho") { $usu = 1; }
  if($tipo_us == "Supervisor") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
  }
  $token_sesion = $_GET['token'];

  mysqli_query($conn, "UPDATE mensajes_tec set tomado = '$quien_notas' WHERE token_sesion = '$token_sesion'");
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
            <div class="col-auto">
              <?php
                $consul = mysqli_query($conn, "SELECT * FROM mensajes_tec WHERE token_sesion = '$token_sesion'");
                if (mysqli_num_rows($consul) >= 1)
                {
                  $row = mysqli_fetch_array($consul);
                  $_SESSION['token_sesion'] = $row['token_sesion'];
              ?>
                <p class="h5 text-center">Consulta de <?php echo $row['tecnico']; ?></p>
                <div class="row">
                  <div class="col-auto mx-auto">
                    <form action="../save/delete_mensaje_tec.php" method="POST">
                      <input type="hidden" name="token_sesion" value="<?php echo $row['token_sesion']; ?>">
                      <button class="btn btn-danger btn-sm" name="cerrar" type="submit">Cerrar chat</button>
                    </form>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
          <br>
          <div class="row justify-content-center p-1">
            <div class="col-12 m-2">
                <form onsubmit="enviar_consulta(); return false" id="formconsul">
                  <input type="hidden" name="quien" value="<?php echo $quien_notas; ?>">
                  <label for="input_msj">Mensaje:</label>
                  <div class="input-group mb-3">
                    <input type="text" class="form-control input_msj" name="consulta" placeholder="Realizar consulta..." aria-describedby="button-enviar" autofocus>
                    <div class="input-group-append">
                      <button class="btn btn-outline-success" type="submit" id="button-enviar"><i class="fa-regular fa-comment"></i></button>
                    </div>
                  </div>
                </form>
              <div id="consulta_msj"></div>
              <script>
                setInterval(function(){
                  $(document).ready(function(){
                    $('#consulta_msj').load('../Ajax/tecnico/consultas.php')
                  });
                },5000);
              </script>
              <script>
                function enviar_consulta(){
                  $.ajax({
                  type: 'POST',
                  url: '../Ajax/tecnico/consulta_guardar.php',
                  data: $('#formconsul').serialize(),
                  success: function(respuesta)
                    {
                      if(respuesta=='ok')
                      {
                        $('#consulta_msj').load('../Ajax/tecnico/consultas.php'),
                        $('.input_msj').val('');
                      }
                    }
                  });
                }
              </script>
            </div>
          </div>
        </div>
      </div>
    </div>
		<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
</html>