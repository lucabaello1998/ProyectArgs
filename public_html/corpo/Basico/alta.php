<?php
  include("../../db.php");
  session_start();
  if(!$_SESSION['nombre'])
  {
  session_destroy();
  header("location: ../indexcorpo.php");
  exit();
  }
  $tipo = $_SESSION['tipo_us'];
  if($tipo == "Administrador") { $usu = 1; }
  if($tipo == "Despacho") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../inicio.php");
  }
?>
<?php include('../include/header.php'); ?>

<div class="container-fluid">
  <div class="row justify-content-center p-1">
    <div class="col-auto">
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
    </div>
  </div>
  
  
  <div class="row justify-content-center p-1">
    <div class="col-5 col-sm-5 p-1">
      <div class="row justify-content-center p-1 pr-3">
        <button type="button" class="btn btn-success p-2 m-2" data-toggle="modal" data-target="#excel">
          <i class="fa-solid fa-file-excel"></i>
        </button>
        <button type="button" class="btn btn-success p-2 m-2" data-toggle="modal" data-target="#individual">
          <i class="fa-solid fa-dolly"></i>
        </button>
        <a class="btn btn-success p-2 m-2" href="ingresoseriado.php" role="button"><i class="fa-solid fa-barcode"></i></a>
      </div>
    </div>
  </div>
  

  <div class="row justify-content-center p-1">
    <h4 class="text-center">Carga de Tareas Realizadas</h4>
  </div>
  <div class="row justify-content-center p-1">
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#alta">Altas <i class="fa-solid fa-angle-up pr-2"></i></button> 
  </div>

  <div class="row justify-content-center p-1">
    <a class="btn btn-info text-light" role="button">Ver todas las altas</a> 
  </div>
  <br>

  <!-- Modal -->
    <div class="modal fade" id="alta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-center">Carga de Tareas Completadas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="../Guardar/save_altas.php" method="POST">
            <div class="modal-body">
              <p class="h4 mb-4 text-center">Carga de Tareas Completadas</p>
                <div class="form-row">
                  <label>CT</label >
                  <input type="text" name="CT" class="form-control" autofocus required>
                </div>            
                <div class="form-row">
                  <label>Fecha</label >
                  <input type="date" name="FECHA" class="form-control" required>
                </div>
                <div class="form-row">
                  <label>Tarea</label >
                  <input type="text" name="TAREA"  class="form-control" required>        
                </div>
                <div class="form-row">
                  <label>Cliente</label >
                  <input type="text" name="CLIENTE" class="form-control" required>
                </div>
                <div class="form-row">
                  <label>Orden</label >
                  <input type="text" name="ORDEN" class="form-control" required>
                </div>
                <div class="form-row">
                  <label>Enlace</label >
                  <input type="text" name="ENLACE"  class="form-control" required>
                </div>
                <div class="form-row">
                  <label>Asignado</label >
                  <input type="text" name="ASIGNADO" class="form-control" required>
                </div>
                <div class="form-row">
                  <label>Certificacion</label >
                  <input type="text" name="CERTIFICACION"  class="form-control" required>
                </div>  
                <div class="form-row">
                  <label>Link_Sytex</label >
                  <input type="text" name="LINK SYTEX" class="form-control" required>
                </div>         
            </div>
            <div class="modal-footer">
              <input type="submit" name="save_altas" class="btn btn-success btn-block" value="Guardar datos">
            </div>
          </form>
        </div>      
      </div>
    </div>
  <!-- Modal -->

  <style>
    thead tr th { 
      position: sticky;
      top: -2px;
      z-index: 10;
      border: #343a40 !important;
    }
    .table-responsive { 
      max-height:1000px;
      overflow:scroll;
    }
    *::-webkit-scrollbar {
      width: 6px;
      height: 6px;
      background-color: #343a401f !important;
    }
    *::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
                box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        background-color: #343a401f !important;
    }
    *::-webkit-scrollbar-thumb {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
                box-shadow: inset 0 0 6px rgba(0,0,0,.3);
        background-color: #343a40 !important;
    }
  </style>


  <!-- PESTAÑAS -->
    <!-- BORRAR ESTE TITULO -->
      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <span class="text-center h5">Pestañas</span>
        </div>
      </div>
    <!-- BORRAR ESTE TITULO -->

    <div class="row justify-content-center p-1">
      <div class="col-auto">
        <nav>
          <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
              <?php
                $titulo = mysqli_query($conn, "SELECT * FROM corpo WHERE TAREA <> '' GROUP BY TAREA");
                while($row = mysqli_fetch_assoc($titulo))
                {
                  $task = $row['TAREA'];
                  $task = str_replace( ' ', '', $task );
                  $task = str_replace( '.', '', $task );
              ?>
                <button class="nav-link" id="nav-<?php echo $task; ?>-tab" data-toggle="tab" data-target="#nav-<?php echo $task; ?>" type="button" role="tab" aria-controls="nav-<?php echo $task; ?>" aria-selected="true"><?php echo $task; ?></button>
              <?php } ?>
          </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
          <?php
            $title = mysqli_query($conn, "SELECT * FROM corpo WHERE TAREA <> '' GROUP BY TAREA");
            while($roww = mysqli_fetch_assoc($title))
            {
              $taskk = $roww['TAREA'];
              $taskk = str_replace( ' ', '', $taskk );
              $taskk = str_replace( '.', '', $taskk );
              $tareasss = $roww['TAREA'];
          ?>
            <div class="tab-pane fade" id="nav-<?php echo $taskk; ?>" role="tabpanel" aria-labelledby="nav-<?php echo $taskk; ?>-tab">
              <div class="col-auto">
                <table class="table table-responsive table-striped table-bordered table-sm">
                  <thead class="thead-dark text-center">
                    <tr>
                      <th>Acciones</th>
                      <th>ID</th>
                      <th>CT</th>
                      <th>Fecha</th>
                      <th>Tarea</th>
                      <th>Cliente</th>
                      <th>Orden</th>
                      <th>Enlace</th>
                      <th>Asignado</th>
                      <th>Certificacion</th>
                      <th>Link_Sytex</th>
                    </tr>
                  </thead>
                  <tbody align="center">
                    <?php
                      $r = mysqli_query($conn, "SELECT * FROM corpo WHERE TAREA = '$tareasss' ORDER BY ID DESC"); /* CONSULTA EDITADA "WHERE INICIOtareas[columna de la tabla donde aplicar filtro] = 'Alta'" */ /* "CLIENTE descendiente" ORDER BY CERTIFICACION[columna en cual CLIENTEar] DESC  */
                      while($rowq = mysqli_fetch_assoc($r))
                      {
                    ?>
                      <tr>
                        <td>
                          <a href="../Editar/editar.php?id=<?php echo $rowq['id']?>">
                            <i class="fas fa-pen p-2"></i>
                          </a>
                          <button type="button" class="btn p-2" data-toggle="modal" data-target="#borrar_<?php echo $rowq['ID']; ?>"><i class="far fa-trash-alt p-2 text-danger"></i></button>
                          <!-- Borrar -->
                            <div class="modal fade" id="borrar_<?php echo $row['ID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title h5">Orden <?php echo $row['ORDEN']; ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    ¿Seguro que quiere borrar la tarea?
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-danger p-2" data-dismiss="modal">No</button>
                                    <a class="btn btn-success p-2" href="../Borrar/BorrarDatos.php?id=<?php echo $row['ID']?>" role="button">Si</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          <!-- Borrar -->
                        </td>
                        <td><?php echo $rowq['ID']; ?></td>         
                        <td><?php echo $rowq['CT']; ?></td>
                        <td><?php echo Fecha7($rowq['FECHA']); ?></td>
                        <td><?php echo $rowq['TAREA']; ?></td>
                        <td><?php echo $rowq['CLIENTE']; ?></td>
                        <td><?php echo $rowq['ORDEN']; ?></td>
                        <td><?php echo $rowq['ENLACE']; ?></td>
                        <td><?php echo $rowq['ASIGNADO']; ?></td>
                        <td><?php echo $rowq['CERTIFICACION']; ?></td>
                        <td data-toggle="tooltip" data-placement="top" title="<?php echo $rowq['LINK_SYTEX']; ?>"><a href="<?php echo $rowq['LINK_SYTEX']; ?>" target="_blank"><i class="fa-regular fa-clipboard p-2"></i></a></td>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  <!-- PESTAÑAS -->

  <br>
  <!-- TABLA CLASICA -->
      <!-- BORRAR ESTE TITULO -->
        <div class="row justify-content-center p-1">
          <div class="col-auto">
            <span class="text-center h5">Tabla clasica</span>
          </div>
        </div>
      <!-- BORRAR ESTE TITULO -->

    <div class="row justify-content-center p-1">
      <div class="col-auto">
        <table class="table table-responsive table-striped table-bordered table-sm">
          <thead class="thead-dark text-center">
            <tr>
              <th>Acciones</th>
              <th>ID</th>
              <th>CT</th>
              <th>Fecha</th>
              <th>Tarea</th>
              <th>Cliente</th>
              <th>Orden</th>
              <th>Enlace</th>
              <th>Asignado</th>
              <th>Certificacion</th>
              <th>Link_Sytex</th>
            </tr>
          </thead>
          <tbody align="center">
            <?php
              $result_tasks = mysqli_query($conn, "SELECT * FROM corpo ORDER BY ID DESC"); /* CONSULTA EDITADA "WHERE INICIOtareas[columna de la tabla donde aplicar filtro] = 'Alta'" */ /* "CLIENTE descendiente" ORDER BY CERTIFICACION[columna en cual CLIENTEar] DESC  */
              while($row = mysqli_fetch_assoc($result_tasks))
              {
            ?>
              <tr>
                <td>
                  <a href="../Editar/editar.php?id=<?php echo $row['id']?>">
                    <i class="fas fa-pen p-2"></i>
                  </a>
                  <button type="button" class="btn p-2" data-toggle="modal" data-target="#borrar_<?php echo $row['ID']; ?>"><i class="far fa-trash-alt p-2 text-danger"></i></button>
                  <!-- Borrar -->
                    <div class="modal fade" id="borrar_<?php echo $row['ID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title h5">Orden <?php echo $row['ORDEN']; ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            ¿Seguro que quiere borrar la tarea?
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-danger p-2" data-dismiss="modal">No</button>
                            <a class="btn btn-success p-2" href="../Borrar/Borrar_Datos.php?id=<?php echo $row['ID']?>" role="button">Si</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  <!-- Borrar -->
                </td>
                <td><?php echo $row['ID']; ?></td>         
                <td><?php echo $row['CT']; ?></td>
                <td><?php echo Fecha7($row['FECHA']); ?></td>
                <td><?php echo $row['TAREA']; ?></td>
                <td><?php echo $row['CLIENTE']; ?></td>
                <td><?php echo $row['ORDEN']; ?></td>
                <td><?php echo $row['ENLACE']; ?></td>
                <td><?php echo $row['ASIGNADO']; ?></td>
                <td><?php echo $row['CERTIFICACION']; ?></td>
                <td data-toggle="tooltip" data-placement="top" title="<?php echo $row['LINK_SYTEX']; ?>"><a href="<?php echo $row['LINK_SYTEX']; ?>" target="_blank"><i class="fa-regular fa-clipboard p-2"></i></a></td>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  <!-- TABLA CLASICA -->

</div>
<!-- PIE DE PAGINA -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- then Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
</body>
</html>