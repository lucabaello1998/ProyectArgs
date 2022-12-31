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
  if($tipo_us == "Despacho") { $usu = 1; }
  if($tipo_us == "Supervisor") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
  }
?>
<?php include('../includes/header.php'); ?>
<!-- FECHA -->
  <?php
    $mes = date ('Y-m', strtotime('-0 month'));
    if(isset($_GET['mes']))
    {
      $desencriptado = $_GET['mes'];
      $mes = base64_decode($desencriptado);
    }

    $b = explode("-", $mes);
    switch ($b[1])
    {
      case '12': $mes_nom = "Diciembre";
      break;
      case '11': $mes_nom = "Noviembre";
      break;
      case '10': $mes_nom = "Octubre";
      break;
      case '09': $mes_nom = "Septiembre";
      break;
      case '08': $mes_nom = "Agosto";
      break;
      case '07': $mes_nom = "Julio";
      break;
      case '06': $mes_nom = "Junio";
      break;
      case '05': $mes_nom = "Mayo";
      break;
      case '04': $mes_nom = "Abril";
      break;
      case '03': $mes_nom = "Marzo";
      break;
      case '02': $mes_nom = "Febrero";
      break;
      case '01': $mes_nom = "Enero";
      break;
    }
  ?>
  <div class="container-fluid pr-4 pl-4 pt-0 pb-0">
    <div class="row justify-content-center pr-2 pl-2 pt-2 pb-0">
      <div class="col-auto align-self-center p-0">
        <form action="../Guardar/save_fecha.php" method="POST">
          <input type="hidden" name="ultima_fecha" value="<?php echo $mes; ?>">
          <input type="hidden" name="link" value="../Basico/reclamos.php">
          <button type="submit" name="menos" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Mes anterior">
            <i class="fa-solid fa-caret-left"></i>
          </button>
        </form>
      </div>
      <div class="col-auto align-self-center text-center text-white">
        <span class="h4"><?php echo $mes_nom; ?></span>
      </div>
      <div class="col-auto align-self-center p-0">
        <form action="../Guardar/save_fecha.php" method="POST">
          <input type="hidden" name="ultima_fecha" value="<?php echo $mes; ?>">
          <input type="hidden" name="link" value="../Basico/reclamos.php">
          <button type="submit" name="mas" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Mes siguiente">
            <i class="fa-solid fa-caret-right"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
<!-- FECHA -->
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">
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
        <div class="col-auto">
          <div class="card card-body">
            <form action="../Guardar/save_reclamos.php" method="POST">
              <p class="h4 mb-4 text-center">Carga de Reclamos</p>
              <div class="form-row align-items-end">
                <div class="form-group col-md-3 col-6">
                  <label for="exampleFormControlSelect1">Tecnico</label >
                  <select type="text" name="tecnico" class="form-control">
                    <option selected="0">Tecnicos...</option>                
                    <?php
                      $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?>   
                      <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                 
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col-md-3 col-6">
                  <label for="exampleFormControlSelect1">Numero de RF</label >
                  <input type="number" name="rf" maxlength="11" class="form-control" placeholder="Ingrese el numero de OT" autofocus required>
                </div> 
                <div class="form-group col-md-3 col-6">
                  <label for="exampleFormControlSelect1">Numero de OT</label >
                  <input type="number" name="ot" maxlength="11" class="form-control" placeholder="Ingrese el numero de OT" autofocus required>
                </div>            
                <div class="form-group col-md-3 col-6">
                  <label for="exampleFormControlSelect1">Telefono de contacto</label >
                  <input type="number" maxlength="20" name="telefono" class="form-control" placeholder="Ingrese el numero de telefono" autofocus required>
                </div> 
              </div>
              <div class="form-row align-items-end">
                <div class="form-group col-md-4 col-6">
                  <label for="exampleFormControlSelect1">Fecha de la instalacion</label >
                  <input type="date" name="fechains" class="form-control" required>
                </div>  
                <div class="form-group col-md-4 col-6">
                  <label for="exampleFormControlSelect1">Fecha del mail</label >
                  <input type="date" name="fechamail" class="form-control" required>
                </div>  
                <div class="form-group col-md-4 col-12">
                  <label for="exampleFormControlSelect1">Direccion</label >
                  <input type="text" name="direccion" maxlength="70" class="form-control" placeholder="Ingrese una direccion" autofocus required>
                </div>            
              </div>
              <div class="form-row align-items-end">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Problema</label >
                  <textarea type="text" name="problema" maxlength="255" class="form-control" placeholder="Ingrese una direccion" autofocus required></textarea>
                </div>      
              </div>
              <input type="submit" name="save_reclamos" class="btn btn-success btn-block" value="Guardar reclamo">
            </form>
          </div>
        </div>
      </div>

      <div class="row justify-content-center p-1">
        <div class="col-auto text-center">
          <a class="btn btn-info" href="../BaseDatos/dtrecla.php" role="button">Ver todos los reclamos</a>
        </div>
      </div>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Reclamos pendientes</p>      
          <table class="table table-responsive table-striped table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>
                <th>Acciones</th>
                <th>Tecnico</th>
                <th>RF</th>
                <th>OT</th>
                <th>Fecha instalacion</th>
                <th>Fecha del mail</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Problema</th> 
                <th>Solucion</th>                                 
              </tr>
            </thead>
            <tbody align="center">
              <?php
                $result_tasks = mysqli_query($conn, "SELECT * FROM reclamos WHERE solucion='Ninguna aun' ORDER BY fechamail desc");
                while($row = mysqli_fetch_assoc($result_tasks))
                {
              ?>
                <tr>
                  <td>
                    <a href="../Editar/edit_reclamos.php?id=<?php echo $row['id']?>">
                      <i class="fas fa-pen p-2"></i>
                    </a>
                    <a href="../Borrar/delete_reclamos.php?id=<?php echo $row['id']?>">
                      <i class="far fa-trash-alt p-2"></i>
                    </a>
                  </td>
                  <td><?php echo $row['tecnico']; ?></td>
                  <td><?php echo $row['rf']; ?></td>
                  <td><?php echo $row['ot']; ?></td>
                  <td><?php echo Fecha7($row['fechains']); ?></td>
                  <td><?php echo Fecha7($row['fechamail']); ?></td>
                  <td><?php echo $row['direccion']; ?></td>
                  <td><?php echo $row['telefono']; ?></td>
                  <td><?php echo $row['problema']; ?></td>
                  <td><?php echo $row['solucion']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>     
        </div>
      </div>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Reclamos cargados</p>
          <table class="table table-responsive table-striped table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>
                <th>Acciones</th>
                <th>Tecnico</th>
                <th>RF</th>
                <th>OT</th>
                <th>Fecha instalacion</th>
                <th>Fecha del mail</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Problema</th>
                <th>Fecha de la solucion</th>
                <th>Solucion</th>
                <th>Gasto</th>                       
              </tr>
            </thead>
            <tbody align="center">
              <?php
                $result_tasks = mysqli_query($conn, "SELECT * FROM reclamos WHERE fechamail LIKE '%$mes%' ORDER BY fechamail desc");    
                while($row = mysqli_fetch_assoc($result_tasks))
                {
              ?>
                <tr>
                  <td>
                    <a href="../Editar/edit_reclamos.php?id=<?php echo $row['id']?>">
                      <i class="fas fa-pen p-2"></i>
                    </a>
                    <a href="../Borrar/delete_reclamos.php?id=<?php echo $row['id']?>">
                      <i class="far fa-trash-alt p-2"></i>
                    </a>
                  </td>
                  <td><?php echo $row['tecnico']; ?></td>
                  <td><?php echo $row['rf']; ?></td>
                  <td><?php echo $row['ot']; ?></td>
                  <td><?php echo Fecha7($row['fechains']); ?></td>
                  <td><?php echo Fecha7($row['fechamail']); ?></td>
                  <td><?php echo $row['direccion']; ?></td>
                  <td><?php echo $row['telefono']; ?></td>
                  <td><?php echo $row['problema']; ?></td>
                  <td><?php echo $row['fechasolu']; ?></td>
                  <td><?php echo $row['solucion']; ?></td>
                  <td><?php echo $row['gasto']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>     
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
