<?php
  include("../db.php");
  session_start();
  if(!$_SESSION['nombre'])
  {
  session_destroy();
  header("location: ../index.php");
  exit();
  }
  $tipo = $_SESSION['tipo_us'];
  $nombre = $_SESSION['nombre'];
  $apellido = $_SESSION['apellido'];
  $quien_notas = $nombre .' ' .$apellido;
  if($tipo == "Administrador") { $usu = 1; }
  if($tipo == "Despacho") { $usu = 1; }
  if($tipo == "Supervisor") { $usu = 1; }
  if($tipo == "Deposito") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
  }

  include('../includes/header.php');
?>
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
<!-- MESSAGES -->
<!-- FECHA -->
  <?php
    $ultimo_mes = date ('Y-m', strtotime('-0 month'));
    if(isset($_GET['mes']))
    {
      $desencriptado = $_GET['mes'];
      $ultimo_mes = base64_decode($desencriptado);
    }

    $b = explode("-", $ultimo_mes);
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
          <input type="hidden" name="ultima_fecha" value="<?php echo $ultimo_mes; ?>">
          <input type="hidden" name="link" value="../Basico/tareas.php">
          <button type="submit" name="menos" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Mes anterior">
            <i class="fa-solid fa-caret-left"></i>
          </button>
        </form>
      </div>
      <div class="col-auto align-self-center text-center text-white">
        <span class="h4">Tareas de  <?php echo $mes_nom; ?></span>
      </div>
      <div class="col-auto align-self-center p-0">
        <form action="../Guardar/save_fecha.php" method="POST">
          <input type="hidden" name="ultima_fecha" value="<?php echo $ultimo_mes; ?>">
          <input type="hidden" name="link" value="../Basico/tareas.php">
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

      <div class="row justify-content-center p-1">
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#descarga">+</button> 
      </div>

      <!-- MODAL DE TAREAS -->
        <div class="modal fade" id="descarga" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel_descarga" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
              <form action="../Guardar/save_tareas.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                  <h5 class="modal-title">Nueva tarea</h5>
                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                  </button>
                </div>
                <div class="modal-body" style="max-height: 30rem;">
                  
                  <div class="form-row">
                    <div class="form-group col-md-4 col-12">
                      <label>Titulo breve</label>
                      <input type="text" name="titulo" class="form-control" required autofocus>
                    </div>
                    <div class="form-group col-md-4 col-6">
                      <label>Tipo</label >
                      <select type="text" name="tarea" class="form-control" required>
                        <option selected value="" disabled>Tipo...</option>
                        <option value="Administrativo">Administrativo</option>
                        <option value="Corpo">Corpo</option><!--realiza cambio Jorge--->
                        <option value="ATC">ATC</option>
                        <option value="Deposito">Deposito</option>
                        <option value="Web">Web</option>
                        <option value="Otro">Otro</option>
                      </select>
                    </div>
                    <div class="form-group col-md-4 col-6">
                      <label>Inicio de Tarea</label >
                      <input type="date" name="inicio" class="form-control" required>
                    </div>
                    <div class="form-group col-md-4 col-6"><!--realiza cambio Jorge--->
                      <label>Final de Tarea</label >
                      <input type="date" name="fin" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-12 p-2">
                      <label>Sub tareas</label>
                      <button id="adicional" name="adicional" type="button" class="btn btn-sm btn-outline-info">Agregar</button>
                    </div>
                  </div>
                  <div class="form-row" id="tabla">
                    <div class="col-md-12 p-1 m-1 fila-fija" id="pepe">
                      <div class="input-group mb-3">
                        <input type="text" class="form-control" name="item[]" id="item" placeholder="Ingresar subtarea" aria-describedby="button-addon2">
                        <div class="input-group-append eliminar" hidden>
                          <button class="btn btn-outline-danger" type="button" id="button-addon2"><i class="fa-solid fa-trash-can"></i></button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-12 p-2">
                      <label>Descripcion</label>
                      <textarea type="text" name="descripcion" class="form-control"></textarea>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-12 p-2">
                      <label for="Range">Prioridad</label>
                      <input type="range" class="custom-range" name="prioridad" min="1" max="5" id="Range">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-12 p-2">
                      <label>Involucrados</label>
                      <div class="row">
                          <?php
                            $ejecutar_notass = mysqli_query($conn,"SELECT * FROM usuarios ORDER BY nombre asc");
                          ?>
                          <?php foreach ($ejecutar_notass as $opciones): ?>
                          <?php $compartir_nota = $opciones['nombre'] .' ' .$opciones['apellido'];
                          if($compartir_nota !== $quien_notas) 
                          {$comp_nota = $compartir_nota; ?>
                            <div class="checkbox col-md-3 col-6">
                              <label><input type="checkbox" name="a_quien[]" value="<?php echo $comp_nota; ?>">  <?php echo $comp_nota ?></label>
                            </div>
                          <?php } ?>
                          <?php endforeach ?>
                      </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-12 p-2">
                      <label>Archivos (jpg, jpeg, png, pdf, doc, docx, xls, xlsx, csv, kml, kmz)</label>
                      <div class="form-row">
                        <div class="col-md-12 p-2">
                          <div class="form-group">
                            <label for="imagen1">Subir 1° archivo</label>
                            <input type="file" class="form-control-file" id="imagen1" lang="es" name="imagen1">
                          </div>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="col-md-12 p-2">
                          <div class="form-group">
                            <label for="imagen2">Subir 2° archivo</label>
                            <input type="file" class="form-control-file" id="imagen2" lang="es" name="imagen2">
                          </div>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="col-md-12 p-2">
                          <div class="form-group">
                            <label for="imagen3">Subir 3° archivo</label>
                            <input type="file" class="form-control-file" id="imagen3" lang="es" name="imagen3">
                          </div>
                        </div>
                      </div> 
                    </div>
                  </div>

                </div>
                <div class="modal-footer">
                  <input type="submit" name="guardar" class="btn btn-success" value="Guardar">
                </div>
              </form>
            </div>
          </div>
        </div>
      <!-- MODAL DE TAREAS -->

      <nav>
      <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-tablero-tab" data-toggle="tab" data-target="#nav-tablero" type="button" role="tab" aria-controls="nav-tablero" aria-selected="true">Tablero</button>
        <button class="nav-link" id="nav-lista-tab" data-toggle="tab" data-target="#nav-lista" type="button" role="tab" aria-controls="nav-lista" aria-selected="false">Lista</button>
      </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-tablero" role="tabpanel" aria-labelledby="nav-tablero-tab">

          <div class="row justify-content-center p-2">
            <?php
              $estados = mysqli_query($conn, "SELECT * FROM tareas WHERE mensaje = '' AND estado <> '' GROUP BY estado ORDER BY id asc");
              while($ro = mysqli_fetch_assoc($estados))
              {
                $estado = $ro['estado'] ;
                $color_estado = $ro['color'] ;
              ?>
              <div class="col-md-3 col-12 p-2">
                <div class="card bg-white rounded shadow-sm">
                  <div class="card-header bg-light p-2">
                    <?php echo $estado;?>
                  </div>
                  <div class="card-body p-1">
                    <div class="accordion" id="accordionExample">
                      <?php
                          $pen = mysqli_query($conn, "SELECT *, COUNT(estado) as 'tareas_pendientes' FROM tareas WHERE estado = '$estado' AND inicio LIKE '%$ultimo_mes%' AND mensaje = '' AND quien = '$quien_notas' AND sub_tarea = '' OR estado = '$estado' AND inicio LIKE '%$ultimo_mes%' AND mensaje = '' AND a_quien LIKE '%$quien_notas%' AND sub_tarea = '' GROUP BY tarea ORDER BY id desc");
                          while($row = mysqli_fetch_assoc($pen))
                          {
                            $abrev_token = $row['abreviado'];
                        ?>
                        <div class="card-header shadow-sm bg-white m-1 p-1">
                          <div class="collapsed p-1 m-1" type="button" data-toggle="collapse" data-target="#<?php echo $abrev_token.$color_estado; ?>">
                            <div class="row p-1">
                              <div class="col-12">
                                <span><?php echo $row['tarea']; ?></span>
                              </div>
                            </div>
                            <div class="row justify-content-between p-1">
                              <div class="col-6">
                                <span><i class="fa-solid fa-circle text-<?php echo $row['color']; ?>"></i></span>
                              </div>
                              <div class="col-6 text-right">
                                <span class="badge badge-pill badge-dark"><?php echo $row['tareas_pendientes']; ?></span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <?php 
                          $pendi = mysqli_query($conn, "SELECT * FROM tareas WHERE estado = '$estado' AND abreviado = '$abrev_token' AND inicio LIKE '%$ultimo_mes%' AND mensaje = '' AND sub_tarea = '' GROUP BY token ORDER BY id desc");
                          while($roww = mysqli_fetch_assoc($pendi))
                          {
                            $quienes = $roww['a_quien'];
                            $color_tarea = $roww['color'] ;
                            $token_tarea = $roww['color'] .$roww['id'];
                            $token_task = $roww['token'] ;
                        ?>
                          <div id="<?php echo $abrev_token.$color_estado; ?>" class="collapse shadow-sm m-1 p-1" data-parent="#accordionExample">
                            <div class="card card-body border-<?php echo $color_tarea; ?> m-1 p-1" >
                              <span class="p-1" type="button" data-toggle="modal" data-target="#<?php echo $token_tarea; ?>"><?php echo $roww['titulo']; ?></span>
                              <div class="row justify-content-between p-1" type="button" data-toggle="modal" data-target="#<?php echo $token_tarea; ?>">
                                <div class="col-6">
                                  <span><i class="fa-regular fa-circle-dot text-<?php echo $color_tarea; ?>"></i></span>
                                </div>
                                <div class="col-6 text-right">
                                  <?php
                                    if($quienes !== '')
                                    {
                                      $cuantos_son = count(explode(",", $quienes));
                                      ?>
                                        <span class="badge badge-info" data-toggle="tooltip" data-placement="top" title="<?php echo $quienes; ?>"><?php echo $cuantos_son; ?></span>
                                      <?php
                                    }
                                  ?>
                                </div>
                              </div>
                              <?php if($roww['quien'] == $quien_notas) {?>
                                <?php if($estado == 'Backlog')
                                  {
                                    ?>
                                      <div class="row justify-content-end p-1">
                                        <div class="col">
                                          <button type="button" class="btn btn-outline-danger p-2" data-toggle="modal" data-target="#borrar_<?php echo $token_tarea; ?>">Borrar</button>
                                          <button type="button" class="btn btn-outline-warning p-2" data-toggle="modal" data-target="#editar_<?php echo $token_tarea; ?>">Editar</button>
                                          <a class="btn btn-outline-primary p-2" href="../Guardar/save_tareas.php?sprint=<?php echo $token_task; ?>" role="button">Sprint</a>
                                        </div>
                                      </div>
                                    <?php
                                  }
                                ?>
                                <?php if($estado == 'Sprint')
                                  {
                                    ?>
                                      <div class="row justify-content-end p-1">
                                        <div class="col">
                                          <button type="button" class="btn btn-outline-danger p-2" data-toggle="modal" data-target="#borrar_<?php echo $token_tarea; ?>">Borrar</button>                                      
                                          <a class="btn btn-outline-warning p-2" href="../Guardar/save_tareas.php?backlog=<?php echo $token_task; ?>" role="button">Backlog</a>
                                          <a class="btn btn-outline-info p-2" href="../Guardar/save_tareas.php?revision=<?php echo $token_task; ?>" role="button">Revision</a>
                                        </div>
                                      </div>
                                    <?php
                                  }
                                ?>
                                <?php if($estado == 'En revision')
                                  {
                                    ?>
                                      <div class="row justify-content-end p-1">
                                        <div class="col">
                                          <a class="btn btn-outline-primary p-2" href="../Guardar/save_tareas.php?sprint=<?php echo $token_task; ?>" role="button">Sprint</a>
                                          <a class="btn btn-outline-success p-2" href="../Guardar/save_tareas.php?finalizar=<?php echo $token_task; ?>" role="button">Finalizar</a>
                                        </div>
                                      </div>
                                    <?php
                                  }
                                ?>
                                <?php if($estado == 'Finalizado')
                                  {
                                    ?>
                                      <div class="row justify-content-end p-1">
                                        <div class="col">
                                          <a class="btn btn-outline-info p-2" href="../Guardar/save_tareas.php?revision=<?php echo $token_task; ?>" role="button">Revision</a>
                                        </div>
                                      </div>
                                    <?php
                                  }
                                ?>
                              <?php } ?>
                              
                            </div>
                          </div>
                          <!-- Borrar -->
                            <div class="modal fade" id="borrar_<?php echo $token_tarea; ?>" tabindex="-1" aria-hidden="true" style="z-index:1060;">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title h5"><?php echo $roww['titulo']; ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    ¿Seguro que quiere borrar la tarea?
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-danger p-2" data-dismiss="modal">No</button>
                                    <a class="btn btn-success p-2" href="../Borrar/delete_tareas.php?token=<?php echo $token_task; ?>" role="button">Si</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          <!-- Borrar -->
                          <!-- Editar -->
                            <div class="modal fade" id="editar_<?php echo $token_tarea; ?>" tabindex="-1" aria-hidden="true" style="z-index:1060;">
                              <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title h5"><?php echo $roww['titulo']; ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <form action="../Guardar/save_tareas.php?actualizar=<?php echo $roww['token']; ?>" method="POST">
                                    <div class="modal-body" style="max-height: 40rem;">
                                      <div class="form-row">
                                        <div class="form-group col-md-4 col-12">
                                          <label>Titulo breve</label>
                                          <input type="text" name="titulo" class="form-control" value="<?php echo $roww['titulo']; ?>">
                                        </div>
                                        <div class="form-group col-md-4 col-6">
                                          <label>Tipo</label >
                                          <select type="text" name="tarea" class="form-control">
                                            <option selected value="<?php echo $roww['tarea']; ?>"><?php echo $roww['tarea']; ?></option>
                                            <option value="Administrativo">Administrativo</option>
                                            <option value="ATC">ATC</option>
                                            <option value="Deposito">Deposito</option>
                                            <option value="Web">Web</option>
                                            <option value="Otro">Otro</option>
                                          </select>
                                        </div>
                                        <div class="form-group col-md-4 col-6">
                                          <label>Final</label >
                                          <input type="date" name="fin" class="form-control" value="<?php echo $roww['fin']; ?>">
                                        </div>
                                      </div>
                                      <?php
                                        $sub = mysqli_query($conn, "SELECT * FROM tareas WHERE token = '$token_task' AND sub_tarea <> '' AND mensaje = ''");
                                        if (mysqli_num_rows($sub) > 0)
                                        {
                                          $sub_t = mysqli_query($conn, "SELECT * FROM tareas WHERE token = '$token_task' AND sub_tarea <> '' AND mensaje = '' ORDER BY id desc");
                                          while($row_sub = mysqli_fetch_assoc($sub_t))
                                          {
                                            $id_sub = $row_sub['id'];
                                            ?>
                                              <input type="hidden" name="id[]" value="<?php echo $id_sub; ?>">
                                              <div class="input-group mb-1">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text <?php if($row_sub['sub_estado'] == 'Finalizado'){echo 'alert-success';} ?>" id="sub_<?php echo $id_sub; ?>"><i class="fa-regular fa-circle-check"></i></span>
                                                </div>
                                                <input type="text" name="sub[]" class="form-control" value="<?php echo $row_sub['sub_tarea']; ?>" aria-describedby="sub_<?php echo $id_sub; ?>" <?php if($row_sub['sub_estado'] == 'Finalizado'){echo 'readonly';} ?>>
                                              </div>
                                            <?php
                                          }
                                        }
                                        else
                                        {
                                          ?>
                                            <div class="form-row">
                                              <div class="col-12 p-2">
                                                <label>Sub tareas</label>
                                                <button id="adicional_sub<?php echo $token_tarea; ?>" name="adicional_sub" type="button" class="btn btn-sm btn-outline-info">Agregar</button>
                                              </div>
                                            </div>
                                            <div class="form-row" id="tabla_sub<?php echo $token_tarea; ?>">
                                              <div class="col-md-12 p-1 m-1 fila-fija_sub<?php echo $token_tarea; ?>" id="pepe_sub<?php echo $token_tarea; ?>">
                                                <div class="input-group mb-3">
                                                  <input type="text" class="form-control" name="item_sub[]" id="item_sub<?php echo $token_tarea; ?>" placeholder="Ingresar subtarea" aria-describedby="button-addon2">
                                                  <div class="input-group-append eliminar_sub<?php echo $token_tarea; ?>" hidden>
                                                    <button class="btn btn-outline-danger" type="button" id="button-addon2"><i class="fa-solid fa-trash-can"></i></button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            <script>
                                              $(function(){
                                                // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
                                                $("#adicional_sub<?php echo $token_tarea; ?>").on('click', function(){
                                                  $("#pepe_sub<?php echo $token_tarea; ?>:eq(0)").clone().removeClass('fila-fija_sub<?php echo $token_tarea; ?>').appendTo("#tabla_sub<?php echo $token_tarea; ?>"); //Toma todo lo que esta en el ID "pepe", borra la clase "fila-fija" y lo clona
                                                  $(".eliminar_sub<?php echo $token_tarea; ?>").removeAttr('hidden'); ///Elimino el atributo hhiden
                                                  $(".eliminar_sub<?php echo $token_tarea; ?>:eq(0)").attr('hidden','hidden'); ///Agrego el atributo hidden solo a la primera clase "eliminar_sub"
                                                  document.getElementById("item_sub<?php echo $token_tarea; ?>").value = ""; ////limpia el input
                                                });
                                                
                                                // Evento que selecciona la fila y la elimina 
                                                $(document).on("click",".eliminar_sub<?php echo $token_tarea; ?>",function(){
                                                  var parent = $(this).parents().get(1);
                                                  if ($('.eliminar_sub<?php echo $token_tarea; ?>').length > 1) /* SI LA CANTIDAD DE LA CLASE "eliminar_sub" ES MAYOR A 1 SE REMUEVE EL PADRE */ 
                                                  {
                                                    $(parent).remove();
                                                  }
                                                });
                                              });
                                            </script>
                                          <?php
                                        }
                                      ?>
                                      <div class="form-row">
                                        <div class="col-md-12 p-2">
                                          <label>Descripcion</label>
                                          <textarea type="text" name="descripcion" class="form-control"><?php echo $roww['descripcion']; ?></textarea>
                                        </div>													
                                      </div>
                                      <div class="form-row">
                                        <div class="col-md-12 p-2">
                                          <label for="Range">Prioridad</label>
                                          <input type="range" class="custom-range" name="prioridad" min="1" max="5" id="Range" value="<?php echo $roww['prioridad'] ?>">
                                        </div>
                                      </div>
                                      <div class="form-row">
                                        <div class="col-12 p-2">
                                          <label>Involucrados</label>
                                          <div class="row">
                                            <?php
                                              $ejecutar_notass = mysqli_query($conn,"SELECT * FROM usuarios ORDER BY nombre asc");
                                            ?>
                                            <?php foreach ($ejecutar_notass as $opciones): ?>
                                            <?php $compartir_nota = $opciones['nombre'] .' ' .$opciones['apellido'];
                                              if($compartir_nota !== $quien_notas) 
                                              {$comp_nota = $compartir_nota;
                                            ?>
                                              <div class="checkbox col-md-3 col-6">
                                                <label><input type="checkbox" name="a_quien[]" value="<?php echo $comp_nota; ?>" <?php if(strpos($roww['a_quien'], $comp_nota) !== false){echo 'checked';}else{echo '';} ?>>  <?php echo $comp_nota ?></label>
                                              </div>
                                            <?php } ?>
                                            <?php endforeach ?>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <input type="submit" class="btn btn-warning" value="Actualizar">
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          <!-- Editar -->
                          <!-- Modal tarea -->
                            <div class="modal fade" id="<?php echo $token_tarea; ?>" tabindex="-1" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title h5"><?php echo $roww['titulo']; ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <div class="row p-1">
                                      <div class="col-12 p-2">
                                        <p class="h6 text-muted">Creador:</p> 
                                        <p class="ml-4"><?php echo $roww['quien']; ?></p>
                                      </div>
                                    </div>
                                    <div class="row p-1">
                                      <div class="col-12 p-2">
                                        <p class="h6 text-muted">Final estimado:</p>
                                        <?php
                                          $d1 = new DateTime(date('Y-m-d'));
                                          $d2 = new DateTime($roww['fin']);
                                          $diff = $d2->diff($d1);
                                          if(date('Y-m-d') < $roww['fin'])
                                          {
                                            $dias_restantes = $diff->days . " dias restantes";
                                          }
                                          else
                                          {
                                            $dias_restantes = 'Pasaron ' .$diff->days .' dias.';
                                          }
                                          if(date('Y-m-d') == $roww['fin'])
                                          {
                                            $dias_restantes = "Hoy es el ultimo dia";
                                          }
                                        ?>
                                        <p class="ml-4"><?php echo Fecha7($roww['fin']) .' (' .$dias_restantes .')'; ?></p>                                    
                                      </div>
                                    </div>
                                    <div class="row justify-content-around p-1">
                                      <div class="col-10 p-2">
                                        <div id="check<?php echo $roww['token']; ?>"></div>
                                        <script>
                                            $(document).ready(function(){
                                              $('#check<?php echo $roww['token']; ?>').load('../Ajax/a_check.php?token=<?php echo $roww['token']; ?>')
                                            });
                                          setInterval(function(){
                                            $('#check<?php echo $roww['token']; ?>').load('../Ajax/a_check.php?token=<?php echo $roww['token']; ?>')
                                          },5000);
                                        </script>
                                      </div>
                                    </div>
                                    <div class="row p-1">
                                      <div class="col-12 p-2">
                                        <p class="h6 text-muted">Descripcion:</p> 
                                        <p class="ml-4"><?php echo $roww['descripcion']; ?></p>
                                      </div>
                                    </div>
                                    <div class="row p-1">
                                      <div class="col-12 p-2">
                                        <p class="h6 text-muted">Prioridad:</p> 
                                        <p class="ml-4"><?php echo $roww['prioridad']; ?></p>
                                      </div>
                                    </div>
                                    <div class="row p-1">
                                      <div class="col-12 p-2">
                                        <p class="h6 text-muted">Involucrados:</p> 
                                        <p class="ml-4"><?php echo $roww['a_quien']; ?></p>
                                      </div>
                                    </div>
                                    <?php if ($roww['archivo_uno'] !== '' || $roww['archivo_dos'] !== '' || $roww['archivo_tres'] !== '') { ?>
                                      <div class="row justify-content-center p-1">
                                        <div class="col-12 p-2">
                                          <p class="h6 text-muted">Archivos adjuntos:</p>
                                        </div>
                                        <?php if ($roww['archivo_uno'] !== ''){ ?>
                                          <div class="col-4 p-2 text-center">
                                            <a href="../Archivos/tareas/<?php echo $row['archivo_uno']; ?>" download="<?php echo $row['nom_archivo_uno']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $row['nom_archivo_uno']; ?>"><i class="fas fa-file-download"></i><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a>
                                          </div>
                                        <?php } ?>
                                        <?php if ($roww['archivo_dos'] !== ''){ ?>
                                          <div class="col-4 p-2 text-center">
                                            <a href="../Archivos/tareas/<?php echo $row['archivo_dos']; ?>" download="<?php echo $row['nom_archivo_dos']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $row['nom_archivo_dos']; ?>"><i class="fas fa-file-download"></i><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a>
                                          </div>
                                        <?php } ?>
                                        <?php if ($roww['archivo_tres'] !== ''){ ?>
                                          <div class="col-4 p-2 text-center">
                                            <a href="../Archivos/tareas/<?php echo $row['archivo_tres']; ?>" download="<?php echo $row['nom_archivo_tres']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $row['nom_archivo_tres']; ?>"><i class="fas fa-file-download"></i><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a>
                                          </div>
                                        <?php } ?>
                                      </div>
                                    <?php } ?>
                                      <form onsubmit="enviar<?php echo $roww['token']; ?>(); return false" id="form<?php echo $roww['token']; ?>">
                                        <input type="hidden" name="token" value="<?php echo $roww['token']; ?>">
                                        <input type="hidden" name="quien" value="<?php echo $roww['quien']; ?>">
                                        <input type="hidden" name="titulo" value="<?php echo $roww['titulo']; ?>">
                                        <input type="hidden" name="tarea" value="<?php echo $roww['tarea']; ?>">
                                        <input type="hidden" name="inicio" value="<?php echo $roww['inicio']; ?>">
                                        <input type="hidden" name="fin" value="<?php echo $roww['fin']; ?>">
                                        <input type="hidden" name="prioridad" value="<?php echo $roww['prioridad']; ?>">
                                        <label for="input_msj">Comentario:</label>
                                        <div class="input-group mb-3">
                                          <input type="text" class="form-control input_msj" id="input_msj" name="mensajes" placeholder="Dejar comentario..." aria-describedby="button-enviar" autofocus>
                                          <div class="input-group-append">
                                            <button class="btn btn-outline-success" type="submit" id="button-enviar"><i class="fa-regular fa-comment"></i></button>
                                          </div>
                                        </div>
                                      </form>

                                      <div id="msj<?php echo $roww['token']; ?>"></div>
                                      <script>
                                        setInterval(function(){
                                          $(document).ready(function(){
                                            $('#msj<?php echo $roww['token']; ?>').load('../Ajax/a_mensajes.php?token=<?php echo $roww['token']; ?>')
                                          });
                                        },5000);
                                      </script>
                                      <script>
                                        function enviar<?php echo $roww['token']; ?>()
                                        {	
                                          $.ajax({
                                          type: 'POST',
                                          url: '../Ajax/a_tarea.php',
                                          data: $('#form<?php echo $roww['token']; ?>').serialize(),
                                          success: function(respuesta) {
                                            if(respuesta=='ok')
                                            {
                                              $('#msj<?php echo $roww['token']; ?>').load('../Ajax/a_mensajes.php?token=<?php echo $roww['token']; ?>'),
                                              $('.input_msj[type="text"]').val('');
                                            }
                                          }
                                          });
                                        }
                                      </script>
                                  </div>
                                  <?php if($roww['quien'] == $quien_notas) {?>
                                    <div class="modal-footer">
                                      <?php if($estado == 'Backlog')
                                        {
                                          ?>
                                            <div class="row justify-content-end p-1">
                                              <div class="col">
                                                <button type="button" class="btn btn-outline-danger p-2" data-toggle="modal" data-target="#borrar_<?php echo $token_tarea; ?>">Borrar</button>
                                                <button type="button" class="btn btn-outline-warning p-2" data-toggle="modal" data-target="#editar_<?php echo $token_tarea; ?>">Editar</button>
                                                <a class="btn btn-outline-primary p-2" href="../Guardar/save_tareas.php?sprint=<?php echo $token_task; ?>" role="button">Sprint</a>
                                              </div>
                                            </div>
                                          <?php
                                        }
                                      ?>
                                      <?php if($estado == 'Sprint')
                                        {
                                          ?>
                                            <div class="row justify-content-end p-1">
                                              <div class="col">
                                                <button type="button" class="btn btn-outline-danger p-2" data-toggle="modal" data-target="#borrar_<?php echo $token_tarea; ?>">Borrar</button>                                      
                                                <a class="btn btn-outline-warning p-2" href="../Guardar/save_tareas.php?backlog=<?php echo $token_task; ?>" role="button">Backlog</a>
                                                <a class="btn btn-outline-info p-2" href="../Guardar/save_tareas.php?revision=<?php echo $token_task; ?>" role="button">Revision</a>
                                              </div>
                                            </div>
                                          <?php
                                        }
                                      ?>
                                      <?php if($estado == 'En revision')
                                        {
                                          ?>
                                            <div class="row justify-content-end p-1">
                                              <div class="col">
                                                <a class="btn btn-outline-primary p-2" href="../Guardar/save_tareas.php?sprint=<?php echo $token_task; ?>" role="button">Sprint</a>
                                                <a class="btn btn-outline-success p-2" href="../Guardar/save_tareas.php?finalizar=<?php echo $token_task; ?>" role="button">Finalizar</a>
                                              </div>
                                            </div>
                                          <?php
                                        }
                                      ?>
                                      <?php if($estado == 'Finalizado')
                                        {
                                          ?>
                                            <div class="row justify-content-end p-1">
                                              <div class="col">
                                                <a class="btn btn-outline-info p-2" href="../Guardar/save_tareas.php?revision=<?php echo $token_task; ?>" role="button">Revision</a>
                                              </div>
                                            </div>
                                          <?php
                                        }
                                      ?>
                                    </div>
                                  <?php } ?>
                                </div>
                              </div>
                            </div>
                          <!-- Modal tarea -->
                        <?php } ?>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>

        </div>
        <div class="tab-pane fade" id="nav-lista" role="tabpanel" aria-labelledby="nav-lista-tab">
          <div class="row justify-content-center p-1">
            <div class="col-auto">
              <p class="h4 mb-4 text-center">Tareas cargadas</p>
              <table class="table table-responsive table-striped table-bordered table-sm">
                <thead class="thead-dark text-center">
                  <tr>
                    <th>Acciones</th>
                    <th>Estado</th>
                    <th>Prioridad</th>
                    <th>Creador</th>
                    <th>Tarea</th>
                    <th>Titulo</th>                
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Involucrados</th>
                  </tr>
                </thead>
                <tbody align="center">
                  <?php
                    $result_tasks = mysqli_query($conn, "SELECT * FROM tareas WHERE  inicio LIKE '%$ultimo_mes%' AND mensaje = '' AND quien = '$quien_notas' AND sub_tarea = '' OR  inicio LIKE '%$ultimo_mes%' AND mensaje = '' AND a_quien LIKE '%$quien_notas%' AND sub_tarea = '' ORDER BY id desc LIMIT 10");
                    while($row = mysqli_fetch_assoc($result_tasks))
                    {
                      $tokken = $row['token'];
                  ?>
                    <tr>
                      <td align="center">
                        <?php if($row['quien'] == $quien_notas) {?>
                          <?php if($row['estado'] !== 'Finalizado') {?>
                            <button type="button" class="btn p-2" data-toggle="modal" data-target="#editar_<?php echo $row['token'].$row['color']; ?>"><i class="fas fa-pen p-2 text-warning"></i></button>
                            <!-- Editar -->
                              <div class="modal fade" id="editar_<?php echo $row['token'].$row['color']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                  <div class="modal-content">
                                    <form action="../Guardar/save_tareas.php?actualizar=<?php echo $row['token']; ?>" method="POST">
                                      <div class="modal-header">
                                        <h5 class="modal-title h5"><?php echo $row['titulo']; ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body" style="max-height: 40rem;">
                                        <div class="form-row">
                                          <div class="form-group col-md-4 col-12">
                                            <label>Titulo breve</label>
                                            <input type="text" name="titulo" class="form-control" value="<?php echo $row['titulo']; ?>">
                                          </div>
                                          <div class="form-group col-md-4 col-6">
                                            <label>Tipo</label >
                                            <select type="text" name="tarea" class="form-control">
                                              <option selected value="<?php echo $row['tarea']; ?>"><?php echo $row['tarea']; ?></option>
                                              <option value="Administrativo">Administrativo</option>
                                              <option value="ATC">ATC</option>
                                              <option value="Deposito">Deposito</option>
                                              <option value="Web">Web</option>
                                              <option value="Otro">Otro</option>
                                            </select>
                                          </div>
                                          <div class="form-group col-md-4 col-6">
                                            <label>Final</label >
                                            <input type="date" name="fin" class="form-control" value="<?php echo $row['fin']; ?>">
                                          </div>
                                        </div>
                                        <div class="form-row">
                                          <div class="col-12 p-2">
                                            <label>Involucrados</label>
                                            <div class="row">
                                              <?php
                                                $ejecutar_notass = mysqli_query($conn,"SELECT * FROM usuarios ORDER BY nombre asc");
                                              ?>
                                              <?php foreach ($ejecutar_notass as $opciones): ?>
                                              <?php $compartir_nota = $opciones['nombre'] .' ' .$opciones['apellido'];
                                                if($compartir_nota !== $quien_notas) 
                                                {$comp_nota = $compartir_nota;
                                              ?>
                                                <div class="checkbox col-md-3 col-6">
                                                  <label><input type="checkbox" name="a_quien[]" value="<?php echo $comp_nota; ?>" <?php if(strpos($row['a_quien'], $comp_nota) !== false){echo 'checked';}else{echo '';} ?>>  <?php echo $comp_nota ?></label>
                                                </div>
                                              <?php } ?>
                                              <?php endforeach ?>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="form-row">
                                          <div class="col-md-12 p-2">
                                            <label>Descripcion</label>
                                            <textarea type="text" name="descripcion" class="form-control"><?php echo $row['descripcion']; ?></textarea>
                                          </div>													
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <input type="submit" class="btn btn-warning" value="Actualizar">
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            <!-- Editar -->
                          <?php } ?>
                          <button type="button" class="btn p-2" data-toggle="modal" data-target="#borrar_<?php echo $row['token'].$row['color']; ?>"><i class="far fa-trash-alt p-2 text-danger"></i></button>
                          <!-- Borrar -->
                            <div class="modal fade" id="borrar_<?php echo $row['token'].$row['color']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title h5"><?php echo $row['titulo']; ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    ¿Seguro que quiere borrar la tarea?
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-danger p-2" data-dismiss="modal">No</button>
                                    <a class="btn btn-success p-2" href="../Borrar/delete_tareas.php?token=<?php echo $row['token']; ?>" role="button">Si</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          <!-- Borrar -->
                        <?php }else{echo'';} ?>
                      </td>
                        <?php switch($row['estado']){case 'Finalizado': $color_tarea = 'badge-success';break; case 'Backlog': $color_tarea = 'badge-warning';break; case 'Sprint': $color_tarea = 'badge-primary';break; } ?>
                      <td style="cursor: pointer;" class="toggler" data-prod-cat="<?php echo $tokken; ?>"><span class="badge <?php echo $color_tarea; ?>"><?php echo $row['estado']; ?></span></td>
                      <td><?php echo $row['prioridad']; ?></td>
                      <td><?php echo $row['quien']; ?></td>
                      <td><?php echo $row['tarea']; ?></td>
                      <td><?php echo $row['titulo']; ?></td>                  
                      <td><?php echo Fecha7($row['inicio']); ?></td>
                      <td><?php echo Fecha7($row['fin']); ?></td>
                      <td><?php if($row['a_quien'] !== ''){echo '<i class="fa-solid fa-users" data-toggle="tooltip" data-placement="bottom" title="' .$row['a_quien'] .'"></i>';} ?></td>
                    </tr>
                    <tr class="cat<?php echo $tokken; ?>" style="display:none">
                      <td colspan="3"></td>
                      <td colspan="6">
                        <?php
                          $rr = mysqli_query($conn, "SELECT * FROM tareas WHERE token = '$tokken' AND sub_tarea <> ''");
                          while($roww = mysqli_fetch_assoc($rr)) 
                          {
                        ?>
                          <?php echo $roww['sub_tarea'] .' ' .'[' .$roww['sub_estado'] .']<br>';  ?>
                        <?php } ?>
                      </td>
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
<script>
  $(document).ready(function(){
    $('.toast').toast('show');
  });
</script>
<script>
  $(function(){
    // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
    
    $("#adicional").on('click', function(){
      $("#pepe:eq(0)").clone().removeClass('fila-fija').appendTo("#tabla"); //Toma todo lo que esta en el ID "pepe", borra la clase "fila-fija" y lo clona
      
      $(".eliminar").removeAttr('hidden'); ///Elimino el atributo hhiden
      $(".eliminar:eq(0)").attr('hidden','hidden'); ///Agrego el atributo hidden solo a la primera clase "elimniar"

      document.getElementById("item").value = ""; ////limpia el input
    });
    
    // Evento que selecciona la fila y la elimina 
    $(document).on("click",".eliminar",function(){
      var parent = $(this).parents().get(1);
      if ($('.eliminar').length > 1) /* SI LA CANTIDAD DE LA CLASE "eliminar" ES MAYOR A 1 SE REMUEVE EL PADRE */ 
      {
        $(parent).remove();
      }
    });
  });
</script>
<script>
  $(function(){
    // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
    $("#adicional_sub").on('click', function(){
      $("#pepe_sub:eq(0)").clone().removeClass('fila-fija_sub').appendTo("#tabla_sub"); //Toma todo lo que esta en el ID "pepe", borra la clase "fila-fija" y lo clona
      $(".eliminar_sub").removeAttr('hidden'); ///Elimino el atributo hhiden
      $(".eliminar_sub:eq(0)").attr('hidden','hidden'); ///Agrego el atributo hidden solo a la primera clase "eliminar_sub"
      document.getElementById("item_sub").value = ""; ////limpia el input
    });
    
    // Evento que selecciona la fila y la elimina 
    $(document).on("click",".eliminar_sub",function(){
      var parent = $(this).parents().get(1);
      if ($('.eliminar_sub').length > 1) /* SI LA CANTIDAD DE LA CLASE "eliminar_sub" ES MAYOR A 1 SE REMUEVE EL PADRE */ 
      {
        $(parent).remove();
      }
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
</body>
</html>
