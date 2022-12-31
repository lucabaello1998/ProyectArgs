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
  if($tipo_us == "Administrador") { $usu = 1; }
  if($tipo_us == "Despacho") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
  }
?>
<?php include('../includes/header.php'); ?>
<style type="text/css">
  .table .sticky{
    position: sticky;
    left: 0;
  }
  .table tbody tr .sticky {
    background: #f2f2f2;
  }
  .table tbody tr:nth-child(2n) .sticky {    
    background: white;
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
          <input type="hidden" name="link" value="../Basico/asistenciatotal.php">
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
          <input type="hidden" name="link" value="../Basico/asistenciatotal.php">
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
          <div class="col-auto">
            <p class="h4 mb-4 text-center">Asistencia de tecnicos</p>
            <table class="table table-responsive table-striped table-hover table-bordered table-sm">
              <thead class="thead-dark text-center">
                <tr>
                  <th>Tecnico</th>
                  <?php
                    $dias = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha LIKE '%$mes%' GROUP BY fecha");   
                    while($row = mysqli_fetch_assoc($dias))
                    {
                  ?>
                    <th><?php echo Fecha11($row['fecha']); ?></th>
                  <?php } ?>
                    <th data-toggle="tooltip" data-placement="top" title="Dia normal">N</th>
                    <th data-toggle="tooltip" data-placement="top" title="Sabado">S</th>
                    <th data-toggle="tooltip" data-placement="top" title="Feriado">F</th>
                    <th data-toggle="tooltip" data-placement="top" title="Licencia">L</th>
                    <th data-toggle="tooltip" data-placement="top" title="Vacaciones">V</th>
                    <th data-toggle="tooltip" data-placement="top" title="Dia libre">DL</th>
                    <th data-toggle="tooltip" data-placement="top" title="Ausente">A</th>
                    <th data-toggle="tooltip" data-placement="top" title="Vehiculo roto">VR</th>
                    <th data-toggle="tooltip" data-placement="top" title="Suspension">Ss</th>
                </tr>
              </thead>
              <tbody align="center">
                <?php
                  $asis = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha LIKE '%$mes%' GROUP BY tecnico");   
                  while($row = mysqli_fetch_assoc($asis))
                  {
                    $asis_tec = $row['tecnico'];
                ?>
                  <tr>
                    <td><?php echo $asis_tec; ?></td>
                      <?php
                        $dias = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha LIKE '%$mes%' GROUP BY fecha");   
                        while($row = mysqli_fetch_assoc($dias))
                        {
                          $dia_tec = $row['fecha'];
                      ?>
                        <?php
                          $marca_dia = '<td data-toggle="tooltip" data-placement="top" title="Sin registro"><i class="fa-regular fa-circle"></i></td>';
                          $dias_asis_tec = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha = '$dia_tec' AND tecnico = '$asis_tec'");
                          while($row = mysqli_fetch_assoc($dias_asis_tec))
                          {
                            $dia_tipo = $row['dia'];
                            switch($dia_tipo)
                            {
                              case 'Normal': $marca_dia = '<td data-toggle="tooltip" data-placement="top" title="' .$dia_tipo .'"><i class="fa-solid fa-circle-check text-success"></i></td>';
                              break;
                              case 'Sabado': $marca_dia = '<td data-toggle="tooltip" data-placement="top" title="' .$dia_tipo .'"><i class="fa-solid fa-circle-check text-info"></i></td>';
                              break;
                              case 'Feriado': $marca_dia = '<td data-toggle="tooltip" data-placement="top" title="' .$dia_tipo .'"><i class="fa-solid fa-circle-check text-info"></i></td>';
                              break;
                              case 'Ausente': $marca_dia = '<td data-toggle="tooltip" data-placement="top" title="' .$dia_tipo .'"><i class="fa-solid fa-circle-xmark text-danger"></i></td>';
                              break;
                              case 'Vehiculo roto': $marca_dia = '<td data-toggle="tooltip" data-placement="top" title="' .$dia_tipo .'"><i class="fa-solid fa-circle-xmark text-danger"></i></td>';
                              break;
                              case 'Suspencion': $marca_dia = '<td data-toggle="tooltip" data-placement="top" title="' .$dia_tipo .'"><i class="fa-solid fa-circle-xmark text-danger"></i></td>';
                              break;
                              case 'Licencia': $marca_dia = '<td data-toggle="tooltip" data-placement="top" title="' .$dia_tipo .'"><i class="fa-solid fa-circle-exclamation text-warning"></i></td>';
                              break;
                              case 'Vacaciones': $marca_dia = '<td data-toggle="tooltip" data-placement="top" title="' .$dia_tipo .'"><i class="fa-solid fa-circle-exclamation text-warning"></i></td>';
                              break;
                              case 'Dia libre': $marca_dia = '<td data-toggle="tooltip" data-placement="top" title="' .$dia_tipo .'"><i class="fa-solid fa-circle-exclamation text-warning"></i></td>';
                              break;
                            }
                          }
                          echo $marca_dia;
                        ?>
                      <?php } ?>
                      
                        <?php
                          $dia_normal = mysqli_query($conn, "SELECT *, COUNT(tecnico) as 'count_normal' FROM produccion WHERE fecha LIKE '%$mes%' AND tecnico = '$asis_tec' AND dia = 'Normal'");
                          while($row = mysqli_fetch_assoc($dia_normal))
                          {
                            echo '<td data-toggle="tooltip" data-placement="top" title="Dia normal">' .$row['count_normal'] .'</td>';
                          }
                          $dia_sabado = mysqli_query($conn, "SELECT *, COUNT(tecnico) as 'count_sabado' FROM produccion WHERE fecha LIKE '%$mes%' AND tecnico = '$asis_tec' AND dia = 'Sabado'");
                          while($row = mysqli_fetch_assoc($dia_sabado))
                          {
                            echo '<td data-toggle="tooltip" data-placement="top" title="Sabado">' .$row['count_sabado'] .'</td>';
                          }
                          $dia_feriado = mysqli_query($conn, "SELECT *, COUNT(tecnico) as 'count_feriado' FROM produccion WHERE fecha LIKE '%$mes%' AND tecnico = '$asis_tec' AND dia = 'Feriado'");
                          while($row = mysqli_fetch_assoc($dia_feriado))
                          {
                            echo '<td data-toggle="tooltip" data-placement="top" title="Feriado">' .$row['count_feriado'] .'</td>';
                          }
                          $dia_licencia = mysqli_query($conn, "SELECT *, COUNT(tecnico) as 'count_licencia' FROM produccion WHERE fecha LIKE '%$mes%' AND tecnico = '$asis_tec' AND dia = 'Licencia'");
                          while($row = mysqli_fetch_assoc($dia_licencia))
                          {
                            echo '<td data-toggle="tooltip" data-placement="top" title="Licencia">' .$row['count_licencia'] .'</td>';
                          }
                          $dia_vacaciones = mysqli_query($conn, "SELECT *, COUNT(tecnico) as 'count_vacaciones' FROM produccion WHERE fecha LIKE '%$mes%' AND tecnico = '$asis_tec' AND dia = 'Vacaciones'");
                          while($row = mysqli_fetch_assoc($dia_vacaciones))
                          {
                            echo '<td data-toggle="tooltip" data-placement="top" title="Vacaciones">' .$row['count_vacaciones'] .'</td>';
                          }
                          $dia_dia_libre = mysqli_query($conn, "SELECT *, COUNT(tecnico) as 'count_dia_libre' FROM produccion WHERE fecha LIKE '%$mes%' AND tecnico = '$asis_tec' AND dia = 'Dia libre'");
                          while($row = mysqli_fetch_assoc($dia_dia_libre))
                          {
                            echo '<td data-toggle="tooltip" data-placement="top" title="Dia libre">' .$row['count_dia_libre'] .'</td>';
                          }
                          $dia_ausente = mysqli_query($conn, "SELECT *, COUNT(tecnico) as 'count_ausente' FROM produccion WHERE fecha LIKE '%$mes%' AND tecnico = '$asis_tec' AND dia = 'Ausente'");
                          while($row = mysqli_fetch_assoc($dia_ausente))
                          {
                            echo '<td data-toggle="tooltip" data-placement="top" title="Ausente">' .$row['count_ausente'] .'</td>';
                          }
                          $dia_vehiculo_roto = mysqli_query($conn, "SELECT *, COUNT(tecnico) as 'count_vehiculo_roto' FROM produccion WHERE fecha LIKE '%$mes%' AND tecnico = '$asis_tec' AND dia = 'Vehiculo roto'");
                          while($row = mysqli_fetch_assoc($dia_vehiculo_roto))
                          {
                            echo '<td data-toggle="tooltip" data-placement="top" title="Vehiculo roto">' .$row['count_vehiculo_roto'] .'</td>';
                          }
                          $dia_suspension = mysqli_query($conn, "SELECT *, COUNT(tecnico) as 'count_suspension' FROM produccion WHERE fecha LIKE '%$mes%' AND tecnico = '$asis_tec' AND dia = 'Suspension'");
                          while($row = mysqli_fetch_assoc($dia_suspension))
                          {
                            echo '<td data-toggle="tooltip" data-placement="top" title="Suspension">' .$row['count_suspension'] .'</td>';
                          }
                        ?>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
        <br>
        <div class="row justify-content-center p-1">
          <div class="col-auto">
            <p class="h4 mb-4 text-center">Asistencia interna</p>
            <table class="table table-responsive table-striped table-hover table-bordered table-sm">
              <thead class="thead-dark text-center">
                <tr>
                  <th>Nombre</th>
                  <?php
                    $dias = mysqli_query($conn, "SELECT * FROM movimiento_interno WHERE inicio LIKE '%$mes%' AND pag = '' GROUP BY inicio");   
                    while($row = mysqli_fetch_assoc($dias))
                    {
                  ?>
                    <th><?php echo Fecha11($row['inicio']); ?></th>
                  <?php } ?>
                    <th data-toggle="tooltip" data-placement="top" title="Dia normal">N</th>
                    <th data-toggle="tooltip" data-placement="top" title="Sabado">S</th>
                    <th data-toggle="tooltip" data-placement="top" title="Feriado">F</th>
                    <th data-toggle="tooltip" data-placement="top" title="Licencia">L</th>
                    <th data-toggle="tooltip" data-placement="top" title="Vacaciones">V</th>
                    <th data-toggle="tooltip" data-placement="top" title="Dia libre">DL</th>
                    <th data-toggle="tooltip" data-placement="top" title="Ausente">A</th>
                    <th data-toggle="tooltip" data-placement="top" title="Suspension">Ss</th>
                </tr>
              </thead>
              <tbody align="center">
                <?php
                  $asis = mysqli_query($conn, "SELECT * FROM movimiento_interno WHERE inicio LIKE '%$mes%' AND pag = '' GROUP BY quien");   
                  while($row = mysqli_fetch_assoc($asis))
                  {
                    $asis_quien = $row['quien'];
                ?>
                  <tr>
                    <td><?php echo $row['quien']; ?></td>
                      <?php
                        $dias = mysqli_query($conn, "SELECT * FROM movimiento_interno WHERE inicio LIKE '%$mes%' AND pag = '' GROUP BY inicio");   
                        while($row = mysqli_fetch_assoc($dias))
                        {
                          $dia = $row['inicio'];
                      ?>
                        <?php
                          $quien_dia = '<td data-toggle="tooltip" data-placement="top" title="Sin registro"><i class="fa-regular fa-circle"></i></td>';
                          $dias_asis = mysqli_query($conn, "SELECT * FROM movimiento_interno WHERE inicio = '$dia' AND quien = '$asis_quien' AND movimiento = 'Inicio'");
                          while($row = mysqli_fetch_assoc($dias_asis))
                          {
                            switch($row['dia'])
                            {
                              case 'Normal': $quien_dia = '<td data-toggle="tooltip" data-placement="top" title="' .$row['dia'] .'"><i class="fa-solid fa-circle-check text-success"></i></td>';
                              break;
                              case 'Sabado': $quien_dia = '<td data-toggle="tooltip" data-placement="top" title="' .$row['dia'] .'"><i class="fa-solid fa-circle-check text-info"></i></td>';
                              break;
                              case 'Feriado': $quien_dia = '<td data-toggle="tooltip" data-placement="top" title="' .$row['dia'] .'"><i class="fa-solid fa-circle-check text-info"></i></td>';
                              break;
                              case 'Ausente': $quien_dia = '<td data-toggle="tooltip" data-placement="top" title="' .$row['dia'] .'"><i class="fa-solid fa-circle-xmark text-danger"></i></td>';
                              break;
                              case 'Suspencion': $quien_dia = '<td data-toggle="tooltip" data-placement="top" title="' .$row['dia'] .'"><i class="fa-solid fa-circle-xmark text-danger"></i></td>';
                              break;
                              case 'Licencia': $quien_dia = '<td data-toggle="tooltip" data-placement="top" title="' .$row['dia'] .'"><i class="fa-solid fa-circle-exclamation text-warning"></i></td>';
                              break;
                              case 'Vacaciones': $quien_dia = '<td data-toggle="tooltip" data-placement="top" title="' .$row['dia'] .'"><i class="fa-solid fa-circle-exclamation text-warning"></i></td>';
                              break;
                              case 'Dia libre': $quien_dia = '<td data-toggle="tooltip" data-placement="top" title="' .$row['dia'] .'"><i class="fa-solid fa-circle-exclamation text-warning"></i></td>';
                              break;
                            }
                          }
                          echo $quien_dia;
                        ?>
                      <?php } ?>

                      <?php
                        $dia_normal_q = mysqli_query($conn, "SELECT *, COUNT(quien) as 'count_normal_q' FROM movimiento_interno WHERE inicio LIKE '%$mes%' AND quien = '$asis_quien' AND dia = 'Normal' AND movimiento = 'Inicio'");
                        while($row = mysqli_fetch_assoc($dia_normal_q))
                        {
                          echo '<td data-toggle="tooltip" data-placement="top" title="Dia normal">' .$row['count_normal_q'] .'</td>';
                        }
                        $dia_sabado_q = mysqli_query($conn, "SELECT *, COUNT(quien) as 'count_sabado_q' FROM movimiento_interno WHERE inicio LIKE '%$mes%' AND quien = '$asis_quien' AND dia = 'Sabado' AND movimiento = 'Inicio'");
                        while($row = mysqli_fetch_assoc($dia_sabado_q))
                        {
                          echo '<td data-toggle="tooltip" data-placement="top" title="Sabado">' .$row['count_sabado_q'] .'</td>';
                        }
                        $dia_feriado_q = mysqli_query($conn, "SELECT *, COUNT(quien) as 'count_feriado_q' FROM movimiento_interno WHERE inicio LIKE '%$mes%' AND quien = '$asis_quien' AND dia = 'Feriado' AND movimiento = 'Inicio'");
                        while($row = mysqli_fetch_assoc($dia_feriado_q))
                        {
                          echo '<td data-toggle="tooltip" data-placement="top" title="Feriado">' .$row['count_feriado_q'] .'</td>';
                        }
                        $dia_licencia_q = mysqli_query($conn, "SELECT *, COUNT(quien) as 'count_licencia_q' FROM movimiento_interno WHERE inicio LIKE '%$mes%' AND quien = '$asis_quien' AND dia = 'Licencia' AND movimiento = 'Inicio'");
                        while($row = mysqli_fetch_assoc($dia_licencia_q))
                        {
                          echo '<td data-toggle="tooltip" data-placement="top" title="Licencia">' .$row['count_licencia_q'] .'</td>';
                        }
                        $dia_vacaciones_q = mysqli_query($conn, "SELECT *, COUNT(quien) as 'count_vacaciones_q' FROM movimiento_interno WHERE inicio LIKE '%$mes%' AND quien = '$asis_quien' AND dia = 'Vacaciones' AND movimiento = 'Inicio'");
                        while($row = mysqli_fetch_assoc($dia_vacaciones_q))
                        {
                          echo '<td data-toggle="tooltip" data-placement="top" title="Vacaciones">' .$row['count_vacaciones_q'] .'</td>';
                        }
                        $dia_dia_libre_q = mysqli_query($conn, "SELECT *, COUNT(quien) as 'count_dia_libre_q' FROM movimiento_interno WHERE inicio LIKE '%$mes%' AND quien = '$asis_quien' AND dia = 'Dia libre' AND movimiento = 'Inicio'");
                        while($row = mysqli_fetch_assoc($dia_dia_libre_q))
                        {
                          echo '<td data-toggle="tooltip" data-placement="top" title="Dia libre">' .$row['count_dia_libre_q'] .'</td>';
                        }
                        $dia_ausente_q = mysqli_query($conn, "SELECT *, COUNT(quien) as 'count_ausente_q' FROM movimiento_interno WHERE inicio LIKE '%$mes%' AND quien = '$asis_quien' AND dia = 'Ausente' AND movimiento = 'Inicio'");
                        while($row = mysqli_fetch_assoc($dia_ausente_q))
                        {
                          echo '<td data-toggle="tooltip" data-placement="top" title="Ausente">' .$row['count_ausente_q'] .'</td>';
                        }
                        $dia_suspension_q = mysqli_query($conn, "SELECT *, COUNT(quien) as 'count_suspension_q' FROM movimiento_interno WHERE inicio LIKE '%$mes%' AND quien = '$asis_quien' AND dia = 'Suspension' AND movimiento = 'Inicio'");
                        while($row = mysqli_fetch_assoc($dia_suspension_q))
                        {
                          echo '<td data-toggle="tooltip" data-placement="top" title="Suspension">' .$row['count_suspension_q'] .'</td>';
                        }
                      ?>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Asistencia de ayudantes</p>
          <i class="fas fa-check-circle text-success text-center"></i><span> Presente</span>
          <br>
          <i class="fas fa-times-circle text-danger text-center"></i><span> Ausente</span>
          <br>
          <i class="fas fa-minus-circle text-warning text-center"></i><span> Justificado</span>
          <br>
          <i class="fas fa-minus-circle text-dark text-center"></i><span> Aun no ingresa</span>
          <br>
          <i class="fas fa-check-circle text-info text-center"></i><span> Esta instalando</span>
          <br>
          <i class="fas fa-times-circle text-dark text-center"></i><span> Ya no trabaja</span>
          <table class="table table-responsive table-striped table-hover table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>           
                <th>Nombre</th>
                <th>P</th>
                <th>A</th>
                <?php
                  $queryyy = "SELECT * FROM asistenciaayudantes WHERE fecha like '%$mes%' GROUP BY fecha ORDER BY fecha asc";
                  $result_tasksa = mysqli_query($conn, $queryyy);   
                  while($row = mysqli_fetch_assoc($result_tasksa)) { 
                  $fech  = $row['fecha'];             
                  $solofech = explode("-", $fech);
                  $fechafecha = $solofech[2];
                  ?>
                <th><?php echo $fechafecha; ?></th>
                <?php } ?>

              </tr>
            </thead>
            <tbody align="center">
              
                <?php
                $queryy = "SELECT * FROM asistenciaayudantes WHERE fecha like '%$mes%' GROUP BY nombre ORDER BY nombre, fecha asc";
                $result_task = mysqli_query($conn, $queryy);   
                while($row = mysqli_fetch_array($result_task)) { ?>
              <tr>
                <td><?php $nom = $row['nombre']; echo $nom; ?></td>

                <?php
                $consulta2 = "SELECT count(dia) as 'prese' FROM asistenciaayudantes WHERE fecha like '%$mes%' AND dia = 'Presente' AND nombre ='$nom'";
                $respuesta2 = mysqli_query($conn, $consulta2);   
                while($row = mysqli_fetch_array($respuesta2)) { ?>
                <td><?php echo $row['prese']; ?></td>
                <?php  }?>

                <?php
                $consulta3 = "SELECT count(dia) as 'ausen' FROM asistenciaayudantes WHERE fecha like '%$mes%' AND dia = 'Ausente' AND nombre ='$nom'";
                $respuesta3 = mysqli_query($conn, $consulta3);   
                while($row = mysqli_fetch_array($respuesta3)) { ?>
                <td><?php echo $row['ausen']; ?></td>
                <?php  }?>

                <?php
                $query = "SELECT * FROM asistenciaayudantes WHERE fecha like '%$mes%' AND nombre ='$nom' GROUP BY fecha ORDER BY fecha asc";
                $result_tas = mysqli_query($conn, $query);   
                while($row = mysqli_fetch_array($result_tas)) { ?>
                <td><?php if ($row['dia'] == 'Presente'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                          if ($row['dia'] == 'Ausente'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';}
                          if ($row['dia'] == 'Justificado'){echo '<i class="fas fa-minus-circle text-warning text-center"></i>';}
                          if ($row['dia'] == 'Aun no ingresa'){echo '<i class="fas fa-minus-circle text-dark text-center"></i>';}
                          if ($row['dia'] == 'Esta como tecnico'){echo '<i class="fas fa-check-circle text-info text-center"></i>';}
                          if ($row['dia'] == 'Ya no trabaja'){echo '<i class="fas fa-times-circle text-dark text-center"></i>';}?></td>
                <?php } ?>
            </tr>	
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
        <p class="h4 mb-4 text-center">Asistencia de ATC</p>
        <i class="fas fa-check-circle text-success text-center"></i><span> Presente</span>
        <br>
        <i class="fas fa-times-circle text-danger text-center"></i><span> Ausente</span>
        <br>
        <i class="fas fa-minus-circle text-warning text-center"></i><span> Justificado</span>
        <br>
        <i class="fas fa-minus-circle text-dark text-center"></i><span> Aun no ingresa</span>
        <br>
        <i class="fas fa-times-circle text-dark text-center"></i><span> Ya no trabaja</span>
          <table class="table table-responsive table-striped table-hover table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>
                <th>Nombre</th>
                <th>P</th>
                <th>A</th>
                  <?php
                    $queryyy = "SELECT * FROM asistenciaatc WHERE fecha like '%$mes%' GROUP BY fecha ORDER BY fecha asc";
                    $result_tasksa = mysqli_query($conn, $queryyy);   
                    while($row = mysqli_fetch_assoc($result_tasksa))
                    { 
                      $fech  = $row['fecha'];             
                      $solofech = explode("-", $fech);
                      $fechafecha = $solofech[2];
                  ?>
                  <th><?php echo $fechafecha; ?></th>
                  <?php } ?>
              </tr>
            </thead>
            <tbody align="center">
                <?php
                  $result_task = mysqli_query($conn, "SELECT * FROM asistenciaatc WHERE fecha like '%$mes%' GROUP BY nombre ORDER BY nombre, fecha asc");   
                  while($row = mysqli_fetch_array($result_task))
                  {
                ?>
              <tr>
                <td><?php $nom = $row['nombre']; echo $nom; ?></td>
                <?php
                  $respuesta2 = mysqli_query($conn, "SELECT count(dia) as 'prese' FROM asistenciaatc WHERE fecha like '%$mes%' AND dia = 'Presente' AND nombre ='$nom'");
                  while($row = mysqli_fetch_array($respuesta2))
                  {
                ?>
                <td><?php echo $row['prese']; ?></td>
                <?php  }?>

                <?php
                  $respuesta3 = mysqli_query($conn, "SELECT count(dia) as 'ausen' FROM asistenciaatc WHERE fecha like '%$mes%' AND dia = 'Ausente' AND nombre ='$nom'");
                  while($row = mysqli_fetch_array($respuesta3))
                  {
                ?>
                  <td><?php echo $row['ausen']; ?></td>
                <?php } ?>

                <?php
                  $result_tas = mysqli_query($conn, "SELECT * FROM asistenciaatc WHERE fecha like '%$mes%' AND nombre ='$nom' GROUP BY fecha ORDER BY fecha asc");   
                  while($row = mysqli_fetch_array($result_tas))
                  {
                ?>
                  <td>
                    <?php
                      if ($row['dia'] == 'Presente'){echo '<i class="fas fa-check-circle text-success text-center"></i>';}
                      if ($row['dia'] == 'Ausente'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} 
                      if ($row['dia'] == 'Justificado'){echo '<i class="fas fa-minus-circle text-warning text-center"></i>';}
                      if ($row['dia'] == 'Aun no ingresa'){echo '<i class="fas fa-minus-circle text-dark text-center"></i>';}
                      if ($row['dia'] == 'Ya no trabaja'){echo '<i class="fas fa-times-circle text-dark text-center"></i>';}
                    ?>
                  </td>
                <?php } ?>

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
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
</body>
</html>