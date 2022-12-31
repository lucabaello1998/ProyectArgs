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
<?php include('../includes/header.php'); 
$mes = date ('Y-m', strtotime('-0 month'));
if(isset($_GET['dia']))
{
  $dia = $_GET['dia'];
  $desencriptado = base64_decode($dia);
  /* FECHA INICIO */
    $fecha_desc = date("l j m Y", strtotime($desencriptado));

    $fechi  = $fecha_desc;
    $so_fechi = explode(" ", $fechi);
    $dia_nombre = $so_fechi[0];
    $dia_numero = $so_fechi[1];
    $mes_nombre = $so_fechi[2];
    $anio_numero = $so_fechi[3];

    switch ($dia_nombre)
    {
      case 'Monday': $dia_mm = "Lunes";
      break;
      case 'Tuesday': $dia_mm = "Martes";
      break;
      case 'Wednesday': $dia_mm = "Miercoles";
      break;
      case 'Thursday': $dia_mm = "Jueves";
      break;
      case 'Friday': $dia_mm = "Viernes";
      break;
      case 'Saturday': $dia_mm = "Sabado";
      break;
      case 'Sunday': $dia_mm = "Domingo";
      break;
    }
    switch ($mes_nombre)
    {
      case '12': $mes_mm = "Diciembre";
      break;
      case '11': $mes_mm = "Noviembre";
      break;
      case '10': $mes_mm = "Octubre";
      break;
      case '09': $mes_mm = "Septiembre";
      break;
      case '08': $mes_mm = "Agosto";
      break;
      case '07': $mes_mm = "Julio";
      break;
      case '06': $mes_mm = "Junio";
      break;
      case '05': $mes_mm = "Mayo";
      break;
      case '04': $mes_mm = "Abril";
      break;
      case '03': $mes_mm = "Marzo";
      break;
      case '02': $mes_mm = "Febrero";
      break;
      case '01': $mes_mm = "Enero";
      break;
    }
    $fecha_dia = $dia_mm .' ' .$dia_numero .' de ' .$mes_mm ;
  /* FECHA INICIO */
}
?>
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <h4 class="modal-title" text-center>Descarga del dia <?php echo $fecha_dia; ?></h4>
        </div>
      </div>
        <?php
          $q_1 = "SELECT COUNT(ot) as 'otes', tecnico FROM asignacion_material WHERE fecha = '$desencriptado' AND tipo = 'Asignacion' GROUP BY tecnico ";
          $re_1 = mysqli_query($conn, $q_1);
          while($row = mysqli_fetch_assoc($re_1)) {
          $tecniquitos = $row['tecnico'];
        ?>
        <div class="row justify-content-center p-1">
          <div class="col-auto">
            <table class="table table-responsive table-striped table-bordered table-sm">
              <thead class="thead-dark text-center">
                <tr>
                  <th colspan="<?php echo $row['otes']; ?>"><?php echo $tecniquitos; ?></th>
                </tr>
                <tr>
                  <th>Material</th>
                  <th>Entregado</th>
                  <?php
                    $re_11 = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE fecha = '$desencriptado' AND tipo = 'Descarga' AND tecnico = '$tecniquitos' AND tipo = 'Descarga' GROUP BY ot ");
                    while($row = mysqli_fetch_assoc($re_11)) {
                      $ot_dire = $row['ot'];
                      $ot_usado = $row['usado'];
                  ?>
                  <th><?php echo $ot_dire; ?></th>
                  <?php } ?>
                  <th>Usado</th>
                  <th>Resto</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <!-- NOMBRE MATERIALES -->
                    <?php 
                      $query_tectec = "SELECT SUM(cantidad) as 'entregado', material, fecha, seriado, cantidad FROM asignacion_material WHERE fecha = '$desencriptado' AND tecnico = '$tecniquitos' AND tipo = 'Asignacion' GROUP BY material, seriado ";
                      $result_tectec = mysqli_query($conn, $query_tectec);
                      while($row = mysqli_fetch_assoc($result_tectec))
                      {
                        $materiall = $row['material'];
                        $seriall = $row['seriado'];
                        $entregadoll = $row['entregado'];
                        if( $seriall == '' )
                        {
                        /* MATERIAL */  echo '<td>' .utf8_encode(utf8_decode($materiall)) .'</td>';
                        }
                        else
                        {
                        /* MATERIAL */  echo '<td>' . $seriall .'</td>';
                        }
                    ?>
                  <!-- NOMBRE MATERIALES -->
                  <!-- ENTREGADO -->
                      <?php
                        echo '<td bgcolor="#fdfad6" style="color: #212529 !important;" align="center">' .$entregadoll .'</td>';
                      ?>
                  <!-- ENTREGADO -->
                  <!-- USADO -->
                      <?php
                        $re_12 = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE fecha = '$desencriptado' AND tipo = 'Descarga' AND tecnico = '$tecniquitos' AND tipo = 'Descarga' GROUP BY ot ");
                        while($row = mysqli_fetch_assoc($re_12))
                        {
                          $ot_direccion = $row['ot'];
                          if($seriall == '' )
                          {
                            $query_1 = "SELECT SUM(usado) as 'usado', material, fecha FROM asignacion_material WHERE fecha = '$desencriptado' AND tecnico = '$tecniquitos' AND tipo = 'Descarga' AND material = '$materiall' AND ot = '$ot_direccion' ";
                            $result_1 = mysqli_query($conn, $query_1);
                            while($roww = mysqli_fetch_assoc($result_1))
                            {
                              if($roww['usado'] == 0)
                              {
                                $usausa = 0;
                              }
                              else
                              {
                                $usausa = $roww['usado'];
                              }
                              echo '<td align="center">' .$usausa .'</td>';
                            }
                          }
                          else
                          {
                            $query_1 = "SELECT SUM(usado) as 'usado', material, fecha FROM asignacion_material WHERE fecha = '$desencriptado' AND tecnico = '$tecniquitos' AND tipo = 'Descarga' AND seriado = '$seriall' AND ot = '$ot_direccion' ";
                            $result_1 = mysqli_query($conn, $query_1);
                            while($roww = mysqli_fetch_assoc($result_1))
                            {
                              if($roww['usado'] == 0)
                              {
                                $usausa = 0;
                              }
                              else
                              {
                                $usausa = $roww['usado'];
                              }
                              echo '<td !important;" align="center">' .$usausa .'</td>';
                            }
                          }                              
                        }
                      ?>
                  <!-- USADO -->
                  <!-- RESTANTE -->
                      <?php
                        if( $seriall == '' )
                        {
                          $query_1 = "SELECT SUM(usado) as 'usado_otes', material, fecha FROM asignacion_material WHERE fecha = '$desencriptado' AND tecnico = '$tecniquitos' AND tipo = 'Descarga' AND material = '$materiall' ";
                          $result_1 = mysqli_query($conn, $query_1);
                          while($rowww = mysqli_fetch_assoc($result_1))
                          {
                            if($rowww['usado_otes'] == 0)
                            {
                              $usado_otes = 0;
                            }
                            else
                            {
                              $usado_otes = $rowww['usado_otes'];
                            }
                            echo '<td bgcolor="#ffefd5" style="color: #212529 !important;" align="center">' .$usado_otes .'</td>';
                          }
                        }
                        else
                        {
                          $query_1 = "SELECT SUM(usado) as 'usado_otes', material, fecha FROM asignacion_material WHERE fecha = '$desencriptado' AND tecnico = '$tecniquitos' AND tipo = 'Descarga' AND seriado = '$seriall' ";
                          $result_1 = mysqli_query($conn, $query_1);
                          while($rowww = mysqli_fetch_assoc($result_1))
                          {
                            if($rowww['usado_otes'] == 0)
                            {
                              $usado_otes = 0;
                            }
                            else
                            {
                              $usado_otes = $rowww['usado_otes'];
                            }
                            echo '<td bgcolor="#ffefd5" style="color: #212529 !important;" align="center">' .$usado_otes .'</td>';
                          }
                        }
                      ?>
                  <!-- RESTANTE -->
                    <td bgcolor='#bcf8ca' style="color: #212529 !important;" align="center"><?php $total_resto = $entregadoll - $usado_otes; echo '<b>' .$total_resto .'</b>'; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php } ?>
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

