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
          <input type="hidden" name="link" value="../Basico/altas2.php">
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
          <input type="hidden" name="link" value="../Basico/altas2.php">
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
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#alta_individual">+</button> 
        </div>
      </div>
      <div class="modal fade" id="alta_individual" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel" text-center>Carga de altas</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
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
        </div>
      </div>

      <div class="row justify-content-center p-1">
        <div class="col-auto text-center">
          <a class="btn btn-info" href="../BaseDatos/dtaltas.php" role="button">Ver todas las ordenes</a>
        </div>
      </div>
      <br>

      <?php
        if($zona_us == 'Todo')
        {
          $altas_cont = mysqli_query($conn, "SELECT * FROM altas WHERE calendario LIKE '%$mes%' AND completo = 'NO'");
        }
        else
        {
          $altas_cont = mysqli_query($conn, "SELECT * FROM altas WHERE calendario LIKE '%$mes%' AND zona = '$zona_us' AND completo = 'NO'");
        }
        if (mysqli_num_rows($altas_cont) > 0)
        {
          $cont_pend = mysqli_num_rows($altas_cont);
      ?>
        <div class="row justify-content-center p-1">
          <div class="col-auto">
            <p class="h4 mb-4 text-center">Altas pendientes (<?php echo $cont_pend; ?>)</p>
            <table class="table table-responsive table-striped table-bordered table-sm" style="max-height: 50rem;">
              <thead class="thead-dark text-center">
                <tr>
                  <th>Estado</th>
                  <th>Acciones</th>
                  <th>Tecnico</th>
                  <th>OT</th>
                  <th>Direccion</th>
                  <th>Deposito</th>
                  <th>Fecha</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  if($zona_us == 'Todo')
                  {
                   $altas = mysqli_query($conn, "SELECT * FROM altas WHERE calendario LIKE '%$mes%' AND completo = 'NO' ORDER BY id asc");
                  }
                  else
                  {
                    $altas = mysqli_query($conn, "SELECT * FROM altas WHERE calendario LIKE '%$mes%' AND zona = '$zona_us' AND completo = 'NO' ORDER BY id asc");
                  }
                  while($row = mysqli_fetch_assoc($altas))
                  {
                    $tokken = $row['token'];
                ?>
                  <tr align="center">
                    <td>
                      <?php if($row['completo'] == 'SI') { ?>
                        <i class="fa-solid fa-circle-check text-success"></i>
                      <?php } else { ?>
                        <i class="fa-solid fa-circle-exclamation text-warning"></i>
                      <?php } ?>
                    </td>
                    <td>
                      <a href="../Editar/edit2.php?id=<?php echo $row['id']; ?>">
                        <i class="fas fa-pen p-2"></i>
                      </a>
                    <?php if($tipo_us == 'Administrador') { ?>
                      <a class="text-danger" href="../Borrar/delete_altas.php?id=<?php echo $row['id']?>">
                        <i class="far fa-trash-alt p-2"></i>
                      </a>
                    <?php } ?>
                    </td>
                    <td style="cursor: pointer;" class="toggler" data-prod-cat="<?php echo $row['token']?>"><?php echo $row['tecnico']; ?></td>
                    <td style="cursor: pointer;" class="toggler" data-prod-cat="<?php echo $row['token']?>"><?php echo $row['ot']; ?></td>
                    <td style="cursor: pointer;" class="toggler" data-prod-cat="<?php echo $row['token']?>"><?php echo $row['direccion']; ?></td>
                    <td style="cursor: pointer;" class="toggler" data-prod-cat="<?php echo $row['token']?>"><?php echo $row['zona']; ?></td>
                    <td style="cursor: pointer;" class="toggler" data-prod-cat="<?php echo $row['token']?>"><?php echo Fecha7($row['calendario']); ?></td>
                  </tr>
                  <tr hidden><td></td></tr>
                  <tr class="cat<?php echo $row['token'];?>" style="display:none">
                    <td colspan="7" class="p-2">
                      <?php if($tipo_us == 'Administrador') { ?>
                        <div class="row pl-2 pr-2 pt-0 pb-0">
                          <div class="col">
                            <p class="m-1"><b>Quien:</b> <?php echo $row['quien']; ?><br><b>Cuando:</b> <?php echo Fecha2($row['cuando']); ?></p>
                          </div>
                        </div>
                      <?php } ?>
                      <div class="row row-cols-2 pl-2 pr-2 pt-0 pb-0">
                        <div class="col">
                          <p class="m-1">
                            <b>ID actividad:</b> <?php echo $row['id_actividad']; ?><br>
                            <b>Cliente:</b> <?php echo $row['cliente']; ?><br>
                            <b>Telefono:</b> <?php echo $row['telefono']; ?>
                          </p>
                        </div>
                        <div class="col">
                          <p class="m-1">
                            <b>NIM:</b> <?php echo $row['nim']; ?><br>
                            <b>Localidad:</b> <?php echo $row['localidad']; ?><br>
                            <b>Zona:</b> <?php echo $row['zona_tarea']; ?>
                          </p>
                        </div>
                      </div>
                      <div class="row p-2">
                        <?php if($row['mac_ont'] !== ''){ ?>
                          <div class="col border border-success p-2">
                            <h6>ONT</h6>
                              <p class="m-1"><b>MAC:</b> <?php echo $row['mac_ont']; ?></p>
                              <p class="m-1"><b>SN:</b> <?php echo $row['sn_ont']; ?></p>
                          </div>
                        <?php } ?>
                        <?php if($row['mac_uno_stb'] !== ''){ ?>
                          <div class="col border border-info p-2">
                            <h6>STB 1</h6>
                              <p class="m-1"><b>MAC:</b> <?php echo $row['mac_uno_stb']; ?></p>
                              <p class="m-1"><b>SN:</b> <?php echo $row['sn_uno_stb']; ?></p>
                          </div>
                        <?php } ?>
                        <?php if($row['mac_dos_stb'] !== ''){ ?>
                          <div class="col border border-info p-2">
                            <h6>STB 2</h6>
                              <p class="m-1"><b>MAC:</b> <?php echo $row['mac_dos_stb']; ?></p>
                              <p class="m-1"><b>SN:</b> <?php echo $row['sn_dos_stb']; ?></p>
                          </div>
                        <?php } ?>
                        <?php if($row['mac_tres_stb'] !== ''){ ?>
                          <div class="col border border-info p-2">
                            <h6>STB 3</h6>
                              <p class="m-1"><b>MAC:</b> <?php echo $row['mac_tres_stb']; ?></p>
                              <p class="m-1"><b>SN:</b> <?php echo $row['sn_tres_stb']; ?></p>
                          </div>
                        <?php } ?>
                        <?php if($row['ap_uno_mac'] !== ''){ ?>
                          <div class="col border border-warning p-2">
                            <h6>AP 1</h6>
                              <p class="m-1"><b>MAC:</b> <?php echo $row['ap_uno_mac']; ?></p>
                              <p class="m-1"><b>SN:</b> <?php echo $row['ap_uno_sn']; ?></p>
                          </div>
                        <?php } ?>
                        <?php if($row['ap_dos_mac'] !== ''){ ?>
                          <div class="col border border-warning p-2">
                            <h6>AP 2</h6>
                              <p class="m-1"><b>MAC:</b> <?php echo $row['ap_dos_mac']; ?></p>
                              <p class="m-1"><b>SN:</b> <?php echo $row['ap_dos_sn']; ?></p>
                          </div>
                        <?php } ?>
                        <?php if($row['ap_tres_mac'] !== ''){ ?>
                          <div class="col border border-warning p-2">
                            <h6>AP 3</h6>
                              <p class="m-1"><b>MAC:</b> <?php echo $row['ap_tres_mac']; ?></p>
                              <p class="m-1"><b>SN:</b> <?php echo $row['ap_tres_sn']; ?></p>
                          </div>
                        <?php } ?>
                      </div>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php } else { ?>
        <div class="row justify-content-center p-1">
          <div class="col-auto">
            <p class="h5 mb-4 text-center">No hay altas pendientes</p>
          </div>
        </div>
      <?php } ?>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Altas completas</p>
          <table class="table table-responsive table-striped table-bordered table-sm" style="max-height: 50rem;">
            <thead class="thead-dark text-center">
              <tr>
                <th>Estado</th>
                <th>Acciones</th>
                <th>Tecnico</th>
                <th>OT</th>
                <th>Direccion</th>
                <th>Deposito</th>
                <th>Fecha</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if($zona_us == 'Todo')
                {
                  $altas_b = mysqli_query($conn, "SELECT * FROM altas WHERE calendario LIKE '%$mes%' AND completo = 'SI' ORDER BY id desc");
                }
                else
                {
                  $altas_b = mysqli_query($conn, "SELECT * FROM altas WHERE calendario LIKE '%$mes%' AND zona = '$zona_us' AND completo = 'SI' ORDER BY id desc");
                }
                while($row = mysqli_fetch_assoc($altas_b))
                {
                  $tokken = $row['token'];
              ?>
                <tr align="center">
                  <td>
                    <?php if($row['completo'] == 'SI') { ?>
                      <i class="fa-solid fa-circle-check text-success"></i>
                    <?php } else { ?>
                      <i class="fa-solid fa-circle-exclamation text-warning"></i>
                    <?php } ?>
                  </td>
                  <td>
                    <a href="../Editar/edit2.php?id=<?php echo $row['id']; ?>">
                      <i class="fas fa-pen p-2"></i>
                    </a>
                  <?php if($tipo_us == 'Administrador') { ?>
                    <a class="text-danger" href="../Borrar/delete_altas.php?id=<?php echo $row['id']?>">
                      <i class="far fa-trash-alt p-2"></i>
                    </a>
                  <?php } ?>
                  </td>
                  <td style="cursor: pointer;" class="toggler" data-prod-cat="<?php echo $row['token']?>"><?php echo $row['tecnico']; ?></td>
                  <td style="cursor: pointer;" class="toggler" data-prod-cat="<?php echo $row['token']?>"><?php echo $row['ot']; ?></td>
                  <td style="cursor: pointer;" class="toggler" data-prod-cat="<?php echo $row['token']?>"><?php echo $row['direccion']; ?></td>
                  <td style="cursor: pointer;" class="toggler" data-prod-cat="<?php echo $row['token']?>"><?php echo $row['zona']; ?></td>
                  <td style="cursor: pointer;" class="toggler" data-prod-cat="<?php echo $row['token']?>"><?php echo Fecha7($row['calendario']); ?></td>
                </tr>
                <tr hidden><td></td></tr>
                <tr class="cat<?php echo $row['token'];?>" style="display:none">
                  <td colspan="7" class="p-2">
                    <?php if($tipo_us == 'Administrador') { ?>
                      <div class="row pl-2 pr-2 pt-0 pb-0">
                        <div class="col">
                          <p class="m-1"><b>Quien:</b> <?php echo $row['quien']; ?><br><b>Cuando:</b> <?php echo Fecha2($row['cuando']); ?></p>
                        </div>
                      </div>
                    <?php } ?>
                    <div class="row row-cols-2 pl-2 pr-2 pt-0 pb-0">
                      <div class="col">
                        <p class="m-1">
                          <b>ID actividad:</b> <?php echo $row['id_actividad']; ?><br>
                          <b>Cliente:</b> <?php echo $row['cliente']; ?><br>
                          <b>Telefono:</b> <?php echo $row['telefono']; ?>
                        </p>
                      </div>
                      <div class="col">
                        <p class="m-1">
                          <b>NIM:</b> <?php echo $row['nim']; ?><br>
                          <b>Localidad:</b> <?php echo $row['localidad']; ?><br>
                          <b>Zona:</b> <?php echo $row['zona_tarea']; ?>
                        </p>
                      </div>
                    </div>
                    <div class="row p-2">
                      <?php if($row['mac_ont'] !== ''){ ?>
                        <div class="col border border-success p-2">
                          <h6>ONT</h6>
                            <p class="m-1"><b>MAC:</b> <?php echo $row['mac_ont']; ?></p>
                            <p class="m-1"><b>SN:</b> <?php echo $row['sn_ont']; ?></p>
                        </div>
                      <?php } ?>
                      <?php if($row['mac_uno_stb'] !== ''){ ?>
                        <div class="col border border-info p-2">
                          <h6>STB 1</h6>
                            <p class="m-1"><b>MAC:</b> <?php echo $row['mac_uno_stb']; ?></p>
                            <p class="m-1"><b>SN:</b> <?php echo $row['sn_uno_stb']; ?></p>
                        </div>
                      <?php } ?>
                      <?php if($row['mac_dos_stb'] !== ''){ ?>
                        <div class="col border border-info p-2">
                          <h6>STB 2</h6>
                            <p class="m-1"><b>MAC:</b> <?php echo $row['mac_dos_stb']; ?></p>
                            <p class="m-1"><b>SN:</b> <?php echo $row['sn_dos_stb']; ?></p>
                        </div>
                      <?php } ?>
                      <?php if($row['mac_tres_stb'] !== ''){ ?>
                        <div class="col border border-info p-2">
                          <h6>STB 3</h6>
                            <p class="m-1"><b>MAC:</b> <?php echo $row['mac_tres_stb']; ?></p>
                            <p class="m-1"><b>SN:</b> <?php echo $row['sn_tres_stb']; ?></p>
                        </div>
                      <?php } ?>
                      <?php if($row['ap_uno_mac'] !== ''){ ?>
                        <div class="col border border-warning p-2">
                          <h6>AP 1</h6>
                            <p class="m-1"><b>MAC:</b> <?php echo $row['ap_uno_mac']; ?></p>
                            <p class="m-1"><b>SN:</b> <?php echo $row['ap_uno_sn']; ?></p>
                        </div>
                      <?php } ?>
                      <?php if($row['ap_dos_mac'] !== ''){ ?>
                        <div class="col border border-warning p-2">
                          <h6>AP 2</h6>
                            <p class="m-1"><b>MAC:</b> <?php echo $row['ap_dos_mac']; ?></p>
                            <p class="m-1"><b>SN:</b> <?php echo $row['ap_dos_sn']; ?></p>
                        </div>
                      <?php } ?>
                      <?php if($row['ap_tres_mac'] !== ''){ ?>
                        <div class="col border border-warning p-2">
                          <h6>AP 3</h6>
                            <p class="m-1"><b>MAC:</b> <?php echo $row['ap_tres_mac']; ?></p>
                            <p class="m-1"><b>SN:</b> <?php echo $row['ap_tres_sn']; ?></p>
                        </div>
                      <?php } ?>
                    </div>
                  </td>
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
    $(".toggler").click(function(e){
      e.preventDefault();
      $('.cat'+$(this).attr('data-prod-cat')).toggle();
    });
  });
</script>
</body>
</html>