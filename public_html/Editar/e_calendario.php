<?php 
include('../db.php');
session_start();
if(!$_SESSION['nombre'])
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
if($usu != 1)
{
  header("location: ../index.php");
}
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
$quien = $nombre ." " .$apellido;
$quien_notas = $quien;
$quien_a= '';
$a_quien = '';
$titulo = '';
$contenido = '';
$color = '';
$inicio = '';
$fin = ''; 
$a_quien = ''; 

if(isset($_GET['token'])) {
  $token = $_GET['token'];
  $query = "SELECT * FROM calendario WHERE token = '$token'";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1)
  {
    $row = mysqli_fetch_array($result);
    $quien_a = $row['quien'];
    $a_quien = $row['a_quien'];
    $titulo = $row['titulo'];
    $contenido = $row['contenido'];
    $color = $row['color'];
    $inicio = $row['inicio'];
    $fin = $row['fin'];
    $a_quien = $row['a_quien'];
  }
}

if (isset($_POST['actualizar']))
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
    'Calendario',
    '$hoy_movi',
    '$tipo_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */

  $token = $_GET['token'];
  $a_quien= implode(",", $_POST['a_quien']);
  $titulo= Reemplazo($_POST['titulo']);
  $contenido= Reemplazo($_POST['contenido']);
  $inicio= $_POST['inicio'];
  if($_POST['inicio'] > $_POST['fin'])
  {
    $fin = $_POST['inicio'];
  }else{
    $fin = $_POST['fin'];
  }
  $a_quien = implode(", ", $_POST['a_quien']);
  $color_tarea = '#FFAA16';

  $consulta = "UPDATE calendario SET a_quien = '$a_quien', titulo = '$titulo', contenido = '$contenido', color = '$color_tarea', inicio = '$inicio', fin = '$fin', a_quien = '$a_quien', estado = 'Pendiente' WHERE token = '$token'";
  $resultado = mysqli_query($conn, $consulta);
  if(!$resultado)
    {
			$alerta = "Error";
			$msj = "Error en el servidor.";
			$color = "error";
    }
    else
    {
      $alerta = "Actualizado";
      $msj = "La tarea fue actualizada.";
      $color = "warning";
    }
  $_SESSION['card'] = 1;
  $_SESSION['message'] = $msj;
  $_SESSION['message_type'] = $color;
  header('Location: ../Basico/b_calendario.php');
}
?>

<?php include('../includes/header.php'); ?>

<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">
      <div class="col-12 p-2">
        <p class="h4 mb-4 text-center">Actualizar la tarea "<?php echo $titulo ?>"</p>
        <form action="e_calendario.php?token=<?php echo $_GET['token']; ?>" method="POST">
          <div class="row justify-content-center">
            <div class="col-10">

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label class="text-muted">Titulo</label>
                  <input type="text" name="titulo" class="form-control" value="<?php echo $titulo; ?>" >
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Inicio</label >
                  <input type="date" name="inicio" class="form-control" value="<?php echo $inicio; ?>">
                </div>
                <div class="form-group col-md-6">
                  <label>Fin</label >
                  <input type="date" name="fin" class="form-control" value="<?php echo $fin; ?>">
                </div>
              </div>

              <div class="form-row">
                <div class="col-12 p-2">
                  <label>Involucrados</label>
                  <div class="row">
                    <?php
                      $ejecutar_notass = mysqli_query($conn,"SELECT * FROM usuarios WHERE tipo_us <> 'ATC' ORDER BY nombre asc");
                    ?>
                    <?php foreach ($ejecutar_notass as $opciones): ?>
                    <?php $compartir_nota = $opciones['nombre'] .' ' .$opciones['apellido'];
                      if($compartir_nota !== $quien_notas) 
                      {$comp_nota = $compartir_nota;
                    ?>
                      <div class="checkbox col-md-3 col-6">
                        <label><input type="checkbox" name="a_quien[]" value="<?php echo $comp_nota; ?>" <?php if(strpos($a_quien, $comp_nota) !== false){echo 'checked';}else{echo '';} ?>>  <?php echo $comp_nota ?></label>
                      </div>
                    <?php } ?>
                    <?php endforeach ?>
                  </div>
                </div>
              </div>

              <div class="form-row">
                <div class="col-md-12 p-2">
                  <label class="text-muted">Descripcion</label>
                  <textarea type="text" name="contenido" class="form-control"><?php echo $contenido; ?></textarea>
                </div>													
              </div>	
              <input type="submit" name="actualizar" class="btn btn-primary" value="Actualizar">            
            </div>
          </div>           
        </form>
      </div>
    </div>
  </div>
</div>
<!-- PIE DE PAGINA -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- then Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Bofechastrap -->
<script src="https://stackpath.bofechastrapcdn.com/bofechastrap/4.4.1/js/bofechastrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>