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
          <input type="hidden" name="link" value="../Basico/altas.php">
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
          <input type="hidden" name="link" value="../Basico/altas.php">
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
          <form action="../Guardar/save_altas.php" method="POST">
            <p class="h4 mb-4 text-center">Carga de Altas</p>
            <div class="form-row">
              <div class="form-group col-md-4 col-6">
                <label>Tecnico</label>
                <select type="text" name="tecnico" class="form-control" required>
                  <option selected value="" disabled>Tecnicos...</option>                
                  <?php
                    $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE tipo = 'Tecnico' AND activo ='SI' ORDER BY tecnico asc");
                    foreach ($ejecutar as $opciones):
                  ?>   
                    <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group col-md-4 col-6">
                <label>Numero de OT</label>
                <input type="number" name="ot" maxlength="15" class="form-control" placeholder="Ingrese el numero de OT" required>
              </div>
              <div class="form-group col-md-4 col-12">
                <label>Direccion</label>
                <input type="text" name="direccion" maxlength="200" class="form-control" placeholder="Ingrese una direccion" required>
              </div>
              <div class="form-group col-md-6 col-6">
                <label>Zona</label>
                <select type="text" name="zona" class="form-control" required>
                  <option selected value="" disabled>Zona...</option>
                  <option value="CABA">CABA</option>
                  <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                  <option value="Lomas de Zamora">Lomas de Zamora</option>
                  <option value="San Nicolas">San Nicolas</option>
                </select>
              </div>
              <div class="form-group col-md-6 col-6">
                <label for="fecha">Fecha</label>
                <input type="date" name="calendario" id="fecha" class="form-control" required>
              </div>
            </div>
            <div class="form-row border border-success p-1 mb-2">
              <div class="col-12 align-self-center">
                <span class="text-center">ONT</span>
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="mac_ont" maxlength="50" class="form-control" placeholder="MAC ONT">
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="sn_ont" maxlength="50" class="form-control" placeholder="SN ONT">
              </div>
            </div>

            <div class="form-row border border-info p-1 mb-2">
              <div class="col-12 align-self-center">
                <span class="text-center">STB 1</span>
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="mac_uno_stb" maxlength="50" class="form-control" placeholder="MAC STB 1">
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="sn_uno_stb" maxlength="50" class="form-control" placeholder="SN STB 1">
              </div>
            </div>
            <div class="form-row border border-info p-1 mb-2">
              <div class="col-12 align-self-center">
                <span class="text-center">STB 2</span>
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="mac_dos_stb" maxlength="50" class="form-control" placeholder="MAC STB 2">
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="sn_dos_stb" maxlength="50" class="form-control" placeholder="SN STB 2">
              </div>
            </div>
            <div class="form-row border border-info p-1 mb-2">
              <div class="col-12 align-self-center">
                <span class="text-center">STB 3</span>
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="mac_tres_stb" maxlength="50" class="form-control" placeholder="MAC STB 3">
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="sn_tres_stb" maxlength="50" class="form-control" placeholder="SN STB 3">
              </div>
            </div>

            <div class="form-row border border-warning p-1 mb-2">
              <div class="col-12 align-self-center">
                <span class="text-center">Access Point 1</span>
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="ap_uno_mac" maxlength="50" class="form-control" placeholder="MAC AP 1">
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="ap_uno_sn" maxlength="50" class="form-control" placeholder="SN AP 1">
              </div>
            </div>
            <div class="form-row border border-warning p-1 mb-2">
              <div class="col-12 align-self-center">
                <span class="text-center">Access Point 2</span>
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="ap_dos_mac" maxlength="50" class="form-control" placeholder="MAC AP 2">
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="ap_dos_sn" maxlength="50" class="form-control" placeholder="SN AP 2">
              </div>
            </div>
            <div class="form-row border border-warning p-1 mb-2">
              <div class="col-12 align-self-center">
                <span class="text-center">Access Point 3</span>
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="ap_tres_mac" maxlength="50" class="form-control" placeholder="MAC AP 3">
              </div>
              <div class="form-group col-md-6 col-12 p-1 mb-0">
                <input type="text" name="ap_tres_sn" maxlength="50" class="form-control" placeholder="SN AP 3">
              </div>
            </div>
            <input type="submit" name="save_altas" class="btn btn-success btn-block" value="Guardar orden">
          </form>
        </div>
      </div>

      <div class="row justify-content-center p-1">
        <div class="col-auto text-center">
          <a class="btn btn-info" href="../BaseDatos/dtaltas.php" role="button">Ver todas las ordenes</a>
        </div>
      </div>
      <br>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Ultimas altas cargadas</p>
          <table id="altas" class="table table-responsive table-striped table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>
                <th>Acciones</th>
                <?php if($tipo_us == 'Administrador') { ?>
                  <th>Quien</th>
                  <th>Cuando</th>
                <?php } ?>
                <th>Tecnico</th>
                <th>OT</th>
                <th>Direccion</th>
                <th>Zona</th>
                <th>Fecha</th>
                <th>ONT MAC</th>
                <th>ONT SN</th>
                <th>STB 1 MAC</th>
                <th>STB 1 SN</th>
                <th>STB 2 MAC</th>
                <th>STB 2 SN</th>
                <th>STB 3 MAC</th>
                <th>STB 3 SN</th>
                <th>AP 1 MAC</th>
                <th>AP 1 SN</th>
                <th>AP 2 MAC</th>
                <th>AP 2 SN</th>
                <th>AP 3 MAC</th>
                <th>AP 3 SN</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $altas = mysqli_query($conn, "SELECT * FROM altas WHERE calendario LIKE '%$mes%' ORDER BY calendario desc LIMIT 50");
                while($row = mysqli_fetch_assoc($altas))
                {
              ?>
                <tr align="center">
                  <td>
                    <a href="../Editar/edit.php?id=<?php echo $row['id']?>">
                      <i class="fas fa-pen p-2"></i>
                    </a>
                    <a class="text-danger" href="../Borrar/delete_altas.php?id=<?php echo $row['id']?>">
                      <i class="far fa-trash-alt p-2"></i>
                    </a>
                  </td>
                  <?php if($tipo_us == 'Administrador') { ?>
                    <td><?php echo $row['quien']; ?></td>
                    <td><?php echo Fecha2($row['cuando']); ?></td>
                  <?php } ?>
                  <td><?php echo $row['tecnico']; ?></td>
                  <td><?php echo $row['ot']; ?></td>
                  <td><?php echo $row['direccion']; ?></td>
                  <td><?php echo $row['zona']; ?></td>
                  <td><?php echo Fecha7($row['calendario']); ?></td>
                  <td><?php echo $row['mac_ont']; ?></td>
                  <td><?php echo $row['sn_ont']; ?></td>
                  <td><?php echo $row['mac_uno_stb']; ?></td>
                  <td><?php echo $row['sn_uno_stb']; ?></td>
                  <td><?php echo $row['mac_dos_stb']; ?></td>
                  <td><?php echo $row['sn_dos_stb']; ?></td>
                  <td><?php echo $row['mac_tres_stb']; ?></td>
                  <td><?php echo $row['sn_tres_stb']; ?></td>
                  <td><?php echo $row['ap_uno_mac']; ?></td>
                  <td><?php echo $row['ap_uno_sn']; ?></td>
                  <td><?php echo $row['ap_dos_mac']; ?></td>
                  <td><?php echo $row['ap_dos_sn']; ?></td>
                  <td><?php echo $row['ap_tres_mac']; ?></td>
                  <td><?php echo $row['ap_tres_sn']; ?></td>
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
      $('#altas').DataTable( {
          "dom": '<"top"if>rt<"bottom"><"clear">',
          "scrollY":        "500px",
          "scrollX": true,
          "scrollCollapse": true,
          "paging":         false,
          "language": {
          "processing":     "Procesando...",
          "search":         "Buscar:",
          "lengthMenu":     "Mostrar _MENU_ altas por pagina...",
          "zeroRecords":    "No se encontro ninguna alta",
          "info":           "",
          "infoEmpty":      "No hay altas disponibles",
          "infoFiltered":   "filtrado entre _MAX_ altas",
          "loadingRecords": "Cargando...",
          },
          "ordering": false
      } );
  } );
</script>
</body>
</html>