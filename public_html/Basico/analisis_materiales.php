<?php
  include("../db.php");
  session_start();
  if(!$_SESSION['nombre'])
  {
  session_destroy();
  header("location: ../index.php");
  exit();
  }
  $nombre = $_SESSION['nombre'];
  $apellido = $_SESSION['apellido'];
  $tipo = $_SESSION['tipo_us'];
  $zona_us = $_SESSION['zona'];
  if($tipo == "Administrador") { $usu = 1; }
  if($tipo == "Despacho") { $usu = 1; }
  if($tipo == "Supervisor") { $usu = 1; }
  if($tipo == "Deposito") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
  }
?>
<?php include('../includes/header.php'); ?>
<!-- DATOS PARA MAETRIALES -->
<?php $dias_trabajo = 6; ?>
<!-- DATOS PARA MAETRIALES -->
<!-- RECUENTO -->
  <?php
    $query1 = "SELECT COUNT(tecnico) as 'tectec' FROM tecnicos WHERE activo ='SI' AND tipo='Tecnico' ORDER BY tecnico asc";
    $result_tasks = mysqli_query($conn, $query1);
    while($row = mysqli_fetch_assoc($result_tasks)) {             
    $tectec= $row['tectec'];} 
  ?>
  <?php
    $query1 = "SELECT COUNT(tecnico) as 'ayuayu' FROM tecnicos WHERE activo ='SI' AND tipo='Capacitacion' ORDER BY tecnico asc";
    $result_tasks = mysqli_query($conn, $query1);
    while($row = mysqli_fetch_assoc($result_tasks)) {             
    $ayuayu= $row['ayuayu'];} 
  ?>
  <?php
    $query1 = "SELECT COUNT(tecnico) as 'ayuayusur' FROM tecnicos WHERE activo ='SI' AND tipo='Capacitacion' AND zona='Lomas de Zamora' ORDER BY tecnico asc";
    $result_tasks = mysqli_query($conn, $query1);
    while($row = mysqli_fetch_assoc($result_tasks)) {             
    $ayuayusur= $row['ayuayusur'];} 
  ?>
  <?php
    $query1 = "SELECT COUNT(tecnico) as 'tectecsur' FROM tecnicos WHERE activo ='SI' AND tipo='Tecnico' AND zona='Lomas de Zamora' ORDER BY tecnico asc";
    $result_tasks = mysqli_query($conn, $query1);
    while($row = mysqli_fetch_assoc($result_tasks)) {             
    $tectecsur= $row['tectecsur'];} 
  ?>
  <?php
    $query1 = "SELECT COUNT(tecnico) as 'ayuayunorte' FROM tecnicos WHERE activo ='SI' AND tipo='Capacitacion' AND zona='Jose Leon Suarez' ORDER BY tecnico asc";
    $result_tasks = mysqli_query($conn, $query1);
    while($row = mysqli_fetch_assoc($result_tasks)) {             
    $ayuayunorte= $row['ayuayunorte'];} 
  ?>
  <?php
    $query1 = "SELECT COUNT(tecnico) as 'tectecnorte' FROM tecnicos WHERE activo ='SI' AND tipo='Tecnico' AND zona='Jose Leon Suarez' ORDER BY tecnico asc";
    $result_tasks = mysqli_query($conn, $query1);
    while($row = mysqli_fetch_assoc($result_tasks)) {             
    $tectecnorte= $row['tectecnorte'];} 
  ?>
  <?php
    $query1 = "SELECT COUNT(tecnico) as 'ayuayucaba' FROM tecnicos WHERE activo ='SI' AND tipo='Capacitacion' AND zona='CABA' ORDER BY tecnico asc";
    $result_tasks = mysqli_query($conn, $query1);
    while($row = mysqli_fetch_assoc($result_tasks)) {             
    $ayuayucaba= $row['ayuayucaba'];} 
  ?>
  <?php
    $query1 = "SELECT COUNT(tecnico) as 'tecteccaba' FROM tecnicos WHERE activo ='SI' AND tipo='Tecnico' AND zona='CABA' ORDER BY tecnico asc";
    $result_tasks = mysqli_query($conn, $query1);
    while($row = mysqli_fetch_assoc($result_tasks)) {             
    $tecteccaba= $row['tecteccaba'];} 
  ?>
  <?php
    $query1 = "SELECT COUNT(tecnico) as 'ayuayusanni' FROM tecnicos WHERE activo ='SI' AND tipo='Capacitacion' AND zona='San Nicolas' ORDER BY tecnico asc";
    $result_tasks = mysqli_query($conn, $query1);
    while($row = mysqli_fetch_assoc($result_tasks)) {             
    $ayuayusanni= $row['ayuayusanni'];} 
  ?>
  <?php
    $query1 = "SELECT COUNT(tecnico) as 'tectecsanni' FROM tecnicos WHERE activo ='SI' AND tipo='Tecnico' AND zona='San Nicolas' ORDER BY tecnico asc";
    $result_tasks = mysqli_query($conn, $query1);
    while($row = mysqli_fetch_assoc($result_tasks)) {             
    $tectecsanni= $row['tectecsanni'];} 
  ?>
<!-- RECUENTO -->

<div class="container-fluid pr-4 pl-4 pt-2 pb-0">
  <div class="row pr-2 pl-2 pt-2 pb-0">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
      <a class="row rounded bg-white shadow border-left border-info m-1 text-muted">
        <div class="col-6 p-2">
          <p class="h2 text-left text-info"><i class="fa-solid fa-users"></i></p>
        </div>
        <div class="col-6 p-2">
            <p class="h4 text-muted text-center">Totales</p>
            <p class="h3 text-muted text-center"><?php echo ($tectecsur+$tecteccaba+$tectecsanni+$tectecnorte+$ayuayusanni+$ayuayucaba+$ayuayunorte+$ayuayusur); ?></p>
        </div>
      </a>
      <div class="row rounded bg-white shadow border-left border-info m-1 justify-content-between">
        <div class="col-auto h6 p-2 text-muted m-0">
          Tecnicos
        </div>
        <div class="col-auto h6 p-2 text-muted m-0">
          <?php echo ($tectecsur+$tecteccaba+$tectecsanni+$tectecnorte); ?>
        </div>
      </div>
      <div class="row rounded bg-white shadow border-left border-info m-1 justify-content-between">
        <div class="col-auto h6 p-2 text-muted m-0">
          Ayudantes
        </div>
        <div class="col-auto h6 p-2 text-muted m-0">
          <?php echo ($ayuayusanni+$ayuayucaba+$ayuayunorte+$ayuayusur); ?>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
      <a class="row rounded bg-white shadow border-left border-success m-1">
        <div class="col-6 p-2">
          <p class="h2 text-left text-success"><i class="fa-solid fa-angle-down"></i></p>
        </div>
        <div class="col-6 p-2">
            <p class="h4 text-muted text-center">Lomas de Zamora</p>
            <p class="h3 text-muted text-center"><?php echo ($tectecsur+$tecteccaba+$ayuayucaba+$ayuayusur); ?></p>
        </div>
      </a>
      <div class="row rounded bg-white shadow border-left border-success m-1 justify-content-between">
        <div class="col-auto h6 p-2 text-muted m-0">
          Tecnicos
        </div>
        <div class="col-auto h6 p-2 text-muted m-0">
          <?php echo ($tectecsur+$tecteccaba); ?>
        </div>
      </div>
      <div class="row rounded bg-white shadow border-left border-success m-1 justify-content-between">
        <div class="col-auto h6 p-2 text-muted m-0">
          Ayudantes
        </div>
        <div class="col-auto h6 p-2 text-muted m-0">
          <?php echo ($ayuayucaba+$ayuayusur); ?>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
      <a class="row rounded bg-white shadow border-left border-success m-1">
        <div class="col-6 p-2">
          <p class="h2 text-left text-success"><i class="fas fa-toolbox"></i></p>
        </div>
        <div class="col-6 p-2">
            <p class="h4 text-muted text-center">Jose Leon Suarez</p>
            <p class="h3 text-muted text-center"><?php echo ($tectecnorte+$ayuayunorte); ?></p>
        </div>
      </a>
      <div class="row rounded bg-white shadow border-left border-success m-1 justify-content-between">
        <div class="col-auto h6 p-2 text-muted m-0">
          Tecnicos
        </div>
        <div class="col-auto h6 p-2 text-muted m-0">
          <?php echo $tectecnorte; ?>
        </div>
      </div>
      <div class="row rounded bg-white shadow border-left border-success m-1 justify-content-between">
        <div class="col-auto h6 p-2 text-muted m-0">
          Ayudantes
        </div>
        <div class="col-auto h6 p-2 text-muted m-0">
          <?php echo $ayuayunorte; ?>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
      <a class="row rounded bg-white shadow border-left border-success m-1">
        <div class="col-6 p-2">
          <p class="h2 text-left text-success"><i class="fa-solid fa-arrows-rotate"></i></p>
        </div>
        <div class="col-6 p-2">
            <p class="h4 text-muted text-center">San Nicolas</p>
            <p class="h3 text-muted text-center"><?php echo ($tectecsanni+$ayuayusanni); ?></p>
        </div>
      </a>
      <div class="row rounded bg-white shadow border-left border-success m-1 justify-content-between">
        <div class="col-auto h6 p-2 text-muted m-0">
          Tecnicos
        </div>
        <div class="col-auto h6 p-2 text-muted m-0">
          <?php echo $tectecsanni; ?>
        </div>
      </div>
      <div class="row rounded bg-white shadow border-left border-success m-1 justify-content-between">
        <div class="col-auto h6 p-2 text-muted m-0">
          Ayudantes
        </div>
        <div class="col-auto h6 p-2 text-muted m-0">
          <?php echo $ayuayusanni; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="col-12 p-0">
      <div class="row rounded bg-white shadow m-1 p-2">

        <style>
          .verde{
            background-color: #3bd05d !important;
          }
          .verde_amarillo{
            background-color: #B2FA3E !important;
          }
          .amarillo{
            background-color: #FAE93A !important;
          }
          .amarillo_rojo{
            background-color: #FFAE4B !important;
          }
          .rojo{
            background-color: #eb5839 !important;
          }
          .negro{
            background-color: #212529 !important;
            color: gainsboro !important;
          }
        </style>

        <?php 
          $s1 = mysqli_query($conn, "SELECT * FROM ingresomaterial WHERE seriado <> '' GROUP BY material");
          while($row = mysqli_fetch_array($s1))
          { $serializados[] = $row['material']; }
        ?>
        
        <div class="col-12">
          <nav class=" nav justify-content-center">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
              <?php
                $r = mysqli_query($conn, "SELECT DISTINCT zona, abreviatura FROM usuarios WHERE zona <> 'Todo' AND zona <> '' ");
                while($row = mysqli_fetch_assoc($r)) {
                $abreviatura =  $row['abreviatura'];
                $zona_deposito =  $row['zona'];
              ?>
                <a class="nav-link" id="<?php echo $abreviatura; ?>-tab" data-toggle="tab" href="#<?php echo $abreviatura; ?>" role="tab" aria-controls="<?php echo $abreviatura; ?>" aria-selected="true"><?php echo $zona_deposito; ?></a>
              <?php } ?>
                <a class="nav-link active" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Total</a>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
            <?php
              $a = mysqli_query($conn, "SELECT DISTINCT zona, abreviatura FROM usuarios WHERE zona <> 'Todo' AND zona <> '' ");
              while($row = mysqli_fetch_assoc($a)) {
              $abreviatura =  $row['abreviatura'];
              $zona_deposito =  $row['zona'];
            ?>
              <div class="tab-pane fade" id="<?php echo $abreviatura; ?>" role="tabpanel" aria-labelledby="<?php echo $abreviatura; ?>-tab">
                <div class="row justify-content-center">
                  <div class="col-auto p-2">
                    <table class="table table-responsive table-striped table-bordered table-sm">
                      <thead class="thead-dark text-center">
                        <tr>
                          <th>Material</th>
                          <th>Sap</th>
                          <th>Precarga</th>
                          <th>Uso en 1 dia</th>
                          <th>Poco material (<?php echo $dias_trabajo *2; ?> dias)</th>
                          <th>Dias</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          $sr2 = mysqli_query($conn, "SELECT *, SUM(cantidad) as 'depo_sed' FROM ingresomaterial WHERE seriado <> '' AND deposito = '$zona_deposito' GROUP BY material");
                          while($ros = mysqli_fetch_array($sr2))
                          { 
                            $serie2 = $ros['material'];
                            $spa_seri2 = $ros['sap'];
                            $cant_seri2 = $ros['depo_sed'];
                            ?>
                              <tr>
                                <td><?php echo utf8_decode($serie2); ?></td>
                                <td align="center"><?php echo $spa_seri2; ?></td>
                                <td align="center">-</td>
                                <td align="center">-</td>
                                <td align="center">-</td>
                                <td align="center">-</td>
                                <td align="center" class="h6"><b>
                                  <?php
                                    /* CALCULAR RESTO O USAR EL ANTERIOR */
                                      $toti_se2 = $cant_seri2;
                                      $rss = mysqli_query($conn, "SELECT SUM(usado) as 'todo_usado_ses' FROM asignacion_material WHERE tipo = 'Descarga' AND material = '$serie2' AND deposito = '$zona_deposito' GROUP BY material");
                                      while($sow = mysqli_fetch_array($rss))
                                      {
                                        $cantidad_total_se2 = ($cant_seri2 - $sow['todo_usado_ses']);
                                        $toti_se2 = $cantidad_total_se2;
                                      }
                                      echo $toti_se2;
                                  ?>
                                </b></td>
                              </tr>
                            <?php
                          }
                        ?>
                        <?php
                          /* NOMBRE DE MATERIALES EN EL DEPOSITO MAYOR A 0 */ 
                            $ra1 = mysqli_query($conn, "SELECT *, SUM(cantidad) as 'depo' FROM ingresomaterial WHERE seriado = '' AND cantidad > 0 AND deposito = '$zona_deposito' GROUP BY material");   
                            while($row = mysqli_fetch_array($ra1))
                            { 
                              $canti1 = $row['material'];
                              $cantidad_material1 = $row['depo'];
                              if(in_array($canti1, $serializados,))
                              {
                              }
                              else
                              {
                              $canti1 = $row['material'];
                              $cantidad_material1 = $row['depo'];
                        ?>
                          <tr class="<?php /* COLOR DE LA FILA */
                                            /* CANTIDAD DE DIAS PARA POCO MATERIAL POR 2 SEMANAS*/
                                              $color_depo1 = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE tipo = 'Precarga' AND material = '$canti1' AND deposito = '$zona_deposito' GROUP BY material");   
                                              while($color1 = mysqli_fetch_array($color_depo1))
                                              {
                                                if($zona_deposito == 'Lomas de Zamora')
                                                {
                                                  $poco_color2 = $color1['cantidad'] * $dias_trabajo * 2 * ($tectecsur+$tecteccaba) ;
                                                  $poco_color25 = $color1['cantidad'] * $dias_trabajo * 2.5 * ($tectecsur+$tecteccaba) ;
                                                  $poco_color3 = $color1['cantidad'] * $dias_trabajo * 3 * ($tectecsur+$tecteccaba) ;
                                                  $poco_color4 = $color1['cantidad'] * $dias_trabajo * 4 * ($tectecsur+$tecteccaba) ;
                                                  $poco_color5 = $color1['cantidad'] * $dias_trabajo * 5 * ($tectecsur+$tecteccaba) ;
                                                }
                                                if($zona_deposito == 'Jose Leon Suarez')
                                                {
                                                  $poco_color2 = $color1['cantidad'] * $dias_trabajo * 2 * ($tectecnorte) ;
                                                  $poco_color25 = $color1['cantidad'] * $dias_trabajo * 2.5 * ($tectecnorte) ;
                                                  $poco_color3 = $color1['cantidad'] * $dias_trabajo * 3 * ($tectecnorte) ;
                                                  $poco_color4 = $color1['cantidad'] * $dias_trabajo * 4 * ($tectecnorte) ;
                                                  $poco_color5 = $color1['cantidad'] * $dias_trabajo * 5 * ($tectecnorte) ;
                                                }
                                                if($zona_deposito == 'San Nicolas')
                                                {
                                                  $poco_color2 = $color1['cantidad'] * $dias_trabajo * 2 * ($tectecsanni) ;
                                                  $poco_color25 = $color1['cantidad'] * $dias_trabajo * 2.5 * ($tectecsanni) ;
                                                  $poco_color3 = $color1['cantidad'] * $dias_trabajo * 3 * ($tectecsanni) ;
                                                  $poco_color4 = $color1['cantidad'] * $dias_trabajo * 4 * ($tectecsanni) ;
                                                  $poco_color5 = $color1['cantidad'] * $dias_trabajo * 5 * ($tectecsanni) ;
                                                }
                                                
                                                  /* CALCULAR RESTO O USAR EL ANTERIOR */
                                                  $color_total = $cantidad_material1;
                                                  $color_depo2 = mysqli_query($conn, "SELECT SUM(usado) as 'todo_usado2' FROM asignacion_material WHERE tipo = 'Descarga' AND material = '$canti1' AND deposito = '$zona_deposito' GROUP BY material");
                                                  while($color2 = mysqli_fetch_array($color_depo2))
                                                  {
                                                    $cantidad_tot_color = ($cantidad_material1 - $color2['todo_usado2']);
                                                    $color_total = $cantidad_tot_color;
                                                  }
                                                if($color_total < $poco_color2){echo 'negro';}
                                                if($color_total >= $poco_color2 && $color_total < $poco_color25){echo 'rojo';}
                                                if($color_total >= $poco_color25 && $color_total < $poco_color3){echo 'amarillo_rojo';}
                                                if($color_total >= $poco_color3 && $color_total < $poco_color4){echo 'amarillo';}
                                                if($color_total >= $poco_color4 && $color_total <= $poco_color5){echo 'verde_amarillo';}
                                                if($color_total > $poco_color5 ){echo 'verde';}
                                              }
                                    ?>">
                            <td><?php echo utf8_decode($row['material']); ?></td>
                            <td align="center"><?php echo $row['sap']; ?></td>
                            <td align="center">
                              <?php
                                /* CANTIDAD GUARDADA EN PRECARGA */
                                  $ra2 = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE tipo = 'Precarga' AND material = '$canti1' AND deposito = '$zona_deposito' GROUP BY material");
                                  while($rowa2 = mysqli_fetch_array($ra2))
                                  {
                                    $cantidad_precarga1 = $rowa2['cantidad'];
                                    echo $cantidad_precarga1 ;
                                  } 
                              ?>
                            </td>
                            <td align="center">
                              <?php
                                /* CANTIDAD DE DIAS PARA POCO MATERIAL POR 2 SEMANAS*/
                                  $ra33 = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE tipo = 'Precarga' AND material = '$canti1' AND deposito = '$zona_deposito' GROUP BY material");   
                                  while($rowa33 = mysqli_fetch_array($ra33))
                                  {
                                    if($zona_deposito == 'Lomas de Zamora')
                                    {
                                      $poco_material_depo = $rowa33['cantidad'] * ($tectecsur+$tecteccaba) ;
                                    }
                                    if($zona_deposito == 'Jose Leon Suarez')
                                    {
                                      $poco_material_depo = $rowa33['cantidad'] * $tectecnorte ;
                                    }
                                    if($zona_deposito == 'San Nicolas')
                                    {
                                      $poco_material_depo = $rowa33['cantidad'] * $tectecsanni ;
                                    }
                                    echo $poco_material_depo;
                                  } 
                              ?>
                            </td>
                            <td align="center">
                              <?php
                                /* CANTIDAD DE DIAS PARA POCO MATERIAL POR 2 SEMANAS*/
                                  $ra3 = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE tipo = 'Precarga' AND material = '$canti1' AND deposito = '$zona_deposito' GROUP BY material");   
                                  while($rowa3 = mysqli_fetch_array($ra3))
                                  {
                                    if($zona_deposito == 'Lomas de Zamora')
                                    {
                                      $poco_material_depo = $rowa3['cantidad'] * ($dias_trabajo * 2) * ($tectecsur+$tecteccaba) ;
                                    }
                                    if($zona_deposito == 'Jose Leon Suarez')
                                    {
                                      $poco_material_depo = $rowa3['cantidad'] * ($dias_trabajo * 2) * $tectecnorte ;
                                    }
                                    if($zona_deposito == 'San Nicolas')
                                    {
                                      $poco_material_depo = $rowa3['cantidad'] * ($dias_trabajo * 2) * $tectecsanni ;
                                    }
                                    echo $poco_material_depo;
                                  } 
                              ?>
                            </td>
                            <td align="center">
                              <?php
                                $za = $cantidad_material1;
                                /* SOLO CALCULAR LOS DIAS / CANTIDAD PRECARGA */
                                  $ra22 = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE tipo = 'Precarga' AND material = '$canti1' AND deposito = '$zona_deposito' GROUP BY material");
                                  while($rowa22 = mysqli_fetch_array($ra22))
                                  {
                                    if($zona_deposito == 'Lomas de Zamora')
                                    {
                                      $cantidad_precarga2_depo = $rowa22['cantidad'] * ($tectecsur+$tecteccaba) ;
                                    }
                                    if($zona_deposito == 'Jose Leon Suarez')
                                    {
                                      $cantidad_precarga2_depo = $rowa22['cantidad'] * $tectecnorte ;
                                    }
                                    if($zona_deposito == 'San Nicolas')
                                    {
                                      $cantidad_precarga2_depo = $rowa22['cantidad'] * $tectecsanni ;
                                    }
                                    /* SOLO CALCULAR LOS DIAS */
                                      $xxa = mysqli_query($conn, "SELECT SUM(usado) as 'todo_usado_depo' FROM asignacion_material WHERE tipo = 'Descarga' AND material = '$canti1' AND deposito = '$zona_deposito' GROUP BY material");
                                      while($rowe3 = mysqli_fetch_array($xxa))
                                      {
                                        $za = ($cantidad_material1 - $rowe3['todo_usado_depo']);
                                      }
                                      $cantidad_dias_depo = bcdiv($za / $cantidad_precarga2_depo, '1', '2');
                                      echo (int)$cantidad_dias_depo;
                                  }
                              ?>
                            </td>
                            <td align="center"><b>
                              <?php
                                /* CALCULAR RESTO O USAR EL ANTERIOR */
                                  $toti1 = $cantidad_material1;
                                  $ra4 = mysqli_query($conn, "SELECT SUM(usado) as 'todo_usado' FROM asignacion_material WHERE tipo = 'Descarga' AND material = '$canti1' AND deposito = '$zona_deposito' GROUP BY material");
                                  while($rowa = mysqli_fetch_array($ra4))
                                  {
                                    $cantidad_total1 = ($cantidad_material1 - $rowa['todo_usado']);
                                    $toti1 = $cantidad_total1;
                                  }
                                  echo $toti1;
                              ?>
                            </b></td>
                          </tr>
                        <?php } } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            <?php } ?>
              <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="row justify-content-center">
                  <div class="col-auto p-2">
                    <table class="table table-responsive table-striped table-bordered table-sm">
                      <thead class="thead-dark text-center">
                        <tr>
                          <th>Material</th>
                          <th>Sap</th>
                          <th>Precarga</th>
                          <th>Uso en 1 dia</th>
                          <th>Poco material (<?php echo $dias_trabajo *2; ?> dias)</th>
                          <th>Dias</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          $sr1 = mysqli_query($conn, "SELECT *, SUM(cantidad) as 'depo_se' FROM ingresomaterial WHERE seriado <> '' GROUP BY material");
                          while($rows = mysqli_fetch_array($sr1))
                          { 
                            $serie = $rows['material'];
                            $spa_seri = $rows['sap'];
                            $cant_seri = $rows['depo_se'];
                            ?>
                              <tr>
                                <td><?php echo utf8_decode($serie); ?></td>
                                <td align="center"><?php echo $spa_seri; ?></td>
                                <td align="center">-</td>
                                <td align="center">-</td>
                                <td align="center">-</td>
                                <td align="center">-</td>
                                <td align="center" class="h6"><b>
                                  <?php
                                    /* CALCULAR RESTO O USAR EL ANTERIOR */
                                      $toti_se = $cant_seri;
                                      $rs4 = mysqli_query($conn, "SELECT SUM(usado) as 'todo_usado_se' FROM asignacion_material WHERE tipo = 'Descarga' AND material = '$serie' GROUP BY material");
                                      while($soww = mysqli_fetch_array($rs4))
                                      {
                                        $cantidad_total_se = ($cant_seri - $soww['todo_usado_se']);
                                        $toti_se = $cantidad_total_se;
                                      }
                                      echo $toti_se;
                                  ?>
                                </b></td>
                              </tr>
                            <?php
                          }
                        ?>
                        <?php
                          /* NOMBRE DE MATERIALES EN EL DEPOSITO MAYOR A 0 */ 
                            $r1 = mysqli_query($conn, "SELECT *, SUM(cantidad) as 'depo' FROM ingresomaterial WHERE seriado = '' AND cantidad > 0 GROUP BY material");   
                            while($row = mysqli_fetch_array($r1))
                            { 
                              $canti = $row['material'];
                              $cantidad_material = $row['depo'];
                              if(in_array($canti, $serializados,))
                              {
                              }
                              else
                              {
                                $canti = $row['material'];
                                $cantidad_material = $row['depo'];
                        ?>
                          <tr class="<?php /* COLOR DE LA FILA */
                                            /* CANTIDAD DE DIAS PARA POCO MATERIAL POR 2 SEMANAS*/
                                              $r33 = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE tipo = 'Precarga' AND material = '$canti' GROUP BY material");   
                                              while($row33 = mysqli_fetch_array($r33))
                                              {
                                                $poco_materials2 = $row33['cantidad'] * ($dias_trabajo * 2) * ($tectecsur+$tecteccaba+$tectecsanni+$tectecnorte) ;
                                                $poco_materials25 = $row33['cantidad'] * ($dias_trabajo * 2.5) * ($tectecsur+$tecteccaba+$tectecsanni+$tectecnorte) ;
                                                $poco_materials3 = $row33['cantidad'] * ($dias_trabajo * 3) * ($tectecsur+$tecteccaba+$tectecsanni+$tectecnorte) ;
                                                $poco_materials4 = $row33['cantidad'] * ($dias_trabajo * 4) * ($tectecsur+$tecteccaba+$tectecsanni+$tectecnorte) ;
                                                $poco_materials5 = $row33['cantidad'] * ($dias_trabajo * 5) * ($tectecsur+$tecteccaba+$tectecsanni+$tectecnorte) ;
                                                  /* CALCULAR RESTO O USAR EL ANTERIOR */
                                                  $totil = $cantidad_material;
                                                  $r44 = mysqli_query($conn, "SELECT SUM(usado) as 'todo_usado' FROM asignacion_material WHERE tipo = 'Descarga' AND material = '$canti' GROUP BY material");
                                                  while($roww4 = mysqli_fetch_array($r44))
                                                  {
                                                    $cantidad_totals = ($cantidad_material - $roww4['todo_usado']);
                                                    $totil = $cantidad_totals;
                                                  }
                                                if($totil < $poco_materials2){echo 'negro';}
                                                if($totil >= $poco_materials2 && $totil < $poco_materials25){echo 'rojo';}
                                                if($totil >= $poco_materials25 && $totil < $poco_materials3){echo 'amarillo_rojo';}
                                                if($totil >= $poco_materials3 && $totil < $poco_materials4){echo 'amarillo';}
                                                if($totil >= $poco_materials4 && $totil <= $poco_materials5){echo 'verde_amarillo';}
                                                if($totil > $poco_materials5 ){echo 'verde';}
                                              }
                                    ?>">
                            <td><?php echo utf8_decode($row['material']); ?></td>
                            <td align="center"><?php echo $row['sap']; ?></td>
                            <td align="center">
                              <?php
                                /* CANTIDAD GUARDADA EN PRECARGA */
                                  $r2 = mysqli_query($conn, "SELECT SUM(cantidad) as 'cant_precarga' FROM asignacion_material WHERE tipo = 'Precarga' AND material = '$canti' GROUP BY material");
                                  while($row2 = mysqli_fetch_array($r2))
                                  {
                                    $cantidad_precarga = $row2['cant_precarga'];
                                    echo $cantidad_precarga ;
                                  } 
                              ?>
                            </td>
                            <td align="center">
                              <?php
                                /* CANTIDAD EN UN DIA*/
                                  $r0 = mysqli_query($conn, "SELECT SUM(cantidad) as 'cant_precarg' FROM asignacion_material WHERE tipo = 'Precarga' AND material = '$canti' GROUP BY material");   
                                  while($row0 = mysqli_fetch_array($r0))
                                  {
                                    $material_un_dia = $row0['cant_precarg'] * ($tectecsur+$tecteccaba+$tectecsanni+$tectecnorte) ;
                                    echo $material_un_dia;
                                  }
                              ?>
                            </td>
                            <td align="center">
                              <?php
                                /* CANTIDAD DE DIAS PARA POCO MATERIAL POR 2 SEMANAS*/
                                  $r3 = mysqli_query($conn, "SELECT SUM(cantidad) as 'cant_precar' FROM asignacion_material WHERE tipo = 'Precarga' AND material = '$canti' GROUP BY material");   
                                  while($row3 = mysqli_fetch_array($r3))
                                  {
                                    $poco_material = $row3['cant_precar'] * ($dias_trabajo * 2) * ($tectecsur+$tecteccaba+$tectecsanni+$tectecnorte) ;
                                    echo $poco_material;
                                  }
                              ?>
                            </td>
                            <td align="center">
                              <?php
                                $z = $cantidad_material;
                                /* SOLO CALCULAR LOS DIAS / CANTIDAD PRECARGA */
                                  $r22 = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE tipo = 'Precarga' AND material = '$canti' GROUP BY material");
                                  while($row22 = mysqli_fetch_array($r22))
                                  {
                                    $cantidad_precarga2 = $row22['cantidad'] * ($tectecsur+$tecteccaba+$tectecnorte+$tectecsanni);
                                  
                                    /* SOLO CALCULAR LOS DIAS */
                                      $xx = mysqli_query($conn, "SELECT *,SUM(usado) as 'todo_usados' FROM asignacion_material WHERE tipo = 'Descarga' AND material = '$canti' GROUP BY material");
                                      while($rowe = mysqli_fetch_array($xx))
                                      {
                                        $z = ($cantidad_material - $rowe['todo_usados']);
                                      }
                                      $cantidad_dias = bcdiv($z / $cantidad_precarga2, '1', '2');
                                      echo (int)$cantidad_dias;
                                  }
                              ?>
                            </td>
                            <td align="center" class="h6"><b>
                              <?php
                                /* CALCULAR RESTO O USAR EL ANTERIOR */
                                  $toti = $cantidad_material;
                                  $r4 = mysqli_query($conn, "SELECT *,SUM(usado) as 'todo_usado' FROM asignacion_material WHERE tipo = 'Descarga' AND material = '$canti' GROUP BY material");
                                  while($roww = mysqli_fetch_array($r4))
                                  {
                                    $cantidad_total = ($cantidad_material - $roww['todo_usado']);
                                    $toti = $cantidad_total;
                                  }
                                  echo $toti;
                              ?>
                            </b></td>
                          </tr>
                        <?php } } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
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
</body>
</html>