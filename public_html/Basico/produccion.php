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
          <input type="hidden" name="link" value="../Basico/produccion.php">
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
          <input type="hidden" name="link" value="../Basico/produccion.php">
          <button type="submit" name="mas" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Mes siguiente">
            <i class="fa-solid fa-caret-right"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
<!-- FECHA -->
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
              <form action="../Guardar/save_produccion.php" method="POST">
                <p class="h4 mb-4 text-center">Carga del dia</p>
                <div class="form-row align-items-end">
                  <div class="form-group col-12 col-md">
                    <label for="exampleFormControlSelect1">Tecnico</label >
                    <select type="text" name="tecnico" class="form-control" required>
                      <option selected value="" disabled>Tecnicos...</option>                
                      <?php
                        $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo ='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                      ?>
                      <?php foreach ($ejecutar as $opciones): ?>   
                        <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                      <?php endforeach ?>
                    </select>
                  </div>            
                  <div class="form-group col-6 col-md">
                    <label for="exampleFormControlSelect1">Fecha</label >
                    <input type="date" name="fecha" class="form-control" required>
                  </div>
                  <div class="form-group col-6 col-md">
                    <label for="exampleFormControlSelect1">Dia</label >
                    <select type="text" name="dia" class="form-control" required>
                      <option selected>Normal</option> 
                      <option value="Ausente">Ausente</option>
                      <option value="Sabado">Sabado</option>
                      <option value="Feriado">Feriado</option>
                      <option value="Vacaciones">Vacaciones</option>
                      <option value="Licencia">Licencia</option>
                      <option value="Suspension">Suspension</option>
                      <option value="Dia libre">Dia libre</option>
                      <option value="Vehiculo roto">Vehiculo roto</option>
                    </select>
                  </div>
                  <div class="form-group col-6 col-md">
                    <label for="exampleFormControlSelect1">Inicio</label >
                    <input type="text" class="form-control clockpicker" readonly="" data-placement="left" data-align="top" data-autoclose="true" name="horadep" required>
                  </div>
                  <div class="form-group col-6 col-md">
                    <label for="exampleFormControlSelect1">Primer tarea</label >
                    <input type="text" class="form-control tarea" readonly="" data-placement="left" data-align="top" data-autoclose="true" name="horatarea" required>
                  </div>
                  <div class="form-group col-6 col-md">
                    <label for="exampleFormControlSelect1">Ultima tarea</label >
                    <input type="text" class="form-control fin" readonly="" data-placement="left" data-align="top" data-autoclose="true" name="fin" required>
                  </div>
                  <div class="form-group col-6 col-md">
                    <label for="exampleFormControlSelect1">Zona</label >
                    <select type="text" name="zona" class="form-control" required>
                      <option selected value="" disabled>Zona...</option>
                      <option value="CABA">CABA</option>
                      <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                      <option value="Lomas de Zamora">Lomas de Zamora</option>
                      <option value="San Nicolas">San Nicolas</option>
                    </select>
                  </div>
                </div>

                <div class="row align-items-end">
                  <div class="form-group col-md col-6">
                    <label for="exampleFormControlSelect1" class="text-center">Doble play</label >
                    <input type="number" name="dosplay" class="form-control" value="0">
                  </div>
                  <div class="form-group col-md col-6">
                    <label for="exampleFormControlSelect1" class="text-center">Triple play</label >
                    <input type="number" name="tresplay" class="form-control" value="0">
                  </div>
                  <div class="form-group col-md col-6">
                    <label for="exampleFormControlSelect1" class="text-center">Set to Box</label >
                    <input type="number" name="stb" class="form-control" value="0">
                  </div>
                  <div class="form-group col-md col-6">
                    <label for="exampleFormControlSelect1" class="text-center">Mudanzas internas</label >
                    <input type="number" name="mudanza" class="form-control" value="0">
                  </div>
                  <div class="form-group col-md col-6">
                    <label for="exampleFormControlSelect1" class="text-center">Tareas cumplidas</label >
                    <input type="number" name="tcumplida" class="form-control" value="0">
                  </div>
                </div>

                <div class="row align-items-end">
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1" class="text-center">Bajas</label >
                    <input type="number" name="bajas" class="form-control" value="0">
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1" class="text-center">Garantias del tecnico</label >
                    <input type="number" name="garantec" class="form-control" value="0">
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1" class="text-center">Garantias compañero</label >
                    <input type="number" name="garancom" class="form-control" value="0">
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1" class="text-center">Reclamos</label >
                    <input type="number" name="reclamo" class="form-control" value="0">
                  </div>
                </div>

                <div class="row align-items-end">
                  <div class="form-group col-md col-6">
                    <label for="exampleFormControlSelect1" class="text-center">Bajas tecnica</label >
                    <input type="number" name="bajatec" class="form-control" value="0">
                  </div>
                  <div class="form-group col-md col-6">
                    <label for="exampleFormControlSelect1" class="text-center">Bajas con desmonte</label >
                    <input type="number" name="baja_desmonte" class="form-control" value="0">
                  </div>
                  <div class="form-group col-md col-6">
                    <label for="exampleFormControlSelect1" class="text-center">Reacondicionamiento</label >
                    <input type="number" name="mtto_reaco" class="form-control" value="0">
                  </div>
                  <div class="form-group col-md col-6">
                    <label for="exampleFormControlSelect1" class="text-center">Mtto interno</label >
                    <input type="number" name="mtto_int" class="form-control" value="0">
                  </div>              
                  <div class="form-group col-md col-6">
                    <label for="exampleFormControlSelect1" class="text-center">Mtto externo</label >
                    <input type="number" name="mtto_ext" class="form-control" value="0">
                  </div>
                  <div class="form-group col-md col-6">
                    <label for="exampleFormControlSelect1" class="text-center">Mtto cumplidos</label >
                    <input type="number" name="tareasmtto" class="form-control" value="0">
                  </div>
                </div>

                <div class="row align-items-end">
                  <div class="form-group col-12">
                    <label class="text-center">Observaciones</label>
                    <textarea type="text" name="obs" maxlength="255" class="form-control"></textarea>
                  </div>
                </div>

                <div class="row align-items-center">
                  <input type="submit" name="save_produccion" class="btn btn-success btn-block" value="Guardar dia">
                </div>
              </form>
            </div>
          </div>
        </div>

        <style type="text/css">
          #fecha{ min-width: 80px; }
        </style>

        <div class="row justify-content-center p-1 m-0">
          <div class="col-auto">
            <p class="h4 mb-4 text-center">Produccion</p>
          </div>
        </div>
        <div class="row justify-content-center p-1 m-0">
          <div class="col-auto">
            <a class="btn btn-info" href="../BaseDatos/dtproduccion.php" role="button">Ver toda la produccion</a>             
          </div>
        </div>
        <div class="row justify-content-center p-1 m-0">
          <div class="col-auto">
            <table class="table table-responsive table-striped table-bordered table-sm">
              <thead class="thead-dark text-center">
                <tr>
                  <th>Acciones</th>
                  <th>Tecnico</th>
                  <th id="fecha">Fecha</th>
                  <th>Dia</th>
                  <th>Hora deposito</th>
                  <th>Hora primera tarea</th>
                  <th>2 play</th>
                  <th>3 play</th>
                  <th>STB</th>
                  <th>Mud</th>
                  <th>Tareas cumplidas</th>
                  <th>Tareas mtto</th>
                  <th>Bajas</th>            
                  <th>Garantias del tecnico</th>            
                  <th>Garantias de un compañero</th>
                  <th>Bajas tecnicas</th>
                  <th>Bajas con desmonte</th>
                  <th>Mtto Reacond</th>
                  <th>Mtto Interno</th>
                  <th>Mtto Externo</th>
                  <th>Reclamos</th>           
                  <th>Fin del dia</th>
                  <th>Zona</th>
                  <th>Observaciones</th>           
                </tr>
              </thead>
              <tbody align="center">
                <?php
                  $result_tasks = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha LIKE '%$mes%' ORDER BY id desc");
                  while($row = mysqli_fetch_assoc($result_tasks))
                  {
                ?>
                  <tr>
                    <td>
                      <a href="../Editar/edit_produccion.php?id=<?php echo $row['id']?>">
                        <i class="fas fa-pen p-2"></i>
                      </a>
                      <a href="../Borrar/delete_produccion.php?id=<?php echo $row['id']?>">
                        <i class="far fa-trash-alt p-2"></i>
                      </a>
                    </td>
                    <td><?php echo $row['tecnico']; ?></td>
                    <td><?php echo Fecha8($row['fecha']); ?></td>
                    <td><?php echo $row['dia']; ?></td>
                    <td><?php echo $row['horadep']; ?></td>
                    <td><?php echo $row['horatarea']; ?></td>
                    <td><?php echo $row['dosplay']; ?></td>
                    <td><?php echo $row['tresplay']; ?></td>
                    <td><?php echo $row['stb']; ?></td>
                    <td><?php echo $row['mudanza']; ?></td>
                    <td><?php echo $row['tcumplida']; ?></td>
                    <td><?php echo $row['tareasmtto']; ?></td>
                    <td><?php echo $row['bajas']; ?></td>               
                    <td><?php echo $row['garantec']; ?></td>                
                    <td><?php echo $row['garancom']; ?></td>
                    <td><?php echo $row['bajatec']; ?></td>
                    <td><?php echo $row['baja_desmonte']; ?></td>
                    <td><?php echo $row['mtto_reaco']; ?></td>
                    <td><?php echo $row['mtto_int']; ?></td>
                    <td><?php echo $row['mtto_ext']; ?></td>
                    <td><?php echo $row['reclamo']; ?></td>              
                    <td><?php echo $row['fin']; ?></td>
                    <td><?php echo $row['zona']; ?></td>
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
</div>
  <!-- PIE DE PAGINA -->
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <!-- then Popper -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <!-- Bootstrap -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <!------Timepicker 1---->
  <script src="../clockpicker.js"></script>
  <script type="text/javascript">
    var input = $('.clockpicker').clockpicker({
      placement: 'bottom',
      align: 'left',
      autoclose: true,
      'default': 'now'});
    </script>
    <!------Timepicker 2---->
  <script src="../clockpicker.js"></script>
  <script type="text/javascript">
     var input = $('.tarea').clockpicker({
      placement: 'bottom',
      align: 'left',
      autoclose: true,
      'default': 'now'});
    </script>
    <!------Timepicker 3---->
  <script src="../clockpicker.js"></script>
  <script type="text/javascript">
      var input = $('.fin').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'});
  </script>
</body>
</html>

