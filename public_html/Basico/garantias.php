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
          <input type="hidden" name="link" value="../Basico/garantias.php">
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
          <input type="hidden" name="link" value="../Basico/garantias.php">
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
            <form action="../Guardar/save_garantias.php" method="POST" data-toggle="validator">
              <p class="h4 mb-4 text-center">Carga de garantia</p>
              <div class="form-row">
                <div class="form-group col-md-4 col-6">
                  <label>Tecnico responsable</label >
                  <select type="text" name="tecnico" class="form-control" required>
                    <option selected value="" disabled>Tecnicos...</option>                
                    <?php
                      $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?>   
                      <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                    <?php endforeach;
                      $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE tipo='Tecnico' AND activo ='NO' ORDER BY tecnico asc");
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?>   
                      <option class="text-danger" value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                    
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col-md-4 col-6">
                  <label>OT</label >
                  <input type="number" name="ot" maxlength="11" class="form-control" required>
                </div>
                <div class="form-group col-md-4 col-6">
                  <label>Direccion</label >
                  <input type="text" name="direccion" maxlength="70" class="form-control" required>
                </div>
                <div class="form-group col-md-4 col-6">
                  <label>Zona</label >
                  <select type="text" name="zona" class="form-control" required>
                    <option selected value="" disabled>Zona...</option>
                    <option value="CABA">CABA</option>
                    <option value="Lomas de Zamora">Lomas de Zamora</option>
                    <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                    <option value="San Nicolas">San Nicolas</option>
                  </select>
                </div>
                <div class="form-group col-md-4 col-6">
                  <label>Instalacion</label >
                  <input type="date" name="fechaint" class="form-control" required>
                </div>        
                <div class="form-group col-md-4 col-6">
                  <label>Reparacion</label >
                  <input type="date" name="fecharep" class="form-control" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-12 col-md-6">
                  <label>Motivo de cierre</label>
                  <textarea type="text" maxlength="255" name="coment" class="form-control"></textarea>
                </div>       
                <div class="form-group col-12 col-md-6">
                  <label>Notas del tecnico</label >
                  <textarea type="text" maxlength="255" name="obs" class="form-control"></textarea>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-12">
                  <label>WFM</label >
                  <textarea type="text" name="nota_cliente" class="form-control" ></textarea>
                </div>
              </div>
              <input type="submit" name="save_garantias" class="btn btn-success btn-block" value="Guardar garantia">
            </form>
          </div>
        </div>
      </div>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <a class="btn btn-success" href="../Basico/garantiasanalisis.php" role="button">Ver analisis</a>        
        </div>
      </div>
      <br>
      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <a class="btn btn-info" href="../BaseDatos/dtgarantias.php" role="button">Ver todas las garantias</a>             
        </div>
      </div>
      <br>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Garantias cargadas</p>
          <div id="export" style="float:left"></div>
          <table id="garantias" class="table table-responsive table-striped table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>
                <th>Acciones</th>
                <th>Tecnico</th>
                <th>OT</th>
                <th>Direccion</th>
                <th>Zona</th>
                <th>Fecha instalacion</th>
                <th>Fecha reparacion</th>
                <th>Tecnico que reparo</th>
                <th>Motivo de cierre</th>
                <th>Reparado</th>
                <th>Justificado</th>
                <th>Intervencion</th>
                <th>Responsabilidad</th>
                <th>WFM</th>
                <th>Notas del tecnico</th>
                <?php if($tipo_us == 'Despacho' || $tipo_us == 'Administrador') {?>
                  <th>Supervisor</th>
                  <th>Cuando</th>
                <?php } ?>
                <th>Obs supervisor</th>
              </tr>
            </thead>
            <tbody align="center">
              <?php
                $result_tasks = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep LIKE '%$mes%' ORDER BY fecharep desc");
                while($row = mysqli_fetch_assoc($result_tasks))
                {
              ?>
                <tr>
                  <td>
                    <a href="../Editar/edit_garantias.php?id=<?php echo $row['id']?>">
                      <i class="fas fa-pen p-2"></i>
                    </a>
                    <a href="../Borrar/delete_garantias.php?id=<?php echo $row['id']?>">
                      <i class="far fa-trash-alt p-2"></i>
                    </a>
                  </td>              
                  <td><?php echo $row['tecnico']; ?></td>
                  <td><?php echo $row['ot']; ?></td>
                  <td><?php echo $row['direccion']; ?></td>
                  <td><?php echo $row['zona']; ?></td>
                  <td><?php echo Fecha7($row['fechaint']); ?></td>
                  <td><?php echo Fecha7($row['fecharep']); ?></td>
                  <td><?php echo $row['tecrep']; ?></td>
                  <td><?php echo $row['coment']; ?></td>
                  <td><?php echo $row['repa']; ?></td>
                  <td><?php echo $row['justificado']; ?></td>
                  <td><?php echo $row['intervencion']; ?></td>
                  <td><?php echo $row['responsabilidad']; ?></td>
                  <td data-toggle="tooltip" data-placement="top" title="<?php echo $row['nota_cliente']; ?>"><?php echo limitar_cadena($row['nota_cliente'], 50); ?></td>
                  <td data-toggle="tooltip" data-placement="top" title="<?php echo $row['obs']; ?>"><?php echo limitar_cadena($row['obs'], 50); ?></td>
                  <?php if($tipo_us == 'Despacho' || $tipo_us == 'Administrador') {?>
                    <td><?php echo $row['supervisor']; ?></td> 
                    <td><?php if($row['cuando'] == '0000-00-00 00:00:00'){echo '-';}else{echo Fecha12($row['cuando']);}; ?></td> 
                  <?php } ?>
                  <td  data-toggle="tooltip" data-placement="top" title="<?php echo $row['obs_supervisor']; ?>"><?php echo limitar_cadena($row['obs_supervisor'], 50); ?></td>
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
  <script>
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>
  <script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> 
  <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script> 
  <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script> 
  <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.bootstrap4.min.js"></script> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> 
  <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script> 
  <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script> 
  <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.colVis.min.js"></script> 
  <script src="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"></script> 
  <script type="text/javascript">
    $(document).ready(function() {
      var table = $('#garantias').DataTable( {
            "dom": '<"top"if>rt<"bottom"><"clear">',
            "buttons":
              [
                {
                  extend: 'excelHtml5',
                  text: '<i class="fas fa-file-excel"></i>',
                  titleAttr: 'Exportar garantias a Excel',
                  autoFilter: false,
                  sheetName: 'Argentseal Garantias',
                  title: 'Garantias',
                  className: 'btn btn-success',
                  exportOptions: { columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 10, 12, 13, 17 ]}
                },
                {
                  extend: 'pdfHtml5',
                  text: '<i class="fas fa-file-pdf"></i>',
                  pdfName: 'Argentseal garantias',
                  titleAttr: 'Exportar garantias a PDF',
                  title: 'Garantias',
                  download: 'open',
                  orientation: 'landscape',
                  className: 'btn btn-danger',
                  exportOptions: { columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 10, 12, 13, 17 ]}
                },
              ],
            "scrollY":        "700px",
            "scrollX": true,
            "scrollCollapse": true,
            "paging":         false,
            "language":
              {
                "processing":     "Procesando...",
                "search":         "Buscar:",
                "lengthMenu":     "Mostrar _MENU_ garantias por pagina...",
                "zeroRecords":    "No se encontro ninguna garantia",
                "info":           "",
                "infoEmpty":      "No hay garantias disponibles",
                "infoFiltered":   "filtrado entre _MAX_ garantias",
                "loadingRecords": "Cargando...",
              },
            "ordering": false
        } );
        table.buttons().container().appendTo($('#export'));
    } );
  </script>
</body>
</html>

