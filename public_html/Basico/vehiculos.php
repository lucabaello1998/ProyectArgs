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
  if($tipo_us == "Visor") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
  }
?>
<?php include('../includes/header.php'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<div class="container-fluid p-4">
  <div class="row p-2">
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
            <form action="../Guardar/save_vehiculo.php" method="POST" enctype="multipart/form-data"/>
              <p class="h4 mb-4 text-center">Carga de Vehiculos</p>
              <div class="form-row">
                <div class="form-group col-md-4 col-12">
                  <label for="exampleFormControlSelect1">Patente</label >
                  <input type="text" name="patente" maxlength="11" class="form-control" placeholder="Ingrese la patente" autofocus required>
                </div>            
                <div class="form-group col-md-4 col-6">
                  <label for="exampleFormControlSelect1">Vehiculo</label >
                  <input type="text" name="auto" maxlength="200" class="form-control" placeholder="Ingrese el vehiculo" autofocus>
                </div>
                <div class="form-group col-md-4 col-6">
                  <label for="exampleFormControlSelect1">Color</label >
                  <input type="text" name="color" maxlength="120" class="form-control" placeholder="Ingrese el color" autofocus>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-4 col-6">
                  <label for="exampleFormControlSelect1">VTV</label >
                  <input type="text" id="vtv" name="vtv" readonly="" class="form-control" required>
                </div>    
                <div class="form-group col-md-4 col-6">
                  <label for="exampleFormControlSelect1">Seguro</label >
                  <input type="text" id="seguro" name="seguro" readonly="" class="form-control" required>
                </div> 
                <div class="form-group col-md-4 col-12">
                  <label for="exampleFormControlFile1">Subir PDF</label>
                  <input type="file" accept="application/pdf" class="form-control-file" name="archivo" id="archivo">
                </div>
              </div>
              <input type="submit" name="save_auto" class="btn btn-success btn-block" value="Guardar vehiculo">
            </form>
          </div>
        </div>
      </div>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Vehiculos cargados</p>
          <table class="table table-responsive table-striped table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>
                <th>Acciones</th>
                <th>Patente</th>
                <th>Vehiculo</th>
                <th>Color</th>              
                <th>Vencimiento VTV</th>                            
                <th>Vencimiento Seguro</th>              
                <th>Descargar seguro</th>             
              </tr>
            </thead>
            <tbody align="center">
              <?php
                $result_tasks = mysqli_query($conn, "SELECT * FROM vehiculos ORDER BY patente asc");
                while($row = mysqli_fetch_assoc($result_tasks)) 
                { 
                  $fecha_ultima = "20" .date ('y-m-d', strtotime('-0 days'));
                  $fecha_media = "20" .date ('y-m-d', strtotime('+15 days'));
                  //////VTV//////
                  $fecha_ven_vtv = $row['vtv'];                      

                    if ($fecha_ven_vtv <= $fecha_media)
                      {
                        if($fecha_ven_vtv > $fecha_ultima)
                        {
                        ////Proximo a vencer//////
                        $col = "text-warning";         
                        }
                        else
                        {
                        ///Vencida///
                        $col = "text-danger";
                        }
                      }
                      else
                      {
                        ///Vigente///
                        $col = "text-info";
                      }
                      ////SEGURO/////
                      $fecha_ven_seg = $row['seguro'];                      

                    if ($fecha_ven_seg <= $fecha_media)
                      {
                        if($fecha_ven_seg > $fecha_ultima)
                        {                      
                        ////Proximo a vencer//////
                        $colseg = "text-warning";         
                        }
                        else
                        {   
                        ///Vencida///                   
                        $colseg = "text-danger";
                        }
                      }
                      else
                      {   
                      ///Vigente///                   
                      $colseg = "text-info";
                      }
              ?>
                <tr>
                  <td>
                    <a href="../Editar/edit_vehiculos.php?id=<?php echo $row['id']?>">
                      <i class="fas fa-pen p-2"></i>
                    </a>
                    <a href="../Borrar/delete_vehiculos.php?id=<?php echo $row['id']?>">
                      <i class="far fa-trash-alt  p-2"></i>
                    </a>
                  </td>
                  <td><?php echo $row['patente']; ?></td>
                  <td><?php echo $row['auto']; ?></td>
                  <td><?php echo $row['color']; ?></td>                
                  <td class="<?php echo $col; ?>"><?php echo $row['vtv']; ?></td>                                
                  <td class="<?php echo $colseg; ?>"><?php echo $row['seguro']; ?></td>                               
                  <td><a href="../Archivos/vehiculos/<?php echo $row['archivo']; ?>" download="<?php echo $row['archivo']; ?>"><i class="fas fa-file-download"></i><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> </a></td>                         
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
<!-- Datatable -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- Filtro por columnas -->
<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script> 
<!-- Calendario 1-->
<script src="../jquery-3.3.1.min.js"></script>
<script src="../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript">
  $(function() {
    $("#vtv").datepicker({ dateFormat: "yy-mm-dd"});
    $( "#anim" ).on( "change", function() {
      $( "#vtv" ).datepicker( "option", "showAnim", $( this ).val() );
    });
  } );
</script>
<!-- Calendario 2-->
<script src="../jquery-3.3.1.min.js"></script>
<script src="../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript">
  $(function() {
    $("#seguro").datepicker({ dateFormat: "yy-mm-dd"});
    $( "#anim" ).on( "change", function() {
      $( "#seguro" ).datepicker( "option", "showAnim", $( this ).val() );
    });
  } );
</script>
</body>
</html>