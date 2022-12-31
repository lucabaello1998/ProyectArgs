<?php 
  include("../db.php");
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
  if($tipo == "Supervisor") { $usu = 1; }
  if($tipo == "Deposito") { $usu = 1; }
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
          <input type="hidden" name="link" value="../Basico/ingresomaterial.php">
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
          <input type="hidden" name="link" value="../Basico/ingresomaterial.php">
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
          <a class="btn btn-outline-info btn-sm" href="sap.php" role="button">Ver codigos SAP</a>
        </div>
      </div>
      <div class="row justify-content-center p-1">
        <div class="col-auto">
            <a class="btn btn-outline-warning btn-sm" href="../Basico/precarga.php" role="button">Precarga</a>
        </div>
      </div>
      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#seriados">Equipos seriados</button>
        </div>
      </div>
      <!-- SERIADO -->
        <div class="modal fade" id="seriados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Equipos seriados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <div class="col-auto">
                    <table id="seriado" class="table table-responsive table-striped table-bordered" style="width:100%">
                      <thead class="thead-dark text-center">
                        <tr>
                          <?php if($tipo_us == 'Despacho' || $tipo_us == 'Administrador') {?>
                            <th>Quien</th>
                            <th>Cuando</th>
                          <?php } ?>
                          <th>Deposito</th>
                          <th>Ingreso</th>
                          <th>Num pedido</th>
                          <th>Material</th>
                          <th>Num serie</th>
                          <th>OT</th>
                          <th>Cantidad</th>
                        </tr>
                      </thead>
                      <tbody align="center">
                        <?php
                          $rs = mysqli_query($conn, "SELECT * FROM ingresomaterial WHERE seriado <> '' ORDER BY seriado asc");
                          while($row = mysqli_fetch_assoc($rs))
                          {
                        ?>
                          <tr>
                            <?php if($tipo_us == 'Despacho' || $tipo_us == 'Administrador') {?>
                              <td><?php echo $row['usuario']; ?></td>
                              <td><?php echo Fecha12($row['fecha_usuario']); ?></td>
                            <?php } ?>
                            <td><?php echo $row['deposito']; ?></td>
                            <td><?php echo Fecha7($row['fecha']); ?></td>
                            <td><?php echo $row['num_pedido']; ?></td>
                            <td><?php echo $row['material']; ?></td>
                            <td><?php echo $row['seriado']; ?></td>
                            <td><?php echo $row['ot']; ?></td>
                            <td><?php echo $row['cantidad']; ?></td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
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

      <!-- MODAL EXCEL -->
        <div class="modal fade" id="excel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" text-center>Ingreso de materiales con excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="../Guardar/save_ingresomaterial.php" method="POST" enctype="multipart/form-data" name="frmExcelImport" id="frmExcelImport">
                  <div class="form-row">
                    <div class="form-group col-12 col-md-4">
                      <label for="ingresoMaterial">Fecha</label >
                      <input type="date" name="fecha" class="form-control" required>
                    </div>
                    <div class="form-group col-6 col-md-4">
                      <label for="ingresoMaterial">Proveedor</label>
                      <input type="text" maxlength="255" name="proveedor" class="form-control" placeholder="Ingrese el proveedor" value="Claro" required>
                    </div>
                    <div class="form-group col-6 col-md-4">
                      <label for="ingresoMaterial">Deposito</label >
                      <select type="text" name="deposito" class="form-control" required>
                        <option selected value="" disabled>Deposito...</option>
                        <option value="Lomas de Zamora">Lomas de Zamora</option>
                        <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                        <option value="La Tablada">La Tablada</option>
                        <option value="San Nicolas">San Nicolas</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-12">
                      <label for="ingresoMaterial">Observaciones</label >
                      <textarea type="text" name="obs" maxlength="255" class="form-control" placeholder="Ingrese una observacion"></textarea>
                    </div>          
                  </div>
                  <div class="form-row">
                    <div class="form-group col-12">
                      <div class="form-row align-items-start justify-content-center"> 
                        <label>Cargar excel del pedido </label>
                      </div>
                      <div class="form-row align-items-start justify-content-center">
                        <input type="file" name="file" id="file" accept=".xls,.xlsx" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-row p-2">
                    <input type="submit" id="submit" name="import" value="Ingresar pedido" class="btn btn-success btn-block"/>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      <!-- MODAL EXCEL -->
      <!-- MODAL UNICO -->
        <div class="modal fade" id="individual" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" text-center>Ingreso de materiale individual</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="../Guardar/save_ingresomaterial_individual.php" method="POST">
                  <div class="form-row">
                    <div class="form-group col-12 col-md-4">
                      <label for="ingresoMaterial">Fecha</label >
                      <input type="date" name="fecha" class="form-control" required>
                    </div>
                    <div class="form-group col-6 col-md-4">
                      <label for="ingresoMaterial">Proveedor</label >
                      <select type="text" name="proveedor" class="form-control" required>
                        <option selected value="" disabled>Proveedor...</option>
                        <option value="Claro">Claro</option>
                        <option value="Argentseal">Argentseal</option>
                      </select>
                    </div>
                    <div class="form-group col-6 col-md-4">
                      <label for="ingresoMaterial">Deposito</label >
                      <select type="text" name="deposito" class="form-control" required>
                        <option selected value="" disabled>Deposito...</option>
                        <option value="Lomas de Zamora">Lomas de Zamora</option>
                        <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                        <option value="La Tablada">La Tablada</option>
                        <option value="San Nicolas">San Nicolas</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-6 col-md-4">
                      <label for="ingresoMaterial">Sap</label >
                      <input type="number" name="sap" class="form-control">
                    </div>
                    <div class="form-group col-6 col-md-4">
                      <label for="ingresoMaterial">Material</label >
                      <input type="text" name="material" class="form-control" required>
                    </div>
                    <div class="form-group col-6 col-md-4">
                      <label for="ingresoMaterial">Cantidad</label >
                      <input type="number" name="cantidad" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-12">
                      <label for="ingresoMaterial">Observaciones</label >
                      <textarea type="text" name="obs" maxlength="255" class="form-control" placeholder="Ingrese una observacion"></textarea>
                    </div>          
                  </div>
                  <div class="form-row p-2">
                    <input type="submit" id="submit" name="individual" value="Ingresar material" class="btn btn-success btn-block"/>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      <!-- MODAL UNICO -->

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Ultimos pedidos</p>
          <table id="materiales" class="table table-responsive table-striped table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>
                <th>Acciones</th>
                <th>Usuario</th>
                <th>Fecha de carga</th>
                <th>Fecha pedido</th>
                <th>Deposito</th>
                <th>Proveedor</th>
                <th>Numero pedido</th>
                <th>Operatoria</th>
                <th>SAP</th>
                <th>Material</th>
                <th>SN</th>
                <th>Cantidad</th>
                <th>Observaciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $result_tasks = mysqli_query($conn, "SELECT * FROM ingresomaterial WHERE fecha LIKE '%$mes%' AND seriado = '' ORDER BY fecha desc");
                while($row = mysqli_fetch_assoc($result_tasks))
                {
              ?>
                <tr>
                  <td align="center">
                    <a href="../Editar/edit_ingresomaterial.php?id=<?php echo $row['id']?>">
                      <i class="fas fa-pen p-2"></i>
                    </a>
                    <a href="../Borrar/delete_ingresomaterial.php?id=<?php echo $row['id']?>">
                      <i class="far fa-trash-alt  p-2"></i>
                    </a>
                  </td>
                  <td><?php echo $row['usuario']; ?></td>
                  <td><?php echo $row['fecha_usuario']; ?></td>
                  <td><?php echo $row['fecha']; ?></td>
                  <td><?php echo $row['deposito']; ?></td>
                  <td><?php echo $row['proveedor']; ?></td>
                  <td><?php echo $row['num_pedido']; ?></td>
                  <td><?php echo $row['operatoria']; ?></td>
                  <td><?php echo $row['sap']; ?></td>
                  <td><?php echo $row['material']; ?></td>
                  <td><?php echo $row['seriado']; ?></td>
                  <td><?php echo $row['cantidad']; ?></td>
                  <td><?php echo $row['obs']; ?></td>                           
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
<script src="./excel/assets/jquery-1.12.4-jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- then Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> 
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
			$('#materiales').DataTable( {
					"dom": '<"top"lif>rt<"bottom"p><"clear">',
					"language": {
										"processing":     "Procesando...",
										"search":         "Buscar:",
										"lengthMenu":     "Mostrar _MENU_ materiales por pagina...",
										"zeroRecords":    "No se encontro ningun material",
										"info":           "Mostrando _START_ a _END_ de un total de _TOTAL_ materiales",
										"infoEmpty":      "No hay materiales disponibles",
										"infoFiltered":   "(filtrado de _MAX_ materiales)",
										"loadingRecords": "Cargando...",
					},
					"ordering": false,
			} );
	} );
</script>
<script type="text/javascript">
	$(document).ready(function() {
			$('#seriado').DataTable( {
					"dom": '<"top"lif>rt<"bottom"p><"clear">',
					"language": {
										"processing":     "Procesando...",
										"search":         "Buscar:",
										"lengthMenu":     "Mostrar _MENU_ materiales por pagina...",
										"zeroRecords":    "No se encontro ningun material",
										"info":           "Mostrando _START_ a _END_ de un total de _TOTAL_ materiales",
										"infoEmpty":      "No hay materiales disponibles",
										"infoFiltered":   "(filtrado de _MAX_ materiales)",
										"loadingRecords": "Cargando...",
					},
					"ordering": false,
			} );
	} );
</script>
</body>
</html>