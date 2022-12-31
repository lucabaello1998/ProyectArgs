<?php
  include("../db.php");
  session_start();
  if(!$_SESSION['nombre'])
  {
  session_destroy();
  header("location: ../index.php");
  exit();
  }
  $tipo_us = $_SESSION['tipo_us'];
  if($tipo_us == "Administrador") { $usu = 1; }
  if($tipo_us == "Despacho") { $usu = 1; }
  if($tipo_us == "Supervisor") { $usu = 1; }
  if($tipo_us == "Deposito") { $usu = 1; }
  if($tipo_us == "Visor") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
  }
?>
<?php include('../includes/header.php'); ?>
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
          <input type="hidden" name="link" value="../Basico/garantiasanalisis.php">
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
          <input type="hidden" name="link" value="../Basico/garantiasanalisis.php">
          <button type="submit" name="mas" class="btn btn-outline-light m-2" data-toggle="tooltip" data-placement="bottom" title="Mes siguiente">
            <i class="fa-solid fa-caret-right"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
<!-- FECHA -->
<!-- TOTAL GARANTIAS-->
<?php $query= "SELECT COUNT(tecnico) as 'todogar' FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> 'Tecnicos...'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$totalgar=$row['todogar'];} ?>
<!-- TOTAL GARANTIAS-->

<!-- TOTAL GARANTIAS SIN INTERVENCION-->
<?php $query= "SELECT COUNT(intervencion) as 'sininter' FROM garantias WHERE fecharep like '%$mes%' AND repa='SI' AND intervencion = 'NO' AND tecrep <> 'Tecnicos...'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$sininter=$row['sininter'];} ?>
<!-- TOTAL GARANTIAS SIN INTERVENCION-->

<!-- TOP GARANTIAS JUSTIFICADAS -->
<?php $query= "SELECT count(fecha) as 'fechfech' FROM produccion  WHERE fecha like '%$mes%' GROUP BY tecnico"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$fechfech= $row['fechfech'];}	?>

<?php $query= "SELECT count(*) as 'justifi' FROM garantias  WHERE fecharep like '%$mes%' and justificado = 'SI' AND tecrep <> 'Tecnicos...' ORDER BY fecharep asc LIMIT $fechfech";
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$justi= $row['justifi'];}?>
<!-- TOP GARANTIAS JUSTIFICADAS -->

<!-- TOTAL GARANTIAS NO REALIZADO-->
<?php $query= "SELECT COUNT(repa) as 'reparado' FROM garantias WHERE fecharep like '%$mes%' AND repa = 'NO' AND tecrep <> 'Tecnicos...'"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$reparado=$row['reparado'];} ?>
<!-- TOTAL GARANTIAS NO REALIZADO-->

<!-- TOP GARANTIAS POR TECNICO-->
<?php $query= "SELECT SUM(garantec) as 'cantidadgar', tecnico FROM produccion  WHERE fecha like '%$mes%' AND tecrep <> 'Tecnicos...' GROUP BY tecnico ORDER BY cantidadgar asc"; 
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$gartecnico= $row['tecnico'];
$cantidadgar= $row['cantidadgar'];}?>
<!-- TOP GARANTIAS POR TECNICO-->

<?php
$consulta = "SELECT * FROM garantias WHERE fecharep like '%$mes%' GROUP BY fecharep";
$respuesta = mysqli_query($conn, $consulta);   
while($row = mysqli_fetch_assoc($respuesta)) { 
$fefe  = $row['fecharep'];             
$solofefe = explode("-", $fefe);
$mess = $solofefe[1];
}
?>

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

<div class="container-fluid p-4 d-md-block d-lg-block">
	<div class="row p-2">
		<div class="col-12 border p-2">	
			<ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
			  <li class="nav-item" role="presentation">
			    <a class="nav-link active" id="datos-tab" data-toggle="tab" href="#datos" role="tab" aria-controls="datos" aria-selected="true">Datos</a>
			  </li>
			  <li class="nav-item" role="presentation">
			    <a class="nav-link" id="graficos-tab" data-toggle="tab" href="#graficos" role="tab" aria-controls="graficos" aria-selected="false">Graficos</a>
			  </li>
			</ul>
			<div class="tab-content" id="myTabContent">
			    <div class="tab-pane fade show active" id="datos" role="tabpanel" aria-labelledby="datos-tab">
                 
                
<style>
table{ 
  table-layout: fixed; 
}
.flow{
  overflow-x: auto;
  height: 400px;
  width: 400px;
}
#por_tec{
  min-width: 400px;  
  overflow-x:auto; 
}
</style>
        <div class="container-fluid p-1">
          <div class="row align-items-start justify-content-center p-2">
							<div class="col-lg-6 col-md-4 border-info flow">
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
                    $query = "SELECT COUNT(tecrep) as 'cantidadgar', tecnico, tecrep FROM garantias  WHERE fecharep like '%$mes%' AND tecrep <> 'Tecnicos...' GROUP BY tecnico ORDER BY cantidadgar desc";
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
							<div class="col-lg-6 col-md-6 border-warning flow">
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
                    $query = "SELECT COUNT(coment) as 'cantidadcoment', tecnico, coment FROM garantias  WHERE fecharep like '%$mes%' AND tecrep <> 'Tecnicos...' GROUP BY coment ORDER BY cantidadcoment desc";
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
                    $query = "SELECT COUNT(coment) as 'cantidadcoment', coment FROM garantias  WHERE fecharep like '%$mes%' AND zona='Lomas de Zamora' AND tecrep <> 'Tecnicos...' GROUP BY coment ORDER BY cantidadcoment desc";
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
                    $query = "SELECT COUNT(coment) as 'cantidadcomenta', tecnico, coment FROM garantias  WHERE fecharep like '%$mes%' AND zona='Jose Leon Suarez' AND tecrep <> 'Tecnicos...' GROUP BY coment ORDER BY cantidadcomenta desc";
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
                <?php
                  $query = "SELECT * FROM garantias  WHERE fecharep like '%$mes%' AND zona='CABA' AND tecrep <> 'Tecnicos...' GROUP BY coment ORDER BY cantidadcomenta desc";
                  $result_tasks = mysqli_query($conn, $query);
                  $total_caba =	mysqli_num_rows($result_tasks);
                  if($total_caba == 0){ echo ''; } else {?>
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
                          $query = "SELECT COUNT(coment) as 'cantidadcomenta', tecnico, coment FROM garantias  WHERE fecharep like '%$mes%' AND zona='CABA' AND tecrep <> 'Tecnicos...' GROUP BY coment ORDER BY cantidadcomenta desc";
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
                <?php } ?>
						</div>
					</div>
				</div>
			</div>			  
			  <div class="tab-pane fade" id="graficos" role="tabpanel" aria-labelledby="graficos-tab">
                <div class="tab-pane fade show active" id="datos" role="tabpanel" aria-labelledby="datos-tab">
                    


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

            <div class="container-fluid p-4 d-md-block d-lg-block">
              <div class="row p-2">
                <div class="col-12 border p-2">	
                  <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Jose Leon Suarez</a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Lomas de Zamora</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                          <figure class="highcharts-figure">
                            <div id="individual"></div>
                            <p class="highcharts-description"></p>
                          </figure>
                      </div>			  
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="home-tab">
                            <figure class="highcharts-figure">
                              <div id="individualsur"></div>
                              <p class="highcharts-description"></p>
                            </figure>
                        </div>         
                      </div>
                  </div>
                </div>
              </div>
            </div>

					<!--- GRAFICO ---->

					<div class="container-fluid p-4 d-md-block d-lg-block">
						<div class="row p-2">
							<div class="col-12 border p-2">			
								<figure class="highcharts-figure">
								    <div id="porzona">    	
								    </div>
								    <p class="highcharts-description">			       
								    </p>
								</figure>			
							</div>		
						</div>
					</div>

					<!--- GRAFICO ---->

          </div>
        </div>
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
                $ejecutar=mysqli_query($conn,$consulta) or die (mysqli_error($conn));
                ?>
                <?php foreach ($ejecutar as $opciones): ?>   
                  <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option> 
                   
                <?php endforeach ?>
                              
                      <?php include "../db.php";
                      $consulta="SELECT * FROM tecnicos WHERE tipo='Tecnico' AND activo ='NO' ORDER BY tecnico asc";
                      $ejecutar=mysqli_query($conn,$consulta) or die (mysqli_error($conn));
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
			if (isset($_POST['garan']))
      {
			  $tecgar = $_POST['tecnico'];
			  if($tecgar <> "Todos")
        {
          $query = "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecnico = '$tecgar' ORDER BY fecharep desc";
          $result_tasks = mysqli_query($conn, $query); 
        }
        else
        {
          $query = "SELECT * FROM garantias WHERE fecharep like '%$mes%' ORDER BY fecharep desc";
          $result_tasks = mysqli_query($conn, $query);
        }
      }
      else
      {
        $query = "SELECT * FROM garantias WHERE fecharep like '%$mes%' ORDER BY fecharep desc";
        $result_tasks = mysqli_query($conn, $query);
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

<!-- Grafico 1-->
  <script src="../HC/code/highcharts.js"></script>
  <script src="../HC/code/modules/data.js"></script>
  <script src="../HC/code/modules/drilldown.js"></script>
  <script src="../HC/code/modules/heatmap.js"></script>
  <script src="../HC/code/modules/series-label.js"></script>
  <script src="../HC/code/modules/exporting.js"></script>
  <script src="../HC/code/modules/export-data.js"></script>
  <script src="../HC/code/modules/accessibility.js"></script>
  <script type="text/javascript">
  Highcharts.chart('container', {

      title: {
          text: 'Garantias por zona'
      },

      subtitle: {
          text: 'Dias'
      },

      yAxis: {
          title: {
              text: 'Total de garantias'
          }
      },

      xAxis: {
          categories:
          [
            <?php
        $query= "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> 'Tecnicos...' GROUP BY fecharep"; 
        $result_tasks = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result_tasks)){
        $bb = $row['fecharep'];
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
          name: 'Jose Leon Suarez',
          data:
          [
            <?php 
        $query= "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> 'Tecnicos...' GROUP BY fecharep"; 
        $result_tasks = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result_tasks)){
        $bb = $row['fecharep'];


          $nortedias= "0";

          $query1= "SELECT COUNT(fecharep) as tito FROM garantias WHERE fecharep like '%$bb%' AND zona = 'Jose Leon Suarez'";
          $result_tasks1 = mysqli_query($conn, $query1);
          while($row2 = mysqli_fetch_array($result_tasks1))
          { 
        ?>
        <?php echo $row2['tito'] + $nortedias; ?>,
        <?php
        }}
        ?>
          ]
      },
      {
          name: 'CABA',
          data:
          [
            <?php 
        $query= "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> 'Tecnicos...' GROUP BY fecharep"; 
        $result_tasks = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result_tasks)){
        $bb = $row['fecharep'];


          $cabadias= "0";

          $query1= "SELECT COUNT(fecharep) as toto FROM garantias WHERE fecharep like '%$bb%' AND zona = 'CABA'";
          $result_tasks1 = mysqli_query($conn, $query1);
          while($row2 = mysqli_fetch_array($result_tasks1))
          { 
        ?>
        <?php echo $row2['toto'] + $cabadias; ?>,
        <?php
        }}
        ?>
          ]
      },
      {
          name: 'Lomas de Zamora',
          data:
          [
            <?php 
        $query= "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> 'Tecnicos...' GROUP BY fecharep"; 
        $result_tasks = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result_tasks)){
        $bb = $row['fecharep'];


          $surdias= "0";

          $query1= "SELECT COUNT(fecharep) as toto FROM garantias WHERE fecharep like '%$bb%' AND zona = 'Sur'";
          $result_tasks1 = mysqli_query($conn, $query1);
          while($row2 = mysqli_fetch_array($result_tasks1))
          { 
        ?>
        <?php echo $row2['toto'] + $surdias; ?>,
        <?php
        }}
        ?>
          ]
      },
    
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
<script type="text/javascript">
	// Create the chart
  Highcharts.chart('porzona', {
      chart: {
          type: 'column'
      },
      title: {
          text: 'Garantias por tecnico'
      },
      subtitle: {
          text: 'Haz click en cada columna para ver mas detalles'
      },
      accessibility: {
          announceNewData: {
              enabled: true
          }
      },
      xAxis: {
          type: 'category'
      },
      yAxis: {
          title: {
              text: 'Total de garantias'
          }

      },
      legend: {
          enabled: false
      },
      plotOptions: {
          series: {
              borderWidth: 0,
              dataLabels: {
                  enabled: true,
                  format: '{point.y}'
              }
          }
      },

      tooltip: {
          headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
          pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> del total<br/>'
      },

      series: [
          {
              name: "Tecnicos",
              colorByPoint: true,
              data: [
                  
                
                
                  <?php 
              $quer_graf= "SELECT COUNT(tecnico) as canti, tecnico FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> 'Tecnicos...' GROUP BY tecnico";
              $result_graf = mysqli_query($conn, $quer_graf);
              while($row1 = mysqli_fetch_array($result_graf))
              {
              ?>
                <?php
                echo '{name: "' .$row1['tecnico'] .'",';
                echo 'y:' .$row1['canti'] .','; 		                    
                echo 'drilldown: "' .$row1['tecnico'] .'"},'; ?>
              
              <?php
              }
              ?>
                
              ]
          }
      ],
      drilldown: {
          breadcrumbs: {
              position: {
                  align: 'right'
              }
          },
          series: [
              <?php
              $query= "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> 'Tecnicos...' GROUP BY tecnico"; 
              $result_tasks = mysqli_query($conn, $query);
              while($row = mysqli_fetch_array($result_tasks)){
              $aa = $row['tecnico'];
              echo '{name: "' .$aa .'",';
              echo 'id: "' .$aa .'", data: [';
              
                  $nortedias= "0";
                  $query1= "SELECT COUNT(coment) as tito, tecnico, coment FROM garantias WHERE fecharep like '%$mes%' AND tecnico = '$aa' GROUP BY coment";
                  $result_tasks1 = mysqli_query($conn, $query1);
                  while($row2 = mysqli_fetch_array($result_tasks1))
                  {
                  $cc = $row2['coment'];
              ?>
              <?php echo "["; ?>
              <?php echo '"' .$cc .'",' ; ?>
              <?php echo $row2['tito'] + $nortedias ; ?>
              <?php echo "],"; ?>

              <?php
                      
                  } 
              echo "]},";
              }
              ?>
          ]
      }
  });
</script>

<script type="text/javascript">
    Highcharts.chart('individual', {
  chart: {
    type: 'column'
  },
  title: {
    text: 'Motivos'
  },
  subtitle: {
    text: 'Garantias de Jose Leon Suarez'
  },
  xAxis: {
    type: 'category',
    labels: {
      rotation: -45,
      style: {
        fontSize: '13px',
        fontFamily: 'Verdana, sans-serif'
      }
    }
  },
  yAxis: {
    min: 0,
    title: {
      text: 'Garantias'
    }
  },
  legend: {
    enabled: false
  },
  tooltip: {
    pointFormat: 'Garantias: <b>{point.y}</b>'
  },
  series: [{
    name: 'Jose Leon Suarez',
    data: [
            <?php
              $query_norno= "SELECT *, COUNT(fecharep) as 'motivos' FROM garantias WHERE fecharep like '%$mes%' GROUP BY coment ORDER BY fecharep desc"; 
              $result_nornor = mysqli_query($conn, $query_norno);
              while($row = mysqli_fetch_assoc($result_nornor))
              { 
                $valores = "['" .$row['coment'] ."'," .$row['motivos'] ."],";
              }
              $valoresQ= substr($valores, 0, -1);
              echo $valoresQ;
            ?>
          ],
    dataLabels: {
      enabled: true,
      rotation: -90,
      color: '#FFFFFF',
      align: 'right',
      format: '{point.y:}', // one decimal
      y: 10, // 10 pixels down from the top
      style: {
        fontSize: '13px',
        fontFamily: 'Verdana, sans-serif'
      }
    }
  }]
  });
</script>
<script type="text/javascript">
    Highcharts.chart('individualsur', {
  chart: {
    type: 'column'
  },
  title: {
    text: 'Motivos'
  },
  subtitle: {
    text: 'Garantias de Lomas de Zamora'
  },
  xAxis: {
    type: 'category',
    labels: {
      rotation: -45,
      style: {
        fontSize: '13px',
        fontFamily: 'Verdana, sans-serif'
      }
    }
  },
  yAxis: {
    min: 0,
    title: {
      text: 'Garantias'
    }
  },
  legend: {
    enabled: false
  },
  tooltip: {
    pointFormat: 'Garantias: <b>{point.y}</b>'
  },
  series: [{
    name: 'Lomas de Zamora',
    data: [
            <?php
            $query= "SELECT COUNT(fecharep) as motivos, coment FROM garantias WHERE fecharep like '%$mes%' AND coment <> '' AND tecrep <> 'Tecnicos...' AND zona = 'Lomas de Zamora' OR fecharep like '%$mes%' AND coment <> '' AND tecrep <> 'Tecnicos...' AND zona = 'CABA' GROUP BY coment"; 
            $result_tasks = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result_tasks)){ ?>

                <?php
                echo "['" .$row['coment'] ."'," .$row['motivos'] ."],"; 
                ?>         
            

            <?php
            }
            ?>
    ],
    dataLabels: {
      enabled: true,
      rotation: -90,
      color: '#FFFFFF',
      align: 'right',
      format: '{point.y:}', // one decimal
      y: 10, // 10 pixels down from the top
      style: {
        fontSize: '13px',
        fontFamily: 'Verdana, sans-serif'
      }
    }
  }]
});
</script>
</body>
</html>
