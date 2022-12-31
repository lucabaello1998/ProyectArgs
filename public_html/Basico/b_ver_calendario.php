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
  $quien_us = $nombre ." " .$apellido;
  if($tipo == "Administrador") { $usu = 1; }
  if($tipo == "Despacho") { $usu = 1; }
  if($tipo == "Supervisor") { $usu = 1; }
  if($tipo == "Deposito") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
  }

  if(isset($_GET['token']))
  {
    $token = $_GET['token'];
    $qu_dt = "SELECT * FROM calendario WHERE token = '$token'";
    $res_dt = mysqli_query($conn, $qu_dt);
    if (mysqli_num_rows($res_dt) == 1)
    {
      $row = mysqli_fetch_array($res_dt);
      $quien = $row['quien'];
      $inicio = $row['inicio'];
      $fin = $row['fin'];
      $titulo= $row['titulo'];
      $contenido = $row['contenido'];
      $a_quien = $row['a_quien'];
      $estado = $row['estado'];
      $obs = $row['obs'];
      $obs_supervisor = $row['obs_supervisor'];
      $archivo_uno = $row['archivo_uno'];
      $archivo_dos = $row['archivo_dos'];
      $tarea = $row['tarea'];
      $tecnico = $row['tecnico'];
      $tomado_por = $row['tomado_por'];
      $id_tarea = $row['id_tarea'];
      $token = $row['token'];
      $id_auditoria = $row['id_auditoria'];
    };
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
  <?php $_SESSION['card'] = 0; } ?>
  <script>
    $(document).ready(function(){
      $('.toast').toast('show');
    });
  </script>
<!-- MESSAGES -->
<div class="container-fluid p-4">
  <div class="row p-2">
    <div class="container-fluid rounded bg-white shadow p-0">
      <div class="col-auto">
        <div class="container-fluid p-2">
          <p class="h4 mb-4 text-center"><?php echo $titulo; if($estado !== '') { echo ' (' .$estado .')'; }; ?><br><span class="h6"><?php echo $quien; ?><br>
            <?php if($quien_us == 'Damian Duarte') { ?>
              <button type="button" id="share" class="btn btn-dark btn-sm m-2"><i class="fa-solid fa-share"></i></button>
              <script>
                initializeApp();
                function onShare() {
                  if (navigator.share) {
                    navigator
                    .share({
                      title: 'Argentseal',
                      text: '<?php echo $titulo; ?>',
                      url: 'b_ver_calendario.php?token=<?php echo $token; ?>',
                    })
                  }
                }
                function initializeApp() {
                  if ("serviceWorker" in navigator) {
                    navigator.serviceWorker.register("/sw.js").then(() => {
                      document.querySelector("#share").addEventListener("click", () => {
                        onShare();
                      });
                    });
                  }
                }
              </script>
            <?php } ?>
          </p>
            <?php if($inicio == $fin){ ?>
              <div class="row p-2">
                <div class="col p-2">
                  <div class="h5">Fecha: <span class="h6 text-black-50"><?php echo Fecha5($inicio); ?></span></div>
                </div>
              </div>
            <?php } else { ?>
              <div class="row p-2">
                <div class="col p-2">
                  <div class="h5">Inicio: <span class="h6 text-black-50"><?php echo Fecha5($inicio); ?></span></div>
                </div>
                <div class="col p-2">
                  <div class="h5">Fin: <span class="h6 text-black-50"><?php echo Fecha5($fin); ?></span></div>
                </div>
              </div>
            <?php } ?>
            
            <div class="row p-2">
              <?php if($a_quien == ''){echo '';} else { ?>
                <div class="col p-2">
                  <div class="h5">Asignado a: <span class="h6 text-black-50"><?php echo $a_quien; ?></span></div>
                </div>
              <?php } ?>
              <?php if($tomado_por !== $a_quien){echo '';} else { ?>
                <div class="col p-2">
                  <div class="h5">Tomado: <span class="h6 text-black-50">Si</span></div>
                </div>
              <?php } ?>
            </div>

            <?php if($tecnico == ''){echo '';} else { ?>
              <div class="row p-2">
                <div class="col p-2">
                  <div class="h5">Tecnico: <span class="h6 text-black-50"><?php echo $tecnico; ?></span></div>
                </div>
              </div>
            <?php } ?>
            
            
            <?php if($contenido == ''){echo '';} else { ?>
              <div class="row p-2">
                <div class="col p-2">
                  <div class="h5">Descripcion: <span class="h6 text-black-50"><?php echo $contenido; ?></span></div>
                </div>
              </div>
            <?php } ?>

            <?php if($obs == ''){echo '';} else { ?>
              <div class="row p-2">
                <div class="col p-2">
                  <div class="h5">Nota de cierre: <span class="h6 text-black-50"><?php echo $obs; ?></span></div>
                </div>
              </div>
            <?php } ?>

            <?php if($obs_supervisor == ''){echo '';} else { ?>
              <div class="row p-2">
                <div class="col p-2">
                  <div class="h5">Observaciones del supervisor: <span class="h6 text-black-50"><?php echo $obs_supervisor; ?></span></div>
                </div>
              </div>
            <?php } ?>

            <?php if ($archivo_uno == "") 
              {
                echo "";
              }
              else 
              { ?> 
              <div class="row p-4">
                <img src="<?php echo "../Archivos/calendario/" .$archivo_uno; ?>" width="50%" height="50%">
              </div>
              <br>
            <?php } ?>

            <?php if ($archivo_dos == "") 
              {
                echo "";
              }
              else 
              { ?> 
              <div class="row p-4">
                <img src="<?php echo "../Archivos/calendario/" .$archivo_dos; ?>" width="50%" height="50%">
              </div>
              <br>
            <?php } ?>

            <?php if($tomado_por == '' && $estado !== 'Finalizado' && $a_quien == $quien_us && $tipo_us == 'Supervisor'){ ?>
              <div class="row p-2">
                <div class="col p-2">
                  <a href="../Guardar/save_calendario.php?tomar=<?php echo $token; ?>" id="tomar_id_tomar"><span class="btn btn-success">Tomar</span></a>
                </div>
              </div>
            <?php } ?>

              <?php if($tarea == 'Garantia' && $id_tarea !== 'No se encontro ID'){ ?>
                <?php
                  $result_tasks = mysqli_query($conn, "SELECT * FROM garantias WHERE id = '$id_tarea'");
                  while($roww = mysqli_fetch_assoc($result_tasks))
                  {
                ?>
                  
                  <div class="container-fluid card card-body">
                    <form action="../Guardar/save_calendario.php?garant=<?php echo $token; ?>" method="POST">
                      <div class="row p-2">
                        <div class="col p-2">
                          <div class="h5">Tecnico responsable: <span class="h6 text-black-50"><?php echo $roww['tecnico']; ?></span></div>
                        </div>
                        <?php if($roww['tecrep'] !== '') { ?>
                          <div class="col p-2">
                            <div class="h5">Tecnico que reparo: <span class="h6 text-black-50"><?php echo $roww['tecrep']; ?></span></div>
                          </div>
                        <?php } ?>
                      </div>

                      <div class="row p-2">
                        <?php if($roww['direccion'] !== '') { ?>
                          <div class="col p-2">
                            <div class="h5">Zona: <span class="h6 text-black-50"><?php echo $roww['zona']; ?></span></div>
                            <br>
                            <div class="h5">Direccion: <span class="h6 text-black-50"><?php echo $roww['direccion']; ?></span></div>
                          </div>
                        <?php } ?>
                        <?php if($roww['ot'] !== '') { ?>
                          <div class="col p-2">
                            <div class="h5">OT: <span class="h6 text-black-50"><?php echo $roww['ot']; ?></span></div>
                          </div>
                        <?php } ?>
                      </div>

                      <div class="row p-2">
                        <?php if($roww['fechaint'] !== '') { ?>
                          <div class="col p-2">
                            <div class="h5">Fecha de instalacion: <span class="h6 text-black-50"><?php echo Fecha7($roww['fechaint']); ?></span></div>
                          </div>
                        <?php } ?>
                        <?php if($roww['fecharep'] !== '') { ?>
                          <div class="col p-2">
                            <div class="h5">Fecha de reparacion: <span class="h6 text-black-50"><?php echo Fecha7($roww['fecharep']); ?></span></div>
                          </div>
                        <?php } ?>
                      </div>

                      <?php if($roww['coment'] !== '') { ?>
                        <div class="row p-2">
                          <div class="col p-2">
                            <div class="h5">Motivo de cierre: <span class="h6 text-black-50"><?php echo $roww['coment']; ?></span></div>
                          </div>
                        </div>
                      <?php } ?>

                      <?php if($roww['nota_cliente'] !== '') { ?>
                        <div class="row p-2">
                          <div class="col p-2">
                            <div class="h5">Notas del cliente: <span class="h6 text-black-50"><?php echo $roww['nota_cliente']; ?></span></div>
                          </div>
                        </div>
                        <div class="row p-2">
                          <div class="col p-2">
                            <div class="h5">Notas del tecnico: <span class="h6 text-black-50"><?php echo $roww['obs']; ?></span></div>
                          </div>
                        </div>
                      <?php } ?> 

                      <div class="row p-2">
                        <div class="form-group col m-2">
                          <div class="form-check p-2">
                            <input class="form-check-input" type="radio" name="justificada" id="justificada" value="SI" <?php if($roww['justificado'] == 'SI'){echo 'checked';}else{echo'';} ?>>
                            <label class="form-check-label" for="justificada">Justificada</label>
                          </div>
                          <div class="form-check p-2">
                            <input class="form-check-input" type="radio" name="justificada" id="no_justificada" value="NO" <?php if($roww['justificado'] == 'NO'){echo 'checked';}else{echo'';} ?>>
                            <label class="form-check-label" for="no_justificada"><b>No</b> justificada</label>
                          </div>
                        </div>
                      </div>

                      <div class="row p-2">
                        <div class="form-group col">
                          <div class="h5">Observaciones supervisor</div >
                          <textarea type="text" name="obs_supervisor" class="form-control" autofocus required style="height: 150px;"><?php echo $roww['obs_supervisor']; ?></textarea>
                        </div>
                      </div>
                      <?php if($estado == 'Pendiente') { ?>
                        <input type="submit" name="actualizar" class="btn btn-success btn-block" value="Guardar">
                      <?php } ?>
                    </form>
                  </div>
                  
                <?php } ?>
              <?php } ?>

              <?php if($tarea == 'Reclamo' && $id_tarea !== 'No se encontro ID'){ ?>
                <?php
                  $reclamos = mysqli_query($conn, "SELECT * FROM reclamos WHERE id = '$id_tarea'");
                  while($rowww = mysqli_fetch_assoc($reclamos))
                  {
                ?>
                  
                <div class="container-fluid card card-body">
                  <form action="../Guardar/save_calendario.php?reclamo=<?php echo $token; ?>" method="POST">
                    <div class="row p-2">
                      <div class="col p-2">
                        <div class="h5">Tecnico responsable: <span class="h6 text-black-50"><?php echo $rowww['tecnico']; ?></span></div>
                      </div>
                      <div class="col p-2">
                        <div class="h5">Fecha de instalacion: <span class="h6 text-black-50"><?php echo $rowww['fechains']; ?></span></div>
                      </div>
                    </div>

                    <div class="row p-2">
                      <div class="col p-2">
                        <div class="h5">Direccion: <span class="h6 text-black-50"><?php echo $rowww['direccion']; ?></span></div>
                      </div>
                      <div class="col p-2">
                        <div class="h5">Telefono de contacto: <span class="h6 text-black-50"><?php echo $rowww['telefono']; ?></span></div>
                      </div>
                      
                    </div>

                    <div class="row p-2">
                      <div class="col p-2">
                        <div class="h5">OT: <span class="h6 text-black-50"><?php echo $rowww['ot']; ?></span></div>
                      </div>
                      <div class="col p-2">
                        <div class="h5">RF: <span class="h6 text-black-50"><?php echo $rowww['rf']; ?></span></div>
                      </div>
                    </div>

                    <div class="form-row">
                      <div class="form-group col">
                        <div class="h5">Fecha de la solucion</div>
                        <input type="date" name="fechasolu" class="form-control" value="<?php if($rowww['fechasolu'] == ''){ echo date('Y-m-d'); }else{ echo $rowww['fechasolu'];} ?>">
                      </div>
                    </div>

                    <div class="form-row">
                      <div class="form-group col">
                        <div class="h5">Solucion</div>
                        <textarea type="text" name="solucion" class="form-control" autofocus required style="height: 150px;"><?php echo $rowww['solucion']; ?></textarea>
                      </div>
                    </div>

                    <?php if($estado == 'Pendiente') { ?>
                      <input type="submit" name="actualizar" class="btn btn-success btn-block" value="Guardar">
                    <?php } ?>
                  </form>
                </div>
                  
                <?php } ?>
              <?php } ?>

            <?php if($tomado_por == $quien_us){ ?>

              <?php if($tarea == 'Otro' && $estado == 'Pendiente' || $tarea == 'Reclamo' && $estado == 'Pendiente' && $id_tarea == 'No se encontro ID' || $tarea == 'Relevamiento fotografico' && $estado == 'Pendiente' || $tarea == 'Garantia' && $estado == 'Pendiente' && $id_tarea == 'No se encontro ID'){ ?>
                <div class="container-fluid card card-body">
                  <form action="../Guardar/save_calendario.php?cerrar=<?php echo $token; ?>" method="POST" enctype="multipart/form-data">

                    <div class="form-row align-items-end">
                      <div class="form-group col">
                        <label for="customRadioInline1">Subir 1° imagen</label>
                        <input type="file" class="form-control-file" accept="image/*" name="imagen1" id="cargaImagen1" onchange="previewImage(1);">
                      </div>
                    </div>

                    <img id="mostrarImagen1" width="50%" height="50%"/>

                    <div class="form-row align-items-end">
                      <div class="form-group col">
                        <label for="customRadioInline1">Subir 2° imagen</label>
                        <input type="file" class="form-control-file" accept="image/*" name="imagen2" id="cargaImagen2" onchange="previewImage(2);">
                      </div>
                    </div>

                    <img id="mostrarImagen2" width="50%" height="50%"/>
                    <script type="text/javascript">
                      function previewImage(nb) {
                          var reader = new FileReader();
                          reader.readAsDataURL(document.getElementById('cargaImagen'+nb).files[0]);
                          reader.onload = function (e) {
                              document.getElementById('mostrarImagen'+nb).src = e.target.result;
                          };     
                      }
                    </script>
                
                    <div class="row p-2">
                      <div class="form-group col">
                        <div class="h5">Observaciones supervisor</div >
                        <textarea type="text" name="obs_supervisor" class="form-control" autofocus required style="height: 150px;"></textarea>
                      </div>
                    </div>
                    <input type="submit" class="btn btn-success btn-block" value="Cerrar tarea">
                  </form>
                </div>
              <?php } ?>

              <?php if($tarea == 'Auditoria de herramientas' && $estado == 'Pendiente'){ ?>
                <div class="row p-2 justify-content-center">
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#herramientas">Realizar auditoria <i class="fas fa-camera"></i></button>
                </div>
                  <!-- Modal -->
                    <div class="modal fade" id="herramientas">  <!-- Modal para el boton -->
                      <div class="modal-dialog modal-xl" role="document">
                          <div class="modal-content">
                            <form action="../Guardar/save_auditorias2.php" method="POST" enctype="multipart/form-data">
                              <div class="modal-header"> <!-- Encabezado del modal -->
                                <h5 class="modal-title">Auditoria de herramientas</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                </button>
                              </div>
                              <input type="text" hidden name="realizado" value="Realizado">
                              <input type="text" hidden name="token_calendario" value="<?php echo $token; ?>">
                              <div class="p-2">
                                
                                <div class="form-row p-2">
                                  <div class="form-group col">
                                    <label>Tecnico</label>
                                    <select type="text" name="tecnico" class="form-control">                
                                        <option selected value="<?php echo $tecnico; ?>"><?php echo $tecnico; ?></option>                
                                        <?php
                                          $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?>   
                                          <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                                        <?php endforeach ?>
                                      </select>
                                  </div>
                                  <div class="form-group col">
                                    <label>Fecha</label>
                                    <input type="date" name="fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                  </div>
                                </div>
                              
                                <div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Aire comprimido</b></label>
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="aire" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="aire" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Alargue</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="alargue" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="alargue" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Alcohol isopropilico</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="alcohol" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="alcohol" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Alicate</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="alicate" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="alicate" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Arnes</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="arnes" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="arnes" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Bolso kit</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="bolso_kit" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="bolso_kit" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Bolso del cleaver</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="bolso_cleaver" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="bolso_cleaver" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Campera</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="campera" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="campera" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Caja de herramientas</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="caja" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="caja" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Casco</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="casco" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="casco" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Celular</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="celular" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="celular" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Chomba</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="chomba" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="chomba" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Cinta pasacable</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="pasacable" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="pasacable" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Cleaver</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="cleaver" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="cleaver" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Conos</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="conos" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="conos" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Crimpeadora</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="crimpeadora" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="crimpeadora" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Destornillador phillips</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="dest_phillips" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="dest_phillips" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Destornillador plano</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="dest_plano" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="dest_plano" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Detector de tension</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="tension" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="tension" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Espatula y enduido</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="enduido" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="enduido" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Escalera chica</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="escalera_chica" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="escalera_chica" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Escalera grande</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="escalera_grande" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="escalera_grande" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Escoba</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="escoba" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="escoba" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Fibron</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="fibron" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="fibron" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Gafas</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="gafas" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="gafas" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Gorra</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="gorra" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="gorra" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Guante de alta tension</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="alta_tension" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="alta_tension" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Guante de trabajo</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="guante_trabajo" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="guante_trabajo" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Lapiz limpiador</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="lapiz_limpiador" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="lapiz_limpiador" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Lapiz optico</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="lapiz_optico" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="lapiz_optico" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Linga</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="linga" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="linga" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Martillo</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="martillo" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="martillo" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Mecha del 6"</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="mecha6" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="mecha6" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Mecha pasante</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="mecha_pasante" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="mecha_pasante" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Pala</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="pala" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="pala" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Pantalon</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="pantalon" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="pantalon" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Paños</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="panos" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="panos" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Peladora FO</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="peladora_fo" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="peladora_fo" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Peladora universal</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="peladora_uni" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="peladora_uni" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Percutora</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="percutora" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="percutora" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Pinza</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="pinza" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="pinza" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Pistola de silicona</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="silicona" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="silicona" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Power meter</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="power" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="power" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Telefono de prueba</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="tel" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="tel" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Tester de RJ45</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="tester_rj" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="tester_rj" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Tijera</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="tijera" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="tijera" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Zapatos</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="zapatos" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="zapatos" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <br>

                                  <div class="form-row align-items-end">
                                    <div class="form-group col">
                                      <label for="customRadioInline1">Subir 1° imagen</label>
                                      <input type="file" class="form-control-file" accept="image/*" name="imagen1" id="cargaImagen1" onchange="previewImage(1);">
                                    </div>
                                  </div>

                                  <img id="mostrarImagen1" width="50%" height="50%"/>

                                  <div class="form-row align-items-end">
                                    <div class="form-group col">
                                      <label for="customRadioInline1">Subir 2° imagen</label>
                                      <input type="file" class="form-control-file" accept="image/*" name="imagen2" id="cargaImagen2" onchange="previewImage(2);">
                                    </div>
                                  </div>

                                  <img id="mostrarImagen2" width="50%" height="50%"/>

                                  <div class="form-row align-items-end">
                                    <div class="form-group col">
                                      <label for="customRadioInline1">Subir 3° imagen</label>
                                      <input type="file" class="form-control-file" accept="image/*" name="imagen3" id="cargaImagen3" onchange="previewImage(3);">
                                    </div>
                                  </div>

                                  <img id="mostrarImagen3" width="50%" height="50%"/>

                                  <div class="form-row align-items-end">
                                    <div class="form-group col">
                                      <label for="customRadioInline1">Subir 4° imagen</label>
                                      <input type="file" class="form-control-file" accept="image/*" name="imagen4" id="cargaImagen4" onchange="previewImage(4);">
                                    </div>
                                  </div>

                                  <img id="mostrarImagen4" width="50%" height="50%"/>

                                  <script type="text/javascript">
                                    function previewImage(nb) {        
                                        var reader = new FileReader();         
                                        reader.readAsDataURL(document.getElementById('cargaImagen'+nb).files[0]);         
                                        reader.onload = function (e) {             
                                            document.getElementById('mostrarImagen'+nb).src = e.target.result;         
                                        };     
                                    }
                                  </script>
                                  <br>
                                  <div class="col">
                                    <label for="exampleFormControlSelect1"><b>Observaciones (Max 255 caracteres)</b></label >
                                    <textarea type="text" name="obs" maxlength="255" class="form-control" placeholder="Ingrese una observacion"></textarea>
                                  </div> 
                                </div>

                                <div class="row p-2">
                                  <div class="col">
                                    <input type="submit" name="save_auditoria" class="btn btn-success btn-block" value="Guardar auditoria">
                                  </div>
                                </div>
                              </div>
                            </form>
                          </div>
                      </div>
                    </div>
                  <!-- Modal -->
              <?php } ?>

              <?php if($tarea == 'Auditoria de instalacion' && $estado == 'Pendiente'){ ?>
                <div class="row p-2 justify-content-center">
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#instalacion">Realizar auditoria <i class="fas fa-camera"></i></button>
                </div>
                  <!-- Modal -->
                    <div class="modal fade" id="instalacion">  <!-- Modal para el boton -->
                      <div class="modal-dialog modal-xl" role="document">
                          <div class="modal-content">
                            <form action="../Guardar/save_auditorias_instalaciones2.php" method="POST" enctype="multipart/form-data">
                              <div class="modal-header"> <!-- Encabezado del modal -->
                                <h5 class="modal-title">Auditoria de instalacion</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                </button>
                              </div>
                              <input type="text" hidden name="realizado" value="Realizado">
                              <input type="text" hidden name="token_calendario" value="<?php echo $token; ?>">
                              <div class="p-2">
                                
                                <div class="form-row p-2">
                                  <div class="form-group col">
                                    <label>Tecnico</label>
                                    <select type="text" name="tecnico" class="form-control">                
                                        <option selected value="<?php echo $tecnico; ?>"><?php echo $tecnico; ?></option>                
                                        <?php
                                          $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?>   
                                          <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                                        <?php endforeach ?>
                                      </select>
                                  </div>
                                  <div class="form-group col">
                                    <label>Fecha</label>
                                    <input type="date" name="fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                  </div>
                                </div>
                              
                                <div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>OT</b></label >
                                    <div class="form-row align-items-center">                  
                                        <input type="number" maxlength="10" name="ot" class="form-control" autofocus>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Instalacion externa</b></label>
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="instalacion_externa" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="instalacion_externa" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Foto del nomenclador</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="foto_nomenclador" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="foto_nomenclador" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>         
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Cadena</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="cadena" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="cadena" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Altura de la acometida</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="altura_acometida" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="altura_acometida" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Punto de retencion</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="punto_retencion" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="punto_retencion" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Curva de goteo</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="curva_goteo" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="curva_goteo" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Ingreso al domicilio</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="ingreso_domicilio" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="ingreso_domicilio" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Engrampado interior</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="engrampado_interior" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="engrampado_interior" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Amurado de ONT</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="ont" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="ont" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Residuos</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="residuos" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="residuos" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Trato con el cliente</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="trato_cliente" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="trato_cliente" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Uso de herramientas</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="uso_herramientas" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="uso_herramientas" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>
                                  </div>

                                  <div class="card card-body">
                                    <label for="exampleFormControlSelect1"><b>Uso de epp</b></label >
                                    <div class="form-row align-items-center">
                                        <div class="form-group col-xs-2">
                                          <legend class="col-form-label col">Estado</legend>
                                        </div>
                                        <div class="form-group col-xs-10">
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="epp" id="gridRadios2" value="BIEN" checked>
                                            <label class="form-check-label" for="customRadioInline1">Bien</label>
                                          </div>
                                          <div class="form-check custom-control-inline">
                                            <input class="form-check-input" type="radio" name="epp" id="gridRadios2" value="MAL">
                                            <label class="form-check-label" for="customRadioInline2">Mal</label>
                                          </div>
                                        </div>
                                    </div>
                                  </div>

                                  <br>

                                  <div class="form-row align-items-end">
                                    <div class="form-group col">
                                      <label for="customRadioInline1">Subir 1° imagen</label>
                                      <input type="file" class="form-control-file" accept="image/*" name="imagen1" id="cargaImagen1" onchange="previewImage(1);">
                                    </div>
                                  </div>

                                  <img id="mostrarImagen1" width="50%" height="50%"/>

                                  <div class="form-row align-items-end">
                                    <div class="form-group col">
                                      <label for="customRadioInline1">Subir 2° imagen</label>
                                      <input type="file" class="form-control-file" accept="image/*" name="imagen2" id="cargaImagen2" onchange="previewImage(2);">
                                    </div>
                                  </div>

                                  <img id="mostrarImagen2" width="50%" height="50%"/>

                                  <div class="form-row align-items-end">
                                    <div class="form-group col">
                                      <label for="customRadioInline1">Subir 3° imagen</label>
                                      <input type="file" class="form-control-file" accept="image/*" name="imagen3" id="cargaImagen3" onchange="previewImage(3);">
                                    </div>
                                  </div>

                                  <img id="mostrarImagen3" width="50%" height="50%"/>

                                  <div class="form-row align-items-end">
                                    <div class="form-group col">
                                      <label for="customRadioInline1">Subir 4° imagen</label>
                                      <input type="file" class="form-control-file" accept="image/*" name="imagen4" id="cargaImagen4" onchange="previewImage(4);">
                                    </div>
                                  </div>

                                  <img id="mostrarImagen4" width="50%" height="50%"/>

                                  <script type="text/javascript">
                                    function previewImage(nb) {        
                                        var reader = new FileReader();         
                                        reader.readAsDataURL(document.getElementById('cargaImagen'+nb).files[0]);         
                                        reader.onload = function (e) {             
                                            document.getElementById('mostrarImagen'+nb).src = e.target.result;         
                                        };     
                                    }
                                  </script>


                                  <br>
                                  <div class="col">
                                    <label for="exampleFormControlSelect1"><b>Observaciones (Max 1000 caracteres)</b></label >
                                    <textarea type="text" name="obs" maxlength="1000" class="form-control" placeholder="Ingrese una observacion"></textarea>
                                  </div> 
                                </div>

                                <div class="row p-2">
                                  <div class="col">
                                    <input type="submit" name="save_auditoria_instalaciones2" class="btn btn-success btn-block" value="Guardar auditoria">
                                  </div>
                                </div>
                              </div>
                            </form>
                          </div>
                      </div>
                    </div>
                  <!-- Modal -->
              <?php } ?>

              <?php if($tarea == 'Auditoria vehiculo' && $estado == 'Pendiente'){ ?>
                <div class="row p-2 justify-content-center">
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#vehiculo">Realizar auditoria <i class="fas fa-camera"></i></button>
                </div>
                  <!-- Modal -->
                    <div class="modal fade" id="vehiculo">  <!-- Modal para el boton -->
                      <div class="modal-dialog modal-xl" role="document">
                          <div class="modal-content">
                            <form action="../Guardar/save_auditorias_vehiculo2.php" method="POST" enctype="multipart/form-data">
                              <div class="modal-header"> <!-- Encabezado del modal -->
                                <h5 class="modal-title">Auditoria vehiculo</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                </button>
                              </div>
                              <input type="text" hidden name="realizado" value="Realizado">
                              <input type="text" hidden name="token_calendario" value="<?php echo $token; ?>">
                              <div class="p-2">
                                
                                <div class="form-row p-2">
                                  <div class="form-group col">
                                    <label>Tecnico</label>
                                    <select type="text" name="tecnico" class="form-control">                
                                        <option selected value="<?php echo $tecnico; ?>"><?php echo $tecnico; ?></option>                
                                        <?php
                                          $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                                        ?>
                                        <?php foreach ($ejecutar as $opciones): ?>   
                                          <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                                        <?php endforeach ?>
                                      </select>
                                  </div>
                                  <div class="form-group col">
                                    <label>Fecha</label>
                                    <input type="date" name="fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                  </div>
                                </div>
                              
                                <div>

                                  <div class="card card-body border-info">

                                    <p class="h4 mb-4 text-center">Datos del vehiculo</p>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Dominio</b></label >
                                      <div class="form-row align-items-center">                  
                                          <input type="text" maxlength="255" name="dv_dominio" class="form-control" autofocus>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Color</b></label >
                                      <div class="form-row align-items-center">                  
                                          <input type="text" maxlength="255" name="dv_color" class="form-control" autofocus>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Modelo</b></label >
                                      <div class="form-row align-items-center">                  
                                          <input type="text" maxlength="255" name="dv_modelo" class="form-control" autofocus>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Balizas</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="dv_balizas" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="dv_balizas" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Cedula</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="dv_cedula" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="dv_cedula" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Chasis</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="dv_chasis" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="dv_chasis" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Criquet</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="dv_criquet" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="dv_criquet" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Llave cruz</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="dv_llave_cruz" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="dv_llave_cruz" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Matafuego</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="dv_matafuego" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="dv_matafuego" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Motor</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="dv_motor" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="dv_motor" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Rueda de auxilio</b></label>
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="dv_auxilio" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="dv_auxilio" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    </div>





                                    <div class="card card-body border-warning">

                                    <p class="h4 mb-4 text-center">Instrumental</p>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Aire</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_aire" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_aire" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Balizas</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_balizas" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_balizas" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Bocina</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_bocina" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_bocina" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Calefaccion</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_calefaccion" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_calefaccion" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Encendedor</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_encendedor" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_encendedor" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Giro delantero lado acompañante</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_giro_del_acom" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_giro_del_acom" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Giro delantero lado conductor</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_giro_del_conductor" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_giro_del_conductor" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Giro trasero lado acompañante</b></label>
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_giro_tras_acom" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_giro_tras_acom" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Giro trasero lado conductor</b></label>
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_giro_tras_conductor" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_giro_tras_conductor" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Limpiaparabrisa</b></label>
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_limpiaparabrisa" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_limpiaparabrisa" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Luces altas</b></label>
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_luz_alta" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_luz_alta" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Luces bajas</b></label>
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_luz_baja" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_luz_baja" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Luces de freno</b></label>
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_luz_freno" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_luz_freno" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Sapito</b></label>
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_sapito" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_sapito" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Stereo</b></label>
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_stereo" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_stereo" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Tapa fusilera</b></label>
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_tapa_fusilera" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_tapa_fusilera" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Medidor temperatura</b></label>
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_temperatura" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_temperatura" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Medidor velocimetro</b></label>
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_velocimetro" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_velocimetro" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Llave</b></label>
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_llave" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="i_llave" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    </div>




                                    <div class="card card-body border-primary">

                                    <p class="h4 mb-4 text-center">Torpedo</p>


                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Manijas de giro</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="tor_manijas_giro" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="tor_manijas_giro" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Manijas de luces</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="tor_manijas_luces" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="tor_manijas_luces" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Pulsadores</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="tor_pulsadores" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="tor_pulsadores" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Rejilla ventilacion</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="tor_rejilla_ventilacion" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="tor_rejilla_ventilacion" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>            

                                    </div>

                                    <div class="card card-body border-info">

                                    <p class="h4 mb-4 text-center">Exterior frente</p>


                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Capot</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extfre_capot" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extfre_capot" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Cubiertas</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extfre_cubiertas" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extfre_cubiertas" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Llantas</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extfre_llantas" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extfre_llantas" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Opticas</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extfre_opticas" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extfre_opticas" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div> 

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Parabrisa</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extfre_parabrisas" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extfre_parabrisas" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div> 

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Paragolpe</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extfre_paragolpe" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extfre_paragolpe" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>  

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Parrilla</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extfre_parrilla" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extfre_parrilla" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Portaescalera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extfre_portaescalera" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extfre_portaescalera" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>         
                                    </div>         

                                    </div>

                                    <div class="card card-body border-warning">

                                    <p class="h4 mb-4 text-center">Exterior trasero</p>


                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Baul</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="exttras_baul" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="exttras_baul" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Caño escape</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="exttras_cano_esc" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="exttras_cano_esc" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Cerradura</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="exttras_cerradura" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="exttras_cerradura" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Cubiertas</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="exttras_cubiertas" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="exttras_cubiertas" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div> 

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Llantas</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="exttras_llantas" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="exttras_llantas" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div> 

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Luneta</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="exttras_luneta" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="exttras_luneta" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>  

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Opticas</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="exttras_opticas" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="exttras_opticas" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Paragolpe</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="exttras_paragolpe" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="exttras_paragolpe" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>         

                                    </div>

                                    <div class="card card-body border-success">

                                    <p class="h4 mb-4 text-center">Interior lado acompañante</p>


                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Alfombra delantera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_alfombra_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_alfombra_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Alfombra trasera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_alfombra_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_alfombra_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Apoya brazo delantero</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_apoya_brazo_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_apoya_brazo_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Apoya brazo trasero</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_apoya_brazo_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_apoya_brazo_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div> 

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Butaca delantera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_butaca_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_butaca_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div> 

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Butaca trasera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_butaca_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_butaca_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>  

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Cerradura delantera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_cerradura_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_cerradura_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Cerradura trasera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_cerradura_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_cerradura_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div> 

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Manija puerta delantera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_manija_puerta_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_manija_puerta_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Manija puerta trasera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_manija_puerta_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_manija_puerta_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Manija ventanilla delantera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_manija_ventanilla_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_manija_ventanilla_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Manija ventanilla trasera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_manija_ventanilla_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_manija_ventanilla_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Panel puerta delantera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_panel_puerta_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_panel_puerta_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Panel puerta trasera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_panel_puerta_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_panel_puerta_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Panel del techo</b></label>
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_panel_techo" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_panel_techo" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Polarizado delantero</b></label>
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_polarizado_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_polarizado_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Polarizado trasero</b></label>
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_polarizado_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_polarizado_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Seguro puerta delantera</b></label>
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_seguro_puerta_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_seguro_puerta_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Seguro puerta trasera</b></label>
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_seguro_puerta_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intacom_seguro_puerta_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    </div>

                                    <div class="card card-body border-danger">

                                    <p class="h4 mb-4 text-center">Interior lado conductor</p>


                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Alfombra delantera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_alfombra_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_alfombra_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Alfombra trasera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_alfombra_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_alfombra_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Apoya brazo delantero</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_apoya_brazo_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_apoya_brazo_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Apoya brazo trasero</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_apoya_brazo_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_apoya_brazo_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div> 

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Butaca delantera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_butaca_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_butaca_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div> 

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Butaca trasera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_butaca_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_butaca_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>  

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Cerradura delantera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_cerradura_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_cerradura_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Cerradura trasera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_cerradura_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_cerradura_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div> 

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Manija puerta delantera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_manija_puerta_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_manija_puerta_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Manija puerta trasera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_manija_puerta_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_manija_puerta_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Manija ventanilla delantera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_manija_ventanilla_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_manija_ventanilla_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Manija ventanilla trasera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_manija_ventanilla_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_manija_ventanilla_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Panel puerta delantera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_panel_puerta_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_panel_puerta_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Panel puerta trasera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_panel_puerta_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_panel_puerta_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Panel del techo</b></label>
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_panel_techo" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_panel_techo" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Polarizado delantero</b></label>
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_polarizado_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_polarizado_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Polarizado trasero</b></label>
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_polarizado_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_polarizado_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Seguro puerta delantera</b></label>
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_seguro_puerta_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_seguro_puerta_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Seguro puerta trasera</b></label>
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_seguro_puerta_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="intcond_seguro_puerta_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    </div>

                                    <div class="card card-body border-success">

                                    <p class="h4 mb-4 text-center">Exterior lado acompañante</p>


                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Bagueta delantera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extacom_bagueta_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extacom_bagueta_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Bagueta trasera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extacom_bagueta_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extacom_bagueta_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Cerradura delantera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extacom_cerradura_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extacom_cerradura_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Cerradura trasera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extacom_cerradura_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extacom_cerradura_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div> 

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Espejo lateral</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extacom_espejo_lateral" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extacom_espejo_lateral" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div> 

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Manija puerta delantera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extacom_manija_puerta_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extacom_manija_puerta_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>  

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Manija puerta trasera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extacom_manija_puerta_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extacom_manija_puerta_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Ventanilla delantera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extacom_ventanilla_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extacom_ventanilla_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div> 

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Ventanilla trasera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extacom_ventanilla_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extacom_ventanilla_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Higuiene interior</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extacom_higuiene_int" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extacom_higuiene_int" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Higuiene exterior</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extacom_higuiene_ext" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extacom_higuiene_ext" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>    

                                    </div>

                                    <div class="card card-body border-danger">

                                    <p class="h4 mb-4 text-center">Exterior lado conductor</p>


                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Bagueta delantera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extcond_bagueta_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extcond_bagueta_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Bagueta trasera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extcond_bagueta_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extcond_bagueta_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Cerradura delantera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extcond_cerradura_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extcond_cerradura_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Cerradura trasera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extcond_cerradura_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extcond_cerradura_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div> 

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Espejo lateral</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extcond_espejo_lateral" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extcond_espejo_lateral" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div> 

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Espejo retrovisor</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extcond_espejo_retrovisor" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extcond_espejo_retrovisor" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>  

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Manija puerta delantera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extcond_manija_puerta_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extcond_manija_puerta_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Manija puerta trasera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extcond_manija_puerta_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extcond_manija_puerta_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div> 

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Tapa del tanque</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extcond_tapa_tanque" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extcond_tapa_tanque" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Ventanilla delantera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extcond_ventanilla_del" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extcond_ventanilla_del" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="card card-body">
                                      <label for="exampleFormControlSelect1"><b>Ventanilla trasera</b></label >
                                      <div class="form-row align-items-center">
                                          <div class="form-group col-xs-2">
                                            <legend class="col-form-label col">Estado</legend>
                                          </div>
                                          <div class="form-group col-xs-10">
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extcond_ventanilla_tras" id="gridRadios2" value="BIEN" checked>
                                              <label class="form-check-label" for="customRadioInline1">Bien</label>
                                            </div>
                                            <div class="form-check custom-control-inline">
                                              <input class="form-check-input" type="radio" name="extcond_ventanilla_tras" id="gridRadios2" value="MAL">
                                              <label class="form-check-label" for="customRadioInline2">Mal</label>
                                            </div>
                                          </div>
                                      </div>
                                    </div>    

                                    </div>

                                    <br>

                                    <div class="form-row align-items-end">
                                      <div class="form-group col">
                                        <label for="customRadioInline1">Subir 1° imagen</label>
                                        <input type="file" class="form-control-file" accept="image/*" name="imagen1" id="cargaImagen1" onchange="previewImage(1);">
                                      </div>
                                    </div>

                                    <img id="mostrarImagen1" width="50%" height="50%"/>

                                    <div class="form-row align-items-end">
                                      <div class="form-group col">
                                        <label for="customRadioInline1">Subir 2° imagen</label>
                                        <input type="file" class="form-control-file" accept="image/*" name="imagen2" id="cargaImagen2" onchange="previewImage(2);">
                                      </div>
                                    </div>

                                    <img id="mostrarImagen2" width="50%" height="50%"/>

                                    <div class="form-row align-items-end">
                                      <div class="form-group col">
                                        <label for="customRadioInline1">Subir 3° imagen</label>
                                        <input type="file" class="form-control-file" accept="image/*" name="imagen3" id="cargaImagen3" onchange="previewImage(3);">
                                      </div>
                                    </div>

                                    <img id="mostrarImagen3" width="50%" height="50%"/>

                                    <div class="form-row align-items-end">
                                      <div class="form-group col">
                                        <label for="customRadioInline1">Subir 4° imagen</label>
                                        <input type="file" class="form-control-file" accept="image/*" name="imagen4" id="cargaImagen4" onchange="previewImage(4);">
                                      </div>
                                    </div>

                                    <img id="mostrarImagen4" width="50%" height="50%"/>

                                    <script type="text/javascript">
                                      function previewImage(nb) {        
                                          var reader = new FileReader();         
                                          reader.readAsDataURL(document.getElementById('cargaImagen'+nb).files[0]);         
                                          reader.onload = function (e) {             
                                              document.getElementById('mostrarImagen'+nb).src = e.target.result;         
                                          };     
                                      }
                                    </script>


                                    <br>
                                    <div class="col">
                                    <label for="exampleFormControlSelect1"><b>Observaciones (Max 1000 caracteres)</b></label >
                                    <textarea type="text" name="obs" maxlength="1000" class="form-control" placeholder="Ingrese una observacion"></textarea>
                                    </div>
                                </div>

                                <div class="row p-2">
                                  <div class="col">
                                    <input type="submit" name="save_auditoria_vehiculo" class="btn btn-success btn-block" value="Guardar auditoria">
                                  </div>
                                </div>
                              </div>
                            </form>
                          </div>
                      </div>
                    </div>
                  <!-- Modal -->
              <?php } ?>

            <?php } ?>

            <?php if($tarea == 'Auditoria de herramientas' && $estado == 'Finalizado')
              {
                $instala = mysqli_query($conn, "SELECT * FROM auditoria WHERE identificador = '$id_auditoria'");
                if (mysqli_num_rows($instala) == 1)
                {
                  $row = mysqli_fetch_array($instala);
                  $identificador = $row['identificador'];
                  $super = $row['supervisor'];
                  $tecnico_i = $row['tecnico'];
                  $fecha_i = $row['fecha'];
                  $aire = $row['aire'];
                  $alargue = $row['alargue'];
                  $alcohol = $row['alcohol'];
                  $alicate = $row['alicate'];
                  $arnes = $row['arnes'];
                  $campera = $row['campera'];
                  $casco = $row['casco'];
                  $celular = $row['celular'];
                  $chomba = $row['chomba'];
                  $pasacable = $row['pasacable'];
                  $cleaver = $row['cleaver'];
                  $conos = $row['conos'];
                  $crimpeadora = $row['crimpeadora'];
                  $dest_phillips = $row['dest_phillips'];
                  $dest_plano = $row['dest_plano'];
                  $tension = $row['tension'];
                  $enduido = $row['enduido'];
                  $escalera_chica = $row['escalera_chica'];
                  $escalera_grande = $row['escalera_grande'];
                  $escoba = $row['escoba'];
                  $fibron = $row['fibron'];
                  $gafas = $row['gafas'];
                  $gorra = $row['gorra'];
                  $alta_tension = $row['alta_tension'];
                  $guante_trabajo = $row['guante_trabajo'];
                  $lapiz_limpiador = $row['lapiz_limpiador'];
                  $lapiz_optico = $row['lapiz_optico'];
                  $linga = $row['linga'];
                  $martillo = $row['martillo'];
                  $mecha6 = $row['mecha6'];
                  $mecha_pasante = $row['mecha_pasante'];
                  $pala = $row['pala'];
                  $pantalon = $row['pantalon'];
                  $panos = $row['panos'];
                  $peladora_fo = $row['peladora_fo'];
                  $peladora_uni = $row['peladora_uni'];
                  $percutora = $row['percutora'];
                  $pinza = $row['pinza'];
                  $silicona = $row['silicona'];
                  $power = $row['power'];
                  $tel = $row['tel'];
                  $tester_rj = $row['tester_rj'];
                  $tijera = $row['tijera'];
                  $zapatos = $row['zapatos'];
                  $bolso_kit = $row['bolso_kit'];
                  $bolso_cleaver = $row['bolso_cleaver'];
                  $caja = $row['caja'];
                  $obs_i = $row['obs'];
                  $imagenprimera_i = $row['imagenpri'];
                  $imagensegunda_i = $row['imagenseg'];
                  $imagentercera_i = $row['imagenter'];
                  $imagencuarta_i = $row['imagencuar'];
                }
              ?>
              <p class="h6 mb-4 text-center"><?php echo $id_auditoria; ?></p>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Tecnico: <span class="h6 text-black-50"><?php echo $tecnico_i; ?></span></div>
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Aire: <?php if ($aire == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($aire == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Alargue: <?php if ($alargue == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($alargue == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Alcohol: <?php if ($alcohol == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($alcohol == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Alicate: <?php if ($alicate == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($alicate == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Celular: <?php if ($celular == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($celular == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Pasacable: <?php if ($pasacable == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($pasacable == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Conos: <?php if ($conos == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($conos == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Crimpeadora: <?php if ($crimpeadora == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($crimpeadora == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Destornillador phillips: <?php if ($dest_phillips == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($dest_phillips == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Destornillador plano: <?php if ($dest_plano == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($dest_plano == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Detector de tension: <?php if ($tension == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($tension == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Enduido: <?php if ($enduido == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($enduido == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Escalera chica: <?php if ($escalera_chica == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($escalera_chica == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Escalera grande: <?php if ($escalera_grande == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($escalera_grande == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Escoba: <?php if ($escoba == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($escoba == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Fibron: <?php if ($fibron == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($fibron == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Linga: <?php if ($linga == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($linga == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Martillo: <?php if ($martillo == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($martillo == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Mecha de 6: <?php if ($mecha6 == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($mecha6 == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Mecha pasante: <?php if ($mecha_pasante == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($mecha_pasante == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Pala: <?php if ($pala == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($pala == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Peladora universal: <?php if ($peladora_uni == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($peladora_uni == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Percutora: <?php if ($percutora == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($percutora == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Pinza: <?php if ($pinza == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($pinza == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Silicona: <?php if ($silicona == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($silicona == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Telefono de prueba: <?php if ($tel == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($tel == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Tester RJ45: <?php if ($tester_rj == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($tester_rj == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Tijera: <?php if ($tijera == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($tijera == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>
                </div>
              </div>

              <p class="h3 mb-4 text-center">FO</p>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Cleaver: <?php if ($cleaver == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($cleaver == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>      
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Lapiz optico: <?php if ($lapiz_optico == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($lapiz_optico == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>      
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Lapiz limpiador: <?php if ($lapiz_limpiador == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($lapiz_limpiador == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>      
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Paños: <?php if ($panos == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($panos == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>      
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Peladora de FO: <?php if ($peladora_fo == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($peladora_fo == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>      
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Peladora universal: <?php if ($peladora_uni == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($peladora_uni == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>      
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Power: <?php if ($power == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($power == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>      
                </div>
              </div>

              <p class="h3 mb-4 text-center">EPP e indumentaria</p>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Arnes: <?php if ($arnes == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($arnes == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>      
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Campera: <?php if ($campera == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($campera == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>      
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Casco: <?php if ($casco == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($casco == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>      
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Chomba: <?php if ($chomba == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($chomba == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>      
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Gafas: <?php if ($gafas == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($gafas == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>      
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Guantes de alta tension: <?php if ($alta_tension == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($alta_tension == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>      
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Guante de trabajo: <?php if ($guante_trabajo == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($guante_trabajo == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>      
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Gorra: <?php if ($gorra == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($gorra == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>      
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Pantalon: <?php if ($pantalon == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($pantalon == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>      
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Zapatos: <?php if ($zapatos == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($zapatos == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></div>      
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Observaciones: <?php echo $obs_i; ?></div>      
                </div>
              </div>
              <?php if ($imagenprimera_i == "") 
              {
                echo "";
              }
              else 
              { ?> 
              <div class="row align-items-center">
                <img src="<?php echo "../Archivos/herramientas/" .$imagenprimera_i; ?>" width="50%" height="50%">
              </div>
              <br>
              <?php } ?>


              <?php if ($imagensegunda_i == "") 
                {
                  echo "";
                }
                else 
                { ?> 
              <div class="row align-items-center">
                <img src="<?php echo "../Archivos/herramientas/" .$imagensegunda_i; ?>" width="50%" height="50%">
              </div>
              <br>
              <?php } ?>


              <?php if ($imagentercera_i == "") 
                {
                  echo "";
                }
                else 
                { ?> 
              <div class="row align-items-center">
                <img src="<?php echo "../Archivos/herramientas/" .$imagentercera_i; ?>"  width="50%" height="50%">
              </div>
              <br>
              <?php } ?>


              <?php if ($imagencuarta_i == "") 
                {
                  echo "";
                }
                else 
                { ?> 
              <div class="row align-items-center">
                <img src="<?php echo "../Archivos/herramientas/" .$imagencuarta_i; ?>"  width="50%" height="50%">
              </div>
              <br>
              <?php } ?>
              
            <?php } ?>

            <?php if($tarea == 'Auditoria de instalacion' && $estado == 'Finalizado')
              {
                $herra = mysqli_query($conn, "SELECT * FROM auditoria_instalaciones WHERE identificador = '$id_auditoria'");
                if (mysqli_num_rows($herra) == 1)
                {
                  $row = mysqli_fetch_array($herra);
                  $super = $row['supervisor'];
                  $tecnico_h = $row['tecnico'];
                  $fecha_h = $row['fecha'];
                  $ot_h = $row['ot'];
                  $instalacion_externa = $row['instalacion_externa'];
                  $foto_nomenclador = $row['foto_nomenclador'];
                  $cadena = $row['cadena'];
                  $altura_acometida = $row['altura_acometida'];
                  $punto_retencion = $row['punto_retencion'];
                  $curva_goteo = $row['curva_goteo'];
                  $ingreso_domicilio = $row['ingreso_domicilio'];
                  $engrampado_interior = $row['engrampado_interior'];
                  $ont = $row['ont'];
                  $residuos = $row['residuos'];
                  $trato_cliente = $row['trato_cliente'];
                  $uso_herramientas = $row['uso_herramientas'];
                  $epp = $row['epp'];
                  $imagenprimera = $row['imagenpri'];
                  $imagensegunda = $row['imagenseg'];
                  $imagentercera = $row['imagenter'];
                  $imagencuarta = $row['imagencuar'];
                  $obs_h = $row['obs'];
                }
              ?>
              <p class="h6 mb-4 text-center"><?php echo $id_auditoria; ?></p>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Tecnico: <span class="h6 text-black-50"><?php echo $tecnico_h; ?></span></div>
                </div>
                <div class="col-6 p-2">
                  <div class="h5">OT: <span class="h6 text-black-50"><?php echo $ot_h; ?></span></div>
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Instalacion externa: <span class="h6 text-black-50"><?php if ($instalacion_externa == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($instalacion_externa == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></span></div>
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Foto del nomenclador: <span class="h6 text-black-50"><?php if ($foto_nomenclador == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($foto_nomenclador == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></span></div>
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Cadena: <span class="h6 text-black-50"><?php if ($cadena == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($cadena == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></span></div>
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Altura de la acometida: <span class="h6 text-black-50"><?php if ($altura_acometida == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($altura_acometida == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></span></div>
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Punto de retencion: <span class="h6 text-black-50"><?php if ($punto_retencion == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($punto_retencion == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></span></div>
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Curva de goteo: <span class="h6 text-black-50"><?php if ($curva_goteo == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($curva_goteo == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></span></div>
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Ingreso al domicilio: <span class="h6 text-black-50"><?php if ($ingreso_domicilio == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($ingreso_domicilio == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></span></div>
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Engrampado interior: <span class="h6 text-black-50"><?php if ($engrampado_interior == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($engrampado_interior == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></span></div>
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">ONT: <span class="h6 text-black-50"><?php if ($ont == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($ont == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></span></div>
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Residuos en el domicilio: <span class="h6 text-black-50"><?php if ($engrampado_interior == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($engrampado_interior == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></span></div>
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Trato con el cliente: <span class="h6 text-black-50"><?php if ($trato_cliente == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($trato_cliente == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></span></div>
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Uso de las herramientas: <span class="h6 text-black-50"><?php if ($uso_herramientas == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($uso_herramientas == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></span></div>
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Uso de EPP: <span class="h6 text-black-50"><?php if ($epp == 'BIEN'){echo '<i class="fas fa-check-circle text-success text-center"></i>';} if ($epp == 'MAL'){echo '<i class="fas fa-times-circle text-danger text-center"></i>';} ?></span></div>
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Observaciones: <span class="h6 text-black-50"><?php echo $obs_h; ?></span></div>
                </div>
              </div>
              <?php if ($imagenprimera == "") 
                {
                  echo "";
                }
                else 
                { ?> 
              <div class="row align-items-center">
                <img src="<?php echo "../Archivos/instalaciones2/" .$imagenprimera; ?>" alt="<?php echo $imagenpri; ?>" width="50%" height="50%">
              </div>
              <br>
              <?php } ?>


              <?php if ($imagensegunda == "") 
                {
                  echo "";
                }
                else 
                { ?> 
              <div class="row align-items-center">
                <img src="<?php echo "../Archivos/instalaciones2/" .$imagensegunda; ?>" alt="<?php echo $imagenseg; ?>" width="50%" height="50%">
              </div>
              <br>
              <?php } ?>


              <?php if ($imagentercera == "") 
                {
                  echo "";
                }
                else 
                { ?> 
              <div class="row align-items-center">
                <img src="<?php echo "../Archivos/instalaciones2/" .$imagentercera; ?>" alt="<?php echo $imagenter; ?>" width="50%" height="50%">
              </div>
              <br>
              <?php } ?>


              <?php if ($imagencuarta == "") 
                {
                  echo "";
                }
                else 
                { ?> 
              <div class="row align-items-center">
                <img src="<?php echo "../Archivos/instalaciones2/" .$imagencuarta; ?>" alt="<?php echo $imagencuar; ?>" width="50%" height="50%">
              </div>
              <br>
              <?php } ?>

            <?php } ?>

            <?php if($tarea == 'Auditoria vehiculo' && $estado == 'Finalizado')
              {
                $vehi = mysqli_query($conn, "SELECT * FROM auditoria_vehiculo WHERE identificador = '$id_auditoria'");
                if (mysqli_num_rows($vehi) == 1)
                {
                  $row = mysqli_fetch_array($vehi);
                  $tecnico_v = $row['tecnico'];
                  $fecha_v = $row['fecha'];
                  $dv_dominio = $row['dv_dominio'];
                  $dv_color = $row['dv_color'];
                  $dv_modelo = $row['dv_modelo'];
                  $imagenprimera_v = $row['imagenpri'];
                  $imagensegunda_v = $row['imagenseg'];
                  $imagentercera_v = $row['imagenter'];
                  $imagencuarta_v = $row['imagencuar'];
                  $obs_v = $row['obs'];
                }
              ?>
              <p class="h6 mb-4 text-center"><?php echo $id_auditoria; ?></p>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Tecnico: <?php echo $tecnico_v ; ?></div>
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Fecha: <?php echo Fecha7($fecha_v); ?></div>
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Modelo: <?php echo $dv_modelo .' ' .$dv_color; ?></div>
                </div>
                <div class="col-6 p-2">
                  <div class="h5">Patente: <?php echo $dv_dominio; ?></div>
                </div>
              </div>
              <div class="row p-2">
                <div class="col-6 p-2">
                  <div class="h5">Observaciones: <?php echo $obs_v ; ?></div>
                </div>
              </div>
              <?php if ($imagenprimera_v == "") 
                {
                  echo "";
                }
                else 
                { ?> 
              <div class="row align-items-center">
                <img src="<?php echo "../Archivos/foto_vehiculos/" .$imagenprimera_v; ?>" width="50%" height="50%">
              </div>
              <?php } ?>


              <?php if ($imagensegunda_v == "") 
                {
                  echo "";
                }
                else 
                { ?> 
              <div class="row align-items-center">
                <img src="<?php echo "../Archivos/foto_vehiculos/" .$imagensegunda_v; ?>" width="50%" height="50%">
              </div>
              <?php } ?>


              <?php if ($imagentercera_v == "") 
                {
                  echo "";
                }
                else 
                { ?> 
              <div class="row align-items-center">
                <img src="<?php echo "../Archivos/foto_vehiculos/" .$imagentercera_v; ?>" width="50%" height="50%">
              </div>
              <?php } ?>


              <?php if ($imagencuarta_v == "") 
                {
                  echo "";
                }
                else 
                { ?> 
              <div class="row align-items-center">
                <img src="<?php echo "../Archivos/foto_vehiculos/" .$imagencuarta_v; ?>" width="50%" height="50%">
              </div>
              <?php } ?>

            <?php } ?>
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