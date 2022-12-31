<?php
include("../db.php");
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$nombre_us = $_SESSION['nombre'];
$apellido_us = $_SESSION['apellido'];
$tipo_us = $_SESSION['tipo_us'];
$zona_us = $_SESSION['zona'];
$quien_notas = $nombre_us .' ' .$apellido_us;
if($tipo_us == "Administrador") { $usu = 1; }
if($tipo_us == "Despacho") { $usu = 1; }
if($tipo_us == "Supervisor") { $usu = 1; }
if($tipo_us == "Deposito") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}
$tecnico = '';
$ot= '';
$id_actividad= '';
$nim= '';
$tkl= '';
$motivo= '';
$obs_tecnico= '';
$obs= '';
$direccion= '';
$localidad= '';
$zona_tarea= '';
$zona= '';
$calendario= '';

if  (isset($_GET['id']))
{
  $id = $_GET['id'];
  $result = mysqli_query($conn, "SELECT * FROM bajas WHERE id=$id");
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $tecnico = $row['tecnico'];
    $ot = $row['ot'];
    $id_actividad = $row['id_actividad'];
    $nim = $row['nim'];
    $tkl = $row['tkl'];
    $motivo = $row['motivo'];
    $obs_tecnico = $row['obs_tecnico'];
    $obs = $row['obs'];
    $direccion = $row['direccion'];
    $localidad = $row['localidad'];
    $zona_tarea = $row['zona_tarea'];
    $zona = $row['zona'];
    $calendario = $row['calendario'];
  }
}

if (isset($_POST['updateb']))
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
    'Bajas',
    '$hoy_movi',
    '$tipo_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $id = $_GET['id'];
  $tecnico= $_POST['tecnico'];
  $tkl = $_POST['tkl'];
  $obs = $_POST['obs'];
  $zona = $_POST['zona'];

  $re = mysqli_query($conn, "UPDATE bajas set tecnico = '$tecnico', tkl = '$tkl', obs = '$obs', zona = '$zona', calendario = '$calendario' WHERE id = '$id'");
  if(!$re)
    {
      $titulo_toast = "Error";
      $msj_toast = "Hubo un error interno al actualizar el proceso";
      $color_toast = "danger";
    }
    else
    {
      $titulo_toast = "Actualizado";
      $msj_toast = "La orden " .$ot ." de " .$tecnico ." fue actualizada correctamente";
      $color_toast = "warning";
    }
    $_SESSION['card'] = 1;
    $_SESSION['titulo_toast'] = $titulo_toast;
    $_SESSION['mensaje_toast'] = $msj_toast;
    $_SESSION['color_toast'] = $color_toast;
  header('Location: ../Basico/bajas.php');
}
?>
<?php include('../includes/header.php'); ?>

<div class="container-fluid p-4 ">
  <div class="row p-2">
    <div class="container-fluid rounded bg-white shadow p-0">
      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <form action="edit_bajas.php?id=<?php echo $_GET['id']; ?>" method="POST">
            <p class="h4 mb-4 text-center">Actualizar orden <?php echo $ot; ?></p>
            <div class="form-row align-items-end">
              <div class="form-group col">
                <label>Tecnico</label>
                <select type="text" name="tecnico" class="form-control">
                  <option selected="0"><?php echo $tecnico; ?></option>
                  <?php
                  $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE tipo = 'Tecnico' AND activo ='SI' ORDER BY tecnico asc");
                  ?>
                  <?php foreach ($ejecutar as $opciones): ?>   
                    <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group col">
                <label>Numero de OT</label>
                <input type="number" class="form-control" value="<?php echo $ot; ?>" readonly>
              </div>
              <div class="form-group col">
                <label>ID actividad</label>
                <input type="text" class="form-control" value="<?php echo $id_actividad; ?>" readonly>
              </div>
              <div class="form-group col">
                <label>NIM</label>
                <input type="text" class="form-control" value="<?php echo $nim; ?>" readonly>
              </div>             
              <div class="form-group col">
                <label>Fecha</label>
                <input type="date" value="<?php echo $calendario; ?>" class="form-control" readonly>
              </div>
            </div>
            <div class="form-row align-items-end">
              <div class="form-group col">
                <label>Direccion</label>
                <input type="text" class="form-control" value="<?php echo $direccion; ?>" readonly>
              </div>
              <div class="form-group col">
                <label>Localidad</label>
                <input type="text" class="form-control" value="<?php echo $localidad; ?>" readonly>
              </div>
              <div class="form-group col">
                <label>Zona</label>
                <input type="text" class="form-control" value="<?php echo $zona_tarea; ?>" readonly>
              </div>
            </div>
            <div class="form-row align-items-end">
              <div class="form-group col">
                <label class="text-center">Deposito</label>
                <select type="text" name="zona" class="form-control">
                <option selected><?php echo $zona; ?></option>
                <option value="CABA">CABA</option>
                <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                <option value="Lomas de Zamora">Lomas de Zamora</option>
                <option value="San Nicolas">San Nicolas</option>
              </select>
              </div>
              <div class="form-group col">
                <label>Numero de interaccion</label>
                <input type="number" name="tkl" class="form-control" value="<?php echo $tkl; ?>" placeholder="Actualice el numeto de interaccion" autofocus>
              </div>
              <div class="form-group col">
                <label>Motivo del cierre</label>
                <input type="text" class="form-control" value="<?php echo $motivo; ?>" readonly>
              </div>
            </div>
            <div class="form-row align-items-end">
              <div class="form-group col">
                <label>Observaciones del tecnico</label>
                <textarea type="text" class="form-control" readonly><?php echo $obs_tecnico; ?></textarea>
              </div>
              <div class="form-group col">
                <label>Observaciones</label>
                <textarea type="text" name="obs" class="form-control"><?php echo $obs; ?></textarea>
              </div>
            </div>
            <input type="submit" name="updateb" class="btn btn-success btn-block" value="Actualizar orden">
          </form>
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
</body>
</html>
