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
          <input type="hidden" name="link" value="../Basico/toa.php">
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
          <input type="hidden" name="link" value="../Basico/toa.php">
          <button type="submit" name="mas" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Mes siguiente">
            <i class="fa-solid fa-caret-right"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
<!-- FECHA -->
<div class="container-fluid p-4">
  <div class="row p-2">
    <div class="container-fluid ">

    <div class="row p-2">
      <div class="col-lg-2 col-md-3 col-sm-3 col-12 p-0">
        <div class="row rounded bg-white shadow border-left border-success m-1 justify-content-between">
          <div class="col-auto h6 p-2 text-muted m-0">
            2 play
          </div>
          <div class="col-auto h6 p-2 text-muted m-0">
            <?php echo '1'; ?>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-3 col-sm-3 col-12 p-0">
        <div class="row rounded bg-white shadow border-left border-success m-1 justify-content-between">
          <div class="col-auto h6 p-2 text-muted m-0">
            3 play
          </div>
          <div class="col-auto h6 p-2 text-muted m-0">
            <?php echo '1'; ?>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-3 col-sm-3 col-12 p-0">
        <div class="row rounded bg-white shadow border-left border-success m-1 justify-content-between">
          <div class="col-auto h6 p-2 text-muted m-0">
            STB
          </div>
          <div class="col-auto h6 p-2 text-muted m-0">
            <?php echo '1'; ?>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-3 col-sm-3 col-12 p-0">
        <div class="row rounded bg-white shadow border-left border-success m-1 justify-content-between">
          <div class="col-auto h6 p-2 text-muted m-0">
            Mud Int
          </div>
          <div class="col-auto h6 p-2 text-muted m-0">
            <?php echo '1'; ?>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-3 col-sm-3 col-12 p-0">
        <div class="row rounded bg-white shadow border-left border-success m-1 justify-content-between">
          <div class="col-auto h6 p-2 text-muted m-0">
            Bajas
          </div>
          <div class="col-auto h6 p-2 text-muted m-0">
            <?php echo '1'; ?>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-3 col-sm-3 col-12 p-0">
        <div class="row rounded bg-white shadow border-left border-success m-1 justify-content-between">
          <div class="col-auto h6 p-2 text-muted m-0">
            Bajas tec
          </div>
          <div class="col-auto h6 p-2 text-muted m-0">
            <?php echo '1'; ?>
          </div>
        </div>
      </div>
    </div>

      <div class="row justify-content-center p-1 rounded bg-white shadow p-0">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Datos de TOA</p>
            <table class="table table-responsive table-striped table-bordered table-hover table-sm">
              <tbody align="center">
                <?php
                  $rra = mysqli_query($conn, "SELECT
                  SUM(dos_play) as 'dos_player',
                  SUM(tres_play) as 'tres_player',
                  SUM(stb) as 'stb_player',
                  SUM(mudanza_interna) as 'mudanza_interna_player',
                  SUM(garantia) as 'garantia_player',
                  SUM(garantia_com) as 'garantia_com_player',
                  SUM(baja_tecnica) as 'baja_tecnica_player',
                  SUM(baja_desmonte) as 'baja_desmonte_player',
                  SUM(mtto) as 'mtto_player',
                  SUM(reacondicionamiento	) as 'reacondicionamiento_player',
                  SUM(mtto_externo) as 'mtto_externo_player'
                  FROM carga_dia WHERE fecha LIKE '%$mes%' AND estado = 'finalizada' ");
                  while($rowa = mysqli_fetch_assoc($rra))
                  {
                    ?>
                      <tr>
                        <!-- DIA Y HORARIOS -->
                          <?php
                            $hora_inicio = '00:00:00';
                            $rrai = mysqli_query($conn, "SELECT * FROM carga_dia WHERE tecnico = '$tecnico' and fecha = '$messi' ORDER BY id asc LIMIT 1");
                            while($rowai = mysqli_fetch_assoc($rrai))
                            { if($rowai['inicio'] < '07:00:00')
                              {
                                $hora_iniciar = '07:00:00';
                              }
                              else
                              {
                                $hora_iniciar = $rowai['inicio'];
                              }
                            }
                          ?>
                          <?php
                            $hora_tarea = '00:00:00';
                            $rrat = mysqli_query($conn, "SELECT * FROM carga_dia WHERE tecnico = '$tecnico' and fecha = '$messi' AND cliente <> '' ORDER BY id asc LIMIT 1");
                            while($rowat = mysqli_fetch_assoc($rrat))
                            { $hora_tarea = $rowat['inicio']; }
                          ?>
                          <?php
                            $hora_fin = '00:00:00';
                            $rraf = mysqli_query($conn, "SELECT * FROM carga_dia WHERE tecnico = '$tecnico' and fecha = '$messi' AND cliente <> '' ORDER BY id desc LIMIT 1");
                            while($rowaf = mysqli_fetch_assoc($rraf))
                            { $hora_fin = $rowaf['fin']; }
                          ?>
                          <?php
                            if($hora_tarea == '00:00:00' && $hora_fin == '00:00:00')
                            {
                              $hora_inicio = '00:00:00';
                              $tipo_de_dia = 'Ausente';
                            }
                            else
                            {
                              $hora_inicio = $hora_iniciar;

                              $a = date("l", strtotime($messi));
                              $b = explode(" ", $a);
                              $c = $b[0];
                              if($c == 'Saturday')
                              {
                                $tipo_de_dia = "Sabado";
                              }
                              else
                              {
                                $tipo_de_dia = "Normal";
                              }
                            }
                          ?>
                        <!-- DIA Y HORARIOS -->
                        <td colspan="5"><label>Dia</label>
                                          <select type="text" name="dia" class="form-control" required>
                                            <option selected value="<?php echo $tipo_de_dia; ?>"><?php echo $tipo_de_dia; ?></option> 
                                            <option value="Ausente">Ausente</option>
                                            <option value="Sabado">Sabado</option>
                                            <option value="Feriado">Feriado</option>
                                            <option value="Vacaciones">Vacaciones</option>
                                            <option value="Licencia">Licencia</option>
                                            <option value="Suspension">Suspension</option>
                                            <option value="Dia libre">Dia libre</option>
                                            <option value="Vehiculo roto">Vehiculo roto</option>
                                          </select>
                        </td>
                        <td><label>Inicio</label><input type="time" name="horadep" required class="form-control form-control-sm border border-primary" value="<?php echo $hora_inicio; ?>"></td>
                        <td><label>Tarea</label><input type="time" name="horatarea" required class="form-control form-control-sm border border-primary" value="<?php echo $hora_tarea; ?>"></td>
                        <td><label>Fin</label><input type="time" name="fin" required class="form-control form-control-sm border border-primary" value="<?php echo $hora_fin; ?>"></td>
                        <td colspan="3"></td>
                        <td><label>2 play</label><input type="number" name="dosplay" class="form-control form-control-sm border border-success" min="0" value="<?php echo $rowa['dos_player']; ?>"></td>
                        <td><label>3 play</label><input type="number" name="tresplay" class="form-control form-control-sm border border-success" min="0" value="<?php echo $rowa['tres_player']; ?>"></td>
                        <td><label>STB</label><input type="number" name="stb" class="form-control form-control-sm border border-success" min="0" value="<?php echo $rowa['stb_player']; ?>"></td>
                        <td><label>Mud int</label><input type="number" name="mudanza" class="form-control form-control-sm border border-success" min="0" value="<?php echo $rowa['mudanza_interna_player']; ?>"></td>
                        <?php
                          $rraa = mysqli_query($conn, "SELECT SUM(baja) as 'baja_player' FROM carga_dia WHERE tecnico = '$tecnico' and fecha = '$messi' AND estado = 'no realizado' AND cliente <> '' ");
                          while($rowaa = mysqli_fetch_assoc($rraa))
                          {
                            if($rowaa['baja_player'] == ''){$bajitas = 0;} else {$bajitas = $rowaa['baja_player'];};
                          }
                        ?>
                        <td><label>Bajas</label><input type="number" name="bajas" class="form-control form-control-sm border border-danger" min="0" value="<?php echo $bajitas; ?>"></td>

                        <td><label>Garatias</label><input type="number" name="garantec" class="form-control form-control-sm border border-success" min="0" value="<?php echo $rowa['garantia_player']; ?>"></td>
                        <td><label>Gar Com</label><input type="number" name="garancom" class="form-control form-control-sm border border-success" min="0" value="<?php echo $rowa['garantia_com_player']; ?>"></td>
                        <td><label>Baja tec</label><input type="number" name="bajatec" class="form-control form-control-sm border border-danger" min="0" value="<?php echo $rowa['baja_tecnica_player']; ?>"></td>
                        <td><label>Baja desm</label><input type="number" name="baja_desmonte" class="form-control form-control-sm border border-danger" min="0" value="<?php echo $rowa['baja_desmonte_player']; ?>"></td>
                        <td><label>Mtto int</label><input type="number" name="mtto_int" class="form-control form-control-sm border border-warning" min="0" value="<?php echo $rowa['mtto_player']; ?>"></td>
                        <td><label>Mtto ext</label><input type="number" name="mtto_ext" class="form-control form-control-sm border border-warning" min="0" value="<?php echo $rowa['mtto_externo_player']; ?>"></td>
                        <td><label>Reac</label><input type="number" name="mtto_reaco" class="form-control form-control-sm border border-warning" min="0" value="<?php echo $rowa['reacondicionamiento_player']; ?>"></td>
                      </tr>
                    <?php
                  } 
                ?>
                <?php
                  $result_tasks = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha LIKE '%$mes%' ORDER BY id asc");
                  while($row = mysqli_fetch_assoc($result_tasks))
                  { 
                    $color = '';
                    if($row['revisita'] === 'SI')
                    {
                      $color= 'class="alert-warning"';
                    }

                    if(strpos($row['actividad'], 'cnico al cliente - Garantia') !== false)
                    {
                      $color= 'class="alert-warning"';
                    }

                    if(strpos($row['actividad'], 'Reclamos Excepcionales') !== false)
                    {
                      $color= 'class="alert-warning"';
                    }

                    if(strpos($row['actividad'], 'cnica por mudanza interna') !== false && $row['estado'] === 'finalizada' ) ///////comprobar
                    {
                      $color= 'class="alert-warning"';
                    }
                    if($row['estado'] === 'iniciada')
                    {
                      $color= 'class="bg-danger"';
                    }
                ?>
                  <tr <?php  echo $color; ?> >
                    <td><?php echo Fecha7($row['fecha']); ?></td>
                    <td><?php echo $row['codigo']; ?></td>
                    <td><?php echo $row['cantidad_tv']; ?></td>
                    <td><?php echo utf8_encode($row['actividad']); ?></td>
                    <td><?php echo $row['ot']; ?></td>
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
                    <td data-toggle="tooltip" data-placement="bottom" title="<?php echo utf8_encode($row['nota_cierre']); ?>"><?php echo limitar_cadena(utf8_encode($row['nota_cierre']),50); ?></td>
                    <td><?php echo $row['revisita']; ?></td>
                    <td <?php if($row['dos_play'] > 0){echo 'class="font-weight-bold text-success"';} ?>><?php echo $row['dos_play']; ?></td>
                    <td <?php if($row['tres_play'] > 0){echo 'class="font-weight-bold text-success"';} ?>><?php echo $row['tres_play']; ?></td> 
                    <td <?php if($row['stb'] > 0){echo 'class="font-weight-bold text-success"';} ?>><?php echo $row['stb']; ?></td> 
                    <td <?php if($row['mudanza_interna'] > 0){echo 'class="font-weight-bold text-success"';} ?>><?php echo $row['mudanza_interna']; ?></td> 
                    <td <?php if($row['baja'] > 0){echo 'class="font-weight-bold text-danger"';} ?>><?php echo $row['baja']; ?></td> 
                    <td <?php if($row['garantia'] > 0){echo 'class="font-weight-bold text-warning"';} ?>><?php echo $row['garantia']; ?></td>
                    <td <?php if($row['garantia_com'] > 0){echo 'class="font-weight-bold text-warning"';} ?>><?php echo $row['garantia_com']; ?></td>
                    <td <?php if($row['baja_tecnica'] > 0){echo 'class="font-weight-bold text-danger"';} ?>><?php echo $row['baja_tecnica']; ?></td>
                    <td <?php if($row['baja_desmonte'] > 0){echo 'class="font-weight-bold text-danger"';} ?>><?php echo $row['baja_desmonte']; ?></td>
                    <td <?php if($row['mtto'] > 0){echo 'class="font-weight-bold text-warning"';} ?>><?php echo $row['mtto']; ?></td>
                    <td <?php if($row['mtto_externo'] > 0){echo 'class="font-weight-bold text-warning"';} ?>><?php echo $row['mtto_externo']; ?></td>
                    <td <?php if($row['reacondicionamiento'] > 0){echo 'class="font-weight-bold text-warning"';} ?>><?php echo $row['reacondicionamiento']; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
              <tfoot class="thead-dark text-center">
                <tr>
                  <th>Codigo</th>
                  <th>TV</th>
                  <th>Actividad</th>
                  <th>OT</th>
                  <th>Estado</th>
                  <th>Inicio</th>
                  <th>Fin</th>
                  <th>Cierre</th>
                  <th>Observacion</th>
                  <th>Revisita</th>
                  <th>2 play</th>
                  <th>3 play</th>
                  <th>Adicional</th>
                  <th>Mudanza interna</th>
                  <th>Baja</th>
                  <th>Garantia</th>
                  <th>Garantia compañero</th>
                  <th>Baja tecnica</th>
                  <th>Baja con desmonte</th>
                  <th>Mtto interno</th>
                  <th>Mtto externo</th>
                  <th>Reacond</th>
                </tr>
              </tfoot>
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

