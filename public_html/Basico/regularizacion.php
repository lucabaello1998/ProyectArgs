<?php
  include("../db.php");
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
  if($tipo_us == "Deposito") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
  }
  $nombre = $_SESSION['nombre'];
  $apellido = $_SESSION['apellido'];
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
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">

    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <div class="card card-body">
            <form action="../Guardar/save_regularizacion.php" method="POST" enctype="multipart/form-data" name="frmExcelImport" id="frmExcelImport">
              <p class="h4 mb-4 text-center">Cargar excel de regularizacion</p>
                <br>
                <p class="text-left">Cargue los equipos sin encabezados, en el siguiente orden, con la mayor cantidad de informacion posible; como en el ejemplo</p>

              <div class="row justify-content-center p-1">
                <div class="col-auto">
                  <table class="table table-responsive table-striped table-bordered table-sm">
                    <thead class="thead-dark text-center">
                      <tr>
                        <th>SN</th>
                        <th>OT</th>
                      </tr>
                    </thead>
                    <tbody align="center">
                      <tr>
                        <td>4857544357854CAA</td>
                        <td>14243542</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <br>
              <div class="form-row align-items-start justify-content-center">
                <input type="file" name="file" id="file" accept=".xls">
              </div>
              <br>
              <div class="row justify-content-center">
                <input type="submit" id="submit" name="regula" value="Ingresar archivo" class="btn btn-success btn-block"/>              
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Equipos sin OT</p>
          <div id="export" style="float:left"></div>
          <table id="seriado" class="table table-responsive table-striped table-bordered" style="width:100%">
            <thead class="thead-dark text-center">
              <tr>
                <th>Deposito</th>
                <th>Fecha</th>
                <th>Num pedido</th>
                <th>SAP</th>
                <th>Material</th>
                <th>Num serie</th>
                <th>Cantidad</th>
              </tr>
            </thead>
            <tbody align="center">
              <?php
                $rs = mysqli_query($conn, "SELECT * FROM ingresomaterial WHERE seriado <> '' AND ot = '' ORDER BY seriado asc");
                while($row = mysqli_fetch_assoc($rs))
                {
              ?>
                <tr>
                  <td><?php echo $row['deposito']; ?></td>
                  <td><?php echo Fecha7($row['fecha']); ?></td>
                  <td><?php echo $row['num_pedido']; ?></td>
                  <td><?php echo $row['sap']; ?></td>
                  <td><?php echo $row['material']; ?></td>
                  <td><?php echo $row['seriado']; ?></td>
                  <td><?php echo $row['cantidad']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Equipos con OT</p>
          <div id="exportar" style="float:left"></div>
          <table id="con_ot" class="table table-responsive table-striped table-bordered" style="width:100%">
            <thead class="thead-dark text-center">
              <tr>
                <th>Deposito</th>
                <th>Fecha</th>
                <th>Num pedido</th>
                <th>SAP</th>
                <th>Material</th>
                <th>Num serie</th>
                <th>Cantidad</th>
                <th>OT</th>
              </tr>
            </thead>
            <tbody align="center">
              <?php
                $rr = mysqli_query($conn, "SELECT * FROM ingresomaterial WHERE seriado <> '' AND ot != '' ORDER BY seriado asc");
                while($row = mysqli_fetch_assoc($rr))
                {
              ?>
                <tr>
                  <td><?php echo $row['deposito']; ?></td>
                  <td><?php echo Fecha7($row['fecha']); ?></td>
                  <td><?php echo $row['num_pedido']; ?></td>
                  <td><?php echo $row['sap']; ?></td>
                  <td><?php echo $row['material']; ?></td>
                  <td><?php echo $row['seriado']; ?></td>
                  <td><?php echo $row['cantidad']; ?></td>
                  <td><?php echo $row['ot']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div> -->

    </div>

  </div>
</div>
<!-- PIE DE PAGINA -->

<!-- jQuery -->
<script src="./excel/assets/jquery-1.12.4-jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- then Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
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
      var table = $('#seriado').DataTable( {
            "dom": '<"top"if>rt<"bottom"><"clear">',
            "buttons":
              [
                {
                  extend: 'excelHtml5',
                  text: '<i class="fas fa-file-excel"></i>',
                  titleAttr: 'Exportar equipos a Excel',
                  autoFilter: false,
                  sheetName: 'Argentseal equipos',
                  title: 'Equipos sin ot',
                  className: 'btn btn-success',
                  exportOptions: { columns: [ 5 ]}
                },
                {
                  extend: 'pdfHtml5',
                  text: '<i class="fas fa-file-pdf"></i>',
                  pdfName: 'Argentseal equipos',
                  titleAttr: 'Exportar equipos a PDF',
                  title: 'Equipos sin OT',
                  download: 'open',
                  orientation: 'landscape',
                  className: 'btn btn-danger',
                  exportOptions: { columns: [ 1, 2, 3, 4, 5, 6, 7 ]}
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
                "lengthMenu":     "Mostrar _MENU_ equipos por pagina...",
                "zeroRecords":    "No se encontro ninguna equipo",
                "info":           "",
                "infoEmpty":      "No hay equipos disponibles",
                "infoFiltered":   "filtrado entre _MAX_ equipos",
                "loadingRecords": "Cargando...",
              },
            "ordering": false
        } );
        table.buttons().container().appendTo($('#export'));
    } );
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
      var table = $('#con_ot').DataTable( {
            "dom": '<"top"if>rt<"bottom"><"clear">',
            "buttons":
              [
                {
                  extend: 'excelHtml5',
                  text: '<i class="fas fa-file-excel"></i>',
                  titleAttr: 'Exportar equipos a Excel',
                  autoFilter: false,
                  sheetName: 'Argentseal equipos',
                  title: 'Equipos con OT',
                  className: 'btn btn-success',
                  exportOptions: { columns: [ 5, 7]}
                },
                {
                  extend: 'pdfHtml5',
                  text: '<i class="fas fa-file-pdf"></i>',
                  pdfName: 'Argentseal equipos',
                  titleAttr: 'Exportar equipos a PDF',
                  title: 'Equipos con OT',
                  download: 'open',
                  orientation: 'landscape',
                  className: 'btn btn-danger',
                  exportOptions: { columns: [ 1, 2, 3, 4, 5, 6, 7, 8 ]}
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
                "lengthMenu":     "Mostrar _MENU_ equipos por pagina...",
                "zeroRecords":    "No se encontro ninguna equipo",
                "info":           "",
                "infoEmpty":      "No hay equipos disponibles",
                "infoFiltered":   "filtrado entre _MAX_ equipos",
                "loadingRecords": "Cargando...",
              },
            "ordering": false
        } );
        table.buttons().container().appendTo($('#exportar'));
    } );
  </script>
</body>
</html>