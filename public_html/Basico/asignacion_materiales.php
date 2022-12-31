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
<!-----Deposito---->
<?php include('../includes/header.php'); ?>

<!-- FECHA -->
<?php
    $as = mysqli_query($conn, "SELECT * FROM asignacion_material ORDER BY fecha desc LIMIT 1");
    while($row = mysqli_fetch_assoc($as))
    {
      $ult_fecha = $row['fecha'];
    }
    if(isset($_GET['dia']))
    {
      $desencriptado = $_GET['dia'];
      $ult_fecha = base64_decode($desencriptado);
    }
  ?>
  <div class="container-fluid pr-4 pl-4 pt-0 pb-0">
    <div class="row justify-content-center pr-2 pl-2 pt-2 pb-0">
      <div class="col-auto align-self-center p-0">
        <form action="../Guardar/save_asignacion.php" method="POST">
          <input type="hidden" name="ultima_fecha" value="<?php echo $ult_fecha; ?>">
          <button type="submit" name="menos" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Dia anterior">
            <i class="fa-solid fa-caret-left"></i>
          </button>
        </form>
      </div>
      <div class="col-auto align-self-center text-center text-white">
        <span><?php 
          /* FECHA INICIO */
            $fecha_desc = date("l j m Y", strtotime($ult_fecha));

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
            echo $dia_mm .' ' .$dia_numero .' de ' .$mes_mm ;
          /* FECHA INICIO */
        ?></span>
      </div>
      <div class="col-auto align-self-center p-0">
        <form action="../Guardar/save_asignacion.php" method="POST">
          <input type="hidden" name="ultima_fecha" value="<?php echo $ult_fecha; ?>">
          <button type="submit" name="mas" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Dia siguiente">
            <i class="fa-solid fa-caret-right"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
<!-- FECHA -->
<?php
  if($zona_us == 'Todo')
  {$resu = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE fecha = '$ult_fecha' AND tipo = 'Asignacion' GROUP BY tecnico");}
  else
  {$resu = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE fecha = '$ult_fecha' AND deposito = '$zona_us' AND tipo = 'Asignacion' GROUP BY tecnico");}  //////ARRAY DE ULTIMOS TECNICOS
  while($row = mysqli_fetch_assoc($resu))
  {
    $array[] = $row['tecnico']; /////guarda resultados en un array Array ( [0] => Brian Flores [1] => Carlos Da Silva [2] => Cristian Caro [3] => Leandro Vaca [4] => Mauro Ramirez [5] => Ricardo Romero [6] => Ruben Gaette Lopez )
  }
?>
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">
      <div class="row justify-content-center p-1">
        <div class="col p-2">
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
        </div>
      </div>

      <div class="row justify-content-center p-1">
        <h4 class="modal-title" text-center>Asignacion de materiales</h4>
      </div>

      <div class="row justify-content-center p-1">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#asignacion">
          +
        </button> 
      </div>

      <div class="row justify-content-center p-1">
        <div class="col-5 col-sm-5 p-1">
          <div class="row justify-content-center p-1 pr-3">
            <button type="button" class="btn btn-info p-2 m-2" data-toggle="modal" data-target="#no_seriado">
              <i class="fa-solid fa-box-open"></i>
            </button>
            <button type="button" class="btn btn-info p-2 m-2" data-toggle="modal" data-target="#seriado_sn">
              <i class="fa-solid fa-barcode"></i>
            </button>
          </div>
        </div>
      </div>

      <?php if($tipo_us == 'Administrador' && $zona_us == 'Todo') { ?>
      <style>
        @media all and (min-width: 991px) {
        .sugerido_nuevo
          {
            top: 64%;
          }
        .sugerido
          {
            top: 94%;
          }
        }

        @media all and (min-width: 768px) and (max-width: 990px) {
          .sugerido
          {
            top: 94%;
          }
        .sugerido_nuevo
          {
            top: 72.5%;
          }
        }

        @media all and (max-width: 767px) {
          .sugerido
          {
            top: 95.8%;
          }
        .sugerido_nuevo
          {
            top: 78%;
          }
        }
      </style> 
      <?php } else { ?>
      <style>
        .sugerido
          {
            top: 94%;
          }
        .sugerido_nuevo
          {
            top: 90.5%;
          }
      </style>
      <?php } ?>
      <style>
        .sugerido
          {
            box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2);
            height: auto;
            position: absolute;
            z-index: 10;
            width: auto;
            left: 17px;
          }

        .sugerido .suggest-element
          {
            background-color: #ffffff;
            border-top: 1px solid #d6d4d4;
            cursor: pointer;
            padding: 5px;
            width: 100%;
            float: left;
          }
        .sugerido .suggest-element:hover
          {
            background-color: #bfe9c5;
          }    
      </style>
      <style>
        .sugerido_nuevo
          {
            box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2);
            height: auto;
            position: absolute;
            z-index: 10;
            width: auto;
            left: 32px;
          }

        .sugerido_nuevo .suggest-element
          {
            background-color: #ffffff;
            border-top: 1px solid #d6d4d4;
            cursor: pointer;
            padding: 5px;
            width: 100%;
            float: left;
          }
        .sugerido_nuevo .suggest-element:hover
          {
            background-color: #bfe9c5;
          }
      </style>
      <!-- MODAL ASIGNACION -->
        <div class="modal fade" id="asignacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" text-center>Asignacion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="../Guardar/save_asignacion.php" method="POST" data-toggle="validator">
                    <?php if($tipo_us == 'Administrador' && $zona_us == 'Todo') { ?>
                      <div class="form-row">
                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                          <label for="exampleFormControlSelect1">Tecnico</label>
                          <select type="text" name="tecnico" class="form-control" required>
                            <option selected disabled value="">Tecnico...</option>
                            <?php
                              $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE tipo = 'Tecnico' AND activo ='SI' ORDER BY tecnico asc");
                              foreach ($ejecutar as $opciones):
                            ?>   
                              <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                            <?php endforeach ?>
                          </select>
                        </div>
                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                          <label for="exampleFormControlSelect1">Fecha</label >
                          <input type="date" name="fecha"  class="form-control" required>
                        </div>
                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                          <label for="exampleFormControlSelect1">Deposito</label>
                          <select type="text" id="zona" name="zona" class="form-control" required>
                            <option selected disabled value="">Deposito...</option>
                            <?php
                              $consulta="SELECT DISTINCT deposito FROM asignacion_material WHERE tipo = 'Precarga' GROUP BY deposito ";
                              $ejecutar=mysqli_query($conn,$consulta) or die (mysqli_error($conn));
                            ?>
                            <?php foreach ($ejecutar as $opciones): ?>   
                              <option value="<?php echo $opciones['deposito'] ?>"><?php echo $opciones['deposito'] ?></option>                                      
                            <?php endforeach ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col" id="material">
                        </div>
                      </div>
                      <table class="table p-0"  id="tabla">
                        <tr class="fila-fija">
                          <td><input class="search_query form-control selec_equipo_nuevo" type="text" name="seriado[]" placeholder="Buscar equipo..." id="seriado" autofocus /></td>
                          <td class="eliminar" hidden><input class="btn btn-outline-danger" type="button" value="Borrar"/></td>
                        </tr>
                        <div class="sugerido_nuevo" id="suggestions"></div>
                      </table>
                      
                    <?php }  else {?>
                      <div class="form-row">
                        <div class="form-group col">
                          <label for="exampleFormControlSelect1">Tecnico</label>
                          <select type="text" name="tecnico" class="form-control" required>                
                            <option selected disabled value="">Tecnico...</option>               
                            <?php
                              $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE tipo = 'Tecnico' AND activo ='SI' AND deposito = '$zona_us' ORDER BY tecnico asc");
                              foreach ($ejecutar as $opciones):
                            ?>   
                              <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                            <?php endforeach ?>
                          </select>
                        </div>
                        <div class="form-group col">
                          <label for="exampleFormControlSelect1">Fecha</label >
                          <input type="date" name="fecha"  class="form-control" required>
                        </div>
                        <input type="hidden" name="zona" value="<?php echo $zona_us; ?>" >
                      </div>
                      <div class="form-row">
                        <div class="form-group col" id="material">
                          <?php
                            $consulta_mat="SELECT * FROM asignacion_material WHERE tipo = 'Precarga' AND deposito = '$zona_us' ORDER BY material desc ";
                            $ejecut=mysqli_query($conn,$consulta_mat);
                            foreach ($ejecut as $op_mat):
                            $sapp = $op_mat['sap'];
                            echo'<div class="form-row">
                              <div class="form-group col-10">
                                <input type="hidden" name="material[]" value="' .$op_mat['material'] .'">
                                <input type="hidden" name="sap[]" value="' .$op_mat['sap'] .'">
                                <label for="exampleFormControlSelect1">' .utf8_encode($op_mat['material']) .'</label >
                              </div>
                              <div class="form-group col-2">
                                <input type="number" name="cantidad[]" class="form-control" value="' .$op_mat['cantidad'] .'" required>
                              </div>
                            </div>';
                          endforeach; ?>
                        </div>
                      </div>
                      <table class="table p-0"  id="tabla">
                        <tr class="fila-fija">
                          <td><input class="search_query form-control selec_equipo_nuevo" type="text" name="seriado[]" placeholder="Buscar equipo..." id="seriado" autofocus /></td>
                          <td class="eliminar" hidden><input class="btn btn-outline-danger" type="button" value="Borrar"/></td>
                        </tr>
                        <div class="sugerido_nuevo" id="suggestions"></div>
                      </table>
                    <?php } ?>
                  <div class="form-row p-2">
                    <input type="submit" name="save_tecnicos" class="btn btn-success btn-block" value="Guardar asignacion">
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      <!-- MODAL ASIGNACION -->

      <br>
      <!-- TACHADO -->
        <style>
          :root { --del-color: #F56F84;}
          del 
          {
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
        <div class="container p-0">
          <div class="row justify-content-center p-1">
            <div class="col-auto">
              <?php
                if($zona_us == 'Todo')
                {$consulta_tec = mysqli_query($conn, "SELECT * FROM tecnicos WHERE activo = 'SI' AND tipo = 'Tecnico' ORDER BY tecnico asc");}
                else
                {$consulta_tec = mysqli_query($conn, "SELECT * FROM tecnicos WHERE activo = 'SI' AND tipo = 'Tecnico' AND zona = '$zona_us' ORDER BY tecnico asc");}  
                while($row = mysqli_fetch_assoc($consulta_tec))
                {
                  $tec = $row['tecnico']; /////guarda los resultados de la consulta en la variable $tec
                  if (in_array($tec, $array)) ////buscame el valor de $tec en la lista de $array
                  {
                    echo '<del> ' .$tec .' </del> - '; //// si encontro resultado agrega <del></del>
                  }
                  else{ //////si no lo encuentra solo mostralos en pantalla
                    echo ' ' .$tec .' - ';
                  }
                }
              ?>
            </div>
          </div>
        </div>
        <br>
      <!-- TACHADO -->  
      
      <?php if($tipo_us == 'Administrador' && $zona_us == 'Todo') { ?>
        <!-- US ADMIN -->
        <div class="row justify-content-center p-1">
          <div class="col-auto">
            <!-- DEPOSITOS -->
              <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                <?php
                  $query_mat = "SELECT * FROM asignacion_material WHERE fecha = '$ult_fecha' GROUP BY tecnico";
                  $result_mat = mysqli_query($conn, $query_mat);
                  while($row = mysqli_fetch_assoc($result_mat)) { 
                ?>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tec" data-toggle="tab" href="#tec_num_<?php echo $row['id_tec'] ; ?>" role="tab" aria-controls="tec_num_<?php echo $row['id_tec'] ; ?>" aria-selected="true"><?php echo $row['tecnico'] ; ?></a>
                  </li>
                <?php } ?>
              </ul>
              <div class="tab-content" id="myTabContent">
                <!-- CONTENIDO -->
                  <?php 
                    $query_mat = "SELECT * FROM asignacion_material WHERE fecha = '$ult_fecha' AND tipo = 'Asignacion' GROUP BY tecnico";
                    $result_mat = mysqli_query($conn, $query_mat);
                    while($row = mysqli_fetch_assoc($result_mat))
                    { 
                      $tectec =  $row['tecnico'];
                      $totoken =  $row['token'];
                  ?>
                    <div class="tab-pane fade" id="tec_num_<?php echo $row['id_tec'] ; ?>" role="tabpanel" aria-labelledby="tec">
                      <div class="row justify-content-center">
                        <div class="col-auto">
                          <table class="table table-responsive table-striped table-bordered table-sm">
                            <thead class="thead-dark text-center">
                              <tr>
                                <th colspan="3">
                                  <div class="row">
                                    <div class="col-9">
                                      <?php echo $tectec; ?>
                                    </div>
                                    <div class="col-3">
                                      <i type="button" class="far fa-trash-alt btn-danger borrardia mr-4" data-toggle="modal" data-target="#modal_msj"  data-token="<?php echo $totoken; ?>" data-tec="<?php echo $tectec; ?>"></i>
                                      <a href="./asignacion_pdf.php?token=<?php echo $totoken; ?>" target="_blank"><i class="fa-regular fa-file-lines text-light"></i></a>
                                    </div>
                                  </div>
                                </th>
                              </tr>
                              <tr>
                                <th>Material</th>
                                <th>Cantidad</th>
                                <th>Accion</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $result_tectec = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE tecnico = '$tectec' AND fecha = '$ult_fecha' AND tipo = 'Asignacion' ORDER BY material asc");
                                while($row = mysqli_fetch_assoc($result_tectec))
                                {
                              ?>
                                <tr>
                                  <?php if($row['seriado'] !== '' ) { ?>
                                    <td class="text-start"><?php echo $row['seriado']; ?></td>
                                  <?php } else {?>
                                    <td class="text-start"><?php echo utf8_encode(utf8_decode($row['material'])); ?></td>
                                  <?php } ?>
                                  <td class="text-center"><?php echo $row['cantidad']; ?></td>
                                  <td>
                                    <button class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#editarr_<?php echo $row['id']; ?>" >Editar</button>
                                    <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#borrarr_<?php echo $row['id']; ?>" >Borrar</button>
                                    <button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#tranferirr_<?php echo $row['id']; ?>" >Transferir</button>
                                      <!-- Editar -->
                                        <div class="modal fade" id="editarr_<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <form method="POST" action="../Editar/edit_asignado.php?id=<?php echo $row['id']; ?>">
                                                <div class="modal-header">
                                                  <h5 class="modal-title">Editar (<span><?php echo $row['tecnico']; ?></span>)</h5>
                                                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>                  
                                                <div class="modal-body">
                                                  <input type="hidden" name="token" value="<?php echo $row['id']; ?>">
                                                  <div class="form-row align-items-end">
                                                    <div class="form-group col-10">
                                                      <label><?php echo $row['material']; ?></label>
                                                    </div>
                                                    <div class="form-group col-2">
                                                      <input type="number" name="cantidad" min="1" class="form-control" required value="<?php echo $row['cantidad']; ?>">
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="modal-footer">
                                                  <input type="submit" name="editar" class="btn btn-warning" value="Editar">
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                      <!-- Editar -->
                                      <!-- Borrar material -->
                                        <div class="modal fade" id="borrarr_<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <form method="POST" action="../Editar/edit_asignado.php?id=<?php echo $row['id']; ?>">
                                                <div class="modal-header">
                                                  <h5 class="modal-title">Borrar (<span><?php echo $row['tecnico']; ?></span>)</h5>
                                                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>        
                                                <div class="modal-body">
                                                  <span>Seguro que quiere borrar </span><span><?php echo $row['material']; ?></span><span>?</span>
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                                  <input type="submit" name="borrar" class="btn btn-success" value="Si">
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                      <!-- Borrar -->
                                      <!-- Transferir -->
                                        <div class="modal fade" id="tranferirr_<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <form method="POST" action="../Editar/edit_asignado.php?id=<?php echo $row['id']; ?>">
                                                <div class="modal-header">
                                                  <h5 class="modal-title">Transferir (<span><?php echo $row['tecnico']; ?></span>)</h5>
                                                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>                  
                                                <div class="modal-body">
                                                  <div class="form-row">
                                                    <div class="form-group col-12">
                                                      <label>Transferir a...</label>
                                                      <select type="text" name="tecnico" class="form-control" required>
                                                        <option disabled selected value="">Tecnicos...</option>                
                                                        <?php
                                                          $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                                                          foreach ($ejecutar as $opciones):
                                                        ?>   
                                                          <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                                                        <?php endforeach ?>
                                                      </select>
                                                    </div>
                                                  </div>
                                                  <div class="form-row">
                                                    <div class="form-group col-10">
                                                      <label><?php echo $row['material']; ?></label>
                                                    </div>
                                                    <div class="form-group col-2">
                                                      <input type="number" name="cantidad" min="1" class="form-control" required value="<?php echo $row['cantidad']; ?>">
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="modal-footer">
                                                  <input type="submit" name="transferir" class="btn btn-primary" value="Transferir">
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                      <!-- Transferir -->
                                  </td>
                                </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                <!-- CONTENIDO -->
              </div>
            <!-- DEPOSITOS -->
          </div>
        </div>
        <!-- US ADMIN -->
      <?php } else { ?>
        <!-- US DEPOSITO -->
          <div class="row justify-content-center p-1">
            <div class="col-auto">
              <!-- DEPOSITOS -->
                <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                  <?php
                    $query_mat = "SELECT * FROM asignacion_material WHERE fecha = '$ult_fecha' AND deposito = '$zona_us' AND tipo = 'Asignacion' GROUP BY tecnico";
                    $result_mat = mysqli_query($conn, $query_mat);
                    while($row = mysqli_fetch_assoc($result_mat)) { 
                  ?>
                    <li class="nav-item" role="presentation">
                      <a class="nav-link" id="tec" data-toggle="tab" href="#tec_num_<?php echo $row['id_tec'] ; ?>" role="tab" aria-controls="tec_num_<?php echo $row['id_tec'] ; ?>" aria-selected="true"><?php echo $row['tecnico'] ; ?></a>
                    </li>
                  <?php } ?>
                </ul>
                <div class="tab-content" id="myTabContent">
                  <!-- CONTENIDO -->
                    <?php 
                      $query_mat = "SELECT * FROM asignacion_material WHERE fecha = '$ult_fecha' AND tipo = 'Asignacion' AND deposito = '$zona_us' GROUP BY tecnico";
                      $result_mat = mysqli_query($conn, $query_mat);
                      while($row = mysqli_fetch_assoc($result_mat))
                      { 
                        $tectec =  $row['tecnico'];
                        $totoken =  $row['token'];
                    ?>
                      <div class="tab-pane fade" id="tec_num_<?php echo $row['id_tec'] ; ?>" role="tabpanel" aria-labelledby="tec">
                        <div class="row justify-content-center">
                          <div class="col-auto">
                            <table class="table table-responsive table-striped table-bordered table-sm">
                              <thead class="thead-dark text-center">
                                <tr>
                                  <th colspan="3">
                                    <div class="row">
                                      <div class="col-9">
                                        <?php echo $tectec; ?>
                                      </div>
                                      <div class="col-3">
                                        <i type="button" class="far fa-trash-alt btn-danger borrardia mr-4" data-toggle="modal" data-target="#modal_msj"  data-token="<?php echo $totoken; ?>" data-tec="<?php echo $tectec; ?>"></i>
                                        <a href="./asignacion_pdf.php?token=<?php echo $totoken; ?>" target="_blank"><i class="fa-regular fa-file-lines text-light"></i></a>
                                      </div>
                                    </div>
                                  </th>
                                </tr>
                                <tr>
                                  <th>Material</th>
                                  <th>Cantidad</th>
                                  <th>Accion</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                  $result_tectec = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE tecnico = '$tectec' AND fecha = '$ult_fecha' AND tipo = 'Asignacion' AND deposito = '$zona_us' ORDER BY material asc");
                                  while($row = mysqli_fetch_assoc($result_tectec))
                                  {
                                ?>
                                  <tr>
                                    <?php if($row['seriado'] !== '' ) { ?>
                                      <td class="text-start"><?php echo $row['seriado']; ?></td>
                                    <?php } else {?>
                                      <td class="text-start"><?php echo utf8_encode(utf8_decode($row['material'])); ?></td>
                                    <?php } ?>
                                    <td class="text-center"><?php echo $row['cantidad']; ?></td>
                                    <td>
                                      <button class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#editar_<?php echo $row['id']; ?>" >Editar</button>
                                      <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#borrar_<?php echo $row['id']; ?>" >Borrar</button>
                                      <button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#tranferir_<?php echo $row['id']; ?>" >Transferir</button>
                                      <!-- Editar -->
                                        <div class="modal fade" id="editar_<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <form method="POST" action="../Editar/edit_asignado.php?id=<?php echo $row['id']; ?>">
                                                <div class="modal-header">
                                                  <h5 class="modal-title">Editar (<span><?php echo $row['tecnico']; ?></span>)</h5>
                                                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>                  
                                                <div class="modal-body">
                                                  <input type="hidden" name="token" value="<?php echo $row['id']; ?>">
                                                  <div class="form-row align-items-end">
                                                    <div class="form-group col-10">
                                                      <label><?php echo $row['material']; ?></label>
                                                    </div>
                                                    <div class="form-group col-2">
                                                      <input type="number" name="cantidad" min="1" class="form-control" required value="<?php echo $row['cantidad']; ?>">
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="modal-footer">
                                                  <input type="submit" name="editar" class="btn btn-warning" value="Editar">
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                      <!-- Editar -->
                                      <!-- Borrar material -->
                                        <div class="modal fade" id="borrar_<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <form method="POST" action="../Editar/edit_asignado.php?id=<?php echo $row['id']; ?>">
                                                <div class="modal-header">
                                                  <h5 class="modal-title">Borrar (<span><?php echo $row['tecnico']; ?></span>)</h5>
                                                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>        
                                                <div class="modal-body">
                                                  <span>Seguro que quiere borrar </span><span><?php echo $row['material']; ?></span><span>?</span>
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                                  <input type="submit" name="borrar" class="btn btn-success" value="Si">
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                      <!-- Borrar -->
                                      <!-- Transferir -->
                                        <div class="modal fade" id="tranferir_<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <form method="POST" action="../Editar/edit_asignado.php?id=<?php echo $row['id']; ?>">
                                                <div class="modal-header">
                                                  <h5 class="modal-title">Transferir (<span><?php echo $row['tecnico']; ?></span>)</h5>
                                                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>                  
                                                <div class="modal-body">
                                                  <div class="form-row">
                                                    <div class="form-group col-12">
                                                      <label>Transferir a...</label>
                                                      <select type="text" name="tecnico" class="form-control" required>
                                                        <option disabled selected value="">Tecnicos...</option>                
                                                        <?php
                                                          $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                                                          foreach ($ejecutar as $opciones):
                                                        ?>   
                                                          <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                                                        <?php endforeach ?>
                                                      </select>
                                                    </div>
                                                  </div>
                                                  <div class="form-row">
                                                    <div class="form-group col-10">
                                                      <label><?php echo $row['material']; ?></label>
                                                    </div>
                                                    <div class="form-group col-2">
                                                      <input type="number" name="cantidad" min="1" class="form-control" required value="<?php echo $row['cantidad']; ?>">
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="modal-footer">
                                                  <input type="submit" name="transferir" class="btn btn-primary" value="Transferir">
                                                </div>
                                              </form>
                                            </div>
                                          </div>
                                        </div>
                                      <!-- Transferir -->
                                    </td>
                                  </tr>
                                <?php } ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  <!-- CONTENIDO -->
                </div>
              <!-- DEPOSITOS -->
            </div>
          </div>
        <!-- US DEPOSITO -->
      <?php } ?>
    </div>
  </div>
</div>

<!-- No seriado -->
  <div class="modal fade" id="no_seriado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="../Editar/edit_asignado.php" method="POST">
          <div class="modal-header">
            <h5 class="modal-title">Asignar material no seriado</h5>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
          </div>                  
          <div class="modal-body">
            <div class="form-row">
              <div class="form-group col-md-6 col-12">
                <label>Tecnico...</label>
                <select type="text" name="tecnico" class="form-control" required>
                  <option disabled selected value="">Tecnicos...</option>                
                  <?php
                    $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                    foreach ($ejecutar as $opciones):
                  ?>   
                    <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                  <?php endforeach ?>
                </select>
              </div>
              <?php if($tipo_us == 'Administrador' && $zona_us == 'Todo') { ?>
              <div class="form-group col-md-6 col-12">
                <label for="exampleFormControlSelect1">Fecha</label >
                <input type="date" name="fecha"  class="form-control" required>
              </div>
              <div class="form-group col-12">
                <label for="exampleFormControlSelect1">Deposito</label>
                <select type="text" id="select_mat" name="zona" class="form-control" required>                
                  <option selected disabled value="">Deposito...</option>
                  <?php
                    $consulta="SELECT DISTINCT deposito FROM asignacion_material WHERE tipo = 'Precarga' GROUP BY deposito ";
                    $ejecutar=mysqli_query($conn,$consulta) or die (mysqli_error($conn));
                  ?>
                  <?php foreach ($ejecutar as $opciones): ?>   
                    <option value="<?php echo $opciones['deposito'] ?>"><?php echo $opciones['deposito'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
            <div class="form-row" id="matmat">
            </div>
            <?php } else { ?>
              <input type="hidden" name="zona" value="<?php echo $zona_us; ?>" >
              <div class="form-group col-md-6 col-12">
                <label for="exampleFormControlSelect1">Fecha</label >
                <input type="date" name="fecha"  class="form-control" required>
              </div>
            </div>
              <div class="form-row">
                <div class="form-group col-10">
                    <select type="text" name="material" class="form-control" required>
                      <option disabled selected>Material...</option>                
                      <?php
                        $ejecutar=mysqli_query($conn,"SELECT * FROM asignacion_material WHERE tipo = 'Precarga' AND seriado = '' AND deposito = '$zona_us' GROUP BY material ORDER BY material asc");
                        foreach ($ejecutar as $opciones):
                      ?>   
                        <option value="<?php echo $opciones['material'] ?>"><?php echo utf8_encode($opciones['material']) ?></option>                                      
                      <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group col-2">
                  <input type="number" name="cantidad" min="1" class="form-control" required>
                </div>
              </div>
            <?php } ?>
          </div>
          <div class="modal-footer">
            <input type="submit" name="cargar" class="btn btn-success" value="Cargar">
          </div>
        </form>
      </div>
    </div>
  </div>
<!-- No seriado -->
<!-- Seriado -->
  <div class="modal fade" id="seriado_sn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="../Editar/edit_asignado.php" method="POST">
          <div class="modal-header">
            <h5 class="modal-title">Asignar material seriado</h5>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
          </div>                  
          <div class="modal-body">
            <div class="form-row">
              <div class="form-group col-md-6 col-12">
                <label>Tecnico...</label>
                <select type="text" name="tecnico" class="form-control" required>
                  <option disabled selected value="">Tecnicos...</option>                
                  <?php
                    $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                    foreach ($ejecutar as $opciones):
                  ?>   
                    <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group col-md-6 col-12">
                <label for="exampleFormControlSelect1">Fecha</label >
                <input type="date" name="fecha"  class="form-control" required>
              </div>
              <?php if($tipo_us == 'Administrador' && $zona_us == 'Todo') { ?>
                <div class="form-group col-12">
                  <label for="exampleFormControlSelect1">Deposito</label>
                  <select type="text" name="zona" class="form-control" required>                
                    <option selected disabled value="">Deposito...</option>
                    <?php
                      $consulta="SELECT DISTINCT deposito FROM asignacion_material WHERE tipo = 'Precarga' GROUP BY deposito ";
                      $ejecutar=mysqli_query($conn,$consulta) or die (mysqli_error($conn));
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?>   
                      <option value="<?php echo $opciones['deposito'] ?>"><?php echo $opciones['deposito'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              <?php } else { ?>
                <input type="hidden" name="zona" value="<?php echo $zona_us; ?>" class="form-control">
              <?php } ?>
            </div>
            <!-- SERIADOS -->
              <div class="form-row">
                <div class="col-12">
                  <input class="search_query form-control selec_equipo" type="text" name="seriado" placeholder="Buscar equipo..." required>
                </div>
                <div class="sugerido" id="suggestions"></div>
              </div>
            <!-- SERIADOS -->
          </div>
          <div id="final" class="modal-footer" hidden>
            <input type="submit" name="cargar_sn" class="btn btn-success" value="Cargar">
          </div>
        </form>
      </div>
    </div>
  </div>
<!-- Seriado -->
<!-- Borrar todo el dia -->
  <div class="modal fade" id="modal_msj">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      <form method="POST" action="../Editar/edit_asignado.php">
        <div class="modal-header">
          <h5 class="modal-title">Eliminar asignacion</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>                  
          <div class="modal-body">
            <input type="hidden" id="token" name="token">
            <span>Seguro que quiere eliminar la asignacion de </span><span id="borrar_dia_tec"></span>?</span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger ml-4" data-dismiss="modal">No</button>
            <input type="submit" name="borrar_dia" class="btn btn-success ml-4" value="Si">            
          </div>
        </form>
      </div>
    </div>
  </div>
  
<!-- Borrar todo el dia -->

<!-- PIE DE PAGINA -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- then Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
	$(document).ready(function(){
		$('#zona').on('change',function(){  /* #ID */
		var parametros= "zona="+$(this).val();
		$.ajax({
				data:  parametros,
				url:   '../Ajax/a_asignacion.php',
				type:  'post',
				beforeSend: function () { },
				success:  function (response) { 
					$("#material").html(response);
					$('#material').on('change',function(){
		})
				},
				error:function(){
					alert("error")
				}
			});
		})
	})
</script>
<script>
	$(document).ready(function(){
		$('#select_mat').on('change',function(){
		var parametros= "zona="+$(this).val();
		$.ajax({
				data:  parametros,
				url:   '../Ajax/a_mat.php',
				type:  'post',
				beforeSend: function () { },
				success:  function (response) { 
					$("#matmat").html(response);
					$('#matmat').on('change',function(){
		})
				},
				error:function(){
					alert("error")
				}
			});
		})
	})
</script>
<script>
  $(document).ready(function()
  {
    $('.selec_equipo').on('keyup', function() /* CUANDO EN LA CLASE "selec_equipo" */
    {
      var key = $(this).val();
      var dato = $(this); /* GUARDAR EN LA VARIABLE "dato" EL ELEMENTO "selec_equipo" */
      var dataString = 'key='+key; /* GAURDAR EN LA VARIABLE "key" EL VALOR DE "selec_equipo" */
      if(key == "")
      {
        //Hacemos desaparecer el resto de sugerencias cuando no halla nada escrito
        $(".selec_equipo").removeClass("is-invalid");
        $(".selec_equipo").removeClass("is-valid");
        $("#final").attr('hidden','hidden');
      }
      else
      {
        $.ajax({
          type: "POST",
          url: "../Ajax/a_seriados2.php",
          data: dataString,
          success: function(data) {
            if(data=='si')
            {
              $(".selec_equipo").addClass("is-valid");
              $(".selec_equipo").removeClass("is-invalid");
              $("#final").removeAttr('hidden');
            }
            else
            {
              $(".selec_equipo").addClass("is-invalid");
              $(".selec_equipo").removeClass("is-valid");
              $("#final").attr('hidden','hidden');
            }
          }
        });
      };
    });
  }); 
</script>
<script>
  $(document).ready(function()
  {
    $('.selec_equipo_nuevo:eq(0)').on('keyup', function() /* CUANDO EN LA CLASE "selec_equipo_nuevo" */
    {
      var key = $(this).val(); /* GAURDAR EN LA VARIABLE "key" EL VALOR DE "selec_equipo_nuevo" */
      var dato = $(this); /* GUARDAR EN LA VARIABLE "dato" EL ELEMENTO "selec_equipo_nuevo" */
      var dataString = 'key='+key;
      if(key == "")
      {
        $(".selec_equipo_nuevo:eq(0)").removeClass("is-valid");
        $(".selec_equipo_nuevo:eq(0)").removeClass("is-invalid");
      }
      else
      {
        $.ajax({
          type: "POST",
          url: "../Ajax/a_seriados2.php",
          data: dataString,
          success: function(data) {
            if(data=='si')
            {
              if($('.selec_equipo_nuevo:eq(0)').val() != "")
              {
                $("#tabla tbody tr:eq(0)").clone().removeClass('fila-fija').appendTo("#tabla").removeAttr('autofocus');
                $(".selec_equipo_nuevo:eq(0)").val(''); ////limpia el input
                $(".selec_equipo_nuevo").addClass("is-valid").attr('readonly', 'readonly');
                $(".selec_equipo_nuevo").removeClass("is-invalid");
                $(".selec_equipo_nuevo:eq(0)").removeClass("is-valid");
                $(".selec_equipo_nuevo:eq(0)").removeAttr('readonly');
                $(".selec_equipo_nuevo:eq(0)").attr('autofocus','autofocus');
                $(".eliminar").removeAttr('hidden'); ///Elimino el atributo hhiden
                $(".eliminar:eq(0)").attr('hidden','hidden'); ///Agrego el atributo hidden solo a la primera clase "elimniar"
                return false;
              }
            }
            else
            {
              $(".selec_equipo_nuevo:eq(0)").addClass("is-invalid");
              $(".selec_equipo_nuevo:eq(0)").removeClass("is-valid");
            }
          }
        });
      };
    });

    $(document).on("click",".eliminar",function(){
      var parent = $(this).parents().get(0);
      if ($('.eliminar').length > 1)
      {
        $(parent).remove();
      }
    });

  }); 
</script>
<script>
  $(document).ready(function() {
    $('.selec_equipo_nuevo').keypress(function(e){
      if(e.which == 13){
        return false;
      }
    });
  });
  $(document).ready(function() {
    $('.selec_equipo').keypress(function(e){
      if(e.which == 13){
        return false;
      }
    });
  });
</script>
<script>
    window.onload=()=>{
      const botones= document.querySelectorAll('.borrardia');
      botones.forEach( el=>el.addEventListener('click',evt=>{
        var token=evt.target.getAttribute('data-token');
        document.getElementById('token').value =token;
        var tecni=evt.target.getAttribute('data-tec');
        document.getElementById('borrar_dia_tec').textContent = tecni;
      }))
    };
  </script>
</body>
</html>