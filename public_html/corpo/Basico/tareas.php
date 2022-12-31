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
  <h4 class="modal-title" text-center>Formulario de Tareas</h4>
</div>
<div class="col-12 col-sm-12">
    <div class="form-row justify-content-center">
      <div class="col-5 col-sm-5">
        <div class="row justify-content-end p-1 pr-3">
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#alta">
           Cargar Tarea <i class="fa-solid fa-angle-up"></i>
          </button>
        </div>
        <!---<div class="row justify-content-end p-1 pr-3">
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#baja">
            Baja <i class="fas fa-chevron-up"></i>
          </button> 
        </div>
        <div class="row justify-content-end p-1 pr-3">
        	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#baja">
            Modificacion <i class="fas fa-chevron-ap"></i>
          </button>
        </div>
        <div class="col-5 col-sm-5">
        <div class="row justify-content-start p-1 pl-3">
           <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#baja">
            Egreso <i class="fas fa-chevron-down"></i>
          </button>
        </div>
      </div>--->
    </div>
  </div>
</div>
<!-- Modal 1 -->
<div class="modal fade" id="alta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" text-center>Formulario de Carga de Tareas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="card card-body">
        <form action="../Guardar/save_tareas.php" method="POST" data-toggle="validator">

          <p class="h4 mb-4 text-center">Carga de Tareas </p>

            <div class="form-row">
              <label for="exampleFormControlSelect1">ID</label >
              <input type="text" name="id" class="form-control" autofocus >
            </div>
            <div class="form-row">
              <label for="exampleFormControlSelect1">F_Asignado</label >
              <input type="date" name="F_Asignado" class="form-control" autofocus>
            </div>
            <div class="form-row">
              <label for="exampleFormControlSelect1">estado</label >
              <input type="text" name="estado" class="form-control" autofocus>
            </div>            
            <div class="form-row">
              <label for="exampleFormControlSelect1">orden</label >
              <input type="number" name="orden" class="form-control" autofocus>
            </div>
            <div class="form-row">
              <label for="exampleFormControlSelect1">enlace</label >
              <input type="number" name="enlace"  class="form-control"  autofocus>        
            </div>
            <div class="form-row">
              <label for="exampleFormControlSelect1">asignado_por</label >
              <input type="text" name="asignado_por" class="form-control"  autofocus>
            </div>
            <div class="form-row">
              <label for="exampleFormControlSelect1">cliente</label >
              <input type="text" name="cliente" class="form-control"  autofocus>
            </div>
            <div class="form-row">
              <label for="exampleFormControlSelect1">referente</label >
              <input type="text" name="referente"  class="form-control"  autofocus>
            </div>
            <div class="form-row">
              <label for="exampleFormControlSelect1">domicilio</label >
              <input type="text" name="domicilio" class="form-control"  autofocus>
            </div>
            <div class="form-row">         
              <label for="exampleFormControlSelect1">celular</label >
              <input type="text" name="celular"  class="form-control"  autofocus>
            </div>          
            <div class="form-row">
              <label for="exampleFormControlSelect1">email_contacto</label >
              <input type="text" name="email_contacto" class="form-control"  autofocus>
            </div> 
            <!--<div class="form-row">         
              <label for="exampleFormControlSelect1">imagen_1</label >
              <input type="text" name="imagen_1"  class="form-control"  autofocus>
            </div>
            <div class="form-row">         
              <label for="exampleFormControlSelect1">imagen_2</label >
              <input type="text" name="imagen_2"  class="form-control"  autofocus>
            </div>
            <div class="form-row">         
              <label for="exampleFormControlSelect1">imagen_3</label >
              <input type="text" name="imagen_3"  class="form-control"  autofocus>
            </div>
            <div class="form-row">         
              <label for="exampleFormControlSelect1">imagen_4</label >
              <input type="text" name="imagen_4"  class="form-control"  autofocus>
            </div>
            <div class="form-row">         
              <label for="exampleFormControlSelect1">imagen_5</label >
              <input type="text" name="imagen_5"  class="form-control"  autofocus>
            </div>
            <div class="form-row">         
              <label for="exampleFormControlSelect1">imagen_6</label >
              <input type="text" name="imagen_6"  class="form-control"  autofocus>
            </div>-->          
       </div>
        <input type="submit" name="save_tareas" class="btn btn-success btn-block" value="Guardar datos">
      </form>
      </div>      
    </div>
  </div>
</div>
</main>




<!-- Carga de Tareas-->


<div class="container-fluid p-2 p-md-5 p-sm-3">
  <div class="row align-items-start justify-content-center">
    <div class="col-12">
      <p class="h4 mb-4 text-center">Tareas cargadas</p>
      
      <table class="table table-responsive table-striped table-bordered table-sm">
        <thead class="thead-dark text-center">
          <tr>
            <th class="col-auto">Acciones</th>
          	<th class="col-auto">id</th>
            <th class="col-auto">F_Asigmnado</th>
            <th class="col-auto">estado</th>
            <th class="col-auto">orden</th>
            <th class="col-auto">enlace</th>
            <th class="col-auto">asignado_por</th>
            <th class="col-auto">cliente</th>
            <th class="col-auto">referente</th>
            <th class="col-auto">domicilio</th>
            <th class="col-auto">celular</th>
            <th class="col-auto">email_contacto</th>
            <!--<th class="col-auto">imagen_1</th>
            <th class="col-auto">imagen_2</th>
            <th class="col-auto">imagen_3</th>
            <th class="col-auto">imagen_4</th>
            <th class="col-auto">imagen_5</th>
            <th class="col-auto">imagen_6</th>-->
            </tr>
        </thead>
        <tbody align="center">
          <?php
          $query = "SELECT * FROM corpo_tareas WHERE F_Asignado ORDER BY F_Asignado DESC "; /* CONSULTA EDITADA "WHERE INICIOtareas[columna de la tabla donde aplicar filtro] = 'Alta'" */ /* "CLIENTE descendiente" ORDER BY CERTIFICACION[columna en cual CLIENTEar] DESC  */
          $result_tasks = mysqli_query($conn, $query);    

          while($row = mysqli_fetch_assoc($result_tasks)) { ?>
            <tr>
              <td>
                <a href="../Editar/editar_tareas.php?id=<?php echo $row['id']?>">
                  <i class="fas fa-pen p-2"></i>
                </a>
                <a href="../Borrar/Borrar_Datos.php?id=<?php echo $row['id']?>">
                  <i class="far fa-trash-alt p-2"></i>
                </a>
              </td>              
              <td><?php echo $row['id']; ?></td>
              <td><?php echo $row['F_Asignado']; ?></td>
              <td><?php echo $row['estado']; ?></td>
              <td><?php echo $row['orden']; ?></td>
              <td><?php echo $row['enlace']; ?></td>
              <td><?php echo $row['asignasdo_por']; ?></td>
              <td><?php echo $row['cliente']; ?></td>
              <td><?php echo $row['referente']; ?></td>
              <td><?php echo $row['domicilio']; ?></td>
              <td><?php echo $row['celular']; ?></td>
              <td><?php echo $row['email_contacto']; ?></td>
             
          <?php } ?>
        </tbody>
      </table>
     		  
           
      
    </div>
  </div>
  <div class="row align-items-start justify-content-center">
        
         
              <a class="btn btn-info" role="button">Ver todas las tareas</a>             
        
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

			  <!--<td><?php echo $row['imagen_1']; ?></td>
              <td><?php echo $row['imagen_2']; ?></td>
              <td><?php echo $row['imagen_3']; ?></td>
              <td><?php echo $row['imagen_4']; ?></td>
              <td><?php echo $row['imagen_5']; ?></td>
              <td><?php echo $row['imagen_6']; ?></td>-->