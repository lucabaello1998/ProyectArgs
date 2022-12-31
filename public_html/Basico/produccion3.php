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
  if($usu != 1)
  {
    header("location: ../index.php");
  }
  $nombre = $_SESSION['nombre'];
  $apellido = $_SESSION['apellido'];
?>
<?php include('../includes/header.php'); ?>
<?php
  if(isset($_GET['dia']))
  {
    $fechaultima = $_GET['dia'];
    $recha = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha = '$fechaultima' LIMIT 1");  
    while($row = mysqli_fetch_assoc($recha))
    {
      $dia_normal = $row['dia'];
    }
  }
  else
  {
    $result = mysqli_query($conn, "SELECT * FROM carga_dia ORDER BY fecha desc LIMIT 1");  
    while($row = mysqli_fetch_assoc($result))
    {
      $fechaultima = $row['fecha'];
      $dia_normal = $row['dia'];
    }
  }

  $resu = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '%$fechaultima%' GROUP BY tecnico ");  
  while($row = mysqli_fetch_assoc($resu))
  {
    $array[] = $row['tecnico']; /////guarda resultados en un array Array ( [0] => Brian Flores [1] => Carlos Da Silva [2] => Cristian Caro [3] => Leandro Vaca [4] => Mauro Ramirez [5] => Ricardo Romero [6] => Ruben Gaette Lopez )
  }

  $resu_produ = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$fechaultima%' GROUP BY tecnico ");  
  while($roww = mysqli_fetch_assoc($resu_produ))
  {
    $array_produ[] = $roww['tecnico']; /////guarda resultados en un array Array ( [0] => Brian Flores [1] => Carlos Da Silva [2] => Cristian Caro [3] => Leandro Vaca [4] => Mauro Ramirez [5] => Ricardo Romero [6] => Ruben Gaette Lopez )
  }
?>
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row justify-content-center pr-2 pl-2 pt-2 pb-0">
    <div class="col-auto align-self-center p-0">
      <form action="../Guardar/save_produccion3.php" method="POST">
        <input type="hidden" name="ultima_fecha" value="<?php echo $fechaultima; ?>">
        <button type="submit" name="menos" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="top" title="Dia anterior">
          <i class="fa-solid fa-caret-left"></i>
        </button>
      </form>
    </div>
    <div class="col-auto align-self-center text-center text-white">
      <span><?php echo Fecha3($fechaultima) ,' (' .$dia_normal .')' ; ?></span>
    </div>
    <div class="col-auto align-self-center p-0">
      <form action="../Guardar/save_produccion3.php" method="POST">
        <input type="hidden" name="ultima_fecha" value="<?php echo $fechaultima; ?>">
        <button type="submit" name="mas" class="btn btn-outline-light m-2" data-toggle="tooltips" data-placement="top" title="Dia siguiente">
          <i class="fa-solid fa-caret-right"></i>
        </button>
      </form>
    </div>
  </div>
</div>
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
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">

    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <a class="btn btn-info" href="../BaseDatos/dtproduccion.php" role="button">Ver toda la produccion</a>
        </div>
      </div>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <p class="h4 mb-4 text-center">Garantias incompletas</p>
          <table id="garantias" class="table table-responsive table-striped table-bordered table-sm">
            <thead class="thead-dark text-center">
              <tr>
                <th>Acciones</th>
                <th>Tecnico</th>
                <th>OT</th>
                <th>Fecha instalacion</th>
                <th>Fecha reparacion</th>
                <th>Tecnico que reparo</th>
              </tr>
            </thead>
            <tbody align="center">
              <?php
                $gargaras = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep LIKE '%$fechaultima%' ORDER BY fecharep desc");
                while($row = mysqli_fetch_assoc($gargaras))
                {
              ?>
                <tr>
                  <td>
                    <a href="../Editar/edit_garantias.php?id=<?php echo $row['id']?>">
                      <i class="fas fa-pen p-2"></i>
                    </a>
                  </td>              
                  <td><?php echo $row['tecnico']; ?></td>
                  <td><?php echo $row['ot']; ?></td>
                  <td><?php echo Fecha7($row['fechaint']); ?></td>
                  <td><?php echo Fecha7($row['fecharep']); ?></td>
                  <td><?php echo $row['tecrep']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <div class="card card-body">
            <form action="../Guardar/save_produccion4.php" method="POST" enctype="multipart/form-data" name="frmExcelImport" id="frmExcelImport">
              <p class="h4 mb-4 text-center">Ingreso del dia</p>
              <div class="row justify-content-center">
                <div class="card card-body">
                  <div class="form-row align-items-start justify-content-center">
                    <label>Cargar excel del dia </label>
                  </div>
                  <div class="form-row align-items-start justify-content-center">
                    <input type="file" name="file" id="file" accept=".xls,.xlsx">
                  </div>
                </div>
              </div>
              <div class="row justify-content-center">
                <input type="submit" id="submit" name="cargar_dia" value="Ingresar dia" class="btn btn-success btn-block"/>              
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-auto p-1">
          <form action="../Guardar/save_produccion3.php" method="POST" >
            <input type="hidden" name="ultima_fecha" value="<?php echo $fechaultima; ?>">
            <div class="form-row">
              <div class="form-group col">
                <select type="text" name="dia_cambio" class="form-control">
                  <option selected><?php echo $dia_normal; ?></option>
                  <option value="Normal">Normal</option>
                  <option value="Sabado">Sabado</option>
                  <option value="Feriado">Feriado</option>
                </select>
              </div>
              <div class="form-group col">                
                <input type="submit" name="cambiar_dia" value="Cambiar dia" class="btn btn-warning"/>              
              </div>
            </div>              
          </form>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-auto p-1">
          <form action="../Guardar/save_produccion3.php" method="POST">
            <input type="hidden" name="ultima_fecha" value="<?php echo $fechaultima; ?>">
            <div class="form-row">
              <div class="form-group col">              
                <select type="text" name="tecnicoa" class="form-control">
                  <option selected="0">Tecnico A</option>                
                  <?php
                    $ejecutar=mysqli_query($conn,"SELECT * FROM carga_dia WHERE fecha like '%$fechaultima%' GROUP BY tecnico ORDER BY tecnico asc");
                  ?>
                  <?php foreach ($ejecutar as $opciones): ?>   
                    <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group col-1">              
                <span>por</span>
              </div>
              <div class="form-group col">
                <select type="text" name="tecnicob" class="form-control">
                  <option selected="0">Tecnico B</option>                
                  <?php
                    $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                  ?>
                  <?php foreach ($ejecutar as $opciones): ?>   
                    <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group col">                
                <input type="submit" id="submit" name="cambiar_tecnico" value="Cambiar de técnico" class="btn btn-warning"/>              
              </div>
            </div>              
          </form>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-auto p-1">
          <form action="../Guardar/save_produccion3.php" method="POST" >
            <input type="hidden" name="ultima_fecha" value="<?php echo $fechaultima; ?>">
            <div class="form-row">
              <div class="form-group col">
                <select type="text" name="tecnicoc" class="form-control">
                  <option selected="0">Tecnico</option>                
                  <?php
                    $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                  ?>
                  <?php foreach ($ejecutar as $opciones): ?>   
                    <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group col">
                <select type="text" name="dia_solo" class="form-control">
                  <option selected>Ausente</option>
                  <option value="Normal">Normal</option>
                  <option value="Ausente">Ausente</option>
                  <option value="Supervisor">Supervisor</option>
                  <option value="Auditor">Auditor</option>
                  <option value="Sabado">Sabado</option>
                  <option value="Feriado">Feriado</option>
                  <option value="Vacaciones">Vacaciones</option>
                </select>
              </div>
              <div class="form-group col">                
                <input type="submit" name="cargar_tecnico" value="Cargar tecnico" class="btn btn-warning"/>              
              </div>
            </div>              
          </form>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-auto p-1">
          <form action="../Guardar/save_produccion3.php" method="POST" >
            <input type="hidden" name="ultima_fecha" value="<?php echo $fechaultima; ?>">
            <input type="submit" name="borrar_dia" value="Borrar dia" class="btn btn-danger"/>
          </form>
        </div>
      </div>

      <style>
        :root { --del-color: #F56F84;}

        del {
        --color: var(--del-color, red);
        text-decoration: none;
        padding: 0 .5em;
        background-repeat: no-repeat;
        background-image: 
          linear-gradient(to left, rgba(255, 255, 255, .5), transparent),
          linear-gradient(2deg, var(--color) 50%, transparent 50%),
          linear-gradient(-.9deg, var(--color) 50%, transparent 50%),
          linear-gradient(-60deg, var(--color) 50%, transparent 50%),
          linear-gradient(120deg, var(--color) 50%, transparent 50%);
        
        background-size: 
          30% 1.5px,
          calc(100% - 20px) 10px, 
          calc(100% - 20px) 10px,
          10px 10px,
          8px 8px; 
        
        background-position: 
          100% calc(50% + 2px),
          center center, 
          center center, 
          2px 50%, 
          calc(100% - 3px) calc(50% + 1px);
        }
      </style>

      <div class="row justify-content-center">
        <div class="col-11 p-1">
          <?php
            $result_tasks = mysqli_query($conn, "SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");  
            while($row = mysqli_fetch_assoc($result_tasks))
            {
              $tec = $row['tecnico']; /////guarda los resultados de la consulta en la variable $tec
              if (in_array($tec, $array)) ////buscame el valor de $tec en la lista de $array
              {
                echo '<del> ' .$tec .' </del>'; //// si encontro resultado agrega <del></del>
              }
              else{ //////si no lo encuentra solo mostralos en pantalla
                echo ' ' .$tec .' ';
              }
            }
          ?>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-11 p-0 m-1">

        <nav >
          <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
            <?php
              $tce_ult = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '%$fechaultima%' GROUP BY tecnico");  
              while($row = mysqli_fetch_assoc($tce_ult))
              {
                $tecnico_ultimo_cargado = $row['tecnico'];
                $tce_ulti = mysqli_query($conn, "SELECT * FROM tecnicos WHERE tecnico = '$tecnico_ultimo_cargado' GROUP BY tecnico");  
                while($row = mysqli_fetch_assoc($tce_ulti))
                {
                  $tecnico_nom = $row['tecnico'];
                  $tec_codigo = $row['id_recurso'];
                  if (in_array($tecnico_nom, $array_produ))
                  {
                    ?>
                      <button class="nav-link alert-success" id="nav-<?php echo $tec_codigo; ?>-tab" data-toggle="tab" data-target="#nav-<?php echo $tec_codigo; ?>" type="button" role="tab" aria-controls="nav-<?php echo $tec_codigo; ?>" aria-selected="true"><?php echo $tecnico_nom; ?></button>
                    <?php
                  }
                  else
                  {
                    ?>
                      <button class="nav-link" id="nav-<?php echo $tec_codigo; ?>-tab" data-toggle="tab" data-target="#nav-<?php echo $tec_codigo; ?>" type="button" role="tab" aria-controls="nav-<?php echo $tec_codigo; ?>" aria-selected="true"><?php echo $tecnico_nom; ?></button>
                    <?php
                  }
                }
              }
            ?>
          </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">
          <?php
            $tce_ult1 = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha like '%$fechaultima%' GROUP BY tecnico");  
            while($row = mysqli_fetch_assoc($tce_ult1))
            {
              $tec_dia = $row['dia'];
              $zona_recurso = $row['zona_recurso'];
              $tecnico_ultimo_cargado1 = $row['tecnico'];
              $tce_ulti1 = mysqli_query($conn, "SELECT * FROM tecnicos WHERE tecnico = '$tecnico_ultimo_cargado1' GROUP BY tecnico");  
              while($row = mysqli_fetch_assoc($tce_ulti1))
              {
                $tecnico_nom1 = $row['tecnico'];
                $tec_codigo1 = $row['id_recurso'];
                $tec_dni1 = $row['dni'];
                ?>
                  <div class="tab-pane fade" id="nav-<?php echo $tec_codigo1; ?>" role="tabpanel" aria-labelledby="nav-<?php echo $tec_codigo1; ?>-tab">

                    <div class="row justify-content-center">
                      <div class="col-auto p-0 m-1">
                        <span  class="text-center"><?php echo $tecnico_nom1 ,' (' .$zona_recurso .')' ; ?></span>
                      </div>
                    </div>
                    <div class="row justify-content-center">
                      <div class="col-11 p-0 m-1">
                        <table class="table table-responsive table-striped table-bordered table-sm">
                          <thead class="thead-dark text-center">
                            <tr>
                              <th>Codigo</th>
                              <th>TV</th>
                              <th>Actividad</th>
                              <th>Estado</th>
                              <th>Inicio</th>
                              <th>Fin</th>
                              <th>Cierre</th>
                              <th>Observacion</th>
                              <th>Revisita</th>
                              <th>2 play</th>
                              <th>3 play</th>
                              <th>Adicional</th>
                              <th>Mudanza interna</th>
                              <th>Baja</th>
                              <th>Garantia</th>
                              <th>Baja tecnica</th>
                              <th>Baja con desmonte</th>
                              <th>Mtto</th>
                              <th>Mtto externo</th>
                            </tr>
                          </thead>
                          <tbody align="center">
                            <?php
                              $rra = mysqli_query($conn, "SELECT
                              SUM(dos_play) as 'dos_player',
                              SUM(tres_play) as 'tres_player',
                              SUM(stb) as 'stb_player',
                              SUM(mudanza_interna) as 'mudanza_interna_player',
                              SUM(garantia) as 'garantia_player',
                              SUM(baja_tecnica) as 'baja_tecnica_player',
                              SUM(baja_desmonte) as 'baja_desmonte_player',
                              SUM(mtto) as 'mtto_player',
                              SUM(mtto_externo) as 'mtto_externo_player'
                              FROM carga_dia WHERE tecnico = '$tecnico_nom1' and fecha like '%$fechaultima%' AND estado = 'finalizada' ");
                              while($rowa = mysqli_fetch_assoc($rra))
                              {
                                ?>
                                  <tr>
                                    <td colspan="9"></td>
                                    <td><span <?php if($rowa['dos_player'] > 0){echo 'class="badge badge-pill badge-success"';} ?>><?php echo $rowa['dos_player']; ?></span></td>
                                    <td><span <?php if($rowa['tres_player'] > 0){echo 'class="badge badge-pill badge-success"';} ?>><?php echo $rowa['tres_player']; ?></span></td>
                                    <td><span <?php if($rowa['stb_player'] > 0){echo 'class="badge badge-pill badge-success"';} ?>><?php echo $rowa['stb_player']; ?></span></td>
                                    <td><span <?php if($rowa['mudanza_interna_player'] > 0){echo 'class="badge badge-pill badge-success"';} ?>><?php echo $rowa['mudanza_interna_player']; ?></span></td>

                                    <?php
                                      $rraa = mysqli_query($conn, "SELECT
                                      SUM(baja) as 'baja_player'
                                      FROM carga_dia WHERE tecnico = '$tecnico_nom1' and fecha like '%$fechaultima%' AND estado = 'no realizado' ");
                                      while($rowaa = mysqli_fetch_assoc($rraa))
                                      {
                                        ?>
                                      <td><span <?php if($rowaa['baja_player'] > 0){echo 'class="badge badge-pill badge-danger"';} ?>><?php echo $rowaa['baja_player']; ?></span></td>
                                    <?php } ?>

                                    <td><span <?php if($rowa['garantia_player'] > 0){echo 'class="badge badge-pill badge-warning"';} ?>><?php echo $rowa['garantia_player']; ?></span></td>
                                    <td><span <?php if($rowa['baja_tecnica_player'] > 0){echo 'class="badge badge-pill badge-danger"';} ?>><?php echo $rowa['baja_tecnica_player']; ?></span></td>
                                    <td><span <?php if($rowa['baja_desmonte_player'] > 0){echo 'class="badge badge-pill badge-danger"';} ?>><?php echo $rowa['baja_desmonte_player']; ?></span></td>
                                    <td><span <?php if($rowa['mtto_player'] > 0){echo 'class="badge badge-pill badge-warning"';} ?>><?php echo $rowa['mtto_player']; ?></span></td>
                                    <td><span <?php if($rowa['mtto_externo_player'] > 0){echo 'class="badge badge-pill badge-warning"';} ?>><?php echo $rowa['mtto_externo_player']; ?></span></td>
                                  </tr>
                                <?php
                              } 
                            ?>
                            <?php
                              $result_tasks = mysqli_query($conn, "SELECT * FROM carga_dia WHERE tecnico = '$tecnico_nom1' and fecha like '%$fechaultima%' ORDER BY id asc");
                              while($row = mysqli_fetch_assoc($result_tasks))
                              { 
                                $color = '';
                                if($row['revisita'] === 'SI')
                                {
                                  $color= 'class="alert-warning"';
                                }

                                if(strpos($row['actividad'], 'cnico al cliente - Garantia') !== false)
                                {
                                  $color= 'class="alert-warning"';
                                }

                                if(strpos($row['actividad'], 'Reclamos Excepcionales') !== false)
                                {
                                  $color= 'class="alert-warning"';
                                }

                                if(strpos($row['actividad'], 'cnica por mudanza interna') !== false && $row['estado'] === 'finalizada' ) ///////comprobar
                                {
                                  $color= 'class="alert-warning"';
                                }
                                if($row['estado'] === 'iniciada')
                                {
                                  $color= 'class="bg-danger"';
                                }
                            ?>
                              <tr <?php  echo $color; ?> >            
                                <td><?php echo $row['codigo']; ?></td>
                                <td><?php echo $row['cantidad_tv']; ?></td>
                                <td><?php echo utf8_encode($row['actividad']); ?></td>
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
                                <td><span class="badge badge-pill <?php echo $color_badge; ?>"><?php echo $row['estado'] ?></span></td>
                                <td><?php echo substr($row['inicio'], 0, -3); ?></td>
                                <td><?php echo substr($row['fin'], 0, -3); ?></td>
                                <td><?php if($row['estado'] == 'finalizada') {echo utf8_encode($row['razon_completada']);} else {echo utf8_encode($row['razon_no_completada']);}; ?></td>
                                <td><?php echo utf8_encode($row['nota_cierre']); ?></td>
                                <td><?php echo $row['revisita']; ?></td>
                                <td <?php if($row['dos_play'] > 0){echo 'class="font-weight-bold text-success"';} ?>><?php echo $row['dos_play']; ?></td>
                                <td <?php if($row['tres_play'] > 0){echo 'class="font-weight-bold text-success"';} ?>><?php echo $row['tres_play']; ?></td> 
                                <td <?php if($row['stb'] > 0){echo 'class="font-weight-bold text-success"';} ?>><?php echo $row['stb']; ?></td> 
                                <td <?php if($row['mudanza_interna'] > 0){echo 'class="font-weight-bold text-success"';} ?>><?php echo $row['mudanza_interna']; ?></td> 
                                <td <?php if($row['baja'] > 0){echo 'class="font-weight-bold text-danger"';} ?>><?php echo $row['baja']; ?></td> 
                                <td <?php if($row['garantia'] > 0){echo 'class="font-weight-bold text-warning"';} ?>><?php echo $row['garantia']; ?></td>
                                <td <?php if($row['baja_tecnica'] > 0){echo 'class="font-weight-bold text-danger"';} ?>><?php echo $row['baja_tecnica']; ?></td>
                                <td <?php if($row['baja_desmonte'] > 0){echo 'class="font-weight-bold text-danger"';} ?>><?php echo $row['baja_desmonte']; ?></td>
                                <td <?php if($row['mtto'] > 0){echo 'class="font-weight-bold text-warning"';} ?>><?php echo $row['mtto']; ?></td>
                                <td <?php if($row['mtto_externo'] > 0){echo 'class="font-weight-bold text-warning"';} ?>><?php echo $row['mtto_externo']; ?></td>        
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>

                  </div>
                <?php
              }
            }
          ?>
        </div>

        </div>
      </div>

    </div>

  </div>
</div>
<!-- PIE DE PAGINA -->

<!-- jQuery -->
<script src="./excel/assets/jquery-1.12.4-jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- then Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>