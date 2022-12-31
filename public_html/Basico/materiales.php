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

<?php
  $consult = "SELECT * FROM asignacion_material ORDER BY fecha desc LIMIT 1";
  $result = mysqli_query($conn, $consult);  
  while($row = mysqli_fetch_assoc($result)) { $ult_fecha = $row['fecha']; }
?>
<?php $dias_trabajo = 6; ?>
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

<div class="container-fluid p-4">
  <div class="row p-2">
    <div class="container-fluid rounded bg-white shadow p-0">
      <!-- MESSAGES -->
        <?php session_start();      
        if ($_SESSION['card'] == 1) { ?>
        <div class="alert alert-<?= $_SESSION['message_type']?> alert-dismissible fade show" role="alert">
          <?= $_SESSION['message']?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <?php $_SESSION['card'] = 0; } ?>
      <!-- MESSAGES -->
      <div class="row justify-content-center p-1">
        <div class="col-auto">
            <a class="btn btn-outline-warning btn-sm" href="../Basico/precarga.php" role="button">Precarga</a>
        </div>
      </div>
        <div class="row justify-content-center p-1">
          <div class="col-auto">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#seriados">Equipos seriados</button>
          </div>
        </div>

        <!-- SERIADO -->
        <div class="modal fade" id="seriados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Equipos seriados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <div class="col-auto">
                    <table id="seriado" class="table table-responsive table-striped table-bordered" style="width:100%">
                      <thead class="thead-dark text-center">
                        <tr>
                          <th>Deposito</th>
                          <th>Fecha</th>
                          <th>Num pedido</th>
                          <th>Material</th>
                          <th>Num serie</th>
                          <th>Cantidad</th>
                        </tr>
                      </thead>
                      <tbody align="center">
                        <?php
                          $rs = mysqli_query($conn, "SELECT * FROM ingresomaterial WHERE seriado <> '' ORDER BY seriado asc");
                          while($row = mysqli_fetch_assoc($rs))
                          {
                        ?>
                          <tr>
                            <td><?php echo $row['deposito']; ?></td>
                            <td><?php echo Fecha7($row['fecha']); ?></td>
                            <td><?php echo $row['num_pedido']; ?></td>
                            <td><?php echo $row['material']; ?></td>
                            <td><?php echo $row['seriado']; ?></td>
                            <td><?php echo $row['cantidad']; ?></td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
          </div>
        </div>

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

      <div class="row justify-content-center p-1">
        <div class="col-auto p-2">
          <p class="h4 mb-4 text-center">Materiales</p>
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
                $sr2 = mysqli_query($conn, "SELECT *, SUM(cantidad) as 'depo_sed' FROM ingresomaterial WHERE seriado <> '' AND deposito = '$zona_us' GROUP BY material");
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
                            $rss = mysqli_query($conn, "SELECT SUM(usado) as 'todo_usado_ses' FROM asignacion_material WHERE tipo = 'Descarga' AND material = '$serie2' AND deposito = '$zona_us' GROUP BY material");
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
                  $ra1 = mysqli_query($conn, "SELECT *, SUM(cantidad) as 'depo' FROM ingresomaterial WHERE seriado = '' AND cantidad > 0 AND deposito = '$zona_us' GROUP BY material");   
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
                                    $color_depo1 = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE tipo = 'Precarga' AND material = '$canti1' AND deposito = '$zona_us' GROUP BY material");   
                                    while($color1 = mysqli_fetch_array($color_depo1))
                                    {
                                      $poco_color2 = $color1['cantidad'] * $dias_trabajo * 2;
                                      $poco_color25 = $color1['cantidad'] * $dias_trabajo * 2.5;
                                      $poco_color3 = $color1['cantidad'] * $dias_trabajo * 3;
                                      $poco_color4 = $color1['cantidad'] * $dias_trabajo * 4;
                                      $poco_color5 = $color1['cantidad'] * $dias_trabajo * 5;
                                        /* CALCULAR RESTO O USAR EL ANTERIOR */
                                        $color_total = $cantidad_material1;
                                        $color_depo2 = mysqli_query($conn, "SELECT SUM(usado) as 'todo_usado2' FROM asignacion_material WHERE tipo = 'Descarga' AND material = '$canti1' AND deposito = '$zona_us' GROUP BY material");
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
                        $ra2 = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE tipo = 'Precarga' AND material = '$canti1' AND deposito = '$zona_us' GROUP BY material");
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
                        $ra33 = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE tipo = 'Precarga' AND material = '$canti1' AND deposito = '$zona_us' GROUP BY material");   
                        while($rowa33 = mysqli_fetch_array($ra33))
                        {
                          if($zona_us == 'Lomas de Zamora')
                          {
                            $poco_material_depo = $rowa33['cantidad'] * ($tectecsur+$tecteccaba) ;
                          }
                          if($zona_us == 'Jose Leon Suarez')
                          {
                            $poco_material_depo = $rowa33['cantidad'] * $tectecnorte ;
                          }
                          if($zona_us == 'San Nicolas')
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
                        $ra3 = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE tipo = 'Precarga' AND material = '$canti1' AND deposito = '$zona_us' GROUP BY material");   
                        while($rowa3 = mysqli_fetch_array($ra3))
                        {
                          if($zona_us == 'Lomas de Zamora')
                          {
                            $poco_material_depo = $rowa3['cantidad'] * ($dias_trabajo * 2) * ($tectecsur+$tecteccaba) ;
                          }
                          if($zona_us == 'Jose Leon Suarez')
                          {
                            $poco_material_depo = $rowa3['cantidad'] * ($dias_trabajo * 2) * $tectecnorte ;
                          }
                          if($zona_us == 'San Nicolas')
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
                        $ra22 = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE tipo = 'Precarga' AND material = '$canti1' AND deposito = '$zona_us' GROUP BY material");
                        while($rowa22 = mysqli_fetch_array($ra22))
                        {
                          if($zona_us == 'Lomas de Zamora')
                          {
                            $cantidad_precarga2_depo = $rowa22['cantidad'] * ($tectecsur+$tecteccaba) ;
                          }
                          if($zona_us == 'Jose Leon Suarez')
                          {
                            $cantidad_precarga2_depo = $rowa22['cantidad'] * $tectecnorte ;
                          }
                          if($zona_us == 'San Nicolas')
                          {
                            $cantidad_precarga2_depo = $rowa22['cantidad'] * $tectecsanni ;
                          }
                          /* SOLO CALCULAR LOS DIAS */
                            $xxa = mysqli_query($conn, "SELECT SUM(usado) as 'todo_usado_depo' FROM asignacion_material WHERE tipo = 'Descarga' AND material = '$canti1' AND deposito = '$zona_us' GROUP BY material");
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
                        $ra4 = mysqli_query($conn, "SELECT SUM(usado) as 'todo_usado' FROM asignacion_material WHERE tipo = 'Descarga' AND material = '$canti1' AND deposito = '$zona_us' GROUP BY material");
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
  </div>
</div>

<!-- PIE DE PAGINA -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- then Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<!-- Datatable -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- Filtro por columnas -->
<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script> 

<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> 
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script> 
<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script> 
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
			$('#seriado').DataTable( {
					"dom": '<"top"lif>rt<"bottom"p><"clear">',
					"language": {
										"processing":     "Procesando...",
										"search":         "Buscar:",
										"lengthMenu":     "Mostrar _MENU_ equipos por pagina...",
										"zeroRecords":    "No se encontro ninguna equipo",
										"info":           "Mostrando _START_ a _END_ de un total de _TOTAL_ equipos",
										"infoEmpty":      "No hay equipos disponibles",
										"infoFiltered":   "(filtrado de _MAX_ equipos)",
										"loadingRecords": "Cargando...",
					},
					"ordering": false,
			} );
	} );
</script>
</body>
</html>

