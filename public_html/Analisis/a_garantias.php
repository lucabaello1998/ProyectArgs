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
    #analisis_garant_ins
    {
      height: 40vh;
      width:40vw;
    }
    #analisis_garant_tec
    {
      height: 40vh;
      width:40vw;
    }
    #analisis_garant_mot
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
          <input type="hidden" name="link" value="../Analisis/a_garantias.php">
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
          <input type="hidden" name="link" value="../Analisis/a_garantias.php">
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
        $a = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' GROUP BY zona");
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
            <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #28A745 !important;">
              <div class="col-12 p-2">
                <?php
                  $a_tot = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_garant' FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> ''");
                  while($roa = mysqli_fetch_assoc($a_tot))
                  { $a_garant = $roa['a_garant']; }
                ?>
                <p class="h2 text-muted text-center"><?php echo $a_garant; ?></p>
                <p class="h4 text-muted text-center">Total</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
            <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #EF8D09 !important;">
              <div class="col-12 p-2">
                <?php
                  $a_2 = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi' FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND justificado = 'NO'");
                  while($roa = mysqli_fetch_assoc($a_2))
                  { $a_justi = $roa['a_justi']; }
                ?>
                <p class="h2 text-muted text-center"><?php echo $a_justi; ?></p>
                <p class="h4 text-muted text-center">No justificadas</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
            <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #0A3775 !important;">
              <div class="col-12 p-2">
                <?php
                  $a_3 = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi_si' FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND justificado = 'SI'");
                  while($roa = mysqli_fetch_assoc($a_3))
                  { $a_justi_si = $roa['a_justi_si']; }
                ?>
                <p class="h2 text-muted text-center"><?php echo $a_justi_si; ?></p>
                <p class="h4 text-muted text-center">Si justificadas</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
            <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #F54D7A !important;">
              <div class="col-12 p-2">
                <?php
                  $a_ssttbb = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi_sin' FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND justificado = ''");
                  while($roa = mysqli_fetch_assoc($a_ssttbb))
                  { $a_justi_sin = $roa['a_justi_sin']; }
                ?>
                <p class="h2 text-muted text-center"><?php echo $a_justi_sin; ?></p>
                <p class="h4 text-muted text-center">Sin justificar</p>
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
                <canvas id="analisis_garant_ins" style="height:25vh; width:40vw"></canvas>
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
                      <th data-toggle="tooltip" data-placement="bottom" title="Cantidad de garantias en el mes">Cant</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $b1 = mysqli_query($conn, "SELECT COUNT(tecnico) as 'ta_garantia', tecnico FROM garantias WHERE fecharep like '$mes%' AND tecrep <> '' GROUP BY tecnico ORDER BY ta_garantia desc");  
                      while($row = mysqli_fetch_assoc($b1))
                      { $tec = $row['tecnico']; ?>
                      <tr>                       
                      <td><?php echo $tec; ?></td>
                      <td align="center"><?php echo $row['ta_garantia']; ?></td>
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
                <canvas id="analisis_garant_tec" style="height:35vh; width:40vw"></canvas>
              </div>
            </div>
            <div class="row rounded bg-white shadow m-1 p-2">
              <div class="col-12 p-0">
                <p class="text-center text-muted h5">Motivos</p>
              </div>
              <div class="col-12 p-0">
                <canvas id="analisis_garant_mot" style="height:35vh; width:40vw"></canvas>
              </div>
            </div>
            
          </div>
        </div>
      </div>

    </div>

    <?php
      $aa = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' GROUP BY zona");
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
            <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #28A745 !important;">
              <div class="col-12 p-2">
                <?php
                  $a_tot = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_garant' FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = '$zona'");
                  while($roa = mysqli_fetch_assoc($a_tot))
                  { $a_garant = $roa['a_garant']; }
                ?>
                <p class="h2 text-muted text-center"><?php echo $a_garant; ?></p>
                <p class="h4 text-muted text-center">Total</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
            <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #EF8D09 !important;">
              <div class="col-12 p-2">
                <?php
                  $a_2 = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi' FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND justificado = 'NO' AND zona = '$zona'");
                  while($roa = mysqli_fetch_assoc($a_2))
                  { $a_justi = $roa['a_justi']; }
                ?>
                <p class="h2 text-muted text-center"><?php echo $a_justi; ?></p>
                <p class="h4 text-muted text-center">No justificadas</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
            <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #0A3775 !important;">
              <div class="col-12 p-2">
                <?php
                  $a_3 = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi_si' FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND justificado = 'SI' AND zona = '$zona'");
                  while($roa = mysqli_fetch_assoc($a_3))
                  { $a_justi_si = $roa['a_justi_si']; }
                ?>
                <p class="h2 text-muted text-center"><?php echo $a_justi_si; ?></p>
                <p class="h4 text-muted text-center">Si justificadas</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
            <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #F54D7A !important;">
              <div class="col-12 p-2">
                <?php
                  $a_ssttbb = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi_sin' FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND justificado = '' AND zona = '$zona'");
                  while($roa = mysqli_fetch_assoc($a_ssttbb))
                  { $a_justi_sin = $roa['a_justi_sin']; }
                ?>
                <p class="h2 text-muted text-center"><?php echo $a_justi_sin; ?></p>
                <p class="h4 text-muted text-center">Sin justificar</p>
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
                <canvas id="analisis_garant_ins_<?php echo $zona_abre; ?>" style="height:25vh; width:40vw"></canvas>
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
                      <th data-toggle="tooltip" data-placement="bottom" title="Cantidad de garantias en el mes">Cant</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $b1 = mysqli_query($conn, "SELECT COUNT(tecnico) as 'ta_garantia', tecnico FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> ''  AND zona = '$zona' GROUP BY tecnico ORDER BY ta_garantia desc");  
                      while($row = mysqli_fetch_assoc($b1))
                      { $tec = $row['tecnico']; ?>
                      <tr>                       
                      <td><?php echo $tec; ?></td>
                      <td align="center"><?php echo $row['ta_garantia']; ?></td>
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
                <canvas id="analisis_garant_tec_<?php echo $zona_abre; ?>" style="height:35vh; width:40vw"></canvas>
              </div>
            </div>
            <div class="row rounded bg-white shadow m-1 p-2">
              <div class="col-12 p-0">
                <p class="text-center text-muted h5">Motivos</p>
              </div>
              <div class="col-12 p-0">
                <canvas id="analisis_garant_mot_<?php echo $zona_abre; ?>" style="height:35vh; width:40vw"></canvas>
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
<!-- TOTAL INS -->
  <script>
    const config_g = {
      type: 'line',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' GROUP BY fecharep");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .Fecha11($row['fecharep']) ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total garantias',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' GROUP BY fecharep");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $fecha_a1 = $row['fecharep'];

                            $a1_a = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_garant' FROM garantias WHERE fecharep = '$fecha_a1'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_garant'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(40, 167, 69, 0.7)'],
                borderColor: ['rgba(40, 167, 69, 0.5)',],
                tension: 0.2
              },
              {
                label: 'No justificadas',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' GROUP BY fecharep");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $fecha_a2 = $row['fecharep'];

                            $a2_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi' FROM garantias WHERE fecharep = '$fecha_a2' AND justificado = 'NO'");
                            while($rob = mysqli_fetch_assoc($a2_b))
                            { echo "'" .$rob['a_justi'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(239, 141, 9, 0.7)'],
                borderColor: ['rgba(239, 141, 9, 0.5)',],
                tension: 0.2
              },
              {
                label: 'Si justificadas',
                data: [
                        <?php
                          $a3 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' GROUP BY fecharep");
                          while($row = mysqli_fetch_assoc($a3))
                          {
                            $fecha_a3 = $row['fecharep'];

                            $a3_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi_si' FROM garantias WHERE fecharep = '$fecha_a3' AND justificado = 'SI'");
                            while($rob = mysqli_fetch_assoc($a3_b))
                            { echo "'" .$rob['a_justi_si'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(10,55,117, 0.7)'],
                borderColor: ['rgba(10,55,117, 0.5)',],
                tension: 0.2
              },
              {
                label: 'Sin justificar',
                data: [
                        <?php
                          $a4 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' GROUP BY fecharep");
                          while($row = mysqli_fetch_assoc($a4))
                          {
                            $fecha_a4 = $row['fecharep'];

                            $a4_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi_sin' FROM garantias WHERE fecharep = '$fecha_a4' AND tecrep <> '' AND justificado = ''");
                            while($rob = mysqli_fetch_assoc($a4_b))
                            { echo "'" .$rob['a_justi_sin'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(245,77,122, 0.7)'],
                borderColor: ['rgba(245,77,122, 0.5)',],
                tension: 0.2
              } 
            ]
        },
      options: {}
    };
    const graficos_g = new Chart(
      document.getElementById('analisis_garant_ins'),
      config_g
    );
  </script>
<!-- TOTAL INS -->
<!-- LOMAS -->
  <script>
    const config_g_lz = {
      type: 'line',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND zona = 'Lomas de Zamora' AND tecrep <> '' GROUP BY fecharep");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .Fecha11($row['fecharep']) ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total garantias',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND zona = 'Lomas de Zamora' AND tecrep <> '' GROUP BY fecharep");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $fecha_a1 = $row['fecharep'];

                            $a1_a = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_garant' FROM garantias WHERE fecharep = '$fecha_a1' AND zona = 'Lomas de Zamora' AND tecrep <> ''");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_garant'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(40, 167, 69, 0.7)'],
                borderColor: ['rgba(40, 167, 69, 0.5)',],
                tension: 0.2
              },
              {
                label: 'No justificadas',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY fecharep");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $fecha_a2 = $row['fecharep'];

                            $a2_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi' FROM garantias WHERE fecharep = '$fecha_a2' AND zona = 'Lomas de Zamora' AND justificado = 'NO'");
                            while($rob = mysqli_fetch_assoc($a2_b))
                            { echo "'" .$rob['a_justi'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(239, 141, 9, 0.7)'],
                borderColor: ['rgba(239, 141, 9, 0.5)',],
                tension: 0.2
              },
              {
                label: 'Si justificadas',
                data: [
                        <?php
                          $a3 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY fecharep");
                          while($row = mysqli_fetch_assoc($a3))
                          {
                            $fecha_a3 = $row['fecharep'];

                            $a3_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi_si' FROM garantias WHERE fecharep = '$fecha_a3' AND zona = 'Lomas de Zamora' AND justificado = 'SI'");
                            while($rob = mysqli_fetch_assoc($a3_b))
                            { echo "'" .$rob['a_justi_si'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(10,55,117, 0.7)'],
                borderColor: ['rgba(10,55,117, 0.5)',],
                tension: 0.2
              },
              {
                label: 'Sin justificar',
                data: [
                        <?php
                          $a4 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY fecharep");
                          while($row = mysqli_fetch_assoc($a4))
                          {
                            $fecha_a4 = $row['fecharep'];

                            $a4_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi_sin' FROM garantias WHERE fecharep = '$fecha_a4' AND zona = 'Lomas de Zamora' AND justificado = ''");
                            while($rob = mysqli_fetch_assoc($a4_b))
                            { echo "'" .$rob['a_justi_sin'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(245,77,122, 0.7)'],
                borderColor: ['rgba(245,77,122, 0.5)',],
                tension: 0.2
              }
            ]
        },
      options: {}
    };
    const graficos_g_lz = new Chart(
      document.getElementById('analisis_garant_ins_lz'),
      config_g_lz
    );
  </script>
<!-- LOMAS -->
<!-- SUAREZ -->
  <script>
    const config_g_jlz = {
      type: 'line',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Jose Leon Suarez' GROUP BY fecharep");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .Fecha11($row['fecharep']) ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total garantias',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Jose Leon Suarez' GROUP BY fecharep");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $fecha_a1 = $row['fecharep'];

                            $a1_a = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_garant' FROM garantias WHERE fecharep = '$fecha_a1' AND tecrep <> '' AND zona = 'Jose Leon Suarez'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_garant'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(40, 167, 69, 0.7)'],
                borderColor: ['rgba(40, 167, 69, 0.5)',],
                tension: 0.2
              },
              {
                label: 'No justificadas',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Jose Leon Suarez' GROUP BY fecharep");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $fecha_a2 = $row['fecharep'];

                            $a2_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi' FROM garantias WHERE fecharep = '$fecha_a2' AND tecrep <> '' AND zona = 'Jose Leon Suarez' AND justificado = 'NO'");
                            while($rob = mysqli_fetch_assoc($a2_b))
                            { echo "'" .$rob['a_justi'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(239, 141, 9, 0.7)'],
                borderColor: ['rgba(239, 141, 9, 0.5)',],
                tension: 0.2
              },
              {
                label: 'Si justificadas',
                data: [
                        <?php
                          $a3 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND zona = 'Jose Leon Suarez' AND tecrep <> '' GROUP BY fecharep");
                          while($row = mysqli_fetch_assoc($a3))
                          {
                            $fecha_a3 = $row['fecharep'];

                            $a3_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi_si' FROM garantias WHERE fecharep = '$fecha_a3' AND tecrep <> '' AND zona = 'Jose Leon Suarez' AND justificado = 'SI'");
                            while($rob = mysqli_fetch_assoc($a3_b))
                            { echo "'" .$rob['a_justi_si'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(10,55,117, 0.7)'],
                borderColor: ['rgba(10,55,117, 0.5)',],
                tension: 0.2
              },
              {
                label: 'Sin justificar',
                data: [
                        <?php
                          $a4 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Jose Leon Suarez' GROUP BY fecharep");
                          while($row = mysqli_fetch_assoc($a4))
                          {
                            $fecha_a4 = $row['fecharep'];

                            $a4_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi_sin' FROM garantias WHERE fecharep = '$fecha_a4' AND tecrep <> '' AND zona = 'Jose Leon Suarez' AND justificado = ''");
                            while($rob = mysqli_fetch_assoc($a4_b))
                            { echo "'" .$rob['a_justi_sin'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(245,77,122, 0.7)'],
                borderColor: ['rgba(245,77,122, 0.5)',],
                tension: 0.2
              }
            ]
        },
      options: {}
    };
    const graficos_g_jlz = new Chart(
      document.getElementById('analisis_garant_ins_jls'),
      config_g_jlz
    );
  </script>
<!-- SUAREZ -->
<!-- NICOLAS -->
  <script>
    const config_g_sn = {
      type: 'line',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'San Nicolas' GROUP BY fecharep");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .Fecha11($row['fecharep']) ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total garantias',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'San Nicolas' GROUP BY fecharep");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $fecha_a1 = $row['fecharep'];

                            $a1_a = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_garant' FROM garantias WHERE fecharep = '$fecha_a1' AND tecrep <> '' AND zona = 'San Nicolas'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_garant'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(40, 167, 69, 0.7)'],
                borderColor: ['rgba(40, 167, 69, 0.5)',],
                tension: 0.2
              },
              {
                label: 'No justificadas',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'San Nicolas' GROUP BY fecharep");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $fecha_a2 = $row['fecharep'];

                            $a2_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi' FROM garantias WHERE fecharep = '$fecha_a2' AND tecrep <> '' AND zona = 'San Nicolas' AND justificado = 'NO'");
                            while($rob = mysqli_fetch_assoc($a2_b))
                            { echo "'" .$rob['a_justi'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(239, 141, 9, 0.7)'],
                borderColor: ['rgba(239, 141, 9, 0.5)',],
                tension: 0.2
              },
              {
                label: 'Si justificadas',
                data: [
                        <?php
                          $a3 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'San Nicolas' GROUP BY fecharep");
                          while($row = mysqli_fetch_assoc($a3))
                          {
                            $fecha_a3 = $row['fecharep'];

                            $a3_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi_si' FROM garantias WHERE fecharep = '$fecha_a3' AND tecrep <> '' AND zona = 'San Nicolas' AND justificado = 'SI'");
                            while($rob = mysqli_fetch_assoc($a3_b))
                            { echo "'" .$rob['a_justi_si'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(10,55,117, 0.7)'],
                borderColor: ['rgba(10,55,117, 0.5)',],
                tension: 0.2
              },
              {
                label: 'Sin justificar',
                data: [
                        <?php
                          $a4 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'San Nicolas' GROUP BY fecharep");
                          while($row = mysqli_fetch_assoc($a4))
                          {
                            $fecha_a4 = $row['fecharep'];

                            $a4_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi_sin' FROM garantias WHERE fecharep = '$fecha_a4' AND tecrep <> '' AND zona = 'San Nicolas' AND justificado = ''");
                            while($rob = mysqli_fetch_assoc($a4_b))
                            { echo "'" .$rob['a_justi_sin'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(245,77,122, 0.7)'],
                borderColor: ['rgba(245,77,122, 0.5)',],
                tension: 0.2
              }
            ]
        },
      options: {}
    };
    const graficos_g_sn = new Chart(
      document.getElementById('analisis_garant_ins_sn'),
      config_g_sn
    );
  </script>
<!-- NICOLAS -->
<!-- TOTAL -->
  <script>
    const config_gg = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' GROUP BY tecnico");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .$row['tecnico'] ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total garantias',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $tecnico_a1 = $row['tecnico'];

                            $a1_a = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_garant' FROM garantias WHERE tecnico = '$tecnico_a1' AND fecharep like '%$mes%' AND tecrep <> ''");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_garant'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(40, 167, 69, 0.6)'],
                borderColor: ['rgba(40, 167, 69, 1)',],
                borderWidth: 2
              },
              {
                label: 'No justificadas',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $fecha_a2 = $row['tecnico'];

                            $a2_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi' FROM garantias WHERE tecnico = '$fecha_a2' AND fecharep like '%$mes%' AND tecrep <> '' AND justificado = 'NO'");
                            while($rob = mysqli_fetch_assoc($a2_b))
                            { echo "'" .$rob['a_justi'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(239, 141, 9, 0.6)'],
                borderColor: ['rgba(239, 141, 9, 1)',],
                borderWidth: 2
              },
              {
                label: 'Si justificadas',
                data: [
                        <?php
                          $a3 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a3))
                          {
                            $fecha_a3 = $row['tecnico'];

                            $a3_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi_si' FROM garantias WHERE tecnico = '$fecha_a3' AND fecharep like '%$mes%' AND tecrep <> '' AND justificado = 'SI'");
                            while($rob = mysqli_fetch_assoc($a3_b))
                            { echo "'" .$rob['a_justi_si'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(10,55,117, 0.6)'],
                borderColor: ['rgba(10,55,117, 1)',],
                borderWidth: 2
              },
              {
                label: 'Sin justificar',
                data: [
                        <?php
                          $a4 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a4))
                          {
                            $fecha_a4 = $row['tecnico'];

                            $a4_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi_sin' FROM garantias WHERE tecnico = '$fecha_a4' AND fecharep like '%$mes%' AND tecrep <> '' AND justificado = ''");
                            while($rob = mysqli_fetch_assoc($a4_b))
                            { echo "'" .$rob['a_justi_sin'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(245,77,122, 0.6)'],
                borderColor: ['rgba(245,77,122, 1)',],
                borderWidth: 2
              }
            ]
        },
      options: { }
    };
    const graficos_gg = new Chart(
      document.getElementById('analisis_garant_tec'),
      config_gg
    );
  </script>
<!-- TOTAL -->
<!-- LOMAS -->
  <script>
    const config_gg_lz = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Lomas de Zamora' GROUP BY tecnico");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .$row['tecnico'] ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total garantias',
                data: [
                        <?php
                          $aa1 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Lomas de Zamora' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($aa1))
                          {
                            $tecnico_aa1 = $row['tecnico'];

                            $aa1_a = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_garant' FROM garantias WHERE tecnico = '$tecnico_aa1' AND fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Lomas de Zamora'");
                            while($roa = mysqli_fetch_assoc($aa1_a))
                            { echo "'" .$roa['a_garant'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(40, 167, 69, 0.6)'],
                borderColor: ['rgba(40, 167, 69, 1)',],
                borderWidth: 2
              },
              {
                label: 'No justificadas',
                data: [
                        <?php
                          $aa2 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Lomas de Zamora' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($aa2))
                          {
                            $fecha_aa2 = $row['tecnico'];

                            $aa2_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi' FROM garantias WHERE tecnico = '$fecha_aa2' AND fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Lomas de Zamora' AND justificado = 'NO'");
                            while($rob = mysqli_fetch_assoc($aa2_b))
                            { echo "'" .$rob['a_justi'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(239, 141, 9, 0.6)'],
                borderColor: ['rgba(239, 141, 9, 1)',],
                borderWidth: 2
              },
              {
                label: 'Si justificadas',
                data: [
                        <?php
                          $aa3 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Lomas de Zamora' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($aa3))
                          {
                            $fecha_aa3 = $row['tecnico'];

                            $aa3_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi_si' FROM garantias WHERE tecnico = '$fecha_aa3' AND fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Lomas de Zamora' AND justificado = 'SI'");
                            while($rob = mysqli_fetch_assoc($aa3_b))
                            { echo "'" .$rob['a_justi_si'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(10,55,117, 0.6)'],
                borderColor: ['rgba(10,55,117, 1)',],
                borderWidth: 2
              },
              {
                label: 'Sin justificar',
                data: [
                        <?php
                          $aa4 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Lomas de Zamora' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($aa4))
                          {
                            $fecha_aa4 = $row['tecnico'];

                            $aa4_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi_sin' FROM garantias WHERE tecnico = '$fecha_aa4' AND fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Lomas de Zamora' AND justificado = ''");
                            while($rob = mysqli_fetch_assoc($aa4_b))
                            { echo "'" .$rob['a_justi_sin'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(245,77,122, 0.6)'],
                borderColor: ['rgba(245,77,122, 1)',],
                borderWidth: 2
              }
            ]
        },
      options: { }
    };
    const graficos_gg_lz = new Chart(
      document.getElementById('analisis_garant_tec_lz'),
      config_gg_lz
    );
  </script>
<!-- LOMAS -->
<!-- SUAREZ -->
  <script>
    const config_gg_jls = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Jose Leon Suarez' GROUP BY tecnico");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .$row['tecnico'] ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total garantias',
                data: [
                        <?php
                          $aa1 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Jose Leon Suarez' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($aa1))
                          {
                            $tecnico_aa1 = $row['tecnico'];

                            $aa1_a = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_garant' FROM garantias WHERE tecnico = '$tecnico_aa1' AND fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Jose Leon Suarez'");
                            while($roa = mysqli_fetch_assoc($aa1_a))
                            { echo "'" .$roa['a_garant'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(40, 167, 69, 0.6)'],
                borderColor: ['rgba(40, 167, 69, 1)',],
                borderWidth: 2
              },
              {
                label: 'No justificadas',
                data: [
                        <?php
                          $aa2 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Jose Leon Suarez' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($aa2))
                          {
                            $fecha_aa2 = $row['tecnico'];

                            $aa2_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi' FROM garantias WHERE tecnico = '$fecha_aa2' AND fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Jose Leon Suarez' AND justificado = 'NO'");
                            while($rob = mysqli_fetch_assoc($aa2_b))
                            { echo "'" .$rob['a_justi'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(239, 141, 9, 0.6)'],
                borderColor: ['rgba(239, 141, 9, 1)',],
                borderWidth: 2
              },
              {
                label: 'Si justificadas',
                data: [
                        <?php
                          $aa3 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Jose Leon Suarez' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($aa3))
                          {
                            $fecha_aa3 = $row['tecnico'];

                            $aa3_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi_si' FROM garantias WHERE tecnico = '$fecha_aa3' AND fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Jose Leon Suarez' AND justificado = 'SI'");
                            while($rob = mysqli_fetch_assoc($aa3_b))
                            { echo "'" .$rob['a_justi_si'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(10,55,117, 0.6)'],
                borderColor: ['rgba(10,55,117, 1)',],
                borderWidth: 2
              },
              {
                label: 'Sin justificar',
                data: [
                        <?php
                          $aa4 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Jose Leon Suarez' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($aa4))
                          {
                            $fecha_aa4 = $row['tecnico'];

                            $aa4_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi_sin' FROM garantias WHERE tecnico = '$fecha_aa4' AND fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Jose Leon Suarez' AND justificado = ''");
                            while($rob = mysqli_fetch_assoc($aa4_b))
                            { echo "'" .$rob['a_justi_sin'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(245,77,122, 0.6)'],
                borderColor: ['rgba(245,77,122, 1)',],
                borderWidth: 2
              }
            ]
        },
      options: { }
    };
    const graficos_gg_jls = new Chart(
      document.getElementById('analisis_garant_tec_jls'),
      config_gg_jls
    );
  </script>
<!-- SUAREZ -->
<!-- NICOLAS -->
  <script>
    const config_gg_sn = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'San Nicolas' GROUP BY tecnico");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .$row['tecnico'] ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total garantias',
                data: [
                        <?php
                          $aa1 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'San Nicolas' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($aa1))
                          {
                            $tecnico_aa1 = $row['tecnico'];

                            $aa1_a = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_garant' FROM garantias WHERE tecnico = '$tecnico_aa1' AND fecharep like '%$mes%' AND tecrep <> '' AND zona = 'San Nicolas'");
                            while($roa = mysqli_fetch_assoc($aa1_a))
                            { echo "'" .$roa['a_garant'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(40, 167, 69, 0.6)'],
                borderColor: ['rgba(40, 167, 69, 1)',],
                borderWidth: 2
              },
              {
                label: 'No justificadas',
                data: [
                        <?php
                          $aa2 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'San Nicolas' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($aa2))
                          {
                            $fecha_aa2 = $row['tecnico'];

                            $aa2_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi' FROM garantias WHERE tecnico = '$fecha_aa2' AND fecharep like '%$mes%' AND tecrep <> '' AND zona = 'San Nicolas' AND justificado = 'NO'");
                            while($rob = mysqli_fetch_assoc($aa2_b))
                            { echo "'" .$rob['a_justi'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(239, 141, 9, 0.6)'],
                borderColor: ['rgba(239, 141, 9, 1)',],
                borderWidth: 2
              },
              {
                label: 'Si justificadas',
                data: [
                        <?php
                          $aa3 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'San Nicolas' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($aa3))
                          {
                            $fecha_aa3 = $row['tecnico'];

                            $aa3_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi_si' FROM garantias WHERE tecnico = '$fecha_aa3' AND fecharep like '%$mes%' AND tecrep <> '' AND zona = 'San Nicolas' AND justificado = 'SI'");
                            while($rob = mysqli_fetch_assoc($aa3_b))
                            { echo "'" .$rob['a_justi_si'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(10,55,117, 0.6)'],
                borderColor: ['rgba(10,55,117, 1)',],
                borderWidth: 2
              },
              {
                label: 'Sin justificar',
                data: [
                        <?php
                          $aa4 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'San Nicolas' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($aa4))
                          {
                            $fecha_aa4 = $row['tecnico'];

                            $aa4_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_justi_sin' FROM garantias WHERE tecnico = '$fecha_aa4' AND fecharep like '%$mes%' AND tecrep <> '' AND zona = 'San Nicolas' AND justificado = ''");
                            while($rob = mysqli_fetch_assoc($aa4_b))
                            { echo "'" .$rob['a_justi_sin'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(245,77,122, 0.6)'],
                borderColor: ['rgba(245,77,122, 1)',],
                borderWidth: 2
              }
            ]
        },
      options: { }
    };
    const graficos_gg_sn = new Chart(
      document.getElementById('analisis_garant_tec_sn'),
      config_gg_sn
    );
  </script>
<!-- NICOLAS -->
<!-- TOTAL -->
  <script>
    const config_ggg = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $ga_tas = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' GROUP BY coment");
                        while($row = mysqli_fetch_assoc($ga_tas))
                        { echo "'" .$row['coment'] ."'," ; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Motivo de cierre',
                data: [
                        <?php
                          $g1 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' GROUP BY coment");
                          while($row = mysqli_fetch_assoc($g1))
                          {
                            $razones_g1 = $row['coment'];

                            $g1_a = mysqli_query($conn, "SELECT COUNT(coment) as 'cant_motivos' FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND coment = '$razones_g1'");
                            while($roa = mysqli_fetch_assoc($g1_a))
                            { echo "'" .$roa['cant_motivos'] ."'," ; }

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
    const graficos_ggg = new Chart(
      document.getElementById('analisis_garant_mot'),
      config_ggg
    );
  </script>
<!-- TOTAL -->
<!-- LOMAS -->
  <script>
    const config_ggg_lz = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $ga_tas_lz = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '$mes%' AND tecrep <> '' AND zona = 'Lomas de Zamora' GROUP BY coment");
                        while($row = mysqli_fetch_assoc($ga_tas_lz))
                        { echo "'" .$row['coment'] ."'," ; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Motivo de cierre',
                data: [
                        <?php
                          $g1_lz = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '$mes%' AND tecrep <> '' AND zona = 'Lomas de Zamora' GROUP BY coment");
                          while($rowe = mysqli_fetch_assoc($g1_lz))
                          {
                            $razones_g1 = $rowe['coment'];

                            $g1_b = mysqli_query($conn, "SELECT COUNT(coment) as 'cant_motivos' FROM garantias WHERE fecharep like '$mes%' AND tecrep <> '' AND zona = 'Lomas de Zamora' AND coment = '$razones_g1'");
                            while($roa = mysqli_fetch_assoc($g1_b))
                            { echo "'" .$roa['cant_motivos'] ."'," ; }

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
    const graficos_ggg_lz = new Chart(
      document.getElementById('analisis_garant_mot_lz'),
      config_ggg_lz
    );
  </script>
<!-- LOMAS -->
<!-- SUAREZ -->
  <script>
    const config_ggg_jls = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $ga_tas = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Jose Leon Suarez' GROUP BY coment");
                        while($row = mysqli_fetch_assoc($ga_tas))
                        { echo "'" .$row['coment'] ."'," ; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Motivo de cierre',
                data: [
                        <?php
                          $g1 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Jose Leon Suarez' GROUP BY coment");
                          while($row = mysqli_fetch_assoc($g1))
                          {
                            $razones_g1 = $row['coment'];

                            $g1_a = mysqli_query($conn, "SELECT COUNT(coment) as 'cant_motivos' FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'Jose Leon Suarez' AND coment = '$razones_g1'");
                            while($roa = mysqli_fetch_assoc($g1_a))
                            { echo "'" .$roa['cant_motivos'] ."'," ; }

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
    const graficos_ggg_jls = new Chart(
      document.getElementById('analisis_garant_mot_jls'),
      config_ggg_jls
    );
  </script>
<!-- SUAREZ -->
<!-- NICOLAS -->
  <script>
    const config_ggg_sn = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $ga_tas = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'San Nicolas' GROUP BY coment");
                        while($row = mysqli_fetch_assoc($ga_tas))
                        { echo "'" .$row['coment'] ."'," ; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Motivo de cierre',
                data: [
                        <?php
                          $g1 = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'San Nicolas' GROUP BY coment");
                          while($row = mysqli_fetch_assoc($g1))
                          {
                            $razones_g1 = $row['coment'];

                            $g1_a = mysqli_query($conn, "SELECT COUNT(coment) as 'cant_motivos' FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' AND zona = 'San Nicolas' AND coment = '$razones_g1'");
                            while($roa = mysqli_fetch_assoc($g1_a))
                            { echo "'" .$roa['cant_motivos'] ."'," ; }

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
    const graficos_ggg_sn = new Chart(
      document.getElementById('analisis_garant_mot_sn'),
      config_ggg_sn
    );
  </script>
<!-- NICOLAS -->
</body>
</html>