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
	if($tipo == "Administrador") { $usu = 1; }
	if($tipo == "Despacho") { $usu = 1; }
	if($tipo == "Supervisor") { $usu = 1; }
	if($tipo == "Deposito") { $usu = 1; }
	if($tipo == "Visor") { $usu = 1; }
	if($usu != 1)
	{
		header("location: ../index.php");
	}
	include('../includes/header.php'); 

?>
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
        <form action="../Guardar/save_fecha.php" method="POST">
          <input type="hidden" name="ultima_fecha" value="<?php echo $mes; ?>">
					<input type="hidden" name="link" value="../Basico/auditoriasanalisis.php">
          <button type="submit" name="menos" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Mes anterior">
            <i class="fa-solid fa-caret-left"></i>
          </button>
        </form>
      </div>
      <div class="col-auto align-self-center text-center text-white">
        <span class="h4"><?php echo $mes_nom; ?></span>
      </div>
      <div class="col-auto align-self-center p-0">
        <form action="../Guardar/save_fecha.php" method="POST">
          <input type="hidden" name="ultima_fecha" value="<?php echo $mes; ?>">
					<input type="hidden" name="link" value="../Basico/auditoriasanalisis.php">
          <button type="submit" name="mas" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Mes siguiente">
            <i class="fa-solid fa-caret-right"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
<!-- FECHA -->
<!-- TOTAL GARANTIAS-->
<?php $query= "SELECT COUNT(tecnico) as 'todoauto' FROM auditoria WHERE fecha like '%$mes%'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$totalauditorias=$row['todoauto'];} ?>
<!-- TOTAL GARANTIAS-->

<!-- CARLOS -->
<?php $carcar= "SELECT COUNT(tecnico) as 'carlos' FROM auditoria WHERE fecha like '%$mes%' AND supervisor ='Carlos Banega' "; 
$carlitos = mysqli_query($conn, $carcar);
while($row = mysqli_fetch_assoc($carlitos)) { 
$carlos=$row['carlos'];} ?>

<?php $carlonchas= "SELECT * FROM auditoria WHERE fecha like '%$mes%' AND supervisor ='Carlos Banega' order by fecha desc LIMIT 1 "; 
$banega = mysqli_query($conn, $carlonchas);
while($row = mysqli_fetch_assoc($banega)) { 
$ultima_carlos=$row['fecha'];} 

$fechacar  = $ultima_carlos;             
$solofecha = explode("-", $fechacar); // explota el string en " " espacios
$fechacarlos = $solofecha[2] ."-" .$solofecha[1] ;  // asigna un valor por el resultado del explotado
?>
<!-- CARLOS-->


<!-- Elias-->
<?php $EliasElias= "SELECT count(tecnico) as 'Elias' FROM auditoria WHERE fecha like '%$mes%' AND supervisor ='Elias Rosas' ";
$bologno = mysqli_query($conn, $EliasElias);
while($row = mysqli_fetch_assoc($bologno)) { 
$Elias= $row['Elias'];}?>

<?php $Eliassuper= "SELECT * FROM auditoria WHERE fecha like '%$mes%' AND supervisor ='Elias Rosas' order by fecha desc LIMIT 1 "; 
$superElias = mysqli_query($conn, $Eliassuper);
while($row = mysqli_fetch_assoc($superElias)) { 
$ultima_Elias=$row['fecha'];} 

$fecharub  = $ultima_Elias;             
$soloElias = explode("-", $fecharub); // explota el string en " " espacios
$fechaElias = $soloElias[2] ."-" .$soloElias[1] ;  // asigna un valor por el resultado del explotado
?>
<!-- Elias-->


<!-- Gerardo-->
<?php $EliasGerardo= "SELECT count(tecnico) as 'Gerardo' FROM auditoria WHERE fecha like '%$mes%' AND supervisor ='Gerardo Gimenez' ";
$bologno = mysqli_query($conn, $EliasGerardo);
while($row = mysqli_fetch_assoc($bologno)) { 
$Gerardo= $row['Gerardo'];}?>

<?php $Gerardosuper= "SELECT * FROM auditoria WHERE fecha like '%$mes%' AND supervisor ='Gerardo Gimenez' order by fecha desc LIMIT 1 "; 
$superGerardo = mysqli_query($conn, $Gerardosuper);
while($row = mysqli_fetch_assoc($superGerardo)) { 
$ultima_Gerardo=$row['fecha'];} 

$fecharub  = $ultima_Gerardo;             
$soloGerardo = explode("-", $fecharub); // explota el string en " " espacios
$fechaGerardo = $soloGerardo[2] ."-" .$soloGerardo[1] ;  // asigna un valor por el resultado del explotado
?>
<!-- Gerardo-->


<!-- JOSE-->
<?php $consu= "SELECT COUNT(tecnico) as 'jose' FROM auditoria WHERE fecha like '%$mes%' AND supervisor ='Jose Lopez'"; 
$resp = mysqli_query($conn, $consu);
while($row = mysqli_fetch_assoc($resp)) { 
$jose=$row['jose'];} ?>

<?php $concon= "SELECT * FROM auditoria WHERE fecha like '%$mes%' AND supervisor ='Jose Lopez' order by fecha desc LIMIT 1 "; 
$solu = mysqli_query($conn, $concon);
while($row = mysqli_fetch_assoc($solu)) { 
$ultima_jose=$row['fecha'];} 

$fechajos  = $ultima_jose;             
$solojose = explode("-", $fechajos); // explota el string en " " espacios
$fechajose = $solojose[2] ."-" .$solojose[1] ;  // asigna un valor por el resultado del explotado
?>
<!-- JOSE-->

<?php 
			$totcarlos = $carlos * 100 / $totalauditorias;
			$porcentajecarlos = bcdiv($totcarlos, '1', '2');
			$totElias = $Elias * 100 / $totalauditorias;
			$porcentajeElias = bcdiv($totElias, '1', '2');
			$totjose = $jose * 100 / $totalauditorias;
			$porcentajejose = bcdiv($totjose, '1', '2');
      $totGerardo = $Gerardo * 100 / $totalauditorias;
			$porcentajeGerardo = bcdiv($totGerardo, '1', '2');
?>
<!------------------------------------------------------------------------------------------------------------------------------------------>



<!-- TOTAL GARANTIAS-->
<?php $query_ins= "SELECT COUNT(tecnico) as 'todoauto' FROM auditoria_instalaciones WHERE fecha like '%$mes%'"; 
$result_tasks_inst = mysqli_query($conn, $query_ins);
while($row = mysqli_fetch_assoc($result_tasks_inst)) { 
$totalauditoriasinstalaciones=$row['todoauto'];} ?>
<!-- TOTAL GARANTIAS-->

<!-- CARLOS -->
<?php $carcar_ins= "SELECT COUNT(tecnico) as 'carlos' FROM auditoria_instalaciones WHERE fecha like '%$mes%' AND supervisor ='Carlos Banega' "; 
$carlitos_ins = mysqli_query($conn, $carcar_ins);
while($row = mysqli_fetch_assoc($carlitos_ins)) { 
$carlos_ins=$row['carlos'];} ?>

<?php $carlonchas_ins= "SELECT * FROM auditoria_instalaciones WHERE fecha like '%$mes%' AND supervisor ='Carlos Banega' order by fecha desc LIMIT 1 "; 
$banega_ins = mysqli_query($conn, $carlonchas_ins);
while($row = mysqli_fetch_assoc($banega_ins)) { 
$ultima_carlos_ins=$row['fecha'];} 

$fechacar_ins  = $ultima_carlos_ins;             
$solofecha_ins = explode("-", $fechacar_ins); // explota el string en " " espacios
$fechacarlos_ins = $solofecha_ins[2] ."-" .$solofecha_ins[1] ;  // asigna un valor por el resultado del explotado
?>
<!-- CARLOS-->


<!-- Elias-->
<?php $EliasElias_ins= "SELECT count(tecnico) as 'Elias' FROM auditoria_instalaciones WHERE fecha like '%$mes%' AND supervisor ='Elias Rosas' ";
$bologno_ins = mysqli_query($conn, $EliasElias_ins);
while($row = mysqli_fetch_assoc($bologno_ins)) { 
$Elias_ins= $row['Elias'];}?>

<?php $Eliassuper_ins= "SELECT * FROM auditoria_instalaciones WHERE fecha like '%$mes%' AND supervisor ='Elias Rosas' order by fecha desc LIMIT 1 "; 
$superElias_ins = mysqli_query($conn, $Eliassuper_ins);
while($row = mysqli_fetch_assoc($superElias_ins)) { 
$ultima_Elias_ins=$row['fecha'];} 

$fecharub_ins  = $ultima_Elias_ins;             
$soloElias_ins = explode("-", $fecharub_ins); // explota el string en " " espacios
$fechaElias_ins = $soloElias_ins[2] ."-" .$soloElias_ins[1] ;  // asigna un valor por el resultado del explotado
?>
<!-- Elias-->


<!-- GERARDO-->
<?php $EliasGerardo_ins= "SELECT count(tecnico) as 'Gerardo' FROM auditoria_instalaciones WHERE fecha like '%$mes%' AND supervisor ='Gerardo Gimenez' ";
$bologno_ins_G = mysqli_query($conn, $EliasGerardo_ins);
while($row = mysqli_fetch_assoc($bologno_ins_G)) { 
$Gerardo_ins= $row['Gerardo'];}?>

<?php $Gerardosuper_ins= "SELECT * FROM auditoria_instalaciones WHERE fecha like '%$mes%' AND supervisor ='Gerardo Gimenez' order by fecha desc LIMIT 1 "; 
$superGerardo_ins = mysqli_query($conn, $Gerardosuper_ins);
while($row = mysqli_fetch_assoc($superGerardo_ins)) { 
$ultima_Gerardo_ins=$row['fecha'];} 

$fecharub_ins  = $ultima_Gerardo_ins;             
$soloGerardo_ins = explode("-", $fecharub_ins); // explota el string en " " espacios
$fechaGerardo_ins = $soloGerardo_ins[2] ."-" .$soloGerardo_ins[1] ;  // asigna un valor por el resultado del explotado
?>
<!-- GERARDO-->


<!-- JOSE-->
<?php $consu_ins= "SELECT COUNT(tecnico) as 'jose' FROM auditoria_instalaciones WHERE fecha like '%$mes%' AND supervisor ='Jose Lopez'"; 
$resp_ins = mysqli_query($conn, $consu_ins);
while($row = mysqli_fetch_assoc($resp_ins)) { 
$jose_ins=$row['jose'];} ?>

<?php $concon_ins= "SELECT * FROM auditoria_instalaciones WHERE fecha like '%$mes%' AND supervisor ='Jose Lopez' order by fecha desc LIMIT 1 "; 
$solu_ins = mysqli_query($conn, $concon_ins);
while($row = mysqli_fetch_assoc($solu_ins)) { 
$ultima_jose_ins=$row['fecha'];} 

$fechajos_ins  = $ultima_jose_ins;             
$solojose_ins = explode("-", $fechajos_ins); // explota el string en " " espacios
$fechajose_ins = $solojose_ins[2] ."-" .$solojose_ins[1] ;  // asigna un valor por el resultado del explotado
?>
<!-- JOSE-->

<?php
	$totcarlos_ins = $carlos_ins * 100 / $totalauditoriasinstalaciones;
	$porcentajecarlos_ins = bcdiv($totcarlos_ins, '1', '2');
	$totElias_inst = $Elias_ins * 100 / $totalauditoriasinstalaciones;
	$porcentajeElias_ins = bcdiv($totElias_inst, '1', '2');
	$totjose_ins = $jose_ins * 100 / $totalauditoriasinstalaciones;
	$porcentajejose_ins = bcdiv($totjose_ins, '1', '2');
	$totGerardo_ins = $Gerardo_ins * 100 / $totalauditoriasinstalaciones;
	$porcentajeGerardo_ins = bcdiv($totGerardo_ins, '1', '2');
?>
<!------------------------------------------------------------------------------------------------------------------------------------------>



<!-- TOTAL GARANTIAS-->
<?php $query_veh= "SELECT COUNT(tecnico) as 'todoauto' FROM auditoria_vehiculo WHERE fecha like '%$mes%'"; 
$result_tasks_veh = mysqli_query($conn, $query_veh);
while($row = mysqli_fetch_assoc($result_tasks_veh)) { 
$totalauditoriavehiculos=$row['todoauto'];} ?>
<!-- TOTAL GARANTIAS-->

<!-- CARLOS -->
<?php $carcar_veh= "SELECT COUNT(tecnico) as 'carlos' FROM auditoria_vehiculo WHERE fecha like '%$mes%' AND supervisor ='Carlos Banega' "; 
$carlitos_veh = mysqli_query($conn, $carcar_veh);
while($row = mysqli_fetch_assoc($carlitos_veh)) { 
$carlos_veh=$row['carlos'];} ?>

<?php $carlonchas_veh= "SELECT * FROM auditoria_vehiculo WHERE fecha like '%$mes%' AND supervisor ='Carlos Banega' order by fecha desc LIMIT 1 "; 
$banega_veh = mysqli_query($conn, $carlonchas_veh);
while($row = mysqli_fetch_assoc($banega_veh)) { 
$ultima_carlos_veh=$row['fecha'];} 

$fechacar_veh  = $ultima_carlos_veh;             
$solofecha_veh = explode("-", $fechacar_veh); // explota el string en " " espacios
$fechacarlos_veh = $solofecha_veh[2] ."-" .$solofecha_veh[1] ;  // asigna un valor por el resultado del explotado
?>
<!-- CARLOS-->


<!-- Elias-->
<?php $EliasElias_veh= "SELECT count(tecnico) as 'Elias' FROM auditoria_vehiculo WHERE fecha like '%$mes%' AND supervisor ='Elias Rosas' ";
$bologno_veh = mysqli_query($conn, $EliasElias_veh);
while($row = mysqli_fetch_assoc($bologno_veh)) { 
$Elias_veh= $row['Elias'];}?>

<?php $Eliassuper_veh= "SELECT * FROM auditoria_vehiculo WHERE fecha like '%$mes%' AND supervisor ='Elias Rosas' order by fecha desc LIMIT 1 "; 
$superElias_veh = mysqli_query($conn, $Eliassuper_veh);
while($row = mysqli_fetch_assoc($superElias_veh)) { 
$ultima_Elias_veh=$row['fecha'];} 

$fecharub_veh  = $ultima_Elias_veh;             
$soloElias_veh = explode("-", $fecharub_veh); // explota el string en " " espacios
$fechaElias_veh = $soloElias_veh[2] ."-" .$soloElias_veh[1] ;  // asigna un valor por el resultado del explotado
?>
<!-- Elias-->


<!-- gerardo-->
<?php $EliasGerardo_veh= "SELECT count(tecnico) as 'Gerardo' FROM auditoria_vehiculo WHERE fecha like '%$mes%' AND supervisor ='Gerardo Gimenez' ";
$bologno_veh_G = mysqli_query($conn, $EliasGerardo_veh);
while($row = mysqli_fetch_assoc($bologno_veh_G)) { 
$Gerardo_veh= $row['Gerardo'];}?>

<?php $Gerardosuper_veh= "SELECT * FROM auditoria_vehiculo WHERE fecha like '%$mes%' AND supervisor ='Gerardo Gimenez' order by fecha desc LIMIT 1 "; 
$superGerardo_veh = mysqli_query($conn, $Gerardosuper_veh);
while($row = mysqli_fetch_assoc($superGerardo_veh)) { 
$ultima_Gerardo_veh=$row['fecha'];} 

$fecharub_veh  = $ultima_Gerardo_veh;             
$soloGerardo_veh = explode("-", $fecharub_veh); // explota el string en " " espacios
$fechaGerardo_veh = $soloGerardo_veh[2] ."-" .$soloGerardo_veh[1] ;  // asigna un valor por el resultado del explotado
?>
<!-- gerardo-->


<!-- JOSE-->
<?php $consu_veh= "SELECT COUNT(tecnico) as 'jose' FROM auditoria_vehiculo WHERE fecha like '%$mes%' AND supervisor ='Jose Lopez'"; 
$resp_veh = mysqli_query($conn, $consu_veh);
while($row = mysqli_fetch_assoc($resp_veh)) { 
$jose_veh=$row['jose'];} ?>

<?php $concon_veh= "SELECT * FROM auditoria_vehiculo WHERE fecha like '%$mes%' AND supervisor ='Jose Lopez' order by fecha desc LIMIT 1 "; 
$solu_veh = mysqli_query($conn, $concon_veh);
while($row = mysqli_fetch_assoc($solu_veh)) { 
$ultima_jose_veh=$row['fecha'];} 

$fechajos_veh  = $ultima_jose_veh;             
$solojose_veh = explode("-", $fechajos_veh); // explota el string en " " espacios
$fechajose_veh = $solojose_veh[2] ."-" .$solojose_veh[1] ;  // asigna un valor por el resultado del explotado
?>
<!-- JOSE-->

<?php
	$totcarlos_veh = $carlos_veh * 100 / $totalauditoriavehiculos;
	$porcentajecarlos_veh = bcdiv($totcarlos_veh, '1', '2');
	$totElias_veh = $Elias_veh * 100 / $totalauditoriavehiculos;
	$porcentajeElias_veh = bcdiv($totElias_veh, '1', '2');
	$totjose_veh = $jose_veh * 100 / $totalauditoriavehiculos;
	$porcentajejose_veh = bcdiv($totjose_veh, '1', '2');
	$totGerardo_veh = $Gerardo_veh * 100 / $totalauditoriavehiculos;
	$porcentajeGerardo_veh = bcdiv($totGerardo_veh, '1', '2');
?>
<!----------------------------------------------------------------------------------------------------------------------------------------------------->
<?php
	$todojunto = $totalauditoriavehiculos + $totalauditoriasinstalaciones + $totalauditorias;
	$todocarlos = $carlos + $carlos_ins + $carlos_veh;
	$todoElias = $Elias + $Elias_ins + $Elias_veh;
	$todojose = $jose + $jose_ins + $jose_veh;
	$todoGerardo = $Gerardo + $Gerardo_ins + $Gerardo_veh;
?>

<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

			<div class="row p-2 border border">		
				<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---TOTAL--->			
					<div class="card text-center bg-success">	
					<div class=" card-header h4 text-light font-weight-bold text-center">
							Total
						</div>				
						<div class="row">			
							<div class="col">
								<p class="h2 card-text text-light font-weight-bold"><?php echo $todojunto ?></p>				
							</div>
							<div class="col">
								<br>						
								<p class="h1 text-light text-center"><i class="fas fa-layer-group"></i></i></p>	
							</div>											
						</div>				
					</div>			
				</div>
				<div class="col-12 col-md-3 col-sm-6 align-items-center"><!---SIN INTERVENCION--->
					<div class="card bg-info">
						<div class=" card-header h4 text-light font-weight-bold text-center">
							Carlos
						</div>					
						<div class="row">			
							<div class="col ">
								<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $todocarlos ?></p>						
							</div>
							<div class="col">
								<br>						
								<p class="h1 text-light text-center"><i class="fas fa-exclamation"></i></i></i></p>	
							</div>							
						</div>
					</div>
				</div>
				<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---JUSTIFICADAS--->
					<div class="card bg-warning">
					<div class=" card-header h4 text-light font-weight-bold text-center">
							Elias
						</div>					
						<div class="row">			
							<div class="col ">
								<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $todoElias ?></p>					
									
							</div>
							<div class="col">
								<br>						
								<p class="h1 text-light text-center"><i class="fas fa-exchange-alt"></i></i></i></i></p>	
							</div>							
						</div>
					</div>
				</div>
				<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---JUSTIFICADAS--->
					<div class="card bg-primary">
					<div class=" card-header h4 text-light font-weight-bold text-center">
							Gerardo
						</div>					
						<div class="row">			
							<div class="col ">
								<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $todoGerardo ?></p>					
									
							</div>
							<div class="col">
								<br>						
								<p class="h1 text-light text-center"><i class="fas fa-exchange-alt"></i></i></i></i></p>	
							</div>							
						</div>
					</div>
				</div>
				<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---NO REALIZADAS--->
					<div class="card bg-danger">
						<div class=" card-header h4 text-light font-weight-bold text-center">
							Jose
						</div>					
						<div class="row">			
							<div class="col ">
								<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $todojose ?></p>							
							</div>
							<div class="col">
								<br>						
								<p class="h1 text-light text-center"><i class="fas fa-times"></i></i></i></i></i></p>	
							</div>							
						</div>
					</div>
				</div>
			</div>



			<p class="h3 mb-6 text-center">Herramientas</p>
			<div class="row p-2 border border">		
				<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---TOTAL--->			
					<div class="card text-center bg-success">	
					<div class=" card-header h4 text-light font-weight-bold text-center">
							Total
						</div>				
						<div class="row">			
							<div class="col">
								<p class="h2 card-text text-light font-weight-bold"><?php echo $totalauditorias ?></p>				
							</div>
							<div class="col">
								<br>						
								<p class="h1 text-light text-center"><i class="fas fa-layer-group"></i></i></p>	
							</div>											
						</div>				
					</div>			
				</div>
				<div class="col-12 col-md-3 col-sm-6 align-items-center"><!---SIN INTERVENCION--->
					<div class="card bg-info">
						<div class=" card-header h4 text-light font-weight-bold text-center">
							Carlos
						</div>					
						<div class="row">			
							<div class="col ">
								<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $porcentajecarlos ?> %</p>						
							</div>
							<div class="col">
								<br>						
								<p class="h1 text-light text-center"><i class="fas fa-exclamation"></i></i></i></p>	
							</div>							
						</div>
					</div>
					<div class="row p-2"> <!----BOTONES DE INFO------->
						<div class="col-sm-6 col-6 col-md-12 col-xl-6">
							<p>				
								<a class="btn btn-info text-light">Auditorias <span class="badge badge-light"><?php echo $carlos ?></span></a>
							</p>
						</div>
						<div class="col-sm-6 col-6 col-md-12 col-xl-6 align-items-center">
							<p>				
								<a class="btn btn-info text-light">Ultimo <span class="badge badge-light"><?php echo $fechacarlos ?></span></a>
							</p>
						</div> 
					</div>
				</div>
				<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---JUSTIFICADAS--->
					<div class="card bg-warning">
					<div class=" card-header h4 text-light font-weight-bold text-center">
							Elias
						</div>					
						<div class="row">			
							<div class="col ">
								<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $porcentajeElias ?> %</p>					
									
							</div>
							<div class="col">
								<br>						
								<p class="h1 text-light text-center"><i class="fas fa-exchange-alt"></i></i></i></i></p>	
							</div>							
						</div>
					</div>
					<div class="row p-2"> <!----BOTONES DE INFO------->
						<div class="col-sm-6 col-6 col-md-12 col-xl-6">
							<p>				
								<a class="btn btn-warning text-light">Auditorias <span class="badge badge-light"><?php echo $Elias ?></span></a>
							</p>
						</div>
						<div class="col-sm-6 col-6 col-md-12 col-xl-6 align-items-center">
							<p>				
								<a class="btn btn-warning text-light">Ultimo <span class="badge badge-light"><?php echo $fechaElias ?></span></a>
							</p>
						</div> 
					</div>
				</div>
				<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---JUSTIFICADAS--->
					<div class="card bg-primary">
					<div class=" card-header h4 text-light font-weight-bold text-center">
							Gerardo
						</div>					
						<div class="row">			
							<div class="col ">
								<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $porcentajeGerardo ?> %</p>					
									
							</div>
							<div class="col">
								<br>						
								<p class="h1 text-light text-center"><i class="fas fa-exchange-alt"></i></i></i></i></p>	
							</div>							
						</div>
					</div>
					<div class="row p-2"> <!----BOTONES DE INFO------->
						<div class="col-sm-6 col-6 col-md-12 col-xl-6">
							<p>				
								<a class="btn btn-primary text-light">Auditorias <span class="badge badge-light"><?php echo $Gerardo ?></span></a>
							</p>
						</div>
						<div class="col-sm-6 col-6 col-md-12 col-xl-6 align-items-center">
							<p>				
								<a class="btn btn-primary text-light">Ultimo <span class="badge badge-light"><?php echo $fechaGerardo ?></span></a>
							</p>
						</div> 
					</div>
				</div>
				<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---NO REALIZADAS--->
					<div class="card bg-danger">
						<div class=" card-header h4 text-light font-weight-bold text-center">
							Jose
						</div>					
						<div class="row">			
							<div class="col ">
								<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $porcentajejose ?> %</p>							
							</div>
							<div class="col">
								<br>						
								<p class="h1 text-light text-center"><i class="fas fa-times"></i></i></i></i></i></p>	
							</div>							
						</div>
					</div>
					<div class="row p-2"> <!----BOTONES DE INFO------->
						<div class="col-sm-6 col-6 col-md-12 col-xl-6">
							<p>				
								<a class="btn btn-danger text-light">Auditorias <span class="badge badge-light"><?php echo $jose ?></span></a>
							</p>
						</div>
						<div class="col-sm-6 col-6 col-md-12 col-xl-6 align-items-center">
							<p>				
								<a class="btn btn-danger text-light">Ultimo <span class="badge badge-light"><?php echo $fechajose ?></span></a>
							</p>
						</div> 
					</div>
				</div>
			</div>


			<p class="h3 mb-6 text-center">Instalaciones</p>
			<div class="row p-2 border border">		
				<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---TOTAL--->			
					<div class="card text-center bg-success">	
					<div class=" card-header h4 text-light font-weight-bold text-center">
							Total
						</div>				
						<div class="row">			
							<div class="col">
								<p class="h2 card-text text-light font-weight-bold"><?php echo $totalauditoriasinstalaciones ?></p>				
							</div>
							<div class="col">
								<br>						
								<p class="h1 text-light text-center"><i class="fas fa-layer-group"></i></i></p>	
							</div>											
						</div>				
					</div>			
				</div>
				<div class="col-12 col-md-3 col-sm-6 align-items-center"><!---SIN INTERVENCION--->
					<div class="card bg-info">
						<div class=" card-header h4 text-light font-weight-bold text-center">
							Carlos
						</div>					
						<div class="row">			
							<div class="col ">
								<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $porcentajecarlos_ins ?> %</p>						
							</div>
							<div class="col">
								<br>						
								<p class="h1 text-light text-center"><i class="fas fa-exclamation"></i></i></i></p>	
							</div>							
						</div>
					</div>
					<div class="row p-2"> <!----BOTONES DE INFO------->
						<div class="col-sm-6 col-6 col-md-12 col-xl-6">
							<p>				
								<a class="btn btn-info text-light">Auditorias <span class="badge badge-light"><?php echo $carlos_ins ?></span></a>
							</p>
						</div>
						<div class="col-sm-6 col-6 col-md-12 col-xl-6 align-items-center">
							<p>				
								<a class="btn btn-info text-light">Ultimo <span class="badge badge-light"><?php echo $fechacarlos_ins ?></span></a>
							</p>
						</div> 
					</div>
				</div>
				<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---JUSTIFICADAS--->
					<div class="card bg-warning">
					<div class=" card-header h4 text-light font-weight-bold text-center">
							Elias
						</div>					
						<div class="row">			
							<div class="col ">
								<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $porcentajeElias_ins ?> %</p>					
									
							</div>
							<div class="col">
								<br>						
								<p class="h1 text-light text-center"><i class="fas fa-exchange-alt"></i></i></i></i></p>	
							</div>							
						</div>
					</div>
					<div class="row p-2"> <!----BOTONES DE INFO------->
						<div class="col-sm-6 col-6 col-md-12 col-xl-6">
							<p>				
								<a class="btn btn-warning text-light">Auditorias <span class="badge badge-light"><?php echo $Elias_ins ?></span></a>
							</p>
						</div>
						<div class="col-sm-6 col-6 col-md-12 col-xl-6 align-items-center">
							<p>				
								<a class="btn btn-warning text-light">Ultimo <span class="badge badge-light"><?php echo $fechaElias_ins ?></span></a>
							</p>
						</div> 
					</div>
				</div>
				<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---JUSTIFICADAS--->
					<div class="card bg-primary">
					<div class=" card-header h4 text-light font-weight-bold text-center">
							Gerardo
						</div>					
						<div class="row">			
							<div class="col ">
								<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $porcentajeGerardo_ins ?> %</p>					
									
							</div>
							<div class="col">
								<br>						
								<p class="h1 text-light text-center"><i class="fas fa-exchange-alt"></i></i></i></i></p>	
							</div>							
						</div>
					</div>
					<div class="row p-2"> <!----BOTONES DE INFO------->
						<div class="col-sm-6 col-6 col-md-12 col-xl-6">
							<p>				
								<a class="btn btn-primary text-light">Auditorias <span class="badge badge-light"><?php echo $Gerardo_ins ?></span></a>
							</p>
						</div>
						<div class="col-sm-6 col-6 col-md-12 col-xl-6 align-items-center">
							<p>				
								<a class="btn btn-primary text-light">Ultimo <span class="badge badge-light"><?php echo $fechaGerardo_ins ?></span></a>
							</p>
						</div> 
					</div>
				</div>
				<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---NO REALIZADAS--->
					<div class="card bg-danger">
						<div class=" card-header h4 text-light font-weight-bold text-center">
							Jose
						</div>					
						<div class="row">			
							<div class="col ">
								<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $porcentajejose_ins ?> %</p>							
							</div>
							<div class="col">
								<br>						
								<p class="h1 text-light text-center"><i class="fas fa-times"></i></i></i></i></i></p>	
							</div>							
						</div>
					</div>
					<div class="row p-2"> <!----BOTONES DE INFO------->
						<div class="col-sm-6 col-6 col-md-12 col-xl-6">
							<p>				
								<a class="btn btn-danger text-light">Auditorias <span class="badge badge-light"><?php echo $jose_ins ?></span></a>
							</p>
						</div>
						<div class="col-sm-6 col-6 col-md-12 col-xl-6 align-items-center">
							<p>				
								<a class="btn btn-danger text-light">Ultimo <span class="badge badge-light"><?php echo $fechajose_ins ?></span></a>
							</p>
						</div> 
					</div>
				</div>
			</div>

			<p class="h3 mb-6 text-center">Vehiculos</p>
			<div class="row p-2 border border">		
				<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---TOTAL--->			
					<div class="card text-center bg-success">	
					<div class=" card-header h4 text-light font-weight-bold text-center">
							Total
						</div>				
						<div class="row">			
							<div class="col">
								<p class="h2 card-text text-light font-weight-bold"><?php echo $totalauditoriavehiculos ?></p>				
							</div>
							<div class="col">
								<br>						
								<p class="h1 text-light text-center"><i class="fas fa-layer-group"></i></i></p>	
							</div>											
						</div>				
					</div>			
				</div>
				<div class="col-12 col-md-3 col-sm-6 align-items-center"><!---SIN INTERVENCION--->
					<div class="card bg-info">
						<div class=" card-header h4 text-light font-weight-bold text-center">
							Carlos
						</div>					
						<div class="row">			
							<div class="col ">
								<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $porcentajecarlos_veh ?> %</p>						
							</div>
							<div class="col">
								<br>						
								<p class="h1 text-light text-center"><i class="fas fa-exclamation"></i></i></i></p>	
							</div>							
						</div>
					</div>
					<div class="row p-2"> <!----BOTONES DE INFO------->
						<div class="col-sm-6 col-6 col-md-12 col-xl-6">
							<p>				
								<a class="btn btn-info text-light">Auditorias <span class="badge badge-light"><?php echo $carlos_veh ?></span></a>
							</p>
						</div>
						<div class="col-sm-6 col-6 col-md-12 col-xl-6 align-items-center">
							<p>				
								<a class="btn btn-info text-light">Ultimo <span class="badge badge-light"><?php echo $fechacarlos_veh ?></span></a>
							</p>
						</div> 
					</div>
				</div>
				<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---JUSTIFICADAS--->
					<div class="card bg-warning">
					<div class=" card-header h4 text-light font-weight-bold text-center">
							Elias
						</div>					
						<div class="row">			
							<div class="col ">
								<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $porcentajeElias_veh ?> %</p>					
									
							</div>
							<div class="col">
								<br>						
								<p class="h1 text-light text-center"><i class="fas fa-exchange-alt"></i></i></i></i></p>	
							</div>							
						</div>
					</div>
					<div class="row p-2"> <!----BOTONES DE INFO------->
						<div class="col-sm-6 col-6 col-md-12 col-xl-6">
							<p>				
								<a class="btn btn-warning text-light">Auditorias <span class="badge badge-light"><?php echo $Elias_veh ?></span></a>
							</p>
						</div>
						<div class="col-sm-6 col-6 col-md-12 col-xl-6 align-items-center">
							<p>				
								<a class="btn btn-warning text-light">Ultimo <span class="badge badge-light"><?php echo $fechaElias_veh ?></span></a>
							</p>
						</div> 
					</div>
				</div>
				<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---JUSTIFICADAS--->
					<div class="card bg-primary">
					<div class=" card-header h4 text-light font-weight-bold text-center">
							Gerardo
						</div>					
						<div class="row">			
							<div class="col ">
								<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $porcentajeGerardo_veh ?> %</p>					
									
							</div>
							<div class="col">
								<br>						
								<p class="h1 text-light text-center"><i class="fas fa-exchange-alt"></i></i></i></i></p>	
							</div>							
						</div>
					</div>
					<div class="row p-2"> <!----BOTONES DE INFO------->
						<div class="col-sm-6 col-6 col-md-12 col-xl-6">
							<p>				
								<a class="btn btn-primary text-light">Auditorias <span class="badge badge-light"><?php echo $Gerardo_veh ?></span></a>
							</p>
						</div>
						<div class="col-sm-6 col-6 col-md-12 col-xl-6 align-items-center">
							<p>				
								<a class="btn btn-primary text-light">Ultimo <span class="badge badge-light"><?php echo $fechaGerardo_veh ?></span></a>
							</p>
						</div> 
					</div>
				</div>
				<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---NO REALIZADAS--->
					<div class="card bg-danger">
						<div class=" card-header h4 text-light font-weight-bold text-center">
							Jose
						</div>					
						<div class="row">			
							<div class="col ">
								<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $porcentajejose_veh ?> %</p>							
							</div>
							<div class="col">
								<br>						
								<p class="h1 text-light text-center"><i class="fas fa-times"></i></i></i></i></i></p>	
							</div>							
						</div>
					</div>
					<div class="row p-2"> <!----BOTONES DE INFO------->
						<div class="col-sm-6 col-6 col-md-12 col-xl-6">
							<p>				
								<a class="btn btn-danger text-light">Auditorias <span class="badge badge-light"><?php echo $jose_veh ?></span></a>
							</p>
						</div>
						<div class="col-sm-6 col-6 col-md-12 col-xl-6 align-items-center">
							<p>				
								<a class="btn btn-danger text-light">Ultimo <span class="badge badge-light"><?php echo $fechajose_veh ?></span></a>
							</p>
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
</body>
</html>