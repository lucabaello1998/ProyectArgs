<?php
  include("../db.php");
  session_start();
  if(!$_SESSION['nombre'])
  {
    session_destroy();
    header("location: /index.php");
    exit();
  }
  $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
  $tipo_us = $_SESSION['tipo_us'];
  $usuarios_permitidos = array("Administrador", "Despacho", "Supervisor", "Deposito", "Tecnico");
  if (in_array($tipo_us, $usuarios_permitidos))
  { $usu = 1; }
  else
  { $usu = 0; }

  if($usu != 1)
  {
    header("location: /index.php");
  }
  if($tipo_us == 'Tecnico')
  {
    $quien_consultas = $quien_notas;
  }
  else
  {
    $quien_consultas = $_SESSION['new_tec'];
  }
?>

<?php include('../include/header.php'); ?>
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
        <form action="../../Guardar/save_fecha.php" method="POST">
          <input type="hidden" name="ultima_fecha" value="<?php echo $mes; ?>">
          <input type="hidden" name="link" value="../tecnico/basic/datos.php">
          <button type="submit" name="menos" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Mes anterior">
            <i class="fa-solid fa-caret-left"></i>
          </button>
        </form>
      </div>
      <div class="col-auto align-self-center text-center text-white">
        <span class="h4"><?php echo $mes_nom; ?></span>
      </div>
      <div class="col-auto align-self-center p-0">
        <form action="../../Guardar/save_fecha.php" method="POST">
          <input type="hidden" name="ultima_fecha" value="<?php echo $mes; ?>">
          <input type="hidden" name="link" value="../tecnico/basic/datos.php">
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
      <div class="container-fluid rounded bg-white shadow p-0">

        <div class="row justify-content-center p-1">
          <div class='col-12 align-items-center p-1'>
            <?php
              if($tipo_us == 'Tecnico')
              {
                echo "<p class='h4 text-muted text-center'>$quien_consultas</p>";
              }
              else
              {
                echo "<p class='h4 text-muted text-center'>$quien_notas -> $quien_consultas</p>";
              }
            ?>
          </div>
        </div>

        <div class="row justify-content-md-center p-2 m-2">
          <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <div class="col-md-6 col-6 align-items-center p-1" id="nav-exitosas-tab" data-toggle="tab" data-target="#nav-exitosas" type="button" role="tab" aria-controls="nav-exitosas" aria-selected="true">
                <div class="row rounded bg-white shadow m-1 border border-success">
                  <div class="col-12 p-2">
                    <p class="h4 text-muted text-center">Exitosas</p>
                    <?php
                      $exi = mysqli_query($conn, "SELECT SUM(tcumplida + tareasmtto) as 'exi' FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$quien_consultas'");
                      while($row = mysqli_fetch_assoc($exi))
                      {  $exxitos= $row['exi']; }
                    ?>
                    <p class="h5 text-muted text-center"><?php echo $exxitos; ?></p>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-6 align-items-center p-1" id="nav-fallidas-tab" data-toggle="tab" data-target="#nav-fallidas" type="button" role="tab" aria-controls="nav-fallidas" aria-selected="false">
                <div class="row rounded bg-white shadow m-1 border border-danger">
                  <div class="col-12 p-2">
                    <p class="h4 text-left text-muted text-center">Fallidas</p>
                    <?php
                      $fallid = mysqli_query($conn, "SELECT SUM(bajas + bajatec) as 'fall' FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$quien_consultas'");
                      while($row = mysqli_fetch_assoc($fallid))
                      { $falli= $row['fall']; }
                    ?>
                    <p class="h5 text-muted text-center"><?php echo $falli; ?></p>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-6 align-items-center p-1" id="nav-garantias-tab" data-toggle="tab" data-target="#nav-garantias" type="button" role="tab" aria-controls="nav-garantias" aria-selected="false">
                <div class="row rounded bg-white shadow m-1 border border-warning">
                  <div class="col-12 p-2">
                    <p class="h4 text-left text-muted text-center">Garantias</p>
                    <?php
                      $garan = mysqli_query($conn, "SELECT SUM(garantec) as 'garantecni' FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$quien_consultas'");
                      while($row = mysqli_fetch_assoc($garan))
                      { $garantecni= $row['garantecni']; }
                    ?>
                    <p class="h5 text-muted text-center"><?php echo $garantecni; ?></p>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-6 align-items-center p-1" id="nav-asistencias-tab" data-toggle="tab" data-target="#nav-asistencias" type="button" role="tab" aria-controls="nav-asistencias" aria-selected="false">
                <div class="row rounded bg-white shadow m-1 border border-info">
                  <div class="col-12 p-2">
                    <p class="h4 text-left text-muted text-center">Días</p>
                    <?php
                      $diass = mysqli_query($conn, "SELECT COUNT(*) as 'cont_dias' FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$quien_consultas' AND (dia = 'Feriado' OR dia = 'Sabado' OR dia = 'Normal') ");
                      while($row = mysqli_fetch_assoc($diass))
                      { $cont_dias = $row['cont_dias']; }
                    ?>
                    <p class="h5 text-muted text-center"><?php echo $cont_dias; ?></p>
                  </div>
                </div>
              </div>
              <div class="col-md-12 col-12 align-items-center p-1" id="nav-otros-tab" data-toggle="tab" data-target="#nav-otros" type="button" role="tab" aria-controls="nav-otros" aria-selected="false">
                <a class="row rounded bg-white shadow m-1 border border-muted">
                  <div class="col-12 p-2">
                    <p class="h4 text-left text-muted text-center">Otros</p>
                  </div>
                </a>
              </div>
            </div>
          </nav>
        </div>

        <div class="row p-2 m-2">
          <div class="col-12">

            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="nav-exitosas" role="tabpanel" aria-labelledby="nav-exitosas-tab">
                <div class="row justify-content-center p-1">
                  <div class='col-12 align-items-center p-1'>
                    <p class="h5 text-center text-muted">Tareas exitosas</p>
                    <canvas id="analisis_exitosas_ins" style="height:25vh; width:40vw"></canvas>
                    <?php
                      $detalle_tareas = mysqli_query($conn, "SELECT SUM(dosplay) as 'dospl', SUM(tresplay) as 'trespl', SUM(stb) as 'stbtec', SUM(mtto_int) as 'mtto_int_t', SUM(mtto_ext) as 'mtto_ext_t', SUM(mtto_reaco) as 'mtto_reaco_t', FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$quien_consultas' ");
                      while($rowe = mysqli_fetch_assoc($detalle_tareas))
                      {
                    ?>
                      <p class="h6 text-muted text-left ml-2">2 play: <small><?php echo Fecha4($rowe['dospl']); ?></small></p>
                      <p class="h6 text-muted text-left ml-2">3 play: <small><?php echo $rowe['trespl']; ?></small></p>
                      <p class="h6 text-muted text-left ml-2">STB: <small><?php echo $rowe['stbtec']; ?></small></p>
                      <p class="h6 text-muted text-left ml-2">Mtto interno: <small><?php echo $rowe['mtto_int']; ?></small></p>
                      <p class="h6 text-muted text-left ml-2">Mtto externo: <small><?php echo $rowe['mtto_ext_t']; ?></small></p>
                      <p class="h6 text-muted text-left ml-2">Reacondicionamiento: <small><?php echo $rowe['mtto_reaco_t']; ?></small></p>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="nav-fallidas" role="tabpanel" aria-labelledby="nav-fallidas-tab">
                <div class="row justify-content-center p-1">
                  <div class='col-12 align-items-center p-1'>
                    <p class="h5 text-center text-muted">Tareas fallidas</p>
                    <canvas id="analisis_fallidas_ins" style="height:25vh; width:40vw"></canvas>
                    <?php
                      $fallidas_tareas = mysqli_query($conn, "SELECT SUM(bajas) as 'baj', SUM(bajatec) as 'bajtec' FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$quien_consultas' ");
                      while($rowb = mysqli_fetch_assoc($fallidas_tareas))
                      {
                    ?>
                      <p class="h6 text-muted text-left ml-2">Tareas fallidas: <small><?php echo $rowb['baj']; ?></small></p>
                      <p class="h6 text-muted text-left ml-2">Bajas tecnicas: <small><?php echo $rowb['bajtec']; ?></small></p>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="nav-garantias" role="tabpanel" aria-labelledby="nav-garantias-tab">
                <div class="row justify-content-center p-1">
                  <div class='col-auto align-items-center p-1'>
                    <p class="h5 text-center text-muted">Garantias</p>
                    <table class="table table-responsive table-striped table-bordered table-sm">
                      <thead class="thead-dark text-center">
                        <tr>
                          <th><small>OT</small></th>
                          <th><small>Direccion</small></th>
                          <th><small>Fecha instalacion</small></th>
                          <th><small>Fecha reparacion</small></th>
                          <th><small>Reparado por</small></th>
                          <th><small>Responsabilidad</small></th>
                          <th><small>Motivo de cierre</small></th>
                          <th><small>Notas</small></th>
                        </tr>
                      </thead>
                      <tbody align="center">
                        <?php
                          $garantias = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep LIKE '%$mes%' AND tecnico = '$quien_consultas' ORDER BY fecharep desc");
                          while($row = mysqli_fetch_assoc($garantias))
                          {
                        ?>
                          <tr>
                            <td><small><?php echo $row['ot']; ?></small></td>
                            <td><small><?php echo $row['direccion']; ?></small></td>
                            <td><small><?php echo Fecha7($row['fechaint']); ?></small></td>
                            <td><small><?php echo Fecha7($row['fecharep']); ?></small></td>
                            <td><small><?php echo $row['tecrep']; ?></small></td>
                            <td><small><?php echo $row['responsabilidad']; ?></small></td>
                            <td><small><?php echo $row['coment']; ?></small></td>
                            <td data-toggle="tooltip" data-placement="top" title="<?php echo $row['obs']; ?>"><small><?php echo limitar_cadena($row['obs'], 30); ?></small></td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="nav-asistencias" role="tabpanel" aria-labelledby="nav-asistencias-tab">
                <div class="row justify-content-center p-1">
                  <div class='col-auto align-items-center p-1'>
                    <p class="h5 text-center text-muted">Asistencias</p>
                    <table class="table table-responsive table-striped table-bordered table-sm">
                      <thead class="thead-dark text-center">
                        <tr>
                          <th><small>Fecha</small></th>             
                          <th><small>Hora deposito</small></th>
                          <th><small>Inicio de tarea</small></th>
                          <th><small>Fin del dia</small></th>
                        </tr>
                      </thead>
                      <tbody align="center">
                        <?php
                          $dia_verde = 0;
                          $dia_amarillo = 0;
                          $dia_rojo1 = 0;
                          $dia_rojo2 = 0;
                          $dia_negro = 0;
                          $pppp = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '$mes%' and tecnico = '$quien_consultas'ORDER BY fecha desc");   
                          while($row = mysqli_fetch_assoc($pppp))
                          { 
                            $aa = $row['fecha'];
                            $tomorrow = date('d', strtotime("$aa")); 
                        ?>
                        <tr>
                          <?php
                            switch($row['dia'])
                            {
                              case 'Normal' : $dia_color = 'bg-light';
                              break;
                              case 'Ausente' : $dia_color = 'bg-dark text-light';
                              break;
                              case 'Sabado' : $dia_color = 'bg-info';
                              break;
                              case 'Feriado' : $dia_color = 'bg-info';
                              break;
                              case 'Vacaciones' : $dia_color = 'bg-primary';
                              break;
                              case 'Dia libre' : $dia_color = 'bg-primary';
                              break;
                              case 'Licencia' : $dia_color = 'bg-primary';
                              break;
                              case 'Suspension' : $dia_color = 'bg-dark text-light';
                              break;
                              case 'Vehiculo roto' : $dia_color = 'bg-primary';
                              break;
                            }
                          ?>
                          <td class="<?php echo $dia_color; ?>"><small><?php echo $tomorrow; ?></small></td>
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
                                      $color = 'class="bg-dark text-light"';
                                      $dia_negro ++;
                                  }
                                echo "$color"
                              ?> ><small><?php echo $row['horadep']; ?></small></td>   
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
                                      $color1 = 'class="bg-dark text-light"' ;
                                  }
                                  echo "$color1";
                              ?> ><small><?php echo $row['horatarea']; ?></small></td> 
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
                                      $color2 = 'class="bg-dark text-light"' ;
                                  }
                                  echo "$color2";
                              ?> ><small><?php echo $row['fin']; ?></small></td>                          
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="nav-otros" role="tabpanel" aria-labelledby="nav-otros-tab">
                <div class="row justify-content-center p-1">
                  <div class='col-auto align-items-center p-1'>
                  <?php
                    $cons_tec = mysqli_query($conn, "SELECT * FROM tecnicos WHERE tecnico = '$quien_consultas' ");
                    while($row = mysqli_fetch_assoc($cons_tec))
                    {
                  ?>
                    <p class="h6 text-muted text-left ml-2">Ingreso: <small><?php echo Fecha4($row['ingreso']); ?></small></p>
                    <p class="h6 text-muted text-left ml-2">DNI: <small><?php echo $row['dni']; ?></small></p>
                    <p class="h6 text-muted text-left ml-2">TOA usuario: <small><?php echo $row['tusu']; ?></small></p>
                    <p class="h6 text-muted text-left ml-2">TOA contraseña: <small><?php echo $row['tcon']; ?></small></p>
                    <p class="h6 text-muted text-left ml-2">SGT usuario: <small><?php echo $row['sgtusu']; ?></small></p>
                    <p class="h6 text-muted text-left ml-2">SGT contraseña: <small><?php echo $row['sgtcon']; ?></small></p>
                    <p class="h6 text-muted text-left ml-2">Zapatos: <small><?php echo $row['zapato']; ?></small></p>
                    <p class="h6 text-muted text-left ml-2">Pantalon: <small><?php echo $row['pantalon']; ?></small></p>
                    <p class="h6 text-muted text-left ml-2">Chomba/Campera: <small><?php echo $row['chomba']; ?></small></p>
                  <?php } ?>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>
  <script src="/chart/dist/chart.js"></script>
  <!-- EXITOSAS -->
    <script>
      const config_a = {
        type: 'line',
        data: {
              labels: [
                        <?php
                          $aa_tas = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$quien_consultas' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($aa_tas))
                          { echo "'" .Fecha11($row['fecha']) ."',"; }
                        ?>
                      ],
              datasets: 
              [
                {
                  label: '2 Play',
                  data: [
                          <?php
                            $a2 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$quien_consultas' GROUP BY fecha");
                            while($row = mysqli_fetch_assoc($a2))
                            {
                              $fecha_a2 = $row['fecha'];

                              $a2_b = mysqli_query($conn, "SELECT SUM(dosplay) as 'a_dosplay' FROM produccion WHERE fecha = '$fecha_a2' AND tecnico = '$quien_consultas'");
                              while($rob = mysqli_fetch_assoc($a2_b))
                              { echo "'" .$rob['a_dosplay'] ."'," ; }

                            }
                          ?>
                        ],
                  backgroundColor: ['rgba(33, 158, 188, 0.7)'],
                  borderColor: ['rgba(33, 158, 188, 0.5)',],
                  tension: 0.2
                },
                {
                  label: '3 Play',
                  data: [
                          <?php
                            $a3 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$quien_consultas' GROUP BY fecha");
                            while($row = mysqli_fetch_assoc($a3))
                            {
                              $fecha_a3 = $row['fecha'];

                              $a3_c = mysqli_query($conn, "SELECT SUM(tresplay) as 'a_tresplay' FROM produccion WHERE fecha = '$fecha_a3' AND tecnico = '$quien_consultas'");
                              while($roc = mysqli_fetch_assoc($a3_c))
                              { echo "'" .$roc['a_tresplay'] ."'," ; }

                            }
                          ?>
                        ],
                  backgroundColor: ['rgba(241, 91, 181, 0.7)'],
                  borderColor: ['rgba(241, 91, 181, 0.5)',],
                  tension: 0.2
                },
                {
                  label: 'STB',
                  data: [
                          <?php
                            $a4 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$quien_consultas' GROUP BY fecha");
                            while($row = mysqli_fetch_assoc($a4))
                            {
                              $fecha_a4 = $row['fecha'];

                              $a4_d = mysqli_query($conn, "SELECT SUM(stb) as 'a_stb' FROM produccion WHERE fecha = '$fecha_a4' AND tecnico = '$quien_consultas'");
                              while($rod = mysqli_fetch_assoc($a4_d))
                              { echo "'" .$rod['a_stb'] ."'," ; }

                            }
                          ?>
                        ],
                  backgroundColor: ['rgba(128, 237, 153, 0.7)'],
                  borderColor: ['rgba(128, 237, 153, 0.5)',],
                  tension: 0.2
                },
                {
                  label: 'Mtto interno',
                  data: [
                          <?php
                            $a5 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$quien_consultas' GROUP BY fecha");
                            while($row = mysqli_fetch_assoc($a5))
                            {
                              $fecha_a5 = $row['fecha'];

                              $a5_e = mysqli_query($conn, "SELECT SUM(mtto_int) as 'a_mtto_int' FROM produccion WHERE fecha = '$fecha_a5' AND tecnico = '$quien_consultas'");
                              while($roe = mysqli_fetch_assoc($a5_e))
                              { echo "'" .$roe['a_mtto_int'] ."'," ; }

                            }
                          ?>
                        ],
                  backgroundColor: ['rgba(251, 133, 0, 0.7)'],
                  borderColor: ['rgba(251, 133, 0, 0.5)',],
                  tension: 0.2
                },
                {
                  label: 'Mtto externo',
                  data: [
                          <?php
                            $a6 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$quien_consultas' GROUP BY fecha");
                            while($row = mysqli_fetch_assoc($a6))
                            {
                              $fecha_a6 = $row['fecha'];

                              $a6_f = mysqli_query($conn, "SELECT SUM(mtto_ext) as 'a_mtto_ext' FROM produccion WHERE fecha = '$fecha_a6' AND tecnico = '$quien_consultas'");
                              while($rof = mysqli_fetch_assoc($a6_f))
                              { echo "'" .$rof['a_mtto_ext'] ."'," ; }

                            }
                          ?>
                        ],
                  backgroundColor: ['rgba(255, 89, 94, 0.7)'],
                  borderColor: ['rgba(255, 89, 94, 0.5)',],
                  tension: 0.2
                },
                {
                  label: 'Reacondicionamiento',
                  data: [
                          <?php
                            $a7 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$quien_consultas' GROUP BY fecha");
                            while($row = mysqli_fetch_assoc($a7))
                            {
                              $fecha_a7 = $row['fecha'];

                              $a7_g = mysqli_query($conn, "SELECT SUM(mtto_reaco) as 'a_mtto_reaco' FROM produccion WHERE fecha = '$fecha_a7' AND tecnico = '$quien_consultas'");
                              while($rog = mysqli_fetch_assoc($a7_g))
                              { echo "'" .$rog['a_mtto_reaco'] ."'," ; }

                            }
                          ?>
                        ],
                  backgroundColor: ['rgba(120, 40, 140, 0.7)'],
                  borderColor: ['rgba(120, 40, 140, 0.5)',],
                  tension: 0.2
                }, 
              ]
          },
        options: {responsive:true,}
      };
      const graficos_a = new Chart(
        document.getElementById('analisis_exitosas_ins'),
        config_a
      );
    </script>
  <!-- EXITOSAS -->
  <!-- FALLIDAS -->
    <script>
      const config_b = {
        type: 'line',
        data: {
              labels: [
                        <?php
                          $ab_tas = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$quien_consultas' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($ab_tas))
                          { echo "'" .Fecha11($row['fecha']) ."',"; }
                        ?>
                      ],
              datasets: 
              [
                {
                  label: 'Fallidas',
                  data: [
                          <?php
                            $b2 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$quien_consultas' GROUP BY fecha");
                            while($row = mysqli_fetch_assoc($b2))
                            {
                              $fecha_b2 = $row['fecha'];

                              $b2_b = mysqli_query($conn, "SELECT SUM(bajas) as 'a_bajas' FROM produccion WHERE fecha = '$fecha_b2' AND tecnico = '$quien_consultas'");
                              while($rob = mysqli_fetch_assoc($b2_b))
                              { echo "'" .$rob['a_bajas'] ."'," ; }

                            }
                          ?>
                        ],
                  backgroundColor: ['rgba(33, 158, 188, 0.7)'],
                  borderColor: ['rgba(33, 158, 188, 0.5)',],
                  tension: 0.2
                },
                {
                  label: 'Bajas tecnicas',
                  data: [
                          <?php
                            $b3 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tecnico = '$quien_consultas' GROUP BY fecha");
                            while($row = mysqli_fetch_assoc($b3))
                            {
                              $fecha_b3 = $row['fecha'];

                              $b3_c = mysqli_query($conn, "SELECT SUM(bajatec) as 'a_bajatec' FROM produccion WHERE fecha = '$fecha_b3' AND tecnico = '$quien_consultas'");
                              while($roc = mysqli_fetch_assoc($b3_c))
                              { echo "'" .$roc['a_bajatec'] ."'," ; }

                            }
                          ?>
                        ],
                  backgroundColor: ['rgba(241, 91, 181, 0.7)'],
                  borderColor: ['rgba(241, 91, 181, 0.5)',],
                  tension: 0.2
                },
              ]
          },
        options: {responsive:true,}
      };
      const graficos_b = new Chart(
        document.getElementById('analisis_fallidas_ins'),
        config_b
      );
    </script>
  <!-- FALLIDAS -->
  </body>
</html>