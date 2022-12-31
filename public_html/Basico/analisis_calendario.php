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
  if($tipo == "Administrador") { $usu = 1; }
  if($tipo == "Despacho") { $usu = 1; }
  if($tipo == "Supervisor") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
  }
?>
<?php include('../includes/header.php'); ?>
<link href='../lib/fullcalendar/lib/main.css' rel='stylesheet'/>
<script src='../lib/fullcalendar/lib/main.js'></script>
<script src='../lib/fullcalendar/lib/locales/es.js'></script>
<style>
  .fc-direction-ltr{
    min-height: 10rem;
    height: 14rem;
  }
  .fc .fc-view-harness-active > .fc-view{
    height: 30rem;
  }
  .fc-direction-ltr{
    height: 35rem;
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
      height: 40rem;
      max-height: 42rem;
    }
  }
  .table-responsive{
    max-height: 18rem;
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
<?php
  $mes = date ('Y-m', strtotime('-0 month'));
  if(isset($_POST['meses']))
  {
    $mes1 = $_POST['mes'];
    $mes = date ('Y-m', strtotime($mes1));
  }
?>
<!-- TOTAL TAREAS-->
  <?php
    $q = mysqli_query($conn, "SELECT COUNT(tarea) as 'total_tareas_asignadas' FROM calendario WHERE inicio LIKE '%$mes%' AND quien = 'Jose Lopez' AND a_quien <> ''");
    while($row = mysqli_fetch_assoc($q))
    {
      $total_tareas_asignadas = $row['total_tareas_asignadas'];
    }
  ?>
<!-- TOTAL TAREAS-->

<!-- TOTAL FINALIZADAS-->
  <?php
    $w = mysqli_query($conn, "SELECT COUNT(tarea) as 'total_tareas_finalizado' FROM calendario WHERE inicio LIKE '%$mes%' AND quien = 'Jose Lopez' AND estado = 'Finalizado' AND a_quien <> ''");
    while($row = mysqli_fetch_assoc($w))
    {
      $total_tareas_finalizado = $row['total_tareas_finalizado'];
    }
  ?>
<!-- TOTAL FINALIZADAS-->

<!-- TOTAL PENDIENTES-->
  <?php
    $t = mysqli_query($conn, "SELECT COUNT(tarea) as 'total_tareas_pendientes' FROM calendario WHERE inicio LIKE '%$mes%' AND quien = 'Jose Lopez' AND estado = 'Pendiente' AND a_quien <> ''");
    while($row = mysqli_fetch_assoc($t))
    {
      $total_tareas_pendientes = $row['total_tareas_pendientes'];
    }
  ?>
<!-- TOTAL PENDIENTES-->

<!-- TOTAL RECHAZADAS-->
  <?php
    $e = mysqli_query($conn, "SELECT COUNT(tarea) as 'total_tareas_rechazado' FROM calendario WHERE inicio LIKE '%$mes%' AND quien = 'Jose Lopez' AND estado = 'Rechazado' AND a_quien <> ''");
    while($row = mysqli_fetch_assoc($e))
    {
      $total_tareas_rechazado = $row['total_tareas_rechazado'];
    }
  ?>
<!-- TOTAL RECHAZADAS-->
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">

  <div class="container-fluid rounded bg-white shadow p-0">
    <div class="row justify-content-center p-1">
      <p class="h2 mb-4 text-center">Tareas de <?php echo Fecha10($mes);  ?></p>
    </div>

    <div class="container-fluid p-2">  <!---- RESUMEN--->
      <div class="row p-2">		
        <div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---TOTAL--->			
          <div class="card text-center bg-info">	
            <div class="card-header text-light font-weight-bold text-center">
              Total
            </div>				
            <div class="row">			
              <div class="col">
                <p class="h2 card-text text-light font-weight-bold"><?php echo $total_tareas_asignadas; ?></p>				
              </div>
              <div class="col">
                <br>						
                <p class="h1 text-light text-center"><i class="fas fa-layer-group"></i></i></p>	
              </div>											
            </div>				
          </div>
          <div class="row justify-content-between p-1">
            <?php
              $r = mysqli_query($conn, "SELECT COUNT(tarea) as 'total_tareas', a_quien FROM calendario WHERE inicio LIKE '%$mes%' AND quien = 'Jose Lopez' AND a_quien <> '' GROUP BY a_quien ORDER BY a_quien desc");
              while($row = mysqli_fetch_assoc($r))
              {
            ?>
              <div class="col-sm-6 col-6 col-md-12 col-xl-6">
                <p>
                  <a class="btn btn-info text-light"><?php echo $row['a_quien'] .' '; ?><span class="badge badge-light"><?php echo $row['total_tareas']; ?></span></a>
                </p>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---TOTAL--->			
          <div class="card text-center bg-success">	
            <div class="card-header text-light font-weight-bold text-center">
              Finalizadas
            </div>				
            <div class="row">			
              <div class="col">
                <p class="h2 card-text text-light font-weight-bold"><?php echo $total_tareas_finalizado; ?></p>				
              </div>
              <div class="col">
                <br>						
                <p class="h1 text-light text-center"><i class="fas fa-layer-group"></i></i></p>	
              </div>											
            </div>				
          </div>
          <div class="row justify-content-between p-1">
            <?php
              $r = mysqli_query($conn, "SELECT COUNT(tarea) as 'total_tareas', a_quien FROM calendario WHERE inicio LIKE '%$mes%' AND quien = 'Jose Lopez' AND estado = 'Finalizado' AND a_quien <> '' GROUP BY a_quien ORDER BY a_quien desc");
              while($row = mysqli_fetch_assoc($r))
              {
            ?>
              <div class="col-sm-6 col-6 col-md-12 col-xl-6">
                <p>
                  <a class="btn btn-success text-light"><?php echo $row['a_quien'] .' '; ?><span class="badge badge-light"><?php echo $row['total_tareas']; ?></span></a>
                </p>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---TOTAL--->			
          <div class="card text-center bg-warning">	
            <div class="card-header text-light font-weight-bold text-center">
              Pendientes
            </div>				
            <div class="row">			
              <div class="col">
                <p class="h2 card-text text-light font-weight-bold"><?php echo $total_tareas_pendientes; ?></p>				
              </div>
              <div class="col">
                <br>						
                <p class="h1 text-light text-center"><i class="fas fa-layer-group"></i></i></p>	
              </div>											
            </div>				
          </div>
          <div class="row justify-content-between p-1">
            <?php
              $r = mysqli_query($conn, "SELECT COUNT(tarea) as 'total_tareas', a_quien FROM calendario WHERE inicio LIKE '%$mes%' AND quien = 'Jose Lopez' AND estado = 'Pendiente' AND a_quien <> '' GROUP BY a_quien ORDER BY a_quien desc");
              while($row = mysqli_fetch_assoc($r))
              {
            ?>
              <div class="col-sm-6 col-6 col-md-12 col-xl-6">
                <p>
                  <a class="btn btn-warning text-light"><?php echo $row['a_quien'] .' '; ?><span class="badge badge-light"><?php echo $row['total_tareas']; ?></span></a>
                </p>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---TOTAL--->			
          <div class="card text-center bg-danger">	
            <div class="card-header text-light font-weight-bold text-center">
              Rechazados
            </div>				
            <div class="row">			
              <div class="col">
                <p class="h2 card-text text-light font-weight-bold"><?php echo $total_tareas_rechazado; ?></p>				
              </div>
              <div class="col">
                <br>						
                <p class="h1 text-light text-center"><i class="fas fa-layer-group"></i></i></p>	
              </div>											
            </div>				
          </div>
          <div class="row justify-content-between p-1">
            <?php
              $r = mysqli_query($conn, "SELECT COUNT(tarea) as 'total_tareas', a_quien FROM calendario WHERE inicio LIKE '%$mes%' AND quien = 'Jose Lopez' AND estado = 'Rechazado' AND a_quien <> '' GROUP BY a_quien ORDER BY a_quien desc");
              while($row = mysqli_fetch_assoc($r))
              {
            ?>
              <div class="col-sm-6 col-6 col-md-12 col-xl-6">
                <p>
                  <a class="btn btn-danger text-light"><?php echo $row['a_quien'] .' '; ?><span class="badge badge-light"><?php echo $row['total_tareas']; ?></span></a>
                </p>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center p-1">
      <div class="col-auto">
        <p class="h4 mb-4 text-center">Total de tareas cargadas</p>
        <table class="table table-responsive table-striped table-bordered table-sm">
          <thead class="thead-dark text-center">
            <tr>
              <th>Supervisor</th>
              <th>Tarea</th>
              <th>Estado</th>
              <th>Tomado por</th>
              <th>Inicio</th>
              <th>Fin</th>
              <th>Contenido</th>
              <th>Nota de cierre</th>
            </tr>
          </thead>
          <tbody align="center">
            <?php
              $rr = mysqli_query($conn, "SELECT * FROM calendario WHERE inicio LIKE '%$mes%' AND quien = 'Jose Lopez' ORDER BY inicio desc");
              while($row = mysqli_fetch_assoc($rr))
              {
            ?>
              <tr>
                <td><?php echo $row['a_quien']; ?></td>
                <td><?php echo $row['tarea']; ?></td>
                  <?php switch($row['estado']){case 'Finalizado': $color_tarea = 'badge-success';break; case 'Pendiente': $color_tarea = 'badge-warning';break; case 'En revision': $color_tarea = 'badge-dark';break; case 'Rechazado': $color_tarea = 'badge-danger';break; } ?>
                <td><a href="./b_ver_calendario.php?token=<?php echo $row['token']?>"><span class="badge <?php echo $color_tarea; ?>"><?php echo $row['estado']; ?></span></a></td>
                <td><?php echo $row['tomado_por']; ?></td>
                <td><?php echo Fecha7($row['inicio']); ?></td>
                <td><?php echo Fecha7($row['fin']); ?></td>
                <td><?php echo $row['contenido']; ?></td>
                <td><?php echo $row['obs']; ?></td> 
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="container-fluid p-1">
      <div id='calendar'></div>
    </div>

    <div class="row justify-content-center p-1">
      <div class="col-auto">
        <form action="../Basico/analisis_calendario.php" method="POST">
          <p class="h4 mb-4 text-center">Mes</p>
          <div class="form-row align-items-end">            
            <div class="col">             
              <select type="text" name="mes" class="form-control">
                <option selected>Mes...</option>
                <option value="-0 month">Mes actual</option>
                <option value="-1 month">Hace un mes</option>
                <option value="-2 month">Hace dos meses</option>
                <option value="-3 month">Hace tres meses</option>
              </select>
            </div>            
            <div class="col">
              <input type="submit" name="meses" class="btn btn-success btn-block" value="Cargar mes">
            </div>            
          </div>
        </form>
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
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#" id="tomar_id_ver"><span class="btn btn-info">Ver</span></a>
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
    document.addEventListener('DOMContentLoaded', function() {
    var Calendar = FullCalendar.Calendar;
    // initialize the calendar
    // -----------------------------------------------------------------
    var calendarEl = document.getElementById('calendar');
    var calendar = new Calendar(calendarEl,
      {
        locale: 'es',
        headerToolbar: 
          {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek,listWeek'
          },
        initialView: window.innerWidth >= 765 ? 'dayGridMonth' : 'listWeek',
        eventDidMount: function(info, event)
        { 
          info.el.title = ("Observaciones: " + info.event.extendedProps.obs )
        },
        events: [<?php
                  $result = mysqli_query($conn, "SELECT * FROM calendario WHERE quien = '$quien_notas' ");    
                  while($row=$result->fetch_assoc())
                  {
                    echo "{";
                    echo "title: '" .$row['titulo'] ."',";
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
                    echo "tomado_por: '" .$row['tomado_por'] ."',";
                    echo "},";
                  }
                ?>],
        eventClick: function(info, event)
          {
            $('#titulo_evento').html('<b>Titulo:</b> ' + info.event.extendedProps.titulo);
            $('#contenido_evento').html('<b>Descripcion:</b> ' + info.event.extendedProps.contenido);
            $('#estadoEvento').html('<b>Estado:</b> ' + info.event.extendedProps.estado);
            $('#obs_evento').html('<b>Observaciones:</b> ' + info.event.extendedProps.obs);
            $('#tarea_evento').html('<b>Tarea:</b> ' + info.event.extendedProps.tarea);
            $('#tecnico_evento').html('<b>Tecnico:</b> ' + info.event.extendedProps.tecnico);
            $('#a_quien_evento').html('<b>Involucrados:</b> ' + info.event.extendedProps.a_quien);
            $('#tomado_por_evento').html('<b>Tomado por:</b> ' + info.event.extendedProps.tomado_por);
            $('#tokenEvento').text(info.event.extendedProps.token);

            /* TOMAR ID Y AGREGARLO AL HREF */
              const linkDelete = document.querySelector('#tomar_id_delete'); /* ESCUCHAR EL DATO #tomar_id */
              linkDelete.setAttribute('href', "../Borrar/delete_calendario.php?token=" + info.event.extendedProps.token);  /* TOMA EL VALOR DE 'href' Y LO REEMPLAZA */
            /* TOMAR ID Y AGREGARLO AL HREF */
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
</body>
</html>
