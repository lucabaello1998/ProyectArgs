<?php
  include("../db.php");
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
  $nombre = $_SESSION['nombre'];
  $apellido = $_SESSION['apellido'];

  include('../includes/header.php');
?>
<style>
  @media screen and (max-width: 575px)
  {
    table
    {
      max-height: 35rem; 
    }
    #analisis_mtto_ins
    {
      height: 40vh;
      width:40vw;
    }
    #analisis_mtto_tec
    {
      height: 40vh;
      width:40vw;
    }
    #analisis_mtto_mot
    {
      height: 40vh;
      width:40vw;
    }
  }
</style>
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
          <input type="hidden" name="link" value="../Analisis/a_mtto.php">
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
          <input type="hidden" name="link" value="../Analisis/a_mtto.php">
          <button type="submit" name="mas" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Mes siguiente">
            <i class="fa-solid fa-caret-right"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
<!-- FECHA -->
<div class="container rounded bg-white shadow p-2">
  <div class="row justify-content-center p-0 m-0">
    <ul class="nav nav-pills" id="pills-tab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active btn-outline-dark" id="pills-total-tab" data-toggle="pill" data-target="#pills-total" type="button" role="tab" aria-controls="pills-total" aria-selected="true">Total</button>
      </li>
      <?php
        $a = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY zona");
        while($row = mysqli_fetch_assoc($a))
        {
          $zona = $row['zona'];
          switch ($zona)
          {
            case 'Lomas de Zamora': $zona_abre = 'lz';
            break;
            case 'Jose Leon Suarez': $zona_abre = 'jls';
            break;
            case 'San Nicolas': $zona_abre = 'sn';
            break;
          }
      ?>
        <li class="nav-item" role="presentation">
          <button class="nav-link  btn-outline-dark" id="pills-<?php echo $zona_abre; ?>-tab" data-toggle="pill" data-target="#pills-<?php echo $zona_abre; ?>" type="button" role="tab" aria-controls="pills-<?php echo $zona_abre; ?>" aria-selected="false"><?php echo $zona; ?></button>
        </li>
      <?php } ?>
    </ul>
  </div>
</div>
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active p-0 m-0" id="pills-total" role="tabpanel" aria-labelledby="pills-total-tab">

        <div class="container-fluid pr-4 pl-4 pt-0 pb-0">
          <div class="row pr-2 pl-2 pt-0 pb-0">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
              <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #06D6A0 !important;">
                <div class="col-12 p-2">
                  <?php
                    $a_tot = mysqli_query($conn, "SELECT SUM(tareasmtto) as 'a_mtto' FROM produccion WHERE fecha like '%$mes%'");
                    while($roa = mysqli_fetch_assoc($a_tot))
                    { $a_mtto = $roa['a_mtto']; }
                  ?>
                  <p class="h2 text-muted text-center"><?php echo $a_mtto; ?></p>
                  <p class="h4 text-muted text-center">Total</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
              <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #EF476F !important;">
                <div class="col-12 p-2">
                  <?php
                    $a_2 = mysqli_query($conn, "SELECT SUM(mtto_reaco) as 'a_mtto_reaco' FROM produccion WHERE fecha like '%$mes%'");
                    while($roa = mysqli_fetch_assoc($a_2))
                    { $a_mtto_reaco = $roa['a_mtto_reaco']; }
                  ?>
                  <p class="h2 text-muted text-center"><?php echo $a_mtto_reaco; ?></p>
                  <p class="h4 text-muted text-center">Reacondicionamiento</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
              <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #1B9AAA !important;">
                <div class="col-12 p-2">
                  <?php
                    $a_3 = mysqli_query($conn, "SELECT SUM(mtto_int) as 'a_mtto_int' FROM produccion WHERE fecha like '%$mes%'");
                    while($roa = mysqli_fetch_assoc($a_3))
                    { $a_mtto_int = $roa['a_mtto_int']; }
                  ?>
                  <p class="h2 text-muted text-center"><?php echo $a_mtto_int; ?></p>
                  <p class="h4 text-muted text-center">Mtto interno</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
              <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #FFC43D !important;">
                <div class="col-12 p-2">
                  <?php
                    $a_ssttbb = mysqli_query($conn, "SELECT SUM(mtto_ext) as 'a_mtto_ext' FROM produccion WHERE fecha like '%$mes%'");
                    while($roa = mysqli_fetch_assoc($a_ssttbb))
                    { $a_mtto_ext = $roa['a_mtto_ext']; }
                  ?>
                  <p class="h2 text-muted text-center"><?php echo $a_mtto_ext; ?></p>
                  <p class="h4 text-muted text-center">Mtto externo</p>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="container-fluid pr-4 pl-4 pt-0 pb-0">
          <div class="row pr-2 pl-2 pt-0 pb-0">
            <div class="col-12 p-0">
              <div class="row rounded bg-white shadow m-1 p-2">
                <div class="col-12 p-0">
                  <p class="text-center text-muted h5">Instalaciones</p>
                </div>
                <div class="col-12 p-0">
                  <canvas id="analisis_mtto_ins" style="height:25vh; width:40vw"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="container-fluid pr-4 pl-4 pt-0 pb-0">
          <div class="row pr-2 pl-2 pt-0 pb-0">
            <div class="col-md-3 col-12 p-0">
              <div class="row rounded bg-white shadow m-1 p-2">
                <div class="col-auto p-0 mx-auto">
                  <table class="table table-striped table-bordered table-md table-sm table-responsive">
                    <thead class="thead-dark text-center">
                      <tr>
                        <th>Tecnico</th>
                        <th data-toggle="tooltip" data-placement="bottom" title="Cantidad de mtto en el mes">Cant</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $b1 = mysqli_query($conn, "SELECT SUM(tareasmtto) as 'tar_mtto', tecnico FROM produccion  WHERE fecha like '%$mes%' GROUP BY tecnico ORDER BY tecnico asc");  
                        while($row = mysqli_fetch_assoc($b1))
                        { $tec = $row['tecnico']; ?>
                        <tr>
                          <td><?php echo $tec; ?></td>
                          <td align="center"><?php echo $row['tar_mtto']; ?></td>
                        </tr>        
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-9 col-12 p-0">
              <div class="row rounded bg-white shadow m-1 p-2">
                <div class="col-12 p-0">
                  <p class="text-center text-muted h5">Tecnicos</p>
                </div>
                <div class="col-12 p-0">
                  <canvas id="analisis_mtto_tec" style="height:35vh; width:40vw"></canvas>
                </div>
              </div>
              <div class="row rounded bg-white shadow m-1 p-2">
                <div class="col-12 p-0">
                  <p class="text-center text-muted h5">Motivos</p>
                </div>
                <div class="col-12 p-0">
                  <canvas id="analisis_mtto_mot" style="height:35vh; width:40vw"></canvas>
                </div>
              </div>
              
            </div>
          </div>
        </div>

      </div>

      <?php
        $aa = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY zona");
        while($row = mysqli_fetch_assoc($aa))
        {
          $zona = $row['zona'];
          switch ($zona)
          {
            case 'Lomas de Zamora': $zona_abre = 'lz';
            break;
            case 'Jose Leon Suarez': $zona_abre = 'jls';
            break;
            case 'San Nicolas': $zona_abre = 'sn';
            break;
          }
      ?>
      <div class="tab-pane fade" id="pills-<?php echo $zona_abre; ?>" role="tabpanel" aria-labelledby="pills-<?php echo $zona_abre; ?>-tab">
        <div class="container-fluid pr-4 pl-4 pt-0 pb-0">
          <div class="row pr-2 pl-2 pt-0 pb-0">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
              <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #06D6A0 !important;">
                <div class="col-12 p-2">
                  <?php
                    $a_tot = mysqli_query($conn, "SELECT SUM(tareasmtto) as 'a_mtto' FROM produccion WHERE fecha like '%$mes%' AND zona = '$zona'");
                    while($roa = mysqli_fetch_assoc($a_tot))
                    { $a_mtto = $roa['a_mtto']; }
                  ?>
                  <p class="h2 text-muted text-center"><?php echo $a_mtto; ?></p>
                  <p class="h4 text-muted text-center">Total</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
              <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #EF476F !important;">
                <div class="col-12 p-2">
                  <?php
                    $a_2 = mysqli_query($conn, "SELECT SUM(mtto_reaco) as 'a_mtto_reaco' FROM produccion WHERE fecha like '%$mes%' AND zona = '$zona'");
                    while($roa = mysqli_fetch_assoc($a_2))
                    { $a_mtto_reaco = $roa['a_mtto_reaco']; }
                  ?>
                  <p class="h2 text-muted text-center"><?php echo $a_mtto_reaco; ?></p>
                  <p class="h4 text-muted text-center">Reacondicionamiento</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
              <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #1B9AAA !important;">
                <div class="col-12 p-2">
                  <?php
                    $a_3 = mysqli_query($conn, "SELECT SUM(mtto_int) as 'a_mtto_int' FROM produccion WHERE fecha like '%$mes%' AND zona = '$zona'");
                    while($roa = mysqli_fetch_assoc($a_3))
                    { $a_mtto_int = $roa['a_mtto_int']; }
                  ?>
                  <p class="h2 text-muted text-center"><?php echo $a_mtto_int; ?></p>
                  <p class="h4 text-muted text-center">Mtto interno</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
              <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #FFC43D !important;">
                <div class="col-12 p-2">
                  <?php
                    $a_ssttbb = mysqli_query($conn, "SELECT SUM(mtto_ext) as 'a_mtto_ext' FROM produccion WHERE fecha like '%$mes%' AND zona = '$zona'");
                    while($roa = mysqli_fetch_assoc($a_ssttbb))
                    { $a_mtto_ext = $roa['a_mtto_ext']; }
                  ?>
                  <p class="h2 text-muted text-center"><?php echo $a_mtto_ext; ?></p>
                  <p class="h4 text-muted text-center">Mtto externo</p>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="container-fluid pr-4 pl-4 pt-0 pb-0">
          <div class="row pr-2 pl-2 pt-0 pb-0">
            <div class="col-12 p-0">
              <div class="row rounded bg-white shadow m-1 p-2">
                <div class="col-12 p-0">
                  <p class="text-center text-muted h5">Instalaciones</p>
                </div>
                <div class="col-12 p-0">
                  <canvas id="analisis_mtto_ins_<?php echo $zona_abre; ?>" style="height:25vh; width:40vw"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="container-fluid pr-4 pl-4 pt-0 pb-0">
          <div class="row pr-2 pl-2 pt-0 pb-0">
            <div class="col-md-3 col-12 p-0">
              <div class="row rounded bg-white shadow m-1 p-2">
                <div class="col-auto p-0 mx-auto">
                  <table class="table table-striped table-bordered table-md table-sm table-responsive">
                    <thead class="thead-dark text-center">
                      <tr>
                        <th>Tecnico</th>
                        <th data-toggle="tooltip" data-placement="bottom" title="Cantidad de mtto en el mes">Cant</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $b1 = mysqli_query($conn, "SELECT SUM(tareasmtto) as 'tar_mtto', tecnico FROM produccion  WHERE fecha like '%$mes%' AND zona = '$zona' GROUP BY tecnico ORDER BY tecnico asc");  
                        while($row = mysqli_fetch_assoc($b1))
                        { $tec = $row['tecnico']; ?>
                        <tr>
                          <td><?php echo $tec; ?></td>
                          <td align="center"><?php echo $row['tar_mtto']; ?></td>
                        </tr>        
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-9 col-12 p-0">
              <div class="row rounded bg-white shadow m-1 p-2">
                <div class="col-12 p-0">
                  <p class="text-center text-muted h5">Tecnicos</p>
                </div>
                <div class="col-12 p-0">
                  <canvas id="analisis_mtto_tec_<?php echo $zona_abre; ?>" style="height:35vh; width:40vw"></canvas>
                </div>
              </div>
              <div class="row rounded bg-white shadow m-1 p-2">
                <div class="col-12 p-0">
                  <p class="text-center text-muted h5">Motivos</p>
                </div>
                <div class="col-12 p-0">
                  <canvas id="analisis_mtto_mot_<?php echo $zona_abre; ?>" style="height:35vh; width:40vw"></canvas>
                </div>
              </div>
              
            </div>
          </div>
        </div>
      </div>
      <?php } ?>

    </div>

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
<script src="/chart/dist/chart.js"></script>
<!-- TOTAL MTTO -->
  <script>
    const config_b_mtto_ins = {
      type: 'line',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .Fecha11($row['fecha']) ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total Mtto',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $fecha_a1 = $row['fecha'];

                            $a1_a = mysqli_query($conn, "SELECT SUM(tareasmtto) as 'a_mtto' FROM produccion WHERE fecha = '$fecha_a1'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_mtto'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(6, 214, 160, 0.7)'],
                borderColor: ['rgba(6, 214, 160, 0.5)',],
                tension: 0.2
              },
              {
                label: 'Reacondicinamiento',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $fecha_a2 = $row['fecha'];

                            $a2_b = mysqli_query($conn, "SELECT SUM(mtto_reaco) as 'a_mtto_reaco' FROM produccion WHERE fecha = '$fecha_a2'");
                            while($rob = mysqli_fetch_assoc($a2_b))
                            { echo "'" .$rob['a_mtto_reaco'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(239, 71, 111, 0.7)'],
                borderColor: ['rgba(239, 71, 111, 0.5)',],
                tension: 0.2
              },
              {
                label: 'Mtto interno',
                data: [
                        <?php
                          $a3 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a3))
                          {
                            $fecha_a3 = $row['fecha'];

                            $a3_c = mysqli_query($conn, "SELECT SUM(mtto_int) as 'a_mtto_int' FROM produccion WHERE fecha = '$fecha_a3'");
                            while($roc = mysqli_fetch_assoc($a3_c))
                            { echo "'" .$roc['a_mtto_int'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(27, 154, 170, 0.7)'],
                borderColor: ['rgba(27, 154, 170, 0.5)',],
                tension: 0.2
              },
              {
                label: 'Mtto externo',
                data: [
                        <?php
                          $a4 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a4))
                          {
                            $fecha_a4 = $row['fecha'];

                            $a4_d = mysqli_query($conn, "SELECT SUM(mtto_ext) as 'a_mtto_ext' FROM produccion WHERE fecha = '$fecha_a4'");
                            while($rod = mysqli_fetch_assoc($a4_d))
                            { echo "'" .$rod['a_mtto_ext'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(255, 196, 61, 0.7)'],
                borderColor: ['rgba(255, 196, 61, 0.5)',],
                tension: 0.2
              },
            ]
        },
      options: {responsive:true,}
    };
    const graficos_b_mtto_ins = new Chart(
      document.getElementById('analisis_mtto_ins'),
      config_b_mtto_ins
    );
  </script>
<!-- TOTAL MTTO -->
<!-- TOTAL LZ -->
  <script>
    const config_mtto_ins_lz = {
      type: 'line',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tareasmtto > 0 AND zona ='Lomas de Zamora' GROUP BY fecha");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .Fecha11($row['fecha']) ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total Mtto',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tareasmtto > 0 AND zona ='Lomas de Zamora' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $fecha_a1 = $row['fecha'];

                            $a1_a = mysqli_query($conn, "SELECT SUM(tareasmtto) as 'a_mtto' FROM produccion WHERE fecha = '$fecha_a1' AND zona ='Lomas de Zamora'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_mtto'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(6, 214, 160, 0.7)'],
                borderColor: ['rgba(6, 214, 160, 0.5)',],
                tension: 0.2
              },
              {
                label: 'Reacondicinamiento',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tareasmtto > 0 AND zona ='Lomas de Zamora' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $fecha_a2 = $row['fecha'];

                            $a2_b = mysqli_query($conn, "SELECT SUM(mtto_reaco) as 'a_mtto_reaco' FROM produccion WHERE fecha = '$fecha_a2' AND zona ='Lomas de Zamora'");
                            while($rob = mysqli_fetch_assoc($a2_b))
                            { echo "'" .$rob['a_mtto_reaco'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(239, 71, 111, 0.7)'],
                borderColor: ['rgba(239, 71, 111, 0.5)',],
                tension: 0.2
              },
              {
                label: 'Mtto interno',
                data: [
                        <?php
                          $a3 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tareasmtto > 0 AND zona ='Lomas de Zamora' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a3))
                          {
                            $fecha_a3 = $row['fecha'];

                            $a3_c = mysqli_query($conn, "SELECT SUM(mtto_int) as 'a_mtto_int' FROM produccion WHERE fecha = '$fecha_a3' AND zona ='Lomas de Zamora'");
                            while($roc = mysqli_fetch_assoc($a3_c))
                            { echo "'" .$roc['a_mtto_int'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(27, 154, 170, 0.7)'],
                borderColor: ['rgba(27, 154, 170, 0.5)',],
                tension: 0.2
              },
              {
                label: 'Mtto externo',
                data: [
                        <?php
                          $a4 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tareasmtto > 0 AND zona ='Lomas de Zamora' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a4))
                          {
                            $fecha_a4 = $row['fecha'];

                            $a4_d = mysqli_query($conn, "SELECT SUM(mtto_ext) as 'a_mtto_ext' FROM produccion WHERE fecha = '$fecha_a4' AND zona ='Lomas de Zamora'");
                            while($rod = mysqli_fetch_assoc($a4_d))
                            { echo "'" .$rod['a_mtto_ext'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(255, 196, 61, 0.7)'],
                borderColor: ['rgba(255, 196, 61, 0.5)',],
                tension: 0.2
              },
            ]
        },
      options: {responsive:true,}
    };
    const graficos_mtto_ins_lz = new Chart(
      document.getElementById('analisis_mtto_ins_lz'),
      config_mtto_ins_lz
    );
  </script>
<!-- TOTAL LZ -->
<!-- TOTAL JLS -->
  <script>
    const config_mtto_ins_jls = {
      type: 'line',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tareasmtto > 0 AND zona ='Jose Leon Suarez' GROUP BY fecha");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .Fecha11($row['fecha']) ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total Mtto',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tareasmtto > 0 AND zona ='Jose Leon Suarez' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $fecha_a1 = $row['fecha'];

                            $a1_a = mysqli_query($conn, "SELECT SUM(tareasmtto) as 'a_mtto' FROM produccion WHERE fecha = '$fecha_a1' AND zona ='Jose Leon Suarez'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_mtto'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(6, 214, 160, 0.7)'],
                borderColor: ['rgba(6, 214, 160, 0.5)',],
                tension: 0.2
              },
              {
                label: 'Reacondicinamiento',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tareasmtto > 0 AND zona ='Jose Leon Suarez' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $fecha_a2 = $row['fecha'];

                            $a2_b = mysqli_query($conn, "SELECT SUM(mtto_reaco) as 'a_mtto_reaco' FROM produccion WHERE fecha = '$fecha_a2' AND zona ='Jose Leon Suarez'");
                            while($rob = mysqli_fetch_assoc($a2_b))
                            { echo "'" .$rob['a_mtto_reaco'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(239, 71, 111, 0.7)'],
                borderColor: ['rgba(239, 71, 111, 0.5)',],
                tension: 0.2
              },
              {
                label: 'Mtto interno',
                data: [
                        <?php
                          $a3 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tareasmtto > 0 AND zona ='Jose Leon Suarez' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a3))
                          {
                            $fecha_a3 = $row['fecha'];

                            $a3_c = mysqli_query($conn, "SELECT SUM(mtto_int) as 'a_mtto_int' FROM produccion WHERE fecha = '$fecha_a3' AND zona ='Jose Leon Suarez'");
                            while($roc = mysqli_fetch_assoc($a3_c))
                            { echo "'" .$roc['a_mtto_int'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(27, 154, 170, 0.7)'],
                borderColor: ['rgba(27, 154, 170, 0.5)',],
                tension: 0.2
              },
              {
                label: 'Mtto externo',
                data: [
                        <?php
                          $a4 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tareasmtto > 0 AND zona ='Jose Leon Suarez' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a4))
                          {
                            $fecha_a4 = $row['fecha'];

                            $a4_d = mysqli_query($conn, "SELECT SUM(mtto_ext) as 'a_mtto_ext' FROM produccion WHERE fecha = '$fecha_a4' AND zona ='Jose Leon Suarez'");
                            while($rod = mysqli_fetch_assoc($a4_d))
                            { echo "'" .$rod['a_mtto_ext'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(255, 196, 61, 0.7)'],
                borderColor: ['rgba(255, 196, 61, 0.5)',],
                tension: 0.2
              },
            ]
        },
      options: {responsive:true,}
    };
    const graficos_mtto_ins_jls = new Chart(
      document.getElementById('analisis_mtto_ins_jls'),
      config_mtto_ins_jls
    );
  </script>
<!-- TOTAL JLS -->
<!-- TOTAL SN -->
  <script>
    const config_mtto_ins_sn = {
      type: 'line',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tareasmtto > 0 AND zona ='San Nicolas' GROUP BY fecha");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .Fecha11($row['fecha']) ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total Mtto',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tareasmtto > 0 AND zona ='San Nicolas' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $fecha_a1 = $row['fecha'];

                            $a1_a = mysqli_query($conn, "SELECT SUM(tareasmtto) as 'a_mtto' FROM produccion WHERE fecha = '$fecha_a1' AND zona ='San Nicolas'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_mtto'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(6, 214, 160, 0.7)'],
                borderColor: ['rgba(6, 214, 160, 0.5)',],
                tension: 0.2
              },
              {
                label: 'Reacondicinamiento',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tareasmtto > 0 AND zona ='San Nicolas' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $fecha_a2 = $row['fecha'];

                            $a2_b = mysqli_query($conn, "SELECT SUM(mtto_reaco) as 'a_mtto_reaco' FROM produccion WHERE fecha = '$fecha_a2' AND zona ='San Nicolas'");
                            while($rob = mysqli_fetch_assoc($a2_b))
                            { echo "'" .$rob['a_mtto_reaco'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(239, 71, 111, 0.7)'],
                borderColor: ['rgba(239, 71, 111, 0.5)',],
                tension: 0.2
              },
              {
                label: 'Mtto interno',
                data: [
                        <?php
                          $a3 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tareasmtto > 0 AND zona ='San Nicolas' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a3))
                          {
                            $fecha_a3 = $row['fecha'];

                            $a3_c = mysqli_query($conn, "SELECT SUM(mtto_int) as 'a_mtto_int' FROM produccion WHERE fecha = '$fecha_a3' AND zona ='San Nicolas'");
                            while($roc = mysqli_fetch_assoc($a3_c))
                            { echo "'" .$roc['a_mtto_int'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(27, 154, 170, 0.7)'],
                borderColor: ['rgba(27, 154, 170, 0.5)',],
                tension: 0.2
              },
              {
                label: 'Mtto externo',
                data: [
                        <?php
                          $a4 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND tareasmtto > 0 AND zona ='San Nicolas' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a4))
                          {
                            $fecha_a4 = $row['fecha'];

                            $a4_d = mysqli_query($conn, "SELECT SUM(mtto_ext) as 'a_mtto_ext' FROM produccion WHERE fecha = '$fecha_a4' AND zona ='San Nicolas'");
                            while($rod = mysqli_fetch_assoc($a4_d))
                            { echo "'" .$rod['a_mtto_ext'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(255, 196, 61, 0.7)'],
                borderColor: ['rgba(255, 196, 61, 0.5)',],
                tension: 0.2
              },
            ]
        },
      options: {responsive:true,}
    };
    const graficos_mtto_ins_sn = new Chart(
      document.getElementById('analisis_mtto_ins_sn'),
      config_mtto_ins_sn
    );
  </script>
<!-- TOTAL SN -->
<!-- TOTAL TEC -->
  <script>
    const config_bb_mtto_tec = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY tecnico");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .$row['tecnico'] ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total mtto',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $tecnico_a1 = $row['tecnico'];

                            $a1_a = mysqli_query($conn, "SELECT SUM(tareasmtto) as 'a_mtto' FROM produccion WHERE tecnico = '$tecnico_a1' AND fecha like '%$mes%'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_mtto'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(6, 214, 160, 0.6)'],
                borderColor: ['rgba(6, 214, 160, 1)',],
                borderWidth: 2
              },
              {
                label: 'Reacondicionamiento',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $tecnico_a2 = $row['tecnico'];

                            $a2_b = mysqli_query($conn, "SELECT SUM(mtto_reaco) as 'a_reaco' FROM produccion WHERE tecnico = '$tecnico_a2' AND fecha like '%$mes%'");
                            while($rob = mysqli_fetch_assoc($a2_b))
                            { echo "'" .$rob['a_reaco'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(239, 71, 111, 0.6)'],
                borderColor: ['rgba(239, 71, 111, 1)',],
                borderWidth: 2
              },
              {
                label: 'Baja con desmonte',
                data: [
                        <?php
                          $a3 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a3))
                          {
                            $tecnico_a3 = $row['tecnico'];

                            $a3_c = mysqli_query($conn, "SELECT SUM(baja_desmonte) as 'a_desmonte' FROM produccion WHERE tecnico = '$tecnico_a3' AND fecha like '%$mes%'");
                            while($roc = mysqli_fetch_assoc($a3_c))
                            { echo "'" .$roc['a_desmonte'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(27, 154, 170, 0.6)'],
                borderColor: ['rgba(27, 154, 170, 1)',],
                borderWidth: 2
              },
              {
                label: 'Mtto interno',
                data: [
                        <?php
                          $a4 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a4))
                          {
                            $tecnico_a4 = $row['tecnico'];

                            $a4_d = mysqli_query($conn, "SELECT SUM(mtto_int) as 'a_int' FROM produccion WHERE tecnico = '$tecnico_a4' AND fecha like '%$mes%'");
                            while($rod = mysqli_fetch_assoc($a4_d))
                            { echo "'" .$rod['a_int'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(255, 196, 61, 0.6)'],
                borderColor: ['rgba(255, 196, 61, 1)',],
                borderWidth: 2
              },
              {
                label: 'Mtto externo',
                data: [
                        <?php
                          $a5 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a5))
                          {
                            $tecnico_a5 = $row['tecnico'];

                            $a5_e = mysqli_query($conn, "SELECT SUM(mtto_ext) as 'a_ext' FROM produccion WHERE tecnico = '$tecnico_a5' AND fecha like '%$mes%'");
                            while($roe = mysqli_fetch_assoc($a5_e))
                            { echo "'" .$roe['a_ext'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(42,147,210, 0.6)'],
                borderColor: ['rgba(42,147,210, 1)',],
                borderWidth: 2
              }, 
            ]
        },
      options: {responsive:true,}
    };
    const graficos_bb_mtto_tec = new Chart(
      document.getElementById('analisis_mtto_tec'),
      config_bb_mtto_tec
    );
  </script>
<!-- TOTAL TEC -->
<!-- TOTAL TEC LZ -->
  <script>
    const config_bb_mtto_tec_lz = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY tecnico");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .$row['tecnico'] ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total mtto',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $tecnico_a1 = $row['tecnico'];

                            $a1_a = mysqli_query($conn, "SELECT SUM(tareasmtto) as 'a_mtto' FROM produccion WHERE tecnico = '$tecnico_a1' AND fecha like '%$mes%' AND zona = 'Lomas de Zamora'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_mtto'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(6, 214, 160, 0.6)'],
                borderColor: ['rgba(6, 214, 160, 1)',],
                borderWidth: 2
              },
              {
                label: 'Reacondicionamiento',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $tecnico_a2 = $row['tecnico'];

                            $a2_b = mysqli_query($conn, "SELECT SUM(mtto_reaco) as 'a_reaco' FROM produccion WHERE tecnico = '$tecnico_a2' AND fecha like '%$mes%' AND zona = 'Lomas de Zamora'");
                            while($rob = mysqli_fetch_assoc($a2_b))
                            { echo "'" .$rob['a_reaco'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(239, 71, 111, 0.6)'],
                borderColor: ['rgba(239, 71, 111, 1)',],
                borderWidth: 2
              },
              {
                label: 'Baja con desmonte',
                data: [
                        <?php
                          $a3 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a3))
                          {
                            $tecnico_a3 = $row['tecnico'];

                            $a3_c = mysqli_query($conn, "SELECT SUM(baja_desmonte) as 'a_desmonte' FROM produccion WHERE tecnico = '$tecnico_a3' AND fecha like '%$mes%' AND zona = 'Lomas de Zamora'");
                            while($roc = mysqli_fetch_assoc($a3_c))
                            { echo "'" .$roc['a_desmonte'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(27, 154, 170, 0.6)'],
                borderColor: ['rgba(27, 154, 170, 1)',],
                borderWidth: 2
              },
              {
                label: 'Mtto interno',
                data: [
                        <?php
                          $a4 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a4))
                          {
                            $tecnico_a4 = $row['tecnico'];

                            $a4_d = mysqli_query($conn, "SELECT SUM(mtto_int) as 'a_int' FROM produccion WHERE tecnico = '$tecnico_a4' AND fecha like '%$mes%' AND zona = 'Lomas de Zamora'");
                            while($rod = mysqli_fetch_assoc($a4_d))
                            { echo "'" .$rod['a_int'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(255, 196, 61, 0.6)'],
                borderColor: ['rgba(255, 196, 61, 1)',],
                borderWidth: 2
              },
              {
                label: 'Mtto externo',
                data: [
                        <?php
                          $a5 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a5))
                          {
                            $tecnico_a5 = $row['tecnico'];

                            $a5_e = mysqli_query($conn, "SELECT SUM(mtto_ext) as 'a_ext' FROM produccion WHERE tecnico = '$tecnico_a5' AND fecha like '%$mes%' AND zona = 'Lomas de Zamora'");
                            while($roe = mysqli_fetch_assoc($a5_e))
                            { echo "'" .$roe['a_ext'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(42,147,210, 0.6)'],
                borderColor: ['rgba(42,147,210, 1)',],
                borderWidth: 2
              }, 
            ]
        },
      options: {responsive:true,}
    };
    const graficos_bb_mtto_tec_lz = new Chart(
      document.getElementById('analisis_mtto_tec_lz'),
      config_bb_mtto_tec_lz
    );
  </script>
<!-- TOTAL TEC LZ -->
<!-- TOTAL TEC JLS -->
  <script>
    const config_bb_mtto_tec_jls = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY tecnico");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .$row['tecnico'] ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total mtto',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $tecnico_a1 = $row['tecnico'];

                            $a1_a = mysqli_query($conn, "SELECT SUM(tareasmtto) as 'a_mtto' FROM produccion WHERE tecnico = '$tecnico_a1' AND fecha like '%$mes%' AND zona = 'Jose Leon Suarez'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_mtto'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(6, 214, 160, 0.6)'],
                borderColor: ['rgba(6, 214, 160, 1)',],
                borderWidth: 2
              },
              {
                label: 'Reacondicionamiento',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $tecnico_a2 = $row['tecnico'];

                            $a2_b = mysqli_query($conn, "SELECT SUM(mtto_reaco) as 'a_reaco' FROM produccion WHERE tecnico = '$tecnico_a2' AND fecha like '%$mes%' AND zona = 'Jose Leon Suarez'");
                            while($rob = mysqli_fetch_assoc($a2_b))
                            { echo "'" .$rob['a_reaco'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(239, 71, 111, 0.6)'],
                borderColor: ['rgba(239, 71, 111, 1)',],
                borderWidth: 2
              },
              {
                label: 'Baja con desmonte',
                data: [
                        <?php
                          $a3 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a3))
                          {
                            $tecnico_a3 = $row['tecnico'];

                            $a3_c = mysqli_query($conn, "SELECT SUM(baja_desmonte) as 'a_desmonte' FROM produccion WHERE tecnico = '$tecnico_a3' AND fecha like '%$mes%' AND zona = 'Jose Leon Suarez'");
                            while($roc = mysqli_fetch_assoc($a3_c))
                            { echo "'" .$roc['a_desmonte'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(27, 154, 170, 0.6)'],
                borderColor: ['rgba(27, 154, 170, 1)',],
                borderWidth: 2
              },
              {
                label: 'Mtto interno',
                data: [
                        <?php
                          $a4 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a4))
                          {
                            $tecnico_a4 = $row['tecnico'];

                            $a4_d = mysqli_query($conn, "SELECT SUM(mtto_int) as 'a_int' FROM produccion WHERE tecnico = '$tecnico_a4' AND fecha like '%$mes%' AND zona = 'Jose Leon Suarez'");
                            while($rod = mysqli_fetch_assoc($a4_d))
                            { echo "'" .$rod['a_int'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(255, 196, 61, 0.6)'],
                borderColor: ['rgba(255, 196, 61, 1)',],
                borderWidth: 2
              },
              {
                label: 'Mtto externo',
                data: [
                        <?php
                          $a5 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a5))
                          {
                            $tecnico_a5 = $row['tecnico'];

                            $a5_e = mysqli_query($conn, "SELECT SUM(mtto_ext) as 'a_ext' FROM produccion WHERE tecnico = '$tecnico_a5' AND fecha like '%$mes%' AND zona = 'Jose Leon Suarez'");
                            while($roe = mysqli_fetch_assoc($a5_e))
                            { echo "'" .$roe['a_ext'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(42,147,210, 0.6)'],
                borderColor: ['rgba(42,147,210, 1)',],
                borderWidth: 2
              }, 
            ]
        },
      options: {responsive:true,}
    };
    const graficos_bb_mtto_tec_jls = new Chart(
      document.getElementById('analisis_mtto_tec_jls'),
      config_bb_mtto_tec_jls
    );
  </script>
<!-- TOTAL TEC JLS -->
<!-- TOTAL TEC SN -->
  <script>
    const config_bb_mtto_tec_sn = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'San Nicolas' GROUP BY tecnico");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .$row['tecnico'] ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total mtto',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'San Nicolas' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $tecnico_a1 = $row['tecnico'];

                            $a1_a = mysqli_query($conn, "SELECT SUM(tareasmtto) as 'a_mtto' FROM produccion WHERE tecnico = '$tecnico_a1' AND fecha like '%$mes%' AND zona = 'San Nicolas'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_mtto'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(6, 214, 160, 0.6)'],
                borderColor: ['rgba(6, 214, 160, 1)',],
                borderWidth: 2
              },
              {
                label: 'Reacondicionamiento',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'San Nicolas' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $tecnico_a2 = $row['tecnico'];

                            $a2_b = mysqli_query($conn, "SELECT SUM(mtto_reaco) as 'a_reaco' FROM produccion WHERE tecnico = '$tecnico_a2' AND fecha like '%$mes%' AND zona = 'San Nicolas'");
                            while($rob = mysqli_fetch_assoc($a2_b))
                            { echo "'" .$rob['a_reaco'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(239, 71, 111, 0.6)'],
                borderColor: ['rgba(239, 71, 111, 1)',],
                borderWidth: 2
              },
              {
                label: 'Baja con desmonte',
                data: [
                        <?php
                          $a3 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'San Nicolas' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a3))
                          {
                            $tecnico_a3 = $row['tecnico'];

                            $a3_c = mysqli_query($conn, "SELECT SUM(baja_desmonte) as 'a_desmonte' FROM produccion WHERE tecnico = '$tecnico_a3' AND fecha like '%$mes%' AND zona = 'San Nicolas'");
                            while($roc = mysqli_fetch_assoc($a3_c))
                            { echo "'" .$roc['a_desmonte'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(27, 154, 170, 0.6)'],
                borderColor: ['rgba(27, 154, 170, 1)',],
                borderWidth: 2
              },
              {
                label: 'Mtto interno',
                data: [
                        <?php
                          $a4 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'San Nicolas' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a4))
                          {
                            $tecnico_a4 = $row['tecnico'];

                            $a4_d = mysqli_query($conn, "SELECT SUM(mtto_int) as 'a_int' FROM produccion WHERE tecnico = '$tecnico_a4' AND fecha like '%$mes%' AND zona = 'San Nicolas'");
                            while($rod = mysqli_fetch_assoc($a4_d))
                            { echo "'" .$rod['a_int'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(255, 196, 61, 0.6)'],
                borderColor: ['rgba(255, 196, 61, 1)',],
                borderWidth: 2
              },
              {
                label: 'Mtto externo',
                data: [
                        <?php
                          $a5 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'San Nicolas' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a5))
                          {
                            $tecnico_a5 = $row['tecnico'];

                            $a5_e = mysqli_query($conn, "SELECT SUM(mtto_ext) as 'a_ext' FROM produccion WHERE tecnico = '$tecnico_a5' AND fecha like '%$mes%' AND zona = 'San Nicolas'");
                            while($roe = mysqli_fetch_assoc($a5_e))
                            { echo "'" .$roe['a_ext'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(42,147,210, 0.6)'],
                borderColor: ['rgba(42,147,210, 1)',],
                borderWidth: 2
              }, 
            ]
        },
      options: {responsive:true,}
    };
    const graficos_bb_mtto_tec_sn = new Chart(
      document.getElementById('analisis_mtto_tec_sn'),
      config_bb_mtto_tec_sn
    );
  </script>
<!-- TOTAL TEC SN -->
<!-- TOTAL MOTIVOS -->
  <script>
    const config_bbb_mtto_mot = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT COUNT(razon_completada) as 'razones', razon_completada, estado, actividad FROM carga_dia WHERE fecha like '%$mes%' AND razon_completada <> '' AND actividad NOT LIKE 'Actividad Regularizaci%' AND actividad NOT LIKE '%n AP' AND actividad NOT LIKE '%cnico al cliente - Garantia' AND actividad NOT LIKE '%cnica por baja' AND estado = 'finalizada' AND actividad NOT LIKE 'Instalación' AND razon_completada NOT LIKE 'Instalada exitosamente' AND razon_completada NOT LIKE 'Recupero de Drop%' GROUP BY razon_completada");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .$row['razon_completada'] ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Motivo de cierre',
                data: [
                        <?php
                          $a0 = mysqli_query($conn, "SELECT COUNT(razon_completada) as 'razones', razon_completada, estado, actividad FROM carga_dia WHERE fecha like '%$mes%' AND razon_completada <> '' AND actividad NOT LIKE 'Actividad Regularizaci%' AND actividad NOT LIKE '%n AP' AND actividad NOT LIKE '%cnico al cliente - Garantia' AND actividad NOT LIKE '%cnica por baja' AND estado = 'finalizada' AND actividad NOT LIKE 'Instalación' AND razon_completada NOT LIKE 'Instalada exitosamente' AND razon_completada NOT LIKE 'Recupero de Drop%' GROUP BY razon_completada");
                          while($row = mysqli_fetch_assoc($a0))
                          {
                            $razones_a0 = $row['razon_completada'];

                            $a0_a = mysqli_query($conn, "SELECT COUNT(razon_completada) as 'razones', razon_completada FROM carga_dia WHERE fecha like '%$mes%' AND razon_completada <> '' AND actividad NOT LIKE 'Actividad Regularizaci%' AND actividad NOT LIKE '%n AP' AND actividad NOT LIKE '%cnico al cliente - Garantia' AND actividad NOT LIKE '%cnica por baja' AND razon_completada = '$razones_a0'");
                            while($roa = mysqli_fetch_assoc($a0_a))
                            { echo "'" .$roa['razones'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(238, 108, 77, 0.6)'],
                borderColor: ['rgba(238, 108, 77, 1)',],
                borderWidth: 2,
              }
            ]
        },
      options: {responsive:true,}
    };
    const graficos_bbb_mtto_mot = new Chart(
      document.getElementById('analisis_mtto_mot'),
      config_bbb_mtto_mot
    );
  </script>
<!-- TOTAL MOTIVOS -->
<!-- TOTAL MOTIVOS LZ -->
  <script>
    const config_bbb_mtto_mot_lz = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '%$mes%' AND estado = 'finalizada' AND actividad NOT LIKE 'Instalación' AND razon_completada <> '' AND actividad NOT LIKE 'Actividad Regularizaci%' AND actividad NOT LIKE '%n AP' AND actividad NOT LIKE '%cnica por baja' AND actividad NOT LIKE '%cnico al cliente - Garantia' AND razon_completada NOT LIKE 'Instalada exitosamente' AND razon_completada NOT LIKE 'Recupero de Drop%' AND zona_recurso = 'Lomas de Zamora' GROUP BY razon_completada");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .$row['razon_completada'] ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Motivo de cierre',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '%$mes%' AND estado = 'finalizada' AND actividad NOT LIKE 'Instalación' AND razon_completada <> '' AND actividad NOT LIKE 'Actividad Regularizaci%' AND actividad NOT LIKE '%n AP' AND actividad NOT LIKE '%cnica por baja' AND actividad NOT LIKE '%cnico al cliente - Garantia' AND razon_completada NOT LIKE 'Instalada exitosamente' AND razon_completada NOT LIKE 'Recupero de Drop%' AND zona_recurso = 'Lomas de Zamora' GROUP BY razon_completada");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $razones_a1 = $row['razon_completada'];

                            $a1_a = mysqli_query($conn, "SELECT COUNT(razon_completada) as 'razones_lz' FROM carga_dia WHERE fecha like '%$mes%' AND razon_completada = '$razones_a1' AND razon_completada <> '' AND actividad NOT LIKE 'Actividad Regularizaci%' AND actividad NOT LIKE '%n AP' AND actividad NOT LIKE '%cnica por baja' AND actividad NOT LIKE '%cnico al cliente - Garantia' AND estado = 'finalizada' AND zona_recurso = 'Lomas de Zamora'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['razones_lz'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(238, 108, 77, 0.6)'],
                borderColor: ['rgba(238, 108, 77, 1)',],
                borderWidth: 2,
              }
            ]
        },
      options: {responsive:true,}
    };
    const graficos_bbb_mtto_mot_lz = new Chart(
      document.getElementById('analisis_mtto_mot_lz'),
      config_bbb_mtto_mot_lz
    );
  </script>
<!-- TOTAL MOTIVOS LZ -->
<!-- TOTAL MOTIVOS JLS -->
  <script>
    const config_bbb_mtto_mot_jls = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '%$mes%' AND estado = 'finalizada' AND actividad NOT LIKE 'Instalación' AND razon_completada <> '' AND actividad NOT LIKE 'Actividad Regularizaci%' AND actividad NOT LIKE '%n AP' AND actividad NOT LIKE '%cnica por baja' AND actividad NOT LIKE '%cnico al cliente - Garantia' AND razon_completada NOT LIKE 'Instalada exitosamente' AND razon_completada NOT LIKE 'Recupero de Drop%' AND zona_recurso = 'Jose Leon Suarez' GROUP BY razon_completada");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .$row['razon_completada'] ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Motivo de cierre',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '%$mes%' AND estado = 'finalizada' AND actividad NOT LIKE 'Instalación' AND razon_completada <> '' AND actividad NOT LIKE 'Actividad Regularizaci%' AND actividad NOT LIKE '%n AP' AND actividad NOT LIKE '%cnica por baja' AND actividad NOT LIKE '%cnico al cliente - Garantia' AND razon_completada NOT LIKE 'Instalada exitosamente' AND razon_completada NOT LIKE 'Recupero de Drop%' AND zona_recurso = 'Jose Leon Suarez' GROUP BY razon_completada");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $razones_a2 = $row['razon_completada'];

                            $a2_a = mysqli_query($conn, "SELECT COUNT(razon_completada) as 'razones_jls', razon_completada FROM carga_dia WHERE fecha like '%$mes%' AND razon_completada <> '' AND actividad NOT LIKE 'Actividad Regularizaci%' AND actividad NOT LIKE '%n AP' AND actividad NOT LIKE '%cnica por baja' AND actividad NOT LIKE '%cnico al cliente - Garantia' AND razon_completada = '$razones_a2' AND estado = 'finalizada' AND zona_recurso = 'Jose Leon Suarez'");
                            while($roa = mysqli_fetch_assoc($a2_a))
                            { echo "'" .$roa['razones_jls'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(238, 108, 77, 0.6)'],
                borderColor: ['rgba(238, 108, 77, 1)',],
                borderWidth: 2,
              }
            ]
        },
      options: {responsive:true,}
    };
    const graficos_bbb_mtto_mot_jls = new Chart(
      document.getElementById('analisis_mtto_mot_jls'),
      config_bbb_mtto_mot_jls
    );
  </script>
<!-- TOTAL MOTIVOS JLS -->
<!-- TOTAL MOTIVOS SN -->
  <script>
    const config_bbb_mtto_mot_sn = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '%$mes%' AND estado = 'finalizada' AND actividad NOT LIKE 'Instalación' AND actividad NOT LIKE '%cnico al cliente - Garantia' AND razon_completada <> '' AND actividad NOT LIKE 'Actividad Regularizaci%' AND actividad NOT LIKE '%n AP' AND actividad NOT LIKE '%cnica por baja' AND razon_completada NOT LIKE 'Instalada exitosamente' AND razon_completada NOT LIKE 'Recupero de Drop%' AND zona_recurso = 'San Nicolas' GROUP BY razon_completada");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .$row['razon_completada'] ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Motivo de cierre',
                data: [
                        <?php
                          $a3 = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '%$mes%' AND estado = 'finalizada' AND actividad NOT LIKE 'Instalación' AND razon_completada <> '' AND actividad NOT LIKE 'Actividad Regularizaci%' AND actividad NOT LIKE '%n AP' AND actividad NOT LIKE '%cnica por baja' AND actividad NOT LIKE '%cnico al cliente - Garantia' AND razon_completada NOT LIKE 'Instalada exitosamente' AND razon_completada NOT LIKE 'Recupero de Drop%' AND zona_recurso = 'San Nicolas' GROUP BY razon_completada");
                          while($row = mysqli_fetch_assoc($a3))
                          {
                            $razones_a3 = $row['razon_completada'];

                            $a3_a = mysqli_query($conn, "SELECT COUNT(razon_completada) as 'razones_sn', razon_completada FROM carga_dia WHERE fecha like '%$mes%' AND razon_completada <> '' AND actividad NOT LIKE 'Actividad Regularizaci%' AND actividad NOT LIKE '%n AP' AND actividad NOT LIKE '%cnica por baja' AND actividad NOT LIKE '%cnico al cliente - Garantia' AND razon_completada = '$razones_a3'  AND estado = 'finalizada' AND zona_recurso = 'San Nicolas'");
                            while($roa = mysqli_fetch_assoc($a3_a))
                            { echo "'" .$roa['razones_sn'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(238, 108, 77, 0.6)'],
                borderColor: ['rgba(238, 108, 77, 1)',],
                borderWidth: 2,
              }
            ]
        },
      options: {responsive:true,}
    };
    const graficos_bbb_mtto_mot_sn = new Chart(
      document.getElementById('analisis_mtto_mot_sn'),
      config_bbb_mtto_mot_sn
    );
  </script>
<!-- TOTAL MOTIVOS SN -->
</body>
</html>