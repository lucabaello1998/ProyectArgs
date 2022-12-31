<?php
  include("../db.php");
  session_start();
  if(!$_SESSION['nombre'])
  {
  session_destroy();
  header("location: ../index.php");
  exit();
  }
  $tipo_us = $_SESSION['tipo_us'];
  $zona_us = $_SESSION['zona'];
  $nombre_us = $_SESSION['nombre'];
  $apellido_us = $_SESSION['apellido'];
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
<!-- MESSAGES -->
  <?php
    if ($_SESSION['card'] == 1) { ?>
    <div class="position-fixed top-5 right-0 p-3" style="z-index: 5; right: 0rem; top: 3rem; width: 18rem">
      <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000">
        <div class="toast-header border-<?= $_SESSION['color_toast']?> ">
          <?php switch($_SESSION['color_toast'])
            {case 'success': $icono_toast = '<i class="fa-solid fa-circle-check text-success pr-2"></i>';break;
            case 'danger': $icono_toast = '<i class="fa-solid fa-circle-xmark text-danger pr-2"></i>';break;
            case 'warning': $icono_toast = '<i class="fa-solid fa-circle-exclamation text-warning pr-2"></i>';break;}
          ?>
          <strong class="mr-auto"><?php echo $icono_toast; ?> <?= $_SESSION['titulo_toast']?></strong>
          <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="toast-body p-2"><?= $_SESSION['mensaje_toast']?></div>
      </div>
    </div>
    <script>
      $(document).ready(function(){
        $('.toast').toast('show');
      });
    </script>
  <?php $_SESSION['card'] = 0; } ?>
<!-- MESSAGES -->
<?php
  $pallet_ver = mysqli_query($conn, "SELECT *, COUNT(token) as 'cant_remito' FROM devolucion WHERE estado <> 'Devuelto' GROUP BY num_remito order by id desc LIMIT 1");
  while($rof = mysqli_fetch_array($pallet_ver))
  {	
    $pallet_old = $rof['pallet'];
    $num_caja_old = $rof['num_caja'];
    $num_remito_old = $rof['num_remito'];
    $fecha_old = $rof['fecha'];
    $cant_remito = $rof['cant_remito'];
  }
?>
<?php
  $deposito_lz = 'Lomas de Zamora';
  $pallet_ver_lz = mysqli_query($conn, "SELECT *, COUNT(token) as 'cant_remito_lz' FROM devolucion WHERE estado <> 'Devuelto' AND deposito = 'Lomas de Zamora' GROUP BY num_remito order by id desc LIMIT 1");
  while($rof_lz = mysqli_fetch_array($pallet_ver_lz))
  {	
    $pallet_old_lz = $rof_lz['pallet'];
    $num_caja_old_lz = $rof_lz['num_caja'];
    $num_remito_old_lz = $rof_lz['num_remito'];
    $fecha_old_lz = $rof_lz['fecha'];
    $cant_remito_lz = $rof_lz['cant_remito_lz'];
  }
?>
<?php
  $deposito_jls = 'Jose Leon Suarez';
  $pallet_ver_jls = mysqli_query($conn, "SELECT *, COUNT(token) as 'cant_remito_jls' FROM devolucion WHERE estado <> 'Devuelto' AND deposito = 'Jose Leon Suarez' GROUP BY num_remito order by id desc LIMIT 1");
  while($rof_jls = mysqli_fetch_array($pallet_ver_jls))
  {	
    $pallet_old_jls = $rof_jls['pallet'];
    $num_caja_old_jls = $rof_jls['num_caja'];
    $num_remito_old_jls = $rof_jls['num_remito'];
    $fecha_old_jls = $rof_jls['fecha'];
    $cant_remito_jls = $rof_jls['cant_remito_jls'];
  }
?>
<?php
  $deposito_sn = 'San Nicolas';
  $pallet_ver_sn = mysqli_query($conn, "SELECT *, COUNT(token) as 'cant_remito_sn' FROM devolucion WHERE estado <> 'Devuelto' AND deposito = 'San Nicolas' GROUP BY num_remito order by id desc LIMIT 1");
  while($rof_sn = mysqli_fetch_array($pallet_ver_sn))
  {	
    $pallet_old_sn = $rof_sn['pallet'];
    $num_caja_old_sn = $rof_sn['num_caja'];
    $num_remito_old_sn = $rof_sn['num_remito'];
    $fecha_old_sn = $rof_sn['fecha'];
    $cant_remito_sn = $rof_sn['cant_remito_sn'];
  }
?>
<style>
  .sugerido_sap_lz
    {
      box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2);
      height: auto;
      position: absolute;
      z-index: 11;
      top: 2.9rem !important;
      width: 100% !important;
    }

  .sugerido_sap_lz .suggest-sap_lz
    {
      background-color: #ffffff;
      border-top: 1px solid #d6d4d4;
      cursor: pointer;
      padding: 5px;
      width: 100%;
      float: left;
    }
  .sugerido_sap_lz .suggest-sap_lz:hover
    {
      background-color: #bfe9c5;
    }
    
    .sugerido_mat_lz
    {
      box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2);
      height: auto;
      position: absolute;
      z-index: 11;
      top: 6.3rem ;
      width: 100% ;
    }

  .sugerido_mat_lz .suggest-mat_lz
    {
      background-color: #ffffff;
      border-top: 1px solid #d6d4d4;
      cursor: pointer;
      padding: 5px;
      width: 100%;
      float: left;
    }
  .sugerido_mat_lz .suggest-mat_lz:hover
    {
      background-color: #bfe9c5;
    } 
</style>
<style>
  .sugerido_sap_jls
    {
      box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2);
      height: auto;
      position: absolute;
      z-index: 11;
      top: 2.9rem !important;
      width: 100% !important;
    }

  .sugerido_sap_jls .suggest-sap_jls
    {
      background-color: #ffffff;
      border-top: 1px solid #d6d4d4;
      cursor: pointer;
      padding: 5px;
      width: 100%;
      float: left;
    }
  .sugerido_sap_jls .suggest-sap_jls:hover
    {
      background-color: #bfe9c5;
    }
    
    .sugerido_mat_jls
    {
      box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2);
      height: auto;
      position: absolute;
      z-index: 11;
      top: 6.3rem ;
      width: 100% ;
    }

  .sugerido_mat_jls .suggest-mat_jls
    {
      background-color: #ffffff;
      border-top: 1px solid #d6d4d4;
      cursor: pointer;
      padding: 5px;
      width: 100%;
      float: left;
    }
  .sugerido_mat_jls .suggest-mat_jls:hover
    {
      background-color: #bfe9c5;
    } 
</style>
<style>
  .sugerido_sap_sn
    {
      box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2);
      height: auto;
      position: absolute;
      z-index: 11;
      top: 2.9rem !important;
      width: 100% !important;
    }

  .sugerido_sap_sn .suggest-sap_sn
    {
      background-color: #ffffff;
      border-top: 1px solid #d6d4d4;
      cursor: pointer;
      padding: 5px;
      width: 100%;
      float: left;
    }
  .sugerido_sap_sn .suggest-sap_sn:hover
    {
      background-color: #bfe9c5;
    }
    
    .sugerido_mat_sn
    {
      box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2);
      height: auto;
      position: absolute;
      z-index: 11;
      top: 6.3rem ;
      width: 100% ;
    }

  .sugerido_mat_sn .suggest-mat_sn
    {
      background-color: #ffffff;
      border-top: 1px solid #d6d4d4;
      cursor: pointer;
      padding: 5px;
      width: 100%;
      float: left;
    }
  .sugerido_mat_sn .suggest-mat_sn:hover
    {
      background-color: #bfe9c5;
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
          <input type="hidden" name="link" value="../Basico/devolucion.php">
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
          <input type="hidden" name="link" value="../Basico/devolucion.php">
          <button type="submit" name="mas" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Mes siguiente">
            <i class="fa-solid fa-caret-right"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
<!-- FECHA -->
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

    <?php
      $cant_ver = mysqli_query($conn, "SELECT * FROM devolucion WHERE estado <> 'Devuelto' GROUP BY num_remito order by id desc");
      while($rocc = mysqli_fetch_array($cant_ver))
      {	
        $num_remito_old_old = $rocc['num_remito'];
    ?>
      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <a class="btn btn-primary p-2 m-2" role="button" href="../Editar/edit_devolucion.php?remito=<?php echo $num_remito_old_old; ?>">Datos generales (<?php echo $num_remito_old_old; ?>)</a>
        </div>
      </div>
    <?php } ?>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <div class="row m-0 p-0">

          <?php if($zona_us == 'Lomas de Zamora' || $zona_us == 'Todo') { ?>
            <div class="col">

              <div class="card card-body">
                <form action="../Guardar/save_devolucion.php" method="POST">
                  <p class="h4 mb-4 text-center">Devolucion Lomas de Zamora</p>
                  <div class="form-row">
                    <div class="form-group col-md col-12">
                      <label>Tecnico</label >
                      <select type="text" name="tecnico" class="form-control" required>
                        <option selected value="" disabled>Tecnicos...</option>
                        <?php
                          $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?>   
                          <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                        <?php endforeach;
                          $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE tipo='Tecnico' AND activo ='NO' ORDER BY tecnico asc");
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?>   
                          <option class="text-danger" value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                    
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group col-md col-12">
                      <label>OT</label >
                      <input type="number" name="ot" class="form-control">
                    </div>

                      <input hidden type="text" name="deposito" value="<?php echo $deposito_lz; ?>">

                    <div class="form-group col-md col-12">
                      <label>Fecha</label >
                      <input type="date" name="fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-3 col-12">
                      <label>Estado</label >
                      <select type="text" name="status" class="form-control" required>
                        <option selected value="" disabled>Estado...</option>
                        <option value="Nuevo sin uso">Nuevo sin uso</option>
                      </select>
                    </div>
                    <div class="form-group col-md-3 col-12">
                      <label>Num remito</label >
                      <input type="number" name="num_remito" min="1" value="<?php echo $num_remito_old_lz; ?>" class="form-control" required>
                    </div>
                    <div class="form-group col-md-3 col-12">
                      <label>Pallet</label >
                      <input type="number" name="pallet" min="1" value="<?php echo $pallet_old_lz; ?>" class="form-control" required>
                    </div>
                    <div class="form-group col-md-3 col-12">
                      <label>Num caja</label >
                      <input type="number" name="num_caja" min="1" value="<?php echo $num_caja_old_lz; ?>" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-3 col-12">
                      <label>Tipo</label >
                      <select type="text" name="tipo" class="form-control" required>
                        <option selected value="" disabled>Tipo...</option>
                        <option value="Material sin uso">Material sin uso</option>
                        <option value="Desinstalacion o desmonte">Desinstalacion o desmonte</option>
                        <option value="Material reparado">Material reparado</option>
                      </select>
                    </div>
                    <div class="form-group col-md-3 col-12">
                      <div class="row p-2">
                        <input class="form-control selec_sap_lz" type="text" name="sap" placeholder="SAP">
                        <div class="sugerido_sap_lz"></div>
                      </div>
                      <div class="row p-2">
                        <input class="form-control selec_mat_lz" type="text" name="material" placeholder="Material">
                        <div class="sugerido_mat_lz"></div>
                      </div>
                    </div>
                    <div class="form-group col-md-3 col-12">
                      <label>Num serie</label >
                      <input type="text" name="sn" class="form-control sn">
                    </div>
                    <div class="form-group col-md-3 col-12">
                      <label>Cantidad</label>
                      <input type="number" min="1" name="cantidad" class="form-control" value="1" required>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-12">
                      <label>Observaciones</label >
                      <textarea type="text" name="obs" class="form-control"></textarea>
                    </div>
                  </div>
                  <input type="submit" name="devolucion" class="btn btn-success btn-block" value="Guardar devolucion">
                </form>
              </div>

            </div>
          <?php } ?>
          <?php if($zona_us == 'Jose Leon Suarez' || $zona_us == 'Todo') { ?>
            <div class="col">

              <div class="card card-body">
                <form action="../Guardar/save_devolucion.php" method="POST">
                  <p class="h4 mb-4 text-center">Devolucion Jose Leon Suarez</p>
                  <div class="form-row">
                    <div class="form-group col-md col-12">
                      <label>Tecnico</label >
                      <select type="text" name="tecnico" class="form-control" required>
                        <option selected value="" disabled>Tecnicos...</option>
                        <?php
                          $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?>   
                          <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                        <?php endforeach;
                          $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE tipo='Tecnico' AND activo ='NO' ORDER BY tecnico asc");
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?>   
                          <option class="text-danger" value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                    
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group col-md col-12">
                      <label>OT</label >
                      <input type="number" name="ot" class="form-control">
                    </div>

                      <input hidden type="text" name="deposito" value="<?php echo $deposito_jls; ?>">

                    <div class="form-group col-md col-12">
                      <label>Fecha</label >
                      <input type="date" name="fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-3 col-12">
                      <label>Estado</label >
                      <select type="text" name="status" class="form-control" required>
                        <option selected value="" disabled>Estado...</option>
                        <option value="Nuevo sin uso">Nuevo sin uso</option>
                      </select>
                    </div>
                    <div class="form-group col-md-3 col-12">
                      <label>Num remito</label >
                      <input type="number" name="num_remito" min="1" value="<?php echo $num_remito_old_jls; ?>" class="form-control" required>
                    </div>
                    <div class="form-group col-md-3 col-12">
                      <label>Pallet</label >
                      <input type="number" name="pallet" min="1" value="<?php echo $pallet_old_jls; ?>" class="form-control" required>
                    </div>
                    <div class="form-group col-md-3 col-12">
                      <label>Num caja</label >
                      <input type="number" name="num_caja" min="1" value="<?php echo $num_caja_old_jls; ?>" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-3 col-12">
                      <label>Tipo</label >
                      <select type="text" name="tipo" class="form-control" required>
                        <option selected value="" disabled>Tipo...</option>
                        <option value="Material sin uso">Material sin uso</option>
                        <option value="Desinstalacion o desmonte">Desinstalacion o desmonte</option>
                        <option value="Material reparado">Material reparado</option>
                      </select>
                    </div>
                    <div class="form-group col-md-3 col-12">
                      <div class="row p-2">
                        <input class="form-control selec_sap_jls" type="text" name="sap" placeholder="SAP">
                        <div class="sugerido_sap_jls"></div>
                      </div>
                      <div class="row p-2">
                        <input class="form-control selec_mat_jls" type="text" name="material" placeholder="Material">
                        <div class="sugerido_mat_jls"></div>
                      </div>
                    </div>
                    <div class="form-group col-md-3 col-12">
                      <label>Num serie</label >
                      <input type="text" name="sn" class="form-control sn">
                    </div>
                    <div class="form-group col-md-3 col-12">
                      <label>Cantidad</label>
                      <input type="number" min="1" name="cantidad" class="form-control" value="1" required>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-12">
                      <label>Observaciones</label >
                      <textarea type="text" name="obs" class="form-control"></textarea>
                    </div>
                  </div>
                  <input type="submit" name="devolucion" class="btn btn-success btn-block" value="Guardar devolucion">
                </form>
              </div>

            </div>
          <?php } ?>
          <?php if($zona_us == 'San Nicolas' || $zona_us == 'Todo') { ?>
            <div class="col">

              <div class="card card-body">
                <form action="../Guardar/save_devolucion.php" method="POST">
                  <p class="h4 mb-4 text-center">Devolucion San Nicolas</p>
                  <div class="form-row">
                    <div class="form-group col-md col-12">
                      <label>Tecnico</label >
                      <select type="text" name="tecnico" class="form-control" required>
                        <option selected value="" disabled>Tecnicos...</option>
                        <?php
                          $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?>   
                          <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                        <?php endforeach;
                          $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE tipo='Tecnico' AND activo ='NO' ORDER BY tecnico asc");
                        ?>
                        <?php foreach ($ejecutar as $opciones): ?>   
                          <option class="text-danger" value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                    
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group col-md col-12">
                      <label>OT</label >
                      <input type="number" name="ot" class="form-control">
                    </div>

                      <input hidden type="text" name="deposito" value="<?php echo $deposito_sn; ?>">

                    <div class="form-group col-md col-12">
                      <label>Fecha</label >
                      <input type="date" name="fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-3 col-12">
                      <label>Estado</label >
                      <select type="text" name="status" class="form-control" required>
                        <option selected value="" disabled>Estado...</option>
                        <option value="Nuevo sin uso">Nuevo sin uso</option>
                      </select>
                    </div>
                    <div class="form-group col-md-3 col-12">
                      <label>Num remito</label >
                      <input type="number" name="num_remito" min="1" value="<?php echo $num_remito_old_sn; ?>" class="form-control" required>
                    </div>
                    <div class="form-group col-md-3 col-12">
                      <label>Pallet</label >
                      <input type="number" name="pallet" min="1" value="<?php echo $pallet_old_sn; ?>" class="form-control" required>
                    </div>
                    <div class="form-group col-md-3 col-12">
                      <label>Num caja</label >
                      <input type="number" name="num_caja" min="1" value="<?php echo $num_caja_old_sn; ?>" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-3 col-12">
                      <label>Tipo</label >
                      <select type="text" name="tipo" class="form-control" required>
                        <option selected value="" disabled>Tipo...</option>
                        <option value="Material sin uso">Material sin uso</option>
                        <option value="Desinstalacion o desmonte">Desinstalacion o desmonte</option>
                        <option value="Material reparado">Material reparado</option>
                      </select>
                    </div>
                    <div class="form-group col-md-3 col-12">
                      <div class="row p-2">
                        <input class="form-control selec_sap_sn" type="text" name="sap" placeholder="SAP">
                        <div class="sugerido_sap_sn"></div>
                      </div>
                      <div class="row p-2">
                        <input class="form-control selec_mat_sn" type="text" name="material" placeholder="Material">
                        <div class="sugerido_mat_sn"></div>
                      </div>
                    </div>
                    <div class="form-group col-md-3 col-12">
                      <label>Num serie</label >
                      <input type="text" name="sn" class="form-control sn">
                    </div>
                    <div class="form-group col-md-3 col-12">
                      <label>Cantidad</label>
                      <input type="number" min="1" name="cantidad" class="form-control" value="1" required>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-12">
                      <label>Observaciones</label >
                      <textarea type="text" name="obs" class="form-control"></textarea>
                    </div>
                  </div>
                  <input type="submit" name="devolucion" class="btn btn-success btn-block" value="Guardar devolucion">
                </form>
              </div>

            </div>
          <?php } ?>

          </div>
        </div>
      </div>
      <br>

      <?php if($nombre_us == 'Damian' && $apellido_us == 'Duarte') { ?>
        <div class="row justify-content-center p-1">
          <div class="col-5 col-sm-5 p-1">
            <div class="row justify-content-center p-1 pr-3">
              <a class="btn btn-success p-2 m-2" role="button" id="download_xls" download="<?php echo $num_remito_old .'_' .$fecha_old; ?>.xls" href="#"><i class="fa-solid fa-file-excel"></i></a>
              <a class="btn btn-info p-2 m-2" role="button" id="download_csv" download="<?php echo $num_remito_old .'_' .$fecha_old; ?>.csv" href="#"><i class="fa-solid fa-file-csv"></i></a>
              <a class="btn btn-success p-2 m-2" role="button" id="download_xlsx" href="#"><i class="fa-regular fa-file-excel"></i></a>
            </div>
          </div>
        </div>
      <?php } ?>
      
      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Ultimas devoluciones en proceso</p>
          <table class="table table-responsive table-striped table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>
                <th>Acciones</th>
                <th>Tecnico</th>
                <th>OT</th>
                <th>Tipo</th>
                <th>SAP</th>
                <th>Material</th>
                <th>SN</th>
                <th>Cantidad</th>
                <th>Caja</th>
                <th>Pallet</th>
                <th>Fecha</th>
                <th>Deposito</th>
                <th>Observaciones</th>
                <?php if($tipo_us == 'Despacho' || $tipo_us == 'Administrador') {?>
                  <th>Quien</th>
                  <th>Cuando</th>
                <?php } ?>
              </tr>
            </thead>
            <tbody align="center">
              <?php
                switch($zona_us)
                {
                  case 'Lomas de Zamora': $pppp = mysqli_query($conn, "SELECT * FROM devolucion WHERE estado = 'En deposito' AND deposito = 'Lomas de Zamora' GROUP BY num_remito ORDER BY id desc");
                  break;
                  case 'Jose Leon Suarez': $pppp = mysqli_query($conn, "SELECT * FROM devolucion WHERE estado = 'En deposito' AND deposito = 'Jose Leon Suarez' GROUP BY num_remito ORDER BY id desc");
                  break;
                  case 'San Nicolas': $pppp = mysqli_query($conn, "SELECT * FROM devolucion WHERE estado = 'En deposito' AND deposito = 'San Nicolas' GROUP BY num_remito ORDER BY id desc");
                  break;
                  case 'Todo': $pppp = mysqli_query($conn, "SELECT * FROM devolucion WHERE estado = 'En deposito' GROUP BY num_remito ORDER BY id desc");
                  break;
                }
                while($rowpp = mysqli_fetch_assoc($pppp))
                {
                  $remito = $rowpp['num_remito'];
                  $estado_dev = $rowpp['estado'];
                  $fecha_dev = $rowpp['fecha'];
                  $fecha_retiro_dev = $rowpp['fecha_retiro'];
              ?>
                <tr>
                  <td class="bg-dark text-light" colspan="17">
                    <div class="row justify-content-between p-0">
                      <div class="col-auto align-self-center">
                        Remito <?php echo ' ' .$remito .' ('; if($estado_dev == 'En deposito') { echo '<a role="button" class="text-light" href="../Guardar/save_devolucion.php?devolver=' .$num_remito_old .'">'; echo $estado_dev .'</a>)';}else{ echo $estado_dev .' el ' .Fecha7($fecha_retiro_dev) .')'; } ; ?>
                      </div>
                      <div class="col-auto align-self-center">
                        <a class="btn btn-success btn-sm p-1 m-0" role="button" id="download_xls_<?php echo $remito; ?>" download="<?php echo $remito .'_' .$fecha_dev; ?>.xls" href="#">xls</a>
                        <a class="btn btn-info btn-sm p-1 m-0" role="button" id="download_csv_<?php echo $remito; ?>" download="<?php echo $remito .'_' .$fecha_dev; ?>.csv" href="#">csv</a>
                        <a class="btn btn-success btn-sm p-1 m-0" role="button" id="download_xlsx_<?php echo $remito; ?>" href="#">xlsx</a>
                      </div>
                    </div>
                  </td>
                </tr>

                  <?php
                    switch($zona_us)
                    {
                      case 'Lomas de Zamora': $originalp = mysqli_query($conn, "SELECT * FROM devolucion WHERE num_remito = '$remito' AND estado = 'En deposito' AND deposito = 'Lomas de Zamora' ORDER BY id desc");
                      break;
                      case 'Jose Leon Suarez': $originalp = mysqli_query($conn, "SELECT * FROM devolucion WHERE num_remito = '$remito' AND estado = 'En deposito' AND deposito = 'Jose Leon Suarez' ORDER BY id desc");
                      break;
                      case 'San Nicolas': $originalp = mysqli_query($conn, "SELECT * FROM devolucion WHERE num_remito = '$remito' AND estado = 'En deposito' AND deposito = 'San Nicolas' ORDER BY id desc");
                      break;
                      case 'Todo': $originalp = mysqli_query($conn, "SELECT * FROM devolucion WHERE num_remito = '$remito' AND estado = 'En deposito' ORDER BY id desc");
                      break;
                    }
                    while($rowp = mysqli_fetch_assoc($originalp))
                    {
                  ?>
                    <tr>
                      <td>
                        <?php if($rowp['estado'] == 'En deposito') { ?>
                          <a href="../Editar/edit_devolucion_unit.php?token=<?php echo $rowp['token']?>">
                            <i class="fas fa-pen p-2"></i>
                          </a>
                          <a href="../Borrar/delete_devolucion_unit.php?token=<?php echo $rowp['token']?>">
                            <i class="far fa-trash-alt p-2"></i>
                          </a>
                        <?php } else {echo '-';} ?>
                      </td>
                      <td><?php echo $rowp['tecnico']; ?></td>
                      <td><?php echo $rowp['ot']; ?></td>
                      <td><?php echo $rowp['tipo']; ?></td>
                      <td><?php echo $rowp['sap']; ?></td>
                      <td><?php echo $rowp['material']; ?></td>
                      <td><?php echo $rowp['sn']; ?></td>
                      <td><?php echo $rowp['cantidad']; ?></td>
                      <td><?php echo $rowp['num_caja']; ?></td>
                      <td><?php echo $rowp['pallet']; ?></td>
                      <td><?php echo Fecha7($rowp['fecha']); ?></td>
                      <td><?php echo $rowp['deposito']; ?></td>
                      <td  data-toggle="tooltip" data-placement="top" title="<?php echo $rowp['obs']; ?>"><?php echo limitar_cadena($rowp['obs'], 50); ?></td>
                      <?php if($tipo_us == 'Despacho' || $tipo_us == 'Administrador') {?>
                        <td><?php echo $rowp['quien']; ?></td>
                        <td><?php if($rowp['cuando'] == '0000-00-00 00:00:00'){echo '-';}else{echo Fecha12($rowp['cuando']);}; ?></td> 
                      <?php } ?>
                    </tr>
                <?php } ?>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

      <br>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Ultimas devoluciones cargadas</p>
          <table class="table table-responsive table-striped table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>
                <th>Acciones</th>
                <th>Tecnico</th>
                <th>OT</th>
                <th>Tipo</th>
                <th>SAP</th>
                <th>Material</th>
                <th>SN</th>
                <th>Cantidad</th>
                <th>Caja</th>
                <th>Pallet</th>
                <th>Fecha</th>
                <th>Deposito</th>
                <th>Observaciones</th>
                <?php if($tipo_us == 'Despacho' || $tipo_us == 'Administrador') {?>
                  <th>Quien</th>
                  <th>Cuando</th>
                <?php } ?>
              </tr>
            </thead>
            <tbody align="center">
              <?php
                switch($zona_us)
                {
                  case 'Lomas de Zamora': $ppp = mysqli_query($conn, "SELECT * FROM devolucion WHERE estado = 'Devuelto' AND deposito = 'Lomas de Zamora' AND fecha_retiro LIKE '$mes%' GROUP BY num_remito ORDER BY id desc");
                  break;
                  case 'Jose Leon Suarez': $ppp = mysqli_query($conn, "SELECT * FROM devolucion WHERE estado = 'Devuelto' AND deposito = 'Jose Leon Suarez' AND fecha_retiro LIKE '$mes%' GROUP BY num_remito ORDER BY id desc");
                  break;
                  case 'San Nicolas': $ppp = mysqli_query($conn, "SELECT * FROM devolucion WHERE estado = 'Devuelto' AND deposito = 'San Nicolas' AND fecha_retiro LIKE '$mes%' GROUP BY num_remito ORDER BY id desc");
                  break;
                  case 'Todo': $ppp = mysqli_query($conn, "SELECT * FROM devolucion WHERE estado = 'Devuelto' AND fecha_retiro LIKE '$mes%' GROUP BY num_remito ORDER BY id desc");
                  break;
                }
                while($rowp = mysqli_fetch_assoc($ppp))
                {
                  $remito = $rowp['num_remito'];
                  $estado_dev = $rowp['estado'];
                  $fecha_dev = $rowp['fecha'];
                  $fecha_retiro_dev = $rowp['fecha_retiro'];
              ?>
                <tr>
                  <td class="bg-dark text-light" colspan="17">
                    <div class="row justify-content-between p-0">
                      <div class="col-auto align-self-center">
                        Remito <?php echo ' ' .$remito .' ('; if($estado_dev == 'En deposito') { echo '<a role="button" class="text-light" href="../Guardar/save_devolucion.php?devolver=' .$num_remito_old .'">'; echo $estado_dev .'</a>)';}else{ echo $estado_dev .' el ' .Fecha7($fecha_retiro_dev) .')'; } ; ?>
                      </div>
                      <div class="col-auto align-self-center">
                        <i style="cursor: pointer;" data-prod-cat="<?php echo $remito;?>" class="fa-solid fa-caret-down toggler"></i>
                      </div>
                      <div class="col-auto align-self-center">
                        <a class="btn btn-success btn-sm p-1 m-0" role="button" id="download_xls_<?php echo $remito; ?>" download="<?php echo $remito .'_' .$fecha_dev; ?>.xls" href="#">xls</a>
                        <a class="btn btn-info btn-sm p-1 m-0" role="button" id="download_csv_<?php echo $remito; ?>" download="<?php echo $remito .'_' .$fecha_dev; ?>.csv" href="#">csv</a>
                        <a class="btn btn-success btn-sm p-1 m-0" role="button" id="download_xlsx_<?php echo $remito; ?>" href="#">xlsx</a>
                      </div>
                    </div>
                  </td>
                </tr>

                  <?php
                    switch($zona_us)
                    {
                      case 'Lomas de Zamora': $original = mysqli_query($conn, "SELECT * FROM devolucion WHERE num_remito = '$remito' AND estado = 'Devuelto' AND deposito = 'Lomas de Zamora' AND fecha_retiro LIKE '$mes%' ORDER BY id desc");
                      break;
                      case 'Jose Leon Suarez': $original = mysqli_query($conn, "SELECT * FROM devolucion WHERE num_remito = '$remito' AND estado = 'Devuelto' AND deposito = 'Jose Leon Suarez' AND fecha_retiro LIKE '$mes%' ORDER BY id desc");
                      break;
                      case 'San Nicolas': $original = mysqli_query($conn, "SELECT * FROM devolucion WHERE num_remito = '$remito' AND estado = 'Devuelto' AND deposito = 'San Nicolas' AND fecha_retiro LIKE '$mes%' ORDER BY id desc");
                      break;
                      case 'Todo': $original = mysqli_query($conn, "SELECT * FROM devolucion WHERE num_remito = '$remito' AND estado = 'Devuelto' AND fecha_retiro LIKE '$mes%' ORDER BY id desc");
                      break;
                    }
                    while($row = mysqli_fetch_assoc($original))
                    {
                  ?>
                    <tr class="cat<?php echo $row['num_remito'];?>" style="display:none">
                      <td>
                        <?php if($row['estado'] == 'En deposito') { ?>
                          <a href="../Editar/edit_devolucion_unit.php?token=<?php echo $row['token']?>">
                            <i class="fas fa-pen p-2"></i>
                          </a>
                          <a href="../Borrar/delete_devolucion_unit.php?token=<?php echo $row['token']?>">
                            <i class="far fa-trash-alt p-2"></i>
                          </a>
                        <?php } else {echo '-';} ?>
                      </td>
                      <td><?php echo $row['tecnico']; ?></td>
                      <td><?php echo $row['ot']; ?></td>
                      <td><?php echo $row['tipo']; ?></td>
                      <td><?php echo $row['sap']; ?></td>
                      <td><?php echo $row['material']; ?></td>
                      <td><?php echo $row['sn']; ?></td>
                      <td><?php echo $row['cantidad']; ?></td>
                      <td><?php echo $row['num_caja']; ?></td>
                      <td><?php echo $row['pallet']; ?></td>
                      <td><?php echo Fecha7($row['fecha']); ?></td>
                      <td><?php echo $row['deposito']; ?></td>
                      <td  data-toggle="tooltip" data-placement="top" title="<?php echo $row['obs']; ?>"><?php echo limitar_cadena($row['obs'], 50); ?></td>
                      <?php if($tipo_us == 'Despacho' || $tipo_us == 'Administrador') {?>
                        <td><?php echo $row['quien']; ?></td>
                        <td><?php if($row['cuando'] == '0000-00-00 00:00:00'){echo '-';}else{echo Fecha12($row['cuando']);}; ?></td> 
                      <?php } ?>
                    </tr>
                <?php } ?>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Ver planilla en proceso</a>
        </div>
      </div>

      <div class="collapse multi-collapse" id="multiCollapseExample1">
        <div class="row justify-content-center p-1">
          <div class="col-auto">
            <p class="h4 mb-4 text-center">Devolucion en proceso</p>
            <table id="datatable">
              <thead>
                <tr>
                  <th style="background-color:yellow; text-align: center;border: 1px black solid;">Tipo de devolución: 1-Devolución material sin uso 2-Desinstalación o Desmonte material(fallado 3-Devolución de material reparado)</th>
                  <th style="background-color:yellow; text-align: center;border: 1px black solid;">N° Remito</th>
                  <th style="background-color:yellow; text-align: center;border: 1px black solid;">Status</th>
                  <th style="background-color:yellow; text-align: center;border: 1px black solid;">Nombre de contratista que realiza devolcuión</th>
                  <th style="background-color:yellow; text-align: center;border: 1px black solid;">Referente ingenieria</th>
                  <th style="background-color:yellow; text-align: center;border: 1px black solid;">Centro</th>
                  <th style="background-color:yellow; text-align: center;border: 1px black solid;">Alm contratista</th>
                  <th style="background-color:yellow; text-align: center;border: 1px black solid;">Centro destino</th>
                  <th style="background-color:yellow; text-align: center;border: 1px black solid;">Almacen destino</th>
                  <th style="background-color:yellow; text-align: center;border: 1px black solid;">Operatoria</th>
                  <th style="background-color:yellow; text-align: center;border: 1px black solid;">N° Pallet</th>
                  <th style="background-color:yellow; text-align: center;border: 1px black solid;">Material SAP</th>
                  <th style="background-color:yellow; text-align: center;border: 1px black solid;">S/N</th>
                  <th style="background-color:yellow; text-align: center;border: 1px black solid;">Cantidad</th>
                  <th style="background-color:yellow; text-align: center;border: 1px black solid;">N° Caja</th>
                  <th style="background-color:yellow; text-align: center;border: 1px black solid;">Descripción</th>
                  <th style="background-color:yellow; text-align: center;border: 1px black solid;">Sitio</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    switch($zona_us)
                    {
                      case 'Lomas de Zamora': $ghost = mysqli_query($conn, "SELECT * FROM devolucion WHERE estado = 'En deposito' AND deposito = 'Lomas de Zamora' ORDER BY id desc");
                      break;
                      case 'Jose Leon Suarez': $ghost = mysqli_query($conn, "SELECT * FROM devolucion WHERE estado = 'En deposito' AND deposito = 'Jose Leon Suarez' ORDER BY id desc");
                      break;
                      case 'San Nicolas': $ghost = mysqli_query($conn, "SELECT * FROM devolucion WHERE estado = 'En deposito' AND deposito = 'San Nicolas' ORDER BY id desc");
                      break;
                      case 'Todo': $ghost = mysqli_query($conn, "SELECT * FROM devolucion WHERE estado = 'En deposito' ORDER BY id desc");
                      break;
                    }
                    while($rog = mysqli_fetch_assoc($ghost))
                    {
                  ?>
                    <tr>
                      <td style="text-align: center;border: 0.5px black solid;">
                        <?php switch($rog['tipo'])
                          {
                            case 'Material sin uso' : echo '1-Devolución material sin uso';
                            break;
                            case 'Desinstalacion o desmonte' : echo '2-Desinstalación o desmonte material (fallado)';
                            break;
                            case 'Material reparado' : echo '3-Devolución de material reparado';
                            break;
                          }
                        ?></td>
                      <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog['num_remito']; ?></td>
                      <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog['statuss']; ?></td>
                      <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog['contratista']; ?></td>
                      <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog['referente']; ?></td>
                      <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog['centro']; ?></td>
                      <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog['almacen']; ?></td>
                      <td style="text-align: center;border: 0.5px black solid;"></td>
                      <td style="text-align: center;border: 0.5px black solid;"></td>
                      <td style="text-align: center;border: 0.5px black solid;"></td>
                      <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog['pallet']; ?></td>
                      <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog['sap']; ?></td>
                      <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog['sn']; ?></td>
                      <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog['cantidad']; ?></td>
                      <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog['num_caja']; ?></td>
                      <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog['material']; ?></td>
                      <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog['sitio']; ?></td>
                    </tr>
                  <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<?php
  $pex = mysqli_query($conn, "SELECT * FROM devolucion GROUP BY num_remito ORDER BY id desc");
  while($rowex = mysqli_fetch_assoc($pex))
  {
    $remito_export = $rowex['num_remito'];
    $fecha_dev_export = $rowex['fecha'];
?>
<!-- TABLAS PARA EXPORTACION -->
  <table hidden id="data<?php echo $remito_export; ?>">
    <thead hidden>
      <tr hidden>
        <th style="background-color:yellow; text-align: center;border: 1px black solid;">Tipo de devolución: 1-Devolución material sin uso 2-Desinstalación o Desmonte material(fallado 3-Devolución de material reparado)</th>
        <th style="background-color:yellow; text-align: center;border: 1px black solid;">N° Remito</th>
        <th style="background-color:yellow; text-align: center;border: 1px black solid;">Status</th>
        <th style="background-color:yellow; text-align: center;border: 1px black solid;">Nombre de contratista que realiza devolcuión</th>
        <th style="background-color:yellow; text-align: center;border: 1px black solid;">Referente ingenieria</th>
        <th style="background-color:yellow; text-align: center;border: 1px black solid;">Centro</th>
        <th style="background-color:yellow; text-align: center;border: 1px black solid;">Alm contratista</th>
        <th style="background-color:yellow; text-align: center;border: 1px black solid;">Centro destino</th>
        <th style="background-color:yellow; text-align: center;border: 1px black solid;">Almacen destino</th>
        <th style="background-color:yellow; text-align: center;border: 1px black solid;">Operatoria</th>
        <th style="background-color:yellow; text-align: center;border: 1px black solid;">N° Pallet</th>
        <th style="background-color:yellow; text-align: center;border: 1px black solid;">Material SAP</th>
        <th style="background-color:yellow; text-align: center;border: 1px black solid;">S/N</th>
        <th style="background-color:yellow; text-align: center;border: 1px black solid;">Cantidad</th>
        <th style="background-color:yellow; text-align: center;border: 1px black solid;">N° Caja</th>
        <th style="background-color:yellow; text-align: center;border: 1px black solid;">Descripción</th>
        <th style="background-color:yellow; text-align: center;border: 1px black solid;">Sitio</th>
      </tr>
    </thead>
    <tbody hidden>
      <?php
          $ghost_hidden = mysqli_query($conn, "SELECT * FROM devolucion WHERE num_remito = '$remito_export' ORDER BY id desc");
          while($rog_h = mysqli_fetch_assoc($ghost_hidden))
          {
        ?>
          <tr hidden>
            <td style="text-align: center;border: 0.5px black solid;">
              <?php switch($rog_h['tipo'])
                {
                  case 'Material sin uso' : echo '1-Devolución material sin uso';
                  break;
                  case 'Desinstalacion o desmonte' : echo '2-Desinstalación o desmonte material (fallado)';
                  break;
                  case 'Material reparado' : echo '3-Devolución de material reparado';
                  break;
                }
              ?></td>
            <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog_h['num_remito']; ?></td>
            <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog_h['statuss']; ?></td>
            <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog_h['contratista']; ?></td>
            <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog_h['referente']; ?></td>
            <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog_h['centro']; ?></td>
            <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog_h['almacen']; ?></td>
            <td style="text-align: center;border: 0.5px black solid;"></td>
            <td style="text-align: center;border: 0.5px black solid;"></td>
            <td style="text-align: center;border: 0.5px black solid;"></td>
            <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog_h['pallet']; ?></td>
            <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog_h['sap']; ?></td>
            <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog_h['sn']; ?></td>
            <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog_h['cantidad']; ?></td>
            <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog_h['num_caja']; ?></td>
            <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog_h['material']; ?></td>
            <td style="text-align: center;border: 0.5px black solid;"><?php echo $rog_h['sitio']; ?></td>
          </tr>
        <?php } ?>
    </tbody>
  </table>
  <script>
      let download_xls_<?php echo $remito_export; ?> = document.querySelector("#download_xls_<?php echo $remito_export; ?>")
      download_xls_<?php echo $remito_export; ?>.addEventListener("click", ()=>{
          ExcellentExport.excel(download_xls_<?php echo $remito_export; ?>, 'data<?php echo $remito_export; ?>')
      })

      let download_csv_<?php echo $remito_export; ?> = document.querySelector("#download_csv_<?php echo $remito_export; ?>")
      download_csv_<?php echo $remito_export; ?>.addEventListener("click", ()=>{
          ExcellentExport.csv(download_csv_<?php echo $remito_export; ?>, 'data<?php echo $remito_export; ?>');
      })

      let download_xlsx_<?php echo $remito_export; ?> = document.querySelector("#download_xlsx_<?php echo $remito_export; ?>")
      download_xlsx_<?php echo $remito_export; ?>.addEventListener("click", ()=>{
          ExcellentExport.convert({ anchor: download_xlsx_<?php echo $remito_export; ?>, filename: '<?php echo $remito_export .'_' .$fecha_dev_export; ?>', format: 'xlsx'},[{name: '<?php echo $remito_export; ?>', from: {table: 'data<?php echo $remito_export; ?>'}}])
      })

  </script>
<!-- TABLAS PARA EXPORTACION -->
<?php } ?>
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
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/excellentexport@3.4.3/dist/excellentexport.min.js"></script>
  <script>
      
      let download_xls = document.querySelector("#download_xls")
      download_xls.addEventListener("click", ()=>{
          ExcellentExport.excel(download_xls, 'datatable')
      })

      let download_csv = document.querySelector("#download_csv")
      download_csv.addEventListener("click", ()=>{
          ExcellentExport.csv(download_csv, 'datatable');
      })

      let download_xlsx = document.querySelector("#download_xlsx")
      download_xlsx.addEventListener("click", ()=>{
          ExcellentExport.convert({ anchor: download_xlsx, filename: '<?php echo $num_remito_old .'_' .$fecha_old; ?>', format: 'xlsx'},[{name: '<?php echo $num_remito_old; ?>', from: {table: 'datatable'}}])
      })

  </script>
  <script>
    $(document).ready(function()
    {
      $('.selec_sap_lz').on('keyup', function()
      {
        var sap = $(this).val();
        var dato = $(this);
        var dataSAP = 'sap_lz='+sap;
        if(sap == "")
        {
          $(".selec_mat_lz").removeAttr("readonly");
          $('.sugerido_sap_lz').fadeOut(500);
        }
        else
        {
          $(".selec_mat_lz").attr("readonly","readonly");
          $.ajax({
            type: "POST",
            url: "../Ajax/a_sap.php",
            data: dataSAP,
            success: function(data)
            {
              //Escribimos las sugerencias que nos manda la consulta
              $('.sugerido_sap_lz').fadeIn(500).html(data);
              //Al hacer click en alguna de las sugerencias
              $('.suggest-sap_lz').on('click', function(){
                //Obtenemos la id unica de la sugerencia pulsada
                var id = $(this).attr('id');
                //Editamos el valor del input con data de la sugerencia pulsada
                dato.val($('#'+id).attr('data'));

                $('.selec_mat_lz').val($('#'+id).attr('mate'));

                //Hacemos desaparecer el resto de sugerencias
                $('.sugerido_sap_lz').fadeOut(500);
                return false;
              });
            }
          });
        };
      });
    }); 
  </script>
  <script>
    $(document).ready(function()
    {
      $('.selec_mat_lz').on('keyup', function()
      {
        var mat = $(this).val();
        var dato = $(this);
        var dataMAT = 'mat_lz='+mat;
        if(mat == "")
        {
          $(".selec_sap_lz").removeAttr("readonly");
          $('.sugerido_mat_lz').fadeOut(500);
        }
        else
        {
          $(".selec_sap_lz").attr("readonly","readonly");
          $.ajax({
            type: "POST",
            url: "../Ajax/a_sap.php",
            data: dataMAT,
            success: function(data)
            {
              //Escribimos las sugerencias que nos manda la consulta
              $('.sugerido_mat_lz').fadeIn(500).html(data);
              //Al hacer click en alguna de las sugerencias
              $('.suggest-mat_lz').on('click', function(){
                //Obtenemos la id unica de la sugerencia pulsada
                var id = $(this).attr('id');
                //Editamos el valor del input con data de la sugerencia pulsada
                dato.val($('#'+id).attr('data'));

                $('.selec_sap_lz').val($('#'+id).attr('sapi'));

                //Hacemos desaparecer el resto de sugerencias
                $('.sugerido_mat_lz').fadeOut(500);
                return false;
              });
            }
          });
        };
      });
    }); 
  </script>
  <script>
    $(document).ready(function()
    {
      $('.selec_sap_jls').on('keyup', function()
      {
        var sap = $(this).val();
        var dato = $(this);
        var dataSAP = 'sap_jls='+sap;
        if(sap == "")
        {
          $(".selec_mat_jls").removeAttr("readonly");
          $('.sugerido_sap_jls').fadeOut(500);
        }
        else
        {
          $(".selec_mat_jls").attr("readonly","readonly");
          $.ajax({
            type: "POST",
            url: "../Ajax/a_sap.php",
            data: dataSAP,
            success: function(data)
            {
              //Escribimos las sugerencias que nos manda la consulta
              $('.sugerido_sap_jls').fadeIn(500).html(data);
              //Al hacer click en alguna de las sugerencias
              $('.suggest-sap_jls').on('click', function(){
                //Obtenemos la id unica de la sugerencia pulsada
                var id = $(this).attr('id');
                //Editamos el valor del input con data de la sugerencia pulsada
                dato.val($('#'+id).attr('data'));

                $('.selec_mat_jls').val($('#'+id).attr('mate'));

                //Hacemos desaparecer el resto de sugerencias
                $('.sugerido_sap_jls').fadeOut(500);
                return false;
              });
            }
          });
        };
      });
    }); 
  </script>
  <script>
    $(document).ready(function()
    {
      $('.selec_mat_jls').on('keyup', function()
      {
        var mat = $(this).val();
        var dato = $(this);
        var dataMAT = 'mat_jls='+mat;
        if(mat == "")
        {
          $(".selec_sap_jls").removeAttr("readonly");
          $('.sugerido_mat_jls').fadeOut(500);
        }
        else
        {
          $(".selec_sap_jls").attr("readonly","readonly");
          $.ajax({
            type: "POST",
            url: "../Ajax/a_sap.php",
            data: dataMAT,
            success: function(data)
            {
              //Escribimos las sugerencias que nos manda la consulta
              $('.sugerido_mat_jls').fadeIn(500).html(data);
              //Al hacer click en alguna de las sugerencias
              $('.suggest-mat_jls').on('click', function(){
                //Obtenemos la id unica de la sugerencia pulsada
                var id = $(this).attr('id');
                //Editamos el valor del input con data de la sugerencia pulsada
                dato.val($('#'+id).attr('data'));

                $('.selec_sap_jls').val($('#'+id).attr('sapi'));

                //Hacemos desaparecer el resto de sugerencias
                $('.sugerido_mat_jls').fadeOut(500);
                return false;
              });
            }
          });
        };
      });
    }); 
  </script>
  <script>
    $(document).ready(function()
    {
      $('.selec_sap_sn').on('keyup', function()
      {
        var sap = $(this).val();
        var dato = $(this);
        var dataSAP = 'sap_sn='+sap;
        if(sap == "")
        {
          $(".selec_mat_sn").removeAttr("readonly");
          $('.sugerido_sap_sn').fadeOut(500);
        }
        else
        {
          $(".selec_mat_sn").attr("readonly","readonly");
          $.ajax({
            type: "POST",
            url: "../Ajax/a_sap.php",
            data: dataSAP,
            success: function(data)
            {
              //Escribimos las sugerencias que nos manda la consulta
              $('.sugerido_sap_sn').fadeIn(500).html(data);
              //Al hacer click en alguna de las sugerencias
              $('.suggest-sap_sn').on('click', function(){
                //Obtenemos la id unica de la sugerencia pulsada
                var id = $(this).attr('id');
                //Editamos el valor del input con data de la sugerencia pulsada
                dato.val($('#'+id).attr('data'));

                $('.selec_mat_sn').val($('#'+id).attr('mate'));

                //Hacemos desaparecer el resto de sugerencias
                $('.sugerido_sap_sn').fadeOut(500);
                return false;
              });
            }
          });
        };
      });
    }); 
  </script>
  <script>
    $(document).ready(function()
    {
      $('.selec_mat_sn').on('keyup', function()
      {
        var mat = $(this).val();
        var dato = $(this);
        var dataMAT = 'mat_sn='+mat;
        if(mat == "")
        {
          $(".selec_sap_sn").removeAttr("readonly");
          $('.sugerido_mat_sn').fadeOut(500);
        }
        else
        {
          $(".selec_sap_sn").attr("readonly","readonly");
          $.ajax({
            type: "POST",
            url: "../Ajax/a_sap.php",
            data: dataMAT,
            success: function(data)
            {
              //Escribimos las sugerencias que nos manda la consulta
              $('.sugerido_mat_sn').fadeIn(500).html(data);
              //Al hacer click en alguna de las sugerencias
              $('.suggest-mat_sn').on('click', function(){
                //Obtenemos la id unica de la sugerencia pulsada
                var id = $(this).attr('id');
                //Editamos el valor del input con data de la sugerencia pulsada
                dato.val($('#'+id).attr('data'));

                $('.selec_sap_sn').val($('#'+id).attr('sapi'));

                //Hacemos desaparecer el resto de sugerencias
                $('.sugerido_mat_sn').fadeOut(500);
                return false;
              });
            }
          });
        };
      });
    }); 
  </script>
  <script>
    $(document).ready(function(){
      $(".toggler").click(function(e){
        e.preventDefault();
        $('.cat'+$(this).attr('data-prod-cat')).toggle();
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      $('.sn').keypress(function(e){
        if(e.which == 13){
          return false;
        }
      });
    });
  </script>
</body>
</html>

