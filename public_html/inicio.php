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
		switch ($tipo_us)
		{
      case 'Administrador': header('Location: ./inicio_administrador.php');
			break;
			case 'Despacho': header('Location: ./inicio_despacho.php');
			break;
			case 'Supervisor': header('Location: ./inicio_supervisor.php');
			break;
			case 'Deposito': header('Location: ./inicio_deposito.php');
			break;
			case 'Tecnico': header('Location: ./tecnico/index.php');
			break;
			case '': header('Location: ./index.php');
			break;
    }


  include('includes/header.php');

$mes = date ('y-m', strtotime('-0 month'));
if(isset($_POST['meses']))
{
	$mes1 = $_POST['mes'];
	$mes = "20" .date ('y-m', strtotime($mes1));
}
?>

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

<!-- TOTAL ALTAS-->
<?php $query= "SELECT SUM(tcumplida) as 'todocum' FROM produccion WHERE fecha like '%$mes%'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todocum= $row['todocum'];}?>
<!-- TOTAL ALTAS-->

<!-- DOS Y TRES PLAY-->
<?php $query= "SELECT SUM(dosplay + tresplay) as 'dosytres' FROM produccion WHERE fecha like '%$mes%'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$dosytres= $row['dosytres'];}?>
<!-- DOS Y TRES PLAY-->

<!-- DOS Y TRES PLAY SUR-->
<?php $querysur= "SELECT SUM(dosplay + tresplay) as 'dosytressursur' FROM produccion WHERE fecha like '%$mes%' AND zona = 'Lomas de Zamora'"; 
$result_taskssur = mysqli_query($conn, $querysur);
while($row = mysqli_fetch_assoc($result_taskssur)) { 
$dosytressursur= $row['dosytressursur'];}?>

<?php $querysannicolas= "SELECT SUM(dosplay + tresplay) as 'dosytressannicolas' FROM produccion WHERE fecha like '%$mes%' AND zona = 'San Nicolas'"; 
$result_taskssannicolas = mysqli_query($conn, $querysannicolas);
while($row = mysqli_fetch_assoc($result_taskssannicolas)) { 
$dosytressannicolas= $row['dosytressannicolas'];}?>
<!-- DOS Y TRES PLAY SUR-->

<!-- DOS Y TRES PLAY NORTE-->
<?php $querynorte= "SELECT SUM(dosplay + tresplay) as 'dosytresnorte' FROM produccion WHERE fecha like '%$mes%' AND zona = 'Jose Leon Suarez'"; 
$result_tasksnorte = mysqli_query($conn, $querynorte);
while($row = mysqli_fetch_assoc($result_tasksnorte)) { 
$dosytresnorte= $row['dosytresnorte'];}?>
<!-- DOS Y TRES PLAY NORTE-->

<!-- SET TO BOX-->
<?php $query= "SELECT SUM(tcumplida) as 'cumplitec', tecnico FROM produccion WHERE fecha like '%$mes%' GROUP BY tecnico ORDER BY cumplitec asc"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$teccum= $row['tecnico'];
$cumplitec= $row['cumplitec'];}?>
<!-- SET TO BOX-->

<!-- TOTAL BAJAS-->
<?php $query= "SELECT SUM(bajas) as 'todobaja' FROM produccion WHERE fecha like '%$mes%'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todobaja= $row['todobaja'];}?>
<!-- TOTAL BAJAS-->

<!-- TOTAL BAJAS SUR-->
<?php $querysur= "SELECT SUM(bajas) as 'todobajasursur' FROM produccion WHERE fecha like '%$mes%' AND zona = 'Lomas de Zamora'"; 
$result_taskssur = mysqli_query($conn, $querysur);
while($row = mysqli_fetch_assoc($result_taskssur)) { 
$todobajasursur= $row['todobajasursur'];}?>

<?php $querysannicolas= "SELECT SUM(bajas) as 'todobajasannicolas' FROM produccion WHERE fecha like '%$mes%' AND zona = 'San Nicolas'"; 
$result_taskssannicolas = mysqli_query($conn, $querysannicolas);
while($row = mysqli_fetch_assoc($result_taskssannicolas)) { 
$todobajasannicolas= $row['todobajasannicolas'];}?>
<!-- TOTAL BAJAS SUR-->

<!-- TOTAL BAJAS NORTE-->
<?php $querynorte= "SELECT SUM(bajas) as 'todobajanorte' FROM produccion WHERE fecha like '%$mes%' AND zona = 'Jose Leon Suarez'"; 
$result_tasksnorte = mysqli_query($conn, $querynorte);
while($row = mysqli_fetch_assoc($result_tasksnorte)) { 
$todobajanorte= $row['todobajanorte'];}?>
<!-- TOTAL BAJAS NORTE-->

<!-- TOP BAJAS Y CANTIDAD -->
<?php $query= "SELECT count(ot) as 'cantidad', motivo FROM bajas  WHERE calendario like '%$mes%' GROUP BY motivo ORDER BY cantidad asc"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$topmotivo= $row['motivo'];
$cantidad= $row['cantidad'];}?>
<!-- TOP BAJAS Y CANTIDAD -->

<!-- TOP BAJAS POR TECNICO-->
<?php $query= "SELECT SUM(bajas) as 'cantidadtec', tecnico FROM produccion  WHERE fecha like '%$mes%' GROUP BY tecnico ORDER BY cantidadtec asc"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$bajatecnico= $row['tecnico'];
$cantidadtec= $row['cantidadtec'];}?>
<!-- TOP BAJAS POR TECNICO-->

<!-- TOTAL GARANTIAS-->
<?php $query= "SELECT COUNT(tecnico) as 'todogar' FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> 'Tecnicos...'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$totalgar=$row['todogar'];} ?>
<!-- TOTAL GARANTIAS-->

<!-- TOTAL GARANTIAS SUR-->
<?php $query= "SELECT COUNT(tecnico) as 'todogarsursur' FROM garantias WHERE fecharep like '%$mes%' AND zona = 'Lomas de Zamora' AND tecrep <> 'Tecnicos...'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$totalgarsursur=$row['todogarsursur'];} ?>

<?php $query= "SELECT COUNT(tecnico) as 'todogarsannicolas' FROM garantias WHERE fecharep like '%$mes%' AND zona = 'San Nicolas' AND tecrep <> 'Tecnicos...'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$totalgarsannicolas=$row['todogarsannicolas'];} ?>
<!-- TOTAL GARANTIAS SUR-->

<!-- TOTAL GARANTIAS Norte-->
<?php $query= "SELECT COUNT(tecnico) as 'todogarnorte' FROM garantias WHERE fecharep like '%$mes%' AND zona = 'Jose Leon Suarez' AND tecrep <> 'Tecnicos...'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$totalgarnorte=$row['todogarnorte'];} ?>
<!-- TOTAL GARANTIAS Norte-->

<!-- TOP GARANTIAS JUSTIFICADAS -->
<?php $query= "SELECT count(fecha) as 'fechfech' FROM produccion  WHERE fecha like '%$mes%' GROUP BY tecnico"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$fechfech= $row['fechfech'];}	?>

<?php $query= "SELECT count(*) as 'justifi' FROM garantias  WHERE fecharep like '%$mes%' and justificado = 'SI' AND tecrep <> 'Tecnicos...' ORDER BY fecharep asc LIMIT $fechfech";
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$justi= $row['justifi'];}?>

<?php $query= "SELECT * FROM garantias  WHERE fecharep like '%$mes%' and justificado = 'SI' AND tecrep <> 'Tecnicos...' GROUP BY fecharep ORDER BY fecharep asc LIMIT $fechfech";
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_array($result_tasks)) { 
}?>
<!-- TOP GARANTIAS JUSTIFICADAS -->

<!-- TOP GARANTIAS POR TECNICO-->
<?php $query= "SELECT count(*) as 'cantidadgar',tecnico FROM garantias  WHERE fecharep like '%$mes%' AND tecrep <> 'Tecnicos...' GROUP BY tecnico ORDER BY cantidadgar asc"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$gartecnico= $row['tecnico'];
$cantidadgar= $row['cantidadgar'];}?>
<!-- TOP GARANTIAS POR TECNICO-->

<!-- TOTAL MANTENIMIENTO-------------------------------------------------------------------------------->
<?php $querty_mto= "SELECT SUM(mtto_int + mtto_ext) as 'todomtto' FROM produccion WHERE fecha like '%$mes%'"; 
$result_mtto = mysqli_query($conn, $querty_mto);
while($row = mysqli_fetch_assoc($result_mtto)) { 
$totalmtto=$row['todomtto'];} ?>
<!-- TOTAL MANTENIMIENTO-------------------------------------------------------------------------------->

<!-- MANTENIMIENTO EXTERNA ----------------------------------------------------------------------------->
<?php $querty_mto_ext= "SELECT SUM(mtto_ext) as 'todomtto_ext' FROM produccion WHERE fecha like '%$mes%'"; 
$result_mtto_ext = mysqli_query($conn, $querty_mto_ext);
while($row = mysqli_fetch_assoc($result_mtto_ext)) { 
$mtto_externa=$row['todomtto_ext'];} ?>
<!-- MANTENIMIENTO EXTERNA ------------------------------------------------------------------------------>

<!-- MANTENIMIENTO INTERNA------------------------------------------------------------------------------->
<?php $querty_mto_int= "SELECT SUM(mtto_int) as 'todomtto_int' FROM produccion WHERE fecha like '%$mes%'"; 
$result_mtto_int = mysqli_query($conn, $querty_mto_int);
while($row = mysqli_fetch_assoc($result_mtto_int)) { 
$mtto_interna=$row['todomtto_int'];} ?>
<!-- MANTENIMIENTO INTERNA------------------------------------------------------------------------------->

<!-- TOTAL-->
<?php $query= "SELECT SUM(tcumplida + bajas) as 'todototal' FROM produccion WHERE fecha like '%$mes%'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todototal=$row['todototal'];} ?>
<!-- TOTAL-->

<!-- TOTAL SUR-->
<?php $querysur= "SELECT SUM(tcumplida + bajas) as 'todototalsursur' FROM produccion WHERE fecha like '%$mes%' AND zona = 'Lomas de Zamora'"; 
$result_taskssur = mysqli_query($conn, $querysur);
while($row = mysqli_fetch_assoc($result_taskssur)) { 
$todototalsursur=$row['todototalsursur'];} ?>

<?php $query= "SELECT SUM(tcumplida + bajas) as 'todototalsannicolas' FROM produccion WHERE fecha like '%$mes%' AND zona = 'San Nicolas'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todototalsannicolas=$row['todototalsannicolas'];} ?>
<!-- TOTAL SUR-->

<!-- TOTAL NORTE-->
<?php $querynorte= "SELECT SUM(tcumplida + bajas) as 'todototalnorte' FROM produccion WHERE fecha like '%$mes%' AND zona = 'Jose Leon Suarez'"; 
$result_tasksnorte = mysqli_query($conn, $querynorte);
while($row = mysqli_fetch_assoc($result_tasksnorte)) { 
$todototalnorte=$row['todototalnorte'];} ?>
<!-- TOTAL NORTE-->

<!-- TOP BAJAS POR TECNICO-->
<?php $query= "SELECT count(tecnico) as 'canttec', tecnico FROM produccion  WHERE fecha like '%$mes%' GROUP BY fecha"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) {
$canttec= $row['canttec'];}?>
<!-- TOP BAJAS POR TECNICO-->

<!-- CANTIDAD DE DIAS-->
<?php
$query= "SELECT COUNT(distinct fecha) as 'cantfech' FROM produccion WHERE fecha like '%$mes%'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$cantfech= $row['cantfech'];}?>
<!-- CANTIDAD DE DIAS-->

<!---Scoring--->
<?php
$scoring1 = $totalgar*100/$dosytres;
$scoring = bcdiv($scoring1, '1', '2');
?>
<!---Scoring--->



<div class="container-fluid p-4">  <!---- RESUMEN--->
	<div class="row p-2 border border">		
		<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---ALTAS--->
			<div class="card bg-primary">					
				<div class="row">			
					<div class="col ">
						<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $todocum ?></p>				
						<p class="h4 text-light text-left ml-4">Altas</p>	
					</div>
					<div class="col">
						<br>						
						<p class="h1 text-light text-center"><i class="fas fa-angle-double-up"></i></i></p>	
					</div>											
				</div>				
			</div>
			<div class="row p-2"> <!----BOTONES DE INFO------->
				<div class="col-sm-6 col-6 col-md-12 col-xl-6">
					<p>				
						<a class="btn btn-primary text-light">2play y 3play <span class="badge badge-light"><?php echo $dosytres ?></span></a>
					</p>
				</div>
				<div class="col-sm-6 col-6 col-md-12 col-xl-6 align-items-center">
					<p>				
						<a class="btn btn-primary text-light"><?php echo $teccum ." "; ?><span class="badge badge-light"><?php echo $cumplitec ?></span></a>
					</p>
				</div> 
			</div>
		</div>
		<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---MANTENIMIENTO--->
			<div class="card bg-info">					
				<div class="row">			
					<div class="col ">
						<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $totalmtto ?></p>					
						<p class="h4 text-light text-left ml-4">Mtto</p>	
					</div>
					<div class="col">
						<br>						
						<p class="h1 text-light text-center"><i class="fas fa-toolbox"></i></i></i></p>	
					</div>							
				</div>
			</div>
			<div class="row p-2"> <!----BOTONES DE INFO------->
				<div class="col">
					<p>				
						<a class="btn btn-info text-light">Visitas externas <span class="badge badge-light"><?php echo $mtto_externa ?></span></a>
					</p>
				</div>
				<div class="col">
					<p>				
						<a class="btn btn-info text-light">Visitas internas <span class="badge badge-light"><?php echo $mtto_interna ?></span></a>
					</p>
				</div> 
			</div>
		</div>
		<div class="col-12 col-md-3 col-sm-6 align-items-center"><!---BAJAS--->
			<div class="card bg-danger">					
				<div class="row">			
					<div class="col ">
						<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $todobaja ?></p>
						<p class="h4 text-light text-left ml-4">Bajas</p>	
					</div>
					<div class="col">
						<br>						
						<p class="h1 text-light text-center"><i class="fas fa-angle-double-down"></i></i></p>	
					</div>							
				</div>
			</div>
			<div class="row p-2"> <!----BOTONES DE INFO------->
				<div class="col">
					<p>				
						<a class="btn btn-danger text-light"><?php echo $topmotivo ." "; ?><span class="badge badge-light"><?php echo $cantidad ?></span></a>
					</p>
				</div>
				<div class="col">
					<p>				
						<a class="btn btn-danger text-light"><?php echo $bajatecnico ." "; ?><span class="badge badge-light"><?php echo $cantidadtec ?></span></a>
					</p>
				</div> 
			</div>
		</div>
		<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---GARANTIAS--->
			<div class="card bg-warning">					
				<div class="row">			
					<div class="col ">
						<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $totalgar ?></p>					
						<p class="h4 text-light text-left ml-4">Garantias</p>	
					</div>
					<div class="col">
						<br>						
						<p class="h1 text-light text-center"><i class="fas fa-sync-alt"></i></i></i></p>	
					</div>							
				</div>
			</div>
			<div class="row p-2"> <!----BOTONES DE INFO------->
				<div class="col">
					<p>				
						<a class="btn btn-warning text-light">Visitas justificadas <span class="badge badge-light"><?php echo $justi ?></span></a>
					</p>
				</div>
				<div class="col">
					<p>				
						<a class="btn btn-warning text-light"><?php echo $gartecnico ." "; ?><span class="badge badge-light"><?php echo $cantidadgar ?></span></a>
					</p>
				</div> 
			</div>
		</div>
		<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---LOMAS DE ZAMORA--->
			<div class="card bg-success">					
				<div class="row">			
					<div class="col ">
						<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $todototalsursur ?></p>					
						<p class="h4 text-light text-left ml-4">Lomas de Zamora</p>	
					</div>
					<div class="col">
						<br>						
						<p class="h1 text-light text-center"><i class="fas fa-sync-alt"></i></i></i></p>	
					</div>							
				</div>
			</div>
			<div class="row p-2"> <!----BOTONES DE INFO------->
				<div class="col">
					<p>				
						<a class="btn btn-success text-light">2p y 3p <span class="badge badge-light"><?php echo $dosytressursur ?></span></a>
					</p>
				</div>
				<div class="col">
					<p>				
						<a class="btn btn-success text-light">Garantias <span class="badge badge-light"><?php echo $totalgarsursur ?></span></a>
					</p>
				</div>
				<div class="col">
					<p>				
						<a class="btn btn-success text-light">Bajas <span class="badge badge-light"><?php echo $todobajasursur ?></span></a>
					</p>
				</div> 
			</div>
		</div>
		<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---JOSE LEON SUAREZ--->
			<div class="card bg-success">					
				<div class="row">			
					<div class="col ">
						<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $todototalnorte ?></p>					
						<p class="h4 text-light text-left ml-4">Jose Leon Suarez</p>	
					</div>
					<div class="col">
						<br>						
						<p class="h1 text-light text-center"><i class="fas fa-sync-alt"></i></i></i></p>	
					</div>							
				</div>
			</div>
			<div class="row p-2"> <!----BOTONES DE INFO------->
				<div class="col">
					<p>				
						<a class="btn btn-success text-light">2p y 3p <span class="badge badge-light"><?php echo $dosytresnorte ?></span></a>
					</p>
				</div>
				<div class="col">
					<p>				
						<a class="btn btn-success text-light">Garantias <span class="badge badge-light"><?php echo $totalgarnorte ?></span></a>
					</p>
				</div>
				<div class="col">
					<p>				
						<a class="btn btn-success text-light">Bajas <span class="badge badge-light"><?php echo $todobajanorte ?></span></a>
					</p>
				</div> 
			</div>
		</div>
    <div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---San Nicolas--->
			<div class="card bg-success">					
				<div class="row">			
					<div class="col ">
						<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $todototalsannicolas ?></p>					
						<p class="h4 text-light text-left ml-4">San Nicolas</p>	
					</div>
					<div class="col">
						<br>						
						<p class="h1 text-light text-center"><i class="fas fa-sync-alt"></i></i></i></p>	
					</div>							
				</div>
			</div>
			<div class="row p-2"> <!----BOTONES DE INFO------->
				<div class="col">
					<p>				
						<a class="btn btn-success text-light">2p y 3p <span class="badge badge-light"><?php echo $dosytressannicolas ?></span></a>
					</p>
				</div>
				<div class="col">
					<p>				
						<a class="btn btn-success text-light">Garantias <span class="badge badge-light"><?php echo $totalgarsannicolas ?></span></a>
					</p>
				</div>
				<div class="col">
					<p>				
						<a class="btn btn-success text-light">Bajas <span class="badge badge-light"><?php echo $todobajasannicolas ?></span></a>
					</p>
				</div> 
			</div>
		</div>
		<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---TOTAL--->
			<div class="card bg-dark">					
				<div class="row">			
					<div class="col ">
						<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $todototal ?></p>
						<p class="h4 text-light text-left ml-4">Visitas</p>	
					</div>
					<div class="col">
						<br>						
						<p class="h1 text-light text-center"><i class="fas fa-layer-group"></i></i></i></i></p>	
					</div>							
				</div>
			</div>
			<div class="row p-2"> <!----BOTONES DE INFO------->
				<div class="col">
					<p>				
						<a class="btn btn-dark text-light">Scoring <span class="badge badge-light"><?php echo $scoring ?>%</span></a>
					</p>
				</div>
				<div class="col">
					<p>				
						<a class="btn btn-dark text-light">Dias trabajados <span class="badge badge-light"><?php echo $cantfech ?></span></a>
					</p>
				</div> 
			</div>
		</div>
	</div>
</div>

<!-- BOTON DESPLEGABLE-->

<div class="container-fluid p-4 border">
	<div class="row justify-content-center p-2">		
		<p><a class="btn btn-primary mt-4" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Ver tablas</a></p>		
	</div>
	<div class="row justify-content-center p-1">
		<div class="col">			
			<div class="collapse multi-collapse" id="multiCollapseExample1">
        <div class="row justify-content-center p-1">
					<div class="col-12 col-md-3 col-sm-6 order-1 order-md-1 order-sm-1">
							<div class="card card-body border-info">
                <div class="container-fluid">
                  <div class="container p-2">
                    <div class="row justify-content-center">
                      <div class="col-auto p-2 text-center">
                        <p class="h4 mb-6 text-center">Altas por tecnico</p>
                        <table class="table table-bordered table-responsive table-striped table-sm">
                          <thead class="thead-dark text-center">
                            <tr>          
                            <th>Tecnico</th>
                            <th>Cant</th>         
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $query = "SELECT SUM(tcumplida) as 'cumplitec', tecnico FROM produccion WHERE fecha like '%$mes%' GROUP BY tecnico ORDER BY cumplitec desc";
                            $result_tasks = mysqli_query($conn, $query);  
                            while($row = mysqli_fetch_assoc($result_tasks)) { ?>
                            <tr>                       
                            <td><?php echo $row['tecnico']; ?></td>
                            <td align="center"><?php echo $row['cumplitec']; ?></td>
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
					<div class="col-12 col-md-6 col-sm-12 order-md-2 order-sm-3 order-2">
						<div class="card border border-danger">
							<div class="row">
								<div class="col-sm-6 col-md-6 d-none d-sm-block d-md-block d-lg-block">
										<div class="card card-body  border-0">
                      <div class="container-fluid">
                        <div class="container p-2">
                          <div class="row justify-content-center">
                            <div class="col-auto p-2 text-center">
                              <p class="h4 mb-6 text-center">Bajas por motivo</p>
                              <table class="table table-bordered table-responsive table-striped table-sm table-6">
                                <thead class="thead-dark text-center">
                                  <tr>          
                                  <th>Motivo</th>
                                  <th>Cant</th>         
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $query = "SELECT count(ot) as 'cantidad', motivo FROM bajas  WHERE calendario like '%$mes%' GROUP BY motivo ORDER BY cantidad desc";
                                  $result_tasks = mysqli_query($conn, $query);  
                                  while($row = mysqli_fetch_assoc($result_tasks)) { ?>
                                  <tr>                       
                                  <td><?php echo $row['motivo']; ?></td>
                                  <td align="center"><?php echo $row['cantidad']; ?></td>
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
								<div class="col-12 col-sm-6 col-md-6 d-block d-sm-block d-md-block d-lg-block">
										<div class="card card-body border-0">
                      <div class="container-fluid">
                        <div class="container p-2">
                          <div class="row justify-content-center">
                            <div class="col-auto p-2 text-center">
                              <p class="h4 mb-6 text-center">Bajas por tecnico</p>
                              <table class="table table-bordered table-responsive table-striped table-sm table-6">
                                <thead class="thead-dark text-center">
                                  <tr>          
                                  <th>Tecnico</th>
                                  <th>Cant</th>         
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $query = "SELECT SUM(bajas) as 'cantidadtec', tecnico FROM produccion  WHERE fecha like '%$mes%' GROUP BY tecnico ORDER BY cantidadtec desc";
                                  $result_tasks = mysqli_query($conn, $query);  
                                  while($row = mysqli_fetch_assoc($result_tasks)) { ?>
                                  <tr>                       
                                  <td><?php echo $row['tecnico']; ?></td>
                                  <td align="center"><?php echo $row['cantidadtec']; ?></td>
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
						</div>
					</div>
					<div class="col-12 col-sm-6 col-md-3 order-md-3 order-sm-2 order-3">
							<div class="card card-body  border-warning">
                <div class="container-fluid">
                  <div class="container p-2">
                    <div class="row justify-content-center">
                      <div class="col-auto p-2 text-center">
                        <p class="h4 mb-6 text-center">Garantias por tecnico</p>
                        <table class="table table-bordered table-responsive table-striped table-sm">
                          <thead class="thead-dark text-center">
                            <tr>          
                            <th>Tecnico</th>
                            <th>Cant</th>         
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $query = "SELECT COUNT(tecrep) as 'cantidadgar', tecnico, tecrep FROM garantias  WHERE fecharep like '%$mes%' AND tecrep <> 'Tecnicos...' GROUP BY tecnico ORDER BY cantidadgar desc";
                            $result_tasks = mysqli_query($conn, $query);  
                            while($row = mysqli_fetch_assoc($result_tasks)) { ?>
                            <tr>                       
                            <td><?php echo $row['tecnico']; ?></td>
                            <td align="center"><?php echo $row['cantidadgar']; ?></td>
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
			</div>
		</div>
	</div>
</div>
<!-- BOTON DESPLEGABLE-->

<!--- GRAFICO TODOS LOS TECNICOS---->

<div class="container-fluid p-4 d-md-block d-lg-block">
	<div class="row p-2">
		<div class="col-12 border p-2">			
			<figure class="highcharts-figure">
        <div id="container">    	
        </div>
        <p class="highcharts-description">			       
        </p>
			</figure>			
		</div>		
	</div>
</div>


<!--- GRAFICO TODOS LOS TECNICOS---->

<div class="container">
	<div class="row">
		<div class="col">
			<div class="card card-body">
				<form action="../inicio.php" method="POST">
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






<!-- PIE DE PAGINA -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- then Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


<!-- Calendario 1-->
<script src="../jquery-3.3.1.min.js"></script>
<script src="../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript">
	$(function() {
		$("#fechaint").datepicker({ dateFormat: "yy-mm-dd"});
		$( "#anim" ).on( "change", function() {
			$( "#fechaint" ).datepicker( "option", "showAnim", $( this ).val() );
		});
	} );
</script>
<!-- Calendario 2-->
<script src="../jquery-3.3.1.min.js"></script>
<script src="../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript">
	$(function() {
		$("#fecharep").datepicker({ dateFormat: "yy-mm-dd"});
		$( "#anim" ).on( "change", function() {
			$( "#fecharep" ).datepicker( "option", "showAnim", $( this ).val() );
		});
	} );
</script>



<!-- Grafico 1-->
<script src="HC/code/highcharts.js"></script>
<script src="HC/code/modules/heatmap.js"></script>
<script src="HC/code/modules/series-label.js"></script>
<script src="HC/code/modules/exporting.js"></script>
<script src="HC/code/modules/export-data.js"></script>
<script src="HC/code/modules/accessibility.js"></script>
<script type="text/javascript">
Highcharts.chart('container', {

    title: {
        text: 'Tareas'
    },

    subtitle: {
        text: 'Tipos de tareas dividido por dia'
    },

    yAxis: {
        title: {
            text: 'Total de tareas'
        }
    },

    xAxis: {
        categories:
        [
	    <?php
			$query= "SELECT * FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha"; 
			$result_tasks = mysqli_query($conn, $query);
			while($row = mysqli_fetch_array($result_tasks)){
			$bb = $row['fecha'];
            $tomorrow = date('d-m', strtotime("$bb"));
			
			?>
			 '<?php echo $tomorrow; ?>',
			<?php
			}
			?>
        ]
    },

    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
            
        }
    },

    series: [
    {
        name: 'Tareas cumplidas',
        data:
        [
	        <?php 
			$query1= "SELECT SUM(tcumplida) as totcum FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha";
			$result_tasks1 = mysqli_query($conn, $query1);
			while($row1 = mysqli_fetch_array($result_tasks1))
			{
			?>
			 <?php echo $row1['totcum']; ?>,
			<?php
			}
			?>
        ]
    },
    {
        name: 'Bajas',
        data:
        [
	        <?php 
			$query1= "SELECT SUM(bajas) as totbajas FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha";
			$result_tasks1 = mysqli_query($conn, $query1);
			while($row1 = mysqli_fetch_array($result_tasks1))
			{
			?>
			 <?php echo $row1['totbajas']; ?>,
			<?php
			}
			?>
        ]
    },
    {
        name: 'Garantias',
        data:
        [
	        <?php 
			$query1= "SELECT SUM(garantec) as totgarantias FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha";
			$result_tasks1 = mysqli_query($conn, $query1);
			while($row1 = mysqli_fetch_array($result_tasks1))
			{
			?>
			 <?php echo $row1['totgarantias']; ?>,
			<?php
			}
			?>
        ]
    },
    {
        name: 'Doble play',
        data:
        [
	        <?php 
			$query1= "SELECT SUM(dosplay) as dosdos FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha";
			$result_tasks1 = mysqli_query($conn, $query1);
			while($row1 = mysqli_fetch_array($result_tasks1))
			{
			?>
			 <?php echo $row1['dosdos']; ?>,
			<?php
			}
			?>
        ]
    },
    {
        name: 'Triple play',
        data:
        [
	        <?php 
			$query1= "SELECT SUM(tresplay) as trestres FROM produccion WHERE fecha like '%$mes%' GROUP BY fecha";
			$result_tasks1 = mysqli_query($conn, $query1);
			while($row1 = mysqli_fetch_array($result_tasks1))
			{
			?>
			 <?php echo $row1['trestres']; ?>,
			<?php
			}
			?>
        ]
    }
        ],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});
</script>
<!-- Grafico 1-->
</body>
</html>

