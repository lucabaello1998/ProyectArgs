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
        <form action="../Guardar/save_reincidencias.php" method="POST">
          <input type="hidden" name="ultima_fecha" value="<?php echo $mes; ?>">
          <button type="submit" name="menos" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Mes anterior">
            <i class="fa-solid fa-caret-left"></i>
          </button>
        </form>
      </div>
      <div class="col-auto align-self-center text-center text-white">
        <span class="h4"><?php echo $mes_nom; ?></span>
      </div>
      <div class="col-auto align-self-center p-0">
        <form action="../Guardar/save_reincidencias.php" method="POST">
          <input type="hidden" name="ultima_fecha" value="<?php echo $mes; ?>">
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
      <div class="row justify-content-center p-1 m-0">
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
      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <div class="card card-body">
            <form action="../Guardar/save_reincidencias.php" method="POST" data-toggle="validator">
              <p class="h4 mb-4 text-center">Carga de reincidencias</p>
              <div class="form-row">
              <div class="form-group col-3">
                <label>Tecnico responsable</label >

                <select type="text" name="tecnico" class="form-control">                
                  <option selected="0">Tecnicos...</option>                
                  <?php
                    $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                  ?>
                  <?php foreach ($ejecutar as $opciones): ?>   
                    <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                  <?php endforeach ?>

                                
                <?php
                  $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE tipo='Tecnico' AND activo ='NO' ORDER BY tecnico asc");
                ?>
                <?php foreach ($ejecutar as $opciones): ?>   
                  <option class="text-danger" value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                    
                <?php endforeach ?>
                </select>

              </div>  

              <div class="form-group col-6">
                <label>Direccion</label >
                <input type="text" name="direccion" maxlength="70" class="form-control" autofocus required>
              </div>
              <div class="form-group col-3">
                <label>Zona</label >
                <select type="text" name="zona" class="form-control">
                  <option selected>Zona...</option>
                  <option value="CABA">CABA</option>
                  <option value="Lomas de Zamora">Lomas de Zamora</option>
                  <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                  <option value="San Nicolas">San Nicolas</option>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col">
                <label>Fecha primera reparacion</label >
                <input type="date" name="fechaint" class="form-control" required>
              </div>
              <div class="form-group col-sm">
                <label>1° OT</label >
                <input type="number" name="ot" maxlength="11" class="form-control" required>
              </div>
              <div class="form-group col">
                <label>Ultima Fecha</label >
                <input type="date" name="fecharep" class="form-control" required>
              </div>
              <div class="form-group col-sm">
                <label>Ultima OT</label >
                <input type="number" name="otdos" maxlength="11" class="form-control" required>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col">
                <label>Abonado</label>
                <input type="text" maxlength="255" name="abonado" class="form-control">
              </div>
              <div class="form-group col">
                <label>NIM</label>
                <input type="number" name="nim" class="form-control">
              </div>
              <div class="form-group col">
                <label>Responsabilidad</label>
                <div class="col-sm-10">
                  <select type="text" name="responsabilidad" class="form-control">
                  <option value="" selected>Responsabilidad</option>
                  <option value="Claro">Claro</option>
                  <option value="Cliente">Cliente</option>
                  <option value="Tecnico">Tecnico</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col">
                <label>Primer motivo de cierre</label>
                <input type="text" maxlength="255" name="primercierre" class="form-control">
              </div>
              <div class="form-group col">
                <label>Motivo de asignacion</label>
                <input type="text" maxlength="255" name="motivo" class="form-control">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col">
                <label>Notas del tecnico</label >
                <textarea type="text" maxlength="255" name="primeranota" class="form-control"></textarea>
              </div>     
            </div>

              <input type="submit" name="save_reincidencias" class="btn btn-success btn-block" value="Guardar reincidencia">
            </form>
          </div>
        </div>
      </div>

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">       
          <a class="btn btn-info" href="../Basico/reincidenciasanalisis.php" role="button">Ver analisis</a>        
        </div>
      </div>
      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <a class="btn btn-info" href="../BaseDatos/dtreincidencia.php" role="button">Ver todas las reincidencias</a>
        </div>
      </div>

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Reincidencias cargadas</p>
          <table id="reincidencias" class="table table-responsive table-striped table-bordered table-sm" style="max-height: 35rem;">
            <thead class="thead-dark text-center">
              <tr>
                <th class="col-auto">Acciones</th>
                <th class="col-auto">Tecnico</th>
                <th class="col-auto">Direccion</th>
                <th class="col-auto">Zona</th>
                <th class="col-auto">Fecha 1° reparacion</th>
                <th class="col-auto">OT</th>
                <th class="col-auto">Ultima Fecha</th>
                <th class="col-auto">Ultima OT</th>
                <th class="col-auto">Abonado</th>
                <th class="col-auto">1° motivo de cierre</th>
                <th class="col-auto">Motivo de asignacion</th>
                <th class="col-auto">Notas del tecnico</th>
                <th class="col-auto">Tecnico que reparo</th>
                <th class="col-auto">Reparado</th>
                <th class="col-auto">Justificados</th>
                <th class="col-auto">Intervencion</th>
                <th class="col-auto">Responsabilidad</th>
                <th class="col-auto">Cierre</th>
                <th class="col-auto">Observaciones</th>
                <th class="col-auto">Obs supervisor</th>
              </tr>
            </thead>
            <tbody align="center">
              <?php
              $query = "SELECT * FROM reincidencias WHERE fecharep LIKE '%$mes%' ORDER BY fecharep desc";
              $result_tasks = mysqli_query($conn, $query);    

              while($row = mysqli_fetch_assoc($result_tasks)) { ?>
                <tr>
                  <td>
                    <a href="../Editar/edit_reincidencias.php?id=<?php echo $row['id']?>">
                      <i class="fas fa-pen p-2"></i>
                    </a>
                    <a href="../Borrar/delete_reincidencias.php?id=<?php echo $row['id']?>" class= "text-danger">
                      <i class="far fa-trash-alt p-2"></i>
                    </a>
                  </td>              
                  <td><?php echo $row['tecnico']; ?></td>
                  <td><?php echo $row['direccion']; ?></td>
                  <td><?php echo $row['zona']; ?></td>
                  <td><?php echo Fecha7($row['fechaint']); ?></td>
                  <td><?php echo $row['ot']; ?></td>
                  <td><?php echo Fecha7($row['fecharep']); ?></td>
                  <td><?php echo $row['otdos']; ?></td>
                  <td><?php echo $row['abonado']; ?></td>
                  <td><?php echo $row['primercierre']; ?></td>
                  <td><?php echo $row['motivo']; ?></td>
                  <td><?php echo $row['primeranota']; ?></td>
                  <td><?php echo $row['tecrep']; ?></td>
                  <td><?php echo $row['repa']; ?></td>
                  <td><?php echo $row['justificado']; ?></td>
                  <td><?php echo $row['intervencion']; ?></td>
                  <td><?php echo $row['responsabilidad']; ?></td>
                  <td><?php echo $row['coment']; ?></td>
                  <td><?php echo $row['obs']; ?></td>              
                  <td><?php echo $row['obs_supervisor']; ?></td> 
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
      <br>

      
      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">NIM duplicados</p>
          <table id="reinci" class="table table-responsive table-striped table-bordered table-sm table-hover">
            <thead class="thead-dark text-center">
              <tr>
                <th>Tecnico</th>
                <th>Fecha</th>
                <th>NIM</th>
                <th>OT</th>
                <th>Codigo</th>
                <th>TV</th>
                <th>Actividad</th>
                <th>Estado</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Cierre</th>
                <th>Observacion</th>
                <th>Revisita</th>
              </tr>
            </thead>
            <tbody align="center">
              <?php
                $a = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '$mes%' AND nim <> '' AND actividad LIKE 'Visita tecnica%' GROUP BY nim HAVING COUNT(nim) > 1 ORDER BY nim ");
                while($ro = mysqli_fetch_assoc($a))
                {
                $dupli_nim = $ro['nim'];
              ?>
                <?php
                  $b = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '$mes%' AND nim = '$dupli_nim' ORDER BY id ");
                  while($row = mysqli_fetch_assoc($b))
                  {
                ?>
                  <tr>
                    <td><?php echo $row['tecnico']; ?></td>
                    <td><?php echo Fecha7($row['fecha']); ?></td>
                    <td><?php echo $row['nim']; ?></td>
                    <td><?php echo $row['ot']; ?></td>             
                    <td><?php echo $row['codigo']; ?></td>
                    <td><?php echo $row['cantidad_tv']; ?></td>
                    <td><?php echo utf8_encode($row['actividad']); ?></td>
                    <?php
                      if(utf8_encode($row['actividad']) == 'Depósito' || utf8_encode($row['actividad']) == 'Almuerzo')
                      {
                        $color_badge = 'badge-info';
                      }
                      else
                      {
                        if($row['estado'] == 'no realizado')
                        {
                          $color_badge = 'badge-danger';
                        }
                        if($row['estado'] == 'finalizada')
                        {
                          $color_badge = 'badge-success';
                        } 
                      }
                    ?>
                    <td><span class="badge badge-pill <?php echo $color_badge; ?>"><?php echo $row['estado'] ?></span></td>
                    <td><?php echo substr($row['inicio'], 0, -3); ?></td>
                    <td><?php echo substr($row['fin'], 0, -3); ?></td>
                    <td><?php if($row['estado'] == 'finalizada') {echo utf8_encode($row['razon_completada']);} else {echo utf8_encode($row['razon_no_completada']);}; ?></td>
                    <td><?php echo utf8_encode($row['nota_cierre']); ?></td>
                    <td><?php echo $row['revisita']; ?></td>       
                  </tr>
                <?php } ?>
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
        $('#reinci').DataTable( {
            "dom": '<"top"if>rt<"bottom"><"clear">',
            "scrollY":        "500px",
            "scrollX": true,
            "scrollCollapse": true,
            "paging":         false,
            "language": {
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "lengthMenu":     "Mostrar _MENU_ reincidencias por pagina...",
            "zeroRecords":    "No se encontro ninguna reincidencia",
            "info":           "",
            "infoEmpty":      "No hay reincidencias disponibles",
            "infoFiltered":   "filtrado entre _MAX_ reincidencias",
            "loadingRecords": "Cargando...",
            },
            "ordering": false
        } );
    } );
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
        $('#reincidencias').DataTable( {
            "dom": '<"top"if>rt<"bottom"><"clear">',
            "scrollY":        "500px",
            "scrollX": true,
            "scrollCollapse": true,
            "paging":         false,
            "language": {
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "lengthMenu":     "Mostrar _MENU_ reincidencias por pagina...",
            "zeroRecords":    "No se encontro ninguna reincidencia",
            "info":           "",
            "infoEmpty":      "No hay reincidencias disponibles",
            "infoFiltered":   "filtrado entre _MAX_ reincidencias",
            "loadingRecords": "Cargando...",
            },
            "ordering": false
        } );
    } );
  </script>
</body>
</html>

