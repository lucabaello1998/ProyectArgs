<?php include("../../db.php"); ?>
<?php include('../include/header.php'); ?>
<!-----Deposito---->
<?php
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
if($usu != 1)
{
  header("location: ../inicio.php");   /////Visor - Deposito - Supervisor/////
}
?>

<main class="container p-2">
  <div class="row">
    <div class="col-lg">

      <!-- MESSAGES -->
      <?php session_start();      
       if ($_SESSION['card'] == 1) { ?>
      <div class="alert alert-<?= $_SESSION['message_type']?> alert-dismissible fade show" role="alert">
        <?= $_SESSION['message']?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php $_SESSION['card'] = 0; } ?>
<!-- MESSAGES -->

<!-- Button trigger modal -->
<div class="container">
  <div class="form-row justify-content-center">
  <h4 class="modal-title" text-center>Formulario de Carga de modificaciones</h4>
</div>
<div class="col-12 col-sm-12">
    <div class="form-row justify-content-center">
      <div class="col-5 col-sm-5">
        <div class="row justify-content-end p-1 pr-3">
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#alta">
            Altas <i class="fa-solid fa-angle-up"></i>
          </button>
        </div>
        <div class="row justify-content-end p-1 pr-3">
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#baja">
            Baja <i class="fas fa-chevron-up"></i>
          </button> 
        </div>
        <div class="row justify-content-end p-1 pr-3">
        	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#Modificacion">
            Modificacion <i class="fas fa-chevron-ap"></i>
          </button>
        </div>
        <div class="col-5 col-sm-5">
        <div class="row justify-content-start p-1 pl-3">
           <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#egreso">
           Baja <i class="fas fa-chevron-down"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal 1 -->
<div class="modal fade" id="alta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" text-center>Carga de Modificacion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="card card-body">
        <form action="../Guardar/save_modificaciones.php" method="POST" data-toggle="validator">

          <p class="h4 mb-4 text-center">Carga de tareas de Modificacion</p>

            <div class="form-row">
              <label for="exampleFormControlSelect1">ID</label >
              <input type="text" name="ID" class="form-control" autofocus required>
            </div>
            <div class="form-row">
              <label for="exampleFormControlSelect1">CT</label >
              <input type="text" name="CT" class="form-control" autofocus required>
            </div>            
            <div class="form-row">
              <label for="exampleFormControlSelect1">FECHA</label >
              <input type="date" name="FECHA" class="form-control" autofocus required>
            </div>
            <div class="form-row">
              <label for="exampleFormControlSelect1">TAREA</label >
              <input type="text" name="TAREA"  class="form-control"  autofocus required>        
            </div>
           <div class="form-row">
              <label for="exampleFormControlSelect1">CLIENTE</label >
              <input type="text" name="CLIENTE" class="form-control"  autofocus required>
             </div>
             <div class="form-row">
              <label for="exampleFormControlSelect1">ORDEN</label >
              <input type="text" name="ORDEN" class="form-control"  autofocus required>
             </div>
           <div class="form-row">
            <label for="exampleFormControlSelect1">ENLACE</label >
            <input type="text" name="ENLACE"  class="form-control"  autofocus required>
           </div>
            <div class="form-row">
              <label for="exampleFormControlSelect1">ASIGNADO</label >
              <input type="text" name="ASIGNADO" class="form-control"  autofocus required>
            </div>
            <div class="form-row">         
              <label for="exampleFormControlSelect1">CERTIFICACION</label >
              <input type="text" name="CERTIFICACION"  class="form-control"  autofocus required>
            </div>          
            <div class="form-row">
              <label for="exampleFormControlSelect1">LINK_SYTEX</label >
              <input type="text" name="LINK SYTEX" class="form-control"  autofocus required>
            </div>            
          </div>
       </div>
        <input type="submit" name="save_altas" class="btn btn-success btn-block" value="Guardar datos">
      </form>
      </div>      
    </div>
  </div>
</div>
</main>




<!-- TABLA GARANTIAS-->


<div class="container-fluid p-2 p-md-5 p-sm-3">
  <div class="row align-items-start justify-content-center">
    <div class="col-12">
      <p class="h4 mb-4 text-center">Datos Cargados</p>
      
      <table class="table table-responsive table-striped table-bordered table-sm">
        <thead class="thead-dark text-center">
          <tr>
            <th class="col-auto">Acciones</th>
          	<th class="col-auto">ID</th>
            <th class="col-auto">CT</th>
            <th class="col-auto">FECHA</th>
            <th class="col-auto">TAREA</th>
            <th class="col-auto">CLIENTE</th>
            <th class="col-auto">ORDEN</th>
            <th class="col-auto">ENLACE</th>
            <th class="col-auto">ASIGNADO</th>
            <th class="col-auto">CERTIFICACION</th>
            <th class="col-auto">LINK_SYTEX</th>
            </tr>
        </thead>
        <tbody align="center">
          <?php
          $query = "SELECT * FROM corpo WHERE ID ORDER BY ID DESC"; /* CONSULTA EDITADA "WHERE INICIOtareas[columna de la tabla donde aplicar filtro] = 'Alta'" */ /* "CLIENTE descendiente" ORDER BY CERTIFICACION[columna en cual CLIENTEar] DESC  */
          $result_tasks = mysqli_query($conn, $query);    

          while($row = mysqli_fetch_assoc($result_tasks)) { ?>
            <tr>
              <td>
                <a href="../Editar/1edit_garantas.php?id=<?php echo $row['id']?>">
                  <i class="fas fa-pen p-2"></i>
                </a>
                <a href="../Borrar/1delete_garantas.php?id=<?php echo $row['id']?>">
                  <i class="far fa-trash-alt p-2"></i>
                </a>
              </td>              
              <td><?php echo $row['ID']; ?></td>
              <td><?php echo $row['CT']; ?></td>
              <td><?php echo $row['FECHA']; ?></td>
              <td><?php echo $row['TAREA']; ?></td>
              <td><?php echo $row['CLIENTE']; ?></td>
              <td><?php echo $row['ORDEN']; ?></td>
              <td><?php echo $row['ENLACE']; ?></td>
              <td><?php echo $row['ASIGNADO']; ?></td>
              <td><?php echo $row['CERTIFICACION']; ?></td>
              <td><?php echo $row['LINK_SYTEX']; ?></td>
          <?php } ?>
        </tbody>
      </table>
     
           
      
    </div>
  </div>
  <div class="row align-items-start justify-content-center">
        
         
              <a class="btn btn-info" role="button">Ver todos los Datos</a>             
        
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