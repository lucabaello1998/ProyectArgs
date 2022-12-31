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
	$quien_notas = $nombre .' ' .$apellido;
  if($quien_notas == "Jose Lopez") { header("location: ./calendario_despacho.php"); }
  if($tipo == "Administrador") { header("location: ./b_calendario.php"); }
  if($tipo == "Despacho") { $usu = 1; }
  if($tipo == "Supervisor") { $usu = 1; }
  if($tipo == "Deposito") { $usu = 1; }
	if($usu != 1)
	{
		header("location: ../index.php");
	}
?>
<?php include('../includes/header.php'); ?>
<!-- Fullcalendar -->
<link href='../lib/fullcalendar/lib/main.css' rel='stylesheet'/>
<script src='../lib/fullcalendar/lib/main.js'></script>
<script src='../lib/fullcalendar/lib/locales/es.js'></script>

<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">
      <div class="row justify-content-center p-1">
        <div class="col-auto">
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

      <div class="row p-4">
        <div class="col-12">
          <br>
          <div class="row">
            <style>
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
                .fc .fc-view-harness{
                  height: 400px !important;
                  min-height: 105px;
                }
              }
              <?php if($letra == "Negro"){ echo '
                .fc-theme-standard .fc-list-day-cushion{
                  color: #fcfcef;
                  background-color: #2c3e50;
                }
                ';} else {echo '';} ?>
            </style>
            <div id="calendar" class="col-12 p-0"></div>
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
                        <div id="a_quien_evento"></div>
                      </div>
                      <div class="row p-2">
                        <div id="estadoEvento"></div>
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
                </div>
                <div class="modal-footer">
                  <a href="#" id="tomar_id_ver"><span class="btn btn-info">Ver</span></a>
                  <a hidden href="#" id="tomar_id_tomar"><span class="btn btn-success">Tomar</span></a>
                  <span hidden id="tomado_id" class="btn btn-outline-secondary disabled"><div id="tomado_evento"></div></span>
                </div>
              </div>
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
<!-- TABLA COMPLETA -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'es',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        initialView: window.innerWidth >= 765 ? 'dayGridMonth' : 'listWeek',
        nowIndicator: true,
        scrollTime: '07:00',
        now: <?php echo json_encode($datetime) ?>,
        events: [<?php
                  $query = "SELECT * FROM calendario WHERE a_quien LIKE '%$quien_notas%'";
                  $result = mysqli_query($conn, $query);    
                  while($row=$result->fetch_assoc())
                  {
                    echo "{";
                    echo "title: '" .$row['titulo'] ." - " .$row['tecnico'] ."',";
                    echo "start: '" .$row['inicio'] ."',";
                    echo "end: '" .$row['fin'] ."',";
                    echo "contenido: '" .$row['contenido'] ."',";
                    echo "token: '" .$row['token'] ."',";
                    echo "tecnico: '" .$row['quien'] ."',";
                    echo "estado: '" .$row['estado'] ."',";
                    echo "color: '" .$row['color'] ."',";
                    echo "titulo: '" .$row['titulo'] ."',";
                    echo "obs: '" .$row['obs'] ."',";
                    echo "tarea: '" .$row['tarea'] ."',";
                    echo "tecnico: '" .$row['tecnico'] ."',";
                    echo "a_quien: '" .$row['a_quien'] ."',";
                    echo "obs_supervisor: '" .$row['obs_supervisor'] ."',";
                    if($row['tomado_por'] == '' && $row['estado'] !== 'Finalizado'){$tomado_por = 'x';}else{$tomado_por = $row['tomado_por'];};
                    echo "tomado_por: '" .$tomado_por ."',";
                    echo "},";
                  }
                ?>],
        eventClick: function(info, event){
          $('#titulo_evento').html('<b>Titulo:</b> ' + info.event.extendedProps.titulo);
          $('#contenido_evento').html('<b>Descripcion:</b> ' + info.event.extendedProps.contenido);
          $('#estadoEvento').html('<b>Estado:</b> ' + info.event.extendedProps.estado);
          $('#obs_evento').html('<b>Observaciones:</b> ' + info.event.extendedProps.obs);
          $('#tarea_evento').html('<b>Tarea:</b> ' + info.event.extendedProps.tarea);
          $('#tecnico_evento').html('<b>Tecnico:</b> ' + info.event.extendedProps.tecnico);
          $('#a_quien_evento').html('<b>Supervisor:</b> ' + info.event.extendedProps.a_quien);
          $('#obs_supervisor').html('<b>Observaciones:</b> ' + info.event.extendedProps.obs_supervisor);
          $('#tomado_evento').html(info.event.extendedProps.tomado_por);
          $('#tokenEvento').text(info.event.extendedProps.token);

          if ($('#tomado_evento').text() === "x")
          {
            $("#tomar_id_tomar").removeAttr('hidden');
            $("#tomado_id").attr('hidden','hidden');
            /* TOMAR ID Y AGREGARLO AL HREF */
              const linkDelete = document.querySelector('#tomar_id_tomar'); /* ESCUCHAR EL DATO #tomar_id */
              linkDelete.setAttribute('href', "../Guardar/save_calendario.php?tomar=" + info.event.extendedProps.token);  /* TOMA EL VALOR DE 'href' Y LO REEMPLAZA */
            /* TOMAR ID Y AGREGARLO AL HREF */
          }
          else
          {
            $("#tomar_id_tomar").attr('hidden','hidden');
						$("#tomado_id").attr('hidden','hidden');
          }
          
          /* TOMAR ID Y AGREGARLO AL HREF */
            const linkVer = document.querySelector('#tomar_id_ver'); /* ESCUCHAR EL DATO #tomar_id */
            linkVer.setAttribute('href', "./b_ver_calendario.php?token=" + info.event.extendedProps.token);  /* TOMA EL VALOR DE 'href' Y LO REEMPLAZA */
          /* TOMAR ID Y AGREGARLO AL HREF */

          $('#exampleModal').modal();
        },
      });
      calendar.render();
    });
  </script>
<!-- TABLA COMPLETA -->
</body>
</html>