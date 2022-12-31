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
<div class="container-fluid p-4">
  <div class="row p-2">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Materiales y codigos SAP</p>
        </div>
      </div>

      <div class="row justify-content-center p-1">
        <div class="col-auto text-center">
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ingresotec">+</button> 
        </div>
      </div>
    <!-- Modal 1 -->
      <div class="modal fade" id="ingresotec" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel" text-center>Carga de material</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="card card-body">
              <form action="../Guardar/sap.php" method="POST">
                <div class="form-row">
                  <div class="form-group col-6">
                    <label>SAP</label >
                    <input type="number" name="sap" class="form-control" autofocus required>
                  </div>
                  <div class="form-group col-6">
                    <label>Nombre del material</label >
                    <input type="text" name="material" class="form-control" required>
                  </div>          
                </div>
                <input type="submit" name="save_sap" class="btn btn-success btn-block" value="Guardar material">
              </form>
            </div>      
          </div>
        </div>
      </div>

      <style>
        .sap{
          max-width: 9rem !important;
        }
        .material{
          max-width: 20rem !important;
        }
      </style>
      <div class="row justify-content-center p-1">
        <div class="col-auto">   
          <table id="materiales" class="table table-responsive table-striped table-hover table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>
                <th class="sap">SAP</th>
                <th class="material">Material</th>
              </tr>
            </thead>
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
<!-- Datatable -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script> 
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> 
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script> 
<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script> 
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.bootstrap4.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"></script> 
<script>
  $(document).ready(function()
    {
    var table = $("#materiales").DataTable(
    { 
      "lengthChange": true,
      "dom": 'lft<t>ip',
      "responsive": true,
      "language":
      {
        "processing":     "Procesando...",
        "search":         "Buscar:",
        "lengthMenu":     "Mostrar _MENU_ materiales por pagina...",
        "zeroRecords":    "No se encontro ningun material",
        "info":           "Mostrando _START_ a _END_ de un total de _TOTAL_ materiales",
        "infoEmpty":      "No hay datos disponibles",
        "infoFiltered":   "(filtrado de _MAX_ materiales)",
        "loadingRecords": "Cargando...",
        "paginate": {
          "first":      "Primer",
          "previous":   "Anterior",
          "next":       "Siguiente",
          "last":       "Ultimo"
        },
      },
      "processing": true,
      "serverSide": true,              
      "sAjaxSource": "../ServerSide/serversideSap.php",             
      "order": [[ 1, "desc" ]],
    });     
  });
</script>
</body>
</html>