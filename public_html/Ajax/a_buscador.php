<?php
include("../db.php");
$key = $_POST['key'];

/* CARGA_DIA */
  $carga_dia = mysqli_query($conn, "SELECT DISTINCT * FROM carga_dia WHERE ot LIKE '%$key%' OR tecnico LIKE '%$key%' OR direccion LIKE '%$key%' OR cliente LIKE '%$key%' OR nota_cierre LIKE '%$key%' OR fecha LIKE '%$key%' OR nim LIKE '%$key%' OR id_actividad LIKE '%$key%' GROUP BY ot LIMIT 5");
  if (mysqli_num_rows($carga_dia) >= 1)
  {
  ?>
    <p class="h4 mb-4 text-center">Carga de produccion</p>
    <table class="table table-responsive table-striped table-bordered table-sm">
      <thead class="thead-dark text-center">
        <tr>
          <th>Tecnico</th>
          <th>Fecha</th>
          <th>OT</th>
          <th>NIM</th>
          <th>ID actividad</th>
          <th>Codigo</th>
          <th>TV</th>
          <th>Actividad</th>
          <th>Estado</th>
          <th>Inicio</th>
          <th>Fin</th>
          <th>Razon completada</th>
          <th>Razon no completada</th>
          <th>Observacion</th>
          <th>Revisita</th>
          <th>Cliente</th>
          <th>Telefono</th>
          <th>Direccion</th>
          <th>Localidad</th>
          <th>Zona</th>
        </tr>
      </thead>
      <tbody align="center">
        <?php
          $f = mysqli_query($conn, "SELECT DISTINCT * FROM carga_dia WHERE ot LIKE '%$key%' OR tecnico LIKE '%$key%' OR direccion LIKE '%$key%' OR cliente LIKE '%$key%' OR nota_cierre LIKE '%$key%' OR fecha LIKE '%$key%' OR nim LIKE '%$key%' OR id_actividad LIKE '%$key%' GROUP BY ot ORDER BY id ASC LIMIT 5");
          while($row = mysqli_fetch_assoc($f))
          {
        ?>
          <tr>
            <td class=" <?php if(stripos($row['tecnico'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo utf8_decode($row['tecnico']); ?></td>
            <td class=" <?php if(stripos($row['fecha'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo Fecha3($row['fecha']); ?></td>
            <td class=" <?php if(stripos($row['ot'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $row['ot']; ?></td>
            <td class=" <?php if(stripos($row['nim'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $row['nim']; ?></td>
            <td class=" <?php if(stripos($row['id_actividad'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $row['id_actividad']; ?></td> 
            <td class=" <?php if(stripos($row['codigo'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $row['codigo']; ?></td>
            <td class=" <?php if(stripos($row['cantidad_tv'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $row['cantidad_tv']; ?></td>
            <td class=" <?php if(stripos($row['actividad'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo utf8_encode($row['actividad']); ?></td>
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
            <td class=" <?php if(stripos($row['estado'], $key) !== false){echo 'bg-warning';} ?>" ><span class="badge badge-pill <?php echo $color_badge; ?>"><?php echo $row['estado'] ?></span></td>
            <td class=" <?php if(stripos($row['inicio'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo substr($row['inicio'], 0, -3); ?></td>
            <td class=" <?php if(stripos($row['fin'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo substr($row['fin'], 0, -3); ?></td>
            <td class=" <?php if(stripos($row['razon_completada'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo utf8_encode($row['razon_completada']); ?></td>
            <td class=" <?php if(stripos($row['razon_no_completada'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo utf8_encode($row['razon_no_completada']); ?></td>
            <td class=" <?php if(stripos($row['nota_cierre'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo utf8_encode($row['nota_cierre']); ?></td>
            <td class=" <?php if(stripos($row['revisita'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $row['revisita']; ?></td>
            <td class=" <?php if(stripos($row['cliente'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo utf8_encode($row['cliente']); ?></td>
            <td class=" <?php if(stripos($row['telefono'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $row['telefono']; ?></td>
            <td class=" <?php if(stripos($row['direccion'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo utf8_encode($row['direccion']); ?></td>
            <td class=" <?php if(stripos($row['localidad'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo utf8_encode($row['localidad']); ?></td>
            <td class=" <?php if(stripos($row['zona'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo utf8_encode($row['zona']); ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php }
/* CARGA_DIA */

/* RECLAMOS */
  $reclamo = mysqli_query($conn, "SELECT DISTINCT * FROM reclamos WHERE tecnico LIKE '%$key%' OR rf LIKE '%$key%' OR ot LIKE '%$key%' OR direccion LIKE '%$key%' OR fechains LIKE '%$key%' OR fechamail LIKE '%$key%' OR telefono LIKE '%$key%' OR problema LIKE '%$key%' OR fechasolu LIKE '%$key%' OR solucion LIKE '%$key%' LIMIT 5");
  if (mysqli_num_rows($reclamo) >= 1)
  {
  ?>
  <br>
    <p class="h4 mb-4 text-center">Carga de reclamos</p>
    <table class="table table-responsive table-striped table-bordered table-sm">
      <thead class="thead-dark text-center">
        <tr>
          <th>Tecnico</th>
          <th>RF</th>
          <th>OT</th>
          <th>Fecha instalacion</th>
          <th>Fecha del mail</th>
          <th>Direccion</th>
          <th>Telefono</th>
          <th>Problema</th> 
          <th>Fecha solucion</th>
          <th>Solucion</th>
        </tr>
      </thead>
      <tbody align="center">
        <?php
          $r = mysqli_query($conn, "SELECT DISTINCT * FROM reclamos WHERE tecnico LIKE '%$key%' OR rf LIKE '%$key%' OR ot LIKE '%$key%' OR direccion LIKE '%$key%' OR fechains LIKE '%$key%' OR fechamail LIKE '%$key%' OR telefono LIKE '%$key%' OR problema LIKE '%$key%' OR fechasolu LIKE '%$key%' OR solucion LIKE '%$key%' LIMIT 5");
          while($re = mysqli_fetch_assoc($r))
          {
        ?>
          <tr>
            <td class=" <?php if(stripos($re['tecnico'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $re['tecnico']; ?></td>
            <td class=" <?php if(stripos($re['rf'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $re['rf']; ?></td>
            <td class=" <?php if(stripos($re['ot'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $re['ot']; ?></td>
            <td class=" <?php if(stripos($re['fechains'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo Fecha3($re['fechains']); ?></td>
            <td class=" <?php if(stripos($re['fechamail'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo Fecha3($re['fechamail']); ?></td>
            <td class=" <?php if(stripos($re['direccion'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $re['direccion']; ?></td>
            <td class=" <?php if(stripos($re['telefono'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $re['telefono']; ?></td>
            <td class=" <?php if(stripos($re['problema'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $re['problema']; ?></td>
            <td class=" <?php if(stripos($re['fechasolu'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo Fecha3($re['fechasolu']); ?></td>
            <td class=" <?php if(stripos($re['solucion'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $re['solucion']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php }
/* RECLAMOS */

/* MATERIALES */
  $materiales = mysqli_query($conn, "SELECT DISTINCT * FROM ingresomaterial WHERE seriado <> '' AND seriado LIKE '%$key%' OR seriado <> '' AND deposito LIKE '%$key%' OR seriado <> '' AND fecha LIKE '%$key%' OR seriado <> '' AND num_pedido LIKE '%$key%' OR seriado <> '' AND sap LIKE '%$key%' OR seriado <> '' AND ot LIKE '%$key%' LIMIT 5");
  if (mysqli_num_rows($materiales) >= 1)
  {
  ?>
  <br>
    <p class="h4 mb-4 text-center">Materiales</p>
    <table class="table table-responsive table-striped table-bordered table-sm">
      <thead class="thead-dark text-center">
        <tr>
          <th>Deposito</th>
          <th>Fecha</th>
          <th>Num pedido</th>
          <th>Sap</th>
          <th>Material</th>
          <th>Num serie</th>
          <th>OT</th>
          <th>Cantidad</th>
          <th>Observaciones</th>
          <th>Descargado por</th>
          <th>Fecha de descarga</th>
        </tr>
      </thead>
      <tbody align="center">
        <?php
          $m = mysqli_query($conn, "SELECT DISTINCT * FROM ingresomaterial WHERE seriado <> '' AND seriado LIKE '%$key%' OR seriado <> '' AND deposito LIKE '%$key%' OR seriado <> '' AND fecha LIKE '%$key%' OR seriado <> '' AND num_pedido LIKE '%$key%' OR seriado <> '' AND sap LIKE '%$key%' OR seriado <> '' AND ot LIKE '%$key%' ORDER BY id ASC LIMIT 5");
          while($mm = mysqli_fetch_assoc($m))
          {
        ?>
          <tr>
            <td class=" <?php if(stripos($mm['deposito'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mm['deposito']; ?></td>
            <td class=" <?php if(stripos($mm['fecha'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo Fecha3($mm['fecha']); ?></td>
            <td class=" <?php if(stripos($mm['num_pedido'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mm['num_pedido']; ?></td>
            <td class=" <?php if(stripos($mm['sap'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mm['sap']; ?></td>
            <td class=" <?php if(stripos($mm['material'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo utf8_encode($mm['material']); ?></td>
            <td class=" <?php if(stripos($mm['seriado'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mm['seriado']; ?></td>
            <td class=" <?php if(stripos($mm['ot'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mm['ot']; ?></td>
            <td class=" <?php if(stripos($mm['cantidad'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mm['cantidad']; ?></td>
            <td><?php if($mm['obs'] == ''){echo '-';} else { echo $mm['obs']; } ?></td>
            <td><?php if($mm['descargado_por'] == ''){echo '-';} else { echo $mm['descargado_por']; } ?></td>
            <td><?php if($mm['descargado_cuando'] == '0000-00-00'){echo '-';} else { echo $mm['descargado_cuando']; } ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php }
/* MATERIALES */

/* GARANTIAS */
  $garantias = mysqli_query($conn, "SELECT DISTINCT * FROM garantias WHERE ot LIKE '%$key%' OR tecnico LIKE '%$key%' OR direccion LIKE '%$key%' OR zona LIKE '%$key%' OR fechaint LIKE '%$key%' OR fecharep LIKE '%$key%' OR tecrep LIKE '%$key%' OR coment LIKE '%$key%' OR nota_cliente LIKE '%$key%' OR obs LIKE '%$key%' OR supervisor LIKE '%$key%' OR direccion LIKE '%$key%' OR obs_supervisor LIKE '%$key%' LIMIT 5");
  if (mysqli_num_rows($garantias) >= 1)
  {
  ?>
  <br>
    <p class="h4 mb-4 text-center">Carga de garantias</p>
    <table class="table table-responsive table-striped table-bordered table-sm">
      <thead class="thead-dark text-center">
        <tr>
          <th>Tecnico</th>
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
          <th>Notas WFM</th>
          <th>Notas del tecnico</th>
          <?php if($tipo == 'Despacho' || $tipo == 'Administrador') {?>
            <th>Supervisor</th>
            <th>Cuando</th>
          <?php } ?>
          <th>Obs supervisor</th>
        </tr>
      </thead>
      <tbody align="center">
        <?php
          $g = mysqli_query($conn, "SELECT DISTINCT * FROM garantias WHERE ot LIKE '%$key%' OR tecnico LIKE '%$key%' OR direccion LIKE '%$key%' OR zona LIKE '%$key%' OR fechaint LIKE '%$key%' OR fecharep LIKE '%$key%' OR tecrep LIKE '%$key%' OR coment LIKE '%$key%' OR nota_cliente LIKE '%$key%' OR obs LIKE '%$key%' OR supervisor LIKE '%$key%' OR direccion LIKE '%$key%' OR obs_supervisor LIKE '%$key%' ORDER BY id ASC LIMIT 5");
          while($gg = mysqli_fetch_assoc($g))
          {
        ?>
          <tr>
            <td class=" <?php if(stripos($gg['tecnico'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $gg['tecnico']; ?></td>
            <td class=" <?php if(stripos($gg['ot'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $gg['ot']; ?></td>
            <td class=" <?php if(stripos($gg['direccion'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $gg['direccion']; ?></td>
            <td class=" <?php if(stripos($gg['zona'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $gg['zona']; ?></td>
            <td class=" <?php if(stripos($gg['fechaint'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo Fecha3($gg['fechaint']); ?></td>
            <td class=" <?php if(stripos($gg['fecharep'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo Fecha3($gg['fecharep']); ?></td>
            <td class=" <?php if(stripos($gg['tecrep'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $gg['tecrep']; ?></td>
            <td class=" <?php if(stripos($gg['coment'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $gg['coment']; ?></td>
            <td class=" <?php if(stripos($gg['repa'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $gg['repa']; ?></td>
            <td class=" <?php if(stripos($gg['justificado'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $gg['justificado']; ?></td>
            <td class=" <?php if(stripos($gg['intervencion'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $gg['intervencion']; ?></td>
            <td class=" <?php if(stripos($gg['nota_cliente'], $key) !== false){echo 'bg-warning';} ?>"  data-toggle="tooltip" data-placement="top" title="<?php echo $gg['nota_cliente']; ?>"><?php echo limitar_cadena($gg['nota_cliente'], 50); ?></td>
            <td class=" <?php if(stripos($gg['obs'], $key) !== false){echo 'bg-warning';} ?>"  data-toggle="tooltip" data-placement="top" title="<?php echo $gg['obs']; ?>"><?php echo limitar_cadena($gg['obs'], 50); ?></td>
            <?php if($tipo == 'Despacho' || $tipo == 'Administrador') {?>
              <td class=" <?php if(stripos($gg['supervisor'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $gg['supervisor']; ?></td> 
              <td class=" <?php if(stripos($gg['cuando'], $key) !== false){echo 'bg-warning';} ?>" ><?php if($gg['cuando'] == '0000-00-00 00:00:00'){echo '';}else{echo Fecha12($gg['cuando']);}; ?></td> 
            <?php } ?>
            <td class=" <?php if(stripos($gg['obs_supervisor'], $key) !== false){echo 'bg-warning';} ?>"  data-toggle="tooltip" data-placement="top" title="<?php echo $gg['obs_supervisor']; ?>"><?php echo limitar_cadena($gg['obs_supervisor'], 50); ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php }
/* GARANTIAS */

/* ALTAS */
  $alta = mysqli_query($conn, "SELECT DISTINCT * FROM altas WHERE ot LIKE '%$key%' OR tecnico LIKE '%$key%' OR direccion LIKE '%$key%' OR zona LIKE '%$key%' OR calendario LIKE '%$key%' OR mac_ont LIKE '%$key%' OR sn_ont LIKE '%$key%' OR mac_uno_stb LIKE '%$key%' OR sn_uno_stb LIKE '%$key%' OR mac_dos_stb LIKE '%$key%' OR sn_dos_stb LIKE '%$key%' OR mac_tres_stb LIKE '%$key%' OR sn_tres_stb LIKE '%$key%' OR ap_uno_mac LIKE '%$key%' OR ap_uno_sn LIKE '%$key%' OR ap_dos_mac LIKE '%$key%' OR ap_dos_sn LIKE '%$key%' OR ap_tres_mac LIKE '%$key%' OR ap_tres_sn LIKE '%$key%' OR id_actividad LIKE '%$key%' OR nim LIKE '%$key%' OR cliente LIKE '%$key%' OR telefono LIKE '%$key%' LIMIT 5");
  if (mysqli_num_rows($alta) >= 1)
  {
  ?>
  <br>
    <p class="h4 mb-4 text-center">Carga de altas</p>
    <table class="table table-responsive table-striped table-bordered table-sm">
      <thead class="thead-dark text-center">
        <tr>
          <th>Tecnico</th>
          <th>OT</th>
          <th>Id actividad</th>
          <th>NIM</th>
          <th>Direccion</th>
          <th>Cliente</th>
          <th>Telefono</th>
          <th>Zona</th>
          <th>Fecha</th>
          <th>ONT MAC</th>
          <th>ONT SN</th>
          <th>STB 1 MAC</th>
          <th>STB 1 SN</th>
          <th>STB 2 MAC</th>
          <th>STB 2 SN</th>
          <th>STB 3 MAC</th>
          <th>STB 3 SN</th>
          <th>AP 1 MAC</th>
          <th>AP 1 SN</th>
          <th>AP 2 MAC</th>
          <th>AP 2 SN</th>
          <th>AP 3 MAC</th>
          <th>AP 3 SN</th>
        </tr>
      </thead>
      <tbody align="center">
        <?php
          $a = mysqli_query($conn, "SELECT DISTINCT * FROM altas WHERE ot LIKE '%$key%' OR tecnico LIKE '%$key%' OR direccion LIKE '%$key%' OR zona LIKE '%$key%' OR calendario LIKE '%$key%' OR mac_ont LIKE '%$key%' OR sn_ont LIKE '%$key%' OR mac_uno_stb LIKE '%$key%' OR sn_uno_stb LIKE '%$key%' OR mac_dos_stb LIKE '%$key%' OR sn_dos_stb LIKE '%$key%' OR mac_tres_stb LIKE '%$key%' OR sn_tres_stb LIKE '%$key%' OR ap_uno_mac LIKE '%$key%' OR ap_uno_sn LIKE '%$key%' OR ap_dos_mac LIKE '%$key%' OR ap_dos_sn LIKE '%$key%' OR ap_tres_mac LIKE '%$key%' OR ap_tres_sn LIKE '%$key%' OR id_actividad LIKE '%$key%' OR nim LIKE '%$key%' OR cliente LIKE '%$key%' OR telefono LIKE '%$key%' ORDER BY id ASC LIMIT 5");
          while($aa = mysqli_fetch_assoc($a))
          {
        ?>
          <tr>
            <td class=" <?php if(stripos($aa['tecnico'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $aa['tecnico']; ?></td>
            <td class=" <?php if(stripos($aa['ot'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $aa['ot']; ?></td>
            <td class=" <?php if(stripos($aa['id_actividad'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $aa['id_actividad']; ?></td>
            <td class=" <?php if(stripos($aa['nim'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $aa['nim']; ?></td>
            <td class=" <?php if(stripos($aa['direccion'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $aa['direccion']; ?></td>
            <td class=" <?php if(stripos($aa['cliente'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $aa['cliente']; ?></td>
            <td class=" <?php if(stripos($aa['telefono'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $aa['telefono']; ?></td>
            <td class=" <?php if(stripos($aa['zona'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $aa['zona']; ?></td>
            <td class=" <?php if(stripos($aa['calendario'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo Fecha3($aa['calendario']); ?></td>
            <td class=" <?php if(stripos($aa['mac_ont'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $aa['mac_ont']; ?></td>
            <td class=" <?php if(stripos($aa['sn_ont'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $aa['sn_ont']; ?></td>
            <td class=" <?php if(stripos($aa['mac_uno_stb'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $aa['mac_uno_stb']; ?></td>
            <td class=" <?php if(stripos($aa['sn_uno_stb'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $aa['sn_uno_stb']; ?></td>
            <td class=" <?php if(stripos($aa['mac_dos_stb'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $aa['mac_dos_stb']; ?></td>
            <td class=" <?php if(stripos($aa['sn_dos_stb'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $aa['sn_dos_stb']; ?></td>
            <td class=" <?php if(stripos($aa['mac_tres_stb'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $aa['mac_tres_stb']; ?></td>
            <td class=" <?php if(stripos($aa['sn_tres_stb'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $aa['sn_tres_stb']; ?></td>
            <td class=" <?php if(stripos($aa['ap_uno_mac'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $aa['ap_uno_mac']; ?></td>
            <td class=" <?php if(stripos($aa['ap_uno_sn'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $aa['ap_uno_sn']; ?></td>
            <td class=" <?php if(stripos($aa['ap_dos_mac'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $aa['ap_dos_mac']; ?></td>
            <td class=" <?php if(stripos($aa['ap_dos_sn'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $aa['ap_dos_sn']; ?></td>
            <td class=" <?php if(stripos($aa['ap_tres_mac'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $aa['ap_tres_mac']; ?></td>
            <td class=" <?php if(stripos($aa['ap_tres_sn'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $aa['ap_tres_sn']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php }
/* ALTAS */

/* BAJAS */
  $baja = mysqli_query($conn, "SELECT DISTINCT * FROM bajas WHERE tecnico LIKE '%$key%' OR ot LIKE '%$key%' OR tkl LIKE '%$key%' OR motivo LIKE '%$key%' OR direccion LIKE '%$key%' OR zona LIKE '%$key%' OR calendario LIKE '%$key%' OR obs_tecnico LIKE '%$key%' OR nim LIKE '%$key%' LIMIT 5");
  if (mysqli_num_rows($baja) >= 1)
  {
  ?>
  <br>
    <p class="h4 mb-4 text-center">Carga de bajas</p>
    <table class="table table-responsive table-striped table-bordered table-sm">
      <thead class="thead-dark text-center">
        <tr>
          <th>Fecha</th>
          <th>Tecnico</th>
          <th>OT</th>
          <th>NIM</th>
          <th>Numero de Interaccion</th>
          <th>Motivo del cierre</th>
          <th>Obs del tecnico</th>
          <th>Direccion</th>
          <th>Zona</th>          
        </tr>
      </thead>
      <tbody align="center">
        <?php
          $b = mysqli_query($conn, "SELECT DISTINCT * FROM bajas WHERE tecnico LIKE '%$key%' OR ot LIKE '%$key%' OR tkl LIKE '%$key%' OR motivo LIKE '%$key%' OR direccion LIKE '%$key%' OR zona LIKE '%$key%' OR calendario LIKE '%$key%' OR obs_tecnico LIKE '%$key%' OR nim LIKE '%$key%' ORDER BY id ASC LIMIT 5");
          while($bb = mysqli_fetch_assoc($b))
          {
        ?>
          <tr>
            <td class=" <?php if(stripos($bb['calendario'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo Fecha3($bb['calendario']); ?></td>
            <td class=" <?php if(stripos($bb['tecnico'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $bb['tecnico']; ?></td>
            <td class=" <?php if(stripos($bb['ot'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $bb['ot']; ?></td>
            <td class=" <?php if(stripos($bb['nim'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $bb['nim']; ?></td>
            <td class=" <?php if(stripos($bb['tkl'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $bb['tkl']; ?></td>
            <td class=" <?php if(stripos($bb['motivo'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $bb['motivo']; ?></td>
            <td class=" <?php if(stripos($bb['obs_tecnico'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $bb['obs_tecnico']; ?></td>
            <td class=" <?php if(stripos($bb['direccion'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $bb['direccion']; ?></td>
            <td class=" <?php if(stripos($bb['zona'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $bb['zona']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php }
/* BAJAS */

/* DEVOLCUION */
  $devolcion = mysqli_query($conn, "SELECT DISTINCT * FROM devolucion WHERE tipo LIKE '%$key%' OR sap LIKE '%$key%' OR statuss LIKE '%$key%' OR material LIKE '%$key%' OR sn LIKE '%$key%' OR deposito LIKE '%$key%' OR obs LIKE '%$key%' OR num_remito LIKE '%$key%' OR tecnico LIKE '%$key%' LIMIT 5");
  if (mysqli_num_rows($devolcion) >= 1)
  {
  ?>
  <br>
    <p class="h4 mb-4 text-center">Devolcuiones</p>
    <table class="table table-responsive table-striped table-bordered table-sm">
      <thead class="thead-dark text-center">
        <tr>
          <th>Fecha</th>
          <th>Tecnico</th>
          <th>OT</th>
          <th>Tipo</th>
          <th>Statuss</th>
          <th>SAP</th>
          <th>Material</th>
          <th>SN</th>
          <th>Cantidad</th>
          <th>Deposito</th>
          <th>N° pedido</th>
          <th>Pallet</th>
          <th>Caja</th>
          <th>Estado</th>
          <th>Observaciones</th>          
        </tr>
      </thead>
      <tbody align="center">
        <?php
          $d = mysqli_query($conn, "SELECT DISTINCT * FROM devolucion WHERE tipo LIKE '%$key%' OR sap LIKE '%$key%' OR statuss LIKE '%$key%' OR material LIKE '%$key%' OR sn LIKE '%$key%' OR deposito LIKE '%$key%' OR obs LIKE '%$key%' OR num_remito LIKE '%$key%' OR tecnico LIKE '%$key%' ORDER BY id ASC LIMIT 5");
          while($dd = mysqli_fetch_assoc($d))
          {
        ?>
          <tr>
            <td class=" <?php if(stripos($dd['fecha'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo Fecha3($dd['fecha']); ?></td>
            <td class=" <?php if(stripos($dd['tecnico'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $dd['tecnico']; ?></td>
            <td class=" <?php if(stripos($dd['ot'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $dd['ot']; ?></td>
            <td class=" <?php if(stripos($dd['tipo'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $dd['tipo']; ?></td>
            <td><?php echo $dd['statuss']; ?></td>
            <td class=" <?php if(stripos($dd['sap'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $dd['sap']; ?></td>
            <td class=" <?php if(stripos($dd['material'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $dd['material']; ?></td>
            <td class=" <?php if(stripos($dd['sn'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $dd['sn']; ?></td>
            <td><?php echo $dd['cantidad']; ?></td>
            <td class=" <?php if(stripos($dd['deposito'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $dd['deposito']; ?></td>
            <td class=" <?php if(stripos($dd['num_remito'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $dd['num_remito']; ?></td>
            <td class=" <?php if(stripos($dd['pallet'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $dd['pallet']; ?></td>
            <td class=" <?php if(stripos($dd['num_caja'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $dd['num_caja']; ?></td>
            <td><?php echo $dd['estado']; ?></td>
            <td class=" <?php if(stripos($dd['obs'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $dd['obs']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php }
/* DEVOLCUION */

/* MTTO */
  $mtto = mysqli_query($conn, "SELECT DISTINCT * FROM mtto WHERE ot LIKE '%$key%' OR tecnico LIKE '%$key%' OR direccion LIKE '%$key%' OR zona LIKE '%$key%' OR fecha LIKE '%$key%' OR ont_mac LIKE '%$key%' OR ont_sn LIKE '%$key%' OR stb_mac_uno LIKE '%$key%' OR stb_sn_uno LIKE '%$key%' OR stb_mac_dos LIKE '%$key%' OR stb_sn_dos LIKE '%$key%' OR stb_mac_tres LIKE '%$key%' OR stb_sn_tres LIKE '%$key%' OR ap_uno_mac LIKE '%$key%' OR ap_uno_sn LIKE '%$key%' OR ap_dos_mac LIKE '%$key%' OR ap_dos_sn LIKE '%$key%' OR ap_tres_mac LIKE '%$key%' OR ap_tres_sn LIKE '%$key%' OR id_actividad LIKE '%$key%' OR nim LIKE '%$key%' OR cliente LIKE '%$key%' OR telefono LIKE '%$key%' ORDER BY id ASC LIMIT 5");
  if (mysqli_num_rows($mtto) >= 1)
  {
  ?>
  <br>
    <p class="h4 mb-4 text-center">Carga de mantenimientos</p>
    <table class="table table-responsive table-striped table-bordered table-sm">
      <thead class="thead-dark text-center">
        <tr>
          <th>Tecnico</th>
          <th>OT</th>
          <th>Id actividad</th>
          <th>NIM</th>
          <th>Direccion</th>
          <th>Cliente</th>
          <th>Telefono</th>
          <th>Zona</th>
          <th>Fecha</th>
          <th>ONT MAC</th>
          <th>ONT SN</th>
          <th>STB 1 MAC</th>
          <th>STB 1 SN</th>
          <th>STB 2 MAC</th>
          <th>STB 2 SN</th>
          <th>STB 3 MAC</th>
          <th>STB 3 SN</th>
          <th>AP 1 MAC</th>
          <th>AP 1 SN</th>
          <th>AP 2 MAC</th>
          <th>AP 2 SN</th>
          <th>AP 3 MAC</th>
          <th>AP 3 SN</th>
        </tr>
      </thead>
      <tbody align="center">
        <?php
          $mtt = mysqli_query($conn, "SELECT DISTINCT * FROM mtto WHERE ot LIKE '%$key%' OR tecnico LIKE '%$key%' OR direccion LIKE '%$key%' OR zona LIKE '%$key%' OR fecha LIKE '%$key%' OR ont_mac LIKE '%$key%' OR ont_sn LIKE '%$key%' OR stb_mac_uno LIKE '%$key%' OR stb_sn_uno LIKE '%$key%' OR stb_mac_dos LIKE '%$key%' OR stb_sn_dos LIKE '%$key%' OR stb_mac_tres LIKE '%$key%' OR stb_sn_tres LIKE '%$key%' OR ap_uno_mac LIKE '%$key%' OR ap_uno_sn LIKE '%$key%' OR ap_dos_mac LIKE '%$key%' OR ap_dos_sn LIKE '%$key%' OR ap_tres_mac LIKE '%$key%' OR ap_tres_sn LIKE '%$key%' OR id_actividad LIKE '%$key%' OR nim LIKE '%$key%' OR cliente LIKE '%$key%' OR telefono LIKE '%$key%' ORDER BY id ASC LIMIT 5");
          while($mmtt = mysqli_fetch_assoc($mtt))
          {
        ?>
          <tr>
            <td class=" <?php if(stripos($mmtt['tecnico'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mmtt['tecnico']; ?></td>
            <td class=" <?php if(stripos($mmtt['ot'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mmtt['ot']; ?></td>
            <td class=" <?php if(stripos($mmtt['id_actividad'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mmtt['id_actividad']; ?></td>
            <td class=" <?php if(stripos($mmtt['nim'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mmtt['nim']; ?></td>
            <td class=" <?php if(stripos($mmtt['direccion'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mmtt['direccion']; ?></td>
            <td class=" <?php if(stripos($mmtt['cliente'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mmtt['cliente']; ?></td>
            <td class=" <?php if(stripos($mmtt['telefono'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mmtt['telefono']; ?></td>
            <td class=" <?php if(stripos($mmtt['zona'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mmtt['zona']; ?></td>
            <td class=" <?php if(stripos($mmtt['fecha'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo Fecha3($mmtt['fecha']); ?></td>
            <td class=" <?php if(stripos($mmtt['ont_mac'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mmtt['ont_mac']; ?></td>
            <td class=" <?php if(stripos($mmtt['ont_sn'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mmtt['ont_sn']; ?></td>
            <td class=" <?php if(stripos($mmtt['stb_mac_uno'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mmtt['stb_mac_uno']; ?></td>
            <td class=" <?php if(stripos($mmtt['stb_sn_uno'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mmtt['stb_sn_uno']; ?></td>
            <td class=" <?php if(stripos($mmtt['stb_mac_dos'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mmtt['stb_mac_dos']; ?></td>
            <td class=" <?php if(stripos($mmtt['stb_sn_dos'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mmtt['stb_sn_dos']; ?></td>
            <td class=" <?php if(stripos($mmtt['stb_mac_tres'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mmtt['stb_mac_tres']; ?></td>
            <td class=" <?php if(stripos($mmtt['stb_sn_tres'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mmtt['stb_sn_tres']; ?></td>
            <td class=" <?php if(stripos($mmtt['ap_uno_mac'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mmtt['ap_uno_mac']; ?></td>
            <td class=" <?php if(stripos($mmtt['ap_uno_sn'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mmtt['ap_uno_sn']; ?></td>
            <td class=" <?php if(stripos($mmtt['ap_dos_mac'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mmtt['ap_dos_mac']; ?></td>
            <td class=" <?php if(stripos($mmtt['ap_dos_sn'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mmtt['ap_dos_sn']; ?></td>
            <td class=" <?php if(stripos($mmtt['ap_tres_mac'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mmtt['ap_tres_mac']; ?></td>
            <td class=" <?php if(stripos($mmtt['ap_tres_sn'], $key) !== false){echo 'bg-warning';} ?>" ><?php echo $mmtt['ap_tres_sn']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php }
/* MTTO */
?>
<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>