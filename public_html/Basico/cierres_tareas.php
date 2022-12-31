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
<!-- FECHA -->
  <?php
    $as = mysqli_query($conn, "SELECT * FROM cierre_tarea ORDER BY fecha desc LIMIT 1");
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
        <form action="../Guardar/save_fecha.php" method="POST">
          <input type="hidden" name="ultima_fecha" value="<?php echo $ult_fecha; ?>">
          <input type="hidden" name="link" value="../Basico/cierres_tareas.php">
          <input type="hidden" name="dia" value="1">
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
        <form action="../Guardar/save_fecha.php" method="POST">
          <input type="hidden" name="ultima_fecha" value="<?php echo $ult_fecha; ?>">
          <input type="hidden" name="link" value="../Basico/cierres_tareas.php">
          <input type="hidden" name="dia" value="1">
          <button type="submit" name="mas" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Dia siguiente">
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

    <style>
      .imag_carro{
          max-height:85vh;
          max-width:115vh
        }
      @media(max-width: 990px) {
        .imag_carro{
          max-height:20vh;
          max-width:115vh
        }
      }
    </style>

      <div class="row justify-content-center p-1">
        <div class="col-auto text-center">
          <nav>
            <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
              <?php
                $tectec = mysqli_query($conn, "SELECT * FROM cierre_tarea WHERE fecha = '$ult_fecha' GROUP BY tecnico");  
                while($row = mysqli_fetch_assoc($tectec))
                {
                  $ultimo_tecnico = $row['tecnico'];
                  $cierre = mysqli_query($conn, "SELECT * FROM tecnicos WHERE tecnico = '$ultimo_tecnico' ORDER BY tecnico asc");  
                  while($ro = mysqli_fetch_assoc($cierre))
                  {
                    ?>
                      <button class="nav-link" id="nav-<?php echo $ro['tecnico']; ?>-tab" data-toggle="tab" data-target="#nav-<?php echo $ro['token']; ?>" type="button" role="tab" aria-controls="nav-<?php echo $ro['token']; ?>" aria-selected="true"><?php echo $ro['tecnico']; ?></button>
                    <?php
                  }
                }
              ?>
            </div>
          </nav>
          <div class="tab-content" id="nav-tabContent">
              <?php
                $tectec_ul = mysqli_query($conn, "SELECT * FROM cierre_tarea WHERE fecha like '%$fechaultima%' GROUP BY tecnico");  
                while($row = mysqli_fetch_assoc($tectec_ul))
                {
                  $ult_tec = $row['tecnico'];
                  $cierre_resultado = mysqli_query($conn, "SELECT * FROM tecnicos WHERE tecnico = '$ult_tec' ORDER BY tecnico asc");  
                  while($row = mysqli_fetch_assoc($cierre_resultado))
                  {
                    $tecnico = $row['tecnico'];
                    ?>
                      <div class="tab-pane fade" id="nav-<?php echo $row['token']; ?>" role="tabpanel" aria-labelledby="nav-<?php echo $row['token']; ?>-tab">
                        <div class="row justify-content-center p-1">
                          <div class="col-auto">
                            <p class="h4 mb-4 text-center"><?php echo $tecnico; ?></p>
                            <table class="table table-responsive table-striped table-bordered table-sm">
                              <thead class="thead-dark text-center">
                                <tr>
                                  <th>Acciones</th>
                                  <th>OT</th>
                                  <th>Cierre</th>
                                  <th>Zona</th>
                                  <th>Imagenes</th>
                                  <th>Observaciones</th>
                                </tr>
                              </thead>
                              <tbody align="center">
                                <?php
                                  $cierres = mysqli_query($conn, "SELECT * FROM cierre_tarea WHERE tecnico = '$tecnico' AND fecha = '$ult_fecha'");
                                  while($row = mysqli_fetch_assoc($cierres))
                                  {
                                ?>
                                  <tr>
                                    <td>
                                      <button class='btn p-1' data-toggle='modal' data-target='#editar<?php echo $row['id']?>'><i class='fas fa-pen text-warning'></i></button>
                                        <div class="modal fade" id="editar<?php echo $row['id']?>" tabindex="-1" role="dialog" aria-hidden="true">
                                          <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" text-center>Editar cierre</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                <form action="../Editar/edit_cierres.php" method="POST">
                                                  <input type="hidden" name="id" value="<?php echo $row['id']?>">
                                                  <div class="form-row align-items-end">
                                                    <div class="form-group col-md-4 col-12">
                                                      <label>Numero de OT</label >
                                                      <input type="number" name="ot" class="form-control" value="<?php echo $row['ot'] ?>">
                                                    </div>
                                                    <div class="form-group col-md-4 col-12">
                                                      <label>Fecha</label >
                                                      <input type="date" name="fecha" class="form-control" value="<?php echo $row['fecha'] ?>">
                                                    </div>
                                                    <div class="form-group col-md-4 col-12">
                                                      <label>Zona</label >
                                                      <select type="text" name="zona" class="form-control">
                                                        <option selected value="<?php echo $row['zona'] ?>"><?php echo $row['zona'] ?></option>
                                                        <option value="CABA">CABA</option>
                                                        <option value="Jose Leon Suarez">Jose Leon Suarez</option>
                                                        <option value="Lomas de Zamora">Lomas de Zamora</option>
                                                        <option value="San Nicolas">San Nicolas</option>
                                                      </select>
                                                    </div>
                                                  </div>
                                                  <div class="form-row align-items-end">
                                                    <div class="form-group col">
                                                      <label>Observaciones</label >
                                                      <textarea type="text" maxlength="255" name="obs" class="form-control" placeholder="Ingrese el motivo del cierre"><?php echo $row['obs'] ?></textarea>
                                                    </div>
                                                  </div>
                                                  <input type="submit" name="actualizar" class="btn btn-success btn-block" value="Actualizar cierre">
                                                </form>
                                              </div>      
                                            </div>
                                          </div>
                                        </div>
                                      <button class='btn p-1' data-toggle='modal' data-target='#borrar<?php echo $row['token']?>'><i class='fa-regular fa-trash-can text-danger'></i></button>
                                        <div class="modal fade" id="borrar<?php echo $row['token']?>" tabindex="-1" role="dialog" aria-hidden="true">
                                          <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" text-center>Borrar cierre</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <form action="../Borrar/delete_cierres.php" method="POST">
                                                <div class="modal-body">
                                                  <input type="hidden" name="token" value="<?php echo $row['token']?>">
                                                  <div class="form-row align-items-end">
                                                    <div class="form-group col">
                                                      <label>Seguro que quiere borrar la orden <?php echo $row['ot']; ?>?</label >
                                                    </div>
                                                  </div>
                                                  <div class='modal-footer'>
                                                    <button type='button' class='btn btn-danger' data-dismiss='modal'>No</button>
                                                    <input type='submit' name='borrar' class='btn btn-success' value='Si'>
                                                  </div>
                                                </div>
                                              </form>    
                                            </div>
                                          </div>
                                        </div>
                                    </td>
                                    <td><?php echo $row['ot']; ?></td>
                                    <td><span <?php if($row['tipo_tarea'] == 'Exitoso'){echo 'class="badge badge-pill badge-success"';} else {echo 'class="badge badge-pill badge-danger"';} ?>><?php echo $row['tipo_tarea']; ?></span></td>
                                    <td><?php echo $row['zona']; ?></td>
                                    <td>
                                      <div data-toggle="modal" data-target="#imgen<?php echo $row['id']; ?>">
                                        <i class="fa-solid fa-image"></i>
                                      </div>
                                      <div class="modal fade" id="imgen<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title"><?php echo $row['tipo_tarea']; ?></h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="card card-body p-0">
                                              <div id="c_img<?php echo $row['id']; ?>" class="carousel slide" data-ride="carousel">
                                                <div class="row justify-content-center">
                                                  <div class="col-auto">
                                                    <div class="carousel-inner" style="height:80vh;">
                                                      <?php if($row['imagenpri'] !== ''){ ?>
                                                        <div class="carousel-item active">
                                                          <?php if($row['tipo_tarea'] == 'Exitoso')
                                                            {$ruta = '../Archivos/cierre_tarea/exitoso/';
                                                            $titu_foto = 'Equipos instalados';
                                                            $slide = 'Si';}
                                                            else
                                                            {$ruta = '../Archivos/cierre_tarea/fallido/';
                                                            $titu_foto = 'Planila con numero de ticket';
                                                            $slide = 'No';}
                                                          ?>
                                                          <p><?php echo $titu_foto; ?></p>
                                                          <div class="row justify-content-center">
                                                            <div class="col-auto">
                                                              
                                                              <img class="imag_carro" src="<?php echo $ruta .$row['imagenpri']; ?>" alt="<?php echo $row['imagenpri']; ?>">
                                                            </div>
                                                          </div>
                                                        </div>
                                                      <?php } ?>
                                                      <?php if($row['imagenseg'] !== ''){ ?>
                                                        <div class="carousel-item">
                                                          <p>Interior engrampado</p>
                                                          <div class="row justify-content-center">
                                                            <div class="col-auto">
                                                              <img class="imag_carro" src="../Archivos/cierre_tarea/exitoso/<?php echo $row['imagenseg']; ?>" alt="<?php echo $row['imagenpri']; ?>">
                                                            </div>
                                                          </div>
                                                        </div>
                                                      <?php } ?>
                                                      <?php if($row['imagenter'] !== ''){ ?>
                                                        <div class="carousel-item">
                                                          <p>Punto de retencion de acometida</p>
                                                          <div class="row justify-content-center">
                                                            <div class="col-auto">
                                                              <img class="imag_carro" src="../Archivos/cierre_tarea/exitoso/<?php echo $row['imagenter']; ?>" alt="<?php echo $row['imagenpri']; ?>">
                                                            </div>
                                                          </div>
                                                        </div>
                                                      <?php } ?>
                                                    </div>
                                                  </div>
                                                </div>
                                                <?php
                                                  // Si es fallido no mostrar botones
                                                  if($slide == 'No')
                                                  { echo '';}
                                                  else
                                                  {
                                                ?>
                                                  <button class="carousel-control-prev" type="button" data-target="#c_img<?php echo $row['id']; ?>" data-slide="prev" style="opacity: 1 !important; width: 45%; background-color: rgb(255 255 255 / 0%) !important; border:none !important; justify-content: flex-start !important">
                                                    <i class="fa-solid fa-caret-left text-dark p-2"></i>
                                                  </button>
                                                  <button class="carousel-control-next" type="button" data-target="#c_img<?php echo $row['id']; ?>" data-slide="next" style="opacity: 1 !important; width: 45%; background-color: rgb(255 255 255 / 0%) !important; border:none !important; justify-content: flex-end !important">
                                                    <i class="fa-solid fa-caret-right text-dark p-2"></i>
                                                  </button>
                                                <?php } ?>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </td>
                                    <td><?php echo $row['obs']; ?></td>
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
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>