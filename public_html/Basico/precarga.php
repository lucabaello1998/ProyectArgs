<?php
  include("../db.php");
  session_start();
  if(!$_SESSION['nombre'])
  {
  session_destroy();
  header("location: ../index.php");
  exit();
  }
  $nombre = $_SESSION['nombre'];
  $apellido = $_SESSION['apellido'];
  $tipo_us = $_SESSION['tipo_us'];
  $zona_us = $_SESSION['zona'];
  if($tipo_us == "Administrador") { $usu = 1; }
  if($tipo_us == "Despacho") { $usu = 1; }
  if($tipo_us == "Supervisor") { $usu = 1; }
  if($tipo_us == "Deposito") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
  }
?>
<?php include('../includes/header.php'); ?>

<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">
      <div class="row justify-content-center p-1">
        <div class="col">
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
        <div class="col">
          <div class="card card-body">
            <form action="../Guardar/save_precarga.php" method="POST" >
              <p class="h4 mb-4 text-center">Precarga de asignacion</p>
              <div class="form-row">
                <?php if($tipo_us == 'Administrador' && $zona_us == 'Todo') { ?>            
                    <div class="form-group col">
                      <label for="exampleFormControlSelect1">Zona</label>
                      <select type="text" name="zona" class="form-control" require>
                        <option selected disabled value="">Zona...</option>
                        <option value="Lomas de Zamora">Lomas de Zamora</option>
                        <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                        <option value="San Nicolas">San Nicolas</option>
                      </select>
                    </div>
                <?php }else{ ?>
                  <input type="hidden" name="zona" value="<?php echo $zona_us; ?>"/>
                <?php } ?>

                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Material</label >
                  <select type="text" name="material" class="form-control">                
                    <option selected disabled value="">Material...</option>               
                    <?php
                      $consulta="SELECT * FROM ingresomaterial WHERE seriado = '' AND cantidad > 1 GROUP BY material ORDER BY material asc";
                      $ejecutar=mysqli_query($conn,$consulta) or die (mysqli_error($conn));
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?>   
                      <option value="<?php echo $opciones['material'] ?>"><?php echo $opciones['material'] ?></option>                                      
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Cantidad</label >
                  <input type="number" name="cantidad" maxlength="11" class="form-control">
                </div>
              </div>
              <br>
              <input type="submit" name="save_precarga" class="btn btn-success btn-block" value="Guardar precarga">
            </form>
          </div>
        </div>
      </div>

      <br>

        <?php if ($zona_us == 'Lomas de Zamora' || $tipo_us == 'Administrador') {?>
        <div class="row justify-content-center">
          <div class="col-auto text-center">
            <p class="h4 mb-4 text-center">Lomas de Zamora</p>
              <table class="table table-responsive table-striped table-bordered table-sm" align="center">
                <thead class="thead-dark text-center">
                  <tr>
                    <th>Acciones</th>
                    <th>SAP</th>
                    <th>Material</th>
                    <th>Cantidad</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = "SELECT * FROM asignacion_material WHERE tipo = 'Precarga' AND deposito = 'Lomas de Zamora'";
                  $result_tasks = mysqli_query($conn, $query);    
                  while($row = mysqli_fetch_assoc($result_tasks)) {
                    ?>
                    <tr>
                      <td align="center">
                        <a href="../Editar/edit_precarga.php?id=<?php echo $row['id']?>">
                          <i class="fas fa-pen p-2"></i>
                        </a>
                        <a href="../Borrar/delete_precarga.php?id=<?php echo $row['id']?>">
                          <i class="far fa-trash-alt  p-2"></i>
                        </a>
                      </td>
                      <td><?php echo $row['sap']; ?></td>
                      <td><?php echo $row['material']; ?></td>                
                      <td><?php echo $row['cantidad']; ?></td>                     
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
          </div>
        </div>
        <?php } ?>
        <?php if ($zona_us == 'Jose Leon Suarez' || $tipo_us == 'Administrador') {?>
        <div class="row justify-content-center">
          <div class="col-auto text-center">
            <p class="h4 mb-4 text-center">Jose Leon Suarez</p>
              <table class="table table-responsive table-striped table-bordered table-sm" align="center">
                <thead class="thead-dark text-center">
                  <tr>
                    <th>Acciones</th>
                    <th>SAP</th>
                    <th>Material</th>
                    <th>Cantidad</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = "SELECT * FROM asignacion_material WHERE tipo = 'Precarga' AND deposito = 'Jose Leon Suarez'";
                  $result_tasks = mysqli_query($conn, $query);    
                  while($row = mysqli_fetch_assoc($result_tasks)) {
                    ?>
                    <tr>
                      <td align="center">
                        <a href="../Editar/edit_precarga.php?id=<?php echo $row['id']?>">
                          <i class="fas fa-pen p-2"></i>
                        </a>
                        <a href="../Borrar/delete_precarga.php?id=<?php echo $row['id']?>">
                          <i class="far fa-trash-alt  p-2"></i>
                        </a>
                      </td>
                      <td><?php echo $row['sap']; ?></td>
                      <td><?php echo $row['material']; ?></td>                
                      <td><?php echo $row['cantidad']; ?></td>                     
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
          </div>
        </div>
        <?php } ?>
        <?php if ($zona_us == 'San Nicolas' || $tipo_us == 'Administrador') {?>
        <div class="row justify-content-center">
          <div class="col-auto text-center">
            <p class="h4 mb-4 text-center">San Nicolas</p>
              <table class="table table-responsive table-striped table-bordered table-sm" align="center">
                <thead class="thead-dark text-center">
                  <tr>
                    <th>Acciones</th>
                    <th>SAP</th>
                    <th>Material</th>
                    <th>Cantidad</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = "SELECT * FROM asignacion_material WHERE tipo = 'Precarga' AND deposito = 'San Nicolas'";
                  $result_tasks = mysqli_query($conn, $query);    
                  while($row = mysqli_fetch_assoc($result_tasks)) {
                    ?>
                    <tr>
                      <td align="center">
                        <a href="../Editar/edit_precarga.php?id=<?php echo $row['id']?>">
                          <i class="fas fa-pen p-2"></i>
                        </a>
                        <a href="../Borrar/delete_precarga.php?id=<?php echo $row['id']?>">
                          <i class="far fa-trash-alt  p-2"></i>
                        </a>
                      </td>
                      <td><?php echo $row['sap']; ?></td>
                      <td><?php echo $row['material']; ?></td>                
                      <td><?php echo $row['cantidad']; ?></td>                     
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
          </div>
        </div>
        <?php } ?>
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