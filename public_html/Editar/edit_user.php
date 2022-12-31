<?php
include("../db.php");
session_start();
if(!$_SESSION['tipo_us'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$tipo_us = $_SESSION['tipo_us'];
if($tipo_us == "Administrador") { $usu = 1; }
if($tipo_us == "Despacho") { $usu = 1; }
if($tipo_us == "Supervisor") { $usu = 1; }
if($tipo_us == "Deposito") { $usu = 1; }
if($tipo_us == "Visor") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}
$usuario = '';
$pass= '';
$mail= '';
$fuente= '';
$icono= '';
if(isset($_GET['id']))
{
  $id = $_GET['id'];
  $result = mysqli_query($conn, "SELECT * FROM usuarios WHERE id = '$id'");
  if (mysqli_num_rows($result) == 1)
  {
    $row = mysqli_fetch_array($result);
    $usuario = $row['usuario'];
    $pass = $row['pass'];
    $mail = $row['mail'];
    $fuente = $row['fuente'];
    $icono = $row['icono'];
  }
}

if(isset($_POST['update']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token,
    quien,
    movimiento,
    pag,
    inicio,
    tipo,
    zona) VALUES ('$token_movi',
    '$quien_notas',
    'Editado',
    'Ajuste de usuarios',
    '$hoy_movi',
    '$tipo_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */

  $id = $_GET['id'];
  $usuario= $_POST['usuario'];
  $pass = $_POST['pass'];
  $mail = $_POST['mail'];
  $fuente = $_POST['fuente'];
  $icono = $_POST['icono'];

  $u = mysqli_query($conn, "UPDATE usuarios set mail = '$mail', usuario = '$usuario', pass = '$pass', fuente = '$fuente', icono = '$icono' WHERE id = '$id'");
  if(!$u)
  {
    $titulo_toast = "Error";
    $msj_toast = "Hubo un error interno al actualizar el proceso";
    $color_toast = "danger";
  }
  else
  {
    $_SESSION['tema'] = $tema;
    $_SESSION['fuente'] = $fuente;
    $_SESSION['icono'] = $icono;
    $titulo_toast = "Actualizado";
    $msj_toast = "El usuario fue actualizado correctamente.";
    $color_toast = "warning";
  }
  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
  header("location: ../inicio.php");
}
?>
<?php include('../includes/header.php'); ?>

<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <form action="edit_user.php?id=<?php echo $_GET['id']; ?>" method="POST">
            <div class="card card-body">
              <p class="h4 mb-4 text-center">Actualizar usuario</p>
              <div class="form-row">
                <div class="form-group col-md-4 col-6">
                  <label>Usuario</label >
                  <input type="text" name="usuario" pattern="[A-Za-z0-9_-.]{3-15}" class="form-control" value="<?php echo $usuario; ?>" placeholder="Actualice el usuario">
                </div>
                <div class="form-group col-md-4 col-6">
                  <label>Contraseña</label >
                  <input type="text" name="pass" class="form-control" pattern="[A-Za-z0-9_-.]{3-15}" value="<?php echo $pass; ?>" placeholder="Actualice la contraseña">
                </div>
                <div class="form-group col-md-4 col-12">
                  <label>Mail</label >
                  <input type="email" name="mail" class="form-control" value="<?php echo $mail; ?>" placeholder="Actualice el mail">
                </div> 
              </div>
              <div class="form-row">
                <div class="form-group col-12">
                  <label>Fuente</label >
                  <select class="form-control" name="fuente">
                    <option selected value="<?php echo $fuente ?>"><?php echo $fuente ?></option>
                    <option value="">Por defecto</option>
                    <option value="Roboto">Roboto</option>
                    <option value="Josefin">Josefin</option>
                    <option value="Fjalla">Fjalla</option>
                    <option value="Vidaloka">Vidaloka</option>
                  </select>
                </div>
              </div>
              <div class="form-row justify-content-around p-1">
                <div class="col-lg-3 col-md-4 col-6">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="icono" id="icono1" value="fa-solid fa-user" <?php if($icono == 'fa-solid fa-user'){echo 'checked';}else{echo '';} ?>>
                    <label class="form-check-label h3" for="icono1"><i class="fa-solid fa-user"></i></label>
                  </div>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="icono" id="icono2" value="fa-solid fa-user-tie" <?php if($icono == 'fa-solid fa-user-tie'){echo 'checked';}else{echo '';} ?>>
                    <label class="form-check-label h3" for="icono2"><i class="fa-solid fa-user-tie"></i></label>
                  </div>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="icono" id="icono3" value="fa-solid fa-user-astronaut" <?php if($icono == 'fa-solid fa-user-astronaut'){echo 'checked';}else{echo '';} ?>>
                    <label class="form-check-label h3" for="icono3"><i class="fa-solid fa-user-astronaut"></i></label>
                  </div>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="icono" id="icono4" value="fa-solid fa-dragon" <?php if($icono == 'fa-solid fa-dragon'){echo 'checked';}else{echo '';} ?>>
                    <label class="form-check-label h3" for="icono4"><i class="fa-solid fa-dragon"></i></label>
                  </div>
                </div>
              </div>
              <br>
              <div class="form-row justify-content-around p-1">
                <div class="col-lg-3 col-md-4 col-6">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="icono" id="icono5" value="fa-solid fa-horse-head" <?php if($icono == 'fa-solid fa-horse-head'){echo 'checked';}else{echo '';} ?>>
                    <label class="form-check-label h3" for="icono5"><i class="fa-solid fa-horse-head"></i></label>
                  </div>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="icono" id="icono6" value="fa-solid fa-frog" <?php if($icono == 'fa-solid fa-frog'){echo 'checked';}else{echo '';} ?>>
                    <label class="form-check-label h3" for="icono6"><i class="fa-solid fa-frog"></i></label>
                  </div>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="icono" id="icono7" value="fa-regular fa-lightbulb" <?php if($icono == 'fa-regular fa-lightbulb'){echo 'checked';}else{echo '';} ?>>
                    <label class="form-check-label h3" for="icono7"><i class="fa-regular fa-lightbulb"></i></label>
                  </div>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="icono" id="icono8" value="fa-solid fa-fire-flame-curved" <?php if($icono == 'fa-solid fa-fire-flame-curved'){echo 'checked';}else{echo '';} ?>>
                    <label class="form-check-label h3" for="icono8"><i class="fa-solid fa-fire-flame-curved"></i></label>
                  </div>
                </div>
              </div>
              <br>
              <input type="submit" name="update" class="btn btn-success btn-block" value="Actualizar usuario">
            </div>
          </form>
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
</body>
</html>
