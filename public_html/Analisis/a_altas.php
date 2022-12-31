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
    #analisis_exitosas_ins
    {
      height: 40vh;
      width:40vw;
    }
    #analisis_exitosas_tec
    {
      height: 40vh;
      width:40vw;
    }
    #analisis_exitosas_mot
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
          <input type="hidden" name="link" value="../Analisis/a_altas.php">
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
          <input type="hidden" name="link" value="../Analisis/a_altas.php">
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
          <div class="col-lg-4 col-md-12 col-sm-12 col-12 p-0">
            <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #FF595E !important;">
              <div class="col-12 p-2">
                <?php
                  $a_tot = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas' FROM produccion WHERE fecha like '%$mes%'");
                  while($roa = mysqli_fetch_assoc($a_tot))
                  { $a_altas = $roa['a_altas']; }
                ?>
                <p class="h2 text-muted text-center"><?php echo $a_altas; ?></p>
                <p class="h4 text-muted text-center">Total</p>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-6 col-sm-6 col-12 p-0">
            <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #219EBC !important;">
              <div class="col-12 p-2">
                <?php
                  $a_2 = mysqli_query($conn, "SELECT SUM(dosplay) as 'a_dos' FROM produccion WHERE fecha like '%$mes%'");
                  while($roa = mysqli_fetch_assoc($a_2))
                  { $a_dos = $roa['a_dos']; }
                ?>
                <p class="h2 text-muted text-center"><?php echo $a_dos; ?></p>
                <p class="h4 text-muted text-center">3 play</p>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-6 col-sm-6 col-12 p-0">
            <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #F15BB5 !important;">
              <div class="col-12 p-2">
                <?php
                  $a_3 = mysqli_query($conn, "SELECT SUM(tresplay) as 'a_tres' FROM produccion WHERE fecha like '%$mes%'");
                  while($roa = mysqli_fetch_assoc($a_3))
                  { $a_tres = $roa['a_tres']; }
                ?>
                <p class="h2 text-muted text-center"><?php echo $a_tres; ?></p>
                <p class="h4 text-muted text-center">2 play</p>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-6 col-sm-6 col-12 p-0">
            <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #80ED99 !important;">
              <div class="col-12 p-2">
                <?php
                  $a_ssttbb = mysqli_query($conn, "SELECT SUM(stb) as 'a_stb' FROM produccion WHERE fecha like '%$mes%'");
                  while($roa = mysqli_fetch_assoc($a_ssttbb))
                  { $a_stb = $roa['a_stb']; }
                ?>
                <p class="h2 text-muted text-center"><?php echo $a_stb; ?></p>
                <p class="h4 text-muted text-center">STB</p>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-6 col-sm-6 col-12 p-0">
            <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #FB8500 !important;">
              <div class="col-12 p-2">
                <?php
                  $a_mud = mysqli_query($conn, "SELECT SUM(mudanza) as 'a_mudanza' FROM produccion WHERE fecha like '%$mes%'");
                  while($roa = mysqli_fetch_assoc($a_mud))
                  { $a_mudanza = $roa['a_mudanza']; }
                ?>
                <p class="h2 text-muted text-center"><?php echo $a_mudanza; ?></p>
                <p class="h4 text-muted text-center">Mud int</p>
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
              <div class="col-auto p-0 mx-auto">
                <table class="table table-striped table-bordered table-md table-sm table-responsive">
                  <thead class="thead-dark text-center">
                    <tr>
                      <th>Tipo</th>
                      <th data-toggle="tooltip" data-placement="bottom" title="Cantidad de tareas en el mes">Cant</th>
                      <th data-toggle="tooltip" data-placement="bottom" title="Cantidad de TV en el mes">TV</th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr>
                        <td>2P</td>
                        <?php
                          $dos_pe = mysqli_query($conn, "SELECT COUNT(codigo) as 'codigo' FROM carga_dia WHERE fecha like '%$mes%' AND codigo = '2P' AND estado = 'finalizada' AND actividad = 'Instalacion' ");
                          while($row = mysqli_fetch_assoc($dos_pe))
                          { $dos_pley = $row['codigo']; }
                        ?>
                        <td align="center"><?php echo $dos_pley; ?></td>
                        <td align="center">-</td>
                      </tr>
                      <tr>
                        <td>Mud</td>
                        <?php
                          $mud = mysqli_query($conn, "SELECT COUNT(codigo) as 'codigo_mud' FROM carga_dia WHERE fecha like '%$mes%' AND estado = 'finalizada' AND actividad = 'Visita tecnica por mudanza' ");
                          while($row = mysqli_fetch_assoc($mud))
                          { $codigo_mud = $row['codigo_mud']; }
                        ?>
                        <td align="center"><?php echo $codigo_mud; ?></td>
                        <?php
                          $mud_tv = mysqli_query($conn, "SELECT SUM(cantidad_tv) as 'codigo_mud_tv' FROM carga_dia WHERE fecha like '%$mes%' AND estado = 'finalizada' AND actividad = 'Visita tecnica por mudanza' ");
                          while($row = mysqli_fetch_assoc($mud_tv))
                          { $codigo_mud_tv = $row['codigo_mud_tv']; }
                        ?>
                        <td align="center"><?php echo $codigo_mud_tv; ?></td>
                      </tr>
                      <tr>
                        <td>3P1D</td>
                        <?php
                          $tres_pe = mysqli_query($conn, "SELECT COUNT(codigo) as 'codigo_3p1d' FROM carga_dia WHERE fecha like '%$mes%' AND codigo = '3P1D' AND estado = 'finalizada' AND actividad = 'Instalacion' ");
                          while($row = mysqli_fetch_assoc($tres_pe))
                          { $tres_pley_uno = $row['codigo_3p1d']; }
                        ?>
                        <td align="center"><?php echo $tres_pley_uno; ?></td>
                        <td align="center"><?php echo $tres_pley_uno *1; ?></td>
                      </tr>
                      <tr>
                        <td>3P2D</td>
                        <?php
                          $tres_pe_dos = mysqli_query($conn, "SELECT COUNT(codigo) as 'codigo_3p2d' FROM carga_dia WHERE fecha like '%$mes%' AND codigo = '3P2D' AND estado = 'finalizada' AND actividad = 'Instalacion' ");
                          while($row = mysqli_fetch_assoc($tres_pe_dos))
                          { $tres_pley_dos = $row['codigo_3p2d']; }
                        ?>
                        <td align="center"><?php echo $tres_pley_dos; ?></td>
                        <td align="center"><?php echo $tres_pley_dos *2; ?></td>
                      </tr>
                      <tr>
                        <td>3P3D</td>
                        <?php
                          $tres_pe_tres = mysqli_query($conn, "SELECT COUNT(codigo) as 'codigo_3p3d' FROM carga_dia WHERE fecha like '%$mes%' AND codigo = '3P3D' AND estado = 'finalizada' AND actividad = 'Instalacion' ");
                          while($row = mysqli_fetch_assoc($tres_pe_tres))
                          { $tres_pley_tres = $row['codigo_3p3d']; }
                        ?>
                        <td align="center"><?php echo $tres_pley_tres; ?></td>
                        <td align="center"><?php echo $tres_pley_tres *3; ?></td>
                      </tr>
                      <tr>
                        <td>ADTV</td>
                        <?php
                          $add_tv = mysqli_query($conn, "SELECT COUNT(codigo) as 'codigo_adtv' FROM carga_dia WHERE fecha like '%$mes%' AND codigo = 'ADTV' AND estado = 'finalizada' AND actividad = 'Instalacion' ");
                          while($row = mysqli_fetch_assoc($add_tv))
                          { $codigo_adtv = $row['codigo_adtv']; }
                        ?>
                        <td align="center"><?php echo $codigo_adtv; ?></td>
                        <?php
                          $add_tv_cant = mysqli_query($conn, "SELECT SUM(cantidad_tv) as 'cant_tv' FROM carga_dia WHERE fecha like '%$mes%' AND codigo = 'ADTV' AND estado = 'finalizada' AND actividad = 'Instalacion' ");
                          while($row = mysqli_fetch_assoc($add_tv_cant))
                          { $cant_tv = $row['cant_tv']; }
                        ?>
                        <td align="center"><?php echo $cant_tv *1; ?></td>
                      </tr>
                      <tr>
                      <td>Total</td>
                        <td align="center"><?php echo $dos_pley + $codigo_mud + $tres_pley_uno + $tres_pley_dos + $tres_pley_tres + $codigo_adtv; ?></td>
                        <td align="center"><?php echo $codigo_mud_tv + $tres_pley_uno + ($tres_pley_dos *2) + ($tres_pley_tres *3) + $cant_tv; ?></td>
                      </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-12 col-md-10 p-0">
                <canvas id="analisis_exitosas_ins" style="height:25vh; width:40vw"></canvas>
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
                      <th data-toggle="tooltip" data-placement="bottom" title="Cantidad de altas en el mes">Cant</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $b1 = mysqli_query($conn, "SELECT SUM(tcumplida) as 'cantidadalta', tecnico FROM produccion WHERE fecha like '%$mes%' GROUP BY tecnico ORDER BY tecnico asc");  
                      while($row = mysqli_fetch_assoc($b1))
                      { $tec = $row['tecnico']; ?>
                      <tr>                       
                        <td><?php echo $tec; ?></td>
                        <td align="center"><?php echo $row['cantidadalta']; ?></td>
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
                <canvas id="analisis_exitosas_tec" style="height:35vh; width:40vw"></canvas>
              </div>
            </div>
            <div class="row rounded bg-white shadow m-1 p-2">
              <div class="col-12 p-0">
                <p class="text-center text-muted h5">Motivos</p>
              </div>
              <div class="col-12 p-0">
                <canvas id="analisis_exitosas_mot" style="height:35vh; width:40vw"></canvas>
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
          <div class="col-lg-4 col-md-12 col-sm-12 col-12 p-0">
            <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #FF595E !important;">
              <div class="col-12 p-2">
                <?php
                  $a_tot = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas' FROM produccion WHERE fecha like '%$mes%' AND zona = '$zona'");
                  while($roa = mysqli_fetch_assoc($a_tot))
                  { $a_altas = $roa['a_altas']; }
                ?>
                <p class="h2 text-muted text-center"><?php echo $a_altas; ?></p>
                <p class="h4 text-muted text-center">Total</p>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-6 col-sm-6 col-12 p-0">
            <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #219EBC !important;">
              <div class="col-12 p-2">
                <?php
                  $a_2 = mysqli_query($conn, "SELECT SUM(dosplay) as 'a_dos' FROM produccion WHERE fecha like '%$mes%' AND zona = '$zona'");
                  while($roa = mysqli_fetch_assoc($a_2))
                  { $a_dos = $roa['a_dos']; }
                ?>
                <p class="h2 text-muted text-center"><?php echo $a_dos; ?></p>
                <p class="h4 text-muted text-center">3 play</p>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-6 col-sm-6 col-12 p-0">
            <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #F15BB5 !important;">
              <div class="col-12 p-2">
                <?php
                  $a_3 = mysqli_query($conn, "SELECT SUM(tresplay) as 'a_tres' FROM produccion WHERE fecha like '%$mes%' AND zona = '$zona'");
                  while($roa = mysqli_fetch_assoc($a_3))
                  { $a_tres = $roa['a_tres']; }
                ?>
                <p class="h2 text-muted text-center"><?php echo $a_tres; ?></p>
                <p class="h4 text-muted text-center">2 play</p>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-6 col-sm-6 col-12 p-0">
            <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #80ED99 !important;">
              <div class="col-12 p-2">
                <?php
                  $a_ssttbb = mysqli_query($conn, "SELECT SUM(stb) as 'a_stb' FROM produccion WHERE fecha like '%$mes%' AND zona = '$zona'");
                  while($roa = mysqli_fetch_assoc($a_ssttbb))
                  { $a_stb = $roa['a_stb']; }
                ?>
                <p class="h2 text-muted text-center"><?php echo $a_stb; ?></p>
                <p class="h4 text-muted text-center">STB</p>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-6 col-sm-6 col-12 p-0">
            <div class="row rounded bg-white shadow m-1 border-left text-muted" style="border-left: 6px solid #FB8500 !important;">
              <div class="col-12 p-2">
                <?php
                  $a_mud = mysqli_query($conn, "SELECT SUM(mudanza) as 'a_mudanza' FROM produccion WHERE fecha like '%$mes%' AND zona = '$zona'");
                  while($roa = mysqli_fetch_assoc($a_mud))
                  { $a_mudanza = $roa['a_mudanza']; }
                ?>
                <p class="h2 text-muted text-center"><?php echo $a_mudanza; ?></p>
                <p class="h4 text-muted text-center">Mud int</p>
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
                <canvas id="analisis_altas_ins_<?php echo $zona_abre; ?>" style="height:25vh; width:40vw"></canvas>
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
                      <th data-toggle="tooltip" data-placement="bottom" title="Cantidad de altas en el mes">Cant</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $b1 = mysqli_query($conn, "SELECT SUM(tcumplida) as 'cantidadalta', tecnico FROM produccion WHERE fecha like '%$mes%' AND zona = '$zona' GROUP BY tecnico ORDER BY tecnico asc");  
                      while($row = mysqli_fetch_assoc($b1))
                      { $tec = $row['tecnico']; ?>
                      <tr>                       
                        <td><?php echo $tec; ?></td>
                        <td align="center"><?php echo $row['cantidadalta']; ?></td>
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
                <canvas id="analisis_altas_tec_<?php echo $zona_abre; ?>" style="height:35vh; width:40vw"></canvas>
              </div>
            </div>
            <div class="row rounded bg-white shadow m-1 p-2">
              <div class="col-12 p-0">
                <p class="text-center text-muted h5">Motivos</p>
              </div>
              <div class="col-12 p-0">
                <canvas id="analisis_motivos_mot_<?php echo $zona_abre; ?>" style="height:35vh; width:40vw"></canvas>
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
<script src="/chart/dist/chart.js"></script>
<!-- TOTAL -->
  <script>
    const config_a = {
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
                label: 'Total altas',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $fecha_a1 = $row['fecha'];

                            $a1_a = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas' FROM produccion WHERE fecha = '$fecha_a1'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_altas'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(255, 89, 94, 0.7)'],
                borderColor: ['rgba(255, 89, 94, 0.5)',],
                tension: 0.2
              },
              {
                label: '2 Play',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $fecha_a2 = $row['fecha'];

                            $a2_b = mysqli_query($conn, "SELECT SUM(dosplay) as 'a_dosplay' FROM produccion WHERE fecha = '$fecha_a2'");
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
                          $a3 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a3))
                          {
                            $fecha_a3 = $row['fecha'];

                            $a3_c = mysqli_query($conn, "SELECT SUM(tresplay) as 'a_tresplay' FROM produccion WHERE fecha = '$fecha_a3'");
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
                          $a4 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a4))
                          {
                            $fecha_a4 = $row['fecha'];

                            $a4_d = mysqli_query($conn, "SELECT SUM(stb) as 'a_stb' FROM produccion WHERE fecha = '$fecha_a4'");
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
                label: 'Mudanzas internas',
                data: [
                        <?php
                          $a5 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a5))
                          {
                            $fecha_a5 = $row['fecha'];

                            $a5_e = mysqli_query($conn, "SELECT SUM(mudanza) as 'a_mudanza' FROM produccion WHERE fecha = '$fecha_a5'");
                            while($roe = mysqli_fetch_assoc($a5_e))
                            { echo "'" .$roe['a_mudanza'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(251, 133, 0, 0.7)'],
                borderColor: ['rgba(251, 133, 0, 0.5)',],
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
<!-- TOTAL -->
<!-- TOTAL LZ -->
  <script>
    const config_a_lz = {
      type: 'line',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY fecha");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .Fecha11($row['fecha']) ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total altas',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $fecha_a1 = $row['fecha'];

                            $a1_a = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas' FROM produccion WHERE fecha = '$fecha_a1' AND zona = 'Lomas de Zamora'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_altas'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(255, 89, 94, 0.7)'],
                borderColor: ['rgba(255, 89, 94, 0.5)',],
                tension: 0.2
              },
              {
                label: '2 Play',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $fecha_a2 = $row['fecha'];

                            $a2_b = mysqli_query($conn, "SELECT SUM(dosplay) as 'a_dosplay' FROM produccion WHERE fecha = '$fecha_a2' AND zona = 'Lomas de Zamora'");
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
                          $a3 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a3))
                          {
                            $fecha_a3 = $row['fecha'];

                            $a3_c = mysqli_query($conn, "SELECT SUM(tresplay) as 'a_tresplay' FROM produccion WHERE fecha = '$fecha_a3' AND zona = 'Lomas de Zamora'");
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
                          $a4 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a4))
                          {
                            $fecha_a4 = $row['fecha'];

                            $a4_d = mysqli_query($conn, "SELECT SUM(stb) as 'a_stb' FROM produccion WHERE fecha = '$fecha_a4' AND zona = 'Lomas de Zamora'");
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
                label: 'Mudanzas internas',
                data: [
                        <?php
                          $a5 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a5))
                          {
                            $fecha_a5 = $row['fecha'];

                            $a5_e = mysqli_query($conn, "SELECT SUM(mudanza) as 'a_mudanza' FROM produccion WHERE fecha = '$fecha_a5' AND zona = 'Lomas de Zamora'");
                            while($roe = mysqli_fetch_assoc($a5_e))
                            { echo "'" .$roe['a_mudanza'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(251, 133, 0, 0.7)'],
                borderColor: ['rgba(251, 133, 0, 0.5)',],
                tension: 0.2
              }, 
            ]
        },
      options: {responsive:true,}
    };
    const graficos_a_lz = new Chart(
      document.getElementById('analisis_altas_ins_lz'),
      config_a_lz
    );
  </script>
<!-- TOTAL LZ -->
<!-- TOTAL JLS -->
  <script>
    const config_a_jls = {
      type: 'line',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY fecha");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .Fecha11($row['fecha']) ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total altas',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $fecha_a1 = $row['fecha'];

                            $a1_a = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas' FROM produccion WHERE fecha = '$fecha_a1' AND zona = 'Jose Leon Suarez'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_altas'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(255, 89, 94, 0.7)'],
                borderColor: ['rgba(255, 89, 94, 0.5)',],
                tension: 0.2
              },
              {
                label: '2 Play',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $fecha_a2 = $row['fecha'];

                            $a2_b = mysqli_query($conn, "SELECT SUM(dosplay) as 'a_dosplay' FROM produccion WHERE fecha = '$fecha_a2' AND zona = 'Jose Leon Suarez'");
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
                          $a3 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a3))
                          {
                            $fecha_a3 = $row['fecha'];

                            $a3_c = mysqli_query($conn, "SELECT SUM(tresplay) as 'a_tresplay' FROM produccion WHERE fecha = '$fecha_a3' AND zona = 'Jose Leon Suarez'");
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
                          $a4 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a4))
                          {
                            $fecha_a4 = $row['fecha'];

                            $a4_d = mysqli_query($conn, "SELECT SUM(stb) as 'a_stb' FROM produccion WHERE fecha = '$fecha_a4' AND zona = 'Jose Leon Suarez'");
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
                label: 'Mudanzas internas',
                data: [
                        <?php
                          $a5 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a5))
                          {
                            $fecha_a5 = $row['fecha'];

                            $a5_e = mysqli_query($conn, "SELECT SUM(mudanza) as 'a_mudanza' FROM produccion WHERE fecha = '$fecha_a5' AND zona = 'Jose Leon Suarez'");
                            while($roe = mysqli_fetch_assoc($a5_e))
                            { echo "'" .$roe['a_mudanza'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(251, 133, 0, 0.7)'],
                borderColor: ['rgba(251, 133, 0, 0.5)',],
                tension: 0.2
              }, 
            ]
        },
      options: {responsive:true,}
    };
    const graficos_a_jls = new Chart(
      document.getElementById('analisis_altas_ins_jls'),
      config_a_jls
    );
  </script>
<!-- TOTAL JLS -->
<!-- TOTAL SN -->
  <script>
    const config_a_sn = {
      type: 'line',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'San Nicolas' GROUP BY fecha");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .Fecha11($row['fecha']) ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total altas',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'San Nicolas' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $fecha_a1 = $row['fecha'];

                            $a1_a = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas' FROM produccion WHERE fecha = '$fecha_a1' AND zona = 'San Nicolas'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_altas'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(255, 89, 94, 0.7)'],
                borderColor: ['rgba(255, 89, 94, 0.5)',],
                tension: 0.2
              },
              {
                label: '2 Play',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'San Nicolas' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $fecha_a2 = $row['fecha'];

                            $a2_b = mysqli_query($conn, "SELECT SUM(dosplay) as 'a_dosplay' FROM produccion WHERE fecha = '$fecha_a2' AND zona = 'San Nicolas'");
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
                          $a3 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'San Nicolas' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a3))
                          {
                            $fecha_a3 = $row['fecha'];

                            $a3_c = mysqli_query($conn, "SELECT SUM(tresplay) as 'a_tresplay' FROM produccion WHERE fecha = '$fecha_a3' AND zona = 'San Nicolas'");
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
                          $a4 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'San Nicolas' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a4))
                          {
                            $fecha_a4 = $row['fecha'];

                            $a4_d = mysqli_query($conn, "SELECT SUM(stb) as 'a_stb' FROM produccion WHERE fecha = '$fecha_a4' AND zona = 'San Nicolas'");
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
                label: 'Mudanzas internas',
                data: [
                        <?php
                          $a5 = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' AND zona = 'San Nicolas' GROUP BY fecha");
                          while($row = mysqli_fetch_assoc($a5))
                          {
                            $fecha_a5 = $row['fecha'];

                            $a5_e = mysqli_query($conn, "SELECT SUM(mudanza) as 'a_mudanza' FROM produccion WHERE fecha = '$fecha_a5' AND zona = 'San Nicolas'");
                            while($roe = mysqli_fetch_assoc($a5_e))
                            { echo "'" .$roe['a_mudanza'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(251, 133, 0, 0.7)'],
                borderColor: ['rgba(251, 133, 0, 0.5)',],
                tension: 0.2
              }, 
            ]
        },
      options: {responsive:true,}
    };
    const graficos_a_sn = new Chart(
      document.getElementById('analisis_altas_ins_sn'),
      config_a_sn
    );
  </script>
<!-- TOTAL SN --> 
<!-- TOTAL -->
  <script>
    const config_aa = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas', tecnico FROM produccion WHERE fecha like '%$mes%' GROUP BY tecnico");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .$row['tecnico'] ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total altas',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas', tecnico FROM produccion WHERE fecha like '%$mes%' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $tecnico_a1 = $row['tecnico'];

                            $a1_a = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas' FROM produccion WHERE tecnico = '$tecnico_a1' AND fecha like '%$mes%'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_altas'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(255, 89, 94, 0.6)'],
                borderColor: ['rgba(255, 89, 94, 1)',],
                borderWidth: 2,
              },
              {
                label: '2 Play',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas', tecnico FROM produccion WHERE fecha like '%$mes%' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $tecnico_a2 = $row['tecnico'];

                            $a2_b = mysqli_query($conn, "SELECT SUM(dosplay) as 'a_dosplay' FROM produccion WHERE tecnico = '$tecnico_a2' AND fecha like '%$mes%'");
                            while($rob = mysqli_fetch_assoc($a2_b))
                            { echo "'" .$rob['a_dosplay'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(33, 158, 188, 0.6)'],
                borderColor: ['rgba(33, 158, 188, 1)',],
                borderWidth: 2,
              },
              {
                label: '3 Play',
                data: [
                        <?php
                          $a3 = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas', tecnico FROM produccion WHERE fecha like '%$mes%' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a3))
                          {
                            $tecnico_a3 = $row['tecnico'];

                            $a3_c = mysqli_query($conn, "SELECT SUM(tresplay) as 'a_tresplay' FROM produccion WHERE tecnico = '$tecnico_a3' AND fecha like '%$mes%'");
                            while($roc = mysqli_fetch_assoc($a3_c))
                            { echo "'" .$roc['a_tresplay'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(241, 91, 181, 0.6)'],
                borderColor: ['rgba(241, 91, 181, 1)',],
                borderWidth: 2,
              },
              {
                label: 'STB',
                data: [
                        <?php
                          $a4 = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas', tecnico FROM produccion WHERE fecha like '%$mes%' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a4))
                          {
                            $tecnico_a4 = $row['tecnico'];

                            $a4_d = mysqli_query($conn, "SELECT SUM(stb) as 'a_stb' FROM produccion WHERE tecnico = '$tecnico_a4' AND fecha like '%$mes%'");
                            while($rod = mysqli_fetch_assoc($a4_d))
                            { echo "'" .$rod['a_stb'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(128, 237, 153, 0.6)'],
                borderColor: ['rgba(128, 237, 153, 1)',],
                borderWidth: 2,
              },
              {
                label: 'Mudanzas internas',
                data: [
                        <?php
                          $a5 = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas', tecnico FROM produccion WHERE fecha like '%$mes%' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a5))
                          {
                            $tecnico_a5 = $row['tecnico'];

                            $a5_e = mysqli_query($conn, "SELECT SUM(mudanza) as 'a_mudanza' FROM produccion WHERE tecnico = '$tecnico_a5' AND fecha like '%$mes%'");
                            while($roe = mysqli_fetch_assoc($a5_e))
                            { echo "'" .$roe['a_mudanza'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(251, 133, 0, 0.6)'],
                borderColor: ['rgba(251, 133, 0, 1)',],
                borderWidth: 2,
              }, 
            ]
        },
      options: {responsive:true,}
    };
    const graficos_aa = new Chart(
      document.getElementById('analisis_exitosas_tec'),
      config_aa
    );
  </script>
<!-- TOTAL -->
<!-- TOTAL LZ -->
  <script>
    const config_aa_lz = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas', tecnico FROM produccion WHERE fecha like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY tecnico");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .$row['tecnico'] ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total altas',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas', tecnico FROM produccion WHERE fecha like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $tecnico_a1 = $row['tecnico'];

                            $a1_a = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas' FROM produccion WHERE tecnico = '$tecnico_a1' AND fecha like '%$mes%' AND zona = 'Lomas de Zamora'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_altas'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(255, 89, 94, 0.6)'],
                borderColor: ['rgba(255, 89, 94, 1)',],
                borderWidth: 2
              },
              {
                label: '2 Play',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas', tecnico FROM produccion WHERE fecha like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $tecnico_a2 = $row['tecnico'];

                            $a2_b = mysqli_query($conn, "SELECT SUM(dosplay) as 'a_dosplay' FROM produccion WHERE tecnico = '$tecnico_a2' AND fecha like '%$mes%' AND zona = 'Lomas de Zamora'");
                            while($rob = mysqli_fetch_assoc($a2_b))
                            { echo "'" .$rob['a_dosplay'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(33, 158, 188, 0.6)'],
                borderColor: ['rgba(33, 158, 188, 1)',],
                borderWidth: 2
              },
              {
                label: '3 Play',
                data: [
                        <?php
                          $a3 = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas', tecnico FROM produccion WHERE fecha like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a3))
                          {
                            $tecnico_a3 = $row['tecnico'];

                            $a3_c = mysqli_query($conn, "SELECT SUM(tresplay) as 'a_tresplay' FROM produccion WHERE tecnico = '$tecnico_a3' AND fecha like '%$mes%' AND zona = 'Lomas de Zamora'");
                            while($roc = mysqli_fetch_assoc($a3_c))
                            { echo "'" .$roc['a_tresplay'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(241, 91, 181, 0.6)'],
                borderColor: ['rgba(241, 91, 181, 1)',],
                borderWidth: 2
              },
              {
                label: 'STB',
                data: [
                        <?php
                          $a4 = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas', tecnico FROM produccion WHERE fecha like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a4))
                          {
                            $tecnico_a4 = $row['tecnico'];

                            $a4_d = mysqli_query($conn, "SELECT SUM(stb) as 'a_stb' FROM produccion WHERE tecnico = '$tecnico_a4' AND fecha like '%$mes%' AND zona = 'Lomas de Zamora'");
                            while($rod = mysqli_fetch_assoc($a4_d))
                            { echo "'" .$rod['a_stb'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(128, 237, 153, 0.6)'],
                borderColor: ['rgba(128, 237, 153, 1)',],
                borderWidth: 2
              },
              {
                label: 'Mudanzas internas',
                data: [
                        <?php
                          $a5 = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas', tecnico FROM produccion WHERE fecha like '%$mes%' AND zona = 'Lomas de Zamora' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a5))
                          {
                            $tecnico_a5 = $row['tecnico'];

                            $a5_e = mysqli_query($conn, "SELECT SUM(mudanza) as 'a_mudanza' FROM produccion WHERE tecnico = '$tecnico_a5' AND fecha like '%$mes%' AND zona = 'Lomas de Zamora'");
                            while($roe = mysqli_fetch_assoc($a5_e))
                            { echo "'" .$roe['a_mudanza'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(251, 133, 0, 0.6)'],
                borderColor: ['rgba(251, 133, 0, 1)',],
                borderWidth: 2
              }, 
            ]
        },
      options: {responsive:true,}
    };
    const graficos_aa_lz = new Chart(
      document.getElementById('analisis_altas_tec_lz'),
      config_aa_lz
    );
  </script>
<!-- TOTAL LZ -->
<!-- TOTAL JLS -->
  <script>
    const config_aa_jls = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas', tecnico FROM produccion WHERE fecha like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY tecnico");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .$row['tecnico'] ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total altas',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas', tecnico FROM produccion WHERE fecha like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $tecnico_a1 = $row['tecnico'];

                            $a1_a = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas' FROM produccion WHERE tecnico = '$tecnico_a1' AND fecha like '%$mes%' AND zona = 'Jose Leon Suarez'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_altas'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(255, 89, 94, 0.6)'],
                borderColor: ['rgba(255, 89, 94, 1)',],
                borderWidth: 2
              },
              {
                label: '2 Play',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas', tecnico FROM produccion WHERE fecha like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $tecnico_a2 = $row['tecnico'];

                            $a2_b = mysqli_query($conn, "SELECT SUM(dosplay) as 'a_dosplay' FROM produccion WHERE tecnico = '$tecnico_a2' AND fecha like '%$mes%' AND zona = 'Jose Leon Suarez'");
                            while($rob = mysqli_fetch_assoc($a2_b))
                            { echo "'" .$rob['a_dosplay'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(33, 158, 188, 0.6)'],
                borderColor: ['rgba(33, 158, 188, 1)',],
                borderWidth: 2
              },
              {
                label: '3 Play',
                data: [
                        <?php
                          $a3 = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas', tecnico FROM produccion WHERE fecha like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a3))
                          {
                            $tecnico_a3 = $row['tecnico'];

                            $a3_c = mysqli_query($conn, "SELECT SUM(tresplay) as 'a_tresplay' FROM produccion WHERE tecnico = '$tecnico_a3' AND fecha like '%$mes%' AND zona = 'Jose Leon Suarez'");
                            while($roc = mysqli_fetch_assoc($a3_c))
                            { echo "'" .$roc['a_tresplay'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(241, 91, 181, 0.6)'],
                borderColor: ['rgba(241, 91, 181, 1)',],
                borderWidth: 2
              },
              {
                label: 'STB',
                data: [
                        <?php
                          $a4 = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas', tecnico FROM produccion WHERE fecha like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a4))
                          {
                            $tecnico_a4 = $row['tecnico'];

                            $a4_d = mysqli_query($conn, "SELECT SUM(stb) as 'a_stb' FROM produccion WHERE tecnico = '$tecnico_a4' AND fecha like '%$mes%' AND zona = 'Jose Leon Suarez'");
                            while($rod = mysqli_fetch_assoc($a4_d))
                            { echo "'" .$rod['a_stb'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(128, 237, 153, 0.6)'],
                borderColor: ['rgba(128, 237, 153, 1)',],
                borderWidth: 2
              },
              {
                label: 'Mudanzas internas',
                data: [
                        <?php
                          $a5 = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas', tecnico FROM produccion WHERE fecha like '%$mes%' AND zona = 'Jose Leon Suarez' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a5))
                          {
                            $tecnico_a5 = $row['tecnico'];

                            $a5_e = mysqli_query($conn, "SELECT SUM(mudanza) as 'a_mudanza' FROM produccion WHERE tecnico = '$tecnico_a5' AND fecha like '%$mes%' AND zona = 'Jose Leon Suarez'");
                            while($roe = mysqli_fetch_assoc($a5_e))
                            { echo "'" .$roe['a_mudanza'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(251, 133, 0, 0.6)'],
                borderColor: ['rgba(251, 133, 0, 1)',],
                borderWidth: 2
              }, 
            ]
        },
      options: {responsive:true,}
    };
    const graficos_aa_jls = new Chart(
      document.getElementById('analisis_altas_tec_jls'),
      config_aa_jls
    );
  </script>
<!-- TOTAL JLS -->
<!-- TOTAL SN -->
  <script>
    const config_aa_sn = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas', tecnico FROM produccion WHERE fecha like '%$mes%' AND zona = 'San Nicolas' GROUP BY tecnico");
                        while($row = mysqli_fetch_assoc($aa_tas))
                        { echo "'" .$row['tecnico'] ."',"; }
                      ?>
                    ],
            datasets: 
            [
              {
                label: 'Total altas',
                data: [
                        <?php
                          $a1 = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas', tecnico FROM produccion WHERE fecha like '%$mes%' AND zona = 'San Nicolas' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $tecnico_a1 = $row['tecnico'];

                            $a1_a = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas' FROM produccion WHERE tecnico = '$tecnico_a1' AND fecha like '%$mes%' AND zona = 'San Nicolas'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['a_altas'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(255, 89, 94, 0.6)'],
                borderColor: ['rgba(255, 89, 94, 1)',],
                borderWidth: 2,
              },
              {
                label: '2 Play',
                data: [
                        <?php
                          $a2 = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas', tecnico FROM produccion WHERE fecha like '%$mes%' AND zona = 'San Nicolas' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a2))
                          {
                            $tecnico_a2 = $row['tecnico'];

                            $a2_b = mysqli_query($conn, "SELECT SUM(dosplay) as 'a_dosplay' FROM produccion WHERE tecnico = '$tecnico_a2' AND fecha like '%$mes%' AND zona = 'San Nicolas'");
                            while($rob = mysqli_fetch_assoc($a2_b))
                            { echo "'" .$rob['a_dosplay'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(33, 158, 188, 0.6)'],
                borderColor: ['rgba(33, 158, 188, 1)',],
                borderWidth: 2,
              },
              {
                label: '3 Play',
                data: [
                        <?php
                          $a3 = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas', tecnico FROM produccion WHERE fecha like '%$mes%' AND zona = 'San Nicolas' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a3))
                          {
                            $tecnico_a3 = $row['tecnico'];

                            $a3_c = mysqli_query($conn, "SELECT SUM(tresplay) as 'a_tresplay' FROM produccion WHERE tecnico = '$tecnico_a3' AND fecha like '%$mes%' AND zona = 'San Nicolas'");
                            while($roc = mysqli_fetch_assoc($a3_c))
                            { echo "'" .$roc['a_tresplay'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(241, 91, 181, 0.6)'],
                borderColor: ['rgba(241, 91, 181, 1)',],
                borderWidth: 2,
              },
              {
                label: 'STB',
                data: [
                        <?php
                          $a4 = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas', tecnico FROM produccion WHERE fecha like '%$mes%' AND zona = 'San Nicolas' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a4))
                          {
                            $tecnico_a4 = $row['tecnico'];

                            $a4_d = mysqli_query($conn, "SELECT SUM(stb) as 'a_stb' FROM produccion WHERE tecnico = '$tecnico_a4' AND fecha like '%$mes%' AND zona = 'San Nicolas'");
                            while($rod = mysqli_fetch_assoc($a4_d))
                            { echo "'" .$rod['a_stb'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(128, 237, 153, 0.6)'],
                borderColor: ['rgba(128, 237, 153, 1)',],
                borderWidth: 2,
              },
              {
                label: 'Mudanzas internas',
                data: [
                        <?php
                          $a5 = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas', tecnico FROM produccion WHERE fecha like '%$mes%' AND zona = 'San Nicolas' GROUP BY tecnico");
                          while($row = mysqli_fetch_assoc($a5))
                          {
                            $tecnico_a5 = $row['tecnico'];

                            $a5_e = mysqli_query($conn, "SELECT SUM(mudanza) as 'a_mudanza' FROM produccion WHERE tecnico = '$tecnico_a5' AND fecha like '%$mes%' AND zona = 'San Nicolas'");
                            while($roe = mysqli_fetch_assoc($a5_e))
                            { echo "'" .$roe['a_mudanza'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(251, 133, 0, 0.6)'],
                borderColor: ['rgba(251, 133, 0, 1)',],
                borderWidth: 2,
              }, 
            ]
        },
      options: {responsive:true,}
    };
    const graficos_aa_sn = new Chart(
      document.getElementById('analisis_altas_tec_sn'),
      config_aa_sn
    );
  </script>
<!-- TOTAL SN -->
<!-- TOTAL -->
  <script>
    const config_aaa = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '%$mes%' AND estado = 'finalizada' AND actividad LIKE 'Instalaci%' AND codigo <> 'ADAP' GROUP BY razon_completada");
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
                          $a1 = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '%$mes%' AND estado = 'finalizada' AND actividad LIKE 'Instalaci%' AND codigo <> 'ADAP' GROUP BY razon_completada");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $razones_a1 = $row['razon_completada'];

                            $a1_a = mysqli_query($conn, "SELECT COUNT(razon_completada) as 'razones', razon_completada FROM carga_dia WHERE fecha like '%$mes%' AND estado = 'finalizada' AND actividad LIKE 'Instalaci%' AND codigo <> 'ADAP' AND razon_completada = '$razones_a1'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['razones'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(238, 108, 77, 0.6)'],
                borderColor: ['rgba(238, 108, 77, 1)',],
                borderWidth: 2
              }
            ]
        },
      options: {responsive:true,}
    };
    const graficos_aaa = new Chart(
      document.getElementById('analisis_exitosas_mot'),
      config_aaa
    );
  </script>
<!-- TOTAL -->
<!-- TOTAL LZ -->
  <script>
    const config_aaa_lz = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '%$mes%' AND estado = 'finalizada' AND actividad LIKE 'Instalaci%' AND codigo <> 'ADAP' AND zona_recurso = 'Lomas de Zamora' GROUP BY razon_completada");
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
                          $a1 = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '%$mes%' AND estado = 'finalizada' AND actividad LIKE 'Instalaci%' AND codigo <> 'ADAP' AND zona_recurso = 'Lomas de Zamora' GROUP BY razon_completada");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $razones_a1 = $row['razon_completada'];

                            $a1_a = mysqli_query($conn, "SELECT COUNT(razon_completada) as 'razones' FROM carga_dia WHERE fecha like '%$mes%'  AND estado = 'finalizada' AND actividad LIKE 'Instalaci%' AND codigo <> 'ADAP' AND zona_recurso = 'Lomas de Zamora' AND razon_completada = '$razones_a1'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['razones'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(238, 108, 77, 0.6)'],
                borderColor: ['rgba(238, 108, 77, 1)',],
                borderWidth: 2
              }
            ]
        },
      options: {responsive:true,}
    };
    const graficos_aaa_lz = new Chart(
      document.getElementById('analisis_motivos_mot_lz'),
      config_aaa_lz
    );
  </script>
<!-- TOTAL LZ -->
<!-- TOTAL LZ -->
  <script>
    const config_aaa_jls = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '%$mes%' AND estado = 'finalizada' AND actividad LIKE 'Instalaci%' AND codigo <> 'ADAP' AND zona_recurso = 'Jose Leon Suarez' GROUP BY razon_completada");
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
                          $a1 = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '%$mes%' AND estado = 'finalizada' AND actividad LIKE 'Instalaci%' AND codigo <> 'ADAP' AND zona_recurso = 'Jose Leon Suarez' GROUP BY razon_completada");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $razones_a1 = $row['razon_completada'];

                            $a1_a = mysqli_query($conn, "SELECT COUNT(razon_completada) as 'razones' FROM carga_dia WHERE fecha like '%$mes%'  AND estado = 'finalizada' AND actividad LIKE 'Instalaci%' AND codigo <> 'ADAP' AND zona_recurso = 'Jose Leon Suarez' AND razon_completada = '$razones_a1'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['razones'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(238, 108, 77, 0.6)'],
                borderColor: ['rgba(238, 108, 77, 1)',],
                borderWidth: 2
              }
            ]
        },
      options: {responsive:true,}
    };
    const graficos_aaa_jls = new Chart(
      document.getElementById('analisis_motivos_mot_jls'),
      config_aaa_jls
    );
  </script>
<!-- TOTAL LZ -->
<!-- TOTAL SN -->
  <script>
    const config_aaa_sn = {
      type: 'bar',
      data: {
            labels: [
                      <?php
                        $aa_tas = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '%$mes%' AND estado = 'finalizada' AND actividad LIKE 'Instalaci%' AND codigo <> 'ADAP' AND zona_recurso = 'San Nicolas' GROUP BY razon_completada");
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
                          $a1 = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '%$mes%' AND estado = 'finalizada' AND actividad LIKE 'Instalaci%' AND codigo <> 'ADAP' AND zona_recurso = 'San Nicolas' GROUP BY razon_completada");
                          while($row = mysqli_fetch_assoc($a1))
                          {
                            $razones_a1 = $row['razon_completada'];

                            $a1_a = mysqli_query($conn, "SELECT COUNT(razon_completada) as 'razones' FROM carga_dia WHERE fecha like '%$mes%'  AND estado = 'finalizada' AND actividad LIKE 'Instalaci%' AND codigo <> 'ADAP' AND zona_recurso = 'San Nicolas' AND razon_completada = '$razones_a1'");
                            while($roa = mysqli_fetch_assoc($a1_a))
                            { echo "'" .$roa['razones'] ."'," ; }

                          }
                        ?>
                      ],
                backgroundColor: ['rgba(238, 108, 77, 0.6)'],
                borderColor: ['rgba(238, 108, 77, 1)',],
                borderWidth: 2
              }
            ]
        },
      options: {responsive:true,}
    };
    const graficos_aaa_sn = new Chart(
      document.getElementById('analisis_motivos_mot_sn'),
      config_aaa_sn
    );
  </script>
<!-- TOTAL SN -->
</body>
</html>