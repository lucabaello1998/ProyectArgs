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
	if($tipo_us == "Despacho") { $usu = 1; }
  if($tipo_us == "Supervisor") { $usu = 1; }
  if($tipo_us == "Deposito") { $usu = 1; }
	if($usu != 1)
	{
		switch ($tipo_us)
		{
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
						<input type="hidden" name="link" value="../inicio_deposito.php">
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
						<input type="hidden" name="link" value="../inicio_deposito.php">
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
    $dias_trabajo = 6;
    
    if($zona_us == 'Todo')
			{$altas = mysqli_query($conn, "SELECT SUM(tcumplida) as 't_altas', SUM(dosplay+tresplay) as 't_dosytres', SUM(tareasmtto) as 't_mtto', SUM(mtto_ext) as 't_mtto_ext', SUM(bajas) as 't_baja', SUM(garantec) as 't_garantia' FROM produccion WHERE fecha like '%$mes%'");}
      else
      {$altas = mysqli_query($conn, "SELECT SUM(tcumplida) as 't_altas', SUM(dosplay+tresplay) as 't_dosytres', SUM(tareasmtto) as 't_mtto', SUM(mtto_ext) as 't_mtto_ext', SUM(bajas) as 't_baja', SUM(garantec) as 't_garantia' FROM produccion WHERE fecha like '%$mes%' AND zona = '$zona_us'");}
			while($a = mysqli_fetch_assoc($altas))
			{ 
				$t_altas = $a['t_altas'];
				$t_dosytres = $a['t_dosytres'];
				$t_baja = $a['t_baja'];
				$t_mtto = $a['t_mtto'];
				$t_mtto_ext = $a['t_mtto_ext'];
				$t_garantia = $a['t_garantia'];
			}

      if($zona_us == 'Todo')
			{$bajas = mysqli_query($conn, "SELECT COUNT(tecnico) as 'b_tkl' FROM bajas WHERE calendario LIKE '%$mes%' AND tkl = ''");}
      else
      {$bajas = mysqli_query($conn, "SELECT COUNT(tecnico) as 'b_tkl' FROM bajas WHERE calendario LIKE '%$mes%' AND tkl = '' AND zona = '$zona_us'");}
			while($b = mysqli_fetch_assoc($bajas))
			{ $tkl = $b['b_tkl']; }

      if($zona_us == 'Todo')
      {$alta_sitema = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_sis' FROM altas WHERE calendario LIKE '%$mes%'");}
      else
      {$alta_sitema = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_sis' FROM altas WHERE calendario LIKE '%$mes%' AND zona = '$zona_us'");}
			while($rob = mysqli_fetch_assoc($alta_sitema))
			{ $a_sis = $rob['a_sis'] ; }

      if($zona_us == 'Todo')
      {$mtto_sitema = mysqli_query($conn, "SELECT COUNT(tecnico) as 'mtto_sis' FROM mtto WHERE fecha LIKE '%$mes%'");}
      else
      {$mtto_sitema = mysqli_query($conn, "SELECT COUNT(tecnico) as 'mtto_sis' FROM mtto WHERE fecha LIKE '%$mes%'");}
			while($rob = mysqli_fetch_assoc($mtto_sitema))
			{ $mtto_sis = $rob['mtto_sis'] ; }

      if($zona_us == 'Todo')
      {$gar_sis = mysqli_query($conn, "SELECT COUNT(tecnico) as 'garan_incom' FROM garantias WHERE fecharep LIKE '%$mes%' AND tecrep = ''");}
      else
      {$gar_sis = mysqli_query($conn, "SELECT COUNT(tecnico) as 'garan_incom' FROM garantias WHERE fecharep LIKE '%$mes%' AND tecrep = '' AND zona = '$zona_us'");}
			while($rob = mysqli_fetch_assoc($gar_sis))
			{ $garan_incom = $rob['garan_incom'] ; }

      if($zona_us == 'Todo')
      {$tec = mysqli_query($conn, "SELECT COUNT(tecnico) as 'cant_tecnicos' FROM tecnicos WHERE activo ='SI' AND tipo ='Tecnico'");}
      else
      {$tec = mysqli_query($conn, "SELECT COUNT(tecnico) as 'cant_tecnicos' FROM tecnicos WHERE activo ='SI' AND tipo ='Tecnico' AND zona = '$zona_us'");}
      while($row = mysqli_fetch_assoc($tec))
      { $cant_tecnicos = $row['cant_tecnicos'];}

      if($zona_us == 'Todo')
      {$ayudantes = mysqli_query($conn, "SELECT COUNT(tecnico) as 'cant_ayudantes' FROM tecnicos WHERE activo ='SI' AND tipo ='Ayudante'");}
      else
      {$ayudantes = mysqli_query($conn, "SELECT COUNT(tecnico) as 'cant_ayudantes' FROM tecnicos WHERE activo ='SI' AND tipo ='Ayudante' AND zona = '$zona_us'");}
      while($row = mysqli_fetch_assoc($ayudantes))
      {
        if($row['cant_ayudantes'] == '')
        {$cant_ayudantes = 0;}
        else
        {$cant_ayudantes = $row['cant_ayudantes'];}
      }

      if($zona_us == 'Todo')
      {$capacitacion = mysqli_query($conn, "SELECT COUNT(tecnico) as 'cant_capacitacion' FROM tecnicos WHERE activo ='NO' AND tipo ='Capacitacion'");}
      else
      {$capacitacion = mysqli_query($conn, "SELECT COUNT(tecnico) as 'cant_capacitacion' FROM tecnicos WHERE activo ='NO' AND tipo ='Capacitacion' AND zona = '$zona_us'");}
      while($row = mysqli_fetch_assoc($capacitacion))
      {
        if($row['cant_capacitacion'] == '')
        {$cant_capacitacion = 0;}
        else
        {$cant_capacitacion = $row['cant_capacitacion'];}
      }

      if($zona_us == 'Todo')
      {$preocupacional = mysqli_query($conn, "SELECT COUNT(tecnico) as 'cant_preocupacional' FROM tecnicos WHERE activo ='NO' AND tipo ='Preocupacional'");}
      else
      {$preocupacional = mysqli_query($conn, "SELECT COUNT(tecnico) as 'cant_preocupacional' FROM tecnicos WHERE activo ='NO' AND tipo ='Preocupacional' AND zona = '$zona_us'");}
      while($row = mysqli_fetch_assoc($preocupacional))
      {
        if($row['cant_preocupacional'] == '')
        {$cant_preocupacional = 0;}
        else
        {$cant_preocupacional = $row['cant_preocupacional'];}
      }


      if($zona_us == 'Todo')
      {$series = mysqli_query($conn, "SELECT * FROM ingresomaterial WHERE seriado <> '' GROUP BY material");}
      else
      {$series = mysqli_query($conn, "SELECT * FROM ingresomaterial WHERE seriado <> '' AND deposito = '$zona_us' GROUP BY material");}
      while($ros = mysqli_fetch_array($series))
      { $serializados[] = $ros['material']; }

      $as = mysqli_query($conn, "SELECT * FROM asignacion_material ORDER BY fecha desc LIMIT 1");  
      while($row = mysqli_fetch_assoc($as))
      {
        $ultimo_dia = $row['fecha'];
      }
      if($zona_us == 'Todo')
      {$resu = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE fecha like '%$ultimo_dia%' AND tipo = 'Asignacion' GROUP BY tecnico ");}
      else
      {$resu = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE fecha like '%$ultimo_dia%' AND deposito = '$zona_us' AND tipo = 'Asignacion' GROUP BY tecnico ");}
      while($row = mysqli_fetch_assoc($resu))
      {
        $array[] = $row['tecnico']; 
      }
			if($zona_us == 'Todo')
      {$descar = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE fecha like '%$ultimo_dia%' AND tipo = 'Descarga' GROUP BY tecnico ");}
      else
      {$descar = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE fecha like '%$ultimo_dia%' AND deposito = '$zona_us' AND tipo = 'Descarga' GROUP BY tecnico ");}
      while($rod = mysqli_fetch_assoc($descar))
      {
        $array_descarga[] = $rod['tecnico']; 
      }
    ?>
	<!-- TOTAL-->
	<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
		<div class="row pr-2 pl-2 pt-0 pb-0">
			<div class="col-md-8 col-12">
				<div class="row"> <!-- TARJETAS -->
					<div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
						<div class="row rounded bg-white shadow border-left border-success m-1 text-muted">
							<div class="col-6 p-2">
								<p class="h2 text-left text-success"><i class="fa-solid fa-angle-up"></i></p>
							</div>
							<div class="col-6 p-2">
									<p class="h4 text-muted text-center">Altas</p>
									<p class="h3 text-muted text-center"><?php echo $t_altas; ?></p>
							</div>
						</div>
						<div class="row rounded bg-white shadow border-left border-success m-1 justify-content-between">
							<div class="col-auto h6 p-2 text-muted m-0">
								En sistema
							</div>
							<div class="col-auto h6 p-2 text-muted m-0">
								<?php echo $a_sis; ?>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
						<div class="row rounded bg-white shadow border-left border-danger m-1">
							<div class="col-6 p-2">
								<p class="h2 text-left text-danger"><i class="fa-solid fa-angle-down"></i></p>
							</div>
							<div class="col-6 p-2">
									<p class="h4 text-muted text-center">Bajas</p>
									<p class="h3 text-muted text-center"><?php echo $t_baja; ?></p>
							</div>
						</div>
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
						<div class="row rounded bg-white shadow border-left border-info m-1">
							<div class="col-6 p-2">
								<p class="h2 text-left text-info"><i class="fas fa-toolbox"></i></p>
							</div>
							<div class="col-6 p-2">
									<p class="h4 text-muted text-center">Mtto</p>
									<p class="h3 text-muted text-center"><?php echo $t_mtto; ?></p>
							</div>
						</div>
						<div class="row rounded bg-white shadow border-left border-info m-1 justify-content-between">
							<div class="col-auto h6 p-2 text-muted m-0">
								En sistema
							</div>
							<div class="col-auto h6 p-2 text-muted m-0">
								<?php echo $mtto_sis; ?>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
						<div class="row rounded bg-white shadow border-left border-warning m-1">
							<div class="col-6 p-2">
								<p class="h2 text-left text-warning"><i class="fa-solid fa-arrows-rotate"></i></p>
							</div>
							<div class="col-6 p-2">
									<p class="h4 text-muted text-center">Garant</p>
									<p class="h3 text-muted text-center"><?php echo $t_garantia; ?></p>
							</div>
						</div>
						<div class="row rounded bg-white shadow border-left border-warning m-1 justify-content-between">
							<div class="col-auto h6 p-2 text-muted m-0">
								Incompletas
							</div>
							<div class="col-auto h6 p-2 text-muted m-0">
								<?php echo $garan_incom; ?>
							</div>
						</div>
					</div>
				</div>

        <div class="row"> <!-- MATERIALES -->
					<div class="col-12 p-0">
						<div class="row rounded bg-white shadow m-1 p-2">
              <canvas id="graficos_tecnicos_alta" class="p-2" height="100vh" width="100vw"></canvas>
						</div>
					</div>
				</div>

			</div>
			<div class="col-md-4 col-12">

        <div class="row"> <!-- AYUDANTES -->
					<div class="col-lg-6 col-md-12 col-12 p-0">
						<div class="row rounded bg-white shadow border-left border-primary m-1 text-muted">
              <div class="col-6 p-2">
                <p class="h2 text-left text-primary"><i class="fa-solid fa-users"></i></p>
              </div>
              <div class="col-6 p-2">
                  <p class="h4 text-muted text-center">Tecnicos</p>
                  <p class="h3 text-muted text-center"><?php echo $cant_tecnicos; ?></p>
              </div>
						</div>
            <div class="row rounded bg-white shadow border-left border-primary m-1 justify-content-between">
							<div class="col-auto h6 p-2 text-muted m-0">
								Capacitacion
							</div>
							<div class="col-auto h6 p-2 text-muted m-0">
								<?php echo $cant_capacitacion; ?>
							</div>
						</div>
					</div>
          <div class="col-lg-6 col-md-12 col-12 p-0">
						<div class="row rounded bg-white shadow border-left border-secondary m-1 text-muted">
              <div class="col-6 p-2">
                <p class="h2 text-left text-secondary"><i class="fa-solid fa-user-group"></i></p>
              </div>
              <div class="col-6 p-2">
                  <p class="h4 text-muted text-center">Ayudantes</p>
                  <p class="h3 text-muted text-center"><?php echo $cant_ayudantes; ?></p>
              </div>
						</div>
            <div class="row rounded bg-white shadow border-left border-secondary m-1 justify-content-between">
              <div class="col-auto h6 p-2 text-muted m-0">
                Preocupacional
              </div>
              <div class="col-auto h6 p-2 text-muted m-0">
                <?php echo $cant_preocupacional; ?>
              </div>
            </div>
					</div>
				</div>

        <div class="row"> <!-- LISTADO TECNICOS -->
					<div class="col-12 p-0">
						<div class="row rounded bg-white shadow m-1 text-muted">
							<div class="col-12 p-2 text-dark">
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
								:root { --sel-color: #6ded6d;}
                sel 
                {
                  --color: var(--sel-color, red);
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
							<span><b>Ultimo dia: </b><?php echo Fecha7($ultimo_dia); ?></span>
							<br>
							<span><b>Materiales asignados: </b><del>Tecnico</del></span>
							<br>
							<span><b>Materiales descargados: </b><sel>Tecnico</sel></span>
							<br>
              <?php
                if($zona_us == 'Todo')
                  {$lista_tec = mysqli_query($conn, "SELECT * FROM tecnicos WHERE activo = 'SI' AND tipo = 'Tecnico' ORDER BY tecnico asc");}
                  else
                  {$lista_tec = mysqli_query($conn, "SELECT * FROM tecnicos WHERE activo = 'SI' AND tipo = 'Tecnico' AND zona = '$zona_us' ORDER BY tecnico asc");}
                  while($row = mysqli_fetch_assoc($lista_tec))
                  {
                    $tec = $row['tecnico'];
                    if (in_array($tec, $array))
                    { 
											if (in_array($tec, $array_descarga))
											{
												echo '<sel> ' .$tec .' </sel> - ';
											}
											else
											{
												echo '<del> ' .$tec .' </del> - ';
											}
										}
                    else
                    { echo ' ' .$tec .' - '; }
                  }
              ?>
							</div>
						</div>
					</div>
				</div>

				<div class="row"> <!-- CALENDARIO -->
					<div class="col-12 p-0">
						<div class="row rounded bg-white shadow m-1 p-2">
              <style>
                #calendar{
                  height: 40rem !important;
                }
              </style>
							<div id="calendar" class="col-12 p-0"></div>
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
																				setInterval(function(){
																					$('#check<?php echo $roww['token']; ?>').load('/Ajax/a_check.php?token=<?php echo $roww['token']; ?>')
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
																			setInterval(function(){
																				$(document).ready(function(){
																					$('#msj<?php echo $roww['token']; ?>').load('/Ajax/a_mensajes.php?token=<?php echo $roww['token']; ?>')
																				});
																			},5000);
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

			</div>
		</div>
	</div>

	<div class="modal" id="tareas_calendario_supervisor"  tabindex="-1" role="dialog"> <!-- MODAL CALENDARIO -->
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
				eventDidMount: function(info, event)
        { 
          info.el.title = ( "Tarea: " + info.event.extendedProps.tarea +
                            "\nDescripcion: " + info.event.extendedProps.contenido +
                            "\nEstado: " + info.event.extendedProps.estado +
                            "\nTecnico: " + info.event.extendedProps.tecnico +
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
                    echo "tecnico: '" .$row['quien'] ."',";
                    echo "estado: '" .$row['estado'] ."',";
                    echo "color: '" .$row['color'] ."',";
                    echo "titulo: '" .$row['titulo'] ."',";
                    echo "obs: '" .$row['obs'] ."',";
                    echo "tarea: '" .$row['tarea'] ."',";
                    echo "tecnico: '" .$row['tecnico'] ."',";
                    echo "obs_supervisor: '" .$row['obs_supervisor'] ."',";
                    if($row['quien'] == $quien_notas && $row['estado'] !== 'Finalizado')
										{
											echo "creado_por: 'x',";
										}
                    echo "},";
									};
								?>],
				eventClick: function(info, event){
          $('#titulo_evento').html('<b>Titulo:</b> ' + info.event.extendedProps.titulo);
          $('#contenido_evento').html('<b>Descripcion:</b> ' + info.event.extendedProps.contenido);
          $('#estadoEvento').html('<b>Estado:</b> ' + info.event.extendedProps.estado);
          $('#obs_evento').html('<b>Observaciones:</b> ' + info.event.extendedProps.obs);
          $('#tarea_evento').html('<b>Tarea:</b> ' + info.event.extendedProps.tarea);
          $('#tecnico_evento').html('<b>Tecnico:</b> ' + info.event.extendedProps.tecnico);
          $('#obs_supervisor').html('<b>Obs supervisor:</b> ' + info.event.extendedProps.obs_supervisor);
          $('#tomado_evento').html(info.event.extendedProps.tomado_por);
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

          $('#tareas_calendario_supervisor').modal();
        },
			});
			calendar.render();
		});
	</script>
	<script>
		const config_penalizaciones = {
			type: 'bar',
			data: {
              labels: [
                      <?php
                        $a_pena = mysqli_query($conn, "SELECT * FROM descuentos WHERE fecha like '%$mes%' GROUP BY tecnico ORDER BY tecnico asc");
                        while($row = mysqli_fetch_assoc($a_pena))
                        { echo "'" .$row['tecnico'] ."',"; }
                      ?>
                    ],
              datasets: 
              [
                {
                  label: 'Penalizaciones',
                  data: [
                          <?php
														
                            $a1 = mysqli_query($conn, "SELECT * FROM descuentos WHERE fecha like '%$mes%' GROUP BY tecnico ORDER BY tecnico asc");
                            while($row = mysqli_fetch_assoc($a1))
                            {
                              $tec_a1 = $row['tecnico'];
                              
                              $a1_a = mysqli_query($conn, "SELECT COUNT(tecnico) as 'a_pena' FROM descuentos WHERE tecnico = '$tec_a1' AND fecha like '%$mes%'");
                              while($roa = mysqli_fetch_assoc($a1_a))
                              { echo "'" .$roa['a_pena'] ."',";}
                            }
                          ?>
                        ],
                backgroundColor: ['rgba(255, 117, 20, 0.6)'],
								borderColor: ['rgba(255, 117, 20, 1)',],
                borderWidth: 2,
                borderRadius: 10,
                }
              ]
        },
			options: {resposive: true,
        indexAxis: 'y',}
		};
		const tec_penalizaciones = new Chart(
			document.getElementById('penalizaciones'),
			config_penalizaciones
		);
	</script>
  <?php if($zona_us == 'Todo'){ ?>
    <script>
      const config_tec_alta = {
        type: 'bar',
        data: {
              labels: [
                        <?php 
                          $sr1 = mysqli_query($conn, "SELECT * FROM ingresomaterial WHERE seriado = '' AND cantidad > 0 GROUP BY material");
                          while($row = mysqli_fetch_array($sr1))
                          {
                            if(in_array($row['material'], $serializados,))
                            {
                            }
                            else
                            {
                              echo "'" .utf8_encode($row['material']) ."',";
                            }
                          }
                        ?>
                        <?php 
                          $sri1 = mysqli_query($conn, "SELECT * FROM ingresomaterial WHERE seriado <> '' GROUP BY material");
                          while($roo = mysqli_fetch_array($sri1))
                          { 
                            echo "'" .utf8_encode($roo['material']) ."',";
                          }
                        ?>
                      ],
              datasets: 
              [
                {
                  label: '1 dia',
                  data: [
                          <?php
                            $sr2 = mysqli_query($conn, "SELECT * FROM ingresomaterial WHERE seriado = '' AND cantidad > 0 GROUP BY material");
                            while($roe = mysqli_fetch_array($sr2))
                            {
                              if(in_array($roe['material'], $serializados,))
                              {
                              }
                              else
                              {
                                $mate2 = $roe['material'];
                                $sr3 = mysqli_query($conn, "SELECT SUM(cantidad) as 'un_precar' FROM asignacion_material WHERE tipo = 'Precarga' AND material = '$mate2'");
                                while($ror = mysqli_fetch_array($sr3))
                                { 
                                  $poco_material = $ror['un_precar'] * ($cant_tecnicos) ;
                                  echo "'" .$poco_material ."'," ; 
                                }
                              }
                            }
                          ?>
                        ],
                  backgroundColor: ['rgba(220, 53, 69, 0.6)'],
                  borderColor: ['rgba(220, 53, 69, 1)',],
                  borderWidth: 2,
                },
                {
                  label: 'Poco material (<?php echo $dias_trabajo *2 .' dias'; ?>)',
                  data: [
                          <?php
                            $sr4 = mysqli_query($conn, "SELECT * FROM ingresomaterial WHERE seriado = '' AND cantidad > 0 GROUP BY material");
                            while($rot = mysqli_fetch_array($sr4))
                            {
                              if(in_array($rot['material'], $serializados,))
                              {
                              }
                              else
                              {
                                $mate3 = $rot['material'];
                                $sr5 = mysqli_query($conn, "SELECT SUM(cantidad) as 'cant_precar' FROM asignacion_material WHERE tipo = 'Precarga' AND material = '$mate3'");
                                while($roy = mysqli_fetch_array($sr5))
                                { 
                                  $poco_m = $roy['cant_precar'] * ($dias_trabajo * 2) * ($cant_tecnicos) ;
                                  echo "'" .$poco_m ."'," ; 
                                }
                              }
                            }
                          ?>
                        ],
                  backgroundColor: ['rgba(255, 193, 7, 0.6)'],
                  borderColor: ['rgba(255, 193, 7, 1)',],
                  borderWidth: 2,
                },
                {
                  label: 'Stock actual',
                  data: [
                          <?php
                            $sr6 = mysqli_query($conn, "SELECT *, SUM(cantidad) as 'depo' FROM ingresomaterial WHERE seriado = '' AND cantidad > 0 GROUP BY material");
                            while($rou = mysqli_fetch_array($sr6))
                            {
                              if(in_array($rou['material'], $serializados,))
                              {
                              }
                              else
                              {
                                $mate4 = $rou['material'];
                                $cantidad_material = $rou['depo'];
                                $toti = $cantidad_material;
                                $sr7 = mysqli_query($conn, "SELECT SUM(usado) as 'todo_usado' FROM asignacion_material WHERE tipo = 'Descarga' AND material = '$mate4' GROUP BY material");
                                while($roy = mysqli_fetch_array($sr7))
                                { 
                                  $cantidad_total = ($cantidad_material - $roy['todo_usado']);
                                  $toti = $cantidad_total;
                                }
                                echo "'" .$toti ."'," ;
                              }
                            }
                          ?>
                          <?php
                            $sr8 = mysqli_query($conn, "SELECT *, SUM(cantidad) as 'depo_se' FROM ingresomaterial WHERE seriado <> '' GROUP BY material");
                            while($rou = mysqli_fetch_array($sr8))
                            {
                                $mate5 = $rou['material'];
                                $cantidad_seriado = $rou['depo_se'];
                                $toti_serie = $cantidad_seriado;
                                $sr9 = mysqli_query($conn, "SELECT SUM(usado) as 'todo_usado' FROM asignacion_material WHERE tipo = 'Descarga' AND material = '$mate5' GROUP BY material");
                                while($roi = mysqli_fetch_array($sr9))
                                { 
                                  $cantidad_total_seriado = ($cantidad_seriado - $roi['todo_usado']);
                                  $toti_serie = $cantidad_total_seriado;
                                }
                                echo "'" .$toti_serie ."'," ;
                              
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
            responsive: true,
            scales: {
              x: {
                stacked: false,
              },
              y: {
                stacked: true
              }
            },
            indexAxis: 'y',
          },
        
      };
      const tectec_alta = new Chart(
        document.getElementById('graficos_tecnicos_alta'),
        config_tec_alta
      );
    </script>
  <?php } else { ?>
    <script>
      const config_tec_alta = {
        type: 'bar',
        data: {
              labels: [
                        <?php 
                          $sr1 = mysqli_query($conn, "SELECT * FROM ingresomaterial WHERE seriado = '' AND cantidad > 0 AND deposito = '$zona_us' GROUP BY material");
                          while($row = mysqli_fetch_array($sr1))
                          {
                            if(in_array($row['material'], $serializados,))
                            {
                            }
                            else
                            {
                              echo "'" .utf8_encode($row['material']) ."',";
                            }
                          }
                        ?>
                        <?php 
                          $sri1 = mysqli_query($conn, "SELECT * FROM ingresomaterial WHERE seriado <> '' AND deposito = '$zona_us' GROUP BY material");
                          while($roo = mysqli_fetch_array($sri1))
                          { 
                            echo "'" .utf8_encode($roo['material']) ."',";
                          }
                        ?>
                      ],
              datasets: 
              [
                {
                  label: '1 dia',
                  data: [
                          <?php
                            $sr2 = mysqli_query($conn, "SELECT * FROM ingresomaterial WHERE seriado = '' AND cantidad > 0 AND deposito = '$zona_us' GROUP BY material");
                            while($roe = mysqli_fetch_array($sr2))
                            {
                              if(in_array($roe['material'], $serializados,))
                              {
                              }
                              else
                              {
                                $mate2 = $roe['material'];
                                $sr3 = mysqli_query($conn, "SELECT SUM(cantidad) as 'un_precar' FROM asignacion_material WHERE tipo = 'Precarga' AND material = '$mate2' AND deposito = '$zona_us'");
                                while($ror = mysqli_fetch_array($sr3))
                                { 
                                  $poco_material = $ror['un_precar'] * ($cant_tecnicos) ;
                                  echo "'" .$poco_material ."'," ; 
                                }
                              }
                            }
                          ?>
                        ],
                  backgroundColor: ['rgba(220, 53, 69, 0.6)'],
                  borderColor: ['rgba(220, 53, 69, 1)',],
                  borderWidth: 2,
                },
                {
                  label: 'Poco material (<?php echo $dias_trabajo *2 .' dias'; ?>)',
                  data: [
                          <?php
                            $sr4 = mysqli_query($conn, "SELECT * FROM ingresomaterial WHERE seriado = '' AND cantidad > 0 AND deposito = '$zona_us' GROUP BY material");
                            while($rot = mysqli_fetch_array($sr4))
                            {
                              if(in_array($rot['material'], $serializados,))
                              {
                              }
                              else
                              {
                                $mate3 = $rot['material'];
                                $sr5 = mysqli_query($conn, "SELECT SUM(cantidad) as 'cant_precar' FROM asignacion_material WHERE tipo = 'Precarga' AND material = '$mate3' AND deposito = '$zona_us'");
                                while($roy = mysqli_fetch_array($sr5))
                                { 
                                  $poco_m = $roy['cant_precar'] * ($dias_trabajo * 2) * ($cant_tecnicos) ;
                                  echo "'" .$poco_m ."'," ; 
                                }
                              }
                            }
                          ?>
                        ],
                  backgroundColor: ['rgba(255, 193, 7, 0.6)'],
                  borderColor: ['rgba(255, 193, 7, 1)',],
                  borderWidth: 2,
                },
                {
                  label: 'Stock actual',
                  data: [
                          <?php
                            $sr6 = mysqli_query($conn, "SELECT *, SUM(cantidad) as 'depo' FROM ingresomaterial WHERE seriado = '' AND cantidad > 0 AND deposito = '$zona_us' GROUP BY material");
                            while($rou = mysqli_fetch_array($sr6))
                            {
                              if(in_array($rou['material'], $serializados,))
                              {
                              }
                              else
                              {
                                $mate4 = $rou['material'];
                                $cantidad_material = $rou['depo'];
                                $toti = $cantidad_material;
                                $sr7 = mysqli_query($conn, "SELECT SUM(usado) as 'todo_usado' FROM asignacion_material WHERE tipo = 'Descarga' AND material = '$mate4' AND deposito = '$zona_us' GROUP BY material");
                                while($roy = mysqli_fetch_array($sr7))
                                { 
                                  $cantidad_total = ($cantidad_material - $roy['todo_usado']);
                                  $toti = $cantidad_total;
                                }
                                echo "'" .$toti ."'," ;
                              }
                            }
                          ?>
                          <?php
                            $sr8 = mysqli_query($conn, "SELECT *, SUM(cantidad) as 'depo_se' FROM ingresomaterial WHERE seriado <> '' AND deposito = '$zona_us' GROUP BY material");
                            while($rou = mysqli_fetch_array($sr8))
                            {
                                $mate5 = $rou['material'];
                                $cantidad_seriado = $rou['depo_se'];
                                $toti_serie = $cantidad_seriado;
                                $sr9 = mysqli_query($conn, "SELECT SUM(usado) as 'todo_usado' FROM asignacion_material WHERE tipo = 'Descarga' AND material = '$mate5' AND deposito = '$zona_us' GROUP BY material");
                                while($roi = mysqli_fetch_array($sr9))
                                { 
                                  $cantidad_total_seriado = ($cantidad_seriado - $roi['todo_usado']);
                                  $toti_serie = $cantidad_total_seriado;
                                }
                                echo "'" .$toti_serie ."'," ;
                              
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
            responsive: true,
            scales: {
              x: {
                stacked: false,
              },
              y: {
                stacked: true
              }
            },
            indexAxis: 'y',
          },
        
      };
      const tectec_alta = new Chart(
        document.getElementById('graficos_tecnicos_alta'),
        config_tec_alta
      );
    </script>
  <?php } ?>
</body>
</html>