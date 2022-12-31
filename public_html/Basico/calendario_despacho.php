<?php
  include('../db.php');
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
  $quien_notas = $nombre .' ' .$apellido;
  if($tipo == "Administrador") { $usu = 1; }
  if($tipo == "Despacho") { $usu = 1; }
  if($tipo == "Supervisor") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
  }

  if($_SESSION['show'] == 'Auditoria de herramientas'){$show_herra = 'active show'; $_SESSION['show'] = '';}else{$show_herra = '';}
  if($_SESSION['show'] == 'Auditoria de instalacion'){$show_insta = 'active show'; $_SESSION['show'] = '';}else{$show_insta = '';}
  if($_SESSION['show'] == 'Auditoria de vehiculo'){$show_vehi = 'active show'; $_SESSION['show'] = '';}else{$show_vehi = '';}
?>
<?php include('../includes/header.php'); ?>
<?php
  $diaSemana = date("w");
  $num_semana = 0;
  # Calcular el tiempo (no la fecha) de cuándo fue el inicio de semana
  $tiempoDeInicioDeSemana = strtotime("-" . $diaSemana . " days"); # Restamos -X days
  # Y formateamos ese tiempo
  $fechaInicioSemana = date("Y-m-d", $tiempoDeInicioDeSemana);
  $fechamas = date ('Y-m-d', strtotime($fechaInicioSemana."+$num_semana day". "+1 day"));
  # Ahora para el fin, sumamos
  $tiempoDeFinDeSemana = strtotime("+" . $diaSemana . " days"); # Sumamos +X days, pero partiendo del tiempo de inicio
  # Y formateamos
  $fechaFinSemana = date("Y-m-d", $tiempoDeFinDeSemana);
  $fechamas2 = date ('Y-m-d', strtotime($fechaFinSemana."+$num_semana day". "-1 day"));

  $semana_descripcion = "Del " .Fecha9($fechamas) ." al " .Fecha9($fechamas2);
?>
<!-- Fullcalendar -->
<link href='../lib/fullcalendar/lib/main.css' rel='stylesheet'/>
<script src='../lib/fullcalendar/lib/main.js'></script>
<script src='../lib/fullcalendar/lib/locales/es.js'></script>
<?php $_SESSION['card'] = 0; ?>
<!-- MESSAGES -->
  <div class="position-fixed top-5 right-0 p-3" style="z-index: 5; right: 0rem; top: 3rem; width: 18rem">
    <div id="liveToast" class="toast m-1" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000">
      <div class="toast-header border-success p-1 m-1">
        <strong class="mr-auto" id="titulo_toast"></strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="toast-body p-2" id="mensaje_toast"></div>
    </div>
  </div>
<!-- MESSAGES -->
<style>
  .fc-direction-ltr{
    min-height: 10rem;
    height: 14rem;
  }
    @media(max-width: 767px) {
    .fc-toolbar.fc-header-toolbar {
      display: flex;
      flex-direction: column;
    }
    .fc-toolbar.fc-header-toolbar .fc-left {
      order: 3;
    }
    .fc-toolbar.fc-header-toolbar .fc-center {
      order: 1;
    }
    .fc-toolbar.fc-header-toolbar .fc-right {
      order: 2;
    }
    .fc .fc-toolbar-title {
      font-size: 1.5em;
      margin: 0.6em;
    }
    .fc-direction-ltr{
      min-height: 11rem;
      height: 22rem;
    }
  }
</style>
<style>
  #split-container
  {
    display: flex;
    flex-direction: column;
    height:78vh
  }
  #a
  {
    flex-basis: 30%;
    overflow-y: scroll;
  }
  #b
  {
    flex-grow: 1;
    overflow-y: scroll;
  }
  #splitter
  {
    background-color: #343a40;
    flex-basis: 20px;
    flex-shrink: 0;
    flex-grow: 0;
    cursor: row-resize;
  }
</style>
<style>
  *::-webkit-scrollbar {
      width: 6px;
      height: 6px;
      background-color: #343a401f !important;
  }
  *::-webkit-scrollbar-track {
      -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
              box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
      background-color: #343a401f !important;
  }
  *::-webkit-scrollbar-thumb {
      -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
              box-shadow: inset 0 0 6px rgba(0,0,0,.3);
      background-color: #343a40 !important;
  }
</style>
<!-- FECHA -->
  <div class="container-fluid pr-4 pl-4 pt-0 pb-0">
    <div class="row justify-content-center pr-2 pl-2 pt-2 pb-0">
      <div class="col-auto align-self-center p-0">
        <input type="hidden" name="ultima_fecha"  value="<?php echo $ult_fecha; ?>">
        <button type="submit" name="menos" id="anterior_semana" class="btn btn-dark p-2 m-2" data-toggle="tooltip" data-placement="bottom" title="Dia anterior">
          <i class="fa-solid fa-caret-left"></i>
        </button>
      </div>
      <div class="col-auto align-self-center text-center text-white">
        <span class="h4" id="nombre_semana"><?php echo $semana_descripcion; ?></span>
      </div>
      <div class="col-auto align-self-center p-0">
        <input type="hidden" name="ultima_fecha" value="<?php echo $ult_fecha; ?>">
        <button type="submit" name="mas" id="siguiente_semana" class="btn btn-dark p-2 m-2" data-toggle="tooltip" data-placement="bottom" title="Dia siguiente">
          <i class="fa-solid fa-caret-right"></i>
        </button>
      </div>
    </div>
  </div>
<!-- FECHA -->
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">
      <br>
      <br>
      <br>
      <div class="row justify-content-around p-0">
        <div class="col-auto align-self-center p-1 h4 text-center">Calendario
        </div>
        <div class="col-auto align-self-center p-1">
          <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#tarea">Programar tarea</button>
          <a class="btn btn-info" role="button" href="./analisis_calendario.php">Ver analisis</a>
        </div>
      </div>
      <!-- PROGRAMAR TAREAS -->
        <!-- Modal -->
          <div class="modal fade" id="tarea">  <!-- Modal para el boton -->
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                  <form action="../Guardar/save_calendario.php" method="POST" >
                    <div class="modal-header"> <!-- Encabezado del modal -->
                      <h5 class="modal-title">Nueva tarea</h5>
                      <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                      </button>
                    </div>
                    <div class="modal-body"> <!-- Contenido del modal -->
                      
                      <div class="form-row">
                        <div class="form-group col">
                          <label>Tecnico</label >
                          <select type="text" name="tecnico" class="form-control">                
                            <option selected value="">Tecnicos...</option>                
                            <?php
                              $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE tipo = 'Tecnico' AND activo ='SI' ORDER BY tecnico asc");
                              foreach ($ejecutar as $opciones):
                            ?>   
                              <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                            <?php endforeach ?>
                          </select>
                        </div>
                        <div class="form-group col">
                          <label>Tarea</label >
                          <select type="text" id="select_tarea" name="tarea" class="form-control" required>
                            <option selected value="" disabled>Tipo...</option>
                            <option value="Garantia">Garantia</option>
                            <option value="Reclamo">Reclamo</option>
                            <option value="Relevamiento fotografico">Relevamiento fotografico</option>
                            <option value="Otro">Otro</option>
                          </select>
                        </div>
                        <div hidden class="form-group col" id="ot_garantia">
                          <label>OT garantia</label>
                          <input type="text" name="ot_garantia" class="form-control selec_garantia" >
                        </div>
                        <div hidden class="form-group col" id="ot_reclamo">
                          <label>OT reclamo</label>
                          <input type="text" name="ot_reclamo" class="form-control selec_reclamo" >
                        </div>
                      </div>
                      <input hidden type="text" class="form-control prueba" name="id_garantia" id="valor_id_garantia">
                      <div hidden class="row" id="obt_id_garantia">
                        <div class="form-group col-12">
                          <div class="sugerido_garantia" id="suggestions"></div>
                        </div>
                      </div>
                      <input hidden type="text" class="form-control prueba_reclamo" name="id_reclamo" id="valor_id_reclamo">
                      <div hidden class="row" id="obt_id_reclamo">
                        <div class="form-group col-12">
                          <div class="sugerido_reclamo" id="suggestions"></div>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6 col-6">
                          <label>Supervisor</label >
                          <select type="text" name="a_quien[]" class="form-control">
                            <option selected value="" disabled>Supervisor...</option>
                            <?php
                              $ejecutar=mysqli_query($conn,"SELECT * FROM usuarios WHERE tipo_us = 'Supervisor' ORDER BY nombre asc");
                              foreach ($ejecutar as $opciones):
                            ?>   
                              <option value="<?php echo $opciones['nombre'] .' ' .$opciones['apellido']; ?>"><?php echo $opciones['nombre'] .' ' .$opciones['apellido']; ?></option>                                      
                            <?php endforeach ?>
                          </select>
                        </div>
                        <div class="form-group col-md-6 col-6">
                          <label>Inicio</label >
                          <input type="date" name="inicio" class="form-control" required>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="col-md-12 p-2">
                          <label class="text-muted">Descripcion</label>
                          <textarea type="text" name="contenido" class="form-control"></textarea>
                        </div>													
                      </div>														
                    </div>
                    <div class="modal-footer"> <!-- Pie del modal -->
                      <input type="submit" name="guardar" class="btn btn-primary" value="Guardar">
                    </div>                            
                  </form>
                </div>
            </div>              
          </div>
        <!-- Modal -->
      <!-- PROGRAMAR TAREAS -->

      <div id="split-container">
        <div class="split-pane"id="a">
          <div class="container-fluid p-0">
            <div class="col-12">

              <nav>
                <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
                  <button class="nav-link active show <?php echo $show_herra; ?>" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><div class="d-none d-md-block">Auditoria de herramientas</div><div class="d-none d-block d-md-none"><i class="fa-solid fa-screwdriver-wrench"></i></div></button>
                  <button class="nav-link <?php echo $show_insta; ?>" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false"><div class="d-none d-md-block">Auditoria de instalacion</div><div class="d-none d-block d-md-none"><i class="fa-solid fa-house-chimney"></i></div></button>
                  <button class="nav-link <?php echo $show_vehi; ?>" id="nav-contact-tab" data-toggle="tab" data-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false"><div class="d-none d-md-block">Auditoria vehiculo</div><div class="d-none d-block d-md-none"><i class="fa-solid fa-car-side"></i></div></button>
                </div>
              </nav>
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade active show <?php echo $show_herra ?>" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    
                    <div id='external-events'>
                      <div id="semana1"></div>
                    </div>
                  </div>

                  <div class="tab-pane fade <?php echo $show_insta; ?>" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    
                    <div id='external-eventos'>
                      <div id="semana2"></div>
                    </div>
                  </div>

                  <div class="tab-pane fade <?php echo $show_vehi; ?>" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    
                    <div id='external-eventes'>
                      <div id="semana3"></div>
                    </div>
                  </div>

              </div>
            </div>
          </div>
        </div>
        <div id="splitter"></div>
        <div class="split-pane" id="b">
          <div class="container-fluid p-1">
            <div class="col-12">
              <?php
                $rrrr = mysqli_query($conn, "SELECT * FROM usuarios WHERE tipo_us = 'Supervisor' ORDER BY nombre asc");
                  while($rowww=$rrrr->fetch_assoc())
                  {
              ?>
                <div class="container-fluid p-1">
                  <div id='calendar<?php echo $rowww['id']; ?>'></div>
                </div>
                <br>
              <?php } ?>

            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>


<div class="modal" id="exampleModal"  tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tarea</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <div class="row p-2">
              <div id="titulo_evento"></div>
            </div>
            <div class="row p-2">
              <div id="creador_evento"></div>
            </div>
            <div class="row p-2">
              <div id="a_quien_evento"></div>
            </div>
            <div class="row p-2">
              <div id="estadoEvento"></div>
            </div>
            <div class="row p-2">
              <div id="tomado_por_evento"></div>
            </div>
            <div class="row p-2">
              <div id="tarea_evento"></div>
            </div>
            <div class="row p-2">
              <div id="tecnico_evento"></div>
            </div>
            <div class="row p-2">
              <div id="contenido_evento"></div>
            </div>
            <div class="row p-2">
              <div id="obs_evento"></div>
            </div>
            <div class="row p-2">
              <div id="obs_supervisor"></div>
            </div>
          </div>
        </div>
        <br>

        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-link active text-muted" id="nav-si-tab" data-toggle="tab" href="#nav-si" role="tab" aria-controls="nav-si" aria-selected="true">Finalizar</a>
            <a class="nav-link text-muted" id="nav-no-tab" data-toggle="tab" href="#nav-no" role="tab" aria-controls="nav-no" aria-selected="false">Rechazar</a>
          </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-si" role="tabpanel" aria-labelledby="nav-si-tab">
            <form action="#" id="tomar_id_action_si" method="POST">
              <div class="form-row">
                <div class="col-12 p-2">
                  <label class="text-muted">Nota de cierre</label>
                  <textarea name="obs" type="text" class="form-control" style="height: 90px;"></textarea>
                </div>
              </div>
              <div class="form-row">
                <div class="col-12 p-2">
                  <input type="submit" name="finalizar" class="btn btn-success h-6" value="Finalizar">
                </div>
              </div>
            </form>
          </div>
          <div class="tab-pane fade" id="nav-no" role="tabpanel" aria-labelledby="nav-no-tab">
            <form action="#" id="tomar_id_action_no" method="POST">
              <div class="form-row">
                <div class="col-12 p-2">
                  <label class="text-muted">Nota de cierre</label>
                  <textarea name="obs" type="text" class="form-control" style="height: 90px;"></textarea>
                </div>
              </div>
              <div class="form-row">
                <div class="col-12 p-2">
                  <input type="submit" name="rechazar" class="btn btn-danger h-6" value="Rechazar">
                </div>
              </div>
            </form>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <a href="#" id="tomar_id_ver"><span class="btn btn-info">Ver</span></a>																	
        <a href="#" id="tomar_id_editar"><span class="btn btn-warning">Editar</span></a>
        <a href="#" id="tomar_id_delete"><span class="btn btn-danger">Eliminar</span></a>
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
  document.addEventListener('DOMContentLoaded', function() {
  var Calendar = FullCalendar.Calendar;
  var Draggable = FullCalendar.Draggable;
  var containerEl = document.getElementById('external-events');
  var containeroEl = document.getElementById('external-eventos');
  var containereEl = document.getElementById('external-eventes');
  // initialize the external events
  var checkbox = document.getElementById('drop-remove');
  // -----------------------------------------------------------------
  new Draggable(containerEl, {
    itemSelector: '.objeto',
  });
  new Draggable(containeroEl, {
    itemSelector: '.objeto',
  });
  new Draggable(containereEl, {
    itemSelector: '.objeto',
  });
  // initialize the calendar
  // -----------------------------------------------------------------
  <?php
    $rr = mysqli_query($conn, "SELECT * FROM usuarios WHERE tipo_us = 'Supervisor' ORDER BY nombre asc");
      while($row=$rr->fetch_assoc())
      {
        $tecnico_sup = $row['nombre'] .' ' .$row['apellido'] ;
  ?>
    var calendar<?php echo $row['id'] .'El'; ?> = document.getElementById('calendar<?php echo $row['id']; ?>');
    var calendar<?php echo $row['id']; ?> = new Calendar(calendar<?php echo $row['id'] .'El'; ?>,
    {
      locale: 'es',
      themeSystem: 'bootstrap4',
      headerToolbar: 
        {
          left: 'supervisor',
          center: 'title',
          right: 'dayGridWeek,listWeek'
        },
        customButtons:
        {
          supervisor:
          {
            text: '<?php echo $row['nombre'] .' ' .$row['apellido'] ; ?>',
            click: function() {
              $(this).click(false);
            }
          },
        },
      initialView: window.innerWidth >= 765 ? 'dayGridWeek' : 'listWeek',
      eventDidMount: function(info, event)
        { 
          info.el.title = ( "Tarea: " + info.event.extendedProps.tarea +
                            "\nCreador: " + info.event.extendedProps.creador +
                            "\nDescripcion: " + info.event.extendedProps.contenido +
                            "\nEstado: " + info.event.extendedProps.estado +
                            "\nTecnico: " + info.event.extendedProps.tecnico +
                            "\nSupervisor: " + info.event.extendedProps.a_quien +
                            "\nObservaciones: " + info.event.extendedProps.obs +
                            "\nObs supervisor: " + info.event.extendedProps.obs_supervisor
                          )
        },
      events: [<?php
                $result = mysqli_query($conn, "SELECT * FROM calendario WHERE a_quien = '$tecnico_sup'");    
                while($row=$result->fetch_assoc())
                {
                  echo "{";
                  echo "title: '" .$row['titulo'] ." - " .$row['tecnico'] ."',";
                  echo "start: '" .$row['inicio'] ."',";
                  echo "end: '" .$row['fin'] ."',";
                  echo "contenido: '" .$row['contenido'] ."',";
                  echo "token: '" .$row['token'] ."',";
                  echo "creador: '" .$row['quien'] ."',";
                  echo "estado: '" .$row['estado'] ."',";
                  echo "color: '" .$row['color'] ."',";
                  echo "titulo: '" .$row['titulo'] ."',";
                  echo "obs: '" .$row['obs'] ."',";
                  echo "tarea: '" .$row['tarea'] ."',";
                  echo "tecnico: '" .$row['tecnico'] ."',";
                  echo "a_quien: '" .$row['a_quien'] ."',";
                  echo "tomado_por: '" .$row['tomado_por'] ."',";
                  echo "obs_supervisor: '" .$row['obs_supervisor'] ."',";
                  echo "},";
                }
              ?>],
      eventClick: function(info, event)
        {
          $('#titulo_evento').html('<b>Titulo:</b> ' + info.event.extendedProps.titulo);
          $('#creador_evento').html('<b>Creador:</b> ' + info.event.extendedProps.creador);
          $('#contenido_evento').html('<b>Descripcion:</b> ' + info.event.extendedProps.contenido);
          $('#estadoEvento').html('<b>Estado:</b> ' + info.event.extendedProps.estado);
          $('#obs_evento').html('<b>Observaciones:</b> ' + info.event.extendedProps.obs);
          $('#tarea_evento').html('<b>Tarea:</b> ' + info.event.extendedProps.tarea);
          $('#tecnico_evento').html('<b>Tecnico:</b> ' + info.event.extendedProps.tecnico);
          $('#a_quien_evento').html('<b>Supervisor:</b> ' + info.event.extendedProps.a_quien);
          $('#tomado_por_evento').html('<b>Tomado por:</b> ' + info.event.extendedProps.tomado_por);
          $('#obs_supervisor').html('<b>Obs supervisor:</b> ' + info.event.extendedProps.obs_supervisor);
          $('#tokenEvento').text(info.event.extendedProps.token);

          /* TOMAR ID Y AGREGARLO AL HREF */
            const linkDelete = document.querySelector('#tomar_id_delete'); /* ESCUCHAR EL DATO #tomar_id */
            linkDelete.setAttribute('href', "../Borrar/delete_calendario.php?token=" + info.event.extendedProps.token);  /* TOMA EL VALOR DE 'href' Y LO REEMPLAZA */
          /* TOMAR ID Y AGREGARLO AL HREF */
          /* TOMAR ID Y AGREGARLO AL HREF */
            const linkVer = document.querySelector('#tomar_id_ver'); /* ESCUCHAR EL DATO #tomar_id */
            linkVer.setAttribute('href', "./b_ver_calendario.php?token=" + info.event.extendedProps.token);  /* TOMA EL VALOR DE 'href' Y LO REEMPLAZA */
          /* TOMAR ID Y AGREGARLO AL HREF */
          /* TOMAR ID Y AGREGARLO AL HREF */
            const linkEditar = document.querySelector('#tomar_id_editar'); /* ESCUCHAR EL DATO #tomar_id */
            linkEditar.setAttribute('href', "../Editar/edit_calendario.php?token=" + info.event.extendedProps.token);  /* TOMA EL VALOR DE 'href' Y LO REEMPLAZA */
          /* TOMAR ID Y AGREGARLO AL HREF */
          /* TOMAR ID Y AGREGARLO AL ACTION */
            const linkActionSi = document.querySelector('#tomar_id_action_si'); /* ESCUCHAR EL DATO #tomar_id */
            linkActionSi.setAttribute('action', "../Guardar/save_calendario.php?token=" + info.event.extendedProps.token);  /* TOMA EL VALOR DE 'action' Y LO REEMPLAZA */
          /* TOMAR ID Y AGREGARLO AL ACTION */
          /* TOMAR ID Y AGREGARLO AL ACTION */
            const linkActionNo = document.querySelector('#tomar_id_action_no'); /* ESCUCHAR EL DATO #tomar_id */
            linkActionNo.setAttribute('action', "../Guardar/save_calendario.php?token=" + info.event.extendedProps.token);  /* TOMA EL VALOR DE 'action' Y LO REEMPLAZA */
          /* TOMAR ID Y AGREGARLO AL ACTION */

          $('#exampleModal').modal();
        },
      editable: true,
      droppable: true, // this allows things to be dropped onto the calendar
      selectable: true,
      eventReceive: function(info)
        {
          var eventData =
          {
            title: info.event.title,
            start: info.event.startStr,
            end: info.event.startStr,
            a_quien: '<?php echo $tecnico_sup ; ?>',
            tecnico: info.event.extendedProps.tecnico,
            tarea: 'nueva',
          };
            //send the data via an AJAX POST request, and log any response which comes from the server
          $.ajax({
          url: '../Ajax/drop_calendario.php',
          type: "POST",
          data: eventData,
          success: function()
            {
              $('#titulo_toast').html('Guardado');
              $('#mensaje_toast').html('La tarea fue asignada correctamente.');
              $('#liveToast').toast('show');
            }
          });
        },
      eventResize: function(info, event)
        {
          var tamanio =
          {
            start: info.event.startStr,
            end: info.event.endStr,
            tarea: 'tamanio',
            token: info.event.extendedProps.token
          };
            //send the data via an AJAX POST request, and log any response which comes from the server
          $.ajax({
          url: '../Ajax/drop_calendario.php',
          type: "POST",
          data: tamanio,
          success: function()
            {
              $('#titulo_toast').html('Actualizado');
              $('#mensaje_toast').html('La tarea fue actualizada correctamente.');
              $('#liveToast').toast('show');
            }
          });
        },
      eventDrop: function(info, event)
        {
          var mover =
          {
            start: info.event.startStr,
            end: info.event.startStr,
            tarea: 'mover',
            token: info.event.extendedProps.token
          };
            //send the data via an AJAX POST request, and log any response which comes from the server
          $.ajax({
          url: '../Ajax/drop_calendario.php',
          type: "POST",
          data: mover,
          success: function()
            {
              $('#titulo_toast').html('Reordenado');
              $('#mensaje_toast').html('La tarea fue reordenada correctamente.');
              $('#liveToast').toast('show');
            }
          });
        },
    });
  <?php } ?>
  
  <?php
    $rrr = mysqli_query($conn, "SELECT * FROM usuarios WHERE tipo_us = 'Supervisor' ORDER BY nombre asc");
      while($roww=$rrr->fetch_assoc())
      {
  ?>
    calendar<?php echo $roww['id']; ?>.render();
    var a=0;
    document.getElementById('anterior_semana').addEventListener('click', function() {
      calendar<?php echo $roww['id']; ?>.prev(); // anterior semana
        a-=3.5;
          stop(a);
        var parametros = {"mas":"mas","fecha":"+"+a};
        $.ajax({
            data:parametros,
            url:'../Ajax/a_semana_dia.php',
            type: 'post',
            success: function (data) {
              $("#nombre_semana").html(data);
            }
        });
        $.ajax(
          {
            data:parametros,
            url:'../Ajax/a_semana.php',
            type: 'post',
            success: function(data)
            {
              $("#semana1").html(data);
            },
          }
        );
        $.ajax(
          {
            data:parametros,
            url:'../Ajax/a_semana_ins.php',
            type: 'post',
            success: function(data)
            {
              $("#semana2").html(data);
            },
          }
        );
        $.ajax(
          {
            data:parametros,
            url:'../Ajax/a_semana_auto.php',
            type: 'post',
            success: function(data)
            {
              $("#semana3").html(data);
            },
          }
        );
      
    });
    document.getElementById('siguiente_semana').addEventListener('click', function() {
      calendar<?php echo $roww['id']; ?>.next(); // siguiente semana
          a+=3.5;
          stop(a);
        var parametros = {"mas":"mas","fecha":"+"+a};
        $.ajax({
            data:parametros,
            url:'../Ajax/a_semana_dia.php',
            type: 'post',
            success: function (data) {
              $("#nombre_semana").html(data);
            }
        });
        $.ajax(
          {
            data:parametros,
            url:'../Ajax/a_semana.php',
            type: 'post',
            success: function(data)
            {
              $("#semana1").html(data);
            },
          }
        );
        $.ajax(
          {
            data:parametros,
            url:'../Ajax/a_semana_ins.php',
            type: 'post',
            success: function(data)
            {
              $("#semana2").html(data);
            },
          }
        );
        $.ajax(
          {
            data:parametros,
            url:'../Ajax/a_semana_auto.php',
            type: 'post',
            success: function(data)
            {
              $("#semana3").html(data);
            },
          }
        );
    });
  <?php } ?>
  });
</script>
<!-- TABLA COMPLETA -->
<script>
  $(document).ready(function () {
    $('#select_tarea').change(function (e) {
        
        if ($(this).val() === "Garantia") {
          $('#ot_garantia').prop("disabled", false);
          $("#ot_garantia").removeAttr('hidden');
          $('#ot_reclamo').prop("disabled", true);
          $("#ot_reclamo").attr('hidden','hidden');
          $("#ot_reclamo").val('');

          $('#obt_id_garantia').prop("disabled", false);
          $("#obt_id_garantia").removeAttr('hidden');
          
          $('#obt_id_reclamo').prop("disabled", true);
          $("#obt_id_reclamo").attr('hidden','hidden');
          $("#valor_id_reclamo").val('');
          $('.selec_garantia').on('keyup', function() /* CUANDO EN LA CLASE "selec_garantia" */
            {
              var key = $(this).val(); /* GAURDAR EN LA VARIABLE "key" EL VALOR DE "selec_garantia" */
              var dataString = 'key='+key;
              if(key == "")
              {
                //Hacemos desaparecer el resto de sugerencias cuando no halla nada escrito
                $('.sugerido_garantia').fadeOut(500);
              }
              else
              {
                $.ajax({
                  type: "POST",
                  url: "../Ajax/a_tarea_calendario.php",
                  data: dataString,
                  success: function(data)
                  {
                    //Escribimos las sugerencias que nos manda la consulta
                    $('.sugerido_garantia').fadeIn(500).html(data);
                    //Al hacer click en alguna de las sugerencias
                    $('.suggest-element').on('click', function(){
                      //Obtenemos la id unica de la sugerencia pulsada
                      var id = $(this).attr('id');
                      //Editamos el valor del input con data de la sugerencia pulsada
                      $('.prueba').val($('#'+id).attr('data'));
                      //Hacemos desaparecer el resto de sugerencias
                      $('.sugerido_garantia').fadeOut(500);
                      return false;
                    });
                  }
                });
              };
            });
        }
        else {
          $('#ot_garantia').prop("disabled", true);
          $("#ot_garantia").attr('hidden','hidden');
          $("#ot_garantia").val('');
        }
        if ($(this).val() === "Reclamo") {
          $('#ot_reclamo').prop("disabled", false);
          $("#ot_reclamo").removeAttr('hidden');
          $('#ot_garantia').prop("disabled", true);
          $("#ot_garantia").attr('hidden','hidden');
          $("#ot_garantia").val('');

          $('#obt_id_reclamo').prop("disabled", false);
          $("#obt_id_reclamo").removeAttr('hidden');

          $('#obt_id_garantia').prop("disabled", true);
          $("#obt_id_garantia").attr('hidden','hidden');
          $("#valor_id_garantia").val('');
          $('.selec_reclamo').on('keyup', function() /* CUANDO EN LA CLASE "selec_reclamo" */
          {
            var key = $(this).val(); /* GAURDAR EN LA VARIABLE "key" EL VALOR DE "selec_reclamo" */
            var dataString = 'key='+key;
            if(key == "")
            {
              //Hacemos desaparecer el resto de sugerencias cuando no halla nada escrito
              $('.sugerido_reclamo').fadeOut(500);
            }
            else
            {
              $.ajax({
                type: "POST",
                url: "../Ajax/a_reclamo_calendario.php",
                data: dataString,
                success: function(data)
                {
                  //Escribimos las sugerencias que nos manda la consulta
                  $('.sugerido_reclamo').fadeIn(500).html(data);
                  //Al hacer click en alguna de las sugerencias
                  $('.suggest-element').on('click', function(){
                    //Obtenemos la id unica de la sugerencia pulsada
                    var id = $(this).attr('id');
                    //Editamos el valor del input con data de la sugerencia pulsada
                    $('.prueba_reclamo').val($('#'+id).attr('data'));
                    //Hacemos desaparecer el resto de sugerencias
                    $('.sugerido_reclamo').fadeOut(500);
                    return false;
                  });
                }
              });
            };
          });
        } 
        else {
          $('#ot_reclamo').prop("disabled", true);
          $("#ot_reclamo").attr('hidden','hidden');
          $("#ot_reclamo").val('');
        }
      
    })
  });
</script>
<script>
  const split = document.getElementById("splitter");

  let elA;
  let elB;

  let elAInitHeight;
  let totalHeight;

  let startY;

  const pointerMove = e=>{
    //prevent mouse events for touch-only systems with mouse event emulation 
    e.preventDefault();

    //TODO get clientY from touch event
    const curY = e.clientY;
    const diff =  curY - startY;

    const newHeightA = Math.min(Math.max(elAInitHeight + diff,0),totalHeight);
    const newHeightB = Math.max(totalHeight - newHeightA,0);

    const aPerc = newHeightA/totalHeight;
    const bPerc = newHeightB/totalHeight;
    

    //elA.style.flexBasis = newHeightA+"px";
    //elB.style.flexBasis = newHeightB+"px";

    elA.style.flexBasis = (aPerc*100)+"%";
    elB.style.flexBasis = (bPerc*100)+"%";
  }

  const pointerUp = e=>{
    //prevent mouse events for touch-only systems with mouse event emulation 
    e.preventDefault();

    console.log("pointer up",e.type);
    
    window.removeEventListener("mousemove",pointerMove);
    window.removeEventListener("touchmove",pointerMove);
    
    window.removeEventListener("mouseup",pointerUp);
    window.removeEventListener("touchend",pointerUp);
  }

  const pointerDown = e=>{
    //prevent mouse events for touch-only systems with mouse event emulation 
    e.preventDefault();
    
    elA = split.previousElementSibling;
    elB = split.nextElementSibling;

    //elAStyle = getComputedStyle(elA);
    elAInitHeight = elA.offsetHeight;
    
    totalHeight = elAInitHeight + elB.offsetHeight;
    
    //TODO get clientY from touch event
    startY = e.clientY;
    
    
    window.addEventListener("mousemove",pointerMove);
    window.addEventListener("touchmove",pointerMove);
    
    window.addEventListener("mouseup",pointerUp);
    window.addEventListener("touchend",pointerUp);
  }

  split.addEventListener("mousedown",pointerDown);
  split.addEventListener("touchstart",pointerDown);

  window.addEventListener("mouseup",()=>console.log("mouse up in window"));
</script>
<script>
  $(document).ready(function () {
    $.ajax(
      '../Ajax/a_semana.php',
      {
        success: function(data)
        {
          $("#semana1").html(data);
        },
      }
    );
    $.ajax(
      '../Ajax/a_semana_ins.php',
      {
        success: function(data)
        {
          $("#semana2").html(data);
        },
      }
    );
    $.ajax(
      '../Ajax/a_semana_auto.php',
      {
        success: function(data)
        {
          $("#semana3").html(data);
        },
      }
    );
  })
</script>
</body>
</html>