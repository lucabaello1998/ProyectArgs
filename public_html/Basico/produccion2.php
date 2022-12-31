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
  if($nombre_us == "Damian" && $apellido_us == 'Duarte') { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
  }
?>
<?php include('../includes/header.php'); ?>
<!-- FECHA -->
  <?php
    $result = mysqli_query($conn, "SELECT * FROM carga_dia ORDER BY fecha desc LIMIT 1");  
    while($row = mysqli_fetch_assoc($result))
    {
      $messi = $row['fecha'];
    }

    $resu_produ = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '$messi%' GROUP BY tecnico ");  
    while($roww = mysqli_fetch_assoc($resu_produ))
    {
      $array_produ[] = $roww['tecnico']; /////guarda resultados en un array Array ( [0] => Brian Flores [1] => Carlos Da Silva [2] => Cristian Caro [3] => Leandro Vaca [4] => Mauro Ramirez [5] => Ricardo Romero [6] => Ruben Gaette Lopez )
    }
  ?>
<!-- FECHA -->
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
<div class="container-fluid p-4">
  <div class="row p-2">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <?php
            $count_id = mysqli_query($conn, "SELECT *, count(tecnico) as 'total_id' FROM tecnicos WHERE activo = 'SI' AND tipo = 'Tecnico' AND id_recurso = '1111'");
            while($row = mysqli_fetch_assoc($count_id))
            {
              $totalnorte = $row['total_id'];
              $tecnico_nomnom = $row['tecnico'];
            }
            $fec = mysqli_query($conn, "SELECT COUNT(DISTINCT(tecnico))as'count_tecnico', fecha, tecnico FROM carga_dia WHERE fecha LIKE '$mes%' AND ingresado = 'NO'");  
            while($rfe = mysqli_fetch_assoc($fec))
            {
              echo '<p class="h3 mb-4 text-center">' .Fecha5($messi) .'<br><span class="badge badge-pill badge-warning">' .$rfe['count_tecnico'] .'</span>';
              if($totalnorte >= 1)
              {
                echo '<br><span class="badge badge-pill badge-danger">' .$tecnico_nomnom .'</span>';
              }
              else
              {
                echo '';
              }
              echo '</p>';
            }
          ?>
        </div>
      </div>

      <div class="row justify-content-center p-1">
        <div class="col-auto">
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ingresotec">
            +
          </button>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="ingresotec" tabindex="-1" role="dialog" aria-labelledby="modal_Tec" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modal_Tec" text-center>Carga de usuarios</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="card card-body">
              <form action="../Guardar/save_produccion.php" method="POST">
                <p class="h4 mb-4 text-center">Carga del dia</p>
                <div class="form-row align-items-end">
                  <div class="form-group col-12 col-md">
                    <label for="exampleFormControlSelect1">Tecnico</label >
                    <select type="text" name="tecnico" class="form-control" required>
                      <option selected value="" disabled>Tecnicos...</option>                
                      <?php
                        $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo ='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                      ?>
                      <?php foreach ($ejecutar as $opciones): ?>   
                        <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                      <?php endforeach ?>
                    </select>
                  </div>            
                  <div class="form-group col-6 col-md">
                    <label for="exampleFormControlSelect1">Fecha</label >
                    <input type="date" name="fecha" class="form-control" required>
                  </div>
                  <div class="form-group col-6 col-md">
                    <label for="exampleFormControlSelect1">Dia</label >
                    <select type="text" name="dia" class="form-control" required>
                      <option selected>Normal</option> 
                      <option value="Ausente">Ausente</option>
                      <option value="Sabado">Sabado</option>
                      <option value="Feriado">Feriado</option>
                      <option value="Vacaciones">Vacaciones</option>
                      <option value="Licencia">Licencia</option>
                      <option value="Suspension">Suspension</option>
                      <option value="Dia libre">Dia libre</option>
                      <option value="Vehiculo roto">Vehiculo roto</option>
                    </select>
                  </div>
                  <div class="form-group col-6 col-md">
                    <label for="exampleFormControlSelect1">Inicio</label >
                    <input type="text" class="form-control clockpicker" readonly="" data-placement="left" data-align="top" data-autoclose="true" name="horadep" required>
                  </div>
                  <div class="form-group col-6 col-md">
                    <label for="exampleFormControlSelect1">Primer tarea</label >
                    <input type="text" class="form-control tarea" readonly="" data-placement="left" data-align="top" data-autoclose="true" name="horatarea" required>
                  </div>
                  <div class="form-group col-6 col-md">
                    <label for="exampleFormControlSelect1">Ultima tarea</label >
                    <input type="text" class="form-control fin" readonly="" data-placement="left" data-align="top" data-autoclose="true" name="fin" required>
                  </div>
                  <div class="form-group col-6 col-md">
                    <label for="exampleFormControlSelect1">Zona</label >
                    <select type="text" name="zona" class="form-control" required>
                      <option selected value="" disabled>Zona...</option>
                      <option value="CABA">CABA</option>
                      <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                      <option value="Lomas de Zamora">Lomas de Zamora</option>
                      <option value="San Nicolas">San Nicolas</option>
                    </select>
                  </div>
                </div>

                <div class="row align-items-end">
                  <div class="form-group col-md col-6">
                    <label for="exampleFormControlSelect1" class="text-center">Doble play</label >
                    <input type="number" name="dosplay" class="form-control" value="0">
                  </div>
                  <div class="form-group col-md col-6">
                    <label for="exampleFormControlSelect1" class="text-center">Triple play</label >
                    <input type="number" name="tresplay" class="form-control" value="0">
                  </div>
                  <div class="form-group col-md col-6">
                    <label for="exampleFormControlSelect1" class="text-center">Set to Box</label >
                    <input type="number" name="stb" class="form-control" value="0">
                  </div>
                  <div class="form-group col-md col-6">
                    <label for="exampleFormControlSelect1" class="text-center">Mudanzas internas</label >
                    <input type="number" name="mudanza" class="form-control" value="0">
                  </div>
                </div>

                <div class="row align-items-end">
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1" class="text-center">Bajas</label >
                    <input type="number" name="bajas" class="form-control" value="0">
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1" class="text-center">Garantias del tecnico</label >
                    <input type="number" name="garantec" class="form-control" value="0">
                  </div>
                  <div class="form-group col">
                    <label for="exampleFormControlSelect1" class="text-center">Garantias compañero</label >
                    <input type="number" name="garancom" class="form-control" value="0">
                  </div>
                </div>

                <div class="row align-items-end">
                  <div class="form-group col-md col-6">
                    <label for="exampleFormControlSelect1" class="text-center">Bajas tecnica</label >
                    <input type="number" name="bajatec" class="form-control" value="0">
                  </div>
                  <div class="form-group col-md col-6">
                    <label for="exampleFormControlSelect1" class="text-center">Bajas con desmonte</label >
                    <input type="number" name="baja_desmonte" class="form-control" value="0">
                  </div>
                  <div class="form-group col-md col-6">
                    <label for="exampleFormControlSelect1" class="text-center">Reacondicionamiento</label >
                    <input type="number" name="mtto_reaco" class="form-control" value="0">
                  </div>
                  <div class="form-group col-md col-6">
                    <label for="exampleFormControlSelect1" class="text-center">Mtto interno</label >
                    <input type="number" name="mtto_int" class="form-control" value="0">
                  </div>              
                  <div class="form-group col-md col-6">
                    <label for="exampleFormControlSelect1" class="text-center">Mtto externo</label >
                    <input type="number" name="mtto_ext" class="form-control" value="0">
                  </div>
                </div>

                <div class="row align-items-end">
                  <div class="form-group col-12">
                    <label class="text-center">Observaciones</label>
                    <textarea type="text" name="obs" maxlength="255" class="form-control"></textarea>
                  </div>
                </div>

                <div class="row align-items-center">
                  <input type="submit" name="save_produccion" class="btn btn-success btn-block" value="Guardar dia">
                </div>
              </form>
            </div>      
          </div>
        </div>
      </div>

      <!-- GARANTIAS -->
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
                    $gargaras = mysqli_query($conn, "SELECT * FROM garantias WHERE fecharep = '$messi%'");
                    while($rowgi = mysqli_fetch_assoc($gargaras))
                    {
                      $tec_original = $rowgi['tecnico'];
                      $tec_copia = $rowgi['tecrep'];
                      $otes = $rowgi['ot'];
                  ?>
                    <tr>
                      <td>
                        <a href="../Editar/edit_garantias2.php?id=<?php echo $rowgi['id']?>">
                          <i class="fas fa-pen p-2"></i>
                        </a>
                      </td>
                      <?php
                        /* TECNICO ORIGINAL */
                          $garan_color = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha = '$messi' AND tecnico = '$tec_original' AND ot = '$otes'");  
                          if(mysqli_num_rows($garan_color) > 0)
                          {
                            $garan_color_pre = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha = '$messi' AND tecnico = '$tec_original' AND garantec > 0");  
                            if(mysqli_num_rows($garan_color_pre) > 0)
                            {
                              $ga_color = 'bg-success';
                            }
                            else
                            {
                              $ga_color = 'bg-warning';
                            }
                          }
                          else
                          {
                            $garan_color_pro = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha = '$messi' AND tecnico = '$tec_original' AND garantec > 0");  
                            if(mysqli_num_rows($garan_color_pro) > 0)
                            {
                              $ga_color = 'bg-success';
                            }
                            else
                            {
                              $ga_color = '';
                            }
                          }
                        /* TECNICO ORIGINAL */
                        /* TECNICO REPARO */
                        $garan_color_re = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha = '$messi' AND tecnico = '$tec_copia' AND ot = '$otes'");  
                        if(mysqli_num_rows($garan_color_re) > 0)
                        {
                          $garan_color_pre_re = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha = '$messi' AND tecnico = '$tec_copia' AND garancom > 0 OR fecha = '$messi' AND tecnico = '$tec_copia' AND garantec > 0");  
                          if(mysqli_num_rows($garan_color_pre_re) > 0)
                          {
                            $ga_color_re = 'bg-success';
                          }
                          else
                          {
                            $ga_color_re = 'bg-warning';
                          }
                        }
                        else
                        {
                          $garan_color_pro_re = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha = '$messi' AND tecnico = '$tec_copia' AND garancom > 0 OR fecha = '$messi' AND tecnico = '$tec_copia' AND garantec > 0");  
                          if(mysqli_num_rows($garan_color_pro_re) > 0)
                          {
                            $ga_color_re = 'bg-success';
                          }
                          else
                          {
                            $ga_color_re = '';
                          }
                        }
                      /* TECNICO REPARO */
                      ?>
                      <td class="<?php echo $ga_color; ?>"><?php echo $rowgi['tecnico']; ?></td>
                      <td><?php echo $rowgi['ot']; ?></td>
                      <td><?php echo Fecha7($rowgi['fechaint']); ?></td>
                      <td><?php echo Fecha7($rowgi['fecharep']); ?></td>
                      <td <?php if($rowgi['tecrep'] == ''){ echo 'class="bg-danger"'; } else {echo 'class="' .$ga_color_re .'"';} ; ?>><?php echo $rowgi['tecrep']; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <div class="col-auto">
              <div class="card card-body">
                <form action="../Guardar/save_produccion4.php" method="POST" enctype="multipart/form-data" name="frmExcelImport" id="frmExcelImport">
                  <p class="h4 mb-4 text-center">Ingreso del dia</p>
                  <div class="row justify-content-center">
                    <div class="col-12">
                      <div class="form-row align-items-start justify-content-center">
                        <label>Cargar excel del dia </label>
                      </div>
                      <div class="form-row align-items-start justify-content-center">
                        <input type="file" name="file" id="file" accept=".xls">
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row justify-content-center">
                    <input type="submit" id="submit" name="cargar_dia" value="Ingresar dia" class="btn btn-success btn-block"/>              
                  </div>
                </form>
              </div>
            </div>
          </div>
      <!-- GARANTIAS -->

      <style>
        :root { --del-color: #77dd77;}

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
            $tachado = mysqli_query($conn, "SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");  
            while($row = mysqli_fetch_assoc($tachado))
            {
              $tec = $row['tecnico']; /////guarda los resultados de la consulta en la variable $tec
              if (in_array($tec, $array_produ)) ////buscame el valor de $tec en la lista de $array
              {
                echo '<del> ' .$tec .' </del>'; //// si encontro resultado agrega <del></del>
              }
              else
              { //////si no lo encuentra solo mostralos en pantalla
                echo ' ' .$tec .' ';
              }
            }
          ?>
        </div>
      </div>

    <?php
      $zona = '-';
      $base = mysqli_query($conn, "SELECT * FROM carga_dia WHERE fecha ='$messi' AND ingresado = 'NO' GROUP BY tecnico");  
      while($row = mysqli_fetch_assoc($base))
      {
        $tecnico = $row['tecnico'];
        
        $zona = $row['zona_recurso'];
        $id_tecnico_id = uniqid();
    ?>
      <div class="row justify-content-center">
        <div class="col-11 p-0 m-1">
          <div class="card card-body">
            <p class="h5 mb-4 text-center"><?php echo $tecnico .'<br><span class="h6 text-center">' .Fecha5($row['fecha']) .'</span>'; ?></p>
            <table class="table table-responsive table-striped table-bordered table-hover table-sm">
              <tbody align="center">
                <?php
                  $rra = mysqli_query($conn, "SELECT
                  SUM(dos_play) as 'dos_player',
                  SUM(tres_play) as 'tres_player',
                  SUM(stb) as 'stb_player',
                  SUM(mudanza_interna) as 'mudanza_interna_player',
                  SUM(garantia) as 'garantia_player',
                  SUM(garantia_com) as 'garantia_com_player',
                  SUM(baja_tecnica) as 'baja_tecnica_player',
                  SUM(baja_desmonte) as 'baja_desmonte_player',
                  SUM(mtto) as 'mtto_player',
                  SUM(reacondicionamiento	) as 'reacondicionamiento_player',
                  SUM(mtto_externo) as 'mtto_externo_player'
                  FROM carga_dia WHERE tecnico = '$tecnico' and fecha = '$messi' AND estado = 'finalizada' ");
                  while($rowa = mysqli_fetch_assoc($rra))
                  {
                    ?>
                      <form id="<?php echo $id_tecnico_id; ?>" action="../Guardar/save_produccion.php" method="POST">
                        <input type="hidden" name="tecnico" value="<?php echo $tecnico; ?>">
                        <input type="hidden" name="zona" value="<?php echo $zona; ?>"> 
                        <input type="hidden" name="fecha" value="<?php echo $messi; ?>">
                        <input type="hidden" name="obs" value=""> 
                        <tr>
                          <!-- DIA Y HORARIOS -->
                            <?php
                              $hora_inicio = '00:00:00';
                              $rrai = mysqli_query($conn, "SELECT * FROM carga_dia WHERE tecnico = '$tecnico' and fecha = '$messi' ORDER BY id asc LIMIT 1");
                              while($rowai = mysqli_fetch_assoc($rrai))
                              { if($rowai['inicio'] < '07:00:00')
                                {
                                  $hora_iniciar = '07:00:00';
                                }
                                else
                                {
                                  $hora_iniciar = $rowai['inicio'];
                                }
                              }
                            ?>
                            <?php
                              $hora_tarea = '00:00:00';
                              $rrat = mysqli_query($conn, "SELECT * FROM carga_dia WHERE tecnico = '$tecnico' and fecha = '$messi' AND cliente <> '' ORDER BY id asc LIMIT 1");
                              while($rowat = mysqli_fetch_assoc($rrat))
                              { $hora_tarea = $rowat['inicio']; }
                            ?>
                            <?php
                              $hora_fin = '00:00:00';
                              $rraf = mysqli_query($conn, "SELECT * FROM carga_dia WHERE tecnico = '$tecnico' and fecha = '$messi' AND cliente <> '' ORDER BY id desc LIMIT 1");
                              while($rowaf = mysqli_fetch_assoc($rraf))
                              { $hora_fin = $rowaf['fin']; }
                            ?>
                            <?php
                              if($hora_tarea == '00:00:00' && $hora_fin == '00:00:00')
                              {
                                $hora_inicio = '00:00:00';
                                $tipo_de_dia = 'Ausente';
                              }
                              else
                              {
                                $hora_inicio = $hora_iniciar;

                                $a = date("l", strtotime($messi));
                                $b = explode(" ", $a);
                                $c = $b[0];
                                if($c == 'Saturday')
                                {
                                  $tipo_de_dia = "Sabado";
                                }
                                else
                                {
                                  $tipo_de_dia = "Normal";
                                }
                              }
                            ?>
                          <!-- DIA Y HORARIOS -->
                          <td colspan="4"><label>Dia</label>
                                            <select type="text" name="dia" class="form-control" required>
                                              <option selected value="<?php echo $tipo_de_dia; ?>"><?php echo $tipo_de_dia; ?></option> 
                                              <option value="Ausente">Ausente</option>
                                              <option value="Sabado">Sabado</option>
                                              <option value="Feriado">Feriado</option>
                                              <option value="Vacaciones">Vacaciones</option>
                                              <option value="Licencia">Licencia</option>
                                              <option value="Suspension">Suspension</option>
                                              <option value="Dia libre">Dia libre</option>
                                              <option value="Vehiculo roto">Vehiculo roto</option>
                                            </select>
                          </td>
                          <td><label>Inicio</label><input type="time" name="horadep" required class="form-control form-control-sm border border-primary" value="<?php echo $hora_inicio; ?>"></td>
                          <td><label>Tarea</label><input type="time" name="horatarea" required class="form-control form-control-sm border border-primary" value="<?php echo $hora_tarea; ?>"></td>
                          <td><label>Fin</label><input type="time" name="fin" required class="form-control form-control-sm border border-primary" value="<?php echo $hora_fin; ?>"></td>
                          <td colspan="3"></td>
                          <td><label>2 play</label><input type="number" name="dosplay" class="form-control form-control-sm border border-success" min="0" value="<?php echo $rowa['dos_player']; ?>"></td>
                          <td><label>3 play</label><input type="number" name="tresplay" class="form-control form-control-sm border border-success" min="0" value="<?php echo $rowa['tres_player']; ?>"></td>
                          <td><label>STB</label><input type="number" name="stb" class="form-control form-control-sm border border-success" min="0" value="<?php echo $rowa['stb_player']; ?>"></td>
                          <td><label>Mud int</label><input type="number" name="mudanza" class="form-control form-control-sm border border-success" min="0" value="<?php echo $rowa['mudanza_interna_player']; ?>"></td>
                          <?php
                            $rraa = mysqli_query($conn, "SELECT SUM(baja) as 'baja_player' FROM carga_dia WHERE tecnico = '$tecnico' and fecha = '$messi' AND estado = 'no realizado' AND cliente <> '' ");
                            while($rowaa = mysqli_fetch_assoc($rraa))
                            {
                              if($rowaa['baja_player'] == ''){$bajitas = 0;} else {$bajitas = $rowaa['baja_player'];};
                            }
                          ?>
                          <td><label>Bajas</label><input type="number" name="bajas" class="form-control form-control-sm border border-danger" min="0" value="<?php echo $bajitas; ?>"></td>

                          <td><label>Garatias</label><input type="number" name="garantec" class="form-control form-control-sm border border-success" min="0" value="<?php echo $rowa['garantia_player']; ?>"></td>
                          <td><label>Gar Com</label><input type="number" name="garancom" class="form-control form-control-sm border border-success" min="0" value="<?php echo $rowa['garantia_com_player']; ?>"></td>
                          <td><label>Baja tec</label><input type="number" name="bajatec" class="form-control form-control-sm border border-danger" min="0" value="<?php echo $rowa['baja_tecnica_player']; ?>"></td>
                          <td><label>Baja desm</label><input type="number" name="baja_desmonte" class="form-control form-control-sm border border-danger" min="0" value="<?php echo $rowa['baja_desmonte_player']; ?>"></td>
                          <td><label>Mtto int</label><input type="number" name="mtto_int" class="form-control form-control-sm border border-warning" min="0" value="<?php echo $rowa['mtto_player']; ?>"></td>
                          <td><label>Mtto ext</label><input type="number" name="mtto_ext" class="form-control form-control-sm border border-warning" min="0" value="<?php echo $rowa['mtto_externo_player']; ?>"></td>
                          <td><label>Reac</label><input type="number" name="mtto_reaco" class="form-control form-control-sm border border-warning" min="0" value="<?php echo $rowa['reacondicionamiento_player']; ?>"></td>
                        </tr>
                      </form>
                    <?php
                  } 
                ?>
                <?php
                  $result_tasks = mysqli_query($conn, "SELECT * FROM carga_dia WHERE tecnico = '$tecnico' and fecha = '$messi' ORDER BY id asc");
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
                    <td><?php echo $row['ot']; ?></td>
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
                    <td data-toggle="tooltip" data-placement="bottom" title="<?php echo utf8_encode($row['nota_cierre']); ?>"><?php echo limitar_cadena(utf8_encode($row['nota_cierre']),50); ?></td>
                    <td><?php echo $row['revisita']; ?></td>
                    <td <?php if($row['dos_play'] > 0){echo 'class="font-weight-bold text-success"';} ?>><?php echo $row['dos_play']; ?></td>
                    <td <?php if($row['tres_play'] > 0){echo 'class="font-weight-bold text-success"';} ?>><?php echo $row['tres_play']; ?></td> 
                    <td <?php if($row['stb'] > 0){echo 'class="font-weight-bold text-success"';} ?>><?php echo $row['stb']; ?></td> 
                    <td <?php if($row['mudanza_interna'] > 0){echo 'class="font-weight-bold text-success"';} ?>><?php echo $row['mudanza_interna']; ?></td> 
                    <td <?php if($row['baja'] > 0){echo 'class="font-weight-bold text-danger"';} ?>><?php echo $row['baja']; ?></td> 
                    <td <?php if($row['garantia'] > 0){echo 'class="font-weight-bold text-warning"';} ?>><?php echo $row['garantia']; ?></td>
                    <td <?php if($row['garantia_com'] > 0){echo 'class="font-weight-bold text-warning"';} ?>><?php echo $row['garantia_com']; ?></td>
                    <td <?php if($row['baja_tecnica'] > 0){echo 'class="font-weight-bold text-danger"';} ?>><?php echo $row['baja_tecnica']; ?></td>
                    <td <?php if($row['baja_desmonte'] > 0){echo 'class="font-weight-bold text-danger"';} ?>><?php echo $row['baja_desmonte']; ?></td>
                    <td <?php if($row['mtto'] > 0){echo 'class="font-weight-bold text-warning"';} ?>><?php echo $row['mtto']; ?></td>
                    <td <?php if($row['mtto_externo'] > 0){echo 'class="font-weight-bold text-warning"';} ?>><?php echo $row['mtto_externo']; ?></td>
                    <td <?php if($row['reacondicionamiento'] > 0){echo 'class="font-weight-bold text-warning"';} ?>><?php echo $row['reacondicionamiento']; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
              <tfoot class="thead-dark text-center">
                <tr>
                  <th>Codigo</th>
                  <th>TV</th>
                  <th>Actividad</th>
                  <th>OT</th>
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
                  <th>Garantia compañero</th>
                  <th>Baja tecnica</th>
                  <th>Baja con desmonte</th>
                  <th>Mtto interno</th>
                  <th>Mtto externo</th>
                  <th>Reacond</th>
                </tr>
              </tfoot>
            </table>
            <div class="row align-items-center">
              <input type="submit" form="<?php echo $id_tecnico_id; ?>" name="second_produccion" class="btn btn-success btn-block" value="<?php echo 'Guardar el dia de ' .$tecnico; ?>">
            </div>
          </div>
        </div>
      </div>

    <?php
      }
    ?>

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
  <!------Timepicker 1---->
  <script src="../clockpicker.js"></script>
  <script type="text/javascript">
    var input = $('.clockpicker').clockpicker({
      placement: 'bottom',
      align: 'left',
      autoclose: true,
      'default': 'now'});
    </script>
    <!------Timepicker 2---->
  <script src="../clockpicker.js"></script>
  <script type="text/javascript">
      var input = $('.tarea').clockpicker({
      placement: 'bottom',
      align: 'left',
      autoclose: true,
      'default': 'now'});
    </script>
    <!------Timepicker 3---->
  <script src="../clockpicker.js"></script>
  <script type="text/javascript">
      var input = $('.fin').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'});
  </script>
</body>
</html>

