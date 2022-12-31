<?php
include("../db.php");
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
$tecnico = '';
$fecha= '';
$id_nc= '';
$supervisor= '';
$problema= '';

if  (isset($_GET['id']))
{
  $id = $_GET['id'];
  $result = mysqli_query($conn, "SELECT * FROM no_conformidades WHERE id = '$id' ");
  if (mysqli_num_rows($result) == 1)
  {
    $row = mysqli_fetch_array($result);
    $tecnico = $row['tecnico'];
    $fecha = $row['fecha'];
    $id_nc = $row['id_nc'];
    $supervisor = $row['supervisor'];
    $problema = $row['problema'];
  }
}

if (isset($_POST['updatedes']))
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
    'No conformidad',
    '$hoy_movi',
    '$tipo_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
    
  $id = $_GET['id'];
  $tecnico= $_POST['tecnico'];
  $fecha = $_POST['fecha'];
  $id_nc = $_POST['id_nc'];
  $supervisor = $_POST['supervisor'];
  $problema = $_POST['problema'];

  $query = "UPDATE no_conformidades set tecnico = '$tecnico', fecha = '$fecha', id_nc = '$id_nc', supervisor = '$supervisor', problema = '$problema' WHERE id=$id";
  mysqli_query($conn, $query);
  $_SESSION['card'] = 1;
  $_SESSION['message'] = "Se actualizo la no conformidad de " .$tecnico;
  $_SESSION['message_type'] = 'warning';
  header('Location: ../Basico/no_conformidad.php');
}
include('../includes/header.php'); ?>
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <div class="card card-body">
            <form action="edit_nc.php?id=<?php echo $_GET['id']; ?>" method="POST">
              <p class="h4 mb-4 text-center">Actualizacion de no conformidad (<?php echo $id_nc; ?>)</p>
              <div class="form-row">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Tecnico</label >
                    <select type="text" name="tecnico" class="form-control">
                      <option selected><?php echo $tecnico; ?></option>                
                      <?php
                      $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE tipo = 'Tecnico' AND activo = 'SI' ORDER BY tecnico asc");
                      ?>
                      <?php foreach ($ejecutar as $opciones): ?>   
                        <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                      <?php endforeach ?>
                    </select>
                </div>
                  <div class="form-group col">
                  <label for="exampleFormControlSelect1">Fecha</label >
                  <input type="date" name="fecha" value="<?php echo $fecha; ?>" class="form-control">
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Supervisor</label >
                  <input type="text" name="supervisor" class="form-control" value="<?php echo $supervisor; ?>">
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">ID</label >
                  <input type="text" name="id_nc" class="form-control" value="<?php echo $id_nc; ?>">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Observaciones</label >
                  <textarea type="text" name="problema" class="form-control" autofocus><?php echo $problema; ?></textarea>
                </div>    
              </div>  
              
              <input type="submit" name="updatedes" class="btn btn-success btn-block" value="Actualizar penalizacion">
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
<!-- Datatable -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- Filtro por columnas -->
<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script> 
</body>
</html>
