<?php
	session_start();
	if(!$_SESSION['nombre'])
	{
		session_destroy();
		header("location: ./index.php");
		exit();
	}
	$nombre = $_SESSION['nombre'];
	$apellido = $_SESSION['apellido'];
	$tipo_us = $_SESSION['tipo_us'];
	$zona_us = $_SESSION['zona'];
	$quien_notas = $nombre .' ' .$apellido;
	if($tipo_us == "Administrador") { $usu = 1; }
	if($usu != 1)
	{
		switch ($tipo_us)
		{
			case 'Despacho': header('Location: ./inicio_despacho.php');
			break;
			case 'Supervisor': header('Location: ./inicio_supervisor.php');
			break;
			case 'Deposito': header('Location: ./inicio_deposito.php');
			break;
			case '': header('Location: ./index.php');
			break;
		}
	}
	
	include('./includes/header.php');
	include("./scraping/simple_html_dom.php");
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
  <script>
    $(document).ready(function(){
      $('.toast').toast('show');
    });
  </script>
<!-- MESSAGES -->
	<!-- FECHA -->
		<?php
			$mes = date ('Y-m', strtotime('-0 month'));
			if(isset($_GET['mes']))
			{
				$desencriptado = $_GET['mes'];
				$mes = base64_decode($desencriptado);
			}

			$b = explode("-", $mes);
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
					<form action="./Guardar/save_fecha.php" method="POST">
						<input type="hidden" name="ultima_fecha" value="<?php echo $mes; ?>">
						<input type="hidden" name="link" value="../inicio_administrador.php">
						<button type="submit" name="menos" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Mes anterior">
							<i class="fa-solid fa-caret-left"></i>
						</button>
					</form>
				</div>
				<div class="col-auto align-self-center text-center text-white">
					<span class="h4"><?php echo $mes_nom; ?></span>
				</div>
				<div class="col-auto align-self-center p-0">
					<form action="./Guardar/save_fecha.php" method="POST">
						<input type="hidden" name="ultima_fecha" value="<?php echo $mes; ?>">
						<input type="hidden" name="link" value="../inicio_administrador.php">
						<button type="submit" name="mas" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Mes siguiente">
							<i class="fa-solid fa-caret-right"></i>
						</button>
					</form>
				</div>
			</div>
		</div>
	<!-- FECHA -->
	<!-- TOTAL-->
		<?php
			$altas = mysqli_query($conn, "SELECT SUM(tcumplida) as 't_altas', SUM(dosplay+tresplay) as 't_dosytres', SUM(tareasmtto) as 't_mtto', SUM(mtto_ext) as 't_mtto_ext', SUM(bajas) as 't_baja', SUM(garantec) as 't_garantia' FROM produccion WHERE fecha like '%$mes%'");
			while($a = mysqli_fetch_assoc($altas))
			{ 
				$t_altas = $a['t_altas'];
				$t_dosytres = $a['t_dosytres'];
				$t_baja = $a['t_baja'];
				$t_mtto = $a['t_mtto'];
				$t_mtto_ext = $a['t_mtto_ext'];
				$t_garantia = $a['t_garantia'];
			}

			$bajas = mysqli_query($conn, "SELECT COUNT(tecnico) as 'b_tkl' FROM bajas WHERE calendario LIKE '%$mes%' AND tkl = ''");
			while($b = mysqli_fetch_assoc($bajas))
			{ $tkl = $b['b_tkl']; }

			$garantia = mysqli_query($conn, "SELECT COUNT(tecnico) as 'g_justi_sin' FROM garantias WHERE fecharep LIKE '%$mes%' AND justificado = '' AND tecrep <> ''");
			while($rob = mysqli_fetch_assoc($garantia))
			{ $sin_justi = $rob['g_justi_sin'] ; }
		?>
	<!-- TOTAL-->
	<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
		<div class="row pr-2 pl-2 pt-0 pb-0">
			<div class="col-md-8 col-12">
				<div class="row"> <!-- TARJETAS -->
					<div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
						<a class="row rounded bg-white shadow border-left border-success m-1 text-muted" href="./Analisis/a_altas.php" style="text-decoration: none;" data-toggle="tooltip" data-placement="bottom" title="Ver el analisis de altas">
							<div class="col-6 p-2">
								<p class="h2 text-left text-success"><i class="fa-solid fa-angle-up"></i></p>
							</div>
							<div class="col-6 p-2">
									<p class="h4 text-muted text-center">Altas</p>
									<p class="h3 text-muted text-center"><?php echo $t_altas; ?></p>
							</div>
						</a>
						<div class="row rounded bg-white shadow border-left border-success m-1 justify-content-between">
							<div class="col-auto h6 p-2 text-muted m-0">
								2 y 3 play
							</div>
							<div class="col-auto h6 p-2 text-muted m-0">
								<?php echo $t_dosytres; ?>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
						<a class="row rounded bg-white shadow border-left border-danger m-1" href="./Analisis/a_bajas.php" style="text-decoration: none;" data-toggle="tooltip" data-placement="bottom" title="Ver el analisis de bajas">
							<div class="col-6 p-2">
								<p class="h2 text-left text-danger"><i class="fa-solid fa-angle-down"></i></p>
							</div>
							<div class="col-6 p-2">
									<p class="h4 text-muted text-center">Bajas</p>
									<p class="h3 text-muted text-center"><?php echo $t_baja; ?></p>
							</div>
						</a>
						<div class="row rounded bg-white shadow border-left border-danger m-1 justify-content-between">
							<div class="col-auto h6 p-2 text-muted m-0">
								Sin TKL
							</div>
							<div class="col-auto h6 p-2 text-muted m-0">
								<?php echo $tkl; ?>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
						<a class="row rounded bg-white shadow border-left border-info m-1" href="./Analisis/a_mtto.php" style="text-decoration: none;" data-toggle="tooltip" data-placement="bottom" title="Ver el analisis de mantenimientos">
							<div class="col-6 p-2">
								<p class="h2 text-left text-info"><i class="fas fa-toolbox"></i></p>
							</div>
							<div class="col-6 p-2">
									<p class="h4 text-muted text-center">Mtto</p>
									<p class="h3 text-muted text-center"><?php echo $t_mtto; ?></p>
							</div>
						</a>
						<div class="row rounded bg-white shadow border-left border-info m-1 justify-content-between">
							<div class="col-auto h6 p-2 text-muted m-0">
								Mtto externo
							</div>
							<div class="col-auto h6 p-2 text-muted m-0">
								<?php echo $t_mtto_ext; ?>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
						<a class="row rounded bg-white shadow border-left border-warning m-1" href="./Analisis/a_garantias.php" style="text-decoration: none;" data-toggle="tooltip" data-placement="bottom" title="Ver el analisis de garantias">
							<div class="col-6 p-2">
								<p class="h2 text-left text-warning"><i class="fa-solid fa-arrows-rotate"></i></p>
							</div>
							<div class="col-6 p-2">
									<p class="h4 text-muted text-center">Garant</p>
									<p class="h3 text-muted text-center"><?php echo $t_garantia; ?></p>
							</div>
						</a>
						<div class="row rounded bg-white shadow border-left border-warning m-1 justify-content-between">
							<div class="col-auto h6 p-2 text-muted m-0">
								Sin justificar
							</div>
							<div class="col-auto h6 p-2 text-muted m-0">
								<?php echo $sin_justi; ?>
							</div>
						</div>
					</div>
				</div>
				<div class="row"> <!-- GRAFICA -->
					<div class="col-12 p-0">
						<div class="row rounded bg-white shadow m-1 p-2">
							<div class="col-12">
								<canvas id="tareas" style="height:40vh; width:40vw"></canvas>
							</div>
						</div>
					</div>
				</div>
				<div class="row"> <!-- CALENDARIO -->
					<div class="col-12 p-0">
						<div class="row rounded bg-white shadow m-1 p-2">
							<div id="calendar" class="col-12 p-0"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-12">

        <div class="row"> <!-- RECLAMOS Y NC -->
					<div class="col-lg-6 col-md-6 col-sm-6 col-12 p-0">
						<div class="row rounded bg-white shadow border-left border-danger m-1 text-muted">
							<div class="col-6 p-2">
								<p class="h2 text-left text-danger"><i class="fa-solid fa-bullhorn"></i></p>
							</div>
							<div class="col-6 p-2">
								<p class="h4 text-muted text-center">Reclamos</p>
								<?php
									$r_a = mysqli_query($conn, "SELECT COUNT(tecnico) as 'recla' FROM reclamos WHERE solucion='Ninguna aun'");  
									while($row = mysqli_fetch_assoc($r_a))
									{ $recla = $row['recla']; }
								?>
								<p class="h3 text-muted text-center"><?php echo $recla; ?></p>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-12 p-0">
						<div class="row rounded bg-white shadow border-left border-primary m-1 text-muted">
							<div class="col-6 p-2">
								<p class="h2 text-left text-primary"><i class="fa-solid fa-triangle-exclamation"></i></p>
							</div>
							<div class="col-6 p-2">
								<p class="h4 text-muted text-center">N/C</p>
								<?php
									$r_a = mysqli_query($conn, "SELECT COUNT(tecnico) as 'no_confor' FROM no_conformidades WHERE fecha like '%$mes%'");  
									while($row = mysqli_fetch_assoc($r_a))
									{ $no_confor = $row['no_confor']; }
								?>
								<p class="h3 text-muted text-center"><?php echo $no_confor; ?></p>
							</div>
						</div>
					</div>
				</div>

				<div class="row"> <!-- TECNICOS -->
					<div class="col-12 p-0">
						<div class="row justify-content-center rounded bg-white shadow m-1">

              <div class="col-12 p-1">
								<nav>
									<div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
										<a class="nav-item nav-link active" id="nav-altas-tab" data-toggle="tab" href="#nav-altas" role="tab" aria-controls="nav-altas" aria-selected="true">Altas</a>
                    <a class="nav-item nav-link" id="nav-bajas-tab" data-toggle="tab" href="#nav-bajas" role="tab" aria-controls="nav-bajas" aria-selected="false">Bajas</a>
										<a class="nav-item nav-link" id="nav-mtto-tab" data-toggle="tab" href="#nav-mtto" role="tab" aria-controls="nav-mtto" aria-selected="false">Mtto</a>										
										<a class="nav-item nav-link" id="nav-garantias-tab" data-toggle="tab" href="#nav-garantias" role="tab" aria-controls="nav-garantias" aria-selected="false">Garantias</a>
									</div>
								</nav>
								<div class="tab-content" id="nav-tabContent">
									<div class="tab-pane fade show active" id="nav-altas" role="tabpanel" aria-labelledby="nav-altas-tab">

									<div class="row justify-content-center"> <!-- ALTAS -->
										<div class="col-12 p-1">
                      <canvas id="graficos_tecnicos_alta" class="p-2" height="100vh" width="100vw"></canvas>
										</div>
									</div>

									</div>
									<div class="tab-pane fade" id="nav-bajas" role="tabpanel" aria-labelledby="nav-bajas-tab">

									<div class="row justify-content-center"> <!-- BAJAS -->
										<div class="col-12 p-1">
                      <canvas id="graficos_tecnicos_baja" class="p-2" height="100vh" width="100vw"></canvas>
										</div>
									</div>

									</div>
									<div class="tab-pane fade" id="nav-mtto" role="tabpanel" aria-labelledby="nav-mtto-tab">

                    <div class="row justify-content-center"> <!-- MTTO -->
                      <div class="col-12 p-1">
                        <canvas id="graficos_tecnicos_mtto" class="p-2" height="100vh" width="100vw"></canvas>
                      </div>
                    </div>

									</div>
									<div class="tab-pane fade" id="nav-garantias" role="tabpanel" aria-labelledby="nav-garantias-tab">

                    <div class="row justify-content-center"> <!-- GARANTIAS -->
                      <div class="col-12 p-1">
                        <canvas id="graficos_tecnicos_garantias" class="p-2" height="100vh" width="100vw"></canvas>
                      </div>
                    </div>

									</div>
								</div>
							</div>

						</div>
					</div>
				</div>

        <div class="row"> <!-- SUPERVISORES -->
					<div class="col-12 p-0">
						<div class="row justify-content-center rounded bg-white shadow m-1">
              <div class="col-12 p-1">
                <canvas id="supervisores" height="110"></canvas>
              </div>
            </div>
          </div>
        </div>

				<div class="row"> <!-- SCRUM -->
					<div class="col-12 p-0">
						<div class="row justify-content-center rounded bg-white shadow m-1">
							<div class="col-12 p-1">

							<div class="card bg-white rounded shadow-sm">
								<div class="card-header bg-light p-2">
									Sprint
								</div>
								<div class="card-body p-1">
									<div class="accordion" id="accordionExample">
										<?php
												$pen = mysqli_query($conn, "SELECT *, COUNT(estado) as 'tareas_pendientes' FROM tareas WHERE estado = 'Sprint' AND inicio LIKE '%$ultimo_mes%' AND mensaje = '' AND quien = '$quien_notas' AND sub_tarea = '' OR estado = 'Sprint' AND inicio LIKE '%$ultimo_mes%' AND mensaje = '' AND a_quien LIKE '%$quien_notas%' AND sub_tarea = '' GROUP BY tarea ORDER BY id desc");
												while($row = mysqli_fetch_assoc($pen))
												{
													$abrev_token = $row['abreviado'];
											?>
											<div class="card-header shadow-sm bg-white m-1 p-1">
												<div class="collapsed show p-1 m-1" type="button" data-toggle="collapse" data-target="#<?php echo $abrev_token.$color_estado; ?>">
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
												$pendi = mysqli_query($conn, "SELECT * FROM tareas WHERE estado = 'Sprint' AND abreviado = '$abrev_token' AND inicio LIKE '%$ultimo_mes%' AND mensaje = '' AND sub_tarea = '' GROUP BY token ORDER BY id desc");
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
																		<div class="row justify-content-end p-1">
																			<div class="col">
																				<button type="button" class="btn btn-outline-danger p-2" data-toggle="modal" data-target="#borrar_<?php echo $token_tarea; ?>">Borrar</button>                                      
																				<a class="btn btn-outline-warning p-2" href="/Guardar/save_tareas.php?backlog=<?php echo $token_task; ?>" role="button">Backlog</a>
																				<a class="btn btn-outline-info p-2" href="/Guardar/save_tareas.php?revision=<?php echo $token_task; ?>" role="button">Revision</a>
																			</div>
																		</div>
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
																	<a class="btn btn-success p-2" href="/Borrar/delete_tareas.php?token=<?php echo $token_task; ?>" role="button">Si</a>
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
																<form action="/Guardar/save_tareas.php?actualizar=<?php echo $roww['token']; ?>" method="POST">
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
																				$d1 = new DateTime($roww['inicio']);
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
																						$('#check<?php echo $roww['token']; ?>').load('/Ajax/a_check.php?token=<?php echo $roww['token']; ?>')
																					});
																					if(navigator.onLine) {
																						setInterval(function(){
																							$(document).ready(function(){
																								$('#check<?php echo $roww['token']; ?>').load('/Ajax/a_check.php?token=<?php echo $roww['token']; ?>')
																							});
																						},5000);
																					}
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
																					<a href="/Archivos/tareas/<?php echo $row['archivo_uno']; ?>" download="<?php echo $row['nom_archivo_uno']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $row['nom_archivo_uno']; ?>"><i class="fas fa-file-download"></i><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a>
																				</div>
																			<?php } ?>
																			<?php if ($roww['archivo_dos'] !== ''){ ?>
																				<div class="col-4 p-2 text-center">
																					<a href="/Archivos/tareas/<?php echo $row['archivo_dos']; ?>" download="<?php echo $row['nom_archivo_dos']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $row['nom_archivo_dos']; ?>"><i class="fas fa-file-download"></i><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a>
																				</div>
																			<?php } ?>
																			<?php if ($roww['archivo_tres'] !== ''){ ?>
																				<div class="col-4 p-2 text-center">
																					<a href="/Archivos/tareas/<?php echo $row['archivo_tres']; ?>" download="<?php echo $row['nom_archivo_tres']; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $row['nom_archivo_tres']; ?>"><i class="fas fa-file-download"></i><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a>
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
																			if(navigator.onLine) {
																				setInterval(function(){
																					$(document).ready(function(){
																						$('#msj<?php echo $roww['token']; ?>').load('/Ajax/a_mensajes.php?token=<?php echo $roww['token']; ?>')
																					});
																				},5000);
																			}
																		</script>
																		<script>
																			function enviar<?php echo $roww['token']; ?>()
																			{	
																				$.ajax({
																				type: 'POST',
																				url: '/Ajax/a_tarea.php',
																				data: $('#form<?php echo $roww['token']; ?>').serialize(),
																				success: function(respuesta) {
																					if(respuesta=='ok')
																					{
																						$('#msj<?php echo $roww['token']; ?>').load('/Ajax/a_mensajes.php?token=<?php echo $roww['token']; ?>'),
																						$('.input_msj[type="text"]').val('');
																					}
																				}
																				});
																			}
																		</script>
																</div>
																<?php if($roww['quien'] == $quien_notas) {?>
																	<div class="modal-footer">
																			<div class="row justify-content-end p-1">
																				<div class="col">
																					<button type="button" class="btn btn-outline-danger p-2" data-toggle="modal" data-target="#borrar_<?php echo $token_tarea; ?>">Borrar</button>                                      
																					<a class="btn btn-outline-warning p-2" href="/Guardar/save_tareas.php?backlog=<?php echo $token_task; ?>" role="button">Backlog</a>
																					<a class="btn btn-outline-info p-2" href="/Guardar/save_tareas.php?revision=<?php echo $token_task; ?>" role="button">Revision</a>
																				</div>
																			</div>
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
						</div>
					</div>
				</div>

				<div class="row"> <!-- CLIMA -->
					<div class="col-12 p-0">
						<div class="row justify-content-center rounded bg-white shadow m-1">

							<div class="col-4 p-1">
								<?php
									$link_clima = 'https://www.meteored.com.ar/tiempo-en_Lomas+de+Zamora-America+Sur-Argentina-Provincia+de+Buenos+Aires--1-16905.html';
									$curl = curl_init();
									curl_setopt($curl, CURLOPT_URL, $link_clima);
									$html = file_get_html($link_clima);
		
									/* LUGAR */
									foreach($html->find('h1[class="titulo"]') as $e)
									$clima = $e->innertext;
									$lugar = strip_tags($clima);
									$lugar = str_replace(['Tiempo en '], '', $lugar);

									/* HORA */
									foreach($html->find('span[class="hour"]') as $e)
									$clima = $e->innertext;
									$hora = strip_tags($clima);

									/* DESCRIPCION */
									foreach($html->find('span[class="descripcion"]') as $e)
									$clima = $e->innertext;
									$descripcion = strip_tags($clima);
                  switch($descripcion){
                    case ' Despejado ': $icono_clima = '<i class="fa-solid fa-sun"></i>';
                    break;
                    case ' Intervalos nubosos ': $icono_clima = '<i class="fa-solid fa-cloud-sun"></i>';
                    break;
                    case ' Cielos Nubosos ': $icono_clima = '<i class="fa-solid fa-cloud-sun"></i>';
                    break;
                    case ' Tormentas ': $icono_clima = '<i class="fa-solid fa-cloud-bolt"></i>';
                    break;
                    case ' Lluvia débil ': $icono_clima = '<i class="fa-solid fa-cloud-rain"></i>';
                    break;
                    case ' Lluvia moderada ': $icono_clima = '<i class="fa-solid fa-cloud-showers-heavy"></i>';
                    break;
                    case ' Cielos Cubiertos ': $icono_clima = '<i class="fa-solid fa-cloud"></i>';
                    break;
                  }

									/* SENSACION */
									foreach($html->find('span[class="dato-temperatura changeUnitT"]') as $e)
									$clima = $e->innertext;
									$sensacion = strip_tags($clima);

									/* MIN MAX */
									foreach($html->find('li[class="dia d1 activo"]') as $e)
									$clima = $e->innertext;
									$min_max = strip_tags($clima);
									$min = explode(' ', $min_max);
								?>
                <a class="card card-body border m-1 p-1 text-dark" href="https://www.meteored.com.ar/tiempo-en_Lomas+de+Zamora-America+Sur-Argentina-Provincia+de+Buenos+Aires--1-16905.html" target="_blank" style="text-decoration: none;">
                  <span class="h5 text-center"><?php echo limitar_cadena($lugar, 12); ?></span>
                  <span class="h6 text-center"><?php echo $descripcion; ?></span>
                  <span class="h1 text-center text-dark"><?php echo $icono_clima; ?></span>
                  <span class="h3 text-center"><?php echo $sensacion; ?></span>
                  <span class="text-center"><?php echo $hora; ?></span>
                  <p class="text-center"><span class="h6 text-primary"><?php if (strpos($min[11], '°') !== false){ echo $min[11]; } else { echo $min[16]; }; ?></span>
                  <span class="h6"> / </span>
                  <span class="h6 text-danger"><?php if (strpos($min[9], '°') !== false){ echo $min[9]; } else { echo $min[14]; }; ?></span></p>
                </a>
							</div>
              <div class="col-4 p-1">
								<?php
									$link_clima = 'https://www.meteored.com.ar/gn/3433323.htm';
									$curl = curl_init();
									curl_setopt($curl, CURLOPT_URL, $link_clima);
									$html = file_get_html($link_clima);
		
									/* LUGAR */
									foreach($html->find('h1[class="titulo"]') as $e)
									$clima = $e->innertext;
									$lugar = strip_tags($clima);
									$lugar = str_replace(['Tiempo en '], '', $lugar);

									/* HORA */
									foreach($html->find('span[class="hour"]') as $e)
									$clima = $e->innertext;
									$hora = strip_tags($clima);

									/* DESCRIPCION */
									foreach($html->find('span[class="descripcion"]') as $e)
									$clima = $e->innertext;
									$descripcion = strip_tags($clima);
                  switch($descripcion){
                    case ' Despejado ': $icono_clima = '<i class="fa-solid fa-sun"></i>';
                    break;
                    case ' Intervalos nubosos ': $icono_clima = '<i class="fa-solid fa-cloud-sun"></i>';
                    break;
                    case ' Cielos Nubosos ': $icono_clima = '<i class="fa-solid fa-cloud-sun"></i>';
                    break;
                    case ' Tormentas ': $icono_clima = '<i class="fa-solid fa-cloud-bolt"></i>';
                    break;
                    case ' Lluvia débil ': $icono_clima = '<i class="fa-solid fa-cloud-rain"></i>';
                    break;
                    case ' Lluvia moderada ': $icono_clima = '<i class="fa-solid fa-cloud-showers-heavy"></i>';
                    break;
                    case ' Cielos Cubiertos ': $icono_clima = '<i class="fa-solid fa-cloud"></i>';
                    break;
                  }

									/* SENSACION */
									foreach($html->find('span[class="dato-temperatura changeUnitT"]') as $e)
									$clima = $e->innertext;
									$sensacion = strip_tags($clima);

									/* MIN MAX */
									foreach($html->find('li[class="dia d1 activo"]') as $e)
									$clima = $e->innertext;
									$min_max = strip_tags($clima);
									$min = explode(' ', $min_max);
								?>
                <a class="card card-body border m-1 p-1 text-dark" href="https://www.meteored.com.ar/gn/3433323.htm" target="_blank" style="text-decoration: none;">
                  <span class="h5 text-center"><?php echo limitar_cadena("Jose Leon Suarez", 12); ?></span>
                  <span class="h6 text-center"><?php echo $descripcion; ?></span>
                  <span class="h1 text-center text-dark"><?php echo $icono_clima; ?></span>
                  <span class="h3 text-center"><?php echo $sensacion; ?></span>
                  <span class="text-center"><?php echo $hora; ?></span>
                  <p class="text-center"><span class="h6 text-primary"><?php if (strpos($min[11], '°') !== false){ echo $min[11]; } else { echo $min[16]; }; ?></span>
                  <span class="h6"> / </span>
                  <span class="h6 text-danger"><?php if (strpos($min[9], '°') !== false){ echo $min[9]; } else { echo $min[14]; }; ?></span></p>
                </a>
							</div>
              <div class="col-4 p-1" >
								<?php
									$link_clima = 'https://www.meteored.com.ar/tiempo-en_San+Nicolas-America+Sur-Argentina-Provincia+de+Buenos+Aires--1-16919.html';
									$curl = curl_init();
									curl_setopt($curl, CURLOPT_URL, $link_clima);
									$html = file_get_html($link_clima);
		
									/* LUGAR */
									foreach($html->find('h1[class="titulo"]') as $e)
									$clima = $e->innertext;
									$lugar = strip_tags($clima);
									$lugar = str_replace(['Tiempo en '], '', $lugar);

									/* HORA */
									foreach($html->find('span[class="hour"]') as $e)
									$clima = $e->innertext;
									$hora = strip_tags($clima);

									/* DESCRIPCION */
									foreach($html->find('span[class="descripcion"]') as $e)
									$clima = $e->innertext;
									$descripcion = strip_tags($clima);
                  switch($descripcion){
                    case ' Despejado ': $icono_clima = '<i class="fa-solid fa-sun"></i>';
                    break;
                    case ' Intervalos nubosos ': $icono_clima = '<i class="fa-solid fa-cloud-sun"></i>';
                    break;
                    case ' Cielos Nubosos ': $icono_clima = '<i class="fa-solid fa-cloud-sun"></i>';
                    break;
                    case ' Tormentas ': $icono_clima = '<i class="fa-solid fa-cloud-bolt"></i>';
                    break;
                    case ' Lluvia débil ': $icono_clima = '<i class="fa-solid fa-cloud-rain"></i>';
                    break;
                    case ' Lluvia moderada ': $icono_clima = '<i class="fa-solid fa-cloud-showers-heavy"></i>';
                    break;
                    case ' Cielos Cubiertos ': $icono_clima = '<i class="fa-solid fa-cloud"></i>';
                    break;
                  }

									/* SENSACION */
									foreach($html->find('span[class="dato-temperatura changeUnitT"]') as $e)
									$clima = $e->innertext;
									$sensacion = strip_tags($clima);

									/* MIN MAX */
									foreach($html->find('li[class="dia d1 activo"]') as $e)
									$clima = $e->innertext;
									$min_max = strip_tags($clima);
									$min = explode(' ', $min_max);
								?>
                <a class="card card-body border m-1 p-1 text-dark" href="https://www.meteored.com.ar/tiempo-en_San+Nicolas-America+Sur-Argentina-Provincia+de+Buenos+Aires--1-16919.html" target="_blank" style="text-decoration: none;">
                  <span class="h5 text-center"><?php echo limitar_cadena($lugar, 12); ?></span>
                  <span class="h6 text-center"><?php echo $descripcion; ?></span>
                  <span class="h1 text-center text-dark"><?php echo $icono_clima; ?></span>
                  <span class="h3 text-center"><?php echo $sensacion; ?></span>
                  <span class="text-center"><?php echo $hora; ?></span>
                  <p class="text-center"><span class="h6 text-primary"><?php if (strpos($min[11], '°') !== false){ echo $min[11]; } else { echo $min[16]; }; ?></span>
                  <span class="h6"> / </span>
                  <span class="h6 text-danger"><?php if (strpos($min[9], '°') !== false){ echo $min[9]; } else { echo $min[14]; }; ?></span></p>
                </a>
							</div>

						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<div class="modal" id="tareas_calendario_admin"  tabindex="-1" role="dialog"> <!-- MODAL CALENDARIO -->
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
					<a href="#" hidden id="tomar_id_editar"><span class="btn btn-warning">Editar</span></a>
					<a href="#" hidden id="tomar_id_delete"><span class="btn btn-danger">Eliminar</span></a>
				</div>
			</div>
		</div>
	</div>
	<!-- PIE DE PAGINA -->
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script>
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();
		});
	</script>
	<script src="/chart/dist/chart.js"></script>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var calendarEl = document.getElementById('calendar');
			var calendar = new FullCalendar.Calendar(calendarEl, {
				locale: 'es',
				headerToolbar: {
					left: 'prev,next today',
					center: 'title',
					right: 'dayGridMonth,listWeek'
				},
				initialView: window.innerWidth >= 765 ? 'dayGridMonth' : 'listWeek',
				nowIndicator: true,
				eventDidMount: function(info, event)
					{ 
						info.el.title = ( "Tarea: " + info.event.extendedProps.tarea +
															"\nCreador: " + info.event.extendedProps.creador +
															"\nDescripcion: " + info.event.extendedProps.contenido +
															"\nEstado: " + info.event.extendedProps.estado +
															"\nTecnico: " + info.event.extendedProps.tecnico +
															"\nInvolucrados: " + info.event.extendedProps.a_quien +
															"\nObservaciones: " + info.event.extendedProps.obs +
															"\nObs supervisor: " + info.event.extendedProps.obs_supervisor
														)
					},
				events: [<?php
									$calen = mysqli_query($conn, "SELECT * FROM calendario WHERE quien = '$quien_notas' OR a_quien LIKE '%$quien_notas%' "); 
									while($row = mysqli_fetch_assoc($calen))
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
										if($row['quien'] == $quien_notas && $row['estado'] !== 'Finalizado'){
										echo "creado_por: 'x',";
										}
                    echo "},";
									};
								?>],
				eventClick: function(info, event){
					$('#titulo_evento').html('<b>Titulo:</b> ' + info.event.extendedProps.titulo);
					$('#creador_evento').html('<b>Creador:</b> ' + info.event.extendedProps.creador);
          $('#contenido_evento').html('<b>Descripcion:</b> ' + info.event.extendedProps.contenido);
          $('#estadoEvento').html('<b>Estado:</b> ' + info.event.extendedProps.estado);
          $('#obs_evento').html('<b>Observaciones:</b> ' + info.event.extendedProps.obs);
          $('#tarea_evento').html('<b>Tarea:</b> ' + info.event.extendedProps.tarea);
          $('#tecnico_evento').html('<b>Tecnico:</b> ' + info.event.extendedProps.tecnico);
          $('#a_quien_evento').html('<b>Involucrados:</b> ' + info.event.extendedProps.a_quien);
          $('#tomado_por_evento').html('<b>Tomado por:</b> ' + info.event.extendedProps.tomado_por);
          $('#obs_supervisor').html('<b>Obs supervisor:</b> ' + info.event.extendedProps.obs_supervisor);
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
						linkDelete.setAttribute('href', "./Borrar/d_calendario.php?token=" + info.event.extendedProps.token);  /* TOMA EL VALOR DE 'href' Y LO REEMPLAZA */
					/* TOMAR ID Y AGREGARLO AL HREF */									
					/* TOMAR ID Y AGREGARLO AL HREF */
						const linkVer = document.querySelector('#tomar_id_ver'); /* ESCUCHAR EL DATO #tomar_id */
						linkVer.setAttribute('href', "./Basico/b_ver_calendario.php?token=" + info.event.extendedProps.token);  /* TOMA EL VALOR DE 'href' Y LO REEMPLAZA */
					/* TOMAR ID Y AGREGARLO AL HREF */
					/* TOMAR ID Y AGREGARLO AL HREF */
						const linkEditar = document.querySelector('#tomar_id_editar'); /* ESCUCHAR EL DATO #tomar_id */
						linkEditar.setAttribute('href', "/Editar/e_calendario.php?token=" + info.event.extendedProps.token);  /* TOMA EL VALOR DE 'href' Y LO REEMPLAZA */
					/* TOMAR ID Y AGREGARLO AL HREF */
					/* TOMAR ID Y AGREGARLO AL ACTION */
						const linkActionSi = document.querySelector('#tomar_id_action_si'); /* ESCUCHAR EL DATO #tomar_id */
						linkActionSi.setAttribute('action', "./Guardar/s_calendario.php?token=" + info.event.extendedProps.token);  /* TOMA EL VALOR DE 'action' Y LO REEMPLAZA */
					/* TOMAR ID Y AGREGARLO AL ACTION */
					/* TOMAR ID Y AGREGARLO AL ACTION */
						const linkActionNo = document.querySelector('#tomar_id_action_no'); /* ESCUCHAR EL DATO #tomar_id */
						linkActionNo.setAttribute('action', "./Guardar/s_calendario.php?token=" + info.event.extendedProps.token);  /* TOMA EL VALOR DE 'action' Y LO REEMPLAZA */
					/* TOMAR ID Y AGREGARLO AL ACTION */

					$('#tareas_calendario_admin').modal();
				},
			});
			calendar.render();
		});
	</script>
	<script>
		const config_int = {
			type: 'line',
			data: {
						labels: [
											<?php
												$a_tas = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha");
												while($row = mysqli_fetch_assoc($a_tas))
												{ echo "'" .Fecha11($row['fecha']) ."',"; }
											?>
										],
						datasets: 
						[
							{
								label: 'Altas',
								data: [
												<?php
													$a_a = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha");
													while($row = mysqli_fetch_assoc($a_a))
													{
														$fecha_a = $row['fecha'];

														$a_b = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas' FROM produccion WHERE fecha = '$fecha_a'");
														while($roa = mysqli_fetch_assoc($a_b))
														{ echo "'" .$roa['a_altas'] ."'," ; }

													}
												?>
											],
								backgroundColor: ['rgba(40, 167, 69, 0.7)'],
								borderColor: ['rgba(40, 167, 69, 0.5)',],
                tension: 0.2
							},
							{
								label: 'Bajas',
								data: [
												<?php
													$b_a = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha");
													while($row = mysqli_fetch_assoc($b_a))
													{
														$fecha_b = $row['fecha'];

														$b_b = mysqli_query($conn, "SELECT SUM(bajas) as 'a_bajas' FROM produccion WHERE fecha = '$fecha_b'");
														while($rob = mysqli_fetch_assoc($b_b))
														{ echo "'" .$rob['a_bajas'] ."'," ; }

													}
												?>
											],
								backgroundColor: ['rgba(220, 53, 69, 0.7)'],
								borderColor: ['rgba(220, 53, 69, 0.5)',],
                tension: 0.2
							},
							{
								label: 'Mtto',
								data: [
												<?php
													$c_a = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha");
													while($row = mysqli_fetch_assoc($c_a))
													{
														$fecha_c = $row['fecha'];

														$c_b = mysqli_query($conn, "SELECT SUM(tareasmtto) as 'a_mtto' FROM produccion WHERE fecha = '$fecha_c'");
														while($roc = mysqli_fetch_assoc($c_b))
														{ echo "'" .$roc['a_mtto'] ."'," ; }

													}
												?>
											],
								backgroundColor: ['rgba(23, 162, 184, 0.7)'],
								borderColor: ['rgba(23, 162, 184, 0.5)',],
                tension: 0.2
							},
							{
								label: 'Garantias',
								data: [
												<?php
													$d_a = mysqli_query($conn, "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha");
													while($row = mysqli_fetch_assoc($d_a))
													{
														$fecha_d = $row['fecha'];

														$d_b = mysqli_query($conn, "SELECT SUM(garantec) as 'a_garant' FROM produccion WHERE fecha = '$fecha_d'");
														while($rod = mysqli_fetch_assoc($d_b))
														{ echo "'" .$rod['a_garant'] ."'," ; }

													}
												?>
											],
								backgroundColor: ['rgba(255, 193, 7, 0.7)'],
								borderColor: ['rgba(255, 193, 7, 0.5)',],
                tension: 0.2
							}
						]
				},
			options: { responsive: true,}
		};
		const tareas = new Chart(
			document.getElementById('tareas'),
			config_int
		);
	</script>
  <script>
		const config_tec_alta = {
			type: 'bar',
			data: {
						labels: [
											<?php
												$a_tas = mysqli_query($conn, "SELECT SUM(tcumplida) as 'cant_altas', tecnico FROM produccion WHERE fecha like '%$mes%' GROUP BY tecnico ORDER BY cant_altas desc");
												while($row = mysqli_fetch_assoc($a_tas))
												{ echo "'" .$row['tecnico'] ."',"; }
											?>
										],
						datasets: 
						[
							{
								label: 'Altas',
								data: [
												<?php
													$a_a = mysqli_query($conn, "SELECT SUM(tcumplida) as 'cant_altas', tecnico FROM produccion WHERE fecha like '%$mes%' GROUP BY tecnico ORDER BY cant_altas desc");
													while($row = mysqli_fetch_assoc($a_a))
													{
														$tecnico_a = $row['tecnico'];

														$a_b = mysqli_query($conn, "SELECT SUM(tcumplida) as 'a_altas' FROM produccion WHERE tecnico = '$tecnico_a' AND fecha like '%$mes%'");
														while($roa = mysqli_fetch_assoc($a_b))
														{ echo "'" .$roa['a_altas'] ."'," ; }

													}
												?>
											],
								backgroundColor: ['rgba(40, 167, 69, 0.6)'],
								borderColor: ['rgba(40, 167, 69, 1)',],
                borderWidth: 2,
							}
						]
				},
			options: {
        indexAxis: 'y',
      }
		};
		const tectec_alta = new Chart(
			document.getElementById('graficos_tecnicos_alta'),
			config_tec_alta
		);
	</script>
  <script>
		const config_tec_baja = {
			type: 'bar',
			data: {
						labels: [
											<?php
												$b_tas = mysqli_query($conn, "SELECT SUM(bajas) as 'cant_bajas', tecnico FROM produccion WHERE fecha like '%$mes%' GROUP BY tecnico ORDER BY cant_bajas desc");
												while($row = mysqli_fetch_assoc($b_tas))
												{ echo "'" .$row['tecnico'] ."',"; }
											?>
										],
						datasets: 
						[
							{
								label: 'Bajas',
								data: [
												<?php
													$b_a = mysqli_query($conn, "SELECT SUM(bajas) as 'cant_bajas', tecnico FROM produccion WHERE fecha like '%$mes%' GROUP BY tecnico ORDER BY cant_bajas desc");
													while($row = mysqli_fetch_assoc($b_a))
													{
														$tecnico_b = $row['tecnico'];

														$b_b = mysqli_query($conn, "SELECT SUM(bajas) as 'a_bajas' FROM produccion WHERE tecnico = '$tecnico_b' AND fecha like '%$mes%'");
														while($roa = mysqli_fetch_assoc($b_b))
														{ echo "'" .$roa['a_bajas'] ."'," ; }

													}
												?>
											],
								backgroundColor: ['rgba(220, 53, 69, 0.6)'],
								borderColor: ['rgba(220, 53, 69, 1)',],
                borderWidth: 2,
							}
						]
				},
			options: {
        indexAxis: 'y',
      }
		};
		const tectec_baja = new Chart(
			document.getElementById('graficos_tecnicos_baja'),
			config_tec_baja
		);
	</script>
  <script>
		const config_tec_mtto = {
			type: 'bar',
			data: {
						labels: [
											<?php
												$c_tas = mysqli_query($conn, "SELECT SUM(tareasmtto) as 'cant_mtto', tecnico FROM produccion WHERE fecha like '%$mes%' GROUP BY tecnico ORDER BY cant_mtto desc");
												while($row = mysqli_fetch_assoc($c_tas))
												{ echo "'" .$row['tecnico'] ."',"; }
											?>
										],
						datasets: 
						[
							{
								label: 'Mantenimientos',
								data: [
												<?php
													$c_a = mysqli_query($conn, "SELECT SUM(tareasmtto) as 'cant_mtto', tecnico FROM produccion WHERE fecha like '%$mes%' GROUP BY tecnico ORDER BY cant_mtto desc");
													while($row = mysqli_fetch_assoc($c_a))
													{
														$tecnico_c = $row['tecnico'];

														$c_b = mysqli_query($conn, "SELECT SUM(tareasmtto) as 'a_mtto' FROM produccion WHERE tecnico = '$tecnico_c' AND fecha like '%$mes%'");
														while($roa = mysqli_fetch_assoc($c_b))
														{ echo "'" .$roa['a_mtto'] ."'," ; }

													}
												?>
											],
								backgroundColor: ['rgba(23, 162, 184, 0.6)'],
								borderColor: ['rgba(23, 162, 184, 1)',],
                borderWidth: 2,
							}
						]
				},
			options: {
        indexAxis: 'y',
      }
		};
		const tectec_mtto = new Chart(
			document.getElementById('graficos_tecnicos_mtto'),
			config_tec_mtto
		);
	</script>
  <script>
		const config_tec_garantias = {
			type: 'bar',
			data: {
						labels: [
											<?php
												$d_tas = mysqli_query($conn, "SELECT COUNT(tecrep) as 'a_garantias', tecnico, tecrep FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' GROUP BY tecnico ORDER BY a_garantias desc");
												while($row = mysqli_fetch_assoc($d_tas))
												{ echo "'" .$row['tecnico'] ."',"; }
											?>
										],
						datasets: 
						[
							{
								label: 'Garantias',
								data: [
												<?php
													$d_a = mysqli_query($conn, "SELECT COUNT(tecrep) as 'a_garantias', tecnico, tecrep FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> '' GROUP BY tecnico ORDER BY a_garantias desc");
													while($row = mysqli_fetch_assoc($d_a))
													{
														$tecnico_d = $row['tecnico'];

														$d_b = mysqli_query($conn, "SELECT COUNT(tecrep) as 'a_garantias', tecnico, tecrep FROM garantias WHERE fecharep like '%$mes%' AND tecnico = '$tecnico_d' AND tecrep <> '' GROUP BY tecnico ORDER BY a_garantias desc");
														while($roa = mysqli_fetch_assoc($d_b))
														{ echo "'" .$roa['a_garantias'] ."'," ; }

													}
												?>
											],
								backgroundColor: ['rgba(255, 193, 7, 0.6)'],
								borderColor: ['rgba(255, 193, 7, 1)',],
                borderWidth: 2,
							}
						]
				},
			options: {
        indexAxis: 'y',
      }
		};
		const tectec_garantias = new Chart(
			document.getElementById('graficos_tecnicos_garantias'),
			config_tec_garantias
		);
	</script>
  <script>
		const config_supervisores = {
			type: 'radar',
			data: {
						labels: ['Auditoria instalacion', 'Auditoria vehiculo', 'Auditoria herramientas', 'Reclamos', 'Garantias', 'Relevamiento fotografico', 'Otro'],
						datasets: 
						[
              <?php
                $rrr = mysqli_query($conn, "SELECT * FROM usuarios WHERE tipo_us = 'Supervisor' ORDER BY nombre asc");
								while($roww=$rrr->fetch_assoc())
								{
									$tecnico_sup = $roww['nombre'] .' ' .$roww['apellido'];
									if($tecnico_sup == 'Carlos Banega'){$color_sup = '145,236,173';}
									if($tecnico_sup == 'Elias Rosas'){$color_sup = '244,83,95';}
									if($tecnico_sup !== 'Elias Rosas' && $tecnico_sup !== 'Carlos Banega'){$color_sup = '244,230,32';}

									$insta = mysqli_query($conn, "SELECT COUNT(tecnico) as 'super_inst' FROM auditoria_instalaciones WHERE fecha like '%$mes%' AND supervisor = '$tecnico_sup'");
									while($row = mysqli_fetch_assoc($insta))
									{$auditoria_instalacion = $row['super_inst'];}

									$vehi = mysqli_query($conn, "SELECT COUNT(tecnico) as 'super_vehi' FROM auditoria_vehiculo WHERE fecha like '%$mes%' AND supervisor = '$tecnico_sup'");
									while($row = mysqli_fetch_assoc($vehi))
									{$auditoria_vehiculo = $row['super_vehi'];}

									$herra = mysqli_query($conn, "SELECT COUNT(tecnico) as 'super_herra' FROM auditoria WHERE fecha like '%$mes%' AND supervisor = '$tecnico_sup'");
									while($row = mysqli_fetch_assoc($herra))
									{$auditoria_herramientas = $row['super_herra'];}

									$recla = mysqli_query($conn, "SELECT COUNT(a_quien) as 'super_recla' FROM calendario WHERE inicio like '%$mes%' AND a_quien = '$tecnico_sup' AND estado = 'Finalizado' AND tarea = 'Reclamo'");
									while($row = mysqli_fetch_assoc($recla))
									{$auditoria_reclamos = $row['super_recla'];}

									$garant = mysqli_query($conn, "SELECT COUNT(a_quien) as 'super_garant' FROM calendario WHERE inicio like '%$mes%' AND a_quien = '$tecnico_sup' AND estado = 'Finalizado' AND tarea = 'Garantia'");
									while($row = mysqli_fetch_assoc($garant))
									{$auditoria_garantia = $row['super_garant'];}

									$fotogra = mysqli_query($conn, "SELECT COUNT(a_quien) as 'super_fotogra' FROM calendario WHERE inicio like '%$mes%' AND a_quien = '$tecnico_sup' AND estado = 'Finalizado' AND tarea = 'Relevamiento fotografico'");
									while($row = mysqli_fetch_assoc($fotogra))
									{$auditoria_fotografico = $row['super_fotogra'];}

									$otro = mysqli_query($conn, "SELECT COUNT(a_quien) as 'super_otro' FROM calendario WHERE inicio like '%$mes%' AND a_quien = '$tecnico_sup' AND estado = 'Finalizado' AND tarea = 'Otro'");
									while($row = mysqli_fetch_assoc($otro))
									{$auditoria_otro = $row['super_otro'];}

									echo '{
													label: "' .$tecnico_sup .'",
													data: ['
																	.'"' .$auditoria_instalacion  .'","' .$auditoria_vehiculo  .'","' .$auditoria_herramientas  .'","' .$auditoria_reclamos  .'","' .$auditoria_garantia  .'","' .$auditoria_fotografico  .'","' .$auditoria_otro  .'"'
															.'],
													backgroundColor: ["rgba(' .$color_sup .', 0.6)"],'
												.'borderColor: ["rgba(' .$color_sup .', 1)",],'
												.'borderWidth: 2'
											.'},';
								}
							?>
						]
				},
			options: {
        indexAxis: 'y',
				resposive: true,
      }
		};
		const tec_supervisores = new Chart(
			document.getElementById('supervisores'),
			config_supervisores
		);
	</script>
</body>
</html>

