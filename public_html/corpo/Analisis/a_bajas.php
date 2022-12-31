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
    #analisis_bajas_ins
    {
      height: 40vh;
      width:40vw;
    }
    #analisis_bajas_tec
    {
      height: 40vh;
      width:40vw;
    }
    #analisis_bajas_mot
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
          <input type="hidden" name="link" value="../Analisis/a_bajas.php">
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
          <input type="hidden" name="link" value="../Analisis/a_bajas.php">
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
        $b = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' GROUP BY zona");
        while($row = mysqli_fetch_assoc($b))
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
            <div class="col-lg-6 col-md-6 col-sm-6 col-12 p-0">
              <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #E71D36 !important;">
                <div class="col-12 p-2">
                  <?php
                    $b_tot = mysqli_query($conn, "SELECT COUNT(tecnico) as 'b_bajas' FROM bajas WHERE calendario like '%$mes%'");
                    while($roa = mysqli_fetch_assoc($b_tot))
                    { $b_bajas = $roa['b_bajas']; }
                  ?>
                  <p class="h2 text-muted text-center"><?php echo $b_bajas; ?></p>
                  <p class="h4 text-muted text-center">Total</p>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-12 p-0">
              <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #EF8D09 !important;">
                <div class="col-12 p-2">
                  <?php
                    $b_2 = mysqli_query($conn, "SELECT COUNT(tecnico) as 'b_tkl' FROM bajas WHERE calendario like '%$mes%' AND tkl = ''");
                    while($roa = mysqli_fetch_assoc($b_2))
                    { $b_tkl = $roa['b_tkl']; }
                  ?>
                  <p class="h2 text-muted text-center"><?php echo $b_tkl; ?></p>
                  <p class="h4 text-muted text-center">Sin TKL</p>
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
                  <canvas id="analisis_bajas_ins" style="height:25vh; width:40vw"></canvas>
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
                        <tr>
                          <th>Tecnico</th>
                          <th data-toggle="tooltip" data-placement="bottom" title="Cantidad de bajas en el mes">Cant</th>
                          <th data-toggle="tooltip" data-placement="bottom" title="tkl sin entregar">tkl</th>
                        </tr>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $b1 = mysqli_query($conn, "SELECT COUNT(tecnico) as 'cantidadtec', tecnico FROM bajas  WHERE calendario like '%$mes%' GROUP BY tecnico ORDER BY tecnico asc");  
                        while($row = mysqli_fetch_assoc($b1))
                        { $tec = $row['tecnico']; ?>
                        <tr>
                        <td><?php echo $tec; ?></td>
                        <td align="center"><?php echo $row['cantidadtec']; ?></td>
                          <?php
                            $b2 = mysqli_query($conn, "SELECT COUNT(tkl) as 'cat_tkl', tecnico FROM bajas WHERE calendario like '%$mes%' AND tkl = '' AND tecnico= '$tec'");  
                            while($roww = mysqli_fetch_assoc($b2))
                            { ?>
                            <td align="center"><?php echo $roww['cat_tkl']; ?></td>
                          <?php } ?>
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
                  <canvas id="analisis_bajas_tec" style="height:35vh; width:40vw"></canvas>
                </div>
              </div>
              <div class="row rounded bg-white shadow m-1 p-2">
                <div class="col-12 p-0">
                  <p class="text-center text-muted h5">Motivos</p>
                </div>
                <div class="col-12 p-0">
                  <canvas id="analisis_bajas_mot" style="height:35vh; width:40vw"></canvas>
                </div>
              </div>
              
            </div>
          </div>
        </div>

      </div>

      <?php
        $bb = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' GROUP BY zona");
        while($row = mysqli_fetch_assoc($bb))
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
            <div class="col-lg-6 col-md-6 col-sm-6 col-12 p-0">
              <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #E71D36 !important;">
                <div class="col-12 p-2">
                  <?php
                    $b_tot = mysqli_query($conn, "SELECT COUNT(tecnico) as 'b_bajas' FROM bajas WHERE calendario like '%$mes%' AND zona = '$zona'");
                    while($roa = mysqli_fetch_assoc($b_tot))
                    { $b_bajas = $roa['b_bajas']; }
                  ?>
                  <p class="h2 text-muted text-center"><?php echo $b_bajas; ?></p>
                  <p class="h4 text-muted text-center">Total</p>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-12 p-0">
              <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #EF8D09 !important;">
                <div class="col-12 p-2">
                  <?php
                    $b_2 = mysqli_query($conn, "SELECT COUNT(tecnico) as 'b_tkl' FROM bajas WHERE calendario like '%$mes%' AND tkl = '' AND zona = '$zona'");
                    while($roa = mysqli_fetch_assoc($b_2))
                    { $b_tkl = $roa['b_tkl']; }
                  ?>
                  <p class="h2 text-muted text-center"><?php echo $b_tkl; ?></p>
                  <p class="h4 text-muted text-center">Sin TKL</p>
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
                  <canvas id="analisis_bajas_ins_<?php echo $zona_abre; ?>" style="height:25vh; width:40vw"></canvas>
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
                        <tr>
                          <th>Tecnico</th>
                          <th data-toggle="tooltip" data-placement="bottom" title="Cantidad de bajas en el mes">Cant</th>
                          <th data-toggle="tooltip" data-placement="bottom" title="tkl sin entregar">tkl</th>
                        </tr>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $b1 = mysqli_query($conn, "SELECT COUNT(tecnico) as 'cantidadtec_zona', tecnico FROM bajas WHERE calendario like '%$mes%' AND zona = '$zona' GROUP BY tecnico ORDER BY tecnico asc");  
                        while($rowo = mysqli_fetch_assoc($b1))
                        { $tecnic = $rowo['tecnico']; ?>
                        <tr>
                        <td><?php echo $tecnic; ?></td>
                        <td align="center"><?php echo $rowo['cantidadtec_zona']; ?></td>
                          <?php
                            $b2 = mysqli_query($conn, "SELECT COUNT(tkl) as 'cat_tkl_zona' FROM bajas WHERE calendario like '%$mes%' AND tkl = '' AND tecnico = '$tecnic' AND zona = '$zona'");  
                            while($rowi = mysqli_fetch_assoc($b2))
                            {
                          ?>
                            <td align="center"><?php echo $rowi['cat_tkl_zona']; ?></td>
                          <?php } ?>
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
                  <canvas id="analisis_bajas_tec_<?php echo $zona_abre; ?>" style="height:35vh; width:40vw"></canvas>
                </div>
              </div>
              <div class="row rounded bg-white shadow m-1 p-2">
                <div class="col-12 p-0">
                  <p class="text-center text-muted h5">Motivos</p>
                </div>
                <div class="col-12 p-0">
                  <canvas id="analisis_bajas_mot_<?php echo $zona_abre; ?>" style="height:35vh; width:40vw"></canvas>
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
    const config_b = {
      type: 'line',
      data: {
              labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' GROUP BY calendario");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .Fecha11($row['calendario']) ."',"; }
                      ?>
                    ],
              datasets: 
              [
                {
                  label: 'Total bajas',
                  data: [
                          <?php
                            $a1 = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' GROUP BY calendario");
                            while($row = mysqli_fetch_assoc($a1))
                            {
                              $fecha_a1 = $row['calendario'];

                              $a1_a = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_bajas' FROM bajas WHERE calendario = '$fecha_a1'");
                              while($roa = mysqli_fetch_assoc($a1_a))
                              { echo "'" .$roa['a_bajas'] ."'," ; }

                            }
                          ?>
                        ],
                  backgroundColor: ['rgba(231, 29, 54, 0.7)'],
                  borderColor: ['rgba(231, 29, 54, 0.5)',],
                  tension: 0.2
                },
                {
                  label: 'Sin numero de interaccion',
                  data: [
                          <?php
                            $a2 = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' GROUP BY calendario");
                            while($row = mysqli_fetch_assoc($a2))
                            {
                              $fecha_a2 = $row['calendario'];

                              $a2_b = mysqli_query($conn, "SELECT tkl, COUNT(tecnico) as 'a_tkl' FROM bajas WHERE calendario = '$fecha_a2' AND tkl = ''");
                              while($rob = mysqli_fetch_assoc($a2_b))
                              { echo "'" .$rob['a_tkl'] ."'," ; }

                            }
                          ?>
                        ],
                  backgroundColor: ['rgba(239, 141, 9, 0.7)'],
                  borderColor: ['rgba(239, 141, 9, 0.5)',],
                  tension: 0.2
                } 
              ]
        },
      options: {responsive:true,}
    };
    const graficos_b = new Chart(
      document.getElementById('analisis_bajas_ins'),
      config_b
    );
  </script>
<!-- TOTAL INS -->
<!-- LOMAS -->
  <script>
    const config_b_lz = {
      type: 'line',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY calendario");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .Fecha11($row['calendario']) ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total bajas',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY calendario");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $fecha_a1 = $row['calendario'];

                            $a1_a = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_bajas' FROM bajas WHERE calendario = '$fecha_a1' AND zona = 'Lomas de Zamora'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_bajas'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(231, 29, 54, 0.7)'],
                borderColor: ['rgba(231, 29, 54, 0.5)',],
                tension: 0.2
              },
              {
                label: 'Sin numero de interaccion',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY calendario");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $fecha_a2 = $row['calendario'];

                            $a2_b = mysqli_query($conn, "SELECT tkl, COUNT(tecnico) as 'a_tkl' FROM bajas WHERE calendario = '$fecha_a2' AND zona = 'Lomas de Zamora' AND tkl = ''");
                            while($rob = mysqli_fetch_assoc($a2_b))
                            { echo "'" .$rob['a_tkl'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(239, 141, 9, 0.7)'],
                borderColor: ['rgba(239, 141, 9, 0.5)',],
                tension: 0.2
              } 
            ]
        },
      options: {responsive:true,}
    };
    const graficos_b_lz = new Chart(
      document.getElementById('analisis_bajas_ins_lz'),
      config_b_lz
    );
  </script>
<!-- LOMAS -->
<!-- SUAREZ -->
  <script>
    const config_b_jlz = {
      type: 'line',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY calendario");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .Fecha11($row['calendario']) ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total bajas',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY calendario");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $fecha_a1 = $row['calendario'];

                            $a1_a = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_bajas' FROM bajas WHERE calendario = '$fecha_a1' AND zona = 'Jose Leon Suarez'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_bajas'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(231, 29, 54, 0.7)'],
                borderColor: ['rgba(231, 29, 54, 0.5)',],
                tension: 0.2
              },
              {
                label: 'Sin numero de interaccion',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY calendario");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $fecha_a2 = $row['calendario'];

                            $a2_b = mysqli_query($conn, "SELECT tkl, COUNT(tecnico) as 'a_tkl' FROM bajas WHERE calendario = '$fecha_a2' AND zona = 'Jose Leon Suarez' AND tkl = ''");
                            while($rob = mysqli_fetch_assoc($a2_b))
                            { echo "'" .$rob['a_tkl'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(239, 141, 9, 0.7)'],
                borderColor: ['rgba(239, 141, 9, 0.5)',],
                tension: 0.2
              } 
            ]
        },
      options: {responsive:true,}
    };
    const graficos_b_jlz = new Chart(
      document.getElementById('analisis_bajas_ins_jls'),
      config_b_jlz
    );
  </script>
<!-- SUAREZ -->
<!-- NICOLAS -->
  <script>
    const config_b_sn = {
      type: 'line',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' AND zona = 'San Nicolas' GROUP BY calendario");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .Fecha11($row['calendario']) ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total bajas',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' AND zona = 'San Nicolas' GROUP BY calendario");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $fecha_a1 = $row['calendario'];

                            $a1_a = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_bajas' FROM bajas WHERE calendario = '$fecha_a1' AND zona = 'San Nicolas'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_bajas'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(231, 29, 54, 0.7)'],
                borderColor: ['rgba(231, 29, 54, 0.5)',],
                tension: 0.2
              },
              {
                label: 'Sin numero de interaccion',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' AND zona = 'San Nicolas' GROUP BY calendario");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $fecha_a2 = $row['calendario'];

                            $a2_b = mysqli_query($conn, "SELECT tkl, COUNT(tecnico) as 'a_tkl' FROM bajas WHERE calendario = '$fecha_a2' AND zona = 'San Nicolas' AND tkl = ''");
                            while($rob = mysqli_fetch_assoc($a2_b))
                            { echo "'" .$rob['a_tkl'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(239, 141, 9, 0.7)'],
                borderColor: ['rgba(239, 141, 9, 0.5)',],
                tension: 0.2
              } 
            ]
        },
      options: {responsive:true,}
    };
    const graficos_b_sn = new Chart(
      document.getElementById('analisis_bajas_ins_sn'),
      config_b_sn
    );
  </script>
<!-- NICOLAS -->
<!-- TOTAL -->
  <script>
    const config_bb = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' GROUP BY tecnico");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .$row['tecnico'] ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total bajas',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $tecnico_a1 = $row['tecnico'];

                            $a1_a = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_bajas' FROM bajas WHERE tecnico = '$tecnico_a1' AND calendario like '%$mes%'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_bajas'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(231, 29, 54, 0.6)'],
                borderColor: ['rgba(231, 29, 54, 1)',],
                borderWidth: 2
              },
              {
                label: 'Sin numero de interaccion',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $tecnico_a2 = $row['tecnico'];

                            $a2_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_bajas_tkl' FROM bajas WHERE tecnico = '$tecnico_a2' AND calendario like '%$mes%' AND tkl = ''");
                            while($rob = mysqli_fetch_assoc($a2_b))
                            { echo "'" .$rob['a_bajas_tkl'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(239, 141, 9, 0.6)'],
                borderColor: ['rgba(239, 141, 9, 1)',],
                borderWidth: 2
              }
            ]
        },
      options: {responsive:true,}
    };
    const graficos_bb = new Chart(
      document.getElementById('analisis_bajas_tec'),
      config_bb
    );
  </script>
<!-- TOTAL -->
<!-- LOMAS -->
  <script>
    const config_bb_lz = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY tecnico");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .$row['tecnico'] ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total bajas',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $tecnico_a1 = $row['tecnico'];

                            $a1_a = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_bajas' FROM bajas WHERE tecnico = '$tecnico_a1' AND calendario like '%$mes%' AND zona = 'Lomas de Zamora'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_bajas'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(231, 29, 54, 0.6)'],
                borderColor: ['rgba(231, 29, 54, 1)',],
                borderWidth: 2
              },
              {
                label: 'Sin numero de interaccion',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $tecnico_a2 = $row['tecnico'];

                            $a2_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_bajas_tkl' FROM bajas WHERE tecnico = '$tecnico_a2' AND zona = 'Lomas de Zamora' AND calendario like '%$mes%' AND tkl = ''");
                            while($rob = mysqli_fetch_assoc($a2_b))
                            { echo "'" .$rob['a_bajas_tkl'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(239, 141, 9, 0.6)'],
                borderColor: ['rgba(239, 141, 9, 1)',],
                borderWidth: 2
              }
            ]
        },
      options: {responsive:true,}
    };
    const graficos_bb_lz = new Chart(
      document.getElementById('analisis_bajas_tec_lz'),
      config_bb_lz
    );
  </script>
<!-- LOMAS -->
<!-- SUAREZ -->
  <script>
    const config_bb_jls = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY tecnico");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .$row['tecnico'] ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total bajas',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $tecnico_a1 = $row['tecnico'];

                            $a1_a = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_bajas' FROM bajas WHERE tecnico = '$tecnico_a1' AND calendario like '%$mes%' AND zona = 'Jose Leon Suarez'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_bajas'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(231, 29, 54, 0.6)'],
                borderColor: ['rgba(231, 29, 54, 1)',],
                borderWidth: 2
              },
              {
                label: 'Sin numero de interaccion',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $tecnico_a2 = $row['tecnico'];

                            $a2_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_bajas_tkl' FROM bajas WHERE tecnico = '$tecnico_a2' AND zona = 'Jose Leon Suarez' AND calendario like '%$mes%' AND tkl = ''");
                            while($rob = mysqli_fetch_assoc($a2_b))
                            { echo "'" .$rob['a_bajas_tkl'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(239, 141, 9, 0.6)'],
                borderColor: ['rgba(239, 141, 9, 1)',],
                borderWidth: 2
              }
            ]
        },
      options: {responsive:true,}
    };
    const graficos_bb_jls = new Chart(
      document.getElementById('analisis_bajas_tec_jls'),
      config_bb_jls
    );
  </script>
<!-- SUAREZ -->
<!-- NICOLAS -->
  <script>
    const config_bb_sn = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' AND zona = 'San Nicolas' GROUP BY tecnico");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .$row['tecnico'] ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total bajas',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' AND zona = 'San Nicolas' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $tecnico_a1 = $row['tecnico'];

                            $a1_a = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_bajas' FROM bajas WHERE tecnico = '$tecnico_a1' AND calendario like '%$mes%' AND zona = 'San Nicolas'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_bajas'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(231, 29, 54, 0.6)'],
                borderColor: ['rgba(231, 29, 54, 1)',],
                borderWidth: 2
              },
              {
                label: 'Sin numero de interaccion',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' AND zona = 'San Nicolas' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $tecnico_a2 = $row['tecnico'];

                            $a2_b = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_bajas_tkl' FROM bajas WHERE tecnico = '$tecnico_a2' AND zona = 'San Nicolas' AND calendario like '%$mes%' AND tkl = ''");
                            while($rob = mysqli_fetch_assoc($a2_b))
                            { echo "'" .$rob['a_bajas_tkl'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(239, 141, 9, 0.6)'],
                borderColor: ['rgba(239, 141, 9, 1)',],
                borderWidth: 2
              }
            ]
        },
      options: {responsive:true,}
    };
    const graficos_bb_sn = new Chart(
      document.getElementById('analisis_bajas_tec_sn'),
      config_bb_sn
    );
  </script>
<!-- NICOLAS -->
<!-- TOTAL -->
  <script>
    const config_bbb = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' GROUP BY motivo");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .$row['motivo'] ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Motivo de cierre',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' GROUP BY motivo");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $razones_a1 = $row['motivo'];

                            $a1_a = mysqli_query($conn, "SELECT COUNT(motivo) as 'motivos' FROM bajas WHERE calendario like '%$mes%' AND motivo = '$razones_a1'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['motivos'] ."'," ; }

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
    const graficos_bbb = new Chart(
      document.getElementById('analisis_bajas_mot'),
      config_bbb
    );
  </script>
<!-- TOTAL -->
<!-- LOMAS -->
  <script>
    const config_bbb_lz = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY motivo");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .$row['motivo'] ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Motivo de cierre',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY motivo");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $razones_a1 = $row['motivo'];

                            $a1_a = mysqli_query($conn, "SELECT COUNT(motivo) as 'motivos' FROM bajas WHERE calendario like '%$mes%' AND zona = 'Lomas de Zamora' AND motivo = '$razones_a1'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['motivos'] ."'," ; }

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
    const graficos_bbb_lz = new Chart(
      document.getElementById('analisis_bajas_mot_lz'),
      config_bbb_lz
    );
  </script>
<!-- LOMAS -->
<!-- SUAREZ -->
  <script>
    const config_bbb_jls = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY motivo");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .$row['motivo'] ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Motivo de cierre',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY motivo");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $razones_a1 = $row['motivo'];

                            $a1_a = mysqli_query($conn, "SELECT COUNT(motivo) as 'motivos' FROM bajas WHERE calendario like '%$mes%' AND zona = 'Jose Leon Suarez' AND motivo = '$razones_a1'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['motivos'] ."'," ; }

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
    const graficos_bbb_jls = new Chart(
      document.getElementById('analisis_bajas_mot_jls'),
      config_bbb_jls
    );
  </script>
<!-- SUAREZ -->
<!-- NICOLAS -->
  <script>
    const config_bbb_sn = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' AND zona = 'San Nicolas' GROUP BY motivo");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .$row['motivo'] ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Motivo de cierre',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM bajas WHERE calendario like '%$mes%' AND zona = 'San Nicolas' GROUP BY motivo");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $razones_a1 = $row['motivo'];

                            $a1_a = mysqli_query($conn, "SELECT COUNT(motivo) as 'motivos' FROM bajas WHERE calendario like '%$mes%' AND zona = 'San Nicolas' AND motivo = '$razones_a1'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['motivos'] ."'," ; }

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
    const graficos_bbb_sn = new Chart(
      document.getElementById('analisis_bajas_mot_sn'),
      config_bbb_sn
    );
  </script>
<!-- NICOLAS -->
</body>
</html>