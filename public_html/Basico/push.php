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
  if($tipo_us == "Administrador") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
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
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Notificaciones push</p>
            <table class="table table-hover table-responsive table-striped table-bordered table-sm" >
              <thead class="thead-dark text-center">
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Notificaciones</th>
                  </tr>
              </thead>
              <tbody align="center">
                <?php
                  $query_msj = mysqli_query($conn, "SELECT * FROM usuarios");
                  while($row = mysqli_fetch_assoc($query_msj)) {
                ?>
                  <tr>
                    <td>
                      <?php if($row['firebase'] == '') {echo '';} else { ?>
                        <i class="fa-solid fa-comment-dots btn btn-outline-success sendNoti border border-none p-2" name="guardar" data-toggle="modal" data-target="#modal_msj"  data-token="<?php echo $row['token']; ?>"></i>
                      <?php } ?>
                    </td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['apellido']; ?></td>
                    <td><?php if($row['firebase'] == ''){echo '<i class="fa-solid fa-bell-slash text-danger p-1"></i>';} else {echo '<i class="fa-solid fa-bell text-success p-1"></i>';} ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
            </table>

          <!-- Modal -->
          <div class="modal fade" id="modal_msj">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
              <form method="POST" action="../Guardar/save_push.php">
                <div class="modal-header">
                  <h5 class="modal-title">Enviar notificacion push</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>                  
                  <div class="modal-body">
                    <input type="hidden" id="token" name="token">
                    <input type="text" placeholder="mensaje" name="mensaje" class="form-control">
                  </div>
                  <div class="modal-footer">
                    <input type="submit" name="guardar" class="btn btn-primary" value="Enviar">
                  </div>
                </form>
              </div>
            </div>
          </div>    
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
<script>
  window.onload=()=>{
    const botones= document.querySelectorAll('.sendNoti');
    botones.forEach( el=>el.addEventListener('click',evt=>{
      var token=evt.target.getAttribute('data-token');
      document.getElementById('token').value =token;
    }))
  };
</script>
</body>
</html>