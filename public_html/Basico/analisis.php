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
<?php
  $tectec = 'Brian Flores';
  if(isset($_POST["tectec"]))
  {
    $tectec = $_POST['tectec'];
  }
?>
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
          <input type="hidden" name="link" value="../Basico/analisis.php">
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
          <input type="hidden" name="link" value="../Basico/analisis.php">
          <button type="submit" name="mas" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Mes siguiente">
            <i class="fa-solid fa-caret-right"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
<!-- FECHA -->
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-2 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

      <nav>
        <div class="nav justify-content-center nav-tabs" id="nav-tab" role="tablist">
          <?php
            $produ = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha LIKE '%$mes%' GROUP BY tecnico");
            while($row = mysqli_fetch_assoc($produ))
            {
              $tecni = str_replace( ' ', "_", $row['tecnico'] );
          ?>
            <button class="nav-link" id="nav-<?php echo $tecni; ?>-tab" data-toggle="tab" data-target="#nav-<?php echo $tecni; ?>" type="button" role="tab" aria-controls="nav-<?php echo $tecni; ?>" aria-selected="true"><?php echo $row['tecnico']; ?></button>
          <?php } ?>
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <?php
          $produ1 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha LIKE '%$mes%' GROUP BY tecnico");
          while($roww = mysqli_fetch_assoc($produ1))
          {
            $tecni1 = str_replace( ' ', "_", $roww['tecnico'] );
            $tectec = $roww['tecnico'];
        ?>
          <div class="tab-pane fade" id="nav-<?php echo $tecni1; ?>" role="tabpanel" aria-labelledby="nav-<?php echo $tecni1; ?>-tab">

              <!---PHP CANTIDAD ESTE MES----->
                <?php
                  $task = mysqli_query($conn, "SELECT SUM(dosplay) as 'dospl', SUM(tresplay) as 'trespl', SUM(stb) as 'stbtec', SUM(mudanza) as 'mud', SUM(tcumplida) as 'todocum', SUM(bajas) as 'baj', SUM(bajatec) as 'bajtec', SUM(garantec) as 'garte', SUM(mtto_int) as 'mtto_int_t', SUM(mtto_ext) as 'mtto_ext_t', SUM(mtto_reaco) as 'mtto_reaco_t', SUM(tareasmtto) as 'tareasmtto_t' FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$tectec'");
                  while($row = mysqli_fetch_assoc($task))
                  { 
                    $todocum= $row['todocum'];
                    $dospl= $row['dospl'];
                    $trespl= $row['trespl'];
                    $stbtec= $row['stbtec'];
                    $mud= $row['mud'];
                    $baj= $row['baj'];
                    $bajtec= $row['bajtec'];
                    $garte= $row['garte'];
                    $mtto_int= $row['mtto_int_t'];
                    $mtto_ext= $row['mtto_ext_t'];
                    $mtto_reaco= $row['mtto_reaco_t'];
                    $tareasmtto= $row['tareasmtto_t'];
                  }

                  $u_dia = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' ORDER by fecha desc LIMIT 1");
                  while($row = mysqli_fetch_assoc($u_dia))
                  { 
                    $ult_dia_produ = $row['fecha'];
                  }

                  $gg = mysqli_query($conn, "SELECT COUNT(tecnico) as 'garte_nj' FROM garantias WHERE tecnico = '$tectec' AND justificado = 'NO' AND fecharep BETWEEN '$mes-01' AND '$ult_dia_produ' ");
                  while($row = mysqli_fetch_assoc($gg))
                  {
                    $garte_nj= $row['garte_nj'];
                  }
                ?>
              <!---PHP CANTIDAD ESTE MES----->
            <?php
              $porc = ($todocum + $garte + $baj + $tareasmtto);
              $dp= ($dospl * 100 / $porc);
              $tot = bcdiv($dp, '1', '2');
              $dpa= ($trespl * 100 / $porc);
              $tottres = bcdiv($dpa, '1', '2');
              $totstb= ($stbtec * 100 / $porc);
              $dpb= ($baj * 100 / $porc);
              $totbajas = bcdiv($dpb, '1', '2');
              $dpg= ($garte_nj * 100 / $porc);
              $totgar = bcdiv($dpg, '1', '2'); 
              $mtto_porc_rea= ($mtto_reaco * 100 / $porc);
              $totreaco = bcdiv($mtto_porc_rea, '1', '2');
              $mtto_porc_int= ($mtto_int * 100 / $porc);
              $totmtto_int = bcdiv($mtto_porc_int, '1', '2');
              $mtto_porc_ext= ($mtto_ext * 100 / $porc);
              $totmtto_ext = bcdiv($mtto_porc_ext, '1', '2');
            ?>
            <div class="row justify-content-center p-1">
              <div class="col-auto">
              <p class="h4 mb-4 text-center"><?php echo $tectec ?> en 
              <?php
                $solofefe = explode("-", $mes);
                $messs = $solofefe[1];
                switch ($messs)
                {
                  case '12': echo "Diciembre";
                  break;
                  case '11': echo "Noviembre";
                  break;
                  case '10': echo "Octubre";
                  break;
                  case '09': echo "Septiembre";
                  break;
                  case '08': echo "Agosto";
                  break;
                  case '07': echo "Julio";
                  break;
                  case '06': echo "Junio";
                  break;
                  case '05': echo "Mayo";
                  break;
                  case '04': echo "Abril";
                  break;
                  case '03': echo "Marzo";
                  break;
                  case '02': echo "Febrero";
                  break;
                  case '01': echo "Enero";
                  break;
                }
              ?>
              </p>
              </div>
            </div>

            <div class="row justify-content-center p-1">
              <div class="col-md-8 col-12">
                <!-- DIAS -->
                  <div class="row justify-content-center">
                    <div class="col-auto text-center">
                      <p class="h4 mb-4 text-center">Dias</p>
                      <table class="table table-responsive table-striped table-bordered table-sm">
                        <thead class="thead-dark text-center">
                          <tr>
                            <th>Normal</th>
                            <th>Ausentes</th>
                            <th>Sabados</th>
                            <th>Feriados</th>
                            <th>Vacaciones</th>
                            <th>Libre</th>
                            <th>Licencia</th>
                            <th>Suspension</th>
                            <th>Vehiculo roto</th>
                          </tr>
                        </thead>
                        <tbody>
                              <?php
                                $dia_normal = mysqli_query($conn, "SELECT COUNT(*) as 'cont_normal' FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND dia = 'Normal' ");
                                while($row = mysqli_fetch_assoc($dia_normal))
                                { $count_dia_normal = $row['cont_normal']; }

                                $dia_ausente = mysqli_query($conn, "SELECT COUNT(*) as 'cont_ausente' FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND dia = 'Ausente'");
                                while($row = mysqli_fetch_assoc($dia_ausente))
                                { $count_dia_ausente = $row['cont_ausente']; }

                                $dia_sabado = mysqli_query($conn, "SELECT COUNT(*) as 'cont_sabado' FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND dia = 'Sabado'");
                                while($row = mysqli_fetch_assoc($dia_sabado))
                                { $count_dia_sabado = $row['cont_sabado']; }

                                $dia_feriado = mysqli_query($conn, "SELECT COUNT(*) as 'cont_feriado' FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND dia = 'Feriado'");
                                while($row = mysqli_fetch_assoc($dia_feriado))
                                { $count_dia_feriado = $row['cont_feriado']; }

                                $dia_vacaciones = mysqli_query($conn, "SELECT COUNT(*) as 'cont_vacaciones' FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND dia = 'Vacaciones'");
                                while($row = mysqli_fetch_assoc($dia_vacaciones))
                                { $count_dia_vacaciones = $row['cont_vacaciones']; }

                                $dia_libre = mysqli_query($conn, "SELECT COUNT(*) as 'cont_libre' FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND dia = 'Dia libre'");
                                while($row = mysqli_fetch_assoc($dia_libre))
                                { $count_dia_libre = $row['cont_libre']; }

                                $dia_licencia = mysqli_query($conn, "SELECT COUNT(*) as 'cont_licencia' FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND dia = 'Licencia'");
                                while($row = mysqli_fetch_assoc($dia_licencia))
                                { $count_dia_licencia = $row['cont_licencia']; }

                                $dia_suspension = mysqli_query($conn, "SELECT COUNT(*) as 'cont_suspension' FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND dia = 'Suspension'");
                                while($row = mysqli_fetch_assoc($dia_suspension))
                                { $count_dia_suspension = $row['cont_suspension']; }

                                $dia_vehiculo = mysqli_query($conn, "SELECT COUNT(*) as 'cont_vehiculo' FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND dia = 'Vehiculo roto'");
                                while($row = mysqli_fetch_assoc($dia_vehiculo))
                                { $count_dia_vehiculo = $row['cont_vehiculo']; }
                              ?>
                            <tr align="center">
                                <td><?php echo $count_dia_normal; ?></td>
                                <td><?php echo $count_dia_ausente; ?></td>
                                <td><?php echo $count_dia_sabado; ?></td>
                                <td><?php echo $count_dia_feriado; ?></td>
                                <td><?php echo $count_dia_vacaciones; ?></td>
                                <td><?php echo $count_dia_libre; ?></td>
                                <td><?php echo $count_dia_licencia; ?></td>
                                <td><?php echo $count_dia_suspension; ?></td>
                                <td><?php echo $count_dia_vehiculo; ?></td>
                            </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                <!-- DIAS -->

                <!-- PRODUCCION -->
                  <div class="row justify-content-center">
                    <div class="col-auto text-center">
                      <p class="h4 mb-4 text-center">Produccion</p>
                      <table class="table table-responsive table-striped table-bordered table-sm">
                        <thead class="thead-dark text-center">
                          <tr>
                            <th>Mes</th>
                            <th>2 play</th>
                            <th>3 play</th>
                            <th>Adicional</th>
                            <th>Mudanzas Int</th>
                            <th>Bajas</th>
                            <th>Bajas tec</th>
                            <th>Reacond</th>
                            <th>Mtto int</th>
                            <th>Mtto ext</th>
                            <th>Garantias</th>
                            <th>No justificada</th>
                            <th>Total tareas</th>
                            <th>Total mtto</th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr align="center">
                              <td>
                                <?php 
                                  switch ($messs)
                                  {
                                    case '12': echo "Diciembre";
                                    break;
                                    case '11': echo "Noviembre";
                                    break;
                                    case '10': echo "Octubre";
                                    break;
                                    case '09': echo "Septiembre";
                                    break;
                                    case '08': echo "Agosto";
                                    break;
                                    case '07': echo "Julio";
                                    break;
                                    case '06': echo "Junio";
                                    break;
                                    case '05': echo "Mayo";
                                    break;
                                    case '04': echo "Abril";
                                    break;
                                    case '03': echo "Marzo";
                                    break;
                                    case '02': echo "Febrero";
                                    break;
                                    case '01': echo "Enero";
                                    break;
                                  }
                                ?>
                              </td>               
                              <td><?php echo $dospl; ?></td>
                              <td><?php echo $trespl; ?></td>
                              <td><?php echo $stbtec; ?></td>
                              <td><?php echo $mud; ?></td>
                              <td><?php echo $baj; ?></td>
                              <td><?php echo $bajtec; ?></td>
                              <td><?php echo $mtto_reaco; ?></td>
                              <td><?php echo $mtto_int; ?></td>
                              <td><?php echo $mtto_ext; ?></td>
                              <td><?php echo $garte; ?></td>
                              <td><?php echo $garte_nj; ?></td>
                              <td><?php echo $todocum; ?></td>
                              <td><?php echo $tareasmtto; ?></td>
                            </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                <!-- PRODUCCION -->

                <!-- PORCENTAJE -->
                  <p class="h4 mb-6 text-center">Porcentaje</p>
                  <p class="h5 mb-6">Dobe play</p>
                  <div class="progress">
                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $tot ?>%;" aria-valuenow="<?php echo $tot ?>" aria-valuemin="0" aria-valuemax="<?php echo $porc ?>"><?php echo $tot ?>%</div>
                  </div>
                  <p class="h5 mb-6">Triple play</p>
                  <div class="progress">
                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $tottres ?>%;" aria-valuenow="<?php echo $tottres ?>" aria-valuemin="0" aria-valuemax="<?php echo $porc ?>"><?php echo $tottres ?>%</div>
                  </div>
                  <p class="h5 mb-6">Bajas</p>
                  <div class="progress">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $totbajas ?>%;" aria-valuenow="<?php echo $totbajas ?>" aria-valuemin="0" aria-valuemax="<?php echo $porc ?>"><?php echo $totbajas ?>%</div>
                  </div>
                  <p class="h5 mb-6">Garantias no justificadas</p>
                  <div class="progress">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $totgar ?>%;" aria-valuenow="<?php echo $totgar ?>" aria-valuemin="0" aria-valuemax="<?php echo $porc ?>"><?php echo $totgar ?>%</div>
                  </div>
                  <p class="h5 mb-6">Reacondicionamientos</p>
                  <div class="progress">
                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $totreaco ?>%;" aria-valuenow="<?php echo $totreaco ?>" aria-valuemin="0" aria-valuemax="<?php echo $porc ?>"><?php echo $totreaco ?>%</div>
                  </div>
                  <p class="h5 mb-6">Mantenimiento interno</p>
                  <div class="progress">
                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $totmtto_int ?>%;" aria-valuenow="<?php echo $totmtto_int ?>" aria-valuemin="0" aria-valuemax="<?php echo $porc ?>"><?php echo $totmtto_int ?>%</div>
                  </div>
                  <p class="h5 mb-6">Mantenimiento externo</p>
                  <div class="progress">
                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $totmtto_ext ?>%;" aria-valuenow="<?php echo $totmtto_ext ?>" aria-valuemin="0" aria-valuemax="<?php echo $porc ?>"><?php echo $totmtto_ext ?>%</div>
                  </div>
                  <br></br>
                <!-- PORCENTAJE -->

                <!-- REINCIDENCIAS -->
                  <?php
                    $reincidencias = mysqli_query($conn, "SELECT *, COUNT(nim) as 'count_nim' FROM carga_dia WHERE fecha like '$mes%' AND nim <> '' AND actividad LIKE 'Visita tecnica%' AND actividad <> 'Visita tecnica por mudanza' AND tecnico = '$tectec' GROUP BY nim HAVING COUNT(nim) > 1 ORDER BY nim ");
                    while($ro = mysqli_fetch_assoc($reincidencias))
                    { if($ro['count_nim'] > 0) {
                  ?>
                    <p class="h4 mb-4 text-center">Reincidencias</p>
                    <table class="table table-responsive table-striped table-bordered table-sm table-hover" style="max-height: 40rem;">
                      <thead class="thead-dark text-center">
                        <tr>
                          <th>Tecnico</th>
                          <th>Fecha</th>
                          <th>NIM</th>
                          <th>OT</th>
                          <th>Direccion</th>
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
                          $reinci = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '$mes%' AND nim <> '' AND actividad LIKE 'Visita tecnica%' AND actividad <> 'Visita tecnica por mudanza' AND tecnico = '$tectec' GROUP BY nim HAVING COUNT(nim) > 1 ORDER BY nim ");
                          while($ro = mysqli_fetch_assoc($reinci))
                          {
                          $dupli_nim = $ro['nim'];
                        ?>
                          <?php
                            $rein = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '$mes%' AND nim = '$dupli_nim' ORDER BY id ");
                            while($row = mysqli_fetch_assoc($rein))
                            {
                          ?>
                            <tr>
                              <td><?php echo $row['tecnico']; ?></td>
                              <td><?php echo Fecha7($row['fecha']); ?></td>
                              <td><?php echo $row['nim']; ?></td>
                              <td><?php echo $row['ot']; ?></td>             
                              <td><?php echo $row['direccion']; ?></td>
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
                  <?php } else {echo '';} } ?>
                <!-- REINCIDENCIAS -->
              </div>
              <div class="col-md-4 col-12">

                  <div class="row justify-content-center">
                    
                    <!-- HORARIO -->
                      <div class="col-auto text-center">
                        <p class="h4 mb-4 text-center">Horarios</p>
                        <table class="table table-responsive table-striped table-bordered table-sm">
                          <thead class="thead-dark text-center">
                            <tr>
                              <th>Fecha</th>             
                              <th>Hora deposito</th>
                              <th>Inicio de tarea</th>
                              <th>Fin del dia</th>
                            </tr>
                          </thead>
                          <tbody align="center">
                            <?php
                              $dia_verde = 0;
                              $dia_amarillo = 0;
                              $dia_rojo1 = 0;
                              $dia_rojo2 = 0;
                              $dia_negro = 0;
                              $pppp = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '$mes%' and tecnico = '$tectec'ORDER BY fecha desc");   
                              while($row = mysqli_fetch_assoc($pppp))
                              { 
                                $aa = $row['fecha'];
                                $tomorrow = date('d', strtotime("$aa")); 
                            ?>
                            <tr>
                              <td class="bg-info"><?php echo $tomorrow; ?></td>
                              <td 
                                  <?php 
                                    $hora1 = $row['horadep'];
                                    $hora2 = "06:00:00" ;
                                    $hora3 = "07:30:00" ;
                                    $hora4 = "07:50:00" ;
                                    $hora5 = "08:05:00" ;
                                    $hora6 = "00:00:00" ;
                                    if( $hora1 > $hora2 && $hora1 <= $hora3)
                                      {
                                          $color = 'class="bg-success"';
                                          $dia_verde ++;
                                      }
                                    if( $hora1 > $hora3 && $hora1 < $hora4)
                                      {
                                          $color = 'class="bg-warning"';
                                          $dia_amarillo ++;
                                      }
                                    if( $hora1 > $hora4 && $hora1 < $hora5)
                                      {
                                          $color = 'class="bg-danger"';
                                          $dia_rojo1 ++;
                                      }
                                    if( $hora1 > $hora5 )
                                      {
                                          $color = 'class="bg-danger"';
                                          $dia_rojo2 ++;
                                      }
                                    if( $hora1 == $hora6)
                                      {
                                          $color = 'class="bg-dark"';
                                          $dia_negro ++;
                                      }
                                    echo "$color"
                                  ?> ><?php echo $row['horadep']; ?></td>   
                              <td 
                                  <?php 
                                    $hor1 = $row['horatarea'];
                                    $hor2 = "08:00:00" ;
                                    $hor3 = "08:30:00" ;
                                    $hor4 = "08:50:00" ;
                                    $hor5 = "00:00:00" ;
                                    if( $hor1 > $hor2 && $hor1 <= $hor3)
                                      {
                                          $color1 = "class=" ."bg-success" ;
                                      }
                                    if( $hor1 > $hor3 && $hor1 < $hor4)
                                      {
                                          $color1 = "class=" ."bg-warning" ;
                                      }
                                    if( $hor1 > $hor4)
                                      {
                                          $color1 = "class=" ."bg-danger" ;
                                      }
                                    if( $hor1 == $hor5)
                                      {
                                          $color1 = "class=" ."bg-dark" ;
                                      }
                                      echo "$color1";
                                  ?> ><?php echo $row['horatarea']; ?></td> 
                              <td 
                                  <?php 
                                    $ho1 = $row['fin'];
                                    $ho2 = "10:00:00" ;
                                    $ho3 = "16:30:00" ;
                                    $ho4 = "18:30:00" ;
                                    $ho5 = "00:00:00" ;
                                    if( $ho1 > $ho2 && $ho1 <= $ho3)
                                      {
                                          $color2 = "class=" ."bg-success" ;
                                      }
                                    if( $ho1 > $ho3 && $ho1 < $ho4)
                                      {
                                          $color2 = "class=" ."bg-warning" ;
                                      }
                                    if( $ho1 > $ho4)
                                      {
                                          $color2 = "class=" ."bg-danger" ;
                                      }
                                    if( $ho1 == $ho5)
                                      {
                                          $color2 = "class=" ."bg-dark" ;
                                      }
                                      echo "$color2";
                                  ?> ><?php echo $row['fin']; ?></td>                          
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-auto text-center">
                        <table class="table table-responsive table-striped table-bordered table-sm">
                          <thead class="thead-dark text-center">
                            <tr>
                              <th>7:00 - 7:30</th>             
                              <th>7:30 - 7:50</th>
                              <th>7:50 - 8:10</th>
                              <th>> 8:10</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td><?php echo $dia_verde; ?></td>
                              <td><?php echo $dia_amarillo; ?></td>
                              <td><?php echo $dia_rojo1; ?></td>
                              <td><?php echo $dia_rojo2; ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    <!-- HORARIO -->
                    <!-- MOTIVOS -->
                      <?php
                        $mot10 = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND estado = 'finalizada' AND actividad LIKE 'Instalaci%' AND codigo <> 'ADAP' GROUP BY razon_completada");
                        if(mysqli_num_rows($mot10) > 0) {
                      ?>
                        <div class="col-auto text-center">
                          <p class="h4 mb-4 text-center">Motivos</p>
                          <table class="table table-responsive table-striped table-bordered table-sm">
                            <thead class="thead-dark text-center">
                              <tr>
                                <th>Tarea</th>
                                <th>Motivo</th>
                                <th>Cantidad</th>
                              </tr>
                            </thead>
                            <tbody align="center">

                            <?php
                              $mot1 = mysqli_query($conn, "SELECT *, COUNT(razon_completada) as 'cant_razones' FROM carga_dia WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND estado = 'finalizada' AND actividad LIKE 'Instalaci%' AND codigo <> 'ADAP' GROUP BY razon_completada");
                              if(mysqli_num_rows($mot1) > 0)
                              {
                              ?>
                              <tr>
                                <td class="bg-dark text-light" colspan="3">Instalaciones</td>
                              </tr>
                              <?php
                                $mot2 = mysqli_query($conn, "SELECT *, COUNT(razon_completada) as 'cant_razones' FROM carga_dia WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND estado = 'finalizada' AND actividad LIKE 'Instalaci%' AND codigo <> 'ADAP' GROUP BY razon_completada");   
                                while($row = mysqli_fetch_assoc($mot2))
                                {
                              ?>
                                <tr>
                                  <td class="badge badge-success badge-pill">Exitosa</td>
                                  <td><?php echo utf8_encode($row['razon_completada']); ?></td>
                                  <td><?php echo $row['cant_razones']; ?></td>
                                </tr>
                              <?php } ?>
                            <?php } ?>
                            <?php
                                $mot1f = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND estado = 'no realizado' AND actividad LIKE 'Instalaci%' AND codigo <> 'ADAP' GROUP BY razon_no_completada");
                                if(mysqli_num_rows($mot1f) > 0)
                                {
                              ?>
                                <?php
                                  $mot2f = mysqli_query($conn, "SELECT *, COUNT(razon_no_completada) as 'cant_razones_f' FROM carga_dia WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND estado = 'no realizado' AND actividad LIKE 'Instalaci%' AND codigo <> 'ADAP' GROUP BY razon_no_completada");   
                                  while($row = mysqli_fetch_assoc($mot2f))
                                  {
                                ?>
                                  <tr>
                                    <td class="badge badge-danger badge-pill">Fallida</td>
                                    <td><?php echo utf8_encode($row['razon_no_completada']); ?></td>
                                    <td><?php echo $row['cant_razones_f']; ?></td>
                                  </tr>
                                <?php } ?>
                            <?php } ?>

                            <?php
                              $mot_mi1 = mysqli_query($conn, "SELECT *, COUNT(razon_completada) as 'cant_razones' FROM carga_dia WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND estado = 'finalizada' AND actividad LIKE '%cnica por mudanza interna' AND codigo <> 'ADAP' GROUP BY razon_completada");
                              if(mysqli_num_rows($mot_mi1) > 0)
                              {
                              ?>
                              <tr>
                                <td class="bg-dark text-light" colspan="3">Mudanzas internas</td>
                              </tr>
                              <?php
                                $mot_mi2 = mysqli_query($conn, "SELECT *, COUNT(razon_completada) as 'cant_razones' FROM carga_dia WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND estado = 'finalizada' AND actividad LIKE '%cnica por mudanza interna' AND codigo <> 'ADAP' GROUP BY razon_completada");   
                                while($row = mysqli_fetch_assoc($mot_mi2))
                                {
                              ?>
                                <tr>
                                  <td class="badge badge-success badge-pill">Exitosa</td>
                                  <td><?php echo utf8_encode($row['razon_completada']); ?></td>
                                  <td><?php echo $row['cant_razones']; ?></td>
                                </tr>
                              <?php } ?>
                            <?php } ?>
                            <?php
                                $mot_mi1f = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND estado = 'no realizado' AND actividad LIKE '%cnica por mudanza interna' AND codigo <> 'ADAP' GROUP BY razon_no_completada");
                                if(mysqli_num_rows($mot_mi1f) > 0)
                                {
                              ?>
                                <?php
                                  $mot_mi2f = mysqli_query($conn, "SELECT *, COUNT(razon_no_completada) as 'cant_razones_f' FROM carga_dia WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND estado = 'no realizado' AND actividad LIKE '%cnica por mudanza interna' AND codigo <> 'ADAP' GROUP BY razon_no_completada");   
                                  while($row = mysqli_fetch_assoc($mot_mi2f))
                                  {
                                ?>
                                  <tr>
                                    <td class="badge badge-danger badge-pill">Fallida</td>
                                    <td><?php echo utf8_encode($row['razon_no_completada']); ?></td>
                                    <td><?php echo $row['cant_razones_f']; ?></td>
                                  </tr>
                                <?php } ?>
                            <?php } ?>

                            <?php
                              $mot_me1 = mysqli_query($conn, "SELECT *, COUNT(razon_completada) as 'cant_razones' FROM carga_dia WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND estado = 'finalizada' AND actividad LIKE '%cnica por mudanza' AND codigo <> 'ADAP' GROUP BY razon_completada");
                              if(mysqli_num_rows($mot_me1) > 0)
                              {
                              ?>
                              <tr>
                                <td class="bg-dark text-light" colspan="3">Mudanzas externas</td>
                              </tr>
                              <?php
                                $mot_me2 = mysqli_query($conn, "SELECT *, COUNT(razon_completada) as 'cant_razones' FROM carga_dia WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND estado = 'finalizada' AND actividad LIKE '%cnica por mudanza' AND codigo <> 'ADAP' GROUP BY razon_completada");   
                                while($row = mysqli_fetch_assoc($mot_me2))
                                {
                              ?>
                                <tr>
                                  <td class="badge badge-success badge-pill">Exitosa</td>
                                  <td><?php echo utf8_encode($row['razon_completada']); ?></td>
                                  <td><?php echo $row['cant_razones']; ?></td>
                                </tr>
                              <?php } ?>
                            <?php } ?>
                            <?php
                                $mot_me1f = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND estado = 'no realizado' AND actividad LIKE '%cnica por mudanza' AND codigo <> 'ADAP' GROUP BY razon_no_completada");
                                if(mysqli_num_rows($mot_me1f) > 0)
                                {
                              ?>
                                <?php
                                  $mot_me2f = mysqli_query($conn, "SELECT *, COUNT(razon_no_completada) as 'cant_razones_f' FROM carga_dia WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND estado = 'no realizado' AND actividad LIKE '%cnica por mudanza' AND codigo <> 'ADAP' GROUP BY razon_no_completada");   
                                  while($row = mysqli_fetch_assoc($mot_me2f))
                                  {
                                ?>
                                  <tr>
                                    <td class="badge badge-danger badge-pill">Fallida</td>
                                    <td><?php echo utf8_encode($row['razon_no_completada']); ?></td>
                                    <td><?php echo $row['cant_razones_f']; ?></td>
                                  </tr>
                                <?php } ?>
                            <?php } ?>

                            <?php
                              $mot_mtto1 = mysqli_query($conn, "SELECT *, COUNT(razon_completada) as 'cant_razones_mtto' FROM carga_dia WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND estado = 'finalizada' AND actividad LIKE '%cnico al cliente' AND codigo <> 'ADAP' GROUP BY razon_completada");   
                              if(mysqli_num_rows($mot_mtto1) > 0)
                              {
                              ?>
                              <tr>
                                <td class="bg-dark text-light" colspan="3">Mantenimientos</td>
                              </tr>
                              <?php
                                $mot_mtto2 = mysqli_query($conn, "SELECT *, COUNT(razon_completada) as 'cant_razones_mtto' FROM carga_dia WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND estado = 'finalizada' AND actividad LIKE '%cnico al cliente' AND codigo <> 'ADAP' GROUP BY razon_completada");   
                                while($row = mysqli_fetch_assoc($mot_mtto2))
                                {
                              ?>
                                <tr>
                                  <td class="badge badge-success badge-pill">Exitosa</td>
                                  <td><?php echo utf8_encode($row['razon_completada']); ?></td>
                                  <td><?php echo $row['cant_razones_mtto']; ?></td>
                                </tr>
                              <?php } ?>
                            <?php } ?>
                            <?php
                                $mot_mtto1f = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND estado = 'no realizado' AND actividad LIKE '%cnico al cliente' AND codigo <> 'ADAP' GROUP BY razon_no_completada");   
                                if(mysqli_num_rows($mot_mtto1f) > 0)
                                {
                              ?>
                                <?php
                                  $mot_mtto2f = mysqli_query($conn, "SELECT *, COUNT(razon_no_completada) as 'cant_razones_mtto_f' FROM carga_dia WHERE fecha like '%$mes%' AND tecnico = '$tectec' AND estado = 'no realizado' AND actividad LIKE '%cnico al cliente' AND codigo <> 'ADAP' GROUP BY razon_no_completada");   
                                  while($row = mysqli_fetch_assoc($mot_mtto2f))
                                  {
                                ?>
                                  <tr>
                                    <td class="badge badge-danger badge-pill">Fallida</td>
                                    <td><?php echo utf8_encode($row['razon_no_completada']); ?></td>
                                    <td><?php echo $row['cant_razones_mtto_f']; ?></td>
                                  </tr>
                                <?php } ?>
                            <?php } ?>

                            <?php
                              $mot_gar1 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep BETWEEN '$mes-01' AND '$ult_dia_produ' AND tecnico = '$tectec' AND repa = 'SI' ");   
                              if(mysqli_num_rows($mot_gar1) > 0)
                              {
                              ?>
                              <tr>
                                <td class="bg-dark text-light" colspan="3">Garantias</td>
                              </tr>
                              <?php
                                $mot_gar2 = mysqli_query($conn, "SELECT *, COUNT(coment) as 'cant_razones_garant' FROM garantias WHERE fecharep BETWEEN '$mes-01' AND '$ult_dia_produ' AND tecnico = '$tectec' AND repa = 'SI' GROUP BY coment ");   
                                while($row = mysqli_fetch_assoc($mot_gar2))
                                {
                              ?>
                                <tr>
                                  <td class="badge badge-success badge-pill">Exitosa</td>
                                  <td><?php echo $row['coment']; ?></td>
                                  <td><?php echo $row['cant_razones_garant']; ?></td>
                                </tr>
                              <?php } ?>
                            <?php } ?>
                            <?php
                              $mot_gar1f = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep BETWEEN '$mes-01' AND '$ult_dia_produ' AND tecnico = '$tectec' AND repa <> 'SI' ");   
                              if(mysqli_num_rows($mot_gar1f) > 0)
                              {
                              ?>
                              <?php
                                $mot_gar2f = mysqli_query($conn, "SELECT *, COUNT(coment) as 'cant_razones_garant_f' FROM garantias WHERE fecharep BETWEEN '$mes-01' AND '$ult_dia_produ' AND tecnico = '$tectec' AND repa <> 'SI' GROUP BY coment ");   
                                while($roww = mysqli_fetch_assoc($mot_gar2f))
                                {
                              ?>
                                <tr>
                                  <td class="badge badge-danger badge-pill">Fallida</td>
                                  <td><?php echo $roww['coment']; ?></td>
                                  <td><?php echo $roww['cant_razones_garant_f']; ?></td>
                                </tr>
                              <?php } ?>
                            <?php } ?>

                            </tbody>
                          </table>
                        </div>
                      <?php } else {echo '';} ?>
                    <!-- MOTIVOS -->
                  </div>

              </div>

              <div class="col-lg-10 col-12">
                <!-- GARANTIA -->
                  <?php
                    $gar = mysqli_query($conn, "SELECT COUNT(tecnico) as 'cont_tec' FROM garantias WHERE tecnico = '$tectec' AND fecharep BETWEEN '$mes-01' AND '$ult_dia_produ' ORDER BY fecharep desc");
                    while($rowc = mysqli_fetch_assoc($gar))
                    { if($rowc['cont_tec'] > 0) {
                  ?>
                    <p class="h4 mb-4 text-center">Garantias</p>
                    <table class="table table-responsive table-striped table-bordered table-sm">
                      <thead class="thead-dark text-center">
                        <tr>
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
                          $gagaga = mysqli_query($conn, "SELECT * FROM garantias WHERE tecnico = '$tectec' AND fecharep BETWEEN '$mes-01' AND '$ult_dia_produ' ORDER BY fecharep desc");
                          while($row = mysqli_fetch_assoc($gagaga))
                          {
                        ?>
                          <tr>
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
                              <td><?php if($row['cuando'] == '0000-00-00 00:00:00'){echo '';}else{echo Fecha12($row['cuando']);}; ?></td> 
                            <?php } ?>
                            <td  data-toggle="tooltip" data-placement="top" title="<?php echo $row['obs_supervisor']; ?>"><?php echo limitar_cadena($row['obs_supervisor'], 50); ?></td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                    <br>
                  <?php } else {echo '';} } ?>
                <!-- GARANTIA -->
              </div>

              <div class="col-auto">
                <!-- GARANTIA -->
                  <?php
                    $gar_d = mysqli_query($conn, "SELECT COUNT(tecnico) as 'cont_tec' FROM garantias WHERE tecnico = '$tectec' AND fecharep BETWEEN '$mes-01' AND '$ult_dia_produ' ORDER BY fecharep desc");
                    while($rowd = mysqli_fetch_assoc($gar_d))
                    if(mysqli_num_rows($gar_d) > 0) {
                  ?>
                    <br>
                    <br>
                    <table class="table table-responsive table-striped table-bordered table-sm">
                      <tbody>
                        <?php
                          $ga_a = mysqli_query($conn, "SELECT COUNT(ot) as 'count_tecrep' FROM garantias WHERE tecnico = '$tectec' AND tecrep = '$tectec' AND fecharep BETWEEN '$mes-01' AND '$ult_dia_produ' ");
                          while($rowa = mysqli_fetch_assoc($ga_a))
                          { $g_a = $rowa['count_tecrep']; }
                          if($g_a > 0) {
                        ?>
                          <tr>
                            <th>Reparados por el tecnico</th>
                            <td><?php echo $g_a; ?></td>
                          </tr>
                        <?php } ?>

                        <?php
                          $ga_b = mysqli_query($conn, "SELECT COUNT(ot) as 'count_no_tecrep' FROM garantias WHERE tecnico = '$tectec' AND tecrep <> '$tectec' AND fecharep BETWEEN '$mes-01' AND '$ult_dia_produ' ");
                          while($rowb = mysqli_fetch_assoc($ga_b))
                          { $g_b = $rowb['count_no_tecrep']; }
                          if($g_b > 0) {
                        ?>
                          <tr>
                            <th>Reparados por otro tecnico</th>
                            <td><?php echo $g_b; ?></td>
                          </tr>
                        <?php } ?>

                        <?php
                          $ga_c = mysqli_query($conn, "SELECT COUNT(ot) as 'count_repa' FROM garantias WHERE tecnico = '$tectec' AND repa = 'Si' AND fecharep BETWEEN '$mes-01' AND '$ult_dia_produ' ");
                          while($rowc = mysqli_fetch_assoc($ga_c))
                          { $g_c = $rowc['count_repa']; }
                          if($g_c > 0) {
                        ?>
                          <tr>
                            <th>Reparadas</th>
                            <td><?php echo $g_c; ?></td>
                          </tr>
                        <?php } ?>

                        <?php
                          $ga_d = mysqli_query($conn, "SELECT COUNT(ot) as 'count_no_repa' FROM garantias WHERE tecnico = '$tectec' AND repa = 'NO' AND fecharep BETWEEN '$mes-01' AND '$ult_dia_produ' ");
                          while($rowd = mysqli_fetch_assoc($ga_d))
                          { $g_d = $rowd['count_no_repa']; }
                          if($g_d > 0) {
                        ?>
                          <tr>
                            <th>No reparadas</th>
                            <td><?php echo $g_d; ?></td>
                          </tr>
                        <?php } ?>

                        <?php
                          $ga_g = mysqli_query($conn, "SELECT COUNT(ot) as 'count_justificado' FROM garantias WHERE tecnico = '$tectec' AND justificado = 'SI' AND fecharep BETWEEN '$mes-01' AND '$ult_dia_produ' ");
                          while($rowg = mysqli_fetch_assoc($ga_g))
                          { $g_g = $rowg['count_justificado']; }
                          if($g_g > 0) {
                        ?>
                          <tr>
                            <th>Justificadas</th>
                            <td><?php echo $g_g; ?></td>
                          </tr>
                        <?php } ?>

                        <?php
                          $ga_h = mysqli_query($conn, "SELECT COUNT(ot) as 'count_no_justificado' FROM garantias WHERE tecnico = '$tectec' AND justificado = 'NO' AND fecharep BETWEEN '$mes-01' AND '$ult_dia_produ' ");
                          while($rowh = mysqli_fetch_assoc($ga_h))
                          { $g_h = $rowh['count_no_justificado']; }
                          if($g_h > 0) {
                        ?>
                          <tr>
                            <th>No justificadas</th>
                            <td><?php echo $g_h; ?></td>
                          </tr>
                        <?php } ?>

                        <?php
                          $ga_e = mysqli_query($conn, "SELECT COUNT(ot) as 'count_intervencion' FROM garantias WHERE tecnico = '$tectec' AND intervencion = 'SI' AND fecharep BETWEEN '$mes-01' AND '$ult_dia_produ' ");
                          while($rowe = mysqli_fetch_assoc($ga_e))
                          { $g_e = $rowe['count_intervencion']; }
                          if($g_e > 0) {
                        ?>
                          <tr>
                            <th>Intervenidas</th>
                            <td><?php echo $g_e; ?></td>
                          </tr>
                        <?php } ?>

                        <?php
                          $ga_f = mysqli_query($conn, "SELECT COUNT(ot) as 'count_no_intervencion' FROM garantias WHERE tecnico = '$tectec' AND intervencion = 'NO' AND fecharep BETWEEN '$mes-01' AND '$ult_dia_produ' ");
                          while($rowf = mysqli_fetch_assoc($ga_f))
                          { $g_f = $rowf['count_no_intervencion']; }
                          if($g_f > 0) {
                        ?>
                          <tr>
                            <th>No intervenidas</th>
                            <td><?php echo $g_f; ?></td>
                          </tr>
                        <?php } ?>

                        <?php
                          $ga_i = mysqli_query($conn, "SELECT COUNT(ot) as 'count_tec' FROM garantias WHERE tecnico = '$tectec' AND responsabilidad = 'Tecnico' AND fecharep BETWEEN '$mes-01' AND '$ult_dia_produ' ");
                          while($rowi = mysqli_fetch_assoc($ga_i))
                          { $g_i = $rowi['count_tec']; }
                          if($g_i > 0) {
                        ?>
                          <tr>
                            <th>Responsabilidad del tecnico</th>
                            <td><?php echo $g_i; ?></td>
                          </tr>
                        <?php } ?>

                        <?php
                          $ga_j = mysqli_query($conn, "SELECT COUNT(ot) as 'count_cliente' FROM garantias WHERE tecnico = '$tectec' AND responsabilidad = 'Cliente' AND fecharep BETWEEN '$mes-01' AND '$ult_dia_produ' ");
                          while($rowj = mysqli_fetch_assoc($ga_j))
                          { $g_j = $rowj['count_cliente']; }
                          if($g_j > 0) {
                        ?>
                          <tr>
                            <th>Responsabilidad del cliente</th>
                            <td><?php echo $g_j; ?></td>
                          </tr>
                        <?php } ?>

                        <?php
                          $ga_k = mysqli_query($conn, "SELECT COUNT(ot) as 'count_claro' FROM garantias WHERE tecnico = '$tectec' AND responsabilidad = 'Claro' AND fecharep BETWEEN '$mes-01' AND '$ult_dia_produ' ");
                          while($rowk = mysqli_fetch_assoc($ga_k))
                          { $g_k = $rowk['count_claro']; }
                          if($g_k > 0) {
                        ?>
                          <tr>
                            <th>Responsabilidad de Claro</th>
                            <td><?php echo $g_k; ?></td>
                          </tr>
                        <?php } ?>

                      </tbody>
                    </table>
                    <br>
                  <?php } else {echo '';}  ?>
                <!-- GARANTIA -->
              </div>

              <div class="col-12">
                <!-- PRODUCCION -->
                  <?php
                    $pro_tec = mysqli_query($conn, "SELECT COUNT(tecnico) as 'cont_tec', fecha FROM produccion WHERE fecha LIKE '%$mes%' AND tecnico = '$tectec' ORDER BY fecha desc");
                    while($row = mysqli_fetch_assoc($pro_tec))
                    { if($row['cont_tec'] > 0) {
                  ?>
                    <p class="h4 mb-4 text-center">Produccion</p>
                    <table class="table table-responsive table-striped table-bordered table-sm" style="max-height: 100rem;">
                      <thead class="thead-dark text-center">
                        <tr>
                          <th>OT</th>
                          <th>NIM</th>
                          <th>ID actividad</th>
                          <th>Cliente</th>
                          <th>Direccion</th>
                          <th>Localidad</th>
                          <th>Zona</th>
                          <th>Codigo</th>
                          <th>TV</th>
                          <th>Actividad</th>
                          <th>Estado</th>
                          <th>Inicio</th>
                          <th>Fin</th>
                          <th>Duracion</th>
                          <th>Cierre</th>
                          <th>Observacion</th>
                          <th>Revisita</th>
                        </tr>
                      </thead>
                      <tbody align="center">
                          
                        <?php
                          $ppp = mysqli_query($conn, "SELECT * FROM carga_dia WHERE tecnico = '$tectec' and fecha like '%$mes%' GROUP BY fecha ORDER BY fecha desc");
                          while($rowp = mysqli_fetch_assoc($ppp))
                          {
                            $fefefefe = $rowp['fecha'];
                        ?>
                          <tr>
                            <td class="bg-dark text-light" colspan="21"><?php echo Fecha11($fefefefe); ?></td>
                          </tr>
                          
                          <?php
                            $result_tasks = mysqli_query($conn, "SELECT * FROM carga_dia WHERE tecnico = '$tectec' and fecha = '$fefefefe' ORDER BY id asc");
                            while($row = mysqli_fetch_assoc($result_tasks))
                            { 
                              $color = '';

                              if(strpos($row['actividad'], 'Garantia') !== false)
                              {
                                $color= 'class="bg-warning"';
                              };

                              if($row['estado'] === 'iniciada')
                              {
                                $color= 'class="bg-danger"';
                              };
                          ?>
                            <tr <?php echo $color; ?> >
                              <td><?php echo $row['ot']; ?></td>
                              <td><?php echo $row['nim']; ?></td>
                              <td><?php echo $row['id_actividad']; ?></td>
                              <td><?php echo utf8_encode($row['cliente']); ?></td>
                              <td><?php echo utf8_encode($row['direccion']); ?></td>
                              <td><?php echo utf8_encode($row['localidad']); ?></td> 
                              <td><?php echo utf8_encode($row['zona']); ?></td>         
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
                              <td><?php echo $row['duracion']; ?></td>
                              <td><?php if($row['estado'] == 'finalizada') {echo utf8_encode($row['razon_completada']);} else {echo utf8_encode($row['razon_no_completada']);}; ?></td>
                              <td><?php echo utf8_encode($row['nota_cierre']); ?></td>
                              <td><?php echo $row['revisita']; ?></td>       
                            </tr>
                          <?php } ?>
                        
                        <?php } ?>
                      </tbody>
                    </table>
                  <?php } else {echo '';} } ?>
                  <br>
                <!-- PRODUCCION -->
              </div>

            </div>

        </div>
        <?php } ?>
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
</body>
</html>

