<?php include("../db.php"); ?>
<!-----Visor---->
<?php
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
?>
<!-----Visor---->
<?php include('../includes/header.php'); 

$mes = date ('y-m', strtotime('-0 month'));
if(isset($_POST['meses']))
{
  $mes1 = $_POST['mes'];
  $mes = "20" .date ('y-m', strtotime($mes1));
}



?>

<!-- TOTAL GARANTIAS-->
<?php $query= "SELECT COUNT(tecnico) as 'todogar' FROM garantias WHERE fecharep like '%$mes%'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$totalgar=$row['todogar'];} ?>
<!-- TOTAL GARANTIAS-->

<!-- TOTAL GARANTIAS SIN INTERVENCION-->
<?php $query= "SELECT COUNT(intervencion) as 'sininter' FROM garantias WHERE fecharep like '%$mes%' AND repa='SI' AND intervencion = 'NO'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$sininter=$row['sininter'];} ?>
<!-- TOTAL GARANTIAS SIN INTERVENCION-->

<!-- TOP GARANTIAS JUSTIFICADAS -->
<?php $query= "SELECT count(fecha) as 'fechfech' FROM produccion  WHERE fecha like '%$mes%' GROUP BY tecnico"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$fechfech= $row['fechfech'];}	?>

<?php $query= "SELECT count(*) as 'justifi' FROM garantias  WHERE fecharep like '%$mes%' and justificado = 'SI' ORDER BY fecharep asc LIMIT $fechfech";
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$justi= $row['justifi'];}?>
<!-- TOP GARANTIAS JUSTIFICADAS -->

<!-- TOTAL GARANTIAS NO REALIZADO-->
<?php $query= "SELECT COUNT(repa) as 'reparado' FROM garantias WHERE fecharep like '%$mes%' AND repa = 'NO'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$reparado=$row['reparado'];} ?>
<!-- TOTAL GARANTIAS NO REALIZADO-->

<!-- TOP GARANTIAS POR TECNICO-->
<?php $query= "SELECT SUM(garantec) as 'cantidadgar', tecnico FROM produccion  WHERE fecha like '%$mes%' GROUP BY tecnico ORDER BY cantidadgar asc"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$gartecnico= $row['tecnico'];
$cantidadgar= $row['cantidadgar'];}?>
<!-- TOP GARANTIAS POR TECNICO-->


<p class="h2 mb-6 text-center">Garantias de <?php switch ($mes)
{
case '2021-12': echo "Diciembre";
break;
case '2021-11': echo "Noviembre";
break;
case '2021-10': echo "Octubre";
break;
case '2021-09': echo "Septiembre";
break;
case '2021-08': echo "Agosto";
break;
case '2021-07': echo "Julio";
break;
case '2021-06': echo "Junio";
break;
case '2021-05': echo "Mayo";
break;
case '2021-04': echo "Abril";
break;
case '2021-03': echo "Marzo";
break;
case '2021-02': echo "Febrero";
break;
case '2021-01': echo "Enero";
break;
} ?></p>
<br>

<div class="container-fluid p-4">  <!---- RESUMEN--->
	<div class="row p-2 border border">		
		<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---TOTAL--->			
			<div class="card text-center bg-success">	
			 <div class=" card-header text-light font-weight-bold text-center">
			    Total
			  </div>				
				<div class="row">			
					<div class="col">
						<p class="h2 card-text text-light font-weight-bold"><?php echo $totalgar ?></p>				
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
			<div class=" card-header text-light font-weight-bold text-center">
			    Sin intervencion
			  </div>					
				<div class="row">			
					<div class="col ">
						<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $sininter ?></p>
						
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
			<div class=" card-header text-light font-weight-bold text-center">
			    Justificadas
			  </div>					
				<div class="row">			
					<div class="col ">
						<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $justi ?></p>					
							
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
			<div class=" card-header text-light font-weight-bold text-center">
			    No realizadas
			  </div>					
				<div class="row">			
					<div class="col ">
						<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $reparado ?></p>
							
					</div>
					<div class="col">
						<br>						
						<p class="h1 text-light text-center"><i class="fas fa-times"></i></i></i></i></i></p>	
					</div>							
				</div>
			</div>
		</div>
	</div>
</div>



<div class="container-fluid p-1 ">
	<div class="row align-items-start justify-content-center p-2">
		<div class="col-lg-6 col-md-4 border-info ">
		<p class="h4 mb-6 text-center">Garantias por tecnico</p>
		<table class="table table-bordered table-striped table-sm">
			<thead class="thead-dark text-center">
				<tr>          
				<th>Tecnicos</th>
				<th>Cantidades</th>         
				</tr>
			</thead>
			<tbody align="center">
				<?php
				$query = "SELECT SUM(garantec) as 'cantidadgar', tecnico FROM produccion  WHERE fecha like '%$mes%' GROUP BY tecnico ORDER BY cantidadgar desc";
				$result_tasks = mysqli_query($conn, $query);  
				while($row = mysqli_fetch_assoc($result_tasks)) { ?>
				<tr>                       
				<td><?php echo $row['tecnico']; ?></td>
				<td><?php echo $row['cantidadgar']; ?></td>
				</tr>        
			<?php } ?>
			</tbody>
		</table>  
		</div>
		<div class="col-lg-6 col-md-6 border-warning">
		<p class="h4 mb-6 text-center">Garantias por motivo</p>
		<table class="table table-bordered table-striped table-sm">
			<thead class="thead-dark text-center">
				<tr>          
				<th>Motivos</th>
				<th>Cantidades</th>         
				</tr>
			</thead>
			<tbody align="center">
				<?php
				$query = "SELECT COUNT(coment) as 'cantidadcoment', tecnico, coment FROM garantias  WHERE fecharep like '%$mes%' GROUP BY coment ORDER BY cantidadcoment desc";
				$result_tasks = mysqli_query($conn, $query);  
				while($row = mysqli_fetch_assoc($result_tasks)) { ?>
				<tr>                       
				<td><?php echo $row['coment']; ?></td>
				<td><?php echo $row['cantidadcoment']; ?></td>
				</tr>        
			<?php } ?>
			</tbody>
		</table>  
		</div>
		<div class="row align-items-start justify-content-center p-2">
		<div class="col-lg-4 col-md-4 border-info">
		<p class="h4 mb-6 text-center">Garantias Lomas de Zamora</p>
		<table class="table table-bordered table-striped table-sm">
			<thead class="thead-dark text-center">
				<tr>          
				<th>Motivo</th>
				<th>Cantidades</th>         
				</tr>
			</thead>
			<tbody align="center">
				<?php
				$query = "SELECT COUNT(coment) as 'cantidadcoment', coment FROM garantias  WHERE fecharep like '%$mes%' AND zona='Lomas de Zamora' GROUP BY coment ORDER BY cantidadcoment desc";
				$result_tasks = mysqli_query($conn, $query);  
				while($row = mysqli_fetch_assoc($result_tasks)) { ?>
				<tr>                       
				<td><?php echo $row['coment']; ?></td>
				<td><?php echo $row['cantidadcoment']; ?></td>
				</tr>        
			<?php } ?>
			</tbody>
		</table>  
		</div>
		<div class="col-lg-4 col-md-6 border-warning">
		<p class="h4 mb-6 text-center">Garantias Jose Leon Suarez</p>
		<table class="table table-bordered table-striped table-sm">
			<thead class="thead-dark text-center">
				<tr>          
				<th>Motivos</th>
				<th>Cantidades</th>         
				</tr>
			</thead>
			<tbody align="center">
				<?php
				$query = "SELECT COUNT(coment) as 'cantidadcomenta', tecnico, coment FROM garantias  WHERE fecharep like '%$mes%' AND zona='Jose Leon Suarez' GROUP BY coment ORDER BY cantidadcomenta desc";
				$result_tasks = mysqli_query($conn, $query);  
				while($row = mysqli_fetch_assoc($result_tasks)) { ?>
				<tr>                       
				<td><?php echo $row['coment']; ?></td>
				<td><?php echo $row['cantidadcomenta']; ?></td>
				</tr>        
			<?php } ?>
			</tbody>
		</table>  
		</div>
		<div class="col-lg-4 col-md-6 border-warning">
		<p class="h4 mb-6 text-center">Garantias CABA</p>
		<table class="table table-bordered table-striped table-sm">
			<thead class="thead-dark text-center">
				<tr>          
				<th>Motivos</th>
				<th>Cantidades</th>         
				</tr>
			</thead>
			<tbody align="center">
				<?php
				$query = "SELECT COUNT(coment) as 'cantidadcomenta', tecnico, coment FROM garantias  WHERE fecharep like '%$mes%' AND zona='CABA' GROUP BY coment ORDER BY cantidadcomenta desc";
				$result_tasks = mysqli_query($conn, $query);  
				while($row = mysqli_fetch_assoc($result_tasks)) { ?>
				<tr>                       
				<td><?php echo $row['coment']; ?></td>
				<td><?php echo $row['cantidadcomenta']; ?></td>
				</tr>        
			<?php } ?>
			</tbody>
		</table>  
		</div>
	</div>
	</div>
</div>

<br>

<main class="container p-2">
  <div class="row">
    <div class="col-lg">
      <!-- ADD TASK FORM -->
      <div class="card card-body">
        <form method="POST">
          <p class="h4 mb-4 text-center">Garantias</p>
          <div class="row">
            <div class="col">
          <select type="text" name="tecnico" class="form-control">                
                <option selected="0">Tecnicos...</option>   
                <option class="text-primary" value="Todos">Todos</option>             
                <?php include "../db.php";
                $consulta="SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc";
                $ejecutar=mysqli_query($conn,$consulta) or die (mysql_error($conn));
                ?>
                <?php foreach ($ejecutar as $opciones): ?>   
                  <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option> 
                   
                <?php endforeach ?>
                              
                      <?php include "../db.php";
                      $consulta="SELECT * FROM tecnicos WHERE tipo='Tecnico' AND activo ='NO' ORDER BY tecnico asc";
                      $ejecutar=mysqli_query($conn,$consulta) or die (mysql_error($conn));
                      ?>
                      <?php foreach ($ejecutar as $opciones): ?>   
                        <option class="text-danger" value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>
                      <?php endforeach ?>                      
              </select>  
          </div>
          <div class="col">          
          <input type="submit" name="garan" class="btn btn-success btn-block" value="Cargar tecnico">
          </div>
          </div>  
        </form>
      </div>
    </div>
  </div>
</main>



<!-- TABLA GARANTIAS-->


<div class="container-fluid p-2 p-md-5 p-sm-3">
  <div class="row align-items-start justify-content-center">
    <div class="col-12">
      <p class="h4 mb-4 text-center">Garantias cargadas</p>
      
      <table class="table table-responsive table-striped table-bordered table-sm">
        <thead class="thead-dark text-center">
          <tr>
            
            <th class="col-auto">Tecnico</th>
            <th class="col-auto">OT</th>
            <th class="col-auto">Direccion</th>
            <th class="col-auto">Zona</th>
            <th class="col-auto">Fecha instalacion</th>
            <th class="col-auto">Fecha reparacion</th>
            <th class="col-auto">Tecnico que reparo</th>
            <th class="col-auto">Comentarios</th>
            <th class="col-auto">Reparado</th>
            <th class="col-auto">Justificado</th>
            <th class="col-auto">Intervencion</th>
            <th class="col-auto">Observaciones</th>
          </tr>
        </thead>
        <tbody align="center">
          <?php
			if (isset($_POST['garan'])) {
			  $tecgar = $_POST['tecnico'];
			  if($tecgar <> "Todos"){
      		$query = "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecnico = '$tecgar' ORDER BY fecharep desc";
          	$result_tasks = mysqli_query($conn, $query); }
          	else
          	{
      		$query = "SELECT * FROM garantias WHERE fecharep like '%$mes%' ORDER BY fecharep desc";
          	$result_tasks = mysqli_query($conn, $query);
          	}

          }

          while($row = mysqli_fetch_assoc($result_tasks)) { ?>
            <tr>              
              <td><?php echo $row['tecnico']; ?></td>
              <td><?php echo $row['ot']; ?></td>
              <td><?php echo $row['direccion']; ?></td>
              <td><?php echo $row['zona']; ?></td>
              <td><?php echo $row['fechaint']; ?></td>
              <td><?php echo $row['fecharep']; ?></td>
              <td><?php echo $row['tecrep']; ?></td>
              <td><?php echo $row['coment']; ?></td>
              <td><?php echo $row['repa']; ?></td>
              <td><?php echo $row['justificado']; ?></td>
              <td><?php echo $row['intervencion']; ?></td>
              <td><?php echo $row['obs']; ?></td>           
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>




<div class="container">
  <div class="row">
    <div class="col">
      <div class="card card-body">
        <form action="../Basico/garantiasanalisis.php" method="POST">
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
</body>
</html>