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
?>
<?php include('../includes/header.php'); ?>
<!-- MESSAGES -->
  <?php
    if ($_SESSION['card'] == 1) { ?>
    <div class="position-fixed top-5 right-0 p-3" style="z-index: 5; right: 0rem; top: 3rem; width: 18rem">
      <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000">
        <div class="toast-header border-<?= $_SESSION['color_toast']?> ">
          <?php switch($_SESSION['color_toast'])
            {case 'success': $icono_toast = '<i class="fa-solid fa-circle-check text-success pr-2"></i>';break;
            case 'danger': $icono_toast = '<i class="fa-solid fa-circle-xmark text-danger pr-2"></i>';break;
            case 'warning': $icono_toast = '<i class="fa-solid fa-circle-exclamation text-warning pr-2"></i>';break;}
          ?>
          <strong class="mr-auto"><?php echo $icono_toast; ?> <?= $_SESSION['titulo_toast']?></strong>
          <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="toast-body p-2"><?= $_SESSION['mensaje_toast']?></div>
      </div>
    </div>
    <script>
      $(document).ready(function(){
        $('.toast').toast('show');
      });
    </script>
  <?php $_SESSION['card'] = 0; } ?>
<!-- MESSAGES -->
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
          <input type="hidden" name="link" value="../Basico/bajas.php">
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
          <input type="hidden" name="link" value="../Basico/bajas.php">
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
        <div class="col-auto text-center">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#baja_individual">+</button> 
        </div>
      </div>
      <div class="modal fade" id="baja_individual" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel" text-center>Carga de bajas</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="../Guardar/save_bajas.php" method="POST">
                <p class="h4 mb-4 text-center">Carga de Bajas</p>
                <div class="form-row align-items-end">
                  <div class="form-group col-md-3 col-6">
                    <label>Tecnico</label >
                    <select type="text" name="tecnico" class="form-control">
                      <option selected="0">Tecnicos...</option>
                      <?php
                        $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE tipo = 'Tecnico' AND activo ='SI' ORDER BY tecnico asc");
                        foreach ($ejecutar as $opciones):
                      ?>   
                        <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                      <?php endforeach ?>
                    </select>
                  </div>
                  
                  <div class="form-group col-md-3 col-6">
                    <label>Numero de OT</label >
                    <input type="number" name="ot"  maxlength="15" class="form-control" placeholder="Ingrese el numero de OT" autofocus required>
                  </div>
                  
                  <div class="form-group col-md-3 col-6">
                    <label>Direccion</label >
                    <input type="text" name="direccion" maxlength="150"  class="form-control" placeholder="Ingrese una direccion" autofocus required>
                  </div>

                  <div class="form-group col-md-3 col-6">
                    <label>Fecha</label >
                    <input type="date" name="calendario" class="form-control" required>
                  </div>
                </div>

                <div class="form-row align-items-end">
                  <div class="form-group col">
                  <label>Deposito</label >
                  <select type="text" name="zona" class="form-control">
                    <option selected>Deposito...</option>
                    <option value="CABA">CABA</option>
                    <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                    <option value="Lomas de Zamora">Lomas de Zamora</option>
                    <option value="San Nicolas">San Nicolas</option>
                  </select>
                    </div>
                  <div class="form-group col">
                    <label>Numero de interaccion</label >
                    <input type="number" name="tkl" maxlength="25" class="form-control" placeholder="Ingrese el numero de interaccion" autofocus>
                  </div>
                  <div class="form-group col">
                    <label>Motivo del cierre (Max 255)</label >
                    <input type="text" name="motivo" maxlength="255" class="form-control" placeholder="Ingrese el motivo del cierre" autofocus>
                    
                  </div>
                </div>
                <div class="form-row align-items-end">
                  <div class="form-group col">
                    <label>Observaciones (Max 255)</label >
                    <textarea type="text" maxlength="255" name="obs" class="form-control" placeholder="Ingrese el motivo del cierre" autofocus></textarea>
                  </div>
                </div>
                <input type="submit" name="save_bajas" class="btn btn-success btn-block" value="Guardar orden">
              </form>
            </div>      
          </div>
        </div>
      </div>

      <div class="row justify-content-center p-1">
        <div class="col-auto text-center">
          <a class="btn btn-info" href="../BaseDatos/dtbajas.php" role="button">Ver todas las ordenes</a>
        </div>
      </div>

      <?php
        if($zona_us == 'Todo')
        {
          $bajas_cont = mysqli_query($conn, "SELECT * FROM bajas WHERE tkl = '' AND calendario LIKE '%$mes%' ");
        }
        else
        {
          $bajas_cont = mysqli_query($conn, "SELECT * FROM bajas WHERE tkl = '' AND calendario LIKE '%$mes%' AND zona = '$zona_us'");
        }
          if (mysqli_num_rows($bajas_cont) > 0)
          {
            $cont_pend = mysqli_num_rows($bajas_cont);
      ?>
        <!-- BAJAS INCOMPLETAS-->
        <div class="row justify-content-center p-1">
          <div class="col-auto">
            <p class="h4 mb-4 text-center">Bajas incompletas de <?php echo $zona_us .' (' .$cont_pend . ' )'; ?></p>
            <table id="tkl" class="table table-responsive table-striped table-bordered table-sm">
              <thead class="thead-dark text-center">
                <tr>
                  <th>Acciones</th>
                  <th>Tecnico</th>
                  <th>OT</th>
                  <th>Numero de Interaccion</th>
                  <th>Motivo del cierre</th>              
                  <th>Direccion</th>
                  <th>Zona</th>
                  <th>Fecha</th>
                </tr>
              </thead>
              <tbody align="center">
                <?php
                  if($zona_us == 'Todo')
                    {
                      $bajas = mysqli_query($conn, "SELECT * FROM bajas  WHERE tkl = '' AND calendario LIKE '%$mes%' ORDER BY calendario desc");
                    }
                    else
                    {
                      $bajas = mysqli_query($conn, "SELECT * FROM bajas  WHERE tkl = '' AND calendario LIKE '%$mes%' AND zona = '$zona_us' ORDER BY calendario desc");
                    }
                    while($row = mysqli_fetch_assoc($bajas))
                    {
                ?>
                  <tr>
                    <td>
                      <a href="../Editar/edit_bajas.php?id=<?php echo $row['id']?>">
                        <i class="fas fa-pen p-2"></i>
                      </a>
                    <?php if($tipo_us == 'Administrador') { ?>
                      <a href="../Borrar/delete_bajas.php?id=<?php echo $row['id']?>">
                        <i class="far fa-trash-alt text-danger p-2"></i>
                      </a>
                    <?php } ?>
                    </td>
                    <td><?php echo $row['tecnico']; ?></td>
                    <td><?php echo $row['ot']; ?></td>
                    <td><?php echo $row['tkl']; ?></td>
                    <td><?php echo $row['motivo']; ?></td>                
                    <td><?php echo $row['direccion']; ?></td>
                    <td><?php echo $row['zona']; ?></td>
                    <td><?php echo Fecha7($row['calendario']); ?></td>              
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <br>
      <?php } else { ?>
        <div class="row justify-content-center p-1">
          <div class="col-auto">
            <p class="h5 mb-4 text-center">No hay bajas incompletas</p>
          </div>
        </div>
      <?php } ?>

      <!-- BAJAS -->
      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Bajas de <?php echo $zona_us; ?></p>
          <table id="bajas" class="table table-striped table-bordered table-md table-sm table-responsive">
            <thead class="thead-dark text-center">
              <tr>
                <th>Acciones</th>
                <th>Tecnico</th>
                <th>OT</th>
                <th>ID actividad</th>
                <th>NIM</th>
                <th>Numero de Interaccion</th>
                <th>Motivo del cierre</th>
                <th>Observaciones del tecnico</th>
                <th>Observaciones</th>
                <th>Direccion</th>
                <th>Localidad</th>
                <th>Zona</th>
                <th>Deposito</th>
                <th>Fecha</th>
              </tr>
            </thead>
            <tbody align="center">
              <?php
                if($zona_us == 'Todo')
                {
                  $result_tasks = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario LIKE '%$mes%' ORDER BY calendario desc");
                }
                else
                {
                  $result_tasks = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario LIKE '%$mes%' AND zona = '$zona_us' ORDER BY calendario desc");
                }
                  while($row = mysqli_fetch_assoc($result_tasks))
                  {
              ?>
                <tr>
                  <td>
                    <a href="../Editar/edit_bajas.php?id=<?php echo $row['id']?>">
                      <i class="fas fa-pen p-2"></i>
                    </a>
                  <?php if($tipo_us == 'Administrador') { ?>
                    <a href="../Borrar/delete_bajas.php?id=<?php echo $row['id']?>">
                      <i class="far fa-trash-alt text-danger p-2"></i>
                    </a>
                  <?php } ?>
                  </td>
                  <td><?php echo $row['tecnico']; ?></td>
                  <td><?php echo $row['ot']; ?></td>
                  <td><?php echo $row['id_actividad']; ?></td>
                  <td><?php echo $row['nim']; ?></td>
                  <td><?php echo $row['tkl']; ?></td>
                  <td><?php echo $row['motivo']; ?></td>
                  <td><?php echo $row['obs_tecnico']; ?></td>
                  <td><?php echo $row['obs']; ?></td>
                  <td><?php echo $row['direccion']; ?></td>
                  <td><?php echo $row['localidad']; ?></td>
                  <td><?php echo $row['zona_tarea']; ?></td>
                  <td><?php echo $row['zona']; ?></td>
                  <td><?php echo Fecha7($row['calendario']); ?></td>
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
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> 
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
      $('#bajas').DataTable( {
          "dom": '<"top"if>rt<"bottom"><"clear">',
          "scrollY":        "500px",
          "scrollX": true,
          "scrollCollapse": true,
          "paging":         false,
          "language": {
          "processing":     "Procesando...",
          "search":         "Buscar:",
          "lengthMenu":     "Mostrar _MENU_ bajas por pagina...",
          "zeroRecords":    "No se encontro ninguna baja",
          "info":           "",
          "infoEmpty":      "No hay bajas disponibles",
          "infoFiltered":   "filtrado entre _MAX_ bajas",
          "loadingRecords": "Cargando...",
          },
          "ordering": false
      } );
  } );
</script>
</body>
</html>