<?php 
include('../db.php');
session_start();
if(!$_SESSION['nombre'])
{
  session_destroy();
  header("location: ../index.php");
  exit();
}
$tipo = $_SESSION['tipo_us'];
if($tipo == "Administrador") { $usu = 1; }
if($tipo == "Despacho") { $usu = 1; }
if($tipo == "Supervisor") { $usu = 1; }
if($tipo == "Deposito") { $usu = 1; }
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
$inicio = '';
$fin = '';
$tarea = '';
$tecnico = '';
$ot_tarea = '';
$id_tarea = '';
$a_quien = '';

if(isset($_GET['token']))
{
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
    $inicio = $row['inicio'];
    $fin = $row['fin'];
    $tarea = $row['tarea'];
    $tecnico = $row['tecnico'];
    $ot_tarea = $row['ot_tarea'];
    $id_tarea = $row['id_tarea'];
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
  $tarea = $_POST['tarea'];
  $tecnico = $_POST['tecnico'];
  $ot_tarea = $_POST['ot_tarea'];
  $ot_tareas = str_replace(' ', '', $ot_tarea);

  if($_POST['tarea'] == 'Garantia')
  {
    $r = mysqli_query($conn, "SELECT * FROM garantias WHERE ot = '$ot_tareas' ORDER BY fecharep desc LIMIT 1");
    if (mysqli_num_rows($r) == 1)
    {
      $row = mysqli_fetch_array($r);
      $ot = $row['ot'];
      $id = $row['id'];
    }
    else
    {
      $ot = "No se encontro OT";
      $id = "No se encontro ID";
    }
  }

  elseif($_POST['tarea'] == 'Reclamo')
  {
    $q = mysqli_query($conn, "SELECT * FROM reclamos WHERE ot = '$ot_tareas' ORDER BY fechains desc LIMIT 1");
    if (mysqli_num_rows($q) == 1)
    {
      $row = mysqli_fetch_array($q);
      $ot = $row['ot'];
      $id = $row['id'];
    }
    else
    {
      $ot = "No se encontro OT";
      $id = "No se encontro ID";
    }
  }


  $consulta = "UPDATE calendario SET a_quien = '$a_quien', titulo = '$titulo', contenido = '$contenido', inicio = '$inicio', fin = '$fin', tarea = '$tarea', tecnico = '$tecnico', ot_tarea = '$ot', id_tarea = '$id' WHERE token = '$token'";
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
  header('Location: ../Basico/calendario_despacho.php');
}
?>

<?php include('../includes/header.php'); ?>
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Actualizar la tarea "<?php echo $titulo ?>"</p>
          <form action="edit_calendario.php?token=<?php echo $_GET['token']; ?>" method="POST">
            <div class="row justify-content-center">
              <div class="col-10">

                <div class="form-row">
                  <div class="form-group col-md-4 col-12">
                    <label class="text-muted">Titulo</label>
                    <input type="text" name="titulo" class="form-control"value="<?php echo $titulo; ?>">
                  </div>
                  <div class="form-group col-md-4 col-6">
                    <label>Inicio</label >
                    <input type="date" name="inicio" class="form-control" value="<?php echo $inicio; ?>">
                  </div>
                  <div class="form-group col-md-4 col-6">
                    <label>Fin</label >
                    <input type="date" name="fin" class="form-control" value="<?php echo $fin; ?>">
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col">
                    <label>Tecnico</label >
                    <select type="text" name="tecnico" class="form-control">
                      <option selected value="<?php echo $tecnico; ?>"><?php echo $tecnico; ?></option>
                      <?php
                        $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE tipo = 'Tecnico' AND activo ='SI' ORDER BY tecnico asc");
                        foreach ($ejecutar as $opciones):
                      ?>   
                        <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                      <?php endforeach ?>
                    </select>
                  </div>
                  <div class="form-group col">
                    <label>Tarea</label >
                    <select type="text" name="tarea" class="form-control">
                      <option selected value="<?php echo $tarea; ?>"><?php echo $tarea; ?></option>
                      <option value="Auditoria de herramientas">Auditoria de herramientas</option>
                      <option value="Auditoria de instalacion">Auditoria de instalacion</option>
                      <option value="Auditoria vehiculo">Auditoria vehiculo</option>
                      <option value="Garantia">Garantia</option>
                      <option value="Reclamo">Reclamo</option>
                      <option value="Relevamiento fotografico">Relevamiento fotografico</option>
                      <option value="Otro">Otro</option>
                    </select>
                  </div>
                  <?php if($ot_tarea !== ''){ ?>
                    <div class="form-group col">
                      <label>OT</label>
                      <input type="text" name="ot_tarea" class="form-control" value="<?php echo $ot_tarea; ?>">
                    </div>
                  <?php } ?>
                </div>

                <div class="row">
                  <div class="form-group col-md-4 col-12">
                    <label>Supervisor</label >
                    <select type="text" name="a_quien[]" class="form-control">                
                      <option selected value="<?php echo $a_quien; ?>"><?php echo $a_quien; ?></option>                
                      <?php
                        $ejecutar=mysqli_query($conn,"SELECT * FROM usuarios WHERE tipo_us = 'Supervisor' ORDER BY nombre asc");
                        foreach ($ejecutar as $opciones):
                      ?>   
                        <option value="<?php echo $opciones['nombre'] .' ' .$opciones['apellido']; ?>"><?php echo $opciones['nombre'] .' ' .$opciones['apellido']; ?></option>                                      
                      <?php endforeach ?>
                    </select>
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