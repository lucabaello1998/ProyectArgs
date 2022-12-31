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
	if($tipo == "Deposito") { $usu = 1; }
	if($usu != 1)
	{
		header("location: ../index.php");   /////Visor - Deposito/////
	}
?>
<?php include('../includes/header.php'); ?>
<!-- Fullcalendar -->
<link href='../lib/fullcalendar/lib/main.css' rel='stylesheet'/>
<script src='../lib/fullcalendar/lib/main.js'></script>
<script src='../lib/fullcalendar/lib/locales/es.js'></script>
<?php $mes = date ('Y-m', strtotime('-0 month'));?>

<div class="container-fluid p-4">
  <div class="row p-2">
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

			<div class="row justify-content-center p-1">
				<div class="col-auto">
					<p class="h4 mb-4 text-center">Calendario</p>
					<!-- PROGRAMAR TAREAS -->		
							<div class="pb-4">
								<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#tarea">Programar tarea</button>
							</div>
							<br>				
							<!-- Modal -->
								<div class="modal fade" id="tarea">  <!-- Modal para el boton -->
									<div class="modal-dialog modal-xl" role="document">
											<div class="modal-content">
												<form action="../Guardar/s_calendario.php" method="POST" >
													<div class="modal-header"> <!-- Encabezado del modal -->
														<h5 class="modal-title">Nueva tarea</h5>
														<button type="button" class="close" data-dismiss="modal"><span>&times;</span>
														</button>
													</div>
													<div class="modal-body"> <!-- Contenido del modal -->
														
														<div class="form-row">
															<div class="form-group col-md-6 col-12">
																<label class="text-muted">Titulo</label>
																<input type="text" name="titulo" class="form-control" required autofocus>
															</div>
															<div class="form-group col-md-6 col-12">
																<label>Dia</label>
																<select type="text" name="dia" class="form-control" required>
																	<option selected value="Normal">Normal</option>
																	<option value="Feriado">Feriado</option>
																	<option value="Libre">Libre</option>
																	<option value="Vacaciones">Vacaciones</option>
																	<option value="Licencia">Licencia</option>
																	<option value="Guardia">Guardia</option>
																	<option value="Administracion">Administracion</option>
																</select>
															</div>
														</div>
														<div class="form-row">
															<div class="form-group col-md-6">
																<label>Inicio</label >
																<input type="date" name="inicio" class="form-control" value="<?php echo date('Y-m-d'); ?>">
															</div>
															<div class="form-group col-md-6">
																<label>Fin</label >
																<input type="date" name="fin" class="form-control" value="<?php echo date('Y-m-d'); ?>">
															</div>
														</div>
														<div class="form-row">
															<div class="col-12 p-2">
																<label>Involucrados</label>
																<div class="row">
																		<?php
																			$ejecutar_notass = mysqli_query($conn,"SELECT * FROM usuarios WHERE tipo_us <> 'ATC' ORDER BY nombre asc");
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
																<label class="text-muted">Descripcion</label>
																<textarea type="text" name="contenido" class="form-control" style="height: 150px;"></textarea>
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
					<br>
				</div>
			</div>

			<div class="row p-4">
				<div class="col-12">
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
									eventDidMount: function(info, event)
										{ 
											info.el.title = ( "Titulo: " + info.event.extendedProps.titulo +
																				"\nEstado: " + info.event.extendedProps.estado +
																				"\nInvolucrados: " + info.event.extendedProps.a_quien +
																				"\nObservaciones: " + info.event.extendedProps.obs
																			)
										},
									now: <?php echo json_encode($datetime) ?>,
									events: [<?php
														$query = "SELECT * FROM calendario WHERE quien = '$quien_notas' OR a_quien LIKE '%$quien_notas%'";
														$result = mysqli_query($conn, $query);    
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
															echo "a_quien: '" .$row['a_quien'] ."',";
															if($row['quien'] == $quien_notas && $row['estado'] !== 'Finalizado')
															{
																echo "creado_por: 'x',";
															}
															echo "},";
														}
													?>],
									eventClick: function(info, event){
										$('#titulo_evento').html('<b>Titulo:</b> ' + info.event.extendedProps.titulo);
										$('#contenido_evento').html('<b>Descripcion:</b> ' + info.event.extendedProps.contenido);
										$('#estadoEvento').html('<b>Estado:</b> ' + info.event.extendedProps.estado);
										$('#obs_evento').html('<b>Observaciones:</b> ' + info.event.extendedProps.obs);
										$('#tokenEvento').text(info.event.extendedProps.token);

										if (info.event.extendedProps.creado_por === "x")
										{
											$("#tomar_id_editar").removeAttr('hidden');
											$("#tomar_id_delete").removeAttr('hidden');
										}
										else
										{
											$("#tomar_id_editar").attr('hidden','hidden');
											$("#tomar_id_delete").attr('hidden','hidden');
										}

										/* TOMAR ID Y AGREGARLO AL HREF */
											const linkDelete = document.querySelector('#tomar_id_delete'); /* ESCUCHAR EL DATO #tomar_id */
											linkDelete.setAttribute('href', "../Borrar/d_calendario.php?token=" + info.event.extendedProps.token);  /* TOMA EL VALOR DE 'href' Y LO REEMPLAZA */
										/* TOMAR ID Y AGREGARLO AL HREF */									
										/* TOMAR ID Y AGREGARLO AL HREF */
											const linkVer = document.querySelector('#tomar_id_ver'); /* ESCUCHAR EL DATO #tomar_id */
											linkVer.setAttribute('href', "./b_ver_calendario.php?token=" + info.event.extendedProps.token);  /* TOMA EL VALOR DE 'href' Y LO REEMPLAZA */
										/* TOMAR ID Y AGREGARLO AL HREF */
										/* TOMAR ID Y AGREGARLO AL HREF */
											const linkEditar = document.querySelector('#tomar_id_editar'); /* ESCUCHAR EL DATO #tomar_id */
											linkEditar.setAttribute('href', "../Editar/e_calendario.php?token=" + info.event.extendedProps.token);  /* TOMA EL VALOR DE 'href' Y LO REEMPLAZA */
										/* TOMAR ID Y AGREGARLO AL HREF */
										/* TOMAR ID Y AGREGARLO AL ACTION */
											const linkActionSi = document.querySelector('#tomar_id_action_si'); /* ESCUCHAR EL DATO #tomar_id */
											linkActionSi.setAttribute('action', "../Guardar/s_calendario.php?token=" + info.event.extendedProps.token);  /* TOMA EL VALOR DE 'action' Y LO REEMPLAZA */
										/* TOMAR ID Y AGREGARLO AL ACTION */
										/* TOMAR ID Y AGREGARLO AL ACTION */
											const linkActionNo = document.querySelector('#tomar_id_action_no'); /* ESCUCHAR EL DATO #tomar_id */
											linkActionNo.setAttribute('action', "../Guardar/s_calendario.php?token=" + info.event.extendedProps.token);  /* TOMA EL VALOR DE 'action' Y LO REEMPLAZA */
										/* TOMAR ID Y AGREGARLO AL ACTION */

										$('#exampleModal').modal();
									},
								});
								calendar.render();
							});
						</script>
					<!-- TABLA COMPLETA -->
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
												<div id="estadoEvento"></div>
											</div>
											<div class="row p-2">
												<div id="contenido_evento"></div>
											</div>
											<div class="row p-2">
												<div id="obs_evento"></div>
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
									<a href="#" hidden id="tomar_id_editar"><span class="btn btn-warning">Editar</span></a>
									<a href="#" hidden id="tomar_id_delete"><span class="btn btn-danger">Eliminar</span></a>
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
<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
</body>
</html>